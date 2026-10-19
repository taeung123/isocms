<?php
function default_default() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
	$pUrl = '';
    #
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
	
	$clsCountry= new Country();
	$assign_list["clsCountry"] = $clsCountry;
	
	$clsVideoStore= new VideoStore();
	$assign_list["clsVideoStore"] = $clsVideoStore;
    #
    $type_list = isset($_GET['type_list'])?$_GET['type_list']:'';$assign_list["type_list"] = $type_list;
    $mod_page = isset($_GET['mod_page'])?$_GET['mod_page']:'';$assign_list["mod_page"] = $mod_page;
	$act_page = isset($_GET['act_page'])?$_GET['act_page']:'';$assign_list["act_page"] = $act_page;
	$target_id = isset($_GET['target_id'])?intval($_GET['target_id']):0;$assign_list["target_id"] = $target_id;
	/*$type = isset($_GET['type'])?$_GET['type']:'_HOME_SLIDE'; $assign_list["type"] = $type;*/
	#
	$clsTable = isset($_GET['clsTable'])?$_GET['clsTable']:'';
	if(!empty($clsTable)) {
		$clsTargetTable = new $clsTable;
		$assign_list["clsTargetTable"] = $clsTargetTable;
	}
	$assign_list["clsTable"] = $clsTable;
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
		if(isset($clsTable) && !empty($clsTable)) {
			$link .= '&clsTable='.$clsTable;
		}
        if(isset($_POST['keyword']) && !empty($_POST['keyword'])) {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
	if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateVideoConfiguration') {
		$video_teaser_page = $_POST['video_teaser_page'];
		$clsConfiguration->updateValue('video_teaser_page', $video_teaser_page);
		header('location:' . PCMS_URL.'?mod='.$mod .'&message=UpdateSuccess');
	}
	
    $classTable = "Video";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
	
	$lstModVideo = $clsClassTable->getListModPage();
	$assign_list["lstModVideo"] = $lstModVideo;
    
	#
	$cond = "1='1'";
	if(!empty($type)){
		 $cond.= " and type = '$type'";
	}
	#

	if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (title like '%".$_GET['keyword']."%' or text like '%".$_GET['keyword']."%' or slug like '%".$keyword."%') ";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$assign_list["pUrl"] = $pUrl;
    #
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
    #
    $allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2);
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2);
    $assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
    #
    $allAll = $clsClassTable->getAll($cond2);
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
}
function default_ajUpdPosSortListVideo(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsVideo = new Video();
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key+1);
		$clsVideo->updateOne($val,"order_no='".$key."'");	
	}
}
function default_edit() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Video";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    #
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $oneTable = $clsClassTable->getOne($pvalTable);
    $assign_list['oneTable'] = $oneTable;
	$clsTable = isset($_GET['clsTable'])?$_GET['clsTable']:'';
	$type = isset($_GET['type'])?$_GET['type']:'_HOME_SLIDE'; $assign_list["type"] = $type;
	
	if(intval($pvalTable) > 0) {
		$_MOD = isset($oneTable['mod_page'])?$oneTable['mod_page'] : 'slide'; 
		$_MOD_PAGE = ($_MOD=='slide') ? 'home': $_MOD;$assign_list["mod_page"] = $_MOD_PAGE;
		$_ACT = isset($oneTable['act_page'])?$oneTable['act_page'] : 'default'; $assign_list["act_page"] = $_ACT;
		$target_id = isset($oneTable['target_id'])? intval($oneTable['target_id']): 0; $assign_list["target_id"] = $target_id;
		$type = $oneTable['type']; $assign_list["type"] = $type;
	} else {
		$_MOD = isset($_GET['mod_page'])?$_GET['mod_page'] : 'slide'; 
		$_MOD_PAGE = ($_MOD=='slide') ? 'home': $_MOD;$assign_list["mod_page"] = $_MOD_PAGE;
		$_ACT = isset($_GET['act_page'])?$_GET['act_page'] : 'default'; $assign_list["act_page"] = $_ACT;
		$target_id = isset($_GET['target_id'])? intval($_GET['target_id']): 0; $assign_list["target_id"] = $target_id;
	}
	
	$pUrl = '';
	if(isset($_MOD_PAGE) && !empty($_MOD_PAGE)){$pUrl.='&mod_page='.$_MOD_PAGE;}
	if(isset($_ACT) && !empty($_ACT)){$pUrl.='&act_page='.$_ACT;}
	if(isset($target_id) && intval($target_id) > 0){$pUrl.='&target_id='.$target_id;}
	if(isset($clsTable) && !empty($clsTable)){$pUrl.='&clsTable='.$clsTable;}
	
	
	$coutry_id = isset($oneTable['coutry_id'])?$oneTable['coutry_id'] : '1'; 
	$assign_list['coutry_id'] = $coutry_id;
	
	$pUrl = '&type='.$type;
	
	$clsCountry= new Country();$assign_list['clsCountry']=$clsCountry;
	
	#
	if($string!='' && $pvalTable==0){
		header('location:'.PCMS_URL.'/index.php?&mod='.$mod.'&message=notPermission');
	}
	
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm; 
	
	
	#
	$clsForm->addInputTextArea("simple150",'text', "", 'text', 255, 25, 2, 1,  "style='width:100%'");
	
	#=========================================#
    if(isset($_POST['submit']) && $_POST['submit'] =='Update'){
        if ($pvalTable > 0) {
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
			$title=$_POST['title'];
			$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
			$set .= ",user_id_update='".addslashes($core->_SESS->user_id)."'";
			$set .= ",upd_date='".time()."'";
			$set .= ",title='".$title."'";
			$set .= ",slug='".$core->replaceSpace($_POST['title'])."'";
			
			#--Special Field: image
			if(_isoman_use){
				$set .= ",image='".addslashes($_POST['isoman_url_image'])."'";
			} else {
				$image = $_POST['image'];
				if($image!=''&&$image!='0'){
					$set .= ",image='".addslashes($image)."'";
				}
			}
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$set .= ",is_online='".$is_online."'";
			//print_r($pvalTable.'<br/>'.$set); die();
            if($clsClassTable->updateOne($pvalTable,$set)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&'.$clsClassTable->pkey.'='.$_GET[$clsClassTable->pkey].'&message=updateSuccess');
                } else {
                    header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=updateSuccess');
                }
            } else {
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
			
			$max_id = $clsClassTable->getMaxID();
			$title=$_POST['title'];
			$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
			$field .= ",$clsClassTable->pkey,user_id,user_id_update,reg_date,upd_date,slug,title,order_no";
			$value .= ",'".$max_id."','".addslashes($core->_SESS->user_id)."','".addslashes($core->_SESS->user_id)."','".time()."','".time()."'";
			$value .= ",'".$core->replaceSpace($_POST['title'])."','".$title."','1'";
			
			#--Special Field: image
			if(_isoman_use){
				$field .= ',image';
				$value .= ",'".addslashes($_POST['isoman_url_image'])."'";
			} else {
				$image = $_POST['image'];
				if($image!=''&&$image!='0'){
					$field .= ',image';
					$value .= ",'".addslashes($image)."'";
				}
			}
			$is_online= isset($_POST['is_online'])?$_POST['is_online']:0;
			$field .= ',is_online';
			$value .= ",'".$is_online."'";
            #
            if($clsClassTable->insertOne($field, $value)) {
                if($_POST['button'] == '_EDIT') {
                    header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&'.$clsClassTable->pkey.'='.$core->encryptID($max_id).'&message=insertSuccess');
                } else {
                    header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=insertSuccess');
                }
            } else {
                header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=insertFailed');
            }
        }
    }
}
function default_trash() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Video";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    #
    $mod_page =(isset($_GET['mod_page']))?$_GET['mod_page']:'';
    $mod_link=($mod_page !="")?"&mod_page=".$mod_page:"";
    if ($pvalTable == "")
        header('location: ' . PCMS_URL . '/?mod=' . $mod .'&message=notPermission');

    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod .$mod_link. '&message=TrashSuccess');
    }
}

function default_restore() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Video";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    #
    $mod_page =(isset($_GET['mod_page']))?$_GET['mod_page']:'';
    $mod_link=($mod_page !="")?"&mod_page=".$mod_page:"";
    if ($pvalTable == "")
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod .$mod_link. '&message=RestoreSuccess');
    }
}
function default_delete() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Video";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
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
function default_move() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Video";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
	#
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
	
	$mod_page = isset($_GET['mod_page']) ? $_GET['mod_page'] : '';
	$act_page = isset($_GET['act_page']) ? $_GET['act_page'] : '';
	$clsTable = isset($_GET['clsTable']) ? $_GET['clsTable'] : '';
	$target_id = isset($_GET['target_id']) ? intval($_GET['target_id']) : 0;
    
    $one = $clsClassTable->getOne($pvalTable);
    $order_no = $one['order_no'];
	if(($string!='' && $pvalTable == 0) || $direct==''){
		header('location: '.PCMS_URL.'/?mod='.$mod);
	}
	
	$where = '1=1 and is_trash=0';
	$pUrl = '';
	if(isset($mod_page) && !empty($mod_page)) {
        $where.= " and mod_page = '$mod_page'";
        $pUrl .= '&mod_page='.$mod_page;
    }
	if(isset($act_page) && !empty($act_page)) {
        $where.= " and act_page = '$act_page'";
        $pUrl .= '&act_page='.$act_page;
    }
	if(isset($target_id) && intval($target_id) > 0) {
		$where.= " and target_id = '$target_id'";
		$pUrl .= '&target_id='.$target_id;
	}
	if(isset($clsTable) && !empty($clsTable)) {
        $pUrl .= '&clsTable='.$clsTable;
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

/*========== SITE SLIDE GROUP =============*/
function default_group(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $clsConfiguration ;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$_LANG_ID,$clsISO;
	$user_id = $core->_USER['user_id'];
	$assign_list["msg"] = isset($_GET['message'])?$_GET['message']:'';
	#
	$type_list = isset($_GET[''])?$_GET['']:'';
	$assign_list["type_list"] = $type_list;
	#
	$classTable = "VideoGroup";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	
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
function default_store(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	$pUrl = '';
	#
	$clsVideoStore = new VideoStore();
	$assign_list["clsVideoStore"] = $clsVideoStore;
	#
	$classTable = "Video";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$type = isset($_GET['type'])?$core->decryptID($_GET['type']):'';$assign_list["type"] = $type;
	$keyword = isset($_GET['keyword'])?$_GET['keyword']:'';$assign_list["keyword"] = $keyword;
	
	if($type==''){
		header('location: '.PCMS_URL.'/?mod=video&message=notPermission');
	}
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = '&act='.$act;
		$link .= '&type='.$core->encryptID($type);

		if($_POST['keyword']!=''&&$_POST['keyword']!='Tìm kiếm...'){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	#
	$cond = "is_trash=0 and is_online=1";

	if($type != ''){
		$cond.= " and video_id NOT IN (SELECT video_id FROM ".DB_PREFIX."video_store WHERE is_trash=0 and _type='$type')";
		$pUrl.='&type='.$core->encryptID($type);
	}
	if($keyword != ''){
		$slug = $core->replaceSpace($keyword);
		$cond .= " and slug like '%".$slug."%'";
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
	$stt=($currentPage-1)*$recordPerPage;
	$assign_list['stt'] = $stt;
	
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
	$listItem = $clsClassTable->getAll($cond." order by ".$orderBy.$limit);
	$assign_list["listItem"] = $listItem;
	
	
	#
	$listSelected =  $clsVideoStore->getAll("is_trash=0 and _type = '$type' order by order_no asc");
	$assign_list["listSelected"] = $listSelected;
	
	//Action
	$action = isset($_GET['action'])?$_GET['action']:'';
	if($action=='Add'){
		$pvalTable = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]: '';
		if($pvalTable=='' && $pvalTable==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		if(!$clsVideoStore->checkExist($pvalTable,$type)) {
			$listTable=$clsVideoStore->getAll("1=1 and _type='$type'", $clsVideoStore->pkey.",order_no");
			for ($i = 0; $i <= count($listTable); $i++) {
				$order_no=$listTable[$i]['order_no'] + 1;
				$clsVideoStore->updateOne($listTable[$i][$clsVideoStore->pkey],"order_no='".$order_no."'");
			}
			$max_order_no = $clsVideoStore->getMaxOrder();
			$f = "video_id,_type,order_no";
			$v = "'$pvalTable','$type','1'";
			if($clsVideoStore->insertOne($f,$v)) {
				header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.$pUrl.'&message=insertSuccess');
			}
		}
	}
	//print_r(xxxx); die();
}
function default_ajSaveStoreForVideo(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsVideoStore = new VideoStore();
	$type = isset($_POST['type'])?$_POST['type']:'';
	$list_video_id = isset($_POST['list_video_id'])?$_POST['list_video_id']:'';
	$list_video_id = rtrim($list_video_id,'|');
	
	if($list_video_id !='' ){
		$tmp = explode('|',$list_video_id);
		if(!empty($tmp)){
			foreach($tmp as $i){
				if(!$clsVideoStore->checkExist($i,$type)){
					#
					$max_id = $clsVideoStore->getMaxID();
					$max_order = $clsVideoStore->getMaxOrder();
					$f = "$clsVideoStore->pkey,video_id,_type,order_no";
					$v = "'$max_id','$i','$type','$max_order'";
					$clsVideoStore->insertOne($f,$v);
				}
			}
			echo '_SUCCESS'; die();
		}else{
			echo '_ERROR'; die();
		}
	}else{
		echo '_ERROR'; die();
	}
}
function default_ajDeleteVideoStore(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsClassTable = new VideoStore();
	$pvalTable = isset($_POST['video_store_id'])?$_POST['video_store_id']:0;
	$clsClassTable->deleteOne($pvalTable);
	echo(1); die();
}
function default_ajUpdPosSortVideoStore(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsVideoStore = new VideoStore();
	$type = $_POST['type'];
	$order = $_POST['order'];
	$currentPage 	= $_POST['currentPage'];
	$recordPerPage 	= $_POST['recordPerPage'];
	//var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
	foreach($order as $key=>$val){
		$key = (($currentPage-1)*$recordPerPage + $key + 1);
		$clsVideoStore->updateByCond("video_id='$val' and _type='$type'","order_no='".$key."'");
	}
}
?>