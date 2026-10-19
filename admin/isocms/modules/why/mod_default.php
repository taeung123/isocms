<?php
function getFrame($why_id=null){
	global $core,$dbconn,$_LANG_ID,$clsISO;
	$frames = array(
		'overview' => array(
			'href_group'	=> 'overview',
			'name'	=> $core->get_Lang('Overview'),
			'icon'	=> 'home',
			'steps' => array(
				'why' => array(
					'name' => $core->get_Lang('Why')
				)
			)
		),
	);
	
	
	return $frames;
}
function default_insert() {
//	ini_set('display_errors', '1');
//	ini_set('display_startup_errors', '1');
//	error_reporting(E_ALL);
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,$pvalTable,
	$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration,$adult_type_id,$child_type_id,$infant_type_id,$show,$nextstep;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
	$show=isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list["show"] = $show;
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';

	
	$pvalTable =Input::get('why_id',0);$assign_list["pvalTable"] = $pvalTable;
	$panel =Input::get('panel','');$assign_list["panel"] = $panel;

	$currentstep =Input::get('step','why');
	$assign_list["currentstep"] = $currentstep;
	
	$currentstepx = 0;
	$frames = getFrame($pvalTable);
	//$clsISO->pre($oneTour);die;
	$ii = 0; $arrStep = array();
	foreach($frames as $okey => $frame){
		$steps = $frame['steps'];
		foreach($steps as $key => $step){
			$status = 0;
			$arrStep[$ii] = array(
				'key' => $key,
				'name' => $step['name'],
				'status' => $status
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
	

    $classTable = "Why";
    $clsClassTable = new $classTable;
	$cond = $clsClassTable->pkey."='".$pvalTable."'";
	$urlRe = PCMS_URL.'/?mod='.$mod;
    $allItem = $clsClassTable->getAll($cond);
	if(!$allItem){
		header('location: '.$urlRe);
	}
    $oneItem = $allItem[0];
    $assign_list["oneItem"] = $oneItem;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
	
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	
	$clsForm->addInputTextArea("full",'intro', "", 'intro', 255, 25, 5, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full",'easy_cancel', "", 'easy_cancel', 255, 25, 5, 1,  "style='width:100%'"); 
//	$clsClassTable->updateMinPrice($pvalTable);
	
}


function default_getMainFormStep(){
//		ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
	global $smarty,$assign_list,$_frontIsLoggedin_user_id,$core,$clsISO,$clsProperty,$clsUser,$_company_iom_id,$dbconn,$nextstep,$clsConfiguration,$mod,$package_id,$pvalTable,$package_id;
	$clsWhy = new Why();
	
	#
	$table_id = Input::post('table_id',0);
	$currentstep = Input::post('currentstep','');
	$type = Input::post('type',''); $assign_list["type"] = $type;
	$cat_id = Input::post('cat_id',0); $assign_list["cat_id"] = $cat_id;
	$cond = $clsWhy->pkey."='".$table_id."'";
	if($type != ''){
		$cond .= "and type='".$type."'";
	}
	if($cat_id > 0){
		$cond .= "and cat_id='".$cat_id."'";
	}
	$allItem = $clsWhy->getAll($cond);
    $oneItem = $allItem[0];
//	$oneItem =$clsWhy->getOne($table_id);
	$tableName = $clsWhy->tbl;
    $pkeyTable = $clsWhy->pkey;
	$classTable                     = "Why";
	$assign_list["classTable"] = $classTable;
	$assign_list["clsClassTable"] = $clsWhy;
    $assign_list["pkeyTable"] = $pkeyTable;
	$smarty->assign('pvalTable',$table_id);
	$smarty->assign('oneItem',$oneItem);
	
	$frames = getFrame();
	#Step follow index
	$ii = 0; $arrStep = array();
	foreach($frames as $okey => $frame){
		$steps = $frame['steps'];
		foreach($steps as $key => $step){
			$arrStep[$ii] = array(
				'key' => $key,
				'panel' => $okey,
				'name' => $step['name']
			);
			++$ii;
		}
	}
	
	$smarty->assign('arrStep',$arrStep);
	
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
	$nextstep = isset($arrStep[$step+1]['key']) ? $arrStep[$step+1]['key'] : '_last';
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
    $clsForm->addInputTextArea("full", "blog_booking_policy", "", "blog_booking_policy", 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", "child_policy", "", "child_policy", 255, 25, 2, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", "cancellation_policy", "", "cancellation_policy", 255, 25, 2, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "other_policy", "", "other_policy", 255, 25, 8, 1, "style='width:100%'");
	
	#
	
	// Output
	$html = $core->build('main_step.tpl');
	echo $html; die();
}
function default_ajSaveMainStep(){
//	ini_set('display_errors', '1');
//	ini_set('display_startup_errors', '1');
//	error_reporting(E_ALL);
	global $_frontIsLoggedin_user_id,$core,$clsISO,$clsProperty,$clsUser,$_company_iom_id,$dbconn,$clsConfiguration;
	#
	$msg = '_error';
	$clsClassTable= new Why();
	$table_id = Input::post('table_id',0);
	$currentstep = Input::post('currentstep');
	if($currentstep=='why'){
		$title = Input::post('title');	
        $title=html_entity_decode($title);
        $slug=$clsISO->replaceSpace2($title);
		$image = Input::post('isoman_url_image','');		
		$arr_update = [
			'title' 			=> ucwords($title),
			'slug'				=> $slug,
			'upd_date' 			=> time(),
			'image' 			=> $image,
			'user_id_update'	=>	addslashes($core->_SESS->user_id)
		];
		
		foreach($_POST as $key=>$val){
			$tmp = explode('-',$key);
			if($tmp[0]=='iso'){
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
		$clsClassTable->updateOne($table_id, $arr_update);
		
	} else{
		$val_post = input::post();
		$arr_update = [];
		foreach($val_post as $key=>$val){
			$tmp = explode('-',$key);
			if($tmp[0]=='iso'){
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
		$clsClassTable->updateOne($table_id, $arr_update);
	}
	$msg = '_success';
	// Output
	echo $msg; die();
}
function default_loadCountry() {
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
function default_loadRegion() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsRegion = new Region();
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    $region_id = isset($_POST['region_id']) ? $_POST['region_id'] : 0;
	#
	$Html = $clsRegion->makeSelectboxOption($country_id, $region_id);
	if($Html==''){
		echo 'EMPTY';
	}else{
		echo $Html;
	}
	die();
}
function default_loadCity() {
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


function default_ajActionNewWhy() {
//	ini_set('display_errors', '1');
//	ini_set('display_startup_errors', '1');
//	error_reporting(E_ALL);
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,
	$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration,$adult_type_id,$child_type_id,$infant_type_id,$clsISO,$package_id;
    $user_id = $core->_USER['user_id'];
    #
	$clsWhy = new Why();
    $assign_list["clsWhy"] = $clsWhy;
    $tp = Input::post('tp');

	$why_id = $clsWhy->getMaxId();
	$title_voucher_new=$core->get_Lang('New Why').' '.$why_id;
    $results = array('result'=>'error');
    if($tp = 'S'){
		$clsISO->UpdateOrderNo('Why');
		
		$field = $clsWhy->pkey.",title,intro,order_no,is_trash,is_online,type,image";
		$value = "'".$why_id."','".$title_voucher_new."','',1,0,1,'',''";
//		$clsWhy->setDeBug(1);
        $clsWhy->insertOne($field,$value);
        
       	$link = 'why/insert/'.$why_id.'/overview';
		
        $results = array('result'=>'success','link'=>$link);
    }
	// Return
    echo @json_encode($results);die();
}
?>