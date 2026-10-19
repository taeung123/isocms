<?php 
	global $smarty,$tour_id;
	$clsTour=new Tour();$smarty->assign('clsTour',$clsTour);
	//$tour_id = isset($_GET['tour_id'])? intval($_GET['tour_id']) : 0;

	$h=$clsTour->getLocationMapBox($tour_id);
	$u=$clsTour->getLocationMapBoxValue($tour_id);

	$smarty->assign('h_a',$h);
	$smarty->assign('u_a',$u);
?>