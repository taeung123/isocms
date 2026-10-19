<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
	#
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
			$link = '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	/**/
	$classTable = "Continent";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	/*List all item*/
	$cond = "1='1'";
	#Filter By Keyword
	if (isset($_GET['keyword'])) {
		if ($_GET['keyword'] != '') {
			$keyword = $core->replaceSpace($_GET['keyword']);
			$cond .= " and slug like '%" . $keyword . "%'";
			$assign_list["keyword"] = $_GET['keyword'];
		}
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
	$assign_list["allItem"] = $allItem;
	#
	$allTrash =  $clsClassTable->GetAll("is_trash=1 and " . $cond2);
	$assign_list["number_trash"] = count($allTrash) ?? 0;
	#
	$allUnTrash =  $clsClassTable->GetAll("is_trash=0 and " . $cond2);
	$assign_list["number_item"] = count($allUnTrash) ?? 0;
	#
	$allAll =  $clsClassTable->GetAll("1=1 and " . $cond2);
	$assign_list["number_all"] = count($allAll) ?? 0;

	#----
	if (isset($_POST['submit'])) {
		if ($_POST['submit'] == 'UpdateFaqsIntro') {
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
	global $assign_list, $clsISO, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $pvalTable, $clsClassTable;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Continent";
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

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 5, 1,  "style='width:100%'");
	#
	if ($string != '' && $pvalTable == 0) {
		header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
	}
	#
	$clsMeta = new Meta();
	$assign_list["clsMeta"] = $clsMeta;
	$linkMeta = $clsClassTable->getLink($pvalTable);

	$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'] ?? 0;
	$assign_list["meta_id"] = $meta_id;
	$assign_list["oneMeta"] = $clsMeta->getOne($meta_id);
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
			#
			$set .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
			$set .= ",upd_date='" . time() . "'";
			$set .= ",slug='" . $core->replaceSpace($_POST['iso-title']) . "'";
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$set .= ",is_online='" . $is_online . "'";
			#

			if ($clsISO->checkExistTitle($classTable, $pvalTable, $_POST['iso-title'], '', 1)) {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=titleHasExisted');
				exit();
			}
			if ($clsClassTable->updateOne($pvalTable, $set)) {
				$titleMeta = $_POST['config_value_title'] ? addslashes($_POST['config_value_title']) : addslashes($_POST['iso-title']);
				$introMeta = strip_tags(html_entity_decode(addslashes($_POST['iso-intro'])));
				$descriptionMeta = $_POST['config_value_intro'] ? addslashes($_POST['config_value_intro']) : substr($introMeta, 0, 160);

				$schema = $clsClassTable->getSchemaMarkupFromPost();
				if (!$schema['success']) {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=updateFailed');
				exit();
				}
				$schema_markup = $schema['data'];


				$image_seo     = isset($_POST['image_seo_src']) ? $_POST['image_seo_src'] : '';
				if (_isoman_use) {
					$image_seo     = $_POST['isoman_url_image_seo'];
				}
				$image_seo = $image_seo ? $image_seo : $image;

				if ($meta_id == 0) {
					$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,meta_index,meta_follow,schema_markup", "'" . $linkMeta . "','" . $titleMeta . "','" . $descriptionMeta . "','" . $image_seo . "','" . time() . "','" . time() . "','" . $clsMeta->getMaxId() . "','" . $_POST['meta_index'] . "','" . $_POST['meta_follow'] . "','" . addslashes($schema_markup)	 . "'");
					$allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
				} else {
					$clsMeta->updateOne($meta_id, "config_value_intro='" . $descriptionMeta . "',config_value_title='" . $titleMeta . "',image='" . $image_seo . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'" . ",schema_markup='" . addslashes($schema_markup) . "'");
				}
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=updateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=updateSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=updateFailed');
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
			$field .= ",user_id,user_id_update,reg_date,upd_date,slug,continent_id,order_no";
			$value .= ",'$user_id','$user_id','" . time() . "','" . time() . "','" . $core->replaceSpace($_POST['iso-title']) . "','$max_id','" . $clsClassTable->getMaxOrderNo() . "'";
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			#
			//print_r($field.'<br />'.$value); die();
			if ($clsISO->checkExistTitle($classTable, 0, $_POST['iso-title'], '', 1)) {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&message=titleHasExisted');
				exit();
			}
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&continent_id=' . $core->encryptID($max_id) . '&message=updateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertSuccess');
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
	$classTable = "Continent";
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
	$classTable = "Continent";
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
	#
	$clsCountry = new Country();
	#
	$classTable = "Continent";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	if ($string == '' && $pvalTable == 0) {
		header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
		exit();
	}

	$tmp = $clsCountry->getAll("area_id = '$pvalTable' limit 0,1");
	if ($tmp[0]['area_id'] != '') {
		header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=DeleteFailed');
		exit();
	}

	if (isset($_POST['agree']) && $_POST['agree'] == 'agree') {
		if ($clsClassTable->doDelete($pvalTable)) {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=DeleteSuccess');
		}
	}
}
function default_move()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Continent";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	#
	$pvalTable = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : "";
	$direct = isset($_GET['direct']) ? $_GET['direct'] : '';

	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	print_r($order_no);
	die();
	if (($string != '' && $pvalTable == 0) || $direct == '') {
		header('location: ' . PCMS_URL . '/?mod=' . $mod);
	}

	$where = '1=1 and is_trash=0';
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
		$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	if ($direct == 'movebottom') {
		$lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no asc");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
		$lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
		for ($i = 0; $i < count($lstItem); $i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
		}
	}
	if ($direct == 'movetop') {
		$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no desc");
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

function default_ajUpdPosSortContinent()
{
	global $clsISO;
	$order = $_POST['order'];
	$clsISO->sortByData('Continent', $order);
}
