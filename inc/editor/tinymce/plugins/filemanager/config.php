<?php
// ==============================
// config.php (SECURE VERSION)
// ==============================
if (
    empty($_SESSION["verify"]) ||
    $_SESSION["verify"] !== "FileManager4TinyMCE"
) {
    exit('forbidden');
}

$root = rtrim(
    $_SERVER['DOCUMENT_ROOT'],
    '/'
);

// ==============================
// HTTPS CHECK
// ==============================
function isSecure()
{
    return (
        (
            !empty($_SERVER['HTTPS']) &&
            $_SERVER['HTTPS'] !== 'off'
        )
        ||
        $_SERVER['SERVER_PORT'] == 443
    );
}

// ==============================
// DOMAIN
// ==============================
define(
    '_ISOCMS_PROTOCOL',
    isSecure()
        ? 'https://'
        : 'http://'
);

define(
    'DOMAIN_URL',
    _ISOCMS_PROTOCOL
    . $_SERVER['HTTP_HOST']
);

// ==============================
// PATH
// ==============================
$base_url = DOMAIN_URL;

$upload_dir = '/uploads/';

$current_path = '../../../../../uploads/';
//$current_path = 'uploads/';

// ==============================
// LIMIT
// ==============================
$MaxSizeUpload = 50; // MB

// ==============================
// IMAGE CONFIG
// ==============================
$image_max_width  = 5000;
$image_max_height = 5000;

$image_resizing = false;

$image_width  = 600;
$image_height = 0;

// ==============================
// PERMISSION
// ==============================
$delete_file   = true;
$create_folder = true;
$delete_folder = true;
$upload_files  = true;
$sufix_file_name  = false;

// ==============================
// EXTENSIONS
// ==============================

// IMAGE
$ext_img = [
    'jpg',
    'jpeg',
    'png',
    'gif',
    'webp'
];

// DOCUMENT
$ext_file = [
    'doc',
    'docx',
    'pdf',
    'xls',
    'xlsx',
    'txt',
    'csv',
    'ppt',
    'pptx'
];

// VIDEO
$ext_video = [
    'mp4'
];

// MUSIC
$ext_music = [
    'mp3'
];

// ARCHIVE
$ext_misc = [
    'zip',
    'rar'
];

$ext = array_merge(
    $ext_img,
    $ext_file,
    $ext_misc,
    $ext_video,
    $ext_music
);