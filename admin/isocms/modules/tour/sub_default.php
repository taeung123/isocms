<?php
function default_default()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $extLang, $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $clsUser = new User();
    $user_id = $core->_USER['user_id'];
    $user_group_id = $clsUser->getOneField('user_group_id', $user_id);
    #
    if (isset($_GET['is_set']) && $_GET['is_set'] == 'free') {
        if (!$clsConfiguration->getValue('SiteHasFreeEasy_Tours')) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
            exit();
        }
    }
    #
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    #


    $lstCountry = $clsCountry->getAll("is_trash=0 and is_online=1 and country_id IN (SELECT country_id FROM " . DB_PREFIX . "tour_destination) order by order_no asc", $clsCountry->pkey);
    $assign_list["lstCountry"] = $lstCountry;

    $SiteHasGroup_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default');;
    $tour_group_id = 0;
    if ($SiteHasGroup_Tours) {
        $clsTourGroup = new TourGroup();
        $assign_list["clsTourGroup"] = $clsTourGroup;
        $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
    }
    $assign_list["tour_group_id"] = $tour_group_id;
    #
    $cat_id = 0;
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'category', 'default')) {
        $clsTourCat = new TourCategory();
        $assign_list["clsTourCat"] = $clsTourCat;
        $cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
    }
    $assign_list["cat_id"] = $cat_id;
    #
    $price_range_id = 0;
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'price_range', 'default')) {
        $clsPriceRange = new PriceRange();
        $assign_list["clsPriceRange"] = $clsPriceRange;
        $price_range_id = isset($_GET['price_range_id']) ? intval($_GET['price_range_id']) : 0;
    }
    $assign_list["price_range_id"] = $price_range_id;
    #
    $country_id = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;
    $assign_list["country_id"] = $country_id;
    $tour_type_id = isset($_GET['tour_type_id']) ? intval($_GET['tour_type_id']) : 0;
    $assign_list["tour_type_id"] = $tour_type_id;
    $check = isset($_GET['check']) ? intval($_GET['check']) : 0;
    $assign_list["check"] = $check;
    $departure_point_id = isset($_GET['departure_point_id']) ? intval($_GET['departure_point_id']) : 0;
    $assign_list["departure_point_id"] = $departure_point_id;
    $number_day = isset($_GET['number_day']) ? intval($_GET['number_day']) : 0;
    $assign_list["number_day"] = $number_day;
    /**/
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($SiteHasGroup_Tours) {
            if (isset($_POST['tour_group_id']) && intval($_POST['tour_group_id']) != 0) {
                $link .= '&tour_group_id=' . intval($_POST['tour_group_id']);
            }
        }

        if (isset($_POST['country_id']) && intval($_POST['country_id']) != 0) {
            $link .= '&country_id=' . intval($_POST['country_id']);
        }
        if (isset($_POST['cat_id']) && intval($_POST['cat_id']) != 0) {
            $link .= '&cat_id=' . $_POST['cat_id'];
        }
        if (isset($_POST['tour_type_id']) && intval($_POST['tour_type_id']) != 0) {
            $link .= '&tour_type_id=' . $_POST['tour_type_id'];
        }
        if (isset($_POST['departure_point_id']) && intval($_POST['departure_point_id']) != 0) {
            $link .= '&departure_point_id=' . $_POST['departure_point_id'];
        }
        if (isset($_POST['number_day']) && intval($_POST['number_day']) != 0) {
            $link .= '&number_day=' . $_POST['number_day'];
        }
        if (isset($_POST['price_range_id']) && intval($_POST['price_range_id']) != 0) {
            $link .= '&price_range_id=' . $_POST['price_range_id'];
        }
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Type trip code or tour name') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    #
    $pUrl = '';
    $cond = "1=1";


    if ($tour_group_id > 0) {
        $cond .= " and tour_group_id=" . $tour_group_id;
        $pUrl .= '&tour_group_id=' . $tour_group_id;
    }
    if (intval($tour_type_id) > 0) {
        $cond .= " and tour_type_id=" . $tour_type_id;
        $pUrl .= '&tour_type_id=' . $tour_type_id;
    }
    if (intval($country_id) > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE country_id='$country_id')";
        $pUrl .= '&country_id=' . $country_id;
    }

    if (intval($cat_id) > 0) {
        $cond .= " and (cat_id = '$cat_id' or list_cat_id like '%|$cat_id|%')";
        $pUrl .= '&cat_id=' . $cat_id;
    }

    if (intval($departure_point_id) > 0) {
        $cond .= " and departure_point_id = '" . $departure_point_id . "'";
        $pUrl .= '&departure_point_id=' . $departure_point_id;
    }
    if (isset($number_day) && intval($number_day) != 0) {
        $cond .= " and number_day = '" . $number_day . "'";
        $pUrl .= '&number_day=' . $number_day;
    }

    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and ( trip_code like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%' or title like '%" . $_GET['keyword'] . "%')";

        $assign_list["keyword"] = $_GET['keyword'];
    }
    if (isset($_GET['tour_id']) && $_GET['tour_id'] != '') {
        $cond .= " and tour_id ='" . $_GET['tour_id'] . "' ";
        $assign_list["tour_id"] = $_GET['tour_id'];
    }
    $cond2 = $cond;
    if ($user_group_id == 2) {
        $cond .= " and user_id='$user_id'";
    }
    $orderBy = " order_no asc";
    #-------Page Divide---------------------------------------------------------------

    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";

    $totalRecord = $clsClassTable->getAll($cond, $clsClassTable->pkey);
    $totalRecord = $totalRecord ? count($totalRecord) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit, $clsClassTable->pkey . ",is_trash,is_online");
    //print_r($totalRecord);die();
    $assign_list["allItem"] = $allItem;
    #
    #
    // $allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2,$clsClassTable->pkey);
    // $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    //$allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2,$clsClassTable->pkey);
    //$assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
    #
    $allAll = $clsClassTable->getAll("is_trash=0", $clsClassTable->pkey);
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
    $assign_list['pUrl'] = $pUrl;

    #----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateToursIntro') {
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    $clsConfiguration->updateValue($tmp[1], $val);
                }
            }
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
        }
    }
}

function default_list_promotion()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $extLang;
    $assign_list["clsModule"] = $clsModule;
    $clsUser = new User();
    $user_id = $core->_USER['user_id'];

    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    $classTable = "HotPromotion";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;

    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    #
    $pUrl = '';
    $cond = "1=1";

    $cond2 = $cond;

    $orderBy = " '$pkeyTable' asc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";

    $totalRecord = $clsClassTable->getAll($cond) ? count($clsClassTable->getAll($cond)) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
    //print_r($cond." order by ".$orderBy.$limit);die();
    $assign_list["allItem"] = $allItem;
    #
    $allTop = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id' and is_top=1");
    $assign_list['num_top'] = (is_array($allTop) && count($allTop) > 0) ? count($allTop) : 0;
    #
    $allTop = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id' and is_promotion=1");
    $assign_list['num_promtion'] = (is_array($allTop) && count($allTop) > 0) ? count($allTop) : 0;
    #
    $allTrash = $clsClassTable->getAll("is_trash=1 and tour_type_id = '$tour_type_id' and " . $cond2);
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id' and " . $cond2);
    $assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
    #
    $allAll = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id'");
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
    $assign_list['pUrl'] = $pUrl;
    #----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateToursIntro') {
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    $clsConfiguration->updateValue($tmp[1], $val);
                }
            }
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
        }
    }
}

function default_ajUpdPosSortTour()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO;
    #
    $order = $_POST['order'] ?? [];
    #
    $clsISO->sortByData('Tour', $order);
}

function default_tourhotel()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    #
    $string = isset($_GET['tour_id']) ? ($_GET['tour_id']) : '';
    $tour_id = intval($core->decryptID($string));
    $assign_list["tour_id"] = $tour_id;
    if ($string != '' && $tour_id == 0) {
        header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
    }
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = "&act={$act}&tour_id=" . $core->encryptID($tour_id);
        if ($_POST['keyword'] != '' && $_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    $classTable = "TourHotel";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    /* List all item */
    $cond = "1='1'";
    $cond .= " and is_trash=0 and tour_id='$tour_id'";
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $keyword = $core->replaceSpace($_GET['keyword']);
        $cond .= " and hotel_id IN (SELECT hotel_id FROM " . DB_PREFIX . "hotel WHERE slug like '%" . $keyword . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $orderBy = " order by reg_date desc";
    $res = $clsClassTable->getAll($cond . $orderBy, "hotel_id");
    if (!empty($res)) {
        $tmp = array();
        for ($i = 0; $i < count($res); $i++) {
            if ($res[$i]['hotel_id'] != '' && $res[$i]['hotel_id'] != '0' && !in_array($res[$i]['hotel_id'], $tmp))
                $tmp[] = $res[$i]['hotel_id'];
        }
        $assign_list["allItem"] = $tmp;
    }
    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Delete') {
        $hotel_id = isset($_GET['hotel_id']) ? ($_GET['hotel_id']) : 0;
        $string = isset($_GET['tour_id']) ? ($_GET['tour_id']) : '';
        $tour_id = intval($core->decryptID($string));
        if (empty($tour_id)) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteByCond("tour_id='$tour_id' and hotel_id = '$hotel_id'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&tour_id=' . $core->encryptID($tour_id) . '&message=DeleteSuccess');
        }
    }
}

function default_ajMoveTourStore()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $postData = $_POST;
    $tour_id = isset($postData['tour_id']) ? ($postData['tour_id']) : '';
    $tour_id = intval($core->decryptID($tour_id));
    #
    $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
    $pvalTable = isset($postData['tour_store_id']) ? ($postData['tour_store_id']) : 0;
    $pvalTable = intval($core->decryptID($pvalTable));
    #		
    $one = $clsClassTable->getOne($pvalTable);
    $order_no = $one['order_no'];

    $cond = "is_trash=0 and tour_id = '$tour_id'";
    #
    if ($direct == 'movedown') {
        $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'moveup') {
        $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movetop') {
        $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no asc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movebottom') {
        $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no desc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    echo (1);
    die();
}
function default_edit()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,
        $clsModule, $clsButtonNav, $dbconn, $clsISO, $package_id, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $pvalTable, $clsClassTable;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #
    $clsTag = new Tag();
    $assign_list["clsTag"] = $clsTag;
    $clsPromoValue = new PromoValue();
    $assign_list["clsPromoValue"] = $clsPromoValue;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;

    $clsTourPriceGroup = new TourPriceGroup();
    $assign_list["clsTourPriceGroup"] = $clsTourPriceGroup;
    $clsConfiguration = new Configuration();
    $assign_list["clsConfiguration"] = $clsConfiguration;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    $clsTourDestination = new TourDestination();
    $assign_list["clsTourDestination"] = $clsTourDestination;
    $clsTourImage = new TourImage();
    $assign_list["clsTourImage"] = $clsTourImage;
    $clsTourExtension = new TourExtension();
    $assign_list["clsTourExtension"] = $clsTourExtension;

    $assign_list["PROMO_PERCENT"] = PROMO_PERCENT;
    $assign_list["PROMO_VALUE"] = PROMO_VALUE;

    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["get"] = $_GET;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    $clsPromoValue = new PromoValue();
    $assign_list["clsPromoValue"] = $clsPromoValue;
    $start_date = strtotime(date('d-m-Y') . ' 00:00:00');
    $listPromoValue = $clsPromoValue->getAll("is_trash=0 and due_date>='$start_date'");
    $assign_list["listPromoValue"] = $listPromoValue;
    #
    $clsCountry = new _Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $lstCity = $clsCity->getAll("is_trash=0 and country_id='1'");
    $assign_list["lstCity"] = $lstCity;
    $clsProfile = new Profile();
    $assign_list["clsProfile"] = $clsProfile;

    $tour_id = isset($_GET['tour_id']) ? ($_GET['tour_id']) : '';
    $tour_id = intval($core->decryptID($tour_id));
    $arrProfileID = array();
    $listAgenOfTour = $dbconn->getAll("SELECT taTour.tour_store_id,taTour.promo_value_id,p.company,p.profile_id,pv.type_promo FROM ta_tour_store as taTour 
	LEFT JOIN ta_profile as p on p.profile_id= taTour.profile_id 
	LEFT JOIN ta_promo_value as pv on pv.promo_value_id= taTour.promo_value_id
	WHERE taTour.is_trash=0 and taTour.tour_id='$tour_id' order by taTour.order_no DESC");
    $assign_list["listAgenOfTour"] = $listAgenOfTour;
    if (!empty($listAgenOfTour)) {
        foreach ($listAgenOfTour as $key => $value) {
            $arrProfileID[] = $value['profile_id'];
        }
        $strProfileID = implode(',', $arrProfileID);

        $cond = "is_trash=0 and type_user='" . USER_TYPE_TA . "' and profile_id NOT IN ($strProfileID) ";
        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
            $company = $core->replaceSpace($company);
            $cond .= " and company_slug like '%$company%' ";
        }
        if (!empty($_GET['email'])) {
            $email = $_GET['email'];
            $cond .= " and email like '%$email%' ";
        }
        $listProfile = $clsProfile->getAll($cond);
        $assign_list["listProfile"] = $listProfile;
    } else {
        ##
        $cond = "is_trash=0 and type_user='" . USER_TYPE_TA . "' ";
        if (!empty($_GET['email'])) {
            $email = $_GET['email'];
            $cond .= " and email like '%$email%'";
        }
        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
            $company = $core->replaceSpace($company);
            $cond .= " and company_slug like '%$company%' ";
        }
        $listProfile = $clsProfile->getAll($cond);
        $assign_list["listProfile"] = $listProfile;
    }
    #
    $SiteHasCustomContentField_Tours = $clsConfiguration->getValue("SiteHasCustomContentField_Tours");
    $SiteHasService_Tours = $clsISO->getCheckActiveModulePackage($package_id, 'property', 'service', 'default');
    $SiteHasGroup_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default');;
    $SiteHasType_Tours = $clsConfiguration->getValue('SiteHasType_Tours');
    # Tour Group
    $tour_group_id = 0;
    if ($SiteHasGroup_Tours) {
        $clsTourGroup = new TourGroup();
        $assign_list["clsTourGroup"] = $clsTourGroup;
        $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
    }
    # Tour Category
    $SiteHasCat_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'category', 'default');;
    if ($SiteHasCat_Tours) {
        $clsTourCategory = new TourCategory();
        $assign_list["clsTourCategory"] = $clsTourCategory;
    }
    # Tour Type
    $tour_type_id = 0;
    if ($SiteHasType_Tours) {
        $clsTourType = new TourType();
        $assign_list["clsTourType"] = $clsTourType;
        $tour_type_id = isset($_GET['tour_type_id']) ? intval($_GET['tour_type_id']) : 0;
    }
    # Tour Custom field
    if ($SiteHasCustomContentField_Tours) {
        $clsTourCustomField = new TourCustomField();
        $assign_list["clsTourCustomField"] = $clsTourCustomField;
    }
    # Tour Services
    $clsAddOnService = new AddOnService();
    $assign_list["clsAddOnService"] = $clsAddOnService;
    $lstAddOnService = $clsAddOnService->getAll("is_trash=0 and is_online=1 order by order_no asc");
    $assign_list["lstAddOnService"] = $lstAddOnService;
    unset($lstAddOnService);

    $clsActivities = new Activities();
    $assign_list["clsActivities"] = $clsActivities;
    $lstActivities = $clsActivities->getAll("is_trash=0 and is_online=1 order by order_no asc");
    $assign_list["lstActivities"] = $lstActivities;
    unset($lstActivities);
    #
    $clsContinent = new Continent();
    $assign_list["clsContinent"] = $clsContinent;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $assign_list["listCountry"] = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $clsRegion = new Region();
    $assign_list["clsRegion"] = $clsRegion;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTourItinerary = new TourItinerary();
    $assign_list["clsTourItinerary"] = $clsTourItinerary;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    if ($string != '' && $pvalTable == 0) {
        header('location:' . PCMS_URL . '/#notPermission');
    }
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['tour_id'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;

    if ($pvalTable > 0) {
        $tour_group_id = $oneItem['tour_group_id'];
        $tour_type_id = $oneItem['tour_type_id'];
    }
    $assign_list["tour_group_id"] = $tour_group_id;
    $assign_list["tour_type_id"] = $tour_type_id;

    # Tour Transport
    $list_transport_id = explode(',', $oneItem['list_transport_id']);
    $assign_list["list_transport_id"] = $list_transport_id;

    $list_cat_selected_id = $oneItem['list_cat_id'];
    $list_cat_selected_id = str_replace('|0|', '|', $list_cat_selected_id);
    $list_cat_selected_id = rtrim($list_cat_selected_id, '|');
    $list_cat_selected_id = ltrim($list_cat_selected_id, '|');
    $list_cat_selected_id = str_replace('|', ',', $list_cat_selected_id);
    $assign_list["list_cat_selected_id"] = $list_cat_selected_id;


    $list_departure_point_selected_id = $oneItem['list_departure_point_id'];
    $list_departure_point_selected_id = rtrim($list_departure_point_selected_id, '|');
    $list_departure_point_selected_id = ltrim($list_departure_point_selected_id, '|');
    $list_departure_point_selected_id = str_replace('|', ',', $list_departure_point_selected_id);
    $assign_list["list_departure_point_selected_id"] = $list_departure_point_selected_id;
    //print_r($list_cat_selected_id); die();


    $clsTourTransport = new TourTransport();
    $assign_list["clsTourTransport"] = $clsTourTransport;
    $lstTourTransport = $clsTourTransport->getAll("is_trash=0 order by order_no desc");
    foreach ($lstTourTransport as $key => $value) {
        if (in_array($value['tourtransport_id'], $list_transport_id))
            $lstTourTransport[$key]['check'] = 'checked="checked"';
    }
    $assign_list["lstTourTransport"] = $lstTourTransport;

    unset($lstTourTransport);

    $lstNationality = $clsTourProperty->getAll("is_trash=0 and type='NATIONALITY' order by order_no asc");
    $assign_list["lstNationality"] = $lstNationality;
    unset($lstNationality);

    $lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc");
    $assign_list["lstVisitorType"] = $lstVisitorType;
    unset($lstVisitorType);

    if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 0) {
        $lstTourOption = $clsClassTable->getOneField('tour_option', $pvalTable);
        $lstOption = array();
        if ($lstTourOption != '' && $lstTourOption != '0') {
            $TMP = explode(',', $lstTourOption);
            for ($i = 0; $i < count($TMP); $i++) {
                if (!in_array($TMP[$i], $lstOption)) {
                    $lstOption[] = $TMP[$i];
                }
            }
        }
        $assign_list['lstOption'] = $lstOption;

        $lstAdultSizeGroup = $clsClassTable->getOneField('adult_group_size', $pvalTable);
        $lstAdultSize = array();
        if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
            $TMP = explode(',', $lstAdultSizeGroup);
            for ($i = 0; $i < count($TMP); $i++) {
                if (!in_array($TMP[$i], $lstAdultSize)) {
                    $lstAdultSize[] = $TMP[$i];
                }
            }
        }
        $assign_list['lstAdultSize'] = $lstAdultSize;

        $lstChildSizeGroup = $clsClassTable->getOneField('child_group_size', $pvalTable);
        $lstChildSize = array();
        if ($lstChildSizeGroup != '' && $lstChildSizeGroup != '0') {
            $TMP = explode(',', $lstChildSizeGroup);
            for ($i = 0; $i < count($TMP); $i++) {
                if (!in_array($TMP[$i], $lstChildSize)) {
                    $lstChildSize[] = $TMP[$i];
                }
            }
        }
        $assign_list['lstChildSize'] = $lstChildSize;

        $lstInfantSizeGroup = $clsClassTable->getOneField('infant_group_size', $pvalTable);
        $lstInfantSize = array();
        if ($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0') {
            $TMP = explode(',', $lstInfantSizeGroup);
            for ($i = 0; $i < count($TMP); $i++) {
                if (!in_array($TMP[$i], $lstInfantSize)) {
                    $lstInfantSize[] = $TMP[$i];
                }
            }
        }
        $assign_list['lstInfantSize'] = $lstInfantSize;
    }

    #- Custom Field
    $clsTourCustomField = new TourCustomField();
    $assign_list["clsTourCustomField"] = $clsTourCustomField;
    $listCustomField = $clsTourCustomField->getAll("fieldtype='CUSTOM' and tour_id='$pvalTable' order by order_no ASC");
    $assign_list["listCustomField"] = $listCustomField;

    unset($listCustomField);

    #-------------Update Config Meta
    $clsMeta = new Meta();
    $assign_list["clsMeta"] = $clsMeta;
    $linkMeta = $clsClassTable->getLink($pvalTable);
    $allMeta = $clsMeta->getAll("config_link='$linkMeta'");
    $meta_id = $allMeta[0]['meta_id'];
    $assign_list["meta_id"] = $meta_id;
    $assign_list["oneMeta"] = $clsMeta->getOne($meta_id);

    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;
    $clsForm->addInputTextArea("full", 'usp_points', "", 'usp_points', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'inclusion', "", 'inclusion', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'key_information', "", 'key_information', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'exclusion', "", 'exclusion', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'information', "", 'information', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'note_price_table', "", 'note_price_table', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'overview', "", 'overview', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'stay', "", 'stay', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'meal', "", 'meal', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'advisory', "", 'advisory', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'activity', "", 'activity', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'what_include', "", 'what_include', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'thing_to_carry', "", 'thing_to_carry', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'cancellation_policy', "", 'cancellation_policy', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'refund_policy', "", 'refund_policy', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'confirmation_policy', "", 'confirmation_policy', 255, 25, 2, 1, "style='width:100%; height:420px'");
    #=========================================#
    if (isset($_POST['UpdateStep1']) && $_POST['UpdateStep1'] == 'UpdateStep1') {
        $value = "";
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . addslashes($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                }
            }
        }
        #- Update Custom field Tour
        if ($SiteHasCustomContentField_Tours) {
            $listCustomField = $clsTourCustomField->getAll("fieldtype='CUSTOM' and tour_id='$pvalTable' order by order_no ASC");
            if (is_array($listCustomField) && count($listCustomField) > 0) {
                for ($i = 0; $i < count($listCustomField); $i++) {
                    $set = "fieldvalue='" . addslashes($_POST['Site_Custom_Field_value_' . $listCustomField[$i][$clsTourCustomField->pkey]]) . "'";

                    $clsTourCustomField->updateOne($listCustomField[$i][$clsTourCustomField->pkey], $set);
                }
            }
            unset($listCustomField);
            unset($set);
        }

        // Fix field type
        $catPost = $_POST['cat_id'];

        if (is_array($catPost) && count($catPost) > 0) {
            $list_cat_id = '|0|';
            foreach ($catPost as $key => $valx) {
                $list_cat_id .= $valx . '|';
            }
            $value .= ",cat_id='" . $catPost[0] . "'";
            $value .= ",list_cat_id='" . addslashes($list_cat_id) . "'";
        }
        // Fix field tag

        $tagPost = $_POST['tag_id'] ? $_POST['tag_id'] : 0;
        if (is_array($tagPost) && count($tagPost) > 0) {
            $list_tag_id = '|0|';
            foreach ($tagPost as $key => $valx) {
                $list_tag_id .= $valx . '|';
            }
            $value .= ",list_tag_id='" . addslashes($list_tag_id) . "'";
        } else {
            $value .= ",list_tag_id=''";
        }

        $departurerPointPost = $_POST['departure_point_id'] ? $_POST['departure_point_id'] : 0;
        if ($departurerPointPost[0] > 0) {
            foreach ($departurerPointPost as $key => $valx) {
                if ($valx > 0) {
                    $list_departure_point_id .= $valx . '|';
                }
            }
            if ($list_departure_point_id != '') {
                $departure_point_id = $departurerPointPost[0] ? $departurerPointPost[0] : $departurerPointPost[1];
                $value .= ",departure_point_id='" . $departure_point_id . "'";
                $value .= ",list_departure_point_id='|" . addslashes($list_departure_point_id) . "'";
            } else {
                $value .= ",departure_point_id='" . $departurerPointPost[0] . "'";
                $value .= ",list_departure_point_id='" . addslashes($list_departure_point_id) . "'";
            }
        } else {
            $value .= ",departure_point_id='0'";
            $value .= ",list_departure_point_id=''";
        }
        $number_day = isset($_POST['number_day']) ? $_POST['number_day'] : 0;
        $number_night = isset($_POST['number_night']) ? $_POST['number_night'] : 0;

        if ($number_day == 0) {
            $number_night = 0;
        }
        if ($number_day > $number_night) {
            $number_night = $number_day - 1;
        } elseif ($number_night > $number_day) {
            $number_night = $number_day + 1;
        } else {
        }
        $title = addslashes($_POST['title']);
        $value .= ",number_day='" . $number_day . "',number_night='" . $number_night . "'";
        $value .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
        $value .= ",upd_date='" . time() . "'";
        $value .= ",title='" . $title . "'";
        $value .= ",slug='" . $clsISO->replaceSpace2($_POST['title']) . "'";
        $value .= ",list_activities_id='" . $clsISO->makeSlashListFromArray($_POST['list_activities_id']) . "'";

        #--Special Field: image
        $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
        if (_isoman_use) {
            $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
        }
        if ($image != '' && $image != '0') {
            $value .= ",image='" . addslashes($image) . "'";
        }
        $imageBig = isset($_POST['imageBig_src']) ? $_POST['imageBig_src'] : '';
        if (_isoman_use) {
            $imageBig = isset($_POST['isoman_url_imageBig']) ? $_POST['isoman_url_imageBig'] : '';
        }
        if ($imageBig != '' && $imageBig != '0') {
            $value .= ",imageBig='" . addslashes($imageBig) . "'";
        }
        $is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
        $value .= ",is_online='" . $is_online . "'";
        //		print_r($_POST);die();
        #- Check Valid TripCode
        if ($clsClassTable->getAll("trip_code='" . $_POST['iso-trip_code'] . "' and $pkeyTable<>'$pvalTable'") != '') {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=DupTripCode');
            die();
        }
        #

        //		print_r($pvalTable.'xxxx'.$value); die();
        if ($clsClassTable->updateOne($pvalTable, $value)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess');
        } else {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateFailed');
        }
    }
    if (isset($_POST['UpdateStep2']) && $_POST['UpdateStep2'] == 'UpdateStep2') {
        $value = "";
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . addslashes($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                }
            }
        }
        #- Update Custom field Tour
        if ($SiteHasCustomContentField_Tours) {
            $listCustomField = $clsTourCustomField->getAll("fieldtype='CUSTOM' and tour_id='$pvalTable' order by order_no ASC");
            if (is_array($listCustomField) && count($listCustomField) > 0) {
                for ($i = 0; $i < count($listCustomField); $i++) {
                    $set = "fieldvalue='" . addslashes($_POST['Site_Custom_Field_value_' . $listCustomField[$i][$clsTourCustomField->pkey]]) . "'";
                    $clsTourCustomField->updateOne($listCustomField[$i][$clsTourCustomField->pkey], $set);
                }
            }
            unset($listCustomField);
            unset($set);
        }
        #
        if ($clsClassTable->updateOne($pvalTable, $value)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess#isotab1');
        } else {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateFailed#isotab1');
        }
    }
    if (isset($_POST['UpdateStep4']) && $_POST['UpdateStep4'] == 'UpdateStep4') {
        $value = "";
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . addslashes($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                }
            }
            if ($tmp[0] == 'date') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . strtotime($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . strtotime($val) . "'";
                }
            }
            if ($tmp[0] == 'price') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . $clsISO->processSmartNumber($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . $clsISO->processSmartNumber($val) . "'";
                }
            }
        }
        $value .= ",trip_old_price='" . $clsISO->processSmartNumber($_POST['trip_old_price']) . "'";
        $value .= ",trip_price='" . $clsISO->processSmartNumber($_POST['trip_price']) . "'";
        $value .= ",intro_trip_price='" . $_POST['intro_trip_price'] . "'";


        $min_price = $oneItem['min_price'];
        if ($_POST['trip_price'] < $min_price) {
            $value .= ",min_price='" . $_POST['trip_price'] . "'";
        }

        if ($clsClassTable->updateOne($pvalTable, $value)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess#isotab3');
        } else {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateFailed#isotab3');
        }
    }
    if (isset($_POST['UpdateStep5']) && $_POST['UpdateStep5'] == 'UpdateStep5') {
        $value = "";
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . addslashes($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                }
            }
            if ($tmp[0] == 'date') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . strtotime($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . strtotime($val) . "'";
                }
            }
            if ($tmp[0] == 'price') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . $clsISO->processSmartNumber($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . $clsISO->processSmartNumber($val) . "'";
                }
            }
        }
        $value .= "list_service_id='" . $clsISO->makeSlashListFromArray($_POST['list_service_id']) . "'";
        //print_r($pvalTable.'xxxx'.$value); die();
        if ($clsClassTable->updateOne($pvalTable, $value)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess#isotab3');
        } else {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateFailed#isotab3');
        }
    }
    if (isset($_POST['UpdateStep6']) && $_POST['UpdateStep6'] == 'UpdateStep6') {
        $titleMeta = $_POST['config_value_title'] ? addslashes($_POST['config_value_title']) : $clsClassTable->getOneField('title', $pvalTable);
        $introMeta = strip_tags(html_entity_decode(addslashes($clsClassTable->getOneField('overview', $pvalTable))));
        $descriptionMeta = $_POST['config_value_intro'] ? addslashes($_POST['config_value_intro']) : substr($introMeta, 0, 160);

        $schema = $clsMeta->getSchemaMarkupFromPost();

        if (!$schema['success']) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateFailed');
            die();
        }

        $update_schema = ",schema_markup='" . addslashes($schema['data']) . "'";

        $image_seo     = isset($_POST['image_seo_src']) ? $_POST['image_seo_src'] : '';
        if (_isoman_use) {
            $image_seo     = $_POST['isoman_url_image_seo'];
        }
        $image_seo = $image_seo ? $image_seo : $clsClassTable->getOneField('image', $pvalTable);
        if ($meta_id == '') {
            $clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,meta_index,meta_follow,schema_markup", "'" . $linkMeta . "','" . $titleMeta . "','" . $descriptionMeta . "','" . $image_seo . "','" . time() . "','" . time() . "','" . $clsMeta->getMaxId() . "','" . $_POST['meta_index'] . "','" . $_POST['meta_follow'] . "'");
            $allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "','" . addslashes($schema['data']) ."'");
        } else {
            $clsMeta->updateOne($meta_id, "config_value_intro='" . $descriptionMeta . "',config_value_title='" . $titleMeta . "',image='" . $image_seo . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'" . $update_schema);
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess');
    }
    if (isset($_POST['UpdateStep7']) && $_POST['UpdateStep7'] == 'UpdateStep7') {
        $value = "upd_date='" . time() . "'";
        $value .= ",hide_flight_info='" . (isset($_POST['iso-hide_flight_info']) ? 1 : 0) . "'";
        $value .= ",hide_hotel_info='" . (isset($_POST['iso-hide_hotel_info']) ? 1 : 0) . "'";
        $value .= ",hide_operator_info='" . (isset($_POST['iso-hide_operator_info']) ? 1 : 0) . "'";
        if ($clsClassTable->updateOne($pvalTable, $value)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $pvalTable . '&message=UpdateSuccess#isotab7');
        } else {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $pvalTable . '&message=updateFailed#isotab7');
        }
    }
    if (isset($_POST['UpdateStep7']) && $_POST['UpdateStep7'] == 'UpdateStep7') {
        $value = "";
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . addslashes($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                }
            }
            if ($tmp[0] == 'date') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . strtotime($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . strtotime($val) . "'";
                }
            }
            if ($tmp[0] == 'price') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . $clsISO->processSmartNumber($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . $clsISO->processSmartNumber($val) . "'";
                }
            }
        }
        $value .= "list_activities_id='" . $clsISO->makeSlashListFromArray($_POST['list_activities_id']) . "'";
        //print_r($pvalTable.'xxxx'.$value); die();
        if ($clsClassTable->updateOne($pvalTable, $value)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess#isotab3');
        } else {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateFailed#isotab3');
        }
    }
    if (isset($_POST['UpdateStep8']) && $_POST['UpdateStep8'] == 'UpdateStep8') {
        $value = "list_transport_id='" . implode(',', $_POST['list_transport_id']) . "'";
        //print_r($value); die();
        if ($clsClassTable->updateOne($pvalTable, $value)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess#isotab4');
        } else {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateFailed#isotab4');
        }
    }
    if (isset($_POST['UpdateStep10']) && $_POST['UpdateStep10'] == 'UpdateStep10') {
        $value = "";
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . addslashes($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                }
            }
        }
        if ($clsClassTable->updateOne($pvalTable, $value)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess#isotab2');
        } else {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateFailed#isotab2');
        }
    }
    if (isset($_POST['UpdateStep11']) && $_POST['UpdateStep11'] == 'UpdateStep11') {
        $value = "";
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . addslashes($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                }
            }
        }
        $tour_optionPost = $clsISO->makeSlashListFromArrayComma($_POST['tour_option']);
        $value .= "tour_option='" . $tour_optionPost . "'";

        $adult_size_groupPost = $clsISO->makeSlashListFromArrayComma($_POST['adult_size_group']);
        $value .= ",adult_group_size='" . $adult_size_groupPost . "'";

        if ($adult_size_groupPost != '') {
            $adult_size_group = explode(',', $adult_size_groupPost);
            for ($i = 0; $i < count($adult_size_group); $i++) {

                if ($clsTourOption->getMin($adult_size_group[$i + 1]) <= $clsTourOption->getMax($adult_size_group[$i]) && $clsTourOption->getMin($adult_size_group[$i + 1]) != '' && $clsTourOption->getMax($adult_size_group[$i]) != '') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateTourOptionFailed#isotab4');
                    return false;
                }
            }
        }

        $child_size_groupPost = $clsISO->makeSlashListFromArrayComma($_POST['child_size_group']);
        $value .= ",child_group_size='" . $child_size_groupPost . "'";

        if ($child_size_groupPost != '') {
            $child_size_group = explode(',', $child_size_groupPost);
            for ($i = 0; $i < count($child_size_group); $i++) {
                if ($clsTourOption->getMin($child_size_group[$i + 1]) <= $clsTourOption->getMax($child_size_group[$i]) && $clsTourOption->getMin($child_size_group[$i + 1]) != '' && $clsTourOption->getMax($child_size_group[$i]) != '') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateTourOptionFailed#isotab4');
                    return false;
                }
            }
        }

        $baby_size_groupPost = $clsISO->makeSlashListFromArrayComma($_POST['infant_size_group']);
        $value .= ",infant_group_size='" . $baby_size_groupPost . "'";
        if ($baby_size_groupPost != '') {
            $baby_size_group = explode(',', $baby_size_groupPost);
            for ($i = 0; $i < count($baby_size_group); $i++) {
                if ($clsTourOption->getMin($baby_size_group[$i + 1]) <= $clsTourOption->getMax($baby_size_group[$i]) && $clsTourOption->getMin($baby_size_group[$i + 1]) != '' && $clsTourOption->getMax($baby_size_group[$i]) != '') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateTourOptionFailed#isotab4');
                    return false;
                }
            }
        }

        $tour_number_group_id = $adult_size_groupPost;
        if ($child_size_groupPost != '') {
            $tour_number_group_id .= ',' . $child_size_groupPost;
        }
        if ($baby_size_groupPost != '') {
            $tour_number_group_id .= ',' . $baby_size_groupPost;
        }
        if ($clsClassTable->updateOne($pvalTable, $value)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess#isotab4');
        } else {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateFailed#isotab4');
        }
    }
    $clsClassTable->updateMinPriceTour($pvalTable);
}

function default_move()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];

    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
    $one = $clsClassTable->getOne($pvalTable);
    $order_no = $one['order_no'];

    $tour_type_id = isset($_GET['tour_type_id']) ? $_GET['tour_type_id'] : 0;
    $depart_point_id = isset($_GET['depart_point_id']) ? $_GET['depart_point_id'] : '';
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;
    $number_day = isset($_GET['number_day']) ? $_GET['number_day'] : '';
    $price_range_id = isset($_GET['price_range_id']) ? $_GET['price_range_id'] : '';

    $where = '1=1 and is_trash=0 ';
    $pUrl = "";
    #--
    if (isset($tour_type_id) && intval($tour_type_id) != 0) {
        $where .= " and tour_type_id=" . $tour_type_id;
        $pUrl .= '&tour_type_id=' . $tour_type_id;
    }
    if (isset($depart_point_id) && intval($depart_point_id) != 0) {
        $where .= " and depart_point_id=" . $depart_point_id;
        $pUrl .= '&depart_point_id=' . $depart_point_id;
    }
    if (isset($cat_id) && intval($cat_id) != 0) {
        $where .= " and (cat_id = '" . $cat_id . "' or list_cat_id like '%|" . $cat_id . "|%')";
        $pUrl .= '&cat_id=' . $cat_id;
    }
    if (intval($number_day) != 0) {
        $where .= " and number_day=" . $number_day;
        $pUrl .= '&number_day=' . $number_day;
    }
    if (intval($price_range_id) != 0) {
        $clsPriceRange = new PriceRange();
        $oneTmp = $clsPriceRange->getOne($price_range_id);
        $min_rate = intval($oneTmp['min_rate']);
        $max_rate = intval($oneTmp['max_rate']);

        if ($min_rate == 0 && $max_rate > 0) {
            $where .= " and trip_price < '$max_rate'";
        } elseif ($min_rate > 0 && $max_rate == 0) {
            $where .= " and trip_price > '$min_rate'";
        } else {
            $where .= " and trip_price > '$min_rate' and trip_price < '$max_rate'";
        }
        $pUrl .= '&price_range_id=' . $price_range_id;
    }

    if ($pvalTable == "" || $direct == '') {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link_back);
    }
    if ($direct == 'moveup') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movedown') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movetop') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
        for ($i = 0; $i < count($lstItem); $i++) {
            $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
        }
    }
    if ($direct == 'movebottom') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no desc");
        for ($i = 0; $i < count($lstItem); $i++) {
            $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
        }
    }
    header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
}

function default_move2()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];

    $classTable = "Category_Country";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
    $type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : 'country';
    $one = $clsClassTable->getOne($pvalTable);
    $order_no = $one['order_no'];

    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : 0;
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : 0;
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;
    #
    $where = "1=1 and is_trash=0";
    $param_url = '&act=category_country';
    if (isset($cat_id) && intval($cat_id) != '') {
        $where .= " and cat_id=" . $cat_id;
        $param_url .= '&cat_id=' . $cat_id;
    }
    /* if(isset($country_id) && intval($country_id) != 0){
      $where.=" and country_id=".$country_id;
      $param_url.='&country_id='.$country_id;
      } */
    if (isset($city_id) && intval($city_id) != 0) {
        $where .= " and (city_id='$city_id' or list_city_id like '%|" . $city_id . "|%')";
        $param_url .= '&city_id=' . $city_id;
    }
    #
    if ($pvalTable == '' && $direct == '') {
        header('location: ' . PCMS_URL . '/?mod=' . $mod);
    }
    #
    if ($direct == 'movedown') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'moveup') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movebottom') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
        for ($i = 0; $i < count($lstItem); $i++) {
            $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
        }
    }
    if ($direct == 'movetop') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
        for ($i = 0; $i < count($lstItem); $i++) {
            $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
        }
    }
    header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=PositionSuccess');
}

function default_trash()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $pvalTable = intval($core->decryptID($string));
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $pUrl = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != $pkeyTable && $tmp[0] != 'act')
            $pUrl .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    #
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=TrashSuccess');
    }
}

function default_trash2()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Category_Country";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $one = $clsClassTable->getOne($pvalTable);
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;

    if ($string = '' && $pvalTable == 0) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&country_id=' . $country_id . '&cat_id=' . $cat_id . '&message=notPermission');
    }
    #
    $param_url = '&act=category_country';
    if (isset($city_id) && intval($city_id) != 0) {
        $param_url .= '&city_id=' . $city_id;
    }
    if (isset($cat_id) && intval($cat_id) != 0) {
        $param_url .= '&cat_id=' . $cat_id;
    }
    #
    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=TrashSuccess');
    }
}

function default_restore()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];

    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $pvalTable = intval($core->decryptID($string));
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $pUrl = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != $pkeyTable && $tmp[0] != 'act')
            $pUrl .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=RestoreSuccess');
    }
}

function default_restore2()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Category_Country";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $one = $clsClassTable->getOne($pvalTable);
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;
    #
    if ($string = '' && $pvalTable == 0) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&country_id=' . $country_id . '&cat_id=' . $cat_id . '&message=notPermission');
    }
    $param_url = '&act=category_country';
    if (isset($city_id) && intval($city_id) != 0) {
        $param_url .= '&city_id=' . $city_id;
    }
    if (isset($cat_id) && intval($cat_id) != 0) {
        $param_url .= '&cat_id=' . $cat_id;
    }
    #
    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=RestoreSuccess');
    }
}

function default_delete()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsTourDestination = new TourDestination();
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $pvalTable = intval($core->decryptID($string));
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $pUrl = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != $pkeyTable && $tmp[0] != 'act')
            $pUrl .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->doDelete($pvalTable)) {
        $clsTourDestination->deleteByCond("tour_id='$pvalTable'");
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=DeleteSuccess');
    }
}

function default_delete2()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Category_Country";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;

    $param_url = '&act=category_country';
    if (isset($city_id) && intval($city_id) != 0) {
        $param_url .= '&city_id=' . $city_id;
    }
    if (isset($cat_id) && intval($cat_id) != 0) {
        $param_url .= '&cat_id=' . $cat_id;
    }
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=notPermission');
    }
    #
    if ($clsClassTable->doDelete($pvalTable)) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=DeleteSuccess');
    }
}

function default_ajSaveStoreForTour()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsTourStore = new TourStore();
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $list_tour_id = isset($_POST['list_tour_id']) ? $_POST['list_tour_id'] : '';
    $list_tour_id = rtrim($list_tour_id, '|');

    if ($list_tour_id != '') {
        $tmp = explode('|', $list_tour_id);
        if (!empty($tmp)) {
            foreach ($tmp as $i) {
                if (!$clsTourStore->checkExist($i, $type)) {
                    #
                    $max_id = $clsTourStore->getMaxID();
                    $max_order = $clsTourStore->getMaxOrder($type);
                    $f = "$clsTourStore->pkey,tour_id,_type,order_no";
                    $v = "'$max_id','$i','$type','$max_order'";
                    $clsTourStore->insertOne($f, $v);
                }
            }
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    } else {
        echo '_ERROR';
        die();
    }
}
function default_ajDeleteTourStore()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsClassTable = new TourStore();
    $pvalTable = isset($_POST['tour_store_id']) ? $_POST['tour_store_id'] : 0;
    $clsClassTable->deleteOne($pvalTable);
    echo (1);
    die();
}
function default_ajUpdPosSortTourStore()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsTourStore = new TourStore();
    $type = $_POST['type'];
    $order = $_POST['order'];
    $currentPage     = $_POST['currentPage'];
    $recordPerPage     = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();

    $list_order = [];
    foreach ($order as $key => $val) {
        $tour = $clsTourStore->getByCond("tour_id='$val' and _type='$type'", 'order_no');
        $list_order[] = $tour['order_no'];
    }

    rsort($list_order);

    foreach ($order as $key => $val) {
        $clsTourStore->updateByCond("tour_id='$val' and _type='$type'", 'order_no=' . $list_order[$key]);
    }
}
function default_liststore()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $clsUser = new User();
    $pUrl = '';
    $user_group_id = $clsUser->getOneField('user_group_id', $user_id);
    #
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsTourCat = new TourCategory();
    $assign_list["clsTourCat"] = $clsTourCat;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsPriceRange = new PriceRange();
    $assign_list["clsPriceRange"] = $clsPriceRange;
    #
    $SiteHasGroup_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default');;
    $tour_group_id = 0;
    if ($SiteHasGroup_Tours) {
        $clsTourGroup = new TourGroup();
        $assign_list["clsTourGroup"] = $clsTourGroup;
        $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
    }
    $assign_list["tour_group_id"] = $tour_group_id;
    #
    $cat_id = 0;
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'category', 'default')) {
        $clsTourCat = new TourCategory();
        $assign_list["clsTourCat"] = $clsTourCat;
        $cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
    }
    $assign_list["cat_id"] = $cat_id;
    #
    $price_range_id = 0;
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'price_range', 'default')) {
        $clsPriceRange = new PriceRange();
        $assign_list["clsPriceRange"] = $clsPriceRange;
        $price_range_id = isset($_GET['price_range_id']) ? intval($_GET['price_range_id']) : 0;
    }
    $assign_list["price_range_id"] = $price_range_id;
    #
    $type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : '';
    $assign_list["type"] = $type;
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : '';
    $assign_list["cat_id"] = $cat_id;
    $depart_point_id = isset($_GET['depart_point_id']) ? $_GET['depart_point_id'] : '';
    $assign_list["depart_point_id"] = $depart_point_id;
    $tour_type_id = isset($_GET['tour_type_id']) ? intval($_GET['tour_type_id']) : 0;
    $assign_list["tour_type_id"] = $tour_type_id;
    $number_day = isset($_GET['number_day']) ? $_GET['number_day'] : '';
    $assign_list["number_day"] = $number_day;
    $price_range_id = isset($_GET['price_range_id']) ? $_GET['price_range_id'] : '';
    $assign_list["price_range_id"] = $price_range_id;

    if ($type == '') {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
    }
    #
    /**/
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($SiteHasGroup_Tours) {
            if (isset($_POST['tour_group_id']) && intval($_POST['tour_group_id']) != 0) {
                $link .= '&tour_group_id=' . intval($_POST['tour_group_id']);
            }
        }
        if (isset($_POST['cat_id']) && intval($_POST['cat_id']) != 0) {
            $link .= '&cat_id=' . $_POST['cat_id'];
        }
        if (isset($_POST['tour_type_id']) && intval($_POST['tour_type_id']) != 0) {
            $link .= '&tour_type_id=' . $_POST['tour_type_id'];
        }
        if (isset($_POST['departure_point_id']) && intval($_POST['departure_point_id']) != 0) {
            $link .= '&departure_point_id=' . $_POST['departure_point_id'];
        }
        if (isset($_POST['number_day']) && intval($_POST['number_day']) != 0) {
            $link .= '&number_day=' . $_POST['number_day'];
        }
        if (isset($_POST['price_range_id']) && intval($_POST['price_range_id']) != 0) {
            $link .= '&price_range_id=' . $_POST['price_range_id'];
        }
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Type trip code or tour name') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&type=' . $core->encryptID($type) . $link);
    }
    #
    $classTable = "TourStore";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $pUrl = '';
    $cond = "1=1 and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE is_trash=0 and is_online=1)";
    if (isset($type) && !empty($type)) {
        $cond .= " and _type = '$type'";
        $pUrl .= '&type=' . $core->encryptID($type);
    }
    if ($tour_group_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE tour_group_id='$tour_group_id')";
        $pUrl .= '&tour_group_id=' . $tour_group_id;
    }
    if (intval($tour_type_id) > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE tour_type_id='$tour_type_id')";
        $pUrl .= '&tour_type_id=' . $tour_type_id;
    }
    if (intval($cat_id) > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE cat_id = '$cat_id' or list_cat_id like '%|$cat_id|%'')";
        $pUrl .= '&cat_id=' . $cat_id;
    }
    if (intval($departure_point_id) > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE departure_point_id='$departure_point_id')";
        $pUrl .= '&departure_point_id=' . $departure_point_id;
    }
    if (isset($number_day) && intval($number_day) != 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE number_day='$number_day')";
        $pUrl .= '&number_day=' . $number_day;
    }
    if ($price_range_id != '' && $price_range_id != '0' && $price_range_id != 'All') {
        $onePriceRange = $clsPriceRange->getOne($price_range_id);
        $min_rate = $onePriceRange['min_rate'];
        $max_rate = $onePriceRange['max_rate'];
        #
        if ($min_rate == 0 && $max_rate > 0) {
            $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE trip_price < '$max_rate')";
        } elseif ($min_rate > 0 && $max_rate > 0) {
            $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE trip_price > '$min_rate' and trip_price < '$max_rate')";
        } else {
            $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE trip_price > '$min_rate')";
        }
        $pUrl .= '&price_range_id=' . $price_range_id;
    }
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE trip_code like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%' or title like '%" . $slug . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }

    $orderBy = " order by order_no asc";
    $allItem = $clsClassTable->getAll($cond . $orderBy);
    $assign_list["allItem"] = $allItem;
    $assign_list["pUrl"] = $pUrl;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Delete') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($pvalTable)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        #
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no desc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no asc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=PositionSuccess');
    }
    #----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateTourTypeIntro') {
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    $clsConfiguration->updateValue($tmp[1], $val);
                }
            }
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=UpdateSuccess');
        }
    }
}

function default_ajUpdPosSortHotTour()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsTourStore = new TourStore();
    $order = $_POST['order'];
    $type = $_POST['type'];
    $currentPage     = $_POST['currentPage'];
    $recordPerPage     = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();

    $list_order = [];
    foreach ($order as $key => $val) {
        $tour = $clsTourStore->getByCond("tour_id='$val' and _type='$type'", 'order_no');
        $list_order[] = $tour['order_no'];
    }

    rsort($list_order);

    foreach ($order as $key => $val) {
        $clsTourStore->updateByCond("tour_id='$val' and _type='$type'", 'order_no=' . $list_order[$key]);
    }
}

/* ========= TOUR CATEGORY MOD MANAGE ============= */

function default_category()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }
    #
    $type_list = Input::get('type_list', '');
    $assign_list["type_list"] = $type_list;
    #
    $classTable = "TourCategory";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    $assign_list["clsTour"] = new Tour();
    #

    $SiteHasGroup_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default');
    $SiteHasSubCat_Tours = $clsConfiguration->getValue("SiteHasSubCat_Tours");
    #
    if ($SiteHasGroup_Tours) {
        $clsTourGroup = new TourGroup();
        $assign_list["clsTourGroup"] = $clsTourGroup;
        $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
        $assign_list["tour_group_id"] = $tour_group_id;
    }
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($SiteHasGroup_Tours && $_POST['tour_group_id'] != '') {
            $link .= '&tour_group_id=' . $_POST['tour_group_id'];
        }
        if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $link);
    }
    #
    $cond = "1=1 and parent_id=0";
    $pUrl = '';
    if ($SiteHasGroup_Tours) {
        if ($tour_group_id > 0) {
            $cond .= " and tour_group_id='$tour_group_id'";
        }
        $pUrl .= '&tour_group_id=' . $tour_group_id;
    }
    #Filter By Keyword
    $keyword = Input::get('keyword', '');
    if (!empty($keyword)) {
        $cond .= " and slug like '%" . $core->replaceSpace($_GET['keyword']) . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;
    $orderBy = " order by order_no asc";

    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = Input::get('recordperpage', 20);
    $currentPage = Input::get('page', 1);
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $totalRecord = $clsClassTable->getAll($cond, $clsClassTable->pkey);
    $totalRecord = $totalRecord ? count($totalRecord) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #
    $LISTALL = $clsClassTable->getAll($cond . $orderBy . $limit);
    if (is_array($LISTALL) && count($LISTALL) > 0) {
        for ($i = 0; $i < count($LISTALL); $i++) {
            $allItem[] = array(
                'idx' => ($i + 1),
                'parent_id' => $LISTALL[$i]['parent_id'],
                'tour_group_id' => $LISTALL[$i][$clsTourGroup->pkey],
                'tourcat_id' => $LISTALL[$i][$clsClassTable->pkey],
                'title' => $clsClassTable->getTitle($LISTALL[$i][$clsClassTable->pkey]),
                'is_trash' => $LISTALL[$i]['is_trash'],
                'is_online' => $LISTALL[$k]['is_online']
            );
            if ($SiteHasSubCat_Tours) {
                $LISTCHILD = $clsClassTable->getChild($LISTALL[$i][$clsClassTable->pkey], 0, false);
                if (is_array($LISTCHILD) && count($LISTCHILD) > 0) {
                    for ($k = 0; $k < count($LISTCHILD); $k++) {
                        $allItem[] = array(
                            'idx' => ($i + 1) . '.' . ($k + 1),
                            'parent_id' => $LISTCHILD[$k]['parent_id'],
                            'tour_group_id' => $LISTCHILD[$k][$clsTourGroup->pkey],
                            'tourcat_id' => $LISTCHILD[$k][$clsClassTable->pkey],
                            'title' => '__' . $clsClassTable->getTitle($LISTCHILD[$k][$clsClassTable->pkey]),
                            'is_trash' => $LISTCHILD[$k]['is_trash'],
                            'is_online' => $LISTCHILD[$k]['is_online']
                        );
                    }
                    unset($LISTCHILD);
                }
            }
        }
        unset($LISTALL);
    }
    $assign_list["allItem"] = $allItem;
    unset($allItem);
    $assign_list["pUrl"] = $pUrl;
    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['tourcat_id']) ? ($_GET['tourcat_id']) : '';
        $tourcat_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($SiteHasGroup_Tours) {
            $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
            $pUrl .= '&tour_group_id=' . $tour_group_id;
        }
        if ($string == '' && $tourcat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tourcat_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['tourcat_id']) ? ($_GET['tourcat_id']) : '';
        $tourcat_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($SiteHasGroup_Tours) {
            $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
            $pUrl .= '&tour_group_id=' . $tour_group_id;
        }
        if ($string == '' && $tourcat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tourcat_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['tourcat_id']) ? ($_GET['tourcat_id']) : '';
        $tourcat_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($SiteHasGroup_Tours) {
            $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
            $pUrl .= '&tour_group_id=' . $tour_group_id;
        }
        if ($string == '' && $tourcat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($tourcat_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if (isset($_POST['submit'])) {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
            if ($tmp[0] == 'date') {
                $clsConfiguration->updateValue($tmp[1], strtotime($val));
            }
        }
        $extUrl = '';
        header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=updateSuccess' . $extUrl);
    }
}
function default_SiteTourCategory()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default')) {
        $clsTourGroup = new TourGroup();
        $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
    }
    $clsTourCategory = new TourCategory();
    $tourcat_id = isset($_POST['tourcat_id']) ? intval($_POST['tourcat_id']) : 0;
    if ($tourcat_id > 0) {
        $tour_group_id = $clsTourCategory->getOneField('tour_group_id', $tourcat_id);
    }
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    #
    if ($tp == 'F') {
        $html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . ($tourcat_id == 0 ? $core->get_Lang('add') : $core->get_Lang('edit')) . ' ' . $core->get_Lang('tourcategory') . '</h3>
		</div>';
        $html .= '
		<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="fl" style="width:100%">
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('title') . '</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<input style="border:2px solid #ccc; padding:6px 10px;" autocomplete="off" class="text_32 full-width border_aaa bold required fontLarge title_capitalize" name="title" value="' . $clsTourCategory->getTitle($tourcat_id) . '" type="text" />
						</div>
					</div>
					' . ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'sub_cat', 'customize') ? '
					<div class="row-span hidden">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('selectcategory') . '</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<select class="slb" name="parent_id" id="slb_TourCategory">
								' . $clsTourCategory->makeSelectboxOption0($tourcat_id, $clsTourCategory->getOneField('parent_id', $tourcat_id)) . '
							</select>
						</div>
					</div>
					' : '') . '
					' . (($clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default') && $_LANG_ID == 'vn') ? '
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong> ' . $core->get_Lang('selectgroup') . '</strong><span class="color_r">*</span></div>
						<div class="fieldarea">
							<select class="slb" name="tour_group_id" id="slb_TourGroup">
								' . $clsTourGroup->makeSelectboxOption($tour_group_id) . '
							</select>
						</div>
					</div>
					' : '') . '
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Short text') . '</strong></div>
						<div class="fieldarea">
							<textarea  id="textarea_tour_intro_editor_' . time() . '" class="textarea_tour_intro_editor" name="intro" style="width:100%">' . $clsTourCategory->getIntro($tourcat_id) . '</textarea>
						</div>
					</div>';
        if ($_LANG_ID != 'vn') {
            $html .= '<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Image') . '</strong></div>
						<div class="fieldarea">
							<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsTourCategory->getOneField('image', $tourcat_id) . '" />
							<input type="hidden" id="isoman_hidden_image" value="' . $clsTourCategory->getOneField('image', $tourcat_id) . '">
							<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsTourCategory->getOneField('image', $tourcat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsTourCategory->getOneField('image', $tourcat_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
						</div>
					</div>';
        }
        if ($clsConfiguration->getValue('Video_Teaser_TourCategory')) {
            $html .= '<div class="row-span">
							<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Video Teaser') . '</strong></div>
							<div class="fieldarea">
								<img class="isoman_img_pop" id="isoman_show_video_teaser" src="' . $clsTourCategory->getOneField('video_teaser', $tourcat_id) . '" />
								<input type="hidden" id="isoman_hidden_video_teaser" value="' . $clsTourCategory->getOneField('video_teaser', $tourcat_id) . '">
								<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_video_teaser" name="video_teaser" value="' . $clsTourCategory->getOneField('video_teaser', $tourcat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="video_teaser" isoman_val="' . $clsTourCategory->getOneField('video_teaser', $tourcat_id) . '" isoman_name="video_teaser"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
							</div>
						</div>';
        }
        if ($clsConfiguration->getValue('Banner_TourCategory')) {
            $html .= '<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Banner') . ' <span class="small">(WxH=1600x460)</span></strong></div>
						<div class="fieldarea">
							<img class="isoman_img_pop" id="isoman_show_image_banner" src="' . $clsTourCategory->getOneField('image_banner', $tourcat_id) . '" />
							<input type="hidden" id="isoman_hidden_image_banner" value="' . $clsTourCategory->getOneField('image_banner', $tourcat_id) . '">
							<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image_banner" name="image_banner" value="' . $clsTourCategory->getOneField('image_banner', $tourcat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_banner" isoman_val="' . $clsTourCategory->getOneField('image_banner', $tourcat_id) . '" isoman_name="image_banner"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
						</div>
					</div>';

            $html .= '<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Banner Link') . '</strong></div>
						<div class="fieldarea">
							<input class="text_32 full-width border_aaa fontLarge" name="iso-link_banner" value="' . $clsTourCategory->getLinkBanner($tourcat_id) . '" type="text" />
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Banner Content') . '<strong></div>
						<div class="fieldarea">
							<textarea  id="textarea_tour_intro_banner_editor_' . time() . '" class="textarea_tour_intro_banner_editor" name="intro_banner" style="width:100%">' . $clsTourCategory->getIntroBanner($tourcat_id) . '</textarea>
						</div>
					</div>';
        }
        $html .= '</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="button" tourcat_id="' . $tourcat_id . '" class="btn btn-primary btnClickToSubmitCategory">
				<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span> 
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
			</button>		
		</div>';
        echo ($html);
        die();
    } else if ($tp == 'S') {
        #
        $titlePost = trim(strip_tags($_POST['title']));
        $slugPost = $core->replaceSpace($titlePost);
        $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0;
        $introPost = trim($_POST['intro']);
        $imagePost = isset($_POST['image']) ? $_POST['image'] : '';
        $introBannerPost = trim($_POST['intro_banner']);
        $linkBannerPost = $_POST['link_banner'];
        $imageBannerPost = isset($_POST['image_banner']) ? $_POST['image_banner'] : '';
        $videoTeaserPost = isset($_POST['video_teaser']) ? $_POST['video_teaser'] : '';
        #
        if ($tourcat_id == 0) {
            $all = $clsTourCategory->getAll("is_trash=0 and tour_group_id='$tour_group_id' and slug like '%" . $slugPost . "' limit 0,1");
            if (!empty($all)) {
                echo '_EXIST';
                die();
            } else {
                $listTable = $clsTourCategory->getAll("1=1", $clsTourCategory->pkey . ",order_no");
                for ($i = 0; $i <= count($listTable); $i++) {
                    $order_no = $listTable[$i]['order_no'] + 1;
                    $clsTourCategory->updateOne($listTable[$i][$clsTourCategory->pkey], "order_no='" . $order_no . "'");
                }
                $max_id = $clsTourCategory->getMaxId();
                $fx = $clsTourCategory->pkey . ",user_id,user_id_update,parent_id,title,slug,intro,intro_banner,order_no,reg_date,upd_date,image,image_banner,link_banner,video_teaser";
                $vx = "'$max_id','$user_id','$user_id','$parent_id','$titlePost','$slugPost','" . addslashes($introPost) . "','" . addslashes($introBannerPost) . "'";
                $vx .= ",'1','" . time() . "','" . time() . "','" . addslashes($imagePost) . "','" . addslashes($imageBannerPost) . "','" . addslashes($linkBannerPost) . "','" . addslashes($videoTeaserPost) . "'";
                if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default')) {
                    $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
                    $fx .= ",tour_group_id";
                    $vx .= ",'$tour_group_id'";
                }
                #
                if ($clsTourCategory->insertOne($fx, $vx)) {
                    echo '_SUCCESS';
                    die();
                } else {
                    echo '_ERROR';
                    die();
                }
            }
        } else {
            $v = "title='$titlePost',slug='$slugPost',intro='" . $introPost . "',intro_banner='" . $introBannerPost . "',parent_id='$parent_id'";
            $v .= ",upd_date='" . time() . "',user_id_update='$user_id'";
            if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default')) {
                $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
                $v .= ",tour_group_id='$tour_group_id'";
            }
            $v .= ",image = '" . addslashes($imagePost) . "'";
            $v .= ",image_banner = '" . addslashes($imageBannerPost) . "'";
            $v .= ",link_banner = '" . addslashes($linkBannerPost) . "'";
            $v .= ",video_teaser = '" . addslashes($videoTeaserPost) . "'";
            if ($clsTourCategory->updateOne($tourcat_id, $v)) {
                echo '_SUCCESS';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        }
    }
}

function default_ajaxSiteTourCategory()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration, $clsISO, $package_id;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, 'category', 'default')) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    $clsTourCategory = new TourCategory();
    $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
    $cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : 0;
    $chosen = isset($_POST['chosen']) ? intval($_POST['chosen']) : 0;
    if (!$chosen) {
        echo $clsTourCategory->makeSelectboxOption($tour_group_id, $cat_id);
        die();
    } else {
        echo '<select name="cat_id[]" id="cat_id" class="slb required chosen-select" multiple style="width:250px">' . $clsTourCategory->makeSelectboxOption($tour_group_id, $cat_id, true) . '</select>';
        die();
    }
}
function default_ajUpdPosSortTourCategory()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO, $package_id;
    global $clsConfiguration;
    #
    $clsTourCategory = new TourCategory();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsTourCategory->updateOne($val, "order_no='" . $key . "'");
    }
}
function default_category_country()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];

    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }

    $pUrl = '';
    #-- Get Type List
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;

    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;


    $country_id = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;
    $assign_list["country_id"] = $country_id;
    $city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : 0;
    $assign_list["city_id"] = $city_id;
    $cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
    $assign_list["cat_id"] = $cat_id;

    #
    $classTable = "Category_Country";
    $clsClassTable = new $classTable;

    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $assign_list["pkeyTable"] = $pkeyTable;
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link .= '&act=category_country';
        if (isset($_POST['country_id']) && intval($_POST['country_id']) > 0) {
            $link .= '&country_id=' . $_POST['country_id'];
        }
        if (isset($_POST['city_id']) && intval($_POST['city_id']) > 0) {
            $link .= '&city_id=' . $_POST['city_id'];
        }
        if (isset($_POST['cat_id']) && intval($_POST['cat_id']) > 0) {
            $link .= '&cat_id=' . $_POST['cat_id'];
        }

        if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }

    /* List all item */
    $cond = "1=1";
    if (intval($country_id) > 0) {
        $cond .= " and country_id='$country_id'";
        $pUrl .= '&country_id=' . $country_id;
    }

    if (intval($cat_id) > 0) {
        $cond .= " and (cat_id='$cat_id' or list_cat_id like '%" . $cat_id . "%')";
        $pUrl .= '&cat_id=' . $cat_id;
    }

    if (intval($city_id) > 0) {
        $cond .= " and (city_id='$city_id')";
        $pUrl .= '&city_id=' . $city_id;
    }

    #Filter By Keyword
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $keyword = $core->replaceSpace($_GET['keyword']);
        $cond .= " and slug like '%" . $keyword . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $assign_list["pUrl"] = $pUrl;
    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no asc";





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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
    $assign_list["allItem"] = $allItem;

    $lstCityGuide = $clsCity->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by title asc", $clsCity->pkey);
    $tmp = array();
    if (!empty($lstCityGuide)) {
        foreach ($lstCityGuide as $item) {
            if ($clsClassTable->countGuideGlobal(0, $item[$clsCity->pkey], $country_id) > 0) {
                $tmp[] = $item[$clsCity->pkey];
            }
        }
    }
    $assign_list["lstCityGuide"] = $tmp;
}

function default_edit_categorycountry()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Category_Country";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    #

    $clsRegion = new Region();
    $assign_list['clsRegion'] = $clsRegion;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;

    $oneTable = $clsClassTable->getOne($pvalTable);
    $assign_list["oneTable"] = $oneTable;

    $country_id = $oneTable['county_id'];

    $cat_id = $oneTable['cat_id'];
    /*
      if($clsConfiguration->getValue('SiteModActive_country')) {
      if(isset($country_id) && intval($country_id)==0){
      header('location: '.PCMS_URL.'/?mod=country&message=notPermission');
      exit();
      }
      } */

    if ($clsConfiguration->getValue('SiteActive_city')) {
        $lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by order_no desc");
        $assign_list["lstCity"] = $lstCity;
        unset($lstCity);
    }
    #
    if (isset($pvalTable) && $pvalTable > 0) {
        $country_id = $oneTable['country_id'];
        $city_id = $oneTable['city_id'];
        $cat_id = $oneTable['cat_id'];
    }
    $assign_list["country_id"] = $country_id;
    $assign_list["cat_id"] = $cat_id;
    $assign_list["city_id"] = $city_id;
    #-------------Update Config Meta
    $clsMeta = new Meta();
    $assign_list["clsMeta"] = $clsMeta;
    $linkMeta = $clsClassTable->getLink($pvalTable);
    $allMeta = $clsMeta->getAll("config_link='$linkMeta'");
    $meta_id = $allMeta[0]['meta_id'];
    $assign_list["meta_id"] = $meta_id;
    $assign_list["oneMeta"] = $clsMeta->getOne($meta_id);

    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;
    $clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 20, 1, "style='width:100%'");
    $clsForm->addInputTextArea("simple150", 'intro_banner', "", 'intro_banner', 255, 25, 20, 1, "style='width:100%'");

    if ($string != '' && $pvalTable == 0) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
    }
    #=========================================#
    if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
        if ($pvalTable > 0) {
            $set = "";
            $firstAdd = 0;
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    if ($firstAdd == 0) {
                        $set .= $tmp[1] . "='" . addslashes($val) . "'";
                        $firstAdd = 1;
                    } else {
                        $set .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                    }
                }
            }
            #
            $set .= ",slug='" . $core->replaceSpace($_POST["iso-title"]) . "'";
            $set .= ",upd_date='" . time() . "',user_id_update='" . addslashes($core->_SESS->user_id) . "'";

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
            }
            if ($image != '' && $image != '0') {
                $set .= ",image='" . addslashes($image) . "'";
            }
            $image_banner = isset($_POST['image_banner_src']) ? $_POST['image_banner_src'] : '';
            if (_isoman_use) {
                $image_banner = isset($_POST['isoman_url_image_banner']) ? $_POST['isoman_url_image_banner'] : '';
            }
            if ($image_banner != '' && $image_banner != '0') {
                $set .= ",image_banner='" . addslashes($image_banner) . "'";
            }

            #
            $pUrl .= '&act=category_country';
            if (isset($_POST['cat_id']) && intval($_POST['cat_id']) > 0) {
                $set .= ",cat_id = '" . $_POST['cat_id'] . "'";
                $pUrl .= "&cat_id=" . $cat_id;
            }
            //print_r($pvalTable.'<br/>'.$set); die();
            if ($clsClassTable->updateOne($pvalTable, $set)) {
                if ($_POST['config_value_title'] != '') {
                    if ($meta_id == '') {
                        $clsMeta->insertOne("config_link,reg_date,meta_id", "'" . $linkMeta . "','" . time() . "','" . $clsMeta->getMaxId() . "'");
                        $allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
                        $meta_id = $allMeta[0]['meta_id'];
                    }
                    $clsMeta->updateOne($meta_id, "config_value_intro='" . addslashes($_POST['config_value_intro']) . "',config_value_keyword='" . addslashes($_POST['config_value_keyword']) . "',config_value_title='" . addslashes($_POST['config_value_title']) . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
                }
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_categorycountry&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=UpdateSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=category_country' . '&message=UpdateSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=updateFailed');
            }
        } else {
            $value = "";
            $firstAdd = 0;
            $field = "";
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    if ($firstAdd == 0) {
                        $field .= $tmp[1];
                        $value .= "'" . addslashes($val) . "'";
                        $firstAdd = 1;
                    } else {
                        $field .= ',' . $tmp[1];
                        $value .= ",'" . addslashes($val) . "'";
                    }
                }
            }
            #
            $listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
            }
            $max_id = $clsClassTable->getMaxID();
            $field .= ",user_id,user_id_update,reg_date,upd_date,slug,$clsClassTable->pkey,order_no";
            $value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
            $value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "','" . $max_id . "','1'";

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
            }
            if ($image != '' && $image != '0') {
                $field .= ',image';
                $value .= ",'" . addslashes($image) . "'";
            }

            $image_banner = isset($_POST['image_banner_src']) ? $_POST['image_banner_src'] : '';
            if (_isoman_use) {
                $image_banner = isset($_POST['isoman_url_image_banner']) ? $_POST['isoman_url_image_banner'] : '';
            }
            if ($image_banner != '' && $image_banner != '0') {
                $field .= ',image_banner';
                $value .= ",'" . addslashes($image_banner) . "'";
            }

            #
            $pUrl .= '&act=category_country';
            if (isset($_POST['cat_id']) && intval($_POST['cat_id']) > 0) {
                $field .= ",cat_id";
                $value .= ",'" . $_POST['cat_id'] . "'";
                $pUrl .= "&cat_id=" . $_POST['cat_id'];
            }
            //print_r($field.'<br />'.$value); die();
            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_categorycountry&' . $clsClassTable->pkey . '=' . $core->encryptID($max_id) . '&message=insertSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=category_country' . '&message=insertSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
            }
        }
    }
}
function default_ajUpdPosSortTravelStylebyCountry()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod,
           $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;

    global $clsConfiguration;

    $clsCategoryCountry = new Category_Country();

    $order = isset($_POST['order']) && is_array($_POST['order'])
        ? array_values($_POST['order'])
        : array();

    if (empty($order)) {
        return;
    }

    /*
     * Lấy order_no hiện tại của các item
     */
    $list_order = array();

    foreach ($order as $val) {

        $val = (int)$val;

        if ($val <= 0) {
            continue;
        }

        $item = $clsCategoryCountry->getOne($val, 'order_no');

        if ($item && isset($item['order_no'])) {
            $list_order[] = (int)$item['order_no'];
        }
    }

    if (empty($list_order)) {
        return;
    }

    /*
     * QUAN TRỌNG:
     * Danh sách đang hiển thị theo order_no DESC
     * nên phải giữ thứ tự:
     *
     * 8, 7, 6, 5, 4, 3, 2, 1
     */
    rsort($list_order, SORT_NUMERIC);

    /*
     * Gán lại order_no theo đúng thứ tự
     * mà sortable gửi lên
     */
    foreach ($order as $key => $val) {

        $val = (int)$val;

        if ($val <= 0) {
            continue;
        }

        if (!isset($list_order[$key])) {
            continue;
        }

        $newOrder = (int)$list_order[$key];

        $clsCategoryCountry->updateOne(
            $val,
            "order_no='" . $newOrder . "'"
        );
    }
}

/* ========= SITE DEPARTURE POINT TOUR ============= */

function default_ajaxSiteDeparturePoint()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();
    $clsCity = new City();
    #
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
    //var_dump($country_id);die();
    $cat_id = isset($_POST['cat_id']) ? intval($_POST['cat_id']) : 0;
    $tour_type_id = isset($_POST['tour_type_id']) ? intval($_POST['tour_type_id']) : 0;
    $departure_point_id = isset($_POST['departure_point_id']) ? intval($_POST['departure_point_id']) : 0;
    #
    $html = '<option value="0">-- ' . $core->get_Lang('selectdeparturepoint') . ' --</option>';
    $sql = "SELECT t1.city_id FROM " . DB_PREFIX . "city t1 INNER JOIN " . DB_PREFIX . "citystore t2 WHERE t1.city_id = t2.city_id and t2.type='DEPARTUREPOINT' and t2.country_id='$country_id' order by t2.order_no DESC";

    $lstItem = $dbconn->GetAll($sql);
    if (is_array($lstItem) && count($lstItem) > 0) {
        foreach ($lstItem as $k => $v) {
            $Query = "1=1 and departure_point_id='" . $v[$clsCity->pkey] . "'";
            if ($cat_id > 0) {
                $Query .= " and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')";
            }
            $html .= '<option value="' . $v[$clsCity->pkey] . '" ' . ($v[$clsCity->pkey] == $departure_point_id ? 'selected="selected"' : '') . '>-- ' . $clsCity->getTitle($v[$clsCity->pkey]) . ' (' . $clsTour->countItem($Query) . ') --</option>';
            unset($Query);
        }
        unset($lstItem);
    }
    echo $html;
    die();
}

/* END SELECT_DIEM_KHOI_HANH */

/* ========= TOUR GROUP MOD MANAGE ============ */

function default_group()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO, $clsConfiguration, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }
    #
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    $classTable = "TourGroup";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    $assign_list["clsTour"] = new Tour();
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        if ($_POST['keyword'] != '' && $_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $link);
    }
    #
    $cond = "1=1";
    #Filter By Keyword
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $cond .= " and slug like '%" . $core->replaceSpace($_GET['keyword']) . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order by order_no desc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $totalRecord = $clsClassTable->getAll($cond) ? count($clsClassTable->getAll($cond)) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #
    $allItem = $clsClassTable->getAll($cond . $orderBy . $limit);
    $assign_list["allItem"] = $allItem;
    unset($allItem);
    $assign_list["number_all"] = $clsClassTable->getAll($cond2) ? count($clsClassTable->getAll($cond2)) : 0;
    $assign_list["number_trash"] = $clsClassTable->getAll($cond2 . " and is_trash=1") ? count($clsClassTable->getAll($cond2 . " and is_trash=1")) : 0;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['tour_group_id']) ? ($_GET['tour_group_id']) : '';
        $tour_group_id = intval($core->decryptID($string));
        if ($string == '' && $tour_group_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tour_group_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['tour_group_id']) ? ($_GET['tour_group_id']) : '';
        $tour_group_id = intval($core->decryptID($string));
        if ($string == '' && $tour_group_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tour_group_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['tour_group_id']) ? ($_GET['tour_group_id']) : '';
        $tour_group_id = intval($core->decryptID($string));
        if ($string == '' && $tour_group_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($tour_group_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $string = isset($_GET['tour_group_id']) ? ($_GET['tour_group_id']) : '';
        $pvalTable = intval($core->decryptID($string));
        if ($string == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        #
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        $where = "is_trash=0";
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no ASC limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no DESC limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no desc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no asc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=PositionSuccess');
    }
}

function default_ajaxFrmTourGroup()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsTourGroup = new TourGroup();
    $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;

    $html = '
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
		<h3>' . ($tour_group_id == 0 ? $core->get_Lang('add') : $core->get_Lang('edit')) . ' ' . $core->get_Lang('tourgroup') . '</h3>
	</div>';
    $html .= '
	<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
		<div class="wrap">
			<div class="fl" style="width:100%">
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('title') . ' <font color="red">*</font></div>
					<div class="fieldarea">
						<input class="text full required" name="title" value="' . $clsTourGroup->getTitle($tour_group_id) . '" type="text" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('intro') . '</div>
					<div class="fieldarea">
						<textarea  id="textarea_tour_intro_editor_' . time() . '" class="textarea_tour_intro_editor" name="intro" style="width:100%">' . $clsTourGroup->getIntro($tour_group_id) . '</textarea>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('Image') . '</div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsTourGroup->getOneField('image', $tour_group_id) . '" />
						<input type="hidden" id="isoman_hidden_image" value="' . $clsTourGroup->getOneField('image', $tour_group_id) . '">
						<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsTourGroup->getOneField('image', $tour_group_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsTourGroup->getOneField('image', $tour_group_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>
				<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Banner') . ' <span class="small">(WxH=1600x460)</span></strong></div>
						<div class="fieldarea">
							<img class="isoman_img_pop" id="isoman_show_image_banner" src="' . $clsTourGroup->getOneField('image_banner', $tour_group_id) . '" />
							<input type="hidden" id="isoman_hidden_image_banner" value="' . $clsTourGroup->getOneField('image_banner', $tour_group_id) . '">
							<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image_banner" name="image_banner" value="' . $clsTourGroup->getOneField('image_banner', $tour_group_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_banner" isoman_val="' . $clsTourGroup->getOneField('image_banner', $tour_group_id) . '" isoman_name="image_banner"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
						</div>
					</div>
			</div>
		</div>
	</form>
	<div class="clearfix"></div>
	<div class="modal-footer">
		<button type="button" tour_group_id="' . $tour_group_id . '" class="btn btn-primary ClickSubmitGroup">
			<i class="icon-ok icon-white"></i> <span>Cập nhật</span> 
		</button>
		<button type="reset" class="btn btn-warning close_pop">
			<i class="icon-retweet icon-white"></i> <span>Đóng lại</span>
		</button>		
	</div>
	';
    echo ($html);
    die();
}

function default_ajSubmitTourGroup()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "TourGroup";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    #
    $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
    $titlePost = trim(strip_tags($_POST['title']));
    $slugPost = $core->replaceSpace($titlePost);
    $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0;
    $introPost = trim($_POST['intro']);
    $imagePost = isset($_POST['image']) ? $_POST['image'] : '';
    $bannerPost = isset($_POST['banner']) ? $_POST['banner'] : '';
    #
    if ($tour_group_id == 0) {
        $all = $clsClassTable->getAll("is_trash=0 and slug='$slugPost' limit 0,1");
        if (!empty($all)) {
            echo '_EXIST';
            die();
        } else {
            $fx = "user_id,user_id_update,parent_id,title,slug,intro,order_no,reg_date,upd_date,image,image_banner";
            $vx = "'$user_id','$user_id','$parent_id','$titlePost','$slugPost','" . addslashes($introPost) . "'";
            $vx .= ",'" . $clsClassTable->getMaxOrderNo() . "','" . time() . "','" . time() . "','" . addslashes($imagePost) . "','" . addslashes($bannerPost) . "'";
            #
            if ($clsClassTable->insertOne($fx, $vx)) {
                echo '_SUCCESS';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        }
    } else {
        $vx = "title='$titlePost',slug='$slugPost',intro='" . addslashes($introPost) . "',parent_id='$parent_id'";
        $vx .= ",upd_date='" . time() . "',user_id_update='$user_id',image='" . addslashes($imagePost) . "',image_banner='" . addslashes($bannerPost) . "'";
        if ($clsClassTable->updateOne($tour_group_id, $vx)) {
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}

function default_setting()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;


    $lstTourType = $clsTourStore->getListType();
    $array_key_first = array_key_first($lstTourType);


    if (!empty($lstTourType)) {
        header('location:' . PCMS_URL . '?mod=tour&act=store&type=' . $core->encryptID($array_key_first));
        exit();
    }

    #
    if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        $site_tour_banner = $_POST['isoman_url_site_tour_banner'];
        if ($site_tour_banner != '' && $site_tour_banner != '0') {
            $clsConfiguration->updateValue('site_tour_banner', $site_tour_banner);
        }
        header('location:' . PCMS_URL . '?mod=' . $mod . '&act=setting&message=updateSuccess');
    }
}
function default_store()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    $pUrl = '';
    #
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    #
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;



    //$abc=$core->encryptID('DEPARTURE');
    //die($abc);
    #
    $type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : '';
    $assign_list["type"] = $type;

    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $assign_list["keyword"] = $keyword;

    if (empty($type)) {
        header('location: ' . PCMS_URL . '/?mod=tour&message=notPermission');
    }

    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default', $_GET['type'])) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }

    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=' . $act;
        $link .= '&type=' . $core->encryptID($type);

        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Tìm kiếm...') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    #
    $cond = "is_trash=0 and is_online=1";

    if (!empty($type)) {
        $cond .= " and tour_id NOT IN (SELECT tour_id FROM " . DB_PREFIX . "tour_store WHERE is_trash=0 and _type='$type')";
        $pUrl .= '&type=' . $core->encryptID($type);
    }
    if (!empty($keyword)) {
        $slug = $core->replaceSpace($keyword);
        $cond .= " and slug like '%" . $slug . "%'";
    }
    $orderBy = " order_no asc";


    #-------Page Divide---------------------------------------------------------------
    $recordPerPage     = 20;
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
    $listPageNumber =  array();
    for ($i = 1; $i <= $totalPage; $i++) {
        $listPageNumber[] = $i;
    }
    $stt = ($currentPage - 1) * $recordPerPage;
    $assign_list['stt'] = $stt;

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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
    //	print_r($cond." order by ".$orderBy.$limit);die();
    $listItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit, $clsClassTable->pkey);
    $assign_list["listItem"] = $listItem;


    #
    $listSelected =  $clsTourStore->getAll("is_trash=0 and _type = '$type' order by order_no asc");
    $assign_list["listSelected"] = $listSelected;

    //Action
    $action = Input::get('action', '');
    if ($action == 'Add') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : 0;


        if (empty($pvalTable)) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if (!$clsTourStore->checkExist($pvalTable, $type)) {
            $listTable = $clsTourStore->getAll("1=1 and _type='$type'", $clsTourStore->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsTourStore->updateOne($listTable[$i][$clsTourStore->pkey], "order_no='" . $order_no . "'");
            }
            $max_order_no = $clsTourStore->getMaxOrder($type);
            $tour_store_id = $clsTourStore->getMaxId();
            $f = "tour_store_id,tour_id,_type,order_no";
            $v = "'$tour_store_id','$pvalTable','$type','1'";
            //print_r($f.'</br>'.$v);die();
            if ($clsTourStore->insertOne($f, $v)) {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=insertSuccess');
            }
        }
    }
    //print_r(xxxx); die();
}
function default_property()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $type = isset($_GET['type']) ? $_GET['type'] : '';

    $assign_list["type"] = $type;

    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default', $type)) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }
    #
    $classTable = "TourProperty";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    #


    $listVISITORTYPE = $clsClassTable->getAll("is_trash=0 and type='VISITORTYPE' and is_online=1 order by order_no asc");
    $assign_list["listVISITORTYPE"] = $listVISITORTYPE;

    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=' . $act;
        if ($type != '') {
            $link .= '&type=' . $type;
        }
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    /* Get type of list news */
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;

    $cond = "1='1' and type<>'TRANSPORT'";
    if ($type != '') {
        $cond .= " and type='$type'";
        $pUrl = '&type=' . $type;
    }
    #Filter By Keyword
    if (isset($_GET['keyword'])) {
        if ($_GET['keyword'] != '') {
            $keyword = $core->replaceSpace($_GET['keyword']);
            $cond .= " and slug like '%" . $keyword . "%'";
            $assign_list["keyword"] = $_GET['keyword'];
        }
    }

    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no asc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = 20;
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit); //print_r($cond." order by ".$orderBy.$limit);die();
    $assign_list["allItem"] = $allItem;
    $assign_list["pUrl"] = $pUrl;
    #
    $assign_list["number_trash"] = $clsClassTable->getAll("is_trash=1 and " . $cond2) ? count($clsClassTable->getAll("is_trash=1 and " . $cond2)) : 0;
    $assign_list["number_item"] = $clsClassTable->getAll("is_trash=0 and " . $cond2) ? count($clsClassTable->getAll("is_trash=0 and " . $cond2)) : 0;
    $assign_list["number_all"] = $clsClassTable->getAll($cond2) ? count($clsClassTable->getAll($cond2)) : 0;
    // Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Delete') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($pvalTable)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : 0;
        if (empty($pvalTable)) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        #
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no desc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no asc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=PositionSuccess');
    }

    $clsTourProperty = new TourProperty();
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    $clsSettingChildPolicy = new SettingChildPolicy();
    $assign_list["clsSettingChildPolicy"] = $clsSettingChildPolicy;

    $adult_type_id = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORTYPE' order by order_no ASC limit 0,1");
    $adult_type_id = $adult_type_id[0]['tour_property_id'];

    $cond_setting = "is_trash=0 and tour_property_id='$adult_type_id' and type='SIZEGROUP'";
    $cond_setting .= " ORDER BY number_to ASC";
    $lstAdultGroupSize = $clsTourOption->getAll($cond_setting, $clsTourOption->pkey . ",number_to,number_from");
    $assign_list["lstAdultGroupSize"] = $lstAdultGroupSize;
}
function default_ajUpdPosSortTourProperty()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsTourProperty = new TourProperty();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsTourProperty->updateOne($val, "order_no='" . $key . "'");
    }
}
function default_ajUpdPosSortTourOption()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO, $package_id;
    #
    $clsTourOption = new TourOption();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsTourOption->updateOne($val, "order_no='" . $key . "'");
    }
}
/* ============== TOUR TRANSPORT MANAGEMENT ================ */

function default_transporttours()
{
    global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, 'property', 'transport', 'default')) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    $classTable = "TourTransport";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }

    $cond = "1=1";
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and ( trip_code like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%' or title like '%" . $slug . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;

    $orderBy = " order_no desc";
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    } elseif ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no desc";

    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = 30;
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
    $assign_list["allItem"] = $allItem;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['tourtransport_id']) ? ($_GET['tourtransport_id']) : '';
        $tourtransport_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $tourservice_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tourtransport_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['tourtransport_id']) ? ($_GET['tourtransport_id']) : '';
        $tourtransport_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $tourservice_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tourtransport_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['tourtransport_id']) ? ($_GET['tourtransport_id']) : '';
        $tourtransport_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $tourtransport_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($tourtransport_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $string = isset($_GET['tourtransport_id']) ? ($_GET['tourtransport_id']) : '';
        $pvalTable = intval($core->decryptID($string));
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';

        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        if (($string != '' && $pvalTable == 0) || $direct == '') {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }

        $where = "1='1' and is_trash=0";
        $pUrl = '&act=transporttours';
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no desc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
    }
}

function default_ajaxFrmTransportour()
{
    global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsTourTransport = new TourTransport();
    $tourtransport_id = isset($_POST['tourtransport_id']) ? intval($_POST['tourtransport_id']) : 0;
    #
    $html = '
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
		<h3>' . ($tourtransport_id == 0 ? $core->get_Lang('Add New Transport') : $core->get_Lang('Edit Detail Transport')) . '</h3>
	</div>';
    $html .= '
	<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
		<div class="wrap">
			<div class="row-span">
				<div class="fieldlabel text-right bold"><strong class="color_r">' . $core->get_Lang('title') . '</strong> <font color="red">*</font></div>
				<div class="fieldarea">
					<input class="text full required" name="title" value="' . $clsTourTransport->getTitle($tourtransport_id) . '" type="text" autocomplete="off" />
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('Image') . '</div>
				<div class="fieldarea">
					<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsTourTransport->getOneField('image', $tourtransport_id) . '" />
					<input type="hidden" id="isoman_hidden_image" value="' . $clsTourTransport->getOneField('image', $tourtransport_id) . '">
					<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsTourTransport->getOneField('image', $tourtransport_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsTourTransport->getOneField('image', $tourtransport_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel  text-right">' . $core->get_Lang('intro') . '</div>
				<div class="fieldarea">
					<textarea id="textarea_intro_editor' . time() . '" class="textarea_intro_editor" name="intro" rows="5" style="width:100%">' . $clsTourTransport->getIntro($tourtransport_id) . '</textarea>
				</div>
			</div>
			
		</div>
	</form>
	<div class="modal-footer">
		<button type="button" tourtransport_id="' . $tourtransport_id . '" class="btn btn-primary btnSaveTransport">
			<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span>
		</button>
		<button type="reset" class="btn btn-warning close_pop">
			<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
		</button>
	</div>';
    echo ($html);
    die();
}

function default_ajaxSaveTransportour()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "TourTransport";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $tourtransport_id = isset($_POST['tourtransport_id']) ? $_POST['tourtransport_id'] : 0;
    $titlePost = trim($_POST['title']);
    $slugPost = $core->replaceSpace($titlePost);
    $introPost = addslashes($_POST['intro']);
    $imagePost = addslashes($_POST['image']);
    #
    if (intval($tourtransport_id) == 0) {
        $all = $clsClassTable->getAll("is_trash=0 and slug like '%" . $slugPost . "' limit 0,1");
        if (!empty($all)) {
            echo '_EXIST';
            die();
        } else {
            $f = "user_id,user_id_update,title,slug,intro,order_no,reg_date,upd_date";
            $v = "'$user_id','$user_id','" . addslashes($titlePost) . "','" . addslashes($slugPost) . "','" . addslashes($introPost) . "'";
            $v .= ",'" . $clsClassTable->getMaxOrderNo() . "','" . time() . "','" . time() . "'";
            if ($imagePost != '' && $imagePost != '0') {
                $f .= ",image";
                $v .= ",'" . $imagePost . "'";
            }
            #

            if ($clsClassTable->insertOne($f, $v)) {
                echo '_SUCCESS';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        }
    } else {
        $vx = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',intro='$introPost',upd_date='" . time() . "',user_id_update='$user_id'";
        if ($imagePost != '' && $imagePost != '0') {
            $vx .= ",image='" . $imagePost . "'";
        }
        if ($clsClassTable->updateOne($tourtransport_id, $vx)) {
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}

/* ------ START_SLOTAVAILABLE ------- */

/* ------ Load Tour Gallery ------- */

function default_ajInitTSysTourGallery()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    #
    $clsTourImage = new TourImage();
    $table_id = $_POST['table_id'];
    #
    $html = '';
    $html .= '
	<div class="wrap">
		<div class="group_button fl">
			<form method="post" action="" accept="application/pdf" id="aj-upload-form" enctype="multipart/form-data">
				<input style="display:none" type="file" multiple="" name="image[]" id="ajAttachFile" />
				<a style="display:none" id="ajSysPhotosGallery" table_id="' . $table_id . '" class="iso-button-primary fl mr10">
					<i class="icon-random"></i>&nbsp; ' . $core->get_Lang('synchronizeposition') . '
				</a>
				<a table_id="' . $table_id . '" isoman_multiple="1" class="iso-button-standard ajOpenDialog fl mr10" isoman_for_id="image_val" isoman_name="image"><i class="icon-plus-sign"></i>&nbsp; ' . $core->get_Lang('addimages') . '</a>
				<input type="hidden" value="' . $table_id . '" name="table_id" id="Hid_TableID"/>
				<input type="hidden" value="' . $type . '" name="type" id="Hid_TypeID"/>
			</form>
		</div>
	</div>';
    $html .= '
	<div class="clearfix"><br /></div>
	<div class="hastable">
		<table class="full-width tbl-grid" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<td class="gridheader" style="width:40px"><strong>' . $core->get_Lang('index') . '</strong></td>
					<td class="gridheader"><strong>' . $core->get_Lang('images') . '</strong></td>
					<td class="gridheader text-left"><strong>' . $core->get_Lang('alttext') . '</strong></td>
					<td class="gridheader hiden767" style="width:12%"><strong>' . $core->get_Lang('update') . '</strong></td>
					<td class="gridheader" style="width:6%;"><strong>' . $core->get_Lang('func') . '</strong></td>
				</tr>
			</thead>
			<tbody id="preview"></tbody>
		</table>
		<div class="clearfix" style="height:5px"></div>
		<div class="pagination_box">
			<div class="wrap" id="gallery_paginate">
			<!-- Ajax Loading pagination -->
			</div>
		</div>
	</div>';
    // End code here !!
    $html .= '
	<script type="text/javascript">
		$(function(){
			checkSysPosition();
			$(document).on(\'click\', \'.ajdeletePhotosGallery\', function(ev){
				var $_this = $(this);
				if(confirm(confirm_delete)){
					$.ajax({
						type: "POST",
						url: path_ajax_script+"/index.php?mod=tour&act=ajOpenTourGallery",
						data: {\'tp\':\'D\', \'tour_image_id\': $_this.attr(\'data\')},
						dataType: "html",
						success: function(html){
							var $table_id = $(\'#Hid_TableID\').val();
							loadTableGallery($table_id,\'\',1,10);
							checkSysPosition();
						}
					});
				}
			});
			$(document).on(\'click\', \'.ajeditPhotosGallery\', function(ev){
				var $_this = $(this);
				var $tour_image_id = $_this.attr(\'data\');
				var $table_id = $_this.attr(\'table_id\');
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod=tour&act=ajOpenTourGallery",
					data: {\'tp\':\'C\',\'tour_image_id\' : $tour_image_id,\'table_id\' : $table_id},
					dataType: "html",
					success: function(html){
						makepopup(\'240px\',\'auto\',html,\'box_EditPhotosGallery\');
					}
				});
				return false;
			});
			$(document).on(\'click\', \'.ajmovePhotosGallery\', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type:\'POST\',
					url: path_ajax_script+"/index.php?mod=tour&act=ajOpenTourGallery",
					data: {
						\'tour_image_id\' : $_this.attr(\'data\'),
						\'direct\' : $_this.attr(\'direct\'),
						\'tp\' : \'M\'
					},
					success: function(html){
						vietiso_loading(0);
						var $table_id = $_this.attr(\'table_id\');
						var $page = $(\'#Hid_CurrentPage\').val();
						loadTableGallery($table_id,\'\',$page,10);
					}
				});
				return false;
			});
			$(document).on(\'click\', \'.paginate_button\', function(ev){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				var $keywrord = \'\';
				loadTableGallery($table_id,$keywrord,$_this.attr(\'page\'),10);
				return false;
			});
			$(\'#keysearch_pop\').bind(\'keyup change\',function(){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				var $page = $(\'#Hid_CurrentPage\').val();
				loadTableGallery($table_id,$_this.val(),$page,3);
			});
			$(document).on(\'click\', \'#ajSysPhotosGallery\', function(ev){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				vietiso_loading(1);
				$.ajax({
					type:\'POST\',
					url: path_ajax_script+"/index.php?mod=tour&act=ajOpenTourGallery",
					data:{"table_id" : $table_id,\'tp\':\'SYS\'},
					success: function(html){
						vietiso_loading(0);
						var $page = $(\'#Hid_CurrentPage\').val();
						loadTableGallery($table_id,\'\',$page,10);
					}
				});	
				return false;
			});
		});
		function isoman_callback(){
			var $table_id = $(\'#Hid_TableID\').val();
			var $page = $(\'#Hid_CurrentPage\').val();
			var $clsTable = \'TourImage\';
			var $type= \'TourImage\';
			var $file_images = isoman_selected_files();
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod=home&act=ajUploadForm",
				data: {
					\'table_id\':$table_id,
					\'type\':$type,
					\'clsTable\':$clsTable,
					\'file_images\':$file_images
				},
				dataType: "html",
				success: function(html){
					loadTableGallery($table_id,\'\', $page, 10);
					checkSysPosition();
				}
			});
		}
		function checkSysPosition(){
			var $table_id = $(\'#Hid_TableID\').val();
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod=tour&act=ajOpenTourGallery",
				data: {\'table_id\':$table_id,\'tp\':\'TOTAL\'},
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					var htm = parseInt(html);
					if(htm==0){
						$(\'#ajSysPhotosGallery\').hide();
					}else{
						$(\'#ajSysPhotosGallery\').show();
					}
				}
			});
		}
	</script>';
    $html .= '</div>';
    echo $html;
    die();
}

function default_ajOpenTourGallery()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn;
    #
    $clsPagination = new Pagination();
    $clsTourImage = new TourImage();
    $pkeyTable = $clsTourImage->pkey;

    $tour_image_id = isset($_POST['tour_image_id']) ? intval($_POST['tour_image_id']) : 0;
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    // Load List
    if ($tp == 'L') {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $number_per_page = isset($_POST['number_per_page']) ? intval($_POST['number_per_page']) : 10;
        //echo $number_per_page; die();
        #
        $cond = "is_trash=0 and table_id='$table_id'";
        if (trim($keyword) != '' && $keyword != '0') {
            $slug = $core->replaceSpace($keyword);
            $cond .= " and (title like '%$keyword%' or slug like '%$slug%')";
        }
        #
        $totalRecord = $clsTourImage->getAll($cond) ? count($clsTourImage->getAll($cond)) : 0;
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no asc";
        $limit = " LIMIT $offset,$number_per_page";

        $lstItem = $clsTourImage->getAll($cond . $order_by . $limit);
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $tour_image_id = $lstItem[$i][$clsTourImage->pkey];
                #
                $html .= '<tr style="cursor:move" id="order_' . $tour_image_id . '" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index2">' . ($offset + $i + 1) . '</td>';
                $html .= '<td width="85px"><a href="javascript:void();" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><img src="' . $ftp_abs_path_image . $lstItem[$i]['image'] . '" width="75" height="50" /></a></td>';
                $html .= '<td>
				
				<input class="editTitleImage full-width" style="max-width:200px" data="' . $tour_image_id . '" table_id="' . $table_id . '" value="' . $clsTourImage->getTitle($tour_image_id) . '" style="line-height:28px; font-size:12px; padding:0 10px" />
				<a style="display:none" href="javascript:void(0);" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><strong>' . $clsTourImage->getTitle($tour_image_id) . '</strong></a>
				
				</td>';
                $html .= '<td class="hiden767" style="text-align:right;color:#c00000">' . date('d-m-Y h:i', $lstItem[$i]['reg_date']) . '</td>';
                $html .= '
				<td style="vertical-align:middle; width:6%;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button> 
						<ul class="dropdown-menu">
							<li><a href="javascript:void(0);" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><i class="icon-edit"></i> ' . $core->get_Lang('edit') . '</a></li>
							<li><a href="javascript:void(0);" table_id="' . $table_id . '" data="' . $tour_image_id . '" title="' . $core->get_Lang('delete') . '" class="ajdeletePhotosGallery"><i class="icon-remove"></i> ' . $core->get_Lang('delete') . '</a></li>
						</ul>
					</div>
				</td>';
                $html .= '</tr>';
            }
            $html .= '
			<script type="text/javascript">
				$("#preview").sortable({
					opacity: 0.8,
					cursor: \'move\',
					start: function(){
						vietiso_loading(1);
					},
					stop: function(){
						vietiso_loading(0);
					},
					update: function(){
						var page = "' . $page . '";
						var order = $(this).sortable("serialize")+\'&update=update\'+\'&recordPerPage=' . $number_per_page . '\'+\'&currentPage=' . $page . '\';
						$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosTourGallery", order, function(html){
							loadTableGallery(tour_id, \'\', page, 10);
							vietiso_loading(0);
						});
					}
				});
				
				$(".editTitleImage").live("change", function() {
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script + "/?mod=" + mod + "&act=ajOpenTourGallery",
					data: {
						"table_id": $_this.attr("table_id"),
						"tour_image_id": $_this.attr("data"),
						"title": $_this.val(),
						"tp": "S"
					},
					dataType: "html",
					success: function(html) {
					alertify.success("Success");
					vietiso_loading(1);
					vietiso_loading(0);
		
					}
				});
			});
				
			</script>';
        } else {
            $html = '
			<tr style="background:#ffda0b;">
				<td colspan="9" style="text-align:center;text-decoration:blink">' . $core->get_Lang('nodata') . '</td>
		   </tr>';
        }
        echo $html . '$$$' . $pageview . '$$$' . $page;
        die();
    }
    // Delete
    else if ($tp == 'D') {
        $clsTourImage->deleteOne($tour_image_id);
        echo (1);
        die();
    }
    // Quick Create
    else if ($tp == 'Q') {
        $fx = "table_id,order_no,reg_date";
        $vx = "'$table_id','" . $clsTourImage->getMaxOrderNoByTour($table_id) . "','" . time() . "'";
        $clsTourImage->insertOne($fx, $vx);
        echo (1);
        die();
    }
    // Edit Upload Form
    else if ($tp == 'C') {
        $HTML .= '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . $core->get_Lang('Add/Edit File') . '</h3>
		</div>';
        $HTML .= '
		<form method="post" action="" method="post" id="aj-update-form" enctype="multipart/form-data">
		<table cellpadding="2" cellspacing="2" width="100%" class="form">
			<tr>
				<td class="fieldarea">
					<input type="text" name="title" class="text full required" style="width:100%" value="' . $clsTourImage->getTitle($tour_image_id) . '">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						<img src="' . $clsTourImage->getOneField('image', $tour_image_id) . '" id="isoman_show_image_val" />
						<input type="hidden" id="isoman_hidden_image_val" name="isoman_url_image" value="' . $clsTourImage->getOneField('image', $tour_image_id) . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image_val" isoman_val="' . $clsTourImage->getOneField('image', $tour_image_id) . '" isoman_name="image">
							<i class="iso-edit"></i>
						</a>';
        if ($clsTourImage->getOneField('image', $tour_image_id) != '') {
            $HTML .= '<a pvalTable="' . $tour_image_id . '" clsTable="TourImage" href="javascript:void()" title="' . $core->get_Lang('delete') . '" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a> ';
        }
        $HTML .= '</div>
				</td>
			</tr>
		</table>
		<div class="clear"><br />
		<div>840 x 420 ( W x h )</div>
		</div>';
        $HTML .= '<div class="modal-footer wrap">
					<a href="javascript:void(0);" class="iso-button-standard submitClick fr btnClickUpdate" tour_image_id="' . $tour_image_id . '" table_id="' . $table_id . '" ><img align="absmiddle" src="' . URL_IMAGES . '/v2/check.png"> ' . $core->get_Lang('save') . '</a>
			   </div>';
        $HTML .= '</form>';
        $HTML .= '
		<script type="text/javascript">
			$(function(){
				$(document).on(\'click\', \'.btnClickUpdate\', function(){
					var $_this = $(this);
					var $_form = $_this.closest(\'.frmPop\');
					var $title = $_form.find(\'input[name=title]\');
					if($title.val()==\'\'){
						$title.focus();
						alertify.error(field_is_required);
						return false;
					};
					$(\'#aj-update-form\').ajaxSubmit({
						type:\'POST\',
						url: path_ajax_script+"/index.php?mod=tour&act=ajOpenTourGallery",
						data : {\'tp\':\'S\',\'tour_image_id\': $_this.attr(\'tour_image_id\')},
						success: function(html){
							var htm = parseInt(html);
							if(htm==1){
								$(\'#aj-upload-form\').resetForm();
								var $table_id = $_this.attr(\'table_id\');
								var $page = $(\'#Hid_CurrentPage\').val();
								loadTableGallery($table_id, \'\',$page,10);
								$_form.find(\'.close_pop\').trigger(\'click\');
							}
						}
					});
					return false;
				});
			})
		</script>';
        echo $HTML;
        die();
    }
    // Save
    else if ($tp == 'S') {
        $titlePost = addslashes($_POST['title']);
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            $set = "title='" . $titlePost . "',slug='" . $core->replaceSpace($titlePost) . "',reg_date='" . time() . "'";
            if ($_POST['isoman_url_image'] != '' && $_POST['isoman_url_image'] != '0') {
                $set .= ",image='" . addslashes($_POST['isoman_url_image']) . "'";
            }
            if ($clsTourImage->updateOne($tour_image_id, $set)) {
                echo (1);
                die();
            } else {
                echo (0);
                die();
            }
        } else {
            echo (0);
            die();
        }
    } else if ($tp == 'M') {
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
        $one = $clsTourImage->getOne($tour_image_id);
        $table_id = $one['table_id'];
        $order_no = $one['order_no'];
        #
        $where = "table_id='$table_id'";
        if ($direct == 'moveup') {
            $lst = $clsTourImage->getAll($where . " and order_no>$order_no order by order_no asc limit 0,1");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTourImage->updateOne($lst[0][$clsTourImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsTourImage->getAll($where . " and order_no<$order_no order by order_no desc limit 0,1");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTourImage->updateOne($lst[0][$clsTourImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsTourImage->getAll($where . " and order_no>$order_no order by order_no asc");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTourImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no>$order_no order by order_no asc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTourImage->updateOne($lst[$i][$clsTourImage->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
                }
                unset($lst);
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsTourImage->getAll($where . " and type='$type' and order_no<$order_no order by order_no desc");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTourImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no<$order_no order by order_no desc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTourImage->updateOne($lst[$i][$clsTourImage->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
                }
                unset($lst);
            }
        }
        echo (1);
        die();
    } else if ($tp == 'TOTAL') {
        echo $clsTourImage->getAll("is_trash=0 and table_id='$table_id'") ? count($clsTourImage->getAll("is_trash=0 and table_id='$table_id'")) : 0;
        die();
    } else if ($tp == 'SYS') {
        $LISTALL = $clsTourImage->getAll("is_trash=0 and table_id='$table_id' order by tour_image_id asc");
        if (!empty($LISTALL)) {
            for ($i = 0; $i < count($LISTALL); $i++) {
                $clsTourImage->updateOne($LISTALL[$i][$clsTourImage->pkey], "order_no='" . ($i + 1) . "'");
            }
            unset($LISTALL);
        }
        echo (1);
        die();
    }
    echo (1);
    die();
}


function default_ajOpenTourGalleryNew()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn;
    #
    $clsPagination = new Pagination();
    $clsTourImage = new TourImage();
    $pkeyTable = $clsTourImage->pkey;

    $tour_image_id = isset($_POST['tour_image_id']) ? intval($_POST['tour_image_id']) : 0;
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    // Load List
    if ($tp == 'L') {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $number_per_page = isset($_POST['number_per_page']) ? intval($_POST['number_per_page']) : 10;
        //echo $number_per_page; die();
        #
        $cond = "is_trash=0 and table_id='$table_id'";
        if (trim($keyword) != '' && $keyword != '0') {
            $slug = $core->replaceSpace($keyword);
            $cond .= " and (title like '%$keyword%' or slug like '%$slug%')";
        }
        #
        $totalRecord = $clsTourImage->getAll($cond) ? count($clsTourImage->getAll($cond)) : 0;
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no asc";
        $limit = " LIMIT $offset,$number_per_page";

        $lstItem = $clsTourImage->getAll($cond . $order_by . $limit);
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $tour_image_id = $lstItem[$i][$clsTourImage->pkey];
                #
                $html .= '<tr style="cursor:move" id="order_' . $tour_image_id . '" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index">' . ($offset + $i + 1) . '</td>';
                $html .= '<td width="60px"><img src="' . $ftp_abs_path_image . $lstItem[$i]['image'] . '" width="60" height="40" /></td>';
                $html .= '<td><a href="javascript:void();" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><strong>' . $clsTourImage->getTitle($tour_image_id) . '</strong></a></td>';
                $html .= '<td style="text-align:right;color:#c00000">' . date('d-m-Y h:i', $lstItem[$i]['reg_date']) . '</td>';
                if (1 == 2) {
                    $html .= '<td style="text-align:center">' . ($i == 0 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="movetop" title="' . $core->get_Lang('movetop') . '" data="' . $tour_image_id . '" table_id="' . $table_id . '"><i class="icon-circle-arrow-up"></i></a>') . '</td>';
                    $html .= '<td style="text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="movebottom" title="' . $core->get_Lang('movebottom') . '" table_id="' . $table_id . '"><i class="icon-circle-arrow-down"></i></a>') . '</td>';
                    $html .= '<td style="text-align:center">' . ($i == 0 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="moveup" title="' . $core->get_Lang('moveup') . '" table_id="' . $table_id . '"><i class="icon-arrow-up"></i></a>') . '</td>';
                    $html .= '<td style="text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a href="javascript:void();" class="ajmovePhotosGallery" direct="movedown" title="' . $core->get_Lang('movedown') . '" data="' . $tour_image_id . '" table_id="' . $table_id . '"><i class="icon-arrow-down"></i></a>') . '</td>';
                }
                $html .= '
				<td style="vertical-align:middle; width:6%;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button> 
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a href="javascript:void(0);" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><i class="icon-edit"></i> ' . $core->get_Lang('edit') . '</a></li>
							<li><a href="javascript:void(0);" table_id="' . $table_id . '" data="' . $tour_image_id . '" title="' . $core->get_Lang('delete') . '" class="ajdeletePhotosGallery"><i class="icon-remove"></i> ' . $core->get_Lang('delete') . '</a></li>
						</ul>
					</div>
				</td>';
                $html .= '</tr>';
            }
            $html .= '
			<script type="text/javascript">
				$("#preview").sortable({
					opacity: 0.8,
					cursor: \'move\',
					start: function(){
						vietiso_loading(1);
					},
					stop: function(){
						vietiso_loading(0);
					},
					update: function(){
						var page = "' . $page . '";
						var order = $(this).sortable("serialize")+\'&update=update\'+\'&recordPerPage=' . $number_per_page . '\'+\'&currentPage=' . $page . '\';
						$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosTourGallery", order, function(html){
							loadTableGallery(tour_id, \'\', page, 10);
							vietiso_loading(0);
						});
					}
				});
			</script>';
        } else {
            $html = '
			<tr style="background:#ffda0b;">
				<td colspan="9" style="text-align:center;text-decoration:blink">' . $core->get_Lang('nodata') . '</td>
		   </tr>';
        }
        echo $html . '$$$' . $pageview . '$$$' . $page;
        die();
    }
    // Delete
    else if ($tp == 'D') {
        $clsTourImage->deleteOne($tour_image_id);
        echo (1);
        die();
    }
    // Quick Create
    else if ($tp == 'Q') {
        $fx = "table_id,order_no,reg_date";
        $vx = "'$table_id','" . $clsTourImage->getMaxOrderNoByTour($table_id) . "','" . time() . "'";
        $clsTourImage->insertOne($fx, $vx);
        echo (1);
        die();
    }
    // Edit Upload Form
    else if ($tp == 'C') {
        $HTML .= '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . $core->get_Lang('Add/Edit File') . '</h3>
		</div>';
        $HTML .= '
		<form method="post" action="" method="post" id="aj-update-form" enctype="multipart/form-data">
		<table cellpadding="2" cellspacing="2" width="100%" class="form">
			<tr>
				<td class="fieldarea">
					<input type="text" name="title" class="text full required" style="width:96%" value="' . $clsTourImage->getTitle($tour_image_id) . '">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						<img src="' . $clsTourImage->getOneField('image', $tour_image_id) . '" id="isoman_show_image_val" />
						<input type="hidden" id="isoman_hidden_image_val" name="isoman_url_image" value="' . $clsTourImage->getOneField('image', $tour_image_id) . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image_val" isoman_val="' . $clsTourImage->getOneField('image', $tour_image_id) . '" isoman_name="image">
							<i class="iso-edit"></i>
						</a>';
        if ($clsTourImage->getOneField('image', $tour_image_id) != '') {
            $HTML .= '<a pvalTable="' . $tour_image_id . '" clsTable="TourImage" href="javascript:void()" title="' . $core->get_Lang('delete') . '" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a> ';
        }
        $HTML .= '</div>
				</td>
			</tr>
		</table>
		<div class="clear"><br /></div>';
        $HTML .= '<div class="modal-footer wrap">
					<a href="javascript:void(0);" class="iso-button-standard submitClick fr btnClickUpdate" tour_image_id="' . $tour_image_id . '" table_id="' . $table_id . '" ><img align="absmiddle" src="' . URL_IMAGES . '/v2/check.png"> ' . $core->get_Lang('save') . '</a>
			   </div>';
        $HTML .= '</form>';
        $HTML .= '
		<script type="text/javascript">
			$(function(){
				$(document).on(\'click\', \'.btnClickUpdate\', function(){
					var $_this = $(this);
					var $_form = $_this.closest(\'.frmPop\');
					var $title = $_form.find(\'input[name=title]\');
					if($title.val()==\'\'){
						$title.focus();
						alertify.error(field_is_required);
						return false;
					};
					$(\'#aj-update-form\').ajaxSubmit({
						type:\'POST\',
						url: path_ajax_script+"/index.php?mod=tour&act=ajOpenTourGallery",
						data : {\'tp\':\'S\',\'tour_image_id\': $_this.attr(\'tour_image_id\')},
						success: function(html){
							var htm = parseInt(html);
							if(htm==1){
								$(\'#aj-upload-form\').resetForm();
								var $table_id = $_this.attr(\'table_id\');
								var $page = $(\'#Hid_CurrentPage\').val();
								loadTableGallery($table_id, \'\',$page,10);
								$_form.find(\'.close_pop\').trigger(\'click\');
							}
						}
					});
					return false;
				});
			})
		</script>';
        echo $HTML;
        die();
    }
    // Save
    else if ($tp == 'S') {
        $titlePost = addslashes($_POST['title']);
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            $set = "title='" . $titlePost . "',slug='" . $core->replaceSpace($titlePost) . "',reg_date='" . time() . "'";
            if ($_POST['isoman_url_image'] != '' && $_POST['isoman_url_image'] != '0') {
                $set .= ",image='" . addslashes($_POST['isoman_url_image']) . "'";
            }
            if ($clsTourImage->updateOne($tour_image_id, $set)) {
                echo (1);
                die();
            } else {
                echo (0);
                die();
            }
        } else {
            echo (0);
            die();
        }
    } else if ($tp == 'M') {
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
        $one = $clsTourImage->getOne($tour_image_id);
        $table_id = $one['table_id'];
        $order_no = $one['order_no'];
        #
        $where = "table_id='$table_id'";
        if ($direct == 'moveup') {
            $lst = $clsTourImage->getAll($where . " and order_no>$order_no order by order_no asc limit 0,1");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTourImage->updateOne($lst[0][$clsTourImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsTourImage->getAll($where . " and order_no<$order_no order by order_no desc limit 0,1");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTourImage->updateOne($lst[0][$clsTourImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsTourImage->getAll($where . " and order_no>$order_no order by order_no asc");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTourImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no>$order_no order by order_no asc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTourImage->updateOne($lst[$i][$clsTourImage->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
                }
                unset($lst);
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsTourImage->getAll($where . " and type='$type' and order_no<$order_no order by order_no desc");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTourImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no<$order_no order by order_no desc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTourImage->updateOne($lst[$i][$clsTourImage->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
                }
                unset($lst);
            }
        }
        echo (1);
        die();
    } else if ($tp == 'TOTAL') {
        echo $clsTourImage->getAll("is_trash=0 and table_id='$table_id'") ? count($clsTourImage->getAll("is_trash=0 and table_id='$table_id'")) : 0;
        die();
    } else if ($tp == 'SYS') {
        $LISTALL = $clsTourImage->getAll("is_trash=0 and table_id='$table_id' order by tour_image_id asc");
        if (!empty($LISTALL)) {
            for ($i = 0; $i < count($LISTALL); $i++) {
                $clsTourImage->updateOne($LISTALL[$i][$clsTourImage->pkey], "order_no='" . ($i + 1) . "'");
            }
            unset($LISTALL);
        }
        echo (1);
        die();
    }
    echo (1);
    die();
}

function default_ajUpdPosTourGallery()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsTourImage = new TourImage();
    $order = $_POST['order'];
    $currentPage     = $_POST['currentPage'];
    $recordPerPage     = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsTourImage->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_ajOpenSotAvailable()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsISO;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();
    $clsTourStartDate = new TourStartDate();
    $tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : 0;
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $is_type_table = isset($_POST['is_type_table']) ? $_POST['is_type_table'] : 'grid';
    #
    if ($tp == 'L') {
        $pp_month = isset($_POST['pp_month']) ? intval($_POST['pp_month']) : date('n');
        $pp_year = isset($_POST['pp_year']) ? intval($_POST['pp_year']) : date('Y');
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $pp_month, $pp_year);
        #
        $_daterange = array();
        for ($i = 1; $i <= $totalDays; $i++) {
            $_daterange[] = strtotime($i . '-' . $pp_month . '-' . $pp_year);
        }
        #
        $html = '';
        $html = '
		<div class="hd">
			<div class="span">
				<label>' . $core->get_Lang('month') . '</label>
				<select id="chgSellByMonth">' . $clsISO->makeSelectMonth($pp_month) . '</select>
				<label>' . $core->get_Lang('year') . '</label>
				<select id="chgSellByYear">' . $clsISO->makeSelectYear($pp_year) . '</select>
			</div>
		</div>
		<h2 class="text-center font16px"><strong>' . $core->get_Lang('List open day sell month') . ' ' . $pp_month . '/' . $pp_year . '</strong></h2>
		<div class="clearfix"><br /></div>
		<div id="pTSell">';
        if ($is_type_table == 'grid') {
            $html .= '
				<style type="text/css">
					#pTSell{ overflow:auto;}
					#pTSell > .form{ width:225%;}
					#pTSell > .form td.fieldarea{ padding:4px !important; width:100px; height:28px; light-height:28px;}
					#pTSell > .form input.full{ width:52px; height:28px; light-height:28px;}
					#pTSell > .form input.medium{ width:32px; height:28px; light-height:28px;}
				</style>
				<table class="form" cellpadding="2" cellspacing="2" style="table-layout:auto;">
					<tbody>
						<tr>
							<td class="fieldarea" style="width:5%;">' . $core->get_Lang('day') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center">
									<strong>' . date('D', $_daterange[$i]) . '</strong>
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('date') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center"><strong>' . date('d', $_daterange[$i]) . '</strong></td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('numberofseats') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="text-center">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" toField="allotment" class="text medium text-center autosavefield saleSlot" start_date="' . $_daterange[$i] . '" type="text" id="input_' . $_daterange[$i] . '_' . $tour_id . '" value="' . $clsTourStartDate->getValue($_daterange[$i], $tour_id, 'allotment') . '" style="font-size:11px;">
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('hadsold') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" toField="seat_sale" class="text medium text-center autosavefield" id="input_sale_' . $_daterange[$i] . '_' . $tour_id . '" start_date="' . $_daterange[$i] . '" type="text" value="' . $clsTourStartDate->getValue($_daterange[$i], $tour_id, 'seat_sale') . '" style="font-size:11px;">
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('empty') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" toField="seat_available" class="text medium text-center autosavefield" id="input_avai_' . $_daterange[$i] . '_' . $tour_id . '" start_date="' . $_daterange[$i] . '"  type="text" value="' . $clsTourStartDate->getValue($_daterange[$i], $tour_id, 'seat_available') . '" style="font-size:11px;">
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('price') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" toField="price" class="text full text-center autosavefield price-In" id="input_price_' . $_daterange[$i] . '_' . $tour_id . '" start_date="' . $_daterange[$i] . '" type="text" value="' . $clsTourStartDate->getValue($_daterange[$i], $tour_id, 'price') . '" style="font-size:11px;">
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('priceold') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" toField="price_old" class="text full text-center autosavefield price-In" id="input_price_old_' . $_daterange[$i] . '_' . $tour_id . '" start_date="' . $_daterange[$i] . '" type="text" value="' . $clsTourStartDate->getValue($_daterange[$i], $tour_id, 'price_old') . '" style="font-size:11px;">
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('active') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="fieldarea text-center" style="background:#D4D3E7 !important">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" ' . ($clsTourStartDate->checkIsActive($_daterange[$i], $tour_id) ? 'checked="checked"' : '') . ' id="chk_' . $_daterange[$i] . '_' . $tour_id . '" start_date="' . $_daterange[$i] . '" tour_id="' . $tour_id . '" value="1" type="checkbox" class="chkSell">
								</td>';
            }
            $html .= '
						</tr>
					</tbody>
				</table>
				';
        } else {
            $cond = "is_trash=0 and tour_id = '$tour_id'";
            if (!empty($pp_month) && !empty($pp_year)) {
                $start_date = $pp_month . '/01/' . $pp_year;
                $end_date = $pp_month . '/31/' . $pp_year;
                $cond .= " and start_date >= '" . strtotime($start_date) . "' and start_date <= '" . strtotime($end_date) . "'";
            }
            $cond .= " order by start_date asc";
            #
            $lstDepart = $clsTourStartDate->getAll($cond);
            $html .= '
				<table class="tbl-grid" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td class="gridheader"><strong>' . $core->get_Lang('Code') . '</strong></td>
						<td class="gridheader" style="text-align:left"><strong>' . $core->get_Lang('departuredate') . '</strong></td>
						<td class="gridheader" style="text-align:left"><strong>' . $core->get_Lang('enddate') . '</strong></td>
						<td class="gridheader"><strong>' . $core->get_Lang('allotment') . '</strong></td>
						<td class="gridheader"><strong>' . $core->get_Lang('soldout') . '</strong></td>
						<td class="gridheader"><strong>' . $core->get_Lang('seatavailable') . '</strong></td>
						<td class="gridheader"><strong>' . $core->get_Lang('price') . ' (' . $clsISO->getRate() . ')</strong></td>
						<td class="gridheader"><strong>' . $core->get_Lang('oldprice') . ' (' . $clsISO->getRate() . ')</strong></td>
						<td class="gridheader" style="width:3%;text-align:center"><strong>' . $core->get_Lang('status') . '</strong></td>
					</tr>';
            if (!empty($lstDepart)) {
                for ($i = 0; $i < count($lstDepart); $i++) {
                    $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                    $html .= '<td><a target="_blank" href="' . $clsTour->getLinkDetailStartDate($tour_id, $lstDepart[$i]['start_date']) . '">' . $clsTourStartDate->getTripCode($lstDepart[$i][$clsTourStartDate->pkey]) . '</a></td>';
                    $html .= '<td>' . $clsISO->formatDate($lstDepart[$i]['start_date']) . '</td>';
                    $html .= '<td>' . $clsISO->formatDate($clsTourStartDate->getEndDateDefault($lstDepart[$i][$clsTourStartDate->pkey])) . '</td>';
                    $html .= '<td>' . $lstDepart[$i]['allotment'] . '</td>';
                    $html .= '<td>' . $lstDepart[$i]['seat_sale'] . '</td>';
                    $html .= '<td>' . $lstDepart[$i]['seat_available'] . '</td>';
                    $html .= '<td>' . $clsISO->formatNumberToEasyRead($lstDepart[$i]['price']) . ' ' . $clsISO->getRate() . '</td>';
                    $html .= '<td>' . $clsISO->formatNumberToEasyRead($lstDepart[$i]['price_old']) . ' ' . $clsISO->getRate() . '</td>';
                    if ($clsTourStartDate->checkTourStartDate($tour_id, $lstDepart[$i]['start_date'])) {
                        $html .= '<td><span class="status_approved">' . $core->get_Lang('Sell') . '</span></td>';
                    } else {
                        $html .= '<td><span class="status_remove">' . $core->get_Lang('Sold out') . '</span></td>';
                    }
                    $html .= '</tr>';
                }
            }
            $html .= '</table>';
        }
        $html .= '</div>';
        echo $html;
        die();
    } else if ($tp == 'S') {
        $start_date = isset($_POST['start_date']) ? intval($_POST['start_date']) : 0;
        $is_active = isset($_POST['is_active']) ? intval($_POST['is_active']) : 0;
        #
        if ($is_active) {
            #
            $res = $clsTourStartDate->getAll("start_date = '$start_date' and tour_id = '$tour_id' limit 0,1");
            if ($res[0][$clsTourStartDate->pkey] == '') {
                $number_day = $clsTour->getOneField('number_day', $tour_id);
                $end_date = $start_date + ($number_day - 1) * 24 * 60 * 60;
                #
                $fx = "tour_start_date_id,user_id,user_id_update,tour_id,title,start_date,end_date,is_active,reg_date,upd_date";
                $vx = "'" . $clsTourStartDate->getMaxId() . "'
					,'$user_id'
					,'$user_id'
					,'$tour_id'
					,'$start_date'
					,'$start_date'
					,'$end_date'
					,'1'
					,'" . time() . "'
					,'" . time() . "'
					";
                #
                $clsTourStartDate->insertOne($fx, $vx);
            } else {
                $tour_start_date_id = $clsTourStartDate->getId($start_date, $tour_id);
                $clsTourStartDate->updateOne($tour_start_date_id, "is_active=1");
            }
        } else {
            $tour_start_date_id = $clsTourStartDate->getId($start_date, $tour_id);
            $clsTourStartDate->updateOne($tour_start_date_id, "is_active=0");
        }
        #
        echo (1);
        die();
    }
}




// Extension mod Tours
require_once(DIR_MODULES . '/tour/mod_default.php');
require_once(DIR_MODULES . '/tour/sub_startdate.php');
