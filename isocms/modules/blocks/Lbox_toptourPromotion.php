<?php

global $smarty, $assign_list, $_CONFIG,$core, $dbconn, $mod, $act, $_LANG_ID,$title_page, $description_page, $keyword_page,$clsISO,$cat_id,$profile_id,$deviceType,$lang_sql;



$clsTour=new Tour(); $smarty->assign('clsTour',$clsTour);

$clsPromotion=new Promotion(); $smarty->assign('clsPromotion',$clsPromotion);

$clsPromotionItem=new PromotionItem(); $smarty->assign('clsPromotionItem',$clsPromotionItem);

$clsPagination=new Pagination(); $smarty->assign('clsPagination',$clsPagination);

$clsTourStore=new TourStore(); $smarty->assign('clsTourStore',$clsTourStore);

$clsReviews=new Reviews(); $smarty->assign('clsReviews',$clsReviews);

$clsProfile= new Profile();



$cond="is_online=1 and clsTable='Tour' and target_id in (SELECT default_tour.tour_id FROM default_tour WHERE is_trash = 0 and is_online = 1 and lang_id='$lang_sql') and ".time()." between start_date and end_date";

if(_ISOCMS_CLIENT_LOGIN){

    $cond1="SELECT pi.taget_id FROM ".$clsPromotion->tbl." p LEFT JOIN ".$clsPromotionItem->tbl." pi ON(p.".$clsPromotion->pkey." = pi.".$clsPromotion->pkey.") WHERE p.is_online = 1 and pi.is_online = 1 ";

    $loggedIn = $clsProfile->isLoggedIn();

    if($loggedIn==1){

        $cond1 .= "";

    }else{

        $cond1 .= " and p.check_mem_set = 0";

    }

    $cond1 .= " and p.type = 'Tour' and pi.taget_id in (SELECT default_tour.tour_id FROM default_tour WHERE is_trash = 0 and is_online = 1 and lang_id='$lang_sql') and ".time()." between  p.start_date and p.end_date ";

}else{

    $cond1="SELECT pi.taget_id FROM ".$clsPromotion->tbl." p LEFT JOIN ".$clsPromotionItem->tbl." pi ON(p.".$clsPromotion->pkey." = pi.".$clsPromotion->pkey.") WHERE p.is_online = 1 and pi.is_online = 1  and p.type = 'Tour' and pi.taget_id in (SELECT default_tour.tour_id FROM default_tour WHERE is_trash = 0 and is_online = 1 and lang_id='$lang_sql') and ".time()." between  p.start_date and p.end_date ";

}



$orderby=" ORDER BY p.end_date ASC";

if($deviceType == 'phone'){
	$recordPerPage = 2; 
}
else{
	$recordPerPage = 8; 
}

$currentPage = isset($_GET['page'])?intval($_GET['page']):1;

$tmp = $dbconn->getAll($cond1);

$totalRecord = !empty($tmp) ? count($tmp) : 0;

$smarty->assign('totalRecord',$totalRecord);
$smarty->assign('recordPerPage',$recordPerPage);



$offset = ($currentPage-1)*$recordPerPage;

$limit = " LIMIT $offset,$recordPerPage";



$listToppromotionnew = $dbconn->GetAll($cond1.$orderby.$limit);

//    $clsISO->print_pre($listToppromotionnew,true);



//	$listTopTourPromotion = $clsPromotion->getAll($cond.$orderby.$limit,$clsPromotion->pkey.",target_id");



$smarty->assign('listTopTourPromotion',$listToppromotionnew);

unset($listToppromotionnew);



?>