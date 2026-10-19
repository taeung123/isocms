<?php 
	global $core, $smarty, $mod, $act;
	
	$clsPartner = new Partner();$smarty->assign('clsPartner',$clsPartner);
	$lstPartner = $clsPartner->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,7", $clsPartner->pkey);
	$smarty->assign("lstPartner",$lstPartner);
	$totalPanner=$lstPartner?count($lstPartner):0;
	//print_r($totalPanner); die();
	$width_slide_panner=$totalPanner*140;
	$smarty->assign("width_slide_panner",$width_slide_panner);
?>
