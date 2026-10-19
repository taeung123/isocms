<?php 
	global $core, $smarty, $mod, $act,$clsISO,$package_id;
	
	if($clsISO->getCheckActiveModulePackage($package_id,'partner','default','default')){
		$clsPartner = new Partner();$smarty->assign('clsPartner',$clsPartner);
		$lstPartner = $clsPartner->getAll("is_trash=0 and is_online=1 and image<>'' order by order_no asc", $clsPartner->pkey);
		$totalProgram=$lstPartner?count($lstPartner):0;
		$TotalListPartner = ceil($totalProgram/6);
		if ($clsISO->getBrowser() == 'phone'){
			$TotalListPartner = ceil($totalProgram/3);
		}
		$smarty->assign("TotalListPartner",$TotalListPartner);
		$smarty->assign("lstPartner",$lstPartner);
		unset($lstPartner);
	}
?>
