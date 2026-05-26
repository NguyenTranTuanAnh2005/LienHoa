USE smart_hospital;

TRUNCATE TABLE goi_kham;

INSERT INTO `goi_kham` (`ten_goi`, `gia_tien`, `mo_ta`) VALUES
('Gói Khám Tổng Quát Cơ Bản', 1500000.00, 'Bao gồm khám lâm sàng tổng quát, xét nghiệm máu cơ bản, X-Quang phổi và siêu âm bụng tổng quát.'),
('Gói Tầm Soát Ung Thư Nữ', 3500000.00, 'Tầm soát chuyên sâu ung thư hình thái các bệnh lý phổ biến ở nữ giới (vú, tử cung, tuyến giáp).'),
('Gói Tầm Soát Ung Thư Nam', 3200000.00, 'Tầm soát sớm ung thư và các bệnh lý đặc trưng phổ biến ở nam giới (gan, dạ dày, tuyến tiền liệt).'),
('Gói Khám Sức Khỏe Tiền Hôn Nhân', 2500000.00, 'Tầm soát các bệnh lý lây truyền qua đường tình dục và đánh giá chức năng sinh sản cơ bản.'),
('Gói Chăm Sóc Nha Khoa Toàn Diện', 800000.00, 'Khám tổng quát răng miệng, cạo vôi răng, đánh bóng và tư vấn thẩm mỹ nha khoa chuyên sâu.');
