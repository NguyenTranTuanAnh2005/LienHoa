<?php
require_once __DIR__ . '/app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

try {
    $conn->exec("UPDATE hospitalizations SET thanh_toan = 'Đã thanh toán'");
    echo "Updated all hospitalizations to 'Đã thanh toán'.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
