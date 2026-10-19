<?php
function default_default() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;
	$clsHotel= new Hotel();$assign_list['clsHotel']=$clsHotel;
	$clsHotelAPI= new HotelAPI();$assign_list['clsHotelAPI']=clsHotelAPI;
	
	$response = curl_exec($ch);
	$response_hotel=json_decode($response,true);
	
	$assign_list['response_hotel']=$response_hotel;
   	#
	$apiKey = 'VIETISOAPI';
	$apiSecret = '29bd027a1c4b804a6f208321b0296312a03a1143b592b0a5c4cb23a0ae2b05ae';
	$api_url = 'https://sandbox.oneinventory.com/api/v1.0/content/hotel';
	$timestamp = time();

	$params = array("langCode" => "vi", "limit" => "25", "offset" => "1");

	// Generate curl request
	$ch = curl_init($api_url);

	// Tell curl to use HTTP TimeOut
	curl_setopt($ch, CURLOPT_ENCODING, "utf-8");
	curl_setopt($ch, CURLOPT_MAXREDIRS, 30);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	// Tell curl to use HTTP Version
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	// Tell curl not to return headers, but do return the response
	curl_setopt($ch, CURLOPT_HEADER, false);
	// Tell curl to 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Tell curl to use HTTP POST
	curl_setopt ($ch, CURLOPT_POST, true);
	// Tell curl that this is the body of the POST
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($params));

	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Authorization: EZ APIKey=' . $apiKey . ',Timestamp=' . time() . ',Signature=' . hash("sha256", $apiKey.$apiSecret.$timestamp)
	));
	// obtain response
	$response = curl_exec($ch);
	$response_hotel=json_decode($response,true);
	
	$assign_list['response_hotel']=$response_hotel;
	//print_r($response); die();

	
	$err = curl_error($ch);
	@curl_close($ch);
	$status = 'error';
	
    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('hotelsresorts').' | '.PAGE_NAME;
     $assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_search() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain,$clsISO;
	$clsHotel= new Hotel();
	$assign_list['clsHotel']=$clsHotel;
	
	
	$clsHotelAPI= new HotelAPI();$assign_list['clsHotelAPI']=clsHotelAPI;
	$params = '{ 
		"keyword":"Đà Nẵng", 
		"keywordType":4, 
		"checkinDate":"2020-10-13", 
		"checkoutDate":"2020-10-14", 
		"rooms":1, 
		"adults":2, 
		"children":0, 
		"childrenAges":[], 
		"prices":[], 
		"stars":[], 
		"langCode":"vi", 
		"currency":"VND", 
		"limit":25, 
		"offset":0, 
		"orderBy":1
	}';
	
	$response = $clsHotelAPI->doInApp('POST','v2.0/availability/search',$params);

	$response_hotel=json_decode($response,true);
	
	$assign_list['response_hotel']=$response_hotel;
	
  
    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('hotelsresorts').' | '.PAGE_NAME;
     $assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_place() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$country_id,$city_id;
	global $clsISO;
    #
	$clsCountryEx=new Country(); $assign_list["clsCountryEx"] = $clsCountryEx;
	$clsRegion=new Region(); $assign_list["clsRegion"] = $clsRegion;
	$clsCity=new City(); $assign_list["clsCity"] = $clsCity;
	$clsTour = new Tour(); $assign_list['clsTour'] = $clsTour;
	$clsHotel=new Hotel();$assign_list['clsHotel']=$clsHotel;
	$clsBlog=new Blog();$assign_list['clsBlog']=$clsBlog;
	$clsGuide=new Guide(); $assign_list["clsGuide"] = $clsGuide;
	$clsGuideCat = new GuideCat(); $assign_list["clsGuideCat"] = $clsGuideCat;
	$clsGuideCatStore = new GuideCatStore();$assign_list["clsGuideCatStore"] = $clsGuideCatStore;
	$clsPagination = new Pagination();$assign_list["clsPagination"] = $clsPagination;
	
    #
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list['show'] = $show;
	
	$listGuideCat = $clsGuideCat->getAll("is_trash=0 and is_online=1 order by order_no ASC",$clsGuideCat->pkey);
	$assign_list['listGuideCat'] = $listGuideCat; 
	unset($listGuideCat);

	if($show=='Country'){
		$slug_country = isset($_GET['slug_country'])?$_GET['slug_country']:'';
		$res = $clsCountryEx->getAll("is_trash=0 and is_online=1 and slug='$slug_country' LIMIT 0,1",$clsCountryEx->pkey);
		$country_id = $res[0][$clsCountryEx->pkey];
		if(intval($country_id)==0) {
			header('Location:'.PCMS_URL.$extLang);
			exit();
		}
		$assign_list['country_id'] = $country_id;
		$place_id=$country_id;
		$clsClassTable='Country';
		#
		$title_page = $clsCountryEx->getTitle($country_id);
		$intro_page = $clsCountryEx->getStripIntro($country_id);
		$intro_hotel = $clsCountryEx->getIntro($country_id,'Hotel');
		$content_page = $clsCountryEx->getContent($country_id);
		$link_page = $clsCountryEx->getLink($country_id);
		$oneItem = $clsCountryEx->getOne($country_id);
		#
		$lstRegionByCountry = $clsRegion->getAll("is_trash=0 and is_online=1 and country_id='$country_id' order by order_no ASC",$clsRegion->pkey.',title');
		$assign_list['lstRegionByCountry'] = $lstRegionByCountry; 
		unset($lstRegionByCountry);
	
		$lstCityRegionOther=$clsCity->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and region_id='0' and  city_id IN (SELECT city_id FROM ".DB_PREFIX."hotel WHERE is_trash=0 and is_online=1) order by order_no ASC",$clsCity->pkey);
		$assign_list['lstCityRegionOther'] = $lstCityRegionOther;  unset($lstCityRegionOther);
	}
	if($show=='Country'){
		$clsCityStore = new CityStore();
		$assign_list['clsCityStore'] = $clsCityStore;
		$listTopCity = $clsCityStore->getAll("country_id='$country_id' and type='TOP' order by order_no ASC");
		$assign_list['listTopCity'] = $listTopCity; unset($listTopCity);
	}
	if($show=='City'){
		$slug_city = isset($_GET['slug_city']) ? $_GET['slug_city'] : '';
		$city_id = $clsCity->getBySlug($slug_city);
		if(intval($city_id)==0) {
			header('Location:'.PCMS_URL.$extLang);
			exit();
		}
		$assign_list["city_id"] = $city_id;
		$place_id=$city_id;
		$clsClassTable='City';
		
		$title_page = $clsCity->getTitle($city_id);
		$intro_page = $clsCity->getIntro($city_id);
		$intro_hotel = $clsCity->getIntro($city_id,'Hotel');
		$content_page = $clsCity->getContent($city_id);
		$link_page = $clsCity->getLink($city_id);
		$oneItem = $clsCity->getOne($city_id);
		$country_id=$oneItem['country_id'];
		$assign_list['country_id'] = $country_id;
	}
	if($show=='Region'){
		$slug_country = isset($_GET['slug_country'])?$_GET['slug_country']:'';
		$res = $clsCountryEx->getAll("is_trash=0 and is_online=1 and slug='$slug_country' LIMIT 0,1");
		$country_id = $res[0][$clsCountryEx->pkey];
		$region_id = isset($_GET['region_id']) ? $_GET['region_id'] : '';

		if(intval($region_id)==0) {
			header('Location:'.PCMS_URL.$extLang);
			exit();
		}
		$assign_list["country_id"] = $country_id;
		$assign_list["region_id"] = $region_id;
		$place_id=$region_id;
		$clsClassTable='Region';
		$title_page = $clsRegion->getTitle($region_id);
		$intro_page = $clsRegion->getIntro($region_id);
		$intro_hotel = $clsRegion->getIntro($region_id,'Hotel');
		$content_page = $clsRegion->getContent($region_id);
		$link_page = $clsRegion->getLink($region_id);
	}
	
	$assign_list['TD'] = $title_page;
	$assign_list['ID'] = $intro_page;
	$assign_list['HOTEL_INTRO'] = $intro_hotel;
	$assign_list['CD'] = $content_page;
	$assign_list['link_page'] = $link_page;
	
	$recordPerPage = 12;
	$currentPage = isset($_GET['page'])?intval($_GET['page']):1;

	$cond = "is_trash=0 and is_online=1";
	
	if($show=='Country'){
		$cond .= " and country_id='$country_id'";
	}elseif($show=='City'){
		$cond .= " and city_id='$city_id'";
	}elseif($show == 'Region'){
		$cond .= " and city_id IN (SELECT city_id FROM ".DB_PREFIX."city WHERE country_id='$country_id' and region_id='$region_id')";
	}else{
		$cond .= "";
	}
	$order_by = " order by order_no ASC";
	$totalRecord = $clsHotel->getAll($cond)?count($clsHotel->getAll($cond)):0;
	$assign_list['totalRecord']=$totalRecord; 
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);
	#
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	#
	$listHotelPlace=$clsHotel->getAll($cond.$order_by.$limit,$clsHotel->pkey.',star_id');
	$assign_list['listHotelPlace'] = $listHotelPlace;
	$assign_list['page_view']=$page_view; 	
	unset($listHotelPlace);
	unset($page_view);
	#
	$totalPage= $clsPagination->getTotalPage();
	$assign_list['totalPage']=$totalPage; 
	#
	$sql = "is_trash=0 and is_online=1";
	if($show=='Country'){
		$listBlogPlace=$clsBlog->getAll($sql." and blog_id IN (SELECT blog_id FROM ".DB_PREFIX."blog_destination WHERE country_id='$country_id')",$clsBlog->pkey);
	}elseif($show=='City'){
		$listBlogPlace=$clsBlog->getAll($sql." and blog_id IN (SELECT blog_id FROM ".DB_PREFIX."blog_destination WHERE country_id='$country_id' and city_id='$city_id')",$clsBlog->pkey);
	}else{
		$listBlogPlace=$clsBlog->getAll($sql." and blog_id IN (SELECT blog_id FROM ".DB_PREFIX."blog_destination WHERE country_id='$country_id' and city_id IN (SELECT city_id FROM ".DB_PREFIX."citystore WHERE is_trash=0 and country_id='$country_id' and region_id='$region_id' and type='REGION'))",$clsBlog->pkey);
	}
	$assign_list['listBlogPlace'] = $listBlogPlace; 
	unset($listBlogPlace);

	$letter = array();
	foreach (range('a','z') as $i){
		$letter[] = $i;
	}
	$assign_list['letter']= $letter;
	
	vnSessionSetVar('linkBack',$_SERVER['REQUEST_URI']);
    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('Hotels in').' '.$title_page.' | '.PAGE_NAME;
    $assign_list["title_page"] = $title_page;
	$description_page = $clsISO->getMetaDescription($place_id,$clsClassTable);
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_ajLoadMoreHotel() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$country_id,$city_id;
	global $clsISO;
    #
	
	$clsCountryEx=new Country(); $assign_list["clsCountryEx"] = $clsCountryEx;
	$clsHotel=new Hotel();$assign_list['clsHotel']=$clsHotel;
	$clsPagination = new Pagination();$assign_list["clsPagination"] = $clsPagination;
	
    #
	$show = isset($_POST['show'])? $_POST['show']:'';
	
	$recordPerPage = 12;
	$keyword = isset($_POST['keyword'])?intval($_POST['keyword']):'';
	$currentPage = isset($_POST['page'])?intval($_POST['page']):1;
	$country_id = isset($_POST['country_id'])?intval($_POST['country_id']):'0';
	
	
	if($show=='Search'){
		$city_id = isset($_POST['city_id'])?intval($_POST['city_id']):'';
		$star_id = isset($_POST['star_id'])?intval($_POST['star_id']):'';
		$price_range = isset($_POST['price_range'])?intval($_POST['price_range']):'';
	}

	$cond = "is_trash=0 and is_online=1";

	if($show=='Search'){
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
			$clsPriceRange=new HotelPriceRange();
			$oneTmp=$clsPriceRange->getOne($price_range);
			$min_rate=intval($oneTmp['min_rate']);
			$max_rate=($oneTmp['max_rate']);
			
			if($min_rate==0 && $max_rate>0){
				$cond.=" and price_avg < '$max_rate'";
			}elseif($min_rate>0 && $max_rate==0){
				$cond.=" and price_avg > ".$min_rate;
			}else{
				$cond.=" and price_avg > '$min_rate' and price_avg < '$max_rate'";
			}
			$assign_list["price_range"] = $price_range;
		}
		if($keyword!=''){
			$cond.=" and (title like '$keyword' or slug like '%".$core->replaceSpace($keyword)."%')";
			$assign_list["keyword"] = $keyword;
		}
	}else{
		if($show=='Country'){
			$cond .= " and country_id='$country_id'";
		}elseif($show=='City'){
			$cond .= " and city_id='$city_id'";
		}elseif($show == 'Region'){
			$cond .= " and city_id IN (SELECT city_id FROM ".DB_PREFIX."citystore WHERE country_id='$country_id' and region_id='$region_id')";
		}else{
			$cond .= "";
		}
	}
	$order_by = " order by order_no ASC";
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	
	$listHotelPlace=$clsHotel->getAll($cond.$order_by.$limit,$clsHotel->pkey.',star_id');
	$assign_list['listHotelPlace'] = $listHotelPlace; 
	$html = $core->build('load_more_hotel.tpl');
	echo $html; die;
}

function default_detail() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act,$_LANG_ID,$title_page,$description_page,$global_image_seo_page,$curl;
	global $country_id,$clsISO;
	#
	$show = isset($_GET['show'])?$_GET['show']:'';
	$assign_list['show']=$show;
	#
	$clsHotel=new Hotel(); $assign_list['clsHotel']=$clsHotel;
	$clsHotelProperty=new HotelProperty(); $assign_list['clsHotelProperty']=$clsHotelProperty;
	$clsProperty=new Property(); $assign_list['clsProperty']=$clsProperty;
    $clsHotelAttraction=new HotelAttraction(); $assign_list['$clsHotelAttraction']=$clsHotelAttraction;
    $clsAttraction=new Attraction(); $assign_list['clsAttraction']=$clsAttraction;
	$clsCountryEx=new Country(); $assign_list['clsCountryEx']=$clsCountryEx;
	$clsCity=new City(); $assign_list['clsCity']=$clsCity;
	$clsHotelImage=new HotelImage(); $assign_list['clsHotelImage']=$clsHotelImage;
	$clsHotelRoom=new HotelRoom(); $assign_list['clsHotelRoom']=$clsHotelRoom;
	$clsHotelPriceCol=new HotelPriceCol(); $assign_list['clsHotelPriceCol']=$clsHotelPriceCol;
	$clsHotelPriceVal=new HotelPriceVal(); $assign_list['clsHotelPriceVal']=$clsHotelPriceVal;
	
	$apiKey = 'VIETISOAPI';
	$apiSecret = '29bd027a1c4b804a6f208321b0296312a03a1143b592b0a5c4cb23a0ae2b05ae';
	$api_url = 'https://sandbox.oneinventory.com/api/v2.0/availability/detail';
	$timestamp = time();
	
	$GET = array();
	foreach($_GET as $k=>$v){
		$GET[$k] = $v;
	}
	//$params=json_encode($GET);
	//print_r($params); die();
	$params = '{ 
		"hotelId":4615, 
		"checkinDate":"2020-10-12", 
		"checkoutDate":"2020-10-13", 
		"rooms":1, 
		"adults":2, 
		"children":0, 
		"childrenAges":[], 
		"langCode":"vi", 
		"currency":"VND" 
	}';

	// Generate curl request
	$ch = curl_init($api_url);

	// Tell curl to use HTTP TimeOut
	curl_setopt($ch, CURLOPT_ENCODING, "utf-8");
	curl_setopt($ch, CURLOPT_MAXREDIRS, 30);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	// Tell curl to use HTTP Version
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	// Tell curl not to return headers, but do return the response
	curl_setopt($ch, CURLOPT_HEADER, false);
	// Tell curl to 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Tell curl to use HTTP POST
	curl_setopt ($ch, CURLOPT_POST, true);
	// Tell curl that this is the body of the POST
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Authorization: EZ APIKey=' . $apiKey . ',Timestamp=' . time() . ',Signature=' . hash("sha256", $apiKey.$apiSecret.$timestamp)
	));
	// obtain response
	$response = curl_exec($ch);
	$response_hotel_detail=json_decode($response,true);
	
	$assign_list['response_hotel_detail']=$response_hotel_detail;
	//print_r($response_hotel_detail); die();

	
	$err = curl_error($ch);
	@curl_close($ch);
	$status = 'error';
	 
    /*=============Title & Description Page==================*/
	$title_page = $clsHotel->getTitle($hotel_id).' | '.$core->get_Lang('hotels').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$description_page = $clsISO->getMetaDescription($hotel_id,'Hotel');
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = $clsISO->getPageImageShare($hotel_id,'Hotel');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
	
}

function default_book(){
	global $assign_list,$_CONFIG,$core,$dbconn,$mod,$act,$title_page,$description_page,$keyword_page,$clsISO;
	global $_lang,$extLang,$_LANG_ID, $profile_id,$loggedIn;


	#
	$clsHotel=new Hotel();$assign_list['clsHotel']=$clsHotel;
	$clsHotelRoom=new HotelRoom();$assign_list['clsHotelRoom']=$clsHotelRoom;
	$clsCountryLt = new _Country();$assign_list['clsCountryLt']=$clsCountryLt;
	$assign_list['lstCountry']=$clsCountryLt->getAll("1=1 order by order_no asc");
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
	
	$allHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id = '$hotel_id' order by order_no ASC",$clsHotelRoom->pkey);
	$assign_list['allHotelRoom']=$allHotelRoom;
	$departure_date=isset($_POST['checkin'])?$_POST['checkin']:'';
	$departure_date=strtotime($departure_date);
	#
	if(!empty($profile_id)) {
		$clsProfile = new Profile(); $assign_list['clsProfile']=$clsProfile;
		$name = $clsProfile->getFullname($profile_id); $assign_list['name']=$name;
		$email = $clsProfile->getEmail($profile_id); $assign_list['email']=$email;
		$phone = $clsProfile->getPhone($profile_id); $assign_list['phone']=$phone;
		$country_id = $clsProfile->getOneField('country_id',$profile_id); $assign_list['country_id']=$country_id;
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
			$err_msg.= '&bull; '.$core->get_Lang('Please select check in date').' <br />';
		}
		$checkout = $_POST['checkout'];
		if($checkout==''){
			$err_msg.= '&bull; '.$core->get_Lang('Please select check out date').' <br />';
		}
		#- Verify Captcha
		if(_ISOCMS_CAPTCHA=='IMG'){
			$security_code = isset($_POST["security_code"])? trim($_POST["security_code"]) : '';
			$security_code = strtoupper($security_code);
			if(!empty($security_code) && $security_code != $_SESSION['skey']){
				$err_msg .='&bull; '.$core->get_Lang('Secure code not match').' <br />';
			}
		}else if(_ISOCMS_CAPTCHA=='reCAPTCHA'){
			if(!$clsISO->checkGoogleReCAPTCHA()){
				$err_msg .='&bull; '.$core->get_Lang('Secure code not match').' <br />';
			}
		}
		#
		if($err_msg == ''){
			$clsBooking = new Booking();
			$booking_id = $clsBooking->getMaxId();
			$booking_code = $clsBooking->generateBookingCode($booking_id);
			#
			$f ="booking_id,target_id,full_name,email,phone,country_id,clsTable,booking_code,booking_store,booking_type,reg_date,departure_date,ip_booking";
			$v ="'$booking_id'
				,'$hotel_id'
				,'$name'
				,'$email'
				,'$phone'
				,'$country_id'
				,'Hotel'
				,'$booking_code'
				,'".serialize($_POST)."'
				,'Hotel'
				,'".$departure_date."'
				,'".time()."'
				,'".$_SERVER['REMOTE_ADDR']."'";
			#
			if(_ISOCMS_CLIENT_LOGIN){
				$f.= ",member_id";
				$v.= ",'$profile_id'";
			}
			//print_r($f.'<br />'.$v); die();
			if($clsBooking->insertOne($f,$v)){
				$clsBooking->sendEmailBookingHotel($booking_id,0);
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
	$title_page = $core->get_Lang('Booking Hotels').' | '.$clsHotel->getTitle($hotel_id).' | '.PAGE_NAME ;
	 $assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/	
	unset($clsHotel);unset($clsHotelRoom);unset($clsBookingHotel);
	unset($clsCountry);unset($clsImage);unset($clsISO);		
}
function default_loadCity() {
    global $core, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    #
    $clsCity = new City();
    $country_id = $_POST['country_id'];
    $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';
    $Html = '<option value="0"> -- '.$core->get_Lang('selectdestination').' -- </option>';
    $lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id='$country_id' order by order_no asc",$clsCity->pkey);
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
