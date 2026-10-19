<?php
	global $smarty,$core, $mod, $act, $_LANG_ID,$clsISO;
	$clsInfoSet=new InfoSet();$smarty->assign('clsInfoSet',$clsInfoSet);
	$tableName = $clsInfoSet->tbl;
	$pkeyTable = $clsInfoSet->pkey ;
	$clsISO = new ISO();
	#
	$domain_id = (isset($_GET['domain_id']) && intval($_GET['domain_id'])>0)?$_GET['domain_id']: $clsISO->getFirstIdInDomain();
	$smarty->assign('domain_id',$domain_id);
	if($act=='default'){
		$all=$clsInfoSet->getAll("mod_page='$mod' and domain_id='$domain_id' limit 0,1");
	}else{
		$all=$clsInfoSet->getAll("mod_page='$mod' and act_page='$act' and domain_id='$domain_id' limit 0,1");
	}
	#
	$infoset_id=$all[0]['infoset_id'];
	$smarty->assign('infoset_id',$infoset_id);
	$oneItem = $clsInfoSet->getOne($infoset_id);
	$smarty->assign('oneItem',$oneItem);
	#
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $infoset_id);
	$smarty->assign('clsForm',$clsForm);
	#
	$intro='intro_'.$_LANG_ID;
	$smarty->assign('intro',$intro);
	$clsForm->addInputTextArea("full",$intro,"",$core->get_Lang($intro), 255, 25, 2, 1, "style='width:100%'");
	#
	if(isset($_POST['commit'])){
		if(intval($infoset_id)==0){
			$f = "mod_page,act_page,$intro,domain_id";
			$v = "'$mod','$act','".$_POST['iso-'.$intro]."','$domain_id'";
			#--Special Field: image
			$up = '';
			if(is_uploaded_file($_FILES['image']['tmp_name'])){
				$clsUploadFile = new UploadFile();
				$up = $clsUploadFile->uploadItem($_FILES["image"],"/content","jpg,gif,png");
			}
			if($up!=''&&$up!='0'){
				$f .= ',image';
				$v .= ",'".addslashes($up)."'";
			}
			$clsInfoSet->insertOne($f,$v);
		}else{
			$set = "$intro='".addslashes($_POST['iso-'.$intro])."',domain_id='$domain_id'";
			$up = '';
			if(is_uploaded_file($_FILES['image']['tmp_name'])){
				$clsUploadFile = new UploadFile();
				$up = $clsUploadFile->uploadItem($_FILES["image"],"/content","jpg,gif,png");
			}
			if($up!=''&&$up!='0'){
				$set .= ",image='".addslashes($up)."'";
			}
			$clsInfoSet->updateOne($infoset_id,$set);
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&domain_id='.$domain_id.'&message=UpdateSuccess');
		unset($_POST['commit']);
	}
	unset($clsInfoSet);
	unset($tableName);
	unset($pkeyTable);
	unset($clsForm)
?>