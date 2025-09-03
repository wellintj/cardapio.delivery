-- Update delivery payment language keys for improved UI
-- This script updates existing keys and adds new ones for the simplified checkout interface

-- Update existing language keys
UPDATE `language_data` SET 
    `data` = 'Dinheiro',
    `english` = 'Cash'
WHERE `keyword` = 'cash_on_delivery';

UPDATE `language_data` SET 
    `data` = 'Cartão de crédito',
    `english` = 'Credit card'
WHERE `keyword` = 'credit_card_on_delivery';

UPDATE `language_data` SET 
    `data` = 'Cartão de débito',
    `english` = 'Debit card'
WHERE `keyword` = 'debit_card_on_delivery';

UPDATE `language_data` SET 
    `data` = 'PIX',
    `english` = 'PIX'
WHERE `keyword` = 'pix_on_delivery';

-- Add new language keys for the improved interface
INSERT IGNORE INTO `language_data` (`keyword`, `data`, `english`) VALUES
('general_payment_terminal_info', 'A maquininha será levada pelo entregador', 'Payment terminal will be brought by delivery person'),
('pix_qr_code_info', '(QR-code)', '(QR-code)');

-- Keep existing keys that are still needed
-- 'select_delivery_payment' - "Selecione a forma de pagamento na entrega"
-- 'payment_terminal_delivery' - "Maquininha será levada pelo entregador" (for individual use)
-- 'change_for_amount' - "Troco para quanto?"
