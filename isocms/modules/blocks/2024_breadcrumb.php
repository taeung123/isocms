<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
global $mod, $act, $assign_list, $act, $dbconn, $show, $smarty, $core, $extLang, $_LANG_ID, $clsISO, $clsConfiguration, $cat_id, $country_id, $clsISO;
#
$clsCountryEx = new Country();
$smarty->assign('clsCountryEx', $clsCountryEx);
#
if ($mod == 'hotel') {
    $clsHotel = new Hotel();
    $smarty->assign('clsHotel', $clsHotel);
    #
    if ($act == 'place2024') {
        $show = $_GET['show'] ?? '';
        $smarty->assign('show', $show);
        #
        unset($show);
    }
    if ($act == 'detail2024') {
        $hotel_id = $_GET['hotel_id'] ?? 0;
        $smarty->assign('hotel_id', $hotel_id);
        $oneItem = $clsHotel->getOne($hotel_id);
        $smarty->assign('oneItem', $oneItem);
        #
        unset($hotel_id);
        unset($oneItem);
    }
}
#
