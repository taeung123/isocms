<?php
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	
	$classTable = "HotelProperty";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	
	$cond = "1='1'";
	
	$cond2 = $cond;
	if($type_list=='Active'){
		$cond .= " and is_trash=0";
	}
	if($type_list=='Trash'){
		$cond .= " and is_trash=1";
	}
	$orderBy = " order_no desc";
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 1000000;
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
	
	
	
	//Action
	$action = isset($_GET['action'])?$_GET['action']:'';
	if($action == 'Trash'){
		$string = isset($_GET['hotel_property_id'])? ($_GET['hotel_property_id']) : '';
		$hotel_property_id = intval($core->decryptID($string));
		$pUrl = '';
		if($string=='' && $hotel_property_id==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.$pUrl.'&message=NotPermission');
			exit();
		}
		if($clsClassTable->updateOne($hotel_property_id,"is_trash='1'")){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.$pUrl.'&message=TrashSuccess');
		}	
	}
	if($action =='Restore'){
		$string = isset($_GET['hotel_property_id'])? ($_GET['hotel_property_id']) : '';
		$hotel_property_id = intval($core->decryptID($string));
		$pUrl = '';
		if($string=='' && $hotel_property_id==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.$pUrl.'&message=NotPermission');
			exit();
		}
		if($clsClassTable->updateOne($hotel_property_id,"is_trash='0'")){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.$pUrl.'&message=RestoreSuccess');
		}	
	}
	if($action=='Delete'){
		$string = isset($_GET['hotel_property_id'])? ($_GET['hotel_property_id']) : '';
		$hotel_property_id = intval($core->decryptID($string));
		$pUrl = '';
		if($string=='' && $hotel_property_id==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.$pUrl.'&message=NotPermission');
			exit();
		}
		if($clsClassTable->deleteOne($hotel_property_id)){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.$pUrl.'&message=DeleteSuccess');
		}
	}
	if($action == 'move'){
		$string = isset($_GET['parent_id'])? $_GET['parent_id'] : '';
		$parent_id = intval($core->decryptID($string));
		$string = isset($_GET['hotel_property_id'])? ($_GET['hotel_property_id']) : '';
		$pvalTable = intval($core->decryptID($string));
		$direct = isset($_GET['direct'])?$_GET['direct']:'';
		
		$one = $clsClassTable->getOne($pvalTable);
		$order_no = $one['order_no'];
		if(($string!='' && $pvalTable == 0) || $direct==''){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		
		$where = "1='1' and parent_id = '$parent_id' and is_trash=0";
		$pUrl = '&act=default';
		#
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
	#-------End Page Divide-----------------------------------------------------------
	$allItem = $clsClassTable->getAll($cond." order by ".$orderBy.$limit);//print_r($cond." order by ".$orderBy.$limit);die();
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
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Why";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$pvalTable = isset($_GET[$pkeyTable])? $_GET[$pkeyTable] : "";

	if($pvalTable == "")
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=notPermission');
	if($_POST['agree']=='agree'){
		if($clsClassTable->deleteOne($pvalTable)){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&message=DeleteSuccess');
		}
	}
}
function default_trash(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "HotelProperty";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$string = isset($_GET[$pkeyTable])? $_GET[$pkeyTable] : "";
	$pvalTable = intval($core->decryptID($string));
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$pUrl = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!= $pkeyTable && $tmp[0] != 'act')
			$pUrl .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	#
	if($pvalTable == ""){
		header('location: '.PCMS_URL.'/index.php'.$pUrl.'&message=notPermission');
	}
	if($clsClassTable->updateOne($pvalTable,"is_trash='1'")){
		header('location: '.PCMS_URL.'/index.php'.$pUrl.'&message=TrashSuccess');
	}
}
function default_restore(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "Tour";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	
	$string = isset($_GET[$pkeyTable])? $_GET[$pkeyTable] : "";
	$pvalTable = intval($core->decryptID($string));
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$pUrl = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!= $pkeyTable && $tmp[0] != 'act')
			$pUrl .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	if($pvalTable == ""){
		header('location: '.PCMS_URL.'/index.php'.$pUrl.'&message=notPermission');
	}
	if($clsClassTable->updateOne($pvalTable,"is_trash='0'")){
		header('location: '.PCMS_URL.'/index.php'.$pUrl.'&message=RestoreSuccess');
	}
}
function default_ajMoveHotelProperty(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];

	$classTable = "HotelProperty";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_POST[$pkeyTable])? $_POST[$pkeyTable] : "";
	$direct = isset($_POST['direct'])? $_POST['direct']:'';
	
	$one = $clsClassTable->getOne($pvalTable);
	$parent_id = $one['parent_id'];
	$order_no = $one['order_no'];
	
	if($direct=='moveup'){
		$lst = $clsClassTable->getAll("parent_id='$parent_id' and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	
	if($direct=='movedown'){
		$lst = $clsClassTable->getAll("parent_id='$parent_id' and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	
	if($direct=='movetop'){
		$lst = $clsClassTable->getAll("parent_id='$parent_id' and order_no < $order_no order by order_no desc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$clsClassTable->updateOne($lst[count($lst)-1][$clsClassTable->pkey],"order_no='".$order_no."'");
		
	}
	if($direct=='movebottom'){
		$lst = $clsClassTable->getAll("parent_id='$parent_id' and order_no > $order_no order by order_no asc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$clsClassTable->updateOne($lst[count($lst)-1][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	echo(1); die();
}
function default_ajLoadFormAddHotelProperty(){
	global $core, $_LANG_ID;
	#
	$clsHotelProperty = new HotelProperty();
	$parent_id = $_POST['parent_id'];
	$type = $_POST['type'];
	$html = '
		<div class="headPop">
			<a href="javascript:void();" title="Đóng" class="closeEv close_pop">&nbsp;</a>
			<h3>'.$core->get_Lang('Add New').' '.$clsHotelProperty->getTextByType($type).'</h3> 
		</div>
		<table class="form" cellpadding="3" cellspacing="3">
			<tr>
				<td class="fieldarea">
					<input placeholder="Nhập tiêu đề vào đây" type="text" name="title" id="title" class="required fontLarge full text">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<select class="slb" id="type">
						'.$clsHotelProperty->getSelectByType($type).'
					</select>
				</td>
			</tr>
		</table>
		<div class="modal-footer"> 
			<button class="btn btn-primary submitClick" id="clickSubmitHotelProperty" HotelProperty_id="0">'.$core->get_Lang('Submit').'</button> 
			<button class="btn btn-warning clickToClose" data-dismiss="modal" aria-hidden="true">'.$core->get_Lang('Close').'</button> 
		</div>';
	echo($html);die();
}
function default_ajLoadFormEditHotelProperty(){
	global $core, $_LANG_ID;
	#
	$clsHotelProperty =new HotelProperty();
	$HotelProperty_id = $_POST['HotelProperty_id'];
	$type = $_POST['type'];
	$oneItem = $clsHotelProperty->getOne($HotelProperty_id);
	#
	$html = '
	<div class="headPop">
		<a href="javascript:void();" title="Đóng" class="closeEv close_pop">&nbsp;</a>
		<h3 id="myModalLabel">'.$core->get_Lang('Edit').' '.$clsHotelProperty->getTextByType($type).'</h3> 
	</div>
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea">
				<input type="text" id="title" name="title" value="'.$clsHotelProperty->getTitle($HotelProperty_id).'" class="fontLarge full text">
			</td>
		</tr>
		<tr>
			<td class="fieldarea">
				<select class="slb" id="type">
					'.$clsHotelProperty->getSelectByType($clsHotelProperty->getOneField('type',$HotelProperty_id)).'
				</select>
			</td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button class="btn btn-primary submitClick" id="clickSubmitHotelProperty" HotelProperty_id="'.$HotelProperty_id.'">
			'.$core->get_Lang('Submit').'
		</button> 
		<button class="btn btn-warning clickToClose" data-dismiss="modal" aria-hidden="true">'.$core->get_Lang('Close').'</button> 
	</div>';
	echo($html);die();
}
function default_ajDeleteHotelProperty(){
	global $core,$_LANG_ID;
	$user_id = $core->_USER['user_id'];
	#
	$clsHotelProperty = new HotelProperty();
	$HotelProperty_id = $_POST['HotelProperty_id'];
	$clsHotelProperty->deleteOne($HotelProperty_id);
	echo(1); die();
}
function default_ajSubmitHotelProperty(){
	global $core,$_LANG_ID;
	$user_id = $core->_USER['user_id'];
	#
	$slug = 'slug_'.$_LANG_ID;
	$title = 'title_'.$_LANG_ID;
	
	$clsHotelProperty = new HotelProperty();
	$HotelProperty_id = isset($_POST['HotelProperty_id'])?$_POST['HotelProperty_id']:0;
	$titlePost = addslashes($_POST['title']);
	$slugPost = $core->replaceSpace($titlePost);
	$type = $_POST['type'];
	#
	if(intval($HotelProperty_id)==0){
		$res = $clsHotelProperty->getAll("$slug='$slugPost' and type='$type' limit 0,1");
		if(!empty($res)){
			echo('EXIST'); die();
		}else{
			$f="$title,$slug,order_no,type";
			$v="'$titlePost','$slugPost','".$clsHotelProperty->getMaxOrderNo()."','$type'";
			if($clsHotelProperty->insertOne($f,$v)){
				echo('IN_SUCCESS'); die();
			}else{
				echo('ERROR'); die();
			}
		}
	}else{
		$set = "$title='$titlePost',$slug='$slugPost'";
		if($clsHotelProperty->updateOne($HotelProperty_id,$set)){
			echo('UP_SUCCESS'); die();
		}else{
			echo('ERROR'); die();
		}
	}
}
function default_move(){
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
		$lst = $clsClassTable->getAll("1=1 and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movedown'){
		$lst = $clsClassTable->getAll("1=1 and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movetop'){
		$lst = $clsClassTable->getAll("1=1 and order_no > $order_no order by order_no asc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$lstItem = $clsClassTable->getAll($where." and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
		for($i=0;$i<count($lstItem);$i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey],"order_no='".($lstItem[$i]['order_no']-1)."'");	
		}
	}
	if($direct=='movebottom'){
		$lst = $clsClassTable->getAll("1=1 and order_no < $order_no order by order_no desc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$lstItem = $clsClassTable->getAll($where." and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no desc");
		for($i=0;$i<count($lstItem);$i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey],"order_no='".($lstItem[$i]['order_no']+1)."'");	
		}
	}
	header('location: '.PCMS_URL.'/?mod='.$mod.'&type='.$type.'&message=PositionSuccess');
}
/* Popup */
function default_ajGetBoxManagerHotelProperty(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsHotelProperty = new HotelProperty();
	$type = $_POST['type'];
	$fromid = $_POST['fromid'];
	$forid = $_POST['forid'];
	
	$html = '';
	$html.='
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="Đóng"></a>
		<h3>Quản lý - '.$type.'</h3>
	</div>';
	
	$html.='<div class="contentPop" style="height:355px">';
	$html.='<table class="tbl-grid">';
	$html.='<thead>
				<tr>
					<td class="gridheader"><strong>No.</strong></td>
					<td class="gridheader"><strong>Tiêu đề</strong></td>
					<td width="3%" class="gridheader"><i class="icon-pencil"></i></td>
					<td width="3%" class="gridheader"><i class="icon-remove"></i></td>
				</tr>
			</thead>';
	$html.='<tbody id="tblHolderHotelPropertyPop">';
	
	$lstItem = $clsHotelProperty->getAll("is_trash=0 and type='$type' order by order_no DESC", $clsHotelProperty->pkey);
	if(!empty($lstItem)){
		$i=0;
		foreach($lstItem as $item){
			$html.='<tr class="'.($i%2==0?'row1':'row2').'">';
			$html.='<td class="index">'.($i+1).'</td>';
			
			$html.='<td><a class="edit_pop_HotelProperty" _type="'.$type.'" title="Sửa" data="'.$item[$clsHotelProperty->pkey].'" fromid="'.$fromid.'" forid="'.$forid.'" href="javascript:;"><strong style="font-size:14px">'.$clsHotelProperty->getTitle($item[$clsHotelProperty->pkey]).'</strong></a></td>';
			
			$html.='<td style="text-align:center"><a href="javascript:void();" class="edit_pop_HotelProperty" _type="'.$type.'" fromid="'.$fromid.'"  forid="'.$forid.'" title="Sửa" data="'.$item[$clsHotelProperty->pkey].'"><i class="icon-pencil"></i></a></td>';
			
			$html.='<td style="text-align:center"><a href="javascript:void();" class="delete_pop_HotelProperty" _type="'.$type.'" fromid="'.$fromid.'" forid="'.$forid.'" title="Xóa" data="'.$item[$clsHotelProperty->pkey].'"><i class="icon-remove"></i></a></td>';
			
			$html.='</tr>';
			++$i;
		}
	}
	$html.='</tbody>';
	$html.='</table>';	
	$html.='</div>';
	$html.='
	<div class="bottom" unselectable="on" style="-moz-user-select: none;">
		<a parent_id="59" type="'.$type.'" fromid="'.$fromid.'" forid="'.$forid.'" id="btnCreateNewHotelProperty" class="iso-button-primary fr">
			<i class="icon-plus-sign"></i> Thêm nhanh
		</a>
	</div>';
	echo $html; die();
}
function default_ajaxLoadTableHotelProperty(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsHotelProperty = new HotelProperty();
	$type = $_POST['type'];
	$fromid = $_POST['fromid'];
	$forid = $_POST['forid'];
	
	$lstItem = $clsHotelProperty->getAll("is_trash=0 and type='$type' order by order_no DESC", $clsHotelProperty->pkey);
	$Html = '';
	
	if(is_array($lstItem) && count($lstItem)>0){
		for($i=0; $i<count($lstItem); $i++){
			
			$Html.='<tr class="'.($i%2==0?'row1':'row2').'">';
			$Html.='<td class="index">'.($i+1).'</td>';
			
			$Html.='<td><a class="edit_pop_HotelProperty" _type="'.$type.'" title="Sửa" data="'.$lstItem[$i][$clsHotelProperty->pkey].'" fromid="'.$fromid.'" forid="'.$forid.'" href="javascript:;"><strong style="font-size:14px">'.$clsHotelProperty->getTitle($lstItem[$i][$clsHotelProperty->pkey]).'</strong></a></td>';
			
			$Html.='<td style="text-align:center"><a href="javascript:void();" class="edit_pop_HotelProperty" _type="'.$type.'" fromid="'.$fromid.'"  forid="'.$forid.'" title="Sửa" data="'.$lstItem[$i][$clsHotelProperty->pkey].'"><i class="icon-pencil"></i></a></td>';
			
			$Html.='<td style="text-align:center"><a href="javascript:void();" class="delete_pop_HotelProperty" _type="'.$type.'" fromid="'.$fromid.'" forid="'.$forid.'" title="Xóa" data="'.$lstItem[$i][$clsHotelProperty->pkey].'"><i class="icon-remove"></i></a></td>';
			
			$Html.='</tr>';
		}
	}
	echo $Html; die();
}
function default_ajaxFrmHotelProperty(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $oneCommon;
	$user_id = $core->_USER['user_id'];
	#
	$clsHotelProperty = new HotelProperty();
	$HotelProperty_id = isset($_POST['HotelProperty_id'])?$_POST['HotelProperty_id']:0;
	$fromid = $_POST['fromid'];
	$forid = $_POST['forid'];
	#
	if(intval($HotelProperty_id)==0){
		$type = $_POST['type'];
	}else{
		$oneTable = $clsHotelProperty->getOne($HotelProperty_id);
		$type = $oneTable['type'];
	}
	#
	$html = '';
	$html.='
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="Đóng"></a>
		<h3>'.(intval($HotelProperty_id)==0?'Thêm mới - '.$type:'Cập nhật - '.$clsHotelProperty->getTitle($HotelProperty_id)).'</h3>
	</div>';
	$html.='
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea">
				<input type="text" placeholder="Nhập tiêu đề" name="title" class="text full required fontLarge" value="'.$clsHotelProperty->getTitle($HotelProperty_id).'" style="width:95%">
			</td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button type="button" class="btn btn-primary submitClick" _type="'.$type.'" HotelProperty_id="'.$HotelProperty_id.'" fromid="'.$fromid.'" forid="'.$forid.'" id="ajaxSaveHotelProperty">Lưu lại</button>
	</div>';
	echo $html; die();
}
function default_SiteHotelProperty(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	
	$clsHotelProperty = new HotelProperty();
	$hotel_property_id = isset($_POST['hotel_property_id'])? intval($_POST['hotel_property_id']):'';
	
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	#
	if($tp=='F'){
		$html='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($hotel_property_id==0?$core->get_Lang('add'):$core->get_Lang('edit')).' '.$core->get_Lang('Hotel Property').'</h3>
		</div>';
		$html .= '
		<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="fl" style="width:100%">
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><b class="color_r">* '.$core->get_Lang('title').'</b></div>
						<div class="fieldarea">
							<input style="border:2px solid #ccc; padding:6px 10px;" autocomplete="off" class="text full required fontLarge" name="title" value="'.$clsHotelProperty->getTitle($hotel_property_id).'" type="text" />
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="button" hotel_property_id="'.$hotel_property_id.'" class="btn btn-primary btnClickToSubmitHotelProperty">
				<i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span> 
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span>
			</button>		
		</div>';
		echo($html);die();
	} else if($tp=='S'){
		#
		$titlePost = trim(strip_tags($_POST['title']));
		$slugPost = $core->replaceSpace($titlePost);
		#
		if($hotel_property_id==0){
			$all = $clsHotelProperty->getAll("is_trash=0 and slug like '%".$slugPost."' limit 0,1");
			if(!empty($all)){
				echo '_EXIST'; die();
			}else{
				$fx = "title,slug,type,order_no";
				$vx = "'$titlePost','$slugPost','HotelFacilities'";
				$vx.= ",'".$clsHotelProperty->getMaxOrderNo()."'";
				
				#
				if($clsHotelProperty->insertOne($fx,$vx)){
					echo '_SUCCESS'; die();	
				}else{
					echo '_ERROR'; die();
				}
			}
		}else{
			$v = "title='$titlePost',slug='$slugPost'";

			if($clsHotelProperty->updateOne($hotel_property_id,$v)){
				echo '_SUCCESS'; die();	
			}else{
				echo '_ERROR'; die();
			}
		}
	}
}
?>