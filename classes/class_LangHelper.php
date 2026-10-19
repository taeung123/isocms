<?php
/**
 * Language Helper Version 3
 *
 * @author VietISO
 * @version 3.0
 */
class LangHelper
{
    /**
     * Đọc file ngôn ngữ.
     *
     * File phải có dạng:
     *
     * <?php
     * $_LANG['Home'] = 'Trang chủ';
     *
     * @param string $file
     * @return array
     */
    public static function loadLanguageFile($file, $variableName = '$_LANG')
	{
		if (!is_file($file)) {
			return [];
		}
		// bỏ dấu $
		$varName = ltrim($variableName, '$');
		// tạo biến rỗng
		$$varName = [];
		try {
			include $file;
		} catch (Throwable $e) {
			return [];
		}
		if (!isset($$varName) || !is_array($$varName)) {
			return [];
		}
		return $$varName;
	}
    /**
     * Ghi file ngôn ngữ.
     *
     * @param string $file
     * @param array  $lang
     * @return bool
	 * $variableName: $_FRONTLANG, $_ADMINLANG
     */
    public static function saveLanguageFile_V1($file, array $lang, $variableName = '$_LANG')
    {
        self::normalizeLanguageArray($lang);
        self::backupLanguageFile($file);
        $content = self::buildPhpContent($lang,$variableName);
        $tmpFile = $file . '.tmp';
        $fp = fopen($tmpFile, 'wb');
        if (!$fp) {
            return false;
        }
        try {
            if (!flock($fp, LOCK_EX)) {
                fclose($fp);
                return false;
            }
            fwrite($fp, $content);
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);
            rename($tmpFile, $file);
            @chmod($file, 0777);
            return true;
        } catch (Throwable $e) {
            fclose($fp);
            @unlink($tmpFile);
            return false;
        }
    }
	/**
	 * Ghi file ngôn ngữ.
	 *
	 * @param string $file
	 * @param array  $lang
	 * @param string $variableName
	 * @param array  $meta
	 *
	 * @return bool
	 */
	public static function saveLanguageFile(
		$file,
		array $lang,
		$variableName = '$_LANG',
		array $meta = []
	) {
		self::normalizeLanguageArray($lang);
		self::backupLanguageFile($file);
		$content = self::buildPhpContent(
			$lang,
			$variableName,
			$meta
		);
		
		/*echo '<pre>';
		echo "Total keys: " . count($lang) . PHP_EOL;
		echo "Has huy test ss: ";
		var_dump(isset($lang['huy test ss']));
		echo "Value: ";
		var_dump($lang['huy test ss'] ?? null);
		die();*/
		
		
		return file_put_contents(
			$file,
			$content,
			LOCK_EX
		) !== false;
	}
    /**
     * Sinh nội dung file PHP.
     *
     * @param array $lang
     * @return string
     */
    public static function buildPhpContent_V1(array $lang, $variableName = '$_LANG')
    {
        $content = "<?php\n";
		$content .= "if (!defined('PCMS_DIR')) die('File này không thể truy cập trực tiếp');\n\n";
        $content .= "/**\n";
        $content .= " * Language File\n";
        $content .= " * Generated: " . date('Y-m-d H:i:s') . "\n";
        $content .= " */\n\n";
        foreach ($lang as $key => $value) {
            $key = self::exportString($key);
            $value = self::exportString($value);
            $content .= "{$variableName}['{$key}'] = '{$value}';\n";
        }
        return $content;
    }
	/**
	 * Build nội dung file ngôn ngữ.
	 *
	 * @param array  $lang
	 * @param string $variableName
	 * @param array  $meta
	 *
	 * @return string
	 */
	public static function buildPhpContent(
		array $lang,
		$variableName = '$_LANG',
		array $meta = []
	) {
		self::normalizeLanguageArray($lang);
		$group = isset($meta['group']) ? ucfirst($meta['group']) : 'Unknown';
		$language = isset($meta['language']) ? strtoupper($meta['language']) : 'Unknown';
		$generator = isset($meta['generator'])
			? $meta['generator']
			: 'Language Manager Version 3.5';
		$content = "<?php\n";
		$content .= "defined('PCMS_DIR') || die('No direct script access.');\n\n";
		$content .= "/**\n";
		$content .= " * -----------------------------------------------------------------------------\n";
		$content .= " * Language File\n";
		$content .= " * -----------------------------------------------------------------------------\n";
		$content .= " *\n";
		$content .= " * Group      : {$group}\n";
		$content .= " * Language   : {$language}\n";
		$content .= " * Generated  : " . date('Y-m-d H:i:s') . "\n";
		$content .= " * Total Keys : " . number_format(count($lang)) . "\n";
		$content .= " * Generator  : {$generator}\n";
		$content .= " *\n";
		$content .= " * -----------------------------------------------------------------------------\n";
		$content .= " */\n\n";
		foreach ($lang as $key => $value) {
			$key = self::exportString($key);
			$value = self::exportString($value);
			$content .= "{$variableName}['{$key}'] = '{$value}';\n";
		}
		$content .= "\n";
		$content .= "/**\n";
		$content .= " * -----------------------------------------------------------------------------\n";
		$content .= " * End of language file\n";
		$content .= " * Total Keys : " . number_format(count($lang)) . "\n";
		$content .= " * -----------------------------------------------------------------------------\n";
		$content .= " */\n";
		return $content;
	}
    /**
     * Backup file.
     *
     * Mỗi tháng chỉ backup 1 lần.
     *
     * backup/
     *      2026-07/
     *              vn.php
     *
     * @param string $file
     * @return bool
     */
    public static function backupLanguageFile($file)
    {
        if (!is_file($file)) {
            return false;
        }
        $backupDir = dirname($file)
            . '/backup/'
            . date('Y-m');
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0777, true);
        }
        $backupFile = $backupDir . '/' . basename($file);
        if (is_file($backupFile)) {
            return true;
        }
        return copy($file, $backupFile);
    }
    /**
     * Escape chuỗi để ghi vào file PHP.
     *
     * @param string $str
     * @return string
     */
    protected static function exportString($str)
    {
        return str_replace(
            [
                "\\",
                "'",
                "\r\n",
                "\r",
                "\n"
            ],
            [
                "\\\\",
                "\\'",
                "\\n",
                "\\n",
                "\\n"
            ],
            $str
        );
    }
	/**
	 * Kiểm tra key tồn tại.
	 *
	 * @param array $lang
	 * @param string $key
	 *
	 * @return bool
	 */
	public static function hasKey(array $lang, $key)
	{
		return array_key_exists($key, $lang);
	}
	/**
	 * Lấy value theo key.
	 *
	 * @param array $lang
	 * @param string $key
	 *
	 * @return string|null
	 */
	public static function getValue(array $lang, $key)
	{
		if (!array_key_exists($key, $lang)) {
			return null;
		}
		return $lang[$key];
	}
	/**
	 * Thêm key mới.
	 *
	 * @param array  &$lang
	 * @param string $key
	 * @param string $value
	 *
	 * @return array
	 */
	public static function addLanguageItem(array &$lang, $key, $value)
	{
		$key = (string)$key;
		if ($key === '') {
			return [
				'success'=>false,
				'code'=>'EMPTY_KEY'
			];
		}
		if (self::hasKey($lang,$key)) {
			return [
				'success'=>false,
				'code'=>'DUPLICATE_KEY'
			];
		}
		$lang[$key] = (string)$value;
		return [
			'success'=>true,
			'code'=>'ADDED'
		];
	}
	/**
	 * Xóa key.
	 *
	 * @param array &$lang
	 * @param string $key
	 *
	 * @return array
	 */
	public static function deleteLanguageItem(array &$lang,$key)
	{
		if (!self::hasKey($lang,$key)) {
			return [
				'success'=>false,
				'code'=>'NOT_FOUND'
			];
		}
		unset($lang[$key]);
		return [
			'success'=>true,
			'code'=>'DELETED'
		];
	}
	/**
	 * Update key.
	 *
	 * @param array &$lang
	 * @param string $oldKey
	 * @param string $newKey
	 * @param string $value
	 *
	 * @return array
	 */
	public static function updateLanguageItem(
		array &$lang,
		$oldKey,
		$newKey,
		$value
	)
	{
		if (!self::hasKey($lang,$oldKey)) {
			return [
				'success'=>false,
				'code'=>'OLD_KEY_NOT_FOUND'
			];
		}
		if ($oldKey === $newKey) {
			$lang[$oldKey] = $value;
			return [
				'success'=>true,
				'code'=>'UPDATED'
			];
		}
		if (self::hasKey($lang,$newKey)) {
			return [
				'success'=>false,
				'code'=>'DUPLICATE_KEY'
			];
		}
		$items=[];
		foreach($lang as $key=>$val){
			if($key==$oldKey){
				$items[$newKey]=$value;
			}else{
				$items[$key]=$val;
			}
		}
		$lang=$items;
		return [
			'success'=>true,
			'code'=>'RENAMED'
		];
	}
	/**
	 * Áp dụng danh sách thay đổi.
	 *
	 * @param array &$lang
	 * @param array $changes
	 *
	 * @return array
	 */
	public static function applyChanges(array &$lang,array $changes)
	{
		$result=[];
		foreach($changes as $row){
			$oldKey=trim($row['old_key'] ?? '');
			$newKey=trim($row['key'] ?? '');
			$value=$row['value'] ?? '';
			/*
			 * Delete
			 */
			if(
				$oldKey!=''
				&&
				$newKey==''
			){
				$result[]=self::deleteLanguageItem(
					$lang,
					$oldKey
				);
				continue;
			}
			/*
			 * Add
			 */
			if(
				$oldKey==''
				&&
				$newKey!=''
			){
				$result[]=self::addLanguageItem(
					$lang,
					$newKey,
					$value
				);
				continue;
			}
			/*
			 * Update
			 */
			if(
				$oldKey!=''
				&&
				$newKey!=''
			){
				$result[]=self::updateLanguageItem(
					$lang,
					$oldKey,
					$newKey,
					$value
				);
			}
		}
		return $result;
	}
	/**
	 * Chuẩn hóa mảng ngôn ngữ.
	 *
	 * Không thay đổi thứ tự key.
	 *
	 * @param array &$lang
	 * @return void
	 */
	public static function normalizeLanguageArray(array &$lang)
	{
		$result = [];
		foreach ($lang as $key => $value) {
			$key = (string)$key;
			$value = (string)$value;
			/*
			 * Không lưu key rỗng
			 */
			if ($key === '') {
				continue;
			}
			/*
			 * Chuẩn hóa newline
			 */
			$value = str_replace(
				["\r\n", "\r"],
				"\n",
				$value
			);
			/*
			 * Duplicate:
			 * giữ lại key đầu tiên
			 */
			if (isset($result[$key])) {
				continue;
			}
			$result[$key] = $value;
		}
		$lang = $result;
	}
	/**
	 * Audit file ngôn ngữ.
	 *
	 * @param array $lang
	 * @return array
	 */
	public static function auditLanguageFile(array $lang)
	{
		$report = [
			'total' => 0,
			'empty_key' => [],
			'empty_value' => [],
			'duplicate_key' => [],
			'longest_key' => null,
			'longest_value' => null,
			'statistics' => []
		];
		$seen = [];
		$maxKey = 0;
		$maxValue = 0;
		foreach ($lang as $key => $value) {
			$report['total']++;
			/*
			 * Empty key
			 */
			if ($key === '') {
				$report['empty_key'][] = $key;
			}
			/*
			 * Empty value
			 */
			if ($value === '') {
				$report['empty_value'][] = $key;
			}
			/*
			 * Duplicate
			 */
			if (isset($seen[$key])) {
				$report['duplicate_key'][] = $key;
			}
			$seen[$key] = true;
			/*
			 * Longest key
			 */
			$len = mb_strlen($key);
			if ($len > $maxKey) {
				$maxKey = $len;
				$report['longest_key'] = [
					'key' => $key,
					'length' => $len
				];
			}
			/*
			 * Longest value
			 */
			$len = mb_strlen($value);
			if ($len > $maxValue) {
				$maxValue = $len;
				$report['longest_value'] = [
					'key' => $key,
					'length' => $len
				];
			}
		}
		$report['statistics'] = [
			'translated' =>
				$report['total']
				- count($report['empty_value']),
			'empty' =>
				count($report['empty_value']),
			'duplicate' =>
				count($report['duplicate_key'])
		];
		return $report;
	}
	protected static function response($success, $data = null, $message = '', $code = '')
	{
		http_response_code($success ? 200 : 400);
		echo json_encode([
			'success' => $success,
			'code'    => $code,
			'message' => $message,
			'data'    => $data
		], JSON_UNESCAPED_UNICODE);
		exit;
	}
}