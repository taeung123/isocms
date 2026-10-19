<?php
global $clsISO, $smarty;
#

$clsTourStartDate = new TourStartDate();
$smarty->assign('clsTourStartDate', $clsTourStartDate);
$clsTour = new Tour();
$smarty->assign('clsTour', $clsTour);
#

$cond = 'is_trash=0 AND is_active=1 AND end_date >= ' . time();
$order_by = ' ORDER BY end_date ASC';

//Danh sach ngay co departure schedule
$lstDateBase = $clsTourStartDate->getAll($cond . $order_by,  'DISTINCT(end_date)');
$lstDateDeparture = array();
if (!empty($lstDateBase)) {
    foreach ($lstDateBase as $key => $item) {
        $lstDateDeparture[] = date('d/m/Y', $item['end_date']);
    }
}

$smarty->assign('lstDateDeparture', json_encode($lstDateDeparture));

//Danh sach tour departure schedule gom 3 tour gan nhat duoc cau hinh departure date khi vua truy cap trang
$limit = " LIMIT 0,4";
$listTourDeparture = $clsTourStartDate->getAll($cond . $order_by . $limit, 'tour_id, end_date, allotment');
$smarty->assign('listTourDeparture', $listTourDeparture);
