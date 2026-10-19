<?php
global $mod, $act, $assign_list, $act, $dbconn, $show, $smarty, $core, $extLang, $_lang, $clsISO, $clsConfiguration, $country_id, $cat_id, $package_id, $duration, $cabin_range_id, $cruise_price_range_id, $cat_id, $tour_id, $oneItem;
global $oneItem, $child_type_id, $infant_type_id, $age_type_id, $height_type_id;

$clsTourProperty = new TourProperty();
$clsTour = new Tour();
$clsTourOption = new TourOption();
$clsTourStore = new TourStore();
$clsTourStartDate = new TourStartDate();

$getSelectChild = $getSelectInfant = "";
$child_visitor_type = $infant_visitor_type = "";
$textSizeGroupChild = $textSizeGroupInfant  = '';
if ($oneItem['visitorage_child'] != '') {
    $getSelectChild = $clsTourOption->getSelectBySizeGroup($child_type_id, "VISITORAGETYPE");
    $textSizeGroupChild = $clsTourOption->getTextSelectBySizeGroup($child_type_id, "VISITORAGETYPE");
    $child_visitor_type = $age_type_id;
} elseif ($oneItem['visitorheight_child'] != '') {
    $getSelectChild = $clsTourOption->getSelectBySizeGroup($child_type_id, "VISITORHEIGHTTYPE");
    $textSizeGroupChild = $clsTourOption->getTextSelectBySizeGroup($child_type_id, "VISITORHEIGHTTYPE");
    $child_visitor_type = $height_type_id;
}

if ($oneItem['visitorage_infant'] != '') {
    $getSelectInfant = $clsTourOption->getSelectBySizeGroup($infant_type_id, "VISITORAGETYPE");
    $textSizeGroupInfant = $clsTourOption->getTextSelectBySizeGroup($infant_type_id, "VISITORAGETYPE");
    $infant_visitor_type = $age_type_id;
} elseif ($oneItem['visitorheight_infant'] != '') {
    $getSelectInfant = $clsTourOption->getSelectBySizeGroup($infant_type_id, "VISITORHEIGHTTYPE");
    $textSizeGroupInfant = $clsTourOption->getTextSelectBySizeGroup($infant_type_id, "VISITORHEIGHTTYPE");
    $infant_visitor_type = $height_type_id;
}

$assign_list['child_visitor_type'] = $child_visitor_type;
$assign_list['infant_visitor_type'] = $infant_visitor_type;
$assign_list['getSelectChild'] = $getSelectChild;
$assign_list['getSelectInfant'] = $getSelectInfant;
$assign_list['textSizeGroupChild'] = $textSizeGroupChild;
$assign_list['textSizeGroupInfant'] = $textSizeGroupInfant;


foreach ($assign_list as $k => $v) {
    $smarty->assign($k, $v);
}
