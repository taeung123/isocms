<?php

global $core, $smarty,$dbconn,$deviceType;



$clsTourStore = new TourStore();$smarty->assign("clsTourStore",$clsTourStore);

$clsTour = new Tour();$smarty->assign("clsTour",$clsTour);

$clsPagination=new Pagination(); $smarty->assign('clsPagination',$clsPagination);

$clsReviews=new Reviews(); $smarty->assign('clsReviews',$clsReviews);



$cond="is_trash=0 and _type='TOPTOUR' and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE is_trash=0 and is_online=1)";

$orderby=" order by order_no ASC";

if($deviceType == 'phone'){
	$recordPerPage = 8; 
}elseif($deviceType == 'tablet'){
	$recordPerPage = 6; 
}else{
	$recordPerPage = 12; 
}

$currentPage = 1;



$totalRecord = $clsTourStore->getAll($cond,$clsTourStore->pkey);

$totalRecord = $totalRecord?count($totalRecord):0;

$smarty->assign('totalRecord',$totalRecord);
$smarty->assign('recordPerPage',$recordPerPage);



$offset = ($currentPage-1)*$recordPerPage;

$limit = " LIMIT $offset,$recordPerPage";



$listTopTour = $clsTourStore->getAll($cond.$orderby.$limit,$clsTour->pkey);



$smarty->assign('listTopTour',$listTopTour);

unset($listTopTour);



?>