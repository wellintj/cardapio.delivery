<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Biblioteca para geração de QR Code estático PIX
 * Baseado nas especificações do Banco Central do Brasil
 */
class Pix {
    
    /**
     * Formata um campo no padrão EMV
     * @param string $id Identificador do campo
     * @param string $valor Valor do campo
     * @return string Campo formatado
     */
    private function formataCampo($id, $valor) {
        return $id . str_pad(strlen($valor), 2, '0', STR_PAD_LEFT) . $valor;
    }
    
    /**
     * Calcula o CRC-16 (CCITT-FALSE)
     * @param string $dados String para cálculo do CRC
     * @return string CRC calculado em formato hexadecimal
     */
    private function calculaCRC16($dados) {
        $resultado = 0xFFFF;
        
        for ($i = 0; $i < strlen($dados); $i++) {
            $resultado ^= (ord($dados[$i]) << 8);
            
            for ($j = 0; $j < 8; $j++) {
                if ($resultado & 0x8000) {
                    $resultado = ($resultado << 1) ^ 0x1021;
                } else {
                    $resultado = $resultado << 1;
                }
                $resultado &= 0xFFFF;
            }
        }
        
        return strtoupper(str_pad(dechex($resultado), 4, '0', STR_PAD_LEFT));
    }
    
    /**
     * Gera o código do PIX (Copia e Cola)
     * 
     * @param string $chave Chave PIX (CPF, CNPJ, telefone, e-mail ou chave aleatória)
     * @param string $nome Nome do destinatário
     * @param string $cidade Cidade do destinatário
     * @param float $valor Valor da transação (0 para permitir qualquer valor)
     * @param string $txid Identificador da transação (opcional)
     * @param string $descricao Descrição da transação (opcional)
     * @return string Código PIX para cópia e cola
     */
    public function geraPix($chave, $nome, $cidade, $valor = 0, $txid = '***', $descricao = '') {
        // Validações básicas
        if (empty($chave)) {
            log_message('error', 'PIX: Chave PIX não informada');
            return '';
        }
        
        if (empty($nome)) {
            $nome = 'Estabelecimento';
            log_message('info', 'PIX: Nome não informado, usando padrão');
        }
        
        if (empty($cidade)) {
            $cidade = 'BRASIL';
            log_message('info', 'PIX: Cidade não informada, usando padrão');
        }
        
        // Inicia o código com payload format indicator
        $resultado = "000201";
        
        // Adiciona dados da conta - Merchant Account Information
        $merchantAccount = "0014br.gov.bcb.pix";
        
        // Adiciona a chave PIX
        $merchantAccount .= $this->formataCampo("01", $chave);
        
        // Adiciona descrição (opcional)
        if (!empty($descricao)) {
            $merchantAccount .= $this->formataCampo("02", $descricao);
        }
        
        $resultado .= $this->formataCampo("26", $merchantAccount);
        
        // Adiciona categoria do comerciante
        $resultado .= "52040000"; // Merchant Category Code
        
        // Adiciona moeda em formato ISO4217 (986 = BRL / Real Brasileiro)
        $resultado .= "5303986";
        
        // Adiciona valor da transação (opcional)
        if ($valor > 0) {
            $resultado .= $this->formataCampo("54", number_format($valor, 2, '.', ''));
        }
        
        // Adiciona país em formato ISO3166-1 (BR = Brasil)
        $resultado .= "5802BR";
        
        // Adiciona nome do destinatário
        $resultado .= $this->formataCampo("59", $nome);
        
        // Adiciona cidade do destinatário
        $resultado .= $this->formataCampo("60", $cidade);
        
        // Adiciona identificador de transação (txid)
        $resultado .= $this->formataCampo("62", $this->formataCampo("05", $txid));
        
        // Adiciona informação de campo fixo para cálculo do CRC16
        $resultado .= "6304";
        
        // Calcula e adiciona o CRC16 do Payload
        $resultado .= $this->calculaCRC16($resultado);
        
        return $resultado;
    }
    
    /**
     * Gera o QR Code PIX em formato base64
     * 
     * @param string $pixCopiaECola Código PIX copia e cola
     * @param int $tamanho Tamanho do QR Code em pixels
     * @return string QR Code em formato base64
     */
    public function geraQrCode($pixCopiaECola, $tamanho = 300) {
        if (empty($pixCopiaECola)) {
            log_message('error', 'PIX: Código PIX vazio ao gerar QR Code');
            return '';
        }
        
        try {
            // Tenta usar a API do Google Charts para gerar o QR Code
            $url = "https://chart.googleapis.com/chart?cht=qr&chs={$tamanho}x{$tamanho}&chl=" . urlencode($pixCopiaECola);
            
            // Configura um timeout para evitar travamentos
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5
                ]
            ]);
            
            // Obtém a imagem e converte para base64
            $imagem = @file_get_contents($url, false, $context);
            
            if ($imagem) {
                return 'data:image/png;base64,' . base64_encode($imagem);
            } else {
                // Fallback para QRServer API
                $url = "https://api.qrserver.com/v1/create-qr-code/?size={$tamanho}x{$tamanho}&data=" . urlencode($pixCopiaECola);
                $imagem = @file_get_contents($url, false, $context);
                
                if ($imagem) {
                    return 'data:image/png;base64,' . base64_encode($imagem);
                } else {
                    log_message('error', 'PIX: Falha ao gerar QR Code com ambas as APIs');
                    return '';
                }
            }
        } catch (Exception $e) {
            log_message('error', 'PIX: Exceção ao gerar QR Code: ' . $e->getMessage());
            return '';
        }
    }
    
    /**
     * Verifica se a biblioteca está funcionando corretamente
     * @return boolean Verdadeiro se tudo estiver funcionando
     */
    public function testarIntegridade() {
        try {
            // Testa se consegue gerar um código PIX
            $pix = $this->geraPix('test@example.com', 'Teste', 'BRASIL', 1.00);
            if (empty($pix)) {
                log_message('error', 'PIX: Falha no teste de geração do código PIX');
                return false;
            }
            
            // Testa se consegue gerar um QR Code
            $qr = $this->geraQrCode($pix);
            if (empty($qr)) {
                log_message('error', 'PIX: Falha no teste de geração do QR Code');
                return false;
            }
            
            return true;
        } catch (Exception $e) {
            log_message('error', 'PIX: Exceção durante teste de integridade: ' . $e->getMessage());
            return false;
        }
    }
} 