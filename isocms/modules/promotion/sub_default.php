<?php
/**
*  Defautl action
*  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (info@vietiso.com)
*  @date		: 2009/10/01
   @date-modify : 2009/01/06
*  @version		: 3.0.0
*/
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain,$clsPageInfo;
	global $clsISO, $clsConfiguration;
	#Promotion
	$clsPromotion = new Promotion(); $assign_list['clsPromotion']=$clsPromotion;
	$clsTour = new Tour(); $assign_list['clsTour']=$clsTour;
	$clsHotel = new Hotel(); $assign_list['clsHotel']=$clsHotel;
	$clsHotelStore = new HotelStore(); $assign_list['clsHotelStore']=$clsHotelStore;
	$clsTourCategory = new TourCategory(); $assign_list['clsTourCategory']=$clsTourCategory;
	$clsPagination = new Pagination();
    $clsActivities = new Activities();$assign_list['clsActivities']=$clsActivities;

    $lstActivities = $clsActivities->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsActivities->pkey.",title");
    $assign_list['lstActivities']=$lstActivities;
    $assign_list['min_duration_value']=0;
    $assign_list['max_duration_value']=20;
    $assign_list['min_duration_search']=0;
    $assign_list['max_duration_search']=30;
	#- Pagination
	$recordPerPage = 14;
	$currentPage = isset($_GET['page'])?intval($_GET['page']):1;
	
	if($clsConfiguration->getValue('SitePromotionEnable')==1){
		$Current_Now = time();
		$CurrentDay = date('d',$Current_Now);
		$CurrentMonth = date('m',$Current_Now);
		$CurrentYear = date('Y',$Current_Now);
		
		$Start_Date = $CurrentDay.'-'.$CurrentMonth.'-'.$CurrentYear.' 00:00:00';
		$End_Date = $CurrentDay.'-'.$CurrentMonth.'-'.$CurrentYear.' 23:59:59';
		$cond ="is_trash=0 and is_online=1";	
		//$cond.=" and date_end <= '".strtotime($End_Date)."'";
		$orderBy = " order by order_no desc";
		$totalRecord = $clsPromotion->countItem($cond);
		
		$link_page = $clsISO->getLink('promotion');
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
		$assign_list['page_view']=$page_view; unset($page_view);
		$assign_list['totalPage'] = $clsPagination->getTotalPage();
		#
		$start_limit = ($currentPage-1)*$recordPerPage; 
		$limit = " limit $start_limit,$recordPerPage"; 
		
		$lstPromotion = $clsPromotion->getAll($cond.$orderBy.$limit, $clsPromotion->pkey.',reg_date');
		$assign_list['lstPromotion']=$lstPromotion; unset($lstPromotion);
	}
	else{
		
		
		$clsCity = new City();$assign_list['clsCity']=$clsCity;
		$lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id=1");
		
		$assign_list['lstCity']=$lstCity; unset($lstCity);
		
		$clsHotelStore = new HotelStore();$assign_list['clsHotelStore']=$clsHotelStore;

		
		$cond = "is_trash=0 and _type='PROMOTION' and hotel_id IN (SELECT hotel_id from ".DB_PREFIX."hotel WHERE is_trash=0 and is_online=1)";
		$orderBy = " order by order_no desc";
		$totalRecord = $clsHotelStore->countItem($cond);
		
		$link_page = $clsISO->getLink('promotion');
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
		$assign_list['page_view']=$page_view; unset($page_view);
		$assign_list['totalPage'] = $clsPagination->getTotalPage();
		#
		$start_limit = ($currentPage-1)*$recordPerPage; 
		$limit = " limit $start_limit,$recordPerPage";
		$listHotel = $clsHotelStore->getAll($cond.$orderBy.$limit, $clsHotel->pkey);
		$assign_list['listHotel']=$listHotel; 
		
		//print_r(count($listHotel)); die();
		unset($listHotel);
	}
	
    /*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('General Promotion').' - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('General Promotion').' - '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('General Promotion').' - '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	unset($clsCountry);unset($clsPromotion);
}
function default_detail(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page, $extLang;
	#
	$clsPromotion=new Promotion();
	$assign_list['clsPromotion']=$clsPromotion;
	
	$slug=$_GET['slug'];
	$all = $clsPromotion->getAll("is_trash=0 and is_online=1 and slug='$slug' LIMIT 0,1");
	$promotion_id = $all[0][$clsPromotion->pkey];
	if(intval($promotion_id)==0){
		header('location:'.PCMS_URL.$extLang);
		exit();
	}
	$assign_list['promotion_id']=$promotion_id;
	#
	$lstPromotion=$clsPromotion->getAll("is_trash=0 and promotion_id<>'$promotion_id' order by rand() limit 0,5");
	$assign_list['lstPromotion']=$lstPromotion; unset($lstPromotion);
	#
	/*=============Title & Description Page==================*/
	$title_page = $clsPromotion->getTitle($promotion_id).' - '.$core->get_Lang('specialoffers').' - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
}
function array_sort($array, $on, $order=SORT_ASC){

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
function default_ajLoadItemPromotion(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page, $extLang,$clsISO;
	#
	$clsPromotion=new Promotion();$assign_list['clsPromotion']=$clsPromotion;
	$clsPromotionItem=new PromotionItem();$assign_list['clsPromotionItem']=$clsPromotionItem;
	$clsTour = new Tour();$assign_list['clsTour']=$clsTour;
	$clsTourItinerary = new TourItinerary();$assign_list['clsTourItinerary']=$clsTourItinerary;
	$clsTourPriceGroup = new TourPriceGroup();$assign_list['clsTourPriceGroup']=$clsTourPriceGroup;
	$clsTourCategory = new TourCategory();$assign_list['clsTourCategory']=$clsTourCategory;
	$clsCruise = new Cruise();$assign_list['clsCruise']=$clsCruise;
	$clsCruiseCabin = new CruiseCabin();$assign_list['clsCruiseCabin']=$clsCruiseCabin;
	$clsCruiseCat = new CruiseCat();$assign_list['clsCruiseCat']=$clsCruiseCat;
	$clsHotel = new Hotel();$assign_list['clsHotel']=$clsHotel;
    $clsProfile= new Profile();$clsPagination = new Pagination();

	#

    $clsTable = isset($_POST['clsTable'])?$_POST['clsTable']:'';
    $sort = isset($_POST['sort'])?$_POST['sort']:'';
    $country_id = isset($_POST['country_check']) ? $_POST['country_check'] : '';
    $city_id = isset($_POST['city__id']) ? $_POST['city__id'] : '';
    $cat_ID = isset($_POST['travel_style_check']) ? $_POST['travel_style_check'] : '';
    $min_duration = isset($_POST['min_duration']) ? $_POST['min_duration'] : '';
    $max_duration =isset($_POST['max_duration']) ? $_POST['max_duration'] : '';
    $activities_id = isset($_POST['travel_acti_check']) ? $_POST['travel_acti_check'] : '';
    $cruise_cat_id = isset($_POST['cruise_cat_check']) ? $_POST['cruise_cat_check'] : '';
    $lang_id = isset($_POST['_LANG_ID']) ? $_POST['_LANG_ID'] : '';

    $recordPerPage = 6;
    $currentPage = isset($_POST['page'])?intval($_POST['page']):1;

    $assign_list['clsTable']=$clsTable;
    $assign_list['sort']=$sort;
    #
    if($clsTable == 'tour'){
        $sql = "SELECT DISTINCT(t.tour_id) FROM ".$clsPromotionItem->tbl." pi LEFT JOIN ".$clsPromotion->tbl." p ON(pi.promotion_id = p.promotion_id) LEFT JOIN ".$clsTour->tbl." t ON(pi.taget_id = t.tour_id) WHERE pi.is_online=1 and p.is_online=1 and t.is_online=1 and p.type='".$clsTable."' and ".time()." between  p.start_date and p.end_date";

        if(_ISOCMS_CLIENT_LOGIN){
            $loggedIn = $clsProfile->isLoggedIn();
            if($loggedIn!=1){
                $sql.= " and p.check_mem_set = 0";
            }
        }

        if($country_id>0){
            $sql.= " and t.tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE is_trash=0 and country_id IN ($country_id))";
            $assign_list["country_id"] = $country_id;
        }

        if(!empty($cat_ID)){
            $cat_id = explode(',',$cat_ID);
            $sql.=" and (";
            for($i=0;$i<count($cat_id);$i++) {
                if($i==0 && count($cat_id)==1){
                    $sql.=" (t.cat_id='".$cat_id[$i]."' or t.list_cat_id like '%|".$cat_id[$i]."|%')";
                }elseif(count($cat_id)>1 && $i< (count($cat_id)-1)){
                    $sql.="(t.cat_id='".$cat_id[$i]."' or t.list_cat_id like '%|".$cat_id[$i]."|%') or ";
                }else{
                    $sql.="(t.cat_id='".$cat_id[$i]."' or t.list_cat_id like '%|".$cat_id[$i]."|%')";
                }
            }
            $sql.=")";
        }
        $assign_list["cat_ID"] = $cat_ID;

        if(!empty($activities_id)){
            $activities_id = explode(',',$activities_id);
            $sql.=" and (";
            for($i=0;$i<count($activities_id);$i++) {
                if($i==0 && count($activities_id)==1){
                    $sql.=" t.list_activities_id like '%".$activities_id[$i]."%'";
                }elseif(count($activities_id)>1 && $i< (count($activities_id)-1)){
                    $sql.=" t.list_activities_id like '%".$activities_id[$i]."%' or ";
                }else{
                    $sql.=" t.list_activities_id like '%".$activities_id[$i]."%'";
                }
            }
            $sql.=")";
        }
        $assign_list["activities_id"] = $activities_id;

        if($min_duration>0 && $max_duration>0){
            $sql.=" and t.number_day >= '$min_duration' and t.number_day <= '$max_duration'";
        }elseif($min_duration==0 && $max_duration>0){
            $sql.=" and t.number_day <= '$max_duration'";
        }elseif($min_duration>0 && $max_duration==0){
            $sql.=" and t.number_day >= '$min_duration'";
        }else{
        }
        $assign_list['min_duration']=$min_duration;
        $assign_list['max_duration']=$max_duration;

        if($lang_id !='en'){
            $sql.=" and t.lang_id='$lang_id'";
        }else{
            $sql.=" and t.lang_id=''";
        }
        $assign_list['_LANG_ID']=$lang_id;
        if($sort == 'p_min'){
            $order_by = " order by t.min_price asc";
        }elseif($sort == 'p_min'){
            $order_by = " order by t.min_price desc";
        }else{
            $order_by="";
        }


    }elseif ($clsTable == 'cruise'){
        $sql = "SELECT DISTINCT(c.cruise_id) FROM ".$clsPromotionItem->tbl." pi LEFT JOIN ".$clsPromotion->tbl." p ON(pi.promotion_id = p.promotion_id) LEFT JOIN ".$clsCruise->tbl." c ON(pi.taget_id = c.cruise_id) WHERE pi.is_online=1 and p.is_online=1 and c.is_online=1 and p.type='".$clsTable."' and ".time()." between  p.start_date and p.end_date";
        if(_ISOCMS_CLIENT_LOGIN){
            $loggedIn = $clsProfile->isLoggedIn();
            if($loggedIn!=1){
                $sql.= " and p.check_mem_set = 0";
            }
        }

        if(!empty($cruise_cat_id)){
            $cat_cruise_id = explode(',',$cruise_cat_id);
            $sql.=" and (";
            for($i=0;$i<count($cat_cruise_id);$i++) {
                if($i==0 && count($cat_cruise_id)==1){
                    $sql.=" c.cruise_cat_id='".$cat_cruise_id[$i]."'";
                }elseif(count($cat_cruise_id)>1 && $i< (count($cat_cruise_id)-1)){
                    $sql.="c.cruise_cat_id='".$cat_cruise_id[$i]."' or ";
                }else{
                    $sql.="c.cruise_cat_id='".$cat_cruise_id[$i]."'";
                }
            }
            $sql.=")";
        }
        $assign_list["cruise_cat_id"] = $cruise_cat_id;
        $now_month = date('m', time());
        $assign_list['now_month']=$now_month;
//        var_dump($sql);
    }
//    $clsISO->print_pre($sql);die();
    $totalRecord = $dbconn->GetAll($sql)? count($dbconn->GetAll($sql)):'0';
    $assign_list['totalRecord']=$totalRecord;

    $config = array(
        'total'	=> $totalRecord,
        'number_per_page'	=> $recordPerPage,
        'current_page'	=> $currentPage,
    );

    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links(false);

    $offset = ($currentPage-1)*$recordPerPage;
    if($clsTable == 'tour'){
        $limit = " LIMIT $offset,$recordPerPage";
        $listArr = $dbconn->GetAll($sql.$order_by.$limit);
        $assign_list['listArr'] = $listArr;
    }elseif ($clsTable == 'cruise'){
        $listArr = $dbconn->GetAll($sql.$order_by);
        foreach ($listArr as $item) {
            $listArr1[]=array(
                'cruise_id'=>$item['cruise_id'],
                'price' => $clsCruise->getLTripPrice1($item['cruise_id'],$now_month,'Value')?$clsCruise->getLTripPrice1($item['cruise_id'],$now_month,'Value'):0
            );
        }
        if($sort == 'p_min'){
            $assign_list['listArr']=array_slice( array_sort($listArr1,'price',SORT_ASC), $offset, $recordPerPage );
        }elseif($sort == 'p_max'){
            $assign_list['listArr']=array_slice( array_sort($listArr1,'price',SORT_DESC), $offset, $recordPerPage );
        }
        unset($listArr);
        unset($listArr1);
    }
//



    $assign_list['page_view']=$page_view;

    $assign_list['totalPage'] = $clsPagination->getTotalPage();
    unset($page_view);
    $html = $core->build('load_item_promotion.tpl');
    echo $html;die();
}
function default_ajLoadMorePromotion(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page, $extLang,$clsISO;
	#
	$clsPromotion=new Promotion();$assign_list['clsPromotion']=$clsPromotion;
	$clsPromotionItem=new PromotionItem();$assign_list['clsPromotionItem']=$clsPromotionItem;
	$clsTour = new Tour();$assign_list['clsTour']=$clsTour;
	$clsTourItinerary = new TourItinerary();$assign_list['clsTourItinerary']=$clsTourItinerary;
	$clsTourPriceGroup = new TourPriceGroup();$assign_list['clsTourPriceGroup']=$clsTourPriceGroup;
	$clsTourCategory = new TourCategory();$assign_list['clsTourCategory']=$clsTourCategory;
	$clsCruise = new Cruise();$assign_list['clsCruise']=$clsCruise;
	$clsCruiseCabin = new CruiseCabin();$assign_list['clsCruiseCabin']=$clsCruiseCabin;
	$clsCruiseCat = new CruiseCat();$assign_list['clsCruiseCat']=$clsCruiseCat;
	$clsHotel = new Hotel();$assign_list['clsHotel']=$clsHotel;
    $clsProfile= new Profile();$clsPagination = new Pagination();

	#

    $clsTable = isset($_POST['clsTable'])?$_POST['clsTable']:'';
    $sort = isset($_POST['sort'])?$_POST['sort']:'';
    $country_id = isset($_POST['country_check']) ? $_POST['country_check'] : '';
    $city_id = isset($_POST['city__id']) ? $_POST['city__id'] : '';
    $cat_ID = isset($_POST['travel_style_check']) ? $_POST['travel_style_check'] : '';
    $min_duration = isset($_POST['min_duration']) ? $_POST['min_duration'] : '';
    $max_duration =isset($_POST['max_duration']) ? $_POST['max_duration'] : '';
    $activities_id = isset($_POST['travel_acti_check']) ? $_POST['travel_acti_check'] : '';
    $cruise_cat_id = isset($_POST['cruise_cat_check']) ? $_POST['cruise_cat_check'] : '';
    $lang_id = isset($_POST['_LANG_ID']) ? $_POST['_LANG_ID'] : '';

    $recordPerPage = 6;
    $currentPage = isset($_POST['page'])?intval($_POST['page']):1;

    $assign_list['clsTable']=$clsTable;
    $assign_list['sort']=$sort;
    #
    if($clsTable == 'tour'){
        $sql = "SELECT DISTINCT(t.tour_id) FROM ".$clsPromotionItem->tbl." pi LEFT JOIN ".$clsPromotion->tbl." p ON(pi.promotion_id = p.promotion_id) LEFT JOIN ".$clsTour->tbl." t ON(pi.taget_id = t.tour_id) WHERE pi.is_online=1 and p.is_online=1 and t.is_online=1 and p.type='".$clsTable."' and ".time()." between  p.start_date and p.end_date";
        if(_ISOCMS_CLIENT_LOGIN){
            $loggedIn = $clsProfile->isLoggedIn();
            if($loggedIn!=1){
                $sql.= " and p.check_mem_set = 0";
            }
        }

        if($country_id>0){
            $sql.= " and t.tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE is_trash=0 and country_id IN ($country_id))";
            $assign_list["country_id"] = $country_id;
        }

        if(!empty($cat_ID)){
            $cat_id = explode(',',$cat_ID);
            $sql.=" and (";
            for($i=0;$i<count($cat_id);$i++) {
                if($i==0 && count($cat_id)==1){
                    $sql.=" (t.cat_id='".$cat_id[$i]."' or t.list_cat_id like '%|".$cat_id[$i]."|%')";
                }elseif(count($cat_id)>1 && $i< (count($cat_id)-1)){
                    $sql.="(t.cat_id='".$cat_id[$i]."' or t.list_cat_id like '%|".$cat_id[$i]."|%') or ";
                }else{
                    $sql.="(t.cat_id='".$cat_id[$i]."' or t.list_cat_id like '%|".$cat_id[$i]."|%')";
                }
            }
            $sql.=")";
        }
        $assign_list["cat_ID"] = $cat_ID;

        if(!empty($activities_id)){
            $activities_id = explode(',',$activities_id);
            $sql.=" and (";
            for($i=0;$i<count($activities_id);$i++) {
                if($i==0 && count($activities_id)==1){
                    $sql.=" t.list_activities_id like '%".$activities_id[$i]."%'";
                }elseif(count($activities_id)>1 && $i< (count($activities_id)-1)){
                    $sql.=" t.list_activities_id like '%".$activities_id[$i]."%' or ";
                }else{
                    $sql.=" t.list_activities_id like '%".$activities_id[$i]."%'";
                }
            }
            $sql.=")";
        }
        $assign_list["activities_id"] = $activities_id;

        if($min_duration>0 && $max_duration>0){
            $sql.=" and t.number_day >= '$min_duration' and t.number_day <= '$max_duration'";
        }elseif($min_duration==0 && $max_duration>0){
            $sql.=" and t.number_day <= '$max_duration'";
        }elseif($min_duration>0 && $max_duration==0){
            $sql.=" and t.number_day >= '$min_duration'";
        }else{
        }
        $assign_list['min_duration']=$min_duration;
        $assign_list['max_duration']=$max_duration;

        if($lang_id !='en'){
            $sql.=" and t.lang_id='$lang_id'";
        }else{
            $sql.=" and t.lang_id=''";
        }
        $assign_list['_LANG_ID']=$lang_id;
        if($sort == 'p_min'){
            $order_by = " order by t.min_price asc";
        }elseif($sort == 'p_min'){
            $order_by = " order by t.min_price desc";
        }else{
            $order_by="";
        }


    }elseif ($clsTable == 'cruise'){
        $sql = "SELECT DISTINCT(c.cruise_id) FROM ".$clsPromotionItem->tbl." pi LEFT JOIN ".$clsPromotion->tbl." p ON(pi.promotion_id = p.promotion_id) LEFT JOIN ".$clsCruise->tbl." c ON(pi.taget_id = c.cruise_id) WHERE pi.is_online=1 and p.is_online=1 and c.is_online=1 and p.type='".$clsTable."' and ".time()." between  p.start_date and p.end_date";
        if(_ISOCMS_CLIENT_LOGIN){
            $loggedIn = $clsProfile->isLoggedIn();
            if($loggedIn!=1){
                $sql.= " and p.check_mem_set = 0";
            }
        }

        if(!empty($cruise_cat_id)){
            $cat_cruise_id = explode(',',$cruise_cat_id);
            $sql.=" and (";
            for($i=0;$i<count($cat_cruise_id);$i++) {
                if($i==0 && count($cat_cruise_id)==1){
                    $sql.=" c.cruise_cat_id='".$cat_cruise_id[$i]."'";
                }elseif(count($cat_cruise_id)>1 && $i< (count($cat_cruise_id)-1)){
                    $sql.="c.cruise_cat_id='".$cat_cruise_id[$i]."' or ";
                }else{
                    $sql.="c.cruise_cat_id='".$cat_cruise_id[$i]."'";
                }
            }
            $sql.=")";
        }
        $assign_list["cruise_cat_id"] = $cruise_cat_id;
        $now_month = date('m', time());
        $assign_list['now_month']=$now_month;
    }
//    var_dump($sql);
    $offset = ($currentPage-1)*$recordPerPage;

    if($clsTable == 'tour'){
        $limit = " LIMIT $offset,$recordPerPage";
        $listArr = $dbconn->GetAll($sql.$order_by.$limit);
        $assign_list['listArr']=$listArr;
    }elseif ($clsTable == 'cruise'){
        $listArr = $dbconn->GetAll($sql.$order_by);
        foreach ($listArr as $item) {
            $listArr1[]=array(
                'cruise_id'=>$item['cruise_id'],
                'price' => $clsCruise->getLTripPrice1($item['cruise_id'],$now_month,'Value')?$clsCruise->getLTripPrice1($item['cruise_id'],$now_month,'Value'):0
            );
        }
        if($sort == 'p_min'){
            $assign_list['listArr']=array_slice( array_sort($listArr1,'price',SORT_ASC), $offset, $recordPerPage );
        }elseif($sort == 'p_max'){
            $assign_list['listArr']=array_slice( array_sort($listArr1,'price',SORT_DESC), $offset, $recordPerPage );
        }

        unset($listArr);
        unset($listArr1);
    }
    $html = $core->build('load_item_promotion.tpl');
    echo $html;die();
}
function default_ajLoadOptionPromotion(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page, $extLang;
	#
	$clsPromotion=new Promotion();
    $clsActivities = new Activities();$assign_list['clsActivities']=$clsActivities;
    $clsCruiseCat = new CruiseCat();$assign_list['clsCruiseCat']=$clsCruiseCat;
	$assign_list['clsPromotion']=$clsPromotion;

	#

    $type_op = isset($_POST['type_op'])?$_POST['type_op']:'';
    $assign_list['type_op']=$type_op;
    if($type_op == 'tour'){
        $lstActivities = $clsActivities->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsActivities->pkey.",title");
        $assign_list['lstActivities']=$lstActivities;
        $assign_list['min_duration_value']=0;
        $assign_list['max_duration_value']=20;
        $assign_list['min_duration_search']=0;
        $assign_list['max_duration_search']=30;
    }elseif ($type_op == 'cruise'){
        $sql_cat = "is_trash=0 and is_online=1 and parent_id='0' order by order_no asc";
        $lstCatAll = $clsCruiseCat->getAll($sql_cat);
        $lstCat=array();
        foreach ($lstCatAll as $it){
            $sql_cat_con = "is_trash=0 and is_online=1 and parent_id='".$it['cruise_cat_id']."' order by order_no asc";
            $lstCatCon = $clsCruiseCat->getAll($sql_cat_con);
            $lstCat[]=array(
                'cruise_cat_id'=> $it['cruise_cat_id'],
                'title'=> $it['title'],
                'catchild'=> $lstCatCon,
            );
        }
        $assign_list['lstCat']=$lstCat;
//        var_dump($lstCat);die();
    }
    $html = $core->build('load_option_promotion.tpl');
	echo $html;die();
}
function default_ajLoadTotalPromotion(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page, $extLang;
	#
	$clsPromotion=new Promotion();
    $clsActivities = new Activities();$assign_list['clsActivities']=$clsActivities;
	$assign_list['clsPromotion']=$clsPromotion;
    $clsPromotionItem=new PromotionItem();$assign_list['clsPromotionItem']=$clsPromotionItem;
    $clsTour = new Tour();$assign_list['clsTour']=$clsTour;
    $clsTourItinerary = new TourItinerary();$assign_list['clsTourItinerary']=$clsTourItinerary;
    $clsTourPriceGroup = new TourPriceGroup();$assign_list['clsTourPriceGroup']=$clsTourPriceGroup;
    $clsTourCategory = new TourCategory();$assign_list['clsTourCategory']=$clsTourCategory;
    $clsCruise = new Cruise();$assign_list['clsCruise']=$clsCruise;
    $clsCruiseCabin = new CruiseCabin();$assign_list['clsCruiseCabin']=$clsCruiseCabin;
    $clsCruiseCat = new CruiseCat();$assign_list['clsCruiseCat']=$clsCruiseCat;
    $clsHotel = new Hotel();$assign_list['clsHotel']=$clsHotel;
    $clsProfile= new Profile();

	#

    $type_op = isset($_POST['clsTable'])?$_POST['clsTable']:'';
    $assign_list['type_op']=$type_op;
    $sort = isset($_POST['sort'])?$_POST['sort']:'';
    $country_id = isset($_POST['country_check']) ? $_POST['country_check'] : '';
    $city_id = isset($_POST['city__id']) ? $_POST['city__id'] : '';
    $cat_ID = isset($_POST['travel_style_check']) ? $_POST['travel_style_check'] : '';
    $min_duration = isset($_POST['min_duration']) ? $_POST['min_duration'] : '';
    $max_duration =isset($_POST['max_duration']) ? $_POST['max_duration'] : '';
    $activities_id = isset($_POST['travel_acti_check']) ? $_POST['travel_acti_check'] : '';
    $lang_id = isset($_POST['_LANG_ID']) ? $_POST['_LANG_ID'] : '';
    $cruise_cat_id = isset($_POST['cruise_cat_check']) ? $_POST['cruise_cat_check'] : '';
    if($type_op == 'tour'){

        $sql = "SELECT COUNT(DISTINCT t.tour_id) as total FROM ".$clsPromotionItem->tbl." pi LEFT JOIN ".$clsPromotion->tbl." p ON(pi.promotion_id = p.promotion_id) LEFT JOIN ".$clsTour->tbl." t ON(pi.taget_id = t.tour_id) WHERE pi.is_online=1 and p.is_online=1 and t.is_online=1 and p.type='".$type_op."' and ".time()." between  p.start_date and p.end_date";
        if(_ISOCMS_CLIENT_LOGIN){
            $loggedIn = $clsProfile->isLoggedIn();
            if($loggedIn!=1){
                $sql.= " and p.check_mem_set = 0";
            }
        }

        if($country_id>0){
            $sql.= " and t.tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE is_trash=0 and country_id IN ($country_id))";
            $assign_list["country_id"] = $country_id;
        }

        if(!empty($cat_ID)){
            $cat_id = explode(',',$cat_ID);
            $sql.=" and (";
            for($i=0;$i<count($cat_id);$i++) {
                if($i==0 && count($cat_id)==1){
                    $sql.=" (t.cat_id='".$cat_id[$i]."' or t.list_cat_id like '%|".$cat_id[$i]."|%')";
                }elseif(count($cat_id)>1 && $i< (count($cat_id)-1)){
                    $sql.="(t.cat_id='".$cat_id[$i]."' or t.list_cat_id like '%|".$cat_id[$i]."|%') or ";
                }else{
                    $sql.="(t.cat_id='".$cat_id[$i]."' or t.list_cat_id like '%|".$cat_id[$i]."|%')";
                }
            }
            $sql.=")";
        }
        $assign_list["cat_ID"] = $cat_ID;

        if(!empty($activities_id)){
            $activities_id = explode(',',$activities_id);
            $sql.=" and (";
            for($i=0;$i<count($activities_id);$i++) {
                if($i==0 && count($activities_id)==1){
                    $sql.=" t.list_activities_id like '%".$activities_id[$i]."%'";
                }elseif(count($activities_id)>1 && $i< (count($activities_id)-1)){
                    $sql.=" t.list_activities_id like '%".$activities_id[$i]."%' or ";
                }else{
                    $sql.=" t.list_activities_id like '%".$activities_id[$i]."%'";
                }
            }
            $sql.=")";
        }
        $assign_list["activities_id"] = $activities_id;

        if($min_duration>0 && $max_duration>0){
            $sql.=" and t.number_day >= '$min_duration' and t.number_day <= '$max_duration'";
        }elseif($min_duration==0 && $max_duration>0){
            $sql.=" and t.number_day <= '$max_duration'";
        }elseif($min_duration>0 && $max_duration==0){
            $sql.=" and t.number_day >= '$min_duration'";
        }else{
        }
        $assign_list['min_duration']=$min_duration;
        $assign_list['max_duration']=$max_duration;

        if($lang_id !='en'){
            $sql.=" and t.lang_id='$lang_id'";
        }else{
            $sql.=" and t.lang_id=''";
        }
        $assign_list['_LANG_ID']=$lang_id;
        if($sort == 'p_min'){
            $order_by = " order by t.min_price asc";
        }elseif($sort == 'p_min'){
            $order_by = " order by t.min_price desc";
        }else{
            $order_by="";
        }

        /*$sql = "SELECT COUNT(DISTINCT t.tour_id) as total FROM ".$clsPromotionItem->tbl." pi LEFT JOIN ".$clsPromotion->tbl." p ON(pi.promotion_id = p.promotion_id) LEFT JOIN ".$clsTour->tbl." t ON(pi.taget_id = t.tour_id) WHERE pi.is_online=1 and p.is_online=1 and t.is_online=1 and p.type='".$type_op."' and ".time()." between  p.start_date and p.end_date";
        if(_ISOCMS_CLIENT_LOGIN){
            $loggedIn = $clsProfile->isLoggedIn();
            if($loggedIn!=1){
                $sql.= " and p.check_mem_set = 0";
            }
        }*/
        $listArr = $dbconn->GetAll($sql);
//        var_dump($listArr[0]['total']) ;die();
       $total_item = $listArr[0]['total'];
    }elseif ($type_op == 'cruise'){
        $sql = "SELECT COUNT(DISTINCT c.cruise_id) as total FROM ".$clsPromotionItem->tbl." pi LEFT JOIN ".$clsPromotion->tbl." p ON(pi.promotion_id = p.promotion_id) LEFT JOIN ".$clsCruise->tbl." c ON(pi.taget_id = c.cruise_id) WHERE pi.is_online=1 and p.is_online=1 and c.is_online=1 and p.type='".$type_op."' and ".time()." between  p.start_date and p.end_date";
        if(_ISOCMS_CLIENT_LOGIN){
            $loggedIn = $clsProfile->isLoggedIn();
            if($loggedIn!=1){
                $sql.= " and p.check_mem_set = 0";
            }
        }

        if(!empty($cruise_cat_id)){
            $cat_cruise_id = explode(',',$cruise_cat_id);
            $sql.=" and (";
            for($i=0;$i<count($cat_cruise_id);$i++) {
                if($i==0 && count($cat_cruise_id)==1){
                    $sql.=" c.cruise_cat_id='".$cat_cruise_id[$i]."'";
                }elseif(count($cat_cruise_id)>1 && $i< (count($cat_cruise_id)-1)){
                    $sql.="c.cruise_cat_id='".$cat_cruise_id[$i]."' or ";
                }else{
                    $sql.="c.cruise_cat_id='".$cat_cruise_id[$i]."'";
                }
            }
            $sql.=")";
        }
        $assign_list["cruise_cat_id"] = $cruise_cat_id;

        $listArr = $dbconn->GetAll($sql);
//        var_dump($sql);
        $total_item = $listArr[0]['total'];
    }elseif ($type_op == 'hotel'){
        $total_item = 300;
    }else{
        $total_item = 400;
    }
    $assign_list['total_item']=$total_item;
    $html = $core->build('load_total_promotion.tpl');
	echo $html;die();
}

?>