<?php
function default_default() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;

    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $clsServiceCategory                = new ServiceCategory();
    $assign_list["clsServiceCategory"] = $clsServiceCategory;
	#
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
	$servicecat_id                   = isset($_GET['servicecat_id']) ? intval($_GET['servicecat_id']) : 0;
    $assign_list["servicecat_id"]    = $servicecat_id;
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		 $link = '';
        if (isset($_POST['servicecat_id']) && $_POST['servicecat_id'] != '') {
            $link .= '&servicecat_id=' . $_POST['servicecat_id'];
        }
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }

    /**/
    $classTable = "Service";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    /* List all item */
    $cond = "1='1'";
    $pUrl = '';
    if ($servicecat_id > 0) {
        $cond .= " and cat_id = '" . $servicecat_id . "'";
        $pUrl .= '&servicecat_id=' . $servicecat_id;
    }
    #Filter By Keyword
    if (isset($_GET['keyword'])) {
        if ($_GET['keyword'] != '') {
            $keyword = $core->replaceSpace($_GET['keyword']);
            $cond .= " and slug like '%" . $keyword . "%'";
            $assign_list["keyword"] = $_GET['keyword'];
        }
    }
	$assign_list["pUrl"] = $pUrl;
    $cond2 = $cond;
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
	
	$stt=($currentPage-1)*$recordPerPage;
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
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit); //print_r($allItem);die();
    $assign_list["allItem"] = $allItem;
    #
    $allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2);
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2);
    $assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
    #
    $allAll = $clsClassTable->getAll($cond2);
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;

    #----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateService') {
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
function default_ajUpdPosSortListService(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	
	$classTable = "Service";
    $clsClassTable = new $classTable;
	
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key+1);
		$clsClassTable->updateOne($val,"order_no='".$key."'");	
	}
}
function default_edit() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration,$clsISO,$pvalTable,$clsClassTable;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Service";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
	$clsServiceCategory                = new ServiceCategory();
    $assign_list["clsServiceCategory"] = $clsServiceCategory;
    $servicecat_id                     = isset($_GET['servicecat_id']) ? intval($_GET['servicecat_id']) : 0;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;
	 if ($pvalTable > 0) {
        $servicecat_id = $oneItem['cat_id'];
    }
    $assign_list["servicecat_id"] = $servicecat_id;

    #-------------Update Config Meta
	$clsMeta = new Meta();$assign_list["clsMeta"] = $clsMeta;
	$linkMeta = $clsClassTable->getLink($pvalTable);
	$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'];
	$assign_list["meta_id"] = $meta_id; 
	$assign_list["oneMeta"] = $clsMeta->getOne($meta_id); 

    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;
    $clsForm->addInputTextArea("full",'intro', "", 'intro', 255, 25, 5, 1,  "style='width:100%'");
    $clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 25, 1, "style='width:100%'");
	#
    if($string!='' && $pvalTable==0){
		header('location:'.PCMS_URL.'/index.php?&mod='.$mod.'&message=notPermission');
	}
	#
	if(intval($pvalTable) > 0 && $clsConfiguration->getValue('SiteHasTags_Service')){
		#---Edit Tags of post
		$clsTag = new Tag(); $assign_list["clsTag"] = $clsTag;
		$listAllTag = $clsTag->getAll("1=1 and title<>'' order by title asc limit 0,5000");
		#
		$listAvailableTag = '<script type="text/javascript">var availableTags = [';
		for($i=0;$i<count($listAllTag);$i++){
			$listAvailableTag .= '{ name: "'.$listAllTag[$i]['title'].'", val: "'.$listAllTag[$i]['title'].'" },';
		}
		$listAvailableTag .= '];</script>';
		$assign_list["listAvailableTag"] = $listAvailableTag;
		#
		$clsTagModule = new TagModule(); $assign_list["clsTagModule"] = $clsTagModule;
		$listTag = $clsTagModule->getAll("1=1 and for_id='$pvalTable' and type = '_SERVICE' order by reg_date asc limit 0,20");
		$assign_list["listTag"] = $listTag; unset($listAllTag); unset($listTag);
	}
	#=========================================#
    if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
        if($pvalTable>0){
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
			$title=$_POST['title'];
			$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
            $set .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
            $set .= ",upd_date='" . time() . "'";
			$set .= ",title='" .$title. "'";
            $set .= ",slug='" . $clsISO->replaceSpace2($_POST['title']) . "'";

            #--Special Field: image
            if (_isoman_use) {
				$image = $_POST['isoman_url_image'];
				 if ($image != '' && $image != '0') {
                	$set.= ",image = '".addslashes($image)."'";
				}
				if(!empty($_POST['image_child']) && $clsConfiguration->getValue('SiteHasIconChild_Service')) {
					 $set .= ",image_child='".addslashes($_POST['image_child'])."'";
				}
            } else {
                $image = $_POST['image'];
                if ($image != '' && $image != '0') {
                    $value .= ",image='" . addslashes($image) . "'";
                }
            }
			$pUrl = '';
            if ($clsConfiguration->getValue('SiteHasCat_Service')) {
                $cat_id      = $_POST['iso-cat_id'];
                $list_cat_id = $clsServiceCategory->getListParent($cat_id);
                $set .= ",list_cat_id='" . addslashes($list_cat_id) . "'";
                $pUrl .= '&servicecat_id=' . $cat_id;
            }
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$set .= ",is_online='".$is_online."'";
			//print_r($pvalTable.'xxxx'.$set); die();
            if ($clsClassTable->updateOne($pvalTable, $set)) {
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
                if($_POST['button']=='_EDIT'){
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&service_id='.$_GET[$clsClassTable->pkey].'&message=updateSuccess');
				}else{
					header('location: '.PCMS_URL.'/?mod='.$mod. $pUrl .'&message=updateSuccess');
				}
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod. $pUrl . '&message=updateFailed');
            }
        } else {
			$listTable=$clsClassTable->getAll("1=1", $clsClassTable->pkey.",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no=$listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey],"order_no='".$order_no."'");
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

            $max_id = $clsClassTable->getMaxId();
            $max_order = $clsClassTable->getMaxOrderNo();
			$title=$_POST['title'];
			$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
            $field .= ",user_id,user_id_update,reg_date,upd_date,title,slug,$clsClassTable->pkey,order_no";
            $value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
            $value .= ",'" .$title. "','" . $clsISO->replaceSpace2($_POST['title']) . "','" . $max_id . "','1'";

            #--Special Field: image
            if (_isoman_use) {
                $field.= ",image";
                $value .= ",'" . addslashes($_POST['isoman_url_image']) . "'";
            } else {
                $image = $_POST['image'];
                if ($image != '' && $image != '0') {
                    $value .= ",image='" . addslashes($image) . "'";
                }
            }
			
			$image_child = $_POST['image_child'];
			if ($image_child != '' && $image_child != '0') {
				$field.= ",image_child";
				$value .= ",'".addslashes($image_child)."'";
			}
			$pUrl = '';
            if ($clsConfiguration->getValue('SiteHasCat_Service')) {
                $cat_id      = $_POST['iso-cat_id'];
                $list_cat_id = $clsServiceCategory->getListParent($cat_id);
                $field .= ',list_cat_id';
                $value .= ",'" . addslashes($list_cat_id) . "'";
                $pUrl .= '&servicecat_id=' . $cat_id;
            }
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$field .= ',is_online';
			$value .= ",'".$is_online."'";
            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&' . $clsClassTable->pkey . '=' . $core->encryptID($max_id) . '&message=updateSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertFailed');
            }
        }
    }
}

function default_trash() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Service";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));

    if ($pvalTable == "")
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=TrashSuccess');
    }
}

function default_restore() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Service";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));

    if ($pvalTable == "")
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=RestoreSuccess');
    }
}

function default_delete() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Service";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));

    if ($string = '' && $pvalTable == 0)
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

    if (isset($_POST['agree']) && $_POST['agree'] == 'agree') {
        if ($clsClassTable->doDelete($pvalTable)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=DeleteSuccess');
        }
    }
}
function default_setting(){
	global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsConfiguration, $oneSetting,$clsISO;
	
	$clsMeta=new Meta();
	$assign_list['clsMeta']=$clsMeta;
	$user_id = $core->_USER['user_id'];
	
	$linkMeta = $clsISO->getLink($mod);
	
	$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'];
	#
	if(isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration'){
		foreach($_POST as $key=>$val){
			$tmp = explode('-',$key);
			if($tmp[0]=='iso'){
				$clsConfiguration->updateValue($tmp[1],$val);
			}
			if($tmp[0]=='date'){
				$clsConfiguration->updateValue($tmp[1],strtotime($val));
			}
		}
		if($_POST['config_value_title']!='' || $_POST['config_value_intro']!=''){
			if($meta_id==''){
				$clsMeta->insertOne("config_link,reg_date,meta_id","'".$linkMeta."','".time()."','".$clsMeta->getMaxID()."'");
				$allMeta = $clsMeta->getAll("config_link='".$linkMeta."'");
				$meta_id = $allMeta[0]['meta_id'];
			}
			$clsMeta->updateOne($meta_id,"config_value_intro='".addslashes($_POST['config_value_intro'])."',config_value_keyword='".addslashes($_POST['config_value_keyword'])."',config_value_title='".addslashes($_POST['config_value_title'])."',upd_date='".time()."',meta_index='".addslashes($_POST['meta_index'])."',meta_follow='".addslashes($_POST['meta_follow'])."',image='".addslashes($_POST['isoman_url_image_seo'])."'");
		}
		header('location:'.PCMS_URL.'?mod='.$mod.'&act='.$act.'&message=UpdateSuccess'.$extUrl);
	}	
}

/*========== SITE PROMOTION TAGS =============*/
function default_ajSiteServiceTags(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTag = new Tag(); 
	$clsTagModule = new TagModule();
	$for_id = isset($_POST['for_id'])?intval($_POST['for_id']):0;
	$tag_module_id = isset($_POST['tag_module_id'])?intval($_POST['tag_module_id']):0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	$type = isset($_POST['type']) ? $_POST['type'] : '';
	$user_id = $core->_USER['user_id'];
	#
	if($tp=='S'){
		$html = '';
		$val = isset($_POST['val'])?trim(addslashes($_POST['val'])):'';
		$slugPost = $core->replaceSpace($val);
		$tag_id = $clsTag->getBySlug($slugPost);
		#
		if($tag_id=='' || $tag_id==0) {
			$clsTag->insertOne("title,slug","'".addslashes($val)."','$slugPost'");
			$tag_id = $clsTag->getBySlug($slugPost);
		}
		$tag_module_id = $clsTagModule->getId($tag_id,$for_id,$type);
		if($tag_module_id=='' || $tag_module_id==0){
			$fx = "$clsTagModule->pkey,tag_id,for_id,type,user_id,reg_date,val";
			$vx = "'".$clsTagModule->getMaxID()."','$tag_id','$for_id','".$type."','".$user_id."','".time()."','1'";
			$clsTagModule->insertOne($fx,$vx);
			#
			$tag_module_id = $clsTagModule->getId($tag_id,$for_id,$type);
			$html.= '<span class="tagz"><a href="javascript:void(0);" class="closeTag" title="'.$core->get_Lang('delete').'" id="t-'.$tag_module_id.'">x</a>'.$val.'</span></div>';
			echo($html); die();
		} else {
			echo '_EXIST'; die();
		}
	} elseif($tp == 'D') {
		$clsTagModule->deleteOne($tag_module_id);
		echo 1; die();
	}
}
function default_category()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO,$package_id;
    $user_id = $core->_USER['user_id'];
    #- Check enable Module
	if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')){
		header('Location:/admin/index.php?lang='.LANG_DEFAULT);
		exit();
	}
    #- End Check
    $assign_list["msg"]           = isset($_GET['message']) ? $_GET['message'] : '';
    $type_list                    = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"]     = $type_list;
    #
    $classTable                   = "ServiceCategory";
    $clsClassTable                = new $classTable;
    $tableName                    = $clsClassTable->tbl;
    $pkeyTable                    = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"]     = $pkeyTable;
    $assign_list["clsService"]       = new Service();
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=' . $act;
        if ($_POST['keyword'] != '' && $_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location:' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    
    $cond = "1=1";
    #Filter By Keyword
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $cond .= " and slug like '%" . $core->replaceSpace($_GET['keyword']) . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    $orderBy                = " order by order_no asc";
    #
    $allItem                = $clsClassTable->getAll($cond . $orderBy);
    $assign_list["allItem"] = $allItem;
    unset($allItem);
    $assign_list["number_all"]   = $clsClassTable->getAll($cond2)?count($clsClassTable->getAll($cond2)):0;
    $assign_list["number_trash"] = $clsClassTable->getAll($cond2 . " and is_trash=1")?count($clsClassTable->getAll($cond2 . " and is_trash=1")):0;
    
    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string     = isset($_GET['servicecat_id']) ? ($_GET['servicecat_id']) : '';
        $servicecat_id = intval($core->decryptID($string));
        if ($string == '' && $servicecat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($servicecat_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string     = isset($_GET['servicecat_id']) ? ($_GET['servicecat_id']) : '';
        $servicecat_id = intval($core->decryptID($string));
        if ($string == '' && $servicecat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($servicecat_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string     = isset($_GET['servicecat_id']) ? ($_GET['servicecat_id']) : '';
        $servicecat_id = intval($core->decryptID($string));
        if ($string == '' && $servicecat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->doDelete($servicecat_id)) {
            header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $string    = isset($_GET['servicecat_id']) ? ($_GET['servicecat_id']) : '';
        $pvalTable = intval($core->decryptID($string));
        #
        if ($string == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        #
        $parent_id = isset($_GET['parent_id']) ? intval($_GET['parent_id']) : 0;
        $direct    = isset($_GET['direct']) ? $_GET['direct'] : '';
        $one       = $clsClassTable->getOne($pvalTable);
        $order_no  = $one['order_no'];
        
        $pUrl  = '&act=' . $act;
        $where = "is_trash=0";
        if ($parent_id > 0) {
            $where .= '&parent_id=' . $parent_id;
            $pUrl .= '&parent_id=' . $parent_id;
        }
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no DESC limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no ASC limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no asc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no desc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
    }
}

function default_ajUpdPosSortListServiceCat(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	
	$classTable = "ServiceCategory";
    $clsClassTable = new $classTable;
	
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key+1);
		$clsClassTable->updateOne($val,"order_no='".$key."'");	
	}
}
/*========== SITE BLOGS CATEGORY =========== */
function default_SiteServiceCategory()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsService       = new Service();
    $clsClassTable = new ServiceCategory();
    #
    $user_id       = $core->_USER['user_id'];
    $servicecat_id    = isset($_POST['servicecat_id']) ? intval($_POST['servicecat_id']) : 0;
    $tp            = isset($_POST['tp']) ? $_POST['tp'] : '';
    #
    if ($tp == 'F') {
        $html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . ($servicecat_id == 0 ? $core->get_Lang('add') : $core->get_Lang('edit')) . ' ' . $core->get_Lang('servicecategory') . '</h3>
		</div>';
        $html .= '
			<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
				<div class="wrap">
					<div class="row-span">
						<div class="fieldlabel text_left_767" style="text-align:right">' . $core->get_Lang('title') . ' <font color="red">*</font></div>
						<div class="fieldarea">
							<input class="text full required" name="title" value="' . $clsClassTable->getOneField('title', $servicecat_id) . '" type="text" autocomplete="off" />
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel text_left_767" style="text-align:right">' . $core->get_Lang('intro') . '</div>
						<div class="fieldarea">
							<textarea  id="textarea_service_intro_editor_' . time() . '" class="textarea_service_intro_editor" name="intro" style="width:100%">' . $clsClassTable->getOneField('intro', $servicecat_id) . '</textarea>
						</div>
					</div>
				</div>
			</form>
			<div class="modal-footer">
				<button type="button" servicecat_id="' . $servicecat_id . '" class="btn btn-primary btnClickToSubmitCategory">
					<i class="icon-ok icon-white"></i><span>' . $core->get_Lang('update') . '</span>
				</button>
				<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>Đóng lại</span> </button>		
			</div>';
        echo ($html);
        die();
    } elseif ($tp == 'S') {
        $titlePost = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
        $slugPost  = $core->replaceSpace($titlePost);
        $introPost = isset($_POST['intro']) ? addslashes($_POST['intro']) : '';
        #
        if (intval($servicecat_id) == 0) {
            if ($clsClassTable->getAll("slug='$slugPost'") !='') {
                echo '_EXIST';
                die();
            } else {
                $fx = "$clsClassTable->pkey,user_id,user_id_update,title,slug,intro,order_no,reg_date,upd_date";
                $vx = "'" . $clsClassTable->getMaxID() . "','$user_id','$user_id','$titlePost','$slugPost','" . addslashes($introPost) . "'";
                $vx .= ",'" . $clsClassTable->getMaxOrderNo() . "','" . time() . "','" . time() . "'";
                #
                if ($clsClassTable->insertOne($fx, $vx)) {
                    echo '_SUCCESS';
                    die();
                } else {
                    echo '_ERROR';
                    die();
                }
            }
        } else {
            if ($clsClassTable->getAll("slug='$slugPost' and servicecat_id <> '$servicecat_id'")!='') {
                echo '_EXIST';
                die();
            } else {
                $set = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',intro='" . addslashes($introPost) . "',upd_date='" . time() . "',user_id_update='" . $user_id . "'";
                if ($clsClassTable->updateOne($servicecat_id, $set)) {
                    echo '_SUCCESS';
                    die();
                } else {
                    echo '_ERROR';
                    die();
                }
            }
        }
    }
}
require_once(DIR_MODULES . '/service/mod_default.php');
?>