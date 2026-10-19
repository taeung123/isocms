<?php
/*======================================================================*\
|| #################################################################### ||
|| # The modules of the ISOCMS                                        # ||
|| # ISOCMS 6.0.0 By Luong Tien Dung (luongtiendung@gmail.com)        # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
function doLoginAgain($user_id){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$clsUser = new User();
	$user_name = $clsUser->getOneField('user_name',$user_id);
	$user_pass = $clsUser->getOneField('user_pass',$user_id);
	#
	vnSessionSetVar("LOGGEDIN", 1);
	vnSessionSetVar("NVC_USERNAME", $user_name);
	vnSessionSetVar("NVC_PASSWORD", $user_pass);
	return $user_pass;
}
function default_doLogin(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$core->_SESS->doLoginAgain($core->_SESS->user_id);
}
function default_loginAgain(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	doLoginAgain($core->_SESS->user_id);
	#
	echo(1); die();
}
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	global $clsConfiguration;
	#----
	$clsFeedback = new Feedback();
	$assign_list["clsFeedback"] = $clsFeedback;
	$lstFeedback = $clsFeedback->getAll("1=1 order by reg_date DESC LIMIT 0,5");
	$assign_list["lstFeedback"] = $lstFeedback; unset($lstFeedback);
}
function default_ajDeleteItemImage(){
	global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	#
	$clsTable =  addslashes($_POST['clsTable']);
	$clsClassTable = new $clsTable();
	$pvalTable = addslashes($_POST['pvalTable']);
	#
	$clsClassTable->updateOne($pvalTable,"image=''");  
	echo($clsClassTable->getOneField('image',$pvalTable));die(); 
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
//				print_r($clsTable);die();
				$clsClassTable->doDelete($temp[$i]);
			}
		}
	}
}
function default_ajDeleteMultiItemPromotionPro(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav;
	#
	$clsTable = $_POST['clsTable'];
    $clsPromotionItem = new PromotionItem();
	$listID = isset($_POST['listID'])?$_POST['listID']:'';
	#
	$clsClassTable = new $clsTable();
	if($listID != '' && $listID != '0') {
		$temp = explode('|',$listID);
		if(is_array($temp) && count($temp) > 0){
			for($i=0; $i<count($temp); $i++){
				$clsClassTable->doDelete($temp[$i]);
                $clsPromotionItem->doDeleteAllByProId($temp[$i]);
			}
		}
	}
}
function default_ajDeleteMultiItemBooking(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    #
    $clsTable = $_POST['clsTable'];
    $listID = isset($_POST['listID'])?$_POST['listID']:'';
    $bk_type = isset($_POST['type'])?$_POST['type']:'';
//    var_dump($_POST);die();
    #
    $clsClassTable = new $clsTable();
    if($listID != '' && $listID != '0') {
        $a = $clsClassTable->doDeleteAllByBooking($listID,$bk_type);
        echo $a;die();
    }
}
function default_ajDeleteMultiItemNew(){
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    #
    $clsTable = $_POST['clsTable'];
    $listID = isset($_POST['listID'])?$_POST['listID']:'';
    #
    $clsClassTable = new $clsTable();
    if($listID != '' && $listID != '0') {
        $clsClassTable->doDelete($listID);
    }
}

function default_ajaxPopSiteHelp(){
	global $core;
	#
	$clsHelp = new Help();
	$mod_page = $_POST['mod_page'];
	$act_page = $_POST['act_page'];
	$area_page = $_POST['area_page'];
	
	$SiteHelpPage = 'Site_Help_'.$mod_page.'_'.$act_page;
	if($area_page != ''){
		$SiteHelpPage .= '_'.$area_page;
	}
	#
	$html='';
	$html.='
	<div class="headPop"> 
		<a class="closeEv close_pop" data-dismiss="modal" aria-hidden="true">&nbsp;</a> 
		<h3>'.$core->get_Lang('infohelpmod').' '.$core->get_Lang($mod_page).'</h3>
	</div>';
	if(_DEV == '1') {
	$html.='
	<form method="post" action="" id="formHelp" class="frmform formborder" enctype="multipart/form-data">
		<div class="wrap">
			<div class="fl" style="width:100%">
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">'.$core->get_Lang('content').'</div>
					<div class="fieldarea">
						<textarea id="textarea_help_content_editor_'.time().'" class="textarea_help_content_editor" name="'.$SiteHelpPage.'" style="width:100%">'.$clsHelp->getValue($SiteHelpPage).'</textarea>
					</div>
				</div>
			</div>
		</div>
	</form>
	<div class="modal-footer"> 
		<button class="btn btn-primary btnSaveSiteHelpPage" mod_page="'.$mod_page.'" act_page="'.$act_page.'" area_page="'.$area_page.'">
			<i class="icon-ok icon-white"></i> '.$core->get_Lang('Save').'
		</button> 
		<button type="reset" class="btn btn-warning close_pop">
			<i class="icon-retweet icon-white"></i> <span>Đóng lại</span>
		</button>
	</div>';
	} else {
		$html .= '
		<style>
			.formatTextStandard{width:99%;padding-right:1%;max-height:470px;overflow-y:scroll}
		</style>';
		$html.= '<div class="formatTextStandard">';
		if($clsHelp->getValue($SiteHelpPage) != ''){
			$html .= $clsHelp->getValue($SiteHelpPage);
		}else{
			$html .= $core->get_Lang('Help content empty !');
		}
		$html .= '</div>';
	}
	echo $html; die();
}
function default_ajaxSaveSiteHelp(){
	global $core;
	#
	$clsHelp = new Help();
	$mod_page = $_POST['mod_page'];
	$act_page = $_POST['act_page'];
	$area_page = $_POST['area_page'];
	
	$SiteHelpPage = 'Site_Help_'.$mod_page.'_'.$act_page;
	if($area_page != ''){
		$SiteHelpPage .= '_'.$area_page;
	}
	$help_content = isset($_POST['help_content'])?addslashes($_POST['help_content']):'';
	$clsHelp->updateValue($SiteHelpPage,$help_content);
	echo(1); die();
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
		if($toField == 'allotment') {
			$clsClassTable->updateOne($pvalTable,"seat_available = '".addslashes($val)."'");
		}
		$html = $val;
	}else{
		$all = $clsClassTable->getAll($toField."='$val'");
		if($all[0][$pkey]!='' && $all[0][$pkey]!=$pvalTable){
			$html = 'IsDuplicated';
		}else{
			$clsClassTable->updateOne($pvalTable,$toField."='".addslashes($val)."'");
			$html = $val;
		}
	}
	sleep(1);
	echo($html); die();
}
function default_ajOpenFeedback(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav;
	#
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	$clsISO = new ISO();
	
	if($tp=='F'){
		$html = '
		<div class="headPop">
			<h3>Send Feedback To <a style="color:#333" href="http://www.vietiso.com">VIET<font color="#F93">ISO</font></a></h3>
			<a href="javscript:void(0);" class="close_pop closeEv"></a>
		</div>
		<div class="space-6"></div>
		<form method="post" action="" id="form-feedback">
			<div class="row">
				<div class="col-xs-6">
					<div class="btn btn-sm btn-danger btn-block btn-grey faded button_toggle" act="bug">
						<i class="fa fa-bug"></i> Report a Problem
					</div>
				</div>
				<div class="col-xs-6">
					<div class="btn btn-sm btn-primary btn-block button_toggle" act="feedback">
						<i class="fa fa-comment"></i> Send Feedback
					</div>
				</div>
			</div>
			<div class="space-6"></div>
			<input type="hidden" id="type" value="feedback">
			<div class="row">
				<div class="col-xs-12">
					<textarea id="message_feedback" placeholder="Enter your feedback." class="col-xs-12" style="height:270px;"></textarea>
					<div class="clearfix"></div>
					<div class="form-actions mt20 mb20">
						<a id="send_feedback" style="padding:10px" class="btn btn-primary">
							<i class="icon-ok icon-white bigger-110"></i> Send Message
						</a>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(function(){
				$(\'#message_feedback\').focus();
				$(\'.button_toggle\').click(function(e) {
					var act = $(this).attr(\'act\');
					$(\'.button_toggle\').removeClass(\'btn-grey faded\').addClass(\'btn-grey faded\');
					$(this).removeClass(\'btn-grey faded\');
					$(\'#type\').val(act);
					var placeholder = (act == \'bug\') ? \'Describe the problem and any instructions required to replicate it.\' : \'Enter your feedback.\';
					$(\'#message_feedback\').attr(\'placeholder\', placeholder);
				});
			});
		</script>';
		echo $html; die();
	}else if($tp=='S'){
		$type = isset($_POST['type']) ? $_POST['type'] : 'feedback';
		$REQUEST_URI = $_POST['REQUEST_URI'];
		$message = isset($_POST['message']) ? $_POST['message'] : '';
		if(trim($message)=='' && $message=='0'){
			echo '_EMPTY'; die();
		}
		#
		$from = 'no-reply@vietiso.com';
		$to = 'support@vietiso.com';
		if($type=='feedback'){
			$suject = '✪✪✪ New feedback from '.PAGE_NAME;
		}else{
			$suject = '✪✪ New bug from '.PAGE_NAME;
			$message .= '
			<br />
			<u>Link bug</u>:'.$REQUEST_URI;
		}
		$owner = PAGE_NAME;
		$message = '
		Xin chào,
		<h2>Bạn nhận được một '.($type=='feedback'?'phản hồi':'thông báo bug').' được gửi từ ('.$core->_USER['first_name'].' '.$core->_USER['last_name'].') </h2>
		<strong> '.PAGE_NAME.' </strong> | '.$clsISO->converTimeToText(time()).' <br />
		<div style="clear:both; margin-top:6px"></div>
		<div style="padding:10px; border:2px dashed #DDD; background:#FFC">'.$message.'</div>
		<br />
		Cảm ơn trước sự kiên nhẫn và hỗ trợ của bạn.
		<div> Thông báo này đã được gửi từ <a href="mailto:'.$core->_USER['user_name'].'" target="_blank"> '.$core->_USER['user_name'].' </a> . Vui lòng reply lại nếu bạn nhận được email thống báo này.</div>';
		#
		$is_send_mail = $clsISO->sendEmail($from, $to, $suject, $message, $owner);
		//$is_send_mail = $clsISO->sendEmail($from, $to, $suject, $message, $owner);
		if($is_send_mail){
			sleep(1);
			echo '_SUCCESS'; die();
		}else{
			echo '_ERROR'; die();
		}
	}
}
function default_ajOpenNote(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav;
	$user_id = $core->_USER['user_id'];
	#
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	$clsUser = new User();
	
	$html = '
	<div class="headPop">
		<h3>'.$core->get_Lang('My Notes').'</h3>
		<a href="javscript:void(0);" class="close_pop closeEv"></a>
	</div>
	<form method="post" action="" id="form-feedback">
		<div class="row-span">
			<textarea id="myNotes" placeholder="'.$core->get_Lang('Enter your notes').'." class="textarea full" style="height:250px;">'.$clsUser->getOneField('notes', $user_id).'</textarea>
			<div class="clearfix"></div>
			<div class="modal-footer">
				<a id="btnUpdateNotes" user_id="'.$user_id.'" style="padding:10px" class="btn btn-primary">
					<i class="icon-ok icon-white bigger-110"></i> '.$core->get_Lang('Save').'
				</a>
			</div>
		</div> 
	</div>
	<script type="text/javascript">
		$(function(){
			$(document).on(\'click\', \'#btnUpdateNotes\', function(ev){
				var $_this = $(this);
				var adata = {};
				adata[\'clsTable\'] = \'User\';
				adata[\'pkey\'] = \'user_id\';
				adata[\'pvalTable\'] = $_this.attr(\'user_id\');
				adata[\'toField\'] = \'notes\';
				adata[\'val\'] = $(\'#myNotes\').val();
				adata[\'allowDuplicate\'] = 1;
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script + \'/?mod=home&act=saveField\',
					data: adata,
					success: function(html) {
						vietiso_loading(0);
						alertify.success(\'Sucess !\');
					}
				});
				return false;
			});
		});
	</script>';
	echo $html; die();
}
function default_ajOpenSidebar(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav;
	$user_id = $core->_USER['user_id'];
	
	$clsConfiguration = new Configuration();
	$val = isset($_POST['val']) ? $_POST['val'] : 0;
	$clsConfiguration->updateValue('SIDEBAR_TOGGLE_'.$user_id,$val);
	echo($val); die();
}
function default_ajLoadChartBooking(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav;
	$user_id = $core->_USER['user_id'];
	
	$clsBooking = new Booking();
	$Current_Now = time();
	$Current_Year = date('Y',$Current_Now);
	
	$html = '<div id="placeholder" class="demo-placeholder"></div>';
	$html.= '
	<style>
	.demo-placeholder {
		width: 530px;
		height: 200px;
		font-size: 14px;
		line-height: 1.2em;
	}
	</style>
	<script type="text/javascript">
		$(function() {
			var hotel = [],
				tour = [],
				tailor = [];
			';
			for($i=1; $i<=12; $i++){
				$html.= '
				hotel.push(['.$i.','.$clsBooking->getTotalBooking($i, $Current_Year, 'Hotel').']);
				tour.push(['.$i.','.$clsBooking->getTotalBooking($i, $Current_Year, 'Tour').']);
				tailor.push(['.$i.','.$clsBooking->getTotalBooking($i, $Current_Year, 'Tailor').']);
				';
			}
			$html.='
			var plot = $.plot("#placeholder", [
				{ data: hotel, label: "'.$core->get_Lang('bookinghotel').'"},
				{ data: tour, label: "'.$core->get_Lang('bookingtour').'"},
				{ data: tailor, label: "'.$core->get_Lang('bookingtailor').'"}],
				{
				series: {
					lines: {
						show: true
					},
					points: {
						show: true
					}
				},
				grid: {
					hoverable: true,
					clickable: true
				},
				xaxis: {
					min: 1,
					max: 12
				},
				yaxis: {
					min: 0,
					max: 50
				}
			});
			$("<div id=\'tooltip\'></div>").css({
				position: "absolute",
				display: "none",
				border: "2px solid #c00000",
				padding: "5px",
				"background-color": "#FFF",
				"border-radius" : "3px",
				"-moz-border-radius" : "3px",
				"-webkit-border-radius" : "3px",
				"-khtml-border-radius" : "3px",
				"-o-border-radius" : "3px",
				"font-size" : "11px"
			}).appendTo("body");
			$("#placeholder").bind("plothover", function (event, pos, item) {
				if (item) {
					var x = item.datapoint[0].toFixed(2),
						y = item.datapoint[1].toFixed(0);
					$("#tooltip").html(item.series.label + "<br />Total(s): "+y)
						.css({top: item.pageY+5, left: item.pageX+5})
						.fadeIn(200);
				} else {
					$("#tooltip").hide();
				}
			});
		});
	</script>';
	echo $html; die();
}
function default_ajLoadChartBooking2(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav;
	$user_id = $core->_USER['user_id'];
	
	$clsBooking = new Booking();
	$Current_Now = time();
	$Current_Year = date('Y',$Current_Now);
	
	$html = '<div id="placeholder" class="demo-placeholder"></div>';
	$html.= '
	<style>
	.demo-placeholder {
		width: 100%;
		height: 250px;
		font-size: 14px;
		line-height: 1.2em;
	}
	</style>
	<script type="text/javascript">
		$(function() {
			var hotel = [],
				tour = [],
				tailor = [];
			';
			for($i=1; $i<=12; $i++){
				$html.= '
				hotel.push(['.$i.','.$clsBooking->getTotalBooking($i, $Current_Year, 'Hotel').']);
				tour.push(['.$i.','.$clsBooking->getTotalBooking($i, $Current_Year, 'Tour').']);
				tailor.push(['.$i.','.$clsBooking->getTotalBooking($i, $Current_Year, 'Tailor').']);
				';
			}
			$html.='
			var plot = $.plot("#placeholder", [
				{ data: hotel, label: "'.$core->get_Lang('bookinghotel').'"},
				{ data: tour, label: "'.$core->get_Lang('bookingtour').'"},
				{ data: tailor, label: "'.$core->get_Lang('bookingtailor').'"}],
				{
				series: {
					lines: {
						show: true
					},
					points: {
						show: true
					}
				},
				grid: {
					hoverable: true,
					clickable: true
				},
				xaxis: {
					min: 1,
					max: 12
				},
				yaxis: {
					min: 0,
					max: 50
				}
			});
			$("<div id=\'tooltip\'></div>").css({
				position: "absolute",
				display: "none",
				border: "2px solid #c00000",
				padding: "5px",
				"background-color": "#FFF",
				"border-radius" : "3px",
				"-moz-border-radius" : "3px",
				"-webkit-border-radius" : "3px",
				"-khtml-border-radius" : "3px",
				"-o-border-radius" : "3px",
				"font-size" : "11px"
			}).appendTo("body");
			$("#placeholder").bind("plothover", function (event, pos, item) {
				if (item) {
					var x = item.datapoint[0].toFixed(2),
						y = item.datapoint[1].toFixed(0);
					$("#tooltip").html(item.series.label + "<br />Total(s): "+y)
						.css({top: item.pageY+5, left: item.pageX+5})
						.fadeIn(200);
				} else {
					$("#tooltip").hide();
				}
			});
		});
	</script>';
	echo $html; die();
}
function default_ajUploadForm(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav;
	$user_id = $core->_USER['user_id'];
	#
	$table_id = isset($_POST['table_id'])?intval($_POST['table_id']):0;
	$type = isset($_POST['type'])? $_POST['type'] : '';
	$clsTable = isset($_POST['clsTable'])?$_POST['clsTable']:'';
	$file_images = isset($_POST['file_images'])?$_POST['file_images']:'';
	#
	if($file_images != '') {
		$file_images = rtrim($file_images,'|');
		$file_images = explode('|',$file_images);
		if($file_images != '' && !empty($clsTable)) {
			$clsClassTable = new $clsTable();
			for($i = 0; $i < count($file_images); $i++){
				$path_parts = pathinfo($file_images[$i]);
				$title = trim(strip_tags($path_parts['filename']));
				#
				$fx = "$clsClassTable->pkey,table_id,type,title,slug,image,order_no,user_id,reg_date";
				$vx = "'".$clsClassTable->getMaxID()."'
				,'".$table_id."'
				,'".$type."'
				,'".$title."'
				,'".$core->replaceSpace($title)."'
				,'".$file_images[$i]."'
				,'".$clsClassTable->getMinOrderNo($table_id,$type)."'
				,'".$user_id."'
				,'".time()."'";
				#
				//print_r($fx.'xxxx'.$vx); die();
				$clsClassTable->insertOne($fx,$vx);
			}
		}
	}
}
function default_ajOpenElfinder(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav;
	$user_id = $core->_USER['user_id'];
	#
	$html ='
	<style>
		#elfinder *,
		#elfinder *:before,
		#elfinder *:after{-webkit-box-sizing:content-box !important; -moz-box-sizing:content-box !important; box-sizing:content-box !important;}
		#elfinder{ position:relative;}
	</style>
	<link rel="stylesheet" type="text/css" href="'.PCMS_URL.'/editor/elfinder/css/elfinder.min.css">
	<link rel="stylesheet" type="text/css" href="'.PCMS_URL.'/editor/elfinder/css/theme.css">
	<script type="text/javascript" src="'.PCMS_URL.'/editor/elfinder/js/elfinder.min.js"></script>
	<div class="headPop"> 
		<a class="closeEv close_pop" data-dismiss="modal" aria-hidden="true">&nbsp;</a> 
		<h3>ISOCMS Manager</h3>
	</div>
	<div id="elfinder"></div>';
	echo $html; die();
}
function default_ajReloadSITEMAP(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav;
	#
	$PCMS_URL  = "https://".$_SERVER['HTTP_HOST'];
//	$data = file_get_contents($PCMS_URL.'/sitemap.php');
	sleep(2);
	echo '_SUCCESS'; die();
}
?>