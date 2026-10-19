<?php

global $smarty, $assign_list,$core, $_LANG_ID,$clsISO;

$clsTour=new Tour(); $smarty->assign('clsTour',$clsTour);

$clsPromotion=new Promotion(); $smarty->assign('clsPromotion',$clsPromotion);

$clsPromotionItem=new PromotionItem(); $smarty->assign('clsPromotionItem',$clsPromotionItem);

$clsReviews=new Reviews(); $smarty->assign('clsReviews',$clsReviews);


$listTourOutBound = $clsTour->getAll("is_trash= 0 and is_online=1 and tour_group_id=3 order by order_no asc limit 0,8",$clsTour->pkey.",title,slug,duration_type,duration_custom,number_day,number_night,list_departure_point_id,image");
$smarty->assign('listTourOutBound',$listTourOutBound);
unset($listTourOutBound);


?>