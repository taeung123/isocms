<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration, $clsISO;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	$assign_list["status"] = $status;
	$rates = isset($_GET['rates']) ? $_GET['rates'] : '';
	$assign_list["rates"] = $rates;

	/*if($type == ""){
		header("Location: ".PCMS_URL.'/?mod='.$mod."&act=reviewAll");
	}*/
	#
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		if ($type != '') {
			$link .= '&type=' . $type;
		}
		if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		if (isset($_POST['rates']) && !empty($_POST['rates'])) {
			$link .= '&rates=' . $_POST['rates'];
		}
		if (isset($_POST['status']) && !empty($_POST['status'])) {
			$link .= '&status=' . $_POST['status'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	$clsProfile = new Profile();
	$assign_list["clsProfile"] = $clsProfile;
	/**/
	$classTable = "Reviews";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	/*List all item*/
	$cond = "1=1";
	//	if (_ISOCMS_CLIENT_LOGIN == 1) {
	//		if (in_array($package_id, array(4))) {
	//			$cond .= " and profile_id > 0 ";
	//		} else {
	//			$cond .= " and profile_id = 0 ";
	//		}
	//	} else {
	//		$cond .= " and profile_id = 0 ";
	//	}

	#Filter By Keyword
	if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (slug like '%" . $keyword . "%' or fullname like '%" . $_GET['keyword'] . "%' or email like '%" . $_GET['keyword'] . "%')";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	if ($type != '') {
		$cond .= " and type = '" . $_GET['type'] . "'";
		$pUrl .= '&type=' . $type;
	}
	if (isset($_GET['rates']) && !empty($_GET['rates'])) {
		$cond .= " and rates = '" . $_GET['rates'] . "'";
		$pUrl .= '&rates=' . $rates;
	}
	if ($status != '') {
		if ($status == 'public') {
			$cond .= " and is_online = '1'";
		} elseif ($status == 'private') {
			$cond .= " and is_online = '0'";
		}
		$pUrl .= '&status=' . $status;
	}
	$assign_list["pUrl"] = $pUrl;

	// data month
	$month_now = strtotime("m");
	$time_start = strtotime(date("1/1/Y"));
	$number = ceil(($month_now - $time_start) / 86400) + 1;
	$dataMonth = [];
	for ($i = 0; $i < 12; $i++) {
		if ($i < date("m")) {
			$start_time = strtotime(date(($i + 1) . "/1/Y 00:00"));
			if ($i == 11) {
				$end_time = strtotime(date("12/31/Y 23:59"));
			} else {
				$end_time = strtotime(date(($i + 2) . "/1/Y 23:59")) - 86400;
			}
			$dataMonth[] = [
				"y"		=>	default_getRevenueReviews($type, $start_time, $end_time),
				"name"	=>	"T" . ($i + 1),
			];
		} else {
			$dataMonth[] = [
				"y"		=>	0,
				"name"	=>	"T" . ($i + 1),
			];
		}
	}
	//	var_dump($dataMonth);die;
	$assign_list['dataMonth'] = json_encode($dataMonth);
	// data tour,voucher
	$condReview = "";
	if (_ISOCMS_CLIENT_LOGIN == 1) {
		if (in_array($package_id, array(4))) {
			$condReview .= " and profile_id > 0 ";
		} else {
			$condReview .= " and profile_id = 0 ";
		}
	} else {
		$condReview .= " and profile_id = 0 ";
	}
	$countReview = $clsClassTable->getAll("type='" . $type . "'" . $condReview, "COUNT(reviews_id) as total,avg(rates) as avg");
	$totalReview = $countReview[0]['total'];
	$assign_list['totalReview'] = $totalReview;
	$totalReviewAvg = $countReview[0]['avg'];
	$assign_list['totalReviewAvg'] = round($totalReviewAvg, 1);

	$allReviewPublic = $clsClassTable->getAll("type='" . $type . "' AND is_online='1'" . $condReview, "COUNT(reviews_id) as total");
	$allReviewPrivate = $clsClassTable->getAll("type='" . $type . "' AND is_online='0'" . $condReview, "COUNT(reviews_id) as total");
	$totalReviewPublic = $allReviewPublic[0]['total'];
	$assign_list['totalReviewPublic'] = $totalReviewPublic;
	$totalReviewPrivate = $allReviewPrivate[0]['total'];
	$assign_list['totalReviewPrivate'] = $totalReviewPrivate;
	$dataStatus = [
		[
			"y"			=>	(int)$allReviewPublic[0]['total'],
			"color"		=>	"#068A2B",
			"name"		=>	$core->get_Lang("Public")
		],
		[
			"y"			=>	(int)$allReviewPrivate[0]['total'],
			"color"		=>	"#F58321",
			"name"		=>	$core->get_Lang("Private")
		]
	];
	$assign_list['dataStatus'] = json_encode($dataStatus);

	if ($type == 'tour' || $type == 'voucher' || $type == 'hotel' || $type == 'cruise') {
		$data = [];
		for ($i = 1; $i <= 5; $i++) {
			$data[] = [
				"y"		=>	default_getRevenueReviews($type, 0, 0, $i),
				"name"	=>	$i . " " . $core->get_Lang('star'),
			];
		}
		if ($type == 'tour') {
			$assign_list['dataTour'] = json_encode($data);
		} else if ($type == 'voucher') {
			$assign_list['dataVoucher'] = json_encode($data);
		} else if ($type == 'hotel') {
			$assign_list['dataHotel'] = json_encode($data);
		} else if ($type == 'cruise') {
			$assign_list['dataCruise'] = json_encode($data);
		}
	}

	$cond2 = $cond;
	if ($type_list == 'Active') {
		$cond .= " and is_trash=0";
	} elseif ($type_list == 'Trash') {
		$cond .= " and is_trash=1";
	}
	$orderBy = " order_no desc";
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
	$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
	$start_limit = ($currentPage - 1) * $recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	//	$clsClassTable->setDeBug(1);
	$lstAllItem = $clsClassTable->getAll($cond);
	//	var_dump($lstAllItem);die;
	$totalRecord = (is_array($lstAllItem) && count($lstAllItem) > 0) ? count($lstAllItem) : 0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;

	$stt = ($currentPage - 1) * $recordPerPage;
	$assign_list['stt'] = $stt;

	$listPageNumber =  array();
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
	//	echo $link_page_current;die;
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
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit, $clsClassTable->pkey . ", reg_date,upd_date,rates,type, table_id,is_trash, is_online");
	//print_r($cond." order by ".$orderBy.$limit);die();
	$assign_list["allItem"] = $allItem;

	#
	$allTrash =  $clsClassTable->getAll("is_trash=1 and " . $cond2);
	$assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
	#
	$allUnTrash =  $clsClassTable->getAll("is_trash=0 and " . $cond2);
	$assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
	#
	$allAll =  $clsClassTable->getAll($cond2);
	$assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
}
function default_getRevenueReviews($type, $start_time = 0, $end_time = 0, $star = 0)
{
	global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsConfiguration, $oneSetting, $package_id;
	$clsReviews = new Reviews();
	$condReview = "";
	if (_ISOCMS_CLIENT_LOGIN == 1) {
		if (in_array($package_id, array(4))) {
			$condReview .= " and profile_id > 0 ";
		} else {
			$condReview .= " and profile_id = 0 ";
		}
	} else {
		$condReview .= " and profile_id = 0 ";
	}
	if ($start_time == 0 && $end_time == 0) {
		$list_reviews = $clsReviews->getAll("type='" . $type . "' and rates='" . $star . "' " . $condReview, "COUNT(" . $clsReviews->pkey . ") as total");
	} else {
		$list_reviews = $clsReviews->getAll("type='" . $type . "' " . $condReview . " AND reg_date BETWEEN $start_time AND $end_time", "COUNT(" . $clsReviews->pkey . ") as total");
	}
	return (int)$list_reviews[0]['total'];
}
function default_reviewAll()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;

	#
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		if (isset($_POST['type']) && !empty($_POST['type'])) {
			$link .= '&type=' . $_POST['type'];
		}
		if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	$clsProfile = new Profile();
	$assign_list["clsProfile"] = $clsProfile;
	/**/
	$classTable = "Reviews";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	/*List all item*/
	$cond = "1=1";
	$condReview = "";
	//	if (_ISOCMS_CLIENT_LOGIN == 1) {
	//		if (in_array($package_id, array(4))) {
	//			$cond .= " and profile_id > 0 ";
	//			$condReview .= " and profile_id > 0 ";
	//		} else {
	//			$cond .= " and profile_id = 0 ";
	//			$condReview .= " and profile_id = 0 ";
	//		}
	//	} else {
	//		$cond .= " and profile_id = 0 ";
	//		$condReview .= " and profile_id = 0 ";
	//	}


	#Filter By Keyword
	if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (slug like '%" . $keyword . "%' or fullname like '%" . $_GET['keyword'] . "%' or email like '%" . $_GET['keyword'] . "%')";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	if (isset($_GET['type']) && !empty($_GET['type'])) {
		//		$cond .= " and type = '".$_GET['type']."'";
		$pUrl .= '&type=' . $type;
	}
	$assign_list["pUrl"] = $pUrl;

	$dataTour = $dataVoucher = $dataCruise = $dataHotel = [];
	//data tour
	for ($i = 1; $i <= 5; $i++) {
		$dataTour[] = [
			"y"		=>	default_getRevenueReviews('tour', 0, 0, $i),
			"name"	=>	$i . " " . $core->get_Lang('star'),
		];
	}
	$assign_list['dataTour'] = json_encode($dataTour);
	$countReviewTour = $clsClassTable->getAll("type='tour'" . $condReview, "COUNT(reviews_id) as total,avg(rates) as avg");
	$totalReviewTour = $countReviewTour[0]['total'];
	$assign_list['totalReviewTour'] = $totalReviewTour;
	$totalReviewAvgTour = $countReviewTour[0]['avg'];
	$assign_list['totalReviewAvgTour'] = round($totalReviewAvgTour, 1);

	//data voucher
	for ($i = 1; $i <= 5; $i++) {
		$dataVoucher[] = [
			"y"		=>	default_getRevenueReviews('voucher', 0, 0, $i),
			"name"	=>	$i . " " . $core->get_Lang('star'),
		];
	}
	$assign_list['dataVoucher'] = json_encode($dataVoucher);
	$countReviewVoucher = $clsClassTable->getAll("type='voucher'" . $condReview, "COUNT(reviews_id) as total,avg(rates) as avg");
	$totalReviewVoucher = $countReviewVoucher[0]['total'];
	$assign_list['totalReviewVoucher'] = $totalReviewVoucher;
	$totalReviewAvgVoucher = $countReviewVoucher[0]['avg'];
	$assign_list['totalReviewAvgVoucher'] = round($totalReviewAvgVoucher, 1);

	//data cruise
	for ($i = 1; $i <= 5; $i++) {
		$dataCruise[] = [
			"y"		=>	default_getRevenueReviews('cruise', 0, 0, $i),
			"name"	=>	$i . " " . $core->get_Lang('star'),
		];
	}
	$assign_list['dataCruise'] = json_encode($dataCruise);
	$countReviewCruise = $clsClassTable->getAll("type='cruise'" . $condReview, "COUNT(reviews_id) as total,avg(rates) as avg");
	$totalReviewCruise = $countReviewCruise[0]['total'];
	$assign_list['totalReviewCruise'] = $totalReviewCruise;
	$totalReviewAvgCruise = $countReviewCruise[0]['avg'];
	$assign_list['totalReviewAvgCruise'] = round($totalReviewAvgCruise, 1);

	//data hotel
	for ($i = 1; $i <= 5; $i++) {
		$dataHotel[] = [
			"y"		=>	default_getRevenueReviews('hotel', 0, 0, $i),
			"name"	=>	$i . " " . $core->get_Lang('star'),
		];
	}
	$assign_list['dataHotel'] = json_encode($dataHotel);
	$countReviewHotel = $clsClassTable->getAll("type='hotel'" . $condReview, "COUNT(reviews_id) as total,avg(rates) as avg");
	$totalReviewHotel = $countReviewHotel[0]['total'];
	$assign_list['totalReviewHotel'] = $totalReviewHotel;
	$totalReviewAvgHotel = $countReviewHotel[0]['avg'];
	$assign_list['totalReviewAvgHotel'] = round($totalReviewAvgHotel, 1);

	$countReview = $clsClassTable->getAll("type IN ('tour','cruise','hotel','voucher') " . $condReview, "COUNT(reviews_id) as total,avg(rates) as avg");
	$totalReview = $countReview[0]['total'];
	$assign_list['totalReview'] = $totalReview;

	$dataAll = [
		[
			"y"		=>	(int)$totalReviewTour,
			"color"	=> "#0D66E0",
			"name"	=> $core->get_Lang('Tour')
		],
		[
			"y"		=>	(int)$totalReviewCruise,
			"color"	=>	"#8B5DE8",
			"name"	=>	$core->get_Lang('Cruise')
		],
		[
			"y"		=> 	(int)$totalReviewHotel,
			"color"	=>	"#EAAC1F",
			"name"	=> 	$core->get_Lang('Hotel')
		],
		[
			"y"		=> 	(int)$totalReviewVoucher,
			"color"	=>	"#DF56CF",
			"name"	=> 	$core->get_Lang('Voucher')
		]
	];
	$assign_list['dataAll'] = json_encode($dataAll);

	$cond2 = $cond;
	if ($type_list == 'Active') {
		$cond .= " and is_trash=0";
	} elseif ($type_list == 'Trash') {
		$cond .= " and is_trash=1";
	}
	$orderBy = " order_no desc";
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage = 10;
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

	$listPageNumber =  array();
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
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit, $clsClassTable->pkey . ",profile_id, reg_date,upd_date,rates,type, table_id,is_trash, is_online"); //print_r($cond." order by ".$orderBy.$limit);die();
	$assign_list["allItem"] = $allItem;

	$allItemTour = $clsClassTable->getAll($cond . " AND type='tour'" . " order by " . $orderBy . $limit, $clsClassTable->pkey . ",profile_id, reg_date,upd_date,rates,type, table_id,is_trash, is_online");
	$allItemCruise = $clsClassTable->getAll($cond . " AND type='cruise'" . " order by " . $orderBy . $limit, $clsClassTable->pkey . ",profile_id, reg_date,upd_date,rates,type, table_id,is_trash, is_online");
	$allItemHotel = $clsClassTable->getAll($cond . " AND type='hotel'" . " order by " . $orderBy . $limit, $clsClassTable->pkey . ",profile_id, reg_date,upd_date,rates,type, table_id,is_trash, is_online");
	$allItemVoucher = $clsClassTable->getAll($cond . " AND type='voucher'" . " order by " . $orderBy . $limit, $clsClassTable->pkey . ",profile_id, reg_date,upd_date,rates,type, table_id,is_trash, is_online");
	$assign_list['allItemTour'] = $allItemTour;
	$assign_list['allItemCruise'] = $allItemCruise;
	$assign_list['allItemHotel'] = $allItemHotel;
	$assign_list['allItemVoucher'] = $allItemVoucher;

	#
	$allTrash =  $clsClassTable->getAll("is_trash=1 and " . $cond2);
	$assign_list["number_trash"] = count($allTrash) ?? 0;
	#
	$allUnTrash =  $clsClassTable->getAll("is_trash=0 and " . $cond2);
	$assign_list["number_item"] = count($allUnTrash) ?? 0;
	#
	$allAll =  $clsClassTable->getAll($cond2);
	$assign_list["number_all"] = count($allAll) ?? 0;
}
function default_loadChartReview()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	$type = Input::post("type", "all");
	var_dump("sdfsdf");
	die;
	echo $type;
	die;
}
function default_ajUpdPosSortReviews()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsReviews = new Reviews();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	$list_order = [];
	foreach ($order as $key => $val) {
		$tour = $clsReviews->getOne($val, 'order_no');
		$list_order[] = $tour['order_no'];
	}

	rsort($list_order);

	foreach ($order as $key => $val) {
		$clsReviews->updateOne($val, 'order_no=' . $list_order[$key]);
	}
}
function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;
	$assign_list["listCountry"] = $clsCountry->getAll("is_trash=0 order by order_no asc");
	#
	$clsProfile = new Profile();
	$assign_list["clsProfile"] = $clsProfile;

	$classTable = "Reviews";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("", 'content', "", $core->get_Lang('content'), 255, 25, 25, 1,  "style='width:100%;height:125px'");
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

			if (isset($_POST['review_date'])) {
				$review_date = strtotime($_POST['review_date']);
			}
			$set .= ",content='" . nl2br(rawurldecode($_POST['content'])) . "'";
			$set .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
			$set .= ",upd_date='" . time() . "'";
			$set .= ",review_date='" . $review_date . "'";
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$set .= ",is_online='" . $is_online . "'";

			$type = Input::get('type', '');
			if ($type != '') {
				$pURL = "&type=" . $type;
			} else {
				$pURL = "&act=reviewAll";
			}
			if ($clsClassTable->updateOne($pvalTable, $set)) {
				#
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=updateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . $pURL . '&message=updateSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . $pURL . '&message=updateFailed');
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

			if (isset($_POST['review_date'])) {
				$_POST['review_date'] = str_replace('/', '-', $_POST['review_date']);
				$_POST['review_date'] = strtotime($_POST['review_date']);
			}

			$max_id = $clsClassTable->getMaxID();
			$max_order = $clsClassTable->getMaxOrderNo();
			$field .= ",slug,user_id,user_id_update,review_date,reg_date,upd_date,$clsClassTable->pkey,order_no";
			$value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "','" . $user_id . "','" . $user_id . "','" . $_POST['review_date'] . "','" . time() . "','" . time() . "','" . $max_id . "','" . $max_order . "'";
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&' . $clsClassTable->pkey . '=' . $core->encryptID($max_id) . '&message=updateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
			}
		}
	}
}
function default_trash()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Reviews";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$type = isset($_GET['type']) ? $_GET['type'] : "";

	$pUrl = '';
	if (!empty($type)) {
		$pUrl .= '&type=' . $type;
	}
	if ($pvalTable == 0)
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');

	if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=TrashSuccess');
	}
}
function default_restore()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Reviews";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$type = isset($_GET['type']) ? $_GET['type'] : "";

	$pUrl = '';
	if (!empty($type)) {
		$pUrl .= '&type=' . $type;
	}
	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');

	if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=RestoreSuccess');
	}
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Reviews";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$type = isset($_GET['type']) ? $_GET['type'] : "";
	$action = isset($_GET['action']) ? $_GET['action'] : "";

	if ($string = '' && $pvalTable == 0)
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

	$pUrl = '';
	if (!empty($action)) {
		$pUrl .= '&act=' . $action;
	}
	if (!empty($type)) {
		$pUrl .= '&type=' . $type;
	}
	if ($clsClassTable->doDelete($pvalTable)) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=DeleteSuccess');
	}
}
function default_ajaxLoadListChoose()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	$type = isset($_POST['type']) ? $_POST['type'] : '';
	$reviews_id = isset($_POST['reviews_id']) ? intval($_POST['reviews_id']) : 0;
	#
	$clsReviews = new Reviews();
	$oneReview = $clsReviews->getOne($reviews_id);
	#
	$html = '';
	if (!empty($type)) {
		$clsTable = $type;
		$clsClassTable = new $clsTable();
		#
		$all = $clsClassTable->getAll("is_trash=0 and is_online=1 order by order_no desc");
		$html .= '';
		if (is_array($all) && !empty($all)) {
			$html .= '<ul class="list_cruise">';
			for ($i = 0; $i < count($all); $i++) {
				$html .= '<li><label><input class="cr_rw" type="checkbox" ' . ($clsISO->checkContainer($oneReview['list_for_id'], $all[$i][$clsClassTable->pkey]) ? 'checked=checked' : '') . ' name="list_for_id[]" value="' . $all[$i][$clsClassTable->pkey] . '" /> ' . $clsClassTable->getTitle($all[$i][$clsClassTable->pkey]) . '</label></li>';
			}
			$html .= '</ul>';
		}
	}
	echo $html;
	die();
}

function default_ajaxDeleteImageReview()
{
	global $clsISO, $core;
	$clsImage = new Image();
	$data_id = $core->decryptID($_POST['data_id']);
	$image = $clsImage->getOne($data_id);
	$img = $image['image'];
	$data = array(
		'result' => 'false',
	);
	if ($clsImage->deleteOne($data_id)) {
		$file_path =  $_SERVER['DOCUMENT_ROOT'] . $img;

		if (is_file($file_path)) {
			@unlink($file_path);
		}

		$data = array(
			'result' => 'true',
		);
	}

	echo json_encode($data);
	die;
}

function default_ajaxUploadImages()
{
	global $clsISO, $core;
	$clsImage = new Image();

	$listImages = $_POST['list_images'];
	$reviews_id = $_POST['table_id'];
	$data = array(
		'result' => 'false',
		'mess' => '_ERROR',
	);
	$addTrue = [];
	$addFalse = '';
	foreach ($listImages as $item) {
		$field = 'image_id,table_id,type,image,order_no,reg_date';
		$id_image = $clsImage->getMaxId();
		$value = "'" . $id_image . "'
		,'$reviews_id'
		,'_REVIEW'
		,'" . addslashes($item) . "'
		,'" . $clsImage->getMaxOrderNo() . "'
		,'" . time() . "'";
		if ($clsImage->insertOne($field, $value)) {
			$addTrue[] = [
				'image_id' => $core->encryptID($id_image),
				'image' => $item,
			];
		} else {
			$addFalse .= "|$item|";
		}
	}
	$data = array(
		'result' => 'true',
		'mess' => '_SUCCESS',
		'addTrue' => $addTrue,
		'addFalse' => $addFalse,
	);
	echo json_encode($data);
	die;
}
