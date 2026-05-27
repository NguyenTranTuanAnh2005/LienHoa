<?php
require 'app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

// Fix dat_lich
$affected1 = $conn->exec("UPDATE dat_lich d JOIN patients p ON d.so_dien_thoai = p.phone SET d.ma_benh_nhan = p.patient_code WHERE d.ma_benh_nhan IS NULL OR d.ma_benh_nhan = ''");
echo "Updated $affected1 dat_lich records.\n";

// Fix hospitalizations
$affected2 = $conn->exec("UPDATE hospitalizations h JOIN patients p ON h.phone = p.phone SET h.patient_id = p.patient_code WHERE h.patient_id NOT LIKE 'BN2026%'");
echo "Updated $affected2 hospitalizations records.\n";

// Fix lab_tests
$affected3 = $conn->exec("UPDATE lab_tests l JOIN patients p ON l.user_id = p.patient_code OR l.phone = p.phone SET l.patient_id = p.patient_code WHERE l.patient_id IS NULL OR l.patient_id = ''");
echo "Updated $affected3 lab_tests records.\n";

