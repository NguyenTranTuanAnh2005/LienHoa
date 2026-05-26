<?php
require_once __DIR__ . '/app/config/database.php';
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->query("SELECT * FROM dat_lich WHERE ma_benh_nhan = 'BN2026001'");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
