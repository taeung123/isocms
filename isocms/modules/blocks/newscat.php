<?php 
	global $smarty;
	
	$clsNewsCategory = new NewsCategory();
	$smarty->assign('clsNewsCategory', $clsNewsCategory);
	
	$lstCategory = $clsNewsCategory->getAll("is_trash=0 order by order_no ASC", $clsNewsCategory->pkey);
	$smarty->assign('lstCategory', $lstCategory);
?>