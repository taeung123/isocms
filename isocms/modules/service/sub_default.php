<?php
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain,$clsPageInfo,$extLang,$clsConfiguration,$clsISO,$package_id;
	
	$clsServiceCategory  = new ServiceCategory ();$assign_list["clsServiceCategory"] = $clsServiceCategory;
	
	$clsService = new Service();$assign_list['clsService']=$clsService;
	$clsTour=new Tour(); $assign_list['clsTour']=$clsTour;
	$clsPagination = new Pagination();$assign_list['clsPagination']=$clsPagination;
	
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list["show"] = $show;
	
	$servicecat_id = 0;
	if($show=='cat'){
		$clsISO = new ISO();
		if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')){
			header('Location:/');
			exit();
		}
		
		$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
		$servicecat_id = $clsServiceCategory->getBySlug($slug);
		if($servicecat_id==0){
			header('location:'.PCMS_URL.$extLang);
			exit();
		}
	}
	
	$assign_list["servicecat_id"] = $servicecat_id;
	
	$recordPerPage =6;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	
	$page_Seo = isset($_GET['page'])?intval($_GET['page']):'';
	$assign_list['page_Seo']=$page_Seo;
	
	$cond ="is_trash=0 and is_online=1";
	
	if(intval($servicecat_id) > 0){
		$cond .= " and (cat_id='$servicecat_id' or list_cat_id like '%|$servicecat_id|%')";
	}
	$totalRecord 	=$clsService->getAll($cond,$clsService->pkey);		
	$totalRecord 	=$totalRecord?count($totalRecord):0;		
	#
	if($show=='cat'){
		$link_page = $clsServiceCategory->getLink($servicecat_id);
	}else{
		$link_page = $clsISO->getLink('service');
	}
	
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
	
	
	$cond .=" order by order_no ASC";
	
	$listService=$clsService->getAll($cond.$limit,$clsService->pkey.",title,reg_date");
	$assign_list['listService']=$listService;
	//print_r($listService); die();
	
	$totalPage = $clsPagination->getTotalPage();
	//print_r($totalPage); die();

	#
	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['page_view'] = $page_view;
	
    /*=============Title & Description Page==================*/
	
	if($show=='cat'){
		$title_page = $clsServiceCategory->getTitle($servicecat_id).' | '.$core->get_Lang('travelservices').' | '.PAGE_NAME;
		$assign_list["title_page"] = $title_page;
		$description_page = $clsISO->getMetaDescription($servicecat_id,'ServiceCategory');
		$assign_list["description_page"] = $description_page;
		$keyword_page =$title_page;
		$assign_list["keyword_page"] = $keyword_page;
	}else{
		$title_page = $core->get_Lang('travelservices').' | '.PAGE_NAME;
		$assign_list["title_page"] = $title_page;
		$description_page = $clsConfiguration->getValue('site_service_intro_'.$_LANG_ID);
		$assign_list["description_page"] = $description_page;
		$keyword_page =$title_page;
		$assign_list["keyword_page"] = $keyword_page;
	}
	/*=============Content Page==================*/
	unset($clsCountry);unset($clsService);
}
function default_detail(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsConfiguration,$profile_id,$loggedIn,$extLang,$clsISO,$package_id;
	#
	$clsBooking=new Booking();$assign_list['clsBooking']=$clsBooking;
	$clsService=new Service();$assign_list['clsService']=$clsService;
	$clsServiceCategory  = new ServiceCategory ();$assign_list["clsServiceCategory"] = $clsServiceCategory;
	$clsTour=new Tour(); $assign_list['clsTour']=$clsTour;

	#
	$service_id = isset($_GET['service_id'])?$_GET['service_id']:0;
	$slug = isset($_GET['slug'])?$_GET['slug']:'';
	
	if(empty($clsService->checkOnlineBySlug($service_id,$slug))){
		header('location:'.$clsISO->getLink('service'));
		exit();
	}
	$assign_list['service_id']=$service_id;
	#
	$servicecat_id = $clsService->getOneField('cat_id',$service_id);
	$assign_list['servicecat_id']=$servicecat_id;
	if($clsISO->getCheckActiveModulePackage($package_id,'service','category','default')){
        $lstRelated = $clsService->getAll("is_trash=0 and is_online=1 and service_id<>'$service_id' and cat_id='$servicecat_id' order by rand() LIMIT 0,10",$clsService->pkey);
    }else{
        $lstRelated = $clsService->getAll("is_trash=0 and is_online=1 and service_id<>'$service_id' order by rand() LIMIT 0,10",$clsService->pkey);
    }
	
	$assign_list["lstRelated"] = $lstRelated;

 	if(!empty($profile_id)) {
		$clsProfile = new Profile(); $assign_list['clsProfile']=$clsProfile;
		$fullname = $clsProfile->getFullname($profile_id); $assign_list['fullname']=$fullname;
		$email = $clsProfile->getEmail($profile_id); $assign_list['email']=$email;
		$phone = $clsProfile->getPhone($profile_id); $assign_list['phone']=$phone;
		$address = $clsProfile->getAddress($profile_id); $assign_list['address']=$address;
		$country_id = $clsProfile->getOneField('country_id',$profile_id); $assign_list['country_id']=$country_id;
	}

 	$errMsg = '';
	if(isset($_POST['Hid_Events']) && $_POST['Hid_Events']=='Hid_Events'){
		if(_ISOCMS_CLIENT_LOGIN==33333){
			if(!$loggedIn){
				$link=$extLang.'/account/signin/r='.$_SERVER['REQUEST_URI'];
				header('Location:'.$link);
				exit();
			}
		}
		$fullname = $_POST['fullname'];
		if($fullname==''){
			$errMsg.= '&nbsp; '.$core->get_Lang('Full name is required').' <br />';
		}
		#
		$address = $_POST['address'];
		if($address==''){
			$errMsg.= '&nbsp; '.$core->get_Lang('Address is required').' <br />';
		}
		#
		$email = addslashes($_POST['email']);
		if($email==''){
			$errMsg .= $core->get_Lang('Please enter your email').' <br />';
		}
		$phone = addslashes($_POST['phone']);
		if($phone==''){
			$errMsg .= $core->get_Lang('Please enter phone number').' <br />';
		}
		$message = addslashes($_POST['message']);
		if($message==''){
			$errMsg .= $core->get_Lang('Please enter message').' <br />';
		}
		if(_ISOCMS_CAPTCHA=='IMG'){
			$security_code = isset($_POST["security_code"])? trim($_POST["security_code"]) : '';
			$security_code = strtoupper($security_code);
			if($security_code==''){
				$errMsg.= $core->get_Lang('Please enter security code').' <br />';
			}
			if(!empty($security_code) && $security_code != $_SESSION['skey']){
				$errMsg .= $core->get_Lang('Secure code not match').' <br />';
			}
		}else{
			if(!$clsISO->checkGoogleReCAPTCHA()){
				$errMsg .= $core->get_Lang('Secure code not match').' <br />';
			}
		}
		#
		if($errMsg==''){
		
			$booking_id = $clsBooking->getMaxId();
			$booking_code = $clsBooking->generateBookingCode($booking_id,'Service');
			#
			$f="booking_id,target_id,contact_name,phone,address,email";
			$f.= ",clsTable,booking_code,booking_store,booking_type,reg_date,departure_date,ip_booking";
			$current_date = date('m/d/Y');
			$current_time = strtotime($current_date);
			$POST = array();
			foreach($_POST as $k=>$v){
				$POST[$k] = $v;
			}
			$POST['BOOK_VALUE'] = serialize($BOOK_VALUE);
			$POST['BOOK_ADDON'] = serialize($BOOK_ADDON);
			#
			
			$v="'$booking_id'
			,'$service_id'
			,'".$_POST['fullname']."'
			,'".$_POST['phone']."'
			,'".$_POST['address']."'
			,'".$email."'
			,'Service'
			,'$booking_code'
			,'".serialize($POST)."'
			,'Service','".time()."'
			,'".$current_time."'
			,'".$_SERVER['REMOTE_ADDR']."'";
			#
			if(!empty($profile_id)) {
				$f.= ",member_id";
				$v.= ",'$profile_id'";
			}
			//print_r($f.'xxx'.$v); die();
			if($clsBooking->insertOne($f,$v)){
				$clsBooking->sendEmailBookingService($booking_id);
				header('location:'.$extLang.'/booking-services/success.html');
				exit();
			}
		}else{
			foreach($_POST as $k=>$v){
				$assign_list[$k] = $v;
			}
			$assign_list["errMsg"] = $errMsg;
		}
	}
	unset($listTourTopHot);
	
	/*=============Title & Description Page==================*/
	$title_page = $clsService->getTitle($service_id).' | '.$core->get_Lang('travelservices').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $clsISO->getMetaDescription($service_id,'Service');
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = $clsISO->getPageImageShare($service_id,'Service');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
	/*=============Content Page==================*/
}
function default_cat(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$extLang;
	global $clsISO;
	
	$clsService = new Service(); $assign_list['clsService']=$clsService;
	$clsServiceCategory = new ServiceCategory(); $assign_list['clsServiceCategory'] = $clsServiceCategory;
	$clsPagination = new Pagination();
	#
	$slug_cat = $_GET['slug_cat'];
	$all = $clsServiceCategory->getAll("is_trash=0 and slug='$slug_cat' LIMIT 0,1");
	$servicecat_id = intval($all[0][$clsServiceCategory->pkey]);
	if($servicecat_id==0){

		header('location:'.PCMS_URL.$extLang);
		exit();
	}
	$assign_list['servicecat_id']=$servicecat_id;
	$oneItem = $clsServiceCategory->getOne($servicecat_id);
	#
	$title_page = $clsServiceCategory->getTitle($servicecat_id);

	$recordPerPage = 6;
	$currentPage = isset($_GET['page'])?intval($_GET['page']):1;
	
	$cond = "is_trash=0 and is_online=1";
	
	$cond.= " and (cat_id='$servicecat_id' or list_cat_id like '%|$servicecat_id|%')";

	$link_page = $clsServiceCategory->getLink($servicecat_id);
	
	$order_by = " order by order_no desc";
	$totalRecord = $clsService->countItem($cond);
	
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> $link_page,
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);
	
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	#
	$listService = $clsService->getAll($cond.$order_by.$limit,$clsService->pkey.',cat_id,reg_date');
	$assign_list['listService']=$listService;unset($listService);
	$assign_list['page_view']=$page_view; unset($page_view);
	$assign_list['totalPage'] = $clsPagination->getTotalPage();
	
    /*=============Title & Description Page==================*/
	$title_page = $title_page.' | '.$core->get_Lang('Services').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $clsISO->getMetaDescription($servicecat_id,'ServiceCategory');
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = $clsISO->getPageImageShare($servicecat_id,'ServiceCategory');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
	/*=============Content Page==================*/
	unset($clsService);unset($clsServiceCategory);
}

?>
