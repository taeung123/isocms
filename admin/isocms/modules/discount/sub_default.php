<?php
function default_default(){
	// ini_set('display_errors', 1);
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL & ~E_STRICT);
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$type_list = Input::get('type_list');
	$assign_list["type_list"] = $type_list;
	$keyword = Input::get('keyword');
	$assign_list["keyword"] = $keyword;
	$status_id = Input::get('status_id');
	$assign_list["status_id"] = $status_id;
	$discount_type = Input::get('discount_type');
	$assign_list["discount_type"] = $discount_type;
	/**/
	$classTable = "Discount";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	$discount_type_list = array(
		0 => $core->get_Lang('All Types'),
		1 => $core->get_Lang('Fixed amount'),
		2 => $core->get_Lang('Percentage')
	);

	$status_list = array(
		0 => $core->get_Lang('All Statuses'),
		1 => $core->get_Lang('Active'),
		2 => $core->get_Lang('Inactive'),
		3 => $core->get_Lang('Expired')
	);

	$assign_list['discount_type_list'] = $discount_type_list;
	$assign_list['status_list'] = $status_list;
	/*List all item*/
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '';
		$keyword = Input::post('keyword');
		if (!empty($keyword)) {
			$link .= '&keyword=' . urlencode($keyword);
		}
		$status_id = Input::post('status_id');
		if ($status_id !== '' && $status_id !== null && (int)$status_id > 0) {
			$link .= '&status_id=' . urlencode($status_id);
		}
		$discount_type = Input::post('discount_type');

		if ($discount_type !== '' && $discount_type !== null && (int)$discount_type > 0) {
			$link .= '&discount_type=' . urlencode($discount_type);
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
		exit();
	}
	#
	$cond = "`is_draft`='0'";
	#Filter By Keyword
	if(!empty($keyword)){
		$slug = $core->replaceSpace($keyword);
		$cond .= " and ( code like '%" . $slug . "%' or title like '%" . $_GET['keyword'] . "%')";
		
	}
	$discount_type = Input::get('discount_type');
	
	if ($discount_type !== '' && $discount_type !== null && (int)$discount_type > 0) {
		$cond .= " AND JSON_UNQUOTE(
			JSON_EXTRACT(more_information, '$.discount_type')
		) = '" . addslashes($discount_type) . "'";
	}

	$status_id = Input::get('status_id');

	if (($status_id !== '' && $status_id !== null) && (int)$status_id > 0) {

		$now = time();

		switch ((string)$status_id) {

			// Active
			case '1':
				$cond .= " AND is_online = 1";
				break;

			// Inactive
			case '2':
				$cond .= " AND is_online = 0";
				break;

			// Expired
			case '3':
				$cond .= " AND booking_date_to <= {$now}";
				break;
		}
	}

	$cond2 = $cond;
	if(!empty($type_list)){
		if($type_list=='Publish'){
			$cond .= " and is_trash=0";
		}
		if($type_list=='Trash'){
			$cond .= " and is_trash=1";
		}
	}
	$orderBy = " reg_date DESC";
	#-------Page Divide---------------------------------------------------------------
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
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='vpc_status')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	$config = array(
		'total'	=> $totalRecord,
		'current_page'	=> $currentPage,
		'number_per_page'	=> $recordPerPage,
		'link'	=> PCMS_URL.'/index.php'.$link_page_current_2
	);
	// $clsPagination = new Pagination();
	// $clsPagination->initianize($config);
	// $html_pager = $clsPagination->create_links();
	// $assign_list["html_pager"] = $html_pager;
	// #
	// $offset = ($current_page-1)*$record_per_page;
	// $limit = " limit {$offset},{$record_per_page}";
	#-------End Page Divide-----------------------------------------------------------
	$allItem = $clsClassTable->getAll($cond." order by ".$orderBy.$limit);
	$assign_list["allItem"] = $allItem;
	#
	$allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_trash"] = count($allTrash) ?? 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_item"] = count($allUnTrash) ?? 0;
    #
    $allAll = $clsClassTable->getAll($cond2, $clsClassTable->pkey);
    $assign_list["number_all"] = count($allAll) ?? 0;

}
function default_new(){
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act,$oneSetting,$clsISO;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$discount_rule = Input::get('discount_rule','code');
	
	$clsProperty = new Property();
	$assign_list['clsProperty'] = $clsProperty;
	$lstGroup = $clsProperty->getAll("property_type='_PROFILE_GROUP' order by order_no ASC");
	$assign_list['lstGroup'] = $lstGroup; unset($lstGroup);
	
	$classTable = "Discount";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	
	/** Delete Temp */
	$clsClassTable->deleteByCond("is_trash=1 and user_id='{$user_id}'");
	$pvalTable = $clsClassTable->getMaxId();
	$more_information = array(
		'type'					=> 'all',
		'discount_type' 		=> 'percentage',
		'discount_value' 		=> 0,
		'minimum_purchase'		=> 0,
		'customer_group_type' 	=> 'all',
		'promotion_voucher_cond_type' => 'quantity',
		'is_due_date'	=> 0,
		'due_date' 		=> strtotime('+1 day')
	);
	if($clsClassTable->insert(array(
		$pkeyTable 			=> $pvalTable,
		'status'			=> 1,
		'discount_rule'		=> $discount_rule,
		'is_trash'			=> 1,
		'user_id' 			=> $user_id,
		'reg_date'			=> time(),
		'start_date'		=> time(),
		'due_date'			=> strtotime('+1 day'),
		'more_information' 	=> @json_encode($more_information)
	))){
		header('Location:'.PCMS_URL.'/index.php?mod='.$mod.'&act=edit&action=new&'.$pkeyTable.'='.$pvalTable);
		exit();
	}
}
function default_ajCreateNewDiscount(){
	// ini_set('display_errors', 1);
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL & ~E_STRICT);

	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act,$oneSetting,$clsISO;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];

	$classTable = "Discount";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	$pvalTable = $clsClassTable->getMaxId();
	$now = time();

	$fields = 'discount_id,title,type,product_type,is_trash,is_online,user_id,reg_date,discount_type';
	$title = 'New Discount ' . $pvalTable;


	$values = "'" . $pvalTable . "','" . addslashes($title) . "','1','all','0','0','" .
			$user_id . "','" .
			$now . "','2'" ;

	$created = $clsClassTable->insertOne($fields, $values);
	if($created){
		echo json_encode(array(
			'status' => 'success',
			'link' => PCMS_URL.'/'.$mod.'/insert/'.$pvalTable
		));
	}else{
		echo json_encode(array(
			'status' => 'error'
		));
	}

}

function default_insert(){
	// ini_set('display_errors', 1);
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL & ~E_STRICT);

	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act,$oneSetting,$clsISO;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsProperty = new Property();
	$assign_list['clsProperty'] = $clsProperty;
	$lstGroup = $clsProperty->getAll("property_type='_PROFILE_GROUP' order by order_no ASC");
	$assign_list['lstGroup'] = $lstGroup; unset($lstGroup);
	
	$discount_rule = Input::get('discount_rule', 'code');
	if(!in_array($discount_rule, array('code','promotion'))){
		header('Location:'.PCMS_URL.'/index.php?mod='.$mod);
		exit();
	}
	
	$classTable = "Discount";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	#
	$action = Input::get('action', '_edit');
	$pvalTable = (int) Input::get($pkeyTable,0);
	$oneItem = $clsClassTable->getOne($pvalTable);
	$more_information = $oneItem['more_information'];
	//var_dump($more_information);
	$more_information = !empty($more_information) ? @json_decode($more_information, true) : array();
	if(!empty($more_information)){
		$oneItem = array_merge($more_information, $oneItem);
	}
	$assign_list['more_information'] = $more_information;
	$assign_list['action'] = $action;
	$assign_list['oneItem'] = $oneItem;
	$assign_list['pvalTable'] = $pvalTable;
	$list_customer_group = $oneItem['list_customer_group'];
	$list_customer_group = !empty($list_customer_group) ? @json_decode($list_customer_group, true) : array();
	$assign_list['list_customer_group'] = $list_customer_group;
	$productGroups = [
		'tour' => 'Tour',
		'hotel' => 'Hotel',
		'cruise' => 'Cruise',
		'voucher' => 'Voucher'
	];
	$assign_list['productGroups'] = $productGroups; unset($productGroups);

	$lstDay = $weekdays_arr = array(
		'Mon' => 'Mo',
		'Tue' => 'Tu',
		'Wed' => 'We',
		'Thu' => 'Th',
		'Fri' => 'Fr',
		'Sat' => 'Sa',
		'Sun' => 'Su'
	);
	$assign_list['lstDay'] = $lstDay; unset($lstDay);

	$weekdays_arr = !empty($oneItem['weekdays']) 
		? json_decode($oneItem['weekdays'], true) : array();
	$assign_list['oneItem'] = $oneItem;
	$assign_list['weekdays_arr'] = $weekdays_arr;
	//var_dump($weekdays_arr);

	$cls_discount_item = new DiscountItem();

	$assign_list['cls_discount_item'] = $cls_discount_item;

	$list_discount_item = $cls_discount_item->getAll(
		"discount_id='" . $pvalTable . "' order by " . $cls_discount_item->pkey . " ASC"
	);

	$assign_list['list_discount_item'] = $list_discount_item;



	// =====================================================
	// GROUP ITEM ID THEO clsTable
	// =====================================================

	$result_discount_item = [];

	foreach ($list_discount_item as $row) {

		$clsTable = isset($row['clsTable'])
			? trim($row['clsTable'])
			: '';

		$itemId = isset($row['item_id'])
			? (int)$row['item_id']
			: 0;

		if (empty($clsTable) || empty($itemId)) {
			continue;
		}

		if (!isset($result_discount_item[$clsTable])) {
			$result_discount_item[$clsTable] = [];
		}

		$result_discount_item[$clsTable][] = $itemId;
	}


	// Loại bỏ ID trùng
	foreach ($result_discount_item as $clsTable => $itemIds) {

		$result_discount_item[$clsTable] = array_values(
			array_unique(
				array_filter(
					array_map('intval', $itemIds)
				)
			)
		);
	}

	$assign_list['result_discount_item'] = $result_discount_item;
	//var_dump($result_discount_item); die();

	// =====================================================
	// QUERY DATA CỦA CÁC ITEM
	// =====================================================

	$discount_items = [];

	foreach ($result_discount_item as $clsTable => $itemIds) {

		if (empty($itemIds)) {
			continue;
		}

		$ids = implode(',', $itemIds);

		switch ($clsTable) {

			// =================================================
			// TOUR
			// =================================================
			case 'Tour':

				$clsTour = new Tour();

				$lstTour = $clsTour->getAll(
					"tour_id IN (" . $ids . ")
					AND is_trash='0'
					AND is_online='1'
					order by FIELD(tour_id," . $ids . ")"
				);

				if (!empty($lstTour)) {

					foreach ($lstTour as $item) {

						$discount_items[] = [
							'type'       => 'Tour',
							'item_id'    => (int)$item['tour_id'],
							'title'      => $item['title'],
							'code'       => isset($item['trip_code'])
								? $item['trip_code']
								: '',
							'data'       => $item
						];
					}
				}

				break;


			// =================================================
			// HOTEL
			// =================================================
			case 'Hotel':

				$clsHotel = new Hotel();

				$lstHotel = $clsHotel->getAll(
					"hotel_id IN (" . $ids . ")
					AND is_trash='0'
					AND is_online='1'
					order by FIELD(hotel_id," . $ids . ")"
				);

				if (!empty($lstHotel)) {

					foreach ($lstHotel as $item) {

						$discount_items[] = [
							'type'       => 'Hotel',
							'item_id'    => (int)$item['hotel_id'],
							'title'      => $item['title'],
							'code'       => isset($item['hotel_code'])
								? $item['hotel_code']
								: '',
							'data'       => $item
						];
					}
				}

				break;


			// =================================================
			// CRUISE
			// =================================================
			case 'Cruise':

				$clsCruise = new Cruise();

				$lstCruise = $clsCruise->getAll(
					"cruise_id IN (" . $ids . ")
					AND is_trash='0'
					AND is_online='1'
					order by FIELD(cruise_id," . $ids . ")"
				);

				if (!empty($lstCruise)) {

					foreach ($lstCruise as $item) {

						$discount_items[] = [
							'type'       => 'Cruise',
							'item_id'    => (int)$item['cruise_id'],
							'title'      => $item['title'],
							'code'       => isset($item['cruise_code'])
								? $item['cruise_code']
								: '',
							'data'       => $item
						];
					}
				}

				break;


			// =================================================
			// VOUCHER
			// =================================================
			case 'Voucher':

				$clsVoucherProduct = new Voucher();

				$lstVoucher = $clsVoucherProduct->getAll(
					"voucher_product_id IN (" . $ids . ")
					AND is_trash='0'
					AND is_online='1'
					order by FIELD(voucher_product_id," . $ids . ")"
				);

				if (!empty($lstVoucher)) {

					foreach ($lstVoucher as $item) {

						$discount_items[] = [
							'type'       => 'Voucher',
							'item_id'    => (int)$item['voucher_product_id'],
							'title'      => $item['title'],
							'code'       => isset($item['code'])
								? $item['code']
								: '',
							'data'       => $item
						];
					}
				}

				break;
		}
	}


	$assign_list['discount_items'] = $discount_items;
	$assign_list['total_items'] = count($discount_items);

	//var_dump($discount_items); die('Debugging result_discount_item');

	// $product_table = '';
	// $cls_product_table = new Product();
	// $assign_list['cls_product_table'] = $cls_product_table;

	$errorNo = 0;
	$errorMsg = array();
	if(Input::exists('submit') && Input::post('submit')=='Update'){
		$value = ""; $firstAdd = 0;
		foreach($_POST as $key=>$val){
			$tmp = explode('-',$key);
			if($tmp[0]=='iso'){
				if($firstAdd==0){
					$value .= $tmp[1]."='".addslashes($val)."'";
					$firstAdd = 1;
				}else{
					$value .= ",".$tmp[1]."='".addslashes($val)."'";
				}
			}
		}
		/** Discount */
		if(Input::post('action')=='new'){ $value.= ",is_trash='0'";}
		$discount_rule = Input::post('iso-discount_rule');
		$discount_type = Input::post('discount_type','percentage');
		$discount_value = Input::post('discount_value',0);
		$requires_minimum_purchase = $clsISO->toInt(Input::post('requires_minimum_purchase',0));
		if($discount_type=='free_shipping'){
			$discount_value = 0;
		} else if($discount_type=='amount'){
			$discount_value = $clsISO->processSmartNumber2($discount_value);
		}
		$minimum_purchase = 0;
		if($requires_minimum_purchase==1){
			$minimum_purchase = $clsISO->processSmartNumber2(Input::post('minimum_purchase',0));
		}
		$more_information['discount_type'] = $discount_type;
		$more_information['discount_value'] = $discount_value;
		$more_information['requires_minimum_purchase'] = $requires_minimum_purchase;
		$more_information['minimum_purchase'] = $minimum_purchase;
		$more_information['once_per_order'] = $clsISO->toInt(Input::post('once_per_order',0));
		/** Voucher */
		$more_information['type'] = Input::post('type', 'all');
		/** Customer Group */
		if($discount_rule=='code'){
			$customer_group_type = Input::post('customer_group_type','all');
			$more_information['customer_group_type'] = $customer_group_type;
			if($customer_group_type=='group'){
				$list_customer_group = Input::post('list_customer_group');
				if(!empty($list_customer_group)){
					$more_information['list_customer_group'] = $list_customer_group;
				}else{
					$errorNo++;
					$err[] = 'Chưa lựa chọn Nhóm khách hàng';
				}
			}
		}
		/** Limit Usage */  
		$allow_usage_limit = $clsISO->toInt(Input::post('allow_usage_limit',0));
		$usage_limit = (int) Input::post('usage_limit',0);
		if($allow_usage_limit==1 && $usage_limit==0) $allow_usage_limit = 0;
		$more_information['allow_usage_limit'] = $allow_usage_limit;
		$more_information['usage_limit'] = $usage_limit;
		$more_information['once_per_customer'] = $clsISO->toInt(Input::post('once_per_customer',0));
		/** Condition apply */
		if($discount_rule=='promotion'){
			$has_promotion_voucher_cond = $clsISO->toInt(Input::post('has_promotion_voucher_cond',0));
			$more_information['has_promotion_voucher_cond'] = $has_promotion_voucher_cond;
			if($has_promotion_voucher_cond==1){
				$promotion_voucher_cond_type = Input::post('promotion_voucher_cond_type','quantity');
				$minimum_promotion_voucher_total_price = Input::post('minimum_promotion_voucher_total_price');
				$minimum_promotion_voucher_total_price = $clsISO->processSmartNumber2($minimum_promotion_voucher_total_price);
				$minimum_promotion_voucher_quntity = Input::post('minimum_promotion_voucher_quntity', 0);
				$more_information['promotion_voucher_cond_type'] = $promotion_voucher_cond_type;
				$more_information['minimum_promotion_voucher_quntity'] = $minimum_promotion_voucher_quntity;
				$more_information['minimum_promotion_voucher_total_price'] = $minimum_promotion_voucher_total_price;
			}
		}
		// Time
		$start_date = Input::post('start_date');
		$start_time = Input::post('start_time');
		$is_due_date = $clsISO->toInt(Input::post('is_due_date',0));
		$due_date = Input::post('due_date');
		$due_time = Input::post('due_time');
		$value.= ",start_date='".$clsISO->convertTextToTime($start_date, $start_time)."',is_due_date='{$is_due_date}'";
		
		
		if($is_due_date) {
			$start_date_check=$clsISO->convertTextToTime($start_date, $start_time);
			$due_date_check=$clsISO->convertTextToTime($due_date, $due_time);
			if($due_date_check >$start_date_check){
				$due_date_check=$due_date_check;
			}else{
				$due_date_check=$due_date_check+86400;
			}
			$value .= ",due_date='".$due_date_check."'";
			$more_information['is_due_date'] = $is_due_date;
			$more_information['due_date'] = $clsISO->convertTextToTime($due_date, $due_time);
		} 
		$value.= ",more_information='".json_encode($more_information)."'";
		$value .= ",user_id_update='".$user_id."',upd_date='".time()."'";
		//print_r($pvalTable); die();
		//print_r($clsClassTable->updateOne($pvalTable,$value, true)); die();
		if($clsClassTable->updateOne($pvalTable,$value)){
			if($_POST['button']=='_EDIT'){
				header('Location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&'.$pkeyTable.'='.$pvalTable.'&message=UpdateSuccess');
				exit();
			} else if($_POST['button']=='_LIST'){
				header('Location: '.PCMS_URL.'/?mod='.$mod.'&message=updateSuccess');
				exit();
			}	
		} else {
			header('Location: '.PCMS_URL.'/?mod='.$mod.'&message=UpdateError');
			exit();
		}
	}
}

function default_ajSearchProducts(){
	// ini_set('display_errors', '1');
	// ini_set('display_startup_errors', '1');
	// error_reporting(E_ALL);
	global $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $clsConfiguration;
	#

	$product_group = Input::post('product_group', 'tour');
	$keyword       = trim(Input::post('keyword', ''));
	$discount_id   = (int) Input::post('discount_id', 0);

	$product_table = 'Tour';
	$id_field      = 'tour_id';
	$code_field    = 'trip_code';
	$label         = 'Tour';
	$cls_table     = 'Tour';

	$cond = "is_trash=0 and is_online=1";

	$keyword = addslashes($keyword);

	switch ($product_group) {

		case 'tour':
			$product_table = 'Tour';
			$id_field      = 'tour_id';
			$code_field    = 'trip_code';
			$label         = 'Tour';
			$cls_table     = 'Tour';

			$cond .= " and (
				title like '%{$keyword}%'
				or slug like '%{$keyword}%'
				or trip_code like '%{$keyword}%'
			)";
			break;


		case 'hotel':
			$product_table = 'Hotel';
			$id_field      = 'hotel_id';
			$code_field    = 'hotel_code';
			$label         = 'Hotel';
			$cls_table     = 'Hotel';

			$cond .= " and (
				title like '%{$keyword}%'
				or slug like '%{$keyword}%'
				or hotel_code like '%{$keyword}%'
			)";
			break;


		case 'cruise':
			$product_table = 'Cruise';
			$id_field      = 'cruise_id';
			$code_field    = 'cruise_code';
			$label         = 'Cruise';
			$cls_table     = 'Cruise';

			$cond .= " and (
				title like '%{$keyword}%'
				or slug like '%{$keyword}%'
				or cruise_code like '%{$keyword}%'
			)";
			break;


		case 'voucher':
			$product_table = 'Voucher';
			$id_field      = 'voucher_id';
			$code_field    = 'code';
			$label         = 'Voucher';
			$cls_table 	   = 'Voucher';

			$cond .= " and (
				title like '%{$keyword}%'
				or slug like '%{$keyword}%'
				or code like '%{$keyword}%'
			)";
			break;


		default:
			echo @json_encode([
				'status' => 'error',
				'html' => '',
				'message' => 'Invalid product group'
			]);
			exit;
	}
	
	/* ================================
	* LOẠI PRODUCT ĐÃ CÓ TRONG DISCOUNT
	* ================================ */

	if ($discount_id > 0) {

		$clsDiscountItem = new DiscountItem();
		$condItem = "discount_id=" .$discount_id . " and clsTable='" . addslashes($cls_table) . "'"; 
		$lstDiscountItem = $clsDiscountItem->getAll($condItem);
		//var_dump($discount_id, $cls_table); die('123');
		if (!empty($lstDiscountItem)) {

			$existItemIds = [];

			foreach ($lstDiscountItem as $item) {

				if (!empty($item['item_id'])) {
					$existItemIds[] = (int) $item['item_id'];
				}
			}
			
			if (!empty($existItemIds)) {

				$existItemIds = array_unique($existItemIds);

				$cond .= " and {$id_field} NOT IN ("
					. implode(',', $existItemIds)
					. ")";
			}
		}
	}


	$order_by = " order by order_no ASC";

	$clsClassTable = new $product_table;

	$lstItems = $clsClassTable->getAll($cond . $order_by);

	$html = '';

	if (!empty($lstItems)) {

		foreach ($lstItems as $item) {

			$product_id   = isset($item[$id_field]) ? $item[$id_field] : '';
			$product_code = isset($item[$code_field]) ? $item[$code_field] : '';
			$product_name = isset($item['title']) ? $item['title'] : '';
			$product_image = isset($item['image']) ? $item['image'] : '';

			$meta = $label . ' · ' . $product_code;

			$html .= '<button
				type="button"
				class="tm-picker__item"
				data-add="' . htmlspecialchars($product_id) . '"
				data-table="' . htmlspecialchars($product_table) . '"
				data-product-id="' . htmlspecialchars($product_id) . '"
				data-product-code="' . htmlspecialchars($product_code) . '"
				data-product-name="' . htmlspecialchars($product_name) . '">';

			$html .= '<img
				src="' . htmlspecialchars($product_image) . '"
				alt="">';

			$html .= '<span>';

			$html .= '<strong>'
				. htmlspecialchars($product_name)
				. '</strong>';

			$html .= '<br>';

			$html .= '<span style="color:var(--text-2);font-size:12px;">'
				. htmlspecialchars($meta)
				. '</span>';

			$html .= '</span>';

			$html .= '</button>';
		}

	} else {

		$html = '<div class="tm-picker__empty">
			No products found
		</div>';
	}


	$result = [
		'status'        => 'success',
		'html'          => $html,
		'product_group' => $product_group,
		'keyword'       => $keyword
	];

	echo @json_encode($result);
	exit;

}

function default_ajRemoveProduct(){
	global $assign_list,$_CONFIG,$_SITE_ROOT,$mod,$act;
	global $core,$clsModule,$clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];

	$clsDiscountItem = new DiscountItem();
	$item_id = (int) Input::post('id',0);
	$type = Input::post('type', '');

	if($item_id > 0){
		$itemDiscount = $clsDiscountItem->getall('item_id='.$item_id . ' and clsTable="' . $type . '"');
		if (!empty($itemDiscount)) {

			$discount_item_id = intval($itemDiscount[0]['discount_item_id']);

			if ($discount_item_id > 0) {
				if ($clsDiscountItem->deleteOne($discount_item_id)) {
					$result = ['status' => 'success'];
				} else {
					$result = ['status' => 'error'];
				}
				
			}

		}
	}
	if(!isset($result)){
		$result = ['status' => 'error'];
	}
	// Return
	echo @json_encode($result);
	exit;
}

function default_ajAddDiscountItem(){

    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;

    $user_id = $core->_USER['user_id'];

    $clsDiscountItem = new DiscountItem();

    $discount_id = (int) Input::post('discount_id', 0);
    $item_id     = (int) Input::post('item_id', 0);
    $type        = trim(Input::post('type', ''));

    if ($discount_id <= 0 || $item_id <= 0 || empty($type)) {

        $result = array(
            'status'  => 'error',
            'message' => 'Invalid data'
        );

        echo @json_encode($result);
        exit;
    }

    // Kiểm tra item đã tồn tại
    $itemDiscount = $clsDiscountItem->getAll(
        'discount_id=' . $discount_id .
        ' and item_id=' . $item_id .
        ' and clsTable="' . addslashes($type) . '"' .
        ' and is_trash=0'
    );

    if (!empty($itemDiscount)) {

        $result = array(
            'status' => 'exists',
            'discount_item_id' => intval($itemDiscount[0]['discount_item_id']),
            'message' => 'This item already exists.'
        );

        echo @json_encode($result);
        exit;
    }

    /*
     * Lấy thông tin Product
     */
    $product_name = '';
    $product_code = '';
    $product_image = '';

    if ($type == 'Tour') {

        $clsTour = new Tour();

        $product_name = $clsTour->getTitle($item_id);
        $product_code = $clsTour->getOneField('trip_code', $item_id);
        $product_image = $clsTour->getOneField('image', $item_id);

    } 
	if ($type == 'Hotel') {

        $clsHotel = new Hotel();

        $product_name = $clsHotel->getTitle($item_id);
        $product_code = $clsHotel->getOneField('hotel_code', $item_id);
        $product_image = $clsHotel->getOneField('image', $item_id);
    }

	if ($type == 'Cruise') {

        $clsCruise = new Cruise();

        $product_name = $clsCruise->getTitle($item_id);
        $product_code = $clsCruise->getOneField('cruise_code', $item_id);
        $product_image = $clsCruise->getOneField('image', $item_id);
    }

	if ($type == 'Voucher') {

        $clsVoucher = new Voucher();

        $product_name = $clsVoucher->getTitle($item_id);
        $product_code = $clsVoucher->getOneField('code', $item_id);
        $product_image = $clsVoucher->getOneField('image', $item_id);
    }

    /*
     * Insert Discount Item
     */
    $now = time();

    $fields = 'discount_id,clsTable,item_id,status,user_id,user_id_update,reg_date,upd_date,is_trash';

    $values = "'" . $discount_id . "','" .
              addslashes($type) . "','" .
              $item_id . "','0','" .
              $user_id . "','" .
              $user_id . "','" .
              $now . "','" .
              $now . "','0'";
	
    $insert = $clsDiscountItem->insertOne($fields, $values);

    if (!$insert) {

        $result = array(
            'status'  => 'error',
            'message' => 'Cannot add discount item.'
        );

        echo @json_encode($result);
        exit;
    }

    /*
     * Lấy lại record vừa insert
     */
    $itemDiscount = $clsDiscountItem->getAll(
        'discount_id=' . $discount_id .
        ' and item_id=' . $item_id .
        ' and clsTable="' . addslashes($type) . '"' .
        ' and is_trash=0'
    );

    if (empty($itemDiscount)) {

        $result = array(
            'status'  => 'error',
            'message' => 'Cannot get discount item.'
        );

        echo @json_encode($result);
        exit;
    }

    $discount_item_id = intval(
        $itemDiscount[0]['discount_item_id']
    );

    /*
     * Escape HTML
     */
    $product_name = htmlspecialchars(
        $product_name,
        ENT_QUOTES,
        'UTF-8'
    );

    $product_code = htmlspecialchars(
        $product_code,
        ENT_QUOTES,
        'UTF-8'
    );

    $product_image = htmlspecialchars(
        $product_image,
        ENT_QUOTES,
        'UTF-8'
    );

    $type_html = htmlspecialchars(
        $type,
        ENT_QUOTES,
        'UTF-8'
    );

    /*
     * HTML Selected Item
     */
    $html = '
    <div class="tm-product-item"
         data-discount-item-id="' . $discount_item_id . '"
         data-item-id="' . $item_id . '"
         data-type="' . $type_html . '">

        <img src="' . $product_image . '"
             alt="' . $product_name . '">

        <div class="tm-product-item__info">

            <div class="tm-product-item__name">
                ' . $product_name . '
            </div>

            <div class="tm-product-item__meta">
                ' . $type_html;

    if ($product_code != '') {
        $html .= ' | ' . $product_code;
    }

    $html .= '
            </div>

        </div>

        <button type="button"
                class="tm-icon-btn"
                data-remove="' . $item_id . '"
                data-type="' . $type_html . '"
                data-discount-item-id="' . $discount_item_id . '"
                aria-label="Remove ' . $product_name . '">

            <i class="fa-solid fa-xmark"></i>

        </button>

    </div>';

    $result = array(
        'status'           => 'success',
        'discount_item_id' => $discount_item_id,
        'item_id'          => $item_id,
        'type'             => $type,
        'html'             => $html
    );

    echo @json_encode($result);
    exit;
}

function default_edit(){
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act,$oneSetting,$clsISO;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsProperty = new Property();
	$assign_list['clsProperty'] = $clsProperty;
	$lstGroup = $clsProperty->getAll("property_type='_PROFILE_GROUP' order by order_no ASC");
	$assign_list['lstGroup'] = $lstGroup; unset($lstGroup);
	
	$discount_rule = Input::get('discount_rule', 'code');
	if(!in_array($discount_rule, array('code','promotion'))){
		header('Location:'.PCMS_URL.'/index.php?mod='.$mod);
		exit();
	}
	
	$classTable = "Discount";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	#
	$action = Input::get('action', '_edit');
	$pvalTable = (int) Input::get($pkeyTable,0);
	$oneItem = $clsClassTable->getOne($pvalTable);
	$more_information = $oneItem['more_information'];
	$more_information = !empty($more_information) ? @json_decode($more_information, true) : array();
	if(!empty($more_information)){
		$oneItem = array_merge($more_information, $oneItem);
	}
	$assign_list['action'] = $action;
	$assign_list['oneItem'] = $oneItem;
	$assign_list['pvalTable'] = $pvalTable;
	$list_customer_group = $oneItem['list_customer_group'];
	$list_customer_group = !empty($list_customer_group) ? @json_decode($list_customer_group, true) : array();
	$assign_list['list_customer_group'] = $list_customer_group;
	
	$errorNo = 0;
	$errorMsg = array();
	if(Input::exists('submit') && Input::post('submit')=='Update'){
		$value = ""; $firstAdd = 0;
		foreach($_POST as $key=>$val){
			$tmp = explode('-',$key);
			if($tmp[0]=='iso'){
				if($firstAdd==0){
					$value .= $tmp[1]."='".addslashes($val)."'";
					$firstAdd = 1;
				}else{
					$value .= ",".$tmp[1]."='".addslashes($val)."'";
				}
			}
		}
		/** Discount */
		if(Input::post('action')=='new'){ $value.= ",is_trash='0'";}
		$discount_rule = Input::post('iso-discount_rule');
		$discount_type = Input::post('discount_type','percentage');
		$discount_value = Input::post('discount_value',0);
		$requires_minimum_purchase = $clsISO->toInt(Input::post('requires_minimum_purchase',0));
		if($discount_type=='free_shipping'){
			$discount_value = 0;
		} else if($discount_type=='amount'){
			$discount_value = $clsISO->processSmartNumber2($discount_value);
		}
		$minimum_purchase = 0;
		if($requires_minimum_purchase==1){
			$minimum_purchase = $clsISO->processSmartNumber2(Input::post('minimum_purchase',0));
		}
		$more_information['discount_type'] = $discount_type;
		$more_information['discount_value'] = $discount_value;
		$more_information['requires_minimum_purchase'] = $requires_minimum_purchase;
		$more_information['minimum_purchase'] = $minimum_purchase;
		$more_information['once_per_order'] = $clsISO->toInt(Input::post('once_per_order',0));
		/** Voucher */
		$more_information['type'] = Input::post('type', 'all');
		/** Customer Group */
		if($discount_rule=='code'){
			$customer_group_type = Input::post('customer_group_type','all');
			$more_information['customer_group_type'] = $customer_group_type;
			if($customer_group_type=='group'){
				$list_customer_group = Input::post('list_customer_group');
				if(!empty($list_customer_group)){
					$more_information['list_customer_group'] = $list_customer_group;
				}else{
					$errorNo++;
					$err[] = 'Chưa lựa chọn Nhóm khách hàng';
				}
			}
		}
		/** Limit Usage */  
		$allow_usage_limit = $clsISO->toInt(Input::post('allow_usage_limit',0));
		$usage_limit = (int) Input::post('usage_limit',0);
		if($allow_usage_limit==1 && $usage_limit==0) $allow_usage_limit = 0;
		$more_information['allow_usage_limit'] = $allow_usage_limit;
		$more_information['usage_limit'] = $usage_limit;
		$more_information['once_per_customer'] = $clsISO->toInt(Input::post('once_per_customer',0));
		/** Condition apply */
		if($discount_rule=='promotion'){
			$has_promotion_voucher_cond = $clsISO->toInt(Input::post('has_promotion_voucher_cond',0));
			$more_information['has_promotion_voucher_cond'] = $has_promotion_voucher_cond;
			if($has_promotion_voucher_cond==1){
				$promotion_voucher_cond_type = Input::post('promotion_voucher_cond_type','quantity');
				$minimum_promotion_voucher_total_price = Input::post('minimum_promotion_voucher_total_price');
				$minimum_promotion_voucher_total_price = $clsISO->processSmartNumber2($minimum_promotion_voucher_total_price);
				$minimum_promotion_voucher_quntity = Input::post('minimum_promotion_voucher_quntity', 0);
				$more_information['promotion_voucher_cond_type'] = $promotion_voucher_cond_type;
				$more_information['minimum_promotion_voucher_quntity'] = $minimum_promotion_voucher_quntity;
				$more_information['minimum_promotion_voucher_total_price'] = $minimum_promotion_voucher_total_price;
			}
		}
		// Time
		$start_date = Input::post('start_date');
		$start_time = Input::post('start_time');
		$is_due_date = $clsISO->toInt(Input::post('is_due_date',0));
		$due_date = Input::post('due_date');
		$due_time = Input::post('due_time');
		$value.= ",start_date='".$clsISO->convertTextToTime($start_date, $start_time)."',is_due_date='{$is_due_date}'";
		
		
		if($is_due_date) {
			$start_date_check=$clsISO->convertTextToTime($start_date, $start_time);
			$due_date_check=$clsISO->convertTextToTime($due_date, $due_time);
			if($due_date_check >$start_date_check){
				$due_date_check=$due_date_check;
			}else{
				$due_date_check=$due_date_check+86400;
			}
			$value .= ",due_date='".$due_date_check."'";
			$more_information['is_due_date'] = $is_due_date;
			$more_information['due_date'] = $clsISO->convertTextToTime($due_date, $due_time);
		} 
		$value.= ",more_information='".json_encode($more_information)."'";
		$value .= ",user_id_update='".$user_id."',upd_date='".time()."'";
		//print_r($pvalTable); die();
		//print_r($clsClassTable->updateOne($pvalTable,$value, true)); die();
		if($clsClassTable->updateOne($pvalTable,$value)){
			if($_POST['button']=='_EDIT'){
				header('Location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&'.$pkeyTable.'='.$pvalTable.'&message=UpdateSuccess');
				exit();
			} else if($_POST['button']=='_LIST'){
				header('Location: '.PCMS_URL.'/?mod='.$mod.'&message=updateSuccess');
				exit();
			}	
		} else {
			header('Location: '.PCMS_URL.'/?mod='.$mod.'&message=UpdateError');
			exit();
		}
	}
}
function default_trash(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Discount";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	
	$pvalTable = isset($_GET[$pkeyTable])? (int) $_GET[$pkeyTable] : 0;
	if($pvalTable == 0) 
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=notPermission');
	
	if($clsClassTable->updateOne($pvalTable,"is_trash='1'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=TrashSuccess');
	}
}
function default_restore(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Discount";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	
	$pvalTable = isset($_GET[$pkeyTable])? (int) $_GET[$pkeyTable] : 0;
	if($pvalTable == 0)
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=notPermission');
	
	if($clsClassTable->updateOne($pvalTable,"is_trash='0'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=RestoreSuccess');
	}
}
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Discount";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	
	$pvalTable = isset($_GET[$pkeyTable])? (int) $_GET[$pkeyTable] : 0;
	if($pvalTable == 0) 
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=notPermission');
		
	if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=DeleteSuccess');
	}
}
function default_open_discount(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsISO;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$clsDiscount = new Discount();
	$clsDiscountItem = new DiscountItem();
	#
	$action = '_edit';
	$discount_id = (int) Input::post('discount_id', 0);
	if($discount_id == 0){
		$action = '_add';
		$clsDiscount->deleteByCond("is_draft=1 and is_trash=1 and user_id='".$core->_USER['user_id']."'");
		$discount_id = $clsDiscount->getMaxId();
		$more_information = array(
			'discount_type' => 2,
			'discount_value' => 0,
			'product_type' => 'product',
			'allow_usage_limit' => 0,
			'use_addon_service' => 0,
			'use_extra_bed' => 0
		);
		$clsDiscount->insert(array(
			'discount_id' => $discount_id,
			'more_information' => json_encode($more_information),
			'user_id' => $core->_USER['user_id'],
			'reg_date' => time(),
			'is_trash' => 1,
			'is_draft' => 1
		));
	} 
	$smarty->assign('action',$action);
	$smarty->assign('discount_id',$discount_id);
	$oneItem = $clsDiscount->getOne($discount_id);
	$more_information = !empty($oneItem['more_information']) 
		? @json_decode($oneItem['more_information'], true) : array();
	$weekdays_arr = !empty($oneItem['weekdays']) 
		? json_decode($oneItem['weekdays'], true) : array();
	$smarty->assign('oneItem',$oneItem);
	$smarty->assign('weekdays_arr',$weekdays_arr);
	$smarty->assign('more_information',$more_information);
	#
	$lstDay = $weekdays_arr = array(
		'Mon' => 'Mo',
		'Tue' => 'Tu',
		'Wed' => 'We',
		'Thu' => 'Th',
		'Fri' => 'Fr',
		'Sat' => 'Sa',
		'Sun' => 'Su'
	);
	$smarty->assign('lstDay',$lstDay);
	// Return
	$smarty->assign('mod', $mod);
	$smarty->assign('core', $core);
	$smarty->assign('template', '_add');
	$html = $clsISO->build('_ajax.form.tpl');
	echo $html;
    die();
	// echo json_encode(array(
	// 	'html' => $html,
	// 	'action' => $action,
	// 	'discount_id' => $discount_id
	// )); die();
}
function default_pop_save_discount(){
	global $assign_list,$_CONFIG,$_SITE_ROOT,$mod,$act;
	global $core,$clsModule,$clsButtonNav,$oneSetting, $clsISO;
	$clsDiscount = new Discount();
	$clsDiscountItem = new DiscountItem();
	$discount_id = Input::post('discount_id', 0);
	$title = Input::post('title', "");
	$description = Input::post('description', "");
	$weekdays = Input::post('weekdays', array());
	$promo_type = Input::post('promo_type', 1);
	#
	$booking_date_from = trim(Input::post('booking_date_from', ''));
	$booking_date_to   = trim(Input::post('booking_date_to', ''));
	$travel_date_from  = trim(Input::post('travel_date_from', ''));
	$travel_date_to    = trim(Input::post('travel_date_to', ''));

	$booking_date_from = $booking_date_from
		? strtotime($booking_date_from . ' 00:00:00')
		: 0;

	$booking_date_to = $booking_date_to
		? strtotime($booking_date_to . ' 23:59:59')
		: 0;

	$travel_date_from = $travel_date_from
		? strtotime($travel_date_from . ' 00:00:00')
		: 0;

	$travel_date_to = $travel_date_to
		? strtotime($travel_date_to . ' 23:59:59')
		: 0;

	$msg = '_error';
	if($discount_id > 0){
		//$clsDiscount->setDebug(true);
		$_POST['is_alldays'] = Input::post('is_alldays', 0);
		$_POST['allow_usage_limit'] = Input::post('allow_usage_limit', 0);
		$product_type = Input::post('product_type', "");
		var_dump($_POST);
		if($clsDiscount->update($discount_id, array(
			'is_trash' => 0,
			'is_draft' => 0,
			'title' => $title,
			'slug' => $core->replaceSpace($title),
			'description' => html_entity_decode($description),
			'code' => Input::post('code'),
			'type' => $promo_type,
			'product_type' => $product_type,
			'booking_date_from' => $booking_date_from,
			'booking_date_to' => $booking_date_to,
			'travel_date_from' => $travel_date_from,
			'travel_date_to' => $travel_date_to,
			'weekdays' => @json_encode($weekdays),
			'more_information' => @json_encode($_POST)
		))){
			if($product_type == 'all'){
				$clsDiscountItem->deleteByCond("discount_id='".$discount_id."'");	
			}			
			$msg = '_success';
		}
	}
	// Return
	echo $msg; die();
}
function default_load_search_tours(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$clsTour = new Tour(); 
	$clsTourCat = new TourCategory();
	#
	$results = array();
	$keyword = Input::post('q');
	$cat_id = (int) Input::post('cat_id', 0);
	$discount_id = (int) Input::request('discount_id', 0);
	$page = (int) Input::post('page',1);
	$rows = (int) Input::post('rows',20);
	$offset = ($page-1) * $rows;
	$limitCond = " limit {$offset},{$rows}";
	#
	$cond = "is_trash=0 and is_online=1";
	if($cat_id > 0) {
		$cond .= " and (cat_id='{$cat_id}' or list_cat_id like '%|{$cat_id}|%')";
	}
	if(!empty($keyword)){
		$slug = $core->replaceSpace($keyword);
		$cond .= " and (slug like '%{$slug}%' or trip_code like '%{$keyword}%')";
	}
	$field = "{$clsTour->pkey},trip_code,title";
	$results['total'] = $clsTour->countItem($cond);
	$list_items = $clsTour->getAll($cond." order by reg_date DESC".$limitCond, $field);
	if(!empty($list_items)){
		foreach($list_items as $key=>$val){
			$tour_id = $val[$clsTour->pkey];
			$results['rows'][] = array(
				'itemid' => '<button type="button" class="btn btn-xxs btn-success" onClick="add_product(this)" clsTable="Tour" discount_id="'.$discount_id.'" item_id="'.$tour_id.'" >+</button>',
				'title' => $clsTour->getTitle($tour_id, $val),
				'trip_code' => $clsTour->getTripCode($tour_id, $val),
				'duration' => $clsTour->getTripDuration2020($val[$clsTour->pkey],'/ ')
			);
		}
	}
	// Return
	echo json_encode($results); die();
}
function default_load_search_hotels(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$clsHotel= new Hotel(); 
	#
	$results = array();
	$keyword = Input::post('q');
	$discount_id = (int) Input::request('discount_id', 0);
	$country_id = (int) Input::post('country_id', 0);
	$city_id = (int) Input::post('city_id', 0);
	$star_id = (int) Input::post('star_id', 0);
	$page = (int) Input::post('page',1);
	$rows = (int) Input::post('rows',20);
	$offset = ($page-1) * $rows;
	$limitCond = " limit {$offset},{$rows}";
	#
	$cond = "is_trash=0 and is_online=1";
	if($country_id > 0) $cond.= " and country_id='{$country_id}'";
	if($city_id) $cond.= " and city_id='{$city_id}'";
	if($star_id) $cond.= " and star_id='{$star_id}'";
	if(!empty($keyword)){
		$slug = $core->replaceSpace($keyword);
		$cond .= " and (slug like '%{$slug}%')";
	}
	$field = "{$clsHotel->pkey},title,address,star_id";
	$results['total'] = $clsHotel->countItem($cond);
	$list_items = $clsHotel->getAll($cond." order by reg_date DESC".$limitCond, $field);
	if(!empty($list_items)){
		foreach($list_items as $key=>$val){
			$results['rows'][] = array(
				'itemid' => '<button type="button" class="btn btn-xxs btn-success" onClick="add_product(this)" clsTable="Hotel" discount_id="'.$discount_id.'" item_id="'.$val[$clsHotel->pkey].'">+</button>',
				'title' => $val['title'],
				'address' => $val['address'],
				'star' => '<img src="'.$clsHotel->getImageStar($val['star_id']).'" />',
				'price' => $clsHotel->getPrice($val[$clsHotel->pkey])
			);
		}
	}
	// Return
	echo json_encode($results); die();
}
function default_load_search_cruises(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$clsCruise = new Cruise(); 
	
	$results = array();
	$keyword = Input::post('q');
	$discount_id = (int) Input::request('discount_id', 0);
	$cruise_cat_id = (int) Input::post('cruise_cat_id', 0);
	$page = (int) Input::post('page',1);
	$rows = (int) Input::post('rows',20);
	$offset = ($page-1) * $rows;
	$limitCond = " limit {$offset},{$rows}";
	#
	$cond = "`is_trash`=0 and `is_online`=1";
	if($cruise_cat_id > 0){
		$cond .= " and `cruise_cat_id`='{$cruise_cat_id}'";
	}
	if(!empty($keyword)){
		$slug = $core->replaceSpace($keyword);
		$cond .= " and (
			slug like '%{$slug}%' 
			or cruise_code like '%{$keyword}%'
		)";
	}
	$field = "{$clsCruise->pkey},title";
	$results['total'] = $clsCruise->countItem($cond);
	$list_items = $clsCruise->getAll($cond." order by reg_date DESC".$limitCond, $field);
	if(!empty($list_items)){
		foreach($list_items as $key=>$val){
			$results['rows'][] = array(
				'itemid' => '<button type="button" class="btn btn-xxs btn-success" onClick="add_product(this)" clsTable="Cruise" discount_id="'.$discount_id.'" item_id="'.$val[$clsCruise->pkey].'">+</button>',
				'title' => $val['title']
			);
		}
	}
	// Return
	echo json_encode($results); die();
}
function default_load_search_combo(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$clsCombo = new Combo(); 
	#
	$results = array();
	$keyword = Input::post('q');
	$discount_id = (int) Input::post('discount_id', 0);
	$page = (int) Input::post('page',1);
	$rows = (int) Input::post('rows',20);
	$offset = ($page-1) * $rows;
	$limitCond = " limit {$offset},{$rows}";
	#
	$cond = "`is_trash`=0 and `is_online`=1";
	if(!empty($keyword)){
		$slug = $core->replaceSpace($keyword);
		$cond .= " and (
			slug like '%{$slug}%' 
		)";
	}
	$field = "{$clsCombo->pkey},title,booking_date_from,booking_date_to,travel_date_from,travel_date_to";
	$results['total'] = $clsCombo->countItem($cond);
	$list_items = $clsCombo->getAll($cond." order by reg_date DESC".$limitCond, $field);
	if(!empty($list_items)){
		foreach($list_items as $key=>$val){
			$results['rows'][] = array(
				'itemid' => '<button type="button" class="btn btn-xxs btn-success" onClick="add_product(this)" clsTable="Combo" discount_id="'.$discount_id.'" item_id="'.$val[$clsCombo->pkey].'">+</button>',
				'title' => $val['title'],
				'booking_date' => $clsISO->convertTimeToText($val['booking_date_from']) . ' - ' . $clsISO->convertTimeToText('booking_date_to'),
				'travel_date' => $clsISO->convertTimeToText($val['travel_date_from']) . ' - ' . $clsISO->convertTimeToText('travel_date_to'),
			);
		}
	}
	// Return
	echo json_encode($results); die();
}
function default_load_search_voucher(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$clsVoucher = new Voucher(); 
	$clsVoucherCat = new VoucherCat();
	
	$results = array();
	$keyword = Input::post('q');
	$cat_id = (int) Input::post('cat_id', 0);
	$discount_id = (int) Input::request('discount_id', 0);
	$page = (int) Input::post('page',1);
	$rows = (int) Input::post('rows',20);
	$offset = ($page-1) * $rows;
	$limitCond = " limit {$offset},{$rows}";
	#
	$cond = "`is_trash`=0 and `is_online`=1";
	if($cat_id > 0){
	$cond .= " and (cat_id='{$cat_id}' 
			or list_cat_id like '%|{$cat_id}|%'
		)";
	}
	if(!empty($keyword)){
		$slug = $core->replaceSpace($keyword);
		$cond .= " and (
			slug like '%{$slug}%' 
			or cruise_code like '%{$keyword}%'
		)";
	}
	$field = "{$clsVoucher->pkey},title,cat_id";
	$results['total'] = $clsVoucher->countItem($cond);
	$list_items = $clsVoucher->getAll($cond." order by reg_date DESC".$limitCond, $field);
	if(!empty($list_items)){
		foreach($list_items as $key=>$val){
			$results['rows'][] = array(
				'itemid' => '<button type="button" class="btn btn-xxs btn-success" onClick="add_product(this)" discount_id="'.$discount_id.'" clsTable="Voucher" item_id="'.$val[$clsVoucher->pkey].'">+</button>',
				'title' => $val['title'],
				'category' => $clsVoucherCat->getTitle($val['cat_id']),
				'price' => '0.00'
			);
		}
	}
	// Return
	echo json_encode($results); die();
}
function default_get_select_city(){
	global $dbconn,$assign_list,$_CONFIG,$_SITE_ROOT,$mod,$_LANG_ID,$act,$core,$clsModule,$clsConfiguration,$clsISO;
	$clsCity = new City();
	$clsHotel = new Hotel();
	#
	$country_id = (int) Input::post('country_id', 0);
	$region_id = (int) Input::post('region_id', 0);
	$city_id = (int) Input::post('city_id', 0);
	#
	$cond = "{$clsCity->tbl}.is_trash=0 and {$clsCity->tbl}.is_online=1 and {$clsHotel->tbl}.is_trash=0 and {$clsHotel->tbl}.is_online=1";
	if($country_id > 0){$cond .= " and {$clsCity->tbl}.country_id='{$country_id}'";}
	if($region_id > 0){$cond .= " and {$clsCity->tbl}.region_id='{$region_id}'";}
	$html = '<option value="0">'.$core->get_Lang('selectcity').'</option>';
	$lstCity = $clsCity->getAllOptimize("{$cond} order by {$clsCity->tbl}.order_no asc", "{$clsHotel->tbl} on {$clsCity->tbl}.city_id={$clsHotel->tbl}.city_id", "DISTINCT({$clsCity->tbl}.city_id),{$clsCity->tbl}.title");
	if(!empty($lstCity)){
		foreach($lstCity as $k => $v){
			$html .= '<option value="'.$v[$clsCity->pkey].'"'.($city_id==$v[$clsCity->pkey]?' selected':'').'>
				'.$clsCity->getTitle($v[$clsCity->pkey]).'
			</option>';
		}
		unset($lstCity);
	} else {
		$html = 'EMPTY';
	}
	// Return
	echo $html; die();
}
function default_handler_filter_objects(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$clsTour = new Tour(); 
	$clsTourCat = new TourCategory();
	#
	$discount_id = Input::post('discount_id');
	$product_type = Input::post('product_type');
	#
	$html = '';
	if($product_type=='tour'){
		$html = '<div class="form-group ">
			<label class="col-form-label">2.'.$core->get_Lang('Travel style').' <span class="text-red">*</span></label>
			<select class="form-control iso-selectbox filter_item_search" column="cat_id" data-width="100%" data-placeholder="'.$core->get_Lang('Travel style').'">
				'.$clsTourCat->makeSelectboxOption(0,0,0,true).'
			</select>
		</div>
		<div class="form-group">
			<label class="col-form-label">3.'.$core->get_Lang('Tour').' <span class="text-red">*</span></label>
			<select id="cboProduct" height="34" class="easyui-combogrid" prompt="'.$core->get_Lang('Search').'..." style="width:100%" data-options="
				panelWidth: 800,
				url: \''.PCMS_URL.'/index.php?mod='.$mod.'&act=load_search_tours&discount_id='.$discount_id.'\',
				mode: \'remote\',
				method:\'post\',
				multiple:true, 
				columns: [[
					{field:\'itemid\',title:\'\',width:30,align:\'center\'},
					{field:\'title\',title:\''.$core->get_Lang('Name').'\',width:220},
					{field:\'trip_code\',title:\''.$core->get_Lang('Trip Code').'\',width:80,align:\'left\'},
					{field:\'duration\',title:\''.$core->get_Lang('Duration Tour').'\',width:80,align:\'left\'}
				]],
				fitColumns: true,
				showFooter: true,
				pagination: true,
				pageSize: 20"></select>
		</div>';
	} else if($product_type=='hotel'){
		$clsCountry = new Country();
		$html .= '<div class="form-group">
			<iv class="form-row">
				<div class="col-xs-12 col-md-6">
					<label class="col-form-label">2.'.$core->get_Lang('Country').'</label>
					<select class="form-control slb_Country_Id iso-selectbox filter_item_search" column="country_id" onChange="get_select_city(this)" data-width="100%" data-placeholder="'.$core->get_Lang('Country').'">
						'.$clsCountry->makeSelectHotelOption(0).'
					</select>
				</div>
				<div class="col-xs-12 col-md-6">
					<label class="col-form-label">2.'.$core->get_Lang('City').'</label>
					<select class="form-control iso-selectbox slb_City_Id filter_item_search" column="city_id" data-width="100%" data-placeholder="'.$core->get_Lang('City').'"></select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-form-label">3.'.$core->get_Lang('Hotel').' <span class="text-red">*</span></label>
			 <select id="cboProduct" height="34" class="easyui-combogrid" prompt="'.$core->get_Lang('Search').'..." style="width:100%" data-options="
                    panelWidth: 800,
                    url: \''.PCMS_URL.'/index.php?mod='.$mod.'&act=load_search_hotels&discount_id='.$discount_id.'\',
                    mode: \'remote\',
					multiple:true, 
                    columns: [[
                        {field:\'itemid\',title:\'\',width:30,align:\'center\'},
                        {field:\'title\',title:\''.$core->get_Lang('Name').'\',width:120},
                        {field:\'address\',title:\''.$core->get_Lang('Address').'\',width:80,align:\'left\'},
                        {field:\'star\',title:\''.$core->get_Lang('Star').'\',width:40,align:\'left\'},
						{field:\'price\',title:\''.$core->get_Lang('Price').'\',width:40,align:\'right\'}
                    ]],
                    fitColumns: true,
					showFooter: true,
					pagination: true,
					pageSize: 20">
		</div>';
	} else if($product_type=='cruise'){
		$clsCruiseCat = new CruiseCat();
		$html .= '<div class="form-group ">
			<label class="col-form-label">2.'.$core->get_Lang('Category').'</label>
			<select class="form-control filter_item_search iso-selectbox" column="cruise_cat_id" data-width="100%" data-placeholder="'.$core->get_Lang('Travel style').'">
				'.$clsCruiseCat->makeSelectboxOption(0,0).'
			</select>
		</div>
		<div class="form-group">
			<label class="col-form-label">3.'.$core->get_Lang('Cruise').'</label>
			 <select id="cboProduct" class="easyui-combogrid" prompt="'.$core->get_Lang('Search Cruise').'..." style="width:100%" height="34" data-options="
                    panelWidth: 800,
                    idField: \'\',
                    textField: \'\',
                    url: \''.PCMS_URL.'/index.php?mod='.$mod.'&act=load_search_cruises&discount_id='.$discount_id.'\',
                    mode: \'remote\',
					multiple:true, 
                    columns: [[
						{field:\'itemid\',title:\'\',width:30,align:\'center\'},
                        {field:\'title\',title:\''.$core->get_Lang('Name').'\',width:120},
                        {field:\'listprice\',title:\'List Price\',width:80,align:\'right\'},
                        {field:\'unitcost\',title:\'Unit Cost\',width:80,align:\'right\'}
                    ]],
                    fitColumns: true,
					showFooter: true,
					pagination: true,
					pageSize: 20">
		</div>';
	} else if($product_type=='combo'){
		$html .= '<div class="form-group">
			<label class="col-form-label">3.'.$core->get_Lang('Product').' <span class="text-red">*</span></label>
			 <select id="cboProduct" class="easyui-combogrid" prompt="'.$core->get_Lang('Search').'..." height="34" style="width:100%" data-options="
                    panelWidth: 800,
                    idField: \'\',
                    textField: \'\',
                    url: \''.PCMS_URL.'/index.php?mod='.$mod.'&act=load_search_combo&discount_id='.$discount_id.'\',
                    method: \'post\',
					mode: \'remote\',
					multiple:true, 
                    columns: [[
                        {field:\'itemid\',title:\'\',width:30,align:\'center\'},
                        {field:\'title\',title:\''.$core->get_Lang('Name').'\',width:250},
                        {field:\'booking_date\',title:\''.$core->get_Lang('Booking Date').'\',width:120,align:\'right\'},
                        {field:\'travel_date\',title:\''.$core->get_Lang('Travel Date').'\',width:120,align:\'right\'}
                    ]],
                    fitColumns: true,
					showFooter: true,
					pagination: true,
					pageSize: 20">
		</div>';
	} else if($product_type=='voucher'){
		$clsVoucherCat = new VoucherCat();
		$html .= '<div class="form-group ">
			<label class="col-form-label">2.'.$core->get_Lang('Category').'</label>
			<select class="form-control filter_item_search iso-selectbox" column="cat_id" data-width="100%" data-placeholder="'.$core->get_Lang('Travel style').'">
				'.$clsVoucherCat->makeSelectboxOption(0,0).'
			</select>
		</div>
		<div class="form-group">
			<label class="col-form-label">3.'.$core->get_Lang('Product').' <span class="text-red">*</span></label>
			 <select id="cboProduct" class="easyui-combogrid" prompt="'.$core->get_Lang('Search').'..." height="34" style="width:100%" data-options="
                    panelWidth: 800,
                    idField: \'\',
                    textField: \'\',
                    url: \''.PCMS_URL.'/index.php?mod='.$mod.'&act=load_search_voucher&discount_id='.$discount_id.'\',
                    method: \'post\',
					mode: \'remote\',
					multiple:true, 
                    columns: [[
                        {field:\'itemid\',title:\'\',width:30,align:\'center\'},
                        {field:\'title\',title:\''.$core->get_Lang('Name').'\',width:200},
                        {field:\'category\',title:\''.$core->get_Lang('Category').'\',width:80,align:\'left\'},
                        {field:\'price\',title:\''.$core->get_Lang('Price').'\',width:80,align:\'right\'}
                    ]],
                    fitColumns: true,
					showFooter: true,
					pagination: true,
					pageSize: 20">
		</div>';
	}
	// Return
	echo @json_encode(array(
		'html' => $html
	)); die();
}
function default_stop_discount(){
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$clsDiscount = new Discount();
	$discount_id = Input::post('discount_id',0);
	
	$msg = '_error';
	if($clsDiscount->updateOne($discount_id, array(
		'status' => 0,
		'is_due_date' => 1,
		'due_date' => time()
	))){
		$msg = '_success';
	}
	echo $msg; die();
}
function default_continue_discount(){
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$clsDiscount = new Discount();
	$discount_id = Input::post('discount_id',0);
	
	$msg = '_error';
	$more_information = $clsDiscount->getOneField('more_information', $discount_id);
	$more_information = !empty($more_information) 
		? @json_decode($more_information, true) : array();
	if($clsDiscount->updateOne($discount_id, array(
		'status' => 1,
		'is_due_date' => $more_information['is_due_date'],
		'due_date' => $more_information['due_date']
	))){
		$msg = '_success';
	}
	echo $msg; die();
}
function default_add_product(){
	global $assign_list,$_CONFIG,$_SITE_ROOT,$mod,$act;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO;
	$clsDiscount = new Discount();
	$clsDiscountItem = new DiscountItem();
	
	$user_id = (int) $core->_USER['user_id'];
	$item_id = (int) Input::post('item_id', 0);
	$clsTable = Input::post('clsTable');
	$discount_id = (int) Input::post('discount_id', 0);
	
	$msg = '_error';
	if($clsDiscountItem->countItem("discount_id='{$discount_id}' and clsTable='{$clsTable}' and item_id='{$item_id}'") == 0){
		$discount_item_id = $clsDiscountItem->getMaxId();
		if($clsDiscountItem->insert(array(
			$clsDiscountItem->pkey => $discount_item_id,
			'clsTable' => $clsTable,
			'item_id' => $item_id,
			'discount_id' => $discount_id,
			'user_id' => $core->_USER['user_id'],
			'user_id_update' => $core->_USER['user_id'],
			'reg_date' => time(),
			'upd_date' => time()
		))){
			$msg = '_success';
		}
	} else {
		
	}
	// Return
	echo($msg); die();
}
function default_delete_product(){
	global $assign_list,$_CONFIG,$_SITE_ROOT,$mod,$act;
	global $core,$clsModule,$clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	$clsDiscount = new Discount();
	$clsDiscountItem = new DiscountItem();
	$discount_id = (int) Input::post('discount_id',0);
	$discount_item_id = (int) Input::post('discount_item_id',0);
	
	$msg = '_error';
	if($discount_item_id > 0){
		if($clsDiscountItem->deleteOne($discount_item_id)){
			$msg = '_success';
		}
	}
	// Return
	echo $msg; die();
}
function default_load_products_discount(){
	global $assign_list,$_CONFIG,$_SITE_ROOT,$mod,$act;
	global $core,$clsModule,$clsButtonNav,$oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	$clsTour = new Tour();
	$clsHotel = new Hotel();
	$clsCruise = new Cruise();
	$clsCombo = new Combo();
	$clsVoucher = new Voucher();
	$clsDiscount = new Discount();
	$clsDiscountItem = new DiscountItem();
	/* Variable */
	$discount_id = (int) Input::post('discount_id',0);
	$list_items = $clsDiscountItem->getAll("discount_id='{$discount_id}' order by reg_date DESC");
	//$clsISO->print_pre($list_items); die();
	$html = '';
	$total_items = 0;
	if(!empty($list_items)){
		$total_items = count($list_items);
		$html = '<ul class="list-igroup">';
		foreach($list_items as $key => $val){
			if($val['clsTable'] == 'Tour') {
                $clsClassTable = $clsTour;
                $link_item=DOMAIN_NAME.'/admin/tour/edit/'.$val['item_id'].'/overview';
            }
            if($val['clsTable'] == 'Hotel') {
                $clsClassTable = $clsHotel;
                $link_item=DOMAIN_NAME.'/admin/hotel/insert/'.$val['item_id'].'/overview';
            }
            if($val['clsTable'] == 'Cruise') {
                $clsClassTable = $clsCruise;
                $link_item=DOMAIN_NAME.'/admin/cruise/insert/'.$val['item_id'].'/overview';
            }
            if($val['clsTable'] == 'Combo') {
                $clsClassTable = $clsCombo;
                $link_item=DOMAIN_NAME.'/admin/combo/edit/'.$val['item_id'].'/overview';
            }
            if($val['clsTable'] == 'Voucher') {
                $clsClassTable = $clsVoucher;
                $link_item=DOMAIN_NAME.'/admin/voucher/insert/'.$val['item_id'].'/overview';
            }
			$html .= '<li>'.$clsClassTable->getTitle($val['item_id']).'
				<a target="_blank" href="'.$link_item.'" title="'.$core->get_Lang('View').'"><i class="icon-eye-open"></i></a><a href="javascript:void(0);" onClick="delete_product(this)" discount_id="'.$discount_id.'" discount_item_id="'.$val[$clsDiscountItem->pkey].'" class="remove"></a>
			</li>';
		}
		$html .= '</ul>';
	} else {
		$html = '<div class="loading text-center">
			'.$core->get_Lang('Not any data').'
		</div>';
	}
	// Return
	echo @json_encode(array(
		'html' => $html,
		'total_items' => $total_items
	)); die();
}
?>