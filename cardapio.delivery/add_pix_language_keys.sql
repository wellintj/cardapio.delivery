-- Add missing language keys for the modern PIX payment interface
INSERT IGNORE INTO language_data (keyword, data, english)
VALUES 
    ('paste', 'Colar', 'Paste');

-- Update existing keys if needed
UPDATE language_data SET 
    data = 'Escaneie o QR code ou copie o código abaixo',
    english = 'Scan the QR code or copy the code below'
WHERE keyword = 'scan_qr_code_or_copy_the_code_below';
