<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	/**/
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '';
		if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	#
	$classTable = "Download";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	/*List all item*/
	$cond = "1='1'";
	#Filter By Keyword
	if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
		$cond .= " and (slug like '%" . $core->replaceSpace($_GET['keyword']) . "%' or title like '%" . $_GET['keyword'] . "%')";
		$assign_list["keyword"] = $_GET['keyword'];
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
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
	$assign_list["allItem"] = $allItem;

	#
	$allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2);
	$assign_list["number_trash"] = count($allTrash) ?? 0;
	#
	$allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2);
	$assign_list["number_item"] = count($allUnTrash) ?? 0;
	#
	$allAll = $clsClassTable->getAll($cond);
	$assign_list["number_all"] = count($allAll) ?? 0;

	unset($allItem);
}
function default_ajUpdPosSortListDownload()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#

	$classTable = "Download";
	$clsClassTable = new $classTable;

	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach ($order as $key => $val) {
		$key = (($currentPage - 1) * $recordPerPage + $key + 1);
		$clsClassTable->updateOne($val, "order_no='" . $key . "'");
	}
}


function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $pvalTable, $clsClassTable;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsTour = new Tour();
	$classTable = "Download";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;
	#

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	#
	if ($string != '' && $pvalTable == 0) {
		header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
	}

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#	

	$clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 15, 1,  "style='width:100%'");

	#=========================================#
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		$tour_id = !empty($_POST['iso-tour_id']) ? $_POST['iso-tour_id'] : 0;

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
			$title = $_POST['title'];
			$set .= ",title='" . $title . "'";
			$set .= ",slug='" . $core->replaceSpace($_POST['title']) . "'";
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$set .= ",is_online='" . $is_online . "'";
			#
			$pUrl = '';
			if ($clsClassTable->updateOne($pvalTable, $set)) {
				if ($tour_id) $clsTour->updateOne($tour_id, "is_for_agent=1");
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=updateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateFailed');
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
			#
			$max_id = $clsClassTable->getMaxId();
			$max_order_no = $clsClassTable->getMaxOrderNo();
			#
			$title = $_POST['title'];
			$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
			$field .= ",user_id,user_id_update,reg_date,upd_date,title,slug,$clsClassTable->pkey,order_no";
			$value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
			$value .= ",'" . $title . "','" . $core->replaceSpace($_POST['title']) . "','" . $max_id . "','1'";
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			#
			$pUrl = '';
			#
			if ($clsClassTable->insertOne($field, $value)) {
				if ($tour_id) $clsTour->updateOne($tour_id, "is_for_agent=1");
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $core->encryptID($max_id) . '&message=insertSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
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
	$classTable = "Download";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));

	$pUrl = '';
	if ($pvalTable == 0) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=notPermission');
	}
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
	$classTable = "Download";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));

	$pUrl = '';
	if ($pvalTable == 0) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=notPermission');
	}
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
	$classTable = "Download";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	if ($pvalTable == "") {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
	}
	#
	if ($clsClassTable->deleteOne($pvalTable)) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=DeleteSuccess');
	}
}

function default_move()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Download";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	#
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$direct = isset($_GET['direct']) ? $_GET['direct'] : '';

	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	if (($string != '' && $pvalTable == 0) || $direct == '') {
		header('location: ' . PCMS_URL . '/?mod=' . $mod);
	}

	$where = '1=1 and is_trash=0';
	$pUrl = '';
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

function default_setting()
{
	global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsConfiguration, $oneSetting, $clsISO;

	$clsMeta = new Meta();
	$assign_list['clsMeta'] = $clsMeta;
	$user_id = $core->_USER['user_id'];

	$linkMeta = $clsISO->getLink($mod);

	$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'];
	#
	if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration') {
		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$clsConfiguration->updateValue($tmp[1], $val);
			}
			if ($tmp[0] == 'date') {
				$clsConfiguration->updateValue($tmp[1], strtotime($val));
			}
		}
		if ($_POST['config_value_title'] != '' || $_POST['config_value_intro'] != '') {
			if ($meta_id == '') {
				$clsMeta->insertOne("config_link,reg_date,meta_id", "'" . $linkMeta . "','" . time() . "','" . $clsMeta->getMaxID() . "'");
				$allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
				$meta_id = $allMeta[0]['meta_id'];
			}
			$clsMeta->updateOne($meta_id, "config_value_intro='" . addslashes($_POST['config_value_intro']) . "',config_value_keyword='" . addslashes($_POST['config_value_keyword']) . "',config_value_title='" . addslashes($_POST['config_value_title']) . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
		}
		header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess' . $extUrl);
	}
}

/*========== SITE DOWNLOAD CATEGORY =============*/
function default_category()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO;
	$user_id = $core->_USER['user_id'];
	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
	#
	$type_list = isset($_GET['']) ? $_GET[''] : '';
	$assign_list["type_list"] = $type_list;
	#
	$classTable = "DownloadCat";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	$clsDownload = new Download();
	$assign_list["clsDownload"] = $clsDownload;

	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		if ($_POST['keyword'] != '' && $_POST['keyword'] != '') {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $link);
	}

	# List all category
	$cond = "1=1";
	#Filter By Keyword
	if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
		$cond .= " and slug like '%" . $core->replaceSpace($_GET['keyword']) . "%'";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$orderBy = " order by order_no asc";
	#
	$allItem = $clsClassTable->getAll($cond . $orderBy);
	$assign_list["allItem"] = $allItem;

	//Action
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	if ($action == 'Trash') {
		$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
		$downloadcat_id = intval($core->decryptID($string));
		if ($string == '' && $downloadcat_id == 0) {
			header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		if ($clsClassTable->updateOne($downloadcat_id, "is_trash='1'")) {
			header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=category&message=TrashSuccess');
		}
	}
	if ($action == 'Restore') {
		$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
		$downloadcat_id = intval($core->decryptID($string));
		if ($string == '' && $downloadcat_id == 0) {
			header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		if ($clsClassTable->updateOne($downloadcat_id, "is_trash='0'")) {
			header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=RestoreSuccess');
		}
	}
	if ($action == 'Delete') {
		$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
		$downloadcat_id = intval($core->decryptID($string));
		if ($string == '' && $downloadcat_id == 0) {
			header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		$listItem = $clsDownload->getAll("downloadcat_id = '$downloadcat_id' limit 0,1");
		if ($listItem[0][$clsDownload->pkey] != '') {
			header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=DeleteFailed');
			exit();
		}
		if ($clsClassTable->doDelete($downloadcat_id)) {
			header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=DeleteSuccess');
		}
	}
	if ($action == 'move') {
		$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
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

		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=PositionSuccess');
	}
}
function default_SiteNewsCategory()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsDownloadCat = new DownloadCat();
	$downloadcat_id = isset($_POST['downloadcat_id']) ? intval($_POST['downloadcat_id']) : 0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	$user_id = $core->_USER['user_id'];
	#
	if ($tp == 'F') {
		$html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . ($downloadcat_id == 0 ? $core->get_Lang('add') : $core->get_Lang('edit')) . ' ' . $core->get_Lang('downloadcategory') . '</h3>
		</div>';
		$html .= '
		<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right"><strong class="color_r">* ' . $core->get_Lang('title') . '</strong></div>
					<div class="fieldarea">
						<input class="text full required" value="' . $clsDownloadCat->getOneField('title', $downloadcat_id) . '" name="title" type="text" autocomplete="off" />
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="button" downloadcat_id="' . $downloadcat_id . '" class="btn btn-primary ClickSubmitCategory">
				<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span> </button>		
		</div>';
		echo ($html);
		die();
	} elseif ($tp == 'S') {
		$titlePost = isset($_POST['title']) ? trim(addslashes($_POST['title'])) : '';
		$slugPost = $core->replaceSpace($titlePost);
		$introPost = isset($_POST['intro']) ? addslashes($_POST['intro']) : '';
		$parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
		if (intval($downloadcat_id) == 0) {
			if ($clsDownloadCat->getAll("parent_id='$parent_id' and slug='$slugPost'") != '') {
				echo '_EXIST';
				die();
			} else {
				$max_id = $clsDownloadCat->getMaxID();
				$max_order_no = $clsDownloadCat->getMaxOrderNo();
				#
				$fx = "user_id,user_id_update,parent_id,title,slug,order_no,$clsDownloadCat->pkey,reg_date,upd_date";
				$vx = "'$user_id','$user_id','$parent_id','$titlePost','$slugPost'";
				$vx .= ",'" . $max_order_no . "','" . $max_id . "','" . time() . "','" . time() . "'";
				#
				if ($clsDownloadCat->insertOne($fx, $vx)) {
					echo '_SUCCESS';
					die();
				} else {
					echo '_ERROR';
					die();
				}
			}
		} else {
			if ($clsDownloadCat->getAll("parent_id='$parent_id' and slug='$slugPost' and downloadcat_id <> '$downloadcat_id'") != '') {
				echo '_EXIST';
				die();
			} else {
				$vx = "title='$titlePost',slug='$slugPost',parent_id='$parent_id',upd_date='" . time() . "'";
				if ($clsDownloadCat->updateOne($downloadcat_id, $vx)) {
					echo '_SUCCESS';
					die();
				} else {
					echo '_ERROR';
					die();
				}
			}
		}
	}
}
function default_ajmakeSelectMarket()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	$clsProperty = new Property();
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	$market_id 	= isset($_POST['market_id']) ? $_POST['market_id'] : 0;
	$html = '';
	if ($country_id > 0) {
		$lstMarket = $clsProperty->getAll("is_trash=0 and country_id='$country_id' and type='Market' and parent_id='0'", $clsProperty->pkey . ',title');
		$html .= '<option value="0">' . $core->get_Lang('Choose market') . '</option>';
		foreach ($lstMarket as $key => $value) {
			$html .= '<option  value="' . $value['property_id'] . '" ' . (($value['property_id'] == $market_id) ? "selected" : "") . '>' . $value['title'] . '</option>';
		}
		echo $html;
	} else {
		echo "EMPTY";
		die;
	}
}
function default_ajmakeSelectTypeMarket()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;

	$clsProperty = new Property();
	$market_type_id = isset($_POST['market_type_id']) ? $_POST['market_type_id'] : 0;
	$market_id 	= isset($_POST['market_id']) ? $_POST['market_id'] : 0;
	$html = '';
	if ($market_id > 0) {
		$lstMarketType = $clsProperty->getAll("is_trash=0 and type='Market' and parent_id='$market_id'", $clsProperty->pkey . ',title');
		$html .= '<option value="">' . $core->get_Lang('Choose market type') . '</option>';
		foreach ($lstMarketType as $key => $value) {
			$html .= '<option  value="' . $value['property_id'] . '" ' . (($value['property_id'] == $market_type_id) ? "selected" : "") . '>' . $value['title'] . '</option>';
		}
		echo $html;
	} else {
		echo "EMPTY";
		die;
	}
}
function default_ajGetTour()
{
	header('Content-Type: application/json');
	global $clsISO;

	$clsTable = new Tour();

	$tour_id = !empty($_POST['tour_id']) ? $_POST['tour_id'] : 0;

	if ($tour_id) {

		$oneTour = $clsTable->getOne($tour_id, "title, slug, trip_code, image, attachment_file, overview");

		echo json_encode($oneTour);
	}
}
