<?php
function default_hotel_packages()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    #

    #
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $assign_list["keyword"] = $keyword;
    // Submit filter.
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';

        #
        if ($_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
        print_r($link);
        die();
    }

    // Get Parameter fiter
    $classTable = "HotelPackage";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $pUrl = '';
    $cond = "1=1";

    if ($keyword != '') {
        $cond .= " and title like '%" . $keyword . "%'";
        $assign_list["keyword"] = $keyword;
        $pUrl .= '&keyword=' . $keyword;
    }

    $assign_list['pUrl'] = $pUrl;

    #
    $cond2 = $cond;
    #
    $orderBy = " order by order_no DESC";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $lstAllItem = $clsClassTable->getAll($cond);
    $totalRecord = (is_array($lstAllItem) && count($lstAllItem) > 0) ? count($lstAllItem) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;

    $stt = ($currentPage - 1) * $recordPerPage;
    $assign_list['stt'] = $stt;


    $listPageNumber = array();
    for ($i = 1; $i <= $totalPage; $i++) {
        $listPageNumber[] = $i;
    }
    $assign_list['listPageNumber'] = $listPageNumber;
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $link_page_current = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page')
            $link_page_current .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current'] = $link_page_current;
    #-------End Page Divide-----------------------------------------------------------
    //    $clsClassTable->setdebug(1);
    $assign_list["allItem"] = $clsClassTable->getAll($cond . $orderBy . $limit);
    //    die;
    #
    $allAll = $clsClassTable->getAll($cond2 . ' and is_trash=0');
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
    #
    $allTrash = $clsClassTable->getAll($cond2 . ' and is_trash=1');
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allTopCity = $clsClassTable->getAll($cond2 . " and is_top_city=1" . $orderBy);
    $assign_list["number_top_city"] = $allTopCity[0][$pkeyTable] != '' ? count($allTopCity) : 0;
    #
    $allTopCountry = $clsClassTable->getAll($cond2 . " and is_top_country=1" . $orderBy);
    $assign_list["number_top_country"] = $allTopCountry[0][$pkeyTable] != '' ? count($allTopCountry) : 0;
    #----
}

function default_hotel_package_services()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration, $act;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $assign_list["keyword"] = $keyword;
    // Submit filter.
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';

        #
        if ($_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $link);
        print_r($link);
        die();
    }

    // Get Parameter fiter
    $classTable = "HotelService";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $pUrl = '';
    $cond = "1=1";

    if ($keyword != '') {
        $cond .= " and title like '%" . $keyword . "%'";
        $assign_list["keyword"] = $keyword;
        $pUrl .= '&keyword=' . $keyword;
    }

    $assign_list['pUrl'] = $pUrl;

    #
    $cond2 = $cond;
    #
    $orderBy = " order by order_no DESC";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $lstAllItem = $clsClassTable->getAll($cond);
    $totalRecord = (is_array($lstAllItem) && count($lstAllItem) > 0) ? count($lstAllItem) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;

    $stt = ($currentPage - 1) * $recordPerPage;
    $assign_list['stt'] = $stt;


    $listPageNumber = array();
    for ($i = 1; $i <= $totalPage; $i++) {
        $listPageNumber[] = $i;
    }
    $assign_list['listPageNumber'] = $listPageNumber;
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $link_page_current = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page')
            $link_page_current .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current'] = $link_page_current;
    #-------End Page Divide-----------------------------------------------------------

    $assign_list["allItem"] = $clsClassTable->getAll($cond . $orderBy . $limit);

    #
    $allAll = $clsClassTable->getAll($cond2 . ' and is_trash=0');
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
    #
    $allTrash = $clsClassTable->getAll($cond2 . ' and is_trash=1');
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allTopCity = $clsClassTable->getAll($cond2 . " and is_top_city=1" . $orderBy);
    $assign_list["number_top_city"] = $allTopCity[0][$pkeyTable] != '' ? count($allTopCity) : 0;
    #
    $allTopCountry = $clsClassTable->getAll($cond2 . " and is_top_country=1" . $orderBy);
    $assign_list["number_top_country"] = $allTopCountry[0][$pkeyTable] != '' ? count($allTopCountry) : 0;
    #----
}

function default_ajaxEventHotelService()
{
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL & ~E_STRICT);
    global $core, $clsISO, $lang_sql, $dbconn, $assign_list, $smarty;
    #
    $user_id = $core->_USER['user_id'];
    $clsHotelService = new HotelService();
    #
    $type = !empty($_POST['type']) ? $_POST['type'] : '';
    $hotel_service_id = !empty($_POST['hotel_service_id']) ? $_POST['hotel_service_id'] : 0;
    $assign_list['hotel_service_id'] = $hotel_service_id;
    #
    $res = array(
        'result' => false,
        'msg' => $core->get_Lang('Error'),
    );
    if ($type == 'F') {
        $oneItem = [];
        if ($hotel_service_id > 0) {
            $oneItem = $clsHotelService->getOne($hotel_service_id);
        }
        $assign_list['oneItem'] = $oneItem;

        $html = $core->build('ajaxLoadFormHotelService.tpl');
        echo $html;
        die;
    } elseif ($type == 'S') {
        $title = !empty($_POST['title']) ? addslashes($_POST['title']) : '';
        $runEvent = true;
        if ($title == '') {
            $res['msg'] = $core->get_Lang('Enter service name');
            $runEvent = false;
        } else {
            //Kiểm tra đã tồn tại tên service hay chưa
            $condCheck = $hotel_service_id > 0 ? "title='$title' AND hotel_service_id!=$hotel_service_id" : "title='$title'";
            $checkService = $clsHotelService->getByCond($condCheck . " LIMIT 1", $clsHotelService->pkey);
            if (!empty($checkService)) {
                $res['msg'] = $core->get_Lang('Service already exists');
                $runEvent = false;
            }
        }

        if ($runEvent) {
            if ($hotel_service_id > 0) {
                $dataUpdate = array(
                    "title" => $title,
                    "user_id" => $user_id,
                    "upd_date" => time(),
                );
                if ($clsHotelService->update($hotel_service_id, $dataUpdate)) {
                    $res = array(
                        'result' => true,
                        'msg' => $core->get_Lang('Update success'),
                    );
                }
            } else {
                $dataInsert = array(
                    "hotel_service_id" => $clsHotelService->getMaxId(),
                    "title" => $title,
                    "user_id" => $user_id,
                    "order_no" => $clsHotelService->getMaxOrderNo(),
                    "reg_date" => time(),
                    "upd_date" => time(),
                );

                if ($clsHotelService->insert($dataInsert)) {
                    $res = array(
                        'result' => true,
                        'msg' => $core->get_Lang('Add success'),
                    );
                }
            }
        }
    } elseif ($type == 'T') {
        $dataUpdate = array(
            "is_trash" => 1,
            "user_id" => $user_id,
            "upd_date" => time(),
        );
        if ($clsHotelService->update($hotel_service_id, $dataUpdate)) {
            $res = array(
                'result' => true,
                'msg' => $core->get_Lang('Update success'),
            );
        }
    } elseif ($type == 'R') {
        $dataUpdate = array(
            "is_trash" => 0,
            "user_id" => $user_id,
            "upd_date" => time(),
        );
        if ($clsHotelService->update($hotel_service_id, $dataUpdate)) {
            $res = array(
                'result' => true,
                'msg' => $core->get_Lang('Update success'),
            );
        }
    } elseif ($type == 'D') {
        if ($clsHotelService->deleteOne($hotel_service_id)) {
            $res = array(
                'result' => true,
                'msg' => $core->get_Lang('Delete success'),
            );
        }
    }

    die(json_encode($res));
}


function default_ajaxEventHotelPackage()
{
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL & ~E_STRICT);
    global $core, $clsISO, $lang_sql, $dbconn, $assign_list, $smarty, $dbconn;
    #
    $user_id = $core->_USER['user_id'];
    $clsHotelService = new HotelService();
    $clsHotelPackage = new HotelPackage();
    $clsHotelPackageService = new HotelPackageService();
    #
    $type = !empty($_POST['type']) ? $_POST['type'] : '';
    $hotel_package_id = !empty($_POST['hotel_package_id']) ? $_POST['hotel_package_id'] : 0;
    $assign_list['hotel_package_id'] = $hotel_package_id;
    #
    $res = array(
        'result' => false,
        'msg' => $core->get_Lang('Error'),
    );
    if ($type == 'F') {
        $lstPackageServices = $oneItem = [];
        if ($hotel_package_id > 0) {
            $oneItem = $clsHotelPackage->getOne($hotel_package_id);
            $sqlPackageServices = "SELECT hps.*, hs.title as service_title
                                    FROM default_hotel_package_service as hps 
                                    INNER JOIN default_hotel_services as hs ON hs.hotel_service_id = hps.hotel_service_id
                                    WHERE hps.hotel_package_id = 1
                                    ORDER BY hps.hotel_package_service_id ASC";
            $lstPackageServices = $dbconn->getAll($sqlPackageServices);
        }

        $assign_list['oneItem'] = $oneItem;
        $assign_list['lstPackageServices'] = $lstPackageServices;

        $html = $core->build('ajaxLoadFormHotelPackage.tpl');
        echo $html;
        die;
    } elseif ($type == 'S') {

        $title = !empty($_POST['title']) ? addslashes($_POST['title']) : '';
        $runEvent = true;
        if ($title == '') {
            $res['msg'] = $core->get_Lang('Enter service name');
            $runEvent = false;
        } else {
            //Kiểm tra đã tồn tại tên service hay chưa
            $condCheck = $hotel_package_id > 0 ? "title='$title' AND hotel_package_id!=$hotel_package_id" : "title='$title'";

            $checkService = $clsHotelPackage->getByCond($condCheck . " LIMIT 1", $clsHotelPackage->pkey);

            if (!empty($checkService)) {
                $res['msg'] = $core->get_Lang('Package already exists');
                $runEvent = false;
            }
        }

        if ($runEvent) {
            if ($hotel_package_id > 0) {
                $dataUpdate = array(
                    "title" => $title,
                    "user_id" => $user_id,
                    "upd_date" => time(),
                );
                if ($clsHotelPackage->update($hotel_package_id, $dataUpdate)) {
                    $res = array(
                        'result' => true,
                        'msg' => $core->get_Lang('Update success'),
                    );
                }
            } else {
                $hotel_package_id = $clsHotelPackage->getMaxId();
                $dataInsert = array(
                    "hotel_package_id" => $clsHotelPackage->getMaxId(),
                    "title" => $title,
                    "user_id" => $user_id,
                    "order_no" => $clsHotelPackage->getMaxOrderNo(),
                    "reg_date" => time(),
                    "upd_date" => time(),
                );

                if ($clsHotelPackage->insert($dataInsert)) {
                    $res = array(
                        'result' => true,
                        'msg' => $core->get_Lang('Add success'),
                    );
                }
            }

            if ($res['result']) {
                $lstPackageServices = !empty($_POST['lstPackageServices']) ? $_POST['lstPackageServices'] : '';
                if ($lstPackageServices != '') {
                    //Xóa dữ liệu trước trong package_services
                    $condDel = "hotel_package_id = $hotel_package_id";
                    $clsHotelPackageService->deleteByCond($condDel);
                    foreach ($lstPackageServices as $key => $item) {
                        $dataPackageService = array(
                            'hotel_package_service_id' => $clsHotelPackageService->getMaxId(),
                            'hotel_package_id' => $hotel_package_id,
                            'hotel_service_id' => $item['hotel_service_id'],
                            'intro' => $item['intro'],
                            'reg_date' => time(),
                            'upd_date' => time(),
                            'user_id' => $user_id
                        );

                        $clsHotelPackageService->insert($dataPackageService);
                    }
                }
            }
        }
    } elseif ($type == 'T') {
        $dataUpdate = array(
            "is_trash" => 1,
            "user_id" => $user_id,
            "upd_date" => time(),
        );
        if ($clsHotelPackage->update($hotel_package_id, $dataUpdate)) {
            $res = array(
                'result' => true,
                'msg' => $core->get_Lang('Update success'),
            );
        }
    } elseif ($type == 'R') {
        $dataUpdate = array(
            "is_trash" => 0,
            "user_id" => $user_id,
            "upd_date" => time(),
        );
        if ($clsHotelPackage->update($hotel_package_id, $dataUpdate)) {
            $res = array(
                'result' => true,
                'msg' => $core->get_Lang('Update success'),
            );
        }
    } elseif ($type == 'D') {
        if ($clsHotelPackage->deleteOne($hotel_package_id)) {
            //Xóa dữ liệu trước trong package_services
            $condDel = "hotel_package_id = $hotel_package_id";
            $clsHotelPackageService->deleteByCond($condDel);
            $res = array(
                'result' => true,
                'msg' => $core->get_Lang('Delete success'),
            );
        }
    }

    die(json_encode($res));
}

function default_ajaxLoadLstServices()
{
    global $lang_sql, $clsISO, $core;
    #
    $clsHotelService = new HotelService();
    #
    $lstServices = $clsHotelService->getAll('is_trash=0 AND is_online=1 ORDER BY order_no DESC', $clsHotelService->pkey . ', title');

    $res = array(
        'result' => true,
        'lstServices' => $lstServices
    );
    die(json_encode($res));
}
