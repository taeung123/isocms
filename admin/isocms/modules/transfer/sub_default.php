<?php
function default_default() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $extLang;
    $assign_list["clsModule"] = $clsModule;
    $clsUser = new User();
    $user_id = $core->_USER['user_id'];
    $user_group_id = $clsUser->getOneField('user_group_id', $user_id);
    #

    $classTable = "Transfer";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    #

    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($SiteHasGroup_Tours) {
            if (isset($_POST['tour_group_id']) && intval($_POST['tour_group_id']) != 0) {
                $link .= '&tour_group_id=' . intval($_POST['tour_group_id']);
            }
        }
      
        if (isset($_POST['country_id']) && intval($_POST['country_id']) != 0) {
            $link .= '&country_id=' . intval($_POST['country_id']);
        }
        if (isset($_POST['cat_id']) && intval($_POST['cat_id']) != 0) {
            $link .= '&cat_id=' . $_POST['cat_id'];
        }
        if (isset($_POST['tour_type_id']) && intval($_POST['tour_type_id']) != 0) {
            $link .= '&tour_type_id=' . $_POST['tour_type_id'];
        }
        if (isset($_POST['departure_point_id']) && intval($_POST['departure_point_id']) != 0) {
            $link .= '&departure_point_id=' . $_POST['departure_point_id'];
        }
        if (isset($_POST['number_day']) && intval($_POST['number_day']) != 0) {
            $link .= '&number_day=' . $_POST['number_day'];
        }
        if (isset($_POST['price_range_id']) && intval($_POST['price_range_id']) != 0) {
            $link .= '&price_range_id=' . $_POST['price_range_id'];
        }
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Type trip code or tour name') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    #
    $pUrl = '';
    $cond = "1=1";
	
    $cond2 = $cond;
    if ($user_group_id == 2) {
        $cond .= " and is_online='0' and user_id='$user_id'";
    }
    $orderBy = " order_no asc";
    #-------Page Divide---------------------------------------------------------------
	
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";

    $totalRecord = $clsClassTable->getAll($cond)?count($clsClassTable->getAll($cond)):0;
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

    #
    $allTop = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id' and is_top=1");
    $assign_list['num_top'] = (is_array($allTop) && count($allTop) > 0) ? count($allTop) : 0;
    #
    $allTop = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id' and is_promotion=1");
    $assign_list['num_promtion'] = (is_array($allTop) && count($allTop) > 0) ? count($allTop) : 0;
    #
    $allTrash = $clsClassTable->getAll("is_trash=1 and tour_type_id = '$tour_type_id' and " . $cond2);
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id' and " . $cond2);
    $assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
    #
    $allAll = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id'");
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
    $assign_list['pUrl'] = $pUrl;
    #----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateToursIntro') {
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    $clsConfiguration->updateValue($tmp[1], $val);
                }
            }
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
        }
    }
}

function default_edit() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core, 
	
	$clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration,$pvalTable,$clsClassTable;
	
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #
    
	$clsProperty = new Property();$assign_list["clsProperty"] = $clsProperty;
	$clsTransferPrice = new TransferPrice();
	$assign_list["clsTransferPrice"] = $clsTransferPrice;
	$clsTransferImage = new TransferImage();
	$assign_list["clsTransferImage"] = $clsTransferImage;
	$clsTourExtension = new TourExtension();
	$assign_list["clsTourExtension"] = $clsTourExtension;

    $classTable = "Transfer";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["get"] = $_GET;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
	
	
	
    #
    $clsCountry = new _Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $lstCity = $clsCity->getAll("is_trash=0 and country_id='1'");
    $assign_list["lstCity"] = $lstCity;
    $clsProfile = new Profile();
    $assign_list["clsProfile"] = $clsProfile;
   
    $transfer_id = isset($_GET['transfer_id']) ? ($_GET['transfer_id']) : '';
    $transfer_id = intval($core->decryptID($transfer_id));
   

    $clsContinent = new Continent();
    $assign_list["clsContinent"] = $clsContinent;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $assign_list["listCountry"] = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $clsRegion = new Region();
    $assign_list["clsRegion"] = $clsRegion;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTourItinerary = new TourItinerary();
    $assign_list["clsTourItinerary"] = $clsTourItinerary;
	$clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
	$clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
	
	
    if ($string != '' && $pvalTable == 0) {
        header('location:' . PCMS_URL . '/#notPermission');
    }
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['transfer_id'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;
	
	//$departure_point=unserialize($oneItem['departure_point_id']);
	$departure_region_id=$oneItem['region_departure_id'];
	$departure_country_id=$oneItem['country_departure_id'];
	$departure_point_id=$oneItem['city_departure_id'];
	
	$assign_list["departure_point_id"] = $departure_point_id;
	$assign_list["departure_region_id"] = $departure_region_id;
	$assign_list["departure_country_id"] = $departure_country_id;
	
	
	
	//$end_point=unserialize($oneItem['end_point_id']);
	$region_end_point_id=$oneItem['region_end_id'];
	$country_end_point_id=$oneItem['country_end_id'];
	$end_point_id=$oneItem['city_end_id'];
	
	$assign_list["end_point_id"] = $end_point_id;
	$assign_list["region_end_point_id"] = $region_end_point_id;
	$assign_list["country_end_point_id"] = $country_end_point_id;
	
	$clsCar = new Car();
	$assign_list["clsCar"] = $clsCar;
	$lstCarTransfer = $clsCar->getAll("is_trash=0 and is_online=1 order by order_no asc");
	$assign_list["lstCarTransfer"] = $lstCarTransfer;
	unset($lstCarTransfer);
	
	$listTypeOfTrip= $clsProperty->getAll("is_trash=0 and type='TypeOfTrip' order by order_no asc");
	$assign_list["listTypeOfTrip"] = $listTypeOfTrip;
	unset($listTypeOfTrip);

    #-------------Update Config Meta
    $clsMeta = new Meta();
    $assign_list["clsMeta"] = $clsMeta;
    $linkMeta = $clsClassTable->getLink($pvalTable);
    $allMeta = $clsMeta->getAll("config_link='$linkMeta'");
    $meta_id = $allMeta[0]['meta_id'];
    $assign_list["meta_id"] = $meta_id;
    $assign_list["oneMeta"] = $clsMeta->getOne($meta_id);
	


    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;
    $clsForm->addInputTextArea("full", 'exclusion', "", 'exclusion', 255, 25, 2, 1, "style='width:100%; height:420px'");
	$clsForm->addInputTextArea("full", 'inclusion', "", 'inclusion', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'service_information', "", 'service_information', 255, 25, 2, 1, "style='width:100%; height:420px'");
	$clsForm->addInputTextArea("full", 'highlight', "", 'highlight', 255, 25, 2, 1, "style='width:100%; height:420px'");
    $clsForm->addInputTextArea("full", 'overview', "", 'overview', 255, 25, 2, 1, "style='width:100%; height:420px'");
	$clsForm->addInputTextArea("full", 'embed_map', "", 'embed_map', 255, 25, 2, 1, "style='width:100%; height:420px'");
	$clsForm->addInputTextArea("full", 'note_map', "", 'note_map', 255, 25, 2, 1, "style='width:100%; height:420px'");
    #=========================================#
    if (isset($_POST['UpdateStep1']) && $_POST['UpdateStep1'] == 'UpdateStep1') {
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
			
			
			
			$value .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
			$value .= ",upd_date='" . time() . "'";
			$value .= ",title='" .ucwords(addslashes($_POST['title'])) . "'";
			$value .= ",slug='" . $core->replaceSpace($_POST['title']) . "'";
			
			
			
			$arr_departure_point =array();
			$arr_departure_point['country_departure_point_id'] = $_POST['country_departure_point_id'];
			$arr_departure_point['region_departure_point_id'] = $_POST['region_departure_point_id'];  
			$arr_departure_point['departure_point_id'] = $_POST['departure_point_id'];  
			
			$arr_end_point =array();
			$arr_end_point['country_end_point_id'] = $_POST['country_end_point_id'];
			$arr_end_point['region_end_point_id'] = $_POST['region_end_point_id'];  
			$arr_end_point['end_point_id'] = $_POST['end_point_id'];  
				
				
			$value .= ",departure_point_id='" .serialize($arr_departure_point). "'";
			$value .= ",end_point_id='" . serialize($arr_end_point). "'";
			$value .= ",country_departure_id='" .$_POST['country_departure_point_id']. "'";
			$value .= ",country_end_id='" .$_POST['country_end_point_id']. "'";
			$value .= ",region_departure_id='" .$_POST['region_departure_point_id']. "'";
			$value .= ",region_end_id='" .$_POST['region_end_point_id']. "'";
			$value .= ",city_departure_id='" .$_POST['departure_point_id']. "'";
			$value .= ",city_end_id='" .$_POST['end_point_id']. "'";
			
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$image_banner = isset($_POST['image_banner_src']) ? $_POST['image_banner_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
				$image_banner = isset($_POST['isoman_url_image_banner']) ? $_POST['isoman_url_image_banner'] : '';
			}
			if ($image != '' && $image != '0' ||$image_banner != '' && $image_banner != '0') {
				$value .= ",image='" . addslashes($image) . "',image_banner='" . addslashes($image_banner) . "'";
			}
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$value .= ",is_online='".$is_online."'";
			//print_r($pvalTable.'xxxx'.$value); die();
			if ($clsClassTable->updateOne($pvalTable, $value)) {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess');
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($pvalTable) . '&message=updateFailed');
			}
		}else{
			$listTable=$clsClassTable->getAll("1=1", $clsClassTable->pkey.",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no=$listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey],"order_no='".$order_no."'");
			}
			$value    = "";
			$firstAdd = 0;
			$field    = "";
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
			
			$arr_departure_point =array();
			$arr_departure_point['country_departure_point_id'] = $_POST['country_departure_point_id'];
			$arr_departure_point['region_departure_point_id'] = $_POST['region_departure_point_id'];  
			$arr_departure_point['departure_point_id'] = $_POST['departure_point_id'];  
			
			$arr_end_point =array();
			$arr_end_point['country_end_point_id'] = $_POST['country_end_point_id'];
			$arr_end_point['region_end_point_id'] = $_POST['region_end_point_id'];  
			$arr_end_point['end_point_id'] = $_POST['end_point_id'];  
				
			
			
			$transfer_id = $clsClassTable->getMaxId();
			$field .= ",user_id,user_id_update,reg_date,upd_date,title,slug,transfer_id,departure_point_id,end_point_id,country_departure_id,country_end_id,region_departure_id,region_end_id,city_departure_id,city_end_id,order_no";
			$value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
			$value .= ",'" .ucwords($_POST['title']) . "','" . str_replace('$', '', $core->replaceSpace($_POST['title'])) . "','" . $transfer_id . "','".serialize($arr_end_point)."','".serialize($arr_departure_point)."','".$_POST['country_departure_point_id']."','".$_POST['country_end_point_id']."','".$_POST['region_departure_point_id']."','".$_POST['region_end_point_id']."','".$_POST['departure_point_id']."','".$_POST['end_point_id']."','1'";
		
			
				#--Special Field: image
			
			$image     = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$image_banner     = isset($_POST['image_banner_src']) ? $_POST['image_banner_src'] : '';
			if (_isoman_use) {
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
				$image_banner = isset($_POST['isoman_url_image_banner']) ? $_POST['isoman_url_image_banner'] : '';
			}
			if ($image != '' && $image != '0' || $image_banner != '' && $image_banner != '0') {
				$field .= ',image';
				$value .= ",'" . addslashes($image) . "'";
				$field .= ',image_banner';
				$value .= ",'" . addslashes($image_banner) . "'";
			}
			$pUrl = '';
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$field .= ',is_online';
			$value .= ",'".$is_online."'";
			//print_r($field.'xxxx'.$value); die();
			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_EDIT') {
					header('location:' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($transfer_id) . '&message=insertSuccess');
				} else {
					header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
				}
			} else {
				header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertFailed');
			}

		}

    }
    if (isset($_POST['UpdateStep2']) && $_POST['UpdateStep2'] == 'UpdateStep2') {
		$value .= "list_car_id='" . $clsISO->makeSlashListFromArrayComma($_POST['list_car_id']) . "'";
		if ($clsClassTable->updateOne($pvalTable, $value)) {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess');
		} else {
			header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($pvalTable) . '&message=updateFailed');
		}
	}
    
	
    if (isset($_POST['UpdateStep6']) && $_POST['UpdateStep6'] == 'UpdateStep6') {
        $titleMeta=$_POST['config_value_title']?addslashes($_POST['config_value_title']):$clsClassTable->getTitle($pvalTable);
		$introMeta=strip_tags(html_entity_decode(addslashes($clsClassTable->getOneField('overview',$pvalTable))));
		$descriptionMeta=$_POST['config_value_intro']?addslashes($_POST['config_value_intro']):substr($introMeta,0,160);
		$image_seo     = isset($_POST['image_seo_src']) ? $_POST['image_seo_src'] : '';
		if (_isoman_use) {
			$image_seo     = $_POST['isoman_url_image_seo'];
		}
		$image_seo=$image_seo?$image_seo:$clsClassTable->getOneField('image',$pvalTable);
		if($meta_id==''){
			$clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,meta_index,meta_follow","'".$linkMeta."','".$titleMeta."','".$descriptionMeta."','".$image_seo."','".time()."','".time()."','".$clsMeta->getMaxId()."','".$_POST['meta_index']."','".$_POST['meta_follow']."'");
			$allMeta = $clsMeta->getAll("config_link='".$linkMeta."'");
		}else{
			$clsMeta->updateOne($meta_id,"config_value_intro='".$descriptionMeta."',config_value_title='".$titleMeta."',image='".$image_seo."',upd_date='".time()."',meta_index='".addslashes($_POST['meta_index'])."',meta_follow='".addslashes($_POST['meta_follow'])."'");
		}
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&transfer_id=' . $core->encryptID($pvalTable) . '&message=UpdateSuccess');
    }
   
}

function default_trash() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
	#
    $classTable = "Transfer";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $pvalTable = intval($core->decryptID($string));
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $pUrl = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != $pkeyTable && $tmp[0] != 'act')
            $pUrl .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    #
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=TrashSuccess');
    }
}

function default_restore() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];

    $classTable = "Transfer";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $pvalTable = intval($core->decryptID($string));
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $pUrl = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != $pkeyTable && $tmp[0] != 'act')
            $pUrl .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=RestoreSuccess');
    }
}

function default_delete() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
	$clsTransferImage= new TransferImage();
    $classTable = "Transfer";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $pvalTable = intval($core->decryptID($string));
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $pUrl = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != $pkeyTable && $tmp[0] != 'act')
            $pUrl .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->doDelete($pvalTable)) {
		 $clsTransferImage->deleteByCond("transfer_id='$pvalTable'");
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=DeleteSuccess');
    }
}


function default_ajOpenManageTransferCarPrice(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
	$user_id = $core->_USER['user_id'];
	#
	$clsTransfer = new Transfer();
	$clsTransferPrice = new TransferPrice();
	$clsCar = new Car();
	$clsProperty = new Property();
	
	$transfer_id = isset($_POST['transfer_id'])?intval($_POST['transfer_id']):0;
	$car_id = isset($_POST['car_id'])?intval($_POST['car_id']):0;
	$type_of_trip_id = isset($_POST['type_of_trip_id'])?intval($_POST['type_of_trip_id']):0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	
	if($tp=='L'){
		$html = '';
		if($lstCar){
			$html .= '
			<table class="table tbl-grid" style="border:1px solid #ccc; min-width:100%;">
				<thead>
					<tr>
						<td rowspan="2" class="gridheader">
							<strong><span class="table_price_title">'.$core->get_Lang('Vehicle').'</span></strong>
						</td>';
				foreach($lstTypeTrip as $k=>$v){	
				$html .='<td class="gridheader" style="text-align:center;" colspan="'.(count($lstCarSeat)*2).'">
							<strong>'.$clsProperty->getTitle($v[$clsProperty->pkey]).'</strong> 
						</td>';
				}
				$html .='</tr>
				<tr>';
				foreach($lstTypeTrip as $a=>$b){
					foreach($lstCarSeat as $k=>$v){
						$html .= '<td class="gridheader" style="text-align:center;">'.$clsProperty->getTitle($v[$clsProperty->pkey]).'</td>';
						$html .= '<td class="gridheader" style="text-align:center;">'.$core->get_Lang('Km+').'</td>';
					}
				}
				$html.= '
				</tr>
			</thead>';
			foreach($lstCar as $key=>$val){
				$html .= '
				<tr>
					<td style="text-align:left;">'.$clsCar->getTitle($val[$clsCar->pkey]).'</td>';
					foreach($lstTypeTrip as $a=>$b){
						foreach($lstCarSeat as $k=>$v){
							$html .= '
							<td class="text-center">
								'.$clsISO->getRate().'<br />
								<input class="text full price-In h_transfer_price fontLarge" style="width:60px; text-align:right; color:red;" transfer_id="'.$transfer_id.'" car_id="'.$val[$clsCar->pkey].'" type_of_trip_id="'.$clsProperty->getOneField('min_value',$b[$clsProperty->pkey]).'" seat_id="'.$v[$clsProperty->pkey].'" value="'.$clsTransferPrice->getPrice($transfer_id,$val[$clsCar->pkey],$v[$clsProperty->pkey],$clsProperty->getOneField('min_value',$b[$clsProperty->pkey])).'" type="text" />
							</td>';
							$html .= '
							<td class="text-center">
								'.$clsISO->getRate().'<br />
								<input class="text full price-In h_transfer_price_kmplus fontLarge" style="width:60px; text-align:right; color:red;" transfer_id="'.$transfer_id.'" car_id="'.$val[$clsCar->pkey].'" type_of_trip_id="'.$clsProperty->getOneField('min_value',$b[$clsProperty->pkey]).'" seat_id="'.$v[$clsProperty->pkey].'" value="'.$clsTransferPrice->getPriceKmPlus($transfer_id,$val[$clsCar->pkey],$v[$clsProperty->pkey],$clsProperty->getOneField('min_value',$b[$clsProperty->pkey])).'" type="text" />
							</td>';	
						}
					}
				$html .= '</tr>';
			}
			$html .= '</table>';
		}else{
			$html .= '<div class="infobox"><b>'.$core->get_Lang('warning').'</b><br>'.$core->get_Lang('nodata').'</div>';
		}
		#
		echo($html);die();
	}
	else if($tp=='S'){
		$price = $_POST['price'];
		$res = $clsTransferPrice->getAll("transfer_id='$transfer_id' and car_id='$car_id' and type_of_trip_id='$type_of_trip_id'");
		if($res[0]['transfer_price_id'] != ''){
			$clsTransferPrice->updateOne($res[0]['transfer_price_id'],"price='".$clsISO->processFloatNumber($price)."'");
		}else{
			$f = "transfer_id,car_id,type_of_trip_id,price,user_id,user_id_update,reg_date,upd_date";
			$v = "'$transfer_id'
				,'$car_id'
				,'$type_of_trip_id'
				,'".$clsISO->processFloatNumber($price)."'
				,'$user_id'
				,'$user_id'
				,'".time()."'
				,'".time()."'
			";
			$clsTransferPrice->insertOne($f, $v);	
		}
		echo '0|||'.$clsISO->processFloatNumber($price); die();
	}
	else if($tp=='SPLUS'){
		$price_km_plus = $_POST['price_km_plus'];
		$res = $clsTransferPrice->getAll("transfer_id='$transfer_id' and car_id='$car_id' and type_of_trip_id='$type_of_trip_id'");
		if($res[0]['transfer_price_id'] != ''){
			$clsTransferPrice->updateOne($res[0]['transfer_price_id'],"price_km_plus='".$clsISO->processSmartNumber($price_km_plus)."'");
		}else{
			$f = "transfer_id,car_id,type_of_trip_id,price_km_plus,user_id,user_id_update,reg_date,upd_date";
			$v = "'$transfer_id'
				,'$car_id'
				,'$type_of_trip_id'
				,'".$clsISO->processSmartNumber($price_km_plus)."'
				,'$user_id'
				,'$user_id'
				,'".time()."'
				,'".time()."'
			";
			$clsTransferPrice->insertOne($f, $v);	
		}
		echo '0|||'.$clsISO->formatPrice($price_km_plus); die();
	}
}

/* ------ Load Tour Gallery ------- */

function default_ajInitTSysTransferGallery() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    #
    $clsTransferImage = new TransferImage();
    $table_id = $_POST['table_id'];
    #
    $html = '';
    $html .= '
	<div class="wrap">
		<div class="group_button fl">
			<form method="post" action="" accept="application/pdf" id="aj-upload-form" enctype="multipart/form-data">
				<input style="display:none" type="file" multiple="" name="image[]" id="ajAttachFile" />
				<a style="display:none" id="ajSysPhotosGallery" table_id="' . $table_id . '" class="iso-button-primary fl mr10">
					<i class="icon-random"></i>&nbsp; ' . $core->get_Lang('synchronizeposition') . '
				</a>
				<a table_id="' . $table_id . '" isoman_multiple="1" class="iso-button-standard ajOpenDialog fl mr10" isoman_for_id="image_val" isoman_name="image"><i class="icon-plus-sign"></i>&nbsp; ' . $core->get_Lang('addimages') . '</a>
				<input type="hidden" value="' . $table_id . '" name="table_id" id="Hid_TableID"/>
				<input type="hidden" value="' . $type . '" name="type" id="Hid_TypeID"/>
			</form>
		</div>
	</div>';
    $html .= '
	<div class="clearfix"><br /></div>
	<div class="hastable">
		<table class="full-width tbl-grid" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<td class="gridheader"><strong>' . $core->get_Lang('index') . '</strong></td>
					<td class="gridheader"><strong>' . $core->get_Lang('images') . '</strong></td>
					<td class="gridheader text-left"><strong>' . $core->get_Lang('alttext') . '</strong></td>
					<td class="gridheader" style="width:12%"><strong>' . $core->get_Lang('update') . '</strong></td>
					<td class="gridheader" style="width:6%;"><strong>' . $core->get_Lang('func') . '</strong></td>
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
						url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
						data: {\'tp\':\'D\', \'tour_image_id\': $_this.attr(\'data\')},
						dataType: "html",
						success: function(html){
							var $table_id = $(\'#Hid_TableID\').val();
							loadTableGallery($table_id,\'\',1,10);
							checkSysPosition();
						}
					});
				}
			});
			$(document).on(\'click\', \'.ajeditPhotosGallery\', function(ev){
				var $_this = $(this);
				var $tour_image_id = $_this.attr(\'data\');
				var $table_id = $_this.attr(\'table_id\');
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
					data: {\'tp\':\'C\',\'tour_image_id\' : $tour_image_id,\'table_id\' : $table_id},
					dataType: "html",
					success: function(html){
						makepopup(\'240px\',\'auto\',html,\'box_EditPhotosGallery\');
					}
				});
				return false;
			});
			$(document).on(\'click\', \'.ajmovePhotosGallery\', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type:\'POST\',
					url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
					data: {
						\'tour_image_id\' : $_this.attr(\'data\'),
						\'direct\' : $_this.attr(\'direct\'),
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
				var $keywrord = \'\';
				loadTableGallery($table_id,$keywrord,$_this.attr(\'page\'),10);
				return false;
			});
			$(\'#keysearch_pop\').bind(\'keyup change\',function(){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				var $page = $(\'#Hid_CurrentPage\').val();
				loadTableGallery($table_id,$_this.val(),$page,3);
			});
			$(document).on(\'click\', \'#ajSysPhotosGallery\', function(ev){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				vietiso_loading(1);
				$.ajax({
					type:\'POST\',
					url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
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
			var $page = $(\'#Hid_CurrentPage\').val();
			var $clsTable = \'TransferImage\';
			var $type= \'TransferImage\';
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
			var $table_id = $(\'#Hid_TableID\').val();
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
				data: {\'table_id\':$table_id,\'tp\':\'TOTAL\'},
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

function default_ajOpenTransferGallery() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn;
    #
    $clsPagination = new Pagination();
    $clsTransferImage = new TransferImage();
    $pkeyTable = $clsTransferImage->pkey;

    $tour_image_id = isset($_POST['tour_image_id']) ? intval($_POST['tour_image_id']) : 0;
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
        $totalRecord = $clsTransferImage->getAll($cond)?count($clsTransferImage->getAll($cond)):0;
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no asc";
        $limit = " LIMIT $offset,$number_per_page";

        $lstItem = $clsTransferImage->getAll($cond . $order_by . $limit);
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $tour_image_id = $lstItem[$i][$clsTransferImage->pkey];
                #
                $html .= '<tr style="cursor:move" id="order_'.$tour_image_id.'" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index">' . ($offset +$i + 1) . '</td>';
                $html .= '<td width="100px"><a href="javascript:void();" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><img src="' . $ftp_abs_path_image . $lstItem[$i]['image'] . '" width="90" height="60" /></a></td>';
                $html .= '<td>
				
				<input class="editTitleImage" data="' . $tour_image_id . '" table_id="' . $table_id . '" value="'.$clsTransferImage->getTitle($tour_image_id).'" style="line-height:28px; font-size:12px; padding:0 10px" />
				<a style="display:none" href="javascript:void(0);" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><strong>' . $clsTransferImage->getTitle($tour_image_id) . '</strong></a>
				
				</td>';
                $html .= '<td style="text-align:right;color:#c00000">' . date('d-m-Y h:i', $lstItem[$i]['reg_date']) . '</td>';
				if(1==2){
                $html .= '<td style="text-align:center">' . ($i == 0 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="movetop" title="' . $core->get_Lang('movetop') . '" data="' . $tour_image_id . '" table_id="' . $table_id . '"><i class="icon-circle-arrow-up"></i></a>') . '</td>';
                $html .= '<td style="text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="movebottom" title="' . $core->get_Lang('movebottom') . '" table_id="' . $table_id . '"><i class="icon-circle-arrow-down"></i></a>') . '</td>';
                $html .= '<td style="text-align:center">' . ($i == 0 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="moveup" title="' . $core->get_Lang('moveup') . '" table_id="' . $table_id . '"><i class="icon-arrow-up"></i></a>') . '</td>';
                $html .= '<td style="text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a href="javascript:void();" class="ajmovePhotosGallery" direct="movedown" title="' . $core->get_Lang('movedown') . '" data="' . $tour_image_id . '" table_id="' . $table_id . '"><i class="icon-arrow-down"></i></a>') . '</td>';
				}
                $html .= '
				<td style="vertical-align:middle; width:6%;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button> 
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a href="javascript:void(0);" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><i class="icon-edit"></i> ' . $core->get_Lang('edit') . '</a></li>
							<li><a href="javascript:void(0);" table_id="' . $table_id . '" data="' . $tour_image_id . '" title="' . $core->get_Lang('delete') . '" class="ajdeletePhotosGallery"><i class="icon-remove"></i> ' . $core->get_Lang('delete') . '</a></li>
						</ul>
					</div>
				</td>';
                $html .= '</tr>';
            }
			$html.='
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
						var page = "'.$page.'";
						var order = $(this).sortable("serialize")+\'&update=update\'+\'&recordPerPage='.$number_per_page.'\'+\'&currentPage='.$page.'\';
						$.post(path_ajax_script+"/index.php?mod=transfer&act=ajUpdPosTourGallery", order, function(html){
							loadTableGallery(transfer_id, \'\', page, 10);
							vietiso_loading(0);
						});
					}
				});
				
				$(".editTitleImage").live("change", function() {
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script + "/?mod=" + mod + "&act=ajOpenTransferGallery",
					data: {
						"table_id": $_this.attr("table_id"),
						"tour_image_id": $_this.attr("data"),
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
    }
    // Delete
    else if ($tp == 'D') {
        $clsTransferImage->deleteOne($tour_image_id);
        echo (1);
        die();
    }
    // Quick Create
    else if ($tp == 'Q') {
        $fx = "table_id,order_no,reg_date";
        $vx = "'$table_id','" . $clsTransferImage->getMaxOrderNo($table_id) . "','" . time() . "'";
        $clsTransferImage->insertOne($fx, $vx);
        echo (1);
        die();
    }
    // Edit Upload Form
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
					<input type="text" name="title" class="text full required" style="width:100%" value="' . $clsTransferImage->getTitle($tour_image_id) . '">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						<img src="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" id="isoman_show_image_val" />
						<input type="hidden" id="isoman_hidden_image_val" name="isoman_url_image" value="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image_val" isoman_val="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" isoman_name="image">
							<i class="iso-edit"></i>
						</a>';
						if($clsTransferImage->getOneField('image', $tour_image_id)!=''){
						  $HTML .= '<a pvalTable="'.$tour_image_id.'" clsTable="TransferImage" href="javascript:void()" title="'.$core->get_Lang('delete').'" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a> ';
						}
					 $HTML .= '</div>
				</td>
			</tr>
		</table>
		<div class="clear"><br /></div>';
        $HTML .= '<div class="modal-footer wrap">
					<a href="javascript:void(0);" class="iso-button-standard submitClick fr btnClickUpdate" tour_image_id="' . $tour_image_id . '" table_id="' . $table_id . '" ><img align="absmiddle" src="' . URL_IMAGES . '/v2/check.png"> ' . $core->get_Lang('save') . '</a>
			   </div>';
        $HTML .= '</form>';
        $HTML .= '
		<script type="text/javascript">
			$(function(){
				$(document).on(\'click\', \'.btnClickUpdate\', function(){
					var $_this = $(this);
					var $_form = $_this.closest(\'.frmPop\');
					var $title = $_form.find(\'input[name=title]\');
					if($title.val()==\'\'){
						$title.focus();
						alertify.error(field_is_required);
						return false;
					};
					$(\'#aj-update-form\').ajaxSubmit({
						type:\'POST\',
						url: path_ajax_script+"/index.php?mod=transfer&act=ajOpenTransferGallery",
						data : {\'tp\':\'S\',\'tour_image_id\': $_this.attr(\'tour_image_id\')},
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
    }
    // Save
    else if ($tp == 'S') {
        $titlePost = addslashes($_POST['title']);
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            $set = "title='" . $titlePost . "',slug='" . $core->replaceSpace($titlePost) . "',reg_date='" . time() . "'";
            if ($_POST['isoman_url_image'] != '' && $_POST['isoman_url_image'] != '0') {
                $set .= ",image='" . addslashes($_POST['isoman_url_image']) . "'";
            }
            if ($clsTransferImage->updateOne($tour_image_id, $set)) {
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
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
        $one = $clsTransferImage->getOne($tour_image_id);
        $table_id = $one['table_id'];
        $order_no = $one['order_no'];
        #
        $where = "table_id='$table_id'";
        if ($direct == 'moveup') {
            $lst = $clsTransferImage->getAll($where . " and order_no>$order_no order by order_no asc limit 0,1");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTransferImage->updateOne($lst[0][$clsTransferImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsTransferImage->getAll($where . " and order_no<$order_no order by order_no desc limit 0,1");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTransferImage->updateOne($lst[0][$clsTransferImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsTransferImage->getAll($where . " and order_no>$order_no order by order_no asc");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTransferImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no>$order_no order by order_no asc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTransferImage->updateOne($lst[$i][$clsTransferImage->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
                }
                unset($lst);
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsTransferImage->getAll($where . " and type='$type' and order_no<$order_no order by order_no desc");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTransferImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no<$order_no order by order_no desc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTransferImage->updateOne($lst[$i][$clsTransferImage->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
                }
                unset($lst);
            }
        }
        echo (1);
        die();
    } else if ($tp == 'TOTAL') {
        echo $clsTransferImage->getAll("is_trash=0 and table_id='$table_id'")?count($clsTransferImage->getAll("is_trash=0 and table_id='$table_id'")):0;
        die();
    } else if ($tp == 'SYS') {
        $LISTALL = $clsTransferImage->getAll("is_trash=0 and table_id='$table_id' order by tour_image_id asc");
        if (!empty($LISTALL)) {
            for ($i = 0; $i < count($LISTALL); $i++) {
                $clsTransferImage->updateOne($LISTALL[$i][$clsTransferImage->pkey], "order_no='" . ($i + 1) . "'");
            }
            unset($LISTALL);
        }
        echo (1);
        die();
    }
    echo (1);
    die();
}


function default_ajOpenTransferGalleryNew() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn;
    #
    $clsPagination = new Pagination();
    $clsTransferImage = new TransferImage();
    $pkeyTable = $clsTransferImage->pkey;

    $tour_image_id = isset($_POST['tour_image_id']) ? intval($_POST['tour_image_id']) : 0;
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
        $totalRecord = $clsTransferImage->getAll($cond)?count($clsTransferImage->getAll($cond)):0;
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no asc";
        $limit = " LIMIT $offset,$number_per_page";

        $lstItem = $clsTransferImage->getAll($cond . $order_by . $limit);
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $tour_image_id = $lstItem[$i][$clsTransferImage->pkey];
                #
                $html .= '<tr style="cursor:move" id="order_'.$tour_image_id.'" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index">' . ($offset+$i+1) . '</td>';
                $html .= '<td width="60px"><img src="' . $ftp_abs_path_image . $lstItem[$i]['image'] . '" width="60" height="40" /></td>';
                $html .= '<td><a href="javascript:void();" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><strong>' . $clsTransferImage->getTitle($tour_image_id) . '</strong></a></td>';
                $html .= '<td style="text-align:right;color:#c00000">' . date('d-m-Y h:i', $lstItem[$i]['reg_date']) . '</td>';
				if(1==2){
                $html .= '<td style="text-align:center">' . ($i == 0 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="movetop" title="' . $core->get_Lang('movetop') . '" data="' . $tour_image_id . '" table_id="' . $table_id . '"><i class="icon-circle-arrow-up"></i></a>') . '</td>';
                $html .= '<td style="text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="movebottom" title="' . $core->get_Lang('movebottom') . '" table_id="' . $table_id . '"><i class="icon-circle-arrow-down"></i></a>') . '</td>';
                $html .= '<td style="text-align:center">' . ($i == 0 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="moveup" title="' . $core->get_Lang('moveup') . '" table_id="' . $table_id . '"><i class="icon-arrow-up"></i></a>') . '</td>';
                $html .= '<td style="text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a href="javascript:void();" class="ajmovePhotosGallery" direct="movedown" title="' . $core->get_Lang('movedown') . '" data="' . $tour_image_id . '" table_id="' . $table_id . '"><i class="icon-arrow-down"></i></a>') . '</td>';
				}
                $html .= '
				<td style="vertical-align:middle; width:6%;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button> 
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a href="javascript:void(0);" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><i class="icon-edit"></i> ' . $core->get_Lang('edit') . '</a></li>
							<li><a href="javascript:void(0);" table_id="' . $table_id . '" data="' . $tour_image_id . '" title="' . $core->get_Lang('delete') . '" class="ajdeletePhotosGallery"><i class="icon-remove"></i> ' . $core->get_Lang('delete') . '</a></li>
						</ul>
					</div>
				</td>';
                $html .= '</tr>';
            }
			$html.='
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
						var page = "'.$page.'";
						var order = $(this).sortable("serialize")+\'&update=update\'+\'&recordPerPage='.$number_per_page.'\'+\'&currentPage='.$page.'\';
						$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosTourGallery", order, function(html){
							loadTableGallery(transfer_id, \'\', page, 10);
							vietiso_loading(0);
						});
					}
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
    }
    // Delete
    else if ($tp == 'D') {
        $clsTransferImage->deleteOne($tour_image_id);
        echo (1);
        die();
    }
    // Quick Create
    else if ($tp == 'Q') {
        $fx = "table_id,order_no,reg_date";
        $vx = "'$table_id','" . $clsTransferImage->getMaxOrderNo($table_id) . "','" . time() . "'";
        $clsTransferImage->insertOne($fx, $vx);
        echo (1);
        die();
    }
    // Edit Upload Form
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
					<input type="text" name="title" class="text full required" style="width:96%" value="' . $clsTransferImage->getTitle($tour_image_id) . '">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						<img src="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" id="isoman_show_image_val" />
						<input type="hidden" id="isoman_hidden_image_val" name="isoman_url_image" value="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image_val" isoman_val="' . $clsTransferImage->getOneField('image', $tour_image_id) . '" isoman_name="image">
							<i class="iso-edit"></i>
						</a>';
						if($clsTransferImage->getOneField('image', $tour_image_id)!=''){
						  $HTML .= '<a pvalTable="'.$tour_image_id.'" clsTable="TransferImage" href="javascript:void()" title="'.$core->get_Lang('delete').'" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a> ';
						}
					 $HTML .= '</div>
				</td>
			</tr>
		</table>
		<div class="clear"><br /></div>';
        $HTML .= '<div class="modal-footer wrap">
					<a href="javascript:void(0);" class="iso-button-standard submitClick fr btnClickUpdate" tour_image_id="' . $tour_image_id . '" table_id="' . $table_id . '" ><img align="absmiddle" src="' . URL_IMAGES . '/v2/check.png"> ' . $core->get_Lang('save') . '</a>
			   </div>';
        $HTML .= '</form>';
        $HTML .= '
		<script type="text/javascript">
			$(function(){
				$(document).on(\'click\', \'.btnClickUpdate\', function(){
					var $_this = $(this);
					var $_form = $_this.closest(\'.frmPop\');
					var $title = $_form.find(\'input[name=title]\');
					if($title.val()==\'\'){
						$title.focus();
						alertify.error(field_is_required);
						return false;
					};
					$(\'#aj-update-form\').ajaxSubmit({
						type:\'POST\',
						url: path_ajax_script+"/index.php?mod=tour&act=ajOpenTransferGallery",
						data : {\'tp\':\'S\',\'tour_image_id\': $_this.attr(\'tour_image_id\')},
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
    }
    // Save
    else if ($tp == 'S') {
        $titlePost = addslashes($_POST['title']);
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            $set = "title='" . $titlePost . "',slug='" . $core->replaceSpace($titlePost) . "',reg_date='" . time() . "'";
            if ($_POST['isoman_url_image'] != '' && $_POST['isoman_url_image'] != '0') {
                $set .= ",image='" . addslashes($_POST['isoman_url_image']) . "'";
            }
            if ($clsTransferImage->updateOne($tour_image_id, $set)) {
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
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
        $one = $clsTransferImage->getOne($tour_image_id);
        $table_id = $one['table_id'];
        $order_no = $one['order_no'];
        #
        $where = "table_id='$table_id'";
        if ($direct == 'moveup') {
            $lst = $clsTransferImage->getAll($where . " and order_no>$order_no order by order_no asc limit 0,1");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTransferImage->updateOne($lst[0][$clsTransferImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsTransferImage->getAll($where . " and order_no<$order_no order by order_no desc limit 0,1");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTransferImage->updateOne($lst[0][$clsTransferImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsTransferImage->getAll($where . " and order_no>$order_no order by order_no asc");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTransferImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no>$order_no order by order_no asc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTransferImage->updateOne($lst[$i][$clsTransferImage->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
                }
                unset($lst);
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsTransferImage->getAll($where . " and type='$type' and order_no<$order_no order by order_no desc");
            $clsTransferImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTransferImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no<$order_no order by order_no desc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTransferImage->updateOne($lst[$i][$clsTransferImage->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
                }
                unset($lst);
            }
        }
        echo (1);
        die();
    } else if ($tp == 'TOTAL') {
        echo $clsTransferImage->getAll("is_trash=0 and table_id='$table_id'")?count($clsTransferImage->getAll("is_trash=0 and table_id='$table_id'")):0;
        die();
    } else if ($tp == 'SYS') {
        $LISTALL = $clsTransferImage->getAll("is_trash=0 and table_id='$table_id' order by tour_image_id asc");
        if (!empty($LISTALL)) {
            for ($i = 0; $i < count($LISTALL); $i++) {
                $clsTransferImage->updateOne($LISTALL[$i][$clsTransferImage->pkey], "order_no='" . ($i + 1) . "'");
            }
            unset($LISTALL);
        }
        echo (1);
        die();
    }
    echo (1);
    die();
}

function default_ajUpdPosTourGallery(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTransferImage = new TransferImage();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key + 1);
		$clsTransferImage->updateOne($val,"order_no='".$key."'");	
	}
}



function default_ajLoadRegion(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsRegion = new Region();
	#
	$country_id = isset($_POST['country_id'])?intval($_POST['country_id']):0;
	$region_id = isset($_POST['region_id'])?intval($_POST['region_id']):0;
	#
	$cond = "is_trash=0 and is_online=1";
	if($country_id > 0) {$cond.= " and country_id = '$country_id'";}
	if($clsRegion->getAll($cond)!='') {
		$html = $clsRegion->makeSelectboxOption($country_id,$region_id);
	} else {
		$html = 'EMPTY';
	}
	echo $html; die();
}
function default_ajmakeSelectCityGlobal(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsCity = new City();
	$country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
	$region_id = isset($_POST['region_id']) ? intval($_POST['region_id']) : 0;
	$city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;
	#
	$cond = "is_trash=0 and is_online=1";
	if($country_id > 0){$cond .= " and country_id='$country_id'";}
	if($region_id > 0){$cond .= " and region_id='$region_id'";}
	#
	$html = '<option value="0">'.$core->get_Lang('selectcity').'</option>';
	if($clsCity->getAll($cond)!='') {
		$lstCity = $clsCity->getAll($cond." order by slug asc", $clsCity->pkey);
		
		if(!empty($lstCity)){
			foreach($lstCity as $k => $v){
				$html .= '<option value="'.$v[$clsCity->pkey].'" '.($city_id==$v[$clsCity->pkey]?'selected="selected"':'').'>'.$clsCity->getTitle($v[$clsCity->pkey]).'</option>';
			}
			unset($lstCity);
	
		}
	} else {
		$html = 'EMPTY';
	}
	echo $html; die();
}

?>