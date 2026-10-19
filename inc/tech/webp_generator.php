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

// Lấy đường dẫn tuyệt đối
$settings_document_root = dirname(__FILE__);
$file = trim(strip_tags($_GET['file']));

// thoát ra nếu không tìm thấy tệp GỐC
if (!is_file($file)) {

    // include("404.php");
    echo "không tìm thấy tệp gốc";
    exit;
}
// phát hiện xem tệp có phải là png / jpg / gif hay không, đối với gif, chúng ta sử dụng lệnh gif2webp
$file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
// mkdir -p để tạo các thư mục cha nếu cần (ví dụ: một đường dẫn đầy đủ của các thư mục con)
exec("mkdir -p " . escapeshellarg("webp/" . dirname($file)));


// Chuyển đổi png, jpg
if ($file_extension == "png" or $file_extension == "jpg") {
    exec("cwebp -q 80 " . escapeshellarg($settings_document_root . "/" . $file) . " -o" . escapeshellarg($settings_document_root . "/webp/" . $file . ".webp"));
}
// Chuyển đổi gif
if ($file_extension == "gif") {
    exec("gif2webp -q 80 " . escapeshellarg($settings_document_root . "/" . $file) . " -o" . escapeshellarg($settings_document_root . "/webp/" . $file . ".webp"));
}


// hiển thị cảnh báo nếu tệp không được tạo đúng cách, bạn có thể thay thế điều này bằng chuyển hướng header() đến hình ảnh mặc định
if (!file_exists($settings_document_root . "/webp/" . $file . ".webp")) {
    echo "không thể tạo tệp webp " . escapeshellarg("webp/" . $file);
    exit;
}

// bảo trì, xóa các tệp webp cũ, sau đó xóa các thư mục trống
exec("find webp/ -type f -mtime +30 -delete");
exec("find webp/ -type d -empty -delete");

// Tiếp tục hiển thị tệp web đã tạo
// ?tim () ở đây để nó không chuyển hướng trở lại chính nó vào lần đầu tiên khi hình ảnh được tạo
// điều đó có thể gây ra vòng lặp vô hạn vì nó lưu vào bộ nhớ cache tệp dưới dạng chuyển hướng trở lại chính nó
header("Location: /webp/" . $file . ".webp?" . time());
exit;
?>