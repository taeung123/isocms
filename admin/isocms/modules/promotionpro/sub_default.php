<?php
function default_default() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting,$clsISO,$package_id;
    #
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    /**/
	$clsCruiseItinerary = new CruiseItinerary();
	$assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $classTable = "Promotion";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    /* List all item */
    $cond = "1='1'";
    #Filter By Keyword
    if (isset($_GET['keyword'])) {
        if ($_GET['keyword'] != '') {
            $keyword = $core->replaceSpace($_GET['keyword']);
            $cond .= " and slug like '%" . $keyword . "%'";
            $assign_list["keyword"] = $_GET['keyword'];
        }
    }
	$type = isset($_GET['type']) ? $_GET['type'] : '';
    $assign_list["type"] = $type;
	
	
	if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,$act,'default',$type)){
		header('Location:/admin/index.php?lang='.LANG_DEFAULT);
		exit();
	}
	
	if($type!=''){
		$cond .= " and type= '$type'";
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
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit); //print_r($cond." order by ".$orderBy.$limit);die();
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
        if ($_POST['submit'] == 'UpdateConfiguration') {
            $clsConfiguration->updateValue('SitePromotionEnable', $_POST['SitePromotionEnable']);
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess');
        }
    }
}
//promotion
function default_ajAddPromotion(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsTour = new Tour();
	$clsPromotion = new Promotion();
	#
	$target_id = isset($_POST['target_id'])?$_POST['target_id']:'';
	$type = isset($_POST['type'])?$_POST['type']:'';
	$clsTable = isset($_POST['clsTable'])?$_POST['clsTable']:'';
	$target_id = isset($_POST['target_id'])?$_POST['target_id']:'';
	$user_id = $core->_USER['user_id'];

	
	$f = "promotion_id,target_id,user_id,reg_date,upd_date,type,clsTable";
	$v = "'".$clsPromotion->getMaxId()."','".$_POST['target_id']."','$user_id','".time()."','".time()."','$type','$clsTable'";
	$clsPromotion->insertOne($f,$v);
	#
	echo(1);die();
}

function default_ajLoadPromotion(){
	global $core,$clsISO,$clsConfiguration;
	$clsTour = new Tour();
	$clsProperty = new Property();
	$clsPromotion = new Promotion();

	#
	$currency = $clsConfiguration->getValue('Currency');
	$target_id = isset($_POST['target_id'])?$_POST['target_id']:'';
	$type = isset($_POST['type'])?$_POST['type']:'';
	$clsTable = isset($_POST['clsTable'])?$_POST['clsTable']:'';
	$html = '';
	$lstPromotion = $clsPromotion->getAll("target_id='$target_id' and clsTable='$clsTable' order by promotion_id desc");
	if($lstPromotion[0][$clsPromotion->pkey]!=''){
		$html .= '<p class="mb10" style="font-size:18px; display:inline-block; line-height:30px; vertical-align:top"><span  style="display:inline-block; line-height:60px;">'.$core->get_Lang('List promotion').'  </span>
		</p>
		<div id="holderAllCruiseBestDeal" style="width:100%;">
		<table cellspacing="0" width="100%" class="tbl-grid">
		<tr>
		<td class="gridheader" style="text-align:center; width:120px ">'.$core->get_Lang('Promotion code').'</td>
		<td class="gridheader" style="text-align:center;width:160px ">'.$core->get_Lang('From date').'</td>
		<td class="gridheader" style="text-align:center;width:160px ">'.$core->get_Lang('To date').'</td>
		<td class="gridheader" style="text-align:center;">'.$core->get_Lang('Flag').'</td>
		<td class="gridheader" style="text-align:center;width:100px ">'.$core->get_Lang('Promotion').'(%)</td>';
		$html .= '<td class="gridheader" style="text-align:center;width:60px ">'.$core->get_Lang('Public').'</td>
		<td class="gridheader" style="text-align:center;width:70px ">'.$core->get_Lang('Function').'</td>
		</tr>
		';
		for($m=0;$m<count($lstPromotion);$m++){
		$promotion_id = $lstPromotion[$m][$clsPromotion->pkey];
		$start_date = $lstPromotion[$m]['start_date'] ? $lstPromotion[$m]['start_date']: time();
		$end_date = $lstPromotion[$m]['end_date'] ? $lstPromotion[$m]['end_date']: time();
		$html .= '
		<tr style="'.($m%2==0?'background:#eee':'background:#fff').'">
			<td style="text-align:center;">'.$lstPromotion[$m]['promotion_code'].'</td>
			<td style="text-align:center;white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">'.date('m/d/Y',$start_date).'</td>
			<td style="text-align:center;white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">'.date('m/d/Y',$end_date).'</td>
			<td style="text-align:center;">'.$lstPromotion[$m]['price_text'].'</td>
			<td style="text-align:center;">'.$lstPromotion[$m]['promot'].'</td>';
			
			$html .= '<td style="text-align:center;">
				<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Promotion" pkey="promotion_id" sourse_id="'.$lstPromotion[$m]['promotion_id'].'" rel="'.$lstPromotion[$m]['is_online'].'" title="'.$core->get_Lang('Click to change status').'">';
					if($lstPromotion[$m]['is_online'] == '1'){
					$html .= '<i class="fa fa-check-circle green"></i>';
					}else{
					$html .= '<i class="fa fa-minus-circle red"></i>';
					}
				$html .= '</a>
			</td>';
			$html .= '<td style="padding:5px 5px; text-align:center;">
				<div class="btn-group">
					<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
					<ul class="dropdown-menu" style="right:0px !important">
						<li><a title="'.$core->get_Lang('Edit').'" promotion_id="'.$promotion_id.'" target_id="'.$target_id.'" class="clickEditPromotion" href="#"><i class="fa fa-cog"></i> '.$core->get_Lang('Edit').'</a></li>
						<li><a title="'.$core->get_Lang('delete').'" promotion_id="'.$promotion_id.'" target_id="'.$target_id.'" clsTable="'.$clsTable.'" class="clickDeletePromotion" href="#"><i class="icon-trash"></i> '.$core->get_Lang('delete').'</a></li>
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
function default_ajLoadPromotionItem(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
	$user_id = $core->_USER['user_id'];
	#
	$clsTour = new Tour();
	
	$clsPromotion = new Promotion();
	$clsProperty = new Property();
	$clsCruiseItinerary = new CruiseItinerary();
	
	$currency = $clsConfiguration->getValue('Currency');
	$cruise_itinerary_id = isset($_POST['cruise_itinerary_id'])?intval($_POST['cruise_itinerary_id']):0;
	$target_id = isset($_POST['target_id'])?intval($_POST['target_id']):0;
	$promotion_id = isset($_POST['promotion_id'])?intval($_POST['promotion_id']):0;
	$tp = isset($_POST['tp'])?$_POST['tp']:'';
	$start_date = isset($_POST['start_date'])?$_POST['start_date']:0;
	
	$end_date = isset($_POST['end_date'])?$_POST['end_date']:0;
	//print_r($start_date.'xxxxxx'.$end_date); die();
	$start_date=strtotime($start_date);
	$end_date=strtotime($end_date);
	
	
	$clsTable=$clsPromotion->getOneField('clsTable',$promotion_id) ? $clsPromotion->getOneField('clsTable',$promotion_id) : '';

	$flag_text = isset($_POST['flag_text'])?$_POST['flag_text']:'';
	$promot = isset($_POST['promot'])?$_POST['promot']:0;
	$promot_agent = isset($_POST['promot_agent'])?$_POST['promot_agent']:0;
	$deposit = isset($_POST['deposit'])?$_POST['deposit']:0;
	$promotioncode=isset($_POST['promotion_code'])?$_POST['promotion_code']:'';

	$lstItinerary = $clsCruiseItinerary->getAll("cruise_id='$target_id' and is_trash=0 and is_online=1 order by order_no asc");
	$assign_list["lstItinerary"] = $lstItinerary;

	if($tp == 'F') {
		$html = '';
		$start_date=$clsPromotion->getOneField('start_date',$promotion_id) ? $clsPromotion->getOneField('start_date',$promotion_id) : time();
		$end_date=$clsPromotion->getOneField('end_date',$promotion_id) ? $clsPromotion->getOneField('end_date',$promotion_id) : time();
		$cruise_itinerary_id=$clsPromotion->getOneField('cruise_itinerary_id',$promotion_id) ? $clsPromotion->getOneField('cruise_itinerary_id',$promotion_id) : '';
		$html.='
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h3>'.$core->get_Lang('Edit Promotion ').'- [ID #'.$target_id.']</h3>
		</div>';
		$html .= '
		
		<form method="post" id="tblPricePromotion" class="frmform" enctype="multipart/form-data" style="width:100%;overflow:auto;">
			<div class="PromotionItem" style="border:1px solid #ccc; min-width:100%;">';
				$html .= '<div class="row-span">
					<div class="fieldlabel text-right"><strong>'.$core->get_Lang('Promotion code').'</strong></div>
					<div class="fieldarea">
						<input type="text" class="inline-block title_upper" id="promotion_code" value="'.$clsPromotion->getPromotionCode($promotion_id).'" name="promotion_code" maxlength="6" style="width:150px"/>
						<a class="btn btn-green ml10 inline-block text_32" id="ajGetPromotionCode">'.$core->get_Lang('Create code').'</a>
					</div>
				</div>';
				if($clsTable=='Cruise'){
					$html .= '<div class="row-span">
					<div class="fieldlabel text-right"><strong>'.$core->get_Lang('Itinerary').'</strong></div>
					<div class="fieldarea">
					<select name="cruise_itinerary_id" class="full-width">
						<option>--'.$core->get_Lang('select').'--</option>';
						for($i=0;$i<count($lstItinerary);$i++){
							$html .= '<option '.($cruise_itinerary_id==$lstItinerary[$i]['cruise_itinerary_id']?'selected=selected':'').' value="'.$lstItinerary[$i]['cruise_itinerary_id'].'">
							'.$clsCruiseItinerary->getTitleDay($lstItinerary[$i]['cruise_itinerary_id']).'
							</option>';
						}
					$html .= '</select>
					</div>
				</div>';
				}
				$html .= '<div class="row-span">
					<div class="fieldlabel text-right"><strong>'.$core->get_Lang('Time').'</strong></div>
					<div class="fieldarea">
						<div id="start_date" class="input-append date span45 fl">
						  <input value="'.date('m/d/Y',$start_date).'" name="start_date" type="text" class="hasDatepicker add-on"/>
						</div>
						<div id="end_date" class="input-append date span45 fr">
						  <input value="'.date('m/d/Y',$end_date).'" name="end_date" type="text" class="hasDatepicker add-on"/>
						</div>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel text-right"><strong>'.$core->get_Lang('Flag text').'</strong></div>
					<div class="fieldarea">
						<input type="text" id="flag_text" value="'.$clsPromotion->getFlagText($promotion_id).'" name="flag_text"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel text-right"><strong>'.$core->get_Lang('Promotion').'(%)</strong></div>
						<div class="fieldarea">
							<input type="number" id="price_ads" value="'.$clsPromotion->getPromotion($promotion_id).'" name="promot" min="1" max="100" style="width:120px"/>
						</div>
					</div>
					<div class="row-span" style="display:none">
					<div class="fieldlabel text-right"><strong>'.$core->get_Lang('Deposit').'(%)</strong></div>
						<div class="fieldarea">
							<input type="number" id="deposit" value="'.$clsPromotion->getDeposit($promotion_id).'" name="deposit" min="1" max="100" style="width:120px"/>
						</div>
					</div>
				</div>';
			$html .= '</div>
		</form>
		<div class="modal-footer">
			<button type="submit" promotion_id="'.$promotion_id.'" target_id="'.$target_id.'" clsTable="'.$clsTable.'" class="btn btn-primary btnSavePromotion">
				<i class="icon-ok icon-white"></i> <span>Save</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>'.$core->get_Lang('close').'</span>
			</button>
		</div>
		<script type="text/javascript">
			$("#start_date").datetimepicker({
				format: "MM/dd/yyyy",
			});
			$("#end_date").datetimepicker({
				format: "MM/dd/yyyy",
			});
			$(document).on("click", "#ajGetPromotionCode", function(ev) {
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod=promotion&act=ajGetPromotionCode",
					dataType:"html",
					success: function(html){
						var htm = html.split("|||");
						$("#promotion_code").val(htm[1]);
					}
				});
			});
		</script>
		';
		echo($html);die();
	}elseif($tp=='S'){
		//print_r($end_date.'xxxxxxxxxxxxxx'.$start_date); die();
		if($end_date <=$start_date){
			echo 'end_date_invalid'; die();
		}else{
			
			$slq="start_date > 0 and promotion_id < '$promotion_id' and target_id='$target_id' and clsTable='$clsTable' order by promotion_id desc";
			
			$lstPromotion1=$clsPromotion->getAll("start_date > 0 and promotion_id < '$promotion_id' and target_id='$target_id' and clsTable='$clsTable' and cruise_itinerary_id='$cruise_itinerary_id' order by promotion_id desc");	
			$lstPromotion2=$clsPromotion->getAll("start_date > 0 and promotion_id > '$promotion_id' and target_id='$target_id' and clsTable='$clsTable' and cruise_itinerary_id='$cruise_itinerary_id' order by promotion_id asc");
			$lstPromotion3=$clsPromotion->getAll("start_date > '".time()."' and promotion_code ='$promotioncode'");
			$onePromotion2=$lstPromotion2[0]['promotion_id'];
			if($start_date < $lstPromotion1[0]['end_date'] && $lstPromotion1[0]['end_date'] !=''){
				echo 'start_date_invalid'; die();
			}elseif($end_date > $lstPromotion2[0]['start_date'] &&  $lstPromotion2[0]['start_date'] !=''){
				echo 'end_date_invalid'; die();
			}elseif($lstPromotion2[0]['promotion_id'] !=''){
				echo 'promotion_code_invalid'; die();
			}else{
				$clsPromotion->updateOne($promotion_id,"promot='".$promot."',promot_agent='".$promot_agent."',start_date='".$start_date."',end_date='".$end_date."',price_text='".$flag_text."',promotion_code='".strtoupper($promotioncode)."',deposit='".$deposit."',cruise_itinerary_id='".$cruise_itinerary_id."'");
				
				echo '_UPDATE_SUCCESS'; die();
			}
		}
	}else{
		
	}
}
function default_ajDeletePromotion(){
	$clsPromotion = new Promotion();
    $clsPromotionItem = new PromotionItem();
	$promotion_id = $_POST['promotion_id'];
    $a = $clsPromotionItem->doDeleteAllByProId($promotion_id);
	$clsPromotion->deleteOne($promotion_id);

	echo($promotion_id);die();
}
function default_ajDeletePromotionItem(){
	$clsPromotion = new Promotion();
    $clsPromotionItem = new PromotionItem();
	$promotion_item_id = $_POST['promotion_item_id'];
    $clsPromotionItem->deleteOne($promotion_item_id);

	echo($promotion_item_id);die();
}
function default_ajGetPromotionCode(){
	global $core, $clsISO,$_LANG_ID,$gid;
	#
	echo('0|||'.$clsISO->getRandomString());die();	
}

function default_ajLoadFormPromotionProfessional(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act;
    global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();

    $clsPromotion = new Promotion();
    $clsPromotionItem = new PromotionItem();
    $clsProperty = new Property();
    $clsCruiseItinerary = new CruiseItinerary();
    $tp= isset($_POST['tp'])?$_POST['tp']:'';
    $promotion_id= isset($_POST['promotion_id'])?$_POST['promotion_id']:'';
    $target_id= isset($_POST['target_id'])?$_POST['target_id']:'';
	$assign_list['target_id'] = $target_id;
    unset($_COOKIE['target_id']);
    unset($_COOKIE['power_promotion']);
    unset($_COOKIE['date_promotion']);
    unset($_COOKIE['discount_value']);
    unset($_COOKIE['select_product']);
//    var_dump($promotion_id);die();
    if($promotion_id){
        $detail_product = $clsPromotion->getAll('promotion_id='.$promotion_id);
        $html = 'proid:'.$detail_product[0]['promotion_id'];
		setcookie('target_id',$detail_product[0]['target_id']);
        setcookie('power_promotion',$detail_product[0]['check_mem_set'].','.$detail_product[0]['check_all_product'].','.$detail_product[0]['check_pieces_product'].','.$detail_product[0]['check_code_product']);
        setcookie('date_promotion',date('d/m/Y',$detail_product[0]['start_date']).','.date('d/m/Y',$detail_product[0]['end_date']).','.date('d/m/Y',$detail_product[0]['travel_date_from']).','.date('d/m/Y',$detail_product[0]['travel_date_to']));
        setcookie('discount_value',$detail_product[0]['discount_value']);
        $list_product = $clsPromotionItem->getAll('promotion_id='.$promotion_id.' and cruise_intinerary=0');
        $select_product_all = '';
        foreach ($list_product as $item) {
            $select_product_all .= ','.$item['taget_id'];
        }
        $select_product_all = trim($select_product_all,',');
        setcookie('select_product',$select_product_all);
        setcookie('name_pro',$detail_product[0]['price_text']);
//        echo($select_product_all);die();
    }
//    setcookie('power_promotion','1,1,1,0');
    if($tp == 'L') {
        $html = '';
        $html.='
		<div class="headPop box_title_text">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h2 class="title_promotion_pop">'.$core->get_Lang('Create a promotion').'</h2>
		</div>';
        $html .='
        <div class="clearfix" style="padding: 10px;"></div>
        <div class="who_can_see">
            <p class="title_pop_who_see">'.$core->get_Lang('Who can see').' <span class="unshow_option"><i class="fa fa-angle-double-up"></i>  <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_op" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_option_mem"></div>
        </div>
        <div class="date_promotion_pro">
            <p class="title_date_promotion">'.$core->get_Lang('Dates').' <span class="unshow_date"><i class="fa fa-angle-double-up"></i> <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_dt" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_date_promotion"></div>
        </div>
        <div class="date_promotion_detail">
            <p class="title_promotion_detail">'.$core->get_Lang('Promotion details').' <span class="unshow_pro_detail"><i class="fa fa-angle-double-up"></i> <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_pd" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_promotion_detail"></div>
        </div>
        <div class="date_promotion_name">
            <p class="title_promotion_name">'.$core->get_Lang('Promotion name').' <span class="unshow_pro_name"><i class="fa fa-angle-double-up"></i> <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_pn" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_promotion_name"></div>
        </div> ';
        if($promotion_id){
            $html.='<div class="btn_save_all_promotion" style="display: none;"><button id="btn_save_all_up" pro_id="'.$promotion_id.'" class="btn_save_all_up">'.$core->get_Lang('Save and continue').'</button></div>';
        }else{
            $html.='<div class="btn_save_all_promotion" style="display: none;"><button id="btn_save_all" class="btn_save_all" target_id="'.$target_id.'">'.$core->get_Lang('Save and continue').'</button></div>';
        }
        echo($html);die();
    }elseif($tp == 'Le') {
        $html = '';
        $html.='
		<div class="headPop box_title_text">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h2 class="title_promotion_pop">'.$core->get_Lang('Edit a promotion').'</h2>
		</div>';
        $html .='
        <div class="clearfix" style="padding: 10px;"></div>
        <div class="who_can_see">
            <p class="title_pop_who_see">'.$core->get_Lang('Who can see').' <span class="unshow_option"><i class="fa fa-angle-double-up"></i>  <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_op" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_option_mem"></div>
        </div>
        <div class="date_promotion_pro">
            <p class="title_date_promotion">'.$core->get_Lang('Dates').' <span class="show_date"><i class="fa fa-angle-double-down"></i> <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_dt" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_date_promotion"></div>
        </div>
        <div class="date_promotion_detail">
            <p class="title_promotion_detail">'.$core->get_Lang('Promotion details').' <span class="show_pro_detail"><i class="fa fa-angle-double-down"></i> <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_pd" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_promotion_detail"></div>
        </div>
        <div class="date_promotion_name">
            <p class="title_promotion_name">'.$core->get_Lang('Promotion name').' <span class="show_pro_name"><i class="fa fa-angle-double-down"></i> <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_pn" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_promotion_name"></div>
        </div> ';
        if($promotion_id){
            $html.='<div class="btn_save_all_promotion" style="display: none;"><button id="btn_save_all_up" pro_id="'.$promotion_id.'" class="btn_save_all_up">'.$core->get_Lang('Save and continue').'</button></div>';
        }else{
            $html.='<div class="btn_save_all_promotion" style="display: none;"><button id="btn_save_all" class="btn_save_all" target_id="'.$target_id.'">'.$core->get_Lang('Save and continue').'</button></div>';
        }
        echo($html);die();
    }else{

    }
}
function default_ajEditSetMem(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act;
    global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();

    $clsPromotion = new Promotion();
    $clsProperty = new Property();
    $clsCruiseItinerary = new CruiseItinerary();
    $tp= isset($_POST['tp'])?$_POST['tp']:'';
    $setting= isset($_POST['setting'])?$_POST['setting']:'';
    $setting = explode(',',$setting);
    $check_mem_ok=0;
    $check_mem_no=0;
    $all_product_ok=0;
    $all_product_no=0;
    $pieces_product_ok=0;
    $pieces_product_no=0;
    $code_product_ok=0;
    $code_product_no=0;
    if($setting[0] == 1){$check_mem_ok= 'checked="checked"';}else{$check_mem_no= 'checked="checked"';}
    if($setting[1] == 1){$all_product_ok= 'checked="checked"';}else{$all_product_no= 'checked="checked"';}
    if($setting[2] == 1){$pieces_product_ok= 'checked="checked"';}else{$pieces_product_no= 'checked="checked"';}
    if($setting[3] == 1){$code_product_ok= 'checked="checked"';}else{$code_product_no= 'checked="checked"';}
//    var_dump($check_mem_no);die();

    if($tp == 'L') {
        $html = '';
        $html.='
        <ul class="list_option_set">
            <li class="item_option_set">
                <label class="name_mem_set">'.$core->get_Lang('Use for all person / member only').'</label>
                <p class="btn-switch">					
                  <input type="radio" id="ok_check_mem" name="check_mem_set" value="1" '.$check_mem_ok.' class="btn-switch__radio btn-switch__radio_yes" />
                  <input type="radio" id="no_check_mem" name="check_mem_set" value="0" '.$check_mem_no.' class="btn-switch__radio btn-switch__radio_no" />		
                  <label for="ok_check_mem" class="btn-switch__label btn-switch__label_yes"><span class="btn-switch__txt"></span></label>
                  <label for="no_check_mem" class="btn-switch__label btn-switch__label_no"><span class="btn-switch__txt"></span></label>							
                </p>
            </li>
            <li class="item_option_set" style="display: none;">
                <label class="name_mem_set">'.$core->get_Lang('Use for all product').'</label>
                <p class="btn-switch">					
                  <input type="radio" id="ok_all_product" name="check_all_product" value="1" '.$all_product_ok.' class="btn-switch__radio btn-switch__radio_yes" />
                  <input type="radio" id="no_all_product" name="check_all_product" value="0" '.$all_product_no.' class="btn-switch__radio btn-switch__radio_no" />		
                  <label for="ok_all_product" class="btn-switch__label btn-switch__label_yes"><span class="btn-switch__txt"></span></label>
                  <label for="no_all_product" class="btn-switch__label btn-switch__label_no"><span class="btn-switch__txt"></span></label>							
                </p>
            </li>
            <li class="item_option_set" style="display: none;">
                <label class="name_mem_set">'.$core->get_Lang('Use for pieces product').'</label>
                <p class="btn-switch">					
                  <input type="radio" id="ok_pieces_product" name="check_pieces_product" value="1" '.$pieces_product_ok.' class="btn-switch__radio btn-switch__radio_yes" />
                  <input type="radio" id="no_pieces_product" name="check_pieces_product" value="0" '.$pieces_product_no.' class="btn-switch__radio btn-switch__radio_no" />		
                  <label for="ok_pieces_product" class="btn-switch__label btn-switch__label_yes"><span class="btn-switch__txt"></span></label>
                  <label for="no_pieces_product" class="btn-switch__label btn-switch__label_no"><span class="btn-switch__txt"></span></label>							
                </p>
            </li>
            <li class="item_option_set">
                <label class="name_mem_set">'.$core->get_Lang('Use for code promotion').'</label>
                <p class="btn-switch">					
                  <input type="radio" id="ok_code_product" name="check_code_product" value="1" '.$code_product_ok.' class="btn-switch__radio btn-switch__radio_yes" />
                  <input type="radio" id="no_code_product" name="check_code_product" value="0" '.$code_product_no.' class="btn-switch__radio btn-switch__radio_no" />		
                  <label for="ok_code_product" class="btn-switch__label btn-switch__label_yes"><span class="btn-switch__txt"></span></label>
                  <label for="no_code_product" class="btn-switch__label btn-switch__label_no"><span class="btn-switch__txt"></span></label>							
                </p>
            </li>    
        </ul>';
        $html.='<div class="btn_save_option_promotion"><button id="btn_save_option" class="btn_save_option">'.$core->get_Lang('Save and continue').'</button></div>';
        echo($html);die();
    }else{

    }
}
function default_ajEditSetDate(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act;
    global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();

    $clsPromotion = new Promotion();
    $clsProperty = new Property();
    $clsCruiseItinerary = new CruiseItinerary();
    $tp= isset($_POST['tp'])?$_POST['tp']:'';
    $setting= isset($_POST['setting'])?$_POST['setting']:'';
    $setting = explode(',',$setting);
    if($tp == 'L') {
        $html = '';
        $html.='
        <div class="box_booking_date">
            <p class="title_box_booking_date">'.$core->get_Lang('Booking dates').'</p>
            <p class="intro_box_booking_date">'.$core->get_Lang('This promotion applies to customers who book on the dates you select here.').'</p>
            <div class="box_from_booking_date">
                <label for="from_booking_date">'.$core->get_Lang("From").'</label>
                <input autocomplete="off" id="from_booking_date" name="from" value="'.$setting[0].'">
            </div>
            <div class="box_to_booking_date">
                <label for="to_booking_date">'.$core->get_Lang("To").'</label>
                <input autocomplete="off" id="to_booking_date" name="to" value="'.$setting[1].'">
            </div>
            <div class="error_row_bk_date"></div>
        </div> 
          <script>
              $( function() {
                var dateFormat = "dd/mm/yy",
                  from = $( "#from_booking_date" )
                    .datepicker({
                        dateFormat:dateFormat,
                      defaultDate: "+1w",
                      minDate: new Date(),
                      changeMonth: true,
                      numberOfMonths: 1
                    })
                    .on( "change", function() {
                      to.datepicker( "option", "minDate", getDate( this ) );
                    }),
                  to = $( "#to_booking_date" ).datepicker({
                    dateFormat:dateFormat,
                    defaultDate: "+1w",
                    minDate: new Date(),
                    changeMonth: true,
                    numberOfMonths: 1
                  })
                  .on( "change", function() {
                    from.datepicker( "option", "maxDate", getDate( this ) );
                  });
             
                function getDate( element ) {
                  var date;
                  try {
                    date = $.datepicker.parseDate( dateFormat, element.value );
                  } catch( error ) {
                    date = null;
                  }
             
                  return date;
                }
              } );
          </script>
        <div class="box_travel_date">
            <p class="title_box_travel_date">'.$core->get_Lang('Travel dates').'</p>
            <p class="intro_box_travel_date">'.$core->get_Lang('This promotion applies to customers traveling on the dates you select here.').'</p>
            <div class="box_from_travel_date">
                 <label for="from_travel_date">'.$core->get_Lang("From").'</label>
                <input type="text" id="from_travel_date" name="from" value="'.$setting[2].'">
            </div>
            <div class="box_to_travel_date">
                    <label for="to_travel_date">'.$core->get_Lang("To").'</label>
                <input type="text" id="to_travel_date" name="to" value="'.$setting[3].'">
            </div>
            <div class="error_row_trvl_date"></div>
        </div>
            <script>
                  $( function() {
                    var dateFormat = "dd/mm/yy",
                      from = $( "#from_travel_date" )
                        .datepicker({
                        dateFormat:dateFormat,
                          defaultDate: "+1w",
                          minDate: new Date(),
                          changeMonth: true,
                          numberOfMonths: 1
                        })
                        .on( "change", function() {
                          to.datepicker( "option", "minDate", getDate( this ) );
                        }),
                      to = $( "#to_travel_date" ).datepicker({
                      dateFormat:dateFormat,
                        defaultDate: "+1w",
                        minDate: new Date(),
                        changeMonth: true,
                        numberOfMonths: 1
                      })
                      .on( "change", function() {
                        from.datepicker( "option", "maxDate", getDate( this ) );
                      });
                 
                    function getDate( element ) {
                      var date;
                      try {
                        date = $.datepicker.parseDate( dateFormat, element.value );
                      } catch( error ) {
                        date = null;
                      }
                 
                      return date;
                    }
                  } );
              </script>
        ';
        $html.='<div class="btn_save_date_promotion"><button id="btn_save_date" class="btn_save_date">'.$core->get_Lang('Save and continue').'</button></div>';
        echo($html);die();
    }else{

    }
}
function checkCompareArrText($array,$text){
    $is_check = 0;
    foreach ( $array as $a){
        if(strcmp($a,$text) == 0){
            $is_check = 1;
        }
    }
    return $is_check;
}
function default_ajEditSetPromotionDetail(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act;
    global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();

    $clsPromotion = new Promotion();
    $clsProperty = new Property();
    $clsCruiseItinerary = new CruiseItinerary();
    $tp= isset($_POST['tp'])?$_POST['tp']:'';
    $setting= isset($_POST['setting'])?$_POST['setting']:'';
    $promotion_id = isset($_POST['promotion_id'])?intval($_POST['promotion_id']):0;
    $setting_discount= isset($_POST['setting_dis_value'])?$_POST['setting_dis_value']:'';

    $setting_discount = explode(',',$setting_discount);
    if($setting != ''){
        $setting = explode(',',$setting);
        $count_setting = count($setting);
    }else{
        $count_setting='';
    }

    $arr_type_check = explode('|',$setting_discount[5]);
//    echo strcmp($setting_discount[5],"MPrice");
//    var_dump($count_setting);
//    var_dump(checkCompareArrText($arr_type_check,'Barcode'));
    if($tp == 'L') {
        $html = '';
        $html.='
            <div class="box_select_type_travel">
                <p class="title_select_type_product">'.$core->get_Lang('Choose type travel').'</p>
                <input type="radio" id="select_type_tour" name="select_type" value="Tour"';
                if($setting_discount[4] == 'Tour'){
                    $html .= 'checked="checked"';
                }
            $html .='>
                <label for="select_type_tour">'.$core->get_Lang("Tour").'</label>
                <input type="radio" id="select_type_cruise" name="select_type" value="Cruise"';
                    if($setting_discount[4] == 'Cruise'){
                        $html .= 'checked="checked"';
                    }
                $html .='>
                <label for="select_type_cruise">'.$core->get_Lang("Cruise").'</label>
                <div class="error_row_select_type_tour"></div>
            </div>
            <div class="box_select_product">
                <p class="title_select_product">'.$core->get_Lang('Where will this promotion apply?').'</p>
                <p class="link_select_product" style="padding: 0;margin: 0;"><a href="javascript:void(0);" class="open_select_product" ';
                if($count_setting >0 && $setting_discount[0] != ''){
                    $html .= 'quantity_pro="'.$count_setting.'">'. $count_setting.$core->get_Lang(' Product Selected');
                }else{
                    $html .='quantity_pro="0">'.$core->get_Lang('Product Selected');
                }
        $html .='</a> <span class="error_row_select_pro"></span></p>
            </div>
            <div class="box_type_of_discount">
                <p class="title_type_discount">'.$core->get_Lang("What type of discount is it?").'</p>
                <div class="des_type_discount ">
                    <input type="radio" id="discount_percent" name="discount_type" value="0"';
                    if($setting_discount[0] == 0){
                        $html .=' checked="checked"';
                    }
        $html .='>
                     <label for="discount_percent" >'.$core->get_Lang("Percent").'</label>
                    <input type="radio" id="discount_amount" name="discount_type" value="1"';
        if($setting_discount[0] == 1){
            $html .=' checked="checked"';
        }
        $discount_percent_amount = isset($setting_discount[1])?$setting_discount[1]:0;
        $ticket_quantity = isset($setting_discount[2])?$setting_discount[2]:'""';
        $max_price = isset($setting_discount[6])?$setting_discount[6]:'""';
        $html .=' style="display: none;">
                    <label for="discount_amount" style="display: none;">'.$core->get_Lang("Amount").'</label>
                </div>
            </div>
            <div class="box_type_of_discount">
                <p class="title_quantity">'.$core->get_Lang(" Discount Percent ").'</p>     
                <input type="text" value="'.$discount_percent_amount.'" name="discount_quantity" id="text_discount_quantity" style="width: 50px;"><label for="text_discount_quantity"> %</label>
                <div class="check_type_service">
                    <label for="type_service_voucher">'.$core->get_Lang("Voucher").'</label>
                    <input type="checkbox" name="type_service_voucher" class="" id="type_service_voucher"  value="Voucher" ';
                        if(checkCompareArrText($arr_type_check,'Voucher')){ $html .= 'checked="checked"';}
        $html .='>
                    <label for="type_service_max_price" style="display: none">'.$core->get_Lang("Max Price").'</label>
                    <input type="checkbox" name="type_service_max_price" class="" id="type_service_max_price" value="MPrice" ';
                        if(checkCompareArrText($arr_type_check,'MPrice')){ $html .= 'checked="checked"';}
        $html .=' style="display: none">
                    <label for="type_service_prcode" style="display: none">'.$core->get_Lang("Qr Code").'</label>
                    <input type="checkbox" name="type_service_prcode" class="" id="type_service_prcode" value="Qrcode" ';
                        if(checkCompareArrText($arr_type_check,'Qrcode')){ $html .= 'checked="checked"';}
        $html .=' style="display: none;">
                    <label for="type_service_barcode" style="display: none">'.$core->get_Lang("Bar Code").'</label>
                    <input type="checkbox" name="type_service_barcode" class="" id="type_service_barcode" value="Barcode" ';
                        if(checkCompareArrText($arr_type_check,'Barcode')){ $html .= 'checked="checked"';}
        $html .=' style="display: none;">
                </div>
                <div class="error_row_discount_quantity"></div>
            </div>
            <div class="box_checkebox_service">
            </div>
        ';
        $html.='<div class="btn_save_select_discount_promotion"><button id="btn_save_select_discount_product" class="btn_save_select_discount_product">'.$core->get_Lang('Save and continue').'</button></div>';
        $html .='
            <script type="text/javascript">
                var vourcher_value = '.$ticket_quantity.';
                var max_price_value = '.$max_price.';
                var code_value = "'.$setting_discount[3].'";
               
                $(document).on("click", "input[name=select_type]", function(ev) {
                    var $_this = $(this);
                    $(".open_select_product").text("Product Selected");
                    $(".open_select_product").attr("quantity_pro","0");
                });
                $(function() {
                    var check_voucher = $("input[name=type_service_voucher]:checked").length;
                    var check_MPrice = $("input[name=type_service_max_price]:checked").length;
                    if(check_voucher>0){
                        $(".box_checkebox_service").append(\' <div class="box_type_of_discount checkb_vourcher"><p class="title_quantity_ticket">'.$core->get_Lang(" Ticket quantity").'</p><input type="text" value="'.$ticket_quantity.'" name="ticket_quantity" id="text_ticket_quantity" placeholder="'.$core->get_Lang("Ticket quantity").'"><input type="text" id="promotion_code" value="'.$setting_discount[3].'" name="promotion_code" maxlength="6" style="width:150px"/><a class="btn btn-green ml10 inline-block text_32" id="ajGetPromotionProCode">'.$core->get_Lang('Create code').'</a><div class="error_row_serv_vourcher"></div></div>\');
                    }
                    if(check_MPrice>0){
                        $(".box_checkebox_service").append(\' <div class="box_type_of_discount checkb_max_price"><p class="title_quantity_ticket">'.$core->get_Lang("Reach the maximum price").'</p><input type="text" value="'.$max_price.'" name="max_price" id="text_max_price" placeholder="'.$core->get_Lang("Max Price").'"><div class="error_row_serv_maxprice"></div></div>\');
                    }
                    $("input[name=type_service_voucher]").change(function(){
                        if($(this).is(":checked")){
                            if(vourcher_value == undefined || code_value == "undefined"){
                                vourcher_value = "";
                                code_value = "";
                                $(".box_checkebox_service").append(\' <div class="box_type_of_discount checkb_vourcher"><p class="title_quantity_ticket">'.$core->get_Lang(" Ticket quantity").'</p><input type="text" value="\'+vourcher_value+\'" name="ticket_quantity" id="text_ticket_quantity" placeholder="'.$core->get_Lang("Ticket quantity").'"><input type="text" id="promotion_code" value="\'+code_value+\'" name="promotion_code" maxlength="6" style="width:150px"/><a class="btn btn-green ml10 inline-block text_32" id="ajGetPromotionProCode">'.$core->get_Lang('Create code').'</a><div class="error_row_serv_vourcher"></div></div>\');
                            }else{
                                $(".box_checkebox_service").append(\' <div class="box_type_of_discount checkb_vourcher"><p class="title_quantity_ticket">'.$core->get_Lang(" Ticket quantity").'</p><input type="text" value="\'+vourcher_value+\'" name="ticket_quantity" id="text_ticket_quantity" placeholder="'.$core->get_Lang("Ticket quantity").'"><input type="text" id="promotion_code" value="\'+code_value+\'" name="promotion_code" maxlength="6" style="width:150px"/><a class="btn btn-green ml10 inline-block text_32" id="ajGetPromotionProCode">'.$core->get_Lang('Create code').'</a><div class="error_row_serv_vourcher"></div></div>\');
                            }
                        }else{
                            $(".box_checkebox_service").find(".checkb_vourcher").remove();
                        }
                    });
                    $("input[name=type_service_max_price]").change(function(){
                        if($(this).is(":checked")){
                            if(max_price_value == undefined){
                                max_price_value = 0;
                                $(".box_checkebox_service").append(\' <div class="box_type_of_discount checkb_max_price"><p class="title_quantity_ticket">'.$core->get_Lang("Reach the maximum price").'</p><input type="text" value="\'+max_price_value+\'" name="max_price" id="text_max_price" placeholder="'.$core->get_Lang("Max Price").'"><div class="error_row_serv_maxprice"></div></div>\');
                            }else{
                                $(".box_checkebox_service").append(\' <div class="box_type_of_discount checkb_max_price"><p class="title_quantity_ticket">'.$core->get_Lang("Reach the maximum price").'</p><input type="text" value="\'+max_price_value+\'" name="max_price" id="text_max_price" placeholder="'.$core->get_Lang("Max Price").'"><div class="error_row_serv_maxprice"></div></div>\');
                            }
                        }else{
                            $(".box_checkebox_service").find(".checkb_max_price").remove();
                        }
                    });
                });
            </script>
        ';
        echo($html);die();
    }else{

    }
}
function default_ajEditSetPromotionName(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act;
    global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();

    $clsPromotion = new Promotion();
    $clsProperty = new Property();
    $clsCruiseItinerary = new CruiseItinerary();
    $tp= isset($_POST['tp'])?$_POST['tp']:'';
    $setting= isset($_POST['setting'])?$_POST['setting']:'';

    if($tp == 'L') {
        $html = '';
        $html.='
            <div class="box_set_name">
                <p class="title_select_product">'.$core->get_Lang('Name Promotion').'</p>
                <input type="text" name="promotion_name" value="'.$setting.'" style="width: 100%;">
            </div>';
        echo($html);die();
    }else{

    }
}
function default_ajLoadFormSelectProduct(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act;
    global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();
    $clsCruise = new Cruise();

    $clsPromotion = new Promotion();
    $clsProperty = new Property();
    $clsCruiseItinerary = new CruiseItinerary();
    $tp= isset($_POST['tp'])?$_POST['tp']:'';
    $h= isset($_POST['h_pop'])?$_POST['h_pop']:'';
    $type= isset($_POST['type'])?$_POST['type']:'';
    $setting= isset($_POST['setting'])?$_POST['setting']:'';
    $setting = explode(',',$setting);
    if($type == 'Tour'){
        $list_product_all = $clsTour->getAll("is_trash=0 and is_online = 1 order by order_no asc");
    }elseif($type == 'Cruise'){
        $list_product_all = $clsCruise->getAll("is_trash=0 and is_online = 1 order by order_no asc");
    }else{
        $list_product_all=array();
    }
    if($tp == 'L') {
        $html = '';
        $html.='
		<div class="headPop box_title_text">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h2 class="title_promotion_pop">'.$core->get_Lang('Select your Product').'</h2>
		</div>';
        $html .='
        <div class="clearfix" style="padding: 10px;"></div>
         <p class="select_option_tour">
                <label for="ckbCheckAll"><span class="text_select_option">'.$core->get_Lang('Select / Disable All').'</span><input type="checkbox" id="ckbCheckAll" style="display: none" /></label>
            </p>
        <div class="list_all_tours" style="height: calc('.$h.'px - 200px);">
           
        ';
            if($type == 'Tour') {
                foreach ($list_product_all as $item) {
                    $html .= '
                    <div class="item_tour">
                        <label for="tour_' . $item['tour_id'] . '" class="label-cbx">
                          <input id="tour_' . $item['tour_id'] . '" type="checkbox" value="' . $item['tour_id'] . '" ';
                    foreach ($setting as $ck) {
                        if ($item['tour_id'] == $ck) {
                            $html .= 'checked="checked"';
                        }
                    }
                    $html .= ' class="invisible check_box_tour">
                          <div class="checkbox">
                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                              <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                              <polyline points="4 11 8 15 16 6"></polyline>
                            </svg>
                          </div>
                          <span>' . $item['title'] . ' (' . $item['number_day'] . ' ' . $core->get_Lang('Days') . ' / ' . $item['number_night'] . ' ' . $core->get_Lang('night') . ')</span>
                        </label>
                    </div>
                ';
                }
            }elseif($type == 'Cruise'){
                foreach ($list_product_all as $item) {
                    $html .= '
                    <div class="item_tour">
                        <label for="cruise_' . $item['cruise_id'] . '" class="label-cbx">
                          <input id="cruise_' . $item['cruise_id'] . '" type="checkbox" value="' . $item['cruise_id'] . '" ';
                    foreach ($setting as $ck) {
                        if ($item['cruise_id'] == $ck) {
                            $html .= 'checked="checked"';
                        }
                    }
                    $html .= ' class="invisible check_box_tour">
                          <div class="checkbox">
                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                              <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                              <polyline points="4 11 8 15 16 6"></polyline>
                            </svg>
                          </div>
                          <span>' . $item['title'] . ' (' . $item['star_number'] . '*)</span>
                        </label>
                    </div>
                ';
                }
            }else{
                $html .= 'No data';
            }
        $html.='</div>
            <script >
                $(document).ready(function () {
                    $("#ckbCheckAll").click(function () {
                        $(".check_box_tour").prop(\'checked\', $(this).prop(\'checked\'));
                    });
                });
            </script>
        ';
        $html.='
            <div class="btn_save_select_product">
                <button id="btn_save_product" class="btn_save_product">'.$core->get_Lang('Save and continue').'</button>
            </div>
        ';

        echo($html);die();
    }else{

    }

}
function default_ajSavePromotion()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $dbconn;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();

    $clsPromotion = new Promotion();
    $clsPromotionItem = new PromotionItem();
    $clsProperty = new Property();
    $clsCruiseItinerary = new CruiseItinerary();
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $h = isset($_POST['h_pop']) ? $_POST['h_pop'] : '';
    $promotion_id = isset($_POST['promotion_id']) ? $_POST['promotion_id'] : '';
    $target_id = (isset($_POST['target_id']) && $_POST['target_id'] != '') ? $_POST['target_id'] : 0;
    $power_promotion = isset($_POST['power_promotion']) ? $_POST['power_promotion'] : '';
    $power_promotion = explode(',', $power_promotion);
    $select_product = isset($_POST['select_product']) ? $_POST['select_product'] : '';
    $select_product = explode(',', $select_product);
    $discount_value = isset($_POST['discount_value']) ? $_POST['discount_value'] : '';
    $discount_value_ex = explode(',', $discount_value);
    $date_promotion = isset($_POST['date_promotion']) ? $_POST['date_promotion'] : '';
    $date_promotion = explode(',', $date_promotion);
    $name_product = isset($_POST['name_product']) ? $_POST['name_product'] : '';
//    var_dump($discount_value_ex);die();
    $result = array('status'=>'NOTOK');
//    var_dump($date_promotion[0]);die();
    if ($tp == 'S') {
        $max_id = $clsPromotion->getMaxId();
        $f='promotion_id,target_id,user_id,price_text,check_mem_set,check_all_product,check_pieces_product,check_code_product,discount_value,start_date,end_date,travel_date_from,travel_date_to,reg_date,upd_date,promot,promotion_code,type,clsTable';
        $v = "'".$max_id."','".$target_id."','".$user_id."','".$name_product."','".$power_promotion[0]."','".$power_promotion[1]."','".$power_promotion[2]."','".$power_promotion[3]."','".$discount_value."','".strtotime(str_replace('/', '-', $date_promotion[0]))."','".strtotime(str_replace('/', '-', $date_promotion[1]))."','".strtotime(str_replace('/', '-', $date_promotion[2]))."','".strtotime(str_replace('/', '-', $date_promotion[3]))."','".time()."','".time()."','".$discount_value_ex[1]."','".$discount_value_ex[3]."','".$discount_value_ex[4]."','".$discount_value_ex[4]."'";
//        var_dump($v);die();
		
        $clsPromotion->insertOne($f,$v);
        $a =  $clsPromotion->getAll("1=1 order by promotion_id desc limit 1",$clsPromotion->pkey);
        foreach ($select_product as $item) {
            if($item>0){
                $clsPromotionItem->insertOne("taget_id,promotion_id,is_online","'".$item."','".$max_id."','1'");
            }
        }
        $result = array('status'=>'OK');
    } elseif ($tp == 'U') {
        $clsPromotion->updateOne($promotion_id,"price_text='".$name_product."',check_mem_set='".$power_promotion[0]."',check_all_product='".$power_promotion[1]."',check_pieces_product='".$power_promotion[2]."',check_code_product='".$power_promotion[3]."',discount_value='".$discount_value."',start_date='".strtotime(str_replace('/', '-', $date_promotion[0]))."',end_date='".strtotime(str_replace('/', '-', $date_promotion[1]))."',travel_date_from='".strtotime(str_replace('/', '-', $date_promotion[2]))."',travel_date_to='".strtotime(str_replace('/', '-', $date_promotion[3]))."',upd_date='".time()."',promot='".$discount_value_ex[1]."',promotion_code='".$discount_value_ex[3]."',type='".$discount_value_ex[4]."',clsTable='".$discount_value_ex[4]."'");
        $clsPromotionItem->deleteByCond("promotion_id=".$promotion_id ." and cruise_intinerary=0");
        foreach ($select_product as $item) {
            if($item>0){
                $clsPromotionItem->insertOne("taget_id,promotion_id,cruise_intinerary,is_online","'".$item."','".$promotion_id."',0,1");
            }
        }
        $result = array('status'=>'OK');
    } else {
        $result = array('status'=>'NOTOK');
    }
    echo json_encode($result);
    exit();
}
function default_ajLoadFormPromotionAddOne(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act,$dbconn;
    global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();

    $clsPromotion = new Promotion();
    $clsPromotionItem = new PromotionItem();
    $clsProperty = new Property();
    $clsCruiseItinerary = new CruiseItinerary();
    $tp= isset($_POST['tp'])?$_POST['tp']:'';
    $promotion_id= isset($_POST['promotion_id'])?$_POST['promotion_id']:'';
    $target_id= isset($_POST['target_id'])?$_POST['target_id']:'';
    $check_iti= isset($_POST['check_iti'])?$_POST['check_iti']:'';
    $type= isset($_POST['type'])?$_POST['type']:'';

    $cond= " is_online = 1 and type = '".$type."' ";
    $sql_promotion = "SELECT p.promotion_id FROM ".$clsPromotion->tbl." p LEFT JOIN ".$clsPromotionItem->tbl." pi ON(p.".$clsPromotion->pkey." = pi.".$clsPromotion->pkey.") WHERE p.is_online = 1 and p.type = '".$type."' and pi.taget_id =$target_id ";
    if($check_iti !=''){
        $sql_promotion .= " and pi.cruise_intinerary in ($check_iti)";
    }
//    var_dump($sql_promotion);
    $list_added_pro = $dbconn->GetAll($sql_promotion);
    $list_added = '';
    foreach ($list_added_pro as $lad){
        $list_added .= ','.$lad['promotion_id'];
    }
    $list_added = trim($list_added,',');
    if ($list_added){
        $cond .= " and promotion_id not in ($list_added)";
    }

//    $clsISO->print_pre($cond,true);die();
//    $cond= " is_online = 1 and type = 'Tour' and promotion_id not in ($list_added)";
    $order_by = " order by promotion_id desc";
    $list_all = $clsPromotion->getAll($cond.$order_by);

//    $clsISO->print_pre($list_added,true);die();
    $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
    $total = count( $list_all ); //total items in array
    $limit = 10; //per page
    $totalPages = ceil( $total/ $limit ); //calculate total pages
    $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
    $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
    $offset = ($page - 1) * $limit;
    if( $offset < 0 ) $offset = 0;
    $list_all = array_slice( $list_all, $offset, $limit );
    $link = 'index.php?mod=promotionpro&act=ajLoadKeySearch&page=%d';
    $lst_all_promotion_pro = array();

//    var_dump($promotion_id);die();

//    setcookie('power_promotion','1,1,1,0');
    $lstItinerary = $clsCruiseItinerary->getAll("cruise_id='$target_id' and is_trash=0 and is_online=1 order by order_no asc");
    $assign_list["lstItinerary"] = $lstItinerary;

    if($tp == 'L') {
        $html = '';
        $html.='
		<div class="headPop box_title_text">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'" style="display: none;"></a>
			<h2 class="title_promotion_pop">'.$core->get_Lang('Add Group Promotion').'</h2>
		</div>';
        $html .='
        <div class="clearfix" style="padding: 10px;"></div>
        <div class="box_search_pro_group">
            <label for="bar_search_pro_group">'.$core->get_Lang('Search Promotion').'</label>
            <input type="text" id="bar_search_group" placeholder="Search Promotion" size="50">
        </div>';
        if($type == 'Cruise'){
            $html .='<div class="box_cruise_intinerary">
            <ul>';
            for($i=0;$i<count($lstItinerary);$i++){
                $html .= '<li ><input type="radio" name="cruise_iti" class="" value="'.$lstItinerary[$i]['cruise_itinerary_id'].'" id="cruise_iti_'.$lstItinerary[$i]['cruise_itinerary_id'].'" > <label for="cruise_iti_'.$lstItinerary[$i]['cruise_itinerary_id'].'">'.$clsCruiseItinerary->getTitleDay($lstItinerary[$i]['cruise_itinerary_id']).'</label></li>';
            }

            $html .='</ul>
            </div>';
        }
        $html .='<div class="content_promotion_group">
            <div class="list_group_pro">
                <table>
                    <thead>
                        <tr>
                            <th class="gridheader"><strong>'.$core->get_Lang("index").'</strong></th>
                            <th class="gridheader"><strong>'.$core->get_Lang("Name").'</strong></th>
                            <th class="gridheader"><strong>'.$core->get_Lang("Discount").'</strong></th>
                            <th class="gridheader"><strong>'.$core->get_Lang("Action").'</strong></th>
                        </tr>
                    </thead>
                    <tbody class="tbl_promotion_group">';
                        foreach ($list_all as $item) {
                            $d_value = explode(',',$item['discount_value']);
                            $html .='<tr>';
                            $html .='<td style="text-align: center">'.$item["promotion_id"].'</td>';
                            $html .='<td>'.$item["price_text"].'
                                        <div class="more_info_promotion" style="display: none">
                                            <ul>
                                                <li>'.$core->get_Lang("Booking date").': '.date('d/m/Y',$item['start_date']).' -> '.date('d/m/Y',$item['end_date']).'</li>
                                                <li>'.$core->get_Lang("Travel date").': '.date('d/m/Y',$item['travel_date_from']).' -> '.date('d/m/Y',$item['travel_date_to']).'</li>';
                                                if($d_value[2] != 0 || $d_value[2] != 'undefined'){
                                                    $html .='<li>'.$core->get_Lang("Ticket quantity").': '.$d_value[2].'</li>';
                                                }
                                                if($d_value[3] != 0 || $d_value[3] != 'undefined'){
                                                    $html .='<li>'.$core->get_Lang("Promotion code").': '.$d_value[3].'</li>';
                                                }
                                                if($d_value[6] != 0 || $d_value[6] != 'undefined'){
                                                    $html .='<li>'.$core->get_Lang("Max price").': '.$d_value[6].'</li>';
                                                }
                                        $html .='<li>'.$core->get_Lang("Use for all person / member only").': ';
                                                if($item['check_mem_set'] == 1){
                                                    $html .='Yes';
                                                }else{
                                                    $html .='No';
                                                }
                                        $html .='</li>';
                                        $html .='<li>'.$core->get_Lang("Use for code promotion").': ';
                                                if($item['check_code_product'] == 1){
                                                    $html .='Yes';
                                                }else{
                                                    $html .='No';
                                                }
                                        $html .='</li>';
                                        $html .='</ul>   
                                        </div>
                                        <a class="read_more" href="javascript:void(0);">'.$core->get_Lang("More").'</a>    
                                        <a class="less_more" href="javascript:void(0);" style="display: none;">'.$core->get_Lang("Less").'</a>    
                                    </td>';
                            $html .='<td style="text-align: center;">'.$item["promot"].'%</td>';
                            $html .='<td style="text-align: center;"><a class="join_promotion_group" pro_id="'.$item["promotion_id"].'"';
                            if($check_iti != ''){
                                $html .='intinerary="'.$check_iti.'"';
                            }
                            $html .= 'href="javascript:void(0);">'.$core->get_Lang('Join').'</a></td>';
                            $html .='</tr>';
                        }
                     $html .='<tr><td colspan="4" style="text-align: center;"><div>';
                        if($check_iti !=''){
                            if( $totalPages != 0 )
                            {
                                if( $page == 1 )
                                {
                                    $html .= '';
                                }
                                else
                                {
                                    $html .= sprintf( '<a href="javascript:void(0)" onclick="page_all_cruise_pro(%d,'.$check_iti.')" style="color: #c00"> &#171; prev page</a>', $page - 1 );
                                }
                                $html .= ' <span> page <strong>' . $page . '</strong> from ' . $totalPages . '</span>';
                                if( $page == $totalPages )
                                {
                                    $html .= '';
                                }
                                else
                                {
                                    $html .= sprintf( '<a href="javascript:void(0)" onclick="page_all_cruise_pro(%d,'.$check_iti.')" style="color: #c00"> next page &#187; </a>', $page + 1 );
                                }
                            }
                        }else{
                            if( $totalPages != 0 )
                            {
                                if( $page == 1 )
                                {
                                    $html .= '';
                                }
                                else
                                {
                                    $html .= sprintf( '<a href="javascript:void(0)" onclick="page_all_pro(%d)" style="color: #c00"> &#171; prev page</a>', $page - 1 );
                                }
                                $html .= ' <span> page <strong>' . $page . '</strong> from ' . $totalPages . '</span>';
                                if( $page == $totalPages )
                                {
                                    $html .= '';
                                }
                                else
                                {
                                    $html .= sprintf( '<a href="javascript:void(0)" onclick="page_all_pro(%d)" style="color: #c00"> next page &#187; </a>', $page + 1 );
                                }
                            }
                        }

                            $html.= '
                                <script>
                                   $(".read_more").on("click",function() {
                                        var _this = $(this);
                                        $(".tbl_promotion_group").find(".more_info_promotion").hide("slow");
                                        $(".tbl_promotion_group").find(".read_more").show("fast");
                                        $(".tbl_promotion_group").find(".less_more").hide("fast");
                                        _this.closest("td").find(".less_more").show("fast");
                                        _this.closest("td").find(".more_info_promotion").show("slow");
                                        _this.hide("fast");
                                    });
                                    $(".less_more").on("click",function() {
                                        var _this = $(this);
                                        _this.closest("td").find(".read_more").show("fast");
                                        _this.closest("td").find(".more_info_promotion").hide("slow");
                                        _this.hide("fast");
                                    });
                                </script>
                            ';
                        $html .='</div></td></tr>';
            $html .='</tbody>
                </table>
                ';

        $html .=' 
            </div>
        </div>
        <div class="btn_save_back"><a class="btn_save_back_list" href="javascipt:void(0);">'.$core->get_Lang('Save & back').'</a></div>
        <script >
           var minlength = 3;
            var data = {
                keysearch: "",
            };
            var target_id = '.$target_id.';
            var type_pro = "'.$type.'";
             $(".box_cruise_intinerary input[type=radio]").change(function () {
                var results = getCheckTextCruiseInti();
                if(this.checked) {
                     $.ajax({
                        type: "GET",
                        url: path_ajax_script + "?mod=promotionpro&act=ajLoadKeySearch",
                        data: {
                            "target_id": target_id,
                            "type": type_pro,
                            "check_iti": results
                        },
                        dataType: "html",
                        success: function (html) {
                            $(".tbl_promotion_group").html(html);
                            
                        }
                    });
                }
            });
            $("#bar_search_group").keyup(function () {
                var _this = $(this);
                data.keysearch = $(this).val();
        
                
				$.ajax({
					type: "GET",
					url: path_ajax_script + "?mod=promotionpro&act=ajLoadKeySearch",
					data: {
						"data": data,
						"target_id": target_id,
						"type": type_pro
					},
					dataType: "html",
					success: function (html) {
						$(".tbl_promotion_group").html(html);
					}
				});
              
            });
            
            $(".join_promotion_group").on("click",function () {
                var _this = $(this);
                var pro_id = _this.attr("pro_id");
                var inti = _this.attr("intinerary");
        

				$.ajax({
					type: "GET",
					url: path_ajax_script + "?mod=promotionpro&act=ajAddItemPro",
					data: {
						"pro_id": pro_id,
						"inti": inti,
						"target_id": target_id,
					},
					dataType: "html",
					success: function (html) {
						_this.text("'.$core->get_Lang('Joined').'");
						console.log("ok");

					}
				});
            });
            
            
            function page_all_pro(lk) {
              $.ajax({
                    type: "GET",
                    url: "index.php?mod=promotionpro&act=ajLoadKeySearch",
                     data: {
                            "data": data,
                            "page": lk,
                            "target_id": target_id,
                             "type": type_pro
                        },
                    dataType: "html",
                    success: function (html) {
                        $(".tbl_promotion_group").html(html);
                    }
                });
            }
            function page_all_cruise_pro(lk,inti) {
              $.ajax({
                    type: "GET",
                    url: "index.php?mod=promotionpro&act=ajLoadKeySearch",
                     data: {
                            "data": data,
                            "page": lk,
                            "check_iti": inti,
                            "target_id": target_id,
                             "type": type_pro
                        },
                    dataType: "html",
                    success: function (html) {
                        $(".tbl_promotion_group").html(html);
                    }
                });
            }
            function loadPromotionPro(target_id,clsTable) {
                vietiso_loading(1);
                var $_this = $(this);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/?mod=promotionpro&act=ajLoadPromotionProItem",
                    data: {
                        "target_id": target_id,
                        "clsTable": clsTable
                    },
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        $("#ListPromotionPro").html(html);
                    }
                });
            }
            function getCheckTextCruiseInti() {
               var result =
                    $(".box_cruise_intinerary > ul > li > input:radio:checked").get();
                var columns = $.map(result, function(element) {
                    return $(element).attr("value");
                });
        
                return columns.join(",");
            }
            $(".btn_save_back_list").on("click",function () {
                var _this = $(this);
                $("#SiteFrmAddOnePromotionPro").find(".close_pop").trigger("click");
                loadPromotionPro(target_id,type_pro);
            });
        </script>
        ';
        if($promotion_id){
            $html.='<div class="btn_save_all_promotion" style="display: none;"><button id="btn_save_all_up" pro_id="'.$promotion_id.'" class="btn_save_all_up">'.$core->get_Lang('Save and continue').'</button></div>';
        }else{
            $html.='<div class="btn_save_all_promotion" style="display: none;"><button id="btn_save_all" class="btn_save_all">'.$core->get_Lang('Save and continue').'</button></div>';
        }
        echo($html);die();
    }elseif($tp == 'Le') {
        $html = '';
        $html.='
		<div class="headPop box_title_text">
			<a class="closeEv close_pop" href="javascript:void();" title="'.$core->get_Lang('close').'"></a>
			<h2 class="title_promotion_pop">'.$core->get_Lang('Create a promotion').'</h2>
		</div>';
        $html .='
        <div class="clearfix" style="padding: 10px;"></div>
        <div class="who_can_see">
            <p class="title_pop_who_see">'.$core->get_Lang('Who can see').' <span class="unshow_option"><i class="fa fa-angle-double-up"></i>  <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_op" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_option_mem"></div>
        </div>
        <div class="date_promotion_pro">
            <p class="title_date_promotion">'.$core->get_Lang('Dates').' <span class="show_date"><i class="fa fa-angle-double-down"></i> <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_dt" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_date_promotion"></div>
        </div>
        <div class="date_promotion_detail">
            <p class="title_promotion_detail">'.$core->get_Lang('Promotion details').' <span class="show_pro_detail"><i class="fa fa-angle-double-down"></i> <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_pd" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_promotion_detail"></div>
        </div>
        <div class="date_promotion_name">
            <p class="title_promotion_name">'.$core->get_Lang('Promotion name').' <span class="show_pro_name"><i class="fa fa-angle-double-down"></i> <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading_promotion_pro_pn" style="font-size: 1em;display: none;"></i></span></p>
            <div class="box_promotion_name"></div>
        </div> ';
        if($promotion_id){
            $html.='<div class="btn_save_all_promotion" style="display: none;"><button id="btn_save_all_up" pro_id="'.$promotion_id.'" class="btn_save_all_up">'.$core->get_Lang('Save and continue').'</button></div>';
        }else{
            $html.='<div class="btn_save_all_promotion" style="display: none;"><button id="btn_save_all" class="btn_save_all">'.$core->get_Lang('Save and continue').'</button></div>';
        }
        echo($html);die();
    }else{

    }
}
function default_ajLoadKeySearch(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act,$dbconn;
    global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
    $clsTour = new Tour();

    $clsPromotion = new Promotion();
    $clsPromotionItem = new PromotionItem();
    $clsProperty = new Property();
    $tp= isset($_POST['tp'])?$_POST['tp']:'';
    $data= isset($_GET['data'])?$_GET['data']:'';
    $target_id= isset($_GET['target_id'])?$_GET['target_id']:'';
    $type= isset($_GET['type'])?$_GET['type']:'';
    $check_iti= isset($_GET['check_iti'])?$_GET['check_iti']:'';
    $keyseach= $data['keysearch'];
//    var_dump($check_iti);

//    $tour_id= isset($_POST['tour_id'])?$_POST['tour_id']:'';
    $cond= " is_online = 1 and type = '".$type."' ";
    $sql_promotion = "SELECT p.promotion_id FROM ".$clsPromotion->tbl." p LEFT JOIN ".$clsPromotionItem->tbl." pi ON(p.".$clsPromotion->pkey." = pi.".$clsPromotion->pkey.") WHERE p.is_online = 1 and p.type = '".$type."' and pi.taget_id =$target_id ";
    if($check_iti !=''){
        $sql_promotion .= " and pi.cruise_intinerary in ($check_iti)";
    }
    $list_added_pro = $dbconn->GetAll($sql_promotion);
//    var_dump($sql_promotion);
    $list_added = '';
    foreach ($list_added_pro as $lad){
        $list_added .= ','.$lad['promotion_id'];
    }
    $list_added = trim($list_added,',');
    if ($list_added){
        $cond .= " and promotion_id not in ($list_added)";
    }

    $html = '';
//    $cond= " is_online = 1";
    if($keyseach != ''){
        $cond .= " and price_text LIKE '".$keyseach."%'";
    }
    $order_by = " order by promotion_id desc";
    $list_all = $clsPromotion->getAll($cond.$order_by);

    $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;

    $total = count( $list_all ); //total items in array
    $limit = 10; //per page
    $totalPages = ceil( $total/ $limit ); //calculate total pages
    $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
    $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
    $offset = ($page - 1) * $limit;
    if( $offset < 0 ) $offset = 0;
    $list_all = array_slice( $list_all, $offset, $limit );
    if($list_all){
        foreach ($list_all as $item) {
            $d_value = explode(',',$item['discount_value']);
            $html .='<tr>';
            $html .='<td>'.$item["promotion_id"].'</td>';
            $html .='<td>'.$item["price_text"].'
                                            <div class="more_info_promotion" style="display: none">
                                                <ul>
                                                    <li>'.$core->get_Lang("Booking date").': '.date('d/m/Y',$item['start_date']).' -> '.date('d/m/Y',$item['end_date']).'</li>
                                                    <li>'.$core->get_Lang("Travel date").': '.date('d/m/Y',$item['travel_date_from']).' -> '.date('d/m/Y',$item['travel_date_to']).'</li>';
            if($d_value[2] != 0 || $d_value[2] != 'undefined'){
                $html .='<li>'.$core->get_Lang("Ticket quantity").': '.$d_value[2].'</li>';
            }
            if($d_value[3] != 0 || $d_value[3] != 'undefined'){
                $html .='<li>'.$core->get_Lang("Promotion code").': '.$d_value[3].'</li>';
            }
            if($d_value[6] != 0 || $d_value[6] != 'undefined'){
                $html .='<li>'.$core->get_Lang("Max price").': '.$d_value[6].'</li>';
            }
            $html .='<li>'.$core->get_Lang("Use for all person / member only").': ';
            if($item['check_mem_set'] == 1){
                $html .='Yes';
            }else{
                $html .='No';
            }
            $html .='</li>';
            $html .='<li>'.$core->get_Lang("Use for all product").': ';
            if($item['check_all_product'] == 1){
                $html .='Yes';
            }else{
                $html .='No';
            }
            $html .='</li>';
            $html .='<li>'.$core->get_Lang("Use for pieces product").': ';
            if($item['check_all_product'] == 1){
                $html .='Yes';
            }else{
                $html .='No';
            }
            $html .='</li>';
            $html .='<li>'.$core->get_Lang("Use for pieces product").': ';
            if($item['check_pieces_product'] == 1){
                $html .='Yes';
            }else{
                $html .='No';
            }
            $html .='</li>';
            $html .='<li>'.$core->get_Lang("Use for code promotion").': ';
            if($item['check_code_product'] == 1){
                $html .='Yes';
            }else{
                $html .='No';
            }
            $html .='</li>';
            $html .='</ul>   
                                            </div>
                                            <a class="read_more" href="javascript:void(0);">'.$core->get_Lang("More").'</a>    
                                            <a class="less_more" href="javascript:void(0);" style="display: none;">'.$core->get_Lang("Less").'</a>    
                                        </td>';
            $html .='<td>'.$item["promot"].'%</td>';
            $html .='<td><a class="join_promotion_group" pro_id="'.$item["promotion_id"].'"';
                if($check_iti != ''){
                    $html .='intinerary="'.$check_iti.'"';
                }
            $html .= 'href="javascript:void(0);">'.$core->get_Lang('Join').'</a></td>';
            $html .='</tr>';
        }
        $html .='<tr><td colspan="4"><div  style="width: 300px;">';
        if($check_iti !=''){
            if( $totalPages != 0 )
            {
                if( $page == 1 )
                {
                    $html .= '';
                }
                else
                {
                    $html .= sprintf( '<a href="javascript:void(0)" onclick="page_all_cruise_pro(%d,'.$check_iti.')" style="color: #c00"> &#171; prev page</a>', $page - 1 );
                }
                $html .= ' <span> page <strong>' . $page . '</strong> from ' . $totalPages . '</span>';
                if( $page == $totalPages )
                {
                    $html .= '';
                }
                else
                {
                    $html .= sprintf( '<a href="javascript:void(0)" onclick="page_all_cruise_pro(%d,'.$check_iti.')" style="color: #c00"> next page &#187; </a>', $page + 1 );
                }
            }
        }else{
            if( $totalPages != 0 )
            {
                if( $page == 1 )
                {
                    $html .= '';
                }
                else
                {
                    $html .= sprintf( '<a href="javascript:void(0)" onclick="page_all_pro(%d)" style="color: #c00"> &#171; prev page</a>', $page - 1 );
                }
                $html .= ' <span> page <strong>' . $page . '</strong> from ' . $totalPages . '</span>';
                if( $page == $totalPages )
                {
                    $html .= '';
                }
                else
                {
                    $html .= sprintf( '<a href="javascript:void(0)" onclick="page_all_pro(%d)" style="color: #c00"> next page &#187; </a>', $page + 1 );
                }
            }
        }

        $html.= '
        <script>
            $(".read_more").on("click",function() {
                var _this = $(this);
                $(".tbl_promotion_group").find(".more_info_promotion").hide("slow");
                $(".tbl_promotion_group").find(".read_more").show("fast");
                $(".tbl_promotion_group").find(".less_more").hide("fast");
                _this.closest("td").find(".less_more").show("fast");
                _this.closest("td").find(".more_info_promotion").show("slow");
                _this.hide("fast");
            });
            $(".less_more").on("click",function() {
                var _this = $(this);
                _this.closest("td").find(".read_more").show("fast");
                _this.closest("td").find(".more_info_promotion").hide("slow");
                _this.hide("fast");
            });
             $(".join_promotion_group").on("click",function () {
                var _this = $(this);
                var pro_id = _this.attr("pro_id");
                var inti = _this.attr("intinerary");
        
                /*if (_this.val().length >= minlength) {*/
                    $.ajax({
                        type: "GET",
                        url: path_ajax_script + "?mod=promotionpro&act=ajAddItemPro",
                        data: {
                            "pro_id": pro_id,
                            "inti": inti,
                            "target_id": target_id,
                        },
                        dataType: "html",
                        success: function (html) {
                            _this.text("'.$core->get_Lang('Joined').'");
                           
                            // vietiso_loading(0);
                            // $("#ListPromotion").html(html);
                        }
                    });
               /* }*/
            });
        </script>
    ';
        $html .='</div></td></tr>';
    }else{
        $html .='</div><tr><td>'.$core->get_Lang("No matching results were found!").'</td></tr></div';
    }


    echo $html;die();
}
function default_ajAddItemPro(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act,$dbconn;
    global $core, $clsModule, $clsButtonNav,$oneSetting,$clsISO,$clsConfiguration;
    $clsTour = new Tour();
    $clsPromotion = new Promotion();
    $clsPromotionItem = new PromotionItem();
    $pro_id= isset($_GET['pro_id'])?$_GET['pro_id']:'';
    $target_id= isset($_GET['target_id'])?$_GET['target_id']:'';
    $inti= isset($_GET['inti'])?$_GET['inti']:'';
    if($pro_id !='' && $target_id!=''){
        if($inti !=''){
            $count = $clsPromotionItem->CountItemCruise($target_id,$pro_id,$inti);
            if($count <= 0){
                $result = $clsPromotionItem->insertOne('taget_id,promotion_id,cruise_intinerary,is_online',$target_id.','.$pro_id.','.$inti.',1');
                if($result == 1){
                    $result = 'Ok';
                }else{
                    $result = 'Not insert';
                }
            }else{
                $result = 'Item is alreadey';
            }
        }else{
            $count = $clsPromotionItem->CountPromotion($target_id,$pro_id);
            if($count <= 0){
                $result = $clsPromotionItem->insertOne('taget_id,promotion_id,is_online',$target_id.','.$pro_id.',1');
                if($result == 1){
                    $result = 'Ok';
                }else{
                    $result = 'Not insert';
                }
            }else{
                $result = 'Item is alreadey';
            }
        }
    }else{
        $result = 'data input not enough target id or promotion id';
    }
    echo $result ;die();
}
function default_ajLoadPromotionProItem(){
    global $core,$clsISO,$clsConfiguration,$dbconn;
    $clsTour = new Tour();
    $clsCruiseItinerary = new CruiseItinerary();
    $clsProperty = new Property();
    $clsPromotion = new Promotion();
    $clsPromotionItem = new PromotionItem();

    #
    $currency = $clsConfiguration->getValue('Currency');
    $target_id = isset($_POST['target_id'])?$_POST['target_id']:'';
    $type = isset($_POST['type'])?$_POST['type']:'';
    $clsTable = isset($_POST['clsTable'])?$_POST['clsTable']:'';
	 $sql ="SELECT * FROM ".$clsPromotion->tbl." p LEFT JOIN ".$clsPromotionItem->tbl." pi ON(p.".$clsPromotion->pkey." = pi.".$clsPromotion->pkey.") WHERE p.is_online = 1 and p.type = '".$clsTable."' and pi.taget_id =$target_id ORDER BY p.promotion_id desc";
    $html = '';
	
    //$lstPromotion = $clsPromotion->getAll("is_online=1 and target_id='$target_id' and clsTable='$clsTable' order by promotion_id desc");
	
	//print_r($sql);die();
	$lstPromotion = $dbconn->GetAll($sql);
//    var_dump($lstPromotion);
    if($lstPromotion[0][$clsPromotion->pkey]!=''){
        $html .= '<p class="mb10" style="font-size:18px; display:inline-block; line-height:30px; vertical-align:top"><span  style="display:inline-block; line-height:60px;">'.$core->get_Lang('List promotion').'  </span>
		</p>
		<div id="holderAllCruiseBestDeal" style="width:100%;">
		<table cellspacing="0" width="100%" class="tbl-grid">
		<tr>
		<td class="gridheader" style="text-align:center; width:120px ">'.$core->get_Lang('Item').'</td>
		<td class="gridheader" style="text-align:center; width:120px ">'.$core->get_Lang('Promotion code').'</td>
		<td class="gridheader" style="text-align:center;width:160px ">'.$core->get_Lang('Booking date').'</td>
		<td class="gridheader" style="text-align:center;width:160px ">'.$core->get_Lang('Travel date').'</td>
		<td class="gridheader" style="text-align:center;">'.$core->get_Lang('Flag').'</td>';
            if($clsTable == 'Cruise'){
                $html .='<td class="gridheader" style="text-align:center;">'.$core->get_Lang('Itinerary').'</td>';
            }
		$html .='<td class="gridheader" style="text-align:center;">'.$core->get_Lang('Tick ket').'</td>
		<td class="gridheader" style="text-align:center;width:100px ">'.$core->get_Lang('Promotion').'(%)</td>
		<td class="gridheader" style="text-align:center;width:100px ">'.$core->get_Lang('Max price').'</td>';
        $html .= '<td class="gridheader" style="text-align:center;width:60px ">'.$core->get_Lang('Public').'</td>
		<td class="gridheader" style="text-align:center;width:70px ">'.$core->get_Lang('Function').'</td>
		</tr>
		';
        for($m=0;$m<count($lstPromotion);$m++){
            $promotion_id = $lstPromotion[$m][$clsPromotion->pkey];
            $promotion_item_id = $lstPromotion[$m][$clsPromotionItem->pkey];
            $start_date = $lstPromotion[$m]['start_date'] ? $lstPromotion[$m]['start_date']: time();
            $end_date = $lstPromotion[$m]['end_date'] ? $lstPromotion[$m]['end_date']: time();
            $travel_date_from = $lstPromotion[$m]['travel_date_from'] ? $lstPromotion[$m]['travel_date_from']: time();
            $travel_date_to = $lstPromotion[$m]['travel_date_to'] ? $lstPromotion[$m]['travel_date_to']: time();
            $cruise_itinerary = $clsCruiseItinerary->getTitleDay($lstPromotion[$m]['cruise_intinerary']);
            if($cruise_itinerary == 'day' || $cruise_itinerary == '  Day'){
                $cruise_iti = 'All';
            }else{
                $cruise_iti = $cruise_itinerary;
            }
            $html .= '
		<tr style="'.($m%2==0?'background:#eee':'background:#fff').'">
			<td style="text-align:center;">'.$promotion_item_id.'</td>';
            if($lstPromotion[$m]['promotion_code'] != undefined){
                $html .= '<td style="text-align:center;">'.$lstPromotion[$m]['promotion_code'].'</td>';
            }else{
                $html .= '<td style="text-align:center;"></td>';
            }

            $html .= '<td style="text-align:center;white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">'.date('d/m/Y',$start_date).' -> '.date('d/m/Y',$end_date).'</td>
			<td style="text-align:center;white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">'.date('d/m/Y',$travel_date_from).' -> '.date('d/m/Y',$travel_date_to).'</td>
			<td style="text-align:center;">'.$lstPromotion[$m]['price_text'].'</td>';
            if($clsTable == 'Cruise'){
                $html .='<td style="text-align:center;">'.$cruise_iti.'</td>';
            }
            $discount_value = explode(',',$lstPromotion[$m]['discount_value']);
            if($discount_value[2] != undefined){
                $html .= '<td style="text-align:center;">'.$discount_value[2].'</td>';
            }else{
                $html .= '<td style="text-align:center;"></td>';
            }
			$html .= '<td style="text-align:center;">'.$lstPromotion[$m]['promot'].'</td>';
            if($discount_value[6] != undefined){
                $html .= '<td style="text-align:center;">'.$discount_value[6].'</td>';
            }else{
                $html .= '<td style="text-align:center;"></td>';
            }
            $html .= '<td style="text-align:center;">
				<a href="javascript:void(0);" class="SiteClickPublic" clsTable="PromotionItem" pkey="promotion_item_id" sourse_id="'.$lstPromotion[$m]['promotion_item_id'].'" rel="'.$lstPromotion[$m]['is_online'].'" title="'.$core->get_Lang('Click to change status').'">';
            if($lstPromotion[$m]['is_online'] == '1'){
                $html .= '<i class="fa fa-check-circle green"></i>';
            }else{
                $html .= '<i class="fa fa-minus-circle red"></i>';
            }
            $html .= '</a>
			</td>';
            $html .= '<td style="padding:5px 5px; text-align:center;">
				<div class="btn-group">
					<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
					<ul class="dropdown-menu" style="right:0px !important">
						<li><a title="'.$core->get_Lang('delete').'" promotion_id="'.$promotion_id.'" target_id="'.$target_id.'" clsTable="'.$clsTable.'" item="'.$promotion_item_id.'" class="clickDeletePromotionPro" href="javascript:void(0);"><i class="icon-trash"></i> '.$core->get_Lang('delete').'</a></li>
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
?>