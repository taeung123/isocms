<?php
	global $core, $smarty, $mod, $act, $_LANG_ID,$pvalTable,$clsClassTable;
	
	//print_r($clsClassTable); die();
	#
	$clsISO = new ISO();$smarty->assign('clsISO',$clsISO); 
	$clsMeta = new Meta();$smarty->assign('clsMeta',$clsMeta);
	# 
	if($pvalTable >0){
		$linkMeta = $clsClassTable->getLink($pvalTable);
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
	


	if(isset($_POST['submit']) && $_POST['submit'] == 'UpdateMeta'){
		if($_POST['config_value_title']!='' && $_POST['config_value_intro']!=''){
			if($meta_id==''){
				$clsMeta->insertOne("config_link","'$linkMeta'");
				$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
				$meta_id = $allMeta[0]['meta_id'];
			}
			$clsMeta->updateOne($meta_id,"config_value_title='".addslashes($_POST['config_value_title'])."',config_value_intro='".addslashes($_POST['config_value_intro'])."',config_value_keyword='".addslashes($_POST['config_value_keyword'])."',reg_date='".time()."',upd_date='".time()."',meta_index='".$_POST['meta_index']."',meta_follow='".$_POST['meta_follow']."'");
		}
		header('location: '.DOMAIN_NAME.$_SERVER['REQUEST_URI'].'&message=UpdateSuccess');
		unset($_POST['submit']);
	}

	unset($clsMeta);unset($tableName);unset($pkeyTable);
?>