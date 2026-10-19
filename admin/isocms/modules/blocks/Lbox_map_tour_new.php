<?php 
	global $smarty,$core,$tour_id;
	
	$clsTour=new Tour();$smarty->assign('clsTour',$clsTour);
	$tour_id = isset($_GET['tour_id']) ? ($_GET['tour_id']) : 0;


	$h=$clsTour->getLocationMapBox($tour_id);
	$u=$clsTour->getLocationMapBoxValue($tour_id);
	$smarty->assign('h',$h);
	$smarty->assign('u',$u);
?>