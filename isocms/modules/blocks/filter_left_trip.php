<?php 
global $mod,$act,$assign_list, $act,$dbconn,$show,$smarty, $core,$extLang,$_lang,$clsISO,$clsConfiguration,$cat_id,$country_id,$min_duration_value,$max_duration_value,$min_price_value,$max_price_value,$min_duration_search,$max_duration_search,$city_id;
$clsCityStore = new CityStore();
$clsTourCategory = new TourCategory();
$clsCity = new City();
$clsRegion = new Region();
$smarty->assign('clsRegion',$clsRegion);

	//ini_set('display_errors',1);
//error_reporting(E_ALL & ~E_STRICT);//E_ALL
if($country_id >0){
	$lstDeparturePoint = $clsCityStore->getAll("is_trash=0 and type='DEPARTUREPOINT' and country_id='$country_id' and city_id IN (SELECT city_id FROM ".DB_PREFIX."city WHERE is_trash=0 and is_online=1) order by order_no ASC",$clsCityStore->pkey.",city_id");
    
    $lstRegion=$clsRegion->getAll("is_trash=0 and is_online=1 and country_id='$country_id' order by order_no ASC",$clsRegion->pkey.",title,country_id");
    if(!empty($lstRegion)){
        $lstRegionTourByCountry=array();
        $k_new=0;
        foreach($lstRegion as $k=>$v){
            $listCityTourByRegion=$clsCity->getListCityTourByRegion($v['region_id'],'',$v['country_id']);
            if($listCityTourByRegion){
                $lstRegionTourByCountry[$k_new]=$v;
                $lstRegionTourByCountry[$k_new]['listCityTourByRegion']=$listCityTourByRegion;
                $k_new++;
            }
        }
        $smarty->assign('lstRegionTourByCountry',$lstRegionTourByCountry); unset($lstRegionTourByCountry);
    }else{
        $lstCityTour=$clsCity->getListCityTourByCountry($country_id);
        $smarty->assign('lstCityTour',$lstCityTour);
    }
    
}else{
	$lstDeparturePoint = $clsCityStore->getAll("is_trash=0 and type='DEPARTUREPOINT' and city_id IN (SELECT city_id FROM ".DB_PREFIX."city WHERE is_trash=0 and is_online=1) order by order_no ASC",$clsCityStore->pkey.",city_id");
}
$arrCity = [];
foreach($lstDeparturePoint as $key=> $value){
	$arrCityID[] = $value['city_id'];
}
$listCity = $clsCity->getAll(' is_trash=0 and is_online=1 and city_id IN('.implode(',',$arrCityID).')',$clsCity->pkey.',title,slug');
$smarty->assign('listCity',$listCity);

$smarty->assign('lstDeparturePoint',$listCity);

	#
	if(isset($_POST['search_des']) &&  $_POST['search_des']=='search_des'){
        if($act=='searchtour'){
            $link= $clsISO->getLink('search_tour');
            $link.= '?action=search';
        }else{
            if($show=='CatCountry'){
                $link= $clsTourCategory->getLinkCatCountry($cat_id,$country_id);
            }elseif($show=='Category'){
                $link= $clsTourCategory->getLink($cat_id);
            }
            $link.= '?action=search';
        }
		if(!empty($_POST['all'])) {
			$link.=(!empty($_POST['all']))?'&all='.$_POST['all']:'';
		}else{
			$link.=(!empty($_POST['departure_point_id']))?'&departure_point_id='.$clsISO->makeSlashListFromArrayComma($_POST['departure_point_id']):'';
            $link.=(!empty($_POST['tourcat_id']))?'&tourcat_id='.$clsISO->makeSlashListFromArrayComma($_POST['tourcat_id']):'';
			$link.=(!empty($_POST['country_filter_id']))?'&country_filter_id='.$clsISO->makeSlashListFromArrayComma($_POST['country_filter_id']):'';
            $link.=(!empty($_POST['city_filter_id']))?'&city_filter_id='.$clsISO->makeSlashListFromArrayComma($_POST['city_filter_id']):'';
            if($min_duration_value!=$_POST['min_duration']){
                $link.=(!empty($_POST['min_duration']))?'&min_duration='.$_POST['min_duration']:'';
            }
			if($max_duration_value!=$_POST['max_duration']){
                $link.=(!empty($_POST['max_duration']))?'&max_duration='.$_POST['max_duration']:'';
            }
			if($min_price_value!=$_POST['min_price']){
                $link.=(!empty($_POST['min_price']))?'&min_price='.$_POST['min_price']:''; 
            }
			if($max_price_value!=$_POST['max_price']){
			    $link.=(!empty($_POST['max_price']))?'&max_price='.$_POST['max_price']:'';
            }
		}
		header('location:'.trim($link));
		exit();
	}
?>