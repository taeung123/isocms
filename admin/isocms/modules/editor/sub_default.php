<?php
/**
*  Defautl action
*  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (info@vietiso.com)		
*  @date		: 2009/10/01
   @date-modify : 2009/01/06	
*  @version		: 3.0.0
*/
function default_link(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$city_id;
	#
	$clsMeta = new Meta();
	$listAllTag = $clsMeta->getAll("1=1 order by config_link asc limit 0,1000"); 
	$listAvailableLink = '<script type="text/javascript">var availableTags = [';
	for($i=0;$i<count($listAllTag);$i++){
		$listAvailableLink .= '{ name: "'.$listAllTag[$i]['config_link'].'", val: "'.$listAllTag[$i]['config_link'].'" },';
	}
	$listAvailableLink .= '];</script>';
	$assign_list["listAvailableLink"] = $listAvailableLink;
}

function default_image(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$assign_list["act_image"] = 'act_image';
	#
	if(isset($_POST['hidImage'])&&$_POST['hidImage']=='hidImage'){
		/*Upload Image*/
		$up = '';
		if(is_uploaded_file($_FILES['imageFile']['tmp_name'])){
			$clsUploadFile = new UploadFile();
			$up = $clsUploadFile->uploadItem($_FILES["imageFile"],"/content","jpg,gif,png");
		}
		$assign_list["imageFile"] = $up;
	}
}
function default_manager(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	if (!$core->_SESS->isLoggedin()){
		header("location: /");
		exit();
	}
	$assign_list["act_image"] = 'act_image';
}
?>