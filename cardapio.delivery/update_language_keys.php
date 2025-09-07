<?php
// Update delivery payment language keys for improved UI
// This script updates existing keys and adds new ones for the simplified checkout interface

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_implicit_flush(true);

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

// Update existing language keys
$updates = [
    'cash_on_delivery' => ['pt' => 'Dinheiro', 'details' => 'Dinheiro', 'english' => 'Cash'],
    'credit_card_on_delivery' => ['pt' => 'Cartão de crédito', 'details' => 'Cartão de crédito', 'english' => 'Credit card'],
    'debit_card_on_delivery' => ['pt' => 'Cartão de débito', 'details' => 'Cartão de débito', 'english' => 'Debit card'],
    'pix_on_delivery' => ['pt' => 'PIX', 'details' => 'PIX', 'english' => 'PIX']
];

foreach ($updates as $keyword => $values) {
    $sql = "UPDATE language_data SET pt = ?, details = ?, english = ? WHERE keyword = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $values['pt'], $values['details'], $values['english'], $keyword);

    if ($stmt->execute()) {
        echo "Updated $keyword successfully\n";
    } else {
        echo "Error updating $keyword: " . $conn->error . "\n";
    }
    $stmt->close();
}

// Add new language keys
$new_keys = [
    'general_payment_terminal_info' => [
        'pt' => 'A maquininha será levada pelo entregador',
        'details' => 'A maquininha será levada pelo entregador',
        'english' => 'Payment terminal will be brought by delivery person'
    ],
    'pix_qr_code_info' => [
        'pt' => '(QR-code)',
        'details' => '(QR-code)',
        'english' => '(QR-code)'
    ]
];

foreach ($new_keys as $keyword => $values) {
    $sql = "INSERT IGNORE INTO language_data (keyword, pt, details, english, type) VALUES (?, ?, ?, ?, 'user')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $keyword, $values['pt'], $values['details'], $values['english']);

    if ($stmt->execute()) {
        echo "Added $keyword successfully\n";
    } else {
        echo "Error adding $keyword: " . $conn->error . "\n";
    }
    $stmt->close();
}

$conn->close();
echo "Language keys updated successfully!\n";
?>
