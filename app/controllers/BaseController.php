<?php

class BaseController
{
    /**
     * Kiểm tra xem người dùng đã đăng nhập chưa
     * @return bool
     */
    protected function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Kiểm tra vai trò của người dùng
     * @param string $role
     * @return bool
     */
    protected function hasRole($role)
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
    }

    /**
     * Yêu cầu đăng nhập, nếu chưa đăng nhập sẽ báo lỗi 401
     */
    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                http_response_code(401);
                echo json_encode(['error' => 'Vui lòng đăng nhập để tiếp tục']);
            } else {
                header("Location: " . BASE_URL . "/login");
            }
            exit;
        }
    }

    /**
     * Yêu cầu phải có quyền cụ thể, nếu không sẽ báo lỗi 403
     * @param string $role
     */
    protected function requireRole($role)
    {
        if (!$this->isLoggedIn() || !$this->hasRole($role)) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                http_response_code(403);
                echo json_encode(['error' => '403 Forbidden - Bạn không có quyền thực hiện hành động này.']);
            } else {
                header("Location: " . BASE_URL . "/login");
            }
            exit;
        }
    }
}
