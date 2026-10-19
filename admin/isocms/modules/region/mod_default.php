<?php
function getFrame($country_id = null)
{
	global $core, $dbconn, $_LANG_ID, $clsISO;
	global $mod, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO, $package_id;
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
				//				'shortText' => array(
				//					'name' => $core->get_Lang('Short text')
				//				),
				//				'longText' => array(
				//					'name' => $core->get_Lang('Long text')
				//				),
				//'gmap' => array(
				//	'name' => $core->get_Lang('Gmap')
				//),
				//				'banner' => array(
				//					'name' => $core->get_Lang('Banner')
				//				)
			)
		),
	);

	//	$frames['seo'] = array(
	//		'name'	=> $core->get_Lang('seosdvanced'),
	//		'href_group'	=> 'seo',
	//		'icon'	=> '',
	//		'steps'	=> array(
	//			'seo' => array(
	//					'name' =>  $core->get_Lang('seosdvanced')
	//				)
	//		)
	//	);

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

	$pvalTable = Input::get('region_id', 0);
	$assign_list["pvalTable"] = $pvalTable;
	$panel = Input::get('panel', '');
	$assign_list["panel"] = $panel;

	$currentstep = Input::get('step', 'basic');
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

	$classTable = "Region";
	$clsClassTable = new $classTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
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
	global $smarty, $assign_list, $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $nextstep, $clsConfiguration, $mod, $package_id, $pvalTable;
	$clsRegion = new Region();
	$smarty->assign('clsClassTable', $clsRegion);
	$clsCountry = new Country();
	$smarty->assign('clsCountry', $clsCountry);
	$clsContinent = new Continent();
	$smarty->assign('clsContinent', $clsContinent);


	#
	$table_id = Input::post('table_id', 0);
	$currentstep = Input::post('currentstep', '');
	$tableName = $clsRegion->tbl;
	$pkeyTable = $clsRegion->pkey;

	$oneItem = $clsRegion->getOne($table_id);
	$smarty->assign('pvalTable', $table_id);
	$smarty->assign('oneItem', $oneItem);
	$smarty->assign('clsTable', 'Region');
	$smarty->assign('clsTableGal', 'RegionImage');

	$frames = getFrame();
	#Step follow index
	$ii = 0;
	$arrStep = array();
	foreach ($frames as $okey => $frame) {
		$steps = $frame['steps'];
		foreach ($steps as $key => $step) {
			$status = 0;
			if ($key == 'basic' && $oneItem['title'] != '' && $oneItem['continent_id'] > 0 && $oneItem['country_id'] > 0) {
				$status = 1;
			}
			if ($key == 'image' && $oneItem['image'] != '') {
				$status = 1;
			}
			if ($key == 'shortText' && $oneItem['intro'] != '') {
				$status = 1;
			}
			if ($key == 'longText' && $oneItem['content'] != '') {
				$status = 1;
			}
			if ($key == 'banner' && $oneItem['banner'] != '') {
				$status = 1;
			}
			if ($key == 'seo') {
				$clsMeta = new Meta();
				$link = $clsRegion->getLink($table_id);
				$oneMeta = $clsMeta->getAll("config_link='$link' limit 0,1", $clsMeta->pkey . ',config_value_title,config_value_intro,image');
				if (!empty($oneMeta) && $oneMeta[0]['config_value_title'] != '' && $oneMeta[0]['config_value_intro'] != '' && $oneMeta[0]['image'] != '') {
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

	if ($clsISO->getCheckActiveModulePackage($package_id, 'continent', 'default', 'default') && $core->checkAccess('continent')) {
		$clsContinent = new Continent();
		$assign_list["clsContinent"] = $clsContinent;
		$lstContinent = $clsContinent->GetAll("is_trash=0 and is_online=1 order by order_no ASC", $clsContinent->pkey);
		$assign_list["lstContinent"] = $lstContinent;
	}

	$smarty->assign('arrStep', $arrStep);
	$smarty->assign('list_check_target', json_encode($arrStep));
	if ($currentstep == 'seo') {
		$clsMeta = new Meta();
		$assign_list["clsMeta"] = $clsMeta;
		$linkMeta = $clsRegion->getLink($table_id);
		$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
		$meta_id = $allMeta[0]['meta_id'];

		if (empty($meta_id)) {

			$introMeta = strip_tags(html_entity_decode(addslashes($oneItem['intro'])));
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
	$clsForm->addInputTextArea("full", "check_in_out_rule", "", "check_in_out_rule", 255, 25, 8, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "country_booking_policy", "", "country_booking_policy", 255, 25, 15, 1, "style='width:100%'");
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
	/*ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);*/
	global $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn;
	#
	$msg = '_error';
	$clsClassTable = new Region();
	$table_id = Input::post('table_id', 0);
	$continent_id = Input::post('iso-continent_id', 0);
	$country_id = Input::post('iso-country_id', 0);
	$currentstep = Input::post('currentstep');
	$arr_update = [
		'user_id_update' => addslashes($core->_SESS->user_id),
		'upd_date' => time()
	];
	if ($currentstep == 'basic') {
		$title = Input::post('title');
		$title = html_entity_decode($title);
		$slug = $core->replaceSpace($title);
		$listItem = $clsClassTable->getAll("slug='$slug' AND region_id <> '" . $table_id . "' AND continent_id='" . $continent_id . "'  AND country_id='" . $country_id . "' ", $clsClassTable->pkey);
		if (!empty($listItem)) {
			$msg = '_EXIST';
			// Output
			echo $msg;
			die();
		}
		$arr_update['title'] = $title;
		$arr_update['slug'] = $slug;
		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
		$meta_id = $clsISO->getMetaId($table_id, "Region");
		$clsClassTable->updateOne($table_id, $arr_update);
		$clsISO->updateMetaConfigLink($meta_id, $table_id, "Region");
	} else if ($currentstep == 'image') {
		$image = Input::post('image', '');
		$arr_update['image'] = addslashes($image);
		$clsClassTable->updateOne($table_id, $arr_update);
	} else if ($currentstep == 'banner') {
		$banner = Input::post('banner', '');
		$arr_update['banner'] = addslashes($banner);
		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
		$clsClassTable->updateOne($table_id, $arr_update);
	} else if ($currentstep == 'information') {
		$image_hotel = Input::post('image_hotel', '');
		$arr_update['image_hotel'] = addslashes($image_hotel);
		foreach ($_POST as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				$arr_update[$tmp[1]] = addslashes($val);
			}
		}
		$clsClassTable->updateOne($table_id, $arr_update);
	} else if ($currentstep == 'seo') {
		$clsClassTable = new Meta();

		$config_value_title = Input::post('config_value_title');
		$meta_id = Input::post('meta_id');
		$config_value_intro = Input::post('config_value_intro');
		$config_value_image = Input::post('isoman_url_image_seo');
		if (empty($meta_id)) {
			$clsClassTable->updateOne($table_id, array(
				'star_id' => $star_id,
				'upd_date' => time()
			));
		} else {
			$clsClassTable->updateOne($meta_id, array(
				'config_value_title' => $config_value_title,
				'config_value_intro' => $config_value_intro,
				'image' => $config_value_image,
				'upd_date' => time()
			));
		}
	} else {
		$val_post = input::post();
		$value = "";
		$firstAdd = 0;
		foreach ($val_post as $key => $val) {
			$tmp = explode('-', $key);
			if ($tmp[0] == 'iso') {
				if ($firstAdd == 0) {
					$value .= $tmp[1] . "='" . addslashes($val) . "'";
					$firstAdd = 1;
				} else {
					$value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
				}
			}
		}
		$clsClassTable->updateOne($table_id, $value);
	}
	$msg = '_success';
	// Output
	echo $msg;
	die();
}
function default_check_table_code()
{
	global $smarty, $core, $_frontIsLoggedin_user_id, $profile_id, $dbconn, $clsISO;
	global $profile_id, $_frontIsLoggedin_user_id;
	$clsClassTable = new Country();

	$table_id = Input::post('table_id', 0);
	$table_code = Input::post('table_code');
	$cond = "is_trash=0 and country_id<>'{$table_id}' and country_code='{$table_code}'";
	$totalItem = $clsClassTable->countItem($cond);
	echo ($totalItem == 1 ? '_invalid' : '_success');
	die();
}

function default_ajaxLoadCountryRoom()
{
	global $core, $mod, $act, $P;
	$clsCountry = new Country();
	$clsCountryRoom = new CountryRoom();
	#
	$country_id = $_POST['country_id'];
	$html = '';
	$lstRoom = $clsCountryRoom->getAll("is_trash=0 and country_id='$country_id' order by order_no asc");
	if (!empty($lstRoom)) {
		$i = 0;
		foreach ($lstRoom as $item) {
			if ($clsCountryRoom->getNumberChild($item[$clsCountryRoom->pkey]) == 0) {
				$number_people = $clsCountryRoom->getNumberAdult($item[$clsCountryRoom->pkey]) . ' ' . $core->get_Lang('NL');
			} else {
				$number_people = $clsCountryRoom->getNumberAdult($item[$clsCountryRoom->pkey]) . ' ' . $core->get_Lang('NL') . ', ' . $clsCountryRoom->getNumberChild($item[$clsCountryRoom->pkey]) . ' ' . $core->get_Lang('TE');
			}

			$html .= '<tr style="cursor:move" id="order_' . $item[$clsCountryRoom->pkey] . '"  class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
			$html .= '<td class="text_left">' . $clsCountryRoom->getTitleRoomType($item['room_stype_id']) . '</td>';
			$html .= '<td class="text_left">' . $clsCountryRoom->getTitle($item[$clsCountryRoom->pkey]) . '</td>';
			$html .= '<td class="text_center">' . $clsCountryRoom->getNumberRoom($item[$clsCountryRoom->pkey]) . '</td>';
			$html .= '<td class="text_center">' . $number_people . '</td>';
			$html .= '<td class="text_right">' . $clsCountryRoom->getPrice($item[$clsCountryRoom->pkey]) . '</td>';
			$html .= '<td></td>';
			$html .= '
			<td align="center" style="vertical-align: middle; text-align:center; width:50px; white-space: nowrap;">
				<div class="btn-group-ico d-flex">
					<a class="clickEditCountryRoom item_left" title="' . $core->get_Lang('edit') . '" href="javascript:void(0);"  data="' . $item[$clsCountryRoom->pkey] . '" country_id="' . $country_id . '"><i class="ico ico-edit"></i></a>
					<a class="clickDeleteCountryRoom item_right" title="' . $core->get_Lang('delete') . '" href="javascript:void(0);" data="' . $item[$clsCountryRoom->pkey] . '" country_id="' . $country_id . '"><i class="ico ico-remove"></i></a>
				</div>
            </td>';
			$html .= '</tr>';
			++$i;
		}
		$html .= '
		<script type="text/javascript">
			$("#countryRoomTable").sortable({
				opacity: 0.8,
				cursor: \'move\',
				start: function(){
					vietiso_loading(1);
				},
				stop: function(){
					vietiso_loading(0);
				},
				update: function(){
					var page = "' . $page . '";
					var order = $(this).sortable("serialize")+\'&update=update\';
					$.post(path_ajax_script+"/index.php?mod=country&act=ajUpdPosSortCountryRoom", order, function(html){
						loadCountryRoom();
						vietiso_loading(0);
					});
				}
			});
		</script>';
	}
	echo $html;
	die();
}
function default_ajaxAddCountryRoom()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $current_page, $core, $clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration;
	#
	$clsPagination = new Pagination();
	$clsCountry = new Country();
	$clsCountry = new Country();
	$assign_list['clsCountry'] = $clsCountry;
	$clsCountryRoom = new CountryRoom();
	$assign_list['clsCountryRoom'] = $clsCountryRoom;

	$table_id = Input::post('table_id', 0);
	$assign_list['table_id'] = $table_id;
	$pvalTable = Input::post('country_room_id', 0);
	$assign_list['pvalTable'] = $pvalTable;

	if (!empty($pvalTable)) {
		$oneItem = $clsCountryRoom->getOne($pvalTable);
		$assign_list['oneItem'] = $oneItem;
		$number_adult = $oneItem['number_adult'];
		$assign_list['number_adult'] = $number_adult;
		$number_child = $oneItem['number_children'];
		$assign_list['number_child'] = $number_child;
		$bed_option = $oneItem['bed_option'];
		$bed_option = json_decode($bed_option, true);
		$assign_list['bed_option'] = $bed_option;
	}

	$clsProperty = new Property();
	$assign_list['clsProperty'] = $clsProperty;
	$listTypeBed = $clsProperty->getAll("is_trash=0 and type='TypeBed' order by order_no ASC", $clsProperty->pkey);
	$assign_list['listTypeBed'] = $listTypeBed;

	$fill_bed_name_select_box = '';
	foreach ($listTypeBed as $item) {
		$fill_bed_name_select_box .= '<option value="' . $item['property_id'] . '">' . $clsProperty->getTitle($item['property_id']) . '</option>';
	}
	$assign_list['fill_bed_name_select_box'] = $fill_bed_name_select_box;


	$fill_bed_number_select_box = '';
	for ($i = 0; $i < 5; $i++) {
		$fill_bed_number_select_box .= '<option value="' . $i . '">' . $i . '</option>';
	}
	$assign_list['fill_bed_number_select_box'] = $fill_bed_number_select_box;


	$tp = Input::post('tp', '');
	$assign_list['tp'] = $tp;
	$html = $core->build('modal.addcountryroom.tpl');
	echo $html;
	die();
}

function default_ajSaveCountryRoom()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
	$clsCountry = new Country();
	$clsCountryRoom = new CountryRoom();
	$user_id = $core->_USER['user_id'];
	$country_room_id = Input::post('country_room_id', 0);
	$country_id = Input::post('country_id', 0);
	$room_stype_id = Input::post('room_stype_id', 0);
	$titlePost = Input::post('title', '');
	$slugPost = $core->replaceSpace($titlePost);
	$number_val = Input::post('number_val', 0);
	$footage = Input::post('footage', 0);
	$number_adult = Input::post('number_adult', 0);
	$number_child = Input::post('number_child', 0);
	$price = Input::post('price', 0);
	$price = $clsISO->processSmartNumber2($price);
	$price_weekend = Input::post('price_weekend', 0);
	$price_weekend = $clsISO->processSmartNumber2($price_weekend);
	$price_peak_time = Input::post('price_peak_time', 0);
	$price_peak_time = $clsISO->processSmartNumber2($price_peak_time);

	if (_isoman_use) {
		$image = $_POST['isoman_url_image'];
	} else {
		$image = $_POST['image_src'];
	}


	$bed_option = array();

	foreach ($_POST['item_bed'] as $key => $val) {
		$bed_option[$key]['id'] = $val;
		$bed_option[$key]['number'] = $_POST['item_bed_number'][$key];
	}
	$bed_option = json_encode($bed_option);

	$tp = Input::post('tp', 'SAVE');


	if (empty($country_room_id)) {
		$fx = "$clsCountryRoom->pkey,country_id,user_id,room_stype_id,title,slug,number_val,footage,number_adult,number_children,price,price_weekend,price_peak_time,bed_option,order_no,reg_date,upd_date,image";
		$vx = "'" . $clsCountryRoom->getMaxId() . "','" . $country_id . "','" . $user_id . "','" . $room_stype_id . "','" . $titlePost . "','$slugPost','$number_val','$footage','$number_adult','$number_child','$price','$price_weekend','$price_peak_time','$bed_option','1','" . time() . "','" . time() . "','" . $image . "'";
		$listTable = $clsCountryRoom->getAll("1=1", $clsCountryRoom->pkey . ",order_no");
		for ($i = 0; $i <= count($listTable); $i++) {
			$order_no = $listTable[$i]['order_no'] + 1;
			$clsCountryRoom->updateOne($listTable[$i][$clsCountryRoom->pkey], "order_no='" . $order_no . "'");
		}
		if ($clsCountryRoom->insertOne($fx, $vx)) {
			echo ('INSERT_SUCCESS');
			die();
		} else {
			echo ('INSERT_ERROR');
			die();
		}
	} else {
		$value = "country_id='" . $country_id . "'";
		$value .= ",user_id_update='" . $user_id . "'";
		$value .= ",room_stype_id='" . $room_stype_id . "'";
		$value .= ",title='" . $titlePost . "'";
		$value .= ",slug='" . $slugPost . "'";
		$value .= ",number_val='" . $number_val . "'";
		$value .= ",footage='" . $footage . "'";
		$value .= ",number_adult='" . $number_adult . "'";
		$value .= ",number_children='" . $number_child . "'";
		$value .= ",price='" . $price . "'";
		$value .= ",price_weekend='" . $price_weekend . "'";
		$value .= ",price_peak_time='" . $price_peak_time . "'";
		$value .= ",bed_option='" . $bed_option . "'";
		$value .= ",upd_date='" . time() . "'";
		$value .= ",image='" . $image . "'";
		if ($clsCountryRoom->updateOne($country_room_id, $value)) {
			$clsCountry->updateMinPrice($country_id);
			echo ('UPDATE_SUCCESS');
			die();
		} else {
			echo ('UPDATE_ERROR');
			die();
		}
	}


	echo (1);
	die();
}

function default_ajUpdPosSortCountryRoom()
{
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsCountryRoom = new CountryRoom();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach ($order as $key => $val) {
		$key = (($currentPage - 1) * $recordPerPage + $key + 1);
		$clsCountryRoom->updateOne($val, "order_no='" . $key . "'");
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



function default_ajActionNewRegion()
{
	//	ini_set('display_errors', '1');
	//	ini_set('display_startup_errors', '1');
	//	error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,
		$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $clsISO, $package_id;
	$user_id = $core->_USER['user_id'];
	#
	$clsRegion = new Region();
	$assign_list["clsRegion"] = $clsRegion;
	$tp = Input::post('tp');
	$is_day_trip = Input::post('is_day_trip', 0);

	$region_id = $clsRegion->getMaxId();
	$title_voucher_new = $core->get_Lang('New Region') . ' ' . $region_id;
	$results = array('result' => 'error');
	if ($tp = 'S') {
		$field = $clsRegion->pkey . ",user_id,user_id_update,title,slug,order_no,reg_date,upd_date";
		$value = "'" . $region_id . "','" . $user_id . "','" . $user_id . "','" . $title_voucher_new . "','" . $core->replaceSpace($title_voucher_new) . "'," . $clsRegion->getMaxOrderNo() . ",'" . time() . "','" . time() . "'";
		$clsRegion->insertOne($field, $value);
		$results = array('result' => 'success', 'link' => 'region/insert/' . $region_id . '/overview');
	}
	// Return
	echo @json_encode($results);
	die();
}
