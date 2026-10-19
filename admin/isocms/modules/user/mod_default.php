<?php
function getFrame($blog_id = null)
{
	global $core, $dbconn, $_LANG_ID, $clsISO;
	$frames = array(
		'overview' => array(
			'href_group'	=> 'overview',
			'name'	=> $core->get_Lang('Overview'),
			'icon'	=> 'home',
			'steps' => array(
				'user' => array(
					'name' => $core->get_Lang('User')
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


	$pvalTable = Input::get('user_id', 0);
	$assign_list["pvalTable"] = $pvalTable;



	$panel = Input::get('panel', '');
	$assign_list["panel"] = $panel;

	$currentstep = Input::get('step', 'user');
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
	$nextstep = $arrStep[$currentstepx + 1] ?? [];
	$assign_list["frames"] = $frames;
	$assign_list["nextstep"] = json_encode($nextstep);

	$classTable = "User";
	$clsClassTable = new $classTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;


	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;

	//$list_domain=$oneItem['list_domain']?json_decode($oneItem['list_domain'],true):array();

	//foreach($list_domain as $item){
	//print_r($item);die();
	///}




	//$list_domain=$oneItem['list_domain']?json_decode($oneItem['list_domain'],true):array();
	//$list_domain[]='https://www.goldentour.vn/';
	//$list_domain_update=array_unique($list_domain);
	//$list_domain_new[]='https://isocms.com/';
	//$list_domain_update=array_merge($list_domain,$list_domain_new);
	//

	//$set = "list_domain='".json_encode($list_domain_update)."'";
	//$clsClassTable->updateOne($pvalTable,$set);

	//print_r($list_domain_update);die();


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
	global $smarty, $assign_list, $_loged_id, $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $nextstep, $clsConfiguration, $mod, $package_id, $pvalTable, $package_id;
	$clsUser = new User();

	#
	$table_id = Input::post('table_id', 0);
	$currentstep = Input::post('currentstep', '');
	$oneItem = $clsUser->getOne($table_id);
	$tableName = $clsUser->tbl;
	$pkeyTable = $clsUser->pkey;
	$classTable                     = "User";
	$assign_list["classTable"] = $classTable;
	$assign_list["clsClassTable"] = $clsUser;
	$assign_list["pkeyTable"] = $pkeyTable;
	$smarty->assign('pvalTable', $table_id);
	$smarty->assign('oneItem', $oneItem);
	$user_type = $clsUser->getOne($_loged_id);
	$smarty->assign('is_type', $user_type["type"]);

	$clsUserGroup = new UserGroup();
	$assign_list["clsUserGroup"] = $clsUserGroup;
	$listUserGroup = $clsUserGroup->getAll("is_trash=0 order by user_group_id asc");
	$assign_list["listUserGroup"] = $listUserGroup;

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
	global $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $clsConfiguration, $_loged_id;
	#
	$msg = '_error';
	$clsClassTable = new User();
	$table_id = Input::post('table_id', 0);
	$currentstep = Input::post('currentstep');
	$user_name = Input::post('user_name', '');
	$pass1 = Input::post('pass1', '');
	$pass2 = Input::post('pass2', '');
	$pass3 = Input::post('pass3', '');

	$user = $clsClassTable->getOne($_loged_id);

	if ($user_name != '') {
		if (!checkValidEmail($user_name)) {
			$data = [
				'result' => false,
				'type'	=>	1,
				'message'	=>	$core->get_Lang('Invalid User Name!')
			];
			echo json_encode($data);
			die;
		}
		$listUser = $clsClassTable->getAll("1=1 and (user_name='$user_name' || email='$user_name') and user_id != '$table_id'", $clsClassTable->pkey);
		if (!empty($listUser)) {
			$data = [
				'result' => false,
				'type'	=>	1,
				'message'	=>	$core->get_Lang('Exist User Name!')
			];
			echo json_encode($data);
			die;
		}
		if ($pass1 != $pass2 || ($pass1 == '' && $table_id == 0)) {
			$data = [
				'result' => false,
				'type'	=>	2,
				'message'	=>	$core->get_Lang("Password doesn't match")
			];
			echo json_encode($data);
			die;
		}
		if ($user["type"] != "OKRS") {
			if ($core->encrypt($pass3) != $clsClassTable->getOneField('user_pass', $_loged_id)) {
				$data = [
					'result' => false,
					'type' => 3,
					'message' => $core->get_Lang("Password doesn't match with your account!")
				];
				echo json_encode($data);
				die;
			}
		}

		$set = "user_name='" . addslashes($user_name) . "',email='" . addslashes($user_name) . "', first_name='" . addslashes($first_name) . "', last_name='" . addslashes($last_name) . "', user_group_id='$user_group_id',is_active='$disabled',is_super='" . $_POST['is_super'] . "'";
		if ($pass1Post != '') {
			$set .= ",user_pass='" . $clsClassTable->encrypt($pass1Post) . "'";
		}

		$user_name = Input::post('user_name', '');
		$first_name = Input::post('first_name', '');
		$last_name = Input::post('last_name', '');
		$user_group_id = Input::post('user_group_id', 0);
		$disabled = Input::post('disabled', 1);
		$is_super = Input::post('is_super', 0);
		$arr_update = [
			'user_name' 	=> addslashes($user_name),
			'email' 		=> addslashes($user_name),
			'first_name'	=> addslashes($first_name),
			'last_name'		=> addslashes($last_name),
			'user_group_id' => $user_group_id,
			'is_active' 	=> $disabled,
			'is_super'		=>	$is_super
		];
		if ($pass1 != '') {
			$arr_update['user_pass'] = $clsClassTable->encrypt($pass1);
		}
		$update = $clsClassTable->updateOne($table_id, $arr_update);
		if ($update) {
			$data = [
				'result' => true,
				'type'	=>	1,
				'message'	=>	'updateSuccess'
			];
			echo json_encode($data);
			die;
		}
	}
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


function default_ajActionNewUser()
{
	//	ini_set('display_errors', '1');
	//	ini_set('display_startup_errors', '1');
	//	error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,
		$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $clsISO, $package_id;
	#
	$clsUser = new User();
	$assign_list["clsUser"] = $clsUser;
	$tp = Input::post('tp');

	$user_id = $clsUser->getMaxId();
	//	$first_name ='New user '.$user_id;
	$first_name = '';
	$results = array('result' => 'error');
	if ($tp = 'S') {
		$field = $clsUser->pkey . ",first_name,user_group_id,is_super,is_active,upd_date";
		$value = "'" . $user_id . "','" . $first_name . "',1,'0','1','" . time() . "'";
		//		$clsUser->setDeBug(1);
		$clsUser->insertOne($field, $value);
		$results = array('result' => 'success', 'link' => 'user/insert/' . $user_id . '/overview');
	}
	// Return
	echo @json_encode($results);
	die();
}
