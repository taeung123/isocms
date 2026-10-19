<?php

function default_test_json(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;
	#
	header('Access-Control-Allow-Origin: *');

	$arrData = array(
		'orgReg' =>$_POST['orgReg'],
		'message' =>'Email của bạn đã được sử dụng',
		'nameReg' =>$_POST['nameReg'],
		'cardReg' =>$_POST['cardReg'],
		'httpReg' =>$_POST['httpReg'],
		'websiteReg' =>$_POST['websiteReg'],
		'user_id' =>'100',
		'phoneReg' => $_POST['phoneReg'],
		'status' =>'RESULT_NOT_OK',
	);
	$json = json_encode($arrData,true); 
    die($json);
}

function objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();
    
    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}
function default_getDestination(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$about_us_id;
	$clsVietISOSDK = new VietISOSDK();

	#
	$response = $clsVietISOSDK->file_get_contents_curl('https://techapi.oneinventory.com/api/v1.0/content/hotel');
	
	$response = json_decode($response, true);
	print_r($response);die();

}

function default_contact(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page,$description_page,$keyword_page;
	global $clsISO, $_LANG_ID, $_lang, $extLang, $_frontIsLoggedin_user_id;
	#

	$clsTailorProperty = new TailorProperty();$assign_list["clsTailorProperty"] = $clsTailorProperty;
	$clsTour = new Tour();$assign_list["clsTour"] = $clsTour;
	$clsCruise = new Cruise();$assign_list["clsCruise"] = $clsCruise;
	$clsCruiseItinerary = new CruiseItinerary();$assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
	$clsCity = new City();$assign_list["clsCity"] = $clsCity;
	$clsCountry = new _Country(); $assign_list["clsCountry"] = $clsCountry;
	$clsCountryEx = new Country();$assign_list["clsCountryEx"] = $clsCountryEx;
	$clsBooking = new Booking();
	$clsFeedback=new Feedback(); $assign_list['clsFeedback'] = $clsFeedback;
	#
	$assign_list["lstCountryRegion"] = $clsCountry->getAll("1=1 and is_trash=0 order by order_no ASC",$clsCountry->pkey.",title");
	$assign_list['lst_country_id']=$lstCountryEx[0][$clsCountryEx->pkey];
	
	$show = isset($_GET['show'])?$_GET['show']:'';
	
	if($show=='Tour'){
		if(isset($_GET['slug']) && !empty($_GET['slug'])) {
			$slug = isset($_GET['slug'])?$_GET['slug']:'';
			$tour_id = $clsTour->getBySlug($slug);
				
			if(al($tour_id) == 0) {
				header('location:'.PCMS_URL.$extLang);
				exit();
			}
		}
	}else{
		$tour_id = vnSessionGetVar('tour_contact_id');
	}
	$assign_list["tour_id"] = $tour_id;
	
	$cruise_id = vnSessionGetVar('cruise_contact_id');
	$assign_list["cruise_id"] = $cruise_id;
	
	
	$cruise_itinerary_id = vnSessionGetVar('cruise_itinerary_contact_id');
	$assign_list["cruise_itinerary_id"] = $cruise_itinerary_id;
	if($cruise_id==''){
		$cruise_id=$clsCruiseItinerary->getOneField('cruise_id',$cruise_itinerary_id);
		$assign_list["cruise_id"] = $cruise_id;
	}

	#
	if(!empty($_frontIsLoggedin_user_id)) {
		$clsMember = new Member(); $assign_list['clsMember']=$clsMember;
		$name = $clsMember->getFullName($_frontIsLoggedin_user_id); $assign_list['name']=$name;
		$email = $clsMember->getEmail($_frontIsLoggedin_user_id); $assign_list['email']=$email;
		$phone = $clsMember->getPhone($_frontIsLoggedin_user_id); $assign_list['phone']=$phone;
		$country_id = $clsMember->getOneField('country_id',$_frontIsLoggedin_user_id); $assign_list['country_id']=$country_id;
		$title = $clsMember->getOneField('title',$_frontIsLoggedin_user_id); $assign_list['title']=$title;
	}
	#
	$errMsg='';
	
	if(isset($_POST['plantrip'])&&$_POST['plantrip']=='plantrip'){ 
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		#- Verify Captcha
		if(_ISOCMS_CAPTCHA=='IMG'){
			$security_code = isset($_POST["security_code"])? trim($_POST["security_code"]) : '';
			$security_code = strtoupper($security_code);
			if($security_code==''){
				$errMsg.= '&bull; '.$core->get_Lang('Please enter security code').' <br />';
			}
			if(!empty($security_code) && $security_code != $_SESSION['skey']){
				$errMsg .= $core->get_Lang('Secure code not match').' <br />';
			}
		}else if(_ISOCMS_CAPTCHA=='reCAPTCHA'){
			if(!$clsISO->checkGoogleReCAPTCHA()){
				$errMsg .= $core->get_Lang('Secure code not match').' <br />';
			}
		}
		#
		if($errMsg==''){
			$feedback_id = $clsFeedback->getMaxId();
			$feedback_code=$clsFeedback->generateFeedBack($feedback_id);
			$current_date = date('m/d/Y');
			$current_time = strtotime($current_date);
			#
			$fx = "feedback_id,target_id,feedback_code,title,first_name,last_name,email,phone,address,country_id,feedback_store,user_ip,reg_date,departure_date";
			$vx = "'$feedback_id'
			,'".$_POST['tour_id']."'
			,'$feedback_code'
			,'".$_POST['title']."'
			,'$firstname'
			,'$lastname'
			,'$email'
			,'$phone'
			,'$address'
			,'".$_POST['country_id']."'
			,'".serialize($_POST)."'
			,'".$_SERVER['REMOTE_ADDR']."'
			,'".time()."'
			,'".$current_time."'
			";
			#

			if($clsFeedback->insertOne($fx,$vx)){
				$clsFeedback->newBooking($feedback_id);
				vnSessionDelVar('tour_contact_id');
				vnSessionDelVar('cruise_contact_id');
				vnSessionDelVar('cruise_itinerary_contact_id');
				vnSessionDelVar('hotel_contact_id');
				header('location:'.$extLang.'/contact-us/success.html');
				exit();
			}
		}else{
			foreach($_POST as $k=>$v){
				$assign_list[$k] = $v;
			}
			$assign_list["errMsg"] = $errMsg;
		}
	}
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('contactus').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('contactus').' | '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('contactus').' | '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
}

function default_team(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act,$title_page,$description_page,$keyword_page,$oneCommon;
	global $clsConfiguration, $extLang, $_LANG_ID, $clsISO;
	#
	$clsTeam = new Team();
	$assign_list['clsTeam'] = $clsTeam;
	#
	$listTeam = $clsTeam->getAll("is_trash=0 and is_online=1 and languages='$_LANG_ID' order by order_no asc",$clsTeam->pkey);
	$assign_list['listTeam'] = $listTeam;
	unset($listTeam);
	
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Our Team').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('Our Team').' | '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('Our Team').' | '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
	/*========================================================*/
	unset($clsFeedback); unset($clsISO);
}

function default_sitemap(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	#-- Country
	$clsCountry = new Country(); $assign_list['clsCountry'] = $clsCountry;
	$lstCountry = $clsCountry->getAll("is_trash=0 and is_online=1 order by order_no ASC",$clsCountry->pkey);
	$assign_list['lstCountry'] = $lstCountry;
	#-- City
	$clsCity = new City(); $assign_list['clsCity'] = $clsCity;
	#-- TourCategory
	$clsTourCategory = new TourCategory(); $assign_list['clsTourCategory'] = $clsTourCategory;
	$listCatTours = $clsTourCategory->getAll("is_trash=0 and is_online=1 order by order_no ASC",$clsTourCategory->pkey);
	$assign_list['listCatTours'] = $listCatTours;
	#-- Travel News
	$clsNewsCategory=new NewsCategory();$assign_list['clsNewsCategory']=$clsNewsCategory;
	$lstNewsCategory = $clsNewsCategory->getAll('is_trash=0 and is_online=1 order by order_no asc',$clsNewsCategory->pkey);
	$assign_list['lstNewsCategory'] = $lstNewsCategory; unset($lstNewsCategory);
	#-- Information
	$clsPage=new Page();$assign_list['clsPage']=$clsPage;
	$assign_list['lstPage']=$clsPage->getAll("is_trash=0 and is_online=1 order by order_no ASC",$clsPage->pkey);
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('sitemap').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('sitemap').' | '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('sitemap').' | '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	 unset($clsCategory); unset($clsCountry);unset($clsCity);
}
function default_FAQ(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	#
	$clsFAQ = new FAQ();$assign_list["clsFAQ"] = $clsFAQ;
	$clsFAQCategory = new FAQCategory(); $assign_list["clsFAQCategory"] = $clsFAQCategory;
	#
	$lstFAQCat = $clsFAQCategory->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsFAQCategory->pkey);
	$assign_list["lstFAQCat"] = $lstFAQCat;
	unset($lstFAQCat);
	#
	$listFAQs = $clsFAQ->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsFAQ->pkey);
	$assign_list["listFAQs"] = $listFAQs; unset($listFAQs);
	
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('faqs').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('faqs').' | '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('faqs').' | '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_why(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	#
	$clsWhy = new Why(); $assign_list["clsWhy"] = $clsWhy;
	#
	$lstWhy = $clsWhy->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsWhy->pkey);
	$assign_list["lstWhy"] = $lstWhy;
	unset($lstWhy);
	#
	
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Why travel with us').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('Why travel with us').' | '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('Why travel with us').' | '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_success(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsConfiguration;
	#
	$show=isset($_GET['show'])?$_GET['show']:'';
	$assign_list["show"] = $show;
	
	 /*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Success').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('Success').' | '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('Success').' | '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_brochure(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$_lang;
	#
	$clsDownload=new Download();
	$assign_list["clsDownload"] = $clsDownload;

	$listDownload=$clsDownload->getAll("is_trash=0 and is_online=1 and attachment_file<>'' order by order_no asc",$clsDownload->pkey);
	$assign_list["listDownload"] = $listDownload;
	 unset($listDownload);
	 
    /*=============Title & Description Page==================*/
	$title_page =$core->get_Lang('Trade Brochures').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('Trade Brochures').' | '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('Trade Brochures').' | '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
}
?>
