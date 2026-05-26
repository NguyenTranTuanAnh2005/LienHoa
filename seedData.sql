USE smart_hospital;

-- Xóa dữ liệu cũ
TRUNCATE TABLE vien_phi;
TRUNCATE TABLE hoa_don;
TRUNCATE TABLE ho_so_suc_khoe;
TRUNCATE TABLE can_lam_sang;

-- 10 Bản ghi Bảng Viện Phí
INSERT INTO vien_phi (ma_ho_so, ten_benh_nhan, noi_dung, tong_tien, trang_thai) VALUES 
('HS-100001', 'Nguyễn Văn A', 'Khám nội, Xét nghiệm máu', 650000, 'chua_thanh_toan'),
('HS-100002', 'Trần Thị B', 'Nội soi dạ dày, Khám tiêu hóa', 1200000, 'chua_thanh_toan'),
('HS-100003', 'Lê Văn C', 'Khám tai mũi họng', 250000, 'da_thanh_toan'),
('HS-100004', 'Phạm Thị D', 'Siêu âm thai 4D, Khám sản', 850000, 'chua_thanh_toan'),
('HS-100005', 'Hoàng Văn E', 'Khám cơ xương khớp, X-Quang', 750000, 'da_thanh_toan'),
('HS-100006', 'Vũ Thị F', 'Khám tổng quát VIP', 3500000, 'chua_thanh_toan'),
('HS-100007', 'Ngô Văn G', 'Khám mắt, Đo khúc xạ', 450000, 'da_thanh_toan'),
('HS-100008', 'Đỗ Thị H', 'Khám nhi, Tư vấn tiêm chủng', 300000, 'chua_thanh_toan'),
('HS-100009', 'Lý Văn I', 'Khám tim mạch, Điện tâm đồ', 950000, 'chua_thanh_toan'),
('HS-100010', 'Bùi Thị K', 'Khám da liễu', 200000, 'da_thanh_toan');

-- 10 Bản ghi Hóa Đơn Điện Tử
INSERT INTO hoa_don (ma_tra_cuu, ky_hieu, so_hoa_don, ngay_lap, tong_tien) VALUES 
('VAT-101', '1C26TNN', '0001001', '2026-04-10 08:15:00', 650000),
('VAT-102', '1C26TNN', '0001002', '2026-04-11 09:30:00', 1200000),
('VAT-103', '1C26TNN', '0001003', '2026-04-11 10:45:00', 250000),
('VAT-104', '1C26TNN', '0001004', '2026-04-12 14:20:00', 850000),
('VAT-105', '1C26TNN', '0001005', '2026-04-12 15:10:00', 750000),
('VAT-106', '1C26TNN', '0001006', '2026-04-13 08:00:00', 3500000),
('VAT-107', '1C26TNN', '0001007', '2026-04-13 09:25:00', 450000),
('VAT-108', '1C26TNN', '0001008', '2026-04-13 13:40:00', 300000),
('VAT-109', '1C26TNN', '0001009', '2026-04-14 07:50:00', 950000),
('VAT-110', '1C26TNN', '0001010', '2026-04-14 10:15:00', 200000);

-- 10 Bản ghi Hồ Sơ Sức Khỏe
INSERT INTO ho_so_suc_khoe (pid, ho_ten, nhom_mau, chi_tiet) VALUES 
('PID-001', 'Nguyễn Văn A', 'A+', '[{"ngay": "2026-01-10", "tieu_de": "Khám nội", "chan_doan": "Viêm họng cấp", "bac_si": "BS. Hùng"}]'),
('PID-002', 'Trần Thị B', 'O+', '[{"ngay": "2026-02-15", "tieu_de": "Nội soi dạ dày", "chan_doan": "Loét dạ dày", "bac_si": "BS. Lan"}]'),
('PID-003', 'Lê Văn C', 'B+', '[{"ngay": "2025-11-20", "tieu_de": "Khám mắt", "chan_doan": "Cận thị", "bac_si": "BS. Minh"}]'),
('PID-004', 'Phạm Thị D', 'AB+', '[{"ngay": "2026-03-05", "tieu_de": "Khám thai", "chan_doan": "Thai 12 tuần khỏe", "bac_si": "BS. Hương"}]'),
('PID-005', 'Hoàng Văn E', 'O-', '[{"ngay": "2026-04-01", "tieu_de": "Khám khớp", "chan_doan": "Thoái hóa khớp gối", "bac_si": "BS. Tuấn"}]'),
('PID-006', 'Vũ Thị F', 'A-', '[{"ngay": "2025-08-12", "tieu_de": "Khám da liễu", "chan_doan": "Viêm da cơ địa", "bac_si": "BS. Trang"}]'),
('PID-007', 'Ngô Văn G', 'B-', '[{"ngay": "2026-02-28", "tieu_de": "Khám tim mạch", "chan_doan": "Cao huyết áp", "bac_si": "BS. Kiên"}]'),
('PID-008', 'Đỗ Thị H', 'AB-', '[{"ngay": "2026-04-10", "tieu_de": "Khám nhi", "chan_doan": "Sốt virus", "bac_si": "BS. Thảo"}]'),
('PID-009', 'Lý Văn I', 'O+', '[{"ngay": "2025-12-18", "tieu_de": "Chụp X-quang", "chan_doan": "Gãy xương sườn", "bac_si": "BS. Nam"}]'),
('PID-010', 'Bùi Thị K', 'A+', '[{"ngay": "2026-01-25", "tieu_de": "Khám nha khoa", "chan_doan": "Sâu răng", "bac_si": "BS. Việt"}]');

-- 10 Bản ghi Kết Quả Cận Lâm Sàng
INSERT INTO can_lam_sang (ma_phieu, ten_benh_nhan, ket_qua) VALUES 
('CLS-001', 'Nguyễn Văn A', '[{"ten_xet_nghiem": "Xét nghiệm máu sinh hóa", "trang_thai": "da_co_ket_qua"}]'),
('CLS-002', 'Trần Thị B', '[{"ten_xet_nghiem": "Nội soi dạ dày", "trang_thai": "dang_phan_tich"}]'),
('CLS-003', 'Lê Văn C', '[{"ten_xet_nghiem": "Đo khúc xạ mắt", "trang_thai": "da_co_ket_qua"}]'),
('CLS-004', 'Phạm Thị D', '[{"ten_xet_nghiem": "Siêu âm thai 4D", "trang_thai": "da_co_ket_qua"}]'),
('CLS-005', 'Hoàng Văn E', '[{"ten_xet_nghiem": "X-Quang khớp gối", "trang_thai": "dang_phan_tich"}]'),
('CLS-006', 'Vũ Thị F', '[{"ten_xet_nghiem": "Xét nghiệm dị ứng", "trang_thai": "da_co_ket_qua"}]'),
('CLS-007', 'Ngô Văn G', '[{"ten_xet_nghiem": "Điện tâm đồ", "trang_thai": "dang_phan_tich"}]'),
('CLS-008', 'Đỗ Thị H', '[{"ten_xet_nghiem": "Test nhanh cúm", "trang_thai": "da_co_ket_qua"}]'),
('CLS-009', 'Lý Văn I', '[{"ten_xet_nghiem": "Chụp MRI sườn", "trang_thai": "da_co_ket_qua"}]'),
('CLS-010', 'Bùi Thị K', '[{"ten_xet_nghiem": "Chụp X-Quang Răng cấm", "trang_thai": "dang_phan_tich"}]');
