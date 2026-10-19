<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn, $clsISO, $package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#
	if ($clsISO->getCheckActiveModulePackage($package_id, 'continent', 'default', 'default') && $core->checkAccess('continent')) {
		$clsContinent = new Continent();
		$assign_list["clsContinent"] = $clsContinent;
		$sql = "is_trash=0 and is_online=1 order by order_no ASC";
		$lstContinent = $clsContinent->GetAll($sql);
		$assign_list["lstContinent"] = $lstContinent;
	}
	$continent_id = isset($_GET['continent_id']) ? intval($_GET['continent_id']) : 0;
	$assign_list["continent_id"] = $continent_id;
	#
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '';
		if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		if (isset($_POST['continent_id']) && !empty($_POST['continent_id'])) {
			$link .= '&continent_id=' . $_POST['continent_id'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	/**/
	$classTable = "Country";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	/*List all item*/
	$cond = "1=1";
	//$cond = "1=1";
	if (isset($continent_id) && intval($continent_id) != 0) {
		$cond .= " and continent_id=" . $continent_id;
		$assign_list["continent_id"] = $continent_id;
		$pUrl .= '&continent_id=' . $continent_id;
	}
	if (isset($area_sub_id) && intval($area_sub_id) != 0) {
		$cond .= " and area_sub_id=" . $area_sub_id;
		$assign_list["area_sub_id"] = $area_sub_id;
		$pUrl .= '&area_sub_id=' . $area_sub_id;
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
	$assign_list['allItem'] = $allItem;
	$allTrash =  $clsClassTable->GetAll("1=1 and is_trash=1");
	$assign_list["number_trash"] = $allTrash ? count($allTrash) : 0;
	$allUnTrash =  $clsClassTable->GetAll("1=1 and is_trash=0");
	$assign_list["number_item"] = $allUnTrash != '' ? count($allUnTrash) : 0;
	$allAll =  $clsClassTable->GetAll("1=1");
	$assign_list["number_all"] = $allAll != '' ? count($allAll) : 0;
	#----
	if (isset($_POST['submit'])) {
		if (isset($_POST['submit']) && $_POST['submit'] == 'SiteUpdateDestinationPage') {
			foreach ($_POST as $key => $val) {
				$tmp = explode('-', $key);
				if ($tmp[0] == 'iso') {
					$clsConfiguration->updateValue($tmp[1], $val);
				}
			}
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
		}
	}
}
function default_ajUpdPosSortCountry()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguratio, $clsISO;
	#
	$order = $_POST['order'] ?? [];
	$clsISO->sortByData('Country', $order);
}
function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO, $dbconn, $clsConfiguration, $pvalTable, $clsClassTable, $package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
	#
	if ($clsISO->getCheckActiveModulePackage($package_id, 'continent', 'default', 'default') && $core->checkAccess('continent')) {
		$clsContinent = new Continent();
		$assign_list["clsContinent"] = $clsContinent;
		$lstContinent = $clsContinent->GetAll("is_trash=0 and is_online=1 order by order_no ASC", $clsContinent->pkey);
		$assign_list["lstContinent"] = $lstContinent;
	}
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : '';
	$assign_list["continent_id"] = $continent_id;
	#
	$classTable = "Country";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
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
	$clsForm->addInputTextArea("simple150", 'intro_banner', "", 'intro_banner', 255, 5, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'room_option', "", 'room_option', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_fastfact', "", 'intro_fastfact', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_hotel', "", 'intro_hotel', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_tour', "", 'intro_tour', 255, 25, 1, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'intro_guide', "", 'intro_guide', 255, 25, 1, 1,  "style='width:100%'");
	#
	/*if(($string!='' && $pvalTable==0) || $pvalTable==0){
		header('location:'.PCMS_URL.'/index.php?&mod='.$mod.'&message=notPermission');
	}*/
	#
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
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$image_map = isset($_POST['image_map_src']) ? $_POST['image_map_src'] : '';
			$image_tour = isset($_POST['image_tour_src']) ? $_POST['image_tour_src'] : '';
			$image_hotel = isset($_POST['image_hotel_src']) ? $_POST['image_hotel_src'] : '';
			$banner = isset($_POST['banner_src']) ? $_POST['banner_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
				$image_map = isset($_POST['isoman_url_image_map']) ? $_POST['isoman_url_image_map'] : '';
				$image_tour = isset($_POST['isoman_url_image_tour']) ? $_POST['isoman_url_image_tour'] : '';
				$image_hotel = isset($_POST['isoman_url_image_hotel']) ? $_POST['isoman_url_image_hotel'] : '';
				$banner = isset($_POST['isoman_url_banner']) ? $_POST['isoman_url_banner'] : '';
			}
			if ($image != '' && $image != '0' || $banner != '' && $banner != '0' || $image_map != '' && $image_map != '0' || $image_tour != '' && $image_tour != '0' || $image_hotel != '' && $image_hotel != '0') {
				$set .= ",image='" . addslashes($image) . "'";
				$set .= ",image_map='" . addslashes($image_map) . "'";
				$set .= ",image_tour='" . addslashes($image_tour) . "'";
				$set .= ",image_hotel='" . addslashes($image_hotel) . "'";
				$set .= ",banner='" . addslashes($banner) . "'";
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$set .= ",is_online='" . $is_online . "'";
			#
			$site_destination_banner = $_POST['isoman_url_site_destination_banner'];
			if ($site_destination_banner != '' && $site_destination_banner != '0') {
				$clsConfiguration->updateValue('site_destination_banner', $site_destination_banner);
			}
			$site_destination_intro_banner = $_POST['isoman_url_site_destination_intro_banner'];
			if ($site_destination_intro_banner != '' && $site_destination_intro_banner != '0') {
				$clsConfiguration->updateValue('site_destination_intro_banner', $site_destination_intro_banner);
			}
			$site_destination_intro_fastfact = $_POST['isoman_url_site_destination_intro_fastfact'];
			if ($site_destination_intro_fastfact != '' && $site_destination_intro_fastfact != '0') {
				$clsConfiguration->updateValue('site_destination_intro_fastfact', $site_destination_intro_fastfact);
			}
			if ($clsClassTable->updateOne($pvalTable, $set)) {
				$titleMeta = $_POST['config_value_title'] ? addslashes($_POST['config_value_title']) : addslashes($_POST['title']);
				$introMeta = strip_tags(html_entity_decode(addslashes($_POST['iso-intro'])));
				$descriptionMeta = $_POST['config_value_intro'] ? addslashes($_POST['config_value_intro']) : substr($introMeta, 0, 280);
				$image_seo     = isset($_POST['image_seo_src']) ? $_POST['image_seo_src'] : '';
				if (_isoman_use) {
					$image_seo     = $_POST['isoman_url_image_seo'];
				}
				$image_seo = $image_seo ? $image_seo : $image;
				if (empty($meta_id)) {
					$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,meta_index,meta_follow", "'" . $linkMeta . "','" . $titleMeta . "','" . $descriptionMeta . "','" . $image_seo . "','" . time() . "','" . time() . "','" . $clsMeta->getMaxId() . "','" . $_POST['meta_index'] . "','" . $_POST['meta_follow'] . "'");
					$allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
				} else {
					$clsMeta->updateOne($meta_id, "config_value_intro='" . $descriptionMeta . "',config_value_title='" . $titleMeta . "',image='" . $image_seo . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
				}
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&country_id=' . $_GET[$clsClassTable->pkey] . '&message=updateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&act=edit&country_id=' . $_GET[$clsClassTable->pkey] . '&message=updateFailed');
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
			$field .= ",user_id,user_id_update,reg_date,upd_date,title,slug,$clsClassTable->pkey,order_no";
			$value .= ",'$user_id','$user_id','" . time() . "','" . time() . "','" . $title . "'";
			$value .= ",'" . $core->replaceSpace($_POST['title']) . "','" . $max_id . "','1'";
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$image_map = isset($_POST['image_map_src']) ? $_POST['image_map_src'] : '';
			$image_tour = isset($_POST['image_tour_src']) ? $_POST['image_tour_src'] : '';
			$image_hotel = isset($_POST['image_hotel_src']) ? $_POST['image_hotel_src'] : '';
			$banner = isset($_POST['banner_src']) ? $_POST['banner_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
				$image_map = isset($_POST['isoman_url_image_map']) ? $_POST['isoman_url_image_map'] : '';
				$image_tour = isset($_POST['isoman_url_image_tour']) ? $_POST['isoman_url_image_tour'] : '';
				$image_hotel = isset($_POST['isoman_url_image_hotel']) ? $_POST['isoman_url_image_hotel'] : '';
				$banner = isset($_POST['isoman_url_banner']) ? $_POST['isoman_url_banner'] : '';
			}
			if ($image != '' && $image != '0' || $banner != '' && $banner != '0' || $image_map != '' && $image_map != '0' || $image_tour != '' && $image_tour != '0' || $image_hotel != '' && $image_hotel != '0') {
				$field .= ',image';
				$value .= ",'" . addslashes($image) . "'";
				$field .= ',image_map';
				$value .= ",'" . addslashes($image_map) . "'";
				$field .= ',image_tour';
				$value .= ",'" . addslashes($image_tour) . "'";
				$field .= ',image_hotel';
				$value .= ",'" . addslashes($image_hotel) . "'";
				$field .= ',banner';
				$value .= ",'" . addslashes($banner) . "'";
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			#
			$site_destination_banner = $_POST['isoman_url_site_destination_banner'];
			if ($site_destination_banner != '' && $site_destination_banner != '0') {
				$clsConfiguration->updateValue('site_destination_banner', $site_destination_banner);
			}
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&country_id=' . $core->encryptID($max_id) . '&continent_id=' . $_POST['iso-continent_id'] . '&message=updateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&continent_id=' . $_POST['iso-continent_id'] . '&message=insertSuccess');
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
	$classTable = "Country";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : "";
	#
	$pUrl = '';
	if (intval($continent_id) > 0) {
		$pUrl .= '&continent_id=' . $continent_id;
	}
	if ($pvalTable == "") {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');
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
	$classTable = "Country";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : "";
	$param_url = '';
	if (intval($continent_id) != 0) {
		$param_url .= '&continent_id=' . $continent_id;
	}
	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=notPermission');
	if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=RestoreSuccess');
	}
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	$clsCruiseCat = new CruiseCat();
	#
	$classTable = "Country";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : "";
	$param_url = '';
	if (intval($continent_id) != 0) {
		$param_url .= '&continent_id=' . $continent_id;
	}
	if ($string = '' && $pvalTable == 0)
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
	if (isset($_POST['agree']) && $_POST['agree'] == 'agree') {
		if ($clsClassTable->doDelete($pvalTable)) {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=DeleteSuccess');
		}
	}
}
function default_move()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Country";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	#
	$pvalTable = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : "";
	$direct = isset($_GET['direct']) ? $_GET['direct'] : '';
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	if ((isset($string) && !empty($string) && $pvalTable == 0) || $direct == '') {
		header('location: ' . PCMS_URL . '/?mod=' . $mod);
	}
	$where = '1=1 and is_trash=0 ';
	$param_url = '';
	if (intval($continent_id) != 0) {
		$where .= " and continent_id=" . $continent_id;
		$param_url .= '&continent_id=' . $continent_id;
	}
	if ($direct == 'movedown') {
		$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	if ($direct == 'moveup') {
		$lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	if ($direct == 'movebottom') {
		$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
		for ($i = 0; $i < count($lstItem); $i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
		}
	}
	if ($direct == 'movetop') {
		$lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
		for ($i = 0; $i < count($lstItem); $i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
		}
	}
	header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=PositionSuccess');
}
/*------ Departure Point City -------*/
function default_store()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#
	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;
	$clsCityStore = new CityStore();
	$assign_list["clsCityStore"] = $clsCityStore;
	#
	$classTable = "City";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
	$assign_list["country_id"] = $country_id;
	$type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : '';
	$assign_list["type"] = $type;
	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
	$assign_list["keyword"] = $keyword;
	if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default', $_GET['type'])) {
		header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
		exit();
	}
	if ($type == '' && intval($country_id) == 0) {
		header('location: ' . PCMS_URL . '/?mod=city&message=notPermission');
	}
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '&act=' . $act;
		$link .= '&type=' . $core->encryptID($type);
		if (isset($_POST['country_id']) != '' && $_POST['country_id'] != '') {
			$link .= '&country_id=' . $_POST['country_id'];
		}
		if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Tìm kiếm...') {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		//print_r($link); die();
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	#
	$cond = "is_trash=0 and is_online=1";
	if (isset($country_id) && intval($country_id) != 0) {
		$cond .= " and country_id='$country_id'";
		$pUrl .= '&country_id=' . $country_id;
	}
	if ($type != '') {
		$cond .= " and city_id NOT IN (SELECT city_id FROM " . DB_PREFIX . "citystore WHERE is_trash=0 and type='$type')";
		$pUrl .= '&type=' . $core->encryptID($type);
	}
	if ($keyword != '') {
		$slug = $core->replaceSpace($keyword);
		$cond .= " and slug like '%" . $slug . "%'";
	}
	$orderBy = " order_no asc";
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
	$listItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit, $clsClassTable->pkey . ",country_id");
	//print_r($cond); die();
	$assign_list["listItem"] = $listItem;
	$sql_select = "is_trash=0 and type = '$type'";
	#
	if ($country_id > 0) {
		$sql_select .= " and country_id='$country_id'";
	}
	$orderBy_selected = " order by order_no ASC";
	$listSelected =  $clsCityStore->getAll($sql_select . $orderBy_selected);
	$assign_list["listSelected"] = $listSelected;
	//Action
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	if ($action == 'Add') {
		$pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
		if ($pvalTable == '' && $pvalTable == 0) {
			header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		if (!$clsCityStore->checkExist($pvalTable, $type)) {
			$max_id = $clsCityStore->getMaxID();
			$max_order_no = $clsCityStore->getMaxOrderNo();
			$f = "$clsCityStore->pkey,city_id,country_id,type,order_no";
			$v = "'$max_id','$pvalTable','$country_id','$type','$max_order_no'";
			#
			if ($clsCityStore->insertOne($f, $v)) {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&type=' . $core->encryptID($type) . '&message=insertSuccess');
			}
		}
	}
}

function default_ajUpdPosSortCityStore()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#
	$order = $_POST['order'] ?? [];
	$clsISO->sortByData('CityStore', $order);
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
		header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess' . ($extUrl ?? ''));
	}
}
function default_ajMoveCityStore()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsClassTable = new CityStore();
	$pvalTable = isset($_POST['citystore_id']) ? $_POST['citystore_id'] : 0;
	$city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	$direct = isset($_POST['direct']) ? $_POST['direct'] : '';
	$type = isset($_POST['type']) ? $_POST['type'] : '';
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	$cond = "is_trash=0 and country_id = '$country_id'";
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
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	$clsCityStore = new CityStore();
	$type = isset($_POST['type']) ? $_POST['type'] : '';
	$lstCheckbox = $_POST['lstCheckbox'];
	if ($lstCheckbox != '') {
		foreach ($lstCheckbox as $key => $item) {
			if (!$clsCityStore->checkExist($item['city_id'], $type)) {
				#
				$max_id = $clsCityStore->getMaxID();
				$max_order = $clsCityStore->getMaxOrderNo();
				$dataInsert = array(
					'citystore_id' => $max_id,
					'city_id' => $item['city_id'],
					'country_id' => $item['country_id'],
					'type' => $type,
					'order_no' => $max_order,
				);
				$clsCityStore->insert($dataInsert);
			}
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
/*------ Ajax -------*/
function default_ajmakeSelectboxByCity()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsCity = new City();
	$country_id = $_POST['country_id'];
	#
	$lstItem = $clsCity->getAll("is_trash=0 and is_top=0 and country_id='$country_id' order by order_no asc");
	$html = '';
	if (!empty($lstItem)) {
		foreach ($lstItem as $item) {
			$html .= '<li>';
			$html .= '<label><input class="chkitem" name="chkid_city[]" value="' . $item[$clsCity->pkey] . '" type="checkbox">&nbsp;' . $clsCity->getTitle($item[$clsCity->pkey]) . '</label>';
			$html .= '</li>';
		}
	}
	echo $html;
	die();
}
function default_ajActionNewCountry()
{
	//	ini_set('display_errors', '1');
	//	ini_set('display_startup_errors', '1');
	//	error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,
		$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $clsISO, $package_id;
	$user_id = $core->_USER['user_id'];
	#
	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;
	$tp = Input::post('tp');
	$is_day_trip = Input::post('is_day_trip', 0);
	$country_id = $clsCountry->getMaxId();
	$title_voucher_new = $core->get_Lang('New Country') . ' ' . $country_id;
	$results = array('result' => 'error');
	if ($tp = 'S') {
		$field = $clsCountry->pkey . ",user_id,user_id_update,title,slug,order_no,reg_date,upd_date";
		$value = "'" . $country_id . "','" . $user_id . "','" . $user_id . "','" . $title_voucher_new . "','" . $core->replaceSpace($title_voucher_new) . "'," . $clsCountry->getMaxOrderNo() . ",'" . time() . "','" . time() . "'";
		$clsCountry->insertOne($field, $value);
		$results = array('result' => 'success', 'link' => 'country/insert/' . $country_id . '/overview');
	}
	// Return
	echo @json_encode($results);
	die();
}
require_once(DIR_MODULES . '/country/mod_default.php');
