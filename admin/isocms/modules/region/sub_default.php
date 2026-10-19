<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#
	$clsContinent = new Continent();
	$assign_list["clsContinent"] = $clsContinent;
	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;
	$clsCity = new City();
	$assign_list["clsCity"] = $clsCity;
	#
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : '';
	$assign_list["continent_id"] = $continent_id;
	$area_id = isset($_GET['area_id']) ? $_GET['area_id'] : '';
	$assign_list["area_id"] = $area_id;
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
	$assign_list["country_id"] = $country_id;

	#
	/*if($clsConfiguration->getValue('SiteModActive_country')) {
		if(intval($continent_id)==0 && intval($country_id)==0){
			header('location: '.PCMS_URL.'/?mod=country&message=notPermission');
			die();
		}
	}*/
	/*Get type of list news*/
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '';
		if (isset($_POST['continent_id']) && intval($_POST['continent_id']) != 0) {
			$link .= '&continent_id=' . $_POST['continent_id'];
		}
		if (isset($_POST['country_id']) && intval($_POST['country_id']) != 0) {
			$link .= '&country_id=' . $_POST['country_id'];
		}
		if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . $link);
	}
	/**/
	$classTable = "Region";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	/*List all item*/
	$cond = "1=1";
	if (isset($continent_id) && intval($continent_id) != 0) {
		$cond .= " and continent_id=" . $continent_id;
		$pUrl .= '&continent_id=' . $continent_id;
	}
	if (isset($area_id) && intval($area_id) != 0) {
		$cond .= " and area_id=" . $area_id;
		$pUrl .= '&area_id=' . $area_id;
	}
	if (isset($country_id) && intval($country_id) != 0) {
		$cond .= " and country_id='$country_id'";
		$pUrl .= '&country_id=' . $country_id;
	}
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
	$assign_list['pUrl'] = $pUrl;
	#-------End Page Divide-----------------------------------------------------------
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit); //print_r($cond." order by ".$orderBy.$limit);die();
	//print_r($allItem); die();
	$assign_list["allItem"] = $allItem;
	#
	$allTrash =  $clsClassTable->getAll("is_trash=1 and " . $cond2, $clsClassTable->pkey);
	$assign_list["number_trash"] = count($allTrash) ?? 0;
	#
	$allAll =  $clsClassTable->getAll($cond2, $clsClassTable->pkey);
	$assign_list["number_all"] = count($allAll) ?? 0;
}
function default_ajUpdPosSortRegion()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#
	$clsRegion = new Region();
	$order = $_POST['order'];
	$clsISO->sortByData('Region', $order);
}
function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO, $pvalTable, $clsClassTable;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Region";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;

	$clsContinent = new Continent();
	$assign_list["clsContinent"] = $clsContinent;
	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;
	$clsCity = new City();
	$assign_list["clsCity"] = $clsCity;
	$clsCityStore = new CityStore();
	$assign_list["clsCityStore"] = $clsCityStore;
	#
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	/*if($string!='' && $pvalTable==0){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&continent_id='.$continent_id.'&country_id='.$country_id.'&message=notPermission');
	}*/
	$assign_list['pvalTable'] = $pvalTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	#
	$continent_id = isset($_GET['continent_id']) ? intval($_GET['continent_id']) : 0;
	$country_id = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;
	/*	if($country_id==0){
		header('location: '.PCMS_URL.'/?mod=country&message=notPermission');
		die();
	}*/
	#
	if ($pvalTable > 0) {
		$continent_id = $oneItem['continent_id'];
		$country_id = $oneItem['country_id'];
	}
	$assign_list["continent_id"] = $continent_id;
	$assign_list["country_id"] = $country_id;
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
	$clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("simple150", 'intro_banner', "", 'intro_banner', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_fastfact', "", 'intro_fastfact', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_hotel', "", 'intro_hotel', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_tour', "", 'intro_tour', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_guide', "", 'intro_guide', 255, 25, 1, 1,  "style='width:100%'");
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
			#
			$title = $_POST['title'];
			$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
			$set .= ",user_id_update='$user_id'";
			$set .= ",upd_date='" . time() . "'";
			$set .= ",title='" . $title . "'";
			$set .= ",slug='" . $core->replaceSpace($_POST['title']) . "'";
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$banner = isset($_POST['banner_src']) ? $_POST['banner_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
				$banner = isset($_POST['isoman_url_banner']) ? $_POST['isoman_url_banner'] : '';
			}
			if ($image != '' && $image != '0' || $banner != '' && $banner != '0') {
				$set .= ",image='" . addslashes($image) . "'";
				$set .= ",banner='" . addslashes($banner) . "'";
			}
			#
			$pUrl = '';
			if ($_POST['iso-continent_id'] != '') {
				$pUrl .= '&continent_id=' . $_POST['iso-continent_id'];
			}
			if ($_POST['iso-country_id'] != '') {
				$pUrl .= '&country_id=' . $_POST['iso-country_id'];
			}
			#
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$set .= ",is_online='" . $is_online . "'";
			//print_r($pvalTable.'xxxxx'.$set); die();
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
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&region_id=' . $_GET[$clsClassTable->pkey] . $pUrl . '&message=updateSuccess');
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
			$title = $_POST['title'];
			$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
			$field .= ",user_id,user_id_update,reg_date,upd_date,slug,title,region_id,order_no";
			$value .= ",'$user_id','$user_id','" . time() . "','" . time() . "','" . $core->replaceSpace($_POST['title']) . "','" . $title . "','$max_id','1'";
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$banner = isset($_POST['banner_src']) ? $_POST['banner_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
				$banner = isset($_POST['isoman_url_banner']) ? $_POST['isoman_url_banner'] : '';
			}
			if ($image != '' && $image != '0' || $banner != '' && $banner != '0') {
				$field .= ',image';
				$value .= ",'" . addslashes($image) . "'";
				$field .= ',banner';
				$value .= ",'" . addslashes($banner) . "'";
			}
			#
			$pUrl = '';
			if ($_POST['iso-continent_id'] != '') {
				$pUrl .= '&continent_id=' . $_POST['iso-continent_id'];
			}
			if ($_POST['iso-country_id'] != '') {
				$pUrl .= '&country_id=' . $_POST['iso-country_id'];
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			#
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&region_id=' . $core->encryptID($max_id) . $pUrl . '&message=insertSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertFailed');
			}
		}
	}
	//print_r($country_id);die();
	if ($country_id > 0) {
		$listCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and city_id NOT IN (SELECT city_id FROM " . DB_PREFIX . "citystore WHERE is_trash=0 and type='REGION' and country_id='$country_id') order by order_no desc");
	} else {
		$listCity = $clsCity->getAll("is_trash=0 and is_online=1 and city_id NOT IN (SELECT city_id FROM " . DB_PREFIX . "citystore WHERE is_trash=0 and type='REGION' and country_id='$country_id') order by order_no desc");
	}
	$assign_list["listCity"] = $listCity;
	#
	$listSelected =  $clsCityStore->getAll("is_trash=0 and type = 'REGION' and region_id='$pvalTable' and country_id='$country_id' order by order_no asc");
	$assign_list["listSelected"] = $listSelected;
	//print_r($listSelected);die();

	$action = isset($_GET['action']) ? $_GET['action'] : '';
	if ($action == 'Add') {
		$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
		$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
		$region_id = isset($_GET['region_id']) ? $_GET['region_id'] : '';

		if ($city_id == '' && $city_id == 0) {
			header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		if (!$clsCityStore->checkExist($city_id, 'REGION')) {
			$listTable = $clsCityStore->getAll("1=1 and region_id='$region_id' and type='REGION'", $clsCityStore->pkey . ",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no = $listTable[$i]['order_no'] + 1;
				$clsCityStore->updateOne($listTable[$i][$clsCityStore->pkey], "order_no='" . $order_no . "'");
			}
			$max_id = $clsCityStore->getMaxID();
			$max_order_no = $clsCityStore->getMaxOrderNo();
			$f = "$clsCityStore->pkey,city_id,region_id,country_id,type,order_no";
			$v = "'$max_id','$city_id','$region_id','$country_id','REGION','1'";
			if ($clsCityStore->insertOne($f, $v)) {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&region_id=' . $core->encryptID($region_id) . '&message=insertSuccess#CityRegion');
			}
		}
	}
}
function default_ajUpdPosSortCityStore()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsClassTable = new CityStore();
	$type = $_POST['type'];
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach ($order as $key => $val) {
		$key = (($currentPage - 1) * $recordPerPage + $key + 1);
		$clsClassTable->updateByCond("city_id='$val' and type='$type'", "order_no='" . $key . "'");
	}
}
function default_ajMoveCityStore()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsClassTable = new CityStore();
	$pvalTable = isset($_POST['citystore_id']) ? $_POST['citystore_id'] : 0;

	$city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;
	$region_id = isset($_POST['region_id']) ? $_POST['region_id'] : 0;
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	$direct = isset($_POST['direct']) ? $_POST['direct'] : '';
	$type = isset($_POST['type']) ? $_POST['type'] : '';

	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];

	$cond = "is_trash=0 and country_id = '$country_id' and region_id = '$region_id' and Type='REGION'";
	#
	if ($direct == 'movedown') {
		$lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	if ($direct == 'moveup') {
		$lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	if ($direct == 'movetop') {
		$lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no asc");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
		$clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	if ($direct == 'movebottom') {
		$lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no desc");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
		$clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	echo (1);
	die();
}
function default_ajSaveStoreForCity()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsCityStore = new CityStore();
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	$region_id = isset($_POST['region_id']) ? $_POST['region_id'] : 0;
	$list_city_id = isset($_POST['list_city_id']) ? $_POST['list_city_id'] : '';
	$list_city_id = rtrim($list_city_id, '|');

	if ($list_city_id != '') {
		$tmp = explode('|', $list_city_id);
		if (!empty($tmp)) {
			foreach ($tmp as $i) {
				if (!$clsCityStore->checkExist($i, REGION)) {
					#
					$max_id = $clsCityStore->getMaxID();
					$max_order = $clsCityStore->getMaxOrderNo();
					$f = "$clsCityStore->pkey,city_id,region_id,country_id,type,order_no";
					$v = "'$max_id','$i','$region_id','$country_id','REGION','$max_order'";

					$clsCityStore->insertOne($f, $v);
				}
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
function default_ajDeleteCityStore()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsClassTable = new CityStore();
	$pvalTable = isset($_POST['citystore_id']) ? $_POST['citystore_id'] : 0;
	$clsClassTable->deleteOne($pvalTable);
	echo (1);
	die();
}




/*====================================================================================================*/
function default_trash()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Region";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : '';
	$area_id = isset($_GET['area_id']) ? $_GET['area_id'] : '';
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
	#
	$pUrl = '';
	if (intval($continent_id) > 0) {
		$pUrl .= '&continent_id=' . $continent_id;
	}
	if (intval($area_id) > 0) {
		$pUrl .= '&area_id=' . $area_id;
	}
	if (intval($continent_id) > 0) {
		$pUrl .= '&country_id=' . $country_id;
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
	$classTable = "Region";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : '';
	$area_id = isset($_GET['area_id']) ? $_GET['area_id'] : '';
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
	#
	$pUrl = '';
	if (intval($continent_id) > 0) {
		$pUrl .= '&continent_id=' . $continent_id;
	}
	if (intval($area_id) > 0) {
		$pUrl .= '&area_id=' . $area_id;
	}
	if (intval($continent_id) > 0) {
		$pUrl .= '&country_id=' . $country_id;
	}
	#
	if ($pvalTable == 0) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');
	}
	#
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
	$clsISO = new ISO();
	$clsCityStore = new CityStore();
	$classTable = "Region";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	#
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : '';
	$area_id = isset($_GET['area_id']) ? $_GET['area_id'] : '';
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
	#
	$pUrl = '';
	if (intval($continent_id) > 0) {
		$pUrl .= '&continent_id=' . $continent_id;
	}
	if (intval($area_id) > 0) {
		$pUrl .= '&area_id=' . $area_id;
	}
	if (intval($continent_id) > 0) {
		$pUrl .= '&country_id=' . $country_id;
	}
	#
	/*if($pvalTable == 0){
		header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=notPermission');
	}*/
	#
	if ($clsClassTable->deleteOne($pvalTable)) {
		$clsCityStore->deleteByCond("region_id='$pvalTable' and type='Region'");
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=DeleteSuccess');
	}
}
function default_ajDeleteMultiItem()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav;
	#
	$clsTable = $_POST['clsTable'];
	$listID = isset($_POST['listID']) ? $_POST['listID'] : '';
	#
	$clsClassTable = new $clsTable();
	if ($listID != '' && $listID != '0') {
		$temp = explode('|', $listID);
		if (is_array($temp) && count($temp) > 0) {
			for ($i = 0; $i < count($temp); $i++) {
				$clsClassTable->deleteOne($temp[$i]);
			}
		}
	}
}
function default_ajSelectCountry()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn;
	$user_id = $core->_USER['user_id'];
	#
	$clsContinent = new Continent();
	$clsCountry = new Country();
	$continent_id = isset($_POST['continent_id']) ? intval($_POST['continent_id']) : 0;
	$country_id = !empty($_POST['country_id']) ? intval($_POST['country_id']) : 0;
	#
	$Html = $clsContinent->getOptCountryByContinent($continent_id, $country_id);
	echo $Html;
	die();
}

function default_ajaxLoadCityRegion()
{
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsCountry = new Country();
	$clsCity = new City();
	$clsCityRegion = new CityRegion();
	$country_id = $_POST['country_id'];
	$region_id = $_POST['region_id'];

	$Html = '';
	$lstItem = $clsCity->getAll("is_trash=0 and country_id='$country_id' order by order_no DESC");
	if (is_array($lstItem) && count($lstItem) > 0) {
		foreach ($lstItem as $k => $v) {
			$Html .= '<label class="lblcheck ' . ($clsCityRegion->checkExist($hotel_id, $v[$clsCity->pkey]) ? 'lblchecked' : '') . '">
			<input class="changeHotelFacility hotel_fa" type="checkbox" ' . ($clsCityRegion->checkExist($hotel_id, $v[$clsCity->pkey]) ? 'checked="checked"' : '') . '   value="' . $v[$clsCity->pkey] . '" />&nbsp; 
			
			' . $clsCity->getTitle($v[$clsCity->pkey]) . '</label>';
		}
	}
	$Html .= '<label class="lblcheck">
		<a href="' . PCMS_URL . '/index.php?mod=city&act=edit"><img src="' . URL_IMAGES . '/v2/add.png" align="absmiddle" /> ' . $core->get_Lang('AddMoreCity') . '</a></label>';
	echo $Html;
	die();
}
require_once(DIR_MODULES . '/region/mod_default.php');
