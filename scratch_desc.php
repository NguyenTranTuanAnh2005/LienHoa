<?php
require_once __DIR__ . '/app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query('DESCRIBE dat_lich');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt = $conn->query('DESCRIBE vien_phi');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
