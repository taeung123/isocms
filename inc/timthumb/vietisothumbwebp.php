<?php
// ============================================================
// vietisothumbwebp.php – FIXED VERSION (security audit 2026-04-05)
// Fix: path traversal, SSRF, DoS, SSL verify, ALLOW_EXTERNAL bypass,
//      jigrss bypass, off-by-one cache, debug log path, backtick RCE
// ============================================================

// === [FIX 1] PATH TRAVERSAL VALIDATION – PHẢI ĐẶT ĐẦU TIÊN ===
$raw_src = $_GET['src'] ?? '';

// Chặn null byte
if (strpos($raw_src, "\0") !== false) {
    http_response_code(400); exit('Invalid request.');
}
// Chặn path traversal patterns
if (preg_match('#(\.\.[\\/]|[\\/]\.\.|^\.\.)#', $raw_src)) {
    http_response_code(400); exit('Invalid request.');
}
// Chặn absolute path
if (preg_match('#^[\\/]#', $raw_src)) {
    http_response_code(400); exit('Invalid request.');
}
// Chặn PHP stream wrappers
if (preg_match('#(php://|phar://|zip://|data:|expect://)#i', $raw_src)) {
    http_response_code(400); exit('Invalid request.');
}
// Chỉ cho phép extension ảnh
if (!preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $raw_src)) {
    http_response_code(400); exit('Invalid file type.');
}

// Validate realpath nằm trong docroot
$_docRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
if (!$_docRoot) {
    http_response_code(500); exit('Server configuration error.');
}
$_safeSrc = realpath($_docRoot . '/' . $raw_src);
if ($_safeSrc === false || strpos($_safeSrc, $_docRoot) !== 0) {
    http_response_code(403); exit('Access denied.');
}
// Chỉ từ đây $_safeSrc mới được dùng làm source path
$url_image_webp = $_safeSrc;
// === END FIX 1 ===

// === [FIX 2] WebPConvert – dùng $_safeSrc, không dùng $_GET['src'] raw ===
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/Webp/vendor/autoload.php';
use WebPConvert\WebPConvert;

// Tính $url_image từ safe path
$_relative = substr($_safeSrc, strlen($_docRoot) + 1);
$_imageWithoutWebpDir = preg_replace('#^Webp/#i', '', $_relative);
$_imageWithoutExt     = preg_replace('/\.webp$/i', '', $_imageWithoutWebpDir);
$_source              = $_docRoot . '/' . $_imageWithoutExt;
$_destination         = $_docRoot . '/Webp/' . $_imageWithoutExt . '.webp';

// [FIX] Chỉ convert nếu destination chưa tồn tại (tránh re-convert mỗi request)
if (!file_exists($url_image_webp) || @getimagesize($url_image_webp) === false) {
    if (file_exists($_source)) {
        // Tạo thư mục destination nếu chưa có
        $destDir = dirname($_destination);
        if (!is_dir($destDir)) {
            @mkdir($destDir, 0750, true);
        }
        try {
            WebPConvert::convert($_source, $_destination, []);
        } catch (\Exception $e) {
            // Log lỗi, không expose ra ngoài
            error_log('WebPConvert error: ' . $e->getMessage());
        }
    }
}
// === END FIX 2 ===

// ============================================================
// TimThumb – WebP patched version (with security fixes)
// ============================================================
define('VERSION', '2.8.14-sec');

if (file_exists(dirname(__FILE__) . '/vietisothumb-config.php')) {
    require_once('vietisothumb-config.php');
}

if (!defined('DEBUG_ON'))                   define('DEBUG_ON', false);
if (!defined('DEBUG_LEVEL'))                define('DEBUG_LEVEL', 1);
if (!defined('MEMORY_LIMIT'))               define('MEMORY_LIMIT', '30M');
if (!defined('BLOCK_EXTERNAL_LEECHERS'))    define('BLOCK_EXTERNAL_LEECHERS', false);
if (!defined('DISPLAY_ERROR_MESSAGES'))     define('DISPLAY_ERROR_MESSAGES', false); // [FIX] false on production
if (!defined('ALLOW_EXTERNAL'))             define('ALLOW_EXTERNAL', TRUE);
if (!defined('ALLOW_ALL_EXTERNAL_SITES'))   define('ALLOW_ALL_EXTERNAL_SITES', false);
if (!defined('FILE_CACHE_ENABLED'))         define('FILE_CACHE_ENABLED', TRUE);
if (!defined('FILE_CACHE_TIME_BETWEEN_CLEANS')) define('FILE_CACHE_TIME_BETWEEN_CLEANS', 86400);
if (!defined('FILE_CACHE_MAX_FILE_AGE'))    define('FILE_CACHE_MAX_FILE_AGE', 86400);
if (!defined('FILE_CACHE_SUFFIX'))          define('FILE_CACHE_SUFFIX', '.timthumb.txt');
if (!defined('FILE_CACHE_PREFIX'))          define('FILE_CACHE_PREFIX', 'timthumb');
// [FIX] Cache directory ngoài webroot
if (!defined('FILE_CACHE_DIRECTORY'))       define('FILE_CACHE_DIRECTORY', ''); // rỗng = sys_get_temp_dir()
if (!defined('MAX_FILE_SIZE'))              define('MAX_FILE_SIZE', 10485760);
if (!defined('CURL_TIMEOUT'))               define('CURL_TIMEOUT', 20);
if (!defined('WAIT_BETWEEN_FETCH_ERRORS'))  define('WAIT_BETWEEN_FETCH_ERRORS', 3600);
if (!defined('BROWSER_CACHE_MAX_AGE'))      define('BROWSER_CACHE_MAX_AGE', 31536000); // [FIX] 1 năm
if (!defined('BROWSER_CACHE_DISABLE'))      define('BROWSER_CACHE_DISABLE', false);
if (!defined('MAX_WIDTH'))                  define('MAX_WIDTH', 3000);
if (!defined('MAX_HEIGHT'))                 define('MAX_HEIGHT', 2000);
if (!defined('NOT_FOUND_IMAGE'))            define('NOT_FOUND_IMAGE', '');
if (!defined('ERROR_IMAGE'))               define('ERROR_IMAGE', '');
if (!defined('PNG_IS_TRANSPARENT'))         define('PNG_IS_TRANSPARENT', FALSE);
if (!defined('DEFAULT_Q'))                  define('DEFAULT_Q', 85); // [FIX] giảm từ 90
if (!defined('DEFAULT_ZC'))                 define('DEFAULT_ZC', 1);
if (!defined('DEFAULT_F'))                  define('DEFAULT_F', '');
if (!defined('DEFAULT_S'))                  define('DEFAULT_S', 0);
if (!defined('DEFAULT_CC'))                 define('DEFAULT_CC', 'ffffff');
if (!defined('DEFAULT_WIDTH'))              define('DEFAULT_WIDTH', 100);
if (!defined('DEFAULT_HEIGHT'))             define('DEFAULT_HEIGHT', 100);
if (!defined('OPTIPNG_ENABLED'))            define('OPTIPNG_ENABLED', false);
if (!defined('OPTIPNG_PATH'))               define('OPTIPNG_PATH', '/usr/bin/optipng');
if (!defined('PNGCRUSH_ENABLED'))           define('PNGCRUSH_ENABLED', false);
if (!defined('PNGCRUSH_PATH'))              define('PNGCRUSH_PATH', '/usr/bin/pngcrush');
// [FIX] WEBSHOT tắt hoàn toàn
if (!defined('WEBSHOT_ENABLED'))            define('WEBSHOT_ENABLED', false);
if (!defined('WEBSHOT_CUTYCAPT'))           define('WEBSHOT_CUTYCAPT', '/usr/local/bin/CutyCapt');
if (!defined('WEBSHOT_XVFB'))               define('WEBSHOT_XVFB', '/usr/bin/xvfb-run');
if (!defined('WEBSHOT_SCREEN_X'))           define('WEBSHOT_SCREEN_X', '1024');
if (!defined('WEBSHOT_SCREEN_Y'))           define('WEBSHOT_SCREEN_Y', '768');
if (!defined('WEBSHOT_COLOR_DEPTH'))        define('WEBSHOT_COLOR_DEPTH', '24');
if (!defined('WEBSHOT_IMAGE_FORMAT'))       define('WEBSHOT_IMAGE_FORMAT', 'png');
if (!defined('WEBSHOT_TIMEOUT'))            define('WEBSHOT_TIMEOUT', '20');
if (!defined('WEBSHOT_USER_AGENT'))         define('WEBSHOT_USER_AGENT', "Mozilla/5.0");
if (!defined('WEBSHOT_JAVASCRIPT_ON'))      define('WEBSHOT_JAVASCRIPT_ON', true);
if (!defined('WEBSHOT_JAVA_ON'))            define('WEBSHOT_JAVA_ON', false);
if (!defined('WEBSHOT_PLUGINS_ON'))         define('WEBSHOT_PLUGINS_ON', true);
if (!defined('WEBSHOT_PROXY'))              define('WEBSHOT_PROXY', '');
if (!defined('WEBSHOT_XVFB_RUNNING'))       define('WEBSHOT_XVFB_RUNNING', false);

if (!isset($ALLOWED_SITES)) {
    $ALLOWED_SITES = array(
        'flickr.com',
        'staticflickr.com',
        'picasa.com',
        'img.youtube.com',
        'upload.wikimedia.org',
        'photobucket.com',
        'imgur.com',
        'imageshack.us',
        'tinypic.com',
        // Thêm domain của bạn tại đây (chỉ hostname, không có http://)
    );
}

timthumb::start();

class timthumb {
    protected $src = "";
    protected $is404 = false;
    protected $docRoot = "";
    protected $lastURLError = false;
    protected $localImage = "";
    protected $localImageMTime = 0;
    protected $url = false;
    protected $myHost = "";
    protected $isURL = false;
    protected $cachefile = '';
    protected $errors = array();
    protected $toDeletes = array();
    protected $cacheDirectory = '';
    protected $startTime = 0;
    protected $lastBenchTime = 0;
    protected $cropTop = false;
    protected $salt = "";
    protected $fileCacheVersion = 2; // [FIX] increment để clear cache cũ
    protected $filePrependSecurityBlock = "<?php die('Execution denied!'); //";
    protected static $curlDataWritten = 0;
    protected static $curlFH = false;

    public static function start() {
        $tim = new timthumb();
        $tim->handleErrors();
        $tim->securityChecks();
        if ($tim->tryBrowserCache()) { exit(0); }
        $tim->handleErrors();
        if (FILE_CACHE_ENABLED && $tim->tryServerCache()) { exit(0); }
        $tim->handleErrors();
        $tim->run();
        $tim->handleErrors();
        exit(0);
    }

    public function __construct() {
        global $ALLOWED_SITES, $ALLOWED_HOTLINKERS;
        $this->startTime = microtime(true);
        date_default_timezone_set('UTC');
        $this->debug(1, "Starting new request from " . $this->getIP() . " to " . $_SERVER['REQUEST_URI']);
        $this->calcDocRoot();
        $this->salt = @filemtime(__FILE__) . '-' . @fileinode(__FILE__);

        // Cache directory
        if (FILE_CACHE_DIRECTORY) {
            if (!is_dir(FILE_CACHE_DIRECTORY)) {
                @mkdir(FILE_CACHE_DIRECTORY, 0750, true);
                if (!is_dir(FILE_CACHE_DIRECTORY)) {
                    $this->error("Could not create the file cache directory.");
                    return false;
                }
            }
            $this->cacheDirectory = FILE_CACHE_DIRECTORY;
            // [FIX] Không tạo index.html trong cache dir ngoài webroot
        } else {
            $this->cacheDirectory = sys_get_temp_dir();
        }

        $this->cleanCache();
        $this->myHost = preg_replace('/^www\./i', '', $_SERVER['HTTP_HOST']);

        $raw_src = $this->param('src');
        if (substr($raw_src, 0, 14) === "https%3A%2F%2F" || substr($raw_src, 0, 13) === "http%3A%2F%2F") {
            $this->src = urldecode($raw_src);
        } else {
            $this->src = $raw_src;
        }

        $this->url = parse_url($this->src);
        $this->src = preg_replace('/https?:\/\/(?:www\.)?' . $this->myHost . '/i', '', $this->src);

        if (strlen($this->src) <= 3) {
            $this->error("No image specified");
            return false;
        }

        // [FIX] Xóa jigrss bypass – không có lý do tồn tại
        if (BLOCK_EXTERNAL_LEECHERS && !empty($_SERVER['HTTP_REFERER'])) {
            $allowed = false;
            if (!empty($ALLOWED_HOTLINKERS)) {
                foreach ($ALLOWED_HOTLINKERS as $site) {
                    if ($site == 'SAME_HOST' && !empty($_SERVER['SERVER_NAME'])) {
                        $site = preg_replace('/^www\./i', '', $_SERVER['SERVER_NAME']);
                        $site = str_replace('.', '\.', $site);
                        if (preg_match('/^https?:\/\/(?:[^\/]*?)' . $site . '(?:[\/:]|$)/i', $_SERVER['HTTP_REFERER'])) {
                            $allowed = true;
                            break;
                        }
                    } else {
                        $site = str_replace(array('.', '*'), array('\.', '([^\/]*)'), $site);
                        if (preg_match('/^https?:\/\/' . $site . '(?:[\/:]|$)/i', $_SERVER['HTTP_REFERER'])) {
                            $allowed = true;
                            break;
                        }
                    }
                }
            }
            if (!$allowed && !preg_match('/^https?:\/\/(?:www\.)?' . $this->myHost . '(?:$|\/)/i', $_SERVER['HTTP_REFERER'])) {
                $imgData = base64_decode("R0lGODlhUAAMAIAAAP8AAP///yH5BAAHAP8ALAAAAABQAAwAAAJpjI+py+0Po5y0OgAMjjv01YUZOGplhWXfNa6JCLnWkXplrcBmW+spbwvaVr/cDyg7IoFC2KbYVC2NQ5MQ4ZNao9Ynzjl9ScNYpnebDULB3RP6JuPuaGfuuV4fumf8PuvqFyhYtjdoeFgAADs=");
                header('Content-Type: image/gif');
                header('Content-Length: ' . strlen($imgData));
                header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
                echo $imgData;
                return false;
            }
        }

        if (preg_match('/^https?:\/\/[^\/]+/i', $this->src)) {
            $this->isURL = true;
        }

        if ($this->isURL && (!ALLOW_EXTERNAL)) {
            $this->error("You are not allowed to fetch images from an external website.");
            return false;
        }

        // [FIX] SSRF Protection – block private/internal addresses
        if ($this->isURL) {
            $parsedHost = strtolower($this->url['host'] ?? '');

            // Block non-HTTP scheme
            $scheme = strtolower($this->url['scheme'] ?? '');
            if (!in_array($scheme, ['http', 'https'], true)) {
                $this->error("Only HTTP/HTTPS URLs are allowed.");
                return false;
            }

            $blockedPatterns = [
                '/^localhost$/i',
                '/^127\.\d+\.\d+\.\d+$/',
                '/^10\.\d+\.\d+\.\d+$/',
                '/^172\.(1[6-9]|2\d|3[01])\.\d+\.\d+$/',
                '/^192\.168\.\d+\.\d+$/',
                '/^169\.254\.\d+\.\d+$/',  // AWS metadata
                '/^100\.(6[4-9]|[7-9]\d|1[01]\d|12[0-7])\.\d+\.\d+$/', // CGNAT
                '/^::1$/',
                '/^0\.0\.0\.0$/',
            ];

            foreach ($blockedPatterns as $pattern) {
                if (preg_match($pattern, $parsedHost)) {
                    $this->error("Access to internal addresses is not allowed.");
                    return false;
                }
            }

            // DNS rebinding protection
            $resolvedIP = gethostbyname($parsedHost);
            if ($resolvedIP !== $parsedHost) {
                foreach ($blockedPatterns as $pattern) {
                    if (preg_match($pattern, $resolvedIP)) {
                        $this->error("Resolved IP is a private address (DNS rebinding protection).");
                        return false;
                    }
                }
            }

            // Check ALLOWED_SITES
            if (!ALLOW_ALL_EXTERNAL_SITES) {
                $allowed = false;
                foreach ($ALLOWED_SITES as $site) {
                    $site = preg_replace('#^https?://(www\.)?#i', '', $site);
                    $site = strtolower(trim($site));
                    $hostLower = strtolower($parsedHost);
                    if ($hostLower === $site || substr($hostLower, -(strlen($site) + 1)) === '.' . $site) {
                        $allowed = true;
                        break;
                    }
                }
                if (!$allowed) {
                    return $this->error("You may not fetch images from that external site.");
                }
            }
        }

        // Build cache file path
        $cachePrefix = ($this->isURL ? '_ext_' : '_int_');
        if ($this->isURL) {
            $arr = explode('&', $_SERVER['QUERY_STRING']);
            asort($arr);
            $this->cachefile = $this->cacheDirectory . '/' . FILE_CACHE_PREFIX . $cachePrefix . md5($this->salt . implode('', $arr) . $this->fileCacheVersion) . FILE_CACHE_SUFFIX;
        } else {
            // Tilde fix
            if (preg_match('%(?:/~.+?)(/.*)%i', $this->param('src'), $regs)) {
                $this->src = $regs[1];
            }
            $this->localImage = $this->getLocalImagePath($this->src);
            if (!$this->localImage) {
                // [FIX] Không tự động chuyển sang URL nếu ALLOW_EXTERNAL = false
                if (!ALLOW_EXTERNAL) {
                    $this->error("Local image not found and external fetching is disabled.");
                    $this->set404();
                    return false;
                }
                $this->isURL = true;
                $this->src   = $this->param('src');
                $arr = explode('&', $_SERVER['QUERY_STRING']);
                asort($arr);
                $this->cachefile = $this->cacheDirectory . '/' . FILE_CACHE_PREFIX . $cachePrefix . md5($this->salt . implode('', $arr) . $this->fileCacheVersion) . FILE_CACHE_SUFFIX;
            } else {
                $this->localImageMTime = @filemtime($this->localImage);
                $this->cachefile = $this->cacheDirectory . '/' . FILE_CACHE_PREFIX . $cachePrefix . md5($this->salt . $this->localImageMTime . $_SERVER['QUERY_STRING'] . $this->fileCacheVersion) . FILE_CACHE_SUFFIX;
            }
        }

        return true;
    }

    public function __destruct() {
        foreach ($this->toDeletes as $del) {
            @unlink($del);
        }
    }

    public function run() {
        if ($this->isURL) {
            if (!ALLOW_EXTERNAL) {
                $this->error("You are not allowed to fetch images from an external website.");
                return false;
            }
            if ($this->param('webshot')) {
                // [FIX] WEBSHOT disabled always (RCE risk)
                $this->error("Webshots are disabled.");
            } else {
                $this->serveExternalImage();
            }
        } else {
            $this->serveInternalImage();
        }
        return true;
    }

    protected function handleErrors() {
        if ($this->haveErrors()) {
            if (NOT_FOUND_IMAGE && $this->is404()) {
                if ($this->serveImg(NOT_FOUND_IMAGE)) { exit(0); }
            }
            if (ERROR_IMAGE) {
                if ($this->serveImg(ERROR_IMAGE)) { exit(0); }
            }
            $this->serveErrors();
            exit(0);
        }
        return false;
    }

    protected function tryBrowserCache() {
        if (BROWSER_CACHE_DISABLE) { return false; }
        if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            $mtime = false;
            if (!is_file($this->cachefile)) { return false; }
            if ($this->localImageMTime) {
                $mtime = $this->localImageMTime;
            } else if (is_file($this->cachefile)) {
                $mtime = @filemtime($this->cachefile);
            }
            if (!$mtime) { return false; }
            $iftime = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
            if ($iftime < 1) { return false; }
            if ($iftime < $mtime) { return false; }
            header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
            return true;
        }
        return false;
    }

    protected function tryServerCache() {
        if (file_exists($this->cachefile)) {
            if ($this->isURL) {
                if (filesize($this->cachefile) < 1) {
                    if (time() - @filemtime($this->cachefile) > WAIT_BETWEEN_FETCH_ERRORS) {
                        @unlink($this->cachefile);
                        return false;
                    } else {
                        $this->set404();
                        $this->error("An error occured fetching image.");
                        return false;
                    }
                }
            }
            if ($this->serveCacheFile()) { return true; }
            @unlink($this->cachefile);
            return true;
        }
    }

    protected function error($err) {
        $this->errors[] = $err;
        return false;
    }

    protected function haveErrors() {
        return sizeof($this->errors) > 0;
    }

    protected function serveErrors() {
        header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
        // [FIX] Không lộ chi tiết lỗi trong production
        if (DISPLAY_ERROR_MESSAGES) {
            $html = '<ul>';
            foreach ($this->errors as $err) {
                $html .= '<li>' . htmlentities($err) . '</li>';
            }
            $html .= '</ul>';
            echo '<h1>VietISOThumb error</h1>' . $html;
            echo '<br>Query String: ' . htmlentities($_SERVER['QUERY_STRING'], ENT_QUOTES);
        } else {
            echo 'Image processing error.';
        }
    }

    protected function serveInternalImage() {
        if (!$this->localImage) {
            $this->error("localImage not set.");
            return false;
        }
        $fileSize = filesize($this->localImage);
        if ($fileSize > MAX_FILE_SIZE) {
            $this->error("File exceeds maximum allowed size.");
            return false;
        }
        if ($fileSize <= 0) {
            $this->error("File is empty.");
            return false;
        }
        if ($this->processImageAndWriteToCache($this->localImage)) {
            $this->serveCacheFile();
            return true;
        }
        return false;
    }

    protected function cleanCache() {
        if (FILE_CACHE_TIME_BETWEEN_CLEANS < 0) { return; }
        $lastCleanFile = $this->cacheDirectory . '/timthumb_cacheLastCleanTime.touch';
        if (!is_file($lastCleanFile)) {
            @touch($lastCleanFile);
            return;
        }
        if (@filemtime($lastCleanFile) < (time() - FILE_CACHE_TIME_BETWEEN_CLEANS)) {
            @touch($lastCleanFile);
            $files = glob($this->cacheDirectory . '/*' . FILE_CACHE_SUFFIX);
            if ($files) {
                $timeAgo = time() - FILE_CACHE_MAX_FILE_AGE;
                foreach ($files as $file) {
                    if (@filemtime($file) < $timeAgo) {
                        @unlink($file);
                    }
                }
            }
        }
    }

    protected function processImageAndWriteToCache($localImage) {
        $sData = @getimagesize($localImage);
        if (!$sData) {
            return $this->error("Cannot read image metadata.");
        }
        $origType = $sData[2];
        $mimeType = $sData['mime'];

        if (!preg_match('/^image\/(?:gif|jpg|jpeg|png|webp)$/i', $mimeType)) {
            return $this->error("The image is not a valid gif, jpg, webp or png.");
        }

        if (!function_exists('imagecreatetruecolor')) {
            return $this->error('GD Library Error: imagecreatetruecolor does not exist.');
        }

        if (function_exists('imagefilter') && defined('IMG_FILTER_NEGATE')) {
            $imageFilters = array(
                1 => array(IMG_FILTER_NEGATE, 0),
                2 => array(IMG_FILTER_GRAYSCALE, 0),
                3 => array(IMG_FILTER_BRIGHTNESS, 1),
                4 => array(IMG_FILTER_CONTRAST, 1),
                5 => array(IMG_FILTER_COLORIZE, 4),
                6 => array(IMG_FILTER_EDGEDETECT, 0),
                7 => array(IMG_FILTER_EMBOSS, 0),
                8 => array(IMG_FILTER_GAUSSIAN_BLUR, 0),
                9 => array(IMG_FILTER_SELECTIVE_BLUR, 0),
                10 => array(IMG_FILTER_MEAN_REMOVAL, 0),
                11 => array(IMG_FILTER_SMOOTH, 0),
            );
        }

        $new_width  = (int) abs($this->param('w', 0));
        $new_height = (int) abs($this->param('h', 0));
        $zoom_crop  = (int) $this->param('zc', DEFAULT_ZC);
        $quality    = (int) abs($this->param('q', DEFAULT_Q));
        $align      = $this->cropTop ? 't' : $this->param('a', 'c');
        $filters    = $this->param('f', DEFAULT_F);
        $sharpen    = (bool) $this->param('s', DEFAULT_S);
        $canvas_color = $this->param('cc', DEFAULT_CC);
        $canvas_trans = (bool) $this->param('ct', '1');

        if ($new_width == 0 && $new_height == 0) {
            $new_width  = (int) DEFAULT_WIDTH;
            $new_height = (int) DEFAULT_HEIGHT;
        }

        // [FIX] MAX_WIDTH/MAX_HEIGHT limit – bỏ comment đã bị xóa trước đây
        $new_width  = min(max(1, $new_width),  MAX_WIDTH);
        $new_height = min(max(1, $new_height), MAX_HEIGHT);

        $this->setMemoryLimit();

        $image = $this->openImage($mimeType, $localImage);
        if ($image === false) {
            return $this->error('Unable to open image.');
        }

        $width    = imagesx($image);
        $height   = imagesy($image);
        $origin_x = 0;
        $origin_y = 0;

        if ($new_width && !$new_height) {
            $new_height = floor($height * ($new_width / $width));
        } else if ($new_height && !$new_width) {
            $new_width = floor($width * ($new_height / $height));
        }

        if ($zoom_crop == 3) {
            $final_height = $height * ($new_width / $width);
            if ($final_height > $new_height) {
                $new_width = $width * ($new_height / $height);
            } else {
                $new_height = $final_height;
            }
        }

        $canvas = imagecreatetruecolor($new_width, $new_height);
        imagealphablending($canvas, false);

        if (strlen($canvas_color) == 3) {
            $canvas_color = str_repeat(substr($canvas_color, 0, 1), 2) . str_repeat(substr($canvas_color, 1, 1), 2) . str_repeat(substr($canvas_color, 2, 1), 2);
        } else if (strlen($canvas_color) != 6) {
            $canvas_color = DEFAULT_CC;
        }

        $canvas_color_R = hexdec(substr($canvas_color, 0, 2));
        $canvas_color_G = hexdec(substr($canvas_color, 2, 2));
        $canvas_color_B = hexdec(substr($canvas_color, 4, 2));

        if (preg_match('/^image\/png$/i', $mimeType) && !PNG_IS_TRANSPARENT && $canvas_trans) {
            $color = imagecolorallocatealpha($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 127);
        } else {
            $color = imagecolorallocatealpha($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 0);
        }

        imagefill($canvas, 0, 0, $color);

        if ($zoom_crop == 2) {
            $final_height = $height * ($new_width / $width);
            if ($final_height > $new_height) {
                $origin_x = $new_width / 2;
                $new_width = $width * ($new_height / $height);
                $origin_x = round($origin_x - ($new_width / 2));
            } else {
                $origin_y = $new_height / 2;
                $new_height = $final_height;
                $origin_y = round($origin_y - ($new_height / 2));
            }
        }

        imagesavealpha($canvas, true);

        if ($zoom_crop > 0) {
            $src_x = $src_y = 0;
            $src_w = $width;
            $src_h = $height;
            $cmp_x = $width / $new_width;
            $cmp_y = $height / $new_height;

            if ($cmp_x > $cmp_y) {
                $src_w = round($width / $cmp_x * $cmp_y);
                $src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
            } else if ($cmp_y > $cmp_x) {
                $src_h = round($height / $cmp_y * $cmp_x);
                $src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
            }

            if ($align) {
                if (strpos($align, 't') !== false) { $src_y = 0; }
                if (strpos($align, 'b') !== false) { $src_y = $height - $src_h; }
                if (strpos($align, 'l') !== false) { $src_x = 0; }
                if (strpos($align, 'r') !== false) { $src_x = $width - $src_w; }
            }

            imagecopyresampled($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
        } else {
            imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        }

        if ($filters != '' && function_exists('imagefilter') && defined('IMG_FILTER_NEGATE')) {
            $filterList = explode('|', $filters);
            foreach ($filterList as $fl) {
                $filterSettings = explode(',', $fl);
                if (isset($imageFilters[$filterSettings[0]])) {
                    for ($i = 0; $i < 4; $i++) {
                        if (!isset($filterSettings[$i])) {
                            $filterSettings[$i] = null;
                        } else {
                            $filterSettings[$i] = (int) $filterSettings[$i];
                        }
                    }
                    switch ($imageFilters[$filterSettings[0]][1]) {
                        case 0: imagefilter($canvas, $imageFilters[$filterSettings[0]][0]); break;
                        case 1: imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1]); break;
                        case 2: imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2]); break;
                        case 3: imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3]); break;
                        case 4: imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3], $filterSettings[4]); break;
                    }
                }
            }
        }

        if ($sharpen && function_exists('imageconvolution')) {
            $sharpenMatrix = array(array(-1, -1, -1), array(-1, 16, -1), array(-1, -1, -1));
            imageconvolution($canvas, $sharpenMatrix, 8, 0);
        }

        if ((IMAGETYPE_PNG == $origType || IMAGETYPE_GIF == $origType) && function_exists('imageistruecolor') && !imageistruecolor($image) && imagecolortransparent($image) > 0) {
            imagetruecolortopalette($canvas, false, imagecolorstotal($image));
        }

        $imgType  = "";
        $tempfile = tempnam($this->cacheDirectory, 'timthumb_tmpimg_');
        if (preg_match('/^image\/(?:jpg|jpeg)$/i', $mimeType)) {
            $imgType = 'jpg';
            imagejpeg($canvas, $tempfile, $quality);
        } else if (preg_match('/^image\/png$/i', $mimeType)) {
            $imgType = 'png';
            imagepng($canvas, $tempfile, floor($quality * 0.09));
        } else if (preg_match('/^image\/gif$/i', $mimeType)) {
            $imgType = 'gif';
            imagegif($canvas, $tempfile);
        } else if (preg_match('/^image\/webp$/i', $mimeType)) {
            $imgType = 'webp';
            imagewebp($canvas, $tempfile, $quality);
        } else {
            imagedestroy($canvas);
            imagedestroy($image);
            return $this->error("Could not match mime type.");
        }

        // [FIX] OPTIPNG/PNGCRUSH – dùng escapeshellarg thay backtick trực tiếp
        if ($imgType == 'png' && OPTIPNG_ENABLED && OPTIPNG_PATH && @is_file(OPTIPNG_PATH)) {
            $presize = filesize($tempfile);
            shell_exec(escapeshellcmd(OPTIPNG_PATH) . ' -o1 ' . escapeshellarg($tempfile));
            clearstatcache();
        } else if ($imgType == 'png' && PNGCRUSH_ENABLED && PNGCRUSH_PATH && @is_file(PNGCRUSH_PATH)) {
            $tempfile2 = tempnam($this->cacheDirectory, 'timthumb_tmpimg_');
            $this->toDelete($tempfile2);
            shell_exec(escapeshellcmd(PNGCRUSH_PATH) . ' ' . escapeshellarg($tempfile) . ' ' . escapeshellarg($tempfile2));
            if (is_file($tempfile2) && filesize($tempfile2) < filesize($tempfile)) {
                @unlink($tempfile);
                $tempfile = $tempfile2;
            } else {
                @unlink($tempfile2);
            }
        }

        // Write cache with security prepend
        $tempfile4 = tempnam($this->cacheDirectory, 'timthumb_tmpimg_');
        $context   = stream_context_create();
        $fp        = fopen($tempfile, 'r', 0, $context);
        file_put_contents($tempfile4, $this->filePrependSecurityBlock . $imgType . ' ?>');
        file_put_contents($tempfile4, $fp, FILE_APPEND);
        fclose($fp);
        @unlink($tempfile);

        $lockFile = $this->cachefile . '.lock';
        $fh = fopen($lockFile, 'w');
        if (!$fh) {
            return $this->error("Could not open the lockfile.");
        }
        if (flock($fh, LOCK_EX)) {
            @unlink($this->cachefile);
            rename($tempfile4, $this->cachefile);
            flock($fh, LOCK_UN);
            fclose($fh);
            @unlink($lockFile);
        } else {
            fclose($fh);
            @unlink($lockFile);
            @unlink($tempfile4);
            return $this->error("Could not get a lock for writing.");
        }

        imagedestroy($canvas);
        imagedestroy($image);
        return true;
    }

    protected function calcDocRoot() {
        $docRoot = @$_SERVER['DOCUMENT_ROOT'];
        if (defined('LOCAL_FILE_BASE_DIRECTORY')) { $docRoot = LOCAL_FILE_BASE_DIRECTORY; }
        if (!isset($docRoot) && isset($_SERVER['SCRIPT_FILENAME'])) {
            $docRoot = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
        }
        if (!isset($docRoot) && isset($_SERVER['PATH_TRANSLATED'])) {
            $docRoot = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
        }
        if ($docRoot && $_SERVER['DOCUMENT_ROOT'] != '/') {
            $docRoot = preg_replace('/\/$/', '', $docRoot);
        }
        $this->docRoot = $docRoot;
    }

    protected function getLocalImagePath($src) {
        $src = ltrim($src, '/');
        if (!$this->docRoot) {
            $file = preg_replace('/^.*?([^\/\\\\]+)$/', '$1', $src);
            if (is_file($file)) { return $this->realpath($file); }
            return $this->error("Could not find document root.");
        } else if (!is_dir($this->docRoot)) {
            $this->error("Server path does not exist.");
        }

        if (file_exists($this->docRoot . '/' . $src)) {
            $real = $this->realpath($this->docRoot . '/' . $src);
            if (stripos($real, $this->docRoot) === 0) { return $real; }
        }

        $absolute = $this->realpath('/' . $src);
        if ($absolute && file_exists($absolute)) {
            if (stripos($absolute, $this->docRoot) === 0) { return $absolute; }
        }

        if (strstr($_SERVER['SCRIPT_FILENAME'], ':')) {
            $sub_directories = explode('\\', str_replace($this->docRoot, '', $_SERVER['SCRIPT_FILENAME']));
        } else {
            $sub_directories = explode('/', str_replace($this->docRoot, '', $_SERVER['SCRIPT_FILENAME']));
        }

        $base = $this->docRoot;
        foreach ($sub_directories as $sub) {
            $base .= $sub . '/';
            if (file_exists($base . $src)) {
                $real = $this->realpath($base . $src);
                if (stripos($real, $this->realpath($this->docRoot)) === 0) { return $real; }
            }
        }
        return false;
    }

    protected function realpath($path) {
        $remove_relatives = '/\w+\/\.\.\//';
        while (preg_match($remove_relatives, $path)) {
            $path = preg_replace($remove_relatives, '', $path);
        }
        return preg_match('#^\.\./|/\.\./#', $path) ? realpath($path) : $path;
    }

    protected function toDelete($name) {
        $this->toDeletes[] = $name;
    }

    // [FIX] serveWebshot disabled
    protected function serveWebshot() {
        return $this->error("Webshot feature is disabled for security reasons.");
    }

    protected function serveExternalImage() {
        if (!preg_match('/^https?:\/\/[a-zA-Z0-9\-\.]+/i', $this->src)) {
            $this->error("Invalid URL supplied.");
            return false;
        }
        $tempfile = tempnam($this->cacheDirectory, 'timthumb');
        $this->toDelete($tempfile);
        if (!$this->getURL($this->src, $tempfile)) {
            @unlink($this->cachefile);
            @touch($this->cachefile);
            $this->error("Error reading the URL from remote host.");
            return false;
        }
        $mimeType = $this->getMimeType($tempfile);
        if (!preg_match("/^image\/(?:jpg|jpeg|gif|png|webp)$/i", $mimeType)) {
            @unlink($this->cachefile);
            @touch($this->cachefile);
            // [FIX] Không lộ $tempfile path và mimetype chi tiết
            $this->error("The remote file is not a valid image.");
            return false;
        }
        if ($this->processImageAndWriteToCache($tempfile)) {
            return $this->serveCacheFile();
        }
        return false;
    }

    public static function curlWrite($h, $d) {
        fwrite(self::$curlFH, $d);
        self::$curlDataWritten += strlen($d);
        if (self::$curlDataWritten > MAX_FILE_SIZE) { return 0; }
        return strlen($d);
    }

    // MB: Updated to handle webP (4-letter imgtype)
    protected function serveCacheFile() {
        $webPOffset = 0;
        if (!is_file($this->cachefile)) {
            $this->error("Cache file not found.");
            return false;
        }
        $fp = fopen($this->cachefile, 'rb');
        if (!$fp) { return $this->error("Could not open cachefile."); }
        fseek($fp, strlen($this->filePrependSecurityBlock), SEEK_SET);
        $imgType = fread($fp, 4);
        if (strtolower($imgType) === 'webp') {
            $webPOffset = 1;
        } else {
            $imgType = substr($imgType, 0, 3);
            fseek($fp, -1, SEEK_CUR);
        }
        fseek($fp, 3, SEEK_CUR);
        if (ftell($fp) != strlen($this->filePrependSecurityBlock) + 6 + $webPOffset) {
            @unlink($this->cachefile);
            return $this->error("Cached image file is corrupt.");
        }
        $imageDataSize = filesize($this->cachefile) - (strlen($this->filePrependSecurityBlock) + 6 + $webPOffset);
        $this->sendImageHeaders($imgType, $imageDataSize);
        $bytesSent = @fpassthru($fp);
        fclose($fp);
        if ($bytesSent > 0) { return true; }
        $content = file_get_contents($this->cachefile);
        if ($content !== false) {
            // [FIX] off-by-one: dùng + $webPOffset, không phải - $webPOffset
            $content = substr($content, strlen($this->filePrependSecurityBlock) + 6 + $webPOffset);
            echo $content;
            return true;
        }
        return $this->error("Cache file could not be read.");
    }

    protected function sendImageHeaders($mimeType, $dataSize) {
        if (!preg_match('/^image\//i', $mimeType)) { $mimeType = 'image/' . $mimeType; }
        if (strtolower($mimeType) == 'image/jpg') { $mimeType = 'image/jpeg'; }
        header('Content-Type: ' . $mimeType);
        header('Accept-Ranges: none');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Content-Length: ' . $dataSize);
        if (BROWSER_CACHE_DISABLE) {
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header("Pragma: no-cache");
            header('Expires: ' . gmdate('D, d M Y H:i:s', time()));
        } else {
            header('Cache-Control: max-age=' . BROWSER_CACHE_MAX_AGE . ', must-revalidate, public');
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + BROWSER_CACHE_MAX_AGE) . ' GMT');
        }
        return true;
    }

    protected function securityChecks() {}

    protected function param($property, $default = '') {
        return isset($_GET[$property]) ? $_GET[$property] : $default;
    }

    protected function openImage($mimeType, $src) {
        switch ($mimeType) {
            case 'image/jpeg': return @imagecreatefromjpeg($src);
            case 'image/png':
                $img = @imagecreatefrompng($src);
                if ($img) { imagealphablending($img, true); imagesavealpha($img, true); }
                return $img;
            case 'image/gif':  return @imagecreatefromgif($src);
            case 'image/webp': return function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($src) : false;
            default:
                $this->error("Unrecognised mimeType: $mimeType");
                return false;
        }
    }

    // [FIX] getIP – chỉ tin REMOTE_ADDR, không trust X-Forwarded-For
    protected function getIP() {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }

    protected function debug($level, $msg) {
        if (DEBUG_ON && $level <= DEBUG_LEVEL) {
            $execTime = sprintf('%.6f', microtime(true) - $this->startTime);
            // [FIX] Ghi vào error_log thay vì file trong webroot
            error_log("TimThumb Debug [$execTime]: $msg");
        }
    }

    protected function sanityFail($msg) {
        return $this->error("Internal error. Please report: $msg");
    }

    protected function getMimeType($file) {
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $file);
            finfo_close($finfo);
            return $mime;
        }
        $info = @getimagesize($file);
        return (is_array($info) && isset($info['mime'])) ? $info['mime'] : '';
    }

    protected function setMemoryLimit() {
        $inimem   = ini_get('memory_limit');
        $inibytes = timthumb::returnBytes($inimem);
        $ourbytes = timthumb::returnBytes(MEMORY_LIMIT);
        if ($inibytes < $ourbytes) {
            @ini_set('memory_limit', MEMORY_LIMIT);
        }
    }

    protected static function returnBytes($size_str) {
        switch (substr($size_str, -1)) {
            case 'M': case 'm': return (int)$size_str * 1048576;
            case 'K': case 'k': return (int)$size_str * 1024;
            case 'G': case 'g': return (int)$size_str * 1073741824;
            default: return $size_str;
        }
    }

    protected function getURL($url, $tempfile) {
        $this->lastURLError = false;
        $url = preg_replace('/ /', '%20', $url);
        if (function_exists('curl_init')) {
            self::$curlFH = fopen($tempfile, 'w');
            if (!self::$curlFH) {
                $this->error("Could not open $tempfile for writing.");
                return false;
            }
            self::$curlDataWritten = 0;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 VietISOThumb/" . VERSION);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            // [FIX] SSL_VERIFYPEER = TRUE
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
            curl_setopt($curl, CURLOPT_CAINFO, '/etc/ssl/certs/ca-certificates.crt');
            curl_setopt($curl, CURLOPT_WRITEFUNCTION, 'timthumb::curlWrite');
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            // [FIX] Giảm MAXREDIRS từ 10 xuống 3
            curl_setopt($curl, CURLOPT_MAXREDIRS, 3);

            $curlResult = curl_exec($curl);
            fclose(self::$curlFH);
            $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpStatus == 404) { $this->set404(); }
            if (!$curlResult) {
                $this->lastURLError = curl_error($curl);
                curl_close($curl);
                return false;
            }
            curl_close($curl);
            return true;
        } else {
            $img = @file_get_contents($url);
            if ($img === false) {
                $err = error_get_last();
                $this->lastURLError = is_array($err) ? $err['message'] : (string)$err;
                if (preg_match('/404/', $this->lastURLError)) { $this->set404(); }
                return false;
            }
            if (!file_put_contents($tempfile, $img)) {
                $this->error("Could not write to tempfile.");
                return false;
            }
            return true;
        }
    }

    protected function serveImg($file) {
        $s = @getimagesize($file);
        if (!($s && $s['mime'])) { return false; }
        header('Content-Type: ' . $s['mime']);
        header('Content-Length: ' . filesize($file));
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header("Pragma: no-cache");
        $bytes = @readfile($file);
        if ($bytes > 0) { return true; }
        $content = @file_get_contents($file);
        if ($content !== false) { echo $content; return true; }
        return false;
    }

    protected function set404() { $this->is404 = true; }
    protected function is404()  { return $this->is404; }
}
