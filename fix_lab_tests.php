<?php
require_once __DIR__ . '/app/config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Thêm cột nếu chưa tồn tại
    try {
        $conn->exec("ALTER TABLE lab_tests ADD COLUMN phone VARCHAR(20) AFTER patient_name");
        echo "Column phone added.\n";
    } catch (PDOException $e) { echo "phone: " . $e->getMessage() . "\n"; }
    
    try {
        $conn->exec("ALTER TABLE lab_tests ADD COLUMN cccd VARCHAR(20) AFTER phone");
        echo "Column cccd added.\n";
    } catch (PDOException $e) { echo "cccd: " . $e->getMessage() . "\n"; }
    
    try {
        $conn->exec("ALTER TABLE lab_tests ADD COLUMN patient_id VARCHAR(50) AFTER cccd");
        echo "Column patient_id added.\n";
    } catch (PDOException $e) { echo "patient_id: " . $e->getMessage() . "\n"; }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
