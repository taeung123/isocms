<?php
function getFrame($country_id=null){
	global $core,$dbconn,$_LANG_ID,$clsISO;
	$frames = array(
		'overview' => array(
			'href_group'	=> 'overview',
			'name'	=> $core->get_Lang('Overview'),
			'icon'	=> 'home',
			'steps' => array(	
				'basic' => array(
					'name' => $core->get_Lang('Basic')
				),		
				'image' => array(
					'name' => $core->get_Lang('Image cover')
				),
				'shortText' => array(
					'name' => $core->get_Lang('Short text')
				),	
				'longText' => array(
					'name' => $core->get_Lang('Long text')
				)
			)
		),
	);
	$frames['seo'] = array(
		'name'	=> $core->get_Lang('seosdvanced'),
		'href_group'	=> 'seo',
		'icon'	=> '',
		'steps'	=> array(
			'seo' => array(
					'name' =>  $core->get_Lang('seosdvanced')
				)
		)
	);
	
	return $frames;
}
function default_insert() {
//	ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,$pvalTable,
	$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration,$adult_type_id,$child_type_id,$infant_type_id,$show,$nextstep;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
	$show=isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list["show"] = $show;
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';

	
	$pvalTable =Input::get('service_id',0);$assign_list["pvalTable"] = $pvalTable;
	$panel =Input::get('panel','');$assign_list["panel"] = $panel;

	$currentstep =Input::get('step','basic');
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
	

    $classTable = "Service";
    $clsClassTable = new $classTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
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
	
	if($currentstep=='seo'){
		$clsMeta = new Meta();
		$assign_list["clsMeta"] = $clsMeta;
		$linkMeta = $clsClassTable->getLink($pvalTable);
		$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
		$meta_id = $allMeta[0]['meta_id'];
		
		if(empty($meta_id)){
			$introMeta=strip_tags(html_entity_decode(addslashes($oneItem['overview'])));
			$introMeta=explode('$trun$', wordwrap($introMeta, 280, '$trun$', false), 2);
			$introMeta=$introMeta[0] . (isset($introMeta[1]) ? '...' : '');
			$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id","'".$linkMeta."','".$oneItem['title']."','".$introMeta."','".$oneItem['image']."','".time()."','".time()."','".$clsMeta->getMaxId()."'");
		}
	}
//	$clsClassTable->updateMinPrice($pvalTable);
	
}


function default_getMainFormStep(){
	global $smarty,$assign_list,$_frontIsLoggedin_user_id,$core,$clsISO,$clsProperty,$clsUser,$_company_iom_id,$dbconn,$nextstep,$clsConfiguration,$mod,$package_id,$pvalTable;
	$clsService = new Service(); $smarty->assign('clsClassTable', $clsService);
	$clsCountry = new Country(); $smarty->assign('clsCountry', $clsCountry);
	$clsContinent = new Continent(); $smarty->assign('clsContinent', $clsContinent);
	
	
	#
	$table_id = Input::post('table_id',0);
	$currentstep = Input::post('currentstep','');
	$tableName = $clsService->tbl;
    $pkeyTable = $clsService->pkey;
	
	$oneItem =$clsService->getOne($table_id);
	$smarty->assign('pvalTable',$table_id);
	$smarty->assign('oneItem',$oneItem);
	$smarty->assign('clsTable','Service');
	$smarty->assign('clsTableGal','ServiceImage');
	
	$frames = getFrame();
	#Step follow index
	$ii = 0; $arrStep = array();
	foreach($frames as $okey => $frame){
		$steps = $frame['steps'];
		foreach($steps as $key => $step){
			$status = 0;
			if($key == 'basic' && $oneItem['title'] !='' && $oneItem['cat_id'] > 0){
				$status = 1;
			}
			if($key == 'image' && $oneItem['image'] !=''){
				$status = 1;
			}
			if($key == 'shortText' && $oneItem['intro'] !=''){
				$status = 1;
			}
			if($key == 'longText' && $oneItem['content'] !=''){
				$status = 1;
			}
			if($key == 'seo'){
				$clsMeta = new Meta();
				$link = $clsService->getLink($table_id);
				$oneMeta = $clsMeta->getAll("config_link='$link' limit 0,1",$clsMeta->pkey.',config_value_title,config_value_intro,image');
				if(!empty($oneMeta) && $oneMeta[0]['config_value_title'] != '' && $oneMeta[0]['config_value_intro'] != '' && $oneMeta[0]['image'] != ''){
					$status = 1;	
				}				
			}
			$arrStep[$ii] = array(
				'key' => $key,
				'panel' => $okey,
				'name' => $step['name'],
				'status' => $status,
//				'description' => $step['description']
			);
			++$ii;
		}
	}
	
	$clsServiceCategory = new ServiceCategory(); $assign_list['clsServiceCategory'] = $clsServiceCategory;
	
	$smarty->assign('arrStep',$arrStep);
	$smarty->assign('list_check_target',json_encode($arrStep));
	if($currentstep=='seo'){
		$clsMeta = new Meta();
		$assign_list["clsMeta"] = $clsMeta;
		$linkMeta = $clsService->getLink($table_id);
		$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
		$meta_id = $allMeta[0]['meta_id'];

		if(empty($meta_id)){
			
			$introMeta=strip_tags(html_entity_decode(addslashes($oneItem['intro'])));
			$introMeta=explode('$trun$', wordwrap($introMeta, 280, '$trun$', false), 2);
			$introMeta=$introMeta[0] . (isset($introMeta[1]) ? '...' : '');
			$meta_id=$clsMeta->getMaxId();
			$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id","'".$linkMeta."','".$oneItem['title']."','".$introMeta."','".$oneItem['image']."','".time()."','".time()."','".$meta_id."'");

		}
		$smarty->assign('meta_id',$meta_id);
	} else if($currentstep == 'lhdl'){

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
    $clsForm->addInputTextArea("full", "country_booking_policy", "", "country_booking_policy", 255, 25, 15, 1, "style='width:100%'");
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
	$clsClassTable= new Service();
	$table_id = Input::post('table_id',0);
	$currentstep = Input::post('currentstep');
	$arr_update = [
		'user_id_update' => addslashes($core->_SESS->user_id),
		'upd_date' => time()
	];
	if($currentstep=='basic'){
		$title = Input::post('title');	
		$slug = $core->replaceSpace($title);
        
        $listItem=$clsClassTable->getAll("slug='$slug'",$clsClassTable->pkey);
        if(!empty($listItem)){
           $msg = '_EXIST';
           // Output
           echo $msg; die(); 
        }
		$arr_update['title'] = $title;
		$arr_update['slug'] = $slug;		
		foreach($_POST as $key=>$val){
			$tmp = explode('-',$key);
			if($tmp[0]=='iso'){
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
		if ($clsConfiguration->getValue('SiteHasCat_Service')) {
			$clsServiceCategory = new ServiceCategory();
			$cat_id      = Input::post('iso-cat_id');
			$list_cat_id = $clsServiceCategory->getListParent($cat_id);
			$arr_update['list_cat_id'] = addslashes($list_cat_id);
		}
		$clsClassTable->setDeBug(1);
		$clsClassTable->updateOne($table_id, $arr_update);
	} else if($currentstep=='image'){
		$image = Input::post('image','');
		$arr_update['image'] = addslashes($image);
		$clsClassTable->updateOne($table_id, $arr_update);
	}else if($currentstep == 'shortText'){
		$intro = Input::post('iso-intro','');
		$arr_update['intro'] = $intro;
		$clsClassTable->updateOne($table_id, $arr_update);
	} else if($currentstep == 'longText'){
		$content = Input::post('iso-content');
		$content = html_entity_decode($content);
		$content= preg_replace_callback('#(<img\s(?>(?!src=)[^>])*?src=")nodata...image/([a-z]+);base64,([\w=+/]++)("[^>]*>)#', "data_upload_image_word_textarea", $content);
		$content= preg_replace_callback('#(<img\s(?>(?!src=)[^>])*?src=")data:image/(gif|png|jpeg);base64,([\w=+/]++)("[^>]*>)#', "data_upload_image_word_textarea", $content);
		$arr_update['content'] = $content;
		$clsClassTable->updateOne($table_id, $arr_update);
	} else if($currentstep == 'seo'){
		$clsClassTable = new Meta();
		
		$config_value_title = Input::post('config_value_title');
		$meta_id = Input::post('meta_id');
		$config_value_intro = Input::post('config_value_intro');
		$config_value_image = Input::post('isoman_url_image_seo');
		if(empty($meta_id)){
			$clsClassTable->updateOne($table_id, array(
				'star_id' => $star_id,
				'upd_date' => time()
			));
		}else{
			$clsClassTable->updateOne($meta_id, array(
				'config_value_title' => $config_value_title,
				'config_value_intro' => $config_value_intro,
				'image' => $config_value_image,
				'upd_date' => time()
			));
		}

	} else{
		$val_post = input::post();
		$arr_update = [];
		foreach($val_post as $key=>$val){
			$tmp = explode('-',$key);
			if($tmp[0]=='iso'){
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
//		var_dump($arr_update);die;
		$clsClassTable->updateOne($table_id, $arr_update);
	}
	$msg = '_success';
	// Output
	echo $msg; die();
}

function default_ajActionNewService() {
//	ini_set('display_errors', '1');
//	ini_set('display_startup_errors', '1');
//	error_reporting(E_ALL);
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,
	$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration,$adult_type_id,$child_type_id,$infant_type_id,$clsISO,$package_id;
    $user_id = $core->_USER['user_id'];
    #
	$clsService = new Service();
    $assign_list["clsService"] = $clsService;
    $tp = Input::post('tp');
	$is_day_trip = Input::post('is_day_trip', 0);

	$service_id = $clsService->getMaxId();
	$title_voucher_new=$core->get_Lang('New Service').' '.$service_id;
    $results = array('result'=>'error');
    if($tp = 'S'){
		$clsISO->UpdateOrderNo('Country');
		$max_order = $clsService->getMaxOrderNo();
		$field = $clsService->pkey.",user_id,user_id_update,title,slug,order_no,reg_date,upd_date";
		$value = "'".$service_id."','".$user_id."','".$user_id."','".$title_voucher_new."','".$core->replaceSpace($title_voucher_new)."',1,'".time()."','".time()."'";
        $clsService->insertOne($field,$value);
        $results = array('result'=>'success','link'=>'service/insert/'.$service_id.'/overview');
    }
	// Return
    echo @json_encode($results);die();
}
?>