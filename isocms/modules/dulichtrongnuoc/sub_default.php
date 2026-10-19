<?php
function default_default() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act,$clsISO, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain,$deviceType;
	
	$clsCountry = new Country();$assign_list["clsCountry"]=$clsCountry;
	$clsCity = new City();$assign_list["clsCity"] = $clsCity;
	$clsGuide = new Guide();$assign_list["clsGuide"]=$clsGuide;
	$clsGuideCat = new GuideCat();$assign_list["clsGuideCat"]=$clsGuideCat;
	$clsTour = new Tour();$assign_list["clsTour"]=$clsTour;
	$clsTourCategory = new TourCategory();$assign_list["clsTourCategory"]=$clsTourCategory;
	$clsRegion = new Region();$assign_list["clsRegion"]=$clsRegion;
	$clsReview = new Reviews();$assign_list["clsReview"]=$clsReview;
	$clsPagination = new Pagination();$assign_list["clsPagination"]=$clsPagination;
	
	$country_id=1;
	$city_id=392;
	$cond ="is_trash=0 and is_online=1";
	$orderby = " order by order_no asc";
	if($deviceType == 'tablet'){
		$recordPerPage = 1; 
	}
	else{
		$recordPerPage = 2; 
	}
	
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	
	
	$lstGuideCat = $clsGuideCat->getAll($cond.$orderby,$clsGuideCat->pkey);
	$lstTour = $clsTour->getAll($cond." and tour_id in (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE country_id='$country_id' and city_id='$city_id')".$orderby);
	$lstRegion = $clsRegion->getAll($cond." and country_id='$country_id'".$orderby,$clsRegion->pkey);
	$lstCity = $clsCity->getAll($cond." and country_id=1 ".$orderby);
	$lstTourCat =$clsTourCategory->getAll($cond.$orderby);

	$totalTour = count($lstTour);
	$link_page =$clsISO->getLink('dulich');
	$config = array(
		'total'	=> $totalTour,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html','/',$link_page),
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	$totalPage = $clsPagination->getTotalPage();
	
	
	$lstTour = $clsTour->getAll($cond." and tour_id in (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE country_id='$country_id' and city_id='$city_id')".$orderby.$limit);
//	print_r($lstTour);die();
	$listTourAsc = $clsTour->getAll($cond." order by number_day asc",$clsTour->pkey.",number_day");
	$listTourDesc =$clsTour->getAll($cond." order by number_day desc",$clsTour->pkey.",number_day");
	$listpriceAsc = $clsTour->getAll($cond."  order by min_price asc",$clsTour->pkey.",min_price");
	$listpriceDesc = $clsTour->getAll($cond."  order by min_price desc",$clsTour->pkey.",min_price");
	
	$min_duration =$listTourAsc[0]['number_day'];
	$max_duration =$listTourDesc[0]['number_day'];
	$min_price =$listpriceAsc[0]['min_price'];
	$max_price =$listpriceDesc[0]['min_price'];
	$min_duration_search=isset($_GET['min_duration']) ? $_GET['min_duration'] : $min_duration;
	$max_duration_search=isset($_GET['max_duration']) ? $_GET['max_duration'] : $max_duration;	$min_price_search=isset($_GET['min_price']) ? $_GET['min_price'] : $min_price;
	$max_price_search=isset($_GET['max_price']) ? $_GET['max_price'] : $max_price;
	
	
	
	$assign_list["totalTour"]=$totalTour;
	$assign_list["country_id"]=$country_id;
	$assign_list["city_id"]=$city_id;
	$assign_list["lstCity"]=$lstCity;
	$assign_list["lstGuideCat"]=$lstGuideCat;
	$assign_list["lstTour"]=$lstTour;
	$assign_list["lstRegion"]=$lstRegion;
	$assign_list["lstTourCat"]=$lstTourCat;
	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalTour'] = $totalTour;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['page_view'] = $page_view;
	
	$assign_list["min_duration"]=$min_duration;
	$assign_list["max_duration"]=$max_duration;
	$assign_list["min_price"]=$min_price;
	$assign_list["max_price"]=$max_price;
	$assign_list["min_duration_search"]=$min_duration_search;
	$assign_list["max_duration_search"]=$max_duration_search;	
	$assign_list["min_price_search"]=$min_price_search;
	$assign_list["max_price_search"]=$max_price_search;
	

}
function default_listGuide(){
	global $smarty, $assign_list, $_CONFIG,$core, $dbconn, $mod, $act, $_LANG_ID,
	$title_page, $description_page, $keyword_page,$clsISO;
	
	$clsGuide = new Guide();
	$smarty->assign('clsGuide', $clsGuide);
	
	$cat_id = isset( $_POST['cat_id'] )? $_POST['cat_id']:0;
	$country_id = isset( $_POST['country_id'] )? $_POST['country_id']:0;
	$city_id = isset( $_POST['city_id'] )? $_POST['city_id']:0;
	
	$lstGuide=$clsGuide->getAll("is_trash=0 and is_online=1 and cat_id='$cat_id' and country_id='$country_id' and city_id='$city_id' order by order_no asc ");
	$totalRecord = $lstGuide;
	$totalRecord = $totalRecord?count($totalRecord):'0';
	
	$smarty->assign('lstGuide', $lstGuide);
	$smarty->assign('totalRecord', $totalRecord);
	
	$html = $core->build('listGuide.tpl');
	echo $html; die();
}
function default_search(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain,$country_id,$cat_id;
	
	$clsTour = new Tour();$assign_list["clsTour"]=$clsTour;
	$clsReview = new Reviews();$assign_list["clsReview"]=$clsReview;
	$clsCity = new City();$assign_list["clsCity"]=$clsCity;
	$clsTourCategory = new TourCategory();$assign_list["clsTourCategory"]=$clsTourCategory;
	
	
	$listTourAsc = $clsTour->getAll("is_trash=0 and is_online=1 order by number_day asc",$clsTour->pkey.",number_day");
	$listTourDesc =$clsTour->getAll("is_trash=0 and is_online=1 order by number_day desc",$clsTour->pkey.",number_day");
	$listpriceAsc = $clsTour->getAll("is_trash=0 and is_online=1  order by min_price asc",$clsTour->pkey.",min_price");
	$listpriceDesc = $clsTour->getAll("is_trash=0 and is_online=1  order by min_price desc",$clsTour->pkey.",min_price");
	
	$min_duration =$listTourAsc[0]['number_day'];
	$max_duration =$listTourDesc[0]['number_day'];
	$min_price =$listpriceAsc[0]['min_price'];
	$max_price =$listpriceDesc[0]['min_price'];
	$city_id =isset($_GET['city_id']) ? $_GET['city_id'] : '';
	$tourcat_id =isset($_GET['tourcat_id']) ? $_GET['tourcat_id'] : '';
	
	$cond="is_trash=0 and is_online=1";
	$orderBy =" order by order_no asc";
	
	if($min_duration>0 && $max_duration > 0){
		$cond.=" and number_day >='$min_duration' and number_day <='$max_duration'";
		
	}
	elseif($min_duration==0 && $max_duration > 0){
		$cond.=" and number_day <='$max_duration'";
	}
	elseif($min_duration > 0 && $max_duration==0){
		$cond.=" and number_day >='$min_duration'";
	}
	$min_duration_search=isset($_GET['min_duration']) ? $_GET['min_duration'] : $min_duration;
	$max_duration_search=isset($_GET['max_duration']) ? $_GET['max_duration'] : $max_duration;
	$assign_list['min_duration']=$min_duration;
	$assign_list['max_duration']=$max_duration;
	
	$assign_list["min_duration_search"]=$min_duration_search;
	$assign_list["max_duration_search"]=$max_duration_search;	
	
	if($min_price > 0 && $max_price > 0){
		$cond.=" and min_price >='$min_price' and min_price <='$max_price'";
	}
	elseif($min_price==0 && $max_price >0){
		$cond.=" and min_price <='$max_price'";
	}
	elseif($min_price > 0 && $max_price==0){
		$cond.=" and min_price >='$min_price'";
	}
	$assign_list['min_price']=$min_price;
	$assign_list['max_price']=$max_price;
	$min_price_search=isset($_GET['min_price']) ? $_GET['min_price'] : $min_price;
	$max_price_search=isset($_GET['max_price']) ? $_GET['max_price'] : $max_price;
	$assign_list["min_price_search"]=$min_price_search;
	$assign_list["max_price_search"]=$max_price_search;
	
	if($city_id>0){
		$cond.=" and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE is_trash=0 and city_id IN ($city_id))";
		$assign_list["city_id"]=$city_id;
	}
	$lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id='1'".$orderBy);
	$assign_list["lstCity"]=$lstCity;
	
	
	if(!empty($tourcat_id)){
		$cat_ID = explode(',',$tourcat_id);
		$cond.=" and (";
		for($i=0;$i<count($cat_ID);$i++) {
			if($i==0 && count($cat_ID)==1){
				$cond.=" (cat_id='".$cat_ID[$i]."' or list_cat_id like '%|".$cat_ID[$i]."|%')";
			}elseif(count($cat_ID)>1 && $i< (count($cat_ID)-1)){
					$cond.="(cat_id='".$cat_ID[$i]."' or list_cat_id like '%|".$cat_ID[$i]."|%') or ";
			}else{
				$cond.="(cat_id='".$cat_ID[$i]."' or list_cat_id like '%|".$cat_ID[$i]."|%')";
			}
		}
		$cond.=")";
	}
	
	$assign_list["cat_id"] = $tourcat_id;
	$lstTourCat =$clsTourCategory->getAll("is_trash=0 and is_online=1".$orderBy);
	$assign_list["lstTourCat"]=$lstTourCat;
	
	
	$lstTourResult=$clsTour->getAll($cond.$orderBy,$clsTour->pkey);
	$assign_list["lstTourResult"]=$lstTourResult;
	
	$totalTour = count($lstTourResult);
	$assign_list["totalTour"]=$totalTour;
	
	
}
?>