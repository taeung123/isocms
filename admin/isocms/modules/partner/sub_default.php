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

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;

	$partnercat_id = isset($_GET['partnercat_id']) ? intval($_GET['partnercat_id']) : 0;
	$assign_list["cat_id"] = $partnercat_id;

	/**/
	$classTable = "Partner";
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
		if ($_POST['type'] != '') {
			$link .= '&type=' . $_POST['type'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	#
	$cond = "1=1";
	if ($partnercat_id > 0) {
		$cond .= " and cat_id = '" . $partnercat_id . "'";
		//$pUrl.='&partnercat_id=' . $partnercat_id;
	}
	if (isset($_GET['keyword'])) {
		$slug = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (title like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%')";
		$assign_list["keyword"] = $_GET['keyword'];
	}

	if ($type != '') {
		$cond .= " and type = '$type' ";
	} else {
		$cond .= " and type = '' ";
	}
	#
	$cond2 = $cond;
	if ($type_list == 'Trash') {
		$cond .= " and is_trash=1";
	}

	$orderBy = " order_no DESC";

	#-------Page Divide---------------------------------------------------------------
	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
	$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
	$totalRecord = $clsClassTable->getAll($cond) ? count($clsClassTable->getAll($cond)) : 0;
	$assign_list['totalRecord'] = $totalRecord;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalPage'] = $totalPage;

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

	$config = array(
		'total'	=> $totalRecord,
		'current_page'	=> $currentPage,
		'number_per_page'	=> $recordPerPage,
		'link'	=> PCMS_URL . '/index.php' . $link_page_current_2
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links();

	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " limit $offset,$recordPerPage";
	#
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
	$assign_list["allItem"] = $allItem;
	$assign_list["page_view"] = $page_view;
	#
	$allTrash =  $clsClassTable->getAll("is_trash=1 and " . $cond2);
	$assign_list["number_trash"] = count($allTrash) ?? 0;
	#
	$allAll =  $clsClassTable->getAll($cond2);
	$assign_list["number_all"] = count($allAll) ?? 0;
}
function default_ajUpdPosSortListPartner()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#
	$order = $_POST['order'] ?? [];
	$clsISO->sortByData('Partner', $order);
}

function default_category()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO;
	$user_id = $core->_USER['user_id'];
	#- Check enable Module
	if (!$clsConfiguration->getValue('SiteHasCat_Partner')) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
		exit();
	}
	#- End Check
	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	#
	$classTable = "PartnerCategory";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	$assign_list["clsPartner"] = new Partner();

	#
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '&act=' . $act;
		if ($_POST['keyword'] != '' && $_POST['keyword'] != '') {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location:' . PCMS_URL . '/?mod=' . $mod . $link);
	}

	$cond = "1=1";
	#Filter By Keyword
	if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
		$cond .= " and slug like '%" . $core->replaceSpace($_GET['keyword']) . "%'";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$cond2 = $cond;
	if ($type_list == 'Trash') {
		$cond .= " and is_trash=1";
	}
	if ($type_list == 'Active') {
		$cond .= " and is_trash=0";
	}
	$orderBy = " order by order_no asc";
	#
	$allItem = $clsClassTable->getAll($cond . $orderBy);
	$assign_list["allItem"] = $allItem;

	unset($allItem);
	$assign_list["number_all"] = $clsClassTable->getAll($cond2) ? count($clsClassTable->getAll($cond2)) : 0;
	$assign_list["number_trash"] = $clsClassTable->getAll($cond2 . " and is_trash=1") ? count($clsClassTable->getAll($cond2 . " and is_trash=1")) : 0;

	//Action
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	if ($action == 'Trash') {
		$string = isset($_GET['partnercat_id']) ? ($_GET['partnercat_id']) : '';
		$partnercat_id = intval($core->decryptID($string));
		if ($string == '' && $partnercat_id == 0) {
			header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		if ($clsClassTable->updateOne($partnercat_id, "is_trash='1'")) {
			header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=TrashSuccess');
		}
	}

	if ($action == 'Restore') {
		$string = isset($_GET['partnercat_id']) ? ($_GET['partnercat_id']) : '';
		$partnercat_id = intval($core->decryptID($string));
		if ($string == '' && $partnercat_id == 0) {
			header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		if ($clsClassTable->updateOne($partnercat_id, "is_trash='0'")) {
			header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=RestoreSuccess');
		}
	}
	if ($action == 'Delete') {
		$string = isset($_GET['partnercat_id']) ? ($_GET['partnercat_id']) : '';
		$partnercat_id = intval($core->decryptID($string));
		if ($string == '' && $partnercat_id == 0) {
			header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		if ($clsClassTable->doDelete($partnercat_id)) {
			header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=DeleteSuccess');
		}
	}
	if ($action == 'move') {
		$string = isset($_GET['partnercat_id']) ? ($_GET['partnercat_id']) : '';
		$pvalTable = intval($core->decryptID($string));
		#
		if ($string == '' && $pvalTable == 0) {
			header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
			exit();
		}
		#
		$parent_id = isset($_GET['parent_id']) ? intval($_GET['parent_id']) : 0;
		$direct = isset($_GET['direct']) ? $_GET['direct'] : '';
		$one = $clsClassTable->getOne($pvalTable);
		$order_no = $one['order_no'];

		$pUrl = '&act=' . $act;
		$where = "is_trash=0";
		if ($parent_id > 0) {
			$where .= '&parent_id=' . $parent_id;
			$pUrl .= '&parent_id=' . $parent_id;
		}
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
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
	}
}
function default_ajUpdPosSortListPartnerCat()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#
	$order = $_POST['order'] ?? [];
	$clsISO->sortByData('PartnerCategory', $order);
}
function default_SitePartnerCategory()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsPartner = new Partner();
	$clsClassTable = new PartnerCategory();

	#
	$user_id = $core->_USER['user_id'];
	$partnercat_id = isset($_POST['partnercat_id']) ? intval($_POST['partnercat_id']) : 0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	//print_r($partnercat_id); die();
	#
	if ($tp == 'F') {
		$html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . ($partnercat_id == 0 ? $core->get_Lang('add') : $core->get_Lang('edit')) . ' ' . $core->get_Lang('partnercategory') . '</h3>
		</div>';
		$html .= '
			<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
				<div class="wrap">
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('title') . ' <font color="red">*</font></div>
						<div class="fieldarea">
							<input class="text full required" name="title" value="' . $clsClassTable->getOneField('title', $partnercat_id) . '" type="text" autocomplete="off" />
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('intro') . '</div>
						<div class="fieldarea">
							<textarea  id="textarea_partner_intro_editor_' . time() . '" class="textarea_partner_intro_editor" name="intro" style="width:100%">' . $clsClassTable->getOneField('intro', $partnercat_id) . '</textarea>
						</div>
					</div>
				</div>
			</form>
			<div class="modal-footer">
				<button type="button" partnercat_id="' . $partnercat_id . '" class="btn btn-primary btnClickToSubmitCategory">
					<i class="icon-ok icon-white"></i><span>' . $core->get_Lang('update') . '</span>
				</button>
				<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>Đóng lại</span> </button>		
			</div>';
		echo ($html);
		die();
	} elseif ($tp == 'S') {
		$titlePost = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
		$slugPost = $core->replaceSpace($titlePost);
		$introPost = isset($_POST['intro']) ? addslashes($_POST['intro']) : '';
		#
		if (intval($partnercat_id) == 0) {
			if ($clsClassTable->getAll("slug='$slugPost'") != '') {
				echo '_EXIST';
				die();
			} else {
				$fx = "$clsClassTable->pkey,user_id,user_id_update,title,slug,intro,order_no,reg_date,upd_date";
				$vx = "'" . $clsClassTable->getMaxID() . "','$user_id','$user_id','$titlePost','$slugPost','" . addslashes($introPost) . "'";
				$vx .= ",'" . $clsClassTable->getMaxOrderNo() . "','" . time() . "','" . time() . "'";
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
			if ($clsClassTable->getAll("slug='$slugPost' and partnercat_id <> '$partnercat_id'") != '') {
				echo '_EXIST';
				die();
			} else {
				$set = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',intro='" . addslashes($introPost) . "',upd_date='" . time() . "',user_id_update='" . $user_id . "'";
				if ($clsClassTable->updateOne($partnercat_id, $set)) {
					echo '_SUCCESS';
					die();
				} else {
					echo '_ERROR';
					die();
				}
			}
		}
	}
}


function default_edit()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $oneCommon;
	global $clsConfiguration, $extLang, $_LANG_ID, $clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Partner";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;

	$clsPartnerCategory = new PartnerCategory();
	$assign_list["clsPartnerCategory"] = $clsPartnerCategory;
	$partnercat_id = isset($_GET['partnercat_id']) ? intval($_GET['partnercat_id']) : 0;

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;
	#
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	/*$pvalTable = intval($core->decryptID($string));*/
	$assign_list['pvalTable'] = $pvalTable;
	$oneTable = $clsClassTable->getOne($pvalTable);
	$assign_list["oneTable"] = $oneTable;
	if ($pvalTable > 0) {
		$partnercat_id = $oneTable['cat_id'];
	}
	$assign_list["partnercat_id"] = $partnercat_id;
	#
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		if ($pvalTable == 0) {
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
			$field .= ',slug';
			$value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "'";

			#--Special Field: order_no
			$max_id = $clsClassTable->getMaxId();
			$field .= ',order_no,partner_id,reg_date,type';
			$value .= ",'1','" . $max_id . "','" . time() . "','" . $type . "'";

			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image = $_POST['isoman_url_image'];
			}
			if ($image != '' && $image != '0') {
				$field .= ",image";
				$value .= ",'" . addslashes($image) . "'";
			}
			#
			$listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no = $listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == 'EDIT') {
					if ($type == "BC") {
						header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&partner_id=' . $max_id . '&type=BC&message=UpdateSuccess');
					} else {
						header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&partner_id=' . $max_id . '&message=UpdateSuccess');
					}
				} else {
					if ($type == "BC") {
						header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=BC&message=UpdateSuccess');
					} else {
						header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
					}
				}
			} else {
				if ($type == "BC") {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=BC&message=insertFailed');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
				}
			}
		} else {
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
			#--Special Field: slug
			$value .= ",slug='" . $core->replaceSpace($_POST['iso-title']) . "'";
			$value .= ",upd_date='" . time() . "'";
			$value .= ",user_id_update='" . $user_id . "'";
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image = $_POST['isoman_url_image'];
			}
			if ($image != '' && $image != '0') {
				$value .= ",image='" . addslashes($image) . "'";
			}
			//print_r($value);die();
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$value .= ",is_online='" . $is_online . "'";
			if ($clsClassTable->updateOne($pvalTable, $value)) {
				if ($_POST['button'] == 'EDIT') {
					if ($type == "BC") {
						header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&partner_id=' . $pvalTable . '&type=BC&message=UpdateSuccess');
					} else {
						header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&partner_id=' . $pvalTable . '&message=UpdateSuccess');
					}
				} else {
					if ($type == "BC") {
						header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=BC&message=UpdateSuccess');
					} else {
						header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
					}
				}
			} else {
				if ($type == "BC") {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=BC&message=insertFailed');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
				}
			}
		}
	}
}
/*====================================================================================================*/
function default_new()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
	$clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Partner";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	if (isset($_POST['submit']) && $_POST['submit'] == 'Insert') {
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
		$field .= ',slug';
		$value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "'";

		#--Special Field: user_id


		#--Special Field: order_no
		$max_id = $clsClassTable->getMaxId();
		$field .= ',order_no,partner_id,reg_date';
		$value .= ",'1','" . $max_id . "','" . time() . "'";

		#--Special Field: image
		$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
		if (_isoman_use) {
			$image = $_POST['isoman_url_image'];
		}
		if ($image != '' && $image != '0') {
			$field .= ",image";
			$value .= ",'" . addslashes($image) . "'";
		}
		#
		$listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
		for ($i = 0; $i <= count($listTable); $i++) {
			$order_no = $listTable[$i]['order_no'] + 1;
			$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
		}
		if ($clsClassTable->insertOne($field, $value)) {
			if ($_POST['button'] == 'EDIT') {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&partner_id=' . $max_id . '&message=UpdateSuccess');
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
			}
		} else {

			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
		}
	}
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Partner";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;

	if ($pvalTable == "")
		if ($type == "BC") {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=BC&message=notPermission');
		} else {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
		}


	if ($clsClassTable->deleteOne($pvalTable)) {
		if ($type == "BC") {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=BC&message=DeleteSuccess');
		} else {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=DeleteSuccess');
		}
	}
}

function default_trash()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "Partner";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$one = $clsClassTable->getOne($pvalTable);

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;

	if ($pvalTable == "") {
		if ($type == "BC") {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=BC');
		} else {
			header('location: ' . PCMS_URL . '/?mod=' . $mod);
		}
	}


	$set = "is_trash='1'";
	if ($clsClassTable->updateOne($pvalTable, $set)) {
		if ($type == "BC") {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=BC&message=TrashSuccess');
		} else {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=TrashSuccess');
		}
	}
}
function default_restore()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "Partner";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$one = $clsClassTable->getOne($pvalTable);

	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;

	if ($pvalTable == "") {
		if ($type == 'BC') {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=BC');
		} else {
			header('location: ' . PCMS_URL . '/?mod=' . $mod);
		}
	}


	$set = "is_trash='0'";
	if ($clsClassTable->updateOne($pvalTable, $set)) {
		if ($type == 'BC') {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=BC&message=RestoreSuccess');
		} else {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=RestoreSuccess');
		}
	}
}
require_once(DIR_MODULES . '/partner/mod_default.php');
