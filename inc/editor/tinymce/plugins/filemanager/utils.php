<?php
// ==============================
// utils.php (SECURE VERSION)
// ==============================

if (
    empty($_SESSION["verify"]) ||
    $_SESSION["verify"] !== "FileManager4TinyMCE"
) {
    exit('forbidden');
}

// ==============================
// DELETE DIRECTORY
// ==============================
function deleteDir($dir)
{
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {

        if ($item === '.' || $item === '..') {
            continue;
        }

        if (
            !deleteDir(
                $dir
                . DIRECTORY_SEPARATOR
                . $item
            )
        ) {
            return false;
        }
    }

    return rmdir($dir);
}

// ==============================
// SANITIZE PATH
// ==============================
function _sanitizePath($path)
{
    $path = str_replace('\\', '/', $path);

    $path = trim($path, '/');

    if (strpos($path, '..') !== false) {
        return false;
    }

    if (
        preg_match(
            '#[^a-zA-Z0-9/_-]#',
            $path
        )
    ) {
        return false;
    }

    return $path;
}
/**
 * Sanitize và validate path an toàn cho FileManager
 */
function __sanitizePath($path, $baseDir = null)
{
    if (empty($path)) {
        return 'uploads'; // default folder
    }

    $path = str_replace('\\', '/', $path);
    $path = trim($path, '/');

    // Loại bỏ nhiều slash liên tiếp
    $path = preg_replace('#/{2,}#', '/', $path);

    // Block dangerous patterns
    if (preg_match('#\.\./|\.\.$|~|\x00|\x01|://#i', $path)) {
        return false;
    }

    // Chỉ cho phép chữ cái, số, -, _, / 
    if (preg_match('#[^a-zA-Z0-9/_-]#', $path)) {
        return false;
    }

    // Nếu có baseDir thì kiểm tra realpath
    if ($baseDir !== null) {
        $fullPath = realpath($baseDir . '/' . $path);
        $realBase = realpath($baseDir);

        if ($fullPath === false || strpos($fullPath, $realBase) !== 0) {
            return false; // Path traversal attempt
        }
    }

    return $path;
}
function sanitizePath($path)
{
    if (empty($path)) {
        return 'uploads';   // fallback an toàn
    }

    $path = str_replace('\\', '/', $path);
    $path = trim($path, '/');

    // Cho phép ../ tạm thời (vì Responsive Filemanager dùng nhiều ../)
    // Nhưng vẫn lọc bớt rủi ro
    $path = preg_replace('#/{2,}#', '/', $path);           // xóa ////
    $path = preg_replace('#\.\./\.\./\.\./\.\./#', '', $path); // lọc bớt ../ thừa

    // Block các ký tự nguy hiểm
    if (preg_match('#\.\./\.\.|~|\x00|\x01|://|\\\\#i', $path)) {
        return false;
    }

    return $path;
}

// ==============================
// CREATE IMAGE
// ==============================
function create_img_gd(
    $imgfile,
    $imgthumb,
    $newwidth,
    $newheight = ''
) {

    require_once 'php_image_magician.php';

    $magicianObj = new imageLib($imgfile);

    $magicianObj->resizeImage(
        $newwidth,
        $newheight,
        'crop'
    );

    $magicianObj->saveImage($imgthumb);
}

// ==============================
// RE-ENCODE IMAGE
// ==============================
function reEncodeImage($file, $ext)
{
    switch ($ext) {

        case 'jpg':
        case 'jpeg':
            $image = @imagecreatefromjpeg($file);
            break;

        case 'png':
            $image = @imagecreatefrompng($file);
            break;

        case 'gif':
            $image = @imagecreatefromgif($file);
            break;

        case 'webp':
            $image = @imagecreatefromwebp($file);
            break;

        default:
            return false;
    }

    if (!$image) {
        return false;
    }

    switch ($ext) {

        case 'png':
            imagepng($image, $file);
            break;

        case 'gif':
            imagegif($image, $file);
            break;

        case 'webp':
            imagewebp($image, $file, 85);
            break;

        default:
            imagejpeg($image, $file, 85);
            break;
    }

    imagedestroy($image);

    return true;
}

// ==============================
// FORMAT SIZE
// ==============================
function makeSize($size)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $u = 0;

    while (
        round($size / 1024) > 0 &&
        $u < 4
    ) {
        $size = $size / 1024;
        $u++;
    }

    return number_format(
        $size,
        1,
        ',',
        ''
    ) . ' ' . $units[$u];
}

// ==============================
// CREATE DIRECTORY
// ==============================
function create_folder($path = false, $path_thumbs = false)
{
    if (empty($path) && empty($path_thumbs)) {
        return false;
    }
	if (!empty($path)){
		if (file_exists($path)) {
			return true;
		}
		return mkdir(
			$path,
			0755,
			true
		);
	}
	if (!empty($path_thumbs)){
		if (file_exists($path_thumbs)) {
			return true;
		}
		return mkdir(
			$path_thumbs,
			0755,
			true
		);
	}
}

// ==============================
// VALIDATE FILE
// ==============================
function validateUploadFile($file)
{
    global $MaxSizeUpload;
    global $ext_img;
    global $ext_file;
    global $ext_video;
    global $ext_music;
    global $ext_misc;

    $maxSize =
        $MaxSizeUpload
        * 1024
        * 1024;

    if (
        !isset($file['tmp_name']) ||
        !is_uploaded_file($file['tmp_name'])
    ) {
        return [
            'status'  => false,
            'message' => 'Invalid upload source'
        ];
    }

    if (
        $file['error'] !== UPLOAD_ERR_OK
    ) {
        return [
            'status'  => false,
            'message' => 'Upload error'
        ];
    }

    if ($file['size'] > $maxSize) {
        return [
            'status'  => false,
            'message' => 'File too large'
        ];
    }

    $originalName = $file['name'];

    $ext = strtolower(
        pathinfo(
            $originalName,
            PATHINFO_EXTENSION
        )
    );

    $allowedExt = array_merge(
        $ext_img,
        $ext_file,
        $ext_video,
        $ext_music,
        $ext_misc
    );

    if (!in_array($ext, $allowedExt)) {

        return [
            'status'  => false,
            'message' => 'Extension not allowed'
        ];
    }

    // ==============================
    // BLOCK DANGEROUS FILE NAMES
    // ==============================
    if (
        preg_match(
            '/\.(php|php3|php4|php5|phtml|phar|cgi|pl|exe|sh|bat|js|html|htm|svg|xml)$/i',
            $originalName
        )
    ) {

        return [
            'status'  => false,
            'message' => 'Dangerous filename'
        ];
    }

    // ==============================
    // MIME VALIDATION
    // ==============================
    $mimeMap = [

        'jpg'  => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'png'  => ['image/png'],
        'gif'  => ['image/gif'],
        'webp' => ['image/webp'],
        'pdf'  => ['application/pdf'],

        'txt'  => ['text/plain'],
        'csv'  => ['text/csv', 'text/plain'],

        'doc' => [
            'application/msword',
            'application/octet-stream'
        ],

        'docx' => [
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/zip',
            'application/octet-stream'
        ],

        'xls' => [
            'application/vnd.ms-excel',
            'application/CDFV2',
            'application/x-ole-storage',
            'application/octet-stream'
        ],

        'xlsx' => [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/zip',
            'application/octet-stream'
        ],

        'ppt' => [
            'application/vnd.ms-powerpoint',
            'application/octet-stream'
        ],

        'pptx' => [
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/zip',
            'application/octet-stream'
        ],

        'zip' => [
            'application/zip'
        ],

        'rar' => [
            'application/x-rar-compressed'
        ],
    ];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo,$file['tmp_name']);

    finfo_close($finfo);

    if (
        !isset($mimeMap[$ext]) ||
        !in_array(
            $mimeType,
            $mimeMap[$ext]
        )
    ) {

        return [
            'status'  => false,
            'message' => 'MIME mismatch'
        ];
    }
    $scan_text_ext = ['txt', 'csv', 'svg', 'html', 'htm', 'xml', 'js', 'css'];
    // ==============================
    // BLOCK PHP PAYLOAD
    // ==============================

    if (in_array($ext, $scan_text_ext)) {   // Chỉ kiểm tra PHP payload với file KHÔNG phải ảnh
    
        $content = @file_get_contents($file['tmp_name'], false, null, 0, 1024 * 1024);

        if ($content !== false) {
            if (preg_match('/<\?php|<\?=|eval\s*\(|base64_decode\s*\(|system\s*\(|shell_exec\s*\(/i', $content)) {
                return ['status' => false, 'message' => 'PHP payload detected'];
            }
        }
    }

    $document_ext = ['doc','xls','ppt','docx','xlsx','pptx','pdf','txt','csv'];

    if (in_array($ext, $document_ext)) {

        // PDF
        if ($ext == 'pdf') {
            $head = file_get_contents($file['tmp_name'], false, null, 0, 5);
            if ($head !== '%PDF-') {
                return ['status' => false, 'message' => 'Invalid PDF file'];
            }
        }

        // Office cũ: doc/xls/ppt
        if (in_array($ext, ['doc','xls','ppt'])) {
            $head = file_get_contents($file['tmp_name'], false, null, 0, 8);
            $oleHeader = "\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1";

            if ($head !== $oleHeader) {
                return ['status' => false, 'message' => 'Invalid Office file'];
            }
        }

        // Office mới: docx/xlsx/pptx là file zip
        if (in_array($ext, ['docx','xlsx','pptx'])) {
            $head = file_get_contents($file['tmp_name'], false, null, 0, 2);

            if ($head !== 'PK') {
                return ['status' => false, 'message' => 'Invalid Office file'];
            }
        }

        return [
            'status' => true,
            'extension' => $ext
        ];
    }
    // ==============================
    // IMAGE VALIDATION
    // ==============================
    if (in_array($ext, $ext_img)) {

        $info = @getimagesize(
            $file['tmp_name']
        );

        if (!$info) {

            return [
                'status'  => false,
                'message' => 'Invalid image'
            ];
        }

        $width  = $info[0];
        $height = $info[1];

        // anti image bomb
        if (
            $width > 10000 ||
            $height > 10000 ||
            ($width * $height) > 40000000
        ) {

            return [
                'status'  => false,
                'message' => 'Image dimensions too large'
            ];
        }
    }

    return [
        'status'    => true,
        'extension' => $ext
    ];
}
function sanitizeFileName($filename)
{
    $filename = html_entity_decode(
        $filename,
        ENT_QUOTES,
        'UTF-8'
    );

    $name = pathinfo(
        $filename,
        PATHINFO_FILENAME
    );

    // bỏ ký tự đặc biệt
    $name = preg_replace(
        '/[^\pL\pN\s\-_]/u',
        '',
        $name
    );

    // space -> -
    $name = preg_replace(
        '/\s+/u',
        '-',
        $name
    );

    $name = trim($name, '-');

    // tránh quá dài
    $name = mb_substr($name, 0, 100);

    if ($name === '') {
        $name = 'file';
    }

    return $name;
}