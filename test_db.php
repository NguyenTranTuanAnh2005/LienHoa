<?php
require 'app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

echo "--- DAT_LICH JOIN PATIENTS ---\n";
print_r($conn->query("SELECT p.patient_code, d.id FROM dat_lich d JOIN patients p ON d.so_dien_thoai = p.phone")->fetchAll(PDO::FETCH_ASSOC));
