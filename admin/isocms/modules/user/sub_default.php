<?php
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	#
	$user_group_id = isset($_GET['user_group_id']) && $_GET['user_group_id']!='' ? $_GET['user_group_id'] : 0;
	$assign_list["user_group_id"] = $user_group_id;
	#
	$clsUserGroup = new UserGroup(); $assign_list["clsUserGroup"] = $clsUserGroup;
	$oneUserGroup = $clsUserGroup->getOne($user_group_id);		
	$assign_list["oneUserGroup"] = $oneUserGroup;
	/*Get type of list*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	/**/
	$classTable = "User";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		if($_POST['email']!=''&&$_POST['email']!='testimonial title, intro'){
			$link .= '&email='.$_POST['email'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	#
	$cond = "1=1 and user_id NOT IN(1,2,36) and type<>'OKRS'";
	if($user_group_id!='0'){
		$cond .=" and user_group_id='$user_group_id'";
	}
	
	
	
	
	if($type_list=="Trash"){
		$cond .= " and is_trash=1";
	}
	else{
		$cond .= " and is_trash=0";
	}
	if(isset($_GET['email']) && !empty($_GET['email'])){
		$email = $_GET['email'];
//		print_r($email);die();
		$cond .= " and (user_name like '%".$email."%' or email like '%".$email."%')";
		$assign_list["email"] = $_GET['email'];
	}
	
	/*List all item*/
	$allItem = $clsClassTable->getAll($cond. " and user_name != '' order by $pkeyTable desc");
	$assign_list["allItem"] = $allItem;
	#
	$name_page = "Users";
	$assign_list["name_page"] = $name_page;
	
	$title_page = $name_page.' &laquo; ISOCMS';
	$assign_list["title_page"] = $title_page;
	
	$menu_current = 'userpanel';
	$assign_list["menu_current"] = $menu_current;
	
	$current_page = 'usergroup';
	$assign_list["current_page"] = $current_page;
	
	$assign_list["mod"] = $mod;
	$assign_list["act"] = $act;
}

function default_edit(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting,$core, $clsModule, $_loged_id;
	#
	$clsUserGroup = new UserGroup(); $assign_list["clsUserGroup"] = $clsUserGroup;
	$listUserGroup = $clsUserGroup->getAll("is_trash=0 order by user_group_id asc");		
	$assign_list["listUserGroup"] = $listUserGroup;
	#
	$classTable = "User";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsUser"] = $clsClassTable;
	#
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string)); 
	$assign_list['pvalTable'] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	
	
	#
	if($pvalTable==1 || ($string!='' && $pvalTable==0) || $oneItem['type']=='OKRS'){
		header('location:'.PCMS_URL.'/index.php?&mod='.$mod.'&message=notPermission');
	}
    
    
    
	#
	if(isset($_POST['submit']) && $_POST['submit'] =='Update'){		
		$user_name = $_POST['user_name'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$pass1Post = $_POST['pass1'];
		$pass2Post = $_POST['pass2'];
		$pass3Post = $_POST['pass3'];
		$disabled = isset($_POST['disabled'])?0:1;		
		$user_group_id = intval($_POST['user_group_id']);
		
		
		if(checkValidEmail($user_name)==0){
			$assign_list["err_user_name"] = 'invalid';
			return;
		} 
		$listUser=$clsClassTable->getAll("1=1 and (user_name='$user_name' || email='$user_name') and user_id <>'$pvalTable'",$clsClassTable->pkey);
		if(!empty($listUser)){
			$assign_list["err_user_name"] = 'exist';
			return;
		}
		#
		$ok3 = 1;		
		if($core->encrypt($pass3Post)!=$clsClassTable->getOneField('user_pass',$_loged_id)){
			$ok3 = 0;
			$assign_list["err_password"] = 'invalidadmin';
		}
		if($ok3==0) return;
		
		$assign_list["user_name"] = $user_name;
		$assign_list["first_name"] = $first_name;
		$assign_list["last_name"] = $last_name;
		$ok2 = 1;		
		if($pass1Post!=$pass2Post || ($pass1Post=='' && $pvalTable==0)){
			$ok2 = 0;
			$assign_list["err_password"] = 'invalid';
		}
		if($ok2==0) return;
		#
		if($pvalTable>0){
			$set = "user_name='".addslashes($user_name)."',email='".addslashes($user_name)."', first_name='".addslashes($first_name)."', last_name='".addslashes($last_name)."', user_group_id='$user_group_id',is_active='$disabled',is_super='".$_POST['is_super']."'";
			if($pass1Post!=''){
				$set .= ",user_pass='".$clsClassTable->encrypt($pass1Post)."'";
			}
			//echo($set);die();
			$clsClassTable->updateOne($pvalTable,$set);
			header('location: '.PCMS_URL.'/index.php?admin&mod='.$mod.'&message=updateSuccess');
		}
		else{
			$f = "user_id,user_name,email,first_name,last_name,user_group_id,is_active,user_pass,is_super";
			$v = "'".$clsClassTable->getMaxId()."','".addslashes($user_name)."','".addslashes($user_name)."','".addslashes($first_name)."','".addslashes($last_name)."','$user_group_id','$disabled','".$clsClassTable->encrypt($pass1Post)."','".$_POST['is_super']."'";
			$clsClassTable->insertOne($f,$v);
			header('location: '.PCMS_URL.'/index.php?admin&mod='.$mod.'&message=insertSuccess');
		}
	}
}
function checkValidEmail($email) {
	// First, we check that there's one @ symbol, and that the lengths are right
	if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
			return false;
		}
	}
	if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
 }
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act,$core, $clsModule;
	$user_id = $core->_USER['user_id'];
	
	$classTable = "User";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string)); 

	if($pvalTable == 0||$string==''||$pvalTable==1) 
		header('location: '.PCMS_URL.'/?admin&mod='.$mod);
	
	if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?admin&mod='.$mod.'&message=DeleteSuccess');
	}
	$assign_list["mod"] = $mod;
	$assign_list["act"] = $act;
}
require_once(DIR_MODULES . '/user/mod_default.php');
?>