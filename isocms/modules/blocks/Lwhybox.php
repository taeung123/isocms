<?php 
	global $smarty,$clsISO,$package_id;
	
	if($clsISO->getCheckActiveModulePackage($package_id,'why','default','default')){
		$clsWhy=new Why();$smarty->assign('clsWhy',$clsWhy);
		$smarty->assign('lstWhy',$clsWhy->getAll("is_trash=0 and is_online=1 order by order_no asc",$clsWhy->pkey.',title'));
		$smarty->assign('totalWhy',count($clsWhy->getAll("is_trash=0 and is_online=1 order by order_no asc",$clsWhy->pkey)));
		unset($clsWhy);
	}
?>