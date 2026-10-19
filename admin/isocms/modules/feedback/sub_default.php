<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	$type = !empty($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;
	#
	$is_process = $_GET['is_process'] ?? '';
	$assign_list["is_process"] = $is_process;
	#
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;
	/**/
	$classTable = "Feedback";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	/*List all item*/
	if (isset($_POST['Export']) && $_POST['Export'] == 'Export') {
		$link = '?mod=export&type=excel_feedback';
		if ($is_process != '') {
			$link .= '&is_process=' . $is_process . '';
		}
		vnSessionSetVar('from_date', $_POST['from_date']);
		vnSessionSetVar('to_date', $_POST['to_date']);
		header('location: ' . PCMS_URL . '/' . $link);
	}
	#
	$cond = '1=1';
	if (isset($is_process) && !empty($is_process)) {
		$cond .= " and is_process = '$is_process'";
	}
	#
	if ($type_list == 'Pending') {
		$cond .= " and is_process=0";
	} elseif ($type_list == 'Approved') {
		$cond .= " and is_process=1";
	}
	if (!empty($type)) {
		$cond .= " and type = '$type'";
		$where = " and type = '$type'";
	} else {
		$str_type = "'TourInquiry', 'CruiseInquiry'";
		$cond .= " and type NOT IN ($str_type)";
		$where = " and type NOT IN ($str_type)";
	}
	$orderBy = " reg_date desc";
	$recordPerPage = !empty($_GET["recordperpage"]) ? $_GET["recordperpage"] : 30;
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
	$stt = ($currentPage - 1) * $recordPerPage;
	$assign_list['stt'] = $stt;
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
	$allItem =  $clsClassTable->getAll("1=1 $where", $clsClassTable->pkey);
	$assign_list["allItem"] = $allItem ? count($allItem) : 0;
	$allProcess =  $clsClassTable->getAll("is_process=1 $where", $clsClassTable->pkey);
	$assign_list["number_process"] = $allProcess ? count($allProcess) : 0;
	$allUnProcess =  $clsClassTable->getAll("is_process=0 $where", $clsClassTable->pkey);
	$assign_list["number_unprocess"] = $allUnProcess ? count($allUnProcess) : 0;
	$allReviewed =  $clsClassTable->getAll("is_process=2 $where", $clsClassTable->pkey);
	$assign_list["number_reviewed"] = $allReviewed ? count($allReviewed) : 0;
	#----
	if (isset($_POST['submit'])) {
		if ($_POST['submit'] == 'UpdateSiteFeedback') {
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
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsCountryex = new Country();
	$assign_list["clsCountryex"] = $clsCountryex;
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;
	$classTable = "Feedback";
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
	$feedback_store = unserialize($oneTable['feedback_store']);
	$lstCountry = '';
	if (!empty($feedback_store['country_id']) && is_array($feedback_store['country_id'])) {
		foreach ($feedback_store['country_id'] as $item) {
			$lstCountry .= ',' . $clsCountryex->getTitle($item);
		}
	}
	$assign_list['lstCountry'] = trim($lstCountry, ',');
	foreach ($clsISO->getListTravelDuration() as $key => $item) {
		if ($key == 0) {
			$travelduration = $core->get_Lang('Unknown');
		} elseif (isset($feedback_store['travelduration']) && $key == $feedback_store['travelduration']) {
			$travelduration = $item;
		}
	}
	$assign_list['travelduration'] = $travelduration ?? "";
	//    var_dump($travelduration);die();
	$is_process = $oneTable['is_process'];
	if ($is_process == 0 && intval($pvalTable) > 0) {
		$clsClassTable->updateOne($pvalTable, "is_process = 2");
	}
	#
	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#-------------Update Config Meta 
	$clsForm->addInputTextArea("full", "note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");
	#
	$link = "";
	if ($oneTable["type"] == "TourInquiry") {
		$link = "&type=TourInquiry";
	}
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		$is_process = $_POST['is_process'] ? intval($_POST['is_process']) : 0;
		$value = "is_process='" . $is_process . "'";
		$value .= ",note='" . $_POST['iso-note'] . "'";
		if ($clsClassTable->updateOne($pvalTable, $value)) {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . $link . '&message=UpdateSuccess');
		}
	}
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Feedback";
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
