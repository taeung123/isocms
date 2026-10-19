<?php 
	global $smarty;
	
	global $smarty;
	
	$clsTour=new Tour();$smarty->assign('clsTour',$clsTour);
	$tour_id = isset($_GET['tour_id'])? intval($_GET['tour_id']) : 0;
	
	$ret = $clsTour->getLocationMap($tour_id);
	$map_la = $ret['map_la'];
	$map_lo = $ret['map_lo'];
	$script_location = $ret['jscode'];
	$smarty->assign('map_la',$map_la);
	$smarty->assign('map_lo',$map_lo);
	$smarty->assign('script_location',$script_location);
?>