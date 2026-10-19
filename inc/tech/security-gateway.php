<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL & ~E_STRICT);
require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/class_ISO.php";
$clsISO = new ISO();
#
$validToken = $clsISO->hashHmacIsoCms();

#
if (!isset($_GET['token']) || $_GET['token'] !== $validToken) {
    header("HTTP/1.1 403 Forbidden");
    exit("Access denied");
}

// Kiểm tra file truyền vào
if (!isset($_GET['file'])) {
    die("Invalid access");
}

$file = basename($_GET['file']); // chống ../

// Không cho load lại gateway hoặc file security
if ($file === 'security-gateway.php' || $file === 'security-check.php') {
    die("Access denied");
}

$path = __DIR__ . '/' . $file;

if (!file_exists($path)) {
    header("HTTP/1.1 404 Not Found");
    exit;
}

require_once($path);
