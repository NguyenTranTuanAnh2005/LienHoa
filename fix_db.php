<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Check if column exists
    $checkSql = "SHOW COLUMNS FROM lab_tests LIKE 'thanh_toan'";
    $stmt = $conn->prepare($checkSql);
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        $alterSql = "ALTER TABLE lab_tests ADD COLUMN thanh_toan ENUM('Chưa thanh toán', 'Đã thanh toán') DEFAULT 'Chưa thanh toán'";
        $conn->exec($alterSql);
        echo "Column 'thanh_toan' added successfully to 'lab_tests' table.\n";
    } else {
        echo "Column 'thanh_toan' already exists in 'lab_tests' table.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
