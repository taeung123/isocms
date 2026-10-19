<?php 
	global $smarty,$core,$hasAPI,$clsISO;
	#
	$clsTour=new Tour();$smarty->assign('clsTour',$clsTour);
	$tour_id = isset($_GET['tour_id']) ? $_GET['tour_id'] : '';	$smarty->assign('tour_id',$tour_id);
	//ini_set('display_errors',1);
	if($hasAPI){
		$clsVietISOSDK = new VietISOSDK();		$smarty->assign('clsVietISOSDK',$clsVietISOSDK);
		$info_price = $clsVietISOSDK->getInfoPrice($tour_id);
		$tour_option_id = $clsTour->getOneField('tour_option_id',$tour_id);
		$is_sic = $tour_option_id==1?1:0;	$smarty->assign('is_sic',$is_sic);
		//$clsISO->pre($info_price);die;
		$yieldOp = $info_price['yieldOp'];		$smarty->assign('yieldOp',$yieldOp);
		$yieldPax = $info_price['yieldPax'];	$smarty->assign('yieldPax',$yieldPax);
		if($is_sic){
			$yieldNett = $info_price['yieldNett'];				$smarty->assign('yieldNett',$yieldNett);	
		}else{
			$yieldEstimate = $info_price['yieldEstimate'];				$smarty->assign('yieldEstimate',$yieldEstimate);
		}
		$info_percent_child = $info_price['info_percent_child'];	$smarty->assign('info_percent_child',$info_percent_child);
	}
?>