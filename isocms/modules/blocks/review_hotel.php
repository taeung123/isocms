<?php 
	global $smarty,$clsISO,$core,$mod,$act,$clsTable,$combo_id;
	
	$clsProfile= new Profile();
	$clsReviews = new Reviews();
	$smarty->assign('clsReviews',$clsReviews); 
	$clsCountry = new _Country();
	$smarty->assign('clsCountry',$clsCountry); 
	$clsImage = new Image();
	$smarty->assign('clsImage',$clsImage);

	$table_id=$combo_id;
	$smarty->assign('table_id',$table_id);

	if(!empty($combo_id)){
		#-- Review  Voucher
		$clsTable = 'Combo'; $smarty->assign('clsTable',$clsTable); 
		$clsReviews = new Reviews();
		$smarty->assign('clsReviews',$clsReviews); 
		
		$cond = "is_trash=0 and is_online=1 and table_id = '$combo_id' and type='$clsTable'";
		
		if(_ISOCMS_CLIENT_LOGIN==1){
			$cond .= " and profile_id > 0";
		}else{
			$cond .= " and profile_id = 0";
		}
		$lstReview = $clsReviews->getAll($cond." order by order_no DESC limit 10",$clsReviews->pkey .',profile_id, review_date,table_id');
		$smarty->assign('lstReview',$lstReview); 
	
		unset($lstReview);
	}
	
	#
?>