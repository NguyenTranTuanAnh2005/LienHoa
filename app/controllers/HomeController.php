<?php

class HomeController {
    public function __construct() {
        // 1. Luôn khởi động session để kiểm tra trạng thái đăng nhập
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. CHẶN ADMIN: Nếu đã đăng nhập và là admin, đẩy về dashboard
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            header("Location: http://localhost:90/dacs-main/admin/dashboard");
            exit(); // Dừng thực thi ngay lập tức
        }
    }

    public function index() {
        // 3. Logic hiển thị cho người dùng bình thường (bệnh nhân)
        require_once APP_DIR . '/models/PackageModel.php';
        $packageModel = new PackageModel();
        $packages = $packageModel->all();

        require_once APP_DIR . '/models/DoctorModel.php';
        $doctorModel = new DoctorModel();
        $doctors = $doctorModel->getAll();

        $viewFile = APP_DIR . '/views/home/index.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy file view {$viewFile}";
        }
    }
}

//code cũ trong codeshare.io/TA