<?php
require_once __DIR__ . '/app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query('DESCRIBE chuyen_khoa');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
