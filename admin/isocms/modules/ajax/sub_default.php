<?php
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
function default_delete_blobe(){
	global $oSmarty,$smarty, $assign_list, $adminid, $core, $clsISO, $_LANG_ID;
	$user_id = $core->_USER['user_id'];
	$pkey = Input::post('pkey');
	$pval_id = (int) Input::post('pval_id', 0);
	$clsTable = Input::post('clsTable');
	
	$msg = '_error';
	if(!empty($clsTable) && $pval_id > 0){
		$clsClassTable = new $clsTable();
		if(method_exists($clsClassTable, 'doDelete')){
			if($clsClassTable->doDelete($pval_id)){
				$msg = '_success';
			}
		} else {
			if($clsClassTable->deleteOne($pval_id)){
				$msg = '_success';
			}
		}
	}
	// Return
	echo $msg; die();
}
function default_convertBase64toImage(){
	global $adminid,$smarty,$PCMS_URL,$clsISO,$core,$clsConfiguration;
	//$imgdata = Input::post('imgdata');
	$content = Input::post('intro');
	$content = html_entity_decode($content);
	/*data: = nodata...
	([\w=+/]++) = $imgdata
	[a-z]+ = (gif|png|jpeg)*/
	echo json_encode(array(
		"msg"	=> "ok",
		"content"	=> preg_replace_callback('#(<img\s(?>(?!src=)[^>])*?src=")nodata...image/([a-z]+);base64,([\w=+/]++)("[^>]*>)#', "data_upload_image_textarea", $content),
	));
}

function data_upload_image_textarea($match) {
	global $clsISO;
	
	$year = date("Y");
	if(!is_dir(_isoman_dir.'/content/'.$year)){
		$clsISO->rmkdir(_isoman_dir.'/content/'.$year,0777);
	}
	$month = date("m");
	if(!is_dir(_isoman_dir.'/content/'.$year.'/'.$month.'-'.$year)){
		$clsISO->rmkdir(_isoman_dir.'/content/'.$year.'/'.$month.'-'.$year,0777);
	}
	
    list(, $img, $type, $base64, $end) = $match;
    $bin = base64_decode($base64);
    $md5 = md5($bin);   // generate a new temporary filename
    //$fn = _isoman_dir.'/content/'.$year.'/'.$month.'-'.$year.'/'.$md5.$type;
	//$imageurl  = PCMS_URL.'/datastore/content/'.$year.'/'.$month.'-'.$year.'/'.$md5.$type;
	
	$fn = _isoman_dir.'/content/'.$year.'/'.$month.'-'.$year.'/'.$md5.'.'.$type;
	$imageurl  = PCMS_URL.'/datastore/content/'.$year.'/'.$month.'-'.$year.'/'.$md5.'.'.$type;
	
    file_exists($fn) or file_put_contents($fn, $bin);

    return "$img$imageurl$end";  // new <img> tag
}
?>