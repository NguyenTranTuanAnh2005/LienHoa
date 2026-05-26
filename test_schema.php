<?php
require_once 'app/core/Database.php';

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("DESCRIBE hospitalizations");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt = $conn->query("DESCRIBE lab_tests");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
