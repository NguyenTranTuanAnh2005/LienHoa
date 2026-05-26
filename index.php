<?php
session_start();

/**
 * Điểm khởi chạy của ứng dụng (Central Router)
 * Tất cả các request đều đi qua đây.
 */

// Hiển thị lỗi trong môi trường phát triển (có thể tắt trên production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Định nghĩa thư mục gốc
define('ROOT_DIR', __DIR__);
define('APP_DIR', ROOT_DIR . '/app');

// Cấu hình URL cơ sở tự động
if (php_sapi_name() === 'cli-server') {
    $baseDir = '';
} else {
    $baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    if ($baseDir === '/' || $baseDir === '\\') {
        $baseDir = '';
    }
}
define('BASE_URL', $baseDir);

/**
 * Khởi tạo tự động tải lớp (Autoloader)
 * Tự động tìm và include các file Controller, Model và cấu hình.
 */
spl_autoload_register(function ($className) {
    // Các thư mục chứa class
    $directories = [
        APP_DIR . '/controllers/',
        APP_DIR . '/models/',
        APP_DIR . '/config/'
    ];

    foreach ($directories as $directory) {
        // Hỗ trợ trường hợp tên file trùng khớp hoàn toàn (BookingController.php)
        $file = $directory . $className . '.php';
        // Hỗ trợ trường hợp tên file viết chữ thường hoàn toàn (database.php - class Database)
        $fileLower = $directory . strtolower($className) . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        } elseif (file_exists($fileLower)) {
            require_once $fileLower;
            return;
        }
    }
});

// ==========================================
// KHỞI TẠO KẾT NỐI DATABASE TOÀN CỤC
// ==========================================
// Đảm bảo Database đã sẵn sàng ngay từ đầu theo yêu cầu
$dbInstance = new Database();
// Biến $dbConnection có thể được dùng ở cấp độ global nếu xử lý không qua Model (tuy nhiên vẫn khuyến khích dùng Model)
$dbConnection = $dbInstance->getConnection();


// ==========================================
// HỆ THỐNG ROUTING (ĐIỀU HƯỚNG CƠ BẢN)
// Cấu trúc URL: domain.com/controller/action/id1/id2
// ==========================================

// Lấy đường dẫn URL từ tham số GET (được rewrite từ .htaccess)
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);
$urlParts = explode('/', $url);

// 1. Xác định Controller, mặc định là HomeController
$controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'HomeController';

// 2. Xác định Action (method), mặc định là 'index'
$actionName = !empty($urlParts[1]) ? $urlParts[1] : 'index';

// 3. Các tham số còn lại trong URL
$params = array_slice($urlParts, 2);

// Đường dẫn file Controller yêu cầu
$controllerFile = APP_DIR . '/controllers/' . $controllerName . '.php';

// Kiểm tra xem Controller có tồn tại không
if (file_exists($controllerFile)) {
    // Class đã tự động include qua autoloader nếu file tồn tại
    if (class_exists($controllerName)) {
        $controller = new $controllerName();

        // Kiểm tra xem Action (Hàm) có tồn tại trong Controller không
        if (method_exists($controller, $actionName)) {
            // Gọi phương thức và truyền vào các tham số (nếu có)
            call_user_func_array([$controller, $actionName], $params);
        } else {
            // Xử lý lỗi 404 - Action không tồn tại
            http_response_code(404);
            die("<h2>Lỗi 404: Không tìm thấy trang.</h2> <p>Phương thức <b>{$actionName}</b> không được tìm thấy trong <b>{$controllerName}</b>.</p>");
        }
    } else {
        http_response_code(500);
        die("<h2>Lỗi 500: Lỗi Server.</h2> <p>Class <b>{$controllerName}</b> chưa được định nghĩa bên trong file.</p>");
    }
} else {
    // Xử lý lỗi 404 - Controller không tồn tại
    http_response_code(404);
    die("<h2>Lỗi 404: Không tìm thấy trang.</h2> <p>Controller <b>{$controllerName}</b> không tồn tại trên hệ thống.</p>");
}