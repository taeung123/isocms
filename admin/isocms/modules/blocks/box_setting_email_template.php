<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL & ~E_STRICT);
global $smarty, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
$smarty->assign('clsModule', $clsModule);

$user_id = $core->_USER['user_id'];
$clsUser = new User();
$assign_list["clsUser"] = $clsUser;
$smarty->assign('clsUser', $clsUser);

$clsEmailTemplateCat = new EmailTemplateCat();
$smarty->assign('clsEmailTemplateCat', $clsEmailTemplateCat);
$lstEmailTemplateCat = $clsEmailTemplateCat->getAll("is_trash=0 order by order_no ASC");
$smarty->assign('lstEmailTemplateCat', $lstEmailTemplateCat);

#
$clsProperty = new Property();
$smarty->assign('clsProperty', $clsProperty);
/*Get type of list news*/
$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
$smarty->assign('type_list', $type_list);

if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
    if ($_POST['email_cat_id'] != '') {
        $link .= '&email_cat_id=' . $_POST['email_cat_id'];
    }
    if ($_POST['keyword'] != '' && $_POST['keyword'] != 'city name') {
        $link .= '&keyword=' . $_POST['keyword'];
    }
    header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
}
/**/
$clsClassTable = new EmailTemplate();
$tableName = $clsClassTable->tbl;
$pkeyTable = $clsClassTable->pkey;
$smarty->assign('clsClassTable', $clsClassTable);
$smarty->assign('pkeyTable', $pkeyTable);
/*List all item*/

$cond = "1=1 and is_trash=0";
if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
    $slug = $core->replaceSpace($_GET['keyword']);
    $cond .= " and (title like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%')";
    $smarty->assign('keyword', $_GET['keyword']);
}
$email_cat_id = '';
if (isset($_GET['email_cat_id']) && $_GET['email_cat_id'] != '') {
    $email_cat_id = $_GET['email_cat_id'];
    $cond .= " and cat_id = '" . $email_cat_id . "'";
}
$smarty->assign('email_cat_id', $email_cat_id);

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


$where = "1=1 and is_trash=0";
$list_mod_page = "'module'";
if ($clsISO->getCheckActiveModulePackage($package_id, 'booking', 'booking_tour', 'default') || $clsISO->getCheckActiveModulePackage($package_id, 'booking', 'booking_hotel', 'default') || $clsISO->getCheckActiveModulePackage($package_id, 'booking', 'booking_cruise', 'default') || $clsISO->getCheckActiveModulePackage($package_id, 'booking', 'booking_tailor', 'default')) {
    $list_mod_page .= ",'booking'";
}
if ($clsISO->getCheckActiveModulePackage($package_id, 'feedback', 'default', 'default')) {
    $list_mod_page .= ",'feedback'";
}
if ($clsISO->getCheckActiveModulePackage($package_id, 'member', 'default', 'default')) {
    $list_mod_page .= ",'member'";
}
if ($clsISO->getCheckActiveModulePackage($package_id, 'subscription', 'default', 'default')) {
    $list_mod_page .= ",'subscription'";
}
if ($clsISO->getCheckActiveModulePackage($package_id, 'reviews', 'default', 'default')) {
    $list_mod_page .= ",'reviews'";
}
if ($clsISO->getCheckActiveModulePackage($package_id, 'agent', 'default', 'default')) {
    $list_mod_page .= ",'agent'";
}
if (!empty($list_mod_page)) {
    $where .= " and mod_page IN ($list_mod_page)";
}
//print_r($where); die();

if (!empty($email_cat_id)) {
    $where .= " and email_template_cat_id = '$email_cat_id'";
}
$lstCat = $clsEmailTemplateCat->getAll($where . " order by email_template_cat_id asc");
$smarty->assign('lstCat', $lstCat);
