<?php 
	global $core, $smarty, $mod, $act,$clsISO,$package_id,$deviceType;
	
	if($clsISO->getCheckActiveModulePackage($package_id,'partner','default','default')){
		$clsPartner = new Partner();$smarty->assign('clsPartner',$clsPartner);
		$lstPartner = $clsPartner->getAll("is_trash=0 and is_online=1 and image<>'' and type='' order by order_no asc", $clsPartner->pkey.",title,image,url");
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
