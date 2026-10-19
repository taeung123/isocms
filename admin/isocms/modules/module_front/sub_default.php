<?php
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $user_id, $core, $clsModule, $clsISO;	
	global $clsConfiguration;
	/**/
	$allItem = array();
	$dir = DIR_FRONT_MODULES;
	
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && is_dir($dir."/$file") && file_exists($dir."/".$file."/index.php")) {
				if ($file[0]!="_" && $core->checkDefaultModule($file)==0){
					$tmp['name'] = $file;
					if(file_exists($dir."/".$file."/mod.ini.php")){
						include_once($dir."/".$file."/mod.ini.php");
						#Display_Name
						if(isset($_MOD_INI['Info']['Display_Name'])){
							$tmp['Display_Name'] = $_MOD_INI['Info']['Display_Name'];
						}
						else{
							$tmp['Display_Name'] = $file;
						}
						#author
						if(isset($_MOD_INI['Info']['Description'])){
							$tmp['intro'] = $_MOD_INI['Info']['Description'];
						}
						else{
							$tmp['intro'] = '';
						}
						#author
						if(isset($_MOD_INI['Info']['Author'])){
							$tmp['author'] = $_MOD_INI['Info']['Author'];
						}
						else{
							$tmp['author'] = '';
						}
						#version
						if(isset($_MOD_INI['Info']['Version'])){
							$tmp['version'] = $_MOD_INI['Info']['Version'];
						}
						else{
							$tmp['version'] = '0.1';
						}
						#author_link
						if(isset($_MOD_INI['Info']['Author_Link'])){
							$tmp['author_link'] = $_MOD_INI['Info']['Author_Link'];
						}
						else{
							$tmp['author_link'] = '';
						}
					}
					else{
						$tmp['Display_Name'] = $file;
						$tmp['intro'] = '';
						$tmp['author'] = '';
						$tmp['author_link'] = '';
						$tmp['version'] = '';
					}
					array_push($allItem, $tmp);							
				}
			}
		}
		closedir($handle);
	}		
	$assign_list["allItem"] = $allItem;
	#
	if(isset($_POST['submit']) && $_POST['submit']=='Update'){
		$setting = 'SiteIntroModule_'.$_POST['modulename'].'_'.$_LANG_ID;
		$clsConfiguration->updateValue($setting,addslashes($_POST[$setting]));
		#
		header('Location:'.PCMS_URL.'/index.php?mod='.$mod.'&message=UpdateSuccess');
	}
}
?>