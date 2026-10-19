<?php
global $mod, $act, $core, $extLang, $core, $country_id, $city_id;
#
$clsCountryEx = new Country();
$smarty->assign('clsCountryEx', $clsCountryEx);
#
if (($mod == 'tour' && $act == 'search') || !empty($_GET['country_id'])) {
	$country_id = $country_id;
	$smarty->assign('country_id', $country_id);
} else {
	if (!empty($_GET['slug_country'])) {
		$slug_country = isset($_GET['slug_country']) ? $_GET['slug_country'] : '';
		$country_id = $clsCountryEx->getBySlug($slug_country);
	}
	$smarty->assign('country_id', $country_id);
}
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
#
