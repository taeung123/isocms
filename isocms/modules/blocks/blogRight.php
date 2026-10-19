<?php 
	global $smarty;
	#
	$clsBlog = new Blog();$smarty->assign('clsBlog',$clsBlog);
	$lstBlog = $clsBlog->getAll("is_trash=0 and is_online=1 and blog_id <> '$blog_id' order by order_no desc limit 0,5",$clsBlog->pkey);
	$smarty->assign('lstBlog',$lstBlog); unset($lstBlog);
?>