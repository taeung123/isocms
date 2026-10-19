<?php 
	global $smarty;
	#
	$clsPage = new Page();$smarty->assign('clsPage',$clsPage);
	$lstPage = $clsPage->getAll("is_trash=0 order by reg_date asc",$clsPage->pkey);
	$smarty->assign('lstPage',$lstPage); unset($lstPage);
?>