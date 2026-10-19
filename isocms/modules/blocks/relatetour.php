<?php 
	global $core, $smarty, $tour_id,$deviceType,$clsISO,$package_id;
	if($clsISO->getCheckActiveModulePackage($package_id,'tour','tour_related','customize')){
		$clsTour=new Tour(); $smarty->assign('clsTour',$clsTour);
		$clsReviews=new Reviews(); $smarty->assign('clsReviews',$clsReviews);
		$clsTourExtension = new TourExtension();$smarty->assign('clsTourExtension',$clsTourExtension);

		#-- Tour Related
		$lstTourRelated = array();
		$lstTourExtension = $clsTourExtension->getAll("is_trash=0 and tour_1_id='$tour_id' and tour_2_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE is_trash=0 and is_online=1) order by order_no asc", "tour_2_id");
		$lstTourRelated = array();
		if(!empty($lstTourExtension)){
			foreach($lstTourExtension as $item){
				$oneTmp = $clsTour->getOne($item['tour_2_id'],$clsTour->pkey.',slug,title,image,duration_type,duration_custom,number_day,number_night');
				if($tour_id != $item['tour_2_id'])
					$lstTourRelated[] = $oneTmp;
			}
		}
		$smarty->assign('lstTourRelated',$lstTourRelated);
	}
?>