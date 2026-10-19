<?php 
	global $smarty,$is_tour_departure_point;


		ini_set('display_errors',1);
error_reporting(E_ERROR & ~E_STRICT);//E_ALL
	$clsPromotion = new Promotion();$smarty->assign('clsPromotion',$clsPromotion);
	#
?>