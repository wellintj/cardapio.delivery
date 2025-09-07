-- Fix PIX Payment Expiration Timer
-- Add field to store PIX payment data including expiration timestamp

-- Add column to store PIX payment data in order_user_list table
ALTER TABLE `order_user_list` 
ADD COLUMN `pix_payment_data` JSON NULL COMMENT 'PIX payment data including expiration timestamp, payment_id, etc.' 
AFTER `service_charge`;

-- Add index for better performance when querying PIX payments
ALTER TABLE `order_user_list` 
ADD INDEX `idx_pix_payment` (`pix_payment_data`(255));
