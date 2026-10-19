<?php
function default_combo(){
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;
	$clsCombo= new Combo();$assign_list['clsCombo']=$clsCombo;
	
	$response = curl_exec($ch);
	$response_hotel=json_decode($response,true);
	
	$assign_list['response_hotel']=$response_hotel;
   	#
	$clsYearJourney = new YearJourney();
	$assign_list['clsYearJourney'] = $clsYearJourney;
	
	#- List_Button
	$listPutCombo = $clsYearJourney->getAll("1=1 and post_type='PUTCOMBO' order by order_no ASC");
	$assign_list["listPutCombo"] = $listPutCombo;
	
	$listWhyCombo = $clsYearJourney->getAll("1=1 and post_type='WHYCOMBO' order by order_no ASC");
	$assign_list["listWhyCombo"] = $listWhyCombo;
//	print_r($listWhyCombo);die();
	
	
	
    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('hotelsresorts').' | '.PAGE_NAME;
     $assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_search_combo() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain,$clsISO;
	$clsCombo= new Combo();$assign_list['clsCombo']=$clsCombo;
	$clsComboRoom= new ComboRoom();$assign_list['clsComboRoom']=$clsComboRoom;
	$clsCombo= new Combo();$assign_list['clsCombo']=$clsCombo;
	$clsReviews= new Reviews();$assign_list['clsReviews']=$clsReviews;
	$clsProperty= new Property();$assign_list['clsProperty']=$clsProperty;
	
	$now= time();
	$now_next= time()+(24*60*60);
	
	$clsComboAPI= new ComboAPI();$assign_list['clsComboAPI']=clsComboAPI;
	
	$keyword = isset($_GET['keyword'])?$_GET['keyword']:'';
	$keywordType = isset($_GET['keywordType'])?$_GET['keywordType']:4;
	$checkin = isset($_GET['checkin'])?$_GET['checkin']:date('Y-m-d',$now);
	$checkout = isset($_GET['checkout'])?$_GET['checkout']:date('Y-m-d',$now_next);
	$number_room = isset($_GET['number_room'])?$_GET['number_room']:1;
	$passenger = isset($_GET['passenger'])?$_GET['passenger']:1;
	
	$cond ="is_trash=0 and is_online=1";
	$orderBy =" order by order_no asc";
	$oneItem = $clsCombo->getOne(1);
	$data_combo = $oneItem['data_combo'];
	$data_combo = unserialize($data_combo);
	
	$list_hotel_id=array();
	$list_hotel_room_id=array();
	foreach ($data_combo as $item){
		$list_hotel_id[].=$item['hotel_id'];
		foreach($item["hotel_room_id"] as $key=>$value) {
			$list_hotel_room_id[].=$value;
		}
    }
	
	
	$lstCombo= $clsCombo->getAll($cond.$orderBy,$clsCombo->pkey);
	$lstAllFacility= $clsProperty->getAll("is_trash=0 and type='ComboFacilities'".$orderBy,$clsProperty->pkey);
	
	$assign_list["lstCombo"]=$lstCombo;
	$assign_list["lstAllFacility"]=$lstAllFacility;
	$assign_list["list_hotel_id"]=$list_hotel_id;
	$assign_list["list_hotel_room_id"]=$list_hotel_room_id;
	
  
    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('hotelsresorts').' | '.PAGE_NAME;
     $assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}


function default_detail() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act,$_LANG_ID,$title_page,$description_page,$global_image_seo_page,$curl;
	global $country_id,$clsISO,$combo_id;
	
	#
	$show = isset($_GET['show'])?$_GET['show']:'';
	$assign_list['show']=$show;
	#
	$clsCombo=new Combo(); $assign_list['clsCombo']=$clsCombo;
	$clsComboImage=new ComboImage(); $assign_list['clsComboImage']=$clsComboImage;
	
	$combo_id=Input::get('combo_id',0);
	$slug=Input::get('slug','');
	
	
	if(empty($clsCombo->checkOnlineBySlug($combo_id,$slug))){
		header('location:'.DOMAIN_NAME.$extLang);
		exit();
	}
	$assign_list['combo_id']=$combo_id;
	
	
	$lstImage = $clsComboImage->getAll("is_trash=0 and table_id='$combo_id' and image<>'' order by order_no ASC",$clsComboImage->pkey);
	$assign_list["lstImage"] = $lstImage; 

	unset($lstImage);
	
	$list_hotel = $clsCombo->getOneField('list_hotel', $combo_id);
	$list_hotel = !empty($list_hotel) ? json_decode($list_hotel, true) : array();
	$assign_list['list_hotel']=$list_hotel;
	
	$number_day =$clsCombo->getOneField('number_day',$combo_id);
	$assign_list['number_day']=$number_day;
	
	$now_day = date('m/d/Y');
	
	$str_check_in = strtotime($now_day)+24*60*60;
	$str_check_out = $str_check_in+$number_day*24*60*60;
	$check_in=date('d/m/Y',$str_check_in);
	$check_out=date('d/m/Y',$str_check_out);
	$assign_list['check_in']=$check_in;
	$assign_list['check_out']=$check_out;
	
	
	
	 
    /*=============Title & Description Page==================*/
	$title_page = $clsCombo->getTitle($combo_id).' | '.$core->get_Lang('Combo').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$description_page = $clsISO->getMetaDescription($combo_id,'Combo');
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = $clsISO->getPageImageShare($combo_id,'Combo');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
	
}
?>
