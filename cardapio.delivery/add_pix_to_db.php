<?php
// Requisita o arquivo principal do sistema para ter acesso às configurações do banco de dados
require_once 'application/config/database.php';

// Conecta ao banco de dados
$conn = new mysqli('localhost', 'cardapio.delivery-db-usr', 'haEY5cLdhMEzrm2D', 'cardapio.delivery-db');

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Insere o método PIX na tabela payment_method_list
$sql1 = "INSERT INTO payment_method_list (name, slug, active_slug, status_slug, status) 
         VALUES ('PIX', 'pix', 'is_offline', 'offline_status', 1) 
         ON DUPLICATE KEY UPDATE 
         name = 'PIX', 
         active_slug = 'is_offline', 
         status_slug = 'offline_status'";

if ($conn->query($sql1) === TRUE) {
    echo "Método de pagamento PIX adicionado com sucesso à tabela payment_method_list<br>";
} else {
    echo "Erro ao adicionar método PIX: " . $conn->error . "<br>";
}

// Adiciona as strings de idioma para o PIX
$sql2 = "INSERT INTO language_data (keyword, data, english)
         VALUES 
         ('pix', 'PIX', 'PIX'),
         ('pix_settings', 'Configurações do PIX', 'PIX Settings'),
         ('pix_key', 'Chave PIX', 'PIX Key'),
         ('pix_description', 'Descrição do PIX', 'PIX Description'),
         ('pix_description_help', 'Esta descrição aparecerá no extrato do cliente', 'This description will appear in the customer\'s statement'),
         ('city', 'Cidade', 'City'),
         ('scan_qr_code_or_copy_the_code_below', 'Escaneie o QR code ou copie o código abaixo', 'Scan the QR code or copy the code below'),
         ('copy', 'Copiar', 'Copy'),
         ('code_copied', 'Código copiado!', 'Code copied!'),
         ('after_payment_confirmation_click_below', 'Após confirmar o pagamento, clique no botão abaixo', 'After payment confirmation, click the button below'),
         ('confirm_payment', 'Confirmar Pagamento', 'Confirm Payment')
         ON DUPLICATE KEY UPDATE 
         data = VALUES(data),
         english = VALUES(english)";

if ($conn->query($sql2) === TRUE) {
    echo "Strings de idioma para o PIX adicionadas com sucesso<br>";
} else {
    echo "Erro ao adicionar strings de idioma: " . $conn->error . "<br>";
}

// Fecha a conexão
$conn->close();

echo "Script finalizado!";
?> 