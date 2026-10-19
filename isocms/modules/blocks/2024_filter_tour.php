<?php
global $mod, $act, $assign_list, $act, $dbconn, $show, $smarty, $core, $extLang, $_lang, $clsISO, $clsConfiguration, $cat_id, $country_id, $min_duration_value, $max_duration_value, $min_price_value, $max_price_value, $min_duration_search, $max_duration_search, $city_id;
$clsCityStore = new CityStore();
$clsTourCategory = new TourCategory();
$clsTour = new Tour();
$clsCity = new City();
$clsRegion = new Region();
$smarty->assign('clsRegion', $clsRegion);
$clsCountry = new Country();
$smarty->assign('clsCountry', $clsCountry);
$cond = "is_online = 1 and is_trash = 0 ";
$cond_def = "is_online = 1 and is_trash = 0 ";


 if ($cat_id > 0) {
    $listTourCategory = $clsTourCategory->getAll("$cond and parent_id='$cat_id'", $clsTourCategory->pkey);
    if ($listTourCategory != '') {
        $parent_id = $cat_id;
        $cond .= " and (cat_id='$cat_id' or list_cat_id like '%|" . $cat_id . "|%' or cat_id IN (SELECT tourcat_id FROM " . DB_PREFIX . "tour_category WHERE parent_id = '$parent_id'))";
    } else {
        $cond .= " and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')";
    }
}
if ($country_id > 0) {
    $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_id')";
}

# get method
$duration = $_GET["duration"] ?? '';
$smarty->assign('duration', $duration);
$rating = $_GET["rating"] ?? '';
$smarty->assign('rating', $rating);
if (empty($country_id)) {
    $country_id = $_GET["country_id"] ?? 0;
}
$smarty->assign('country_id', $country_id);
$city_filter_id = $_GET["city_filter_id"] ?? '';
$smarty->assign('city_filter_id', $city_filter_id);
$departure_point_id = $_GET["departure_point_id"] ?? '';
$smarty->assign('departure_point_id', $departure_point_id);
$duration_id = $_GET["duration_id"] ?? '';
$smarty->assign('duration_id', $duration_id);
$departure_date = $_GET["departure_date"] ?? '';
$smarty->assign('departure_date', $departure_date);

$max_price_value = $clsTour->getAll($cond, "max(min_price) as max");

$min_price_search = $_GET["min_price"] ?? 0;
$max_price_search = $_GET["max_price"]  ?? $max_price_value[0]["max"];
$smarty->assign('min_price_value', 0);
$smarty->assign('max_price_value', $max_price_value[0]["max"]);
$smarty->assign('min_price_search', $min_price_search);
$smarty->assign('max_price_search', $max_price_search);

$listCountry = $clsCountry->getAll($cond, "$clsCountry->pkey, title");
$smarty->assign('listCountry', $listCountry);

$order_field = !empty($departure_point_id) ? "FIELD($clsCity->pkey, $departure_point_id) DESC, " : "";
$lstDeparturePoint = $clsCity->getAll("$cond and city_id IN (SELECT city_id FROM $clsCityStore->tbl WHERE is_trash=0 and type='DEPARTUREPOINT') order by $order_field order_no DESC", "$clsCity->pkey, title");
$smarty->assign('lstDeparturePoint', $lstDeparturePoint);

$listDuration = $clsTour->getAll("$cond_def and number_day > 0 GROUP BY number_day, number_night ORDER BY number_day", "$clsTour->pkey,number_day, number_night");
$smarty->assign('listDuration', $listDuration);

if ($city_id && $act == "place_inbound2024") {
    $country_id = $clsCity->getCountryByCity($city_id);
    $smarty->assign('country_id', $country_id);
    $city_filter_id = $city_id;
}
if ($country_id) {
    $order_field = !empty($city_filter_id) ? "FIELD($clsCity->pkey, $city_filter_id) DESC, " : "";
    $listCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id='$country_id' order by $order_field order_no ASC", "$clsCity->pkey, title");
    $smarty->assign('listCity', $listCity);
}
