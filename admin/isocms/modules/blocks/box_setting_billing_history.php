<?php
global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
global $core, $clsModule, $clsButtonNav, $clsConfiguration;
#
$smarty->assign('clsModule', $clsModule);

$user_id = $core->_USER['user_id'];
/*Get type of list news*/
$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
$smarty->assign('type_list', $type_list);

#
$status = isset($_GET['status']) ? $_GET['status'] : '';
$smarty->assign('status', $status);
#

if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
    if (isset($_POST['status']) && $_POST['status'] != '') {
        $link .= '&status=' . $_POST['status'];
    }
    if ($_POST['bill_code'] != '' && $_POST['bill_code'] != '') {
        $link .= '&code=' . $_POST['bill_code'];
    }
    header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
}
if (isset($_POST['Export']) && $_POST['Export'] == 'Export') {
    default_export_billing_history();
    /*$link= '?mod=billing&act=export&type=excel_billing';
    if($status!=''){
        $link .= '&status='.$status.'';
    }
    vnSessionSetVar('from_date', $_POST['from_date']);
    vnSessionSetVar('to_date', $_POST['to_date']);
    header('location: '.PCMS_URL.'/'.$link);*/
}
/**/
$clsBooking = new Booking();
$smarty->assign('clsBooking', $clsBooking);
#
$classTable = "BillingHistory";
$clsClassTable = new $classTable;
$tableName = $clsClassTable->tbl;
$pkeyTable = $clsClassTable->pkey;
$smarty->assign('clsClassTable', $clsClassTable);
$smarty->assign('pkeyTable', $pkeyTable);

#
$cond = '1=1';
if ($status != '') {
    $cond .= " and status='$status'";
}
#Filter By Keyword
if (isset($_GET['code']) && !empty($_GET['code'])) {
    $keyword = $core->replaceSpace($_GET['keyword']);
    $cond .= " and bill_code LIKE '%" . $_GET['code'] . "%'";
    $code = isset($_GET['code']) ? $_GET['code'] : '';
    $smarty->assign('code', $code);
}
#
if ($type_list == 'Reminding') {
    $cond .= " and status=0";
} elseif ($type_list == 'Offered') {
    $cond .= " and status=1";
} elseif ($type_list == 'Reviewed') {
    $cond .= " and status=2";
}
$orderBy = "order by reg_date desc";

#-------Page Divide---------------------------------------------------------------
$recordPerPage = 20;
$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
$start_limit = ($currentPage - 1) * $recordPerPage;
$limit = " limit $start_limit,$recordPerPage";
$lstAllItem = $clsClassTable->getAll($cond);
$totalRecord = (is_array($lstAllItem) && count($lstAllItem) > 0) ? count($lstAllItem) : 0;
$totalPage = ceil($totalRecord / $recordPerPage);
$smarty->assign('totalRecord', $totalRecord);
$smarty->assign('totalPage', $totalPage);
$smarty->assign('currentPage', $currentPage);
$smarty->assign('recordPerPage', $recordPerPage);

$listPageNumber = array();
for ($i = 1; $i <= $totalPage; $i++) {
    $listPageNumber[] = $i;
}
$smarty->assign('listPageNumber', $listPageNumber);

$query_string = $_SERVER['QUERY_STRING'];
$lst_query_string = explode('&', $query_string);
$link_page_current = '';
for ($i = 0; $i < count($lst_query_string); $i++) {
    $tmp = explode('=', $lst_query_string[$i]);
    if ($tmp[0] != 'page')
        $link_page_current .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
}
$smarty->assign('link_page_current', $link_page_current);
#
$link_page_current_2 = '';
for ($i = 0; $i < count($lst_query_string); $i++) {
    $tmp = explode('=', $lst_query_string[$i]);
    if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
        $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
}
$smarty->assign('link_page_current_2', $link_page_current_2);
#-------End Page Divide-----------------------------------------------------------
$listItem = $clsClassTable->getAll($cond . " " . $orderBy . $limit); //print_r($cond); die();
$smarty->assign('listItem', $listItem);
unset($listItem);
#

$totalItem = $clsClassTable->countItem("1=1");
$numberProcess = $clsClassTable->countItem("status=1");
$numberUnprocess = $clsClassTable->countItem("status=0");

// Gán giá trị vào Smarty
$smarty->assign('totalItem', $totalItem);
$smarty->assign('number_process', $numberProcess);
$smarty->assign('number_unprocess', $numberUnprocess);
