/* Update Intro */
	$clsCommon=new Common();
	$pvalTable = '1';
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($clsCommon->tbl, $clsCommon->pkey, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#
	$oneItem = $clsCommon->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;	
	$clsForm->addInputTextArea("full","hotel_intro", "", "hotel_intro", 255, 25, 2, 1,  "style='width:100%'");
	if(isset($_POST['submit']) && $_POST['submit'] =='UpdateNote'){		
		$value = ""; $firstAdd = 0;
		foreach($_POST as $key=>$val){
			$tmp = explode('-',$key);
			if($tmp[0]=='iso'){
				if($firstAdd==0){
					$value .= $tmp[1]."='".addslashes($val)."'";
					$firstAdd = 1;
				}
				else{
					$value .= ",".$tmp[1]."='".addslashes($val)."'";
				}
			}
		}
		if($clsCommon->updateOne($pvalTable,$value)){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&message=UpdateSuccess');			
		}
		else{
			header('location: '.PCMS_URL.'/?mod='.$mod.'&message=updateFailed');	
		}
	}
	/* End Update Intro */