
<?php
function getFrame($blog_id = null)
{
	global $core, $dbconn, $_LANG_ID, $clsISO, $package_id, $mod;
	$frames = array(
		'overview' => array(
			'href_group'	=> 'overview',
			'name'	=> $core->get_Lang('Overview'),
			'icon'	=> 'home',
			'steps' => array(
				'generalinformation' => array(
					'name' => $core->get_Lang('About')
				),
				'image' => array(
					'name' => $core->get_Lang('Image')
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
	if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'blog_destination', 'customize')) {
		$frames['destination'] = array(
			'name'	=> $core->get_Lang('Blog destination'),
			'href_group'	=> 'destination',
			'icon'	=> '',
			'steps'	=> array(
				'destination' => array(
					'name' => $core->get_Lang('Blog destination')
				),
			)
		);
	}
	if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'blog_tour_related', 'customize')) {
		$frames['tourRelated'] = array(
			'name'	=> $core->get_Lang('TourRelated'),
			'href_group'	=> 'tourRelated',
			'icon'	=> '',
			'steps'	=> array(
				'tourRelated' => array(
					'name' => $core->get_Lang('TourRelated')
				),
			)
		);
	}
	if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'blog_hotel_related', 'customize')) {
		$frames['hotelRelated'] = array(
			'name'	=> $core->get_Lang('HotelRelated'),
			'href_group'	=> 'hotelRelated',
			'icon'	=> '',
			'steps'	=> array(
				'hotelRelated'	=> array(
					'name' => $core->get_Lang('HotelRelated')
				),
			)
		);
	}
	if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'blog_cruise_related', 'customize')) {
		$frames['cruiseRelated'] = array(
			'name'	=> $core->get_Lang('CruiseRelated'),
			'href_group'	=> 'cruiseRelated',
			'icon'	=> '',
			'steps'	=> array(
				'cruiseRelated' => array(
					'name' => $core->get_Lang('CruiseRelated')
				),
			)
		);
	}
	$frames['seo'] = array(
		'name'	=> $core->get_Lang('Seo tools'),
		'href_group'	=> 'seo',
		'icon'	=> '',
		'steps'	=> array(
			'seo' => array(
				'name' =>  $core->get_Lang('Seo tools')
			)
		)
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


	$pvalTable = Input::get('blog_id', 0);
	$assign_list["pvalTable"] = $pvalTable;
	$panel = Input::get('panel', '');
	$assign_list["panel"] = $panel;

	$currentstep = Input::get('step', 'generalinformation');
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
				'status' => $status,
				'description' => $step['description'] ?? ''
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


	$classTable = "Blog";
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
	global $smarty, $assign_list, $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $nextstep, $clsConfiguration, $mod, $package_id, $pvalTable, $package_id;
	$clsBlog = new Blog();
	$clsBlogCategory = new BlogCategory();
	$assign_list["clsBlogCategory"] = $clsBlogCategory;
	$clsTag = new Tag();
	$assign_list["clsTag"] = $clsTag;
	$clsContinent                   = new Continent();
	$assign_list["clsContinent"]    = $clsContinent;

	#
	$table_id = Input::post('table_id', 0);
	$currentstep = Input::post('currentstep', '');
	$oneItem = $clsBlog->getOne($table_id);

	$clsBlogExtension = new BlogExtension();
	$tableName = $clsBlog->tbl;
	$pkeyTable = $clsBlog->pkey;
	$classTable                     = "Blog";
	$assign_list["classTable"] = $classTable;
	$assign_list["clsTable"] = $classTable;
	$assign_list["clsClassTable"] = $clsBlog;
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
			$status = 0;
			if ($key == 'generalinformation' && $oneItem['title'] != '' && $oneItem['cat_id'] > 0) {
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
			if ($key == 'destination') {
				$clsBlogDestination = new BlogDestination();
				$number_destination = $clsBlogDestination->countItem("blog_id='" . $table_id . "'");
				if ($number_destination > 0) {
					$status = 1;
				}
			}
			if ($key == 'tourRelated') {
				$number_tourRelated = $clsBlogExtension->countItem("blog_id='" . $table_id . "' AND table_name='tour'");
				if ($number_tourRelated > 0) {
					$status = 1;
				}
			}
			if ($key == 'hotelRelated') {
				$number_hotelRelated = $clsBlogExtension->countItem("blog_id='" . $table_id . "' AND table_name='hotel'");
				if ($number_hotelRelated > 0) {
					$status = 1;
				}
			}
			if ($key == 'cruiseRelated') {
				$number_cruiseRelated = $clsBlogExtension->countItem("blog_id='" . $table_id . "' AND table_name='cruise'");
				if ($number_cruiseRelated > 0) {
					$status = 1;
				}
			}
			if ($key == 'seo') {
				$clsMeta = new Meta();
				$link = $clsBlog->getLink($table_id);
				$oneMeta = $clsMeta->getAll("config_link='$link' limit 0,1", $clsMeta->pkey . ',config_value_title,config_value_intro,image,schema_markup');
				if (!empty($oneMeta) && $oneMeta[0]['config_value_title'] != '' && $oneMeta[0]['config_value_intro'] != '' && $oneMeta[0]['image'] != '') {
					$status = 1;
				}
			}
			$arrStep[$ii] = array(
				'key' => $key,
				'panel' => $okey,
				'name' => $step['name'],
				'status' => $status,
				'description' => $step['description'] ?? ''
			);
			++$ii;
		}
	}

	$smarty->assign('arrStep', $arrStep);
	$smarty->assign('list_check_target', json_encode($arrStep));
	if ($currentstep == 'seo') {
		$clsMeta = new Meta();
		$assign_list["clsMeta"] = $clsMeta;
		$linkMeta = $clsBlog->getLink($table_id);
		$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
		$meta_id = $allMeta[0]['meta_id'] ?? 0;

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
	if ($currentstep == 'image-file-tour') {
		$hasImg = 1;
		if (stripos($oneItem['image'], 'no-image') !== false) {
			$hasImg = 0;
		}
		$smarty->assign('hasImg', $hasImg);
	}

	if ($currentstep == 'generalinformation') {
		$clsCountry = new Country();
		$lstCountry = $clsCountry->getAll('is_trash = 0 AND is_online = 1', 'country_id, title');
		$smarty->assign('lstCountry', $lstCountry);
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
				ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	global $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $clsConfiguration;
	#
	$clsBlogCategory = new BlogCategory();
	$clsTag = new Tag();
	$msg = '_error';
	$clsClassTable = new Blog();
	$table_id = Input::post('table_id', 0);
	$currentstep = Input::post('currentstep');

	if ($currentstep == 'generalinformation') {
	$oneItem = $clsClassTable->getOne(
		(int)$table_id,
		'title,slug'
	);

	$title = trim(
		html_entity_decode(
			(string)Input::post('title', ''),
			ENT_QUOTES,
			'UTF-8'
		)
	);

	if ($title === '') {
		echo '_error_title';
		die();
	}

	$currentTitle = trim(
		(string)($oneItem['title'] ?? '')
	);

	$currentSlug = trim(
		(string)($oneItem['slug'] ?? '')
	);

	$postedSlug = trim(
		(string)Input::post('slug', '')
	);

	$changeUrl = (int)Input::post(
		'change_url',
		0
	);

	$defaultTitle =
		'New Blog ' . (int)$table_id;

	$defaultSlug =
		'new-blog-' . (int)$table_id;

	$isNewBlog = (
		$currentSlug === '' ||
		$currentSlug === $defaultSlug ||
		$currentTitle === '' ||
		$currentTitle === $defaultTitle
	);

	/*
	 * Check title trùng.
	 */
	$clsISO->checkExistTitle(
		'Blog',
		(int)$table_id,
		$title
	);

	$slugToSave = '';

	if ($isNewBlog) {
		$slugToSave = $postedSlug !== ''
			? $postedSlug
			: $title;
	} elseif ($changeUrl === 1) {
		$slugToSave = $postedSlug !== ''
			? $postedSlug
			: $title;
	}

	if ($slugToSave !== '') {
		$slugRaw = trim((string)$slugToSave);

		$hasHtml = (bool)preg_match(
			'/\.html$/i',
			$slugRaw
		);

		if ($hasHtml) {
			$slugRaw = preg_replace(
				'/\.html$/i',
				'',
				$slugRaw
			);
		}

		$slugRaw = preg_replace(
			'/[^a-zA-Z0-9\-_\s]+/',
			'-',
			$slugRaw
		);

		$slugToSave = trim(
			(string)$clsISO->replaceSpace2(
				$slugRaw
			),
			'-'
		);

		if ($hasHtml && $slugToSave !== '') {
			$slugToSave .= '.html';
		}

		if ($slugToSave === '') {
			echo '_error_slug';
			die();
		}

		$duplicateSlug = $clsClassTable->getAll(
			"slug='" .
			addslashes($slugToSave) .
			"' AND blog_id<>'" .
			(int)$table_id .
			"' LIMIT 0,1",
			$clsClassTable->pkey
		);

		if (!empty($duplicateSlug)) {
			echo '_EXIST_URL';
			die();
		}
	}

	/*
	 * Tags.
	 */
	$tagPost = trim(
		(string)Input::post(
			'list_tag_id',
			''
		)
	);

	$tags_list = array();

	if ($tagPost !== '') {
		$tags_array = array_filter(
			array_map(
				'trim',
				explode(',', $tagPost)
			)
		);

		foreach ($tags_array as $tag) {
			$tagSlug = $clsISO->replaceSpace2(
				$tag
			);

			$lstcheck = $clsTag->getAll(
				"slug='" .
				addslashes($tagSlug) .
				"' LIMIT 0,1"
			);

			if (!empty($lstcheck)) {
				$tags_list[] =
					$lstcheck[0][
						$clsTag->pkey
					];
			} else {
				$id = $clsTag->getMaxId();

				$clsTag->insertOne(
					'tag_id,title,slug',
					"'" . (int)$id . "'," .
					"'" . addslashes($tag) . "'," .
					"'" . addslashes($tagSlug) . "'"
				);

				$tags_list[] = $id;
			}
		}
	}

	$list_tag_id = !empty($tags_list)
		? $clsISO->makeSlashListFromArray2(
			$tags_list
		)
		: '';

	$listCountry = Input::post(
		'list_country',
		array()
	);

	$list_country_id = !empty($listCountry)
		? $clsISO->makeSlashListFromArray2(
			$listCountry
		)
		: '';

	$arr_update = array(
		'title' => $title,
		'list_tag_id' => $list_tag_id,
		'list_country_id' => $list_country_id,
		'upd_date' => time(),
		'user_id_update' => addslashes(
			$core->_SESS->user_id
		)
	);

	/*
	 * Chỉ cập nhật URL khi tạo mới hoặc có tích Change URL.
	 */
	if ($slugToSave !== '') {
		$arr_update['slug'] = $slugToSave;
	}

	if (
		$clsConfiguration->getValue(
			'SiteHasCat_Blogs'
		)
	) {
		$cat_id = (int)Input::post(
			'iso-cat_id',
			0
		);

		$list_cat_id =
			$clsBlogCategory->getListParent(
				$cat_id
			);

		$arr_update['cat_id'] = $cat_id;
		$arr_update['list_cat_id'] =
			addslashes($list_cat_id);
	}

	$publish_date = trim(
		(string)Input::post(
			'publish_date',
			''
		)
	);

	if ($publish_date !== '') {
		$publishTimestamp = strtotime(
			str_replace(
				'/',
				'-',
				$publish_date
			)
		);

		if ($publishTimestamp !== false) {
			$arr_update['publish_date'] =
				$publishTimestamp;
		}
	}

	foreach ($_POST as $key => $val) {
		if (
			strpos((string)$key, 'iso-') !== 0
		) {
			continue;
		}

		$field = substr((string)$key, 4);

		if (
			$field === '' ||
			is_array($val)
		) {
			continue;
		}

		$arr_update[$field] =
			addslashes((string)$val);
	}

	$meta_id = $clsISO->getMetaId(
		(int)$table_id,
		'Blog'
	);

	$updated = $clsClassTable->updateOne(
		(int)$table_id,
		$arr_update
	);

	if (!$updated) {
		echo '_error';
		die();
	}

	$clsISO->updateMetaConfigLink(
		$meta_id,
		(int)$table_id,
		'Blog'
	);
	} else if ($currentstep == 'image') {
		$image = Input::post('image', '');
		$clsClassTable->updateOne($table_id, array(
			'image' => $image
		));
	} else if ($currentstep == 'shortText') {
		$intro = Input::post('iso-intro', '');
		$arr_update['intro'] = $intro;
		$clsClassTable->updateOne($table_id, $arr_update);
	} else if ($currentstep == 'longText') {
		$content = Input::post('iso-content');
		$content = html_entity_decode($content);
		$content = preg_replace_callback('#(<img\s(?>(?!src=)[^>])*?src=")nodata...image/([a-z]+);base64,([\w=+/]++)("[^>]*>)#', "data_upload_image_word_textarea", $content);
		$content = preg_replace_callback('#(<img\s(?>(?!src=)[^>])*?src=")data:image/(gif|png|jpeg);base64,([\w=+/]++)("[^>]*>)#', "data_upload_image_word_textarea", $content);
		$arr_update['content'] = $content;
		$clsClassTable->updateOne($table_id, $arr_update);
	} else if ($currentstep == 'seo') {
		$clsClassTable = new Meta();

	$config_value_title = Input::post(
		'config_value_title',
		''
	);

	$meta_id = (int)Input::post(
		'meta_id',
		0
	);

	$config_value_intro = Input::post(
		'config_value_intro',
		''
	);

	$schema = $clsClassTable->getSchemaMarkupFromPost();
    if (!$schema['success']) {
        die('_error');
    }
    $schema_markup = $schema['data'];

	$config_value_image = Input::post(
		'isoman_url_image_seo',
		''
	);
	$clsMeta = new Meta();
	if ($meta_id > 0) {
		$clsMeta->updateOne(
			$meta_id,
			array(
				'config_value_title' =>
					$config_value_title,

				'config_value_intro' =>
					$config_value_intro,

				'image' =>
					$config_value_image,

				'schema_markup' =>
					$schema_markup,

				'upd_date' =>
					time()
			)
		);
	} else {
		$blog = new Blog();

		$configLink = $blog->getLink(
			(int)$table_id
		);

		$newMetaId = $clsMeta->getMaxId();

		$clsMeta->insertOne(
			'meta_id,config_link,' .
			'config_value_title,' .
			'config_value_intro,' .
			'image,' .
			'schema_markup,' .
			'reg_date,upd_date',

			"'" . (int)$newMetaId . "'," .
			"'" . addslashes($configLink) . "'," .
			"'" . addslashes($config_value_title) . "'," .
			"'" . addslashes($config_value_intro) . "'," .
			"'" . addslashes($config_value_image) . "'," .
			"'" . addslashes($schema_markup) . "'," .
			"'" . time() . "'," .
			"'" . time() . "'"
		);
	}
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
function default_ajActionNewBlog()
{
	//	ini_set('display_errors', '1');
	//	ini_set('display_startup_errors', '1');
	//	error_reporting(E_ALL);
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,
		$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $clsISO, $package_id;
	$user_id = $core->_USER['user_id'];
	#
	$clsBlog = new Blog();
	$assign_list["clsBlog"] = $clsBlog;
	$tp = Input::post('tp');
	$is_day_trip = Input::post('is_day_trip', 0);

	$blog_id = $clsBlog->getMaxId();
	$title_voucher_new = $core->get_Lang('New Blog') . ' ' . $blog_id;
	$results = array('result' => 'error');
	if ($tp = 'S') {

		$field = $clsBlog->pkey . ",user_id,user_id_update,title,slug,order_no,reg_date,upd_date,is_approve";
		$value = "'" . $blog_id . "','" . $user_id . "','" . $user_id . "','" . $title_voucher_new . "','" . $core->replaceSpace($title_voucher_new) . "',{$clsBlog->getMaxOrderNo()},'" . time() . "','" . time() . "','1'";
		$clsBlog->insertOne($field, $value);
		$results = array('result' => 'success', 'link' => 'blog/insert/' . $blog_id . '/overview');
	}
	// Return
	echo @json_encode($results);
	die();
}
?>