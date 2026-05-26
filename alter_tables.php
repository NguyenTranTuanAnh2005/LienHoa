<?php
require_once __DIR__ . '/app/config/database.php';
$db = new Database();
$conn = $db->getConnection();
try {
    $conn->exec("ALTER TABLE lab_tests ADD COLUMN tong_tien DECIMAL(15,2) DEFAULT 0 AFTER status");
    echo "Added tong_tien to lab_tests\n";
} catch (Exception $e) {
    echo "lab_tests err: " . $e->getMessage() . "\n";
}
try {
    $conn->exec("ALTER TABLE hospitalizations ADD COLUMN tong_tien DECIMAL(15,2) DEFAULT 0 AFTER status");
    echo "Added tong_tien to hospitalizations\n";
} catch (Exception $e) {
    echo "hospitalizations err: " . $e->getMessage() . "\n";
}
