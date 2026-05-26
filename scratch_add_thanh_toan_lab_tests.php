<?php
require_once __DIR__ . '/app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

try {
    $stmt = $conn->query("SHOW COLUMNS FROM lab_tests LIKE 'thanh_toan'");
    if ($stmt->rowCount() == 0) {
        $conn->exec("ALTER TABLE lab_tests ADD COLUMN thanh_toan ENUM('Chưa thanh toán', 'Đã thanh toán') DEFAULT 'Chưa thanh toán' AFTER status");
        echo "Added thanh_toan to lab_tests.\n";
    } else {
        echo "Column thanh_toan already exists in lab_tests.\n";
    }

    $conn->exec("UPDATE lab_tests SET thanh_toan = 'Đã thanh toán'");
    $conn->exec("UPDATE lab_tests SET thanh_toan = 'Chưa thanh toán' WHERE id = (SELECT MAX(id) FROM (SELECT * FROM lab_tests) as temp WHERE user_id = (SELECT id FROM users WHERE patient_id = (SELECT id FROM patients WHERE patient_code = 'BN2026001') LIMIT 1))");
    
    echo "Updated payment statuses for lab_tests.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
