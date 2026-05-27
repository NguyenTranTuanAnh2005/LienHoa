<?php
require 'app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

echo "Testing dat_lich...\n";
try {
    $conn->query("SELECT d.id FROM dat_lich d LEFT JOIN patients p ON d.so_dien_thoai = p.phone LIMIT 1");
    echo "dat_lich OK\n";
} catch (Exception $e) {
    echo "dat_lich failed: " . $e->getMessage() . "\n";
}

echo "Testing hospitalizations...\n";
try {
    $conn->query("SELECT h.id FROM hospitalizations h LEFT JOIN patients p ON h.phone = p.phone LIMIT 1");
    echo "hospitalizations OK\n";
} catch (Exception $e) {
    echo "hospitalizations failed: " . $e->getMessage() . "\n";
}

echo "Testing lab_tests...\n";
try {
    $conn->query("SELECT l.id FROM lab_tests l LEFT JOIN patients p ON l.phone = p.phone LIMIT 1");
    echo "lab_tests OK\n";
} catch (Exception $e) {
    echo "lab_tests failed: " . $e->getMessage() . "\n";
}
