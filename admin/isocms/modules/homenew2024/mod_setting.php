<?php

function default_setting()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $sub, $action;
    global $core, $smarty, $clsModule, $clsButtonNav, $clsISO, $clsConfiguration, $_LANG_ID;
    #
    $clsAdminButton = new AdminButton();
    #

    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $assign_list['action'] = $action;
    if (!empty($action)) {
        if ($core->isAjax()) {
            require_once(ISOCMS_DIR . "/_header.php");
            $smarty->assign($assign_list);
            echo $core->getBlock("box_setting_" . $action);
            exit();
        } else {
            $assign_list['setting_block'] = "box_setting_" . $action;
            $link_load = PCMS_URL . '/homenew2024/setting/' . $action;
            if (!empty($_POST)) {

                if (!empty($_POST['submit']) && ($_POST['submit'] == 'mail_config' || $_POST['submit'] == 'notification_config' || $_POST['submit'] == 'home_config')) {
                    foreach ($_POST as $key => $val) {
                        $tmp = explode('-', $key);
                        if ($tmp[0] == 'iso') {
                            $clsConfiguration->updateValue($tmp[1], $val);
                        }
                    }

                    $link_load .= '&message=updateSuccess';
                }

                if (!empty($_POST['submit']) && ($_POST['submit'] == 'UpdateFrontLang' || $_POST['submit'] == 'UpdateAdminLang')) {
                    if ($_POST['submit'] == 'UpdateFrontLang') {
                        $dir = $_SERVER['DOCUMENT_ROOT'] . '/lang/' . $_LANG_ID . '.php';
                    } else if ($_POST['submit'] == 'UpdateAdminLang') {
                        $dir = $_SERVER['DOCUMENT_ROOT'] . '/admin/lang/' . $_LANG_ID . '.php';
                    }

                    $lang_permission = substr(sprintf('%o', fileperms($dir)), -4);

                    if (!empty($dir) && $lang_permission == '0777') {
                        $key = $_POST['key'];
                        $value = $_POST['value'];
                        $change = $_POST['change'];
                        $delete = $_POST['delete'];

                        if (!empty($delete)) {
                            removeLanguages($dir, $delete, $_POST['submit']);
                        }

                        if (!empty($change)) {
                            removeLanguages($dir, $change, $_POST['submit']);
                        }

                        if (empty($delete) && !empty($key)) {
                            $lines = file($dir, FILE_IGNORE_NEW_LINES);

                            for ($i = 0; $i < count($key); $i++) {
                                if ($key[$i] != '') {
                                    $escapedKey = str_replace('"', '&quot;', $key[$i]);
                                    $val = str_replace('"', '&quot;', $value[$i]);
                                    if ($_POST['submit'] == 'UpdateAdminLang') {
                                        $exact_match = '$_ADMINLANG["' . $escapedKey . '"]';
                                    } else if ($_POST['submit'] == 'UpdateFrontLang') {
                                        $exact_match = '$_FRONTLANG["' . $escapedKey . '"]';
                                    }
                                    $line = $exact_match . '="' . $val . '";';
                                    foreach ($lines as $existingLine) {
                                        if (strpos($existingLine, $exact_match) !== false) {
                                            $link_load .= '&message=keyExist';
                                            header('location:' . $link_load);
                                            exit;
                                        }
                                    }
                                    array_splice($lines, 3, 0, $line);
                                }
                            }
                            file_put_contents($dir, implode("\n", $lines));
                        }
                    }
                }

                header('location:' . $link_load);
                exit();
            }
        }
    }
    #
}

function removeLanguages($dir, $data, $submit)
{
    $lines_remove = file($dir, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($data as $_key) {
        if ($submit == 'UpdateAdminLang') {
            $exact_match = '$_ADMINLANG["' . $_key . '"]';
        } else if ($submit == 'UpdateFrontLang') {
            $exact_match = '$_FRONTLANG["' . $_key . '"]';
        }

        $lines_remove = array_filter($lines_remove, function ($line_rm) use ($exact_match) {
            return strpos($line_rm, $exact_match) !== 0;
        });
    }
    file_put_contents($dir, implode("\n", $lines_remove));
}

function default_ajaxpayment() {
    global $core, $clsConfiguration, $clsISO, $assign_list;
    $clsConfiguration = new Configuration();
    $assign_list['clsConfiguration'] = $clsConfiguration;

    // Đảm bảo trả về dữ liệu JSON
    header('Content-Type: application/json');

    // Kiểm tra yêu cầu AJAX (dạng JSON)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(file_get_contents('php://input'))) {
        // Dữ liệu được gửi qua AJAX
        $input = json_decode(file_get_contents('php://input'), true);

        // Log dữ liệu nhận được
        error_log('Dữ liệu nhận được: ' . print_r($input, true));

        // Xử lý AJAX toggle (phần công tắc)
        if (isset($input['ajax']) && $input['ajax'] === 'toggle') {
            $setting = $input['setting'] ?? null;
            $value = $input['value'] ?? null;

            if ($setting && $value !== null) {
                // Cập nhật giá trị cấu hình tương ứng
                $clsConfiguration->updateValue($setting, $value);
                echo json_encode(['success' => true, 'reload' => true]);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
                exit;
            }
        }

        // Kiểm tra nếu gửi form submit từ modal (cập nhật các phương thức thanh toán)
        if (isset($input['ajax']) && $input['ajax'] === 'update_multiple') {
            $paymentData = $input['paymentData'] ?? [];

            if (empty($paymentData)) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu thanh toán không hợp lệ.']);
                exit;
            }

            // Duyệt qua tất cả các phương thức thanh toán và cập nhật
            foreach ($paymentData as $key => $val) {
                // Cập nhật từng phương thức thanh toán
                $clsConfiguration->updateValue($key, $val);
            }

            // Trả về phản hồi thành công
            echo json_encode(['success' => true, 'message' => 'Cập nhật các phương thức thanh toán thành công!']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ.']);
        exit;
    }
}








