<?php
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	#
	$agency_view = $agency;  $assign_list["profile_id_view"] = $agency_view;
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
	$oneProfileView = $clsProfile->getOne($agency_view);
	$assign_list["oneProfileView"] = $oneProfileView;
    /*=============Title & Description Page==================*/
	$title_page = 'Trang thành viên';
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
}
function default_list_tour(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency,$clsConfiguration;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$extLang;
	$clsTourStore = new TourStore();$assign_list["clsTourStore"] = $clsTourStore;
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
	$clsPromoValue = new PromoValue();$assign_list["clsPromoValue"] = $clsPromoValue;
	$clsProperty = new Property();$assign_list["clsProperty"] = $clsProperty;  
	$clsCountry = new _Country();$assign_list["clsCountry"] = $clsCountry;
	$clsCity = new _City();$assign_list["clsCity"] = $clsCity; 
	
	$listCoutry = $clsCountry->getAll("is_trash=0");
	$assign_list["listCoutry"] = $listCoutry;
	$assign_list["get"] = $_GET;
	
	#
	$SiteHasCategoryGroup_Tours = $clsConfiguration->getValue('SiteHasCategoryGroup_Tours');
	$SiteHasGroup_Tours = $clsConfiguration->getValue("SiteHasGroup_Tours");
	$tour_group_id = 0;
	if($SiteHasGroup_Tours){
		$clsTourGroup = new TourGroup();
		$assign_list["clsTourGroup"] = $clsTourGroup;
		$tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
	}
	$assign_list["tour_group_id"] = $tour_group_id;
	#
	$cat_id= 0;
	if($clsConfiguration->getValue('SiteHasCat_Tours')){
		$clsTourCat = new TourCategory(); $assign_list["clsTourCat"] = $clsTourCat;
		$cat_id=isset($_GET['cat_id'])?intval($_GET['cat_id']):0;
	}
	$assign_list["cat_id"] = $cat_id;
	#
	$price_range_id= 0;
	if($clsConfiguration->getValue('SiteHasPriceRange_Tours')){
		$clsPriceRange = new PriceRange(); $assign_list["clsPriceRange"] = $clsPriceRange;
		$price_range_id = isset($_GET['price_range_id'])?intval($_GET['price_range_id']):0;
	}
	$assign_list["price_range_id"] = $price_range_id;
	#
	$tour_type_id = isset($_GET['tour_type_id'])?intval($_GET['tour_type_id']):0;
	$assign_list["tour_type_id"] = $tour_type_id;
	#
	
	$clsConfiguration = new Configuration(); 
	$assign_list["clsConfiguration"] = $clsConfiguration;
	$assign_list["PROMO_PERCENT"] = PROMO_PERCENT;
	$assign_list["PROMO_VALUE"] = PROMO_VALUE;
	#
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;	
	$listPromoValue = $clsPromoValue->getAll("is_trash=0");
	$assign_list["listPromoValue"] = $listPromoValue;
	#
	$agency = $clsProfile->getUserID();
	if( empty( $agency ) ){
		header('location:'.PCMS_URL.'profile/sign-in.html');	  
	}
	
	if(intval($_GET['cat_id']) > 0){
		$cat_id = $_GET['cat_id'];
		$cond.=" and (tour.cat_id = '$cat_id' or tour.list_cat_id like '%|$cat_id|%')";		
	}	
	$number_day = $_GET['number_day'];
	if(isset($number_day) && intval($number_day)!=0){
		$cond.=" and tour.number_day = '".$number_day."'";
	}
	$keyword = $_GET['keyword'];
	if(isset($keyword) && !empty($keyword) ){
		$keyword = $core->replaceSpace($keyword);
		$cond.=" and tour.slug like '%$keyword%'";
	}
	$depart_start = $_GET['depart_start'];
	if(isset($depart_start) && !empty($depart_start) ){
		$start_date = str_replace('/','-',$depart_start).' 00:00:00';
		$start_date = strtotime($start_date);
		$cond.=" and sd.start_date >= '$start_date'";
	}
	$depart_end = $_GET['depart_end'];
	if(isset($depart_end) && !empty($depart_end) ){
		$depart_end = str_replace('/','-',$depart_end).' 23:59:59';
		$depart_end = strtotime($depart_end);
		$cond.=" and sd.start_date <= '$depart_end'";
	}
	$cond.=" GROUP BY tour.tour_id";
	$listAgenOfTour = $dbconn->getAll("SELECT tour.*,ts.tour_store_id,pv.type_promo,pv.promo_value_id,pv.val FROM default_tour as tour 
	LEFT JOIN ta_tour_store as ts ON ts.tour_id=tour.tour_id
	LEFT JOIN default_tour_start_date as sd ON sd.tour_id=tour.tour_id
	LEFT JOIN ta_promo_value as pv on pv.promo_value_id= ts.promo_value_id WHERE ts.profile_id='$agency' $cond");
	$assign_list["listAgenOfTour"] = $listAgenOfTour;
	$title_page = 'List tour';
	$assign_list["title_page"] = $title_page;
}

function getTripPrice($tour_price_row_id,$start_date,$tour_id){
	global $core, $clsISO, $dbconn;
	$one = $dbconn->getAll("SELECT * FROM ".DB_PREFIX."tour_price_val WHERE tour_price_row_id='$tour_price_row_id' and departure_date='$start_date' and tour_id='$tour_id'");
	return $one[0]['price']==''?0:$clsISO->formatPrice($one[0]['price']);
}
function getTaTripPrice($tour_price_row_id,$start_date,$tour_id){
	global $core, $clsISO, $dbconn;
	$one = $dbconn->getAll("SELECT * FROM ".DB_PREFIX."ta_tour_price_val WHERE tour_price_row_id='$tour_price_row_id' and departure_date='$start_date' and tour_id='$tour_id'");
	return $one[0]['price']==''?0:$clsISO->formatPrice($one[0]['price']);
}
function default_bookTourItem(){
	$aryData = array('ok'=>true,'message'=>'','error'=>'','reault'=>'');	
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency,$clsISO;
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;  
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;  
	$clsCity = new _City();
	$assign_list["clsCity"] = $clsCity;
	
	$clsTaTourStore = new TaTourStore();
	$assign_list["clsTaTourStore"] = $clsTaTourStore; 
	$clsTour = new Tour();
	$assign_list["clsTour"] = $clsTour; 
	$clsTourPriceAgeType = new TourPriceAgeType();
	$clsTourPriceCustomerType = new TourPriceCustomerType();
	$clsTourPriceUnit = new TourPriceUnit();
	$clsTourStartDate = new TourStartDate();

	$clsTourProperty = new TourProperty(); $assign_list["clsTourProperty"] = $clsTourProperty;
	$clsTourPriceRow = new TourPriceRow(); $assign_list["clsTourPriceRow"] = $clsTourPriceRow;
	$clsTourPriceCol = new TourPriceCol(); $assign_list["clsTourPriceCol"] = $clsTourPriceCol;
	$clsTourPriceVal = new TourPriceVal(); $assign_list["clsTourPriceVal"] = $clsTourPriceVal;
	#
	$tour_id = isset($_GET['tour_id'])? ($_GET['tour_id']) : '';
	$tour_id = intval($core->decryptID($tour_id)); 
	$agency = $clsProfile->getUserID();
	$oneTour = $clsTour->getOne($tour_id);
	#		
	$listAgenOfTour = $dbconn->getAll("SELECT tour.*,ts.tour_store_id,pv.type_promo,pv.promo_value_id,pv.val FROM default_tour as tour 
	LEFT JOIN ta_tour_store as ts ON ts.tour_id=tour.tour_id 
	LEFT JOIN ta_promo_value as pv on pv.promo_value_id= ts.promo_value_id WHERE ts.profile_id='$agency' and tour.tour_id ='$tour_id'");	
	if( !empty( $listAgenOfTour ) ){
		$oneTour =  $listAgenOfTour[0];
	}
	$start_date = $_POST['data']['start_date'];
	$start_date = str_replace("/", "-", $start_date);
	$endDate = strtotime($start_date.' 23:59:59');
	$start_date = strtotime($start_date.' 00:00:00');
	
	$lstVisitorType = $dbconn->getAll("SELECT * FROM default_tour_property WHERE is_trash=0 and type='VISITORTYPE' and lang_id='en' order by order_no asc");
	$lstTourStartDate = $dbconn->getAll("SELECT * FROM default_tour_start_date WHERE tour_id='$tour_id' and start_date >= '$start_date' and start_date <= '$endDate' order by start_date asc");
	$arrTourCard = array();		
	$arrPrice = array(ADULT=>0,CHILDREN=>0,INFANT=>0);
	foreach( $lstTourStartDate as $key=>$value ){		
		foreach( $lstVisitorType as $k=>$v ){
			$price = getTripPrice($v['tour_property_id'],$value['start_date'],$tour_id);				
			$arrPrice[$v['tour_property_id']] = $price;			
		}
	}				
	$arrTourCard['visit_price'] = $arrPrice;
	$arrTour = array();
	$postData = $_POST;
	$arrTourCard = array_merge( $postData['data'], $arrTourCard);		
	if( !isset( $_SESSION['tourCard'] ) ){
		$_SESSION['tourCard'] = array();		
	}
	$arrTourCard['tour_id']	= $tour_id;
	$price_adult = $arrTourCard['visit_price'][ADULT];
	$price_children = $arrTourCard['visit_price'][CHILDREN];
	$price_infant = $arrTourCard['visit_price'][INFANT];		
	$quanlity_adult = intval($arrTourCard['adult']);
	$quanlity_children = intval($arrTourCard['children']);
	$quanlity_infant = intval($arrTourCard['infant']);
	$arrTourCard['total'] = intval(($price_adult*$quanlity_adult)+($price_children*$quanlity_children)+($price_infant*$quanlity_infant));
	#
	$arrTourCard['trip_price'] = $oneTour['trip_price'];
	$arrTourCard['type_promo'] = $oneTour['type_promo'];
	$arrTourCard['val'] = $oneTour['val'];
	if($oneTour['type_promo'] == PROMO_VALUE){
		$arrTourCard['total'] = $arrTourCard['total'] - $oneTour['val'];
		$arrTourCard['dis_count'] = $oneTour['val'];
	}
	if($oneTour['type_promo'] == PROMO_PERCENT){	
		$arrTourCard['dis_count'] = $arrTourCard['total']*$oneTour['val']/100;		
		$arrTourCard['total'] = $arrTourCard['total'] - $arrTourCard['total']*$oneTour['val']/100;
		
	}	
	$_SESSION['tourCard'][] = $arrTourCard;	
	echo json_encode( $aryData );	
	die();
}

function default_RemoveItemOrder(){
	$aryData = array('ok'=>true,'message'=>'','error'=>'','reault'=>'');
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	$key = isset($_POST['key'])? ($_POST['key']) : '';
	if( isset( $_SESSION['tourCard'][$key] ) ){
		unset( $_SESSION['tourCard'][$key] );
		array_values($_SESSION['tourCard']);
		sort($_SESSION['tourCard']);
		$aryData['message'] = 'Delete this tour successfully!';
	}
	else{
		$aryData['error'] = 'Delete this tour error!';
	}
	echo json_encode($aryData);die();
}

function default_bookOrder(){	
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;$assign_list["dbconn"] = $dbconn;
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;  
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;  
	$clsCity = new _City();
	$assign_list["clsCity"] = $clsCity; 
	$clsTaTourStore = new TaTourStore();
	$assign_list["clsTaTourStore"] = $clsTaTourStore; 
	$clsTour = new Tour();
	$assign_list["clsTour"] = $clsTour; 
	$agency = $clsProfile->getUserID();
	$lstVisitorType = $dbconn->getAll("SELECT * FROM default_tour_property WHERE is_trash=0 and type='VISITORTYPE' and lang_id='en' order by order_no asc");
	#
	$listAgenOfTour = array();
	$arrDateTour = array();
	if( isset($_SESSION['tourCard']) ){
		if( isset($_POST['data']) ){
			foreach( $_POST['data'] as $key=>$value ){
				foreach( $value as $k=>$v ){					
					$_SESSION['tourCard'][$key][$k] = $v;
				}
				$tour_id = $_SESSION['tourCard'][$key]['tour_id'];
				$start_date = $value['start_date'];
				$start_date = str_replace("/", "-", $start_date);
				$endDate = strtotime($start_date.' 23:59:59');
				$start_date = strtotime($start_date.' 00:00:00');
				$lstTourStartDate = $dbconn->getAll("SELECT * FROM default_tour_start_date WHERE tour_id='$tour_id' and start_date >= '$start_date' and start_date <= '$endDate' order by start_date asc");				
				$listAgenOfTour = $dbconn->getAll("SELECT tour.*,ts.tour_store_id,pv.type_promo,pv.promo_value_id,pv.val FROM default_tour as tour 
	LEFT JOIN ta_tour_store as ts ON ts.tour_id=tour.tour_id 
	LEFT JOIN ta_promo_value as pv on pv.promo_value_id= ts.promo_value_id WHERE ts.profile_id='$agency' and tour.tour_id ='$tour_id'");	
				if( !empty( $listAgenOfTour ) ){
					$oneTour =  $listAgenOfTour[0];
				}	
				$arrPrice = array(ADULT=>0,CHILDREN=>0,INFANT=>0);
				foreach( $lstTourStartDate as $ke=>$val ){		
					foreach( $lstVisitorType as $k=>$vType ){
						$price = getTripPrice($vType['tour_property_id'],$val['start_date'],$tour_id);				
						$arrPrice[$vType['tour_property_id']] = $price;							
					}
				}
				$_SESSION['tourCard'][$key]['visit_price'] = $arrPrice;		
				#
				$price_adult = $_SESSION['tourCard'][$key]['visit_price'][ADULT];
				$price_children =$_SESSION['tourCard'][$key]['visit_price'][CHILDREN];
				$price_infant = $_SESSION['tourCard'][$key]['visit_price'][INFANT];
				#
							
				$quanlity_adult = intval($_SESSION['tourCard'][$key]['adult']);
				$quanlity_children = intval($_SESSION['tourCard'][$key]['children']);
				$quanlity_infant = intval($_SESSION['tourCard'][$key]['infant']);
				$_SESSION['tourCard'][$key]['total'] = intval(($price_adult*$quanlity_adult)+($price_children*$quanlity_children)+($price_infant*$quanlity_infant));
				if($_SESSION['tourCard'][$key]['type_promo'] == PROMO_VALUE){
					$_SESSION['tourCard'][$key]['dis_count'] = $_SESSION['tourCard'][$key]['val'];
					$_SESSION['tourCard'][$key]['total'] = $_SESSION['tourCard'][$key]['total'] - $_SESSION['tourCard'][$key]['val'];					
				}
				if($_SESSION['tourCard'][$key]['type_promo'] == PROMO_PERCENT){	
					$_SESSION['tourCard'][$key]['dis_count'] = $_SESSION['tourCard'][$key]['total']*$_SESSION['tourCard'][$key]['val']/100;		
					$_SESSION['tourCard'][$key]['total'] = $_SESSION['tourCard'][$key]['total'] - $_SESSION['tourCard'][$key]['total']*$_SESSION['tourCard'][$key]['val']/100;
					
				}
			}			
		}
		$assign_list["tourCard"] = $_SESSION['tourCard'];
		$arrTourID = array(); 
		foreach( $_SESSION['tourCard'] as $key=>$value ){
			$tour_id = $value['tour_id'];
			$listAgenOfTour = $dbconn->getAll("SELECT tour.*,ts.tour_store_id,pv.type_promo,pv.promo_value_id,pv.promo_value_id,pv.val FROM default_tour as tour 
		LEFT JOIN ta_tour_store as ts ON ts.tour_id=tour.tour_id 
		LEFT JOIN ta_promo_value as pv on pv.promo_value_id= ts.promo_value_id WHERE ts.profile_id='$agency' and tour.tour_id ='$tour_id'");
			if( !empty( $listAgenOfTour ) ){
				$dateNow = date('d-m-Y').' 23:59:59';
				$dateNow = strtotime($dateNow);
				#
				foreach( $listAgenOfTour as $key=>$value ){	
					$tour_id = $value['tour_id'];			
					$lstTourStartDate = $dbconn->getAll("select * from default_tour_start_date where tour_id='$tour_id' and start_date > '$dateNow' order by start_date asc");
					$arrDate = array();
					if( !empty( $lstTourStartDate ) ){
						foreach( $lstTourStartDate as $k=>$val ){
							$arrDate[] = date('j-n-Y',$val['start_date']);
						}
					}
					$arrDateTour[] = $arrDate;				
				}
				
			}
		}		
	}
	$assign_list["arrDateTour"] = json_encode($arrDateTour);
	$assign_list["listAgenOfTour"] = $listAgenOfTour; 
	#
	$tour_id = isset($_GET['tour_id'])? ($_GET['tour_id']) : '';
	$tour_id = intval($core->decryptID($tour_id));
	
	$oneTour = $clsTour->getOne($tour_id);
	#	
	
	$listCoutry = $clsCountry->getAll("is_trash=0");
	$assign_list["listCoutry"] = $listCoutry; 
	
	$clsConfiguration = new Configuration(); 
	$assign_list["clsConfiguration"] = $clsConfiguration;
	$assign_list["PROMO_PERCENT"] = PROMO_PERCENT;
	$assign_list["PROMO_VALUE"] = PROMO_VALUE;
	#
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;	
	$listPromoValue = $clsPromoValue->getAll("is_trash=0");
	$assign_list["listPromoValue"] = $listPromoValue;
	#
	$agency = $clsProfile->getUserID();
	$title_page = 'Booking tour';
	$assign_list["title_page"] = $title_page;
}

function default_OrderFinal(){	
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;  
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;  
	$clsCity = new _City();
	$assign_list["clsCity"] = $clsCity; 
	$clsTaTourStore = new TaTourStore();
	$assign_list["clsTaTourStore"] = $clsTaTourStore; 				
	#
	$clsTour = new Tour();
	$assign_list["clsTour"] = $clsTour;			
	$clsTaBooking = new TaBooking();
	$clsTaBookingDetail = new TaBookingDetail();
	#
	$agency = $clsProfile->getUserID();
	$oneProfile = $clsProfile->getOne($agency);
	$assign_list["oneProfile"] = $oneProfile; 
	$listAgenOfTour = array();
	if( isset($_SESSION['tourCard']) ){
		$assign_list["tourCard"] = $_SESSION['tourCard'];
		$arrTourID = array(); 
		foreach( $_SESSION['tourCard'] as $key=>$value ){
			$arrTourID[] = $key;
		}
		$strID = implode(",",$arrTourID);
		$listAgenOfTour = $dbconn->getAll("SELECT tour.*,ts.tour_store_id,pv.type_promo,pv.promo_value_id,pv.promo_value_id,pv.val FROM default_tour as tour 
	LEFT JOIN ta_tour_store as ts ON ts.tour_id=tour.tour_id 
	LEFT JOIN ta_promo_value as pv on pv.promo_value_id= ts.promo_value_id WHERE ts.profile_id='$agency' and tour.tour_id IN ($strID)");	
	}
	$assign_list["listAgenOfTour"] = $listAgenOfTour; 
	#
	$tour_id = isset($_GET['tour_id'])? ($_GET['tour_id']) : '';
	$tour_id = intval($core->decryptID($tour_id));	
	$oneTour = $clsTour->getOne($tour_id);
	#	
	$listCoutry = $clsCountry->getAll("is_trash=0");
	$assign_list["listCoutry"] = $listCoutry; 
	
	$clsConfiguration = new Configuration(); 
	$assign_list["clsConfiguration"] = $clsConfiguration;
	$assign_list["PROMO_PERCENT"] = PROMO_PERCENT;
	$assign_list["PROMO_VALUE"] = PROMO_VALUE;
	#
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;	
	$listPromoValue = $clsPromoValue->getAll("is_trash=0");
	$assign_list["listPromoValue"] = $listPromoValue;
	#
	$agency = $clsProfile->getUserID();
	$title_page = 'Booking tour';
	$assign_list["title_page"] = $title_page;
			
	if( isset($_POST['data']['user']) ){
		//
		$amount = 0;
		foreach( $_SESSION['tourCard'] as $key=>$value ){	
			$amount+=floatval($value['total']);
		}
		$dataUser = $_POST['data']['user'];		
		$booking_id = $clsTaBooking->getMaxId();
		$booking_code = $clsTaBooking->generateBookingCode($booking_id,'Tour');
		#
		$fBook="booking_id,profile_id,full_name,company,address,email,phone,job,fax,booking_code,reg_date,ip_booking,amount";
		$vBook="'$booking_id'
		,'".addslashes($agency)."'
		,'".addslashes($dataUser['full_name'])."'
		,'".addslashes($dataUser['company'])."'
		,'".addslashes($dataUser['address'])."'
		,'".addslashes($dataUser['email'])."'
		,'".addslashes($dataUser['phone'])."'
		,'".addslashes($dataUser['job'])."'
		,'".addslashes($dataUser['fax'])."'
		,'$booking_code'
		,'".time()."'
		,'".$_SERVER['REMOTE_ADDR']."'
		,".addslashes($amount)."";
		#		
		if($clsTaBooking->insertOne($fBook,$vBook)){
			//if(true){
			//$clsBooking->sendEmailBookingTour($booking_id);
			//header('location: /booking/tours/successful');
			foreach( $_SESSION['tourCard'] as $key=>$value ){				
				$tour_id = $value['tour_id'];
				$tour_duplicatID = default_dulicate_tour($tour_id,$agency);
				$start_date = str_replace('/','-',$value['start_date']);
				$book_detail_id = $clsTaBookingDetail->getMaxId();
				$fieldDetails = 'book_detail_id,booking_id,profile_id,tour_id,adult,children,infant,reg_date,start_date,upd_date,default_choice,trip_price,
				dis_count,val,type_promo,total,purchaser,purchaser_slug';
				$vBookDetail = "'$book_detail_id'
				,'".addslashes($booking_id)."'
				,'".addslashes($agency)."'
				,'".addslashes($tour_duplicatID)."'
				,'".addslashes($value['adult'])."'
				,'".addslashes($value['children'])."'
				,'".addslashes($value['infant'])."'
				,'".addslashes(time())."'
				,'".addslashes(strtotime($start_date))."'
				,'".addslashes(time())."'
				,'".addslashes(CHOICE_ON)."'			
				,".addslashes(floatval($value['trip_price']))."
				,".addslashes(floatval($value['dis_count']))."
				,".addslashes(floatval($value['val']))."
				,'".addslashes($value['type_promo'])."'
				,".addslashes(floatval($value['total']))."
				,'".addslashes($value['purchaser'])."'
				,'".addslashes($core->replaceSpace($value['purchaser']))."'";				
				$clsTaBookingDetail->insertOne( $fieldDetails,$vBookDetail );
			}	
			unset($_SESSION['tourCard']);		
			header('location: '.PCMS_URL.'/profile/your_order.html');
		}else{
			//header('location: /booking/tours/error');
		}				
	}
	$title_page = 'Booking tour';
	$assign_list["title_page"] = $title_page;
}

function default_dulicate_tour_from_ta($tour_id = NULL,$agency = NULL){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
	$clsTour = new Tour();$assign_list["clsTaTour"] = $clsTaTour;
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;
	#
	$clsTaTour = new TaTour();
	$assign_list["clsTaTour"] = $clsTaTour;
	$clsTaTourItinerary = new TaTourItinerary();
	$assign_list["clsTaTourItinerary"] = $clsTaTourItinerary;
	$clsTaTourDestination = new TaTourDestination();
	$assign_list["clsTaTourDestination"] = $clsTaTourDestination;
	$clsTaTourCustomField = new TaTourCustomField();
	$assign_list["clsTaTourCustomField"] = $clsTaTourCustomField;	
	$clsTaTourStartDate = new TaTourStartDate();
	$assign_list["clsTaTourStartDate"] = $clsTaTourStartDate; 
	$clsTaTourImage = new TaTourImage();
	$assign_list["clsTaTourImage"] = $clsTaTourImage; 
	$clsTaTourPriceVal = new TaTourPriceVal();
	$assign_list["clsTaTourPriceVal"] = $clsTaTourPriceVal;	
	$clsTaTourPriceRow = new TaTourPriceRow();
	$assign_list["clsTaTourPriceRow"] = $clsTaTourPriceRow; 
	$clsTaTourPriceCol = new TaTourPriceCol();
	$assign_list["clsTaTourPriceCol"] = $clsTaTourPriceCol;
	
	#
	$clsTourStartDate = new TourStartDate();
	$assign_list["clsTourStartDate"] = $clsTourStartDate; 
	$clsTourImage = new TourImage();
	$assign_list["clsTourImage"] = $clsTourImage; 
	$clsTourPriceVal = new TourPriceVal();
	$assign_list["clsTourPriceVal"] = $clsTourPriceVal;
	$clsTourItinerary = new TourItinerary();
	$assign_list["clsTourItinerary"] = $clsTourItinerary;
	$clsTourDestination = new TourDestination();
	$assign_list["clsTourDestination"] = $clsTourDestination;	
	$clsTourCustomField = new TourCustomField();
	$assign_list["clsTourCustomField"] = $clsTourCustomField;	
	$clsTourPriceRow = new TourPriceRow();
	$assign_list["clsTourPriceRow"] = $clsTourPriceRow; 
	$clsTourPriceCol = new TourPriceCol();
	$assign_list["clsTourPriceCol"] = $clsTourPriceCol;
	## copy Tour
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTour->tbl");	
	$arrFieldTour = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrFieldTour[] = $value['Field'];
		}
	}
	$strFieldTour = implode(',',$arrFieldTour);
	$taTourID = $clsTaTour->getMaxId();
	$arrTourValue = $clsTaTour->getOne($tour_id);	
	if( !empty( $arrTourValue ) ){
		foreach( $arrTourValue as $key=>$value ){
			 if(is_numeric($key)){
				 unset($arrTourValue[$key]);
			 }else{
				 $val = addslashes($arrTourValue[$key]);
				 $arrTourValue[$key] = '"'.$val.'"';
			 }
		}
		$arrTourValue['tour_id'] = $taTourID;
		$arrTourValue['tour_id_old'] = $tour_id;	
		$strValueTour = implode(',',$arrTourValue);			
		$sqlColumn = "INSERT INTO $clsTaTour->tbl ($strFieldTour) VALUES ($strValueTour)";
		$dbconn->Execute($sqlColumn);	
	}	
	# copy TourItinerary
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourItinerary->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrItineraryValue = $dbconn->getAll("SELECT * from $clsTaTourItinerary->tbl WHERE is_trash=0 and tour_id=$tour_id");
	$arrItinerary = array();
	if( !empty( $arrItineraryValue ) ){	
		$itinerary_id = $clsTaTourItinerary->getMaxId();
		foreach( $arrItineraryValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['itinerary_id'] = $itinerary_id++;
			$value['tour_id'] = $taTourID;			
			$arrItinerary[] = '('.implode(',',$value).')';
		}
		$strItineraryValue = implode(',',$arrItinerary);
		$sqlColumn = "INSERT INTO $clsTaTourItinerary->tbl ($strField) VALUES $strItineraryValue";
		$dbconn->Execute($sqlColumn);
	}	
	#### copy TourDestination
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourDestination->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrDestinationValue = $dbconn->getAll("SELECT * from $clsTaTourDestination->tbl WHERE is_trash=0 and tour_id=$tour_id");
	$arrDestination = array();
	if( !empty( $arrDestinationValue ) ){	
		$tour_destination_id = $clsTaTourDestination->getMaxId();
		foreach( $arrDestinationValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_destination_id'] = $tour_destination_id++;
			$value['tour_id'] = $taTourID;		
			$arrDestination[] = '('.implode(',',$value).')';
		}
		$strDestinationValue = implode(',',$arrDestination);
		$sqlColumn = "INSERT INTO $clsTaTourDestination->tbl ($strField) VALUES $strDestinationValue";
		$dbconn->Execute($sqlColumn);
	}	
	#copy TourCustomField
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourCustomField->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrCustomFieldValue = $dbconn->getAll("SELECT * from $clsTaTourCustomField->tbl WHERE is_trash=0 and tour_id=$tour_id");	
	$arrCustomField = array();
	if( !empty( $arrCustomFieldValue ) ){	
		$tour_customfield_id = $clsTaTourDestination->getMaxId();
		foreach( $arrCustomFieldValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_customfield_id'] = $tour_customfield_id++;
			$value['tour_id'] = $taTourID;		
			$arrCustomField[] = '('.implode(',',$value).')';
		}
		$strCustomFieldValue = implode(',',$arrCustomField);
		$sqlColumn = "INSERT INTO $clsTaTourCustomField->tbl ($strField) VALUES $strCustomFieldValue";		
		$dbconn->Execute($sqlColumn);
	}
	#copy TourPriceVal
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourPriceVal->tbl");
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrTourPriceValValue = $dbconn->getAll("SELECT * FROM $clsTaTourPriceVal->tbl WHERE tour_id=$tour_id");
	$arrTourPriceVal = array();
	if( !empty( $arrTourPriceValValue ) ){
		$tour_price_val_id = $clsTaTourPriceVal->getMaxId();
		foreach( $arrTourPriceValValue as $key=>$value ){
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_price_val_id'] = $tour_price_val_id++;
			$value['tour_id'] = $taTourID;		
			$arrTourPriceVal[] = '('.implode(',',$value).')';
		}
		$strTourPriceValValue = implode(',',$arrTourPriceVal);
		$sqlColumn = "INSERT INTO $clsTaTourPriceVal->tbl ($strField) VALUES $strTourPriceValValue";
		$dbconn->Execute($sqlColumn);
	}	
	#copy clsTourImage
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourImage->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrTourImageValue = $dbconn->getAll("SELECT * from $clsTaTourImage->tbl WHERE is_trash=0 and table_id=$tour_id");
	$arrTourImage = array();
	if( !empty( $arrTourImageValue ) ){	
		$tour_image_id = $clsTaTourImage->getMaxId();
		foreach( $arrTourImageValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_image_id'] = $tour_image_id++;
			$value['table_id'] = $taTourID;		
			$arrTourImage[] = '('.implode(',',$value).')';
		}
		$strTourImage = implode(',',$arrTourImage);
		$sqlColumn = "INSERT INTO $clsTaTourImage->tbl ($strField) VALUES $strTourImage";
		$dbconn->Execute($sqlColumn);
	}
	#
	#copy clsTourStartDate
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourStartDate->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrTourStartDateValue = $dbconn->getAll("SELECT * from $clsTaTourStartDate->tbl WHERE is_trash=0 and tour_id=$tour_id");
	$arrTourStartDate = array();
	if( !empty( $arrTourStartDateValue ) ){	
		$tour_start_date_id = $clsTaTourStartDate->getMaxId();
		foreach( $arrTourStartDateValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_start_date_id'] = $tour_start_date_id++;
			$value['tour_id'] = $taTourID;		
			$arrTourStartDate[] = '('.implode(',',$value).')';
		}
		$strTourStartDate = implode(',',$arrTourStartDate);
		$sqlColumn = "INSERT INTO $clsTaTourStartDate->tbl ($strField) VALUES $strTourStartDate";
		$dbconn->Execute($sqlColumn);
	}
	#copy TourPriceRow
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourPriceRow->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrTourPriceRowValue = $dbconn->getAll("SELECT * from $clsTaTourPriceRow->tbl WHERE is_trash=0 and tour_id=$tour_id");
	$arrTourPriceRow = array();
	if( !empty( $arrTourPriceRowValue ) ){	
		$tour_price_row_id = $clsTaTourPriceRow->getMaxId();
		foreach( $arrTourPriceRowValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 } 
			}
			$value['tour_price_row_id'] = $tour_price_row_id++;
			$value['tour_id'] = $taTourID;		
			$arrTourPriceRow[] = '('.implode(',',$value).')';
		}
		$strTourPriceRow = implode(',',$arrTourPriceRow);
		$sqlColumn = "INSERT INTO $clsTaTourPriceRow->tbl ($strField) VALUES $strTourPriceRow";
		$dbconn->Execute($sqlColumn);
	}
	#copy TourPriceCol
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourPriceCol->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrTourPriceColValue = $dbconn->getAll("SELECT * from $clsTaTourPriceCol->tbl WHERE is_trash=0 and tour_id=$tour_id");
	$arrTourPriceCol = array();
	if( !empty( $arrTourPriceRowValue ) ){	
		$tour_price_col_id = $clsTaTourPriceCol->getMaxId();
		foreach( $arrTourPriceColValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_price_col_id'] = $tour_price_col_id++;
			$value['tour_id'] = $taTourID;		
			$arrTourPriceCol[] = '('.implode(',',$value).')';
		}
		$strTourPriceCol = implode(',',$arrTourPriceCol);
		$sqlColumn = "INSERT INTO $clsTaTourPriceCol->tbl ($strField) VALUES $strTourPriceCol";
		$dbconn->Execute($sqlColumn);
	}
	return $taTourID;
}

function default_dulicate_tour($tour_id = NULL,$agency = NULL){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
	$clsTour = new Tour();$assign_list["clsTaTour"] = $clsTaTour;
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;
	#
	$clsTaTour = new TaTour();
	$assign_list["clsTaTour"] = $clsTaTour;
	$clsTaTourItinerary = new TaTourItinerary();
	$assign_list["clsTaTourItinerary"] = $clsTaTourItinerary;
	$clsTaTourDestination = new TaTourDestination();
	$assign_list["clsTaTourDestination"] = $clsTaTourDestination;
	$clsTaTourCustomField = new TaTourCustomField();
	$assign_list["clsTaTourCustomField"] = $clsTaTourCustomField;	
	$clsTaTourStartDate = new TaTourStartDate();
	$assign_list["clsTaTourStartDate"] = $clsTaTourStartDate; 
	$clsTaTourImage = new TaTourImage();
	$assign_list["clsTaTourImage"] = $clsTaTourImage; 
	$clsTaTourPriceVal = new TaTourPriceVal();
	$assign_list["clsTaTourPriceVal"] = $clsTaTourPriceVal;	
	$clsTaTourPriceRow = new TaTourPriceRow();
	$assign_list["clsTaTourPriceRow"] = $clsTaTourPriceRow; 
	$clsTaTourPriceCol = new TaTourPriceCol();
	$assign_list["clsTaTourPriceCol"] = $clsTaTourPriceCol;
	
	#
	$clsTourStartDate = new TourStartDate();
	$assign_list["clsTourStartDate"] = $clsTourStartDate; 
	$clsTourImage = new TourImage();
	$assign_list["clsTourImage"] = $clsTourImage; 
	$clsTourPriceVal = new TourPriceVal();
	$assign_list["clsTourPriceVal"] = $clsTourPriceVal;
	$clsTourItinerary = new TourItinerary();
	$assign_list["clsTourItinerary"] = $clsTourItinerary;
	$clsTourDestination = new TourDestination();
	$assign_list["clsTourDestination"] = $clsTourDestination;	
	$clsTourCustomField = new TourCustomField();
	$assign_list["clsTourCustomField"] = $clsTourCustomField;	
	$clsTourPriceRow = new TourPriceRow();
	$assign_list["clsTourPriceRow"] = $clsTourPriceRow; 
	$clsTourPriceCol = new TourPriceCol();
	$assign_list["clsTourPriceCol"] = $clsTourPriceCol;
	## copy Tour
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTour->tbl");	
	$arrFieldTour = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrFieldTour[] = $value['Field'];
		}
	}
	$strFieldTour = implode(',',$arrFieldTour);
	$taTourID = $clsTaTour->getMaxId();
	$arrTourValue = $clsTour->getOne($tour_id);	
	if( !empty( $arrTourValue ) ){
		foreach( $arrTourValue as $key=>$value ){
			 if(is_numeric($key)){
				 unset($arrTourValue[$key]);
			 }else{
				 $val = addslashes($arrTourValue[$key]);
				 $arrTourValue[$key] = '"'.$val.'"';
			 }
		}
		$arrTourValue['tour_id'] = $taTourID;
		$arrTourValue['tour_id_old'] = $tour_id;	
		$strValueTour = implode(',',$arrTourValue);			
		$sqlColumn = "INSERT INTO $clsTaTour->tbl ($strFieldTour) VALUES ($strValueTour)";
		$dbconn->Execute($sqlColumn);	
	}	
	# copy TourItinerary
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourItinerary->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrItineraryValue = $dbconn->getAll("SELECT * from $clsTourItinerary->tbl WHERE is_trash=0 and tour_id=$tour_id");
	$arrItinerary = array();
	if( !empty( $arrItineraryValue ) ){	
		$itinerary_id = $clsTaTourItinerary->getMaxId();
		foreach( $arrItineraryValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['itinerary_id'] = $itinerary_id++;
			$value['tour_id'] = $taTourID;			
			$arrItinerary[] = '('.implode(',',$value).')';
		}
		$strItineraryValue = implode(',',$arrItinerary);
		$sqlColumn = "INSERT INTO $clsTaTourItinerary->tbl ($strField) VALUES $strItineraryValue";
		$dbconn->Execute($sqlColumn);
	}	
	#### copy TourDestination
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourDestination->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrDestinationValue = $dbconn->getAll("SELECT * from $clsTourDestination->tbl WHERE is_trash=0 and tour_id=$tour_id");
	$arrDestination = array();
	if( !empty( $arrDestinationValue ) ){	
		$tour_destination_id = $clsTaTourDestination->getMaxId();
		foreach( $arrDestinationValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_destination_id'] = $tour_destination_id++;
			$value['tour_id'] = $taTourID;		
			$arrDestination[] = '('.implode(',',$value).')';
		}
		$strDestinationValue = implode(',',$arrDestination);
		$sqlColumn = "INSERT INTO $clsTaTourDestination->tbl ($strField) VALUES $strDestinationValue";
		$dbconn->Execute($sqlColumn);
	}	
	#copy TourCustomField
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourCustomField->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrCustomFieldValue = $dbconn->getAll("SELECT * from $clsTourCustomField->tbl WHERE is_trash=0 and tour_id=$tour_id");	
	$arrCustomField = array();
	if( !empty( $arrCustomFieldValue ) ){	
		$tour_customfield_id = $clsTaTourDestination->getMaxId();
		foreach( $arrCustomFieldValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_customfield_id'] = $tour_customfield_id++;
			$value['tour_id'] = $taTourID;		
			$arrCustomField[] = '('.implode(',',$value).')';
		}
		$strCustomFieldValue = implode(',',$arrCustomField);
		$sqlColumn = "INSERT INTO $clsTaTourCustomField->tbl ($strField) VALUES $strCustomFieldValue";		
		$dbconn->Execute($sqlColumn);
	}
	#copy TourPriceVal
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourPriceVal->tbl");
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrTourPriceValValue = $dbconn->getAll("SELECT * FROM $clsTourPriceVal->tbl WHERE tour_id=$tour_id");
	$arrTourPriceVal = array();
	if( !empty( $arrTourPriceValValue ) ){
		$tour_price_val_id = $clsTaTourPriceVal->getMaxId();
		foreach( $arrTourPriceValValue as $key=>$value ){
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_price_val_id'] = $tour_price_val_id++;
			$value['tour_id'] = $taTourID;		
			$arrTourPriceVal[] = '('.implode(',',$value).')';
		}
		$strTourPriceValValue = implode(',',$arrTourPriceVal);
		$sqlColumn = "INSERT INTO $clsTaTourPriceVal->tbl ($strField) VALUES $strTourPriceValValue";
		$dbconn->Execute($sqlColumn);
	}	
	#copy clsTourImage
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourImage->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrTourImageValue = $dbconn->getAll("SELECT * from $clsTourImage->tbl WHERE is_trash=0 and table_id=$tour_id");
	$arrTourImage = array();
	if( !empty( $arrTourImageValue ) ){	
		$tour_image_id = $clsTaTourImage->getMaxId();
		foreach( $arrTourImageValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_image_id'] = $tour_image_id++;
			$value['table_id'] = $taTourID;		
			$arrTourImage[] = '('.implode(',',$value).')';
		}
		$strTourImage = implode(',',$arrTourImage);
		$sqlColumn = "INSERT INTO $clsTaTourImage->tbl ($strField) VALUES $strTourImage";
		$dbconn->Execute($sqlColumn);
	}
	#
	#copy clsTourStartDate
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourStartDate->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrTourStartDateValue = $dbconn->getAll("SELECT * from $clsTourStartDate->tbl WHERE is_trash=0 and tour_id=$tour_id");
	$arrTourStartDate = array();
	if( !empty( $arrTourStartDateValue ) ){	
		$tour_start_date_id = $clsTaTourStartDate->getMaxId();
		foreach( $arrTourStartDateValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_start_date_id'] = $tour_start_date_id++;
			$value['tour_id'] = $taTourID;		
			$arrTourStartDate[] = '('.implode(',',$value).')';
		}
		$strTourStartDate = implode(',',$arrTourStartDate);
		$sqlColumn = "INSERT INTO $clsTaTourStartDate->tbl ($strField) VALUES $strTourStartDate";
		$dbconn->Execute($sqlColumn);
	}
	#copy TourPriceRow
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourPriceRow->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrTourPriceRowValue = $dbconn->getAll("SELECT * from $clsTourPriceRow->tbl WHERE is_trash=0 and tour_id=$tour_id");
	$arrTourPriceRow = array();
	if( !empty( $arrTourPriceRowValue ) ){	
		$tour_price_row_id = $clsTaTourPriceRow->getMaxId();
		foreach( $arrTourPriceRowValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_price_row_id'] = $tour_price_row_id++;
			$value['tour_id'] = $taTourID;		
			$arrTourPriceRow[] = '('.implode(',',$value).')';
		}
		$strTourPriceRow = implode(',',$arrTourPriceRow);
		$sqlColumn = "INSERT INTO $clsTaTourPriceRow->tbl ($strField) VALUES $strTourPriceRow";
		$dbconn->Execute($sqlColumn);
	}
	#copy TourPriceCol
	$allColumns = $dbconn->getAll("SHOW COLUMNS FROM $clsTaTourPriceCol->tbl");	
	$arrField = array();
	if( !empty( $allColumns ) ){
		foreach( $allColumns as $key=>$value ){
			$arrField[] = "`".$value['Field']."`";
		}
	}
	$strField = implode(',',$arrField);
	$arrTourPriceColValue = $dbconn->getAll("SELECT * from $clsTourPriceCol->tbl WHERE is_trash=0 and tour_id=$tour_id");
	$arrTourPriceCol = array();
	if( !empty( $arrTourPriceRowValue ) ){	
		$tour_price_col_id = $clsTaTourPriceCol->getMaxId();
		foreach( $arrTourPriceColValue as $key=>$value ){			
			foreach( $value as $ke=>$val ){
				 if(is_numeric($ke)){
					 unset($value[$ke]);
				 }else{
					 $val = addslashes($value[$ke]);
					 $value[$ke] = '"'.$val.'"';
				 }
			}
			$value['tour_price_col_id'] = $tour_price_col_id++;
			$value['tour_id'] = $taTourID;		
			$arrTourPriceCol[] = '('.implode(',',$value).')';
		}
		$strTourPriceCol = implode(',',$arrTourPriceCol);
		$sqlColumn = "INSERT INTO $clsTaTourPriceCol->tbl ($strField) VALUES $strTourPriceCol";
		$dbconn->Execute($sqlColumn);
	}
	return $taTourID;
}

function default_tour_details(){	
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;  
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;  
	$clsCity = new _City();
	$assign_list["clsCity"] = $clsCity; 
	$clsTaTourStore = new TaTourStore();
	$assign_list["clsTaTourStore"] = $clsTaTourStore; 
	$clsTour = new Tour();
	$assign_list["clsTour"] = $clsTour;	
	$clsTourPriceAgeType = new TourPriceAgeType();
	$clsTourPriceCustomerType = new TourPriceCustomerType();
	$clsTourPriceUnit = new TourPriceUnit();
	$clsTourStartDate = new TourStartDate();
	$clsTourProperty = new TourProperty(); $assign_list["clsTourProperty"] = $clsTourProperty;
	$clsTourPriceRow = new TourPriceRow(); $assign_list["clsTourPriceRow"] = $clsTourPriceRow;
	$clsTourPriceCol = new TourPriceCol(); $assign_list["clsTourPriceCol"] = $clsTourPriceCol;
	$clsTourPriceVal = new TourPriceVal(); $assign_list["clsTourPriceVal"] = $clsTourPriceVal;	
	#
	$tour_id = isset($_GET['tour_id'])? ($_GET['tour_id']) : '';
	$tour_id = intval($core->decryptID($tour_id));
	$agency = $clsProfile->getUserID();
	$oneTour = $clsTour->getOne($tour_id);
	#
	$dateNow = date('d-m-Y').' 23:59:59';
	$dateNow = strtotime($dateNow);
	$lstTourStartDate = $dbconn->getAll("select * from default_tour_start_date where tour_id='$tour_id' and start_date > '$dateNow' order by start_date asc");
	$arrDate = array();
	if( !empty( $lstTourStartDate ) ){
		foreach( $lstTourStartDate as $key=>$value ){
			$arrDate[] = date('j-n-Y',$value['start_date']);
		}
	}
	$assign_list["arrDate"] = json_encode($arrDate);
	$listAgenOfTour = $dbconn->getAll("SELECT tour.*,ts.tour_store_id,pv.type_promo,pv.promo_value_id,pv.promo_value_id,pv.val FROM default_tour as tour 
	LEFT JOIN ta_tour_store as ts ON ts.tour_id=tour.tour_id 
	LEFT JOIN ta_promo_value as pv on pv.promo_value_id= ts.promo_value_id WHERE ts.profile_id='$agency' and tour.tour_id='$tour_id'");	
	$oneTour = '';
	if( !empty( $listAgenOfTour ) ){
		$oneTour = $listAgenOfTour[0];
	}
	$assign_list["oneTour"] = $oneTour;
	$dbconn->getAll(""); 
	
	$listCoutry = $clsCountry->getAll("is_trash=0");
	$assign_list["listCoutry"] = $listCoutry; 
	
	$clsConfiguration = new Configuration(); 
	$assign_list["clsConfiguration"] = $clsConfiguration;
	$assign_list["PROMO_PERCENT"] = PROMO_PERCENT;
	$assign_list["PROMO_VALUE"] = PROMO_VALUE;
	#
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;	
	$listPromoValue = $clsPromoValue->getAll("is_trash=0");
	$assign_list["listPromoValue"] = $listPromoValue;
	#
	$agency = $clsProfile->getUserID();
	$title_page = 'Booking tour';
	$assign_list["title_page"] = $title_page;
}
function default_profile(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	$cssShow='member';
	$assign_list["cssShow"] = $cssShow;
	$assign_list["infoMember"] = $_GET;
	
	#
	$clsCountry=new Country(); $assign_list["clsCountry"] = $clsCountry;
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
    
	$agency = $clsProfile->getUserID();
	if( empty( $agency ) && isset($_SESSION["profile_id_db"]) ){
		$agency = $_SESSION["profile_id_db"];
	}
    if($agency==0) header('location: /sign-in.html');
	
	$assign_list["profile_id"] = $agency;
	
	$oneProfile=$clsProfile->getOne($agency);
	$assign_list["oneProfile"] = $oneProfile;
	
	$lstCountry=$clsCountry->getAll("is_trash=0 order by order_no asc");
	$assign_list["lstCountry"] = $lstCountry;
	//
	$title_page = 'Register member account of Vietnamtourism.org.vn';
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
}
function default_agency_order(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsConfiguration;	
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;  
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;  
	$clsCity = new _City();
	$assign_list["clsCity"] = $clsCity; 
	$clsTaTourStore = new TaTourStore();
	$assign_list["clsTaTourStore"] = $clsTaTourStore; 
	$clsTour = new Tour();
	$assign_list["clsTour"] = $clsTour; 
	$clsTaTour = new TaTour();
	$assign_list["clsTaTour"] = $clsTaTour; 
	$clsTaBooking = new TaBooking();
	$clsTaBookingDetail = new TaBookingDetail();
	$assign_list["get"] = $_GET; 
	if($clsConfiguration->getValue('SiteHasCat_Tours')){
		$clsTourCat = new TourCategory(); $assign_list["clsTourCat"] = $clsTourCat;
		$cat_id=isset($_GET['cat_id'])?intval($_GET['cat_id']):0;
	}
	#
	$agency = $clsProfile->getUserID();
	if( empty( $agency ) ){
		header('location:'.PCMS_URL.'profile/sign-in.html');	  
	}
	$oneProfile = $clsProfile->getOne($agency);
	$assign_list["oneProfile"] = $oneProfile;
	
	$cond.=" b.is_trash=0 and b.profile_id='$agency' ";
	
	if(intval($_GET['cat_id']) > 0){
		$cat_id = $_GET['cat_id'];
		$cond.=" and (tour.cat_id = '$cat_id' or tour.list_cat_id like '%|$cat_id|%') ";		
	}		
	$purchaser = $_GET['purchaser'];
	if(isset($purchaser) && !empty($purchaser) ){
		$purchaser = $core->replaceSpace($purchaser);
		$cond.=" and bd.purchaser_lug like '%$purchaser%' ";
	}
	$depart_start = $_GET['depart_start'];
	if(isset($depart_start) && !empty($depart_start) ){
		$start_date = str_replace('/','-',$depart_start).' 00:00:00';
		$start_date = strtotime($start_date);
		$cond.=" and bd.start_date >= '$start_date' ";
	}
	$depart_end = $_GET['depart_end'];
	if(isset($depart_end) && !empty($depart_end) ){
		$depart_end = str_replace('/','-',$depart_end).' 23:59:59';
		$depart_end = strtotime($depart_end);
		$cond.=" and bd.start_date <= '$depart_end' ";
	}
	$cond.=" GROUP BY b.booking_id ORDER BY bd.start_date DESC";	
	$lstBooking = $dbconn->getAll("SELECT bd.*,b.booking_code,b.*,sum(bd.adult) as adult,sum(bd.infant) as infant,
	sum(bd.children) as children,count(bd.book_detail_id) as totalDetails FROM ta_booking as b 
	RIGHT JOIN ta_booking_details as bd ON bd.booking_id = b.booking_id 
	LEFT JOIN default_ta_tour as tour ON tour.tour_id = bd.tour_id
	WHERE ".$cond);
	$assign_list["lstBooking"] = $lstBooking;
	$title_page = 'Booking of you';
}
function default_agency_booking_details(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;	
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;  
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;  
	$clsCity = new _City();
	$assign_list["clsCity"] = $clsCity; 
	$clsTaTourStore = new TaTourStore();
	$assign_list["clsTaTourStore"] = $clsTaTourStore; 
	$clsTaBooking = new TaBooking();
	$assign_list["clsTaBooking"] = $clsTaBooking; 
	$clsTaBookingDetail = new TaBookingDetail();
	$clsTaTour = new TaTour();
	$assign_list["clsTaTour"] = $clsTaTour;
	#
	$booking_id = isset($_GET['booking_id'])? ($_GET['booking_id']) : '';
	$booking_id = intval($core->decryptID($booking_id));	
	$oneBooking = $clsTaBooking->getOne($booking_id);
	$assign_list["oneBooking"] = $oneBooking;
	$agency = $clsProfile->getUserID();
	if( empty( $agency ) ){
		header('location:'.PCMS_URL.'profile/sign-in.html');	  
	}
	$oneProfile = $clsProfile->getOne($agency);
	$assign_list["oneProfile"] = $oneProfile;
	$lstBooking = $dbconn->getAll("SELECT b.*,bd.* FROM ta_booking as b RIGHT JOIN ta_booking_details as bd ON bd.booking_id = b.booking_id WHERE b.is_trash=0 and b.booking_id='$booking_id' and bd.parent_book_detail_id ='0'");
	if( !empty($lstBooking) ){
		foreach( $lstBooking as $key=>$value ){
			$book_detail_id = $value['book_detail_id'];
			$oneChoice = $dbconn->getAll("SELECT b.*,bd.* FROM ta_booking as b RIGHT JOIN ta_booking_details as bd ON bd.booking_id = b.booking_id WHERE b.is_trash=0 and b.booking_id='$booking_id' and bd.parent_book_detail_id ='$book_detail_id' OR bd.book_detail_id='$book_detail_id' ORDER BY bd.upd_date DESC limit 1");			
			if( !empty($oneChoice) ){
				$lstBooking[$key] = $oneChoice[0];
			}
		}
	}
	$assign_list["lstBooking"] = $lstBooking;
	$title_page = 'Booking details';	
}
function default_ajAddOrder(){
	$aryData = array("ok"=>true,'message'=>'','error'=>'','result'=>'');
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;	
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;  
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;  
	$clsCity = new _City();
	$assign_list["clsCity"] = $clsCity; 
	$clsTaTourStore = new TaTourStore();
	$assign_list["clsTaTourStore"] = $clsTaTourStore; 
	$clsTaBooking = new TaBooking();
	$assign_list["clsTaBooking"] = $clsTaBooking; 
	$clsTaBookingDetail = new TaBookingDetail();
	$clsTaTour = new TaTour();
	$assign_list["clsTaTour"] = $clsTaTour;
	#
	$booking_id = isset($_POST['booking_id'])? ($_POST['booking_id']) : '';
	$booking_id = intval($core->decryptID($booking_id));	
	if( $clsTaBooking->updateOne( $booking_id,"create_invoice='".addslashes(CREATED_INVOICE)."'" )){
		$aryData['message'] = 'Created order successfully';
	}else{
		$aryData['error'] = 'Create order failed';
		$aryData['ok'] = false;
	}
	echo json_encode($aryData);die();
}


function default_ajUpdateChoiceBooking(){
	$aryData = array('ok'=>true,'message'=>'','error'=>'','result'=>'');
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	$clsTaBookingDetail = new TaBookingDetail();	
	$book_detail_id = isset($_POST['book_detail_id'])? ($_POST['book_detail_id']) : '';
	$book_detail_id = intval($core->decryptID($book_detail_id));
	if( $clsTaBookingDetail->updateOne($book_detail_id,"default_choice='".$_POST['default_choice']."',upd_date='".time()."'") ){
		$aryData['message'] = "Update choice default successfully";
	}else{
		$aryData['message'] = "Update choice default error";
		$aryData['ok'] = false;
	}
	echo json_encode($aryData);
}
function default_agency_booking_edit(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;	
	$clsProfile = new Profile(); $assign_list["clsProfile"] = $clsProfile;
	$clsPromoValue = new PromoValue();
	$assign_list["clsPromoValue"] = $clsPromoValue;
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;  
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;  
	$clsCity = new _City();
	$assign_list["clsCity"] = $clsCity; 
	$clsTaTourStore = new TaTourStore();
	$assign_list["clsTaTourStore"] = $clsTaTourStore; 
	$clsTaBooking = new TaBooking();
	$assign_list["clsTaBooking"] = $clsTaBooking; 
	$clsTaBookingDetail = new TaBookingDetail();
	$clsTaTour = new TaTour();
	$assign_list["clsTaTour"] = $clsTaTour;	
	$assign_list["gets"] = $_GET;	
	#
	$book_detail_id = isset($_GET['book_detail_id'])? ($_GET['book_detail_id']) : '';
	$book_detail_id = intval($core->decryptID($book_detail_id));
	$oneBookingDetails = $clsTaBookingDetail->getOne($book_detail_id);
	if( empty( $oneBookingDetails['parent_book_detail_id'] ) ){
		$listAllDetails = $clsTaBookingDetail->getAll("is_trash=0 and book_detail_id='$book_detail_id' OR parent_book_detail_id='$book_detail_id' ORDER BY reg_date DESC ");
	}else{
		$listAllDetails = $clsTaBookingDetail->getAll("is_trash=0 and book_detail_id='".$oneBookingDetails['parent_book_detail_id']."' OR parent_book_detail_id='".$oneBookingDetails['parent_book_detail_id']."' ORDER BY reg_date DESC ");
	}
	$assign_list["listAllDetails"] = $listAllDetails;	
	if( isset($_POST['data']) ){
		$start_date = $_POST['data'][$book_detail_id]['start_date'];
			$oneBookingDetail = $clsTaBookingDetail->getOne($book_detail_id);
			$tour_id = $oneBookingDetail['tour_id'];
			$start_date = str_replace("/", "-", $start_date);
			$endDate = strtotime($start_date.' 23:59:59');
			$start_date = strtotime($start_date.' 00:00:00');
			$lstVisitorType = $dbconn->getAll("SELECT * FROM default_tour_property WHERE is_trash=0 and type='VISITORTYPE' and lang_id='en' order by order_no asc");
			$lstTourStartDate = $dbconn->getAll("SELECT * FROM default_ta_tour_start_date WHERE tour_id='$tour_id' and start_date >= '$start_date' and start_date <= '$endDate' order by start_date asc");
			$arrTourCard = array();		
			$arrPrice = array(ADULT=>0,CHILDREN=>0,INFANT=>0);
			foreach( $lstTourStartDate as $key=>$value ){		
				foreach( $lstVisitorType as $k=>$v ){					
					$price = getTaTripPrice($v['tour_property_id'],$value['start_date'],$tour_id);								
					$arrPrice[$v['tour_property_id']] = $price;			
				}
			}				
			//Perform Duplicate tour, create order details
			$total = 0;
			$price_adult = $arrPrice[ADULT];
			$price_children = $arrPrice[CHILDREN];
			$price_infant = $arrPrice[INFANT];
			$quanlity_adult = intval($_POST['data'][$book_detail_id]['adult']);
			$quanlity_children = intval($_POST['data'][$book_detail_id]['children']);
			$quanlity_infant = intval($_POST['data'][$book_detail_id]['infant']);
			$type_promo = $oneBookingDetail['type_promo'];
			$val = $oneBookingDetail['val'];
			$total = intval(($price_adult*$quanlity_adult)+($price_children*$quanlity_children)+($price_infant*$quanlity_infant));
			#
			if($oneTour['type_promo'] == PROMO_VALUE){
				$total = $total - $val;
				$dis_count = $val;
			}
			if($oneTour['type_promo'] == PROMO_PERCENT){	
				$dis_count = $total*$val/100;		
				$total = $total - $total*$val/100;				
			}
			$start_date = str_replace('/','-',$_POST['data'][$book_detail_id]['start_date']);
			$book_detail_id_new = $clsTaBookingDetail->getMaxId();
			if( empty($oneBookingDetail['parent_book_detail_id']) ){
				$parent_book_detail_id = $oneBookingDetail['book_detail_id'];
			}else{
				$parent_book_detail_id = $oneBookingDetail['parent_book_detail_id'];
			}
			$fieldDetails = 'profile_id,adult,children,infant,start_date,trip_price,
			dis_count,val,type_promo,total,purchaser';
			$vBookDetail = "profile_id='".addslashes($agency)."'			
			,adult='".addslashes($_POST['data'][$book_detail_id]['adult'])."'
			,children='".addslashes($_POST['data'][$book_detail_id]['children'])."'
			,infant='".addslashes($_POST['data'][$book_detail_id]['infant'])."'
			,start_date='".addslashes(strtotime($start_date))."'
			,trip_price='".addslashes($total)."'
			,dis_count='".addslashes($dis_count)."'
			,val='".addslashes($val)."'
			,type_promo='".addslashes($type_promo)."'
			,total='".addslashes($total)."'
			,purchaser='".addslashes($_POST['data'][$book_detail_id]['purchaser'])."'";
			$clsTaBookingDetail->updateOne( $book_detail_id,$vBookDetail );
		//code bellow manager version
		/*
		$oneBookingDetail = $clsTaBookingDetail->getOne($book_detail_id);
		$assign_list["oneBookingDetail"] = $oneBookingDetail;
		$tour_id = $oneBookingDetail['tour_id'];
		$oneBooking = $clsTaBooking->getOne($oneBookingDetail['booking_id']);
		$assign_list["oneBooking"] = $oneBooking;
		$agency = $clsProfile->getUserID();
		$booking_id = $oneBookingDetail['booking_id'];
		$exitsSame = false;
		foreach( $_POST['data'] as $book_detail_id=>$val ){			
			foreach( $val as $key=>$value ){
				$vowels = array(".", ",", "'", "", "{", "}", "", "", "=", "?");
				$value = str_replace($vowels, "", $value);
				if( $key =='start_date' ){
					if( strcmp(date('d/m/Y',$oneBookingDetail[$key]), $value) !== 0 ){
					$exitsSame = true; break;
					}
				}
				else{
					if(strcmp($oneBookingDetail[$key], $value) !== 0) {
						$exitsSame = true; break;
					}	
				}
			}
		}
		if( $exitsSame ){		
			$start_date = $_POST['data'][$book_detail_id]['start_date'];			
			$start_date = str_replace("/", "-", $start_date);
			$endDate = strtotime($start_date.' 23:59:59');
			$start_date = strtotime($start_date.' 00:00:00');
			$lstVisitorType = $dbconn->getAll("SELECT * FROM default_tour_property WHERE is_trash=0 and type='VISITORTYPE' and lang_id='en' order by order_no asc");
			$lstTourStartDate = $dbconn->getAll("SELECT * FROM default_ta_tour_start_date WHERE tour_id='$tour_id' and start_date >= '$start_date' and start_date <= '$endDate' order by start_date asc");
			$arrTourCard = array();		
			$arrPrice = array(ADULT=>0,CHILDREN=>0,INFANT=>0);
			foreach( $lstTourStartDate as $key=>$value ){		
				foreach( $lstVisitorType as $k=>$v ){					
					$price = getTaTripPrice($v['tour_property_id'],$value['start_date'],$tour_id);								
					$arrPrice[$v['tour_property_id']] = $price;			
				}
			}
			//Perform Duplicate tour, create order details			
			$tour_duplicatID = default_dulicate_tour_from_ta($tour_id,$agency);
			$total = 0;
			$price_adult = $arrPrice[ADULT];
			$price_children = $arrPrice[CHILDREN];
			$price_infant = $arrPrice[INFANT];
			$quanlity_adult = intval($_POST['data'][$book_detail_id]['adult']);
			$quanlity_children = intval($_POST['data'][$book_detail_id]['children']);
			$quanlity_infant = intval($_POST['data'][$book_detail_id]['infant']);
			$type_promo = $oneBookingDetail['type_promo'];
			$val = $oneBookingDetail['val'];
			$total = intval(($price_adult*$quanlity_adult)+($price_children*$quanlity_children)+($price_infant*$quanlity_infant));
			#
			if($oneTour['type_promo'] == PROMO_VALUE){
				$total = $total - $val;
				$dis_count = $val;
			}
			if($oneTour['type_promo'] == PROMO_PERCENT){	
				$dis_count = $total*$val/100;		
				$total = $total - $total*$val/100;				
			}
			$start_date = str_replace('/','-',$_POST['data'][$book_detail_id]['start_date']);
			$book_detail_id_new = $clsTaBookingDetail->getMaxId();
			if( empty($oneBookingDetail['parent_book_detail_id']) ){
				$parent_book_detail_id = $oneBookingDetail['book_detail_id'];
			}else{
				$parent_book_detail_id = $oneBookingDetail['parent_book_detail_id'];
			}
			$fieldDetails = 'book_detail_id,parent_book_detail_id,booking_id,profile_id,tour_id,adult,children,infant,reg_date,start_date,trip_price,
			dis_count,val,type_promo,total,purchaser';
			$vBookDetail = "'$book_detail_id_new'
			,'".addslashes($parent_book_detail_id)."'
			,'".addslashes($booking_id)."'			
			,'".addslashes($agency)."'
			,'".addslashes($tour_duplicatID)."'
			,'".addslashes($_POST['data'][$book_detail_id]['adult'])."'
			,'".addslashes($_POST['data'][$book_detail_id]['children'])."'
			,'".addslashes($_POST['data'][$book_detail_id]['infant'])."'
			,'".time()."'
			,'".addslashes(strtotime($start_date))."'
			,'".addslashes($total)."'
			,'".addslashes($dis_count)."'
			,'".addslashes($val)."'
			,'".addslashes($type_promo)."'
			,'".addslashes($total)."'
			,'".addslashes($_POST['data'][$book_detail_id]['purchaser'])."'";
			$clsTaBookingDetail->insertOne( $fieldDetails,$vBookDetail );
		}	
		*/		
	}
	$oneBookingDetail = $clsTaBookingDetail->getOne($book_detail_id);
	$assign_list["oneBookingDetail"] = $oneBookingDetail;
	$tour_id = $oneBookingDetail['tour_id'];
	$oneBooking = $clsTaBooking->getOne($oneBookingDetail['booking_id']);
	$assign_list["oneBooking"] = $oneBooking;
	$agency = $clsProfile->getUserID();
	if( empty( $agency ) ){
		header('location:'.PCMS_URL.'profile/sign-in.html');
	}
	$oneProfile = $clsProfile->getOne($agency);
	$assign_list["oneProfile"] = $oneProfile;
	
	$dateNow = date('d-m-Y').' 23:59:59';
	$dateNow = strtotime($dateNow);
	$arrDateTour = array();
			
	$lstTourStartDate = $dbconn->getAll("select * from default_ta_tour_start_date where tour_id='$tour_id' and start_date > '$dateNow' order by start_date asc");
	$arrDate = array();
	if( !empty( $lstTourStartDate ) ){
		foreach( $lstTourStartDate as $k=>$val ){
			$arrDate[] = date('j-n-Y',$val['start_date']);
		}
	}
	$arrDateTour = $arrDate;			
	$assign_list["arrDateTour"] = json_encode($arrDateTour);
	$title_page = 'Booking edit';
	$oneBookingDetails = $clsTaBookingDetail->getOne($book_detail_id);
	if( empty( $oneBookingDetails['parent_book_detail_id'] ) ){
		$listAllDetails = $clsTaBookingDetail->getAll("is_trash=0 and book_detail_id='$book_detail_id' OR parent_book_detail_id='$book_detail_id'");
	}else{
		$listAllDetails = $clsTaBookingDetail->getAll("is_trash=0 and book_detail_id='".$oneBookingDetails['parent_book_detail_id']."' OR parent_book_detail_id='".$oneBookingDetails['parent_book_detail_id']."'");
	}
	$assign_list["listAllDetails"] = $listAllDetails;
}

function default_signup(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;		
	
	$clsProfile = new Profile();
	$assign_list["html_captcha"] = $clsProfile->generateHtmlSpam();
	
	$assign_list["msgSubmitForm"] = $msgSubmitForm;
	
	
	$title_page = 'Register member account of Vietnamtourism.org.vn';
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
}
function default_registerCustomer(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	#
	$clsProfile = new Profile();
	$arrData = array('ok'=>true,'message'=>'','error'=>'','result'=>'');
	$msgSubmitForm = '';
	if(isset($_POST['hid_reg']) && $_POST['hid_reg']== 'hid_reg'){
		if($clsProfile->checkValidEmail($_POST['useremail'])!=1){
			$msgSubmitForm .= 'Email format is incorrect!';
			$arrData['ok'] = false;
			$arrData['error'] = $msgSubmitForm;
		}
		if($_POST['username']==''){
			$msgSubmitForm .= 'Username is request!';
			$arrData['ok'] = false;
			$arrData['error'] = $msgSubmitForm;
		}
		if($_POST['userpass']==''){
			$msgSubmitForm .= 'Password is request!';
			$arrData['ok'] = false;
			$arrData['error'] = $msgSubmitForm;
		}
		if($_POST['confirmpass']==''){
			$msgSubmitForm .= 'Unknown password confirmation!';
			$arrData['ok'] = false;
			$arrData['error'] = $msgSubmitForm;
		}
		if($_POST['userpass']!=$_POST['confirmpass']){
			$msgSubmitForm .= 'Confirm password do not match!';
			$arrData['ok'] = false;
			$arrData['error'] = $msgSubmitForm;
		}
		if($clsProfile->checkValidUsername($_POST['username'])==1){
			$msgSubmitForm .= 'Username already exists. Please choose another name!';
			$arrData['ok'] = false;
			$arrData['error'] = $msgSubmitForm;
		}
		if ($_SESSION['skey']!=strtoupper(addslashes($_POST['security_code']))){
			$msgSubmitForm .= '5 characters entered incorrectly. Please re-enter!';
			$arrData['ok'] = false;
			$arrData['error'] = $msgSubmitForm;
		}				
		if($_POST['tccheck']!='1'){
			$msgSubmitForm .= 'Please read and accept the terms of Cietnamtourism.org.vn!';
			$arrData['ok'] = false;
			$arrData['error'] = $msgSubmitForm;
		}
		foreach($_POST as $key=>$val){
			$assign_list[$key] = $val;
		}		
		if($msgSubmitForm==''){
			$f = "email,username,userpass,ip_register,reg_date";
			$v = "'".addslashes($_POST['useremail'])."'";
			$v .= ",'".addslashes($_POST['username'])."'";
			$userpass = $clsProfile->encryptPass($_POST['userpass']);			
			$v .= ",'".addslashes($userpass)."'";
			$v .= ",'".$_SERVER['REMOTE_ADDR']."'";
			$v .= ",'".time()."'";
			
			if($clsProfile->insertOne($f,$v)){
				$clsProfile->userLoggedIn($_POST['useremail'],$_POST['userpass']);
				$email = addslashes($_POST['useremail']);
				$one=$clsProfile->getAll("is_trash=1 and email='$email' order by profile_id desc limit 0,1");
				//$clsProfile->sendEMailRegisterSuccess($one[0]['profile_id']);
				//header('location: '.PCMS_URL.'profile/register-success.html');
				$arrData['message'] = 'Register successfully!';
			}
			else{
				$msgSubmitForm .= '&bull; Suspension of registration system to upgrade!<br>';
			}
		}
	}
	echo json_encode($arrData);die();
}
function default_AjaxSignin(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	$clsProfile = new Profile();
	#
	$aryData = array('ok'=>true,'error'=>'','message'=>'','result'=>'','linkReload'=>'');		
	if(isset($_POST['hidsignin']) && $_POST['hidsignin']== 'hidsignin'){
		if($clsProfile->userLoggedIn($_POST['USER'],$_POST['PASSWORD'])){			
			$aryData['linkReload'] = PCMS_URL.'agents/index.html';	
			$aryData['message'] = 'Login successfully';
		}
		else{
			$aryData['error'] = 'Login your failed!. Incorrect email or password!';
			$aryData['ok'] = false;
		}		
	}	
	echo json_encode($aryData);die();
	#Login via
	$oauth_provider=$_GET['oauth_provider'];
	
	if($oauth_provider == 'yahoo'){
		header('location:'.PCMS_URL.'?mod=login&act=yahoo');
	}	
	if($oauth_provider == 'facebook'){
		header('location:'.PCMS_URL.'?mod=login&act=facebook');
	}
	if ($oauth_provider == 'google') {
    	header('location:'.PCMS_URL.'?mod=login&act=google');
    }
	#
	$title_page = 'Sign in '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
	
}

function default_signin(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	$clsProfile = new Profile();
	#
	$agency = $clsProfile->getUserID();
	if( !empty( $agency ) ){
		header('location:'.PCMS_URL.'profile/my-profile.html');	  
	}	
	$msgSubmitForm = '';
	$rest = $_GET['rest'];
	if(isset($_POST['hidsignin']) && $_POST['hidsignin']== 'hidsignin'){	
	
		if($clsProfile->userLoggedIn($_POST['USER'],$_POST['PASSWORD'])){			
			if($rest!=''){
				$link=base64_decode($rest);
				header('location:'.PCMS_URL.'profile/my-profile.html');
			}else{
				header('location:'.PCMS_URL.'profile/my-profile.html');
			}		
		}
		else{			
			$msgSubmitForm .= 'Login failed!<br>';
		}
		foreach($_POST as $key=>$val){
			$assign_list[$key] = $val;
		}
	}
	$assign_list["msgSubmitForm"] = $msgSubmitForm;
	#Login via
	$oauth_provider=$_GET['oauth_provider'];
	
	if($oauth_provider == 'yahoo'){
		header('location:'.PCMS_URL.'?mod=login&act=yahoo');
	}	
	if($oauth_provider == 'facebook'){
		header('location:'.PCMS_URL.'?mod=login&act=facebook');
	}
	if ($oauth_provider == 'google') {
    	header('location:'.PCMS_URL.'?mod=login&act=google');
    }
	#
	$title_page = 'Sign in '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
}
function default_signinBy(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	#
	require_once(DIR_MODULES.'/member/classes/TwitterOAuth.php');
	require_once(DIR_MODULES.'/member/classes/facebook.php');
	require_once(DIR_MODULES.'/member/classes/fbconfig.php');
	$oauth_provider = $_GET['oauth_provider'];
	if ($oauth_provider == 'twitter'){
			header("location:https://twitter.com/oauth/authenticate?oauth_token=2L8NCMlPiivw4fkIfF2feWkj5EqH5UvZzvFfqK50Cc");
		}else if ($oauth_provider == 'facebook'){
			header("location: login-facebook.php");
	}
	#
}
function default_logout(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	global $facebook;
	$clsProfile = new Profile();	
	#
	if($clsProfile->getOneField('oauth_provider',$agency)=='_FACEBOOK'){
		session_destroy();
		unset($_SESSION['userdata']);
	}
	else if($clsProfile->getOneField('oauth_provider',$agency)=='_GOOGLE'){
		unset($_SESSION['token']);
		//Google session data unset
		unset($_SESSION['google_data']);
		session_destroy();
	}
	#
	$clsProfile->userDoLogout();
	header('location: '.PCMS_URL.'agents/index.html');
}
function dmY2mdY($str) {
    $arr = explode('/', $str);
    return $arr[1]."/".$arr['0']."/".$arr[2];
}
function default_my_setting(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	#
	$cssShow='member';
	$assign_list["cssShow"] = $cssShow;
	#
	$clsCountry=new Country();
	$assign_list["clsCountry"] = $clsCountry;
	
	$lstCountry=$clsCountry->getAll("is_trash=0 order by order_no asc");
	$assign_list["lstCountry"] = $lstCountry;
    #
    $clsProfile = new Profile();
	$assign_list["clsProfile"] = $clsProfile;
    $agency = $clsProfile->getUserID();
	if( empty( $agency ) && isset($_SESSION["profile_id_db"]) ){
		$agency = $_SESSION["profile_id_db"];
	}
	
	$message=$_GET['message'];
	$assign_list["message"] = $message;
	
	if($agency==0){
		header('location: /sign-in.html');
	}
    $oneProfile=$clsProfile->getOne($agency);
	$assign_list["oneProfile"] = $oneProfile;
	#
    if($_POST['Update']=='Profile') {
		$_POST['iso-_first_login'] = NOT_FIRST_LOGIN;
        $value = ""; $firstAdd = 0;       
    	foreach($_POST as $key=>$val){
    		$tmp = explode('-',$key);
    		if($tmp[0]=='iso'){
    			if($firstAdd==0){
    				$value .= $tmp[1]."='".addslashes($val)."'";
    				$firstAdd = 1;
    			}
    			else{
    				$value .= ",".$tmp[1]."='".addslashes($val)."'";
    			}
    		}
    	}
       if( $clsProfile->updateOne($agency,$value) ){
		   	$assign_list["msg"] = 'You are update successfully!';
			//header('location:'.PCMS_URL.'/account/setting-profile/success.html');	  
	   }else{
			die('Error');  
	   }
    }
	//
	$title_page = 'Setting profile - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	
	
}

function default_change_pass(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	#
	$clsProfile = new Profile();		
	$cssShow='member';
	$assign_list["cssShow"] = $cssShow;
	$clsCountry=new Country(); $assign_list["clsCountry"] = $clsCountry;
	#
    $assign_list["clsProfile"] = $clsProfile;
    $agency = $clsProfile->getUserID();
	if( empty( $agency ) && isset($_SESSION["profile_id_db"]) ){
		$agency = $_SESSION["profile_id_db"];
	}
	$assign_list["profile_id"] = $agency;
	
	$oneProfile=$clsProfile->getOne($agency);
	$assign_list["oneProfile"] = $oneProfile;
	
	$lstCountry=$clsCountry->getAll("is_trash=0 order by order_no asc");
	$assign_list["lstCountry"] = $lstCountry;
	
    
	$message=$_GET['message'];
	$assign_list["message"] = $message;
	
	if($agency==0){
		header('location: /sign-in.html');
	}
    $oneProfile=$clsProfile->getOne($agency);
	$assign_list["oneProfile"] = $oneProfile;
	#
    if($_POST['Update']=='ChangePass') {
        
		$msg=array();
		$old_pass=$_POST['old_pass'];
		$pass2=$_POST['pass2'];
		$pass3=$_POST['pass3'];
		
		if(!$clsProfile->checkPass($old_pass,$oneProfile['userpass'])){
			$msg[]='Current password not match';
		}
		
		if($pass2!=$pass3){
			$msg[]='Password and Retype password not match';
		}
		if(strlen($pass2)<6){
			$msg[]='The passwords Minimum must have 6 characters';
		}
		if($old_pass=='' || $pass2=='' || $pass3==''){
			$msg[]='Required field not empty';
		}		
		if( empty($msg) ){
			$value = "userpass='".$clsProfile->encryptPass(addslashes($_POST['pass2']))."'";
			if($clsProfile->updateOne($agency,$value)){
				//header('location:'.PCMS_URL.'/account/sign-in.html');
				$assign_list["message"] = 'Change password successfully';	
			}else{
				$assign_list["msg"] = 'Change password error';	
				//header('location:'.PCMS_URL.'/account/change-password/error.html');
			}
			
		}
    }
	$assign_list["msg"] = $msg;	
	#
	$title_page = 'Change Password - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
}
function default_my_profile(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	$clsProfile = new Profile();
	$clsCountry = new _Country();
	$clsCity = new City();
	$assign_list["clsCountry"] = $clsCountry;
	$assign_list["clsCity"] = $clsCity;
	$agency = '';	
	$message = '';
	if( isset( $_SESSION['profile_id'] ) ){
		$agency = $_SESSION['profile_id'];
	}else{
		header('location: /sign-in.html');
	}
	$lstCountry = $clsCountry->getAll("is_trash=0");
	$assign_list["lstCountry"] = $lstCountry;
	$lstCity = $clsCity->getAll("is_trash=0 and country_id='1'");
	$assign_list["lstCity"] = $lstCity;
	
	$assign_list["message"] = $message;
	$assign_list["profile_id"] = $agency;
	$oneProfile = $clsProfile->getOne($agency);
	$assign_list["oneProfile"] = $oneProfile;
	$title_page = $oneProfile['email'];
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
}
function default_change_avatar(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	#
	$cssShow='member';
	$assign_list["cssShow"] = $cssShow;
	#
    $clsProfile = new Profile();$assign_list["clsProfile"] = $clsProfile;
    $agency = $clsProfile->getUserID();
    if( empty( $agency ) && isset($_SESSION["profile_id_db"]) ){
		$agency = $_SESSION["profile_id_db"];
	}
	$message=$_GET['message'];
	$assign_list["message"] = $message;
	
	if($agency==0){
		header('location: /sign-in.html');
	}
    $oneProfile=$clsProfile->getOne($agency);
	$assign_list["oneProfile"] = $oneProfile;
	#
    if($_POST['Update']=='ChangeAvata') {
        
		$msg='';
		$up = '';
		
		$name=$_FILES['avatar']['name'];
		$type=$_FILES['avatar']['type'];
		$size=$_FILES['avatar']['size'];
		
		if($name==''){
			$msg.='&bull; File upload not empty !<br />';
		}
		if($size>2097152){
			$msg.='&bull; File upload limit 2MB <br />';
		}
		if(!in_array($type,array('image/jpeg','image/png','image/gif'))){
			$msg.='&bull; File upload required format:.jpg,.gif,.png';
		}
		
		if($msg===''){
			if(is_uploaded_file($_FILES['avatar']['tmp_name'])){
				$clsUploadFile = new UploadFile();
				$up = $clsUploadFile->uploadItem($_FILES["avatar"],"/avatar","jpg,gif,png");
			}
			if($up!=''&&$up!='0'){
				$value = "avatar='".addslashes($up)."'";
			}
			if($clsProfile->updateOne($agency,$value)){
				$assign_list["messages"] = 'You are update avatar successfully!';
				//header('location:'.PCMS_URL.'/account/change-avatar/success.html');
			}else{
				header('location:'.PCMS_URL.'/account/change-avatar.html');
			}
		}	
    }
	$assign_list["msg"] = $msg;
	#
	$title_page = 'Change avatar - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
}
function default_signinpost(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	$arrData = array('ok'=>true,'message'=>'','error'=>'','result'=>'','urlLoad'=>'');	
	$clsProfile = new Profile();
	#
	$msgSubmitForm = '';
	$rest = $_GET['rest'];
	if(!$clsProfile->userLoggedIn($_POST['USER'],$_POST['PASSWORD'])){
		$arrData['ok'] = false;
		$arrData['error'] = 'Username or password your incorrect!';
	}else{
		$arrData['urlLoad'] = PCMS_URL;
	}		
	$assign_list["msgSubmitForm"] = $msgSubmitForm;
	#Login via
	$oauth_provider=$_GET['oauth_provider'];
	if ($oauth_provider == 'google') {
    	header('location:'.PCMS_URL.'?mod=login&act=google');
    }elseif($oauth_provider == 'yahoo'){
		header('location:'.PCMS_URL.'?mod=login&act=yahoo');
	}
	#
	echo json_encode( $arrData );die();
	/*=============Content Page==================*/
}
function default_register(){	
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$agency;
	#
	$arrData = array('ok'=>true,'message'=>'','error'=>'','result'=>'','urlLoad'=>'');
	
	$clsProfile = new Profile();
	$assign_list["html_captcha"] = $clsProfile->generateHtmlSpam();
	$msgSubmitForm = '';
	
	if(isset($_POST['hid_reg']) && $_POST['hid_reg']== 'hid_reg'){
		
		if($clsProfile->checkValidEmail($_POST['useremail'])!=1){
			$msgSubmitForm .= '&bull; Email format is incorrect!<br>';
		}
		if($_POST['username']==''){
			$msgSubmitForm .= '&bull; Username is request!<br>';
		}
		if($_POST['userpass']==''){
			$msgSubmitForm .= '&bull; Password is request!<br>';
		}
		if($_POST['confirmpass']==''){
			$msgSubmitForm .= '&bull; Unknown password confirmation!<br>';
		}
		if($_POST['userpass']!=$_POST['confirmpass']){
			$msgSubmitForm .= '&bull; Confirm password do not match!<br>';
		}
		if($clsProfile->checkValidUsername($_POST['username'])==1){
			$msgSubmitForm .= '&bull; Username already exists. Please choose another name!<br>';
		}
		//if ( $_SESSION['skey']!=strtoupper(addslashes($_POST['security_code']))){
			$msgSubmitForm .= '&bull; 5 characters entered incorrectly. Please re-enter!<br>';
		//}
		$email = $_POST['useremail'];
		$one = $clsProfile->getAll("is_trash=0 and email='$email' order by profile_id desc limit 0,1");
		if( isset( $one[0] ) ){
			$arrData['ok'] = false;
			$arrData['error'] = 'Email exits';
		}
		if($_POST['tccheck']!='1'){
			$msgSubmitForm .= '&bull; Please read and accept the terms of Cietnamtourism.org.vn!<br>';
		}
		foreach($_POST as $key=>$val){
			$assign_list[$key] = $val;
		}		

		if($msgSubmitForm==''){
			$f = "email,username,userpass,ip_register,reg_date";
			$v = "'".addslashes($_POST['useremail'])."'";
			$v .= ",'".addslashes($_POST['username'])."'";
			$userpass = $clsProfile->encrypt($_POST['userpass']);
			$v .= ",'".addslashes($userpass)."'";
			$v .= ",'".$_SERVER['REMOTE_ADDR']."'";
			$v .= ",'".time()."'";
			if($clsProfile->insertOne($f,$v)){		
				$info = $clsProfile->userLoggedIn($_POST['useremail'],$_POST['userpass']);
				$email = addslashes($_POST['useremail']);
				$oneProfile = $clsProfile->getAll("is_trash=0 and email='$email' order by profile_id desc limit 0,1");
				$clsProfile->sendEMailRegisterSuccess($oneProfile[0]['profile_id']);				
				//header('location: '.PCMS_URL.'/account/register-success.html');
			}
			else{
				$msgSubmitForm .= '&bull; Suspension of registration system to upgrade!<br>';
			}
		}
	}
	$assign_list["msgSubmitForm"] = $msgSubmitForm;
	#
	$title_page = 'Register member account of Vietnamtourism.org.vn';
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
	echo json_encode( $arrData );die();
	/*=============Content Page==================*/
}
function default_checkAccountAJAX(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	global $facebook;
	require_once(DIR_INCLUDES."/oauth/facebook/facebook.php");
	#
	$clsProfile = new Profile();
	$clsISO = new ISO();
	$fbAT = isset($_POST['fbAT'])?$_POST['fbAT']:'';
	$facebook = new Facebook(array(
		'appId'  => appID,
		'secret' => AppSecret,
		'fileUpload' => false, 
		'allowSignedRequest' => false,
	));
	$fbUser = $facebook->getUser();
	$_success = false;
	if($fbUser){
		try{
			$user_profile = $facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture','GET');
			if($clsProfile->userLoggedInFacebook($user_profile)){
				$_success = true;
			}
		}catch(FacebookApiException $e){
			$fbuser = null;
			$fbLoginUrl = $facebook->getLoginUrl(array('redirect_uri'=>homeUrl,'scope'=>fbPermissions));
			echo 'Please <a href="' . $fbLoginUrl . '">Face.</a>';
			error_log($e->getType());
			error_log($e->getMessage());
			die();
		}   
	}
	#
	echo $_success; die();
}
function default_checkGoogleAccount(){
	global $core, $clsISO, $oneSetting, $_frontIsLoggedin_user_id;
	global $_lang, $extLang, $clsSetting;
	#
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$_id = isset($_POST['id']) ? $_POST['id'] : '';
	if($email=='' || $_id==''){
		echo '_invalid'; die();
	}
	#
	$clsProfile = new Profile();
	$userProfile = array(
		'id'			=> $_POST['id'],
		'email'			=> $_POST['email'],
		'full_name'		=> $_POST['full_name'],
		'avatar'		=> $_POST['avatar'],
		'family_name'	=> $_POST['family_name'],
		'given_name'	=> $_POST['given_name'],
		'gender'		=> $_POST['gender'],
		'verified_email'=> $_POST['verified_email'],
		'hd'			=> $_POST['hd'],
		'link'			=> $_POST['link']
	);
	#
	$_success = false;
	if($clsProfile->userLoggedInGoogle($userProfile)){
		$_SESSION['google_data'] = $userProfile;
		$_success = true;
	}
	#
	echo $_success; die();
}
function default_setTrackingLogin(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	$_tp = isset($_POST['_tp']) ? $_POST['_tp'] : '_FACEBOOK';
	$_return_url = isset($_POST['_return_url']) ? $_POST['_return_url'] : '/';
	vnSessionSetVar('_LOGIN', $_tp);
	$_SESSION['_return_url'] = $_return_url;
	#
	echo($_tp); die();
}
function default_createTicket(){
	require_once($_SERVER['DOCUMENT_ROOT'].'/inc/iso/class.upload.php');

	$aryData = array('ok'=>true,'message'=>'','error'=>'','result'=>'','waning'=>'');
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$dbconn;
	$user_id = $core->_USER['user_id'];	
	if( isset( $_SESSION["profile_id"] ) ){
		$agency_id = $_SESSION["profile_id"];
		
	}else{
		$agency_id =  $clsProfile->getUserID();					
	}	
	$postData = $_POST;
	$up = '';
	if(is_uploaded_file($_FILES["attachment"]['tmp_name'])){		
		$clsUploadFile = new UploadFile();
		$up = $clsUploadFile->uploadItem($_FILES["attachment"],"/avatar","jpg,pdf,csv,png");			
	}	
		
	$clsTaAgancyTicket = new TaAgancyTicket();
	$max_id = $clsTaAgancyTicket->getMaxID();
	$max_order_no = $clsTaAgancyTicket->getMaxOrderNo();
	$f = "tickit_id,agency_id,message,attachment,reg_date";
	$v = "'$max_id','$agency_id','".addslashes($postData['data']['message'])."','".addslashes($up)."','".time()."'";			
	if($clsTaAgancyTicket->insertOne($f,$v)) {
		$aryData['message'] = 'Create ticket success';	
	}else{
		$aryData['ok'] = false;
		$aryData['waning'] = 'Create ticket failed';			
	}
	echo json_encode($aryData);die();
}
function default_report(){
	$assign_list["arrYear"] = $arrYear;
	if( !isset($_GET['year']) ){			
		$_GET['year'] = date("Y");
	}
	if( !isset($_GET['month']) ){			
		$_GET['month'] = date("m");
	}
	$arrYear = array();
	for($i = intval(date("Y")); $i>=intval(date("Y")-100);$i--){
		$arrYear[]  = $i;
	}
	$assign_list["arrYear"] = $arrYear;	
	for( $i= 1;$i<=12;$i++ ){
		$arrMonth[] = $i;		
	}
	$assign_list["arrMonth"] = $arrMonth;
}
function default_ajOpenChangeAvatar(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$dbconn, $profile_id, $extLang;
	$clsProfile = new Profile();
	$upload_path = '/datastore/'.$core->replaceSpace($clsProfile->getUserName($profile_id));
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	#
	if($tp=='F'){
		$html = '<div class="atlas_pop signin anarrow">
		<div class="headPop">
			<h3>'.$core->get_Lang('Upload a Profile Image').'</h3>
			<a href="" class="closeEv close_pop" aria-hidden="true">x</a>
		</div>
		<div class="cleafix"></div>
		<div class="body page-bg round-bottom pal">
			<p>'.$core->get_Lang('Upload a profile image for your account. It should be square, preferably 125x125 pixels, and in JPEG, GIF, or PNG format.').'</p>
			<div id="fieldErrors" class="mhm"></div>
			<form id="useraccount_uploadImageForm" action="" method="post" enctype="multipart/form-data">
				<p>
					<label for="profileImage">'.$core->get_Lang('Enter file path').':</label>
					<input type="file" id="profileImage" name="profileImage">
				</p>
				<div class="line">
					<button type="submit" name="submit" title="'.$core->get_Lang('Submit').'"><span>'.$core->get_Lang('Submit').'</span></button>
				</div>
			</form>
		</div>';
		#
		echo $html;
		die();
	}
	else if($tp=='S'){
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$name=$_FILES['profileImage']['name'];
			$tmp_name=$_FILES['profileImage']['tmp_name'];
			$type=$_FILES['profileImage']['type'];
			$size=$_FILES['profileImage']['size'];
			#-Validate
			if(is_null($name)){
				echo '_invalid_empty';
				die();
			}
			if($size >= 2097152){
				echo '_invalid_size';
				die();
			}
			if(!in_array($type,array('image/jpeg','image/png','image/gif'))){
				echo '_invalid_type';
				die();
			}
			
			if(!class_exists('UploadFile')){ require_once(DIR_COMMON.'/class.upload.php'); }
			$up = '';
			if(is_uploaded_file($_FILES['profileImage']['tmp_name'])){
				$clsUploadFile = new UploadFile();
				$up = $clsUploadFile->uploadItem($_FILES["profileImage"],$upload_path,"jpg,gif,png");
			}
			if($up!=''&&$up!='0'){
				$value = "avatar='".addslashes($up)."'";
			}
			if($clsProfile->updateOne($profile_id,$value)){
				header('location:'.DOMAIN_NAME.$extLang.'/account/change-avatar/success.html');
			}else{
				header('location:'.DOMAIN_NAME.$extLang.'/account/change-avatar.html');
			}
			
			/*echo '0|||'.$up; die();*/
		}
	}
}


function default_change_avatar_old(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$profile_id;
	#
	require_once(DIR_COMMON.'/class.upload.php');
	
	$cssShow='member';
	$assign_list["cssShow"] = $cssShow;
	#
    $clsProfile = new Profile();$assign_list["clsProfile"] = $clsProfile;
    $profile_id = $clsProfile->getUserID();
    if( empty( $profile_id ) && isset($_SESSION["profile_id_db"]) ){
		$profile_id = $_SESSION["profile_id_db"];
	}
	$message=$_GET['message'];
	$assign_list["message"] = $message;
	
	if($profile_id==0){
		header('location: /sign-in.html');
	}
    $oneProfile=$clsProfile->getOne($profile_id);
	$assign_list["oneProfile"] = $oneProfile;
	#
    if($_POST['Update']=='ChangeAvata') {
        
		$msg='';
		$up = '';
		
		$name=$_FILES['avatar']['name'];
		$type=$_FILES['avatar']['type'];
		$size=$_FILES['avatar']['size'];
		
		if($name==''){
			$msg.='&bull; File upload not empty !<br />';
		}
		if($size>2097152){
			$msg.='&bull; File upload limit 2MB <br />';
		}
		if(!in_array($type,array('image/jpeg','image/png','image/gif'))){
			$msg.='&bull; File upload required format:.jpg,.gif,.png';
		}
		
		if($msg===''){
			if(is_uploaded_file($_FILES['avatar']['tmp_name'])){
				$clsUploadFile = new UploadFile();
				$up = $clsUploadFile->uploadItem($_FILES["avatar"],"/avatar","jpg,gif,png");
			}
			if($up!=''&&$up!='0'){
				$value = "avatar='".addslashes($up)."'";
			}
			if($clsProfile->updateOne($profile_id,$value)){
				$assign_list["messages"] = 'You are update avatar successfully!';
				//header('location:'.PCMS_URL.'/account/change-avatar/success.html');
			}else{
				header('location:'.PCMS_URL.'/account/change-avatar.html');
			}
		}	
    }
	$assign_list["msg"] = $msg;
	#
	$title_page = 'Change avatar - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
}

?>