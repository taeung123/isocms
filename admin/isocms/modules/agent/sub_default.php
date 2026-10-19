<?php
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;
	if($type==''){
	header('location: ' . PCMS_URL . '/?mod=' . $mod .'&type=AGENT');	
	}
	#
	$is_active = isset($_GET['is_active']) ? $_GET['is_active'] : '';
	$assign_list["is_active"] = $is_active;
	#
	
	/**/
	$classTable = "Agent";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
    $clsCountry = new _Country(); $assign_list["clsCountry"] = $clsCountry;
    $clsCountryEx = new Country(); $assign_list["clsCountryEx"] = $clsCountryEx;
	/*List all item*/
	 if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        if($_POST['domain_id']!=''&&$_POST['domain_id']!='0'){
			$link .= '&domain_id='.$_POST['domain_id'];
		}
        if (isset($_POST['name']) && $_POST['name'] != '') {
            $link .= '&name=' . $_POST['name'];
        }
		if (isset($_POST['email']) && $_POST['email'] != '') {
            $link .= '&email=' . $_POST['email'];
        }
		if (isset($_POST['phoneNumber']) && $_POST['phoneNumber'] != '') {
            $link .= '&phone=' . $_POST['phoneNumber'];
        }
		 header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
	$pUrl = '';
	#
	$cond ='1=1';
	if($is_active != '') {$cond.= " and is_active = '$is_active'";}
	#
	if($type_list=='Pending'){
		$cond.=" and is_active=0";
	}elseif($type_list=='Approved'){
		$cond.=" and is_active=1";
	}
	
	if($type!=''){
		$cond.=" and type='$type'";
	}
	
	if (isset($_GET['name']) && $_GET['name'] != '') {
        $cond .= " and (first_name like '%".$_GET['name']."%' or last_name like '%".$_GET['name']."%' or full_name like '%".$_GET['name']."%')";
        $assign_list["name"] = $_GET['name'];
    }
	if (isset($_GET['email']) && $_GET['email'] != '') {
        $cond .= " and (email like '%".$_GET['email']."%')";
        $assign_list["email"] = $_GET['email'];
    }
	if (isset($_GET['address']) && $_GET['address'] != '') {
        $cond .= " and (address like '%".$_GET['address']."%')";
        $assign_list["address"] = $_GET['address'];
    }
	 if (isset($_GET['country_id']) && $_GET['country_id'] != '') {
        $cond .= " and country_id ='".$_GET['country_id']."'";
        $assign_list["country_id"] = $_GET['country_id'];
    }
	if (isset($_GET['phone']) && $_GET['phone'] != '') {
        $cond .= " and (phone like '%".$_GET['phone']."%')";
        $assign_list["phone"] = $_GET['phone'];
    }
	$orderBy = " $clsClassTable->pkey asc";
	
	$recordPerPage = 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";

    $totalRecord = $clsClassTable->getAll($cond)?count($clsClassTable->getAll($cond)):0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
    $listPageNumber = array();
    for ($i = 1; $i <= $totalPage; $i++) {
        $listPageNumber[] = $i;
    }
    $assign_list['listPageNumber'] = $listPageNumber;
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $link_page_current = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page')
            $link_page_current .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current'] = $link_page_current;
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
	
	//print_r($cond . " order by " . $orderBy . $limit); die();
    $listItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
	$assign_list["listItem"] = $listItem;
	$assign_list["totalItem"] = (is_array($listItem) && count($listItem)>0) ? count($listItem) : 0;
	$assign_list["last_item"] = count($listItem)-1;	
	#
	$allProcess =  $clsClassTable->getAll("is_active=1");
	$assign_list["number_active"] = $allProcess[0][$pkeyTable]!=''?count($allProcess):0;
	$allUnProcess =  $clsClassTable->getAll("is_active=0");
	$assign_list["number_unactive"] = $allUnProcess[0][$pkeyTable]!=''?count($allUnProcess):0;
	$assign_list["number_reviewed"] = $clsClassTable->countItem("is_active=2");
	#----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateSiteAgent') {
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    $clsConfiguration->updateValue($tmp[1], $val);
                }
            }
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess');
        }
    }
}
function default_edit(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$dbconn;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsCountry = new _Country(); $assign_list["clsCountry"] = $clsCountry;
	$clsCountryEx = new Country(); $assign_list["clsCountryEx"] = $clsCountryEx;
	$classTable = "Agent";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$assign_list["clsClassTable"] = $clsClassTable;
	#
	
	$string = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]:"";
	
	$pvalTable =intval($core->decryptID($string));
		
	$assign_list['pvalTable'] = $pvalTable;
	$oneTable = $clsClassTable->getOne($pvalTable);
	$assign_list["oneTable"] = $oneTable;
	#

	$is_active = $oneTable['is_active'];
	if($is_active == 0 && intval($pvalTable) > 0) {
		$clsClassTable->updateOne($pvalTable,"is_active = 2");
	}
	
	$clsCountry=new _Country();
	$assign_list["clsCountry"] = $clsCountry;
	$clsHotel=new Hotel();
	$assign_list["clsHotel"] = $clsHotel;
	$clsCruise=new Cruise();
	$assign_list["clsCruise"] = $clsCruise;
	$clsTour=new Tour();
	$assign_list["clsTour"] = $clsTour;
	
	$clsReviews = new Reviews(); 
	$assign_list["clsReviews"] = $clsReviews;
	
	$lstCountry=$clsCountry->getAll("is_trash=0 order by order_no asc");
	$assign_list["lstCountry"] = $lstCountry;
    #
	$clsWishlist = new Wishlist();
	$assign_list["clsWishlist"] = $clsWishlist;
	
	$clsBooking = new Booking(); 
	$assign_list["clsBooking"] = $clsBooking;
	
	$clsCruiseCabin = new CruiseCabin(); 
	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	
	
	/*//////WishList/////////*/
	
	$lstWishlist = $clsWishlist->getAll("agent_id='$pvalTable' order by wishlist_id desc");
	$assign_list["lstWishlist"] = $lstWishlist;
	if($lstWishlist>0){
		$totlalWishlist=count($lstWishlist);
	}else{
		$totlalWishlist=0;
	}
	$assign_list["totlalWishlist"] = $totlalWishlist;

	$lstWishlistHotel=$clsWishlist->getAll("clsTable='Hotel' and agent_id='$pvalTable' order by wishlist_id desc");
	$assign_list["lstWishlistHotel"] = $lstWishlistHotel;
	
	$lstWishlistTour=$clsWishlist->getAll("clsTable='Tour' and agent_id='$pvalTable' order by wishlist_id desc");
	$assign_list["lstWishlistTour"] = $lstWishlistTour;
	
	$lstWishlistCruise=$clsWishlist->getAll("clsTable='Cruise' and agent_id='$pvalTable' order by wishlist_id desc");
	$assign_list["lstWishlistCruise"] = $lstWishlistCruise;
	
	
	/*//////Booking////////*/

	$lstBooking = $clsBooking->getAll("1=1 and booking_type='Tour' order by reg_date DESC LIMIT 0,10");
	$assign_list["lstBooking"] = $lstBooking;
	if($lstBooking>0){
		$totalBooking=count($lstBooking);
	}else{
		$totalBooking=0;
	}

    $clsFeedback = new Feedback(); $assign_list['clsFeedback'] = $clsFeedback;

    $lstRequest = $clsFeedback->getAll("type='TourAgent' and email = '".$oneTable['email']."' ");
    $assign_list['lstRequest'] = $lstRequest;
    if($lstRequest){
        $totalBooking += count($lstRequest);
    }

	$assign_list["totalBooking"] = $totalBooking;
	$lstBookingHotel=$clsBooking->getAll("clsTable='Hotel' and agent_id='$pvalTable' order by booking_id desc");
	$assign_list["lstBookingHotel"] = $lstBookingHotel;
	
	$lstBookingTour=$clsBooking->getAll("clsTable='Tour' and agent_id='$pvalTable' order by booking_id desc");
	$assign_list["lstBookingTour"] = $lstBookingTour;

	$lstBookingCruise=$clsBooking->getAll("clsTable='Cruise' and agent_id='$pvalTable' order by booking_id desc");
	$assign_list["lstBookingCruise"] = $lstBookingCruise;
	
	/*///////Reviews////////////*/
	$lstReviews = $clsReviews->getAll("agent_id='$pvalTable' order by reviews_id desc");
	$assign_list["lstReviews"] = $lstReviews;
	if($lstReviews>0){
		$totalReviews=count($lstReviews);
	}else{
		$totalReviews=0;
	}
	
	$assign_list["totalReviews"] = $totalReviews;
	$lstReviewsHotel=$clsReviews->getAll("type='hotel' and agent_id='$pvalTable' order by is_online desc",$clsReviews->pkey .', reg_date,agent_id, table_id');
	$assign_list["lstReviewsHotel"] = $lstReviewsHotel;
	$lstReviewsTour=$clsReviews->getAll("type='tour' and agent_id='$pvalTable' order by is_online desc",$clsReviews->pkey .', reg_date,agent_id, table_id');
	$assign_list["lstReviewsTour"] = $lstReviewsTour;
	$lstReviewsCruise=$clsReviews->getAll("type='cruise' and agent_id='$pvalTable' order by is_online desc",$clsReviews->pkey .', reg_date,agent_id, table_id');
	$assign_list["lstReviewsCruise"] = $lstReviewsCruise;

	#
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm; 
	#-------------Update Config Meta 
	$clsForm->addInputTextArea("full","note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");
	#
	if(isset($_POST['submit']) && $_POST['submit']=='Update'){
		$value .= "is_active='".$_POST['is_active']."'";
		$value .= ",note='".$_POST['iso-note']."'";
		if($clsClassTable->updateOne($pvalTable,$value)){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&message=UpdateSuccess');	
		}
	}
}

function default_ajUpdateAgent() {
    global $core,$mod,$act, $clsConfiguration;
	$clsAgent =new Agent();
	#
	
	$agent_id = isset($_POST['agent_id'])?intval($_POST['agent_id']):'';
	$val = isset($_POST['val'])?intval($_POST['val']):'0';
	$status = isset($_POST['status'])?$_POST['status']:'';

		if($status=='Active'){
			if($clsAgent->updateOne($agent_id,"is_active='$val'")){
				if ($val > 0) {
                    $one = $clsAgent->getOne($agent_id);
                    $time=time();
                    $confirm_code=md5(md5($one['email'].'VIETISO'.$time));
                    $set = "reset_code='".$confirm_code."',reset_time='".$time."'";
                    if($clsAgent->updateOne($agent_id,$set)) {
                        $clsAgent->sendEmailActiveAgent($agent_id);
                    }
                }
				exit();
			}else{
				echo 0; die();	
			}
		}elseif($status=='Block'){
			if($clsAgent->updateOne($agent_id,"is_lock='$val'")){
                if ($val > 0) $clsAgent->sendEmailBlockAgent($agent_id);
				exit();
			}else{
				echo 0; die();	
			}
		}

}
function default_viewbooking(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$dbconn;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsAgent= new Agent();
	$assign_list["clsAgent"] = $clsAgent;
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	#
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$string = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]:"";
	$pvalTable =intval($core->decryptID($string));
	if($string != '' && $pvalTable==0){
		 header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
		 exit();
	}
	$assign_list["pvalTable"] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	#
	$clsBilling = new Billing();
	$assign_list["clsBilling"] = $clsBilling;
	$lstBilling = $clsBilling->getAll("booking_id='$pvalTable' and billing_type='".$oneItem['clsTable']."' order by reg_date DESC");
	$assign_list["lstBilling"] = $lstBilling; unset($lstBilling);
	#
/*	$status = $oneItem['status'];
	if($status == 0 && intval($pvalTable) > 0) {
		$clsClassTable->updateOne($pvalTable,"status = 2");
	}*/
	#
	$clsTable = $oneItem['clsTable'];
	$clsTable = new $clsTable;
	$assign_list["clsTable"] = $clsTable;
	
	$target_id = $oneItem['target_id'];
	$assign_list["target_id"] = $target_id;
	
	$agent_id = $oneItem['agent_id'];
	
	$assign_list["agent_id"] = $agent_id;
	$clsCruiseCabin = new CruiseCabin();
	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	#
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#-------------Update Config Meta 
	$clsForm->addInputTextArea("static","note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");
	
	$reg_date = $oneItem['reg_date'];
	$clsBooking=new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$listBookingPrev = $clsBooking->getAll("1=1 and clsTable = 'Tour' and reg_date < '$reg_date' order by reg_date desc"); 
	//print_r($cond); die();
	
	$bookingPrevItem=$listBookingPrev[0]['booking_id'];
	$assign_list["bookingPrevItem"] = $bookingPrevItem; 
	//print_r($listItem); die();
	
	$listBookingNext = $clsBooking->getAll("1=1 and clsTable = 'Tour' and reg_date > '$reg_date' order by reg_date ASC"); 
	//print_r($cond); die();
	
	$bookingNextItem=$listBookingNext[0]['booking_id'];
	$assign_list["bookingNextItem"] = $bookingNextItem; 
	//print_r($listItem); die();
	
	if(isset($_POST['submit']) && $_POST['submit'] =='Update'){
		if($oneItem['status']==1){
			$value = "is_send_email='".$_POST['sendmail']."'";
		}else{
			$value = "status='".$_POST['status']."'";
		}
		$value .= ",note='".addslashes($_POST['iso-note'])."'";
		#
		$pUrl = '';
		$pUrl.= "&act=edit";
		$pUrl.= "&agent_id=".$core->encryptID($agent_id)."";
		//print_r($pvalTable.'xxx'.$value); die();
		if($clsClassTable->updateOne($pvalTable,$value)){
			if($_POST['sendmail']==1){
				$clsClassTable->sendEmailSupportBooking($pvalTable);
			}
			header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=UpdateSuccess#isotab2');			
		}
	}
	if(isset($_POST['updateBooking']) && $_POST['updateBooking'] =='Update'){

		$value .= "customer_note='".addslashes($_POST['customer_note'])."'";
		$value .= ",staff_note='".addslashes($_POST['staff_note'])."'";
		
		if($clsClassTable->updateOne($pvalTable,$value)){
			if($_POST['notify_user']=='Y'){
			
			}
			if($_POST['notify_department']=='Y'){
				
			}
			$pUrl = '';
			$pUrl.= "&act=viewbooking";
			$pUrl.= "&booking_id=".$core->encryptID($pvalTable)."";
			
			header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=UpdateSuccess#isotab0');			
		}
	}
	
	
	if(1==2){
		$clsCountry = new _Country(); $assign_list["clsCountry"] = $clsCountry;

		$classTable = "Agent";
		$clsClassTable = new $classTable;
		$tableName = $clsClassTable->tbl;
		$pkeyTable = $clsClassTable->pkey ;
	
		$assign_list["clsClassTable"] = $clsClassTable;
		#
		$string = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]:"";
		
		$pvalTable =intval($core->decryptID($string));
			
		$assign_list['pvalTable'] = $pvalTable;
		$oneTable = $clsClassTable->getOne($pvalTable);
		$assign_list["oneTable"] = $oneTable;
		#
		$is_active = $oneTable['is_active'];
		if($is_active == 0 && intval($pvalTable) > 0) {
			$clsClassTable->updateOne($pvalTable,"is_active = 2");
		}
		$clsCountry=new _Country();
		$assign_list["clsCountry"] = $clsCountry;
		$clsHotel=new Hotel();
		$assign_list["clsHotel"] = $clsHotel;
		$clsCruise=new Cruise();
		$assign_list["clsCruise"] = $clsCruise;
		$clsTour=new Tour();
		$assign_list["clsTour"] = $clsTour;
		
		$clsReviews = new Reviews(); 
		$assign_list["clsReviews"] = $clsReviews;
		$lstCountry=$clsCountry->getAll("is_trash=0 order by order_no asc");
		$assign_list["lstCountry"] = $lstCountry;
		#
		$clsWishlist = new Wishlist();
		$assign_list["clsWishlist"] = $clsWishlist;
		
		$clsBooking = new Booking(); 
		$assign_list["clsBooking"] = $clsBooking;
		
		$clsCruiseCabin = new CruiseCabin(); 
		$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
		
		
		/*//////WishList/////////*/
		
		$lstWishlist = $clsWishlist->getAll("agent_id='$pvalTable' order by wishlist_id desc");
		$assign_list["lstWishlist"] = $lstWishlist;
		if($lstWishlist>0){
			$totlalWishlist=count($lstWishlist);
		}else{
			$totlalWishlist=0;
		}
		$assign_list["totlalWishlist"] = $totlalWishlist;
	
		$lstWishlistHotel=$clsWishlist->getAll("clsTable='Hotel' and agent_id='$pvalTable' order by wishlist_id desc");
		$assign_list["lstWishlistHotel"] = $lstWishlistHotel;
		
		$lstWishlistTour=$clsWishlist->getAll("clsTable='Tour' and agent_id='$pvalTable' order by wishlist_id desc");
		$assign_list["lstWishlistTour"] = $lstWishlistTour;
		
		$lstWishlistCruise=$clsWishlist->getAll("clsTable='Cruise' and agent_id='$pvalTable' order by wishlist_id desc");
		$assign_list["lstWishlistCruise"] = $lstWishlistCruise;
		
		/*//////Booking////////*/
		
		$lstBooking = $clsBooking->getAll("agent_id='$pvalTable' order by booking_id desc");
		$assign_list["lstBooking"] = $lstBooking;
		if($lstBooking>0){
			$totalBooking=count($lstBooking);
		}else{
			$totalBooking=0;
		}
		
		$assign_list["totalBooking"] = $totalBooking;
		$lstBookingHotel=$clsBooking->getAll("clsTable='Hotel' and agent_id='$pvalTable' order by booking_id desc");
		$assign_list["lstBookingHotel"] = $lstBookingHotel;
		
		$lstBookingTour=$clsBooking->getAll("clsTable='Tour' and agent_id='$pvalTable' order by booking_id desc");
		$assign_list["lstBookingTour"] = $lstBookingTour;
	
		$lstBookingCruise=$clsBooking->getAll("clsTable='Cruise' and agent_id='$pvalTable' order by booking_id desc");
		$assign_list["lstBookingCruise"] = $lstBookingCruise;
		
		
		/*///////Reviews////////////*/
		$lstReviews = $clsReviews->getAll("agent_id='$pvalTable' order by reviews_id desc");
		$assign_list["lstReviews"] = $lstReviews;
		if($lstReviews>0){
			$totalReviews=count($lstReviews);
		}else{
			$totalReviews=0;
		}
		
		$assign_list["totalReviews"] = $totalReviews;
	
		$lstReviewsHotel=$clsReviews->getAll("type='hotel' and agent_id='$pvalTable' order by is_online desc",$clsReviews->pkey .', reg_date,agent_id, table_id');
		$assign_list["lstReviewsHotel"] = $lstReviewsHotel;
		
		$lstReviewsTour=$clsReviews->getAll("type='tour' and agent_id='$pvalTable' order by is_online desc",$clsReviews->pkey .', reg_date,agent_id, table_id');
		$assign_list["lstReviewsTour"] = $lstReviewsTour;
		$lstReviewsCruise=$clsReviews->getAll("type='cruise' and agent_id='$pvalTable' order by is_online desc",$clsReviews->pkey .', reg_date,agent_id, table_id');
		$assign_list["lstReviewsCruise"] = $lstReviewsCruise;
	
		
		
		#
		require_once DIR_COMMON."/clsForm.php";
		$clsForm = new Form();
		$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
		$assign_list["clsForm"] = $clsForm; 
		#-------------Update Config Meta 
		$clsForm->addInputTextArea("full","note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");
		#
		if(isset($_POST['submit']) && $_POST['submit']=='Update'){
			$value .= "is_active='".$_POST['is_active']."'";
			$value .= ",note='".$_POST['iso-note']."'";
			if($clsClassTable->updateOne($pvalTable,$value)){
				header('location: '.PCMS_URL.'/?mod='.$mod.'&message=UpdateSuccess');	
			}
		}
	}
	
}
function default_viewrequest(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
    global $core, $clsModule, $clsButtonNav,$dbconn,$clsISO;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #


    $clsCountry = new _Country(); $assign_list["clsCountry"] = $clsCountry;


    $classTable = "Feedback";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey ;

    $assign_list["clsClassTable"] = $clsClassTable;

    $clsDownload = new Download();$assign_list["clsDownload"] = $clsDownload;
    $clsCountryEx = new Country();$assign_list["clsCountryEx"] = $clsCountryEx;
    $clsTourCategory = new TourCategory();$assign_list["clsTourCategory"] = $clsTourCategory;
    $clsCruiseCat = new CruiseCat();$assign_list["clsCruiseCat"] = $clsCruiseCat;
    #
    $string = isset($_GET['request_id'])?$_GET['request_id']:"";

    $pvalTable =intval($core->decryptID($string));

    $assign_list['pvalTable'] = $pvalTable;
    $oneTable = $clsClassTable->getOne($pvalTable);
    $assign_list["oneTable"] = $oneTable;
    #
    
    $oneDownload = $clsDownload->getOne($oneTable['target_id']); $assign_list["oneDownload"] = $oneDownload;

    $is_process = $oneTable['is_process'];
    $clsClassTable->updateOne($pvalTable,"is_process = '".$is_process."'");
    $feedback_store = $clsISO->getArrayFromString($oneTable['feedback_store']);
    $country_tmp = $feedback_store['country_id'];
    $lst_country = '';
    if(!empty($country_tmp)) {
        for($i=0;$i<count($country_tmp);$i++){
            $lst_country .= ($i==0 ? '' : ' , ').$clsCountryEx->getTitle($country_tmp[$i]);
        }
    }
    $assign_list['lst_country'] = $lst_country;

    #
    require_once DIR_COMMON."/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;
    #-------------Update Config Meta
    $clsForm->addInputTextArea("full","note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");
    #
    $a = $_SERVER['HTTP_REFERER'];
//    var_dump($_SERVER['HTTP_REFERER'].'&message=UpdateSuccess');die();

    $clsAgent = new Agent();
    $oneAgent = $clsAgent->getAll("email = '".$oneTable['email']."' limit 0,1");
    $agent_id = ($oneAgent)?$oneAgent[0]['agent_id']:0;
    $assign_list['agent_id'] = $agent_id;
    if(isset($_POST['submit']) && $_POST['submit']=='Update'){
        $value .= "is_process='".$_POST['is_process']."'";
        $value .= ",note='".$_POST['iso-note']."'";
        if($clsClassTable->updateOne($pvalTable,$value)){
            $page_access = isset($_GET["page"]) ? $_GET["page"] : 1;
            header('location: '.PCMS_URL.'/?mod='.$mod . '&act='.$act.'&request_id='.$core->encryptID($oneTable['feedback_id']) .'&message=UpdateSuccess');
        }
    }

}
function default_editbooking(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$dbconn,$clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	
	#
	$clsAgent= new Agent();
	$assign_list["clsAgent"] = $clsAgent;
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#

	#
	$string = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]:"";
	$pvalTable =intval($core->decryptID($string));
	if($string != '' && $pvalTable==0){
		 header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
		 exit();
	}
	$assign_list["pvalTable"] = $pvalTable;

	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	
	#
	$status = $oneItem['status'];
	if($status == 0 && intval($pvalTable) > 0) {
		$clsClassTable->updateOne($pvalTable,"status = 2");
	}
	#
	$clsTable = $oneItem['clsTable'];
	$clsTable = new $clsTable;
	$assign_list["clsTable"] = $clsTable;
	
	$target_id = $oneItem['target_id'];
	$assign_list["target_id"] = $target_id;
	
	$agent_id = $oneItem['agent_id'];
	
	$assign_list["agent_id"] = $agent_id;
	$clsCruiseCabin = new CruiseCabin();
	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	
	#
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#-------------Update Config Meta 
	$clsForm->addInputTextArea("full","note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");
	
	
	
	$reg_date = $oneItem['reg_date'];
	$clsBooking=new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$listBookingPrev = $clsBooking->getAll("1=1 and clsTable = 'Tour' and reg_date < '$reg_date' order by reg_date desc"); //print_r($cond); die();
	
	$bookingPrevItem=$listBookingPrev[0]['booking_id'];
	$assign_list["bookingPrevItem"] = $bookingPrevItem; //print_r($listItem); die();
	
	$listBookingNext = $clsBooking->getAll("1=1 and clsTable = 'Tour' and reg_date > '$reg_date' order by reg_date ASC"); //print_r($cond); die();
	
	$bookingNextItem=$listBookingNext[0]['booking_id'];
	$assign_list["bookingNextItem"] = $bookingNextItem; //print_r($listItem); die();
	#------------------------
	if(isset($_POST['submit']) && $_POST['submit'] =='Update'){
		if($oneItem['status']==1){
			$value = "is_send_email='".$_POST['sendmail']."'";
		}else{
			$value = "status='".$_POST['status']."'";
		}
		
		$value .= ",note='".addslashes($_POST['iso-note'])."'";
		#
		$pUrl = '';
		$pUrl.= "&act=edit";
		$pUrl.= "&agent_id=".$core->encryptID($agent_id)."";
		#
		//print_r($pvalTable.'xxx'.$value); die();
		if($clsClassTable->updateOne($pvalTable,$value)){
			if($_POST['sendmail']==1){
				//print_r(xxx); die();
				$clsClassTable->sendEmailSupportBooking($pvalTable);
			}
			
			header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=UpdateSuccess#isotab2');			
		}
	}
	
	if(isset($_POST['updateBooking']) && $_POST['updateBooking'] =='Update'){
		
		
		foreach($_POST as $k=>$v){
			$POST[$k] = $v;
		}
			
		$value .= "departure_date='".addslashes($_POST['departure_date'])."'";
		$value .= ",pickup_address='".addslashes($_POST['pickup_address'])."'";
		$value .= ",number_adult='".addslashes($_POST['number_adult'])."'";
		$value .= ",number_child='".addslashes($_POST['number_child'])."'";
		$value .= ",number_baby='".addslashes($_POST['number_baby'])."'";
		$value .= ",price_adult='".addslashes($_POST['price_adult'])."'";
		$value .= ",price_child='".addslashes($_POST['price_child'])."'";
		$value .= ",price_baby='".addslashes($_POST['price_baby'])."'";
		$value .= ",discount_adult='".addslashes($_POST['discount_adult'])."'";
		$value .= ",discount_child='".addslashes($_POST['discount_child'])."'";
		$value .= ",discount_baby='".addslashes($_POST['discount_baby'])."'";
		$value .= ",surcharge_price='".addslashes($_POST['total_surcharge'])."'";
		$value .= ",payment_method='".addslashes($_POST['payment_method'])."'";
		$value .= ",customer_note='".addslashes($_POST['customer_note'])."'";
		$value .= ",staff_note='".addslashes($_POST['staff_note'])."'";
		$value .= ",booking_store='".serialize($POST)."'";
		$value .= ",totalgrand='".$clsISO->processSmartNumber(str_replace('.00','',$_POST['totalgrand']))."'";
		$value .= ",deposit='".$clsISO->processSmartNumber(str_replace('.00','',$_POST['deposit']))."'";
		$value .= ",balance='".$clsISO->processSmartNumber(str_replace('.00','',$_POST['balance']))."'";
		
		//print_r($pvalTable.'xxxx'.$value); die();
		if($clsClassTable->updateOne($pvalTable,$value)){
			if($_POST['notify_user']=='Y'){
			
			}
			if($_POST['notify_department']=='Y'){
				
			}
			$pUrl = '';
			$pUrl.= "&act=editbooking";
			$pUrl.= "&booking_id=".$core->encryptID($pvalTable)."";
			
			header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=UpdateSuccess#isotab0');			
		}
	}
}
function default_print(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$user_id = $core->_USER['user_id'];
	
	$clsAgent= new Agent();
	$assign_list["clsAgent"] = $clsAgent;
	$clsCountry= new Country();
	$assign_list["clsCountry"] = $clsCountry;
	
	#
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	
	$string = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]:"";
	$pvalTable =intval($core->decryptID($string));
	$assign_list["pvalTable"] = $pvalTable;
	
	
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	#
	$clsTable = $oneItem['clsTable'];
	$clsTable = new $clsTable;
	$assign_list["clsTable"] = $clsTable;
	
	$target_id = $oneItem['target_id'];
	$assign_list["target_id"] = $target_id;
	
	$agent_id = $oneItem['agent_id'];
	
	$assign_list["agent_id"] = $agent_id;
	
	if($string != '' && $pvalTable==0){
		 header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
		 exit();
	}
	$assign_list["booking_id"] = $pvalTable;
}
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Agent";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	
	$string = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]:"";
	$pvalTable =intval($core->decryptID($string));
	if($pvalTable == ""){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=notPermission');
	}
	#
	if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=DeleteSuccess');
	}
}
function default_setting(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	if(isset($_POST['submit']) && $_POST['submit']=='Update'){
		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$clsConfiguration->updateValue($tmp[1], $val);
			}
		}
		for($i==1;$i<6;$i++){
			$isoman_url_Site_WhyAgentIcon_box = $_POST['isoman_url_Site_WhyAgentIcon_box_'.$i];
			if($isoman_url_Site_WhyAgentIcon_box != '' && $isoman_url_Site_WhyAgentIcon_box != '0'){
				$clsConfiguration->updateValue('Site_WhyAgentIcon_box_'.$i,$isoman_url_Site_WhyAgentIcon_box);
			}
		}
		
		header('location:'.PCMS_URL.'/index.php?mod='.$mod.'&act='.$act.'&message=UpdateSuccess');
		exit();
	}
	#
	$action = isset($_GET['action'])?$_GET['action']:'';
}
function default_ajUpdateStatusBooking(){
	global $core,$dbconn;
	#
	$clsClassTable = new Booking();
	$booking_id = isset($_POST['booking_id'])?$_POST['booking_id']:0;
	$status = isset($_POST['status'])?$_POST['status']:0;
	$user_id = $core->_USER['user_id'];
	#
	$clsClassTable->updateOne($booking_id,"status='$status'");
	
	echo 1; die();
}
?>