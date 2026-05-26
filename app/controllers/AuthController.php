<?php

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Giao diện Đăng nhập
     * GET /auth/loginPage
     */
    public function loginPage()
    {
        // Nếu đã đăng nhập, chuyển hướng về trang chủ hoặc dashboard
        if (isset($_SESSION['user_id'])) {
            $redirectUrl = BASE_URL . '/';
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                $redirectUrl = BASE_URL . '/admin/dashboard';
            }
            header("Location: " . $redirectUrl);
            exit;
        }

        $viewFile = APP_DIR . '/views/auth/login.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy giao diện.";
        }
    }

    /**
     * API Đăng nhập
     * Method: POST /auth/login
     */
    public function login()
    {
        // Chỉ nhận POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Phương thức không được hỗ trợ']);
            return;
        }

        // Đọc dữ liệu JSON hoặc form data
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'] ?? $_POST['username'] ?? '';
        $password = $input['password'] ?? $_POST['password'] ?? '';
        $selectedRole = $input['role'] ?? $_POST['role'] ?? '';

        if (empty($username) || empty($password)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Vui lòng nhập tài khoản và mật khẩu']);
            return;
        }

        // Gọi model để xác thực
        $user = $this->userModel->authenticate($username, $password);

        if ($user) {
            // Kiểm tra tư cách đăng nhập nếu có truyền lên từ form
            if (!empty($selectedRole) && $user['role'] !== $selectedRole) {
                http_response_code(401);
                echo json_encode(['success' => false, 'error' => 'Sai tài khoản hoặc mật khẩu']);
                return;
            }
            
            // Đăng nhập thành công -> Thiết lập Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            
            // Nếu là bệnh nhân, lưu thêm patient_id
            if ($user['role'] === 'user' && !empty($user['patient_id'])) {
                $_SESSION['patient_id'] = $user['patient_id'];
            }

            // Xác định đường dẫn chuyển hướng dựa trên vai trò
            $redirectUrl = BASE_URL . '/';
            if ($user['role'] === 'admin') {
                $redirectUrl = BASE_URL . '/admin/dashboard';
            }

            echo json_encode([
                'success' => true,
                'message' => 'Đăng nhập thành công',
                'redirect' => $redirectUrl,
                'data' => [
                    'id' => $user['id'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role']
                ]
            ]);
        } else {
            // Sai tài khoản hoặc mật khẩu
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Sai tài khoản hoặc mật khẩu']);
        }
    }

    /**
     * API Đăng xuất
     * Method: GET hoặc POST /auth/logout
     */
    public function logout()
    {
        // Xóa toàn bộ Session
        session_unset();
        session_destroy();
        
        echo json_encode(['success' => true, 'message' => 'Đăng xuất thành công']);
    }

    /**
     * API Đăng ký dành cho Bệnh nhân
     * Method: POST /auth/register
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Phương thức không được hỗ trợ']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $fullName = $input['full_name'] ?? $_POST['full_name'] ?? '';
        $email = $input['email'] ?? $_POST['email'] ?? '';
        $phone = $input['phone'] ?? $_POST['phone'] ?? '';
        $password = $input['password'] ?? $_POST['password'] ?? '';
        
        if (empty($fullName) || empty($phone) || empty($password)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Vui lòng nhập đầy đủ Họ tên, Số điện thoại và Mật khẩu']);
            return;
        }

        // Chọn Số điện thoại (hoặc email) làm username. Ở đây ưu tiên phone.
        $username = !empty($phone) ? $phone : $email;

        // 1. Kiểm tra tài khoản đã tồn tại chưa
        if ($this->userModel->checkUsernameExists($username)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Số điện thoại hoặc Email này đã được đăng ký']);
            return;
        }

        // Bắt đầu transaction (Nếu có thể, nhưng Database class không public conn, có thể tạo tạm thông qua UserModel)
        // Tuy nhiên tớ sẽ gọi lần lượt vì quy mô nhỏ
        
        // 2. Tạo Hồ sơ Bệnh nhân
        $patientModel = new PatientModel();
        $patientId = $patientModel->create([
            'full_name' => $fullName,
            'phone' => $phone,
            'email' => $email
        ]);

        if (!$patientId) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Lỗi khi tạo Hồ sơ bệnh nhân']);
            return;
        }

        // 3. Tạo Tài khoản liên kết
        $success = $this->userModel->registerUser($username, $password, $fullName, 'user', $patientId);

        if ($success) {
            // Lấy lại user vừa đăng ký để set Session
            $user = $this->userModel->authenticate($username, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['patient_id'] = $user['patient_id'];

                echo json_encode([
                    'success' => true,
                    'message' => 'Đăng ký thành công',
                    'redirect' => BASE_URL . '/',
                    'data' => [
                        'id' => $user['id'],
                        'full_name' => $user['full_name'],
                        'role' => $user['role']
                    ]
                ]);
            }
        } else {
            // Rollback thủ công nếu lỗi (xóa bệnh nhân)
            $patientModel->delete($patientId);
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Lỗi khi tạo tài khoản']);
        }
    }

    /**
     * Lấy thông tin user hiện tại (Dùng để hiển thị lên Header/UI)
     */
    public function me()
    {
        if (isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => true,
                'data' => [
                    'id' => $_SESSION['user_id'],
                    'full_name' => $_SESSION['full_name'],
                    'role' => $_SESSION['user_role']
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Chưa đăng nhập']);
        }
    }
}
