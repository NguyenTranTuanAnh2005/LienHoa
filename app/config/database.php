<?php
/**
 * Lớp Database
 * 
 * Quản lý kết nối đến cơ sở dữ liệu PDO.
 * Tuân thủ chuẩn PSR về khai báo class.
 */
class Database
{
    private $host = 'localhost';
    private $db_name = 'smart_hospital'; // Tôi đã khôi phục lại thành smart_hospital như edit của bạn
    private $username = 'root';
    private $password = '';
    public $conn;

    /**
     * Tạo kết nối đến cơ sở dữ liệu MySQL thông qua PDO.
     * 
     * @return PDO|null Trả về đối tượng PDO nếu thành công, null nếu thất bại.
     */
    public function getConnection()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            
            // Cấu hình các tuỳ chọn cho PDO
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      
                PDO::ATTR_EMULATE_PREPARES   => false,                 
            ];

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch (PDOException $exception) {
            die("Lỗi kết nối CSDL: " . $exception->getMessage());
        }

        return $this->conn;
    }
}