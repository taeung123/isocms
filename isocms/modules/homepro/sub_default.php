<?php
require_once(DIR_INCLUDES.'/isoman/php/index.php');
function default_default2(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsConfiguration,$clsISO,$package_id;
	#
	$clsTour=new Tour(); $assign_list['clsTour']=$clsTour;
	$clsTourCategory = new TourCategory(); $assign_list['clsTourCategory']=$clsTourCategory;
	$clsTestimonial=new Testimonial(); $assign_list['clsTestimonial']=$clsTestimonial;
	$clsCity=new City(); $assign_list['clsCity']=$clsCity;
	$clsCountry=new Country(); $assign_list['clsCountry']=$clsCountry;
	$clsProperty = new Property();$assign_list["clsProperty"] = $clsProperty;
	$clsAds = new Ads();$assign_list['clsAds']=$clsAds;
	$clsSlide = new Slide();$assign_list['clsSlide']=$clsSlide;
	$clsReviews=new Reviews(); $assign_list['clsReviews']=$clsReviews;
	$clsWhy=new Why(); $assign_list['clsWhy'] = $clsWhy;
	#
	
	#ads
	if($clsISO->getCheckActiveModulePackage($package_id,'ads','default','default')){
		$listAdsHome = $clsAds->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,5", $clsAds->pkey);
		$assign_list['listAdsHome']=$listAdsHome;	
		unset($listAdsHome);
	}
	
	#whywith_us
	if($clsISO->getCheckActiveModulePackage($package_id,'why','default','default')){
		$listWhyHome=$clsWhy->getAll("is_trash=0 and is_online=1 and type='HOME' order by order_no ASC",$clsWhy->pkey);
		$assign_list['listWhyHome'] = $listWhyHome;
		unset($listWhyHome);
	}
	 
    /*=============Title & Description Page==================*/
	$title_page = PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page =$clsConfiguration->getValue('ImageShareSocial');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;

}
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsISO,$clsConfiguration;
	#
	$clsTour=new Tour(); $assign_list['clsTour']=$clsTour;
	$clsTourCategory = new TourCategory(); $assign_list['clsTourCategory']=$clsTourCategory;
	$clsTestimonial=new Testimonial(); $assign_list['clsTestimonial']=$clsTestimonial;
	$clsCity=new City(); $assign_list['clsCity']=$clsCity;
	$clsCountry=new Country(); $assign_list['clsCountry']=$clsCountry;
	$clsProperty = new Property();$assign_list["clsProperty"] = $clsProperty;
	$clsAds = new Ads();$assign_list['clsAds']=$clsAds;
	$clsSlide = new Slide();$assign_list['clsSlide']=$clsSlide;
	$clsReviews=new Reviews(); $assign_list['clsReviews']=$clsReviews;
	$clsWhy=new Why(); $assign_list['clsWhy'] = $clsWhy;
	#
	
	#ads
	$listAdsHome = $clsAds->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,5", $clsAds->pkey);
	$assign_list['listAdsHome']=$listAdsHome;
	#whywith_us
	$listWhyHome=$clsWhy->getAll("is_trash=0 and is_online=1 and type='HOME' order by order_no ASC",$clsWhy->pkey);
	$assign_list['listWhyHome'] = $listWhyHome;
	unset($listWhyHome);
	 
    /*=============Title & Description Page==================*/
	$title_page = PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page =$clsConfiguration->getValue('ImageShareSocial');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
	/*=============Content Page==================*/
	unset($clsTour);

}
function default_tour_start_date(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsISO,$clsConfiguration;
	#
	$clsTour= new Tour();$assign_list['clsTour']= $clsTour;
	$clsTourGroup= new TourGroup();$assign_list['clsTourGroup']= $clsTourGroup;
	$clsTourStartDate = new TourStartDate();$assign_list['clsTourStartDate']= $clsTourStartDate;
	
	$tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
	 if(intval($tour_group_id)==0) {
		header('location:'.PCMS_URL);
		exit();
	}
	$lstTourGroup = $clsTourGroup->getAll('is_trash=0 and is_online=1 order by order_no ASC',$clsTourGroup->pkey);
	$assign_list['lstTourGroup']= $lstTourGroup;
	unset($lstTourGroup);

	$lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '".time()."' and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour_store) and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') order by start_date asc limit 0,20",$clsTourStartDate->pkey.',tour_id');
	$assign_list['lstTourStartDate']= $lstTourStartDate;

	 
    /*=============Title & Description Page==================*/
	$title_page = PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page =$clsConfiguration->getValue('ImageShareSocial');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
	/*=============Content Page==================*/
	unset($clsTour);

}
function default_ajload_list_tour_start_date(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;
	#
	$clsTour= new Tour();$assign_list['clsTour']= $clsTour;
	$clsTourGroup= new TourGroup();$assign_list['clsTourGroup']= $clsTourGroup;
	$clsTourStartDate = new TourStartDate();$assign_list['clsTourStartDate']= $clsTourStartDate;
	
	$tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
	$lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '".time()."' and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour_store) and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') order by start_date asc limit 0,20",$clsTourStartDate->pkey.',tour_id');
	$assign_list['lstTourStartDate']= $lstTourStartDate;
	
	#
	$assign_list['tour_group_id']= $tour_group_id;
	
	$html = $core->build('load_list_tour_strat_date.tpl');
	echo $html; die();
}
function default_ajload_list_tour_start_date_mobile(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;
	#
	$clsTour= new Tour();$assign_list['clsTour']= $clsTour;
	$clsTourGroup= new TourGroup();$assign_list['clsTourGroup']= $clsTourGroup;
	$clsTourStartDate = new TourStartDate();$assign_list['clsTourStartDate']= $clsTourStartDate;
	
	$tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
	$lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '".time()."' and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour_store) and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') order by start_date asc limit 0,20",$clsTourStartDate->pkey.',tour_id');
	$assign_list['lstTourStartDate']= $lstTourStartDate;
	
	#
	$assign_list['tour_group_id']= $tour_group_id;
	
	$html = $core->build('load_list_tour_strat_date_mobile.tpl');
	echo $html; die();
}
function default_set_cookie(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;
	$clsCustomer = new Customer();
	$customer_str= isset($_GET['customer_id']) ? ($_GET['customer_id']) : '';
	$customer_id= intval($core->decryptID($customer_str));
	
	//print_r($customer_id); die();
	
	$is_online=$clsCustomer->getOneField('is_online',$customer_id);
	$package_id=$clsCustomer->getOneField('package_id',$customer_id);
	
	$expired_date=$clsCustomer->getOneField('expired_date',$customer_id);
	$customer_demo =$_COOKIE["customer_demo_isocms"];
	
	
	if($expired_date < time() || $is_online==0){
		if($is_online==0){
			setcookie("customer_demo_isocms","demo_isocms",time() - 100,"/");
			print_r("Bạn không được cấp quyền truy cập vào website này");die();
		}else{
			print_r("Bạn không được cấp quyền truy cập vào website này");die();
		}
	}else{
		if($package_id==1){
			setcookie("customer_demo_isocms","demo_isocms", $expired_date,"/"); 
			header('location:https://essentials.isocms.com');
			exit();
		}elseif($package_id==2){

			setcookie("customer_demo_isocms","demo_isocms", $expired_date,"/"); 
			header('location:https://professional.isocms.com');
			exit();
		}elseif($package_id==3){
			setcookie("customer_demo_isocms","demo_isocms", $expired_date,"/"); 
			header('location:https://premium.isocms.com');
			exit();
		}elseif($package_id==4){
			setcookie("customer_demo_isocms","demo_isocms", $expired_date,"/"); 
			header('location:https://isocms.com');
			exit();
		}else{
			header('location:http://isocms.net');
			exit();
		}
		
		
		setcookie("customer_demo_isocms","demo_isocms", $expired_date,"/"); 
		header('Location: '.DOMAIN_NAME);
		exit();
	}
}
function default_set_cookie2(){
	
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;

	$package_str= isset($_GET['sid']) ? ($_GET['sid']) : '';
	$package_id= intval($core->decryptID($package_str));
	if($package_id==5){
		$package_id=1;
	}
	if($package_id==6){
		$package_id=2;
	}
	if($package_id==7){
		$package_id=3;
	}
	if($package_id==8){
		$package_id=4;
	}
	
	$enip_str= isset($_GET['enip']) ? ($_GET['enip']) : '';
	$enip=$core->decryptID($enip_str);
	
	if($enip==$_SERVER['REMOTE_ADDR']){
		if($package_id==1){
			setcookie("get_demo_1","demo", time() + (86400 * 1),"/"); 
			header('location:http://essentials.isocms.com');
			exit();
		}elseif($package_id==2){
			setcookie("get_demo_2","demo", time() + (86400 * 1),"/"); 
			header('location:http://professional.isocms.com');
			exit();
		}elseif($package_id==3){
			setcookie("get_demo_3","demo", time() + (86400 * 1),"/"); 
			header('location:http://premium.isocms.com');
			exit();
		}elseif($package_id==4){
			setcookie("get_demo_4","demo", time() + (86400 * 1),"/"); 
			header('location:https://isocms.com');
			exit();
		}else{
			header('location:http://isocms.net');
			exit();
		}
	}else{
		header('location:http://isocms.net');
		exit();
	}
	
}
function default_test_html(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;
	//print_r($list_city); die('xxxx');
	
}

function getChartDataCompareByCat($city_id,$PCI_Cat,$list_year){
	global $core;
	$clsISO = new ISO();
	$clsCity = new City();
	$clsData_PCI = new Data_PCI();

	$arr = array();
	$result = array();

	$lstYear = $this->getAll("is_trash=0 and is_online=1 and year<>2005 and year IN ($list_year) order by year ASC");
	$arr['name'] = $clsISO->getNameCPICategory($PCI_Cat);

	foreach ($lstYear as $key => $value) {
		$arr['data'][] = (float)$clsCity->getPCIDataItemValue($city_id,$PCI_Cat,$value['year']);
	}	
	array_push($result,$arr);
	return json_encode($result); 
}

function default_test_map_box(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;
	
	$clsCity=new City();
	$clsTour=new Tour();$assign_list['clsTour']=$clsTour;
	$tour_id=512;
	$assign_list['tour_id']=$tour_id;
	
		
	$h=$clsTour->getLocationMapBox($tour_id);
	$u=$clsTour->getLocationMapBoxValue($tour_id);
	
	$assign_list['h_a']=$h;
	$assign_list['u_a']=$u;


}




function default_video(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;
	#
}
function default_unknow(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$extLang,$oneCommon;
	
	$URI = $_SERVER['REQUEST_URI'];
	if(str_replace('//','/',$URI.'/')==$URI.'/'){
		header('location: '.$URI.'/');
	}
	/*=============Title & Description Page==================*/
	$title_page = '404 page - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '404';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '404';
	$assign_list["keyword_page"] = $keyword_page;
}
function default_popup(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain;
	#
	$html='';
	$html.='<div class="header">
				<a class="closeEv clickToClose" href="javascript:void();" title="Đóng"></a>
				<h3 class="headPop">Send email to friend</h3>
			</div>';
	$html.='<div class="clearfix"></div>';
	$html.='<form id="SendToFriendForm" method="post" action="">';
	$html.='<div class="line-s">';
	$html.='<label class="tit">To (Name):</label>';
	$html.='<input class="txt" id="ToName" type="text" name="ToName">';
	$html.='</div>';
	$html.='<div class="line-s">';
	$html.='<label class="tit">To (Email):</label>';
	$html.='<input class="txt" id="ToEmail" type="text" name="ToEmail">';
	$html.='</div>';
	$html.='<div class="line-s">';
	$html.='<label class="tit">From (Name):</label>';
	$html.='<input class="txt" id="FromName" type="text" value="" name="FromName">';
	$html.='</div>';
	$html.='<div class="line-s">';
	$html.='<label class="tit">From (Email):</label>';
	$html.='<input class="txt" id="FromEmail" type="text" value="" name="FromEmail">';
	$html.='</div>';
	$html.='<div class="line-s">';
	$html.='<label class="tit">From (Email):</label>';
	$html.='<textarea id="Note" rows="2" cols="20" value="" class="textarea"></textarea>';
	$html.='</div>';
	$html.='<div class="line-s">';
	$html.='<label class="tit">&nbsp;</label>';
	$html.='<input id="SendToFriend" class="button" type="submit" value="Send">
			<input id="Reset" class="button" type="reset" value="Reset">';
	$html.='</div>';
	$html.='</form>';
	echo $html; die();
}
function default_checkCaptcha(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain;
	#
	$security_code = isset($_POST["security_code"])? $_POST["security_code"] : '';
	$security_code = strtoupper($security_code);
	$security_code = trim($security_code);
	if(!empty($security_code) && $security_code === vnSessionGetVar('skey')){
		echo 1;
	}else{
		echo 0;
	}
	//
	die();
}
function default_sendMail(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain;
	#
	$from = $_POST['FromEmail'];
	$to   = $_POST['ToEmail'];
	$subject = 'Send mail friend';
	$message = "Một lá thư được gửi đến từ ".$_POST['FromName']." <br/>";
	$message.= "Nội dung : ".$_POST['Note']." <br/>";
	$message.= "Đường dẫn website : ".$_POST['current_link']."";
	$headers = 	"MIME-Version: 1.0\r\n".
				"Content-type: text/html; charset=utf-8\r\n".
				"From:  ".$_POST['FromName']."<".$from.">\r\n".
				"Subject: ".$subject."\r\n";
	$is_send_mail = @mail($to,$subject,$message,$headers);
	die();
}
function default_ajMakeSelectboxCategory(){
	global $core;
	
	$clsTour = new Tour();
	$clsCountry = new Country();
	$clsTourCategory = new TourCategory();
	#
	$country_id = $_POST['country_id'];
	$cat_id = isset($_POST['cat_id'])?$_POST['cat_id']:'';
	
	$html = '<select class="selectbox" name="cat_id">';
	$html.= '<option value="0">-- Select vacation type --</option>';
	
	if(intval($country_id) > 0){
		$lstCategory = $clsTourCategory->getAll("is_trash=0 order by order_no asc");
		if(is_array($lstCategory) && count($lstCategory) > 0){
			foreach($lstCategory as $k=>$v){
				if($clsTour->countTourGolobal($country_id,0,0,$v[$clsTourCategory->pkey],0) > 0){
					$html.='<option value="'.$v[$clsTourCategory->pkey].'" '.($cat_id==$v[$clsTourCategory->pkey]?'selected="selected"':'').'>'.$clsTourCategory->getTitle($v[$clsTourCategory->pkey]).'</option>';
				}
			}
		}
		unset($lstCategory);
	}
	$html.='</select>';
	echo $html; die();
}
function default_ajMakeSelectboxDuration(){
	$clsTour = new Tour();
	$clsCountry = new Country();
	#
	$country_id = $_POST['country_id'];
	$cat_id = isset($_POST['cat_id'])?$_POST['cat_id']:'';
	$duration_id = isset($_POST['duration_id'])?$_POST['duration_id']:'';
	#
	$html = '<select class="selectbox" name="duration_id">';
	$html.='<option value="0">-- Select duration--</option>';
	#
	$cond= "is_trash=0 and is_online=1";
	if(intval($country_id) > 0){
		$cond .= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE country_id='$country_id')";
	}
	if(intval($cat_id) > 0){
		$cond .= " and (cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%')";
	}
	#
	if(intval($country_id) > 0 || intval($cat_id) > 0){
		$res = $clsTour->getAll($cond." order by number_day ASC limit 0,1000");
		$tmp='';
		if(!empty($res)){
			for ($i=0; $i < count($res); $i++) {
				$tmp .= $clsTour->getSelectTripDuration($res[$i]['tour_id']).'|';
			}
		}
		$tmp = array_unique(explode('|', $tmp));
		if(!empty($tmp)){
			foreach($tmp as $key=>$val){
				if($val!='' && $val!='n/a'){
					$selected = ($duration_id==$clsTour->convertDuration($val))?'selected="selected"':'';
					$html.='<option value="'.$clsTour->convertDuration($val).'" '.$selected.'>'.$val.'</option>';
				}
			}
		}
	}
	$html.='</select>';
	echo $html; die();
}
function default_ajMakeSelectboxCountry(){
	$clsCountry = new Country();
	#
	$res =$clsCountry->getAll("is_trash=0 order by order_no asc");
	$html = '<select class="selectbox" name="country_id">';
	$html.= '<option value="0">-- Select country --</option>';
	if(is_array($res) && count($res) > 0){
		foreach($res as $k => $v){
			$html.='<option value="'.$v[$clsCountry->pkey].'">-- '.$clsCountry->getTitle($v[$clsCountry->pkey]).' --</option>';
		}
	}
	$html .= '</select>';
	unset($res);
	echo $html; die();
}
function default_ajLoadPackageDeals() {
	global $core, $dbconn, $clsISO;
	#
	$clsTour = new Tour();
	$clsCountryEz = new Country();
	$country_id = isset($_POST['country_id'])?$_POST['country_id']:0;
	#
	$sql = "SELECT DISTINCT t1.tour_id FROM ".DB_PREFIX."tour t1 INNER JOIN ".DB_PREFIX."tour_destination t2 WHERE t1.tour_id = t2.tour_id AND t2.country_id='".$country_id."' and t1.is_trash=0 and t1.is_online=1 ORDER BY t1.order_no DESC limit 0,2";
	$lstTours = $dbconn->GetAll($sql);
	#
	$html = '';
	if(!empty($lstTours)) {
		for($i=0;$i<count($lstTours);$i++) {
			$tour_id = $lstTours[$i][$clsTour->pkey];
			$html.= '
			<div class="lst-ext-tours">
				<div class="row">
					<div class="col-md-3">
						<a class="photo" href="'.$clsTour->getLink($tour_id).'" title="'.$clsTour->getTitle($tour_id).'">
							<img src="'.$clsTour->getImageUrl($tour_id).'" width="100%" alt="" />
							<span class="priceTours hide_m">
								'.$core->get_Lang('Price').' <br/>
								<strong class="valPrice">'.$clsTour->getTripPrice($tour_id).'</strong>
							</span>
						</a>
					</div>
					<div class="col-md-7 r">
						<h3 class="title"><a href="'.$clsTour->getLink($tour_id).'" title="'.$clsTour->getTitle($tour_id).'">'.$clsTour->getTitle($tour_id).'</a></h3>
						<div class="div_sub_duration">
							'.$core->get_Lang('Durations').':  <b class="val">'.$clsTour->getTripDuration($tour_id).'</b>
						</div>
						<div class="div_sub_arround">
							'.$core->get_Lang('Destinations').':  '.$clsTour->getCityAround($tour_id).'
						</div>
						<div class="intro">'.$clsISO->truncateWord($clsTour->getStripIntro($tour_id),20).'</div>
					</div>
					<div class="col-md-2 boxPrice hide_s">
						<div class="priceVal">
							<div class="price_from">'.$core->get_Lang('Price').'</div>
							<div class="valPrice">'.$clsTour->getTripPrice($tour_id).'</div>
						</div>
						<a class="view" href="'.$clsTour->getLink($tour_id).'" title="'.$core->get_Lang('View detail').'">'.$core->get_Lang('View detail').'></a>
					</div>
				</div>
			</div>';
		}
	}
	echo($html.'|||'.$clsCountryEz->getLinkTour($country_id)); die();
}

function default_ajaxLoadTotalWishlist(){
	global $core,$dbconn,$profile_id;
	#
	
	$clsTable = isset($_POST['clsTable'])?$_POST['clsTable']:'';
	$clsClassTable = new $clsTable();
	$target_id = isset($_POST['target_id'])?$_POST['target_id']:0;
	$user_id = $core->_USER['user_id'];
	#
	$totalWishlist = $clsClassTable->getOneField('wishlist_num',$target_id);
	
	echo $totalWishlist; die();
}

function default_ajaxSetCodeRate(){
	global $core,$dbconn,$profile_id;
	#
	
	vnSessionDelVar('CurrencyCode'); 

	$CurrencyCode = isset($_POST['CODE'])?$_POST['CODE']:'USD';
	vnSessionSetVar('CurrencyCode', $CurrencyCode);
	
	echo $CurrencyCode; die();
}


function default_ajUpdateWishlist(){
	global $core,$dbconn,$profile_id;
	#
	$clsWishlist = new Wishlist();
	$clsTable = isset($_POST['clsTable'])?$_POST['clsTable']:'';
	$clsClassTable = new $clsTable;
	$target_id = isset($_POST['target_id'])?$_POST['target_id']:0;
	$wishlist_num=$clsClassTable->getOneField('wishlist_num',$target_id);
	$user_id = $core->_USER['user_id'];
	#
	$lst = $clsWishlist->getAll("target_id='$target_id' and clsTable = '".$clsTable."' and member_id='".$profile_id."' limit 0,1");
	if(isset($lst[0][$clsWishlist->pkey])) {
		echo '_EXIST'; die();
	}else{
		$fx = "wishlist_id,target_id,clsTable,member_id";
		$vx = "'".$clsWishlist->getMaxID()."','$target_id','$clsTable','$profile_id'";
		$clsWishlist->insertOne($fx,$vx);
	}
	$wishlist_num_update=$wishlist_num + 1;
	$set = "wishlist_num='".$wishlist_num_update."'";
	$clsClassTable->updateOne($target_id,$set);
	echo 1; die();
}
function default_ajDeleteWishlist(){
	global $core,$dbconn,$profile_id;
	#
	$clsWishlist = new Wishlist();
	$clsTable = isset($_POST['clsTable'])?$_POST['clsTable']:'';
	$clsClassTable = new $clsTable;
	$target_id = isset($_POST['target_id'])?$_POST['target_id']:0;
	$wishlist_num=$clsClassTable->getOneField('wishlist_num',$target_id);
	$user_id = $core->_USER['user_id'];
	#
	
	$lst = $clsWishlist->getAll("target_id='$target_id' and clsTable = '".$clsTable."' limit 0,1");
	if(isset($lst[0][$clsWishlist->pkey])) {
		$wishlist_id = $lst[0][$clsWishlist->pkey];
		$clsWishlist->deleteOne($wishlist_id);
		
	}
	echo '_SUSSESS'; die();
}

function default_ajSubmitSubscribe() {
    global $core,$mod,$act, $clsConfiguration;
	$clsSubscribe =new Subscribe();
	#
	$email = isset($_POST['email'])?addslashes($_POST['email']):'';
	$name = isset($_POST['name'])?addslashes($_POST['name']):'';
	$subscribe_check = isset($_POST['subscribe_check'])?addslashes($_POST['subscribe_check']):'';
	
	$current_date = date('m/d/Y');
	$current_time = strtotime($current_date);
	#
	if($subscribe_check==''){
		if($clsSubscribe->checkValidEmail($email) == '0') {
			$fx = "$clsSubscribe->pkey,fullname,email,user_ip,reg_date,departure_date,receive_newsletter";
			$vx = "'".$clsSubscribe->getMaxId()."','$name','$email','".$_SERVER['REMOTE_ADDR']."','".time()."','".$current_time."','1'";
			if($clsSubscribe->insertOne($fx,$vx)) {
					$clsSubscribe->sendMail($email);
				echo '_SUCCESS|||'.html_entity_decode($clsConfiguration->getValue('SiteMsg_SubscribeSuccess')); die();
				}
			} else {
				echo '_EXIST|||'.$core->get_Lang('Email address already exists !'); die();
		}
	}else{
		echo '_ERROR|||'.$core->get_Lang('subscribe error'); die();
	}
}
function default_ajQuickBooking() {
    global $core,$mod,$act, $clsConfiguration;
	$clsBooKingRoom =new BooKingRoom();
	#
	$name = isset($_POST['name'])?addslashes($_POST['name']):'';
	$email = isset($_POST['email'])?addslashes($_POST['email']):'';
	$phone = $_POST['phone'];
	$intro = $_POST['intro'];
	$type = $_POST['type'];
	#
	$max_id = $clsBooKingRoom->getMaxId();
	$fx = "booking_room_id,fullname,phone,email,type,intro_email,user_ip,reg_date";
	$vx = "'$max_id','$name',$phone,'$email','$type','$intro','".$_SERVER['REMOTE_ADDR']."','".time()."'";
	if($clsBooKingRoom->insertOne($fx,$vx)) {
		$clsBooKingRoom->sendMailQuickBooKing($max_id);
	echo '_SUCCESS|||'.html_entity_decode($clsConfiguration->getValue('SiteMsg_SubscribeSuccess')); die();
	}
}
function default_ajSaveReviews(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$profile_id;
	if(!class_exists('UploadFile')){ require_once(DIR_COMMON.'/class.upload.php'); }
	$clsISO = new ISO();
	$clsReviews = new Reviews();
	$clsProfile = new Profile();
	$clsImage = new Image();
	#
	$_LANG_ID = isset($_POST['_LANG_ID'])?addslashes($_POST['_LANG_ID']):'';
	$type = $_POST['type'];
	if($type=='tour_new'){
		$type ='tour';
	}
	$table_id = $_POST['table_id'];
	$rates = $_POST['rates'];
	$message = $_POST['message'];
	$datastore_folder = "/datastore/".$clsProfile->getUsername($profile_id);
	$datastore_folder = str_replace('@','',$datastore_folder);
	#
	$fullname = $clsProfile->getFullname($profile_id);
	$full_name_slug = $core->replaceSpace($fullname);
	$email = $clsProfile->getEmail($profile_id);
	
	$f="reviews_id,reg_date,review_date,upd_date,table_id,type,rates,fullname,slug,email,content,order_no,is_trash,is_online,profile_id";
	$reviews_id = $clsReviews->getMaxId();
	$v ="'".$reviews_id."'
	,'".time()."'
	,'".time()."'
	,'".time()."'
	,'".$table_id."'
	,'".$type."'
	,'".$rates."'
	,'".$fullname."'
	,'".$full_name_slug."'
	,'".$email."'
	,'".addslashes($message)."'
	,'".$clsReviews->getMaxOrderNo()."'
	,'0','0'
	,'".$profile_id."'";	
	//echo $f.'---'.$v;die('xxx');
	
	if($clsReviews->insertOne($f, $v)){
		if($_FILES['media_images']['name'][0] !=''){
			$clsUploadFile = new UploadFile();
			for($i=0;$i<count($_FILES['media_images']['name']);$i++){
				$file = array();
				$file["name"] = $_FILES['media_images']['name'][$i];
				$file["type"] = $_FILES['media_images']['type'][$i];
				$file["tmp_name"] = $_FILES['media_images']['tmp_name'][$i];
				$file["error"] = $_FILES['media_images']['error'][$i];
				$file["size"] = $_FILES['media_images']['size'][$i];
				
				$image = '';
				if(!is_uploaded_file($file['name'])){
					$image = $clsUploadFile->uploadItem($file,$datastore_folder,"jpg,gif,png");
				}
				if($image != '0' && $image != ''){
					$field = 'image_id,table_id,type,image,order_no,reg_date';
					$value = "'".$clsImage->getMaxId()."'
					,'$reviews_id'
					,'_REVIEW'
					,'".addslashes($image)."'
					,'".$clsImage->getMaxOrderNo($reviews_id,'_REVIEW')."'
					,'".time()."'";
					#
					$clsImage->insertOne($field,$value);
				}
			}
		}
        //$aaa = $clsReviews->sendMail($clsProfile->getEmail($profile_id),$message,$type);
        if($aaa){
            echo '_SUCCESS - '.$aaa; die();
        }else{
            echo '_SUCCESS - error send mail'; die();
        }
//		echo '_SUCCESS'; die();
	}else{
		echo '_ERROR';
	}
}
function default_ajSaveReviewsNoLogin(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$profile_id;
	$clsISO = new ISO();
	$clsReviews = new Reviews();
	#
	$type = $_POST['type'];
	$table_id = $_POST['table_id'];
	$rates = $_POST['rates'];
	$fullname = $_POST['fullname'];
	$email = $_POST['email_reviews'];
	$country_id = $_POST['country_id'];
	$message = $_POST['message'];

	#
	$f="reviews_id,reg_date,review_date,upd_date,table_id,type,rates,fullname,email,country_id,content,order_no,is_trash,is_online";
	$reviews_id = $clsReviews->getMaxId();
	$v ="'".$reviews_id."'
	,'".time()."'
	,'".time()."'
	,'".time()."'
	,'".$table_id."'
	,'".$type."'
	,'".$rates."'
	,'".$fullname."'
	,'".$email."'
	,'".$country_id."'
	,'".addslashes($message)."'
	,'".$clsReviews->getMaxOrderNo()."'
	,'0','0'";	
	
	if($clsReviews->insertOne($f, $v)){
	    $aaa = $clsReviews->sendMail($email,$message,$type);
        if($aaa){
            echo '_SUCCESS - '.$aaa; die();
        }else{
            echo '_SUCCESS - error send mail'; die();
        }

	}else{
		echo '_ERROR';
	}
}
function default_ajLoadMoreBlog() {
    global $smarty, $assign_list, $_CONFIG,$core, $dbconn, $mod, $act, $_LANG_ID,$title_page, $description_page, $keyword_page,$clsISO,$cat_id,$profile_id,$lang_sql;;

    $clsBlog= new Blog();$smarty->assign('clsBlog',$clsBlog);
    $cond="is_trash=0 and is_approve=1 and is_online=1 ";
    $orderby=" ORDER BY order_no ASC";
    $recordPerPage = 4;

    $currentPage = isset($_POST['pageBlog'])?intval($_POST['pageBlog']):1;
    $assign_list["numberPage"] = $currentPage;
    $offset = ($currentPage-1)*$recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    $lstTopBlog = $clsBlog->getAll($cond.$orderby.$limit);

    $assign_list["lstTopBlog"] = $lstTopBlog;
    $html = $core->build('load_more_blog.tpl');
    echo $html; die;
}
function default_ajLoadMoreTopTourPromotion() {
	 global $smarty, $assign_list, $_CONFIG,$core, $dbconn, $mod, $act, $_LANG_ID,$title_page, $description_page, $keyword_page,$clsISO,$cat_id,$profile_id,$lang_sql,$deviceType;
	
	$clsTourCategory  = new TourCategory(); $assign_list['clsTourCategory']=$clsTourCategory;
	$clsTour = new Tour();$assign_list['clsTour']=$clsTour;
	$clsPromotion=new Promotion(); $assign_list['clsPromotion']=$clsPromotion;
	$clsReviews= new Reviews(); $assign_list['clsReviews']=$clsReviews;
	$clsTourStore = new TourStore();$assign_list['clsTourStore'] = $clsTourStore;
    $clsPromotion=new Promotion(); $smarty->assign('clsPromotion',$clsPromotion);
    $clsPromotionItem=new PromotionItem(); $smarty->assign('clsPromotionItem',$clsPromotionItem);
    $clsProfile= new Profile();
	$cond ="is_online=1 and clsTable='Tour' and target_id in (SELECT default_tour.tour_id FROM default_tour WHERE is_trash = 0 and is_online = 1 ) and ".time()." between  start_date and end_date";
    if(_ISOCMS_CLIENT_LOGIN){
        $cond1="SELECT pi.taget_id FROM ".$clsPromotion->tbl." p LEFT JOIN ".$clsPromotionItem->tbl." pi ON(p.".$clsPromotion->pkey." = pi.".$clsPromotion->pkey.") WHERE p.is_online = 1 and pi.is_online = 1 ";
        $loggedIn = $clsProfile->isLoggedIn();
        if($loggedIn==1){
            $cond1 .= "";
        }else{
            $cond1 .= " and p.check_mem_set = 0";
        }
        $cond1 .= " and p.type = 'Tour' and pi.taget_id in (SELECT default_tour.tour_id FROM default_tour WHERE is_trash = 0 and is_online = 1 and lang_id='$lang_sql') and ".time()." between  p.start_date and p.end_date ";
    }else{
        $cond1="SELECT pi.taget_id FROM ".$clsPromotion->tbl." p LEFT JOIN ".$clsPromotionItem->tbl." pi ON(p.".$clsPromotion->pkey." = pi.".$clsPromotion->pkey.") WHERE p.is_online = 1 and pi.is_online = 1  and p.type = 'Tour' and pi.taget_id in (SELECT default_tour.tour_id FROM default_tour WHERE is_trash = 0 and is_online = 1 and lang_id='$lang_sql') and ".time()." between  p.start_date and p.end_date ";
    }

    $orderby=" ORDER BY p.end_date ASC";
    if($deviceType=='phone'){
		$recordPerPage = 2;
	}else{
		$recordPerPage = 8;
	}
    $currentPage = isset( $_POST['page'] )? $_POST['page']:1;
	$assign_list["numberPage"] = $currentPage;
    $offset = ($currentPage-1)*$recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    $listTopTourPromotion = $dbconn->GetAll($cond1.$orderby.$limit);
	$assign_list["listTopTourPromotion"] = $listTopTourPromotion;
	$html = $core->build('load_more_top_tour_promotion.tpl');
	echo $html; die;
}
function default_ajLoadMoreTopTourHomePage() {
	 global $smarty, $assign_list, $_CONFIG,$core, $dbconn, $mod, $act, $_LANG_ID,$title_page, $description_page, $keyword_page,$clsISO,$cat_id,$profile_id,$deviceType;
	
	$clsTourStore = new TourStore();$smarty->assign("clsTourStore",$clsTourStore);
	$clsTour = new Tour();$smarty->assign("clsTour",$clsTour);
	$clsPagination=new Pagination(); $smarty->assign('clsPagination',$clsPagination);
	$clsReviews=new Reviews(); $smarty->assign('clsReviews',$clsReviews);
	
	$width = isset($_POST['width'])?intval($_POST['width']):0;
	
	$cond="is_trash=0 and _type='TOPTOUR' and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE is_trash=0 and is_online=1)";
	$orderby=" order by order_no ASC";
	if($deviceType=='phone'){
		$recordPerPage = 2;
	}else{
		if($_LANG_ID=='vn'){
			$recordPerPage = 12;
		}else{
			$recordPerPage = 6;
		}
		
	}
	
	$currentPage = isset($_POST['page'])?intval($_POST['page']):1;

    $totalRecord = $clsTourStore->getAll($cond,$clsTourStore->pkey);
	$totalRecord=$totalRecord?count($totalRecord):0;
	$smarty->assign('totalRecord',$totalRecord);
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);
	
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	
	$listTopTour = $clsTourStore->getAll($cond.$orderby.$limit,$clsTour->pkey);
	$assign_list["listTopTour"] = $listTopTour;
	$html = $core->build('load_more_top_tourpro.tpl');
	echo $html; die;
}
function default_ajLoadMoreTourCategory() {
	 global $smarty, $assign_list, $_CONFIG,$core, $dbconn, $mod, $act, $_LANG_ID,$title_page, $description_page, $keyword_page,$clsISO,$cat_id,$profile_id,$deviceType;
	
	$clsTourCategory = new TourCategory();$smarty->assign("clsTourCategory",$clsTourCategory);
	$clsPagination=new Pagination(); $smarty->assign('clsPagination',$clsPagination);
	
	
	$cond="is_trash=0 and is_online=1 and parent_id=0";
	$orderby=" order by order_no ASC";
	$recordPerPage = 5;
	
	$currentPage = isset($_POST['page'])?intval($_POST['page']):1;

    $totalRecord = $clsTourCategory->getAll($cond,$clsTourCategory->pkey);
	$totalRecord=$totalRecord?count($totalRecord):0;
	$smarty->assign('totalRecord',$totalRecord);
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);
	
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	
	$lstCatTour = $clsTourCategory->getAll($cond.$orderby.$limit, $clsTourCategory->pkey.", title");
	$assign_list["lstCatTour"] = $lstCatTour;
	
	$html = $core->build('load_more_tour_cat_home_page.tpl');
	echo $html; die;
}
function default_check_open_email(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$profile_id;
	$clsISO = new ISO();
	$clsFeedback = new Feedback();
	#
	$feedback_id = isset($_GET['feedback_id'])?intval($_GET['feedback_id']):0;
	
	$clsFeedback->updateOne($feedback_id,"is_open_mail=1");
	exit;
}
function default_ajCheckPromotionPro(){
    global $core,$dbconn,$profile_id,$_LANG_ID,$clsISO;
    #
    header('Content-type: application/json;');
    $clsPromotion =new Promotion();
    $clsPromotionItem =new PromotionItem();
    $voucher = isset($_POST['voucher'])?$_POST['voucher']:'';
    $type = isset($_POST['type'])?$_POST['type']:'';
    $results = array('result'=>'error');
    $check_pro=$clsPromotion->getCheckPromotionCode($voucher,$type);
    if($check_pro>=1){
        $getAll_by_code= $clsPromotion->getAll("is_online = 1 and promotion_code ='".$voucher."' and `type`='".$type."'",$clsPromotion->pkey.",promot");
        $html='';
        $html .='<div class="line"><label>'.$core->get_Lang("Promotion").' ('.$getAll_by_code[0]['promot'].'%)</label><input type="hidden" name="promotion" id="promotion" value="'.$getAll_by_code[0]['promot'].'" /><input type="hidden" name="price_promotion" id="price_promotion_post" value="0" />';
            if ($_LANG_ID == "vn"){
                $html .='<span class="right"><span id="price_promotion">1000</span>'.$clsISO->getShortRate().'</span>';
            }else{
                $html .='<span class="right">'.$clsISO->getShortRate().'<span id="price_promotion">1000</span></span>';
            }
                $html .='</div><script>var promotion_check="'.$getAll_by_code[0]['promot'].'"</script>';
        $results = array('result'=>'success','verify'=>$html);
    }else{
        $results = array('result'=>'error');
    }

    echo json_encode($results);exit();
}
function default_ajSendRegAdvisory(){
    global $core,$dbconn,$profile_id,$_LANG_ID,$clsISO;
    #
    header('Content-type: application/json;');

    $clsFeedback=new Feedback(); $assign_list['clsFeedback'] = $clsFeedback;

    $results = array('result'=>'error');

    if($_POST){
        $clsFeedback->newRegAdvisory($_POST);
        $results = array('result'=>'success');
    }else{
        $results = array('result'=>'error');
    }

    echo json_encode($results);die();
}

//promotion
function default_promotion(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsConfiguration,$clsISO,$package_id,$lang_sql,$now_day;
	#
//	ini_set('display_errors', '1');
//	ini_set('display_startup_errors', '1');
//	error_reporting(E_ALL);
	$clsDiscountItem = new DiscountItem();
	$assign_list['clsDiscountItem'] = $clsDiscountItem;
	
	
	$clsReviews=new Reviews(); 
	$assign_list['clsReviews'] = $clsReviews;
	
	$clsTour = new Tour();
	$assign_list['clsTour'] = $clsTour;
	
	$clsIso = new ISO();
	$assign_list['clsIso'] = $clsIso;
	
	$clsPagination=new Pagination();
	$assign_list['clsPagination'] = $clsPagination;
	
	$cond="is_trash=0 and item_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE is_trash=0 and is_online=1 and lang_id = '".$lang_sql."' order by order_no ASC) and discount_id IN (SELECT discount_id FROM ".DB_PREFIX."discount WHERE is_trash=0 and is_online=1 and lang_id = '".$lang_sql."' and ".$now_day." between booking_date_from and booking_date_to and ".$now_day." between travel_date_from and travel_date_to) group by item_id ";
	$totalRecord = $clsDiscountItem->countItem($cond);
	
	$recordPerPage = 8;
	$currentPage = isset($_GET['page'])?intval($_GET['page']):1;
	
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	$listPromotionId = $clsDiscountItem->getAll($cond.$limit,$clsDiscountItem->pkey.',item_id');
	$assign_list['listPromotionId'] = $listPromotionId;
	
	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	
	/*=============Title & Description Page==================*/
	$title_page = PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page =$clsConfiguration->getValue('ImageShareSocial');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
	/*=============Content Page==================*/
	
	unset($listPromotionId);
}

function default_ajaxLoadMorePromotion(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsISO,$clsConfiguration,$lang_sql,$now_day;
	$clsDiscountItem = new DiscountItem();
	$assign_list['clsDiscountItem'] = $clsDiscountItem;
	
	$clsTour = new Tour();
	$assign_list['clsTour'] = $clsTour;
	
	$clsIso = new ISO();
	$assign_list['clsIso'] = $clsIso;
	
	$clsReviews=new Reviews(); 
	$assign_list['clsReviews'] = $clsReviews;
	
	$currentPage = isset( $_POST['page'] )? $_POST['page']:1;
	$recordPerPage = 8;
	$assign_list["numberPage"] = $currentPage;
    $offset = ($currentPage-1)*$recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
	$cond="is_trash=0 and item_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE is_trash=0 and is_online=1 and lang_id = '".$lang_sql."' order by order_no ASC) and discount_id IN (SELECT discount_id FROM ".DB_PREFIX."discount WHERE is_trash=0 and is_online=1 and lang_id = '".$lang_sql."' and ".$now_day." between booking_date_from and booking_date_to and ".$now_day." between travel_date_from and travel_date_to) group by item_id ";
	$totalRecord = $clsDiscountItem->countItem($cond);
  	$listPromotionId = $clsDiscountItem->getAll($cond.$limit,$clsDiscountItem->pkey.',item_id');
	$assign_list["listPromotionId"] = $listPromotionId;
	$html = $core->build('load_more_tour_promotion.tpl');
	echo $html; die;
}
?>