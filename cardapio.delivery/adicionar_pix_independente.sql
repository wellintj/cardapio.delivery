-- Adicionar os campos is_pix e pix_status na tabela restaurant_list caso não existam
ALTER TABLE restaurant_list 
    ADD COLUMN IF NOT EXISTS pix_status INT NOT NULL DEFAULT 1 AFTER offline_status,
    ADD COLUMN IF NOT EXISTS is_pix INT NOT NULL DEFAULT 0 AFTER is_offline;

-- Adicionar o PIX como método de pagamento independente na tabela payment_method_list
INSERT INTO payment_method_list (name, slug, active_slug, status_slug, status) 
VALUES ('PIX', 'pix', 'is_pix', 'pix_status', 1) 
ON DUPLICATE KEY UPDATE 
    name = 'PIX', 
    active_slug = 'is_pix', 
    status_slug = 'pix_status';

-- Copiar as configurações do PIX do campo offline_config para pix_config
ALTER TABLE restaurant_list ADD COLUMN IF NOT EXISTS pix_config JSON NULL AFTER offline_config;

-- Criar a tabela pix_config caso não exista
CREATE TABLE IF NOT EXISTS pix_config (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    pix_key VARCHAR(255) NOT NULL,
    city VARCHAR(255) DEFAULT 'BRASIL',
    pix_description VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_restaurant (restaurant_id)
);

-- Adicionar strings de idioma PIX se não existirem
INSERT IGNORE INTO language_data (keyword, data, english)
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
    ('confirm_payment', 'Confirmar Pagamento', 'Confirm Payment'); 