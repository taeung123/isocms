<?php 
	global $smarty;
	#
	$clsCruise=new Cruise();$smarty->assign('clsCruise',$clsCruise);
	$smarty->assign('lstCruiseViewed',$clsCruise->getAll("is_trash=0 and is_online=1 order by view_num desc limit 0,5",$clsCruise->pkey));
	unset($clsCruise);
?>