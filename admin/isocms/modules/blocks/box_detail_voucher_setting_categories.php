<?php 
	// ini_set('display_errors', '1');
	// ini_set('display_startup_errors', '1');
	// error_reporting(E_ALL);
	global $smarty,$core,$pvalTable,$meta_id;
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
	global $clsModule, $clsButtonNav, $dbconn, $clsISO;

	$clsISO = new ISO();
	$smarty->assign("clsISO", $clsISO); 
	$clsMeta = new Meta();
	$smarty->assign("clsMeta", $clsMeta);
	$oneMeta = $clsMeta->getOne($meta_id); 
	$clsSupplier = new VoucherSupply();
	$smarty->assign("clsSupplier", $clsSupplier);

	$smarty->assign("oneMeta", $oneMeta);

	$classTable                   = "VoucherCat";
	$clsClassTable                = new $classTable;
	$tableName                    = $clsClassTable->tbl;
	$pkeyTable                    = $clsClassTable->pkey;
	$smarty->assign("clsClassTable", $clsClassTable);
	$smarty->assign("pkeyTable", $pkeyTable);
	$clsVoucher = new Voucher();
	$smarty->assign("clsVoucher", $clsVoucher);
	
	$number_word_title=$clsISO->getCountMetaWord($clsMeta->getMetaTitle($meta_id));
	$smarty->assign('number_word_title', $number_word_title);
	$number_word_description=$clsISO->getCountMetaWord($clsMeta->getMetaDescription($meta_id));
	$smarty->assign('number_word_description', $number_word_description);

	$op_status = array(
		'1' => 'Active',
		'2' => 'Inactive'
	);
	$smarty->assign("op_status", $op_status);


	$startCurrentMonth = strtotime(date('Y-m-01 00:00:00'));
	$startNextMonth = strtotime('+1 month', $startCurrentMonth);
	$startPrevMonth = strtotime('-1 month', $startCurrentMonth);

	/* =========================
	* TOTAL VOUCHER
	* ========================= */

	$totalCategory = count($clsClassTable->getAll(
		"is_trash=0
		and reg_date >= {$startCurrentMonth}
		and reg_date < {$startNextMonth}", 
		$clsClassTable->pkey
	));
	
	$totalCategoryPrev = count($clsClassTable->getAll(
		"is_trash=0
		and reg_date >= {$startPrevMonth}
		and reg_date < {$startCurrentMonth}", 
		$clsClassTable->pkey
	));
	
	$totalPercent = getPercentChange(
		$totalCategory,
		$totalCategoryPrev
	);
	$smarty->assign("totalCategory", $totalCategory);
	$smarty->assign("totalPercent", $totalPercent);

	$totalActiveCategory = count($clsClassTable->getAll(
		"is_trash=0
		and is_online=1
		and reg_date >= {$startCurrentMonth}
		and reg_date < {$startNextMonth}", 
		$clsClassTable->pkey
	));
	
	$totalActiveCategoryPrev = count($clsClassTable->getAll(
		"is_trash=0
		and is_online=1
		and reg_date >= {$startPrevMonth}
		and reg_date < {$startCurrentMonth}", 
		$clsClassTable->pkey
	));
	
	$totalActivePercent = getPercentChange(
		$totalActiveCategory,
		$totalActiveCategoryPrev
	);
	$smarty->assign("totalActiveCategory", $totalActiveCategory);
	$smarty->assign("totalActivePercent", $totalActivePercent);

	$totalInactiveCategory = count($clsClassTable->getAll(
		"is_trash=0
		and is_online=0
		and reg_date >= {$startCurrentMonth}
		and reg_date < {$startNextMonth}", 
		$clsClassTable->pkey
	));
	
	$totalInactiveCategoryPrev = count($clsClassTable->getAll(
		"is_trash=0
		and is_online=0
		and reg_date >= {$startPrevMonth}
		and reg_date < {$startCurrentMonth}", 
		$clsClassTable->pkey
	));
	
	$totalInactivePercent = getPercentChange(
		$totalInactiveCategory,
		$totalInactiveCategoryPrev
	);
	$smarty->assign("totalInactiveCategory", $totalInactiveCategory);
	$smarty->assign("totalInactivePercent", $totalInactivePercent);

	$totalVoucherUsing = count($clsVoucher->getAll(
		"is_trash=0
		and is_online=1
		and reg_date >= {$startCurrentMonth}
		and reg_date < {$startNextMonth}", 
		$clsVoucher->pkey
	));
	
	$totalVoucherUsingPrev = count($clsVoucher->getAll(
		"is_trash=0
		and is_online=1
		and reg_date >= {$startPrevMonth}
		and reg_date < {$startCurrentMonth}", 
		$clsVoucher->pkey
	));
	
	$totalVoucherUsingPercent = getPercentChange(
		$totalVoucherUsing,
		$totalVoucherUsingPrev
	);
	$smarty->assign("totalVoucherUsing", $totalVoucherUsing);
	$smarty->assign("totalVoucherUsingPercent", $totalVoucherUsingPercent);



	$cat_id = (int) Input::get('cat_id', 0);
	$type_id = (int) Input::get('type_id', 0);
	$supplier_id = (int) Input::get('supplier_id', 0);
	$option_status = Input::get('option_status', 0);
	$keyword = Input::get('keyword', "");
	$type = !empty($_GET["type"]) ? $_GET["type"] : "";
	$smarty->assign("cat_id", $cat_id);
	$smarty->assign("type_id", $type_id);
	$smarty->assign("keyword", $keyword);
	$smarty->assign("supplier_id", $supplier_id);
	$smarty->assign("type", $type);
	$smarty->assign("option_status", $option_status);
	/*Get type of list news*/
	$type_list = Input::get('type_list');
	$smarty->assign("type_list", $type_list);
	//var_dump($supplier_id); die();

	//Action
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	if ($action == 'Trash') {
		$string     = isset($_GET['voucher_cat_id']) ? ($_GET['voucher_cat_id']) : '';
		$voucher_cat_id = intval($core->decryptID($string));
		if ($string == '' && $voucher_cat_id == 0) {
			header('location:' . PCMS_URL . '/' . $mod . '/' . $act . '/categories?message=NotPermission');
			exit();
		}
		if ($clsClassTable->updateOne($voucher_cat_id, "is_trash='1'")) {
			header('location:' . PCMS_URL . '/' . $mod . '/' . $act . '/categories?message=TrashSuccess');
		}
	}
	if ($action == 'Restore') {
		$string     = isset($_GET['voucher_cat_id']) ? ($_GET['voucher_cat_id']) : '';
		$voucher_cat_id = intval($core->decryptID($string));
		if ($string == '' && $voucher_cat_id == 0) {
			header('location:' . PCMS_URL . '/' . $mod . '/' . $act . '/categories?message=NotPermission');
			exit();
		}
		if ($clsClassTable->updateOne($voucher_cat_id, "is_trash='0'")) {
			header('location:' . PCMS_URL . '/' . $mod . '/' . $act . '/categories?message=RestoreSuccess');
		}
	}
	if ($action == 'Delete') {
		$string     = isset($_GET['voucher_cat_id']) ? ($_GET['voucher_cat_id']) : '';
		$voucher_cat_id = intval($core->decryptID($string));
		if ($string == '' && $voucher_cat_id == 0) {
			header('location:' . PCMS_URL . '/' . $mod . '/' . $act . '/categories?message=NotPermission');
			exit();
		}
		if ($clsClassTable->doDelete($voucher_cat_id)) {
			header('location: ' . PCMS_URL . '/' . $mod . '/' . $act . '/categories?message=DeleteSuccess');
		}
	}
    $params = [];
	if(!empty($type_list)) {
		$params['type_list'] = $type_list;
	}
	$pUrl = '';
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$cat_id = (int) Input::post('voucher_cat_id', 0);
		$type_id = (int) Input::post('type_id', 0);
		$supplier_id = (int) Input::post('supplier_id', 0);
		$keyword = Input::post('keyword');
		$option_status = Input::post('option_status', '');

		if ($type) {
			$params['type'] = $type;
		}

		if ($cat_id > 0) {
			$params['cat_id'] = $cat_id;
		}

		if ($type_id > 0) {
			$params['type_id'] = $type_id;
		}

		if ($supplier_id > 0) {
			$params['supplier_id'] = $supplier_id;
		}

		if ($option_status > 0) {
			$params['option_status'] = $option_status;
		}

		if (!empty($keyword)) {
			$params['keyword'] = $keyword;
		}

		$link = !empty($params) ? '?' . http_build_query($params) : '';
		

		header('Location: ' . PCMS_URL . '/voucher/setting/categories' . $link);
		exit();
	}

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
	$smarty->assign("pUrl", $pUrl);
	#Filter By Keyword
	if (!empty($keyword)) {
		$cond .= " and (title like '%{$keyword}%'   
			or slug like '%" . $core->replaceSpace($keyword) . "%'
		)";
	}
	$cond2 = $cond;
	if (!empty($type_list)) {
		if ($type_list == 'Publish') {
			$cond .= " and is_trash=0 and is_online=1";
		} else if ($type_list == 'Trash') {
			$cond .= " and is_trash=1";
		}
		else if ($type_list == 'Private') {
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
	$smarty->assign('link_page_current', $link_page_current);
	#
	$link_page_current_2 = '';
	for ($i = 0; $i < count($lst_query_string); $i++) {
		$tmp = explode('=', $lst_query_string[$i]);
		if ($tmp[0] != 'page' && $tmp[0] != 'vpc_status')
			$link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
	}
	$smarty->assign('link_page_current_2', $link_page_current_2);
	$config = array(
		'total'	=> $total_record,
		'current_page'	=> $current_page,
		'number_per_page'	=> $recordPerPage,
		'link'	=> PCMS_URL . '/index.php' . $link_page_current_2
	);
	$clsPagination = new Pagination();
	$clsPagination->initianize($config);
	$html_pager = $clsPagination->create_links();
	$smarty->assign("html_pager", $html_pager);
	#
	$offset = ($current_page - 1) * $recordPerPage;
	$limit = " limit {$offset},{$recordPerPage}";
	#-------End Page Divide-----------------------------------------------------------
	$allItem = [];
	$sql = "";
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);

	$smarty->assign("allItem", $allItem);
	#
	$allAll = $clsClassTable->getAll($cond2, $clsClassTable->pkey);
    $smarty->assign("number_all", count($allAll) ?? 0);

	$allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2, $clsClassTable->pkey);
    $smarty->assign("number_trash", count($allTrash) ?? 0);

	$allPublish = $clsClassTable->getAll("is_trash=0 and is_online=1 and " . $cond2, $clsClassTable->pkey);
    $smarty->assign("number_publish", count($allPublish) ?? 0);

	$allPrivate = $clsClassTable->getAll("is_trash=0 and is_online=0 and " . $cond2, $clsClassTable->pkey);
    $smarty->assign("number_private", count($allPrivate) ?? 0);

	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : ADMIN_PAGINATION;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";

    $totalRecord = $clsClassTable->getAll($cond, $clsClassTable->pkey);
    $totalRecord = $totalRecord ? count($totalRecord) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $smarty->assign("totalRecord", $totalRecord);
    $smarty->assign("recordPerPage", $recordPerPage);
    $smarty->assign("totalPage", $totalPage);
    $smarty->assign("currentPage", $currentPage);
    $smarty->assign("showingStart", $totalRecord > 0 ? $start_limit + 1 : 0);
    $smarty->assign("showingEnd", min($start_limit + $recordPerPage, $totalRecord));
    $listPageNumber = array();
    for ($i = 1; $i <= $totalPage; $i++) {
        $listPageNumber[] = $i;
    }
    $smarty->assign("listPageNumber", $listPageNumber);
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $link_page_current = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page')
            $link_page_current .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $smarty->assign("link_page_current", $link_page_current);
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $smarty->assign("link_page_current_2", $link_page_current_2);
	
	// $smarty->assign('assign_list',$assign_list);
?>