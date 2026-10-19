<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$pUrl = "";
	#
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;

	#
	$classTable = "Car";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	$vehicle_type_id = isset($_GET['vehicle_type_id']) ? intval($_GET['vehicle_type_id']) : 0;
	$assign_list["vehicle_type_id"] = $vehicle_type_id;

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($mod_table, $pkeyMod, $pvalMod);
	$assign_list["clsForm"] = $clsForm;
	#
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		if (isset($_POST['vehicle_type_id']) && $_POST['vehicle_type_id'] != '') {
			$link .= '&vehicle_type_id=' . $_POST['vehicle_type_id'];
		}
		if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Tìm kiếm...') {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;

	/*List all item*/
	$cond = "1='1'";
	#Filter By Keyword
	if ($_GET['keyword'] != '') {
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and title like '%" . $keyword . "%'";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	if ($vehicle_type_id > 0) {
		$cond .= " and vehicle_type_id='$vehicle_type_id'";
		$pUrl .= '&vehicle_type_id=' . $vehicle_type_id;
	}
	#
	$cond2 = $cond;
	if ($type_list == 'Active') {
		$cond .= " and is_trash=0";
	}
	if ($type_list == 'Trash') {
		$cond .= " and is_trash=1";
	}
	$orderBy = " order by order_no asc";
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
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

	$link_page_current_3 = '';
	for ($i = 0; $i < count($lst_query_string); $i++) {
		$tmp = explode('=', $lst_query_string[$i]);
		if ($tmp[0] != 'sort_type' && $tmp[0] != 'sort_by')
			$link_page_current_3 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
	}
	$assign_list['link_page_current_3'] = $link_page_current_3;

	#-------End Page Divide-----------------------------------------------------------
	$allItem = $clsClassTable->getAll($cond . $orderBy . $limit);
	$assign_list["allItem"] = $allItem;
	#
	$allTrash =  $clsClassTable->getAll("is_trash=1 and " . $cond2);
	$assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
	#
	$allAll =  $clsClassTable->getAll($cond2);
	$assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
}
function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $pvalTable, $clsClassTable;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];

	$clsISO = new ISO();
	#
	$classTable = "Car";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;
	#

	$string                         = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable                      = intval($core->decryptID($string));
	$assign_list['pvalTable']       = $pvalTable;
	$oneItem                        = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"]         = $oneItem;
	#
	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;

	$clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("simple150", 'seat_belt_note', "", 'seat_belt_note', 255, 5, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("simple150", 'luggage_note', "", 'luggage_note', 255, 5, 1, 1,  "style='width:100%'");
	#
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		if ($pvalTable > 0) {
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
			#- Update Special Field
			$value .= ",slug='" . $core->replaceSpace($_POST["iso-title"]) . "'";
			$value .= ",upd_date='" . time() . "'";
			$price = $_POST['price_one_km'];
			$value .= ",price_one_km='" . $clsISO->processFloatNumber($price) . "'";
			#

			$image     = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image     = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if ($image != '' && $image != '0') {
				$value .= ",image='" . addslashes($image) . "'";
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$value .= ",is_online='" . $is_online . "'";
			//print_r($pvalTable.'<br/>'.$value); die();
			if ($clsClassTable->updateOne($pvalTable, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&car_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=updateFailed');
			}
		} else {
			$listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no = $listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
			}
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
			#--Special Field: slug
			$field .= ",slug";
			$value .= ",'" . $core->replaceSpace($_POST["iso-title"]) . "'";

			#--Special Field: order_no
			$max_id = $clsClassTable->getMaxId();
			$field .= ',car_id,order_no,reg_date,upd_date';
			$value .= ",'" . $max_id . "','1','" . time() . "','" . time() . "'";

			$price = $_POST['price_one_km'];
			$field .= ",price_one_km";
			$value .= ",'" . $clsISO->processFloatNumber($price) . "'";

			#
			$image     = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image     = $_POST['isoman_url_image'];
			}
			if ($image != '' && $image != '0') {
				$field .= ',image';
				$value .= ",'" . addslashes($image) . "'";
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			//print_r($field.'xxxxx'.$value); die();
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&car_id=' . $core->encryptID($max_id) . '&message=InsertSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=InsertSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
			}
		}
	}
}
/*====================================================================================================*/
function default_new()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$clsISO = new ISO();
	#
	$classTable = "Car";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list['pvalTable'] = $pvalTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	#
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;
	$clsProvider = new Provider();
	$assign_list["clsProvider"] = $clsProvider;

	$listSupplier = $clsProvider->getAll("is_trash=0");
	$assign_list["listSupplier"] = $listSupplier;
	unset($listSupplier);
	$list_CarFacilities = $clsProperty->getAll("is_trash=0 and type='CarFacilities'");;
	$assign_list["list_CarFacilities"] = $list_CarFacilities;
	#
	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#
	$title = 'title_' . $_LANG_ID;
	$assign_list["title"] = $title;
	$slug = 'slug_' . $_LANG_ID;
	$assign_list["slug"] = $slug;
	$intro = 'intro_' . $_LANG_ID;
	$assign_list["intro"] = $intro;
	$content = 'content_' . $_LANG_ID;
	$assign_list["content"] = $content;

	$clsForm->addInputTextArea("", $intro, "", $core->get_Lang($intro), 255, 25, 5, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", $content, "", $core->get_Lang($content), 255, 25, 15, 1,  "style='width:100%'");
	#
	if (isset($_POST['submit']) && $_POST['submit'] == 'Insert') {
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
		#--Special Field: slug
		$field .= ",$slug";
		$value .= ",'" . $core->replaceSpace($_POST["iso-$title"]) . "'";
		$field .= ",list_supplier_id";
		$value .= ",'" . $clsISO->makeSlashListFromArray($_POST['supplier_id']) . "'";
		#
		$CarFacilities = $_POST['CarFacilities'];
		if (is_array($CarFacilities) && count($CarFacilities) > 0) {
			$list_CarFacilities = $clsISO->makeSlashListFromArray($CarFacilities);
			$field .= ",list_CarFacilities";
			$value .= ",'" . addslashes($list_CarFacilities) . "'";
		}
		#
		#--Special Field: order_no
		$max_id = $clsClassTable->getMaxId();
		$field .= ',car_id,order_no,reg_date,upd_date';
		$value .= ",'" . $max_id . "','" . $clsClassTable->getMaxOrderNo() . "','" . time() . "','" . time() . "'";
		#
		$up = isset($_POST['image_src']) ? $_POST['image_src'] : '';
		if ($up != '' && $up != '0') {
			$field .= ",image";
			$value .= ",'" . addslashes($up) . "'";
		}
		if ($clsClassTable->insertOne($field, $value)) {
			if ($_POST['edit'] == 'edit') {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&car_id=' . $max_id . '&message=UpdateSuccess');
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
			}
		} else {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
		}
	}
}
function default_ajUpdPosSortCar()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsCar = new Car();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	$list_order = [];
	foreach ($order as $key => $val) {
		$tour = $clsCar->getOne($val, 'order_no');
		$list_order[] = $tour['order_no'];
	}

	rsort($list_order);

	foreach ($order as $key => $val) {
		$clsCar->updateOne($val, 'order_no=' . $list_order[$key]);
	}
}
function default_trash()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Car";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

	if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=TrashSuccess');
	}
}
function default_restore()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Car";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string     = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable  = intval($core->decryptID($string));

	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

	if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=RestoreSuccess');
	}
}

function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Car";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string     = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable  = intval($core->decryptID($string));

	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
	if ($_POST['agree'] == 'agree') {
		if ($clsClassTable->deleteOne($pvalTable)) {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=DeleteSuccess');
		}
	}
}
function default_move()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "Car";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	$direct = isset($_GET['direct']) ? $_GET['direct'] : '';

	$where = '1=1 and is_trash=0 ';

	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];

	if ($pvalTable == "" || $direct == '') {
		header('location: ' . PCMS_URL . '/?mod=' . $mod);
	}
	if ($direct == 'moveup') {
		$lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	if ($direct == 'movedown') {
		$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	if ($direct == 'movetop') {
		$lst = $clsClassTable->getAll($where . " order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
		$clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	if ($direct == 'movebottom') {
		$lst = $clsClassTable->getAll($where . " order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
		$clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=PositionSuccess');
}
