<?php 
	global $smarty;
	#
	$CountFile = "index.log";
	$CF = fopen ($CountFile, "r");
	$Views = fread ($CF, filesize ($CountFile));
	fclose ($CF);
	$Views++; 
	
	$CF = fopen ($CountFile, "w");
	fwrite ($CF, $Views); 
	fclose ($CF); 
	$smarty->assign('Views',$Views);
?>