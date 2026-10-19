<?php 
	global $smarty;
	#
	$clsPage = new Page();$smarty->assign('clsPage',$clsPage);
	$lstPage = $clsPage->getAll("is_trash=0 and is_online=1 order by order_no asc",$clsPage->pkey.',title,slug');
	$listAllpage =  $clsPage->getAll("is_trash=0 and is_online=1 order by order_no asc",$clsPage->pkey.',title,slug');
	$smarty->assign('listAllpage',$listAllpage);
	$smarty->assign('lstPage',$lstPage); unset($lstPage);
	#	
?>