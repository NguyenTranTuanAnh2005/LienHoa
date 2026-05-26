<?php

class LoginController extends BaseController
{
    /**
     * Giao diện Đăng nhập chính (GET /login)
     */
    public function index()
    {
        // Nếu đã đăng nhập, chuyển hướng về trang chủ hoặc dashboard
        if ($this->isLoggedIn()) {
            $redirectUrl = BASE_URL . '/';
            if ($this->hasRole('admin')) {
                $redirectUrl = BASE_URL . '/admin/dashboard'; // Hoặc đường dẫn admin thực tế
            }
            header("Location: " . $redirectUrl);
            exit;
        }

        // Tải giao diện đăng nhập
        $viewFile = APP_DIR . '/views/auth/login.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "<h2>Lỗi 404: Không tìm thấy giao diện.</h2> <p>File views/auth/login.php không tồn tại.</p>";
        }
    }
}
