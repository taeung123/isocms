<?php 
	global $smarty,$cruise_itinerary_id,$cruse_id,$show;

	$clsCruiseItinerary=new CruiseItinerary();$smarty->assign('clsCruiseItinerary',$clsCruiseItinerary);
	$clsCruise=new Cruise();$smarty->assign('clsCruise',$clsCruise);
	if($show=='Itinerary'){
		$ret = $clsCruiseItinerary->getLocationMap($cruise_itinerary_id);
	}else{
		$ret = $clsCruise->getLocationMap($cruise_id);
	}
	
	$map_la = $ret['map_la'];
	$map_lo = $ret['map_lo'];
	$script_location = $ret['jscode'];
	$smarty->assign('map_la',$map_la);
	$smarty->assign('map_lo',$map_lo);
	$smarty->assign('script_location',$script_location);
?>