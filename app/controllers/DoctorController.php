<?php

/**
 * Controller xử lý các chức năng liên quan đến Bác sĩ
 */
class DoctorController
{
    /**
     * Action mặc định: Hiển thị danh sách bác sĩ
     */
    public function index()
    {
        // 1. Khởi tạo Model
        $doctorModel = new DoctorModel();
        
        // 2. Lấy dữ liệu (Model đã được sửa GROUP BY để tránh trùng lặp)
       $doctors = $doctorModel->getAll();

        // 3. Đường dẫn file view
        $viewFile = APP_DIR . '/views/doctors/index.php';
        
        if (file_exists($viewFile)) {
            // SỬ DỤNG require_once để ngăn việc nạp file 2 lần gây lặp giao diện
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy file view {$viewFile}";
        }
    }

    /**
     * Action xem chi tiết sơ yếu lý lịch bác sĩ
     */
    public function detail($id)
    {
        // Kiểm tra ID hợp lệ trước khi truy vấn
        if (empty($id) || !is_numeric($id)) {
            header("Location: " . BASE_URL . "/doctor/index");
            exit();
        }

        $doctorModel = new DoctorModel();
        $doctor = $doctorModel->find($id);

        // Kiểm tra bác sĩ có tồn tại không
        if (!$doctor) {
            header("Location: " . BASE_URL . "/doctor/index");
            exit();
        }

        $pageTitle = "Sơ yếu lý lịch: BS. " . $doctor['ho_ten'];
        $viewFile = APP_DIR . '/views/doctors/detail.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Lỗi: Không tìm thấy file view {$viewFile}";
        }
    }
}