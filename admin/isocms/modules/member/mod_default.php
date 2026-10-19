<?php
function getFrame($profile_id = null)
{
	global $core, $dbconn, $_LANG_ID, $clsISO;
	$frames = array(
		'overview' => array(
			'href_group'	=> 'overview',
			'name'	=> $core->get_Lang('Overview'),
			'icon'	=> 'home',
			'steps' => array(
				'profile' => array(
					'name' => $core->get_Lang('profilemanagement')
				),
				'image' => array(
					'name' => $core->get_Lang('Image cover')
				),
				'booking' => array(
					'name' => $core->get_Lang('Bookings')
				),
				'reviewsPhoto' => array(
					'name' => $core->get_Lang('Tour Reviews &amp; Photos')
				)
			)
		),
	);
	return $frames;
}
function default_insert()
{
	//	ini_set('display_errors', '1');
	//ini_set('display_startup_errors', '1');
	//error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core, $pvalTable,
		$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $show, $nextstep;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list["show"] = $show;
	$assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';


	$pvalTable = Input::get('profile_id', 0);
	$assign_list["pvalTable"] = $pvalTable;
	$panel = Input::get('panel', '');
	$assign_list["panel"] = $panel;

	$currentstep = Input::get('step', 'profile');
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


	$classTable = "Profile";
	$clsClassTable = new $classTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	$is_active = $oneItem['is_active'];
	if ($is_active == 0 && intval($pvalTable) > 0) {
		$clsClassTable->updateOne($pvalTable, "is_active = 1");
	}

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
	//	ini_set('display_errors', '1');
	//ini_set('display_startup_errors', '1');
	//error_reporting(E_ALL);
	global $smarty, $assign_list, $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $nextstep, $clsConfiguration, $mod, $package_id, $pvalTable;
	$clsProfile = new Profile();
	$smarty->assign('clsClassTable', $clsProfile);

	#
	$table_id = Input::post('table_id', 0);
	$currentstep = Input::post('currentstep', '');
	$tableName = $clsProfile->tbl;
	$pkeyTable = $clsProfile->pkey;

	$oneItem = $clsProfile->getOne($table_id);
	$smarty->assign('pvalTable', $table_id);
	$smarty->assign('oneItem', $oneItem);
	$smarty->assign('clsTable', 'Profile');
	$smarty->assign('clsTableGal', 'ProfileImage');

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
				'name' => $step['name'],
				//				'description' => $step['description']
			);
			++$ii;
		}
	}

	/*//////Booking////////*/
	$clsTour = new Tour();
	$assign_list["clsTour"] = $clsTour;
	$clsCruise = new Cruise();
	$assign_list["clsCruise"] = $clsCruise;
	$clsHotel = new Hotel();
	$assign_list["clsHotel"] = $clsHotel;
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$lstBooking = $clsBooking->getAll("member_id='$table_id' order by booking_id desc");
	$assign_list["lstBooking"] = $lstBooking;
	if ($lstBooking > 0) {
		$totalBooking = count($lstBooking);
	} else {
		$totalBooking = 0;
	}
	$assign_list["totalBooking"] = $totalBooking;
	$lstBookingHotel = $clsBooking->getAll("clsTable='Hotel' and member_id='$table_id' order by booking_id desc");
	$assign_list["lstBookingHotel"] = $lstBookingHotel;

	$lstBookingTour = $clsBooking->getAll("clsTable='Tour' and member_id='$table_id' order by booking_id desc");
	$assign_list["lstBookingTour"] = $lstBookingTour;

	$lstBookingCruise = $clsBooking->getAll("clsTable='Cruise' and member_id='$table_id' order by booking_id desc");
	$assign_list["lstBookingCruise"] = $lstBookingCruise;

	/*///////Reviews////////////*/
	$clsReviews = new Reviews();
	$assign_list["clsReviews"] = $clsReviews;
	$lstReviews = $clsReviews->getAll("profile_id='$table_id' order by reviews_id desc");
	$assign_list["lstReviews"] = $lstReviews;
	$totalReviews = 0;



	$lstReviewsHotel = $clsReviews->getAll("type='hotel' and profile_id='$table_id' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
	if ($lstReviewsHotel) {
		$totalReviews += count($lstReviewsHotel);
	}
	$assign_list["lstReviewsHotel"] = $lstReviewsHotel;
	$lstReviewsTour = $clsReviews->getAll("type='tour' and profile_id='$table_id' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
	if ($lstReviewsTour) {
		$totalReviews += count($lstReviewsTour);
	}
	$assign_list["lstReviewsTour"] = $lstReviewsTour;
	$lstReviewsCruise = $clsReviews->getAll("type='cruise' and profile_id='$table_id' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
	if ($lstReviewsCruise) {
		$totalReviews += count($lstReviewsCruise);
	}
	$assign_list["lstReviewsCruise"] = $lstReviewsCruise;

	$assign_list["totalReviews"] = $totalReviews;
	$smarty->assign('arrStep', $arrStep);
	if ($currentstep == 'seo') {
		$clsMeta = new Meta();
		$assign_list["clsMeta"] = $clsMeta;
		$linkMeta = $clsProfile->getLink($table_id);
		$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
		$meta_id = $allMeta[0]['meta_id'];

		if (empty($meta_id)) {

			$introMeta = strip_tags(html_entity_decode(addslashes($oneItem['overview'])));
			$introMeta = explode('$trun$', wordwrap($introMeta, 280, '$trun$', false), 2);
			$introMeta = $introMeta[0] . (isset($introMeta[1]) ? '...' : '');
			$meta_id = $clsMeta->getMaxId();
			$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id", "'" . $linkMeta . "','" . $oneItem['title'] . "','" . $introMeta . "','" . $oneItem['image'] . "','" . time() . "','" . time() . "','" . $meta_id . "'");
		}
		$smarty->assign('meta_id', $meta_id);
	} else if ($currentstep == 'lhdl') {
	}
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

	#

	// Output
	$html = $core->build('main_step.tpl');
	echo $html;
	die();
}
function default_ajSaveMainStep()
{
	//			ini_set('display_errors', '1');
	//ini_set('display_startup_errors', '1');
	//error_reporting(E_ALL);
	global $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn;
	#
	die;
	$msg = '_error';
	$clsClassTable = new Profile();
	$table_id = Input::post('table_id', 0);
	$currentstep = Input::post('currentstep');
	$arr_update = [
		'user_id_update' => addslashes($core->_SESS->user_id),
		'upd_date' => time()
	];
	$val_post = input::post();
	$arr_update = [];
	foreach ($val_post as $key => $val) {
		$tmp = explode('-', $key);
		if ($tmp[0] == 'iso') {
			$arr_update[$tmp[1]] = addslashes($val);
		}
	}
	$msg = '_success';
	// Output
	echo $msg;
	die();
}
