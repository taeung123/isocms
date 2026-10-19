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
		$type='tour';
		$smarty->assign('type',$type); 
		$clsReviews = new Reviews();
		$smarty->assign('clsReviews',$clsReviews); 
		
		$cond = "is_trash=0 and is_online=1 and table_id = '$tour_id' and type='tour'";
		
		$cond .= " and profile_id = 0 ";
		
		$lstReview = $clsReviews->getAll($cond." order by order_no DESC",$clsReviews->pkey .',profile_id, review_date,table_id,rates,content,fullname');
		$smarty->assign('lstReview',$lstReview);
	
		unset($lstReview);
	}
	if($voucher_id!=''){
		#-- Review  Voucher
		$type='voucher';
		$smarty->assign('type',$type); 
		$clsReviews = new Reviews();
		$smarty->assign('clsReviews',$clsReviews); 
		
		$cond = "is_trash=0 and is_online=1 and table_id = '$voucher_id' and type='voucher'";
		
		$cond .= " and profile_id = 0 ";
		$lstReview = $clsReviews->getAll($cond." order by order_no DESC",$clsReviews->pkey .',profile_id, review_date,table_id,rates,content,fullname');
		$smarty->assign('lstReview',$lstReview); 
	
		unset($lstReview);
	}
	if($hotel_id!=''){
		#-- Review  Voucher
		$type='hotel';
		$smarty->assign('type',$type); 
		$clsReviews = new Reviews();
		$smarty->assign('clsReviews',$clsReviews); 
		
		$cond = "is_trash=0 and is_online=1 and table_id = '$hotel_id' and type='hotel'";
		
		$cond .= " and profile_id = 0 ";
		$lstReview = $clsReviews->getAll($cond." order by order_no DESC",$clsReviews->pkey .',profile_id, review_date,table_id,rates,content,fullname');
		$smarty->assign('lstReview',$lstReview); 
	var_dump($lstReview);die;
		unset($lstReview);
	}
	if($cruise_id!=''){
		#-- Review  Voucher
		$type='cruise';
		$smarty->assign('type',$type); 
		$clsReviews = new Reviews();
		$smarty->assign('clsReviews',$clsReviews); 
		
		$cond = "is_trash=0 and is_online=1 and table_id = '$cruise_id' and type='cruise'";
		
		$cond .= " and profile_id = 0 ";
		$lstReview = $clsReviews->getAll($cond." order by order_no DESC",$clsReviews->pkey .',profile_id, review_date,table_id,rates,content,fullname');
		$smarty->assign('lstReview',$lstReview); 
	
		unset($lstReview);
	}
	
	#
?>