<?php

function default_ajLoadArea()
{
	global $core;
	$country_id = $_POST['country_id'];
	$continent_id = $_POST['continent_id'];
	$clsArea = new Area();
	$lstSubArea = $clsArea->getAll("is_trash=0 and country_id='$country_id' order by slug_en asc");
	$html = '';
	if ($lstSubArea[0]['continent_id'] != '') {
		$html = '<option value="0">' . $core->get_Lang('area') . '</option>';
		for ($i = 0; $i < count($lstSubArea); $i++) {
			$html .= '<option ' . ($continent_id == $lstSubArea[$i]['continent_id'] ? 'selected="selected"' : '') . ' value="' . $lstSubArea[$i]['continent_id'] . '">' . $clsArea->getTitle($lstSubArea[$i]['continent_id']) . '</option>';
		}
	}
	echo ($html);
	die();
}
function default_ajSelectRegion()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn;
	$user_id = $core->_USER['user_id'];
	#
	$clsRegion = new Region();
	$country_id = $_POST['country_id'];
	$region_id = $_POST['region_id'];
	#
	$sql = "SELECT region_id FROM " . DB_PREFIX . "region WHERE is_trash=0 and country_id='$country_id' order by order_no ASC";
	$listItem = $dbconn->GetAll($sql);
	#
	if (is_array($listItem) && count($listItem) > 0) {
		$html = '<option value="0"> -- ' . $core->get_Lang('selectregion') . ' --</option>';
		for ($i = 0; $i < count($listItem); $i++) {
			$html .= '<option ' . ($region_id == $listItem[$i][$clsRegion->pkey] ? 'selected="selected"' : '') . ' value="' . $listItem[$i][$clsRegion->pkey] . '">' . $clsRegion->getTitle($listItem[$i][$clsRegion->pkey]) . '</option>';
		}
		echo ($html);
		die();
	} else {
		echo '_NOT_REGION';
		die();
	}
}
function default_ajSelectArea()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn;
	$user_id = $core->_USER['user_id'];
	#
	$clsGuideArea = new GuideArea();
	$clsGuideArea2 = new GuideArea2();
	$country_id = $_POST['country_id'];
	$area_id = $_POST['area_id'];
	#
	$sql = "SELECT area_id FROM " . DB_PREFIX . "guide_area2 WHERE is_trash=0 and country_id='$country_id' order by order_no ASC";
	$listItem = $dbconn->GetAll($sql);
	#
	if (is_array($listItem) && count($listItem) > 0) {
		$html = '<option> -- ' . $core->get_Lang('selectarea') . ' --</option>';
		for ($i = 0; $i < count($listItem); $i++) {
			$html .= '<option ' . ($area_id == $listItem[$i]['area_id'] ? 'selected="selected"' : '') . ' value="' . $listItem[$i]['area_id'] . '">' . $clsGuideArea->getTitle($listItem[$i]['area_id']) . '</option>';
		}
		echo ($html);
		die();
	} else {
		echo '_NOT_AREA';
		die();
	}
}
function default_makeSelectboxCity()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsCity = new City();
	$country_id = $_POST['country_id'];
	$city_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';
	$html = '<option value="">-- ' . $core->get_Lang('selectcity') . ' --</option>';
	$lstCity = $clsCity->getAll("is_trash=0 and country_id='$country_id' order by order_no asc");
	if (!empty($lstCity)) {
		$i = 0;
		foreach ($lstCity as $item) {
			$selected = ($city_id == $item[$clsCity->pkey]) ? 'selected="selected"' : '';
			$html .= '<option title="' . $clsCity->getTitle($item[$clsCity->pkey]) . '" value="' . $item[$clsCity->pkey] . '" ' . $selected . '>-- ' . $clsCity->getTitle($item[$clsCity->pkey]) . ' --</option>';
			++$i;
		}
	}
	echo $html;
	die();
}
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn, $clsISO, $package_id, $clsISO;
	#

	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
	$pUrl = '';
	#

	$clsCountryEx = new Country();
	$assign_list["clsCountryEx"] = $clsCountryEx;
	$clsCity = new City();
	$assign_list["clsCity"] = $clsCity;
	$clsRegion = new Region();
	$assign_list["clsRegion"] = $clsRegion;
	#

	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : 0;
	$region_id = isset($_GET['region_id']) ? $_GET['region_id'] : 0;

	#
	#=== Continent
	if ($clsISO->getCheckActiveModulePackage($package_id, 'continent', 'default', 'default') && $core->checkAccess('continent')) {
		$clsContinent = new Continent();
		$assign_list["clsContinent"] = $clsContinent;
		$sql = "is_trash=0 and is_online=1 order by order_no ASC";
		$lstContinent = $clsContinent->GetAll($sql);
		$assign_list["lstContinent"] = $lstContinent;

		$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : 0;
		if (intval($continent_id) == 0) {
			$continent_id = $clsCountryEx->getOneField('continent_id', $country_id);
		}
		$assign_list["continent_id"] = $continent_id;
	}
	$assign_list["country_id"] = $country_id;
	$assign_list["region_id"] = $region_id;

	#=== Country
	$sql = "is_trash=0 and is_online=1";
	if (!empty($continent_id)) {
		$sql .= " AND continent_id = '$continent_id'";
	}
	$sql .= " ORDER BY order_no DESC";
	$lstCountryEx = $clsCountryEx->GetAll($sql, $clsCountryEx->pkey);
	$assign_list["lstCountryEx"] = $lstCountryEx;

	//print_r($lstCountryEx);die();

	unset($lstCountryEx);
	#=== Area
	$sql = "is_trash=0 and is_online=1";
	if (!empty($continent_id)) {
		$sql .= " AND continent_id = '$continent_id'";
	}
	if (!empty($country_id)) {
		$sql .= " AND country_id = '$country_id'";
	}
	$sql .= " ORDER BY order_no DESC";
	$lstRegion = $clsRegion->GetAll($sql);

	$assign_list["lstRegion"] = $lstRegion;
	#
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '';
		if (isset($_POST['continent_id']) && !empty($_POST['continent_id'])) {
			$link .= '&continent_id=' . $_POST['continent_id'];
		}
		if (isset($_POST['country_id']) && !empty($_POST['country_id'])) {
			$link .= '&country_id=' . $_POST['country_id'];
		}
		if ($_POST['region_id'] != '' && intval($_POST['region_id']) != 0) {
			$link .= '&region_id=' . $_POST['region_id'];
		}
		if ($_POST['keyword'] != '' && $_POST['keyword'] != 'city name') {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}

	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	/**/
	$classTable = "City";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	$cond = "1=1";
	#

	if (isset($country_id) && intval($country_id) != 0) {
		$cond .= " and country_id='$country_id'";
		$assign_list["country_id"] = $country_id;
		$pUrl .= '&country_id=' . $country_id;
	} else if (isset($continent_id) && intval($continent_id) != 0) {
		$cond .= " and continent_id=" . $continent_id;
		$assign_list["continent_id"] = $continent_id;
		$pUrl .= '&continent_id=' . $continent_id;
	}

	if (isset($region_id) && intval($region_id) != 0) {
		$cond .= " and region_id='$region_id'";
		$pUrl .= '&region_id=' . $region_id;
	}
	$assign_list["pUrl"] = $pUrl;

	#Filter By Keyword
	if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and slug like '%" . $keyword . "%'";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$cond2 = $cond;
	if ($type_list == 'Active') {
		$cond .= " and is_trash=0";
	}
	if ($type_list == 'Trash') {
		$cond .= " and is_trash=1";
	}
	$orderBy = " order_no DESC";
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
	$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
	$start_limit = ($currentPage - 1) * $recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond, $clsClassTable->pkey);
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

	$stt = ($currentPage - 1) * $recordPerPage;
	$assign_list['stt'] = $stt;

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

	if ($country_id > 0) {
		$pagerecordLink = 'mod=' . $mod . '&country_id=' . $country_id;
	} else {
		$pagerecordLink = 'mod=' . $mod;
	}
	$assign_list['pagerecordLink'] = $pagerecordLink;
	#-------End Page Divide-----------------------------------------------------------
	//	$clsClassTable->setDeBug(1);
	$allItem = $clsClassTable->GetAll($cond . " ORDER BY " . $orderBy . $limit);
	$assign_list["allItem"] = $allItem;
	//	var_dump($allItem);die;
	#
	$allTrash =  $clsClassTable->GetAll("is_trash=1 and " . $cond2, $clsClassTable->pkey);
	$assign_list["number_trash"] = count($allTrash) ?? 0;
	#
	$allUnTrash =  $clsClassTable->GetAll("is_trash=0 and " . $cond2, $clsClassTable->pkey);
	$assign_list["number_item"] = count($allUnTrash) ?? 0;
	#
	$allAll =  $clsClassTable->GetAll("1=1 and " . $cond2, $clsClassTable->pkey);
	$assign_list["number_all"] = count($allAll) ?? 0;
}
function default_ajUpdPosSortCity()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#

	$order = $_POST['order'];
	$clsISO->sortByData('City', $order);
}

function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO, $pvalTable, $clsClassTable, $clsISO, $package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
	#

	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;
	$clsRegion = new Region();
	$assign_list["clsRegion"] = $clsRegion;
	#
	if ($clsISO->getCheckActiveModulePackage($package_id, 'continent', 'default', 'default') && $core->checkAccess('continent')) {
		$clsContinent = new Continent();
		$assign_list["clsContinent"] = $clsContinent;
		$sql = "SELECT continent_id FROM " . DB_PREFIX . "continent WHERE is_trash=0 order by order_no desc";
		$lstContinent = $dbconn->GetAll($sql);
		$assign_list["lstContinent"] = $lstContinent;
	}
	#
	$classTable = "City";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	if ($string != '' && $pvalTable == 0) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&country_id=' . $country_id . '&message=notPermission');
	}
	$assign_list['pvalTable'] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;

	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : 0;
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : 0;
	$region_id = isset($_GET['region_id']) ? $_GET['region_id'] : 0;
	$area_id = isset($_GET['area_id']) ? $_GET['area_id'] : 0;
	if ($pvalTable > 0) {
		if ($clsISO->getCheckActiveModulePackage($package_id, 'continent', 'default', 'default') && $core->checkAccess('continent')) {
			$continent_id = $oneItem['continent_id'];
		}
		$country_id = $oneItem['country_id'];
		$region_id = $oneItem['region_id'];
		$area_id = $oneItem['area_id'];
	}
	$assign_list["continent_id"] = $continent_id;
	$assign_list["country_id"] = $country_id;
	$assign_list["region_id"] = $region_id;
	$assign_list["area_id"] = $area_id;
	#
	$pUrl = '';
	if (intval($continent_id) > 0) {
		$pUrl .= '&continent_id=' . $continent_id;
	}
	if (intval($country_id) > 0) {
		$pUrl .= '&country_id=' . $country_id;
	}
	if (intval($region_id) > 0) {
		$pUrl .= '&region_id=' . $region_id;
	}
	if (intval($area_id) > 0) {
		$pUrl .= '&area_id=' . $area_id;
	}
	$assign_list["pUrl"] = $pUrl;

	#-------------Update Config Meta
	$clsMeta = new Meta();
	$assign_list["clsMeta"] = $clsMeta;
	$linkMeta = $clsClassTable->getLink($pvalTable);
	$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'];
	$assign_list["meta_id"] = $meta_id;
	$assign_list["oneMeta"] = $clsMeta->getOne($meta_id);
	#
	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#
	$clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 2, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 2, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_hotel', "", 'intro_hotel', 255, 25, 2, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_travel', "", 'intro_travel', 255, 25, 2, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_attraction', "", 'intro_attraction', 255, 25, 2, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_tour', "", 'intro_tour', 255, 25, 2, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("simple150", 'intro_banner', "", 'intro_banner', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_fastfact', "", 'intro_fastfact', 255, 25, 1, 1,  "style='width:100%'");
	#	
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
			$set .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
			$set .= ",upd_date='" . time() . "'";
			$title = $_POST['title'];
			$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
			$set .= ",title='" . $title . "'";
			$set .= ",slug='" . $core->replaceSpace($_POST['title']) . "'";
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$set .= ",is_online='" . $is_online . "'";

			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$image_tour = isset($_POST['image_tour_src']) ? $_POST['image_tour_src'] : '';
			$image_hotel = isset($_POST['image_hotel_src']) ? $_POST['image_hotel_src'] : '';
			$banner = isset($_POST['banner_src']) ? $_POST['banner_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
				$image_tour = isset($_POST['isoman_url_image_tour']) ? $_POST['isoman_url_image_tour'] : '';
				$image_hotel = isset($_POST['isoman_url_image_hotel']) ? $_POST['isoman_url_image_hotel'] : '';
				$banner = isset($_POST['isoman_url_banner']) ? $_POST['isoman_url_banner'] : '';
			}
			if (!empty($image)) {
				$set .= ",image='" . addslashes($image) . "'";
			}
			if (!empty($image_tour)) {
				$set .= ",image_tour='" . addslashes($image_tour) . "'";
			}
			if (!empty($image_hotel)) {
				$set .= ",image_hotel='" . addslashes($image_hotel) . "'";
			}
			if (!empty($banner)) {
				$set .= ",banner='" . addslashes($banner) . "'";
			}


			$tmp = $clsClassTable->getAll("slug = '%" . $core->replaceSpace($_POST['iso-title']) . "%' and country_id='" . $oneItem['country_id'] . "' and city_id <> '$pvalTable' limit 0,1");
			if ($tmp[0]['city_id'] != '') {
				header('location:' . PCMS_URL . '/?mod=' . $mod . '&act=edit&city_id=' . $pvalTable . '&continent_id=' . $oneItem['continent_id'] . '&country_id=' . $oneItem['country_id'] . '&message=DuplicateCity');
				exit();
			}
			#
			$pUrl = '';
			if (isset($_POST['iso-continent_id']) && intval($_POST['iso-continent_id']) != 0) {
				$pUrl .= "&continent_id=" . $_POST['iso-continent_id'];
			}
			if (isset($_POST['iso-country_id']) && intval($_POST['iso-country_id']) != 0) {
				$pUrl .= "&country_id=" . $_POST['iso-country_id'];
			}
			if (isset($_POST['iso-region_id']) && intval($_POST['iso-region_id']) != 0) {
				$pUrl .= "&region_id=" . $_POST['iso-region_id'];
			}
			#
			//print_r($pvalTable.'<br/>'.$set); die();
			if ($clsClassTable->updateOne($pvalTable, $set)) {
				$titleMeta = $_POST['config_value_title'] ? addslashes($_POST['config_value_title']) : addslashes($_POST['title']);
				$introMeta = strip_tags(html_entity_decode(addslashes($_POST['iso-intro'])));
				$descriptionMeta = $_POST['config_value_intro'] ? addslashes($_POST['config_value_intro']) : substr($introMeta, 0, 160);
				$image_seo     = isset($_POST['image_seo_src']) ? $_POST['image_seo_src'] : '';
				if (_isoman_use) {
					$image_seo     = $_POST['isoman_url_image_seo'];
				}
				$image_seo = $image_seo ? $image_seo : $image;
				if ($meta_id == '') {
					$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,meta_index,meta_follow", "'" . $linkMeta . "','" . $titleMeta . "','" . $descriptionMeta . "','" . $image_seo . "','" . time() . "','" . time() . "','" . $clsMeta->getMaxId() . "','" . $_POST['meta_index'] . "','" . $_POST['meta_follow'] . "'");
					$allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
				} else {
					$clsMeta->updateOne($meta_id, "config_value_intro='" . $descriptionMeta . "',config_value_title='" . $titleMeta . "',image='" . $image_seo . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
				}
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&city_id=' . $core->encryptID($pvalTable) . '&message=updateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateFailed');
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
			$max_id = $clsClassTable->getMaxId();
			$title = $_POST['title'];
			$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
			$field .= ",user_id,user_id_update,reg_date,upd_date,slug,title,city_id,order_no";
			$value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
			$value .= ",'" . $core->replaceSpace($_POST['title']) . "','" . $title . "','" . $max_id . "','" . $clsClassTable->getMaxOrderNo() . "'";
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$image_tour = isset($_POST['image_tour_src']) ? $_POST['image_tour_src'] : '';
			$image_hotel = isset($_POST['image_hotel_src']) ? $_POST['image_hotel_src'] : '';
			$banner = isset($_POST['banner_src']) ? $_POST['banner_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
				$image_tour = isset($_POST['isoman_url_image_tour']) ? $_POST['isoman_url_image_tour'] : '';
				$image_hotel = isset($_POST['isoman_url_image_hotel']) ? $_POST['isoman_url_image_hotel'] : '';
				$banner = isset($_POST['isoman_url_banner']) ? $_POST['isoman_url_banner'] : '';
			}

			if (!empty($image)) {
				$field .= ',image';
				$value .= ",'" . addslashes($image) . "'";
			}
			if (!empty($image_tour)) {
				$field .= ',image_tour';
				$value .= ",'" . addslashes($image_tour) . "'";
			}
			if (!empty($image_hotel)) {
				$field .= ',image_hotel';
				$value .= ",'" . addslashes($image_hotel) . "'";
			}
			if (!empty($banner)) {
				$field .= ',banner';
				$value .= ",'" . addslashes($banner) . "'";
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			#
			$pUrl = '';
			if (isset($_POST['iso-continent_id']) && intval($_POST['iso-continent_id']) != 0) {
				$pUrl .= "&continent_id=" . $_POST['iso-continent_id'];
			}
			if (isset($_POST['iso-country_id']) && intval($_POST['iso-country_id']) != 0) {
				$pUrl .= "&country_id=" . $_POST['iso-country_id'];
			}
			if (isset($_POST['iso-region_id']) && intval($_POST['iso-region_id']) != 0) {
				$pUrl .= "&region_id=" . $_POST['iso-region_id'];
			}
			//print_r($field.'<br />'.$value);die();
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&city_id=' . $core->encryptID($max_id) . '&message=updateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertFailed');
			}
		}
	}
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "City";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : "";
	$area_id = isset($_GET['area_id']) ? $_GET['area_id'] : "";
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : "";
	$region_id = isset($_GET['region_id']) ? $_GET['region_id'] : "";

	$pUrl = '';
	if (intval($continent_id) != 0) {
		$pUrl .= '&continent_id=' . $continent_id;
	}
	if (intval($area_id) > 0) {
		$pUrl .= '&area_id=' . $area_id;
	}
	if (intval($country_id) != 0) {
		$pUrl .= '&country_id=' . $country_id;
	}
	if (intval($region_id) != 0) {
		$pUrl .= '&region_id=' . $region_id;
	}
	#
	if ($pvalTable == "") {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');
	}
	#
	if ($clsClassTable->doDelete($pvalTable)) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=DeleteSuccess');
	}
}
function default_trash()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "City";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : "";
	$area_id = isset($_GET['area_id']) ? $_GET['area_id'] : "";
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : "";
	$region_id = isset($_GET['region_id']) ? $_GET['region_id'] : "";

	$pUrl = '';
	if (intval($continent_id) != 0) {
		$pUrl .= '&continent_id=' . $continent_id;
	}
	if (intval($area_id) > 0) {
		$pUrl .= '&area_id=' . $area_id;
	}
	if (intval($country_id) != 0) {
		$pUrl .= '&country_id=' . $country_id;
	}
	if (intval($region_id) != 0) {
		$pUrl .= '&region_id=' . $region_id;
	}
	#
	if ($pvalTable == "") {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');
	}
	#
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
	$classTable = "City";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : "";
	$area_id = isset($_GET['area_id']) ? $_GET['area_id'] : "";
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : "";
	$region_id = isset($_GET['region_id']) ? $_GET['region_id'] : "";

	$pUrl = '';
	if (intval($continent_id) != 0) {
		$pUrl .= '&continent_id=' . $continent_id;
	}
	if (intval($area_id) > 0) {
		$pUrl .= '&area_id=' . $area_id;
	}
	if (intval($country_id) != 0) {
		$pUrl .= '&country_id=' . $country_id;
	}
	if (intval($region_id) != 0) {
		$pUrl .= '&region_id=' . $region_id;
	}
	#
	if ($pvalTable == "") {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');
	}
	#
	if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=RestoreSuccess');
	}
}
function default_move()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "City";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	#
	$pvalTable = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : "";
	$area_id = isset($_GET['area_id']) ? $_GET['area_id'] : "";
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : "";
	$region_id = isset($_GET['region_id']) ? $_GET['region_id'] : "";
	$direct = isset($_GET['direct']) ? $_GET['direct'] : '';
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];

	if ($pvalTable == "" || $direct == '') {
		header('location: ' . PCMS_URL . '/?mod=' . $mod);
	}

	$where = '1=1 and is_trash=0 ';
	$pUrl = '';
	if (intval($continent_id) > 0) {
		$where .= " and continent_id=" . $continent_id;
		$pUrl .= '&continent_id=' . $continent_id;
	}
	if (intval($area_id) > 0) {
		$where .= " and area_id=" . $area_id;
		$pUrl .= '&area_id=' . $area_id;
	}
	if (intval($country_id) > 0) {
		$where .= " and country_id=" . $country_id;
		$pUrl .= '&country_id=' . $country_id;
	}
	if (intval($region_id) > 0) {
		$where .= " and region_id=" . $region_id;
		$pUrl .= '&region_id=' . $region_id;
	}
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
	header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
}
function default_setting()
{
	global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsConfiguration, $oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	$clsCityStore = new CityStore();
	$assign_list["clsCityStore"] = $clsCityStore;
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
function default_makeSelectboxCountry()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn;
	$user_id = $core->_USER['user_id'];
	#
	$clsCountry = new Country();
	#
	$continent_id = isset($_POST['continent_id']) ? $_POST['continent_id'] : 0;
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	#
	$sql = "SELECT country_id FROM " . DB_PREFIX . "country WHERE is_trash=0 and continent_id='$continent_id' ORDER BY order_no ASC";
	$lstCountry = $dbconn->GetAll($sql);
	#
	if (!empty($lstCountry)) {
		$html = '<option value="">--' . $core->get_Lang('selectcountry') . ' --</option>';
		$i = 0;
		foreach ($lstCountry as $item) {
			$selected = ($city_id == $item[$clsCountry->pkey]) ? 'selected="selected"' : '';
			$html .= '<option title="' . $clsCountry->getTitle($item[$clsCountry->pkey]) . '" value="' . $item[$clsCountry->pkey] . '" ' . $selected . '>-- ' . $clsCountry->getTitle($item[$clsCountry->pkey]) . ' --</option>';
			++$i;
		}
		echo $html;
		die();
	} else {
		echo '_NOT_COUNTRY';
		die();
	}
}
function default_ajLoadAreaList()
{
	global $core, $dbconn;
	#
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	#
	$clsRegion = new Region();
	$sql = "SELECT region_id FROM " . DB_PREFIX . "region WHERE is_trash=0 and country_id = '" . $country_id . "' order by order_no desc";
	$lstSubArea = $dbconn->getAll($sql);
	#
	$html = '';
	if ($lstSubArea[0]['area_id'] != '') {
		$html = '<option value="0">-- ' . $core->get_Lang('selectarea') . ' --</option>';
		for ($i = 0; $i < count($lstSubArea); $i++) {
			$selected_index = ($country_id == $lstSubArea[$i]['country_id']) ? 'selected="selected"' : '';
			$html .= '<option value="' . $lstSubArea[$i]['area_id'] . '" ' . $selected_index . '>' . $clsRegion->getTitle($lstSubArea[$i]['area_id']) . '</option>';
		}
	}
	echo ($html);
	die();
}
/* Địa danh nổi bật theo Tour*/
function default_top()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;
	$lstCountry =  $clsCountry->getAll("is_trash=0 order by order_no asc");
	$assign_list["lstCountry"] = $lstCountry;
	#
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : $lstCountry[0][$clsCountry->pkey];
	$assign_list["country_id"] = $country_id;
}
function default_ajaxLoadCityChoice()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsCity = new City();
	$country_id = $_POST['country_id'];
	$lstItem = $clsCity->getAll("is_trash=0 and is_top=0 and country_id='$country_id' order by order_no asc");
	$html = '';
	if (is_array($lstItem) && count($lstItem) > 0) {
		foreach ($lstItem as $item) {
			$html .= '
			<li>
				<label><input class="chkitem" name="chkid_city[]" value="' . $item[$clsCity->pkey] . '" type="checkbox">&nbsp;' . $clsCity->getTitle($item[$clsCity->pkey]) . '</label>
			</li>';
		}
	}
	unset($lstItem);
	echo $html;
	die();
}
function default_ajaxLoadCityTop()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsCountry = new Country();
	$clsCity = new City();
	#
	$country_id = $_POST['country_id'];
	$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

	$where = "is_trash=0 and is_top=1";
	if (!empty($country_id)) {
		$where .= " and country_id='$country_id'";
	}
	$lstItem = $clsCity->getAll($where . " order by order_top DESC", $clsCity->pkey . ',country_id');
	if (!empty($lstItem)) {
		$i = 0;
		foreach ($lstItem as $k => $item) {
			$html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
			$html .= '<td class="index">' . ($i + 1) . '</td>';
			$html .= '<td><strong style="font-size:16px">' . $clsCity->getTitle($item[$clsCity->pkey]) . '</strong></td>';
			$html .= '<td><strong>' . $clsCountry->getTitle($item['country_id']) . '</strong></td>';

			$html .= '<td style="vertical-align: middle;text-align:center">
					' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('movetop') . '"  direct="movetop" class="moveCityTop" country_id="' . $country_id . '" data="' . $item[$clsCity->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
                </td>
				
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="moveCityTop" direct="movebottom" country_id="' . $country_id . '" data="' . $item[$clsCity->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
                </td>
				
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('moveup') . '" class="moveCityTop" direct="moveup" country_id="' . $country_id . '" data="' . $item[$clsCity->pkey] . '" href="javascript:void();"><i class="icon-arrow-up"></i></a>') . '
                </td>
				
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movedown') . '" class="moveCityTop" direct="movedown" country_id="' . $country_id . '" data="' . $item[$clsCity->pkey] . '" href="javascript:void();"><i class="icon-arrow-down"></i></a>') . '
                </td>';

			$html .= '<td style="text-align:center">
						<a title="' . $core->get_Lang('delete') . '" class="btn clickToCancelTopCity btn-danger" country_id="' . $country_id . '" data="' . $item[$clsCity->pkey] . '" href="javascript:void();"><i class="icon-remove icon-white"></i></a>
					</td>';
			$html .= '</tr>';
			++$i;
		}
	} else {
		$html .= '
		<tr>
			<td colspan="8" style="text-align:center">' . $core->get_Lang('nodata') . '</td>
		</tr>';
	}
	echo $html;
	die();
}
function getMaxOrderTop($country_id)
{
	$clsCity = new City();
	$res = $clsCity->getAll("1=1 and country_id='$country_id' order by order_top DESC LIMIT 0,1");
	return intval($res[0]["order_top"]) + 1;
}
function default_ajaxSaveTopCity()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsCity = new City();
	$country_id = $_POST['country_id'];
	$listId = $_POST['listId'];
	$listId = str_replace('||', '|', $listId);

	if ($listId != '') {
		$tmp = explode('|', $listId);
		if (is_array($tmp) && count($tmp) > 0) {
			foreach ($tmp as $k => $v) {
				$all = $clsCity->getAll("is_trash=0 and country_id='$country_id' order by order_top DESC limit 0,1");
				$max_oder_top = intval($all[0]['order_top']) + 1;
				$clsCity->updateOne($v, "is_top=1,order_top='$max_oder_top'");
			}
			echo '_SUCCESS';
			die();
		} else {
			echo '_ERROR';
			die();
		}
	} else {
		echo '_ERROR';
		die();
	}
}
function default_ajMoveCityTop()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$country_id = $_POST['country_id'];
	#
	$clsClassTable = new City();
	$pkeyTable = $clsClassTable->pkey;
	$pvalTable = $_POST['city_id'];

	$direct = $_POST['direct'];
	$one = $clsClassTable->getOne($pvalTable);
	$order_top = $one['order_top'];

	$where = 'is_trash=0 and is_top=1';
	if (intval($country_id) > 0) {
		$where .= " and country_id = '$country_id'";
	}
	#
	if ($direct == 'moveup') {
		$lst = $clsClassTable->getAll($where . " and order_top > $order_top order by order_top asc limit 0,1");

		$clsClassTable->updateOne($pvalTable, "order_top='" . $lst[0]['order_top'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_top='" . $order_top . "'");
	}
	if ($direct == 'movedown') {
		$lst = $clsClassTable->getAll($where . " and order_top < $order_top order by order_top desc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_top='" . $lst[0]['order_top'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_top='" . $order_top . "'");
	}

	if ($direct == 'movebottom') {
		$lst = $clsClassTable->getAll($where . " and order_top < $order_top order by order_top desc");
		$clsClassTable->updateOne($pvalTable, "order_top='" . $lst[count($lst) - 1]['order_top'] . "'");
		$lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_top < $order_top order by order_top asc");
		for ($i = 0; $i < count($lstItem); $i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_top='" . ($lstItem[$i]['order_top'] + 1) . "'");
		}
	}
	if ($direct == 'movetop') {
		$lst = $clsClassTable->getAll($where . " and order_top > $order_top order by order_top asc");
		$clsClassTable->updateOne($pvalTable, "order_top='" . $lst[count($lst) - 1]['order_top'] . "'");
		$lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_top > $order_top order by order_top asc");
		for ($i = 0; $i < count($lstItem); $i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_top='" . ($lstItem[$i]['order_top'] - 1) . "'");
		}
	}
	echo (1);
	die();
}
function default_ajCancelChooseTopCity()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsCity = new City();
	$city_id = $_POST['city_id'];
	$clsCity->updateOne($city_id, "is_top='0',order_top='0'");
	#
	echo (1);
	die();
}
function default_ajLoadCountry()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsCountry = new Country();
	$chauluc_id = isset($_POST['chauluc_id']) ? intval($_POST['chauluc_id']) : 0;
	$khuvuc_id = isset($_POST['khuvuc_id']) ? intval($_POST['khuvuc_id']) : 0;
	$country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
	#
	$cond = "is_trash=0 and is_online=1";
	if ($chauluc_id > 0) {
		$cond .= " and continent_id='$chauluc_id'";
	}
	if ($khuvuc_id > 0) {
		$cond .= " and khuvuc_id='$khuvuc_id'";
	}
	#
	if ($clsCountry->getAll($cond) != '') {
		$html = "<option value='0'>" . $core->get_Lang('selectcountry') . "</option>";
		$rslist = $clsCountry->getAll($cond . " order by order_no asc", $clsCountry->pkey);
		if (is_array($rslist) && count($rslist) > 0) {
			foreach ($rslist as $k => $v) {
				$html .= '<option value="' . $v[$clsCountry->pkey] . '" ' . ($country_id == $v[$clsCountry->pkey] ? 'selected="selected"' : '') . '>' . $clsCountry->getTitle($v[$clsCountry->pkey]) . '</option>';
			}
			unset($rslist);
		}
	} else {
		$html = 'EMPTY';
	}
	echo $html;
	die();
}
function default_ajLoadRegion()
{
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $core, $clsModule, $clsConfiguration;
	#
	$clsRegion = new Region();
	$country_id = (int) Input::post('country_id', 0);
	$region_id = (int) Input::post('region_id', 0);
	#
	$cond = "is_trash=0 AND is_online=1";
	if ($country_id > 0) {
		$cond .= " and country_id = '{$country_id}'";
	}
	//	$html = 'EMPTY';
	//	if($clsRegion->countItem($cond) > 0) {
	$html = $clsRegion->makeSelectboxOption($country_id, $region_id);
	//	}
	// Return
	echo $html;
	die();
}
require_once(DIR_MODULES . '/city/mod_default.php');
