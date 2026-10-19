<?php 
	global $smarty;
	
	$clsNewsCategory = new NewsCategory();
	$smarty->assign('clsNewsCategory', $clsNewsCategory);
	
	$clsNews = new News();
	$smarty->assign('clsNews', $clsNews);
	
	
	$lstCategory = $clsNewsCategory->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsNewsCategory->pkey.',title,slug');
	$smarty->assign('lstCategory', $lstCategory);
	
	
	
	$lstLatestNews = $clsNews->getAll("is_trash=0 and is_online=1 order by view_num desc LIMIT 3,5", $clsNews->pkey.",reg_date,title,image,slug");
	$smarty->assign('lstLatestNews', $lstLatestNews);
	
	
?>