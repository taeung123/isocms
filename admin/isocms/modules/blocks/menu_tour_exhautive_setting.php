<?php
global $smarty, $core, $mod, $act, $_LANG_ID, $clsISO;
$clsAdminButton = new AdminButton();
ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL & ~E_STRICT);
$lstMenuSettingTours = $clsAdminButton->menuSettingTours();
$smarty->assign('lstMenuSettingTours', $lstMenuSettingTours);
