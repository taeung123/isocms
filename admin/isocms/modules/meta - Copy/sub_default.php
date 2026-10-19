<?php
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	/**/
	$classTable = "Meta";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = '';
		if($_POST['keyword']!=''&&$_POST['keyword']!='nhập link, title hoặc keyword'){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/index.php?mod='.$mod.$link);
	}
	#
	$allResult = $clsClassTable->getAll("config_link like 'http:%'");
	for($i=0;$i<count($allResult);$i++){
		$config_link = str_replace('http://trippy.vietiso.vn/','/',$allResult[$i]['config_link']);
		$config_link = str_replace('http://beta.trippy.vn/','/',$config_link);
		$config_link = str_replace(DOMAIN_NAME,'',$config_link);
		$clsClassTable->updateOne($allResult[$i]['meta_id'],"config_link='$config_link'"); 
	}

	#
	
	/*List all item*/
	$cond = "1=1";
	$orderBy = " config_link ASC";
	#Filter By Keyword
	if(isset($_GET['keyword'])){
		$short_keyword  = str_replace(DOMAIN_NAME,'',$_GET['keyword']);
		if(strpos($short_keyword,'|')!==false){
			$short_keyword = ltrim($short_keyword,'|');
			$short_keyword = rtrim($short_keyword,'|');
			$cond .= " and (config_value_title='$short_keyword' or config_link='$short_keyword')";
		}else{
			$cond .= " and (config_value_title like '%".$_GET['keyword']."%' or config_value_intro like '%".$_GET['keyword']."%' or config_value_keyword like '%".$_GET['keyword']."%' or config_link like '%".$_GET['keyword']."%')";
		}
		$assign_list["keyword"] = $_GET['keyword'];
	}
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 40;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	

	#-------End Page Divide-----------------------------------------------------------
	$allItem = $clsClassTable->getAll($cond." order by ".$orderBy.$limit);
	$assign_list["allItem"] = $allItem;
}
function default_edit(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Meta";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	
	
	$number_word_title=$clsISO->getCountMetaWord($clsClassTable->getMetaTitle($pvalTable));
	$assign_list['number_word_title'] = $number_word_title;
	$number_word_description=$clsISO->getCountMetaWord($clsClassTable->getMetaDescription($pvalTable));
	$assign_list['number_word_description'] = $number_word_description;
	//print_r($abc);die();
	
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	#
	if($string!='' && $pvalTable==0){
		header('location:'.PCMS_URL.'/index.php?&mod='.$mod.'&message=notPermission');
	}
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	
	if(isset($_POST['submit']) && $_POST['submit'] =='Update'){
		if($pvalTable==0){
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
			#--Validate config_link Duplicate
			$config_link_Post = $_POST['config_link'];
			$config_link_Post = str_replace(DOMAIN_NAME,'',$config_link_Post);
			if($clsClassTable->countItem("config_link='$config_link_Post'") > 0){
				header('location: '.PCMS_URL.'/?mod='.$mod.'&message=NotPermission');
				die();
			}
			$field .= ',config_link';
			$value .= ",'".addslashes($config_link_Post)."'";
			
			#--Validate config_value_title Duplicate
			$config_value_title_Post = $_POST['config_value_title'];
			if($clsClassTable->countItem("config_value_title='$config_value_title_Post'") > 0){
				header('location: '.PCMS_URL.'/?mod='.$mod.'&message=NotPermission');
				die();
			}
			$field .= ',config_value_title';
			$value .= ",'".addslashes($config_value_title_Post)."'";
			$field .= ',user_id,reg_date,upd_date';
			$value .= ",'$user_id','".time()."','".time()."'";
			#--Special Field: image
			$image     = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if (_isoman_use) {
				$image     = $_POST['isoman_url_image'];
			}
			if ($image != '' && $image != '0') {
				$field .= ',image';
				$value .= ",'" . addslashes($image) . "'";
			}
			
			$meta_id = $clsClassTable->getMaxId();
			$field .= ',meta_id';
			$value .= ",'".$meta_id."'";
			
			
			#--End Validate config_link Duplicate
			if($clsClassTable->insertOne($field,$value)){
				if($_POST['button']=='_LIST'){
					header('location: '.PCMS_URL.'/?mod='.$mod.'&message=InsertSuccess');
				}
				if($_POST['button']=='_EDIT'){
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&meta_id='.$core->encryptID($meta_id).'&&message=InsertSuccess');
				}
			}else{
				header('location: '.PCMS_URL.'/?mod='.$mod.'&message=insertFailed');
			}
		}else{
			$value = ""; $firstAdd = 0;
			foreach($_POST as $key=>$val){
				$tmp = explode('-',$key);
				if($tmp[0]=='iso'){
					if($firstAdd==0){
						$value .= $tmp[1]."='".addslashes($val)."'";
						$firstAdd = 1;
					}
					else{
						$value .= ",".$tmp[1]."='".addslashes($val)."'";
					}
				}
			}
			
			#--Validate config_link Duplicate
			$config_link_Post = $_POST['config_link'];
			$config_link_Post = str_replace(DOMAIN_NAME,'',$config_link_Post);
			
			if($clsClassTable->getAll("meta_id<>'$pvalTable' and config_link='$config_link_Post'")!=''){
				
				header('location: '.PCMS_URL.'/?mod='.$mod.'&message=NotPermission');
				die();
			}
			
			$value .= ",config_link='".addslashes($config_link_Post)."'";
			#
			#--Validate config_value_title Duplicate
			$config_value_title_Post = $_POST['config_value_title'];
			if($clsClassTable->getAll("config_value_title='$config_value_title_Post' and meta_id<>'$pvalTable'")!=''){
				header('location: '.PCMS_URL.'/?mod='.$mod.'&message=insertFailed');
				die();
			}
			$value .= ",config_value_title='".addslashes($config_value_title_Post)."'";
			$value .= ",upd_date='".time()."'";
			$value .= ",user_update_id='".$user_id."'";
			
			     #--Special Field: image
			$image     = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			
			if (_isoman_use) {
				$image     = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if ($image != '' && $image != '0') {
				$value .= ",image='" . addslashes($image) . "'";
			}
		
			#
			if($clsClassTable->updateOne($pvalTable,$value)){
				if($_POST['button']=='_LIST'){
					header('location: '.PCMS_URL.'/?mod='.$mod.'&message=UpdateSuccess');
				}
				if($_POST['button']=='_EDIT'){
					$max_id = $clsClassTable->getMaxId()-1;
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&meta_id='.$core->encryptID($pvalTable).'&&message=UpdateSuccess');
				}
			}else{
				header('location: '.PCMS_URL.'/?mod='.$mod.'&message=updateFailed');
			}
		}
	}
}
function default_trash(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Meta";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	
	$param_url = '';
	
	if($pvalTable == "")
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=notPermission');

	if($clsClassTable->updateOne($pvalTable,"is_trash='1'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=TrashSuccess');
	}
}
function default_restore(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Meta";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	
	$param_url = '';
	
	if($pvalTable == "")
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=notPermission');

	if($clsClassTable->updateOne($pvalTable,"is_trash='0'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=RestoreSuccess');
	}
}
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Meta";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string)); 
	#
	if($string!='' && $pvalTable==0){
		header('location:'.PCMS_URL.'/index.php?&mod='.$mod.'&message=notPermission');
	}
	#
	if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=DeleteSuccess');
	}
}
function default_setting(){
	global $assign_list, $core,$clsConfiguration,$dbconn,$mod,$act;
	#
	if(isset($_POST['submit']) && $_POST['submit']='UpdateConfiguration'){
		foreach($_POST as $key=>$val){
			$tmp = explode('-',$key);
			if($tmp[0]=='iso'){
				$clsConfiguration->updateValue($tmp[1],$val);
			}
		}
		header('location:'.PCMS_URL.'?mod='.$mod.'&act='.$act.'&message=updateSuccess');
	}
}
?>