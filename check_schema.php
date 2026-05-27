<?php
require 'app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("DESCRIBE lab_tests");
echo "lab_tests table:\n";
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt = $conn->query("DESCRIBE hospitalizations");
echo "\nhospitalizations table:\n";
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
