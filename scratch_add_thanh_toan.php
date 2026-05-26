<?php
require_once __DIR__ . '/app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

try {
    $stmt = $conn->query("SHOW COLUMNS FROM dat_lich LIKE 'thanh_toan'");
    if ($stmt->rowCount() == 0) {
        $conn->exec("ALTER TABLE dat_lich ADD COLUMN thanh_toan VARCHAR(50) DEFAULT 'Chưa thanh toán' AFTER trang_thai");
        echo "Added thanh_toan to dat_lich.\n";
    } else {
        echo "Column thanh_toan already exists in dat_lich.\n";
    }

    // Set all existing as paid EXCEPT the most recent one for BN2026001 so they can test
    // Actually, let's just set all to 'Đã thanh toán', and only the most recent one to 'Chưa thanh toán'
    $conn->exec("UPDATE dat_lich SET thanh_toan = 'Đã thanh toán'");
    $conn->exec("UPDATE dat_lich SET thanh_toan = 'Chưa thanh toán' WHERE id = (SELECT MAX(id) FROM (SELECT * FROM dat_lich) as temp WHERE ma_benh_nhan = 'BN2026001')");
    
    echo "Updated payment statuses for testing.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
