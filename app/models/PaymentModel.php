<?php

class PaymentModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findByCode($code)
    {
        // 1. Lấy thông tin cơ bản
        $query = "SELECT * FROM vien_phi WHERE ma_benh_nhan = :code LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            // Nếu không có trong vien_phi, thử tìm trong dat_lich
            $queryPatient = "SELECT ten_benh_nhan FROM dat_lich WHERE ma_benh_nhan = :code LIMIT 1";
            $stmtP = $this->conn->prepare($queryPatient);
            $stmtP->execute([':code' => $code]);
            $patient = $stmtP->fetch(PDO::FETCH_ASSOC);
            
            if ($patient) {
                $data = [
                    'ma_benh_nhan' => $code,
                    'ten_benh_nhan' => $patient['ten_benh_nhan'],
                    'trang_thai' => 'Đã thanh toán',
                    'tong_tien' => 0
                ];
            } else {
                return null;
            }
        }

        // 2. Xác định trạng thái thực tế bằng cách kiểm tra các dịch vụ chưa thanh toán
        // Sử dụng logic mới (không dùng vien_phi tĩnh nữa)
        $invoiceData = $this->getInvoiceData($code, 'Chưa thanh toán');
        
        if ($invoiceData && !empty($invoiceData['services'])) {
            $data['trang_thai'] = 'Chưa thanh toán';
            $data['tong_tien'] = $invoiceData['tong_tien'];
        } else {
            $data['trang_thai'] = 'Đã thanh toán';
        }

        return $data;
    }

    public function markAsPaid($code) {
        $sql = "UPDATE vien_phi SET trang_thai = 'Đã thanh toán' WHERE ma_benh_nhan = :code";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([':code' => $code]);

        // Đánh dấu các dịch vụ trong dat_lich và hospitalizations là đã thanh toán
        $this->conn->prepare("UPDATE dat_lich SET thanh_toan = 'Đã thanh toán' WHERE ma_benh_nhan = :code AND thanh_toan = 'Chưa thanh toán'")->execute([':code' => $code]);
        $this->conn->prepare("UPDATE hospitalizations SET thanh_toan = 'Đã thanh toán' WHERE patient_id = :code AND thanh_toan = 'Chưa thanh toán'")->execute([':code' => $code]);

        // Đánh dấu các dịch vụ xét nghiệm là đã thanh toán
        $this->conn->prepare("UPDATE lab_tests l LEFT JOIN users u ON CAST(l.user_id AS CHAR) COLLATE utf8mb4_general_ci = CAST(u.id AS CHAR) COLLATE utf8mb4_general_ci LEFT JOIN patients p ON u.patient_id = p.id SET l.thanh_toan = 'Đã thanh toán' WHERE (l.user_id = :code1 OR l.patient_id = :code2 OR p.patient_code = :code3) AND l.thanh_toan = 'Chưa thanh toán'")->execute([':code1' => $code, ':code2' => $code, ':code3' => $code]);

        return $result;
    }

    public function getInvoiceData($code, $status = 'Chưa thanh toán')
    {
        // 1. Get patient info from dat_lich
        $queryPatient = "SELECT ten_benh_nhan FROM dat_lich WHERE ma_benh_nhan = :code LIMIT 1";
        $stmtP = $this->conn->prepare($queryPatient);
        $stmtP->execute([':code' => $code]);
        $patient = $stmtP->fetch(PDO::FETCH_ASSOC);
        
        $patientName = $patient ? $patient['ten_benh_nhan'] : 'Khách hàng';

        $services = [];
        $totalPrice = 0;

        // 2. Fetch bookings from dat_lich
        if ($status === 'ALL') {
            $queryBookings = "SELECT d.*, g.gia_tien 
                              FROM dat_lich d 
                              LEFT JOIN goi_kham g ON d.id_goi_kham = g.id 
                              WHERE d.ma_benh_nhan = :code AND d.trang_thai != 'da_huy'";
            $stmtB = $this->conn->prepare($queryBookings);
            $stmtB->execute([':code' => $code]);
        } else {
            $queryBookings = "SELECT d.*, g.gia_tien 
                              FROM dat_lich d 
                              LEFT JOIN goi_kham g ON d.id_goi_kham = g.id 
                              WHERE d.ma_benh_nhan = :code AND d.thanh_toan = :status AND d.trang_thai != 'da_huy'";
            $stmtB = $this->conn->prepare($queryBookings);
            $stmtB->execute([':code' => $code, ':status' => $status]);
        }
        $bookings = $stmtB->fetchAll(PDO::FETCH_ASSOC);

        foreach ($bookings as $b) {
            if (!empty($b['id_goi_kham'])) {
                $price = (float)($b['gia_tien'] ?? 0);
                $services[] = [
                    'ten_dich_vu' => 'Gói khám: ' . $b['ten_goi_kham'],
                    'so_luong' => 1,
                    'don_gia' => $price,
                    'thanh_tien' => $price
                ];
                $totalPrice += $price;
            } else if (!empty($b['chuyen_khoa'])) {
                $price = 150000; // Default consultation fee
                $services[] = [
                    'ten_dich_vu' => 'Khám chuyên khoa: ' . $b['chuyen_khoa'],
                    'so_luong' => 1,
                    'don_gia' => $price,
                    'thanh_tien' => $price
                ];
                $totalPrice += $price;
            }
        }

        // 3. Add hospitalizations
        if ($status === 'ALL') {
            $queryHosp = "SELECT * FROM hospitalizations WHERE patient_id = :code AND LOWER(status) != 'cancelled' AND LOWER(status) != 'rejected'";
            $stmtH = $this->conn->prepare($queryHosp);
            $stmtH->execute([':code' => $code]);
        } else {
            $queryHosp = "SELECT * FROM hospitalizations WHERE patient_id = :code AND thanh_toan = :status AND LOWER(status) != 'cancelled' AND LOWER(status) != 'rejected'";
            $stmtH = $this->conn->prepare($queryHosp);
            $stmtH->execute([':code' => $code, ':status' => $status]);
        }
        $hospitalizations = $stmtH->fetchAll(PDO::FETCH_ASSOC);

        foreach ($hospitalizations as $h) {
            $price = (float)($h['tong_tien'] ?? 800000); // Lấy giá tiền từ CSDL
            $services[] = [
                'ten_dich_vu' => 'Đăng ký nhập viện: ' . $h['department'],
                'so_luong' => 1,
                'don_gia' => $price,
                'thanh_tien' => $price
            ];
            $totalPrice += $price;
        }

        // 4. Add lab tests
        if ($status === 'ALL') {
            $queryLab = "SELECT l.* FROM lab_tests l LEFT JOIN users u ON CAST(l.user_id AS CHAR) COLLATE utf8mb4_general_ci = CAST(u.id AS CHAR) COLLATE utf8mb4_general_ci LEFT JOIN patients p ON u.patient_id = p.id WHERE (l.user_id = :code1 OR l.patient_id = :code2 OR p.patient_code = :code3) AND LOWER(l.status) != 'cancelled' AND LOWER(l.status) != 'rejected'";
            $stmtL = $this->conn->prepare($queryLab);
            $stmtL->execute([':code1' => $code, ':code2' => $code, ':code3' => $code]);
        } else {
            $queryLab = "SELECT l.* FROM lab_tests l LEFT JOIN users u ON CAST(l.user_id AS CHAR) COLLATE utf8mb4_general_ci = CAST(u.id AS CHAR) COLLATE utf8mb4_general_ci LEFT JOIN patients p ON u.patient_id = p.id WHERE (l.user_id = :code1 OR l.patient_id = :code2 OR p.patient_code = :code3) AND l.thanh_toan = :status AND LOWER(l.status) != 'cancelled' AND LOWER(l.status) != 'rejected'";
            $stmtL = $this->conn->prepare($queryLab);
            $stmtL->execute([':code1' => $code, ':code2' => $code, ':code3' => $code, ':status' => $status]);
        }
        $labTests = $stmtL->fetchAll(PDO::FETCH_ASSOC);

        foreach ($labTests as $l) {
            $price = (float)($l['tong_tien'] ?? 300000);
            $services[] = [
                'ten_dich_vu' => 'Đăng ký xét nghiệm: ' . $l['test_type'],
                'so_luong' => 1,
                'don_gia' => $price,
                'thanh_tien' => $price
            ];
            $totalPrice += $price;
        }

        // Fallback for legacy tests if no services found
        if (empty($services)) {
            $queryVienPhi = "SELECT * FROM vien_phi WHERE ma_benh_nhan = :code LIMIT 1";
            $stmtV = $this->conn->prepare($queryVienPhi);
            $stmtV->execute([':code' => $code]);
            $vp = $stmtV->fetch(PDO::FETCH_ASSOC);

            if ($vp) {
                if ($status === 'ALL' || $vp['trang_thai'] === $status || ($status === 'Chưa thanh toán' && $vp['trang_thai'] !== 'Đã thanh toán')) {
                    $price = (float)($vp['tong_tien'] ?? 850000);
                    // Don't add a service if it's 0 and we only want unpaid
                    if ($price > 0 || $status === 'ALL') {
                        $services[] = [
                            'ten_dich_vu' => 'Khám tổng quát / Dịch vụ y tế (Dữ liệu cũ)',
                            'so_luong' => 1,
                            'don_gia' => $price,
                            'thanh_tien' => $price
                        ];
                        $totalPrice += $price;
                    }
                }
            } else {
                return null;
            }
        }

        // 4. Ensure vien_phi record exists for state tracking
        $checkVp = $this->conn->prepare("SELECT id FROM vien_phi WHERE ma_benh_nhan = :code");
        $checkVp->execute([':code' => $code]);
        if (!$checkVp->fetch()) {
            $insertVp = $this->conn->prepare("INSERT INTO vien_phi (ma_benh_nhan, tong_tien, trang_thai) VALUES (:code, :total, 'Chưa thanh toán')");
            $insertVp->execute([
                ':code' => $code,
                ':total' => $totalPrice
            ]);
        } else {
            $updateVp = $this->conn->prepare("UPDATE vien_phi SET tong_tien = :total WHERE ma_benh_nhan = :code");
            $updateVp->execute([
                ':total' => $totalPrice,
                ':code' => $code
            ]);
        }

        $invoiceCode = 'INV' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        return [
            'patient_info' => [
                'ma_benh_nhan' => $code,
                'ten_benh_nhan' => $patientName,
                'ngay_lap' => date('d/m/Y H:i'),
                'ma_hoa_don' => $invoiceCode
            ],
            'services' => $services,
            'tong_tien' => $totalPrice
        ];
    }
}