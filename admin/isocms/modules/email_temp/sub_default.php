<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;

	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '';
		if ($_POST['iso-email_cat_id'] != '') {
			$link .= '&email_cat_id=' . $_POST['iso-email_cat_id'];
		}
		if ($_POST['keyword'] != '' && $_POST['keyword'] != 'city name') {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	/**/
	$classTable = "EmailTemp";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	/*List all item*/

	$cond = "1=1 and is_trash=0";
	if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
		$slug = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (title like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%')";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	if (isset($_GET['email_cat_id']) && $_GET['email_cat_id'] != '') {
		$email_cat_id = $_GET['email_cat_id'];
		$cond .= " and email_cat_id = '" . $email_cat_id . "'";
		$assign_list["email_cat_id"] = $_GET['email_cat_id'];
	}
	$cond2 = $cond;
	if ($type_list == 'Active') {
		$cond .= " and is_trash=0";
	}
	if ($type_list == 'Trash') {
		$cond .= " and is_trash=1";
	}
	$orderBy = " email_template_id asc";
	#
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


	$clsEmailTemplateCat = new EmailTemplateCat();
	$assign_list["clsEmailTemplateCat"] = $clsEmailTemplateCat;
	$where = "1=1";
	if (!empty($email_template_cat_id)) {
		$where .= " and email_template_cat_id = '$email_template_cat_id'";
	}
	$lstCat = $clsEmailTemplateCat->getAll($where . " order by email_template_cat_id asc");
	$assign_list["lstCat"] = $lstCat;

	//print_r($lstCat);die();
	#-------End Page Divide-----------------------------------------------------------
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy); //print_r($cond." order by ".$orderBy.$limit);die();
	$assign_list["allItem"] = $allItem;
	#
	$allTrash =  $clsClassTable->getAll("is_trash=1 and " . $cond2);
	$assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
	#
	$allUnTrash =  $clsClassTable->getAll("is_trash=0 and " . $cond2);
	$assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
	#
	$allAll =  $clsClassTable->getAll($cond2);
	$assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
}
function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsEmailTemplateCat = new EmailTemplateCat();
	$assign_list["clsEmailTemplateCat"] = $clsEmailTemplateCat;
	$lstEmailTemplateCat = $clsEmailTemplateCat->getAll("is_trash=0 order by order_no ASC");
	$assign_list["lstEmailTemplateCat"] = $lstEmailTemplateCat;
	#
	$classTable = "EmailTemp";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;




	#
	$string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	$pvalTable = $core->decryptID($string);
	if ($string != '' && $pvalTable == 0)
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

	$assign_list['pvalTable'] = $pvalTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;


	$clsEmailTemp_Traslation = new EmailTemp_Traslation();
	$assign_list["clsEmailTemp_Traslation"] = $clsEmailTemp_Traslation;
	$language_id = 2;
	$allItem = $clsEmailTemp_Traslation->getAll("email_temp_id='$pvalTable' and language_id='$language_id'");
	$email_temp_traslation_id = $allItem[0]['email_temp_traslation_id'];
	$assign_list["email_temp_traslation_id"] = $email_temp_traslation_id;
	$assign_list["oneEmailTemp_Traslation"] = $clsEmailTemp_Traslation->getOne($email_temp_traslation_id);

	#
	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#
	$clsForm->addInputTextArea("full", "content", "", "content", 255, 25, 20, 1, "style='width:100%'");
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		if ($pvalTable > 0) {
			$set = "";
			$firstAdd = 0;

			// Time update.
			$set .= "title='" . $_POST['iso-title'] . "'";
			$set .= ",upd_date='" . time() . "'";
			$set .= ",user_id_update='$user_id'";


			$arr_content_email[$_LANG_ID] = array();
			$arr_content_email[$_LANG_ID]['title'] = $_POST['iso-title'];
			$arr_content_email[$_LANG_ID]['fromname'] = $_POST['iso-fromname'];
			$arr_content_email[$_LANG_ID]['fromemail'] = $_POST['iso-fromemail'];
			$arr_content_email[$_LANG_ID]['copyto'] = $_POST['iso-copyto'];
			$arr_content_email[$_LANG_ID]['subject'] = $_POST['iso-subject'];
			$arr_content_email[$_LANG_ID]['content'] = $_POST['iso-content'];


			if ($oneItem['email_content_setting'] != '') {
				$email_content_setting_item = unserialize($oneItem['email_content_setting']);
			}

			if ($email_content_setting_item != '') {
				$arr_content_email_item_update = array_merge($email_content_setting_item, $arr_content_email);
			} else {
				$arr_content_email_item_update = $arr_content_email;
			}
			$set .= ",email_content_setting='" . serialize($arr_content_email_item_update) . "'";



			//print_r($set); die();
			if ($clsClassTable->updateOne($pvalTable, $set)) {
				if ($email_temp_traslation_id == '') {
					$clsEmailTemp_Traslation->insertOne("title,fromname,fromemail,copyto,subject,content,email_temp_traslation_id", "'" . $_POST['iso-title'] . "','" . $_POST['iso-fromname'] . "','" . $_POST['iso-fromemail'] . "','" . $_POST['iso-copyto'] . "','" . $_POST['iso-subject'] . "','" . $_POST['iso-content'] . "','" . $clsEmailTemp_Traslation->getMaxId() . "'");
				} else {
					$clsEmailTemp_Traslation->updateOne($email_temp_traslation_id, "title='" . addslashes($_POST['iso-title']) . "',fromname='" . addslashes($_POST['iso-fromname']) . "',fromemail='" . addslashes($_POST['iso-fromemail']) . "',copyto='" . addslashes($_POST['iso-copyto']) . "',subject='" . addslashes($_POST['iso-subject']) . "',content='" . addslashes($_POST['iso-content']) . "'");
				}
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&email_temp_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess');
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&email_temp_id=' . $core->encryptID($pvalTable) . '&message=updateFailed');
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
			$field .= ",$pkeyTable,user_id,reg_date";
			$value .= ",'$max_id','$user_id','" . time() . "'";

			$arr_content_email[$_LANG_ID] = array();
			$arr_content_email[$_LANG_ID]['title'] = $_POST['iso-title'];
			$arr_content_email[$_LANG_ID]['fromname'] = $_POST['iso-fromname'];
			$arr_content_email[$_LANG_ID]['fromemail'] = $_POST['iso-fromemail'];
			$arr_content_email[$_LANG_ID]['copyto'] = $_POST['iso-copyto'];
			$arr_content_email[$_LANG_ID]['subject'] = $_POST['iso-subject'];
			$arr_content_email[$_LANG_ID]['content'] = $_POST['iso-content'];


			if ($oneItem['email_content_setting'] != '') {
				$email_content_setting_item = unserialize($oneItem['email_content_setting']);
			}

			if ($email_content_setting_item != '') {
				$arr_content_email_item_update = array_merge($email_content_setting_item, $arr_content_email);
			} else {
				$arr_content_email_item_update = $arr_content_email;
			}
			$field .= ",email_content_setting";
			$value .= ",'" . serialize($arr_content_email_item_update) . "'";

			#
			//print_r($field.$value); die();
			if ($clsClassTable->insertOne($field, $value)) {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&email_temp_id=' . $core->encryptID($max_id) . '&message=InsertSuccess');
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&email_temp_id=' . $core->encryptID($max_id) . '&message=InsertFailed');
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
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
	$assign_list["country_id"] = $country_id;
	if ($country_id == '') {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
		die();
	}
	#
	$classTable = "EmailTemp";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&country_id=' . $country_id . '&message=notPermission');

	if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&country_id=' . $country_id . '&message=TrashSuccess');
	}
}
function default_restore()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
	$assign_list["country_id"] = $country_id;
	if ($country_id == '') {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
		die();
	}
	#
	$classTable = "EmailTemp";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";

	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&country_id=' . $country_id . '&message=notPermission');
	if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&country_id=' . $country_id . '&message=RestoreSuccess');
	}
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "EmailTemp";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));

	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

	if ($clsClassTable->deleteOne($pvalTable)) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=DeleteSuccess');
	}
}
