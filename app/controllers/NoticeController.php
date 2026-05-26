<?php

class NoticeController
{
    /**
     * Hàm khởi tạo: Để trống hoặc không tham số để tránh lỗi ArgumentCountError
     */
    public function __construct()
    {
        // Router trong index.php khởi tạo tự động nên không để tham số ở đây
    }

    /**
     * Action: Hiển thị danh sách tin tức/thông báo
     */
    public function index()
    {
        // 1. Khởi tạo Model và lấy dữ liệu
        $noticeModel = new NoticeModel();
        $notices = $noticeModel->all();

        // 2. Xác định đường dẫn View
        $viewFile = APP_DIR . '/views/notices/index.php';
        
        if (file_exists($viewFile)) {
            // Nạp file giao diện
            require_once $viewFile;
            // Dừng chương trình ngay sau khi nạp view để tránh lặp dữ liệu
            exit(); 
        } else {
            die("Lỗi: Không tìm thấy file view tại: " . $viewFile);
        }
    }

    /**
     * Action: Xem nội dung chi tiết bài viết
     * URL ví dụ: domain.com/notice/detail/1
     */
    public function detail($id = null)
    {
        // 1. Kiểm tra ID hợp lệ (phải là số)
        if (empty($id) || !is_numeric($id)) {
            header("Location: " . BASE_URL . "/notice");
            exit();
        }

        $noticeModel = new NoticeModel();
        $item = $noticeModel->find($id);

        // 2. Nếu không tìm thấy bài viết, quay về danh sách
        if (!$item) {
            header("Location: " . BASE_URL . "/notice");
            exit();
        }

        // 3. Đổ dữ liệu ra trang chi tiết
        $pageTitle = $item['title'];
        $viewFile = APP_DIR . '/views/notices/detail.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
            exit(); // Ngăn nạp chồng nội dung
        } else {
            die("Lỗi: Không tìm thấy file view tại: " . $viewFile);
        }
    }

    /**
     * Action: Hiển thị form tạo tin mới (Dành cho Admin)
     */
    public function create()
    {
        $viewFile = APP_DIR . '/views/notices/create.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
            exit();
        } else {
            die("Lỗi: Không tìm thấy file form thêm thông báo.");
        }
    }
}