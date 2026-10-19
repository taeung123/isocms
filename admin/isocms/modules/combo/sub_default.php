<?php
//HOTEL DEFAULT
function default_default() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    # 
    $clsContinent = new Continent();$assign_list['clsContinent'] = $clsContinent;
    $clsCountry = new Country();$assign_list['clsCountry'] = $clsCountry;
	$clsRegion = new Region();$assign_list['clsRegion'] = $clsRegion;
    $clsCity = new City();$assign_list['clsCity'] = $clsCity;
    #
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list['type_list'] = $type_list;
    #
    $continent_id = isset($_GET['continent_id']) ? $_GET['continent_id'] : 0;
    $assign_list["continent_id"] = $continent_id;
	#
    $area_id = isset($_GET['area_id']) ? $_GET['area_id'] : 0;
    $assign_list["area_id"] = $area_id;
	#
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : 0;
    $assign_list["country_id"] = $country_id;
	
	#
	$region_id = isset($_GET['region_id']) ? $_GET['region_id'] : 0;
    $assign_list["region_id"] = $region_id;
	#
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : 0;
    $assign_list["city_id"] = $city_id;
	#
    $hotel_rating = isset($_GET['hotel_rating']) ? $_GET['hotel_rating'] : 0;
    $assign_list["hotel_rating"] = $hotel_rating;
    #
	$star = isset($_GET['star']) ? $_GET['star'] : 0;
    $assign_list["star"] = $star;
    #
	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $assign_list["keyword"] = $keyword;
    // Submit filter.
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if (isset($_POST['iso-continent_id']) && intval($_POST['iso-continent_id']) != '0') {
            $link.='&continent_id=' . $_POST['iso-continent_id'];
        }
		#
		if (isset($_POST['iso-area_id']) && intval($_POST['iso-area_id']) != '') {
            $link.='&area_id=' . $_POST['iso-area_id'];
        }
		#
        if (isset($_POST['country_id']) && intval($_POST['country_id']) != '0') {
            $link.='&country_id=' . $_POST['country_id'];
        }
        #
		if (isset($_POST['region_id']) && intval($_POST['region_id']) != '0') {
            $link.='&region_id=' . $_POST['region_id'];
        }
		#
        if (isset($_POST['city_id']) && intval($_POST['city_id']) != '0' && intval($_POST['country_id']) != '0') {
            $link.='&city_id=' . $_POST['city_id'];
        }
		#
        if (isset($_POST['star']) && intval($_POST['star']) != '0') {
            $link.='&star=' . $_POST['star'];
        }
		#
        if (isset($_POST['hotel_rating']) && intval($_POST['hotel_rating']) != '0') {
            $link.='&hotel_rating=' . $_POST['hotel_rating'];
        }
		#
        if ($_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
	

    // Get Parameter fiter
    $classTable = "Combo";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
	
	$pUrl = '';
    $cond = "1=1";
    #-- $continent_id
    if (intval($continent_id) > 0) {
        $cond.=" and continent_id='$continent_id'";
		$pUrl .= '&continent_id='.$continent_id;
    }
	#-- $area_id
	if (intval($area_id) > 0) {
        $cond.=" and area_id='$area_id'";
		$pUrl .= '&area_id='.$area_id;
    }
	#-- $country_id
    if (intval($country_id) > 0) {
        $cond.=" and country_id='$country_id'";
		$pUrl .= '&country_id='.$country_id;
    }
    #-- $region_id
    if (intval($region_id) > 0) {
        $cond.=" and region_id='$region_id'";
		$pUrl .= '&region_id='.$region_id;
    }
	#-- $star
    if (intval($star) > 0) {
        $cond.=" and star_id='$star'";
		$pUrl .= '&star_id='.$star_id;
    }
	#-- $hotel_rating
    if (intval($hotel_rating) > 0) {
        $cond.=" and hotel_rating='$hotel_rating'";
		$pUrl .= '&star_id='.$star_id;
    }
		#-- $city_id
    if (intval($city_id) > 0) {
        $cond.=" and city_id='$city_id'";
		$pUrl .= '&city_id='.$city_id;
    }
    if ($keyword != '') {
        $slug = 'slug';
        $cond.=" and $slug like '%" . $core->replaceSpace($keyword) . "%'";
        $assign_list["keyword"] = $keyword;
		$pUrl .= '&keyword='.$keyword;
    }
	
	$assign_list['pUrl'] = $pUrl;
	
    #
    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    #
    $orderBy = " order by order_no asc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $lstAllItem = $clsClassTable->getAll($cond,$clsClassTable->pkey);
    $totalRecord = (is_array($lstAllItem) && count($lstAllItem) > 0) ? count($lstAllItem) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
	
	$stt=($currentPage-1)*$recordPerPage;
	$assign_list['stt'] = $stt;
	
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
    #-------End Page Divide-----------------------------------------------------------
	
	
    $allItem= $clsClassTable->getAll($cond . $orderBy . $limit);
	$assign_list["allItem"]=$allItem;
    #
    $allAll = $clsClassTable->getAll($cond2 . ' and is_trash=0');
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
    #
    $allTrash = $clsClassTable->getAll($cond2 . ' and is_trash=1');
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allTopCity = $clsClassTable->getAll($cond2 . " and is_top_city=1" . $orderBy);
    $assign_list["number_top_city"] = $allTopCity[0][$pkeyTable] != '' ? count($allTopCity) : 0;
    #
    $allTopCountry = $clsClassTable->getAll($cond2 . " and is_top_country=1" . $orderBy);
    $assign_list["number_top_country"] = $allTopCountry[0][$pkeyTable] != '' ? count($allTopCountry) : 0;
	#----
	
	if(isset($_POST['submit'])){
		if($_POST['submit']=='UpdateCombo'){
			foreach($_POST as $key=>$val){
				$tmp = explode('-',$key);
				if($tmp[0]=='iso'){
					$clsConfiguration->updateValue($tmp[1],$val);
				}
			}
			header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&message=UpdateSuccess');
		}
	}
}
function getFrame(){
	global $core,$dbconn,$_LANG_ID,$clsISO;
	$frames = array(
		'overview' => array(
			'href_group'	=> 'overview',
			'name'	=> $core->get_Lang('Overview'),
			'icon'	=> 'home',
			'steps' => array(
				'name' => array(
					'name' => $core->get_Lang('Name and Combo code')
				),
				'itinerary' => array(
					'name' => $core->get_Lang('Combo Itinerary')
				),
				'image' => array(
					'name' => $core->get_Lang('Image cover')
				),
				'highlight'	=> array(
					'name' => $core->get_Lang('Highlight')
				),
				'inclusion' => array(
					'name' => $core->get_Lang('Inclusion Combo')
				),
				'note' => array(
					'name' =>  $core->get_Lang('Special notes')
				),
				'condition_apply' => array(
					'name' =>  $core->get_Lang('Conditions apply')
				)
			)
		),
	);
	$frames['apply'] = array(
		'name'	=> $core->get_Lang('Apply'),
		'href_group'	=> 'apply',
		'icon'	=> 'destination',
		'steps'	=> array(
			'time_apply' => array(
				'name' => $core->get_Lang('Thời gian hiệu lực'),
			),
			'hotel' => array(
				'name' => $core->get_Lang('Hotels')
			)
		)
	);
	$frames['config'] = array(
		'name'	=> $core->get_Lang('Configs'),
		'href_group'	=> 'config',
		'icon'	=> 'config',
		'steps'	=> array(
			'addon_service' => array(
				'name' => $core->get_Lang('Addon Services')
			),
			'combo_related' => array(
				'name' => $core->get_Lang('Combo Related')
			),
			'gallery' => array(
				'name' => $core->get_Lang('Gallery')
			),
		)
	);
	$frames['price'] = array(
		'name'	=> $core->get_Lang('Price Table'),
		'href_group'	=> 'price',
		'icon'	=> 'pricetable',
		'steps'	=> array(
			'price' => array(
				'name' => $core->get_Lang('Price Table')
			),
			
		)
	);
	$frames['seo'] = array(
		'name'	=> $core->get_Lang('Seo tools'),
		'href_group'	=> 'seo',
		'icon'	=> 'seo',
		'steps'	=> array(
			'seo' => array(
				'name' => $core->get_Lang('Seo tools')
			),
		)
	);
	return $frames;
}
function default_insert() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,$pvalTable,
	$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration,$adult_type_id,$child_type_id,$infant_type_id,$show,$nextstep;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
	$show=isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list["show"] = $show;
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';

	$pvalTable =Input::get('table_id',0);$assign_list["pvalTable"] = $pvalTable;
	$panel =Input::get('panel','');$assign_list["panel"] = $panel;

	$currentstep =Input::get('step','name');
	$assign_list["currentstep"] = $currentstep;
	
	
	$currentstepx = 0;
	$frames = getFrame();
	
	//$clsISO->pre($oneCombo);die;
	$ii = 0; $arrStep = array();
	foreach($frames as $okey => $frame){
		$steps = $frame['steps'];
		foreach($steps as $key => $step){
			$status = 0;
			$arrStep[$ii] = array(
				'key' => $key,
				'name' => $step['name'],
				'status' => $status,
				'description' => $step['description']
			);
			$frames[$okey]['steps'][$key]['status'] = $status;
			++$ii;
		}
	}
	/*if($profile_id==18696){
			die('ss');
		}*/
	$nextstep = $arrStep[$currentstepx+1];
	$assign_list["frames"] = $frames;
	$assign_list["nextstep"] = $nextstep;
	

    $classTable = "Combo";
    $clsClassTable = new $classTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    
    $assign_list["clsTable"] = $classTable;
	$assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
	
}
function default_getMainFormStep(){
	global $smarty,$assign_list,$_frontIsLoggedin_user_id,$core,$clsISO,$clsProperty,$clsUser,$_company_iom_id,$dbconn,$nextstep,$clsConfiguration;
	$clsTag = new Tag();
	$clsCity = new City();
	$clsRegion = new Region();
	$clsCountry = new Country();
	$clsContinent = new Continent();
	$clsCombo = new Combo();
	$clsMeta = new Meta();
	$smarty->assign('clsTag', $clsTag);
	$smarty->assign('clsCity', $clsCity);
	$smarty->assign('clsRegion', $clsRegion);
	$smarty->assign('clsCountry', $clsCountry);
	$smarty->assign('clsContinent', $clsContinent);
	$smarty->assign('clsClassTable', $clsCombo);
	
	#
	$table_id = Input::post('table_id',0);
	$currentstep = Input::post('currentstep','');
	
	
	
	$oneItem =$clsCombo->getOne($table_id);
	
	$smarty->assign('pvalTable',$table_id);
	$smarty->assign('oneItem',$oneItem);
	$smarty->assign('clsTable','Combo');
	$smarty->assign('clsTableGal','ComboImage');
	
	$booking_date_from=$oneItem['booking_date_from']?$oneItem['booking_date_from']:time();
	$booking_date_to=$oneItem['booking_date_to']?$oneItem['booking_date_to']:time()+24*60*60;
	
	$travel_date_from=$oneItem['travel_date_from']?$oneItem['travel_date_from']:time();
	$travel_date_to=$oneItem['travel_date_to']?$oneItem['travel_date_to']:time()+24*60*60;
	
	$smarty->assign('booking_date_from', $booking_date_from);
	$smarty->assign('booking_date_to', $booking_date_to);
	
	$smarty->assign('travel_date_from', $travel_date_from);
	$smarty->assign('travel_date_to', $travel_date_to);
	
	
	$frames = getFrame();
	#Step follow index
	$ii = 0; $arrStep = array();
	foreach($frames as $okey => $frame){
		$steps = $frame['steps'];
		foreach($steps as $key => $step){
			$arrStep[$ii] = array(
				'key' => $key,
				'panel' => $okey,
				'name' => $step['name'],
				'description' => $step['description']
			);
			++$ii;
		}
	}
	
	$smarty->assign('arrStep',$arrStep);
	if($currentstep=='seo'){
		$linkMeta = $clsCombo->getLink($table_id);
		$allMeta = $clsMeta->getAll("config_link='{$linkMeta}'", $clsMeta->pkey);
		$meta_id = !empty($allMeta) ? $allMeta[0]['meta_id'] : 0;
		$smarty->assign('meta_id',$meta_id);
	} else if($currentstep == 'lhdl'){

	}
	if($currentstep=='image-file-tour'){
		$hasImg = 1;
		if(stripos($oneItem['image'],'no-image')!==false){
			$hasImg = 0;
		}
		$smarty->assign('hasImg',$hasImg);
	}
	//die('xx');
	#Possition current step
	$step = 0;
	foreach($arrStep as $k => $v){
		if($v['key']==$currentstep){
			$step = $k;
			break;
		}
	}
	$prevstep = isset($arrStep[$step-1]['key']) ? $arrStep[$step-1]['key'] : '_first';
	$nextstep = isset($arrStep[$step+1]['key']) ? $arrStep[$step+1]['key'] : 'name';
	$smarty->assign('step',$step);
	$smarty->assign('prevstep',$prevstep);
	$smarty->assign('nextstep',$nextstep);
	$smarty->assign('currentstep',$currentstep);
	
	
	require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$smarty->assign('clsForm',$clsForm);
	#
    $clsForm->addInputTextArea("full", "overview", "", "overview", 255, 25, 8, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "check_in_out_rule", "", "check_in_out_rule", 255, 25, 8, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", "hotel_booking_policy", "", "hotel_booking_policy", 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", "child_policy", "", "child_policy", 255, 25, 2, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", "cancellation_policy", "", "cancellation_policy", 255, 25, 2, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "other_policy", "", "other_policy", 255, 25, 8, 1, "style='width:100%'");
	
	
	if($currentstep=='addon_service'){
		$clsAddOnService=new AddOnService();$smarty->assign('clsAddOnService',$clsAddOnService);
		$lstAddOnService=$clsAddOnService->getAll("is_trash=0 and is_online=1 order by order_no ASC",$clsAddOnService->pkey);
		$smarty->assign('lstAddOnService',$lstAddOnService);
		
		$list_service_check =$oneItem['list_service'];
		$list_service_check = !empty($list_service_check) ? json_decode($list_service_check, true) : array();

		
		$assign_list['list_service_check']=$list_service_check;
		
		
	}
	
	
	#
	
	// Output
	$html = $core->build('main_step.tpl');
	echo $html; die();
}
function default_ajCheckPublicCombo(){
    global $core,$clsISO,$clsConfiguration,$assign_list,$clsModule;
//    header('Content-Type: application/json');
    $clsCombo = new Combo();
	$pvalTable =Input::post('table_id',0);
	$online =Input::post('is_online',0);

    $result = array('result' => '_ERR');
    $value = '';
	$value .= 'is_online='.$online;

    if($clsCombo->updateOne($pvalTable, $value)){
        $result = array('result' => '_SUCCESS');
    }else{
        $result = array('result' => '_ERR');
    }
    echo json_encode($result);die();
}
function default_ajSaveMainStep(){
	global $_frontIsLoggedin_user_id,$core,$clsISO,$clsProperty,$clsUser,$_company_iom_id,$dbconn;
	#
	$msg = '_error';
	$clsClassTable= new Combo();
	$table_id = Input::post('table_id',0);
	$currentstep = Input::post('currentstep');
	
	

	if($currentstep=='name'){
		$title = Input::post('title');
		$slug=$core->replaceSpace($title);
		$slug=str_replace('-|-','-',$slug);
		$slug=str_replace('-+-','-',$slug);

		if($clsClassTable->updateOne($table_id, array(
			'title' => $title,
			'slug' => $slug,
			'code' => Input::post('table_code'),
			'upd_date' => time()
			
		))){
			$msg = '_success';
		}else{
			$msg = '_error';
		}
	} else if($currentstep=='location'){
		$continent_id = Input::post('iso-continent_id',0);
		$country_id = Input::post('iso-country_id',0);
		$region_id = Input::post('iso-region_id',0);
		$city_id = Input::post('iso-city_id',0);
		$address = Input::post('iso-address',0);
		if($clsClassTable->updateOne($table_id, array(
			'continent_id' => $continent_id,
			'country_id' => $country_id,
			'region_id' => $region_id,
			'city_id' => $city_id,
			'address' => $address
		))){
			$msg = '_success';
		}else{
			$msg = '_error';
		}
		
	}else if($currentstep=='star'){
		$star_id = Input::post('star_id');
		if($clsClassTable->updateOne($table_id, array(
			'star_id' => $star_id,
			'upd_date' => time()
		))){
			$msg = '_success';
		}else{
			$msg = '_error';
		}
	}else if($currentstep=='time_apply'){
		$booking_date_from = Input::post('booking_date_from',0);
		$booking_date_from=str_replace('/','-',$booking_date_from);
		$booking_date_from=strtotime($booking_date_from);
		
		$booking_date_to = Input::post('booking_date_to',0);
		$booking_date_to=str_replace('/','-',$booking_date_to);
		$booking_date_to=strtotime($booking_date_to);
		
		$travel_date_from = Input::post('travel_date_from',0);
		$travel_date_from=str_replace('/','-',$travel_date_from);
		$travel_date_from=strtotime($travel_date_from);
		
		$travel_date_to = Input::post('travel_date_to',0);
		$travel_date_to=str_replace('/','-',$travel_date_to);
		$travel_date_to=strtotime($travel_date_to);

		if($clsClassTable->updateOne($table_id, array(
			'booking_date_from' => $booking_date_from,
			'booking_date_to' => $booking_date_to,
			'travel_date_from' => $travel_date_from,
			'travel_date_to' => $travel_date_to,
			'upd_date' => time()
		))){
			$msg = '_success';
		}else{
			$msg = '_error';
		};
	}else if($currentstep=='addon_service'){
		
		$list_service_id=Input::post('list_service_id','');
		
		foreach($list_service_id as $item){
			$list_service[]=$item;
		}
		
		if($clsClassTable->updateOne($table_id, array(
			'list_service' => json_encode($list_service)
		))){
			$msg = '_success';
		}else{
			$msg = '_success';
		}
		;
	}else if($currentstep=='itinerary'){
		$number_day = Input::post('number_day',0);
		$number_night = Input::post('number_night',0);
		if($clsClassTable->updateOne($table_id, array(
			'number_day' => $number_day,
			'number_night' => $number_night,
			'upd_date' => time()
		))){
			$msg = '_success';
		}else{
			$msg = '_error';
		};
	}else if(in_array($currentstep,array(
			'itinerary',
			'highlight',
			'inclusion',
			'note',
			'condition_apply',
		))){
		$valueField = Input::post($currentstep);
		
		if($clsClassTable->updateOne($table_id, array(
			$currentstep => $valueField
		))){
			$msg = '_success';
		}else{
			$msg = '_error';
		}
	}else if($currentstep == 'seo'){
		$linkMeta = $clsClassTable->getLink($table_id);
		$clsClassTable = new Meta();
		
		$config_value_title = Input::post('config_value_title');
		$meta_id = Input::post('meta_id');
		$config_value_intro = Input::post('config_value_intro');
		$config_value_image = Input::post('isoman_url_image_seo');
		if(empty($meta_id)){
			
			if($clsClassTable->insert(array(
				'meta_id' => $clsClassTable->getMaxId(),
				'config_value_title' => $config_value_title,
				'config_link' => $linkMeta,
				'config_value_intro' => $config_value_intro,
				'image' => $config_value_image,
				'reg_date' => time(),
				'upd_date' => time()
			))){
				$msg = '_insert_success';
			}else{
				$msg = '_insert_error';
			}
		}else{
			if($clsClassTable->updateOne($meta_id, array(
				'config_value_title' => $config_value_title,
				'config_value_intro' => $config_value_intro,
				'image' => $config_value_image,
				'upd_date' => time()
			))){
				$msg = '_success';
			}else{
				$msg = '_error';
			}
		}
		
	}
	// Output
	echo $msg; die();
}
function default_check_table_code(){
	global $smarty,$core,$_frontIsLoggedin_user_id,$profile_id,$dbconn,$clsISO;
	global $profile_id, $_frontIsLoggedin_user_id;
	$clsClassTable= new Combo();
	
	$table_id = Input::post('table_id', 0);
	$table_code = Input::post('table_code');
	$cond = "is_trash=0 and combo_id<>'{$table_id}' and code='{$table_code}'";
	$totalItem = $clsClassTable->countItem($cond);
	echo ($totalItem==1?'_invalid':'_success'); die();
}
function default_ajDeleteCombo(){
	global $smarty,$core,$_frontIsLoggedin_user_id,$profile_id,$dbconn,$clsISO;
	global $profile_id, $_frontIsLoggedin_user_id;
	$clsClassTable= new Combo();
	
	$table_id = Input::post('combo_id', 0);
	if($clsClassTable->doDelete($table_id)){
		echo '/admin/?mod=combo'; die();
	}else{
		echo '_error'; die();
	}
	
}

function default_ajaxLoadComboRoom() {
    global $core,$mod,$act,$P;
    $clsCombo = new Combo();
    $clsComboRoom = new ComboRoom();
    #
    $combo_id = $_POST['combo_id'];
    $html = '';
    $lstRoom = $clsComboRoom->getAll("is_trash=0 and combo_id='$combo_id' order by order_no asc");
    if (!empty($lstRoom)) {
        $i = 0;
        foreach ($lstRoom as $item) {
			if($clsComboRoom->getNumberChild($item[$clsComboRoom->pkey])==0){
			$number_people=$clsComboRoom->getNumberAdult($item[$clsComboRoom->pkey]);
			}else{
			$number_people=$clsComboRoom->getNumberAdult($item[$clsComboRoom->pkey]).$clsComboRoom->getNumberChild($item[$clsComboRoom->pkey]);
			}
			
            $html.='<tr style="cursor:move" id="order_'.$item[$clsComboRoom->pkey].'"  class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $html.='<td class="text_left">'.$clsComboRoom->getTitleRoomType($item['room_stype_id']).'</td>';
            $html.='<td class="text_left">'.$clsComboRoom->getTitle($item[$clsComboRoom->pkey]).'</td>';
			$html.='<td class="text_left">'.$clsComboRoom->getNumberAdult($item[$clsComboRoom->pkey]).' '.$core->get_Lang('NL').', '.$clsComboRoom->getNumberChild($item[$clsComboRoom->pkey]).' '.$core->get_Lang('TE').'</td>';
			 $html.='<td class="text_center">'.$clsComboRoom->getNumberRoom($item[$clsComboRoom->pkey]).'</td>';
			 $html.='<td class="text_right">'.$clsComboRoom->getPrice($item[$clsComboRoom->pkey]).'</td>';
			$html.='<td></td>';
            $html.='
			<td align="center" style="vertical-align: middle; text-align:center; width:50px; white-space: nowrap;">
				<div class="btn-group-ico">
					<a title="'.$core->get_Lang('edit').'" href="'.PCMS_URL.'/?mod='.$mod.'&act=room&combo_id='.$core->encryptID($combo_id).'&hotel_room_id='.$core->encryptID($item[$clsComboRoom->pkey]).'"  data="'.$item[$clsComboRoom->pkey].'"><i class="ico ico-edit"></i></a>
					<a class="clickDeleteComboRoom" title="'.$core->get_Lang('delete').'" href="javascript:void();" data="'.$item[$clsComboRoom->pkey].'" combo_id="'.$combo_id.'"><i class="ico ico-remove"></i></a>
				</div>
            </td>';
            $html.='</tr>';
            ++$i;
        }
		$html.='
		<script type="text/javascript">
			$("#hotelRoomTable").sortable({
				opacity: 0.8,
				cursor: \'move\',
				start: function(){
					vietiso_loading(1);
				},
				stop: function(){
					vietiso_loading(0);
				},
				update: function(){
					var page = "'.$page.'";
					var order = $(this).sortable("serialize")+\'&update=update\';
					$.post(path_ajax_script+"/index.php?mod=hotel&act=ajUpdPosSortComboRoom", order, function(html){
						loadComboRoom();
						vietiso_loading(0);
					});
				}
			});
		</script>';
		

    }
    echo $html;
    die();
}
function default_ajUpdPosSortComboRoom(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsComboRoom = new ComboRoom();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key + 1);
		$clsComboRoom->updateOne($val,"order_no='".$key."'");	
	}
}
function default_loadCountryCombo() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
	$clsContinent = new Continent();
	$clsCountry = new Country();
	$continent_id = Input::post('continent_id', 0);
	$country_id = Input::post('country_id', 0);
    #
	$Html = $clsContinent->getOptCountryByContinent($continent_id, $country_id);
    echo $Html; die();
}
function default_loadArea() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsArea = new Area();
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    $area_id = isset($_POST['area_id']) ? $_POST['area_id'] : 0;
	
	$Html = '<option value="0">|---' . $core->get_Lang('select') . '--</option>';
    $lstArea = $clsArea->getAll("is_trash=0 and country_id='$country_id' order by order_no asc");
	if(is_array($lstArea) && count($lstArea) > 0){
		for($i=0; $i<count($lstArea); $i++){
			$Html .= '<option title="' .$clsArea->getTitle($lstArea[$i][$clsArea->pkey]). '" value="'.$lstArea[$i][$clsArea->pkey].'"'.($area_id==$lstArea[$i][$clsArea->pkey]?'selected="selected"':'').'>|--- ' . $clsArea->getTitle($lstArea[$i][$clsArea->pkey]) . '</option>';
		}
	}
	echo $Html; die();
}
function default_loadRegionCombo() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsRegion = new Region();
    $country_id = Input::post('country_id',0);
    $region_id = Input::post('region_id',0);
	#
	$Html = $clsRegion->makeSelectboxOption($country_id, $region_id);
	if($Html==''){
		echo 'EMPTY';
	}else{
		echo $Html;
	}
	die();
}
function default_loadCityCombo() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsCity = new City();
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    $region_id = isset($_POST['region_id']) ? $_POST['region_id'] : 0;
    $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;
	
	$cond = "is_trash=0 and is_online=1";
	if(intval($country_id)){
		$cond .= " and country_id='$country_id'";
	}
	if(intval($region_id) > 0){
		$cond .= " and region_id='$region_id'";
	}
	$cond .= " order by title ASC";
	#
    $Html = '<option value="0"> --' . $core->get_Lang('select') . '-- </option>';
    $listCity = $clsCity->getAll($cond, $clsCity->pkey);
	if(is_array($listCity) && count($listCity) > 0){
		for($i=0; $i<count($listCity); $i++){
			$Html .= '<option title="'.$clsCity->getTitle($listCity[$i][$clsCity->pkey]) . '" value="'.$listCity[$i][$clsCity->pkey].'" '.($city_id==$listCity[$i][$clsCity->pkey]?'selected="selected"':'').'>|--- ' . $clsCity->getTitle($listCity[$i][$clsCity->pkey]) . '</option>';
		}
	}
	unset($listCity);
	echo $Html; die();
}
function default_ajaxAddMoreComboDestination(){
	global $dbconn,$assign_list,$_CONFIG,$_SITE_ROOT,$mod,$_LANG_ID,$act,$core,$clsModule,$clsISO,$clsConfiguration;
	$clsCombo = new Combo();
	$clsComboDestination = new ComboDestination();
	#
	$combo_id = (int) Input::post('table_id', 0);
	$country_id = (int) Input::post('country_id', 0);
	$region_id = (int) Input::post('region_id', 0);
	$city_id = (int) Input::post('city_id', 0);
	#
	$cond = "is_trash=0 and combo_id='{$combo_id}'";
	if($country_id > 0) {$cond .= " and country_id='$country_id'";}
	if($region_id > 0) {$cond .= " and region_id='$region_id'";}
	if($city_id > 0) {$cond .= " and city_id='$city_id'";}
	
	$f="{$clsComboDestination->pkey},combo_id,country_id,region_id,city_id,order_no,val";
	$v="'".$clsComboDestination->getMaxID()."','{$combo_id}','{$country_id}','{$region_id}','{$city_id}','".$clsComboDestination->getMaxOrderNo($combo_id)."','1'";
	//$clsComboDestination->SetDebug(true);
	if($clsComboDestination->insertOne($f,$v)){
		echo '_SUCCESS'; die();
	}else{
		echo '_ERROR'; die();
	}
}
function default_ajaxDeleteComboDestination(){
	global $dbconn,$assign_list,$_CONFIG,$_SITE_ROOT,$mod,$_LANG_ID,$act,$core,$clsModule,$clsISO,$clsConfiguration;
	$user_id = $core->_USER['user_id'];
	#
	$clsComboDestination = new ComboDestination();
	$combo_destination_id = (int) Input::post('combo_destination_id', 0);
	#
	$clsComboDestination->deleteOne($combo_destination_id);
	// Return
	echo(1); die();
}
function default_ajaxLoadComboDestination(){
	global $dbconn,$assign_list,$_CONFIG,$_SITE_ROOT,$mod,$_LANG_ID,$act,$core,$clsModule,$clsISO,$clsConfiguration;
	$clsComboDestination = new ComboDestination();
	$clsContinent = new Continent();
	$clsCountry = new Country();
	$clsRegion = new Region();
	$clsCity = new City();
	$clsGuide = new Guide();
	$clsCombo = new Combo();
	#
	$table_id = (int) Input::post('table_id', 0);
	$openFrom = Input::post('openFrom', 'block');
	#
	$html = '';
	$lstDestination = $clsComboDestination->getAll("is_trash=0 and combo_id='{$table_id}' order by order_no asc");
	if(!empty($lstDestination)){
		foreach($lstDestination as $k=>$v){
			$title = '';
			if(intval($v['country_id']) > 0){
				$title.=$clsCountry->getTitle($v['country_id']);
			}
			if(intval($v['region_id']) > 0){
				$title.= ' &raquo; '.$clsRegion->getTitle($v['region_id']);
			}
			if(intval($v['city_id']) > 0){
				$title.= ' &raquo; '.$clsCity->getTitle($v['city_id']);
			}
			if(intval($v['placetogo_id']) > 0){
				$title.= ' &raquo; '.$clsGuide->getTitle($v['placetogo_id']);
			}
			$html.='<li id="order_'.$v[$clsComboDestination->pkey].'" style="cursor:move">
				<a title="'.$core->get_Lang('Drag & drop change position').'">'.$title.'</a>
				<span class="remove removeDestination" data="'.$v[$clsComboDestination->pkey].'">x</span>
			</li>';
		}
		if($openFrom=='block__'){
			$html .= '<li class="btn_remove ajRemoveAllDestinationInCombo  ui-sortable-unhandle">
				<i class="ico ico-remove"></i> '.$core->get_Lang('Removeall').'
			</li>';
		}
		$html.='<script type="text/javascript">
			$("#lstDestination").sortable({
				opacity: 1,
				cursor: \'move\',
				start: function(){vietiso_loading(1);},
				stop: function(){vietiso_loading(0);},
				update: function(){
					var order = $(this).sortable("serialize")+\'&update=update\';
					$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosComboDestination",order,function(html){
						vietiso_loading(0);
					});
				}
			}).disableSelection();
			$("#lstDestination").sortable({ cancel: \'.ui-sortable-unhandle\' });
		</script>';
		unset($lstDestination);
	}
	echo $html; die();
}
function default_ajaxLoadComboDestination2(){
	global $dbconn,$assign_list,$_CONFIG,$_SITE_ROOT,$mod,$_LANG_ID,$act,$core,$clsModule,$clsISO,$clsConfiguration;
	$clsComboDestination = new ComboDestination();
	$clsContinent = new Continent();
	$clsCountry = new Country();
	$clsRegion = new Region();
	$clsCity = new City();
	$clsGuide = new Guide();
	$clsCombo = new Combo();
	#
	$table_id = (int) Input::post('table_id', 0);
	$openFrom = Input::post('openFrom', 'block');
	#
	$html ='';
	$lstDestination = $clsComboDestination->getAll("is_trash=0 and combo_id='{$table_id}' order by order_no asc");
	if(!empty($lstDestination)){
		foreach($lstDestination as $k=>$v){
			$title = '';
			if(intval($v['city_id']) > 0){$title.=$clsCity->getTitle($v['city_id']);}if(intval($v['country_id']) > 0){$title.=', '.$clsCountry->getTitle($v['country_id']);}$html.=$title.'; ';
		}
		unset($lstDestination);
	}
	echo $html; die();
}


function default_ajaxLoadHotelItinerary(){
	global $_LANG_ID, $core;
	$clsHotel = new Hotel();
	$clsComboHotel = new ComboHotel();
	#
	$table_id = $_POST['table_id'];
	$combo_itinerary_id = $_POST['combo_itinerary_id'];
	#
	$lstItem=$clsComboHotel->getAll("table_id='$table_id' and combo_itinerary_id='$combo_itinerary_id' order by order_no ASC",$clsComboHotel->pkey.",hotel_id");
	if(is_array($lstItem) && count($lstItem)>0){
		$html = '';
		for($i=0; $i<count($lstItem);$i++){
			$html.= '<span class="hotelitem">';
			$html.='<strong>'. $clsHotel->getTitle($lstItem[$i][$clsHotel->pkey]).'</strong>';
			$html.='<a class="remove btn_delete_hotel_itinerary" _table_id="'.$table_id.'" _combo_itinerary_id="'.$combo_itinerary_id.'" data="'.$lstItem[$i][$clsComboHotel->pkey].'" tp="pop">x</a>';
			$html.='</span>';
			$html.= ($i==count($lstItem)-1)?'':', ';
		}
		echo $html; die();
	}else{
		echo '<strong class="color_r">'.$core->get_Lang('nodata').'</strong>'; die();
	}
}

function default_ajaxGetBoxHotelCombo(){
	global $assign_list,$_CONFIG,$_SITE_ROOT,$mod,$_LANG_ID,$act,$current_page,$core,$clsModule,$clsButtonNav,$dbconn,$clsISO,$clsConfiguration;
	#
	$clsPagination = new Pagination();
	$clsCountry = new Country();
	$clsHotel = new Hotel();$assign_list['clsHotel']=$clsHotel;
	$clsCombo = new Combo();$assign_list['clsCombo']=$clsCombo;
	$clsContinent = new Continent();
	#
	$table_id =Input::post('table_id',0);$assign_list['table_id']=$table_id;
	$hotel_id =Input::post('hotel_id',0);$assign_list['hotel_id']=$hotel_id;
	$tp =Input::post('tp','');$assign_list['tp']=$tp;
	
	
	
	$list_hotel = $clsCombo->getOneField('list_hotel', $table_id);
	$list_hotel = !empty($list_hotel) ? @json_decode($list_hotel, true) : array();
	
	$list_day_check=$list_hotel[$hotel_id];
	$assign_list['list_day_check']=$list_day_check;
	$total_day_check=count($list_day_check);
	$assign_list['total_day_check']=$total_day_check;
	
	$html=$core->build('modal.addhotel.tpl');
	echo $html; die();
	
	#
	$html='';
	$html.='
		<style type="text/css">.dataTable_length{display:none !important}</style>
		<div class="headPop"> 
			<a href="javascript:void();" class="closeEv close_pop"></a> 
			<h3>'.$core->get_Lang('List hotel in system').'</h3>
		</div>';
	$html.='<div class="wrap"><div class="searchbox fl" style="width:100%">';
	if($tour_type_id == 2 && $clsConfiguration->getValue('SiteModActive_continent') and $core->checkAccess('continent') && $clsConfiguration->getValue('SiteModActive_country') and $core->checkAccess('country')) {
		$html.='<select class="fl slb mr5" name="continenthotel_id" style="width:160px">'.$clsContinent->makeSelectboxOption().'</select>';
	}
	if($clsConfiguration->getValue('SiteModActive_country')) {
		$html.='<select class="fl slb mr5 country_id" name="countryhotel_id" style="width:160px">';
		$html.= $clsCountry->makeSelectboxOption(0,0,'HOTEL');
		$html.='</select>';
	} else {
		$html.='<script type="text/javascript">$().ready(function(){loadCityHotelList();});</script>';
	}
	$html.='<select class="fl slb mr5" name="cityhotel_id" style="width:160px">
				<option>-- '.$core->get_Lang('city').' --</option>
			</select>
			<input type="text" class="fl text mr5" name="keypop" placeholder="'.$core->get_Lang('search').'" style="width:160px;">
			<a href="javascript:void();" class="btn btn-success searchpop">
				<i class="icon-search icon-white"></i>
			</a>
		</div>
	</div>
	<div class="clear"><br/></div>';
	$html.='<div class="contentPop">';
	$html.='<style>.tbl-grid td{ padding:8px !important;}</style>
	<table class="tbl-grid" width="100%">
	<thead>
		<tr>
			<td class="gridheader"><input type="checkbox" id="check_all">
				<input type="hidden" id="list_selected_chkitem">
			</td>
			<td width="42%" class="gridheader" style="text-align:left"><strong>'.$core->get_Lang('nameofhotels').'</strong></td>
			<td class="gridheader" style="text-align:left"><strong>'.$core->get_Lang('Address').'</strong></td>
			<td width="3%" class="gridheader"><i class="icon-eye-open"></i></td>
		</tr>
	</thead>
	<tbody id="tblHolderHotel">';
	
	if(!empty($lstHotel)){
		for($i=0;$i<count($lstHotel);$i++){
			$html.='<tr class="'.($i%2==0?'row1':'row2').'">';
			$html.='
			<td class="index"><input value="'.$lstHotel[$i][$clsHotel->pkey].'" class="chkitem" type="checkbox" /></td>';
			$html.='<td>
				<a href="javascript:void(0);" style="font-size:16px; font-weight:bold;">'.$clsHotel->getTitle($lstHotel[$i][$clsHotel->pkey]).'</a>
				</td>';
			$html.='<td>'.$clsHotel->getAddress($lstHotel[$i][$clsHotel->pkey]).'</td>
					<td width="3%"><a href="'.DOMAIN_NAME.$clsHotel->getLink($lstHotel[$i][$clsHotel->pkey]).'" target="_blank"><i class="icon-eye-open"></i></a></td>';	

			$html.='</tr>';
		}
		unset($lstHotel);
		unset($clsHotel);
	}
	$html.='
		</tbody></table>
		<div class="clear"><br /></div>
	</div>
	<div class="pagination_box">
		<div class="wrap" id="dataTable_paginate">'.$pageview.'</div>
	</div>';
	$html.='
	<div class="bottom">
		<input type="hidden" id="hid_table_id" value="'.$table_id.'" />
		<input type="hidden" id="hid_itinerary_id" value="'.$combo_itinerary_id.'" />
		<a href="javascript:void();" tour_hotel_id="'.$tour_hotel_id.'" table_id="'.$table_id.'" combo_itinerary_id="'.$combo_itinerary_id.'" class="iso-button-primary fl btnChooiseHotel"><i class="icon-check icon-white"></i> '.$core->get_Lang('save').'</a>
		<a class="iso-button-standard close_pop fr"><i class="icon icon-cancel"></i> '.$core->get_Lang('close').'</a></div>
	</div>';
	echo $html; die();
}
function default_ajGetHotelCombo(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	
	
	$clsHotel= new Hotel();
	$clsComboDestination= new ComboDestination();
	$keyword=Input::post('keyword','');
	$table_id=Input::post('table_id',0);
	$check=Input::post('check','');
	
	if($check=='Hidden'){
		echo '_EMPTY'; die();
	}
	
	
	$listComboDestination=$clsComboDestination->getAll("combo_id='$table_id' order by order_no ASC");
	$where_country='';
	$where_region='';
	$where_city='';
	foreach ($listComboDestination as $item){
		if(!empty($item['country_id'])){
			$where_country = ($where_country == '' ? '' : $where_country . ',') . $item['country_id'];
		}
		if(!empty($item['region_id'])){
		$where_region = ($where_region == '' ? '' : $where_region . ',') . $item['region_id'];
		}
		if(!empty($item['city_id'])){
		$where_city = ($where_city == '' ? '' : $where_city . ',') . $item['city_id'];
		}
	}
	

	#
	
	$where = "is_trash=0 and is_online=1";
	if(!empty($where_country)){
		$where .= " and country_id IN ($where_country)";
	}
	
	if(!empty($where_region)){
		$where .= " and region_id IN ($where_region)";
	}
	
	if(!empty($where_city)){
		$where .= " and city_id IN ($where_city)";
	}
	
	
	if(!empty($keyword)){
		$slug = $core->replaceSpace($keyword);
		$where.=" and (hotel_id='".$keyword."' or slug like '%".$slug."%')";
	}
	
	$limit = " limit 0,1000";
	#
	$lstItem = $clsHotel->getAll($where.$limit);
	if(is_array($lstItem) && count($lstItem) > 0){
		foreach($lstItem as $k=>$v){
			$html.='
			<li class="clickChooseHotel" data-title="'.$clsHotel->getTitle($v[$clsHotel->pkey]).'" tp="'.$tp.'" data-hotel_id="'.$v[$clsHotel->pkey].'" type="add">
				<a href="javascript:void(0);" title="Click để chọn hotel này">'.$clsHotel->getTitle($v[$clsHotel->pkey]).'</a>	
			</li>';
		}
	}else{
		$html .= '_EMPTY';
	}
	echo $html; die();
}


function default_ajSaveHotelCombo(){
	global $assign_list,$_CONFIG,$_SITE_ROOT,$mod,$act;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO;
	$clsCombo = new Combo();
	$user_id = $core->_USER['user_id'];
	$combo_id = Input::post('combo_id',0);
	$hotel_id = Input::post('hotel_id',0);
	$listDay = Input::post('listDay','');
	
	
	$tp = Input::post('tp','SAVE');
	
	$list_hotel = $clsCombo->getOneField('list_hotel', $combo_id);
	$list_hotel = !empty($list_hotel) ? json_decode($list_hotel, true) : array();
	
	
	if($tp=='DEL'){
		unset($list_hotel[$hotel_id]);
	}elseif($tp=='EDIT'){
		if(empty($listDay)){
			echo 'ERROR_DAY'; die();
		}else{
			$list_hotel[$hotel_id]=array();
			foreach($listDay as $key=>$value){
				$list_hotel[$hotel_id][$key]=$value;
			}
		}
	}else{
		if(empty($listDay)){
			echo 'ERROR_DAY'; die();
		}elseif(empty($hotel_id)){
			echo 'ERROR_HOTEL'; die();
		}else{
			foreach($listDay as $key=>$value){
				$list_hotel[$hotel_id][]=$value;
			}
		}
	}
	$clsCombo->updateOne($combo_id, array(
		'list_hotel' => json_encode($list_hotel)
	));
	
	echo(1); die();
}


function default_ajaxLoadHotelCombo(){
	global $_LANG_ID, $core, $clsISO,$assign_list;
	$clsPagination = new Pagination();
	$clsCombo = new Combo();$assign_list['clsCombo']=$clsCombo;
	$clsHotel = new Hotel();$assign_list['clsHotel']=$clsHotel;
	$html='';
	#
	
	$table_id =Input::post('table_id',0);
	$list_hotel = $clsCombo->getOneField('list_hotel', $table_id);
	$list_hotel = !empty($list_hotel) ? @json_decode($list_hotel, true) : array();
	$assign_list['list_hotel']=$list_hotel;
	$assign_list['combo_id']=$table_id;
	$html=$core->build('load_list_hotel.tpl');

	echo $html; die();
}

function default_ajaxLoadComboPriceTable(){
	global $_LANG_ID, $core, $clsISO,$assign_list;
	$clsPagination = new Pagination();
	$clsCombo = new Combo();$assign_list['clsCombo']=$clsCombo;
	$clsHotel = new Hotel();$assign_list['clsHotel']=$clsHotel;
	$clsHotelRoom = new HotelRoom();$assign_list['clsHotelRoom']=$clsHotelRoom;
	$html='';
	#
	
	$table_id =Input::post('table_id',0);
	$list_hotel = $clsCombo->getOneField('list_hotel', $table_id);
	$list_hotel = !empty($list_hotel) ? @json_decode($list_hotel, true) : array();
	$assign_list['list_hotel']=$list_hotel;

	$assign_list['combo_id']=$table_id;
	$html=$core->build('load.combopricetable.tpl');

	echo $html; die();
}
function default_ajSaveComboPriceTable(){
	global $assign_list,$_CONFIG,$_SITE_ROOT,$mod,$act;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO;
	$clsCombo = new Combo();
	$clsHotel = new Hotel();
	$clsHotelRoom = new HotelRoom();
	$user_id = $core->_USER['user_id'];
	$combo_id = Input::post('combo_id',0);
	$hotel_id = Input::post('hotel_id',0);
	$hotel_room_id = Input::post('hotel_room_id',0);
	
	$price=Input::post('price_room',0);
	$price=str_replace('.','',$price);
	$price=$price?$price:$clsHotelRoom->getOneField('price',$hotel_room_id);
	
	$val = Input::post('val',0);
	$tp = Input::post('tp','');

	
	
	$info_price_table = $clsCombo->getOneField('info_price_table', $combo_id);
	$info_price_table = !empty($info_price_table) ? json_decode($info_price_table, true) : array();
	if($tp=='ALL_ROOM'){
		if($val==0){
			unset($info_price_table[$hotel_id]);
		}else{
			$listRoom=$clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no asc",$clsHotelRoom->pkey.',price');
			$info_price_table[$hotel_id]=array();
			foreach($listRoom as $item){
				$info_price_table[$hotel_id][$item['hotel_room_id']]['price']=$item['price'];
			}
			//print_r($info_price_table); die();
		}
	}elseif($tp=='CHOOSE'){
		if($val==0){
			unset($info_price_table[$hotel_id][$hotel_room_id]);
		}else{
			$info_price_table[$hotel_id][$hotel_room_id]=array();
			$info_price_table[$hotel_id][$hotel_room_id]['price']=$price;
		}
	}else{
		$info_price_table[$hotel_id][$hotel_room_id]=array();
		$info_price_table[$hotel_id][$hotel_room_id]['price']=$price;
	}

	$clsCombo->updateOne($combo_id, array(
		'info_price_table' => json_encode($info_price_table)
	));
	
	echo(1); die();
}

function default_ajAddComboExtension(){
	global $assign_list,$_CONFIG,$_SITE_ROOT,$mod,$act;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO;
	$clsCombo = new Combo();
	$user_id = $core->_USER['user_id'];
	$combo_id = Input::post('combo_id',0);
	$combo_related_id = Input::post('combo_related_id',0);
	$tp = Input::post('tp','SAVE');
	
	$list_combo_related = $clsCombo->getOneField('list_combo_related', $combo_id);
	$list_combo_related = !empty($list_combo_related) ? json_decode($list_combo_related, true) : array();
	
	
	if($tp=='DEL'){
		$del = array_search($combo_related_id, $list_combo_related);
		array_splice($list_combo_related, $del, 1);
	}elseif($tp=='SAVE'){
		if(empty($combo_related_id)){
			echo 'ERROR_COMBO'; die();
		}else{
			array_unshift($list_combo_related, $combo_related_id);
		}
	}
	$list_combo_related=array_unique($list_combo_related);
	if($clsCombo->updateOne($combo_id, array(
		'list_combo_related' => json_encode($list_combo_related)
	))){
		echo(1); die();
	}else{
		echo(0); die();
	}
}
function default_ajUpdPosSortComboExtension(){  
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsCombo = new Combo();
	$combo_id =Input::post('combo_id',0);
	$order = Input::post('order','');
	$list_combo_related = array();
	//print_r($order);die('xxx');
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $item){
		array_push($list_combo_related,$item);  
	}
	if($clsCombo->updateOne($combo_id, array(
		'user_update_id' => addslashes($core->_SESS->user_id),
		'upd_date' => time(),
		'list_combo_related' => json_encode($list_combo_related)
	))){
		echo '_SUCCESS'; die();
	}else{
		echo '_ERROR'; die();
	}
}

function default_ajLoadComboExtension(){
	global $_LANG_ID, $core, $clsISO,$assign_list;
	$clsPagination = new Pagination();
	$clsCombo = new Combo();$assign_list['clsCombo']=$clsCombo;
	$html='';
	#
	
	$table_id =Input::post('table_id',0);
	$list_combo_related = $clsCombo->getOneField('list_combo_related', $table_id);
	$list_combo_related = !empty($list_combo_related) ? @json_decode($list_combo_related, true) : array();
	$assign_list['list_combo_related']=$list_combo_related;
	$assign_list['combo_id']=$table_id;
	$html=$core->build('load.listcomborelated.tpl');
	
	
	
	echo $html; die();
}


function default_ajaxDeleteHotelItinerary(){
	global $_LANG_ID, $core;
	$clsComboHotel = new ComboHotel();
	$tour_hotel_id = $_POST['tour_hotel_id'];
	#
	$clsComboHotel->deleteOne($tour_hotel_id);
	echo(1); die();
}

function default_SiteFrmComboItinerary(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO,$package_id;
	
	$user_id = $core->_USER['user_id'];
	#
	$clsCombo = new Combo();
	$clsComboItinerary = new ComboItinerary();
	$clsTransport = new Transport();
	$assign_list["clsTransport"] = $clsTransport;
	$combo_itinerary_id = isset($_POST['combo_itinerary_id']) ? intval($_POST['combo_itinerary_id']):0;
	$table_id = isset($_POST['table_id']) ? intval($_POST['table_id']):0;
	if(intval($combo_itinerary_id) > 0) {
		$oneItem = $clsComboItinerary->getOne($combo_itinerary_id);
	}
	$tp = isset($_POST['tp'])?$_POST['tp']:'';

	if($number_day>$number_night){
		$limit=$number_day;
	}elseif($number_day==$number_night){
		$limit=$number_day+1;
	}else{
		$limit=10;
	}
	if($tp == 'L') {
			ini_set('display_errors',1);
error_reporting(E_ALL & ~E_STRICT);//E_ALL
		if($clsCombo->getOneField('duration_type',$table_id) == 0){
			$lstItem = $clsComboItinerary->getAll("is_trash=0 and table_id='$table_id'  and title_contingency='' order by order_no asc limit 0,$limit", $clsComboItinerary->pkey.',day,day2,reg_date');
			
		}else{
			$lstItem = $clsComboItinerary->getAll("is_trash=0 and table_id='$table_id'  and title_contingency='' order by order_no asc", $clsComboItinerary->pkey.',day,day2,reg_date');
		}
		$html='';
		//$clsISO->print_pre($lstItem,true);
		//die();
		if(!empty($lstItem)){
			for($i=0, $max=count($lstItem); $i<$max; $i++){
				$html.='<tr style="cursor:move" id="order_'.$lstItem[$i][$clsComboItinerary->pkey].'" day2="'.$lstItem[$i]['day2'].'" class="'.($i%2==0?'row1':'row2').'">';
				if($clsCombo->getOneField('duration_type',$table_id) == 0){
					if($clsCombo->getOneField('number_day',$table_id) == 1 && $clsCombo->getOneField('number_night',$table_id) <= 1){
						$html.='<th class="day"><span>'.$core->get_Lang('Full day').'</span></th>';
					}elseif($lstItem[$i]['day']==0){
						$html.='<th class="day index"><span>'.$core->get_Lang('Setting').'</span></th>';
					}else{
						$html.='<th class="day index"><span>'.$lstItem[$i]['day'].''.($lstItem[$i]['day2']>$lstItem[$i]['day']? '-'.$lstItem[$i]['day2']:'').'</span></th>';
					}	
				}
				$html.='
				<td class="hiden_responsive" style="width: 40px"></td>
				<td class="name_service">'.$clsComboItinerary->getTitle($lstItem[$i][$clsComboItinerary->pkey]).'
				</td>';
				$html.='<td data-title="'.$core->get_Lang('Meals').'" class="text-left block_responsive border_top_responsive">'.$clsComboItinerary->getMeal($lstItem[$i][$clsComboItinerary->pkey],1).'</td>';
				$html.='
				<td  data-title="'.$core->get_Lang('func').'" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 50px; white-space: nowrap;">
					<div class="btn-group-ico">
						<a class="clickEditItinerary" title="'.$core->get_Lang('edit').'" href="javascript:void();" data="'.$lstItem[$i][$clsComboItinerary->pkey].'"><i class="ico ico-edit"></i></a>
						<a class="clickDeleteItinerary" title="'.$core->get_Lang('delete').'" href="javascript:void();" data="'.$lstItem[$i][$clsComboItinerary->pkey].'"><i class="ico ico-remove"></i></a>
					</div>
				</td>';
			}
		} else {
			$html.= '<tr><td colspan="12">
				<div class="message" style="text-align:center">'.$core->get_Lang('no record found in here').'</div>
			</td></tr>';
		}
		$html.='<script type="text/javascript">
			$("#tblComboItinerary").sortable({
				opacity: 0.8,
				cursor: \'move\',
				start: function(){
					vietiso_loading(1);
				},
				stop: function(){
					vietiso_loading(0);
				},
				update: function(){
					var order = $(this).sortable("serialize")+\'&update=update\';
					$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosComboItinerary", order, function(html){
						loadComboItinerary(table_id);
						vietiso_loading(0);
					});
				}
			});
			$(".toggle-row").click(function() {
				var $_this = $(this);
				if($_this.parents("tr").hasClass("open_tr")){
					$_this.closest("tr").removeClass("open_tr");
					$_this.closest("tr").find(".fa-caret").removeClass("fa-caret-up");
				}else{
					$_this.parents("tr").addClass("open_tr");
					$_this.closest("tr").find(".fa-caret").addClass("fa-caret-up");
				}
			});	
		</script>';
		echo $html; die();
	} elseif($tp == 'F') {
		$html = '';
		$html.='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($combo_itinerary_id==0?$core->get_Lang('Add Combo Itinerary'):$core->get_Lang('Edit Combo Itinerary')).'- [ID #'.$table_id.']</h3>
		</div>';
		$html .= '
		<form method="post" id="frmItinerary" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="fr full_width_991">
					<div class="photobox image center_991">
						<img src="'.($combo_itinerary_id > 0?$clsComboItinerary->getOneField('image',$combo_itinerary_id):'').'" id="isoman_show_image_itinerary" />
						<input type="hidden" id="isoman_hidden_image_itinerary" name="isoman_url_image" value="'.($combo_itinerary_id > 0?$clsComboItinerary->getOneField('image',$combo_itinerary_id):'').'" />
						<a href="javascript:void(0);" title="'.$core->get_Lang('Change').'" class="photobox_edit ajOpenDialog" isoman_for_id="image_itinerary" isoman_val="'.($combo_itinerary_id > 0?$clsComboItinerary->getOneField('image',$combo_itinerary_id):'').'" isoman_name="image"><i class="iso-edit"></i></a>
						'.($clsComboItinerary->getOneField('image',$combo_itinerary_id) != '' ? '<a pvalTable="'.$combo_itinerary_id.'" clsTable="ComboItinerary" href="javascript:void()" title="'.$core->get_Lang('delete').'" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>' : '') . '
					</div>
					<div class="wrap mt10 boxShowImages">
						<p class="text-center"><strong>'.$core->get_Lang('Image Size').' (WxH=204x134)</strong></p>
						<p class="text-center">
							<label>
								<input type="radio" class="margin_0" name="is_show_image" value="0" checked="checked" /> OFF
							</label>
							<label>
								<input type="radio" class="margin_0" name="is_show_image" value="1" '.($oneItem['is_show_image']==1?'checked="checked"':'').' /> ON
							</label>
						</p>
					</div>
				</div>
				<div class="fl full_width_991" style="width:76%">
					<div class="row-span">';
						if($clsCombo->getOneField('duration_type',$table_id)==1){
						$html .= '<div class="fieldlabel bold text-right text_left_767"><strong>'.$core->get_Lang('Itinerary name').'</strong> <span class="color_r">*</span></div>';
						}else{
						$html .= '<div class="fieldlabel bold text-right text_left_767"><strong>'.$core->get_Lang('day').'</strong> <span class="color_r">*</span></div>';	
						}
						$html .= '<div class="fieldarea">';
							if($clsCombo->getOneField('duration_type',$table_id)==1){
								$html .= '<input type="text" name="title" class="text_32 border_aaa fontLarge full-width title_capitalize" id="title" value="'.$clsComboItinerary->getOneField('title',$combo_itinerary_id).'"  />';
							}else{
							$html .= '<input class="text_32 border_aaa required" style="width:60px;float:left" value="'.($combo_itinerary_id==0?$clsComboItinerary->getMaxDay($table_id):$clsComboItinerary->getOneField('day',$combo_itinerary_id)).'" name="day" type="number" min="1" max="'.$clsCombo->getOneField('number_day',$table_id).'"><span style="width:20px; display:inline-block; text-align:center; float:left; line-height:32px"> -> </span>
							<input class="text_32 border_aaa required" style="width:60px;float:left" min="0" max="'.$clsCombo->getOneField('number_day',$table_id).'" value="'.($combo_itinerary_id==0?$clsComboItinerary->getMaxDay($table_id):$clsComboItinerary->getOneField('day2',$combo_itinerary_id)).'" name="day2" type="number">
							<input type="text" name="title" class="text_32 border_aaa fontLarge titleDay title_capitalize full_width_767 mt10_767" id="title" value="'.$clsComboItinerary->getOneField('title',$combo_itinerary_id).'"  />';
							}
						$html .= '</div>
					</div>
					<div class="row-span" style="display:none">
						<div class="fieldlabel bold text-right text_left_767"><span class="color_r">*'.$core->get_Lang('daytrip').'</span></div>
						<div class="fieldarea"><input type="text" name="date_title" class="text full fontLarge " id="date_title" value="'.$clsComboItinerary->getOneField('date_title',$combo_itinerary_id).'" /></div>
					</div>';
					if($clsConfiguration->getValue('SiteComboAPI')){
						$html.='
						<div class="row-span">
							<div class="fieldlabel bold text-right text_left_767" style="text-align:right">
								<strong>'.$core->get_Lang('meal').'</strong> <span class="color_r">*</span>
							</div>
							<div class="fieldarea">
								'.$clsComboItinerary->getMeal($combo_itinerary_id,1).'
							</div>
						</div>';
					}else{
						$lstMeal = $clsCombo->getListMeal();
						if(!empty($lstMeal)){
						$html.='
						<div class="row-span">
							<div class="fieldlabel bold text-right text_left_767" style="text-align:right">
								<strong>'.$core->get_Lang('meal').'</strong> <span class="color_r">*</span> 
								<input type="checkbox" class="checkall_checkbox" group="meal" title="'.$core->get_Lang('selectall').'" style="cursor:pointer;" />
							</div>
							<div class="fieldarea">
								<div style="border:1px solid #d7d7d7;width:100%;padding:3px 10px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;">';
								
								
									foreach($lstMeal as $item){
										$html.='<label class="mr20"><input type="checkbox" '.($clsComboItinerary->checkMealExist($item[$clsComboProperty->pkey],$combo_itinerary_id)?'checked="checked"':'').' name="meal[]" class="chk_Meal checkitem_checkbox" group="meal" value="'.$item[$clsComboProperty->pkey].'"> '.$clsComboProperty->getTitle($item[$clsComboProperty->pkey]).'</label>';
									}	
						$html.='				
								</div>
							</div>
						</div>';
						}	
					}
					if($clsISO->getCheckActiveModulePackage($package_id,'property','transport','default')){
						$lstItem = $clsCombo->getListTransport();
						if(!empty($lstItem)){
						$html.='<div class="row-span">
						<div class="fieldlabel bold text-right text_left_767" style="text-align:right">
							<strong>'.$core->get_Lang('transport').'</strong> <span class="color_r">*</span> 
							<input type="checkbox" class="checkall_checkbox" group="transport" title="'.$core->get_Lang('selectall').'" style="cursor:pointer;" />
						</div>
						<div class="fieldarea">
							<div style="border:1px solid #d7d7d7;padding:3px 10px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px; max-height:56px; overflow:auto">';
							
							foreach ($lstItem as $k => $v) {
								$html.='
								<label class="mr20">
									<input type="checkbox" name="transport[]" '.($combo_itinerary_id > 0 ? ($clsComboItinerary->checkTransportExist($v[$clsTransport->pkey],$combo_itinerary_id)?'checked="checked"':'') : '').' class="checkitem_checkbox chk_Transport" group="transport" value="'.$v[$clsTransport->pkey].'"> '.$clsTransport->getTitle($v[$clsTransport->pkey]).'
								</label>';
							}	
						$html.='</div>
							</div>
						</div>';
						}
					}
					
					$html.='<div class="row-span">
						<div class="fieldlabel" style="text-align:right;font-weight:700">'.$core->get_Lang('Short text').'</div>
						<div class="fieldarea">
							<textarea rows="5" cols="255" id="textarea_itinerary_content_editor_'.time().'" class="textarea_itinerary_content_editor" style="width:100%">'.$clsComboItinerary->getContent($combo_itinerary_id).'</textarea>
						</div>
					</div>
					'.($combo_itinerary_id > 0 && $clsISO->getCheckActiveModulePackage($package_id,'tour','hotel','customize')  && $clsISO->getCheckActiveModulePackage($package_id,'hotel','default','default') ? '
					<div class="row-span" style="border:1px dashed #c00000; padding:1%; width:100%;">
						<div class="fieldlabel" style="font-weight:700">'.$core->get_Lang('Accommodation').' <button type="button" table_id="'.$table_id.'" combo_itinerary_id="'.$combo_itinerary_id.'" tour_hotel_id="0" class="iso-button-small ajaxOpenChoiceHotel">...</button></div>
						<div class="fieldarea"><div id="lstHotel"></div></div>
					</div>
					':'').'
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="submit" combo_itinerary_id="'.$combo_itinerary_id.'" class="btn btn-primary btnSaveComboItinerary">
				<i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span>
			</button>
		</div>';
		echo($html);die();
	} elseif($tp == 'S') {
		$dayPost = isset($_POST['day']) ? $_POST['day']:0;
		$dayPost2 = isset($_POST['day2']) ? $_POST['day2']:0;
		$titlePost = isset($_POST['title']) ? ucwords($_POST['title']):'';
		$slugPost = $core->replaceSpace($titlePost);
		$mealsPost = isset($_POST['meals'])?$_POST['meals']:'';
		$transportPost = isset($_POST['transport'])?$_POST['transport']:'';
		$transport_id = isset($_POST['transport_id'])?$_POST['transport_id']:0;
		$contentPost = isset($_POST['content']) ? $_POST['content']:'';
		$imagePost = isset($_POST['image']) ? $_POST['image']:'';
		$dateTitlePost = isset($_POST['date_title']) ? $_POST['date_title']:'';
		$is_show_image = isset($_POST['is_show_image']) ? intval($_POST['is_show_image']): 0;
		#
		if($combo_itinerary_id > 0) {
			
			$cond_check="table_id='$table_id' and combo_itinerary_id<>'$combo_itinerary_id' and day='$dayPost'";
			if($dayPost2 >0){
				$cond_check.=" and day2='$dayPost2'";
			}
			if($clsComboItinerary->getAll($cond_check)!=''){
				echo 'day_invalid'; die();	
			}elseif($dayPost > $limit || $dayPost2 >$limit){
				echo 'day_invalid'; die();
			} 
			$v = "user_id_update='$user_id',day='$dayPost',day2='$dayPost2',title='$titlePost',slug='$slugPost',content='".addslashes($contentPost)."',transport='$transportPost',upd_date='".time()."',image='$imagePost',transport_id='$transport_id',date_title='$dateTitlePost',is_show_image='$is_show_image'";
			if(!$clsConfiguration->getValue('SiteComboAPI')){
				$v .= ",meals='$mealsPost'";
			}
			#
			if($clsComboItinerary->updateOne($combo_itinerary_id,$v)){
				echo '_UPDATE_SUCCESS'; die();
			}else{
				echo '_ERROR'; die();
			}	
		} else {
			if($clsComboItinerary->getAll("table_id='$table_id' and day='$dayPost'")!=''){
				echo 'day_invalid'; die('111');
			}elseif($dayPost > $limit){
				echo 'day_invalid'; die('2222');
			} else {
				$max_id = $clsComboItinerary->getMaxID();
				$fx ="$clsComboItinerary->pkey,user_id,user_id_update,day,table_id,title,slug,content,transport";
				$fx.=",reg_date,upd_date,image,transport_id,order_no,date_title,is_show_image,title_contingency";
				$vx ="'".$max_id."','$user_id','$user_id','$dayPost','$table_id','$titlePost','$slugPost','".addslashes($contentPost)."','$transportPost','".time()."','".time()."','".addslashes($imagePost)."','$transport_id','".$clsComboItinerary->getMaxOrderNo()."','".$dateTitlePost."','".$is_show_image."',''";
				if(!$clsConfiguration->getValue('SiteComboAPI')){
					$fx .= ",meals";
					$vx .= ",'$mealsPost'";
				}
				#
				if($clsComboItinerary->insertOne($fx,$vx)){
					echo '_INSERT_SUCCESS'; die();
				}else{
					echo '_ERROR'; die();
				}
			}
		}
	} elseif($tp == 'M') {
		$direct = isset($_POST['direct'])?$_POST['direct']:'';
		$one = $clsComboItinerary->getOne($combo_itinerary_id);
		$dayCombo = $one['day'];
		
		$cond = "is_trash=0 and title_contingency='' and table_id=".$table_id;
		if($direct=='moveup'){
			$lst = $clsComboItinerary->getAll($cond." and day < $dayCombo order by day desc limit 0,1");
			$clsComboItinerary->updateOne($combo_itinerary_id,"day='".$lst[0]['day']."'");
			$clsComboItinerary->updateOne($lst[0][$clsComboItinerary->pkey],"day='".$dayCombo."'");
		}
		if($direct=='movedown'){
			$lst = $clsComboItinerary->getAll($cond." and day > $dayCombo order by day asc limit 0,1");
			$clsComboItinerary->updateOne($combo_itinerary_id,"day='".$lst[0]['day']."'");
			$clsComboItinerary->updateOne($lst[0][$clsComboItinerary->pkey],"day='".$dayCombo."'");
		}
		if($direct=='movetop'){
			$lst = $clsComboItinerary->getAll($cond." and day < $dayCombo order by day desc");
			$clsComboItinerary->updateOne($combo_itinerary_id,"day='".$lst[count($lst)-1]['day']."'");
			$lstItem = $clsComboItinerary->getAll($cond." and combo_itinerary_id <> '$combo_itinerary_id' and day < $dayCombo order by day asc");
			for($i=0;$i<count($lstItem);$i++) {
				$clsComboItinerary->updateOne($lstItem[$i][$clsComboItinerary->pkey],"day='".($lstItem[$i]['day']+1)."'");	
			}
		}
		if($direct=='movebottom'){
			$lst = $clsComboItinerary->getAll($cond." and day > $dayCombo order by day asc");
			$clsComboItinerary->updateOne($combo_itinerary_id,"day='".$lst[count($lst)-1]['day']."'");
			$lstItem = $clsComboItinerary->getAll($cond." and $combo_itinerary_id <> '$combo_itinerary_id' and day > $dayCombo order by day asc");
			for($i=0;$i<count($lstItem);$i++) {
				$clsComboItinerary->updateOne($lstItem[$i][$clsComboItinerary->pkey],"day='".($lstItem[$i]['day']-1)."'");	
			}
		}
		echo(1); die();
	} elseif($tp == 'D') {
		$clsComboItinerary->doDelete($combo_itinerary_id);
		echo(1); die();
	}
}

function default_SiteFrmComboItineraryContingency(){
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO,$package_id;
    #
    $clsCombo = new Combo();
    $clsComboItinerary = new ComboItinerary();
    $clsTransport = new Transport();
    $assign_list["clsTransport"] = $clsTransport;
    $combo_itinerary_id = isset($_POST['combo_itinerary_id']) ? intval($_POST['combo_itinerary_id']):0;
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']):0;
    if(intval($combo_itinerary_id) > 0) {
        $oneItem = $clsComboItinerary->getOne($combo_itinerary_id);
    }
    $tp = isset($_POST['tp'])?$_POST['tp']:'';


    if($tp == 'L') {
//        $number_day=$clsCombo->getOneField('number_day',$table_id);
//        $number_night=$clsCombo->getOneField('number_night',$table_id);
//        if($number_day>$number_night){
//            $limit=$number_day;
//        }else{
//            $limit=$number_night;
//        }
//        if($clsCombo->getOneField('duration_type',$table_id) == 0){
//            $lstItem = $clsComboItinerary->getAll("is_trash=0 and table_id='$table_id' order by order_no asc limit 0,$limit", $clsComboItinerary->pkey.',day,day2,reg_date');
//        }else{
//            $lstItem = $clsComboItinerary->getAll("is_trash=0 and table_id='$table_id' order by order_no asc", $clsComboItinerary->pkey.',day,day2,reg_date');
//        }
        $lstItem = $clsComboItinerary->getAll("is_trash=0 and table_id='$table_id' and title_contingency!='' order by order_no asc", $clsComboItinerary->pkey.',title_contingency,reg_date');
        $html='';
        //$clsISO->print_pre($lstItem,true);
        //die();
        if(!empty($lstItem)){
            for($i=0, $max=count($lstItem); $i<$max; $i++){
                $html.='<tr style="cursor:move" id="order_'.$lstItem[$i][$clsComboItinerary->pkey].'" class="'.($i%2==0?'row1':'row2').'">';
                $html.='<th class="day"><span>'.$clsComboItinerary->getTitleContingency($lstItem[$i][$clsComboItinerary->pkey]).'</span></th>';
                $html.='<td class="name_service">
					<strong style="font-size:15px;">'.$clsComboItinerary->getTitle($lstItem[$i][$clsComboItinerary->pkey]).'</strong>
					<div class="clearfix mt5"></div>
					'.($clsISO->getCheckActiveModulePackage($package_id,'tour','hotel','customize') && $clsISO->getCheckActiveModulePackage($package_id,'hotel','default','default') && $clsComboItinerary->getItineraryHotel($table_id, $lstItem[$i][$clsComboItinerary->pkey],1) ? '<strong class="color_r">'.$core->get_Lang('hotels').'</strong>: '.$clsComboItinerary->getItineraryHotel($table_id, $lstItem[$i][$clsComboItinerary->pkey]).'':'').'
					<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
				</td>';
                $html.='<td data-title="'.$core->get_Lang('Meals').'" class="text-right block_responsive border_top_responsive">'.strtoupper($clsComboItinerary->getMeal($lstItem[$i][$clsComboItinerary->pkey],1)).'</td>';
                $html.='
				<td  data-title="'.$core->get_Lang('func').'" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a class="clickEditItineraryContingency" title="'.$core->get_Lang('edit').'" href="javascript:void();" data="'.$lstItem[$i][$clsComboItinerary->pkey].'"><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
							<li><a class="clickDeleteItineraryContingency" title="'.$core->get_Lang('delete').'" href="javascript:void();" data="'.$lstItem[$i][$clsComboItinerary->pkey].'"><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
						</ul>
					</div>
				</td>';
            }
        } else {
            $html.= '<tr><td colspan="12">
				<div class="message" style="text-align:center">'.$core->get_Lang('no record found in here, please use').' <a style="text-decoration:underline" href="javascript:void(0);" id="clickToAddItinerary_contingency">'.$core->get_Lang('Add New').'</a></div>
			</td></tr>';

        }
        $html.='<script type="text/javascript">
			$("#tblComboItinerary_contingency").sortable({
				opacity: 0.8,
				cursor: \'move\',
				start: function(){
					vietiso_loading(1);
				},
				stop: function(){
					vietiso_loading(0);
				},
				update: function(){
					var order = $(this).sortable("serialize")+\'&update=update\';
					$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosComboItinerary", order, function(html){
						loadComboItinerary(table_id);
						vietiso_loading(0);
					});
				}
			});
			$(".toggle-row").click(function() {
				var $_this = $(this);
				if($_this.parents("tr").hasClass("open_tr")){
					$_this.closest("tr").removeClass("open_tr");
					$_this.closest("tr").find(".fa-caret").removeClass("fa-caret-up");
				}else{
					$_this.parents("tr").addClass("open_tr");
					$_this.closest("tr").find(".fa-caret").addClass("fa-caret-up");
				}
			});	
		</script>';
        echo $html; die();
    } elseif($tp == 'F') {
        $html = '';
        $html.='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($combo_itinerary_id==0?$core->get_Lang('Add Combo Itinerary Contingency'):$core->get_Lang('Edit Combo Itinerary Contingency')).'- [ID #'.$table_id.']</h3>
		</div>';
        $html .= '
		<form method="post" id="frmItinerary" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="fr full_width_991">
					<div class="photobox image center_991">
						<img src="'.($combo_itinerary_id > 0?$clsComboItinerary->getOneField('image',$combo_itinerary_id):'').'" id="isoman_show_image_itinerary" />
						<input type="hidden" id="isoman_hidden_image_itinerary" name="isoman_url_image" value="'.($combo_itinerary_id > 0?$clsComboItinerary->getOneField('image',$combo_itinerary_id):'').'" />
						<a href="javascript:void(0);" title="'.$core->get_Lang('Change').'" class="photobox_edit ajOpenDialog" isoman_for_id="image_itinerary" isoman_val="'.($combo_itinerary_id > 0?$clsComboItinerary->getOneField('image',$combo_itinerary_id):'').'" isoman_name="image"><i class="iso-edit"></i></a>
						'.($clsComboItinerary->getOneField('image',$combo_itinerary_id) != '' ? '<a pvalTable="'.$combo_itinerary_id.'" clsTable="ComboItinerary" href="javascript:void()" title="'.$core->get_Lang('delete').'" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>' : '') . '
					</div>
					<div class="wrap mt10 boxShowImages">
						<p class="text-center"><strong>'.$core->get_Lang('Image Size').' (WxH=204x134)</strong></p>
						<p class="text-center">
							<label>
								<input type="radio" class="margin_0" name="is_show_image" value="0" checked="checked" /> OFF
							</label>
							<label>
								<input type="radio" class="margin_0" name="is_show_image" value="1" '.($oneItem['is_show_image']==1?'checked="checked"':'').' /> ON
							</label>
						</p>
					</div>
				</div>
				<div class="fl full_width_991" style="width:76%">
					<div class="row-span">';
        $html .= '<div class="fieldlabel bold text-right text_left_767"><strong>'.$core->get_Lang('day').'</strong> <span class="color_r">*</span></div>';
        $html .= '<div class="fieldarea">';

        $html .= '<input class="text_32 border_aaa required" style="width:140px;float:left" value="'.$clsComboItinerary->getOneField('title_contingency',$combo_itinerary_id).'" name="title_contingency">
							<input type="text" name="title" class="text_32 border_aaa fontLarge titleDay title_capitalize full_width_767 mt10_767" id="title" value="'.$clsComboItinerary->getOneField('title',$combo_itinerary_id).'"  />';

        $html .= '</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel bold text-right text_left_767" style="text-align:right">
							<strong>'.$core->get_Lang('meal').'</strong> <span class="color_r">*</span> 
							<input type="checkbox" class="checkall_checkbox" group="meal" title="'.$core->get_Lang('selectall').'" style="cursor:pointer;" />
						</div>
						<div class="fieldarea">
							<div style="border:1px solid #d7d7d7;width:100%;padding:3px 10px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;">';
        $lstMeal = $clsCombo->getListMeal();
							if(!empty($lstMeal)){
								foreach($lstMeal as $item){
									$html.='<label class="mr20"><input type="checkbox" '.($clsComboItinerary->checkMealExist($item[$clsComboProperty->pkey],$combo_itinerary_id)?'checked="checked"':'').' name="meal[]" class="chk_Meal checkitem_checkbox" group="meal" value="'.$item[$clsComboProperty->pkey].'"> '.$clsComboProperty->getTitle($item[$clsComboProperty->pkey]).'</label>';
								}	
							}
        $html.='				</div>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel bold text-right text_left_767" style="text-align:right">
							<strong>'.$core->get_Lang('transport').'</strong> <span class="color_r">*</span> 
							<input type="checkbox" class="checkall_checkbox" group="transport" title="'.$core->get_Lang('selectall').'" style="cursor:pointer;" />
						</div>
						<div class="fieldarea">
							<div style="border:1px solid #d7d7d7;padding:3px 10px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px; max-height:56px; overflow:auto">';
        $lstItem = $clsCombo->getListTransport();
        if(!empty($lstItem)){
            foreach ($lstItem as $k => $v) {
                $html.='
									<label class="mr20">
										<input type="checkbox" name="transport[]" '.($combo_itinerary_id > 0 ? ($clsComboItinerary->checkTransportExist($v[$clsTransport->pkey],$combo_itinerary_id)?'checked="checked"':'') : '').' class="checkitem_checkbox chk_Transport" group="transport" value="'.$v[$clsTransport->pkey].'"> '.$clsTransport->getTitle($v[$clsTransport->pkey]).'
									</label>';
            }
        }

        $html.='				</div>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right;font-weight:700">'.$core->get_Lang('Short text').'</div>
						<div class="fieldarea">
							<textarea rows="5" cols="255" id="textarea_itinerary_content_editor_'.time().'" class="textarea_itinerary_content_editor" style="width:100%">'.$clsComboItinerary->getContent($combo_itinerary_id).'</textarea>
						</div>
					</div>
					'.($combo_itinerary_id > 0 && $clsISO->getCheckActiveModulePackage($package_id,'tour','hotel','customize') && $clsISO->getCheckActiveModulePackage($package_id,'hotel','default','default') ? '
					<div class="row-span" style="border:1px dashed #c00000; padding:1%; width:100%;">
						<div class="fieldlabel" style="font-weight:700">'.$core->get_Lang('Accommodation').' <button type="button" table_id="'.$table_id.'" combo_itinerary_id="'.$combo_itinerary_id.'" tour_hotel_id="0" class="iso-button-small ajaxOpenChoiceHotel">...</button></div>
						<div class="fieldarea"><div id="lstHotel"></div></div>
					</div>
					':'').'
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="submit" combo_itinerary_id="'.$combo_itinerary_id.'" class="btn btn-primary btnSaveComboItineraryContingency">
				<i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span>
			</button>
		</div>';
        echo($html);die();
    } elseif($tp == 'S') {
        $dayPost = isset($_POST['day']) ? $_POST['day']:0;
        $dayPost2 = isset($_POST['day2']) ? $_POST['day2']:0;
        $titlePost = isset($_POST['title']) ? ucwords($_POST['title']):'';
        $slugPost = $core->replaceSpace($titlePost);
        $mealsPost = isset($_POST['meals'])?$_POST['meals']:'';
        $transportPost = isset($_POST['transport'])?$_POST['transport']:'';
        $transport_id = isset($_POST['transport_id'])?$_POST['transport_id']:0;
        $contentPost = isset($_POST['content']) ? $_POST['content']:'';
        $imagePost = isset($_POST['image']) ? $_POST['image']:'';
        $dateTitlePost = isset($_POST['date_title']) ? $_POST['date_title']:'';
        $title_contingency = isset($_POST['title_contingency']) ? $_POST['title_contingency']:'';
        $is_show_image = isset($_POST['is_show_image']) ? intval($_POST['is_show_image']): 0;
        #
//        var_dump($_POST);die();
        if($combo_itinerary_id > 0) {
//            if($clsComboItinerary->countItem("table_id='$table_id' and day='$dayPost' and day2='$dayPost2' and combo_itinerary_id<>'$combo_itinerary_id'")>0){
//                echo 'day_invalid'; die();
//            }
            $v = "user_id_update='$user_id',day='$dayPost',day2='$dayPost2',title='$titlePost',slug='$slugPost',content='".addslashes($contentPost)."',transport='$transportPost',meals='$mealsPost',upd_date='".time()."',image='$imagePost',transport_id='$transport_id',date_title='$dateTitlePost',title_contingency='$title_contingency',is_show_image='$is_show_image'";
            #




            if($clsComboItinerary->updateOne($combo_itinerary_id,$v)){
                echo '_UPDATE_SUCCESS'; die();
            }else{
                echo '_ERROR'; die();
            }
        } else {
//            if($clsComboItinerary->countItem("table_id='$table_id' and day='$dayPost'")>0){
//                echo 'day_invalid'; die();
//            } else {
            $max_id = $clsComboItinerary->getMaxID();
            $fx ="$clsComboItinerary->pkey,user_id,user_id_update,day,table_id,title,slug,content,meals,transport";
            $fx.=",reg_date,upd_date,image,transport_id,order_no,date_title,title_contingency,is_show_image";
            $vx ="'".$max_id."','$user_id','$user_id','$dayPost','$table_id','$titlePost','$slugPost','".addslashes($contentPost)."','$mealsPost','$transportPost','".time()."','".time()."','".addslashes($imagePost)."','$transport_id','".$clsComboItinerary->getMaxOrderNo()."','".$dateTitlePost."','".$title_contingency."','".$is_show_image."'";
            #
            if($clsComboItinerary->insertOne($fx,$vx)){
                echo '_INSERT_SUCCESS'; die();
            }else{
                echo '_ERROR'; die();
            }
//            }
        }
    } elseif($tp == 'M') {
        $direct = isset($_POST['direct'])?$_POST['direct']:'';
        $one = $clsComboItinerary->getOne($combo_itinerary_id);
        $dayCombo = $one['day'];

        $cond = "is_trash=0 and title_contingency!='' and table_id=".$table_id;
        if($direct=='moveup'){
            $lst = $clsComboItinerary->getAll($cond." and day < $dayCombo order by day desc limit 0,1");
            $clsComboItinerary->updateOne($combo_itinerary_id,"day='".$lst[0]['day']."'");
            $clsComboItinerary->updateOne($lst[0][$clsComboItinerary->pkey],"day='".$dayCombo."'");
        }
        if($direct=='movedown'){
            $lst = $clsComboItinerary->getAll($cond." and day > $dayCombo order by day asc limit 0,1");
            $clsComboItinerary->updateOne($combo_itinerary_id,"day='".$lst[0]['day']."'");
            $clsComboItinerary->updateOne($lst[0][$clsComboItinerary->pkey],"day='".$dayCombo."'");
        }
        if($direct=='movetop'){
            $lst = $clsComboItinerary->getAll($cond." and day < $dayCombo order by day desc");
            $clsComboItinerary->updateOne($combo_itinerary_id,"day='".$lst[count($lst)-1]['day']."'");
            $lstItem = $clsComboItinerary->getAll($cond." and combo_itinerary_id <> '$combo_itinerary_id' and day < $dayCombo order by day asc");
            for($i=0;$i<count($lstItem);$i++) {
                $clsComboItinerary->updateOne($lstItem[$i][$clsComboItinerary->pkey],"day='".($lstItem[$i]['day']+1)."'");
            }
        }
        if($direct=='movebottom'){
            $lst = $clsComboItinerary->getAll($cond." and day > $dayCombo order by day asc");
            $clsComboItinerary->updateOne($combo_itinerary_id,"day='".$lst[count($lst)-1]['day']."'");
            $lstItem = $clsComboItinerary->getAll($cond." and $combo_itinerary_id <> '$combo_itinerary_id' and day > $dayCombo order by day asc");
            for($i=0;$i<count($lstItem);$i++) {
                $clsComboItinerary->updateOne($lstItem[$i][$clsComboItinerary->pkey],"day='".($lstItem[$i]['day']-1)."'");
            }
        }
        echo(1); die();
    } elseif($tp == 'D') {
        $clsComboItinerary->doDelete($combo_itinerary_id);
        echo(1); die();
    }
}

function default_ajUpdPosComboItinerary(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsCombo = new Combo();
	$clsComboItinerary = new ComboItinerary();
	$order = $_POST['order'];
	foreach($order as $key=>$val){
		$key = $key+1;
		$clsComboItinerary->updateOne($val,"order_no='".$key."'");	
	}
}
function default_ajGetSearch(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsCombo = new Combo();
	$table_id =Input::post('table_id',0);
	$keyword =Input::post('keyword','');
	$check =Input::post('check','');
	$html = '';
	
	if($check=='Hidden'){
		$html .= '_EMPTY';
		echo $html; die();
	}
	#
	$where = "is_trash=0 and is_online=1 and combo_id<>'$table_id'";
	if(trim($keyword) !='' && $keyword != '0'){
		$slug = $core->replaceSpace($keyword);
		$where .= " and (title like '%$keyword%' or slug like '%$slug%')";
	}
	$limit = " limit 0,1000";
	#
	$lstItem = $clsCombo->getAll($where.$limit);
	if(is_array($lstItem) && count($lstItem) > 0){
		foreach($lstItem as $k=>$v){
			$html.='
			<li class="clickChooseCombo" data-title="'.$clsCombo->getTitle($v[$clsCombo->pkey]).'" data-combo_id="'.$v[$clsCombo->pkey].'" type="add">
				<a href="javascript:void(0);" title="Click để chọn combo này">'.$clsCombo->getTitle($v[$clsCombo->pkey]).'</a>	
			</li>';
		}
	}else{
		$html .= '_EMPTY';
	}
	echo $html; die();
}
?>