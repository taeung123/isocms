<?php
function getFrame($meta_id = null)
{
	global $core, $dbconn, $_LANG_ID, $clsISO;
	$frames = array(
		'overview' => array(
			'href_group'	=> 'overview',
			'name'	=> $core->get_Lang('Overview'),
			'icon'	=> 'home',
			'steps' => array(
				'meta' => array(
					'name' => $core->get_Lang('Meta')
				)
			)
		),
	);

	return $frames;
}
function default_insert()
{
	//	ini_set('display_errors', '1');
	//	ini_set('display_startup_errors', '1');
	//	error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core, $pvalTable,
		$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $show, $nextstep;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list["show"] = $show;
	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';


	$pvalTable = Input::get('meta_id', 0);
	$assign_list["pvalTable"] = $pvalTable;
	$panel = Input::get('panel', '');
	$assign_list["panel"] = $panel;

	$currentstep = Input::get('step', 'meta');
	$assign_list["currentstep"] = $currentstep;

	$currentstepx = 0;
	$frames = getFrame($pvalTable);
	//$clsISO->pre($oneTour);die;
	$ii = 0;
	$arrStep = array();
	foreach ($frames as $okey => $frame) {
		$steps = $frame['steps'];
		foreach ($steps as $key => $step) {
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
	$nextstep = $arrStep[$currentstepx + 1];
	$assign_list["frames"] = $frames;
	$assign_list["nextstep"] = $nextstep;


	$classTable = "Meta";
	$clsClassTable = new $classTable;
	$oneItem = $clsClassTable->getOne($pvalTable);



	$config_link_Post = $oneItem['config_link'];
	$config_link_Post = str_replace(DOMAIN_NAME, '', $config_link_Post);


	$config_value_title_Post = $oneItem['config_value_title'];




	//	var_dump($oneItem);die;
	$assign_list["oneItem"] = $oneItem;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;

	$clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 5, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full", 'easy_cancel', "", 'easy_cancel', 255, 25, 5, 1,  "style='width:100%'");

	if ($currentstep == 'seo') {
		$clsMeta = new Meta();
		$assign_list["clsMeta"] = $clsMeta;
		$linkMeta = $clsClassTable->getLink($pvalTable);
		$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
		$meta_id = $allMeta[0]['meta_id'];

		if (empty($meta_id)) {
			$introMeta = strip_tags(html_entity_decode(addslashes($oneItem['overview'])));
			$introMeta = explode('$trun$', wordwrap($introMeta, 280, '$trun$', false), 2);
			$introMeta = $introMeta[0] . (isset($introMeta[1]) ? '...' : '');
			$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id", "'" . $linkMeta . "','" . $oneItem['title'] . "','" . $introMeta . "','" . $oneItem['image'] . "','" . time() . "','" . time() . "','" . $clsMeta->getMaxId() . "'");
		}
	}
	//	$clsClassTable->updateMinPrice($pvalTable);

}


function default_getMainFormStep()
{
	//		ini_set('display_errors', '1');
	//ini_set('display_startup_errors', '1');
	//error_reporting(E_ALL);
	global $smarty, $assign_list, $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $nextstep, $clsConfiguration, $mod, $package_id, $pvalTable, $package_id;
	$clsMeta = new Meta();

	#
	$table_id = Input::post('table_id', 0);
	$currentstep = Input::post('currentstep', '');
	$oneItem = $clsMeta->getOne($table_id);
	$tableName = $clsMeta->tbl;
	$pkeyTable = $clsMeta->pkey;
	$classTable                     = "Meta";
	$assign_list["classTable"] = $classTable;
	$assign_list["clsClassTable"] = $clsMeta;
	$assign_list["pkeyTable"] = $pkeyTable;
	$smarty->assign('pvalTable', $table_id);
	$smarty->assign('oneItem', $oneItem);

	$frames = getFrame();
	#Step follow index
	$ii = 0;
	$arrStep = array();
	foreach ($frames as $okey => $frame) {
		$steps = $frame['steps'];
		foreach ($steps as $key => $step) {
			$arrStep[$ii] = array(
				'key' => $key,
				'panel' => $okey,
				'name' => $step['name']
			);
			++$ii;
		}
	}

	$smarty->assign('arrStep', $arrStep);

	//die('xx');
	#Possition current step
	$step = 0;
	foreach ($arrStep as $k => $v) {
		if ($v['key'] == $currentstep) {
			$step = $k;
			break;
		}
	}
	$prevstep = isset($arrStep[$step - 1]['key']) ? $arrStep[$step - 1]['key'] : '_first';
	$nextstep = isset($arrStep[$step + 1]['key']) ? $arrStep[$step + 1]['key'] : '_last';
	$smarty->assign('step', $step);
	$smarty->assign('prevstep', $prevstep);
	$smarty->assign('nextstep', $nextstep);
	$smarty->assign('currentstep', $currentstep);

	require_once DIR_COMMON . "/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$smarty->assign('clsForm', $clsForm);
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
	echo $html;
	die();
}
function default_ajSaveMainStep()
{
	//	ini_set('display_errors', '1');
	//	ini_set('display_startup_errors', '1');
	//	error_reporting(E_ALL);
	global $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $clsConfiguration;
	#
	$msg = '_error';
	$clsClassTable = new Meta();
	$table_id = Input::post('table_id', 0);
	$currentstep = Input::post('currentstep');
	if ($currentstep == 'meta') {
		$config_link_Post = Input::post('config_link', 0);
		$config_link_Post = str_replace(DOMAIN_NAME, '', $config_link_Post);

		$title = Input::post('config_value_title');
		$image = Input::post('image', '');
		$arr_update = [
			'config_value_title' 			=> addslashes($title),
			'config_link' 					=> $config_link_Post,
			'user_id' 						=> addslashes($core->_SESS->user_id),
			'reg_date' 						=> time(),
			'upd_date' 						=> time(),
			'image' 						=> $image
		];


		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
		$clsClassTable->setDeBug(1);
		$clsClassTable->updateOne($table_id, $arr_update);
		die;
	} else {
		$val_post = input::post();
		$arr_update = [];
		foreach ($val_post as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
		//		var_dump($arr_update);die;
		$clsClassTable->updateOne($table_id, $arr_update);
	}
	$msg = '_success';
	// Output
	echo $msg;
	die();
}
function default_loadCountry()
{
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
	echo $Html;
	die();
}
function default_loadArea()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsArea = new Area();
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	$area_id = isset($_POST['area_id']) ? $_POST['area_id'] : 0;

	$Html = '<option value="0">|---' . $core->get_Lang('select') . '--</option>';
	$lstArea = $clsArea->getAll("is_trash=0 and country_id='$country_id' order by order_no asc");
	if (is_array($lstArea) && count($lstArea) > 0) {
		for ($i = 0; $i < count($lstArea); $i++) {
			$Html .= '<option title="' . $clsArea->getTitle($lstArea[$i][$clsArea->pkey]) . '" value="' . $lstArea[$i][$clsArea->pkey] . '"' . ($area_id == $lstArea[$i][$clsArea->pkey] ? 'selected="selected"' : '') . '>|--- ' . $clsArea->getTitle($lstArea[$i][$clsArea->pkey]) . '</option>';
		}
	}
	echo $Html;
	die();
}
function default_loadRegion()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsRegion = new Region();
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	$region_id = isset($_POST['region_id']) ? $_POST['region_id'] : 0;
	#
	$Html = $clsRegion->makeSelectboxOption($country_id, $region_id);
	if ($Html == '') {
		echo 'EMPTY';
	} else {
		echo $Html;
	}
	die();
}
function default_loadCity()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsCity = new City();
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	$region_id = isset($_POST['region_id']) ? $_POST['region_id'] : 0;
	$city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;

	$cond = "is_trash=0 and is_online=1";
	if (intval($country_id)) {
		$cond .= " and country_id='$country_id'";
	}
	if (intval($region_id) > 0) {
		$cond .= " and region_id='$region_id'";
	}
	$cond .= " order by title ASC";
	#
	$Html = '<option value="0"> --' . $core->get_Lang('select') . '-- </option>';
	$listCity = $clsCity->getAll($cond, $clsCity->pkey);
	if (is_array($listCity) && count($listCity) > 0) {
		for ($i = 0; $i < count($listCity); $i++) {
			$Html .= '<option title="' . $clsCity->getTitle($listCity[$i][$clsCity->pkey]) . '" value="' . $listCity[$i][$clsCity->pkey] . '" ' . ($city_id == $listCity[$i][$clsCity->pkey] ? 'selected="selected"' : '') . '>|--- ' . $clsCity->getTitle($listCity[$i][$clsCity->pkey]) . '</option>';
		}
	}
	unset($listCity);
	echo $Html;
	die();
}


function default_ajActionNewMeta()
{
	//	ini_set('display_errors', '1');
	//	ini_set('display_startup_errors', '1');
	//	error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,
		$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $clsISO, $package_id;
	$user_id = $core->_USER['user_id'];
	#
	$clsMeta = new Meta();
	$assign_list["clsMeta"] = $clsMeta;
	$tp = Input::post('tp');

	$meta_id = $clsMeta->getMaxId();
	$config_value_title = $core->get_Lang('New Meta') . ' ' . $meta_id;
	$results = array('result' => 'error');
	if ($tp = 'S') {
		$check = $clsMeta->getAll("config_link=''", $clsMeta->pkey);
		if (!$check) {

			$field = $clsMeta->pkey . ",user_id,config_value_title,reg_date,upd_date,config_link";
			$value = "'" . $meta_id . "','" . $user_id . "','" . $config_value_title . "','" . time() . "','" . time() . "',''";
			//		$clsMeta->setDeBug(1);
			$clsMeta->insertOne($field, $value);
			$results = array('result' => 'success', 'link' => 'meta/insert/' . $meta_id . '/overview');
		} else {
			$results = array('result' => 'success', 'link' => 'meta/insert/' . $check[0][$clsMeta->pkey] . '/overview');
		}
	}
	// Return
	echo @json_encode($results);
	die();
}
