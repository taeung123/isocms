<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $about_us_id, $clsISO, $package_id;
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
	$classTable = "Page";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	/*List all item*/
	$cond = "1=1";
	if ($clsISO->getCheckActiveModulePackage($package_id, 'page', 'about', 'default')) {
		$cond .= " and page_id<>'$about_us_id'";
	}
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
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
	$assign_list["allItem"] = $allItem;
	unset($allItem);
}
function default_about()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "YearJourney";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;


	$post_type = (isset($_GET['post_type']) && $_GET['post_type'] != '') ? $_GET['post_type'] : 'YEARJOURNEY';
	$assign_list["post_type"] = $post_type;

	#- List_Button
	$listYearJourney = $clsClassTable->getAll("1=1 and post_type='YEARJOURNEY' order by order_no ASC");
	$assign_list["listYearJourney"] = $listYearJourney;

	$listReasons = $clsClassTable->getAll("1=1 and post_type='REASON' order by order_no ASC");
	$assign_list["listReasons"] = $listReasons;

	#
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$clsConfiguration->updateValue($tmp[1], $val);
			}
		}
		$site_about_logo_home = $_POST['isoman_url_site_about_logo_home'];
		if ($site_about_logo_home != '' && $site_about_logo_home != '0') {
			$clsConfiguration->updateValue('site_about_logo_home', $site_about_logo_home);
		}
		$site_about_page_banner = $_POST['isoman_url_site_about_page_banner'];
		if ($site_about_page_banner != '' && $site_about_page_banner != '0') {
			$clsConfiguration->updateValue('site_about_page_banner', $site_about_page_banner);
		}
		$site_about_page_logo = $_POST['isoman_url_site_about_page_logo'];
		if ($site_about_page_logo != '' && $site_about_page_logo != '0') {
			$clsConfiguration->updateValue('site_about_page_logo', $site_about_page_logo);
		}

		$site_about_page_bg_download = $_POST['isoman_url_site_about_page_bg_download'];
		if ($site_about_page_bg_download != '' && $site_about_page_bg_download != '0') {
			$clsConfiguration->updateValue('site_about_page_bg_download', $site_about_page_bg_download);
		}

		$about_page_file_download = $_POST['isoman_url_about_page_file_download_' . $_LANG_ID];
		$clsConfiguration->updateValue('about_page_file_download_' . $_LANG_ID, $about_page_file_download);

		/* Update Link */
		for ($i = 0; $i < count($listYearJourney); $i++) {
			$year_journey_id = $listYearJourney[$i][$clsClassTable->pkey];
			$titlePost = addslashes($_POST['title_' . $year_journey_id]);
			$linkPost = addslashes($_POST['link_' . $year_journey_id]);
			$imagePost = addslashes($_POST['image_' . $year_journey_id]);
			$introPost = isset($_POST['intro_' . $year_journey_id]) ? addslashes($_POST['intro_' . $year_journey_id]) : '';
			$business_year = isset($_POST['business_year_' . $year_journey_id]) ? addslashes($_POST['business_year_' . $year_journey_id]) : '';
			#
			$clsClassTable->updateOne($year_journey_id, "title='$titlePost',image='$imagePost',intro='$introPost',business_year='$business_year'");
		}
		for ($i = 0; $i < count($listReasons); $i++) {
			$reason_id = $listReasons[$i][$clsClassTable->pkey];
			$titlePost = addslashes($_POST['title_' . $reason_id]);
			$introPost = isset($_POST['intro_' . $reason_id]) ? addslashes($_POST['intro_' . $reason_id]) : '';
			#
			$clsClassTable->updateOne($reason_id, "title='$titlePost',image='$imagePost',icon='" . ($iconPost ?? '') . "',intro='$introPost'");
		}

		header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&post_type=' . $post_type . '&message=UpdateSuccess');
		exit();
	}
	#
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	if ($action == 'new') {
		$max_id = $clsClassTable->getMaxID();
		$fx = "year_journey_id,title,link,post_type,reg_date,order_no";
		$num = $clsClassTable->getAll("post_type='$post_type'") ? count($clsClassTable->getAll("post_type='$post_type'")) : 0;
		$vx = "$max_id,'Blank-" . ($num + 1) . "','Link-" . ($num + 1) . "','$post_type','" . time() . "','" . $clsClassTable->getMaxOrderNo() . "'";
		if ($clsClassTable->insertOne($fx, $vx)) {
			header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=InsertSuccess#box_' . $max_id . '');
			exit();
		}
	}
	if ($action == 'delete') {
		$pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
		if ($pvalTable == '') {
			header('location:' . PCMS_URL . 'index.php?mod=' . $mod . '&message=NotPermission');
			exit();
		}
		#
		$clsClassTable->deleteOne($pvalTable);
		header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&post_type=' . $post_type . '#' . $post_type);
		exit();
	}
}
function default_ajUpdPosSortListPage()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#
	$order = $_POST['order'] ?? [];
	$clsISO->sortByData('Page', $order);
}
function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO, $pvalTable, $clsClassTable;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Page";
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
	$clsForm->addInputTextArea("full", "intro", "", "intro", 255, 25, 25, 1,  "style='width:100%'");
	#
	if ($string != '' && $pvalTable == 0) {
		header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
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
			$set .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
			$set .= ",upd_date='" . time() . "'";
			$set .= ",slug='" . $core->replaceSpace($_POST['iso-title']) . "'";

			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if ($image != '' && $image != '0') {
				$value .= ",image='" . addslashes($image) . "'";
			}
			//print_r($pvalTable.'xxxxx'.$set); die();
			if ($clsClassTable->updateOne($pvalTable, $set)) {
				$clsClassTable->updateLink($pvalTable);
				$titleMeta = $_POST['config_value_title'] ? addslashes($_POST['config_value_title']) : addslashes($_POST['iso-title']);
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
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=updateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=updateSuccess');
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
			#
			$max_id = $clsClassTable->getMaxID();
			$field .= ",$clsClassTable->pkey,user_id,user_id_update,reg_date,upd_date,slug,order_no";
			$value .= ",'" . $max_id . "','" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
			$value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "','1'";

			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image = $_POST['isoman_url_image'];
			}
			if ($image != '' && $image != '0') {
				$field .= ',image';
				$value .= ",'" . addslashes($image) . "'";
			}

			if ($clsClassTable->insertOne($field, $value)) {
				$clsClassTable->updateLink($max_id);
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $core->encryptID($max_id) . '&message=insertSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
			}
		}
	}
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
		$site_about_banner = $_POST['isoman_url_site_about_banner'];
		if ($site_about_banner != '' && $site_about_banner != '0') {
			$clsConfiguration->updateValue('site_about_banner', $site_about_banner);
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
function default_trash()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Page";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));

	if ($pvalTable == 0) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
	}
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
	$classTable = "Page";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));

	if ($pvalTable == 0) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
	}
	if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=TrashSuccess');
	}
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Page";
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

	$classTable = "Page";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	$direct = isset($_GET['direct']) ? $_GET['direct'] : '';

	$where = 'is_trash=0 ';
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];

	if ($pvalTable == "" || $direct == '') {
		header('location: ' . PCMS_URL . '/?mod=' . $mod);
	}
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
		#
		$lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
		for ($i = 0; $i < count($lst); $i++) {
			$clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
		}
	}
	if ($direct == 'movebottom') {
		$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no desc LIMIT 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		#
		$lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
		for ($i = 0; $i < count($lst); $i++) {
			$clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
		}
	}
	header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=PositionSuccess');
}

/*========== MANAGEMENT PAGE WHY =============*/
function default_why()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO;
	$user_id = $core->_USER['user_id'];

	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
	$assign_list["msg"] = $msg ?? '';
	#
	$type_list = isset($_GET['']) ? $_GET[''] : '';
	$assign_list["type_list"] = $type_list;
	#
	$classTable = "Why";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	$clsNews = new News();
	$assign_list["clsNews"] = $clsNews;

	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '';
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
	if ($action == 'Delete') {
		$pvalTable = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
		if ($pvalTable == '' && $pvalTable == 0) {
			header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		if ($clsClassTable->deleteOne($pvalTable)) {
			header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=DeleteSuccess');
		}
	}
	if ($action == 'move') {
		$pvalTable = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
		if ($pvalTable == '' && $pvalTable == 0) {
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
function default_ajSitePageWhy()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $core;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
	$user_id = $core->_USER['user_id'];
	#
	$clsClassTable = new Why();
	$why_id = isset($_POST['why_id']) ? intval($_POST['why_id']) : 0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';

	if ($tp == 'F') {
		$html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . ($why_id == 0 ? $core->get_Lang('add') : $core->get_Lang('edit')) . ' ' . $core->get_Lang('why') . '</h3>
		</div>';
		$html .= '
		<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right"><strong class="color_r">* ' . $core->get_Lang('title') . '</strong></div>
					<div class="fieldarea">
						<input class="text full required" value="' . $clsClassTable->getOneField('title', $why_id) . '" name="title" type="text" autocomplete="off" />
					</div>
				</div>
				<div class="row-span" style="display:none">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('category') . ' <font color="red">*</font></div>
					<div class="fieldarea">
						<select name="parent_id" class="select slb">
							<option value="0"> -- ' . $core->get_Lang('Select category') . ' -- </option>
						</select>
					</div>
				</div>
				' . ($clsConfiguration->getValue('SiteHasContent_Why') ? '<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('intro') . '</div>
					<div class="fieldarea">
						<textarea  id="textarea_intro_editor_' . time() . '" class="textarea_intro_editor" name="intro" style="width:100%">' . $clsClassTable->getOneField('intro', $why_id) . '</textarea>
					</div>
				</div>' : '') . '
				' . ($clsConfiguration->getValue('SiteHasContent_Why') ? '<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('Image') . '</div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsClassTable->getOneField('image', $why_id) . '" />
						<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsClassTable->getOneField('image', $why_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsClassTable->getOneField('image', $why_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>' : '') . '
			</div>
		</form>
		<div class="modal-footer">
			<button type="button" why_id="' . $why_id . '" class="btn btn-primary ClickSubmitWhy">
				<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span> </button>		
		</div>';
		echo ($html);
		die();
	} elseif ($tp == 'S') {
		$titlePost = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
		$slugPost = $core->replaceSpace($titlePost);
		$introPost = isset($_POST['intro']) ? addslashes($_POST['intro']) : '';
		$imagePost = isset($_POST['image']) ? addslashes($_POST['image']) : '';
		#
		if (intval($why_id) == 0) {
			if ($clsClassTable->getAll("is_trash=0 and slug='$slugPost'") != '') {
				echo '_EXIST';
				die();
			} else {
				#
				$fx = "$clsClassTable->pkey,user_id,user_id_update,title,slug,intro,order_no,reg_date,upd_date";
				$vx = "'" . $clsClassTable->getMaxID() . "','$user_id','$user_id','$titlePost','$slugPost','" . $introPost . "'";
				$vx .= ",'" . $clsClassTable->getMaxOrderNo() . "','" . time() . "','" . time() . "'";
				if ($imagePost != '' && $imagePost != '0') {
					$fx .= ",image";
					$vx .= ",'" . addslashes($imagePost) . "'";
				}
				#
				if ($clsClassTable->insertOne($fx, $vx)) {
					echo '_SUCCESS';
					die();
				} else {
					echo '_ERROR';
					die();
				}
			}
		} else {
			$vx = "title='$titlePost',slug='$slugPost',intro='" . $introPost . "',upd_date='" . time() . "'";
			if ($imagePost != '' && $imagePost != '0') {
				$vx .= ",image='" . addslashes($imagePost) . "'";
			}
			if ($clsClassTable->updateOne($why_id, $vx)) {
				echo '_SUCCESS';
				die();
			} else {
				echo '_ERROR';
				die();
			}
		}
	}
}
require_once(DIR_MODULES . '/page/mod_default.php');
