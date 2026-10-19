<?php
class Stdio
{
	public array $GET = [];
	public array $POST = [];
	public bool $allow_unicode = true;

	// ========================
	// Danh sách EXT bị cấm
	// ========================
	private $denyExt = [
		'php',
		'php2',
		'php3',
		'php4',
		'php5',
		'php7',
		'php8',
		'phtml',
		'phar',
		'html',
		'htm',
		'txt',
		'js',
		'css',
		'json',
		'exe',
		'sh',
		'bat',
		'cmd'
	];

	// ========================
	// Danh sách MIME HỢP LỆ
	// ========================
	private $allowedMime = [
		// Images
		'image/jpeg',
		'image/png',
		'image/gif',
		'image/webp',

		// Docs
		'application/pdf',

		// Video
		'video/mp4',
		'video/webm',
		'video/ogg',
		'video/quicktime',    // mov
		'video/x-msvideo',    // avi
		'video/x-matroska',   // mkv
	];
	public function __construct() {}

	// ========================
	// Hàm ghi log file nguy hiểm
	// ========================
	private function logBlockedFile($filename, $mime)
	{
		$logFolder = $_SERVER['DOCUMENT_ROOT'] . '/logs';
		$logFile   = $logFolder . '/upload_blocked.log';

		if (!is_dir($logFolder)) {
			mkdir($logFolder, 0777, true);
		}

		$time = date('Y-m-d H:i:s');
		$ip   = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

		file_put_contents(
			$logFile,
			"[$time] IP: $ip | FILE: $filename | MIME: $mime\n",
			FILE_APPEND
		);
	}

	// ==========================================================
	// Xử lý single file — trả về true nếu hợp lệ, false nếu xoá
	// ==========================================================
	private function processSingleFile(&$file)
	{
		if (empty($file['name'])) return false;

		// Chặn null-byte
		$file['name'] = str_replace("\0", '', $file['name']);

		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

		// Block EXT
		if (in_array($ext, $this->denyExt)) {
			$this->logBlockedFile($file['name'], "EXT BLOCKED");
			$file = [];
			return false;
		}

		// Check MIME thật
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$realMime = finfo_file($finfo, $file['tmp_name']);
		finfo_close($finfo);

		if (!in_array($realMime, $this->allowedMime)) {
			$this->logBlockedFile($file['name'], $realMime);
			$file = [];
			return false;
		}

		return true;
	}

	// ==========================================================
	// Xử lý multiple file
	// ==========================================================
	private function processMultipleFiles(&$files)
	{
		foreach ($files['name'] as $i => $name) {

			// Chặn null-byte
			$files['name'][$i] = str_replace("\0", '', $name);

			$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

			// Block EXT
			if (in_array($ext, $this->denyExt)) {
				$this->logBlockedFile($name, "EXT BLOCKED");
				$this->unsetFileIndex($files, $i);
				continue;
			}

			// MIME thật
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$realMime = finfo_file($finfo, $files['tmp_name'][$i]);
			finfo_close($finfo);

			if (!in_array($realMime, $this->allowedMime)) {
				$this->logBlockedFile($name, $realMime);
				$this->unsetFileIndex($files, $i);
				continue;
			}
		}

		// Reindex
		foreach ($files as &$arr) {
			if (is_array($arr)) {
				$arr = array_values($arr);
			}
		}
	}

	// ==========================================================
	// Xoá file ở index $i khỏi mảng multiple
	// ==========================================================
	private function unsetFileIndex(&$files, $i)
	{
		unset($files['name'][$i]);
		unset($files['type'][$i]);
		unset($files['tmp_name'][$i]);
		unset($files['error'][$i]);
		unset($files['size'][$i]);
	}

	// ==========================================================
	// HÀM PUBLIC — xử lý toàn bộ $_FILES
	// ==========================================================
	public function secureFiles(&$fileGroup)
	{
		if (empty($fileGroup)) return;

		if (is_array($fileGroup['name'])) {
			$this->processMultipleFiles($fileGroup);
		} else {
			$this->processSingleFile($fileGroup);
		}
	}

	public function parse_incoming(bool $flag = true): array
	{
		$return = [];

		// --- Lấy dữ liệu từ $_GET ---
		if ($flag && is_array($_GET)) {
			foreach ($_GET as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						$return[$k][$this->clean_key($k2)] = $this->clean_value($v2);
					}
				} else {
					$return[$k] = $this->clean_value($v);
				}
			}
		}

		// --- Gộp dữ liệu từ $_POST ---
		if (!$flag && is_array($_POST)) {
			foreach ($_POST as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						$return[$k][$this->clean_key($k2)] = $this->clean_value($v2);
					}
				} else {
					$return[$k] = $this->clean_value($v);
				}
			}
		}

		return $return;
	}

	/**
	 * Làm sạch key
	 */
	private function clean_key(string $key): string
	{
		if ($key === "0" || $key === "") {
			return $key;
		}
		$key = preg_replace("/\.\./", "", $key);
		$key = preg_replace("/\_\_(.+?)\_\_/", "", $key);
		$key = preg_replace("/^([\w.\-_]+)$/", "$1", $key);
		return (string)$key;
	}

	/**
	 * Làm sạch giá trị
	 */
	private function clean_value(mixed $val): string
	{
		if ($val === null || $val === "") {
			return "";
		}
		if (is_array($val)) {
			return json_encode($val, JSON_UNESCAPED_UNICODE);
		}

		$val = (string)$val;
		$val = str_replace(["&#032;", chr(0xCA)], [" ", ""], $val);
		$val = str_replace("&", "&amp;", $val);
		$val = str_replace(["<!--", "-->"], ["&#60;&#33;--", "--&#62;"], $val);
		$val = preg_replace("/<script/i", "&#60;script", $val);
		$val = str_replace(">", "&gt;", $val);
		$val = str_replace("<", "&lt;", $val);
		$val = str_replace("\"", "&quot;", $val);
		$val = preg_replace("/\n/", "<br>", $val);
		$val = preg_replace("/\\\$/", "&#036;", $val);
		$val = preg_replace("/\r/", "", $val);
		$val = str_replace(["!", "'"], ["&#33;", "&#39;"], $val);

		// Unicode-safe
		if ($this->allow_unicode) {
			$val = preg_replace("/&amp;#([0-9]+);/s", "&#\\1;", $val);
		}

		// Backslash
		$val = preg_replace("/\\\(?!&amp;#|\?#)/s", "&#092;", $val);

		// Loại bỏ <br> nếu không cần
		$val = preg_replace("/<br\s?\/?>/s", "", $val);

		return trim($val);
	}

	/**
	 * Truy xuất GET / POST an toàn
	 */
	public function GET(string $var, mixed $def = ""): mixed
	{
		return $_GET[$var] ?? $def;
	}

	public function POST(string $var, mixed $def = ""): mixed
	{
		return $_POST[$var] ?? $def;
	}
}
