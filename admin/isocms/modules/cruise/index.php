<?php
$sub = $stdio->GET("sub", "default");
$act = $stdio->GET("act", "default");
$clsModule = new Module("cruise");
$clsModule->run($sub, $act);
#
$assign_list["sub"] = $sub;
$assign_list["act"] = $act;

$clsISO = new ISO();
if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,'default','default')){
	header('Location:/admin/index.php?lang='.LANG_DEFAULT);
	exit();
}
?>