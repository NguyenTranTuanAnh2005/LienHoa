<?php
require_once 'app/config/database.php';
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->query('SHOW COLUMNS FROM patients');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($columns as $col) {
    echo $col['Field'] . " - " . $col['Type'] . "\n";
}
