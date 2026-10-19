<?php
global $smarty, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $package_id;
global $clsConfiguration, $lang_sql;

$cruiseModuleActive = $clsISO->getCheckActiveModulePackage($package_id, 'cruise', 'default', 'default');
$hotelModuleActive = $clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'default', 'default');
$voucherModuleActive = $clsISO->getCheckActiveModulePackage($package_id, 'voucher', 'default', 'default');

$listHotel = [];
if (!empty($hotelModuleActive)) {
    // List Top Hotel
    $clsHotel = new Hotel();
    $smarty->assign("hotel", $clsHotel);
    $order_by = " ORDER BY order_no DESC";
    $cond = "is_trash=0 and is_online=1";
    $limit = " LIMIT 0,10";
    $listHotel = $clsHotel->getAll($cond . $order_by . $limit, $clsHotel->pkey . ",title");
}
$smarty->assign("listHotel", $listHotel);
unset($listHotel);

// List Top Voucher
$lstVoucher = [];
if (!empty($voucherModuleActive)) {
    $clsVoucher = new Voucher();
    $smarty->assign("clsVoucher", $clsVoucher);
    $clsVoucherCat = new VoucherCat();
    $smarty->assign("clsVoucherCat", $clsVoucherCat);
    $order_by = " ORDER BY order_no ASC";
    $cond = "is_trash=0 and is_online=1";
    $limit = " LIMIT 0,10";
    $orderBy = " order by order_no ASC";
    $lstVoucher = $clsVoucher->getAll($cond . $orderBy . $limit, $clsVoucher->pkey . ",title,cat_id");
}

$smarty->assign("lstVoucher", $lstVoucher);
unset($lstVoucher);

//List Top Cruise
$listCruise = [];
if (!empty($cruiseModuleActive)) {
    $clsCruise = new Cruise();
    $smarty->assign("clsCruise", $clsCruise);
    $listCruise = $clsCruise->getAll($cond . $order_by . $limit, $clsCruise->pkey . ",title");
}

$smarty->assign("listCruise", $listCruise);
unset($listCruise);
