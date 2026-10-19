<?php 
	global $mod, $act,$dbconn,$show,$smarty, $core,$extLang,$_lang, $clsISO,$cat_id,$city_id,$country_id,$clsConfiguration,$duration_ID,$price_range_ID, $tour_id;
	#
	$clsTour = new Tour();$smarty->assign('clsTour',$clsTour);
	$clsTourCategory = new TourCategory();$smarty->assign('clsTourCategory',$clsTourCategory);
	$clsTourStartDate = new TourStartDate();$smarty->assign('clsTourStartDate',$clsTourStartDate);
	$clsTourOption = new TourOption();$smarty->assign('clsTourOption',$clsTourOption);
	$clsPriceRange = new PriceRange();$smarty->assign('clsPriceRange',$clsPriceRange);
	$clsProperty = new Property();$smarty->assign('clsProperty',$clsProperty);
	$clsPriceRange=new PriceRange();
	
	$lstTourOption = $clsTour->getOneField('tour_option',$tour_id);
	$lstOption = array();
	if($lstTourOption != '' && $lstTourOption != '0'){
		$lstTourOption = str_replace('||','|',$lstTourOption);
		$lstTourOption = ltrim($lstTourOption,'|');
		$lstTourOption = rtrim($lstTourOption,'|'); 
		$TMP = explode('|',$lstTourOption);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lstOption)){
				$lstOption[] = $TMP[$i];
			}
		}
	}
	$smarty->assign('lstOption',$lstOption);

	
	$lstAdultSizeGroup = $clsTour->getOneField('adult_group_size',$tour_id);
	$lstAdultSize = array();
	if($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0'){
		$lstAdultSizeGroup = str_replace('||','|',$lstAdultSizeGroup);
		$lstAdultSizeGroup = ltrim($lstAdultSizeGroup,'|');
		$lstAdultSizeGroup = rtrim($lstAdultSizeGroup,'|'); 
		$TMP = explode('|',$lstAdultSizeGroup);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lstAdultSize)){
				$lstAdultSize[] = $TMP[$i];
			}
		}
	}
	$smarty->assign('lstAdultSize',$lstAdultSize);
	$lastAdultSize=end($lstAdultSize);
	$max_adult=$clsTourOption->getOneField('number_to',$lastAdultSize);
	$smarty->assign('max_adult',$max_adult);
	
	$lstChildSizeGroup = $clsTour->getOneField('child_group_size',$tour_id);
	$lstChildSize = array();
	if($lstChildSizeGroup != '' && $lstChildSizeGroup != '0'){
		$lstChildSizeGroup = str_replace('||','|',$lstChildSizeGroup);
		$lstChildSizeGroup = ltrim($lstChildSizeGroup,'|');
		$lstChildSizeGroup = rtrim($lstChildSizeGroup,'|'); 
		$TMP = explode('|',$lstChildSizeGroup);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lstChildSize)){
				$lstChildSize[] = $TMP[$i];
			}
		}
	}
	$smarty->assign('lstChildSize',$lstChildSize);

	$lastChildSize=end($lstChildSize);
	$max_child=$clsTourOption->getOneField('number_to',$lastChildSize);
	$smarty->assign('max_child',$max_child);
	
	
	$lstInfantSizeGroup = $clsTour->getOneField('infant_group_size',$tour_id);
	$lstInfantSize = array();
	if($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0'){
		$lstInfantSizeGroup = str_replace('||','|',$lstInfantSizeGroup);
		$lstInfantSizeGroup = ltrim($lstInfantSizeGroup,'|');
		$lstInfantSizeGroup = rtrim($lstInfantSizeGroup,'|'); 
		$TMP = explode('|',$lstInfantSizeGroup);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lstInfantSize)){
				$lstInfantSize[] = $TMP[$i];
			}
		}
	}
	$smarty->assign('lstInfantSize',$lstInfantSize);
	
	$lastInfantSize=end($lstInfantSize);
	$max_infant=$clsTourOption->getOneField('number_to',$lastInfantSize);
	$smarty->assign('max_infant',$max_infant);
	
	
	if(isset($_POST['bookTourDeparture']) && $_POST['bookTourDeparture']=='bookTourDeparture'){
		$arraybookingTour = $_POST;
		vnSessionSetVar('arraybookingTour',$arraybookingTour);
		//print_r($arraybookingTour); die();
		$link=$clsTour->getLinkBookGroup($tour_id);
		header('location: '.$link);
	}
	if(isset($_POST['tailorMadeTour']) && $_POST['tailorMadeTour']=='tailorMadeTour'){
		$arrayTailorTour = $_POST;
		vnSessionSetVar('arrayTailorTour',$arrayTailorTour);
		$link=$clsTour->getLinkCustomize($tour_id);
		header('location: '.$link);
	}
?>