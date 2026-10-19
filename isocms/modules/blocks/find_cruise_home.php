<?php 
	global $mod, $act, $core, $extLang,$cruise_id,$clsISO;
	#
	$clsCity=new City();$smarty->assign('clsCity',$clsCity);
	$clsCruise=new Cruise();$smarty->assign('clsCruise',$clsCruise);
	$clsCruiseItinerary=new CruiseItinerary();$smarty->assign('clsCruiseItinerary',$clsCruiseItinerary);
	$clsCruiseProperty=new CruiseProperty();$smarty->assign('clsCruiseProperty',$clsCruiseProperty);
	$clsCruisePriceRange=new CruisePriceRange();$smarty->assign('clsCruisePriceRange',$clsCruisePriceRange);
	#
	$duration = (isset($_GET['duration']))?$_GET['duration']:'';$smarty->assign('duration',$duration);
	$place = (isset($_GET['place']))?intval($_GET['place']):0;$smarty->assign('place',$place);
	$travel_as = (isset($_GET['travel_as']))?intval($_GET['travel_as']):0;$smarty->assign('travel_as',$travel_as);
	$budget = (isset($_GET['budget']))?intval($_GET['budget']):0;$smarty->assign('budget',$budget);

	$lstItinerary_search = $clsCruiseItinerary->getAll("is_trash=0 and is_online=1 and cruise_id='$cruise_id' order by order_no asc",$clsCruiseItinerary->pkey);
	$smarty->assign('lstItinerary_search',$lstItinerary_search);
	
	$max_adult=$clsCruise->getMaxAdult($cruise_id);
	$smarty->assign('max_adult',$max_adult);
	#
	if(isset($_POST['hidFind']) && $_POST['hidFind']=='hidCruises'){
		$link= $extLang.'/search-cruises/';
		foreach($_POST as $key=>$val){
			if($val!=''){
				$link.=($key=='hidFind')?'':'&'.$key.'='.addslashes($val);
			}
			
		}
		header('location:'.$link);
	}
	unset($clsCountry);unset($clsCity);unset($lstPriceRange);
	
?>