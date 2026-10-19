<?php 
	global $core, $smarty;
	#
	$clsPromotion=new Promotion();$smarty->assign('clsPromotion',$clsPromotion);
	$lstPromotion = $clsPromotion->getAll("is_trash=0 order by reg_date desc limit 0,4",$clsPromotion->pkey.",reg_date");
	$smarty->assign('lstPromotion',$lstPromotion); unset($lstPromotion);
?>