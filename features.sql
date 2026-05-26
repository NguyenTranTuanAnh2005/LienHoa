USE smart_hospital;

-- Bảng Viện Phí
CREATE TABLE IF NOT EXISTS vien_phi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_ho_so VARCHAR(50) NOT NULL UNIQUE,
    ten_benh_nhan VARCHAR(150) NOT NULL,
    noi_dung TEXT NOT NULL,
    tong_tien DECIMAL(15,2) NOT NULL,
    trang_thai ENUM('chua_thanh_toan', 'da_thanh_toan') DEFAULT 'chua_thanh_toan',
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng Hóa Đơn
CREATE TABLE IF NOT EXISTS hoa_don (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_tra_cuu VARCHAR(50) NOT NULL UNIQUE,
    ky_hieu VARCHAR(20) NOT NULL,
    so_hoa_don VARCHAR(20) NOT NULL,
    ngay_lap DATETIME NOT NULL,
    tong_tien DECIMAL(15,2) NOT NULL,
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng Hồ Sơ Sức Khỏe
CREATE TABLE IF NOT EXISTS ho_so_suc_khoe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pid VARCHAR(50) NOT NULL UNIQUE,
    ho_ten VARCHAR(150) NOT NULL,
    nhom_mau VARCHAR(10),
    chi_tiet JSON NOT NULL,
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng Cận Lâm Sàng
CREATE TABLE IF NOT EXISTS can_lam_sang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_phieu VARCHAR(50) NOT NULL UNIQUE,
    ten_benh_nhan VARCHAR(150) NOT NULL,
    ket_qua JSON NOT NULL,
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Xóa dữ liệu cũ nếu chạy lại (để test)
TRUNCATE TABLE vien_phi;
TRUNCATE TABLE hoa_don;
TRUNCATE TABLE ho_so_suc_khoe;
TRUNCATE TABLE can_lam_sang;

-- Chèn dữ liệu mẫu (Seeding)
INSERT INTO vien_phi (ma_ho_so, ten_benh_nhan, noi_dung, tong_tien, trang_thai) VALUES 
('HS-123456', 'Nguyễn Văn Minh', 'Khám tổng quát & Siêu âm 4D', 850000, 'chua_thanh_toan'),
('HS-999999', 'Trần Thị Thu', 'Nội soi dạ dày', 1200000, 'da_thanh_toan');

INSERT INTO hoa_don (ma_tra_cuu, ky_hieu, so_hoa_don, ngay_lap, tong_tien) VALUES 
('VAT-888', '1C26TNN', '0001234', '2026-04-14 08:30:00', 250000);

INSERT INTO ho_so_suc_khoe (pid, ho_ten, nhom_mau, chi_tiet) VALUES 
('PID-987654321', 'Lê Bệnh Nhân', 'O+', '[
    {"ngay": "2026-03-12", "tieu_de": "Khám định kỳ tổng quát", "chan_doan": "Sức khỏe bình thường, đường huyết hơi cao.", "bac_si": "Trần Y Khoa"},
    {"ngay": "2025-01-05", "tieu_de": "Nội soi dạ dày", "chan_doan": "Viêm loét dạ dày nhẹ.", "bac_si": "Lê Tiêu Hóa"}
]');

INSERT INTO can_lam_sang (ma_phieu, ten_benh_nhan, ket_qua) VALUES 
('CLS-2026', 'Phạm Quỳnh', '[
    {"ten_xet_nghiem": "Xét nghiệm Máu Tổng Quát", "trang_thai": "da_co_ket_qua"},
    {"ten_xet_nghiem": "Siêu Âm Ổ Bụng Dưới", "trang_thai": "dang_phan_tich"}
]');
