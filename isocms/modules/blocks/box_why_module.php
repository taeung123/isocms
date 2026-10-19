<?php 
	global $smarty;
	#
	$clsAboutCategory = new AboutCategory();$smarty->assign('clsAboutCategory',$clsAboutCategory); 
	$lstAboutCategory = $clsAboutCategory->getAll("is_trash=0 and is_online=1 order by order_no asc",$clsAboutCategory->pkey);
	$smarty->assign('lstAboutCategory',$lstAboutCategory); unset($lstAboutCategory);
?>