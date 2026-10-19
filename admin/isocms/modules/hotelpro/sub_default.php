<?php
//HOTEL DEFAULT
function default_default() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
	$clsProperty = new Property();$assign_list["clsProperty"] = $clsProperty;
    $clsContinent = new Continent();$assign_list['clsContinent'] = $clsContinent;
    $clsCountry = new Country();$assign_list['clsCountry'] = $clsCountry;
	$clsRegion = new Region();$assign_list['clsRegion'] = $clsRegion;
    $clsCity = new City();$assign_list['clsCity'] = $clsCity;
	$clsAreaCity = new AreaCity();$assign_list['clsAreaCity'] = $clsAreaCity;
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
	
	$area_city_id = isset($_GET['area_city_id']) ? $_GET['area_city_id'] : 0;
    $assign_list["area_city_id"] = $area_city_id;
	
	//print_r($city_id); die();
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
            $link.='&continent_id=' . $_POST['iso-continent_id'];
        }
		#
		if (isset($_POST['iso-area_id']) && intval($_POST['iso-area_id']) != '') {
            $link.='&area_id=' . $_POST['iso-area_id'];
        }
		#
        if (isset($_POST['country_id']) && intval($_POST['country_id']) != '0') {
            $link.='&country_id=' . $_POST['country_id'];
        }
        #
		if (isset($_POST['region_id']) && intval($_POST['region_id']) != '0') {
            $link.='&region_id=' . $_POST['region_id'];
        }
		#
        if (isset($_POST['city_id']) && intval($_POST['city_id']) != '0' && intval($_POST['country_id']) != '0') {
            $link.='&city_id=' . $_POST['city_id'];
        }
		if (isset($_POST['area_city_id']) && intval($_POST['area_city_id']) != '0') {
            $link.='&area_city_id=' . $_POST['area_city_id'];
        }
		#
        if (isset($_POST['star']) && intval($_POST['star']) != '0') {
            $link.='&star=' . $_POST['star'];
        }
		#
        if (isset($_POST['hotel_rating']) && intval($_POST['hotel_rating']) != '0') {
            $link.='&hotel_rating=' . $_POST['hotel_rating'];
        }
		#
        if ($_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    // Get Parameter fiter
    $classTable = "Hotel";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $cond = "1=1";
    #-- $continent_id
    if (intval($continent_id) > 0) {
        $cond.=" and continent_id='$continent_id'";
    }
	#-- $area_id
	if (intval($area_id) > 0) {
        $cond.=" and area_id='$area_id'";
    }
	#-- $country_id
    if (intval($country_id) > 0) {
        $cond.=" and country_id='$country_id'";
    }
    #-- $region_id
    if (intval($region_id) > 0) {
        $cond.=" and region_id='$region_id'";
    }
	if (intval($city_id) > 0) {
        $cond.=" and city_id='$city_id'";
    }
	if (intval($area_city_id) > 0) {
        $cond.=" and area_city_id='$area_city_id'";
    }
	#-- $star
    if (intval($star) > 0) {
        $cond.=" and star_id='$star'";
    }
	#-- $hotel_rating
    if (intval($hotel_rating) > 0) {
        $cond.=" and hotel_rating='$hotel_rating'";
    }
    if ($keyword != '') {
        $slug = 'slug';
        $cond.=" and $slug like '%" . $core->replaceSpace($keyword) . "%'";
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
	if(isset($_POST['submit'])){
		if($_POST['submit']=='UpdateHotel'){
			foreach($_POST as $key=>$val){
				$tmp = explode('-',$key);
				if($tmp[0]=='iso'){
					$clsConfiguration->updateValue($tmp[1],$val);
				}
			}
			header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&message=UpdateSuccess');
		}
	}
}
function default_edit() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsISO;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration,$pvalTable,$clsClassTable;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #
	$clsProperty = new Property();$assign_list["clsProperty"] = $clsProperty;
	$clsHotelCustomField = new HotelCustomField();
    $clsHotelProperty = new HotelProperty();$assign_list['clsHotelProperty'] = $clsHotelProperty;
	$clsContinent = new Continent();$assign_list['clsContinent'] = $clsContinent;
    $clsCountry = new Country();$assign_list['clsCountry'] = $clsCountry;
	$clsAreaCity = new AreaCity();$assign_list['clsAreaCity'] = $clsAreaCity;
	$clsAttraction = new Attraction();$assign_list['clsAttraction'] = $clsAttraction;
	$clsHotelAttraction = new HotelAttraction();$assign_list['clsHotelAttraction'] = $clsHotelAttraction;
	$clsRegion = new Region();$assign_list['clsRegion'] = $clsRegion;
	$clsHotelStore = new HotelStore();$assign_list['clsHotelStore'] = $clsHotelStore;
    $clsCity = new City();$assign_list['clsCity'] = $clsCity;
    #
    $country_id = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;
    $city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : '';
    $star = isset($_GET['star']) ? $_GET['star'] : '';
    #
    $pUrl = '';
    if(isset($country_id) && intval($country_id) > 0) {$pUrl.='&country_id='.$country_id;}
	if(isset($city_id) && intval($city_id) > 0) {$pUrl.='&city_id='.$city_id;}
	if(isset($star) && !empty($star)) {$pUrl.='&star='.$star;}
    if ($city_id != '') {
        $pUrl.='&city_id=' . $city_id;
    }
    #
    $classTable = "Hotel";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
    #
    $continent_id = $oneItem['continent_id'];$assign_list['continent_id'] = $continent_id;
    $country_id = $oneItem['country_id'];$assign_list['country_id'] = $country_id;
	$area_id = $oneItem['area_id'];$assign_list['area_id'] = $area_id;
    $city_id = $oneItem['city_id'];$assign_list['city_id'] = $city_id;
	$area_city_id = $oneItem['area_city_id'];$assign_list['area_city_id'] = $area_city_id;
	
    #
    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;
	#
    $clsForm->addInputTextArea("full", "intro", "", "intro", 255, 25, 8, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "intro_area", "", "intro_area", 255, 25, 8, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", "content", "", "content", 255, 25, 15, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", "note", "", "note", 255, 25, 2, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", "hotel_booking_policy", "", "hotel_booking_policy", 255, 25, 2, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "move", "", "move", 255, 25, 8, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "instructions", "", "instructions", 255, 25, 8, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full", "surcharge", "", "surcharge", 255, 25, 8, 1, "style='width:100%'");
    #-------------Update Config Meta
    $clsMeta = new Meta();
    $assign_list["clsMeta"] = $clsMeta;
    $linkMeta = $clsClassTable->getLink($pvalTable);
    $allMeta = $clsMeta->getAll("config_link='$linkMeta'");
    $meta_id = $allMeta[0]['meta_id'];
    $assign_list["meta_id"] = $meta_id;
	$assign_list["oneMeta"] = $clsMeta->getOne($meta_id);
  	#=========================================#
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
		$auto_price_avg=$_POST['auto_price_avg']?$_POST['auto_price_avg']:0;
		$price_avg=$_POST['price_avg']?$clsISO->processSmartNumber($_POST['price_avg']):0;
		
        $value .= ",slug='" . $clsISO->replaceSpace($_POST["iso-title"])."'";
        $value .= ",upd_date='".time()."',user_update_id='".$user_id."',star_id='".$_POST['star_id']."'";
        $value .= ",price_avg='". $price_avg."'";
		$value .= ",auto_price_avg='". $auto_price_avg."'";
		
		#- Update Custom Field
		if($clsConfiguration->getValue("SiteHasCustomField_Hotel")){
			$clsHotelCustomField = new HotelCustomField();
			$listCustomField = $clsHotelCustomField->getAll("fieldtype='CUSTOM' and hotel_id='$pvalTable' order by order_no ASC");
			if(is_array($listCustomField) && count($listCustomField) > 0){
				for($i=0; $i<count($listCustomField); $i++){
					$set = "fieldvalue='".addslashes($_POST['Site_Custom_Field_value_'.$listCustomField[$i][$clsHotelCustomField->pkey]])."'";
	
                    $clsHotelCustomField->updateOne($listCustomField[$i][$clsHotelCustomField->pkey],$set);
				}
			}
			unset($listCustomField);
			unset($set);
		}
        $clsHotelAttraction = new HotelAttraction();
		if($area_city_id>0){
        $listAttraction = $clsAttraction->getAll("is_trash=0 and city_id='$city_id' and area_city_id='$area_city_id' order by order_no DESC");
		}else{
		$listAttraction = $clsAttraction->getAll("is_trash=0 and city_id='$city_id' order by order_no DESC");
		}
        if (is_array($listAttraction) && count($listAttraction) > 0) {
        foreach ($listAttraction as $k => $v) {
            $fx = "user_id,user_id_update,hotel_id,city_id,area_city_id,fieldvalue,$clsHotelAttraction->pkey,order_no,reg_date,upd_date,attraction_id";
    		$vx = "'$user_id','$user_id','$pvalTable','$city_id','$area_city_id','".addslashes($_POST['hotel_attraction_'.$pvalTable.$v[$clsAttraction->pkey]])."','".$pvalTable.$v[$clsAttraction->pkey]."','".$clsAttraction->getMaxOrderNo()."','".time()."','".time()."','".$v[$clsAttraction->pkey]."'";
            $clsHotelAttraction->insertOne($fx,$vx);
            
            }
        }
        
        /*if(is_array($listAttraction) && count($listAttraction) > 0){
			for($j=0; $j<count($listAttraction); $j++){
    		$fx = "user_id,user_id_update,hotel_id,fieldvalue,$clsHotelAttraction->pkey,order_no,reg_date,upd_date,attraction_id";
    		$vx = "'$user_id','$user_id','$pvalTable','".addslashes($_POST['hotel_attraction_'.$pvalTable.$listAttraction[$j][$clsAttraction->pkey]])."','".$pvalTable.$listAttraction[$j][$clsAttraction->pkey]."','".$clsAttraction->getMaxOrderNo()."','".time()."','".time()."','".$listAttraction[$j][$clsAttraction->pkey]."'";
            print_r($fx.'<br/>'.$vx); die();
            $clsHotelAttraction->insertOne($fx,$vx);
    		}
        }*/
        
        

		$clsHotelAttraction = new HotelAttraction();
		$listHotelAttraction = $clsHotelAttraction->getAll("hotel_id='$pvalTable' order by order_no ASC");
		if(is_array($listHotelAttraction) && count($listHotelAttraction) > 0){
			for($i=0; $i<count($listHotelAttraction); $i++){
				$set = "fieldvalue='".addslashes($_POST['hotel_attraction_'.$listHotelAttraction[$i][$clsHotelAttraction->pkey]])."'";
                //print_r($set); die();
                $clsHotelAttraction->updateOne($listHotelAttraction[$i][$clsHotelAttraction->pkey],$set);
			}
		}
		unset($listHotelAttraction);
		unset($set);
		
        #--Special Field: image
		if(_isoman_use){
			$image = $_POST['isoman_url_image'];
			$value .= ",image='".addslashes($_POST['isoman_url_image'])."'";
		} else {
			$image = $_POST['image_src'];
			if($image!=''&&$image!='0'){
				$value .= ",image='".addslashes($image)."'";
			}
		}
		
		$value .= ",list_HotelFacilities='".$clsISO->makeSlashListFromArray($_POST['list_HotelFacilities'])."'";
		$value .= ",list_HotelFreeService='".$clsISO->makeSlashListFromArray($_POST['HotelFreeService'])."'";
		$value .= ",list_Attraction='".$clsISO->makeSlashListFromArray($_POST['list_HotelAttraction'])."'";
		
        // Save
        if (trim($pUrl) == '') {
            if(isset($_POST['iso-country_id']) && intval($_POST['iso-country_id']) > 0) {
                $pUrl.='&country_id='.$_POST['iso-country_id'];
            }
            if(isset($_POST['iso-city_id']) && intval($_POST['iso-city_id']) > 0) {
                $pUrl.='&city_id='.$_POST['iso-city_id'];
            }
        }
		//print_r($pvalTable.'<br/>'.$value); die();
        if ($clsClassTable->updateOne($pvalTable, $value)) {
           $titleMeta=$_POST['config_value_title']?addslashes($_POST['config_value_title']):addslashes($_POST['title']);
			$introMeta=strip_tags(html_entity_decode(addslashes($_POST['iso-intro'])));
			$descriptionMeta=$_POST['config_value_intro']?addslashes($_POST['config_value_intro']):substr($introMeta,0,160);
			$image_seo     = isset($_POST['image_seo_src']) ? $_POST['image_seo_src'] : '';
			if (_isoman_use) {
				$image_seo     = $_POST['isoman_url_image_seo'];
			}
			$image_seo=$image_seo?$image_seo:$image;
			if($meta_id==''){
				$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,meta_index,meta_follow","'".$linkMeta."','".$titleMeta."','".$descriptionMeta."','".$image_seo."','".time()."','".time()."','".$clsMeta->getMaxId()."','".$_POST['meta_index']."','".$_POST['meta_follow']."'");
				$allMeta = $clsMeta->getAll("config_link='".$linkMeta."'");
			}else{
				$clsMeta->updateOne($meta_id,"config_value_intro='".$descriptionMeta."',config_value_title='".$titleMeta."',image='".$image_seo."',upd_date='".time()."',meta_index='".addslashes($_POST['meta_index'])."',meta_follow='".addslashes($_POST['meta_follow'])."'");
			}
            if($_POST['button'] == '_EDIT') {
                header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&'.$clsClassTable->pkey.'='.$_GET[$clsClassTable->pkey].$pUrl.'&message=UpdateSuccess');
            }else{
                header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=UpdateSuccess');
            }
        }else{
            header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=updateFailed');
        }
    }
}
function default_trash() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Hotel";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    $star = isset($_GET['star']) ? $_GET['star'] : '';

    $link_back = '/index.php?mod=' . $mod;
    $link_back .= $country_id != '' ? '&country_id=' . $country_id : '';
    $link_back .= $city_id != '' ? '&city_id=' . $city_id : '';
    $link_back .= $star != '' ? '&star=' . $star : '';

    if ($pvalTable == "")
        header('location: ' . PCMS_URL . $link_back . '&message=notPermission');

    $set = "is_trash = 1";
    if ($clsClassTable->updateOne($pvalTable, $set)) {
        header('location: ' . PCMS_URL . $link_back . '&message=TrashSuccess');
    }
}
function default_restore() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Hotel";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    $star = isset($_GET['star']) ? $_GET['star'] : '';

    $link_back = '/index.php?mod=' . $mod;
    $link_back .= $country_id != '' ? '&country_id=' . $country_id : '';
    $link_back .= $city_id != '' ? '&city_id=' . $city_id : '';
    $link_back .= $star != '' ? '&star=' . $star : '';

    if ($pvalTable == "")
        header('location: ' . PCMS_URL . $link_back . '&message=notPermission');

    $set = "is_trash = 0";
    if ($clsClassTable->updateOne($pvalTable, $set)) {
        header('location: ' . PCMS_URL . $link_back . '&message=RestoreSuccess');
    }
}
function default_delete() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Hotel";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $oneTable = $clsClassTable->getOne($pvalTable);
    #
    $country_id = isset($_GET['country_id']) ? intval($core->decryptID($_GET['country_id'])) : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    $star = isset($_GET['star']) ? $_GET['star'] : '';
    #
    $link_back = '/index.php?mod=' . $mod;
    $link_back .= $country_id != '' ? '&country_id=' . $country_id : '';
    $link_back .= $city_id != '' ? '&city_id=' . $city_id : '';
    $link_back .= $star != '' ? '&star=' . $star : '';

    if ($pvalTable == "")
        header('location: ' . PCMS_URL . $link_back . '&message=notPermission');

    if (isset($_POST['agree']) && $_POST['agree'] == 'agree') {
        if ($clsClassTable->deleteOne($pvalTable)) {
            #- Delete Image
            $clsImage = new Image();
            //$clsImage->deleteFile($_SERVER['DOCUMENT_ROOT'].$oneTable['image']);
            $clsImage->deleteByCond("type='hotel' and table_id='$pvalTable'");
            #- Delete Room
            $clsHotelRoom = new HotelRoom();
            $clsHotelRoom->deleteByCond("hotel_id='$pvalTable'");
			
			#- Delete CustomField
			$clsHotelCustomField = new HotelCustomField();
			$clsHotelCustomField->deleteByCond("hotel_id='$pvalTable'");
			
            #- Delete Hotel Price Col
            $clsHotelPriceCol = new HotelPriceCol();
            $clsHotelPriceCol->deleteByCond("hotel_id='$pvalTable'");
            #- Delete Hotel Price Val
            $clsHotelPriceVal = new HotelPriceVal();
            $clsHotelPriceVal->deleteByCond("hotel_id='$pvalTable'");
            #
            header('location: ' . PCMS_URL . $link_back . '&message=DeleteSuccess');
        }
    }
}
function default_move() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];

    $classTable = "Hotel";
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
        $link_back.='&country_id=' . $country_id;
    }
    if ($city_id != '') {
        $where .= ' and city_id = ' . $city_id . '';
        $link_back.='&city_id=' . $city_id;
    }
    if ($star != '') {
        $where .= ' and star = ' . $star . '';
        $link_back.='&star=' . $star;
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
function default_room() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsISO;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #
	$clsHotel = new Hotel();$assign_list['clsHotel'] = $clsHotel;
	$clsHotelProperty = new HotelProperty();$assign_list['clsHotelProperty'] = $clsHotelProperty;
	$clsProperty = new Property();$assign_list['clsProperty'] = $clsProperty;
	$clsContinent = new Continent();$assign_list['clsContinent'] = $clsContinent;
    $clsCountry = new Country();$assign_list['clsCountry'] = $clsCountry;
	$clsRegion = new Region();$assign_list['clsRegion'] = $clsRegion;
    $clsCity = new City();$assign_list['clsCity'] = $clsCity;
	#
	$string = isset($_GET['hotel_id'])? ($_GET['hotel_id']) : '';
	$hotel_id = intval($core->decryptID($string));
	$assign_list["hotel_id"] = $hotel_id;
    #
    $classTable = "HotelRoom";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$lstRoomService = $clsProperty->getAll("is_trash=0 and type='RoomService' order by order_no ASC");
	$assign_list["lstRoomService"] = $lstRoomService;
	#
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	//
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
  	#=========================================#
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
		$price=isset($_POST['rate'])?$clsISO->processSmartNumber($_POST['rate']):0;
		$price_extra=isset($_POST['price_extra'])?$clsISO->processSmartNumber($_POST['price_extra']):0;
		$is_external_booking=isset($_POST['is_external_booking'])?$_POST['is_external_booking']:0;
		$is_breakfast=isset($_POST['is_breakfast'])?$_POST['is_breakfast']:0;
		$is_booking=isset($_POST['is_booking'])?$_POST['is_booking']:0;
		$is_sendrequest=isset($_POST['is_sendrequest'])?$_POST['is_sendrequest']:0;
		$is_getprice=isset($_POST['is_getprice'])?$_POST['is_getprice']:0;
		$is_cancel=isset($_POST['is_cancel'])?$_POST['is_cancel']:0;
		
		#
		$value .= ",price='".$price."'";
		$value .= ",price_extra='".$price_extra."'";
		$value .= ",is_external_booking='".$is_external_booking."'";
		$value .= ",is_breakfast='".$is_breakfast."'";
		$value .= ",is_booking='".$is_booking."'";
		$value .= ",is_sendrequest='".$is_sendrequest."'";
		$value .= ",is_getprice='".$is_getprice."'";
		$value .= ",is_cancel='".$is_cancel."'";
		$value .= ",user_id_update='".$user_id."'";
		$value .= ",upd_date='".time()."'";
		$value .= ",slug='".$core->replaceSpace($_POST["iso-title"])."'";
		#
		$list_RoomServices = $_POST['list_RoomServices'];
		if(!empty($list_RoomServices)){
			$list_RoomServices_slash = '';
			for ($i = 0; $i < count($list_RoomServices); $i++) {
                $list_RoomServices_slash .= '|' . $list_RoomServices[$i];
            }
			$value .= ",list_RoomServices='".addslashes($list_RoomServices_slash)."'";
		}
		#
		$list_RoomFacilities = $_POST['list_RoomFacilities'];
		if(!empty($list_RoomFacilities)){
			$list_RoomFacilities_slash = '';
			for ($i = 0; $i < count($list_RoomFacilities_slash); $i++) {
                $list_RoomFacilities_slash .= '|' . $list_RoomFacilities[$i];
            }
			$value .= ",list_RoomFacilities='".addslashes($list_RoomFacilities_slash)."'";
		}
		#
		$image_src = isset($_POST['image_src']) && $_POST['image_src'] != '' ? $_POST['image_src'] : '';
		if(_isoman_use && $image_src == ''){
			$image_src = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
		}
		if($image_src!=''&&$image_src!='0'){
			$value .= ",image='".addslashes($image_src)."'";
		}
        //print_r($value); die();
        if ($clsClassTable->updateOne($pvalTable, $value)) {
            if($_POST['button'] == '_EDIT') {
                header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&hotel_id='.$core->encryptID($hotel_id).'
				&hotel_room_id='.$core->encryptID($pvalTable).$pUrl.'&message=UpdateSuccess');
            }else{
                header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&hotel_id='.$core->encryptID($hotel_id).'&message=UpdateSuccess#isotab1');
            }
        }else{
            header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=updateFailed');
        }
    }
}
function default_review() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsISO;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #
	$clsHotel = new Hotel();$assign_list['clsHotel'] = $clsHotel;
	
	#
	$string = isset($_GET['hotel_id'])? ($_GET['hotel_id']) : '';
	$hotel_id = intval($core->decryptID($string));
	$assign_list["hotel_id"] = $hotel_id;
    #
    $classTable = "HotelReview";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	
	#
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	//
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
  	#=========================================#
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
		$value .= ",user_id_update='".$user_id."'";
		$value .= ",upd_date='".time()."'";
		$value .= ",point='".$_POST['point']."'";
		$value .= ",slug='".$core->replaceSpace($_POST["iso-title"])."'";
		
		#
		$image_src = isset($_POST['image_src']) && $_POST['image_src'] != '' ? $_POST['image_src'] : '';
		if(_isoman_use && $image_src == ''){
			$image_src = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
		}
		if($image_src!=''&&$image_src!='0'){
			$value .= ",image='".addslashes($image_src)."'";
		}
        //print_r($value); die();
        if ($clsClassTable->updateOne($pvalTable, $value)) {
            if($_POST['button'] == '_EDIT') {
                header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&hotel_id='.$core->encryptID($hotel_id).'
				&hotel_review_id='.$core->encryptID($pvalTable).$pUrl.'&message=UpdateSuccess');
            }else{
                header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&hotel_id='.$core->encryptID($hotel_id).'&message=UpdateSuccess#isotab3');
            }
        }else{
            header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=updateFailed');
        }
    }
}
function default_ajaxLoadHotelFacibility() {
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $clsProperty = new Property();
    $clsHotel = new Hotel();
    $hotel_id = $_POST['hotel_id'];

    $Html = '';
    $lstItem = $clsProperty->getAll("is_trash=0 and type='HotelFacilities' order by order_no DESC");
    if (is_array($lstItem) && count($lstItem) > 0) {
        foreach ($lstItem as $k => $v) {
            $Html.='<label class="lblcheck '.($clsHotel->checkProperty('HotelFacilities', $hotel_id, $v[$clsProperty->pkey]) ? 'lblchecked' : '') . '"><input class="hotel_fa" type="checkbox" '.($clsHotel->checkProperty('HotelFacilities', $hotel_id, $v[$clsProperty->pkey]) ? 'checked="checked"' : '') . '  name="list_HotelFacilities[]" value="' . $v[$clsProperty->pkey] . '" />&nbsp; ' . $clsProperty->getTitle($v[$clsProperty->pkey]) . '</label>';
        }
    }
	$Html .= '<label class="lblcheck">
		<a href="'.PCMS_URL.'/index.php?mod=property&type=HotelFacilities"><img src="'.URL_IMAGES.'/v2/add.png" align="absmiddle" /> '.$core->get_Lang('AddMoreHotelFacility').'</a></label>';
    echo $Html;
    die();
}
function default_ajaxLoadRoomFacibility() {
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    $clsProperty = new Property();
    $clsHotelRoom = new HotelRoom();
    $hotel_room_id = $_POST['hotel_room_id'];

    $Html = '';
    $lstItem = $clsProperty->getAll("is_trash=0 and type='RoomFacilities' order by order_no DESC");
    if (is_array($lstItem) && count($lstItem) > 0) {
        foreach ($lstItem as $k => $v) {
            $Html.='<label class="lblcheck '.($clsHotelRoom->checkProperty('RoomFacilities',$hotel_room_id, $v[$clsProperty->pkey]) ? 'lblchecked' : '') . '"><input class="hotel_fa" type="checkbox" '.($clsHotelRoom->checkProperty('RoomFacilities', $hotel_room_id, $v[$clsProperty->pkey]) ? 'checked="checked"' : '') . '  name="list_RoomFacilities[]" value="' . $v[$clsProperty->pkey] . '" />' . $clsProperty->getTitle($v[$clsProperty->pkey]) . '</label>';
        }
    }
    sleep(1);
    echo $Html;
    die();
}
function default_ajaxLoadHotelAttraction() {
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    $clsAttraction = new Attraction();
	$clsHotelAttraction = new HotelAttraction();
    $clsHotel = new Hotel();
	#
    $hotel_id = $_POST['hotel_id'];
	$city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;
	$area_city_id = isset($_POST['area_city_id']) ? intval($_POST['area_city_id']) : 0;
	if($city_id==0){
		$city_id=$clsHotel->getOnefield('city_id',$hotel_id);
	}
	
	#
    $Html = '';
	if($area_city_id>0){
    	$lstItem = $clsAttraction->getAll("is_trash=0 and city_id='$city_id' and  area_city_id='$area_city_id' order by order_no DESC");
	}else{
	$lstItem = $clsAttraction->getAll("is_trash=0 and city_id='$city_id' order by order_no DESC");
	}
   if(!empty($lstItem)){
        foreach ($lstItem as $k => $v) {
            $t=$k+1;
            $Html.='<label class="lblcheck '.($clsHotel->checkAttraction($hotel_id, $v[$clsAttraction->pkey]) ? 'lblchecked' : '') . '">
            <input class="hotel_attr" type="checkbox" '.($clsHotel->checkAttraction($hotel_id, $v[$clsAttraction->pkey]) ? 'checked="checked"' : '').'name="list_HotelAttraction[]" value="'.$v[$clsAttraction->pkey].'" /> 
            <input class="attr_fa fr" type="text" name="hotel_attraction_'.$hotel_id.$v[$clsAttraction->pkey].'" id="'.$v[$clsAttraction->pkey].'"  value="'.$clsHotelAttraction->getTitle($hotel_id.$v[$clsAttraction->pkey]).'"/>'.$clsAttraction->getTitle($v[$clsAttraction->pkey]).'</label> ';
        }
    }
	#
    echo $Html; die();
}
function default_ajChangeTableValue(){
	global $core,$_loged_id,$clsISO;
	$html = '';
	#
	$ipn = $_POST['ipn'];
	$tbl = $_POST['tbl'];
	$field_id = $_POST['field_id'];
	$pval = $_POST['pval'];
	if($ipn=='number'){
		$value = $clsISO->processSmartNumber($_POST['value']);
	}else if($ipn=='date'){
		$value = strtotime($_POST['value']);
	}else{
		$value = $_POST['value'];
	}
	$clsClassTable = new $tbl;
	$clsClassTable->updateOne($pval,$field_id."='".addslashes($value)."'");
	#
	echo($html); die();
}
function default_SiteHotelCustomField(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	$clsClassTable = new HotelCustomField();
	$hotel_customfield_id = isset($_POST['hotel_customfield_id'])?intval($_POST['hotel_customfield_id']) : 0;
	$hotel_id = isset($_POST['hotel_id'])?intval($_POST['hotel_id']) : 0;
	$hotel_room_id = isset($_POST['hotel_room_id'])? intval($_POST['hotel_room_id']) : 0;
	$type = isset($_POST['type'])?$_POST['type'] : 'CUSTOM';
	$forid = isset($_POST['forid'])?$_POST['forid'] : '';
	$tp = isset($_POST['tp']) ? $_POST['tp']: '';
	#
	if($tp=='C'){
		$idx = $clsClassTable->getAll("fieldtype='$type' and hotel_id='$hotel_id' and hotel_room_id='$hotel_room_id'")?count( $clsClassTable->getAll("fieldtype='$type' and hotel_id='$hotel_id' and hotel_room_id='$hotel_room_id'")):0;
		$title = 'Custom_Field_'.($idx+1);
		$slug = 'custom_field_'.($idx+1);
		$fx = "fieldname,fieldname_slug,fieldtype,user_id,user_id_update,hotel_id,hotel_room_id,$clsClassTable->pkey,order_no,reg_date,upd_date";
		$vx = "'$title','$slug','$type','$user_id','$user_id','$hotel_id','$hotel_room_id',
		'".$clsClassTable->getMaxID()."','".$clsClassTable->getMaxOrderNo()."','".time()."','".time()."'";
		if($clsClassTable->insertOne($fx,$vx)){
			echo('_SUCCESS'); die();
		}else{
			echo('_ERROR'); die();
		}
	}
	else if($tp=='L'){
		$listCustomField = $clsClassTable->getAll("fieldtype='$type' and hotel_id='$hotel_id' order by order_no ASC");
		$html = '';
		if(is_array($listCustomField) && count($listCustomField) > 0){
			for($i=0; $i< count($listCustomField); $i++){
				$html .= '
				<div class="row-span row-has-border" style="width:100%; margin:0 0 10px 0">
					<div class="fieldlabel" style="line-height:20px;">
						<span id="HotelCustomFieldLabel_'.$listCustomField[$i][$clsClassTable->pkey].'">'.$listCustomField[$i]['fieldname'].'</span><br />
						<div class="Site_Custom_Field_Tools" style="display:inline-block;margin-bottom:10px">
							'.($type=='CUSTOM'?'<a title="'.$core->get_Lang('edit').'" hotel_id="'.$hotel_id.'" hotel_room_id="'.$hotel_room_id.'" type="'.$type.'" forid="'.$forid.'" data="'.$listCustomField[$i][$clsClassTable->pkey].'" class="btnedit_customfield" href="javascript:void(0);"><i class="icon-pencil"></i></a>':'').'
							<a title="'.$core->get_Lang('delete').'" hotel_id="'.$hotel_id.'" hotel_room_id="'.$hotel_room_id.'" type="'.$type.'" forid="'.$forid.'" data="'.$listCustomField[$i][$clsClassTable->pkey].'" class="btndelete_customfield" href="javascript:void(0);"><i class="icon-remove"></i></a>
							'.($i==0?'':'<a title="'.$core->get_Lang('moveup').'" hotel_id="'.$hotel_id.'" hotel_room_id="'.$hotel_room_id.'" type="'.$type.'" forid="'.$forid.'" data="'.$listCustomField[$i][$clsClassTable->pkey].'" class="btnmove_customfield" direct="up" href="javascript:void(0);"><i class="icon-circle-arrow-up"></i></a>').'
							'.($i==(count($listCustomField)-1)?'':'<a title="'.$core->get_Lang('movedown').'" hotel_id="'.$hotel_id.'" hotel_room_id="'.$hotel_room_id.'" type="'.$type.'" forid="'.$forid.'" data="'.$listCustomField[$i][$clsClassTable->pkey].'" class="btnmove_customfield" direct="down" href="javascript:void(0);"><i class="icon-circle-arrow-down"></i></a>').'
						</div>
					</div>
					<div class="fieldarea">';
						if($type=='CUSTOM'){
							$html .= '<textarea style="width:100%" cols="255" rows="5" class="Site_Custom_Field_Editor Site_Custom_Field_Editor_'.$listCustomField[$i][$clsClassTable->pkey].'" id="Site_Custom_Field_'.$listCustomField[$i][$clsClassTable->pkey].'_'.time().'" name="Site_Custom_Field_value_'.$listCustomField[$i][$clsClassTable->pkey].'">'.$listCustomField[$i]['fieldvalue'].'</textarea>
							<input type="hidden" class="CustomFieldTextArea" id="'.$listCustomField[$i][$clsClassTable->pkey].'">
							';
						}else{
							$html .= '
							<div class="wrap row-has-border">
								<div class="row-span">
									<div class="fieldlabel">'.$core->get_Lang('Title').'</div>
									<div class="fieldarea">
										<input type="text" name="fieldname" value="'.$listCustomField[$i]['fieldname'].'" class="text full autosavefield" field_id="fieldname" tbl="HotelCustomField" ipn="text" pval="'.$listCustomField[$i][$clsClassTable->pkey].'" onclick="this.select();" id="HotelCustomFieldName_'.$listCustomField[$i][$clsClassTable->pkey].'" />
										<script type="text/javascript">
											$(document).on("keyup","#HotelCustomFieldName_'.$listCustomField[$i][$clsClassTable->pkey].'", function(ev){
												var $_this = $(this);
												$("#HotelCustomFieldLabel_'.$listCustomField[$i][$clsClassTable->pkey].'").text($_this.val());
											});
										</script>
									</div>
								</div>
								<div class="row-span">
									<div class="fieldlabel">'.$core->get_Lang('Value').'</div>
									<div class="fieldarea">
										<input type="text" name="fieldvalue" value="'.$listCustomField[$i]['fieldvalue'].'" class="text full autosavefield" field_id="fieldvalue" tbl="HotelCustomField" ipn="text" pval="'.$listCustomField[$i][$clsClassTable->pkey].'" />
									</div>
								</div>
								<div class="row-span">
									<div class="fieldlabel">'.$core->get_Lang('Icon').'</div>
									<div class="fieldarea">
										<input type="text" name="icon" value="'.$listCustomField[$i]['_Icon'].'" class="text full autosavefield" field_id="_Icon" tbl="HotelCustomField" ipn="text" pval="'.$listCustomField[$i][$clsClassTable->pkey].'" style="width:50%" />
										<span>Support: fonticon (eg: fa-facebook)</span>
									</div>
								</div>
							</div>
							';
						}
					$html .='</div>
				</div>';
			}
		}
		echo $html; die();
	}
	else if($tp=='D'){
		$clsClassTable->deleteOne($hotel_customfield_id);
		echo(1); die();
	}
	else if($tp=='F'){
		$html = '
		<div class="headPop"> 
			<a id="clickToCloseNewTourPriceRow" href="javascript:void();" class="closeEv close_pop">'.$core->get_Lang('close').'</a> 
			<h3>'.$core->get_Lang('editcustomfield').'</h3> 
		</div> 
		<table class="form" cellpadding="3" cellspacing="3">
			<tr>
				<td class="fieldarea">
					<input type="text" name="fieldname" class="text full fontLarge required" style="width:95%" value="'.$clsClassTable->getOneField('fieldname',$hotel_customfield_id).'">
				</td>
			</tr>
		</table>
		<div class="modal-footer"> 
			<button class="btn btn-success submitClick SiteClickUpdateFieldName" hotel_id="'.$hotel_id.'" hotel_room_id="'.$hotel_room_id.'" type="'.$type.'" forid="'.$forid.'" hotel_customfield_id="'.$hotel_customfield_id.'">'.$core->get_Lang('update').'</button> 
		</div>';
		echo($html);die();
	}
	else if($tp=='S'){
		$fieldname = $_POST['fieldname'];
		$fieldnameSlug = $core->replaceSpace($fieldname);
		if($clsClassTable->getAll("fieldtype='CUSTOM' and hotel_id='$hotel_id' and fieldname_slug='$fieldnameSlug'")!=''){
			echo '_EXIST'; die();
		}else{
			$v = "user_id_update = '$user_id',fieldname='$fieldname',fieldname_slug='$fieldnameSlug'";
			$clsClassTable->updateOne($hotel_customfield_id,$v);
			echo(1); die();
		}
	}
	else if($tp=='AUTOSAVE'){
		$listID = $_POST['listID'];
		$listContent = $_POST['listContent'];
		$_tmpID = explode('||||',$listID);
		$_tmpContent = explode('||||',$listContent);
		#
		if(!empty($_tmpID)){
			for($i=0; $i<count($_tmpID); $i++){
				$clsClassTable->updateOne($_tmpID[$i],"fieldvalue='".addslashes($_tmpContent[$i])."'");
			}
		}
		echo(1); die();
	}
	else if($tp=='M'){
		$direct = isset($_POST['direct']) ? intval($_POST['direct']) : '';
		$order_no = $clsClassTable->getOneField('order_no',$hotel_customfield_id);
		$where = "is_trash=0 and hotel_id='$hotel_id' and fieldtype='$type'";
		if($hotel_room_id > 0){
			$where .= " and hotel_room_id='$hotel_room_id'";
		}
		if($direct=='up'){
			$lst = $clsClassTable->getAll($where." and order_no < $order_no order by order_no desc limit 0,1");
			$clsClassTable->updateOne($hotel_customfield_id,"order_no='".$lst[0]['order_no']."'");
			$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='$order_no'");
		}
		if($direct=='down'){
			$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no asc limit 0,1");
			$clsClassTable->updateOne($hotel_customfield_id,"order_no='".$lst[0]['order_no']."'");
			$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='$order_no'");
		}
		echo(1); die();
	}
}
/* ======== SITE HOTEL SETTING ========== */
function default_setting(){
	global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsConfiguration, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsHotelProperty = new HotelProperty();$assign_list["clsHotelProperty"] = $clsHotelProperty;
	$clsProperty = new Property();$assign_list["clsProperty"] = $clsProperty;
	#
	if(isset($_POST['submit'])){
		foreach($_POST as $key=>$val){
			$tmp = explode('-',$key);
			if($tmp[0]=='iso'){
				$clsConfiguration->updateValue($tmp[1],$val);
			}
			if($tmp[0]=='date'){
				$clsConfiguration->updateValue($tmp[1],strtotime($val));
			}
		}
		$site_hotel_banner = $_POST['isoman_url_site_hotel_banner'];
		if($site_hotel_banner != '' && $site_hotel_banner != '0'){
			$clsConfiguration->updateValue('site_hotel_banner',$site_hotel_banner);
		}
		$extUrl = '';
		if($_POST['submit']=='UpdateConfiguration'){
			$extUrl = '#isotab0';
		}
		if($_POST['submit']=='UpdateConfiguration1'){
			$extUrl = '#isotab1';
		}
		if($_POST['submit']=='UpdateConfiguration2'){
			$extUrl = '#isotab2';
		}
		header('location:'.PCMS_URL.'?mod='.$mod.'&act='.$act.'&message=updateSuccess'.$extUrl);
	}	
}
/* ======== QUICK CREATE NEW HOTEL ========== */
function default_ajaxCreateQuickHotel() {
    global $core, $dbconn, $assign_list,$_CONFIG,$_SITE_ROOT, $mod, $act, $clsModule, $clsISO, $_LANG_ID;
    $clsClassTable = new Hotel();
    $hotel_id = isset($_POST['hotel_id'])?intval($_POST['hotel_id']):0;
	$tp = isset($_POST['tp']) ? $_POST['tp']: '';
    #
	if($tp=='F'){
		$html='<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.$core->get_Lang('Add hotels Pro').'</h3>
		</div>';
		$html .= '
		<div class="wrap">
			<div class="fl span100">
				<div class="row-span">
					<strong>'.$core->get_Lang('Enter name of hotels').'</strong><br><br>
					<em style="color:#999;">'.$core->get_Lang('After entering the name of the hotel, you will be moved to the next step to enter all the other parameters of a hotel').'</em>
					<br><br>
					<input type="text" autocomplete="off" name="title" class="text full required fontLarge" id="NewHotelTitle" placeholder="'.$core->get_Lang('ex').': '.$clsISO->getExName('Hotel').'" />
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary clickToSubmitNewHotelPro">
				<i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span>
			</button>
		</div>';
		echo($html);die();
	} 
	elseif($tp=='S') {
		$titlePost = isset($_POST['title'])?trim(addslashes($_POST['title'])):'';
    	$slugPost = $core->replaceSpace($titlePost);
		#
		if($clsClassTable->getAll("slug='$slugPost'")!=''){
			echo '_EXIST'; die();
		} else {
			$listTable=$clsClassTable->getAll("1=1", $clsClassTable->pkey.",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no=$listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey],"order_no='".$order_no."'");
			}
			$max_id = $clsClassTable->getMaxID();
			$fx = "$clsClassTable->pkey,title,slug,user_id,user_update_id,reg_date,upd_date,order_no";
			$vx = "'".$max_id."'
			,'".addslashes($titlePost)."'
			,'".$slugPost."'
			,'".$core->_USER['user_id']."'
			,'".$core->_USER['user_id']."'
			,'".time()."'
			,'".time()."'
			,'1'
			";
			#
			if($clsClassTable->insertOne($fx, $vx)){
				$clsHotelCustomField = new HotelCustomField();
				$clsHotelCustomField->initCustomField($max_id);
				#
				echo(PCMS_URL.'/index.php?mod='.$mod.'&act=edit&'.$clsClassTable->pkey.'='.$core->encryptID($max_id));die();
			}else{
				echo '_ERROR'; die();
			}
		}
	}
}
function default_ajaxCreateQuickHotelRoom() {
    global $core, $dbconn, $assign_list,$_CONFIG,$_SITE_ROOT, $mod, $act, $clsModule, $clsISO, $_LANG_ID;
    $clsClassTable = new HotelRoom();
	$hotel_id = isset($_POST['hotel_id'])?intval($_POST['hotel_id']):'';
	$tp = isset($_POST['tp']) ? $_POST['tp']: '';
    #		
	if($tp=='S') {
		$titlePost = $_POST['title'];
    	$slugPost = $core->replaceSpace($titlePost);
		#
		if($clsClassTable->getAll("hotel_id='$hotel_id' and slug='$slugPost'")!=''){
			echo '_EXIST'; die();
		} else {
			$fx = "hotel_room_id,hotel_id,title,slug,reg_date,upd_date,order_no";
			$hotel_room_id = $clsClassTable->getMaxID();
			#
			$vx = "'$hotel_room_id'
			,'".$hotel_id."'
			,'".addslashes($titlePost)."'
			,'".$slugPost."'
			,'".time()."'
			,'".time()."
			','".$clsClassTable->getMaxOrderNo()."'";
			#
			if($clsClassTable->insertOne($fx, $vx)){
				echo(PCMS_URL.'/index.php?mod='.$mod.'&act=room&hotel_id='.$core->encryptID($hotel_id).'&hotel_room_id='.$core->encryptID($hotel_room_id));die();
			}else{
				echo '_ERROR'; die();
			}
		}
	}
}
function default_ajUpdateHotelVr3() {
    $clsClassTable = new Hotel();
    #
    $tp = $_POST['tp'];
    $tp_order = $_POST['tp_order'];
    $hotel_id = $_POST['hotel_id'];
    $val = $_POST['val'];
    #
    if ($val == 1) {
        $all = $clsClassTable->getAll("1=1 order by $tp_order DESC LIMIT 0,1");
        $max_order_tp = intval($all[0][$tp_order]) + 1;
        $clsClassTable->updateOne($hotel_id, "$tp='1',$tp_order='$max_order_tp'");
    } else {
        $clsClassTable->updateOne($hotel_id, "$tp='0',$tp_order='0'");
    }
    echo $tp;
    die();
}

function default_ajLoadHotelPriceShow() {
    global $core, $clsISO;
    $hotel_id = $_POST['hotel_id'];
    $clsHotelPriceRow = new HotelPriceRow();
    $clsHotelPriceCol = new HotelPriceCol();
    $clsHotelPriceVal = new HotelPriceVal();
    #
    $lstHotelPriceRow = $clsHotelPriceRow->getAll("hotel_id='$hotel_id' order by order_no asc");
    $lstHotelPriceCol = $clsHotelPriceCol->getAll("hotel_id='$hotel_id' order by order_no asc");
    #
    $html = '<table class="tbl-grid" width="100%">
	<thead>
		<tr>
			<th></th>
			';
    for ($k = 0; $k < count($lstHotelPriceCol); $k++) {
        $html.= '<th style="text-align:center;">
			<a class="editHotelPriceCol" href="#" data="' . $lstHotelPriceCol[$k]['hotel_price_col_id'] . '"><strong>' . $lstHotelPriceCol[$k]['title'] . '</strong></a>
			
		</th>';
    }
    $html.= '
		<th style="width:80px;"></th>                                  
		</tr>
	</thead>
	';
    if ($lstHotelPriceRow[0]['hotel_price_row_id'] != '') {
        for ($i = 0; $i < count($lstHotelPriceRow); $i++) {
            $html .= '
			<tr>
				<td style="text-align:center;">
					<a class="editHotelPriceRow" href="#" data="' . $lstHotelPriceRow[$i]['hotel_price_row_id'] . '"><strong>' . $lstHotelPriceRow[$i]['title'] . '</strong></a>
				</td>
				
		';
            for ($k = 0; $k < count($lstHotelPriceCol); $k++) {
                $html.= '<td style="text-align:center;">
				<a class="editHotelPriceVal" hotel_price_col_id="' . $lstHotelPriceCol[$k]['hotel_price_col_id'] . '" hotel_price_row_id="' . $lstHotelPriceRow[$i]['hotel_price_row_id'] . '" href="#">
				<strong style="color:red;">' . $clsHotelPriceVal->getPrice($lstHotelPriceRow[$i]['hotel_price_row_id'], $lstHotelPriceCol[$k]['hotel_price_col_id']) . '</strong> ' . $clsISO->getRate() . '
				</a>
				</td>';
            }
            $html .='<td style="text-align:right;"></td></tr>';
        }
        $html .= '<tr><td></td><td></td></tr>';
    }
    $html .= '<table>';
    #
    echo($html);
    die();
}
// HOTEL PRICE
function default_ajaxLoadHotelPrice() {
    global $core,$_LANG_ID, $clsISO;
    #
    $hotel_id = $_POST['hotel_id'];
    $clsHotelPriceRow = new HotelPriceRow();
    $clsHotelPriceCol = new HotelPriceCol();
    $clsHotelPriceVal = new HotelPriceVal();
    $clsHotelRoom = new HotelRoom();
    #
    $lstHotelRow = $clsHotelRoom->getAll("hotel_id='$hotel_id' order by order_no desc");
    $lstHotelPriceCol = $clsHotelPriceCol->getAll("hotel_id='$hotel_id' order by order_no asc");
    #
    if ($lstHotelRow[0]['hotel_room_id'] != '') {
        $html = '<table class="tbl-grid" cellpadding="0" width="100%">
				<thead>
					<tr>
						<td class="gridheader" style="text-align:left"><strong>'.$core->get_Lang('Name of rooms').'</strong></td>';
        for ($k = 0; $k < count($lstHotelPriceCol); $k++) {
            $html.= '
							<td class="gridheader">
								<a class="editHotelPriceCol" href="#" data="' . $lstHotelPriceCol[$k]['hotel_price_col_id'] . '">
									<strong>' . $lstHotelPriceCol[$k]['title'] . '</strong>
								</a>
							</td>';
        }
        $html.= '<td class="gridheader"><strong></strong></td>';
        $html.= '<td class="gridheader"><strong>'.$core->get_Lang('func').'</strong></td>';
        $html.= '</tr>
				</thead>';
        for ($i = 0; $i < count($lstHotelRow); $i++) {
            $class = ($i % 2 == 0) ? 'row1' : 'row2';
            $html .= '
			<tr class="' . $class . '">
				<td style="text-align:left;">
					<a class="editHotelPriceRoom" href="#" data="' . $lstHotelRow[$i]['hotel_room_id'] . '"><strong style="font-size:14px">' . $lstHotelRow[$i]['title'] . '</strong></a>
				</td>';
            for ($k = 0; $k < count($lstHotelPriceCol); $k++) {
                $html.= '<td style="text-align:center;">
				<a class="editHotelPriceVal" hotel_price_col_id="' . $lstHotelPriceCol[$k]['hotel_price_col_id'] . '" hotel_price_row_id="' . $lstHotelRow[$i]['hotel_room_id'] . '" href="#"><strong style="color:red; font-size:14px">' . $clsISO->getRate() . ' ' . $clsHotelPriceVal->getPrice($lstHotelRow[$i]['hotel_room_id'], $lstHotelPriceCol[$k]['hotel_price_col_id']) . '</strong></a>
				</td>';
            }
            $html .='
			<td style="text-align:center;">
				' . ($i == 0 ? '' : '<a class="moveHotelPriceRoom" direct="up" data="' . $lstHotelRow[$i]['hotel_room_id'] . '" href="#"><span class="icon-arrow-up"></span></a>
				') . '
				' . ($i == count($lstHotelRow) - 1 ? '' : '<a class="moveHotelPriceRoom" direct="down" data="' . $lstHotelRow[$i]['hotel_room_id'] . '" href="#"><span class="icon-arrow-down"></span></a>
			') . '
			</td>';
            $html .='
			<td style="text-align:center; width:60px">
				<a class="editHotelPriceRoom" data="' . $lstHotelRow[$i]['hotel_room_id'] . '" href="#"><span class="icon-pencil"></span></a>
				<a class="deleteHotelPriceRoom" data="' . $lstHotelRow[$i]['hotel_room_id'] . '" href="#"><span class="icon-remove"></span></a>
				</td>
			</tr>';
        }
        $html .= '
		<tr>
			<td></td>';
        for ($k = 0; $k < count($lstHotelPriceCol); $k++) {
            $html.='
			<td style="text-align:center;">
				' . ($k == 0 ? '' : '<a title="Move Left" class="moveHotelPriceCol" href="#" data="' . $lstHotelPriceCol[$k]['hotel_price_col_id'] . '" direct="left"><span class="icon-chevron-left"></span></a>
				') . '
				<a title="Edit" class="editHotelPriceCol" href="#" data="' . $lstHotelPriceCol[$k]['hotel_price_col_id'] . '"><span class="icon-pencil"></span></a>
				<a title="Delete" class="deleteHotelPriceCol" data="' . $lstHotelPriceCol[$k]['hotel_price_col_id'] . '" href="#"><span class="icon-remove"></span></a>
				' . ($k == count($lstHotelPriceCol) - 1 ? '' : '<a title="Move Right" class="moveHotelPriceCol" href="#" data="' . $lstHotelPriceCol[$k]['hotel_price_col_id'] . '" direct="right"><span class="icon-chevron-right"></span></a>
			') . '
				</td>';
        }
        $html.='<td colspan="2"></td>';
        $html.='</tr></table>';
    } else {
        $html = '<div class="infobox">
		         	<b>Warning</b><br>
					Chưa có dữ liệu
				 </div>';
    }
    #
    echo($html);
    die();
}
function default_ajLoadNewHotelPriceRow() {
    global $core;
    $hotel_id = $_POST['hotel_id'];
    #
    $html = '
	<div class="headPop"> 
		<a id="clickToCloseNewHotelPriceRow" class="closeEv close_pop" data-dismiss="modal" aria-hidden="true">&nbsp;</a>
		<h3>'.$core->get_Lang('Add new room').'</h3> 
	</div> 
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea"><input type="text" id="titleRow" class="text full fontLarge required" placeholder="'.$core->get_Lang('Enter name of rooms').'" style="width:95%"></td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button class="btn btn-primary submitClick" hotel_id="'.$hotel_id.'" id="clickToAddHotelPriceRow">'.$core->get_Lang('save').'</button> 
	</div>';
    echo($html);
    die();
}
function default_ajAddHotelPriceRow() {
    global $core, $_frontIsLoggedin_user_id, $_LANG_ID;
    #
    $clsHotelRoom = new HotelRoom();
	#
    $hotel_id = isset($_POST['hotel_id'])?intval($_POST['hotel_id']):0;
    $titlePost = isset($_POST['title'])?addslashes($_POST['title']):'';
    $slugPost = $core->replaceSpace($titlePost);

    $all = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' and slug='$slugPost' limit 0,1");
    if (!empty($all)) {
        echo '_EXIST'; die();
    } else {
        $f = "$clsHotelRoom->pkey,title,slug,hotel_id,reg_date,upd_date,order_no";
        $v = "'".$clsHotelRoom->getMaxID()."','$titlePost','$slugPost','$hotel_id','".time()."','".time()."','".$clsHotelRoom->getMaxOrderNo()."'";
        if ($clsHotelRoom->insertOne($f, $v)) {
            echo '_SUCCESS'; die();
        } else {
            echo '_ERROR'; die();
        }
    }
}

/* ========= SITE HOTEL PRICE COL ========= */
function default_ajLoadNewHotelPriceCol() {
    global $core;
    $hotel_id = $_POST['hotel_id'];
    #
    $html = '
	<div class="headPop"> 
		<a id="clickToCloseNewHotelPriceCol" class="closeEv close_pop" data-dismiss="modal" aria-hidden="true">&nbsp;</a> 
		<h3>'.$core->get_Lang('Add new column').'</h3> 
	</div> 
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea"><input type="text" id="titleCol" class="text full fontLarge required" style="width:95%" placeholder="'.$core->get_Lang('Enter name of column').'..."></td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button class="btn btn-primary submitClick" hotel_id="' . $hotel_id . '" id="clickToAddHotelPriceCol">'.$core->get_Lang('save').'</button> 
	</div>
	';
    echo($html);
    die();
}
function default_ajAddHotelPriceCol() {
    global $core, $clsModule, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $clsHotelPriceCol = new HotelPriceCol();
    $title = 'title';
    #
    $all = $clsHotelPriceCol->getAll("hotel_id='" . $_POST['hotel_id'] . "' and $title='" . addslashes($_POST['title']) . "' limit 0,1");
    if (!empty($all)) {
        
    } else {
        $f = "hotel_id,user_id,order_no";
        $v = "'" . $_POST['hotel_id'] . "','$user_id','" . $clsHotelPriceCol->getMaxOrderNo() . "'";
        $f .="," . $title;
        $v .=",'" . addslashes($_POST['title']) . "'";
        #
        if ($clsHotelPriceCol->insertOne($f, $v)) {
            echo("_IN_SUCCESS");
            die();
        } else {
            echo "ERROR";
            die();
        }
    }
}
function default_ajDeleteHotelPriceCol() {
    $clsHotelPriceCol = new HotelPriceCol();
    #
    $id = $_POST['id'];
    $clsHotelPriceCol->deleteOne($id);
    $clsHotelPriceVal = new HotelPriceVal();
    $clsHotelPriceVal->deleteByCond("hotel_price_col_id='$id'");
    echo(1);
    die();
}
function default_ajLoadEditHotelPriceCol() {
    global $core, $_LANG_ID;
    #
    $clsHotelPriceCol = new HotelPriceCol();
    $id = $_POST['id'];
    $oneItem = $clsHotelPriceCol->getOne($id);
    #
    $html = '
	<div class="headPop"> 
		<a id="clickToCloseEditHotelPriceCol" class="closeEv close_pop" data-dismiss="modal" aria-hidden="true">&nbsp;</a>
		<h3>'.$core->get_Lang('editpricecol').'</h3> 
	</div> 
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea">
				<input type="text" id="titleCol" class="text fontLarge full" style="width:95%" value="' . $oneItem['title'] . '">
			</td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button class="btn btn-primary submitClick" data="' . $id . '" id="clickToEditHotelPriceCol">'.$core->get_Lang('save').'</button>
	</div>';
    echo($html);
    die();
}
function default_ajUpdateHotelPriceCol() {
    global $core, $_LANG_ID;
    #
    $clsHotelPriceCol = new HotelPriceCol();
    $id = $_POST['id'];
    $title = 'title';
    $clsHotelPriceCol->updateOne($id, $title . "='" . addslashes($_POST['title']) . "'");
    echo(1);
    die();
}
function default_ajDeleteHotelPriceRoom() {
    $id = $_POST['id'];
    $clsHotelRoom = new HotelRoom();
    $clsHotelRoom->deleteOne($id);
    $clsHotelPriceVal = new HotelPriceVal();
    $clsHotelPriceVal->deleteByCond("hotel_price_row_id='$id'");
    echo(1);
    die();
}
function default_ajLoadEditHotelPriceRoom() {
    global $core;
    #
    $clsHotelRoom = new HotelRoom();
    $id = $_POST['id'];
    $oneItem = $clsHotelRoom->getOne($id);
    #
    $html = '
	<div class="headPop"> 
		<a id="clickToCloseEditHotelRoom" class="closeEv close_pop" data-dismiss="modal" aria-hidden="true">&nbsp;</a>
		<h3>'.$core->get_Lang('Edit Hotel Room').'</h3> 
	</div> 
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea">
				<input type="text" id="titleRow" class="required fontLarge text full" value="'.$clsHotelRoom->getTitle($id).'">
			</td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button class="btn btn-primary submitClick" data="'.$id.'" id="clickToEditHotelPriceRow">'.$core->get_Lang('save').'</button> 
	</div>';
    echo($html);
    die();
}
function default_ajUpdateHotelPriceRow() {
    global $core, $_LANG_ID;
    #
    $clsHotelRoom = new HotelRoom();

    $titlePost = $_POST['title'];
    $slugPost = $core->replaceSpace($titlePost);
    $id = $_POST['id'];
    #
    $set = "title='$titlePost',slug='$slugPost'";
    $clsHotelRoom->updateOne($id, $set);
    echo(1);die();
}
function default_ajLoadEditHotelPriceVal() {
    global $core;
    $clsISO = new ISO();
    #
    $clsHotelRoom = new HotelRoom();
    $clsHotelPriceCol = new HotelPriceCol();
    #
    $hotel_price_col_id = $_POST['hotel_price_col_id'];
    $hotel_price_row_id = $_POST['hotel_price_row_id'];
    $clsHotelPriceVal = new HotelPriceVal();
    #
    $all = $clsHotelPriceVal->getAll("hotel_price_row_id='$hotel_price_row_id' and hotel_price_col_id='$hotel_price_col_id' limit 0,1");
    #
    $html = '<div class="headPop"> 
		<a id="clickToCloseUpdatePriceRoom" class="closeEv close_pop" data-dismiss="modal">&nbsp;</a>
		<h3>'.$core->get_Lang('editprice').' - ' . $clsHotelRoom->getTitle($hotel_price_row_id) . '</h3> 
	</div>
	<div class="fl span100">
		<div class="row-span">
			<input type="text" class="text full required" style="font-size:14px; width:155px;" id="titleVal" value="' . $all[0]['price'] . '"> ' . $clsISO->getRate() . ' 
			<br>
			Hoặc <a style="color:red;" class="ajCopyPriceHotel" href="#" tour_cruise_price_row_id="329" tour_id="" tour_cruise_price_col_id="730">copy từ giá gốc</a> 
		</div>
	</div>
	<div class="modal-footer"> 
		<button class="btn btn-primary submitClick" hotel_price_row_id="' . $hotel_price_row_id . '" hotel_price_col_id="' . $hotel_price_col_id . '" id="clickToEditHotelPriceVal">'.$core->get_Lang('save').'</button>  
	</div>';
    echo($html);
    die();
}
function default_ajUpdateHotelPriceVal() {
    $clsISO = new ISO();
    $clsHotelPriceVal = new HotelPriceVal();
    #
    $hotel_id = $_POST['hotel_id'];
    $hotel_price_col_id = $_POST['hotel_price_col_id'];
    $hotel_price_row_id = $_POST['hotel_price_row_id'];
    #
    $all = $clsHotelPriceVal->getAll("hotel_price_row_id='$hotel_price_row_id' and hotel_price_col_id='$hotel_price_col_id' limit 0,1");
    #
    if ($all[0]['hotel_price_val_id'] != '') {
        $clsHotelPriceVal->updateOne($all[0]['hotel_price_val_id'], "price='" . $clsISO->processSmartNumber($_POST['price']) . "'");
    } else {
        $f = "hotel_id,hotel_price_row_id,hotel_price_col_id,price";
        $v = "'" . $hotel_id . "','" . $hotel_price_row_id . "','" . $hotel_price_col_id . "','" . $_POST['price'] . "'";
        $clsHotelPriceVal->insertOne($f, $v);
    }
    echo(1);
    die();
}
function default_ajMoveHotelPriceCol() {
    $id = $_POST['id'];
    $direct = $_POST['direct'];
    $clsHotelPriceCol = new HotelPriceCol();
    $one = $clsHotelPriceCol->getOne($id);
    $hotel_id = $one['hotel_id'];
    #
    $order_no = $one['order_no'];
    if ($direct == 'left') {
        $lst = $clsHotelPriceCol->getAll("hotel_id='$hotel_id' and order_no<$order_no order by order_no desc limit 0,1");
        $clsHotelPriceCol->updateOne($id, "order_no='" . $lst[0]['order_no'] . "'");
        $clsHotelPriceCol->updateOne($lst[0][$clsHotelPriceCol->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'right') {
        $lst = $clsHotelPriceCol->getAll("hotel_id='$hotel_id' and order_no>$order_no order by order_no asc limit 0,1");
        $clsHotelPriceCol->updateOne($id, "order_no='" . $lst[0]['order_no'] . "'");
        $clsHotelPriceCol->updateOne($lst[0][$clsHotelPriceCol->pkey], "order_no='" . $order_no . "'");
    }
    #
    echo(1);
    die();
}
function default_ajMoveHotelPriceRow() {
    $id = $_POST['id'];
    $direct = $_POST['direct'];
    #
    $clsHotelRoom = new HotelRoom();
    $one = $clsHotelRoom->getOne($id);
    $hotel_id = $one['hotel_id'];
    #
    $order_no = $one['order_no'];
    if ($direct == 'down') {
        $lst = $clsHotelRoom->getAll("hotel_id='$hotel_id' and order_no<$order_no order by order_no desc limit 0,1");
        $clsHotelRoom->updateOne($id, "order_no='" . $lst[0]['order_no'] . "'");
        $clsHotelRoom->updateOne($lst[0][$clsHotelRoom->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'up') {
        $lst = $clsHotelRoom->getAll("hotel_id='$hotel_id' and order_no>$order_no order by order_no asc limit 0,1");
        $clsHotelRoom->updateOne($id, "order_no='" . $lst[0]['order_no'] . "'");
        $clsHotelRoom->updateOne($lst[0][$clsHotelRoom->pkey], "order_no='" . $order_no . "'");
    }
    #
    echo(1);
    die();
}

function default_ajCheckHotelRoomAvailable() {
    $clsHotelRoom = new HotelRoom();
    $hotel_id = $_POST['hotel_id'];
    $res = $clsHotelRoom->getAll("hotel_id='$hotel_id'");
    echo!empty($res) ? count($res) : 0;
    die();
}
// HOTEL REVIEW
function default_ajaxLoadHotelReview() {
    global $core,$mod,$act,$P;
    $clsHotel = new Hotel();
    $clsHotelReview = new HotelReview();
    #
    $hotel_id = $_POST['hotel_id'];
    $html = '';
    $lstReview = $clsHotelReview->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no desc");
    if (!empty($lstReview)) {
        $i = 0;
        foreach ($lstReview as $item) {
            $html.='<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $html.='<td class="index">' . ($i + 1) . '</td>';
            $html.='<td style="width:60px;"><img src="'.$item['image'].'" width="60px" height="40px" /></td>';
						$html.='<td><a class="clickEditHotelReview" data="' . $item[$clsHotelReview->pkey] . '" href="javascript:;"><strong style="font-size:14px">' . $clsHotelReview->getName($item[$clsHotelReview->pkey]) . '</strong></a></td>';
            $html.='<td><a class="clickEditHotelReview" data="' . $item[$clsHotelReview->pkey] . '" href="javascript:;"><strong style="font-size:14px">' . $clsHotelReview->getTitle($item[$clsHotelReview->pkey]) . '</strong></a></td>';
            $html.='<td style="vertical-align: middle;text-align:center">
				' . ($i == 0 ? '' : '<a title="'.$core->get_Lang('movetop').'"  direct="movetop" class="ajmoveHotelReview" hotel_id="' . $hotel_id . '" data="' . $item[$clsHotelReview->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
			</td>
			
			<td style="vertical-align: middle;text-align:center">
				' . ($i == count($lstReview) - 1 ? '' : '<a title="'.$core->get_Lang('movebottom').'" class="ajmoveHotelReview" direct="movebottom" hotel_id="' . $hotel_id . '" data="' . $item[$clsHotelReview->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
			</td>
			
			<td style="vertical-align: middle;text-align:center">
				' . ($i == 0 ? '' : '<a title="'.$core->get_Lang('moveup').'" class="ajmoveHotelReview" direct="moveup" hotel_id="' . $hotel_id . '" data="' . $item[$clsHotelReview->pkey] . '" href="javascript:void();"><i class="icon-arrow-up"></i></a>') . '
			</td>
			
			<td style="vertical-align: middle;text-align:center">
				' . ($i == count($lstReview) - 1 ? '' : '<a title="'.$core->get_Lang('movedown').'" class="ajmoveHotelReview" direct="movedown" hotel_id="' . $hotel_id . '" data="' . $item[$clsHotelReview->pkey] . '" href="javascript:void();"><i class="icon-arrow-down"></i></a>') . '
			</td>';

            $html.='
			<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                <div class="btn-group">
                    <button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
                    <ul class="dropdown-menu" style="right:0px !important">
                        <li><a href="'.PCMS_URL.'/?mod='.$mod.'&act=review&hotel_id='.$core->encryptID($hotel_id).'&hotel_review_id='.$core->encryptID($item[$clsHotelReview->pkey]).'" class="" title="'.$core->get_Lang('edit').'" data="'.$item[$clsHotelReview->pkey].'" hotel_id="'.$hotel_id.'"><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
                        <li><a  class="clickDeleteHotelReview" title="'.$core->get_Lang('delete').'" data="'.$item[$clsHotelReview->pkey].'" hotel_id="'.$hotel_id.'"><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
                    </ul>
                </div>
            </td>';
            $html.='</tr>';
            ++$i;
        }
    }
    echo $html;
    die();
}
function default_ajaxCreateQuickHotelReview() {
    global $core, $dbconn, $assign_list,$_CONFIG,$_SITE_ROOT, $mod, $act, $clsModule, $clsISO, $_LANG_ID;
    $clsClassTable = new HotelReview();
	$hotel_id = isset($_POST['hotel_id'])?intval($_POST['hotel_id']):'';
	$tp = isset($_POST['tp']) ? $_POST['tp']: '';
    #		
	if($tp=='S') {
		$titlePost = $_POST['title'];
    	$slugPost = $core->replaceSpace($titlePost);
		#
		if($clsClassTable->getAll("hotel_id='$hotel_id' and slug='$slugPost'")!=''){
			echo '_EXIST'; die();
		} else {
			$fx = "hotel_review_id,hotel_id,title,slug,reg_date,upd_date,order_no";
			$hotel_review_id = $clsClassTable->getMaxID();
			#
			$vx = "'$hotel_review_id'
			,'".$hotel_id."'
			,'".addslashes($titlePost)."'
			,'".$slugPost."'
			,'".time()."'
			,'".time()."
			','".$clsClassTable->getMaxOrderNo()."'";
			#
			if($clsClassTable->insertOne($fx, $vx)){
				echo(PCMS_URL.'/index.php?mod='.$mod.'&act=review&hotel_id='.$core->encryptID($hotel_id).'&hotel_review_id='.$core->encryptID($hotel_review_id));die();
			}else{
				echo '_ERROR'; die();
			}
		}
	}
}
function default_ajDeleteHotelReviewImage() {
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    $clsHotelReview = new HotelReview();
    $hotel_review_id = $_POST['hotel_review_id'];
    $clsHotelReview->updateOne($hotel_review_id, "image=''");
    echo($clsHotelReview->getOneField('image', $hotel_review_id));
    die();
}
function default_ajDeleteHotelReview() {
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO; 
	$clsHotelReview = new HotelReview();
	#
	$hotel_review_id = intval($_POST['hotel_review_id']);
	if($hotel_review_id==0){
		echo '_invalid';
		die();
	}
	#delete main
	$clsHotelReview->deleteOne($hotel_review_id);
	echo(1); die();
}

// HOTEL ROOM
function default_ajaxLoadHotelRoom() {
    global $core,$mod,$act,$P;
    $clsHotel = new Hotel();
    $clsHotelRoom = new HotelRoom();
    #
    $hotel_id = $_POST['hotel_id'];
    $html = '';
    $lstRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no desc");
    if (!empty($lstRoom)) {
        $i = 0;
        foreach ($lstRoom as $item) {
			if($clsHotelRoom->getNumberChild($item[$clsHotelRoom->pkey])==0){
			$number_people=$clsHotelRoom->getNumberAdult($item[$clsHotelRoom->pkey]);
			}else{
			$number_people=$clsHotelRoom->getNumberAdult($item[$clsHotelRoom->pkey]).$clsHotelRoom->getNumberChild($item[$clsHotelRoom->pkey]);
			}
			
            $html.='<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $html.='<td class="index">' . ($i + 1) . '</td>';
            $html.='<td style="width:60px;"><img src="'.$item['image'].'" width="60px" height="40px" /></td>';

            $html.='<td><a class="clickEditHotelRoom" data="' . $item[$clsHotelRoom->pkey] . '" href="javascript:;"><strong style="font-size:14px">' . $clsHotelRoom->getTitle($item[$clsHotelRoom->pkey]) . '</strong></a></td>';

            $html.='<td><a class="clickEditHotelRoom" data="' . $item[$clsHotelRoom->pkey] . '" href="javascript:;"><strong style="font-size:14px"><img src="' . URL_IMAGES . '/people/icon_child_' .$number_people. '.png" height="16px" /></strong></a></td>';

            $html.='<td style="vertical-align: middle;text-align:center">
				' . ($i == 0 ? '' : '<a title="'.$core->get_Lang('movetop').'"  direct="movetop" class="ajmoveHotelRoom" hotel_id="' . $hotel_id . '" data="' . $item[$clsHotelRoom->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
			</td>
			
			<td style="vertical-align: middle;text-align:center">
				' . ($i == count($lstRoom) - 1 ? '' : '<a title="'.$core->get_Lang('movebottom').'" class="ajmoveHotelRoom" direct="movebottom" hotel_id="' . $hotel_id . '" data="' . $item[$clsHotelRoom->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
			</td>
			
			<td style="vertical-align: middle;text-align:center">
				' . ($i == 0 ? '' : '<a title="'.$core->get_Lang('moveup').'" class="ajmoveHotelRoom" direct="moveup" hotel_id="' . $hotel_id . '" data="' . $item[$clsHotelRoom->pkey] . '" href="javascript:void();"><i class="icon-arrow-up"></i></a>') . '
			</td>
			
			<td style="vertical-align: middle;text-align:center">
				' . ($i == count($lstRoom) - 1 ? '' : '<a title="'.$core->get_Lang('movedown').'" class="ajmoveHotelRoom" direct="movedown" hotel_id="' . $hotel_id . '" data="' . $item[$clsHotelRoom->pkey] . '" href="javascript:void();"><i class="icon-arrow-down"></i></a>') . '
			</td>';

            $html.='
			<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                <div class="btn-group">
                    <button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
                    <ul class="dropdown-menu" style="right:0px !important">
                        <li><a href="'.PCMS_URL.'/?mod='.$mod.'&act=room&hotel_id='.$core->encryptID($hotel_id).'&hotel_room_id='.$core->encryptID($item[$clsHotelRoom->pkey]).'" class="" title="'.$core->get_Lang('edit').'" data="'.$item[$clsHotelRoom->pkey].'" hotel_id="'.$hotel_id.'"><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
                        <li><a  class="clickDeleteHotelRoom" title="'.$core->get_Lang('delete').'" data="'.$item[$clsHotelRoom->pkey].'" hotel_id="'.$hotel_id.'"><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
                    </ul>
                </div>
            </td>';
            $html.='</tr>';
            ++$i;
        }
    }
    echo $html;
    die();
}
function default_ajaxFrmHotelRoom() {
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO;
    global $_lang;
    #
	$clsHotel = new Hotel();
    $clsHotelRoom = new HotelRoom();
    $clsHotelProperty = new HotelProperty();
    $hotel_id = (isset($_POST['hotel_id']) ? $_POST['hotel_id'] : 0);
    $hotel_room_id = isset($_POST['hotel_room_id']) ? $_POST['hotel_room_id'] : 0;
    #
	$HTML_ROOM_FACILITY = '';
    if (intval($hotel_room_id) == 0) {
        $listRoomFacilities = $clsHotelProperty ->getAll("is_trash=0 and type='RoomFacilities' order by order_no asc", $clsHotelProperty->pkey);
        if (!empty($listRoomFacilities)) {
            foreach ($listRoomFacilities as $k => $v) {
                $HTML_ROOM_FACILITY .= '<option value="'.$v[$clsHotelProperty->pkey].'">' . $clsHotelProperty->getTitle($v[$clsHotelProperty->pkey]) . '</option>';
            }
			unset($listRoomFacilities);
        }
    } else {
        $RoomFacilities = $clsHotelRoom->getOneField('list_RoomFacilities', $hotel_room_id);
        $listRoomFacilities = $clsHotelProperty->getAll("is_trash=0 and type='RoomFacilities' order by order_no asc", $clsHotelProperty->pkey);
        if (!empty($listRoomFacilities)) {
            foreach ($listRoomFacilities as $k => $v) {
                $HTML_ROOM_FACILITY .= '<option ' . ($clsHotelRoom->checkRoomFacility($v[$clsHotelProperty->pkey], $RoomFacilities) ? 'selected="selected"' : '') . ' value="' . $v[$clsHotelProperty->pkey] . '">' . $clsHotelProperty->getTitle($v[$clsHotelProperty->pkey]) . '</option>';
            }
			unset($listRoomFacilities);
        }
    }
	#
	$HTML_ROOM_SERVICES = '';
    if (intval($hotel_room_id) == 0) {
        $listRoomServices = $clsHotelProperty ->getAll("is_trash=0 and type='FreeService' order by order_no asc", $clsHotelProperty->pkey);
        if (!empty($listRoomServices)) {
            foreach ($listRoomServices as $k => $v) {
                $HTML_ROOM_SERVICES .= '<option value="'.$v[$clsHotelProperty->pkey].'">' . $clsHotelProperty->getTitle($v[$clsHotelProperty->pkey]) . '</option>';
            }
			unset($listRoomServices);
        }
    } else {
        $RoomServices = $clsHotelRoom->getOneField('list_RoomServices', $hotel_room_id);
        $listRoomServices = $clsHotelProperty->getAll("is_trash=0 and type='FreeService' order by order_no asc", $clsHotelProperty->pkey);
        if (!empty($listRoomServices)) {
            foreach ($listRoomServices as $k => $v) {
                $HTML_ROOM_SERVICES .= '<option ' . ($clsHotelRoom->checkRoomFacility($v[$clsHotelProperty->pkey], $RoomServices) ? 'selected="selected"' : '') . ' value="' . $v[$clsHotelProperty->pkey] . '">' . $clsHotelProperty->getTitle($v[$clsHotelProperty->pkey]) . '</option>';
            }
			unset($listRoomFacilities);
        }
    }
    #
    $html = '';
    $html.='
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('Close').'"></a>
		<h3>' . (intval($hotel_room_id) == 0 ? $core->get_Lang('Add Room').' - ' . $clsHotel->getTitle($hotel_id) : $core->get_Lang('Update').': <u>' . $clsHotelRoom->getTitle($hotel_room_id) . '</u>') . '</h3>
	</div>';
    $html .= '
	<style>.mceToolbar table{ background:transparent;}</style>
	<form method="post" class="frmform" enctype="multipart/form-data" id="frmHotelRoom">
		<table border="0" class="form" cellspacing="2" cellpadding="2" style="width:100%">
			<tbody>
				<tr>
					<td width="136px" rowspan="4" style="vertical-align:top;">
						 <div class="photobox_160 image">
						 	<img src="'.$clsHotelRoom->getOneField('image',$hotel_room_id).'" id="isoman_show_image_room" />
							<input type="hidden" id="isoman_hidden_image_room" name="isoman_url_image" value="'.$clsHotelRoom->getOneField('image',$hotel_room_id).'" />
							<a href="javascript:void(0);" title="'.$core->get_Lang('Change').'" class="photobox_edit ajOpenDialog" isoman_for_id="image_room" isoman_val="'.$clsHotelRoom->getOneField('image',$hotel_room_id).'" isoman_name="image">
								<i class="iso-edit"></i>
							</a>
							'.($clsHotelRoom->getOneField('image',$hotel_room_id) != '' ? '<a pvalTable="'.$hotel_room_id.'" clsTable="HotelRoom" href="javascript:void()" title="'.$core->get_Lang('delete').'" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>' : '') . '
						</div>
					</td>
					<td width="15%" class="fieldarea">'.$core->get_Lang('nameofroom').' <font color="#c00000">*</font>:</td>
					<td class="fieldarea" colspan="5">
						<input type="text" class="text full required" name="hotel_room_title" value="' . $clsHotelRoom->getTitle($hotel_room_id) . '" />
					</td>
				</tr>
				<tr>
					<td width="8%" class="fieldarea">'.$core->get_Lang('rates').':</td>
					<td class="fieldarea">
						<input type="text" class="price text full" style=" width:70%" value="' . $clsHotelRoom->getOneField('rate_room', $hotel_room_id) . '" name="rate_room">' . $clsISO->getRate() . '
					</td>
					<td width="12%" class="fieldarea">'.$core->get_Lang('extrabed').':</td>
					<td class="fieldarea">
						<input type="text" class="price text full" style=" width:70%" value="' . $clsHotelRoom->getOneField('extra_bed', $hotel_room_id) . '" name="extra_bed">' . $clsISO->getRate() . '
					</td>
				</tr>
				<tr>
					<td width="8%" class="fieldarea">'.$core->get_Lang('Guest in room').':</td>
					<td class="fieldarea">
						<select class="slb full" name="number_people" style="width:100px">
							' . $clsISO->makeSelectNumber2(5, $clsHotelRoom->getOneField('number_people', $hotel_room_id)) . '
						</select>
					</td>
					<td width="12%" class="fieldarea">'.$core->get_Lang('Total Rooms').':</td>
					<td class="fieldarea">
						<input type="number" class="text full" style=" width:90%" value="' . $clsHotelRoom->getOneField('number_room', $hotel_room_id) . '" name="number_room">
					</td>
				</tr>
				<tr>
					<td width="15%" class="fieldarea">'.$core->get_Lang('roomservice').':
						<button type="button" fromid="pop_HotelRoom" style="margin-top:-6px" class="iso-button-small fr ajaxManagerHotelProperty" forid="' . $hotel_room_id . '" _type="FreeService">...</button>
					</td>
					<td class="fieldarea" colspan="5">
						<select class="selectbox" name="room_services[]" multiple="true">
							'.$HTML_ROOM_SERVICES.'
						</select>
					</td>
				</tr>
				<tr>
					<td width="15%" class="fieldarea">'.$core->get_Lang('roomfacilities').':
						<button type="button" fromid="pop_HotelRoom" style="margin-top:-6px" class="iso-button-small fr ajaxManagerHotelProperty" forid="' . $hotel_room_id . '" _type="RoomFacilities">...</button>
					</td>
					<td class="fieldarea" colspan="6" style="vertical-align:top">
						<select class="selectbox" name="room_facility[]" multiple="true">
							'.$HTML_ROOM_FACILITY.'
						</select>
					</td>
				</tr>
				<tr> 
					<td class="fieldarea" valign="top">'.$core->get_Lang('Description').' <font color="#c00000">*</font></td> 
					<td class="fieldarea" colspan="6">
						<textarea id="textarea_content_editor' . time() . '" rows="2" class="textarea_content_editor" style="width:99%">' . $clsHotelRoom->getIntro($hotel_room_id) . '</textarea>
					</td>  
				</tr>
			</tbody>
		</table>
		<div class="modal-footer" style="text-align:center"> 
			<button type="submit" hotel_room_id="' . $hotel_room_id . '" hotel_id="' . $hotel_id . '" id="clickSubmitHotelRoom" class="btn btn-primary submitClick"><i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span></button> 
			<button type="reset" class="btn btn-warning close_pop"> <i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span> </button> 
		</div>
	</form>';
    #
    echo($html);
    die();
}
function default_ajDeleteHotelRoomImage() {
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    $clsHotelRoom = new HotelRoom();
    $hotel_room_id = $_POST['hotel_room_id'];
    $clsHotelRoom->updateOne($hotel_room_id, "image=''");
    echo($clsHotelRoom->getOneField('image', $hotel_room_id));
    die();
}
function default_ajaxSubmitHotelRoom() {
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO;
    #
    $clsHotel = new Hotel();
    $clsHotelRoom = new HotelRoom();
    #
    $hotel_room_id = $_POST['hotel_room_id'];
    $hotel_id = $_POST['hotel_id'];
    $titlePost = $_POST['hotel_room_title'];
    $slugPost = $core->replaceSpace($titlePost);
    $number_room = $_POST['number_room'];
    $rate_room = $clsISO->processSmartNumber($_POST['rate_room']);
	$extra_bed = $clsISO->processSmartNumber($_POST['extra_bed']);
    $number_people = $_POST['number_people'];
    $room_facility = isset($_POST['room_facility']) ? $_POST['room_facility'] : 0;
	$room_services = isset($_POST['room_services']) ? $_POST['room_services'] : 0;
    $rate_notePost = $_POST['rate_note'];
    $rate_includePost = $_POST['rate_include'];
    $imagePost = addslashes($_POST['image']);
    $introPost = addslashes($_POST['intro']);
    #
    $list_RoomFacilities = '';
    if (!empty($room_facility)) {
        for ($i = 0; $i < count($room_facility); $i++) {
            $list_RoomFacilities .= '|' . $room_facility[$i];
        }
    }
	#
	$list_RoomServices = '';
    if (!empty($room_services)) {
        for ($i = 0; $i < count($room_services); $i++) {
            $list_RoomServices .= '|' . $room_services[$i];
        }
    }
    #
    if (intval($hotel_room_id) == 0) {
        $all = $clsHotelRoom->checkExist($hotel_id, $slugPost);
        if (!empty($all)) {
            echo('_EXIST'); die();
        } else {
            #
            $f = "title,slug,intro,rate_note,rate_include,list_RoomFacilities,list_RoomServices,number_room,rate_room,extra_bed";
            $f.=",number_people,reg_date,upd_date,order_no,hotel_id,image";
            $v = "'".addslashes($titlePost) . "','".$slugPost."','$introPost','".addslashes($rate_notePost)."'";
            $v.=",'".addslashes($rate_includePost)."','$list_RoomFacilities','$list_RoomServices','$number_room','$rate_room'";
            $v.=",'$extra_bed','$number_people','".time()."','".time()."','$order_no','$hotel_id','$imagePost'";
            #
            if ($clsHotelRoom->insertOne($f, $v)) {
                echo('_IN_SUCCESS'); die();
            } else {
                echo('_ERROR'); die();
            }
        }
    } else {
        $v = "title='" . addslashes($_POST['hotel_room_title']) . "'
			,slug='" . $core->replaceSpace($_POST['hotel_room_title']) . "'
			,intro='$introPost'
			,list_RoomFacilities='$list_RoomFacilities'
			,list_RoomServices='$list_RoomServices'
			,number_room='" . $number_room . "'
			,rate_room='$rate_room'
			,extra_bed='$extra_bed'
			,number_people='" . $number_people . "'
			,reg_date='" . time() . "'
			,rate_note='" . addslashes($rate_notePost) . "'
			,rate_include='" . addslashes($rate_includePost) . "'
			,image='" . addslashes($imagePost) . "'";
        #
        if ($clsHotelRoom->updateOne($hotel_room_id, $v)) {
            echo('_UPDATE_SUCCESS'); die();
        } else {
            echo('_ERROR'); die();
        }
    }
}
function default_ajDeleteHotelRoom() {
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO; 
	$clsHotelRoom = new HotelRoom();
	$clsAvailbility = new Availbility();
	$clsHotelImage = new HotelImage();
	$clsHotelCustomField = new HotelCustomField();
	#
	$hotel_room_id = intval($_POST['hotel_room_id']);
	if($hotel_room_id==0){
		echo '_invalid';
		die();
	}
	#delete availbility
	$clsAvailbility->deleteByCond("target_id='$hotel_room_id' and type='_ROOM'");
	#delete Image
	$clsHotelImage->deleteByCond("table_id='$hotel_room_id' and type='_ROOM'");
	#delete customfield
	$clsHotelCustomField->deleteByCond("hotel_room_id='$hotel_room_id' and fieldtype='ADDFACILITY'");
	#delete main
	$clsHotelRoom->deleteOne($hotel_room_id);
	echo(1); die();
}
function default_ajCheckHotelPriceCol() {
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO;
    #
    $clsHotelPriceCol = new HotelPriceCol();
    $hotel_id = $_POST['hotel_id'];
    #
    echo $clsHotelPriceCol->getAll("hotel_id='$hotel_id'")?count($clsHotelPriceCol->getAll("hotel_id='$hotel_id'")):0;
    die();
}

function default_ajMoveHotelRoom() {
    $clsHotelRoom = new HotelRoom();
    $html = '';
    #
    $hotel_room_id = (isset($_POST['hotel_room_id']) ? $_POST['hotel_room_id'] : 0);
    $direct = (isset($_POST['direct'])) ? $_POST['direct'] : '';
    $hotel_id = (isset($_POST['hotel_id'])) ? $_POST['hotel_id'] : 0;
    $one = $clsHotelRoom->getOne($hotel_room_id);
    $order_no = $one['order_no'];
    #
    switch ($direct) {
        case 'movetop':
            $lst = $clsHotelRoom->getAll("hotel_id='$hotel_id' and order_no >$order_no order by order_no asc");
            $clsHotelRoom->updateOne($hotel_room_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            unset($lst);
            $lst = $clsHotelRoom->getAll("hotel_room_id<>'$hotel_room_id' and hotel_id='$hotel_id' and order_no>$order_no order by order_no asc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsHotelRoom->updateOne($lst[$i][$clsHotelRoom->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
                }
            }
            break;
        case 'movebottom':
            $lst = $clsHotelRoom->getAll("hotel_id='$hotel_id' and order_no<$order_no order by order_no desc");
            $clsHotelRoom->updateOne($hotel_room_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            unset($lst);
            $lst = $clsHotelRoom->getAll("hotel_room_id<>'$hotel_room_id' and hotel_id='$hotel_id' and order_no<$order_no order by order_no desc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsHotelRoom->updateOne($lst[$i][$clsHotelRoom->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
                }
            }
            break;
        case 'moveup':
            $lst = $clsHotelRoom->getAll("hotel_id='$hotel_id' and order_no>$order_no order by order_no asc limit 0,1");
            $clsHotelRoom->updateOne($hotel_room_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsHotelRoom->updateOne($lst[0][$clsHotelRoom->pkey], "order_no='" . $order_no . "'");
            break;
        case 'movedown':
            $lst = $clsHotelRoom->getAll("hotel_id='$hotel_id' and order_no<$order_no order by order_no desc limit 0,1");
            $clsHotelRoom->updateOne($hotel_room_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsHotelRoom->updateOne($lst[0][$clsHotelRoom->pkey], "order_no='" . $order_no . "'");
            break;
    }
    echo(1);
    die();
}
/* ========= SITE HOTEL PROPERTY ========= */
function default_property(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	
	$classTable = "HotelProperty";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$listType = $clsClassTable->getListType();
	$assign_list["listType"] = $listType;
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	if($type==''){
		header('location: '.PCMS_URL.'/index.php?mod='.$mod.'&act=property&type='.$listType['HotelFacilities'].'');
		exit();
	}
	$assign_list["type"] = $type;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = '&act=property';
		$link .= '&type='.$type;
		if(isset($_POST['parent_id']) && $_POST['parent_id']!=''){
			$link .= '&parent_id='.$_POST['parent_id'];
		}
		if($_POST['keyword']!=''&&$_POST['keyword']!='Transport title, intro'){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	$cond = "1='1'";
	$cond .= " and type='$type'";
	#Filter By Keyword
	if(isset($_GET['keyword']) && $_GET['keyword']!=''){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and slug like '%".$keyword."%'";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$cond2 = $cond;
	if($type_list=='Active'){
		$cond .= " and is_trash=0";
	}
	if($type_list=='Trash'){
		$cond .= " and is_trash=1";
	}
	$orderBy = " order_no DESC";
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='type_list')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	$allItem = $clsClassTable->getAll($cond." order by ".$orderBy.$limit);
	//print_r($allItem);die();
	$assign_list["allItem"] = $allItem;
	#
	$allTrash =  $clsClassTable->getAll("is_trash=1 and ".$cond2);
	$assign_list["number_trash"] = $allTrash[0][$pkeyTable]!=''?count($allTrash):0;
	#
	$allUnTrash =  $clsClassTable->getAll("is_trash=0 and ".$cond2);
	$assign_list["number_item"] = $allUnTrash[0][$pkeyTable]!=''?count($allUnTrash):0;
	#
	$allAll =  $clsClassTable->getAll($cond2);
	$assign_list["number_all"] = $allAll[0][$pkeyTable]!=''?count($allAll):0;
}
function default_move_property(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "HotelProperty";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable])? $_GET[$pkeyTable] : "";
	$direct = isset($_GET['direct'])? $_GET['direct']:'';
	
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;
	
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	
	if($pvalTable == "" || $direct==''){
		header('location: '.PCMS_URL.'/?mod='.$mod);
	}
	if($direct=='moveup'){
		$lst = $clsClassTable->getAll("1=1 and type = '$type' and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movedown'){
		$lst = $clsClassTable->getAll("1=1 and type = '$type' and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movetop'){
		$lst = $clsClassTable->getAll("1=1 and type = '$type' order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$clsClassTable->updateOne($lst[count($lst)-1][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movebottom'){
		$lst = $clsClassTable->getAll("1=1 and type = '$type' order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$clsClassTable->updateOne($lst[count($lst)-1][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	header('location: '.PCMS_URL.'/?mod='.$mod.'&act=property&type='.$type.'&message=PositionSuccess');
}
function default_ajSiteHotelProperty(){
	global $core;
	#
	$clsHotelProperty =new HotelProperty();
	$type = isset($_POST['type'])? $_POST['type']: '';
	$hotel_property_id = isset($_POST['hotel_property_id']) ? intval($_POST['hotel_property_id']) : 0;
	$parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	#
	if($tp == 'F') {
		$html = '
		<div class="headPop">
			<a href="javascript:void();" title="'.$core->get_Lang('close').'" class="closeEv close_pop">&nbsp;</a>
			<h3 id="myModalLabel">'.$core->get_Lang('edit').' '.$clsHotelProperty->getTextByType($type).'</h3> 
		</div>
		<table class="form" cellpadding="3" cellspacing="3">
			<tr>
				<td class="fieldlabel span15">'.$core->get_Lang('title').'</label>
				<td class="fieldarea">
					<input type="text" name="title_HotelProperty" value="'.$clsHotelProperty->getTitle($hotel_property_id).'" class="fontLarge full text">
				</td>
			</tr>
			<tr>
				<td class="fieldlabel span15">'.$core->get_Lang('type').'</label>
				<td class="fieldarea">
					<select class="slbHighlight" id="type" name="type_HotelProperty">
						'.$clsHotelProperty->getSelectByType($type).'
					</select>
				</td>
			</tr>
			<tr>
				<td class="fieldlabel span15">'.$core->get_Lang('intro').'</label>
				<td class="fieldarea">
					<textarea class="textarea full" rows="5" name="intro_HotelProperty">'.$clsHotelProperty->getIntro($hotel_property_id).'</textarea>
				</td>
			</tr>
			
		</table>
		<div class="modal-footer"> 
			<button class="btn btn-primary clickSubmitProperty" hotel_property_id="'.$hotel_property_id.'">
				'.$core->get_Lang('save').'
			</button> 
			<button class="btn btn-warning close_pop" data-dismiss="modal" aria-hidden="true">'.$core->get_Lang('close').'</button> 
		</div>';
		echo($html);die();
	} elseif($tp == 'S') {
		$titlePost 	= isset($_POST['title'])?trim(addslashes($_POST['title'])):'';
		$introPost 	= isset($_POST['intro'])?addslashes($_POST['intro']):'';
		$slugPost 	= $core->replaceSpace($titlePost);
		#
		if(intval($hotel_property_id)==0){
			if($clsHotelProperty->getAll("slug='$slugPost' and type='$type'")!=''){
				echo('EXIST'); die();
			}else{
				$fx = "$clsHotelProperty->pkey,title,slug,intro,order_no,type";
				$vx = "'".$clsHotelProperty->getMaxID()."','".$titlePost."','$slugPost','".$introPost."','".$clsHotelProperty->getMaxOrderNo()."','$type'";
				if($clsHotelProperty->insertOne($fx,$vx)){
					echo('IN_SUCCESS'); die();
				}else{
					echo('ERROR'); die();
				}
			}
		}else{
			$set = "title='$titlePost',slug='$slugPost',intro='".addslashes($introPost)."',type='$type'";
			if($clsHotelProperty->updateOne($hotel_property_id,$set)){
				echo('UP_SUCCESS'); die();
			}else{
				echo('ERROR'); die();
			}
		}
	} elseif($tp == 'D') {
		$clsHotelProperty->deleteOne($hotel_property_id);
		echo(1); die();
	}
}
function default_ajGetBoxManagerHotelProperty() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsHotelProperty = new HotelProperty();
	$fromid = isset($_POST['fromid']) ? $_POST['fromid'] : 0;
	$forid = isset($_POST['forid']) ? $_POST['forid'] : 0;
	$hotel_property_id = isset($_POST['hotel_property_id']) ? $_POST['hotel_property_id'] : 0;
	$type = (isset($_POST['type'])) ? $_POST['type'] : 0;
	$tp = isset($_POST['tp'])?$_POST['tp']:'';
	
	if($tp == 'L') {
		#
		$html = '<div class="headPop">
					<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
					<h3>'.$core->get_Lang('management').' - ' . $type . '</h3>
				</div>
				<div class="contentPop" style="max-height:355px">
					<table class="tbl-grid">
						<thead><tr>
				<td class="gridheader"><strong>'.$core->get_Lang('index').'</strong></td>
				<td class="gridheader" style="text-align:left"><strong>'.$core->get_Lang('title').'</strong></td>
				<td class="gridheader" style="text-align:center;"><strong>'.$core->get_Lang('func').'</strong></td>
			</tr>
		</thead>';
		$html.='<tbody id="tblHolderPropertyPop">';
		$lstItem = $clsHotelProperty->getAll("is_trash=0 and type='$type' order by order_no DESC", $clsHotelProperty->pkey);
		if (!empty($lstItem)) {
			$i = 0;
			foreach ($lstItem as $item) {
				$html.='<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
				$html.='<td class="index">'.($i+1).'</td>';
				$html.='<td><a class="edit_pop_hotel_property" _type="'.$type.'" title="'.$clsHotelProperty->getTitle($item[$clsHotelProperty->pkey]).'" data="'.$item[$clsHotelProperty->pkey].'" fromid="'.$fromid.'" forid="'.$forid.'" href="javascript:;"><strong style="font-size:14px">'.$clsHotelProperty->getTitle($item[$clsHotelProperty->pkey]).'</strong></a></td>';
				$html.='
					<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" style="right:0px !important">
								<li><a class="edit_pop_hotel_property" title="'.$core->get_Lang('edit').'" href="javascript:void();" _type="'.$type.'" fromid="'.$fromid.'" forid="'.$forid.'" data="'.$item[$clsHotelProperty->pkey].'"><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
								<li><a class="delete_pop_hotel_property" title="'.$core->get_Lang('delete').'" href="javascript:void();" _type="'.$type.'" fromid="'.$fromid.'" forid="'.$forid.'" data="'.$item[$clsHotelProperty->pkey].'"><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
							</ul>
						</div>
					</td>
				';
				$html.='</tr>';
				++$i;
			}
		}
		$html.='</tbody>';
		$html.='</table>';
		$html.='</div>';
		$html.='
		<div class="bottom" unselectable="on" style="-moz-user-select: none;">
			<a parent_id="59" type="'.$type.'" fromid="'.$fromid.'" forid="'.$forid.'" id="btnCreateNewHotelProperty" class="iso-button-primary fr"><i class="icon-plus-sign"></i> '.$core->get_Lang('add').'</a>
		</div>';
		echo $html; die();
	} elseif($tp == 'F') {
		#
		$oneTable = $clsHotelProperty->getOne($hotel_property_id);
		if(!empty($oneTable['type'])) {$type = $oneTable['type'];}
		#
		$html = '';
		$html.='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('Close').'"></a>
			<h3>' . (intval($hotel_property_id) == 0 ? $core->get_Lang('Add new').' - ' . $type : $core->get_Lang('Update').' - ' . $clsHotelProperty->getTitle($hotel_property_id)) . '</h3>
		</div>';
		$html.='
		<table class="form" cellpadding="3" cellspacing="3">
			<tr>
				<td class="fieldarea">
					<input type="text" placeholder="'.$core->get_Lang('Enter title').'" name="title" class="text full required fontLarge" value="' . $clsHotelProperty->getTitle($hotel_property_id) . '" style="width:95%">
				</td>
			</tr>
		</table>
		<div class="modal-footer"> 
			<button type="button" class="btn btn-primary submitClick" _type="'.$type.'" hotel_property_id="'.$hotel_property_id.'" fromid="'.$fromid.'" forid="'.$forid.'" id="ajaxSaveHotelProperty">'.$core->get_Lang('save').'</button>
		</div>';
		echo $html; die();
	} elseif($tp == 'S') {
		#
		$titlePost = isset($_POST['title'])?addslashes($_POST['title']):'';
		$slugPost = $core->replaceSpace($titlePost);
		#
		if(intval($hotel_property_id) == 0) {
			$res = $clsHotelProperty->getAll("slug='$slugPost' and type='$type' limit 0,1");
			if (!empty($res)) {
				echo('EXIST'); die();
			} else {
				$f = "$clsHotelProperty->pkey,title,slug,order_no,type";
				$v = "'".$clsHotelProperty->getMaxID()."','$titlePost','$slugPost','".$clsHotelProperty->getMaxOrderNo()."','$type'";
				if($clsHotelProperty->insertOne($f, $v)) {
					echo('IN_SUCCESS'); die();
				} else {
					echo('ERROR'); die();
				}
			}
		} else {
			$set = "title='$titlePost',slug='$slugPost'";
			if ($clsHotelProperty->updateOne($hotel_property_id, $set)) {
				echo('UP_SUCCESS'); die();
			} else {
				echo('ERROR'); die();
			}
		}
	} elseif($tp == 'D') {
    	$clsHotelProperty->deleteOne($hotel_property_id);
    	echo(1); die();
	}
}
function default_ajLoadTableHotelProperty() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsHotelProperty = new HotelProperty();
    $type = isset($_POST['type'])?$_POST['type']:'';
    $fromid = isset($_POST['fromid'])?$_POST['fromid']:'';
    $forid = isset($_POST['forid'])?intval($_POST['forid']):0;

    $lstItem = $clsHotelProperty->getAll("is_trash=0 and type='$type' order by order_no DESC", $clsHotelProperty->pkey);
    $Html = '';

    if (is_array($lstItem) && count($lstItem) > 0) {
        for($i = 0; $i < count($lstItem); $i++) {
            $Html.='<tr class="'.($i % 2 == 0 ? 'row1' : 'row2').'">';
            $Html.='<td class="index">' . ($i + 1) . '</td>';

            $Html.='<td><a class="edit_pop_hotel_property" _type="' . $type . '" title="'.$core->get_Lang('edit').'" data="' . $lstItem[$i][$clsHotelProperty->pkey] . '" fromid="' . $fromid . '" forid="' . $forid . '" href="javascript:;"><strong style="font-size:14px">' . $clsHotelProperty->getTitle($lstItem[$i][$clsHotelProperty->pkey]) . '</strong></a></td>';

            $Html.='
				<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a class="edit_pop_hotel_property" title="'.$core->get_Lang('edit').'" href="javascript:void();" _type="'.$type.'" fromid="'.$fromid.'" forid="'.$forid.'" data="'.$lstItem[$i][$clsHotelProperty->pkey].'"><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
							<li><a class="delete_pop_hotel_property" title="'.$core->get_Lang('delete').'" href="javascript:void();" _type="'.$type.'" fromid="'.$fromid.'" forid="'.$forid.'" data="'.$lstItem[$i][$clsHotelProperty->pkey].'"><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
						</ul>
					</div>
				</td>
			';
            $Html.='</tr>';
        }
    }
    echo $Html; die();
}
/* ========= SITE HOTEL GALERRY ========= */
function default_ajaxInitPhotosGallery() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $clsHotelImage = new HotelImage();
    $table_id = $_POST['table_id'];
	$type = $_POST['type'];
    #
    $html = '';
    $html.='
	<div class="wrap">
		<div class="group_button fl">
			<form method="post" action="" accept="application/pdf" id="aj-upload-form" enctype="multipart/form-data">
				<input style="display:none" type="file" multiple="" name="image[]" id="ajAttachFile" />
				<a style="display:none" id="ajSysPhotosGallery" table_id="'.$table_id.'" type="'.$type.'" class="iso-button-primary fl mr10">
					<i class="icon-random"></i>&nbsp; '.$core->get_Lang('synchronizeposition').'
				</a>
				<a table_id="'.$table_id.'" type="'.$type.'" isoman_multiple="1" class="iso-button-standard ajOpenDialog fl" isoman_for_id="image_val" isoman_name="image">
					<i class="icon-plus-sign"></i>&nbsp; '.$core->get_Lang('addimages').'
				</a>
				<span style="white-space:nowrap;float:left;margin-left:10px;padding-top:6px;">'.$core->get_Lang('autoaddimage').'</span>
				<input type="hidden" value="'.$table_id.'" name="table_id" id="Hid_TableID"/>
				<input type="hidden" value="'.$type.'" name="type" id="Hid_TypeID"/>
			</form>
		</div>
	</div>';
    $html.='
	<div class="clearfix"><br /></div>
	<div class="hastable">
    	<table class="tbl-grid" cellpadding="0" cellspacing="0">
    		<thead>
				<tr>
					<td class="gridheader"><strong>'.$core->get_Lang('index').'</strong></td>
					<td class="gridheader"><strong>'.$core->get_Lang('images').'</strong></td>
					<td class="gridheader" style="text-align:left;"><strong>'.$core->get_Lang('alttext').'</strong></td>
					<td class="gridheader" style="width:15%"><strong>'.$core->get_Lang('update').'</strong></td>
					<td class="gridheader" style="width:3%" colspan="4"><strong>'.$core->get_Lang('move').'</strong></td>
					<td class="gridheader" style="width:75px;"><strong>'.$core->get_Lang('func').'</strong></td>
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
    $html.='
	<script type="text/javascript">
		$(function(){
			checkSysPosition();
			$(document).on(\'click\', \'.ajdeletePhotosGallery\', function(ev){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				var $type = $(\'#Hid_TypeID\').val();
				var $page = $(\'#Hid_CurrentPage\').val();
				if(confirm(confirm_delete)){
					 $.ajax({
						type: "POST",
						url: path_ajax_script+"/index.php?mod=hotelpro&act=ajSysPhotosGallery",
						data: {\'tp\':\'D\', \'hotel_image_id\': $_this.attr(\'data\')},
						dataType: "html",
						success: function(html){
							loadTableGallery($table_id,\'\',1,10);
							checkSysPosition();
						}
					});
				}
				return false;
			});
			$(document).on(\'click\', \'.ajeditPhotosGallery\', function(ev){
				var $_this = $(this);
				var $hotel_image_id = $_this.attr(\'data\');
				var $table_id = $_this.attr(\'table_id\');
				var $type = $_this.attr(\'type\');
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod=hotelpro&act=ajSysPhotosGallery",
					data: {\'tp\':\'C\',\'hotel_image_id\' : $hotel_image_id,\'table_id\' : $table_id,\'type\' : $type},
					dataType: "html",
					success: function(html){
						makepopup(\'230px\',\'auto\',html,\'box_EditPhotosGallery\');
					}
				});
				return false;
			});
			$(document).on(\'click\', \'.ajmovePhotosGallery\', function(ev){
				var $_this = $(this);
				var $table_id = $_this.attr(\'table_id\');
				var $type = $_this.attr(\'type\');
				var $page = $(\'#Hid_CurrentPage\').val();
				vietiso_loading(1);
				$.ajax({
					type:\'POST\',
					url: path_ajax_script+"/index.php?mod=hotelpro&act=ajSysPhotosGallery",
					data: {
						\'hotel_image_id\' : $_this.attr(\'data\'),
						\'direct\' : $_this.attr(\'direct\'),
						\'table_id\' : $table_id,
						\'type\' : $type,
						\'tp\' : \'M\'
					},
					success: function(html){
						vietiso_loading(0);
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
					url: path_ajax_script+"/index.php?mod=hotelpro&act=ajSysPhotosGallery",
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
		function isoman_callback(){
			var $table_id = $(\'#Hid_TableID\').val();
			var $type = $(\'#Hid_TypeID\').val();
			var $page = $(\'#Hid_CurrentPage\').val();
			var $clsTable = \'HotelImage\';
			var $file_images = isoman_selected_files();
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod=home&act=ajUploadForm",
				data: {
					\'table_id\':$table_id,
					\'type\':$type,
					\'clsTable\':$clsTable,
					\'file_images\':$file_images
				},
				dataType: "html",
				success: function(html){
					loadTableGallery($table_id,\'\', $page, 10);
					checkSysPosition();
				}
			});
		}
		function checkSysPosition(){
			var table_id = $(\'input[name=table_id]\').val();
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod=hotelpro&act=ajSysPhotosGallery",
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
    $html.='</div>';
    echo $html; die();
}
function default_ajSysPhotosGallery(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$dbconn;
	$clsPagination = new Pagination();
	$clsHotelImage = new HotelImage();
	$pkeyTable = $clsHotelImage->pkey;
	$hotel_image_id = isset($_POST['hotel_image_id']) ? intval($_POST['hotel_image_id']) : 0;
	$table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
	$type = isset($_POST['type']) ? $_POST['type'] : 0;
	$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	// Load List
	if($tp=='L'){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$number_per_page = isset($_POST['number_per_page']) ? intval($_POST['number_per_page']) : 10;
		#
		$cond = "is_trash=0 and table_id='$table_id'";
		if(trim($keyword) !='' && $keyword!='0'){
			$slug = $core->replaceSpace($keyword);
			$cond.=" and (title like '%$keyword%' or slug like '%$slug%')";
		}
		#
		$totalRecord = $clsHotelImage->getAll($cond)?count($clsHotelImage->getAll($cond)):0;
		$pageview = $clsPagination->pagination_ajax($totalRecord,$number_per_page,$page,'','',false);
		#
		$offset = ($page-1)*$number_per_page;
		$order_by = " ORDER BY order_no desc";
		$limit = " LIMIT $offset,$number_per_page";
		
		$lstItem = $clsHotelImage->getAll($cond.$order_by.$limit);
		if(!empty($lstItem)){
			for($i=0; $i<count($lstItem); $i++){
				$hotel_image_id = $lstItem[$i][$clsHotelImage->pkey];
				#
				$html.='<tr class="'.($i%2==0?'row1':'row2').'">';
				$html.='<td class="index">'.($i+1).'</td>';
				$html.='<td width="60px"><img src="'.$ftp_abs_path_image.$lstItem[$i]['image'].'" width="60" height="40" /></td>';
				$html.='<td><a href="javascript:void();" data="'.$hotel_image_id.'" table_id="'.$table_id.'" type="'.$type.'" title="'.$core->get_Lang('edit').'" class="ajeditPhotosGallery"><strong>'.$clsHotelImage->getTitle($hotel_image_id).'</strong></a></td>';
				$html.='<td style="text-align:right;">'.date('d-m-Y h:i',$lstItem[$i]['reg_date']).'</td>';
				$html.='<td style="text-align:center">'.($i==0?'':'<a href="javascript:void();" data="'.$hotel_image_id.'" class="ajmovePhotosGallery" direct="movetop" title="'.$core->get_Lang('movetop').'" data="'.$hotel_image_id.'" table_id="'.$table_id.'" type="'.$type.'"><i class="icon-circle-arrow-up"></i></a>').'</td>';
				$html.='<td style="text-align:center">'.($i==count($lstItem)-1?'':'<a href="javascript:void();" data="'.$hotel_image_id.'" class="ajmovePhotosGallery" direct="movebottom" title="'.$core->get_Lang('movebottom').'" table_id="'.$table_id.'" type="'.$type.'"><i class="icon-circle-arrow-down"></i></a>').'</td>';
				$html.='<td style="text-align:center">'.($i==0?'':'<a href="javascript:void();" data="'.$hotel_image_id.'" class="ajmovePhotosGallery" direct="moveup" title="'.$core->get_Lang('moveup').'" table_id="'.$table_id.'" type="'.$type.'"><i class="icon-arrow-up"></i></a>').'</td>';
				$html.='<td style="text-align:center">'.($i==count($lstItem)-1?'':'<a href="javascript:void();" class="ajmovePhotosGallery" direct="movedown" title="'.$core->get_Lang('movedown').'" data="'.$hotel_image_id.'" table_id="'.$table_id.'" type="'.$type.'"><i class="icon-arrow-down"></i></a>').'</td>';
				$html.='
				<td style="vertical-align:middle; width:6%;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button> 
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a href="javascript:void(0);" data="'.$hotel_image_id.'" table_id="'.$table_id.'" type="'.$type.'" title="'.$core->get_Lang('edit').'" class="ajeditPhotosGallery"><i class="icon-edit"></i> '.$core->get_Lang('edit').'</a></li>
							<li><a href="javascript:void(0);" table_id="'.$table_id.'" type="'.$type.'" data="'.$hotel_image_id.'" title="'.$core->get_Lang('delete').'" class="ajdeletePhotosGallery"><i class="icon-remove"></i> '.$core->get_Lang('delete').'</a></li>
						</ul>
					</div>
				</td>';
				$html.='</tr>';
			}
		}else{
			$html='
			<tr style="background:#ffda0b;">
				<td colspan="9" style="text-align:center;text-decoration:blink">'.$core->get_Lang('nodata').'</td>
		   </tr>';
		}
		echo $html.'$$$'.$pageview.'$$$'.$page; die();
	}
	// Delete
	else if($tp=='D'){
		$clsHotelImage->deleteOne($hotel_image_id);
		echo(1); die();
	}
	// Quick Create
	else if($tp=='Q'){
		$fx ="table_id,type,order_no,reg_date";
		$vx ="'$table_id','$type','".$clsHotelImage->getMaxOrderNo($table_id)."','".time()."'";
		$clsHotelImage->insertOne($fx,$vx);
		echo(1); die();
	}
	// Edit Upload Form
	else if($tp=='C'){
		$HTML.='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.$core->get_Lang('Add/Edit File').'</h3>
		</div>';
		$HTML.='
		<form method="post" action="" method="post" id="aj-update-form" enctype="multipart/form-data">
		<table cellpadding="2" cellspacing="2" width="100%" class="form">
			<tr>
				<td class="fieldarea">
					<input type="text" name="title" class="text full required" style="width:96%" value="'.$clsHotelImage->getTitle($hotel_image_id).'">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						<img src="'.$clsHotelImage->getOneField('image',$hotel_image_id).'" id="isoman_show_image_val" />
						<input type="hidden" id="isoman_hidden_image_val" name="isoman_url_image" value="'.$clsHotelImage->getOneField('image',$hotel_image_id).'" />
						<a href="javascript:void(0);" title="'.$core->get_Lang('change').'" class="photobox_edit ajOpenDialog" isoman_for_id="image_val" isoman_val="'.$clsHotelImage->getOneField('image',$hotel_image_id).'" isoman_name="image">
							<i class="iso-edit"></i>
						</a>
					</div>
				</td>
			</tr>
		</table>
		<div class="clear"><br /></div>';
		$HTML.='<div class="modal-footer wrap">
					<a href="javascript:void(0);" class="iso-button-standard submitClick fr clickUpdateHotelImage" hotel_image_id="'.$hotel_image_id.'" table_id="'.$table_id.'" type="'.$type.'" ><img align="absmiddle" src="'.URL_IMAGES.'/v2/check.png"> '.$core->get_Lang('save').'</a>
			   </div>';
		$HTML.='</form>';
		$HTML.='
		<script type="text/javascript">
			$(function(){
				$(document).on(\'click\', \'.clickUpdateHotelImage\', function(){
					var $_this = $(this);
					var $_table_id = $_this.attr("table_id");
					var $_type = $_this.attr("type");
					var $_page = $(\'#Hid_CurrentPage\').val();
					var $_form = $_this.closest(\'.frmPop\');
					var $title = $_form.find(\'input[name=title]\');
					if($.trim($title.val())==\'\'){
						$title.focus().addClass(\'error\');
						alertify.error(field_is_required);
						return false;
					};
					$(\'#aj-update-form\').ajaxSubmit({
						type:\'POST\',
						url: path_ajax_script+"/index.php?mod=hotelpro&act=ajSysPhotosGallery",
						data : {\'tp\':\'S\',\'hotel_image_id\': $_this.attr(\'hotel_image_id\')},
						success: function(html){
							var htm = parseInt(html);
							if(htm==1){
								$(\'#aj-upload-form\').resetForm();
								loadTableGallery($table_id, $type,\'\',$_page,10);
								$_form.find(\'.close_pop\').trigger(\'click\');
							}
						}
					});
					return false;
				});
			})
		</script>';
		echo $HTML; die();
	}
	// Save
	else if($tp=='S'){
		$titlePost = addslashes($_POST['title']);
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
			$set = "title='".$titlePost."',slug='".$core->replaceSpace($titlePost)."',reg_date='".time()."'";
			if(!empty($_POST['isoman_url_image'])){
				$set.= ",image='".addslashes($_POST['isoman_url_image'])."'";
			}
			if($clsHotelImage->updateOne($hotel_image_id,$set)){
				echo(1); die();
			}else{
				echo(0); die();
			}
		}else{
			echo(0); die();
		}
	}
	else if($tp=='M'){
		$one = $clsHotelImage->getOne($hotel_image_id);
		$order_no = $one['order_no'];
		$direct = isset($_POST['direct'])?$_POST['direct']:'';
		#
		$cond = "is_trash=0 and table_id='$table_id' and type='$type'";
		if($direct=='moveup'){
			$lst = $clsHotelImage->getAll($cond." and order_no > $order_no order by order_no asc limit 0,1");
			$clsHotelImage->updateOne($hotel_image_id,"order_no='".$lst[0]['order_no']."'");
			$clsHotelImage->updateOne($lst[0][$clsHotelImage->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movedown'){
			$lst = $clsHotelImage->getAll($cond." and order_no < $order_no order by order_no desc limit 0,1");
			$clsHotelImage->updateOne($hotel_image_id,"order_no='".$lst[0]['order_no']."'");
			$clsHotelImage->updateOne($lst[0][$clsHotelImage->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movetop'){
			$lst = $clsHotelImage->getAll($cond." and order_no > $order_no order by order_no asc");
			$clsHotelImage->updateOne($hotel_image_id,"order_no='".$lst[count($lst)-1]['order_no']."'");
			$lstItem = $clsHotelImage->getAll($cond." and hotel_image_id <> '$hotel_image_id' and order_no > $order_no order by order_no asc");
			for($i=0;$i<count($lstItem);$i++) {
				$clsHotelImage->updateOne($lstItem[$i][$clsHotelImage->pkey],"order_no='".($lstItem[$i]['order_no']-1)."'");	
			}
		}
		if($direct=='movebottom'){
			$lst = $clsHotelImage->getAll($cond." and order_no < $order_no order by order_no desc");
			$clsHotelImage->updateOne($hotel_image_id,"order_no='".$lst[count($lst)-1]['order_no']."'");
			$lstItem = $clsHotelImage->getAll($cond." and hotel_image_id <> '$hotel_image_id' and order_no < $order_no order by order_no asc");
			for($i=0;$i<count($lstItem);$i++) {
				$clsHotelImage->updateOne($lstItem[$i][$clsHotelImage->pkey],"order_no='".($lstItem[$i]['order_no']+1)."'");	
			}
		}
		echo(1); die();
	}
	else if($tp=='TOTAL'){
		echo $clsHotelImage->getAll("is_trash=0 and table_id='$table_id' and type='$type'")?count($clsHotelImage->getAll("is_trash=0 and table_id='$table_id' and type='$type'")):0;
		die();
	}
	else if($tp=='SYS'){
		$LISTALL = $clsHotelImage->getAll("is_trash=0 and table_id='$table_id' and type='$type' order by hotel_image_id asc");
		if(!empty($LISTALL)){
			for($i=0; $i<count($LISTALL); $i++){
				$clsHotelImage->updateOne($LISTALL[$i][$clsHotelImage->pkey],"order_no='".($i+1)."'");
			}
			unset($LISTALL);
		}
		echo(1); die();
	}
	echo(1); die();
}
function default_loadCountry() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
	$clsContinent = new Continent();
	$clsCountry = new Country();
    $continent_id = isset($_POST['continent_id']) ? $_POST['continent_id'] : '';
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    #
	$Html = $clsContinent->getOptCountryByContinent($continent_id, $country_id);
    echo $Html; die();
}
function default_loadArea() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsArea = new Area();
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    $area_id = isset($_POST['area_id']) ? $_POST['area_id'] : 0;
	
	$Html = '<option value="0">|---' . $core->get_Lang('select') . '--</option>';
    $lstArea = $clsArea->getAll("is_trash=0 and country_id='$country_id' order by order_no asc");
	if(is_array($lstArea) && count($lstArea) > 0){
		for($i=0; $i<count($lstArea); $i++){
			$Html .= '<option title="' .$clsArea->getTitle($lstArea[$i][$clsArea->pkey]). '" value="'.$lstArea[$i][$clsArea->pkey].'"'.($area_id==$lstArea[$i][$clsArea->pkey]?'selected="selected"':'').'>' . $clsArea->getTitle($lstArea[$i][$clsArea->pkey]) . '</option>';
		}
	}
	echo $Html; die();
}
function default_loadRegion() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsRegion = new Region();
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    $region_id = isset($_POST['region_id']) ? $_POST['region_id'] : 0;
	#
	$Html = $clsRegion->makeSelectboxOption($country_id, $region_id);
	echo $Html; die();
}
function default_loadCity() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsCity = new City();
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    $region_id = isset($_POST['region_id']) ? $_POST['region_id'] : 0;
    $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;
	
	$cond = "is_trash=0";
	if(intval($country_id)){
		$cond .= " and country_id='$country_id'";
	}
	if(intval($region_id) > 0){
		$cond .= " and region_id='$region_id'";
	}
	$cond .= " order by order_no ASC";
	#
    $Html = '<option value="0"> --' . $core->get_Lang('select') . '-- </option>';
    $listCity = $clsCity->getAll($cond, $clsCity->pkey);
	if(is_array($listCity) && count($listCity) > 0){
		for($i=0; $i<count($listCity); $i++){
			$Html .= '<option title="'.$clsCity->getTitle($listCity[$i][$clsCity->pkey]) . '" value="'.$listCity[$i][$clsCity->pkey].'" '.($city_id==$listCity[$i][$clsCity->pkey]?'selected="selected"':'').'>|--- ' . $clsCity->getTitle($listCity[$i][$clsCity->pkey]) . '</option>';
		}
	}
	unset($listCity);
	echo $Html; die();
}

function default_loadAreaCity() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsCity = new City();
	$clsAreaCity = new AreaCity();
    $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;
	$area_city_id = isset($_POST['area_city_id']) ? $_POST['area_city_id'] : 0;
	#Khi thêm mới->bước tiếp theo country_id mặc định
	if(intval($city_id) > 0){
		$cond = "city_id='$city_id'";
	}
	$cond .= " order by order_no ASC";
	#
    $Html = '<option value="0"> --' . $core->get_Lang('select') . '-- </option>';
    $listAreaCity = $clsAreaCity->getAll($cond, $clsAreaCity->pkey);
	if(is_array($listAreaCity) && count($listAreaCity) > 0){
		for($i=0; $i<count($listAreaCity); $i++){
			$Html .= '<option title="'.$clsAreaCity->getTitle($listAreaCity[$i][$clsAreaCity->pkey]) . '" value="'.$listAreaCity[$i][$clsAreaCity->pkey].'" '.($area_city_id==$listAreaCity[$i][$clsAreaCity->pkey]?'selected="selected"':'').'>' . $clsAreaCity->getTitle($listAreaCity[$i][$clsAreaCity->pkey]) . '</option>';
		}
	}
	unset($listAreaCity);
	//echo 1; die();
	echo $Html; die();
}

//HOTEL RATING
function default_ajSelectBoxHotelRating() {
    $clsHotel = new Hotel();
    $clsHotelProperty = new HotelProperty();
    #
    $type = $_POST['type'];
    $forid = $_POST['forid'];
    $hotel_rating = $clsHotel->getOneField('hotel_rating', $forid);
    $Html = $clsHotelProperty->getSelectByProperty($type, $hotel_rating);
    echo $Html;
    die();
}
/* HOTEL TOP */
function default_hoteltop(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO;
	global $clsConfiguration;
	#
	if(!$clsConfiguration->getValue('SiteHasHotelToP')){
		header('Location:'.PCMS_URL.'/index.php?mod=NotPermission');
		exit();
	}
	#
	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;
	$clsCity = new City();
	$assign_list["clsCity"] = $clsCity;
	
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act='.$act;
		$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
		$city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;
		
		if(intval($country_id) > 0 && intval($city_id) == 0){
			 $link.='&fromid=COUNTRY&target_id=' . $country_id;
		}
		elseif(intval($country_id) > 0 && intval($city_id) > 0){
			$link.='&fromid=CITY&target_id=' . $city_id;
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	#
	$fromid = isset($_GET['fromid']) ? $_GET['fromid'] : 'COUNTRY';
	$assign_list["fromid"] = $fromid;
	$target_id = isset($_GET['target_id']) ? $_GET['target_id'] : '1';
	$assign_list["target_id"] = $target_id;
	
	if($fromid=='COUNTRY'){
		$assign_list["country_id"] = $target_id;
	}else if($fromid=='CITY'){
		$one = $clsCity->getOne($target_id);
		$country_id = $one['country_id'];
		$assign_list["country_id"] = $country_id;
		$assign_list["city_id"] = $target_id;
	}
}
function default_PopSearchHotel(){
	global $core, $clsISO;
	#
	$clsCountry = new Country();
	$clsHotelTop = new HotelTop();
	$clsHotel = new Hotel();
	
	$target_id = $_POST['target_id'];
	$fromid = $_POST['fromid'];
	$tp = isset($_POST['tp'])?$_POST['tp']:'F';
	
	$html = '';
	if($tp=='S'){
		$keyword = isset($_POST['keyword'])?$_POST['keyword']:'';
		$slug = $core->replaceSpace($keyword);
		
		$listItem = $clsHotel->getAll("is_trash=0 and ".($fromid=='COUNTRY'?'country_id':'city_id')."='$target_id' and (slug like '%$slug%' or title like '%$keyword%') and hotel_id NOT IN(SELECT hotel_id FROM ".DB_PREFIX."hoteltop WHERE target_id='$target_id' and fromid='$fromid') LIMIT 0,100");
		if(is_array($listItem) && count($listItem) > 0){
			foreach($listItem as $k=>$v){
				$html.='<li class="ClickChoiceHotel" target_id="'.$target_id.'" fromid="'.$fromid.'" data="'.$v[$clsHotel->pkey].'" title="'.$core->get_Lang('Click to choose this cruise').'" type="add">'.$clsHotel->getTitle($v[$clsHotel->pkey]).'</li>';
			}
		}else{
			$html = '';
		}
		unset($listItem);
	}
	else if($tp=='D'){
		$hoteltop_id = $_POST['hoteltop_id'];
		if(intval($hoteltop_id)==0){
			echo 'invalidID'; die();
		}
		$clsHotelTop->deleteOne($hoteltop_id);
		echo(1); die();
	}
	else{
		$html = '
		<div class="headPop"> 
			<a href="javascript:void();" class="closeEv close_pop"></a> 
			<h3>'.$core->get_Lang('Selection of typical hotels in').' '.$clsCountry->getTitle($target_id).'</h3> 
		</div> 
		<style> .listSearchQuick{ max-height:300px; min-height:20px;}</style>
		<div class="infobox">
			<b>'.$core->get_Lang('Guide add a hotel').'</b><br />
			<strong>'.$core->get_Lang('step').'1:</strong> '.$core->get_Lang('Enter search keywords hotel').'<br />
			<strong>'.$core->get_Lang('step').'2:</strong> '.$core->get_Lang('Click on the hotel you want to add').'
		</div>
		<div class="wrap">
			<div class="row-span">
				<input type="text" id="SitePopSeachHotel" target_id="'.$target_id.'" fromid="'.$fromid.'" class="text full fontLarge" value="" placeholder="'.$core->get_Lang('search').'" />
			</div>
			<ul id="listSearchQuick" class="listSearchQuick">
			</ul>
		</div>
		<div class="modal-footer"> 
			<button class="btn btn-warning close_pop" data-dismiss="modal" aria-hidden="true">'.$core->get_Lang('close').'</button> 
		</div>';
	}
	#
	echo($html);die();
}
function default_SiteSaveHotelTop(){
	global $core, $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	$clsHotelTop = new HotelTop();
	$clsHotel = new Hotel();
	$hotel_id = $_POST['hotel_id'];
	$target_id = $_POST['target_id'];
	$fromid = $_POST['fromid'];
	#
	if($clsHotelTop->getAll("target_id='$target_id' and fromid='$fromid' and hotel_id='$hotel_id'")!=''){
		echo 'EXIST'; die();
	}else{
		$fx = "user_id,target_id,fromid,hotel_id,reg_date,upd_date,order_no";
		$vx = "'$user_id','$target_id','$fromid','$hotel_id','".time()."','".time()."','".$clsHotelTop->getMaxOrderNo()."'";
		//echo $vx; die();
		if($clsHotelTop->insertOne($fx, $vx)){
			echo '_SUCCESS'; die();
		}else{
			echo '_ERROR'; die();
		}
	}
}
function default_SiteLoadHotelTop(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO;
	#
	$clsPagination = new Pagination();
	$clsHotelTop = new HotelTop();
	$clsHotel = new Hotel();
	$target_id = $_POST['target_id'];
	$fromid = isset($_POST['fromid']) ? $_POST['fromid'] : '';
	$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
	
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$number_per_page = isset($_POST['number_per_page']) ? intval($_POST['number_per_page']):20;
	
	$cond = "is_trash=0 and target_id='$target_id' and fromid='$fromid'";
	if(trim($keyword) != ''){
		$slug = $core->replaceSpace($keyword);
		$cond .= " and hotel_id IN (SELECT hotel_id FROM ".DB_PREFIX."hotel WHERE slug like '%$slug%' or title like '%$keyword%')";
	}
	$totalRecord = $clsHotelTop->getAll($cond)?count($clsHotelTop->getAll($cond)):0;
	$page_view = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page);
	
	$offset = ($page-1)*$number_per_page;
	$limit = " LIMIT $offset,$number_per_page";
	//echo $page." order by order_no DESC".$limit; die();
	
	$Html = '';
	$listHotel = $clsHotelTop->getAll($cond." order by order_no DESC".$limit);
	#
	if(is_array($listHotel) && count($listHotel)){
		for($i=0; $i < count($listHotel); $i ++){
			$Html.='<tr class="'.($i%2==0?'row1':'row2').'">';
			$Html.='<td class="index">'.($i+1).'</td>';
			
			$Html.='<td><a><strong style="font-size:14px">'.$clsHotel->getTitle($listHotel[$i][$clsHotel->pkey]).'</strong></a>
				<div class="clear" style="height:5px;"></div>
				<font color="#c00000">'.$core->get_Lang('address').'</font> '.$clsHotel->getOneField('address', $listHotel[$i][$clsHotel->pkey]).'
			</td>';
			$Html.='<td style="text-align:center"><img align="absmiddle" src="'.$clsHotel->getImageStar($clsHotel->getOneField('star_id', $listHotel[$i][$clsHotel->pkey])).'" /></td>';
			$Html.='<td style="text-align:center">'.$clsHotel->getHotelStyles($listHotel[$i][$clsHotel->pkey]).'</td>';
			$Html.='<td style="text-align:right; white-space:nowrap">
                    	<b class="format_price" style="font-size:13px">'.$clsHotel->getPrice($listHotel[$i][$clsHotel->pkey]).'</b>
					</td>';
			$Html.='<td style="vertical-align: middle;text-align:center">
				'.($i==0?'':'<a title="'.$core->get_Lang('movetop').'"  direct="movetop" class="btn_move_hoteltop" data="'.$listHotel[$i][$clsHotelTop->pkey].'" href="javascript:void();" target_id="'.$target_id.'" fromid="'.$fromid.'"><i class="icon-circle-arrow-up"></i></a>').'
			</td>
			<td style="vertical-align: middle;text-align:center">
				'.($i==count($listHotel)-1?'':'<a title="'.$core->get_Lang('movebottom').'" class="btn_move_hoteltop" direct="movebottom" data="'.$listHotel[$i][$clsHotelTop->pkey].'" href="javascript:void();" target_id="'.$target_id.'" fromid="'.$fromid.'"><i class="icon-circle-arrow-down"></i></a>').'
			</td>
			<td style="vertical-align: middle;text-align:center">
				'.($i==0?'':'<a title="'.$core->get_Lang('moveup').'" class="btn_move_hoteltop" direct="moveup" data="'.$listHotel[$i][$clsHotelTop->pkey].'" href="javascript:void();" target_id="'.$target_id.'" fromid="'.$fromid.'"><i class="icon-arrow-up"></i></a>').'
			</td>
			<td style="vertical-align: middle;text-align:center">
				'.($i==count($listHotel)-1 ? '' : '<a title="'.$core->get_Lang('movedown').'" class="btn_move_hoteltop" direct="movedown" data="'.$listHotel[$i][$clsHotelTop->pkey].'" href="javascript:void();" target_id="'.$target_id.'" fromid="'.$fromid.'"><i class="icon-arrow-down"></i></a>').'
			</td>';
			$Html.='<td style="text-align:center"><a href="javascript:void();" class="btn_delete_hoteltop" title="'.$core->get_Lang('delete').'" data="'.$listHotel[$i][$clsHotelTop->pkey].'" target_id="'.$target_id.'" fromid="'.$fromid.'"><i class="icon-remove"></i></a></td>';
			$Html.='</tr>';
		}

	}else{
		$Html .= '
		<tr>
			<td class="text-center" colspan="10">'.$core->get_Lang('nodata').' !</td>
		</tr>';
	}
	echo $Html.'$$'.$page_view; die();
}
function default_SiteMoveHotelTop(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $core, $clsModule, $clsISO;
	#
	$classTable = "HotelTop";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	
	$hoteltop_id = isset($_POST['hoteltop_id'])?$_POST['hoteltop_id']:0;
	if(intval($hoteltop_id)==0){
		echo 'invalidID'; die();
	}
	$direct = $_POST['direct'];
	$target_id = $_POST['target_id'];
	$fromid = $_POST['fromid'];
	#
	$one = $clsClassTable->getOne($hoteltop_id);
	$order_no = $one['order_no'];
	
	$where = "is_trash=0 and target_id='$target_id' and fromid='$fromid'";
	if($direct=='moveup'){
		$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no ASC limit 0,1");
		$clsClassTable->updateOne($hoteltop_id,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movedown'){
		$lst = $clsClassTable->getAll($where." and order_no < $order_no order by order_no DESC limit 0,1");
		$clsClassTable->updateOne($hoteltop_id,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movetop'){
		$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no DESC LIMIT 0,1");
		$clsClassTable->updateOne($hoteltop_id,"order_no='".$lst[0]['order_no']."'");
		#
		$lst = $clsClassTable->getAll($where." and $pkeyTable<>'$hoteltop_id' and order_no>$order_no order by order_no asc");
		for($i=0;$i<count($lst);$i++) {
			$clsClassTable->updateOne($lst[$i][$clsClassTable->pkey],"order_no='".($lst[$i]['order_no']-1)."'");	
		}
		unset($lst);
	}
	if($direct=='movebottom'){
		$lst = $clsClassTable->getAll($where." and order_no < '$order_no' order by order_no ASC LIMIT 0,1");
		$clsClassTable->updateOne($hoteltop_id,"order_no='".$lst[0]['order_no']."'");
		#
		$lst = $clsClassTable->getAll($where." and $pkeyTable<>'$hoteltop_id' and order_no<$order_no order by order_no ASC");
		for($i=0;$i<count($lst);$i++) {
			$clsClassTable->updateOne($lst[$i][$clsClassTable->pkey],"order_no='".($lst[$i]['order_no']+1)."'");	
		}
		unset($lst);
	}
	echo(1); die();
}
/* ========= SITE HOTEL PRICE RANGE ========= */
function default_price_range(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	if(!$clsConfiguration->getValue('SiteHasHotelPriceRange')){
		header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&message=NotPermission');
		exit();
	}
}
function default_ajSiteFrmHotelPriceRange(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsISO;
	#
	$clsPagination = new Pagination();
	$clsHotelPriceRange = new HotelPriceRange();
	#
	$user_id = $core->_USER['user_id'];
	$tp = isset($_POST['tp']) ? $_POST['tp']: '';
	$hotel_price_range_id = isset($_POST['hotel_price_range_id'])?intval($_POST['hotel_price_range_id']):0;
	
	if($tp == 'L') {
		$number_per_page = isset($_POST['number_per_page'])?$_POST['number_per_page']:10;
		$page = isset($_POST['page'])?$_POST['page']:1;
		$keyword = isset($_POST['keyword'])?$_POST['keyword']:'';
		#
		$cond= "is_trash=0";
		if(isset($keyword) && !empty($keyword)){
			$slug = $core->replaceSpace($keyword);
			$cond.=" and (slug like '%$slug%' or title like '%$keyword%')";
		}
		$totalRecord = $clsHotelPriceRange->getAll($cond)?count($clsHotelPriceRange->getAll($cond)):0;
		$pageview = $clsPagination->pagination_ajax($totalRecord,$number_per_page,$page);
		$offset = ($page-1)*$number_per_page;
		$cond.=" ORDER BY order_no ASC";
		$cond.=" LIMIT $offset,$number_per_page";
		#
		$lstItem = $clsHotelPriceRange->getAll($cond);
		if(is_array($lstItem) && count($lstItem) > 0){
			$i=0;
			foreach($lstItem as $item){
				$html.='<tr class="'.($i%2==0?'row1':'row2').'">';
				$html.='<td class="index">'.($i+1).'</td>';
				$html.='<td><strong>'.$clsHotelPriceRange->getTitle($item[$clsHotelPriceRange->pkey]).'</strong></td>';
				$html.='<td><strong class="format_price">'.$clsHotelPriceRange->getMin($item[$clsHotelPriceRange->pkey]).'</strong></td>';
				$html.='<td><strong class="format_price">'.$clsHotelPriceRange->getMax($item[$clsHotelPriceRange->pkey]).'</strong></td>';
				$html.='
					<td style="vertical-align: middle;text-align:center">
						'.($i==0?'':'<a title="'.$core->get_Lang('movetop').'" class="ajMovePriceRange" direct="movetop" data="'.$item[$clsHotelPriceRange->pkey].'" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>').'
					</td>
					<td style="vertical-align: middle;text-align:center">'.($i==count($lstItem)-1 ? '' : '<a title="'.$core->get_Lang('movebottom').'" class="ajMovePriceRange" direct="movebottom" data="'.$item[$clsHotelPriceRange->pkey].'" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>').'
					</td>
					<td style="vertical-align: middle;text-align:center">'.($i==0?'':'<a title="'.$core->get_Lang('moveup').'" class="ajMovePriceRange" direct="moveup" data="'.$item[$clsHotelPriceRange->pkey].'" href="javascript:void();"><i class="icon-arrow-up"></i></a>').'
					</td>
					<td style="vertical-align: middle;text-align:center"> '.($i==count($lstItem)-1 ? '' : '<a title="'.$core->get_Lang('movedown').'" class="ajMovePriceRange" direct="movedown" data="'.$item[$clsHotelPriceRange->pkey].'" href="javascript:void();"><i class="icon-arrow-down"></i></a>').'</td>';
				$html.='
					<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" style="right:0px !important">
								<li><a class="ajEditPriceRange" title="'.$core->get_Lang('edit').'" href="javascript:void();" data="'.$item[$clsHotelPriceRange->pkey].'"><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
								<li><a class="ajDeletePriceRange" title="'.$core->get_Lang('delete').'" href="javascript:void();" data="'.$item[$clsHotelPriceRange->pkey].'"><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
							</ul>
						</div>
					</td>';
				$html.='</tr>';
				++$i;
			}
		}
		else{
			$html.='<tr><td style="text-align:center" colspan="7">'.$core->get_Lang('nodata').' !</td></tr>';
		}
		echo $html.'$$'.$pageview; die();
	} elseif($tp == 'F') {
		$html ='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($hotel_price_range_id>0?$core->get_Lang('edit'):$core->get_Lang('add')).' '.$core->get_Lang('pricerange').'</h3>
		</div>
		<form method="post" id="frmPriceRange" class="frmform" enctype="multipart/form-data">
			<table class="form" cellpadding="3" cellspacing="3">
				<tr>
					<td class="fieldlabel span15">'.$core->get_Lang('title').'</label>
					<td class="fieldarea">
						<input class="text fontLarge full" name="title" value="'.$clsHotelPriceRange->getTitle($hotel_price_range_id).'" type="text" />
					</td>
				</tr>
				<tr>
					<td class="fieldlabel span15">'.$core->get_Lang('minrate').'</label>
					<td class="fieldarea">
						<input class="text fontLarge full price" value="'.$clsHotelPriceRange->getMin($hotel_price_range_id).'" name="min_rate" type="text" />
					</td>
				</tr>
				<tr>
					<td class="fieldlabel span15">'.$core->get_Lang('minrate').'</label>
					<td class="fieldarea">
						<input class="text fontLarge full price" value="'.$clsHotelPriceRange->getMax($hotel_price_range_id).'" name="max_rate" type="text" />
					</td>
				</tr>
			</table>
			<div class="modal-footer">
				<button type="button" hotel_price_range_id="'.$hotel_price_range_id.'" class="btn btn-primary ajSubmitPriceRange"><i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span> </button>
				<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span></button>
			</div>
		</form>';
		echo($html);die();
	} elseif($tp == 'S') {
		$titlePost = isset($_POST['title'])?trim(addslashes($_POST['title'])):'';
		$slugPost = $core->replaceSpace($titlePost);
		$min_rate = addslashes($_POST['min_rate']);
		$max_rate = addslashes($_POST['max_rate']);
		#
		if(intval($hotel_price_range_id) == 0){
			$f = "$clsHotelPriceRange->pkey,title,slug,min_rate,max_rate,order_no";
			$v = "'".$clsHotelPriceRange->getMaxID."','$titlePost','$slugPost','".$clsISO->processSmartNumber($min_rate)."','".$clsISO->processSmartNumber($max_rate)."','".$clsHotelPriceRange->getMaxOrderNo()."'";
			if($clsHotelPriceRange->insertOne($f,$v)){
				echo '_INSUCCESS'; die();	
			}else{
				echo '_ERROR'; die();
			}
		}else{
			$v="title='$titlePost',slug='$slugPost',min_rate='".$clsISO->processSmartNumber($min_rate)."',max_rate='".$clsISO->processSmartNumber($max_rate)."'";
			if($clsHotelPriceRange->updateOne($hotel_price_range_id,$v)){
				echo '_UPSUCCESS'; die();	
			}else{
				echo '_ERROR'; die();
			}
		}
	} elseif($tp == 'D') {
		$clsHotelPriceRange->deleteOne($hotel_price_range_id);
		echo 1; die();
	} elseif($tp == 'M') {
		$one = $clsHotelPriceRange->getOne($hotel_price_range_id);
		$order_no = $one['order_no'];
		$direct = isset($_POST['direct'])?$_POST['direct']:'';
		
		if($direct=='moveup'){
			$lst = $clsHotelPriceRange->getAll("is_trash=0 and order_no < $order_no order by order_no DESC limit 0,1");
			$clsHotelPriceRange->updateOne($hotel_price_range_id,"order_no='".$lst[0]['order_no']."'");
			$clsHotelPriceRange->updateOne($lst[0][$clsHotelPriceRange->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movedown'){
			$lst = $clsHotelPriceRange->getAll("is_trash=0 and order_no > $order_no order by order_no ASC limit 0,1");
			$clsHotelPriceRange->updateOne($hotel_price_range_id,"order_no='".$lst[0]['order_no']."'");
			$clsHotelPriceRange->updateOne($lst[0][$clsHotelPriceRange->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movetop'){
			$lst = $clsHotelPriceRange->getAll("is_trash=0 and order_no < $order_no order by order_no ASC");
			$clsHotelPriceRange->updateOne($hotel_price_range_id,"order_no='".$lst[0]['order_no']."'");
			unset($lst);
			$lst = $clsHotelPriceRange->getAll("is_trash=0 and hotel_price_range_id<>'$hotel_price_range_id' and order_no < '$order_no' order by order_no DESC");
			if(!empty($lst)){
				for($i=0;$i<count($lst);$i++) {
					$clsHotelPriceRange->updateOne($lst[$i][$clsHotelPriceRange->pkey],"order_no='".($lst[$i]['order_no']+1)."'");	
				}
			}
		}
		if($direct=='movebottom'){
			$lst = $clsHotelPriceRange->getAll("is_trash=0 and order_no > $order_no order by order_no DESC");
			$clsHotelPriceRange->updateOne($hotel_price_range_id,"order_no='".$lst[0]['order_no']."'");
			unset($lst);
			$lst = $clsHotelPriceRange->getAll("is_trash=0 and hotel_price_range_id<>'$hotel_price_range_id' and order_no > '$order_no' order by order_no ASC");
			if(!empty($lst)){
				for($i=0;$i<count($lst);$i++) {
					$clsHotelPriceRange->updateOne($lst[$i][$clsHotelPriceRange->pkey],"order_no='".($lst[$i]['order_no']-1)."'");	
				}
			}
		}
		echo(1); die();
	}
}
function default_SiteHotelDistaceField(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	$user_id = $core->_USER['user_id'];
	#
	$clsClassTable = new HotelCustomField();
	$hotel_id = isset($_POST['hotel_id'])?intval($_POST['hotel_id']) : 0;
	$hotel_customfield_id = isset($_POST['hotel_customfield_id'])?intval($_POST['hotel_customfield_id']) : 0;
	$tp = isset($_POST['tp']) ? $_POST['tp']: '';
	#
	if($tp=='C'){
		$idx = $clsClassTable->getAll("fieldtype='CUSTOM' and hotel_id='$hotel_id'")?count($clsClassTable->getAll("fieldtype='CUSTOM' and hotel_id='$hotel_id'")):0;
		$title = 'Custom_Field_'.($idx+1);
		$slug = 'custom_field_'.($idx+1);
		$fx = "fieldname,fieldname_slug,fieldtype,user_id,user_id_update,hotel_id,$clsClassTable->pkey,order_no,reg_date,upd_date";
		$vx = "'$title','$slug','CUSTOM','$user_id','$user_id','$hotel_id','".$clsClassTable->getMaxID()."','".$clsClassTable->getMaxOrderNo()."','".time()."','".time()."'";
		if($clsClassTable->insertOne($fx, $vx)){
			echo('_SUCCESS'); die();
		}else{
			echo('_ERROR'); die();
		}
	}
	else if($tp=='L'){
		$listCustomField = $clsClassTable->getAll("fieldtype='CUSTOM' and hotel_id='$hotel_id' order by order_no ASC");
		$html = '';
		if(is_array($listCustomField) && count($listCustomField) > 0){
			$html .= '
			<style type="text/css">
				
			</style>
			';
			for($i=0; $i< count($listCustomField); $i++){
				$html .= '
				<div class="row-span row-has-border" style="width:100%">
					<div class="fieldlabel">
						'.$listCustomField[$i]['fieldname'].'
						<div class="Site_Custom_Field_Tools" style="display:inline-block;margin-bottom:10px">
							<a title="'.$core->get_Lang('edit').'" hotel_id="'.$hotel_id.'" data="'.$listCustomField[$i][$clsClassTable->pkey].'" class="btnedit_customfield" href="javascript:void();"><i class="icon-pencil"></i></a>
							<a title="'.$core->get_Lang('delete').'" hotel_id="'.$hotel_id.'" data="'.$listCustomField[$i][$clsClassTable->pkey].'" class="btndelete_customfield" href="javascript:void();"><i class="icon-remove"></i></a>
							'.($i==0?'':'<a title="'.$core->get_Lang('moveup').'" hotel_id="'.$hotel_id.'" data="'.$listCustomField[$i][$clsClassTable->pkey].'" class="btnmove_customfield" direct="up" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>').'
							'.($i==(count($listCustomField)-1)?'':'<a title="'.$core->get_Lang('movedown').'" hotel_id="'.$hotel_id.'" data="'.$listCustomField[$i][$clsClassTable->pkey].'" class="btnmove_customfield" direct="down" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>').'
						</div>
					</div>
					<div class="fieldarea">
						<textarea style="width:100%" cols="255" rows="5" class="Site_Custom_Field_Editor" id="Site_Custom_Field_'.$listCustomField[$i][$clsClassTable->pkey].'_'.time().'" name="Site_Custom_Field_value_'.$listCustomField[$i][$clsClassTable->pkey].'">'.$listCustomField[$i]['fieldvalue'].'</textarea>
					</div>
				</div>';
			}
		}
		echo $html; die();
	}
	else if($tp=='D'){
		$clsClassTable->deleteOne($hotel_customfield_id);
		echo(1); die();
	}
	else if($tp=='F'){
		$html = '
		<div class="headPop"> 
			<a id="clickToCloseNewTourPriceRow" href="javascript:void();" class="closeEv close_pop">'.$core->get_Lang('close').'</a> 
			<h3>'.$core->get_Lang('editcustomfield').'</h3> 
		</div> 
		<table class="form" cellpadding="3" cellspacing="3">
			<tr>
				<td class="fieldarea">
					<input type="text" name="fieldname" class="text full fontLarge required" style="width:95%" value="'.$clsClassTable->getOneField('fieldname',$hotel_customfield_id).'">
				</td>
			</tr>
		</table>
		<div class="modal-footer"> 
			<button class="btn btn-success submitClick SiteClickUpdateFieldName" hotel_id="'.$hotel_id.'" hotel_customfield_id="'.$hotel_customfield_id.'">'.$core->get_Lang('update').'</button> 
		</div>';
		echo($html);die();
	}
	else if($tp=='S'){
		$fieldname = $_POST['fieldname'];
		$fieldnameSlug = $core->replaceSpace($fieldname);
		if($clsClassTable->getAll("fieldtype='CUSTOM' and hotel_id='$hotel_id' and fieldname_slug='$fieldnameSlug'")!=''){
			echo '_EXIST'; die();
		}else{
			$v = "user_id_update = '$user_id',fieldname='$fieldname',fieldname_slug='$fieldnameSlug'";
			$clsClassTable->updateOne($hotel_customfield_id,$v);
			echo(1); die();
		}
	}
	else if($tp=='M'){
		$direct = isset($_POST['direct']) ? intval($_POST['direct']) : '';
		$order_no = $clsClassTable->getOneField('order_no',$hotel_customfield_id);
		$where = "is_trash=0";
		$where.= " and hotel_id='$hotel_id'";
		
		if($direct=='up'){
			$lst = $clsClassTable->getAll($where." and order_no < $order_no order by order_no desc limit 0,1");
			$clsClassTable->updateOne($hotel_customfield_id,"order_no='".$lst[0]['order_no']."'");
			$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='$order_no'");
		}
		if($direct=='down'){
			$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no asc limit 0,1");
			$clsClassTable->updateOne($hotel_customfield_id,"order_no='".$lst[0]['order_no']."'");
			$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='$order_no'");
		}
		echo(1); die();
	}
}
function default_ajUpdateHotelStore(){
	global $core,$dbconn;
	#
	$clsClassTable = new HotelStore();
	$_type = isset($_POST['_type'])?$_POST['_type']:'';
	$hotel_id = isset($_POST['hotel_id'])?$_POST['hotel_id']:0;
	$val = isset($_POST['val'])?$_POST['val']:0;
	$user_id = $core->_USER['user_id'];
	#
	$lst = $clsClassTable->getAll("hotel_id='$hotel_id' and _type = '".$_type."' limit 0,1");
	if(isset($lst[0][$clsClassTable->pkey]) && $val==0) {
		$hotel_store_id = $lst[0][$clsClassTable->pkey];
		$clsClassTable->deleteOne($hotel_store_id);
	} else {
		$fx = "hotel_store_id,hotel_id,_type,order_no";
		$vx = "'".$clsClassTable->getMaxID()."','$hotel_id','$_type','".$clsClassTable->getMaxOrder($_type)."'";
		$clsClassTable->insertOne($fx,$vx);
	}
	echo 1; die();
}

/*------ Deplicate Hotels -------*/
function default_ajDuplicateHotel(){
	global $clsISO,$core;
	#
	$user_id = $core->_USER['user_id'];
	$hotel_id_duplicate = $_POST['hotel_id'];
	
	$html = '';
	
	#Duplicate Hotel Table--------------------------
	$clsHotel = new Hotel();
	$oneHotel = $clsHotel->getOne($hotel_id_duplicate);
	$hotel_id = $clsHotel->getMaxID();
	$max_hotel_order = $clsHotel->getMaxOrderNo();
	$fx = "hotel_id,order_no";
	$vx= "'$hotel_id','$max_hotel_order'";
	foreach($oneHotel as $key=>$value){ 
		if(intval($key)==0 && $key!=$clsHotel->pkey && $key!='order_no'){
			$fx .= ",".$key;
			if($key=='user_id')
				$vx .= ",'$user_id'";
			elseif($key=='is_online')
				$vx .= ",0";
			elseif($key=='title')
				$vx .= ",'".addslashes($value)."-DUP'";
			elseif($key=='slug')
				$vx .= ",'".addslashes($value).$core->replaceSpace('-DUP')."'";
			else
				$vx .= ",'".addslashes($value)."'";
		}
	}
	$clsHotel->insertOne($fx,$vx);
	#End Duplicate Hotel Table--------------------------
	#Duplicate Hotel Custom Field Table------------------------------
	$clsHotelCustomField = new HotelCustomField();
	$lstHotelCustomField = $clsHotelCustomField->getAll("hotel_id='$hotel_id_duplicate'");
	if($lstHotelCustomField[0][$clsHotelCustomField->pkey]!=''){
		for($i=0;$i<count($lstHotelCustomField);$i++){
			$oneItem = $lstHotelCustomField[$i];
			$max_item_id = $clsHotelCustomField->getMaxID();
			$fx = "$clsHotelCustomField->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsHotelCustomField->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsHotelCustomField->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='hotel_id')
						$vx .= ",'$hotel_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			} 
			$clsHotelCustomField->insertOne($fx,$vx); 
		}
	} unset($clsHotelCustomField);
	#End Duplicate Hotel Custom Field Table--------------------------
	#Duplicate Hotel Custom Field Table------------------------------
	$clsHotelCustomField = new HotelCustomField();
	$lstHotelCustomField = $clsHotelCustomField->getAll("hotel_id='$hotel_id_duplicate'");
	if($lstHotelCustomField[0][$clsHotelCustomField->pkey]!=''){
		for($i=0;$i<count($lstHotelCustomField);$i++){
			$oneItem = $lstHotelCustomField[$i];
			$max_item_id = $clsHotelCustomField->getMaxID();
			$fx = "$clsHotelCustomField->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsHotelCustomField->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsHotelCustomField->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='hotel_id')
						$vx .= ",'$hotel_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			} 
			$clsHotelCustomField->insertOne($fx,$vx); 
		}
	} unset($clsHotelCustomField);
	#End Duplicate Hotel Custom Field Table--------------------------
	#Duplicate Hotel Images Table------------------------------
	$clsHotelImage = new HotelImage();
	$lstImage = $clsHotelImage->getAll("table_id='$hotel_id_duplicate'");
	if($lstImage[0][$clsHotelImage->pkey]!=''){
		for($i=0;$i<count($lstImage);$i++){
			$oneItem = $lstImage[$i];
			$max_item_id = $clsHotelImage->getMaxID();
			$fx = "$clsHotelImage->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsHotelImage->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsHotelImage->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='table_id')
						$vx .= ",'$hotel_id'";
					elseif($key=='is_online')
						$vx .= ",0";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			} 
			$clsHotelImage->insertOne($fx,$vx); 
		}
	} unset($clsHotelImage);
	#End Duplicate Hotel Images Table--------------------------
	#Duplicate Hotel Price Col Table------------------------------
	$clsHotelPriceCol = new HotelPriceCol();
	$lstHotelPriceCol = $clsHotelPriceCol->getAll("hotel_id='$hotel_id_duplicate'");
	if($lstHotelPriceCol[0][$clsHotelPriceCol->pkey]!=''){
		for($i=0;$i<count($lstHotelPriceCol);$i++){
			$oneItem = $lstHotelPriceCol[$i];
			$fx = "$clsHotelPriceCol->pkey,order_no";
			$vx = "'".$clsHotelPriceCol->getMaxID()."','".$clsHotelPriceCol->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsHotelPriceCol->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='hotel_id')
						$vx .= ",'$hotel_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}
			$clsHotelPriceCol->insertOne($fx,$vx); 
		}
	} unset($clsHotelPriceCol);
	#End Duplicate Hotel Price Col table------------------------------
	#Duplicate Hotel Price Val Table------------------------------
	$clsHotelPriceVal = new HotelPriceVal();
	$lstHotelPriceVal = $clsHotelPriceVal->getAll("hotel_id='$hotel_id_duplicate'");
	if($lstHotelPriceVal[0][$clsHotelPriceVal->pkey]!=''){
		for($i=0;$i<count($lstHotelPriceVal);$i++){
			$oneItem = $lstHotelPriceVal[$i];
			$fx = "$clsHotelPriceVal->pkey,order_no";
			$vx = "'".$clsHotelPriceVal->getMaxID()."','".$clsHotelPriceVal->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsHotelPriceVal->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='hotel_id')
						$vx .= ",'$hotel_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}
			$clsHotelPriceVal->insertOne($fx,$vx); 
		}
	} unset($clsHotelPriceVal);
	#End Duplicate Hotel Price Val table------------------------------
	#Duplicate Hotel Room Table------------------------------
	$clsHotelRoom = new HotelRoom();
	$lstHotelRoom = $clsHotelRoom->getAll("hotel_id='$hotel_id_duplicate'");
	if($lstHotelPriceVal[0][$clsHotelRoom->pkey]!=''){
		for($i=0;$i<count($lstHotelRoom);$i++){
			$oneItem = $lstHotelRoom[$i];
			$fx = "$clsHotelRoom->pkey,order_no";
			$vx = "'".$clsHotelRoom->getMaxID()."','".$clsHotelRoom->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsHotelRoom->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='hotel_id')
						$vx .= ",'$hotel_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}
			$clsHotelRoom->insertOne($fx,$vx); 
		}
	} unset($clsHotelRoom);
	#End Duplicate Hotel Room table------------------------------
	#Duplicate Hotel Top Table------------------------------
	$clsHotelTop = new HotelTop();
	$lstHotelTop = $clsHotelTop->getAll("hotel_id='$hotel_id_duplicate'");
	if($lstHotelPriceVal[0][$clsHotelTop->pkey]!=''){
		for($i=0;$i<count($lstHotelTop);$i++){
			$oneItem = $lstHotelTop[$i];
			$fx = "$clsHotelTop->pkey,order_no";
			$vx = "'".$clsHotelTop->getMaxID()."','".$clsHotelTop->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsHotelTop->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='hotel_id')
						$vx .= ",'$hotel_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}
			$clsHotelTop->insertOne($fx,$vx); 
		}
	} unset($clsHotelTop);
	#End Duplicate Hotel Top table------------------------------
	
	$html = PCMS_URL.'/index.php?mod=hotelpro&act=edit&'.$clsHotel->pkey.'='.$core->encryptID($hotel_id);
	echo($html);die();
}
function default_OpenAvailbility(){
	global $clsISO, $core, $dbconn, $_LANG_ID;
	$clsHotelRoom = new HotelRoom();
	$clsAvailbility = new Availbility();
	$type = $_POST['type'];
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	$target_id = intval($_POST['target_id']);
	$hotel_id = intval($_POST['hotel_id']);
	$price_ori = $clsHotelRoom->getOneField('price',$target_id);
	$default_state = $clsHotelRoom->getOneField('default_state',$target_id);
	// List action
	if($tp=='L'){
		$results = array();
		$check_in = intval($_POST['start']);
		$check_out = intval($_POST['end']);
		if($type=='_ROOM'){
			$data = _getdataHotel($target_id, $type, $check_in, $check_out);
			for($i = $check_in; $i <= $check_out; $i = strtotime('+1 day', $i)){
				$op .= '|'.$i;
				$in_date = false;
				if(!empty($data)){
					foreach($data as $key => $val){
						$status = $val['status'];
						if(date('dmY',$i) == date('dmY',$val['check_in']) &&  date('dmY',$i) == date('dmY',$val['check_out'])){
							$results[] = array(
								'price' => $val['price'],
								'start' => date('Y-m-d',$i),
								'title' => $clsHotelRoom->getTitle($target_id),
								'item_id' => $val[$clsAvailbility->pkey],
								'status' => $val['status'],
								'allotement' => $val['allotement'],
								'request_price' => $val['request_price'],
							);
							if(!$in_date){
								$in_date = true;
							} 
						}
					}
				}
				if(!$in_date && ($default_state == 'available' || !$default_state)){
					$results[] = array(
						'price' => $price_ori,
						'start' => date('Y-m-d', $i),
						'title' => $clsHotelRoom->getTitle($target_id),
						'number' => $number_room,
						'status' => $default_state
					);
				}
			}
		}
		//var_dump($op); die();
		echo json_encode($results);
		die();
	}
	// Save action
	else if($tp=='S'){
		if($type=='_ROOM'){
			$check_in= $_POST['check_in'];
			$check_out= $_POST['check_out'];
			$price = $_POST['price'];
			$status = $_POST['status'];
			$allotement = $_POST['allotement'];
			$request_price = $_POST['request_price'];
			if($check_in=='' || $check_out==''){
				echo '_invalid_date_empty'; die();
			}
			$check_in = strtotime($check_in);
			$check_out = strtotime($check_out);
			if($check_in > $check_out){
				echo '_invalid_date_less'; die();
			}
			if($status=='available'){
				if(filter_var($price, FILTER_VALIDATE_FLOAT) === false){
					echo '_invalid_price'; die();
				}
			}
			#
			for($i = $check_in; $i <= $check_out; $i = strtotime('+1 day', $i)){
				$_data = _getdataHotel($target_id, $type, $i, $i);
				if(!empty($_data)){
					foreach($_data as $key => $val){
						if($i == $val['check_in'] && $i == $val['check_out']){
							$set = "price='".$clsISO->processSmartNumber($price)."'
							,status='$status',allotement='$allotement',request_price='$request_price'";
							$clsAvailbility->updateOne($val[$clsAvailbility->pkey], $set);
						}else{
							$f = "availbility_id,hotel_id,target_id,type,check_in,check_out,price,status,allotement,request_price";
							$availbility_id = $clsAvailbility->getMaxId();
							$v = "'$availbility_id','$hotel_id','$target_id','$type','$i','$i','".$clsISO->processSmartNumber($price)."','$status','$allotement','$request_price'";
							$clsAvailbility->insertOne($f, $v);
						}
					}
				}else{
					$f = "availbility_id,hotel_id,target_id,type,check_in,check_out,price,status,allotement,request_price";
					$availbility_id = $clsAvailbility->getMaxId();
					$v = "'$availbility_id','$hotel_id','$target_id','$type','$i','$i','".$clsISO->processSmartNumber($price)."','$status','$allotement','$request_price'";
					$clsAvailbility->insertOne($f, $v);
				}
			}
		}
		#
		echo(1); die();
	}
}
function _getdataHotel($target_id, $type, $check_in, $check_out){
	global $dbconn, $_LANG_ID;
	$clsAvailbility = new Availbility();
	$sql = "SELECT `availbility_id`,`target_id`,`type`,`check_in`,`check_out`,`number`,`price`,`status`,`allotement`,`request_price` FROM ".DB_PREFIX."availbility 
	WHERE target_id = '$target_id' AND type='$type' AND(
		(
			UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME('$check_in'), '%Y-%m-%d')) < UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(check_in), '%Y-%m-%d'))
			AND UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME('$check_out'), '%Y-%m-%d')) > UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(check_out), '%Y-%m-%d'))
		)
		OR (
			UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME('$check_in'), '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(check_in), '%Y-%m-%d'))
			AND UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(check_out), '%Y-%m-%d'))
		)
		OR (
			UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME('$check_out'), '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(check_in), '%Y-%m-%d'))
			AND UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(check_out), '%Y-%m-%d'))
		)
	)";
	$results = $dbconn->getAll($sql);
	return $results;
}
?>