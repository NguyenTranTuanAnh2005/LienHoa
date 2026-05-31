<?php
require_once __DIR__ . '/app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT * FROM notices");
$notices = $stmt->fetchAll();

echo "--- Current Notices ---\n";
print_r($notices);

?>
//Giống SELECT * FROM trong database, đoạn code này giúp hiển thị tất cả các thông báo hiện có trong bảng notices.