<?php 
	global $smarty,$core,$pvalTable,$meta_id;

	
	$clsISO = new ISO();$smarty->assign('clsISO',$clsISO); 
	$clsMeta = new Meta();$smarty->assign('clsMeta',$clsMeta);

	$oneMeta = $clsMeta->getOne($meta_id); 
	$smarty->assign('oneMeta',$oneMeta);

	
	$number_word_title=$clsISO->getCountMetaWord($clsMeta->getMetaTitle($meta_id));
	$smarty->assign('number_word_title',$number_word_title);
	$number_word_description=$clsISO->getCountMetaWord($clsMeta->getMetaDescription($meta_id));
	$smarty->assign('number_word_description',$number_word_description);

?>