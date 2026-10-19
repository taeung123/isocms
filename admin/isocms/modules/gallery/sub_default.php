<?php
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting,$clsConfiguration;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		if($_POST['keyword']!=''&&$_POST['keyword']!='testimonial title, intro'){
			$link .= '&keyword='.$_POST['keyword'];
		}
		if($_POST['gallerycat_id']!=''&&$_POST['gallerycat_id']!='0'){
			$link .= '&gallerycat_id='.$_POST['gallerycat_id'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	
	$gallerycat_id = isset($_GET['gallerycat_id']) ? intval($_GET['gallerycat_id']) : '';
	$assign_list["gallerycat_id"] = $gallerycat_id;
	/**/
	$classTable = "Gallery";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	/*List all item*/
	$cond = "1='1'";
	#Filter By Keyword
	if(isset($_GET['keyword'])){
		if($_GET['keyword'] !=''){
			$keyword = $core->replaceSpace($_GET['keyword']);
			$cond .= " and slug like '%".$keyword."%'";
			$assign_list["keyword"] = $_GET['keyword'];
		}
	}
	if($gallerycat_id > 0){
		$cond .= " and gallerycat_id = '".$gallerycat_id."'";
		$pUrl.='&gallerycat_id='.$gallerycat_id;
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
	$allItem = $clsClassTable->getAll($cond." order by ".$orderBy.$limit); //print_r($cond." order by ".$orderBy.$limit);die();
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
	
	#----
	if(isset($_POST['submit'])){
		if($_POST['submit']=='UpdateGalleryIntro'){
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
function default_ajUpdPosSortList(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$classTable = "Gallery";
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
function default_edit(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$dbconn,$clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Gallery";
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
	$clsForm->addInputTextArea("full",'content', "", 'content', 255, 25, 25, 1,  "style='width:100%'");
	#
	if($string!='' && $pvalTable==0){
		header('location:'.PCMS_URL.'/index.php?&mod='.$mod.'&message=notPermission');
	}
	#
	if(intval($pvalTable) > 0 && $clsConfiguration->getValue('SiteHasTags_Gallery')){
		#---Edit Tags of post
		$clsTag = new Tag(); $assign_list["clsTag"] = $clsTag;
		$listAllTag = $clsTag->getAll("1=1 and title<>'' order by title asc limit 0,5000");
		//print_r($listAllTag); die();
		$listAvailableTag = '<script type="text/javascript">var availableTags = [';
		for($i=0;$i<count($listAllTag);$i++){
			$listAvailableTag .= '{ name: "'.$listAllTag[$i]['title'].'", val: "'.$listAllTag[$i]['title'].'" },';
		}
		$listAvailableTag .= '];</script>';
		$assign_list["listAvailableTag"] = $listAvailableTag;
		#
		$clsTagModule = new TagModule(); $assign_list["clsTagModule"] = $clsTagModule;
		$listTag = $clsTagModule->getAll("1=1 and for_id='$pvalTable' and type = '_BOOK' order by reg_date asc limit 0,20");
		$assign_list["listTag"] = $listTag; unset($listAllTag); unset($listTag);
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
			$set .= ",user_id_update='".addslashes($core->_SESS->user_id)."'";
			$set .= ",upd_date='".time()."'";
			$set .= ",slug='".$core->replaceSpace($_POST['iso-title'])."'";
			
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src']: '';
			if(_isoman_use){
				$image = $_POST['isoman_url_image'];
			}
			if($image!='' && $image!='0'){
				$set .= ",image='".addslashes($image)."'";
			}
			
			#
			$pUrl = '';
			if($clsConfiguration->getValue('SiteHasCat_BOOK')){
				$gallerycat_id = $_POST['iso-gallerycat_id'];
				$pUrl .= '&gallerycat_id='.$gallerycat_id;
			}
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$set .= ",is_online='".$is_online."'";
			if($clsClassTable->updateOne($pvalTable,$set)) {
				if($_POST['config_value_title']!=''){
					if($meta_id==''){
						$clsMeta->insertOne("config_link,reg_date,meta_id","'".$linkMeta."','".time()."','".$clsMeta->getMaxID()."'");
						$allMeta = $clsMeta->getAll("config_link='".$linkMeta."'");
						$meta_id = $allMeta[0]['meta_id'];
					}
					$clsMeta->updateOne($meta_id,"config_value_intro='".addslashes($_POST['config_value_intro'])."',config_value_keyword='".addslashes($_POST['config_value_keyword'])."',config_value_title='".addslashes($_POST['config_value_title'])."',upd_date='".time()."',meta_index='".addslashes($_POST['meta_index'])."',meta_follow='".addslashes($_POST['meta_follow'])."'");
				}
				if($_POST['button']=='_EDIT'){
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&gallery_id='.$_GET[$clsClassTable->pkey].'&message=updateSuccess');
				}else{
					header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=updateSuccess');
				}
			} else{
				header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=updateFailed');
			}
		}
		else{
			$listTable=$clsClassTable->getAll("1=1", $clsClassTable->pkey.",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no=$listTable[$i]['order_no'] + 1;
				$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey],"order_no='".$order_no."'");
			}
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
			$max_id = $clsClassTable->getMaxID();
			$field .= ",user_id,user_id_update,reg_date,upd_date,slug,$clsClassTable->pkey,order_no";
			$value .= ",'".addslashes($core->_SESS->user_id)."','".addslashes($core->_SESS->user_id)."','".time()."','".time()."'";
			$value .= ",'".$core->replaceSpace($_POST['iso-title'])."','".$max_id."','1'";
			
			#--Special Field: image
			$image = isset($_POST['image_src']) ? $_POST['image_src']: '';
			if(_isoman_use){
				$image = $_POST['isoman_url_image'];
			}
			if($image!='' && $image!='0'){
				$field .= ',image';
				$value .= ",'".addslashes($image)."'";
			}
			
			#
			$pUrl = '';
			if($clsConfiguration->getValue('SiteHasCat_BOOK')){
				$gallerycat_id = $_POST['iso-gallerycat_id'];
				$pUrl .= '&gallerycat_id='.$gallerycat_id;
			}
			#
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$field .= ',is_online';
			$value .= ",'".$is_online."'";
			
			if($clsClassTable->insertOne($field,$value)){
				if ($_POST['button'] == '_EDIT') {
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&gallery_id='.$core->encryptID($max_id).'&message=updateSuccess');
				}else {
					header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=insertSuccess');
				}
			} else{
				header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=insertFailed');
			}
		}
	}
}
function default_trash(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Gallery";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$gallery_cat_id = isset($_GET['gallery_cat_id'])? $_GET['gallery_cat_id'] : "";
	
	$param_url = '';
	if(intval($gallery_cat_id)!=0){
		$param_url .= '&gallery_cat_id='.$gallery_cat_id;
	}
	
	if($pvalTable == "")
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=notPermission');

	if($clsClassTable->updateOne($pvalTable,"is_trash='1'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=TrashSuccess');
	}
}
function default_restore(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Gallery";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$gallery_cat_id = isset($_GET['gallery_cat_id'])? $_GET['gallery_cat_id'] : "";
	
	$param_url = '';
	if(intval($gallery_cat_id)!=0){
		$param_url .= '&gallery_cat_id='.$gallery_cat_id;
	}
	
	if($pvalTable == "")
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=notPermission');

	if($clsClassTable->updateOne($pvalTable,"is_trash='0'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=RestoreSuccess');
	}
}
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Gallery";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$gallery_cat_id = isset($_GET['gallery_cat_id'])? $_GET['gallery_cat_id'] : "";
	
	$param_url = '';
	if(intval($gallery_cat_id)!=0){
		$param_url .= '&gallery_cat_id='.$gallery_cat_id;
	}

	if($string = '' && $pvalTable == 0)
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=notPermission');
		
	if(isset($_POST['agree']) && $_POST['agree']=='agree'){
		if($clsClassTable->doDelete($pvalTable)){
			header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=DeleteSuccess');
		}
	}
}
function default_move(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Gallery";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	#
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$gallerycat_id = isset($_GET['gallerycat_id'])?intval($_GET['gallerycat_id']):0;
	$direct = isset($_GET['direct'])? $_GET['direct']:'';
	
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	if(($string!='' && $pvalTable == 0) || $direct==''){
		header('location: '.PCMS_URL.'/?mod='.$mod);
	}
	
	$where = '1=1 and is_trash=0 ';
	$pUrl = '';
	if(intval($gallerycat_id) > 0){
		$where.=" and gallerycat_id=".$gallerycat_id;
		$pUrl .= '&gallerycat_id='.$gallerycat_id;
	}
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
	header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=PositionSuccess');
}
function default_setting(){
	global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsConfiguration, $oneSetting;
	$user_id = $core->_USER['user_id'];
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
		header('location:'.PCMS_URL.'?mod='.$mod.'&act='.$act.'&message=UpdateSuccess'.$extUrl);
	}	
}

/*============ SITE BOOK CATEGORY ============*/
function default_cat(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$_LANG_ID,$clsISO,$clsConfiguration;
	$user_id = $core->_USER['user_id'];
	$assign_list["msg"] = isset($_GET['message'])?$_GET['message']:'';
	$clsGallery = new Gallery();$assign_list["clsGallery"] = $clsGallery;
	#
	if($clsConfiguration->getValue('SiteHasCruisesProperty') == 0) {
		header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&message=NotPermission');
		exit();
	}
	#
	$classTable = "GalleryCategory";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		if($_POST['keyword']!=''&&$_POST['keyword']!=''){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.$link);
	}
	
	# List all category
	$cond = "1=1";
	#Filter By Keyword
	if(isset($_GET['keyword']) && $_GET['keyword']!=''){
		$cond .= " and slug like '%".$core->replaceSpace($_GET['keyword'])."%'";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$orderBy = " order by order_no asc";
	#
	$allItem = $clsClassTable->getAll($cond.$orderBy);
	$assign_list["allItem"] = $allItem;
	
	//Action
	$action = isset($_GET['action'])?$_GET['action']:'';
	if($action == 'Trash'){
		$string = isset($_GET['gallerycat_id'])? ($_GET['gallerycat_id']) : '';
		$gallerycat_id = intval($core->decryptID($string));
		if($string=='' && $gallerycat_id==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		if($clsClassTable->updateOne($gallerycat_id,"is_trash='1'")){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&act=cat&message=TrashSuccess');
		}	
	}
	if($action =='Restore'){
		$string = isset($_GET['gallerycat_id'])? ($_GET['gallerycat_id']) : '';
		$gallerycat_id = intval($core->decryptID($string));
		if($string=='' && $gallerycat_id==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		if($clsClassTable->updateOne($gallerycat_id,"is_trash='0'")){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&act=cat&message=RestoreSuccess');
		}	
	}
	if($action=='Delete'){
		$string = isset($_GET['gallerycat_id'])? ($_GET['gallerycat_id']) : '';
		$gallerycat_id = intval($core->decryptID($string));
		if($string=='' && $gallerycat_id==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		
		if($clsClassTable->doDelete($gallerycat_id)){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&act=cat&message=DeleteSuccess');
		}
	}
	if($action == 'move'){
		$string = isset($_GET['gallerycat_id'])? ($_GET['gallerycat_id']) : '';
		$pvalTable = intval($core->decryptID($string));
		#
		if($string=='' && $pvalTable==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		#
		$direct = isset($_GET['direct'])?$_GET['direct']:'';
		$one = $clsClassTable->getOne($pvalTable);
		$order_no = $one['order_no'];
		$where = "is_trash=0";
		#
		if($direct=='moveup'){
			$lst = $clsClassTable->getAll($where." and order_no < $order_no order by order_no DESC limit 0,1");
			$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
			$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movedown'){
			$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no ASC limit 0,1");
			$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
			$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movetop'){
			$lst = $clsClassTable->getAll($where." and order_no < $order_no order by order_no asc LIMIT 0,1");
			$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
			$lst = $clsClassTable->getAll($where." and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
			for($i=0;$i<count($lst);$i++) {
				$clsClassTable->updateOne($lst[$i][$clsClassTable->pkey],"order_no='".($lst[$i]['order_no']+1)."'");	
			}
		}
		if($direct=='movebottom'){
			$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no desc LIMIT 0,1");
			$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
			$lst = $clsClassTable->getAll($where." and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
			for($i=0;$i<count($lst);$i++) {
				$clsClassTable->updateOne($lst[$i][$clsClassTable->pkey],"order_no='".($lst[$i]['order_no']-1)."'");	
			}
		}
		
		header('location: '.PCMS_URL.'/?mod='.$mod.'&act=cat&message=PositionSuccess');
	}
}
/*========== SITE BOOK CATEGORY =========== */
function default_SiteGalleryCategory(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsClassTable = new GalleryCategory();
	$gallerycat_id = isset($_POST['gallerycat_id'])?intval($_POST['gallerycat_id']):0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	#
	if($tp=='F'){
		$html='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($gallerycat_id==0?$core->get_Lang('add'):$core->get_Lang('edit')).' '.$core->get_Lang('Gallerycategory').'</h3>
		</div>';
		$html .= '
		<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="row-span">
					<div class="fieldlabel bold" style="text-align:right"> '.$core->get_Lang('title').' <strong class="color_r">*</strong></div>
					<div class="fieldarea">
						<input class="text_32 full-width border_aaa required" name="title" value="'.$clsClassTable->getTitle($gallerycat_id).'" type="text" autocomplete="off" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">'.$core->get_Lang('intro').'</div>
					<div class="fieldarea">
						<textarea  id="textarea_intro_editor'.time().'" class="textarea_intro_editor" name="intro" style="width:100%">'.$clsClassTable->getIntro($gallerycat_id).'</textarea>
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="button" gallerycat_id="'.$gallerycat_id.'" class="btn btn-primary btnSubmitGalleryCategory"><i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span> </button>
			<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span> </button>		
		</div>';
		echo($html);die();
	} elseif($tp=='S'){
		$titlePost = isset($_POST['title'])?trim(strip_tags($_POST['title'])):'';
		$slugPost = $core->replaceSpace($titlePost);
		$parent_id = isset($_POST['parent_id'])?intval($_POST['parent_id']):0;
		$introPost = addslashes($_POST['intro']);
		#
		if($gallerycat_id==0){
			if($clsClassTable->countItem("parent_id='$parent_id' and slug='$slugPost'") > 0){
				echo '_EXIST'; die();
			}else{
				$f="user_id,user_id_update,parent_id,title,slug,intro,order_no,$clsClassTable->pkey,reg_date,upd_date";
				$v = "'$user_id','$user_id','$parent_id','".addslashes($titlePost)."','".addslashes($slugPost)."','".addslashes($introPost)."'";
				$v.= ",'".$clsClassTable->getMaxOrderNo()."','".$clsClassTable->getMaxID()."','".time()."','".time()."'";
				#
				if($clsClassTable->insertOne($f,$v)){
					echo '_SUCCESS'; die();	
				}else{
					echo '_ERROR'; die();
				}
			}
		} else {
			if($clsClassTable->getAll("parent_id='$parent_id' and slug='$slugPost' and gallerycat_id <> '$gallerycat_id'")!=''){
				echo '_EXIST'; die();
			}else{
				$set = "title='".addslashes($titlePost)."',slug='".addslashes($slugPost)."',intro='".addslashes($introPost)."',parent_id='$parent_id',upd_date='".time()."'";
				if($clsClassTable->updateOne($gallerycat_id, $set)){
					echo '_SUCCESS'; die();	
				}else{
					echo '_ERROR'; die();
				}
			}
		}
	}
}
/*========== SITE BOOK TAGS =============*/
function default_ajSiteGalleryTags(){
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
		$tag_module_id = $clsTagModule->getId($tag_id,$for_id);
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
?>