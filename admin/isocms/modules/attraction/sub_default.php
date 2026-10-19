<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#-- Get Type List
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;

	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;
	$clsCity = new City();
	$assign_list["clsCity"] = $clsCity;
	#
	$country_id = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;
	$assign_list["country_id"] = $country_id;
	$city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : 0;
	$assign_list["city_id"] = $city_id;
	#
	$classTable = "Attraction";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '';
		if (isset($country_id) && intval($country_id) > 0) {
			$link .= '&country_id=' . $country_id;
		}
		if (isset($_POST['city_id']) && intval($_POST['city_id']) > 0) {
			$link .= '&city_id=' . $_POST['city_id'];
		}
		if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}

	/*List all item*/
	$cond = "1=1";
	if (intval($country_id) > 0) {
		$cond .= " and country_id='$country_id'";
		$pUrl .= '&country_id=' . $country_id;
		$pUrl .= '';
	}
	if (intval($city_id) > 0) {
		$cond .= " and (city_id='$city_id')";
		$pUrl .= '&city_id=' . $city_id;
	}
	#Filter By Keyword
	if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and slug like '%" . $keyword . "%'";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$assign_list["pUrl"] = $pUrl;
	$cond2 = $cond;
	if ($type_list == 'Active') {
		$cond .= " and is_trash=0";
	}
	if ($type_list == 'Trash') {
		$cond .= " and is_trash=1";
	}
	$orderBy = " order_no ASC";
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
	#-------End Page Divide-----------------------------------------------------------
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);

	//print_r($cond); die();
	$assign_list["allItem"] = $allItem;

	$lstCityAttraction = $clsCity->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by title asc", $clsCity->pkey);
	$tmp = array();
	if (!empty($lstCityGuide)) {
		foreach ($lstCityGuide as $item) {
			if ($clsClassTable->countGuideGlobal(0, $item[$clsCity->pkey], $country_id) > 0) {
				$tmp[] = $item[$clsCity->pkey];
			}
		}
	}
	$assign_list["lstCityGuide"] = $tmp;
}
function default_ajUpdPosSortAttraction()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$classTable = "Attraction";
	$clsClassTable = new $classTable;

	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	$list_order = [];
	foreach ($order as $key => $val) {
		$tour = $clsClassTable->getOne($val, 'order_no');
		$list_order[] = $tour['order_no'];
	}

	rsort($list_order);

	foreach ($order as $key => $val) {
		$clsClassTable->updateOne($val, 'order_no=' . $list_order[$key]);
	}
}
function default_edit()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsISO;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $pvalTable, $clsClassTable;

	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsAreaCity = new AreaCity();
	$assign_list["clsAreaCity"] = $clsAreaCity;
	$classTable = "Attraction";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$clsContinent = new Continent();
	$assign_list['clsContinent'] = $clsContinent;
	$clsCountry = new Country();
	$assign_list['clsCountry'] = $clsCountry;
	$clsAreaCity = new AreaCity();
	$assign_list['clsAreaCity'] = $clsAreaCity;
	$clsRegion = new Region();
	$assign_list['clsRegion'] = $clsRegion;
	$clsCity = new City();
	$assign_list['clsCity'] = $clsCity;
	#
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$assign_list['pkeyTable'] = $pkeyTable;

	$oneTable = $clsClassTable->getOne($pvalTable);
	$assign_list["oneTable"] = $oneTable;

	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : 0;

	$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : 0;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	#
	if ($clsConfiguration->getValue('SiteActive_city')) {
		$lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by order_no desc");
		$assign_list["lstCity"] = $lstCity;
		unset($lstCity);
	}
	#
	if (isset($pvalTable) && $pvalTable > 0) {
		$country_id = $oneTable['country_id'];
		$city_id = $oneTable['city_id'];
	}
	$assign_list["country_id"] = $country_id;
	$assign_list["city_id"] = $city_id;
	#-------------Update Config Meta
	$clsMeta = new Meta();
	$assign_list["clsMeta"] = $clsMeta;
	$linkMeta = $clsClassTable->getLink($pvalTable);
	$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'];
	$assign_list["meta_id"] = $meta_id;
	$assign_list["oneMeta"] = $clsMeta->getOne($meta_id);

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 20, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 20, 1,  "style='width:100%'");

	if ($string != '' && $pvalTable == 0) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
	}
	#=========================================#
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
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
			#
			$set .= ",slug='" . $core->replaceSpace($_POST["iso-title"]) . "'";
			$set .= ",upd_date='" . time() . "',user_id_update='" . addslashes($core->_SESS->user_id) . "'";
			/*			$set .= ",country_id='".$country_id."'";*/
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if ($image != '' && $image != '0') {
				$set .= ",image='" . addslashes($image) . "'";
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$set .= ",is_online='" . $is_online . "'";

			#			
			if (trim($pUrl) == '') {
				if (isset($_POST['iso-country_id']) && intval($_POST['iso-country_id']) > 0) {
					$pUrl .= '&country_id=' . $_POST['iso-country_id'];
				}
				if (isset($_POST['iso-city_id']) && intval($_POST['iso-city_id']) > 0) {
					$pUrl .= '&city_id=' . $_POST['iso-city_id'];
				}
			}
			//print_r($pvalTable.'<br/>'.$set); die();	
			if ($clsClassTable->updateOne($pvalTable, $set)) {
				if ($_POST['config_value_title'] != '' && $_POST['config_value_intro'] != '') {
					if ($meta_id == '') {
						$clsMeta->insertOne("config_link,reg_date,meta_id", "'" . $linkMeta . "','" . time() . "','" . $clsMeta->getMaxId() . "'");
						$allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
						$meta_id = $allMeta[0]['meta_id'];
					}
					//print_r(); die();
					$clsMeta->updateOne($meta_id, "config_value_intro='" . addslashes($_POST['config_value_intro']) . "',config_value_keyword='" . addslashes($_POST['config_value_keyword']) . "',config_value_title='" . addslashes($_POST['config_value_title']) . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
					//print_r($clsMeta);die();
				}
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . $pUrl . '&message=UpdateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=UpdateSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateFailed');
				print_r($pUrl);
				die();
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
			#
			$max_id = $clsClassTable->getMaxID();
			$field .= ",user_id,user_id_update,reg_date,upd_date,slug,$clsClassTable->pkey,order_no";
			$value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
			$value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "','" . $max_id . "','1'";
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if ($image != '' && $image != '0') {
				$field .= ',image';
				$value .= ",'" . addslashes($image) . "'";
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			#
			$pUrl = '';
			if (isset($_POST['iso-city_id']) && intval($_POST['iso-city_id']) > 0) {
				$pUrl .= "&city_id=" . $_POST['iso-city_id'];
			}
			$listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no = $listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
			}
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $core->encryptID($max_id) . $pUrl . '&message=insertSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertFailed');
			}
		}
	}
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
	echo $Html;
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
	#Khi thêm mới->bước tiếp theo country_id mặc định
	if ($country_id == 0) $country_id = 1;
	#
	$cond = "is_trash=0";
	if (intval($country_id)) {
		$cond .= " and country_id='$country_id'";
	}
	if (intval($region_id) > 0) {
		$cond .= " and region_id='$region_id'";
	}
	$cond .= " order by order_no ASC";
	#
	$Html = '<option value="0"> --' . $core->get_Lang('select') . '-- </option>';
	$listCity = $clsCity->getAll($cond, $clsCity->pkey);
	if (is_array($listCity) && count($listCity) > 0) {
		for ($i = 0; $i < count($listCity); $i++) {
			$Html .= '<option title="' . $clsCity->getTitle($listCity[$i][$clsCity->pkey]) . '" value="' . $listCity[$i][$clsCity->pkey] . '" ' . ($city_id == $listCity[$i][$clsCity->pkey] ? 'selected="selected"' : '') . '>|--- ' . $clsCity->getTitle($listCity[$i][$clsCity->pkey]) . '</option>';
		}
	}
	unset($listCity);
	//echo 1; die();
	echo $Html;
	die();
}

function default_loadAreaCity()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsCity = new City();
	$clsAreaCity = new AreaCity();
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	$region_id = isset($_POST['region_id']) ? $_POST['region_id'] : 0;
	$city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;
	$area_city_id = isset($_POST['area_city_id']) ? $_POST['area_city_id'] : 0;
	#Khi thêm mới->bước tiếp theo country_id mặc định
	if ($country_id == 0) $country_id = 1;
	#
	$cond = "is_trash=0";
	if (intval($country_id)) {
		$cond .= " and country_id='$country_id'";
	}
	if (intval($region_id) > 0) {
		$cond .= " and region_id='$region_id'";
	}
	if (intval($city_id) > 0) {
		$cond .= " and city_id='$city_id'";
	}
	$cond .= " order by order_no ASC";
	#
	$Html = '<option value="0"> --' . $core->get_Lang('select') . '-- </option>';
	$listAreaCity = $clsAreaCity->getAll($cond, $clsAreaCity->pkey);
	if (is_array($listAreaCity) && count($listAreaCity) > 0) {
		for ($i = 0; $i < count($listAreaCity); $i++) {
			$Html .= '<option title="' . $clsAreaCity->getTitle($listAreaCity[$i][$clsAreaCity->pkey]) . '" value="' . $listAreaCity[$i][$clsAreaCity->pkey] . '" ' . ($area_city_id == $listAreaCity[$i][$clsAreaCity->pkey] ? 'selected="selected"' : '') . '>|--- ' . $clsAreaCity->getTitle($listAreaCity[$i][$clsAreaCity->pkey]) . '</option>';
		}
	}
	unset($listAreaCity);
	//echo 1; die();
	echo $Html;
	die();
}

function default_trash()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Attraction";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$one = $clsClassTable->getOne($pvalTable);
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
	$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
	if ($string = '' && $pvalTable == 0) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&country_id=' . $country_id . '&message=notPermission');
	}
	#
	$param_url = '';
	if (isset($city_id) && intval($city_id) != 0) {
		$param_url .= '&city_id=' . $city_id;
	}
	#
	if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=TrashSuccess');
	}
}

function default_restore()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Attraction";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$one = $clsClassTable->getOne($pvalTable);
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
	$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
	#
	if ($string = '' && $pvalTable == 0) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&country_id=' . $country_id . '&message=notPermission');
	}
	$param_url = '';
	if (isset($city_id) && intval($city_id) != 0) {
		$param_url .= '&city_id=' . $city_id;
	}
	#
	if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=RestoreSuccess');
	}
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Attraction";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
	$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';

	$param_url = '';
	if (isset($city_id) && intval($city_id) != 0) {
		$param_url .= '&city_id=' . $city_id;
	}
	if ($pvalTable == "") {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=notPermission');
	}
	#
	if (isset($_POST['agree']) && $_POST['agree'] == 'agree') {
		if ($clsClassTable->deleteOne($pvalTable)) {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=DeleteSuccess');
		}
	}
}
function default_move()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "Attraction";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$direct = isset($_GET['direct']) ? $_GET['direct'] : '';
	$type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : 'country';
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];

	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : 0;
	$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : 0;
	#
	$where = "1=1 and is_trash=0";
	/*
    if(isset($country_id) && intval($country_id) != 0){
		$where.=" and country_id=".$country_id;
		$param_url.='&country_id='.$country_id;
	}
    */
	if (isset($city_id) && intval($city_id) != 0) {
		$where .= " and (city_id='$city_id' or list_city_id like '%|" . $city_id . "|%')";
		$param_url .= '&city_id=' . $city_id;
	}
	#
	if ($pvalTable == '' && $direct == '') {
		header('location: ' . PCMS_URL . '/?mod=' . $mod);
	}
	#
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
	header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=PositionSuccess');
}
function default_setting()
{
	global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsConfiguration, $oneSetting;
	$user_id = $core->_USER['user_id'];
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
		$site_attraction_banner = $_POST['isoman_url_site_attraction_banner'];
		if ($site_attraction_banner != '' && $site_attraction_banner != '0') {
			$clsConfiguration->updateValue('site_attraction_banner', $site_attraction_banner);
		}
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
