<?php 
# Video Home
	global $assign_list,$mod, $act, $core, $oneConfiguration, $smarty;
	#
	$clsPlace = new Place();$smarty->assign("clsPlace",$clsPlace);
	#
	$listPlace = $clsPlace->getAll("is_trash=0 and is_online=1 order by order_no desc limit 0,10",$clsPlace->pkey);
	$smarty->assign("listPlace",$listPlace);
	unset($listPlace);
	
