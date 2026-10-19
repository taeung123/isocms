<?php
/**
 * VietISOThumb – Fixed version
 * Fix: SSRF protection, cache directory ngoài webroot, ALLOWED_SITES bug
 */

define ('VERSION', '1.1.112-sec');

if (file_exists(dirname(__FILE__) . '/vietisothumb-config.php')) {
    require_once('vietisothumb-config.php');
}

if (!defined('DEBUG_ON'))                  define('DEBUG_ON', false);
if (!defined('DEBUG_LEVEL'))               define('DEBUG_LEVEL', 1);
if (!defined('MEMORY_LIMIT'))              define('MEMORY_LIMIT', '30M');
if (!defined('BLOCK_EXTERNAL_LEECHERS'))   define('BLOCK_EXTERNAL_LEECHERS', false);

// [FIX] Tắt ALLOW_EXTERNAL hoặc restrict về false nếu không cần fetch external
if (!defined('ALLOW_EXTERNAL'))            define('ALLOW_EXTERNAL', TRUE);
if (!defined('ALLOW_ALL_EXTERNAL_SITES'))  define('ALLOW_ALL_EXTERNAL_SITES', false);
if (!defined('FILE_CACHE_ENABLED'))        define('FILE_CACHE_ENABLED', TRUE);
if (!defined('FILE_CACHE_TIME_BETWEEN_CLEANS')) define('FILE_CACHE_TIME_BETWEEN_CLEANS', 86400);
if (!defined('FILE_CACHE_MAX_FILE_AGE'))   define('FILE_CACHE_MAX_FILE_AGE', 86400);
if (!defined('FILE_CACHE_SUFFIX'))         define('FILE_CACHE_SUFFIX', '.vietisothumb.txt');
if (!defined('FILE_CACHE_PREFIX'))         define('FILE_CACHE_PREFIX', 'vietisothumb');

// [FIX CRITICAL] Cache directory NGOÀI webroot — không còn ./tmp trong webroot
// Dùng sys_get_temp_dir() hoặc đặt đường dẫn tuyệt đối ngoài docroot:
if (!defined('FILE_CACHE_DIRECTORY'))      define('FILE_CACHE_DIRECTORY', '');
// Để rỗng = dùng sys_get_temp_dir(). Hoặc đặt: '/var/cache/isocms/thumb'

if (!defined('MAX_FILE_SIZE'))             define('MAX_FILE_SIZE', 10485760);
if (!defined('CURL_TIMEOUT'))              define('CURL_TIMEOUT', 30); // [FIX] giảm timeout từ 60 xuống 30
if (!defined('WAIT_BETWEEN_FETCH_ERRORS')) define('WAIT_BETWEEN_FETCH_ERRORS', 3600);
if (!defined('BROWSER_CACHE_MAX_AGE'))     define('BROWSER_CACHE_MAX_AGE', 864000);
if (!defined('BROWSER_CACHE_DISABLE'))     define('BROWSER_CACHE_DISABLE', false);
if (!defined('MAX_WIDTH'))                 define('MAX_WIDTH', 6000);
if (!defined('MAX_HEIGHT'))               define('MAX_HEIGHT', 4000);
if (!defined('NOT_FOUND_IMAGE'))           define('NOT_FOUND_IMAGE', '');
if (!defined('ERROR_IMAGE'))              define('ERROR_IMAGE', '');
if (!defined('PNG_IS_TRANSPARENT'))        define('PNG_IS_TRANSPARENT', FALSE);
if (!defined('DEFAULT_Q'))                 define('DEFAULT_Q', 85); // [FIX] giảm quality mặc định để tối ưu size
if (!defined('DEFAULT_ZC'))               define('DEFAULT_ZC', 1);
if (!defined('DEFAULT_F'))                 define('DEFAULT_F', '');
if (!defined('DEFAULT_S'))                 define('DEFAULT_S', 0);
if (!defined('DEFAULT_CC'))               define('DEFAULT_CC', 'ffffff');
if (!defined('OPTIPNG_ENABLED'))           define('OPTIPNG_ENABLED', false);
if (!defined('OPTIPNG_PATH'))              define('OPTIPNG_PATH', '/usr/bin/optipng');
if (!defined('PNGCRUSH_ENABLED'))          define('PNGCRUSH_ENABLED', false);
if (!defined('PNGCRUSH_PATH'))             define('PNGCRUSH_PATH', '/usr/bin/pngcrush');

// [FIX] Tắt hoàn toàn WEBSHOT — tính năng này có RCE risk (backtick shell_exec)
if (!defined('WEBSHOT_ENABLED'))           define('WEBSHOT_ENABLED', false);
if (!defined('WEBSHOT_CUTYCAPT'))          define('WEBSHOT_CUTYCAPT', '/usr/local/bin/CutyCapt');
if (!defined('WEBSHOT_XVFB'))              define('WEBSHOT_XVFB', '/usr/bin/xvfb-run');
if (!defined('WEBSHOT_SCREEN_X'))          define('WEBSHOT_SCREEN_X', '1024');
if (!defined('WEBSHOT_SCREEN_Y'))          define('WEBSHOT_SCREEN_Y', '768');
if (!defined('WEBSHOT_COLOR_DEPTH'))       define('WEBSHOT_COLOR_DEPTH', '24');
if (!defined('WEBSHOT_IMAGE_FORMAT'))      define('WEBSHOT_IMAGE_FORMAT', 'png');
if (!defined('WEBSHOT_TIMEOUT'))           define('WEBSHOT_TIMEOUT', '20');
if (!defined('WEBSHOT_USER_AGENT'))        define('WEBSHOT_USER_AGENT', "Mozilla/5.0");
if (!defined('WEBSHOT_JAVASCRIPT_ON'))     define('WEBSHOT_JAVASCRIPT_ON', true);
if (!defined('WEBSHOT_JAVA_ON'))           define('WEBSHOT_JAVA_ON', false);
if (!defined('WEBSHOT_PLUGINS_ON'))        define('WEBSHOT_PLUGINS_ON', true);
if (!defined('WEBSHOT_PROXY'))             define('WEBSHOT_PROXY', '');
if (!defined('WEBSHOT_XVFB_RUNNING'))      define('WEBSHOT_XVFB_RUNNING', false);

// [FIX] ALLOWED_SITES — xóa entry có http:// prefix (bug gốc), chỉ dùng hostname thuần
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
        'vietnamtraveland.com', // [FIX] bỏ http:// prefix
        // Thêm domain nội bộ của bạn tại đây nếu cần fetch external image
    );
}

vietisothumb::start();

class vietisothumb {
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
    protected $fileCacheVersion = 2; // increment để clear cache cũ sau fix bảo mật
    protected $filePrependSecurityBlock = "<?php die('Execution denied!'); //";
    protected static $curlDataWritten = 0;
    protected static $curlFH = false;

    public static function start() {
        $vietiso = new vietisothumb();
        $vietiso->handleErrors();
        $vietiso->securityChecks();
        if ($vietiso->tryBrowserCache()) {
            exit(0);
        }
        $vietiso->handleErrors();
        if (FILE_CACHE_ENABLED && $vietiso->tryServerCache()) {
            exit(0);
        }
        $vietiso->handleErrors();
        $vietiso->run();
        $vietiso->handleErrors();
        exit(0);
    }

    public function __construct() {
        global $ALLOWED_SITES;
        $this->startTime = microtime(true);
        date_default_timezone_set('UTC');
        $this->debug(1, "Starting new request from " . $this->getIP() . " to " . $_SERVER['REQUEST_URI']);
        $this->calcDocRoot();
        $this->salt = @filemtime(__FILE__) . '-' . @fileinode(__FILE__);

        if (FILE_CACHE_DIRECTORY) {
            if (!is_dir(FILE_CACHE_DIRECTORY)) {
                @mkdir(FILE_CACHE_DIRECTORY, 0750, true);
                if (!is_dir(FILE_CACHE_DIRECTORY)) {
                    $this->error("Could not create the file cache directory.");
                    return false;
                }
            }
            $this->cacheDirectory = FILE_CACHE_DIRECTORY;
            // [FIX] Không tạo index.html trong cache directory ngoài webroot (không cần thiết)
        } else {
            $this->cacheDirectory = sys_get_temp_dir();
        }

        $this->cleanCache();

        $this->myHost = preg_replace('/^www\./i', '', $_SERVER['HTTP_HOST']);
        $this->src = $this->param('src');
        $this->url = parse_url($this->src);
        $this->src = preg_replace('/https?:\/\/(?:www\.)?' . $this->myHost . '/i', '', $this->src);

        if (strlen($this->src) <= 3) {
            $this->error("No image specified");
            return false;
        }

        // Hotlinking check
        if (BLOCK_EXTERNAL_LEECHERS && array_key_exists('HTTP_REFERER', $_SERVER) &&
            (!preg_match('/^https?:\/\/(?:www\.)?' . $this->myHost . '(?:$|\/)/i', $_SERVER['HTTP_REFERER']))) {
            $imgData = base64_decode("R0lGODlhUAAMAIAAAP8AAP///yH5BAAHAP8ALAAAAABQAAwAAAJpjI+py+0Po5y0OgAMjjv01YUZOGplhWXfNa6JCLnWkXplrcBmW+spbwvaVr/cDyg7IoFC2KbYVC2NQ5MQ4ZNao9Ynzjl9ScNYpnebDULB3RP6JuPuaGfuuV4fumf8PuvqFyhYtjdoeFgAADs=");
            header('Content-Type: image/gif');
            header('Content-Length: ' . strlen($imgData));
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            echo $imgData;
            return false;
        }

        if (preg_match('/^https?:\/\/[^\/]+/i', $this->src)) {
            $this->isURL = true;
        }

        if ($this->isURL && (!ALLOW_EXTERNAL)) {
            $this->error("You are not allowed to fetch images from an external website.");
            return false;
        }

        // [FIX CRITICAL] SSRF Protection
        if ($this->isURL) {
            $parsedHost = strtolower($this->url['host'] ?? '');

            // Block private/loopback/link-local addresses
            $blockedHostPatterns = [
                '/^localhost$/i',
                '/^127\.\d+\.\d+\.\d+$/',
                '/^10\.\d+\.\d+\.\d+$/',
                '/^172\.(1[6-9]|2\d|3[01])\.\d+\.\d+$/',
                '/^192\.168\.\d+\.\d+$/',
                '/^169\.254\.\d+\.\d+$/',   // link-local / AWS metadata endpoint
                '/^100\.(6[4-9]|[7-9]\d|1[0-1]\d|12[0-7])\.\d+\.\d+$/', // CGNAT
                '/^::1$/',
                '/^0\.0\.0\.0$/',
                '/^fd[0-9a-f]{2}(:[\da-f]{0,4}){1,7}$/i', // ULA IPv6
            ];

            foreach ($blockedHostPatterns as $pattern) {
                if (preg_match($pattern, $parsedHost)) {
                    $this->error("Access to internal/private addresses is not allowed.");
                    return false;
                }
            }

            // DNS rebinding protection: resolve hostname và kiểm tra IP thực
            $resolvedIP = gethostbyname($parsedHost);
            if ($resolvedIP !== $parsedHost) { // gethostbyname trả về hostname nếu resolve fail
                foreach ($blockedHostPatterns as $pattern) {
                    if (preg_match($pattern, $resolvedIP)) {
                        $this->error("Resolved IP is a private/internal address (DNS rebinding protection).");
                        return false;
                    }
                }
            }

            // Block non-HTTP scheme
            $scheme = strtolower($this->url['scheme'] ?? '');
            if (!in_array($scheme, ['http', 'https'], true)) {
                $this->error("Only HTTP/HTTPS URLs are allowed.");
                return false;
            }

            // Check ALLOWED_SITES
            if (!ALLOW_ALL_EXTERNAL_SITES) {
                $allowed = false;
                foreach ($ALLOWED_SITES as $site) {
                    // [FIX] Strip http:// prefix nếu còn trong config
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
            $this->localImage = $this->getLocalImagePath($this->src);
            if (!$this->localImage) {
                $this->error("Could not find the internal image you specified.");
                $this->set404();
                return false;
            }
            $this->localImageMTime = @filemtime($this->localImage);
            $this->cachefile = $this->cacheDirectory . '/' . FILE_CACHE_PREFIX . $cachePrefix . md5($this->salt . $this->localImageMTime . $_SERVER['QUERY_STRING'] . $this->fileCacheVersion) . FILE_CACHE_SUFFIX;
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
                // [FIX] WEBSHOT_ENABLED phải là false (RCE risk via backtick)
                if (WEBSHOT_ENABLED) {
                    $this->serveWebshot();
                } else {
                    $this->error("Webshots are disabled on this server.");
                }
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
                if ($this->serveImg(NOT_FOUND_IMAGE)) {
                    exit(0);
                }
            }
            if (ERROR_IMAGE) {
                if ($this->serveImg(ERROR_IMAGE)) {
                    exit(0);
                }
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
            if ($iftime < $mtime) {
                return false;
            } else {
                header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
                return true;
            }
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
            if ($this->serveCacheFile()) {
                return true;
            } else {
                @unlink($this->cachefile);
                return true;
            }
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
        // [FIX] Không lộ chi tiết lỗi ra ngoài trừ khi DEBUG_ON
        if (DEBUG_ON) {
            $html = '<ul>';
            foreach ($this->errors as $err) {
                $html .= '<li>' . htmlentities($err) . '</li>';
            }
            $html .= '</ul>';
            echo '<h1>VietISOThumb error</h1>' . $html;
            echo '<br>Query String: ' . htmlentities($_SERVER['QUERY_STRING']);
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
        $lastCleanFile = $this->cacheDirectory . '/vietisothumb_cacheLastCleanTime.touch';
        if (!is_file($lastCleanFile)) {
            @touch($lastCleanFile);
            return;
        }
        if (@filemtime($lastCleanFile) < (time() - FILE_CACHE_TIME_BETWEEN_CLEANS)) {
            @touch($lastCleanFile);
            $files = glob($this->cacheDirectory . '/*' . FILE_CACHE_SUFFIX);
            if ($files) {
                $maxAge = time() - FILE_CACHE_MAX_FILE_AGE;
                foreach ($files as $file) {
                    if (@filemtime($file) < $maxAge) {
                        @unlink($file);
                    }
                }
            }
        }
    }

    protected function processImageAndWriteToCache($localImage) {
        $sData = @getimagesize($localImage);
        if (!$sData) {
            return $this->error("Cannot read image metadata. File may be corrupt.");
        }
        $origType = $sData[2];
        $mimeType = $sData['mime'];

        if (!preg_match('/^image\/(?:gif|jpg|jpeg|png|webp)$/i', $mimeType)) {
            return $this->error("The image is not a valid gif, jpg, png, or webp.");
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
            $new_width = 100;
            $new_height = 100;
        }

        $new_width  = min($new_width, MAX_WIDTH);
        $new_height = min($new_height, MAX_HEIGHT);

        $this->setMemoryLimit();

        $image = $this->openImage($mimeType, $localImage);
        if ($image === false) {
            return $this->error('Unable to open image.');
        }

        $width  = imagesx($image);
        $height = imagesy($image);
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

        if ($sharpen) {
            $sharpenMatrix = array(array(-1, -1, -1), array(-1, 16, -1), array(-1, -1, -1));
            $divisor = 8;
            $offset  = 0;
            imageconvolution($canvas, $sharpenMatrix, $divisor, $offset);
        }

        // Write to cache with security prepend
        $lockFile  = $this->cachefile . '.lock';
        $tempfile  = $this->cachefile . '.tmp';
        $tempfile2 = $this->cachefile . '.tmp2';
        $this->toDelete($tempfile);
        $this->toDelete($tempfile2);

        if ($origType == IMAGETYPE_GIF) {
            $imgType = 'gif';
        } else if ($origType == IMAGETYPE_PNG) {
            $imgType = 'png';
        } else if ($origType == IMAGETYPE_WEBP) {
            $imgType = 'webp';
        } else {
            $imgType = 'jpg';
        }

        ob_start();
        switch ($origType) {
            case IMAGETYPE_GIF:  imagegif($canvas); break;
            case IMAGETYPE_PNG:  imagepng($canvas, null, 9); break;
            case IMAGETYPE_WEBP: imagewebp($canvas, null, $quality); break;
            default:             imagejpeg($canvas, null, $quality);
        }
        $imgData = ob_get_clean();

        if (!$imgData) {
            imagedestroy($canvas);
            imagedestroy($image);
            return $this->error("Could not generate image data.");
        }

        $lockFP = fopen($lockFile, 'w');
        if (!$lockFP) {
            imagedestroy($canvas);
            imagedestroy($image);
            return $this->error("Could not open lock file.");
        }
        if (flock($lockFP, LOCK_EX | LOCK_NB)) {
            $tempFP = fopen($tempfile, 'wb');
            if ($tempFP) {
                fwrite($tempFP, $this->filePrependSecurityBlock);
                fwrite($tempFP, $imgType . ' ?>');
                fwrite($tempFP, $imgData);
                fclose($tempFP);
                rename($tempfile, $this->cachefile);
            }
            flock($lockFP, LOCK_UN);
        }
        fclose($lockFP);
        @unlink($lockFile);

        imagedestroy($canvas);
        imagedestroy($image);
        return true;
    }

    protected function serveExternalImage() {
        if (!preg_match('/^https?:\/\/[a-zA-Z0-9\-\.]+/i', $this->src)) {
            $this->error("Invalid URL supplied.");
            return false;
        }
        $tempfile = tempnam($this->cacheDirectory, 'vietisothumb');
        $this->toDelete($tempfile);
        if (!$this->getURL($this->src, $tempfile)) {
            @unlink($this->cachefile);
            @touch($this->cachefile);
            $this->error("Error reading the URL from remote host. " . $this->lastURLError);
            return false;
        }
        $mimeType = $this->getMimeType($tempfile);
        if (!preg_match("/^image\/(?:jpg|jpeg|gif|png|webp)$/i", $mimeType)) {
            @unlink($this->cachefile);
            @touch($this->cachefile);
            $this->error("The remote file is not a valid image.");
            return false;
        }
        if ($this->processImageAndWriteToCache($tempfile)) {
            return $this->serveCacheFile();
        }
        return false;
    }

    // [FIX] serveWebshot bị disable — override để luôn trả error
    protected function serveWebshot() {
        return $this->error("Webshot feature is disabled for security reasons.");
    }

    public static function curlWrite($h, $d) {
        fwrite(self::$curlFH, $d);
        self::$curlDataWritten += strlen($d);
        if (self::$curlDataWritten > MAX_FILE_SIZE) {
            return 0;
        } else {
            return strlen($d);
        }
    }

    protected function serveCacheFile() {
        if (!is_file($this->cachefile)) {
            $this->error("Cache file not found.");
            return false;
        }
        $fp = fopen($this->cachefile, 'rb');
        if (!$fp) { return $this->error("Could not open cachefile."); }
        fseek($fp, strlen($this->filePrependSecurityBlock), SEEK_SET);
        $imgType = fread($fp, 3);
        fseek($fp, 3, SEEK_CUR);
        if (ftell($fp) != strlen($this->filePrependSecurityBlock) + 6) {
            @unlink($this->cachefile);
            return $this->error("Cached image file is corrupt.");
        }
        $imageDataSize = filesize($this->cachefile) - (strlen($this->filePrependSecurityBlock) + 6);
        $this->sendImageHeaders($imgType, $imageDataSize);
        $bytesSent = @fpassthru($fp);
        fclose($fp);
        if ($bytesSent > 0) { return true; }
        $content = file_get_contents($this->cachefile);
        if ($content !== false) {
            $content = substr($content, strlen($this->filePrependSecurityBlock) + 6);
            echo $content;
            return true;
        }
        return $this->error("Cache file could not be read.");
    }

    protected function sendImageHeaders($mimeType, $dataSize) {
        if (!preg_match('/^image\//i', $mimeType)) {
            $mimeType = 'image/' . $mimeType;
        }
        if (strtolower($mimeType) == 'image/jpg') {
            $mimeType = 'image/jpeg';
        }
        $gmdate_expires  = gmdate('D, d M Y H:i:s', strtotime('now +10 days')) . ' GMT';
        $gmdate_modified = gmdate('D, d M Y H:i:s') . ' GMT';
        header('Content-Type: ' . $mimeType);
        header('Accept-Ranges: none');
        header('Last-Modified: ' . $gmdate_modified);
        header('Content-Length: ' . $dataSize);
        if (BROWSER_CACHE_DISABLE) {
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header("Pragma: no-cache");
            header('Expires: ' . gmdate('D, d M Y H:i:s', time()));
        } else {
            header('Cache-Control: max-age=' . BROWSER_CACHE_MAX_AGE . ', must-revalidate, public');
            header('Expires: ' . $gmdate_expires);
        }
        return true;
    }

    protected function securityChecks() {
        // Thêm rate limiting đơn giản dựa trên IP (nếu có APCu)
        if (function_exists('apcu_fetch')) {
            $ip = $this->getIP();
            $key = 'vietisothumb_rate_' . md5($ip);
            $count = apcu_fetch($key);
            if ($count === false) {
                apcu_store($key, 1, 60);
            } else if ($count > 100) { // max 100 requests/phút/IP
                header($_SERVER['SERVER_PROTOCOL'] . ' 429 Too Many Requests');
                exit('Rate limit exceeded.');
            } else {
                apcu_inc($key);
            }
        }
    }

    protected function param($property, $default = '') {
        if (isset($_GET[$property])) {
            return $_GET[$property];
        }
        return $default;
    }

    protected function openImage($mimeType, $src) {
        switch ($mimeType) {
            case 'image/jpeg': return @imagecreatefromjpeg($src);
            case 'image/png':  return @imagecreatefrompng($src);
            case 'image/gif':  return @imagecreatefromgif($src);
            case 'image/webp': return function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($src) : false;
            default:           return false;
        }
    }

    protected function getLocalImagePath($src) {
        $src = ltrim($src, '/');
        if (!$this->docRoot) {
            $file = preg_replace('/^.*?([^\/\\\\]+)$/', '$1', $src);
            if (is_file($file)) {
                return $this->realpath($file);
            }
            return $this->error("Could not find document root.");
        }

        if (file_exists($this->docRoot . '/' . $src)) {
            $real = $this->realpath($this->docRoot . '/' . $src);
            if (stripos($real, $this->docRoot) === 0) {
                return $real;
            }
        }

        $absolute = $this->realpath('/' . $src);
        if ($absolute && file_exists($absolute)) {
            if (stripos($absolute, $this->docRoot) === 0) {
                return $absolute;
            }
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
                if (stripos($real, $this->realpath($this->docRoot)) === 0) {
                    return $real;
                }
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

    protected function is404() {
        return $this->is404;
    }

    protected function set404() {
        $this->is404 = true;
    }

    protected function calcDocRoot() {
        $docRoot = @$_SERVER['DOCUMENT_ROOT'];
        if (defined('LOCAL_FILE_BASE_DIRECTORY')) {
            $docRoot = LOCAL_FILE_BASE_DIRECTORY;
        }
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

    protected function getURL($url, $tempfile) {
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            self::$curlDataWritten = 0;
            self::$curlFH = fopen($tempfile, 'wb');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($ch, CURLOPT_WRITEFUNCTION, array('vietisothumb', 'curlWrite'));
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, CURL_TIMEOUT);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 VietISOThumb/" . VERSION);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // [FIX] verify SSL
            // [FIX] Bind to interface để tránh SSRF qua local interface
            // curl_setopt($ch, CURLOPT_INTERFACE, 'your-public-ip');
            curl_exec($ch);
            $info = curl_getinfo($ch);
            $this->lastURLError = curl_error($ch);
            curl_close($ch);
            fclose(self::$curlFH);
            if ($info['http_code'] != 200) {
                $this->lastURLError = "HTTP " . $info['http_code'];
                return false;
            }
            return true;
        }
        $result = @file_get_contents($url);
        if ($result === false) {
            $this->lastURLError = "file_get_contents failed.";
            return false;
        }
        file_put_contents($tempfile, $result);
        return true;
    }

    protected function getMimeType($file) {
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $file);
            finfo_close($finfo);
            return $mime;
        }
        $sData = @getimagesize($file);
        return $sData ? $sData['mime'] : '';
    }

    protected function setMemoryLimit() {
        $limit = MEMORY_LIMIT;
        $currentLimit = ini_get('memory_limit');
        if ((int)$currentLimit < (int)$limit) {
            @ini_set('memory_limit', $limit);
        }
    }

    protected function serveImg($src) {
        $path = $this->getLocalImagePath($src);
        if (!$path || !is_file($path)) { return false; }
        $size = getimagesize($path);
        if (!$size) { return false; }
        header('Content-Type: ' . $size['mime']);
        header('Content-Length: ' . filesize($path));
        readfile($path);
        return true;
    }

    protected function getIP() {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        // [FIX] Không tin X-Forwarded-For nếu không qua trusted proxy
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }

    protected function debug($level, $msg) {
        if (DEBUG_ON && DEBUG_LEVEL >= $level) {
            error_log("VietISOThumb debug ($level): $msg");
        }
    }
}
