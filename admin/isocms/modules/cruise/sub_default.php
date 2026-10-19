<?php
function default_default()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsISO;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $pUrl = '';
    #
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsCruiseStore = new CruiseStore();
    $assign_list["clsCruiseStore"] = $clsCruiseStore;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    #
    $cruise_cat_id = isset($_GET['cruise_cat_id']) ? $_GET['cruise_cat_id'] : '';
    $assign_list["cruise_cat_id"] = $cruise_cat_id;
    #
    $cruise_type = $_GET['cruise_type'] ?? '';
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if (isset($_POST['cruise_cat_id']) && !empty($_POST['cruise_cat_id'])) {
            $link .= '&cruise_cat_id=' . $_POST['cruise_cat_id'];
        }
        if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
            $link .= '&keyword=' . rawurlencode($_POST['keyword']);
        }
        if (isset($_POST['cruise_type']) && !empty($_POST['cruise_type'])) {
            $link .= '&cruise_type=' . $_POST['cruise_type'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    /*Get type of list news*/
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    /**/
    $classTable = "Cruise";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    /*List all item*/

    $cond = "1=1";
    #Filter By Category
    if (isset($cruise_cat_id) && intval($cruise_cat_id) != 0) {
        $cond .= " and (cruise_cat_id = '$cruise_cat_id' or list_cat_id like '%|" . $cruise_cat_id . "|%')";
        $pUrl .= '&cruise_cat_id=' . $cruise_cat_id;
    }
    $assign_list["pUrl"] = $pUrl;
    #Filter By Keyword
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $keyword = $core->replaceSpace($_GET['keyword']);
        $cond .= " and slug like '%" . $keyword . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
        $pUrl .= '&keyword=' . rawurlencode($_GET['keyword']);
    }
    #Filter by Type
    if (!empty($cruise_type)) {
        $cond .= " and cruise_type = '$cruise_type'";
        $pUrl .= '&cruise_type=' . $cruise_type;
        $assign_list["cruise_type"] = $cruise_type;
    }
    $assign_list["pUrl"] = $pUrl;
    $cond2 = $cond;
    if ($type_list == 'Publish') {
        $cond .= " and is_trash=0 and is_online=1";
    } elseif ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    } elseif ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    #
    $orderBy = " order_no asc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? max(1, (int) $_GET["recordperpage"]) : 20;
    $currentPage = isset($_GET["page"]) ? max(1, (int) $_GET["page"]) : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $lstAllItem = $clsClassTable->getAll($cond);
    $totalRecord = (is_array($lstAllItem) && count($lstAllItem) > 0) ? count($lstAllItem) : 0;
    $totalPage = $totalRecord > 0 ? (int) ceil($totalRecord / $recordPerPage) : 0;
    if ($totalPage > 0 && $currentPage > $totalPage) {
        $currentPage = $totalPage;
        $start_limit = ($currentPage - 1) * $recordPerPage;
        $limit = " limit $start_limit,$recordPerPage";
    }
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
    $assign_list['previousPage'] = max(1, $currentPage - 1);
    $assign_list['nextPage'] = min(max(1, $totalPage), $currentPage + 1);
    $assign_list['showingStart'] = $totalRecord > 0 ? $start_limit + 1 : 0;
    $assign_list['showingEnd'] = min($start_limit + $recordPerPage, $totalRecord);

    $stt = ($currentPage - 1) * $recordPerPage;
    $assign_list['stt'] = $stt;
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    $cruiseRecordPerPageFilterUrl = $pUrl;
    if ($type_list !== '') {
        $cruiseRecordPerPageFilterUrl .= '&type_list=' . rawurlencode($type_list);
    }
    $assign_list['cruiseRecordPerPageFilterUrl'] = $cruiseRecordPerPageFilterUrl;
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit, $clsClassTable->pkey . ",is_trash,is_online,order_no,cruise_cat_id,reg_date,upd_date,user_id,user_id_update, cruise_type");
    $assign_list["allItem"] = $allItem;
    #
    $allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2);
    $assign_list["number_trash"] = count($allTrash) ?? 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2);
    $assign_list["number_item"] = count($allUnTrash) ?? 0;
    $allPublish = $clsClassTable->getAll("is_trash=0 and is_online=1 and " . $cond2);
    $assign_list["number_publish"] = is_array($allPublish) ? count($allPublish) : 0;
    #
    $allAll = $clsClassTable->getAll($cond2);
    $assign_list["number_all"] = count($allAll) ?? 0;
    //print_r('xxxxxxx'); die();

}

function default_ajUpdPosSortCruise()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCruise = new Cruise();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    $list_order = [];
    foreach ($order as $key => $val) {
        $tour = $clsCruise->getOne($val, 'order_no');
        $list_order[] = $tour['order_no'];
    }

    sort($list_order);

    foreach ($order as $key => $val) {
        $clsCruise->updateOne($val, 'order_no=' . $list_order[$key]);
    }
}

function default_edit()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $pvalTable, $clsClassTable, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $clsTag = new Tag();
    $assign_list["clsTag"] = $clsTag;

    $clsCruiseStore = new CruiseStore();
    $assign_list["clsCruiseStore"] = $clsCruiseStore;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruiseVideo = new CruiseVideo();
    $assign_list["clsCruiseVideo"] = $clsCruiseVideo;
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsContinent = new Continent();
    $assign_list["clsContinent"] = $clsContinent;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCountryLang = new _Country();
    $assign_list["clsCountryLang"] = $clsCountryLang;

    $clsISO = new ISO();
    $assign_list["clsISO"] = $clsISO;
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    $clsReviewsCruise = new ReviewsCruise();
    $assign_list["clsReviewsCruise"] = $clsReviewsCruise;
    $clsCruiseDataProperty = new CruiseDataProperty();
    $assign_list["clsCruiseDataProperty"] = $clsCruiseDataProperty;

    $lstCountryLang = $clsCountryLang->getAll("is_trash=0 order by language asc", $clsCountryLang->pkey);
    $assign_list["lstCountryLang"] = $lstCountryLang;
    unset($lstCountryLang);

    #
    #
    $assign_list["listCountry"] = $clsCountry->getAll("is_trash=0 and is_online=1");
    #
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', 'CruiseServices')) {
        $lstCruiseService = $clsCruiseProperty->getAll("is_trash=0 and type = 'CruiseServices' order by order_no asc");
        $assign_list["lstCruiseService"] = $lstCruiseService;
        unset($lstCruiseService);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', 'CruiseBudget')) {
        $lstCruiseBudget = $clsCruiseProperty->getAll("is_trash=0 and type = 'CruiseBudget' order by order_no asc");
        $assign_list["lstCruiseBudget"] = $lstCruiseBudget;
        unset($lstCruiseBudget);
    }
    #
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', 'TravelAs')) {
        $lstCruiseTravel = $clsCruiseProperty->getAll("is_trash=0 and type = 'TravelAs' order by order_no asc");
        $assign_list["lstCruiseTravel"] = $lstCruiseTravel;
        unset($lstCruiseTravel);
    }
    #
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', 'RestFacilities')) {
        $lstRestFa = $clsCruiseProperty->getAll("is_trash=0 and type = 'RestFacilities' order by order_no asc");
        $assign_list["lstRestFa"] = $lstRestFa;
        unset($lstRestFa);
    }
    #
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', 'CruiseFacilities')) {
        $lstCruiseFa = $clsCruiseProperty->getAll("is_trash=0 and type = 'CruiseFacilities' order by order_no asc");
        $assign_list["lstCruiseFa"] = $lstCruiseFa;
        unset($lstCruiseFa);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', 'ThingAbout')) {
        $lstThingAbout = $clsCruiseProperty->getAll("is_trash=0 and type = 'ThingAbout' order by order_no asc");
        $assign_list["lstThingAbout"] = $lstThingAbout;
        unset($lstCruiseFa);
    }
    #
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', 'CruiseFaActivities')) {
        $lstCruiseFaActivities = $clsCruiseProperty->getAll("is_trash=0 and type = 'CruiseFaActivities' order by order_no asc");
        $assign_list["lstCruiseFaActivities"] = $lstCruiseFaActivities;
        unset($lstCruiseFaActivities);
    }


    #
    $classTable = "Cruise";
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

    $cruisecat_id = $oneItem['cruise_cat_id'];
    $assign_list["cruisecat_id"] = $cruisecat_id;

    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'edit_cabin', 'default')) {
        $listCabin = $clsCruiseCabin->getAll("1=1 and cruise_id='$pvalTable' order by order_no asc", $clsCruiseCabin->pkey . ",is_trash");
        $assign_list['listCabin'] = $listCabin;
        unset($listCabin);
    }
    #

    $lstCruiseItinerary = $clsCruiseItinerary->getAll("1=1 and cruise_id='$pvalTable' order by order_no asc");
    $assign_list['listCruiseItinerary'] = $lstCruiseItinerary;
    unset($lstCruiseItinerary);

    $listCruiseVideo = $clsCruiseVideo->getAll("1=1 and table_id='$pvalTable' order by order_no asc");
    $assign_list['listCruiseVideo'] = $listCruiseVideo;
    unset($listCruiseVideo);


    #- Custom Field
    $clsCruiseCustomField = new CruiseCustomField();
    $assign_list["clsCruiseCustomField"] = $clsCruiseCustomField;
    $listCustomField = $clsCruiseCustomField->getAll("cruise_id='$pvalTable' and fieldtype='CUSTOM' order by order_no ASC");
    $assign_list["listCustomField"] = $listCustomField;
    unset($listCustomField);


    #-------------Update Config Meta
    $clsMeta = new Meta();
    $assign_list["clsMeta"] = $clsMeta;
    $linkMeta = $clsClassTable->getLink($pvalTable);
    $allMeta = $clsMeta->getAll("config_link='$linkMeta'");
    $meta_id = $allMeta[0]['meta_id'];
    $assign_list["meta_id"] = $meta_id;
    $assign_list["oneMeta"] = $clsMeta->getOne($meta_id);

    if ($string != '' && $pvalTable == 0)
        header('location:' . PCMS_URL . '/#notPermission');

    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;
    $clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'inclusion', "", 'inclusion', 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'exclusion', "", 'exclusion', 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'cruise_policy', "", 'cruise_policy', 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'booking_policy', "", 'booking_policy', 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'child_policy', "", 'child_policy', 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'booking_condition', "", 'booking_condition', 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'easy_cancellation', "", 'easy_cancellation', 255, 25, 15, 1, "style='width:100%'");


    $clsForm->addInputTextArea("full", 'about', "", 'about', 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'most_about', "", 'most_about', 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'important_notes', "", 'important_notes', 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'note_price', "", 'note_price', 255, 25, 10, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'cruise_map', "", 'cruise_map', 255, 25, 10, 1, "style='width:100%'");
    #
    if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
        $value = "";
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
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

        #
        $cruise_cat_id = isset($_POST['cruise_cat_id']) ? $_POST['cruise_cat_id'] : 0;
        if (isset($cruise_cat_id) && count($cruise_cat_id) > 0) {
            $list_cat_id = $clsCruiseCat->getListParent($cruise_cat_id);
            $value .= ",cruise_cat_id='$cruise_cat_id'";
            $value .= ",list_cat_id='" . $list_cat_id . "'";
        }

        $tagPost = $_POST['tag_id'];
        if (is_array($tagPost) && count($tagPost) > 0) {
            $list_tag_id = '|0|';
            foreach ($tagPost as $key => $valx) {
                $list_tag_id .= $valx . '|';
            }
            $value .= ",list_tag_id='" . addslashes($list_tag_id) . "'";
        } else {
            $value .= ",list_tag_id=''";
        }
        $title = $_POST['title'];
        $title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
        $star_number = isset($_POST['star_number']) ? $_POST['star_number'] : 0;
        $value .= ",title='" . $title . "'";
        $value .= ",slug='" . $clsISO->replaceSpace2($_POST["title"]) . "'";
        $value .= ",upd_date='" . time() . "',user_id_update='" . addslashes($core->_SESS->user_id) . "'";
        $value .= ",discount_text_rate='" . $_POST['discount_text_rate'] . "'";

        $value .= ",total_cabin='" . $clsISO->processSmartNumber($_POST['total_cabin']) . "'";
        $value .= ",star_number='" . $star_number . "'";

        #- Update Custom Field
        if ($clsConfiguration->getValue("SiteHasCustomField_Cruise")) {
            $clsCruiseCustomField = new CruiseCustomField();
            $listCustomField = $clsCruiseCustomField->getAll("fieldtype='CUSTOM' and cruise_id='$pvalTable' order by order_no ASC");
            if (is_array($listCustomField) && count($listCustomField) > 0) {
                for ($i = 0; $i < count($listCustomField); $i++) {
                    $set = "fieldvalue='" . addslashes($_POST['Site_Custom_Field_value_' . $listCustomField[$i][$clsCruiseCustomField->pkey]]) . "'";
                    $clsCruiseCustomField->updateOne($listCustomField[$i][$clsCruiseCustomField->pkey], $set);
                }
            }
            unset($listCustomField);
            unset($set);
        }


        #--Special Field: image
        if (_isoman_use) {
            $image = $_POST['isoman_url_image'];
            $value .= ",image='" . addslashes($image) . "'";
        } else {
            $image = $_POST['image'];
            if ($image != '' && $image != '0') {
                $value .= ",image='" . addslashes($image) . "'";
            }
        }

        $value .= ",listTravelAs='" . $clsISO->makeSlashListFromArrayComma($_POST['listTravelAs']) . "'";
        $value .= ",listCruiseBudget='" . $clsISO->makeSlashListFromArrayComma($_POST['listCruiseBudget']) . "'";
        $value .= ",listCruiseFacilities='" . $clsISO->makeSlashListFromArrayComma($_POST['listCruiseFacilities']) . "'";
        $value .= ",listCruiseFaActivities='" . $clsISO->makeSlashListFromArrayComma($_POST['listCruiseFaActivities']) . "'";
        $value .= ",listThingAbout='" . $clsISO->makeSlashListFromArrayComma($_POST['listThingAbout']) . "'";


        $pUrl = '';
        if (isset($cruise_cat_id) && intval($cruise_cat_id) != 0) {
            $pUrl .= "&cruise_cat_id=" . $cruise_cat_id;
        }

        $totalRateCruise = $clsISO->processSmartNumber($_POST['cruise_quality']) + $clsISO->processSmartNumber($_POST['food_drink']) + $clsISO->processSmartNumber($_POST['cabin_quality']) + $clsISO->processSmartNumber($_POST['staff_quality']) + $clsISO->processSmartNumber($_POST['entertainment']);


        $listNearestEssentials = $clsCruiseProperty->getAll("is_trash=0 and type='NearestEssentials' and cruise_property_id IN ($listNearestEssentials) order by order_no ASC", $clsCruiseProperty->pkey);


        if (is_array($listNearestEssentials) && count($listNearestEssentials) > 0) {
            foreach ($listNearestEssentials as $k => $v) {
                $fx = "user_id,user_id_update,cruise_id,fieldvalue,$clsCruiseDataProperty->pkey,order_no,upd_date,cruise_property_id,type";
                $vx = "'$user_id','$user_id','$pvalTable','" . addslashes($_POST['cruise_nearestessentials_' . $pvalTable . $v[$clsCruiseProperty->pkey]]) . "','" . $pvalTable . $v[$clsCruiseProperty->pkey] . "','" . $clsCruiseDataProperty->getMaxOrderNo() . "','" . time() . "','" . $v[$clsCruiseProperty->pkey] . "','NearestEssentials'";
                $clsCruiseDataProperty->insertOne($fx, $vx);
            }
        }

        $listUsefulInformation = $clsCruiseProperty->getAll("is_trash=0 and type='UsefulInformation' and cruise_property_id IN ($listUsefulInformation) order by order_no ASC", $clsCruiseProperty->pkey);


        if (is_array($listUsefulInformation) && count($listUsefulInformation) > 0) {
            foreach ($listUsefulInformation as $k => $v) {
                $fx = "user_id,user_id_update,cruise_id,fieldvalue,$clsCruiseDataProperty->pkey,order_no,upd_date,cruise_property_id,type";
                $vx = "'$user_id','$user_id','$pvalTable','" . addslashes($_POST['cruise_usefulinformation_' . $pvalTable . $v[$clsCruiseProperty->pkey]]) . "','" . $pvalTable . $v[$clsCruiseProperty->pkey] . "','" . $clsCruiseDataProperty->getMaxOrderNo() . "','" . time() . "','" . $v[$clsCruiseProperty->pkey] . "','UsefulInformation'";
                $clsCruiseDataProperty->insertOne($fx, $vx);
            }
        }


        $listCruiseDataNearestEssentials = $clsCruiseDataProperty->getAll("cruise_id='$pvalTable' and type='NearestEssentials' order by order_no ASC");

        if (is_array($listCruiseDataNearestEssentials) && count($listCruiseDataNearestEssentials) > 0) {
            for ($i = 0; $i < count($listCruiseDataNearestEssentials); $i++) {
                $set = "fieldvalue='" . addslashes($_POST['cruise_nearestessentials_' . $listCruiseDataNearestEssentials[$i][$clsCruiseDataProperty->pkey]]) . "'";
                //print_r($set); die();
                $clsCruiseDataProperty->updateOne($listCruiseDataNearestEssentials[$i][$clsCruiseDataProperty->pkey], $set);
            }
        }

        $listCruiseDataUsefulInformation = $clsCruiseDataProperty->getAll("cruise_id='$pvalTable' and type='UsefulInformation' order by order_no ASC");

        if (is_array($listCruiseDataUsefulInformation) && count($listCruiseDataUsefulInformation) > 0) {
            for ($i = 0; $i < count($listCruiseDataUsefulInformation); $i++) {
                $set = "fieldvalue='" . addslashes($_POST['cruise_usefulinformation_' . $listCruiseDataUsefulInformation[$i][$clsCruiseDataProperty->pkey]]) . "'";
                //print_r($set); die();
                $clsCruiseDataProperty->updateOne($listCruiseDataUsefulInformation[$i][$clsCruiseDataProperty->pkey], $set);
            }
        }
        unset($listCruiseDataProperty);
        unset($set);
        $is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
        $set .= ",is_online='" . $is_online . "'";


        //$value .= ",total_rate='".$totalRateCruise."'";
        //print_r($pvalTable.'<br/>'.$value); die();
        #
        if ($clsClassTable->updateOne($pvalTable, $value)) {

            $clsCruiseItinerary->updateByCond("cruise_id='$pvalTable'", "star_number='" . $_POST['star_number'] . "',listCruiseFaActivities='" . $clsISO->makeSlashListFromArrayComma($_POST['listCruiseFaActivities']) . "'");
            $titleMeta = $_POST['config_value_title'] ? addslashes($_POST['config_value_title']) : addslashes($_POST['title']);
            $introMeta = strip_tags(html_entity_decode(addslashes($_POST['iso-about'])));
            $descriptionMeta = $_POST['config_value_intro'] ? addslashes($_POST['config_value_intro']) : substr($introMeta, 0, 160);
            $image_seo = isset($_POST['image_seo_src']) ? $_POST['image_seo_src'] : '';
            if (_isoman_use) {
                $image_seo = $_POST['isoman_url_image_seo'];
            }
            $image_seo = $image_seo ? $image_seo : $image;
            if ($meta_id == '') {
                $clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,meta_index,meta_follow", "'" . $linkMeta . "','" . $titleMeta . "','" . $descriptionMeta . "','" . $image_seo . "','" . time() . "','" . time() . "','" . $clsMeta->getMaxId() . "','" . $_POST['meta_index'] . "','" . $_POST['meta_follow'] . "'");
                $allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
            } else {
                $clsMeta->updateOne($meta_id, "config_value_intro='" . $descriptionMeta . "',config_value_title='" . $titleMeta . "',image='" . $image_seo . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
            }
            #
            if ($clsReviewsCruise->checkExits($pvalTable)) {
                $is_show_reviews = isset($_POST['is_show_reviews']) ? 1 : 0;
                $reviews_cruise_id = $clsReviewsCruise->getIdByCruise($pvalTable);
                $vx = "cruise_quality = '" . $clsISO->processSmartNumber($_POST['cruise_quality']) . "',food_drink = '" . $clsISO->processSmartNumber($_POST['food_drink']) . "',cabin_quality = '" . $clsISO->processSmartNumber($_POST['cabin_quality']) . "',staff_quality = '" . $clsISO->processSmartNumber($_POST['staff_quality']) . "',entertainment = '" . $clsISO->processSmartNumber($_POST['entertainment']) . "',excellent = '" . $clsISO->processSmartNumber($_POST['excellent']) . "',very_good = '" . $clsISO->processSmartNumber($_POST['very_good']) . "',good = '" . $clsISO->processSmartNumber($_POST['good']) . "',average = '" . $clsISO->processSmartNumber($_POST['average']) . "',poor = '" . $clsISO->processSmartNumber($_POST['poor']) . "',terrible = '" . $clsISO->processSmartNumber($_POST['terrible']) . "',is_show_reviews = '" . $is_show_reviews . "'";
                $clsReviewsCruise->updateOne($reviews_cruise_id, $vx);
            } else {
                $totalRateCruise = $clsISO->processSmartNumber($_POST['cruise_quality']) + $clsISO->processSmartNumber($_POST['food_drink']) + $clsISO->processSmartNumber($_POST['cabin_quality']) + $clsISO->processSmartNumber($_POST['staff_quality']) + $clsISO->processSmartNumber($_POST['entertainment']);
                $is_show_reviews = isset($_POST['is_show_reviews']) ? 1 : 0;
                $fx = "$clsReviewsCruise->pkey,cruise_id,cruise_quality,food_drink,cabin_quality,staff_quality,entertainment,excellent,very_good,good,average,poor,terrible,is_show_reviews";
                $vx = "'" . $clsReviewsCruise->getMaxID() . "','$pvalTable','" . $clsISO->processSmartNumber($_POST['cruise_quality']) . "','" . $clsISO->processSmartNumber($_POST['food_drink']) . "','" . $clsISO->processSmartNumber($_POST['cabin_quality']) . "','" . $clsISO->processSmartNumber($_POST['staff_quality']) . "','" . $clsISO->processSmartNumber($_POST['entertainment']) . "','" . $clsISO->processSmartNumber($_POST['excellent']) . "','" . $clsISO->processSmartNumber($_POST['very_good']) . "','" . $clsISO->processSmartNumber($_POST['good']) . "','" . $clsISO->processSmartNumber($_POST['average']) . "','" . $clsISO->processSmartNumber($_POST['poor']) . "','" . $clsISO->processSmartNumber($_POST['terrible']) . "','" . $is_show_reviews . "'";
                $clsReviewsCruise->insertOne($fx, $vx);
            }
            #
            if ($_POST['button'] == '_EDIT') {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . $pUrl . '&message=UpdateSuccess');
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=UpdateSuccess');
            }
        } else {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . $pUrl . '&message=updateFailed');
        }
    }
}

function default_trash()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Cruise";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $cruise_cat_id = isset($_GET['cruise_cat_id']) ? $_GET['cruise_cat_id'] : "";

    $param_url = '';
    if (intval($cruise_cat_id) != 0) {
        $param_url .= '&cruise_cat_id=' . $cruise_cat_id;
    }

    if ($pvalTable == "")
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=notPermission');

    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=TrashSuccess');
    }
}

function default_restore()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Cruise";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $cruise_cat_id = isset($_GET['cruise_cat_id']) ? $_GET['cruise_cat_id'] : "";

    $param_url = '';
    if (intval($cruise_cat_id) != 0) {
        $param_url .= '&cruise_cat_id=' . $cruise_cat_id;
    }

    if ($pvalTable == "")
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=notPermission');

    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=RestoreSuccess');
    }
}

function default_move()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Cruise";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $pvalTable = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $cruise_cat_id = isset($_GET['cruise_cat_id']) ? $_GET['cruise_cat_id'] : "";
    $direct = isset($_GET['direct']) ? $_GET['direct'] : '';

    $one = $clsClassTable->getOne($pvalTable);
    $order_no = $one['order_no'];

    if ($pvalTable == "" || $direct == '') {
        header('location: ' . PCMS_URL . '/?mod=' . $mod);
    }

    $where = '1=1 and is_trash=0 ';
    $param_url = '';
    if (intval($cruise_cat_id) != 0) {
        $where .= " and (cruise_cat_id='$cruise_cat_id' or list_cat_id like '%|" . $cruise_cat_id . "|%')";
        $param_url .= '&cruise_cat_id=' . $cruise_cat_id;
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
    header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=PositionSuccess');
}

function default_delete()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Cruise";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $cruise_cat_id = isset($_GET['cruise_cat_id']) ? $_GET['cruise_cat_id'] : "";

    $param_url = '';
    if (intval($cruise_cat_id) != 0) {
        $param_url .= '&cruise_cat_id=' . $cruise_cat_id;
    }

    if ($string = '' && $pvalTable == 0)
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

    if ($clsClassTable->doDelete($pvalTable)) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=DeleteSuccess');
    }
}

function default_setting()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsCruiseStore = new CruiseStore();
    $assign_list["clsCruiseStore"] = $clsCruiseStore;
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

function default_childpolicy()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsCruiseStore = new CruiseStore();
    $assign_list["clsCruiseStore"] = $clsCruiseStore;
    #


    if (isset($_POST['submit'])) {
        if ($_POST['iso-InfantMaxAgePolicy'] <= $_POST['iso-InfantMinAgePolicy']) {
            header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=updateFailed');
            exit();
        }
        if ($_POST['iso-ChildMinAgePolicy'] <= $_POST['iso-InfantMaxAgePolicy']) {
            header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=updateFailed');
            exit();
        }
        if ($_POST['iso-ChildMaxAgePolicy'] <= $_POST['iso-ChildMinAgePolicy']) {
            header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=updateFailed');
            exit();
        }
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
            if ($tmp[0] == 'date') {
                $clsConfiguration->updateValue($tmp[1], strtotime($val));
            }
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
        header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=updateSuccess');
    }
}

/*------ Load Type Cruise -------*/
function default_liststore()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $clsUser = new User();
    $pUrl = '';
    $user_group_id = $clsUser->getOneField('user_group_id', $user_id);
    #
    if ($clsConfiguration->getValue('SiteHasStore_Cruises') == 0) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    #
    $type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : '';
    $assign_list["type"] = $type;
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    $cruise_cat_id = isset($_GET['cruise_cat_id']) ? intval($_GET['cruise_cat_id']) : 0;
    $assign_list["cruise_cat_id"] = $cruise_cat_id;

    if ($type == '') {
        header('location: ' . PCMS_URL . '/?mod=cruise&message=notPermission');
    }
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=' . $act . '&type=' . $core->encryptID($type);
        if (isset($_POST['cruise_cat_id']) && intval($_POST['cruise_cat_id']) != '0') {
            $link .= '&cruise_cat_id=' . $_POST['cruise_cat_id'];
        }
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Type trip code or tour name') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    #
    $classTable = "CruiseStore";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $cond = "1=1 and is_trash=0";
    $cond .= " and cruise_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise WHERE is_trash=0 and is_online=1)";

    if (!empty($type)) {
        $cond .= " and _type = '" . $type . "'";
        $pUrl .= '&type=' . $core->encryptID($type);
    }
    if (isset($cruise_cat_id) && intval($cruise_cat_id) != 0) {
        $cond .= " and cruise_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise WHERE cruise_cat_id = '" . $cruise_cat_id . "' or list_cat_id like '%|" . $cruise_cat_id . "|%')";
        $pUrl .= '&cruise_cat_id=' . $cruise_cat_id;
    }
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $keyword = $core->replaceSpace($_GET['keyword']);
        $cond .= " and cruise_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise WHERE slug like '%" . $keyword . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $orderBy = " order by order_no asc";
    #
    $allItem = $clsClassTable->getAll($cond . $orderBy);
    $assign_list["allItem"] = $allItem;
    $assign_list["pUrl"] = $pUrl;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Delete') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($pvalTable)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        #
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no desc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no asc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=PositionSuccess');
    }

    #----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateCruiseTypeIntro') {
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    $clsConfiguration->updateValue($tmp[1], $val);
                }
            }
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=UpdateSuccess');
        }
    }
}

function default_store()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    $pUrl = '';
    #
    $clsCruiseStore = new CruiseStore();
    $assign_list["clsCruiseStore"] = $clsCruiseStore;
    #
    $classTable = "Cruise";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    #
    $type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : '';
    $assign_list["type"] = $type;
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $assign_list["keyword"] = $keyword;

    if ($type == '') {
        header('location: ' . PCMS_URL . '/?mod=cruise&message=notPermission');
    }
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=' . $act;
        $link .= '&type=' . $core->encryptID($type);

        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Tìm kiếm...') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    #
    $cond = "is_trash=0 and is_online=1";

    if ($type != '') {
        $cond .= " and cruise_id NOT IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise_store WHERE is_trash=0 and _type='$type')";
        $pUrl .= '&type=' . $core->encryptID($type);
    }
    if ($keyword != '') {
        $slug = $core->replaceSpace($keyword);
        $cond .= " and slug like '%" . $slug . "%'";
    }
    $orderBy = " order_no asc";


    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = 20;
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
    $stt = ($currentPage - 1) * $recordPerPage;
    $assign_list['stt'] = $stt;

    $assign_list['listPageNumber'] = $listPageNumber;
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $link_page_current = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        //		print_r($lst_query_string);die();
        if ($tmp[0] != 'page')
            $link_page_current .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current'] = $link_page_current;

    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
    //	print_r($cond." order by ".$orderBy.$limit);die();
    $listItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);

    $assign_list["listItem"] = $listItem;


    #
    $listSelected = $clsCruiseStore->getAll("is_trash=0 and _type = '$type' order by order_no asc");
    $assign_list["listSelected"] = $listSelected;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Add') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if (!$clsCruiseStore->checkExist($pvalTable, $type)) {
            $listTable = $clsCruiseStore->getAll("1=1 and _type='$type'", $clsCruiseStore->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsCruiseStore->updateOne($listTable[$i][$clsCruiseStore->pkey], "order_no='" . $order_no . "'");
            }
            $max_order_no = $clsCruiseStore->getMaxOrder($type);
            $max_id = $clsCruiseStore->getMaxId();
            $f = $clsCruiseStore->pkey . ",cruise_id,_type,order_no";
            $v = "'$max_id','$pvalTable','$type','1'";
            //print_r($f.'</br>'.$v);die();
            if ($clsCruiseStore->insertOne($f, $v)) {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=insertSuccess');
            }
        }
    }
    //print_r(xxxx); die();
}

function default_promotion()
{
    //	ini_set('display_errors', '1');
    //	ini_set('display_startup_errors', '1');
    //	error_reporting(E_ALL);
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    #
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    /**/
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $classTable = "Promotion";
    $clsPromotion = new Promotion();
    $tableName = $clsPromotion->tbl;
    $pkeyTable = $clsPromotion->pkey;
    $assign_list["clsPromotion"] = $clsPromotion;
    $assign_list["pkeyTable"] = $pkeyTable;
    /* List all item */
    $cond = "1='1' and type= 'CRUISE'";
    #Filter By Keyword
    if (isset($_GET['keyword'])) {
        if ($_GET['keyword'] != '') {
            $keyword = $core->replaceSpace($_GET['keyword']);
            $cond .= " and slug like '%" . $keyword . "%'";
            $assign_list["keyword"] = $_GET['keyword'];
        }
    }
    $assign_list["type"] = 'CRUISE';


    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default', 'CRUISE')) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }
    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    } elseif ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " promotion_id desc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $lstAllItem = $clsPromotion->getAll($cond);
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsPromotion->getAll($cond . " order by " . $orderBy . $limit); //print_r($cond." order by ".$orderBy.$limit);die();
    $assign_list["allItem"] = $allItem;
    #
    $allTrash = $clsPromotion->getAll("is_trash=1 and " . $cond2);
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allUnTrash = $clsPromotion->getAll("is_trash=0 and " . $cond2);
    $assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
    #
    $allAll = $clsPromotion->getAll($cond2);
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
    #----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateConfiguration') {
            $clsConfiguration->updateValue('SitePromotionEnable', $_POST['SitePromotionEnable']);
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess');
        }
    }
}

function default_ajDeleteCruiseStore()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsClassTable = new CruiseStore();
    $pvalTable = isset($_POST['cruise_store_id']) ? $_POST['cruise_store_id'] : 0;
    $clsClassTable->deleteOne($pvalTable);
    echo (1);
    die();
}

function default_ajUpdPosSortTourStore()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCruiseStore = new CruiseStore();
    $type = $_POST['type'];
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsCruiseStore->updateByCond("cruise_id='$val' and _type='$type'", "order_no='" . $key . "'");
    }
}

function default_ajSaveStoreForCruise()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruiseStore = new CruiseStore();
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $list_cruise_id = isset($_POST['list_cruise_id']) ? $_POST['list_cruise_id'] : '';
    $list_cruise_id = rtrim($list_cruise_id, '|');

    if ($list_cruise_id != '') {
        $tmp = explode('|', $list_cruise_id);
        if (!empty($tmp)) {
            foreach ($tmp as $i) {
                if (!$clsCruiseStore->checkExist($i, $type)) {
                    #
                    $max_id = $clsCruiseStore->getMaxID();
                    $max_order = $clsCruiseStore->getMaxOrder($type);
                    $f = "$clsCruiseStore->pkey,cruise_id,_type,order_no";
                    $v = "'$max_id','$i','$type','$max_order'";
                    $clsCruiseStore->insertOne($f, $v);
                }
            }
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    } else {
        echo '_ERROR';
        die();
    }
}

function default_ajUpdPosSortListCruiseStore()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $classTable = "CruiseStore";
    $clsClassTable = new $classTable;
    $order = $_POST['order'];
    $type = $_POST['type'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        /*$key = (($currentPage-1)*$recordPerPage + $key + 1);*/
        $key = $key + 1;
        $clsClassTable->updateByCond("cruise_id='$val' and _type='$type'", "order_no='" . $key . "'");
    }
}

function default_listcruise()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $clsUser = new User();
    $pUrl = '';
    $user_group_id = $clsUser->getOneField('user_group_id', $user_id);
    #
    if ($clsConfiguration->getValue('SiteHasStore_Cruises') == 0) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsCruiseStore = new CruiseStore();
    $assign_list["clsCruiseStore"] = $clsCruiseStore;
    #
    $type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : '';
    $assign_list["type"] = $type;
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    $cruise_cat_id = isset($_GET['cruise_cat_id']) ? intval($_GET['cruise_cat_id']) : 0;
    $assign_list["cruise_cat_id"] = $cruise_cat_id;

    if ($type == '') {
        header('location: ' . PCMS_URL . '/?mod=tour&message=notPermission');
    }
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=' . $act . '&type=' . $core->encryptID($type);
        if (isset($_POST['cruise_cat_id']) && intval($_POST['cruise_cat_id']) > '0') {
            $link .= '&cruise_cat_id=' . $_POST['cruise_cat_id'];
        }
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Type trip code or tour name') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    #
    $classTable = "Cruise";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $cond = "is_trash=0 and is_online=1";

    if (!empty($type)) {
        $cond .= " and cruise_id NOT IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise_store WHERE _type='" . $type . "')";
        $pUrl .= '&type=' . $core->encryptID($type);
    }
    if (isset($cruise_cat_id) && intval($cruise_cat_id) != 0) {
        $cond .= " and (cruise_cat_id = '" . $cruise_cat_id . "' or list_cat_id like '%|" . $cruise_cat_id . "|%')";
        $pUrl .= '&cruise_cat_id=' . $cruise_cat_id;
    }
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $keyword = $core->replaceSpace($_GET['keyword']);
        $cond .= " and slug like '%" . $keyword . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;
    if ($user_group_id == 2) {
        $cond .= " and is_online='0' and user_id='$user_id'"; //
    }
    $orderBy = " order by order_no desc";

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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . $orderBy . $limit); //print_r($cond.$orderBy.$limit);die();
    $assign_list["allItem"] = $allItem;
    $assign_list['pUrl'] = $pUrl;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Add') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if (!$clsCruiseStore->checkExist($pvalTable, $type)) {
            $max_id = $clsCruiseStore->getMaxID();
            $max_order = $clsCruiseStore->getMaxOrder($type);
            $f = "cruise_store_id,cruise_id,_type,order_no";
            $v = "'$max_id','$pvalTable','$type','$max_order'";
            if ($clsCruiseStore->insertOne($f, $v)) {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=insertSuccess');
            }
        }
    }
}

/*------ Cruise Destination -------*/
function default_ajLoadListDestination()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCruiseDestination = new CruiseDestination();
    $clsContinent = new Continent();
    $clsCountry = new Country();
    $clsRegion = new Region();
    $clsCity = new City();
    $clsCruise = new Cruise();
    $clsGuide = new Guide();
    $cruise_id = $_POST['cruise_id'];
    $cruise_itinerary_id = $_POST['cruise_itinerary_id'];

    $html = '';
    #
    $lstDestination = $clsCruiseDestination->getAll("is_trash=0 and cruise_itinerary_id='$cruise_itinerary_id' order by order_no asc");
    if (is_array($lstDestination) && count($lstDestination) > 0) {
        foreach ($lstDestination as $k => $v) {
            $title = '';
            if (intval($v['chauluc_id']) > 0) {
                $title .= ' &raquo; ' . $clsContinent->getTitle($v['chauluc_id']);
            }
            if (intval($v['country_id']) > 0) {
                $title .= ' &raquo; ' . $clsCountry->getTitle($v['country_id']);
            }
            if (intval($v['region_id']) > 0) {
                $title .= ' &raquo; ' . $clsRegion->getTitle($v['region_id']);
            }
            if (intval($v['city_id']) > 0) {
                $title .= ' &raquo; ' . $clsCity->getTitle($v['city_id']);
            }
            if (intval($v['placetogo_id']) > 0) {
                $title .= ' &raquo; ' . $clsGuide->getTitle($v['placetogo_id']);
            }
            $html .= '<li style="cursor:move" id="order_' . $v[$clsCruiseDestination->pkey] . '"><strong><a href="javascript:void(0);" title="' . $core->get_Lang('Drag & drop change position') . '">' . $title . '</a></strong><span class="remove removeDestination" data="' . $v[$clsCruiseDestination->pkey] . '">x</span></li>';
        }
        $html .= '
		<li style="cursor:pointer;width:120px;height:30px;margin-top:15px;position:relative;padding-left: 35px;text-align: left;line-height: 30px;" class="ajRemoveAllDestinationInCruise iso-button-primary"><i class="ico ico-remove-white"></i> ' . $core->get_Lang('deleteall') . '</li>';
        $html .= '
		<script type="text/javascript">
			$("#lstDestination").sortable({
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
					$.post(path_ajax_script+"/index.php?mod=cruise&act=ajaxUpdateCruiseDestination", order, function(html){
						vietiso_loading(0);
					});
				}
			});
		</script>';
        unset($lstDestination);
    }
    echo $html;
    die();
}

function default_ajmakeSelectPlaceToGoGlobal()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsGuide = new Guide();
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
    $city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;
    $guide_id = isset($_POST['guide_id']) ? intval($_POST['guide_id']) : 0;
    #
    $cond = "is_trash=0 and is_online=1 and cat_id='15'";
    if ($country_id > 0) {
        $cond .= " and country_id='$country_id'";
    }
    if ($city_id > 0) {
        $cond .= " and city_id='$city_id'";
    }
    #
    $html = '<option value="0">' . $core->get_Lang('selectplacetogo') . '</option>';
    if (!empty($clsGuide->getAll($cond))) {
        $lstPlaceToGo = $clsGuide->getAll($cond . " order by slug asc", $clsGuide->pkey);
        if (!empty($lstPlaceToGo)) {
            foreach ($lstPlaceToGo as $k => $v) {
                $html .= '<option value="' . $v[$clsGuide->pkey] . '" ' . ($guide_id == $v[$clsGuide->pkey] ? 'selected="selected"' : '') . '>' . $clsGuide->getTitle($v[$clsGuide->pkey]) . '</option>';
            }
            unset($lstPlaceToGo);
        }
    } else {
        $html = 'EMPTY';
    }
    echo $html;
    die();
}

function default_ajaxUpdateCruiseDestination()
{
    $clsCruiseDestination = new CruiseDestination();
    #
    $_array_id = $_POST['order'];
    if ($_POST['update'] == 'update' && !empty($_array_id)) {
        $n = 1;
        foreach ($_array_id as $k => $v) {
            $clsCruiseDestination->updateOne($v, "order_no='$n'");
            ++$n;
        }
    }
    echo (1);
    die();
}

function default_ajaxDeleteAllCruiseDestination()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruiseDestination = new CruiseDestination();
    $cruise_id = $_POST['cruise_id'];
    #
    $clsCruiseDestination->deleteByCond("cruise_id='$cruise_id'");
    echo (1);
    die();
}

function default_ajaxDeleteCruiseDestination()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruiseDestination = new CruiseDestination();
    $cruise_destination_id = $_POST['cruise_destination_id'];
    #
    $clsCruiseDestination->deleteOne($cruise_destination_id);
    echo (1);
    die();
}

function default_ajLoadFormAddQuickCity()
{
    global $core;
    #
    $clsCountry = new Country();
    $clsCity = new City();
    $country_id = $_POST['country_id'];
    $forid = $_POST['forid'];
    #
    $html = '';
    $html .= '<div class="headPop">
				<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('entertitle') . '"></a>
				<h3>' . $core->get_Lang('Add new city') . ' - ' . $clsCountry->getTitle($country_id) . '</h3>
			</div>';
    $html .= '<table class="form" cellpadding="3" cellspacing="3">
				<tr>
					<td class="fieldlabel">' . $core->get_Lang('City name') . '</td>
					<td class="fieldarea"><input type="text" name="title" autocomplete="off" class="text" style="width:95%" /></td>
				</tr>
			</table>';
    $html .= '<div class="modal-footer">
			<a class="iso-button-primary fl ajSubmitQuickCity" country_id="' . $country_id . '" forid="' . $forid . '" city_id="0"><i class="icon-check icon-white"></i> ' . $core->get_Lang('add') . '</a>
			<a class="iso-button-standard close_pop fr"><i class="icon icon-cancel"></i> ' . $core->get_Lang('close') . '</a></div>';
    echo $html;
    die();
}

function default_ajSubmitQuickCity()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsCity = new City();
    $titlePost = trim(addslashes($_POST['title']));
    $slugPost = $core->replaceSpace($titlePost);
    $countryPost = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    #
    $res = $clsCity->getAll("is_trash=0 and slug like '%" . $slugPost . "%' limit 0,1");
    if (!empty($res)) {
        echo '_EXIST';
        die();
    } else {
        $max_id = $clsCity->getMaxId();
        $max_order = $clsCity->getMaxOrderNo();
        #
        $f = 'city_id,title,slug,country_id,reg_date,upd_date,user_id_update,user_id,order_no';
        $v = "'$max_id','$titlePost','$slugPost','$countryPost','" . time() . "','" . time() . "','$user_id','$user_id','$max_order'";
        if ($clsCity->insertOne($f, $v)) {
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}

/*------ Ajax -------*/

/*------ START_SELECTBOX_GEO -------*/
function default_ajLoadChauLuc()
{
    $clsContinent = new Continent();
    #
    $lst = $clsContinent->getAll("is_trash=0 order by title asc");
    $html = '';
    if (!empty($lst)) {
        foreach ($lst as $item) {
            $html .= '<option value="' . $item[$clsContinent->pkey] . '">' . $clsContinent->getTitle($item[$clsContinent->pkey]) . '</option>';
        }
    }
    echo $html;
    die();
}

function default_ajLoadCountry()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCountry = new Country();
    $chauluc_id = isset($_POST['chauluc_id']) ? intval($_POST['chauluc_id']) : 0;
    $khuvuc_id = isset($_POST['khuvuc_id']) ? intval($_POST['khuvuc_id']) : 0;
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
    #
    $cond = "is_trash=0";
    if (intval($chauluc_id) > 0) {
        $cond .= " and continent_id='$chauluc_id'";
    }
    if (intval($khuvuc_id) > 0) {
        $cond .= " and khuvuc_id='$khuvuc_id'";
    }
    #
    $html = "<option value='0'> -- " . $core->get_Lang('selectcountry') . " -- </option>";
    $rslist = $clsCountry->getAll($cond . " order by order_no ASC", $clsCountry->pkey);
    if (is_array($rslist) && count($rslist) > 0) {
        foreach ($rslist as $k => $v) {
            $html .= '<option value="' . $v[$clsCountry->pkey] . '" ' . ($country_id == $v[$clsCountry->pkey] ? 'selected="selected"' : '') . '> -- ' . $clsCountry->getTitle($v[$clsCountry->pkey]) . ' -- </option>';
        }
        unset($rslist);
    }
    echo $html;
    die();
}

function default_ajLoadAreaList()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsArea = new Area();
    $country_id = $_POST['country_id'];
    $area_id = isset($_POST['area_id']) ? intval($_POST['area_id']) : 0;

    $cond = "is_trash=0 and country_id='$country_id' order by order_no asc";
    $html = "<option value='0'> -- " . $core->get_Lang('selectarea') . " -- </option>";
    $lstArea = $clsArea->getAll($cond, $clsArea->pkey);
    if (is_array($lstArea) && count($lstArea) > 0) {
        foreach ($lstArea as $k => $v) {
            $html .= '<option value="' . $v[$clsArea->pkey] . '" ' . ($area_id == $v[$clsArea->pkey] ? 'selected="selected"' : '') . '>' . $clsArea->getTitle($v[$clsArea->pkey]) . '</option>';
        }
        unset($lstArea);
    }
    echo $html;
    die();
}

function default_ajLoadRegion()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsRegion = new Region();
    $country_id = $_POST['country_id'];
    $region_id = isset($_POST['region_id']) ? intval($_POST['region_id']) : 0;
    #
    if ($clsRegion->getAll("country_id='$country_id'") != '') {
        $html = $clsRegion->makeSelectboxOption($country_id, $region_id);
    } else {
        $html = 'EMPTY';
    }
    echo $html;
    die();
}

function default_ajmakeSelectCityGlobal()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCity = new City();
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 1;
    $region_id = isset($_POST['region_id']) ? intval($_POST['region_id']) : 0;
    $city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;
    $cruise_id = isset($_POST['cruise_id']) ? intval($_POST['cruise_id']) : 0;
    #
    $cond = "is_trash=0 and is_online=1 and country_id='$country_id'";
    if ($region_id > 0) {
        $cond .= " and region_id='$region_id'";
    }
    if ($cruise_id > 0) {
        $cond .= " and city_id NOT IN (SELECT city_id FROM " . DB_PREFIX . "cruise_destination WHERE country_id='$country_id' and cruise_id='$cruise_id')";
    }
    #
    $html = '<option value="0"> -- ' . $core->get_Lang('selectcity') . ' --</option>';
    $lstCity = $clsCity->getAll($cond . " order by order_no ASC", $clsCity->pkey);
    if (!empty($lstCity)) {
        foreach ($lstCity as $k => $v) {
            $html .= '<option value="' . $v[$clsCity->pkey] . '" ' . ($city_id == $v[$clsCity->pkey] ? 'selected="selected"' : '') . '> -- ' . $clsCity->getTitle($v[$clsCity->pkey]) . ' -- </option>';
        }
        unset($lstCity);
    }
    echo $html;
    die();
}

function default_ajCaculatorCruisePriceOld()
{
    global $clsISO;

    $price_old = $clsISO->processSmartNumber($_POST['price_old']);
    $hot_deals = $clsISO->processSmartNumber($_POST['hot_deals']);
    echo $clsISO->formatNumberToEasyRead($price_old - (($price_old * $hot_deals) / 100));
    die();
}

function default_ajUpdateCruiseStore()
{
    global $core, $dbconn;
    #
    $clsClassTable = new CruiseStore();
    $_type = isset($_POST['_type']) ? $_POST['_type'] : '';
    $cruise_id = isset($_POST['cruise_id']) ? $_POST['cruise_id'] : 0;
    $val = isset($_POST['val']) ? $_POST['val'] : 0;
    $user_id = $core->_USER['user_id'];
    #
    $lst = $clsClassTable->getAll("cruise_id='$cruise_id' and _type = '" . $_type . "' limit 0,1");
    if (isset($lst[0][$clsClassTable->pkey]) && $val == 0) {
        $cruise_store_id = $lst[0][$clsClassTable->pkey];
        $clsClassTable->deleteOne($cruise_store_id);
    } else {
        $fx = "cruise_store_id,cruise_id,_type,order_no";
        $vx = "'" . $clsClassTable->getMaxID() . "','$cruise_id','$_type','" . $clsClassTable->getMaxOrder($_type) . "'";
        $clsClassTable->insertOne($fx, $vx);
    }
    echo 1;
    die();
}

function default_ajLoadCruiseStoreModal()
{
    global $core, $dbconn, $clsISO, $clsConfiguration;
    $clsCruise = new Cruise();
    $clsCruiseCat = new CruiseCat();
    $clsCruiseStore = new CruiseStore();

    $_type = isset($_POST['_type']) ? $_POST['_type'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : 'F';
    $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
    $cruise_cat_id = isset($_POST['cruise_cat_id']) ? intval($_POST['cruise_cat_id']) : 0;

    if ($tp == 'L') {
        $cond = "is_trash=0 and is_online=1";
        if ($cruise_cat_id > 0) {
            $cond .= " and (cruise_cat_id = '$cruise_cat_id' or list_cat_id like '%|" . $cruise_cat_id . "|%')";
        }
        if (!empty($keyword)) {
            $slug = $core->replaceSpace($keyword);
            $cond .= " and (slug like '%" . $slug . "%' or title like '%" . addslashes($keyword) . "%')";
        }
        $orderBy = " order by order_no desc";
        $lstCruise = $clsCruise->getAll($cond . $orderBy);

        $html = '';
        if (!empty($lstCruise)) {
            foreach ($lstCruise as $i => $item) {
                $cruise_id = $item['cruise_id'];
                $title = $clsCruise->getTitle($cruise_id);
                $catName = $clsCruise->getCatName($cruise_id);
                $isAdded = $clsCruiseStore->checkExist($cruise_id, $_type);

                $html .= '<tr id="modal_cruise_row_' . $cruise_id . '">';
                $html .= '<td class="text-center">' . ($i + 1) . '</td>';
                $html .= '<td><strong>' . htmlspecialchars($title) . '</strong></td>';
                $html .= '<td>' . htmlspecialchars($catName) . '</td>';
                $html .= '<td class="text-center">';
                if ($isAdded) {
                    $html .= '<button type="button" class="btn btn-sm btn-success disabled text-white" style="opacity:1 !important; background-color:#28a745 !important; border-color:#28a745 !important; color:#ffffff !important; font-weight:500; cursor:default;"><i class="fa fa-check"></i> Added</button>';
                } else {
                    $html .= '<button type="button" class="btn btn-sm btn-outline-primary btnClickStoreCruise" data-cruise_id="' . $cruise_id . '" data-_type="' . $_type . '" data-val="1"><i class="fa fa-plus"></i> ' . $core->get_Lang('Add') . '</button>';
                }
                $html .= '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="4" class="text-center text-muted">' . $core->get_Lang('nodata') . '</td></tr>';
        }
        echo json_encode(array('result' => true, 'html' => $html));
        die();
    }

    $storeTitle = $clsCruiseStore->getTitle($_type);
    if (empty($storeTitle)) {
        $storeTitle = $_type;
    }

    $catOptions = $clsCruiseCat->makeSelectboxOption($cruise_cat_id, 0);

    $cond = "is_trash=0 and is_online=1";
    $orderBy = " order by order_no desc";
    $lstCruise = $clsCruise->getAll($cond . $orderBy);

    $htmlRows = '';
    if (!empty($lstCruise)) {
        foreach ($lstCruise as $i => $item) {
            $cruise_id = $item['cruise_id'];
            $title = $clsCruise->getTitle($cruise_id);
            $catName = $clsCruise->getCatName($cruise_id);
            $isAdded = $clsCruiseStore->checkExist($cruise_id, $_type);

            $htmlRows .= '<tr id="modal_cruise_row_' . $cruise_id . '">';
            $htmlRows .= '<td class="text-center">' . ($i + 1) . '</td>';
            $htmlRows .= '<td><strong>' . htmlspecialchars($title) . '</strong></td>';
            $htmlRows .= '<td>' . htmlspecialchars($catName) . '</td>';
            $htmlRows .= '<td class="text-center">';
            if ($isAdded) {
                $htmlRows .= '<button type="button" class="btn btn-sm btn-success disabled text-white" style="opacity:1 !important; background-color:#28a745 !important; border-color:#28a745 !important; color:#ffffff !important; font-weight:500; cursor:default;"><i class="fa fa-check"></i> Added</button>';
            } else {
                $htmlRows .= '<button type="button" class="btn btn-sm btn-outline-primary btnClickStoreCruise" data-cruise_id="' . $cruise_id . '" data-_type="' . $_type . '" data-val="1"><i class="fa fa-plus"></i> ' . $core->get_Lang('Add') . '</button>';
            }
            $htmlRows .= '</td>';
            $htmlRows .= '</tr>';
        }
    } else {
        $htmlRows .= '<tr><td colspan="4" class="text-center text-muted">' . $core->get_Lang('nodata') . '</td></tr>';
    }

    $html = '
    <div class="headPop">
        <a class="closeEv close_pop" href="javascript:void(0);" title="' . $core->get_Lang('close') . '"></a>
        <h3>' . $core->get_Lang('Add Cruise to') . ' ' . htmlspecialchars($storeTitle) . '</h3>
    </div>
    <div class="frmform" style="padding:15px">
        <div class="filter_box mb-3 d-flex gap-2 align-items-center" style="margin-bottom:15px;">
            <input type="text" id="search_cruise_store_keyword" class="form-control" style="max-width:250px; display:inline-block;" placeholder="' . $core->get_Lang('search') . '..." />
            <select id="search_cruise_store_cat_id" class="form-select form-control" style="max-width:200px; display:inline-block;">
                <option value="0">-- ' . $core->get_Lang('Select Category') . ' --</option>
                ' . $catOptions . '
            </select>
            <button type="button" id="btn_search_cruise_store_modal" class="btn btn-primary" data-_type="' . $_type . '">' . $core->get_Lang('Search') . '</button>
        </div>
        <div class="table-responsive" style="max-height:400px; overflow-y:auto;">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width:50px">STT</th>
                        <th>' . $core->get_Lang('nameofcruises') . '</th>
                        <th>' . $core->get_Lang('cruisescategory') . '</th>
                        <th class="text-center" style="width:120px"></th>
                    </tr>
                </thead>
                <tbody id="ListCruiseStoreModal">
                    ' . $htmlRows . '
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer" style="padding:10px 15px; text-align:right; border-top:1px solid #eee;">
        <button type="button" class="btn btn-secondary close_pop">' . $core->get_Lang('Close') . '</button>
    </div>';

    echo json_encode(array('result' => true, 'html' => $html));
    die();
}

function default_ajaxAddMoreCruiseDestination()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCruise = new Cruise();
    $clsCruiseDestination = new CruiseDestination();
    #
    $chauluc_id = intval($_POST['chauluc_id'] ?? 0);
    $country_id = intval($_POST['country_id'] ?? 0);
    $region_id = intval($_POST['region_id'] ?? 0);
    $city_id = intval($_POST['city_id'] ?? 0);
    $cruise_id = intval($_POST['cruise_id'] ?? 0);
    $cruise_itinerary_id = intval($_POST['cruise_itinerary_id'] ?? 0);
    $placetogo_id = intval($_POST['placetogo_id'] ?? 0);
    $area_id = intval($_POST['area_id'] ?? 0);
    #
    if (!empty($clsCruiseDestination->getAll("is_trash=0 and cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and country_id='$country_id' and city_id='$city_id' and chauluc_id='$chauluc_id' and area_id='$area_id' and region_id='$region_id' and placetogo_id='$placetogo_id'"))) {
        echo '_EXIST';
        die();
    } else {
        $max_order = $clsCruiseDestination->getMaxOrderNo();
        $f = $clsCruiseDestination->pkey . ",cruise_id,cruise_itinerary_id,country_id,region_id,city_id,order_no,val,chauluc_id,placetogo_id";
        $v = "'" . $clsCruiseDestination->getMaxId() . "','$cruise_id','$cruise_itinerary_id','$country_id','$region_id','$city_id','$max_order','1','$chauluc_id','$placetogo_id'";
        if ($clsCruiseDestination->insertOne($f, $v)) {
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}

/* ========== QUICK CREATE NEW CRUISE ============ */
function default_ajaxCreateQuickCruise()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO, $package_id;
    #
    $clsCruiseCat = new CruiseCat();
    $clsCruise = new Cruise();
    #
    $cruise_cat_id = isset($_POST['cruise_cat_id']) ? $_POST['cruise_cat_id'] : 0;
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $user_id = $core->_USER['user_id'];
    #
    if ($tp == 'F') {
        $html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . $core->get_Lang('addcruises') . '</h3>
		</div>
		<form method="post" action="" id="frmCrxCruise">
			<div class="wrap">
				<div class="span100">
					<div class="row-span">
						<strong>' . $core->get_Lang('step') . ' 1: ' . $core->get_Lang('enternamecruises') . '</strong><br><br>
						<em style="color:#999;">' . $core->get_Lang('stepnamecruises') . '</em> <br /><br />';
        if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'cat', 'default')) {
            /*            $html .= '
						<div class="row-span">
							<div class="fieldlabel">' . $core->get_Lang('categories') . '</div>
							<div class="fieldarea">
								<select id="slb_CategoryID" name="cruise_cat_id" class="slbHighlight" style="width:160px;">
									' . $clsCruiseCat->makeSelectboxOption(0, $cruise_cat_id) . '
								</select>
							</div>
						</div>';*/
        }
        $html .= '
						<div class="row-span">
							<div class="fieldlabel">' . $core->get_Lang('Cruise Type') . '</div>
							<div class="fieldarea">
								<select id="cruise_type" name="cruise_type" class="slbHighlight" style="width:160px;">
									<option value="1">' . $core->get_Lang("Join-in Cruise") . '</option>
									<option value="2">' . $core->get_Lang("Private Cruise") . '</option>
								</select>
							</div>
						</div>';
        $html .= '<div class="clearfix" style="margin-bottom:10px"></div>
						<input type="text" autocomplete="off" name="title" class="text full fontLarge required title_capitalize" id="NewCruiseTitle" placeholder="' . $core->get_Lang('ex') . ': ' . $clsISO->getExName('Cruise') . '" />
						<br><br>
					</div>';
        $html .= '
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary clickToSubmitNewCruise">
					<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('nextstep') . '</span>
				</button>
				<input type="hidden" name="tp" value="S" />
			</div>
		</form>';
        echo ($html);
        die();
    } elseif ($tp == 'S') {
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $titlePost = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
        $slugPost = $clsISO->replaceSpace2($titlePost);
        $cruise_type = isset($_POST['cruise_type']) ? $_POST['cruise_type'] : 0;
        #
        if ($clsCruise->getAll("slug='$slugPost'") != '' && count($clsCruise->getAll("slug='$slugPost'")) > 0) {
            echo '_EXIST';
            die();
        } else {
            $listTable = $clsCruise->getAll("1=1", $clsCruise->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsCruise->updateOne($listTable[$i][$clsCruise->pkey], "order_no='" . $order_no . "'");
            }
            $max_id = $clsCruise->getMaxID();
            $fx = "$clsCruise->pkey,title,slug,user_id,user_id_update,reg_date,upd_date,order_no,cruise_type";
            $vx = "'$max_id','" . addslashes($titlePost) . "','" . $slugPost . "','$user_id','$user_id','" . time() . "','" . time() . "','1','$cruise_type'";
            if (isset($cruise_cat_id) && intval($cruise_cat_id) > 0) {
                $list_cat_id = $clsCruiseCat->getListParent($cruise_cat_id);
                $fx .= ",cruise_cat_id,list_cat_id";
                $vx .= ",'$cruise_cat_id','" . $list_cat_id . "'";
            }
            if ($clsCruise->insertOne($fx, $vx)) {
                //				echo(PCMS_URL.'/index.php?mod='.$mod.'&act=edit&'.$clsCruise->pkey.'='.$core->encryptID($max_id));die();
                echo PCMS_URL . '/cruise/insert/' . $max_id . '/overview/basic';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        }
    }
}

/*============== LOAD CRUISE SERVICES ============*/
function default_service()
{
    global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, 'cruise', 'service', 'default')) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    $classTable = "CruiseService";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=service';
        if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }

    $cond = "1=1";
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and (title like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;

    $orderBy = " order_no desc";
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    } elseif ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no asc";

    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
    $assign_list["allItem"] = $allItem;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['cruise_service_id']) ? ($_GET['cruise_service_id']) : '';
        $cruise_service_id = intval($core->decryptID($string));
        if ($string == '' && $cruise_service_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($cruise_service_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['cruise_service_id']) ? ($_GET['cruise_service_id']) : '';
        $cruise_service_id = intval($core->decryptID($string));
        if ($string == '' && $cruise_service_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($cruise_service_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['cruise_service_id']) ? ($_GET['cruise_service_id']) : '';
        $cruise_service_id = intval($core->decryptID($string));
        if ($string == '' && $cruise_service_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($cruise_service_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $string = isset($_GET['cruise_service_id']) ? ($_GET['cruise_service_id']) : '';
        $pvalTable = intval($core->decryptID($string));
        if ($string == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        #
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        $where = "is_trash=0";
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no ASC limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no DESC limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no desc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no asc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=PositionSuccess');
    }
}

function default_ajUpdPosSortListCruiseService()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $classTable = "CruiseService";
    $clsClassTable = new $classTable;
    $order = $_POST['order'];
    $type = $_POST['type'];
    $currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;
    $recordPerPage = isset($_POST['recordPerPage']) ? $_POST['recordPerPage'] : 1;
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        /*$key = $key + 1;*/
        $clsClassTable->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_ajSiteCruiseService()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    if ($clsConfiguration->getValue('SiteHasCruisesService') == 0) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    $clsClassTable = new CruiseService;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $cruise_service_id = isset($_POST['cruise_service_id']) ? intval($_POST['cruise_service_id']) : 0;
    #
    if ($tp == 'L') {
        $lstItem = $clsClassTable->getAll("is_trash=0 and is_online=1 order by order_no desc");
        $html = "";
        if (is_array($lstItem) && count($lstItem)) {
            $i = 0;
            foreach ($lstItem as $item) {
                $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="' . $item[$clsClassTable->pkey] . '" /></td>';
                $html .= '<td class="index">' . ($i + 1) . '</td>';
                $html .= '<td><strong style="font-size:15px;">' . $clsClassTable->getTitle($item[$clsClassTable->pkey]) . '</strong></td>';
                $html .= '<td style="text-align:right;"><strong class="format_price" style="font-size:15px">' . $clsClassTable->getPrice($item[$clsClassTable->pkey]) . ' ' . $clsISO->getRate() . '</strong></td>';
                $html .= '<td style="vertical-align: middle;text-align:center">
						' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('movetop') . '"  direct="movetop" class="moveCruiseService" data="' . $item[$clsClassTable->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">
						' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="moveCruiseService" direct="movebottom" data="' . $item[$clsClassTable->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">
						' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('moveup') . '" class="moveCruiseService" direct="moveup" data="' . $item[$clsClassTable->pkey] . '" href="javascript:void();"><i class="icon-arrow-up"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">
						' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="moveCruiseService" direct="movedown" data="' . $item[$clsClassTable->pkey] . '" href="javascript:void();"><i class="icon-arrow-down"></i></a>') . '
					</td>';
                $html .= '<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
								<ul class="dropdown-menu" style="right:0px !important">
									<li><a class="clickEditCruiseService" title="' . $core->get_Lang('edit') . '" href="javascript:void();" data="' . $item[$clsClassTable->pkey] . '"><i class="icon-edit"></i> <span>' . $core->get_Lang('edit') . '</span></a></li>
									<li><a class="clickDeleteCruiseService" title="' . $core->get_Lang('delete') . '" href="javascript:void();" data="' . $item[$clsClassTable->pkey] . '"><i class="icon-remove"></i> <span>' . $core->get_Lang('delete') . '</span></a></li>
								</ul>
							</div>
						</td>';
                $html .= '</tr>';
                ++$i;
            }
        } else {
            $html .= '<tr><td colspan="7"><div class="message">' . $core->get_Lang('nodata') . '</div></td></tr>';
        }
        echo $html;
        die();
    } elseif ($tp == 'F') {
        #
        $html = '';
        $html .= '<div class="headPop"> 
					<a class="closeEv close_pop" data-dismiss="modal" aria-hidden="true">&nbsp;</a> 
					<h3>' . ($cruise_service_id > 0 ? $core->get_Lang('edit') : $core->get_Lang('add')) . ' ' . $core->get_Lang('servicecruises') . '</h3> 
				</div>';
        $html .= '
		<form method="post" action="" id="form-post" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Title') . '</strong> <span class="color_r">*</span></div>
						<div class="fieldarea"><input type="text" name="title" class="text_32 full-width border_aaa bold" value="' . $clsClassTable->getTitle($cruise_service_id) . '" style=" width:95%"/></div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right">
							<strong>' . $core->get_Lang('Extra') . '</strong>
						</div>
						<div class="fieldarea">
							<select class="glSlBox" id="extra" name="extra" style="width:200px">
								<option ' . ($clsClassTable->getOneField('extra', $cruise_service_id) == 0 ? 'selected=selected' : '') . ' value="0">Included</option>
								<option ' . ($clsClassTable->getOneField('extra', $cruise_service_id) == 2 ? 'selected=selected' : '') . ' value="2">Factor Number Guest</option>
							</select>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('price') . '</strong></div>
						<div class="fieldarea">
							<input type="text" class="text_32 border_aaa bold required formatprice" style=" width:200px" value="' . $clsClassTable->getPrice($cruise_service_id) . '" name="price" />
							' . $clsISO->getRate() . '
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Short text') . '</strong></div>
						<div class="fieldarea">
							<textarea id="textarea_intro_editor' . time() . '" class="textarea_intro_editor" name="intro" style="width:100%">' . $clsClassTable->getIntro($cruise_service_id) . '</textarea>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer"> 
			<button class="btn btn-primary submitCruiseService" cruise_service_id="' . $cruise_service_id . '">
				<i class="icon-ok icon-white"></i> ' . $core->get_Lang('save') . '
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
			</button>
		</div>';
        echo $html;
        die();
    } elseif ($tp == 'S') {
        $titlePost = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
        $slugPost = $core->replaceSpace($titlePost);
        $introPost = addslashes($_POST['intro']);
        $price = isset($_POST['price']) ? $clsISO->processSmartNumber(str_replace('.', '', $_POST['price'])) : 0;
        $imagePost = isset($_POST['image']) ? addslashes($_POST['image']) : '';
        $extra = isset($_POST['extra']) ? intval($_POST['extra']) : 0;
        #
        if (intval($cruise_service_id) == '0') {
            if (!empty($clsClassTable->getAll("slug='$slugPost'"))) {
                echo '_EXIST';
                die();
            } else {
                $listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
                for ($i = 0; $i <= count($listTable); $i++) {
                    $order_no = $listTable[$i]['order_no'] + 1;
                    $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
                }
                $max_id = $clsClassTable->getMaxID();
                $max_order = $clsClassTable->getMaxOrderNo();
                $f = "user_id,user_id_update,title,slug,intro,price,order_no,cruise_service_id,reg_date,upd_date,image,extra";
                $v = "'$user_id','$user_id','" . addslashes($titlePost) . "','" . addslashes($slugPost) . "','" . addslashes($introPost) . "','" . $price . "'";
                $v .= ",'1','$max_id','" . time() . "','" . time() . "','$imagePost','" . $extra . "'";
                if ($clsClassTable->insertOne($f, $v)) {
                    echo '_INSERT_SUCCESS';
                    die();
                } else {
                    echo '_ERROR';
                    die();
                }
            }
        } else {
            if (!empty($clsClassTable->getAll("slug='$slugPost' and cruise_service_id <> '$cruise_service_id'"))) {
                echo '_EXIST';
                die();
            } else {
                $v = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',intro='$introPost',price='$price'";
                $v .= ",image='" . addslashes($imagePost) . "',upd_date='" . time() . "',user_id_update='$user_id',extra='" . $extra . "'";
                if ($clsClassTable->updateOne($cruise_service_id, $v)) {
                    echo '_UPDATE_SUCCESS';
                    die();
                } else {
                    echo '_ERROR';
                    die();
                }
            }
        }
    }
}

/*============ LOAD CRUISE CATEGORY =========*/
function default_cat()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration, $clsISO, $package_id;
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    #- End Check
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #
    $classTable = "CruiseCat";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    $assign_list["clsCruise"] = new Cruise();
    #
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #

    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=cat';
        if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
        exit();
    }

    $cond = "1=1";
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and (title like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    } else {
        $cond .= " and parent_id=0";
    }
    $cond2 = $cond;
    $orderBy = " order_no desc";
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    } elseif ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no asc";


    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------


    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
    $assign_list["allItem"] = $allItem;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['cruise_cat_id']) ? ($_GET['cruise_cat_id']) : '';
        $cruise_cat_id = intval($core->decryptID($string));
        if ($string == '' && $cruise_cat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        $listChild = $clsClassTable->getChild($cruise_cat_id, 0, false);
        if (!empty($listChild)) {
            header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=DeleteFailedHasChild');
            exit();
        }
        if ($clsClassTable->updateOne($cruise_cat_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['cruise_cat_id']) ? ($_GET['cruise_cat_id']) : '';
        $cruise_cat_id = intval($core->decryptID($string));
        if ($string == '' && $cruise_cat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($cruise_cat_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['cruise_cat_id']) ? ($_GET['cruise_cat_id']) : '';
        $cruise_cat_id = intval($core->decryptID($string));
        if ($string == '' && $cruise_cat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        $listChild = $clsClassTable->getChild($cruise_cat_id, 0, false);
        if (!empty($listChild)) {
            header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=DeleteFailedHasChild');
            exit();
        }
        if ($clsClassTable->deleteOne($cruise_cat_id)) {
            header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=DeleteSuccess');
        }
    }
    #

}

function default_ajSysCruiseCategory()
{
    global $dbconn, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $core, $clsModule;
    global $clsISO, $clsConfiguration, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, 'cat', 'default')) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    $clsCruiseCat = new CruiseCat();
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $cruise_cat_id = isset($_POST['cruise_cat_id']) ? intval($_POST['cruise_cat_id']) : 0;
    $parent_id = (isset($_POST['parent_id']) && $_POST['parent_id'] > 0) ? $_POST['parent_id'] : 0;
    #
    if ($tp == 'L') {
        $lstItem = array();
        $clsCruiseCat->makeList(0, 0, $lstItem);
        $html = "";
        if (!empty($lstItem)) {
            $i = 0;
            foreach ($lstItem as $key => $val) {
                $html .= '<tr data="' . $key . '" style="cursor:move" id="order_' . $key . '" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index">' . ($i + 1) . '</td>';
                $html .= '<td>
							<strong class="mr10">' . $val['level'] . '&nbsp;' . $clsCruiseCat->getTitle($key) . '</strong>
							' . ($clsConfiguration->getValue('SiteHasChild_slide') == 1 ? '<a href="' . PCMS_URL . '/index.php?mod=slide&mod_page=cruise&act_page=cat&target_id=' . $key . '&clsTable=CruiseCat" title="' . $core->get_Lang('listslide') . '"><i class="fa fa-folder-open"></i>  ' . $core->get_Lang('listslide') . ' <strong style="color:#c00000;">(' . $clsISO->countTotalSlide('cruise', 'cat', $key) . ')</strong></a>' : '') . '
						</td>';
                if (1 == 2) {
                    $html .= '<td style="vertical-align: middle;text-align:center">
							' . ($clsCruiseCat->checkMove($key, '_DOWN') ? '<a title="' . $core->get_Lang('movetop') . '"  direct="movetop" class="moveCruiseCategory" data="' . $key . '" parent_id="' . $clsCruiseCat->getOneField('parent_id', $key) . '" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>' : '') . '
						</td>
						<td style="vertical-align: middle;text-align:center">
							' . ($clsCruiseCat->checkMove($key, '_UP') ? '<a title="' . $core->get_Lang('movebottom') . '" class="moveCruiseCategory" direct="movebottom" data="' . $key . '" parent_id="' . $clsCruiseCat->getOneField('parent_id', $key) . '" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>' : '') . '
						</td>
						<td style="vertical-align: middle;text-align:center">
							' . ($clsCruiseCat->checkMove($key, '_DOWN') ? '<a title="' . $core->get_Lang('moveup') . '" class="moveCruiseCategory" direct="moveup" data="' . $key . '" parent_id="' . $clsCruiseCat->getOneField('parent_id', $key) . '" href="javascript:void();"><i class="icon-arrow-up"></i></a>' : '') . '
						</td>
						<td style="vertical-align: middle;text-align:center">
							' . ($clsCruiseCat->checkMove($key, '_UP') ? '<a title="' . $core->get_Lang('movebottom') . '" class="moveCruiseCategory" direct="movedown" data="' . $key . '" parent_id="' . $clsCruiseCat->getOneField('parent_id', $key) . '" href="javascript:void();"><i class="icon-arrow-down"></i></a>' : '') . '
						</td>';
                }
                $html .= '<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
								<ul class="dropdown-menu" style="right:0px !important">
									<li><a class="btnEditCruiseCategory" title="' . $core->get_Lang('edit') . '" href="javascript:void();" data="' . $key . '"><i class="icon-edit"></i> <span>' . $core->get_Lang('edit') . '</span></a></li>
									<li><a class="btnDeleteCruiseCategory" title="' . $core->get_Lang('delete') . '" href="javascript:void();" data="' . $key . '"><i class="icon-remove"></i> <span>' . $core->get_Lang('delete') . '</span></a></li>
								</ul>
							</div>
						</td>';
                $html .= '</tr>';
                ++$i;
            }
            $html .= '
			<script type="text/javascript">
				$("#tblHolderCruiseCategory").sortable({
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
						$.post(path_ajax_script+"/index.php?mod=cruise&act=ajUpdPosCruiseCat", order, function(html){
							loadListSysCategory(\'\',\'\');
							vietiso_loading(0);
						});
					}
				});
			</script>';
        } else {
            $html .= '<tr><td style="text-align:center" colspan="10">' . $core->get_Lang('nodata') . '</td></tr>';
        }
        echo $html;
        die();
    } elseif ($tp == 'F') {
        $parent_id = $clsCruiseCat->getOneField('parent_id', $cruise_cat_id);
        $html = '';
        $html .= '<div class="headPop"> 
					<a class="closeEv close_pop" data-dismiss="modal" aria-hidden="true">&nbsp;</a> 
					<h3>' . $core->get_Lang('updatecruisecategory') . ' - ' . $clsCruiseCat->getTitle($cruise_cat_id) . '</h3> 
				</div>';
        $html .= '
			<form method="post" action="" id="form-post" class="frmform formborder" enctype="multipart/form-data">
				<div class="wrap">
					<div>
						<div class="row-span">
							<div class="fieldlabel" style="text-align:right"><strong >' . $core->get_Lang('title') . '</strong> <span class="color_r">*</span></div>
							<div class="fieldarea"><input type="text" name="title" class="text_32 border_aaa full-width fontLarge" value="' . $clsCruiseCat->getTitle($cruise_cat_id) . '" style=" width:95%"/></div>
						</div>';
        if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'cruise_sub_category', 'customize')) {
            $html .= '<div class="row-span">
							<div class="fieldlabel" style="text-align:right"><strong> ' . $core->get_Lang('selectcategory') . '</strong><span class="color_r">*</span></div>
							<div class="fieldarea">
								<select class="slb" name="parent_id" id="slb_TourCategory">  
									' . ($cruise_cat_id > 0 ? $clsCruiseCat->makeSelectboxOption($parent_id, $cruise_cat_id, 0, '--', 1, 0) : $clsCruiseCat->makeSelectboxOption($parent_id, $cruise_cat_id, 0, '--', 0, 0)) . '  
								</select>
							</div>
						</div>';
        }
        //echo $cruise_cat_id;die('xxx');
        $html .= '
						<div class="row-span">
							<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Short text') . '</strong> <span class="color_r">*</span></div>
							<div class="fieldarea">
								<textarea id="textarea_intro_editor' . time() . '" class="textarea_intro_editor" name="intro" style="width:100%">' . $clsCruiseCat->getIntro($cruise_cat_id) . '</textarea>
							</div>
						</div>
						<div class="row-span">
							<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Image') . '</strong> <span class="color_r">*</span></div>
							<div class="fieldarea">
								<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsCruiseCat->getOneField('image', $cruise_cat_id) . '" />
								<input type="hidden" id="isoman_hidden_image" value="' . $clsCruiseCat->getOneField('image', $cruise_cat_id) . '">
								<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsCruiseCat->getOneField('image', $cruise_cat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsCruiseCat->getOneField('image', $cruise_cat_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open" /></a>
							</div>
						</div>
						<div class="row-span">
							<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Banner') . ' (WxH:1920x400)</strong> <span class="color_r">*</span></div>
							<div class="fieldarea">
								<img class="isoman_img_pop" id="isoman_show_image_banner" src="' . $clsCruiseCat->getOneField('image_banner', $cruise_cat_id) . '" />
								<input type="hidden" id="isoman_hidden_image_banner" value="' . $clsCruiseCat->getOneField('image_banner', $cruise_cat_id) . '">
								<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image_banner" name="image_banner" value="' . $clsCruiseCat->getOneField('image_banner', $cruise_cat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_banner" isoman_val="' . $clsCruiseCat->getOneField('image_banner', $cruise_cat_id) . '" isoman_name="image_banner"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open" /></a>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="modal-footer"> 
				<button class="btn btn-primary submitCruiseCategory" cruise_cat_id="' . $cruise_cat_id . '">
					<i class="icon-ok icon-white"></i> ' . $core->get_Lang('save') . '
				</button>
				<button type="reset" class="btn btn-warning close_pop">
					<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
				</button>
			</div>';
        echo $html;
        die();
    } elseif ($tp == 'S') {
        $titlePost = trim(strip_tags($_POST['title']));
        $slugPost = $core->replaceSpace($titlePost);
        $introPost = addslashes($_POST['intro']);
        $imagePost = isset($_POST['image']) ? addslashes($_POST['image']) : '';
        $image_bannerPost = isset($_POST['image_banner']) ? addslashes($_POST['image_banner']) : '';
        #
        if ($cruise_cat_id == '0') {
            if (!empty($clsCruiseCat->getAll("parent_id='$parent_id' and slug='$slugPost'"))) {
                echo '_EXIST';
                die();
            } else {
                $listTable = $clsCruiseCat->getAll("1=1 and parent_id='$parent_id'", $clsCruiseCat->pkey . ",order_no");
                for ($i = 0; $i <= count($listTable); $i++) {
                    $order_no = $listTable[$i]['order_no'] + 1;
                    $clsCruiseCat->updateOne($listTable[$i][$clsCruiseCat->pkey], "order_no='" . $order_no . "'");
                }
                $max_id = $clsCruiseCat->getMaxID();
                $max_order = $clsCruiseCat->getMaxOrderNo();
                $f = "user_id,user_id_update,parent_id,title,slug,intro,order_no,cruise_cat_id,reg_date,upd_date,image,image_banner";
                $v = "'$user_id','$user_id','$parent_id','" . addslashes($titlePost) . "','" . addslashes($slugPost) . "','" . addslashes($introPost) . "'";
                $v .= ",'1','$max_id','" . time() . "','" . time() . "','$imagePost','$image_bannerPost'";
                if ($clsCruiseCat->insertOne($f, $v)) {
                    echo '_SUCCESS';
                    die();
                } else {
                    echo '_ERROR';
                    die();
                }
            }
        } else {
            if (!empty($clsCruiseCat->getAll("parent_id='$parent_id' and cruise_cat_id <> '$cruise_cat_id' and slug='$slugPost'"))) {
                echo '_EXIST';
                die();
            } else {
                $v = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',intro='$introPost'";
                $v .= ",parent_id='$parent_id',image='" . addslashes($imagePost) . "',image_banner='" . addslashes($image_bannerPost) . "',upd_date='" . time() . "',user_id_update='$user_id'";
                if ($clsCruiseCat->updateOne($cruise_cat_id, $v)) {
                    echo '_UPDATESUCCESS';
                    die();
                } else {
                    echo '_ERROR';
                    die();
                }
            }
        }
    } elseif ($tp == 'M') {
        #
        $one = $clsCruiseCat->getOne($cruise_cat_id);
        $order_no = $one['order_no'];
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
        #
        $cond = 'is_trash=0 and parent_id=' . $parent_id;
        #
        if ($direct == 'moveup') {
            $lst = $clsCruiseCat->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsCruiseCat->updateOne($cruise_cat_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruiseCat->updateOne($lst[0][$clsCruiseCat->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsCruiseCat->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsCruiseCat->updateOne($cruise_cat_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruiseCat->updateOne($lst[0][$clsCruiseCat->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsCruiseCat->getAll($cond . " and order_no > $order_no order by order_no asc");
            $clsCruiseCat->updateOne($cruise_cat_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsCruiseCat->getAll($cond . " and cruise_cat_id <> '$cruise_cat_id' and order_no > $order_no order by order_no asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsCruiseCat->updateOne($lstItem[$i][$clsCruiseCat->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsCruiseCat->getAll($cond . " and order_no < $order_no order by order_no desc");
            $clsCruiseCat->updateOne($cruise_cat_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsCruiseCat->getAll($cond . " and cruise_cat_id <> '$cruise_cat_id' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsCruiseCat->updateOne($lstItem[$i][$clsCruiseCat->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
            }
        }
        echo (1);
        die();
    } elseif ($tp == 'D') {
        $clsCruiseCat->doDelete($cruise_cat_id);
        echo (1);
        die();
    }
}

function default_ajUpdPosCruiseCat()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCruiseCat = new CruiseCat();
    $order = $_POST['order'];
    foreach ($order as $key => $val) {
        $key = $key + 1;
        $clsCruiseCat->updateOne($val, "order_no='" . $key . "'");
    }
    //var_dump($order);die;
}

/*------ Cruise Itinerary -------*/
function default_itinerary()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $pUrl = '';
    #
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;

    /*Get type of list news*/
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    $cruise_id = isset($_GET['cruise_id']) ? intval($_GET['cruise_id']) : 0;
    $assign_list["cruise_id"] = $cruise_id;
    if (intval($cruise_id) == 0) {
        header('location:' . PCMS_URL . '/index.php?mod=cruise&message=NotPermission');
        exit();
    }
    /**/
    $classTable = "CruiseItinerary";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = "&act=" . $act . "&cruise_id=" . $cruise_id;
        if (isset($_POST['keyword']) && $_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    /*List all item*/
    $cond = "1='1'";
    $cond .= " and cruise_id='$cruise_id'";
    $pUrl .= '&cruise_id=' . $cruise_id;
    #Filter By Keyword
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $cond .= " and (title like '%" . $_GET['keyword'] . "%' or content like '%" . $_GET['keyword'] . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no desc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = 20;
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    $assign_list['pUrl'] = $pUrl;
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit); //print_r($cond." order by ".$orderBy.$limit);die();
    $assign_list["allItem"] = $allItem;
    #
    $allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2);
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allAll = $clsClassTable->getAll($cond2);
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=TrashSuccess');
        }
    }
    if ($action == 'Delete') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->doDelete($pvalTable)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if ($action == 'Move') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        #
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no desc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no asc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=PositionSuccess');
    }
}

function default_ajUpdPosSortItineraryCruise()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCruiseItinerary = new CruiseItinerary();
    $order = $_POST['order'];
    /*$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];*/
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        /*		$key = (($currentPage-1)*$recordPerPage + $key + 1);*/
        $key = $key + 1;
        $clsCruiseItinerary->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_edit_itinerary()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO, $package_id;
    $clsContinent = new Continent();
    $assign_list["clsContinent"] = $clsContinent;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $check_in = date('m/d/Y', strtotime("+ 1 days"));
    $assign_list['check_in'] = $check_in;
    $check_in_math = strtotime($check_in);
    $assign_list['check_in_math'] = $check_in_math;

    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $Current_Now = time();
    $lstMonth = array();
    for ($i = 1; $i <= 12; $i++) {
        $lstMonth[] = ($i < 10) ? '0' . $i : $i;
    }
    $assign_list["lstMonth"] = $lstMonth;
    #
    $clsCruiseService = new CruiseService();
    $assign_list["clsCruiseService"] = $clsCruiseService;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $lstService = $clsCruiseService->getAll("is_trash=0 and is_online=1 order by order_no desc");
    $assign_list["lstService"] = $lstService;
    unset($lstService);
    #
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCruiseItineraryDay = new CruiseItineraryDay();
    $assign_list["clsCruiseItineraryDay"] = $clsCruiseItineraryDay;
    $cruise_id = isset($_GET['cruise_id']) ? intval($_GET['cruise_id']) : 0;
    $assign_list["cruise_id"] = $cruise_id;
    $return = isset($_GET['return']) ? $_GET['return'] : '';

    if ($cruise_id == 0) {
        header('location: ' . PCMS_URL);
        exit();
    }
    $pUrl = '';
    $pUrl .= '&cruise_id=' . $cruise_id;
    #
    $classTable = "CruiseItinerary";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    if ($string != '' && $pvalTable == 0) {
        header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
    }
    $assign_list['pvalTable'] = $pvalTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;
    #

    $listCabin = $clsCruiseCabin->getAll("is_trash=0 and is_online=1 and cruise_id='$cruise_id' order by order_no asc");
    $assign_list['listCabin'] = $listCabin;
    unset($listCabin);


    $lstItinerary = $clsClassTable->getAll("cruise_id='$cruise_id'");
    $assign_list["lstItinerary"] = $lstItinerary;
    unset($lstItinerary);
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $cruise_itinerary_id = $_POST['cruise_itinerary_id'];
        if (intval($cruise_itinerary_id) > 0) {
            header('Location:/admin/?mod=' . $mod . '&act=' . $act . '&cruise_itinerary_id=' . $core->encryptID($cruise_itinerary_id) . $pUrl);
            exit();
        } else {
            header('Location:/admin/?mod=' . $mod . '&act=' . $act . $pUrl);
            exit();
        }
    }
    #
    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;

    $clsForm->addInputTextArea("full", 'what_include', "", 'what_include', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'highlight', "", 'highlight', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'cancellation', "", 'cancellation', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'price_note', "", 'price_note', 255, 25, 5, 1, "style='width:100%'");
    #
    #- Init Price
    /*if(intval($pvalTable) > 0){
		$clsClassTable->initCruiseTable($pvalTable);
	}*/
    #- End Init Price
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
            #
            $trip_price = $_POST['trip_price'] ? $clsISO->processSmartNumber($_POST['trip_price']) : 0;
            $is_show_price = $_POST['is_show_price'] ? $_POST['is_show_price'] : 0;

            $set .= ",slug='" . $core->replaceSpace($_POST['iso-title']) . "'";
            $set .= ",slug_search='" . $core->replaceSpace($_POST['iso-title_search']) . "'";
            $set .= ",trip_price='" . $trip_price . "'";
            $set .= ",user_id_update='$user_id',upd_date='" . time() . "'";
            $set .= ",is_show_price='" . $is_show_price . "'";
            $set .= ",high_season_month='" . $clsISO->makeSlashListFromArray($_POST['season_month']) . "'";
            $set .= ",listService='" . $clsISO->makeSlashListFromArray($_POST['listService']) . "'";

            $number_day = (int)Input::post('iso-number_day', 0);
            #--Special Field: image
            $image = '';
            if (_isoman_use && $image == '') {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
            } else {
                $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            }
            if ($image != '' && $image != '0') {
                $set .= ",image='" . addslashes($image) . "'";
            }
            //print_r($pvalTable.'xxxxx'.$set); die();

            if ($clsClassTable->updateOne($pvalTable, $set)) {
                #update cruise itinerary day
                $count_intinerary_day = $clsCruiseItineraryDay->getAll("is_trash=0 and cruise_itinerary_id='$pvalTable'", "count(" . $clsCruiseItineraryDay->pkey . ") as count");
                $numberItinerary = $count_intinerary_day[0]['count'];
                $numberLoop = ($number_day > $numberItinerary) ? ($number_day - $numberItinerary) : 0;
                for ($i = $numberItinerary; $i <= $number_day; $i++) {
                    $titlePost = "Edit Day " . ($i + 1);
                    $slugPost = $core->replaceSpace($titlePost);
                    $dayPost = $i + 1;
                    $user_id = $core->_USER['user_id'];
                    $f = "user_id,user_id_update,title,slug,day,cruise_itinerary_id,content,reg_date,upd_date,order_no,cruise_itinerary_day_id,transport_id,transport,image,is_show_image";
                    $v = "'$user_id','$user_id','$titlePost','$slugPost','$dayPost','$pvalTable','','" . time() . "','" . time() . "','" . $clsCruiseItineraryDay->getMaxOrderNo() . "','" . $clsCruiseItineraryDay->getMaxID() . "','0','','','0'";
                    $clsCruiseItineraryDay->insertOne($f, $v);
                }
                $clsCruiseItineraryDay->deleteByCond(" cruise_itinerary_id='$pvalTable' and day > $number_day");

                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_itinerary&cruise_itinerary_id=' . $core->encryptID($pvalTable) . $pUrl . '&message=updateSuccess');
                } else {
                    header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=updateSuccess");
                }
            } else {
                header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=updateFailed");
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
            $max_ID = $clsClassTable->getMaxID();
            $trip_price = $_POST['trip_price'] ? $clsISO->processSmartNumber($_POST['trip_price']) : 0;
            $is_show_price = $_POST['is_show_price'] ? $_POST['is_show_price'] : 0;
            $field .= ",slug,user_id,user_id_update,reg_date,upd_date,cruise_id,$clsClassTable->pkey,order_no";
            $value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "','$user_id','$user_id','" . time() . "','" . time() . "','$cruise_id','$max_ID','1'";
            $field .= ",trip_price,is_show_price,high_season_month";
            $value .= ",'" . $trip_price . "','" . $is_show_price . "','" . $clsISO->makeSlashListFromArray($_POST['season_month']) . "'";

            #--Special Field: image
            $image = '';
            if (_isoman_use && $image == '') {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
            } else {
                $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            }
            if ($image != '' && $image != '0') {
                $field .= ",image";
                $value .= ",'" . addslashes($image) . "'";
            }

            $listTable = $clsClassTable->getAll("1=1 and cruise_id='$cruise_id'", $clsClassTable->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
            }
            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_itinerary&cruise_itinerary_id=' . $core->encryptID($max_ID) . '&cruise_id=' . $cruise_id . '&message=InsertSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&cruise_id=' . $core->encryptID($cruise_id) . '&message=insertSuccess#isotab2');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&cruise_id=' . $core->encryptID($cruise_id) . 'message=insertFailed#isotab2');
            }
        }
    }
}

function default_edit_cabin()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO;


    $classTable = "CruiseCabin";
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

    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;

    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;

    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;

    #- Custom Field
    $clsCruiseCustomField = new CruiseCustomField();
    $assign_list["clsCruiseCustomField"] = $clsCruiseCustomField;
    $listCustomField = $clsCruiseCustomField->getAll("cruise_id='$pvalTable' and fieldtype='CUSTOM' order by order_no ASC");
    $assign_list["listCustomField"] = $listCustomField;

    $lstGroupSize = $clsCruiseProperty->getAll("is_trash=0 and type = 'GroupSize' order by number_adult ASC", $clsCruiseProperty->pkey);
    $assign_list["lstGroupSize"] = $lstGroupSize;

    $listCabinFacilities = $clsCruiseProperty->getAll("is_trash=0 and type='CabinFacilities' order by order_no ASC", $clsCruiseProperty->pkey);
    $assign_list["listCabinFacilities"] = $listCabinFacilities;


    $cruise_id = isset($_GET['cruise_id']) ? ($_GET['cruise_id']) : '';
    $assign_list["cruise_id"] = $cruise_id;

    #
    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;

    $clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'easy_cancel', "", 'easy_cancel', 255, 25, 5, 1, "style='width:100%'");
    #
    #- Init Price
    /*if(intval($pvalTable) > 0){
		$clsClassTable->initCruiseTable($pvalTable);
	}*/
    #- End Init Price
    #=========================================#
    if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
        if ($pvalTable > 0) {
            $value = "";
            $firstAdd = 0;
            foreach ($_POST as $key => $val) {
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


            $value .= ",slug='" . $core->replaceSpace($_POST["iso-title"]) . "'";
            $value .= ",upd_date='" . time() . "',user_id_update='" . addslashes($core->_SESS->user_id) . "'";

            #--Special Field: image
            if (_isoman_use) {
                $value .= ",image='" . addslashes($_POST['isoman_url_image']) . "'";
            } else {
                $image = $_POST['image'];
                if ($image != '' && $image != '0') {
                    $value .= ",image='" . addslashes($image) . "'";
                }
            }
            $value .= ",list_cabin_facilities='" . $clsISO->makeSlashListFromArray($_POST['listCabinFacilities']) . "'";
            $value .= ",list_group_size='" . $clsISO->makeSlashListFromArray($_POST['listGroupSize']) . "'";

            $pUrl = '';
            if (isset($cruise_id) && intval($cruise_id) != 0) {
                $pUrl .= "&cruise_id=" . $cruise_id;
            }

            $lastAdultSize = end($_POST['listGroupSize']);
            $max_adult = $clsCruiseProperty->getOneField('number_adult', $lastAdultSize) ? $clsCruiseProperty->getOneField('number_adult', $lastAdultSize) : 0;
            $value .= ",max_adult='" . $max_adult . "'";

            if ($clsClassTable->updateOne($pvalTable, $value)) {
                if ($_POST['button'] == '_EDIT') {

                    $listGroupSize = implode(',', $_POST['listGroupSize']);
                    $clsCruiseSeasonPrice = new CruiseSeasonPrice();
                    $clsCruiseSeasonPrice->deleteByCond(" cruise_id='" . $cruise_id . "' AND cruise_cabin_id = '" . $pvalTable . "' and group_size_id NOT IN (" . $listGroupSize . ")");
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_cabin&cruise_cabin_id=' . $core->encryptID($pvalTable) . $pUrl . '&message=updateSuccess');
                } else {
                    header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/cabin/cabin&message=UpdateSuccess");
                }
            } else {
                header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/cabin/cabin&message=UpdateFailed");
            }
        } else {
            $pUrl = '';
            if (isset($cruise_id) && intval($cruise_id) != 0) {
                $pUrl .= "&cruise_id=" . $cruise_id;
            }
            $listTable = $clsClassTable->getAll("1=1 and cruise_id='$cruise_id'", $clsClassTable->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
            }
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
            $field .= ",user_id,user_id_update,reg_date,upd_date,slug,cruise_cabin_id,order_no,cruise_id";
            $value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
            $value .= ",'" . str_replace('$', '', $core->replaceSpace($_POST['title'])) . "','" . $max_id . "','1','$cruise_id'";

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = $_POST['isoman_url_image'];
            }
            if ($image != '' && $image != '0') {
                $field .= ',image';
                $value .= ",'" . addslashes($image) . "'";
            }
            $field .= ',list_cabin_facilities,list_group_size';
            $value .= ",'" . $clsISO->makeSlashListFromArray($_POST['listCabinFacilities']) . "','" . $clsISO->makeSlashListFromArray($_POST['listGroupSize']) . "'";

            $lastAdultSize = end($_POST['listGroupSize']);
            $max_adult = $clsCruiseProperty->getOneField('number_adult', $lastAdultSize) ? $clsCruiseProperty->getOneField('number_adult', $lastAdultSize) : 0;
            $field .= ',max_adult';
            $value .= ",'" . $max_adult . "'";
            //print_r($field.'xxxx'. $value); die();
            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_cabin&cruise_cabin_id=' . $core->encryptID($max_id) . $pUrl . '&message=updateSuccess');
                } else {
                    header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/cabin/cabin&message=insertSuccess");
                }
            } else {
                header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/cabin/cabin&message=insertFailed");
            }
        }
    }
}

function default_ajUpdPosSortCruiseCabin()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCruiseCabin = new CruiseCabin();
    $order = $_POST['order_cabin'];
    foreach ($order as $key => $val) {
        $key = $key + 1;
        $clsCruiseCabin->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_delete_cruise_cabin()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "CruiseCabin";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;

    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : "";
    #


    if ($string == '' && $pvalTable == 0)
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/cabin/cabin&message=DeleteFailed");

    if ($clsClassTable->doDelete($pvalTable)) {
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/cabin/cabin&message=DeleteSuccess");
    }
}

function default_trash_cruise_cabin()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "CruiseCabin";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;

    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : "";

    if ($pvalTable == "")
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/cabin/cabin&message=TrashFailed");

    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/cabin/cabin&message=TrashSuccess");
    }
}

function default_restore_cruise_cabin()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "CruiseCabin";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;

    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : "";

    if ($pvalTable == "")
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/cabin/cabin&message=RestoreFailed");

    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/cabin/cabin&message=RestoreSuccess");
    }
}

function default_delete_cruise_itinerary()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "CruiseItinerary";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;

    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : "";
    #
    if ($string == '' && $pvalTable == 0)
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=DeleteFailed");

    if ($clsClassTable->doDelete($pvalTable)) {
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=DeleteSuccess");
    }
}

function default_trash_cruise_itinerary()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "CruiseItinerary";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;

    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : "";

    if ($pvalTable == "")
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=TrashFailed");

    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=TrashSuccess");
    }
}

function default_restore_cruise_itinerary()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "CruiseItinerary";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;

    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : "";

    if ($pvalTable == "")
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=RestoreFailed");
    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=RestoreSuccess");
    }
}

function default_delete_itinerary()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "CruiseItinerary";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : "";
    $return = isset($_GET['return']) ? $_GET['return'] : '';
    #
    $clsCruisePriceRow = new CruisePriceRow();
    $clsCruisePriceCol = new CruisePriceCol();
    $clsCruisePriceVal = new CruisePriceVal();
    #
    if ($pvalTable == "") {
        if ($return == 'edit') {
            header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=notPermission");
        } else {
            header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=notPermission");
        }
    }
    if ($clsClassTable->deleteOne($pvalTable)) {
        $clsCruisePriceRow->deleteByCond("cruise_itinerary_id = '$pvalTable'");
        $clsCruisePriceCol->deleteByCond("cruise_itinerary_id = '$pvalTable'");
        $clsCruisePriceVal->deleteByCond("cruise_itinerary_id = '$pvalTable'");
        #
        if ($return == 'edit') {
            header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=DeleteSuccess");
        } else {
            header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/itinerary/itinerary&message=DeleteSuccess");
        }
    }
}

function default_trash_cruise_video()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "CruiseVideo";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;

    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : "";

    if ($pvalTable == "")
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/video/video&message=TrashFailed");

    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/video/video&message=TrashSuccess");
    }
}

function default_restore_cruise_video()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "CruiseVideo";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;

    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : "";

    if ($pvalTable == "")
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/video/video&message=RestoreFailed");

    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/video/video&message=RestoreSuccess");
    }
}

function default_delete_cruise_video()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "CruiseVideo";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;

    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : "";
    #
    if ($string == '' && $pvalTable == 0)
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/video/video&message=DeleteFailed");

    if ($clsClassTable->doDelete($pvalTable)) {
        header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/video/video&message=DeleteSuccess");
    }
}

function default_ajOpenManageCabinPriceCruiseOld()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $clsConfiguration, $dbconn, $lang_sql;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruiseCabin = new CruiseCabin();
    $clsCruiseProperty = new CruiseProperty();
    $clsCruiseSeasonPrice = new CruiseSeasonPrice();
    $clsCruiseItinerary = new CruiseItinerary();

    $cruise_id = isset($_POST['cruise_id']) ? intval($_POST['cruise_id']) : 0;
    $cruise_cabin_id = isset($_POST['cruise_cabin_id']) ? intval($_POST['cruise_cabin_id']) : 0;
    $group_size_id = isset($_POST['group_size_id']) ? intval($_POST['group_size_id']) : 0;
    $cruise_itinerary_id = isset($_POST['cruise_itinerary_id']) ? intval($_POST['cruise_itinerary_id']) : 0;
    $season = isset($_POST['season']) ? $_POST['season'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';

    $lstCruiseCabin = $clsCruiseCabin->getAll("cruise_id='$cruise_id' order by order_no asc");
    $lstGroupSize = $clsCruiseProperty->getAll("type='GroupSize' order by order_no ASC");

    $high_season_month = $clsConfiguration->getValue('high_season_month');
    $number_high_season_month = explode(',', $high_season_month);

    $html_high_season = $core->get_Lang('month') . ' ';
    if ($number_high_season_month != '') {
        for ($i = 0; $i < count($number_high_season_month); $i++) {
            if (!empty($number_high_season_month[$i])) {
                $html_high_season .= ($i == 0 ? '' : ', ') . $number_high_season_month[$i];
            }
        }
    }
    $lstMonth = array();
    for ($i = 1; $i <= 12; $i++) {
        $lstMonth[] = ($i < 10) ? '0' . $i : $i;
    }
    $assign_list["lstMonth"] = $lstMonth;
    $html_low_season = $core->get_Lang('month') . ' ';
    for ($i = 0; $i < count($lstMonth); $i++) {
        if ($clsISO->checkInArray($high_season_month, $lstMonth[$i])) {
        } else {
            $html_low_season .= '';
            $html_low_season .= $lstMonth[$i];
            if ($i < count($lstMonth) - 1) {
                $html_low_season .= ', ';
            }
        }
    }
    if ($tp == 'L') {
        $html = '
		<div id="tourPriceTable">';
        if ($lstCruiseCabin[0][$clsCruiseCabin->pkey] != '') {
            $html .= '
			<table class="table tbl-grid" width="100%" style="border:1px solid #ccc;">
				<thead>
					<tr>
						<td rowspan="3" class="gridheader">
							<strong><span class="table_price_title">' . $core->get_Lang('Cabin') . '</span></strong>
						</td>
						<td class="gridheader" style="text-align:center;" colspan="' . count($lstGroupSize) . '">
							<strong>' . $core->get_Lang('Low Season') . ' <i title="' . $html_low_season . '" class="fa fa-question-circle" aria-hidden="true"></i></strong> 
						</td>
						<td class="gridheader" style="text-align:center;" colspan="' . count($lstGroupSize) . '">
							<strong>' . $core->get_Lang('High Season') . ' <i title="' . $html_high_season . '" class="fa fa-question-circle" aria-hidden="true"></i></strong> 
						</td>
					</tr>
				<tr>
				<tr>';
            // Low
            for ($i = 0; $i < count($lstGroupSize); $i++) {
                $html .= '<td class="gridheader" style="text-align:center;">' . ($clsCruiseProperty->getNumberAdult($lstGroupSize[$i]['cruise_property_id']) > 1 ? $clsCruiseProperty->getNumberAdult($lstGroupSize[$i]['cruise_property_id']) . ' ' . $core->get_Lang('Adults') : $clsCruiseProperty->getNumberAdult($lstGroupSize[$i]['cruise_property_id']) . ' ' . $core->get_Lang('Adult')) . '</td>';
            }
            // High
            for ($i = 0; $i < count($lstGroupSize); $i++) {
                $html .= '<td class="gridheader" style="text-align:center;">' . ($clsCruiseProperty->getNumberAdult($lstGroupSize[$i]['cruise_property_id']) > 1 ? $clsCruiseProperty->getNumberAdult($lstGroupSize[$i]['cruise_property_id']) . ' ' . $core->get_Lang('Adults') : $clsCruiseProperty->getNumberAdult($lstGroupSize[$i]['cruise_property_id']) . ' ' . $core->get_Lang('Adult')) . '</td>';
            }
            $html .= '
				</tr>
			</thead>';
            for ($i = 0; $i < count($lstCruiseCabin); $i++) {
                $html .= '
				<tr>
					<td style="text-align:left;">' . $clsCruiseCabin->getTitle($lstCruiseCabin[$i]['cruise_cabin_id']) . '</td>';
                // Low
                for ($k = 0; $k < count($lstGroupSize); $k++) {
                    $html .= '
						<td class="text-center">
							' . $clsISO->getRate() . '<br />
							<input class="text full price-In cruise_season_price fontLarge" style="width:calc(100% - 10px); text-align:right; color:red;" cruise_cabin_id="' . $lstCruiseCabin[$i]['cruise_cabin_id'] . '" group_size_id="' . $lstGroupSize[$k]['cruise_property_id'] . '" season="low" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" value="' . $clsCruiseSeasonPrice->getPriceDefault($cruise_itinerary_id, $lstCruiseCabin[$i]['cruise_cabin_id'], $lstGroupSize[$k]['cruise_property_id'], 'low') . '" type="text" ' . ($clsISO->checkContainer($lstCruiseCabin[$i]['list_group_size'], $lstGroupSize[$k]['cruise_property_id']) ? '' : 'disabled="disabled"') . '/>
							
						</td>';
                }
                // High
                for ($k = 0; $k < count($lstGroupSize); $k++) {
                    $html .= '
						<td class="text-center">
							' . $clsISO->getRate() . '<br />
							<input class="text full price-In cruise_season_price fontLarge" style="width:calc(100% - 10px); text-align:right; color:red;" cruise_cabin_id="' . $lstCruiseCabin[$i]['cruise_cabin_id'] . '" group_size_id="' . $lstGroupSize[$k]['cruise_property_id'] . '" season="high" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" value="' . $clsCruiseSeasonPrice->getPriceDefault($cruise_itinerary_id, $lstCruiseCabin[$i]['cruise_cabin_id'], $lstGroupSize[$k]['cruise_property_id'], 'high') . '" type="text"  ' . ($clsISO->checkContainer($lstCruiseCabin[$i]['list_group_size'], $lstGroupSize[$k]['cruise_property_id']) ? '' : 'disabled="disabled"') . '/>
						</td>';
                }
                $html .= '</tr>';
            }
            if (1 == 2) {
                $html .= '<tr>';
                $html .= '<td class="gridheader" style="text-align:left;"><strong>' . $core->get_Lang('status') . '</strong></td>';
                // Low
                for ($k = 0; $k < count($lstGroupSize); $k++) {
                    $html .= '
				<td class="gridheader text-center">
					<input type="checkbox" ' . ($clsCruiseItinerary->checkRoomTypeAvailable($cruise_itinerary_id, $lstGroupSize[$k]['cruise_property_id'], 'low') ? 'checked="checked"' : '') . ' name="is_hide" season="low" class="changeToHide changeToHide_low" cruise_itinerary_id="' . $cruise_itinerary_id . '" value="' . $lstGroupSize[$k]['cruise_property_id'] . '" >
				</td>';
                }
                // High
                for ($k = 0; $k < count($lstGroupSize); $k++) {
                    $html .= '
				<td class="gridheader text-center">
					<input type="checkbox" ' . ($clsCruiseItinerary->checkRoomTypeAvailable($cruise_itinerary_id, $lstGroupSize[$k]['cruise_property_id'], 'high') ? 'checked="checked"' : '') . ' name="is_hide" season="high" class="changeToHide changeToHide_high" cruise_itinerary_id="' . $cruise_itinerary_id . '" value="' . $lstGroupSize[$k]['cruise_property_id'] . '" >
				</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</table>';
        } else {
            $html .= '<div class="infobox"><b>' . $core->get_Lang('warning') . '</b><br>' . $core->get_Lang('nodata') . '</div>';
        }
        $html .= '</div>
		<br />
		<p>' . $core->get_Lang('Note: Please enter price & system price automatic save !') . '</p>
		';
        #
        echo ($html);
        die();
    } else if ($tp == 'S') {
        $price = str_replace('.', '', $_POST['price']);

        $res = $clsCruiseSeasonPrice->getAll("cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and group_size_id='$group_size_id' and season='$season'");
        if ($res[0]['cruise_season_price_id'] != '') {
            $clsCruiseSeasonPrice->updateOne($res[0]['cruise_season_price_id'], "price='" . $clsISO->processSmartNumber($price) . "'");
            $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and season='$season' and price > 0";
            $min_price = $dbconn->GetOne($SQL);
            //print_r($cruise_itinerary_id.'min_"'.$season.'"_price'.$min_price); die();
            $clsCruiseItinerary->updateOne($cruise_itinerary_id, "min_" . $season . "_price='" . $min_price . "'");
        } else {
            $max_id = $clsCruiseSeasonPrice->getMaxId();
            $f = "$clsCruiseSeasonPrice->pkey, cruise_id,cruise_itinerary_id,cruise_cabin_id,season,price,user_id,user_id_update,reg_date,upd_date,group_size_id";
            $v = "'$max_id'
				,'$cruise_id'
				,'$cruise_itinerary_id'
				,'$cruise_cabin_id'
				,'$season'
				,'" . $clsISO->processSmartNumber($price) . "'
				,'$user_id'
				,'$user_id'
				,'" . time() . "'
				,'" . time() . "'
				,'$group_size_id'
			";
            $clsCruiseSeasonPrice->insertOne($f, $v);
            $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and season='$season' and price > 0";
            $min_price = $dbconn->GetOne($SQL);
            $clsCruiseItinerary->updateOne($cruise_itinerary_id, "min_" . $season . "_price='" . $min_price . "'");
        }
        echo '0|||' . $clsISO->formatPrice($price);
        die();
    } else if ($tp == 'S_EXB') {
        $price = str_replace('.', '', $_POST['price']);

        print_r($price);
        die('xxxx');

        $res = $clsCruiseSeasonPrice->getAll("cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and group_size_id='$group_size_id' and season='$season'");

        print_r($res);
        die('xxxx');

        if ($res[0]['cruise_season_price_id'] != '') {
            $clsCruiseSeasonPrice->updateOne($res[0]['cruise_season_price_id'], "price_extra_bed='" . $clsISO->processSmartNumber($price) . "'");
        } else {
            $max_id = $clsCruiseSeasonPrice->getMaxId();
            $f = "$clsCruiseSeasonPrice->pkey, cruise_id,cruise_itinerary_id,cruise_cabin_id,season,price_extra_bed,user_id,user_id_update,reg_date,upd_date,group_size_id";
            $v = "'$max_id'
				,'$cruise_id'
				,'$cruise_itinerary_id'
				,'$cruise_cabin_id'
				,'$season'
				,'" . $clsISO->processSmartNumber($price) . "'
				,'$user_id'
				,'$user_id'
				,'" . time() . "'
				,'" . time() . "'
				,'$group_size_id'
			";
            $clsCruiseSeasonPrice->insertOne($f, $v);
        }
        echo '0|||' . $clsISO->formatPrice($price);
        die();
    } else if ($tp == 'H') {
        $is_hide = isset($_POST['is_hide']) ? intval($_POST['is_hide']) : 0;
        #
        $cond = "cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and group_size_id='$group_size_id' and season='$season'";
        if (intval($is_hide) > 0) {
            $clsCruiseSeasonPrice->updateByCond($cond, "is_hide=0");
        } else {
            $clsCruiseSeasonPrice->updateByCond($cond, "is_hide=1");
        }
    }
}

function default_ajOpenManageCabinPriceCruise()
{
    //	ini_set('display_errors', '1');
    //	ini_set('display_startup_errors', '1');
    //	error_reporting(E_ALL);
    global $assign_list, $now_month, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $clsConfiguration, $dbconn, $lang_sql;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruise = new Cruise();
    $assign_list['clsCruise'] = $clsCruise;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list['clsCruiseCabin'] = $clsCruiseCabin;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list['clsCruiseProperty'] = $clsCruiseProperty;
    $clsCruiseSeasonPrice = new CruiseSeasonPrice();
    $assign_list['clsCruiseSeasonPrice'] = $clsCruiseSeasonPrice;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list['clsCruiseItinerary'] = $clsCruiseItinerary;

    $cruise_id = isset($_POST['cruise_id']) ? intval($_POST['cruise_id']) : 0;
    $assign_list['cruise_id'] = $cruise_id;
    $cruise_cabin_id = isset($_POST['cruise_cabin_id']) ? intval($_POST['cruise_cabin_id']) : 0;
    $assign_list['cruise_cabin_id'] = $cruise_cabin_id;
    $group_size_id = isset($_POST['group_size_id']) ? intval($_POST['group_size_id']) : 0;
    $assign_list['group_size_id'] = $group_size_id;
    $cruise_itinerary_id = isset($_POST['cruise_itinerary_id']) ? intval($_POST['cruise_itinerary_id']) : 0;
    $assign_list['cruise_itinerary_id'] = $cruise_itinerary_id;
    $season = isset($_POST['season']) ? $_POST['season'] : '';
    $assign_list['season'] = $season;
    $price_by = isset($_POST['price_by']) ? $_POST['price_by'] : '0';
    $assign_list['price_by'] = $price_by;
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $number_adult = (int)Input::post("number_adult", 0);

    $lstCruiseCabin = $clsCruiseCabin->getAll("cruise_id='$cruise_id' order by order_no asc");
    $assign_list['lstCruiseCabin'] = $lstCruiseCabin;
    $assign_list['numberCabin'] = (!empty($lstCruiseCabin)) ? count($lstCruiseCabin) : 0;
    $lstGroupSize = $clsCruiseProperty->getAll("type='GroupSize' order by order_no ASC");
    $assign_list['lstGroupSize'] = $lstGroupSize;

    $high_season_month = $clsConfiguration->getValue('high_season_month');
    $number_high_season_month = explode(',', $high_season_month);

    $html_high_season = $core->get_Lang('month') . ' ';
    if ($number_high_season_month != '') {
        for ($i = 0; $i < count($number_high_season_month); $i++) {
            if (!empty($number_high_season_month[$i])) {
                $html_high_season .= ($i == 0 ? '' : ', ') . $number_high_season_month[$i];
            }
        }
    }
    $lstMonth = array();
    for ($i = 1; $i <= 12; $i++) {
        $lstMonth[] = ($i < 10) ? '0' . $i : $i;
    }
    $assign_list["lstMonth"] = $lstMonth;
    $html_low_season = $core->get_Lang('month') . ' ';
    for ($i = 0; $i < count($lstMonth); $i++) {
        if ($clsISO->checkInArray($high_season_month, $lstMonth[$i])) {
        } else {
            $html_low_season .= '';
            $html_low_season .= $lstMonth[$i];
            if ($i < count($lstMonth) - 1) {
                $html_low_season .= ', ';
            }
        }
    }
    $assign_list['html_high_season'] = $html_high_season;
    $assign_list['html_low_season'] = $html_low_season;
    if ($tp == 'L') {
        $cruise = $clsCruise->getOne($cruise_id);
        $assign_list['deposit'] = $cruise["deposit"];
        $assign_list['cruise_type'] = $cruise['cruise_type'];
        $assign_list['config_price_overnight'] = !empty($cruise['config_price_overnight'])
            ? json_decode($cruise['config_price_overnight'], true) : [];
        if ($assign_list['config_price_overnight']) {
            $assign_list['list_group_size'] = join(',', $assign_list['config_price_overnight']['groups']);
            $assign_list['config_price_overnight'] = !empty($assign_list['config_price_overnight']['prices'][$cruise_itinerary_id]) ? $assign_list['config_price_overnight']['prices'][$cruise_itinerary_id] : [];
        }

        $priceByLow = $clsCruiseItinerary->getOneField("price_by_low", $cruise_itinerary_id);
        $assign_list['priceByLow'] = $priceByLow;
        $priceByHigh = $clsCruiseItinerary->getOneField("price_by_high", $cruise_itinerary_id);
        $assign_list['priceByHigh'] = $priceByHigh;
        $html = $clsISO->build("ajLoadFormCruisePrice.tpl");
        # Update min_price cho cruise
        $clsCruise->updateOne($cruise_id, "min_price={$clsCruise->getLTripPrice1($cruise_id,$now_month, "update_min_price")}");
        echo ($html);
        die();

        if ($lstCruiseCabin[0][$clsCruiseCabin->pkey] != '') {
            $html = '<div class="table-wrapper mb-half radius-3">
				   <table class="table table-iloocal table-bordered mb-0 radius-3">
					  <tbody>
						 <tr class="bg-gray">
							<td colspan="2" class="text-left bg-gray">
								<div class="d-flex justify-content-between align-items-center" >
									<div>
										<strong>' . $core->get_Lang("Low season") . " (" . $html_low_season . ')</strong>
										<div class="info_module" data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $core->get_Lang("Low season") . " (" . $html_low_season . ')">i
										</div>
									</div>
									<div class="box_price_by">
										<div class="boxCheckbox"> 
											<input type="radio" class="check_box_price_by" name="price_by_low" value="1" season="low" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" ' . (($priceByLow == 1) ? "checked" : "") . '> 
											<label class="checkmark">/' . $core->get_Lang('Room') . '</label> 
										</div>
										<div class="boxCheckbox"> 
											<input type="radio" class="check_box_price_by" name="price_by_low" value="0" season="low" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" ' . (($priceByLow == 0) ? "checked" : "") . '> 
											<label class="checkmark">/' . $core->get_Lang('Person') . '</label> 
										</div>
									</div>
								</div>
							</td>
						 </tr>';
            for ($i = 0; $i < count($lstCruiseCabin); $i++) {
                $list_group_size = $clsISO->makeArrayBySlash($lstCruiseCabin[$i]['list_group_size']);
                $listGroupCabin = $clsCruiseProperty->getAll("type='GroupSize' AND " . $clsCruiseProperty->pkey . " IN(" . implode(",", $list_group_size) . ") order by order_no DESC", $clsCruiseProperty->pkey . ',title');
                $html .= '<tr>
							<td width="20%" class="text-left" rowspan="' . (count($listGroupCabin) + 1) . '">
							   <strong>' . $clsCruiseCabin->getTitle($lstCruiseCabin[$i]['cruise_cabin_id']) . '</strong>
							</td>
						 </tr>';
                for ($k = 0; $k < count($listGroupCabin); $k++) {
                    $priceBy = $clsCruiseSeasonPrice->getPriceBy($cruise_itinerary_id, $lstCruiseCabin[$i]['cruise_cabin_id'], $listGroupCabin[$k]['cruise_property_id'], 'low');
                    $html .= '<tr ' . $priceBy . '>
								<td width="80%" class="text-left">
									<div class="d-flex justify-content-between">
										<div class="box_left_group">
											<span>' . $listGroupCabin[$k]['title'] . '</span>											
										</div>
										<div class="d-flex justify-content-between align-items-center">										
											<div class="input-group input-group_price d-flex align-items-center">
												<input class="text full price-In cruise_season_price fontLarge" cruise_cabin_id="' . $lstCruiseCabin[$i]['cruise_cabin_id'] . '" group_size_id="' . $listGroupCabin[$k]['cruise_property_id'] . '" season="low" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" value="' . $clsCruiseSeasonPrice->getPriceDefault($cruise_itinerary_id, $lstCruiseCabin[$i]['cruise_cabin_id'], $listGroupCabin[$k]['cruise_property_id'], 'low') . '" type="text" ' . ($clsISO->checkContainer($lstCruiseCabin[$i]['list_group_size'], $listGroupCabin[$k]['cruise_property_id']) ? '' : 'disabled="disabled"') . '/>
												<span class="input-group-addon">' . $clsISO->getRate() . '</span>
											</div>
											<div class="box_price_by" style="display:none">
												<div class="boxCheckbox"> 
													<input type="radio" class="check_box_price_by" name="price_by_low_' . $lstCruiseCabin[$i]['cruise_cabin_id'] . $listGroupCabin[$k]['cruise_property_id'] . '" value="1" cruise_cabin_id="' . $lstCruiseCabin[$i]['cruise_cabin_id'] . '" group_size_id="' . $listGroupCabin[$k]['cruise_property_id'] . '" season="low" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" ' . (($priceBy == 1) ? "checked" : "") . '> 
													<label class="checkmark">/' . $core->get_Lang('Room') . '</label> 
												</div>
												<div class="boxCheckbox"> 
													<input type="radio" class="check_box_price_by" name="price_by_low_' . $lstCruiseCabin[$i]['cruise_cabin_id'] . $listGroupCabin[$k]['cruise_property_id'] . '" value="0" cruise_cabin_id="' . $lstCruiseCabin[$i]['cruise_cabin_id'] . '" group_size_id="' . $listGroupCabin[$k]['cruise_property_id'] . '" season="low" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" ' . (($priceBy == 0 || !isset($priceBy)) ? "checked" : "") . '> 
													<label class="checkmark">/' . $core->get_Lang('Person') . '</label> 
												</div>
											</div>
										</div>
									</div>
								</td>
							 </tr>';
                    unset($priceBy);
                }
                unset($listGroupCabin, $list_group_size);
            }

            $html .= '</tbody>
			   </table>
			</div>';
            $html .= '<div class="table-wrapper mb-half radius-3">
				   <table class="table table-iloocal table-bordered mb-0 radius-3">
					  <tbody>
					  	<tr class="bg-gray">
							<td colspan="2" class="text-left bg-gray">
								<div class="d-flex justify-content-between align-items-center" >
									<div>
										<strong>' . $core->get_Lang("High season") . " (" . $html_high_season . ')</strong>
										<div class="info_module" data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $core->get_Lang("High season") . " (" . $html_high_season . ')">i
										</div>
									</div>
									<div class="box_price_by">
										<div class="boxCheckbox"> 
											<input type="radio" class="check_box_price_by" name="price_by_high" value="1" season="high" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" ' . (($priceByHigh == 1) ? "checked" : "") . '> 
											<label class="checkmark">/' . $core->get_Lang('Room') . '</label> 
										</div>
										<div class="boxCheckbox"> 
											<input type="radio" class="check_box_price_by" name="price_by_high" value="0" season="high" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" ' . (($priceByHigh == 0) ? "checked" : "") . '> 
											<label class="checkmark">/' . $core->get_Lang('Person') . '</label> 
										</div>
									</div>
								</div>
							</td>
						 </tr>';
            for ($i = 0; $i < count($lstCruiseCabin); $i++) {
                $list_group_size = $clsISO->makeArrayBySlash($lstCruiseCabin[$i]['list_group_size']);
                $listGroupCabin = $clsCruiseProperty->getAll("type='GroupSize' AND " . $clsCruiseProperty->pkey . " IN(" . implode(",", $list_group_size) . ") order by order_no DESC", $clsCruiseProperty->pkey . ',title');
                $html .= '<tr>
							<td width="20%" class="text-left" rowspan="' . (count($listGroupCabin) + 1) . '">
							   <strong>' . $clsCruiseCabin->getTitle($lstCruiseCabin[$i]['cruise_cabin_id']) . '</strong>
							</td>
						 </tr>';
                for ($k = 0; $k < count($listGroupCabin); $k++) {
                    $priceBy = $clsCruiseSeasonPrice->getPriceBy($cruise_itinerary_id, $lstCruiseCabin[$i]['cruise_cabin_id'], $listGroupCabin[$k]['cruise_property_id'], 'high');
                    $html .= '<tr>
								<td width="80%" class="text-left">
									<div class="d-flex justify-content-between">
										<div class="box_left_group">
											<span>' . $listGroupCabin[$k]['title'] . '</span>											
										</div>
										<div class="d-flex justify-content-between align-items-center">	
											<div class="input-group input-group_price d-flex align-items-center">
												<input class="text full price-In cruise_season_price fontLarge" 
												cruise_cabin_id="' . $lstCruiseCabin[$i]['cruise_cabin_id'] . '" group_size_id="' . $listGroupCabin[$k]['cruise_property_id'] . '" season="high" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" value="' . $clsCruiseSeasonPrice->getPriceDefault($cruise_itinerary_id, $lstCruiseCabin[$i]['cruise_cabin_id'], $listGroupCabin[$k]['cruise_property_id'], 'high') . '" type="text"  ' . ($clsISO->checkContainer($lstCruiseCabin[$i]['list_group_size'], $listGroupCabin[$k]['cruise_property_id']) ? '' : 'disabled="disabled"') . '/>
												<span class="input-group-addon">' . $clsISO->getRate() . '</span>
											</div>	
											<div class="box_price_by" style="display:none">
												<div class="boxCheckbox"> 
													<input type="radio" class="check_box_price_by" name="price_by_high_' . $lstCruiseCabin[$i]['cruise_cabin_id'] . $listGroupCabin[$k]['cruise_property_id'] . '" value="1" cruise_cabin_id="' . $lstCruiseCabin[$i]['cruise_cabin_id'] . '" group_size_id="' . $listGroupCabin[$k]['cruise_property_id'] . '" season="high" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" ' . (($priceBy == 1) ? "checked" : "") . '> 
													<label class="checkmark">/' . $core->get_Lang('Room') . '</label> 
												</div>
												<div class="boxCheckbox"> 
													<input type="radio" class="check_box_price_by" name="price_by_high_' . $lstCruiseCabin[$i]['cruise_cabin_id'] . $listGroupCabin[$k]['cruise_property_id'] . '" value="0" cruise_cabin_id="' . $lstCruiseCabin[$i]['cruise_cabin_id'] . '" group_size_id="' . $listGroupCabin[$k]['cruise_property_id'] . '" season="high" cruise_id="' . $cruise_id . '" cruise_itinerary_id="' . $cruise_itinerary_id . '" ' . ((($priceBy == 0) || (empty($priceBy))) ? "checked" : "") . '> 
													<label class="checkmark">/' . $core->get_Lang('Person') . '</label> 
												</div>
											</div>
										</div>
									</div>
								</td>
							 </tr>';
                    unset($priceBy);
                }
                unset($listGroupCabin, $list_group_size);
            }

            $html .= '</tbody>
			   </table>
			</div>';
        }
        #
        echo ($html);
        die();
    } else if ($tp == 'S') {
        $price = str_replace('.', '', $_POST['price']);

        if (!empty($_POST['overnight'])) {
            $config_price_overnight = $clsCruise->getOneField('config_price_overnight', $cruise_id);
            $config_price_overnight = !empty($config_price_overnight)
                ? json_decode($config_price_overnight, true) : [];
            if (!empty($number_adult)) {
                $config_price_overnight['prices'][$cruise_itinerary_id][$group_size_id][$season]['person'][$number_adult] = $price;
            } else {
                $config_price_overnight['prices'][$cruise_itinerary_id][$group_size_id][$season]['carbin'] = $price;
            }
            $config_price_overnight = addslashes(json_encode($config_price_overnight));
            $clsCruise->updateOne($cruise_id, "config_price_overnight = '$config_price_overnight'");
            echo '0|||' . $clsISO->formatPrice($price);
            die();
        }

        $res = $clsCruiseSeasonPrice->getAll("cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and group_size_id='$group_size_id' and season='$season' and number_adult='$number_adult'");
        if ($res[0]['cruise_season_price_id'] != '') {
            $clsCruiseSeasonPrice->updateOne($res[0]['cruise_season_price_id'], "price='" . $clsISO->processSmartNumber($price) . "',price_by='" . $price_by . "'");
            $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and season='$season' and price > 0";
            $min_price = $dbconn->GetOne($SQL);
            //print_r($cruise_itinerary_id.'min_"'.$season.'"_price'.$min_price); die();
            $clsCruiseItinerary->updateOne($cruise_itinerary_id, "min_" . $season . "_price='" . $min_price . "'");
        } else {
            $max_id = $clsCruiseSeasonPrice->getMaxId();
            $f = "$clsCruiseSeasonPrice->pkey, cruise_id,cruise_itinerary_id,cruise_cabin_id,season,price,price_by,user_id,user_id_update,reg_date,upd_date,group_size_id,number_adult";
            $v = "'$max_id'
				,'$cruise_id'
				,'$cruise_itinerary_id'
				,'$cruise_cabin_id'
				,'$season'
				,'" . $clsISO->processSmartNumber($price) . "'
				,'" . $price_by . "'
				,'$user_id'
				,'$user_id'
				,'" . time() . "'
				,'" . time() . "'
				,'$group_size_id'
				,'$number_adult'
			";
            $clsCruiseSeasonPrice->insertOne($f, $v);
            $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and season='$season' and price > 0";
            $min_price = $dbconn->GetOne($SQL);
            $clsCruiseItinerary->updateOne($cruise_itinerary_id, "min_" . $season . "_price='" . $min_price . "'");
        }
        echo '0|||' . $clsISO->formatPrice($price);
        die();
    } else if ($tp == 'S_EXB') {
        $price = str_replace('.', '', $_POST['price']);

        $res = $clsCruiseSeasonPrice->getAll("cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and group_size_id='$group_size_id' and season='$season'");
        if ($res[0]['cruise_season_price_id'] != '') {
            $clsCruiseSeasonPrice->updateOne($res[0]['cruise_season_price_id'], "price_extra_bed='" . $clsISO->processSmartNumber($price) . "'");
        } else {
            $max_id = $clsCruiseSeasonPrice->getMaxId();
            $f = "$clsCruiseSeasonPrice->pkey, cruise_id,cruise_itinerary_id,cruise_cabin_id,season,price_extra_bed,user_id,user_id_update,reg_date,upd_date,group_size_id";
            $v = "'$max_id'
				,'$cruise_id'
				,'$cruise_itinerary_id'
				,'$cruise_cabin_id'
				,'$season'
				,'" . $clsISO->processSmartNumber($price) . "'
				,'$user_id'
				,'$user_id'
				,'" . time() . "'
				,'" . time() . "'
				,'$group_size_id'
			";
            $clsCruiseSeasonPrice->insertOne($f, $v);
        }
        echo '0|||' . $clsISO->formatPrice($price);
        die();
    } else if ($tp == 'H') {
        $is_hide = isset($_POST['is_hide']) ? intval($_POST['is_hide']) : 0;
        #
        $cond = "cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and group_size_id='$group_size_id' and season='$season'";
        if (intval($is_hide) > 0) {
            $clsCruiseSeasonPrice->updateByCond($cond, "is_hide=0");
        } else {
            $clsCruiseSeasonPrice->updateByCond($cond, "is_hide=1");
        }
    }
}

function default_ajUpdatePriceBy()
{
    global $core, $now_month;

    $clsCruiseItinerary = new CruiseItinerary();
    $clsCruise = new Cruise();
    $cruise_id = (int)Input::post('cruise_id', 0);
    $cruise_itinerary_id = (int)Input::post('cruise_itinerary_id', 0);
    $clsCruiseSeasonPrice = new CruiseSeasonPrice();

    $price_by = (int)Input::post('price_by', 0);
    $season = Input::post('season', "");
    $data = ["result" => false];
    if ($cruise_id > 0 && $cruise_itinerary_id > 0) {
        $checkExistCruiseItinerary = $clsCruiseItinerary->countItem("cruise_id='" . $cruise_id . "' AND cruise_itinerary_id='" . $cruise_itinerary_id . "'");
        if ($checkExistCruiseItinerary == 1) {
            if ($price_by == 0) {
                $cond = " AND number_adult=0";
            } else {
                $cond = " AND number_adult > 0";
            }

            if ($season == 'low') {
                $clsCruiseItinerary->updateOne($cruise_itinerary_id, "price_by_low='" . $price_by . "'");
                /*$clsCruiseSeasonPrice->deleteByCond("cruise_itinerary_id='$cruise_itinerary_id' and cruise_id='".$cruise_id."' AND season='".$season."'".$cond);*/
                $data = ["result" => true];
            } else if ($season == 'high') {
                $clsCruiseItinerary->updateOne($cruise_itinerary_id, "price_by_high='" . $price_by . "'");
                /*$clsCruiseSeasonPrice->deleteByCond("cruise_itinerary_id='$cruise_itinerary_id' and cruise_id='".$cruise_id."' AND season='".$season."'".$cond);*/
                $data = ["result" => true];
            }
            $jsonString = json_decode($clsCruise->getOneField("config_price_overnight", $cruise_id), true);
            $jsonString['prices'][$cruise_itinerary_id]["price_by"] = $price_by;
            $upd_cf_price_overnight = json_encode($jsonString, JSON_UNESCAPED_UNICODE);
            $clsCruise->updateOne($cruise_id, "config_price_overnight='$upd_cf_price_overnight'");
        }
    }
    echo json_encode($data);
    die;
}

function default_ajaxFrmNewCruisePriceRow()
{
    global $core;
    $cruise_itinerary_id = $_POST['cruise_itinerary_id'];
    #
    $html = '
	<div class="headPop"> 
		<a id="clickToCloseNewTourCruisePriceRow" href="javascript:void();" class="closeEv close_pop"></a> 
		<h3>' . $core->get_Lang('addrow') . '</h3> 
	</div> 
	<table width="100%" class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea">
				<input type="text" placeholder="' . $core->get_Lang('entertitle') . '" id="titleFx" class="required fontLarge text full" style="width:95%" value="">
			</td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button class="btn btn-success submitClick ajaxCreateNewCruisePriceRow" cruise_itinerary_id="' . $cruise_itinerary_id . '">' . $core->get_Lang('save') . '</button> 
		<button class="btn btn-warning close_pop" data-dismiss="modal" aria-hidden="true">' . $core->get_Lang('close') . '</button> 
	</div>';
    echo ($html);
    die();
}

function default_ajaxFrmEditCruisePriceRow()
{
    global $core, $_LANG_ID;
    #
    $clsCruisePriceRow = new CruisePriceRow();
    $cruise_price_row_id = $_POST['cruise_price_row_id'];
    #
    $html = '
	<div class="headPop"> 
		<a id="clickToCloseNewTourCruisePriceRow" href="javascript:void();" class="closeEv close_pop"></a> 
		<h3>' . $core->get_Lang('editrow') . ' [#' . $cruise_price_row_id . ']</h3> 
	</div> 
	<table width="100%" class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea">
				<input type="text" id="titleFx" class="required fontLarge text" style="width:95%" value="' . $clsCruisePriceRow->getTitle($cruise_price_row_id) . '">
			</td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button class="btn btn-success submitClick ajaxSaveCruisePriceRow" data="' . $cruise_price_row_id . '" toField="title">' . $core->get_Lang('save') . '</button> 
		<button class="btn btn-warning close_pop">' . $core->get_Lang('close') . '</button> 
	</div>';
    echo ($html);
    die();
}

function default_ajaxCreateNewCruisePriceRow()
{
    global $core, $_frontIsLoggedin_user_id;
    global $_LANG_ID;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruisePriceRow = new CruisePriceRow();
    $cruise_itinerary_id = $_POST['cruise_itinerary_id'];
    $titlePost = isset($_POST['title']) ? addslashes($_POST['title']) : '';
    #
    $all = $clsCruisePriceRow->getAll("is_trash=0 and cruise_itinerary_id='$cruise_itinerary_id' and title='" . $titlePost . "' limit 0,1");
    if (!empty($all)) {
    } else {
        $f = "user_id,cruise_itinerary_id,title,order_no";
        $v = "'$user_id','$cruise_itinerary_id','" . addslashes($titlePost) . "','" . $clsCruisePriceRow->getMaxOrderNo() . "'";
        $clsCruisePriceRow->insertOne($f, $v);
    }
    echo (1);
    die();
}

function default_ajaxDeleteCruisePriceRow()
{
    global $core, $_LANG_ID;
    #
    $clsCruisePriceRow = new CruisePriceRow();
    $cruise_price_row_id = $_POST['cruise_price_row_id'];
    #
    $clsCruisePriceRow->deleteOne($cruise_price_row_id);
    $clsCruisePriceVal = new CruisePriceVal();
    $clsCruisePriceVal->deleteByCond("cruise_price_row_id='$cruise_price_row_id'");
    echo (1);
    die();
}

function default_saveField()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    #
    $html = '';
    #
    $clsTable = $_POST['clsTable'];
    $pkey = $_POST['pkey'];
    $pvalTable = $_POST['pvalTable'];
    $toField = $_POST['toField'];
    $val = $_POST['val'];
    $allowDuplicate = $_POST['allowDuplicate'];
    #
    $clsClassTable = new $clsTable();
    if ($allowDuplicate == 1) {
        //allow duplicate
        $clsClassTable->updateOne($pvalTable, $toField . "='" . addslashes($val) . "'");
        $html = $val;
    } else {
        $all = $clsClassTable->getAll($toField . "='$val'");
        if ($all[0][$pkey] != '' && $all[0][$pkey] != $pvalTable) {
            $html = 'IsDuplicated';
        } else {
            $clsClassTable->updateOne($pvalTable, $toField . "='" . addslashes($val) . "'");
            $html = $val;
        }
    }
    #
    echo ($html);
    die();
}

function default_ajaxFrmCruisePriceHead()
{
    global $core, $_LANG_ID;
    #
    $clsCruiseItinerary = new CruiseItinerary();
    $cruise_itinerary_id = $_POST['cruise_itinerary_id'];
    $tp = $_POST['tp'];

    if ($tp == 'L') {
        $toField = "low_season_title";
        $val = $clsCruiseItinerary->getLowSeasonTitle($cruise_itinerary_id);
    } else if ($tp == 'H') {
        $toField = "high_season_title";
        $val = $clsCruiseItinerary->getHighSeasonTitle($cruise_itinerary_id);
    } else {
        $toField = "table_price_title";
        $val = $clsCruiseItinerary->getTablePriceTitle($cruise_itinerary_id);
    }
    #
    $html = '
	<div class="headPop"> 
		<a id="clickToCloseNewTourPriceRow" href="javascript:void();" class="closeEv close_pop"></a> 
		<h3>' . $core->get_Lang('Update price table') . '</h3> 
	</div> 
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea">
				<input type="text" id="titleFx" class="text full fontLarge" style="width:95%" value="' . $val . '">
				<div class="clearfix mt5"></div>
				<font color="#c00000">' . $core->get_Lang('use <br /> to break line.') . '</font>
			</td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button class="btn btn-success submitClick ajaxSaveCruisePriceRowHead" cruise_itinerary_id="' . $cruise_itinerary_id . '" toField="' . $toField . '">' . $core->get_Lang('Update') . '</button> 
	</div>';
    echo ($html);
    die();
}

function default_ajLoadEditTourPriceCol()
{
    global $core, $_LANG_ID;
    #
    $clsCruisePriceCol = new CruisePriceCol();
    $cruise_price_col_id = $_POST['cruise_price_col_id'];
    #
    $html = '
	<div class="headPop"> 
		<a id="clickToCloseNewTourPriceRow" href="javascript:void();" class="closeEv close_pop">&nbsp;</a> 
		<h3>' . $core->get_Lang('editcol') . ' [#' . $cruise_price_col_id . ']</h3> 
	</div> 
	<table width="100%" class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea">
				<input type="text" id="titleFx" class="required fontLarge text" style="width:95%" value="' . $clsCruisePriceCol->getTitle($cruise_price_col_id) . '">
			</td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button class="btn btn-success submitClick ajaxSaveCruisePriceCol" data="' . $cruise_price_col_id . '" toField="title">' . $core->get_Lang('save') . '</button> 
		<button class="btn btn-warning close_pop">' . $core->get_Lang('close') . '</button> 
	</div>';
    echo ($html);
    die();
}

function default_ajaxPosCruisePriceRow()
{
    global $clsISO;
    #
    $clsCruisePriceRow = new CruisePriceRow();
    $cruise_price_row_id = $_POST['cruise_price_row_id'];
    $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
    #
    $oneTable = $clsCruisePriceRow->getOne($cruise_price_row_id);
    $cruise_itinerary_id = $oneTable['cruise_itinerary_id'];
    $order_no = $oneTable['order_no'];
    #
    $where = "cruise_itinerary_id='$cruise_itinerary_id'";

    if ($direct == 'up') {
        $lst = $clsCruisePriceRow->getAll($where . " and order_no<$order_no order by order_no desc limit 0,1");
        $clsCruisePriceRow->updateOne($cruise_price_row_id, "order_no='" . $lst[0]['order_no'] . "'");
        $clsCruisePriceRow->updateOne($lst[0][$clsCruisePriceRow->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'down') {
        $lst = $clsCruisePriceRow->getAll($where . " and order_no>$order_no order by order_no asc limit 0,1");
        $clsCruisePriceRow->updateOne($cruise_price_row_id, "order_no='" . $lst[0]['order_no'] . "'");
        $clsCruisePriceRow->updateOne($lst[0][$clsCruisePriceRow->pkey], "order_no='" . $order_no . "'");
    }
    #
    echo (1);
    die();
}

function default_ajaxFrmCruisePriceVal()
{
    global $core, $clsISO;
    $clsCruisePriceVal = new CruisePriceVal();
    #
    $cruise_price_col_id = $_POST['cruise_price_col_id'];
    $cruise_price_row_id = $_POST['cruise_price_row_id'];
    $cruise_itinerary_id = $_POST['cruise_itinerary_id'];
    #
    $sql = "cruise_price_col_id='$cruise_price_col_id' and cruise_price_row_id='$cruise_price_row_id' and cruise_itinerary_id='$cruise_itinerary_id'";
    $all = $clsCruisePriceVal->getAll($sql . " limit 0,1");
    #
    $html = '
	<div class="headPop"> 
		<a href="javascript:void();" class="closeEv close_pop"></a> 
		<h3>' . $core->get_Lang('editprice') . '</h3> 
	</div> 
	<div class="wrap">
		<div class="fl span100">
			<div class="row-span">
				<input type="text" class="text full required" style="font-size:14px; width:155px;" id="titleVal" value="' . $clsISO->formatPrice($all[0]['price']) . '" />' . $clsISO->getRate() . '
			</div>
		</div>
	</div>
	<div class="modal-footer"> 
		<button class="btn btn-success submitClick ajaxSaveCruisePriceVal" cruise_price_col_id="' . $cruise_price_col_id . '" cruise_price_row_id="' . $cruise_price_row_id . '">' . $core->get_Lang('save') . '</button>
		<button class="btn btn-warning close_pop">' . $core->get_Lang('close') . '</button> 
	</div>';
    echo ($html);
    die();
}

function default_ajaxUpdateCruisePriceVal()
{
    global $clsISO;
    #
    $cruise_itinerary_id = $_POST['cruise_itinerary_id'];
    $cruise_price_col_id = $_POST['cruise_price_col_id'];
    $cruise_price_row_id = $_POST['cruise_price_row_id'];
    $clsCruisePriceVal = new CruisePriceVal();
    #
    $all = $clsCruisePriceVal->getAll("cruise_price_col_id='$cruise_price_col_id' and cruise_price_row_id='$cruise_price_row_id' and cruise_itinerary_id='$cruise_itinerary_id' limit 0,1");
    #
    if ($all[0][$clsCruisePriceVal->pkey] != '') {
        $clsCruisePriceVal->updateOne($all[0][$clsCruisePriceVal->pkey], "price='" . $clsISO->processSmartNumber($_POST['price']) . "'");
    } else {
        $f = "cruise_itinerary_id,cruise_price_col_id,cruise_price_row_id,price";
        $v = "'" . $cruise_itinerary_id . "','" . $cruise_price_col_id . "','" . $cruise_price_row_id . "','" . $clsISO->processSmartNumber($_POST['price']) . "'";
        $clsCruisePriceVal->insertOne($f, $v);
    }
    echo (1);
    die();
}

/*======== SITE CRUISES CABIN ========*/
function default_ajSiteCruiseCabin()
{
    global $core, $clsISO;
    #
    $clsCruise = new Cruise();
    $clsCruiseCabin = new CruiseCabin();
    $clsCruiseProperty = new CruiseProperty();
    #
    $cruise_id = isset($_POST['cruise_id']) ? intval($_POST['cruise_id']) : 0;
    $cruise_cabin_id = isset($_POST['cruise_cabin_id']) ? intval($_POST['cruise_cabin_id']) : 0;
    $tp = isset($_POST['tp']) ? addslashes($_POST['tp']) : '';

    $lstGroupSize = $clsCruiseProperty->getAll("is_trash=0 and type = 'GroupSize' order by order_no asc");
    $assign_list["lstGroupSize"] = $lstGroupSize;

    #
    if ($tp == 'L') {
        $html = '';
        $lstCabin = $clsCruiseCabin->getAll("is_trash=0 and cruise_id='$cruise_id' order by order_no asc");
        if (!empty($lstCabin)) {
            $i = 0;
            foreach ($lstCabin as $item) {
                $html .= '<tr style="cursor:move" id="order_' . $item[$clsCruiseCabin->pkey] . '" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="' . $item[$clsCruiseCabin->pkey] . '" /></td>';
                $html .= '<td class="index">' . ($i + 1) . '</td>';
                $html .= '<td style="width:60px;"><img src="' . $clsCruiseCabin->getImage($item[$clsCruiseCabin->pkey], 60, 40) . '" width="60px" height="40px" /></td>';
                $html .= '<td><a class="clickToEditCruiseCabin" data="' . $item[$clsCruiseCabin->pkey] . '" href="javascript:;"><strong style="font-size:14px">' . $clsCruiseCabin->getTitle($item[$clsCruiseCabin->pkey]) . '</strong></a></td>';
                $html .= '<td>' . $item['cabin_size'] . '</td>';
                $html .= '<td>' . $item['bed_size'] . '</td>';
                $html .= '<td>' . ($item['extra_bed'] == 0 ? 'Yes' : 'No') . '</td>';
                if (1 == 2) {
                    $html .= '<td style="vertical-align: middle;text-align:center">
					' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('movetop') . '"  direct="movetop" class="moveCruiseCabin" data="' . $item[$clsCruiseCabin->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
				</td>
				<td style="vertical-align: middle;text-align:center">
					' . ($i == count($lstCabin) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="moveCruiseCabin" direct="movebottom" data="' . $item[$clsCruiseCabin->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
				</td>
				<td style="vertical-align: middle;text-align:center">
					' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('moveup') . '" class="moveCruiseCabin" direct="moveup" data="' . $item[$clsCruiseCabin->pkey] . '" href="javascript:void();"><i class="icon-arrow-up"></i></a>') . '
				</td>
				<td style="vertical-align: middle;text-align:center">
					' . ($i == count($lstCabin) - 1 ? '' : '<a title="' . $core->get_Lang('movedown') . '" class="moveCruiseCabin" direct="movedown" data="' . $item[$clsCruiseCabin->pkey] . '" href="javascript:void();"><i class="icon-arrow-down"></i></a>') . '
				</td>';
                }
                $html .= '<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
								<ul class="dropdown-menu" style="right:0px !important">
									<li><a class="clickToEditCruiseCabin" title="' . $core->get_Lang('edit') . '" href="javascript:void();" data="' . $item[$clsCruiseCabin->pkey] . '" cruise_id="' . $cruise_id . '"><i class="icon-edit"></i> <span>' . $core->get_Lang('edit') . '</span></a></li>
									<li><a class="clickToDeleteCruiseCabin" title="' . $core->get_Lang('delete') . '" href="javascript:void();" data="' . $item[$clsCruiseCabin->pkey] . '" cruise_id="' . $cruise_id . '"><i class="icon-remove"></i> <span>' . $core->get_Lang('delete') . '</span></a></li>
								</ul>
							</div>
						</td>';
                $html .= '</tr>';
                ++$i;
            }
            $html .= '
			<script type="text/javascript">
			$("#hotelCabinTable").sortable({
				opacity: 0.8,
				cursor: \'move\',
				start: function(){
					vietiso_loading(1);
				},
				stop: function(){
					vietiso_loading(0);
				},
				update: function(){
					var page = "' . ($page ?? 0) . '";
					var order = $(this).sortable("serialize")+\'&update=update\'+\'&recordPerPage=' . ($number_per_page ?? 0) . '\'+\'&currentPage=' . ($page ?? 0) . '\';
					$.post(path_ajax_script+"/index.php?mod=cruise&act=ajUpdPosCabin", order, function(html){
						loadListCruiseCabin($cruise_id);
						vietiso_loading(0);
					});
				}
			});
			</script>';
        }
        echo $html;
        die();
    } elseif ($tp == 'F') {
        $listCabinFacilities = $clsCruiseProperty->getAll("is_trash=0 and type='CabinFacilities' order by order_no desc", $clsCruiseProperty->pkey);
        #
        $html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('entertitle') . '"></a>
			<h3>' . ($cruise_cabin_id == 0 ? $core->get_Lang('addcabin') . ' - ' . $clsCruise->getTitle($cruise_id) : $core->get_Lang('edit') . ': <u>' . $clsCruiseCabin->getTitle($cruise_cabin_id) . '</u>') . '</h3>
		</div>';
        $html .= '
		<style>.mceToolbar table{ background:transparent;}</style>
		<form method="post" class="frmform" enctype="multipart/form-data" id="frmCruiseCabin">
			<table border="0" class="form" cellspacing="2" cellpadding="2" style="width:100%">
				<tbody>
					<tr>
						<td width="136px" rowspan="4" style="vertical-align:top;">
							 <div class="photobox_160 image">
								<img src="' . $clsCruiseCabin->getImageUrl($cruise_cabin_id) . '" id="isoman_show_image_room" />
								<input type="hidden" id="isoman_hidden_image_room" name="isoman_url_image" value="' . $clsCruiseCabin->getImageUrl($cruise_cabin_id) . '" />
								<a href="javascript:void()" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image_room" isoman_val="' . $clsCruiseCabin->getImageUrl($cruise_cabin_id) . '" isoman_name="image">
									<i class="iso-edit"></i>
								</a>
								' . ($clsCruiseCabin->getImageUrl($cruise_cabin_id) == '' ? '' : '<a pvalTable="' . $cruise_cabin_id . '" clsTable="CruiseCabin" href="javascript:void()" title="' . $core->get_Lang('delete') . '" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image"> X </a>') . '
							</div>
						</td>
						<td width="15%" class="fieldarea bold"><strong>' . $core->get_Lang('title') . '</strong> <span class="color_r">*</span></td>
						<td class="fieldarea" colspan="5">
							<input type="text" class="text fontLarge full required" placeholder="' . $clsISO->getExName('CruiseCabin') . '" name="title" value="' . $clsCruiseCabin->getTitle($cruise_cabin_id) . '" />
						</td>
					</tr>
					<tr>';
        if (1 == 2) {
            $html .= '<td width="15%" class="fieldarea bold"><u class="color_r">* ' . $core->get_Lang('price') . '</u></td>
						<td class="fieldarea">
							<input type="number" id="priceInput" class="text full" style=" width:100px; margin-right:10px" value="' . $clsCruiseCabin->getOneField('price', $cruise_cabin_id) . '" name="price">' . $clsISO->getRate() . '
						</td>';
        }
        $html .= '<td class="fieldarea"><strong>' . $core->get_Lang('Group size') . '</strong> <span class="color_r">*</span></td>
						<td class="fieldarea" colspan="5">';
        foreach ($lstGroupSize as $key => $val) {
            $html .= '<label class="col-sm-4 col-md-4 inline mb5" style="font-size:0.9em;display:inline-block"><input type="checkbox" ' . ($clsISO->checkContainer($oneItem['listGroupSize'], $val['cruise_property_id']) ? 'checked=checked' : '') . ' name="listGroupSize[]" value="' . $val['cruise_property_id'] . '">' . $clsCruiseProperty->getTitle($val['cruise_property_id']) . '</label>';
        }
        $html .= '</td>
					</tr>
					<tr>
						<td width="8%" class="fieldarea">' . $core->get_Lang('extrabed') . '</td>
						<td class="fieldarea">
							<select name="extra_bed"> 
								<option value="0" ' . ($clsCruiseCabin->getOneField('extra_bed', $cruise_cabin_id) == 0 ? 'selected=selected' : '') . '>' . $core->get_Lang('Yes') . '</option> 
								<option value="1" ' . ($clsCruiseCabin->getOneField('extra_bed', $cruise_cabin_id) == 1 ? 'selected=selected' : '') . '>' . $core->get_Lang('No') . '</option> 
							</select>
						</td>
						<td class="fieldarea">' . $core->get_Lang('cabinsize') . '</td>
						<td class="fieldarea">
							<input type="text" class="text full" style="width:90%" value="' . $clsCruiseCabin->getOneField('cabin_size', $cruise_cabin_id) . '" name="cabin_size" />
						</td>
						<td class="fieldarea">' . $core->get_Lang('bedsize') . '</td>
						<td class="fieldarea">
							<input type="text" class="text full" style="width:90%" value="' . $clsCruiseCabin->getOneField('bed_size', $cruise_cabin_id) . '" name="bed_size" />
						</td>
					</tr>
					';
        if (1 == 2) {
            $html .= '<tr>
						<td width="8%" class="fieldarea">' . $core->get_Lang('numberbed') . '</td>
						<td width="13%" class="fieldarea" style="white-space:nowrap">
							' . $core->get_Lang('single') . '&nbsp;&nbsp;
							<select name="single_bed">
								' . $clsISO->getSelect(0, 10, $clsCruiseCabin->getOneField('single_bed', $cruise_cabin_id)) . '
							</select>
						</td>
						<td width="13%" class="fieldarea" style="white-space:nowrap">
							' . $core->get_Lang('double') . '&nbsp;&nbsp;
							<select name="double_bed">
								' . $clsISO->getSelect(0, 10, $clsCruiseCabin->getOneField('double_bed', $cruise_cabin_id)) . '
							</select>
						</td>
						<td width="14%" class="fieldarea" style="white-space:nowrap">
							' . $core->get_Lang('twin') . '&nbsp;&nbsp;
							<select name="twin_bed">
								' . $clsISO->getSelect(0, 10, $clsCruiseCabin->getOneField('twin_bed', $cruise_cabin_id)) . '
							</select>
						</td>
						<td width="14%" class="fieldarea" style="white-space:nowrap">
							' . $core->get_Lang('triple') . '&nbsp;&nbsp;
							<select name="triple_bed">
								' . $clsISO->getSelect(0, 10, $clsCruiseCabin->getOneField('triple_bed', $cruise_cabin_id)) . '
							</select>
						</td>
						<td width="14%" class="fieldarea" style="white-space:nowrap">
							' . $core->get_Lang('quad') . '&nbsp;&nbsp;
							<select name="quad_bed">
								' . $clsISO->getSelect(0, 10, $clsCruiseCabin->getOneField('quad_bed', $cruise_cabin_id)) . '
							</select>
						</td>
					</tr>';
            $html .= '	<tr> 
						<td class="fieldarea bold" style="vertical-align:top;padding-top:10px"><u class="color_r">' . $core->get_Lang('intro') . '</u></td> 
						<td class="fieldarea" colspan="6">
							<textarea id="textarea_content_editor' . time() . '" rows="2" class="textarea_content_editor" style="width:98%">' . $clsCruiseCabin->getIntro($cruise_cabin_id) . '</textarea>
						</td>  
					</tr>';
        }
        if (is_array($listCabinFacilities) && count($listCabinFacilities) > 0) {
            $html .= '
					<tr> 
						<td class="fieldarea bold" style="vertical-align:top;padding-top:10px"><u class="color_r">' . $core->get_Lang('cabinfacilities') . '</u></td> 
						<td class="fieldarea" colspan="6">
							<div class="checkall" style="margin-bottom:10px;float:left">' . $core->get_Lang('Check/Uncheck All') . ' <input type="checkbox" rel="cabin_fa" id="all_check"></div>
							<div class="clearifx"></div>
							<div class="wrap">';
            foreach ($listCabinFacilities as $k => $v) {
                $html .= '<label title="' . $clsCruiseProperty->getTitle($v[$clsCruiseProperty->pkey]) . '" class="lblcheck ' . ($clsISO->checkContainer($clsCruiseCabin->getOneField('list_cabin_facilities', $cruise_cabin_id), $v[$clsCruiseProperty->pkey]) ? 'lblchecked' : '') . '" style="width:24%"><input class="cabin_fa" type="checkbox" ' . ($clsISO->checkContainer($clsCruiseCabin->getOneField('list_cabin_facilities', $cruise_cabin_id), $v[$clsCruiseProperty->pkey]) ? 'checked="checked"' : '') . ' name="list_cabin_facilities[]" value="' . $v[$clsCruiseProperty->pkey] . '" />' . $clsISO->myTruncate($clsCruiseProperty->getTitle($v[$clsCruiseProperty->pkey]), 20) . '</label>';
            }
            $html .= '</div></td></tr>';
        }
        $html .= '</tbody>
			</table>
			<div class="modal-footer" style="text-align:center"> 
				<button type="submit" cruise_cabin_id="' . $cruise_cabin_id . '" cruise_id="' . $cruise_id . '" class="btn btn-primary clickToSubmitCruiseCabin"><i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span></button> 
				<button type="reset" class="btn btn-warning close_pop"> <i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span> </button> 
			</div>
		</form>';
        #
        echo ($html);
        die();
    } elseif ($tp == 'S') {
        $titlePost = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
        $slugPost = $core->replaceSpace($titlePost);
        $imagePost = isset($_POST['image']) ? addslashes($_POST['image']) : '';
        $introPost = isset($_POST['intro']) ? addslashes($_POST['intro']) : '';
        $cabin_size = isset($_POST['cabin_size']) ? addslashes($_POST['cabin_size']) : '';
        $bed_size = isset($_POST['bed_size']) ? addslashes($_POST['bed_size']) : '';
        $price = $clsISO->processSmartNumber($_POST['price']);
        $max_adult = isset($_POST['max_adult']) ? intval($_POST['max_adult']) : 0;
        $max_child = isset($_POST['max_child']) ? intval($_POST['max_child']) : 0;
        $list_cabin_facilities = isset($_POST['list_cabin_facilities']) ? $clsISO->makeSlashListFromArray($_POST['list_cabin_facilities']) : '';
        $extra_bed = isset($_POST['extra_bed']) ? $_POST['extra_bed'] : '';
        $single_bed = isset($_POST['single_bed']) ? intval($_POST['single_bed']) : 0;
        $double_bed = isset($_POST['double_bed']) ? intval($_POST['double_bed']) : 0;
        $twin_bed = isset($_POST['twin_bed']) ? intval($_POST['twin_bed']) : 0;
        $triple_bed = isset($_POST['triple_bed']) ? intval($_POST['triple_bed']) : 0;
        $quad_bed = isset($_POST['quad_bed']) ? intval($_POST['quad_bed']) : 0;
        #
        //print_r($cruise_cabin_id); die();
        if (intval($cruise_cabin_id) == 0) {
            if ($clsCruiseCabin->getAll("slug='$slugPost' and cruise_id = '$cruise_id'") != '') {
                echo ('_EXIST');
                die();
            } else {
                #
                $f = "title,slug,intro,cabin_size,bed_size,list_cabin_facilities,reg_date,upd_date,user_id,user_id_update";
                $f .= ",order_no,cruise_id,$clsCruiseCabin->pkey,image,extra_bed,single_bed,double_bed,twin_bed,triple_bed,quad_bed,price,max_adult,max_child";
                $v = "'$titlePost','$slugPost','$introPost','" . $cabin_size . "','" . $bed_size . "','" . $list_cabin_facilities . "'";
                $v .= ",'" . time() . "','" . time() . "','$user_id','$user_id','" . $clsCruiseCabin->getMaxOrderNo() . "','$cruise_id','" . $clsCruiseCabin->getMaxID() . "','$imagePost','" . $extra_bed . "','" . $single_bed . "','" . $double_bed . "','" . $twin_bed . "','" . $triple_bed . "','" . $quad_bed . "','" . $price . "','" . $max_adult . "','" . $max_child . "'";

                #
                if ($clsCruiseCabin->insertOne($f, $v)) {
                    unset($_COOKIE['list_id']);
                    echo ('_IN_SUCCESS');
                    die();
                } else {
                    echo ('_ERROR');
                    die();
                }
            }
        } else {
            if ($clsCruiseCabin->getAll("slug='$slugPost' and cruise_id = '$cruise_id' and cruise_cabin_id <> '$cruise_cabin_id'") != '') {
                echo ('_EXIST');
                die();
            } else {
                $v = "title='$titlePost',slug='$slugPost',intro='$introPost',cabin_size='$cabin_size',bed_size='$bed_size'";
                $v .= ",list_cabin_facilities='$list_cabin_facilities',upd_date='" . time() . "',user_id_update='$user_id',image='$imagePost',extra_bed='$extra_bed',single_bed='$single_bed',double_bed='$double_bed',twin_bed='$twin_bed',triple_bed='$triple_bed',quad_bed='$quad_bed',price='" . $price . "',max_adult='" . $max_adult . "',max_child='" . $max_child . "'";
                #
                if ($clsCruiseCabin->updateOne($cruise_cabin_id, $v)) {
                    unset($_COOKIE['list_id']);
                    echo ('_UPDATE_SUCCESS');
                    die();
                } else {
                    echo ('_ERROR');
                    die();
                }
            }
        }
    } elseif ($tp == 'M') {
        $one = $clsCruiseCabin->getOne($cruise_cabin_id);
        $order_no = $one['order_no'];
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';

        $cond = "is_trash=0 and cruise_id = '$cruise_id'";

        if ($direct == 'moveup') {
            $lst = $clsCruiseCabin->getAll($cond . " and order_no > $order_no order by order_no ASC limit 0,1");
            $clsCruiseCabin->updateOne($cruise_cabin_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruiseCabin->updateOne($lst[0][$clsCruiseCabin->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsCruiseCabin->getAll($cond . " and order_no < $order_no order by order_no DESC limit 0,1");
            $clsCruiseCabin->updateOne($cruise_cabin_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruiseCabin->updateOne($lst[0][$clsCruiseCabin->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsCruiseCabin->getAll($cond . " and order_no > $order_no order by order_no DESC");
            $clsCruiseCabin->updateOne($cruise_cabin_id, "order_no='" . $lst[0]['order_no'] . "'");
            unset($lst);
            $lst = $clsCruiseCabin->getAll($cond . " and cruise_cabin_id<>'$cruise_cabin_id' and order_no > '$order_no' order by order_no ASC");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsCruiseCabin->updateOne($lst[$i][$clsCruiseCabin->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
                }
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsCruiseCabin->getAll($cond . " and order_no < $order_no order by order_no ASC");
            $clsCruiseCabin->updateOne($cruise_cabin_id, "order_no='" . $lst[0]['order_no'] . "'");
            unset($lst);
            $lst = $clsCruiseCabin->getAll($cond . " and cruise_cabin_id<>'$cruise_cabin_id' and order_no < '$order_no' order by order_no DESC");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsCruiseCabin->updateOne($lst[$i][$clsCruiseCabin->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
                }
            }
        }
        echo (1);
        die();
    } elseif ($tp == 'D') {
        $clsCruiseCabin->deleteOne($cruise_cabin_id);
        echo (1);
        die();
    }
}

function default_ajUpdPosCabin()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCruiseCabin = new CruiseCabin();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsCruiseCabin->updateOne($val, "order_no='" . $key . "'");
    }
}

/*========= LOAD CRUISE GALLERY -------*/
function default_ajInitSysCruiseGallery()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    #
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    #
    $html = '
	<div class="wrap">
		<div class="group_button fl">
			<form method="post" action="" accept="application/pdf" id="aj-upload-form" enctype="multipart/form-data">
				<input style="display:none" type="file" multiple="" name="image[]" id="ajAttachFile" />
				<a style="display:none" id="ajSysPhotosGallery" table_id="' . $table_id . '" class="iso-button-primary fl mr10" >
					<i class="icon-random"></i>&nbsp;' . $core->get_Lang('synchronizeposition') . '
				</a>
				<a table_id="' . $table_id . '" isoman_multiple="1" class="iso-button-standard ajOpenDialog fl" clsTable="CruiseImage" isoman_for_id="image_val" isoman_name="image">
					<i class="icon-plus-sign"></i>&nbsp;' . $core->get_Lang('addimages') . '
				</a>
				<span style="white-space:nowrap;float:left;margin-left:10px;padding-top:6px;">' . $core->get_Lang('autoaddimage') . '</span>
				<input type="hidden" value="' . $table_id . '" name="table_id" id="Hid_TableID"/>
				<input type="hidden" value="CruiseImage" name="clsTable" id="clsTable"/>
			</form>
		</div>
	</div>';
    $html .= '
	<div class="clearfix"><br /></div>
	<div class="hastable">
		<table class="tbl-grid" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<td class="gridheader"><strong>' . $core->get_Lang('index') . '</strong></td>
					<td class="gridheader"><strong>' . $core->get_Lang('images') . '</strong></td>
					<td class="gridheader" style="text-align:left;"><strong>' . $core->get_Lang('nameimages') . '</strong></td>
					<td class="gridheader hiden767" style="width:12%"><strong>' . $core->get_Lang('update') . '</strong></td>
					<td class="gridheader" style="width:70px;"><strong>' . $core->get_Lang('func') . '</strong></td>
				</tr>
			</thead>
			<tbody id="preview"></tbody>
		</table>
		<div class="clearfix" style="height:5px"></div>
		<div class="pagination_box">
			<div class="wrap" id="gallery_paginate">
			<!-- Ajax Loading pagination -->
			</div>
		</div>
	</div>';

    // End code here !!
    $html .= '
	<script type="text/javascript">
		$(function(){
			checkSysPosition();
			$(document).on(\'click\', \'.ajdeletePhotosGallery\', function(ev){
				var $_this = $(this);
				if(confirm(confirm_delete)){
					$.ajax({
						type: "POST",
						url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGallery",
						data: {\'tp\':\'D\', \'cruise_image_id\': $_this.attr(\'data\')},
						dataType: "html",
						success: function(html){
							var $table_id = $(\'input[name=table_id]\').val();
							loadTableGallery($table_id,\'\');
							checkSysPosition();
						}
					});
				}
			});
			$(document).on(\'click\', \'.ajeditPhotosGallery\', function(ev){
				var $_this = $(this);
				var $cruise_image_id = $_this.attr(\'data\');
				var $table_id = $_this.attr(\'table_id\');
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGallery",
					data: {\'tp\':\'C\',\'cruise_image_id\' : $cruise_image_id,\'table_id\' : $table_id},
					dataType: "html",
					success: function(html){
						makepopup(\'270px\',\'auto\',html,\'box_EditPhotosGallery\');
					}
				});
				return false;
			});
			$(document).on(\'click\', \'.ajmovePhotosGallery\', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type:\'POST\',
					url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGallery",
					data: {
						\'cruise_image_id\' : $_this.attr(\'data\'),
						\'direct\' : $_this.attr(\'direct\'),
						\'table_id\' : $(\'#Hid_TableID\').val(),
						\'tp\' : \'M\'
					},
					success: function(html){
						vietiso_loading(0);
						var $table_id = $_this.attr(\'table_id\');
						var $page = $(\'#Hid_CurrentPage\').val();
						loadTableGallery($table_id,\'\',$page,10);
					}
				});
				return false;
			});
			$(document).on(\'click\', \'.paginate_button\', function(ev){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				var $keyword = \'\';
				loadTableGallery($table_id,$keyword,$_this.attr(\'page\'),10);
				return false;
			});
			$(document).on(\'click\', \'#ajSysPhotosGallery\', function(ev){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				vietiso_loading(1);
				$.ajax({
					type:\'POST\',
					url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGallery",
					data:{"table_id" : $table_id,\'tp\':\'SYS\'},
					success: function(html){
						vietiso_loading(0);
						var $page = $(\'#Hid_CurrentPage\').val();
						loadTableGallery($table_id,\'\',$page,10);
					}
				});	
				return false;
			});
		});
		
		function checkSysPosition(){
			var table_id = $(\'input[name=table_id]\').val();
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGallery",
				data: {\'table_id\':table_id,\'tp\':\'TOTAL\'},
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					var htm = parseInt(html);
					if(htm==0){
						$(\'#ajSysPhotosGallery\').hide();
					}else{
						$(\'#ajSysPhotosGallery\').show();
					}
				}
			});
		}
	</script>';
    $html .= '</div>';
    echo $html;
    die();
}

function default_ajSysPhotosGallery()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn;
    #
    $clsPagination = new Pagination();
    $clsCruiseImage = new CruiseImage();
    $pkeyTable = $clsCruiseImage->pkey;

    $cruise_image_id = isset($_POST['cruise_image_id']) ? intval($_POST['cruise_image_id']) : 0;
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';

    // Load List
    if ($tp == 'L') {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $number_per_page = isset($_POST['number_per_page']) ? intval($_POST['number_per_page']) : 10;
        //echo $number_per_page; die();
        #
        $cond = "is_trash=0 and table_id='$table_id'";
        if (trim($keyword) != '' && $keyword != '0') {
            $slug = $core->replaceSpace($keyword);
            $cond .= " and (title like '%$keyword%' or slug like '%$slug%')";
        }
        #
        $totalRecord = $clsCruiseImage->getAll($cond) ? count($clsCruiseImage->getAll($cond)) : 0;
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no asc";
        $limit = " LIMIT $offset,$number_per_page";

        $lstItem = $clsCruiseImage->getAll($cond . $order_by . $limit);
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $cruise_image_id = $lstItem[$i][$clsCruiseImage->pkey];
                #
                $html .= '<tr style="cursor:move" id="order_' . $cruise_image_id . '" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index">' . ($offset + $i + 1) . '</td>';
                $html .= '<td width="85px"><a href="javascript:void();" data="' . $cruise_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><img src="' . $lstItem[$i]['image'] . '" width="75" height="50" /></a></td>';
                $html .= '<td>
				<input class="editTitleImage full-width" data="' . $cruise_image_id . '" table_id="' . $table_id . '" value="' . $clsCruiseImage->getTitle($cruise_image_id) . '" style="line-height:28px; font-size:12px; padding:0 10px; max-width:200px" />
				<a style="display:none" href="javascript:void();" data="' . $cruise_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><strong>' . $clsCruiseImage->getTitle($cruise_image_id) . '</strong></a></td>';
                $html .= '<td class="hiden767" style="text-align:right;color:#c00000">' . date('d-m-Y h:i', $lstItem[$i]['reg_date']) . '</td>';
                $html .= '
				<td style="vertical-align:middle; width:70px">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button> 
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a href="javascript:void(0);" data="' . $cruise_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><i class="icon-edit"></i> ' . $core->get_Lang('edit') . '</a></li>
							<li><a href="javascript:void(0);" table_id="' . $table_id . '" data="' . $cruise_image_id . '" title="' . $core->get_Lang('delete') . '" class="ajdeletePhotosGallery"><i class="icon-remove"></i> ' . $core->get_Lang('delete') . '</a></li>
						</ul>
					</div>
				</td>';
                $html .= '</tr>';
            }
            $html .= '
			<script type="text/javascript">
				$("#preview").sortable({
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
						var order = $(this).sortable("serialize")+\'&update=update\'+\'&recordPerPage=' . $number_per_page . '\'+\'&currentPage=' . $page . '\';
						$.post(path_ajax_script+"/index.php?mod=cruise&act=ajUpdPosSortCruiseGallery", order, function(html){
							loadTableGallery($cruise_id, \'\', page, 10);
							vietiso_loading(0);
						});
					}
				});
				$(".editTitleImage").live("change", function() {
					var $_this = $(this);
					$.ajax({
						type: "POST",
						url: path_ajax_script + "/?mod=" + mod + "&act=ajSysPhotosGallery",
						data: {
							"table_id": $_this.attr("table_id"),
							"cruise_image_id": $_this.attr("data"),
							"title": $_this.val(),
							"tp": "S"
						},
						dataType: "html",
						success: function(html) {
						alertify.success("Success");
						vietiso_loading(1);
						vietiso_loading(0);
			
						}
					});
				});
			</script>';
        } else {
            $html = '
			<tr style="background:#ffda0b;">
				<td colspan="9" style="text-align:center;text-decoration:blink">' . $core->get_Lang('nodata') . '</td>
		   </tr>';
        }
        echo $html . '$$$' . $pageview . '$$$' . $page;
        die();
    } // Delete
    else if ($tp == 'D') {
        $clsCruiseImage->deleteOne($cruise_image_id);
        echo (1);
        die();
    } // Quick Create
    else if ($tp == 'Q') {
        $fx = "table_id,order_no,reg_date";
        $vx = "'$table_id','" . $clsCruiseImage->getMaxOrderNoByTable($table_id) . "','" . time() . "'";
        $clsCruiseImage->insertOne($fx, $vx);
        echo (1);
        die();
    } // Edit Upload Form
    else if ($tp == 'C') {
        $HTML .= '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . $core->get_Lang('Add/Edit File') . '</h3>
		</div>';
        $HTML .= '
		<form method="post" action="" method="post" id="aj-update-form" enctype="multipart/form-data">
		<table cellpadding="2" cellspacing="2" width="100%" class="form">
			<tr>
				<td class="fieldarea">
					<input type="text" name="title" class="text full required" style="width:96%" value="' . $clsCruiseImage->getTitle($cruise_image_id) . '">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						<img src="' . $clsCruiseImage->getOneField('image', $cruise_image_id) . '" id="isoman_show_image_val" />
						<input type="hidden" id="isoman_hidden_image_val" name="isoman_url_image" value="' . $clsCruiseImage->getOneField('image', $cruise_image_id) . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" clsTable="CruiseImage" isoman_for_id="image_val" isoman_val="' . $clsCruiseImage->getOneField('image', $cruise_image_id) . '" isoman_name="image">
							<i class="iso-edit"></i>
						</a>
					</div>
				</td>
			</tr>
		</table>
		<div class="clear"><br /></div>';
        $HTML .= '<div class="modal-footer wrap">
					<a href="javascript:void(0);" class="iso-button-standard submitClick fr clickUpdateCruiseImage" cruise_image_id="' . $cruise_image_id . '" table_id="' . $table_id . '" ><img align="absmiddle" src="' . URL_IMAGES . '/v2/check.png"> ' . $core->get_Lang('save') . '</a>
			   </div>';
        $HTML .= '</form>';
        $HTML .= '
		<script type="text/javascript">
			$(function(){
				$(document).on(\'click\', \'.clickUpdateCruiseImage\', function(){
					var $_this = $(this);
					var $_form = $_this.closest(\'.frmPop\');
					var $title = $_form.find(\'input[name=title]\');
					if($.trim($title.val())==\'\'){
						$title.focus().addClass(\'error\');
						alertify.error(field_is_required);
						return false;
					};
					$(\'#aj-update-form\').ajaxSubmit({
						type:\'POST\',
						url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGallery",
						data : {\'tp\':\'S\',\'cruise_image_id\': $_this.attr(\'cruise_image_id\')},
						success: function(html){
							var htm = parseInt(html);
							if(htm==1){
								$(\'#aj-upload-form\').resetForm();
								var $table_id = $_this.attr(\'table_id\');
								var $page = $(\'#Hid_CurrentPage\').val();
								loadTableGallery($table_id, \'\',$page,10);
								$_form.find(\'.close_pop\').trigger(\'click\');
							}
						}
					});
					return false;
				});
			})
		</script>';
        echo $HTML;
        die();
    } // Save
    else if ($tp == 'S') {
        $titlePost = addslashes($_POST['title']);
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            $set = "title='" . $titlePost . "',slug='" . $core->replaceSpace($titlePost) . "',reg_date='" . time() . "'";
            if (!empty($_POST['isoman_url_image'])) {
                $set .= ",image='" . addslashes($_POST['isoman_url_image']) . "'";
            }
            if ($clsCruiseImage->updateOne($cruise_image_id, $set)) {
                echo (1);
                die();
            } else {
                echo (0);
                die();
            }
        } else {
            echo (0);
            die();
        }
    } else if ($tp == 'M') {
        #
        $one = $clsCruiseImage->getOne($cruise_image_id);
        $order_no = $one['order_no'];
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
        #
        $cond = 'table_id=' . $table_id;
        #
        if ($direct == 'moveup') {
            $lst = $clsCruiseImage->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsCruiseImage->updateOne($cruise_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruiseImage->updateOne($lst[0][$clsCruiseImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsCruiseImage->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsCruiseImage->updateOne($cruise_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruiseImage->updateOne($lst[0][$clsCruiseImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsCruiseImage->getAll($cond . " and order_no > $order_no order by order_no asc");
            $clsCruiseImage->updateOne($cruise_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsCruiseImage->getAll($cond . " and cruise_image_id <> '$cruise_image_id' and order_no > $order_no order by order_no asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsCruiseImage->updateOne($lstItem[$i][$clsCruiseImage->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsCruiseImage->getAll($cond . " and order_no < $order_no order by order_no desc");
            $clsCruiseImage->updateOne($cruise_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsCruiseImage->getAll($cond . " and cruise_image_id <> '$cruise_image_id' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsCruiseImage->updateOne($lstItem[$i][$clsCruiseImage->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
            }
        }
        echo (1);
        die();
    } else if ($tp == 'TOTAL') {
        echo $clsCruiseImage->getAll("is_trash=0 and table_id='$table_id'") ? count($clsCruiseImage->getAll("is_trash=0 and table_id='$table_id'")) : 0;
        die();
    } else if ($tp == 'SYS') {
        $LISTALL = $clsCruiseImage->getAll("is_trash=0 and table_id='$table_id' order by cruise_image_id asc");
        if (!empty($LISTALL)) {
            for ($i = 0; $i < count($LISTALL); $i++) {
                $clsCruiseImage->updateOne($LISTALL[$i][$clsCruiseImage->pkey], "order_no='" . ($i + 1) . "'");
            }
            unset($LISTALL);
        }
        echo (1);
        die();
    }
    echo (1);
    die();
}

function default_ajUpdPosSortCruiseGallery()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCruiseImage = new CruiseImage();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsCruiseImage->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_ajUpdPosSortCruiseVideo()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCruiseVideo = new CruiseVideo();
    $order = $_POST['order'];
    /*$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];*/
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        /*		$key = (($currentPage-1)*$recordPerPage + $key + 1);*/
        $key = $key + 1;
        $clsCruiseVideo->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_edit_cruise_video()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $pUrl = '';
    #
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $return = isset($_GET['return']) ? $_GET['return'] : '';
    $cruise_id = $_GET['cruise_id'];
    $assign_list["cruise_id"] = $cruise_id;

    if (isset($cruise_id) && intval($cruise_id) != 0) {
        $pUrl .= "&cruise_id=" . $cruise_id;
    } else {
        header('location: ' . PCMS_URL);
    }
    #
    $classTable = "CruiseVideo";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));

    $assign_list['pvalTable'] = $pvalTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;


    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;

    #- Init Price
    if (intval($pvalTable) > 0) {
        //$clsClassTable->initCruiseTable($pvalTable);
    }

    #- End Init Price
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
            $set .= ",slug='" . $core->replaceSpace($_POST['iso-title']) . "'";

            if ($clsClassTable->updateOne($pvalTable, $set)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_cruise_video&cruise_video_id=' . $core->encryptID($pvalTable) . $pUrl . '&message=updateSuccess');
                } else {
                    header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/video/video&message=insertSuccess");
                }
            } else {
                header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/video/video&message=updateFailed");
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

            $max_id = $clsClassTable->getMaxId();
            $max_order = $clsClassTable->getMaxOrder();

            $field .= ",user_id,reg_date,table_id,slug,$clsClassTable->pkey,order_no";
            $value .= ",'$user_id','" . time() . "','" . $cruise_id . "'";
            $value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "','" . $max_id . "','1'";

            $listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
            }

            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=cruise&act=edit_cruise_video&cruise_video_id=' . $core->encryptID($max_id) . $pUrl . '&message=insertSuccess');
                } else {
                    header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/video/video&message=updateSuccess");
                }
            } else {
                header('location:' . PCMS_URL . "/cruise/insert/{$cruise_id}/video/video&message=insertFailed");
            }
        }
    }
}

function default_move_cruise_video()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $classTable = "CruiseVideo";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $cruise_video_id = isset($_GET[$cruise_video_id]) ? $_GET[$cruise_video_id] : "";
    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : "";
    $direct = isset($_GET['direct']) ? $_GET['direct'] : "";
    $return = isset($_GET['return']) ? $_GET['return'] : '';
    #
    if ($cruise_video_id == "") {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
    }
    #
    $oneItem = $clsClassTable->getOne($cruise_video_id);
    $order_no = $oneItem['order_no'];
    $table_id = $oneItem['table_id'];
    #
    $where = "is_trash=0 and table_id='$cruise_id'";

    if ($direct == 'movedown') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
        $clsClassTable->updateOne($cruise_video_id, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'moveup') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
        $clsClassTable->updateOne($cruise_video_id, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movebottom') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no asc");
        $clsClassTable->updateOne($cruise_video_id, "order_no='" . $lst[0]['order_no'] . "'");
        #
        $lst = $clsClassTable->getAll($where . " and $cruise_video_id <> '$cruise_video_id' order by order_no asc");
        for ($i = 0; $i < count($lst); $i++) {
            $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
        }
    }
    if ($direct == 'movetop') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no desc");
        $clsClassTable->updateOne($cruise_video_id, "order_no='" . $lst[0]['order_no'] . "'");
        #
        $lst = $clsClassTable->getAll($where . " and $cruise_video_id <> '$cruise_video_id' order by order_no asc");
        for ($i = 0; $i < count($lstItem); $i++) {
            $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
        }
    }

    header('location: ' . PCMS_URL . '/?mod=cruise&act=edit&cruise_id=' . $core->encryptID($cruise_id) . '&message=PositionSuccess#isotab5');
}

/*========= LOAD CRUISE GALLERY -------*/
function default_ajInitSysCruiseGalleryMap()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    #
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    #
    $html = '
	<div class="wrap">
		<div class="group_button fl">
			<form method="post" action="" accept="application/pdf" id="aj-upload-form" enctype="multipart/form-data">
				<input style="display:none" type="file" multiple="" name="image[]" id="ajAttachFile" />
				<a style="display:none" id="ajSysPhotosGalleryMap" table_id="' . $table_id . '" class="iso-button-primary fl mr10" >
					<i class="icon-random"></i>&nbsp;' . $core->get_Lang('synchronizeposition') . '
				</a>
				<a table_id="' . $table_id . '" isoman_multiple="1" class="iso-button-standard ajOpenDialog fl" clsTable="CruiseMapImage" isoman_for_id="image_val" isoman_name="image">
					<i class="icon-plus-sign"></i>&nbsp;' . $core->get_Lang('addimages') . '
				</a>
				<span style="white-space:nowrap;float:left;margin-left:10px;padding-top:6px;">' . $core->get_Lang('autoaddimage') . '</span>
				<input type="hidden" value="' . $table_id . '" name="table_id" id="Hid_TableID"/>
			</form>
		</div>
	</div>';
    $html .= '
	<div class="clearfix"><br /></div>
	<div class="hastable">
		<table class="tbl-grid" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<td class="gridheader"><strong>' . $core->get_Lang('index') . '</strong></td>
					<td class="gridheader"><strong>' . $core->get_Lang('images') . '</strong></td>
					<td class="gridheader" style="text-align:left;"><strong>' . $core->get_Lang('nameimages') . '</strong></td>
					<td class="gridheader" style="width:12%"><strong>' . $core->get_Lang('update') . '</strong></td>
					<td class="gridheader" colspan="4" style="width:3%"><strong>' . $core->get_Lang('move') . '</strong></td>
					<td class="gridheader" style="width:75px;"><strong>' . $core->get_Lang('func') . '</strong></td>
				</tr>
			</thead>
			<tbody id="previewmap"></tbody>
		</table>
		<div class="clearfix" style="height:5px"></div>
		<div class="pagination_box">
			<div class="wrap" id="gallery_paginate_map">
			<!-- Ajax Loading pagination -->
			</div>
		</div>
	</div>';

    // End code here !!
    $html .= '
	<script type="text/javascript">
		$(function(){
			checkSysPositionMap();
			$(document).on(\'click\', \'.ajdeletePhotosGalleryMap\', function(ev){
				var $_this = $(this);
				if(confirm(confirm_delete)){
					$.ajax({
						type: "POST",
						url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGalleryMap",
						data: {\'tp\':\'D\', \'cruise_map_image_id\': $_this.attr(\'data\')},
						dataType: "html",
						success: function(html){
							var $table_id = $(\'input[name=table_id]\').val();
							loadTableGalleryMap($table_id,\'\');
							checkSysPosition();
						}
					});
				}
			});
			$(document).on(\'click\', \'.ajeditPhotosGalleryMap\', function(ev){
				var $_this = $(this);
				var $cruise_map_image_id = $_this.attr(\'data\');
				var $table_id = $_this.attr(\'table_id\');
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGalleryMap",
					data: {\'tp\':\'C\',\'cruise_map_image_id\' : $cruise_map_image_id,\'table_id\' : $table_id},
					dataType: "html",
					success: function(html){
						console.log(html);
						makepopup(\'270px\',\'auto\',html,\'box_EditPhotosGallery\');
					}
				});
				return false;
			});
			$(document).on(\'click\', \'.ajmovePhotosGalleryMap\', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type:\'POST\',
					url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGalleryMap",
					data: {
						\'cruise_map_image_id\' : $_this.attr(\'data\'),
						\'direct\' : $_this.attr(\'direct\'),
						\'table_id\' : $(\'#Hid_TableID\').val(),
						\'tp\' : \'M\'
					},
					success: function(html){
						vietiso_loading(0);
						var $table_id = $_this.attr(\'table_id\');
						var $page = $(\'#Hid_CurrentPage\').val();
						loadTableGalleryMap($table_id,\'\',$page,10);
					}
				});
				return false;
			});
			$(document).on(\'click\', \'.paginate_button\', function(ev){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				var $keyword = \'\';
				loadTableGalleryMap($table_id,$keyword,$_this.attr(\'page\'),10);
				return false;
			});
			$(document).on(\'click\', \'#ajSysPhotosGalleryMap\', function(ev){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				vietiso_loading(1);
				$.ajax({
					type:\'POST\',
					url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGalleryMap",
					data:{"table_id" : $table_id,\'tp\':\'SYS\'},
					success: function(html){
						vietiso_loading(0);
						var $page = $(\'#Hid_CurrentPage\').val();
						loadTableGalleryMap($table_id,\'\',$page,10);
					}
				});	
				return false;
			});
		});
		
		function checkSysPositionMap(){
			var table_id = $(\'input[name=table_id]\').val();
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGalleryMap",
				data: {\'table_id\':table_id,\'tp\':\'TOTAL\'},
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					var htm = parseInt(html);
					if(htm==0){
						$(\'#ajSysPhotosGalleryMap\').hide();
					}else{
						$(\'#ajSysPhotosGalleryMap\').show();
					}
				}
			});
		}
	</script>';
    $html .= '</div>';
    echo $html;
    die();
}

function default_ajSysPhotosGalleryMap()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn;
    #
    $clsPagination = new Pagination();
    $clsCruiseMapImage = new CruiseMapImage();
    $pkeyTable = $clsCruiseMapImage->pkey;

    $cruise_map_image_id = isset($_POST['cruise_map_image_id']) ? intval($_POST['cruise_map_image_id']) : 0;
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';

    // Load List
    if ($tp == 'L') {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $number_per_page = isset($_POST['number_per_page']) ? intval($_POST['number_per_page']) : 10;
        //echo $number_per_page; die();
        #
        $cond = "is_trash=0 and table_id='$table_id'";
        if (trim($keyword) != '' && $keyword != '0') {
            $slug = $core->replaceSpace($keyword);
            $cond .= " and (title like '%$keyword%' or slug like '%$slug%')";
        }
        #
        $totalRecord = $clsCruiseMapImage->getAll($cond) ? count($clsCruiseMapImage->getAll($cond)) : 0;
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no DESC";
        $limit = " LIMIT $offset,$number_per_page";

        $lstItem = $clsCruiseMapImage->getAll($cond . $order_by . $limit);
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $cruise_map_image_id = $lstItem[$i][$clsCruiseMapImage->pkey];
                #
                $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index">' . ($i + 1) . '</td>';
                $html .= '<td width="60px"><img src="' . $lstItem[$i]['image'] . '" width="60" height="40" /></td>';
                $html .= '<td><a href="javascript:void();" data="' . $cruise_map_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGalleryMap"><strong>' . $clsCruiseMapImage->getTitle($cruise_map_image_id) . '</strong></a></td>';
                $html .= '<td style="text-align:right;color:#c00000">' . date('d-m-Y h:i', $lstItem[$i]['reg_date']) . '</td>';
                $html .= '<td style="text-align:center">' . ($i == 0 ? '' : '<a href="javascript:void();" data="' . $cruise_map_image_id . '" class="ajmovePhotosGalleryMap" direct="movetop" title="' . $core->get_Lang('movetop') . '" data="' . $cruise_map_image_id . '" table_id="' . $table_id . '"><i class="icon-circle-arrow-up"></i></a>') . '</td>';
                $html .= '<td style="text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a href="javascript:void();" data="' . $cruise_map_image_id . '" class="ajmovePhotosGalleryMap" direct="movebottom" title="' . $core->get_Lang('movebottom') . '" table_id="' . $table_id . '"><i class="icon-circle-arrow-down"></i></a>') . '</td>';
                $html .= '<td style="text-align:center">' . ($i == 0 ? '' : '<a href="javascript:void();" data="' . $cruise_map_image_id . '" class="ajmovePhotosGalleryMap" direct="moveup" title="' . $core->get_Lang('moveup') . '" table_id="' . $table_id . '"><i class="icon-arrow-up"></i></a>') . '</td>';
                $html .= '<td style="text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a href="javascript:void();" class="ajmovePhotosGalleryMap" direct="movedown" title="' . $core->get_Lang('movedown') . '" data="' . $cruise_map_image_id . '" table_id="' . $table_id . '"><i class="icon-arrow-down"></i></a>') . '</td>';
                $html .= '
				<td style="vertical-align:middle; width:6%;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button> 
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a href="javascript:void(0);" data="' . $cruise_map_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGalleryMap"><i class="icon-edit"></i> ' . $core->get_Lang('edit') . '</a></li>
							<li><a href="javascript:void(0);" table_id="' . $table_id . '" data="' . $cruise_map_image_id . '" title="' . $core->get_Lang('delete') . '" class="ajdeletePhotosGalleryMap"><i class="icon-remove"></i> ' . $core->get_Lang('delete') . '</a></li>
						</ul>
					</div>
				</td>';
                $html .= '</tr>';
            }
        } else {
            $html = '
			<tr style="background:#ffda0b;">
				<td colspan="9" style="text-align:center;text-decoration:blink">' . $core->get_Lang('nodata') . '</td>
		   </tr>';
        }
        echo $html . '$$$' . $pageview . '$$$' . $page;
        die();
    } // Delete
    else if ($tp == 'D') {
        $clsCruiseMapImage->deleteOne($cruise_map_image_id);
        echo (1);
        die();
    } // Quick Create
    else if ($tp == 'Q') {
        $fx = "table_id,order_no,reg_date";
        $vx = "'$table_id','" . $clsCruiseMapImage->getMaxOrderNoByTable($table_id) . "','" . time() . "'";
        $clsCruiseMapImage->insertOne($fx, $vx);
        echo (1);
        die();
    } // Edit Upload Form
    else if ($tp == 'C') {
        $HTML .= '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . $core->get_Lang('Add/Edit File') . '</h3>
		</div>';
        $HTML .= '
		<form method="post" action="" method="post" id="aj-update-form" enctype="multipart/form-data">
		<table cellpadding="2" cellspacing="2" width="100%" class="form">
			<tr>
				<td class="fieldarea">
					<input type="text" name="title" class="text full required" style="width:96%" value="' . $clsCruiseMapImage->getTitle($cruise_map_image_id) . '">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						' . ($clsCruiseMapImage->getOneField('image', $cruise_map_image_id) == '' ? '' : '<a pvalTable="' . $cruise_map_image_id . '" clsTable="CruiseMapImage" href="javascript:void()" title="' . $core->get_Lang('delete') . '" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image"> X </a>') . '
								
						<img src="' . $clsCruiseMapImage->getOneField('image', $cruise_map_image_id) . '" id="isoman_show_image_map" />
						<input type="hidden" id="isoman_hidden_image_map" name="isoman_url_image" value="' . $clsCruiseMapImage->getOneField('image', $cruise_map_image_id) . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" clsTable="CruiseMapImage" isoman_for_id="image_map" isoman_val="' . $clsCruiseMapImage->getOneField('image', $cruise_map_image_id) . '" isoman_name="image">
							<i class="iso-edit"></i>
						</a>
					</div>
				</td>
			</tr>
		</table>
		<div class="clear"><br /></div>';
        $HTML .= '<div class="modal-footer wrap">
					<a href="javascript:void(0);" class="iso-button-standard submitClick fr clickUpdateCruiseMapImage" cruise_map_image_id="' . $cruise_map_image_id . '" table_id="' . $table_id . '" ><img align="absmiddle" src="' . URL_IMAGES . '/v2/check.png"> ' . $core->get_Lang('save') . '</a>
			   </div>';
        $HTML .= '</form>';
        $HTML .= '
		<script type="text/javascript">
			$(function(){
				$(document).on(\'click\', \'.clickUpdateCruiseMapImage\', function(){
					var $_this = $(this);
					var $_form = $_this.closest(\'.frmPop\');
					var $title = $_form.find(\'input[name=title]\');
					if($.trim($title.val())==\'\'){
						$title.focus().addClass(\'error\');
						alertify.error(field_is_required);
						return false;
					};
					$(\'#aj-update-form\').ajaxSubmit({
						type:\'POST\',
						url: path_ajax_script+"/index.php?mod=cruise&act=ajSysPhotosGalleryMap",
						data : {\'tp\':\'S\',\'cruise_map_image_id\': $_this.attr(\'cruise_map_image_id\')},
						success: function(html){
							console.log(html);
							var htm = parseInt(html);
							if(htm==1){
								$(\'#aj-upload-form\').resetForm();
								var $table_id = $_this.attr(\'table_id\');
								var $page = $(\'#Hid_CurrentPage\').val();
								loadTableGalleryMap($table_id, \'\',$page,10);
								$_form.find(\'.close_pop\').trigger(\'click\');
							}
						}
					});
					return false;
				});
			})
		</script>';
        echo $HTML;
        die();
    } // Save
    else if ($tp == 'S') {
        $titlePost = addslashes($_POST['title']);
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            $set = "title='" . $titlePost . "',slug='" . $core->replaceSpace($titlePost) . "',reg_date='" . time() . "'";
            if (!empty($_POST['isoman_url_image'])) {
                $set .= ",image='" . addslashes($_POST['isoman_url_image']) . "'";
            }
            if ($clsCruiseMapImage->updateOne($cruise_map_image_id, $set)) {
                echo (1);
                die();
            } else {
                echo (0);
                die();
            }
        } else {
            echo (0);
            die();
        }
    } else if ($tp == 'M') {
        #
        $one = $clsCruiseMapImage->getOne($cruise_map_image_id);
        $order_no = $one['order_no'];
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
        #
        $cond = 'table_id=' . $table_id;
        #
        if ($direct == 'moveup') {
            $lst = $clsCruiseMapImage->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsCruiseMapImage->updateOne($cruise_map_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruiseMapImage->updateOne($lst[0][$clsCruiseMapImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsCruiseMapImage->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsCruiseMapImage->updateOne($cruise_map_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruiseMapImage->updateOne($lst[0][$clsCruiseMapImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsCruiseMapImage->getAll($cond . " and order_no > $order_no order by order_no asc");
            $clsCruiseMapImage->updateOne($cruise_map_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsCruiseMapImage->getAll($cond . " and cruise_map_image_id <> '$cruise_map_image_id' and order_no > $order_no order by order_no asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsCruiseMapImage->updateOne($lstItem[$i][$clsCruiseMapImage->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsCruiseMapImage->getAll($cond . " and order_no < $order_no order by order_no desc");
            $clsCruiseMapImage->updateOne($cruise_map_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsCruiseMapImage->getAll($cond . " and cruise_map_image_id <> '$cruise_map_image_id' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsCruiseMapImage->updateOne($lstItem[$i][$clsCruiseMapImage->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
            }
        }
        echo (1);
        die();
    } else if ($tp == 'TOTAL') {
        echo $clsCruiseMapImage->getAll("is_trash=0 and table_id='$table_id'") ? count($clsCruiseMapImage->getAll("is_trash=0 and table_id='$table_id'")) : 0;
        die();
    } else if ($tp == 'SYS') {
        $LISTALL = $clsCruiseMapImage->getAll("is_trash=0 and table_id='$table_id' order by cruise_map_image_id asc");
        if (!empty($LISTALL)) {
            for ($i = 0; $i < count($LISTALL); $i++) {
                $clsCruiseMapImage->updateOne($LISTALL[$i][$clsCruiseMapImage->pkey], "order_no='" . ($i + 1) . "'");
            }
            unset($LISTALL);
        }
        echo (1);
        die();
    }
    echo (1);
    die();
}

/*========== LOAD PRICE UNIT START DATE ==========*/
function default_ajLoadPriceUnitStartDate()
{
    global $core, $clsISO;
    #
    $clsCruise = new Cruise();
    $clsCruiseStartDate = new CruiseStartDate();
    #
    $cruise_id = $_POST['cruise_id'];
    #
    $html = '';
    $lstCruiseStartDate = $clsCruiseStartDate->getAll("cruise_id='$cruise_id' order by start_date asc");
    if ($lstCruiseStartDate[0][$clsCruiseStartDate->pkey] != '') {
        $html .= '<h3 class="btn btn-primary fileinput-button">' . $core->get_Lang('liststartdate') . '</h3>
		<br style="clear:both;" /><br style="clear:both;" />
			<div id="holderAllTourStartDate" style="width:100%;">
				
			</div>
		';
        $html .= '
		<script type="text/javascript">
			$().ready(function(){
				makeGlobalTab("globaltabs_TourStartDate");
			});
		</script>
		<div class="globaltabs" id="globaltabs_TourStartDate_ul">
			<ul>';
        for ($m = 0; $m < count($lstCruiseStartDate); $m++) {
            $html .= '
				<li><a href="javascript:void();" title="' . date('d/m/Y', $lstCruiseStartDate[$m]['start_date']) . '">' . date('d/m', $lstCruiseStartDate[$m]['start_date']) . '</a></li>';
        }
        $html .= '</ul></div>
		<div class="clearfix"></div>
		<div class="tab_contentglobal">';
        for ($m = 0; $m < count($lstCruiseStartDate); $m++) {
            $html .= '
			<div class="tabboxglobal tabboxchild_globaltabs_TourStartDate" ' . ($m == 0 ? '' : ' style="display:none;"') . '>';
            #
            $cruise_start_date_id = $lstCruiseStartDate[$m][$clsCruiseStartDate->pkey];
            $start_date = $lstCruiseStartDate[$m]['start_date'];
            #
            $html .= '
			' . $core->get_Lang('tripcode') . ': <strong class="fontLarge">' . $clsCruiseStartDate->getTripCode($cruise_start_date_id) . '</strong>
			<br><em>' . $core->get_Lang('Note: Each cruise will depart one day own one program code to distinguish and handle bookings.') . '</em>
			<br><br>
			' . $core->get_Lang('pricefrom') . ': <a href="#" class="ajEditCruiseStartDateElement" tp="price" cruise_start_date_id="' . $cruise_start_date_id . '"><strong class="fontLarge" id="CruiseStartDateElement-' . $cruise_start_date_id . '-price">' . $clsISO->formatNumberToEasyRead($lstCruiseStartDate[$m]['price']) . $clsISO->getRateSign() . '</strong></a>
			<br><br>
			' . $core->get_Lang('priceold') . ': <a href="#" class="ajEditCruiseStartDateElement" tp="price_old" cruise_start_date_id="' . $cruise_start_date_id . '"><strong class="fontLarge" id="CruiseStartDateElement-' . $cruise_start_date_id . '-price_old"><del>' . $clsISO->formatNumberToEasyRead($lstCruiseStartDate[$m]['price_old']) . '</del></strong>' . $clsISO->getRateSign() . '</a> 
			<br><br>
			' . $core->get_Lang('arrivaldate') . ': <strong class="fontLarge">' . date('d/m/Y', $lstCruiseStartDate[$m]['start_date']) . '</strong>
			<br><br>
			' . $core->get_Lang('departdate') . ':  <a href="#" class="ajEditCruiseStartDateElement" tp="end_date" cruise_start_date_id="' . $cruise_start_date_id . '"><strong class="fontLarge"id="CruiseStartDateElement-' . $cruise_start_date_id . '-end_date">' . date('d/m/Y', $clsCruiseStartDate->getEndDate($cruise_start_date_id)) . '</strong></a>
			<br><br>
			' . $core->get_Lang('arrivaltime') . ': <a href="#" class="ajEditCruiseStartDateElement" tp="hour_in" cruise_start_date_id="' . $cruise_start_date_id . '"><strong class="fontLarge" id="CruiseStartDateElement-' . $cruise_start_date_id . '-hour_in">' . (trim($lstCruiseStartDate[$m]['hour_in']) == '' ? $core->get_Lang('null') : $lstCruiseStartDate[$m]['hour_in']) . '</strong></a>
			<br><br>
			' . $core->get_Lang('departtime') . ': <a href="#" class="ajEditCruiseStartDateElement" tp="hour_out" cruise_start_date_id="' . $cruise_start_date_id . '"><strong class="fontLarge" id="CruiseStartDateElement-' . $cruise_start_date_id . '-hour_out">' . (trim($lstCruiseStartDate[$m]['hour_out']) == '' ? $core->get_Lang('null') : $lstCruiseStartDate[$m]['hour_out']) . '</strong></a>
			<br><br>';
            $html .= '
			<br style="clear:both;" /><br style="clear:both;" />
			<a title="' . $core->get_Lang('delete') . '" cruise_start_date_id="' . $cruise_start_date_id . '" cruise_id="' . $cruise_id . '" class="clickDeleteCruiseStartDate btn btn-warning" href="#"><i class="icon-trash icon-white"></i> ' . $core->get_Lang('delete') . '</a>
			';
            $html .= '</div>';
        }
        $html .= '</div></div>';
    }
    echo ($html);
    die();
}

/* ========= SITE CRUISE PROPERTY ========= */
function default_property()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration, $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    #
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;

    $classTable = "CruiseProperty";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;


    $lstMonth = array();
    for ($i = 1; $i <= 12; $i++) {
        $lstMonth[] = ($i < 10) ? '0' . $i : $i;
    }
    $assign_list["lstMonth"] = $lstMonth;

    $listType = $clsClassTable->getListType();
    $assign_list["listType"] = $listType;
    $countListType = isset($listType) ? count($listType) : 0;
    $assign_list["countListType"] = $countListType;
    #
    $type = isset($_GET['type']) ? $_GET['type'] : '';

    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', $type)) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }


    $assign_list["type"] = $type;

    //print_r($type); die();

    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=' . $act . '&type=' . $type;
        if (isset($_POST['parent_id']) && $_POST['parent_id'] != '') {
            $link .= '&parent_id=' . $_POST['parent_id'];
        }
        if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }

    $cond = "1='1'";
    $cond .= " and type='$type'";
    #Filter By Keyword
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $keyword = $core->replaceSpace($_GET['keyword']);
        $cond .= " and slug like '%" . $keyword . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
    }

    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no asc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
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
    #
    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
            $link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit); //print_r($allItem);die();
    $assign_list["allItem"] = $allItem;
    #
    $allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2);
    $assign_list["number_trash"] = count($allTrash) ?? 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2);
    $assign_list["number_item"] = count($allUnTrash) ?? 0;
    #
    $allAll = $clsClassTable->getAll($cond2);
    $assign_list["number_all"] = count($allAll) ?? 0;


    if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
        $clsConfiguration->updateValue('high_season_month', $clsISO->makeSlashListFromArrayComma($_POST['season_month']));
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&type=' . $type . '&message=updateSuccess');
    }
}

function default_ajUpdPosSortListCruiseProperty()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $classTable = "CruiseProperty";
    $clsClassTable = new $classTable;
    $order = $_POST['order'];
    $type = $_POST['type'];
    $currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;
    $recordPerPage = isset($_POST['recordPerPage']) ? $_POST['recordPerPage'] : 1;
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        /*$key = $key + 1;*/
        $clsClassTable->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_move_property()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    #
    $classTable = "CruiseProperty";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $direct = isset($_GET['direct']) ? $_GET['direct'] : '';

    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $assign_list["type"] = $type;

    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', $type)) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }


    $one = $clsClassTable->getOne($pvalTable);
    $order_no = $one['order_no'];
    if ($pvalTable == "" || $direct == '') {
        header('location: ' . PCMS_URL . '/?mod=' . $mod);
    }

    $where = "1=1";
    $pUrl = '&act=property';
    if (isset($type) && !empty($type)) {
        $where .= " and type = '$type'";
        $pUrl .= '&type=' . $type;
    }

    if ($direct == 'moveup') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movedown') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movetop') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no DESC");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        unset($lst);
        $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > '$order_no' order by order_no asc");
        if (!empty($lst)) {
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
    }
    if ($direct == 'movebottom') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no ASC");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        unset($lst);
        $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < '$order_no' order by order_no desc");
        if (!empty($lst)) {
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
    }
    header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
}

function default_ajSiteCruiseProperty()
{
    ini_set('display_errors', 1);
    error_reporting(E_ERROR & ~E_STRICT);
    global $core, $clsConfiguration, $clsISO, $assign_list, $_LANG_ID;
    $user_id = $core->_USER['user_id'];
    #

    #
    $clsCruiseProperty = new CruiseProperty();
    $cruise_property_id = isset($_POST['cruise_property_id']) ? intval($_POST['cruise_property_id']) : 0;
    $is_private = $clsCruiseProperty->getOneField('is_private', $cruise_property_id);
    $is_extra_bed = $clsCruiseProperty->getOneField('is_extra_bed', $cruise_property_id);
    $parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';

    $listLang = $clsISO->getListLang();
    $listLang = array_diff($listLang, [$_LANG_ID]);
    array_unshift($listLang, $_LANG_ID);
    $assign_list["listLang"] = $listLang;
    $assign_list['clsCruiseProperty'] = $clsCruiseProperty;
    $assign_list['cruise_property_id'] = $cruise_property_id;
    $assign_list['type'] = $type;
    #
    if ($tp == 'F') {
        $number_adult = $clsCruiseProperty->getNumberAdult($cruise_property_id) ? $clsCruiseProperty->getNumberAdult($cruise_property_id) : 1;
        $number_child = $clsCruiseProperty->getNumberChild($cruise_property_id) ? $clsCruiseProperty->getNumberChild($cruise_property_id) : 0;
        /*        $assign_list["number_adult"] = $number_adult;
        $assign_list['number_child'] = $number_child;*/
        // echo $clsISO->build('property/form.tpl');
        // die;
        $typeName = $clsCruiseProperty->getTextByType($type) ? $clsCruiseProperty->getTextByType($type) : $type;
        $html = '
        <div class="headPop">
            <a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
            <h3>' . ($cruise_property_id == 0 ? $core->get_Lang('Add New') : $core->get_Lang('Edit')) . ' ' . $typeName . '</h3>
        </div>';
        $html .= '
			<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
				<div class="wrap">
					<div class="row-span">
						<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('title') . '</strong> <font class="color_r">*</font></div>
						<div class="fieldarea">
							<input class="text_32 border_aaa full-width bold required" name="title" placeholder="' . $core->get_Lang('entertitle') . '" value="' . $clsCruiseProperty->getTitle($cruise_property_id) . '" type="text" autocomplete="off" />
						</div>
					</div>';
        if ($type == 'GroupSize') {
            $html .= '<div class="row-span">
                            <div class="fieldlabel text-right bold"></div>
                            <div class="fieldarea bold">
                                <input name="is_private" ' . ($is_private == 1 ? 'checked' : '') . ' value="1" type="checkbox" style="width:20px; margin-right:5px!important;cursor: pointer;"/>' . $core->get_Lang('CruisePrivate') . '
                            </div>
                        </div>';
            $html .= '<div class="row-span">
                            <div class="fieldlabel text-right bold"></div>
                            <div class="fieldarea bold">
                                <input name="is_extra_bed" ' . ($is_extra_bed == 1 ? 'checked' : '') . ' value="1" type="checkbox" style="width:20px; margin-right:5px!important;cursor: pointer;"/>' . $core->get_Lang('Extra bed') . '
                            </div>
                        </div>';
            $html .= '<div class="row-span">
						<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Max adults') . '</strong> <font class="color_r">*</font></div>
						<div class="fieldarea">
							<input class="text_32 border_aaa bold price-In" required name="number_adult" min="1" value="' . $number_adult . '" type="number" style="width:120px"/>
						</div>
					</div>';
            $html .= '<div class="row-span">
						<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Max children') . '</strong></div>
						<div class="fieldarea">
							<input class="text_32 border_aaa bold price-In" name="number_child" value="' . $number_child . '" type="number" style="width:120px" min="0"/>
						</div>
					</div>';
        } elseif ($type == 'GroupBenefits') {
            $html .= '<div class="row-span">
							<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Class Icon') . '</strong> <font class="color_r">*</font></div>
							<div class="fieldarea">
								<input class="text_32 border_aaa bold required full-width" name="class_icon" value="' . $clsCruiseProperty->getClassIcon($cruise_property_id) . '" type="text"/>
							</div>
						</div>';
        } elseif ($type == 'GroupCabinFacilities') {
            $html .= '';
        } elseif ($type == 'GroupUsefulInformation') {
            $html .= '';
        } elseif ($type == 'GroupCruiseFacilities') {
            $html .= '<div class="row-span">
						<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Class Icon') . '</strong> <font class="color_r">*</font></div>
						<div class="fieldarea">
							<input class="text_32 border_aaa bold required full-width" name="class_icon" value="' . $clsCruiseProperty->getClassIcon($cruise_property_id) . '" type="text"/>
						</div>
						</div>';
        } elseif ($type == 'GroupNearestEssentials') {
            $html .= '<div class="row-span">
						<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Class Icon') . '</strong> <font class="color_r">*</font></div>
						<div class="fieldarea">
							<input class="text_32 border_aaa bold required full-width" name="class_icon" value="' . $clsCruiseProperty->getClassIcon($cruise_property_id) . '" type="text"/>
						</div>
						</div>';
        } elseif ($type == 'NearestEssentials') {
            $html .= '<div class="row-span">
							<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Group') . '</strong> <font class="color_r">*</font></div>
							<div class="fieldarea">
								<select name="group_id" style="width:300px">
									' . $clsCruiseProperty->getSelectByProperty('GroupNearestEssentials', $clsCruiseProperty->getOneField('group_id', $cruise_property_id)) . '
								</select>
							</div>
						</div>';
        } elseif ($type == 'UsefulInformation') {
            $html .= '<div class="row-span">
						<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Class Icon') . '</strong> <font class="color_r">*</font></div>
						<div class="fieldarea">
							<input class="text_32 border_aaa bold required full-width" name="class_icon" value="' . $clsCruiseProperty->getClassIcon($cruise_property_id) . '" type="text"/>
						</div>
						</div>
						<div class="row-span">
							<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Group') . '</strong> <font class="color_r">*</font></div>
							<div class="fieldarea">
								<select name="group_id" style="width:300px">
									' . $clsCruiseProperty->getSelectByProperty('GroupUsefulInformation', $clsCruiseProperty->getOneField('group_id', $cruise_property_id)) . '
								</select>
							</div>
						</div>';
        } elseif ($type == 'Benefits') {
            $html .= '<div class="row-span">
						<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Class Icon') . '</strong> <font class="color_r">*</font></div>
						<div class="fieldarea">
							<input class="text_32 border_aaa bold required full-width" name="class_icon" value="' . $clsCruiseProperty->getClassIcon($cruise_property_id) . '" type="text"/>
						</div>
						<div class="row-span">
							<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Group') . '</strong> <font class="color_r">*</font></div>
							<div class="fieldarea">
								<select name="group_id" style="width:300px">
									' . $clsCruiseProperty->getSelectByProperty('GroupBenefits', $clsCruiseProperty->getOneField('group_id', $cruise_property_id)) . '
								</select>
							</div>
						</div>
						<div class="row-span">
							<div class="fieldlabel  text-right"><strong>' . $core->get_Lang('Short text') . '</strong></div>
							<div class="fieldarea">
								<textarea id="textarea_intro_editor' . time() . '" class="textarea_intro_editor" name="intro" rows="5" style="width:100%">' . $clsCruiseProperty->getIntro($cruise_property_id) . '</textarea>
							</div>
						</div>
					</div>';
        } elseif ($type == 'CabinFacilities') {
            $html .= '<div class="row-span">
								<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Icon') . '</strong></div>
								<div class="fieldarea">
									<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '" style="width:32px; height:32px"/>
									<input type="hidden" id="isoman_hidden_image" value="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '">
									<input class="fl ml10 text_32 border_aaa" style="width:70% !important;display:inline-block" type="text" id="isoman_url_image" name="image" value="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
								</div>
							</div>';
            /*$html .='<div class="row-span">
									<div class="fieldlabel text-right bold"><strong>'.$core->get_Lang('Class Icon').'</strong> <font class="color_r">*</font></div>
									<div class="fieldarea">
										<input class="text_32 border_aaa bold required full-width" name="class_icon" value="'.$clsCruiseProperty->getClassIcon($cruise_property_id).'" type="text"/>
									</div>
								</div>';
						$html.='<div class="row-span">
									<div class="fieldlabel text-right bold"><strong>'.$core->get_Lang('Group').'</strong> <font class="color_r">*</font></div>
									<div class="fieldarea">
										<select name="group_id" style="width:300px">
											'.$clsCruiseProperty->getSelectByProperty('GroupCabinFacilities',$clsCruiseProperty->getOneField('group_id',$cruise_property_id)).'
										</select>
									</div>
								</div>';*/
        } elseif ($type == 'CruiseFacilities') {
            /*$html .='<div class="row-span">
							<div class="fieldlabel text-right bold"><strong>'.$core->get_Lang('Class Icon').'</strong> <font class="color_r">*</font></div>
							<div class="fieldarea">
								<input class="text_32 border_aaa bold required full-width" name="class_icon" value="'.$clsCruiseProperty->getClassIcon($cruise_property_id).'" type="text"/>
							</div>
						</div>';
            $html .= '<div class="row-span">
							<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Group') . '</strong> <font class="color_r">*</font></div>
							<div class="fieldarea">
								<select name="group_id" style="width:300px">
									' . $clsCruiseProperty->getSelectByProperty('GroupCruiseFacilities', $clsCruiseProperty->getOneField('group_id', $cruise_property_id)) . '
								</select>
							</div>
						</div>';*/
            $html .= '<div class="row-span">
								<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Icon') . '</strong></div>
								<div class="fieldarea">
									<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '" style="width:32px; height:32px"/>
									<input type="hidden" id="isoman_hidden_image" value="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '">
									<input class="fl ml10 text_32 border_aaa" style="width:70% !important;display:inline-block" type="text" id="isoman_url_image" name="image" value="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
								</div>
							</div>';
        } elseif ($type == 'ThingLove') {
            $html .= '<div class="row-span">
						<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Class Icon') . '</strong> <font class="color_r">*</font></div>
						<div class="fieldarea">
							<input class="text_32 border_aaa bold required full-width" name="class_icon" value="' . $clsCruiseProperty->getClassIcon($cruise_property_id) . '" type="text"/>
						</div>
					</div>';
        } elseif ($type == 'Conditions') {
            $html .= '<div class="row-span">
						<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Group') . '</strong> <font class="color_r">*</font></div>
						<div class="fieldarea">
							<select name="group" style="width:100px">
								<option value="Default" ' . ($clsCruiseProperty->getOneField('type_group', $cruise_property_id) == 'Default' ? 'selected=selected' : '') . '>' . $core->get_Lang('Default') . '</option>
								<option value="Free" ' . ($clsCruiseProperty->getOneField('type_group', $cruise_property_id) == 'Free' ? 'selected=selected' : '') . '>' . $core->get_Lang('Free') . '</option>
							</select>
						</div>
					</div>';
        } else if ($type == 'MEAL') {
            $html .= '
						<div class="row-span">
							<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Symbol') . '</strong> <span class="color_r">*</span></div>
							<div class="fieldarea">
							<input type="text" name="symbol" class="text full" value="' . $clsCruiseProperty->getSymbol($cruise_property_id) . '">
							</div>
						</div>';
        } else {
            if ($type != 'CruiseMaterial') {
                $html .= '<div class="row-span">
								<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Image') . '</strong></div>
								<div class="fieldarea">
									<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '" style="width:32px; height:32px"/>
									<input type="hidden" id="isoman_hidden_image" value="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '">
									<input class="fl ml10 text_32 border_aaa" style="width:70% !important;display:inline-block" type="text" id="isoman_url_image" name="image" value="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsCruiseProperty->getOneField('image', $cruise_property_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
								</div>
							</div>';
                $html .= '<div class="row-span">
								<div class="fieldlabel  text-right"><strong>' . $core->get_Lang('Short text') . '</strong></div>
								<div class="fieldarea">
									<textarea id="textarea_intro_editor' . time() . '" class="textarea_intro_editor" name="intro" rows="5" style="width:100%">' . $clsCruiseProperty->getIntro($cruise_property_id) . '</textarea>
								</div>
							</div>';
            }
        }

        $html .= '</div>
			</form>
			<div class="modal-footer"> 
				<button class="btn btn-primary clickSubmitProperty" cruise_property_id="' . $cruise_property_id . '" type="' . $type . '">
					<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span>
				</button> 
				<button class="btn btn-warning close_pop" data-dismiss="modal" aria-hidden="true">
					<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
				</button> 
			</div>';
        echo ($html);
        die();
    } elseif ($tp == 'S') {
        $titlePost = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
        $slugPost = $core->replaceSpace($titlePost);
        $introPost = isset($_POST['intro']) ? addslashes($_POST['intro']) : '';
        $imagePost = isset($_POST['image']) ? $_POST['image'] : '';
        $classIcon = isset($_POST['class_icon']) ? $_POST['class_icon'] : '';
        $groupPost = isset($_POST['group']) ? $_POST['group'] : '';
        $group_id = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
        $is_private = isset($_POST['is_private']) ? intval($_POST['is_private']) : 0;
        $is_extra_bed = isset($_POST['is_extra_bed']) ? intval($_POST['is_extra_bed']) : 0;
        $number_adult = isset($_POST['number_adult']) ? intval($_POST['number_adult']) : 1;
        $number_child = isset($_POST['number_child']) ? intval($_POST['number_child']) : 0;
        $symbol = isset($_POST['symbol']) ? $_POST['symbol'] : '';
        #
        if (intval($cruise_property_id) == 0) {
            if (!empty($clsCruiseProperty->getAll("is_trash=0 and slug='$slugPost' and type='$type'"))) {
                //                $clsISO->print_pre($clsCruiseProperty->countItem("slug='$slugPost' and type='$type'"),true);die();
                echo ('_EXIST');
                die();
            } else {
                $listTable = $clsCruiseProperty->getAll("1=1 and type='$type'", $clsCruiseProperty->pkey . ",order_no");

                for ($i = 0; $i <= count($listTable); $i++) {
                    $order_no = $listTable[$i]['order_no'] + 1;
                    $clsCruiseProperty->updateOne($listTable[$i][$clsCruiseProperty->pkey], "order_no='" . $order_no . "'");
                }

                $fx = "$clsCruiseProperty->pkey,title,slug,intro,image,is_private,is_extra_bed,number_adult,number_child,order_no,type_group,type,class_icon,group_id,symbol";
                $vx = "'" . $clsCruiseProperty->getMaxID() . "','" . $titlePost . "','" . $slugPost . "','" . $introPost . "','" . $imagePost . "','" . $is_private . "','" . $is_extra_bed . "','" . $number_adult . "','" . $number_child . "','1','" . $groupPost . "','$type','$classIcon','$group_id','$symbol'";
                if ($clsCruiseProperty->checkColumnInTable('is_online')) {
                    $fx .= ",is_online";
                    $vx .= ",'1'";
                }

                if ($clsCruiseProperty->insertOne($fx, $vx)) {
                    echo ('_SUCCESS');
                    die();
                } else {
                    echo ('_ERROR');
                    die();
                }
            }
        } else {
            if (!empty($clsCruiseProperty->getAll("is_trash=0 and slug='$slugPost' and type='$type' and cruise_property_id <> '$cruise_property_id'"))) {
                echo ('_EXIST');
                die();
            } else {
                $set = "title='$titlePost',slug='$slugPost',intro='$introPost',image='$imagePost',is_private='$is_private',is_extra_bed='$is_extra_bed',number_adult='$number_adult',number_child='$number_child',class_icon='$classIcon',type='$type',type_group='$groupPost',group_id='$group_id',symbol='$symbol'";
                if ($clsCruiseProperty->updateOne($cruise_property_id, $set)) {

                    echo ('_SUCCESS');
                    die();
                } else {
                    echo ('_ERROR');
                    die();
                }
            }
        }
    } elseif ($tp == 'D') {
        $clsCruiseProperty->deleteOne($cruise_property_id);
        echo (1);
        die();
    }
}

function default_ajGetBoxManagerCruiseProperty()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration, $clsISO;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruiseProperty = new CruiseProperty();
    $fromid = isset($_POST['fromid']) ? $_POST['fromid'] : 0;
    $forid = isset($_POST['forid']) ? $_POST['forid'] : 0;
    $cruise_property_id = isset($_POST['cruise_property_id']) ? $_POST['cruise_property_id'] : 0;
    $type = (isset($_POST['type'])) ? $_POST['type'] : 0;
    $is_choose = (isset($_POST['type'])) ? $_POST['is_choose'] : 0;
    $clsTable = (isset($_POST['clsTable'])) ? $_POST['clsTable'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    #
    if ($clsTable != '' && intval($forid) > 0) {
        if ($clsTable == 'CruiseCabin') {
            $clsClassTable = new $clsTable();
            $list_id = $clsClassTable->getOneField('list_cabin_facilities', $forid);
        }
    } else {
        $list_id = (isset($_POST['list_id'])) ? $_POST['list_id'] : '';
        if (!empty($list_id)) {
            $list_id = explode(',', $list_id);
            $list_id = $clsISO->makeSlashListFromArray($list_id);
        }
    }
    #
    if ($tp == 'L') {
        #
        $html .= '<div class="headPop">
					<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
					<h3>' . $core->get_Lang('management') . ' - ' . $type . '</h3>
				</div>
				<div class="contentPop" style="max-height:355px">
					<table class="tbl-grid" width="100%" cellpadding="0">
						<thead><tr>
				' . ($is_choose == 1 ? '<td class="gridheader"><input id="all_property" type="checkbox" /></td>' : '') . '
				<td class="gridheader"><strong>' . $core->get_Lang('index') . '</strong></td>
				<td class="gridheader" style="text-align:left"><strong>' . $core->get_Lang('title') . '</strong></td>
				<td class="gridheader" style="text-align:center;"><strong>' . $core->get_Lang('func') . '</strong></td>
			</tr>
		</thead>';
        $html .= '<tbody id="tblHolderPropertyPop">';
        $lstItem = $clsCruiseProperty->getAll("is_trash=0 and type='$type' order by order_no DESC", $clsCruiseProperty->pkey);
        if (!empty($lstItem)) {
            $i = 0;
            foreach ($lstItem as $item) {
                $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= ($is_choose == 1 ? '<td class="index"><input name="fa_item[]" class="chkitem chkitem_property" type="checkbox" ' . ($clsISO->checkContainer($list_id, $item[$clsCruiseProperty->pkey]) ? 'checked=checked' : '') . ' value="' . $item[$clsCruiseProperty->pkey] . '" /></td>' : '');
                $html .= '<td class="index">' . ($i + 1) . '</td>';
                $html .= '<td><a class="editCruiseProperty" _type="' . $type . '" title="' . $clsCruiseProperty->getTitle($item[$clsCruiseProperty->pkey]) . '" data="' . $item[$clsCruiseProperty->pkey] . '" fromid="' . $fromid . '" forid="' . $forid . '" href="javascript:;"><strong style="font-size:14px">' . $clsCruiseProperty->getTitle($item[$clsCruiseProperty->pkey]) . '</strong></a></td>';
                $html .= '
					<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" style="right:0px !important">
								<li><a class="editCruiseProperty" title="' . $core->get_Lang('edit') . '" href="javascript:void();" _type="' . $type . '" fromid="' . $fromid . '" forid="' . $forid . '" data="' . $item[$clsCruiseProperty->pkey] . '"><i class="icon-edit"></i> <span>' . $core->get_Lang('edit') . '</span></a></li>
								<li><a class="deleteCruiseProperty" title="' . $core->get_Lang('delete') . '" href="javascript:void();" _type="' . $type . '" fromid="' . $fromid . '" forid="' . $forid . '" data="' . $item[$clsCruiseProperty->pkey] . '"><i class="icon-remove"></i> <span>' . $core->get_Lang('delete') . '</span></a></li>
							</ul>
						</div>
					</td>
				';
                $html .= '</tr>';
                ++$i;
            }
        }
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '
		<div class="bottom" unselectable="on" style="-moz-user-select: none;">
			' . ($is_choose == 1 ? '<button type="button" class="btn btn-primary fr savePropertyToBox" _type="' . $type . '" cruise_property_id="' . $cruise_property_id . '" fromid="' . $fromid . '" forid="' . $forid . '"><i class="icon-ok icon-white"></i> ' . $core->get_Lang('save') . '</button>' : '') . '
			<a parent_id="59" type="' . $type . '" fromid="' . $fromid . '" forid="' . $forid . '" class="iso-button-primary createNewCruiseProperty fr"><i class="icon-plus-sign"></i> ' . $core->get_Lang('add') . '</a>
			
		</div>';
        echo $html;
        die();
    } elseif ($tp == 'F') {
        #
        $oneTable = $clsCruiseProperty->getOne($cruise_property_id);
        if (!empty($oneTable['type'])) {
            $type = $oneTable['type'];
        }
        #
        $html = '';
        $html .= '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('Close') . '"></a>
			<h3>' . (intval($cruise_property_id) == 0 ? $core->get_Lang('Add new') . ' - ' . $type : $core->get_Lang('Update') . ' - ' . $clsCruiseProperty->getTitle($cruise_property_id)) . '</h3>
		</div>';
        $html .= '
		<table class="form" cellpadding="3" cellspacing="3">
			<tr>
				<td class="fieldarea">
					<input type="text" placeholder="' . $core->get_Lang('Enter title') . '" name="title" class="text full required fontLarge" value="' . $clsCruiseProperty->getTitle($cruise_property_id) . '" style="width:95%">
				</td>
			</tr>
		</table>
		<div class="modal-footer"> 
			<button type="button" class="btn btn-primary saveCruiseProperty" _type="' . $type . '" cruise_property_id="' . $cruise_property_id . '" fromid="' . $fromid . '" forid="' . $forid . '">' . $core->get_Lang('save') . '</button>
		</div>';
        echo $html;
        die();
    } elseif ($tp == 'S') {
        #
        $titlePost = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
        $slugPost = $core->replaceSpace($titlePost);
        #
        if (intval($cruise_property_id) == 0) {
            if ($clsCruiseProperty->getAll("slug='$slugPost' and type='$type'") != '') {
                echo ('_EXIST');
                die();
            } else {
                $f = "$clsCruiseProperty->pkey,title,slug,order_no,type";
                $v = "'" . $clsCruiseProperty->getMaxID() . "','$titlePost','$slugPost','" . $clsCruiseProperty->getMaxOrderNo() . "','$type'";
                if ($clsCruiseProperty->insertOne($f, $v)) {
                    echo ('_SUCCESS');
                    die();
                } else {
                    echo ('_ERROR');
                    die();
                }
            }
        } else {
            if ($clsCruiseProperty->getAll("slug='$slugPost' and type='$type' and cruise_property_id <> '$cruise_property_id'") != '') {
                echo ('_EXIST');
                die();
            } else {
                $set = "title='$titlePost',slug='$slugPost'";
                if ($clsCruiseProperty->updateOne($cruise_property_id, $set)) {
                    echo ('_SUCCESS');
                    die();
                } else {
                    echo ('_ERROR');
                    die();
                }
            }
        }
    } elseif ($tp == 'D') {
        $clsCruiseProperty->deleteOne($cruise_property_id);
        echo (1);
        die();
    }
}

function default_ajaxSavePropertyToBox()
{
    global $core, $clsISO, $_LANG_ID;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruiseProperty = new CruiseProperty();
    $type = isset($_POST['type']) ? trim($_POST['type']) : '';
    $list_id = isset($_POST['list_id']) ? $_POST['list_id'] : '';
    #
    if (is_array($list_id) && count($list_id) > 0) {
        $listCabinFacilities = $clsCruiseProperty->getAll("is_trash=0 and type='$type' order by order_no desc", $clsCruiseProperty->pkey);
        $list_id = $clsISO->makeSlashListFromArray($list_id);
        $html = '<select class="selectbox" name="cabin_facility[]" multiple>';
        if (!empty($listCabinFacilities)) {
            foreach ($listCabinFacilities as $k => $v) {
                $html .= '<option ' . ($clsISO->checkContainer($list_id, $v[$clsCruiseProperty->pkey]) ? 'selected=selected' : '') . ' value="' . $v[$clsCruiseProperty->pkey] . '">' . $clsCruiseProperty->getTitle($v[$clsCruiseProperty->pkey]) . '</option>';
            }
        }
        $html .= '</select>';
        echo $html;
        die();
    } else {
        echo '_EMPTY';
        die();
    }
}

function default_ajLoadTableCruiseProperty()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    #
    $clsCruiseProperty = new CruiseProperty();
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $fromid = isset($_POST['fromid']) ? $_POST['fromid'] : '';
    $forid = isset($_POST['forid']) ? intval($_POST['forid']) : 0;

    $lstItem = $clsCruiseProperty->getAll("is_trash=0 and type='$type' order by order_no DESC", $clsCruiseProperty->pkey);
    $Html = '';

    if (is_array($lstItem) && count($lstItem) > 0) {
        for ($i = 0; $i < count($lstItem); $i++) {
            $Html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $Html .= '<td class="index">' . ($i + 1) . '</td>';
            $Html .= '<td><a class="editCruiseProperty" _type="' . $type . '" title="' . $core->get_Lang('edit') . '" data="' . $lstItem[$i][$clsCruiseProperty->pkey] . '" fromid="' . $fromid . '" forid="' . $forid . '" href="javascript:;"><strong style="font-size:14px">' . $clsCruiseProperty->getTitle($lstItem[$i][$clsCruiseProperty->pkey]) . '</strong></a></td>';
            $Html .= '
				<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a class="editCruiseProperty" title="' . $core->get_Lang('edit') . '" href="javascript:void();" _type="' . $type . '" fromid="' . $fromid . '" forid="' . $forid . '" data="' . $lstItem[$i][$clsCruiseProperty->pkey] . '"><i class="icon-edit"></i> <span>' . $core->get_Lang('edit') . '</span></a></li>
							<li><a class="deleteCruiseProperty" title="' . $core->get_Lang('delete') . '" href="javascript:void();" _type="' . $type . '" fromid="' . $fromid . '" forid="' . $forid . '" data="' . $lstItem[$i][$clsCruiseProperty->pkey] . '"><i class="icon-remove"></i> <span>' . $core->get_Lang('delete') . '</span></a></li>
						</ul>
					</div>
				</td>
			';
            $Html .= '</tr>';
        }
    }
    echo $Html;
    die();
}

function default_ajSelectBoxCruiseBudget()
{
    global $core, $clsConfiguration;
    #

    $clsCruise = new Cruise();
    $clsCruiseProperty = new CruiseProperty();
    #
    $type = $_POST['type'];
    $forid = $_POST['forid'];
    $cruise_budget = $clsCruise->getOneField('cruise_budget', $forid);
    $Html = $clsCruiseProperty->getSelectByProperty($type, $cruise_budget);
    echo $Html;
    die();
}

function default_ajLoadCruiseTypeList()
{
    global $core, $clsConfiguration, $clsISO;
    #
    $clsCruise = new Cruise();
    $clsCruiseProperty = new CruiseProperty();
    #
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $forid = isset($_POST['forid']) ? intval($_POST['forid']) : 0;
    #
    $lstItem = $clsCruiseProperty->getAll("is_trash=0 and type = '$type' order by order_no desc");
    $Html = '';
    if (is_array($lstItem) && count($lstItem) > 0) {
        for ($i = 0; $i < count($lstItem); $i++) {
            $Html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $Html .= '<td class="index">' . ($i + 1) . '</td>';
            $Html .= '<td>' . $clsCruiseProperty->getTitle($lstItem[$i][$clsCruiseProperty->pkey]) . '</td>';
            $Html .= '<td class="text-center"><input class="cruise_' . $type . '" ' . ($clsISO->checkContainer($clsCruise->getOneField('list' . $type, $forid), $lstItem[$i][$clsCruiseProperty->pkey]) ? 'checked=checked' : '') . ' name="list' . $type . '[]" value="' . $lstItem[$i][$clsCruiseProperty->pkey] . '" type="checkbox" /></td>';
        }
    }
    echo $Html;
    die();
}

/* ========= SITE CRUISE PRICE SETUP ========= */
function default_ajCruisePriceSetup()
{
    global $core, $_LANG_ID, $clsISO, $clsConfiguration;
    #
    $clsCruise = new Cruise();
    $clsCruisePriceTable = new CruisePriceTable();
    $clsCruiseItinerary = new CruiseItinerary();
    $clsCruiseCabin = new CruiseCabin();
    $clsCruiseProperty = new CruiseProperty();

    $cruise_id = isset($_POST['cruise_id']) ? $_POST['cruise_id'] : 0;
    $cruise_itinerary_id = isset($_POST['cruise_itinerary_id']) ? $_POST['cruise_itinerary_id'] : 0;
    $cruise_cabin_id = isset($_POST['cruise_cabin_id']) ? $_POST['cruise_cabin_id'] : 0;
    $cruise_property_id = isset($_POST['cruise_property_id']) ? $_POST['cruise_property_id'] : 0;
    $price = isset($_POST['price']) ? $_POST['price'] : 0;
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $season = isset($_POST['season']) ? $_POST['season'] : '';
    $cruise_price_table_id = isset($_POST['cruise_price_table_id']) ? intval($_POST['cruise_price_table_id']) : 0;
    #
    if ($tp == 'L') {
        $Html = '';
        $listItem = $clsCruisePriceTable->getAll("cruise_id='$cruise_id' order by order_no ASC");
        if (is_array($listItem) && count($listItem) > 0) {
            for ($i = 0; $i < count($listItem); $i++) {
                $Html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $Html .= '<td class="index">' . ($i + 1) . '</td>';
                $Html .= '<td><strong>' . $clsCruiseItinerary->getTitle($listItem[$i][$clsCruiseItinerary->pkey]) . '</strong></td>';
                $Html .= '<td><strong>' . $clsCruiseCabin->getTitle($listItem[$i][$clsCruiseCabin->pkey]) . '</strong></td>';
                if ($clsConfiguration->getValue('SiteHasCruisesProperty')) {
                    $Html .= '<td><strong>' . $clsCruiseProperty->getTitle($listItem[$i][$clsCruiseProperty->pkey]) . '</strong></td>';
                }
                $Html .= '<td><strong>' . $clsCruisePriceTable->getSeason($listItem[$i][$clsCruisePriceTable->pkey]) . '</strong></td>';
                $Html .= '<td style="text-align:right;"><strong class="format_price" style="font-size:15px">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($listItem[$i]['price']) . '</strong></td>';
                $Html .= '<td style="vertical-align: middle;text-align:center">
						' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('movetop') . '"  direct="movetop" class="btnmove_price_table" data="' . $listItem[$i][$clsCruisePriceTable->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">
						' . ($i == count($listItem) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="btnmove_price_table" direct="movebottom" data="' . $listItem[$i][$clsCruisePriceTable->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">
						' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('moveup') . '" class="btnmove_price_table" direct="moveup" data="' . $listItem[$i][$clsCruisePriceTable->pkey] . '" href="javascript:void();"><i class="icon-arrow-up"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">
						' . ($i == count($listItem) - 1 ? '' : '<a title="' . $core->get_Lang('movedown') . '" class="btnmove_price_table" direct="movedown" data="' . $listItem[$i][$clsCruisePriceTable->pkey] . '" href="javascript:void();"><i class="icon-arrow-down"></i></a>') . '
					</td>';
                $Html .= '
					<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" style="right:0px !important">
								<li><a class="btnedit_price_table" title="' . $core->get_Lang('edit') . '" href="javascript:void();" data="' . $listItem[$i][$clsCruisePriceTable->pkey] . '"><i class="icon-edit"></i> <span>' . $core->get_Lang('edit') . '</span></a></li>
								<li><a class="btndelete_price_table" title="' . $core->get_Lang('delete') . '" href="javascript:void();" data="' . $listItem[$i][$clsCruisePriceTable->pkey] . '"><i class="icon-remove"></i> <span>' . $core->get_Lang('delete') . '</span></a></li>
							</ul>
						</div>
					</td>';
                $Html .= '</tr>';
            }
        }
        echo $Html;
        die();
    } else if ($tp == 'S') {
        if ($cruise_price_table_id == 0) {
            if ($clsCruisePriceTable->getAll("cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and cruise_property_id='$cruise_property_id' and season='$season'") != '') {
                echo '_EXIST';
                die();
            } else {
                $fx = "$clsCruisePriceTable->pkey,cruise_id,cruise_itinerary_id,season,cruise_cabin_id";
                $fx .= ",cruise_property_id,price,reg_date,upd_date,order_no";
                $vx = "'" . $clsCruisePriceTable->getMaxID() . "','$cruise_id','$cruise_itinerary_id','$season','$cruise_cabin_id'";
                $vx .= ",'$cruise_property_id','" . $clsISO->processSmartNumber($price) . "','" . time() . "','" . time() . "','" . $clsCruisePriceTable->getMaxOrderNo() . "'";
                $clsCruisePriceTable->insertOne($fx, $vx);
                echo ('_SUCCESS');
                die();
            }
        } else {
            if ($clsCruisePriceTable->getAll("cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and cruise_property_id='$cruise_property_id' and cruise_price_table_id<>'$cruise_price_table_id' and season='$season'") != '') {
                echo '_EXIST';
                die();
            } else {
                $clsCruisePriceTable->updateOne($cruise_price_table_id, "cruise_itinerary_id='$cruise_itinerary_id',cruise_cabin_id='$cruise_cabin_id',season='$season',cruise_property_id='$cruise_property_id',price='" . $clsISO->processSmartNumber($price) . "',upd_date='" . time() . "'");
                echo ('_SUCCESS');
                die();
            }
        }
    } else if ($tp == 'D') {
        $clsCruisePriceTable->deleteOne($cruise_price_table_id);
        echo (1);
        die();
    } else if ($tp == 'G') {
        $one = $clsCruisePriceTable->getOne($cruise_price_table_id);

        $clsCruiseItinerary = new CruiseItinerary();
        $lstCruiseItinerary = $clsCruiseItinerary->getAll("is_trash=0 and cruise_id='$cruise_id' order by order_no desc");
        $Html = '<option value="0"> -- ' . $core->get_Lang('selectitinerary') . ' -- </option>';
        if (is_array($lstCruiseItinerary) && count($lstCruiseItinerary) > 0) {
            for ($i = 0; $i < count($lstCruiseItinerary); $i++) {
                $Html .= '<option ' . ($one['cruise_itinerary_id'] == $lstCruiseItinerary[$i][$clsCruiseItinerary->pkey] ? 'selected="selected"' : '') . ' value="' . $lstCruiseItinerary[$i][$clsCruiseItinerary->pkey] . '"> -- ' . $clsCruiseItinerary->getTitle($lstCruiseItinerary[$i][$clsCruiseItinerary->pkey]) . ' -- </option>';
            }
        }
        #
        echo $Html . '$$' . $one['cruise_cabin_id'] . '$$' . $one['cruise_property_id'] . '$$' . $one['price'] . '$$' . $cruise_price_table_id . '$$' . $one['season'];
        die();
    } else if ($tp == 'M') {
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
        $one = $clsCruisePriceTable->getOne($cruise_price_table_id);
        $current_pos = $one['order_no'];

        $where = "is_trash=0 and cruise_id='$cruise_id'";
        if ($direct == 'movedown') {
            $lst = $clsCruisePriceTable->getAll($where . " and order_no > '$current_pos' order by order_no ASC limit 0,1");
            $clsCruisePriceTable->updateOne($cruise_price_table_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruisePriceTable->updateOne($lst[0][$clsCruisePriceTable->pkey], "order_no='" . $current_pos . "'");
        }
        if ($direct == 'moveup') {
            $lst = $clsCruisePriceTable->getAll($where . " and order_no < '$current_pos' order by order_no DESC limit 0,1");
            $clsCruisePriceTable->updateOne($cruise_price_table_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruisePriceTable->updateOne($lst[0][$clsCruisePriceTable->pkey], "order_no='" . $current_pos . "'");
        }
        if ($direct == 'movebottom') {
            $lst = $clsCruisePriceTable->getAll($where . " and order_no > '$current_pos' order by order_no DESC LIMIT 0,1");
            $clsCruisePriceTable->updateOne($cruise_price_table_id, "order_no='" . $lst[0]['order_no'] . "'");
            #
            $lst = $clsCruisePriceTable->getAll($where . " and cruise_price_table_id <> '$cruise_price_table_id' and order_no>'$current_pos' order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsCruisePriceTable->updateOne($lst[$i][$clsCruisePriceTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movetop') {
            $lst = $clsCruisePriceTable->getAll($where . " and order_no < '$current_pos' order by order_no ASC LIMIT 0,1");
            $clsCruisePriceTable->updateOne($cruise_price_table_id, "order_no='" . $lst[0]['order_no'] . "'");
            #
            $lst = $clsCruisePriceTable->getAll($where . " and cruise_price_table_id <> '$cruise_price_table_id' and order_no<'$current_pos' order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsCruisePriceTable->updateOne($lst[$i][$clsCruisePriceTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        echo (1);
        die();
    }
}

/* ========= SITE CRUISE CUSTOM FIELD ========= */
function default_SiteCruiseCustomField()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruiseCustomField = new CruiseCustomField();
    $cruise_customfield_id = isset($_POST['cruise_customfield_id']) ? intval($_POST['cruise_customfield_id']) : 0;
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $cruise_id = $_POST['cruise_id'];
    #
    if ($tp == 'C') {
        $idx = $clsCruiseCustomField->getAll("fieldtype='CUSTOM' and cruise_id='$cruise_id'") ? count($clsCruiseCustomField->getAll("fieldtype='CUSTOM' and cruise_id='$cruise_id'")) : 0;
        $title = 'Custom_Field_' . ($idx + 1);
        $slug = 'custom_field_' . ($idx + 1);
        $fx = "fieldname,fieldname_slug,fieldtype,user_id,user_id_update,cruise_id,$clsCruiseCustomField->pkey,order_no,reg_date,upd_date";
        $vx = "'$title','$slug','CUSTOM','$user_id','$user_id','$cruise_id','" . $clsCruiseCustomField->getMaxID() . "','" . $clsCruiseCustomField->getMaxOrderNo() . "','" . time() . "','" . time() . "'";
        if ($clsCruiseCustomField->insertOne($fx, $vx)) {
            echo ('_SUCCESS');
            die();
        } else {
            echo ('_ERROR');
            die();
        }
    } else if ($tp == 'L') {
        $listCustomField = $clsCruiseCustomField->getAll("fieldtype='CUSTOM' and cruise_id='$cruise_id' order by order_no ASC");
        $html = '';
        if (is_array($listCustomField) && count($listCustomField) > 0) {
            for ($i = 0; $i < count($listCustomField); $i++) {
                $html .= '
				<div class="row-span row-has-border" style="width:100%">
                    <div class="fieldlabel">
						' . $listCustomField[$i]['fieldname'] . '
						<div class="Site_Custom_Field_Tools" style="display:inline-block;margin-bottom:10px">
							<a title="' . $core->get_Lang('edit') . '" cruise_id="' . $cruise_id . '" data="' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '" class="btnedit_customfield" href="javascript:void();"><i class="icon-pencil"></i></a>
							<a title="' . $core->get_Lang('delete') . '" cruise_id="' . $cruise_id . '" data="' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '" class="btndelete_customfield" href="javascript:void();"><i class="icon-remove"></i></a>
							' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('move') . '" cruise_id="' . $cruise_id . '" data="' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '" class="btnmove_customfield" direct="up" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
							' . ($i == (count($listCustomField) - 1) ? '' : '<a title="' . $core->get_Lang('move') . '" cruise_id="' . $cruise_id . '" data="' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '" class="btnmove_customfield" direct="down" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
						</div>
					</div>
					<div class="fieldarea">
						<textarea style="width:100%" cols="255" rows="5" class="Site_Custom_Field_Editor" id="Site_Custom_Field_' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '_' . time() . '" name="Site_Custom_Field_value_' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '">' . $listCustomField[$i]['fieldvalue'] . '</textarea>
					</div>
				</div>';
            }
        }
        echo $html;
        die();
    } else if ($tp == 'L2') {
        $listCustomField = $clsCruiseCustomField->getAll("fieldtype='CUSTOM' and cruise_id='$cruise_id' order by order_no ASC");
        $html = '';
        if (is_array($listCustomField) && count($listCustomField) > 0) {
            for ($i = 0; $i < count($listCustomField); $i++) {
                $html .= '
				<div class="row-span row-has-border" style="width:100%">
                    <div class="fieldlabel">
						' . $listCustomField[$i]['fieldname'] . '
						<div class="Site_Custom_Field_Tools" style="display:inline-block;margin-bottom:10px">
							<a title="' . $core->get_Lang('edit') . '" cruise_id="' . $cruise_id . '" data="' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '" class="btnedit_customfield" href="javascript:void();"><i class="icon-pencil"></i></a>
							<a title="' . $core->get_Lang('delete') . '" cruise_id="' . $cruise_id . '" data="' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '" class="btndelete_customfield" href="javascript:void();"><i class="icon-remove"></i></a>
							' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('move') . '" cruise_id="' . $cruise_id . '" data="' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '" class="btnmove_customfield" direct="up" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
							' . ($i == (count($listCustomField) - 1) ? '' : '<a title="' . $core->get_Lang('move') . '" cruise_id="' . $cruise_id . '" data="' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '" class="btnmove_customfield" direct="down" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
						</div>
					</div>
					<div class="fieldarea">
						<textarea style="width:100%" cols="255" rows="5" class="Site_Custom_Field_Editor" id="Site_Custom_Field_' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '_' . time() . '" name="Site_Custom_Field_value_' . $listCustomField[$i][$clsCruiseCustomField->pkey] . '">' . $listCustomField[$i]['fieldvalue'] . '</textarea>
					</div>
				</div>';
            }
        }
        echo $html;
        die();
    } else if ($tp == 'D') {
        $clsCruiseCustomField->deleteOne($cruise_customfield_id);
        echo (1);
        die();
    } else if ($tp == 'F') {
        $html = '
		<div class="headPop"> 
			<a id="clickToCloseNewTourPriceRow" href="javascript:void();" class="closeEv close_pop"></a> 
			<h3>' . $core->get_Lang('Edit') . ': ' . $clsCruiseCustomField->getOneField('fieldname', $cruise_customfield_id) . '</h3> 
		</div> 
		<div class="modal-body">
			<table class="form" cellpadding="3" cellspacing="3">
				<tr>
					<td class="fieldarea">
						<input type="text" name="fieldname" class="text_32 border_aaa full-width fontLarge required" style="width:95%" value="' . $clsCruiseCustomField->getOneField('fieldname', $cruise_customfield_id) . '">
					</td>
				</tr>
			</table>
		</div>
		<div class="modal-footer"> 
			<button class="btn btn-success submitClick SiteClickUpdateFieldName" cruise_id="' . $cruise_id . '" cruise_customfield_id="' . $cruise_customfield_id . '">' . $core->get_Lang('update') . '</button> 
		</div>';
        echo ($html);
        die();
    } else if ($tp == 'S') {
        $fieldname = $_POST['fieldname'];
        $fieldnameSlug = $core->replaceSpace($fieldname);
        if ($clsCruiseCustomField->getAll("fieldtype='CUSTOM' and cruise_id='$cruise_id' and BINARY fieldname='$fieldname'") != '') {
            echo '_EXIST';
            die();
        } else {
            $v = "user_id_update = '$user_id',fieldname='$fieldname',fieldname_slug='$fieldnameSlug'";
            $clsCruiseCustomField->updateOne($cruise_customfield_id, $v);
            echo (1);
            die();
        }
    } else if ($tp == 'M') {
        $direct = isset($_POST['direct']) ? intval($_POST['direct']) : '';
        $order_no = $clsCruiseCustomField->getOneField('order_no', $cruise_customfield_id);
        $where = "is_trash=0";
        $where .= " and cruise_id='$cruise_id'";

        if ($direct == 'up') {
            $lst = $clsCruiseCustomField->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsCruiseCustomField->updateOne($cruise_customfield_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruiseCustomField->updateOne($lst[0][$clsCruiseCustomField->pkey], "order_no='$order_no'");
        }
        if ($direct == 'down') {
            $lst = $clsCruiseCustomField->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsCruiseCustomField->updateOne($cruise_customfield_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruiseCustomField->updateOne($lst[0][$clsCruiseCustomField->pkey], "order_no='$order_no'");
        }
        echo (1);
        die();
    }
}

/* END_TOUR_CUSTOM_FIELD_MOD */

/* ========= SITE CRUISE ITINERARY DAY ========= */
function default_SiteCruiseItineraryDay()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO;
    $user_id = $core->_USER['user_id'];
    #
    $clsCruise = new Cruise();
    $clsCruiseItinerary = new CruiseItinerary();
    $clsClassTable = new CruiseItineraryDay();
    $clsCruiseProperty = new CruiseProperty();
    $clsTransport = new Transport();
    $assign_list["clsTransport"] = $clsTransport;
    $cruise_itinerary_day_id = isset($_POST['cruise_itinerary_day_id']) ? intval($_POST['cruise_itinerary_day_id']) : 0;
    $cruise_itinerary_id = isset($_POST['cruise_itinerary_id']) ? $_POST['cruise_itinerary_id'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $html = '';
    #
    if ($tp == 'L') {
        $number_day = $clsCruiseItinerary->getOneField('number_day', $cruise_itinerary_id);
        $lstItem = $clsClassTable->getAll("is_trash=0 and cruise_itinerary_id='$cruise_itinerary_id' order by day asc limit 0,$number_day", $clsClassTable->pkey . ',reg_date,day,meals');

        if (is_array($lstItem) && count($lstItem) > 0) {
            $i = 0;
            foreach ($lstItem as $k => $item) {
                $txt_meal = "";
                if ($item['meals'] != '') {
                    $lst_meal = $clsCruiseProperty->getAll("is_trash=0 and type='MEAL' and cruise_property_id IN (" . $item['meals'] . ")", $clsCruiseProperty->pkey . ',title');
                    foreach ($lst_meal as $key => $value) {
                        $txt_meal .= (($key > 0) ? ", " : "") . $value['title'];
                    }
                }
                $html .= '<tr style="cursor:move" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '" id="order_' . $item[$clsClassTable->pkey] . '">';
                $html .= '<td class="index">' . $item['day'] . '</td>';
                $html .= '<td class="text-left" style="width:70px;padding-left:8px !important"><img src="' . $clsClassTable->getImage($item[$clsClassTable->pkey], 68, 52) . '" alt="tests" width="68" height="52" style="border-radius:2px"></td>';
                $html .= '<td>' . $clsClassTable->getTitle($item[$clsClassTable->pkey]) . '</td>';
                $html .= '<td>' . $txt_meal . '</td>';
                $html .= '<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="btn-group-ico">
								<a title="' . $core->get_Lang('edit') . '" href="javascript:void()" data-cruise_itinerary_id="' . $cruise_itinerary_id . '" class="clickEditItineraryDay" data="' . $item[$clsClassTable->pkey] . '"><i class="ico ico-edit"></i></a>
								<a title="' . $core->get_Lang('delete') . '" class="clickDeleteItinerary" data-cruise_itinerary_id="' . $cruise_itinerary_id . '" data="' . $item[$clsClassTable->pkey] . '" href="javascript:void();"><i class="ico ico-remove"></i></a>
							</div>
						</td>';
                $html .= '</tr>';
                ++$i;
            }
            $html .= '<script type="text/javascript">
				$("#tblCruiseItineraryDay").sortable({
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
						$.post(path_ajax_script+"/index.php?mod=cruise&act=ajUpdPosSortCruiseItineraryDay", order, function(html){
							loadCruiseItineraryDay(' . $cruise_itinerary_id . ');
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
        } else {
            /*for($i==0;$i<$number_day;$i++){
				$html.='<tr class="'.($i%2==0?'row1':'row2').'">';
				$html.='<td class="index">'.($i+1).'</td>';
				$html.='<td><a class="clickEditItineraryDay" title="'.$core->get_Lang('edit').'" href="javascript:void();" data=""><strong style="font-size:15px;">Edit Day '.($i+1).'</strong></a></td>';
				$html.='<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
								<ul class="dropdown-menu" style="right:0px !important">
									<li><a class="clickEditItineraryDay" title="'.$core->get_Lang('edit').'" href="javascript:void();" data=""><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
									<li><a class="clickDeleteItinerary" title="'.$core->get_Lang('delete').'" href="javascript:void();" data=""><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
								</ul>
							</div>
						</td>
					</tr>';
			}*/
        }
        echo $html;
        die();
    } elseif ($tp == 'F') {
        $number_day = Input::post('number_day', 0);
        $max_day = $clsClassTable->getMaxDay($cruise_itinerary_id);

        if ($cruise_itinerary_day_id == 0) {
            $number_itinerary_day = $clsClassTable->countItem("cruise_itinerary_id='" . $cruise_itinerary_id . "'");
            $day = !empty($number_itinerary_day) ? $number_itinerary_day + 1 : 1;
        } else {
            $day = $clsClassTable->getOneField('day', $cruise_itinerary_day_id);
        }

        $html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('entertitle') . '"></a>
			<h3>' . ($cruise_itinerary_day_id == 0 ? $core->get_Lang('Add Cruise Itinerary Day') : $core->get_Lang('Edit Cruise Itinerary Day')) . '- [ID #' . $cruise_itinerary_id . ']</h3>
		</div>';
        $html .= '
		<form method="post" id="frmItinerary" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="fr span20 full_width_991">
					<div class="photobox center_991 image">
						<img src="' . ($cruise_itinerary_day_id > 0 ? $clsClassTable->getOneField('image', $cruise_itinerary_day_id) : '') . '" id="isoman_show_image_itinerary" />
						<input type="hidden" id="isoman_hidden_image_itinerary" name="isoman_url_image" value="' . ($cruise_itinerary_day_id > 0 ? $clsClassTable->getOneField('image', $cruise_itinerary_day_id) : '') . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('Change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image_itinerary" isoman_val="' . ($cruise_itinerary_day_id > 0 ? $clsClassTable->getOneField('image', $cruise_itinerary_day_id) : '') . '" isoman_name="image"><i class="iso-edit"></i></a>
						' . ($clsClassTable->getOneField('image', $cruise_itinerary_day_id) != '' ? '<a pvalTable="' . $cruise_itinerary_day_id . '" clsTable="CruiseItineraryDay" href="javascript:void()" title="' . $core->get_Lang('delete') . '" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>' : '') . '
					</div>
					<div class="wrap mt10 boxShowImages">
						<p class="text-center"><strong>' . $core->get_Lang('Image Size') . ' (WxH=384x256px)<strong></p>
						<p class="text-center">
							<label>
								<input type="radio" class="margin_0" name="is_show_image" value="0" checked="checked" /> OFF
							</label>
							<label>
								<input type="radio" class="margin_0" name="is_show_image" value="1" ' . ($clsClassTable->getOneField('is_show_image', $cruise_itinerary_day_id) == 1 ? 'checked="checked"' : '') . ' /> ON
							</label>
						</p>
					</div>
				</div>
				<div class="fl span75 full_width_991">
					<div class="row-span" style="display:none">
						<div class="fieldlabel bold text-right text_left_767"><strong>' . $core->get_Lang('Day') . '</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<input class="text full required" style="width:70px" value="' . $day . '" name="day" type="number" max="' . $max_day . '">
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel bold text-right text_left_767"><strong>' . $core->get_Lang('title') . '</strong> <span class="color_r">*</span></div>
						<div class="fieldarea"><input type="text" name="title" class="text full-width fontLarge required" id="title" value="' . $clsClassTable->getOneField('title', $cruise_itinerary_day_id) . '" /></div>
					</div>';
        $lstMeal = $clsCruiseProperty->getAll("is_trash=0 and type='MEAL'", $clsCruiseProperty->pkey . ',title,symbol');
        if (!empty($lstMeal)) {
            $html .= '
					<div class="row-span">
						<div class="fieldlabel bold text-right text_left_767" style="text-align:right">
							<strong>' . $core->get_Lang('meal') . '</strong> <span class="color_r">*</span> 
							<input type="checkbox" class="checkall_checkbox" group="meal" title="' . $core->get_Lang('selectall') . '" style="cursor:pointer;" />
						</div>
						<div class="fieldarea">
							<div style="border:1px solid #d7d7d7;width:100%;padding:3px 10px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;">';
            foreach ($lstMeal as $item) {
                $html .= '<label class="mr20"><input type="checkbox" ' . ($clsClassTable->checkMealExist($item[$clsCruiseProperty->pkey], $cruise_itinerary_day_id) ? 'checked="checked"' : '') . ' name="meal[]" class="chk_Meal checkitem_checkbox" group="meal" value="' . $item[$clsCruiseProperty->pkey] . '"> ' . $item['title'] . '</label>';
            }
            $html .= '				
							</div>
						</div>
					</div>';
        }
        $html .= '<div class="row-span">
						<div class="fieldlabel text-right text_left_767" ><strong>' . $core->get_Lang('Long text') . '</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<textarea rows="5" cols="255" id="textarea_itinerary_content_editor_' . time() . '" class="textarea_itinerary_content_editor" name="content" style="width:100%">' . $clsClassTable->getContent($cruise_itinerary_day_id) . '</textarea>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="submit" cruise_itinerary_day_id="' . $cruise_itinerary_day_id . '" class="btn btn-primary btnSaveCruiseItineraryDay">
				<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
			</button>
		</div>';
        echo ($html);
        die();
    } elseif ($tp == 'S') {
        $titlePost = isset($_POST['title']) && !is_array($_POST['title'])
            ? trim(strip_tags((string)$_POST['title']))
            : '';

        if ($titlePost === '') {
            echo '_EMPTY_TITLE';
            die();
        }

        $slugPost = $core->replaceSpace($titlePost);

        $transportPost = isset($_POST['transport']) && !is_array($_POST['transport'])
            ? trim((string)$_POST['transport'])
            : '';

        $transport_id = isset($_POST['transport_id']) && !is_array($_POST['transport_id'])
            ? (int)$_POST['transport_id']
            : 0;

        $dayPost = isset($_POST['day']) && !is_array($_POST['day'])
            ? (int)$_POST['day']
            : 0;

        if ($dayPost <= 0) {
            if ($cruise_itinerary_day_id > 0) {
                $dayPost = (int)$clsClassTable->getOneField(
                    'day',
                    $cruise_itinerary_day_id
                );
            } else {
                $dayPost = (int)$clsClassTable->countItem(
                    "cruise_itinerary_id='" . (int)$cruise_itinerary_id . "'"
                ) + 1;
            }
        }

        $contentRaw = isset($_POST['content']) && !is_array($_POST['content'])
            ? (string)$_POST['content']
            : '';

        $contentPost = addslashes($contentRaw);

        if (isset($_POST['image']) && !is_array($_POST['image'])) {
            $imagePost = trim((string)$_POST['image']);
        } elseif (
            isset($_POST['isoman_url_image'])
            && !is_array($_POST['isoman_url_image'])
        ) {
            $imagePost = trim((string)$_POST['isoman_url_image']);
        } else {
            $imagePost = '';
        }

        $is_show_image = isset($_POST['is_show_image']) && !is_array($_POST['is_show_image'])
            ? (int)$_POST['is_show_image']
            : 0;

        $mealIds = [];
        if (isset($_POST['meal'])) {
            $mealInput = is_array($_POST['meal'])
                ? $_POST['meal']
                : explode(',', (string)$_POST['meal']);

            foreach ($mealInput as $mealId) {
                $mealId = (int)$mealId;
                if ($mealId > 0) {
                    $mealIds[$mealId] = $mealId;
                }
            }
        }
        $meals = implode(',', array_values($mealIds));

        $cruise_itinerary_id = (int)$cruise_itinerary_id;
        $cruise_itinerary_day_id = (int)$cruise_itinerary_day_id;
        $user_id = (int)$user_id;
        $transport_id = (int)$transport_id;
        $dayPost = (int)$dayPost;
        $is_show_image = $is_show_image === 1 ? 1 : 0;
        #
        if ($cruise_itinerary_day_id > 0) {
            $duplicateCount = (int)$clsClassTable->countItem(
                "cruise_itinerary_id='{$cruise_itinerary_id}'
                AND day='{$dayPost}'
                AND cruise_itinerary_day_id<>'{$cruise_itinerary_day_id}'"
            );

            if ($duplicateCount > 0) {
                echo '_EXIST';
                die();
            }

            $v = "user_id_update='$user_id',title='$titlePost',slug='$slugPost',day='$dayPost',content='" . $contentPost . "',transport='" . $transportPost . "',transport_id='$transport_id',upd_date='" . time() . "',image='$imagePost',is_show_image='$is_show_image',meals='$meals'";
            //print_r($cruise_itinerary_day_id.'<br/>'.$v);die();
            if ($clsClassTable->updateOne($cruise_itinerary_day_id, $v)) {
                echo '_UPDATE_SUCCESS';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        } else {
            $number_day = Input::post("number_day", 0);
            $number_night = Input::post("number_night", 0);
            if ($number_day > 0) {
                $clsCruiseItinerary->updateOne($cruise_itinerary_id, "number_day='" . $number_day . "',number_night='" . $number_night . "'");
            }

            $duplicateCount = (int)$clsClassTable->countItem(
                "cruise_itinerary_id='{$cruise_itinerary_id}'
                AND day='{$dayPost}'"
            );

            if ($duplicateCount > 0) {
                echo '_EXIST';
                die();
            }
            #
            $f = "user_id,user_id_update,title,slug,day,cruise_itinerary_id,content,reg_date,upd_date,order_no,cruise_itinerary_day_id,transport_id,transport,image,is_show_image,meals";
            $v = "'$user_id','$user_id','$titlePost','$slugPost','$dayPost','$cruise_itinerary_id','" . $contentPost . "','" . time() . "','" . time() . "','" . $clsClassTable->getMaxOrderNo() . "','" . $clsClassTable->getMaxID() . "','$transport_id','$transportPost','$imagePost','$is_show_image','$meals'";

            if ($clsClassTable->insertOne($f, $v)) {
                echo '_INSERT_SUCCESS';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        }
    } elseif ($tp == 'M') {
        #
        $one = $clsClassTable->getOne($cruise_itinerary_day_id);
        $dayTour = $one['day'];
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
        #
        $cond = 'is_trash=0 and cruise_itinerary_id=' . $cruise_itinerary_id;

        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($cond . " and day < $dayTour order by day desc limit 0,1");
            $clsClassTable->updateOne($cruise_itinerary_day_id, "day='" . $lst[0]['day'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "day='" . $dayTour . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($cond . " and day > $dayTour order by day asc limit 0,1");
            $clsClassTable->updateOne($cruise_itinerary_day_id, "day='" . $lst[0]['day'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "day='" . $dayTour . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($cond . " and day < $dayTour order by day desc");
            $clsClassTable->updateOne($cruise_itinerary_day_id, "day='" . $lst[count($lst) - 1]['day'] . "'");
            $lstItem = $clsClassTable->getAll($cond . " and cruise_itinerary_day_id <> '$cruise_itinerary_day_id' and day < $dayTour order by day asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "day='" . ($lstItem[$i]['day'] + 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($cond . " and day > $dayTour order by day asc");
            $clsClassTable->updateOne($cruise_itinerary_day_id, "day='" . $lst[count($lst) - 1]['day'] . "'");
            $lstItem = $clsClassTable->getAll($cond . " and cruise_itinerary_day_id <> '$cruise_itinerary_day_id' and day > $dayTour order by day asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "day='" . ($lstItem[$i]['day'] - 1) . "'");
            }
        }
        echo (1);
        die();
    } elseif ($tp == 'D') {
        $clsClassTable->doDelete($cruise_itinerary_day_id);
        echo (1);
        die();
    }
}

/* ========= SITE CRUISE PRICE RANGE ========= */
function default_price_range()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsConfiguration->getValue('SiteHasPriceRange_Cruises')) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
}

function default_OpenAvailbilityOld()
{
    global $clsISO, $core, $dbconn, $_LANG_ID;
    $clsCruiseItinerary = new CruiseItinerary();
    $clsCruiseCabin = new CruiseCabin();
    $clsAvailbility = new Availbility();
    $type = $_POST['type'];
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $target_id = intval($_POST['target_id']);
    $cruise_cabin_id = $_POST['cruise_cabin_id'];
    $price_ori = $clsCruiseItinerary->getOneField('trip_price', $target_id);
    $default_state = $clsCruiseItinerary->getOneField('default_state', $target_id);
    $max_adult = $clsCruiseCabin->getMaxAdult($cruise_cabin_id);
    $assign_list["max_adult"] = $max_adult;
    // List action
    if ($tp == 'L') {
        $results = array();
        $check_in = intval($_POST['start']);
        $check_out = intval($_POST['end']);
        if ($type == '_CABIN') {
            $data = _getdataCruise($target_id, $type, $check_in, $check_out, $cruise_cabin_id);
            for ($i = $check_in; $i <= $check_out; $i = strtotime('+1 day', $i)) {
                $op .= '|' . $i;
                $in_date = false;
                if (!empty($data)) {
                    foreach ($data as $key => $val) {
                        $status = $val['status'];
                        if (date('dmY', $i) == date('dmY', $val['check_in']) && date('dmY', $i) == date('dmY', $val['check_out'])) {
                            $results[] = array(
                                'price' => $val['price'],
                                'start' => date('Y-m-d', $i),
                                'title' => $clsCruiseItinerary->getTitle($target_id),
                                'item_id' => $val[$clsAvailbility->pkey],
                                'status' => $val['status'],
                                'allotement' => $val['allotement'],
                                'request_price' => $val['request_price'],
                            );
                            if (!$in_date) {
                                $in_date = true;
                            }
                        }
                    }
                }
                if (!$in_date && ($default_state == 'available' || !$default_state)) {
                    $results[] = array(
                        'price' => $price_ori,
                        'start' => date('Y-m-d', $i),
                        'title' => $clsCruiseItinerary->getTitle($target_id),
                        'number' => $number_room,
                        'status' => $default_state
                    );
                }
            }
        }
        //var_dump($op); die();
        echo json_encode($results);
        die();
    } // Save action
    else if ($tp == 'S') {
        if ($type == '_CABIN') {
            $cruise_cabin_id = $_POST['cruise_cabin_id'];
            $check_in = $_POST['check_in'];
            $check_out = $_POST['check_out'];
            $price = $_POST['price'];
            $status = $_POST['status'];
            $allotement = $_POST['allotement'];
            $request_price = $_POST['request_price'];
            if ($check_in == '' || $check_out == '') {
                echo '_invalid_date_empty';
                die();
            }
            $check_in = strtotime($check_in);
            $check_out = strtotime($check_out);
            if ($check_in > $check_out) {
                echo '_invalid_date_less';
                die();
            }
            if ($status == 'available') {
                if (filter_var($price, FILTER_VALIDATE_FLOAT) === false) {
                    echo '_invalid_price';
                    die();
                }
            }
            #
            for ($i = $check_in; $i <= $check_out; $i = strtotime('+1 day', $i)) {
                $_data = _getdataCruise($target_id, $type, $i, $i, $cruise_cabin_id);
                if (!empty($_data)) {
                    foreach ($_data as $key => $val) {
                        if ($i == $val['check_in'] && $i == $val['check_out'] && $cruise_cabin_id == $val['cruise_cabin_id']) {
                            $set = "price='" . $clsISO->processSmartNumber($price) . "'
							,status='$status',allotement='$allotement',request_price='$request_price'";
                            $clsAvailbility->updateOne($val[$clsAvailbility->pkey], $set);
                        } else {
                            $f = "availbility_id,target_id,cruise_cabin_id,type,check_in,check_out,price,status,allotement,request_price";
                            $availbility_id = $clsAvailbility->getMaxId();
                            $v = "'$availbility_id','$target_id','$cruise_cabin_id','$type','$i','$i','" . $clsISO->processSmartNumber($price) . "','$status','$allotement','$request_price'";
                            $clsAvailbility->insertOne($f, $v);
                        }
                    }
                } else {
                    $f = "availbility_id,target_id,cruise_cabin_id,type,check_in,check_out,price,status,allotement,request_price";
                    $availbility_id = $clsAvailbility->getMaxId();
                    $v = "'$availbility_id','$target_id','$cruise_cabin_id','$type','$i','$i','" . $clsISO->processSmartNumber($price) . "','$status','$allotement','$request_price'";
                    $clsAvailbility->insertOne($f, $v);
                }
            }
        }
        #
        echo (1);
        die();
    }
}


function default_OpenAvailbility()
{
    global $clsISO, $core, $dbconn, $_LANG_ID;
    $clsCruiseItinerary = new CruiseItinerary();
    $clsCruiseCabin = new CruiseCabin();
    $clsAvailbility = new Availbility();
    $type = $_POST['type'];
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $target_id = intval($_POST['target_id']);
    $price_ori = $clsCruiseItinerary->getOneField('trip_price', $target_id);
    $default_state = $clsCruiseItinerary->getOneField('default_state', $target_id);

    // List action
    if ($tp == 'L') {
        $results = array();
        $check_in = intval($_POST['start']);
        $cruise_cabin_id = $_POST['cruise_cabin_id'];
        $max_adult = $clsCruiseCabin->getMaxAdult($cruise_cabin_id);
        $assign_list["max_adult"] = $max_adult;
        $max_child = $clsCruiseCabin->getMaxChild($cruise_cabin_id);
        $assign_list["max_child"] = $max_child;
        if ($type == '_CABIN') {
        }
        //var_dump($op); die();
        echo json_encode($results);
        die();
    } // Save action
    else if ($tp == 'S') {
        if ($type == '_CABIN') {
            $cruise_cabin_id = $_POST['cruise_cabin_id'];
            $max_adult = $clsCruiseCabin->getMaxAdult($cruise_cabin_id);
            $assign_list["max_adult"] = $max_adult;
            $max_child = $clsCruiseCabin->getMaxChild($cruise_cabin_id);
            $assign_list["max_child"] = $max_child;
            $check_in = $_POST['check_in'];
            $status = $_POST['status'];
            $allotement = $_POST['allotement'];
            if ($check_in == '') {
                echo '_invalid_date_empty';
                die();
            }
            $check_in = strtotime($check_in);

            #
            for ($i = 1; $i <= $max_adult; $i++) {
                for ($j = 0; $j <= $max_child; $j++) {
                    $price = $_POST['price_' . $i . 'adult_' . $j . 'child'];
                    //$price=$_POST['price_4adult_1child'];

                    //$data=$clsCruiseItinerary->getPricePeopleDepartureDate($target_id,$cruise_cabin_id,$check_in,$i,$j);
                    //$_data = _getdataCruise($target_id, $type, $check_in, $i, $j, $cruise_cabin_id);

                    $SQL = "SELECT * FROM " . DB_PREFIX . "availbility WHERE target_id='$target_id' and check_in ='$check_in' AND number_adult='$i' and number_child='$j' and type='_CABIN' and cruise_cabin_id='$cruise_cabin_id' order by check_in ASC";
                    $allAvailbility = $dbconn->getAll($SQL);

                    if (!empty($allAvailbility)) {
                        foreach ($allAvailbility as $key => $val) {
                            if ($check_in == $val['check_in'] && $type == $val['type'] && $i == $val['number_adult'] && $j == $val['number_child'] && $cruise_cabin_id == $val['cruise_cabin_id']) {
                                $set = "price='" . $clsISO->processSmartNumber($price) . "'
								,status='$status',allotement='$allotement',request_price='" . $clsISO->processSmartNumber($price) . "'";
                                $clsAvailbility->updateOne($val[$clsAvailbility->pkey], $set);
                            } else {
                                $f = "availbility_id,target_id,cruise_cabin_id,type,check_in,number_adult,number_child,price,status,allotement,request_price";
                                $availbility_id = $clsAvailbility->getMaxId();
                                $v = "'$availbility_id','$target_id','$cruise_cabin_id','$type','$check_in','$i','$j','" . $clsISO->processSmartNumber($price) . "','$status','$allotement','" . $clsISO->processSmartNumber($price) . "'";
                                $clsAvailbility->insertOne($f, $v);
                            }
                        }
                    } else {
                        $f = "availbility_id,target_id,cruise_cabin_id,type,check_in,number_adult,number_child,price,status,allotement,request_price";
                        $availbility_id = $clsAvailbility->getMaxId();
                        $v = "'$availbility_id','$target_id','$cruise_cabin_id','$type','$check_in','$i','$j','" . $clsISO->processSmartNumber($price) . "','$status','$allotement','" . $clsISO->processSmartNumber($price) . "'";
                        $clsAvailbility->insertOne($f, $v);
                    }
                }
            }
        }
        #
        echo (1);
        die();
    }
}


function default_loadDepartureCruiseItinerary()
{
    global $clsISO, $core, $dbconn, $_LANG_ID, $clsConfiguration;
    $clsCruiseItinerary = new CruiseItinerary();
    $clsProperty = new Property();
    $clsCruiseCabin = new CruiseCabin();
    $clsAvailbility = new Availbility();
    $type = $_POST['type'];
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $target_id = $_POST['target_id'];
    $assign_list["target_id"] = $target_id;
    $cruise_cabin_id = $_POST['cruise_cabin_id'];
    $assign_list["cruise_cabin_id"] = $cruise_cabin_id;
    $max_adult = $clsCruiseCabin->getMaxAdult($cruise_cabin_id);
    $assign_list["max_adult"] = $max_adult;
    $max_child = $clsCruiseCabin->getMaxChild($cruise_cabin_id);
    $assign_list["max_child"] = $max_child;

    $check_in = $_POST['check_in'];
    if ($check_in == '') {
        $check_in = date('m/d/Y', strtotime("+ 1 days"));
    }
    $check_in_math = strtotime($check_in);
    $assign_list['check_in_math'] = $check_in_math;
    //print_r($check_in); die();

    $Html = '';

    $Html .= '<div class="form-group row">
			<input type="hidden" name="cruise_cabin_id" value="' . $cruise_cabin_id . '">
            <div class="col-xs-6">
                <label for="calendar_status">' . $core->get_Lang('Max Adults') . '</label>
                <input readonly="readonly" value="' . $clsCruiseCabin->getOneField('max_adult', $cruise_cabin_id) . '" type="text" disabled="disabled" style="width:100%; line-height:26px">
            </div>
            <div class="col-xs-6">
                <label for="calendar_status">' . $core->get_Lang('Max Child') . '</label>
                <input readonly="readonly" value="' . $clsCruiseCabin->getOneField('max_child', $cruise_cabin_id) . '" type="text" disabled="disabled" style="width:100%; line-height:26px">
            </div>
        </div>

		<div class="form-group">
			<label for="priceTable">' . $core->get_Lang('Price Setting') . ' (' . $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ')</label>
			<table width="100%" border-collapse="0" border-spacing="0" class="TablePriceCruiseDP">
				<tbody>
					<tr>
						<th style="border:1px solid #ddd">Adults</th>
						<th style="border:1px solid #ddd">Child</th>
						<th style="border:1px solid #ddd">Price</th>
					</tr>';

    for ($i = 1; $i <= $max_adult; $i++) {
        for ($j = 0; $j <= $max_child; $j++) {
            $Html .= '<tr>
						<td style="text-align:center;border:1px solid #ddd">' . $i . '</td>';

            $Html .= '<td style="text-align:center; border:1px solid #ddd">' . $j . '</td>
								<td style="text-align:center; border:1px solid #ddd"><input class="calendar_price" name="price_' . $i . 'adult_' . $j . 'child" type="text" value="' . $clsCruiseItinerary->getPricePeopleDepartureDate($target_id, $cruise_cabin_id, $check_in_math, $i, $j) . '" style="width:120px"/></td>
						';
            $Html .= '</tr>';
        }
    }
    $Html .= '<tr>
					</tr>
				</tbody>
			</table>
		</div>
		
		
        <div class="form-group row">
            <div class="col-xs-6">
                <label for="calendar_status">' . $core->get_Lang('Status') . '</label>';
    $status = $clsAvailbility->getAll("type='_CABIN' and target_id ='" . $target_id . "' and cruise_cabin_id='" . $cruise_cabin_id . "' and check_in='" . $check_in_math . "' and status='unavailable'");
    if ($status == '') {
        $Html .= '<select name="status" id="calendar_status" class="form-control">
						<option value="available">' . $core->get_Lang('Available') . '</option>
						<option value="unavailable">' . $core->get_Lang('Unavailable') . '</option>
					</select>';
    } else {
        $Html .= '<select name="status" id="calendar_status" class="form-control">
						<option value="available">' . $core->get_Lang('Available') . '</option>
						<option selected="selected" value="unavailable">' . $core->get_Lang('Unavailable') . '</option>
					</select>';
    }
    $Html .= '</div>
        </div>
';

    // End code here !!
    $Html .= '
	<script type="text/javascript">
	</script>';
    echo $Html;
    die();
}


function _getdataCruise($target_id, $type, $check_in, $num_adult, $num_child, $cruise_cabin_id)
{
    global $dbconn, $_LANG_ID;
    $clsAvailbility = new Availbility();
    $sql = "SELECT `availbility_id`,`target_id`,`type`,`check_in`,`price`,`status`,`allotement`,`request_price` FROM " . DB_PREFIX . "availbility 
	WHERE target_id = '$target_id' AND type='$type' AND cruise_cabin_id='$cruise_cabin_id' AND number_adult='$num_adult' AND number_child='$num_child' AND check_in='$check_in'";
    $results = $dbconn->getAll($sql);
    return $results;
}

function default_loadPriceDayItinerary($number_day)
{
    global $core, $clsISO, $_LANG_ID;
    #
    $clsCruise = new Cruise();
    $clsCruiseItinerary = new CruiseItinerary();
    $number_day = $_POST['number_day'];
    $cruise_id = $_POST['cruise_id'];
    #
    if ($number_day == 3) {
        $trip_price = $clsCruise->getOneField('price_3day', $cruise_id);
    } else {
        $trip_price = $clsCruise->getOneField('price', $cruise_id);
    }
    #
    echo ('0|||' . $trip_price);
    die();
}

function default_ajSiteFrmCruisePriceRange()
{
    /*ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);*/
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsISO;
    #
    $clsPagination = new Pagination();
    $clsCruisePriceRange = new CruisePriceRange();
    #
    $user_id = $core->_USER['user_id'];
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $cruise_price_range_id = isset($_POST['cruise_price_range_id']) ? intval($_POST['cruise_price_range_id']) : 0;

    if ($tp == 'L') {
        $number_per_page = isset($_POST['number_per_page']) ? $_POST['number_per_page'] : 10;
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
        #
        $cond = "is_trash=0";
        if (isset($keyword) && !empty($keyword)) {
            $slug = $core->replaceSpace($keyword);
            $cond .= " and (slug like '%$slug%' or title like '%$keyword%')";
        }
        $totalRecord = $clsCruisePriceRange->getAll($cond);
        $pageview = $clsPagination->pagination_ajax(count($totalRecord), $number_per_page, $page);
        $offset = ($page - 1) * $number_per_page;
        $cond .= " ORDER BY order_no ASC";
        $cond .= " LIMIT $offset,$number_per_page";
        #
        $lstItem = $clsCruisePriceRange->getAll($cond);
        if (is_array($lstItem) && count($lstItem) > 0) {
            $i = 0;
            foreach ($lstItem as $item) {
                $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index">' . ($i + 1) . '</td>';
                $html .= '<td><strong>' . $clsCruisePriceRange->getTitle($item[$clsCruisePriceRange->pkey]) . '</strong></td>';
                $html .= '<td><strong class="format_price">' . $clsCruisePriceRange->getMin($item[$clsCruisePriceRange->pkey]) . '</strong></td>';
                $html .= '<td><strong class="format_price">' . $clsCruisePriceRange->getMax($item[$clsCruisePriceRange->pkey]) . '</strong></td>';
                $html .= '
					<td style="vertical-align: middle;text-align:center">
						' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('movetop') . '" class="ajMovePriceRange" direct="movetop" data="' . $item[$clsCruisePriceRange->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="ajMovePriceRange" direct="movebottom" data="' . $item[$clsCruisePriceRange->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('moveup') . '" class="ajMovePriceRange" direct="moveup" data="' . $item[$clsCruisePriceRange->pkey] . '" href="javascript:void();"><i class="icon-arrow-up"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center"> ' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movedown') . '" class="ajMovePriceRange" direct="movedown" data="' . $item[$clsCruisePriceRange->pkey] . '" href="javascript:void();"><i class="icon-arrow-down"></i></a>') . '</td>';
                $html .= '
					<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" style="right:0px !important">
								<li><a class="ajEditPriceRange" title="' . $core->get_Lang('edit') . '" href="javascript:void();" data="' . $item[$clsCruisePriceRange->pkey] . '"><i class="icon-edit"></i> <span>' . $core->get_Lang('edit') . '</span></a></li>
								<li><a class="ajDeletePriceRange" title="' . $core->get_Lang('delete') . '" href="javascript:void();" data="' . $item[$clsCruisePriceRange->pkey] . '"><i class="icon-remove"></i> <span>' . $core->get_Lang('delete') . '</span></a></li>
							</ul>
						</div>
					</td>';
                $html .= '</tr>';
                ++$i;
            }
        } else {
            $html .= '<tr><td style="text-align:center" colspan="7">' . $core->get_Lang('nodata') . ' !</td></tr>';
        }
        echo $html . '$$' . $pageview;
        die();
    } elseif ($tp == 'F') {
        $html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . $core->get_Lang('updateCruisePriceRange') . '</h3>
		</div>
		<form method="post" id="frmPriceRange" class="frmform" enctype="multipart/form-data">
			<table class="form" cellpadding="3" cellspacing="3">
				<tr>
					<td class="fieldlabel span15">' . $core->get_Lang('title') . '</label>
					<td class="fieldarea">
						<input class="text fontLarge full" name="title" value="' . $clsCruisePriceRange->getTitle($cruise_price_range_id) . '" type="text" />
					</td>
				</tr>
				<tr>
					<td class="fieldlabel span15">' . $core->get_Lang('minrate') . '</label>
					<td class="fieldarea">
						<input class="text fontLarge full price" value="' . $clsCruisePriceRange->getMin($cruise_price_range_id) . '" name="min_rate" type="text" />
					</td>
				</tr>
				<tr>
					<td class="fieldlabel span15">' . $core->get_Lang('minrate') . '</label>
					<td class="fieldarea">
						<input class="text fontLarge full price" value="' . $clsCruisePriceRange->getMax($cruise_price_range_id) . '" name="max_rate" type="text" />
					</td>
				</tr>
			</table>
			<div class="modal-footer">
				<button type="button" cruise_price_range_id="' . $cruise_price_range_id . '" class="btn btn-primary ajSubmitPriceRange"><i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span> </button>
				<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span></button>
			</div>
		</form>';
        echo ($html);
        die();
    } elseif ($tp == 'S') {
        $titlePost = isset($_POST['title']) ? trim(addslashes($_POST['title'])) : '';
        $slugPost = $core->replaceSpace($titlePost);
        $min_rate = $_POST['min_rate'] ? addslashes($_POST['min_rate']) : 0;
        $max_rate = $_POST['max_rate'] ? addslashes($_POST['max_rate']) : 0;
        #
        if (intval($cruise_price_range_id) == 0) {
            $f = "$clsCruisePriceRange->pkey,title,slug,min_rate,max_rate,order_no";
            $v = "'" . $clsCruisePriceRange->getMaxID() . "','$titlePost','$slugPost','" . $clsISO->processSmartNumber($min_rate) . "','" . $clsISO->processSmartNumber($max_rate) . "','" . $clsCruisePriceRange->getMaxOrderNo() . "'";
            if ($clsCruisePriceRange->insertOne($f, $v)) {
                echo '_INSUCCESS';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        } else {
            $v = "title='$titlePost',slug='$slugPost',min_rate='" . $clsISO->processSmartNumber($min_rate) . "',max_rate='" . $clsISO->processSmartNumber($max_rate) . "'";
            if ($clsCruisePriceRange->updateOne($cruise_price_range_id, $v)) {
                echo '_UPSUCCESS';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        }
    } elseif ($tp == 'D') {
        $clsCruisePriceRange->deleteOne($cruise_price_range_id);
        echo 1;
        die();
    } elseif ($tp == 'M') {
        $one = $clsCruisePriceRange->getOne($cruise_price_range_id);
        $order_no = $one['order_no'];
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';

        if ($direct == 'moveup') {
            $lst = $clsCruisePriceRange->getAll("is_trash=0 and order_no < $order_no order by order_no DESC limit 0,1");
            $clsCruisePriceRange->updateOne($cruise_price_range_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruisePriceRange->updateOne($lst[0][$clsCruisePriceRange->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsCruisePriceRange->getAll("is_trash=0 and order_no > $order_no order by order_no ASC limit 0,1");
            $clsCruisePriceRange->updateOne($cruise_price_range_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsCruisePriceRange->updateOne($lst[0][$clsCruisePriceRange->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsCruisePriceRange->getAll("is_trash=0 and order_no < $order_no order by order_no ASC");
            $clsCruisePriceRange->updateOne($cruise_price_range_id, "order_no='" . $lst[0]['order_no'] . "'");
            unset($lst);
            $lst = $clsCruisePriceRange->getAll("is_trash=0 and cruise_price_range_id<>'$cruise_price_range_id' and order_no < '$order_no' order by order_no DESC");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsCruisePriceRange->updateOne($lst[$i][$clsCruisePriceRange->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
                }
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsCruisePriceRange->getAll("is_trash=0 and order_no > $order_no order by order_no DESC");
            $clsCruisePriceRange->updateOne($cruise_price_range_id, "order_no='" . $lst[0]['order_no'] . "'");
            unset($lst);
            $lst = $clsCruisePriceRange->getAll("is_trash=0 and cruise_price_range_id<>'$cruise_price_range_id' and order_no > '$order_no' order by order_no ASC");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsCruisePriceRange->updateOne($lst[$i][$clsCruisePriceRange->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
                }
            }
        }
        echo (1);
        die();
    }
}

require_once(DIR_MODULES . '/cruise/mod_default.php');
