<?php
	global $core, $smarty;
	$clsBlogCategory = new BlogCategory();$smarty->assign('clsBlogCategory',$clsBlogCategory);
	
	$clsTag = new Tag(); $smarty->assign('clsTag',$clsTag); 
	$clsBlog = new Blog();$smarty->assign('clsBlog',$clsBlog);  
	$lstBlogHome = $clsBlog->getAll("is_trash=0 and is_online=1 order by order_no desc limit 0,1",$clsBlog->pkey.",reg_date,cat_id");
	$smarty->assign('lstBlogHome',$lstBlogHome);unset($lstBlogHome);
	$assign_list[""] = $lstBlogHome;
	$lstRelated = $clsBlog->getAll("is_trash=0 and is_online=1 and blog_id <> '$blog_id' order by order_no desc limit 0,3");
	$smarty->assign('lstRelated',$lstRelated); unset($lstRelated); 
?>