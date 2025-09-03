# Brazilian Delivery Payment Options - Deployment Guide

## Pre-Deployment Checklist

### 1. Backup Current System
- [ ] Backup database
- [ ] Backup modified files:
  - `application/views/layouts/inc/order_info_form.php`
  - `application/views/backend/order/inc/order_details_thumb.php`
  - `application/views/backend/order/inc/orderList_thumb.php`
  - `application/models/Order_m.php`

### 2. Database Migration
Execute the following SQL commands in your database:

```sql
-- Add delivery_payment_method column
ALTER TABLE `order_user_list` 
ADD COLUMN `delivery_payment_method` VARCHAR(50) DEFAULT NULL 
COMMENT 'Delivery payment method: cash, credit_card, debit_card, pix' 
AFTER `change_amount`;

-- Add language keys (adjust table name if different)
INSERT IGNORE INTO `language_data` (`keyword`, `data`, `english`) VALUES
('delivery_payment_method', 'Forma de pagamento na entrega', 'Delivery payment method'),
('cash_on_delivery', 'Dinheiro na entrega', 'Cash on delivery'),
('credit_card_on_delivery', 'Cartão de crédito na entrega', 'Credit card on delivery'),
('debit_card_on_delivery', 'Cartão de débito na entrega', 'Debit card on delivery'),
('pix_on_delivery', 'PIX na entrega', 'PIX on delivery'),
('select_delivery_payment', 'Selecione a forma de pagamento na entrega', 'Select delivery payment method'),
('payment_terminal_delivery', 'Maquininha será levada pelo entregador', 'Payment terminal will be brought by delivery person'),
('change_for_amount', 'Troco para quanto?', 'Change for how much?');
```

### 3. File Verification
Ensure all modified files are in place:
- [ ] `application/views/layouts/inc/order_info_form.php` - Updated with delivery payment options
- [ ] `application/views/backend/order/inc/order_details_thumb.php` - Shows payment method in order details
- [ ] `application/views/backend/order/inc/orderList_thumb.php` - Shows payment info in order list
- [ ] `application/models/Order_m.php` - Handles delivery_payment_method field
- [ ] `imagens_para_checkout/pix-delivery.svg` - PIX payment icon

## Deployment Steps

### Step 1: Database Migration
1. Connect to your database
2. Run the SQL migration script: `database_migration_delivery_payment.sql`
3. Verify the new column exists: `DESCRIBE order_user_list;`

### Step 2: File Deployment
1. Upload all modified files to their respective locations
2. Ensure file permissions are correct (typically 644 for PHP files)
3. Clear any application cache if applicable

### Step 3: Testing
1. Upload `test_delivery_payment.php` to your root directory
2. Access it via browser: `https://yourdomain.com/test_delivery_payment.php?run_tests=1`
3. Verify all tests pass
4. Remove the test file after testing

### Step 4: Functional Testing
1. **Frontend Testing:**
   - Navigate to checkout page
   - Add items to cart for delivery
   - Select "Pay Later" option
   - Verify delivery payment options appear
   - Test each payment method selection
   - For cash, verify change amount field appears

2. **Backend Testing:**
   - Place test orders with different payment methods
   - Check admin panel order details
   - Verify order list shows payment information
   - Test with different order types

## Post-Deployment Verification

### 1. User Experience Flow
```
Customer Journey:
1. Add items to cart
2. Go to checkout
3. Select delivery order type
4. Choose "Pay Later"
5. Select delivery payment method:
   - Cash (with change amount if needed)
   - Credit Card on Delivery
   - Debit Card on Delivery  
   - PIX on Delivery
6. Complete order
```

### 2. Admin Panel Verification
```
Restaurant Admin View:
1. Order list shows payment method column
2. Order details display payment method with icon
3. Change amount shown for cash orders
4. Payment status clearly indicated
```

### 3. Database Verification
Check that orders are saving the delivery payment method:
```sql
SELECT uid, delivery_payment_method, is_change, change_amount, order_type 
FROM order_user_list 
WHERE delivery_payment_method IS NOT NULL 
ORDER BY created_at DESC 
LIMIT 10;
```

## Troubleshooting

### Common Issues

#### 1. Payment Options Not Showing
**Symptoms:** Delivery payment options don't appear when "Pay Later" is selected
**Solutions:**
- Check JavaScript console for errors
- Verify order type is set to delivery (cod)
- Ensure "Pay Later" is properly selected
- Check CSS is loading correctly

#### 2. Database Errors
**Symptoms:** Errors when placing orders
**Solutions:**
- Verify database migration ran successfully
- Check column exists: `SHOW COLUMNS FROM order_user_list LIKE 'delivery_payment_method'`
- Ensure proper data types and constraints

#### 3. Icons Not Displaying
**Symptoms:** Payment method icons don't show
**Solutions:**
- Verify SVG files exist in `imagens_para_checkout/` directory
- Check file permissions (should be readable)
- Verify correct file paths in code

#### 4. Language Keys Missing
**Symptoms:** English text showing instead of Portuguese
**Solutions:**
- Check language_data table has the new keys
- Verify language system is working
- Clear language cache if applicable

### Debug Mode
Enable debug mode to see detailed error messages:
1. Set `$config['log_threshold'] = 4;` in `application/config/config.php`
2. Check logs in `application/logs/` directory
3. Use browser developer tools to check for JavaScript errors

## Rollback Plan

If issues occur, follow this rollback procedure:

### 1. Database Rollback
```sql
-- Remove the new column (this will lose data!)
ALTER TABLE `order_user_list` DROP COLUMN `delivery_payment_method`;

-- Remove language keys
DELETE FROM `language_data` WHERE keyword IN (
    'delivery_payment_method', 'cash_on_delivery', 'credit_card_on_delivery',
    'debit_card_on_delivery', 'pix_on_delivery', 'select_delivery_payment',
    'payment_terminal_delivery', 'change_for_amount'
);
```

### 2. File Rollback
Restore backed up files:
- `application/views/layouts/inc/order_info_form.php`
- `application/views/backend/order/inc/order_details_thumb.php`
- `application/views/backend/order/inc/orderList_thumb.php`
- `application/models/Order_m.php`

## Support

### Contact Information
- Developer: [Your contact information]
- Documentation: `BRAZILIAN_DELIVERY_PAYMENT_IMPLEMENTATION.md`
- Test Suite: `test_delivery_payment.php`

### Additional Resources
- CodeIgniter Documentation
- Original system documentation
- Database schema documentation

## Success Criteria

Deployment is successful when:
- [ ] All tests in test suite pass
- [ ] Customers can select delivery payment methods
- [ ] Orders save payment method to database
- [ ] Admin panel displays payment information
- [ ] No errors in application logs
- [ ] Existing functionality remains intact
- [ ] Mobile responsive design works
- [ ] Icons display correctly

## Maintenance

### Regular Checks
- Monitor error logs for payment-related issues
- Verify database integrity
- Check for any performance impacts
- Update language translations as needed

### Future Enhancements
- Integration with actual payment terminals
- Real-time payment status updates
- Delivery person mobile app integration
- Analytics and reporting on payment methods
