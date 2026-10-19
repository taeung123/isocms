<?php
global $mod, $act, $assign_list, $act, $dbconn, $show, $smarty, $core, $extLang, $_lang, $clsISO, $clsConfiguration, $country_id, $cat_id, $duration, $cabin_range_id, $cruise_price_range_id, $package_id, $cruise_id;

$clsCruiseItinerary = new CruiseItinerary();
$smarty->assign('clsCruiseItinerary', $clsCruiseItinerary);
$clsCruiseCabin = new CruiseCabin();
$smarty->assign('clsCruiseCabin', $clsCruiseCabin);
$clsCruiseProperty = new CruiseProperty();
$smarty->assign('clsCruiseProperty', $clsCruiseProperty);
$clsCruisePriceChild = new CruisePriceChild();
$smarty->assign('clsCruisePriceChild', $clsCruisePriceChild);

#list duration
$listDuration = $clsCruiseItinerary->getListDuration(0, 0, 1, $cruise_id);
$smarty->assign('listDuration', $listDuration);

$days = [
    'Monday'    => $core->get_Lang("Monday"),
    'Tuesday'   => $core->get_Lang("Tuesday"),
    'Wednesday' => $core->get_Lang("Wednesday"),
    'Thursday'  => $core->get_Lang("Thursday"),
    'Friday'    => $core->get_Lang("Friday"),
    'Saturday'  => $core->get_Lang("Saturday"),
    'Sunday'    => $core->get_Lang("Sunday"),
];

$time_now = strtotime("+1 day");
$day_of_week = $days[date("l", $time_now)]; // Get day names
$date = date("d/m/Y", $time_now);

$format_time_now = "$day_of_week, $date";
$smarty->assign('format_time_now', $format_time_now);

/*$format_time_now = date('l, d/m/Y', strtotime("+1 day"));
$smarty->assign('format_time_now', $format_time_now);*/

$lstCabinCruise = $clsCruiseCabin->getAll("is_trash=0 and is_online=1 and cruise_id='" . $cruise_id . "'", $clsCruiseCabin->pkey . ',list_group_size,title');

$number_cabin = (!empty($lstCabinCruise)) ? count($lstCabinCruise) : 0;
$smarty->assign('number_cabin', $number_cabin);

$arrGroupSize = [];
foreach ($lstCabinCruise as $key => $value) {
	$lstSizeGroup = str_replace('||', '|', $value['list_group_size']);
	$lstSizeGroup = trim($lstSizeGroup, '|');
	$arrSizeGroup = explode("|", $lstSizeGroup);
	$arrGroupSize = array_merge($arrGroupSize, $arrSizeGroup);
}
$arrGroupSize = array_unique($arrGroupSize);
$lstGroupSize = $clsCruiseProperty->getAll("cruise_property_id IN (" . implode(",", $arrGroupSize) . ") AND type='GroupSize'", $clsCruiseProperty->pkey . ',title,number_adult,number_child');
$smarty->assign('lstGroupSize', $lstGroupSize);

$CheckCruisePriceChild = $clsCruisePriceChild->getAll("cruise_id='" . $cruise_id . "'", $clsCruisePriceChild->pkey);
$smarty->assign('CheckCruisePriceChild', $CheckCruisePriceChild);
if (!empty($CheckCruisePriceChild)) {
	$lstCruisePriceChild = $clsCruisePriceChild->getAll("cruise_id='" . $cruise_id . "'", "MAX(max) as max_age, MIN(min) as min_age");
	$max_age = $lstCruisePriceChild[0]['max_age'];
	$min_age = $lstCruisePriceChild[0]['min_age'];
} else {
    $max_age = $clsConfiguration->getValue("ChildMaxAgePolicy");
    $min_age = $clsConfiguration->getValue("InfantMinAgePolicy");
}
$smarty->assign('max_age', $max_age);
$smarty->assign('min_age', $min_age);
