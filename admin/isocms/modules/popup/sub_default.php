<?php
function default_default() {

    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Popup name') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    $classTable = "Popup";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey; 
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
	#
    $cond = "1='1'";
  $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and (title like '%" . $_GET['keyword'] . "%' or title like '%" . $slug . "%') ";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    #
    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    } elseif ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no ASC";

    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy);
	//print_r($cond . " order by " . $orderBy); die();
    $assign_list["allItem"] = $allItem;
    #
    $allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2);
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2);
    $assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
    #
    $allAll = $clsClassTable->getAll($cond2);
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
}
function default_ajUpdPosSortPopup(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsPopup = new Popup();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key+1);
		$clsPopup->updateOne($val,"order_no='".$key."'");	
	}
}
function default_edit() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO,$clsConfiguration;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Popup";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
	
	
	
	#


	$string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
    $pvalTable = intval($core->decryptID($_GET[$pkeyTable]));
	if($string != '' && $pvalTable==0){
		header('Location:'.BASE_URL.'/index.php?mod='.$mod.'&message=NotPermission');
		exit();
	}
	#
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;
    $oneTable = $clsClassTable->getOne($pvalTable);
    $assign_list['oneTable'] = $oneTable;
	
	
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("full",'intro', "", 'intro', 255, 25, 5, 1,  "style='width:100%'");
	#
    if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
        if ($pvalTable > 0) {
			$set = ""; $firstAdd = 0;
			foreach($_POST as $key=>$val){
				$tmp = explode('-',$key);
				if($tmp[0]=='iso'){
					if($firstAdd==0){
						$set .= $tmp[1]."='".addslashes($val)."'";
						$firstAdd = 1;
					}else{
						$set .= ",".$tmp[1]."='".addslashes($val)."'";
					}
				}
			}
			#
			$set .= ",upd_date='".time()."'";
			
			#--Special Field: image
			$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			if($image!=''&&$image!='0'){
				$set .= ",image='".addslashes($image)."'";
			}	
            #
            if($clsClassTable->updateOne($pvalTable,$set)) {
				if ($_POST['button'] == '_EDIT') {
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&popup_id='.$core->encryptID($pvalTable).'&message=updateSuccess');
                } else {
                    header('location: '.PCMS_URL.'/?mod='.$mod.'&message=updateSuccess');
                }
            } else {
                header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&message=updateFailed');
            }
        }else{
			$listTable=$clsClassTable->getAll("1=1", $clsClassTable->pkey.",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no=$listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey],"order_no='".$order_no."'");
			}
			$value = ""; $firstAdd = 0; $field = "";
			foreach($_POST as $key=>$val){
				$tmp = explode('-',$key);
				if($tmp[0]=='iso'){
					if($firstAdd==0){
						$field .= $tmp[1];
						$value .= "'".addslashes($val)."'";
						$firstAdd = 1;
					}
					else{
						$field .= ','.$tmp[1];
						$value .= ",'".addslashes($val)."'";
					}
				}
			}
			$max_ID = $clsClassTable->getMaxId();
			$field .= ",user_id,reg_date,upd_date,popup_id,order_no";
			$value .= ",'".$user_id."','".time()."','".time()."'";
			$value .= ", '".$max_ID."','1'";
			#--Special Field: image
			$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			if($image!=''&&$image!='0'){
				$field .= ',image';
				$value .= ",'".addslashes($image)."'";
			}

            #
			//print_r($field.'xxx'.$value); die();
			if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&popup_id='.$core->encryptID($max_ID).'&message=insertSuccess');
                } else {
                    header('location: '.PCMS_URL.'/?mod='.$mod.'&message=insertSuccess');
                }
            } else {
                header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&message=insertFailed');
            }
        }
    }
}
function default_trash() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Popup";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
	#

	if ($pvalTable == "")
		 header('location: ' . PCMS_URL . '/?mod='.$mod.'&message=notPermission');
	#
	if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
		 header('location: ' . PCMS_URL . '/?mod='.$mod.'&message=TrashSuccess');
	}
}
function default_restore() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Popup";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
	#

	if ($pvalTable == "")
		 header('location: ' . PCMS_URL . '/?mod='.$mod.'&message=notPermission');
	   
    if($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location: ' . PCMS_URL . '/?mod='.$mod.'&message=TrashSuccess');
    }
}
function default_delete() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Popup";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
	#

    if ($string = '' && $pvalTable == 0)
        header('location: ' . PCMS_URL . '/?mod='.$mod.'&message=notPermission');
	#
	if ($clsClassTable->doDelete($pvalTable)) {
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=TrashSuccess');
	}
}

function default_ajDeleteMultiItem() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
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

?>