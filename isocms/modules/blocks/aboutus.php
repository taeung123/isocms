<?php 
	global $smarty;
	#
	$clsPage = new Page();$smarty->assign('clsPage',$clsPage);
	$lstPage = $clsPage->getAll("is_trash=0 is_online=1 order by order_no asc",$clsPage->pkey);
	$smarty->assign('lstPage',$lstPage); unset($lstPage);
?>