<?php
global $smarty;

$clsTourStore = new TourStore();
$smarty->assign('clsTourStore', $clsTourStore);
$clsCruiseStore = new CruiseStore();
$smarty->assign('clsCruiseStore', $clsCruiseStore);
