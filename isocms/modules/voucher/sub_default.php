<?php
function default_default()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $clsISO, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $deviceType, $package_id, $min_price_value, $max_price_value;

	$clsVoucher = new Voucher();
	$assign_list["clsVoucher"] = $clsVoucher;
	$clsVoucherCategory = new VoucherCat();
	$assign_list["clsVoucherCategory"] = $clsVoucherCategory;
	$clsVoucherDestination = new VoucherDestination();
	$assign_list["clsVoucherDestination"] = $clsVoucherDestination;
	$clsStock = new Stock();
	$assign_list["clsStock"] = $clsStock;
	$clsCity = new City();
	$assign_list["clsCity"] = $clsCity;
	$clsReviews = new Reviews();
	$assign_list["clsReviews"] = $clsReviews;
	$clsPagination = new Pagination();
	$assign_list["clsPagination"] = $clsPagination;
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$type = !empty($_GET["type"]) ? $_GET['type'] : '';
	$cat_id = 0;
	if ($show == 'Cat') {
		$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
		$cat_id = $clsVoucherCategory->getBySlugOnline($slug);
		if (empty($cat_id)) {
			header('Location:/404/');
			exit();
		}
		$assign_list["cat_id"] = $cat_id;
	}

	$cond = '';
	$orderBy = '';

	$lstVoucherCat = $clsVoucherCategory->getAll($cond . $orderBy, $clsVoucherCategory->pkey . ',title');
	$assign_list["lstVoucherCat"] = $lstVoucherCat ?? [];
	$cond = "is_trash=0 and is_online=1 and type = '$type'";

	if ($cat_id > 0) {
		$cond .= " and cat_id='$cat_id'";
	}

	$orderBy = " order by order_no asc";

	if ($deviceType == 'tablet') {
		$recordPerPage = 14;
	} else {
		$recordPerPage = 12;
	}

	$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;

	$listpriceMaxMin = $clsVoucher->getAll($cond, "max(price) as max,min(price) as min");
	$min_price_value = $listpriceMaxMin[0]['min'];
	$max_price_value = $listpriceMaxMin[0]['max'];
	$voucher_cat_id = isset($_GET['voucher_cat_id']) ? $_GET['voucher_cat_id'] : 0;
	$min_price_search = isset($_GET['min_price']) ? $_GET['min_price'] : $min_price_value;
	$max_price_search = isset($_GET['max_price']) ? $_GET['max_price'] : $max_price_value;

	$assign_list["min_price_value"] = $min_price_value;
	$assign_list["max_price_value"] = $max_price_value;
	$assign_list["min_price_search"] = $min_price_search;
	$assign_list["max_price_search"] = $max_price_search;

	if ($min_price_search > 0 && $max_price_search > 0) {
		$cond .= " and price >='$min_price_search' and price <='$max_price_search'";
	} elseif ($min_price_search == 0 && $max_price_search > 0) {
		$cond .= " and price <='$max_price_search'";
	} elseif ($min_price_search > 0 && $max_price_search == 0) {
		$cond .= " and price >='$min_price_search'";
	}

	if (!empty($voucher_cat_id)) {
		$cat_ID = explode(',', $voucher_cat_id);
		$cond .= " and (";
		for ($i = 0; $i < count($cat_ID); $i++) {
			if ($i == 0 && count($cat_ID) == 1) {
				$cond .= " (cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
			} elseif (count($cat_ID) > 1 && $i < (count($cat_ID) - 1)) {
				$cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%') or ";
			} else {
				$cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
			}
		}
		$cond .= ")";
	}

	$assign_list["voucher_cat_id"] = $voucher_cat_id;

	$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
	if ($city_id > 0) {
		$cond .= " and voucher_id IN (SELECT voucher_id FROM " . DB_PREFIX . "voucher_destination WHERE is_trash=0 and city_id IN ($city_id))";
		$assign_list["city_id"] = $city_id;
	}

	$link_page = !$type ? $clsISO->getLink('voucher') : $clsISO->getLink('agent_voucher');
	$config = array(
		'total'	=> $totalVoucher ?? 0,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html', '', $link_page),
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);
	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	$totalPage = $clsPagination->getTotalPage();

	$lstAllVoucher = $clsVoucher->getAll($cond, $clsVoucher->pkey);
	$totalVoucher = $lstAllVoucher ? count($lstAllVoucher) : 0;


	$lstVoucher = $clsVoucher->getAll($cond . $orderBy . $limit, $clsVoucher->pkey . ',slug,title,image,price,unit');
	if (!$lstVoucher && $currentPage > 1) {
		header("Location: " . $link_page);
		exit();
	}
	$assign_list["lstVoucher"] = $lstVoucher;
	//	$clsISO->print_pre($lstVoucher);die;



	$assign_list["totalVoucher"] = $totalVoucher;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['page_view'] = $page_view;

	/*=============Title & Description Page==================*/
	if ($cat_id > 0) {
		$title_page = $clsVoucherCategory->getTitle($cat_id) . ' | ' . $core->get_Lang('Voucher') . ' | ' . PAGE_NAME;
	} else {
		$title_page = $core->get_Lang('Voucher') . ' | ' . PAGE_NAME;
	}

	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
}
function default_searchvoucher()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $clsISO, $description_page, $keyword_page, $domain, $deviceType;


	$clsVoucher = new Voucher();
	$assign_list["clsVoucher"] = $clsVoucher;
	$clsVoucherCategory = new VoucherCat();
	$assign_list["clsVoucherCategory"] = $clsVoucherCategory;
	$clsVoucherDestination = new VoucherDestination();
	$assign_list["clsVoucherDestination"] = $clsVoucherDestination;
	$clsCity = new City();
	$assign_list["clsCity"] = $clsCity;
	$clsReviews = new Reviews();
	$assign_list["clsReviews"] = $clsReviews;
	$clsPagination = new Pagination();
	$assign_list["clsPagination"] = $clsPagination;
	$clsStock = new Stock();;
	$assign_list["clsStock"] = $clsStock;

	$cond = "is_trash=0 and is_online=1";
	$orderBy = " order by order_no asc";

	$lstVoucher = $clsVoucher->getAll($cond . $orderBy, $clsVoucher->pkey . ',slug,title,image,price');

	foreach ($lstVoucher as $item) {
		$price = $clsVoucher->getPriceSort($item['voucher_id'], $item);
		$lstVoucher[$item['voucher_id']]['price'] = $price;
	}
	$min_price = min(array_column($lstVoucher, 'price'));
	$max_price = max(array_column($lstVoucher, 'price'));
	if ($min_price == '') {
		$min_price = 0;
	}

	$min_price_search = isset($_GET['min_price']) ? $_GET['min_price'] : $min_price;
	$max_price_search = isset($_GET['max_price']) ? $_GET['max_price'] : $max_price;
	$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
	$voucher_cat_id = isset($_GET['voucher_cat_id']) ? $_GET['voucher_cat_id'] : '';
	//	print_r($min_price_search);die();
	if ($deviceType == 'tablet') {
		$recordPerPage = 14;
		$end_limit = 14;
	} else {
		$recordPerPage = 15;
		$end_limit = 15;
	}
	$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;

	$start_limit = ($currentPage - 1) * $recordPerPage;

	if ($min_price_search > 0 && $max_price_search > 0) {
		$cond .= " and price >='$min_price_search' and price <='$max_price_search'";
	} elseif ($min_price_search == 0 && $max_price_search > 0) {
		$cond .= " and price <='$max_price_search'";
	} elseif ($min_price_search > 0 && $max_price_search == 0) {
		$cond .= " and price >='$min_price_search'";
	}

	if ($city_id > 0) {
		$cond .= " and voucher_id IN (SELECT voucher_id FROM " . DB_PREFIX . "voucher_destination WHERE is_trash=0 and city_id IN ($city_id))";
		$assign_list["city_id"] = $city_id;
	}


	if (!empty($voucher_cat_id)) {
		$cat_ID = explode(',', $voucher_cat_id);
		$cond .= " and (";
		for ($i = 0; $i < count($cat_ID); $i++) {
			if ($i == 0 && count($cat_ID) == 1) {
				$cond .= " (cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
			} elseif (count($cat_ID) > 1 && $i < (count($cat_ID) - 1)) {
				$cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%') or ";
			} else {
				$cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
			}
		}
		$cond .= ")";
	}

	$assign_list["voucher_cat_id"] = $voucher_cat_id;


	$assign_list['min_price'] = $min_price;
	$assign_list['max_price'] = $max_price;
	$min_price_search = isset($_GET['min_price']) ? $_GET['min_price'] : $min_price;
	$max_price_search = isset($_GET['max_price']) ? $_GET['max_price'] : $max_price;
	$assign_list["min_price_search"] = $min_price_search;
	$assign_list["max_price_search"] = $max_price_search;


	//	print_r($cond.$orderBy);die();
	$lstVoucherResult = $clsVoucher->getAll($cond . $orderBy, $clsVoucher->pkey . ',slug,title,image,price');
	$lstVoucherResultNew = array();
	foreach ($lstVoucherResult as $item) {
		$price = $clsVoucher->getPriceSort($item['voucher_id'], $item);
		if ($price >= $min_price_search && $price <= $max_price_search) {
			$lstVoucherResultNew[] = $item;
		}
	}

	//		print($cond.$orderBy);die();
	if ($lstVoucherResultNew != '') {
		$totalVoucher = count($lstVoucherResultNew);
	} else {
		$totalVoucher = 0;
	}
	//	print_r($totalVoucher); die();
	$lnk = $_SERVER['REQUEST_URI'];
	if (isset($_GET['page'])) {
		$tmp = explode('&', $lnk);
		$n = count($tmp) - 1;
		$la_it = '&' . $tmp[$n];
		$str_len = -strlen($la_it);
		$link_page = substr($lnk, 0, $str_len);
	} else {
		$link_page = $lnk;
	}
	$assign_list["link_page"] = $link_page;
	$config = array(
		'total'	=> $totalVoucher,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html', '/', $link_page),
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);
	#
	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";

	//$lstVoucherResult=$clsVoucher->getAll($cond.$orderBy.$limit,$clsVoucher->pkey);

	//	print_r($lstVoucherResultNew);die();
	$lstVoucherResult = array_slice($lstVoucherResultNew, $start_limit, $end_limit);
	$assign_list["lstVoucherResult"] = $lstVoucherResult;
	//	print_r($lstVoucherResult);die();

	$assign_list['page_view'] = $page_view;


	unset($page_view);

	$assign_list['totalVoucher'] = $totalVoucher;
	$totalPage = $clsPagination->getTotalPage();
	//	print_r($totalPage);die();
	$assign_list['totalPage'] = $totalPage;

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Search voucher') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
}
function default_detail()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $clsISO, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $deviceType, $voucher_id, $package_id;

	$clsVoucher = new Voucher();
	$assign_list["clsVoucher"] = $clsVoucher;
	$clsProfile = new Profile();
	$assign_list["clsProfile"] = $clsProfile;
	$clsImage = new Image();
	$assign_list["clsImage"] = $clsImage;
	$clsReviews = new Reviews();
	$assign_list['clsReviews'] = $clsReviews;
	$clsStock = new Stock();
	$assign_list["clsStock"] = $clsStock;
	$clsCity = new City();
	$assign_list["clsCity"] = $clsCity;
	$clsVoucherDestination = new VoucherDestination();
	$assign_list["clsVoucherDestination"] = $clsVoucherDestination;

	$voucher_id = isset($_GET['voucher_id']) ? $_GET['voucher_id'] : 0;
	$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

	if (empty($clsVoucher->checkOnlineBySlug($voucher_id, $slug))) {
		header('location:' . $clsISO->getLink('voucher'));
		exit();
	}

	if (_IS_PROMOTION == 1) {
		$getPromotion = $clsISO->getPromotion($voucher_id, 'Voucher', time(), time(), 'get_infomation');
		$assign_list['getPromotion'] = $getPromotion;
	}
	$assign_list["voucher_id"] = $voucher_id;

	$table_id = $voucher_id;
	$assign_list["table_id"] = $voucher_id;

	$oneTable = $clsVoucher->getOne($voucher_id, 'cat_id,title,intro,price,taxable,image,slug,continue_order,content,location,inclusion,exclusion,note');
	$assign_list["oneTable"] = $oneTable;

	$vouchercat_id = $clsVoucher->getOneField('cat_id', $voucher_id);
	$assign_list["vouchercat_id"] = $vouchercat_id;

	$lstDestination = $clsVoucherDestination->getAll("is_trash=0 and voucher_id='$voucher_id' order by order_no asc");

	if (!empty($lstDestination)) {
		$cond1 = "is_trash=0 and is_online=1";
		$tmp = array();
		foreach ($lstDestination as $k => $v) {
			if (!in_array($v['city_id'], $tmp)) {
				$tmp[] = $v['city_id'];
			}
		}
		if (!empty($tmp)) {
			$query_in = implode(',', $tmp);


			$cond1 .= " and voucher_id IN (SELECT voucher_id FROM " . DB_PREFIX . "voucher_destination WHERE city_id IN (" . $query_in . ")) and cat_id='$vouchercat_id' and voucher_id <> '$voucher_id'";
		}
		#
		$cond1 .= " order by order_no asc limit 0,3";

		$lstVoucherRecommend = $clsVoucher->getAll($cond1, $clsVoucher->pkey . ',title,slug,image,price');
		$assign_list['lstVoucherRecommend'] = $lstVoucherRecommend;
	}

	$cond = "is_trash=0";
	$orderBy = " order by order_no asc";

	if ($voucher_id) {
		$cond .= " and table_id='$voucher_id' and type='Voucher'";
	}

	$lstImage = $clsImage->getAll($cond . $orderBy, $clsImage->pkey . ',image,title');
	$assign_list["lstImage"] = $lstImage;

	if (isset($_POST['BookingVoucher']) &&  $_POST['BookingVoucher'] == 'BookingVoucher') {
		$cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
		if (empty($cartSessionVoucher)) {
			$cartSessionVoucher = array();
		}
		$assign_list["cartSessionVoucher"] = $cartSessionVoucher;
		$link = $clsISO->getLink('cart');
		$cartSessionVoucher[$_LANG_ID][$voucher_id] = array();
		foreach ($_POST as $k => $v) {
			$cartSessionVoucher[$_LANG_ID][$voucher_id][$k] = $v;
		}
		///$clsISO->print_pre($cartSessionService);die();
		vnSessionSetVar('BookingVoucher_' . $_LANG_ID, $cartSessionVoucher);
		header('location:' . $link);
		exit();
	}

	if (isset($_POST['ContactVoucher']) &&  $_POST['ContactVoucher'] == 'ContactVoucher') {
		vnSessionDelVar('ContactTour');
		vnSessionDelVar('ContactCruise');
		vnSessionDelVar('ContactHotel');
		vnSessionDelVar('ContactVoucher');
		$cartSessionVoucher = vnSessionGetVar('ContactVoucher');
		if (empty($cartSessionVoucher)) {
			$cartSessionVoucher = array();
		}
		$assign_list["cartSessionVoucher"] = $cartSessionVoucher;

		$link = $clsVoucher->getLinkContact();
		$cartSessionVoucher[$voucher_id] = array();
		foreach ($_POST as $k => $v) {
			$cartSessionVoucher[$voucher_id][$k] = $v;
		}
		//$clsISO->print_pre($cartSessionService);die();
		vnSessionSetVar('ContactVoucher', $cartSessionVoucher);
		header('location:' . $link);
		exit();
	}
	$numReview = $clsReviews->countItem("is_trash=0 and is_online=1 and table_id = '$voucher_id' and type='Voucher'");
	$assign_list["numReview"] = $numReview;

	/*=============Title & Description Page==================*/

	$title_page = $clsVoucher->getTitle($voucher_id) . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
}
function default_ajaxAddVoucherToCart()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $voucher_id;


	$cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);

	if (empty($cartSessionVoucher)) {
		$cartSessionVoucher = array();
	}
	$assign_list["BookingVoucher"] = $cartSessionVoucher;
	$voucher_id = $_POST['voucher_id'];
	$tp = $_POST['tp'];
	if ($tp == 'DEL_PACKAGE') {
		unset($cartSessionVoucher[$_LANG_ID][$voucher_id]);
		vnSessionSetVar('BookingVoucher_' . $_LANG_ID, $cartSessionVoucher);
		$exist = '_REMOVE';
	} else {
		$cartSessionVoucher[$_LANG_ID][$voucher_id] = array();
		foreach ($_POST as $k => $v) {
			$cartSessionVoucher[$_LANG_ID][$voucher_id][$k] = $v;
		}
		vnSessionSetVar('BookingVoucher_' . $_LANG_ID, $cartSessionVoucher);
		$exist = '_SUCCESS';
	}
	//	print_r($cartSessionVoucher);die();


	echo $exist;
	die();
}
