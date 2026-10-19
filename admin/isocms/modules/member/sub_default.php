<?php
function default_defaultOld()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;

	#
	$is_active = isset($_GET['is_active']) ? $_GET['is_active'] : '';
	$assign_list["is_active"] = $is_active;
	#
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;

	$lstCountry = $clsCountry->getAll("is_trash=0 and country_id IN (SELECT country_id FROM " . DB_PREFIX . "profile) order by order_no asc", $clsCountry->pkey);
	$assign_list["lstCountry"] = $lstCountry;

	/**/
	$classTable = "Profile";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	/*List all item*/
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		if ($_POST['domain_id'] != '' && $_POST['domain_id'] != '0') {
			$link .= '&domain_id=' . $_POST['domain_id'];
		}
		if (isset($_POST['name']) && $_POST['name'] != '') {
			$link .= '&name=' . $_POST['name'];
		}
		if (isset($_POST['email']) && $_POST['email'] != '') {
			$link .= '&email=' . $_POST['email'];
		}
		if (isset($_POST['address']) && $_POST['address'] != '') {
			$link .= '&address=' . $_POST['address'];
		}
		if (isset($_POST['country_id']) && intval($_POST['country_id']) != 0) {
			$link .= '&country_id=' . intval($_POST['country_id']);
		}
		if (isset($_POST['phoneNumber']) && $_POST['phoneNumber'] != '') {
			$link .= '&phone=' . $_POST['phoneNumber'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	$pUrl = '';
	#
	$cond = '1=1';
	if ($is_active != '') {
		$cond .= " and is_active = '$is_active'";
	}
	#
	if ($type_list == 'Pending') {
		$cond .= " and is_active=0";
	} elseif ($type_list == 'Approved') {
		$cond .= " and is_active=1";
	}

	if ($type == 'Traveller') {
		$cond .= " and is_agent <>2";
	} elseif ($type == 'TravelAgent') {
		$cond .= " and is_agent=2";
	}

	if (isset($_GET['name']) && $_GET['name'] != '') {
		$cond .= " and (first_name like '%" . $_GET['name'] . "%' or last_name like '%" . $_GET['name'] . "%' or full_name like '%" . $_GET['name'] . "%')";
		$assign_list["name"] = $_GET['name'];
	}
	if (isset($_GET['email']) && $_GET['email'] != '') {
		$cond .= " and (email like '%" . $_GET['email'] . "%')";
		$assign_list["email"] = $_GET['email'];
	}
	if (isset($_GET['address']) && $_GET['address'] != '') {
		$cond .= " and (address like '%" . $_GET['address'] . "%')";
		$assign_list["address"] = $_GET['address'];
	}
	if (isset($_GET['country_id']) && $_GET['country_id'] != '') {
		$cond .= " and country_id ='" . $_GET['country_id'] . "'";
		$assign_list["country_id"] = $_GET['country_id'];
	}
	if (isset($_GET['phone']) && $_GET['phone'] != '') {
		$cond .= " and (phone like '%" . $_GET['phone'] . "%')";
		$assign_list["phone"] = $_GET['phone'];
	}
	$orderBy = " reg_date desc";

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

	//print_r($cond . " order by " . $orderBy . $limit); die();
	$listItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
	$assign_list["listItem"] = $listItem;
	$assign_list["totalItem"] = (is_array($listItem) && count($listItem) > 0) ? count($listItem) : 0;
	$assign_list["last_item"] = count($listItem) - 1;
	#

	$allAll = $clsClassTable->getAll("is_trash=0", $clsClassTable->pkey);
	$assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;

	$allProcess =  $clsClassTable->getAll("is_active=1");
	$assign_list["number_active"] = $allProcess[0][$pkeyTable] != '' ? count($allProcess) : 0;
	$allUnProcess =  $clsClassTable->getAll("is_active=0");
	$assign_list["number_unactive"] = $allUnProcess[0][$pkeyTable] != '' ? count($allUnProcess) : 0;
	$assign_list["number_reviewed"] = $clsClassTable->countItem("is_active=2");
	#----
	if (isset($_POST['submit'])) {
		if ($_POST['submit'] == 'UpdateSiteProfile') {
			foreach ($_POST as $key => $val) {
				$tmp = explode('-', $key);
				if ($tmp[0] == 'iso') {
					$clsConfiguration->updateValue($tmp[1], $val);
				}
			}
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess');
		}
	}
}
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;

	#
	$is_active = isset($_GET['is_active']) ? $_GET['is_active'] : '';
	$assign_list["is_active"] = $is_active;
	#
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;

	$lstCountry = $clsCountry->getAll("is_trash=0 and country_id IN (SELECT country_id FROM " . DB_PREFIX . "profile) order by order_no asc", $clsCountry->pkey);
	$assign_list["lstCountry"] = $lstCountry;

	/**/
	$classTable = "Profile";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	/*List all item*/
	$link = '';
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		if (isset($_POST['domain_id']) && $_POST['domain_id'] != '' && $_POST['domain_id'] != '0') {
			$link .= '&domain_id=' . $_POST['domain_id'];
		}
		if (isset($_POST['name']) && $_POST['name'] != '') {
			$link .= '&name=' . rawurlencode($_POST['name']);
		}
		if (isset($_POST['is_active']) && $_POST['is_active'] !== '') {
			$link .= '&is_active=' . (int) $_POST['is_active'];
		}
		if (isset($_POST['type_list']) && in_array($_POST['type_list'], array('Pending', 'Reviewed', 'Approved'))) {
			$link .= '&type_list=' . rawurlencode($_POST['type_list']);
		}
		if (isset($_POST['email']) && $_POST['email'] != '') {
			$link .= '&email=' . $_POST['email'];
		}
		if (isset($_POST['address']) && $_POST['address'] != '') {
			$link .= '&address=' . $_POST['address'];
		}
		if (isset($_POST['country_id']) && intval($_POST['country_id']) != 0) {
			$link .= '&country_id=' . intval($_POST['country_id']);
		}
		if (isset($_POST['phoneNumber']) && $_POST['phoneNumber'] != '') {
			$link .= '&phone=' . $_POST['phoneNumber'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	$pUrl = '';
	#
	$cond = '1=1';
	if ($is_active != '') {
		$cond .= " and is_active = '$is_active'";
	}
	#
	if ($type_list == 'Pending') {
		$cond .= " and is_active=0";
	} elseif ($type_list == 'Approved') {
		$cond .= " and is_active=1";
	} elseif ($type_list == 'Reviewed') {
		$cond .= " and is_active IN (1,2)";
	}

	if ($type == 'Traveller') {
		$cond .= " and is_agent <>2";
	} elseif ($type == 'TravelAgent') {
		$cond .= " and is_agent=2";
	}

	if (isset($_GET['name']) && $_GET['name'] != '') {
		$memberKeyword = addslashes($_GET['name']);
		$cond .= " and (first_name like '%" . $memberKeyword . "%' or last_name like '%" . $memberKeyword . "%' or full_name like '%" . $memberKeyword . "%' or email like '%" . $memberKeyword . "%' or phone like '%" . $memberKeyword . "%')";
		$assign_list["name"] = $_GET['name'];
	}
	if (isset($_GET['email']) && $_GET['email'] != '') {
		$cond .= " and (email like '%" . $_GET['email'] . "%')";
		$assign_list["email"] = $_GET['email'];
	}
	if (isset($_GET['address']) && $_GET['address'] != '') {
		$cond .= " and (address like '%" . $_GET['address'] . "%')";
		$assign_list["address"] = $_GET['address'];
	}
	if (isset($_GET['country_id']) && $_GET['country_id'] != '') {
		$cond .= " and country_id ='" . $_GET['country_id'] . "'";
		$assign_list["country_id"] = $_GET['country_id'];
	}
	if (isset($_GET['phone']) && $_GET['phone'] != '') {
		$cond .= " and (phone like '%" . $_GET['phone'] . "%')";
		$assign_list["phone"] = $_GET['phone'];
	}
	$orderBy = " reg_date desc";

	$recordPerPage = isset($_GET["recordperpage"]) ? max(1, (int) $_GET["recordperpage"]) : 20;
	$currentPage = isset($_GET["page"]) ? max(1, (int) $_GET["page"]) : 1;
	$start_limit = ($currentPage - 1) * $recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";

	$totalRecord = $clsClassTable->countItem($cond);
	$totalPage = $totalRecord > 0 ? (int) ceil($totalRecord / $recordPerPage) : 0;
	if ($totalPage > 0 && $currentPage > $totalPage) {
		$currentPage = $totalPage;
		$start_limit = ($currentPage - 1) * $recordPerPage;
		$limit = " limit $start_limit,$recordPerPage";
	}
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$assign_list['previousPage'] = max(1, $currentPage - 1);
	$assign_list['nextPage'] = min(max(1, $totalPage), $currentPage + 1);
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
	$memberRecordPerPageFilterUrl = '';
	if (!empty($_GET['name'])) {
		$memberRecordPerPageFilterUrl .= '&name=' . rawurlencode($_GET['name']);
	}
	if ($is_active !== '') {
		$memberRecordPerPageFilterUrl .= '&is_active=' . (int) $is_active;
	}
	if ($type_list !== '') {
		$memberRecordPerPageFilterUrl .= '&type_list=' . rawurlencode($type_list);
	}
	$assign_list['memberRecordPerPageFilterUrl'] = $memberRecordPerPageFilterUrl;
	#-------End Page Divide-----------------------------------------------------------

	//print_r($cond . " order by " . $orderBy . $limit); die();
	$listItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
	$assign_list["listItem"] = $listItem;
	$assign_list["totalItem"] = (is_array($listItem) && count($listItem) > 0) ? count($listItem) : 0;
	$assign_list["last_item"] = count($listItem) - 1;
	#

	$allAll = $clsClassTable->getAll("is_trash=0", $clsClassTable->pkey);
	$assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;

	$allProcess =  $clsClassTable->getAll("is_active=1");
	$assign_list["number_active"] = $allProcess[0][$pkeyTable] != '' ? count($allProcess) : 0;
	$allUnProcess =  $clsClassTable->getAll("is_active=0");
	$assign_list["number_unactive"] = $allUnProcess[0][$pkeyTable] != '' ? count($allUnProcess) : 0;
	$assign_list["number_reviewed"] = $clsClassTable->countItem("is_active=2");
	$assign_list["number_reviewed_total"] = $assign_list["number_active"] + $assign_list["number_reviewed"];
	#----
	if (isset($_POST['submit'])) {
		if ($_POST['submit'] == 'UpdateSiteProfile') {
			foreach ($_POST as $key => $val) {
				$tmp = explode('-', $key);
				if ($tmp[0] == 'iso') {
					$clsConfiguration->updateValue($tmp[1], $val);
				}
			}
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess');
		}
	}
}
function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;
	$classTable = "Profile";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$assign_list["clsClassTable"] = $clsClassTable;
	#

	$string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";

	$pvalTable = intval($core->decryptID($string));

	$assign_list['pvalTable'] = $pvalTable;
	$oneTable = $clsClassTable->getOne($pvalTable);
	$assign_list["oneTable"] = $oneTable;
	#

	$is_active = $oneTable['is_active'];
	if ($is_active == 0 && intval($pvalTable) > 0) {
		$clsClassTable->updateOne($pvalTable, "is_active = 2");
	}

	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;
	$clsHotel = new Hotel();
	$assign_list["clsHotel"] = $clsHotel;
	$clsCruise = new Cruise();
	$assign_list["clsCruise"] = $clsCruise;
	$clsTour = new Tour();
	$assign_list["clsTour"] = $clsTour;

	$clsReviews = new Reviews();
	$assign_list["clsReviews"] = $clsReviews;

	$lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
	$assign_list["lstCountry"] = $lstCountry;
	#
	$clsWishlist = new Wishlist();
	$assign_list["clsWishlist"] = $clsWishlist;

	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;

	$clsCruiseCabin = new CruiseCabin();
	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;


	/*//////WishList/////////*/

	$lstWishlist = $clsWishlist->getAll("member_id='$pvalTable' order by wishlist_id desc");
	$assign_list["lstWishlist"] = $lstWishlist;
	if ($lstWishlist > 0) {
		$totlalWishlist = count($lstWishlist);
	} else {
		$totlalWishlist = 0;
	}
	$assign_list["totlalWishlist"] = $totlalWishlist;

	$lstWishlistHotel = $clsWishlist->getAll("clsTable='Hotel' and member_id='$pvalTable' order by wishlist_id desc");
	$assign_list["lstWishlistHotel"] = $lstWishlistHotel;

	$lstWishlistTour = $clsWishlist->getAll("clsTable='Tour' and member_id='$pvalTable' order by wishlist_id desc");
	$assign_list["lstWishlistTour"] = $lstWishlistTour;

	$lstWishlistCruise = $clsWishlist->getAll("clsTable='Cruise' and member_id='$pvalTable' order by wishlist_id desc");
	$assign_list["lstWishlistCruise"] = $lstWishlistCruise;


	/*//////Booking////////*/

	$lstBooking = $clsBooking->getAll("member_id='$pvalTable' order by booking_id desc");
	$assign_list["lstBooking"] = $lstBooking;
	if ($lstBooking > 0) {
		$totalBooking = count($lstBooking);
	} else {
		$totalBooking = 0;
	}

	$assign_list["totalBooking"] = $totalBooking;
	$lstBookingHotel = $clsBooking->getAll("clsTable='Hotel' and member_id='$pvalTable' order by booking_id desc");
	$assign_list["lstBookingHotel"] = $lstBookingHotel;

	$lstBookingTour = $clsBooking->getAll("clsTable='Tour' and member_id='$pvalTable' order by booking_id desc");
	$assign_list["lstBookingTour"] = $lstBookingTour;

	$lstBookingCruise = $clsBooking->getAll("clsTable='Cruise' and member_id='$pvalTable' order by booking_id desc");
	$assign_list["lstBookingCruise"] = $lstBookingCruise;

	/*///////Reviews////////////*/
	$lstReviews = $clsReviews->getAll("profile_id='$pvalTable' order by reviews_id desc");
	$assign_list["lstReviews"] = $lstReviews;
	if ($lstReviews > 0) {
		$totalReviews = count($lstReviews);
	} else {
		$totalReviews = 0;
	}

	$assign_list["totalReviews"] = $totalReviews;
	$lstReviewsHotel = $clsReviews->getAll("type='hotel' and profile_id='$pvalTable' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
	$assign_list["lstReviewsHotel"] = $lstReviewsHotel;
	$lstReviewsTour = $clsReviews->getAll("type='tour' and profile_id='$pvalTable' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
	$assign_list["lstReviewsTour"] = $lstReviewsTour;
	$lstReviewsCruise = $clsReviews->getAll("type='cruise' and profile_id='$pvalTable' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
	$assign_list["lstReviewsCruise"] = $lstReviewsCruise;

	#
	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#-------------Update Config Meta 
	$clsForm->addInputTextArea("full", "note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");
	#
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		$value .= "is_active='" . $_POST['is_active'] . "'";
		$value .= ",note='" . $_POST['iso-note'] . "'";
		if ($clsClassTable->updateOne($pvalTable, $value)) {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
		}
	}
}
function default_viewbooking()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsProfile = new Profile();
	$assign_list["clsProfile"] = $clsProfile;
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	#
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	$pvalTable = intval($core->decryptID($string));
	if ($string != '' && $pvalTable == 0) {
		header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
		exit();
	}
	$assign_list["pvalTable"] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;

	$cart_store = unserialize($oneItem['cart_store']);
	$booking_store = unserialize($oneItem['booking_store']);

	$cart_store_tour = $cart_store['TOUR'];
	$cart_store_voucher = $cart_store['VOUCHER'];

	$assign_list['booking_store'] = $booking_store;
	$assign_list['cart_store_tour'] = $cart_store_tour;
	$assign_list['cart_store_voucher'] = $cart_store_voucher;
	//print_r($cart_store_voucher); die();

	#
	$clsBilling = new Billing();
	$assign_list["clsBilling"] = $clsBilling;

	$clsTour = new Tour();
	$assign_list["clsTour"] = $clsTour;

	$clsVoucher = new Voucher();
	$assign_list["clsVoucher"] = $clsVoucher;

	$clsPromotion = new Promotion();
	$assign_list["clsPromotion"] = $clsPromotion;

	$clsAddOnService = new AddOnService();
	$assign_list["clsAddOnService"] = $clsAddOnService;

	$lstBilling = $clsBilling->getAll("booking_id='$pvalTable' and billing_type='" . $oneItem['clsTable'] . "' order by reg_date DESC");
	$assign_list["lstBilling"] = $lstBilling;
	unset($lstBilling);
	#
	$clsTable = $oneItem['clsTable'];
	$clsTable = new $clsTable;
	$assign_list["clsTable"] = $clsTable;

	$target_id = $oneItem['target_id'];
	$assign_list["target_id"] = $target_id;

	$profile_id = $oneItem['member_id'];

	$assign_list["profile_id"] = $profile_id;
	$clsCruiseCabin = new CruiseCabin();
	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	#
	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#-------------Update Config Meta 
	$clsForm->addInputTextArea("static", "note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");

	$reg_date = $oneItem['reg_date'];
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$listBookingPrev = $clsBooking->getAll("1=1 and clsTable = 'Tour' and reg_date < '$reg_date' order by reg_date desc");


	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		if ($oneItem['status'] == 1) {
			$value = "is_send_email='" . $_POST['sendmail'] . "'";
		} else {
			$value = "status='" . $_POST['status'] . "'";
		}
		$value .= ",note='" . addslashes($_POST['iso-note']) . "'";
		#
		$pUrl = '';
		$pUrl .= "&act=edit";
		$pUrl .= "&profile_id=" . $core->encryptID($profile_id) . "";
		//print_r($pvalTable.'xxx'.$value); die();
		if ($clsClassTable->updateOne($pvalTable, $value)) {
			if ($_POST['sendmail'] == 1) {
				$clsClassTable->sendEmailSupportBooking($pvalTable);
			}
			header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=UpdateSuccess#isotab2');
		}
	}
	if (isset($_POST['updateBooking']) && $_POST['updateBooking'] == 'Update') {

		$value .= "customer_note='" . addslashes($_POST['customer_note']) . "'";
		$value .= ",staff_note='" . addslashes($_POST['staff_note']) . "'";

		if ($clsClassTable->updateOne($pvalTable, $value)) {
			if ($_POST['notify_user'] == 'Y') {
			}
			if ($_POST['notify_department'] == 'Y') {
			}
			$pUrl = '';
			$pUrl .= "&act=viewbooking";
			$pUrl .= "&booking_id=" . $core->encryptID($pvalTable) . "";

			header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=UpdateSuccess#isotab0');
		}
	}
}
function default_viewbooking2()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsProfile = new Profile();
	$assign_list["clsProfile"] = $clsProfile;
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	#
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	$pvalTable = intval($core->decryptID($string));
	if ($string != '' && $pvalTable == 0) {
		header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
		exit();
	}
	$assign_list["pvalTable"] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	#
	$clsBilling = new Billing();
	$assign_list["clsBilling"] = $clsBilling;
	$lstBilling = $clsBilling->getAll("booking_id='$pvalTable' and billing_type='" . $oneItem['clsTable'] . "' order by reg_date DESC");
	$assign_list["lstBilling"] = $lstBilling;
	unset($lstBilling);
	#
	/*	$status = $oneItem['status'];
	if($status == 0 && intval($pvalTable) > 0) {
		$clsClassTable->updateOne($pvalTable,"status = 2");
	}*/
	#
	$clsTable = $oneItem['clsTable'];
	$clsTable = new $clsTable;
	$assign_list["clsTable"] = $clsTable;

	$target_id = $oneItem['target_id'];
	$assign_list["target_id"] = $target_id;

	$profile_id = $oneItem['member_id'];

	$assign_list["profile_id"] = $profile_id;
	$clsCruiseCabin = new CruiseCabin();
	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	#
	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#-------------Update Config Meta 
	$clsForm->addInputTextArea("static", "note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");

	$reg_date = $oneItem['reg_date'];
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$listBookingPrev = $clsBooking->getAll("1=1 and clsTable = 'Tour' and reg_date < '$reg_date' order by reg_date desc");
	//print_r($cond); die();

	$bookingPrevItem = $listBookingPrev[0]['booking_id'];
	$assign_list["bookingPrevItem"] = $bookingPrevItem;
	//print_r($listItem); die();

	$listBookingNext = $clsBooking->getAll("1=1 and clsTable = 'Tour' and reg_date > '$reg_date' order by reg_date ASC");
	//print_r($cond); die();

	$bookingNextItem = $listBookingNext[0]['booking_id'];
	$assign_list["bookingNextItem"] = $bookingNextItem;
	//print_r($listItem); die();

	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		if ($oneItem['status'] == 1) {
			$value = "is_send_email='" . $_POST['sendmail'] . "'";
		} else {
			$value = "status='" . $_POST['status'] . "'";
		}
		$value .= ",note='" . addslashes($_POST['iso-note']) . "'";
		#
		$pUrl = '';
		$pUrl .= "&act=edit";
		$pUrl .= "&profile_id=" . $core->encryptID($profile_id) . "";
		//print_r($pvalTable.'xxx'.$value); die();
		if ($clsClassTable->updateOne($pvalTable, $value)) {
			if ($_POST['sendmail'] == 1) {
				$clsClassTable->sendEmailSupportBooking($pvalTable);
			}
			header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=UpdateSuccess#isotab2');
		}
	}
	if (isset($_POST['updateBooking']) && $_POST['updateBooking'] == 'Update') {

		$value .= "customer_note='" . addslashes($_POST['customer_note']) . "'";
		$value .= ",staff_note='" . addslashes($_POST['staff_note']) . "'";

		if ($clsClassTable->updateOne($pvalTable, $value)) {
			if ($_POST['notify_user'] == 'Y') {
			}
			if ($_POST['notify_department'] == 'Y') {
			}
			$pUrl = '';
			$pUrl .= "&act=viewbooking";
			$pUrl .= "&booking_id=" . $core->encryptID($pvalTable) . "";

			header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=UpdateSuccess#isotab0');
		}
	}


	if (1 == 2) {
		$clsCountry = new _Country();
		$assign_list["clsCountry"] = $clsCountry;

		$classTable = "Profile";
		$clsClassTable = new $classTable;
		$tableName = $clsClassTable->tbl;
		$pkeyTable = $clsClassTable->pkey;

		$assign_list["clsClassTable"] = $clsClassTable;
		#
		$string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";

		$pvalTable = intval($core->decryptID($string));

		$assign_list['pvalTable'] = $pvalTable;
		$oneTable = $clsClassTable->getOne($pvalTable);
		$assign_list["oneTable"] = $oneTable;
		#
		$is_active = $oneTable['is_active'];
		if ($is_active == 0 && intval($pvalTable) > 0) {
			$clsClassTable->updateOne($pvalTable, "is_active = 2");
		}
		$clsCountry = new _Country();
		$assign_list["clsCountry"] = $clsCountry;
		$clsHotel = new Hotel();
		$assign_list["clsHotel"] = $clsHotel;
		$clsCruise = new Cruise();
		$assign_list["clsCruise"] = $clsCruise;
		$clsTour = new Tour();
		$assign_list["clsTour"] = $clsTour;

		$clsReviews = new Reviews();
		$assign_list["clsReviews"] = $clsReviews;
		$lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
		$assign_list["lstCountry"] = $lstCountry;
		#
		$clsWishlist = new Wishlist();
		$assign_list["clsWishlist"] = $clsWishlist;

		$clsBooking = new Booking();
		$assign_list["clsBooking"] = $clsBooking;

		$clsCruiseCabin = new CruiseCabin();
		$assign_list["clsCruiseCabin"] = $clsCruiseCabin;


		/*//////WishList/////////*/

		$lstWishlist = $clsWishlist->getAll("member_id='$pvalTable' order by wishlist_id desc");
		$assign_list["lstWishlist"] = $lstWishlist;
		if ($lstWishlist > 0) {
			$totlalWishlist = count($lstWishlist);
		} else {
			$totlalWishlist = 0;
		}
		$assign_list["totlalWishlist"] = $totlalWishlist;

		$lstWishlistHotel = $clsWishlist->getAll("clsTable='Hotel' and member_id='$pvalTable' order by wishlist_id desc");
		$assign_list["lstWishlistHotel"] = $lstWishlistHotel;

		$lstWishlistTour = $clsWishlist->getAll("clsTable='Tour' and member_id='$pvalTable' order by wishlist_id desc");
		$assign_list["lstWishlistTour"] = $lstWishlistTour;

		$lstWishlistCruise = $clsWishlist->getAll("clsTable='Cruise' and member_id='$pvalTable' order by wishlist_id desc");
		$assign_list["lstWishlistCruise"] = $lstWishlistCruise;

		/*//////Booking////////*/

		$lstBooking = $clsBooking->getAll("member_id='$pvalTable' order by booking_id desc");
		$assign_list["lstBooking"] = $lstBooking;
		if ($lstBooking > 0) {
			$totalBooking = count($lstBooking);
		} else {
			$totalBooking = 0;
		}

		$assign_list["totalBooking"] = $totalBooking;
		$lstBookingHotel = $clsBooking->getAll("clsTable='Hotel' and member_id='$pvalTable' order by booking_id desc");
		$assign_list["lstBookingHotel"] = $lstBookingHotel;

		$lstBookingTour = $clsBooking->getAll("clsTable='Tour' and member_id='$pvalTable' order by booking_id desc");
		$assign_list["lstBookingTour"] = $lstBookingTour;

		$lstBookingCruise = $clsBooking->getAll("clsTable='Cruise' and member_id='$pvalTable' order by booking_id desc");
		$assign_list["lstBookingCruise"] = $lstBookingCruise;


		/*///////Reviews////////////*/
		$lstReviews = $clsReviews->getAll("profile_id='$pvalTable' order by reviews_id desc");
		$assign_list["lstReviews"] = $lstReviews;
		if ($lstReviews > 0) {
			$totalReviews = count($lstReviews);
		} else {
			$totalReviews = 0;
		}

		$assign_list["totalReviews"] = $totalReviews;

		$lstReviewsHotel = $clsReviews->getAll("type='hotel' and profile_id='$pvalTable' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
		$assign_list["lstReviewsHotel"] = $lstReviewsHotel;

		$lstReviewsTour = $clsReviews->getAll("type='tour' and profile_id='$pvalTable' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
		$assign_list["lstReviewsTour"] = $lstReviewsTour;
		$lstReviewsCruise = $clsReviews->getAll("type='cruise' and profile_id='$pvalTable' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
		$assign_list["lstReviewsCruise"] = $lstReviewsCruise;



		#
		require_once DIR_COMMON . "/clsForm.php";
		$clsForm = new Form();
		$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
		$assign_list["clsForm"] = $clsForm;
		#-------------Update Config Meta 
		$clsForm->addInputTextArea("full", "note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");
		#
		if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
			$value .= "is_active='" . $_POST['is_active'] . "'";
			$value .= ",note='" . $_POST['iso-note'] . "'";
			if ($clsClassTable->updateOne($pvalTable, $value)) {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
			}
		}
	}
}
function default_editbooking()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];

	#
	$clsProfile = new Profile();
	$assign_list["clsProfile"] = $clsProfile;
	$classTable = "Booking";
	$clsClassTable = new $classTable;

	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#

	#
	$string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	$pvalTable = intval($core->decryptID($string));
	if ($string != '' && $pvalTable == 0) {
		header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
		exit();
	}
	$assign_list["pvalTable"] = $pvalTable;

	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;

	#
	$status = $oneItem['status'];
	if ($status == 0 && intval($pvalTable) > 0) {
		$clsClassTable->updateOne($pvalTable, "status = 2");
	}
	#
	$clsTable = $oneItem['clsTable'];
	$clsTable = new $clsTable;
	$assign_list["clsTable"] = $clsTable;

	$target_id = $oneItem['target_id'];
	$assign_list["target_id"] = $target_id;

	$profile_id = $oneItem['member_id'];

	$assign_list["profile_id"] = $profile_id;
	$clsCruiseCabin = new CruiseCabin();
	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;

	#
	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#-------------Update Config Meta 
	$clsForm->addInputTextArea("full", "note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");



	$reg_date = $oneItem['reg_date'];
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$listBookingPrev = $clsBooking->getAll("1=1 and clsTable = 'Tour' and reg_date < '$reg_date' order by reg_date desc"); //print_r($cond); die();

	$bookingPrevItem = $listBookingPrev[0]['booking_id'];
	$assign_list["bookingPrevItem"] = $bookingPrevItem; //print_r($listItem); die();

	$listBookingNext = $clsBooking->getAll("1=1 and clsTable = 'Tour' and reg_date > '$reg_date' order by reg_date ASC"); //print_r($cond); die();

	$bookingNextItem = $listBookingNext[0]['booking_id'];
	$assign_list["bookingNextItem"] = $bookingNextItem; //print_r($listItem); die();
	#------------------------
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		if ($oneItem['status'] == 1) {
			$value = "is_send_email='" . $_POST['sendmail'] . "'";
		} else {
			$value = "status='" . $_POST['status'] . "'";
		}

		$value .= ",note='" . addslashes($_POST['iso-note']) . "'";
		#
		$pUrl = '';
		$pUrl .= "&act=edit";
		$pUrl .= "&profile_id=" . $core->encryptID($profile_id) . "";
		#
		//print_r($pvalTable.'xxx'.$value); die();
		if ($clsClassTable->updateOne($pvalTable, $value)) {
			if ($_POST['sendmail'] == 1) {
				//print_r(xxx); die();
				$clsClassTable->sendEmailSupportBooking($pvalTable);
			}

			header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=UpdateSuccess#isotab2');
		}
	}

	if (isset($_POST['updateBooking']) && $_POST['updateBooking'] == 'Update') {


		foreach ($_POST as $k => $v) {
			$POST[$k] = $v;
		}

		$value .= "departure_date='" . addslashes($_POST['departure_date']) . "'";
		$value .= ",pickup_address='" . addslashes($_POST['pickup_address']) . "'";
		$value .= ",number_adult='" . addslashes($_POST['number_adult']) . "'";
		$value .= ",number_child='" . addslashes($_POST['number_child']) . "'";
		$value .= ",number_baby='" . addslashes($_POST['number_baby']) . "'";
		$value .= ",price_adult='" . addslashes($_POST['price_adult']) . "'";
		$value .= ",price_child='" . addslashes($_POST['price_child']) . "'";
		$value .= ",price_baby='" . addslashes($_POST['price_baby']) . "'";
		$value .= ",discount_adult='" . addslashes($_POST['discount_adult']) . "'";
		$value .= ",discount_child='" . addslashes($_POST['discount_child']) . "'";
		$value .= ",discount_baby='" . addslashes($_POST['discount_baby']) . "'";
		$value .= ",surcharge_price='" . addslashes($_POST['total_surcharge']) . "'";
		$value .= ",payment_method='" . addslashes($_POST['payment_method']) . "'";
		$value .= ",customer_note='" . addslashes($_POST['customer_note']) . "'";
		$value .= ",staff_note='" . addslashes($_POST['staff_note']) . "'";
		$value .= ",booking_store='" . serialize($POST) . "'";
		$value .= ",totalgrand='" . $clsISO->processSmartNumber(str_replace('.00', '', $_POST['totalgrand'])) . "'";
		$value .= ",deposit='" . $clsISO->processSmartNumber(str_replace('.00', '', $_POST['deposit'])) . "'";
		$value .= ",balance='" . $clsISO->processSmartNumber(str_replace('.00', '', $_POST['balance'])) . "'";

		//print_r($pvalTable.'xxxx'.$value); die();
		if ($clsClassTable->updateOne($pvalTable, $value)) {
			if ($_POST['notify_user'] == 'Y') {
			}
			if ($_POST['notify_department'] == 'Y') {
			}
			$pUrl = '';
			$pUrl .= "&act=editbooking";
			$pUrl .= "&booking_id=" . $core->encryptID($pvalTable) . "";

			header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=UpdateSuccess#isotab0');
		}
	}
}
function default_print()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$user_id = $core->_USER['user_id'];

	$clsProfile = new Profile();
	$assign_list["clsProfile"] = $clsProfile;
	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;

	#
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	$string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	$pvalTable = intval($core->decryptID($string));
	$assign_list["pvalTable"] = $pvalTable;


	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	#
	$clsTable = $oneItem['clsTable'];
	$clsTable = new $clsTable;
	$assign_list["clsTable"] = $clsTable;

	$target_id = $oneItem['target_id'];
	$assign_list["target_id"] = $target_id;

	$profile_id = $oneItem['member_id'];

	$assign_list["profile_id"] = $profile_id;

	if ($string != '' && $pvalTable == 0) {
		header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
		exit();
	}
	$assign_list["booking_id"] = $pvalTable;
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Profile";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	$pvalTable = intval($core->decryptID($string));
	if ($pvalTable == "") {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
	}
	#
	if ($clsClassTable->deleteOne($pvalTable)) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=DeleteSuccess');
	}
}
function default_setting()
{
	//	ini_set('display_errors', '1');
	//ini_set('display_startup_errors', '1');
	//error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsConfiguration, $oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	$clsMeta = new Meta();
	$assign_list['clsMeta'] = $clsMeta;
	$linkMeta = $clsISO->getLink($mod);

	$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'] ?? 0;
	#
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
		$site_member_background = $_POST['isoman_url_site_member_background'];
		if ($site_member_background != '' && $site_member_background != '0') {
			$clsConfiguration->updateValue('site_member_background', $site_member_background);
		}
		/*if($_POST['config_value_title']!='' || $_POST['config_value_intro']!=''){
			if($meta_id==''){
				$clsMeta->insertOne("config_link,reg_date,meta_id","'".$linkMeta."','".time()."','".$clsMeta->getMaxID()."'");
				$allMeta = $clsMeta->getAll("config_link='".$linkMeta."'");
				$meta_id = $allMeta[0]['meta_id'];
			}
			$clsMeta->updateOne($meta_id,"config_value_intro='".addslashes($_POST['config_value_intro'])."',config_value_keyword='".addslashes($_POST['config_value_keyword'])."',config_value_title='".addslashes($_POST['config_value_title'])."',upd_date='".time()."',meta_index='".addslashes($_POST['meta_index'])."',meta_follow='".addslashes($_POST['meta_follow'])."',image='".addslashes($_POST['isoman_url_image_seo'])."'");
		}*/
		$extUrl = '';
		if ($_POST['submit'] == 'UpdateConfiguration') {
			$extUrl = '#isotab0';
		}
		if ($_POST['submit'] == 'UpdateConfiguration1') {
			$extUrl = '#isotab1';
		}
		if ($_POST['submit'] == 'UpdateConfiguration2') {
			$extUrl = '#isotab2';
		}
		header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess' . $extUrl);
	}
}
function default_ajUpdateStatusBooking()
{
	global $core, $dbconn;
	#
	$clsClassTable = new Booking();
	$booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : 0;
	$status = isset($_POST['status']) ? $_POST['status'] : 0;
	$user_id = $core->_USER['user_id'];
	#
	$clsClassTable->updateOne($booking_id, "status='$status'");

	echo 1;
	die();
}
require_once(DIR_MODULES . '/member/mod_default.php');
