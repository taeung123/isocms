<?php 
	global $smarty,$core,$pvalTable, $mod,$child_cat_menu;

	
	$clsISO = new ISO();$smarty->assign('clsISO',$clsISO); 
	$clsMeta = new Meta();$smarty->assign('clsMeta',$clsMeta);
	$clsTour = new Tour();$smarty->assign('clsTour',$clsTour);
	# 
	if($pvalTable >0){
		$linkMeta = $clsTour->getLink($pvalTable);
	}else{
		$linkMeta = $clsISO->getLink($mod);
	}
	
	$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'];
	$smarty->assign('meta_id',$meta_id);
	$oneMeta = $clsMeta->getOne($meta_id); 
	$smarty->assign('oneMeta',$oneMeta);

	
	$number_word_title=$clsISO->getCountMetaWord($clsMeta->getMetaTitle($meta_id));
	$smarty->assign('number_word_title',$number_word_title);
	$number_word_description=$clsISO->getCountMetaWord($clsMeta->getMetaDescription($meta_id));
	$smarty->assign('number_word_description',$number_word_description);
	//var_dump($child_cat_menu);

?>