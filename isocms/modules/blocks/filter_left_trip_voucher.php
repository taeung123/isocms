
<?php
global $mod, $act, $assign_list, $act, $dbconn, $show, $smarty, $core, $extLang, $_lang, $clsISO, $clsConfiguration, $min_price_value, $max_price_value;
#
$clsVoucherDestination = new VoucherDestination();
$smarty->assign('clsVoucherDestination', $clsVoucherDestination);
$clsVoucherCategory = new VoucherCat();
$smarty->assign('clsVoucherCategory', $clsVoucherCategory);
$clsCity = new City();
$smarty->assign('clsCity', $clsCity);
$type = !empty($_GET["type"]) ? $_GET["type"] : "";
$cond = "is_trash=0";
$orderBy = " order by order_no asc";

$lstVoucherDestination = $clsVoucherDestination->getAll($cond . $orderBy, $clsVoucherDestination->pkey . ",voucher_id,city_id");

$lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and city_id IN (SELECT city_id FROM " . DB_PREFIX . "voucher_destination WHERE is_trash=0)" . $orderBy, $clsCity->pkey . ',title');

$smarty->assign('lstVoucherDestination', $lstVoucherDestination);
$smarty->assign('lstVoucherCat', $lstVoucherCat ?? []);
$smarty->assign('lstCity', $lstCity);

if (isset($_POST['search_des']) &&  $_POST['search_des'] == 'search_des') {
    $link = (!$type ? $clsISO->getLink($mod) : $clsISO->getLink("agent_voucher")) . '?action=search';
    if (!empty($_POST['all'])) {
        $link .= (!empty($_POST['all'])) ? '&all=' . $_POST['all'] : '';
    } else {

        $link .= (!empty($_POST['city_id'])) ? '&city_id=' . $clsISO->makeSlashListFromArrayComma($_POST['city_id']) : '';

        $link .= (!empty($_POST['voucher_cat_id'])) ? '&voucher_cat_id=' . $clsISO->makeSlashListFromArrayComma($_POST['voucher_cat_id']) : '';
        if ($min_price_value != $_POST['min_price']) {

            $link .= (!empty($_POST['min_price'])) ? '&min_price=' . $_POST['min_price'] : '&min_price=0';
        }
        if ($max_price_value != $_POST['max_price']) {
            $link .= (!empty($_POST['max_price'])) ? '&max_price=' . $_POST['max_price'] : '&max_price=0';
        }
    }
    header('location:' . trim($link));
    exit();
}
?>