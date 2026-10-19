<?php
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $user_id, $core, $clsModule;	
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	/**/
	$classTable = "UserGroup";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsUserGroup"] = $clsClassTable;
	#
	$cond ="1=1 and user_group_id <>5";
	if($type_list=="Trash"){
		$cond .= " and is_trash=1";
	}
	else{
		$cond .= " and is_trash=0";
	}	
	/*List all item*/
	$allItem = $clsClassTable->getAll($cond. " order by $pkeyTable asc");
	$assign_list["allItem"] = $allItem;
}
function default_edit(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	$user_id = $core->_USER['user_id'];
	
	$classTable = "UserGroup";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsUserGroup"] = $clsClassTable;
	
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string)); 
	$assign_list['pvalTable'] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list['oneItem'] = $oneItem;
	$clsISO = new ISO();
	$listModule = $clsISO->getListModule();
	$assign_list['listModule'] = $listModule;
	//print_r(count($listModule)); die();
	
	if($string != '' && $pvalTable==0){
		header('location: '.PCMS_URL.'/index.php?mod='.$mod);	
	}
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("",'intro', "", $core->get_Lang("intro"), 255, 25, 3, 1,  "style='width:100%'");
	#===============================
	if(isset($_POST['submit']) && $_POST['submit'] =='Update'){
		if($pvalTable > 0){
			$namePost = addslashes($_POST['name']);	
			$value = "name='".$namePost."'";
			$clsISO = new ISO();
			$list_access_action = $clsISO->makeSlashListFromArrayRoot($_POST['listModule']);
			$value .= ",list_access_action='".$list_access_action."'"; 
			if($clsClassTable->updateOne($pvalTable,$value)){ 
				header('location: '.PCMS_URL.'/index.php?mod='.$mod.'&message=updateSuccess');			
			} 
		}else{
			$namePost = addslashes($_POST['name']);	
			if($clsClassTable->countItem("name_slug='".$core->replaceSpace($namePost)."'") > 0){
				header('location:'.PCMS_URL.'/index.php?mod='.$mod.'&message=NotPermission');
				exit();
			}
			#
			$field = "name";
			$value = "'".$namePost."'";
			$field .= ",name_slug";
			$value .= ",'".$core->replaceSpace($namePost)."'";
			$field .= ",order_no";
			$value .= ",'".$clsClassTable->getMaxOrderNo()."'";
			$clsISO = new ISO();
			$list_access_action = $clsISO->makeSlashListFromArrayRoot($_POST['listModule']);
			$field .= ",list_access_action";
			$value .= ",'".$list_access_action."'"; 
			$field .= ",".$clsClassTable->pkey;
			$max_id = $clsClassTable->getMaxId();
			$value .= ",'".$max_id."'"; 
			//print_r($field); die();
			if($clsClassTable->insertOne($field,$value)){ 
				header('location: '.PCMS_URL.'/index.php?mod='.$mod.'&message=insertSuccess');			
			} 
		}
		
	}
}
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "UserGroup";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string)); 

	if($pvalTable == 0||$string==''||$pvalTable==1) 
		header('location: '.PCMS_URL.'/?mod='.$mod);
	if($clsClassTable->deleteOne($pvalTable)){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&message=DeleteSuccess');
		}	
}
?>