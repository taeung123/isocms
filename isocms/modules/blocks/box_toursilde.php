<?php 
	global $core, $smarty,$dbconn;
    
    $clsTour=new Tour();
    $assign_list['clsTour']=$clsTour;
	#
	$sql = "SELECT t1.tour_id,t1.cat_id FROM ".DB_PREFIX."tour t1 INNER JOIN ".DB_PREFIX."tour_store t2 WHERE t1.tour_id = t2.tour_id AND t2._type='PROMOTION' AND t1.is_online=1 AND t1.is_trash=0 ORDER BY t2.order_no DESC limit 0,6";
	$lstTourOfferHomeDB = $dbconn->GetAll($sql);
    $lstTourOfferHome=array();
    $numTourOfferHome=count($lstTourOfferHomeDB);
    if(is_array($lstTourOfferHomeDB) && $numTourOfferHome > 0){
		for($i=1; $i<$numTourOfferHome; $i++){
			$lstTourOfferHome[] = array(
				'title'	=> $clsTour->getTitle($lstTourOfferHomeDB[$i][$clsTour->pkey],$lstTourOfferHomeDB[$i]),
				'link'	=> $clsTour->getLink($lstTourOfferHomeDB[$i][$clsTour->pkey],$lstTourOfferHomeDB[$i]),
				'intro'	=> $clsTour->getIntro($lstTourOfferHomeDB[$i][$clsTour->pkey],$lstTourOfferHomeDB[$i]),
				'image'	=> $clsTour->getImage($lstTourOfferHomeDB[$i][$clsTour->pkey],800,600,$lstTourOfferHomeDB[$i]),
				$clsTour->pkey => $lstTourOfferHomeDB[$i][$clsTour->pkey]
			);
		}
		
		unset($lstTourOfferHomeDB);
	}
	$assign_list['lstTourOfferHome']=$lstTourOfferHome; 

	unset($lstTourOfferHome);
 
	
	
	
?>