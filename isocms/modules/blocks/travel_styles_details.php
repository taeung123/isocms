<?php 
	global $core, $smarty;
	#
	$clsTourCategory = new TourCategory();
	$smarty->assign('clsTourCategory',$clsTourCategory);
	#
	$cat_id = isset($_GET['cat_id'])?intval($_GET['cat_id']):0;
	$smarty->assign('cat_id',$cat_id);
	
	$sql= "is_trash=0 and parent_id='$cat_id' and is_online=1";
	$lstToursCategory = $clsTourCategory->getAll($sql." order by order_no desc", $clsTourCategory->pkey);
	if($lstToursCategory[0][$clsTourCategory->pkey]==''){
		$parentID = $clsTourCategory->getOneField('parent_id',$cat_id);
		$sql= "is_trash=0 and parent_id='$parentID' and is_online=1";
		$lstToursCategory = $clsTourCategory->getAll($sql." order by order_no desc", $clsTourCategory->pkey);
	}
	$smarty->assign('lstToursCategory',$lstToursCategory);
	$smarty->assign('parentID',$parentID);
	#	
	unset($lstToursCategory);
	unset($clsTourCategory);
?>