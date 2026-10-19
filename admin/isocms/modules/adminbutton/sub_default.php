<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	#
	$classTable = "AdminButton";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["pkeyTable"] = $pkeyTable;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$cond = "1=1";
	if (isset($_GET['_type'])) {
		$cond .= " and _type='" . $_GET['_type'] . "'";
		$assign_list["_type"] = $_GET['_type'];
		if ($_GET['_type'] != '_TOP' && $_GET['_type'] != '_LEFT' && $_GET['_type'] != '_SETTING') {
			$cond .= ' and is_group=1';
		} else {
			$cond .= ' and parent_id=0';
		}
	} else {
		$cond .= " and is_group=1 and _type='_HOME'";
		$assign_list["_type"] = '_HOME';
	}
	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
	$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
	$start_limit = ($currentPage - 1) * $recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";

	$totalRecord = $clsClassTable->getAll($cond) ? count($clsClassTable->getAll($cond)) : 0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	/*List all item*/
	$allItem = $clsClassTable->getAll($cond . " order by order_no asc");
	$assign_list["allItem"] = $allItem;
}
function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $oneSetting, $core, $clsModule, $_loged_id;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
	#
	$classTable = "AdminButton";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;

	$clsUserGroup = new UserGroup();
	$assign_list["clsUserGroup"] = $clsUserGroup;
	$listUserGroup = $clsUserGroup->getAll();
	$assign_list["listUserGroup"] = $listUserGroup;
	unset($listUserGroup);

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	if ($string != '' && $pvalTable == 0) {
		header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
	}
	$assign_list['pvalTable'] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;

	$permiss_access = '';
	if (isset($_GET['_type'])) {
		$_type = $_GET['_type'];
		$assign_list["_type"] = $_GET['_type'];
	}
	if ($pvalTable > 0) {
		$_type = $oneItem['_type'];
		$permiss_access = $oneItem['permiss_access'];
		$package_id = $oneItem['package_id'];
		$package_check_id = $oneItem['package_id'];
		$package_check_id = unserialize($package_check_id);
	}
	$assign_list["listParent"] = $clsClassTable->getAll("is_trash=0 and _type='$_type' and is_group=1 order by order_no asc");
	$assign_list["permiss_access"] = $permiss_access;
	$assign_list["package_check_id"] = $package_check_id;

	#
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		$title = $_POST['title'];
		$assign_list["title"] = $title;
		$order_no = $_POST['order_no'];
		$assign_list["order_no"] = $order_no;
		$url_page = str_replace(PCMS_URL . '/?', '', $_POST['url_page']);
		$url_page = str_replace(PCMS_URL . '/index.php?', '', $url_page);
		$assign_list["url_page"] = $url_page;
		if ($pvalTable > 0) {
			$set = "title_page='" . addslashes($title) . "'";
			$set .= ",order_no='" . addslashes($order_no) . "'";
			$set .= ",url_page='" . addslashes($url_page) . "'";
			$set .= ",image='" . addslashes($_POST['image']) . "'";
			$set .= ",mod_page='" . addslashes($_POST['mod_page']) . "'";
			$set .= ",act_page='" . addslashes($_POST['act_page']) . "'";
			$set .= ",_type='" . addslashes($_POST['_type']) . "'";
			$set .= ",is_group='" . intval($_POST['is_group']) . "'";
			if ($_POST['is_group'] == 0) {
				$set .= ",parent_id='" . intval($_POST['parent_id']) . "'";
			}
			$set .= ",class_page='" . $_POST['class_page'] . "'";
			$set .= ",class_iconpage='" . $_POST['class_iconpage'] . "'";
			$set .= ",dev_access='" . intval($_POST['dev_access']) . "'";
			$permiss_access = $clsISO->makeSlashListFromArray($_POST['permiss']);
			$set .= ",permiss_access='" . $permiss_access . "'";

			$package_id = $_POST['package_id'] ? serialize($_POST['package_id']) : '';
			$set .= ",package_id='" . $package_id . "'";

			$set .= ",CONFIGURATION_KEY='" . addslashes($_POST['configuration_key']) . "'";
			#
			$clsClassTable->updateOne($pvalTable, $set);
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=updateSuccess&_type=' . $_POST['_type']);
		} else {
			$f = "title_page,is_active,order_no,url_page,image,mod_page,act_page,_type,is_group,parent_id,class_page,class_iconpage,dev_access";
			$v = "'" . addslashes($title) . "','1','" . addslashes($order_no) . "','" . addslashes($url_page) . "','" . addslashes($_POST['image']) . "'
				,'" . addslashes($_POST['mod_page']) . "'
				,'" . addslashes($_POST['act_page']) . "'
				,'" . addslashes($_POST['_type']) . "'
				,'" . intval($_POST['is_group']) . "'
				,'" . intval($_POST['parent_id']) . "'
				,'" . addslashes($_POST['class_page']) . "'
				,'" . addslashes($_POST['class_iconpage']) . "'
				,'" . intval(addslashes($_POST['dev_access'])) . "'
				";
			#
			$permiss_access = $clsISO->makeSlashListFromArray($_POST['permiss']);
			$f .= ",permiss_access";
			$v .= ",'$permiss_access'";

			$package_id = $_POST['package_id'] ? serialize($_POST['package_id']) : '';
			$f .= ",package_id";
			$v .= ",'$package_id'";

			$f .= ",CONFIGURATION_KEY";
			$v .= ",'" . addslashes($_POST['configuration_key']) . "'";
			#


			if ($clsClassTable->insertOne($f, $v)) {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertSuccess&_type=' . $_POST['_type']);
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed&_type=' . $_POST['_type']);
			}
		}
	}
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $core, $clsModule;
	$user_id = $core->_USER['user_id'];

	$classTable = "AdminButton";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));

	if (isset($_GET['_type'])) {
		$_type = $_GET['_type'];
		$assign_list["_type"] = $_GET['_type'];
	}

	if ($pvalTable == 0 || $string == '')
		header('location: ' . PCMS_URL . '/?admin&mod=' . $mod);

	if ($clsClassTable->doDelete($pvalTable)) {
		header('location: ' . PCMS_URL . '/?admin&mod=' . $mod . '&message=DeleteSuccess&_type=' . $_GET['_type']);
	}
}
function default_ajUpdPosSortAdminbutton()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsAdminButton = new AdminButton();
	$order = $_POST['order'];
	//	print_r($order);die();
	$list_order = [];
	foreach ($order as $key => $val) {
		$tour = $clsAdminButton->getOne($val, 'order_no');
		$list_order[] = $tour['order_no'];
	}

	rsort($list_order);

	foreach ($order as $key => $val) {
		$clsAdminButton->updateOne($val, 'order_no=' . $list_order[$key]);
	}
}
