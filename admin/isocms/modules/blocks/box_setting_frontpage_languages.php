<?php
global $smarty, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $oneSetting, $core, $clsModule, $_loged_id, $clsISO;
#
$string = isset($_GET['lang_id']) ? ($_GET['lang_id']) : '';
$lang_id = $lang = $_LANG_ID;
$smarty->assign('langid', $lang_id);

#

$dir = $_SERVER['DOCUMENT_ROOT'] . '/lang/' . $lang . '.php';
$lang_contents = file_get_contents($dir);

$lang_contents = str_replace('<?php', '', $lang_contents);
$lang_contents = str_replace('if (!defined("PCMS_DIR")) die("File này không thể truy cập trực tiếp");', '', $lang_contents);
$lang_contents = str_replace('global $_FRONTLANG;', '', $lang_contents);

$lang_contents = str_replace(' = ', "=", $lang_contents);
$lang_contents = str_replace('?>', '', $lang_contents);
$lang_contents = str_replace(';', '', $lang_contents);
$lang_contents = str_replace('$_FRONTLANG', '|||', $lang_contents);

$lang_contents = ltrim($lang_contents, '


|||');

$listLangItem = explode('|||', $lang_contents);

$lstItem = array();
for ($i = 0; $i < count($listLangItem); $i++) {
    $tmp = $listLangItem[$i] . '|||';
    $tmp = str_replace('["', '', $tmp);
    $tmp = str_replace('"|||', '', $tmp);
    $tmp = str_replace('"]="', '|||', $tmp);
    $item = explode('|||', $tmp);
    $val = array();
    $val['key'] = $item[0];
    $val['value'] = $item[1];
    $lstItem[] = $val;
}

$smarty->assign('lstItem', $lstItem);
$lang_permission = substr(sprintf('%o', fileperms($dir)), -4);
$smarty->assign('lang_permission', $lang_permission);

$conf_lang = $clsISO->read_file_config($lang_id . ".conf");
//$clsISO->pre($conf_lang);die();
$smarty->assign('conf_lang', $conf_lang);
