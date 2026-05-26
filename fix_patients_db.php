<?php
require_once 'app/config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Check if column exists
    $checkSql = "SHOW COLUMNS FROM patients LIKE 'status'";
    $stmt = $conn->prepare($checkSql);
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        $alterSql = "ALTER TABLE patients ADD COLUMN status VARCHAR(50) DEFAULT NULL";
        $conn->exec($alterSql);
        echo "Column 'status' added successfully to 'patients' table.\n";
    } else {
        echo "Column 'status' already exists in 'patients' table.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
