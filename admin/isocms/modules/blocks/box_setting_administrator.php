<?php
global $smarty, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
global $core, $clsModule, $clsButtonNav,$oneSetting;
#
$user_group_id = isset($_GET['user_group_id']) && $_GET['user_group_id']!='' ? $_GET['user_group_id'] : 0;
$smarty->assign('user_group_id', $user_group_id);
#
$clsUserGroup = new UserGroup(); $assign_list["clsUserGroup"] = $clsUserGroup;
$oneUserGroup = $clsUserGroup->getOne($user_group_id);
$smarty->assign('oneUserGroup', $oneUserGroup);

/*Get type of list*/
$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
$smarty->assign('type_list', $type_list);
/**/
$classTable = "User";
$clsClassTable = new $classTable;
$tableName = $clsClassTable->tbl;
$pkeyTable = $clsClassTable->pkey ;
$smarty->assign('clsClassTable', $clsClassTable);
$smarty->assign('pkeyTable', $pkeyTable);

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
    $smarty->assign('email', $email);

}

/*List all item*/
$allItem = $clsClassTable->getAll($cond. " and user_name != '' order by $pkeyTable desc");
$smarty->assign('allItem', $allItem);

#
$name_page = "Users";
$smarty->assign('name_page', $name_page);

$title_page = $name_page.' &laquo; ISOCMS';
$smarty->assign('title_page', $title_page);

$menu_current = 'userpanel';
$smarty->assign('menu_current', $menu_current);

$current_page = 'usergroup';
$smarty->assign('current_page', $current_page);

$smarty->assign('mod', $mod);
$smarty->assign('act', $act);
