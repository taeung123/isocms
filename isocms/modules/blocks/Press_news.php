<?php 
	global $core, $smarty, $mod, $act,$clsISO,$package_id;

	$clsPartner = new Partner();$smarty->assign('clsPartner',$clsPartner);
	$lstPartner = $clsPartner->getAll("is_trash=0 and is_online=1 and image<>'' and type='BC' order by order_no asc", $clsPartner->pkey.',title,image,url');
	$totalPartner=$lstPartner?count($lstPartner):0;
	$width_slide_panner=$totalPartner*141;
	$smarty->assign("width_slide_panner",$width_slide_panner);
	$smarty->assign("lstPartner",$lstPartner);
	unset($lstPartner);


	
?>
