<?php 
	global $smarty,$map_la,$map_lo;
	
	$clsCountryEx=new Country();$smarty->assign('clsCountryEx',$clsCountryEx);
	
	
	$script_location = $clsCountryEx->getLocationMap($country_id);
	$smarty->assign('script_location',$script_location);
?>