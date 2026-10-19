<?php
global $mod, $act, $smarty, $core, $extLang, $_lang;
#
$clsCountryEx = new Country();
$smarty->assign('clsCountryEx', $clsCountryEx);
$clsTour = new Tour();
$smarty->assign('clsTour', $clsTour);

$country_id = !empty($country_id) ? $country_id : '1';
$smarty->assign('country_id', $country_id);
#
$clsCity = new City();
$smarty->assign('clsCity', $clsCity);

$clsCityStore = new CityStore();
$smarty->assign('clsCityStore', $clsCityStore);


$lstDeparturePoint = $clsCityStore->getAll("is_trash=0 and type='DEPARTUREPOINT' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "city WHERE is_trash =0 and is_online=1) order by order_no ASC", $clsCityStore->pkey . ',city_id');
$smarty->assign('lstDeparturePoint', $lstDeparturePoint);
unset($lstDeparturePoint);


$listTopCity = $clsCityStore->getAll("is_trash=0 and type='TOP' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "city WHERE is_trash =0 and is_online=1) order by order_no ASC", $clsCityStore->pkey . ',city_id');
$smarty->assign('listTopCity', $listTopCity);
unset($listTopCity);

#-- Create Duration
$cond = "is_trash=0 and is_online=1";
$LISTALL = $clsTour->getAll($cond);
$TMP = '';
$DURATION_HTML = '<option value="0">' . $core->get_Lang('Select all') . '</option>';
if (is_array($LISTALL) && count($LISTALL) > 0) {
	for ($i = 0; $i < count($LISTALL); $i++) {
		$TMP .= $clsTour->getSelectTripDuration($LISTALL[$i][$clsTour->pkey]) . '|';
	}
	$TMP = array_unique(explode('|', $TMP));
	if (is_array($TMP) && count($TMP) > 0) {
		sort($TMP, SORT_NUMERIC);
		foreach ($TMP as $key => $val) {
			if ($val != '' && $val != 'n/a') {
				$DURATION_HTML .= '<option value="' . $clsTour->convertDuration($val) . '" ' . ($duration == $clsTour->convertDuration($val) ? 'selected="selected"' : '') . '>' . $val . '</option>';
			}
		}
	}
	unset($LISTALL);
}
$smarty->assign('DURATION_HTML', $DURATION_HTML);
#
if (isset($_POST['Hid_Search']) &&  $_POST['Hid_Search'] == 'Hid_Search') {
	$link = $extLang . '/tours/';
	foreach ($_POST as $key => $val) {
		$link .= ($key == 'Hid_Search') ? '' : '&' . $key . '=' . ($val != '' ? addslashes($val) : '0');
	}
	//print_r($link); die();
	header('location:' . $link);
	exit();
}
