<?php
/**
 * Migration script to fix PIX payment expiration timer
 * This script adds the pix_payment_data column to store PIX payment information including expiration timestamp
 */

// Database configuration - Update these values according to your database settings
$db_config = [
    'hostname' => 'localhost',
    'username' => 'your_db_username',
    'password' => 'your_db_password',
    'database' => 'your_database_name'
];

// Create database connection
$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "Connected to database successfully.\n";

// Check if column already exists
$check_column = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
                 WHERE TABLE_SCHEMA = '{$db_config['database']}' 
                 AND TABLE_NAME = 'order_user_list' 
                 AND COLUMN_NAME = 'pix_payment_data'";

$result = $mysqli->query($check_column);

if ($result->num_rows > 0) {
    echo "Column 'pix_payment_data' already exists in 'order_user_list' table.\n";
} else {
    // Add the column
    $add_column_sql = "ALTER TABLE `order_user_list` 
                       ADD COLUMN `pix_payment_data` JSON NULL 
                       COMMENT 'PIX payment data including expiration timestamp, payment_id, etc.' 
                       AFTER `service_charge`";
    
    if ($mysqli->query($add_column_sql) === TRUE) {
        echo "Column 'pix_payment_data' added successfully to 'order_user_list' table.\n";
    } else {
        echo "Error adding column: " . $mysqli->error . "\n";
    }
}

// Add index for better performance (optional)
$check_index = "SHOW INDEX FROM `order_user_list` WHERE Key_name = 'idx_pix_payment'";
$index_result = $mysqli->query($check_index);

if ($index_result->num_rows == 0) {
    $add_index_sql = "ALTER TABLE `order_user_list` ADD INDEX `idx_pix_payment` (`pix_payment_data`(255))";
    
    if ($mysqli->query($add_index_sql) === TRUE) {
        echo "Index 'idx_pix_payment' added successfully.\n";
    } else {
        echo "Error adding index: " . $mysqli->error . "\n";
    }
} else {
    echo "Index 'idx_pix_payment' already exists.\n";
}

$mysqli->close();
echo "Migration completed successfully!\n";
echo "\nNow you can test the PIX payment timer fix:\n";
echo "1. Create a new PIX payment\n";
echo "2. Refresh the page or navigate away and back\n";
echo "3. The timer should show the correct remaining time\n";
?>
