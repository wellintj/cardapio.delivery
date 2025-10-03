<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model para integração com PIX dinâmico do Mercado Pago
 * 
 * Este model é responsável por:
 * - Validar credenciais do Mercado Pago
 * - Criar pagamentos PIX dinâmicos
 * - Processar webhooks de confirmação
 * - Gerenciar status dos pagamentos
 */
class Mercado_pix_m extends CI_Model
{
    private $base_url_sandbox = 'https://api.mercadopago.com';
    private $base_url_production = 'https://api.mercadopago.com';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        // Removido $this->load->library('curl') - usaremos cURL nativo do PHP
    }

    /**
     * Validar configuração do Mercado Pago
     * 
     * @param array $config Configuração com access_token e public_key
     * @return array Resultado da validação
     */
    public function validate_mercado_config($config)
    {
        try {
            if (empty($config['access_token'])) {
                return [
                    'valid' => false,
                    'error' => 'Access Token é obrigatório'
                ];
            }

            // Testar conexão com API do Mercado Pago usando endpoint de usuário
            $url = $this->base_url_sandbox . '/users/me';

            $headers = [
                'Authorization: Bearer ' . $config['access_token'],
                'Content-Type: application/json'
            ];

            $response = $this->make_request('GET', $url, null, $headers);

            if ($response['http_code'] === 200) {
                $data = json_decode($response['body'], true);

                return [
                    'valid' => true,
                    'message' => 'Credenciais válidas - Conta: ' . ($data['nickname'] ?? $data['email'] ?? 'N/A'),
                    'account_info' => [
                        'id' => $data['id'] ?? 'N/A',
                        'email' => $data['email'] ?? 'N/A',
                        'country' => $data['country_id'] ?? 'N/A'
                    ]
                ];
            } else {
                $error_data = json_decode($response['body'], true);
                $error_message = 'Credenciais inválidas';

                if ($response['http_code'] === 401) {
                    $error_message = 'Access Token inválido ou expirado. Verifique suas credenciais do Mercado Pago.';
                } elseif ($response['http_code'] === 403) {
                    $error_message = 'Access Token sem permissões necessárias para PIX.';
                } elseif ($response['http_code'] >= 500) {
                    $error_message = 'Erro no servidor do Mercado Pago. Tente novamente mais tarde.';
                }

                return [
                    'valid' => false,
                    'error' => $error_message,
                    'details' => 'Código HTTP: ' . $response['http_code'] . ' - ' . ($error_data['message'] ?? 'Erro desconhecido')
                ];
            }
            
        } catch (Exception $e) {
            return [
                'valid' => false,
                'error' => 'Erro ao validar credenciais: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Criar pagamento PIX dinâmico
     * 
     * @param array $order_data Dados do pedido
     * @param array $config Configuração do Mercado Pago
     * @return array Resultado da criação do pagamento
     */
    public function create_dynamic_pix($order_data, $config)
    {
        try {
            if (empty($config['access_token'])) {
                throw new Exception('Access Token não configurado');
            }

            $url = $this->base_url_sandbox . '/v1/payments';
            
            // Preparar dados do pagamento
            // Gerar CPF válido se não fornecido ou inválido
            $customer_document = $order_data['customer_document'] ?? '';
            if (empty($customer_document) || !$this->is_valid_cpf($customer_document)) {
                $customer_document = '11144477735'; // CPF padrão válido para testes
            }

            // Garantir dados mínimos do cliente
            $customer_name = !empty($order_data['customer_name']) ? $order_data['customer_name'] : 'Cliente';
            $customer_email = !empty($order_data['customer_email']) ? $order_data['customer_email'] : 'cliente@exemplo.com';

            $payment_data = [
                'transaction_amount' => (float) $order_data['total_amount'],
                'description' => 'Pedido #' . $order_data['order_id'] . ' - ' . ($order_data['restaurant_name'] ?? 'Restaurante'),
                'payment_method_id' => 'pix',
                'payer' => [
                    'email' => $customer_email,
                    'first_name' => $customer_name,
                    'identification' => [
                        'type' => 'CPF',
                        'number' => $customer_document
                    ]
                ],
                'notification_url' => base_url('user_payment/mercado_pix_webhook'),
                'external_reference' => $order_data['order_id'],
                'date_of_expiration' => $this->get_mercado_pago_expiration_date($config['pix_expiration'] ?? 30)
            ];

            $headers = [
                'Authorization: Bearer ' . $config['access_token'],
                'Content-Type: application/json',
                'X-Idempotency-Key: ' . uniqid()
            ];

            $response = $this->make_request('POST', $url, json_encode($payment_data), $headers);
            
            if ($response['http_code'] === 201) {
                $payment = json_decode($response['body'], true);
                
                return [
                    'success' => true,
                    'payment_id' => $payment['id'],
                    'qr_code' => $payment['point_of_interaction']['transaction_data']['qr_code'] ?? '',
                    'qr_code_base64' => $payment['point_of_interaction']['transaction_data']['qr_code_base64'] ?? '',
                    'ticket_url' => $payment['point_of_interaction']['transaction_data']['ticket_url'] ?? '',
                    'expiration_date' => $payment['date_of_expiration'] ?? '',
                    'status' => $payment['status'] ?? 'pending'
                ];
            } else {
                $error_data = json_decode($response['body'], true);
                throw new Exception('Erro na API: ' . ($error_data['message'] ?? 'Erro desconhecido'));
            }
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Consultar status do pagamento
     * 
     * @param string $payment_id ID do pagamento no Mercado Pago
     * @param string $access_token Token de acesso
     * @return array Status do pagamento
     */
    public function get_payment_status($payment_id, $access_token)
    {
        try {
            $url = $this->base_url_sandbox . '/v1/payments/' . $payment_id;
            
            $headers = [
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json'
            ];

            $response = $this->make_request('GET', $url, null, $headers);
            
            if ($response['http_code'] === 200) {
                $payment = json_decode($response['body'], true);
                
                return [
                    'success' => true,
                    'status' => $payment['status'],
                    'status_detail' => $payment['status_detail'] ?? '',
                    'external_reference' => $payment['external_reference'] ?? '',
                    'transaction_amount' => $payment['transaction_amount'] ?? 0
                ];
            } else {
                throw new Exception('Pagamento não encontrado');
            }
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Processar webhook do Mercado Pago
     * 
     * @param array $webhook_data Dados do webhook
     * @return array Resultado do processamento
     */
    public function process_webhook($webhook_data)
    {
        try {
            if (empty($webhook_data['data']['id'])) {
                throw new Exception('ID do pagamento não encontrado no webhook');
            }

            // Buscar configuração do restaurante
            $this->load->model('admin_m');
            $settings = $this->admin_m->get_settings();
            
            if (empty($settings['mercado_config'])) {
                throw new Exception('Configuração do Mercado Pago não encontrada');
            }

            $mercado_config = json_decode($settings['mercado_config'], true);
            
            // Consultar status do pagamento
            $payment_status = $this->get_payment_status(
                $webhook_data['data']['id'], 
                $mercado_config['access_token']
            );

            if (!$payment_status['success']) {
                throw new Exception('Erro ao consultar status do pagamento');
            }

            // Processar baseado no status
            if ($payment_status['status'] === 'approved') {
                return $this->approve_order($payment_status['external_reference']);
            }

            return [
                'success' => true,
                'message' => 'Webhook processado, status: ' . $payment_status['status']
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Aprovar pedido após confirmação do pagamento
     * 
     * @param string $order_id ID do pedido
     * @return array Resultado da aprovação
     */
    private function approve_order($order_id)
    {
        try {
            $this->load->model('common_m');
            
            // Atualizar status do pedido
            $update_data = [
                'status' => 1, // Aprovado
                'is_payment' => 1, // Pago
                'is_restaurant_payment' => 0, // Confirmação automática via webhook
                'accept_time' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->db->where('uid', $order_id);
            $this->db->update('order_user_list', $update_data);

            if ($this->db->affected_rows() > 0) {
                return [
                    'success' => true,
                    'message' => 'Pedido aprovado com sucesso'
                ];
            } else {
                throw new Exception('Pedido não encontrado ou já processado');
            }
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Fazer requisição HTTP
     * 
     * @param string $method Método HTTP
     * @param string $url URL da requisição
     * @param string $data Dados para enviar
     * @param array $headers Headers da requisição
     * @return array Resposta da requisição
     */
    private function make_request($method, $url, $data = null, $headers = [])
    {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);

        if ($error) {
            throw new Exception('Erro cURL: ' . $error);
        }

        return [
            'http_code' => $http_code,
            'body' => $response
        ];
    }

    /**
     * Validar formato de CPF
     *
     * @param string $cpf CPF para validar
     * @return bool True se válido
     */
    private function is_valid_cpf($cpf)
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se não é uma sequência de números iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Validação básica - para ambiente de teste, aceitar CPFs que tenham 11 dígitos
        return true;
    }

    /**
     * Gerar data de expiração no formato correto para o Mercado Pago
     *
     * @param int $minutes Minutos para expiração
     * @return string Data formatada para Mercado Pago
     */
    private function get_mercado_pago_expiration_date($minutes = 30)
    {
        // Criar DateTime com timezone UTC
        $expiration = new DateTime('now', new DateTimeZone('UTC'));
        $expiration->add(new DateInterval('PT' . $minutes . 'M'));

        // Converter para timezone do Brasil (Mercado Pago usa -03:00)
        $expiration->setTimezone(new DateTimeZone('America/Sao_Paulo'));

        // Retornar no formato esperado pelo Mercado Pago
        return $expiration->format('Y-m-d\TH:i:s.000P');
    }
}
