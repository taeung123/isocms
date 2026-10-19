<?php
function getFrame()
{
    global $core, $dbconn, $_LANG_ID, $clsISO;
    global $mod, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO, $package_id;
    $frames = array(
        'overview' => array(
            'href_group' => 'overview',
            'name' => $core->get_Lang('Overview'),
            'icon' => 'home',
            'steps' => array(
                'name' => array(
                    'name' => $core->get_Lang('Name and hotelcode')
                ),
                'location' => array(
                    'name' => $core->get_Lang('Location')
                ),
                'image' => array(
                    'name' => $core->get_Lang('Image cover')
                ),
                'overview' => array(
                    'name' => $core->get_Lang('Overview')
                ),
                'checkin' => array(
                    'name' => $core->get_Lang('Check-in/ Check-out')
                ),
                'booking_policy' => array(
                    'name' => $core->get_Lang('Booking Policy')
                ),
                'child_policy' => array(
                    'name' => $core->get_Lang('Children and bed policy')
                ),
                'cancellation_policy' => array(
                    'name' => $core->get_Lang('Cancellation Policy')
                ),

                'other_policy' => array(
                    'name' => $core->get_Lang('Other Rule')
                )
            )
        ),
    );
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'hotel_room', 'customize')) {
        $frames['room'] = array(
            'name' => $core->get_Lang('Room and Price'),
            'href_group' => 'room',
            'icon' => 'briefcase',
            'steps' => array(
                'room' => array(
                    'name' => $core->get_Lang('Room and Price')
                )
            )
        );
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'hotel_gallery', 'customize') && $clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', 'HotelFacilities')) {
        $frames['config'] = array(
            'name' => $core->get_Lang('Configs'),
            'href_group' => 'config',
            'icon' => 'setting',
            'steps' => array(
                'gallery' => array(
                    'name' => $core->get_Lang('Gallery')
                ),
                'hotel_facilities' => array(
                    'name' => $core->get_Lang('Hotel facilities')
                ),
            )
        );
    } elseif ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'hotel_gallery', 'customize')) {
        $frames['config'] = array(
            'name' => $core->get_Lang('Configs'),
            'href_group' => 'config',
            'icon' => 'setting',
            'steps' => array(
                'gallery' => array(
                    'name' => $core->get_Lang('Gallery')
                )
            )
        );
    } elseif ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', 'HotelFacilities')) {
        $frames['config'] = array(
            'name' => $core->get_Lang('Configs'),
            'href_group' => 'config',
            'icon' => 'setting',
            'steps' => array(
                'hotel_facilities' => array(
                    'name' => $core->get_Lang('Hotel facilities')
                ),
            )
        );
    }

    // $frames['price_table'] = array(
    //     'name' => $core->get_Lang('Price table'),
    //     'href_group' => 'price_table',
    //     'icon' => 'pricetable',
    //     'steps' => array(
    //         'price_config' => array(
    //             'name' => $core->get_Lang('Price config')
    //         ),
    //     )
    // );

    $frames['seo'] = array(
        'name' => $core->get_Lang('Seo tools'),
        'href_group' => 'seo',
        'icon' => 'seo',
        'steps' => array(
            'seo' => array(
                'name' => $core->get_Lang('Seo tools')
            ),
        )
    );
    return $frames;
}

function default_insert()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core, $pvalTable,
        $clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $show, $nextstep, $hotel_room_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list["show"] = $show;
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';

    $hotel_room_id = isset($_GET['hotel_room_id']) ? $_GET['hotel_room_id'] : 0;
    $pvalTable = Input::get('hotel_id', 0);
    $assign_list["pvalTable"] = $pvalTable;
    $panel = Input::get('panel', '');
    $assign_list["panel"] = $panel;

    $currentstep = Input::get('step', 'name');
    $assign_list["currentstep"] = $currentstep;


    //	$clsISO->pre($_GET);
    //    die();

    $currentstepx = 0;
    $frames = getFrame();
    $clsHotelRoom = new HotelRoom();
    $lstRoom = $clsHotelRoom->getAll("hotel_id='$pvalTable' order by order_no asc", "$clsHotelRoom->pkey, title");
    $arr_hotelRoom = [];
    // if (!empty($lstRoom)) {
    //     foreach ($lstRoom as $value) {
    //         $arr_hotelRoom['room-' . $value['hotel_room_id']] = [
    //             'name' => $value['title'],
    //             'id' => $value['hotel_room_id']
    //         ];
    //     }
    //     $frames['price_table']['steps'] = $arr_hotelRoom;
    // } else {
    //     unset($frames['price_table']);
    // }

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


    $classTable = "Hotel";
    $clsClassTable = new $classTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
        if ($currentstep == 'seo') {
            $clsMeta = new Meta();
            $assign_list["clsMeta"] = $clsMeta;
            $linkMeta = $clsClassTable->getLink($pvalTable);
            $allMeta = $clsMeta->getAll("config_link='$linkMeta'");
            $meta_id = $allMeta[0]['meta_id'];


            if (_isoman_use) {
                $image = $_POST['isoman_url_image'];
            } else {
                $image = $_POST['image_src'];
            }

            $schema = $clsMeta->getSchemaMarkupFromPost();
            if (!$schema['success']) {
                die();
            }
            $update_schema = ",schema_markup='" . addslashes($schema['data']) . "'";

            $titleMeta = $_POST['config_value_title'] ? addslashes($_POST['config_value_title']) : addslashes($_POST['title']);
            $introMeta = strip_tags(html_entity_decode(addslashes($_POST['iso-intro'])));
            $descriptionMeta = $_POST['config_value_intro'] ? addslashes($_POST['config_value_intro']) : substr($introMeta, 0, 160);
            $image_seo = isset($_POST['image_seo_src']) ? $_POST['image_seo_src'] : '';
            if (_isoman_use) {
                $image_seo = $_POST['isoman_url_image_seo'];
            }
            $image_seo = $image_seo ? $image_seo : $image;
            if ($meta_id == '') {
                $clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,meta_index,meta_follow,schema_markup ", "'" . $linkMeta . "','" . $titleMeta . "','" . $descriptionMeta . "','" . $image_seo . "','" . time() . "','" . time() . "','" . $clsMeta->getMaxId() . "','" . $_POST['meta_index'] . "','" . $_POST['meta_follow'] . "','" . addslashes($schema['data']) . "'");
                $allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
            } else {
                $clsMeta->updateOne($meta_id, "config_value_intro='" . $descriptionMeta . "',config_value_title='" . $titleMeta . "',image='" . $image_seo . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'" . $update_schema);
            }
        }
    }
    $clsClassTable->updateMinPrice($pvalTable);

    $arr_step = explode("-", $currentstep);
    if (count($arr_step) == 2) {
        $step_id = $arr_step[1];
        $assign_list["step_id"] = $step_id;
    }
}

function default_getMainFormStep()
{

    global $smarty, $assign_list, $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn, $nextstep, $clsConfiguration;


    $clsTag = new Tag();
    $clsCity = new City();
    $clsRegion = new Region();
    $clsCountry = new Country();
    $clsContinent = new Continent();
    $clsReviewsHotel = new ReviewsHotel();
    $clsHotel = new Hotel();
    $smarty->assign('clsTag', $clsTag);
    $smarty->assign('clsCity', $clsCity);
    $smarty->assign('clsRegion', $clsRegion);
    $smarty->assign('clsCountry', $clsCountry);
    $smarty->assign('clsContinent', $clsContinent);
    $smarty->assign('clsClassTable', $clsHotel);
    $smarty->assign('clsReviewsHotel', $clsReviewsHotel);

    #
    $table_id = Input::post('table_id', 0);
    $currentstep = Input::post('currentstep', '');
    $step_id = Input::post('step_id', 0);

    $oneItem = $clsHotel->getOne($table_id);

    $smarty->assign('pvalTable', $table_id);
    $smarty->assign('oneItem', $oneItem);
    $smarty->assign('clsTable', 'Hotel');
    $smarty->assign('clsTableGal', 'HotelImage');

    $frames = getFrame();
    $clsHotelRoom = new HotelRoom();
    $lstRoom = $clsHotelRoom->getAll("hotel_id='$table_id' order by order_no asc", "$clsHotelRoom->pkey, title");
    $arr_hotelRoom = [];
    // if (!empty($lstRoom)) {
    //     foreach ($lstRoom as $value) {
    //         $arr_hotelRoom['room-' . $value['hotel_room_id']] = [
    //             'name' => $value['title'],
    //             'id' => $value['hotel_room_id']
    //         ];
    //     }
    //     $frames['price_table']['steps'] = $arr_hotelRoom;
    // } else {
    //     unset($frames['price_table']);
    // }
    #Step follow index
    $ii = 0;
    $arrStep = array();
    foreach ($frames as $okey => $frame) {
        $steps = $frame['steps'];
        foreach ($steps as $key => $step) {
            $status = 0;
            if ($key == 'name' && $oneItem['title'] != '') {
                $status = 1;
            }
            if ($key == 'location' && $oneItem['continent_id'] > 0 && $oneItem['country_id'] > 0 && $oneItem['city_id'] > 0 && $oneItem['address'] != '') {
                $status = 1;
            }
            if ($key == 'image' && $oneItem['image'] != '') {
                $status = 1;
            }
            if ($key == 'overview' && $oneItem['overview'] != '') {
                $status = 1;
            }
            if ($key == 'checkin' && $oneItem['check_in_out_time'] != '') {
                $status = 1;
            }
            if ($key == 'thingAbout' && $oneItem['listThingAbout'] != '') {
                $status = 1;
            }
            if ($key == 'booking_policy' && $oneItem['booking_policy'] != '') {
                $status = 1;
            }
            if ($key == 'child_policy' && $oneItem['child_policy'] != '') {
                $status = 1;
            }
            if ($key == 'cancellation_policy' && $oneItem['cancellation_policy'] != '') {
                $status = 1;
            }
            if ($key == 'other_policy' && $oneItem['other_policy'] != '') {
                $status = 1;
            }
            if ($key == 'room') {
                $clsHotelRoom = new HotelRoom();
                $number_room = $clsHotelRoom->countItem("hotel_id='" . $table_id . "'");
                if ($number_room > 0) {
                    $status = 1;
                }
            }
            if ($key == 'gallery') {
                $clsHotelImage = new HotelImage();
                $number_image = $clsHotelImage->countItem("table_id='" . $table_id . "' and type='HotelImage'");
                if ($number_image > 0) {
                    $status = 1;
                }
            }
            if ($key == 'hotel_facilities' && $oneItem['list_HotelFacilities'] != '') {
                $status = 1;
            }
            if ($key == 'seo') {
                $clsMeta = new Meta();
                $link = $clsHotel->getLink($table_id);
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
    if ($currentstep == 'seo') {
        $clsMeta = new Meta();
        $assign_list["clsMeta"] = $clsMeta;
        $linkMeta = $clsHotel->getLink($table_id);
        $allMeta = $clsMeta->getAll("config_link='$linkMeta'");
        $meta_id = $allMeta[0]['meta_id'] ?? 0;

        if (empty($meta_id)) {
            $introMeta = strip_tags(html_entity_decode(addslashes($oneItem['overview'] ?? '')));
            $introMeta = explode('$trun$', wordwrap($introMeta, 280, '$trun$', false), 2);
            $introMeta = $introMeta[0] . (isset($introMeta[1]) ? '...' : '');
            $meta_id = $clsMeta->getMaxId();
            $clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,schema_markup", "'" . $linkMeta . "','" . $oneItem['title'] . "','" . $introMeta . "','" . $oneItem['image'] . "','" . time() . "','" . time() . "','" . $meta_id . "','" . ($oneItem['schema_markup'] ?? '') . "'");
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
    $smarty->assign('list_check_target', json_encode($arrStep));
    $smarty->assign('step_id', $step_id);
    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    //	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $smarty->assign('clsForm', $clsForm);
    #
    $clsForm->addInputTextArea("full", "overview", "", "overview", 255, 25, 8, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", "check_in_out_rule", "", "check_in_out_rule", 255, 25, 8, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", "hotel_booking_policy", "", "hotel_booking_policy", 255, 25, 15, 1, "style='width:100%'");
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
    global $_frontIsLoggedin_user_id, $core, $clsISO, $clsProperty, $clsUser, $_company_iom_id, $dbconn;
    #
    $msg = '_error';
    $clsClassTable = new Hotel();
    $table_id = Input::post('table_id', 0);
    $currentstep = Input::post('currentstep');

    if ($currentstep === 'name') {
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

    $postedSlug = trim(
        (string)Input::post('slug', '')
    );

    $changeUrl = (int)Input::post(
        'change_url',
        0
    );

    $currentTitle = trim(
        (string)($oneItem['title'] ?? '')
    );

    $currentSlug = trim(
        (string)($oneItem['slug'] ?? '')
    );

    $defaultTitle = 'New Hotel ' . (int)$table_id;
    $defaultSlug = 'new-hotel-' . (int)$table_id;

    /*
     * Hotel vừa được tạo bản ghi tạm vẫn có table_id,
     * nên không thể xác định add/edit chỉ bằng table_id.
     */
    $isNewHotel = (
        $currentSlug === '' ||
        $currentSlug === $defaultSlug ||
        $currentTitle === '' ||
        $currentTitle === $defaultTitle
    );

    if ($title === '') {
        echo '_error_title';
        die();
    }

    $star_id = (int)Input::post('star_id', 0);
    $type_hotel_id = (int)Input::post(
        'type_hotel_id',
        0
    );

    $tags_hotel = Input::post(
        'tags_hotel',
        array()
    );

    $tags_hotel = !empty($tags_hotel)
        ? $clsISO->makeSlashListFromArray(
            $tags_hotel,
            '|'
        )
        : '';

    $includes_taxes_fees = (int)Input::post(
        'includes_taxes_fees',
        0
    );

    $updateData = array(
        'title' => $title,
        'star_id' => $star_id,
        'list_TypeHotel' => $type_hotel_id,
        'tags_hotel' => $tags_hotel,
        'includes_taxes_fees' => $includes_taxes_fees,
        'upd_date' => time()
    );

    /*
     * HOTEL MỚI:
     * luôn lưu slug từ input; nếu input rỗng thì sinh từ Title.
     */
    if ($isNewHotel) {
        $slugToSave = $postedSlug !== ''
            ? $postedSlug
            : $title;

        $slugToSave = $clsISO->replaceSpace2(
            $slugToSave
        );

        if ($slugToSave !== '') {
            $updateData['slug'] = $slugToSave;
        }
    }

    /*
     * HOTEL EDIT:
     * chỉ thay slug khi tích Change URL.
     */
    if (!$isNewHotel && $changeUrl === 1) {
        $slugToSave = $postedSlug !== ''
            ? $postedSlug
            : $title;

        $slugToSave = $clsISO->replaceSpace2(
            $slugToSave
        );

        if ($slugToSave !== '') {
            $updateData['slug'] = $slugToSave;
        }
    }

    /*
     * Edit không tích Change URL:
     * không có key slug trong $updateData,
     * URL cũ được giữ nguyên.
     */
    $updated = $clsClassTable->updateOne(
        (int)$table_id,
        $updateData
    );

    if (!$updated) {
        echo '_error';
        die();
    }

    $meta_id = $clsISO->getMetaId(
        (int)$table_id,
        $clsClassTable
    );

    $clsISO->updateMetaConfigLink(
        $meta_id,
        (int)$table_id,
        'Hotel'
    );

    /*
     * REVIEWS HOTEL
     */
    $staff = Input::post('staff');
    $amenities = Input::post('amenities');
    $clean = Input::post('clean');
    $place = Input::post('place');
    $food_drink = Input::post('food_drink');
    $worthy = Input::post('worthy');

    $is_show_reviews = Input::post(
        'is_show_reviews',
        0
    );

    $is_show_reviews = $is_show_reviews ? 1 : 0;

    $clsReviewsHotel = new ReviewsHotel();

    $arr_reviews = array(
        'staff' => $clsISO->processSmartNumber($staff),
        'amenities' => $clsISO->processSmartNumber($amenities),
        'clean' => $clsISO->processSmartNumber($clean),
        'place' => $clsISO->processSmartNumber($place),
        'food_drink' => $clsISO->processSmartNumber($food_drink),
        'worthy' => $clsISO->processSmartNumber($worthy),
        'is_show_reviews' => $is_show_reviews
    );

    if ($clsReviewsHotel->checkExits((int)$table_id)) {
        $reviews_hotel_id =
            $clsReviewsHotel->getIdByHotel(
                (int)$table_id
            );

        $clsReviewsHotel->updateOne(
            $reviews_hotel_id,
            $arr_reviews
        );
    } else {
        $arr_reviews[$clsReviewsHotel->pkey] =
            $clsReviewsHotel->getMaxID();

        $arr_reviews['hotel_id'] = (int)$table_id;

        $clsReviewsHotel->insert($arr_reviews);
    }
}else if ($currentstep == 'location') {
        $continent_id = Input::post('iso-continent_id', 0);
        $country_id = Input::post('iso-country_id', 0);
        $region_id = Input::post('iso-region_id', 0);
        $city_id = Input::post('iso-city_id', 0);
        $address = Input::post('iso-address', '');
        $clsClassTable->updateOne($table_id, array(
            'continent_id' => intval($continent_id),
            'country_id' => intval($country_id),
            'region_id' => intval($region_id),
            'city_id' => intval($city_id),
            'address' => $address
        ));
    } else if ($currentstep == 'checkin') {
        $hour_in = Input::post('hour_in', 0);
        $minute_in = Input::post('minute_in', 0);
        $hour_out = Input::post('hour_out', 0);
        $minute_out = Input::post('minute_out', 0);

        $arr_time_check_in_out = array();
        $arr_time_check_in_out['hour_in'] = $hour_in > 24 ? 24 : $hour_in;
        $arr_time_check_in_out['minute_in'] = $minute_in > 60 ? 60 : $minute_in;
        $arr_time_check_in_out['hour_out'] = $hour_out > 24 ? 24 : $hour_out;
        $arr_time_check_in_out['minute_out'] = $minute_out > 60 ? 60 : $minute_out;
        $clsClassTable->updateOne($table_id, array(
            'check_in_out_time' => json_encode($arr_time_check_in_out),
            'upd_date' => time()
        ));
    } else if ($currentstep == 'image') {
        $image = Input::post('image', '');
        $clsClassTable->updateOne($table_id, array(
            'image' => $image
        ));
    } else if ($currentstep == 'hotel_facilities') {
        $list_HotelFacilities = Input::post('list_HotelFacilities', '');
        $list_HotelAccommodation = Input::post('list_HotelAccommodation', '');
        $list_HotelFacilities = $clsISO->makeSlashListFromArray($list_HotelFacilities);
        $list_HotelAccommodation = $clsISO->makeSlashListFromArray($list_HotelAccommodation);
        $clsClassTable->updateOne($table_id, array(
            'list_HotelFacilities' => $list_HotelFacilities,
            'list_HotelAccommodation' => $list_HotelAccommodation,
        ));
    } else if (in_array($currentstep, array(
        'overview',
        'checkin',
        'booking_policy',
        'child_policy',
        'cancellation_policy',
        'other_policy',
    ))) {
        $valueField = Input::post($currentstep);

        $clsClassTable->updateOne($table_id, array(
            $currentstep => $valueField
        ));
    } else if ($currentstep == 'seo') {
           $clsMeta = new Meta();

    $config_value_title = Input::post(
        'config_value_title',
        ''
    );

    $schema = $clsMeta->getSchemaMarkupFromPost();
    if (!$schema['success']) {
        die('_error');
    }
    $schema_markup = $schema['data'];

    $meta_id = (int)Input::post(
        'meta_id',
        0
    );

    $config_value_intro = Input::post(
        'config_value_intro',
        ''
    );

    $config_value_image = Input::post(
        'isoman_url_image_seo',
        ''
    );

    if ($meta_id > 0) {
        $clsMeta->updateOne(
            $meta_id,
            array(
                'config_value_title' => $config_value_title,
                'schema_markup' => $schema_markup,
                'config_value_intro' => $config_value_intro,
                'image' => $config_value_image,
                'upd_date' => time()
            )
        );
    } else {
        $hotel = new Hotel();
        $configLink = $hotel->getLink(
            (int)$table_id
        );

        $newMetaId = $clsMeta->getMaxId();

        $clsMeta->insertOne(
            'meta_id,config_link,config_value_title,' .
            'config_value_intro,image,schema_markup,reg_date,upd_date',
            "'" . $newMetaId . "'," .
            "'" . addslashes($configLink) . "'," .
            "'" . addslashes($config_value_title) . "'," .
            "'" . addslashes($config_value_intro) . "'," .
            "'" . addslashes($config_value_image) . "'," .
            "'" . addslashes($schema_markup) . "'," .
            "'" . time() . "'," .
            "'" . time() . "'"
        );
    }
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
    $clsClassTable = new Hotel();

    $table_id = Input::post('table_id', 0);
    $table_code = Input::post('table_code');
    $cond = "is_trash=0 and hotel_id<>'{$table_id}' and hotel_code='{$table_code}'";
    $totalItem = $clsClassTable->countItem($cond);
    echo ($totalItem == 1 ? '_invalid' : '_success');
    die();
}

function default_ajaxLoadHotelRoom()
{
    global $core, $mod, $act, $P;
    $clsHotel = new Hotel();
    $clsHotelRoom = new HotelRoom();
    #
    $hotel_id = $_POST['hotel_id'];
    $html = '';
    $lstRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no asc");
    if (!empty($lstRoom)) {
        $i = 0;
        foreach ($lstRoom as $item) {
            if ($clsHotelRoom->getNumberChild($item[$clsHotelRoom->pkey]) == 0) {
                $number_people = $clsHotelRoom->getNumberAdult($item[$clsHotelRoom->pkey]) . ' ' . $core->get_Lang('NL');
            } else {
                $number_people = $clsHotelRoom->getNumberAdult($item[$clsHotelRoom->pkey]) . ' ' . $core->get_Lang('NL') . ', ' . $clsHotelRoom->getNumberChild($item[$clsHotelRoom->pkey]) . ' ' . $core->get_Lang('TE');
            }

            $html .= '<tr style="cursor:move" id="order_' . $item[$clsHotelRoom->pkey] . '"  class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $html .= '<td class="text_left">' . $clsHotelRoom->getTitleRoomType($item['room_type_id']) . '</td>';
            $html .= '<td class="text_left">' . $clsHotelRoom->getTitle($item[$clsHotelRoom->pkey]) . '</td>';
            $html .= '<td class="text_center">' . $clsHotelRoom->getNumberRoom($item[$clsHotelRoom->pkey]) . '</td>';
            $html .= '<td class="text_center">' . $number_people . '</td>';
            $html .= '<td class="text_right">' . $clsHotelRoom->getPrice($item[$clsHotelRoom->pkey]) . '</td>';
            $html .= '<td></td>';
            $html .= '
			<td align="center" style="vertical-align: middle; text-align:center; width:50px; white-space: nowrap;">
				<div class="btn-group-ico d-flex">
					<a class="clickEditHotelRoom item_left" title="' . $core->get_Lang('edit') . '" href="javascript:void(0);"  data="' . $item[$clsHotelRoom->pkey] . '" hotel_id="' . $hotel_id . '"><i class="ico ico-edit"></i></a>
					<a class="clickDeleteHotelRoom item_right" title="' . $core->get_Lang('delete') . '" href="javascript:void(0);" data="' . $item[$clsHotelRoom->pkey] . '" hotel_id="' . $hotel_id . '"><i class="ico ico-remove"></i></a>
				</div>
            </td>';
            $html .= '</tr>';
            ++$i;
        }

        $html .= '
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
					var page = "' . ($page ?? 1) . '";
					var order = $(this).sortable("serialize")+\'&update=update\';
					$.post(path_ajax_script+"/index.php?mod=hotel&act=ajUpdPosSortHotelRoom", order, function(html){
						loadHotelRoom();
						vietiso_loading(0);
					});
				}
			});
		</script>';
    }
    echo $html;
    die();
}

function default_ajaxAddHotelRoom()
{

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL & ~E_STRICT);

    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $current_page, $core, $clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $clsISO;
    #
    $clsPagination = new Pagination();
    $clsCountry = new Country();
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    $clsHotelRoom = new HotelRoom();
    $assign_list['clsHotelRoom'] = $clsHotelRoom;

    $table_id = Input::post('table_id', 0);
    $assign_list['table_id'] = $table_id;
    $pvalTable = Input::post('hotel_room_id', 0);
    $assign_list['pvalTable'] = $pvalTable;

    $hotel_id = Input::post('hotel_id', 0);
    $assign_list['hotel_id'] = $hotel_id;

    if (!empty($pvalTable)) {
        $oneItem = $clsHotelRoom->getOne($pvalTable);
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

    $listRoomFacilities = $clsProperty->getAll("is_trash=0 and is_favorite=1 and type='RoomFacilities' order by order_no ASC", $clsProperty->pkey);
    $assign_list['listRoomFacilities'] = $listRoomFacilities;

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
    $html = $core->build('modal.addhotelroom.tpl');

    echo $html;
    die();
}

function default_ajSaveHotelRoom()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
    #
    $clsHotel = new Hotel();
    $clsHotelRoom = new HotelRoom();
    $user_id = $core->_USER['user_id'];
    $hotel_room_id = Input::post('hotel_room_id', 0);
    $hotel_id = Input::post('hotel_id', 0);
    $room_type_id = Input::post('room_type_id', 0);
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
    #
    $room_views_id = Input::post('room_views_id', array());
    $status_meal_id = Input::post('status_meal_id', 0);
    $cancel_room_id = Input::post('cancel_room_id', 0);
    $status_payment_id = Input::post('status_payment_id', 0);
    $highlight_room_id = Input::post('highlight_room_id', array());

    $room_facilities_id = Input::post('room_facilities_id', array());
    $image = Input::post('img', '');
    #
    //	$status_meal_id = !empty($status_meal_id) ? $clsISO->makeSlashListFromArray($status_meal_id, "|") : "";
    $highlight_room_id = !empty($highlight_room_id) ? $clsISO->makeSlashListFromArray($highlight_room_id, "|") : "";
    $room_views_id = !empty($room_views_id) ? $clsISO->makeSlashListFromArray($room_views_id, "|") : "";
    $room_facilities_id = !empty($room_facilities_id) ? $clsISO->makeSlashListFromArray($room_facilities_id, "|") : "";
    // if (_isoman_use) {
    //     $image = $_POST['isoman_url_image'];
    // } else {
    //     $image = $_POST['image_src'];
    // }
    $bed_option = array();
    foreach ($_POST['item_bed'] as $key => $val) {
        $bed_option[$key]['id'] = $val;
        $bed_option[$key]['number'] = $_POST['item_bed_number'][$key];
    }
    $bed_option = json_encode($bed_option);
    #
    $tp = Input::post('tp', 'SAVE');
    if (empty($hotel_room_id) && $tp == 'SAVE') {
        $hotel_id = (int)$hotel_id;
        $user_id = (int)$user_id;
        $room_type_id = (int)$room_type_id;

        /*
        * Danh sách phòng đang hiển thị order_no ASC.
        * Đẩy toàn bộ phòng cũ xuống một vị trí để phòng mới đứng đầu.
        */
        $listTable = $clsHotelRoom->getAll(
            "hotel_id='{$hotel_id}'",
            $clsHotelRoom->pkey . ',order_no'
        );

        if (is_array($listTable)) {
            foreach ($listTable as $roomItem) {
                $oldRoomId = isset($roomItem[$clsHotelRoom->pkey])
                    ? (int)$roomItem[$clsHotelRoom->pkey]
                    : 0;

                $oldOrderNo = isset($roomItem['order_no'])
                    ? (int)$roomItem['order_no']
                    : 0;

                if ($oldRoomId <= 0) {
                    continue;
                }

                /*
                * Các dữ liệu cũ có order_no=0 cũng được chuẩn hóa.
                */
                $newOrderNo = max(1, $oldOrderNo) + 1;

                $clsHotelRoom->updateOne(
                    $oldRoomId,
                    "order_no='{$newOrderNo}'"
                );
            }
        }

        $newRoomId = (int)$clsHotelRoom->getMaxId();
        $now = time();

        /*
        * Phòng mới luôn có order_no=1 nên đứng đầu với ORDER BY ASC.
        */
        $order_no = 1;

        $fx = $clsHotelRoom->pkey
            . ",hotel_id,user_id,room_type_id,title,slug"
            . ",number_val,footage,number_adult,number_children"
            . ",price,price_weekend,price_peak_time,bed_option"
            . ",order_no,reg_date,upd_date,image"
            . ",meal_id,cancel_id,payment_id"
            . ",list_highlight_id,list_viewroom_id,list_RoomFacilities";

        $vx = "'{$newRoomId}'"
            . ",'{$hotel_id}'"
            . ",'{$user_id}'"
            . ",'{$room_type_id}'"
            . ",'" . addslashes($titlePost) . "'"
            . ",'" . addslashes($slugPost) . "'"
            . ",'" . (int)$number_val . "'"
            . ",'" . addslashes($footage) . "'"
            . ",'" . (int)$number_adult . "'"
            . ",'" . (int)$number_child . "'"
            . ",'" . (float)$price . "'"
            . ",'" . (float)$price_weekend . "'"
            . ",'" . (float)$price_peak_time . "'"
            . ",'" . addslashes($bed_option) . "'"
            . ",'{$order_no}'"
            . ",'{$now}'"
            . ",'{$now}'"
            . ",'" . addslashes($image) . "'"
            . ",'" . (int)$status_meal_id . "'"
            . ",'" . (int)$cancel_room_id . "'"
            . ",'" . (int)$status_payment_id . "'"
            . ",'" . addslashes($highlight_room_id) . "'"
            . ",'" . addslashes($room_views_id) . "'"
            . ",'" . addslashes($room_facilities_id) . "'";

        // var_dump($fx, $vx);
        // die();
        if ($clsHotelRoom->insertOne($fx, $vx)) {
            $clsHotel->updateMinPrice($hotel_id);

            echo 'INSERT_SUCCESS';
            die();
        }

        echo 'INSERT_ERROR';
        die();
    }else {
        $value = "hotel_id='" . $hotel_id . "'";
        $value .= ",user_id_update='" . $user_id . "'";
        $value .= ",room_type_id='" . $room_type_id . "'";
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


        $value .= ",meal_id='" . $status_meal_id . "'";
        $value .= ",cancel_id='" . $cancel_room_id . "'";
        $value .= ",payment_id='" . $status_payment_id . "'";
        $value .= ",list_highlight_id='" . $highlight_room_id . "'";
        //		$value .= ",down_payment_status_id='" . $payment_down . "'";
        $value .= ",list_viewroom_id='" . $room_views_id . "'";
        $value .= ",list_RoomFacilities='" . $room_facilities_id . "'";


        if ($clsHotelRoom->updateOne($hotel_room_id, $value)) {
            $clsHotel->updateMinPrice($hotel_id);
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

function default_ajCheckTitleHotelRoom()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO;
    global $clsConfiguration;
    #
    $clsHotelRoom = new HotelRoom();
    $hotel_id = (int)Input::post('hotel_id', 0);
    $room_type_id = (int)Input::post('room_type_id', 0);
    $table_id = (int)Input::post('table_id', 0);
    $title_room = Input::post('title_room', '');
    $slug = $clsISO->replaceSpace2($title_room);
    $data = ['result' => true];
    if ($hotel_id > 0) {
        $cond = "hotel_id = '" . $hotel_id . "' and room_type_id='" . $room_type_id . "' and hotel_room_id !='$table_id' and slug='$slug'";
        $count_room = $clsHotelRoom->countItem($cond);
        if ($count_room > 0) {
            $data = ['result' => false];
        }
    }
    echo json_encode($data);
    die;
}

function default_ajUpdPosSortHotelRoom()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsHotelRoom = new HotelRoom();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsHotelRoom->updateOne($val, "order_no='" . $key . "'");
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
    $Html = '<option value="0"> --' . $core->get_Lang('City') . '-- </option>';
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

function default_ajCheckPublicHotel()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule, $clsISO, $package_id;
    //    header('Content-Type: application/json');
    $clsHotel = new Hotel();
    $pvalTable = isset($_POST['hotel_id']) ? $_POST['hotel_id'] : 0;
    $online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
    $oneItem = $clsHotel->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;

    $result = array('result' => '_ERR');
    $value = '';

    //    if($online){
    $value .= 'is_online=' . $online;
    //    }

    if ($clsHotel->updateOne($pvalTable, $value)) {
        $result = array('result' => '_SUCCESS');
    } else {
        $result = array('result' => '_ERR');
    }
    echo json_encode($result);
    die();
}

function default_checkExistTitle()
{
    global $dbconn, $_LANG_ID, $core, $smarty, $assign_list, $clsISO;
    $clsHotel = new Hotel();
    $hotel_id = (int)Input::post('table_id', 0);
    $title = Input::post('title', '');
    $data = ['result' => true];
    if ($hotel_id > 0) {
        if ($title != '') {
            $slug = $clsISO->replaceSpace2($title);
            $listAllHotel = $clsHotel->getAll("1=1 and slug='$slug' and hotel_id <>'$hotel_id'");
            if ($listAllHotel) {
                $data = [
                    'result' => false,
                    'message' => $core->get_Lang('Title exist'),
                    'type' => 'title'
                ];
                echo json_encode($data);
                die;
            }
        }
    }
    echo json_encode($data);
}

function default_updateListTypeBed()
{
    $clsProperty = new Property();
    $listTypeBed = $clsProperty->getAll("is_trash=0 and type='TypeBed'", "MAX($clsProperty->pkey) as property_id");
    $property_id = $listTypeBed[0]['property_id'];
    $fill_bed_name_select_box = "<option value='$property_id'>{$clsProperty->getTitle($property_id)}</option>";
    echo $fill_bed_name_select_box;
    die;
}

function default_ajaxHotelRoomAdd()
{
    global $clsISO, $core;
    $clsHotelRoom = new HotelRoom();
    $table_id = !empty($_POST['table_id']) ? $_POST['table_id'] : 0;
    $result = array('result' => false);
    if ($table_id > 0) {
        $hotel_room_id = $clsHotelRoom->getMaxId();
        $data = array(
            'hotel_id' => $table_id,
            'hotel_room_id' => $hotel_room_id,
            'user_id' => $core->_USER['user_id'],
            'title' => $core->get_Lang('New Hotel Room') . ' ' . $hotel_room_id,
            'reg_date' => time(),
            'upd_date' => time(),
            'order_no' => $clsHotelRoom->getMaxOrderNo(),
            'is_trash' => 0
        );
        if ($clsHotelRoom->insert($data)) {
            $result = array(
                'result' => true,
                'hotel_room_id' => $hotel_room_id
            );
        }

        die(json_encode($result));
    }
}
