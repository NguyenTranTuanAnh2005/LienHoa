<?php

class UserModel
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
     * @param string $username Tên đăng nhập
     * @param string $password Mật khẩu thô
     * @return array|false Trả về mảng thông tin user (kèm role) nếu thành công, false nếu thất bại
     */
    public function authenticate($username, $password)
    {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                unset($user['password']);
                return $user; 
            }
        }

        return false;
    }

    /**
     * Kiểm tra username đã tồn tại chưa
     */
    public function checkUsernameExists($username)
    {
        $query = "SELECT id FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->fetch() !== false;
    }

    /**
     * Đăng ký người dùng mới
     */
    public function registerUser($username, $password, $fullName, $role = 'user', $patientId = null)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users (username, password, full_name, role, patient_id) 
                  VALUES (:username, :password, :full_name, :role, :patient_id)";
        $stmt = $this->conn->prepare($query);
        
        $params = [
            ':username' => $username,
            ':password' => $hashedPassword,
            ':full_name' => $fullName,
            ':role' => $role,
            ':patient_id' => $patientId
        ];
        
        return $stmt->execute($params);
    }

    /**
     * Lấy thông tin user theo ID
     */
    public function getById($id)
    {
        $query = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
