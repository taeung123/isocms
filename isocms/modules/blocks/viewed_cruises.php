<?php 

	global $smarty, $mod, $act, $_LANG_ID;

	#

		

	$clsCruise = new Cruise();$smarty->assign('clsCruise', $clsCruise);

	#

	$sessionName = md5('VIEWDEDCRUISE');

	$VIEWDED_CRUISE = vnsessionGetVar($sessionName);

	$VIEWDED_CRUISE = array_merge(explode('|',$VIEWDED_CRUISE));

	$assign_list['lstCruiseViewed'] = $VIEWDED_CRUISE; 

	$smarty->assign('lstCruiseViewed', $VIEWDED_CRUISE);

?>