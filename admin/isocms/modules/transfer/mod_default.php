<?php
function default_SiteTourProperty(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsISO;
	#
	$clsTourProperty = new TourProperty();
	$tour_property_id = isset($_POST['tour_property_id']) ? intval($_POST['tour_property_id']) : 0;
	$type = $_POST['type'];
	$tp = isset($_POST['tp']) ? $_POST['tp']: '';
	
	if($tp=='F'){
		$html = '
		<div class="headPop"> 
			<a id="clickToCloseNewTourPriceRow" href="javascript:void();" class="closeEv close_pop"></a> 
			<h3>'.($tour_property_id==0?$core->get_Lang('add'):$core->get_Lang('add')).' '.$core->get_Lang('tourproperty').'</h3> 
		</div> 
		<div class="row-span">
			<input type="text" name="title" class="text full fontLarge required" value="'.$clsTourProperty->getTitle($tour_property_id).'">
		</div>
		<div class="modal-footer"> 
			<button class="btn btn-success submitClick SiteClickSaveTourProperty" type="'.$type.'" tour_property_id="'.$tour_property_id.'">
				<i class="icon-white icon-ok"></i> '.$core->get_Lang('save').'
			</button> 
		</div>';
		echo($html);die();
	}
	elseif($tp=='S'){
		$titlePost = $_POST['title'];
		$slugPost = $core->replaceSpace($titlePost);
		if($tour_property_id==0){
			if($clsTourProperty->countItem("type='$type' and slug='$slugPost'") > 0){
				echo '_EXIST'; die();
			}else{
				$fx = "title,slug,type,order_no";
				$vx = "'$titlePost','$slugPost','$type','".$clsTourProperty->getMaxOrderNo()."'";
				if($clsTourProperty->insertOne($fx, $vx)){
					echo '_SUCCESS'; die();
				}else{
					echo '_ERROR'; die();
				}
			}
		}else{
			$vx = "title='$titlePost',slug='$slugPost'";
			if($clsTourProperty->updateOne($tour_property_id, $vx)){
				echo '_SUCCESS'; die();
			}else{
				echo '_ERROR'; die();
			}
		}
	}
	elseif($tp=='M'){
		
	}
	elseif($tp=='D'){
		$clsTourProperty->deleteOne($tour_property_id);
		echo(1); die();
	}
	else{
		echo(1); die();
	}
}

/* QUICK CREATE NEW TOUR */
function default_ajaxCreateQuickTour(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#
	$clsTourService = new TourCategory();
	$clsTour = new Tour();
	$tour_group_id = isset($_POST['tour_group_id'])?intval($_POST['tour_group_id']):0;
	$tour_type_id = isset($_POST['tour_type_id'])?intval($_POST['tour_type_id']):0;
	$cat_id = isset($_POST['cat_id'])?intval($_POST['cat_id']):0;
	$tp = isset($_POST['tp']) ? $_POST['tp']: '';
	#
	if($tp=='F'){
		$html = '';
		$html='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.$core->get_Lang('addtours').'</h3>
		</div>';
		
		$html .= '
		<form method="post" action="" id="frmCrxTour">
			<div class="wrap">
				<div class="fl span100">
					<div class="row-span">
						<strong>'.$core->get_Lang('step').' 1: '.$core->get_Lang('enternametours').'</strong><br><br>
						<em style="color:#999;">'.$core->get_Lang('stepnametours').'</em> <br /><br />
						<input type="hidden" name="tour_type_id" value="1">
						';
					if($clsConfiguration->getValue("SiteHasGroup_Tours")){
						$clsTourGroup = new TourGroup();
						$html.='
						<div class="row-span">
							<div class="fieldlabel">'.$core->get_Lang('tourgroup').'</div>
							<div class="fieldarea">
								<select id="slb_TourGroupID" name="tour_group_id" tp="ajax" class="slbHighlight" style="width:160px;">
									'.$clsTourGroup->makeSelectboxOption($tour_group_id).'
								</select>
							</div>
						</div>';
					}
					if($clsConfiguration->getValue('SiteHasCat_Tours')) {
						$html.='
						<div class="row-span">
							<div class="fieldlabel">'.$core->get_Lang('tourcategory').'</div>
							<div class="fieldarea">
								<select id="slb_CategoryID" name="cat_id" class="slbHighlight" style="width:160px;">
									'.$clsTourService->makeSelectboxOption($tour_group_id,$cat_id).'
								</select>
							</div>
						</div>';
					}
					$html.='
						<div class="clearfix" style="margin-bottom:10px"></div>
						<input type="text" autocomplete="off" name="title" class="text full required fontLarge title_capitalize" id="NewTourTitle" placeholder="'.$core->get_Lang('ex').': '.$clsISO->getExName('Tour').'" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" tour_id="0" class="btn btn-primary clickToSubmitNewTour">
					<i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('nextstep').'</span>
				</button>
				<input type="hidden" name="tp" value="S" />
			</div>
		</form>';
		#
		echo($html); die();
	}elseif($tp=='S'){
		$titlePost = isset($_POST['title'])?trim(addslashes($_POST['title'])):'';
		$slugPost = $core->replaceSpace($titlePost);
		
		if($clsTour->countItem("slug='$slugPost'") > 0){
			echo '_EXIST'; die();
		} else {
			$listTour=$clsTour->getAll("1=1", $clsTour->pkey.",order_no");
			for ($i = 0; $i <= count($listTour); $i++) {
				$order_no=$listTour[$i]['order_no'] + 1;
				$clsTour->updateOne($listTour[$i]['tour_id'],"order_no='".$order_no."'");
			}
			$max_id = $clsTour->getMaxID();
			$fx = "$clsTour->pkey,tour_group_id,tour_type_id,title,slug,user_id,user_id_update,reg_date,upd_date,is_online,order_no";
			$vx = "'".$max_id."','$tour_group_id','$tour_type_id','".ucwords(addslashes($titlePost))."','$slugPost','".$core->_USER['user_id']."','".$core->_USER['user_id']."','".time()."','".time()."','0','1'";
			if(intval($cat_id) > 0){
				$fx .= ",cat_id,list_cat_id";
				$vx .= ",'$cat_id','|$cat_id|'";
			}
			if($clsTour->insertOne($fx, $vx)){
				echo(PCMS_URL.'/index.php?mod='.$mod.'&act=edit&'.$clsTour->pkey.'='.$core->encryptID($max_id));die();
			}else{
				echo '_ERROR'; die();
			}
		}
	}
}

/* START_TOUR_CUSTOM_FIELD_MOD */
function default_SiteTourCustomField(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	
	$clsTourCustomField = new TourCustomField();
	$tour_customfield_id = isset($_POST['tour_customfield_id']) ? intval($_POST['tour_customfield_id']) : 0;
	$tp = isset($_POST['tp']) ? $_POST['tp']: '';
	$tour_id = $_POST['tour_id'];
	#
	if($tp=='C'){
		$idx = $clsTourCustomField->countItem("fieldtype='CUSTOM' and tour_id='$tour_id'");
		$title = 'Custom_Field_'.($idx+1);
		$slug = 'custom_field_'.($idx+1);
		$fx = "fieldname,fieldname_slug,fieldtype,tour_id,order_no,reg_date,upd_date";
		$vx = "'$title','$slug','CUSTOM','$tour_id','".$clsTourCustomField->getMaxOrderNo()."','".time()."','".time()."'";
		if($clsTourCustomField->insertOne($fx, $vx)){
			echo('_SUCCESS'); die();
		}else{
			echo('_ERROR'); die();
		}
	}
	else if($tp=='L'){
		$listCustomField = $clsTourCustomField->getAll("fieldtype='CUSTOM' and tour_id='$tour_id' order by order_no ASC");
		$html = '';
		if(is_array($listCustomField) && count($listCustomField) > 0){
			$html .= '
			<style type="text/css">
				
			</style>
			';
			for($i=0; $i< count($listCustomField); $i++){
				$html .= '
				<div class="row-span row-has-border">
					<div class="fieldlabel text-right">
						<strong>'.$listCustomField[$i]['fieldname'].'</strong>
						<div class="Site_Custom_Field_Tools">
							<a title="'.$core->get_Lang('edit').'" tour_id="'.$tour_id.'" data="'.$listCustomField[$i][$clsTourCustomField->pkey].'" class="btnedit_customfield" href="javascript:void();"><i class="icon-pencil"></i></a>
							<a title="'.$core->get_Lang('delete').'" tour_id="'.$tour_id.'" data="'.$listCustomField[$i][$clsTourCustomField->pkey].'" class="btndelete_customfield" href="javascript:void();"><i class="icon-remove"></i></a>
							'.($i==0?'':'<a title="'.$core->get_Lang('move').'" tour_id="'.$tour_id.'" data="'.$listCustomField[$i][$clsTourCustomField->pkey].'" class="btnmove_customfield" direct="up" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>').'
							'.($i==(count($listCustomField)-1)?'':'<a title="'.$core->get_Lang('move').'" tour_id="'.$tour_id.'" data="'.$listCustomField[$i][$clsTourCustomField->pkey].'" class="btnmove_customfield" direct="down" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>').'
						</div>
					</div>
					<div class="fieldarea">
						<textarea style="width:100%" cols="255" rows="5" class="Site_Custom_Field_Editor" id="Site_Custom_Field_'.$listCustomField[$i][$clsTourCustomField->pkey].'_'.time().'" name="Site_Custom_Field_value_'.$listCustomField[$i][$clsTourCustomField->pkey].'">'.$listCustomField[$i]['fieldvalue'].'</textarea>
					</div>
				</div>';
			}
		}
		echo $html; die();
	}
	else if($tp=='D'){
		$clsTourCustomField->deleteOne($tour_customfield_id);
		echo(1); die();
	}
	else if($tp=='F'){
		$html = '
		<div class="headPop"> 
			<a id="clickToCloseNewTourPriceRow" href="javascript:void();" class="closeEv close_pop"></a> 
			<h3>'.$core->get_Lang('Edit').': '.$clsTourCustomField->getOneField('fieldname',$tour_customfield_id).'</h3> 
		</div> 
		<div class="modal-body">
			<table class="form formPopup" cellpadding="3" cellspacing="3">
				<tr>
					<td class="fieldarea">
						<input type="text" name="fieldname" class="text_32 border_aaa full-width fontLarge required" style="width:95%" value="'.$clsTourCustomField->getOneField('fieldname',$tour_customfield_id).'">
					</td>
				</tr>
			</table>
		</div>
		<div class="modal-footer"> 
			<button class="btn btn-success submitClick SiteClickUpdateFieldName" tour_id="'.$tour_id.'" tour_customfield_id="'.$tour_customfield_id.'">'.$core->get_Lang('save').'</button> 
		</div>';
		echo($html);die();
	}
	else if($tp=='S'){
		$fieldname = $_POST['fieldname'];
		$fieldnameSlug = $core->replaceSpace($fieldname);
		if($clsTourCustomField->countItem("fieldtype='CUSTOM' and tour_id='$tour_id' and BINARY fieldname='$fieldname'") > 0){
			echo '_EXIST'; die();
		}else{
			$clsTourCustomField->updateOne($tour_customfield_id,"fieldname='$fieldname',fieldname_slug='$fieldnameSlug'");
			echo(1); die();
		}
	}
	else if($tp=='M'){
		$direct = isset($_POST['direct']) ? intval($_POST['direct']) : '';
		$order_no = $clsTourCustomField->getOneField('order_no',$tour_customfield_id);
		$where = "is_trash=0";
		$where.= " and tour_id='$tour_id'";
		
		if($direct=='up'){
			$lst = $clsTourCustomField->getAll($where." and order_no < $order_no order by order_no desc limit 0,1");
			$clsTourCustomField->updateOne($tour_customfield_id,"order_no='".$lst[0]['order_no']."'");
			$clsTourCustomField->updateOne($lst[0][$clsTourCustomField->pkey],"order_no='$order_no'");
		}
		if($direct=='down'){
			$lst = $clsTourCustomField->getAll($where." and order_no > $order_no order by order_no asc limit 0,1");
			$clsTourCustomField->updateOne($tour_customfield_id,"order_no='".$lst[0]['order_no']."'");
			$clsTourCustomField->updateOne($lst[0][$clsTourCustomField->pkey],"order_no='$order_no'");
		}
		echo(1); die();
	}
}
/* END_TOUR_CUSTOM_FIELD_MOD */

/*------ START_TOUR_ITINERARY -------*/
function default_SiteFrmTourItinerary(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#
	$clsTour = new Tour();
	$clsTourItinerary = new TourItinerary();
	$clsTransport = new Transport();
	$clsCountry = new Country();
	$clsCity = new City();
	$clsRegion = new Region();
	$assign_list["clsTransport"] = $clsTransport;
	$tour_itinerary_id = isset($_POST['tour_itinerary_id']) ? intval($_POST['tour_itinerary_id']):0;
	$tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']):0;
	if(intval($tour_itinerary_id) > 0) {
		$oneItem = $clsTourItinerary->getOne($tour_itinerary_id);
		$overnight=unserialize($oneItem['overnight']);
		
	}
	$tp = isset($_POST['tp'])?$_POST['tp']:'';
	

	if($tp == 'L') {
		$number_day=$clsTour->getOneField('number_day',$tour_id);
		$number_night=$clsTour->getOneField('number_night',$tour_id);
		if($number_day>$number_night){
			$limit=$number_day;
		}else{
			$limit=$number_night;
		}
		if($clsTour->getOneField('duration_type',$tour_id) == 0){
			$lstItem = $clsTourItinerary->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc limit 0,$limit", $clsTourItinerary->pkey.',day,day2,reg_date');
		}else{
			$lstItem = $clsTourItinerary->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc", $clsTourItinerary->pkey.',day,day2,reg_date');
		}
		$html='';
		//$clsISO->print_pre($lstItem,true);
		//die();
		if(!empty($lstItem)){
			for($i=0, $max=count($lstItem); $i<$max; $i++){
				$html.='<tr style="cursor:move" id="order_'.$lstItem[$i][$clsTourItinerary->pkey].'" day2="'.$lstItem[$i]['day2'].'" class="'.($i%2==0?'row1':'row2').'">';
				if($clsTour->getOneField('duration_type',$tour_id) == 0){
					if($clsTour->getOneField('number_day',$tour_id) == 1 && $clsTour->getOneField('number_night',$tour_id) <= 1){
						$html.='<td class="day">'.$core->get_Lang('Full day').'</td>';
					}else{
						$html.='<td class="day">'.$lstItem[$i]['day'].''.($lstItem[$i]['day2']>$lstItem[$i]['day']? '-'.$lstItem[$i]['day2']:'').'</td>';
					}
					
				}
				$html.='<td>
					<strong style="font-size:15px;">'.$clsTourItinerary->getTitle($lstItem[$i][$clsTourItinerary->pkey]).'</strong>
					<div class="clearfix mt5"></div>
					'.($clsConfiguration->getValue('SiteHasHotel_Tours') && $clsTourItinerary->getItineraryHotel($tour_id, $lstItem[$i][$clsTourItinerary->pkey],1) ? '<strong class="color_r">'.$core->get_Lang('hotels').'</strong>: '.$clsTourItinerary->getItineraryHotel($tour_id, $lstItem[$i][$clsTourItinerary->pkey]).'':'').'
				</td>';
				$html.='<td class="text-right">'.strtoupper($clsTourItinerary->getMeal($lstItem[$i][$clsTourItinerary->pkey],1)).'</td>';
				$html.='
				<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a class="clickEditItinerary" title="'.$core->get_Lang('edit').'" href="javascript:void();" data="'.$lstItem[$i][$clsTourItinerary->pkey].'"><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
							<li><a class="clickDeleteItinerary" title="'.$core->get_Lang('delete').'" href="javascript:void();" data="'.$lstItem[$i][$clsTourItinerary->pkey].'"><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
						</ul>
					</div>
				</td>';
			}
		} else {
			$html.= '<tr><td colspan="12">
				<div class="message" style="text-align:center">'.$core->get_Lang('no record found in here, please use').' <a style="text-decoration:underline" href="javascript:void(0);" id="clickToAddItinerary">'.$core->get_Lang('Add New').'</a></div>
			</td></tr>';
			
		}
		$html.='<script type="text/javascript">
			$("#tblTourItinerary").sortable({
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
					$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosTourItinerary", order, function(html){
						loadTourItinerary(tour_id);
						vietiso_loading(0);
					});
				}
			});
		</script>';
		echo $html; die();
	} elseif($tp == 'F') {
		$html = '';
		$html.='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($tour_itinerary_id==0?$core->get_Lang('Add Tour Itinerary'):$core->get_Lang('Edit Tour Itinerary')).'- [ID #'.$tour_id.']</h3>
		</div>';
		$html .= '
		<form method="post" id="frmItinerary" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="fr">
					<div class="photobox image">
						<img src="'.($tour_itinerary_id > 0?$clsTourItinerary->getOneField('image',$tour_itinerary_id):'').'" id="isoman_show_image_itinerary" />
						<input type="hidden" id="isoman_hidden_image_itinerary" name="isoman_url_image" value="'.($tour_itinerary_id > 0?$clsTourItinerary->getOneField('image',$tour_itinerary_id):'').'" />
						<a href="javascript:void(0);" title="'.$core->get_Lang('Change').'" class="photobox_edit ajOpenDialog" isoman_for_id="image_itinerary" isoman_val="'.($tour_itinerary_id > 0?$clsTourItinerary->getOneField('image',$tour_itinerary_id):'').'" isoman_name="image"><i class="iso-edit"></i></a>
						'.($clsTourItinerary->getOneField('image',$tour_itinerary_id) != '' ? '<a pvalTable="'.$tour_itinerary_id.'" clsTable="TourItinerary" href="javascript:void()" title="'.$core->get_Lang('delete').'" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>' : '') . '
					</div>
					<div class="wrap mt10 boxShowImages">
						<p class="text-center"><strong>'.$core->get_Lang('Image Size').' (WxH=204x134)</strong></p>
						<p class="text-center">
							<label>
								<input type="radio" class="margin_0" name="is_show_image" value="0" checked="checked" /> OFF
							</label>
							<label>
								<input type="radio" class="margin_0" name="is_show_image" value="1" '.($oneItem['is_show_image']==1?'checked="checked"':'').' /> ON
							</label>
						</p>
					</div>
				</div>
				<div class="fl" style="width:76%">
					<div class="row-span">';
						if($clsTour->getOneField('duration_type',$tour_id)==1){
						$html .= '<div class="fieldlabel bold text-right"><strong>'.$core->get_Lang('Itinerary name').'</strong> <span class="color_r">*</span></div>';
						}else{
						$html .= '<div class="fieldlabel bold text-right"><strong>'.$core->get_Lang('day').'</strong> <span class="color_r">*</span></div>';	
						}
						$html .= '<div class="fieldarea">';
							if($clsTour->getOneField('duration_type',$tour_id)==1){
								$html .= '<input type="text" name="title" class="text_32 border_aaa fontLarge full-width title_capitalize" id="title" value="'.$clsTourItinerary->getOneField('title',$tour_itinerary_id).'"  />';
							}else{
							$html .= '<input class="text_32 border_aaa required" style="width:60px;float:left" value="'.($tour_itinerary_id==0?$clsTourItinerary->getMaxDay($tour_id):$clsTourItinerary->getOneField('day',$tour_itinerary_id)).'" name="day" type="number" min="1" max="'.$clsTour->getOneField('number_day',$tour_id).'"><span style="width:20px; display:inline-block; text-align:center; float:left; line-height:32px"> -> </span>
							<input class="text_32 border_aaa required" style="width:60px;float:left" min="0" max="'.$clsTour->getOneField('number_day',$tour_id).'" value="'.($tour_itinerary_id==0?$clsTourItinerary->getMaxDay($tour_id):$clsTourItinerary->getOneField('day2',$tour_itinerary_id)).'" name="day2" type="number">
							<input type="text" name="title" class="text_32 border_aaa fontLarge titleDay title_capitalize" id="title" value="'.$clsTourItinerary->getOneField('title',$tour_itinerary_id).'"  />';
							}
						$html .= '</div>
					</div>
					<div class="row-span" style="display:none">
						<div class="fieldlabel bold text-right"><span class="color_r">*'.$core->get_Lang('daytrip').'</span></div>
						<div class="fieldarea"><input type="text" name="date_title" class="text full fontLarge " id="date_title" value="'.$clsTourItinerary->getOneField('date_title',$tour_itinerary_id).'" /></div>
					</div>
					<div class="row-span">
						<div class="fieldlabel bold text-right" style="text-align:right">
							<strong>'.$core->get_Lang('meal').'</strong> <span class="color_r">*</span> 
							<input type="checkbox" class="checkall_checkbox" group="meal" title="'.$core->get_Lang('selectall').'" style="cursor:pointer;" />
						</div>
						<div class="fieldarea">
							<div style="border:1px solid #d7d7d7;width:100%;padding:3px 10px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;">';
							$lstMeal = $clsTour->getListMeal();
							if(!empty($lstMeal)){
								foreach($lstMeal as $k=>$v){
									$html.='
									<label class="mr20">
										<input type="checkbox" name="meal[]" '.($tour_itinerary_id > 0 ? ($clsTourItinerary->checkMealExist($k,$tour_itinerary_id)?'checked="checked"':'') : '').' class="checkitem_checkbox chk_Meal" group="meal" value="'.$k.'"> '.$v.'
									</label>';
								}	
							}				
	$html.='				</div>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel bold text-right" style="text-align:right">
							<strong>'.$core->get_Lang('transport').'</strong> <span class="color_r">*</span> 
							<input type="checkbox" class="checkall_checkbox" group="transport" title="'.$core->get_Lang('selectall').'" style="cursor:pointer;" />
						</div>
						<div class="fieldarea">
							<div style="border:1px solid #d7d7d7;padding:3px 10px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px; max-height:56px; overflow:auto">';
							$lstItem = $clsTour->getListTransport();
							if(!empty($lstItem)){
								foreach ($lstItem as $k => $v) {
									$html.='
									<label class="mr20">
										<input type="checkbox" name="transport[]" '.($tour_itinerary_id > 0 ? ($clsTourItinerary->checkTransportExist($v[$clsTransport->pkey],$tour_itinerary_id)?'checked="checked"':'') : '').' class="checkitem_checkbox chk_Transport" group="transport" value="'.$v[$clsTransport->pkey].'"> '.$clsTransport->getTitle($v[$clsTransport->pkey]).'
									</label>';
								}	
							}	
							
	$html.='				</div>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right;font-weight:700">'.$core->get_Lang('Overnight').'</div>
						<div class="fieldarea">';
						$html.='<select class="fl slb mr5 country_id" id="countryitinerary" name="countryitinerary_id" style="width:160px">';
						$html.= $clsCountry->makeSelectboxOption($overnight['countryitinerary_id']);
						$html.='</select>';
						if($clsConfiguration->getValue('SiteActive_region')){
							if($overnight['regionitinerary_id'] > 0){
								$html.='<select class="fl slb mr5" id="regionitinerary" name="regionitinerary_id" style="width:160px;">';
							}else{
								$html.='<select class="fl slb mr5" id="regionitinerary" name="regionitinerary_id" style="width:160px; display:none">';
							}
							$html.=$clsRegion->makeSelectboxOption($overnight['countryitinerary_id'],$overnight['regionitinerary_id']);
							$html.='</select>';
						}
						if($overnight['cityitinerary_id'] > 0){
							$html.='<select class="fl slb mr5" id="cityitinerary" name="cityitinerary_id" style="width:160px;">';
						}else{
							$html.='<select class="fl slb mr5" id="cityitinerary" name="cityitinerary_id" style="width:160px;display:none">';
						}
						$html.=$clsCity->makeSelectboxOption($overnight['cityitinerary_id'],$overnight['countryitinerary_id'],$overnight['regionitinerary_id']);
						$html.='</select>';
						$html.='</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right;font-weight:700">'.$core->get_Lang('Short text').'</div>
						<div class="fieldarea">
							<textarea rows="5" cols="25" id="textarea_itinerary_intro_editor_'.time().'" class="textarea_itinerary_content_editor" style="width:100%">'.$clsTourItinerary->getIntro($tour_itinerary_id).'</textarea>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right;font-weight:700">'.$core->get_Lang('Long text').'</div>
						<div class="fieldarea">
							<textarea rows="5" cols="255" id="textarea_itinerary_content_editor_'.time().'" class="textarea_itinerary_intro_editor" style="width:100%">'.$clsTourItinerary->getContent($tour_itinerary_id).'</textarea>
						</div>
					</div>
					'.($tour_itinerary_id > 0 && $clsConfiguration->getValue('SiteHasHotel_Tours') ? '
					<div class="row-span" style="border:1px dashed #c00000; padding:1%; width:100%;">
						<div class="fieldlabel" style="font-weight:700">'.$core->get_Lang('Accommodation').' <button type="button" tour_id="'.$tour_id.'" tour_itinerary_id="'.$tour_itinerary_id.'" tour_hotel_id="0" class="iso-button-small ajaxOpenChoiceHotel">...</button></div>
						<div class="fieldarea"><div id="lstHotel"></div></div>
					</div>
					':'').'
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="submit" tour_itinerary_id="'.$tour_itinerary_id.'" class="btn btn-primary btnSaveTourItinerary">
				<i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span>
			</button>
		</div>';
		echo($html);die();
	} elseif($tp == 'S') {
		$dayPost = isset($_POST['day']) ? $_POST['day']:0;
		$dayPost2 = isset($_POST['day2']) ? $_POST['day2']:0;
		$titlePost = isset($_POST['title']) ? ucwords($_POST['title']):'';
		$slugPost = $core->replaceSpace($titlePost);
		$mealsPost = isset($_POST['meals'])?$_POST['meals']:'';
		$transportPost = isset($_POST['transport'])?$_POST['transport']:'';
		$transport_id = isset($_POST['transport_id'])?$_POST['transport_id']:0;
		$contentPost = isset($_POST['content']) ? $_POST['content']:'';
		$introPost = isset($_POST['intro']) ? $_POST['intro']:'';
		$imagePost = isset($_POST['image']) ? $_POST['image']:'';
		$dateTitlePost = isset($_POST['date_title']) ? $_POST['date_title']:'';
		$is_show_image = isset($_POST['is_show_image']) ? intval($_POST['is_show_image']): 0;
		$countryitinerary_id = isset($_POST['countryitinerary_id']) ? intval($_POST['countryitinerary_id']): 1;
		$regionitinerary_id = isset($_POST['regionitinerary_id']) ? intval($_POST['regionitinerary_id']): 0;
		$cityitinerary_id = isset($_POST['cityitinerary_id']) ? intval($_POST['cityitinerary_id']): 0;
		
		foreach($_POST as $k=>$v){
			$_POST[$k] = $v;
		}
		$overnight=serialize($_POST);
		
		#
		if($tour_itinerary_id > 0) {
			if($clsTourItinerary->countItem("tour_id='$tour_id' and day='$dayPost' and day2='$dayPost2' and tour_itinerary_id<>'$tour_itinerary_id'")>0){
				echo 'day_invalid'; die();	
			}
			$v = "user_id_update='$user_id',day='$dayPost',day2='$dayPost2',title='$titlePost',slug='$slugPost',intro='".addslashes($introPost)."',content='".addslashes($contentPost)."',transport='$transportPost',meals='$mealsPost',upd_date='".time()."',image='$imagePost',transport_id='$transport_id',date_title='$dateTitlePost',is_show_image='$is_show_image',overnight='$overnight'";
			#
			
			
			
			//print_r($tour_itinerary_id.'ccccc'.$v); die();
			if($clsTourItinerary->updateOne($tour_itinerary_id,$v)){
				echo '_UPDATE_SUCCESS'; die();
			}else{
				echo '_ERROR'; die();
			}	
		} else {
			if($clsTourItinerary->countItem("tour_id='$tour_id' and day='$dayPost'")>0){
				echo 'day_invalid'; die();	
			} else {
				$max_id = $clsTourItinerary->getMaxID();
				$fx ="$clsTourItinerary->pkey,user_id,user_id_update,day,tour_id,title,slug,intro,content,meals,transport";
				$fx.=",reg_date,upd_date,image,transport_id,order_no,date_title,is_show_image,overnight";
				$vx ="'".$max_id."','$user_id','$user_id','$dayPost','$tour_id','$titlePost','$slugPost','".addslashes($introPost)."','".addslashes($contentPost)."','$mealsPost','$transportPost','".time()."','".time()."','".addslashes($imagePost)."','$transport_id','".$clsTourItinerary->getMaxOrderNo()."','".$dateTitlePost."','".$is_show_image."','".$overnight."'";
				#
				if($clsTourItinerary->insertOne($fx,$vx)){
					echo '_INSERT_SUCCESS'; die();
				}else{
					echo '_ERROR'; die();
				}
			}
		}
	} elseif($tp == 'M') {
		$direct = isset($_POST['direct'])?$_POST['direct']:'';
		$one = $clsTourItinerary->getOne($tour_itinerary_id);
		$dayTour = $one['day'];
		
		$cond = 'is_trash=0 and tour_id='.$tour_id;
		if($direct=='moveup'){
			$lst = $clsTourItinerary->getAll($cond." and day < $dayTour order by day desc limit 0,1");
			$clsTourItinerary->updateOne($tour_itinerary_id,"day='".$lst[0]['day']."'");
			$clsTourItinerary->updateOne($lst[0][$clsTourItinerary->pkey],"day='".$dayTour."'");
		}
		if($direct=='movedown'){
			$lst = $clsTourItinerary->getAll($cond." and day > $dayTour order by day asc limit 0,1");
			$clsTourItinerary->updateOne($tour_itinerary_id,"day='".$lst[0]['day']."'");
			$clsTourItinerary->updateOne($lst[0][$clsTourItinerary->pkey],"day='".$dayTour."'");
		}
		if($direct=='movetop'){
			$lst = $clsTourItinerary->getAll($cond." and day < $dayTour order by day desc");
			$clsTourItinerary->updateOne($tour_itinerary_id,"day='".$lst[count($lst)-1]['day']."'");
			$lstItem = $clsTourItinerary->getAll($cond." and tour_itinerary_id <> '$tour_itinerary_id' and day < $dayTour order by day asc");
			for($i=0;$i<count($lstItem);$i++) {
				$clsTourItinerary->updateOne($lstItem[$i][$clsTourItinerary->pkey],"day='".($lstItem[$i]['day']+1)."'");	
			}
		}
		if($direct=='movebottom'){
			$lst = $clsTourItinerary->getAll($cond." and day > $dayTour order by day asc");
			$clsTourItinerary->updateOne($tour_itinerary_id,"day='".$lst[count($lst)-1]['day']."'");
			$lstItem = $clsTourItinerary->getAll($cond." and $tour_itinerary_id <> '$tour_itinerary_id' and day > $dayTour order by day asc");
			for($i=0;$i<count($lstItem);$i++) {
				$clsTourItinerary->updateOne($lstItem[$i][$clsTourItinerary->pkey],"day='".($lstItem[$i]['day']-1)."'");	
			}
		}
		echo(1); die();
	} elseif($tp == 'D') {
		$clsTourItinerary->doDelete($tour_itinerary_id);
		echo(1); die();
	}
}


function default_ajUpdPosTourItinerary(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTour = new Tour();
	$clsTourItinerary = new TourItinerary();
	$order = $_POST['order'];
	foreach($order as $key=>$val){
		$key = $key+1;
		$clsTourItinerary->updateOne($val,"order_no='".$key."'");	
	}
}



function default_SiteFrmTourItinerary11(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#
	$clsTour = new Tour();
	$clsTourItinerary = new TourItinerary();
	$tour_itinerary_id = isset($_POST['tour_itinerary_id']) ? intval($_POST['tour_itinerary_id']):0;
	$tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']):0;
	if(intval($tour_itinerary_id) > 0) {
		$oneItem = $clsTourItinerary->getOne($tour_itinerary_id);
	}
	$tp = isset($_POST['tp'])?$_POST['tp']:'';
	
	if($tp == 'L') {
		$html='';
		$lstItem = $clsTourItinerary->getAll("is_trash=0 and tour_id='$tour_id' order by day asc", $clsTourItinerary->pkey.',reg_date,day');
		if(is_array($lstItem) && count($lstItem) > 0){
			$max = count($lstItem);
			for($i=0; $i<$max; $i++){
				$html.='<tr class="'.($i%2==0?'row1':'row2').'">';
				$html.='<td class="index">'.$lstItem[$i]['day'].''.($lstItem[$i]['day2']>$lstItem[$i]['day']? '-'.$lstItem[$i]['day2']:'').'</td>';
				$html.='<td>
					<strong style="font-size:15px;">'.$clsTourItinerary->getTitle($lstItem[$i][$clsTourItinerary->pkey]).'</strong>
					<div class="clearfix mt5"></div>
					'.($clsConfiguration->getValue('SiteHasHotel_Tours') && $clsTourItinerary->getItineraryHotel($tour_id, $lstItem[$i][$clsTourItinerary->pkey],1) ? '<strong class="color_r">'.$core->get_Lang('hotels').'</strong>: '.$clsTourItinerary->getItineraryHotel($tour_id, $lstItem[$i][$clsTourItinerary->pkey]).'':'').'
				</td>';
				$html.='<td class="text-right">'.strtoupper($clsTourItinerary->getMeal($lstItem[$i][$clsTourItinerary->pkey],1)).'</td>';
				$html.='<td class="text-right">'.$clsISO->formatDateTime($lstItem[$i]['reg_date']).'</td>';
				$html.='
				<td style="vertical-align: middle;text-align:center">
					'.($i==0?'':'<a title="'.$core->get_Lang('movetop').'"  direct="movetop" class="moveTourItinerary" data="'.$lstItem[$i][$clsTourItinerary->pkey].'" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>').'
				</td>
				<td style="vertical-align: middle;text-align:center">
					'.($i==count($lstItem)-1?'':'<a title="'.$core->get_Lang('movebottom').'" class="moveTourItinerary" direct="movebottom" data="'.$lstItem[$i][$clsTourItinerary->pkey].'" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>').'
				</td>
				<td style="vertical-align: middle;text-align:center">
					'.($i==0?'':'<a title="'.$core->get_Lang('moveup').'" class="moveTourItinerary" direct="moveup" data="'.$lstItem[$i][$clsTourItinerary->pkey].'" href="javascript:void();"><i class="icon-arrow-up"></i></a>').'
				</td>
				<td style="vertical-align: middle;text-align:center">
					'.($i==count($lstItem)-1 ? '' : '<a title="'.$core->get_Lang('movedown').'" class="moveTourItinerary" direct="movedown" data="'.$lstItem[$i][$clsTourItinerary->pkey].'" href="javascript:void();"><i class="icon-arrow-down"></i></a>').'
				</td>';
				$html.='
				<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret" style="margin-top:-4px;"></span></button>
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a class="clickEditItinerary" title="'.$core->get_Lang('edit').'" href="javascript:void();" data="'.$lstItem[$i][$clsTourItinerary->pkey].'"><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
							<li><a class="clickDeleteItinerary" title="'.$core->get_Lang('delete').'" href="javascript:void();" data="'.$lstItem[$i][$clsTourItinerary->pkey].'"><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
						</ul>
					</div>
				</td>';
			}
		} else {
			$html.= '<tr><td colspan="12">
				<div class="message" style="text-align:center">'.$core->get_Lang('no record found in here, please use').' <a style="text-decoration:underline" href="javascript:void(0);" id="clickToAddItinerary">'.$core->get_Lang('Add New').'</a></div>
			</td></tr>';
		}
		echo $html; die();
	} elseif($tp == 'F') {
		$html = '';
		$html.='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($tour_itinerary_id==0?$core->get_Lang('Add Tour Itinerary'):$core->get_Lang('Edit Tour Itinerary')).'- [ID #'.$tour_id.']</h3>
		</div>';
		$html .= '
		<form method="post" id="frmItinerary" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="fr">
					<div class="photobox image" style="width:220px; height:160px">
						<img src="'.($tour_itinerary_id > 0?$clsTourItinerary->getOneField('image',$tour_itinerary_id):'').'" id="isoman_show_image_itinerary" style="width:220px;" />
						<input type="hidden" id="isoman_hidden_image_itinerary" name="isoman_url_image" value="'.($tour_itinerary_id > 0?$clsTourItinerary->getOneField('image',$tour_itinerary_id):'').'" />
						<a href="javascript:void(0);" title="'.$core->get_Lang('Change').'" class="photobox_edit ajOpenDialog" isoman_for_id="image_itinerary" isoman_val="'.($tour_itinerary_id > 0?$clsTourItinerary->getOneField('image',$tour_itinerary_id):'').'" isoman_name="image"><i class="iso-edit"></i></a>
						'.($clsTourItinerary->getOneField('image',$tour_itinerary_id) != '' ? '<a pvalTable="'.$tour_itinerary_id.'" clsTable="TourItinerary" href="javascript:void()" title="'.$core->get_Lang('delete').'" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>' : '') . '
					</div>
					<div class="wrap mt10 boxShowImages">
						Images &nbsp;&nbsp;(220 x 160)
						<label>
							<input type="radio" name="is_show_image" value="0" checked="checked" /> Off
						</label>
						<label>
							<input type="radio" name="is_show_image" value="1" '.($oneItem['is_show_image']==1?'checked="checked"':'').' /> On
						</label>
					</div>
				</div>
				<div class="fl" style="width:76%">
					<div class="row-span">
						<div class="fieldlabel bold text-right"><span class="color_r">*'.$core->get_Lang('day').'</span></div>
						<div class="fieldarea">
							<input class="text full required" style="width:50px;" value="'.($tour_itinerary_id==0?$clsTourItinerary->getMaxDay($tour_id):$clsTourItinerary->getOneField('day',$tour_itinerary_id)).'" name="day" type="number" min="1" max="'.$clsTour->getOneField('number_day',$tour_id).'"><span> -> </span>
							<input class="text full required" style="width:50px;" min="1" max="'.$clsTour->getOneField('number_day',$tour_id).'" value="'.($tour_itinerary_id==0?$clsTourItinerary->getMaxDay($tour_id):$clsTourItinerary->getOneField('day2',$tour_itinerary_id)).'" name="day2" type="number">
							<input type="text" name="date_title" class="text full fontLarge" style="width:80.5%" id="date_title" value="'.$clsTourItinerary->getOneField('date_title',$tour_itinerary_id).'"  />
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel bold text-right"><span class="color_r">*'.$core->get_Lang('daytrip').'</span></div>
						<div class="fieldarea"><input type="text" name="title" class="text full fontLarge required" id="title" value="'.$clsTourItinerary->getOneField('title',$tour_itinerary_id).'" /></div>
					</div>
					<div class="row-span">
						<div class="fieldlabel bold text-right" style="text-align:right">
							<span class="color_r">*'.$core->get_Lang('meal').'</span> 
							<input type="checkbox" class="checkall_checkbox" group="meal" title="'.$core->get_Lang('selectall').'" style="cursor:pointer;" />
						</div>
						<div class="fieldarea">
							<div style="border:1px solid #d7d7d7;padding:3px 10px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;">';
							$lstMeal = $clsTour->getListMeal();
							if(!empty($lstMeal)){
								foreach($lstMeal as $k=>$v){
									$html.='
									<label class="mr20">
										<input type="checkbox" name="meal[]" '.($tour_itinerary_id > 0 ? ($clsTourItinerary->checkMealExist($k,$tour_itinerary_id)?'checked="checked"':'') : '').' class="checkitem_checkbox chk_Meal" group="meal" value="'.$k.'"> '.$v.'
									</label>';
								}	
							}				
	$html.='				</div>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right;font-weight:700">'.$core->get_Lang('content').'</div>
						<div class="fieldarea">
							<textarea rows="5" cols="255" id="textarea_itinerary_content_editor_'.time().'" class="textarea_itinerary_content_editor" style="width:100%">'.$clsTourItinerary->getContent($tour_itinerary_id).'</textarea>
						</div>
					</div>
					'.($tour_itinerary_id > 0 && $clsConfiguration->getValue('SiteHasHotel_Tours') ? '
					<div class="row-span" style="border:1px dashed #c00000; padding:1%; width:100%;">
						<div class="fieldlabel" style="font-weight:700">'.$core->get_Lang('hotel').' <button type="button" tour_id="'.$tour_id.'" tour_itinerary_id="'.$tour_itinerary_id.'" tour_hotel_id="0" class="iso-button-small ajaxOpenChoiceHotel">...</button></div>
						<div class="fieldarea"><div id="lstHotel"></div></div>
					</div>
					':'').'
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="submit" tour_itinerary_id="'.$tour_itinerary_id.'" class="btn btn-primary btnSaveTourItinerary">
				<i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span>
			</button>
		</div>';
		echo($html);die();
	} elseif($tp == 'S') {
		$dayPost = isset($_POST['day']) ? $_POST['day']:0;
		$dayPost2 = isset($_POST['day2']) ? $_POST['day2']:0;
		$titlePost = isset($_POST['title']) ? $_POST['title']:'';
		$slugPost = $core->replaceSpace($titlePost);
		$mealsPost = isset($_POST['meals'])?$_POST['meals']:'';
		$transport_id = isset($_POST['transport_id'])?$_POST['transport_id']:0;
		$contentPost = isset($_POST['content']) ? $_POST['content']:'';
		$imagePost = isset($_POST['image']) ? $_POST['image']:'';
		$dateTitlePost = isset($_POST['date_title']) ? $_POST['date_title']:'';
		$is_show_image = isset($_POST['is_show_image']) ? intval($_POST['is_show_image']): 0;
		#
		if($tour_itinerary_id > 0) {
			if($clsTourItinerary->countItem("tour_id='$tour_id' and day='$dayPost' day2='$dayPost2' and tour_itinerary_id<>'$tour_itinerary_id'")>0){
				echo 'day_invalid'; die();	
			}
			$v = "user_id_update='$user_id',day='$dayPost',day2='$dayPost2',title='$titlePost',slug='$slugPost',content='".addslashes($contentPost)."',meals='$mealsPost',upd_date='".time()."',image='$imagePost',transport_id='$transport_id',date_title='$dateTitlePost',is_show_image='$is_show_image'";
			#
			if($clsTourItinerary->updateOne($tour_itinerary_id,$v)){
				echo '_UPDATE_SUCCESS'; die();
			}else{
				echo '_ERROR'; die();
			}	
		} else {
			if($clsTourItinerary->countItem("tour_id='$tour_id' and day='$dayPost'")>0){
				echo 'day_invalid'; die();	
			} else {
				$max_id = $clsTourItinerary->getMaxID();
				$fx ="$clsTourItinerary->pkey,user_id,user_id_update,day,tour_id,title,slug,content,meals";
				$fx.=",reg_date,upd_date,image,transport_id,order_no,date_title,is_show_image";
				$vx ="'".$max_id."','$user_id','$user_id','$dayPost','$tour_id','$titlePost','$slugPost','".addslashes($contentPost)."','$mealsPost','".time()."','".time()."','".addslashes($imagePost)."','$transport_id','".$clsTourItinerary->getMaxOrderNo()."','".$dateTitlePost."','".$is_show_image."'";
				#
				if($clsTourItinerary->insertOne($fx,$vx)){
					echo '_INSERT_SUCCESS'; die();
				}else{
					echo '_ERROR'; die();
				}
			}
		}
	} elseif($tp == 'M') {
		$direct = isset($_POST['direct'])?$_POST['direct']:'';
		$one = $clsTourItinerary->getOne($tour_itinerary_id);
		$dayTour = $one['day'];
		
		$cond = 'is_trash=0 and tour_id='.$tour_id;
		if($direct=='moveup'){
			$lst = $clsTourItinerary->getAll($cond." and day < $dayTour order by day desc limit 0,1");
			$clsTourItinerary->updateOne($tour_itinerary_id,"day='".$lst[0]['day']."'");
			$clsTourItinerary->updateOne($lst[0][$clsTourItinerary->pkey],"day='".$dayTour."'");
		}
		if($direct=='movedown'){
			$lst = $clsTourItinerary->getAll($cond." and day > $dayTour order by day asc limit 0,1");
			$clsTourItinerary->updateOne($tour_itinerary_id,"day='".$lst[0]['day']."'");
			$clsTourItinerary->updateOne($lst[0][$clsTourItinerary->pkey],"day='".$dayTour."'");
		}
		if($direct=='movetop'){
			$lst = $clsTourItinerary->getAll($cond." and day < $dayTour order by day desc");
			$clsTourItinerary->updateOne($tour_itinerary_id,"day='".$lst[count($lst)-1]['day']."'");
			$lstItem = $clsTourItinerary->getAll($cond." and tour_itinerary_id <> '$tour_itinerary_id' and day < $dayTour order by day asc");
			for($i=0;$i<count($lstItem);$i++) {
				$clsTourItinerary->updateOne($lstItem[$i][$clsTourItinerary->pkey],"day='".($lstItem[$i]['day']+1)."'");	
			}
		}
		if($direct=='movebottom'){
			$lst = $clsTourItinerary->getAll($cond." and day > $dayTour order by day asc");
			$clsTourItinerary->updateOne($tour_itinerary_id,"day='".$lst[count($lst)-1]['day']."'");
			$lstItem = $clsTourItinerary->getAll($cond." and $tour_itinerary_id <> '$tour_itinerary_id' and day > $dayTour order by day asc");
			for($i=0;$i<count($lstItem);$i++) {
				$clsTourItinerary->updateOne($lstItem[$i][$clsTourItinerary->pkey],"day='".($lstItem[$i]['day']-1)."'");	
			}
		}
		echo(1); die();
	} elseif($tp == 'D') {
		$clsTourItinerary->doDelete($tour_itinerary_id);
		echo(1); die();
	}
}

/*------ START_SELECTBOX_GEO -------*/
function default_ajLoadChauLuc(){
	$clsContinent = new Continent();
	#
	$lst = $clsContinent->getAll("is_trash=0 order by title asc");
	$html = '';
	if(!empty($lst)){
		foreach($lst as $item){
			$html.='<option value="'.$item[$clsContinent->pkey].'">'.$clsContinent->getTitle($item[$clsContinent->pkey]).'</option>';
		}
	}
	echo $html; die();
}
function default_ajLoadCountry(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsCountry = new Country();
	$chauluc_id = isset($_POST['chauluc_id'])?intval($_POST['chauluc_id']):0;
	$khuvuc_id = isset($_POST['khuvuc_id'])?intval($_POST['khuvuc_id']):0;
	$country_id = isset($_POST['country_id'])?intval($_POST['country_id']):0; 
	#
	$cond = "is_trash=0";
	if($chauluc_id > 0){$cond .= " and continent_id='$chauluc_id'";}
	if($khuvuc_id > 0){$cond .= " and khuvuc_id='$khuvuc_id'";}
	#
	if($clsCountry->countItem($cond) > 0) {
		$html = "<option value='0'>".$core->get_Lang('selectcountry')."</option>";
		$rslist = $clsCountry->getAll($cond." order by order_no asc", $clsCountry->pkey);
		if(is_array($rslist) && count($rslist)>0){
			foreach($rslist as $k => $v){
				$html .= '<option value="'.$v[$clsCountry->pkey].'" '.($country_id==$v[$clsCountry->pkey]?'selected="selected"':'').'>'.$clsCountry->getTitle($v[$clsCountry->pkey]).'</option>';
			}
			unset($rslist);
		}
	} else {
		$html = 'EMPTY';
	}
	echo $html; die();
}

function default_ajaxMakeSelectboxCity(){
	global $core,$mod,$act;
	#
	$clsCity = new City();
	$clsTour = new Tour();
	#
	$depart_point_id = isset($_POST['depart_point_id'])?$_POST['depart_point_id']:'';
	$city_id = isset($_POST['city_id'])?$_POST['city_id']:'';
	$tour_type_id = isset($_POST['tour_type_id'])?$_POST['tour_type_id']:'0';
	#
	$html = '<option value="">-- '.$core->get_Lang('select').' --</option>';
	#
	if(!empty($depart_point_id)) {
		$lstCity = $clsCity->getAll("is_trash=0 order by order_no asc",$clsCity->pkey);
		if(!empty($lstCity)){
			foreach($lstCity as $item){
				if($clsTour->countTourGolobal(0,$depart_point_id, $item[$clsCity->pkey], 0, $tour_type_id)>0){
					$selected = ($city_id==$item[$clsCity->pkey])?'selected="selected"':'';
					$html.='<option value="'.$item[$clsCity->pkey].'" '.$selected.'>'.$clsCity->getTitle($item[$clsCity->pkey]).'</option>';
				}
			}
		}
	}
	echo $html; die();
}
function default_ajmakeSelectPlaceToGoGlobal(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsGuide = new Guide();
	$country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
	$city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;
	#
	$cond = "is_trash=0 and is_online=1 and cat_id='15'";
	if($country_id > 0){$cond .= " and country_id='$country_id'";}
	if($city_id > 0){$cond .= " and city_id='$city_id'";}
	#
	$html = '<option value="0">'.$core->get_Lang('selectplacetogo').'</option>';
	if($clsGuide->countItem($cond) > 0) {
		$lstPlaceToGo = $clsGuide->getAll($cond." order by slug asc", $clsGuide->pkey);
		if(!empty($lstPlaceToGo)){
			foreach($lstPlaceToGo as $k => $v){
				$html .= '<option value="'.$v[$clsGuide->pkey].'" '.($guide_id==$v[$clsGuide->pkey]?'selected="selected"':'').'>'.$clsGuide->getTitle($v[$clsGuide->pkey]).'</option>';
			}
			unset($lstPlaceToGo);
	
		}
	} else {
		$html = 'EMPTY';
	}
	echo $html; die();
}

/*========= START TOUR LIST DESTINATION MOD ===========*/
function default_ajaxLoadTourDestination(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTourDestination = new TourDestination();
	$clsContinent = new Continent();
	$clsArea = new Area();
	$clsCountry = new Country();
	$clsRegion = new Region();
	$clsCity = new City();
	$clsGuide = new Guide();
	$clsTour = new Tour();
	$tour_id = $_POST['tour_id'];
	$html = '';
	#
	$lstDestination = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc");
	if(is_array($lstDestination) && count($lstDestination) > 0){
		foreach($lstDestination as $k=>$v){
			$title = '';
			if(intval($v['chauluc_id']) > 0){
				$title.= ' &raquo; '.$clsContinent->getTitle($v['chauluc_id']);
			}
			if(intval($v['area_id']) > 0){
				$title.= ' &raquo; '.$clsArea->getTitle($v['area_id']);
			}
			if(intval($v['country_id']) > 0){
				$title.= ' &raquo; '.$clsCountry->getTitle($v['country_id']);
			}
			if(intval($v['region_id']) > 0){
				$title.= ' &raquo; '.$clsRegion->getTitle($v['region_id']);
			}
			if(intval($v['city_id']) > 0){
				$title.= ' &raquo; '.$clsCity->getTitle($v['city_id']);
			}if(intval($v['placetogo_id']) > 0){
				$title.= ' &raquo; '.$clsGuide->getTitle($v['placetogo_id']);
			}
			$html.='<li style="cursor:move" id="order_'.$v[$clsTourDestination->pkey].'"><strong><a  title="'.$core->get_Lang('Drag & drop change position').'">'.$title.'</a></strong><span class="remove removeDestination" data="'.$v[$clsTourDestination->pkey].'">x</span></li>';
		}
		$html .= '
		<li style="cursor:pointer; width:90px; margin-top:10px;" class="ajRemoveAllDestinationInTour iso-button-primary"><i class="fa fa-times-circle-o"></i> '.$core->get_Lang('removeall').'</li>';
		$html.='
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
					$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosTourDestination", order, function(html){
						vietiso_loading(0);
					});
				}
			});
		</script>';
		unset($lstDestination);
	}
	echo $html; die();
}
function default_ajUpdPosTourDestination(){
		global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
		global $clsConfiguration;
	#
	$clsTour = new Tour();
	$clsTourDestination = new TourDestination();
	$order = $_POST['order'];
	foreach($order as $key=>$val){
		$key = $key+1;
		$clsTourDestination->updateOne($val,"order_no='".$key."'");	
	}
	//var_dump($order);die;
}
function default_ajaxAddMoreTourDestination(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration;
	#
	$clsTour = new Tour();
	$clsTourDestination = new TourDestination();
	#
	$chauluc_id = isset($_POST['chauluc_id'])?intval($_POST['chauluc_id']):0;
	$country_id = isset($_POST['country_id'])?intval($_POST['country_id']):0;
	$region_id = isset($_POST['region_id'])?intval($_POST['region_id']):0;
	$city_id = isset($_POST['city_id'])?intval($_POST['city_id']):0;
	$placetogo_id = isset($_POST['placetogo_id'])?intval($_POST['placetogo_id']):0;
	$tour_id = isset($_POST['tour_id'])?intval($_POST['tour_id']):0;
	#
	$cond = "is_trash=0";
	if($chauluc_id > 0) {$cond .= " and chauluc_id='$chauluc_id'";}
	if($country_id > 0) {$cond .= " and country_id='$country_id'";}
	if($region_id > 0) {$cond .= " and region_id='$region_id'";}
	if($city_id > 0) {$cond .= " and city_id='$city_id'";}
	if($placetogo_id > 0) {$cond .= " and placetogo_id='$placetogo_id'";}
	if($tour_id > 0) {$cond .= " and tour_id='$tour_id'";}
	
	if($clsTourDestination->countItem($cond) > 0){
		echo '_EXIST'; die();
	}else{
		$f="$clsTourDestination->pkey,tour_id,country_id,region_id,city_id,order_no,val,chauluc_id,area_id,placetogo_id";
		$v="'".$clsTourDestination->getMaxID()."','$tour_id','$country_id','$region_id','$city_id','".$clsTourDestination->getMaxOrderNo($tour_id)."','1','$chauluc_id','$area_id','$placetogo_id'";
		//print_r($f.'xxxxxx'.$v); die();
		if($clsTourDestination->insertOne($f,$v)){
			echo '_SUCCESS'; die();
		}else{
			echo '_ERROR'; die();
		}
	}
}
function default_ajaxDeleteTourDestination(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsTourDestination = new TourDestination();
	$tour_destination_id = $_POST['tour_destination_id'];
	#
	$clsTourDestination->deleteOne($tour_destination_id);
	echo(1); die();
}
function default_ajaxDeleteAllTourDestination(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsTourDestination = new TourDestination();
	$tour_id = $_POST['tour_id'];
	#
	$clsTourDestination->deleteByCond("tour_id='$tour_id'");
	echo(1); die();
}
function default_listtour(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act,$clsConfiguration;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$clsUser = new User();
	$pUrl = '';
	$user_group_id = $clsUser->getOneField('user_group_id',$user_id);
	#
	$clsCountry = new Country(); $assign_list["clsCountry"] = $clsCountry;
	$clsTourCat = new TourCategory(); $assign_list["clsTourCat"] = $clsTourCat;
	$clsCity = new City();$assign_list["clsCity"] = $clsCity;
	$clsPriceRange = new PriceRange();$assign_list["clsPriceRange"] = $clsPriceRange;
	$clsTourStore = new TourStore();$assign_list["clsTourStore"] = $clsTourStore;
	#
	$SiteHasCategoryGroup_Tours = $clsConfiguration->getValue('SiteHasCategoryGroup_Tours');
	$SiteHasGroup_Tours = $clsConfiguration->getValue("SiteHasGroup_Tours");
	$tour_group_id = 0;
	if($SiteHasGroup_Tours){
		$clsTourGroup = new TourGroup();
		$assign_list["clsTourGroup"] = $clsTourGroup;
		$tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
	}
	$assign_list["tour_group_id"] = $tour_group_id;
	#
	$cat_id= 0;
	if($clsConfiguration->getValue('SiteHasCat_Tours')){
		$clsTourCat = new TourCategory(); $assign_list["clsTourCat"] = $clsTourCat;
		$cat_id=isset($_GET['cat_id'])?intval($_GET['cat_id']):0;
	}
	$assign_list["cat_id"] = $cat_id;
	#
	$price_range_id= 0;
	if($clsConfiguration->getValue('SiteHasPriceRange_Tours')){
		$clsPriceRange = new PriceRange(); $assign_list["clsPriceRange"] = $clsPriceRange;
		$price_range_id = isset($_GET['price_range_id'])?intval($_GET['price_range_id']):0;
	}
	$assign_list["price_range_id"] = $price_range_id;
	#
	$type = isset($_GET['type'])?$core->decryptID($_GET['type']):'';$assign_list["type"] = $type;
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';$assign_list["type_list"] = $type_list;
	$cat_id=isset($_GET['cat_id'])?$_GET['cat_id']:'';$assign_list["cat_id"] = $cat_id;
	$depart_point_id=isset($_GET['depart_point_id'])?$_GET['depart_point_id']:'';$assign_list["depart_point_id"] = $depart_point_id;
	$number_day=isset($_GET['number_day'])?$_GET['number_day']:'';$assign_list["number_day"] = $number_day;
	$price_range_id=isset($_GET['price_range_id'])?$_GET['price_range_id']:'';$assign_list["price_range_id"] = $price_range_id;
	
	if($type==''){
		header('location: '.PCMS_URL.'/?mod=tour&message=notPermission');
	}
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = '&act='.$act.'&type='.$core->encryptID($type);
		if($SiteHasGroup_Tours){
			if(isset($_POST['tour_group_id']) && intval($_POST['tour_group_id']) != 0){
				$link .= '&tour_group_id='.intval($_POST['tour_group_id']);
			}
		}
		if(isset($_POST['cat_id']) && intval($_POST['cat_id']) != 0){
			$link .= '&cat_id='.$_POST['cat_id'];
		}
		if(isset($_POST['tour_type_id']) && intval($_POST['tour_type_id']) != 0){
			$link .= '&tour_type_id='.$_POST['tour_type_id'];
		}
		if(isset($_POST['departure_point_id']) && intval($_POST['departure_point_id'])!=0){
			$link .= '&departure_point_id='.$_POST['departure_point_id'];
		}
		if(isset($_POST['number_day']) && intval($_POST['number_day'])!=0){
			$link .= '&number_day='.$_POST['number_day'];
		}
		if(isset($_POST['price_range_id']) && intval($_POST['price_range_id'])!=0){
			$link .= '&price_range_id='.$_POST['price_range_id'];
		}
		if($_POST['keyword']!=''&&$_POST['keyword']!='Type trip code or tour name'){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	#
	$classTable = "Tour";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	
	$cond = "is_trash=0 and is_online=1";
	
	if(isset($type) && !empty($type)) {
		$cond.= " and tour_id NOT IN (SELECT tour_id FROM ".DB_PREFIX."tour_store WHERE _type='".$type."')";
		$pUrl.='&type='.$core->encryptID($type);
	}
	if(isset($cat_id) && intval($cat_id)!=0){
		$cond.=" and (cat_id = '".$cat_id."' or list_cat_id like '%|".$cat_id."|%')";
		$pUrl.='&cat_id='.$cat_id;
	}
	if(isset($depart_point_id) && intval($depart_point_id)!=0){
		$cond.=" and depart_point_id = '".$depart_point_id."'";
		$pUrl.='&depart_point_id='.$depart_point_id;
	}
	if(isset($number_day) && intval($number_day)!=0){
		$cond.=" and number_day = '".$number_day."'";
		$pUrl.='&number_day='.$number_day;
	}
	if($price_range_id!='' && $price_range_id!='0' && $price_range_id!='All'){
		$onePriceRange = $clsPriceRange->getOne($price_range_id);
		$min_rate = $onePriceRange['min_rate'];
		$max_rate = $onePriceRange['max_rate'];
		#
		if($min_rate == 0 && $max_rate > 0){
			$cond.= " and trip_price < '$max_rate'";
		}elseif($min_rate >0 && $max_rate > 0){
			$cond.=" and trip_price > '$min_rate' and trip_price < '$max_rate'";
		}else{
			$cond.= " and trip_price > '$min_rate'";
		}
		$pUrl.='&price_range_id='.$price_range_id;
	}
	if(isset($_GET['keyword'])&&$_GET['keyword']!=''){
		$slug = $core->replaceSpace($_GET['keyword']);
		$cond .= " and ( trip_code like '%".$_GET['keyword']."%' or slug like '%".$slug."%' or title like '%".$slug."%')";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$cond2 = $cond;
	if($user_group_id==2){
		$cond .= " and is_online='0' and user_id='$user_id'";//
	}
	$orderBy = " order by order_no desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 30;
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
	$allItem = $clsClassTable->getAll($cond.$orderBy.$limit); //print_r($cond.$orderBy.$limit);die();
	$assign_list["allItem"] = $allItem;
	$assign_list['pUrl'] = $pUrl;
	
	//Action
	$action = isset($_GET['action'])?$_GET['action']:'';
	if($action=='Add'){
		$pvalTable = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]: '';
		if($pvalTable=='' && $pvalTable==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		if(!$clsTourStore->checkExist($pvalTable,$type)) {
			$max_id = $clsTourStore->getMaxId();
			$max_order = $clsTourStore->getMaxOrder($type);
			$f = "tour_store_id,tour_id,_type,order_no";
			$v = "'$max_id','$pvalTable','$type','$max_order'";
			if($clsTourStore->insertOne($f,$v)) {
				header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.$pUrl.'&message=insertSuccess');
			}
		}
	}
}
/* START TOUR_PRICE_SYSTEM */
function default_aj_load_season_price(){
	global $core, $clsISO,$_LANG_ID,$gid;
	#
	$clsTour = new Tour();
	$clsCommon = new Common();
	$clsTourProperty = new TourProperty();
	$tour_id = $_POST['tour_id'];
	$season = $_POST['season'];
	$html = '<table class="form" cellpadding="3" cellspacing="3">';
	#
	$lstTourClass = $clsTourProperty->getAll("is_trash=0 and type='TOURCLASS' order by order_no asc");
	$html .= '
			<tr>
				<td class="fieldarea" align="right">
					<em>Nett price</em>
				</td>';
	for($i=0;$i<count($lstTourClass);$i++){
		$html .= '
				<td class="fieldlabel">'.$clsTourProperty->getTitle($lstTourClass[$i][$clsTourProperty->pkey]).'</td>
				<td class="fieldarea">
					<input title="'.$core->get_Lang('show').'" _type="client" '.($clsTour->checkShowSeasonPrice($tour_id,$season,$lstTourClass[$i][$clsTourProperty->pkey],'client')==1?'checked="checked"':'').' type="checkbox" value="1" class="tour_season_price_check" tour_class_id="'.$lstTourClass[$i][$clsTourProperty->pkey].'" tour_id="'.$tour_id.'" season="'.$season.'" />
					<input '.($clsTour->checkShowSeasonPrice($tour_id,$season,$lstTourClass[$i][$clsTourProperty->pkey],'client')==1?'':'disabled="disabled"').' type="text" _type="client" class="full text tour_season_price" tour_class_id="'.$lstTourClass[$i][$clsTourProperty->pkey].'" tour_id="'.$tour_id.'" season="'.$season.'" value="'.$clsISO->formatNumberToEasyRead($clsTour->getSeasonPrice($tour_id,$season,$lstTourClass[$i][$clsTourProperty->pkey],'client')).'" style="width:76px;" />'.$clsISO->getRate().'
				</td>
		';
	}
	$html .= '
			</tr>';		
	#
	$html .= '</table>';
	echo('0|||'.$html);die();	
}
function default_aj_save_tour_season_price(){
	global $core, $clsISO,$_LANG_ID,$gid;
	#
	$clsTour = new Tour();
	$tour_id = $_POST['tour_id'];
	$season = $_POST['season'];
	$tour_class_id = $_POST['tour_class_id'];
	$_type = $_POST['_type'];
	$price = $clsISO->processSmartNumber($_POST['price']);
	
	$is_hide = isset($_POST['is_hide'])? $_POST['is_hide']:0;
	$action = isset($_POST['action'])? $_POST['action']:'';
	#
	$clsTourSeasonPrice = new TourSeasonPrice();
	$lst = $clsTourSeasonPrice->getAll("tour_id='$tour_id' and season='$season' and tour_class_id='$tour_class_id' and _type='$_type' limit 0,1");
	if($lst[0][$clsTourSeasonPrice->pkey]!=''){
		$set = "price='$price'";
		if($action=='check'){
			$set = "is_hide='$is_hide'";
		}
		$clsTourSeasonPrice->updateOne($lst[0][$clsTourSeasonPrice->pkey],$set);
	}else{
		$f = "tour_id,season,tour_class_id,price,_type";
		$v = "'$tour_id','$season','$tour_class_id','$price','$_type'";
		if($action=='check'){
			$f .= ",is_hide";
			$v .= ",'$is_hide'";
		}
		$clsTourSeasonPrice->insertOne($f,$v);
	}
	#
	echo('0|||'.$clsISO->formatNumberToEasyRead($price));die();	
}
function default_aj_save_tour_price_in_date(){
	global $core, $clsISO,$_LANG_ID,$gid;
	#
	$clsTour = new Tour();
	$clsDomain = new Domain();
	$clsCommon = new Common();
	$clsProperty = new Property();
	$tour_id = $_POST['tour_id'];
	$tour_start_date_id = $_POST['tour_start_date_id'];
	$tour_class_id = $_POST['tour_class_id'];
	$_type = $_POST['_type'];
	$common_id = $clsDomain->getOneField('_common_id',$gid);
	$price = $clsISO->processSmartNumber($_POST['price']);
	#
	$clsTourStartDatePrice = new TourStartDatePrice();
	$lst = $clsTourStartDatePrice->getAll("tour_id='$tour_id' and tour_start_date_id='$tour_start_date_id' and tour_class_id='$tour_class_id' and _type='$_type' limit 0,1");
	if($lst[0][$clsTourStartDatePrice->pkey]!=''){
		$set = "price='$price'";
		$clsTourStartDatePrice->updateOne($lst[0][$clsTourStartDatePrice->pkey],$set);
	}else{
		$f = "tour_id,tour_start_date_id,tour_class_id,price,_type";
		$v = "'$tour_id','$tour_start_date_id','$tour_class_id','$price','$_type'";
		$clsTourStartDatePrice->insertOne($f,$v);
	}
	#
	echo('0|||'.$clsISO->formatNumberToEasyRead($price));die();	
}
function default_aj_save_change_is_hide(){
	global $core, $clsISO,$_LANG_ID,$gid;
	#
	$clsTour = new Tour();
	$clsDomain = new Domain();
	$clsCommon = new Common();
	$clsProperty = new Property();
	$tour_id = $_POST['tour_id'];
	$tour_start_date_id = $_POST['tour_start_date_id'];
	$tour_class_id = $_POST['tour_class_id'];
	$_type = $_POST['_type'];
	$common_id = $clsDomain->getOneField('_common_id',$gid);
	$val = $_POST['val'];
	#
	$clsTourStartDatePrice = new TourStartDatePrice();
	$lst = $clsTourStartDatePrice->getAll("tour_id='$tour_id' and tour_start_date_id='$tour_start_date_id' and tour_class_id='$tour_class_id' and _type='$_type' limit 0,1");
	if($lst[0][$clsTourStartDatePrice->pkey]!=''){
		$set = "is_hide='$val'";
		$clsTourStartDatePrice->updateOne($lst[0][$clsTourStartDatePrice->pkey],$set);
	}else{
		$f = "tour_id,tour_start_date_id,tour_class_id,price,_type,is_hide";
		$v = "'$tour_id','$tour_start_date_id','$tour_class_id','$price','$_type','$val'";
		$clsTourStartDatePrice->insertOne($f,$v);
	}
	#
	echo('0|||'.$clsISO->formatNumberToEasyRead($price));die();	
}
function default_ajResetTourProperty(){
	global $core, $clsISO, $_LANG_ID, $clsConfiguration;
	#
	$tour_id = $_POST['tour_id'];
	$tp = $_POST['tp'];
	#
	if($tp=='tour_low'||$tp=='tour_high'){
		$from = $clsConfiguration->getValue($tp.'_from');
		$to = $clsConfiguration->getValue($tp.'_to');
		#
		echo('0|||'.date('m/d/Y',$from).'|||'.date('m/d/Y',$to));die();
	}
	if($tp=='config_markup_tour'){
		echo('0|||'.$clsConfiguration->getValue($tp.'').'|||'.$clsConfiguration->getValue($tp.'_agent'));die();
	}
}
function default_ajLoadTourPriceNewVersion(){
	global $core, $clsISO,$dbconn, $_LANG_ID, $clsConfiguration;
	global $_loged_id;
	#
	$clsTour = new Tour();
	$clsTourProperty = new TourProperty(); $assign_list["clsTourProperty"] = $clsTourProperty;
	$clsProperty = new Property(); $assign_list["clsProperty"] = $clsProperty;
	$clsTourPriceRow = new TourPriceRow(); $assign_list["clsTourPriceRow"] = $clsTourPriceRow;
	$clsTourPriceCol = new TourPriceCol(); $assign_list["clsTourPriceCol"] = $clsTourPriceCol;
	$clsTourPriceVal = new TourPriceVal(); $assign_list["clsTourPriceVal"] = $clsTourPriceVal;
	$tour_id = $_POST['tour_id'];
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	$is_agent = isset($_POST['is_agent']) ? $_POST['is_agent'] : '0';
	
	
	$lstNationality = $clsTourProperty->getAll("is_trash=0 and type='NATIONALITY' order by order_no asc");
	
	
	$lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc");

	if($tp=='L'){
	$html = '
	<div id="tourPriceTable">';
	if($lstVisitorType[0]['tour_property_id']!=''){
		$html .= '
		<table class="table tbl-grid"  style="border:1px solid #ccc;width:80% !important">
			<thead>
				<tr><td class="gridheader" rowspan="2">
						<strong><span class="table_price_title">'.$core->get_Lang('Traveler Types').'</span></strong>
					</td>';
					for($k=0;$k<count($lstNationality);$k++){
						if($_LANG_ID=='vn'){ 
						$html.= '
						<td class="gridheader" style="text-align:center;">'.$lstNationality[$k]['title'].'</td>';
						}else{
						$html .= '<td colspan="2" style="text-align:center;"><strong>'.$core->get_Lang('Price').'</strong></td>';
						}
					}
				$html.= '
				</tr>';
				if(_IS_AGENT==1){
					$html.='<tr>
						<td><strong>'.$core->get_Lang('Traveler').'</strong></td>
						<td><strong>'.$core->get_Lang('Agent').'</strong></td>
					</tr>';
				}                         
			$html.='</thead>';
				if($lstVisitorType[0]['tour_property_id']!=''){
					for($i=0;$i<count($lstVisitorType);$i++){
						$html .= '
						<tr>
						<td style="text-align:left;">'.$lstVisitorType[$i]['title'].'</td>';
							for($k=0;$k<count($lstNationality);$k++){
								$html.='
								<td style="text-align:center;white-space:nowrap">';
									if($_LANG_ID=='vn'){
										$html.= ''.$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency')).'  <input class="text tour_season_price_newversion fontLarge" style="width:60%; text-align:right; color:red;" id="advertisedPrice'.$lstVisitorType[$i]['tour_property_id'].'" departure="'.$start_date.'"  tour_property_idc="'.$lstNationality[$k]['tour_property_id'].'" tour_property_idr="'.$lstVisitorType[$i]['tour_property_id'].'" tour_id="'.$tour_id.'" is_agent="0"  value="'.$clsTourPriceVal->getTripPriceOption($lstVisitorType[$i]['tour_property_id'],$lstNationality[$k]['tour_property_id'],$start_date,$tour_id,0).'" type="text" /> '.$clsISO->getRate().'
										';
									}else{
									$html.= ' '.$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency')).' <input class="text tour_season_price_newversion fontLarge" style="width:60%; text-align:right; color:red;" id="advertisedPrice'.$lstVisitorType[$i]['tour_property_id'].'" departure="'.$start_date.'"  tour_property_idc="'.$lstNationality[$k]['tour_property_id'].'" tour_property_idr="'.$lstVisitorType[$i]['tour_property_id'].'" tour_id="'.$tour_id.'" is_agent="0"  value="'.$clsTourPriceVal->getTripPriceOption($lstVisitorType[$i]['tour_property_id'],0,$start_date,$tour_id,0).'" type="text" />
									<input name="priceHidden'.$lstVisitorType[$i]['tour_property_id'].'" value="'.$clsTourPriceVal->getTripPriceOption($lstVisitorType[$i]['tour_property_id'],0,$start_date,$tour_id,0).'" type="hidden" />';
									$html .= '</td>'; 
									}
								if(_IS_AGENT==1){
									$html .= '</td>
									<td style="text-align:center;white-space:nowrap">';
										if($_LANG_ID=='vn'){
											$html.= ''.$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency')).'  <input class="text tour_season_price_newversion fontLarge" style="width:60%; text-align:right; color:red;" id="advertisedPrice'.$lstVisitorType[$i]['tour_property_id'].'" departure="'.$start_date.'"  tour_property_idc="'.$lstNationality[$k]['tour_property_id'].'" tour_property_idr="'.$lstVisitorType[$i]['tour_property_id'].'" tour_id="'.$tour_id.'" is_agent="1"  value="'.$clsTourPriceVal->getTripPriceOption($lstVisitorType[$i]['tour_property_id'],$lstNationality[$k]['tour_property_id'],$start_date,$tour_id,1).'" type="text" /> '.$clsISO->getRate().'
											';
										}else{
											$html.= ' '.$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency')).' <input class="text tour_season_price_newversion fontLarge" style="width:60%; text-align:right; color:red;" id="advertisedPrice'.$lstVisitorType[$i]['tour_property_id'].'" departure="'.$start_date.'"  tour_property_idc="'.$lstNationality[$k]['tour_property_id'].'" tour_property_idr="'.$lstVisitorType[$i]['tour_property_id'].'" tour_id="'.$tour_id.'" is_agent="1" value="'.$clsTourPriceVal->getTripPriceOption($lstVisitorType[$i]['tour_property_id'],$lstNationality[$k]['tour_property_id'],$start_date,$tour_id,1).'" type="text" />
											<input name="priceHidden'.$lstVisitorType[$i]['tour_property_id'].'" value="'.$clsTourPriceVal->getTripPriceOption($lstVisitorType[$i]['tour_property_id'],$lstNationality[$k]['tour_property_id'],$start_date,$tour_id,1).'" type="hidden" />
										';
										}
									$html .= '</td>'; 
								}
							}			
							$html .= '
						</tr>';
					}
					$html .= '<tr>';
					$html .= '<td class="gridheader" style="text-align:left; display:none"><strong>'.$core->get_Lang('status').'</strong></td>';
					for($k=0; $k<count($lstNationality); $k++){
					$html .= '
					<td class="gridheader text-center" style="display:none">
						<input type="checkbox">
					</td>';	
				}
				$html .= '</tr>';
				}
			$html .= '</table>';
		}
		$html .= '</div>';
	#
	echo($html);die();
	}
	elseif($tp=='S'){
	$tour_price_row_id = isset($_POST['tour_price_row_id'])?intval($_POST['tour_price_row_id']):0;
	$tour_price_col_id = isset($_POST['tour_price_col_id'])?intval($_POST['tour_price_col_id']):0;
	$is_agent = isset($_POST['is_agent'])?intval($_POST['is_agent']):0;
	$departure = isset($_POST['departure'])?intval($_POST['departure']):0;
	$price = $_POST['price'];
	$sql = "tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='$departure' and tour_id='$tour_id' and is_agent='$is_agent'";
	$res =  $clsTourPriceVal->getAll($sql." limit 0,1");
	if(!$res[0]==''){
		$clsTourPriceVal->updateOne($res[0][$clsTourPriceVal->pkey],"price='".$clsISO->processSmartNumber($_POST['price'])."'");
		if($tour_price_row_id==16){
			if($is_agent=='0'){
				$SQL = "SELECT MIN(price) FROM ".DB_PREFIX."tour_price_val WHERE tour_id='$tour_id' and price > 0 and (departure_date >= '".time()."' or departure_date = '0') and tour_price_row_id='16' and tour_price_col_id='0' and is_agent='$is_agent'";
				
				$min_price = $dbconn->GetOne($SQL);
				$trip_price= $clsTour->GetOneField('trip_price',$tour_id);
				if($trip_price > 0){
					if($min_price>=$trip_price){
						$min_trip_price=$trip_price;
					}else{
						$min_trip_price=$min_price;
					}
				}else{
					$min_trip_price=$min_price;
				}

				if($min_trip_price >=$_POST['price']){
					$clsTour->updateOne($tour_id,"min_price='".$_POST['price']."'");
				}else{
					$clsTour->updateOne($tour_id,"min_price='".$min_trip_price."'");
				}
			}else{
				$SQL = "SELECT MIN(price) FROM ".DB_PREFIX."tour_price_val WHERE tour_id='$tour_id' and price > 0 and (departure_date >= '".time()."' or departure_date = '0') and tour_price_row_id='16' and tour_price_col_id='0' and is_agent='$is_agent'";
				$min_price = $dbconn->GetOne($SQL);
				$trip_price= $clsTour->GetOneField('trip_price',$tour_id);
				if($trip_price > 0){
					if($min_price>=$trip_price){
						$min_trip_price=$trip_price;
					}else{
						$min_trip_price=$min_price;
					}
				}else{
					$min_trip_price=$min_price;
				}
				if($min_trip_price >=$_POST['price']){
					$clsTour->updateOne($tour_id,"min_price_agent='".$_POST['price']."'");
				}else{
					$clsTour->updateOne($tour_id,"min_price_agent='".$min_trip_price."'");
				}
			}
		}
	}else{
		$f = "tour_id,tour_price_row_id,tour_price_col_id,price,departure_date,is_agent";
		$v = "'".$tour_id."','".$tour_price_row_id."','".$tour_price_col_id."','".$clsISO->processSmartNumber($_POST['price'])."','".$departure."','".$is_agent."'";
		$clsTourPriceVal->insertOne($f,$v); 
		if($tour_price_row_id==16){
			if($is_agent==0){
				$SQL = "SELECT MIN(price) FROM ".DB_PREFIX."tour_price_val WHERE tour_id='$tour_id' and price > 0 and (departure_date >= '".time()."' or departure_date = '0') and tour_price_row_id='16' and tour_price_col_id='0'  and is_agent='$is_agent'";
				$min_price = $dbconn->GetOne($SQL);
				$trip_price= $clsTour->GetOneField('trip_price',$tour_id);
				if($trip_price > 0){
					if($min_price>=$trip_price){
						$min_trip_price=$trip_price;
					}else{
						$min_trip_price=$min_price;
					}
				}else{
					$min_trip_price=$min_price;
				}
				if($min_trip_price >=$_POST['price']){
					$clsTour->updateOne($tour_id,"min_price='".$_POST['price']."'");
				}else{
					$clsTour->updateOne($tour_id,"min_price='".$min_trip_price."'");
				}
			}else{
				$SQL = "SELECT MIN(price) FROM ".DB_PREFIX."tour_price_val WHERE tour_id='$tour_id' and price > 0 and (departure_date >= '".time()."' or departure_date = '0') and tour_price_row_id='16' and tour_price_col_id='0'  and is_agent='$is_agent'";
				$min_price = $dbconn->GetOne($SQL);
				$trip_price= $clsTour->GetOneField('trip_price',$tour_id);
				if($trip_price > 0){
					if($min_price>=$trip_price){
						$min_trip_price=$trip_price;
					}else{
						$min_trip_price=$min_price;
					}
				}else{
					$min_trip_price=$min_price;
				}
				if($min_trip_price >=$_POST['price']){
					$clsTour->updateOne($tour_id,"min_price_agent='".$_POST['price']."'");
				}else{
					$clsTour->updateOne($tour_id,"min_price_agent='".$min_trip_price."'");
				}
			}
		}
	}
	echo(1); die();
	}
	else{}
}
function default_ajLoadTourPrice(){
	global $core, $clsISO, $_LANG_ID, $clsConfiguration;
	global $_loged_id;
	#
	$clsTour = new Tour();
	$clsTourProperty = new TourProperty(); $assign_list["clsTourProperty"] = $clsTourProperty;
	$clsTourPriceRow = new TourPriceRow();
	$clsTourPriceCol = new TourPriceCol();
	$clsTourPriceVal = new TourPriceVal();
	$tour_id = $_POST['tour_id'];
	
	$lstTourPriceRow = $clsTourPriceRow->getAll("tour_id='$tour_id' order by order_no asc");
	$lstTourPriceCol = $clsTourPriceCol->getAll("tour_id='$tour_id' order by order_no asc");
	$tp = isset($_GET['tp']) ? $_GET['tp'] : '';
	
	
	
	
	
	// RESET_TOUR_PRICE
	if($lstTourPriceCol[0][$clsTourPriceCol->pkey]=='' && $lstTourPriceRow[0][$clsTourPriceRow->pkey]==''){
		
		$lstCol[] = '1 pax';
		$lstCol[] = '2 pax';
		$lstCol[] = '3 pax';
		$lstCol[] = '4 pax';
		
		$lstRow[] = 'Standard';
		$lstRow[] = 'Superior';
		$lstRow[] = 'Deluxe';
		
		if(is_array($lstCol) && count($lstCol) > 0){
			for($i=0; $i<count($lstCol); $i++){
				$f = "tour_id,user_id,title,order_no";
				$v = "'$tour_id','$_loged_id','".addslashes($lstCol[$i])."','".$clsTourPriceCol->getMaxOrderNo()."'";
				$clsTourPriceCol->insertOne($f,$v);
			}
		}
		if(is_array($lstRow) && count($lstRow) > 0){
			for($i=0; $i<count($lstRow); $i++){
				$f = "tour_id,user_id,title,order_no";
				$v = "'$tour_id','$_loged_id','".addslashes($lstRow[$i])."','".$clsTourPriceRow->getMaxOrderNo()."'";
				$clsTourPriceRow->insertOne($f,$v);
			}
		}
	}
	#
	$lstTourPriceRow = $clsTourPriceRow->getAll("tour_id='$tour_id' order by order_no asc");
	$lstTourPriceCol = $clsTourPriceCol->getAll("tour_id='$tour_id' order by order_no asc");
	
	$lstNationality = $clsTourProperty->getAll("is_trash=0 and type='NATIONALITY' order by order_no asc");
	$lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc");

	$html = '
	<div id="tourPriceTable">';
	if($lstVisitorType[0]['tour_property_id']!=''){
		$html .= '
		<table class="table tbl-grid" width="100%" style="border:1px solid #ccc;">
			<thead>
				<tr>
					<td class="gridheader">
						<strong><span class="table_price_title">'.$core->get_Lang('Visitor Type').'</span></strong>
						<script type="text/javascript">
							$().ready(function(){
								$(\'.clickEditPriceTableTitle\').click(function(){
									var _this = $(this);
									var adata = {
										\'tp\' : \'F\',
										\'tour_id\'	: _this.attr(\'tour_id\')
									};
									$.ajax({
										type: "POST",
										url: path_ajax_script+"/index.php?mod=tour&act=ajGetFormEditTablePriceTitle",
										data: adata,
										dataType: "html",
										success: function(html){
											makepopup(300,\'\',html,\'frmEditTablePriceTitle\');
										}
									});	
								});
								$(\'.clickSaveTablePriceTitle\').live(\'click\',function(){
									var _this = $(this);
									var adata = {
										"clsTable" : \'Tour\',
										"pkey" : \'tour_id\',
										"pvalTable" :_this.attr(\'tour_id\'),
										"toField" : _this.attr(\'toField\'),
										"val" : $(\'#table_price_title\').val(),
										"allowDuplicate":\'1\'
									};
									$(\'.table_price_title\').text($(\'#table_price_title\').val());
									$.ajax({
										type: "POST",
										url: path_ajax_script+"/index.php?mod=tour&act=saveField",
										data: adata,
										dataType: "html",
										success: function(html){
											_this.closest(\'.frmPop\').find(\'.close_pop\').trigger(\'click\');
										}
									});
									return false;
								});
							});
						</script>
					</td>';
					for($k=0;$k<count($lstNationality);$k++){
						$html.= '
						<td class="gridheader" style="text-align:center">
							<a class="editTourPriceCol" tp="F" href="javascript:void(0);" data="'.$lstNationality[$k]['tour_property_id'].'">
								<strong>'.$lstNationality[$k]['title'].'</strong>
							</a>
						</td>';
					}
				$html.= '                            
				</tr>
			</thead>';
		if($lstVisitorType[0]['tour_property_id']!=''){
			for($i=0;$i<count($lstVisitorType);$i++){
				$html .= '
				<tr>
					<td style="text-align:left;">
						<a style="font-size:14px" title="'.$core->get_Lang('edit').'" class="editTourPriceRow" tp="F" href="#" data="'.$lstVisitorType[$i]['tour_property_id'].'">'.$lstVisitorType[$i]['title'].'</a>
					</td>';
					for($k=0;$k<count($lstNationality);$k++){
						$html.= '
						<td style="text-align:center;white-space:nowrap">
							<a class="editTourPriceVal" title="'.$core->get_Lang('edit').'" style="color:red; font-size:14px" tour_property_idc="'.$lstNationality[$k]['tour_property_id'].'" tour_property_idr="'.$lstVisitorType[$i]['tour_property_id'].'" href="#">
								'.$clsTourPriceVal->getPrice($lstVisitorType[$i]['tour_property_id'],$lstNationality[$k]['tour_property_id'],$tour_id).'
							</a>
						</td>'; 
					}			
					$html .= '
				</tr>';
			}
		}
		$html .= '</table>';
	}
	$html .= '</div>';
	#
	echo($html);die();
}
function default_ajLoadTourPrice001(){
	global $core, $clsISO, $_LANG_ID, $clsConfiguration;
	global $_loged_id;
	#
	$clsTour = new Tour();
	$clsTourProperty = new TourProperty(); $assign_list["clsTourProperty"] = $clsTourProperty;
	$clsTourPriceRow = new TourPriceRow();
	$clsTourPriceCol = new TourPriceCol();
	$clsTourPriceVal = new TourPriceVal();
	$tour_id = $_POST['tour_id'];
	
	$lstTourPriceRow = $clsTourPriceRow->getAll("tour_id='$tour_id' order by order_no asc");
	$lstTourPriceCol = $clsTourPriceCol->getAll("tour_id='$tour_id' order by order_no asc");
	$tp = isset($_GET['tp']) ? $_GET['tp'] : '';
	
	
	
	
	
	// RESET_TOUR_PRICE
	if($lstTourPriceCol[0][$clsTourPriceCol->pkey]=='' && $lstTourPriceRow[0][$clsTourPriceRow->pkey]==''){
		
		$lstCol[] = '1 pax';
		$lstCol[] = '2 pax';
		$lstCol[] = '3 pax';
		$lstCol[] = '4 pax';
		
		$lstRow[] = 'Standard';
		$lstRow[] = 'Superior';
		$lstRow[] = 'Deluxe';
		
		if(is_array($lstCol) && count($lstCol) > 0){
			for($i=0; $i<count($lstCol); $i++){
				$f = "tour_id,user_id,title,order_no";
				$v = "'$tour_id','$_loged_id','".addslashes($lstCol[$i])."','".$clsTourPriceCol->getMaxOrderNo()."'";
				$clsTourPriceCol->insertOne($f,$v);
			}
		}
		if(is_array($lstRow) && count($lstRow) > 0){
			for($i=0; $i<count($lstRow); $i++){
				$f = "tour_id,user_id,title,order_no";
				$v = "'$tour_id','$_loged_id','".addslashes($lstRow[$i])."','".$clsTourPriceRow->getMaxOrderNo()."'";
				$clsTourPriceRow->insertOne($f,$v);
			}
		}
	}
	#
	$lstTourPriceRow = $clsTourPriceRow->getAll("tour_id='$tour_id' order by order_no asc");
	$lstTourPriceCol = $clsTourPriceCol->getAll("tour_id='$tour_id' order by order_no asc");
	
	$lstNationality = $clsTourProperty->getAll("is_trash=0 and type='NATIONALITY' order by order_no asc");
	$lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc");

	$html = '
	<div class="wrap"> 
		<div class="group_buttons fl">
			<a class="btnCreatePriceRow iso-button-primary fl mr10" data="0" tp="F" style="display:none">
				<i class="icon-plus-sign icon-white"></i> '.$core->get_Lang('addrow').'
			</a> 
			'.(is_array($lstVisitorType) && count($lstVisitorType)> 0 ? '<a href="javascript:void(0);" data="0" tp="F" class="btnCreatePriceCol iso-button-primary fl" style="display:none"><i class="icon-list"></i> '.$core->get_Lang('addcol').'</a>':'').'
		</div>
	</div>
	<br class="clearfix" /><br class="clearfix" />
	<div id="tourPriceTable">';
	if($lstVisitorType[0]['tour_property_id']!=''){
		$html .= '
		<table class="table tbl-grid" width="100%" style="border:1px solid #ccc;">
			<thead>
				<tr>
					<td class="gridheader">
						<strong><span class="table_price_title">'.$core->get_Lang('Visitor Type').'</span></strong>
						<a tour_id="'.$tour_id.'" href="javascript:void(0);" class="clickEditPriceTableTitle" style="display:none">
							<img align="absmiddle" src="'.URL_IMAGES.'/v2/edit_pencial.png">
						</a>
						<script type="text/javascript">
							$().ready(function(){
								$(\'.clickEditPriceTableTitle\').click(function(){
									var _this = $(this);
									var adata = {
										\'tp\' : \'F\',
										\'tour_id\'	: _this.attr(\'tour_id\')
									};
									$.ajax({
										type: "POST",
										url: path_ajax_script+"/index.php?mod=tour&act=ajGetFormEditTablePriceTitle",
										data: adata,
										dataType: "html",
										success: function(html){
											makepopup(300,\'\',html,\'frmEditTablePriceTitle\');
										}
									});	
								});
								$(\'.clickSaveTablePriceTitle\').live(\'click\',function(){
									var _this = $(this);
									var adata = {
										"clsTable" : \'Tour\',
										"pkey" : \'tour_id\',
										"pvalTable" :_this.attr(\'tour_id\'),
										"toField" : _this.attr(\'toField\'),
										"val" : $(\'#table_price_title\').val(),
										"allowDuplicate":\'1\'
									};
									$(\'.table_price_title\').text($(\'#table_price_title\').val());
									$.ajax({
										type: "POST",
										url: path_ajax_script+"/index.php?mod=tour&act=saveField",
										data: adata,
										dataType: "html",
										success: function(html){
											_this.closest(\'.frmPop\').find(\'.close_pop\').trigger(\'click\');
										}
									});
									return false;
								});
							});
						</script>
					</td>';
					for($k=0;$k<count($lstNationality);$k++){
						$html.= '
						<td class="gridheader" style="text-align:center">
							<a class="editTourPriceCol" tp="F" href="javascript:void(0);" data="'.$lstNationality[$k]['tour_property_id'].'">
								<strong>'.$lstNationality[$k]['title'].'</strong>
							</a>
						</td>';
					}
				$html.= '
					<td class="gridheader" style="width:80px;"></td>    
					<td class="gridheader" style="width:80px;"><strong>'.$core->get_Lang('func').'</strong></td>                              
				</tr>
			</thead>';
		if($lstVisitorType[0]['tour_property_id']!=''){
			for($i=0;$i<count($lstVisitorType);$i++){
				$html .= '
				<tr>
					<td style="text-align:left;">
						<a style="font-size:14px" title="'.$core->get_Lang('edit').'" class="editTourPriceRow" tp="F" href="#" data="'.$lstVisitorType[$i]['tour_property_id'].'">'.$lstVisitorType[$i]['title'].'</a>
					</td>';
					for($k=0;$k<count($lstNationality);$k++){
						$html.= '
						<td style="text-align:center;white-space:nowrap">
							<a class="editTourPriceVal" title="'.$core->get_Lang('edit').'" style="color:red; font-size:14px" tour_property_id="'.$lstTourPriceCol[$k]['tour_property_id'].'" tour_property_id="'.$lstVisitorType[$i]['tour_property_id'].'" href="#">
								'.$clsTourPriceVal->getPrice($lstVisitorType[$i]['tour_property_id'],$lstNationality[$k]['tour_property_id']).'
							</a>
						</td>'; 
					}			
					$html .= '
					<td style="text-align:center;">
						'.($i==0?'':'<a class="moveTourPriceRow" direct="up" data="'.$lstVisitorType[$i]['tour_property_id'].'" href="#"><span class="icon-arrow-up"></span></a>').'
						'.($i==count($lstVisitorType)-1?'':'<a class="moveTourPriceRow" direct="down" data="'.$lstVisitorType[$i]['tour_property_id'].'" href="#"><span class="icon-arrow-down"></span> </a>').'
					</td>
					<td style="text-align:center">
						<a class="editTourPriceRow" tp="F" data="'.$lstVisitorType[$i]['tour_property_id'].'" href="javascript:void(0);">
							<span class="icon-pencil"></span>
						</a>
						<a class="deleteTourPriceRow" tp="D" data="'.$lstVisitorType[$i]['tour_property_id'].'" href="javascript:void(0);">
							<span class="icon-remove"></span>
						</a>
					</td>
				</tr>';
			}
			$html .= '
			<tr>
				<td></td>';
				for($k=0;$k<count($lstNationality);$k++){
				$html.='
				<td style="text-align:center;">
					'.($k==0?'':'<a title="'.$core->get_Lang('moveleft').'" class="moveTourPriceCol" href="#" data="'.$lstNationality[$k]['tour_property_id'].'" direct="left"><span class="icon-chevron-left"></span></a>
					').'
					<a title="'.$core->get_Lang('edit').'" class="editTourPriceCol" tp="F" href="#" data="'.$lstNationality[$k]['tour_property_id'].'">
						<span class="icon-pencil"></span>
					</a>
					<a title="'.$core->get_Lang('delete').'" class="deleteTourPriceCol" tp="D" data="'.$lstNationality[$k]['tour_property_id'].'" href="#">
						<span class="icon-remove"></span>
					</a>
					'.($k==count($lstNationality)-1?'':'<a title="'.$core->get_Lang('moveright').'" class="moveTourPriceCol" href="#" data="'.$lstNationality[$k]['tour_property_id'].'" direct="right"><span class="icon-chevron-right"></span></a>
				').'
					</td>';
				}	
			$html.='<td colspan="2"></td></tr><tr></tr>';
		}
		$html .= '</table>';
	}
	$html .= '</div>';
	#
	echo($html);die();
}
function default_ajLoadTourPrice01(){
	global $core, $clsISO, $_LANG_ID, $clsConfiguration;
	global $_loged_id;
	#
	$clsTour = new Tour();
	$clsTourPriceRow = new TourPriceRow();
	$clsTourPriceCol = new TourPriceCol();
	$clsTourPriceVal = new TourPriceVal();
	$tour_id = $_POST['tour_id'];
	
	$lstTourPriceRow = $clsTourPriceRow->getAll("tour_id='$tour_id' order by order_no asc");
	$lstTourPriceCol = $clsTourPriceCol->getAll("tour_id='$tour_id' order by order_no asc");
	$tp = isset($_GET['tp']) ? $_GET['tp'] : '';
	
	
	
	
	
	// RESET_TOUR_PRICE
	if($lstTourPriceCol[0][$clsTourPriceCol->pkey]=='' && $lstTourPriceRow[0][$clsTourPriceRow->pkey]==''){
		$lstCol[] = '1 pax';
		$lstCol[] = '2 pax';
		$lstCol[] = '3 pax';
		$lstCol[] = '4 pax';
		
		$lstRow[] = 'Standard';
		$lstRow[] = 'Superior';
		$lstRow[] = 'Deluxe';
		
		if(is_array($lstCol) && count($lstCol) > 0){
			for($i=0; $i<count($lstCol); $i++){
				$f = "tour_id,user_id,title,order_no";
				$v = "'$tour_id','$_loged_id','".addslashes($lstCol[$i])."','".$clsTourPriceCol->getMaxOrderNo()."'";
				$clsTourPriceCol->insertOne($f,$v);
			}
		}
		if(is_array($lstRow) && count($lstRow) > 0){
			for($i=0; $i<count($lstRow); $i++){
				$f = "tour_id,user_id,title,order_no";
				$v = "'$tour_id','$_loged_id','".addslashes($lstRow[$i])."','".$clsTourPriceRow->getMaxOrderNo()."'";
				$clsTourPriceRow->insertOne($f,$v);
			}
		}
	}
	#
	$lstTourPriceRow = $clsTourPriceRow->getAll("tour_id='$tour_id' order by order_no asc");
	$lstTourPriceCol = $clsTourPriceCol->getAll("tour_id='$tour_id' order by order_no asc");
	$html = '
	<div class="wrap"> 
		<div class="group_buttons fl">
			<a class="btnCreatePriceRow iso-button-primary fl mr10" data="0" tp="F">
				<i class="icon-plus-sign icon-white"></i> '.$core->get_Lang('addrow').'
			</a> 
			'.(is_array($lstTourPriceRow) && count($lstTourPriceRow)> 0 ? '<a href="javascript:void(0);" data="0" tp="F" class="btnCreatePriceCol iso-button-primary fl"><i class="icon-list"></i> '.$core->get_Lang('addcol').'</a>':'').'
		</div>
	</div>
	<br class="clearfix" /><br class="clearfix" />
	<div id="tourPriceTable">';
	if($lstTourPriceRow[0]['tour_price_row_id']!=''){
		$html .= '
		<table class="table tbl-grid" width="100%" style="border:1px solid #ccc;">
			<thead>
				<tr>
					<td class="gridheader">
						<strong><span class="table_price_title">'.$clsTour->getTablePriceTitle($tour_id).'</span></strong>
						<a tour_id="'.$tour_id.'" href="javascript:void(0);" class="clickEditPriceTableTitle">
							<img align="absmiddle" src="'.URL_IMAGES.'/v2/edit_pencial.png">
						</a>
						<script type="text/javascript">
							$().ready(function(){
								$(\'.clickEditPriceTableTitle\').click(function(){
									var _this = $(this);
									var adata = {
										\'tp\' : \'F\',
										\'tour_id\'	: _this.attr(\'tour_id\')
									};
									$.ajax({
										type: "POST",
										url: path_ajax_script+"/index.php?mod=tour&act=ajGetFormEditTablePriceTitle",
										data: adata,
										dataType: "html",
										success: function(html){
											makepopup(300,\'\',html,\'frmEditTablePriceTitle\');
										}
									});	
								});
								$(\'.clickSaveTablePriceTitle\').live(\'click\',function(){
									var _this = $(this);
									var adata = {
										"clsTable" : \'Tour\',
										"pkey" : \'tour_id\',
										"pvalTable" :_this.attr(\'tour_id\'),
										"toField" : _this.attr(\'toField\'),
										"val" : $(\'#table_price_title\').val(),
										"allowDuplicate":\'1\'
									};
									$(\'.table_price_title\').text($(\'#table_price_title\').val());
									$.ajax({
										type: "POST",
										url: path_ajax_script+"/index.php?mod=tour&act=saveField",
										data: adata,
										dataType: "html",
										success: function(html){
											_this.closest(\'.frmPop\').find(\'.close_pop\').trigger(\'click\');
										}
									});
									return false;
								});
							});
						</script>
					</td>';
					for($k=0;$k<count($lstTourPriceCol);$k++){
						$html.= '
						<td class="gridheader" style="text-align:center">
							<a class="editTourPriceCol" tp="F" href="javascript:void(0);" data="'.$lstTourPriceCol[$k]['tour_price_col_id'].'">
								<strong>'.$lstTourPriceCol[$k]['title'].'</strong>
							</a>
						</td>';
					}
				$html.= '
					<td class="gridheader" style="width:80px;"></td>    
					<td class="gridheader" style="width:80px;"><strong>'.$core->get_Lang('func').'</strong></td>                              
				</tr>
			</thead>';
		if($lstTourPriceRow[0]['tour_price_row_id']!=''){
			for($i=0;$i<count($lstTourPriceRow);$i++){
				$html .= '
				<tr>
					<td style="text-align:left;">
						<a style="font-size:14px" title="'.$core->get_Lang('edit').'" class="editTourPriceRow" tp="F" href="#" data="'.$lstTourPriceRow[$i]['tour_price_row_id'].'">'.$lstTourPriceRow[$i]['title'].'</a>
					</td>';
					for($k=0;$k<count($lstTourPriceCol);$k++){
						$html.= '
						<td style="text-align:center;white-space:nowrap">
							<a class="editTourPriceVal" title="'.$core->get_Lang('edit').'" style="color:red; font-size:14px" tour_price_col_id="'.$lstTourPriceCol[$k]['tour_price_col_id'].'" tour_price_row_id="'.$lstTourPriceRow[$i]['tour_price_row_id'].'" href="#">
								'.$clsTourPriceVal->getPrice($lstTourPriceRow[$i]['tour_price_row_id'],$lstTourPriceCol[$k]['tour_price_col_id']).'
							</a>
						</td>'; 
					}			
					$html .= '
					<td style="text-align:center;">
						'.($i==0?'':'<a class="moveTourPriceRow" direct="up" data="'.$lstTourPriceRow[$i]['tour_price_row_id'].'" href="#"><span class="icon-arrow-up"></span></a>').'
						'.($i==count($lstTourPriceRow)-1?'':'<a class="moveTourPriceRow" direct="down" data="'.$lstTourPriceRow[$i]['tour_price_row_id'].'" href="#"><span class="icon-arrow-down"></span> </a>').'
					</td>
					<td style="text-align:center">
						<a class="editTourPriceRow" tp="F" data="'.$lstTourPriceRow[$i]['tour_price_row_id'].'" href="javascript:void(0);">
							<span class="icon-pencil"></span>
						</a>
						<a class="deleteTourPriceRow" tp="D" data="'.$lstTourPriceRow[$i]['tour_price_row_id'].'" href="javascript:void(0);">
							<span class="icon-remove"></span>
						</a>
					</td>
				</tr>';
			}
			$html .= '
			<tr>
				<td></td>';
				for($k=0;$k<count($lstTourPriceCol);$k++){
				$html.='
				<td style="text-align:center;">
					'.($k==0?'':'<a title="'.$core->get_Lang('moveleft').'" class="moveTourPriceCol" href="#" data="'.$lstTourPriceCol[$k]['tour_price_col_id'].'" direct="left"><span class="icon-chevron-left"></span></a>
					').'
					<a title="'.$core->get_Lang('edit').'" class="editTourPriceCol" tp="F" href="#" data="'.$lstTourPriceCol[$k]['tour_price_col_id'].'">
						<span class="icon-pencil"></span>
					</a>
					<a title="'.$core->get_Lang('delete').'" class="deleteTourPriceCol" tp="D" data="'.$lstTourPriceCol[$k]['tour_price_col_id'].'" href="#">
						<span class="icon-remove"></span>
					</a>
					'.($k==count($lstTourPriceCol)-1?'':'<a title="'.$core->get_Lang('moveright').'" class="moveTourPriceCol" href="#" data="'.$lstTourPriceCol[$k]['tour_price_col_id'].'" direct="right"><span class="icon-chevron-right"></span></a>
				').'
					</td>';
				}	
			$html.='<td colspan="2"></td></tr><tr></tr>';
		}
		$html .= '</table>';
	}
	$html .= '</div>';
	#
	echo($html);die();
}

function default_SiteTourPriceRow(){
	global $core, $clsISO, $_LANG_ID, $clsConfiguration;
	global $_loged_id;
	
	$clsTourPriceRow = new TourPriceRow();
	$tour_id = $_POST['tour_id'];
	$tour_price_row_id = isset($_POST['tour_price_row_id']) ? intval($_POST['tour_price_row_id']) : 0;
	$tp = $_POST['tp'];
	if($tp=='F'){
		$html = '
		<div class="headPop"> 
			<a id="clickToCloseNewTourPriceRow" href="javascript:void();" class="closeEv close_pop"></a> 
			<h3>'.($tour_price_row_id==0?$core->get_Lang('add'):$core->get_Lang('edit')).' '.$core->get_Lang('pricerow').'</h3> 
		</div>
		<div class="row-pan">
			<div class="fieldlabel-full">* '.$core->get_Lang('title').'</div>
			<div class="fieldarea-full mt5">
				<input type="text" id="titleRow" class="required text full fontLarge" style="width:95%" value="'.$clsTourPriceRow->getTitle($tour_price_row_id).'">
			</div>
		</div>
		<div class="modal-footer"> 
			<button class="btn btn-success submitClick btnSavePriceRow" data="'.$tour_price_row_id.'" tour_id="'.$tour_id.'" tp="S"><i class="icon-white icon-ok"></i> '.$core->get_Lang('add').'</button> 
			<button class="btn btn-warning close_pop" data-dismiss="modal" aria-hidden="true">'.$core->get_Lang('Close').'</button> 
		</div>';
		echo($html);die();
	}
	elseif($tp=='S'){
		$title = $_POST['title'];
		if($tour_price_row_id == 0){
			if($clsTourPriceRow->countItem("tour_id='$tour_id' and title='$title' LIMIT 0,1") > 0){
				echo '_EXIST'; die();
			}else{
				$f = "tour_id,user_id,title,order_no";
				$v = "'$tour_id','$_loged_id','".addslashes($title)."','".$clsTourPriceRow->getMaxOrderNo()."'";
				$clsTourPriceRow->insertOne($f,$v);
			}
			echo(1); die();
		}else{
			$clsTourPriceRow->updateOne($tour_price_row_id,"title='$title'");
			echo(1); die();
		}
	}
	elseif($tp=='D'){
		$clsTourPriceRow->deleteOne($tour_price_row_id);
		echo(1); die();
	}
	elseif($tp=='M'){
		$direct = $_POST['direct'];
		$one = $clsTourPriceRow->getOne($tour_price_row_id);
		$order_no = $one['order_no'];
		$tour_id = $one['tour_id'];
		
		if($direct=='up'){
			$lst = $clsTourPriceRow->getAll("tour_id='$tour_id' and order_no<$order_no order by order_no desc limit 0,1");
			$clsTourPriceRow->updateOne($tour_price_row_id,"order_no='".$lst[0]['order_no']."'");
			$clsTourPriceRow->updateOne($lst[0][$clsTourPriceRow->pkey],"order_no='".$order_no."'");
		}
		if($direct=='down'){
			$lst = $clsTourPriceRow->getAll("tour_id='$tour_id' and order_no>$order_no order by order_no asc limit 0,1");
			$clsTourPriceRow->updateOne($tour_price_row_id,"order_no='".$lst[0]['order_no']."'");
			$clsTourPriceRow->updateOne($lst[0][$clsTourPriceRow->pkey],"order_no='".$order_no."'");
		}
		echo(1); die();
	}
}
function default_SiteTourPriceCol(){
	global $core, $clsISO, $_LANG_ID, $clsConfiguration;
	global $_loged_id;
	
	$clsTourPriceCol = new TourPriceCol();
	$tour_id = $_POST['tour_id'];
	$tour_price_col_id = isset($_POST['tour_price_col_id']) ? intval($_POST['tour_price_col_id']) : 0;
	$tp = $_POST['tp'];
	if($tp=='F'){
		$html = '
		<div class="headPop"> 
			<a href="javascript:void();" class="closeEv close_pop"></a> 
			<h3>'.($tour_price_col_id==0?$core->get_Lang('add'):$core->get_Lang('edit')).' '.$core->get_Lang('pricecol').'</h3> 
		</div>
		<div class="row-pan">
			<div class="fieldlabel-full">* '.$core->get_Lang('title').'</div>
			<div class="fieldarea-full mt5">
				<input type="text" id="titleCol" class="required text full fontLarge" style="width:95%" value="'.$clsTourPriceCol->getTitle($tour_price_col_id).'">
			</div>
		</div>
		<div class="modal-footer"> 
			<button class="btn btn-success submitClick btnSavePriceCol" data="'.$tour_price_col_id.'" tour_id="'.$tour_id.'" tp="S"><i class="icon-white icon-ok"></i> '.$core->get_Lang('add').'</button> 
			<button class="btn btn-warning close_pop" data-dismiss="modal" aria-hidden="true">'.$core->get_Lang('Close').'</button> 
		</div>';
		echo($html);die();
	}
	elseif($tp=='S'){
		$title = $_POST['title'];
		if($tour_price_col_id == 0){
			if($clsTourPriceCol->countItem("tour_id='$tour_id' and title='$title' LIMIT 0,1") > 0){
				echo '_EXIST'; die();
			}else{
				$f = "tour_id,user_id,title,order_no";
				$v = "'$tour_id','$_loged_id','".addslashes($title)."','".$clsTourPriceCol->getMaxOrderNo()."'";
				$clsTourPriceCol->insertOne($f,$v);
			}
			echo(1); die();
		}else{
			$clsTourPriceCol->updateOne($tour_price_col_id,"title='$title'");
			echo(1); die();
		}
	}
	elseif($tp=='D'){
		$clsTourPriceCol->deleteOne($tour_price_col_id);
		echo(1); die();
	}
	elseif($tp=='M'){
		$direct = $_POST['direct'];
		$one = $clsTourPriceCol->getOne($tour_price_col_id);
		$order_no = $one['order_no'];
		$tour_id = $one['tour_id'];
		
		if($direct=='left'){
			$lst = $clsTourPriceCol->getAll("tour_id='$tour_id' and order_no<$order_no order by order_no desc limit 0,1");
			$clsTourPriceCol->updateOne($tour_price_col_id,"order_no='".$lst[0]['order_no']."'");
			$clsTourPriceCol->updateOne($lst[0][$clsTourPriceCol->pkey],"order_no='".$order_no."'");
		}
		if($direct=='right'){
			$lst = $clsTourPriceCol->getAll("tour_id='$tour_id' and order_no>$order_no order by order_no asc limit 0,1");
			$clsTourPriceCol->updateOne($tour_price_col_id,"order_no='".$lst[0]['order_no']."'");
			$clsTourPriceCol->updateOne($lst[0][$clsTourPriceCol->pkey],"order_no='".$order_no."'");
		}
		echo(1); die();
	}
}
function default_SiteTourPriceVal(){
	global $core, $clsISO, $_LANG_ID, $clsConfiguration;
	global $_loged_id;
	
	$clsTourProperty = new TourProperty();
	$clsTourPriceCol = new TourPriceCol();
	$clsTourPriceRow = new TourPriceRow();
	$clsTourPriceVal = new TourPriceVal();
	
	$tour_price_col_id = isset($_POST['tour_price_col_id'])? intval($_POST['tour_price_col_id']):0;
	$tour_price_row_id = isset($_POST['tour_price_row_id'])? intval($_POST['tour_price_row_id']):0;
	$tour_id = $_POST['tour_id'];
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	
	if($tp=='F'){
		$sql = "tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and tour_id='$tour_id'";
		$res =  $clsTourPriceVal->getAll($sql." limit 0,1");
		$html = '
		<div class="headPop"> 
			<a href="javascript:void();" class="closeEv close_pop"></a> 
			<h3>'.$core->get_Lang('editprice').'</h3> 
		</div>
		<div class="span100">
			<div class="row-span">
				<input type="text" name="title" class="text full required fontLarge" autocomplete="off" style="width:155px;" id="titleVal" value="'.$res[0]['price'].'" />'.$clsISO->getRate().'
				<br />
				Hoặc <a style="color:red;" class="ajCopyPriceCustomer" href="#" tour_price_row_id="'.$tour_price_row_id.'" tour_id="'.$tour_id.'" tour_price_col_id="'.$tour_price_col_id.'">copy từ giá gốc</a>
			</div>
		</div>
		<div class="modal-footer"> 
			<button class="btn btn-success clickToEditTourPriceVal" tour_price_row_id="'.$tour_price_row_id.'" tour_price_col_id="'.$tour_price_col_id.'">'.$core->get_Lang('save').'</button> 
			<button class="btn btn-warning close_pop" data-dismiss="modal" aria-hidden="true">'.$core->get_Lang('Close').'</button> 
		</div>';
		echo $html; die();
	}
	elseif($tp=='S'){
		$sql = "tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and tour_id='$tour_id'";
		$res =  $clsTourPriceVal->getAll($sql." limit 0,1");
		if(!$res[0]==''){
			$clsTourPriceVal->updateOne($res[0][$clsTourPriceVal->pkey],"price='".$clsISO->processSmartNumber($_POST['price'])."'");
		}else{
			$f = "tour_id,tour_price_row_id,tour_price_col_id,price";
			$v = "'".$tour_id."','".$tour_price_row_id."','".$tour_price_col_id."','".$clsISO->processSmartNumber($_POST['price'])."'";
			$clsTourPriceVal->insertOne($f,$v); 
		}
		echo(1); die();
	}
	else{
		
	}
}
function default_ajGetFormEditTablePriceTitle(){
	global $core, $_LANG_ID;
	$tour_id = $_POST['tour_id'];
	$clsTour = new Tour();
	#
	$html = '<div class="headPop"> 
		<a id="clickToCloseNewTourPriceRow" href="javascript:void();" class="closeEv close_pop"></a> 
		<h3><img align="absmiddle" src="'.URL_IMAGES.'/v2/edit_pencial.png"> '.$core->get_Lang('Edit Table Price Title').'</h3> 
	</div> 
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldlabel">'.$core->get_Lang('title').' <span class="required">*</span></td>
			<td class="fieldarea">
				<input type="text" id="table_price_title" class="text full" style="width:95%" value="'.$clsTour->getTablePriceTitle($tour_id).'">
			</td>
		</tr>
	</table>
	<div class="modal-footer"><button class="btn btn-success clickSaveTablePriceTitle" tour_id="'.$tour_id.'" toField="table_price_title">'.$core->get_Lang('save').'</button></div>';
	echo($html);die();
}

/* END TOUR_PRICE_SYSTEM */

function default_ajUpdateTourVr3(){
	global $core,$dbconn;
	#
	$clsTourStore = new TourStore();
	$_type = isset($_POST['_type'])?$_POST['_type']:'';
	$tour_id = isset($_POST['tour_id'])?$_POST['tour_id']:0;
	$val = isset($_POST['val'])?$_POST['val']:0;
	$user_id = $core->_USER['user_id'];
	#
	$sql = "select * from ".DB_PREFIX."tour_store where tour_id='$tour_id' and _type = '".$_type."' limit 0,1";
	$lst = $dbconn->GetAll($sql);
	if(isset($lst[0][$clsTourStore->pkey]) && $val==0) {
		$tour_store_id = $lst[0][$clsTourStore->pkey];
		$clsTourStore->deleteOne($tour_store_id);
	} else {
		$max_id = $clsTourStore->getMaxId();
		$max_order = $clsTourStore->getMaxOrder($_type);
		#
		$f = "tour_store_id,tour_id,_type,order_no";
		$v = "'$max_id','$tour_id','$_type','$max_order'";
		$clsTourStore->insertOne($f,$v);
	}
	echo 1; die();
}
function default_ajDeleteMultiItem(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav;
	#
	$clsTable = $_POST['clsTable'];
	$listID = isset($_POST['listID'])?$_POST['listID']:'';
	#
	$clsClassTable = new $clsTable();
	if($listID != '' && $listID != '0') {
		$temp = explode('|',$listID);
		if(is_array($temp) && count($temp) > 0){
			for($i=0; $i<count($temp); $i++){    
				$clsClassTable->deleteOne($temp[$i]);
			}
		}
	}
}
function default_saveField(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
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
	if($allowDuplicate==1){
		//allow duplicate
		$clsClassTable->updateOne($pvalTable,$toField."='".addslashes($val)."'");
		$html = $val;
	}
	else{
		$all = $clsClassTable->getAll($toField."='$val'");
		if($all[0][$pkey]!='' && $all[0][$pkey]!=$pvalTable){
			$html = 'IsDuplicated';
		}else{
			$clsClassTable->updateOne($pvalTable,$toField."='".addslashes($val)."'");
			$html = $val;
		}
	}
	#
	echo($html); die();
}
function default_ajGetSearch(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsTour = new Tour();
	$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
	$tour_id = isset($_POST['tour_id'])? intval($_POST['tour_id']) : 0;
	$tp = isset($_POST['tp'])? $_POST['tp'] : '';
	$html = '';
	#
	$where = "is_trash=0";
	if(trim($keyword) !='' && $keyword != '0'){
		$slug = $core->replaceSpace($keyword);
		$where .= " and (title like '%$keyword%' or slug like '%$slug%')";
	}
	if($tp=='_PROMOTION'){
	}
	if($tp=='_TOP'){
	}
	$limit = " limit 0,1000";
	#
	$lstItem = $clsTour->getAll($where.$limit);
	if(is_array($lstItem) && count($lstItem) > 0){
		foreach($lstItem as $k=>$v){
			$html.='
			<li class="clickChooiseTour" tp="'.$tp.'" data="'.$v[$clsTour->pkey].'" type="add">
				<a href="javascript:void(0);" title="Click để chọn tin này">'.$clsTour->getTitle($v[$clsTour->pkey]).'</a>	
			</li>';
		}
	}else{
		$html .= '_EMPTY';
	}
	echo $html; die();
}
function default_ajDuplicateTour(){
	global $clsISO,$core;
	#
	$user_id = $core->_USER['user_id'];
	$tour_id_duplicate = $_POST['tour_id'];
	
	$html = '';
	
	#Duplicate Tour table--------------------------
	$clsTour = new Tour();
	$oneTour = $clsTour->getOne($tour_id_duplicate);
	$tour_id = $clsTour->getMaxID();
	$max_tour_order = $clsTour->getMaxOrderNo();
	$fx = "tour_id,order_no";
	$vx= "'$tour_id','$max_tour_order'";
	foreach($oneTour as $key=>$value){ 
		if(intval($key)==0 && $key!=$clsTour->pkey && $key!='order_no'){
			$fx .= ",".$key;
			if($key=='user_id')
				$vx .= ",'$user_id'";
			elseif($key=='is_online')
				$vx .= ",0";
			elseif($key=='title')
				$vx .= ",'".addslashes($value)."-DUP'";
			elseif($key=='slug')
				$vx .= ",'".addslashes($value).$core->replaceSpace('-DUP')."'";
			elseif($key=='trip_code')
				$vx .= ",'".addslashes($value)."-DUP'";
			else
				$vx .= ",'".addslashes($value)."'";
		}
	}
	$clsTour->insertOne($fx,$vx);
	#End Duplicate Tour Table--------------------------
	#Duplicate Tour Custom Field Table------------------------------
	$clsTourCustomField = new TourCustomField();
	$lstTourCustomField = $clsTourCustomField->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourCustomField[0][$clsTourCustomField->pkey]!=''){
		for($i=0;$i<count($lstTourCustomField);$i++){
			$oneItem = $lstTourCustomField[$i];
			$max_item_id = $clsTourCustomField->getMaxID();
			$fx = "$clsTourCustomField->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsTourCustomField->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourCustomField->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			} 
			$clsTourCustomField->insertOne($fx,$vx); 
		}
	} unset($clsTourCustomField);
	#End Duplicate Tour Custom Field Table--------------------------
	#Duplicate Tour Extension Table------------------------------
	$clsTourExtension = new TourExtension();
	$lstTourExtension = $clsTourExtension->getAll("tour_1_id='$tour_id_duplicate'");
	if($lstTourExtension[0][$clsTourExtension->pkey]!=''){
		for($i=0;$i<count($lstTourExtension);$i++){
			$oneItem = $lstTourExtension[$i];
			$max_item_id = $clsTourExtension->getMaxID();
			$fx = "$clsTourExtension->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsTourExtension->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourExtension->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='tour_1_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			} 
			$clsTourExtension->insertOne($fx,$vx); 
		}
	} unset($clsTourExtension);
	#End Duplicate Tour Extension Table--------------------------
	#Duplicate Tour Hotel Table------------------------------
	$clsTourHotel = new TourHotel();
	$lstTourHotel = $clsTourHotel->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourHotel[0][$clsTourHotel->pkey]!=''){
		for($i=0;$i<count($lstTourHotel);$i++){
			$oneItem = $lstTourHotel[$i];
			$max_item_id = $clsTourHotel->getMaxID();
			$fx = "$clsTourHotel->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsTourHotel->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourHotel->pkey && $key!='order_no'){
					$f .= ",".$key;
					if($key=='tour_id')
						$v .= ",'$tour_id'";
					else
						$v .= ",'".addslashes($value)."'";
				}
			}  
			$clsTourHotel->insertOne($f,$v); 
		}
	} unset($clsTourHotel);
	#End Duplicate Tour Hotel table------------------------------
	#Duplicate Tour Images Table------------------------------
	$clsTourImage = new TourImage();
	$lstImage = $clsTourImage->getAll("table_id='$tour_id_duplicate'");
	if($lstImage[0][$clsTourImage->pkey]!=''){
		for($i=0;$i<count($lstImage);$i++){
			$oneItem = $lstImage[$i];
			$max_item_id = $clsTourImage->getMaxID();
			$fx = "$clsTourImage->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsTourImage->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourImage->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='table_id')
						$vx .= ",'$tour_id'";
					elseif($key=='is_online')
						$vx .= ",0";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			} 
			$clsTourImage->insertOne($fx,$vx); 
		}
	} unset($clsTourImage);
	#End Duplicate Tour Images Table--------------------------
	#Duplicate Tour Itinerary Table------------------------------
	$clsTourItinerary = new TourItinerary();
	$lstItinerary = $clsTourItinerary->getAll("tour_id='$tour_id_duplicate'");
	if($lstItinerary[0][$clsTourItinerary->pkey]!=''){
		for($i=0;$i<count($lstItinerary);$i++){
			$oneItem = $lstItinerary[$i];
			$max_item_id = $clsTourItinerary->getMaxID();
			$fx = "$clsTourItinerary->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsTourItinerary->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourItinerary->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					elseif($key=='is_online')
						$vx .= ",0";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			} 
			$clsTourItinerary->insertOne($fx,$vx); 
		}
	} unset($clsTourItinerary);
	#End Duplicate Tour Itinerary Table--------------------------
	#Duplicate Tour Price Cat Table------------------------------
	$clsTourPriceCat = new TourPriceCat();
	$lstTourPriceCat = $clsTourPriceCat->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourPriceCat[0][$clsTourPriceCat->pkey]!=''){
		for($i=0;$i<count($lstTourPriceCat);$i++){
			$oneItem = $lstTourPriceCat[$i];
			$max_item_id = $clsTourPriceCat->getMaxID();
			$fx = "$clsTourPriceCat->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsTourPriceCat->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourPriceCat->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			} 
			$clsTourPriceCat->insertOne($fx,$vx); 
		}
	} unset($clsTourPriceCat);
	#End Duplicate Tour Price Cat Table--------------------------
	#Duplicate Tour Price Age Type Table------------------------------
	$clsTourPriceAgeType = new TourPriceAgeType();
	$lstTourPriceAgeType = $clsTourPriceAgeType->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourPriceAgeType[0][$clsTourPriceAgeType->pkey]!=''){
		for($i=0;$i<count($lstTourPriceAgeType);$i++){
			$oneItem = $lstTourPriceAgeType[$i];
			$max_item_id = $clsTourPriceAgeType->getMaxID();
			$fx = "$clsTourPriceAgeType->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsTourPriceAgeType->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourPriceAgeType->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			} 
			$clsTourPriceAgeType->insertOne($fx,$vx); 
		}
	} unset($clsTourPriceAgeType);
	#End Duplicate Tour Price Age Type Table--------------------------
	#Duplicate Tour Price Customer Type Table------------------------------
	$clsTourPriceCustomerType = new TourPriceCustomerType();
	$lstTourPriceCustomerType = $clsTourPriceCustomerType->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourPriceCustomerType[0][$clsTourPriceCustomerType->pkey]!=''){
		for($i=0;$i<count($lstTourPriceCustomerType);$i++){
			$oneItem = $lstTourPriceCustomerType[$i];
			$max_item_id = $clsTourPriceCustomerType->getMaxID();
			$fx = "$clsTourPriceCustomerType->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsTourPriceCustomerType->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourPriceCustomerType->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			} 
			$clsTourPriceCustomerType->insertOne($fx,$vx); 
		}
	} unset($clsTourPriceCustomerType);
	#End Duplicate Tour Price Age Type Table--------------------------
	#Duplicate Tour Price Col Table------------------------------
	$clsTourPriceCol = new TourPriceCol();
	$lstTourPriceCol = $clsTourPriceCol->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourPriceCol[0][$clsTourPriceCol->pkey]!=''){
		for($i=0;$i<count($lstTourPriceCol);$i++){
			$oneItem = $lstTourPriceCol[$i];
			$fx = "$clsTourPriceCol->pkey,order_no";
			$vx = "'".$clsTourPriceCol->getMaxID()."','".$clsTourPriceCol->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourPriceCol->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}
			$clsTourPriceCol->insertOne($fx,$vx); 
		}
	} unset($clsTourPriceCol);
	#End Duplicate Tour Price Col table------------------------------
	#Duplicate Tour Price Row Table------------------------------
	$clsTourPriceRow = new TourPriceRow();
	$lstTourPriceRow = $clsTourPriceRow->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourPriceRow[0][$clsTourPriceRow->pkey]!=''){
		for($i=0;$i<count($lstTourPriceRow);$i++){
			$oneItem = $lstTourPriceRow[$i];
			$fx = "".$clsTourPriceRow->pkey.",order_no";
			$vx = "'".$clsTourPriceRow->getMaxID()."','".$clsTourPriceRow->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourPriceRow->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}  
			$clsTourPriceRow->insertOne($fx,$vx); 
		}
	} unset($clsTourPriceRow);
	#End Duplicate Tour Price Row table------------------------------
	#Duplicate Tour Price Val Table------------------------------
	$clsTourPriceVal = new TourPriceVal();
	$lstTourPriceVal = $clsTourPriceVal->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourPriceVal[0][$clsTourPriceVal->pkey]!=''){
		for($i=0;$i<count($lstTourPriceVal);$i++){
			$oneItem = $lstTourPriceVal[$i];
			$fx = "".$clsTourPriceVal->pkey."";
			$vx = "'".$clsTourPriceVal->getMaxID()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourPriceVal->pkey){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}  
			$clsTourPriceVal->insertOne($fx,$vx); 
		}
	} unset($clsTourPriceVal);
	#End Duplicate Tour Price Val Table------------------------------
	#Duplicate Tour Price Unit Table------------------------------
	$clsTourPriceUnit = new TourPriceUnit();
	$lstTourPriceUnit = $clsTourPriceUnit->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourPriceUnit[0][$clsTourPriceUnit->pkey]!=''){
		for($i=0;$i<count($lstTourPriceUnit);$i++){
			$oneItem = $lstTourPriceUnit[$i];
			$fx = "".$clsTourPriceUnit->pkey."";
			$vx = "'".$clsTourPriceUnit->getMaxID()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourPriceUnit->pkey){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}  
			$clsTourPriceUnit->insertOne($fx,$vx); 
		}
	} unset($clsTourPriceUnit);
	#End Duplicate Tour Price Unit Table------------------------------
	#Duplicate Tour Destination table------------------------------
	$clsTourDestination = new TourDestination();
	$lstTourDestination = $clsTourDestination->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourDestination[0][$clsTourDestination->pkey]!=''){
		for($i=0;$i<count($lstTourDestination);$i++){
			$oneItem = $lstTourDestination[$i];
			$max_item_id = $clsTourDestination->getMaxID();
			$fx = "$clsTourDestination->pkey,order_no";
			$vx = "'".$max_item_id."','".$clsTourDestination->getMaxOrderNo($tour_id)."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourDestination->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}  
			$clsTourDestination->insertOne($fx,$vx); 
		}
	}
	#End Duplicate Tour Destination Table------------------------------
	#Duplicate Tour Review Table------------------------------
	/*$clsReviews = new Reviews();
	$lstReviews = $clsReviews->getAll("tour_id='$tour_id_duplicate'");
	if($lstReviews[0][$clsReviews->pkey]!=''){
		for($i=0;$i<count($lstReviews);$i++){
			$oneItem = $lstReviews[$i];
			$fx = "".$clsReviews->pkey.",order_no";
			$vx = "'".$clsReviews->getMaxID()."','".$clsReviews->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsReviews->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}  
			$clsReviews->insertOne($fx,$vx); 
		}
	} unset($clsReviews);
	#End Duplicate Tour Review Table------------------------------*/
	#Duplicate Tour Season Price Table------------------------------
	$clsTourSeasonPrice = new TourSeasonPrice();
	$lstTourSeasonPrice = $clsTourSeasonPrice->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourSeasonPrice[0][$clsTourSeasonPrice->pkey]!=''){
		for($i=0;$i<count($lstTourSeasonPrice);$i++){
			$oneItem = $lstTourSeasonPrice[$i];
			$fx = "".$clsTourSeasonPrice->pkey."";
			$vx = "'".$clsTourSeasonPrice->getMaxID()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourSeasonPrice->pkey){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}  
			$clsTourSeasonPrice->insertOne($fx,$vx); 
		}
	} unset($clsTourSeasonPrice);
	#End Duplicate Tour Season Price Table------------------------------
	#Duplicate Tour Start Date Table------------------------------
	$clsTourStartDate = new TourStartDate();
	$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourStartDate[0][$clsTourStartDate->pkey]!=''){
		for($i=0;$i<count($lstTourStartDate);$i++){
			$oneItem = $lstTourStartDate[$i];
			$fx = "".$clsTourStartDate->pkey."";
			$vx = "'".$clsTourStartDate->getMaxID()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourStartDate->pkey){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}  
			$clsTourStartDate->insertOne($fx,$vx); 
		}
	} unset($clsTourStartDate);
	#End Duplicate Tour Start Date Table------------------------------
	#Duplicate Tour Store Table------------------------------
	$clsTourStore = new TourStore();
	$lstTourStore = $clsTourStore->getAll("tour_id='$tour_id_duplicate'");
	if($lstTourStore[0][$clsTourStore->pkey]!=''){
		for($i=0;$i<count($lstTourStore);$i++){
			$oneItem = $lstTourStore[$i];
			$fx = "".$clsTourStore->pkey.",order_no";
			$vx = "'".$clsTourStore->getMaxID()."','".$clsTourStore->getMaxOrderNo()."'";
			foreach($oneItem as $key=>$value){ 
				if(intval($key)==0 && $key!=$clsTourStore->pkey && $key!='order_no'){
					$fx .= ",".$key;
					if($key=='tour_id')
						$vx .= ",'$tour_id'";
					else
						$vx .= ",'".addslashes($value)."'";
				}
			}  
			$clsTourStore->insertOne($fx,$vx); 
		}
	} unset($clsTourStore);
	#End Duplicate Tour Store Table------------------------------
	
	$html = PCMS_URL.'/index.php?mod=tour&act=edit&'.$clsTour->pkey.'='.$core->encryptID($tour_id);
	echo($html);die();
}
/*------ Tour Hotels -------*/
function default_ajaxSaveTourHotel(){
	global $core, $_LANG_ID;
	$user_id = $core->_USER['user_id'];
	#
	$clsTourHotel = new TourHotel();
	$clsHotel = new Hotel();
	$tour_id = intval($_POST['tour_id']);
	$tour_itinerary_id = intval($_POST['tour_itinerary_id']);
	$list_id = trim($_POST['list_id']);
	
	if($list_id != ''){
		$list_id = rtrim($list_id,'|');
		$list_id = ltrim($list_id,'|');
		$temp = explode('|',$list_id);
		if(is_array($temp) && count($temp)>0){
			//$clsTourHotel->deleteByCond("tour_id='$tour_id' and itinerary_id='$itinerary_id'");
			for($i=0; $i<count($temp); $i++){
				$tour_hotel_id = $clsTourHotel->getMaxId();
				$order_no = $clsTourHotel->getMaxOrderNo();
				$hotel_id = $temp[$i];
				$f = "tour_hotel_id,user_id,user_id_update,tour_id,tour_itinerary_id,hotel_id,reg_date,upd_date,order_no";
				$v = "'$tour_hotel_id','$user_id','$user_id','$tour_id','$tour_itinerary_id','$hotel_id','".time()."','".time()."','".$order_no."'";
				$clsTourHotel->insertOne($f, $v);
			}
			echo '_SUCCESS'; die();
		}else{
			echo '_EMPTY'; die();
		}
	}else{
		echo '_EMPTY'; die();
	}
}
/*------ Tour Hotels -------*/
function default_ajaxSelectHotelCountry(){
	global $_LANG_ID, $core, $clsISO;
	#
	$clsCountry = new Country();
	$continent_id = $_POST['continent_id'];
	$Html = $clsCountry->makeSelectboxOption('', $continent_id,'HOTEL');
	echo $Html; die();
}
function default_ajmakeSelectCityHotelGlobal(){
	$clsHotel = new Hotel();
	$clsCity = new City();
	#
	$country_id = isset($_POST['country_id'])?$_POST['country_id']:0;
	#
	$cond = "is_trash=0 and city_id IN (SELECT city_id FROM default_hotel WHERE is_trash=0 and is_online=1)";
	if(isset($country_id) && intval($country_id)>0) {$cond.= " and country_id='$country_id'";}
	$cond.= " order by title asc";
	#
	$lstCity = $clsCity->getAll($cond);
	$html = '<option value="">-- Tỉnh/TP --</option>';
	if(!empty($lstCity)){
		foreach($lstCity as $item){
			$html.='<option value="'.$item[$clsCity->pkey].'">'.$clsCity->getTitle($item[$clsCity->pkey]).'</option>';
		}
	}
	echo $html; die();
}
function default_ajaxLoadHotelItinerary(){
	global $_LANG_ID, $core;
	$clsHotel = new Hotel();
	$clsTourHotel = new TourHotel();
	#
	$tour_id = $_POST['tour_id'];
	$tour_itinerary_id = $_POST['tour_itinerary_id'];
	#
	$lstItem=$clsTourHotel->getAll("tour_id='$tour_id' and tour_itinerary_id='$tour_itinerary_id' order by order_no ASC",$clsTourHotel->pkey.",hotel_id");
	if(is_array($lstItem) && count($lstItem)>0){
		$html = '';
		for($i=0; $i<count($lstItem);$i++){
			$html.= '<span class="hotelitem">';
			$html.='<strong>'. $clsHotel->getTitle($lstItem[$i][$clsHotel->pkey]).'</strong>';
			$html.='<a class="remove btn_delete_hotel_itinerary" _tour_id="'.$tour_id.'" _tour_itinerary_id="'.$tour_itinerary_id.'" data="'.$lstItem[$i][$clsTourHotel->pkey].'" tp="pop">x</a>';
			$html.='</span>';
			$html.= ($i==count($lstItem)-1)?'':', ';
		}
		echo $html; die();
	}else{
		echo '<strong class="color_r">'.$core->get_Lang('nodata').'</strong>'; die();
	}
}
function default_ajaxGetBoxHotelRecommend(){
	global $assign_list,$_CONFIG,$_SITE_ROOT,$mod,$_LANG_ID,$act,$current_page,$core,$clsModule,$clsButtonNav,$dbconn,$clsISO,$clsConfiguration;
	#
	$clsPagination = new Pagination();
	$clsCountry = new Country();
	$clsHotel = new Hotel();
	$clsTour = new Tour();
	$clsContinent = new Continent();
	#
	$tour_hotel_id = isset($_POST['tour_hotel_id'])?$_POST['tour_hotel_id']:0;
	$tour_itinerary_id = isset($_POST['tour_itinerary_id'])?$_POST['tour_itinerary_id']:0;
	$tour_id = isset($_POST['tour_id'])?$_POST['tour_id']:0;
	$tour_type_id = isset($_POST['tour_type_id'])?$_POST['tour_type_id']:'';
	#
	$where="is_trash=0";
	$where.=" and hotel_id NOT IN(SELECT hotel_id FROM default_tour_hotel WHERE tour_id='$tour_id' and tour_itinerary_id='$tour_itinerary_id')";
	$order_by = " order by order_no desc";
	#
	$page = isset($_POST['page']) ? intval($_POST['page']): 1;
	$number_per_page = isset($_POST['number_per_page']) ? intval($_POST['number_per_page']):10;
	$totalRecord = $clsHotel->countItem($where);
	$pageview = $clsPagination->pagination_ajax($totalRecord,$number_per_page,1);
	$offset = ($page-1)*$number_per_page;
	$lstHotel = $clsHotel->getAll($where.$order_by." limit $offset,$number_per_page");
	#
	$html='';
	$html.='
		<style type="text/css">.dataTable_length{display:none !important}</style>
		<div class="headPop"> 
			<a href="javascript:void();" class="closeEv close_pop"></a> 
			<h3>'.$core->get_Lang('List hotel in system').'</h3>
		</div>';
	$html.='<div class="wrap"><div class="searchbox fl" style="width:100%">';
	if($tour_type_id == 2 && $clsConfiguration->getValue('SiteModActive_continent') and $core->checkAccess('continent') && $clsConfiguration->getValue('SiteModActive_country') and $core->checkAccess('country')) {
		$html.='<select class="fl slb mr5" name="continenthotel_id" style="width:160px">'.$clsContinent->makeSelectboxOption().'</select>';
	}
	if($clsConfiguration->getValue('SiteModActive_country')) {
		$html.='<select class="fl slb mr5 country_id" name="countryhotel_id" style="width:160px">';
		$html.= $clsCountry->makeSelectboxOption(0,0,'HOTEL');
		$html.='</select>';
	} else {
		$html.='<script type="text/javascript">$().ready(function(){loadCityHotelList();});</script>';
	}
	$html.='<select class="fl slb mr5" name="cityhotel_id" style="width:160px">
				<option>-- '.$core->get_Lang('city').' --</option>
			</select>
			<input type="text" class="fl text mr5" name="keypop" placeholder="'.$core->get_Lang('search').'" style="width:160px;">
			<a href="javascript:void();" class="btn btn-success searchpop">
				<i class="icon-search icon-white"></i>
			</a>
		</div>
	</div>
	<div class="clear"><br/></div>';
	$html.='<div class="contentPop">';
	$html.='<style>.tbl-grid td{ padding:8px !important;}</style>
	<table class="tbl-grid" width="100%">
	<thead>
		<tr>
			<td class="gridheader"><input type="checkbox" id="check_all">
				<input type="hidden" id="list_selected_chkitem">
			</td>
			<td width="42%" class="gridheader" style="text-align:left"><strong>'.$core->get_Lang('nameofhotels').'</strong></td>
			<td class="gridheader" style="text-align:left"><strong>'.$core->get_Lang('Address').'</strong></td>
			<td width="3%" class="gridheader"><i class="icon-eye-open"></i></td>
		</tr>
	</thead>
	<tbody id="tblHolderHotel">';
	
	if(!empty($lstHotel)){
		for($i=0;$i<count($lstHotel);$i++){
			$html.='<tr class="'.($i%2==0?'row1':'row2').'">';
			$html.='
			<td class="index"><input value="'.$lstHotel[$i][$clsHotel->pkey].'" class="chkitem" type="checkbox" /></td>';
			$html.='<td>
				<a href="javascript:void(0);" style="font-size:16px; font-weight:bold;">'.$clsHotel->getTitle($lstHotel[$i][$clsHotel->pkey]).'</a>
				</td>';
			$html.='<td>'.$clsHotel->getAddress($lstHotel[$i][$clsHotel->pkey]).'</td>
					<td width="3%"><a href="'.DOMAIN_NAME.$clsHotel->getLink($lstHotel[$i][$clsHotel->pkey]).'" target="_blank"><i class="icon-eye-open"></i></a></td>';	
			$html.='</tr>';
		}
		unset($lstHotel);
		unset($clsHotel);
	}
	$html.='
		</tbody></table>
		<div class="clear"><br /></div>
	</div>
	<div class="pagination_box">
		<div class="wrap" id="dataTable_paginate">'.$pageview.'</div>
	</div>';
	$html.='
	<div class="bottom">
		<input type="hidden" id="hid_tour_id" value="'.$tour_id.'" />
		<input type="hidden" id="hid_itinerary_id" value="'.$tour_itinerary_id.'" />
		<a href="javascript:void();" tour_hotel_id="'.$tour_hotel_id.'" tour_id="'.$tour_id.'" tour_itinerary_id="'.$tour_itinerary_id.'" class="iso-button-primary fl btnChooiseHotel"><i class="icon-check icon-white"></i> '.$core->get_Lang('save').'</a>
		<a class="iso-button-standard close_pop fr"><i class="icon icon-cancel"></i> '.$core->get_Lang('close').'</a></div>
	</div>';
	echo $html; die();
}
function default_ajaxLoadListHotel(){
	global $_LANG_ID, $core, $clsISO;
	$clsPagination = new Pagination();
	$clsHotel = new Hotel();
	$html='';
	#
	$continent_id = isset($_POST['continent_id'])?intval($_POST['continent_id']):'';
	$country_id = isset($_POST['country_id'])?intval($_POST['country_id']):'';
	$city_id = isset($_POST['city_id'])?intval($_POST['city_id']):'';
	$star = isset($_POST['star'])?intval($_POST['star']):'';
	$keyword = isset($_POST['keyword']) ? trim(strip_tags($_POST['keyword'])):'';
	$tour_id = $_POST['tour_id'];
	$tour_itinerary_id = $_POST['tour_itinerary_id'];
	$page = isset($_POST['page']) && intval($_POST['page'])>0 ? intval($_POST['page']): 1;
	$number_per_page = isset($_POST['number_per_page']) && intval($_POST['number_per_page'])?intval($_POST['number_per_page']):10;
	#
	$where = "is_trash=0";
	if(intval($continent_id)>0){
		$where .=" and continent_id='$continent_id'";
	}
	if(intval($country_id)>0){
		$where .=" and country_id='$country_id'";
	}
	if(intval($city_id)>0){
		$where .=" and city_id='$city_id'";
	}
	if(intval($star)>0){
		$where .=" and star='$star'";
	}
	if($keyword!=''){
		$slug = $core->replaceSpace($keyword);
		$where.=" and slug like '%".$slug."%'";
	}

	$where.=" and hotel_id NOT IN(SELECT hotel_id FROM ".DB_PREFIX."tour_hotel WHERE tour_id='$tour_id' and tour_itinerary_id='$tour_itinerary_id')";
	/**/
	$totalRecord = $clsHotel->countItem($where);
	$pageview = $clsPagination->pagination_ajax($totalRecord,$number_per_page,$page);
	$offset = ($page-1)*$number_per_page;
	$where .= " order by order_no DESC";
	$limit = " LIMIT $offset,$number_per_page";
	$lstHotel = $clsHotel->getAll($where.$limit);
	#
	if(is_array($lstHotel) && count($lstHotel)>0){
		for($i=0; $i<count($lstHotel); $i++){
			$html.='<tr class="'.($i%2==0?'row1':'row2').'">';
			$html.='
			<td class="index"><input value="'.$lstHotel[$i][$clsHotel->pkey].'" class="chkitem" type="checkbox" /></td>';
			$html.='<td>
				<a href="javascript:void(0);" style="font-size:16px; font-weight:bold;">'.$clsHotel->getTitle($lstHotel[$i][$clsHotel->pkey]).'</a>
				</td>';
			$html.='<td>'.$clsHotel->getAddress($lstHotel[$i][$clsHotel->pkey]).'</td>
					<td width="3%"><a href="'.DOMAIN_NAME.$clsHotel->getLink($lstHotel[$i][$clsHotel->pkey]).'" target="_blank"><i class="icon-eye-open"></i></a></td>';	
			$html.='</tr>';
		}
	}else{
		$html.='<tr>
			<td colspan="6">
				<div class="infobox">
					<b>'.$core->get_Lang('warning').'</b> <br/> '.$core->get_Lang('nodata').'
				</div>
			</td>
		</tr>';
	}
	unset($totalRecord);
	unset($lstHotel);
	unset($clsHotel);
	unset($clsPagination);
	unset($_lang);
	echo $html.'$$'.$pageview; die();
}
function default_ajaxDeleteHotelItinerary(){
	global $_LANG_ID, $core;
	$clsTourHotel = new TourHotel();
	$tour_hotel_id = $_POST['tour_hotel_id'];
	#
	$clsTourHotel->deleteOne($tour_hotel_id);
	echo(1); die();
}
/*------ TourPriceUnitStartDate -------*/
function default_ajLoadTourPriceUnitStartDate(){
	global $core,$clsISO,$clsConfiguration;
	$clsTour = new Tour();
	$clsTourPriceAgeType = new TourPriceAgeType();
	$clsTourPriceCustomerType = new TourPriceCustomerType();
	$clsTourPriceUnit = new TourPriceUnit();
	$clsTourStartDate = new TourStartDate();

	$clsProperty = new Property(); $assign_list["clsProperty"] = $clsProperty;
	$clsTourProperty = new TourProperty(); $assign_list["clsTourProperty"] = $clsTourProperty;
	$clsTourPriceRow = new TourPriceRow(); $assign_list["clsTourPriceRow"] = $clsTourPriceRow;
	$clsTourPriceCol = new TourPriceCol(); $assign_list["clsTourPriceCol"] = $clsTourPriceCol;
	$clsTourPriceVal = new TourPriceVal(); $assign_list["clsTourPriceVal"] = $clsTourPriceVal;
	#
	$tour_id = $_POST['tour_id'];
	$is_agent = isset($_POST['is_agent']) ? $_POST['is_agent'] : '0';
	
	$lstNationality = $clsTourProperty->getAll("is_trash=0 and type='NATIONALITY' order by order_no asc");
	$lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc");
	

	$lstAgeType = $clsTourPriceAgeType->getAll("tour_id='$tour_id' and is_trash=0 order by age_type_id asc");
	$lstCustomerType = $clsTourPriceCustomerType->getAll("tour_id='$tour_id' and is_trash=0 order by customer_type_id asc");
	#

	$html = '';
	if($is_agent!=''){
		$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and is_agent='$is_agent' order by start_date asc");
	}else{
		$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and is_agent<>1 order by start_date asc");
	}
	if($lstTourStartDate[0][$clsTourStartDate->pkey]!=''){
		$html .= '<p class="mb10" style="font-size:18px; display:inline-block; line-height:30px; vertical-align:top">'.$core->get_Lang('List departure date').'</p>
		<a href="javascript:void(0);" title="Gird" class="clickSortDepartureDateGird"></a>
		<a href="javascript:void(0);" title="List" class="clickSortDepartureDateList"></a>
		
		<br style="clear:both;" /><br style="clear:both;" />
		
		<div id="holderAllTourStartDateList" style="width:100%; display:none">
		<table cellspacing="0" width="100%">
		<tr>
		<td style="padding:0 5px; text-align:center; border: 1px solid #ccc;" rowspan="2">'.$core->get_Lang('Departure date').'</td>
		<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;" rowspan="2">'.$core->get_Lang('Trip code').'</td>
		<td style="padding:5px 5px; text-align:center; border: 1px solid #ccc;" colspan="4">'.$core->get_Lang('Price').'</td>
		<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;" rowspan="2">'.$core->get_Lang('Function').'</td>
		</tr>
		<tr>
		<td style="padding:5px 5px; text-align:center;border: 1px solid #ccc;">'.$core->get_Lang('Adults').'</td>
		<td style="padding:5px 5px; text-align:center;border: 1px solid #ccc;">'.$core->get_Lang('Child').'</td>
		<td style="padding:5px 5px; text-align:center;border: 1px solid #ccc;">'.$core->get_Lang('Ifant').'</td>
		
		</tr>
		';
		for($m=0;$m<count($lstTourStartDate);$m++){
		$tour_start_date_id = $lstTourStartDate[$m][$clsTourStartDate->pkey];
		$start_date = $lstTourStartDate[$m]['start_date'].'';
		$html .= '
		<tr style="'.($m%2==0?'background:#eee':'background:#fff').'">
			<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.date('d/m',$lstTourStartDate[$m]['start_date']).'</td>
			<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$clsTourStartDate->getTripCode($tour_start_date_id).'</td>';
			if($lstVisitorType[0]['tour_property_id']!=''){
			for($i=0;$i<count($lstVisitorType);$i++){
				$html .= '
			<td style="padding:5px 5px; text-align:center;border: 1px solid #ccc;">
			'.$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency')).' <input id="price_adult1'.$m.''.$lstVisitorType[$i]['tour_property_id'].''.$lstNationality[$k]['tour_property_id'].'" class="text tour_season_price_newversion fontLarge" style="width:60%; text-align:right; color:red;" departure="'.$lstTourStartDate[$m]['start_date'].'"  tour_property_idc="'.$lstNationality[$k]['tour_property_id'].'" tour_property_idr="'.$lstVisitorType[$i]['tour_property_id'].'" tour_id="'.$tour_id.'" and is_agent='.$is_agent.'  value="'.$clsTourPriceVal->getTripPriceOption($lstVisitorType[$i]['tour_property_id'],$lstNationality[$k]['tour_property_id'],$lstTourStartDate[$m]['start_date'],$tour_id,$is_agent).'" type="text" /> </td>';
			}}
			$html .= '<td style="padding:5px 5px; text-align:center;border: 1px solid #ccc;">
			'.$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency')).' <input class="text tour_season_price_newversion fontLarge" id="advertisedPrice1'.$m.'" style="width:60%; text-align:right; color:red;" departure="'.$lstTourStartDate[$m]['start_date'].'"  tour_property_idc="0" tour_property_idr="0" tour_id="'.$tour_id.'"  value="'.$clsTourPriceVal->getTripPriceOption(0,0,$lstTourStartDate[$m]['start_date'],$tour_id,$is_agent).'" and is_agent='.$is_agent.'  type="text" /> </td>
			<script type="text/javascript">
				var price_adult1 = parseInt($("#price_adult1'.$m.'16").val());
				var  priceAdDepart1 = $("#advertisedPrice1'.$m.'");
				priceAdDepart1.change(function(){
					if(!isNaN(parseInt($(this).val()))){
						if(parseInt($(this).val()) >= parseInt($("#price_adult1'.$m.'16").val())){
						}else{
							alert("Input data is invalid");
							$(this).val(parseInt($("#price_adult1'.$m.'16").val()));
						}
					}
				});
				var price_advert1 = parseInt($("#advertisedPrice1'.$m.'").val());
				var priceAdult1 = $("#price_adult1'.$m.'16");
				priceAdult1.change(function(){
					if(parseInt($("#advertisedPrice1'.$m.'").val())>0){
						if(!isNaN(parseInt($(this).val()))){
							if(parseInt($(this).val()) <= parseInt($("#advertisedPrice1'.$m.'").val())){
							}else{
								alert("Input data is invalid");
								$(this).val(parseInt($("#advertisedPrice1'.$m.'").val()));
							}
						}
					}
				});
			</script>		
			';
			$html .= '<td style="padding:5px 5px; text-align:center;border: 1px solid #ccc;"><a title="'.$core->get_Lang('delete').'" tour_start_date_id="'.$tour_start_date_id.'" departure="'.$lstTourStartDate[$m]['start_date'].'" tour_id="'.$tour_id.'" class="clickDeleteTourStartDate btn btn-warning" href="#"><i class="icon-trash icon-white"></i> '.$core->get_Lang('delete').'</a></td>';
			 
			$html .= '
		</tr>';
		
		}
		$html .= '
		</table>
		</div>';
																								
		$html .= '<div id="holderAllTourStartDateGird" style="width:100%;">';
		for($m=0;$m<count($lstTourStartDate);$m++){
		$tour_start_date_id = $lstTourStartDate[$m][$clsTourStartDate->pkey];
		$start_date = $lstTourStartDate[$m]['start_date'];
		$html .= '
		<div class="col-md-3 col-sm-6 mb20">
			<div class="departureItem">
			<p class="date" title="'.date('d/m/Y',$lstTourStartDate[$m]['start_date']).'">'.$core->get_Lang('Departure date').':'.' <strong>'.date('d/m',$lstTourStartDate[$m]['start_date']).'</strong></p>
			<p class="date" title="'.date('d/m/Y',$lstTourStartDate[$m]['start_date']).'">'.$core->get_Lang('tripcode').':'.' <strong>'.$clsTourStartDate->getTripCode($tour_start_date_id).'</strong></p>';
	
			#
			$html .= '
			 <div class="priceTableEn">
			<div class="fieldlabel" style="text-align:left;line-height:24px; margin-bottom:10px">'.$core->get_Lang('Product pricing').'</div>
			<div style="display:inline-block; vertical-align:top">
				<select name="service_ID" id="service_ID" class="form-control" style="display:none">
						<option value="1">'.$core->get_Lang('By Person').'</option>
				</select>
			</div>
			<div id="priceTableDepart" style="display:inline-block">
				 <div id="tblTourPriceNewVersion'.$m.'" class="span100">
					<table class="table tbl-grid" width="100%" style="border:1px solid #ccc;">
						<thead>
							<tr>
								<td class="gridheader">';
									if($is_agent!=''){
										$html .='<strong><span class="table_price_title">'.$core->get_Lang('Agent Type').'</span></strong>';
									}else{
										$html .='<strong><span class="table_price_title">'.$core->get_Lang('Visitor Type').'</span></strong>';
									}
									
								$html .='</td>';
								for($k=0;$k<count($lstNationality);$k++){
									if($_LANG_ID=='vn'){ 
									$html.= '
									<td class="gridheader" style="text-align:center;">'.$lstNationality[$k]['title'].'</td>';
									}else{
									$html .= '<td style="text-align:center;"><strong>'.$core->get_Lang('Price').'</strong></td>';
									}
								}
							$html.= '                            
							</tr>
						</thead>';
						if($lstVisitorType[0]['tour_property_id']!=''){
							for($i=0;$i<count($lstVisitorType);$i++){
								$html .= '
								<tr>
								<td style="text-align:left;">'.$lstVisitorType[$i]['title'].'</td>';
									for($k=0;$k<count($lstNationality);$k++){
										$html.= '
										<td style="text-align:center;white-space:nowrap">
											'.$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency')).' <input name="price_adult'.$m.''.$lstVisitorType[$i]['tour_property_id'].''.$lstNationality[$k]['tour_property_id'].'" id="price_adult'.$m.''.$lstVisitorType[$i]['tour_property_id'].''.$lstNationality[$k]['tour_property_id'].'" class="text tour_season_price_newversion fontLarge priceTourFormat" style="width:60%; text-align:right; color:red;" departure="'.$lstTourStartDate[$m]['start_date'].'"  tour_property_idc="'.$lstNationality[$k]['tour_property_id'].'" tour_property_idr="'.$lstVisitorType[$i]['tour_property_id'].'" tour_id="'.$tour_id.'" and is_agent='.$is_agent.'  value="'.$clsTourPriceVal->getTripPrice($lstVisitorType[$i]['tour_property_id'],0,$lstTourStartDate[$m]['start_date'],$tour_id,$is_agent).'" type="text" /> 
										
										</td>'; 
									}			
									$html .= '
								</tr>';
							}
							$html .= '<tr>';
							$html .= '<td class="gridheader" style="text-align:left; display:none"><strong>'.$core->get_Lang('status').'</strong></td>';
							for($k=0; $k<count($lstNationality); $k++){
							$html .= '
							<td class="gridheader text-center" style="display:none">
								<input type="checkbox">
							</td>';	
						}
						$html .= '</tr>';
						}
					$html .= '</table>';
					$html .= '</div>    ';                    
				$html .= '</div>';
				$html .= '<div id="priceOption" style="display:none">
					<label class="control-label" for="price_ID">'.$core->get_Lang('Price').'</label>
					'.$clsISO->getRate().' <input type="text" name="trip_price" id="trip_price" value="'.$clsISO->formatNumberToEasyRead($clsTour->getOneField('trip_price',$tour_id)).'" class="text ful span20 fontLarge" /> 
			</div>
		</div>';
		if(1==2){
		$html .= '<label style="text-align:left; line-height:24px; padding-right:0; font-size:13px; width:110px;">'.$core->get_Lang('Advertised price').'</label>
                            <span style="display:inline-block; width:40px">('.$clsISO->getRate().')</span><input type="text" name="price_ad" id="advertisedPrice'.$m.'" tour_property_idc="0" tour_property_idr="0" value="'.$clsTourPriceVal->getTripPrice(0,0,$lstTourStartDate[$m]['start_date'],$tour_id).'" departure="'.$lstTourStartDate[$m]['start_date'].'" tour_id="'.$tour_id.'" and is_agent='.$is_agent.'  class="text full tour_season_price_newversion priceTourFormat" style="width:115px; padding:2px 3px" />';
		}
		$html .= '<label style="text-align:left; line-height:24px; padding-right:0; font-size:13px; width:110px;">'.$core->get_Lang('available').'</label>
                            <input type="text" name="available" value="'.$clsTourStartDate->getSeatAvailableTour($tour_start_date_id).'" departure="'.$start_date.'" tour_id="'.$tour_id.'" and is_agent='.$is_agent.' tour_start_date_id="'.$tour_start_date_id.'" class="text full tour_available priceTourFormat" style="width:115px; padding:2px 3px" />';
												
		$html .= '<script type="text/javascript">
			var price_adult = parseInt($("#price_adult'.$m.'16").val());
			var  priceAdDepart = $("#advertisedPrice'.$m.'");
			priceAdDepart.change(function(){
				if(!isNaN(parseInt($(this).val()))){
					if(parseInt($(this).val()) >= parseInt($("#price_adult'.$m.'16").val())){
					}else{
						alert("Input data is invalid");
						$(this).val(parseInt($("#price_adult'.$m.'16").val()));
					}
				}
			});
			
			var price_advert = parseInt($("#advertisedPrice'.$m.'").val());
			var priceAdult = $("#price_adult'.$m.'16");
			priceAdult.change(function(){
				if(parseInt($("#advertisedPrice'.$m.'").val())>0){
					if(!isNaN(parseInt($(this).val()))){
						if(parseInt($(this).val()) <= parseInt($("#advertisedPrice'.$m.'").val())){
						}else{
							alert("Input data is invalid");
							$(this).val(parseInt($("#advertisedPrice'.$m.'").val()));
						}
					}
				}
			});
		</script>						
		<div class="cleafix"></div>';
			$html .= '
			<a title="'.$core->get_Lang('delete').'" tour_start_date_id="'.$tour_start_date_id.'" departure="'.$lstTourStartDate[$m]['start_date'].'" tour_id="'.$tour_id.'" is_agent="'.$is_agent.'" class="clickDeleteTourStartDate btn btn-warning" href="#"><i class="icon-trash icon-white"></i> '.$core->get_Lang('delete').'</a>
			';
			$html .= '
			</div>
		</div>';
		}
	}	
	echo($html);die();
}

function default_ajLoadTourPriceUnitStartDateCopy(){
	global $core,$clsISO;
	$clsTour = new Tour();
	$clsTourPriceAgeType = new TourPriceAgeType();
	$clsTourPriceCustomerType = new TourPriceCustomerType();
	$clsTourPriceUnit = new TourPriceUnit();
	$clsTourStartDate = new TourStartDate();
	#
	$tour_id = $_POST['tour_id'];
	$lstAgeType = $clsTourPriceAgeType->getAll("tour_id='$tour_id' and is_trash=0 order by age_type_id asc");
	$lstCustomerType = $clsTourPriceCustomerType->getAll("tour_id='$tour_id' and is_trash=0 order by customer_type_id asc");
	#
	$html = '';
	$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' order by start_date asc");
	if($lstTourStartDate[0][$clsTourStartDate->pkey]!=''){
		$html .= '<h3 class="btn btn-primary fileinput-button">'.$core->get_Lang('liststartdate').'</h3>
		<a style="vertical-align:middle; padding:15px 10px; float:right;" href="javascript:void(0);" class="clickResetPriceTourStartDate btn btn-warning">'.$core->get_Lang('reset').'</a>
		<br style="clear:both;" /><br style="clear:both;" />
		<div id="holderAllTourStartDate" style="width:100%;">';
		for($m=0;$m<count($lstTourStartDate);$m++){
			$tour_start_date_id = $lstTourStartDate[$m][$clsTourStartDate->pkey];
			$start_date = $lstTourStartDate[$m]['start_date'];
			$html .= '
			<div class="col-md-3 col-sm-6">
			<div class="departureItem">
			<a class="date" href="javascript:void();" title="'.date('d/m/Y',$lstTourStartDate[$m]['start_date']).'">'.$core->get_Lang('Departure date').':'.' <strong>'.date('d/m',$lstTourStartDate[$m]['start_date']).'</strong></a>
			<a class="date" href="javascript:void();" title="'.date('d/m/Y',$lstTourStartDate[$m]['start_date']).'">'.$core->get_Lang('tripcode').':'.' <strong>'.$clsTourStartDate->getTripCode($tour_start_date_id).'</strong></a>';

			#
			$html .= '
			Giá từ: <a href="#" class="ajEditTourStartDateElement" tp="price" tour_start_date_id="'.$tour_start_date_id.'"><strong class="fontLarge" id="CruiseStartDateElement-'.$tour_start_date_id.'-price">'.$clsISO->formatNumberToEasyRead($lstTourStartDate[$m]['price']).$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency')).'</strong></a>
			<br><br>
			Giá cũ: <a href="#" class="ajEditTourStartDateElement" tp="price_old" tour_start_date_id="'.$tour_start_date_id.'"><strong class="fontLarge" id="TourStartDateElement-'.$tour_start_date_id.'-price_old"><del>'.$clsISO->formatNumberToEasyRead($lstTourStartDate[$m]['price_old']).'</del></strong>'.$clsISO->getRateSign().'</a> 
			<br><br>
			Giờ đi: <a href="#" class="ajEditTourStartDateElement" tp="hour_in" tour_start_date_id="'.$tour_start_date_id.'"><strong class="fontLarge" id="TourStartDateElement-'.$tour_start_date_id.'-hour_in">'.(trim($lstTourStartDate[$m]['hour_in'])==''?$core->get_Lang('null'):$lstTourStartDate[$m]['hour_in']).'</strong></a>
			<br><br>
			Giờ đến: <a href="#" class="ajEditTourStartDateElement" tp="hour_out" tour_start_date_id="'.$tour_start_date_id.'"><strong class="fontLarge" id="TourStartDateElement-'.$tour_start_date_id.'-hour_out">'.(trim($lstTourStartDate[$m]['hour_out'])==''?$core->get_Lang('null'):$lstTourStartDate[$m]['hour_out']).'</strong></a>
			<br><br>
			';
			$html .= '
			<br style="clear:both;" /><br style="clear:both;" />
			<a title="'.$core->get_Lang('delete').'" tour_start_date_id="'.$tour_start_date_id.'" tour_id="'.$tour_id.'" class="clickDeleteTourStartDate btn btn-warning" href="#"><i class="icon-trash icon-white"></i> '.$core->get_Lang('delete').'</a>
			';
			$html .= '
			</div>
			</div>';
		}
	}	
	echo($html);die();
}
/*------ Load Tour Extension -------*/
function default_ajLoadTourExtension(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration, $clsISO;
	#
	$clsTour = new Tour();
	$clsTourExtension = new TourExtension();
	$clsProperty = new Property();
	#
	$tour_1_id = $_POST['tour_1_id'];
	$html='';
	$lstItem = $clsTourExtension->getAll("is_trash=0 and tour_1_id='$tour_1_id' order by order_no asc");
	if(!empty($lstItem)){
		$i=0;
		foreach($lstItem as $item){
			$html.='<tr style="cursor:move" id="order_'.$item[$clsTourExtension->pkey].'" class="'.($i%2==0?'row1':'row2').'">';
			$html.='<td class="index">'.($i+1).'</td>';
			$html.='<td><strong>'.$clsTour->getTitle($item['tour_2_id']).'</strong></td>';
			$html.='<td><strong>'.$clsTour->getTripDuration($item['tour_2_id']).'</strong></td>';
			if($clsConfiguration->getValue('SiteHasCat_Tours') == 1) {
				$html.='<td><strong>'.$clsTour->getCatName($item['tour_2_id']).'</strong></td>';
			}
			$html.='<td style="text-align:right; white-space:nowrap">
						<strong class="format_price">
							'.$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency')).' '.$clsISO->formatNumberToEasyRead($clsTour->getOneField('trip_price',$item['tour_2_id'])).'
						</strong>
					</td>';
			if(1==2){
			$html.='<td style="vertical-align: middle;text-align:center">
					'.($i==0?'':'<a title="'.$core->get_Lang('movetop').'"  direct="movetop" class="moveTourExtension" data="'.$item[$clsTourExtension->pkey].'" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>').'
                </td>
                <td style="vertical-align: middle;text-align:center">
                    '.($i==count($lstItem)-1?'':'<a title="'.$core->get_Lang('movebottom').'" class="moveTourExtension" direct="movebottom" data="'.$item[$clsTourExtension->pkey].'" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>').'
                </td>
                <td style="vertical-align: middle;text-align:center">
                    '.($i==0?'':'<a title="'.$core->get_Lang('moveup').'" class="moveTourExtension" direct="moveup" data="'.$item[$clsTourExtension->pkey].'" href="javascript:void();"><i class="icon-arrow-up"></i></a>').'
                </td>
                <td style="vertical-align: middle;text-align:center">
                    '.($i==count($lstItem)-1 ? '' : '<a title="'.$core->get_Lang('movedown').'" class="moveTourExtension" direct="movedown" data="'.$item[$clsTourExtension->pkey].'" href="javascript:void();"><i class="icon-arrow-down"></i></a>').'
                </td>';
			}
			$html.='<td style="text-align:center">
						<a title="'.$core->get_Lang('delete').'" class="btn clickDeleteTourExtension btn-danger fileinput-button" data="'.$item[$clsTourExtension->pkey].'" href="javascript:void();">
							<i class="icon-remove icon-white"></i>
						</a>
					</td>';
			$html.='</tr>';
			++$i;
		}
		$html.='
		<script type="text/javascript">
			$("#tblTourExtension").sortable({
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
					$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosTourExtension", order, function(html){
						loadTourExtension(tour_id);
						vietiso_loading(0);
					});
				}
			});
		</script>';
	}
	echo $html; die();
}

function default_ajLoadListPriceTourGroupStartDate(){
	global $core,$clsISO,$clsConfiguration;
	$clsTour = new Tour();
	$clsTourPriceGroup = new TourPriceGroup();
	$clsTourPriceAgeType = new TourPriceAgeType();
	$clsTourPriceCustomerType = new TourPriceCustomerType();
	$clsTourPriceUnit = new TourPriceUnit();
	$clsTourStartDate = new TourStartDate();
	$clsTourStore = new TourStore();
	
	$listMonth = array();
	$now = time();
	$month = date('m',$now);
	$year = date('Y',$now);

	for($i = intval($month); $i <= 12; $i++){
		$listMonth[] = array(
			'month'	=> ($i<10) ? '0'.$i : $i,
			'year'	=> $year
		);
	}
	for($i = 1; $i < intval($month); $i++){
		$listMonth[] = array(
			'month'	=> $i ? '0'.$i : $i,
			'year'	=> ($year+1)
		);
	}
	for($m=1;$m<5;$m++){
		for($i = intval($month); $i <= 12; $i++){
			$listMonth[] = array(
				'month'	=> ($i<10) ? '0'.$i : $i,
				'year'	=> $year+$m
			);
		}
		for($i = 1; $i < intval($month); $i++){
			$listMonth[] = array(
				'month'	=> $i ? '0'.$i : $i,
				'year'	=> ($year+$m+1)
			);
		}
	}
	

	$assign_list["listMonth"] = $listMonth;
	
	
	$clsProperty = new Property(); $assign_list["clsProperty"] = $clsProperty;
	$clsTourProperty = new TourProperty(); $assign_list["clsTourProperty"] = $clsTourProperty;
	$clsTourPriceRow = new TourPriceRow(); $assign_list["clsTourPriceRow"] = $clsTourPriceRow;
	$clsTourPriceCol = new TourPriceCol(); $assign_list["clsTourPriceCol"] = $clsTourPriceCol;
	$clsTourPriceVal = new TourPriceVal(); $assign_list["clsTourPriceVal"] = $clsTourPriceVal;
	#
	$tour_id = $_POST['tour_id'];
	$departure_date = isset($_POST['departure']) ? $_POST['departure'] : '';
	$is_agent = isset($_POST['is_agent']) ? $_POST['is_agent'] : '0';
	
	
	$lstNationality = $clsTourProperty->getAll("is_trash=0 and type='NATIONALITY' order by order_no asc");
	$lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc");
	
	$lstTourNumberGroup = $clsTourProperty->getAll("is_trash=0 and type='TOURNUMBERGROUP' order by order_no asc");
	$lstTourClass = $clsTourProperty->getAll("is_trash=0 and type='TOURCLASS' order by order_no asc");
	
	$lstAgeType = $clsTourPriceAgeType->getAll("tour_id='$tour_id' and is_trash=0 order by age_type_id asc");
	$lstCustomerType = $clsTourPriceCustomerType->getAll("tour_id='$tour_id' and is_trash=0 order by customer_type_id asc");
	#
	$maxNumberPrice=(count($lstVisitorType)*count($lstTourNumberGroup)*count($lstTourClass)) + count($lstTourClass);
	
	$tmp_departure_date = explode('/',$departure_date);
	
	$monthFilter=$tmp_departure_date[0];
	$YearFilter=$tmp_departure_date[1];
	
	$startdate =$monthFilter.'/01/'.$YearFilter;
	$enddate = $monthFilter.'/31/'.$YearFilter;



	$html = '';
	if($is_agent!=''){
		if($departure_date!=''){
			$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and start_date >= '".time()."' and start_date >= '".strtotime($startdate)."' and start_date <= '".strtotime($enddate)."' and is_agent='$is_agent' order by start_date asc");
		}else{
			$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and is_agent='$is_agent' order by start_date asc");
		}
		
	}else{
		if($departure_date!=''){
			$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and start_date >= '".time()."' and start_date >= '".strtotime($startdate)."' and start_date <= '".strtotime($enddate)."' and is_agent<>1 order by start_date asc");
		}else{
			$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and is_agent<>1 order by start_date asc");
		}
	}
	if($lstTourStartDate[0][$clsTourStartDate->pkey]!=''){
		$html .= '<p class="mb10" style="font-size:18px; display:inline-block; line-height:30px; vertical-align:top"><span  style="display:inline-block; line-height:60px;">'.$core->get_Lang('List departure date').'  </span>
		</p>
		<div class="line mb20">
			<label>'.$core->get_Lang('Departure date').': </label> 
			<select id="slb_MonthYear" class="selectbox">
				<option value="0">-- '.$core->get_Lang('select').' --</option>';
				
				for($i=0;$i<count($listMonth);$i++){
					$start_date = $listMonth[$i]['month'].'/01/'.$listMonth[$i]['year'];
					$end_date = $listMonth[$i]['month'].'/31/'.$listMonth[$i]['year'];
					if($clsTourStartDate->countTourStartDateByMonth($tour_id,$start_date,$end_date)!=''){
						$html .= '<option start_date="'.$start_date.'"  end_date="'.$end_date.'" value="'.$listMonth[$i]['month'].'/'.$listMonth[$i]['year'].'" year="">'.$listMonth[$i]['month'].'/'.$listMonth[$i]['year'].'</option>';
					}
				}
			$html .= '</select>
		</div>
		
		<div id="holderAllTourStartDateList" style="width:100%;">
		<table cellspacing="0" width="100%">
		<tr>
		<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;height:40px">'.$core->get_Lang('Trip code').'</td>
		<td style="padding:0 5px; text-align:center; border: 1px solid #ccc;">'.$core->get_Lang('Departure date').'</td>
		<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$core->get_Lang('Public').'</td>
		<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$core->get_Lang('Function').'</td>
		</tr>
		';
		for($m=0;$m<count($lstTourStartDate);$m++){
		$tour_start_date_id = $lstTourStartDate[$m][$clsTourStartDate->pkey];
		$start_date = $lstTourStartDate[$m]['start_date'].'';
		$numberPrice=$clsTourPriceGroup->countNumberPriceDepartureDate($tour_id,$lstTourStartDate[$m]['start_date']);
		$arrayPastePrice=vnSessionGetVar('arrayPastePrice');
		if($numberPrice=='0'){
			$class='button01';
		}elseif($numberPrice==$maxNumberPrice){
			$class='button03';
		}else{
			$class='button02';
		}
		$html .= '
		<tr style="'.($m%2==0?'background:#eee':'background:#fff').'">';
			if($numberPrice=='0'){
				$html .= '<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$clsTourStartDate->getTripCode($tour_start_date_id).' <span class="color_f00">!!!</span></td>';
			}else{
				$html .= '<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$clsTourStartDate->getTripCode($tour_start_date_id).'</td>';
			}
			$html .= '<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.date('d/m/Y',$lstTourStartDate[$m]['start_date']).'</td>';
			$html .= '<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">';
				$html .= '<a href="javascript:void(0);" class="'.($numberPrice==0?'SiteClickNoPublic':'SiteClickPublic').'" clsTable="TourStartDate" pkey="tour_start_date_id" sourse_id="'.$lstTourStartDate[$m]['tour_start_date_id'].'" rel="'.$lstTourStartDate[$m]['is_online'].'" title="'.$core->get_Lang('Click to change status').'">';
					if($lstTourStartDate[$m]['is_online'] == '1'){
					$html .= '<i class="fa fa-check-circle green"></i>';
					}else{
					$html .= '<i class="fa fa-minus-circle red"></i>';
					}
				$html .= '</a>
			</td>';
			$html .= '<td style="padding:5px 5px; text-align:center;border: 1px solid #ccc;">
				<div class="btn-group">
					<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
					<ul class="dropdown-menu" style="right:0px !important">
						<li><a title="'.$core->get_Lang('Edit').'" tour_start_date_id="'.$tour_start_date_id.'" departure="'.$lstTourStartDate[$m]['start_date'].'" tour_id="'.$tour_id.'" class="clickEditTourGroupStartDate" href="#"><i class="icon-edit"></i> <span>'.$core->get_lang('Edit').'</span></a></li>
						<li><a title="'.$core->get_Lang('delete').'" tour_start_date_id="'.$tour_start_date_id.'" departure="'.$lstTourStartDate[$m]['start_date'].'" tour_id="'.$tour_id.'" class="clickDeleteTourGroupStartDate" href="#"><i class="icon-trash"></i> <span>'.$core->get_lang('Delete').'</span></a></li>';
						if($numberPrice!='0'){
						$html .= '<li><a title="'.$core->get_Lang('Copy').'" tour_start_date_id="'.$tour_start_date_id.'" departure="'.$lstTourStartDate[$m]['start_date'].'" tour_id="'.$tour_id.'" class="clickCopyTourGroupStartDate" href="#"><i class="fa fa-files-o"></i> <span>'.$core->get_lang('Copy').'</span></a></li>';
						}
						if($arrayPastePrice!='' && $arrayPastePrice['departure']!=$lstTourStartDate[$m]['start_date']){
							$html .= '<li><a title="'.$core->get_Lang('Paste').'" tour_start_date_id="'.$tour_start_date_id.'" departure="'.$lstTourStartDate[$m]['start_date'].'" tour_id="'.$tour_id.'" class="clickPasteTourGroupStartDate" href="#"><i class="fa fa-clipboard"></i> <span>'.$core->get_lang('Paste').'</span></a></li>';
						}
					$html .= '</ul>
				</div>
			</td>';
			
			
			 
			$html .= '
		</tr>';
		
		}
		$html .= '
		</table>
		</div>';
	}	
	echo($html);die();
}

function default_ajUpdPosTourExtension(){
		global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
		global $clsConfiguration;
	#
	$clsTour = new Tour();
	$clsTourExtension = new TourExtension();
	$order = $_POST['order'];
	foreach($order as $key=>$val){
		$key = $key+1;
		$clsTourExtension->updateOne($val,"order_no='".$key."'");	
	}
	//var_dump($order);die;
}
function default_ajAddTourExtension(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsTourExtension = new TourExtension();
	$tour_1_id = $_POST['tour_1_id'];
	$tour_2_id = $_POST['tour_2_id'];
	
	if(!$clsTourExtension->checkExist($tour_1_id, $tour_2_id)){
		$f="tour_1_id,tour_2_id,order_no";
		$res = $clsTourExtension->getAll("is_trash=0 and tour_1_id='$tour_1_id' order by order_no desc limit 0,1");
		$order_no = intval($res[0]['order_no'])+1;
		$v="'$tour_1_id','$tour_2_id','".$order_no."'";
		if($clsTourExtension->insertOne($f,$v)){
			echo('_SUCCESS'); die();
		}
	}else{
		echo('_EXIST'); die();
	}
}
function default_ajMoveTourExtension(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsClassTable = new TourExtension();
	
	$pvalTable = $_POST['tour_extension_id'];
	$direct = $_POST['direct'];
	$one = $clsClassTable->getOne($pvalTable);
	$tour_1_id = $one['tour_1_id'];
	$order_no = $one['order_no'];
	
	if($direct=='moveup'){
		$lst = $clsClassTable->getAll("tour_1_id='$tour_1_id' and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movedown'){
		$lst = $clsClassTable->getAll("tour_1_id='$tour_1_id' and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[0]['order_no']."'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movetop'){
		$lst = $clsClassTable->getAll("tour_1_id='$tour_1_id' and order_no > $order_no order by order_no asc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$clsClassTable->updateOne($lst[count($lst)-1][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	if($direct=='movebottom'){
		$lst = $clsClassTable->getAll("tour_1_id='$tour_1_id' and order_no < $order_no order by order_no desc");
		$clsClassTable->updateOne($pvalTable,"order_no='".$lst[count($lst)-1]['order_no']."'");
		$clsClassTable->updateOne($lst[count($lst)-1][$clsClassTable->pkey],"order_no='".$order_no."'");
	}
	echo(1); die();
}
function default_ajDeleteTourExtension(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsClassTable = new TourExtension();
	$tour_extension_id = $_POST['tour_extension_id'];
	
	$clsClassTable->deleteOne($tour_extension_id);
	echo(1); die();
}

/*------ Tour Start Date -------*/
function default_ajLoadAddStartDate(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	$clsTour = new Tour();
	$tour_id = $_POST['tour_id'];
	#
	$html = '';
	$html.='<style type="text/css">#ui-datepicker-div{top:350px !important;}</style>
	<div class="headPop">
				<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
				<h3>'.$core->get_Lang('addstartdate').'</h3>
			</div>';
	$html .= '
			<div class="wrap">
				<div class="fl span100">
					<div class="row-span">
						<input style="width:90%;" type="text" id="multiDate" placeholder="'.$core->get_Lang('choosemultidate').'" />
						<script type="text/javascript" src="'.URL_JS.'/MultiDatesPicker/jquery-ui.multidatespicker.js"></script>
						<style type="text/css">
							.ui-state-highlight .ui-state-default{background:#743620 !important; color:#fff !important;}
						</style>
					</div>
				</div>
			</div>
		<div class="modal-footer">
			<button type="submit" itinerary_id=0 class="btn btn-primary clickToAddNewTourStartDate"><i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('add').'</span> </button>
		</div>';
	echo($html);die();
}
function default_ajAddStartDate(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsTour = new Tour();
	$clsTourPriceUnit = new TourPriceUnit();
	$clsTourStartDate = new TourStartDate();
	#
	$tour_id = $_POST['tour_id'];
	$is_agent = isset($_POST['is_agent']) ? $_POST['is_agent'] : '0';
	$user_id = $core->_USER['user_id'];
	$list_start_date = explode(',',$_POST['start_date']);
	$allotment = isset($_POST['allotment']) ? $_POST['allotment'] : '0';
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	if($tp=='SaveAvailable'){
		$tour_start_date_id = isset($_POST['tour_start_date_id']) ? intval($_POST['tour_start_date_id']) : '0';
		if($tour_start_date_id!=''){
			$clsTourStartDate->updateOne($tour_start_date_id,"allotment='".$allotment."'");
			echo '_SUCCESS'; die();		
		}else{
			echo("_EXIST");die();
		}
	}else{
		$countList = count($list_start_date);
		for($l=0;$l<$countList;$l++){
			$start_date = strtotime($list_start_date[$l]);
			if($is_agent!=''){
				$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and start_date='$start_date' and is_agent='$is_agent' limit 0,1");
			}else{
				$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and start_date='$start_date' limit 0,1");
			}
			$tour_start_date_id = $lstTourStartDate[0][$clsTourStartDate->pkey];
			if($tour_start_date_id!=''){
				echo("_EXIST");die();
			}
			else{
				if($clsTour->getTourTypeCategory($tour_id)==0){
					$tour_start_date_id = $clsTourStartDate->getMaxId();
					#
					$f = "title,tour_start_date_id,tour_id,start_date,user_id,user_id_update,reg_date,upd_date";
					$f.= ",allotment,hour_in,hour_out,price,price_old,is_agent";
					$v = "'".$_POST['start_date']."','$tour_start_date_id','$tour_id','$start_date','$user_id','$user_id','".time()."'";
					$v.= ",'".time()."','".$clsTour->getOneField("number_seat",$tour_id)."','".$clsTour->getOneField("hour_in",$tour_id)."'";
					$v.= ",'".$clsTour->getOneField("hour_out",$tour_id)."','".addslashes($clsTour->getOneField("trip_price",$tour_id))."'";
					$v.= ",'".addslashes($clsTour->getOneField("trip_old_price",$tour_id))."','".$is_agent."'";
					$clsTourStartDate->insertOne($f,$v);
					#
					$clsTourPriceAgeType = new TourPriceAgeType();
					$clsTourPriceCustomerType = new TourPriceCustomerType();
					if($is_agent!=''){
						$lstAgeType = $clsTourPriceAgeType->getAll("tour_id='$tour_id' and is_trash=0 order by age_type_id asc");
						$lstCustomerType = $clsTourPriceCustomerType->getAll("tour_id='$tour_id' and is_trash=0 order by customer_type_id asc");
						$f = "tour_start_date_id,tour_price_customer_type_id,tour_price_age_type_id,price,user_id,user_id_update,reg_date,upd_date,tour_id,is_agent";
						for($i=0;$i<count($lstAgeType);$i++){
							for($k=0;$k<count($lstCustomerType);$k++){
								$tour_price_customer_type_id = $lstCustomerType[$i]['tour_price_customer_type_id']; 
								$tour_price_age_type_id = $lstAgeType[$k]['tour_price_age_type_id'];
								$tmp = $clsTourPriceUnit->getAll("tour_start_date_id='0' and tour_price_customer_type_id='$tour_price_customer_type_id' and tour_price_age_type_id='$tour_price_age_type_id' and is_agent='$is_agent' limit 0,1");
								$v = "'$tour_start_date_id','$tour_price_customer_type_id','$tour_price_age_type_id','".intval($tmp[0]['price'])."','$user_id','$user_id','".time()."','".time()."','$tour_id','$tour_id','$is_agent'";
								$clsTourPriceUnit->insertOne($f,$v);
							}
						}
					}else{
						$lstAgeType = $clsTourPriceAgeType->getAll("tour_id='$tour_id' and is_trash=0 order by age_type_id asc");
						$lstCustomerType = $clsTourPriceCustomerType->getAll("tour_id='$tour_id' and is_trash=0 order by customer_type_id asc");
						$f = "tour_start_date_id,tour_price_customer_type_id,tour_price_age_type_id,price,user_id,user_id_update,reg_date,upd_date,tour_id";
						for($i=0;$i<count($lstAgeType);$i++){
							for($k=0;$k<count($lstCustomerType);$k++){
								$tour_price_customer_type_id = $lstCustomerType[$i]['tour_price_customer_type_id']; 
								$tour_price_age_type_id = $lstAgeType[$k]['tour_price_age_type_id'];
								$tmp = $clsTourPriceUnit->getAll("tour_start_date_id='0' and tour_price_customer_type_id='$tour_price_customer_type_id' and tour_price_age_type_id='$tour_price_age_type_id' limit 0,1");
								$v = "'$tour_start_date_id','$tour_price_customer_type_id','$tour_price_age_type_id','".intval($tmp[0]['price'])."','$user_id','$user_id','".time()."','".time()."','$tour_id'";
								$clsTourPriceUnit->insertOne($f,$v);
							}
						}
						
					}
				}
				else{
					$clsTourPriceAgeType = new TourPriceAgeType();
					$clsTourPriceCustomerType = new TourPriceCustomerType();
					$lstAgeType = $clsTourPriceAgeType->getAll("tour_id='$tour_id' and is_trash=0 order by age_type_id asc");
					$lstCustomerType = $clsTourPriceCustomerType->getAll("tour_id='$tour_id' and is_trash=0 order by customer_type_id asc");
					
					$f = "title,tour_start_date_id,tour_id,start_date,user_id,user_id_update,reg_date,upd_date,allotment,hour_in,hour_out,price,price_old,is_agent";
					$tour_start_date_id = $clsTourStartDate->getMaxId();
					$v = "'".$_POST['start_date']."','$tour_start_date_id','$tour_id','$start_date','$user_id','$user_id','".time()."','".time()."','".$clsTour->getOneField("number_seat",$tour_id)."','".$clsTour->getOneField("hour_in",$tour_id)."','".$clsTour->getOneField("hour_out",$tour_id)."','".addslashes($clsTour->getOneField("trip_price",$tour_id))."','".addslashes($clsTour->getOneField("trip_old_price",$tour_id))."','".$is_agent."'";
					$clsTourStartDate->insertOne($f,$v);
					#
					$f = "tour_start_date_id,tour_price_customer_type_id,tour_price_age_type_id,price,user_id,user_id_update,reg_date,upd_date,tour_id,is_agent";
					for($i=0;$i<count($lstAgeType);$i++){
						for($k=0;$k<count($lstCustomerType);$k++){
							$tour_price_customer_type_id = $lstCustomerType[$k]['tour_price_customer_type_id']; 
							$tour_price_age_type_id = $lstAgeType[$i]['tour_price_age_type_id'];
							if($is_agent!=''){
								$tmp = $clsTourPriceUnit->getAll("tour_start_date_id='0' and tour_price_customer_type_id='$tour_price_customer_type_id' and tour_price_age_type_id='$tour_price_age_type_id' and is_agent=1 limit 0,1");
							}else{
								$tmp = $clsTourPriceUnit->getAll("tour_start_date_id='0' and tour_price_customer_type_id='$tour_price_customer_type_id' and tour_price_age_type_id='$tour_price_age_type_id' limit 0,1");	
							}
							$v = "'$tour_start_date_id','$tour_price_customer_type_id','$tour_price_age_type_id','".intval($tmp[0]['price'])."','$user_id','$user_id','".time()."','".time()."','$tour_id','$is_agent'";
							$clsTourPriceUnit->insertOne($f,$v);
							$clsTourPriceUnit->insertOne($f,$v);
						}
					}
				}
				#
				if($clsTour->getTourTypeCategory($tour_id)==0){
					for($k=0;$k<count($lstCustomerType);$k++){
						$tour_price_customer_type_id = $lstCustomerType[$k]['tour_price_customer_type_id'];
						$tour_price_age_type_id = _PHUTHUPHONGDON;
						if($is_agent!=1){
							$cond = "tour_price_customer_type_id='".$tour_price_customer_type_id."' and tour_start_date_id='0' and tour_price_age_type_id='".$tour_price_age_type_id."' and tour_id='$tour_id' and is_agent='1' limit 0,1";
						}else{
							$cond = "tour_price_customer_type_id='".$tour_price_customer_type_id."' and tour_start_date_id='0' and tour_price_age_type_id='".$tour_price_age_type_id."' and tour_id='$tour_id' limit 0,1";
						}
						$lst = $clsTourPriceUnit->getAll($cond);
						$price = $lst[0]['price'];
						#
						$f = "tour_start_date_id,tour_price_customer_type_id,tour_price_age_type_id,price,user_id,user_id_update,reg_date,upd_date,tour_id";
						$v = "'$tour_start_date_id','$tour_price_customer_type_id','$tour_price_age_type_id','".addslashes($price)."','$user_id','$user_id','".time()."','".time()."','$tour_id'";
						//echo($v);die();
						print_r(7777); die();
						$clsTourPriceUnit->insertOne($f,$v);
						$cnt++;
					}
				}
				else{
					$clsCategory = new Category();
					$lstPhuThu = $clsCategory->getAll("is_trash=0 and _type='PTKH' order by order_no asc");	
					$clsTourPriceCat = new TourPriceCat();
					$f = "tour_start_date_id,tour_id,cat_id,user_id,user_id_update,reg_date,upd_date,price";
					for($i=0;$i<count($lstPhuThu);$i++){
						$tmp = $clsTourPriceCat->getAll("tour_start_date_id='0' and tour_id='$tour_id' and cat_id='".$lstPhuThu[$i]['cat_id']."' limit 0,1");
						$pricePT = $tmp[0]['price'];
						if(($pricePT==0||$pricePT=='') && 246==$lstPhuThu[$i]['cat_id']){
							$clsCommon = new Common();
							$pricePT= $clsCommon->getOneField('config_tour_ptvtnvn',1);
						}
						$v = "'$tour_start_date_id','$tour_id','".$lstPhuThu[$i]['cat_id']."','$user_id','$user_id','".time()."','".time()."','".addslashes($pricePT)."'";
	
						$clsTourPriceCat->insertOne($f,$v); 
					}
				}
				
			}
		}
	}
	
	#
	echo($cnt);die();
}
function default_ajAddGroupStartDate(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsTour = new Tour();
	$clsTourPriceUnit = new TourPriceUnit();
	$clsTourStartDate = new TourStartDate();
	#
	$tour_id = $_POST['tour_id'];
	$type = $_POST['type'];
	$tp = $_POST['tp'];
	$allotment = isset($_POST['available']) ? $_POST['available'] : '0';
	$deposit_departure = isset($_POST['deposit_departure']) ? $_POST['deposit_departure'] : '0';
	if($tp=='SaveAvailable'){
		$is_agent = isset($_POST['is_agent']) ? $_POST['is_agent'] : '0';
		$start_date=isset($_POST['start_date']) ? $_POST['start_date'] : '';
		$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and start_date='$start_date' and is_agent='$is_agent' and type='$type' limit 0,1");
		$tour_start_date_id = $lstTourStartDate[0][$clsTourStartDate->pkey];
		if($tour_start_date_id!=''){
			$clsTourStartDate->updateOne($tour_start_date_id, "allotment='" . $allotment. "'");
			echo '_SUCCESS'; die();
		}else{
			echo("_EXIST");die();
		}
	}elseif($tp=='SaveDeposit'){
		$is_agent = isset($_POST['is_agent']) ? $_POST['is_agent'] : '0';
		$start_date=isset($_POST['start_date']) ? $_POST['start_date'] : '0';
		$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and start_date='$start_date' and is_agent='$is_agent' and type='$type' limit 0,1");
		$tour_start_date_id = $lstTourStartDate[0][$clsTourStartDate->pkey];
		if($tour_start_date_id!=''){
			$clsTourStartDate->updateOne($tour_start_date_id, "deposit='" . $deposit_departure. "'");
			echo '_SUCCESS'; die();
		}else{
			echo("_EXIST");die();
		}
	}else{
		$is_agent = isset($_POST['is_agent']) ? $_POST['is_agent'] : '0';
		$user_id = $core->_USER['user_id'];
		$list_start_date = explode(',',$_POST['start_date']);
		$countList = count($list_start_date);
		for($l=0;$l<$countList;$l++){
			$start_date = strtotime($list_start_date[$l]);
			if($is_agent!=''){
				$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and start_date='$start_date' and is_agent='$is_agent' and type='$type' limit 0,1");
			}else{
				$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and start_date='$start_date' and is_agent='0' and type='$type' limit 0,1");
			}
			$tour_start_date_id = $lstTourStartDate[0][$clsTourStartDate->pkey];
			if($tour_start_date_id!=''){
				echo("_EXIST");die();
			}
			else{
				$f = "title,tour_start_date_id,tour_id,start_date,user_id,user_id_update,reg_date,upd_date,allotment,hour_in,hour_out,price,type,price_old,is_agent";
				$tour_start_date_id = $clsTourStartDate->getMaxId();
				$v = "'".$_POST['start_date']."','$tour_start_date_id','$tour_id','$start_date','$user_id','$user_id','".time()."','".time()."','".$clsTour->getOneField("number_seat",$tour_id)."','".$clsTour->getOneField("hour_in",$tour_id)."','".$clsTour->getOneField("hour_out",$tour_id)."','".addslashes($clsTour->getOneField("trip_price",$tour_id))."','$type','".addslashes($clsTour->getOneField("trip_old_price",$tour_id))."','".$is_agent."'";
				$clsTourStartDate->insertOne($f,$v);
			}
		}	
	}
	
	#
	echo($cnt);die();
}


function default_ajLoadPriceTableCustomerAge(){
	global $core,$clsISO;
	$clsCategory = new Category();
	$clsTourPriceAgeType = new TourPriceAgeType();
	$clsTourPriceCustomerType = new TourPriceCustomerType();
	$tour_id = $_POST['tour_id'];
	$lstAgeType = $clsTourPriceAgeType->getAll("tour_id='$tour_id' and is_trash=0 order by age_type_id asc");
	$lstCustomerType = $clsTourPriceCustomerType->getAll("tour_id='$tour_id' and is_trash=0 order by customer_type_id asc");
	#
	$clsTour = new Tour();
	$set = "_list_customer_type_id='".addslashes(serialize($lstCustomerType))."'";
	$set .= ",_list_age_type_id='".addslashes(serialize($lstAgeType))."'";
	$clsTour->updateOne($tour_id,$set);
	#
	$html = '';
	$clsTourPriceUnit = new TourPriceUnit();
	if($lstAgeType[0]['tour_id']!='' && $lstCustomerType[0]['tour_id']!=''){
		if($clsTour->getTourTypeCategory($tour_id)==0){
			$html .= '<table cellpadding="5" cellspacing="2" class="tbl-grid" style="font-size:17px; width:auto;">';
			$html .= '<tr><td style="text-align:right; ">'.$core->get_Lang('basicprice').' ('.$clsISO->getRate().')</td>';
			for($k=0;$k<count($lstCustomerType);$k++){
				$html .= '
					<td style="text-align:right;">	
						<strong>'.$clsCategory->getTitle($lstCustomerType[$k]['customer_type_id']).'</strong>
					</td>
				';
			}
			$html .= '</tr>';
			for($i=0;$i<count($lstAgeType);$i++){
				$html .= '<tr>
					<td style="text-align:right;">	
						<strong>'.$clsCategory->getTitle($lstAgeType[$i]['age_type_id']).'</strong>
					</td>';
				for($k=0;$k<count($lstCustomerType);$k++){
					$tour_price_customer_type_id = $lstCustomerType[$k]['tour_price_customer_type_id'];
					$tour_price_age_type_id = $lstAgeType[$i]['tour_price_age_type_id'];
					$lst = $clsTourPriceUnit->getAll("tour_price_customer_type_id='".$tour_price_customer_type_id."' and tour_start_date_id='0' and tour_price_age_type_id='".$tour_price_age_type_id."' limit 0,1");
					$price = $lst[0][$clsTourPriceUnit->pkey]==''?$core->get_Lang('null'):$clsISO->formatNumberToEasyRead($lst[0]['price']);
					$html .= '
						<td style="text-align:right;">	
							<a href="#" title="'.$core->get_Lang('edit').'" style="color:red;" class="ajEditPriceCustomerAge" tour_id="'.$tour_id.'" tour_price_age_type_id="'.$tour_price_age_type_id.'" tour_start_date_id="0" tour_price_customer_type_id="'.$tour_price_customer_type_id.'" id="pr-'.$tour_id.'-'.$tour_price_customer_type_id.'-'.$tour_price_age_type_id.'-0">'.$price.'</a>
						</td>
					';
				}	
				$html .= '
				</tr>';
			}
			$html .= '</table>
			<br style="clear:both" /><br />
			<strong>'.$core->get_Lang('singleroomsupplement').'</strong>:
			<table cellpadding="5" cellspacing="2" class="tbl-grid" style="font-size:17px; width:auto;"><tr>';
				for($k=0;$k<count($lstCustomerType);$k++){
					$html .= '
						<td width="33%">
							<strong>'.$clsCategory->getTitle($lstCustomerType[$k]['customer_type_id']).'</strong>
						</td>
					';
				}
				$html .= '</tr><tr>';
				for($k=0;$k<count($lstCustomerType);$k++){
					$tour_price_customer_type_id = $lstCustomerType[$k]['tour_price_customer_type_id'];
					$tour_price_age_type_id = _PHUTHUPHONGDON;
					$lst = $clsTourPriceUnit->getAll("tour_price_customer_type_id='".$tour_price_customer_type_id."' and tour_start_date_id='0' and tour_price_age_type_id='".$tour_price_age_type_id."' and tour_id='$tour_id' limit 0,1");
					$price = $lst[0][$clsTourPriceUnit->pkey]==''||$lst[0]['price']==0?$core->get_Lang('null'):$clsISO->formatNumberToEasyRead($lst[0]['price']);
					#
					$html .= '
						<td>
							<a href="#" title="'.$core->get_Lang('edit').'" style="color:red;" class="ajEditPriceCustomerAge" tour_id="'.$tour_id.'" tour_price_age_type_id="'.$tour_price_age_type_id.'" tour_start_date_id="0" tour_price_customer_type_id="'.$tour_price_customer_type_id.'" id="pr-'.$tour_id.'-'.$tour_price_customer_type_id.'-'.$tour_price_age_type_id.'-0">'.$price.'</a>
						</td>
					';
				}
				$html .= '</tr></table>';
		}
		else{
			$html .= '<table cellpadding="5" cellspacing="2" class="tbl-grid" style="font-size:17px; width:auto;">';
			$html .= '<tr><td style="text-align:right; ">('.$clsISO->getRate().')</td>';
			for($k=0;$k<count($lstAgeType);$k++){
				$html .= '
					<td style="text-align:right;">	
						<strong>'.$clsCategory->getTitle($lstAgeType[$k]['age_type_id']).'</strong>
					</td>
				';
			}
			$html .= '</tr>';
			for($i=0;$i<count($lstCustomerType);$i++){
				$html .= '<tr>
					<td style="text-align:right;">	
						<strong>'.$clsCategory->getTitle($lstCustomerType[$i]['customer_type_id']).'</strong>
					</td>';
				for($k=0;$k<count($lstAgeType);$k++){
					$tour_price_age_type_id = $lstAgeType[$k]['tour_price_age_type_id'];
					$tour_price_customer_type_id = $lstCustomerType[$i]['tour_price_customer_type_id'];
					$lst = $clsTourPriceUnit->getAll("tour_price_customer_type_id='".$tour_price_customer_type_id."' and tour_start_date_id='0' and tour_price_age_type_id='".$tour_price_age_type_id."' limit 0,1");
					$price = $lst[0][$clsTourPriceUnit->pkey]==''?$core->get_Lang('null'):$clsISO->formatNumberToEasyRead($lst[0]['price']);
					$html .= '
						<td style="text-align:right;">	
							<a href="#" title="'.$core->get_Lang('edit').'" style="color:red;" class="ajEditPriceCustomerAge" tour_id="'.$tour_id.'" tour_price_age_type_id="'.$tour_price_age_type_id.'" tour_start_date_id="0" tour_price_customer_type_id="'.$tour_price_customer_type_id.'" id="pr-'.$tour_id.'-'.$tour_price_customer_type_id.'-'.$tour_price_age_type_id.'-0">'.$price.'</a>
						</td>
					';
				}	
				$html .= '
				</tr>';
			}
			$html .= '</table>
			<br style="clear:both" /><br />
			<strong>'.$core->get_Lang('Surcharge By Clients').'</strong>:
			<table cellpadding="5" cellspacing="2" class="tbl-grid" style="font-size:17px; width:auto;">';
			$lstPhuThu = $clsCategory->getAll("is_trash=0 and _type='PTKH' order by order_no asc");	
			for($i=0;$i<count($lstPhuThu);$i++){
				$html .= '
					<tr>
						<td>'.$clsCategory->getTitle($lstPhuThu[$i]['cat_id']).'</td>
						<td>
							<a href="#" title="'.$core->get_Lang('edit').'" style="color:red;" class="ajEditTourPriceCat" tour_id="'.$tour_id.'" tour_start_date_id="0" cat_id="'.$lstPhuThu[$i]['cat_id'].'" id="prc-'.$tour_id.'-'.$lstPhuThu[$i]['cat_id'].'-0">'.$clsISO->formatNumberToEasyRead($clsTour->getPriceCat($tour_id,$lstPhuThu[$i]['cat_id'],0)).'</a>'.$clsISO->getRateSign().'
							
						</td>
					</tr> 
				';
			}
			$html .= '</tr></table>
			';
		}
	}
	$html .= '<br style="clear:both" /><br />
		<p>'.$core->get_Lang('This is the general price system applies to all days of departure. If you want to add the date of departure,').'
		<a style="vertical-align:middle; padding:6px;" href="javascript:void(0);" class="iso-button-primary ajAddStartDate"><i class="icon-plus-sign"></i> '.$core->get_Lang('clickhere').'</a>
		
		</p>
		<div id="StartDateHolder" style="border:2px dashed red; padding:4px;"></div>
		';
		
	echo($html);die();
}
function default_ajDeleteTourStartDate(){
	$clsTourPriceVal = new TourPriceVal();
	$clsTourPriceUnit = new TourPriceUnit();
	$clsTourStartDate = new TourStartDate();
	$tour_id = $_POST['tour_id'];
	$departure = $_POST['departure'];
	$tour_start_date_id = $_POST['tour_start_date_id'];
	$clsTourStartDate->deleteByCond("tour_id='$tour_id' and tour_start_date_id='$tour_start_date_id'");
	$clsTourPriceUnit->deleteByCond("tour_start_date_id='$tour_start_date_id'");
	$clsTourPriceVal->deleteByCond("tour_id='$tour_id' and departure_date='$departure'");
	$clsTourPriceCat = new TourPriceCat();
	$clsTourPriceCat->deleteByCond("tour_start_date_id='$tour_start_date_id'");
	echo('');die();
}
function default_ajLoadEditTourStartDateElement(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	$clsTourStartDate = new TourStartDate();
	$tour_start_date_id = $_POST['tour_start_date_id'];
	$tp = $_POST['tp'];
	#
	$html = '';
	$html.='<div class="headPop">
				<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
				<h3>'.$core->get_Lang('edit').'</h3>
			</div>';
	$val = $clsTourStartDate->getOneField($tp,$tour_start_date_id);
	if($tp=='end_date'){
		$val = date('m/d/Y',$clsTourStartDate->getEndDate($tour_start_date_id)); 
	}
	$html .= '
			<div class="wrap">
				<div class="fl span100">
					<div class="row-span">
						<input type="text" class="fontLarge required" style="width:98%;" value="'.$val.'" id="TourStartDateElementVal" />
						<input type="hidden" id="default_end_date" value="'. date('m/d/Y',$clsTourStartDate->getEndDateDefault($tour_start_date_id)).'" />
						<br> 
						<a href="#" style="color:red" class="ajCopyTourStartDateElementFromDefault" tp="'.$tp.'">'.$core->get_Lang('reset').'</a>
						'.($tp=='end_date'?'<script type="text/javascript">
							$("#TourStartDateElementVal").datepicker();
						</script>':'').'
					</div>
				</div>
			</div>
		<div class="modal-footer">
			<button type="submit" itinerary_id=0 class="btn btn-primary clickToUpdateTourStartDateElement submitClick" tour_start_date_id="'.$tour_start_date_id.'" tp="'.$tp.'"><i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span> </button>
		</div>';
	echo($html);die();
}
function default_ajSaveTourStartDateElement(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	$clsTourStartDate = new TourStartDate();
	$tour_start_date_id = $_POST['tour_start_date_id'];
	$tp = $_POST['tp'];
	$clsISO = new ISO();
	if($tp=='price'||$tp=='price_old')
	$clsTourStartDate->updateOne($tour_start_date_id,$tp."='".$clsISO->processSmartNumber($_POST['val'])."'");
	else{
		if($tp=='end_date'){
			$val = explode('/',$_POST['val']);
			$ret =strtotime($_POST['val']);
			$html =  date('d/m/Y',$ret);
			$clsTourStartDate->updateOne($tour_start_date_id,$tp."='".addslashes($ret)."'");
		}else
			$clsTourStartDate->updateOne($tour_start_date_id,$tp."='".addslashes($_POST['val'])."'");
	}
	echo($html);die();
}
function default_ajResetTourPriceStartDate(){
	#
	$clsTour = new Tour();
	$clsTourStartDate = new TourStartDate();
	$clsTourPriceUnit = new TourPriceUnit();
	$clsTourPriceAgeType = new TourPriceAgeType();
	$clsTourPriceCustomerType = new TourPriceCustomerType();
	#
	$tour_id = $_POST['tour_id'];
	$lstAgeType = $clsTourPriceAgeType->getAll("tour_id='$tour_id' and is_trash=0 order by age_type_id asc");
	$lstCustomerType = $clsTourPriceCustomerType->getAll("tour_id='$tour_id' and is_trash=0 order by customer_type_id asc");
	#
	$lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id'");
	if($lstTourStartDate[0]['tour_id']!=''){
		for($u=0;$u<count($lstTourStartDate);$u++){
			$tour_start_date_id = $lstTourStartDate[$u]['tour_start_date_id'];
			for($i=0;$i<count($lstAgeType);$i++){
				for($k=0;$k<count($lstCustomerType);$k++){
					$tour_price_customer_type_id = $lstCustomerType[$k]['tour_price_customer_type_id']; 
					$tour_price_age_type_id = $lstAgeType[$i]['tour_price_age_type_id'];
					$tmp = $clsTourPriceUnit->getAll("tour_start_date_id='0' and tour_price_customer_type_id='$tour_price_customer_type_id' and tour_price_age_type_id='$tour_price_age_type_id' limit 0,1");
					$tmp2 = $clsTourPriceUnit->getAll("tour_start_date_id='$tour_start_date_id' and tour_price_customer_type_id='$tour_price_customer_type_id' and tour_price_age_type_id='$tour_price_age_type_id' limit 0,1");				
					$clsTourPriceUnit->updateOne($tmp2[0]['tour_price_unit_id'],"price='".$tmp[0]['price']."'");
				}
			}
			#
			if($clsTour->getTourTypeCategory($tour_id)==0){
				for($k=0;$k<count($lstCustomerType);$k++){
					$tour_price_customer_type_id = $lstCustomerType[$k]['tour_price_customer_type_id'];
					$tour_price_age_type_id = _PHUTHUPHONGDON;
					$tmp = $clsTourPriceUnit->getAll("tour_price_customer_type_id='".$tour_price_customer_type_id."' and tour_start_date_id='0' and tour_price_age_type_id='".$tour_price_age_type_id."' and tour_id='$tour_id' limit 0,1");
					$tmp2 = $clsTourPriceUnit->getAll("tour_price_customer_type_id='".$tour_price_customer_type_id."' and tour_start_date_id='$tour_start_date_id' and tour_price_age_type_id='".$tour_price_age_type_id."' and tour_id='$tour_id' limit 0,1");
					$clsTourPriceUnit->updateOne($tmp2[0]['tour_price_unit_id'],"price='".$tmp[0]['price']."'");
				}
			}
			else{
				$clsCategory = new Category();
				$lstPhuThu = $clsCategory->getAll("is_trash=0 and _type='PTKH' order by order_no asc");	
				$clsTourPriceCat = new TourPriceCat();
				$f = "tour_start_date_id,tour_id,cat_id,user_id,user_id_update,reg_date,upd_date,price";
				for($i=0;$i<count($lstPhuThu);$i++){
					$tmp = $clsTourPriceCat->getAll("tour_start_date_id='0' and tour_id='$tour_id' and cat_id='".$lstPhuThu[$i]['cat_id']."' limit 0,1");
					$tmp2 = $clsTourPriceCat->getAll("tour_start_date_id='$tour_start_date_id' and tour_id='$tour_id' and cat_id='".$lstPhuThu[$i]['cat_id']."' limit 0,1");
					$clsTourPriceCat->updateOne($tmp2[0]['tour_price_cat_id'],"price='".$tmp[0]['price']."'"); 
				}
			}
		}
	}
	#
	echo(0);die();
}

/* ========= SITE TOUR PRICE RANGE ========= */
function default_price_range(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsConfiguration;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	if(!$clsConfiguration->getValue('SiteHasPriceRange_Tours')){
		header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&message=NotPermission');
		exit();
	}
	#
	$type = isset($_GET['type'])? $_GET['type']:'1';
	$assign_list["type"] = $type;
}
function default_ajSiteFrmTourPriceRange(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsISO;
	#
	$clsPagination = new Pagination();
	$clsPriceRange = new PriceRange();
	#
	$user_id = $core->_USER['user_id'];
	$tp = isset($_POST['tp']) ? $_POST['tp']: '';
	$type = isset($_POST['type'])?$_POST['type']:'1';
	$price_range_id = isset($_POST['price_range_id'])?intval($_POST['price_range_id']):0;
	
	if($tp == 'L') {
		$number_per_page = isset($_POST['number_per_page'])?$_POST['number_per_page']:10;
		$page = isset($_POST['page'])?$_POST['page']:1;
		$keyword = isset($_POST['keyword'])?$_POST['keyword']:'';
		#
		$cond= "is_trash=0 and type='$type'";
		if(isset($keyword) && !empty($keyword)){
			$slug = $core->replaceSpace($keyword);
			$cond.=" and (slug like '%$slug%' or title like '%$keyword%')";
		}
		$allRecord = $clsPriceRange->getAll($cond);
		$totalRecord = $allRecord[0][$clsPriceRange->pkey] != '' ? count($allRecord) : 0;
		$pageview = $clsPagination->pagination_ajax($totalRecord,$number_per_page,$page);
		$offset = ($page-1)*$number_per_page;
		$cond.=" ORDER BY order_no ASC";
		$cond.=" LIMIT $offset,$number_per_page";
		#
		$html='';
		$lstItem = $clsPriceRange->getAll($cond);
		if(!empty($lstItem)){
			$i=0;
			foreach($lstItem as $item){
				$html.='<tr class="'.($i%2==0?'row1':'row2').'">';
				$html.='<td class="index">'.($i+1).'</td>';
				$html.='<td><strong>'.$clsPriceRange->getTitle($item[$clsPriceRange->pkey]).'</strong></td>';
				$html.='<td><strong class="format_price">'.$clsPriceRange->getMin($item[$clsPriceRange->pkey]).'&nbsp;'.$clsISO->getRate().'</strong></td>';
				$html.='<td><strong class="format_price">'.$clsPriceRange->getMax($item[$clsPriceRange->pkey]).'&nbsp;'.$clsISO->getRate().'</strong></td>';
				$html.='
					<td style="vertical-align: middle;text-align:center">
						'.($i==0?'':'<a title="'.$core->get_Lang('movetop').'" class="ajMovePriceRange" direct="movetop" data="'.$item[$clsPriceRange->pkey].'" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>').'
					</td>
					<td style="vertical-align: middle;text-align:center">'.($i==count($lstItem)-1 ? '' : '<a title="'.$core->get_Lang('movebottom').'" class="ajMovePriceRange" direct="movebottom" data="'.$item[$clsPriceRange->pkey].'" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>').'
					</td>
					<td style="vertical-align: middle;text-align:center">'.($i==0?'':'<a title="'.$core->get_Lang('moveup').'" class="ajMovePriceRange" direct="moveup" data="'.$item[$clsPriceRange->pkey].'" href="javascript:void();"><i class="icon-arrow-up"></i></a>').'
					</td>
					<td style="vertical-align: middle;text-align:center"> '.($i==count($lstItem)-1 ? '' : '<a title="'.$core->get_Lang('movedown').'" class="ajMovePriceRange" direct="movedown" data="'.$item[$clsPriceRange->pkey].'" href="javascript:void();"><i class="icon-arrow-down"></i></a>').'</td>';
				$html.='
					<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" style="right:0px !important">
								<li><a class="ajEditPriceRange" title="'.$core->get_Lang('edit').'" href="javascript:void();"  data="'.$item[$clsPriceRange->pkey].'"><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
								<li><a class="ajDeletePriceRange" title="'.$core->get_Lang('delete').'" href="javascript:void();"  data="'.$item[$clsPriceRange->pkey].'"><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
							</ul>
						</div>
					</td>';
				$html.='</tr>';
				++$i;
			}
		}
		else{
			$html.='<tr><td style="text-align:center" colspan="15">'.$core->get_Lang('nodata').'</td></tr>';
		}
		echo $html.'$$'.$pageview; die();
	} elseif($tp == 'F') {
		$html ='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($price_range_id>0?$core->get_Lang('edit'):$core->get_Lang('add')).' '.($type==1?$core->get_Lang('pricerangeinbound'):$core->get_Lang('pricerangeoutbound')).'</h3>
		</div>
		<form method="post" id="frmPriceRange" class="frmform" enctype="multipart/form-data">
			<table class="form" cellpadding="3" cellspacing="3">
				<tr>
					<td class="fieldlabel span15">'.$core->get_Lang('title').'</label>
					<td class="fieldarea">
						<input class="text fontLarge full" name="title" value="'.$clsPriceRange->getTitle($price_range_id).'" type="text" />
					</td>
				</tr>
				<tr>
					<td class="fieldlabel span15">'.$core->get_Lang('minrate').'</label>
					<td class="fieldarea">
						<input class="text fontLarge full price" value="'.$clsPriceRange->getMin($price_range_id).'" name="min_rate" type="text" />
					</td>
				</tr>
				<tr>
					<td class="fieldlabel span15">'.$core->get_Lang('maxrate').'</label>
					<td class="fieldarea">
						<input class="text fontLarge full price" value="'.$clsPriceRange->getMax($price_range_id).'" name="max_rate" type="text" />
					</td>
				</tr>
			</table>
			<div class="modal-footer">
				<button type="button" price_range_id="'.$price_range_id.'" class="btn btn-primary ajSubmitPriceRange"><i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span> </button>
				<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span> </button>
			</div>
		</form>';
		echo($html);die();
	} elseif($tp == 'S') {
		$titlePost = isset($_POST['title'])?trim(addslashes($_POST['title'])):'';
		$slugPost = $core->replaceSpace($titlePost);
		$min_rate = addslashes($_POST['min_rate']);
		$max_rate = addslashes($_POST['max_rate']);
		#
		if($price_range_id=='0'){
			$f="$clsPriceRange->pkey,title,slug,min_rate,max_rate,order_no,type";
			$v="'".$clsPriceRange->getMaxID."','$titlePost','$slugPost','".$clsISO->processSmartNumber($min_rate)."','".$clsISO->processSmartNumber($max_rate)."','".$clsPriceRange->getMaxOrderNo()."','$type'";
			if($clsPriceRange->insertOne($f,$v)){
				echo '_SUCCESS'; die();	
			}else{
				echo '_ERROR'; die();
			}
		}else{
			$v="title='$titlePost',slug='$slugPost',min_rate='".$clsISO->processSmartNumber($min_rate)."',max_rate='".$clsISO->processSmartNumber($max_rate)."',type='$type'";
			if($clsPriceRange->updateOne($price_range_id,$v)){
				echo '_UPDATE_SUCCESS'; die();	
			}else{
				echo '_ERROR'; die();
			}
		}
	} elseif($tp == 'D') {
		$clsPriceRange->deleteOne($price_range_id);
		echo(1); die();
	} elseif($tp == 'M') {
		$one = $clsPriceRange->getOne($price_range_id);
		$order_no = $one['order_no'];
		$direct = isset($_POST['direct'])?$_POST['direct']:'';
		
		if($direct=='moveup'){
			$lst = $clsPriceRange->getAll("is_trash=0 and order_no < $order_no order by order_no DESC limit 0,1");
			$clsPriceRange->updateOne($price_range_id,"order_no='".$lst[0]['order_no']."'");
			$clsPriceRange->updateOne($lst[0][$clsPriceRange->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movedown'){
			$lst = $clsPriceRange->getAll("is_trash=0 and order_no > $order_no order by order_no ASC limit 0,1");
			$clsPriceRange->updateOne($price_range_id,"order_no='".$lst[0]['order_no']."'");
			$clsPriceRange->updateOne($lst[0][$clsPriceRange->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movetop'){
			$lst = $clsPriceRange->getAll("is_trash=0 and order_no < $order_no order by order_no ASC");
			$clsPriceRange->updateOne($price_range_id,"order_no='".$lst[0]['order_no']."'");
			unset($lst);
			$lst = $clsPriceRange->getAll("is_trash=0 and price_range_id<>'$price_range_id' and order_no < $order_no order by order_no DESC");
			if(!empty($lst)){
				for($i=0;$i<count($lst);$i++) {
					$clsPriceRange->updateOne($lst[$i][$clsPriceRange->pkey],"order_no='".($lst[$i]['order_no']+1)."'");	
				}
			}
		}
		if($direct=='movebottom'){
			$lst = $clsPriceRange->getAll("is_trash=0 and order_no > $order_no order by order_no DESC");
			$clsPriceRange->updateOne($price_range_id,"order_no='".$lst[0]['order_no']."'");
			unset($lst);
			$lst = $clsPriceRange->getAll("is_trash=0 and price_range_id<>'$price_range_id' and order_no>$order_no order by order_no ASC");
			if(!empty($lst)){
				for($i=0;$i<count($lst);$i++) {
					$clsPriceRange->updateOne($lst[$i][$clsPriceRange->pkey],"order_no='".($lst[$i]['order_no']-1)."'");	
				}
			}
		}
		echo(1); die();
	}
}

function default_ajSiteFrmTourSizeGroup(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsISO;
	#
	$clsPagination = new Pagination();
	$clsTourOption = new TourOption();
	#
	$user_id = $core->_USER['user_id'];
	$tp = isset($_POST['tp']) ? $_POST['tp']: '';
	$type = isset($_POST['type'])?$_POST['type']:'1';
	$tour_option_id = isset($_POST['tour_option_id'])?intval($_POST['tour_option_id']):0;
	
	$tour_property_id = isset($_POST['tour_property_id'])?intval($_POST['tour_property_id']):0;
	
	if($tp == 'L') {
		$number_per_page = isset($_POST['number_per_page'])?$_POST['number_per_page']:10;
		$page = isset($_POST['page'])?$_POST['page']:1;
		$keyword = isset($_POST['keyword'])?$_POST['keyword']:'';
		#
		$cond= "is_trash=0 and tour_property_id='$tour_property_id' and type='$type'";
		if(isset($keyword) && !empty($keyword)){
			$slug = $core->replaceSpace($keyword);
			$cond.=" and (slug like '%$slug%' or title like '%$keyword%')";
		}
		$allRecord = $clsTourOption->getAll($cond);
		$totalRecord = $allRecord[0][$clsTourOption->pkey] != '' ? count($allRecord) : 0;
		$pageview = $clsPagination->pagination_ajax($totalRecord,$number_per_page,$page);
		$offset = ($page-1)*$number_per_page;
		$cond.=" ORDER BY number_to ASC";
		$cond.=" LIMIT $offset,$number_per_page";
		#
		$html='';
		$lstItem = $clsTourOption->getAll($cond);
		if(!empty($lstItem)){
			$i=0;
			foreach($lstItem as $item){
				$html.='<tr class="'.($i%2==0?'row1':'row2').'">';
				$html.='<td class="index">'.($i+1).'</td>';
				$html.='<td><strong>'.$clsTourOption->getTitle($item[$clsTourOption->pkey]).'</strong></td>';
				$html.='<td><strong class="format_price">'.$clsTourOption->getMin($item[$clsTourOption->pkey]).'</strong></td>';
				$html.='<td><strong class="format_price">'.$clsTourOption->getMax($item[$clsTourOption->pkey]).'</strong></td>';
				$html.='
					<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" style="right:0px !important">
								<li><a class="ajEditSizeGroup" title="'.$core->get_Lang('edit').'" href="javascript:void();" tour_property_id='.$tour_property_id.'  data="'.$item[$clsTourOption->pkey].'"><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
								<li><a class="ajDeleteSizeGroup" title="'.$core->get_Lang('delete').'" href="javascript:void();"  data="'.$item[$clsTourOption->pkey].'" tour_property_id='.$tour_property_id.'><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
							</ul>
						</div>
					</td>';
				$html.='</tr>';
				++$i;
			}
		}
		else{
			$html.='<tr><td style="text-align:center" colspan="15">'.$core->get_Lang('nodata').'</td></tr>';
		}
		echo $html.'$$'.$pageview; die();
	} elseif($tp == 'F') {
		//print_r($tour_option_id); die();
		$html ='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($tour_option_id>0?$core->get_Lang('edit'):$core->get_Lang('add')).' '.($type==1?$core->get_Lang('pricerangeinbound'):$core->get_Lang('pricerangeoutbound')).'</h3>
		</div>
		<form method="post" id="frmSizeGroup" class="frmform" enctype="multipart/form-data">
			<table class="form" cellpadding="3" cellspacing="3">
				<tr>
					<td class="fieldlabel span15">'.$core->get_Lang('title').'</label>
					<td class="fieldarea">
						<input class="text fontLarge full" name="title" value="'.$clsTourOption->getTitle($tour_option_id).'" type="text" {$tour_option_id} />
					</td>
				</tr>
				<tr>
					<td class="fieldlabel span15">'.$core->get_Lang('min people').'</label>
					<td class="fieldarea">
						<input class="text fontLarge full price" value="'.$clsTourOption->getMin($tour_option_id).'" name="number_from" type="text" />
					</td>
				</tr>
				<tr>
					<td class="fieldlabel span15">'.$core->get_Lang('max people').'</label>
					<td class="fieldarea">
						<input class="text fontLarge full price" value="'.$clsTourOption->getMax($tour_option_id).'" name="number_to" type="text" />
					</td>
				</tr>
			</table>
			<div class="modal-footer">
				<button type="button" tour_option_id="'.$tour_option_id.'" tour_property_id='.$tour_property_id.' class="btn btn-primary ajSubmitSizeGroup"><i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span> </button>
				<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span> </button>
			</div>
		</form>';
		echo($html);die();
	} elseif($tp == 'S') {
		$titlePost = isset($_POST['title'])?trim(addslashes($_POST['title'])):'SIZEGROUP';
		$titlePost = isset($_POST['title'])?trim(addslashes($_POST['title'])):'';
		$slugPost = $core->replaceSpace($titlePost);
		$tour_property_id = isset($_POST['tour_property_id'])?intval($_POST['tour_property_id']):'';
		$number_to = addslashes($_POST['number_to']);
		$number_from = addslashes($_POST['number_from']);
		#
		if($tour_option_id=='0'){
			$f="$clsTourOption->pkey,title,slug,number_to,number_from,order_no,type,tour_property_id";
			$v="'".$clsTourOption->getMaxID."','$titlePost','$slugPost','".$clsISO->processSmartNumber($number_to)."','".$clsISO->processSmartNumber($number_from)."','".$clsTourOption->getMaxOrderNo($target_id,$type)."','SIZEGROUP','$tour_property_id'";
			if($clsTourOption->insertOne($f,$v)){
				echo '_SUCCESS'; die();	
			}else{
				echo '_ERROR'; die();
			}
		}else{
			$v="title='$titlePost',slug='$slugPost',number_to='".$clsISO->processSmartNumber($number_to)."',number_from='".$clsISO->processSmartNumber($number_from)."',type='$type'";
			if($clsTourOption->updateOne($tour_option_id,$v)){
				echo '_UPDATE_SUCCESS'; die();	
			}else{
				echo '_ERROR'; die();
			}
		}
	} elseif($tp == 'D') {
		$clsTourOption->deleteOne($tour_option_id);
		echo(1); die();
	} elseif($tp == 'M') {
		$one = $clsTourOption->getOne($tour_option_id);
		$order_no = $one['order_no'];
		$direct = isset($_POST['direct'])?$_POST['direct']:'';
		
		if($direct=='moveup'){
			$lst = $clsTourOption->getAll("is_trash=0 and order_no < $order_no order by order_no DESC limit 0,1");
			$clsTourOption->updateOne($tour_option_id,"order_no='".$lst[0]['order_no']."'");
			$clsTourOption->updateOne($lst[0][$clsTourOption->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movedown'){
			$lst = $clsTourOption->getAll("is_trash=0 and order_no > $order_no order by order_no ASC limit 0,1");
			$clsTourOption->updateOne($tour_option_id,"order_no='".$lst[0]['order_no']."'");
			$clsTourOption->updateOne($lst[0][$clsTourOption->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movetop'){
			$lst = $clsTourOption->getAll("is_trash=0 and order_no < $order_no order by order_no ASC");
			$clsTourOption->updateOne($tour_option_id,"order_no='".$lst[0]['order_no']."'");
			unset($lst);
			$lst = $clsTourOption->getAll("is_trash=0 and tour_option_id<>'$tour_option_id' and order_no < $order_no order by order_no DESC");
			if(!empty($lst)){
				for($i=0;$i<count($lst);$i++) {
					$clsTourOption->updateOne($lst[$i][$clsTourOption->pkey],"order_no='".($lst[$i]['order_no']+1)."'");	
				}
			}
		}
		if($direct=='movebottom'){
			$lst = $clsTourOption->getAll("is_trash=0 and order_no > $order_no order by order_no DESC");
			$clsTourOption->updateOne($tour_option_id,"order_no='".$lst[0]['order_no']."'");
			unset($lst);
			$lst = $clsTourOption->getAll("is_trash=0 and tour_option_id<>'$tour_option_id' and order_no>$order_no order by order_no ASC");
			if(!empty($lst)){
				for($i=0;$i<count($lst);$i++) {
					$clsTourOption->updateOne($lst[$i][$clsTourOption->pkey],"order_no='".($lst[$i]['order_no']-1)."'");	
				}
			}
		}
		echo(1); die();
	}

}

/*------ Type Of Tours -------*/
function default_ajaxFrmHotDeal(){
	global $core, $clsISO;
	#
	$clsTour = new Tour();
	$tour_id = $_POST['tour_id'];
	#
	$html = '
	<div class="headPop"> 
		<a id="clickToCloseNewTourPriceRow" href="javascript:void();" class="closeEv close_pop"></a> 
		<h3>'.$core->get_Lang('updatehotdeals').'</h3> 
	</div> 
	<div class="wrap">
		<div class="fl span100">
			<div class="row-span">
				<input type="text" autocomplete="off" class="text full required fontLarge" name="title" id="hot_deals" value="'.$clsTour->getOneField('hot_deals', $tour_id).'" maxlength="3" />
			</div>
		</div>
	</div>
	<div class="modal-footer"> 
		<button class="btn btn-success ajaxSaveHotDeal" tour_id="'.$tour_id.'" toField="hot_deals">'.$core->get_Lang('save').'</button> 
		<button class="btn btn-warning close_pop" data-dismiss="modal" aria-hidden="true">'.$core->get_Lang('close').'</button> 
	</div>';
	echo($html);die();
}

/*------ Reviews Of Tours -------*/
function default_tourreview(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting,$clsConfiguration;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$clsUser = new User();
	$pUrl = '';
	$user_group_id = $clsUser->getOneField('user_group_id',$user_id);
	#
	$clsCountry = new Country(); $assign_list["clsCountry"] = $clsCountry;
	$clsTour = new Tour();$assign_list["clsTour"] = $clsTour;
	#
	$classTable = "Reviews";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	
	$string = isset($_GET['tour_id'])?$_GET['tour_id']:"";
	$tour_id = intval($core->decryptID($string));
	$assign_list['tour_id'] = $tour_id;
	
	if($string!='' && $tour_id==0){
		header('location:'.PCMS_URL.'/index.php?&mod='.$mod.'&message=notPermission');
	}
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		if(isset($tour_type_id) && intval($tour_type_id)!='0'){
			$link .= '&tour_type_id='.$tour_type_id;
		}
		if(isset($_POST['cat_id']) && intval($_POST['cat_id'])!='0'){
			$link .= '&cat_id='.$_POST['cat_id'];
		}
		if(isset($_POST['depart_point_id']) && intval($_POST['depart_point_id'])!='0'){
			$link .= '&depart_point_id='.$_POST['depart_point_id'];
		}
		if(isset($_POST['number_day']) && intval($_POST['number_day'])!='0'){
			$link .= '&number_day='.$_POST['number_day'];
		}
		if(isset($_POST['price_range_id']) && intval($_POST['price_range_id'])!='0'){
			$link .= '&price_range_id='.$_POST['price_range_id'];
		}
		if($_POST['keyword']!=''&&$_POST['keyword']!='Type trip code or tour name'){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	/**/
	$cond = "1=1 and tour_id = '$tour_id'";
	if(isset($_GET['keyword'])&&$_GET['keyword']!=''){
		$slug = $core->replaceSpace($_GET['keyword']);
		$cond .= " and ( trip_code like '%".$_GET['keyword']."%' or slug like '%".$slug."%' or title like '%".$slug."%')";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$cond2 = $cond;
	if($user_group_id==2){
		$cond .= " and is_online='0' and user_id='$user_id'";//
	}
	$orderBy = " order_no desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 30;
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
	$allAll =  $clsClassTable->getAll("is_trash=0");
	$assign_list["number_all"] = $allAll[0][$pkeyTable]!=''?count($allAll):0;
	$assign_list['pUrl'] = $pUrl;
}
function default_edittourreview(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$dbconn;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsTour = new Tour(); $assign_list["clsTour"] = $clsTour;
	$clsCountry=new _Country();$assign_list["clsCountry"] = $clsCountry;
	$assign_list["listCountry"] = $clsCountry->getAll("is_trash=0 order by order_no asc");
	#
	$classTable = "Reviews";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$tour_id = isset($_GET['tour_id'])? ($_GET['tour_id']) : '';
	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$assign_list['tour_id'] = $tour_id;
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;

	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	$clsForm->addInputTextArea("full",'content', "", 'content', 255, 25, 25, 1,  "style='width:100%'");
	
	if(($string!='' && $pvalTable==0) || ($tour_id=='' || $tour_id==0)){
		header('location:'.PCMS_URL.'/index.php?&mod='.$mod.'&message=notPermission');
	}
	
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
			$set .= ",slug='".$core->replaceSpace($_POST['iso-title'])."'";
			
			#--Special Field: image
			if(_isoman_use){
				$set .= ",image='".addslashes($_POST['isoman_url_image'])."'";
			} else {
				$image = $_POST['image'];
				if($image!=''&&$image!='0'){

					$set .= ",image='".addslashes($image)."'";
				}
			}
			
			if($clsClassTable->updateOne($pvalTable,$set)) {
				if($_POST['button']=='_EDIT'){
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&tour_id='.$tour_id.'&'.$clsClassTable->pkey.'='.$_GET[$clsClassTable->pkey].'&message=updateSuccess');
				}
				else{
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=tourreview&tour_id='.$core->encryptID($tour_id).'&message=updateSuccess');
				}
			} else{
				header('location: '.PCMS_URL.'/?mod='.$mod.'&act=tourreview&tour_id='.$core->encryptID($tour_id).'&message=updateFailed');
			}
		}
		else{
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
			$max_id = $clsClassTable->getMaxId();
			$max_order = $clsClassTable->getMaxOrder();
			$field .= ",user_id,user_id_update,reg_date,upd_date,slug,$clsClassTable->pkey,order_no";
			$value .= ",'".addslashes($core->_SESS->user_id)."','".addslashes($core->_SESS->user_id)."','".time()."','".time()."'";
			$value .= ",'".$core->replaceSpace($_POST['iso-title'])."','".$max_id."','".$max_order."'";
			
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
			if($clsClassTable->insertOne($field,$value)){
				if ($_POST['button'] == '_EDIT') {
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.'&tour_id='.$tour_id.'&'.$clsClassTable->pkey.'='.$core->encryptID($max_id).'&message=insertSuccess');
				}else{
					header('location: '.PCMS_URL.'/?mod='.$mod.'&act=tourreview&tour_id='.$core->encryptID($tour_id).'&message=insertSuccess');
				}
			}
			else{
				header('location: '.PCMS_URL.'/?mod='.$mod.'&act=tourreview&tour_id='.$core->encryptID($tour_id).'&message=insertFailed');
			}
		}
	}
}
function default_ajUpdateTourGlobal(){
	$clsReviews = new Reviews();
	$tour_id = isset($_POST['tour_id'])?intval($_POST['tour_id']):0;
	$tour_review_id = isset($_POST['tour_review_id'])?intval($_POST['tour_review_id']):0;
	#
	$clsReviews->updateOne($tour_review_id,"tour_id='$tour_id'");
	echo '_SUCCESS'; die();
}
function default_ajCaculatorTripPriceOld(){
	global $clsISO;
	
	$trip_old_price = $clsISO->processSmartNumber($_POST['trip_old_price']);
	$hot_deals = $clsISO->processSmartNumber($_POST['hot_deals']);
	echo $clsISO->formatNumberToEasyRead($trip_old_price-(($trip_old_price*$hot_deals)/100)); die();
}

/*============== TOUR SERVICE MANAGEMENT ================*/
function default_service(){
	global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	if(!$clsConfiguration->getValue('SiteHasService_Tours')){
		header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&message=NotPermission');
		exit();
	}
	#
	$classTable = "TourService";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
	
	$cond = "1=1";
	if(isset($_GET['keyword'])&&$_GET['keyword']!=''){
		$slug = $core->replaceSpace($_GET['keyword']);
		$cond .= " and ( trip_code like '%".$_GET['keyword']."%' or slug like '%".$slug."%' or title like '%".$slug."%')";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$cond2 = $cond;
	
	$orderBy = " order_no desc";
	if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    } elseif ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 30;
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
	$assign_list["allItem"] = $allItem;
	
	//Action
	$action = isset($_GET['action'])?$_GET['action']:'';
	if($action == 'Trash'){
		$string = isset($_GET['tourservice_id'])? ($_GET['tourservice_id']) : '';
		$tourservice_id = intval($core->decryptID($string));
		$pUrl = '';
		if($string=='' && $tourservice_id==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.$pUrl.'&message=NotPermission');
			exit();
		}
		if($clsClassTable->updateOne($tourservice_id,"is_trash='1'")){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.$pUrl.'&message=TrashSuccess');
		}	
	}
	if($action =='Restore'){
		$string = isset($_GET['tourservice_id'])? ($_GET['tourservice_id']) : '';
		$tourservice_id = intval($core->decryptID($string));
		$pUrl = '';
		if($string=='' && $tourservice_id==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.$pUrl.'&message=NotPermission');
			exit();
		}
		if($clsClassTable->updateOne($tourservice_id,"is_trash='0'")){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.$pUrl.'&message=RestoreSuccess');
		}	
	}
	if($action=='Delete'){
		$string = isset($_GET['tourservice_id'])? ($_GET['tourservice_id']) : '';
		$tourservice_id = intval($core->decryptID($string));
		$pUrl = '';
		if($string=='' && $tourservice_id==0){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.$pUrl.'&message=NotPermission');
			exit();
		}
		if($clsClassTable->deleteOne($tourservice_id)){
			header('location: '.PCMS_URL.'/?mod='.$mod.'&act='.$act.$pUrl.'&message=DeleteSuccess');
		}
	}
	if($action == 'move'){
		$string = isset($_GET['tourservice_id'])? ($_GET['tourservice_id']) : '';
		$pvalTable = intval($core->decryptID($string));
		$direct = isset($_GET['direct'])?$_GET['direct']:'';
		
		$one = $clsClassTable->getOne($pvalTable);
		$order_no = $one['order_no'];
		if(($string!='' && $pvalTable == 0) || $direct==''){
			header('location:'.PCMS_URL.'/index.php?admin&mod='.$mod.'&act='.$act.'&message=NotPermission');
			exit();
		}
		
		$where = "1='1' and is_trash=0";
		$pUrl = '&act=service';
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
}
function default_ajaxFrmService(){
	global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsTourService = new TourService();
	$tourservice_id = isset($_POST['tourservice_id'])? intval($_POST['tourservice_id']):0;
	#
	$html='
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
		<h3>'.($tourservice_id==0?$core->get_Lang('Add New Service'):$core->get_Lang('Edit Detail Service')).'</h3>
	</div>';
	$html .= '
	<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
		<div class="wrap">
			<div class="row-span">
				<div class="fieldlabel text-right bold"><strong class="color_r">'.$core->get_Lang('title').'</strong> <font color="red">*</font></div>
				<div class="fieldarea">
					<input class="text_32 full-width border_aaa required" name="title" value="'.$clsTourService->getTitle($tourservice_id).'" type="text" autocomplete="off" />
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel" style="text-align:right">'.$core->get_Lang('Image').'</div>
				<div class="fieldarea">
					<img class="isoman_img_pop" id="isoman_show_image" src="'.$clsTourService->getOneField('image',$tourservice_id).'" style="width:32px;height:32px"/>
					<input type="hidden" id="isoman_hidden_image" value="'.$clsTourService->getOneField('image',$tourservice_id).'">
					<input class="text_32 border_aaa fl ml10" style="width:70% !important;" type="text" id="isoman_url_image" name="image" value="'.$clsTourService->getOneField('image',$tourservice_id).'"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="'.$clsTourService->getOneField('image',$tourservice_id).'" isoman_name="image"><img src="'.URL_IMAGES.'/general/folder-32.png" border="0" title="Open" alt="Open"></a>
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel text-right"><strong class="color_r">* '.$core->get_Lang('price').'</strong></div>
				<div class="fieldarea">
					<input class="text full fontLarge required formatprice" style="width:30%" name="price" value="'.$clsTourService->getPrice($tourservice_id).'" type="text" autocomplete="off" />
					'.$clsISO->getRate().'/1Pax
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel  text-right">'.$core->get_Lang('intro').'</div>
				<div class="fieldarea">
					<textarea id="textarea_intro_editor'.time().'" class="textarea_intro_editor" name="intro" rows="5" style="width:100%">'.$clsTourService->getIntro($tourservice_id).'</textarea>
				</div>
			</div>
			
		</div>
	</form>
	<div class="modal-footer">
		<button type="button" tourservice_id="'.$tourservice_id.'" class="btn btn-primary btnSaveService">
			<i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span>
		</button>
		<button type="reset" class="btn btn-warning close_pop">
			<i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span>
		</button>
	</div>';
	echo($html);die();
}
function default_ajaxSaveService(){
	global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "TourService";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	#
	$tourservice_id = isset($_POST['tourservice_id'])?$_POST['tourservice_id']:0;
	$titlePost = trim($_POST['title']);
	$slugPost = $core->replaceSpace($titlePost);
	$pricePost = isset($_POST['price'])?$_POST['price']:0;
	$pricePost = $clsISO->processSmartNumber($pricePost);
	$introPost = addslashes($_POST['intro']);
	$imagePost = addslashes($_POST['image']);
	#
	if(intval($tourservice_id)==0){
		$all = $clsClassTable->getAll("is_trash=0 and slug like '%".$slugPost."' limit 0,1");
		if(!empty($all)){
			echo '_EXIST'; die();
		}else{
			$f="user_id,user_id_update,title,slug,price,intro,order_no,reg_date,upd_date";
			$v="'$user_id','$user_id','".addslashes($titlePost)."','".addslashes($slugPost)."','$pricePost','".addslashes($introPost)."'";
			$v.=",'".$clsClassTable->getMaxOrderNo()."','".time()."','".time()."'";
			if($imagePost != '' && $imagePost != '0'){
				$f .= ",image";
				$v .= ",'".$imagePost."'";
			}
			#
			if($clsClassTable->insertOne($f,$v)){
				echo '_SUCCESS'; die();	
			}else{
				echo '_ERROR'; die();
			}
		}
	}else{
		$vx = "title='".addslashes($titlePost)."',slug='".addslashes($slugPost)."',price='$pricePost',intro='$introPost',upd_date='".time()."',user_id_update='$user_id'";
		if($imagePost != '' && $imagePost != '0'){
			$vx .= ",image='".$imagePost."'";
		}
		if($clsClassTable->updateOne($tourservice_id,$vx)){
			echo '_SUCCESS'; die();	
		}else{
			echo '_ERROR'; die();
		}
	}
}
function default_ajLoadDepartPoint() {
	global $core;
	#
	$clsTour = new Tour();
	$clsCity = new City();
	#
	$cat_id=isset($_POST['cat_id'])?intval($_POST['cat_id']):0;
	$depart_point_id=isset($_POST['depart_point_id'])?intval($_POST['depart_point_id']):0;
	$tour_type_id=isset($_POST['tour_type_id'])?intval($_POST['tour_type_id']):0;
	$typeTour=isset($_POST['typeTour'])?addslashes($_POST['typeTour']):'';
	#
	$cond = "is_trash=0 and is_online=1";
	$cond.= " and city_id IN (SELECT city_id FROM ".DB_PREFIX."citystore WHERE type='DEPARTUREPOINT')";
	if(isset($typeTour) && !empty($typeTour)) {
		$cond.= " and city_id IN (SELECT city_id FROM ".DB_PREFIX."tour_destination WHERE tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_store WHERE _type = '$typeTour'))";
	}
	if(isset($cat_id) && intval($cat_id)!=0) {
		$cond.= " and city_id IN (SELECT city_id FROM ".DB_PREFIX."tour_destination WHERE tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE  is_trash=0 and is_online=1 and (cat_id = '$cat_id' or list_cat_id like '%|".$cat_id."|%')))";
	}
	if(isset($tour_type_id) && intval($tour_type_id)!=0) {
		$cond.= " and city_id IN (SELECT city_id FROM ".DB_PREFIX."tour_destination WHERE tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE  is_trash=0 and is_online=1 and tour_type_id = '$tour_type_id'))";
	}
	$cond.= " order by slug asc";
	#
	$lstCity=$clsCity->getAll($cond);
	$html='<option value="">-- '.$core->get_Lang('Select departure point').' --</option>';
	if(!empty($lstCity)){
		foreach($lstCity as $item){
			$selected_index=($depart_point_id==$item[$clsCity->pkey])?'selected="selected"':'';
			$html.='<option value="'.$item[$clsCity->pkey].'" '.$selected_index.'>-- '.$clsCity->getTitle($item[$clsCity->pkey]).' --</option>';
		}
	}
	echo $html;die();
}
function default_transport(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
}
function default_ajOpenTransport(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$clsTourProperty = new TourProperty();
	$type = $_POST['type'];
	$tp = isset($_POST['tp']) ? $_POST['tp'] : 'tp';
	$tour_property_id = isset($_POST['tour_property_id']) ? intval($_POST['tour_property_id']) : 0;
	
	if($tp=='F'){
		$html.='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($tour_property_id > 0 ? $core->get_Lang('edittransport') : $core->get_Lang('addnewtransport')).'</h3>
		</div>';
		#
		$order_no = ($tour_property_id > 0) ? $clsTourProperty->getOneField('order_no',$tour_property_id) : $clsTourProperty->getMaxOrderNo();
		$html .= '
		<form method="post" id="frmItinerary" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="row-span">
					<div class="fieldlabel font12px">'.$core->get_Lang('title').' <font color="#c00000">*</font></div>
					<div class="fieldarea"><input class="text full required" name="title" value="'.$clsTourProperty->getOneField('title',$tour_property_id).'" type="text"></div>
				</div>
				<div class="row-span">
					<div class="fieldlabel font12px">'.$core->get_Lang('intro').'</div>
					<div class="fieldarea">
						<textarea class="textarea full" name="intro" rows="5">'.$clsTourProperty->getOneField('intro',$tour_property_id).'</textarea>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel font12px">'.$core->get_Lang('position').'</div>
					<div class="fieldarea">
						<input class="text full span20 required" name="order_no" value="'.$order_no.'" type="number">
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">'.$core->get_Lang('Image').'</div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_image" src="'.$clsTourProperty->getOneField('image',$tour_property_id).'" />
						<input type="hidden" id="isoman_hidden_image" value="'.$clsTourProperty->getOneField('image',$tour_property_id).'">
						<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="'.$clsTourProperty->getOneField('image',$tour_property_id).'"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="'.$clsTourProperty->getOneField('image',$tour_property_id).'" isoman_name="image"><img src="'.URL_IMAGES.'/general/folder-32.png" border="0" alt="'.$core->get_Lang('open').'" /></a>
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="button" tour_property_id="'.$tour_property_id.'" _type="'.$type.'" class="btn btn-primary ajSubmitTransport">
				<i class="icon-ok icon-white"></i> <span>'.$core->get_Lang('save').'</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span>
			</button>
		</div>';
		echo($html);die();
	}
	else if($tp=='S'){
		$titlePost = addslashes($_POST['title']);
		$slugPost = $core->replaceSpace($titlePost);
		$introPost = addslashes($_POST['intro']);
		$order_no = addslashes($_POST['order_no']);
		$image = addslashes($_POST['image']);
		$type = addslashes($_POST['type']);
		#
		if($tour_property_id==0){
			if($clsTourProperty->countItem("is_trash=0 and type='$type' and slug='$slugPost'") > 0){
				echo '_EXIST'; die();	
			}else{
				$f = "title,slug,intro,order_no,image,type";
				$v = "'$titlePost','$slugPost','$introPost','$order_no','$image','$type'";
				#
				if($clsTourProperty->insertOne($f,$v)){
					echo '_INSUCCESS'; die();	
				}else{
					echo '_ERROR'; die();
				}
			}
		}else{
			$set = "title='$titlePost',slug='$slugPost',intro='$introPost',order_no='$order_no'";
			if($image !='' && $image !='0'){
				$set .= ",image='".addslashes($image)."'";
			}
			if($clsTourProperty->updateOne($tour_property_id,$set)){
				echo '_UPSUCCESS'; die();	
			}else{
				echo '_ERROR'; die();
			}
		}
	}
	else if($tp=='L'){
		$clsPagination = new Pagination();
		$where = "is_trash=0 and type='TRANSPORT'";
		$number_per_page = isset($_POST['number_per_page'])?$_POST['number_per_page']:10;
		$page = isset($_POST['page'])?$_POST['page']:1;
		#
		$keyword = isset($_POST['keyword'])?$_POST['keyword']:'';
		if($keyword!=''){
			$slug = $core->replaceSpace($keyword);
			$where.=" and (slug like '%$slug%' or title like '%$keyword%')";
		}
		$totalRecord = $clsTourProperty->countItem($where);
		$pageview = $clsPagination->pagination_ajax($totalRecord,$number_per_page,$page);
		$offset = ($page-1)*$number_per_page;
		$where .= " ORDER BY order_no ASC";
		$limit = " LIMIT $offset,$number_per_page";
		#
		$lstItem = $clsTourProperty->getAll($where.$limit);
		if(!empty($lstItem)){
			$i=0;
			foreach($lstItem as $item){
				$html.='<tr class="'.($i%2==0?'row1':'row2').'">';
				$html.='<td class="index"><img src="'.$item['image'].'" width="32px" height="32px" /></td>';
				$html.='<td><strong>'.$clsTourProperty->getTitle($item[$clsTourProperty->pkey]).'</strong></td>';
				$html.='<td>'.$clsTourProperty->getIntro($item[$clsTourProperty->pkey]).'</td>';
				$html.='
				<td style="vertical-align: middle;text-align:center">
					'.($i==0?'':'<a title="'.$core->get_Lang('movetop').'" class="btnmove_transport" direct="movetop" data="'.$item[$clsTourProperty->pkey].'" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>').'
				</td>
				<td style="vertical-align: middle;text-align:center">'.($i==count($lstItem)-1 ? '' : '<a title="'.$core->get_Lang('movebottom').'" class="btnmove_transport" direct="movebottom" data="'.$item[$clsTourProperty->pkey].'" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>').'
				</td>
				<td style="vertical-align: middle;text-align:center">'.($i==0?'':'<a title="'.$core->get_Lang('moveup').'" class="btnmove_transport" direct="moveup" data="'.$item[$clsTourProperty->pkey].'" href="javascript:void();"><i class="icon-arrow-up"></i></a>').'
				</td>
				<td style="vertical-align: middle;text-align:center">'.($i==count($lstItem)-1 ? '' : '<a title="'.$core->get_Lang('movedown').'" class="btnmove_transport" direct="movedown" data="'.$item[$clsTourProperty->pkey].'" href="javascript:void();"><i class="icon-arrow-down"></i></a>').'</td>';
				$html.='
				<td style="text-align:right">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown">
							<i class="icon-cog"></i> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a title="'.$core->get_Lang('edit').'" class="btnedit_transport" data="'.$item[$clsTourProperty->pkey].'" href="javascript:void();"><i class="icon-edit"></i> <span>'.$core->get_Lang('edit').'</span></a></li>
							<li><a title="'.$core->get_Lang('delete').'" class="btndelete_transport" data="'.$item[$clsTourProperty->pkey].'" href="javascript:void();"><i class="icon-remove"></i> <span>'.$core->get_Lang('delete').'</span></a></li>
						</ul>
					</div>
				</td>';
				$html.='
				</tr>';
				++$i;
			}
		}else{
			$html.='<tr><td style="text-align:center" colspan="8">'.$core->get_Lang('nodata').'</td></tr>';
		}
		echo $html.'$$'.$pageview; die();
	}
	else if($tp=='D'){
		$image = $clsTourProperty->getOneField('image',$tour_property_id);
		if($image!=''){
			$image_path = $_SERVER['DOCUMENT_ROOT'].$image;
			@chmod($image_path,0666);
			@unlink($image_path);
		}
		$clsTourProperty->deleteOne($tour_property_id);
		echo(1); die();
	}
	else if($tp=='M'){
		$direct = isset($_POST['direct']) ? $_POST['direct'] : '';
		$one = $clsTourProperty->getOne($tour_property_id);
		$order_no = $one['order_no'];
		$type = $one['type'];
		#
		$where = "is_trash=0 and type='$type'";
		if($direct=='moveup'){
			$lst = $clsTourProperty->getAll($where." and order_no < $order_no order by order_no DESC limit 0,1");
			$clsTourProperty->updateOne($tour_property_id,"order_no='".$lst[0]['order_no']."'");
			$clsTourProperty->updateOne($lst[0][$clsTourProperty->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movedown'){
			$lst = $clsTourProperty->getAll($where." and order_no > $order_no order by order_no ASC limit 0,1");
			$clsTourProperty->updateOne($tour_property_id,"order_no='".$lst[0]['order_no']."'");
			$clsTourProperty->updateOne($lst[0][$clsTourProperty->pkey],"order_no='".$order_no."'");
		}
		if($direct=='movetop'){
			$lst = $clsTourProperty->getAll($where." and order_no < $order_no order by order_no ASC");
			$clsTourProperty->updateOne($tour_property_id,"order_no='".$lst[0]['order_no']."'");
			unset($lst);
			$lst = $clsTourProperty->getAll($where." and tour_property_id<>'$tour_property_id' and order_no < $order_no order by order_no DESC");
			if(!empty($lst)){
				for($i=0;$i<count($lst);$i++) {
					$clsTourProperty->updateOne($lst[$i][$clsTourProperty->pkey],"order_no='".($lst[$i]['order_no']+1)."'");	
				}
			}
		}
		if($direct=='movebottom'){
			$lst = $clsTourProperty->getAll($where." and order_no > $order_no order by order_no DESC");
			$clsTourProperty->updateOne($tour_property_id,"order_no='".$lst[0]['order_no']."'");
			unset($lst);
			$lst = $clsTourProperty->getAll($where." and tour_property_id<>'$tour_property_id' and order_no>$order_no order by order_no ASC");
			if(!empty($lst)){
				for($i=0;$i<count($lst);$i++) {
					$clsTourProperty->updateOne($lst[$i][$clsTourProperty->pkey],"order_no='".($lst[$i]['order_no']-1)."'");	
				}
			}
		}
		echo(1); die();
	}
}
function default_ajLoadTourPriceGroup(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
	$user_id = $core->_USER['user_id'];
	#
	$clsTour = new Tour();
	$clsTourPriceGroup = new TourPriceGroup();
	$clsTourProperty = new TourProperty();
	$clsTourOption = new TourOption();
	$clsProperty = new Property();
	$clsTourStartDate = new TourStartDate();
	
	$currency = $clsConfiguration->getValue('Currency');
	$tour_id = isset($_POST['tour_id'])?intval($_POST['tour_id']):0;
	$tour_price_group_id = isset($_POST['tour_price_group_id'])?intval($_POST['tour_price_group_id']):0;
	$tour_class_id = isset($_POST['tour_class_id'])?intval($_POST['tour_class_id']):0;
	$tour_number_group_id = isset($_POST['tour_number_group_id'])?intval($_POST['tour_number_group_id']):0;
	$tour_visitor_type_id = isset($_POST['tour_visitor_type_id'])?intval($_POST['tour_visitor_type_id']):0;
	$departure=isset($_POST['departure'])?$_POST['departure']:0;
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	
	$lstTourClass = $clsTourProperty->getAll("is_trash=0 and type='TOURCLASS' order by order_no ASC");
	$lstTourNumberGroup = $clsTourProperty->getAll("is_trash=0 and type='TOURNUMBERGROUP' order by order_no ASC");
	$lstTourVisitorType  = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by tour_property_id ASC");
	
	
	
	$lstTourOption = $clsTour->getOneField('tour_option',$tour_id);
	$lstOption = array();
	if($lstTourOption != '' && $lstTourOption != '0'){
		$lstTourOption = str_replace('||','|',$lstTourOption);
		$lstTourOption = ltrim($lstTourOption,'|');
		$lstTourOption = rtrim($lstTourOption,'|'); 
		$TMP = explode('|',$lstTourOption);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lstOption)){
				$lstOption[] = $TMP[$i];
			}
		}
	}
	$assign_list['lstOption']=$lstOption;
	
	$lstAdultSizeGroup = $clsTour->getOneField('adult_group_size',$tour_id);
	$lstAdultSize = array();
	if($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0'){
		$lstAdultSizeGroup = str_replace('||','|',$lstAdultSizeGroup);
		$lstAdultSizeGroup = ltrim($lstAdultSizeGroup,'|');
		$lstAdultSizeGroup = rtrim($lstAdultSizeGroup,'|'); 
		$TMP = explode('|',$lstAdultSizeGroup);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lstAdultSize)){
				$lstAdultSize[] = $TMP[$i];
			}
		}
	}
	$assign_list['lstAdultSize']=$lstAdultSize;
	
	
	$lstChildSizeGroup = $clsTour->getOneField('child_group_size',$tour_id);
	$lstChildSize = array();
	if($lstChildSizeGroup != '' && $lstChildSizeGroup != '0'){
		$lstChildSizeGroup = str_replace('||','|',$lstChildSizeGroup);
		$lstChildSizeGroup = ltrim($lstChildSizeGroup,'|');
		$lstChildSizeGroup = rtrim($lstChildSizeGroup,'|'); 
		$TMP = explode('|',$lstChildSizeGroup);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lstChildSize)){
				$lstChildSize[] = $TMP[$i];
			}
		}
	}
	$assign_list['lstChildSize']=$lstChildSize;
	
	
	
	$lstInfantSizeGroup = $clsTour->getOneField('infant_group_size',$tour_id);
	$lstInfantSize = array();
	if($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0'){
		$lstInfantSizeGroup = str_replace('||','|',$lstInfantSizeGroup);
		$lstInfantSizeGroup = ltrim($lstInfantSizeGroup,'|');
		$lstInfantSizeGroup = rtrim($lstInfantSizeGroup,'|'); 
		$TMP = explode('|',$lstInfantSizeGroup);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lstInfantSize)){
				$lstInfantSize[] = $TMP[$i];
			}
		}
	}
	$assign_list['lstInfantSize']=$lstInfantSize;
	
	
	if($tp=='L'){
		$html = '';
		if(!empty($lstOption)){
			$html .= '
			<table class="table tbl-grid" style="border:1px solid #ccc; min-width:100%;" >
				<thead>
					<tr>
						<td class="gridheader" width="150" height="50" rowspan="2">
							<div class="h-boxdiagonal">
							<div class="h-diagonal"></div>
							<div class="boxdiagonal-class"><strong><span class="table_price_title">'.$core->get_Lang('Tour Class').'</span></strong></div>
							<div class="boxdiagonal-group"><strong><span class="table_price_title">'.$core->get_Lang('Group Number').'</span></strong></div>
						</div>
						</td>
						';
						foreach($lstTourVisitorType as $key=>$val){
							if($val[$clsTourProperty->pkey]==16){
								$html .= '	<td class="gridheader" colspan="'.count($lstAdultSize).'">
										<strong><span class="table_price_title">'.$clsTourProperty->getTitle($val[$clsTourProperty->pkey]).'</span></strong>
									</td>';	
							}elseif($val[$clsTourProperty->pkey]==17){
								$html .= '	<td class="gridheader" colspan="'.count($lstChildSize).'">
										<strong><span class="table_price_title">'.$clsTourProperty->getTitle($val[$clsTourProperty->pkey]).'</span></strong>
									</td>';	
							}else{
								$html .= '	<td class="gridheader" colspan="'.count($lstInfantSize).'">
										<strong><span class="table_price_title">'.$clsTourProperty->getTitle($val[$clsTourProperty->pkey]).'</span></strong>
									</td>';	
							}
						
						}	
						$html .= '	<td class="gridheader" rowspan="2">
							<strong><span class="table_price_title">'.$core->get_Lang('Single supplement').'</span></strong>
						</td>';	
					$html .= '	
					</tr>	
					<tr>';
			foreach($lstTourVisitorType as $a=>$b){
				if($b[$clsTourProperty->pkey]==16){
					foreach($lstAdultSize as $k16=>$v16){
						$html .= 	'<td class="gridheader" style="text-align:center;">'.$clsTourOption->getTitle($v16).'</td>';
					}
				}elseif($b[$clsTourProperty->pkey]==17){
					foreach($lstChildSize as $k17=>$v17){
						$html .= 	'<td class="gridheader" style="text-align:center;">'.$clsTourOption->getTitle($v17).'</td>';
					}
				}else{
					foreach($lstInfantSize as $k18=>$v18){
						$html .= 	'<td class="gridheader" style="text-align:center;">'.$clsTourOption->getTitle($v18).'</td>';
					}
				}
				
			}
			$html.= '
					</tr>
				</thead>';
			foreach($lstOption as $key=>$val){
			$html .= '
					<tr>
						<td style="text-align:left;"><strong val='.$val.'>'.$clsTourOption->getTitle($val).'</strong></td>';
				foreach($lstTourVisitorType as $a=>$b){
					if($b[$clsTourProperty->pkey]==16){
						foreach($lstAdultSize as $k16=>$v16){
						$html .= '
							<td class="text-center">
								'.$clsProperty->getOneField('property_code',$currency).'<br />
								<input class="text full price-In h_tour_price_group fontLarge" style="width:85px; text-align:right; color:red;" tour_id="'.$tour_id.'" tour_class_id="'.$val.'" tour_number_group_id="'.$v16.'" tour_visitor_type_id="'.$b[$clsTourProperty->pkey].'" departure="'.$departure.'" value="'.$clsTourPriceGroup->getPrice($tour_id,$val,$v16,$b[$clsTourProperty->pkey],$departure).'" type="text" />
							</td>';	
						}
					}elseif($b[$clsTourProperty->pkey]==17){
						foreach($lstChildSize as $k17=>$v17){
						$html .= '
							<td class="text-center">
								'.$clsProperty->getOneField('property_code',$currency).'<br />
								<input class="text full price-In h_tour_price_group fontLarge" style="width:85px; text-align:right; color:red;" tour_id="'.$tour_id.'" tour_class_id="'.$val.'" tour_number_group_id="'.$v17.'" tour_visitor_type_id="'.$b[$clsTourProperty->pkey].'" departure="'.$departure.'" value="'.$clsTourPriceGroup->getPrice($tour_id,$val,$v17,$b[$clsTourProperty->pkey],$departure).'" type="text" />
							</td>';	
						}
					}else{
						foreach($lstInfantSize as $k18=>$v18){
						$html .= '
							<td class="text-center">
								'.$clsProperty->getOneField('property_code',$currency).'<br />
								<input class="text full price-In h_tour_price_group fontLarge" style="width:85px; text-align:right; color:red;" tour_id="'.$tour_id.'" tour_class_id="'.$val.'" tour_number_group_id="'.$v18.'" tour_visitor_type_id="'.$b[$clsTourProperty->pkey].'" departure="'.$departure.'" value="'.$clsTourPriceGroup->getPrice($tour_id,$val,$v18,$b[$clsTourProperty->pkey],$departure).'" type="text" />
							</td>';	
						}
					}	
				}
			$html .= '
						<td class="text-center">
							'.$clsProperty->getOneField('property_code',$currency).'<br />
							<input class="text full price-In h_price_single_supply fontLarge" style="width:85px; text-align:right; color:red;" tour_id="'.$tour_id.'" tour_class_id="'.$val.'" value="'.$clsTourPriceGroup->getPriceSingleSupply($tour_id,$val,$departure).'" type="text" departure="'.$departure.'" />
						</td>';	
			$html .= '
					</tr>';
			}
			$html .= '
			</table>';
			if($departure!=''){
			$html .= '
			<div class="mt10">
			<label style="width:110px">'.$core->get_Lang('Available Seats').'</label>
			<input type="text" name="available" id="available" value="'.$clsTourStartDate->getAllotmentTourGroup($tour_id,$departure,0).'" min="0" style="width;120px; line-height:32px; font-weight:bold; font-size:16px;" start_date="'.$departure.'" tour_id="'.$tour_id.'"/>
			</div>
			<div class="mt10">
			<label style="width:110px">'.$core->get_Lang('Deposit').'(%)</label>
			<input type="text" name="deposit_departure" id="deposit_departure" start_date="'.$departure.'" tour_id="'.$tour_id.'" value="'.$clsTourStartDate->getDepositDeparture($tour_id,$departure,0).'" min="0" style="width;120px;line-height:32px; font-weight:bold;font-size:16px;"/>
			</div>
			';
			}
		}
		#
		echo($html);die();
	}elseif($tp == 'F') {
		$html = '';
		$html.='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.($tour_price_group_id==0?$core->get_Lang('Add Tour Price Group'):$core->get_Lang('Edit Tour Price Group')).'- [ID #'.$tour_id.']</h3>
		</div>';
		$html .= '
		<form method="post" id="tblTourPriceGroup" class="frmform formborder" enctype="multipart/form-data" style="width:100%;overflow:auto">
			<table class="table tbl-grid" style="border:1px solid #ccc; min-width:100%;">
				<thead>
					<tr>
						<td class="gridheader" width="150" height="50" rowspan="2">
							<div class="h-boxdiagonal">
							<div class="h-diagonal"></div>
							<div class="boxdiagonal-class"><strong><span class="table_price_title">'.$core->get_Lang('Tour Class').'</span></strong></div>
							<div class="boxdiagonal-group"><strong><span class="table_price_title">'.$core->get_Lang('Group Number').'</span></strong></div>
						</div>
						</td>
						';
			foreach($lstTourVisitorType as $key=>$val){
				if($val[$clsTourProperty->pkey]==16){
					$html .= '	<td class="gridheader" colspan="'.count($lstAdultSize).'">
							<strong><span class="table_price_title">'.$clsTourProperty->getTitle($val[$clsTourProperty->pkey]).'</span></strong>
						</td>';	
				}elseif($val[$clsTourProperty->pkey]==17){
					$html .= '	<td class="gridheader" colspan="'.count($lstChildSize).'">
							<strong><span class="table_price_title">'.$clsTourProperty->getTitle($val[$clsTourProperty->pkey]).'</span></strong>
						</td>';	
				}else{
					$html .= '	<td class="gridheader" colspan="'.count($lstInfantSize).'">
							<strong><span class="table_price_title">'.$clsTourProperty->getTitle($val[$clsTourProperty->pkey]).'</span></strong>
						</td>';	
				}
			
			}	
			$html .= '	<td class="gridheader" rowspan="2">
							<strong><span class="table_price_title">'.$core->get_Lang('Single supplement').'</span></strong>
						</td>';	
			$html .= '	
					</tr>	
					<tr>';
		foreach($lstTourVisitorType as $a=>$b){
			if($b[$clsTourProperty->pkey]==16){
				foreach($lstAdultSize as $k16=>$v16){
					$html .= 	'<td class="gridheader" style="text-align:center;">'.$clsTourOption->getTitle($v16).'</td>';
				}
			}elseif($b[$clsTourProperty->pkey]==17){
				foreach($lstChildSize as $k17=>$v17){
					$html .= 	'<td class="gridheader" style="text-align:center;">'.$clsTourOption->getTitle($v17).'</td>';
				}
			}else{
				foreach($lstInfantSize as $k18=>$v18){
					$html .= 	'<td class="gridheader" style="text-align:center;">'.$clsTourOption->getTitle($v18).'</td>';
				}
			}
			
		}
			$html.= '
					</tr>
				</thead>';
			foreach($lstOption as $key=>$val){
			$html .= '
					<tr>
						<td style="text-align:left;"><strong>'.$clsTourOption->getTitle($val).'</strong></td>';
				foreach($lstTourVisitorType as $a=>$b){
					if($b[$clsTourProperty->pkey]==16){
						foreach($lstAdultSize as $k16=>$v16){
						$html .= '
							<td class="text-center">
								'.$clsProperty->getOneField('property_code',$currency).'<br />
								<input class="text full price-In h_tour_price_group fontLarge" style="width:85px; text-align:right; color:red;" tour_id="'.$tour_id.'" tour_class_id="'.$val.'" tour_number_group_id="'.$v16.'" tour_visitor_type_id="'.$b[$clsTourProperty->pkey].'" departure="'.$departure.'" value="'.$clsTourPriceGroup->getPrice($tour_id,$val,$v16,$b[$clsTourProperty->pkey],$departure).'" type="text" />
							</td>';	
						}
					}elseif($b[$clsTourProperty->pkey]==17){
						foreach($lstChildSize as $k17=>$v17){
						$html .= '
							<td class="text-center">
								'.$clsProperty->getOneField('property_code',$currency).'<br />
								<input class="text full price-In h_tour_price_group fontLarge" style="width:85px; text-align:right; color:red;" tour_id="'.$tour_id.'" tour_class_id="'.$val.'" tour_number_group_id="'.$v17.'" tour_visitor_type_id="'.$b[$clsTourProperty->pkey].'" departure="'.$departure.'" value="'.$clsTourPriceGroup->getPrice($tour_id,$val,$v17,$b[$clsTourProperty->pkey],$departure).'" type="text" />
							</td>';	
						}
					}else{
						foreach($lstInfantSize as $k18=>$v18){
						$html .= '
							<td class="text-center">
								'.$clsProperty->getOneField('property_code',$currency).'<br />
								<input class="text full price-In h_tour_price_group fontLarge" style="width:85px; text-align:right; color:red;" tour_id="'.$tour_id.'" tour_class_id="'.$val.'" tour_number_group_id="'.$v18.'" tour_visitor_type_id="'.$b[$clsTourProperty->pkey].'" departure="'.$departure.'" value="'.$clsTourPriceGroup->getPrice($tour_id,$val,$v18,$b[$clsTourProperty->pkey],$departure).'" type="text" />
							</td>';	
						}
					}	
				}
			$html .= '
						<td class="text-center">
							'.$clsProperty->getOneField('property_code',$currency).'<br />
							<input class="text full price-In h_price_single_supply fontLarge" style="width:85px; text-align:right; color:red;" tour_id="'.$tour_id.'" tour_class_id="'.$val.'" value="'.$clsTourPriceGroup->getPriceSingleSupply($tour_id,$val,$departure).'" departure="'.$departure.'" type="text" />
						</td>';	
			$html .= '
					</tr>';
			}
			$html .= '
			</table>';
			$html .= '
			</table>';
			$html .= '
			<div class="mt10">
			<label style="width:110px">'.$core->get_Lang('Available Seats').'</label>
			<input type="text" name="available" id="available" value="'.$clsTourStartDate->getAllotmentTourGroup($tour_id,$departure,0).'" min="0" style="width;120px; line-height:32px; font-weight:bold; font-size:16px;" start_date="'.$departure.'" tour_id="'.$tour_id.'"/>
			</div>
			<div class="mt10">
			<label style="width:110px">'.$core->get_Lang('Deposit').'(%)</label>
			<input type="text" name="deposit_departure" id="deposit_departure" start_date="'.$departure.'" tour_id="'.$tour_id.'" value="'.$clsTourStartDate->getDepositDeparture($tour_id,$departure,0).'" min="0" style="width;120px;line-height:32px; font-weight:bold;font-size:16px;"/>
			</div>
			
			';
		$html .= '</form>
		<div class="modal-footer">
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span>
			</button>
		</div>';
		$html.='
		<script type="text/javascript">
			$(function(){
				$(".close_pop").click(function(){
					loadListPriceTourGroupStartDate();
				});
				
			});
		</script>';
		echo($html);die();
	} else if($tp=='S'){
		$price = $_POST['price'];
		$res = $clsTourPriceGroup->getAll("tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id='$tour_visitor_type_id' and departure_date='$departure'");
		if($res[0]['tour_price_group_id'] != ''){
			$clsTourPriceGroup->updateOne($res[0]['tour_price_group_id'],"price='".$clsISO->processSmartNumber($price)."'");
		}else{
			$f = "tour_id,tour_class_id,tour_number_group_id,tour_visitor_type_id,price,departure_date,user_id,user_id_update,reg_date,upd_date";
			$v = "'$tour_id'
				,'$tour_class_id'
				,'$tour_number_group_id'
				,'$tour_visitor_type_id'
				,'".$clsISO->processSmartNumber($price)."'
				,'$departure'
				,'$user_id'
				,'$user_id'
				,'".time()."'
				,'".time()."'
			";
			$clsTourPriceGroup->insertOne($f, $v);	
		}
		echo '0|||'.$clsISO->formatPrice($price); die();
	}
	else if($tp=='SINGLE'){
		$departure_date = $_POST['departure_date'];
		$price_single = $_POST['price_single'];
		$res = $clsTourPriceGroup->getAll("tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='0' and tour_visitor_type_id='0' and departure_date='$departure_date'");
		if($res[0]['tour_price_group_id'] != ''){
			$clsTourPriceGroup->updateOne($res[0]['tour_price_group_id'],"price_single_supply='".$clsISO->processSmartNumber($price_single)."'");
		}else{
			$f = "tour_id,tour_class_id,tour_number_group_id,tour_visitor_type_id,departure_date,price_single_supply,user_id,user_id_update,reg_date,upd_date";
			$v = "'$tour_id'
				,'$tour_class_id'
				,'0'
				,'0'
				,'$departure_date'
				,'".$clsISO->processSmartNumber($price_single)."'
				,'$user_id'
				,'$user_id'
				,'".time()."'
				,'".time()."'
			";
			$clsTourPriceGroup->insertOne($f, $v);	
		}
		echo '0|||'.$clsISO->formatPrice($price_single); die();
	}
}
/* Tailor */
function default_tailor(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	
	$classTable = "TailorProperty";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$listType = $clsClassTable->getListType();
	$assign_list["listType"] = $listType;
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	if($type==''){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&act=tailor&type=_TRANSPORT');
		exit();
	}
	$assign_list["type"] = $type;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = '&act=tailor&type='.$type;
		if(isset($_POST['keyword']) && !empty($_POST['keyword'])){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	#
	$cond = "1='1' and type='$type'";
	#Filter By Keyword
	if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (title like '%".$_GET['keyword']."%' or slug like '%".$keyword."%')";
		$assign_list["keyword"] = $_GET['keyword'];
	}
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
	#-------End Page Divide-----------------------------------------------------------
	$allItem = $clsClassTable->getAll($cond." order by ".$orderBy.$limit);
	$assign_list["allItem"] = $allItem;
}
function default_ajOpenTailorProperty(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	
	$clsTailorProperty = new TailorProperty();
	$type = isset($_POST['type']) ? $_POST['type'] : '';
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	$tailor_property_id = isset($_POST['tailor_property_id']) ? intval($_POST['tailor_property_id']) : 0;
	
	if($tp=='F'){
		$html = '
		<div class="headPop">
			<a href="javascript:void();" title="'.$core->get_Lang('close').'" class="closeEv close_pop">&nbsp;</a>
			<h3>'.($tailor_property_id==0?$core->get_Lang('add'):$core->get_Lang('edit')).' '.$clsTailorProperty->getTextByType($type).'</h3> 
		</div>
		<table class="form" cellpadding="3" cellspacing="3">
			<tr>
				<td class="fieldarea">
					<input placeholder="'.$core->get_Lang('entertitle').'" type="text" name="title" class="required fontLarge full text" value="'.$clsTailorProperty->getTitle($tailor_property_id).'">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<select class="slb" id="type">
						'.$clsTailorProperty->getSelectByType($type).'
					</select>
				</td>
			</tr>
		</table>
		<div class="modal-footer"> 
			<button class="btn btn-primary submitClick" id="clickSubmitProperty" tailor_property_id="'.$tailor_property_id.'">
				<i class="icon-white icon-ok"></i> <span>'.$core->get_Lang('save').'</span></button> 
			<button class="btn btn-warning close_pop" data-dismiss="modal" aria-hidden="true">'.$core->get_Lang('close').'</button> 
		</div>';
		echo($html);die();
	}
	else if($tp=='D'){
		$clsTailorProperty->deleteOne($tailor_property_id);
		echo(1); die();
	}
	else if($tp=='S'){
		$titlePost = isset($_POST['title'])?trim(strip_tags($_POST['title'])):'';
		$slugPost = $core->replaceSpace($titlePost);
		$type = $_POST['type'];
		
		if($tailor_property_id == 0){
			if($clsTailorProperty->countItem("slug='$slugPost' and type='$type'")){
				echo('_EXIST'); die();
			}else{
				$fx = "$clsTailorProperty->pkey,title,slug,order_no,type";
				$vx = "'".$clsTailorProperty->getMaxID()."','".addslashes($titlePost)."','$slugPost','".$clsTailorProperty->getMaxOrderNo()."','$type'";
				if($clsTailorProperty->insertOne($f,$v)){
					echo('_SUCCESS'); die();
				}else{
					echo('_ERROR'); die();
				}
			}
		}else{
			if($clsTailorProperty->countItem("slug='$slugPost' and type='$type' and tailor_property_id <> '$tailor_property_id'")){
				echo('_EXIST'); die();
			}else{
				$set = "title='$titlePost',slug='$slugPost'";
				if($clsTailorProperty->updateOne($tailor_property_id,$set)){
					echo('_SUCCESS'); die();
				}else{
					echo('_ERROR'); die();
				}
			}
		}
	}
}
function default_ajCaculatorPriceAdvert(){
	global $clsISO;
	
	$price = $clsISO->processSmartNumber($_POST['price']);
	echo $price; die();
}
function default_move_property(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	
	$classTable = "TailorProperty";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	
	$string = isset($_GET[$pkeyTable])? $_GET[$pkeyTable] : "";
	$pvalTable = intval($core->decryptID($string));
	$direct = isset($_GET['direct'])? $_GET['direct']:'';
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	
	$one = $clsClassTable->getOne($pvalTable);
	$order_no = $one['order_no'];
	if(($string!='' && $pvalTable == 0) || $direct==''){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&act=tailor');
	}
	
	$where = '1=1 and is_trash=0';
	$pUrl = '&act=tailor';
	if(!empty($type)){
		$where.=" and type = '$type'";
		$pUrl .= '&type='.$type;
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
		$lstItem = $clsClassTable->getAll($where." and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
		for($i=0;$i<count($lstItem);$i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey],"order_no='".($lstItem[$i]['order_no']+1)."'");	
		}
	}
	header('location: '.PCMS_URL.'/?mod='.$mod.$pUrl.'&message=PositionSuccess');
}
function default_ajUpdateTourStore(){
	global $core,$dbconn;
	#
	$clsClassTable = new TourStore();
	$_type = isset($_POST['_type'])?$_POST['_type']:'';
	$tour_id = isset($_POST['tour_id'])?$_POST['tour_id']:0;
	$val = isset($_POST['val'])?$_POST['val']:0;
	$user_id = $core->_USER['user_id'];
	#
	$lst = $clsClassTable->getAll("tour_id='$tour_id' and _type = '".$_type."' limit 0,1");
	if(isset($lst[0][$clsClassTable->pkey]) && $val==0) {
		$tour_store_id = $lst[0][$clsClassTable->pkey];
		$clsClassTable->deleteOne($tour_store_id);
	} else {
		$fx = "tour_store_id,tour_id,_type,order_no";
		$vx = "'".$clsClassTable->getMaxID()."','$tour_id','$_type','".$clsClassTable->getMaxOrder($_type)."'";
		$clsClassTable->insertOne($fx,$vx);
	}
	echo 1; die();
}
function default_ajAddTourOption(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsTour = new Tour();
	$clsTourOption = new TourOption();
	#
	$target_id = isset($_POST['target_id'])?intval($_POST['target_id']):'';
	
	$type = isset($_POST['type'])?$_POST['type']:'TOUROPTION';

	$user_id = $core->_USER['user_id'];

	$title ='Tour option'.' '.$clsTourOption->getMaxOrder($type);
	$f = "title,slug,target_id,user_id,reg_date,upd_date,type,order_no";
	$v = "'".$title."','".$core->replaceSpace($title)."','".$_POST['target_id']."','$user_id','".time()."','".time()."','$type','".$clsTourOption->getMaxOrder($type)."'";
	$clsTourOption->insertOne($f,$v);
	#
	echo(1);die();
}

function default_ajLoadListTourOption(){
	global $core,$clsISO,$clsConfiguration;
	$clsTour = new Tour();
	$clsProperty = new Property();
	$clsTourOption = new TourOption();

	#
	$currency = $clsConfiguration->getValue('Currency');
	$tp = isset($_POST['tp'])?$_POST['tp']:'';
	
	if($tp=='loadList'){
		$html = '';
		$lstTourOption = $clsTourOption->getAll("type='TOUROPTION' order by order_no desc");
		if($lstTourOption[0][$clsTourOption->pkey]!=''){
			$html .= '<p class="mb10" style="font-size:18px; display:inline-block; line-height:30px; vertical-align:top"><span  style="display:inline-block; line-height:30px;">'.$core->get_Lang('List tour option').'  </span>
			</p>
			<div id="ListTourOption" style="width:100%;">
			<table class="tbl-grid" cellspacing="0" width="100%">
			<tr>
			<td class="gridheader" style="text-align:left"><strong>'.$core->get_Lang('No.').'</strong></td>
			<td class="gridheader" style="text-align:left"><strong>'.$core->get_Lang('Title').'</strong></td>
			<td class="gridheader" style="text-align:center"><strong>'.$core->get_Lang('Function').'</strong></td></tr>';
			for($m=0;$m<count($lstTourOption);$m++){
			$tour_option_id = $lstTourOption[$m][$clsTourOption->pkey];
			$html .= '
			<tr style="'.($m%2==0?'background:#eee':'background:#fff').'">
				<td class="index"><strong>'.($m+1).'</strong></td>
				<td><strong>'.$lstTourOption[$m]['title'].'</strong></td>
				';
				$html .= '
				<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
					<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
					<ul class="dropdown-menu" style="right:0px !important">
						<li><a title="'.$core->get_Lang('Edit').'" tour_option_id="'.$tour_option_id.'" target_id="'.$target_id.'" class="clickEditTourOption" href="#"><i class="icon-edit"></i> <span>Edit</a></li>
						<li><a title="'.$core->get_Lang('delete').'" tour_option_id="'.$tour_option_id.'" target_id="'.$target_id.'" class="clickDeleteTourOption" href="#"><i class="icon-trash"></i>'.$core->get_Lang('delete').'</a></li>
					</ul>
				</div>
			</td>
				'; 
				$html .= '
			</tr>';
			}
			$html .= '
			</table>
			</div>';
		}	
	}elseif($tp == 'Edit') {
		$tour_option_id = isset($_POST['tour_option_id']) ? intval($_POST['tour_option_id']) : 0;
		$html = '';
		$html .= '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.$core->get_Lang('Edit Tour Option ').'- [ID #'.$tour_option_id.']</h3>
		</div>
		<div class="row-span">
			<input type="text" name="title" class="text full fontLarge required" value="'.$clsTourOption->getTitle($tour_option_id).'">
		</div>
		<div class="modal-footer"> 
			<button class="btn btn-success submitClick SiteClickSaveTourOption" type="'.$type.'" tour_option_id="'.$tour_option_id.'">
				<i class="icon-white icon-ok"></i> '.$core->get_Lang('save').'
			</button> 
		</div>';
		echo($html);die();
	}elseif($tp=='Save'){
		$tour_option_id = isset($_POST['tour_option_id']) ? intval($_POST['tour_option_id']) : 0;
		$titlePost = $_POST['title'];
		$slugPost = $core->replaceSpace($titlePost);
		$vx = "title='$titlePost',slug='$slugPost'";
		if($clsTourOption->updateOne($tour_option_id, $vx)){
			echo '_SUCCESS'; die();
		}else{
			echo '_ERROR'; die();
		}
	}elseif($tp=='Delete'){
		$clsTourOption = new TourOption();
		$tour_option_id = $_POST['tour_option_id'];
		$clsTourOption->deleteOne($tour_option_id);
		echo('');die();
	}
	
	echo($html);die();
}
function default_ajAddHotPromotion(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsTour = new Tour();
	$clsHotPromotion = new HotPromotion();
	#
	$target_id = $_POST['target_id'];
	$type = $_POST['type'];
	$user_id = $core->_USER['user_id'];

	
	$f = "target_id,user_id,reg_date,upd_date,type";
	$v = "'".$_POST['target_id']."','$user_id','".time()."','".time()."','$type'";
	$clsHotPromotion->insertOne($f,$v);
	#
	echo(1);die();
}
function default_ajLoadListHotPromotion(){
	global $core,$clsISO,$clsConfiguration;
	$clsTour = new Tour();
	$clsProperty = new Property();
	$clsHotPromotion = new HotPromotion();

	#
	$currency = $clsConfiguration->getValue('Currency');
	$target_id = $_POST['target_id'];
	$html = '';
	$lstHotPromotion = $clsHotPromotion->getAll("target_id='$target_id' order by start_date asc");
	if($lstHotPromotion[0][$clsHotPromotion->pkey]!=''){
		$html .= '<p class="mb10" style="font-size:18px; display:inline-block; line-height:30px; vertical-align:top"><span  style="display:inline-block; line-height:60px;">'.$core->get_Lang('List hot tour promotion').'  </span>
		</p>
		<div id="holderAllTourStartDateList" style="width:100%;">
		<table cellspacing="0" width="100%">
		<tr>
		<td style="padding:5px 5px; text-align:center; border: 1px solid #ccc;">'.$core->get_Lang('No.').'</td>
		<td style="padding:0 5px; text-align:center; border: 1px solid #ccc;">'.$core->get_Lang('Promotion code').'</td>
		<td style="padding:0 5px; text-align:center; border: 1px solid #ccc;">'.$core->get_Lang('From date').'</td>
		<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$core->get_Lang('To date').'</td>
		<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$core->get_Lang('Flag').'</td>
		<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$core->get_Lang('Price Ads').'('.$clsProperty->getOneField('property_code',$currency).')</td>';
		if( _IS_AGENT ==1){
		$html .= '<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$core->get_Lang('Price Ads - Agent').'('.$clsProperty->getOneField('property_code',$currency).')</td>';
		}
		$html .= '<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$core->get_Lang('Public').'</td>
		<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$core->get_Lang('Function').'</td>
		</tr>
		';
		for($m=0;$m<count($lstHotPromotion);$m++){
		$hot_promotion_id = $lstHotPromotion[$m][$clsHotPromotion->pkey];
		$start_date = $lstHotPromotion[$m]['start_date'] ? $lstHotPromotion[$m]['start_date']: time();
		$end_date = $lstHotPromotion[$m]['end_date'] ? $lstHotPromotion[$m]['end_date']: time();
		$html .= '
		<tr style="'.($m%2==0?'background:#eee':'background:#fff').'">
			<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.($m+1).'</td>
			<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$lstHotPromotion[$m]['promotion_code'].'</td>
			<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.date('m/d/Y',$start_date).'</td>
			<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.date('m/d/Y',$end_date).'</td>
			<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$lstHotPromotion[$m]['price_text'].'</td>
			<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$lstHotPromotion[$m]['price'].'</td>';
			if( _IS_AGENT ==1){
			$html .= '<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">'.$lstHotPromotion[$m]['price_agent'].'</td>';
			}
			$html .= '<td style="padding:0 5px; text-align:center;border: 1px solid #ccc;">
				<a href="javascript:void(0);" class="SiteClickPublic" clsTable="HotPromotion" pkey="hot_promotion_id" sourse_id="'.$lstHotPromotion[$m]['hot_promotion_id'].'" rel="'.$lstHotPromotion[$m]['is_online'].'" title="'.$core->get_Lang('Click to change status').'">';
					if($lstHotPromotion[$m]['is_online'] == '1'){
					$html .= '<i class="fa fa-check-circle green"></i>';
					}else{
					$html .= '<i class="fa fa-minus-circle red"></i>';
					}
				$html .= '</a>
			</td>';
			$html .= '<td style="padding:5px 5px; text-align:center;border: 1px solid #ccc;">
				<div class="btn-group">
					<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
					<ul class="dropdown-menu" style="right:0px !important">
						<li><a title="'.$core->get_Lang('Edit').'" hot_promotion_id="'.$hot_promotion_id.'" target_id="'.$target_id.'" class="clickEditHotPromotion" href="#"><i class="fa fa-cog"></i> '.$core->get_Lang('Edit').'</a></li>
						<li><a title="'.$core->get_Lang('delete').'" hot_promotion_id="'.$hot_promotion_id.'" target_id="'.$target_id.'" class="clickDeleteHotPromotion" href="#"><i class="icon-trash"></i> '.$core->get_Lang('delete').'</a></li>
						</ul>
				</div>
			</td>'; 
			$html .= '
		</tr>';
		}
		$html .= '
		</table>
		</div>';
	}	
	echo($html);die();
}
function default_ajLoadHotPromotionItem(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
	$user_id = $core->_USER['user_id'];
	#
	$clsTour = new Tour();
	$clsHotPromotion = new HotPromotion();
	$clsProperty = new Property();

	$currency = $clsConfiguration->getValue('Currency');
	$target_id = isset($_POST['target_id'])?intval($_POST['target_id']):0;
	$hot_promotion_id = isset($_POST['hot_promotion_id'])?intval($_POST['hot_promotion_id']):0;
	$tp = isset($_POST['tp'])?$_POST['tp']:'';
	$start_date = isset($_POST['start_date'])?$_POST['start_date']:0;
	$start_date=strtotime($start_date);
	$end_date = isset($_POST['end_date'])?$_POST['end_date']:0;
	$end_date=strtotime($end_date);
	$flag_text = isset($_POST['flag_text'])?$_POST['flag_text']:'';
	$price_ads = isset($_POST['price_ads'])?$_POST['price_ads']:0;
	$price_agent = isset($_POST['price_agent'])?$_POST['price_agent']:0;
	$deposit = isset($_POST['deposit'])?$_POST['deposit']:0;
	$date =  date('m',$start_date).date('d',$start_date).date('y',$start_date);
	$promotioncode=$clsTour->getTripCode($target_id).'/PRT'.$date; 

	if($tp == 'F') {
		$html = '';
		$start_date=$clsHotPromotion->getOneField('start_date',$hot_promotion_id) ? $clsHotPromotion->getOneField('start_date',$hot_promotion_id) : time();
		$end_date=$clsHotPromotion->getOneField('end_date',$hot_promotion_id) ? $clsHotPromotion->getOneField('end_date',$hot_promotion_id) : time();
		$html.='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.$core->get_Lang('Edit Promotion ').'- [ID #'.$target_id.']</h3>
		</div>';
		$html .= '
		
		<form method="post" id="tblPriceHotPromotion" class="frmform formborder mb10" enctype="multipart/form-data" style="width:100%;overflow:auto;">
			<div class="hotPromotionItem" style="border:1px solid #ccc; min-width:100%;">
				<div class="row mb10">
					<div class="date col-xs-6 w50">
						<label>'.$core->get_Lang('From date').'</label>
						<input type="text" id="start_date" value="'.date('m/d/Y',$start_date).'" name="start_date"/>
					</div>
					<div class="date col-xs-6 w50">
						<label>'.$core->get_Lang('To date').'</label>
						<input type="text" id="end_date" value="'.date('m/d/Y',$end_date).'" name="end_date"/>
					</div>
				</div>
				<div class="flag_text mb10">
					<label>'.$core->get_Lang('Flag text').'</label>
					<input type="text" id="flag_text" value="'.$clsHotPromotion->getFlagText($hot_promotion_id).'" name="flag_text"/>
				</div>
				<div class="row mb10">
					<div class="price col-xs-6 w50">
						<label>'.$core->get_Lang('Price Ads').' ('.$clsProperty->getOneField('property_code',$currency).')</label>
						<input type="text" id="price_ads" value="'.$clsHotPromotion->getPriceAds($hot_promotion_id).'" name="price_ads"/>
					</div>
					<div class="price col-xs-6 w50">
						<label>'.$core->get_Lang('Deposit').' (%)</label>
						<input type="text" id="deposit" value="'.$clsHotPromotion->getDeposit($hot_promotion_id).'" name="deposit" max="100"/>
					</div>
				</div>';
				if(_IS_AGENT=='1'){
				$html .= '<div class="row">
					<div class="price col-xs-6 w50">
						<label>'.$core->get_Lang('Price Ads - Agent').' ('.$clsProperty->getOneField('property_code',$currency).')</label>
						<input type="text" id="price_agent" value="'.$clsHotPromotion->getPriceAdsAgent($hot_promotion_id).'" name="price_agent"/>
					</div>
				</div>';
				}
			$html .= '</div>
		</form>
		<div class="modal-footer">
			<button type="submit" hot_promotion_id="'.$hot_promotion_id.'" target_id="'.$target_id.'" class="btn btn-primary btnSaveHotPromotion">
				<i class="icon-ok icon-white"></i> <span>Save</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span>
			</button>
		</div>
		<script type="text/javascript">
			$("#start_date").datepicker();
			$("#end_date").datepicker();
		</script>
		';
		echo($html);die();
	}elseif($tp=='S'){
		if($end_date <=$start_date){
			echo 'end_date_invalid'; die();
		}elseif($start_date <= time()){
			echo 'start_date_invalid'; die();
		}else{
			
			$slq="start_date > 0 and hot_promotion_id < '$hot_promotion_id' and target_id='$target_id' order by hot_promotion_id desc";
			
			$lstHotPromotion1=$clsHotPromotion->getAll("start_date > 0 and hot_promotion_id < '$hot_promotion_id' and target_id='$target_id' order by hot_promotion_id desc");	
			$lstHotPromotion2=$clsHotPromotion->getAll("start_date > 0 and hot_promotion_id > '$hot_promotion_id' and target_id='$target_id' order by hot_promotion_id asc");
			$oneHotPromotion2=$lstHotPromotion2[0]['hot_promotion_id'];
			if($start_date < $lstHotPromotion1[0]['end_date'] && $lstHotPromotion1[0]['end_date'] !=''){
				echo 'start_date_invalid'; die();
			}elseif($end_date > $lstHotPromotion2[0]['start_date'] &&  $lstHotPromotion2[0]['start_date'] !=''){
				echo 'end_date_invalid'; die();
			}else{
				$clsHotPromotion->updateOne($hot_promotion_id,"price='".$price_ads."',price_agent='".$price_agent."',start_date='".$start_date."',end_date='".$end_date."',price_text='".$flag_text."',promotion_code='".$promotioncode."',deposit='".$deposit."'");
				echo '_UPDATE_SUCCESS'; die();
			}
		}
	}else{
		
	}
}
function default_map(){
	global $dbconn, $_LANG_ID, $core, $smarty;
	$clsTour = new Tour();
	$smarty->assign('clsTour', $clsTour);
	
	$tour_id = intval($_POST['tour_id']);
	$smarty->assign('tour_id', $tour_id);
	$mapzom = intval($_POST['mapzom']);
	$smarty->assign('mapzom', $mapzom);
	
	$ret = $clsTour->getLocationMap($tour_id);
	
	$map_la = $ret['map_la'];
	$map_lo = $ret['map_lo'];
	$script_location = $ret['jscode'];
	print_r($script_location); die();
	print_r($script_location); die();
	$smarty->assign('map_la',$map_la);
	$smarty->assign('map_lo',$map_lo);
	$smarty->assign('script_location',$script_location);
	
	$html = $core->build('map.tpl');
	echo $html; die();
	
}
function default_ajDeleteHotPromotion(){
	$clsHotPromotion = new HotPromotion();
	$hot_promotion_id = $_POST['hot_promotion_id'];
	$clsHotPromotion->deleteOne($hot_promotion_id);
	echo('');die();
}
?>