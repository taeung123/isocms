<?php
if (!defined('PCMS_DIR')) {
    die('File này không thể truy cập trực tiếp');
}

/**
 * Đọc file ngôn ngữ
 *
 * @param string $file
 * @return array
 * @throws Exception
 */
function loadLanguageFile($file)
{
    if (!is_file($file)) {
        throw new Exception('Language file not found: ' . $file);
    }

    $_FRONTLANG = array();

    include $file;

    if (!isset($_FRONTLANG) || !is_array($_FRONTLANG)) {
        $_FRONTLANG = array();
    }

    return $_FRONTLANG;
}

/**
 * Convert language array -> smarty list
 *
 * @param array $langArray
 * @return array
 */
function languageArrayToList(array $langArray)
{
    $list = array();

    foreach ($langArray as $key => $value) {

        $list[] = array(
            'key'   => $key,
            'value' => $value
        );

    }

    return $list;
}

/**
 * Validate language key
 *
 * @param string $key
 * @return bool
 */
function validateLanguageKey_old($key)
{
    if ($key === '') {
        return false;
    }

    return preg_match('/^[a-zA-Z0-9._-]+$/', $key) === 1;
}
/**
 * Kiểm tra key ngôn ngữ hợp lệ
 *
 * @param string $key
 * @return array
 */
function validateLanguageKey($key)
{
    $key = trim($key);

    if ($key === '') {
        return buildResult(
            false,
            array(),
            'Key không được để trống.'
        );
    }

    // Không cho phép xuống dòng
    if (preg_match('/[\r\n]/', $key)) {
        return buildResult(
            false,
            array(),
            'Key không được chứa ký tự xuống dòng.'
        );
    }

    // Không cho phép ký tự NULL
    if (strpos($key, "\0") !== false) {
        return buildResult(
            false,
            array(),
            'Key chứa ký tự không hợp lệ.'
        );
    }

    return buildResult(true);
}

/**
 * Normalize POST
 *
 * @param array $post
 * @return array
 */
function normalizeLanguagePost(array $post)
{
    $oldKeys = isset($post['old_key']) && is_array($post['old_key'])
        ? $post['old_key']
        : array();

    $keys = isset($post['key']) && is_array($post['key'])
        ? $post['key']
        : array();

    $values = isset($post['value']) && is_array($post['value'])
        ? $post['value']
        : array();

    $max = max(
        count($oldKeys),
        count($keys),
        count($values)
    );

    for ($i = 0; $i < $max; $i++) {

        if (!isset($oldKeys[$i])) {
            $oldKeys[$i] = '';
        }

        if (!isset($keys[$i])) {
            $keys[$i] = '';
        }

        if (!isset($values[$i])) {
            $values[$i] = '';
        }

        $oldKeys[$i] = trim($oldKeys[$i]);
        $keys[$i] = trim($keys[$i]);

        $values[$i] = str_replace(
            array("\r\n", "\r"),
            "\n",
            $values[$i]
        );
    }

    return array(
        'old_key' => $oldKeys,
        'key'     => $keys,
        'value'   => $values
    );
}
/**
 * Build language array từ dữ liệu POST
 *
 * @param array $oldLanguage
 * @param array $post
 * @return array
 * @throws Exception
 
 không dùng post mảng, dùng post json
 */
function buildLanguageArray_old(array $oldLanguage, array $post)
{
    $post = normalizeLanguagePost($post);

    $newLanguage = $oldLanguage;
    $usedKeys = array();

    $count = count($post['key']);

    for ($i = 0; $i < $count; $i++) {

        $oldKey = $post['old_key'][$i];
        $key    = trim($post['key'][$i]);
        $value  = $post['value'][$i];

        /**
         * Bỏ qua dòng trống
         */
        if ($oldKey == '' && $key == '') {
            continue;
        }

        /**
         * Xóa key
         */
        if ($oldKey != '' && $key == '') {

            if (isset($newLanguage[$oldKey])) {
                unset($newLanguage[$oldKey]);
            }

            continue;
        }

        /**
         * Validate key
         */
        if (!validateLanguageKey($key)) {
            /*throw new Exception(
                'Invalid language key "' . $key . '" at row ' . ($i + 1)
            );*/
			return array(
				'success' => false,
				'data'    => array(),
				'message' => 'Invalid language key "' . $key . '" at row ' . ($i + 1)
			);
        }

        /**
         * Duplicate trong POST
         */
        if (isset($usedKeys[$key])) {
            /*throw new Exception(
                'Duplicate language key "' . $key . '" at row ' . ($i + 1)
            );*/
			return array(
				'success' => false,
				'data'    => array(),
				'message' => 'Duplicate language key "' . $key . '" at row ' . ($i + 1)
			);
        }

        $usedKeys[$key] = true;

        /**
         * Thêm mới
         */
        if ($oldKey == '') {

            if (isset($newLanguage[$key])) {
                /*throw new Exception(
                    'Language key "' . $key . '" already exists.'
                );*/
				return array(
					'success' => false,
					'data'    => array(),
					'message' => 'Language key "' . $key . '" already exists.'
				);
            }

            $newLanguage[$key] = $value;

            continue;
        }

        /**
         * Không đổi key
         */
        if ($oldKey == $key) {

            $newLanguage[$key] = $value;

            continue;
        }

        /**
         * Rename
         */
        if (isset($newLanguage[$key])) {
            /*throw new Exception(
                'Cannot rename "' . $oldKey .
                '" to "' . $key .
                '" because the destination key already exists.'
            );*/
			return array(
				'success' => false,
				'data'    => array(),
				'message' => 'Cannot rename "' . $oldKey .
								'" to "' . $key .
								'" because the destination key already exists.'
			);
        }

        if (isset($newLanguage[$oldKey])) {

            unset($newLanguage[$oldKey]);

        }

        $newLanguage[$key] = $value;

    }

    //return $newLanguage;
	array(
		'success' => true,
		'data'    => $newLanguage,
		'message' => ''
	);
}
/**
 * Xây dựng lại mảng ngôn ngữ từ dữ liệu gửi lên
 *
 * @param array $oldLangArray Mảng ngôn ngữ hiện tại
 * @param array $rows Dữ liệu JSON từ form
 *
 * @return array
 * [
 *      'success' => bool,
 *      'data'    => array,
 *      'message' => string
 * ]
 */
function buildLanguageArray(array $oldLangArray, array $rows)
{
	global $clsISO;
    $newLangArray = $oldLangArray;
	//$clsISO->pre($newLangArray);die();
    foreach ($rows as $index => $row) {

        $oldKey = isset($row['old_key'])
            ? trim($row['old_key'])
            : '';

        $key = isset($row['key'])
            ? trim($row['key'])
            : '';

        $value = isset($row['value'])
            ? $row['value']
            : '';

        //--------------------------------------------------
        // 1. Bỏ qua dòng hoàn toàn rỗng
        //--------------------------------------------------

        if ($oldKey === '' && $key === '') {
            continue;
        }
		/**
         * Xóa key
         */
        if ($oldKey != '' && $key == '') {

            if (isset($newLangArray[$oldKey])) {
                unset($newLangArray[$oldKey]);
            }

            continue;
        }
        //--------------------------------------------------
        // 2. Key rỗng
        //--------------------------------------------------

        if ($key === '') {

            /*return array(
                'success' => false,
                'data' => array(),
                'message' => 'Dòng '.($index + 1).' chưa nhập Key.'
            );*/
			return buildResult(
				false,
				array(),
				'Dòng '.($index + 1).' chưa nhập Key.'
			);

        }

        //--------------------------------------------------
        // 3. Validate key
        //--------------------------------------------------

        if (!validateLanguageKey($key)) {

            /*return array(
                'success' => false,
                'data' => array(),
                'message' => 'Key "'.$key.'" không hợp lệ.'
            );*/
			return buildResult(
				false,
				array(),
				'Key "'.$key.'" không hợp lệ.'
			);

        }

        //--------------------------------------------------
        // 4. Rename key
        //--------------------------------------------------

        if ($oldKey != '' && $oldKey != $key) {

            if (isset($newLangArray[$key])) {

                /*return array(
                    'success' => false,
                    'data' => array(),
                    'message' => 'Key "'.$key.'" đã tồn tại.'
                );*/
				return buildResult(
					false,
					array(),
					'Key "'.$key.'" đã tồn tại.'
				);

            }

            unset($newLangArray[$oldKey]);

        }

        //--------------------------------------------------
        // 5. Duplicate key
        //--------------------------------------------------

        if (
            $oldKey == '' &&
            isset($newLangArray[$key])
        ) {

            /*return array(
                'success' => false,
                'data' => array(),
                'message' => 'Key "'.$key.'" đã tồn tại.'
            );*/
			return buildResult(
				false,
				array(),
				'Key "'.$key.'" đã tồn tại.'
			);

        }

        //--------------------------------------------------
        // 6. Save value
        //--------------------------------------------------

        $newLangArray[$key] = $value;

    }

    //--------------------------------------------------
    // 7. Sort theo key
    //--------------------------------------------------

    ksort($newLangArray);

    /*return array(
        'success' => true,
        'data' => $newLangArray,
        'message' => ''
    );*/
	//$clsISO->pre($newLangArray);die();
	return buildResult(
		true,
		$newLangArray,
		''
	);
}
function buildResult($success, $data = array(), $message = '')
{
    return array(
        'success' => $success,
        'data' => $data,
        'message' => $message
    );
}
/**
 * Escape chuỗi để ghi vào file PHP
 *
 * @param string $text
 * @return string
 */
function escapePhpString($text)
{
    return str_replace(
        array(
            "\\",
            "\"",
            "\r\n",
            "\r"
        ),
        array(
            "\\\\",
            "\\\"",
            "\n",
            "\n"
        ),
        $text
    );
}
/**
 * Export mảng ngôn ngữ thành source PHP
 *
 * @param array $langArray
 * @return string
 */
function exportLanguagePhp(array $langArray)
{
    $lines = array();

    $lines[] = '<?php';
    $lines[] = 'if (!defined("PCMS_DIR")) die("File này không thể truy cập trực tiếp");';
    $lines[] = 'global $_FRONTLANG;';
    $lines[] = '';

    foreach ($langArray as $key => $value) {

        $lines[] =
            '$_FRONTLANG["'
            . escapePhpString($key)
            . '"]="'
            . escapePhpString($value)
            . '";';

    }

    $lines[] = '';

    return implode(PHP_EOL, $lines);
}
/**
 * Lưu file ngôn ngữ
 *
 * @param string $file
 * @param array $langArray
 * @return bool
 * @throws Exception
 */
function saveLanguageFile($file, array $langArray)
{
    if (!is_array($langArray)) {
        throw new Exception('Invalid language array.');
    }

    if (!is_file($file)) {
        throw new Exception('Language file not found.');
    }

    backupLanguageFile($file);

    $content = exportLanguagePhp($langArray);

    $tmpFile = $file . '.tmp';

    if (file_put_contents($tmpFile, $content, LOCK_EX) === false) {

        @unlink($tmpFile);

        throw new Exception(
            'Cannot write temporary language file.'
        );
    }

    /**
     * Giữ nguyên permission của file cũ
     */
    @chmod($tmpFile, fileperms($file) & 0777);

    /*if (!@rename($tmpFile, $file)) {

        @unlink($tmpFile);

        throw new Exception(
            'Cannot replace language file.'
        );
    }*/
	if (!@rename($tmpFile, $file)) {

		if (@copy($tmpFile, $file)) {
			@unlink($tmpFile);
		} else {
			@unlink($tmpFile);
			throw new Exception('Cannot replace language file.');
		}
	}

    return true;
}
/**
 * Backup language file
 *
 * @param string $file
 * @param int $maxBackup
 * @return bool
 */
function backupLanguageFile($file, $maxBackup = 20)
{
    if (!is_file($file)) {
        return false;
    }

    $langName = pathinfo($file, PATHINFO_FILENAME);

    $backupDir =
        dirname($file)
        . DIRECTORY_SEPARATOR
        . '.backup'
        . DIRECTORY_SEPARATOR
        . $langName;

    if (!is_dir($backupDir)) {

        if (!mkdir($backupDir, 0777, true)) {
            return false;
        }

    }

    /*$backupFile =
        $backupDir
        . DIRECTORY_SEPARATOR
        . date('Ymd_His')
        . '.php';*/
	/*$backupFile =
		$backupDir
		. DIRECTORY_SEPARATOR
		. date('Ymd_His_u')
		. '.php';*/
	/*$micro = sprintf('%06d', (int)(microtime(true) * 1000000) % 1000000);

	$backupFile =
		$backupDir
		. DIRECTORY_SEPARATOR
		. date('Ymd_His')
		. '_'
		. $micro
		. '.php';*/
	$backupFile =
        $backupDir
        . DIRECTORY_SEPARATOR
        . date('Ymd')
        . '.php';
	// Đã backup tháng này rồi
    if (file_exists($backupFile)) {
        return true;
    }

    if (!copy($file, $backupFile)) {
        return false;
    }

    $files = glob(
        $backupDir
        . DIRECTORY_SEPARATOR
        . '*.php'
    );

    if (!is_array($files)) {
        return true;
    }

    sort($files);

    while (count($files) > $maxBackup) {

        $old = array_shift($files);

        @unlink($old);

    }

    return true;
}
function redirectLang($location,$message)
{
	header(
        'Location: '        
        . $location
        . '&message='.$message
    );
    exit;
}
