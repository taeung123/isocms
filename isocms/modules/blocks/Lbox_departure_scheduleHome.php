<?php 
	global $smarty,$core,$mod,$act;
	
	$clsTour= new Tour();$smarty->assign('clsTour',$clsTour);
	$clsTourGroup= new TourGroup();$smarty->assign('clsTourGroup',$clsTourGroup);
	$clsTourStartDate = new TourStartDate();$smarty->assign('clsTourStartDate',$clsTourStartDate);

	$lstTourGroup = $clsTourGroup->getAll('is_trash=0 and is_online=1 order by order_no ASC',$clsTourGroup->pkey);
	$smarty->assign('lstTourGroup',$lstTourGroup);
	$tour_group_first_id = $lstTourGroup[0][$clsTourGroup->pkey];
	$smarty->assign('tour_group_first_id',$tour_group_first_id);
	unset($lstTourGroup);

	$lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '".time()."' and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour_store) and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_first_id') order by start_date asc limit 0,20",$clsTourStartDate->pkey.',tour_id');
	$smarty->assign('lstTourStartDate',$lstTourStartDate);

?>