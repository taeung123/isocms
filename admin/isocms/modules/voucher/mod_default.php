<?php
function getFrame($voucher_id = null)
{
	global $core, $dbconn, $_LANG_ID, $clsISO;
	$frames = array(
		'overview' => array(
			'href_group'	=> 'overview',
			'name'	=> $core->get_Lang('Overview'),
			'icon'	=> 'home',
			'steps' => array(
				'generalinformation' => array(
					'name' => $core->get_Lang('generalinformation')
				),
				'image' => array(
					'name' => $core->get_Lang('Image')
				),
				'highLight' => array(
					'name' => $core->get_Lang('HighLight')
				),
				'detail_information' => array(
					'name' => $core->get_Lang('Detail Information')
				),
				'conditions_apply' => array(
					'name' => $core->get_Lang('Conditions apply')
				)
			)
		),
	);
	$frames['destinations'] = array(
		'name'	=> $core->get_Lang('destinations'),
		'href_group'	=> 'destination',
		'icon'	=> '',
		'steps'	=> array(
			'destination' => array(
				'name' => $core->get_Lang('destinations')
			),
		)
	);
	$frames['photoGallery'] = array(
		'name'	=> $core->get_Lang('Photo Gallery'),
		'href_group'	=> 'photoGallery',
		'icon'	=> '',
		'steps'	=> array(
			'photoGallery' => array(
				'name' => $core->get_Lang('Photo Gallery')
			),
		)
	);
	$frames['configPrice'] = array(
		'name'	=> $core->get_Lang('Config Price'),
		'href_group'	=> 'configPrice',
		'icon'	=> '',
		'steps'	=> array(
			'configPrice'	=> array(
				'name' => $core->get_Lang('Config Price')
			),
		)
	);
	$frames['seo'] = array(
		'name'	=> $core->get_Lang('seosdvanced'),
		'href_group'	=> 'seo',
		'icon'	=> '',
		'steps'	=> array(
			'seo' => array(
				'name' =>  $core->get_Lang('seosdvanced')
			)
		)
	);

	return $frames;
}
function default_insert()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core, $pvalTable,
		$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $show, $nextstep;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list["show"] = $show;
	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';


	$pvalTable = Input::get('voucher_id', 0);
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


	$classTable = "Voucher";
	$clsClassTable = new $classTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	$clsSupplier = new VoucherSupply();
	$assign_list["clsSupplier"] = $clsSupplier;

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
		'generalinformation' => [
			'id'   => 'tabBasicInformation',
			'icon' => 'fa-solid fa-table-cells',
			'name' => 'General Information'
		],
		'photoGallery' => [
			'id'   => 'tabPhotoGallery',
			'icon' => 'fa-regular fa-image',
			'name' => 'Images & Media'
		],
		'conditions_apply' => [
			'id'   => 'tabConditionsApply',
			'icon' => 'fa-solid fa-shield-halved',
			'name' => 'Terms & Conditions'
		],
		'inventorycodes' => [
			'id'   => 'tabInventoryCodes',
			'icon' => 'fa-solid fa-list-check',
			'name' => 'Inventory & Codes'
		],
		'seo' => [
			'id'   => 'tabSeo',
			'icon' => 'fa-regular fa-eye',
			'name' => 'SEO & Display'
		]
	];
	$assign_list["tabInfo"] = $tabInfo;
	//	$clsClassTable->updateMinPrice($pvalTable);

}
function default_overview()
{

	//ini_set('display_errors', '1');
	//ini_set('display_startup_errors', '1');
	//error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core, $pvalTable,
		$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $show, $nextstep;
	global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;

	Asset::css([
		"{$URL_LIBRARY}/swiper-11.1.15/swiper-bundle.min.css?v={$v_cache}"
	]);

	Asset::js([
		"{$URL_LIBRARY}/swiper-11.1.15/swiper-bundle.min.js?v={$v_cache}"
	]);
	$assign_list["clsModule"] = $clsModule;
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$clsCustomer = new Customer();
	$assign_list["clsCustomer"] = $clsCustomer;
	$user_id = $core->_USER['user_id'];
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list["show"] = $show;
	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';

	$clsVochercat = new VoucherCat();
	$assign_list["clsVochercat"] = $clsVochercat;


	$pvalTable = Input::get('voucher_id', 0);
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


	$classTable = "Voucher";
	$clsClassTable = new $classTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	//get gallery images for the voucher
	$clsgallery = new Image();
	$voucherGallery = $clsgallery->getAll("is_trash=0 and table_id='$pvalTable' and type='voucher' order by order_no asc");
	$totalImage = count($voucherGallery);
	$assign_list["voucherGallery"] = $voucherGallery;
	if (!empty($oneItem['image']))
		$totalImage++;
	$assign_list["totalImage"] = $totalImage;

	$clsVoucherCode = new VoucherCode();
	$assign_list["clsVoucherCode"] = $clsVoucherCode;

	$totalCode = $clsVoucherCode->countItem("voucher_product_id=" . $pvalTable);
	$assign_list["totalCode"] = $totalCode;

	$query_default = "voucher_product_id=" . $pvalTable . " and is_trash=0 and is_online=1";
	$query_availableCode = $query_default . " and redeemed_at is NULL and expired_at is NULL and cancelled_at is NULL and valid_to > UNIX_TIMESTAMP() and valid_from <= UNIX_TIMESTAMP()";
	$query_soldCode = $query_default . " and sold_at is NOT NULL";
	$query_redeemedCode = $query_default . " and redeemed_at is NOT NULL";
	$query_expiredCode = $query_default . " and expired_at is NOT NULL";

	$availableCode = $clsVoucherCode->countItem($query_availableCode);
	$assign_list["availableCode"] = $availableCode;

	$soldCode = $clsVoucherCode->countItem($query_soldCode);
	$assign_list["soldCode"] = $soldCode;

	$redeemedCode = $clsVoucherCode->countItem($query_redeemedCode);
	$assign_list["redeemedCode"] = $redeemedCode;

	$expiredCode = $clsVoucherCode->countItem($query_expiredCode);
	$assign_list["expiredCode"] = $expiredCode;

	$availablePercent = 0;

	if ($totalCode > 0) {
		$availablePercent = round(($availableCode / $totalCode) * 100);
	}

	$assign_list["availablePercent"] = $availablePercent;

	$op_status = array(
		'1' => 'Available',
		'2' => 'Sold',
		'3' => 'Redeemed',
		'4' => 'Expired',
	);
	$assign_list["op_status"] = $op_status;

	$option_status = Input::get('option_status', 0);
	$user_id = Input::get('user_id', 0);
	$keyword = Input::get('keyword', "");
	$assign_list["user_id"] = $user_id;
	$assign_list["keyword"] = $keyword;
	$assign_list["option_status"]  = $option_status;
	/*Get type of list news*/
	$type_list = Input::get('type_list');
	$assign_list["type_list"] = $type_list;

	$pUrl = '';
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$params = array();
		$option_status = Input::post('option_status', 0);
		$user_id       = Input::post('user_id', 0);
		$keyword       = Input::post('keyword', '');
		$type_list     = Input::post('type_list', '');

		if ($option_status > 0) {
			$params['option_status'] = $option_status;
		}
		if (!empty($type_list)) {
			$params['type_list'] = $type_list;
		}
		if ($user_id > 0) {
			$params['user_id'] = $user_id;
		}
		if (!empty($keyword)) {
			$params['keyword'] = $keyword;
		}
		$link = !empty($params)
			? '?' . http_build_query($params)
			: '';
		header('Location: ' . PCMS_URL . '/voucher/overview/' . $pvalTable . $link);
		exit();
	}

	// var_dump($type_list);
	$cond = "voucher_product_id=" . $pvalTable . ' ';
	if (!empty($option_status)) {
		switch ($option_status) {
			case '1':
				$pUrl .= '&option_status=' . urlencode($option_status);
				$cond .= " and " . $query_availableCode;
				break;
			case '2':
				$pUrl .= '&option_status=' . urlencode($option_status);
				$cond .= " and " . $query_soldCode;
				break;
			case '3':
				$pUrl .= '&option_status=' . urlencode($option_status);
				$cond .= " and " . $query_redeemedCode;
				break;
			case '4':
				$pUrl .= '&option_status=' . urlencode($option_status);
				$cond .= " and " . $query_expiredCode;
				break;
			default:
		}
	}
	$assign_list["pUrl"] = $pUrl;
	#Filter By Keyword
	if (!empty($keyword)) {
		$keyword = addslashes($keyword);
		$cond .= " AND (
			code LIKE '%{$keyword}%'

			OR EXISTS (
				SELECT 1
				FROM default_booking b
				WHERE b.booking_id = default_voucher_code.booking_id
				AND b.booking_code LIKE '%{$keyword}%'
			)

			OR EXISTS (
				SELECT 1
				FROM default_customer c
				WHERE c.customer_id = default_voucher_code.customer_id
				AND c.full_name LIKE '%{$keyword}%'
			)
		)";
	}
	if (!empty($user_id)) {
		$cond .= " and customer_id='" . intval($user_id) . "'";
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
	$clsVoucherCode = new VoucherCode();
	$assign_list["clsVoucherCode"] = $clsVoucherCode;
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
	$current_page = (int) Input::get('page', 1);
	$total_record = $clsVoucherCode->countItem($cond);

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
	$allItem = $clsVoucherCode->getAll($cond . " order by " . $orderBy . $limit);
	// var_dump($allItem);
	$assign_list["allItem"] = $allItem;
	#

	$allAll = $clsVoucherCode->getAll($cond2, $clsVoucherCode->pkey);
	//var_dump($cond2, $allAll);die();
	$assign_list["number_all"] = count($allAll) ?? 0;

	$allTrash = $clsVoucherCode->getAll("is_trash=1 and " . $cond2, $clsVoucherCode->pkey);
	$assign_list["number_trash"] = count($allTrash) ?? 0;

	$allPublish = $clsVoucherCode->getAll("is_trash=0 and is_online=1 and " . $cond2, $clsVoucherCode->pkey);
	$assign_list["number_publish"] = count($allPublish) ?? 0;

	$allPrivate = $clsVoucherCode->getAll("is_trash=0 and is_online=0 and " . $cond2, $clsVoucherCode->pkey);
	$assign_list["number_private"] = count($allPrivate) ?? 0;

	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : ADMIN_PAGINATION;
	$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
	$start_limit = ($currentPage - 1) * $recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";

	$totalRecord = $clsVoucherCode->getAll($cond, $clsVoucherCode->pkey);
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
	//	$clsClassTable->updateMinPrice($pvalTable);

}


function default_ajImportVoucher()
{
	header('Content-Type: application/json; charset=utf-8');

	$base64 = isset($_POST['voucher_import_file_base64'])
		? $_POST['voucher_import_file_base64']
		: '';

	$fileName = isset($_POST['voucher_import_file_name'])
		? $_POST['voucher_import_file_name']
		: '';

	if ($base64 === '') {
		echo json_encode(array(
			'status' => 'error',
			'message' => 'Excel file data is empty'
		));
		exit;
	}

	if ($fileName === '') {
		echo json_encode(array(
			'status' => 'error',
			'message' => 'Excel file name is missing'
		));
		exit;
	}

	$extension = strtolower(
		pathinfo($fileName, PATHINFO_EXTENSION)
	);

	if (!in_array($extension, array('xlsx', 'xls'))) {
		echo json_encode(array(
			'status' => 'error',
			'message' => 'Only .xlsx and .xls files are supported'
		));
		exit;
	}

	$fileContent = base64_decode($base64, true);

	if ($fileContent === false) {
		echo json_encode(array(
			'status' => 'error',
			'message' => 'Invalid Excel file data'
		));
		exit;
	}

	$fileSize = strlen($fileContent);

	if ($fileSize === 0) {
		echo json_encode(array(
			'status' => 'error',
			'message' => 'Excel file is empty'
		));
		exit;
	}

	if ($fileSize > 10 * 1024 * 1024) {
		echo json_encode(array(
			'status' => 'error',
			'message' => 'Maximum file size is 10MB'
		));
		exit;
	}

	$tmpFile = tempnam(sys_get_temp_dir(), 'voucher_import_');

	if ($tmpFile === false) {
		echo json_encode(array(
			'status' => 'error',
			'message' => 'Cannot create temporary file'
		));
		exit;
	}

	if (file_put_contents($tmpFile, $fileContent) === false) {
		@unlink($tmpFile);
		echo json_encode(array(
			'status' => 'error',
			'message' => 'Cannot write temporary Excel file'
		));
		exit;
	}

	require_once DIR_INCLUDES . '/voucher/VoucherImportService.php';
	try {
		$result = VoucherImportService::readExcel($tmpFile);
	} catch (Exception $e) {
		@unlink($tmpFile);
		echo json_encode(array(
			'status' => 'error',
			'message' => $e->getMessage()
		), JSON_UNESCAPED_UNICODE);
		exit;
	}
	@unlink($tmpFile);
	echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	exit;
}

function default_ajSaveImportedVoucher()
{
	header('Content-Type: application/json; charset=utf-8');
	$dataRaw = isset($_POST['data']) ? $_POST['data'] : '';

	/*
     * =========================
     * 1. GET VOUCHER PRODUCT ID
     * =========================
     */
	$voucherProductId = isset($_POST['voucher_product_id'])
		? (int) $_POST['voucher_product_id']
		: 0;

	if ($voucherProductId <= 0) {

		echo json_encode(array(
			'status' => 'error',
			'message' => 'Invalid voucher product ID'
		));

		exit;
	}

	/*
     * =========================
     * 2. GET BASE64 DATA
     * =========================
     */
	$dataBase64 = isset($_POST['data_base64'])
		? trim($_POST['data_base64'])
		: '';

	if ($dataBase64 === '') {

		echo json_encode(array(
			'status' => 'error',
			'message' => 'No voucher data',
			'post_keys' => array_keys($_POST)
		));

		exit;
	}

	/*
     * =========================
     * 3. BASE64 -> JSON
     * =========================
     */
	$jsonData = base64_decode(
		$dataBase64,
		true
	);

	if ($jsonData === false) {

		echo json_encode(array(
			'status' => 'error',
			'message' => 'Invalid Base64 voucher data'
		));

		exit;
	}

	/*
     * =========================
     * 4. JSON -> ARRAY
     * =========================
     */
	$data = json_decode(
		$jsonData,
		true
	);

	if (json_last_error() !== JSON_ERROR_NONE) {

		echo json_encode(array(
			'status' => 'error',
			'message' => 'Invalid JSON',
			'json_error' => json_last_error(),
			'json_error_message' => function_exists('json_last_error_msg')
				? json_last_error_msg()
				: 'Unknown JSON error',
			'json_data' => substr($jsonData, 0, 500)
		));

		exit;
	}

	if (!is_array($data) || empty($data)) {

		echo json_encode(array(
			'status' => 'error',
			'message' => 'Voucher data is empty'
		));

		exit;
	}

	/*
     * =========================
     * 5. MAXIMUM 10,000
     * =========================
     */
	if (count($data) > 10000) {

		echo json_encode(array(
			'status' => 'error',
			'message' => 'Maximum 10,000 vouchers'
		));

		exit;
	}

	/*
     * =========================
     * 6. VOUCHER CODE
     * =========================
     */
	$clsVoucherCode = new VoucherCode();

	$inserted = 0;
	$skipped = 0;
	$errors = array();

	$now = time();

	/*
     * =========================
     * 7. INSERT VOUCHERS
     * =========================
     */
	foreach ($data as $item) {

		/*
         * Skip invalid row
         */
		if (
			isset($item['valid']) &&
			!$item['valid']
		) {
			$skipped++;
			continue;
		}

		/*
         * Voucher code
         */
		$code = isset($item['voucher_code'])
			? trim($item['voucher_code'])
			: '';

		if ($code === '') {
			$skipped++;
			continue;
		}

		/*
         * Check duplicate
         */
		$codeExists = $clsVoucherCode->getAll(
			"code='" . addslashes($code) . "'",
			$clsVoucherCode->pkey
		);

		if (!empty($codeExists)) {
			$skipped++;
			$duplicateCodes[] = $code;
			continue;
		}

		/*
		* Valid from - Start Date
		*/
		$validFrom = $now;

		if (
			isset($item['start_date']) &&
			$item['start_date'] !== ''
		) {
			$validFrom = strtotime(
				trim($item['start_date']) . ' 00:00:00'
			);

			if ($validFrom === false) {
				$validFrom = $now;
			}
		}

		/*
         * Valid to$now
         */
		$validTo = $now;

		if (
			isset($item['expiry_date']) &&
			$item['expiry_date'] !== ''
		) {

			$validTo = strtotime(
				trim($item['expiry_date']) . ' 23:59:59'
			);

			if ($validTo === false) {
				$validTo = $now;
			}
		}


		/*
         * Notes
         */
		$notes = isset($item['notes'])
			? trim($item['notes'])
			: '';

		/*
		* Price
		*/
		$price = 0;

		if (
			isset($item['price']) &&
			$item['price'] !== ''
		) {
			$price = (float) $item['price'];
		}

		/*
         * Fields
         */
		$fields = "code,voucher_product_id,valid_from,valid_to,price,note,is_online,is_trash,created_time,updated_time";

		$values = "'" . addslashes($code) . "',
    " . (int)$voucherProductId . ",
    " . (int)$validFrom . ",
    " . (int)$validTo . ",
	" . (float)$price . ",
    '" . addslashes($notes) . "',
    1,
    0,
    " . (int)$now . ",
    " . (int)$now;

		try {

			if ($clsVoucherCode->insertOne($fields, $values)) {

				$inserted++;
			} else {

				$errors[] = 'Cannot insert voucher: ' . $code;
			}
		} catch (Exception $e) {

			$errors[] =
				$code . ': ' . $e->getMessage();
		}
	}

	/*
     * =========================
     * 8. RESPONSE
     * =========================
     */
	echo json_encode(
		array(
			'status' => 'success',
			'inserted' => $inserted,
			'skipped' => $skipped,
			'errors' => $errors
		),
		JSON_UNESCAPED_UNICODE |
			JSON_UNESCAPED_SLASHES
	);

	exit;
}

function default_ajUpdPosSortVouchersss() {}

function default_ajUpdPosSort()
{
	global $core;

	$clsVoucherCode = new VoucherCode();

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

	$voucherCodeIds = [];

	foreach ($order as $voucherCodeId) {
		$voucherCodeId = (int)$voucherCodeId;

		if ($voucherCodeId > 0) {
			$voucherCodeIds[] = $voucherCodeId;
		}
	}

	if (empty($voucherCodeIds)) {
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
	$totalOnPage = count($voucherCodeIds);

	foreach ($voucherCodeIds as $index => $voucherCodeId) {
		/*
         * Trang 1:
         * dòng đầu = 20, dòng cuối = 1
         *
         * Trang 2:
         * dòng đầu = 40, dòng cuối = 21
         */
		$orderNo = $pageStartOrder + ($totalOnPage - $index);

		$clsVoucherCode->updateOne(
			$voucherCodeId,
			"order_no='{$orderNo}'"
		);
	}

	echo '_SUCCESS';
	die();
}

function default_getMainFormStep()
{
	global $smarty, $assign_list, $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $nextstep, $clsConfiguration, $mod, $package_id, $pvalTable, $meta_id;
	$clsVoucher = new Voucher();
	$clsVoucherCat = new VoucherCat();
	$assign_list["clsVoucherCat"] = $clsVoucherCat;
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;
	$clsTag = new Tag();
	$assign_list["clsTag"] = $clsTag;
	$clsMeta = new Meta();
	$assign_list["clsMeta"] = $clsMeta;
	$clsContinent                   = new Continent();
	$assign_list["clsContinent"]    = $clsContinent;

	#
	$table_id = Input::post('table_id', 0);
	$currentstep = Input::post('currentstep', '');
	$oneItem = $clsVoucher->getOne($table_id);
	$tableName = $clsVoucher->tbl;
	$pkeyTable = $clsVoucher->pkey;
	$classTable                     = "Voucher";
	$assign_list["classTable"] = $classTable;
	$assign_list["clsTable"] = $classTable;
	$assign_list["clsClassTable"] = $clsVoucher;
	$assign_list["pkeyTable"] = $pkeyTable;
	$smarty->assign('pvalTable', $table_id);
	$smarty->assign('oneItem', $oneItem);

	$linkMeta               = $clsVoucher->getLink($table_id);
	$allMeta                = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id                = $allMeta[0]['meta_id'] ?? 0;
	$assign_list["meta_id"] = $meta_id;

	$frames = getFrame();
	#Step follow index
	$ii = 0;
	$arrStep = array();
	foreach ($frames as $okey => $frame) {
		$steps = $frame['steps'];
		foreach ($steps as $key => $step) {
			$status = 0;
			if ($key == 'generalinformation' && $oneItem['title'] != '' && $oneItem['cat_id'] > 0) {
				$status = 1;
			}
			if ($key == 'image' && $oneItem['image'] != '') {
				$status = 1;
			}
			if ($key == 'highLight' && $oneItem['intro'] != '') {
				$status = 1;
			}
			if ($key == 'detail_information' && $oneItem['content'] != '') {
				$status = 1;
			}
			if ($key == 'conditions_apply' && $oneItem['location'] != '') {
				$status = 1;
			}
			if ($key == 'destination') {
				$clsVoucherDestination = new VoucherDestination();
				$number_destination = $clsVoucherDestination->countItem("voucher_id='" . $table_id . "'");
				if ($number_destination > 0) {
					$status = 1;
				}
			}
			if ($key == 'photoGallery') {
				$clsImage = new Image();
				$number_image = $clsImage->countItem("table_id='" . $table_id . "' and type='Voucher'");
				if ($number_image > 0) {
					$status = 1;
				}
			}
			if ($key == 'configPrice' && $oneItem['price'] != '' && $oneItem['unit'] > 0) {
				$status = 1;
			}
			if ($key == 'seo') {
				$clsMeta = new Meta();
				$link = $clsVoucher->getLink($table_id);
				$oneMeta = $clsMeta->getAll("config_link='$link' limit 0,1", $clsMeta->pkey . ',config_value_title,config_value_intro,image,schema_markup');
				if (!empty($oneMeta) && $oneMeta[0]['config_value_title'] != '' && $oneMeta[0]['config_value_intro'] != '' && $oneMeta[0]['image'] != '') {
					$status = 1;
				}
			}
			$arrStep[$ii] = array(
				'key' => $key,
				'panel' => $okey,
				'name' => $step['name'],
				'status' => $status
			);
			++$ii;
		}
	}

	$smarty->assign('arrStep', $arrStep);
	if ($currentstep == 'seo') {
		$clsMeta = new Meta();
		$assign_list["clsMeta"] = $clsMeta;
		$linkMeta = $clsVoucher->getLink($table_id);
		$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
		$meta_id = $allMeta[0]['meta_id'] ?? 0;

		if (empty($meta_id)) {

			$introMeta = strip_tags(html_entity_decode(addslashes($oneItem['intro'])));
			$introMeta = explode('$trun$', wordwrap($introMeta, 280, '$trun$', false), 2);
			$introMeta = $introMeta[0] . (isset($introMeta[1]) ? '...' : '');
			$meta_id = $clsMeta->getMaxId();
			$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id", "'" . $linkMeta . "','" . $oneItem['title'] . "','" . $introMeta . "','" . $oneItem['image'] . "','" . time() . "','" . time() . "','" . $meta_id . "'");
		}
		$smarty->assign('meta_id', $meta_id);
	} else if ($currentstep == 'lhdl') {
	}
	if ($currentstep == 'image-file-tour') {
		$hasImg = 1;
		if (stripos($oneItem['image'], 'no-image') !== false) {
			$hasImg = 0;
		}
		$smarty->assign('hasImg', $hasImg);
	}
	//die('xx');
	#Possition current step
	$step = 0;
	foreach ($arrStep as $k => $v) {
		if ($v['key'] == $currentstep) {
			$step = $k;
			break;
		}
	}
	$prevstep = isset($arrStep[$step - 1]['key']) ? $arrStep[$step - 1]['key'] : '_first';
	$nextstep = isset($arrStep[$step + 1]['key']) ? $arrStep[$step + 1]['key'] : '_last';
	$smarty->assign('step', $step);
	$smarty->assign('prevstep', $prevstep);
	$smarty->assign('nextstep', $nextstep);
	$smarty->assign('currentstep', $currentstep);
	$smarty->assign('list_check_target', json_encode($arrStep));

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$smarty->assign('clsForm', $clsForm);
	#
	$clsForm->addInputTextArea("full", "overview", "", "overview", 255, 25, 8, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "check_in_out_rule", "", "check_in_out_rule", 255, 25, 8, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "blog_booking_policy", "", "blog_booking_policy", 255, 25, 15, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "child_policy", "", "child_policy", 255, 25, 2, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "cancellation_policy", "", "cancellation_policy", 255, 25, 2, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "other_policy", "", "other_policy", 255, 25, 8, 1, "style='width:100%'");

	#

	// Output
	$html = $core->build('main_step.tpl');
	echo $html;
	die();
}
function default_ajSaveMainStep()
{
	/*ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);*/
	global $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $clsConfiguration;
	#
	$clsVoucherCat = new VoucherCat();
	$clsTag = new Tag();
	$msg = '_error';

	$clsClassTable = new Voucher();
	$typeTable = Input::post('table', '');
	if (!empty($typeTable)) {
		if ($typeTable == 'supplier') {
			$clsClassTable = new VoucherSupply();
		}
		if ($typeTable == 'categories') {
			$clsClassTable = new VoucherCat();
		}
	}


	$table_id = Input::post('table_id', 0);
	$currentstep = Input::post('currentstep');

	if ($currentstep == 'basic-information') {
		$title = Input::post('title');
		$title = html_entity_decode($title);
		$title = ucfirst($title);
		$code = Input::post('code', '');
		$image = Input::post('image', '');
		$is_online = Input::post('is_online', 0);
		$content = Input::post('iso-content', '');
		$country_id = Input::post('country_id', 0);
		$address = Input::post('address', '');

		$arr_update = [];
		if ($typeTable == 'supplier') {
			$arr_update = [
				'supply_name' 		=> addslashes($title),
				'slug'				=> $clsISO->replaceSpace2($title),
				'code'				=> addslashes($code),
				'image'				=> addslashes($image),
				'is_online'			=> addslashes($is_online),
				'content'			=> addslashes($content),
				'country_id'		=> addslashes($country_id),
				'address'			=> addslashes($address),
				'updated_time' 		=> time()
			];
		}
		if ($typeTable == 'categories') {
			$arr_update = [
				'title' 		=> addslashes($title),
				'slug'				=> $clsISO->replaceSpace2($title),
				'is_online'			=> addslashes($is_online),
				'code'				=> addslashes($code),
				'image'				=> addslashes($image),
				'intro'				=> addslashes($content),
				'upd_date' 			=> time()
			];
		}



		if ($clsClassTable->updateOne($table_id, $arr_update)) {
			$msg = '_success';
			// Output
			echo $msg;
			die();
		} else {
			$msg = '_error';
			// Output
			echo $msg;
			die();
		}
	} elseif ($currentstep == 'generalinformation') {

		$title = Input::post('title');
		$title = html_entity_decode($title);
		$title = ucfirst($title);
		$code = Input::post('code');
		$image = Input::post('image', '');
		$is_online = Input::post('is_online', 0);
		$cat_id = Input::post('iso-cat_id');
		$supplier_id = Input::post('supplier_id');
		$content = Input::post('iso-content', '');
		$intro = Input::post('iso-intro', '');
		$label = Input::post('label');
		$arr_update = [
			'title' 			=> addslashes($title),
			'slug'				=> $clsISO->replaceSpace2($title),
			'code'				=> addslashes($code),
			'image'				=> addslashes($image),
			'is_online'			=> addslashes($is_online),
			'cat_id'			=> addslashes($cat_id),
			'supplier_id'		=> addslashes($supplier_id),
			'content'			=> addslashes($content),
			'intro'				=> addslashes($intro),
			'label'				=> addslashes($label),
			'is_draft' 			=> '0',
			'upd_date' 			=> time(),
			'user_id_update'	=>	addslashes($core->_SESS->user_id)
		];
		if ($clsConfiguration->getValue('SiteHasCat_Voucher')) {
			$cat_id      = Input::post('iso-cat_id');
			$list_cat_id = $clsVoucherCat->getListParent($cat_id);
			$arr_update['list_cat_id'] = addslashes($list_cat_id);
		}

		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
		//var_dump($table_id, $arr_update);
		$clsClassTable->updateOne($table_id, $arr_update);
	} else if ($currentstep == 'image') {
		$image = Input::post('image', '');
		$clsClassTable->updateOne($table_id, array(
			'image' => $image
		));
	} else if ($currentstep == 'highLight') {
		//		var_dump($_POST);die;
		$intro = Input::post('iso-intro', '');
		$arr_update['intro'] = $intro;
		if ($clsClassTable->updateOne($table_id, $arr_update)) {
			$msg = '_error';
			// Output
			echo $msg;
			die();
		}
	} else if ($currentstep == 'detail_information') {
		$content = Input::post('iso-content');
		$content = html_entity_decode($content);
		$content = preg_replace_callback('#(<img\s(?>(?!src=)[^>])*?src=")nodata...image/([a-z]+);base64,([\w=+/]++)("[^>]*>)#', "data_upload_image_word_textarea", $content);
		$content = preg_replace_callback('#(<img\s(?>(?!src=)[^>])*?src=")data:image/(gif|png|jpeg);base64,([\w=+/]++)("[^>]*>)#', "data_upload_image_word_textarea", $content);
		$arr_update['content'] = $content;
		$clsClassTable->updateOne($table_id, $arr_update);
	} else if ($currentstep == 'conditions_apply') {
		//		var_dump($_POST);die;
		$location = Input::post('iso-location', '');
		$arr_update['location'] = $location;
		$clsClassTable->updateOne($table_id, $arr_update);
	} else if ($currentstep == 'configPrice') {
		$price = Input::post('price', 0);
		$price_input = Input::post('price_input', 0);
		$taxable = Input::post('taxable', 0);
		$quantity = Input::post('quantity', 0);
		$continue_order = Input::post('continue_order', 0);
		$is_shipping = Input::post('is_shipping', 0);
		$is_inventory = Input::post('is_inventory', 0);
		$unit = (int) Input::post('unit', 0);
		$arr_update = [
			'price'				=> $clsISO->processSmartNumber2($price),
			'price_input'		=> $clsISO->processSmartNumber2($price_input),
			'taxable'			=> $taxable,
			'continue_order'	=> $continue_order,
			'is_shipping'		=> $is_shipping,
			'is_inventory'		=> $is_inventory,
			'unit'				=> $unit,
		];
		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
		$clsClassTable->updateOne($table_id, $arr_update);
		$clsStock = new Stock();
		$clsStock->init($table_id, $quantity);
	} else if ($currentstep == 'seo') {
		$clsClassTable = new Meta();

		$config_value_title = Input::post('config_value_title');
		$meta_id = Input::post('meta_id');

		$config_value_intro = Input::post('config_value_intro');
		$schema = $clsClassTable->getSchemaMarkupFromPost();
		if (!$schema['success']) {
			die('_error');
		}
		$schema_markup = $schema['data'];

		$config_value_image = Input::post('isoman_url_image_seo');
		if (empty($meta_id)) {
			$clsClassTable->updateOne($table_id, array(
				'star_id' => $star_id,
				'upd_date' => time()
			));
		} else {
			$clsClassTable->updateOne($meta_id, array(
				'config_value_title' => $config_value_title,
				'config_value_intro' => $config_value_intro,
				'schema_markup' => $schema_markup,
				'image' => $config_value_image,
				'upd_date' => time()
			));
		}
	} else {
		$val_post = input::post();
		$arr_update = [];
		foreach ($val_post as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
		//		var_dump($arr_update);die;
		$clsClassTable->updateOne($table_id, $arr_update);
	}
	$msg = '_success';
	// Output
	echo $msg;
	die();
}
function default_ajDeleteMainImage()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$table = Input::post('table');
	$id = Input::post('id');
	if (!empty($table) && !empty($id)) {
		$clsClassTable = new $table();
		$clsClassTable->updateOne($id, array(
			'image' => '',
			'updated_time' => time()
		));
		echo '_success';
	} else {
		echo '_error';
	}
	die();
}

function default_ajAddNewSetting()
{
	// ini_set('display_errors', '1');
	// ini_set('display_startup_errors', '1');
	// error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$table = Input::post('table', '');

	if (!empty($table)) {

		if ($table == 'categories') {
			$clsClassTable = new VoucherCat();
			$newId = $clsClassTable->getMaxId();
			$field = 'voucher_cat_id,user_id,title,is_online,is_trash,reg_date,upd_date';
			$value = "'{$newId}','{$user_id}','Category Voucher " . time() . "',0,0,'" . time() . "','" . time() . "'";
		} else {
			$clsClassTable = new VoucherSupply();
			$newId = $clsClassTable->getMaxId();
			$field = 'supply_id,supply_name,is_online,is_trash,created_time,updated_time';
			$value = "'{$newId}','Supply Voucher " . time() . "',0,0,'" . time() . "','" . time() . "'";
		}

		if ($clsClassTable->insertOne($field, $value)) {
			echo json_encode([
				'status' => 'success',
				'table'  => $table,
				'new_id' => $newId
			]);
			exit;
		}

		echo json_encode([
			'status' => 'error',
			'table'  => $table
		]);
		exit;
	}

	echo @json_encode([
		'status' => 'error',
		'table' => $table
	]);
	exit; // Stop further execution after sending error response

}
function default_loadCountry()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsContinent = new Continent();
	$clsCountry = new Country();
	$continent_id = Input::post('continent_id', 0);
	$country_id = Input::post('country_id', 0);
	#
	$Html = $clsContinent->getOptCountryByContinent($continent_id, $country_id);
	echo $Html;
	die();
}
function default_loadArea()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsArea = new Area();
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	$area_id = isset($_POST['area_id']) ? $_POST['area_id'] : 0;

	$Html = '<option value="0">|---' . $core->get_Lang('select') . '--</option>';
	$lstArea = $clsArea->getAll("is_trash=0 and country_id='$country_id' order by order_no asc");
	if (is_array($lstArea) && count($lstArea) > 0) {
		for ($i = 0; $i < count($lstArea); $i++) {
			$Html .= '<option title="' . $clsArea->getTitle($lstArea[$i][$clsArea->pkey]) . '" value="' . $lstArea[$i][$clsArea->pkey] . '"' . ($area_id == $lstArea[$i][$clsArea->pkey] ? 'selected="selected"' : '') . '>|--- ' . $clsArea->getTitle($lstArea[$i][$clsArea->pkey]) . '</option>';
		}
	}
	echo $Html;
	die();
}
function default_loadRegion()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsRegion = new Region();
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	$region_id = isset($_POST['region_id']) ? $_POST['region_id'] : 0;
	#
	$Html = $clsRegion->makeSelectboxOption($country_id, $region_id);
	if ($Html == '') {
		echo 'EMPTY';
	} else {
		echo $Html;
	}
	die();
}
function default_loadCity()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsCity = new City();
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	$region_id = isset($_POST['region_id']) ? $_POST['region_id'] : 0;
	$city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;

	$cond = "is_trash=0 and is_online=1";
	if (intval($country_id)) {
		$cond .= " and country_id='$country_id'";
	}
	if (intval($region_id) > 0) {
		$cond .= " and region_id='$region_id'";
	}
	$cond .= " order by title ASC";
	#
	$Html = '<option value="0"> --' . $core->get_Lang('select') . '-- </option>';
	$listCity = $clsCity->getAll($cond, $clsCity->pkey);
	if (is_array($listCity) && count($listCity) > 0) {
		for ($i = 0; $i < count($listCity); $i++) {
			$Html .= '<option title="' . $clsCity->getTitle($listCity[$i][$clsCity->pkey]) . '" value="' . $listCity[$i][$clsCity->pkey] . '" ' . ($city_id == $listCity[$i][$clsCity->pkey] ? 'selected="selected"' : '') . '>|--- ' . $clsCity->getTitle($listCity[$i][$clsCity->pkey]) . '</option>';
		}
	}
	unset($listCity);
	echo $Html;
	die();
}

function default_upload_gallery()
{
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO, $package_id;

	$tp = Input::post('tp', "_crop");
	$table_id = (int) Input::post('table_id', 0);
	$clsTableGal = Input::post('clsTableGal');
	$clsClassTableGal = new Image();
	//	var_dump($_POST);die;
	#
	$msg = '_error';

	$list_images = Input::post('list_images');
	$list_images = explode('|', $list_images);
	foreach ($list_images as $key => $image) {
		if (!empty($image) && file_exists(ABSPATH . $image)) {
			$arr_img = explode('/', $image);
			$img_title = explode('.', end($arr_img));
			if ($clsClassTableGal->insert(array(
				$clsClassTableGal->pkey => $clsClassTableGal->getMaxId(),
				'user_id' 	=> $core->_USER['user_id'],
				'table_id' 	=> $table_id,
				'type' 		=> $clsTableGal,
				'title' 	=> $img_title[0],
				'slug' 		=> $core->replaceSpace($img_title[0]),
				'image' 	=> $image,
				'order_no' 	=> $clsClassTableGal->getMaxOrderNo(),
				'reg_date' 	=> time()
			))) {
				$msg = 'success';
			}
		}
	}
	// Return
	echo $msg;
	die();
}

function default_ajOpenGallery()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO;
	#
	$clsPagination = new Pagination();

	$tour_image_id = isset($_POST['tour_image_id']) ? intval($_POST['tour_image_id']) : 0;
	$table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
	$clsTable = isset($_POST['clsTable']) ? $_POST['clsTable'] : '';
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	//	var_dump($_POST);die;
	$clsClassTable = new Image();
	// Load List
	if ($tp == 'L') {
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$number_per_page = isset($_POST['number_per_page']) ? intval($_POST['number_per_page']) : 10;
		//echo $number_per_page; die();
		#
		$cond = "is_trash=0 and table_id='$table_id' and type='$clsTable'";
		#
		$html = '';
		$totalRecord = $clsClassTable->countItem($cond);
		$pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
		#
		$offset = ($page - 1) * $number_per_page;
		$order_by = " ORDER BY order_no asc";
		$limit = " LIMIT $offset,$number_per_page";
		$lstItem = $clsClassTable->getAll($cond . $order_by);
		//        $clsISO->print_pre($cond . $order_by,true);die();
		if (!empty($lstItem)) {
			for ($i = 0; $i < count($lstItem); $i++) {
				$table_image_id = $lstItem[$i][$clsClassTable->pkey];
				$html .= '<div><div class="gallery-item bootstrap">';
				$html .= '<a><img class="img-responsive mr-3 preview-img" src="' . $ftp_abs_path_image . $clsClassTable->getImage($table_image_id, 140, 100, $lstItem[$i]) . '" alt="' . $lstItem[$i]['title'] . '" ></a>';
				$html .= '  <div class="gallery-toolbar">
						<a class="text-white" onClick="delete_gallery(this)" table_id="' . $table_id . '" table_image_id="' . $lstItem[$i][$clsClassTable->pkey] . '">' . $clsISO->makeIcon('times') . '</a>
					</div>
					</div>
					<input type="text" data="' . $lstItem[$i]['image_id'] . '" table_id="' . $lstItem[$i]['table_id'] . '" value="' . $lstItem[$i]['title'] . '" onChange="changeTitleGallery(this)"/>
				</div>';
			}
		}
		$html .= '';
		echo $html;
		die();
	} else {
		echo 'error';
		die();
	}
}

function default_ajDeleteGallery()
{
	global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule;
	// header('Content-Type: application/json');
	$clsTable = Input::post('clsTable');
	$clsClassTable = new Image();
	$table_id = (int) Input::post('table_id', 0);
	$image_id = (int) Input::post('image_id', 0);
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

function default_ajaxChangeTitleGallery()
{
	global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule;
	$clsTable = Input::post('clsTable');
	$title = Input::post('value', '');
	$slug = $core->replaceSpace($title);
	$image_id = Input::post('data', 0);
	$table_id = (int) Input::post('table_id', 0);
	$clsClassTable = new Image();
	if ($image_id > 0 && $slug != '') {
		$arr_update = [
			'title' =>	$title,
			'slug'	=>	$slug
		];
		if ($clsClassTable->updateOne($image_id, $arr_update)) {
			echo 'success';
			die;
		} else {
			echo 'error';
			die;
		}
	}
}

function default_checkTitleVoucher()
{
	global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule;
	$clsVoucher = new Voucher();
	$table_id = (int)Input::post('table_id', 0);
	$title = Input::post('title', '');
	$slug = $clsISO->replaceSpace2($title);
	$cond = "voucher_id !='$table_id' and slug='$slug'";
	$count_voucher = $clsVoucher->countItem($cond);
	$data = ['result' => true];
	if ($count_voucher > 0) {
		$data = ['result' => false];
	}
	echo json_encode($data);
	die;
}
