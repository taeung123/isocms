<?php
function default_default() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $extLang;
    $assign_list["clsModule"] = $clsModule;
    $clsUser = new User();
    $user_id = $core->_USER['user_id'];
    $user_group_id = $clsUser->getOneField('user_group_id', $user_id);
    #

    $classTable = "Transfer";
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
	
    $cond2 = $cond;
    if ($user_group_id == 2) {
        $cond .= " and is_online='0' and user_id='$user_id'";
    }
    $orderBy = " order_no asc";
    #-------Page Divide---------------------------------------------------------------
	
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";

    $totalRecord = $clsClassTable->countItem($cond);
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

function default_list_promotion() {
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

    $totalRecord = $clsClassTable->countItem($cond);
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

function default_ajUpdPosSortTransfer(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTransfer = new Transfer();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key+1);
		$clsTransfer->updateOne($val,"order_no='".$key."'");	
	}
}

function default_tourhotel() {
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
    $string = isset($_GET['transfer_id']) ? ($_GET['transfer_id']) : '';
    $transfer_id = intval($core->decryptID($string));
    $assign_list["transfer_id"] = $transfer_id;
    if ($string != '' && $transfer_id == 0) {
        header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
    }
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = "&act={$act}&transfer_id=" . $core->encryptID($transfer_id);
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
    $cond .= " and is_trash=0 and transfer_id='$transfer_id'";
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
        $hotel_id = isset($_GET['hotel_id']) ? ($_GET['hotel_id']) : '';
        $string = isset($_GET['transfer_id']) ? ($_GET['transfer_id']) : '';
        $transfer_id = intval($core->decryptID($string));
        if ($transfer_id == '' && $transfer_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteByCond("transfer_id='$transfer_id' and hotel_id = '$hotel_id'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&transfer_id=' . $core->encryptID($transfer_id) . '&message=DeleteSuccess');
        }
    }
}

function default_ajMoveTourStore() {
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $postData = $_POST;
    $transfer_id = isset($postData['transfer_id']) ? ($postData['transfer_id']) : '';
    $transfer_id = intval($core->decryptID($transfer_id));
    #
    $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
    $pvalTable = isset($postData['tour_store_id']) ? ($postData['tour_store_id']) : '';
    $pvalTable = intval($core->decryptID($pvalTable));
    #		

    $one = $clsClassTable->getOne($pvalTable);
    $order_no = $one['order_no'];

    $cond = "is_trash=0 and transfer_id = '$transfer_id'";
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
function default_edit() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core, 
	
	$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration;
	
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #
    
	$clsProperty = new Property();$assign_list["clsProperty"] = $clsProperty;
	$clsTransferPrice = new TransferPrice();
	$assign_list["clsTransferPrice"] = $clsTransferPrice;
	$clsTransferImage = new TransferImage();
	$assign_list["clsTransferImage"] = $clsTransferImage;
	$clsTourExtension = new TourExtension();
	$assign_list["clsTourExtension"] = $clsTourExtension;

    $classTable = "Transfer";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["get"] = $_GET;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
	
	
	
    #
    $clsCountry = new _Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $lstCity = $clsCity->getAll("is_trash=0 and country_id='1'");
    $assign_list["lstCity"] = $lstCity;
    $clsProfile = new Profile();
    $assign_list["clsProfile"] = $clsProfile;
   
    $transfer_id = isset($_GET['transfer_id']) ? ($_GET['transfer_id']) : '';
    $transfer_id = intval($core->decryptID($transfer_id));
   

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
    $assign_list['transfer_id'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;
	
	//$departure_point=unserialize($oneItem['departure_point_id']);
	$departure_region_id=$oneItem['region_departure_id'];
	$departure_country_id=$oneItem['country_departure_id'];
	$departure_point_id=$oneItem['city_departure_id'];
	
	$assign_list["departure_point_id"] = $departure_point_id;
	$assign_list["departure_region_id"] = $departure_region_id;
	$assign_list["departure_country_id"] = $departure_country_id;
	
	
	
	//$end_point=unserialize($oneItem['end_point_id']);
	$region_end_point_id=$oneItem['region_end_id'];
	$country_end_point_id=$oneItem['country_end_id'];
	$end_point_id=$oneItem['city_end_id'];
	
	$assign_list["end_point_id"] = $end_point_id;
	$assign_list["region_end_point_id"] = $region_end_point_id;
	$assign_list["country_end_point_id"] = $country_end_point_id;
	
	$clsCar = new Car();
	$assign_list["clsCar"] = $clsCar;
	$lstCarTransfer = $clsCar->getAll("is_trash=0 and is_online=1 order by order_no asc");
	$assign_list["lstCarTransfer"] = $lstCarTransfer;
	unset($lstCarTransfer);
	
	$listTypeOfTrip= $clsProperty->getAll("is_trash=0 and type='TypeOfTrip' order by order_no asc");
	$assign_list["listTypeOfTrip"] = $listTypeOfTrip;
	unset($listTypeOfTrip);

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
    $clsForm->addInputTextArea("full", 'exclusion', "", 'exclusion', 255, 25, 2, 1, "style='width:100%; height:420px'");
	$clsForm->addInputTextArea("full", 'inclusion', "", 'inclusion', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'service_information', "", 'service_information', 255, 25, 2, 1, "style='width:100%; height:420px'");
	$clsForm->addInputTextArea("full", 'highlight', "", 'highlight', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'overview', "", 'overview', 255, 25, 2, 1, "style='width:100%; height:420px'");
	$clsForm->addInputTextArea("full", 'embed_map', "", 'embed_map', 255, 25, 2, 1, "style='width:100%; height:420px'");
	$clsForm->addInputTextArea("full", 'note_map', "", 'note_map', 255, 25, 2, 1, "style='width:100%; height:420px'");
    #=========================================#
    if (isset($_POST['UpdateStep1']) && $_POST['UpdateStep1'] == 'UpdateStep1') {
		if ($pvalTable > 0) {
			$value = "";
			$firstAdd = 0;
			foreach ($_POST as $key => $val) {
				if(!empty($val)){
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
			}
			
			
			
			$value .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
			$value .= ",upd_date='" . time() . "'";
			$value .= ",title='" .ucwords(addslashes($_POST['title'])) . "'";
			$value .= ",slug='" . $core->replaceSpace($_POST['title']) . "'";
			
			
			
			$arr_departure_point =array();
			$arr_departure_point['country_departure_point_id'] = $_POST['country_departure_point_id'];
			$arr_departure_point['region_departure_point_id'] = $_POST['region_departure_point_id'];  
			$arr_departure_point['departure_point_id'] = $_POST['departure_point_id'];  
			
			$arr_end_point =array();
			$arr_end_point['country_end_point_id'] = $_POST['country_end_point_id'];
			$arr_end_point['region_end_point_id'] = $_POST['region_end_point_id'];  
			$arr_end_point['end_point_id'] = $_POST['end_point_id'];  
				
				
			$value .= ",departure_point_id='" .serialize($arr_departure_point). "'";
			$value .= ",end_point_id='" . serialize($arr_end_point). "'";
			$value .= ",country_departure_id='" .$_POST['country_departure_point_id']. "'";
			$value .= ",country_end_id='" .$_POST['country_end_point_id']. "'";
			$value .= ",region_departure_id='" .$_POST['region_departure_point_id']. "'";
			$value .= ",region_end_id='" .$_POST['region_end_point_id']. "'";
			$value .= ",city_departure_id='" .$_POST['departure_point_id']. "'";
			$value .= ",city_end_id='" .$_POST['end_point_id']. "'";
			
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$image_banner = isset($_POST['image_banner_src']) ? $_POST['image_banner_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
				$image_banner = isset($_POST['isoman_url_image_banner']) ? $_POST['isoman_url_image_banner'] : '';
			}
			if ($image != '' && $image != '0' ||$image_banner != '' && $image_banner != '0') {
				$value .= ",image='" . addslashes($image) . "',image_banner='" . addslashes($image_banner) . "'";
			}
			//print_r($pvalTable.'xxxx'.$value); die();
			if ($clsClassTable->updateOne($pvalTable, $value)) {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess');
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($pvalTable) . '&message=updateFailed');
			}
		}else{
			$listTable=$clsClassTable->getAll("1=1", $clsClassTable->pkey.",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no=$listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey],"order_no='".$order_no."'");
			}
			$value    = "";
			$firstAdd = 0;
			$field    = "";
			foreach ($_POST as $key => $val) {
				if(!empty($val)){
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
			}
			
			$arr_departure_point =array();
			$arr_departure_point['country_departure_point_id'] = $_POST['country_departure_point_id'];
			$arr_departure_point['region_departure_point_id'] = $_POST['region_departure_point_id'];  
			$arr_departure_point['departure_point_id'] = $_POST['departure_point_id'];  
			
			$arr_end_point =array();
			$arr_end_point['country_end_point_id'] = $_POST['country_end_point_id'];
			$arr_end_point['region_end_point_id'] = $_POST['region_end_point_id'];  
			$arr_end_point['end_point_id'] = $_POST['end_point_id'];  
				
			
			
			$transfer_id = $clsClassTable->getMaxId();
			$field .= ",user_id,user_id_update,reg_date,upd_date,title,slug,transfer_id,departure_point_id,end_point_id,country_departure_id,country_end_id,region_departure_id,region_end_id,city_departure_id,city_end_id,order_no";
			$value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
			$value .= ",'" .ucwords($_POST['title']) . "','" . str_replace('$', '', $core->replaceSpace($_POST['title'])) . "','" . $transfer_id . "','".serialize($arr_end_point)."','".serialize($arr_departure_point)."','".$_POST['country_departure_point_id']."','".$_POST['country_end_point_id']."','".$_POST['region_departure_point_id']."','".$_POST['region_end_point_id']."','".$_POST['departure_point_id']."','".$_POST['end_point_id']."','1'";
		
			
				#--Special Field: image
			
			$image     = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$image_banner     = isset($_POST['image_banner_src']) ? $_POST['image_banner_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
				$image_banner = isset($_POST['isoman_url_image_banner']) ? $_POST['isoman_url_image_banner'] : '';
			}
			if ($image != '' && $image != '0' || $image_banner != '' && $image_banner != '0') {
				$field .= ',image';
				$value .= ",'" . addslashes($image) . "'";
				$field .= ',image_banner';
				$value .= ",'" . addslashes($image_banner) . "'";
			}
			$pUrl = '';
			//print_r($field.'xxxx'.$value); die();
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location:' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($transfer_id) . '&message=insertSuccess');
				} else {
					header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
				}
			} else {
				header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertFailed');
			}

		}

    }
    if (isset($_POST['UpdateStep2']) && $_POST['UpdateStep2'] == 'UpdateStep2') {
		$value .= "list_car_id='" . $clsISO->makeSlashListFromArrayComma($_POST['list_car_id']) . "'";
		if ($clsClassTable->updateOne($pvalTable, $value)) {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess');
		} else {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($pvalTable) . '&message=updateFailed');
		}
	}
    
	
    if (isset($_POST['UpdateStep6']) && $_POST['UpdateStep6'] == 'UpdateStep6') {
        if ($_POST['config_value_title'] != '') {
            if ($meta_id == '') {
                $clsMeta->insertOne("config_link,reg_date,meta_id", "'" . $linkMeta . "','" . time() . "','" . $clsMeta->getMaxId() . "'");
                $allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
                $meta_id = $allMeta[0]['meta_id'];
            }
            $clsMeta->updateOne($meta_id, "config_value_intro='" . addslashes($_POST['config_value_intro']) . "',config_value_keyword='" . addslashes($_POST['config_value_keyword']) . "',config_value_title='" . addslashes($_POST['config_value_title']) . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess#isotab5');
    }
   
}

function default_move() {
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

function default_move2() {
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

function default_trash() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
	#
    $classTable = "Transfer";
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

function default_trash2() {
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

function default_restore() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];

    $classTable = "Transfer";
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

function default_restore2() {
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

function default_delete() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
	$clsTransferImage= new TransferImage();
    $classTable = "Transfer";
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
		 $clsTransferImage->deleteByCond("transfer_id='$pvalTable'");
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=DeleteSuccess');
    }
}

function default_delete2() {
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
    if (isset($_POST['agree']) && $_POST['agree'] == 'agree') {
        if ($clsClassTable->deleteOne($pvalTable)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=DeleteSuccess');
        }
    }
}
function default_store(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#
	$clsTourStore = new TourStore();
	$assign_list["clsTourStore"] = $clsTourStore;
	#
	$classTable = "Tour";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$type = isset($_GET['type'])?$core->decryptID($_GET['type']):'';$assign_list["type"] = $type;
	$keyword = isset($_GET['keyword'])?$_GET['keyword']:'';$assign_list["keyword"] = $keyword;
	
	if($type==''){
		header('location: '.PCMS_URL.'/?mod=tour&message=notPermission');
	}
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = '&act='.$act;
		$link .= '&type='.$core->encryptID($type);

		if($_POST['keyword']!=''&&$_POST['keyword']!='Tìm kiếm...'){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	#
	$cond = "is_trash=0 and is_online=1";

	if($type != ''){
		$cond.= " and transfer_id NOT IN (SELECT transfer_id FROM ".DB_PREFIX."tour_store WHERE is_trash=0 and _type='$type')";
		$pUrl.='&type='.$core->encryptID($type);
	}
	if($keyword != ''){
		$slug = $core->replaceSpace($keyword);
		$cond .= " and slug like '%".$slug."%'";
	}
	$orderBy = " order_no asc";
	
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$stt=($currentPage-1)*$recordPerPage;
	$assign_list['stt'] = $stt;
	
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='type_list')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	$listItem = $clsClassTable->getAll($cond." order by ".$orderBy.$limit);
	$assign_list["listItem"] = $listItem;
	
	
	#
	$listSelected =  $clsTourStore->getAll("is_trash=0 and _type = '$type' order by order_no asc");
	$assign_list["listSelected"] = $listSelected;
	
	//Action
	$action = isset($_GET['action'])?$_GET['action']:'';
	if($action=='Add'){
		$pvalTable = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]: '';
		if($pvalTable=='' && $pvalTable==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		if(!$clsTourStore->checkExist($pvalTable,$type)) {
			$listTable=$clsTourStore->getAll("1=1 and type='$type'", $clsTourStore->pkey.",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no=$listTable[$i]['order_no'] + 1;
				$clsTourStore->updateOne($listTable[$i][$clsTourStore->pkey],"order_no='".$order_no."'");
			}
			$max_id = $clsTourStore->getMaxID();
			$max_order_no = $clsTourStore->getMaxOrder();
			$f = "tour_store_id,transfer_id,_type,order_no";
			$v = "'$max_id','$pvalTable','$type','$max_order_no'";
			if($clsTourStore->insertOne($f,$v)) {
				header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.$pUrl.'&message=insertSuccess');
			}
		}
	}
	//print_r(xxxx); die();
}



function default_ajOpenManageTransferCarPrice(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
	$user_id = $core->_USER['user_id'];
	#
	$clsTransfer = new Transfer();
	$clsTransferPrice = new TransferPrice();
	$clsCar = new Car();
	$clsProperty = new Property();
	
	$transfer_id = isset($_POST['transfer_id'])?intval($_POST['transfer_id']):0;
	$car_id = isset($_POST['car_id'])?intval($_POST['car_id']):0;
	$type_of_trip_id = isset($_POST['type_of_trip_id'])?intval($_POST['type_of_trip_id']):0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	
	if($tp=='L'){
		$html = '';
		if($lstCar){
			$html .= '
			<table class="table tbl-grid" style="border:1px solid #ccc; min-width:100%;">
				<thead>
					<tr>
						<td rowspan="2" class="gridheader">
							<strong><span class="table_price_title">'.$core->get_Lang('Vehicle').'</span></strong>
						</td>';
				foreach($lstTypeTrip as $k=>$v){	
				$html .='<td class="gridheader" style="text-align:center;" colspan="'.(count($lstCarSeat)*2).'">
							<strong>'.$clsProperty->getTitle($v[$clsProperty->pkey]).'</strong> 
						</td>';
				}
				$html .='</tr>
				<tr>';
				foreach($lstTypeTrip as $a=>$b){
					foreach($lstCarSeat as $k=>$v){
						$html .= '<td class="gridheader" style="text-align:center;">'.$clsProperty->getTitle($v[$clsProperty->pkey]).'</td>';
						$html .= '<td class="gridheader" style="text-align:center;">'.$core->get_Lang('Km+').'</td>';
					}
				}
				$html.= '
				</tr>
			</thead>';
			foreach($lstCar as $key=>$val){
				$html .= '
				<tr>
					<td style="text-align:left;">'.$clsCar->getTitle($val[$clsCar->pkey]).'</td>';
					foreach($lstTypeTrip as $a=>$b){
						foreach($lstCarSeat as $k=>$v){
							$html .= '
							<td class="text-center">
								'.$clsISO->getRate().'<br />
								<input class="text full price-In h_transfer_price fontLarge" style="width:60px; text-align:right; color:red;" transfer_id="'.$transfer_id.'" car_id="'.$val[$clsCar->pkey].'" type_of_trip_id="'.$clsProperty->getOneField('min_value',$b[$clsProperty->pkey]).'" seat_id="'.$v[$clsProperty->pkey].'" value="'.$clsTransferPrice->getPrice($transfer_id,$val[$clsCar->pkey],$v[$clsProperty->pkey],$clsProperty->getOneField('min_value',$b[$clsProperty->pkey])).'" type="text" />
							</td>';
							$html .= '
							<td class="text-center">
								'.$clsISO->getRate().'<br />
								<input class="text full price-In h_transfer_price_kmplus fontLarge" style="width:60px; text-align:right; color:red;" transfer_id="'.$transfer_id.'" car_id="'.$val[$clsCar->pkey].'" type_of_trip_id="'.$clsProperty->getOneField('min_value',$b[$clsProperty->pkey]).'" seat_id="'.$v[$clsProperty->pkey].'" value="'.$clsTransferPrice->getPriceKmPlus($transfer_id,$val[$clsCar->pkey],$v[$clsProperty->pkey],$clsProperty->getOneField('min_value',$b[$clsProperty->pkey])).'" type="text" />
							</td>';	
						}
					}
				$html .= '</tr>';
			}
			$html .= '</table>';
		}else{
			$html .= '<div class="infobox"><b>'.$core->get_Lang('warning').'</b><br>'.$core->get_Lang('nodata').'</div>';
		}
		#
		echo($html);die();
	}
	else if($tp=='S'){
		$price = $_POST['price'];
		$res = $clsTransferPrice->getAll("transfer_id='$transfer_id' and car_id='$car_id' and type_of_trip_id='$type_of_trip_id'");
		if($res[0]['transfer_price_id'] != ''){
			$clsTransferPrice->updateOne($res[0]['transfer_price_id'],"price='".$clsISO->processFloatNumber($price)."'");
		}else{
			$f = "transfer_id,car_id,type_of_trip_id,price,user_id,user_id_update,reg_date,upd_date";
			$v = "'$transfer_id'
				,'$car_id'
				,'$type_of_trip_id'
				,'".$clsISO->processFloatNumber($price)."'
				,'$user_id'
				,'$user_id'
				,'".time()."'
				,'".time()."'
			";
			$clsTransferPrice->insertOne($f, $v);	
		}
		echo '0|||'.$clsISO->processFloatNumber($price); die();
	}
	else if($tp=='SPLUS'){
		$price_km_plus = $_POST['price_km_plus'];
		$res = $clsTransferPrice->getAll("transfer_id='$transfer_id' and car_id='$car_id' and type_of_trip_id='$type_of_trip_id'");
		if($res[0]['transfer_price_id'] != ''){
			$clsTransferPrice->updateOne($res[0]['transfer_price_id'],"price_km_plus='".$clsISO->processSmartNumber($price_km_plus)."'");
		}else{
			$f = "transfer_id,car_id,type_of_trip_id,price_km_plus,user_id,user_id_update,reg_date,upd_date";
			$v = "'$transfer_id'
				,'$car_id'
				,'$type_of_trip_id'
				,'".$clsISO->processSmartNumber($price_km_plus)."'
				,'$user_id'
				,'$user_id'
				,'".time()."'
				,'".time()."'
			";
			$clsTransferPrice->insertOne($f, $v);	
		}
		echo '0|||'.$clsISO->formatPrice($price_km_plus); die();
	}
}

function default_ajSaveStoreForTour(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsTourStore = new TourStore();
	$type = isset($_POST['type'])?$_POST['type']:'';
	$list_transfer_id = isset($_POST['list_transfer_id'])?$_POST['list_transfer_id']:'';
	$list_transfer_id = rtrim($list_transfer_id,'|');
	
	if($list_transfer_id !='' ){
		$tmp = explode('|',$list_transfer_id);
		if(!empty($tmp)){
			foreach($tmp as $i){
				if(!$clsTourStore->checkExist($i,$type)){
					#
					$max_id = $clsTourStore->getMaxID();
					$max_order = $clsTourStore->getMaxOrder();
					$f = "$clsTourStore->pkey,transfer_id,_type,order_no";
					$v = "'$max_id','$i','$type','$max_order'";
					$clsTourStore->insertOne($f,$v);
				}
			}
			echo '_SUCCESS'; die();
		}else{
			echo '_ERROR'; die();
		}
	}else{
		echo '_ERROR'; die();
	}
}
function default_ajDeleteTourStore(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsClassTable = new TourStore();
	$pvalTable = isset($_POST['tour_store_id'])?$_POST['tour_store_id']:0;
	$clsClassTable->deleteOne($pvalTable);
	echo(1); die();
}
function default_ajUpdPosSortTourStore(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTourStore = new TourStore();
	$type = $_POST['type'];
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key + 1);
		$clsTourStore->updateByCond("transfer_id='$val' and _type='$type'","order_no='".$key."'");
	}
}
function default_liststore() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
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
    $SiteHasCategoryGroup_Tours = $clsConfiguration->getValue('SiteHasCategoryGroup_Tours');
    $SiteHasGroup_Tours = $clsConfiguration->getValue("SiteHasGroup_Tours");
    $tour_group_id = 0;
    if ($SiteHasGroup_Tours) {
        $clsTourGroup = new TourGroup();
        $assign_list["clsTourGroup"] = $clsTourGroup;
        $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
    }
    $assign_list["tour_group_id"] = $tour_group_id;
    #
    $cat_id = 0;
    if ($clsConfiguration->getValue('SiteHasCat_Tours')) {
        $clsTourCat = new TourCategory();
        $assign_list["clsTourCat"] = $clsTourCat;
        $cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
    }
    $assign_list["cat_id"] = $cat_id;
    #
    $price_range_id = 0;
    if ($clsConfiguration->getValue('SiteHasPriceRange_Tours')) {
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
    $cond = "1=1 and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "tour WHERE is_trash=0 and is_online=1)";
    if (isset($type) && !empty($type)) {
        $cond .= " and _type = '$type'";
        $pUrl .= '&type=' . $core->encryptID($type);
    }
    if ($tour_group_id > 0) {
        $cond .= " and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "tour WHERE tour_group_id='$tour_group_id')";
        $pUrl .= '&tour_group_id=' . $tour_group_id;
    }
    if (intval($tour_type_id) > 0) {
        $cond .= " and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "tour WHERE tour_type_id='$tour_type_id')";
        $pUrl .= '&tour_type_id=' . $tour_type_id;
    }
    if (intval($cat_id) > 0) {
        $cond .= " and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "tour WHERE cat_id = '$cat_id' or list_cat_id like '%|$cat_id|%'')";
        $pUrl .= '&cat_id=' . $cat_id;
    }
    if (intval($departure_point_id) > 0) {
        $cond .= " and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "tour WHERE departure_point_id='$departure_point_id')";
        $pUrl .= '&departure_point_id=' . $departure_point_id;
    }
    if (isset($number_day) && intval($number_day) != 0) {
        $cond .= " and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "tour WHERE number_day='$number_day')";
        $pUrl .= '&number_day=' . $number_day;
    }
    if ($price_range_id != '' && $price_range_id != '0' && $price_range_id != 'All') {
        $onePriceRange = $clsPriceRange->getOne($price_range_id);
        $min_rate = $onePriceRange['min_rate'];
        $max_rate = $onePriceRange['max_rate'];
        #
        if ($min_rate == 0 && $max_rate > 0) {
            $cond .= " and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "tour WHERE trip_price < '$max_rate')";
        } elseif ($min_rate > 0 && $max_rate > 0) {
            $cond .= " and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "tour WHERE trip_price > '$min_rate' and trip_price < '$max_rate')";
        } else {
            $cond .= " and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "tour WHERE trip_price > '$min_rate')";
        }
        $pUrl .= '&price_range_id=' . $price_range_id;
    }
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "tour WHERE trip_code like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%' or title like '%" . $slug . "%')";
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

function default_ajUpdPosSortHotTour(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTourStore = new TourStore();
	$order = $_POST['order'];
	$type = $_POST['type'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		/*$key = (($currentPage-1)*$recordPerPage + $key + 1);*/
		$key = $key + 1;
		$clsTourStore->updateByCond("transfer_id='$val' and _type='$type'","order_no='".$key."'");
	}
}

/* ========= TOUR CATEGORY MOD MANAGE ============= */

function default_category() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO;
    $user_id = $core->_USER['user_id'];
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #
    if (!$clsConfiguration->getValue('SiteHasCat_Tours')) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
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
    $SiteHasCategoryGroup_Tours = $clsConfiguration->getValue('SiteHasCategoryGroup_Tours');
    $SiteHasGroup_Tours = $clsConfiguration->getValue("SiteHasGroup_Tours");
    $SiteHasSubCat_Tours = $clsConfiguration->getValue("SiteHasSubCat_Tours");
    #
    if ($SiteHasGroup_Tours && $SiteHasCategoryGroup_Tours) {
        $clsTourGroup = new TourGroup();
        $assign_list["clsTourGroup"] = $clsTourGroup;
        $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
        $assign_list["tour_group_id"] = $tour_group_id;
    }
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($SiteHasGroup_Tours && $SiteHasCategoryGroup_Tours && $_POST['tour_group_id'] != '') {
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
    if ($SiteHasGroup_Tours && $SiteHasCategoryGroup_Tours) {
        if ($tour_group_id > 0) {
            $cond .= " and tour_group_id='$tour_group_id'";
        }
        $pUrl .= '&tour_group_id=' . $tour_group_id;
    }
    #Filter By Keyword
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $cond .= " and slug like '%" . $core->replaceSpace($_GET['keyword']) . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;
    $orderBy = " order by order_no asc";

    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $totalRecord = $clsClassTable->countItem($cond);
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
        if ($SiteHasGroup_Tours && $SiteHasCategoryGroup_Tours) {
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
        if ($SiteHasGroup_Tours && $SiteHasCategoryGroup_Tours) {
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
        if ($SiteHasGroup_Tours && $SiteHasCategoryGroup_Tours) {
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
function default_ajUpdPosSortTourCategory(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTourCategory = new TourCategory();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key+1);
		$clsTourCategory->updateOne($val,"order_no='".$key."'");	
	}
}
function default_category_country() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
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
    $cond = "1='1'";
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

function default_edit_categorycountry() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
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

    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : 0;
    /*
      if($clsConfiguration->getValue('SiteModActive_country')) {
      if(isset($country_id) && intval($country_id)==0){
      header('location: '.PCMS_URL.'/?mod=country&message=notPermission');
      exit();
      }
      } */
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : 0;
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;
    #
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
            //print_r($field.'<br />'.$value); die();
			$listCategoryByCountry=$clsClassTable->getAll("1=1 and cat_id='".$_POST['cat_id']."' and country_id ='".$_POST['iso-country_id']."'");
			if($listCategoryByCountry!=''){
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act='.$act.'&message=insertFailed');
				return false;
			}else{
				$listTable=$clsClassTable->getAll("1=1", $clsClassTable->pkey.",order_no");
				for ($i = 0; $i <= count($listTable); $i++) {
					$order_no=$listTable[$i]['order_no'] + 1;
					$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey],"order_no='".$order_no."'");
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
				if ($clsClassTable->insertOne($field, $value)) {
					if ($_POST['button'] == '_EDIT') {
						header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_categorycountry&' . $clsClassTable->pkey . '=' . $core->encryptID($max_id) . '&message=insertSuccess');
					} else {
						header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=category_country' . '&message=insertSuccess');
					}
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act='.$act.'&message=insertFailed');
				}
			}
            
        }
    }
}
function default_ajUpdPosSortTravelStylebyCountry(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsCategoryCountry = new Category_Country();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key+1);
		$clsCategoryCountry->updateOne($val,"order_no='".$key."'");	
	}
}
function default_edit_category() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "TourCategory";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $assign_list["tour_group_id"] = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;

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
    $clsForm->addInputTextArea("", 'intro', "", 'intro', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 20, 1, "style='width:100%'");
    #
    if ($string != '' && $pvalTable == 0) {
        header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
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
            $set .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
            $set .= ",upd_date='" . time() . "'";
            $set .= ",slug='" . $core->replaceSpace($_POST['iso-title']) . "'";

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = $_POST['isoman_url_image'];
            }
            if ($image != '' && $image != '0') {
                $set .= ",image='" . addslashes($image) . "'";
            }
            #
            $pUrl = '';
            if ($clsConfiguration->getValue('SiteHasCat_News')) {
                $newscat_id = $_POST['iso-newscat_id'];
                $list_cat_id = $clsNewsCategory->getListParent($newscat_id);
                $set .= ",list_cat_id='" . addslashes($list_cat_id) . "'";
                $pUrl .= '&newscat_id=' . $newscat_id;
            }
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
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=updateSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateFailed');
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
            $news_id = $clsClassTable->getMaxId();
            $field .= ",user_id,user_id_update,reg_date,upd_date,slug,$clsClassTable->pkey,order_no";
            $value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
            $value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "','" . $news_id . "','" . $clsClassTable->getMaxOrderNo() . "'";

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = $_POST['isoman_url_image'];
            }
            if ($image != '' && $image != '0') {
                $field .= ',image';
                $value .= ",'" . addslashes($image) . "'";
            }
            #
            $pUrl = '';
            if ($clsConfiguration->getValue('SiteHasCat_News')) {
                $newscat_id = $_POST['iso-newscat_id'];
                $list_cat_id = $clsNewsCategory->getListParent($newscat_id);
                $field .= ',list_cat_id';
                $value .= ",'" . addslashes($list_cat_id) . "'";
                $pUrl .= '&newscat_id=' . $newscat_id;
            }
            #
            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&news_id=' . $core->encryptID($max_id) . '&message=insertSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
            }
        }
    }
}

function default_SiteTourCategory() {
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    if (!$clsConfiguration->getValue('SiteHasCat_Tours')) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    if ($clsConfiguration->getValue('SiteHasCategoryGroup_Tours') && $clsConfiguration->getValue("SiteHasGroup_Tours")) {
        $clsTourGroup = new TourGroup();
        $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
    }
    $clsTourCategory = new TourCategory();
    $tourcat_id = isset($_POST['tourcat_id']) ? intval($_POST['tourcat_id']) : '';
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
						<div class="fieldlabel" style="text-align:right"><strong>'.$core->get_Lang('title').'</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<input style="border:2px solid #ccc; padding:6px 10px;" autocomplete="off" class="text_32 full-width border_aaa bold required fontLarge title_capitalize" name="title" value="' . $clsTourCategory->getTitle($tourcat_id) . '" type="text" />
						</div>
					</div>
					' . ($clsConfiguration->getValue('SiteHasSubCat_Tours') ? '
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><b class="color_r">* ' . $core->get_Lang('selectcategory') . '</b></div>
						<div class="fieldarea">
							<select class="slb" name="parent_ID" id="slb_TourCategory">
								' . $clsTourCategory->makeSelectboxOption($tour_group_id) . '
							</select>
						</div>
					</div>
					' : '') . '
					' . (($clsConfiguration->getValue('SiteHasCategoryGroup_Tours') && $clsConfiguration->getValue("SiteHasGroup_Tours")) ? '
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><b class="color_r">* ' . $core->get_Lang('selectgroup') . '</b></div>
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
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Image').'</strong></div>
						<div class="fieldarea">
							<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsTourCategory->getOneField('image', $tourcat_id) . '" />
							<input type="hidden" id="isoman_hidden_image" value="' . $clsTourCategory->getOneField('image', $tourcat_id) . '">
							<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsTourCategory->getOneField('image', $tourcat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsTourCategory->getOneField('image', $tourcat_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>'.$core->get_Lang('Icon Home').'</strong></div>
						<div class="fieldarea">
							<img class="isoman_img_pop" id="isoman_show_image_icon" src="' . $clsTourCategory->getOneField('image_icon', $tourcat_id) . '" />
							<input type="hidden" id="isoman_hidden_image_icon" value="' . $clsTourCategory->getOneField('image_icon', $tourcat_id) . '">
							<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image_icon" name="image_icon" value="' . $clsTourCategory->getOneField('image_icon', $tourcat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_icon" isoman_val="' . $clsTourCategory->getOneField('image_icon', $tourcat_id) . '" isoman_name="image_icon"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>'.$core->get_Lang('Icon').'</strong></div>
						<div class="fieldarea">
							<img class="isoman_img_pop" id="isoman_show_image_icon2" src="' . $clsTourCategory->getOneField('image_icon2', $tourcat_id) . '" />
							<input type="hidden" id="isoman_hidden_image_icon2" value="' . $clsTourCategory->getOneField('image_icon2', $tourcat_id) . '">
							<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image_icon2" name="image_icon2" value="' . $clsTourCategory->getOneField('image_icon2', $tourcat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_icon2" isoman_val="' . $clsTourCategory->getOneField('image_icon2', $tourcat_id) . '" isoman_name="image_icon2"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>'.$core->get_Lang('Banner').' <span class="small">(WxH=1920x480)</span></strong></div>
						<div class="fieldarea">
							<img class="isoman_img_pop" id="isoman_show_image_banner" src="' . $clsTourCategory->getOneField('image_banner', $tourcat_id) . '" />
							<input type="hidden" id="isoman_hidden_image_banner" value="' . $clsTourCategory->getOneField('image_banner', $tourcat_id) . '">
							<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image_banner" name="image_banner" value="' . $clsTourCategory->getOneField('image_banner', $tourcat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_banner" isoman_val="' . $clsTourCategory->getOneField('image_banner', $tourcat_id) . '" isoman_name="image_banner"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
						</div>
					</div>
					<div class="row-span">
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
        $imageBannerPost = isset($_POST['image_banner']) ? $_POST['image_banner'] : '';
        $imageIconPost = isset($_POST['image_icon']) ? $_POST['image_icon'] : '';
		$imageIconPost2 = isset($_POST['image_icon2']) ? $_POST['image_icon2'] : '';
        #
        if ($tourcat_id == 0) {
            $all = $clsTourCategory->getAll("is_trash=0 and slug like '%" . $slugPost . "' limit 0,1");
            if (!empty($all)) {
                echo '_EXIST';
                die();
            } else {
				$listTable=$clsTourCategory->getAll("1=1", $clsTourCategory->pkey.",order_no");
				for ($i = 0; $i <= count($listTable); $i++) {
					$order_no=$listTable[$i]['order_no'] + 1;
					$clsTourCategory->updateOne($listTable[$i][$clsTourCategory->pkey],"order_no='".$order_no."'");
				}
                $fx = "user_id,user_id_update,parent_id,title,slug,intro,intro_banner,order_no,reg_date,upd_date,image,image_banner,image_icon,image_icon2";
                $vx = "'$user_id','$user_id','$parent_id','$titlePost','$slugPost','" . addslashes($introPost) . "','" . addslashes($introBannerPost) . "'";
                $vx .= ",'1','" . time() . "','" . time() . "','" . addslashes($imagePost) . "','" . addslashes($imageBannerPost) . "','". addslashes($imageIconPost) ."','". addslashes($imageIconPost2) ."'";
                if ($clsConfiguration->getValue('SiteHasCategoryGroup_Tours') && $clsConfiguration->getValue("SiteHasGroup_Tours")) {
                    $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
                    $fx .= ",tour_group_id";
                    $vx .= ",'$tour_group_id'";
                }
                #
				//echo $vx; die('xxx');
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
            if ($clsConfiguration->getValue('SiteHasCategoryGroup_Tours') && $clsConfiguration->getValue("SiteHasGroup_Tours")) {
                $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
                $v .= ",tour_group_id='$tour_group_id'";
            }
            $v .= ",image = '" . addslashes($imagePost) . "'";
            $v .= ",image_banner = '" . addslashes($imageBannerPost) . "'";
            $v .= ",image_icon = '" . addslashes($imageIconPost) . "'"; 
			$v .= ",image_icon2 = '" . addslashes($imageIconPost2) . "'"; 
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

function default_ajaxSiteTourCategory() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsConfiguration->getValue('SiteHasCat_Tours')) {
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

/* ========= SITE DEPARTURE POINT TOUR ============= */

function default_ajaxSiteDeparturePoint() {
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

function default_group() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO, $clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsConfiguration->getValue('SiteHasGroup_Tours')) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
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
    $totalRecord = $clsClassTable->countItem($cond);
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
    $assign_list["number_all"] = $clsClassTable->countItem($cond2);
    $assign_list["number_trash"] = $clsClassTable->countItem($cond2 . " and is_trash=1");

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

function default_ajaxFrmTourGroup() {
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

function default_ajSubmitTourGroup() {
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
    #
    if ($tour_group_id == 0) {
        $all = $clsClassTable->getAll("is_trash=0 and slug='$slugPost' limit 0,1");
        if (!empty($all)) {
            echo '_EXIST';
            die();
        } else {
            $fx = "user_id,user_id_update,parent_id,title,slug,intro,order_no,reg_date,upd_date,image";
            $vx = "'$user_id','$user_id','$parent_id','$titlePost','$slugPost','" . addslashes($introPost) . "'";
            $vx .= ",'" . $clsClassTable->getMaxOrderNo() . "','" . time() . "','" . time() . "','" . addslashes($imagePost) . "'";
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
        $vx .= ",upd_date='" . time() . "',user_id_update='$user_id',image='" . addslashes($imagePost) . "'";
        if ($clsClassTable->updateOne($tour_group_id, $vx)) {
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}

function default_setting() {
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
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

function default_property() {
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $type = isset($_GET['type']) ? $_GET['type'] : '';

    $assign_list["type"] = $type;

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
    $assign_list["number_trash"] = $clsClassTable->countItem("is_trash=1 and " . $cond2);
    $assign_list["number_item"] = $clsClassTable->countItem("is_trash=0 and " . $cond2);
    $assign_list["number_all"] = $clsClassTable->countItem($cond2);
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
}
function default_ajUpdPosSortTourProperty(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTourProperty = new TourProperty();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key+1);
		$clsTourProperty->updateOne($val,"order_no='".$key."'");	
	}
}
/* ============== TOUR TRANSPORT MANAGEMENT ================ */

function default_transporttours() {
    global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsConfiguration->getValue('SiteHasTransport_Tours')) {
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

function default_ajaxFrmTransportour() {
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

function default_ajaxSaveTransportour() {
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

function default_ajInitTSysTransferGallery() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    #
    $clsTransferImage = new TransferImage();
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
					<td class="gridheader"><strong>' . $core->get_Lang('index') . '</strong></td>
					<td class="gridheader"><strong>' . $core->get_Lang('images') . '</strong></td>
					<td class="gridheader text-left"><strong>' . $core->get_Lang('alttext') . '</strong></td>
					<td class="gridheader" style="width:12%"><strong>' . $core->get_Lang('update') . '</strong></td>
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
						url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
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
					url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
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
					url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
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
					url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
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
			var $clsTable = \'TransferImage\';
			var $type= \'TransferImage\';
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
				url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
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

function default_ajOpenTransferGallery() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn;
    #
    $clsPagination = new Pagination();
    $clsTransferImage = new TransferImage();
    $pkeyTable = $clsTransferImage->pkey;

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
        $totalRecord = $clsTransferImage->countItem($cond);
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no asc";
        $limit = " LIMIT $offset,$number_per_page";

        $lstItem = $clsTransferImage->getAll($cond . $order_by . $limit);
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $tour_image_id = $lstItem[$i][$clsTransferImage->pkey];
                #
                $html .= '<tr style="cursor:move" id="order_'.$tour_image_id.'" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index">' . ($offset +$i + 1) . '</td>';
                $html .= '<td width="100px"><a href="javascript:void();" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><img src="' . $ftp_abs_path_image . $lstItem[$i]['image'] . '" width="90" height="60" /></a></td>';
                $html .= '<td>
				
				<input class="editTitleImage" data="' . $tour_image_id . '" table_id="' . $table_id . '" value="'.$clsTransferImage->getTitle($tour_image_id).'" style="line-height:28px; font-size:12px; padding:0 10px" />
				<a style="display:none" href="javascript:void(0);" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><strong>' . $clsTransferImage->getTitle($tour_image_id) . '</strong></a>
				
				</td>';
                $html .= '<td style="text-align:right;color:#c00000">' . date('d-m-Y h:i', $lstItem[$i]['reg_date']) . '</td>';
				if(1==2){
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
			$html.='
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
						var page = "'.$page.'";
						var order = $(this).sortable("serialize")+\'&update=update\'+\'&recordPerPage='.$number_per_page.'\'+\'&currentPage='.$page.'\';
						$.post(path_ajax_script+"/index.php?mod=transfer&act=ajUpdPosTourGallery", order, function(html){
							loadTableGallery(transfer_id, \'\', page, 10);
							vietiso_loading(0);
						});
					}
				});
				
				$(".editTitleImage").live("change", function() {
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script + "/?mod=" + mod + "&act=ajOpenTransferGallery",
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
        $clsTransferImage->deleteOne($tour_image_id);
        echo (1);
        die();
    }
    // Quick Create
    else if ($tp == 'Q') {
        $fx = "table_id,order_no,reg_date";
        $vx = "'$table_id','" . $clsTransferImage->getMaxOrderNo($table_id) . "','" . time() . "'";
        $clsTransferImage->insertOne($fx, $vx);
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
					<input type="text" name="title" class="text full required" style="width:100%" value="' . $clsTransferImage->getTitle($tour_image_id) . '">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						<img src="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" id="isoman_show_image_val" />
						<input type="hidden" id="isoman_hidden_image_val" name="isoman_url_image" value="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image_val" isoman_val="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" isoman_name="image">
							<i class="iso-edit"></i>
						</a>';
						if($clsTransferImage->getOneField('image', $tour_image_id)!=''){
						  $HTML .= '<a pvalTable="'.$tour_image_id.'" clsTable="TransferImage" href="javascript:void()" title="'.$core->get_Lang('delete').'" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a> ';
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
						url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
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
            if ($clsTransferImage->updateOne($tour_image_id, $set)) {
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
        $one = $clsTransferImage->getOne($tour_image_id);
        $table_id = $one['table_id'];
        $order_no = $one['order_no'];
        #
        $where = "table_id='$table_id'";
        if ($direct == 'moveup') {
            $lst = $clsTransferImage->getAll($where . " and order_no>$order_no order by order_no asc limit 0,1");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTransferImage->updateOne($lst[0][$clsTransferImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsTransferImage->getAll($where . " and order_no<$order_no order by order_no desc limit 0,1");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTransferImage->updateOne($lst[0][$clsTransferImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsTransferImage->getAll($where . " and order_no>$order_no order by order_no asc");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTransferImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no>$order_no order by order_no asc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTransferImage->updateOne($lst[$i][$clsTransferImage->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
                }
                unset($lst);
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsTransferImage->getAll($where . " and type='$type' and order_no<$order_no order by order_no desc");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTransferImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no<$order_no order by order_no desc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTransferImage->updateOne($lst[$i][$clsTransferImage->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
                }
                unset($lst);
            }
        }
        echo (1);
        die();
    } else if ($tp == 'TOTAL') {
        echo $clsTransferImage->countItem("is_trash=0 and table_id='$table_id'");
        die();
    } else if ($tp == 'SYS') {
        $LISTALL = $clsTransferImage->getAll("is_trash=0 and table_id='$table_id' order by tour_image_id asc");
        if (!empty($LISTALL)) {
            for ($i = 0; $i < count($LISTALL); $i++) {
                $clsTransferImage->updateOne($LISTALL[$i][$clsTransferImage->pkey], "order_no='" . ($i + 1) . "'");
            }
            unset($LISTALL);
        }
        echo (1);
        die();
    }
    echo (1);
    die();
}


function default_ajOpenTransferGalleryNew() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn;
    #
    $clsPagination = new Pagination();
    $clsTransferImage = new TransferImage();
    $pkeyTable = $clsTransferImage->pkey;

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
        $totalRecord = $clsTransferImage->countItem($cond);
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no asc";
        $limit = " LIMIT $offset,$number_per_page";

        $lstItem = $clsTransferImage->getAll($cond . $order_by . $limit);
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $tour_image_id = $lstItem[$i][$clsTransferImage->pkey];
                #
                $html .= '<tr style="cursor:move" id="order_'.$tour_image_id.'" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index">' . ($offset+$i+1) . '</td>';
                $html .= '<td width="60px"><img src="' . $ftp_abs_path_image . $lstItem[$i]['image'] . '" width="60" height="40" /></td>';
                $html .= '<td><a href="javascript:void();" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><strong>' . $clsTransferImage->getTitle($tour_image_id) . '</strong></a></td>';
                $html .= '<td style="text-align:right;color:#c00000">' . date('d-m-Y h:i', $lstItem[$i]['reg_date']) . '</td>';
				if(1==2){
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
			$html.='
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
						var page = "'.$page.'";
						var order = $(this).sortable("serialize")+\'&update=update\'+\'&recordPerPage='.$number_per_page.'\'+\'&currentPage='.$page.'\';
						$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosTourGallery", order, function(html){
							loadTableGallery(transfer_id, \'\', page, 10);
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
        $clsTransferImage->deleteOne($tour_image_id);
        echo (1);
        die();
    }
    // Quick Create
    else if ($tp == 'Q') {
        $fx = "table_id,order_no,reg_date";
        $vx = "'$table_id','" . $clsTransferImage->getMaxOrderNo($table_id) . "','" . time() . "'";
        $clsTransferImage->insertOne($fx, $vx);
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
					<input type="text" name="title" class="text full required" style="width:96%" value="' . $clsTransferImage->getTitle($tour_image_id) . '">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						<img src="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" id="isoman_show_image_val" />
						<input type="hidden" id="isoman_hidden_image_val" name="isoman_url_image" value="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image_val" isoman_val="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" isoman_name="image">
							<i class="iso-edit"></i>
						</a>';
						if($clsTransferImage->getOneField('image', $tour_image_id)!=''){
						  $HTML .= '<a pvalTable="'.$tour_image_id.'" clsTable="TransferImage" href="javascript:void()" title="'.$core->get_Lang('delete').'" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a> ';
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
						url: path_ajax_script+"/index.php?mod=tour&act=ajOpenTransferGallery",
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
            if ($clsTransferImage->updateOne($tour_image_id, $set)) {
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
        $one = $clsTransferImage->getOne($tour_image_id);
        $table_id = $one['table_id'];
        $order_no = $one['order_no'];
        #
        $where = "table_id='$table_id'";
        if ($direct == 'moveup') {
            $lst = $clsTransferImage->getAll($where . " and order_no>$order_no order by order_no asc limit 0,1");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTransferImage->updateOne($lst[0][$clsTransferImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsTransferImage->getAll($where . " and order_no<$order_no order by order_no desc limit 0,1");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTransferImage->updateOne($lst[0][$clsTransferImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsTransferImage->getAll($where . " and order_no>$order_no order by order_no asc");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTransferImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no>$order_no order by order_no asc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTransferImage->updateOne($lst[$i][$clsTransferImage->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
                }
                unset($lst);
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsTransferImage->getAll($where . " and type='$type' and order_no<$order_no order by order_no desc");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTransferImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no<$order_no order by order_no desc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTransferImage->updateOne($lst[$i][$clsTransferImage->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
                }
                unset($lst);
            }
        }
        echo (1);
        die();
    } else if ($tp == 'TOTAL') {
        echo $clsTransferImage->countItem("is_trash=0 and table_id='$table_id'");
        die();
    } else if ($tp == 'SYS') {
        $LISTALL = $clsTransferImage->getAll("is_trash=0 and table_id='$table_id' order by tour_image_id asc");
        if (!empty($LISTALL)) {
            for ($i = 0; $i < count($LISTALL); $i++) {
                $clsTransferImage->updateOne($LISTALL[$i][$clsTransferImage->pkey], "order_no='" . ($i + 1) . "'");
            }
            unset($LISTALL);
        }
        echo (1);
        die();
    }
    echo (1);
    die();
}

function default_ajUpdPosTourGallery(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTransferImage = new TransferImage();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key + 1);
		$clsTransferImage->updateOne($val,"order_no='".$key."'");	
	}
}



function default_ajLoadRegion(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsRegion = new Region();
	#
	$country_id = isset($_POST['country_id'])?intval($_POST['country_id']):0;
	$region_id = isset($_POST['region_id'])?intval($_POST['region_id']):0;
	#
	$cond = "is_trash=0 and is_online=1";
	if($country_id > 0) {$cond.= " and country_id = '$country_id'";}
	if($clsRegion->countItem($cond) > 0) {
		$html = $clsRegion->makeSelectboxOption($country_id,$region_id);
	} else {
		$html = 'EMPTY';
	}
	echo $html; die();
}
function default_ajmakeSelectCityGlobal(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsCity = new City();
	$country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
	$region_id = isset($_POST['region_id']) ? intval($_POST['region_id']) : 0;
	$city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;
	#
	$cond = "is_trash=0 and is_online=1";
	if($country_id > 0){$cond .= " and country_id='$country_id'";}
	if($region_id > 0){$cond .= " and region_id='$region_id'";}
	#
	$html = '<option value="0">'.$core->get_Lang('selectcity').'</option>';
	if($clsCity->countItem($cond) > 0) {
		$lstCity = $clsCity->getAll($cond." order by slug asc", $clsCity->pkey);
		
		if(!empty($lstCity)){
			foreach($lstCity as $k => $v){
				$html .= '<option value="'.$v[$clsCity->pkey].'" '.($city_id==$v[$clsCity->pkey]?'selected="selected"':'').'>'.$clsCity->getTitle($v[$clsCity->pkey]).'</option>';
			}
			unset($lstCity);
	
		}
	} else {
		$html = 'EMPTY';
	}
	echo $html; die();
}

?>