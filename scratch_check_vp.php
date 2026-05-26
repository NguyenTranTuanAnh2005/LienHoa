<?php
require_once __DIR__ . '/app/config/database.php';
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->query("SELECT trang_thai FROM vien_phi WHERE ma_benh_nhan = 'BN2026001'");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
