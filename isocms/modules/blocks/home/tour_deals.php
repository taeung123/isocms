<?php
global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $package_id, $smarty;
global $clsConfiguration, $lang_sql;
//   List Deal tour
$clsTour = new Tour();
$clsTourStore = new TourStore();
$smarty->assign("clsTourStore", $clsTourStore);
$clsTourStartDate = new TourStartDate();
$smarty->assign("clsTourStartDate", $clsTourStartDate);
#

$listSelected = $clsTourStartDate->getAll("is_trash=0 and is_active=1 and start_date >= '" . time() . "' and open_sale_date <= '" . time() . "' and close_sale_date >= '" . time() . "' and is_last_hour=1 order by start_date ASC ", 'tour_id, open_sale_date, close_sale_date, start_date, allotment');
$smarty->assign("listSelected", $listSelected);
