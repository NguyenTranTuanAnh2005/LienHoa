<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=smart_hospital', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("UPDATE bac_si SET hinh_anh = 'doctor_tran_thanh_binh.png' WHERE ho_ten LIKE '%Trần Thanh Bình%'");
    $pdo->exec("UPDATE bac_si SET hinh_anh = 'doctor_le_minh_tam.png' WHERE ho_ten LIKE '%Lê Minh Tâm%'");
    $pdo->exec("UPDATE bac_si SET hinh_anh = 'doctor_pham_quang_khai.png' WHERE ho_ten LIKE '%Phạm Quang Khải%'");
    
    echo "Done updating images.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
