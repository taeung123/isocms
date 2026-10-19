<?php 
	global $smarty,$clsISO,$core,$mod,$act,$clsTable,$tour_id,$voucher_id,$hotel_id,$cruise_id;
	
	$clsProfile= new Profile();
	$clsReviews = new Reviews();
	$smarty->assign('clsReviews',$clsReviews); 
	$clsCountry = new _Country();
	$smarty->assign('clsCountry',$clsCountry); 
	$clsImage = new Image();
	$smarty->assign('clsImage',$clsImage);
	if($tour_id!=''){
		#-- Review  Tours
		$clsTable = 'Tour'; $smarty->assign('clsTable',$clsTable); 
		$clsReviews = new Reviews();
		$smarty->assign('clsReviews',$clsReviews); 
		
		$cond = "is_trash=0 and is_online=1 and table_id = '$tour_id' and type='$clsTable'";
		
		if(_ISOCMS_CLIENT_LOGIN==1){
			$cond .= " and profile_id > 0 ";
		}else{
			$cond .= " and profile_id = 0 ";
		}
		
		$lstReview = $clsReviews->getAll($cond." order by order_no DESC",$clsReviews->pkey .',profile_id, review_date,table_id,rates,content');
		$smarty->assign('lstReview',$lstReview);
	
		unset($lstReview);
	}
	if($voucher_id!=''){
		#-- Review  Voucher
		$clsTable = 'Voucher'; $smarty->assign('clsTable',$clsTable); 
		$clsReviews = new Reviews();
		$smarty->assign('clsReviews',$clsReviews); 
		
		$cond = "is_trash=0 and is_online=1 and table_id = '$voucher_id' and type='$clsTable'";
		
		if(_ISOCMS_CLIENT_LOGIN==1){
			$cond .= " and profile_id > 0 ";
		}else{
			$cond .= " and profile_id = 0 ";
		}
		$lstReview = $clsReviews->getAll($cond." order by order_no DESC",$clsReviews->pkey .',profile_id, review_date,table_id,rates,content');
		$smarty->assign('lstReview',$lstReview);
		unset($lstReview);
	}
	if($hotel_id!=''){
		#-- Review  Hotel
		$clsTable = 'Hotel'; $smarty->assign('clsTable',$clsTable); 
		$clsReviews = new Reviews();
		$smarty->assign('clsReviews',$clsReviews); 
		
		$cond = "is_trash=0 and is_online=1 and table_id = '$hotel_id' and type='$clsTable'";
		
		if(_ISOCMS_CLIENT_LOGIN==1){
			$cond .= " and profile_id > 0 ";
		}else{
			$cond .= " and profile_id = 0 ";
		}
		$lstReview = $clsReviews->getAll($cond." order by order_no DESC",$clsReviews->pkey .',profile_id, review_date,table_id,rates,content');
		$smarty->assign('lstReview',$lstReview);
		unset($lstReview);
	}
	if($cruise_id!=''){
		#-- Review  Cruise
		$clsTable = 'Cruise'; $smarty->assign('clsTable',$clsTable); 
		$clsReviews = new Reviews();
		$smarty->assign('clsReviews',$clsReviews); 
		
		$cond = "is_trash=0 and is_online=1 and table_id = '$cruise_id' and type='$clsTable'";
		
		if(_ISOCMS_CLIENT_LOGIN==1){
			$cond .= " and profile_id > 0 ";
		}else{
			$cond .= " and profile_id = 0 ";
		}
		$lstReview = $clsReviews->getAll($cond." order by order_no DESC",$clsReviews->pkey .',profile_id, review_date,table_id,rates,content');
		$smarty->assign('lstReview',$lstReview);
		unset($lstReview);
	}
	
	#
?>