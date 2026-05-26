-- 1. Khởi tạo Database
DROP DATABASE IF EXISTS smart_hospital;
CREATE DATABASE smart_hospital CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE smart_hospital;

-- ================= CẤU TRÚC BẢNG =================

-- Bảng Chuyên Khoa
CREATE TABLE IF NOT EXISTS chuyen_khoa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_khoa VARCHAR(100) NOT NULL,
    mo_ta TEXT
) ENGINE=InnoDB;

-- Bảng Bác Sĩ
CREATE TABLE IF NOT EXISTS bac_si (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ho_ten VARCHAR(100) NOT NULL,
    id_chuyen_khoa INT NOT NULL,
    hinh_anh VARCHAR(255),
    tieu_su TEXT,
    FOREIGN KEY (id_chuyen_khoa) REFERENCES chuyen_khoa(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Bảng Gói Khám
CREATE TABLE IF NOT EXISTS goi_kham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_goi VARCHAR(255) NOT NULL,
    gia_tien DECIMAL(15,2) NOT NULL, -- Cột này ĐÃ CÓ trong bảng
    mo_ta TEXT,
    hinh_anh VARCHAR(255) DEFAULT 'default_pkg.jpg'
) ENGINE=InnoDB;

-- Bảng Đặt Lịch (Đã sửa lỗi thiếu cột id_bac_si và bổ sung đầy đủ trường)
CREATE TABLE IF NOT EXISTS dat_lich (
    id INT AUTO_INCREMENT PRIMARY KEY,

    ma_benh_nhan VARCHAR(50),

    ten_benh_nhan VARCHAR(255) NOT NULL,
    so_dien_thoai VARCHAR(20) NOT NULL,
    email VARCHAR(255),

    ngay_sinh DATE,
    gioi_tinh VARCHAR(10),

    dia_chi TEXT,
    cccd VARCHAR(20),

    co_so_kham VARCHAR(255),

    chuyen_khoa VARCHAR(255),

    ten_goi_kham VARCHAR(255),
    id_goi_kham INT,

    id_bac_si INT,

    ngay_hen DATETIME NOT NULL,

    ghi_chu TEXT,

    thanh_toan ENUM(
        'Chưa thanh toán',
        'Đã thanh toán'
    ) DEFAULT 'Chưa thanh toán',

    trang_thai ENUM(
        'dang_cho',
        'da_xac_nhan',
        'hoan_thanh',
        'da_huy'
    ) DEFAULT 'dang_cho',

    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_goi_kham)
        REFERENCES goi_kham(id)
        ON DELETE SET NULL,

    FOREIGN KEY (id_bac_si)
        REFERENCES bac_si(id)
        ON DELETE SET NULL

) ENGINE=InnoDB;

-- Bảng Tin Tức & Thông Báo
CREATE TABLE IF NOT EXISTS notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    summary TEXT,
    content LONGTEXT,
    image VARCHAR(255),
    category VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_notices_slug (slug)
) ENGINE=InnoDB;

-- Bảng Bệnh Nhân
CREATE TABLE IF NOT EXISTS patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_code VARCHAR(50) UNIQUE,
    full_name VARCHAR(150),
    gender VARCHAR(10),
    birthday DATE,
    phone VARCHAR(20),
    address TEXT,
    email VARCHAR(255),
    cccd VARCHAR(20),
    diagnosis VARCHAR(255),
    status VARCHAR(50) DEFAULT NULL
) ENGINE=InnoDB;

-- Bảng Tài Khoản Người Dùng (Sử dụng password hash)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- Chứa chuỗi mã hóa
    full_name VARCHAR(150),
    role ENUM('admin', 'user') DEFAULT 'user',
    patient_id INT,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Bảng Hóa Đơn & Viện Phí
CREATE TABLE IF NOT EXISTS hoa_don (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_benh_nhan VARCHAR(50),
    tong_tien DECIMAL(15,2),
    trang_thai ENUM('chua_thanh_toan', 'da_thanh_toan') DEFAULT 'chua_thanh_toan',
    ma_tra_cuu VARCHAR(50) UNIQUE,
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS vien_phi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_benh_nhan VARCHAR(20),
    ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
    noi_dung_vien_phi TEXT,
    tong_tien DECIMAL(15,2),
    trang_thai VARCHAR(50)
) ENGINE=InnoDB;

-- Bảng Hồ Sơ Sức Khỏe
CREATE TABLE IF NOT EXISTS ho_so_suc_khoe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_benh_nhan VARCHAR(20),
    ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
    noi_dung_suc_khoe TEXT,
    chan_doan TEXT,
    ghi_chu TEXT
) ENGINE=InnoDB;

-- Bảng Cận Lâm Sàng
CREATE TABLE IF NOT EXISTS can_lam_sang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_benh_nhan VARCHAR(20),
    ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
    loai_xet_nghiem VARCHAR(255),
    noi_dung_can_lam_sang TEXT,
    ket_qua TEXT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS hospitalizations (
    id INT AUTO_INCREMENT PRIMARY KEY,

    patient_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,

    cccd VARCHAR(20),

    patient_id VARCHAR(50),

    department VARCHAR(100) NOT NULL,

    reason TEXT,

    admission_date DATE NOT NULL,

    room_type VARCHAR(50),

    thanh_toan ENUM(
        'Chưa thanh toán',
        'Đã thanh toán'
    ) DEFAULT 'Chưa thanh toán',

    status VARCHAR(50) DEFAULT 'Waiting',
	tong_tien DECIMAL(15,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS lab_tests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(20) NOT NULL,
    patient_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    cccd VARCHAR(20),
    patient_id VARCHAR(50),
    test_type VARCHAR(100) NOT NULL,
    sample_date DATE NOT NULL,
    notes TEXT,
    tong_tien INT DEFAULT 0, -- Thêm cột này để khớp với Controller
    status VARCHAR(50) DEFAULT 'pending',
    thanh_toan VARCHAR(50) DEFAULT 'Chưa thanh toán',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- ================= DỮ LIỆU MẪU (DATA) =================

-- 1. Chèn Chuyên khoa
INSERT INTO chuyen_khoa (ten_khoa, mo_ta) VALUES  
('Khoa Ngoại Tổng Quát', 'Khám, chẩn đoán và điều trị ngoại khoa (phẫu thuật) các bệnh lý ổ bụng, tiêu hóa và lồng ngực.'),
('Khoa Tim Mạch', 'Tầm soát, chẩn đoán và điều trị nội khoa các bệnh lý liên quan đến tim và mạch máu.'),
('Khoa Ngoại', 'Khám, phẫu thuật và điều trị các chấn thương, bệnh lý cần can thiệp ngoại khoa kỹ thuật cao.'),
('Khoa Nhi', 'Khám, chữa bệnh, chủng ngừa và chăm sóc sức khỏe chuyên sâu cho trẻ sơ sinh và trẻ em.'),
('Thần Kinh', 'Chăm sóc, khám và điều trị chuyên sâu các bệnh lý về não bộ, tủy sống và hệ thần kinh.'),
('Khoa Ung Bướu', 'Cung cấp các dịch vụ tầm soát, chẩn đoán sớm và phác đồ điều trị ung thư đa mô thức tiên tiến.');

-- 2. Chèn Bác Sĩ
INSERT INTO bac_si (ho_ten, id_chuyen_khoa, hinh_anh, tieu_su) VALUES  
('Nguyễn Văn An', 1, 'doctor_nguyen_van_an.png', 'Chuyên gia với hơn 15 năm kinh nghiệm trong lĩnh vực phẫu thuật tim mạch và lồng ngực.'),
('Lê Minh Tâm', 2, 'doctor_le_minh_tam.png', 'Thạc sĩ, Bác sĩ Nhi khoa tận tâm, đạt nhiều bằng khen ưu tú trong công tác chăm sóc sức khỏe trẻ em.'),
('Phạm Quang Khải', 3, 'doctor_pham_quang_khai.png', 'Chuyên gia Nội tiết xuất sắc, nguyên tu nghiệp chuyên sâu tại Cộng hòa Pháp.'),
('Trần Thanh Bình', 4, 'doctor_tran_thanh_binh.png', 'Bác sĩ Chuyên khoa Tiêu hóa, tiên phong ứng dụng công nghệ nội soi không đau trong chẩn đoán.'),
('Lê Quang Hải', 5, 'doctor_le_quang_hai.png', 'Chuyên gia Phục hình răng và Chỉnh nha thẩm mỹ cao cấp, thành viên Hội Răng Hàm Mặt Việt Nam.'),
('Nguyễn Thị Trang', 6, 'doctor_nguyen_thi_trang.png', 'Bác sĩ chuyên khoa Ung bướu, chuyên tầm soát, chẩn đoán sớm và xây dựng phác đồ điều trị đa mô thức tiên tiến.');
 
 SELECT * FROM bac_si;
-- 3. Chèn Gói Khám
INSERT INTO goi_kham (ten_goi, gia_tien, mo_ta, hinh_anh) VALUES 
('Gói Khám Tổng Quát Cơ Bản', 1500000.00, 'Bao gồm khám lâm sàng tổng quát, xét nghiệm máu cơ bản...', 'pkg_basic.jpg'),
('Gói Tầm Soát Ung Thư Nữ', 3500000.00, 'Tầm soát chuyên sâu đánh giá các bệnh ung thư phổ biến...', 'pkg_female.jpg'),
('Gói Tầm Soát Ung Thư Nam', 3200000.00, 'Tầm soát sớm ung thư và các bệnh lý nội tạng phổ biến...', 'pkg_male.jpg'),
('Gói Khám Sức Khỏe Tiền Hôn Nhân', 2500000.00, 'Khám tổng quát, đánh giá sức khoẻ sinh sản...', 'pkg_wedding.jpg'),
('Gói Chăm Sóc Nha Khoa Toàn Diện', 800000.00, 'Lấy cao răng siêu âm, đánh bóng...', 'pkg_dental.jpg'),
('Gói khám tổng quát Nam', 2000000.00, 'Chủ động phòng bệnh, sống khỏe trọn vẹn...', 'pkg_nam.jpg'),
('Gói khám tiền sản', 1800000.00, 'Chuẩn bị hành trang thai kỳ khỏe mạnh...', 'pkg_tiensan.jpg'),
('Gói sinh', 15000000.00, 'Gửi trọn yêu thương, vượt cạn an toàn...', 'pkg_sinh.jpg'),
('Gói khám tổng quát Nhi', 1200000.00, 'Chăm sóc toàn diện cho con tương lai khỏe mạnh.', 'pkg_nhi.jpg');

-- 4. Chèn Đặt lịch (Fix lỗi dữ liệu khớp với cấu trúc mới)
INSERT INTO dat_lich (ten_benh_nhan, so_dien_thoai, id_bac_si, ngay_hen, trang_thai, ghi_chu, id_goi_kham) VALUES
-- Tháng 1 - Tháng 3
('Nguyễn Văn Nam', '0901111001', 1, '2026-01-10 08:00:00', 'hoan_thanh', 'Khám tổng quát', 1),
('Trần Thị Lan', '0901111002', 2, '2026-02-15 09:30:00', 'hoan_thanh', 'Tầm soát ung thư', 2),
('Lê Hoàng Anh', '0901111003', 3, '2026-03-05 10:00:00', 'hoan_thanh', 'Khám nội tiết', 3),
('Phạm Minh Tú', '0901111004', 1, '2026-03-20 14:00:00', 'da_xac_nhan', 'Tư vấn định kỳ', 1),

-- Tháng 4 - Tháng 6
('Hoàng Văn Hùng', '0901111005', 4, '2026-04-12 08:30:00', 'hoan_thanh', 'Nội soi dạ dày', NULL),
('Đặng Thị Thắm', '0901111006', 5, '2026-04-18 09:00:00', 'da_xac_nhan', 'Khám nha khoa', 5),
('Bùi Văn Quý', '0901111007', 2, '2026-05-10 11:00:00', 'hoan_thanh', 'Khám nhi', 9),
('Vũ Thị Mai', '0901111008', 6, '2026-05-22 15:00:00', 'hoan_thanh', 'Tầm soát ung thư nữ', 2),
('Nguyễn Văn Tuấn', '0901111009', 3, '2026-06-05 08:00:00', 'hoan_thanh', 'Khám tổng quát nam', 6),
('Lê Thị Hạnh', '0901111010', 4, '2026-06-15 10:30:00', 'da_xac_nhan', 'Khám tiền sản', 7),

-- Tháng 7 - Tháng 9
('Trần Văn Bình', '0901111011', 1, '2026-07-08 09:00:00', 'hoan_thanh', 'Khám tim mạch', NULL),
('Ngô Thị Nga', '0901111012', 2, '2026-07-25 14:00:00', 'hoan_thanh', 'Gói sinh', 8),
('Đỗ Văn Dũng', '0901111013', 3, '2026-08-05 08:00:00', 'hoan_thanh', 'Khám sức khỏe', 1),
('Phan Thị Ngọc', '0901111014', 5, '2026-08-28 09:30:00', 'da_xac_nhan', 'Nha khoa', 5),
('Đặng Văn Quang', '0901111015', 6, '2026-09-02 10:00:00', 'hoan_thanh', 'Tầm soát ung thư', 3),
('Lý Thị Sen', '0901111016', 4, '2026-09-20 11:00:00', 'hoan_thanh', 'Khám tổng quát', 1),

-- Tháng 10 - Tháng 12
('Nguyễn Văn Tiến', '0901111017', 1, '2026-10-10 09:00:00', 'hoan_thanh', 'Khám tổng quát', 1),
('Trịnh Thị Liên', '0901111018', 2, '2026-10-25 14:30:00', 'da_xac_nhan', 'Tầm soát nữ', 2),
('Mai Văn Thắng', '0901111019', 3, '2026-11-05 08:00:00', 'hoan_thanh', 'Khám nội tiết', 3),
('Lưu Thị Lệ', '0901111020', 5, '2026-11-18 09:00:00', 'hoan_thanh', 'Nha khoa', 5),
('Nguyễn Văn Lộc', '0901111021', 6, '2026-12-01 10:00:00', 'hoan_thanh', 'Tầm soát nam', 3),
('Đoàn Thị Hồng', '0901111022', 4, '2026-12-10 11:30:00', 'hoan_thanh', 'Khám tiền hôn nhân', 4),
('Trần Văn Phúc', '0901111023', 1, '2026-12-15 08:00:00', 'da_xac_nhan', 'Khám tổng quát', 1),
('Lê Văn Lộc', '0901111024', 2, '2026-12-20 09:00:00', 'hoan_thanh', 'Khám nhi', 9),
('Phạm Thị Thu', '0901111025', 3, '2026-12-28 10:00:00', 'da_xac_nhan', 'Tư vấn sức khỏe', 6);

-- 5. Chèn Tin Tức
INSERT INTO notices (title, slug, summary, content, image, category) VALUES
('Phòng chống bệnh Sốt xuất huyết từ Bộ Y tế', 'Thong-bao-phong-chong-benh', 'Hướng dẫn phòng chống', '<p>Khoa Cấp cứu vẫn hoạt động 24/7.</p>', 'le-30-4.jpg', 'Kiến thức'),
('Ưu đãi Gói khám tổng quát', 'uu-dai-goi-kham-tong-quat', 'Giảm ngay 20% cho khách hàng...', '<p>Áp dụng khi đặt lịch online.</p>', 'khuyen-mai.jpg', 'Khuyến mãi');

INSERT INTO patients (patient_code, full_name, gender, birthday, phone, address, cccd, diagnosis) VALUES 
('BN2026001', 'Nguyễn Văn A', 'Nam', '1990-05-15', '0901234567', 'TP. Hồ Chí Minh', '079123456789', 'Cao huyết áp'),
('BN2026004', 'Trần Thị Bích', 'Nữ', '1985-03-12', '0912345678', 'Quận 1, TP.HCM', '079123456781', 'Viêm dạ dày'),
('BN2026005', 'Lê Văn Cường', 'Nam', '1992-07-25', '0908765432', 'Quận 3, TP.HCM', '079123456782', 'Đau thắt lưng'),
('BN2026006', 'Phạm Minh Tú', 'Nam', '2000-11-02', '0934567890', 'Quận 7, TP.HCM', '079123456783', 'Cảm cúm thông thường'),
('BN2026007', 'Nguyễn Hoàng Lan', 'Nữ', '1978-05-18', '0987654321', 'Quận 5, TP.HCM', '079123456784', 'Tiểu đường'),
('BN2026008', 'Đỗ Thanh Phong', 'Nam', '1995-09-30', '0965432109', 'TP. Thủ Đức', '079123456785', 'Viêm xoang'),
('BN2026009', 'Hoàng Thị Mai', 'Nữ', '1988-12-15', '0943210987', 'Quận Bình Thạnh', '079123456786', 'Thiếu máu nhẹ'),
('BN2026010', 'Bùi Văn Dũng', 'Nam', '1999-02-28', '0978901234', 'Quận 10, TP.HCM', '079123456787', 'Rối loạn tiền đình');
-- 6. Tài khoản Admin mẫu (Mật khẩu '123456' đã được mã hóa)
INSERT INTO users (username, password, full_name, role) VALUES 
('admin', '$2y$10$4A4tT.7OFhB8FYzmLB/4PeHJ4VfzR46Ox.NRlnRuLreOubCaiAOvy', 'Quản trị viên', 'admin');

-- Tài khoản Bệnh nhân test (Mật khẩu '123456' đã được mã hóa)
INSERT INTO users (username, password, full_name, role, patient_id) VALUES 
('0901234567', '$2y$10$4A4tT.7OFhB8FYzmLB/4PeHJ4VfzR46Ox.NRlnRuLreOubCaiAOvy', 'Nguyễn Văn A', 'user', 1);
-- 7. Bệnh nhân & Hóa đơn test

INSERT INTO hoa_don (ma_benh_nhan, tong_tien, trang_thai, ma_tra_cuu) VALUES
('BN2026001', 850000, 'chua_thanh_toan', 'HD-2026-0001');

INSERT INTO vien_phi (ma_benh_nhan, noi_dung_vien_phi, tong_tien, trang_thai, ngay_tao) VALUES
('BN2026001', 'Khám nội + Xét nghiệm máu', 850000.00, 'da_thanh_toan', '2026-01-10 09:00:00'),
('BN2026002', 'Siêu âm ổ bụng', 500000.00, 'da_thanh_toan', '2026-01-25 10:30:00'),
('BN2026003', 'Tiền giường phòng thường', 1200000.00, 'da_thanh_toan', '2026-02-12 14:00:00'),
('BN2026004', 'Xét nghiệm sinh hóa', 650000.00, 'da_thanh_toan', '2026-02-28 08:00:00'),
('BN2026005', 'Khám tim mạch chuyên sâu', 1500000.00, 'da_thanh_toan', '2026-03-15 09:15:00'),
('BN2026006', 'Phẫu thuật ngoại khoa', 5500000.00, 'da_thanh_toan', '2026-03-20 11:00:00'),
('BN2026007', 'Tiền khám tổng quát', 900000.00, 'da_thanh_toan', '2026-04-05 08:30:00'),
('BN2026008', 'Chụp X-quang phổi', 450000.00, 'da_thanh_toan', '2026-04-18 10:00:00'),
('BN2026009', 'Dịch vụ sinh con trọn gói', 8900000.00, 'da_thanh_toan', '2026-05-02 14:30:00'),
('BN2026010', 'Xét nghiệm máu + nước tiểu', 750000.00, 'da_thanh_toan', '2026-05-20 09:00:00'),
('BN2026011', 'Tiền giường phòng VIP', 4000000.00, 'da_thanh_toan', '2026-06-01 15:00:00');

INSERT INTO hospitalizations (
    patient_name, phone, cccd, patient_id, department, reason, 
    admission_date, room_type, status, thanh_toan, tong_tien
) VALUES
('Nguyễn Văn A', '0901234567', '079201000001', 'BN001', 'Nội tổng quát', 'Đau bụng', '2026-01-05', 'Phòng thường', 'Completed', 'Đã thanh toán', 1200000.00),
('Trần Thị B', '0912345678', '079201000002', 'BN002', 'Tim mạch', 'Đau ngực', '2026-01-20', 'Phòng VIP', 'Completed', 'Đã thanh toán', 5500000.00),
('Lê Văn C', '0987654321', '079201000003', 'BN003', 'Ngoại khoa', 'Gãy tay', '2026-02-10', 'Phòng đôi', 'Completed', 'Đã thanh toán', 3200000.00),
('Phạm Thị D', '0978123456', '079201000004', 'BN004', 'Sản khoa', 'Chuyển dạ', '2026-02-25', 'Phòng riêng', 'Completed', 'Đã thanh toán', 8900000.00),
('Hoàng Văn E', '0911111111', '079201000005', 'BN005', 'Nội khoa', 'Sốt cao', '2026-03-05', 'Phòng thường', 'Completed', 'Đã thanh toán', 1500000.00),
('Đặng Thị F', '0922222222', '079201000006', 'BN006', 'Thần kinh', 'Đau đầu', '2026-03-15', 'Phòng đôi', 'Completed', 'Đã thanh toán', 2500000.00),
('Bùi Văn G', '0933333333', '079201000007', 'BN007', 'Ngoại khoa', 'Viêm ruột thừa', '2026-04-02', 'Phòng VIP', 'Completed', 'Đã thanh toán', 6000000.00),
('Vũ Thị H', '0944444444', '079201000008', 'BN008', 'Nội khoa', 'Tiểu đường', '2026-04-20', 'Phòng thường', 'Completed', 'Đã thanh toán', 2000000.00),
('Ngô Văn I', '0955555555', '079201000009', 'BN009', 'Tim mạch', 'Huyết áp', '2026-05-10', 'Phòng riêng', 'Completed', 'Đã thanh toán', 3500000.00),
('Lý Thị K', '0966666666', '079201000010', 'BN010', 'Sản khoa', 'Kiểm tra thai', '2026-05-25', 'Phòng đôi', 'Completed', 'Đã thanh toán', 1800000.00),
('Đỗ Văn L', '0977777777', '079201000011', 'BN011', 'Nội khoa', 'Viêm phổi', '2026-06-05', 'Phòng thường', 'Completed', 'Đã thanh toán', 2800000.00),
('Phan Thị M', '0988888888', '079201000012', 'BN012', 'Ngoại khoa', 'Chấn thương', '2026-07-15', 'Phòng VIP', 'Completed', 'Đã thanh toán', 7500000.00),
('Đặng Văn N', '0999999999', '079201000013', 'BN013', 'Thần kinh', 'Mất ngủ', '2026-07-28', 'Phòng đơn', 'Completed', 'Đã thanh toán', 2200000.00),
('Trịnh Thị O', '0901231231', '079201000014', 'BN014', 'Nội khoa', 'Dạ dày', '2026-08-10', 'Phòng thường', 'Completed', 'Đã thanh toán', 1900000.00),
('Mai Văn P', '0901231232', '079201000015', 'BN015', 'Tim mạch', 'Nhịp tim nhanh', '2026-09-05', 'Phòng VIP', 'Completed', 'Đã thanh toán', 4500000.00),
('Lưu Thị Q', '0901231233', '079201000016', 'BN016', 'Sản khoa', 'Tư vấn sinh', '2026-09-20', 'Phòng riêng', 'Completed', 'Đã thanh toán', 9500000.00),
('Nguyễn Văn R', '0901231234', '079201000017', 'BN017', 'Ngoại khoa', 'Gãy xương', '2026-10-12', 'Phòng đôi', 'Completed', 'Đã thanh toán', 3800000.00),
('Trần Thị S', '0901231235', '079201000018', 'BN018', 'Nội khoa', 'Sốt xuất huyết', '2026-11-05', 'Phòng thường', 'Completed', 'Đã thanh toán', 1700000.00),
('Lê Văn T', '0901231236', '079201000019', 'BN019', 'Thần kinh', 'Chóng mặt', '2026-11-25', 'Phòng đơn', 'Completed', 'Đã thanh toán', 2100000.00),
('Phạm Thị U', '0901231237', '079201000020', 'BN020', 'Ngoại khoa', 'Tiểu phẫu', '2026-12-10', 'Phòng thường', 'Completed', 'Đã thanh toán', 1500000.00);

INSERT INTO lab_tests (user_id, patient_name, test_type, sample_date, notes, status) VALUES 
('BN2026001', 'Nguyễn Văn A', 'Xét nghiệm huyết học', '2026-05-25', 'Kiểm tra định kỳ', 'pending'),
('BN2026002', 'Trần Thị B', 'Xét nghiệm sinh hóa', '2026-05-26', 'Theo chỉ định bác sĩ', 'pending'),
('BN2026003', 'Lê Văn C', 'Xét nghiệm miễn dịch', '2026-05-27', 'Kiểm tra dị ứng', 'pending'),
('BN2026004', 'Trịnh Thị K', 'Nội soi dạ dày', '2026-05-27', 'Đau thượng vị', 'pending'),
('BN2026005', 'Phạm Văn D', 'Xét nghiệm nước tiểu', '2026-05-28', 'Kiểm tra định kỳ', 'pending'),
('BN2026006', 'Hoàng Thị E', 'Siêu âm ổ bụng', '2026-05-28', 'Đau bụng âm ỉ', 'pending'),
('BN2026007', 'Đặng Văn F', 'Chụp X-Quang phổi', '2026-05-29', 'Kiểm tra sức khỏe lao động', 'pending'),
('BN2026008', 'Ngô Thị G', 'Xét nghiệm đường huyết', '2026-05-29', 'Theo dõi tiền tiểu đường', 'pending'),
('BN2026009', 'Lý Văn H', 'Điện tâm đồ (ECG)', '2026-05-30', 'Kiểm tra định kỳ', 'pending'),
('BN2026011', 'Vũ Thị I', 'Xét nghiệm chức năng gan', '2026-05-30', 'Theo chỉ định bác sĩ', 'pending');

-- 8. Hồ sơ sức khỏe và Cận lâm sàng test cho BN2026001
INSERT INTO ho_so_suc_khoe (ma_benh_nhan, noi_dung_suc_khoe, chan_doan, ghi_chu) VALUES 
('BN2026001', 'Bệnh nhân có tiền sử huyết áp cao. Cần theo dõi định kỳ.', 'Tăng huyết áp vô căn, Viêm loét dạ dày', 'Hẹn tái khám sau 1 tháng.');

INSERT INTO can_lam_sang (ma_benh_nhan, loai_xet_nghiem, noi_dung_can_lam_sang, ket_qua) VALUES 
('BN2026001', 'Xét nghiệm & Siêu âm', 'Chỉ định siêu âm ổ bụng, xét nghiệm máu tổng quát', '[{"ten_xet_nghiem":"Siêu âm ổ bụng tổng quát","trang_thai":"da_co_ket_qua"},{"ten_xet_nghiem":"Xét nghiệm sinh hóa máu","trang_thai":"dang_cho_ket_qua"}]');