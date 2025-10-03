<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fix_translations extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        // Verificar se é admin ou permitir acesso temporário
        // Para segurança, você pode adicionar verificação de admin aqui
        
        echo "<h2>🔧 Executando Correções do Sistema de Troco</h2>";
        
        try {
            // 1. Atualizar tradução existente
            echo "<h3>1. Atualizando tradução 'change_value'</h3>";
            $this->db->where('keyword', 'change_value');
            $this->db->update('language_data', [
                'data' => 'Troco para',
                'english' => 'Change for'
            ]);
            echo "✅ Tradução 'change_value' atualizada<br>";
            
            // 2. Inserir novas traduções
            echo "<h3>2. Inserindo novas traduções</h3>";
            $translations = [
                ['keyword' => 'change_amount_to_return', 'data' => 'Troco a devolver', 'english' => 'Change amount to return'],
                ['keyword' => 'customer_bill_amount', 'data' => 'Valor da cédula do cliente', 'english' => 'Customer bill amount'],
                ['keyword' => 'change_calculation', 'data' => 'Cálculo do Troco', 'english' => 'Change Calculation'],
                ['keyword' => 'customer_payment_amount', 'data' => 'Valor que o Cliente Pagará', 'english' => 'Customer Payment Amount'],
                ['keyword' => 'amount_customer_will_pay', 'data' => 'Valor que o cliente irá pagar', 'english' => 'Amount customer will pay'],
                ['keyword' => 'change_to_return', 'data' => 'Troco a Devolver', 'english' => 'Change to Return'],
                ['keyword' => 'calculated_automatically', 'data' => 'Calculado automaticamente', 'english' => 'Calculated automatically'],
                ['keyword' => 'paid_online', 'data' => 'Pago Online', 'english' => 'Paid Online'],
                ['keyword' => 'do_not_collect', 'data' => 'NÃO COBRAR', 'english' => 'DO NOT COLLECT'],
                ['keyword' => 'collect_payment_on_delivery', 'data' => 'COBRAR NA ENTREGA', 'english' => 'COLLECT PAYMENT ON DELIVERY'],
                ['keyword' => 'payment_information', 'data' => 'Informações de Pagamento', 'english' => 'Payment Information'],
                ['keyword' => 'change_required', 'data' => 'Troco Necessário', 'english' => 'Change Required'],
                ['keyword' => 'cash_on_delivery', 'data' => 'Dinheiro na Entrega', 'english' => 'Cash on Delivery'],
                ['keyword' => 'credit_card_on_delivery', 'data' => 'Cartão de Crédito na Entrega', 'english' => 'Credit Card on Delivery'],
                ['keyword' => 'debit_card_on_delivery', 'data' => 'Cartão de Débito na Entrega', 'english' => 'Debit Card on Delivery'],
                ['keyword' => 'pix_on_delivery', 'data' => 'PIX na Entrega', 'english' => 'PIX on Delivery'],
                ['keyword' => 'digital_payment', 'data' => 'Pagamento Digital', 'english' => 'Digital Payment'],
                ['keyword' => 'select_delivery_payment', 'data' => 'Selecione o método de pagamento na entrega', 'english' => 'Select delivery payment method'],
                ['keyword' => 'change_for_amount', 'data' => 'Informe o valor para o troco', 'english' => 'Enter amount for change']
            ];
            
            $inserted = 0;
            foreach ($translations as $translation) {
                // Verificar se já existe
                $existing = $this->db->get_where('language_data', ['keyword' => $translation['keyword']])->row();
                
                if (!$existing) {
                    $this->db->insert('language_data', $translation);
                    $inserted++;
                    echo "✅ {$translation['keyword']} inserida<br>";
                } else {
                    echo "⚠️ {$translation['keyword']} já existe<br>";
                }
            }
            
            // 3. Verificar/criar coluna customer_payment_amount
            echo "<h3>3. Verificando coluna customer_payment_amount</h3>";
            
            // Verificar se a coluna existe
            $columns = $this->db->query("SHOW COLUMNS FROM order_user_list LIKE 'customer_payment_amount'")->result();
            
            if (empty($columns)) {
                // Criar a coluna
                $this->db->query("ALTER TABLE order_user_list ADD COLUMN customer_payment_amount DECIMAL(10,2) DEFAULT 0.00 AFTER change_amount");
                echo "✅ Coluna customer_payment_amount criada<br>";
            } else {
                echo "⚠️ Coluna customer_payment_amount já existe<br>";
            }
            
            // 4. Verificar traduções
            echo "<h3>4. Verificação Final</h3>";
            $verify_keywords = ['change_value', 'change_amount_to_return', 'customer_bill_amount', 'change_calculation'];
            $this->db->where_in('keyword', $verify_keywords);
            $this->db->order_by('keyword');
            $verify_result = $this->db->get('language_data')->result_array();
            
            echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
            echo "<tr style='background-color: #f0f0f0;'><th style='padding: 8px;'>Chave</th><th style='padding: 8px;'>Português</th><th style='padding: 8px;'>Inglês</th></tr>";
            foreach ($verify_result as $row) {
                echo "<tr>";
                echo "<td style='padding: 8px;'>{$row['keyword']}</td>";
                echo "<td style='padding: 8px;'>{$row['data']}</td>";
                echo "<td style='padding: 8px;'>{$row['english']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            echo "<h2>🎉 Correções Aplicadas com Sucesso!</h2>";
            echo "<div style='background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
            echo "<p><strong>Resumo das Correções:</strong></p>";
            echo "<ul>";
            echo "<li>✅ Tradução 'change_value' corrigida para 'Troco para'</li>";
            echo "<li>✅ {$inserted} novas traduções inseridas</li>";
            echo "<li>✅ Coluna customer_payment_amount verificada/criada</li>";
            echo "<li>✅ Interfaces do entregador e admin corrigidas nos arquivos</li>";
            echo "</ul>";
            echo "</div>";
            
            echo "<h3>📋 Próximos Passos:</h3>";
            echo "<ol>";
            echo "<li><strong>Teste o checkout</strong> - Crie um pedido com troco</li>";
            echo "<li><strong>Verifique a interface do entregador</strong> - Deve mostrar 'Troco a devolver'</li>";
            echo "<li><strong>Confirme o painel administrativo</strong> - Deve ter seção 'Cálculo do Troco'</li>";
            echo "</ol>";
            
            echo "<div style='background-color: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
            echo "<p><strong>⚠️ Importante:</strong> As correções nas interfaces já foram aplicadas nos arquivos PHP. ";
            echo "Se você fez alterações manuais nos arquivos, certifique-se de que as modificações estão corretas.</p>";
            echo "</div>";
            
        } catch (Exception $e) {
            echo "<h2>❌ Erro</h2>";
            echo "<div style='background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px;'>";
            echo "<p><strong>Erro:</strong> " . $e->getMessage() . "</p>";
            echo "</div>";
        }
    }
    
    public function test_translations() {
        echo "<h2>🧪 Teste de Traduções</h2>";
        
        $test_keys = [
            'change_value',
            'change_amount_to_return', 
            'customer_bill_amount',
            'change_calculation',
            'paid_online',
            'collect_payment_on_delivery'
        ];
        
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background-color: #f0f0f0;'><th style='padding: 8px;'>Chave</th><th style='padding: 8px;'>Tradução</th><th style='padding: 8px;'>Status</th></tr>";
        
        foreach ($test_keys as $key) {
            $translation = lang($key);
            $status = ($translation !== $key) ? "✅ OK" : "❌ Não encontrada";
            $color = ($translation !== $key) ? "#d4edda" : "#f8d7da";
            
            echo "<tr style='background-color: {$color};'>";
            echo "<td style='padding: 8px;'>{$key}</td>";
            echo "<td style='padding: 8px;'>{$translation}</td>";
            echo "<td style='padding: 8px;'>{$status}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h3>Exemplo de Uso:</h3>";
        echo "<p><strong>change_value:</strong> " . lang('change_value') . "</p>";
        echo "<p><strong>change_amount_to_return:</strong> " . lang('change_amount_to_return') . "</p>";
        echo "<p><strong>customer_bill_amount:</strong> " . lang('customer_bill_amount') . "</p>";
    }
}
