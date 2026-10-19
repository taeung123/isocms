<?php 
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	// End config.
	$clsTour=new Tour(); $assign_list['clsTour']=$clsTour;

	
	
	#--TopTour
	 $sql = "SELECT t1.tour_id,t1.cat_id FROM ".DB_PREFIX."tour t1 INNER JOIN ".DB_PREFIX."tour_store t2 WHERE t1.tour_id = t2.tour_id AND t2._type='HOT' AND t1.is_online=1 AND t1.is_trash=0 ORDER BY t2.order_no DESC limit 0,5";
	$listTourTopHot = $dbconn->GetAll($sql);
	$assign_list['listTourTopHot']=$listTourTopHot;

	 unset($listTourTopHot);
?>