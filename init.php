<?php
/*======================================================================*\
|| #################################################################### ||
|| # ISOCMS - init.php (đã tối ưu bảo mật)                           # ||
|| # VietISO (support@vietiso.com)                                    # ||
|| #################################################################### ||
\*======================================================================*/

// =========================================================
// [FIX BẢO MẬT #1] Validate ABSPATH trước khi dùng
// - Đảm bảo constant được định nghĩa bởi index.php hợp lệ
// =========================================================
if (!defined('ABSPATH')) {
    http_response_code(403);
    exit('Direct access not allowed.');
}

$configFile = ABSPATH . '/config.php';
if (!file_exists($configFile) || !is_readable($configFile)) {
    http_response_code(500);
    error_log('ISOCMS: config.php not found or not readable');
    exit('Configuration error.');
}
require($configFile);

// =========================================================
// [FIX BẢO MẬT #2] Load Library an toàn hơn
// - Kiểm tra is_dir trước khi opendir
// - Sort để đảm bảo thứ tự load nhất quán
// - Chỉ load đúng file .php, tránh load file .php.bak, v.v.
// =========================================================
if (defined('DIR_LIBRARYS') && is_dir(DIR_LIBRARYS) && is_readable(DIR_LIBRARYS)) {
    $customLibArray = [];
    $dh = opendir(DIR_LIBRARYS);
    if ($dh !== false) {
        while (($file = readdir($dh)) !== false) {
            // Chỉ load file .php thuần, không load dotfile
            if (preg_match('/^[a-zA-Z0-9_\-]+\.php$/', $file)) {
                $customLibArray[] = $file;
            }
        }
        closedir($dh);
    }
    sort($customLibArray); // Đảm bảo thứ tự load nhất quán
    foreach ($customLibArray as $customCls) {
        $fullPath = DIR_LIBRARYS . '/' . $customCls;
        if (is_file($fullPath) && is_readable($fullPath)) {
            require_once($fullPath);
        }
    }
}

// =========================================================
// SESSION CONFIG
// =========================================================
$SESSION_NAME    = "ISOCMS_SESSION";
$SESSION_PATH    = sys_get_temp_dir(); // [FIX] Dùng sys_get_temp_dir() thay "/tmp" hardcode
$SESSION_COOKIE  = 1;
$SESSION_TIME_OUT = 5 * 24 * 3600;

// =========================================================
// COMMON INCLUDES
// =========================================================
require_once DIR_COMMON . "/vnSession.php";
require_once DIR_COMMON . "/clsIniManager.php";

// =========================================================
// [FIX BẢO MẬT #3] Session setup
// =========================================================
if (!vnSessionSetup()) {
    error_log('ISOCMS: Session setup failed');
    http_response_code(500);
    exit('Session initialization failed.');
}

// =========================================================
// COOKIE
// =========================================================
require_once DIR_COMMON . "/clsCookie.php";
$COOKIE_NAME     = 'ISOCMS_COOKIES';
$COOKIE_TIME_OUT = 5 * 24 * 3600;
$clsCookie = new VnCookie($COOKIE_NAME, $COOKIE_TIME_OUT);
$clsCookie->extractAll();

// =========================================================
// STDIO / INPUT SANITIZATION
// =========================================================
require_once DIR_COMMON . "/clsStdio.php";
$stdio = new Stdio();
if (!in_array($stdio->GET("mod"), ['lang_front', 'lang'])) {
    $_GET  = $stdio->parse_incoming(true);
    $_POST = $stdio->parse_incoming(false);
}

// [FIX] Sanitize file uploads
if (!empty($_FILES)) {
    foreach ($_FILES as $key => $file) {
        $stdio->secureFiles($_FILES[$key]);
    }
}

// =========================================================
// [FIX BẢO MẬT #4] Session Start - chỉ start 1 lần, an toàn
// - Không start lại nếu đã active
// - Set cookie với đầy đủ thuộc tính bảo mật
// =========================================================
if (session_status() === PHP_SESSION_NONE) {
    // Cấu hình session cookie bảo mật TRƯỚC khi start
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',          // Để trống: chỉ domain hiện tại
        'secure'   => true,        // Chỉ gửi qua HTTPS
        'httponly' => true,        // Chặn JavaScript đọc cookie
        'samesite' => 'Lax',       // Chống CSRF
    ]);
    session_name($SESSION_NAME);
    session_start();
}
if (!function_exists('AntiSpamGetHiddenFields')) {
    function AntiSpamGetHiddenFields(){
        global $spam_csrf, $from_time, $signature, $js_token;
        $html = '';
        static $css_loaded = false;
        if (!$css_loaded) {
            $html .= '
        <style>
        .via_antispam_field{
            position:absolute!important;
            left:-99999px!important;
            top:-99999px!important;
            width:1px!important;
            height:1px!important;
            opacity:0!important;
            visibility:hidden!important;
            pointer-events:none!important;
            z-index:-9999!important;
            overflow:hidden!important;
        }
        </style>
        ';
        $css_loaded = true;
        }
        $html .= '<input type="text" name="via_spam_csrf" class="via_antispam_field" value="'.htmlspecialchars($spam_csrf, ENT_QUOTES, 'UTF-8').'" autocomplete="off" tabindex="-1" />'."\n";
        $html .= '<input type="text" name="via_from_time" class="via_antispam_field" value="'.htmlspecialchars($from_time, ENT_QUOTES, 'UTF-8').'" autocomplete="off" tabindex="-1" />'."\n";
        $html .= '<input type="text" name="via_signature" class="via_antispam_field" value="'.htmlspecialchars($signature, ENT_QUOTES, 'UTF-8').'" autocomplete="off" tabindex="-1" />'."\n";
        $html .= '<input type="text" name="via_js_token" class="via_antispam_field via_js_token" value="'.htmlspecialchars($js_token, ENT_QUOTES, 'UTF-8').'" autocomplete="off" tabindex="-1" />'."\n";
        $html .= '<input type="text" name="via_key" class="via_antispam_field" value="" autocomplete="off" tabindex="-1" />'."\n";
        return $html;
    }
}

// =========================================================
// [FIX BẢO MẬT #5] Xóa setcookie() thừa sau session_start()
// - Gọi setcookie() thủ công sau session_start() là dư thừa
//   vì session_set_cookie_params() đã cấu hình đầy đủ.
// - Gọi lại còn có thể gây lỗi "headers already sent".
// =========================================================
// ĐÃ XÓA: setcookie(session_name(), session_id(), [...])
