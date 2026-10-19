<?php 
	global $smarty,$core,$mod,$act;
	
	$clsBlog= new Blog();$smarty->assign('clsBlog',$clsBlog);
	
	$lstTopBlog = $clsBlog->getAll("is_trash=0 and is_approve=1 and is_online=1 order by order_no ASC limit 0,12",$clsBlog->pkey);
	$smarty->assign('lstTopBlog',$lstTopBlog);

	$totalBlog=$lstTopBlog?count($lstTopBlog):0;
	$smarty->assign('totalBlog',$totalBlog);
	unset($lstTopBlog);
?>