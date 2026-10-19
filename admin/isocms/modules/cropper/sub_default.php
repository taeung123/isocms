<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/Webp/vendor/autoload.php';

use WebPConvert\WebPConvert;

function default_open_cropper()
{
    //ini_set('display_errors', 1);
    //error_reporting(E_ALL ^ E_NOTICE);
    global $smarty, $_frontIsLoggedin_user_id, $core, $clsISO;
    $table_id = Input::post('table_id', 0);
    $imgdata = Input::post('imgdata');
    $smarty->assign('objectUrl', $imgdata);
    #
    $openFrom = Input::post('openFrom', 'image');
    $smarty->assign('openFrom', $openFrom);
    // Return
    $html = $core->build('_ajax.cropper.tpl');
    echo $html;
    die();
}
function default_upload_image()
{
    global $smarty, $_frontIsLoggedin_user_id, $core, $clsISO;
    global $clsConfiguration, $oneProfile, $profile_id;
    $clsTable = $_POST['clsTable'] ?? '';
    $openFrom = $_POST['openFrom'] ?? '';
    $table_id = !empty($_POST['table_id']) ? $_POST['table_id'] : 0;
    $toField  = !empty($_POST['toField']) ? $_POST['toField'] : 'image';
    $toId     = !empty($_POST['toId']) ? $_POST['toId'] : '';
    $imgdata  = $_FILES['imgdata'] ?? [];
    $filename = $clsISO->getUniqid();
    $check = ($openFrom == "image_hotel" && $toId == "isoman_show_image_hotel");
    $clsTableArr = ["Configuration", "Meta"];
    $clsClassTable = !empty($clsTable) ? new $clsTable() : null;
    # Ngày hiện tại
    $today = date("Y_m_d");
    # ===============================
    # XÁC ĐỊNH FOLDER LƯU FILE
    # ===============================
    if (!empty($clsTable)) {
        // uploads/{clsTable}/{today}/
        $upload_dir = dirname(getcwd()) . "/uploads/{$clsTable}/{$today}/";
        $link_file  = "/uploads/{$clsTable}/{$today}/" . $filename . ".webp";
    } else {
        // Webp/{today}/ (fallback cũ)
        $upload_dir = dirname(getcwd()) . "/Webp/{$today}/";
        $link_file  = "/Webp/{$today}/" . $filename . ".webp";
    }
    # Tạo folder nếu chưa tồn tại
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $file_tmp  = $_FILES['imgdata']['tmp_name'] ?? '';
    $webp_file = $upload_dir . $filename . ".webp";
    $msg = '_error';
    try {
        # Convert sang WebP
        WebPConvert::convert($file_tmp, $webp_file, [
            'quality'      => 80,
            'max-quality'  => 90,
            'method'       => 6,
            'sharp-yuv'    => true,
            'metadata'     => 'none'
        ]);
        # ===============================
        # UPDATE DATABASE
        # ===============================
        if (!empty($clsTable) && $table_id > 0 && !empty($imgdata)) {
            if ($check) {
                $msg = '_success|||' . $link_file;
            } else {
                $file_old = $clsClassTable->getOne($table_id, $toField);
                if ($clsClassTable->updateOne($table_id, array(
                    $toField => $link_file
                ))) {
                    # Xóa file cũ
                    if (!empty($file_old[$toField])) {
                        $file_delete = dirname(getcwd()) . $file_old[$toField];
                        if (file_exists($file_delete)) {
                            unlink($file_delete);
                        }
                    }
                    $msg = '_success|||' . $link_file;
                }
            }
        } else if ($openFrom == 'seo') {
            $msg = '_success|||' . $link_file;
        } else if ($openFrom == "banner" && in_array($clsTable, $clsTableArr)) {
            $msg = '_success|||' . $link_file;
        }
    } catch (Exception $e) {
        $msg = "Error: " . $e->getMessage();
    }

    echo $msg;
    die();
}
function default_upload_gallery()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO, $package_id, $profile_id;

    $tp = Input::post('tp', '_crop');
    $table_id = (int) Input::post('table_id', 0);
    $clsTableGal = Input::post('clsTableGal');
    $clsClassTableGal = new $clsTableGal();

    $msg = '_error';

    if ($tp == '_crop') {

        $filename = $clsISO->getUniqid();
        $img_title = !empty($_POST['img_title']) ? $_POST['img_title'] : '';

        // Thư mục upload theo ngày
        $today = date('Y_m_d');
        $upload_dir = dirname(getcwd()) . "/Webp/{$today}/";

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_tmp = isset($_FILES['imgdata']['tmp_name'])
            ? $_FILES['imgdata']['tmp_name']
            : '';

        // Lấy định dạng file ảnh gốc
        $original_name = isset($_FILES['imgdata']['name'])
            ? $_FILES['imgdata']['name']
            : '';

        $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

        // Chỉ chấp nhận các định dạng ảnh được phép
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp');

        if (
            !empty($file_tmp)
            && is_uploaded_file($file_tmp)
            && file_exists($file_tmp)
            && in_array($extension, $allowed_extensions)
            && @getimagesize($file_tmp) !== false
        ) {
            // Giữ nguyên phần mở rộng của ảnh gốc
            $new_filename = $filename . '.' . $extension;

            $target_file = $upload_dir . $new_filename;
            $link_file = "/Webp/{$today}/" . $new_filename;

            // Di chuyển file gốc, không chuyển đổi định dạng
            if (move_uploaded_file($file_tmp, $target_file)) {

                chmod($target_file, 0644);

                $clsClassTableGal->insert(array(
                    $clsClassTableGal->pkey => $clsClassTableGal->getMaxId(),
                    'type' => $clsTableGal,
                    'table_id' => $table_id,
                    'image' => $link_file,
                    'title' => $img_title,
                    'slug' => $core->replaceSpace($img_title),
                    'order_no' => $clsClassTableGal->getMaxOrderNo(),
                    'reg_date' => time()
                ));

                $msg = '_success|||' . $link_file;
            } else {
                $msg = '_error_upload';
            }
        } else {
            $msg = '_error';
        }

    } else {

        // Xử lý list_images
        $list_images = Input::post('list_images');
        $list_images = explode('|', $list_images);

        foreach ($list_images as $image) {
            if (!empty($image) && file_exists(ABSPATH . $image)) {
                $clsClassTableGal->insert(array(
                    $clsClassTableGal->pkey => $clsClassTableGal->getMaxId(),
                    'type' => $clsTableGal,
                    'table_id' => $table_id,
                    'image' => $image,
                    'title' => '',
                    'slug' => '',
                    'order_no' => $clsClassTableGal->getMaxOrderNo(),
                    'reg_date' => time()
                ));

                $msg = 'success';
            }
        }
    }

    echo $msg;
    die();
}


function default_ajDeleteGalImg()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule;
    // header('Content-Type: application/json');
    $clsTable = Input::post('clsTable');
    $clsClassTable = new $clsTable();
    $table_id = (int)Input::post('table_id', 0);
    $image_id = (int)Input::post('image_id', 0);
    #
    $result = array('result' => 'error', 'mes' => $core->get_Lang('error_data_image'));
    if ($image_id == 0) {
        $result = array('result' => 'error', 'mes' => $core->get_Lang('error_data_image'));
    } else if ($image_id) {
        if ($clsClassTable->deleteOne($image_id)) {
            $result = array('result' => 'success', 'mes' => $core->get_Lang('success_del_image'));
        } else {
            $result = array('result' => 'error', 'mes' => $core->get_Lang('error_del_image'));
        }
    }
    // Return
    echo @json_encode($result);
    die();
}

function default_upload_image_isoman()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    $user_id = $core->_USER['user_id'];
    #
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $clsTable = isset($_POST['type']) ? $_POST['type'] : '';
    $file_images = isset($_POST['file_images']) ? $_POST['file_images'] : '';
    #
    if ($file_images != '') {
        $file_images = rtrim($file_images, '|');
        $file_images = explode('|', $file_images);
        if ($file_images != '' && !empty($clsTable)) {
            $clsClassTable = new $clsTable();
            $clsClassTable->updateOne($table_id, array(
                'image' => $file_images[0]
            ));
        }
        echo $file_images[0];
    }
}
