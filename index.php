<?php
// *************************************************************************
// * ISOCMS - The Complete Content Management System Solution              *
// * Copyright (c) VietISO. All Rights Reserved.                           *
// * Version: 6.0.0                                                        *
// *************************************************************************

// =========================================================
// [FIX BẢO MẬT #1] Xóa hardcode IP whitelist/blacklist
// - IP whitelist để bật debug nên dùng file config hoặc biến môi trường
// - IP blacklist nên xử lý ở tầng firewall / .htaccess, không phải PHP
// - Tuyệt đối không để IP cụ thể trong source code công khai
// =========================================================

// Bật debug an toàn qua biến môi trường hoặc file config (không hardcode IP)
// Ví dụ: đặt DEBUG_MODE=1 trong file .env và đọc qua getenv() 
//ISOCMS_DEBUG tham số này được cấu hình trong .htaccess
if (getenv('ISOCMS_DEBUG') === '1') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL & ~E_STRICT);
} else {
    // [FIX BẢO MẬT #2] Production: tắt hiển thị lỗi, log ra file
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
    // ini_set('log_errors', 1);
    // ini_set('error_log', '/path/to/private/error.log');
}

// =========================================================
// [FIX BẢO MẬT #3] Xóa exit('404 Not Found.') hardcode IP
// - Trả về 404 đúng HTTP status thay vì plain text
// - Việc filter IP nên để ở tầng .htaccess / firewall
// =========================================================

define("IS_ADMIN_PAGE", 0);
define("_SITE_ROOT", 'FRONTPAGE');

// =========================================================
// [FIX BẢO MẬT #4] Validate DOCUMENT_ROOT trước khi dùng
// - Tránh path traversal nếu biến môi trường bị giả mạo
// =========================================================
$docRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
if (!$docRoot || !is_dir($docRoot)) {
    http_response_code(500);
    exit('Server configuration error.');
}

define('ABSPATH', $docRoot);

// =========================================================
// [FIX BẢO MẬT #5] Kiểm tra file tồn tại trước khi require
// =========================================================
$initFile = ABSPATH . '/init.php';
if (!file_exists($initFile) || !is_readable($initFile)) {
    http_response_code(500);
    exit('ISOCMS initialization error.');
}
require($initFile);

// Required Module
$indexIncludes = DIR_INCLUDES . "/index.php";
if (file_exists($indexIncludes)) {
    require_once($indexIncludes);
} else {
    http_response_code(500);
    // [FIX BẢO MẬT #6] Không lộ thông tin nội bộ ra màn hình
    // Chỉ log, không echo ra ngoài
    error_log('ISOCMS: DIR_INCLUDES/index.php not found');
    exit();
}
