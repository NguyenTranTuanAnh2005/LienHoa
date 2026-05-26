<?php

class PackageController
{
    /**
     * Hiển thị danh sách tất cả các gói khám
     */
    public function index()
    {
        // Khởi tạo model và lấy danh sách các gói
        $packageModel = new PackageModel();
        $packages = $packageModel->all();

        // Gọi View hiển thị
        $viewFile = APP_DIR . '/views/packages/index.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy file view {$viewFile}";
        }
    }

    /**
     * Hiển thị chi tiết một gói khám (Sửa lỗi 404 phương thức detail)
     */
    public function detail($id)
    {
        $packageModel = new PackageModel();
        // Giả sử Model của bạn có hàm find($id) để lấy 1 bản ghi
        $package = $packageModel->find($id);

        if (!$package) {
            // Nếu không tìm thấy ID, có thể chuyển hướng hoặc báo lỗi
            header("Location: " . BASE_URL . "/package");
            exit;
        }

        // Truyền dữ liệu vào View chi tiết
        $viewFile = APP_DIR . '/views/packages/detail.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy file view chi tiết.";
        }
    }
}