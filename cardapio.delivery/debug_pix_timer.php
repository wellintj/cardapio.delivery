<?php
/**
 * Debug script for PIX payment timer issues
 * This script will help identify and fix the timer problems
 */

// Database configuration
$hostname = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : 'db';
$username = 'cardapio.delivery-db-usr';
$password = 'haEY5cLdhMEzrm2D';
$database = 'cardapio.delivery-db';

echo "=== PIX TIMER DEBUG SCRIPT ===\n\n";

// Create connection
$mysqli = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

echo "✅ Database connection successful\n\n";

// 1. Check if pix_payment_data column exists
echo "1. CHECKING DATABASE SCHEMA:\n";
echo "----------------------------\n";

$check_column = "SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT 
                 FROM INFORMATION_SCHEMA.COLUMNS 
                 WHERE TABLE_SCHEMA = '$database' 
                 AND TABLE_NAME = 'order_user_list' 
                 AND COLUMN_NAME = 'pix_payment_data'";

$result = $mysqli->query($check_column);

if ($result->num_rows > 0) {
    $column_info = $result->fetch_assoc();
    echo "✅ Column 'pix_payment_data' EXISTS\n";
    echo "   - Type: " . $column_info['DATA_TYPE'] . "\n";
    echo "   - Nullable: " . $column_info['IS_NULLABLE'] . "\n";
    echo "   - Default: " . ($column_info['COLUMN_DEFAULT'] ?? 'NULL') . "\n";
} else {
    echo "❌ Column 'pix_payment_data' DOES NOT EXIST\n";
    echo "   Running migration to add the column...\n";
    
    $add_column_sql = "ALTER TABLE `order_user_list` 
                       ADD COLUMN `pix_payment_data` JSON NULL 
                       COMMENT 'PIX payment data including expiration timestamp, payment_id, etc.' 
                       AFTER `service_charge`";
    
    if ($mysqli->query($add_column_sql) === TRUE) {
        echo "✅ Column 'pix_payment_data' added successfully\n";
    } else {
        echo "❌ Error adding column: " . $mysqli->error . "\n";
    }
}

echo "\n";

// 2. Check existing PIX payment data
echo "2. CHECKING EXISTING PIX PAYMENT DATA:\n";
echo "--------------------------------------\n";

$check_pix_data = "SELECT uid, payment_by, pix_payment_data, created_at 
                   FROM order_user_list 
                   WHERE payment_by = 'mercado_pix' 
                   AND pix_payment_data IS NOT NULL 
                   ORDER BY created_at DESC 
                   LIMIT 5";

$pix_result = $mysqli->query($check_pix_data);

if ($pix_result->num_rows > 0) {
    echo "Found " . $pix_result->num_rows . " PIX payment(s) with stored data:\n";
    
    while ($row = $pix_result->fetch_assoc()) {
        echo "\n📋 Order ID: " . $row['uid'] . "\n";
        echo "   Created: " . $row['created_at'] . "\n";
        
        if ($row['pix_payment_data']) {
            $pix_data = json_decode($row['pix_payment_data'], true);
            echo "   PIX Data:\n";
            
            if (isset($pix_data['expiration_timestamp'])) {
                $exp_time = $pix_data['expiration_timestamp'];
                $current_time = time();
                $remaining = $exp_time - $current_time;
                
                echo "     - Expiration Timestamp: $exp_time\n";
                echo "     - Current Timestamp: $current_time\n";
                echo "     - Time Difference: $remaining seconds\n";
                echo "     - Minutes Remaining: " . round($remaining / 60, 2) . "\n";
                echo "     - Expiration Date: " . date('Y-m-d H:i:s', $exp_time) . "\n";
                
                if ($remaining > 0) {
                    echo "     - Status: ✅ ACTIVE\n";
                } else {
                    echo "     - Status: ❌ EXPIRED\n";
                }
            }
            
            if (isset($pix_data['payment_id'])) {
                echo "     - Payment ID: " . $pix_data['payment_id'] . "\n";
            }
            
            if (isset($pix_data['status'])) {
                echo "     - Payment Status: " . $pix_data['status'] . "\n";
            }
        }
    }
} else {
    echo "❌ No PIX payments with stored data found\n";
    echo "   This could mean:\n";
    echo "   - No PIX payments have been created yet\n";
    echo "   - The column was added after existing payments\n";
    echo "   - The data is not being stored correctly\n";
}

echo "\n";

// 3. Check timestamp calculation logic
echo "3. TESTING TIMESTAMP CALCULATIONS:\n";
echo "----------------------------------\n";

$current_timestamp = time();
$expiration_30min = strtotime('+30 minutes');
$expiration_29min = strtotime('+29 minutes');

echo "Current timestamp: $current_timestamp\n";
echo "Current time: " . date('Y-m-d H:i:s', $current_timestamp) . "\n";
echo "30 min expiration: $expiration_30min\n";
echo "30 min expiration time: " . date('Y-m-d H:i:s', $expiration_30min) . "\n";
echo "Difference (30min): " . ($expiration_30min - $current_timestamp) . " seconds\n";
echo "Minutes (30min): " . round(($expiration_30min - $current_timestamp) / 60, 2) . "\n\n";

echo "29 min expiration: $expiration_29min\n";
echo "29 min expiration time: " . date('Y-m-d H:i:s', $expiration_29min) . "\n";
echo "Difference (29min): " . ($expiration_29min - $current_timestamp) . " seconds\n";
echo "Minutes (29min): " . round(($expiration_29min - $current_timestamp) / 60, 2) . "\n\n";

// 4. Simulate JavaScript calculation
echo "4. SIMULATING JAVASCRIPT CALCULATION:\n";
echo "-------------------------------------\n";

$js_current_time = floor(time());
$js_expiration_time = $expiration_29min;
$js_time_left = $js_expiration_time - $js_current_time;
$js_minutes = floor($js_time_left / 60);
$js_seconds = $js_time_left % 60;

echo "JavaScript simulation:\n";
echo "- Current time (JS): $js_current_time\n";
echo "- Expiration time (JS): $js_expiration_time\n";
echo "- Time left (JS): $js_time_left seconds\n";
echo "- Minutes (JS): $js_minutes\n";
echo "- Seconds (JS): $js_seconds\n";
echo "- Display format: {$js_minutes}:" . str_pad($js_seconds, 2, '0', STR_PAD_LEFT) . "\n";

echo "\n";

// 5. Check for potential issues
echo "5. POTENTIAL ISSUES ANALYSIS:\n";
echo "-----------------------------\n";

if ($js_minutes > 60) {
    echo "⚠️  WARNING: Timer showing more than 60 minutes ($js_minutes minutes)\n";
    echo "   This could indicate:\n";
    echo "   - Timestamp is in milliseconds instead of seconds\n";
    echo "   - Wrong timezone calculation\n";
    echo "   - Incorrect expiration time calculation\n";
}

if ($js_minutes < 0) {
    echo "⚠️  WARNING: Timer showing negative time ($js_minutes minutes)\n";
    echo "   This indicates the payment has already expired\n";
}

if ($js_minutes >= 25 && $js_minutes <= 35) {
    echo "✅ Timer value looks reasonable ($js_minutes minutes)\n";
}

$mysqli->close();

echo "\n=== DEBUG COMPLETED ===\n";
echo "\nNext steps:\n";
echo "1. If column doesn't exist, run this script to add it\n";
echo "2. Create a new PIX payment to test data storage\n";
echo "3. Check the JavaScript console for any errors\n";
echo "4. Verify the PHP data being passed to JavaScript\n";
?>
