<?php
require_once(DIR_INCLUDES.'/isoman/php/index.php');
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
	$listAdsHome = $clsAds->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,1", $clsAds->pkey);
	$assign_list['listAdsHome']=$listAdsHome;
	

	#whywith_us
	$listWhyHome=$clsWhy->getAll("is_trash=0 and is_online=1 and type='HOME' order by order_no ASC",$clsWhy->pkey);
	$assign_list['listWhyHome'] = $listWhyHome; 
	unset($listWhyHome);
	 
    /*=============Title & Description Page==================*/
	$title_page = $clsConfiguration->getValue('SiteMetaTitle');
	$assign_list["title_page"] = $title_page;
	$description_page =$clsConfiguration->getValue('SiteMetaDescription');;
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page =$clsConfiguration->getValue('ImageShareSocial');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
	/*=============Content Page==================*/
	unset($clsTour);

}
function default_video(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsISO;
	#

}
function default_unknow(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$extLang,$oneCommon;
	
	$URI = $_SERVER['REQUEST_URI'];
	if(str_replace('//','/',$URI.'/')==$URI.'/'){
		header('location: '.$URI.'/');
	}
	/*=============Title & Description Page==================*/
	$title_page = '404 page - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '404';
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = '404';
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
}
function default_popup(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$domain;
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
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$domain;
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
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$domain;
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
	$current_date = date('m/d/Y');
	$current_time = strtotime($current_date);
	#
	if($clsSubscribe->checkValidEmail($email) == '0') {
		$fx = "fullname,email,user_ip,reg_date,departure_date,receive_newsletter";
		$vx = "'$name','$email','".$_SERVER['REMOTE_ADDR']."','".time()."','".$current_time."','1'";
		if($clsSubscribe->insertOne($fx,$vx)) {
				$clsSubscribe->sendMail($email);
			echo '_SUCCESS|||'.html_entity_decode($clsConfiguration->getValue('SiteMsg_SubscribeSuccess')); die();
			}
		} else {
			echo '_EXIST|||'.$core->get_Lang('Email address already exists !'); die();
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
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$profile_id;
	if(!class_exists('UploadFile')){ require_once(DIR_COMMON.'/class.upload.php'); }
	$clsISO = new ISO();
	$clsReviews = new Reviews();
	$clsProfile = new Profile();
	$clsImage = new Image();
	#
	$_LANG_ID = isset($_POST['_LANG_ID'])?addslashes($_POST['_LANG_ID']):'';
	$type = $_POST['type'];
	$table_id = $_POST['table_id'];
	$rates = $_POST['rates'];
	$message = $_POST['message'];
	$datastore_folder = "/datastore/".$clsProfile->getUsername($profile_id);
	$datastore_folder = str_replace('@','',$datastore_folder);
	#
	$f="reviews_id,reg_date,table_id,type,rates,content,order_no,is_trash,is_online,profile_id";
	$reviews_id = $clsReviews->getMaxId();
	$v ="'".$reviews_id."'
	,'".time()."'
	,'".$table_id."'
	,'".$type."'
	,'".$rates."'
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
		echo '_SUCCESS'; die();
	}else{
		echo '_ERROR';
	}
}
function default_ajSaveReviewsNoLogin(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$profile_id;
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
	$f="reviews_id,reg_date,table_id,type,rates,fullname,email,country_id,content,order_no,is_trash,is_online";
	$reviews_id = $clsReviews->getMaxId();
	$v ="'".$reviews_id."'
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
		echo '_SUCCESS'; die();
	}else{
		echo '_ERROR';
	}
}
function default_ajLoadMoreTopTourPromotion() {
	 global $smarty, $assign_list, $_CONFIG,$core, $dbconn, $mod, $act, $_LANG_ID,$title_page, $description_page, $global_image_seo_page,$clsISO,$cat_id,$profile_id;
	
	$clsTourCategory  = new TourCategory(); $assign_list['clsTourCategory']=$clsTourCategory;
	$clsTour = new Tour();$assign_list['clsTour']=$clsTour;
	$clsPromotion=new Promotion(); $assign_list['clsPromotion']=$clsPromotion;
	$clsReviews= new Reviews(); $assign_list['clsReviews']=$clsReviews;
	$clsTourStore = new TourStore();$assign_list['clsTourStore'] = $clsTourStore;
	$cond ="is_online=1 and clsTable='Tour' and target_id in (SELECT default_tour.tour_id FROM default_tour WHERE is_trash = 0 and is_online = 1 ) and ".time()." between  start_date and end_date";
	$orderby=" ORDER BY promotion_id DESC";

	$numberPage = isset( $_POST['page'] )? $_POST['page']:1;
	$assign_list["numberPage"] = $numberPage;
	$itemOnPage = 6;
	$limit = " limit ".(($numberPage-1)*$itemOnPage).",".($itemOnPage);

	#
	$listTopTourPromotion = $clsPromotion->getAll($cond.$orderby.$limit,$clsPromotion->pkey.",target_id");
	$assign_list["listTopTourPromotion"] = $listTopTourPromotion;
	$html = $core->build('load_more_top_tour_promotion.tpl');
	echo $html; die;
}
function default_ajLoadMoreTopTourHomePage() {
	 global $smarty, $assign_list, $_CONFIG,$core, $dbconn, $mod, $act, $_LANG_ID,$title_page, $description_page, $global_image_seo_page,$clsISO,$cat_id,$profile_id;
	
	$clsTourStore = new TourStore();$smarty->assign("clsTourStore",$clsTourStore);
	$clsTour = new Tour();$smarty->assign("clsTour",$clsTour);
	$clsPagination=new Pagination(); $smarty->assign('clsPagination',$clsPagination);
	$clsReviews=new Reviews(); $smarty->assign('clsReviews',$clsReviews);
	
	
	$cond="is_trash=0 and _type='TOPTOUR' and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE is_trash=0 and is_online=1)";
	$orderby=" order by order_no ASC";
	$recordPerPage = 6;
	$currentPage = isset($_POST['page'])?intval($_POST['page']):1;
	
	
	$totalRecord = count($clsTourStore->getAll($cond));
	
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
	
	$listTopTourHomePage = $clsTourStore->getAll($cond.$orderby.$limit,$clsTour->pkey);
	$assign_list["listTopTourHomePage"] = $listTopTourHomePage;
	$html = $core->build('load_more_top_tour_home_page.tpl');
	echo $html; die;
}
function default_check_open_mail(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$profile_id;
	$clsISO = new ISO();
	$clsFeedback = new Feedback();
	#
	$feedback_id = $_GET['feedback_id'];
	print_r($feedback_id); die();
	
	$clsFeedback->updateOne($feedback_id,"is_open_mail=1");
	exit;
}
function default_home_storeshop(){
	 global $smarty, $assign_list, $_CONFIG,$core, $dbconn, $mod, $act, $_LANG_ID,$title_page, $description_page, $global_image_seo_page,$clsISO,$cat_id,$profile_id;
}

?>