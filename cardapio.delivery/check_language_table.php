<?php
// Check the structure of the language_data table

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$hostname = 'localhost';
$username = 'cardapio.delivery-db-usr';
$password = 'haEY5cLdhMEzrm2D';
$database = 'cardapio.delivery-db';

// Connect to database
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected to database successfully\n";

// Check table structure
$sql = "DESCRIBE language_data";
$result = $conn->query($sql);

if ($result) {
    echo "Table structure:\n";
    while ($row = $result->fetch_assoc()) {
        echo "Column: " . $row['Field'] . " - Type: " . $row['Type'] . "\n";
    }
} else {
    echo "Error describing table: " . $conn->error . "\n";
}

// Check existing language keys
$sql = "SELECT * FROM language_data WHERE keyword IN ('cash_on_delivery', 'credit_card_on_delivery', 'debit_card_on_delivery', 'pix_on_delivery') LIMIT 5";
$result = $conn->query($sql);

if ($result) {
    echo "\nExisting language keys:\n";
    while ($row = $result->fetch_assoc()) {
        echo "Keyword: " . $row['keyword'] . "\n";
        foreach ($row as $key => $value) {
            if ($key != 'keyword') {
                echo "  $key: $value\n";
            }
        }
        echo "\n";
    }
} else {
    echo "Error querying language keys: " . $conn->error . "\n";
}

$conn->close();
?>
