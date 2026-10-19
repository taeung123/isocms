<?php 
	global $smarty;
	#
	$clsTour = new TOur();
	$smarty->assign('clsTour',$clsTour);
	#
	$listTour = $clsTour->getAll("is_trash=0 and is_online=1 order by order_no desc LIMIT 0,10");
	
	$smarty->assign('listTour',$listTour); unset($listTour);
?>