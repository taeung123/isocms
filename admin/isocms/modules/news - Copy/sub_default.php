<?php
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting,$clsConfiguration,$clsISO,$package_id;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	global $_user_group_id;
	
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#
	$clsNewsCategory = new NewsCategory();
	$assign_list["clsNewsCategory"] = $clsNewsCategory;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		if(isset($_POST['newscat_id']) &&  $_POST['newscat_id']!=''){
			$link .= '&newscat_id='.$_POST['newscat_id'];
		}
		if($_POST['user_ctv_id']!=''&& intval($_POST['user_ctv_id'])!=0){
			$link .= '&user_ctv_id='.$_POST['user_ctv_id'];
		}
		if($_POST['is_approve_id']!=''&& $_POST['is_approve_id']!=0){
			$link .= '&is_approve_id='.$_POST['is_approve_id'];
		}
		if($_POST['from_date']!=''&& $_POST['from_date']!=''){
			$link .= '&from_date='.$_POST['from_date'];
		}
		if($_POST['to_date']!=''&& $_POST['to_date']!=''){
			$link .= '&to_date='.$_POST['to_date'];
		}
		if($_POST['keyword']!=''&&$_POST['keyword']!='testimonial title, intro'){
			$link .= '&keyword='.$_POST['keyword'];
		}
		
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	$newscat_id = isset($_GET['newscat_id']) ? intval($_GET['newscat_id']) : '';
	$assign_list["newscat_id"] = $newscat_id;
	
	/**/
	$classTable = "News";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	
	$cond = "1=1";
	//Check By CTV
	if($_user_group_id==5){
		$cond .= " and user_id='$user_id'";
	}else{
		if($user_id==1){
			
		}else{
			$cond .= " and is_approve=1";
		}
	}
	if($newscat_id > 0){
		$cond .= " and (newscat_id='$newscat_id' or list_cat_id like '%|$newscat_id|%')";
		$pUrl.='&newscat_id='.$newscat_id;
	}
	if(isset($_GET['user_ctv_id']) && intval($_GET['user_ctv_id']) > 0){
		$cond .= " and user_id =  '".$_GET['user_ctv_id']."'";
		$assign_list["user_ctv_id"] = $_GET['user_ctv_id'];
		$pUrl.='&user_ctv_id='.$_GET['user_ctv_id'];
	}
	if(isset($_GET['is_approve_id'])&& intval($_GET['is_approve_id']) > 0){
		if($_GET['is_approve_id']==2){
			$cond .= " and is_approve =  '0'";
		}else{
			$cond .= " and is_approve =  '".$_GET['is_approve_id']."'";
		}
		$assign_list["is_approve_id"] = $_GET['is_approve_id'];
		$pUrl.='&is_approve_id='.$_GET['is_approve_id'];
	}
	
	if(isset($_GET['from_date'])){
		//$from_date = str_replace('/', '-', $_GET['from_date']);
		$from_date =$_GET['from_date'];
		$from_date=strtotime($from_date);
		$cond .= " and reg_date >=  '".$from_date."'";
		$assign_list["from_date"] = $from_date;
		$pUrl.='&from_date='.$_GET['from_date'];
	}
	
	if(isset($_GET['to_date'])){
		//$to_date = str_replace('/', '-', $_GET['to_date']);
		$to_date = $_GET['to_date'];
		$to_date=strtotime($to_date);
		$cond .= " and reg_date <=  '".$to_date."'";
		$assign_list["to_date"] = $to_date;
		$pUrl.='&to_date='.$_GET['to_date'];
	}
	#Filter By Keyword
	if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
//		print_r($keyword);die();
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
	
	if($type_list=='Approved'){
		$cond .= " and is_approve=1";
	}
	if($type_list=='Unapproved'){
		$cond .= " and is_approve=0";
	}
	$orderBy = " order_no asc";
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
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
		if($_POST['submit']=='UpdateNewsIntro'){
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
function default_ajUpdPosSortListNews(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	
	$classTable = "News";
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
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav,$dbconn, $clsConfiguration,$clsISO,$pvalTable,$clsClassTable;
	global $_user_group_id,$clsISO,$package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "News";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["classTable"] = $classTable;
	
	$clsNewsCategory = new NewsCategory();
	$assign_list["clsNewsCategory"] = $clsNewsCategory;
	$assign_list["newscat_id"] = isset($_GET['newscat_id']) ? intval($_GET['newscat_id']) : 0;
	#
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	if($pvalTable > 0){
		$assign_list["newscat_id"] = $oneItem['newscat_id'];
	}
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
	$clsForm->addInputTextArea("simple_height150",'intro', "", 'intro', 255, 25, 5, 1,  "style='width:100%'");
	$clsForm->addInputTextArea("full",'content', "", 'content', 255, 25, 20, 1,  "style='width:100%'");
	#

	if(intval($pvalTable) > 0 && $clsConfiguration->getValue('SiteHasTags_News')){
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
		$listTag = $clsTagModule->getAll("1=1 and for_id='$pvalTable' and type = '_NEWS' order by reg_date asc limit 0,20");
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
					}
					else{
						$set .= ",".$tmp[1]."='".addslashes($val)."'";
					}
				}
			}
			$set .= ",user_id_update='".addslashes($core->_SESS->user_id)."'";
			$set .= ",upd_date='".time()."'";
			$set .= ",slug='".$clsISO->replaceSpace2($_POST['iso-title'])."'";
			
			#--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src']: '';
            if(_isoman_use){
                $image = $_POST['isoman_url_image'];
            }
            if($image!='' && $image!='0'){
                $set .= ",image='".addslashes($image)."'";
            }
            #
            #--Special Field: logo_news
            $logo_news = isset($_POST['logo_news_src']) ? $_POST['logo_news_src']: '';
            if(_isoman_use){
                $logo_news = $_POST['isoman_url_logo_news'];
            }
            if($logo_news!='' && $logo_news!='0'){
                $set .= ",logo_news='".addslashes($logo_news)."'";
            }
            #

			$pUrl = '';
			if($clsConfiguration->getValue('SiteHasCat_News')){
				$newscat_id = $_POST['iso-newscat_id'];
				$list_cat_id = $clsNewsCategory->getListParent($newscat_id);
				$set .= ",list_cat_id='".addslashes($list_cat_id)."'";
				$pUrl .= '&newscat_id='.$newscat_id;
			}
			$tagPost = $_POST['list_tag_id'];
			if (!empty($tagPost) && $tagPost != '0') {
				$tags_array = explode(',', $tagPost);
				foreach ($tags_array as $tag) {
					$lstcheck = $clsTag->getAll("slug='".$core->replaceSpace($tag)."' limit 0,1");
					if(!empty($lstcheck)){
						$tags_list[] = $lstcheck[0][$clsTag->pkey];
					}else{
						$id = $clsTag->getMaxId();
						$ft = "tag_id,title,slug";
						$vt = "'$id','".$tag."','".$clsISO->replaceSpace2($tag)."'";
						$clsTag->insertOne($ft,$vt);
						$tags_list[] = $id;
					}
				}
				$set .= ",list_tag_id='" . $clsISO->makeSlashListFromArray2($tags_list) . "'";
			}else{
				$set .= ",list_tag_id=''";
			}
			
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$set .= ",is_online='".$is_online."'";
			//print_r($pvalTable.'xxxx'.$set); die();
			if($clsClassTable->updateOne($pvalTable,$set)) {
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
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&'.$clsClassTable->pkey.'='.$_GET[$clsClassTable->pkey].'&message=updateSuccess');
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
					}
					else{
						$field .= ','.$tmp[1];
						$value .= ",'".addslashes($val)."'";
					}
				}
			}
			#
			$news_id = $clsClassTable->getMaxId();
			$field .= ",user_id,user_id_update,reg_date,upd_date,slug,$clsClassTable->pkey,order_no";
			$value .= ",'".addslashes($core->_SESS->user_id)."','".addslashes($core->_SESS->user_id)."','".time()."','".time()."'";
			$value .= ",'".$clsISO->replaceSpace2($_POST['iso-title'])."','".$news_id."','1'";
			
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
			$tagPost = $_POST['list_tag_id'];
			if (!empty($tagPost) && $tagPost != '0') {
				$tags_array = explode(',', $tagPost);
				foreach ($tags_array as $tag) {
					$lstcheck = $clsTag->getAll("slug='".$core->replaceSpace($tag)."' limit 0,1");
					if(!empty($lstcheck)){
						$tags_list[] = $lstcheck[0][$clsTag->pkey];
					}else{
						$id = $clsTag->getMaxId();
						$ft = "tag_id,title,slug";
						$vt = "'$id','".$tag."','".$clsISO->replaceSpace2($tag)."'";
						$clsTag->insertOne($ft,$vt);
						$tags_list[] = $id;
					}
				}
				$field .= ',list_tag_id';
				$value .= ",'" . $clsISO->makeSlashListFromArray2($tags_list) . "'";
			}else{
				$field .= ',list_tag_id';
				$value .= ",''";
			}
            #--Special Field: logo_news
            $logo_news = isset($_POST['logo_news_src']) ? $_POST['logo_news_src']: '';
            if(_isoman_use){
                $logo_news = $_POST['isoman_url_logo_news'];
            }
            if($logo_news!='' && $logo_news!='0'){
                $field .= ',logo_news';
                $value .= ",'".addslashes($logo_news)."'";
            }
            #
			$pUrl = '';
			if($clsConfiguration->getValue('SiteHasCat_News')){
				$newscat_id = $_POST['iso-newscat_id'];
				$list_cat_id = $clsNewsCategory->getListParent($newscat_id);
				$field .= ',list_cat_id';
				$value .= ",'".addslashes($list_cat_id)."'";
				$pUrl .= '&newscat_id='.$newscat_id;
			}
			if($CTV_POST){
				if($_user_group_id ==5){
					$field .= ',is_approve';
					$value .= ",'0'";
				}
			}else{
				$field .= ',is_approve';
				$value .= ",'1'";
			}
			
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$field .= ',is_online';
			$value .= ",'".$is_online."'";
			#
			if($clsClassTable->insertOne($field,$value)){
				if ($_POST['button'] == '_EDIT') {
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=edit&news_id='.$core->encryptID($news_id).'&message=insertSuccess');
				}else {
					header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=insertSuccess'); 
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
	$classTable = "News";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$newscat_id = isset($_GET['newscat_id'])? $_GET['newscat_id'] : "";
	
	$pUrl = '';
	if(intval($newscat_id)> 0){
		$pUrl .= '&newscat_id='.$newscat_id;
	}
	if($pvalTable == 0){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=notPermission');
	}
	if($clsClassTable->updateOne($pvalTable,"is_trash='1'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=TrashSuccess');
	}
}
function default_restore(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "News";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$newscat_id = isset($_GET['newscat_id'])? $_GET['newscat_id'] : "";
	
	$pUrl = '';
	if(intval($newscat_id)> 0){
		$pUrl .= '&newscat_id='.$newscat_id;
	}
	if($pvalTable == 0){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=notPermission');
	}
	if($clsClassTable->updateOne($pvalTable,"is_trash='0'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=RestoreSuccess');
	}
}
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "News";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;

	$pkeyTable = $clsClassTable->pkey;
	
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$newscat_id = isset($_GET['newscat_id'])? $_GET['newscat_id'] : "";
	
	$pUrl = '';
	if(intval($newscat_id)> 0){
		$pUrl .= '&newscat_id='.$newscat_id;
	}
	if($pvalTable == 0){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=notPermission');
	}
	if($clsClassTable->doDelete($pvalTable)){
		header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=DeleteSuccess');
	}
}
function default_move(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "News";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	#
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$newscat_id = isset($_GET['newscat_id'])?intval($_GET['newscat_id']):0;
	$direct = isset($_GET['direct'])? $_GET['direct']:'';
	
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	if(($string!='' && $pvalTable == 0) || $direct==''){
		header('location: '.PCMS_URL.'/?mod='.$mod);
	}
	
	$where = '1=1 and is_trash=0';
	$pUrl = '';
	if(intval($newscat_id) > 0){
		$where.=" and (newscat_id='$newscat_id' or list_cat_id like '%|$newscat_id|%')";
		$pUrl .= '&newscat_id='.$newscat_id;
	}
	if($direct=='moveup'){
		$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movedown'){
		$lst = $clsClassTable->getAll($where." and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movetop'){
		$lst = $clsClassTable->getAll($where." and order_no > $order_no order by order_no asc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$lstItem = $clsClassTable->getAll($where." and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
		for($i=0;$i<count($lstItem);$i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey],"order_no='".($lstItem[$i]['order_no']-1)."'");	
		}
	}
	if($direct=='movebottom'){
		$lst = $clsClassTable->getAll($where." and order_no < $order_no order by order_no desc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$lstItem = $clsClassTable->getAll($where." and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no desc");
		for($i=0;$i<count($lstItem);$i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey],"order_no='".($lstItem[$i]['order_no']+1)."'");	
		}
	}
	header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=PositionSuccess');
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
/*========== SITE NEWS CATEGORY =============*/
function default_category(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $clsConfiguration ;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$_LANG_ID,$clsISO;
	$user_id = $core->_USER['user_id'];
	$assign_list["msg"] = isset($_GET['message'])?$_GET['message']:'';
	#
	if(!$clsConfiguration->getValue('SiteHasCat_News')){
		header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&message=NotPermission');
		exit();
	}
	#
	$type_list = isset($_GET[''])?$_GET['']:'';
	$assign_list["type_list"] = $type_list;
	#
	$classTable = "NewsCategory";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	$clsNews = new News(); $assign_list["clsNews"] = $clsNews;
	
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
		$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
		$newscat_id = intval($core->decryptID($string));
		if($string=='' && $newscat_id==0){
			header('location:'.PCMS_URL.'/index.php?mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		if($clsClassTable->updateOne($newscat_id,"is_trash='1'")){
			header('location: '.PCMS_URL.'/index.php?mod='.$mod.'&act=category&message=TrashSuccess');
		}	
	}
	if($action =='Restore'){
		$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
		$newscat_id = intval($core->decryptID($string));
		if($string=='' && $newscat_id==0){
			header('location:'.PCMS_URL.'/index.php?mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		if($clsClassTable->updateOne($newscat_id,"is_trash='0'")){
			header('location: '.PCMS_URL.'/index.php?mod='.$mod.'&act='.$act.'&message=RestoreSuccess');
		}	
	}
	if($action=='Delete'){
		$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
		$newscat_id = intval($core->decryptID($string));
		if($string=='' && $newscat_id==0){
			header('location:'.PCMS_URL.'/index.php?mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		$listItem = $clsNews->getAll("newscat_id = '$newscat_id' limit 0,1");
		if($listItem[0][$clsNews->pkey]!=''){
			header('location:'.PCMS_URL.'/index.php?mod='.$mod.'&act='.$act.'&message=DeleteFailed');
			exit();
		}
		if($clsClassTable->doDelete($newscat_id)){
			header('location: '.PCMS_URL.'/index.php?mod='.$mod.'&act='.$act.'&message=DeleteSuccess');
		}
	}
	if($action == 'move'){
		$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
		$pvalTable = intval($core->decryptID($string));
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
		
		header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&message=PositionSuccess');
	}
}
function default_ajUpdPosSortListNewsCat(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	
	$classTable = "NewsCategory";
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

function default_SiteNewsCategory(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsNewsCategory = new NewsCategory();
	$newscat_id = isset($_POST['newscat_id']) ? intval($_POST['newscat_id']) : 0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	$user_id = $core->_USER['user_id'];
	#
	if($tp=='F'){
		$html='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($newscat_id==0?$core->get_Lang('add'):$core->get_Lang('edit')).' '.$core->get_Lang('newscategory').'</h3>
		</div>';
		$html .= '
		<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="row-span">
					<div class="fieldlabel text_left_767" style="text-align:right"><strong>'.$core->get_Lang('title').'</strong><span  class="color_r">*</span></div>
					<div class="fieldarea">
						<input class="text full required" value="'.$clsNewsCategory->getOneField('title',$newscat_id).'" name="title" type="text" autocomplete="off" />
					</div>
				</div>
				<div class="row-span" style="display:none">
					<div class="fieldlabel text_left_767" style="text-align:right"><strong>'.$core->get_Lang('category').' </strong><span color="red">*</span></div>
					<div class="fieldarea">
						<select name="parent_id" class="select slb">
							<option value="0"> -- '.$core->get_Lang('Select category').' -- </option>
						</select>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel text_left_767" style="text-align:right"><strong>'.$core->get_Lang('intro').'</strong></div>
					<div class="fieldarea">
						<textarea  id="textarea_intro_editor_'.time().'" class="textarea_intro_editor" name="intro" style="width:100%">'.$clsNewsCategory->getOneField('intro',$newscat_id).'</textarea>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel text_left_767" style="text-align:right"><strong>'.$core->get_Lang('Content banner').'</strong></div>
					<div class="fieldarea">
						<textarea  id="textarea_content_editor_'.time().'" class="textarea_content_editor" name="content" style="width:100%">'.$clsNewsCategory->getOneField('content',$newscat_id).'</textarea>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel text_left_767" style="text-align:right"><strong>'.$core->get_Lang('Banner').' <span class="small">(WxH=1920x480)</span></strong></div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_image_banner" src="' . $clsNewsCategory->getOneField('image', $newscat_id) . '" />
						<input type="hidden" id="isoman_hidden_image_banner" value="' . $clsNewsCategory->getOneField('image', $newscat_id) . '">
						<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image_banner" name="image_banner" value="' . $clsNewsCategory->getOneField('image', $newscat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_banner" isoman_val="' . $clsNewsCategory->getOneField('image', $newscat_id) . '" isoman_name="image_banner"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="button" newscat_id="'.$newscat_id.'" class="btn btn-primary ClickSubmitCategory">
				<i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span> </button>		
		</div>';
		echo($html);die();
	} elseif($tp=='S'){
		$titlePost = isset($_POST['title'])?trim(addslashes($_POST['title'])):'';
		$slugPost = $core->replaceSpace($titlePost);
		$introPost = isset($_POST['intro'])?addslashes($_POST['intro']):'';
		$contentPost = isset($_POST['content'])?addslashes($_POST['content']):'';
		$image_banner = isset($_POST['image_banner'])?addslashes($_POST['image_banner']):'';
		$parent_id = isset($_POST['parent_id'])?intval($_POST['parent_id']):0;
		if(intval($newscat_id)==0){
			if($clsNewsCategory->getAll("parent_id='$parent_id' and slug='$slugPost'")!=''){
				echo '_EXIST'; die();
			}else{
				$listTable=$clsNewsCategory->getAll("1=1", $clsNewsCategory->pkey.",order_no");
				for ($i = 0; $i <= count($listTable); $i++) {
					$order_no=$listTable[$i]['order_no'] + 1;
					$clsNewsCategory->updateOne($listTable[$i][$clsNewsCategory->pkey],"order_no='".$order_no."'");
				}
				
				$fx = "user_id,user_id_update,parent_id,title,slug,intro,content,image,order_no,newscat_id,reg_date,upd_date";
				$vx = "'$user_id','$user_id','$parent_id','$titlePost','$slugPost','".addslashes($introPost)."','".addslashes($contentPost)."','" . addslashes($image_banner) . "'";
				$vx.= ",'1','".$clsNewsCategory->getMaxID()."','".time()."','".time()."'";
				#
				if($clsNewsCategory->insertOne($fx,$vx)){
					echo '_SUCCESS'; die();	
				}else{
					echo '_ERROR'; die();
				}
			}
		}else{
			if($clsNewsCategory->getAll("parent_id='$parent_id' and slug='$slugPost' and newscat_id <> '$newscat_id'")!=''){
				echo '_EXIST'; die();
			}else{
				$vx = "title='$titlePost',slug='$slugPost',intro='".addslashes($introPost)."',content='".addslashes($contentPost)."',image='".addslashes($image_banner)."',parent_id='$parent_id',upd_date='".time()."'";
				if($clsNewsCategory->updateOne($newscat_id, $vx)){
					echo '_SUCCESS'; die();	
				}else{
					echo '_ERROR'; die();
				}
			}
		}
	}
}
/*========== SITE NEWS TAGS =============*/
function default_ajSiteNewsTags(){
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
/*============= DUPLICATE NEWS ============*/
function default_ajDuplicateNews(){
	global $core, $mod, $clsISO;
	#
	$user_id = $core->_USER['user_id'];
	$news_id_duplicate = $_POST['news_id'];
	
	$html = '';
	
	#=== Duplicate News Table--------------------------
	$clsNews = new News();
	$oneNews = $clsNews->getOne($news_id_duplicate);
	$news_id = $clsNews->getMaxID();
	$max_news_order = $clsNews->getMaxOrderNo();
	$fx = "news_id,order_no";
	$vx= "'$news_id','$max_news_order'";
	foreach($oneNews as $key=>$value){ 
		if(intval($key)==0 && $key!=$clsNews->pkey && $key!='order_no'){
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
	$clsNews->insertOne($fx,$vx);
	#End Duplicate News Table--------------------------
	#Duplicate News Tag Table------------------------------
	$clsTagNews = new TagNews();
	$lstTagNews = $clsTagNews->getAll("news_id='$news_id_duplicate'");
	if($lstTagNews[0][$clsTagNews->pkey]!=''){
		for($i=0;$i<count($lstTagNews);$i++){
			$oneItem = $lstTagNews[$i];
			$fx = "$clsTagNews->pkey";
			$vx = "'".$clsTagNews->getMaxID()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTagNews->pkey){
					$fx .= ",".$key;
					if($key=='news_id')
						$vx .= ",'$news_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}
			$clsTagNews->insertOne($fx,$vx); 
		}
	} unset($clsTagNews);
	#End Duplicate News Tag table------------------------------
	
	$html = PCMS_URL.'/index.php?mod='.$mod.'&act=edit&'.$clsNews->pkey.'='.$core->encryptID($news_id);
	echo($html);die();
}
?>