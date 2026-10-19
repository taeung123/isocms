<?php
function default_default(){
	global $assign_list, $_CONFIG,$_SITE_ROOT,$mod,$_LANG_ID, $act, $menu_current, $current_page,$oneSetting,$clsConfiguration;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$extLang,$clsISO,$package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#-- Get Type List
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	
	$clsGuideCat = new GuideCat();$assign_list["clsGuideCat"] = $clsGuideCat;
	$clsCountry = new Country();$assign_list["clsCountry"] = $clsCountry;
	$clsCity = new City();$assign_list["clsCity"] = $clsCity;
	$clsRegion = new Region();$assign_list["clsRegion"] = $clsRegion;
	#
	$country_id = isset($_GET['country_id'])? intval($_GET['country_id']) : 0;
	$assign_list["country_id"] = $country_id;
	$region_id = isset($_GET['region_id'])? intval($_GET['region_id']) : 0;
	$assign_list["region_id"] = $region_id;
	$city_id = isset($_GET['city_id'])? intval($_GET['city_id']) : 0;
	$assign_list["city_id"] = $city_id;
	$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
	$assign_list["cat_id"] = $cat_id;
	#
	/*if(isset($country_id) && intval($country_id)==0){
		header('location: '.PCMS_URL.'/?mod=country&message=notPermission');
		exit();
	}*/
	#
	$classTable = "Guide";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = '';
		if(isset($_POST['country_id']) && intval($_POST['country_id'])>0){
			$link.='&country_id='.$_POST['country_id'];
		}
		if(isset($_POST['region_id']) && intval($_POST['region_id'])>0){
			$link.='&region_id='.$_POST['region_id'];
		}
		if(isset($_POST['city_id']) && intval($_POST['city_id'])>0){
			$link.='&city_id='.$_POST['city_id'];
		}
		if(isset($_POST['cat_id']) && intval($_POST['cat_id'])>0){
			$link.='&cat_id='.$_POST['cat_id'];
		}
		
		if(isset($_POST['keyword']) && !empty($_POST['keyword'])){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	
	/*List all item*/
	$cond = "1='1'";
	if(intval($country_id) > 0) {
		$cond .= " and country_id='$country_id'";
		$pUrl .= '&country_id='.$country_id;
	}
	if(intval($region_id) > 0) {
		$cond .=" and city_id IN (SELECT city_id FROM ".DB_PREFIX."city WHERE region_id='$region_id')";
		$pUrl .= '&region_id='.$region_id;
	}
	if(intval($city_id) > 0) {
		$cond .=" and (city_id='$city_id')";
		$pUrl .= '&city_id='.$city_id;
	}
	if(intval($cat_id) > 0) {
		$cond .=" and (cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%')";
		$pUrl .= '&cat_id='.$cat_id;
	}
	#Filter By Keyword
	if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and slug like '%".$keyword."%'";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$assign_list["pUrl"] = $pUrl;
	$cond2 = $cond;
	if($type_list=='Active'){
		$cond .= " and is_trash=0";
	}
	if($type_list=='Trash'){
		$cond .= " and is_trash=1";
	}
	$orderBy = " order_no asc";		
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	//print_r($cond); die();
	//print_r(count($lstAllItem));die();

	$totalRecord = $clsClassTable->getAll($cond)?count($clsClassTable->getAll($cond)):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	
	$stt=($currentPage-1)*$recordPerPage;
	$assign_list['stt'] = $stt;
	
	
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
	

	$assign_list["allItem"] = $allItem;
	$lstCityGuide = $clsCity->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by title asc",$clsCity->pkey);
	$tmp = array();
	if(!empty($lstCityGuide)){
		foreach($lstCityGuide as $item){
			if($clsClassTable->countGuideGlobal(0,$item[$clsCity->pkey],$country_id)>0) {
				$tmp[]= $item[$clsCity->pkey];
			}
		}
	}
	$assign_list["lstCityGuide"] = $tmp;

}
function default_ajUpdPosSortGuide(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsGuide = new Guide();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key+1);
		$clsGuide->updateOne($val,"order_no='".$key."'");	
	}
}
function default_ajUpdPosSortGuideCat(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsGuideCat = new GuideCat();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key+1);
		$clsGuideCat->updateOne($val,"order_no='".$key."'");	
	}
}
function default_notitle(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting,$clsConfiguration;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#-- Get Type List
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	
	$clsGuideCat = new GuideCat();$assign_list["clsGuideCat"] = $clsGuideCat;
	$clsCountry = new Country();$assign_list["clsCountry"] = $clsCountry;
	$clsRegion = new Region();$assign_list["clsRegion"] = $clsRegion;
	$clsCity = new City();$assign_list["clsCity"] = $clsCity;
	
	
	$country_id = isset($_GET['country_id'])? intval($_GET['country_id']) : 0;
	$assign_list["country_id"] = $country_id;
	$region_id = isset($_GET['region_id'])? intval($_GET['region_id']) : 0;
	$assign_list["region_id"] = $region_id;
	$city_id = isset($_GET['city_id'])? intval($_GET['city_id']) : 0;
	$assign_list["city_id"] = $city_id;
	$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
	$assign_list["cat_id"] = $cat_id;
	
	#
	$classTable = "Guide2";
	$clsClassTable = new $classTable;
	
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link.= '&act=notitle';
		if(isset($_POST['country_id']) && intval($_POST['country_id'])>0){
			$link.='&country_id='.$_POST['country_id'];
		}
		if(isset($_POST['region_id']) && intval($_POST['region_id'])>0){
			$link.='&region_id='.$_POST['region_id'];
		}
		if(isset($_POST['city_id']) && intval($_POST['city_id'])>0){
			$link.='&city_id='.$_POST['city_id'];
		}
		if(isset($_POST['cat_id']) && intval($_POST['cat_id'])>0){
			$link.='&cat_id='.$_POST['cat_id'];
		}
	
		if(isset($_POST['keyword']) && !empty($_POST['keyword'])){
			$link.= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	
	/*List all item*/
	$cond = "1='1'";
	if(intval($country_id) > 0) {
		$cond .= " and country_id='$country_id'";
		$pUrl .= '&country_id='.$country_id;
	}

	if(intval($cat_id) > 0) {
		$cond .=" and (cat_id='$cat_id' or list_cat_id like '%".$cat_id."%')";
		$pUrl .= '&cat_id='.$cat_id;
	}
	
	if(intval($city_id) > 0) {
		$cond .=" and city_id='$city_id'";
		$pUrl .= '&city_id='.$city_id;
	}
	if(intval($region_id) > 0) {
		$cond .=" and region_id='$region_id'";
		$pUrl .= '&region_id='.$region_id;
	}
	
	#Filter By Keyword
	if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and slug like '%".$keyword."%'";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$assign_list["pUrl"] = $pUrl;
	$cond2 = $cond;
	if($type_list=='Active'){
		$cond .= " and is_trash=0";
	}
	if($type_list=='Trash'){
		$cond .= " and is_trash=1";
	}
	$orderBy = " order_no asc";	
	
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage = isset($_GET["recordperpage"])? $_GET["recordperpage"] : 20;
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
	
	$stt=($currentPage-1)*$recordPerPage;
	$assign_list['stt'] = $stt;
	
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
	$assign_list["allItem"] = $allItem;
	
	$lstCityGuide = $clsCity->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by title asc",$clsCity->pkey);
	$tmp = array();
	if(!empty($lstCityGuide)){
		foreach($lstCityGuide as $item){
			if($clsClassTable->countGuideGlobal(0,$item[$clsCity->pkey],$country_id)>0) {
				$tmp[]= $item[$clsCity->pkey];
			}
		}
	}
	$assign_list["lstCityGuide"] = $tmp;
}
function default_ajUpdPosSortGuideNotitle(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsGuide2 = new Guide2();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key+1);
		$clsGuide2->updateOne($val,"order_no='".$key."'");	
	}
}
function default_edit(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting,$clsConfiguration;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$pvalTable,$clsClassTable;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Guide";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$clsCountry = new Country(); $assign_list["clsCountry"] = $clsCountry;
	$clsCity = new City(); $assign_list["clsCity"] = $clsCity;
	$clsGuideCat = new GuideCat(); $assign_list["clsGuideCat"] = $clsGuideCat;
	#
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	
	$oneTable = $clsClassTable->getOne($pvalTable);
	$assign_list["oneTable"] = $oneTable;
	//print_r($oneTable); die();
	
/*	if($clsConfiguration->getValue('SiteModActive_country')) {
		if(isset($country_id) && intval($country_id)==0){
			header('location: '.PCMS_URL.'/?mod=country&message=notPermission');
			exit();
		}
	}*/

	#
	if(isset($pvalTable) && $pvalTable > 0){
		$country_id = $oneTable['country_id'];
		$city_id = $oneTable['city_id'];
		$cat_id = $oneTable['cat_id'];
	}
	$assign_list["country_id"] = $country_id;
	$assign_list["cat_id"] = $cat_id;
	$assign_list["city_id"] = $city_id;
	#-------------Update Config Meta
	$clsMeta = new Meta();$assign_list["clsMeta"] = $clsMeta;
	$linkMeta = $clsClassTable->getLink($pvalTable);
	$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'];
	$assign_list["meta_id"] = $meta_id; 
	$assign_list["oneMeta"] = $clsMeta->getOne($meta_id); 
	
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("full",'intro',"",'intro', 255, 25, 20, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full",'content',"",'content', 255, 25, 20, 1,  "style='width:100%'");
	
	if($string!='' && $pvalTable==0){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=notPermission');
	}
	#=========================================#
	if(isset($_POST['submit']) && $_POST['submit'] =='Update'){
		if($pvalTable>0){
			$set = ""; $firstAdd = 0;
			foreach($_POST as $key=>$val){
				$tmp = explode('-',$key);
				if($tmp[0]=='iso'){
					if($firstAdd==0){
						$set .= $tmp[1]."='".addslashes($val)."'";
						$firstAdd = 1;
					}else{
						$set .= ",".$tmp[1]."='".addslashes($val)."'";
					}
				}
			}
			#
			$set .= ",slug='".$clsISO->replaceSpace2($_POST["iso-title"])."'";
			$set .= ",upd_date='".time()."',user_id_update='".addslashes($core->_SESS->user_id)."'";
			if(isset($_POST['publish_date'])) {
				$_POST['publish_date'] = str_replace('/', '-', $_POST['publish_date']);
				$_POST['publish_date'] = strtotime($_POST['publish_date']);
			$set .= ",publish_date='".$_POST['publish_date']."'";
			
			}
				
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if(_isoman_use){
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if($image!='' && $image!='0'){
				$set .= ",image='".addslashes($image)."'";
			}
			
			#
			/*$pUrl .= '&country_id='.$country_id;*/
			if(isset($_POST['iso-country_id']) && intval($_POST['iso-country_id'])>0){
				$pUrl .= "&country_id=".$_POST['iso-country_id'];
			}
			if(isset($_POST['iso-city_id']) && intval($_POST['iso-city_id'])>0){
				$pUrl .= "&city_id=".$_POST['iso-city_id'];
			}
			if(isset($_POST['cat_id']) && intval($_POST['cat_id']) > 0){
				$list_cat_id = $clsGuideCat->getListParent($_POST['cat_id']);
				$set.= ",cat_id = '".$_POST['cat_id']."',list_cat_id = '".$list_cat_id."'";
				$pUrl .= "&cat_id=".$cat_id;
			}
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$set .= ",is_online='".$is_online."'";
			//print_r($pvalTable.'<br/>'.$set); die();
			if($clsClassTable->updateOne($pvalTable,$set)){
				$titleMeta=$_POST['config_value_title']?addslashes($_POST['config_value_title']):addslashes($_POST['iso-title']);
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
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&'.$clsClassTable->pkey.'='.$_GET[$clsClassTable->pkey].$pUrl.'&message=UpdateSuccess');
				} else {
					header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=UpdateSuccess');
				}
			}else{
				header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=updateFailed');
			}
		} else {
			$value = ""; $firstAdd = 0; $field = "";
			foreach($_POST as $key=>$val){
				$tmp = explode('-',$key);
				if($tmp[0]=='iso'){
					if($firstAdd==0){
						$field .= $tmp[1];
						$value .= "'".addslashes($val)."'";
						$firstAdd = 1;
					}else{
						$field .= ','.$tmp[1];
						$value .= ",'".addslashes($val)."'";
					}
				}
			}
			#
			$listTable=$clsClassTable->getAll("1=1", $clsClassTable->pkey.",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no=$listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey],"order_no='".$order_no."'");
			}
			$max_id = $clsClassTable->getMaxID();
			$field .= ",user_id,user_id_update,reg_date,upd_date,slug,$clsClassTable->pkey,order_no";
			$value .= ",'".addslashes($core->_SESS->user_id)."','".addslashes($core->_SESS->user_id)."','".time()."','".time()."'";
			$value .= ",'".$clsISO->replaceSpace2($_POST['iso-title'])."','".$max_id."','1'";
			
			if(isset($_POST['publish_date'])) {
				$_POST['publish_date'] = str_replace('/', '-', $_POST['publish_date']);
				$_POST['publish_date'] = strtotime($_POST['publish_date']);
			$field .= ",publish_date";
			$value .= ",'".$_POST['publish_date']."'";
			}
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if(_isoman_use){
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if($image!='' && $image!='0'){
				$field .= ',image';
				$value .= ",'".addslashes($image)."'";
			}
			#
			$pUrl = '';
			if(isset($_POST['cat_id']) && intval($_POST['cat_id'])>0) {
				$list_cat_id = $clsGuideCat->getListParent($_POST['cat_id']);
				$field .= ",cat_id,list_cat_id";
				$value .= ",'".$_POST['cat_id']."','".$list_cat_id."'";
				$pUrl .= "&cat_id=".$_POST['cat_id'];
			}
			if(isset($_POST['iso-country_id']) && intval($_POST['iso-country_id'])>0){
				$pUrl .= "&country_id=".$_POST['iso-country_id'];
			}
			if(isset($_POST['iso-city_id']) && intval($_POST['iso-city_id'])>0){
				$pUrl .= "&city_id=".$_POST['iso-city_id'];
			}
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$field .= ',is_online';
			$value .= ",'".$is_online."'";
			//print_r($field.'<br />'.$value); die();
			if($clsClassTable->insertOne($field,$value)){
				if ($_POST['button'] == '_EDIT') {
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&'.$clsClassTable->pkey.'='.$core->encryptID($max_id).$pUrl.'&message=insertSuccess');
				}else {
					header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=insertSuccess');
				}
			} else{
				header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=insertFailed');
			}
		}
	}
}
function default_editcompose(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting,$clsConfiguration;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Guide2";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	#

	$clsRegion = new Region();$assign_list['clsRegion'] = $clsRegion;
	$clsCountry = new Country(); $assign_list["clsCountry"] = $clsCountry;
	$clsCity = new City(); $assign_list["clsCity"] = $clsCity;
	$clsGuideCat = new GuideCat(); $assign_list["clsGuideCat"] = $clsGuideCat;
	#
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$assign_list['pkeyTable'] = $pkeyTable;
	
	
	$oneTable = $clsClassTable->getOne($pvalTable);
	$assign_list["oneTable"] = $oneTable;
	
	$country_id = isset($_GET['country_id'])? $_GET['country_id']:0;
/*
	if($clsConfiguration->getValue('SiteModActive_country')) {
		if(isset($country_id) && intval($country_id)==0){
			header('location: '.PCMS_URL.'/?mod=country&message=notPermission');
			exit();
		}
	}*/
	$city_id = isset($_GET['city_id'])?$_GET['city_id']:0;
	$cat_id = isset($_GET['cat_id'])? $_GET['cat_id']:0;
	#
	if($clsConfiguration->getValue('SiteActive_city')){
		$lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by order_no desc");
		$assign_list["lstCity"] = $lstCity; unset($lstCity);
	}
	#
	if(isset($pvalTable) && $pvalTable > 0){
		$country_id = $oneTable['country_id'];
		$region_id = $oneTable['region_id'];
		$city_id = $oneTable['city_id'];
		$cat_id = $oneTable['cat_id'];
	}
	$assign_list["country_id"] = $country_id;
	$assign_list["region_id"] = $region_id;
	$assign_list["cat_id"] = $cat_id;
	$assign_list["city_id"] = $city_id;
	#-------------Update Config Meta
	$clsMeta = new Meta();$assign_list["clsMeta"] = $clsMeta;
	$linkMeta = $clsClassTable->getLink($pvalTable);
	$allMeta = $clsMeta->getAll("config_link='$linkMeta'");
	$meta_id = $allMeta[0]['meta_id'];
	$assign_list["meta_id"] = $meta_id; 
	$assign_list["oneMeta"] = $clsMeta->getOne($meta_id); 
	
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("full",'intro',"",'intro', 255, 25, 5, 1, "style='width:100%'");
	$clsForm->addInputTextArea("full",'content',"",'content', 255, 25, 20, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("simple150",'intro_banner',"",'intro_banner', 255, 25, 20, 1,  "style='width:100%'");
	
	if($string!='' && $pvalTable==0){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=notPermission');
	}
	#=========================================#
	if(isset($_POST['submit']) && $_POST['submit'] =='Update'){
		if($pvalTable>0){
			$set = ""; $firstAdd = 0;
			foreach($_POST as $key=>$val){
				$tmp = explode('-',$key);
				if($tmp[0]=='iso'){
					if($firstAdd==0){
						$set .= $tmp[1]."='".addslashes($val)."'";
						$firstAdd = 1;
					}else{
						$set .= ",".$tmp[1]."='".addslashes($val)."'";
					}
				}
			}
			#
			$set .= ",slug='".$core->replaceSpace($_POST["iso-title"])."'";
			$set .= ",upd_date='".time()."',user_id_update='".addslashes($core->_SESS->user_id)."'";
			
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if(_isoman_use){
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if($image!='' && $image!='0'){
				$set .= ",image='".addslashes($image)."'";
			}
					$banner = $_POST['banner_src'];
			if($banner!=''&&$banner!='0'){
				$set .= ",banner='".addslashes($banner)."'";
			}
			if (_isoman_use) {
				$banner = $_POST['isoman_url_banner'];
				if($banner!=''&&$banner!='0'){
					$set .= ",banner='".addslashes($banner)."'";
				}
				
			}
			
			#
			$pUrl .= '&act=notitle';
			if(isset($_POST['cat_id']) && intval($_POST['cat_id']) > 0){
				$list_cat_id = $clsGuideCat->getListParent($_POST['cat_id']);
				$set.= ",cat_id = '".$_POST['cat_id']."',list_cat_id = '".$list_cat_id."'";
				$pUrl .= "&cat_id=".$cat_id;
			}
			if(isset($_POST['iso-city_id']) && intval($_POST['iso-city_id'])>0){
				$pUrl .= "&city_id=".$_POST['iso-city_id'];
			}
			//print_r($pvalTable.'<br/>'.$set); die();
			if($clsClassTable->updateOne($pvalTable,$set)){
				if($_POST['config_value_title']!='' && $_POST['config_value_intro']!=''){
					if($meta_id==''){
						$clsMeta->insertOne("config_link,reg_date,meta_id","'".$linkMeta."','".time()."','".$clsMeta->getMaxId()."'");
						$allMeta = $clsMeta->getAll("config_link='".$linkMeta."'");
						$meta_id = $allMeta[0]['meta_id'];
					}
					$clsMeta->updateOne($meta_id,"config_value_intro='".addslashes($_POST['config_value_intro'])."',config_value_keyword='".addslashes($_POST['config_value_keyword'])."',config_value_title='".addslashes($_POST['config_value_title'])."',upd_date='".time()."',meta_index='".addslashes($_POST['meta_index'])."',meta_follow='".addslashes($_POST['meta_follow'])."'");
				}
				if($_POST['button']=='_EDIT'){
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=editcompose&'.$clsClassTable->pkey.'='.$_GET[$clsClassTable->pkey].'&message=UpdateSuccess');
				} else {
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=notitle'.'&message=UpdateSuccess');
				}
				
			}else{
				header('location: '.PCMS_URL.'/?mod='.$mod.'&message=updateFailed');
			}
		} else {
			$value = ""; $firstAdd = 0; $field = "";
			foreach($_POST as $key=>$val){
				$tmp = explode('-',$key);
				if($tmp[0]=='iso'){
					if($firstAdd==0){
						$field .= $tmp[1];
						$value .= "'".addslashes($val)."'";
						$firstAdd = 1;
					}else{
						$field .= ','.$tmp[1];
						$value .= ",'".addslashes($val)."'";
					}
				}
			}
			$listTable=$clsClassTable->getAll("1=1", $clsClassTable->pkey.",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no=$listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey],"order_no='".$order_no."'");
			}
			
			#
			$max_id = $clsClassTable->getMaxID();
			$field .= ",user_id,user_id_update,reg_date,upd_date,slug,$clsClassTable->pkey,order_no";
			$value .= ",'".addslashes($core->_SESS->user_id)."','".addslashes($core->_SESS->user_id)."','".time()."','".time()."'";
			$value .= ",'".$core->replaceSpace($_POST['iso-title'])."','".$max_id."','1'";
			
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			if(_isoman_use){
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
			}
			if($image!='' && $image!='0'){
				$field .= ',image';
				$value .= ",'".addslashes($image)."'";
			}
			
					$banner = $_POST['banner_src'];
			if($banner!=''&&$banner!='0'){
				$field .= ",banner";
				$value .= ",'".addslashes($banner)."'";
			}
			if (_isoman_use) {
				$banner = $_POST['isoman_url_banner'];
				if($banner!=''&&$banner!='0'){
					$field .= ",banner";
					$value .= ",'".addslashes($banner)."'";
				}
				
			}
			#
			$pUrl .= '&act=notitle';
			if(isset($_POST['cat_id']) && intval($_POST['cat_id'])>0) {
				$list_cat_id = $clsGuideCat->getListParent($_POST['cat_id']);
				$field .= ",cat_id,list_cat_id";
				$value .= ",'".$_POST['cat_id']."','".$list_cat_id."'";
				$pUrl .= "&cat_id=".$_POST['cat_id'];
			}
			if(isset($_POST['iso-city_id']) && intval($_POST['iso-city_id'])>0){
				$pUrl .= "&city_id=".$_POST['iso-city_id'];
			}
			//print_r($field.'<br />'.$value); die();
			if($clsClassTable->insertOne($field,$value)){
				if ($_POST['button'] == '_EDIT') {
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=editcompose&'.$clsClassTable->pkey.'='.$core->encryptID($max_id).'&message=insertSuccess');
				}else {
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=notitle'.'&message=insertSuccess');
				}
			} else{
				header('location: '.PCMS_URL.'/?mod='.$mod.'&message=insertFailed');
			}
		}
	}
}

function default_trash(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Guide";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$one = $clsClassTable->getOne($pvalTable);
	$country_id = isset($_GET['country_id'])?$_GET['country_id']:'';
	$city_id = isset($_GET['city_id'])?$_GET['city_id']:'';
	$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']:0;
	
	if($string='' && $pvalTable == 0){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&country_id='.$country_id.'&cat_id='.$cat_id.'&message=notPermission');
	}
	#
	$param_url = '';
	if(isset($city_id) && intval($city_id)!=0){
		$param_url.= '&city_id='.$city_id;
	}
	if(isset($cat_id) && intval($cat_id)!=0){
		$param_url .= '&cat_id='.$cat_id;
	}
	#
	if($clsClassTable->updateOne($pvalTable,"is_trash='1'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=TrashSuccess');
	}
}
function default_trash2(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Guide2";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$one = $clsClassTable->getOne($pvalTable);
	$country_id = isset($_GET['country_id'])?$_GET['country_id']:'';
	$city_id = isset($_GET['city_id'])?$_GET['city_id']:'';
	$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']:0;
	
	if($string='' && $pvalTable == 0){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&country_id='.$country_id.'&cat_id='.$cat_id.'&message=notPermission');
	}
	#
	$param_url = '&act=notitle';
	if(isset($city_id) && intval($city_id)!=0){
		$param_url.= '&city_id='.$city_id;
	}
	if(isset($cat_id) && intval($cat_id)!=0){
		$param_url .= '&cat_id='.$cat_id;
	}
	#
	if($clsClassTable->updateOne($pvalTable,"is_trash='1'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=TrashSuccess');
	}
}
function default_restore(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Guide";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$one = $clsClassTable->getOne($pvalTable);
	$country_id = isset($_GET['country_id'])?$_GET['country_id']:'';
	$city_id = isset($_GET['city_id'])?$_GET['city_id']:'';
	$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']:0;
	#
	if($string='' && $pvalTable == 0){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&country_id='.$country_id.'&cat_id='.$cat_id.'&message=notPermission');
	}
	$param_url = '';
	if(isset($city_id) && intval($city_id)!=0){
		$param_url.= '&city_id='.$city_id;
	}
	if(isset($cat_id) && intval($cat_id)!=0){
		$param_url .= '&cat_id='.$cat_id;
	}
	#
	if($clsClassTable->updateOne($pvalTable,"is_trash='0'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=RestoreSuccess');
	}
}
function default_restore2(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Guide2";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$one = $clsClassTable->getOne($pvalTable);
	$country_id = isset($_GET['country_id'])?$_GET['country_id']:'';
	$city_id = isset($_GET['city_id'])?$_GET['city_id']:'';
	$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']:0;
	#
	if($string='' && $pvalTable == 0){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&country_id='.$country_id.'&cat_id='.$cat_id.'&message=notPermission');
	}
	$param_url = '&act=notitle';
	if(isset($city_id) && intval($city_id)!=0){
		$param_url.= '&city_id='.$city_id;
	}
	if(isset($cat_id) && intval($cat_id)!=0){
		$param_url .= '&cat_id='.$cat_id;
	}
	#
	if($clsClassTable->updateOne($pvalTable,"is_trash='0'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=RestoreSuccess');
	}
}
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Guide";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$country_id = isset($_GET['country_id'])?$_GET['country_id']:'';
	$city_id = isset($_GET['city_id'])?$_GET['city_id']:'';
	$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']:0;
	
	$param_url = '';
	if(isset($city_id) && intval($city_id)!=0){
		$param_url.= '&city_id='.$city_id;
	}
	if(isset($cat_id) && intval($cat_id)!=0){
		$param_url .= '&cat_id='.$cat_id;
	}
	if($pvalTable == ""){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=notPermission');
	}
	#
	if(isset($_POST['agree']) && $_POST['agree']=='agree'){
		if($clsClassTable->deleteOne($pvalTable)){
			header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=DeleteSuccess');
		}
	}
}
function default_delete2(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Guide2";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	$country_id = isset($_GET['country_id'])?$_GET['country_id']:'';
	$city_id = isset($_GET['city_id'])?$_GET['city_id']:'';
	$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']:0;
	
	$param_url = '&act=notitle';
	if(isset($city_id) && intval($city_id)!=0){
		$param_url.= '&city_id='.$city_id;
	}
	if(isset($cat_id) && intval($cat_id)!=0){
		$param_url .= '&cat_id='.$cat_id;
	}
	if($pvalTable == ""){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=notPermission');
	}
	#
	if(isset($_POST['agree']) && $_POST['agree']=='agree'){
		if($clsClassTable->deleteOne($pvalTable)){
			header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=DeleteSuccess');
		}
	}
}

function default_move(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "Guide";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	
	$pvalTable = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$direct = isset($_GET['direct'])? $_GET['direct']:'';
	$type = isset($_GET['type'])?$core->decryptID($_GET['type']):'country';
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	
	$country_id = isset($_GET['country_id'])?$_GET['country_id']:0;
	$city_id = isset($_GET['city_id'])?$_GET['city_id']:0;
	$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']:0;
	#
	$where = "1=1 and is_trash=0";
	$param_url='';
	if(isset($cat_id) && intval($cat_id)!=''){
		$where.=" and cat_id=".$cat_id;
		$param_url.= '&cat_id='.$cat_id;
	}
	/*
    if(isset($country_id) && intval($country_id) != 0){
		$where.=" and country_id=".$country_id;
		$param_url.='&country_id='.$country_id;
	}
    */
	if(isset($city_id) && intval($city_id) != 0){
		$where.=" and (city_id='$city_id' or list_city_id like '%|".$city_id."|%')";
		$param_url.='&city_id='.$city_id;
	}
	#
	if($pvalTable=='' && $direct==''){
		header('location: '.PCMS_URL.'/?mod='.$mod);
	}
	#
	if($direct=='movedown'){
		$lst = $clsClassTable->getAll($where." and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='moveup'){
		$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movebottom'){
		$lst = $clsClassTable->getAll($where." and order_no < $order_no order by order_no desc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$lstItem = $clsClassTable->getAll($where." and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
		for($i=0;$i<count($lstItem);$i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey],"order_no='".($lstItem[$i]['order_no']+1)."'");	
		}
	}
	if($direct=='movetop'){
		$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no asc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$lstItem = $clsClassTable->getAll($where." and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
		for($i=0;$i<count($lstItem);$i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey],"order_no='".($lstItem[$i]['order_no']-1)."'");	
		}
	}
	header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=PositionSuccess');
}
function default_move2(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "Guide2";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	
	$pvalTable = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$direct = isset($_GET['direct'])? $_GET['direct']:'';
	$type = isset($_GET['type'])?$core->decryptID($_GET['type']):'country';
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	
	$country_id = isset($_GET['country_id'])?$_GET['country_id']:0;
	$city_id = isset($_GET['city_id'])?$_GET['city_id']:0;
	$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']:0;
	#
	$where = "1=1 and is_trash=0";
	$param_url='&act=notitle';
	if(isset($cat_id) && intval($cat_id)!=''){
		$where.=" and cat_id=".$cat_id;
		$param_url.= '&cat_id='.$cat_id;
	}
	/*if(isset($country_id) && intval($country_id) != 0){
		$where.=" and country_id=".$country_id;
		$param_url.='&country_id='.$country_id;
	}*/
	if(isset($city_id) && intval($city_id) != 0){
		$where.=" and (city_id='$city_id' or list_city_id like '%|".$city_id."|%')";
		$param_url.='&city_id='.$city_id;
	}
	#
	if($pvalTable=='' && $direct==''){
		header('location: '.PCMS_URL.'/?mod='.$mod);
	}
	#
	if($direct=='movedown'){
		$lst = $clsClassTable->getAll($where." and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='moveup'){
		$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movebottom'){
		$lst = $clsClassTable->getAll($where." and order_no < $order_no order by order_no desc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$lstItem = $clsClassTable->getAll($where." and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
		for($i=0;$i<count($lstItem);$i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey],"order_no='".($lstItem[$i]['order_no']+1)."'");	
		}
	}
	if($direct=='movetop'){
		$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no asc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$lstItem = $clsClassTable->getAll($where." and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
		for($i=0;$i<count($lstItem);$i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey],"order_no='".($lstItem[$i]['order_no']-1)."'");	
		}
	}
	header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=PositionSuccess');
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
			$clsMeta->updateOne($meta_id,"config_value_intro='".addslashes($_POST['config_value_intro'])."',config_value_keyword='".addslashes($_POST['config_value_keyword'])."',config_value_title='".addslashes($_POST['config_value_title'])."',upd_date='".time()."',meta_index='".addslashes($_POST['meta_index'])."',meta_follow='".addslashes($_POST['meta_follow'])."'");
		}
		header('location:'.PCMS_URL.'?mod='.$mod.'&act='.$act.'&message=UpdateSuccess'.$extUrl);
	}	
}

/*------ Guide Category -------*/
function default_cat(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$country_id = isset($_GET['country_id'])?$_GET['country_id']:1;
	$assign_list["country_id"] = $country_id;
	#
	$classTable = "GuideCat";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	
	$pUrl = '&country_id='.$country_id;
	$assign_list["pUrl"] = $pUrl;
	
	$classTable = "GuideCat";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = '';
		if(isset($_POST['country_id']) && intval($_POST['country_id'])>0){
			$link.='&country_id='.$_POST['country_id'];
		}
		if(isset($_POST['city_id']) && intval($_POST['city_id'])>0){
			$link.='&city_id='.$_POST['city_id'];
		}
		if(isset($_POST['cat_id']) && intval($_POST['cat_id'])>0){
			$link.='&cat_id='.$_POST['cat_id'];
		}
		
		if(isset($_POST['keyword']) && !empty($_POST['keyword'])){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.$link);
	}
	
	/*List all item*/
	$cond = "1=1";

	#Filter By Keyword
	if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and slug like '%".$keyword."%'";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$assign_list["pUrl"] = $pUrl;
	$cond2 = $cond;
	if($type_list=='Active'){
		$cond .= " and is_trash=0";
	}
	if($type_list=='Trash'){
		$cond .= " and is_trash=1";
	}
	$orderBy = " order_no asc";		
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	//print_r($cond); die();
	//print_r(count($lstAllItem));die();

	$totalRecord = $clsClassTable->getAll($cond)?count($clsClassTable->getAll($cond)):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	
	$stt=($currentPage-1)*$recordPerPage;
	$assign_list['stt'] = $stt;
	
	
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
	

	$assign_list["allItem"] = $allItem;
	
	 //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['guidecat_id']) ? ($_GET['guidecat_id']) : '';
        $guidecat_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $guidecat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($guidecat_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['guidecat_id']) ? ($_GET['guidecat_id']) : '';
        $guidecat_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $guidecat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($guidecat_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['guidecat_id']) ? ($_GET['guidecat_id']) : '';
        $guidecat_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $guidecat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($guidecat_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
	
}
function default_editcat(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#
	$clsCountry = new Country();$assign_list["clsCountry"] = $clsCountry;
	$lstCountry = $clsCountry->getAll("is_trash=0 and is_online=1");$assign_list["lstCountry"] = $lstCountry;
	$countCountry = !empty($lstCountry)?count($lstCountry):0;$assign_list["countCountry"] = $countCountry;
	#
	$classTable = "GuideCat";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	
	$assign_list['pvalTable'] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("full",'intro', "", 'intro', 255, 25, 2, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("simple150",'intro_banner', "", 'intro', 255, 25, 1, 1,  "style='width:100%'");
	#
	if($string!='' && $pvalTable==0){
		header('location:'.PCMS_URL.'/index.php?&mod='.$mod.'&message=notPermission');
	}
	#=========================================#
	if(isset($_POST['submit']) && $_POST['submit'] =='Update'){
		if($pvalTable>0){
			$set = ""; $firstAdd = 0;
			foreach($_POST as $key=>$val){
				$tmp = explode('-',$key);
				if($tmp[0]=='iso'){
					if($firstAdd==0){
						$set .= $tmp[1]."='".addslashes($val)."'";
						$firstAdd = 1;
					}else{
						$set .= ",".$tmp[1]."='".addslashes($val)."'";
					}
				}
			}
			$set .= ",user_id_update='".addslashes($core->_SESS->user_id)."'";
			$set .= ",upd_date='".time()."'";
			$set .= ",slug='".$core->replaceSpace($_POST['title'])."'";
			$set .= ",title='" .ucwords(addslashes($_POST['title'])) . "'";
			// list_HotelFacilities
			$list_country_id = '|1|';
			$set .= ",list_country_id='".addslashes($list_country_id)."'";
			#
			#--Special Field: image
			if (_isoman_use) {
				$image = $_POST['isoman_url_image'];
				if($image!=''&&$image!='0'){
					$set .= ",image='".addslashes($image)."'";
				}
				
			}else{
				$image = $_POST['image_src'];
				if($image!=''&&$image!='0'){
					$set .= ",image='".addslashes($image)."'";
				}
			}
			if (_isoman_use) {
				$banner = $_POST['isoman_url_banner'];
				if($banner!=''&&$banner!='0'){
					$set .= ",banner='".addslashes($banner)."'";
				}
				
			}else{
				$banner = $_POST['banner_src'];
				if($banner!=''&&$banner!='0'){
					$set .= ",banner='".addslashes($banner)."'";
				}
			}
			
			
			#- Update Custom field
			$clsGuideCatStore = new GuideCatStore();
			$listStore = $clsGuideCatStore->getAll("guidecat_id='$pvalTable' order by order_no ASC");
			#
			if(is_array($listStore) && count($listStore) > 0){
				for($i=0; $i<count($listStore); $i++){
					$vx = "content='".addslashes($_POST['Site_GuideCat_Content_'.$listStore[$i][$clsGuideCatStore->pkey]])."'";
					$clsGuideCatStore->updateOne($listStore[$i][$clsGuideCatStore->pkey],$vx);
				}
				unset($listStore);
			}
			#
			//print_r($set); die();
			if($clsClassTable->updateOne($pvalTable,$set)){
				if($_POST['button']=='_EDIT'){
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&'.$clsClassTable->pkey.'='.$_GET[$clsClassTable->pkey].'&message=updateSuccess');
				}else{
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=cat&message=updateSuccess');
				}
			}else{
				header('location: '.PCMS_URL.'/?mod='.$mod.'&act=cat&message=updateFailed');
			}
		} else {
			$value = ""; $firstAdd = 0; $field = "";
			foreach($_POST as $key=>$val){
				$tmp = explode('-',$key);
				if($tmp[0]=='iso'){
					if($firstAdd==0){
						$field .= $tmp[1];
						$value .= "'".addslashes($val)."'";
						$firstAdd = 1;
					}else{
						$field .= ','.$tmp[1];
						$value .= ",'".addslashes($val)."'";
					}
				}
			}
			
			$listTable=$clsClassTable->getAll("1=1", $clsClassTable->pkey.",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no=$listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey],"order_no='".$order_no."'");
			}
			#
			$max_id = $clsClassTable->getMaxId();
			$field .= ",user_id,user_id_update,reg_date,upd_date,slug,title,$clsClassTable->pkey,order_no";
			$value .= ",'".addslashes($core->_SESS->user_id)."','".addslashes($core->_SESS->user_id)."','".time()."','".time()."'";
			$value .= ",'".$core->replaceSpace($_POST['title'])."','".ucwords($_POST['title'])."','".$max_id."','1'";
			$image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
			$banner = isset($_POST['banner_src']) ? $_POST['banner_src'] : '';
			if(_isoman_use){
				$image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
				$banner = isset($_POST['isoman_url_banner']) ? $_POST['isoman_url_banner'] : '';
			}
			if($image!=''&&$image!='0' || $banner != '' && $banner != '0'){
				$field .= ',image';
				$value .= ",'".addslashes($image)."'";
				$field .= ',banner';
				$value .= ",'".addslashes($banner)."'";
			}
			$list_country_id = '|1|';

			$field .= ",list_country_id";
			$value .= ",'".addslashes($list_country_id)."'";
			#
		//print_r($field.'<br/>'.$value);die();
			if($clsClassTable->insertOne($field,$value)){
				if ($_POST['button'] == '_EDIT') {
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&'.$clsClassTable->pkey.'='.$core->encryptID($max_id).'&message=insertSuccess');
				}else {
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=cat&message=insertSuccess');
				}
			} else{
				header('location: '.PCMS_URL.'/?mod='.$mod.'&act=cat&message=insertFailed');
			}
		}
	}
}
function default_OpenGuideCategory(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "GuideCat";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	
	$guidecat_id = isset($_POST['guidecat_id']) ? intval($_POST['guidecat_id']) : 0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	if($tp=='F'){
	
	}
	elseif($tp=='L'){
		$parent_id = isset($_POST['']) ? intval($_POST['']) : 0;
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : 0;
		#
		$lstItem = array();
		$clsClassTable->makeList(0,0,$lstItem);
		$html="";
		if(!empty($lstItem)){
			$i=0;
			foreach($lstItem as $key=>$val){
				$html.='<tr style="cursor:move" id="order_'.$key.'" data="'.$key.'" class="'.($i%2==0?'row1':'row2').'">';
				$html.='<td class="index">'.($i+1).'</td>';
				$html.='<td><a class="btnEditCategory" data="'.$val['cat_id'].'" href="javascript:void();" tile="Edit">
							<strong style="font-size:16px">'.$val['level'].'&nbsp;'.$clsClassTable->getTitle($key).'</strong>
						</a></td>';
				$html.='<td class="text-right">'.$clsISO->formatDateTime($val['reg_date']).'</td>';
				if(1==2){
				$html.='<td style="vertical-align: middle;text-align:center">
							'.($i==0?'':'<a title="Di chuyển lên đầu"  direct="movetop" class="btnmove_guidecat" data="'.$key.'" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>').'
						</td>
						<td style="vertical-align: middle;text-align:center">
							'.($i==count($lstItem)-1?'':'<a title="Di chuyển xuống dưới cùng" class="btnmove_guidecat" direct="movebottom" data="'.$key.'" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>').'
						</td>
						<td style="vertical-align: middle;text-align:center">
							'.($i==0?'':'<a title="Di chuyển lên" class="btnmove_guidecat" direct="moveup" data="'.$key.'" href="javascript:void();"><i class="icon-arrow-up"></i></a>').'
						</td>
						<td style="vertical-align: middle;text-align:center">
							'.($i==count($lstItem)-1 ? '' : '<a title="Di chuyển xuống" class="btnmove_guidecat" direct="movedown" data="'.$key.'" href="javascript:void();"><i class="icon-arrow-down"></i></a>').'
						</td>';
				}
				$html.='<td style="vertical-align: middle; text-align:center;">
							<a title="Edit" class="btn btn-primary" href="'.PCMS_URL.'/?mod=guide&act=editcat&guidecat_id='.$core->encryptID($key).'"><i class="icon-edit icon-white"></i></a>
							'.($val['is_lock']=='1'?'<a title="Locked" class="btn btn-warning" onclick="alert(\'Locked !\'); return false;" href="javascript:void(0);"><i class="icon-lock icon-white"></i></a>':'<a title="Delete" class="btn btn-danger btndelete_guidecat" data="'.$key.'" href="javascript:void(0);"><i class="icon-remove icon-white"></i></a>').'
						</td>';
				$html.='</tr>';
				++$i;
			}
			$html.='
			<script type="text/javascript">
				$("#tblHolderGuideCategory").sortable({
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
						$.post(path_ajax_script+"/index.php?mod=guide&act=ajUpdPosSortGuideCat", order, function(html){
							loadListSysCategory();
							vietiso_loading(0);
						});
					}
				});
			</script>';
		}else{
			$html.='<tr></tr>';	
		}
		echo $html; die();
	}
	else if($tp=='D'){
		if($guidecat_id > 0){
			$clsClassTable->doDelete($guidecat_id);
			echo(1); die();
		}
	}
	else if($tp=='M'){
		$direct = isset($_POST['direct']) ? $_POST['direct'] :'';
		$one = $clsClassTable->getOne($guidecat_id);
		$order_no = $one['order_no'];
		$parent_id = $one['parent_id'];
		#
		$cond = "is_trash=0 and parent_id='$parent_id'";
		if($direct=='moveup'){
			$lst = $clsClassTable->getAll($cond." and order_no > $order_no order by order_no asc limit 0,1");
			$clsClassTable->updateOne($guidecat_id,"order_no='".$lst[0]['order_no']."'");
			$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movedown'){
			$lst = $clsClassTable->getAll($cond." and order_no < $order_no order by order_no desc limit 0,1");
			$clsClassTable->updateOne($guidecat_id,"order_no='".$lst[0]['order_no']."'");
			$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movetop'){
			$lst = $clsClassTable->getAll($cond." and order_no > $order_no order by order_no asc");
			$clsClassTable->updateOne($guidecat_id,"order_no='".$lst[count($lst)-1]['order_no']."'");
			$lstItem = $clsClassTable->getAll($cond." and $pkeyTable <> '$guidecat_id' and order_no > $order_no order by order_no asc");
			for($i=0;$i<count($lstItem);$i++) {
				$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey],"order_no='".($lstItem[$i]['order_no']-1)."'");	
			}
		}
		if($direct=='movebottom'){
			$lst = $clsClassTable->getAll($cond." and order_no < $order_no order by order_no desc");
			$clsClassTable->updateOne($guidecat_id,"order_no='".$lst[count($lst)-1]['order_no']."'");
			$lstItem = $clsClassTable->getAll($cond." and $pkeyTable <> '$guidecat_id' and order_no < $order_no order by order_no asc");
			for($i=0;$i<count($lstItem);$i++) {
				$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey],"order_no='".($lstItem[$i]['order_no']+1)."'");	
			}
		}
		echo(1); die();
	}
}

function default_SiteGuideCatStore(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsGuideCat = new GuideCat();
	$clsGuideCatStore = new GuideCatStore();
	$clsCountry = new Country();
	
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	$flag = isset($_POST['flag']) ? $_POST['flag'] : '';
	$guidecat_id = $_POST['guidecat_id'];
	$country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
	#
	if($tp=='S'){
		if($flag){
			if($clsGuideCatStore->getAll("guidecat_id='$guidecat_id' and country_id='$country_id'")!=''){
			}else{
				$fx = "guidecat_id,country_id,order_no,reg_date,upd_date";
				$vx = "'$guidecat_id','$country_id','".$clsGuideCatStore->getMaxOrderNo()."','".time()."','".time()."'";
				#
				if($clsGuideCatStore->insertOne($fx, $vx)){
					echo '_SUCCESS'; die();
				}else{
					echo '_ERROR'; die();
				}
			}
		}
		else{
			$res = $clsGuideCatStore->getAll("guidecat_id='$guidecat_id' and country_id='$country_id' LIMIT 0,1");
			if($res[0][$clsGuideCatStore->pkey]!=''){
				$guidecat_store_id = $res[0][$clsGuideCatStore->pkey];
				$clsGuideCatStore->deleteOne($guidecat_store_id);
			}
			echo(1); die();
		}
	}
	else if($tp=='L'){
		$Html = '';
		$listStore = $clsGuideCatStore->getAll("guidecat_id='$guidecat_id' and country_id IN (SELECT country_id FROM ".DB_PREFIX."country WHERE is_trash=0 and is_online=1) order by order_no ASC");
		if(is_array($listStore) && count($listStore) > 0){
			$Html .= '
			<div class="globaltabs" id="globaltabs_optional_ul">
				<ul>';
				for($i=0; $i<count($listStore); $i++){
					$Html .= '<li><a href="javascript:void();">'.$clsCountry->getTitle($listStore[$i][$clsCountry->pkey]).'</a></li>';
				}
			$Html.='
				</ul>
			</div>
			<div class="clearfix"></div>
			<div class="tab_contentglobal">
			';
			for($i=0; $i<count($listStore); $i++){
				$Html .= '
				<div class="tabboxglobal tabboxchild_globaltabs_optional" '.($i==0?'':'style="display:none"').'>
					<textarea style="width:100%" cols="255" rows="5" class="Site_GuideCat_Content_Editor" id="Site_GuideCat_Content_'.$listStore[$i][$clsGuideCatStore->pkey].'_'.time().'" name="Site_GuideCat_Content_'.$listStore[$i][$clsGuideCatStore->pkey].'">'.$listStore[$i]['content'].'</textarea>
				</div>';
			}
			$Html .= '</div>';
		}
		echo $Html; die();
	}
}
function default_ajLoadSelectCategory(){
	global $core,$mod,$act;
	#
	$clsGuideCat = new GuideCat();
	$clsCountry = new Country();
	$clsGuide = new Guide();
	#
	$country_id = intval($_POST['country_id']);
	$city_id = intval($_POST['city_id']);
	$cat_id = intval($_POST['cat_id']);
	
	#
	$html = '<option value="0">'.$core->get_Lang('Category').'</option>';
	$lstCategory = $clsGuideCat->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsGuideCat->pkey);
	
	if(is_array($lstCategory) && count($lstCategory) > 0){
		foreach($lstCategory as $k=>$v){
			if($clsGuide->countGuideGlobal($country_id, $city_id, $v[$clsGuideCat->pkey]) > 0){
				$html.='<option value="'.$v[$clsGuideCat->pkey].'" '.($cat_id==$v[$clsGuideCat->pkey]?'selected="selected"':'').'>'.$clsGuideCat->getTitle($v[$clsGuideCat->pkey]).'</option>';
			}
		}
	}
 	#
	echo $html; die();
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
	if($Html==''){
		echo 'EMPTY';
	}else{
		echo $Html;
	}
	die();
}
function default_loadCity() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsCity = new City();
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;
	
	$cond = "is_trash=0 and is_online=1";
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

?>