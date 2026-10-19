<?php 
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act,$title_page,$description_page,$keyword_page,$oneCommon;
	global $clsConfiguration, $extLang, $_LANG_ID, $clsISO;
	#
	$clsFeedback=new Feedback(); $assign_list['clsFeedback'] = $clsFeedback;

	$clsCountry = new _Country() ;$assign_list['lstCountry']=$clsCountry->getAll("1=1 order by order_no asc");
	$assign_list['clsCountry']=$clsCountry;
	#
	$msg = isset($_GET['msg'])? $_GET['msg']:'';
	$assign_list['msg']=$msg;
	
	$errMsg = '';
	if(isset($_POST['Hid_HomeContact']) && $_POST['Hid_HomeContact']=='Hid_HomeContact'){
		$full_name = $_POST['full_name'];
		if($full_name==''){
			$errMsg.= '&nbsp; '.$core->get_Lang('Full name is required').' <br />';
		}
		#
		$email = addslashes($_POST['email']);
		if($email==''){
			$errMsg .= $core->get_Lang('Please enter your email').' <br />';
		}
		$message = addslashes($_POST['message']);
		if($message==''){
			$errMsg .= $core->get_Lang('Please enter message').' <br />';
		}
		//$security_code = isset($_POST["security_code"])? $_POST["security_code"] : '';
//		$security_code = strtoupper($security_code);
//		if($security_code==''){
//			$errMsg .= $core->get_Lang('Please enter correct security code').' <br />';
//		}
//		if($security_code != '' && $security_code != $_SESSION['skey']){
//			$errMsg .= $core->get_Lang('Secure code not match').' <br />';
//		}
		#
		if($errMsg==''){
			$feedback_id = $clsFeedback->getMaxId();
			$feedback_code=$clsFeedback->generateFeedBack($feedback_id);
			#
			$fx = "feedback_id,feedback_code,fullname,email,type,feedback_store,user_ip,reg_date";
			$vx = "'$feedback_id'
			,'$feedback_code'
			,'$full_name'
			,'$email'
			,'HOME'
			,'".serialize($_POST)."'
			,'".$_SERVER['REMOTE_ADDR']."'
			,'".time()."'";
			#
			if($clsFeedback->insertOne($fx,$vx)){
				$clsFeedback->newBooking($feedback_id);
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
	$title_page = $core->get_Lang('contactus').' - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('contactus').' - '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('contactus').' - '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
	/*========================================================*/
	unset($clsFeedback); unset($clsISO);
?>