<?php 
	global $smarty,$core;
	
	global $smarty;
	
	$clsTour=new Tour();$smarty->assign('clsTour',$clsTour);
	$tour_id = isset($_GET['tour_id']) ? ($_GET['tour_id']) : '';
    $tour_id = intval($core->decryptID($tour_id));
	$map_zoom=$clsTour->getOneField('map_zoom',$tour_id);
	$smarty->assign('map_zoom',$map_zoom);
	$ret = $clsTour->getLocationMap($tour_id);
	$map_la = $ret['map_la']?$ret['map_la']:'20.9954822';
	$map_lo = $ret['map_lo']?$ret['map_lo']:'105.86207179999997';
	$script_location = $ret['jscode'];
	$smarty->assign('map_la',$map_la);
	$smarty->assign('map_lo',$map_lo);
	$smarty->assign('script_location',$script_location);
?>