<?php

function default_default()
{
		// ini_set('display_errors', '1');
		// ini_set('display_startup_errors', '1');
		// error_reporting(E_ALL);
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn, $clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];

	$clsSupplier = new VoucherSupply();
	$assign_list["clsSupplier"] = $clsSupplier;

	$clsVoucherCat = new VoucherCat();
	$assign_list["clsVoucherCat"] = $clsVoucherCat;

	$clsVoucherCode = new VoucherCode();
	$assign_list["clsVoucherCode"] = $clsVoucherCode;

	$startCurrentMonth = strtotime(date('Y-m-01 00:00:00'));
	$startNextMonth = strtotime('+1 month', $startCurrentMonth);
	$startPrevMonth = strtotime('-1 month', $startCurrentMonth);


	/* =========================
	* TOTAL VOUCHER
	* ========================= */

	$totalCode = $clsVoucherCode->countItem(
		"is_trash=0
		and created_time >= {$startCurrentMonth}
		and created_time < {$startNextMonth}"
	);

	$totalCodePrev = $clsVoucherCode->countItem(
		"is_trash=0
		and created_time >= {$startPrevMonth}
		and created_time < {$startCurrentMonth}"
	);

	$totalPercent = getPercentChange(
		$totalCode,
		$totalCodePrev
	);

	$assign_list["totalCode"] = $totalCode;
	$assign_list["totalPercent"] = $totalPercent;

	$soldCode = $clsVoucherCode->countItem(
		"is_trash=0 
		and is_online=1
		and sold_at >= {$startCurrentMonth}
		and sold_at < " . strtotime('+1 month', $startCurrentMonth)
	);

	$soldCodePrev = $clsVoucherCode->countItem(
		"is_trash=0 
		and is_online=1
		and sold_at >= {$startPrevMonth}
		and sold_at < {$startCurrentMonth}"
	);

	$soldPercent = getPercentChange($soldCode, $soldCodePrev);

	$assign_list["soldCode"] = $soldCode;
	$assign_list["soldPercent"] = $soldPercent;


	$availableCode = $clsVoucherCode->countItem(
		"is_trash=0 and is_online=1 and redeemed_at is NULL and expired_at is NULL and cancelled_at is NULL and valid_to > UNIX_TIMESTAMP() and valid_from <= UNIX_TIMESTAMP()");
	$assign_list["availableCode"] = $availableCode;

	$firstDayCurrentMonth = strtotime(date('Y-m-01 00:00:00'));
	$lastMonthEnd = $firstDayCurrentMonth - 1;
	$availableCodePrev = $clsVoucherCode->countItem(
		"is_trash=0
		and is_online=1
		and (sold_at is NULL or sold_at > {$lastMonthEnd})
		and (redeemed_at is NULL or redeemed_at > {$lastMonthEnd})
		and (expired_at is NULL or expired_at > {$lastMonthEnd})
		and (cancelled_at is NULL or cancelled_at > {$lastMonthEnd})
		and valid_from <= {$lastMonthEnd}
		and valid_to >= {$lastMonthEnd}"
	);

	$availablePercent = getPercentChange(
		$availableCode,
		$availableCodePrev
	);
	$assign_list["availablePercent"] = $availablePercent;
		

	$redeemedCode = $clsVoucherCode->countItem(
		"is_trash=0
		and is_online=1
		and redeemed_at >= {$startCurrentMonth}
		and redeemed_at < " . strtotime('+1 month', $startCurrentMonth)
	);

	$redeemedCodePrev = $clsVoucherCode->countItem(
		"is_trash=0
		and is_online=1
		and redeemed_at >= {$startPrevMonth}
		and redeemed_at < {$startCurrentMonth}"
	);

	$redeemedPercent = getPercentChange(
		$redeemedCode,
		$redeemedCodePrev
	);

	$assign_list["redeemedCode"] = $redeemedCode;
	$assign_list["redeemedPercent"] = $redeemedPercent;

	$expiredCode = $clsVoucherCode->countItem(
		"is_trash=0
		and is_online=1
		and expired_at >= {$startCurrentMonth}
		and expired_at < " . strtotime('+1 month', $startCurrentMonth)
	);

	$expiredCodePrev = $clsVoucherCode->countItem(
		"is_trash=0
		and is_online=1
		and expired_at >= {$startPrevMonth}
		and expired_at < {$startCurrentMonth}"
	);

	$expiredPercent = getPercentChange(
		$expiredCode,
		$expiredCodePrev
	);

	$assign_list["expiredCode"] = $expiredCode;
	$assign_list["expiredPercent"] = $expiredPercent;

	$op_status = array(
		'1' => 'Active',
		'2' => 'Inactive'
	);
	$assign_list["op_status"] = $op_status;


	$cat_id = (int) Input::get('cat_id', 0);
	$type_id = (int) Input::get('type_id', 0);
	$supplier_id = (int) Input::get('supplier_id', 0);
	$option_status = Input::get('option_status', 0);
	$keyword = Input::get('keyword', "");
	$type = !empty($_GET["type"]) ? $_GET["type"] : "";
	$assign_list["cat_id"] = $cat_id;
	$assign_list["type_id"] = $type_id;
	$assign_list["keyword"] = $keyword;
	$assign_list["supplier_id"] = $supplier_id;
	$assign_list["type"] = $type;
	$assign_list["option_status"]  = $option_status;
	//var_dump($supplier_id); die();
	$pUrl = '';
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$cat_id = (int) Input::post('voucher_cat_id', 0);
		$type_id = (int) Input::post('type_id', 0);
		$supplier_id = (int) Input::post('supplier_id', 0);
		$keyword = Input::post('keyword');
		$option_status = Input::post('option_status', '');
		$link = '';
		if ($type) {
			$link .= '&type=' . $type;
		}
		if ($cat_id > 0) {
			$link .= '&cat_id=' . $cat_id;
		}
		if ($type_id > 0) {
			$link .= '&type_id=' . $type_id;
		}
		if ($supplier_id > 0) {
			$link .= '&supplier_id=' . $supplier_id;
		}
		if ($option_status > 0) {

			$link .= '&option_status=' . urlencode($option_status);
		}
		if (!empty($keyword)) {
			$link .= '&keyword=' . $keyword;
		}

		header('Location: ' . PCMS_URL . '/?mod=' . $mod . $link);
		exit();
	}
	/*Get type of list news*/
	$type_list = Input::get('type_list');
	$assign_list["type_list"] = $type_list;
	/**/
	$classTable = "Voucher";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	/*List all item*/

	$assign_list["voucher_link"] = DOMAIN_NAME . (!$type ? $clsISO->getLink($mod) : $clsISO->getLink("agent_voucher"));

	$cond = "1=1 ";
	if ($type) {
		$cond .= " AND type='$type'";
	}
	#Filter By VoucherCat
	if ($cat_id > 0) {
		$pUrl .= '&cat_id=' . $cat_id;
		$cond .= " and (cat_id = '{$cat_id}' or list_cat_id like '%|{$cat_id}|%')";
	}
	if ($type_id > 0) {
		$pUrl .= '&type_id=' . $type_id;
		$cond .= " and list_type_id like '%|{$type_id}|%'";
	}
	if ($supplier_id > 0) {
		$pUrl .= '&supplier_id=' . $supplier_id;
		$cond .= " and supplier_id='{$supplier_id}'";
	}
	if (!empty($option_status)) {
		switch ($option_status) {
			case '1':
				$pUrl .= '&option_status=' . urlencode($option_status);
				$cond .= " and is_online='1'";
				break;
			case '2':
				$pUrl .= '&option_status=' . urlencode($option_status);
				$cond .= " and is_online='0'";
				break;
			default:
		}
	}
	$assign_list["pUrl"] = $pUrl;
	#Filter By Keyword
	if (!empty($keyword)) {
		$cond .= " and (code like '%{$keyword}%' 
			or barcode like '%{$keyword}%'  
			or slug like '%" . $core->replaceSpace($keyword) . "%'
		)";
	}
	$cond2 = $cond;
	if (!empty($type_list)) {
		if ($type_list == 'Publish') {
			$cond .= " and is_trash=0 and is_online=1";
		} else if ($type_list == 'Trash') {
			$cond .= " and is_trash=1";
		} else if ($type_list == 'Private') {
			$cond .= " and is_trash=0 and is_online=0";
		}
	}
	$orderBy = " order_no DESC";
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
	$current_page = (int) Input::get('page', 1);
	$total_record = $clsClassTable->countItem($cond);

	$link_page_current = '';
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&', $query_string);
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
		if ($tmp[0] != 'page' && $tmp[0] != 'vpc_status')
			$link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	$config = array(
		'total'	=> $total_record,
		'current_page'	=> $current_page,
		'number_per_page'	=> $recordPerPage,
		'link'	=> PCMS_URL . '/index.php' . $link_page_current_2
	);
	$clsPagination = new Pagination();
	$clsPagination->initianize($config);
	$html_pager = $clsPagination->create_links();
	$assign_list["html_pager"] = $html_pager;
	#
	$offset = ($current_page - 1) * $recordPerPage;
	$limit = " limit {$offset},{$recordPerPage}";
	#-------End Page Divide-----------------------------------------------------------
	$allItem = [];
	$sql = "";
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);

	$assign_list["allItem"] = $allItem;
	#
	$allAll = $clsClassTable->getAll($cond2, $clsClassTable->pkey);
    $assign_list["number_all"] = count($allAll) ?? 0;

	$allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_trash"] = count($allTrash) ?? 0;

	$allPublish = $clsClassTable->getAll("is_trash=0 and is_online=1 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_publish"] = count($allPublish) ?? 0;

	$allPrivate = $clsClassTable->getAll("is_trash=0 and is_online=0 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_private"] = count($allPrivate) ?? 0;

	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : ADMIN_PAGINATION;
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
    $assign_list['showingStart'] = $totalRecord > 0 ? $start_limit + 1 : 0;
    $assign_list['showingEnd'] = min($start_limit + $recordPerPage, $totalRecord);
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


	//die('xxxx');
}

function getPercentChange($current, $previous)
{
    $current = (int)$current;
    $previous = (int)$previous;

    if ($previous == 0) {
        return $current > 0 ? 100 : 0;
    }

    return round((($current - $previous) / $previous) * 100);
}


function default_stock()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];

	$clsVoucher = new Voucher();
	$clsVoucherCat = new VoucherCat();
	$assign_list["clsVoucher"] = $clsVoucher;
	$assign_list["clsVoucherCat"] = $clsVoucherCat;

	$cat_id = (int) Input::get('cat_id', 0);
	$keyword = Input::get('keyword');
	$assign_list["cat_id"] = $cat_id;
	$assign_list["keyword"] = $keyword;

	/** Submit seảch */
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$cat_id = (int) Input::post('cat_id', 0);
		$keyword = Input::post('keyword');

		$link = '';
		if ($cat_id > 0) {
			$link .= '&cat_id=' . $cat_id;
		}
		if (!empty($keyword)) {
			$link .= '&keyword=' . $keyword;
		}
		header('Location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $link);
		exit();
	}

	/*Get type of list news*/
	$type_list = Input::get('type_list');
	$assign_list["type_list"] = $type_list;
	/**/
	$classTable = "Stock";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	/*List all item*/

	$cond = "1=1";
	#Filter By VoucherCat
	if ($cat_id > 0) {
		$pUrl .= '&cat_id=' . $cat_id;
		$cond .= " and (t2.cat_id = '{$cat_id}' or t2.list_cat_id like '%|{$cat_id}|%')";
	}
	$assign_list["pUrl"] = $pUrl;
	#Filter By Keyword
	if (!empty($keyword)) {
		$cond .= " and (t2.code like '%{$keyword}%' 
			or t2.barcode like '%{$keyword}%'  
			or t2.slug like '%" . $core->replaceSpace($keyword) . "%'
		)";
	}
	$cond2 = $cond;
	if (!empty($type_list)) {
		if ($type_list == 'Active') {
			$cond .= " and t2.is_trash=0";
		} else if ($type_list == 'Trash') {
			$cond .= " and t2.is_trash=1";
		}
	}
	$orderBy = " t2.reg_date desc";
	#-------Page Divide---------------------------------------------------------------
	$record_per_page = 20;
	$current_page = (int) Input::get('page', 1);
	$total_record = Query_Results::countItem("select count(1) as total_record from " . $clsClassTable->tbl . " as t1 
	inner join " . $clsVoucher->tbl . " as t2 on t1.voucher_id=t2.voucher_id where {$cond}", "total_record");
	//$total_record = $clsClassTable->countItem($cond);
	$link_page_current = '';
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&', $query_string);
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
		if ($tmp[0] != 'page' && $tmp[0] != 'vpc_status')
			$link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#
	$config = array(
		'total'	=> $total_record,
		'current_page'	=> $current_page,
		'number_per_page'	=> $record_per_page,
		'link'	=> PCMS_URL . '/index.php' . $link_page_current_2
	);
	$clsPagination = new Pagination();
	$clsPagination->initianize($config);
	$html_pager = $clsPagination->create_links();
	$assign_list["html_pager"] = $html_pager;
	#
	$offset = ($current_page - 1) * $record_per_page;
	$limit = " limit {$offset},{$record_per_page}";
	#-------End Page Divide-----------------------------------------------------------
	//$allItem = $clsClassTable->getAll($cond." order by ".$orderBy.$limit); 
	$allItem = $dbconn->GetAll("select t1.*,t2.code,t2.price,t2.continue_order from " . $clsClassTable->tbl . " as t1 
	inner join " . $clsVoucher->tbl . " as t2 on t1.voucher_id=t2.voucher_id where {$cond} order by {$orderBy}" . $limit);
	$assign_list["allItem"] = $allItem;
	//$assign_list["number_item"] = $clsClassTable->countItem("is_trash=0 and ".$cond2);
	//$assign_list["number_all"] = $clsClassTable->countItem($cond2);
}

function default_ajActionNewVoucher()
{
	//	ini_set('display_errors', '1');
	//	ini_set('display_startup_errors', '1');
	//	error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,
		$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $clsISO, $package_id;
	$user_id = $core->_USER['user_id'];
	#
	$clsVoucher = new Voucher();
	$assign_list["clsVoucher"] = $clsVoucher;
	$tp = Input::post('tp');
	$type = !empty($_POST["type"]) ? $_POST["type"] : 0;
	$is_day_trip = Input::post('is_day_trip', 0);

	$voucher_id = $clsVoucher->getMaxId();
	$title_voucher_new = $core->get_Lang('New Voucher') . ' ' . $voucher_id;
	$results = array('result' => 'error');
	if ($tp == 'S') {
		$field = $clsVoucher->pkey . ",cat_id,list_cat_id,user_id,user_id_update,title,slug,order_no,reg_date,upd_date,type";
		$value = "'" . $voucher_id . "','0','0','" . $user_id . "','" . $user_id . "','" . $title_voucher_new . "','" . $core->replaceSpace($title_voucher_new) . "'," . $clsVoucher->getMaxOrderNo() . ",'" . time() . "','" . time() . "','$type'";
		//$clsVoucher->SetDebug(1);
		$clsVoucher->insertOne($field, $value);
		// die;
		$results = array('result' => 'success', 'link' => 'voucher/insert/' . $voucher_id . '/overview');
	}
	// Return
	echo @json_encode($results);
	die();
}

function default_edit()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO, $pvalTable, $clsClassTable, $_user_group_id;
	$assign_list["clsModule"]  = $clsModule;
	$user_id  = $core->_USER['user_id'];
	#
	$clsProperty                         = new Property();
	$assign_list["clsProperty"]          = $clsProperty;

	$clsContinent                         = new Continent();
	$assign_list["clsContinent"]          = $clsContinent;

	$classTable                     = "Voucher";
	$clsClassTable                  = new $classTable;
	$tableName                      = $clsClassTable->tbl;
	$pkeyTable                      = $clsClassTable->pkey;
	$assign_list["clsClassTable"]   = $clsClassTable;
	$clsVoucherCat                = new VoucherCat();
	$assign_list["clsVoucherCat"] = $clsVoucherCat;
	$voucher_cat_id                     = isset($_GET['voucher_cat_id']) ? intval($_GET['voucher_cat_id']) : 0;
	#
	$string                         = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable                      = intval($core->decryptID($string));
	$assign_list['pvalTable']       = $pvalTable;
	$oneItem                        = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"]         = $oneItem;
	if ($pvalTable > 0) {
		$voucher_cat_id = $oneItem['cat_id'];
	}
	$assign_list["voucher_cat_id"] = $voucher_cat_id;

	#-------------Update Config Meta
	$clsMeta                = new Meta();
	$assign_list["clsMeta"] = $clsMeta;
	$linkMeta               = $clsClassTable->getLink($pvalTable);
	$allMeta                = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id                = $allMeta[0]['meta_id'];
	$assign_list["meta_id"] = $meta_id;
	$assign_list["oneMeta"] = $clsMeta->getOne($meta_id);

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("static", 'intro', "", 'intro', 255, 25, 5, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 22, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", 'location', "", 'location', 255, 25, 5, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", 'inclusion', "", 'inclusion', 255, 25, 22, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", 'exclusion', "", 'exclusion', 255, 25, 22, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", 'note', "", 'note', 255, 25, 22, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", 'checkinOut', "", 'checkinOut', 255, 25, 22, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", 'timeApplication', "", 'timeApplication', 255, 25, 22, 1, "style='width:100%'");
	#
	/*if ($string != '' && $pvalTable == 0) {
    header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
}*/
	#
	if (intval($pvalTable) > 0 && $clsConfiguration->getValue('SiteHasTags_Voucher')) {
		#---Edit Tags of post
		$clsTag                = new Tag();
		$assign_list["clsTag"] = $clsTag;
		$listAllTag            = $clsTag->getAll("1=1 and title<>'' order by title asc limit 0,5000");
		#
		$listAvailableTag      = '<script type="text/javascript">var availableTags = [';
		for ($i = 0; $i < count($listAllTag); $i++) {
			$listAvailableTag .= '{ name: "' . $listAllTag[$i]['title'] . '", val: "' . $listAllTag[$i]['title'] . '" },';
		}
		$listAvailableTag .= '];</script>';
		$assign_list["listAvailableTag"] = $listAvailableTag;
		#
		$clsTagModule                    = new TagModule();
		$assign_list["clsTagModule"]     = $clsTagModule;
		$listTag                         = $clsTagModule->getAll("1=1 and for_id='$pvalTable' and type = 'BLOG' order by reg_date asc limit 0,20");
		$assign_list["listTag"]          = $listTag;
		unset($listAllTag);
		unset($listTag);
	}
	#=============================================#
	if (isset($_POST['UpdateStep1']) && $_POST['UpdateStep1'] == 'UpdateStep1') {
		if ($pvalTable > 0) {
			$set      = "";
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
			$set .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
			$set .= ",upd_date='" . time() . "'";
			$set .= ",title='" . addslashes($_POST['title']) . "'";
			$set .= ",slug='" . $core->replaceSpace($_POST['title']) . "'";
			$set .= ",is_draft='0'";


			//		echo str_replace('$', '', $clsISO->replaceSpace($slug_title)); die();
			#--Special Field: image
			$image     = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image     = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if ($image != '' && $image != '0') {
				$set .= ",image='" . addslashes($image) . "'";
			}
			$pUrl = '';
			if ($clsConfiguration->getValue('SiteHasCat_Voucher')) {
				$cat_id      = $_POST['iso-cat_id'];
				$list_cat_id = $clsVoucherCat->getListParent($cat_id);
				$set .= ",list_cat_id='" . addslashes($list_cat_id) . "'";
				$pUrl .= '&voucher_cat_id=' . $cat_id;
			}

			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$set .= ",is_online='" . $is_online . "'";

			//		print_r($pvalTable.'xxx'. $set); die();

			if ($clsClassTable->updateOne($pvalTable, $set)) {
				$clsStock = new Stock();
				$clsStock->init($pvalTable, Input::post('quantity', 0));
				$titleMeta = $_POST['config_value_title'] ? addslashes($_POST['config_value_title']) : addslashes($_POST['title']);
				$introMeta = strip_tags(html_entity_decode(addslashes($_POST['iso-intro'])));
				$descriptionMeta = $_POST['config_value_intro'] ? addslashes($_POST['config_value_intro']) : substr($introMeta, 0, 160);
				$image_seo     = isset($_POST['image_seo_src']) ? $_POST['image_seo_src'] : '';
				if (_isoman_use) {
					$image_seo     = $_POST['isoman_url_image_seo'];
				}
				$image_seo = $image_seo ? $image_seo : $image;
				if ($meta_id == '') {
					$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,meta_index,meta_follow", "'" . $linkMeta . "','" . $titleMeta . "','" . $descriptionMeta . "','" . $image_seo . "','" . time() . "','" . time() . "','" . $clsMeta->getMaxId() . "','" . $_POST['meta_index'] . "','" . $_POST['meta_follow'] . "'");
					$allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
				} else {
					$clsMeta->updateOne($meta_id, "config_value_intro='" . $descriptionMeta . "',config_value_title='" . $titleMeta . "',image='" . $image_seo . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
				}
				header('location:' . PCMS_URL . '/?mod=' . $mod . '&act=edit&voucher_id=' . $core->encryptID($pvalTable) . '&message=updateSuccess');
			} else {
				header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateFailed');
			}
		} else {
			$listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no = $listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
			}
			$value    = "";
			$firstAdd = 0;
			$field    = "";
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
			$voucher_id = $clsClassTable->getMaxId();
			$field .= ",user_id,user_id_update,reg_date,upd_date,title,slug,voucher_id,order_no";
			$value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
			$value .= ",'" . ucwords($_POST['title']) . "','" . $core->replaceSpace($_POST['title']) . "','" . $voucher_id . "','1'";
			$field .= ",is_draft";
			$value .= ",0";


			#--Special Field: image
			$image     = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$imagehome = isset($_POST['imagehome_src']) ? $_POST['imagehome_src'] : '';
			if (_isoman_use) {
				$image     = $_POST['isoman_url_image'];
			}
			if ($image != '' && $image != '0') {
				$field .= ',image';
				$value .= ",'" . addslashes($image) . "'";
			}
			$pUrl = '';
			if ($clsConfiguration->getValue('SiteHasCat_Voucher')) {
				$cat_id      = $_POST['iso-cat_id'];
				$list_cat_id = $clsVoucherCat->getListParent($cat_id);
				$field .= ',list_cat_id';
				$value .= ",'" . addslashes($list_cat_id) . "'";
				$pUrl .= '&voucher_cat_id=' . $cat_id;
			}

			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			//print_r($field.'xxx'.$value); die();
			if ($clsClassTable->insertOne($field, $value)) {
				//			header('location:' . PCMS_URL . '/?mod=' . $mod . '&act=edit&voucher_id=' . $core->encryptID($voucher_id) . '&message=insertSuccess');
				header('location:' . PCMS_URL . '/' . $mod . '/insert/' . $voucher_id . '/overview&message=insertSuccess');
			} else {
				header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertFailed');
			}
		}
	}
	if (isset($_POST['UpdateStep2']) && $_POST['UpdateStep2'] == 'UpdateStep2') {
		if ($pvalTable > 0) {
			$set      = "";
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

			$is_shipping = (int) Input::post('is_shipping', 0);
			$is_inventory = (int) Input::post('is_inventory', 0);
			$taxable = $clsISO->toInt(Input::post('taxable', 0));
			$continue_order = Input::post('continue_order', 0);
			$unit = Input::post('unit', 0);
			$unit = $unit > 0 ? $unit : 0;
			#
			$set .= ",continue_order='{$continue_order}'";
			$set .= ",taxable='$taxable',is_inventory='$is_inventory'";
			$set .= ",is_shipping='$is_shipping'";
			$set .= ",unit='$unit'";
			$set .= ",price='" . $clsISO->processSmartNumber2(Input::post('price')) . "'";
			$set .= ",price_input='" . $clsISO->processSmartNumber2(Input::post('price_input')) . "'";
			//		echo str_replace('$', '', $clsISO->replaceSpace($slug_title)); die();
			#--Special Field: image


			if ($clsClassTable->updateOne($pvalTable, $set)) {
				$clsStock = new Stock();
				$clsStock->init($pvalTable, Input::post('quantity', 0));
				header('location:' . PCMS_URL . '/?mod=' . $mod . '&act=edit&voucher_id=' . $core->encryptID($pvalTable) . '&message=updateSuccess#isotab3');
			} else {
				header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateFailed');
			}
		}
	}
	if (isset($_POST['UpdateStep3']) && $_POST['UpdateStep3'] == 'UpdateStep3') {
		$titleMeta = $_POST['config_value_title'] ? addslashes($_POST['config_value_title']) : addslashes($_POST['title']);
		$introMeta = strip_tags(html_entity_decode(addslashes($_POST['iso-intro'])));
		$descriptionMeta = $_POST['config_value_intro'] ? addslashes($_POST['config_value_intro']) : substr($introMeta, 0, 160);
		$image_seo     = isset($_POST['image_seo_src']) ? $_POST['image_seo_src'] : '';
		if (_isoman_use) {
			$image_seo     = $_POST['isoman_url_image_seo'];
		}
		$image_seo = $image_seo ? $image_seo : $image;
		if ($meta_id == '') {
			$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,meta_index,meta_follow", "'" . $linkMeta . "','" . $titleMeta . "','" . $descriptionMeta . "','" . $image_seo . "','" . time() . "','" . time() . "','" . $clsMeta->getMaxId() . "','" . $_POST['meta_index'] . "','" . $_POST['meta_follow'] . "'");
			$allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
		} else {
			$clsMeta->updateOne($meta_id, "config_value_intro='" . $descriptionMeta . "',config_value_title='" . $titleMeta . "',image='" . $image_seo . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
		}
		header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateSuccess');
	}
	#=========================================#
}
function default_edit_()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsVoucherCat = new VoucherCat();
	$assign_list["clsVoucherCat"] = $clsVoucherCat;
	$cat_id = (int) Input::get('cat_id', 0);
	$type_id = (int) Input::get('type_id', 0);
	$assign_list["cat_id"] = $cat_id;
	$assign_list["type_id"] = $type_id;

	$clsSupplier = new Supplier();
	$assign_list["clsSupplier"] = $clsSupplier;

	$classTable = "Voucher";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$clsVoucherStore = new VoucherStore();
	$assign_list["clsVoucherStore"] = $clsVoucherStore;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = !empty($string) ? intval($core->decryptID($string)) : 0;
	if (!empty($string) && $pvalTable == 0) {
		header('Location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
		exit();
	}
	#-------------Update Config Meta
	$clsMeta = new Meta();
	$assign_list["clsMeta"] = $clsMeta;
	$linkMeta = $clsClassTable->getLink($pvalTable);
	$allMeta = $clsMeta->getAll("config_link='{$linkMeta}' limit 0,1", $clsMeta->pkey);
	$meta_id = empty($allMeta) ? (int) $allMeta[0]['meta_id'] : 0;
	$assign_list["meta_id"] = $meta_id;
	#=========================================#
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		$pvalTable = (int) Input::post('pvalTable', 0);
		$action = Input::post('action', 'add');
		$cat_id = (int) Input::post('cat_id', 0);
		$is_shipping = (int) Input::post('is_shipping', 0);
		$is_inventory = (int) Input::post('is_inventory', 0);
		$taxable = $clsISO->toInt(Input::post('taxable', 0));
		$continue_order = Input::post('continue_order', 0);
		//var_dump($_POST); die();
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
		$set .= ",is_draft='0'";
		$set .= ",is_online='" . Input::post('is_online', 0) . "'";
		$set .= ",user_id_update='" . $user_id . "',continue_order='{$continue_order}'";
		$set .= ",upd_date='" . time() . "',taxable='{$taxable}',is_inventory='{$is_inventory}'";
		$set .= ",slug='" . $core->replaceSpace(Input::post('iso-title')) . "',is_shipping='{$is_shipping}'";
		$set .= ",price='" . $clsISO->processSmartNumber2(Input::post('price')) . "'";
		$set .= ",price_input='" . $clsISO->processSmartNumber2(Input::post('price_input')) . "'";

		#--Special Field: image
		$list_type_id = Input::post('list_type_id');
		if (!empty($list_type_id)) {
			$list_type_id = $clsISO->makeSlashListFromArray($list_type_id);
			$set .= ", list_type_id = '" . $list_type_id . "'";
		}
		/* End Type */
		$pUrl = '';
		if ($cat_id > 0) {
			$pUrl .= '&cat_id=' . $cat_id;
			$list_cat_id = $clsVoucherCat->getListParent($cat_id);
			$set .= ",cat_id = '{$cat_id}', list_cat_id = '" . $list_cat_id . "'";
		}
		/** Logs action edit */
		if ($action == 'edit') {
			$clsLog = new Log();
			$type_log = 'Voucher';
			$pkeyTable_log = $pkeyTable;
			$pvalTable_log = $pvalTable;
			$title_log = "Sửa sản phẩm #" . $pvalTable;
			$intro_log = json_encode($clsClassTable->getOne($pvalTable));
			$clsLog->insertAction($type_log, $pkeyTable_log, $pvalTable_log, $title_log, $intro_log);
		}
		/** End Logs action */
		if ($clsClassTable->updateOne($pvalTable, $set)) {
			/** Logs action new */
			if ($action == 'add') {
				$clsLog = new Log();
				$type_log = 'Voucher';
				$pkeyTable_log = $pkeyTable;
				$pvalTable_log = $pvalTable;
				$title_log = "Thêm mới sản phẩm #" . $pvalTable;
				$intro_log = json_encode($clsClassTable->getOne($pvalTable));
				$clsLog->insertAction($type_log, $pkeyTable_log, $pvalTable_log, $title_log, $intro_log);
			}
			/** End Logs action */

			/** Update Stock */
			$clsStock = new Stock();
			$clsStock->init($pvalTable, Input::post('quantity', 0));
			/** End Update Stock */
			$config_value_title = Input::post('config_value_title');
			$config_value_intro = Input::post('config_value_intro');
			if (!empty($config_value_title)) {
				if ((int) $meta_id == 0) {
					$meta_id = $clsMeta->getMaxId();
					$clsMeta->insertOne("config_link,reg_date,meta_id", "'" . $linkMeta . "','" . time() . "','{$meta_id}'");
				}
				$clsMeta->updateOne($meta_id, "config_value_intro='" . addslashes($config_value_intro) . "',config_value_title='" . addslashes($config_value_title) . "',upd_date='" . time() . "'");
			}
			if ($_POST['button'] == '_EDIT') {
				header('Location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $pkeyTable . '=' . $core->encryptID($pvalTable) . '&message=updateSuccess');
				exit();
			} else {
				header('Location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateSuccess');
				exit();
			}
		} else {
			header('Location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateFailed');
			exit();
		}
	} else {
		$action = 'edit';
		if ($pvalTable == 0) {
			$action = 'add';
			/** Clear Temp */
			$clsClassTable->deleteByCond("is_draft=1 and user_id='{$user_id}'");
			/** End clear temp */
			$pvalTable = $clsClassTable->getMaxId();
			$list_type_id = ($type_id > 0) ? "|{$type_id}|" : "";
			$list_cat_id = ($cat_id > 0) ? $clsVoucherCat->getListParent($cat_id) : "";
			$clsClassTable->insert(array(
				$pkeyTable => $pvalTable,
				'price' => 0,
				'price_input' => 0,
				'taxable' => 0,
				'is_shipping' => 0,
				'is_inventory' => 0,
				'weight' => 0,
				'is_draft' => 1,
				'is_online' => 1,
				'user_id' => $user_id,
				'reg_date' => time(),
				'cat_id' => $cat_id,
				'list_cat_id' => $list_cat_id,
				'list_type_id' => $list_type_id,
				'order_no'	=> $clsClassTable->getMaxOrderNo()
			));
		}
		$oneItem = $clsClassTable->getOne($pvalTable);
		$cat_id = $oneItem['cat_id'];
		$list_type_id = $oneItem['list_type_id'];
		$list_type_selected = !empty($list_type_id) ? $clsISO->getArrayByTextSlash($list_type_id) : array();

		$assign_list['action'] = $action;
		$assign_list["cat_id"] = $cat_id;
		$assign_list["oneItem"] = $oneItem;
		$assign_list['pvalTable'] = $pvalTable;
		$assign_list["list_type_selected"] = $list_type_selected;

		require_once DIR_COMMON . "/clsForm.php";
		$clsForm = new Form();
		$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
		$assign_list["clsForm"] = $clsForm;
		$clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 5, 1,  "style='width:100%'");
		$clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 15, 1,  "style='width:100%'");
	}
}
function default_trash()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Voucher";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$cat_id = (int) Input::get('cat_id', 0);
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = !empty($string) ? intval($core->decryptID($string)) : 0;
	if (intval($cat_id) != 0) {
		$pUrl .= '&cat_id=' . $cat_id;
	}
	if ($pvalTable == "") {
		header('Location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');
		exit();
	}
	/** Logs action */
	$clsLog = new Log();
	$type_log = 'Voucher';
	$pkeyTable_log = $pkeyTable;
	$pvalTable_log = $pvalTable;
	$title_log = "Trash sản phẩm #" . $pvalTable;
	$intro_log = json_encode($clsClassTable->getOne($pvalTable));
	$clsLog->insertAction($type_log, $pkeyTable_log, $pvalTable_log, $title_log, $intro_log);
	/** End Logs action */
	if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
		header('Location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=TrashSuccess');
		exit();
	}
}
function default_restore()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Voucher";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$cat_id = (int) Input::get('cat_id', 0);
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = !empty($string) ? intval($core->decryptID($string)) : 0;

	$pUrl = '';
	if (intval($cat_id) != 0) {
		$pUrl .= '&cat_id=' . $cat_id;
	}
	if ($pvalTable == "") {
		header('Location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');
		exit();
	}
	/** Logs action */
	$clsLog = new Log();
	$type_log = 'Voucher';
	$pkeyTable_log = $pkeyTable;
	$pvalTable_log = $pvalTable;
	$title_log = "Restore sản phẩm #" . $pvalTable;
	$intro_log = json_encode($clsClassTable->getOne($pvalTable));
	$clsLog->insertAction($type_log, $pkeyTable_log, $pvalTable_log, $title_log, $intro_log);
	/** End Logs action */
	if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
		header('Location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=RestoreSuccess');
	}
}
function default_move()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Voucher";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	#
	$direct = Input::get('direct', 'up');
	$cat_id = (int) Input::get('cat_id', 0);
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = !empty($string) ? intval($core->decryptID($string)) : 0;

	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	if ($pvalTable == "" || $direct == '') {
		header('Location: ' . PCMS_URL . '/?mod=' . $mod);
		exit();
	}

	$pUrl = '';
	$where = 'is_trash=0 ';
	if (intval($cat_id) != 0) {
		$pUrl .= '&cat_id=' . $cat_id;
		$where .= " and (cat_id='$cat_id' or list_cat_id like '%|" . $cat_id . "|%')";
	} else if ($direct == 'movedown') {
		$lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	} else if ($direct == 'moveup') {
		$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	} else if ($direct == 'movebottom') {
		$lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
		$lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
		for ($i = 0; $i < count($lstItem); $i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
		}
	} else if ($direct == 'movetop') {
		$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
		$lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
		for ($i = 0; $i < count($lstItem); $i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
		}
	}
	header('Location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
	exit();
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Voucher";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$cat_id = (int) Input::get('cat_id', 0);
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = !empty($string) ? intval($core->decryptID($string)) : 0;

	$pUrl = '';
	if (intval($cat_id) != 0) {
		$pUrl .= '&cat_id=' . $cat_id;
	}
	if ($string = '' && $pvalTable == 0) {
		header('Location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
		exit();
	}
	/** Logs action */
	$clsLog = new Log();
	$type_log = 'Voucher';
	$pkeyTable_log = $pkeyTable;
	$pvalTable_log = $pvalTable;
	$title_log = "Xóa sản phẩm #" . $pvalTable;
	$intro_log = json_encode($clsClassTable->getOne($pvalTable));
	$clsLog->insertAction($type_log, $pkeyTable_log, $pvalTable_log, $title_log, $intro_log);
	/** End Logs action */
	if ($clsClassTable->doDelete($pvalTable)) {
		header('Location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=DeleteSuccess');
	}
}
function default_delete_image()
{
	global $smarty, $core, $_LANG_ID, $clsISO;
	$clsImage = new Image();
	$clsVoucher = new Voucher();
	$image_id = (int) Input::post('image_id', 0);
	$oneImage = $clsImage->getOne($image_id, "table_id,is_thumb");

	$msg = '_error';
	if ($clsImage->deleteOne($image_id)) {
		if ($oneImage['is_thumb']) {
			$clsVoucher->updateOne($oneImage['table_id'], array(
				'image' => "",
				'is_thumb' => 0
			));
		}
		$msg = '_success';
	}
	// Return
	echo $msg;
	die();
}
function default_open_view_image()
{
	global $smarty, $core, $_LANG_ID, $clsISO;
	$clsImage = new Image();
	$image_id = (int) Input::post('image_id', 0);

	$smarty->assign('core', $core);
	$smarty->assign('template', '_view');
	$smarty->assign('image_id', $image_id);
	$smarty->assign('clsImage', $clsImage);

	// Return
	$html = $core->build('image.tpl');
	echo $html;
	die();
}
function default_open_edit_image()
{
	global $smarty, $core, $_LANG_ID, $clsISO;
	$clsImage = new Image();
	$image_id = (int) Input::post('image_id', 0);

	$smarty->assign('core', $core);
	$smarty->assign('template', '_edit');
	$smarty->assign('image_id', $image_id);
	$smarty->assign('clsImage', $clsImage);

	// Return
	$html = $core->build('image.tpl');
	echo $html;
	die();
}
function default_save_edit_image()
{
	$clsImage = new Image();
	$image_id = (int) Input::post('image_id', 0);

	$msg = '_error';
	if ($clsImage->updateOne($image_id, array(
		'title' => Input::post('title')
	))) {
		$msg = '_success';
	}
	// Return
	echo $msg;
	die();
}
function default_open_tock_in()
{
	global $smarty, $core, $_LANG_ID, $clsISO;
	$clsStockIn = new StockIn();
	$clsVoucher = new Voucher();
	$clsProperty = new Property();
	$smarty->assign('clsStockIn', $clsStockIn);
	$smarty->assign('clsProperty', $clsProperty);

	$stock_id = (int) Input::post('stock_id', 0);
	$voucher_id = (int) Input::post('voucher_id', 0);
	$stock_in_id = (int) Input::post('stock_in_id', 0);
	$smarty->assign('stock_id', $stock_id);
	$smarty->assign('voucher_id', $voucher_id);
	$smarty->assign('stock_in_id', $stock_in_id);

	$unit_id = $clsVoucher->getOneField('unit', $voucher_id);
	$smarty->assign('unit_id', $unit_id);
	// Return
	$smarty->assign('core', $core);
	$html = $core->build('stock_in.tpl');
	echo $html;
	die();
}
function default_save_tock_in()
{
	global $smarty, $core, $_LANG_ID, $clsISO;
	$clsStock = new Stock();
	$clsStockIn = new StockIn();
	$stock_id = (int) Input::post('stock_id', 0);
	$stock_in_id = (int) Input::post('stock_in_id', 0);
	$voucher_id = (int) Input::post('voucher_id', 0);

	$date_id = Input::post('date_id');
	$time_id = Input::post('time_id');
	if (empty($time_id)) $time_id = "00:00";
	$quantily = (int) Input::post('quantily', 0);
	/** Get Total */
	$stock_total_in = $clsStock->getOneField('quantily', $stock_id);
	$stock_quantily = $clsStock->getOneField('quantily', $stock_id);
	$stock_quantily += $quantily;
	$stock_total_in += $quantily;

	$msg = '_error';
	if ($stock_in_id == 0) {
		$stock_in_id = $clsStockIn->getMaxId();
		if ($clsStockIn->insert(array(
			$clsStockIn->pkey => $stock_in_id,
			'stock_id' => $stock_id,
			'voucher_id' => $voucher_id,
			'code' => Input::post('code'),
			'note' => Input::post('note'),
			'date_id' => $clsISO->convertTextToTime($date_id, $time_id),
			'quantily' => $quantily,
			'user_id' => $core->_USER['user_id'],
			'reg_date' => time()
		))) {
			$msg = '_success';
			$clsStock->updateOne($stock_id, array(
				'quantily' => $stock_quantily,
				'total_in' => $stock_total_in
			));
		}
	} else {
	}
	// Return
	echo @json_encode(array(
		'msg' => $msg,
		'stock_id' =>  $stock_id,
		'voucher_id' => $voucher_id,
		'total_in' => $stock_total_in,
		'total_quantily' => $stock_quantily
	));
	die();
}
function default_open_tock_logs()
{
	global $smarty, $core, $_LANG_ID, $clsISO;
	$clsStock = new Stock();
	$clsVoucher = new Voucher();
	$clsStockIn = new StockIn();
	$smarty->assign('clsStock', $clsStock);
	$smarty->assign('clsStockIn', $clsStockIn);
	$smarty->assign('clsVoucher', $clsVoucher);

	$stock_id = (int) Input::post('stock_id', 0);
	$voucher_id = $clsStock->getOneField('voucher_id', $stock_id);
	$smarty->assign('stock_id', $stock_id);
	$smarty->assign('voucher_id', $voucher_id);
	$smarty->assign('template', '_manage');

	// Return
	$smarty->assign('core', $core);
	$html = $core->build('stock.logs.tpl');
	echo $html;
	die();
}
function default_load_list_stock_logs()
{
	global $smarty, $core, $_LANG_ID, $clsISO;
	$clsStockIn = new StockIn();
	$smarty->assign('clsStockIn', $clsStockIn);
	$stock_id = (int) Input::request('stock_id', 0);
	$smarty->assign('stock_id', $stock_id);
	$ipn_start_date = Input::request('start_date', 0);
	$ipn_due_date = Input::request('due_date', 0);


	$start_date = !empty($ipn_start_date)
		? strtotime($ipn_start_date) : 0;
	$due_date = !empty($ipn_due_date)
		? strtotime($ipn_due_date) : 0;
	$cond = "is_trash=0 and stock_id='{$stock_id}'";
	if ($start_date > 0 && $due_date == 0) {
		$cond .= " and date_id > '{$start_date}'";
	} elseif ($due_date > 0 && $due_date == 0) {
		$cond .= " and date_id < '{$due_date}'";
	} elseif ($start_date > 0 and $due_date > 0) {
		$cond .= " and (date_id between '{$start_date}' and '{$due_date}')";
	}
	/* Send Cond */

	#Begin pagiantiom
	$current_page = (int) Input::post('page', 1);
	$number_per_page = (int) Input::post('number_per_page', 10);
	$total_record = $clsStockIn->countItem($cond);
	$offset = ($current_page - 1) * $number_per_page;
	$limit = " limit {$offset},{$number_per_page}";
	#End

	//print_r($cond); die();
	$lstStock = $clsStockIn->getAll("{$cond} order by date_id desc" . $limit);
	$smarty->assign('lstStock', $lstStock);
	$smarty->assign('total_record', $total_record);
	$smarty->assign('current_page', $current_page);
	// Return
	$smarty->assign('core', $core);
	$smarty->assign('template', '_list');
	$tpl = $core->build('stock_list_logs.tpl');
	echo $tpl . '$$$' . $total_record . '$$$' . $number_per_page;
	die();
}
function default_load_images()
{
	global $smarty, $core, $dbconn, $_LANG_ID, $clsISO;
	$clsImage = new Image();
	$clsVoucher = new Voucher();

	$voucher_id = (int) Input::post('voucher_id', 0);
	$oneVoucher = $clsVoucher->getOne($voucher_id, "is_thumb,image");
	$list_images = $clsImage->getAll("is_trash=0 and table_id='{$voucher_id}' and type='_PRODUCT' order by is_thumb DESC,order_no DESC");
	$total_record = !empty($list_images) ? count($list_images) : 0;
	/** Update First Image*/
	if ($total_record > 0 && ($oneVoucher['is_thumb'] == 0 || empty($oneVoucher['image']))) {
		$one = $list_images[0];
		$clsImage->updateOne($one[$clsImage->pkey], array(
			'is_thumb' => 1
		));
		$clsVoucher->updateOne($voucher_id, array(
			'is_thumb' => 1,
			'image' => $one['image']
		));
	}
	/** End Update Image */
	$smarty->assign('core', $core);
	$smarty->assign('total_record', $total_record);
	$smarty->assign('list_images', $list_images);
	$smarty->assign('template', '_list');
	// Return
	$html = $core->build('image.tpl');
	echo json_encode(array(
		'html' => $html,
		'total_record' => $total_record
	));
	die();
}
function default_upload_images()
{
	global $core, $_LANG_ID, $clsISO;
	$clsImage = new Image();
	$clsVoucher = new Voucher();

	$user_id = $core->_USER['user_id'];
	$type = Input::post('type', '_PRODUCT');
	$table_id = (int) Input::post('table_id', 0);
	//var_dump($table_id); die();
	if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
		$images = $_FILES['images'];
		if (!empty($images['name'])) {
			$ii = 0; //Init
			for ($i = 0; $i < count($images); $i++) {
				$clsUploadFile = new UploadFile();
				$image = array();
				$image["name"] = $images['name'][$i];
				$image["type"] = $images['type'][$i];
				$image["tmp_name"] = $images['tmp_name'][$i];
				$image["error"] = $images['error'][$i];
				$image["size"] = $images['size'][$i];

				$up = '';
				$up = $clsUploadFile->uploadItem($image, "/content", "jpg,gif,png");
				if (!empty($up)) {
					$field = "user_id,table_id,type,image,order_no,reg_date";
					$value = "'{$user_id}','{$table_id}','{$type}','" . addslashes($up) . "'
					,'" . $clsImage->getMaxOrderNo($table_id, $type) . "','" . time() . "'";
					$clsImage->insertOne($field, $value, false);
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
function default_setup_voucher_image()
{
	global $core, $_LANG_ID, $clsISO;
	$clsImage = new Image();
	$clsVoucher = new Voucher();
	$image_id = (int) Input::post('image_id', 0);
	$voucher_id = (int) Input::post('voucher_id', 0);

	$msg = '_error';
	$image_url = $clsImage->getOneField('image', $image_id);
	if ($clsVoucher->updateOne($voucher_id, array('image' => $image_url))) {
		$msg = '_success';
		/** Reset is_thumb prev */
		if ($clsImage->updateByCond("type='_PRODUCT' and table_id='{$voucher_id}'", "is_thumb='0'")) {
			$clsImage->updateOne($image_id, array('is_thumb' => 1));
		}
		/** End */
	}
	// Return
	echo $msg;
	die();
}
function default_setting()
{
	// ini_set('display_errors', '1');
	// ini_set('display_startup_errors', '1');
	// error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsConfiguration, $oneSetting;
	$user_id = $core->_USER['user_id'];
	$type = Input::get('type', '');
	$assign_list["type"] = $type;
	$id = Input::get('id', 0);	
	$assign_list["id"] = $id;
	
	$currentTab = Input::get('step', '');
	$assign_list["currentTab"] = $currentTab;
	
	$tabInfo = [
		'supplier' => [
			'id'   => 'tabSupplier',
			'icon' => 'fa-solid fa-people-group',
			'name' => 'Suppliers'
		],
		'categories' => [
			'id'   => 'tabCategories',
			'icon' => 'fa-solid fa-table-cells',
			'name' => 'Categories'
		],
		// 'generalSetting' => [
		// 	'id'   => 'tabGeneralSetting',
		// 	'icon' => 'fa-solid fa-gear',
		// 	'name' => 'General Setting'
		// ],
		// 'codeTemplates' => [
		// 	'id'   => 'tabCodeTemplates',
		// 	'icon' => 'fa-solid fa-code',
		// 	'name' => 'Code Templates'
		// ],
		// 'importHistory' => [
		// 	'id'   => 'tabImportHistory',
		// 	'icon' => 'fa-solid fa-history',
		// 	'name' => 'Import History'
		// ],
		// 'usageRules' => [
		// 	'id'   => 'tabUsageRules',
		// 	'icon' => 'fa-solid fa-gavel',
		// 	'name' => 'Usage Rules'
		// ],
		// 'notificationTemplates' => [
		// 	'id'   => 'tabNotificationTemplates',
		// 	'icon' => 'fa-solid fa-bell',
		// 	'name' => 'Notification Templates'
		// ]
	];
	$assign_list["tabInfo"] = $tabInfo;


	$classAddNewButton = '';
	switch ($currentTab) {
		case 'supplier':
			$classAddNewButton = 'addNewVoucherSupplier';
			break;
		case 'categories':
			$classAddNewButton = 'addNewVoucherCategory';
			break;
		case 'generalSetting':
		case 'codeTemplates':
		case 'importHistory':
		case 'usageRules':
		case 'notificationTemplates':
			break;
		default:
			break;
	}
	$assign_list["classAddNewButton"] = $classAddNewButton;


	if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration') {
		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$clsConfiguration->updateValue($tmp[1], $val);
			}
		}

		header('location:' . PCMS_URL . '?mod=' . $mod . '&act=setting&message=updateSuccess');
	}
}

function default_edit_setting()
{
	
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core, $pvalTable,
		$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $show, $nextstep;
	$user_id = $core->_USER['user_id'];
	$type = Input::get('type', '');
	$assign_list["type"] = $type;
	
	$currentTab = Input::get('step', '');
	$assign_list["currentTab"] = $currentTab;
	
	
	$assign_list["clsModule"] = $clsModule;
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list["show"] = $show;
	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';


	$pvalTable = Input::get('id', 0);
	$assign_list["pvalTable"] = $pvalTable;
	$panel = Input::get('panel', '');
	$assign_list["panel"] = $panel;

	$currentstep = Input::get('step', 'generalinformation');
	$assign_list["currentstep"] = $currentstep;

	$currentstepx = 0;
	$frames = getFrame($pvalTable);
	//$clsISO->pre($oneTour);die;
	$ii = 0;
	$arrStep = array();
	foreach ($frames as $okey => $frame) {
		$steps = $frame['steps'];
		foreach ($steps as $key => $step) {
			$status = 0;
			$arrStep[$ii] = array(
				'key' => $key,
				'name' => $step['name'],
				'status' => $status,
				'description' => $step['description'] ?? ''
			);
			$frames[$okey]['steps'][$key]['status'] = $status;
			++$ii;
		}
	}
	/*if($profile_id==18696){
			die('ss');
		}*/
	$nextstep = $arrStep[$currentstepx + 1] ?? [];
	$assign_list["frames"] = $frames;
	$assign_list["nextstep"] = json_encode($nextstep);

	$classTable = "VoucherSupply";
	if($type == 'categories') {
		$classTable = "VoucherCat";
	}
	
	$clsClassTable = new $classTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	//var_dump($oneItem);die();

	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	$clsSupplier = new VoucherSupply();
	$assign_list["clsSupplier"] = $clsSupplier;

	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;

	$clsVoucher = new Voucher();
	$assign_list["clsVoucher"] = $clsVoucher;

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;

	$clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 5, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'easy_cancel', "", 'easy_cancel', 255, 25, 5, 1,  "style='width:100%'");

	if ($currentstep == 'seo') {
		$clsMeta = new Meta();
		$assign_list["clsMeta"] = $clsMeta;
		$linkMeta = $clsClassTable->getLink($pvalTable);
		$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
		$meta_id = $allMeta[0]['meta_id'];

		if (empty($meta_id)) {
			$introMeta = strip_tags(html_entity_decode(addslashes($oneItem['overview'])));
			$introMeta = explode('$trun$', wordwrap($introMeta, 280, '$trun$', false), 2);
			$introMeta = $introMeta[0] . (isset($introMeta[1]) ? '...' : '');
			$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id", "'" . $linkMeta . "','" . $oneItem['title'] . "','" . $introMeta . "','" . $oneItem['image'] . "','" . time() . "','" . time() . "','" . $clsMeta->getMaxId() . "'");
		}
	}
	$tabInfo = [
		'basic-information' => [
			'id'   => 'tabBasicInformation',
			'icon' => 'fa-solid fa-table-cells',
			'name' => 'Basic Information'
		],
		// 'commercial-terms' => [
		// 	'id'   => 'tabCommercialTerms',
		// 	'icon' => 'fa-solid fa-handshake',
		// 	'name' => 'Commercial Terms'
		// ],
		// 'voucher-code-rules' => [
		// 	'id'   => 'tabVoucherCodeRules',
		// 	'icon' => 'fa-solid fa-key',
		// 	'name' => 'Voucher & Code Rules'
		// ],
		// 'contact-operations' => [
		// 	'id'   => 'tabContactOperations',
		// 	'icon' => 'fa-solid fa-address-book',
		// 	'name' => 'Contact & Operations'
		// ],
		// 'integration' => [
		// 	'id'   => 'tabIntegration',
		// 	'icon' => 'fa-solid fa-puzzle-piece',
		// 	'name' => 'Integration'
		// ],
		// 'notes' => [
		// 	'id'   => 'tabNotes',
		// 	'icon' => 'fa-regular fa-note-sticky',
		// 	'name' => 'Notes'
		// ]
	];
	$assign_list["tabInfo"] = $tabInfo;
}

function default_load_list_voucher_search()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];

	$clsISO = new ISO();
	$clsVoucher = new Voucher();
	$cat_id = Input::post('cat_id', 0);
	$keySearch = Input::post('keySearch');
	$page = Input::post('page', 1);
	$rows = Input::post('rows', 10);
	$_data = array();
	$_results = array();
	#---
	$cond = "1=1";
	if ($cat_id > 0) {
		$cond .= " and (cat_id='{$cat_id}' or list_cat_id like '%|{$cat_id}|%')";
	}
	if (!empty($keySearch)) {
		$cond .= " and (title like '%{$keySearch}%' or slug like '%" . $core->replaceSpace($keySearch) . "%')";
	}
	#---
	$totalRecord = $clsVoucher->countItem($cond);
	$totalPage = ceil($totalRecord / $rows);
	$offset = ($page - 1) * $rows;
	$limit = " limit $offset,$rows";
	$order_by = " order by reg_date DESC";
	$_results['total'] = $totalRecord;
	#---
	$lstVoucher = $clsVoucher->getAll("{$cond} {$order_by} {$limit}");
	if (!empty($lstVoucher)) {
		foreach ($lstVoucher as $voucher) {
			$voucher_id = $voucher[$clsVoucher->pkey];
			$_data[] = array(
				'voucher_id'	=> $voucher_id,
				'button' => '<button type="button" class="btn btn-xs btn-default">' . $core->makeIcon('plus-circle') . '</button>',
				'image'	=> $clsISO->genIMG($voucher['image'], 36, 36, "padding:2px;"),
				'code'	=> $clsVoucher->getCode($voucher_id, $voucher),
				'name'	=> $clsVoucher->getTitle($voucher_id, $voucher),
				'price'	=> $clsVoucher->getPrice($voucher_id, true, $voucher) . ' ' . $clsISO->getRate()
			);
		}
	}
	$_results['rows'] = $_data;
	echo json_encode($_results);
	die();
}
function default_ajLoadCountry()
{
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsCountry = new Country();
	$chauluc_id = isset($_POST['chauluc_id']) ? intval($_POST['chauluc_id']) : 0;
	$khuvuc_id  = isset($_POST['khuvuc_id']) ? intval($_POST['khuvuc_id']) : 0;
	$country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
	#
	$cond       = "is_trash=0";
	if ($chauluc_id > 0) {
		$cond .= " and continent_id='$chauluc_id'";
	}
	if ($khuvuc_id > 0) {
		$cond .= " and khuvuc_id='$khuvuc_id'";
	}
	#
	if ($clsCountry->getAll($cond) != '') {
		$html   = "<option value='0'> -- " . $core->get_Lang('selectcountry') . " -- </option>";
		$rslist = $clsCountry->getAll($cond . " order by order_no asc", $clsCountry->pkey);
		if (is_array($rslist) && count($rslist) > 0) {
			foreach ($rslist as $k => $v) {
				$html .= '<option value="' . $v[$clsCountry->pkey] . '" ' . ($country_id == $v[$clsCountry->pkey] ? 'selected="selected"' : '') . '> -- ' . $clsCountry->getTitle($v[$clsCountry->pkey]) . ' -- </option>';
			}
			unset($rslist);
		}
	} else {
		$html = 'EMPTY';
	}
	echo $html;
	die();
}
function default_ajLoadRegion()
{
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsRegion  = new Region();
	#
	$country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
	$region_id  = isset($_POST['region_id']) ? intval($_POST['region_id']) : 0;
	#
	$cond       = "is_trash=0";
	if ($country_id > 0) {
		$cond .= " and country_id = '$country_id'";
	}
	if ($clsRegion->getAll($cond) != '') {
		$html = $clsRegion->makeSelectboxOption($country_id, $region_id);
	} else {
		$html = 'EMPTY';
	}
	echo $html;
	die();
}
function default_ajmakeSelectCityGlobal()
{
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsCity    = new City();
	$country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
	$region_id  = isset($_POST['region_id']) ? intval($_POST['region_id']) : 0;
	$city_id    = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;
	#
	$cond       = "is_trash=0";
	if ($country_id > 0) {
		$cond .= " and country_id='$country_id'";
	}
	if ($region_id > 0) {
		$cond .= " and region_id='$region_id'";
	}
	#
	$html = '<option value="0"> -- ' . $core->get_Lang('selectcity') . ' --</option>';
	if ($clsCity->getAll($cond) != '') {
		$lstCity = $clsCity->getAll($cond . " order by slug asc", $clsCity->pkey);
		if (!empty($lstCity)) {
			foreach ($lstCity as $k => $v) {
				$html .= '<option value="' . $v[$clsCity->pkey] . '" ' . ($city_id == $v[$clsCity->pkey] ? 'selected="selected"' : '') . '> -- ' . $clsCity->getTitle($v[$clsCity->pkey]) . ' -- </option>';
			}
			unset($lstCity);
		}
	} else {
		$html = 'EMPTY';
	}
	echo $html;
	die();
}
/*========= START TOUR LIST DESTINATION MOD ===========*/
function default_ajaxLoadVoucherDestination()
{
	//	ini_set('display_errors', '1');
	//ini_set('display_startup_errors', '1');
	//error_reporting(E_ALL);
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsVoucherDestination = new VoucherDestination();
	$clsContinent       = new Continent();
	$clsCountry         = new Country();
	$clsRegion          = new Region();
	$clsCity            = new City();
	$clsTour            = new Tour();
	$voucher_id            = $_POST['voucher_id'];
	$html               = '';
	#
	$lstDestination     = $clsVoucherDestination->getAll("is_trash=0 and voucher_id='$voucher_id' order by order_no asc");
	if (is_array($lstDestination) && count($lstDestination) > 0) {
		foreach ($lstDestination as $k => $v) {
			$title = '';
			if (intval($v['chauluc_id']) > 0) {
				$title .= ' &raquo; ' . $clsContinent->getTitle($v['chauluc_id']);
			}
			if (intval($v['area_id']) > 0) {
				$title .= ' &raquo; ' . $clsArea->getTitle($v['area_id']);
			}
			if (intval($v['country_id']) > 0) {
				$title .= ' &raquo; ' . $clsCountry->getTitle($v['country_id']);
			}
			if (intval($v['region_id']) > 0) {
				$title .= ' &raquo; ' . $clsRegion->getTitle($v['region_id']);
			}
			if (intval($v['city_id']) > 0) {
				$title .= ' &raquo; ' . $clsCity->getTitle($v['city_id']);
			}
			$html .= '<li style="cursor:move" id="order_' . $v[$clsVoucherDestination->pkey] . '"><strong><a href="javascript:void(0);" title="' . $core->get_Lang('Drag & drop change position') . '">' . $title . '</a></strong><span class="remove removeDestination" data="' . $v[$clsVoucherDestination->pkey] . '" onClick="removeDestination(this)">x</span></li>';
		}
		$html .= '
		<li style="cursor:pointer; width:90px; margin-top:10px;" class="ajRemoveAllDestinationInTour iso-button-primary" onClick="removeAllDestination(this)"><i class="fa fa-times-circle-o"></i> ' . $core->get_Lang('removeall') . '</li>';
		$html .= '
		<script type="text/javascript">
			$("#lstDestination").sortable({
				opacity: 0.8,
				cursor: \'move\',
				start: function(){
					vietiso_loading(1);
				},
				stop: function(){
					vietiso_loading(0);
				},
				update: function(){
					var order = $(this).sortable("serialize")+\'&update=update\';
					$.post(path_ajax_script+"/index.php?mod=voucher&act=ajUpdPosVoucherDestination", order, function(html){
						vietiso_loading(0);
					});
				}
			});
		</script>';
		unset($lstDestination);
	}
	echo $html;
	die();
}
function default_ajUpdPosVoucherDestination()
{
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTour            = new Tour();
	$clsVoucherDestination = new VoucherDestination();
	$order              = $_POST['order'];
	foreach ($order as $key => $val) {
		$key = $key + 1;
		$clsVoucherDestination->updateOne($val, "order_no='" . $key . "'");
	}
	//var_dump($order);die;
}
function default_ajaxAddMoreVoucherDestination()
{
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsVoucher            = new Voucher();
	$clsVoucherDestination = new VoucherDestination();
	#
	$chauluc_id         = isset($_POST['chauluc_id']) ? intval($_POST['chauluc_id']) : 0;
	$country_id         = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
	$region_id          = isset($_POST['region_id']) ? intval($_POST['region_id']) : 0;
	$city_id            = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;
	$voucher_id            = isset($_POST['voucher_id']) ? intval($_POST['voucher_id']) : 0;
	#
	$cond               = "is_trash=0";
	if ($chauluc_id > 0) {
		$cond .= " and chauluc_id='$chauluc_id'";
	}
	if ($country_id > 0) {
		$cond .= " and country_id='$country_id'";
	}
	if ($region_id > 0) {
		$cond .= " and region_id='$region_id'";
	}
	if ($city_id > 0) {
		$cond .= " and city_id='$city_id'";
	}
	if ($voucher_id > 0) {
		$cond .= " and voucher_id='$voucher_id'";
	}

	if ($clsVoucherDestination->getAll($cond) != '') {
		echo '_EXIST';
		die();
	} else {
		$f = "$clsVoucherDestination->pkey,voucher_id,country_id,region_id,city_id,order_no,val,chauluc_id";
		$v = "'" . $clsVoucherDestination->getMaxID() . "','$voucher_id','$country_id','$region_id','$city_id','" . $clsVoucherDestination->getMaxOrderNoByTable($voucher_id) . "','1','$chauluc_id'";
		if ($clsVoucherDestination->insertOne($f, $v)) {
			echo '_SUCCESS';
			die();
		} else {
			echo '_ERROR';
			die();
		}
	}
}
function default_ajaxDeleteVoucherDestination()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id             = $core->_USER['user_id'];
	#
	$clsVoucherDestination  = new VoucherDestination();
	$voucher_destination_id = $_POST['voucher_destination_id'];
	#
	$clsVoucherDestination->deleteOne($voucher_destination_id);
	echo (1);
	die();
}
function default_ajaxDeleteAllVoucherDestination()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id            = $core->_USER['user_id'];
	#
	$clsVoucherDestination = new VoucherDestination();
	$voucher_id            = $_POST['voucher_id'];
	#
	$clsVoucherDestination->deleteByCond("voucher_id='$voucher_id'");
	echo (1);
	die();
}
function default_category()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO;
	$user_id = $core->_USER['user_id'];

	#- End Check
	$assign_list["msg"]           = isset($_GET['message']) ? $_GET['message'] : '';
	$type_list                    = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"]     = $type_list;
	#
	$classTable                   = "VoucherCat";
	$clsClassTable                = new $classTable;
	$tableName                    = $clsClassTable->tbl;
	$pkeyTable                    = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"]     = $pkeyTable;
	$assign_list["clsVoucher"]       = new Voucher();
	#
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '&act=' . $act;
		if ($_POST['keyword'] != '' && $_POST['keyword'] != '') {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location:' . PCMS_URL . '/?mod=' . $mod . $link);
	}

	$cond = "1=1";
	#Filter By Keyword
	if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
		$cond .= " and slug like '%" . $core->replaceSpace($_GET['keyword']) . "%'";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$cond2 = $cond;
	if ($type_list == 'Trash') {
		$cond .= " and is_trash=1";
	}
	if ($type_list == 'Active') {
		$cond .= " and is_trash=0";
	}
	$orderBy                = " order by order_no asc";
	#
	$allItem                = $clsClassTable->getAll($cond . $orderBy);
	$assign_list["allItem"] = $allItem;
	unset($allItem);
	$assign_list["number_all"]   = $clsClassTable->getAll($cond2) ? count($clsClassTable->getAll($cond2)) : 0;
	$assign_list["number_trash"] = $clsClassTable->getAll($cond2 . " and is_trash=1") ? count($clsClassTable->getAll($cond2 . " and is_trash=1")) : 0;

	//Action
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	if ($action == 'Trash') {
		$string     = isset($_GET['voucher_cat_id']) ? ($_GET['voucher_cat_id']) : '';
		$voucher_cat_id = intval($core->decryptID($string));
		if ($string == '' && $voucher_cat_id == 0) {
			header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		if ($clsClassTable->updateOne($voucher_cat_id, "is_trash='1'")) {
			header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=TrashSuccess');
		}
	}
	if ($action == 'Restore') {
		$string     = isset($_GET['voucher_cat_id']) ? ($_GET['voucher_cat_id']) : '';
		$voucher_cat_id = intval($core->decryptID($string));
		if ($string == '' && $voucher_cat_id == 0) {
			header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		if ($clsClassTable->updateOne($voucher_cat_id, "is_trash='0'")) {
			header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=RestoreSuccess');
		}
	}
	if ($action == 'Delete') {
		$string     = isset($_GET['voucher_cat_id']) ? ($_GET['voucher_cat_id']) : '';
		$voucher_cat_id = intval($core->decryptID($string));
		if ($string == '' && $voucher_cat_id == 0) {
			header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		if ($clsClassTable->doDelete($voucher_cat_id)) {
			header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=DeleteSuccess');
		}
	}
	if ($action == 'move') {
		$string    = isset($_GET['voucher_cat_id']) ? ($_GET['voucher_cat_id']) : '';
		$pvalTable = intval($core->decryptID($string));
		#
		if ($string == '' && $pvalTable == 0) {
			header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		#
		$parent_id = isset($_GET['parent_id']) ? intval($_GET['parent_id']) : 0;
		$direct    = isset($_GET['direct']) ? $_GET['direct'] : '';
		$one       = $clsClassTable->getOne($pvalTable);
		$order_no  = $one['order_no'];

		$pUrl  = '&act=' . $act;
		$where = "is_trash=0";
		if ($parent_id > 0) {
			$where .= '&parent_id=' . $parent_id;
			$pUrl .= '&parent_id=' . $parent_id;
		}
		#
		if ($direct == 'moveup') {
			$lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no DESC limit 0,1");
			$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
			$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
		}
		if ($direct == 'movedown') {
			$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no ASC limit 0,1");
			$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
			$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
		}
		if ($direct == 'movetop') {
			$lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no asc LIMIT 0,1");
			$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
			$lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
			for ($i = 0; $i < count($lst); $i++) {
				$clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
			}
		}
		if ($direct == 'movebottom') {
			$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no desc LIMIT 0,1");
			$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
			$lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
			for ($i = 0; $i < count($lst); $i++) {
				$clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
			}
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
	}
}

function default_SiteVoucherCategory()
{
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#
	$clsVoucher       = new Voucher();
	$clsClassTable = new VoucherCat();
	#
	$user_id       = $core->_USER['user_id'];
	$voucher_cat_id    = isset($_POST['voucher_cat_id']) ? intval($_POST['voucher_cat_id']) : 0;
	$tp            = isset($_POST['tp']) ? $_POST['tp'] : '';
	#
	if ($tp == 'F') {
		$html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . ($voucher_cat_id == 0 ? $core->get_Lang('add') : $core->get_Lang('edit')) . ' ' . $core->get_Lang('vouchercategory') . '</h3>
		</div>';
		$html .= '
		<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('title') . ' <font color="red">*</font></div>
					<div class="fieldarea">
						<input class="text full required" name="title" value="' . $clsClassTable->getOneField('title', $voucher_cat_id) . '" type="text" autocomplete="off" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('intro') . '</div>
					<div class="fieldarea">
						<textarea  id="textarea_voucher_intro_editor_' . time() . '" class="textarea_voucher_intro_editor" name="intro" style="width:100%">' . $clsClassTable->getOneField('intro', $voucher_cat_id) . '</textarea>
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="button" voucher_cat_id="' . $voucher_cat_id . '" class="btn btn-primary btnClickToSubmitCategory">
				<i class="icon-ok icon-white"></i><span>' . $core->get_Lang('update') . '</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>Đóng lại</span> </button>		
		</div>';
		echo ($html);
		die();
	} elseif ($tp == 'S') {
		$titlePost = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
		$slugPost  = $clsISO->replaceSpace2($titlePost);
		$introPost = isset($_POST['intro']) ? addslashes($_POST['intro']) : '';
		#
		$clsISO->checkExistTitle($clsClassTable, $voucher_cat_id, $titlePost);
		if (intval($voucher_cat_id) == 0) {
			$listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no = $listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
			}
			$fx = "$clsClassTable->pkey,user_id,user_id_update,title,slug,intro,order_no,reg_date,upd_date";
			$vx = "'" . $clsClassTable->getMaxID() . "','$user_id','$user_id','$titlePost','$slugPost','" . addslashes($introPost) . "'";
			$vx .= ",'1','" . time() . "','" . time() . "'";
			#
			if ($clsClassTable->insertOne($fx, $vx)) {
				echo '_SUCCESS';
			} else {
				echo '_ERROR';
			}
		} else {
			$set = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',intro='" . addslashes($introPost) . "',upd_date='" . time() . "',user_id_update='" . $user_id . "'";
			if ($clsClassTable->updateOne($voucher_cat_id, $set)) {
				echo '_SUCCESS';
			} else {
				echo '_ERROR';
			}
		}
		die();
	}
}

/** Block */
function genCode($property_id)
{
	return '{{PRODUCT_EMBED_CODE_' . substr(md5(ENCRYPTION_KEY . $property_id), 0, 5) . '}}';
}
function default_block()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	global $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	$clsProperty = new Property();
	$assign_list['clsProperty'] = $clsProperty;

	$lstproperty = $clsProperty->getAll("property_type='_PRODUCT_BLOCK' order by order_no ASC");
	$assign_list['lstproperty'] = $lstproperty;
	$block_id = Input::get('block_id', $lstproperty[0][$clsProperty->pkey]);
	$assign_list['block_id'] = $block_id;
}
function default_load_voucher_search()
{
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
	$clsVoucher = new Voucher();
	$clsVoucherStore = new VoucherStore();

	$for_id = (int) Input::post('for_id');
	$voucher_type = Input::post('voucher_type');
	$keysearch = Input::request('keysearch');

	$cond = "is_trash=0 and is_online='1'";
	if (!empty($keysearch)) {
		$cond .= " and (
			title like '%{$keysearch}%' 
			or code like '%{$keysearch}%' 
			or slug like '%" . $core->replaceSpace($keysearch) . "%'
		)";
	}
	if ($for_id > 0 && !empty($voucher_type)) {
		$cond .= " and voucher_id not in (
			select voucher_id from " . $clsVoucherStore->tbl . " 
			where voucher_type='{$voucher_type}' and for_id='{$for_id}'
		)";
	}
	$number_per_page = 20;
	$current_page = (int) Input::post('page', 1);
	$total_record = $clsVoucher->countItem($cond);
	$total_page = ceil($total_record / $number_per_page);
	$offset = ($current_page - 1) * $number_per_page;
	$limit = " limit {$offset},{$number_per_page}";

	$field = "{$clsVoucher->pkey},title,slug,image,price";
	$tmp = $clsVoucher->getAll($cond . "order by order_no ASC" . $limit, $field);
	$html  = '<div class="single-suggest-result clear-ul" style="width:100% !important">
		<ul class="clear-ul">';
	if (!empty($tmp)) {
		foreach ($tmp as $voucher) {
			$voucher_id = $voucher[$clsVoucher->pkey];
			$html .= '<li onClick="add_voucher_store(this,' . $voucher_id . ',\'' . $for_id . '\',\'' . $voucher_type . '\')" class="page-select clearfix single-suggest-select">
					<div class="ui-stack ui-stack--alignment-center ui-stack--spacing-tight">
						<div class="ui-stack-item">
                            <div class="aspect-ratio aspect-ratio--square aspect-ratio--square--30">
                            	<img class="aspect-ratio__content" src="' . $voucher['image'] . '" alt="' . $voucher['title'] . '">
                            </div>
                        </div>
						<div class="ui-stack-item ui-stack-item--fill">
							' . $voucher['title'] . '
						</div>
						<div class="ui-stack-item">
							' . $core->get_Lang('Price') . ': <span class="type--warning">' . $clsISO->formatPrice($voucher['price']) . '</span>
						</div>
					</div>
				</li>';
		}
	}
	$html .= '</ul>
	</div>';
	// Return
	echo json_encode(array(
		'html' => $html,
		'total_page' => $total_page,
		'current_page' => $current_page,
		'next_page' => ($current_page < $total_page ? ($current_page + 1) : $total_page),
		'prev_page' => ($current_page > 1 ? ($current_page - 1) : 1)
	));
	die();
}
function default_add_voucher_store()
{
	global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;
	$user_id = $core->_USER['user_id'];
	$clsVoucherStore = new VoucherStore();

	$for_id = (int) Input::post('for_id', 0);
	$voucher_id = (int) Input::post('voucher_id', 0);
	$voucher_type = Input::post('voucher_type', '_GENERAL');

	$msg = '_error';
	if ($clsVoucherStore->checkAvailable($voucher_type, $for_id, $voucher_id)) {
		$msg = '_duplicate';
	} else {
		if ($clsVoucherStore->insert(array(
			'for_id' => $for_id,
			'user_id' => $user_id,
			'voucher_id' => $voucher_id,
			'voucher_type'	=> $voucher_type,
			'order_no'	=> $clsVoucherStore->getMaxOrderNo(),
			'reg_date'	=> time()
		))) {
			$msg = '_success';
		}
	}
	// Return
	echo $msg;
	die();
}
function default_ajOpenBlock()
{
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $core, $clsModule, $clsButtonNav, $oneSetting;
	$clsProperty = new Property();
	$user_id = $core->_USER['user_id'];
	$tp = Input::post('tp', "");
	if ($tp == 'F') {
		$titlePage = $core->get_Lang('AddnewBlock');
		$smarty->assign('titlePage', $titlePage);

		// Return
		$smarty->assign('core', $core);
		$html = $core->build('block.open.tpl');
		echo $html;
		die();
	} else {
		$gr = '_PRODUCT_BLOCK';
		$title = Input::post('title');
		$slug = $core->replaceSpace($title);
		$intro = Input::post('intro');

		$msg = '_error';
		if ($clsProperty->countItem("property_type='_PRODUCT_BLOCK' and slug='{$slug}'") > 0) {
			echo '_invalid';
			die();
		} else {
			$property_id = $clsProperty->getMaxId();
			$f = "property_id,property_type,title,slug,intro,embed_code,order_no";
			$v = "'{$property_id}','{$gr}','" . addslashes($title) . "','" . addslashes($slug) . "'
			,'" . addslashes($intro) . "','" . addslashes(genCode($property_id)) . "','" . $clsProperty->getMaxOrderNo() . "'";
			if ($clsProperty->insertOne($f, $v)) {
				$msg = '_success';
			}
		}
		// Return
		echo ($msg);
		die();
	}
}
function default_load_list_voucher_store()
{
	global $smarty, $_CONFIG, $dbconn, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	$clsVoucher = new Voucher();
	$clsVoucherStore = new VoucherStore();
	$clsVoucherCat = new VoucherCat();
	$smarty->assign('clsVoucher', $clsVoucher);
	$smarty->assign('clsVoucherCat', $clsVoucherCat);
	#
	$for_id = (int) Input::post('for_id', 0);
	$voucher_type = Input::post('voucher_type', '_GENERAL');
	$keyword = Input::post('keyword', "");
	$smarty->assign('for_id', $for_id);
	$smarty->assign('voucher_type', $voucher_type);

	$cond = "t1.is_trash=0 and t1.voucher_type='{$voucher_type}'";
	if (intval($for_id) > 0) {
		$cond .= " and for_id='{$for_id}'";
	}
	if ($keyword != '') {
		$slug = $core->replaceSpace($keyword);
		$cond .= " and (t2.slug like '%{$slug}%') ";
	}
	#
	$current_page = (int) Input::post('page', 1);
	$number_per_page = (int) Input::post('number_per_page', 15);
	$total_record = Query_Results::countItem("select count(1) as total_record from " . $clsVoucherStore->tbl . " as t1 
	inner join " . $clsVoucher->tbl . " as t2 on t1.voucher_id=t2.voucher_id where {$cond}", "total_record");
	$offset = ($current_page - 1) * $number_per_page;
	$limit = " limit {$offset},{$number_per_page}";
	$order_by = " order by order_no asc";

	$lstItem = $dbconn->getAll("select t1.*,t2.image,t2.title,t2.price,t2.cat_id from " . $clsVoucherStore->tbl . " as t1 
	inner join " . $clsVoucher->tbl . " as t2 on t1.voucher_id=t2.voucher_id where {$cond}" . $order_by . $limit);
	$smarty->assign('lstItem', $lstItem);
	$smarty->assign('current_page', $current_page);
	$smarty->assign('total_record', $total_record);
	// Return 
	$smarty->assign('core', $core);
	$html = $core->build('block.table.tpl');
	echo json_encode(array(
		'html' => $html,
		'total_record' => $total_record,
		'number_per_page' => $number_per_page
	));
	die();
}
function default_delete_voucher_store()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	$clsVoucherStore = new VoucherStore();
	$voucher_store_id = (int) Input::post('voucher_store_id', 0);
	$clsVoucherStore->deleteOne($voucher_store_id);
	// Return
	echo (1);
	die();
}
function default_move_voucher_store()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsVoucherStore = new VoucherStore();
	$for_id = (int) Input::post('for_id', 0);
	$voucher_type = Input::post('voucher_type');
	$voucher_store_id = (int) Input::post('voucher_store_id', 0);
	$direct = Input::post('direct', "up");
	/**/
	$order_no = $clsVoucherStore->getOneField('order_no', $voucher_store_id);
	$where = "is_trash=0 and for_id='{$for_id}' and voucher_type='{$voucher_type}'";
	if ($direct == 'moveup') {
		$lst = $clsVoucherStore->getAll($where . " and order_no<'{$order_no}' order by order_no DESC limit 0,1");
		$clsVoucherStore->updateOne($voucher_store_id, "order_no='" . $lst[0]['order_no'] . "'");
		$clsVoucherStore->updateOne($lst[0][$clsVoucherStore->pkey], "order_no='{$order_no}'");
	}
	if ($direct == 'movedown') {
		$lst = $clsVoucherStore->getAll($where . " and order_no>'{$order_no}' order by order_no ASC limit 0,1");
		$clsVoucherStore->updateOne($voucher_store_id, "order_no='" . $lst[0]['order_no'] . "'");
		$clsVoucherStore->updateOne($lst[0][$clsVoucherStore->pkey], "order_no='{$order_no}'");
	}
	if ($direct == 'movetop') {
		$lst = $clsVoucherStore->getAll($where . " and order_no<'{$order_no}' order by order_no asc limit 0,1");
		$clsVoucherStore->updateOne($voucher_store_id, "order_no='" . $lst[0]['order_no'] . "'");
		unset($lst);
		$lst = $clsVoucherStore->getAll($where . " and voucher_store_id<>'{$voucher_store_id}' and order_no<'{$order_no}' order by order_no asc");
		if (is_array($lst) && count($lst) > 0) {
			foreach ($lst as $k => $v) {
				$clsVoucherStore->updateOne($v[$clsVoucherStore->pkey], "order_no='" . ($v['order_no'] + 1) . "'");
			}
		}
	}
	if ($direct == 'movebottom') {
		$lst = $clsVoucherStore->getAll($where . " and order_no>'{$order_no}' order by order_no desc limit 0,1");
		$clsVoucherStore->updateOne($voucher_store_id, "order_no='" . $lst[0]['order_no'] . "'");
		unset($lst);
		$lst = $clsVoucherStore->getAll($where . " and voucher_store_id<>'{$voucher_store_id}' and order_no>'{$order_no}' order by order_no DESC");
		if (is_array($lst) && count($lst) > 0) {
			foreach ($lst as $k => $v) {
				$clsVoucherStore->updateOne($v[$clsVoucherStore->pkey], "order_no='" . ($v['order_no'] - 1) . "'");
			}
		}
	}
	echo (1);
	die();
}
function default_ajInitTSysVoucherGallery()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	#
	$clsImage = new Image();
	$table_id = $_POST['table_id'];
	$type = 'Voucher';
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
						url: path_ajax_script+"/index.php?mod=voucher&act=ajOpenVoucherGallery",
						data: {\'tp\':\'D\', \'image_id\': $_this.attr(\'data\')},
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
				var $image_id = $_this.attr(\'data\');
				var $table_id = $_this.attr(\'table_id\');
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod=voucher&act=ajOpenVoucherGallery",
					data: {\'tp\':\'C\',\'image_id\' : $image_id,\'table_id\' : $table_id},
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
					url: path_ajax_script+"/index.php?mod=voucher&act=ajOpenVoucherGallery",
					data: {
						\'image_id\' : $_this.attr(\'data\'),
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
					url: path_ajax_script+"/index.php?mod=voucher&act=ajOpenVoucherGallery",
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
			var $clsTable = \'Image\';
			var $type= \'Voucher\';
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
				url: path_ajax_script+"/index.php?mod=voucher&act=ajOpenVoucherGallery",
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

function default_ajOpenVoucherGallery()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn;
	#
	$clsPagination = new Pagination();
	$clsImage = new Image();
	$pkeyTable = $clsImage->pkey;

	$image_id = isset($_POST['image_id']) ? intval($_POST['image_id']) : 0;
	$table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
	$type = 'Voucher';
	$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	// Load List
	if ($tp == 'L') {
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$number_per_page = isset($_POST['number_per_page']) ? intval($_POST['number_per_page']) : 10;
		//echo $number_per_page; die();
		#
		$cond = "is_trash=0 and type='$type' and table_id='$table_id'";
		if (trim($keyword) != '' && $keyword != '0') {
			$slug = $core->replaceSpace($keyword);
			$cond .= " and (title like '%$keyword%' or slug like '%$slug%')";
		}
		#
		$totalRecord = $clsImage->getAll($cond) ? count($clsImage->getAll($cond)) : 0;
		$pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
		#
		$offset = ($page - 1) * $number_per_page;
		$order_by = " ORDER BY order_no asc";
		$limit = " LIMIT $offset,$number_per_page";

		$lstItem = $clsImage->getAll($cond . $order_by . $limit);
		if (!empty($lstItem)) {
			for ($i = 0; $i < count($lstItem); $i++) {
				$image_id = $lstItem[$i][$clsImage->pkey];
				#
				$html .= '<tr style="cursor:move" id="order_' . $image_id . '" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
				$html .= '<td class="index2">' . ($offset + $i + 1) . '</td>';
				$html .= '<td width="85px"><a href="javascript:void();" data="' . $image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><img src="' . $ftp_abs_path_image . $lstItem[$i]['image'] . '" width="75" height="50" /></a></td>';
				$html .= '<td>
				
				<input class="editTitleImage full-width" style="max-width:200px" data="' . $image_id . '" table_id="' . $table_id . '" value="' . $clsImage->getTitle($image_id) . '" style="line-height:28px; font-size:12px; padding:0 10px" />
				<a style="display:none" href="javascript:void(0);" data="' . $image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><strong>' . $clsImage->getTitle($image_id) . '</strong></a>
				
				</td>';
				$html .= '<td class="hiden767" style="text-align:right;color:#c00000">' . date('d-m-Y h:i', $lstItem[$i]['reg_date']) . '</td>';
				$html .= '
				<td style="vertical-align:middle; width:6%;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button> 
						<ul class="dropdown-menu">
							<li><a href="javascript:void(0);" data="' . $image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><i class="icon-edit"></i> ' . $core->get_Lang('edit') . '</a></li>
							<li><a href="javascript:void(0);" table_id="' . $table_id . '" data="' . $image_id . '" title="' . $core->get_Lang('delete') . '" class="ajdeletePhotosGallery"><i class="icon-remove"></i> ' . $core->get_Lang('delete') . '</a></li>
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
						$.post(path_ajax_script+"/index.php?mod=voucher&act=ajUpdPosVoucherGallery", order, function(html){
							loadTableGallery(voucher_id, \'\', page, 10);
							vietiso_loading(0);
						});
					}
				});
				
				$(".editTitleImage").live("change", function() {
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script + "/?mod=" + mod + "&act=ajOpenVoucherGallery",
					data: {
						"table_id": $_this.attr("table_id"),
						"image_id": $_this.attr("data"),
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
		$clsImage->deleteOne($image_id);
		echo (1);
		die();
	}
	// Quick Create
	else if ($tp == 'Q') {
		$fx = "table_id,order_no,reg_date";
		$vx = "'$table_id','" . $clsImage->getMaxOrderNoByVoucher($table_id) . "','" . time() . "'";
		$clsImage->insertOne($fx, $vx);
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
					<input type="text" name="title" class="text full required" style="width:100%" value="' . $clsImage->getTitle($image_id) . '">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						<img src="' . $clsImage->getOneField('image', $image_id) . '" id="isoman_show_image_val" />
						<input type="hidden" id="isoman_hidden_image_val" name="isoman_url_image" value="' . $clsImage->getOneField('image', $image_id) . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image_val" isoman_val="' . $clsImage->getOneField('image', $image_id) . '" isoman_name="image">
							<i class="iso-edit"></i>
						</a>';
		if ($clsImage->getOneField('image', $image_id) != '') {
			$HTML .= '<a pvalTable="' . $image_id . '" clsTable="Image" href="javascript:void()" title="' . $core->get_Lang('delete') . '" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a> ';
		}
		$HTML .= '</div>
				</td>
			</tr>
		</table>
		<div class="clear"><br />
		<div>840 x 420 ( W x h )</div>
		</div>';
		$HTML .= '<div class="modal-footer wrap">
					<a href="javascript:void(0);" class="iso-button-standard submitClick fr btnClickUpdate" image_id="' . $image_id . '" table_id="' . $table_id . '" ><img align="absmiddle" src="' . URL_IMAGES . '/v2/check.png"> ' . $core->get_Lang('save') . '</a>
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
						url: path_ajax_script+"/index.php?mod=voucher&act=ajOpenVoucherGallery",
						data : {\'tp\':\'S\',\'image_id\': $_this.attr(\'image_id\')},
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
			if ($clsImage->updateOne($image_id, $set)) {
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
		$one = $clsImage->getOne($image_id);
		$table_id = $one['table_id'];
		$order_no = $one['order_no'];
		#
		$where = "table_id='$table_id'";
		if ($direct == 'moveup') {
			$lst = $clsImage->getAll($where . " and order_no>$order_no order by order_no asc limit 0,1");
			$clsImage->updateOne($image_id, "order_no='" . $lst[0]['order_no'] . "'");
			$clsImage->updateOne($lst[0][$clsImage->pkey], "order_no='" . $order_no . "'");
		}
		if ($direct == 'movedown') {
			$lst = $clsImage->getAll($where . " and order_no<$order_no order by order_no desc limit 0,1");
			$clsImage->updateOne($image_id, "order_no='" . $lst[0]['order_no'] . "'");
			$clsImage->updateOne($lst[0][$clsImage->pkey], "order_no='" . $order_no . "'");
		}
		if ($direct == 'movetop') {
			$lst = $clsImage->getAll($where . " and order_no>$order_no order by order_no asc");
			$clsImage->updateOne($image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
			$lst = $clsImage->getAll($where . "$pkeyTable <> '$image_id' and order_no>$order_no order by order_no asc");
			if (!empty($lst)) {
				for ($i = 0; $i < count($lst); $i++) {
					$clsImage->updateOne($lst[$i][$clsImage->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
				}
				unset($lst);
			}
		}
		if ($direct == 'movebottom') {
			$lst = $clsImage->getAll($where . " and type='$type' and order_no<$order_no order by order_no desc");
			$clsImage->updateOne($image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
			$lst = $clsImage->getAll($where . "$pkeyTable <> '$image_id' and order_no<$order_no order by order_no desc");
			if (!empty($lst)) {
				for ($i = 0; $i < count($lst); $i++) {
					$clsImage->updateOne($lst[$i][$clsImage->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
				}
				unset($lst);
			}
		}
		echo (1);
		die();
	} else if ($tp == 'TOTAL') {
		echo $clsImage->getAll("is_trash=0 and table_id='$table_id'") ? count($clsImage->getAll("is_trash=0 and table_id='$table_id'")) : 0;
		die();
	} else if ($tp == 'SYS') {
		$LISTALL = $clsImage->getAll("is_trash=0 and type='$type' and table_id='$table_id' order by image_id asc");
		if (!empty($LISTALL)) {
			for ($i = 0; $i < count($LISTALL); $i++) {
				$clsImage->updateOne($LISTALL[$i][$clsImage->pkey], "order_no='" . ($i + 1) . "'");
			}
			unset($LISTALL);
		}
		echo (1);
		die();
	}
	echo (1);
	die();
}
function default_ajUpdPosVoucherGallery()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsImage = new Image();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach ($order as $key => $val) {
		$key = (($currentPage - 1) * $recordPerPage + $key + 1);
		$clsImage->updateOne($val, "order_no='" . $key . "'");
	}
}

function default_ajUpdPosSortVoucherSupplier()
{
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	$cls = new VoucherSupply();
	updateVoucherOrder($cls);
}
function default_ajUpdPosSortVoucherCategory()
{
	$clsVoucherCat = new VoucherCat();
	updateVoucherOrder($clsVoucherCat);
}
function default_ajUpdPosSortVoucher()
{	
	global $core;
    $clsVoucher = new Voucher();
	updateVoucherOrder($clsVoucher);
    
}

function updateVoucherOrder($class='') {
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	$order = isset($_POST['order']) && is_array($_POST['order'])
        ? $_POST['order']
        : [];

    $currentPage = isset($_POST['currentPage'])
        ? max(1, (int)$_POST['currentPage'])
        : 1;

    $recordPerPage = isset($_POST['recordPerPage'])
        ? max(1, (int)$_POST['recordPerPage'])
        : 20;

    if (empty($order)) {
        echo '_EMPTY';
        die();
    }

    $voucherIds = [];

    foreach ($order as $voucherId) {
        $voucherId = (int)$voucherId;

        if ($voucherId > 0) {
            $voucherIds[] = $voucherId;
        }
    }

    if (empty($voucherIds)) {
        echo '_EMPTY';
        die();
    }

    /*
     * Danh sách đang hiển thị:
     * ORDER BY order_no DESC, hotel_id DESC
     *
     * Vì vậy dòng trên cùng phải có order_no lớn nhất.
     */
    $pageStartOrder = ($currentPage - 1) * $recordPerPage;
    $totalOnPage = count($voucherIds);

    foreach ($voucherIds as $index => $voucherId) {
        /*
         * Trang 1:
         * dòng đầu = 20, dòng cuối = 1
         *
         * Trang 2:
         * dòng đầu = 40, dòng cuối = 21
         */
        $orderNo = $pageStartOrder + ($totalOnPage - $index);

        $class->updateOne(
            $voucherId,
            "order_no='{$orderNo}'"
        );
    }

    echo '_SUCCESS';
    die();
}
require_once(DIR_MODULES . '/voucher/mod_default.php');
