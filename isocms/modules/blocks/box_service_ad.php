<?php 
	global $smarty,$clsISO,$mod,$assign_list;
	$clsWhy = new Why(); $smarty->assign('clsWhy',$clsWhy);
	$type = "HOME";
	if($mod == 'hotel'){
		$type = "HOTEL";
	}
	if($mod == 'cruise'){
		$type = "CRUISE";
	}
    if($mod == 'tour_new'){
        $type = "TOUR";
    }
	$listWhy=$clsWhy->getAll("is_trash=0 and is_online=1 and type='".$type."' order by order_no ASC",$clsWhy->pkey.',title,image,intro');
	$smarty->assign('listWhy',$listWhy);
	unset($listWhy);
?>