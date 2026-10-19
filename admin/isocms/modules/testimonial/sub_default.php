<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting;

	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	#
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '';
		if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	/**/
	$classTable = "Testimonial";
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
	} elseif ($type_list == 'Trash') {
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
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit); //print_r($cond." order by ".$orderBy.$limit);die();
	$assign_list["allItem"] = $allItem;
	#
	$allTrash =  $clsClassTable->getAll("is_trash=1 and " . $cond2);
	$assign_list["number_trash"] = count($allTrash) ?? 0;
	#
	$allUnTrash =  $clsClassTable->getAll("is_trash=0 and " . $cond2);
	$assign_list["number_item"] = count($allUnTrash) ?? 0;
	#
	$allAll =  $clsClassTable->getAll($cond2);
	$assign_list["number_all"] = count($allAll) ?? 0;

	#----
	if (isset($_POST['submit'])) {
		if ($_POST['submit'] == 'UpdateTestimonial') {
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
function default_ajUpdPosSortListTestimonial()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#
	$order = $_POST['order'] ?? [];
	$clsISO->sortByData('Testimonial', $order);
}
function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO, $pvalTable, $clsClassTable;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;
	$assign_list["listCountry"] = $clsCountry->getAll("is_trash=0 order by order_no asc");
	#
	$classTable = "Testimonial";
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
	$config_link = 'config_link';
	$assign_list["config_link"] = $config_link;
	$config_value_title = 'config_value_title';
	$assign_list["config_value_title"] = $config_value_title;
	$config_value_intro = 'config_value_intro';
	$assign_list["config_value_intro"] = $config_value_intro;
	$config_value_keyword = 'config_value_keyword';
	$assign_list["config_value_keyword"] = $config_value_keyword;
	$clsMeta = new Meta();
	$assign_list["clsMeta"] = $clsMeta;
	$linkMeta = $clsClassTable->getLink($pvalTable);
	$allMeta = $clsMeta->getAll("$config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'];
	$assign_list["meta_id"] = $meta_id;
	$assign_list["oneMeta"] = $clsMeta->getOne($meta_id);

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 25, 1,  "style='width:100%'");
	#
	if ($string != '' && $pvalTable == 0) {
		header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
	}
	#
	if (intval($pvalTable) > 0 && $clsConfiguration->getValue('SiteHasTags_Testimonial')) {
		#---Edit Tags of post
		$clsTag = new Tag();
		$assign_list["clsTag"] = $clsTag;
		$listAllTag = $clsTag->getAll("1=1 and title<>'' order by title asc limit 0,5000");
		#
		$listAvailableTag = '<script type="text/javascript">var availableTags = [';
		for ($i = 0; $i < count($listAllTag); $i++) {
			$listAvailableTag .= '{ name: "' . $listAllTag[$i]['title'] . '", val: "' . $listAllTag[$i]['title'] . '" },';
		}
		$listAvailableTag .= '];</script>';
		$assign_list["listAvailableTag"] = $listAvailableTag;
		#
		$clsTagModule = new TagModule();
		$assign_list["clsTagModule"] = $clsTagModule;
		$listTag = $clsTagModule->getAll("1=1 and for_id='$pvalTable' and type = '_TESTIMONIAL' order by reg_date asc limit 0,20");
		$assign_list["listTag"] = $listTag;
		unset($listAllTag);
		unset($listTag);
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
			$set .= ",slug='" . $clsISO->replaceSpace2($_POST['iso-title']) . "'";

			#--Special Field: image
			if (_isoman_use) {
				$image = $_POST['isoman_url_image'];
				$set .= ",image = '" . addslashes($image) . "'";
			} else {
				$image = $_POST['image'];
				if ($image != '' && $image != '0') {
					$value .= ",image='" . addslashes($image) . "'";
				}
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$set .= ",is_online='" . $is_online . "'";
			if ($clsClassTable->updateOne($pvalTable, $set)) {
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
				#
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=updateSuccess');
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

			$max_id = $clsClassTable->getMaxId();
			$field .= ",user_id,user_id_update,reg_date,upd_date,slug,$clsClassTable->pkey,order_no";
			$value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
			$value .= ",'" . $clsISO->replaceSpace2($_POST['iso-title']) . "','" . $max_id . "','1'";

			#--Special Field: image
			if (_isoman_use) {
				$field .= ",image";
				$value .= ",'" . addslashes($_POST['isoman_url_image']) . "'";
			} else {
				$image = $_POST['image'];
				if ($image != '' && $image != '0') {
					$value .= ",image='" . addslashes($image) . "'";
				}
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&' . $clsClassTable->pkey . '=' . $core->encryptID($max_id) . '&message=updateSuccess');
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
	$classTable = "Testimonial";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));

	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

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
	$classTable = "Testimonial";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));

	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

	if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=RestoreSuccess');
	}
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Testimonial";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));

	if ($string = '' && $pvalTable == 0)
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

	if (isset($_POST['agree']) && $_POST['agree'] == 'agree') {
		if ($clsClassTable->doDelete($pvalTable)) {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=DeleteSuccess');
		}
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
			$image = '';
			if ($_POST['isoman_url_image_seo']) {
				$image = addslashes($_POST['isoman_url_image_seo']);
			}
			if ($meta_id == '') {
				$clsMeta->insertOne("config_link,reg_date,meta_id", "'" . $linkMeta . "','" . time() . "','" . $clsMeta->getMaxID() . "'");
				$allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
				$meta_id = $allMeta[0]['meta_id'];
			}
			$clsMeta->updateOne($meta_id, "config_value_intro='" . addslashes($_POST['config_value_intro']) . "',config_value_keyword='" . addslashes($_POST['config_value_keyword']) . "',config_value_title='" . addslashes($_POST['config_value_title']) . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "',image='" . $image . "'");
		}
		header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess' . $extUrl);
	}
}

/*========== SITE TESTIMONIAL TAGS =============*/
function default_ajSiteTestimonialTags()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTag = new Tag();
	$clsTagModule = new TagModule();
	$for_id = isset($_POST['for_id']) ? intval($_POST['for_id']) : 0;
	$tag_module_id = isset($_POST['tag_module_id']) ? intval($_POST['tag_module_id']) : 0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	$type = isset($_POST['type']) ? $_POST['type'] : '';
	$user_id = $core->_USER['user_id'];
	#
	if ($tp == 'S') {
		$html = '';
		$val = isset($_POST['val']) ? trim(addslashes($_POST['val'])) : '';
		$slugPost = $core->replaceSpace($val);
		$tag_id = $clsTag->getBySlug($slugPost);
		#
		if ($tag_id == '' || $tag_id == 0) {
			$clsTag->insertOne("title,slug", "'" . addslashes($val) . "','$slugPost'");
			$tag_id = $clsTag->getBySlug($slugPost);
		}
		$tag_module_id = $clsTagModule->getId($tag_id, $for_id, $type);
		if ($tag_module_id == '' || $tag_module_id == 0) {
			$fx = "$clsTagModule->pkey,tag_id,for_id,type,user_id,reg_date,val";
			$vx = "'" . $clsTagModule->getMaxID() . "','$tag_id','$for_id','" . $type . "','" . $user_id . "','" . time() . "','1'";
			$clsTagModule->insertOne($fx, $vx);
			#
			$tag_module_id = $clsTagModule->getId($tag_id, $for_id, $type);
			$html .= '<span class="tagz"><a href="javascript:void(0);" class="closeTag" title="' . $core->get_Lang('delete') . '" id="t-' . $tag_module_id . '">x</a>' . $val . '</span></div>';
			echo ($html);
			die();
		} else {
			echo '_EXIST';
			die();
		}
	} elseif ($tp == 'D') {
		$clsTagModule->deleteOne($tag_module_id);
		echo 1;
		die();
	}
}
require_once(DIR_MODULES . '/testimonial/mod_default.php');
