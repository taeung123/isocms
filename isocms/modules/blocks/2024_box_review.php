<?php
global $smarty,$clsISO,$core,$mod,$act,$clsTable,$tour_id,$voucher_id,$hotel_id,$cruise_id,$URL_JS, $upd_version;

$clsProfile= new Profile();
$clsReviews = new Reviews();
$smarty->assign('clsReviews',$clsReviews);
$clsCountry = new _Country();
$smarty->assign('clsCountry',$clsCountry);
$clsImage = new Image();
$smarty->assign('clsImage',$clsImage);
$type = '';
$table_id = '';

if($tour_id != ''){
    #-- Review Tours
    $type = 'tour';
    $table_id = $tour_id;
    $clsReviews = new Reviews();
    $smarty->assign('clsReviews', $clsReviews);

    $cond = "is_trash = 0 AND is_online = 1 AND table_id = '$tour_id' AND type = 'tour'";
    $cond .= " and profile_id = 0";
    $lstReview = $clsReviews->getAll($cond . " ORDER BY order_no DESC", $clsReviews->pkey . ', profile_id, review_date, table_id, rates, content, fullname');
    $smarty->assign('lstReview', $lstReview);

    unset($lstReview);
}

if($voucher_id!=''){
    #-- Review  Voucher
    $type='voucher';
    $table_id = $voucher_id;
    $clsReviews = new Reviews();
    $smarty->assign('clsReviews',$clsReviews);

    $cond = "is_trash=0 and is_online=1 and table_id = '$voucher_id' and type='voucher'";

    $cond .= " and profile_id = 0 ";
    $lstReview = $clsReviews->getAll($cond." order by order_no DESC",$clsReviews->pkey .',profile_id, review_date,table_id,rates,content,fullname');
    $smarty->assign('lstReview',$lstReview);

    unset($lstReview);
}
if($hotel_id!=''){
    $type='hotel';
    $table_id = $hotel_id;
    $clsReviews = new Reviews();
    $smarty->assign('clsReviews',$clsReviews);

    $cond = "is_trash=0 and is_online=1 and table_id = '$hotel_id' and type='hotel'";

    $cond .= " and profile_id = 0 ";
    $lstReview = $clsReviews->getAll($cond." order by order_no DESC",$clsReviews->pkey .',profile_id, review_date,table_id,rates,content,fullname');
    $smarty->assign('lstReview',$lstReview);
    unset($lstReview);
}
if($cruise_id!=''){
    #-- Review Cruise
    $type='cruise';
    $table_id = $cruise_id;
    $smarty->assign('type',$type);
    $clsReviews = new Reviews();
    $smarty->assign('clsReviews',$clsReviews);

    $cond = "is_trash=0 and is_online=1 and table_id = '$cruise_id' and type='cruise'";

    $cond .= " and profile_id = 0 ";
    $lstReview = $clsReviews->getAll($cond." order by order_no DESC",$clsReviews->pkey .',profile_id, review_date,table_id,rates,content,fullname');
    $smarty->assign('lstReview',$lstReview);

    unset($lstReview);
}

$smarty->assign('type', $type);
$smarty->assign('table_id', $table_id);
#
?>