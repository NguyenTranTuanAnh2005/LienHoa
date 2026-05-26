<?php
require_once __DIR__ . '/app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

try {
    // Kiem tra xem cot da ton tai chua
    $stmt = $conn->query("SHOW COLUMNS FROM dat_lich LIKE 'ma_benh_nhan'");
    if ($stmt->rowCount() == 0) {
        $conn->exec("ALTER TABLE dat_lich ADD COLUMN ma_benh_nhan VARCHAR(50) AFTER id");
        echo "Added ma_benh_nhan to dat_lich.\n";
    } else {
        echo "Column ma_benh_nhan already exists in dat_lich.\n";
    }

    // Update existing records for testing if necessary
    $conn->exec("UPDATE dat_lich SET ma_benh_nhan = 'BN2026001' WHERE ten_benh_nhan LIKE '%Khách hàng%' OR id_goi_kham IS NOT NULL");
    echo "Updated existing records for testing.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
