<?php 
	global $smarty, $mod, $act,$tour_id;
	
	
	$clsTour = new Tour();
	$smarty->assign('clsTour', $clsTour);
	$clsTourExtension = new TourExtension();
	$smarty->assign('clsTourExtension', $clsTourExtension);
	
	$lstTourRelated = array();
	$lstTourExtension = $clsTourExtension->getAll("is_trash=0 and tour_1_id='$tour_id' and tour_2_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE is_trash=0 and is_online=1) order by order_no asc", "tour_2_id");
	foreach($lstTourExtension as $item){
		$oneTmp = $clsTour->getOne($item['tour_2_id']);
		if($tour_id != $item['tour_2_id'])
			$lstTourRelated[] = $oneTmp;
	}
	$smarty->assign('lstTourRelated', $lstTourRelated);

?>