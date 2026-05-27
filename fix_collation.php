<?php
require 'app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

echo "Altering lab_tests...\n";
try {
    $conn->exec("ALTER TABLE lab_tests CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "lab_tests ALTER OK\n";
} catch (Exception $e) {
    echo "lab_tests failed: " . $e->getMessage() . "\n";
}
