<?php
// router.php - Hỗ trợ URL Rewrite cho PHP Built-in Server giống hệt .htaccess của Apache
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Nếu file hoặc thư mục (assets, hình ảnh) có thật trên ổ đĩa thì trả về nguyên bản
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Nếu không phải file thật thì giả định là đường dẫn ảo (Clean URL) => Chuyển cấu trúc cho index.php
$_GET['url'] = ltrim($uri, '/');
require_once __DIR__ . '/index.php';
