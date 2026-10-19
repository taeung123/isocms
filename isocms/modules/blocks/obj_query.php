<?php 
	global $smarty;
	#
	$ObjQuery = new ObjQuery();
	$assign_list['ObjQuery']=$ObjQuery;
	$abc=$ObjQuery->renderHTML();
	print_r($abc);
?>