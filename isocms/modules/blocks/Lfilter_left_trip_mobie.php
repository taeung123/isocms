<?php
global $mod, $act, $dbconn, $show, $smarty, $core, $extLang, $_lang, $clsISO, $cat_id, $city_id, $country_id, $clsConfiguration, $duration_ID, $price_range_ID;
#
$clsTour = new Tour();
$smarty->assign('clsTour', $clsTour);
$clsTourCategory = new TourCategory();
$smarty->assign('clsTourCategory', $clsTourCategory);
$clsPriceRange = new PriceRange();
$smarty->assign('clsPriceRange', $clsPriceRange);
$clsProperty = new Property();
$smarty->assign('clsProperty', $clsProperty);
#
$country__id = isset($_GET['country_id']) ? $_GET['country_id'] : '';

$cat__id = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
$cat__ID = isset($_GET['cat_ID']) ? $_GET['cat_ID'] : '';
$price_range__ID = isset($_GET['price_range_ID']) ? $_GET['price_range_ID'] : '';

#-- Create Duration
$cond = "is_trash=0 and is_online=1";
if ($country__id > 0) {
	$cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id IN ($country__id))";
}
if (!empty($cat__ID)) {
	$cat__ID = explode(',', $cat__ID);
	$cond .= " and (";
	for ($i = 0; $i < count($cat__ID); $i++) {
		if ($i == 0 && count($cat__ID) == 1) {
			$cond .= " (cat_id='" . $cat__ID[$i] . "' or list_cat_id like '%|" . $cat__ID[$i] . "|%')";
		} elseif (count($cat__ID) > 1 && $i < (count($cat__ID) - 1)) {
			$cond .= "(cat_id='" . $cat__ID[$i] . "' or list_cat_id like '%|" . $cat__ID[$i] . "|%') or ";
		} else {
			$cond .= "(cat_id='" . $cat__ID[$i] . "' or list_cat_id like '%|" . $cat__ID[$i] . "|%')";
		}
	}
	$assign_list["cat__ID"] = $cat__ID;
	$cond .= ")";
}
if (!empty($price_range__ID)) {
	$clsPriceRange = new PriceRange();
	//print_r(xxx);die();
	$SQLMINRATE = "SELECT MIN(min_rate) FROM " . DB_PREFIX . "price_range WHERE price_range_id IN ($price_range__ID) and type='TOUR'";

	$SQLMAXRATE = "SELECT MAX(max_rate) FROM " . DB_PREFIX . "price_range WHERE price_range_id IN ($price_range__ID) and max_rate<>'0' and type='TOUR'";

	$SQLMINMAXRATE = "SELECT MIN(max_rate) FROM " . DB_PREFIX . "price_range WHERE price_range_id IN ($price_range__ID) and type='TOUR'";

	#

	$min_rate = $dbconn->GetOne($SQLMINRATE);
	$minmax_rate = $dbconn->GetOne($SQLMINMAXRATE);
	$assign_list['minmax_rate'] = $minmax_rate;
	if ($minmax_rate == '0') {
		$max_rate = 0;
	} else {
		$max_rate = $dbconn->GetOne($SQLMAXRATE);
	}


	$assign_list['min_rate'] = $min_rate;
	$assign_list['max_rate'] = $max_rate;

	if ($min_rate > 0 && $max_rate > 0) {
		$cond .= " and trip_price > '$min_rate' and trip_price < '$max_rate'";
	} elseif ($min_rate == 0 && $max_rate > 0) {
		$cond .= " and trip_price < '$max_rate'";
	} elseif ($min_rate > 0 && $max_rate == 0) {
		$cond .= " and trip_price >= '$min_rate'";
	} elseif ($min_rate == 0 && $max_rate == 0) {
		$cond .= " and trip_price >= '$min_rate'";
	} else {
		$cond .= " and trip_price > '$min_rate'";
	}
}

//print_r($cond); die();

$LISTALL = $clsTour->getAll($cond);
$TMP = '';
$DURATION_HTML = '';
if (is_array($LISTALL) && count($LISTALL) > 0) {
	for ($i = 0; $i < count($LISTALL); $i++) {
		$TMP .= $clsTour->getSelectTripDuration($LISTALL[$i][$clsTour->pkey]) . '|';
	}
	$TMP = array_unique(explode('|', $TMP));
	if (is_array($TMP) && count($TMP) > 0) {
		sort($TMP, SORT_NUMERIC);
		foreach ($TMP as $key => $val) {
			if ($val != '' && $val != 'n/a') {
				$DURATION_HTML .= '<li class="clearfix margin-bottom-10">
										<input id="d' . $clsTour->convertDurationDaySort($val) . '" class="typeSearch" name="duration_ID[]" value="' . $clsTour->convertDurationDaySort($val) . '" type="checkbox" ' . ($clsISO->checkInArray($duration_ID, $clsTour->convertDurationDaySort($val)) ? 'checked="checked"' : '') . '/>
				<label for="d' . $clsTour->convertDurationDaySort($val) . '" class="twoFilter">' . $val . '</label>	
									  </li>';
			}
		}
	}
}
$smarty->assign('DURATION_HTML', $DURATION_HTML);



$all = $clsPriceRange->getAll("is_trash=0 and type='TOUR' order by order_no asc");

$PRICERANGE_HTML = '';
if (!empty($all)) {
	foreach ($all as $item) {
		$PRICERANGE_HTML .= '<li class="clearfix margin-bottom-10">
				<input id="p' . $item[$clsPriceRange->pkey] . '" class="typeSearch" name="price_range_ID[]" value="' . $item[$clsPriceRange->pkey] . '" type="checkbox" ' . ($clsISO->checkInArray($price_range_ID, $item[$clsPriceRange->pkey]) ? 'checked="checked"' : '') . '"/>
<label for="p' . $item[$clsPriceRange->pkey] . '" class="twoFilter">' . $clsPriceRange->getTitle($item[$clsPriceRange->pkey]) . '</label>	
			  </li>';
	}
}
$smarty->assign('PRICERANGE_HTML', $PRICERANGE_HTML);

if (isset($_POST['Hid_Search']) &&  $_POST['Hid_Search'] == 'Hid_Search') {
	$link = $extLang . '/tours/';
	if (!empty($_POST['all'])) {
		$link .= (!empty($_POST['all'])) ? '&all=' . $_POST['all'] : '';
	} else {
		$link .= (!empty($_POST['country_id'])) ? '&country_id=' . $clsISO->makeSlashListFromArrayComma($_POST['country_id']) : '';
		$link .= (!empty($_POST['cat_ID'])) ? '&cat_ID=' . $clsISO->makeSlashListFromArrayComma($_POST['cat_ID']) : '';
		$link .= (!empty($_POST['duration_ID'])) ? '&duration_ID=' . $clsISO->makeSlashListFromArrayComma($_POST['duration_ID']) : '';
		$link .= (!empty($_POST['price_range_ID'])) ? '&price_range_ID=' . $clsISO->makeSlashListFromArrayComma($_POST['price_range_ID']) : '';
	}
	header('location:' . trim($link));
	exit();
}
