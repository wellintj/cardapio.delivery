-- Database migration to add Brazilian delivery payment methods support
-- Add delivery_payment_method field to order_user_list table

ALTER TABLE `order_user_list` 
ADD COLUMN `delivery_payment_method` VARCHAR(50) DEFAULT NULL COMMENT 'Delivery payment method: cash, credit_card, debit_card, pix' 
AFTER `change_amount`;

-- Add language keys for the new delivery payment options
INSERT IGNORE INTO `language_data` (`keyword`, `data`, `english`) VALUES
('delivery_payment_method', 'Forma de pagamento na entrega', 'Delivery payment method'),
('cash_on_delivery', 'Dinheiro na entrega', 'Cash on delivery'),
('credit_card_on_delivery', 'Cartão de crédito na entrega', 'Credit card on delivery'),
('debit_card_on_delivery', 'Cartão de débito na entrega', 'Debit card on delivery'),
('pix_on_delivery', 'PIX na entrega', 'PIX on delivery'),
('select_delivery_payment', 'Selecione a forma de pagamento na entrega', 'Select delivery payment method'),
('payment_terminal_delivery', 'Maquininha será levada pelo entregador', 'Payment terminal will be brought by delivery person'),
('change_for_amount', 'Troco para quanto?', 'Change for how much?');
