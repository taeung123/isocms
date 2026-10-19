<?php
function getFrame($country_id = null)
{
    global $core, $dbconn, $_LANG_ID, $clsISO;
    global $mod, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO, $package_id;
    $frames = array(
        'overview' => array(
            'href_group' => 'overview',
            'name' => $core->get_Lang('Overview'),
            'icon' => 'home',
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
                ),
                //'gmap' => array(
                //	'name' => $core->get_Lang('Gmap')
                //),
                'banner' => array(
                    'name' => $core->get_Lang('Banner')
                ),
                'why_choose_country' => array(
                    'name' => $core->get_Lang('Why choose country')
                ),
                'gallery_country' => array(
                    'name' => $core->get_Lang('Gallery country')
                ),
            )
        ),
    );
    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'default', 'default') && $clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'country_hotel', 'customize', 'default')) {
        $frames['information'] = array(
            'name' => $core->get_Lang('Hotel Information'),
            'href_group' => 'information',
            'icon' => '',
            'steps' => array(
                'information' => array(
                    'name' => $core->get_Lang('Hotel Information')
                ),
            )
        );
    }
    $frames['seo'] = array(
        'name' => $core->get_Lang('SEO Advanced'),
        'href_group' => 'seo',
        'icon' => '',
        'steps' => array(
            'seo' => array(
                'name' => $core->get_Lang('SEO Advanced')
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


    $pvalTable = Input::get('country_id', 0);
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


    $classTable = "Country";
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

    $clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'easy_cancel', "", 'easy_cancel', 255, 25, 5, 1, "style='width:100%'");

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
    //    ini_set('display_errors', '1');
    //    ini_set('display_startup_errors', '1');
    //    error_reporting(E_ALL);
    global $smarty, $assign_list, $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $nextstep, $clsConfiguration, $mod, $package_id, $pvalTable;
    $clsCountry = new Country();
    $smarty->assign('clsClassTable', $clsCountry);
    $clsWhyChooseCountry = new WhyChooseCountry();
    $clsCountryImage = new CountryImage();
    #
    $table_id = Input::post('table_id', 0);
    $currentstep = Input::post('currentstep', '');
    $tableName = $clsCountry->tbl;
    $pkeyTable = $clsCountry->pkey;
    #
    $oneItem = $clsCountry->getOne($table_id);
    $smarty->assign('pvalTable', $table_id);
    $smarty->assign('oneItem', $oneItem);
    $smarty->assign('clsTable', 'Country');
    $smarty->assign('clsTableGal', 'CountryImage');
    #
    $arr_why_country = $clsWhyChooseCountry->getAll("country_id=$table_id AND is_online=1", $clsWhyChooseCountry->pkey);
    $arr_galley_country = $clsCountryImage->getAll("table_id=$table_id", $clsCountryImage->pkey);
    #
    $frames = getFrame();
    #Step follow index
    $ii = 0;
    $arrStep = array();
    foreach ($frames as $okey => $frame) {
        $steps = $frame['steps'];
        foreach ($steps as $key => $step) {
            $status = 0;
            if ($key == 'basic' && $oneItem['title'] != '' && $oneItem['continent_id'] != '') {
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
            if ($key == 'why_choose_country' && !empty($arr_why_country)) {
                $status = 1;
            }
            if ($key == 'gallery_country' && !empty($arr_galley_country)) {
                $status = 1;
            }
            if ($key == 'information' && $oneItem['intro_hotel'] != '' && $oneItem['image_hotel'] != '') {
                $status = 1;
            }
            if ($key == 'seo') {
                $clsMeta = new Meta();
                $link = $clsCountry->getLink($table_id);
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
                //				'description' => $step['description']
            );
            ++$ii;
        }
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'continent', 'default', 'default')) {
        $clsContinent = new Continent();
        $assign_list["clsContinent"] = $clsContinent;
        $lstContinent = $clsContinent->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsContinent->pkey);
        $assign_list["lstContinent"] = $lstContinent;
    }
    $smarty->assign('arrStep', $arrStep);
    $smarty->assign('list_check_target', json_encode($arrStep));
    if ($currentstep == 'seo') {
        $clsMeta = new Meta();
        $assign_list["clsMeta"] = $clsMeta;
        $linkMeta = $clsCountry->getLink($table_id);
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
    #
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
    $clsClassTable = new Country();
    $table_id = Input::post('table_id', 0);
    $continent_id = Input::post('iso-continent_id', 0);
    $currentstep = Input::post('currentstep');
    $arr_update = [
        'user_id_update' => addslashes($core->_SESS->user_id),
        'upd_date' => time()
    ];
    if ($currentstep == 'basic') {
        $title = Input::post('title');
        $title = html_entity_decode($title);
        $slug = $core->replaceSpace($title);

        $listItem = $clsClassTable->getAll("slug='$slug' AND country_id <> '" . $table_id . "'", $clsClassTable->pkey);
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
        $clsClassTable->updateOne($table_id, $arr_update);
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

		$schema = $clsClassTable->getSchemaMarkupFromPost();
		if (!$schema['success']) {
			die('_error');
		}
		$schema_markup = $schema['data'];

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
                'schema_markup' => $schema_markup,
                'image' => $config_value_image,
                'upd_date' => time()
            ));
        }
    } else {
        $val_post = input::post();
        $arr_update = [];
        foreach ($val_post as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($tmp[1] == 'intro' || $tmp[1] == 'content') {
                    $arr_update[$tmp[1]] = $val;
                } else {
                    $arr_update[$tmp[1]] = addslashes($val);
                }
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
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCountryRoom = new CountryRoom();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
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

function default_SiteFrmWhyCountry()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $clsWhyChooseCountry = new WhyChooseCountry();
    $assign_list["clsWhyChooseCountry"] = $clsWhyChooseCountry;
    #
    $why_choose_country_id = isset($_POST['why_choose_country_id']) ? intval($_POST['why_choose_country_id']) : 0;
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
    if (intval($why_choose_country_id) > 0) {
        $oneItem = $clsWhyChooseCountry->getOne($why_choose_country_id);
    }
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    if ($tp == 'L') {
        $lstItem = $clsWhyChooseCountry->getAll("country_id='$country_id' order by order_no asc", $clsWhyChooseCountry->pkey . ',title,image,is_online');
        $html = '';
        if (!empty($lstItem)) {
            for ($i = 0, $max = count($lstItem); $i < $max; $i++) {
                $html .= '<tr style="cursor:move" id="order_' . $lstItem[$i][$clsWhyChooseCountry->pkey] . '" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<th class="day index"><span>' . ($i + 1) . '</span></th>';
                $html .= '
				<td class="name_service">
                    <div class="d-flex">
                        <img src="' . $clsWhyChooseCountry->getImage($lstItem[$i][$clsWhyChooseCountry->pkey], 60, 40) . '" style="margin-right:5px" />
                        ' . $clsWhyChooseCountry->getTitle($lstItem[$i][$clsWhyChooseCountry->pkey]) . '
                    </div>
				</td>';
                $statusIcon = $lstItem[$i]['is_online'] == 1
                    ? '<i class="fa fa-check-circle green"></i>'
                    : '<i class="fa fa-minus-circle red"></i>';
                $html .= '<td data-title="' . $core->get_Lang('Status') . '" class="text-left block_responsive border_top_responsive">
                    <a href="javascript:void(0);" class="SiteClickPublic" clstable="WhyChooseCountry" pkey="why_choose_country_id" sourse_id="' . $lstItem[$i][$clsWhyChooseCountry->pkey] . '" rel="' . $lstItem[$i]['is_online'] . '" title="' . $core->get_Lang('Click to change status') . '">' . $statusIcon . '</a>
                </td>';
                $html .= '
                    <td class="block_responsive text-center" style="white-space:nowrap;" data-title="' . $core->get_Lang('func') . '">
                        <div class="btn-group">
                            <button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item clickEditWhyCountry" href="javascript:void(0);" data="' . $lstItem[$i][$clsWhyChooseCountry->pkey] . '">
                                        <i class="icon-edit"></i> ' . $core->get_Lang('edit') . '
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item clickDeleteWhyCountry" href="javascript:void(0);" data="' . $lstItem[$i][$clsWhyChooseCountry->pkey] . '">
                                        <i class="icon-remove"></i> ' . $core->get_Lang('delete') . '
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>';
            }
            $html .= '<a href="javascript:void(0);" id="clickToAddWhyCountry" class="btn_additinerary" title="' . $core->get_Lang('Add why choose country') . '">+ ' . $core->get_Lang('Add why choose country') . '</a>';
        } else {
            $html .= '<tr><td colspan="12">
				<div class="message" style="text-align:center">' . $core->get_Lang('no record found in here, please use') . ' <a style="text-decoration:underline" href="javascript:void(0);" id="clickToAddWhyCountry">' . $core->get_Lang('Add New') . '</a></div>
			</td></tr>';
        }
        $html .= '<script type="text/javascript">
			$("#tblWhyCountry").sortable({
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
					$.post(path_ajax_script+"/index.php?mod=country&act=ajUpdPosWhyCountry", order, function(html){
						loadWhyChooseCountry(country_id);
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
        echo $html;
        die();
    } elseif ($tp == 'F') {
        $html = '';
        $html .= '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . ($why_choose_country_id == 0 ? $core->get_Lang('Add Why Country') : $core->get_Lang('Edit Why Country')) . '- [ID #' . $country_id . ']</h3>
		</div>';
        $html .= '
		<form method="post" id="frmWhyCountry" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="fr full_width_991">
					<div class="photobox image center_991">
						<img src="' . ($why_choose_country_id > 0 ? $clsWhyChooseCountry->getOneField('image', $why_choose_country_id) : '') . '" id="isoman_show_image" />
						<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="' . ($why_choose_country_id > 0 ? $clsWhyChooseCountry->getOneField('image', $why_choose_country_id) : '') . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('Change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="' . ($why_choose_country_id > 0 ? $clsWhyChooseCountry->getOneField('image', $why_choose_country_id) : '') . '" isoman_name="image"><i class="iso-edit"></i></a>
						' . ($clsWhyChooseCountry->getOneField('image', $why_choose_country_id) != '' ? '<a pvalTable="' . $why_choose_country_id . '" clsTable="WhyChooseCountry" href="javascript:void()" title="' . $core->get_Lang('delete') . '" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>' : '') . '
					</div>
					<div class="wrap mt10 boxShowImages">
						<p class="text-center"><strong>' . $core->get_Lang('Image Size') . ' (WxH=68x68)</strong></p>
					</div>
				</div>
				<div class="fl full_width_991" style="width:76%">
					<div class="row-span">';
        $html .= '<div class="fieldlabel bold text-right text_left_767"><strong>' . $core->get_Lang('Title') . '</strong> <span class="color_r">*</span></div>';

        $html .= '<div class="fieldarea">';
        $html .= '<input type="text" name="title" class="text_32 border_aaa fontLarge full-width" id="title" value="' . $clsWhyChooseCountry->getOneField('title', $why_choose_country_id) . '"  />';
        $html .= '</div>
					</div>';
        $html .= '<div class="row-span">
						<div class="fieldlabel" style="text-align:right;font-weight:700">' . $core->get_Lang('Intro') . ' <span class="color_r">*</span></div>
						<div class="fieldarea">
							<textarea rows="5" cols="255" id="textarea_why_country_content_editor_' . time() . '" class="textarea_why_country_content_editor" style="width:100%">' . $clsWhyChooseCountry->getIntro($why_choose_country_id) . '</textarea>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="submit" why_choose_country_id="' . $why_choose_country_id . '" class="btn btn-primary btnSaveWhyCountry">
				<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
			</button>
		</div>';
        echo ($html);
        die();
    } elseif ($tp == 'S') {
        $titlePost = isset($_POST['title']) ? ucwords($_POST['title']) : '';
        $introPost = isset($_POST['content']) ? $_POST['content'] : '';
        $imagePost = isset($_POST['image']) ? $_POST['image'] : '';
        $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
        $why_choose_country_id = isset($_POST['why_choose_country_id']) ? intval($_POST['why_choose_country_id']) : 0;
        //        $is_show_image = isset($_POST['is_show_image']) ? intval($_POST['is_show_image']) : 0;
        #
        if ($why_choose_country_id > 0) {
            $v = "user_id_update='$user_id', title='$titlePost', intro='" . addslashes($introPost) . "', upd_date='" . time() . "', image='$imagePost'";
            #
            if ($clsWhyChooseCountry->updateOne($why_choose_country_id, $v)) {
                echo '_UPDATE_SUCCESS';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        } else {
            $max_id = $clsWhyChooseCountry->getMaxID();
            $fx = "$clsWhyChooseCountry->pkey,country_id,image,title,intro,reg_date,upd_date,user_id,user_id_update,is_trash,is_online,order_no";
            $vx = "'$max_id','$country_id','$imagePost','$titlePost','$introPost','" . time() . "','" . time() . "','$user_id','$user_id',0,1,'" . $clsWhyChooseCountry->getMaxOrderNo() . "'";
            #
            //            $clsWhyChooseCountry->setdebug(1);
            //            $clsWhyChooseCountry->insertOne($fx, $vx);
            //            die;
            if ($clsWhyChooseCountry->insertOne($fx, $vx)) {
                echo '_INSERT_SUCCESS';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        }
    } elseif ($tp == 'D') {
        $clsWhyChooseCountry->doDelete($why_choose_country_id);
        echo (1);
        die();
    }
}

function default_ajUpdPosWhyCountry()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsWhyChooseCountry = new WhyChooseCountry();
    $order = $_POST['order'];
    foreach ($order as $key => $val) {
        $key = $key + 1;
        $clsWhyChooseCountry->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_multi_country()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting, $clsISO;
    if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration') {

        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        $site_about_logo_home = $_POST['isoman_url_site_about_logo_home'];
        if ($site_about_logo_home != '' && $site_about_logo_home != '0') {
            $clsConfiguration->updateValue('site_about_logo_home', $site_about_logo_home);
        }
        header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess');
    }
}
