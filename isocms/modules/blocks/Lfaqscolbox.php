<?php 
	global $smarty,$clsISO,$package_id;
	#
	if($clsISO->getCheckActiveModulePackage($package_id,'faqs','default','default')){
		$clsFAQ=new FAQ();$smarty->assign('clsFAQ',$clsFAQ);
		$smarty->assign('lstFaqs',$clsFAQ->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,4",$clsFAQ->pkey.',title,slug'));
		unset($clsWhy);
	}
?>