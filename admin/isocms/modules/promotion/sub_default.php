<?php
function default_default() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
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
	$promotion_id = $_POST['promotion_id'];
	$clsPromotion->deleteOne($promotion_id);
	echo('1');die();
}
function default_ajGetPromotionCode(){
	global $core, $clsISO,$_LANG_ID,$gid;
	#
	echo('0|||'.$clsISO->getRandomString());die();	
}
?>