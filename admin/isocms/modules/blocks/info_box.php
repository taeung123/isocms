<?php 
	global $core, $mod, $act, $_LANG_ID;
	$clsISO = new ISO();
	#
	$clsMeta = new Meta(); $smarty->assign('clsMeta',$clsMeta);
	$config_link = 'config_link_'.$_LANG_ID; $smarty->assign('config_link',$config_link);
	$config_value_title = 'config_value_title_'.$_LANG_ID; $smarty->assign('config_value_title',$config_value_title);
	$config_value_intro = 'config_value_intro_'.$_LANG_ID; $smarty->assign('config_value_intro',$config_value_intro); ;
	$config_value_keyword = 'config_value_keyword_'.$_LANG_ID;  $smarty->assign('config_value_keyword',$config_value_keyword);
	
	$linkMeta = $clsISO->getLink($mod);
	$allMeta = $clsMeta->getAll("$config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'];
	$smarty->assign('meta_id',$meta_id);
	#
	$clsInfoSet=new InfoSet();
	$tableName = $clsInfoSet->tbl;
	$pkeyTable = $clsInfoSet->pkey ;
	$oneItem=$clsInfoSet->getAll("module='$mod' limit 0,1");
	$infoset_id=$oneItem[0]['infoset_id'];
	
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $infoset_id);
	$smarty->assign('clsForm',$clsForm);
	$intro = 'intro_'.$_LANG_ID;$smarty->assign('intro',$intro); 
	#
	$clsForm->addInputTextArea("full", $intro, "", $core->get_Lang($intro), 255, 25, 1, 1, "style='width:100%'");
	if(isset($_POST['submit']) && $_POST['submit']=='Update'){
		// Update Meata
		if($_POST[$config_value_title]!=''){
			if($meta_id==''){
				$clsMeta->insertOne("$config_link","'$linkMeta'");
				$allMeta = $clsMeta->getAll("$config_link='$linkMeta'");
				$meta_id = $allMeta[0]['meta_id'];
			}
			$clsMeta->updateOne($meta_id,"$config_value_title='".addslashes($_POST[$config_value_title])."',$config_value_intro='".addslashes($_POST[$config_value_intro])."',$config_value_keyword='".addslashes($_POST[$config_value_keyword])."',reg_date='".time()."',upd_date='".time()."'");
		}
		// Page Info
		if($infoset_id==''){
			$clsInfoSet->insertOne("module,$intro","'$mod','".$_POST['iso-'.$intro]."'");
		}else{
			$clsInfoSet->updateOne($infoset_id,"$intro='".$_POST['iso-'.$intro]."'");
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&message=UpdateSuccess');
		exit();
	}
?>