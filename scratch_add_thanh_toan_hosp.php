<?php
require_once __DIR__ . '/app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

try {
    $stmt = $conn->query("SHOW COLUMNS FROM hospitalizations LIKE 'thanh_toan'");
    if ($stmt->rowCount() == 0) {
        $conn->exec("ALTER TABLE hospitalizations ADD COLUMN thanh_toan VARCHAR(50) DEFAULT 'Chưa thanh toán'");
        echo "Added thanh_toan to hospitalizations.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
