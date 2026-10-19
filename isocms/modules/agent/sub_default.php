<?php
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain,$country_id,$city_id,$cat_id,$extLang;
	#Blog;
	
	
    /*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Travel Agent').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_agent_profile(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain,$country_id,$city_id,$cat_id,$extLang;
	#Blog;
	
	$clsAgent = new Agent();
	$clsFeedback = new Feedback();
	$clsDownload = new Download();
	$clsCountry = new _Country();
	$clsCountryx = new Country();
	$assign_list["clsAgent"] = $clsAgent;
	$assign_list["clsFeedback"] = $clsFeedback;
	$assign_list["clsDownload"] = $clsDownload;
	$assign_list["clsCountry"] = $clsCountry;
	$assign_list["clsCountryx"] = $clsCountryx;
	
	#
	$agent_id = $_SESSION['agent_id'];
	$oneAgent = $clsAgent->getOne($agent_id);
	$assign_list["oneAgent"] = $oneAgent;

	$lstRequest = $clsFeedback->getAll('is_trash=0 and email="' . $oneAgent['email'] . '" and type="request" order by order_no desc', $clsFeedback->pkey . ',feedback_code,target_id,is_process,feedback_html');
	$assign_list["lstRequest"] = $lstRequest;

	$title_page = $core->get_Lang('Setting profile').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_agent_register(){
	
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$extLang;
	global $clsISO;
	#

	$type = isset($_POST['type']) ? $_POST['type'] : '';

	$clsAgent = new Agent();
	$agent_max_id=$clsAgent->getMaxId();
	if($type=='AGENT'){
		if($clsAgent->checkExitsEmail($_POST['email']) == '1') {
			$assign_list["msg_error"] = $core->get_Lang("Email already exists");
		}else{
			$country_id = !empty($_POST['country_id']) ? $_POST['country_id'] : 0;
			$market_id = !empty($_POST['market_id']) ? $_POST['market_id'] : 0;

			$f = "agent_id,full_name,email,phone,company_name,position,tax_code,userpass,type,ip_register,reg_date,country_id,market_id";
			$v = "'".$agent_max_id."'";
			$v .= ",'".addslashes($_POST['full_name'])."'";
			$v .= ",'".addslashes($_POST['email'])."'";
			$v .= ",'".addslashes($_POST['phone'])."'";
			$v .= ",'".addslashes($_POST['company_name'])."'";
			$v .= ",'".addslashes($_POST['position'])."'";
			$v .= ",'".addslashes($_POST['tax_code'])."'";
			$userpass = $clsAgent->encrypt($_POST['password']);
			$v .= ",'".addslashes($userpass)."'";
			$v .= ",'".$type."'";
			$v .= ",'".$_SERVER['REMOTE_ADDR']."'";
			$v .= ",'".time()."'";
			$v .= ",'".$country_id."'";
			$v .= ",'".$market_id."'";
			if($clsAgent->insertOne($f,$v)){
				$clsAgent->sendEmailRegisterAgent($agent_max_id,$userpass);
				header('Location: ' . PCMS_URL . $extLang . '/travel-agent/signup-success.html');die;
			}else{
				$assign_list["msg_error"] = 'ERROR';
			}
		}
	}
	
    /*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Travel Agent').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	unset($clsBlog);unset($clsBlogCategory);
}

function default_register(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$extLang;
	global $clsISO,$dbconn;
	#
	$type = isset($_POST['type']) ? $_POST['type'] : '';
	
	$clsAgent = new Agent();
	$clsCountryEx = new _Country();
	$clsCountry = new Country();
	$agent_max_id=$clsAgent->getMaxId();
	$assign_list["listCountryEx"] = $clsCountryEx->getAll("1=1", "title, country_id");
	$assign_list["listMarket"] = $clsCountry->getAll("is_online=1 and is_trash=0", "title, country_id");
	$msg_error = "";
	if($type=='AGENT'){
		if($clsAgent->checkExitsEmail($_POST['email']) == '1') {
			$msg_error .= $core->get_Lang("Email already exists") . "<br />";
		}

		if (!$clsISO->checkGoogleReCAPTCHA()) {
			$msg_error .= $core->get_Lang("You must check Recaptcha") . "<br />";
		}

		if (empty($msg_error)) {
			$country_id = !empty($_POST['country_id']) ? $_POST['country_id'] : 0;
			$market_id = !empty($_POST['market_id']) ? $_POST['market_id'] : 0;
			$webiste = !empty($_POST['website']) ? $_POST['website'] : '';
			$userpass = $clsAgent->encrypt($_POST['password']);

			$f = "agent_id,full_name,email,phone,company_name,position,tax_code,userpass,type,ip_register,reg_date,country_id,market_id,website";
			$v = "'".$agent_max_id."'";
			$v .= ",'".addslashes($_POST['full_name'])."'";
			$v .= ",'".addslashes($_POST['email'])."'";
			$v .= ",'".addslashes($_POST['phone'])."'";
			$v .= ",'".addslashes($_POST['company_name'])."'";
			$v .= ",'".addslashes($_POST['position'])."'";
			$v .= ",'".addslashes($_POST['tax_code'])."'";
			$v .= ",'".addslashes($userpass)."'";
			$v .= ",'".$type."'";
			$v .= ",'".$_SERVER['REMOTE_ADDR']."'";
			$v .= ",'".time()."'";
			$v .= ",'".$country_id."'";
			$v .= ",'".$market_id."'";
			$v .= ",'".$webiste."'";
			if($clsAgent->insertOne($f,$v)){
				$clsAgent->sendEmailRegisterAgent($agent_max_id,$userpass);
				header('Location: ' . PCMS_URL . $extLang . '/travel-agent/signup-success.html');die;
			}else{
				$msg_error = $core->get_Lang("Sign-up failed. Please try again.");
			}
		}
		if (!empty($msg_error)) $assign_list["msg_error"] = $msg_error;
	}
	
    /*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Travel Agent').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	unset($clsBlog);unset($clsBlogCategory);
}

function default_ctv_register(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$extLang;
	global $clsISO,$dbconn;
	#
	$type = isset($_POST['type']) ? $_POST['type'] : '';
	
	$clsAgent = new Agent();
	$agent_max_id=$clsAgent->getMaxId();
	$errMsg='';
	if(isset($_POST['ctv_register'])&&$_POST['ctv_register']=='ctv_register'){ 
		if($clsAgent->checkExitsEmail($_POST['email']) == '1') {
			$errMsg.= '<p>'.$core->get_Lang('Email address already exists').' </p>';
		}
		$name=$_FILES['identity_card_file']['name'];
		$tmp_name=$_FILES['identity_card_file']['tmp_name'];
		$type_file=$_FILES['identity_card_file']['type'];
		$size=$_FILES['identity_card_file']['size'];
		
		//print_r($name.'x'.$tmp_name.'xx'.$type_file.'xxxyyyy'.$size); die();
		#- Validate
		if($name==''){
			$errMsg.= '<p>'.$core->get_Lang('Your identity card file should not be empty').' </p>';
		}
		if($size >= 2097152){
			$errMsg.= '<p>'.$core->get_Lang('Your identity card file size too large').' </p>';
		}
		if($name!='' && !in_array($type_file,array('image/jpeg','image/png'))){
			$errMsg.= '<p>'.$core->get_Lang('Your identity card file not wrong format').' </p>';
		}
		
		$f = "agent_id,full_name,email,phone,userpass,type,ip_register,reg_date";
		$v = "'".$agent_max_id."'";
		$v .= ",'".addslashes($_POST['full_name'])."'";
		$v .= ",'".addslashes($_POST['email'])."'";
		$v .= ",'".addslashes($_POST['phone'])."'";
		$userpass = $clsAgent->encrypt($_POST['password']);
		$v .= ",'".addslashes($userpass)."'";
		$v .= ",'".$type."'";
		$v .= ",'".$_SERVER['REMOTE_ADDR']."'";
		$v .= ",'".time()."'";
		if($errMsg==''){
			if($clsAgent->insertOne($f,$v)){
				$upload_path = '/ctv_'.$agent_max_id;
				if(!class_exists('UploadFile')){ require_once(DIR_COMMON.'/class.upload.php'); }
				$up = '';
				if(is_uploaded_file($_FILES['identity_card_file']['tmp_name'])){
					$clsUploadFile = new UploadFile();
					$up = $clsUploadFile->uploadItem($_FILES["identity_card_file"],$upload_path,"jpg,gif,png");
				}
				$clsAgent->updateOne($agent_max_id,"identity_card_file='$up'");
				$clsAgent->sendEmailRegisterCTV($agent_max_id,$userpass);	
				header('location: '.PCMS_URL.'collaborators/signup-success.html');
				exit();
			}
		}else{
			foreach($_POST as $k=>$v){
				$assign_list[$k] = $v;
			}
		}
		$assign_list["errMsg"] = $errMsg;
	}
	
	
    /*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Travel Agent').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	unset($clsBlog);unset($clsBlogCategory);
}

function default_update_profile_agent(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$extLang;
	global $clsISO,$dbconn;
	#
	$type = isset($_POST['type']) ? $_POST['type'] : '';
	$agent_id = isset($_POST['agent_id']) ? $_POST['agent_id'] : '';
	
	//print_r($_POST); die();
	
	$clsAgent = new Agent();
	
	$name=$_FILES['avatar']['name'];
	$tmp_name=$_FILES['avatar']['tmp_name'];
	$type_file=$_FILES['avatar']['type'];
	$size=$_FILES['avatar']['size'];
	
	$msg_error='';
	
	//print_r($name.'x'.$tmp_name.'xx'.$type.'xxxyyyy'.$size); die();
	#- Validate
	
	$upload_path = '/avatar_'.$agent_id;
	if(!class_exists('UploadFile')){ require_once(DIR_COMMON.'/class.upload.php'); }
	$up = '';
	
	
	if($_POST['avatar_post']!=''){
		$up=$_POST['avatar_post'];
	}else{
		if(is_uploaded_file($_FILES['avatar']['tmp_name'])){
			$clsUploadFile = new UploadFile();
			$up = $clsUploadFile->uploadItem($_FILES["avatar"],$upload_path,"jpg,gif,png");
		}
	}	
	if($agent_id >0){
		if($type=='AGENT'){
			$value = "full_name='".$_POST['full_name']."'";
			$value .= ",phone='".$_POST['phone']."'";
			$value .= ",company_name='".$_POST['company_name']."'";
			$value .= ",position='".$_POST['position']."'";
			$value .= ",tax_code='".$_POST['tax_code']."'";
			$value .= ",upd_date='".time()."'";
			$value .= ",avatar='".$up."'";
			//print_r($agent_id.'xxxx'.$value); die();
			if($clsAgent->updateOne($agent_id,$value)){
				//$clsAgent->sendEmailUpdateProfileAgent($agent_id);	
				redirect(DOMAIN_NAME.$extLang.'/travel-agent/my-profile.html');
			}else{
				redirect(DOMAIN_NAME.$extLang.'/travel-agent/my-profile.html');
				$msg_error .= $core->get_Lang('Update failed!');
			}
		}else{
			$value = "full_name='".$_POST['full_name']."'";
			$value .= ",phone='".$_POST['phone']."'";
			$value .= ",upd_date='".time()."'";
			$value .= ",avatar='".$up."'";
			//print_r($agent_id.'xxxx'.$value); die();
			if($clsAgent->updateOne($agent_id,$value)){
				//$clsAgent->sendEmailUpdateProfileAgent($agent_id);	
				redirect(DOMAIN_NAME.$extLang.'/travel-agent/my-profile.html');
			}else{
				redirect(DOMAIN_NAME.$extLang.'/travel-agent/my-profile.html');
				$msg_error .= $core->get_Lang('Update failed!');
			}
		}
	}
	
	
	
    /*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Travel Agent').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	unset($clsBlog);unset($clsBlogCategory);
}

function default_login(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $clsISO,$title_page,$description_page,$keyword_page,$agent_id,$extLang;
	//print_r('xxxx'); die();
	$clsAgent = new Agent();

	$is_change_pass = !empty($_GET["is_change_pass"]) ? $_GET["is_change_pass"] : "";
	$is_token_expired = !empty($_GET["is_token_expired"]) ? $_GET["is_token_expired"] : "";
	if ($is_change_pass) {
		$assign_list["mess_change_pwd"] = $core->get_Lang("Password Updated!");
		$assign_list["icon_swal"] = "success";
	} else if ($is_token_expired) {
		$assign_list["mess_change_pwd"] = $core->get_Lang("Link expired. Click 'Forgot Password' to retry");
		$assign_list["icon_swal"] = "error";
	}
	$msgSubmitForm='';
	if(isset($_POST['LOGIN']) && $_POST['LOGIN']== 'LOGIN'){
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		if($clsAgent->agentLoggedIn($email,$password)){
			header('Location: ' . $clsISO->getLink("sale_tool"));
			exit();
		}else{
			$assign_list["msgSubmitForm"] .= $core->get_Lang('Login failed! Please try again!');
		}
	}
	/*=============Content Page==================*/
	$title_page = 'Sign in '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_logout(){
	global $assign_list, $_CONFIG, $core,$extLang, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;
	global $facebook;
	$clsAgent = new Agent();	
	#
	$clsAgent->userDoLogout();
	header('Location:'. $clsISO->getLink("agent_signin"));
	exit();
}
function default_forgot_pass(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	#
	$title_page = $core->get_Lang('Forgot Password').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_ajAjaxForgotPass(){
	global $core, $clsISO, $clsEvent, $_lang, $_LANG_ID;
	#
	$clsAgent = new Agent();
	#
	$email = isset($_POST['email'])?trim(strip_tags($_POST['email'])):'';

	#
	if($clsAgent->checkExitsEmail($email)== '0'){
		echo 'email_not_correct'; die();
	} else {
		$one = $clsAgent->getAll("email='$email' limit 0,1");
		$agent_id = $one[0]['agent_id'];
		$time=time();
		$confirm_code=md5(md5($email.'VIETISO'.$time));
		$set = "reset_code='".$confirm_code."',reset_time='".$time."'";
		#
		if($clsAgent->updateOne($agent_id,$set)) {
			$clsAgent->sendEmailForgetPassword($agent_id);
			echo 'reset_success'; die();
		}
	}
}
function default_change_pass(){
	global $assign_list, $_CONFIG, $core,$extLang, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agent_id;
	#
	$cssShow='member';
	$assign_list["cssShow"] = $cssShow;
	$clsCountry=new Country(); $assign_list["clsCountry"] = $clsCountry;
	#
    $clsAgent = new Agent();$assign_list["clsAgent"] = $clsAgent;
	$agent_id = $clsAgent->getUserID();
	if( empty( $agent_id ) && isset($_SESSION["agent_id_db"]) ){
		$agent_id = $_SESSION["agent_id_db"];
	}
	//$assign_list["agent_id"] = $agent_id;
	$assign_list["agent_id"] = $agent_id;
	
	$oneAgent=$clsAgent->getOne($agent_id);
	$assign_list["oneAgent"] = $oneAgent;
	
	$lstCountry=$clsCountry->getAll("is_trash=0 order by order_no asc");
	$assign_list["lstCountry"] = $lstCountry;

	$message=$_GET['message'];
	$assign_list["message"] = $message;
	
	if($agent_id==0){
		header('location:'.$extLang.'/travel-agent/signup.html');
	}
    $oneAgent=$clsAgent->getOne($agent_id);
	$assign_list["oneAgent"] = $oneAgent;
	#
    if($_POST['CHANGE_PASS']=='CHANGE_PASS') {
		$msg='';
		$old_pass=$_POST['current_password'];
		$pass2=$_POST['password'];
		$pass3=$_POST['re_password'];
		
		if(!$clsAgent->checkPass($old_pass,$oneAgent['userpass'])){
			$msg.='<p>'.$core->get_Lang('Current password not match').'</p>';
		}
		if(strlen($pass2)<6){
			$msg.='<p>'.$core->get_Lang('The passwords Minimum must have 6 characters').'</p>';
		}
		if($msg===''){
			$value = "userpass='".$clsAgent->encrypt(addslashes($_POST['pass2']))."'";
			if($clsAgent->updateOne($agent_id,$value)){
				header('location:'.DOMAIN_NAME.$extLang.'/travel-agent/signin.html');
			}else{
				header('location:'.DOMAIN_NAME.$extLang.'/travel-agent/change-password/error.html');
			}
		}
    }
	$assign_list["msg"] = $msg;
	#
	$title_page = $core->get_Lang('Change Password').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
}
function default_reset_pass(){
	global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$clsISO,$extLang, $_lang;
	#
	$restorekey = $_GET['restorekey']; //print_r($restorekey);die();
	$clsAgent = new Agent();
	$assign_list["clsAgent"] = $clsAgent;
	$lstAgent = $clsAgent->getAll("reset_code = '$restorekey'");
	$agent_id = $lstAgent[0]['agent_id'];

	$oneAgent = $clsAgent->getOne($agent_id);

	if($agent_id=='' || $oneAgent['reset_code']=='' || $oneAgent['reset_time']<time()-48*60*60){
		header('location:'.$clsISO->getLink("agent_signin")."?is_token_expired=1");
	}
	if($_POST['RESET_PASS']=='RESET_PASS'){
		$login_password = $_POST['password'];
		$c_login_password = $_POST['re_password'];
		#
		if($login_password==$c_login_password){
			#
			$set = "userpass='".$clsAgent->encrypt($login_password)."',reset_code='',reset_time='0',upd_date='".time()."'";
			#
			if($clsAgent->updateOne($agent_id,$set)) {
				$oneAgent = $clsAgent->getOne($agent_id);
				$_SESSION['FRONT_LOGGEDIN'] = 1;
				$_SESSION['FRONT_USEREMAIL'] = $oneAgent['email'];
				$_SESSION['FRONT_PASSWORD'] = $oneAgent['userpass'];
				$_frontIsLoggedin_user_id = $oneAgent;
				$clsAgent->updateOne($_frontIsLoggedin_user_id,"last_connect='".time()."',is_online='1'");
				$clsAgent->sendEmailChangePassword($agent_id,$login_password);
			}
			#
			header('location: '.$clsISO->getLink("agent_signin")."?is_change_pass=1");
		}
		else{
			$assign_list["invalid"] = 'invalid';
		}
	}
	
	$title_page =$core->get_Lang('Reset Password').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;

}
function default_agent_booking(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agent_id;
	#
	require_once(DIR_COMMON.'/class.upload.php');
	$cssShow='member';
	$assign_list["cssShow"] = $cssShow;
	#
	$clsCountry=new Country();
	$assign_list["clsCountry"] = $clsCountry;
	$clsHotel=new Hotel();
	$assign_list["clsHotel"] = $clsHotel;
	$clsCruise=new Cruise();
	$assign_list["clsCruise"] = $clsCruise;
	$clsCruiseCabin=new CruiseCabin();
	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	$clsTour=new Tour();
	$assign_list["clsTour"] = $clsTour;
	
	$clsReviews = new Reviews();
	
	$lstCountry=$clsCountry->getAll("is_trash=0 order by order_no asc");
	$assign_list["lstCountry"] = $lstCountry;
    #
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	
	$lstBooking = $clsBooking->getAll("agent_id='$agent_id' order by booking_id desc");
	$assign_list["lstBooking"] = $lstBooking;
	if($lstBooking>0){
		$totlalBooking=count($lstBooking);
	}else{
		$totlalBooking=0;
	}
	$assign_list["totlalBooking"] = $totlalBooking;

	$lstBookingHotel=$clsBooking->getAll("clsTable='Hotel' and agent_id='$agent_id' and target_id IN (SELECT hotel_id FROM ".DB_PREFIX."hotel WHERE is_trash=0 and is_online=1) order by booking_id desc");
	$assign_list["lstBookingHotel"] = $lstBookingHotel;
	
	$lstBookingTour=$clsBooking->getAll("clsTable='Tour' and agent_id='$agent_id' and target_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE is_trash=0 and is_online=1) order by booking_id desc");
	$assign_list["lstBookingTour"] = $lstBookingTour;

	$lstBookingCruise=$clsBooking->getAll("clsTable='Cruise' and agent_id='$agent_id' and target_id IN (SELECT cruise_id FROM ".DB_PREFIX."cruise WHERE is_trash=0 and is_online=1) order by booking_id desc");
	$assign_list["lstBookingCruise"] = $lstBookingCruise;
	
	$title_page =$core->get_Lang('My Booking').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	

}
function default_agent_review(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agent_id;
	#
	require_once(DIR_COMMON.'/class.upload.php');
	$cssShow='member';
	$assign_list["cssShow"] = $cssShow;
	#
	$clsCountry=new Country();
	$assign_list["clsCountry"] = $clsCountry;
	$clsHotel=new Hotel();
	$assign_list["clsHotel"] = $clsHotel;
	$clsCruise=new Cruise();
	$assign_list["clsCruise"] = $clsCruise;
	$clsCruiseCabin=new CruiseCabin();
	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	$clsTour=new Tour();
	$assign_list["clsTour"] = $clsTour;
	
	$clsReviews = new Reviews();
	
	$cond = "is_trash=0 and is_online=1 and agent_id ='$agent_id'";

	$lstReview = $clsReviews->getAll($cond." order by order_no asc");
	$assign_list["lstReview"] = $lstReview;
	//print_r($lstReview); die();

	$title_page =$core->get_Lang('My Reviews').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
}
function default_sale_tool()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang, $clsISO, $is_agent;
	#
	/*if (!$is_agent) {
		header('Location:' . $clsISO->getLink("agent_signin"));die;
	}*/
	$clsDownload = new Download();
	$assign_list["clsDownload"] = $clsDownload;
	$clsPagination = new Pagination();
	$clsProperty = new Property();
	$assign_list['clsProperty'] = $clsProperty;
	$clsSaleKits = new SaleKits();
	$assign_list['clsSaleKits'] = $clsSaleKits;

	$clsCountryEx = new Country();
	$assign_list["clsCountryEx"] = $clsCountryEx;
	$country_id = 0;
//	$cond = "is_online_agent=1 and is_for_agent=1";
	$cond = "is_trash=0 and is_online=1 ";
	$slug_country = !empty($_GET['slug_country']) ? $_GET['slug_country'] : '';
	$assign_list["slug_country"] = $slug_country;

	if (!empty($slug_country)) {
		$res = $clsCountryEx->getAll("$cond and slug='$slug_country' LIMIT 0,1");
		$country_id = $res[0][$clsCountryEx->pkey];
		if (intval($country_id) == 0) {
			header('Location:' . PCMS_URL . $extLang);
			exit();
		}
	}

	$assign_list['country_id'] = $country_id;

	$lstCountryEx = $clsCountryEx->getAll($cond, "country_id, title, slug");
	$assign_list["lstCountryEx"] = $lstCountryEx;

	$cond_market = '';
	if (!empty($country_id)) {
		$listAllDownload = $clsDownload->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and attachment_file<>''");
		$lstMarket = $clsProperty->getAll("is_trash=0 AND country_id = '$country_id' AND type ='Market' AND parent_id='0' ORDER BY order_no DESC", $clsProperty->pkey . ',title');
		$assign_list['lstMarket'] = $lstMarket;
		$listMarketTypeFirst = $clsProperty->getAll("is_trash=0 AND country_id = '$country_id' AND type ='Market' AND parent_id='" . $lstMarket[0]['property_id'] . "' ORDER BY order_no DESC", $clsProperty->pkey . ',title');
		$assign_list['listMarketTypeFirst'] = $listMarketTypeFirst;
		if ($lstMarket) {
			$cond_market = " AND market_id = '" . $lstMarket[0]['property_id'] . "' ";
			if ($listMarketTypeFirst) {
				$cond_market .= " AND market_type_id = '" . $listMarketTypeFirst[0]['property_id'] . "' ";
			}
		}
	} else {
		$listAllDownload = $clsDownload->getAll("$cond and attachment_file<>''");
	}
	# Sale Kits
	$listSaleKit = $clsSaleKits->getAll("$cond order by order_no limit 6", "title, image, attachment_file");

	$totalRecord = $listAllDownload ? count($listAllDownload) : 0;
	$recordPerPage = 10;
	$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_Seo = isset($_GET['page']) ? intval($_GET['page']) : '';
	$assign_list['page_Seo'] = $page_Seo;
	$link_page = $clsISO->getLink('sale_tool');
	if ($slug_country != '') {
		$link_page = $clsDownload->getLink($slug_country);
	}

	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html', '/', $link_page),
		'link_page_1'	=> $link_page
	);
	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);
	if (empty($country_id)) {
		$assign_list['page_view'] = $page_view;
	}
	unset($page_view);
	$assign_list['totalPage'] = $clsPagination->getTotalPage();

	if (!empty($country_id)) {
		$listDownload = $clsDownload->getAll($cond  . $cond_market . " and country_id='$country_id' and attachment_file<>'' order by order_no asc $limit");
	} else {
		$listDownload = $clsDownload->getAll("$cond and attachment_file<>'' order by order_no $limit");
	}
	$assign_list["listDownload"] = $listDownload;
	$assign_list["listSaleKit"] = $listSaleKit;
	//print_r($listDownload); die();
	unset($listDownload);
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Sales tools') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
}

function default_sale_kits(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$clsISO;

	$currentPage = $_GET["page"] ?? 1;
	$recordPerPage = 10;
	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";

	$keyword = !empty($_GET["keyword"]) ? $_GET["keyword"] : "";

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["hid"]) && $_POST['hid'] === "searchBook") {
		$link = $clsISO->getLink("sale_kits");
		$link .= "?keyword=".$_POST['keyword'];
		header('Location: ' . trim($link));
	}

	#
	$clsSaleKits=new SaleKits();
	$assign_list["clsSaleKit"] = $clsSaleKits;
	$cond = "is_trash=0 and is_online=1 ";

	if ($keyword) {
		$slug = $clsISO->replaceSpace2($keyword);
		$cond .= "and (title LIKE '%$keyword%' or slug LIKE '%$slug%')";
	}

	$listSaleKit=$clsSaleKits->getAll("$cond and attachment_file != '' order by order_no asc $limit",$clsSaleKits->pkey.",attachment_file,title,intro,image, upd_date");
	$assign_list["listSaleKit"] = $listSaleKit;

	# Paginate
	$clsPagination = new Pagination();
	$totalRecord = $clsSaleKits->getAll($cond, $clsSaleKits->pkey);

	if ($totalRecord) {
		$totalRecord = count($totalRecord);
	} else {
		$totalRecord = 0;
	}

	$lnk = $_SERVER['REQUEST_URI'];
	if (isset($_GET['page'])) {
		$tmp = explode('&', $lnk);
		$n = count($tmp) - 1;
		$la_it = '&' . $tmp[$n];
		$str_len = -strlen($la_it);
		$link_page = substr($lnk, 0, $str_len);
	} else {
		$link_page = $lnk;
	}

	$config = array(
		'total' => $totalRecord,
		'number_per_page' => $recordPerPage,
		'current_page' => $currentPage,
		'link' => str_replace('.html', '/', $link_page),
		'link_page_1' => $link_page
	);

	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links();

	$assign_list["page_view"] = $page_view;
	$assign_list["totalSaleKits"] = $totalRecord;
	$assign_list["totalPages"] = $clsPagination->getTotalPage();
	#
	$assign_list["keyword"] = $keyword;
	/*=============Title & Description Page==================*/
	$title_page =$core->get_Lang('Sale Kits').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
}

function default_loadProduct()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $_lang, $clsISO;
	$clsProperty = new Property();
	$clsDownload = new Download();
	$market_id = !empty($_POST['market_id']) ? $_POST['market_id'] : 0;
	$country_id = !empty($_POST['country_id']) ? $_POST['country_id'] : 0;
	$market_type_id = !empty($_POST['market_type_id']) ? $_POST['market_type_id'] : 0;
	$htmlMarketType = $htmlDownload = '';
	if ($market_id > 0 && $country_id > 0) {
		if ($market_type_id == 0) {
			$listMarketType = $clsProperty->getAll("is_trash=0 AND country_id = '$country_id' AND type ='Market' AND parent_id='" . $market_id . "' ORDER BY order_no DESC", $clsProperty->pkey . ',title');
			if ($listMarketType) {
				$market_type_id = $listMarketType[0]['property_id'];
			}
			foreach ($listMarketType as $key => $value) {
				$check = ($key == 0) ? "checked" : "";
				$htmlMarketType .= '<label class="item_market_type" data-market_id="' . $market_id . '" data-market_type_id="' . $value['property_id'] . '" data-country_id="' . $country_id . '">
								' . $value['title'] . '
								<input type="radio" name="market_type_id" value="' . $value['property_id'] . '" ' . $check . '>
								<span class="checkmark"></span>
							</label>';
			}
		}

		$cond_market = " AND market_id = '" . $market_id . "' ";
		if ($market_type_id > 0) {
			$cond_market .= " AND market_type_id = '" . $market_type_id . "' ";
		}
		$listDownload = $clsDownload->getAll("is_trash=0 and is_online=1 " . $cond_market . " and country_id='$country_id' and attachment_file<>'' order by order_no asc");
		if ($listDownload) {
			foreach ($listDownload as $key => $value) {
				$htmlDownload .= $clsISO->getBlock("box_tour_agent", ["value" => $value]);
			}
		}

		$data = [
			"result"	=>	true,
			"htmlMarketType"	=>	$htmlMarketType,
			"htmlDownload"		=>	$htmlDownload
		];
		echo json_encode($data, CURLE_BAD_CONTENT_ENCODING);
		die;
	}
	$data = [
		"result"	=>	false,
		"htmlMarketType"	=>	$htmlMarketType,
		"htmlDownload"		=>	$htmlDownload
	];
	echo json_encode($data, CURLE_BAD_CONTENT_ENCODING);
	die;
}
function default_addRequireSalesTools()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang, $clsISO;
	//	var_dump($_POST);die;
	$clsAgent = new Agent();
	$clsFeedback = new Feedback();
	$user_login_id = $clsAgent->getUserID();
	if ($user_login_id == 0) {
		$data = [
			'result'	=>	false,
			'data'		=> [
				'type'	=>	"login",
				'message'	=>	$core->get_Lang('You need to log in to your account'),
				'url'	=>	DOMAIN_NAME . $clsISO->getLink('signin'),
				'sitekey'	=>	$sitekey
			]
		];
		echo json_encode($data);
		die;
	}

	$time_check = time() - 24 * 60 * 60; //1660086885
	$user_ip_check = $_SERVER['REMOTE_ADDR'];
	$target_id = isset($_POST['target_id']) ? $_POST['target_id'] : 0;
	/*$checkSpam=$clsFeedback->getAll("is_trash=0 and user_ip='{$user_ip_check}' and target_id='".$target_id."'",$clsFeedback->pkey);
	if($checkSpam){
		$data = [
			'result'	=>	false,
			'data'		=> [
				'type'	=>	"spam",
				'message'	=>	$core->get_Lang('You must not send spam'),
				'sitekey'	=>	$sitekey,
			]
		];
		echo json_encode($data);die;
	}*/
	if (_ISOCMS_CAPTCHA == 'IMG') {
		$security_code = isset($_POST["security_code"]) ? trim($_POST["security_code"]) : '';
		$security_code = strtoupper($security_code);
		if ($security_code == '') {
			$data = [
				'result'	=>	false,
				'data'		=> [
					'type'	=>	"captcha",
					'message'	=>	$core->get_Lang('Please enter security code'),
					'sitekey'	=>	$sitekey,
				]
			];
			echo json_encode($data);
			die;
		}
		if (!empty($security_code) && $security_code != $_SESSION['skey']) {
			$data = [
				'result'	=>	false,
				'data'		=> [
					'type'	=>	"captcha",
					'message'	=>	$core->get_Lang('Secure code not match'),
					'sitekey'	=>	$sitekey,
				]
			];
			echo json_encode($data);
			die;
		}
	} else if (_ISOCMS_CAPTCHA == 'reCAPTCHA') {
		/*$security_code = isset($_POST["g-recaptcha-response"]) ? trim($_POST["g-recaptcha-response"]) : '';
		if ($security_code == '') {
			$data = [
				'result'	=>	false,
				'data'		=> [
					'type'	=>	"captcha",
					'message'	=>	$core->get_Lang('Please enter security code'),
					'sitekey'	=>	$sitekey,
				]
			];
			echo json_encode($data);
			die;
		}
		if (!$clsISO->checkGoogleReCAPTCHA()) {
			$data = [
				'result'	=>	false,
				'data'		=> [
					'type'	=>	"captcha",
					'message'	=>	$core->get_Lang('Secure code not match'),
					'sitekey'	=>	$sitekey,
				]
			];
			echo json_encode($data);
			die;
		}*/
	}
	$number_adult = $_POST['number_adult'];
	$number_children = $_POST['number_children'];
	$number_infant = $_POST['number_infant'];
	$travelduration = $_POST['travelduration'];
	$departure = $_POST['departure'];
	$country_id = $_POST['country_id'];
	$cat_id = $_POST['cat_id'];
	$Comments = $_POST['Comments'];

	$oneAgent = $clsAgent->getOne($user_login_id, $clsAgent->pkey . ',full_name,email,phone,address,country_id');

	$feedback_id = $clsFeedback->getMaxId();
	$feedback_code = $clsFeedback->generateFeedBack($feedback_id);
	#
	$fx = "feedback_id,target_id,feedback_code,fullname,email,phone,address,country_id,feedback_store,user_ip,reg_date,type";
	$vx = "'$feedback_id'
	,'" . $target_id . "'
	,'$feedback_code'
	,'" . $oneAgent['full_name'] . "'
	,'" . $oneAgent['email'] . "'
	,'" . $oneAgent['phone'] . "'
	,'" . $oneAgent['address'] . "'
	,'" . $oneAgent['country_id'] . "'
	,'" . serialize($_POST) . "'
	,'" . $_SERVER['REMOTE_ADDR'] . "'
	,'" . time() . "'
	,'TourAgent'";
	#
	if ($clsFeedback->insertOne($fx, $vx)) {
		$clsFeedback->newBookingAgent($feedback_id);
		$data = [
			'result'	=>	true,
			'data'		=> [
				'type'	=>	"message",
				'message'	=>	$core->get_Lang('Success'),
				'url'	=>	DOMAIN_NAME . $extLang . '/contact-us/success.html'
			]
		];
		echo json_encode($data);
		die;
	}
}
function default_ajLoadRequest()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $country_id, $city_id, $cat_id, $extLang, $clsISO;
	$clsAgent = new Agent();
	$clsFeedback = new Feedback();
	$clsDownload = new Download();
	$assign_list["clsAgent"] = $clsAgent;
	$assign_list["clsFeedback"] = $clsFeedback;
	$assign_list["clsDownload"] = $clsDownload;
	if (!$clsAgent->isLoggedIn()) {
		redirect($clsAgent->getLinkAgent('signin'));
	}

	$agent_id = $_SESSION['agent_id'];
	$oneAgent = $clsAgent->getOne($agent_id, 'email');
	if (isset($_POST['process']) && $_POST['process'] != '') {
		$where = ' and is_process="' . $_POST['process'] . '"';
	}
	$process = isset($_POST['process']) ? $_POST['process'] : 0;
	$lstRequest = $clsFeedback->getAll('is_trash=0 and email="' . $oneAgent['email'] . '" ' . $where . ' and type="request" order by order_no desc', $clsFeedback->pkey . ',feedback_code,target_id,is_process,feedback_html');
	$assign_list["lstRequest"] = $lstRequest;
	$html = $clsISO->build('loadListRequest.tpl');
	echo $html;
	die;
}
function default_ajRequestTourAgent() {
	global $clsISO, $assign_list;

	$assign_list["URL_CSS"] = URL_CSS;
	$assign_list["title_item"] = "test";
	echo $clsISO->build("modal_request.tpl");die;
}
?>
