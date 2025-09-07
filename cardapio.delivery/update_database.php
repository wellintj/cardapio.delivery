<?php
// Database credentials
$hostname = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : 'db';
$username = 'cardapio.delivery-db-usr';
$password = 'haEY5cLdhMEzrm2D';
$database = 'cardapio.delivery-db';

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to add the column
$sql = "ALTER TABLE `restaurant_list` ADD `is_mercado_pix` INT(1) NOT NULL DEFAULT '0'";

if ($conn->query($sql) === TRUE) {
    echo "Column is_mercado_pix added successfully";
} else {
    echo "Error adding column: " . $conn->error;
}

$conn->close();
?>