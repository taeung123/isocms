<?php
global $smarty, $core, $mod, $act, $_LANG_ID, $clsISO;

$clsUser = new User();
$smarty->assign('clsUser', $clsUser);
$clsCountry = new _Country();
$smarty->assign('clsCountry', $clsCountry);
?>