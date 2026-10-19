<?php
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
	$classTable = "Team";
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
		$cond .= " and (name like '%" . $_GET['keyword'] . "%' or name_slug like '%" . $slug . "%')";
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
	$classTable = "Team";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;

	$clsPartnerCategory = new PartnerCategory();
	$assign_list["clsPartnerCategory"] = $clsPartnerCategory;
	$partnercat_id = isset($_GET['partnercat_id']) ? intval($_GET['partnercat_id']) : 0;
	#
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;

	$oneTable = $clsClassTable->getOne($pvalTable);
	$assign_list["oneTable"] = $oneTable;

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 25, 1,  "style='width:100%'");
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
			$name = $_POST['name'];
			$name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
			#--Special Field: slug
			$value .= ",name='" . $name . "'";
			$value .= ",name_slug='" . $core->replaceSpace($_POST['name']) . "'";
			$value .= ",upd_date='" . time() . "'";
			$value .= ",user_id_update='" . $user_id . "'";
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if ($image != '' && $image != '0') {
				$value .= ",image='" . addslashes($image) . "'";
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$value .= ",is_online='" . $is_online . "'";

			//print_r($pvalTable.'xxx'.$value);die();

			if ($clsClassTable->updateOne($pvalTable, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&team_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess');
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
			$name = $_POST['name'];
			$name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
			$field .= ',name';
			$value .= ",'" . $name . "'";
			$field .= ',name_slug';
			$value .= ",'" . $core->replaceSpace($_POST['name']) . "'";
			#--Special Field: order_no
			$max_id = $clsClassTable->getMaxId();
			$field .= ',order_no,team_id,reg_date';
			$value .= ",'1','" . $max_id . "','" . time() . "'";
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if ($image != '' && $image != '0') {
				$field .= ",image";
				$value .= ",'" . addslashes($image) . "'";
			}
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
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&team_id=' . $core->encryptID($max_id) . '&message=UpdateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
			}
		}
	}
}
/*====================================================================================================*/
function default_delete()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Team";
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
function default_trash()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Team";
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

	$classTable = "Team";
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
function default_ajUpdPosSortListTeam()
{
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT;
	global $mod, $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsConfiguration;

	$classTable = "Team";
	$clsClassTable = new $classTable;

	/*
	 * =========================================================
	 * GET POST DATA
	 * =========================================================
	 */

	$order = isset($_POST['order']) && is_array($_POST['order'])
		? $_POST['order']
		: array();

	$currentPage = isset($_POST['currentPage'])
		? intval($_POST['currentPage'])
		: 1;

	$recordPerPage = isset($_POST['recordPerPage'])
		? intval($_POST['recordPerPage'])
		: 20;

	if (empty($order)) {
		echo '0';
		exit();
	}

	/*
	 * =========================================================
	 * CLEAN ID LIST
	 * =========================================================
	 */

	$order = array_values(array_unique(array_map('intval', $order)));

	if (empty($order)) {
		echo '0';
		exit();
	}

	/*
	 * =========================================================
	 * GET CURRENT order_no
	 *
	 * $order[] là thứ tự item trên giao diện:
	 *
	 * [item trên cùng, item thứ 2, item thứ 3, ...]
	 *
	 * Vì frontend đang hiển thị:
	 *
	 * order_no ASC
	 *
	 * nên phải lấy order_no hiện tại và sắp xếp ASC.
	 * KHÔNG được dùng rsort().
	 * =========================================================
	 */

	$list_order = array();

	foreach ($order as $id) {

		if ($id <= 0) {
			continue;
		}

		$item = $clsClassTable->getOne($id, 'order_no');

		if (is_array($item) && isset($item['order_no'])) {

			$list_order[] = intval($item['order_no']);

		}
	}

	if (empty($list_order)) {
		echo '0';
		exit();
	}

	/*
	 * =========================================================
	 * SORT ASC
	 *
	 * QUAN TRỌNG:
	 *
	 * Frontend:
	 * order_no ASC
	 *
	 * Vì vậy phải dùng sort() chứ không phải rsort().
	 * =========================================================
	 */

	sort($list_order, SORT_NUMERIC);

	/*
	 * =========================================================
	 * UPDATE POSITION
	 * =========================================================
	 */

	$position = 0;

	foreach ($order as $id) {

		if ($id <= 0) {
			continue;
		}

		if (!isset($list_order[$position])) {
			break;
		}

		$new_order_no = intval($list_order[$position]);

		$clsClassTable->updateOne(
			$id,
			'order_no=' . $new_order_no
		);

		$position++;
	}

	echo '1';
	exit();
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
