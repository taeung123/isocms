<?
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];

	$clsPagination = new Pagination();
	$clsPartnerCategory = new PartnerCategory();
	$assign_list["clsPartnerCategory"] = $clsPartnerCategory;

	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;

	$partnercat_id = isset($_GET['partnercat_id']) ? intval($_GET['partnercat_id']) : 0;
	$assign_list["partnercat_id"] = $partnercat_id;
	/**/
	$classTable = "Package";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	/*List all item*/
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '';
		if (isset($_POST['partnercat_id']) && $_POST['partnercat_id'] != '') {
			$link .= '&partnercat_id=' . $_POST['partnercat_id'];
		}
		if ($_POST['keyword'] != '' && $_POST['keyword'] != 'slide name') {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	#
	$cond = "1=1";
	if (isset($_GET['keyword'])) {
		$slug = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (title like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%')";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	#
	$cond2 = $cond;
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
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit); //print_r($cond." order by ".$orderBy.$limit);die();
	$assign_list["allItem"] = $allItem;
	#
	$allTrash =  $clsClassTable->getAll("is_trash=1 and " . $cond2);
	$assign_list["number_trash"] = count($allTrash) ?? 0;
	#
	$allAll =  $clsClassTable->getAll($cond2);
	$assign_list["number_all"] = count($allAll) ?? 0;
}
function default_edit()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $oneCommon;
	global $clsConfiguration, $extLang, $_LANG_ID, $clsISO;

	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Package";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;

	$clsFeaturePackage = new FeaturePackage();
	$assign_list["clsFeaturePackage"] = $clsFeaturePackage;

	$listFeaturePackage = $clsFeaturePackage->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsFeaturePackage->pkey);
	$assign_list["listFeaturePackage"] = $listFeaturePackage;
	#
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;

	$oneTable = $clsClassTable->getOne($pvalTable);
	$assign_list["oneTable"] = $oneTable;

	$list_feature_package_check_id = $oneTable['list_feature_package_id'] ?? '';
	$list_feature_package_check_id = unserialize($list_feature_package_check_id) ?? [];
	$assign_list["list_feature_package_check_id"] = $list_feature_package_check_id;

	$content_json = $oneTable['content_json'] ?? '';
	$assign_list['content_json'] = json_decode($content_json);
	//print_r($content_json); die();
	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 1, 1,  "style='width:100%'");
	#
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		// $clsISO->dd($_POST);
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
			$title = $_POST['title'];
			$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
			#--Special Field: slug
			$value .= "title='" . $title . "'";
			$value .= ",slug='" . $core->replaceSpace($_POST['title']) . "'";
			$value .= ",upd_date='" . time() . "'";
			$value .= ",user_id_update='" . $user_id . "'";
			$value .= ",list_feature_package_id='" . serialize($_POST['list_feature_package_id']) . "'";

			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$value .= ",is_online='" . $is_online . "'";
			if ($clsClassTable->updateOne($pvalTable, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&package_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
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
			#--Special Field: slug
			$title = $_POST['title'];
			$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
			$field .= ',title';
			$value .= ",'" . $title . "'";
			$field .= ',slug';
			$value .= ",'" . $core->replaceSpace($_POST['title']) . "'";
			#--Special Field: order_no
			$max_id = $clsClassTable->getMaxId();
			$field .= ',order_no,package_id,reg_date,list_feature_package_id';
			$value .= ",'1','" . $max_id . "','" . time() . "','" . serialize($_POST['list_feature_package_id']) . "'";


			$listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no = $listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			#
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&package_id=' . $core->encryptID($max_id) . '&message=UpdateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
			}
		}
	}
}

function default_setting()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];

	$clsPackage = new Package();
	$assign_list["clsPackage"] = $clsPackage;
	$clsFAQ = new FAQ();
	$assign_list["clsFAQ"] = $clsFAQ;

	$clsFeaturePackage = new FeaturePackage();
	$assign_list["clsFeaturePackage"] = $clsFeaturePackage;

	$listPackage = $clsPackage->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsPackage->pkey . ",list_feature_package_id,list_feature_package_home_id");
	$assign_list["listPackage"] = $listPackage;
	///print_r($listPackage); die();
	//
	$listFeaturePackage = $clsFeaturePackage->getAll("is_trash=0 and is_online=1 order by order_no ASC");
	$assign_list["listFeaturePackage"] = $listFeaturePackage;
	//print_r($listFeaturePackage); die();
	if (isset($_POST['UpdateSettingFeaturePackage']) && $_POST['UpdateSettingFeaturePackage'] == 'UpdateSettingFeaturePackage') {
		foreach ($listPackage as $item) {
			//print_r('xxx'); die();
			$value = "list_feature_package_id='" . $clsISO->makeSlashListFromArrayComma($_POST['list_feature_package_id_' . $item[$clsPackage->pkey]]) . "'";
			$value .= ",list_feature_package_home_id='" . $clsISO->makeSlashListFromArrayComma($_POST['list_feature_package_home_id_' . $item[$clsPackage->pkey]]) . "'";
			if ($clsPackage->updateOne($item[$clsPackage->pkey], $value)) {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=setting&message=UpdateSuccess');
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=setting&message=updateFailed');
			}
		}
	}

	$listSitePricing = $clsFAQ->getAll("is_trash=0 and is_online=1 and type='PRICING' order by order_no ASC");
	$assign_list["listSitePricing"] = $listSitePricing;

	$action = isset($_GET['action']) ? $_GET['action'] : '';
	if ($action == 'addnew') {
		$fx = "title,type,content,reg_date,order_no";
		$num = $clsFAQ->getAll("is_trash=0 and is_online=1 and type='PRICING'", $clsFAQ->pkey) ? count($clsFAQ->getAll("is_trash=0 and is_online=1 and type='PRICING'", $clsFAQ->pkey)) : 0;

		$vx = "'','PRICING','','" . time() . "','" . $clsFAQ->getMaxOrderNo() . "'";
		//print_r($fx.'xxxx'.$vx); die();
		if ($clsFAQ->insertOne($fx, $vx)) {
			header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=InsertSuccess');
			exit();
		}
	}
	if ($action == 'delete') {
		$faq_id = isset($_GET['faq_id']) ? $_GET['faq_id'] : '';
		if ($faq_id == '') {
			header('location:' . PCMS_URL . 'index.php?mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		#
		$clsFAQ->deleteOne($faq_id);
		header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=DeleteSuccess');
		exit();
	}

	if (isset($_POST['UpdateSettingPricingQuestion']) && $_POST['UpdateSettingPricingQuestion'] == 'UpdateSettingPricingQuestion') {
		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$clsConfiguration->updateValue($tmp[1], $val);
			}
		}
		/* Update Link */
		for ($i = 0; $i < count($listSitePricing); $i++) {
			$faq_id = $listSitePricing[$i][$clsFAQ->pkey];
			$titlePost = addslashes($_POST['title_' . $faq_id]);
			$contentPost = isset($_POST['content_' . $faq_id]) ? addslashes($_POST['content_' . $faq_id]) : '';
			#
			$value = "title='$titlePost',content='$contentPost'";
			$clsFAQ->updateOne($faq_id, $value);
		}
		header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess');
		exit();
	}
}
function default_home()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	if (isset($_POST['submit'])) {
		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$clsConfiguration->updateValue($tmp[1], $val);
			}
		}
		$image_package_page_1 = $_POST['isoman_url_image_package_page_1'];
		if ($image_package_page_1 != '' && $image_package_page_1 != '0') {
			$clsConfiguration->updateValue('image_package_page_1', $image_package_page_1);
		}
		$image_package_page_2 = $_POST['isoman_url_image_package_page_2'];
		if ($image_package_page_2 != '' && $image_package_page_2 != '0') {
			$clsConfiguration->updateValue('image_package_page_2', $image_package_page_2);
		}
		$image_package_page_3 = $_POST['isoman_url_image_package_page_3'];
		if ($image_package_page_3 != '' && $image_package_page_3 != '0') {
			$clsConfiguration->updateValue('image_package_page_3', $image_package_page_3);
		}
		$image_package_page_4 = $_POST['isoman_url_image_package_page_4'];
		if ($image_package_page_4 != '' && $image_package_page_4 != '0') {
			$clsConfiguration->updateValue('image_package_page_4', $image_package_page_4);
		}
		$image_package_page_5 = $_POST['isoman_url_image_package_page_5'];
		if ($image_package_page_5 != '' && $image_package_page_5 != '0') {
			$clsConfiguration->updateValue('image_package_page_5', $image_package_page_5);
		}
		$extUrl = '';
		if ($_POST['submit'] == 'UpdateConfiguration') {
			$extUrl = '#isotab0';
		}
		header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess' . $extUrl);
	}
}
/*====================================================================================================*/
function default_delete()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Package";
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
		header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=DeleteSuccess');
	}
}
function default_move()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "Package";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	$direct = isset($_GET['direct']) ? $_GET['direct'] : '';
	if ($pvalTable == "" || $direct == '') {
		header('location: ' . PCMS_URL . '/?mod=' . $mod);
	}
	#
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	#
	$where = '1=1 and is_trash=0 ';
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
	header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=PositionSuccess');
}
function default_trash()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Package";
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
function default_restore()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "Package";
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
function default_ajUpdPosSortListPackage()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#

	$classTable = "Package";
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
