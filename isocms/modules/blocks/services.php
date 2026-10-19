<?php 
	global $core, $smarty;
	#
	$clsService = new Service(); $smarty->assign('clsService',$clsService);
	#
	$slug = isset($_GET['slug'])?$_GET['slug']:'';
	$service_id = $clsService->getBySlug($slug);
	if($clsService->checkExitsId($service_id) == '0') {
		$smarty->assign('service_id',$service_id);
	}
	#
	$resItem = $clsService->getAll("is_trash=0 and is_online=1 order by order_no desc");
	$smarty->assign('resItem',$resItem); unset($resItem);
?>