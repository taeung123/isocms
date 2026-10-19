<?php 
	global $smarty,$core,$mod,$act,$clsISO,$package_id;
	if($clsISO->getCheckActiveModulePackage($package_id,'blog','default','default')){
		$clsBlog= new Blog();$smarty->assign('clsBlog',$clsBlog);
		$cond="is_trash=0 and is_approve=1 and is_online=1 ";
		$limit = " LIMIT 0,4";
		$orderby="order by order_no ASC";
		$lstTopBlog = $clsBlog->getAll($cond.$orderby.$limit,$clsBlog->pkey.',title,slug,image,intro,publish_date');
		$smarty->assign('lstTopBlog',$lstTopBlog);

		unset($lstTopBlog);
	}
?>