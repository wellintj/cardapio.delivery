-- Adicionar método de pagamento PIX na tabela payment_method_list
INSERT INTO payment_method_list (name, slug, active_slug, status_slug, status) 
VALUES ('PIX', 'pix', 'is_offline', 'offline_status', 1) 
ON DUPLICATE KEY UPDATE 
    name = 'PIX', 
    active_slug = 'is_offline', 
    status_slug = 'offline_status';

-- Adicionar strings de idioma para o PIX em português
INSERT INTO language_data (keyword, data, english)
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
    english = VALUES(english); 