<?php
	global $core, $smarty;
	$clsServiceCategory = new ServiceCategory();$smarty->assign('clsServiceCategory',$clsServiceCategory);
	//$clsTag = new Tag(); $smarty->assign('clsTag',$clsTag); 
	$clsService = new Service();$smarty->assign('clsService',$clsService);  
	$lstServiceCategory = $clsServiceCategory->getAll("is_trash=0 and is_online=1 order by order_no asc");
	$smarty->assign('lstServiceCategory',$lstServiceCategory);
	#
	$lstLatestService = $clsService->getAll("is_trash=0 and is_online=1 order by order_no desc limit 0,20");
	$smarty->assign('lstLatestService',$lstLatestService);
?>