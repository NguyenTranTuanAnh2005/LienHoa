<?php
require_once __DIR__ . '/app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

try {
    $stmt = $conn->query("SHOW COLUMNS FROM patients LIKE 'diagnosis'");
    if ($stmt->rowCount() == 0) {
        $conn->exec("ALTER TABLE patients ADD COLUMN diagnosis TEXT AFTER email");
        echo "Added diagnosis column to patients table.\n";
    } else {
        echo "Column diagnosis already exists.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
