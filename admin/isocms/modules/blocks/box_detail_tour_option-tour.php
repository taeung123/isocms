<?php
global $smarty, $core;

$clsTour = new Tour();
$smarty->assign('clsTour', $clsTour);
$clsTourOption = new TourOption();
$smarty->assign('clsTourOption', $clsTourOption);

$lstProperty = $clsTourOption->getAll("is_trash=0 and type='$type' and tour_property_id='$tour_property_id' order by order_no ASC");
