<?php
global $mod, $act, $core, $extLang, $core, $clsISO, $country_id;
#
$clsCountryEx = new Country();
$smarty->assign('clsCountryEx', $clsCountryEx);
#

#
if ($mod == 'search') {
	$cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : '';
	$smarty->assign('cat_id', $cat_id);
}
#
$duration_trip = isset($_GET['duration']) ? $_GET['duration'] : '';
$smarty->assign('duration_trip', $duration_trip);
#
if (isset($_POST['hid_s']) &&  $_POST['hid_s'] == 'hid_s') {
	$link = $extLang . '/tours/';
	foreach ($_POST as $key => $val) {
		$link .= ($key == 'hid_s') ? '' : '&' . $key . '=' . ($val != '' ? addslashes($val) : '0');
	}
	header('location:' . $link);
	exit();
}

$city_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';

if (isset($_POST['Hid_Search2']) &&  $_POST['Hid_Search2'] == 'Hid_Search2') {
	$link = $extLang . '/dtours/';
	$link .= (!empty($_POST['city_id'])) ? '&city__id=' . $clsISO->makeSlashListFromArrayComma($_POST['city_id']) : '';
	header('location:' . trim($link));
	exit();
}
