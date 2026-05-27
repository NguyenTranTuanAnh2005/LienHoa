<?php

class BookingModel
{
    /** @var PDO */
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * LẤY TẤT CẢ DANH SÁCH ĐẶT LỊCH (Dành cho Admin)
     * Giữ lại để tránh lỗi ở các module thống kê, tổng hợp khác
     */
    public function getAllBookings(): array
    {
        $query = "SELECT d.*, g.gia_tien, b.ho_ten as ten_bac_si 
                  FROM dat_lich d 
                  LEFT JOIN goi_kham g ON d.id_goi_kham = g.id 
                  LEFT JOIN bac_si b ON d.id_bac_si = b.id 
                  ORDER BY d.ngay_tao DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * CHỈ LẤY LỊCH HẸN KHÁM CHUYÊN KHOA / BÁC SĨ
     * Điều kiện: id_goi_kham trống (bằng 0 hoặc NULL)
     */
    public function getDoctorBookings($search = ''): array
    {
        $query = "SELECT d.*, b.ho_ten as ten_bac_si, p.patient_code as linked_patient_code 
                  FROM dat_lich d 
                  LEFT JOIN bac_si b ON d.id_bac_si = b.id 
                  LEFT JOIN patients p ON d.so_dien_thoai = p.phone
                  WHERE (d.id_goi_kham IS NULL OR d.id_goi_kham = 0)";
                  
        $params = [];
        if (!empty($search)) {
            $query .= " AND (d.ten_benh_nhan LIKE :search1 OR d.so_dien_thoai LIKE :search2 OR d.ma_benh_nhan LIKE :search3 OR p.patient_code LIKE :search4)";
            $searchTerm = '%' . $search . '%';
            $params[':search1'] = $searchTerm;
            $params[':search2'] = $searchTerm;
            $params[':search3'] = $searchTerm;
            $params[':search4'] = $searchTerm;
        }

        $query .= " ORDER BY d.ngay_tao DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * CHỈ LẤY ĐƠN ĐĂNG KÝ GÓI KHÁM SỨC KHỎE
     * Điều kiện: id_goi_kham có giá trị cụ thể lớn hơn 0
     * ĐÃ SỬA: Thay g.ten_goi_kham bằng g.ten_goi AS ten_goi_kham khớp với cấu trúc bảng thực tế
     */
    public function getPackageBookings($search = ''): array
    {
        $query = "SELECT d.*, g.ten_goi AS ten_goi_kham, g.gia_tien, p.patient_code as linked_patient_code
                  FROM dat_lich d 
                  INNER JOIN goi_kham g ON d.id_goi_kham = g.id 
                  LEFT JOIN patients p ON d.so_dien_thoai = p.phone
                  WHERE d.id_goi_kham IS NOT NULL AND d.id_goi_kham > 0";

        $params = [];
        if (!empty($search)) {
            $query .= " AND (d.ten_benh_nhan LIKE :search1 OR d.so_dien_thoai LIKE :search2 OR d.ma_benh_nhan LIKE :search3 OR p.patient_code LIKE :search4)";
            $searchTerm = '%' . $search . '%';
            $params[':search1'] = $searchTerm;
            $params[':search2'] = $searchTerm;
            $params[':search3'] = $searchTerm;
            $params[':search4'] = $searchTerm;
        }

        $query .= " ORDER BY d.ngay_tao DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Tạo mới một lịch hẹn
     */
    public function create(array $data)
    {
        $query = "INSERT INTO dat_lich (
                    ma_benh_nhan, ten_benh_nhan, so_dien_thoai, email, ngay_sinh, 
                    gioi_tinh, dia_chi, cccd, co_so_kham, 
                    chuyen_khoa, ten_goi_kham, id_goi_kham, id_bac_si, ngay_hen, ghi_chu
                  ) VALUES (
                    :patient_code, :name, :phone, :email, :dob, 
                    :gender, :address, :cccd, :hospital, 
                    :specialty, :package_name, :package_id, :doctor_id, :appointment_date, :notes
                  )";
                  
        $stmt = $this->conn->prepare($query);

        $result = $stmt->execute([
            ':patient_code'     => $data['patient_code'] ?? null,
            ':name'             => $data['patient_name'] ?? null,
            ':phone'            => $data['phone'] ?? null,
            ':email'            => $data['email'] ?? null,
            ':dob'              => $data['dob'] ?? null,
            ':gender'           => $data['gender'] ?? null,
            ':address'          => $data['address'] ?? null,
            ':cccd'             => $data['cccd'] ?? null,
            ':hospital'         => $data['hospital'] ?? null,
            ':specialty'        => $data['specialty'] ?? null,
            ':package_name'     => $data['package_name'] ?? null,
            ':package_id'       => $data['package_id'] ?? null,
            ':doctor_id'        => $data['doctor_id'] ?? null,
            ':appointment_date' => $data['appointment_date'] ?? null,
            ':notes'            => $data['notes'] ?? null
        ]);

        return $result ? (int)$this->conn->lastInsertId() : false;
    }

    /**
     * Tìm chi tiết một lịch hẹn theo ID
     */
    public function find($id): ?array
    {
        $sql = "SELECT d.*, g.gia_tien, b.ho_ten as ten_bac_si 
                FROM dat_lich d 
                LEFT JOIN goi_kham g ON d.id_goi_kham = g.id 
                LEFT JOIN bac_si b ON d.id_bac_si = b.id 
                WHERE d.id = :id";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data ?: null;
    }

    /**
     * Tìm kiếm danh sách lịch hẹn bằng số điện thoại
     */
    public function findByPhone(string $phone): array
    {
        $query = "SELECT d.*, g.gia_tien, b.ho_ten as ten_bac_si 
                  FROM dat_lich d 
                  LEFT JOIN goi_kham g ON d.id_goi_kham = g.id 
                  LEFT JOIN bac_si b ON d.id_bac_si = b.id 
                  WHERE d.so_dien_thoai = :phone 
                  ORDER BY d.ngay_hen DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':phone' => $phone]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Tìm kiếm lịch hẹn bằng mã bệnh nhân hoặc số điện thoại
     */
    public function findByPatientCodeOrPhone(?string $patientCode, string $phone): array
    {
        $query = "SELECT d.*, g.gia_tien, b.ho_ten as ten_bac_si 
                  FROM dat_lich d 
                  LEFT JOIN goi_kham g ON d.id_goi_kham = g.id 
                  LEFT JOIN bac_si b ON d.id_bac_si = b.id 
                  WHERE (d.so_dien_thoai = :phone) 
                  ORDER BY d.ngay_hen DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':phone' => $phone]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Cập nhật trạng thái lịch hẹn / đơn hàng
     */
    public function updateStatus(int $id, string $status): bool
    {
        $query = "UPDATE dat_lich SET trang_thai = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }

    /**
     * Tạo mã OTP và lưu vào session
     */
    public function updateOTP(string $patientCode, int $otp): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['payment_otp_' . $patientCode] = [
            'otp' => $otp,
            'expires_at' => time() + 300
        ];
        
        return true;
    }

    /**
     * Xác thực mã OTP
     */
    public function verifyOTP(string $patientCode, string $otp): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $sessionKey = 'payment_otp_' . $patientCode;
        
        if (isset($_SESSION[$sessionKey])) {
            $otpData = $_SESSION[$sessionKey];
            
            if ($otpData['otp'] == $otp && time() <= $otpData['expires_at']) {
                unset($_SESSION[$sessionKey]);
                return true;
            }
        }
        
        return false;
    }

    /* ==========================================================================
       CÁC HÀM THỐNG KÊ DOANH THU MỚI BỔ SUNG
       ========================================================================== */

    /**
     * LẤY DOANH THU GÓI KHÁM THEO THÁNG TRONG NĂM HIỆN TẠI (Dùng vẽ biểu đồ)
     * Chỉ tính các đơn có trạng thái 'da_xac_nhan' hoặc 'hoan_thanh'
     */
    /**
     * TÍNH DOANH THU THEO THÁNG
     * Logic: Lấy doanh thu từ Gói khám + Doanh thu từ Lịch khám lẻ (cột gia_tien trong dat_lich)
     */
    public function getRevenueByMonth(): array
{
    $query = "
        SELECT thang, SUM(doanh_thu) as doanh_thu FROM (
            -- Doanh thu từ Gói khám
            SELECT MONTH(d.ngay_hen) as thang, SUM(g.gia_tien) as doanh_thu
            FROM dat_lich d
            INNER JOIN goi_kham g ON d.id_goi_kham = g.id
            WHERE d.trang_thai = 'hoan_thanh' AND YEAR(d.ngay_hen) = 2026
            GROUP BY MONTH(d.ngay_hen)
            
            UNION ALL
            
            -- Doanh thu từ Nhập viện (Viện phí)
            SELECT MONTH(admission_date) as thang, SUM(gia_tien) as doanh_thu
            FROM hospitalizations 
            WHERE status = 'Completed' AND thanh_toan = 'Đã thanh toán' AND YEAR(admission_date) = 2026
            GROUP BY MONTH(admission_date)
        ) as combined_revenue
        GROUP BY thang
        ORDER BY thang ASC";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

    public function getYearlyRevenue(): float
    {
        $query = "SELECT SUM(g.gia_tien) as total
                  FROM dat_lich d
                  INNER JOIN goi_kham g ON d.id_goi_kham = g.id
                  WHERE d.trang_thai IN ('da_xac_nhan', 'hoan_thanh') 
                  AND YEAR(d.ngay_hen) = YEAR(CURDATE())";
                    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return (float)($stmt->fetchColumn() ?: 0);
    }

    public function getTotalVienPhi2026(): float
    {
        $query = "SELECT SUM(tong_tien) as total FROM vien_phi";
                    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return (float)($stmt->fetchColumn() ?: 0);
    }

    public function getMonthlyRevenue(): float
    {
        $query = "SELECT SUM(g.gia_tien) as total
                  FROM dat_lich d
                  INNER JOIN goi_kham g ON d.id_goi_kham = g.id
                  WHERE d.trang_thai IN ('da_xac_nhan', 'hoan_thanh') 
                  AND d.ngay_hen >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
                    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return (float)($stmt->fetchColumn() ?: 0);
    }

    public function getRevenueComparison(): array
{
    // Sử dụng LEFT JOIN và IFNULL để tránh lỗi khi dữ liệu trống
    // Đảm bảo tên cột khớp với schema: goi_kham(gia_tien), hospitalizations(gia_tien)
    $query = "
        SELECT thang, 
               SUM(doanh_thu_goi) as doanh_thu_goi,
               SUM(doanh_thu_le) as doanh_thu_le,
               SUM(doanh_thu_vien_phi) as doanh_thu_vien_phi
        FROM (
            -- 1. Doanh thu Gói khám
            SELECT MONTH(d.ngay_hen) as thang, SUM(g.gia_tien) as doanh_thu_goi, 0 as doanh_thu_le, 0 as doanh_thu_vien_phi
            FROM dat_lich d 
            INNER JOIN goi_kham g ON d.id_goi_kham = g.id
            WHERE d.trang_thai = 'hoan_thanh' AND YEAR(d.ngay_hen) = 2026 
            GROUP BY thang
            
            UNION ALL
            
            -- 2. Doanh thu Khám lẻ (Đặt bằng 0 vì trong bảng dat_lich không có cột gia_tien)
            SELECT MONTH(d.ngay_hen) as thang, 0 as doanh_thu_goi, 0 as doanh_thu_le, 0 as doanh_thu_vien_phi
            FROM dat_lich d 
            WHERE (d.id_goi_kham IS NULL OR d.id_goi_kham = 0) AND d.trang_thai = 'hoan_thanh' AND YEAR(d.ngay_hen) = 2026 
            GROUP BY thang
            
            UNION ALL
            
            -- 3. Doanh thu Viện phí: Lấy từ bảng vien_phi
            SELECT MONTH(ngay_tao) as thang, 0 as doanh_thu_goi, 0 as doanh_thu_le, SUM(tong_tien) as doanh_thu_vien_phi
            FROM vien_phi 
            WHERE YEAR(ngay_tao) = 2026 
            GROUP BY thang

            UNION ALL

            -- 4. Doanh thu Xét nghiệm
            SELECT MONTH(sample_date) as thang, 0 as doanh_thu_goi, 0 as doanh_thu_le, SUM(tong_tien) as doanh_thu_vien_phi
            FROM lab_tests
            WHERE status = 'completed' AND YEAR(sample_date) = 2026
            GROUP BY thang
        ) as t 
        GROUP BY thang 
        ORDER BY thang ASC";
    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

/**
 * TÌM KIẾM LỊCH KHÁM (CHO ADMIN)
 * Tìm kiếm theo Họ tên hoặc SĐT hoặc Mã đơn
 */
public function searchAppointments($term): array
{
    // Tìm kiếm trong cột Họ tên, SĐT, Mã đơn, CCCD, Số điện thoại
    $query = "SELECT d.*, g.gia_tien, b.ho_ten as ten_bac_si 
              FROM dat_lich d 
              LEFT JOIN goi_kham g ON d.id_goi_kham = g.id 
              LEFT JOIN bac_si b ON d.id_bac_si = b.id 
              WHERE d.ten_benh_nhan LIKE :term 
              OR d.so_dien_thoai LIKE :term 
              OR d.ma_benh_nhan LIKE :term 
              OR d.cccd LIKE :term
              ORDER BY d.id DESC";
              
    $stmt = $this->conn->prepare($query);
    $stmt->execute([':term' => "%{$term}%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

/**
 * Lấy danh sách các chuyên khoa (dùng cho dropdown form booking)
 */
public function getSpecialties(): array
{
    $query = "SELECT id, ten_khoa FROM chuyen_khoa ORDER BY ten_khoa ASC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

/**
 * Lấy danh sách Bác sĩ theo chuyên khoa
 */
public function getDoctorsBySpecialty($specialtyId): array
{
    $query = "SELECT id, ho_ten, hinh_anh FROM bac_si WHERE id_chuyen_khoa = :specialty_id ORDER BY ho_ten ASC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([':specialty_id' => $specialtyId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

/**
 * Cập nhật thông tin bệnh nhân từ booking
 */
public function updatePatientInfo($patientId, $data): bool
{
    // Tìm bệnh nhân
    $patient = $this->findPatientById($patientId);
    if (!$patient) return false;

    $fields = [];
    $params = [];

    if (isset($data['name']) && trim($data['name']) !== $patient['full_name']) {
        $fields[] = "full_name = :name";
        $params[':name'] = trim($data['name']);
    }

    if (isset($data['gender']) && trim($data['gender']) !== $patient['gender']) {
        $fields[] = "gender = :gender";
        $params[':gender'] = trim($data['gender']);
    }

    if (isset($data['birthday']) && trim($data['birthday']) !== $patient['birthday']) {
        $fields[] = "birthday = :birthday";
        $params[':birthday'] = trim($data['birthday']);
    }

    if (isset($data['phone']) && trim($data['phone']) !== $patient['phone']) {
        $fields[] = "phone = :phone";
        $params[':phone'] = trim($data['phone']);
    }

    if (isset($data['address']) && trim($data['address']) !== $patient['address']) {
        $fields[] = "address = :address";
        $params[':address'] = trim($data['address']);
    }

    if (isset($data['email']) && trim($data['email']) !== $patient['email']) {
        $fields[] = "email = :email";
        $params[':email'] = trim($data['email']);
    }

    if (empty($fields)) return true;

    $params[':patientId'] = $patientId;
    $query = "UPDATE patients SET " . implode(", ", $fields) . " WHERE id = :patientId";
    
    $stmt = $this->conn->prepare($query);
    return $stmt->execute($params);
}

/**
 * Tìm bệnh nhân theo ID
 */
private function findPatientById($id): ?array
{
    $query = "SELECT * FROM patients WHERE id = :id LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

/**
 * Lấy thông tin bệnh nhân từ đơn booking
 */
public function getPatientFromBooking($bookingId): ?array
{
    $query = "SELECT d.*, p.id as patient_id 
              FROM dat_lich d 
              LEFT JOIN patients p ON d.ma_benh_nhan = p.patient_code
              WHERE d.id = :booking_id";
              
    $stmt = $this->conn->prepare($query);
    $stmt->execute([':booking_id' => $bookingId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) return null;
    
    // Nếu chưa có patient_id, thử tạo mới
    if (!$result['patient_id'] && $result['ma_benh_nhan']) {
        $patientId = $this->createNewPatientFromBooking($result);
        if ($patientId) {
            $result['patient_id'] = $patientId;
        }
    }
    
    return $result;
}

/**
 * Tạo mới bệnh nhân từ thông tin booking
 */
private function createNewPatientFromBooking($bookingData): ?int
{
    $query = "INSERT INTO patients 
              (patient_code, full_name, gender, birthday, phone, address, email) 
              VALUES (:code, :name, :gender, :birthday, :phone, :address, :email)";
              
    $params = [
        ':code' => $bookingData['ma_benh_nhan'],
        ':name' => $bookingData['ten_benh_nhan'],
        ':gender' => $bookingData['gioi_tinh'],
        ':birthday' => $bookingData['ngay_sinh'],
        ':phone' => $bookingData['so_dien_thoai'],
        ':address' => $bookingData['dia_chi'],
        ':email' => $bookingData['email']
    ];
    
    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);
    return (int)$this->conn->lastInsertId();
}
}       