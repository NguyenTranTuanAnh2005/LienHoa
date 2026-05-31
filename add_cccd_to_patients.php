<?php
require_once __DIR__ . '/app/config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Check if column exists first
    $check = $conn->query("SHOW COLUMNS FROM patients LIKE 'cccd'");
    if ($check->rowCount() == 0) {
        $conn->exec("ALTER TABLE patients ADD COLUMN cccd VARCHAR(20) AFTER address");
        echo "Successfully added 'cccd' column to 'patients' table.\n";
    } else {
        echo "Column 'cccd' already exists.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

//Đoạn code này giúp đồng bộ hóa cấu trúc Database giữa các máy tính khác nhau.
