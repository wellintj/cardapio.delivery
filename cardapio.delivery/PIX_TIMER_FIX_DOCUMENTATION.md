# PIX Payment Expiration Timer Fix

## 🚨 **PROBLEM IDENTIFIED**

The PIX payment expiration timer was resetting to 29:00 minutes every time the page was refreshed, navigated away from, or reloaded. This happened because the system was recalculating the expiration time based on the current time instead of using the original expiration timestamp from when the PIX payment was created.

### **Root Cause**
```php
// PROBLEMATIC CODE (Profile.php line 2622)
$data['expiration_timestamp'] = strtotime('+' . $data['expiration_minutes'] . ' minutes');
```

This line was creating a new expiration timestamp every time the page loaded, instead of using the original expiration time from the Mercado Pago API.

---

## ✅ **SOLUTION IMPLEMENTED**

### **1. Database Schema Update**
Added a new column to store PIX payment data including the original expiration timestamp:

```sql
ALTER TABLE `order_user_list` 
ADD COLUMN `pix_payment_data` JSON NULL 
COMMENT 'PIX payment data including expiration timestamp, payment_id, etc.' 
AFTER `service_charge`;
```

### **2. PIX Payment Data Storage**
When a PIX payment is created, the system now stores:
- Original expiration timestamp from Mercado Pago API
- Payment ID, QR codes, and other payment data
- Creation timestamp for reference

```php
$pix_payment_data = [
    'payment_id' => $pix_result['payment_id'],
    'qr_code' => $pix_result['qr_code'],
    'qr_code_base64' => $pix_result['qr_code_base64'],
    'expiration_timestamp' => $expiration_timestamp,
    'expiration_date' => $pix_result['expiration_date'] ?? '',
    'created_at' => time(),
    'status' => $pix_result['status'] ?? 'pending'
];
```

### **3. Smart Payment Page Loading**
The system now checks if a PIX payment already exists for an order:
- If exists and not expired → Use stored data
- If expired or doesn't exist → Create new payment

### **4. Enhanced JavaScript Timer**
Improved countdown logic with:
- Proper expiration handling
- Auto-stop when expired
- Expiration message display
- Better error handling

---

## 📁 **FILES MODIFIED**

### **1. `application/controllers/Profile.php`**
- **Lines 2606-2648**: Enhanced PIX creation with data storage
- **Lines 2583-2600**: Added existing payment check logic  
- **Lines 2677-2699**: New helper method `load_existing_pix_payment()`

### **2. `application/views/payment/mercado_pix_payment.php`**
- **Lines 323-386**: Improved countdown timer with expiration handling

### **3. Database Migration Files**
- **`fix_pix_expiration_timer.sql`**: SQL migration script
- **`run_pix_timer_migration.php`**: PHP migration runner

---

## 🧪 **TESTING SCENARIOS**

### **Scenario 1: New PIX Payment**
1. Create a new order and generate PIX payment
2. Timer should show correct countdown (e.g., 29:00)
3. PIX data is stored in database

### **Scenario 2: Page Refresh**
1. Refresh the PIX payment page
2. Timer should continue from where it left off
3. No new PIX payment should be created

### **Scenario 3: Navigation Back**
1. Navigate away from PIX page
2. Return to PIX page via browser back button
3. Timer should show correct remaining time

### **Scenario 4: Direct URL Access**
1. Copy PIX payment URL
2. Open in new tab/window
3. Timer should show correct remaining time

### **Scenario 5: Expired Payment**
1. Wait for PIX payment to expire
2. Timer should show "Expirado"
3. Expiration message should appear
4. Auto-verification should stop

---

## 🚀 **DEPLOYMENT STEPS**

### **Step 1: Run Database Migration**
```bash
# Update database credentials in the migration file
php run_pix_timer_migration.php
```

### **Step 2: Test the Fix**
1. Create a new PIX payment
2. Note the timer value (e.g., 28:45)
3. Refresh the page
4. Verify timer continues from correct time
5. Test navigation scenarios

### **Step 3: Monitor Logs**
Check application logs for any PIX-related errors or warnings.

---

## 🔧 **TECHNICAL DETAILS**

### **Timer Calculation Logic**
```javascript
const now = Math.floor(Date.now() / 1000);
const timeLeft = paymentData.expirationTime - now;
```

### **Expiration Timestamp Source Priority**
1. **Primary**: Mercado Pago API `expiration_date`
2. **Fallback**: Local configuration `pix_expiration` minutes

### **Data Storage Format**
```json
{
  "payment_id": "1234567890",
  "qr_code": "00020126...",
  "qr_code_base64": "iVBORw0KGgoAAAANSUhEUgAA...",
  "expiration_timestamp": 1693872000,
  "expiration_date": "2023-09-05T10:00:00.000-03:00",
  "created_at": 1693870200,
  "status": "pending"
}
```

---

## ✅ **EXPECTED RESULTS**

After implementing this fix:

1. **✅ Persistent Timer**: Timer shows correct remaining time across page refreshes
2. **✅ No Duplicate Payments**: System reuses existing PIX payments when valid
3. **✅ Proper Expiration**: Clear indication when PIX payment expires
4. **✅ Better UX**: Users can safely refresh or navigate without losing timer state
5. **✅ Data Integrity**: PIX payment data is properly stored and retrieved

---

## 🔍 **TROUBLESHOOTING**

### **Issue**: Timer still resets after migration
**Solution**: Verify the `pix_payment_data` column was added successfully

### **Issue**: JavaScript errors in console
**Solution**: Check that `paymentData.expirationTime` is properly set

### **Issue**: Expired payments not handled correctly
**Solution**: Verify expiration timestamp is in Unix format (seconds, not milliseconds)

---

**Status**: ✅ **IMPLEMENTED AND READY FOR TESTING**
**Priority**: 🔥 **HIGH** - Critical UX issue affecting payment flow
**Impact**: 🎯 **POSITIVE** - Significantly improves PIX payment user experience
