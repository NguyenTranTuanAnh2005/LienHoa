<?php

class LoginModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    /**
     * Xác thực đăng nhập
     * 
     * @param string $username Email hoặc Số điện thoại
     * @param string $password Mật khẩu thô (chưa hash)
     * @return array|false Trả về mảng thông tin user nếu thành công, false nếu thất bại
     */
    public function checkLogin($username, $password)
    {
        // 1. Tìm người dùng theo username
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Nếu tìm thấy user, kiểm tra mật khẩu
        if ($user) {
            // Sử dụng password_verify để so sánh mật khẩu thô với hash trong CSDL
            if (password_verify($password, $user['password'])) {
                // Xóa mật khẩu khỏi mảng kết quả trước khi trả về để bảo mật
                unset($user['password']);
                return $user; // Trả về thông tin user bao gồm id, username, full_name, role, patient_id
            }
        }

        // Đăng nhập thất bại (sai tài khoản hoặc mật khẩu)
        return false;
    }
}
