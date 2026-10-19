<?php
	$sub = $stdio->GET("sub", "default");
	$act = $stdio->GET("act", "default");
	$tmp = explode('/',__FILE__);
	$clsModule = new Module($tmp[count($tmp)-2]);
	$clsModule->run($sub, $act);
	$assign_list["sub"] = $sub; 
	$assign_list["act"] = $act;
	#- Check enable module
	$clsISO = new ISO();
	if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,'default','default')){
		header('Location:/');
		exit();
	}
	
	#- End check enable module
?>