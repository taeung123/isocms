<?php
/*======================================================================*\
|| #################################################################### ||
|| # The database configurations of the ISOCMS                        # ||
|| # ISOCMS By VietISO (support@vietiso.com)        			      # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2025 VietISO JSC.             # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/

/**
 * Lấy danh sách các tệp .php mới được thêm trong các thư mục và thư mục con theo ngày.
 *
 * @param string $directory Thư mục gốc để quét.
 * @param string $date Ngày cần kiểm tra (định dạng Y-m-d).
 * @return array Danh sách các tệp .php thỏa mãn điều kiện.
 */
function getNewPhpFilesByDate($directory, $date)
{
    $result = [];
    $dateStart = strtotime($date . " 00:00:00");
    $dateEnd = strtotime($date . " 23:59:59");

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $fileModifiedTime = $file->getMTime();
            if ($fileModifiedTime >= $dateStart) {
                $result[] = $file->getPathname();
            }
        }
    }

    return $result;
}

// Sử dụng hàm
$directoryToScan = __DIR__; // Thư mục gốc
$dateToCheck = date('d-m-Y'); // Ngày muốn kiểm tra
$phpFiles = getNewPhpFilesByDate($directoryToScan, $dateToCheck);

if (!empty($phpFiles)) {
    echo "Danh sách các tệp .php mới được thay đổi vào ngày $dateToCheck:\n </br>";
    foreach ($phpFiles as $file) {
        echo $file . "\n </br>";
    }
} else {
    echo "Không tìm thấy tệp .php nào mới được thêm vào ngày $dateToCheck.\n";
}
