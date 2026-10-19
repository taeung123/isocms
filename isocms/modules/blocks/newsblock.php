<?php 
	global $smarty;
	#
	$clsNews = new News();
	$smarty->assign('clsNews', $clsNews);
	$lstNews = $clsNews->getAll("is_trash=0 and is_online=1 order by order_no DESC LIMIT 0,5");
	$smarty->assign('lstNews', $lstNews); unset($lstNews);
	
	$clsBlog = new Blog();
	$smarty->assign('clsBlog', $clsBlog);
	$lstBlog = $clsBlog->getAll("is_trash=0 and is_online=1 order by order_no DESC LIMIT 0,5");
	$smarty->assign('lstBlog', $lstBlog); unset($lstBlog);
?>