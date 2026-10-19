<?php
class LanguageService
{
	 /**
     * Frontend language group
     */
    const GROUP_FRONT = 'front';
    /**
     * Backend language group
     */
    const GROUP_ADMIN = 'admin';
	    /**
     * Danh sách thư mục ngôn ngữ
     *
     * @var array
     */
    protected static $directories = [];
	/**
	 * Khởi tạo đường dẫn ngôn ngữ.
	 *
	 * @param array $directories
	 */
	public static function init(array $directories)
	{
		self::$directories = $directories;
	}
	/**
	 * Load language file.
	 *
	 * @param string $group
	 * @param string $language
	 *
	 * @return array
	 */
	public static function load($group, $language)
	{
		if (!self::validateGroup($group)) {
			return self::result(false, 'INVALID_GROUP');
		}
		if (!self::validateLanguage($language)) {
			return self::result(false, 'INVALID_LANGUAGE');
		}
		$file = self::getLanguageFile($group, $language);
		if (!is_file($file)) {
			return self::result(false, 'FILE_NOT_FOUND');
		}
		$lang = LangHelper::loadLanguageFile($file,self::getLanguageVariable($group));
		return self::result(true, '', '', $lang);
	}
	/**
	 * Lưu file ngôn ngữ.
	 *
	 * @param string $group
	 * @param string $language
	 * @param array  $changes
	 *
	 * @return array
	 */
	public static function save($group, $language, array $changes)
	{
		$response = self::load($group, $language);
		if (!$response['success']) {
			return $response;
		}
		$lang = $response['data'];
		$result = LangHelper::applyChanges(
			$lang,
			$changes
		);
		LangHelper::normalizeLanguageArray($lang);
		$saved = LangHelper::saveLanguageFile(
			self::getLanguageFile($group, $language),
			$lang,
			self::getLanguageVariable($group),
			[
				'group'      => $group,
				'language'   => $language,
				'generator'  => 'Language Manager Version 3.5'
			]
		);
		if (!$saved) {
			return self::result(
				false,
				'SAVE_FAILED',
				'Không thể ghi file ngôn ngữ.'
			);
		}
		return self::result(
			true,
			'',
			'Đã lưu thành công.',
			$result
		);
	}
	public static function saveRow(
		$group,
		$language,
		array $item
	){
		
		
		$response = self::load(
			$group,
			$language
		);
		/*var_dump($group);
		var_dump($language);
		var_dump($response);
		die();*/
		if(!$response['success']){
			return $response;
		}
		$lang = $response['data'];
		
		if ($item['old_key'] === '' && $item['key'] !== '') {
			// ADD
			LangHelper::addLanguageItem(
				$lang,
				$item['key'],
				$item['value']
			);
		} elseif ($item['old_key'] !== '' && $item['key'] === '') {
			// DELETE
			LangHelper::deleteLanguageItem(
				$lang,
				$item['old_key']
			);
		} elseif ($item['old_key'] !== '' && $item['key'] !== '') {
			// UPDATE (bao gồm cả đổi tên key hoặc chỉ đổi value)
			LangHelper::updateLanguageItem(
				$lang,
				$item['old_key'],
				$item['key'],
				$item['value']
			);
		} else {
			// Cả old_key và key đều rỗng -> không làm gì
			return;
		}
		
		LangHelper::normalizeLanguageArray($lang);
		LangHelper::saveLanguageFile(
			self::getLanguageFile(
				$group,
				$language
			),
			$lang,
			self::getLanguageVariable($group),
			[
				'group'      => $group,
				'language'   => $language,
				'generator'  => 'Language Manager Version 3.5'
			]
		);
		return self::result(
			true,
			'',
			'Saved.'
		);
	}
	/**
	 * Audit language.
	 *
	 * @param string $group
	 * @param string $language
	 *
	 * @return array
	 */
	public static function audit($group, $language)
	{
		$response = self::load($group, $language);
		if (!$response['success']) {
			return $response;
		}
		return self::result(
			true,
			'',
			'',
			LangHelper::auditLanguageFile(
				$response['data']
			)
		);
	}
	/**
	 * Lấy thông tin file.
	 *
	 * @param string $group
	 * @param string $language
	 *
	 * @return array
	 */
	public static function info($group, $language)
	{
		$file = self::getLanguageFile($group, $language);
		if (!is_file($file)) {
			return self::result(false, 'FILE_NOT_FOUND');
		}
		$lang = LangHelper::loadLanguageFile($file);
		return self::result(true, '', '', [
			'file' => basename($file),
			'path' => $file,
			'size' => filesize($file),
			'modified' => date('Y-m-d H:i:s', filemtime($file)),
			'total' => count($lang)
		]);
	}
	/**
	 * Lấy đường dẫn file.
	 *
	 * @param string $group
	 * @param string $language
	 *
	 * @return string
	 */
	public static function getLanguageFile($group, $language)
	{
		$directory = self::$directories[$group];
		return rtrim($directory, '/\\')
			. DIRECTORY_SEPARATOR
			. $language
			. '.php';
	}
	/**
	 * Lấy tên biến ngôn ngữ.
	 *
	 * @param string $group
	 *
	 * @return string
	 */
	public static function getLanguageVariable($group)
	{
		switch ($group) {
			case self::GROUP_FRONT:
				return '$_FRONTLANG';
			case self::GROUP_ADMIN:
				return '$_ADMINLANG';
			default:
				return '$_LANG';
		}
	}
	protected static function validateGroup($group)
	{
		return isset(self::$directories[$group]);
	}
	protected static function validateLanguage($language)
	{
		return (bool)preg_match(
			'/^[a-z0-9_-]+$/i',
			$language
		);
	}
	protected static function result(
		$success,
		$code = '',
		$message = '',
		$data = []
	) {
		return [
			'success' => $success,
			'code' => $code,
			'message' => $message,
			'data' => $data
		];
	}
}