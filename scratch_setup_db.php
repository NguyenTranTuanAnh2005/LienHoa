<?php
require_once 'app/config/Database.php';

$db = new Database();
$conn = $db->getConnection();

// Check chuyen_khoa
$stmt = $conn->query("SELECT * FROM chuyen_khoa");
$chuyen_khoas = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "CHUYEN_KHOA:\n";
print_r($chuyen_khoas);

// Check bac_si
$stmt = $conn->query("SELECT * FROM bac_si");
$bac_sis = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "\nBAC_SI:\n";
print_r($bac_sis);

// Update/Insert 6 chuyen khoa (from home page tabs)
$target_chuyen_khoas = [
    1 => 'Sản Phụ Khoa',
    2 => 'Trung tâm Tim mạch',
    3 => 'Khoa Tiêu Hóa',
    4 => 'Chấn thương chỉnh hình',
    5 => 'Thần kinh',
    6 => 'Ung Bướu'
];

foreach ($target_chuyen_khoas as $id => $ten) {
    $stmt = $conn->prepare("INSERT INTO chuyen_khoa (id, ten_khoa, mo_ta) VALUES (?, ?, 'Mô tả chuyên khoa') ON DUPLICATE KEY UPDATE ten_khoa = ?");
    $stmt->execute([$id, $ten, $ten]);
}

// Ensure 6 doctors
$target_bac_sis = [
    1 => ['ho_ten' => 'BS. CKII Nguyễn Văn A', 'id_chuyen_khoa' => 1, 'hinh_anh' => 'doctor_nguyen_van_a.png', 'tieu_su' => 'Hơn 15 năm kinh nghiệm...'],
    2 => ['ho_ten' => 'ThS. BS Trần Thị B', 'id_chuyen_khoa' => 3, 'hinh_anh' => 'doctor2.png', 'tieu_su' => 'Chuyên gia hàng đầu...'],
    3 => ['ho_ten' => 'BS. CKI Nguyễn Văn An', 'id_chuyen_khoa' => 4, 'hinh_anh' => 'doctor3.png', 'tieu_su' => 'Nhiều năm kinh nghiệm...'],
    4 => ['ho_ten' => 'BS. CKII Phạm Quang Khải', 'id_chuyen_khoa' => 2, 'hinh_anh' => 'doctor1.png', 'tieu_su' => 'Chuyên gia điều trị...'],
    5 => ['ho_ten' => 'BS. CKII Lê Quang Hải', 'id_chuyen_khoa' => 5, 'hinh_anh' => 'doctor_le_quang_hai.png', 'tieu_su' => 'Kinh nghiệm phẫu thuật thần kinh phức tạp...'],
    6 => ['ho_ten' => 'ThS. BS Nguyễn Thị Trang', 'id_chuyen_khoa' => 6, 'hinh_anh' => 'doctor_nguyen_thi_trang.png', 'tieu_su' => 'Chuyên gia tầm soát và điều trị các bệnh lý ung bướu...']
];

foreach ($target_bac_sis as $id => $bs) {
    $stmt = $conn->prepare("INSERT INTO bac_si (id, ho_ten, tieu_su, hinh_anh, id_chuyen_khoa) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE ho_ten = ?, id_chuyen_khoa = ?, hinh_anh = ?");
    $stmt->execute([$id, $bs['ho_ten'], $bs['tieu_su'], $bs['hinh_anh'], $bs['id_chuyen_khoa'], $bs['ho_ten'], $bs['id_chuyen_khoa'], $bs['hinh_anh']]);
}

echo "\nDONE DB SETUP\n";
