# PIX Timer Testing & Debugging Guide

## 🚨 **ISSUES IDENTIFIED & FIXED**

### **1. Timezone Conversion Issue**
**Problem**: The Mercado Pago API returns expiration dates in Brazilian timezone format (`2023-09-05T10:00:00.000-03:00`), but `strtotime()` wasn't handling this correctly.

**Fix**: Replaced `strtotime()` with `DateTime` class for proper timezone handling.

### **2. Database Schema Issue**
**Problem**: The `pix_payment_data` column might not exist in the `order_user_list` table.

**Fix**: Created migration script to add the column.

### **3. JavaScript Debugging**
**Problem**: Timer showing 209:00 minutes instead of expected 29:00.

**Fix**: Added comprehensive debugging to identify the root cause.

---

## 🧪 **STEP-BY-STEP TESTING PROCESS**

### **Step 1: Run Database Migration**
1. Open your browser and navigate to:
   ```
   http://yourdomain.com/migrate_pix_timer.php
   ```
2. This will:
   - Check if `pix_payment_data` column exists
   - Add the column if missing
   - Show existing PIX payments
   - Test timestamp calculations

### **Step 2: Create New PIX Payment**
1. Go to your restaurant's ordering page
2. Add items to cart and proceed to checkout
3. Select "PIX Dinâmico - Mercado Pago" as payment method
4. Complete the order to generate PIX payment
5. **Note the timer value when the PIX page loads**

### **Step 3: Debug JavaScript Timer**
1. Open browser Developer Tools (F12)
2. Go to the **Console** tab
3. Look for debug messages starting with "PIX Timer Debug Info:"
4. Check the logged values:
   ```javascript
   PIX Timer Debug Info:
   - Expiration timestamp: 1693872000
   - Current timestamp: 1693870200
   - Expiration date: Tue Sep 05 2023 10:00:00 GMT-0300
   - Current date: Tue Sep 05 2023 09:30:00 GMT-0300
   ```

### **Step 4: Analyze Timer Values**
Check the console output for these scenarios:

#### **✅ CORRECT BEHAVIOR:**
```
- Time left (seconds): 1800
- Time left (minutes): 30
Timer display: 30:00 or 29:59
```

#### **❌ INCORRECT BEHAVIOR (209 minutes):**
```
- Time left (seconds): 12540
- Time left (minutes): 209
Timer display: 209:00
```

### **Step 5: Test Page Refresh**
1. Note the current timer value (e.g., 28:45)
2. Refresh the page (F5)
3. **Expected**: Timer should continue from approximately the same time
4. **Check console** for any errors or warnings

---

## 🔍 **DEBUGGING SPECIFIC ISSUES**

### **Issue 1: Timer Shows 209:00 Minutes**

**Possible Causes:**
1. **Timestamp in milliseconds**: JavaScript expects seconds, but getting milliseconds
2. **Timezone offset**: Server timezone different from expected
3. **Date format parsing**: Mercado Pago date not parsed correctly

**Debug Steps:**
```javascript
// Check these values in browser console:
console.log('Expiration timestamp:', paymentData.expirationTime);
console.log('Current timestamp:', Math.floor(Date.now() / 1000));
console.log('Difference:', paymentData.expirationTime - Math.floor(Date.now() / 1000));
```

**Expected Values:**
- Expiration timestamp: ~1693872000 (10-digit Unix timestamp)
- Current timestamp: ~1693870200 (10-digit Unix timestamp)
- Difference: ~1800 seconds (30 minutes)

### **Issue 2: Timer Resets on Page Refresh**

**Check Database:**
1. Go to your database management tool (phpMyAdmin, etc.)
2. Check `order_user_list` table for recent PIX orders
3. Look for `pix_payment_data` column
4. Verify it contains JSON data like:
   ```json
   {
     "payment_id": "1234567890",
     "expiration_timestamp": 1693872000,
     "created_at": 1693870200,
     "status": "pending"
   }
   ```

**Check PHP Logic:**
1. Add this debug code to Profile.php (temporarily):
   ```php
   // After line 2700 in load_existing_pix_payment method
   error_log('PIX Debug - Stored timestamp: ' . $stored_pix_data['expiration_timestamp']);
   error_log('PIX Debug - Current time: ' . time());
   error_log('PIX Debug - Remaining: ' . ($stored_pix_data['expiration_timestamp'] - time()));
   ```

### **Issue 3: Database Column Missing**

**Symptoms:**
- Migration script shows "Column does not exist"
- PHP errors about undefined column

**Fix:**
1. Run the migration script: `http://yourdomain.com/migrate_pix_timer.php`
2. Or manually execute SQL:
   ```sql
   ALTER TABLE `order_user_list` 
   ADD COLUMN `pix_payment_data` JSON NULL 
   COMMENT 'PIX payment data including expiration timestamp, payment_id, etc.';
   ```

---

## 📊 **EXPECTED TEST RESULTS**

### **Scenario 1: New PIX Payment**
- ✅ Timer shows 30:00 or 29:59
- ✅ Console shows reasonable timestamp values
- ✅ Database stores PIX payment data

### **Scenario 2: Page Refresh After 5 Minutes**
- ✅ Timer shows ~25:00 (not 30:00)
- ✅ Console shows same expiration timestamp
- ✅ No new PIX payment created

### **Scenario 3: Browser Back/Forward**
- ✅ Timer maintains correct remaining time
- ✅ QR code remains the same
- ✅ No JavaScript errors

### **Scenario 4: Direct URL Access**
- ✅ Timer shows correct remaining time
- ✅ Existing PIX data loaded from database
- ✅ Page functions normally

---

## 🚨 **TROUBLESHOOTING COMMON ISSUES**

### **Timer Still Shows Wrong Value**
1. Clear browser cache and cookies
2. Check server timezone: `date_default_timezone_get()`
3. Verify Mercado Pago API response format
4. Check PHP error logs for DateTime conversion errors

### **Database Errors**
1. Ensure MySQL supports JSON data type (MySQL 5.7+)
2. Check database user permissions
3. Verify table exists and is accessible

### **JavaScript Errors**
1. Check browser console for errors
2. Verify `paymentData.expirationTime` is not null
3. Ensure Bootstrap and other dependencies are loaded

---

## ✅ **SUCCESS CRITERIA**

The PIX timer fix is working correctly when:

1. **✅ New payments** show 30:00 or 29:59 minutes
2. **✅ Page refreshes** maintain correct remaining time
3. **✅ Navigation** (back/forward) preserves timer state
4. **✅ Expired payments** show "Expirado" message
5. **✅ Console logs** show reasonable timestamp values
6. **✅ Database** contains PIX payment data with correct timestamps

---

**Next Steps**: Run through each testing scenario and report any remaining issues with specific console log outputs and database values.
