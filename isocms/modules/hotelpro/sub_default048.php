<?php

/**
 *  Defautl action
 *  @author		: Technical Group (technical@aboutpro.com)
  @modifier    : Luong Tien Dung (info@vietiso.com)
 *  @date		: 2009/10/01
  @date-modify : 2009/01/06
 *  @version		: 3.0.0
 */
function default_default() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;
   	#
	$clsCountryEx = new Country();$assign_list['clsCountryEx'] = $clsCountryEx;
	$clsCity = new City();$assign_list['clsCity'] = $clsCity;
	$clsHotel = new Hotel();$assign_list['clsHotel'] = $clsHotel;
	
	$clsPagination = new Pagination();
	$country_id = $clsCountryEx->getBySlug($slug_country);
    if(intval($country_id)==0) {
        header('location:'.PCMS_URL.$extLang);
		exit();
    }
    $assign_list['country_id'] = $country_id;
	#
	$recordPerPage = 12;
	$currentPage = isset($_GET['page'])?intval($_GET['page']):1;
	
	$cond = "is_trash=0 and is_online=1";
	$order_by = " ORDER BY order_no DESC";
	$totalRecord = $clsHotel->countItem($cond);
	#
	$link_page = $clsCountryEx->getLink($country_id,'Hotel');
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html','/',$link_page),
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);
	
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	
	$listHotel = $clsHotel->getAll($cond.$order_by.$limit,$clsHotel->pkey.',star_id');
	$assign_list['listHotel'] = $listHotel; unset($listHotel);
	$assign_list['totalPage'] = $clsPagination->getTotalPage();
	
	$assign_list['page_view'] = $page_view; unset($page_view);
	
    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('hotelsresorts').' - '.PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $core->get_Lang('hotelsresorts').' - '.PAGE_NAME;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $core->get_Lang('hotelsresorts').' - '.PAGE_NAME;
    $assign_list["keyword_page"] = $keyword_page;
}
function default_place() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$city_id;
	global $clsISO;
    #
	$clsCity=new City(); $assign_list["clsCity"] = $clsCity;
	$clsTour = new Tour(); $assign_list['clsTour'] = $clsTour;
	$clsHotel=new Hotel();$assign_list['clsHotel']=$clsHotel;
	$clsGuide=new Guide(); $assign_list["clsGuide"] = $clsGuide;
	$clsGuideCat = new GuideCat(); $assign_list["clsGuideCat"] = $clsGuideCat;
	$clsGuideCatStore = new GuideCatStore(); 
	$assign_list["clsGuideCatStore"] = $clsGuideCatStore;
	$clsProperty=new Property(); $assign_list['clsProperty']=$clsProperty;
	$clsAreaCity=new AreaCity(); $assign_list['clsAreaCity']=$clsAreaCity;
	$clsPriceRange=new PriceRange();$assign_list['clsPriceRange']=$clsPriceRange;
	$clsProperty=new Property(); $assign_list['clsProperty']=$clsProperty;
    #
	
	$sort = isset($_GET['sort'])?$_GET['sort']:'';
	
	$clsPagination = new Pagination();
	$slug_city = $_GET['slug_city'];
	//print_r($slug_city); die();
	$all = $clsCity->getAll("is_trash=0 and is_online=1 and slug='$slug_city' LIMIT 0,1");
	$city_id = $all[0][$clsCity->pkey];
	if(intval($city_id)==0){
		header('Location:/');
		exit();
	}
	$assign_list['city_id']=$city_id;

	$one = $clsCity->getOne($city_id);
	
	$recordPerPage =8;
	$currentPage = isset($_GET['page'])?intval($_GET['page']):1;
	
	$cond = "is_trash=0 and is_online=1 and city_id='$city_id'";
	$order_by = " ORDER BY order_no DESC";
	
	if(isset($sort) && !empty($sort)) {
		switch($sort){
			case 'a-z':
				$order_by = " order by slug asc";
				break;
			case 'name':
				$order_by = " order by slug asc";
				break;
			case 'price':
				$order_by = " order by price desc";
				break;
			case 'rank':
				$order_by = " order by star_id desc";
				break;
			default:
				$order_by = " order by order_no desc";
		}
	}
	
	$totalRecord = $clsHotel->countItem($cond);
	
	#
	$link_page = $clsCity->getLink($city_id,'hotel');
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html','/',$link_page),
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);
	
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	
	
	$listHotelCity=$clsHotel->getAll($cond.$order_by.$limit,$clsHotel->pkey.',star_id');
	$assign_list['listHotelCity'] = $listHotelCity; 
	
	$assign_list['totalPage'] = $clsPagination->getTotalPage();
	$assign_list['page_view'] = $page_view; unset($page_view);

	unset($listHotelCity);
	
	$listGuideByCity = $clsGuide->getAll("is_trash=0 and is_online=1 and city_id='$city_id' and cat_id='$guidecat_id'");
	$assign_list['listGuideByCity'] = $listGuideByCity; 
	unset($listGuideByCity);
	
	#area_city
	$lstCityAreaHotel=$clsAreaCity->getAll("is_trash=0 and is_online=1 and city_id='$city_id'");
	$assign_list['lstCityAreaHotel'] = $lstCityAreaHotel; 
	unset($lstCityAreaHotel);
	
	#price_range
	$lstPriceRangeSearch=$clsPriceRange->getAll("is_trash=0 order by order_no");
	$assign_list['lstPriceRangeSearch'] = $lstPriceRangeSearch; 
	unset($lstPriceRangeSearch);
	
	#star
	$star=array();
	for($i=1;$i<6;$i++){
		if($i<6){
			$star[]=$i;
		}
	}
	$assign_list['star']=$star;
	
	#hotel_pacility
	$listHotelFacility = $clsProperty->getAll("is_trash=0 and type='HotelFacilities'");
	$assign_list['listHotelFacility']=$listHotelFacility; 
	unset($listHotelFacility);
	
	$listTopCity = $clsCity->getAll("is_trash=0 and country_id='1' and city_id <>'$city_id' and city_id IN (SELECT city_id FROM ".DB_PREFIX."citystore WHERE country_id='1' and type='TOP' order by order_no ASC) and city_id IN (SELECT city_id FROM ".DB_PREFIX."hotel WHERE country_id='1')", $clsCity->pkey);
	$assign_list['listTopCity']=$listTopCity;
	//print_r($listTopCity); die();
	 unset($listTopCity);
	
    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('Hotels').' in '.$clsCity->getTitle($city_id).' | '.PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = PAGE_NAME;
    $assign_list["description_page"] = $description_page;
    $keyword_page = PAGE_NAME;
    $assign_list["keyword_page"] = $keyword_page;
}
function default_search(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain;
	#
	$show = isset($_GET['show'])?$_GET['show']:''; $assign_list["show"] = $show;

	$sort = isset($_GET['sort'])?$_GET['sort']:''; $assign_list["sort"] = $sort;
	$mode = vnSessionGetVar('_VIEWMODE_'.$mod.'_'.$act) != '' ? vnSessionGetVar('_VIEWMODE_'.$mod.'_'.$act): 'list';
	$assign_list["mode"] = $mode;
	$sortType = vnSessionGetVar('_SORT_TYPE') != '' ? vnSessionGetVar('_SORT_TYPE'): '';$assign_list["sortType"] = $sortType;
	$sortVal = vnSessionGetVar('_SORT_VAL') != '' ? vnSessionGetVar('_SORT_VAL'): '';$assign_list["sortVal"] = $sortVal;
	#
	$clsHotel=new Hotel();$assign_list["clsHotel"] = $clsHotel;
	$clsCountry=new Country();$assign_list["clsCountry"] = $clsCountry;
	$clsCity=new City();$assign_list['clsCity']=$clsCity;
	$clsAreaCity=new AreaCity(); $assign_list['clsAreaCity']=$clsAreaCity;
	$clsPriceRange=new PriceRange();$assign_list['clsPriceRange']=$clsPriceRange;
	$clsProperty=new Property();$assign_list['clsProperty']=$clsProperty;
	#
	if($show=='city'){
	$country_id=(isset($_GET['country_id']) && $_GET['country_id']!='')?$_GET['country_id']:'';
	$slug_city = $_GET['slug_city'];
	$all = $clsCity->getAll("is_trash=0 and is_online=1 and slug='$slug_city' LIMIT 0,1");
	$city_id = $all[0][$clsCity->pkey];
	if(intval($city_id)==0){
	header('Location:/');
	exit();
	}
	$assign_list['city_id']=$city_id;

	#areaCity
	$lstCityAreaHotel=$clsAreaCity->getAll("is_trash=0 and is_online=1 and city_id='$city_id'");
	$assign_list['lstCityAreaHotel'] = $lstCityAreaHotel; 
	unset($lstCityAreaHotel);
	
	#price_range
	$lstPriceRangeSearch=$clsPriceRange->getAll("is_trash=0 order by order_no");
	$assign_list['lstPriceRangeSearch'] = $lstPriceRangeSearch; 
	unset($lstPriceRangeSearch);
	
	#star
	$star=array();
	for($i=1;$i<6;$i++){
		if($i<6){
			$star[]=$i;
		}
	}
	$assign_list['star']=$star;
	
	#hotel_pacility
	$listHotelFacility = $clsProperty->getAll("is_trash=0 and type='HotelFacilities'");
	$assign_list['listHotelFacility']=$listHotelFacility; 
	unset($listHotelFacility);
	
	$area_city_id=(isset($_GET['area_city_id']) && $_GET['area_city_id']!='')?$_GET['area_city_id']:'';
	$price_range_id=(isset($_GET['price_range_id']) && $_GET['price_range_id']!='')?$_GET['price_range_id']:'';
	$star_id=(isset($_GET['star_id']) && $_GET['star_id']!='')?$_GET['star_id']:'';
	$property_id=(isset($_GET['property_id']) && $_GET['property_id']!='')?$_GET['property_id']:'';
	
	//print_r($star_id); die();
	$keyword=(isset($_GET['key']) && !empty($_GET['key']))?$_GET['key']:'';
	#
	$sql = "SELECT DISTINCT t1.city_id FROM ".DB_PREFIX."city t1 INNER JOIN ".DB_PREFIX."hotel t2 WHERE t1.city_id = t2.city_id AND t2.country_id = '$country_id' AND t2.is_trash=0 AND t2.is_online=1 ORDER BY t1.slug ASC";
	$rslCity = $dbconn->GetAll($sql);
	$assign_list['rslCity']=$rslCity; unset($rslCity);	
	$cond="is_trash=0";
	if(intval($country_id) > 0){
		$cond.=" and country_id='$country_id'";
		$assign_list["country_id"] = $country_id;
	}
	if(intval($city_id) > 0){
		$cond.=" and city_id='$city_id'";
		$assign_list["city_id"] = $city_id;
	}
	if(intval($area_city_id) > 0){
		$cond.=" and area_city_id =$area_city_id";
		$assign_list["area_city_id"] = $area_city_id;
	}
	if(intval($star_id) > 0){
		$cond.=" and star_id IN ($star_id)";
		$assign_list["star_id"] = $star_id;
	}
	
	if(intval($property_id) > 0){
		$cond.=" and list_HotelFacilities like '%|$property_id|%'";
		$assign_list["property_id"] = $property_id;
	}
	if(intval($price_range_id) > 0){
		$clsPriceRange=new PriceRange();
		$oneTmp=$clsPriceRange->getOne($price_range_id);
		$min_rate=intval($oneTmp['min_rate']);
		$max_rate=($oneTmp['max_rate']);
		
		if($min_rate==0 && $max_rate>0){
			$cond.=" and price < '$max_rate'";
		}
		elseif($min_rate>0 && $max_rate==0){
			$cond.=" and price > ".$min_rate;
		}
		else{
			$cond.=" and price > '$min_rate' and price < '$max_rate'";
		}
		$assign_list["price_range_id"] = $price_range_id;
	}
	if($keyword!=''){
		$cond.=" and (title like '$keyword' or slug like '%".$core->replaceSpace($keyword)."%')";
		$assign_list["keyword"] = $keyword;
	}
	#
	$order_by = "order by order_no desc";
	if(isset($sort) && !empty($sort)) {
		switch($sort){
			case 'a-z':
				$order_by = "order by slug asc";
				break;
			case 'name':
				$order_by = "order by slug asc";
				break;
			case 'price':
				$order_by = "order by price asc";
				break;
			case 'star':
				$order_by = "order by star_id asc";
				break;
			default:
				$order_by = "order by order_no desc";
		}
	}
	#
	if(isset($sortType) && !empty($sortType)) {
		if($sortType == 'DEFAULT') {
			if(isset($sortVal) && !empty($sortVal)) {
				switch($sortVal){
					case 'NAME':
						$order_by = "order by slug asc";
						break;
					case 'PRICE':
						$order_by = "order by price asc";
						break;
					case 'RANK':
						$order_by = "order by star_id asc";
						break;
					default:
						$order_by = "order by order_no desc";
				}
			}
		}
		if($sortType == 'CITY') {
			if(isset($sortVal) && !empty($sortVal)) {
				$cond.= " and city_id = '$sortVal'";
			}
		}
	}
	}else{
		$country_id=(isset($_GET['country_id']) && $_GET['country_id']!='')?$_GET['country_id']:'';
		$city_id=(isset($_GET['city_id']) && $_GET['city_id']!='')?$_GET['city_id']:'';
		$star_id=(isset($_GET['star_id']) && $_GET['star_id']!='')?$_GET['star_id']:'';
		$price_range=(isset($_GET['price_range']) && $_GET['price_range']!='')?$_GET['price_range']:'';
		$keyword=(isset($_GET['key']) && !empty($_GET['key']))?$_GET['key']:'';
		#
		$sql = "SELECT DISTINCT t1.city_id FROM ".DB_PREFIX."city t1 INNER JOIN ".DB_PREFIX."hotel t2 WHERE t1.city_id = t2.city_id AND t2.country_id = '$country_id' AND t2.is_trash=0 AND t2.is_online=1 ORDER BY t1.slug ASC";
		$rslCity = $dbconn->GetAll($sql);
		$assign_list['rslCity']=$rslCity; unset($rslCity);	
		$cond="is_trash=0";
		if(intval($country_id) > 0){
			$cond.=" and country_id='$country_id'";
			$assign_list["country_id"] = $country_id;
		}
		if(intval($city_id) > 0){
			$cond.=" and city_id='$city_id'";
			$assign_list["city_id"] = $city_id;
		}
		if(intval($star_id) > 0){
			$cond.=" and star_id='$star_id'";
			$assign_list["star_id"] = $star_id;
		}
		if(intval($price_range) > 0){
			$clsPriceRange=new PriceRange();
			$oneTmp=$clsPriceRange->getOne($price_range);
			$min_rate=intval($oneTmp['min_rate']);
			$max_rate=($oneTmp['max_rate']);
			
			if($min_rate==0 && $max_rate>0){
				$cond.=" and price < '$max_rate'";
			}
			elseif($min_rate>0 && $max_rate==0){
				$cond.=" and price > ".$min_rate;
			}
			else{
				$cond.=" and price > '$min_rate' and price < '$max_rate'";
			}
			$assign_list["price_range"] = $price_range;
		}
		if($keyword!=''){
			$cond.=" and (title like '$keyword' or slug like '%".$core->replaceSpace($keyword)."%')";
			$assign_list["keyword"] = $keyword;
		}
		#
		$order_by = "order by order_no desc";
		if(isset($sort) && !empty($sort)) {
			switch($sort){
				case 'a-z':
					$order_by = "order by slug asc";
					break;
				case 'name':
					$order_by = "order by slug asc";
					break;
				case 'price':
					$order_by = "order by price asc";
					break;
				case 'star':
					$order_by = "order by star_id asc";
					break;
				default:
					$order_by = "order by order_no desc";
			}
		}
		#
		if(isset($sortType) && !empty($sortType)) {
			if($sortType == 'DEFAULT') {
				if(isset($sortVal) && !empty($sortVal)) {
					switch($sortVal){
						case 'NAME':
							$order_by = "order by slug asc";
							break;
						case 'PRICE':
							$order_by = "order by price asc";
							break;
						case 'RANK':
							$order_by = "order by star_id asc";
							break;
						default:
							$order_by = "order by order_no desc";
					}
				}
			}
			if($sortType == 'CITY') {
				if(isset($sortVal) && !empty($sortVal)) {
					$cond.= " and city_id = '$sortVal'";
				}
			}
		}
	}
	#
	
	$totalRecord = $clsHotel->countItem($cond);
	$assign_list['totalRecord']= $totalRecord;
	$totalPage = ceil($totalRecord/$recordPerPage);
	$assign_list['totalPage'] = $totalPage;
	#
    $listHotel = $clsHotel->getAll($cond.$order_by);
    $assign_list['listHotel'] = $listHotel;

	 unset($listHotel);
	
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('resultsearch').' - '.PAGE_NAME ;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('resultsearch').' - '.PAGE_NAME ;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('resultsearch').' - '.PAGE_NAME ;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/	
	unset($clsHotel);		
}
function default_detail() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act,$_LANG_ID,$title_page,$description_page,$keyword_page;
	global $country_id;
	#
	$show = isset($_GET['show'])?$_GET['show']:'';
	$assign_list['show']=$show;
	#
	$clsHotel=new Hotel(); $assign_list['clsHotel']=$clsHotel;
	$clsTour=new Tour(); $assign_list['clsTour']=$clsTour;
	$clsProperty=new Property(); $assign_list['clsProperty']=$clsProperty;
	$clsCountryEx=new Country(); $assign_list['clsCountryEx']=$clsCountryEx;
	$clsCity=new City(); $assign_list['clsCity']=$clsCity;
	$clsHotelImage=new HotelImage(); $assign_list['clsHotelImage']=$clsHotelImage;
	$clsHotelRoom=new HotelRoom(); $assign_list['clsHotelRoom']=$clsHotelRoom;
	$clsHotelPriceCol=new HotelPriceCol(); $assign_list['clsHotelPriceCol']=$clsHotelPriceCol;
	$clsHotelPriceVal=new HotelPriceVal(); $assign_list['clsHotelPriceVal']=$clsHotelPriceVal;
	$clsHotelAttraction=new HotelAttraction(); $assign_list['$clsHotelAttraction']=$clsHotelAttraction;
	$clsAreaCity=new AreaCity(); $assign_list['clsAreaCity']=$clsAreaCity;
    $clsAttraction=new Attraction(); $assign_list['clsAttraction']=$clsAttraction;
	#
	$hotel_id = intval($_GET['hotel_id']);
	if(intval($hotel_id)==0 && $clsHotel->checkExitsId($hotel_id) == '0') {
		header('location:'.PCMS_URL.$extLang.'/');
		exit();
	}
	$assign_list['hotel_id']=$hotel_id;
	$oneItem = $clsHotel->getOne($hotel_id);
	$assign_list['oneItem']=$oneItem;
	$city_id=$oneItem['city_id'];
	$assign_list['city_id']=$city_id;
	
	#-- Hotel Images
	$listImage = $clsHotelImage->getAll("is_trash=0 and table_id='$hotel_id' and image <> ''",$clsHotelImage->pkey.',image');
	$assign_list['listImage'] = $listImage;
	 unset($listImage);
	#-- Hotel Rooms
	$lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no desc");
	$assign_list['lstHotelRoom']=$lstHotelRoom;unset($lstHotelRoom);
	#-- Hotel Price Col
	$lstCol = $clsHotelPriceCol->getAll("is_trash=0 and hotel_id = '$hotel_id' order by order_no asc");
	$assign_list['lstCol'] = $lstCol;$assign_list['total_col'] = count($lstCol);unset($lstCol);
	
	#list all Room and hotel Facilities
	$list_HotelFacilities = $oneItem['list_HotelFacilities'];
	$lstFacility = array();
	if($list_HotelFacilities != '' && $list_HotelFacilities != '0'){
		$list_HotelFacilities = str_replace('||','|',$list_HotelFacilities);
		$list_HotelFacilities = ltrim($list_HotelFacilities,'|');
		$list_HotelFacilities = rtrim($list_HotelFacilities,'|'); 
		$TMP = explode('|',$list_HotelFacilities);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lstFacility)){
				$lstFacility[] = $TMP[$i];
			}
		}
	}
	$assign_list['lstFacility']=$lstFacility; 
	//print_r($lstFacility); die(); 
	unset($lstFacility);
	
	#list all Room and hotel Attraction
	$list_HotelAttraction = $oneItem['list_attraction'];
	$lstHotelAttraction = array();
	if($list_HotelAttraction != '' && $list_HotelAttraction != '0'){
		$list_HotelAttraction = str_replace('||','|',$list_HotelAttraction);
		$list_HotelAttraction = ltrim($list_HotelAttraction,'|');
		$list_HotelAttraction = rtrim($list_HotelAttraction,'|'); 
		$TMP = explode('|',$list_HotelAttraction);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lstHotelAttraction)){
				$lstHotelAttraction[] = $TMP[$i];
			}
		}
	}
	$assign_list['lstHotelAttraction']=$lstHotelAttraction;
    //print_r($lstHotelAttraction); die();
     unset($lstHotelAttraction);
	
	#attraction
	$Html = '';
    $lstItem = $clsAttraction->getAll("is_trash=0 order by order_no DESC");
    $listHotelAttraction = $clsHotelAttraction->getAll("hotel_id='$pvalTable' and fieldvalue<>'' order by order_no ASC");
    if (is_array($lstItem) && count($lstItem)> 0) {
        foreach ($lstItem as $k => $v) {
            $t=$k+1;
            if($clsHotelAttraction->getTitle($hotel_id.$t)){
            $Html.='<h3><a href="'.$clsAttraction->getLink($v[$clsAttraction->pkey]).'">'.$clsAttraction->getTitle($v[$clsAttraction->pkey]).'</a><span>'.$clsHotelAttraction->getTitle($hotel_id.$t).'</span>
            </h3>';
            }
        }
    }
    sleep(1);
    $assign_list['Html'] = $Html;
	
	#-- Tour City
	$lstTourCity = $clsTour->getAll("is_trash=0 and is_online=1 and departure_point_id='$city_id' and departure_point_id IN (SELECT city_id FROM ".DB_PREFIX."citystore WHERE is_trash=0) order by order_no desc limit 0,5",$clsTour->pkey);
	$assign_list['lstTourCity'] = $lstTourCity; 
	unset($lstTourCity);
	
	
	#- Update Custom Field
	$clsHotelCustomField = new HotelCustomField();
	$assign_list["clsHotelCustomField"] = $clsHotelCustomField;
	$listCustomField = $clsHotelCustomField->getAll("hotel_id='$hotel_id' and fieldtype='CUSTOM' order by order_no ASC");
	$assign_list["listCustomField"] = $listCustomField;
	 unset($listCustomField);
	
	#-- Hotel Related
	$lstHotelRelated = $clsHotel->getAll("is_trash=0 and hotel_id <> '$hotel_id' order by order_no desc limit 0,10",$clsHotel->pkey.',star_id');
	$assign_list['lstHotelRelated'] = $lstHotelRelated; unset($lstHotelRelated);
	
    /*=============Title & Description Page==================*/
	$title_page = $clsHotel->getTitle($hotel_id).' - '.$core->get_Lang('hotelsresorts').' - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $clsHotel->getTitle($hotel_id).' - '.$core->get_Lang('hotelsresorts').' - '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $clsHotel->getTitle($hotel_id).' - '.$core->get_Lang('hotelsresorts').' - '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_book(){
	global $assign_list,$_CONFIG,$core,$dbconn,$mod,$act,$title_page,$description_page,$keyword_page,$clsISO;
	global $_lang,$extLang,$_LANG_ID, $_frontIsLoggedin_user_id;
	#
	$clsHotel=new Hotel();$assign_list['clsHotel']=$clsHotel;
	$clsHotelRoom=new HotelRoom();$assign_list['clsHotelRoom']=$clsHotelRoom;
	$clsCountryLt = new _Country() ;$assign_list['lstCountry']=$clsCountryLt->getAll("1=1 order by order_no asc");
	$assign_list['clsCountryLt']=$clsCountryLt;
	$clsCity = new City();$assign_list['clsCity']=$clsCity;
	$clsCountryEx = new Country();$assign_list['clsCountryEx']=$clsCountryEx;
	
	#Get By Slug
	$slug=$_GET['slug'];
	$hotel_id = $clsHotel->getBySlug($slug);
	if($hotel_id==''){
		header('location:'.PCMS_URL);
	}
	$assign_list['hotel_id']=$hotel_id;
	#
	
	$hotel_room_id = isset($_COOKIE['Session_HotelRoomID']) ? intval($_COOKIE['Session_HotelRoomID']) : 0;
	$assign_list['hotel_room']=$hotel_room_id;
	
	$allHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id = '$hotel_id' order by order_no desc");
	$assign_list['allHotelRoom']=$allHotelRoom;
	
	#
	if(!empty($_frontIsLoggedin_user_id)) {
		$clsMember = new Member(); $assign_list['clsMember']=$clsMember;
		$name = $clsMember->getFullName($_frontIsLoggedin_user_id); $assign_list['name']=$name;
		$email = $clsMember->getEmail($_frontIsLoggedin_user_id); $assign_list['email']=$email;
		$phone = $clsMember->getPhone($_frontIsLoggedin_user_id); $assign_list['phone']=$phone;
		$country_id = $clsMember->getOneField('country_id',$_frontIsLoggedin_user_id); $assign_list['country_id']=$country_id;
	}
	
	$err_msg = '';
	if(isset($_POST['book']) && $_POST['book']=='book'){
		$name = $_POST['name'];
		if($name==''){
			$err_msg.= '&bull; '.$core->get_Lang('Please enter your fullname').' <br />';
		}
		$email = $_POST['email'];
		if($email==''){
			$err_msg.= '&bull; '.$core->get_Lang('Please enter your email').' <br />';
		}
		$phone = $_POST['phone'];
		if($phone==''){
			$err_msg.= '&bull; '.$core->get_Lang('Please enter your phone').' <br />';
		}
		$country_id = $_POST['country_id'];
		if($country_id==''){
			$err_msg.= '&bull; '.$core->get_Lang('Please select your country').' <br />';
		}
		$request = $_POST['request'];
		if($request==''){
			$err_msg.='&bull; '.$core->get_Lang('Please enter request').' <br />';
		}
		$checkin = $_POST['checkin'];
		if($checkin==''){
			$err_msg.= '&bull; '.$core->get_Lang('Please select check-in date').' <br />';
		}
		$checkout = $_POST['checkout'];
		if($checkout==''){
			$err_msg.= '&bull; '.$core->get_Lang('Please select check-out date').' <br />';
		}
		#
		$secure_code = isset($_POST["secure_code"])? $_POST["secure_code"] : '';
		$secure_code = strtoupper($secure_code);
		if($secure_code == ''){
			$err_msg.= '&bull; '.$core->get_Lang('Please enter secure code').' <br />';
		}
		#
		if($secure_code !='' && $secure_code != $_SESSION['skey']){
			$err_msg.= '&bull; '.$core->get_Lang('Please enter correct secure code').' <br />';
		}
		#
		if($err_msg == ''){
			$clsBooking = new Booking();
			$booking_id = $clsBooking->getMaxId();
			$booking_code = $clsBooking->generateBookingCode($booking_id);
			#
			$fx ="booking_id,target_id,clsTable,booking_code,booking_store,booking_type,reg_date,ip_booking";
			$vx ="'$booking_id'
				,'$hotel_id'
				,'Hotel'
				,'$booking_code'
				,'".serialize($_POST)."'
				,'Hotel'
				,'".time()."'
				,'".$_SERVER['REMOTE_ADDR']."'";
			#
			if(!empty($_frontIsLoggedin_user_id)) {
				$fx.= ",member_id";
				$vx.= ",'$_frontIsLoggedin_user_id'";
			}
			#
			if($clsBooking->insertOne($fx,$vx)){
				$clsBooking->sendEmailBookingHotel($booking_id);
				header('location: '.$extLang.'/booking/hotel/successful');
			}else{
				header('location: '.$extLang.'/booking/hotel/error');
			}
			unset($clsBooking);
		}else{
			$assign_list["err_msg"] = $err_msg;
			foreach($_POST as $key=>$val){
				$assign_list[$key] = $val;	
			}
		}
	}
	
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('bookinghotels').' | '.$clsHotel->getTitle($hotel_id).' | '.PAGE_NAME ;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('bookinghotels').' '.$clsHotel->getTitle($hotel_id).' - '.PAGE_NAME ;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('bookinghotels').' '.$clsHotel->getTitle($hotel_id).' - '.PAGE_NAME ;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/	
	unset($clsHotel);unset($clsHotelRoom);unset($clsBookingHotel);
	unset($clsCountry);unset($clsImage);unset($clsISO);		
}
function default_loadCity() {
    global $core, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    #
    $clsCity = new City();
    //$country_id = $_POST['country_id'];
	$country_id =1;
    $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';
    $Html = '<option value="0"> -- '.$core->get_Lang('selectdestination').' -- </option>';
    $lstCity = $clsCity->getAll("is_trash=0 and country_id='$country_id' order by order_no asc");
    if (is_array($lstCity) && count($lstCity) > 0) {
        foreach ($lstCity as $k => $v) {
            $selected = $city_id == $v[$clsCity->pkey] ? 'selected="selected"' : '';
            if ($clsCity->countHotel($country_id, $v[$clsCity->pkey])) {
                $Html .= '<option value="' . $v[$clsCity->pkey] . '" ' . $selected . '>-- ' . $clsCity->getTitle($v[$clsCity->pkey]) . ' --</option>';
            }
        }
    }
    echo $Html;
    die();
}

function default_ajLoadBedType() {
    global $core, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    #
    $clsHotelPriceCol = new HotelPriceCol();
    $clsHotelPriceVal = new HotelPriceVal();
    $hotel_id = $_POST['hotel_id'];
    $hotel_room_id = $_POST['hotel_room_id'];

    $html = '<option value="">-- '.$core->get_Lang('select').' --</option>';
    $lst = $clsHotelPriceCol->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no asc");
    if (!empty($lst)) {
        $i = 0;
        foreach ($lst as $item) {
            $selected = $city_id == $item[$clsHotelPriceCol->pkey] ? 'selected="selected"' : '';
            $html.='<option value="' . $item[$clsHotelPriceCol->pkey] . '" ' . $selected . '>
				-- ' . $clsHotelPriceCol->getTitle($item[$clsHotelPriceCol->pkey]) . ' (' . $clsHotelPriceVal->getPrice($hotel_room_id, $item[$clsHotelPriceCol->pkey]) . ')
			</option>';
            ++$i;
        }
    }
    echo $html;
    die();
}
function default_ajSetBookHotelRoom(){
	global $core, $dbconn, $clsISO;
	#
	$hotel_id = isset($_POST['hotel_id'])?intval($_POST['hotel_id']):0;
	$hotel_room_id = isset($_POST['hotel_room_id'])?intval($_POST['hotel_room_id']):0;
	#
	if(!empty($hotel_room_id) && !empty($hotel_id)){
		setcookie('Session_HotelRoomID', $hotel_room_id, time() + (86400 * 30), "/");
		setcookie('Session_HotelID', $hotel_id, time() + (86400 * 30), "/");
	}else {
		$hotel_room_id = isset($_COOKIE['Session_HotelRoomID']) ? intval($_COOKIE['Session_HotelRoomID']) : '0';
		$hotel_id = isset($_COOKIE['Session_HotelID']) ? intval($_COOKIE['Session_HotelID']) : '0';
		setcookie('Session_HotelRoomID', $hotel_room_id, time() + (86400 * 30), "/");
		setcookie('Session_HotelID', $hotel_id, time() + (86400 * 30), "/");
	}
	echo($hotel_id); die();
}
function default_ajMakeSelectHotelRoom() {
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    #
	$clsHotelRoom = new HotelRoom();
	$clsISO = new ISO();
	#
	$hotel_room_id = isset($_POST['hotel_room_id'])?intval($_POST['hotel_room_id']):0;
	$number_room = isset($_POST['number_room'])?intval($_POST['number_room']):0;
	#
	$html = '';
	if(intval($hotel_room_id)>0) {
		$number_room_hotel = $clsHotelRoom->getOneField('number_room',$hotel_room_id);
		$html.= $clsISO->getSelect(1,$number_room_hotel,$number_room);
	} else {
		$html.= $clsISO->getSelect(1,10,$number_room);
	}
	echo $html; die();
}
?>
