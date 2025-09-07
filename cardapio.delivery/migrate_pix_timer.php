<?php
/**
 * PIX Timer Migration Script
 * Run this through the web browser to add the pix_payment_data column
 * URL: http://yourdomain.com/migrate_pix_timer.php
 */

// Load CodeIgniter framework
require_once('index.php');

// Get CodeIgniter instance
$CI =& get_instance();

echo "<h1>PIX Timer Migration Script</h1>";
echo "<pre>";

try {
    // Check if column exists
    $query = $CI->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
                             WHERE TABLE_SCHEMA = DATABASE() 
                             AND TABLE_NAME = 'order_user_list' 
                             AND COLUMN_NAME = 'pix_payment_data'");
    
    if ($query->num_rows() > 0) {
        echo "✅ Column 'pix_payment_data' already exists in 'order_user_list' table.\n";
    } else {
        echo "❌ Column 'pix_payment_data' does not exist. Adding it now...\n";
        
        // Add the column
        $sql = "ALTER TABLE `order_user_list` 
                ADD COLUMN `pix_payment_data` JSON NULL 
                COMMENT 'PIX payment data including expiration timestamp, payment_id, etc.'";
        
        if ($CI->db->query($sql)) {
            echo "✅ Column 'pix_payment_data' added successfully!\n";
        } else {
            echo "❌ Error adding column: " . $CI->db->error()['message'] . "\n";
        }
    }
    
    // Check existing PIX payments
    echo "\n--- Checking existing PIX payments ---\n";
    
    $existing_pix = $CI->db->where('payment_by', 'mercado_pix')
                           ->order_by('created_at', 'DESC')
                           ->limit(5)
                           ->get('order_user_list');
    
    if ($existing_pix->num_rows() > 0) {
        echo "Found " . $existing_pix->num_rows() . " existing PIX payment(s):\n";
        
        foreach ($existing_pix->result_array() as $row) {
            echo "\n📋 Order ID: " . $row['uid'] . "\n";
            echo "   Created: " . $row['created_at'] . "\n";
            echo "   PIX Data: " . ($row['pix_payment_data'] ? 'EXISTS' : 'NULL') . "\n";
            
            if ($row['pix_payment_data']) {
                $pix_data = json_decode($row['pix_payment_data'], true);
                if (isset($pix_data['expiration_timestamp'])) {
                    $remaining = $pix_data['expiration_timestamp'] - time();
                    echo "   Remaining: " . round($remaining / 60, 1) . " minutes\n";
                }
            }
        }
    } else {
        echo "No existing PIX payments found.\n";
    }
    
    // Test timestamp calculations
    echo "\n--- Testing timestamp calculations ---\n";
    
    $current_time = time();
    $expiration_30min = strtotime('+30 minutes');
    $remaining_seconds = $expiration_30min - $current_time;
    $remaining_minutes = floor($remaining_seconds / 60);
    $remaining_secs = $remaining_seconds % 60;
    
    echo "Current timestamp: $current_time\n";
    echo "Current time: " . date('Y-m-d H:i:s', $current_time) . "\n";
    echo "30min expiration: $expiration_30min\n";
    echo "30min expiration time: " . date('Y-m-d H:i:s', $expiration_30min) . "\n";
    echo "Remaining seconds: $remaining_seconds\n";
    echo "Timer display: {$remaining_minutes}:" . str_pad($remaining_secs, 2, '0', STR_PAD_LEFT) . "\n";
    
    // Test Mercado Pago date format
    echo "\n--- Testing Mercado Pago date format ---\n";
    
    $mp_date = date('Y-m-d\TH:i:s.000-03:00', strtotime('+30 minutes'));
    echo "Mercado Pago format: $mp_date\n";
    
    try {
        $datetime = new DateTime($mp_date);
        $timestamp = $datetime->getTimestamp();
        $remaining = $timestamp - time();
        echo "Converted timestamp: $timestamp\n";
        echo "Remaining minutes: " . round($remaining / 60, 1) . "\n";
        echo "✅ DateTime conversion works correctly\n";
    } catch (Exception $e) {
        echo "❌ DateTime conversion failed: " . $e->getMessage() . "\n";
    }
    
    echo "\n✅ Migration completed successfully!\n";
    echo "\nNext steps:\n";
    echo "1. Create a new PIX payment to test the timer\n";
    echo "2. Refresh the page and verify the timer maintains correct time\n";
    echo "3. Check browser console for any JavaScript errors\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
echo "<p><strong>Migration completed!</strong> You can now test the PIX payment timer.</p>";
?>
