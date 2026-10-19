<?php
global $mod, $assign_list, $act, $dbconn, $show, $smarty, $core, $extLang, $_lang, $clsISO, $cat_id, $cat_ID, $city_id, $country_id, $clsConfiguration, $duration_ID, $price_range_ID;
#

$clsTour = new Tour();
$smarty->assign('clsTour', $clsTour);
$clsActivities = new Activities();
$smarty->assign('clsActivities', $clsActivities);
$clsTourCategory = new TourCategory();
$smarty->assign('clsTourCategory', $clsTourCategory);
$clsPriceRange = new PriceRange();
$smarty->assign('clsPriceRange', $clsPriceRange);
$clsProperty = new Property();
$smarty->assign('clsProperty', $clsProperty);

$activities_id = isset($_GET['activities_id']) ? $_GET['activities_id'] : '';
$physical_grade_id = isset($_GET['physical_grade_id']) ? $_GET['physical_grade_id'] : '';

$lstActivities = $clsActivities->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsActivities->pkey . ",title");
$smarty->assign('lstActivities', $lstActivities);

#-- Create Duration
$cond = "is_trash=0 and is_online=1";
if (1 == 2) {
	if ($country_id > 0) {
		$cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id IN ($country_id))";
	}
	if (!empty($cat_id)) {
		$cat_ID = explode(',', $cat_id);
		$cond .= " and (";
		for ($i = 0; $i < count($cat_ID); $i++) {
			if ($i == 0 && count($cat_ID) == 1) {
				$cond .= " (cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
			} elseif (count($cat_ID) > 1 && $i < (count($cat_ID) - 1)) {
				$cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%') or ";
			} else {
				$cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
			}
		}

		$cond .= ")";
	}

	$assign_list["cat_id"] = $cat_id;



	if (!empty($activities_id)) {
		$activities_id = explode(',', $activities_id);
		$cond .= " and (";
		for ($i = 0; $i < count($activities_id); $i++) {
			if ($i == 0 && count($activities_id) == 1) {
				$cond .= " list_activities_id like '%" . $activities_id[$i] . "%'";
			} elseif (count($activities_id) > 1 && $i < (count($activities_id) - 1)) {
				$cond .= " list_activities_id like '%" . $activities_id[$i] . "%' or ";
			} else {
				$cond .= " list_activities_id like '%" . $activities_id[$i] . "%'";
			}
		}
		$cond .= ")";
		$assign_list["activities_id"] = $activities_id;
	}
	if ($physical_grade_id > 0) {
		$cond .= " and physical_grade_id = '$physical_grade_id'";
	}
}

$orderByASC = " order by number_day ASC";
$orderByDESC = " order by number_day DESC";
$listAllTourASC = $clsTour->getAll($cond . $orderByASC, $clsTour->pkey . ",number_day");
$listAllTourDESC = $clsTour->getAll($cond . $orderByDESC, $clsTour->pkey . ",number_day");
$listAllTourPageDESC = $clsTour->getAll("is_trash=0 and is_online=1" . $orderByDESC, $clsTour->pkey . ",number_day");
$min_duration_value = $listAllTourASC[0]['number_day'];
if ($min_duration_value != '') {
	$min_duration_value = $min_duration_value;
} else {
	$min_duration_value = 0;
}
$max_duration_value = $listAllTourDESC[0]['number_day'];
if ($max_duration_value != '') {
	$max_duration_value = $max_duration_value;
} else {
	$max_duration_value = $listAllTourPageDESC[0]['number_day'];
}

$smarty->assign('min_duration_value', $min_duration_value);
$smarty->assign('max_duration_value', $max_duration_value);


$min_duration_search = isset($_GET['min_duration']) ? $_GET['min_duration'] : $min_duration_value;
$max_duration_search = isset($_GET['max_duration']) ? $_GET['max_duration'] : $max_duration_value;
$smarty->assign('min_duration_search', $min_duration_search);
$smarty->assign('max_duration_search', $max_duration_search);



if (1 == 2) {
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
					$DURATION_HTML .= '<li>
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
			$PRICERANGE_HTML .= '<li>
					<input id="p' . $item[$clsPriceRange->pkey] . '" class="typeSearch" name="price_range_ID[]" value="' . $item[$clsPriceRange->pkey] . '" type="checkbox" ' . ($clsISO->checkInArray($price_range_ID, $item[$clsPriceRange->pkey]) ? 'checked="checked"' : '') . '"/>
	<label for="p' . $item[$clsPriceRange->pkey] . '" class="twoFilter">' . $clsPriceRange->getTitle($item[$clsPriceRange->pkey]) . '</label>	
				  </li>';
		}
	}
	$smarty->assign('PRICERANGE_HTML', $PRICERANGE_HTML);
}
if (isset($_POST['Hid_Search']) &&  $_POST['Hid_Search'] == 'Hid_Search') {
	$link = $extLang . '/tours/';
	if (!empty($_POST['all'])) {
		$link .= (!empty($_POST['all'])) ? '&all=' . $_POST['all'] : '';
	} else {
		$link .= (!empty($_POST['country_id'])) ? '&country_id=' . $clsISO->makeSlashListFromArrayComma($_POST['country_id']) : '';
		$link .= (!empty($_POST['cat_id'])) ? '&cat_id=' . $clsISO->makeSlashListFromArrayComma($_POST['cat_id']) : '';
		$link .= (!empty($_POST['min_duration'])) ? '&min_duration=' . $_POST['min_duration'] : '&min_duration=0';
		$link .= (!empty($_POST['max_duration'])) ? '&max_duration=' . $_POST['max_duration'] : '&max_duration=0';
		$link .= (!empty($_POST['activities_id'])) ? '&activities_id=' . $clsISO->makeSlashListFromArrayComma($_POST['activities_id']) : '';
		$link .= (!empty($_POST['physical_grade_id'])) ? '&physical_grade_id=' . $clsISO->makeSlashListFromArrayComma($_POST['physical_grade_id']) : '';
	}
	header('location:' . trim($link));
	exit();
}
