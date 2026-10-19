<?php

/**
*  Default action
*  @author		: VietISO Support (support@vietiso.com)		
*  @date		: 2011/09/20	
*  @update		: 2026/07/09	
*  @version		: 3.5.1
*/
require_once(DIR_MODULES . '/lang/lang_helper.php');
function default_default()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $core, $clsModule, $clsButtonNav, $oneSetting;
    #
    $customClsArray = array();
    if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/admin/lang')) {
        if ($dh = opendir($_SERVER['DOCUMENT_ROOT'] . '/admin/lang')) {
            while (($file = readdir($dh)) !== false) {
                if (substr($file, -3) == 'php')
                    array_push($customClsArray, str_replace('.php', '', $file));
            }
            closedir($dh);
        }
    }
    $assign_list["listLang"] = $customClsArray;
}
function read_file_config($filename)
{
    //$file_path = PCMS_DIR . DS . "langs/" . $filename;
    $file_path = DIR_CONF . DS . $filename;

    if (is_file($file_path) && is_readable($file_path)) {
        return file_get_contents($file_path);
    }

    return ''; // hoặc return null;
}

function write_file_config($filename, $content)
{
    //$file_path = PCMS_DIR . DS . "langs/" . $filename;
    $file_path = DIR_CONF . DS . $filename;

    // Kiểm tra folder có ghi được không
    if (!is_writable(dirname($file_path))) {
        return false;
    }

    $bytes_written = file_put_contents($file_path, $content);

    return $bytes_written !== false;
}

function default_edit_old()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $oneSetting, $core, $clsModule, $_loged_id;
    #
    $string = isset($_GET['lang_id']) ? ($_GET['lang_id']) : '';
    $lang_id = $lang = $core->decryptID($string);
    $assign_list["langid"] = $lang;
    $dir = $_SERVER['DOCUMENT_ROOT'] . '/admin/lang/' . $lang . '.php';
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'Updatelang') {
            write_file_config($lang_id . ".conf", $_POST['content_config_file']);
            $key = $_POST['key'];
            $value = $_POST['value'];
            $lang_content = '<?php
if (!defined("PCMS_DIR")) die("File này không thể truy cập trực tiếp");
global $_ADMINLANG;
';
            for ($i = 0; $i < count($key); $i++) {
                if ($key[$i] != '') {
                    $val = str_replace('&#33;', '!', $value[$i]);
                    $val = str_replace('"', '&quot;', $value[$i]);
                    $lang_content .= '
$_ADMINLANG["' . str_replace('"', '&quot;', $key[$i]) . '"]="' . $val . '";';
                }
            }
            $lang_content .= "
?>";
            $core->writeFile($dir, $lang_content);
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&lang_id&lang_id=' . $string . '&message=UpdateSuccess');
        }
    } else {

        $conf_lang = read_file_config($lang_id . ".conf");
        //$clsISO->pre($conf_lang);die();
        $assign_list["conf_lang"] = $conf_lang;
        #

        $lang = file_get_contents($dir);
        $lang = str_replace('<?php
if (!defined("PCMS_DIR")) die("File này không thể truy cập trực tiếp");
global $_ADMINLANG;', '', $lang);
        $lang = str_replace(' = ', "=", $lang);
        $lang = str_replace('

', "
", $lang);
        $lang = str_replace('
?>', '', $lang);
        $lang = str_replace('
', '', $lang);
        $lang = str_replace(';$_ADMINLANG', '|||', $lang);
        $lang = str_replace('$_ADMINLANG', '', $lang);
        $listLangItem = explode('|||', $lang);
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
        $assign_list["lstItem"] = $lstItem;
        $lang_permission = substr(sprintf('%o', fileperms($dir)), -4);
        $assign_list["lang_permission"] = $lang_permission;
    }
}
function default_edit_2025()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $oneSetting, $core, $clsModule, $_loged_id, $clsISO;
    #
    $string = isset($_GET['lang_id']) ? ($_GET['lang_id']) : '';
    $lang_id = $lang = $core->decryptID($string);
    $assign_list["langid"] = $lang;
    #
    $dir = $_SERVER['DOCUMENT_ROOT'] . '/admin/lang/' . $lang . '.php';
    $lang_contents = file_get_contents($dir);
    $lang_contents = str_replace('<?php
if (!defined("PCMS_DIR")) die("File này không thể truy cập trực tiếp");
global $_ADMINLANG;', '', $lang_contents);
    $lang_contents = str_replace(' = ', "=", $lang_contents);
    $lang_contents = str_replace('

', "
", $lang_contents);
    $lang_contents = str_replace('
?>', '', $lang_contents);
    $lang_contents = str_replace('
', '', $lang_contents);
    $lang_contents = str_replace(';$_ADMINLANG', '|||', $lang_contents);
    $lang_contents = str_replace('$_ADMINLANG', '', $lang_contents);
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
    $assign_list["lstItem"] = $lstItem;
    $lang_permission = substr(sprintf('%o', fileperms($dir)), -4);
    $assign_list["lang_permission"] = $lang_permission;
	//$clsISO->pre(PCMS_DIR);die();
    $conf_lang = read_file_config($lang_id . ".conf");
    //$clsISO->pre($conf_lang);die();
    $assign_list["conf_lang"] = $conf_lang;

    if (isset($_POST['submit'])) {
        write_file_config($lang_id . ".conf", $_POST['content_config_file']);
        $key = $_POST['key'];
        $value = $_POST['value'];
        $change = $_POST['change'];
        # Khi thay đổi giá trị input (key || value) thì sẽ xóa dữ liệu cũ và thêm dữ liệu đã thay đổi
        // Xóa
        if (!empty($change)) {
            $lines_remove = file($dir, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($change as $_key) {
                $exact_match = '$_ADMINLANG["' . $_key . '"]';
                $lines_remove = array_filter($lines_remove, function ($line_rm) use ($exact_match) {
                    return strpos($line_rm, $exact_match) !== 0;
                });
            }
            file_put_contents($dir, implode("\n", $lines_remove));
        }
        // Thêm
        if (!empty($key)) {
            $lines = file($dir, FILE_IGNORE_NEW_LINES);
            for ($i = 0; $i < count($key); $i++) {
                if ($key[$i] != '') {
                    $escapedKey = trim(str_replace('"', '&quot;', trim($key[$i])));
                    $val = trim(str_replace('"', '&quot;', trim($value[$i])));
                    $line = '$_ADMINLANG["' . $escapedKey . '"]="' . $val . '";';
                    foreach ($lines as $existingLine) {
                        if (strpos($existingLine, '$_ADMINLANG["' . $escapedKey . '"]') !== false) {
                            header('Location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&lang_id=' . $string . '&message=keyExist');
                            exit;
                        }
                    }
                    array_splice($lines, 3, 0, $line);
                }
            }
            file_put_contents($dir, implode("\n", $lines));
        }
        header('Location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&lang_id=' . $string . '&message=UpdateSuccess');
        exit;
    }
}
function default_edit()
{
    global $assign_list, $core, $mod, $clsISO;
	
	/*echo 'post_max_size: ',ini_get('post_max_size').'<br>';//128M
	echo 'max_input_vars: ',ini_get('max_input_vars').'<br>';//1000
	echo 'max_input_nesting_level: ',ini_get('max_input_nesting_level').'<br>';//64
	echo 'memory_limit: ',ini_get('memory_limit').'<br>';//256M
	die();*/
	$csrfToken = CsrfHelper::generate();
		$assign_list['csrfToken'] = $csrfToken;
		$assign_list['group'] = 'admin';
		
    $string = isset($_GET['lang_id']) ? $_GET['lang_id'] : '';

    $langId = $core->decryptID($string);
	
//$clsISO->pre($langId);
//$clsISO->pre($_POST); die;
    if (empty($langId)) {
        header('Location: ' . PCMS_URL . '/?mod=' . $mod);
        exit;
    }

    $assign_list['langid'] = $langId;
	$assign_list['language'] = $langId;
    $file = DIR_LANG
        . '/'
        . $langId
        . '.php';

    if (!file_exists($file)) {

        header(
            'Location: '
            . PCMS_URL
            . '/?mod='
            . $mod
            . '&message=FileNotFound'
        );

        exit;

    }

    /**
     * Load language
     */

    $langArray = loadLanguageFile($file);

    $assign_list['lstItem'] = languageArrayToList($langArray);

    $assign_list['lang_permission'] =
        substr(sprintf('%o', fileperms($file)), -4);
	if(0){//không cần lưu file conf 11/07/2026
		$conf_lang = read_file_config($langId . ".conf");
		//$clsISO->pre($conf_lang);die();
		$assign_list["conf_lang"] = $conf_lang;
	}

    /**
     * Save
     */

	/*echo '<pre>';
echo 'old_key = '.count($_POST['old_key']).PHP_EOL;
echo 'key     = '.count($_POST['key']).PHP_EOL;
echo 'value   = '.count($_POST['value']).PHP_EOL;
die();*/
	
    if (!isset($_POST['submit'])) {
        return;
    }
	if(0){//không cần lưu file conf 11/07/2026
		write_file_config($langId . ".conf", $_POST['content_config_file']);
	}
   /* $result = buildLanguageArray(
        $langArray,
        $_POST
    );*/
	
	$langRows = json_decode($_POST['lang_json'], true);
	
	//$report = auditLanguageFile($langRows);
	//$clsISO->pre($report);die();
	
	if (!is_array($langRows)) {
		redirectLang(
			PCMS_URL
            . '/?mod='
            . $mod
            . '&act=edit'
            . '&lang_id='
            . $string,
			'Invalid language data.'
		);
	}
	//$clsISO->pre($langRows);die();
	$result = buildLanguageArray(
		$langArray,
		$langRows
	);
	
	
	//$clsISO->pre($result);die();
    if (!$result['success']) {
		redirectLang(
			PCMS_URL
            . '/?mod='
            . $mod
            . '&act=edit'
            . '&lang_id='
            . $string,
			urlencode($result['message'])
		);
        

    }

    if (!saveLanguageFile(
        $file,
        $result['data']
    )) {
		redirectLang(
			PCMS_URL
            . '/?mod='
            . $mod
            . '&act=edit'
            . '&lang_id='
            . $string,
			'SaveFailed'
		);

    }
	redirectLang(
		PCMS_URL
		. '/?mod='
		. $mod
		. '&act=edit'
		. '&lang_id='
		. $string,
		'UpdateSuccess'
	);
}
function default_ajax(){
	global $_frontIsLoggedin_user_id, $core, $clsISO, $dbconn;
	define("DIR_LANG_FRONT", PCMS_DIR . DS . "lang");
	define("DIR_LANG_ADMIN", PCMS_DIR . DS . "admin/lang");
	LanguageService::init([
		LanguageService::GROUP_FRONT => DIR_LANG_FRONT,
		LanguageService::GROUP_ADMIN => DIR_LANG_ADMIN
	]);
	$controller = new LanguageController();

	$controller->dispatch();
}
function default_delete()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act, $core, $clsModule;
    $user_id = $core->_USER['user_id'];

    $classTable = "AdminButton";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));

    if ($pvalTable == 0 || $string == '')
        header('location: ' . PCMS_URL . '/?admin&mod=' . $mod);

    if ($clsClassTable->deleteOne($pvalTable)) {
        header('location: ' . PCMS_URL . '/?admin&mod=' . $mod . '&message=DeleteSuccess');
    }
}
