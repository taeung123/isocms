<?php
global $smarty, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $user_id, $core, $clsModule;

$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
$smarty->assign('type_list', $type_list);
/**/
$classTable = "UserGroup";
$clsClassTable = new $classTable;
$tableName = $clsClassTable->tbl;
$pkeyTable = $clsClassTable->pkey ;
$smarty->assign('clsUserGroup', $clsClassTable);

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
$smarty->assign('allItem', $allItem);
