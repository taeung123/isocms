<?php
global $smarty, $core, $clsConfiguration, $dbconn, $mod, $act;

// Kiểm tra xem có yêu cầu cập nhật từ công tắc không
if (isset($_GET['mod']) && $_GET['mod'] == 'social' && isset($_GET['act']) && $_GET['act'] == 'updateConfig') {
    $field = isset($_GET['field']) ? $_GET['field'] : null;
    $value = isset($_GET['value']) ? intval($_GET['value']) : 0;

    if ($field) {
        $clsConfiguration->updateValue($field, $value);

        // Tùy chọn: Thông báo khi cập nhật thành công
        if ($value == 0) {
            echo "<script>alert('Facebook Link đã bị tắt!');</script>";
        }

        // Load lại trang
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=social');
        exit;
    }
}

// Xử lý cập nhật các giá trị khác nếu cần
if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration') {
    foreach ($_POST as $key => $val) {
        $tmp = explode('-', $key);
        if ($tmp[0] == 'iso') {
            $clsConfiguration->updateValue($tmp[1], $val);
        }
    }
    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=social&message=UpdateSuccess');
}

