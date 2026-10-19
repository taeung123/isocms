<?php
//HOTEL DEFAULT
function default_default()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];

    #
    $clsContinent = new Continent();
    $assign_list['clsContinent'] = $clsContinent;
    $clsCountry = new Country();
    $assign_list['clsCountry'] = $clsCountry;
    $clsRegion = new Region();
    $assign_list['clsRegion'] = $clsRegion;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;

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
            $link .= '&continent_id=' . $_POST['iso-continent_id'];
        }
        #
        if (isset($_POST['iso-area_id']) && intval($_POST['iso-area_id']) != '') {
            $link .= '&area_id=' . $_POST['iso-area_id'];
        }
        #
        if (isset($_POST['country_id']) && intval($_POST['country_id']) != '0') {
            $link .= '&country_id=' . $_POST['country_id'];
        }
        #
        if (isset($_POST['region_id']) && intval($_POST['region_id']) != '0') {
            $link .= '&region_id=' . $_POST['region_id'];
        }
        #
        if (isset($_POST['city_id']) && intval($_POST['city_id']) != '0' && intval($_POST['country_id']) != '0') {
            $link .= '&city_id=' . $_POST['city_id'];
        }
        #
        #
        if ($_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    // Get Parameter fiter
    $classTable = "AreaCity";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $cond = "1=1";
    #-- $continent_id
    if (intval($continent_id) > 0) {
        $cond .= " and continent_id='$continent_id'";
    }
    #-- $area_id
    if (intval($area_id) > 0) {
        $cond .= " and area_id='$area_id'";
    }
    #-- $country_id
    if (intval($country_id) > 0) {
        $cond .= " and country_id='$country_id'";
    }
    #-- $region_id
    if (intval($region_id) > 0) {
        $cond .= " and region_id='$region_id'";
    }
    #-- $city
    if (intval($city_id) > 0) {
        $cond .= " and city_id='$city_id'";
    }
    #-- $hotel_rating
    if ($keyword != '') {
        $slug = 'slug';
        $cond .= " and $slug like '%" . $core->replaceSpace($keyword) . "%'";
        $assign_list["keyword"] = $keyword;
    }
    #
    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    #
    $orderBy = " order by order_no ASC";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = 30;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $lstAllItem = $clsClassTable->getAll($cond);
    $totalRecord = (is_array($lstAllItem) && count($lstAllItem) > 0) ? count($lstAllItem) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
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
    $assign_list["allItem"] = $clsClassTable->getAll($cond . $orderBy . $limit);
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
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateHotel') {
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    $clsConfiguration->updateValue($tmp[1], $val);
                }
            }
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess');
        }
    }
}
function default_ajUpdPosSortAreaCity()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $classTable = "AreaCity";
    $clsClassTable = new $classTable;

    $order = $_POST['order'];
    $currentPage     = $_POST['currentPage'];
    $recordPerPage     = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    $list_order = [];
    foreach ($order as $key => $val) {
        $tour = $clsClassTable->getOne($val, 'order_no');
        $list_order[] = $tour['order_no'];
    }

    rsort($list_order);

    foreach ($order as $key => $val) {
        $clsClassTable->updateOne($val, 'order_no=' . $list_order[$key]);
    }
}
function default_edit()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsISO;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $pvalTable, $clsClassTable;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #

    $clsContinent = new Continent();
    $assign_list['clsContinent'] = $clsContinent;
    $clsCountry = new Country();
    $assign_list['clsCountry'] = $clsCountry;
    $clsRegion = new Region();
    $assign_list['clsRegion'] = $clsRegion;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    #
    $country_id = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;
    $city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : '';
    #
    $pUrl = '';
    if (isset($country_id) && intval($country_id) > 0) {
        $pUrl .= '&country_id=' . $country_id;
    }
    if (isset($city_id) && intval($city_id) > 0) {
        $pUrl .= '&city_id=' . $city_id;
    }
    if (isset($star) && !empty($star)) {
        $pUrl .= '&star=' . $star;
    }
    if ($city_id != '') {
        $pUrl .= '&city_id=' . $city_id;
    }
    #
    $classTable = "AreaCity";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;
    #
    $continent_id = $oneItem['continent_id'];
    $assign_list['continent_id'] = $continent_id;
    $country_id = $oneItem['country_id'];
    $assign_list['country_id'] = $country_id;
    $area_id = $oneItem['area_id'];
    $assign_list['area_id'] = $area_id;
    $city_id = $oneItem['city_id'];
    $assign_list['city_id'] = $city_id;


    #-------------Update Config Meta
    $clsMeta = new Meta();
    $assign_list["clsMeta"] = $clsMeta;
    $linkMeta = $clsClassTable->getLink($pvalTable);
    $allMeta = $clsMeta->getAll("config_link='$linkMeta'");
    $meta_id = $allMeta[0]['meta_id'];
    $assign_list["meta_id"] = $meta_id;
    $assign_list["oneMeta"] = $clsMeta->getOne($meta_id);
    #
    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;
    #
    $clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 2, 1,  "style='width:100%'");
    $clsForm->addInputTextArea("full", 'intro_hotel', "", 'intro_hotel', 255, 25, 2, 1,  "style='width:100%'");
    $clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 2, 1,  "style='width:100%'");
    #	
    #=========================================#
    if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
        if ($pvalTable > 0) {
            $set = "";
            $firstAdd = 0;
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    if ($firstAdd == 0) {
                        $set .= $tmp[1] . "='" . addslashes($val) . "'";
                        $firstAdd = 1;
                    } else {
                        $set .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                    }
                }
            }
            $set .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
            $set .= ",upd_date='" . time() . "'";
            $set .= ",slug='" . $core->replaceSpace($_POST['iso-title']) . "'";

            #--Special Field: image


            if (_isoman_use) {
                $set .= ",image='" . addslashes($_POST['isoman_url_image']) . "'";
            } else {
                $image = $_POST['image'];
                if ($image != '' && $image != '0') {
                    $set .= ",image='" . addslashes($image) . "'";
                }
            }
            $is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
            $set .= ",is_online='" . $is_online . "'";

            $tmp = $clsClassTable->getAll("slug = '%" . $core->replaceSpace($_POST['iso-title']) . "%' and country_id='" . $oneItem['country_id'] . "' and city_id <> '$pvalTable' limit 0,1");
            if ($tmp[0]['city_id'] != '') {
                header('location:' . PCMS_URL . '/?mod=' . $mod . '&act=edit&city_id=' . $pvalTable . '&continent_id=' . $oneItem['continent_id'] . '&country_id=' . $oneItem['country_id'] . '&message=DuplicateCity');
                exit();
            }
            #
            $pUrl = '';
            if (isset($_POST['iso-continent_id']) && intval($_POST['iso-continent_id']) != 0) {
                $pUrl .= "&continent_id=" . $_POST['iso-continent_id'];
            }
            if (isset($_POST['iso-country_id']) && intval($_POST['iso-country_id']) != 0) {
                $pUrl .= "&country_id=" . $_POST['iso-country_id'];
            }
            if (isset($_POST['iso-region_id']) && intval($_POST['iso-region_id']) != 0) {
                $pUrl .= "&region_id=" . $_POST['iso-region_id'];
            }
            if (isset($_POST['iso-city_id']) && intval($_POST['iso-city_id']) != 0) {
                $pUrl .= "&city_id=" . $_POST['iso-city_id'];
            }

            #
            if ($clsClassTable->updateOne($pvalTable, $set)) {
                if ($_POST['config_value_title'] != '' && $_POST['config_value_intro'] != '') {
                    if ($meta_id == '') {
                        $clsMeta->insertOne("config_link,reg_date,meta_id", "'" . $linkMeta . "','" . time() . "','" . $clsMeta->getMaxId() . "'");
                        $allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
                        $meta_id = $allMeta[0]['meta_id'];
                    }
                    $clsMeta->updateOne($meta_id, "config_value_intro='" . addslashes($_POST['config_value_intro']) . "',config_value_keyword='" . addslashes($_POST['config_value_keyword']) . "',config_value_title='" . addslashes($_POST['config_value_title']) . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
                }
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&area_city_id=' . $core->encryptID($pvalTable) . '&message=updateSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateFailed');
            }
        } else {
            $value = "";
            $firstAdd = 0;
            $field = "";
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    if ($firstAdd == 0) {
                        $field .= $tmp[1];
                        $value .= "'" . addslashes($val) . "'";
                        $firstAdd = 1;
                    } else {
                        $field .= ',' . $tmp[1];
                        $value .= ",'" . addslashes($val) . "'";
                    }
                }
            }
            #
            $max_id = $clsClassTable->getMaxId();
            $field .= ",user_id,user_id_update,reg_date,upd_date,slug,area_city_id,order_no";
            $value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
            $value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "','" . $max_id . "','" . $clsClassTable->getMaxOrderNo() . "'";

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
            }
            if ($image != '' && $image != '0') {
                $field .= ',image';
                $value .= ",'" . addslashes($image) . "'";
            }
            $is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
            $field .= ',is_online';
            $value .= ",'" . $is_online . "'";
            #
            $pUrl = '';
            if (isset($_POST['iso-continent_id']) && intval($_POST['iso-continent_id']) != 0) {
                $pUrl .= "&continent_id=" . $_POST['iso-continent_id'];
            }
            if (isset($_POST['iso-country_id']) && intval($_POST['iso-country_id']) != 0) {
                $pUrl .= "&country_id=" . $_POST['iso-country_id'];
            }
            if (isset($_POST['iso-region_id']) && intval($_POST['iso-region_id']) != 0) {
                $pUrl .= "&region_id=" . $_POST['iso-region_id'];
            }
            if (isset($_POST['iso-city_id']) && intval($_POST['iso-city_id']) != 0) {
                $pUrl .= "&city_id=" . $_POST['iso-city_id'];
            }
            //print_r($field.'<br />'.$value);die();
            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&area_city_id=' . $core->encryptID($max_id) . '&message=updateSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertFailed');
            }
        }
    }
}
function default_trash()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "AreaCity";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';

    $link_back = '/index.php?mod=' . $mod;
    $link_back .= $country_id != '' ? '&country_id=' . $country_id : '';
    $link_back .= $city_id != '' ? '&city_id=' . $city_id : '';

    if ($pvalTable == "")
        header('location: ' . PCMS_URL . $link_back . '&message=notPermission');

    $set = "is_trash = 1";
    if ($clsClassTable->updateOne($pvalTable, $set)) {
        header('location: ' . PCMS_URL . $link_back . '&message=TrashSuccess');
    }
}
function default_restore()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "AreaCity";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';

    $link_back = '/index.php?mod=' . $mod;
    $link_back .= $country_id != '' ? '&country_id=' . $country_id : '';
    $link_back .= $city_id != '' ? '&city_id=' . $city_id : '';

    if ($pvalTable == "")
        header('location: ' . PCMS_URL . $link_back . '&message=notPermission');

    $set = "is_trash = 0";
    if ($clsClassTable->updateOne($pvalTable, $set)) {
        header('location: ' . PCMS_URL . $link_back . '&message=RestoreSuccess');
    }
}
function default_delete()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "AreaCity";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $oneTable = $clsClassTable->getOne($pvalTable);
    #
    $country_id = isset($_GET['country_id']) ? intval($core->decryptID($_GET['country_id'])) : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    #
    $link_back = '/index.php?mod=' . $mod;
    $link_back .= $country_id != '' ? '&country_id=' . $country_id : '';
    $link_back .= $city_id != '' ? '&city_id=' . $city_id : '';

    if ($pvalTable == "")
        header('location: ' . PCMS_URL . $link_back . '&message=notPermission');

    if (isset($_POST['agree']) && $_POST['agree'] == 'agree') {
        if ($clsClassTable->deleteOne($pvalTable)) {
            #- Delete Image
            $clsImage = new Image();
            //$clsImage->deleteFile($_SERVER['DOCUMENT_ROOT'].$oneTable['image']);
            $clsImage->deleteByCond("type='hotel' and table_id='$pvalTable'");
            #- Delete Room
            $clsAreaCityRoom = new HotelRoom();
            $clsAreaCityRoom->deleteByCond("area_city_id='$pvalTable'");
            #- Delete Hotel Price Col
            $clsAreaCityPriceCol = new HotelPriceCol();
            $clsAreaCityPriceCol->deleteByCond("area_city_id='$pvalTable'");
            #- Delete Hotel Price Val
            $clsAreaCityPriceVal = new HotelPriceVal();
            $clsAreaCityPriceVal->deleteByCond("area_city_id='$pvalTable'");
            #
            header('location: ' . PCMS_URL . $link_back . '&message=DeleteSuccess');
        }
    }
}
function default_move()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];

    $classTable = "AreaCity";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    $star = isset($_GET['star']) ? $_GET['star'] : '';

    $where = '1=1 and is_trash=0 ';
    $link_back = "";
    if (!empty($_GET['country_id'])) {
        $where .= ' and country_id = ' . $_GET['country_id'] . '';
        $link_back .= '&country_id=' . $country_id;
    }
    if ($city_id != '') {
        $where .= ' and city_id = ' . $city_id . '';
        $link_back .= '&city_id=' . $city_id;
    }

    $one = $clsClassTable->getOne($pvalTable);
    $order_no = $one['order_no'];
    if ($pvalTable == "" || $direct == '') {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link_back);
    }
    if ($direct == 'movedown') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'moveup') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movebottom') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
        for ($i = 0; $i < count($lstItem); $i++) {
            $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
        }
    }
    if ($direct == 'movetop') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
        for ($i = 0; $i < count($lstItem); $i++) {
            $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
        }
    }
    header('location: ' . PCMS_URL . '/?mod=' . $mod . $link_back . '&message=PositionSuccess');
}
/* ======== SITE HOTEL SETTING ========== */
function default_setting()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsAreaCityProperty = new HotelProperty();
    $assign_list["clsAreaCityProperty"] = $clsAreaCityProperty;
    #
    if (isset($_POST['submit'])) {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
            if ($tmp[0] == 'date') {
                $clsConfiguration->updateValue($tmp[1], strtotime($val));
            }
        }
        $site_hotel_banner = $_POST['isoman_url_site_hotel_banner'];
        if ($site_hotel_banner != '' && $site_hotel_banner != '0') {
            $clsConfiguration->updateValue('site_hotel_banner', $site_hotel_banner);
        }
        $extUrl = '';
        if ($_POST['submit'] == 'UpdateConfiguration') {
            $extUrl = '#isotab0';
        }
        if ($_POST['submit'] == 'UpdateConfiguration1') {
            $extUrl = '#isotab1';
        }
        if ($_POST['submit'] == 'UpdateConfiguration2') {
            $extUrl = '#isotab2';
        }
        header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=updateSuccess' . $extUrl);
    }
}
