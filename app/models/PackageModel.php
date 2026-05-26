<?php

class PackageModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();

        if ($this->conn === null) {
            error_log("PackageModel Error: Database connection is null.");
        }
    }

    /**
     * Lấy danh sách tất cả các gói khám (đã xử lý trùng lặp)
     */
    public function all()
    {
        if (!$this->conn) {
            return [];
        }

        $query = "SELECT id, ten_goi, mo_ta, gia_tien 
                  FROM goi_kham 
                  WHERE id IN (
                      SELECT MIN(id) 
                      FROM goi_kham 
                      GROUP BY ten_goi
                  )
                  ORDER BY gia_tien ASC";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Query Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * TÌM CHI TIẾT MỘT GÓI KHÁM (Hàm mới để fix lỗi 404)
     * @param int $id ID của gói khám
     * @return array|false Trả về mảng dữ liệu hoặc false nếu không tìm thấy
     */
    public function find($id)
    {
        if (!$this->conn) {
            return false;
        }

        // Truy vấn lấy chi tiết gói khám theo ID
        $query = "SELECT id, ten_goi, mo_ta, gia_tien 
                  FROM goi_kham 
                  WHERE id = :id 
                  LIMIT 1";

        try {
            $stmt = $this->conn->prepare($query);
            // Sử dụng bindParam hoặc truyền mảng vào execute để tránh SQL Injection
            $stmt->execute(['id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Query Detail Error: " . $e->getMessage());
            return false;
        }
    }

    public function package()
{
    $package_id = filter_input(INPUT_GET, 'package_id', FILTER_SANITIZE_NUMBER_INT);
    
    if (!$package_id) {
        header("Location: " . BASE_URL . "/package");
        exit;
    }

    // Đảm bảo Model đã được khởi tạo đúng cách
    $packageModel = new PackageModel();
    $selected_package = $packageModel->find($package_id);

    if (!$selected_package) {
        // Thay vì dùng die, nên redirect kèm thông báo lỗi
        header("Location: " . BASE_URL . "/package?error=notfound");
        exit;
    }

    require_once APP_DIR . '/views/booking/package_form.php';
}
}