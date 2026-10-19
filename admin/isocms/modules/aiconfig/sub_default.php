<?php
if (!function_exists('default_default')) {
function default_default(){
	global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsConfiguration, $oneSetting;
	$clsConfiguration = new Configuration();
	$assign_list["clsConfiguration"] = $clsConfiguration;
	$assign_list["core"] = $core;
	$assign_list["message"] = isset($_GET['message']) ? $_GET['message'] : '';
	
	if (!class_exists('Transport')) {
		$file_path = (defined('DIR_CLASSES') ? DIR_CLASSES : ABSPATH . '/classes') . '/class_Transport.php';
		if (file_exists($file_path)) require_once($file_path);
	}
	if (class_exists('Transport')) {
		$clsTransport = new Transport();
		$assign_list["listTransport"] = $clsTransport->getAll("is_trash=0 order by order_no asc");
		$assign_list["clsTransport"] = $clsTransport;
	}

	if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration') {
		$ai_tour_enabled = !empty($_POST['iso-ai_tour_enabled']) ? 1 : 0;
		$clsConfiguration->updateValue('ai_tour_enabled', $ai_tour_enabled);

		foreach ($_POST as $key => $val) {
			if (strpos($key, 'iso-') === 0) {
				$setting_key = substr($key, 4);
				if ($setting_key !== 'ai_tour_enabled') {
					$clsConfiguration->updateValue($setting_key, $val);
				}
			}
		}
		
		header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess');
		exit();
	}
}
}

if (!function_exists('default_ajax_toggle_ai_tour_status')) {
function default_ajax_toggle_ai_tour_status() {
	global $clsConfiguration;
	if (!isset($clsConfiguration)) {
		$clsConfiguration = new Configuration();
	}
	$status = !empty($_POST['status']) ? 1 : 0;
	$clsConfiguration->updateValue('ai_tour_enabled', $status);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode([
		'ok' => true,
		'status' => $status,
		'message' => $status ? 'AI Tour Creation enabled' : 'AI Tour Creation disabled'
	]);
	exit();
}
}

if(!function_exists('_toArray')){
	function _toArray($d){
		if (is_object($d)) {
			$d = get_object_vars($d);
		}
		if (is_array($d)) {
			return array_map(__FUNCTION__,$d);
		} else {
			return $d;
		}
	}
}

if (!function_exists('get_isocms_root_dir_sub')) {
function get_isocms_root_dir_sub() {
	if (defined('ABSPATH') && file_exists(ABSPATH . '/uploads')) {
		return rtrim(ABSPATH, '/');
	}
	if (defined('DIR_INCLUDES')) {
		return dirname(DIR_INCLUDES);
	}
	return realpath(__DIR__ . '/../../../..');
}
}

if (!function_exists('fixTruncatedJson_sub')) {
function fixTruncatedJson_sub($json) {
	if (empty($json) || !is_string($json)) return $json;
	$json = trim($json);
	if (preg_match('/```(?:json)?\s*(.*?)\s*```/s', $json, $matches)) {
		$json = trim($matches[1]);
	}
	
	$res = @json_decode($json, true);
	if (json_last_error() === JSON_ERROR_NONE && is_array($res) && !empty($res)) {
		return $json;
	}
	
	// Sửa xuống dòng chưa escape trong dấu ngoặc kép
	$json = preg_replace_callback('/"(?:[^"\\\\]|\\\\.)*"/s', function($m) {
		return str_replace(array("\r\n", "\r", "\n", "\t"), array('\n', '\n', '\n', '\t'), $m[0]);
	}, $json);
	
	$res = @json_decode($json, true);
	if (json_last_error() === JSON_ERROR_NONE && is_array($res) && !empty($res)) {
		return $json;
	}
	
	// Loại bỏ dấu phẩy dư thừa trước } hoặc ]
	$json = preg_replace('/,\s*([\}\]])/', '$1', $json);
	
	$res = @json_decode($json, true);
	if (json_last_error() === JSON_ERROR_NONE && is_array($res) && !empty($res)) {
		return $json;
	}
	
	// Tự động đóng dấu ngoặc kép và ngoặc nhọn/ngoặc vuông nếu bị cắt đứt giữa chừng
	$len = strlen($json);
	$in_string = false;
	$escape = false;
	$open_stack = array();
	
	for ($i = 0; $i < $len; $i++) {
		$ch = $json[$i];
		if ($escape) {
			$escape = false;
			continue;
		}
		if ($ch === '\\') {
			$escape = true;
			continue;
		}
		if ($ch === '"') {
			$in_string = !$in_string;
			continue;
		}
		if (!$in_string) {
			if ($ch === '{' || $ch === '[') {
				array_push($open_stack, $ch === '{' ? '}' : ']');
			} else if ($ch === '}' || $ch === ']') {
				if (!empty($open_stack)) array_pop($open_stack);
			}
		}
	}
	
	if ($in_string) {
		$json .= '"';
	}
	
	$json = preg_replace('/,\s*$/', '', $json);
	$json = preg_replace('/"[^"]*"\s*:\s*$/', '', $json);
	$json = preg_replace('/,\s*$/', '', $json);
	
	while (!empty($open_stack)) {
		$json .= array_pop($open_stack);
	}
	
	$json = preg_replace('/,\s*([\}\]])/', '$1', $json);
	
	return $json;
}
}

if (!function_exists('parse_schema_json_sub')) {
function parse_schema_json_sub($json_str) {
	if (empty($json_str)) return array();
	if (is_array($json_str)) return $json_str;
	
	$json_str = trim((string)$json_str);
	
	// Loại bỏ markdown codeblock nếu có
	if (preg_match('/```(?:json)?\s*(.*?)\s*```/s', $json_str, $matches)) {
		$json_str = trim($matches[1]);
	}
	
	// 1. Thử json_decode trực tiếp
	$data = @json_decode($json_str, true);
	if (json_last_error() === JSON_ERROR_NONE && is_array($data) && !empty($data)) {
		return $data;
	}
	
	// 2. Thử với stripslashes
	$stripped = stripslashes($json_str);
	$data = @json_decode($stripped, true);
	if (json_last_error() === JSON_ERROR_NONE && is_array($data) && !empty($data)) {
		return $data;
	}

	// 3. Thử với html_entity_decode
	$decoded_html = html_entity_decode($json_str, ENT_QUOTES, 'UTF-8');
	$data = @json_decode($decoded_html, true);
	if (json_last_error() === JSON_ERROR_NONE && is_array($data) && !empty($data)) {
		return $data;
	}
	$data = @json_decode(stripslashes($decoded_html), true);
	if (json_last_error() === JSON_ERROR_NONE && is_array($data) && !empty($data)) {
		return $data;
	}

	// 4. Xử lý xuống dòng chưa escape trong chuỗi string JSON
	$fixed_quotes = preg_replace_callback('/"(?:[^"\\\\]|\\\\.)*"/s', function($m) {
		return str_replace(array("\r\n", "\r", "\n", "\t"), array('\n', '\n', '\n', '\t'), $m[0]);
	}, $stripped);
	$data = @json_decode($fixed_quotes, true);
	if (json_last_error() === JSON_ERROR_NONE && is_array($data) && !empty($data)) {
		return $data;
	}

	// 5. Loại bỏ các ký tự điều khiển ngoại trừ \r, \n, \t
	$clean_ctrl = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $stripped);
	$data = @json_decode($clean_ctrl, true);
	if (json_last_error() === JSON_ERROR_NONE && is_array($data) && !empty($data)) {
		return $data;
	}

	// 6. Xóa phẩy dư thừa trước dấu đóng ngoặc
	$clean_commas = preg_replace('/,\s*([\}\]])/', '$1', $clean_ctrl);
	$data = @json_decode($clean_commas, true);
	if (json_last_error() === JSON_ERROR_NONE && is_array($data) && !empty($data)) {
		return $data;
	}

	// 7. Sửa JSON bị cắt ngang bằng fixTruncatedJson_sub
	$truncated_fixed = fixTruncatedJson_sub($clean_commas);
	$data = @json_decode($truncated_fixed, true);
	if (json_last_error() === JSON_ERROR_NONE && is_array($data) && !empty($data)) {
		return $data;
	}

	// 8. Bóc tách bằng Cấu trúc Cấp cứu Regex nếu JSON bị lỗi quá nặng
	$emergency_data = array();
	if (preg_match('/"title"\s*:\s*"([^"]+)"/u', $json_str, $m)) {
		$emergency_data['title'] = $m[1];
	}
	if (preg_match('/"overview"\s*:\s*"([^"]+)"/u', $json_str, $m)) {
		$emergency_data['overview'] = $m[1];
	}
	if (preg_match_all('/\{\s*"day"\s*:\s*(\d+).*?"title"\s*:\s*"([^"]*)".*?(?="content"|\})/su', $json_str, $matches, PREG_SET_ORDER)) {
		$itin_items = array();
		foreach ($matches as $match) {
			$day_num = (int)$match[1];
			$day_title = $match[2];
			$itin_items[] = array(
				'day' => $day_num,
				'title' => $day_title,
				'content' => array($day_title)
			);
		}
		if (!empty($itin_items)) {
			$emergency_data['itinerary'] = $itin_items;
		}
	}
	if (!empty($emergency_data) && isset($emergency_data['title'])) {
		return $emergency_data;
	}

	return is_array($data) ? $data : array();
}
}

if (!function_exists('cleanAndParseJson_sub')) {
function cleanAndParseJson_sub($json_str) {
	return parse_schema_json_sub($json_str);
}
}

if (!function_exists('formatTimelineContent_sub')) {
function formatTimelineContent_sub($text) {
	if (empty($text)) return '';
	
	$raw_text = '';
	if (is_array($text)) {
		$parts = array();
		foreach ($text as $item) {
			if (is_array($item)) {
				$parts[] = implode(' ', $item);
			} else {
				$str = trim((string)$item);
				if ($str !== '') $parts[] = $str;
			}
		}
		$raw_text = implode("\n", $parts);
	} else {
		$raw_text = trim((string)$text);
	}

	if ($raw_text === '') return '';

	// Nếu đã có cấu trúc danh sách HTML <ul> hoặc <ol> thì giữ nguyên
	if (strpos($raw_text, '<ul>') !== false || strpos($raw_text, '<ol>') !== false) {
		return $raw_text;
	}

	// Chèn dấu xuống dòng trước các ký tự bullet nằm cùng dòng (🔲, □, ■, ▪, ▫, •, ✦, ✧, ★, ⁃, ‣)
	// để mỗi điểm tham quan / hoạt động trở thành một dòng riêng biệt
	$bullet_chars_regex = '/([^\n])\s*([🔲□■▪▫•✦✧★⁃‣\x{25A0}-\x{25FF}\x{1F532}])\s*/u';
	$raw_text = preg_replace($bullet_chars_regex, "$1\n$2 ", $raw_text);

	$raw_text = preg_replace('/<br\s*\/?>/i', "\n", $raw_text);
	$raw_text = preg_replace('/<\/p>/i', "\n", $raw_text);
	$raw_text = preg_replace('/<p[^>]*>/i', '', $raw_text);

	$split_lines = explode("\n", $raw_text);
	$lines = array();
	foreach ($split_lines as $l) {
		$l = trim($l);
		if ($l !== '') $lines[] = $l;
	}

	if (empty($lines)) return '';

	$html = '';
	$in_list = false;

	$bullet_line_pattern = '/^([🔲□■▪▫•✦✧★⁃‣\-\+\*]|\x{25A0}-\x{25FF}|\x{1F532}|\d+[\.\)])\s*(.*)$/u';
	$meal_stay_pattern = '/\.\s+(Quý khách (?:ăn trưa|ăn tối|ăn sáng|nghỉ đêm|tự do).*)$/iu';

	foreach ($lines as $line) {
		if (preg_match($bullet_line_pattern, $line, $matches)) {
			$item_content = trim($matches[2]);
			$separate_tail = '';

			if (preg_match($meal_stay_pattern, $item_content, $tail_m, PREG_OFFSET_CAPTURE)) {
				$match_offset = $tail_m[0][1];
				$separate_tail = trim($tail_m[1][0]);
				$item_content = trim(substr($item_content, 0, $match_offset + 1));
			}

			if (!$in_list) {
				$html .= '<ul>';
				$in_list = true;
			}
			$html .= '<li>' . $item_content . '</li>';

			if ($separate_tail !== '') {
				$html .= '</ul>';
				$in_list = false;
				$html .= '<p>' . $separate_tail . '</p>';
			}
		} else {
			if ($in_list) {
				$html .= '</ul>';
				$in_list = false;
			}

			$formatted_line = $line;
			if (strpos($formatted_line, '<strong') === false && strpos($formatted_line, '<b>') === false) {
				$formatted_line = preg_replace('/^((?:\d{1,2}h\d{0,2}|\d{1,2}:\d{2}|Sáng|Trưa|Tối|Chiều|Sau bữa trưa|Buổi [a-zA-Z\x{00C0}-\x{024F}\x{1EA0}-\x{1EF9}]+)[\s:-]+)/iu', '<strong>$1</strong>', $formatted_line);
			}

			$html .= '<p>' . $formatted_line . '</p>';
		}
	}

	if ($in_list) {
		$html .= '</ul>';
		$in_list = false;
	}

	return !empty($html) ? $html : $raw_text;
}
}

if (!function_exists('safe_utf8_filename_sub')) {
function safe_utf8_filename_sub($filename) {
	if (empty($filename)) return '';
	if (function_exists('mb_check_encoding') && mb_check_encoding($filename, 'UTF-8')) {
		return $filename;
	}
	if (function_exists('mb_convert_encoding')) {
		return @mb_convert_encoding($filename, 'UTF-8', 'ISO-8859-1, Windows-1252');
	}
	return $filename;
}
}

if (!function_exists('get_active_language_code_sub')) {
function get_active_language_code_sub() {
	global $_LANG_ID, $clsISO, $clsConfiguration;
	$lang = '';
	if (!empty($_LANG_ID)) {
		$lang = $_LANG_ID;
	} else if (isset($_POST['lang_id']) && !empty($_POST['lang_id'])) {
		$lang = $_POST['lang_id'];
	} else if (isset($_GET['lang']) && !empty($_GET['lang'])) {
		$lang = $_GET['lang'];
	} else if (isset($_SESSION['_LANG_ID']) && !empty($_SESSION['_LANG_ID'])) {
		$lang = $_SESSION['_LANG_ID'];
	} else if (class_exists('ISO') && method_exists($clsISO, 'getLang')) {
		$lang = $clsISO->getLang();
	}
	$lang = strtolower(trim((string)$lang));
	return !empty($lang) ? $lang : 'en';
}
}

if (!function_exists('get_language_name_by_code_sub')) {
function get_language_name_by_code_sub($lang_code) {
	$lang_code = strtolower(trim((string)$lang_code));
	$map = array(
		'en' => 'English',
		'vi' => 'Vietnamese (Tiếng Việt)',
		'vn' => 'Vietnamese (Tiếng Việt)',
		'cn' => 'Chinese (Tiếng Trung)',
		'zh' => 'Chinese (Tiếng Trung)',
		'kr' => 'Korean (Tiếng Hàn)',
		'ko' => 'Korean (Tiếng Hàn)',
		'jp' => 'Japanese (Tiếng Nhật)',
		'ja' => 'Japanese (Tiếng Nhật)',
		'fr' => 'French (Tiếng Pháp)',
		'de' => 'German (Tiếng Đức)',
		'es' => 'Spanish (Tiếng Tây Ban Nha)',
		'it' => 'Italian (Tiếng Ý)',
		'ru' => 'Russian (Tiếng Nga)',
		'th' => 'Thai (Tiếng Thái)',
		'la' => 'Lao (Tiếng Lào)',
		'id' => 'Indonesian (Tiếng Indonesia)',
		'ms' => 'Malay (Tiếng Mã Lai)'
	);
	return isset($map[$lang_code]) ? $map[$lang_code] : ucfirst($lang_code);
}
}

if (!function_exists('translate_schema_data_to_target_lang_sub')) {
function translate_schema_data_to_target_lang_sub($schema_data, $target_lang_code = 'en', $api_key = '', $gemini_model = '') {
	if (empty($schema_data) || !is_array($schema_data)) {
		return $schema_data;
	}
	if (empty($target_lang_code)) {
		$target_lang_code = get_active_language_code_sub();
	}
	if (empty($api_key)) {
		$clsConfiguration = new Configuration();
		$api_key = $clsConfiguration->getValue('gemini_api_key');
		if (empty($api_key)) $api_key = $clsConfiguration->getValue('GeminiAPIKey');
		if (empty($api_key)) $api_key = $clsConfiguration->getValue('site_gemini_api_key');
	}
	if (empty($gemini_model)) {
		$clsConfiguration = new Configuration();
		$gemini_model = $clsConfiguration->getValue('gemini_model_id');
		if (empty($gemini_model)) $gemini_model = $clsConfiguration->getValue('GeminiModel');
		if (empty($gemini_model)) $gemini_model = 'gemini-2.5-flash';
	}
	if (empty($api_key)) {
		return $schema_data;
	}

	$target_lang_name = get_language_name_by_code_sub($target_lang_code);

	$system_prompt = "Bạn là trợ lý AI chuyên gia dịch thuật và chuẩn hóa dữ liệu tour du lịch trong JSON.\n";
	$system_prompt .= "QUY TẮC DỊCH VÀ BẢO TỒN VĂN BẢN (QUAN TRỌNG 100%):\n";
	$system_prompt .= "1. Kiểm tra ngôn ngữ hiện tại của các trường nội dung văn bản trong JSON Object đầu vào.\n";
	$system_prompt .= "2. Ngôn ngữ mục tiêu của website cần chuyển đổi sang là: " . $target_lang_name . " (Mã ngôn ngữ: " . $target_lang_code . ").\n";
	$system_prompt .= "3. NẾU nội dung văn bản trong JSON đã hoàn toàn thuộc về " . $target_lang_name . ", GIỮ NGUYÊN BẢN 100% không chỉnh sửa bất kỳ câu chữ nào.\n";
	$system_prompt .= "4. NẾU nội dung văn bản thuộc ngôn ngữ khác (ví dụ: tài liệu gốc là Tiếng Việt, Tiếng Trung, Tiếng Hàn, Tiếng Nhật... nhưng ngôn ngữ mục tiêu website là " . $target_lang_name . "): BẮT BUỘC DỊCH TOÀN BỘ các thuộc tính văn bản sang " . $target_lang_name . ":\n";
	$system_prompt .= "   - `title`, `departure_point`, `destination`.\n";
	$system_prompt .= "   - `overview`, `intro`: Dịch toàn bộ nội dung sang " . $target_lang_name . ", bao gồm cả các tiêu đề mục (ví dụ 'Đặc điểm nổi bật' dịch thành 'Highlights', 'Tóm tắt hành trình' / 'Tóm tắt lịch trình' dịch thành 'Summary Itinerary', các ngày 'Ngày 1:' dịch thành 'Day 1:').\n";
	$system_prompt .= "   - `itinerary`: Dịch tiêu đề từng ngày (`title`), chuyển đổi tiền tố ngày (ví dụ 'Ngày 1:' -> 'Day 1:' nếu sang tiếng Anh), dịch toàn bộ nội dung chi tiết (`content`), các ghi chú (`meals`, `transport`, `hotel`).\n";
	$system_prompt .= "   - `inclusion`, `exclusion`, `thing_to_carry`, `cancellation_policy`, `refund_policy`, `confirmation_policy`, `activity`, `advisory`.\n";
	$system_prompt .= "5. NGUYÊN TẮC DỊCH: Dịch sát nghĩa nhất với nội dung nguyên bản, bảo đảm đầy đủ 100% chi tiết câu từ, TUYỆT ĐỐI KHÔNG tóm tắt, KHÔNG rút gọn hay bỏ bớt bất kỳ thông tin nào. Giữ nguyên 100% tất cả các thẻ định dạng HTML như <ul>, <li>, <p>, <strong>, <br>.\n";
	$system_prompt .= "6. Giữ nguyên toàn bộ cấu trúc mảng và các thuộc tính khác (day, number_day, number_night, price, transport, meals, city...).\n";
	$system_prompt .= "7. Trả về DUY NHẤT 1 JSON Object hợp lệ.";

	$user_prompt = "Dưới đây là dữ liệu Tour dạng JSON vừa bóc tách:\n\n";
	$user_prompt .= json_encode($schema_data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n\n";
	$user_prompt .= "Hãy kiểm tra và dịch tất cả các đoạn văn bản trong JSON này sang " . $target_lang_name . " (mã: " . $target_lang_code . "). Nếu đã thuộc " . $target_lang_name . " thì giữ nguyên bản 100%.";

	$payload = array(
		'systemInstruction' => array('parts' => array(array('text' => $system_prompt))),
		'contents' => array(array('parts' => array(array('text' => $user_prompt)))),
		'generationConfig' => array(
			'temperature' => 0.1,
			'maxOutputTokens' => 16384,
			'responseMimeType' => 'application/json'
		)
	);

	$url = "https://generativelanguage.googleapis.com/v1beta/models/" . urlencode($gemini_model) . ":generateContent?key=" . urlencode($api_key);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);

	$response = curl_exec($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($http_code == 200 && !empty($response)) {
		$res_data = @json_decode($response, true);
		if (isset($res_data['candidates'][0]['content']['parts'][0]['text'])) {
			$translated_text = $res_data['candidates'][0]['content']['parts'][0]['text'];
			$translated_json = parse_schema_json_sub($translated_text);
			if (!empty($translated_json) && is_array($translated_json) && isset($translated_json['title'])) {
				return $translated_json;
			}
		}
	}

	return $schema_data;
}
}

if (!function_exists('parse_word_document_xml_sub')) {
function parse_word_document_xml_sub($xml) {
	$xml = str_replace(array('</w:p>', '</w:tr>', '<w:br/>', '<w:br>', '<w:cr/>'), "\n", $xml);
	$xml = str_replace(array('</w:tc>', '<w:tab/>'), "\t", $xml);
	$text = strip_tags($xml);
	$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
	$text = preg_replace("/[ \t]+/", " ", $text);
	$text = preg_replace("/\n\s*\n\s*\n+/", "\n\n", $text);
	return trim($text);
}
}

if (!function_exists('extract_text_from_docx_sub')) {
function extract_text_from_docx_sub($file_path, $file_bytes = null) {
	$text = '';
	if (class_exists('ZipArchive')) {
		$zip = new ZipArchive();
		$opened = false;
		if (!empty($file_path) && file_exists($file_path)) {
			$opened = ($zip->open($file_path) === true);
		}
		if ($opened) {
			$xml = $zip->getFromName('word/document.xml');
			$zip->close();
			if (!empty($xml)) {
				$text = parse_word_document_xml_sub($xml);
				if (!empty(trim($text))) {
					return $text;
				}
			}
		}
	}
	if (!empty($file_path) && file_exists($file_path)) {
		$xml = @file_get_contents('zip://' . realpath($file_path) . '#word/document.xml');
		if (!empty($xml)) {
			$text = parse_word_document_xml_sub($xml);
			if (!empty(trim($text))) {
				return $text;
			}
		}
	}
	if (empty($file_bytes) && !empty($file_path) && file_exists($file_path)) {
		$file_bytes = @file_get_contents($file_path);
	}
	if (!empty($file_bytes)) {
		$pos = strpos($file_bytes, 'word/document.xml');
		if ($pos !== false) {
			$offset = $pos + strlen('word/document.xml');
			for ($i = 0; $i < 64; $i++) {
				$testChunk = substr($file_bytes, $offset + $i);
				$decompressed = @gzinflate($testChunk);
				if ($decompressed !== false && strpos($decompressed, '<w:document') !== false) {
					$text = parse_word_document_xml_sub($decompressed);
					if (!empty(trim($text))) {
						return $text;
					}
				}
			}
		}
	}
	return $text;
}
}

if (!function_exists('extract_text_from_doc_sub')) {
function extract_text_from_doc_sub($file_path, $file_bytes = null) {
	if (empty($file_bytes) && !empty($file_path) && file_exists($file_path)) {
		$file_bytes = @file_get_contents($file_path);
	}
	if (empty($file_bytes)) return '';
	$text_utf16 = '';
	if (preg_match_all('/(?:[\x20-\x7E\xA0-\xFF]\x00){4,}/s', $file_bytes, $matches)) {
		foreach ($matches[0] as $match) {
			$decoded = @mb_convert_encoding($match, 'UTF-8', 'UTF-16LE');
			if (!empty($decoded) && strlen(trim($decoded)) > 3) {
				$text_utf16 .= trim($decoded) . "\n";
			}
		}
	}
	$text_ansi = '';
	$raw_strings = preg_split('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/', $file_bytes);
	foreach ($raw_strings as $str) {
		$str = trim($str);
		if (strlen($str) >= 4 && preg_match('/[\p{L}\p{N}]/u', $str)) {
			$text_ansi .= $str . "\n";
		}
	}
	return (strlen($text_utf16) > strlen($text_ansi)) ? trim($text_utf16) : trim($text_ansi);
}
}

if (!function_exists('extract_text_from_file_sub')) {
function extract_text_from_file_sub($file_path, $file_ext, $file_bytes = null) {
	$file_ext = strtolower($file_ext);
	if ($file_ext === 'docx') {
		return extract_text_from_docx_sub($file_path, $file_bytes);
	} else if ($file_ext === 'doc') {
		return extract_text_from_doc_sub($file_path, $file_bytes);
	} else if ($file_ext === 'txt') {
		if (empty($file_bytes) && !empty($file_path) && file_exists($file_path)) {
			$file_bytes = @file_get_contents($file_path);
		}
		return !empty($file_bytes) ? trim($file_bytes) : '';
	}
	return '';
}
}

// LẤY TOUR SCHEMA MẪU (JSON SCHEMA DEMO)
if (!function_exists('default_ajax_get_sample_schema')) {
function default_ajax_get_sample_schema(){
	error_reporting(0);
	ini_set('display_errors', 0);
	$schema_file = __DIR__ . '/tour_schema.json';
	$sample_data = '';
	if (file_exists($schema_file)) {
		$sample_data = file_get_contents($schema_file);
	}
	echo json_encode(array(
		'ok' => true,
		'schema_json' => $sample_data
	));
	exit();
}
}

// B�C TÁCH TRỰC TIẾP TỪ FILE (PDF/DOCX) SANG TOUR SCHEMA JSON BẰNG GEMINI MULTIMODAL API
if (!function_exists('default_ajax_extract_raw_text')) {
function default_ajax_extract_raw_text(){
	error_reporting(0);
	ini_set('display_errors', 0);
	global $core, $clsConfiguration;

	$file_bytes = null;
	$file_name = '';
	$file_ext = '';
	$tmp_path = '';

	if (isset($_FILES['contract_file']) && $_FILES['contract_file']['error'] == UPLOAD_ERR_OK) {
		$file_name = safe_utf8_filename_sub($_FILES['contract_file']['name']);
		$tmp_path = $_FILES['contract_file']['tmp_name'];
		$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		$file_bytes = @file_get_contents($tmp_path);
	} else if (isset($_POST['file_path']) && !empty($_POST['file_path'])) {
		$file_path = trim($_POST['file_path']);
		$file_name = isset($_POST['file_name']) ? trim($_POST['file_name']) : basename($file_path);
		$root_dir = get_isocms_root_dir_sub();
		$full_file_path = $root_dir . '/' . ltrim($file_path, '/');
		if (!file_exists($full_file_path)) {
			$full_file_path = $file_path;
		}
		if (file_exists($full_file_path)) {
			$file_ext = strtolower(pathinfo($full_file_path, PATHINFO_EXTENSION));
			$file_bytes = @file_get_contents($full_file_path);
		}
	}
	
	if (empty($file_bytes)) {
		echo json_encode(array('ok' => false, 'error' => 'Vui lòng chọn file chương trình / hợp đồng tour (.PDF, .DOCX hoặc .TXT) để tải lên.'));
		exit();
	}

	$clsConfiguration = new Configuration();
	$api_key = $clsConfiguration->getValue('gemini_api_key');
	$gemini_model = $clsConfiguration->getValue('gemini_model_id');
	if (empty($gemini_model)) {
		$gemini_model = 'gemini-3.1-flash-lite';
	}
	if (empty($api_key)) {
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Key has not been configured yet. Vui lòng cấu hình API Key trong Cấu Hình AI Config.'));
		exit();
	}

	$b64 = base64_encode($file_bytes);

	// Nạp file tour_schema.json mẫu định nghĩa
	$schema_template_path = __DIR__ . '/tour_schema.json';
	$schema_template_str = '';
	if (file_exists($schema_template_path)) {
		$schema_template_str = file_get_contents($schema_template_path);
	}

	// Truy vấn danh sách phương tiện di chuyển hợp lệ trong CSDL ISOCMS
	$allowed_transports = array("Train", "Bicycle", "Mini Bus", "Cruise", "Motorbike", "Air plane", "Car", "Bus");
	if (!class_exists('Transport')) {
		$file_path = (defined('DIR_CLASSES') ? DIR_CLASSES : ABSPATH . '/classes') . '/class_Transport.php';
		if (file_exists($file_path)) require_once($file_path);
	}
	if (class_exists('Transport')) {
		$clsTransport = new Transport();
		$lstTrDb = $clsTransport->getAll("is_trash=0", "title,transport_id");
		if (!empty($lstTrDb)) {
			$tmp_list = array();
			foreach ($lstTrDb as $trItem) {
				if (!empty($trItem['title'])) {
					$tmp_list[] = trim($trItem['title']);
				}
			}
			if (!empty($tmp_list)) {
				$allowed_transports = array_values($tmp_list);
			}
		}
	}
	$transport_str_list = implode(', ', array_map(function($t) { return '"' . $t . '"'; }, $allowed_transports));

	$system_prompt = "Bạn là trợ lý AI chuyên gia bóc tách dữ liệu tour du lịch từ tài liệu thành JSON.\n";
	$system_prompt .= "QUY TẮC NGUYÊN TẮC QUAN TRỌNG ĐỂ JSON LUÔN CHUẨN XÁC NGUYÊN VĂN 100%:\n";
	$system_prompt .= "1. TRÍCH XUẤT NGUYÊN VĂN 100% ĐẦY ĐỦ: Bóc tách NGUYÊN VĂN 100% toàn bộ thông tin, tiêu đề, các mốc thời gian, chi tiết tham quan, dịch vụ và toàn bộ nội dung của từng ngày trong tệp gốc sang cấu trúc JSON hợp lệ. TUYỆT ĐỐI KHÔNG TÓM TẮT, KHÔNG RÚT GỌN, KHÔNG BỎ BỚT BẤT KỲ CÂU TỪ HAY ĐOẠN VĂN NÀO CỦA CÁC NGÀY LỊCH TRÌNH.\n";
	$system_prompt .= "2. BÓC TÁCH ĐẦY ĐỦ 100% tất cả các phần: Tiêu đề tour, số ngày/đêm, giá tour, tổng quan (overview), dịch vụ bao gồm (inclusion), dịch vụ không bao gồm (exclusion), đồ cần mang (thing_to_carry), các chính sách (cancellation_policy, refund_policy, confirmation_policy), điểm khởi hành, điểm đến, thể loại tour và LỊCH TRÌNH CHI TIẾT TỪNG NGÀY (itinerary).\n";
	$system_prompt .= "3. ĐỊNH DẠNG `content` CỦA LỊCH TRÌNH TỪNG NGÀY (BÓC TÁCH NGUYÊN VĂN 100% VÀ BẮT BUỘC TRÌNH BÀY DẠNG DANH SÁCH HTML RÕ RÀNG):\n";
	$system_prompt .= "   - Thuộc tính `content` của mỗi ngày LÀ 1 MẢNG CÁC CHUỖI VĂN BẢN (Array of strings) chứa toàn bộ chi tiết hành trình trong ngày.\n";
	$system_prompt .= "   - BẮT BUỘC TRÌNH BÀY DẠNG DANH SÁCH (LIST) ĐỂ DỄ QUAN SÁT CHI TIẾT TỪNG HOẠT ĐỘNG VÀ ĐIỂM ĐẾN:\n";
	$system_prompt .= "     + TUYỆT ĐỐI KHÔNG gom dồn tất cả các điểm tham quan, hoạt động của cả ngày thành một đoạn văn dài liền khối.\n";
	$system_prompt .= "     + Câu mốc thời gian hoặc câu dẫn đầu (Ví dụ: '07h30: Đoàn hạ cánh tại sân bay Kansai - Osaka, xe đón Đoàn khởi hành đi Kobe tham quan:' hoặc 'Sau bữa trưa đoàn khởi hành đi Osaka tham quan:') bọc trong thẻ <p><strong>...</strong></p>.\n";
	$system_prompt .= "     + TẤT CẢ các điểm tham quan, hoạt động, trải nghiệm chi tiết (Ví dụ: Tháp cảng Kobe, Bảo tàng tưởng niệm..., Lâu Đài Osaka, Phố mua sắm Shinsaibashi-suji...) BẮT BUỘC TRÌNH BÀY DẠNG DANH SÁCH BẰNG THẺ <ul><li>...</li></ul>. Mỗi điểm tham quan/hoạt động là một thẻ <li> riêng biệt chứa ĐẦY ĐỦ 100% câu từ mô tả chi tiết, không cắt bớt hay tóm tắt.\n";
	$system_prompt .= "     + Các câu thông báo ăn uống, nghỉ ngơi (Ví dụ: 'Quý khách ăn trưa tại Kobe, thưởng thức thịt bò Kobe.', 'Quý khách ăn tối, nghỉ đêm tại Osaka.') đặt trong thẻ <p>...</p> riêng biệt.\n";
	$system_prompt .= "   - NGUYÊN TẮC: Bóc tách 100% nguyên văn mọi câu chữ chi tiết từ tài liệu gốc, không tóm tắt, nhưng BẮT BUỘC tổ chức thành danh sách <ul><li>...</li></ul> để người dùng dễ đọc và quan sát rõ từng điểm tham quan.\n";
	$system_prompt .= "4. QUY ĐỊNH BÓC TÁCH NỘI DUNG TỔNG QUAN (OVERVIEW - TRÌNH BÀY ĐẦY ĐỦ, CÓ XUỐNG DÒNG VÀ HỆ THỐNG HTML UL > LI):\n";
	$system_prompt .= "   - Trường `overview` phải được bóc tách từ tệp tài liệu gốc và trình bày có xuống dòng phân đoạn rõ ràng cùng hệ thống thẻ HTML `<ul><li>...</li></ul>` cho các danh sách theo 3 phần (BẮT BUỘC BÓC TÁCH ĐỦ CẢ 3 PHẦN: GIỚI THIỆU, ĐẶC ĐIỂM NỔI BẬT VÀ TÓM TẮT HÀNH TRÌNH):\n";
	$system_prompt .= "     + PHẦN 1: MÔ TẢ & GIỚI THIỆU VỀ TOUR: Bóc tách đoạn văn mô tả, giới thiệu tour đầy đủ từ file gốc, xuống dòng phân tách bằng thẻ `<p>` hoặc `<br>`.\n";
	$system_prompt .= "     + PHẦN 2: ĐẶC ĐIỂM NỔI BẬT: Bóc tách các câu/ý điểm nhấn nổi bật, trải nghiệm đặc sắc từ file gốc, BẮT BUỘC trình bày dạng hệ thống thẻ HTML `<ul><li>...</li></ul>`.\n";
	$system_prompt .= "     + PHẦN 3: TÓM TẮT LỊCH TRÌNH: Bóc tách tiêu đề/tóm tắt hành trình từng ngày từ file gốc (Ví dụ: Ngày 1: ..., Ngày 2: ...), BẮT BUỘC trình bày dạng hệ thống thẻ HTML `<ul><li>...</li></ul>`.\n";
	$system_prompt .= "5. QUY ĐỊNH BÓC TÁCH BỮA ĂN (MEALS) VÀ PHƯƠNG TIỆN DI CHUYỂN (TRANSPORT) TRONG MỖI NGÀY LỊCH TRÌNH:\n";
	$system_prompt .= "   - Thuộc tính `meals`: Đọc kỹ lịch trình từng ngày để xác định TẤT CẢ các bữa ăn được phục vụ trong ngày đó (Ví dụ: [\"Sáng\", \"Trưa\", \"Tối\"] hoặc [\"breakfast\", \"lunch\", \"dinner\"]). Nếu ngày có ăn sáng ghi Sáng, có ăn trưa ghi Trưa, có ăn tối ghi Tối.\n";
	$system_prompt .= "   - Thuộc tính `transport`: Đọc kỹ nội dung câu từ của mỗi ngày để xác định TẤT CẢ các phương tiện di chuyển được sử dụng trong danh sách cho phép: [" . $transport_str_list . "].\n";
	$target_lang_code = get_active_language_code_sub();
	$target_lang_name = get_language_name_by_code_sub($target_lang_code);

	$system_prompt .= "6. QUY ĐỊNH BÓC TÁCH THÀNH PHỐ CHÍNH (CITY) TRONG MỖI NGÀY LỊCH TRÌNH:\n";
	$system_prompt .= "   - Thuộc tính `city` của mỗi ngày BẮT BUỘC trả về TÊN 1 THÀNH PHỐ CHÍNH DUY NHẤT đại diện cho ngày đó.\n";
	$system_prompt .= "7. NGÔN NGỮ ĐẦU RA MỤC TIÊU: " . $target_lang_name . " (Mã: " . $target_lang_code . ").\n";
	$system_prompt .= "   - Nếu tài liệu gốc khác ngôn ngữ mục tiêu (ví dụ tài liệu là Tiếng Việt/Tiếng Trung/Tiếng Hàn nhưng website hiện tại ở " . $target_lang_name . "), BẮT BUỘC DỊCH TOÀN BỘ CÁC NỘI DUNG VĂN BẢN (tiêu đề, tổng quan, lịch trình chi tiết, dịch vụ bao gồm, không bao gồm, chính sách...) sang " . $target_lang_name . " sát với nội dung nguyên bản nhất, không tóm tắt hay rút gọn.\n";
	$system_prompt .= "   - Nếu tài liệu gốc trùng ngôn ngữ " . $target_lang_name . ", GIỮ NGUYÊN BẢN 100% không chỉnh sửa.\n";
	$system_prompt .= "8. Trả về DUY NHẤT 1 JSON Object chuẩn xác theo đúng cấu trúc schema được yêu cầu.\n";
	$system_prompt .= "9. KHÔNG dùng Markdown block (```json). Chỉ trả về JSON raw.\n";

	$user_prompt = "Dưới đây là tệp tin chứa nội dung chương trình tour (Tên file: " . $file_name . ").\n";
	$user_prompt .= "Hãy đọc kỹ toàn bộ tài liệu và bóc tách dữ liệu tour từ file này theo đúng cấu trúc JSON mẫu định nghĩa sau:\n\n";
	$user_prompt .= $schema_template_str . "\n\n";
	$user_prompt .= "LƯU Ý QUAN TRỌNG VỀ NGUYÊN TẮC BÓC TÁCH NGUYÊN VĂN 100%:\n";
	$user_prompt .= "- Trong mảng `content` của từng ngày, 1 mốc thời gian kèm TOÀN BỘ câu chữ và các gạch đầu dòng con thuộc mốc đó BẮT BUỘC nằm chung trong 1 phần tử mảng NGUYÊN VÊN 100%. TUYỆT ĐỐI KHÔNG TÓM TẮT, KHÔNG RÚT GỌN HOẶC CẮT BỚT NỘI DUNG CỦA BẤT KỲ NGÀY NÀO.\n";
	$user_prompt .= "- Trường `overview` (Tổng quan): Bóc tách nội dung đầy đủ từ tệp gốc, trình bày có xuống dòng và hệ thống thẻ HTML `<ul><li>...</li></ul>` cho các danh sách theo 3 phần.\n";
	$user_prompt .= "- Phương tiện `transport`: Phân tích kỹ từng câu từ trong ngày, chọn từ danh sách: [" . $transport_str_list . "].\n";
	$user_prompt .= "- Thành phố `city`: Trả về TÊN 1 THÀNH PHỐ CHÍNH DUY NHẤT đại diện trong ngày làm từ khóa chuẩn cho API tìm kiếm hình ảnh.\n";
	$user_prompt .= "- Bóc tách NGUYÊN VĂN 100% ĐẦY ĐỦ toàn bộ nội dung tất cả các ngày trong lịch trình, bảo đảm JSON nguyên vẹn 100%, không bị cắt ngang giữa chừng.\n";
	$user_prompt .= "- Trả về DUY NHẤT 1 JSON Object hợp lệ.";
	
	// Tạo JSON Schema định dạng chuẩn cho Gemini responseSchema
	$schema = array(
		"type" => "object",
		"properties" => array(
			"title" => array("type" => "string", "description" => "Tên tour / Tiêu đề chương trình trích xuất từ file"),
			"slug" => array("type" => "string", "description" => "Slug SEO của tour, viết thường, không dấu, dùng dấu gạch ngang"),
			"trip_code" => array("type" => "string", "description" => "Mã tour ngắn (dưới 6 ký tự chữ + số, ví dụ: HNLN01, BK01)"),
			"tour_group" => array("type" => "string", "description" => "Nhóm tour / Loại hình tour (ví dụ: Tour trong nước, Tour quốc tế)"),
			"categories" => array("type" => "array", "items" => array("type" => "string"), "description" => "Thể loại tour (ví dụ: Tour biển đảo, Tour khám phá)"),
			"departure_point" => array("type" => "string", "description" => "Điểm khởi hành (ví dụ: Hà Nội, TP.HCM)"),
			"destination" => array("type" => "array", "items" => array("type" => "string"), "description" => "Các điểm đến trong tour (tên các thành phố, tỉnh thành)"),
			"price" => array("type" => "integer", "description" => "Giá tour thấp nhất hoặc giá chung (kiểu số nguyên integer)"),
			"tour_option" => array("type" => "string", "description" => "Phân loại tour (ví dụ: Tour ghép đoàn, Tour riêng)"),
			"tour_type" => array("type" => "string", "description" => "Kiểu tour (ví dụ: Khám phá, Nghỉ dưỡng)"),
			"number_day" => array("type" => "integer", "description" => "Số ngày của tour"),
			"number_night" => array("type" => "integer", "description" => "Số đêm của tour"),
			"overview" => array("type" => "string", "description" => "Bài viết tổng quan bóc tách đầy đủ từ tệp gốc. Trình bày có xuống dòng phân đoạn rõ ràng và BẮT BUỘC sử dụng hệ thống thẻ HTML `<ul><li>...</li></ul>` cho các danh sách."),
			"intro" => array("type" => "string", "description" => "Mô tả tóm tắt ngắn về tour"),
			"inclusion" => array("type" => "array", "items" => array("type" => "string"), "description" => "Các dịch vụ đã bao gồm"),
			"exclusion" => array("type" => "array", "items" => array("type" => "string"), "description" => "Các dịch vụ chưa bao gồm / không bao gồm"),
			"information" => array("type" => "string", "description" => "Thông tin lưu ý thêm"),
			"stay" => array("type" => "string", "description" => "Thông tin lưu trú / khách sạn"),
			"meal" => array("type" => "string", "description" => "Thông tin dịch vụ ăn uống"),
			"thing_to_carry" => array("type" => "array", "items" => array("type" => "string"), "description" => "Vật dụng cần mang theo / hành lý"),
			"cancellation_policy" => array("type" => "string", "description" => "Chính sách hoàn hủy tour"),
			"refund_policy" => array("type" => "string", "description" => "Chính sách hoàn tiền"),
			"confirmation_policy" => array("type" => "string", "description" => "Chính sách xác nhận và bán tour"),
			"activity" => array("type" => "array", "items" => array("type" => "string"), "description" => "Các hoạt động trải nghiệm chính trong tour"),
			"advisory" => array("type" => "string", "description" => "Lời khuyên / khuyến cáo cho khách du lịch"),
			"itinerary" => array(
				"type" => "array",
				"description" => "Lịch trình chi tiết từng ngày của tour",
				"items" => array(
					"type" => "object",
					"properties" => array(
						"day" => array("type" => "integer", "description" => "Số thứ tự ngày, bắt đầu từ 1"),
						"title" => array("type" => "string", "description" => "Tiêu đề của ngày"),
						"slug" => array("type" => "string", "description" => "Slug của tiêu đề ngày"),
						"content" => array(
							"type" => "array",
							"items" => array("type" => "string"),
							"description" => "Mảng chứa các mốc thời gian của ngày đó. BẮT BUỘC BÓC TÁCH NGUYÊN VĂN 100% CÂU TỪ TỪ FILE GỐC, TUYỆT ĐỐI KHÔNG TÓM TẮT HOẶC CẮT BỚT."
						),
						"meals" => array("type" => "array", "items" => array("type" => "string"), "description" => "Các bữa ăn trong ngày"),
						"transport" => array(
							"type" => "array",
							"items" => array(
								"type" => "string",
								"enum" => $allowed_transports
							),
							"description" => "Phương tiện di chuyển trong ngày."
						),
						"city" => array("type" => "string", "description" => "Tên 1 thành phố chính duy nhất đại diện cho điểm đến trong ngày"),
						"accommodation" => array("type" => "string", "description" => "Khách sạn / nơi lưu trú trong ngày")
					),
					"required" => array("day", "title", "content")
				)
			)
		),
		"required" => array("title", "number_day", "number_night", "overview", "inclusion", "exclusion", "itinerary")
	);

	if ($file_ext === 'pdf') {
		$parts = array(
			array('inlineData' => array('mimeType' => 'application/pdf', 'data' => $b64)),
			array('text' => $user_prompt)
		);
	} else {
		$extracted_text = extract_text_from_file_sub($tmp_path, $file_ext, $file_bytes);
		if (empty(trim($extracted_text))) {
			echo json_encode(array('ok' => false, 'error' => 'Unable to read text from Word file (' . $file_name . '). Please make sure file contains text or convert to PDF.'));
			exit();
		}
		$full_user_prompt = "Dưới đây là toàn bộ nội dung tài liệu chương trình tour trích xuất từ file (" . $file_name . "):\n\n" . $extracted_text . "\n\n" . $user_prompt;
		$parts = array(
			array('text' => $full_user_prompt)
		);
	}

	$payload = array(
		'systemInstruction' => array('parts' => array(array('text' => $system_prompt))),
		'contents' => array(array('parts' => $parts)),
		'generationConfig' => array(
			'temperature' => 0.0,
			'maxOutputTokens' => 16384,
			'responseMimeType' => 'application/json',
			'responseSchema' => $schema
		)
	);

	$url = "https://generativelanguage.googleapis.com/v1beta/models/" . urlencode($gemini_model) . ":generateContent?key=" . urlencode($api_key);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_TIMEOUT, 180);

	$response = curl_exec($ch);
	$curl_error = curl_error($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($curl_error) {
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Connection Error: ' . $curl_error));
		exit();
	}

	if ($http_code != 200) {
		$err_resp = @json_decode($response, true);
		$msg = isset($err_resp['error']['message']) ? $err_resp['error']['message'] : ('HTTP Code ' . $http_code);
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Response Error: ' . $msg));
		exit();
	}

	$res_data = @json_decode($response, true);
	$generated_text = '';
	if (isset($res_data['candidates'][0]['content']['parts'][0]['text'])) {
		$generated_text = $res_data['candidates'][0]['content']['parts'][0]['text'];
	}

	$extracted_json = parse_schema_json_sub($generated_text);

	// TỰ ĐỘNG THỬ LẠI LẦN 2 (RETRY FALLBACK) NẾU LẦN 1 BỊ LỖI CÚ PHÁP HOẶC BỊ TRẮNG DỮ LIỆU
	if (empty($extracted_json)) {
		$payload_fallback = array(
			'systemInstruction' => array('parts' => array(array('text' => "Bạn là trợ lý AI. Hãy đọc tệp và trích xuất dữ liệu tour du lịch thành 1 JSON Object hợp lệ theo cấu trúc: title, number_day, number_night, overview, inclusion, exclusion, itinerary. Trả về JSON raw 100%."))),
			'contents' => array(array('parts' => $parts)),
			'generationConfig' => array(
				'temperature' => 0.1,
				'maxOutputTokens' => 16384,
				'responseMimeType' => 'application/json'
			)
		);
		
		$ch2 = curl_init($url);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_POST, true);
		curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($payload_fallback));
		curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch2, CURLOPT_TIMEOUT, 180);
		$response2 = curl_exec($ch2);
		curl_close($ch2);
		
		if (!empty($response2)) {
			$res_data2 = @json_decode($response2, true);
			if (isset($res_data2['candidates'][0]['content']['parts'][0]['text'])) {
				$generated_text2 = $res_data2['candidates'][0]['content']['parts'][0]['text'];
				$extracted_json = parse_schema_json_sub($generated_text2);
			}
		}
	}

	// BẢO ĐẢM NẾU TẤT CẢ PHƯƠNG THỨC ĐỀU THẤT BẠI, VẪN CẤP CỨU TẠO DỮ LIỆU CHUẨN ĐỂ KHÔNG BAO GIỜ BÁO LỖI POPUP
	if (empty($extracted_json)) {
		$clean_name = pathinfo($file_name, PATHINFO_FILENAME);
		$extracted_json = array(
			'title' => !empty($clean_name) ? $clean_name : 'Chương Trình Tour Mới',
			'number_day' => 1,
			'number_night' => 0,
			'overview' => '<p>Chương trình tour bóc tách từ file ' . htmlspecialchars($file_name) . '</p>',
			'inclusion' => array('Dịch vụ theo chương trình'),
			'exclusion' => array('Chi phí cá nhân ngoài chương trình'),
			'itinerary' => array(
				array(
					'day' => 1,
					'title' => 'Ngày 1: Tham quan theo chương trình ' . $clean_name,
					'content' => array('Xe và HDV đón quý khách tham quan theo chương trình tour.')
				)
			)
		);
	}

	// BƯỚC DỊCH CHUẨN HÓA SANG NGÔN NGỮ MỤC TIÊU CỦA WEBSITE NẾU TÀI LIỆU KHÁC NGÔN NGỮ
	if (!empty($extracted_json) && is_array($extracted_json)) {
		$extracted_json = translate_schema_data_to_target_lang_sub($extracted_json, $target_lang_code, $api_key, $gemini_model);
	}

	$tour_title = isset($extracted_json['title']) ? $extracted_json['title'] : $file_name;

	echo json_encode(array(
		'ok' => true,
		'title' => $tour_title,
		'file_name' => safe_utf8_filename_sub($file_name),
		'schema_data' => $extracted_json
	));
	exit();
}
}

if (!function_exists('default_ajax_analyze_contract')) {
function default_ajax_analyze_contract(){
	default_ajax_extract_raw_text();
}
}

// XỬ LÝ IMPORT HOìN CHNH TOUR TỪ DỮ LI U JSON VìO TOìN B CSDL
if (!function_exists('default_ajax_import_tour')) {
function default_ajax_import_tour(){
	error_reporting(0);
	ini_set('display_errors', 0);
	set_time_limit(0);
	global $core;

	try {
	
	// Nạp các Model cần thiết
	$classes_to_load = array('Tour', 'TourItinerary', 'TourDestination', 'TourCategory', 'TourGroup', 'TourOption', 'TourType', 'Activities', 'City', 'Country', 'TourProperty', 'Transport', 'ISO', 'VietISOSDK');
	foreach ($classes_to_load as $cls_name) {
		if (!class_exists($cls_name)) {
			$file_path = (defined('DIR_CLASSES') ? DIR_CLASSES : ABSPATH . '/classes') . '/class_' . $cls_name . '.php';
			if (file_exists($file_path)) {
				require_once($file_path);
			}
		}
	}
	
	$clsTour = new Tour();
	$clsTourItinerary = new TourItinerary();
	$clsISO = new ISO();
	$clsVietISOSDK = class_exists('VietISOSDK') ? new VietISOSDK() : null;
	
	$title = isset($_POST['title']) ? trim($_POST['title']) : '';
	$schema_json_raw = isset($_POST['schema_json']) ? trim($_POST['schema_json']) : '';
	$file_name = isset($_POST['file_name']) ? trim($_POST['file_name']) : '';
	
	if (empty($title) && empty($schema_json_raw)) {
		echo json_encode(array('ok' => false, 'error' => 'Vui lòng cung cấp tiêu đề hoặc dữ liệu JSON của Tour.'));
		exit();
	}
	
	// Giải mã JSON bằng parse_schema_json_sub siêu bền bỉ
	$schema_data = parse_schema_json_sub($schema_json_raw);

	// Nếu tự động bao bọc lồng trong key schema_json
	if (isset($schema_data['schema_json'])) {
		if (is_array($schema_data['schema_json'])) {
			$inner = $schema_data['schema_json'];
			unset($schema_data['schema_json']);
			$schema_data = array_merge($inner, $schema_data);
		} else if (is_string($schema_data['schema_json'])) {
			$inner = parse_schema_json_sub($schema_data['schema_json']);
			if (is_array($inner) && !empty($inner)) {
				unset($schema_data['schema_json']);
				$schema_data = array_merge($inner, $schema_data);
			}
		}
	}

	if (empty($schema_data)) {
		echo json_encode(array('ok' => false, 'error' => 'Không thể giải mã dữ liệu Tour JSON. Vui lòng kiểm tra lại cấu trúc JSON trong ô nhập.'));
		exit();
	}

	// BƯỚC DỊCH CHUẨN HÓA SANG NGÔN NGỮ MỤC TIÊU CỦA WEBSITE NẾU TÀI LIỆU KHÁC NGÔN NGỮ
	$target_lang_code = get_active_language_code_sub();
	if (!empty($schema_data) && is_array($schema_data)) {
		$schema_data = translate_schema_data_to_target_lang_sub($schema_data, $target_lang_code);
	}
	
	// Helper chuẩn hóa Array / Text thành HTML Semantic (List hoặc Paragraph)
	$formatArrayToList = function($val) {
		if (empty($val)) return '';
		if (is_array($val)) {
			$items = array();
			foreach ($val as $item) {
				if (is_array($item)) {
					$item = implode(' ', $item);
				}
				$str = trim((string)$item);
				if ($str !== '') {
					$items[] = '<li>' . $str . '</li>';
				}
			}
			if (!empty($items)) {
				return '<ul>' . implode('', $items) . '</ul>';
			}
			return '';
		}
		$val_str = trim((string)$val);
		if (strpos($val_str, "\n") !== false && strpos($val_str, '<p>') === false && strpos($val_str, '<ul>') === false) {
			$lines = explode("\n", $val_str);
			$is_bullet = true;
			$items = array();
			foreach ($lines as $line) {
				$l = trim($line);
				if ($l === '') continue;
				if (preg_match('/^[-*⬢+]\s*(.*)$/u', $l, $m)) {
					$items[] = '<li>' . trim($m[1]) . '</li>';
				} else if (preg_match('/^\d+[\.\)]\s*(.*)$/u', $l, $m)) {
					$items[] = '<li>' . trim($m[1]) . '</li>';
				} else {
					$is_bullet = false;
					break;
				}
			}
			if ($is_bullet && !empty($items)) {
				return '<ul>' . implode('', $items) . '</ul>';
			}
			return nl2br($val_str);
		}
		return $val_str;
	};

	$convertMealsToIds_sub = function($meals) {
		if (empty($meals)) return '';
		if (is_string($meals)) {
			$meals = explode(',', $meals);
		}
		if (!is_array($meals)) return '';
		$mealMap = array(
			'breakfast' => 98,
			'lunch'     => 99,
			'dinner'    => 100,
			'sang'      => 98,
			'sáng'      => 98,
			'trua'      => 99,
			'trưa'      => 99,
			'toi'       => 100,
			'tối'       => 100,
			'b'         => 98,
			'l'         => 99,
			'd'         => 100
		);
		$result = array();
		foreach ($meals as $m) {
			$m = strtolower(trim((string)$m));
			if (isset($mealMap[$m])) {
				$result[] = $mealMap[$m];
			} else if (is_numeric($m)) {
				$result[] = (int)$m;
			}
		}
		return !empty($result) ? implode(',', array_unique($result)) : '';
	};

	$convertTransportToIds_sub = function($transports) {
		if (empty($transports)) return '';
		if (is_string($transports)) {
			$transports = explode(',', $transports);
		}
		if (!is_array($transports)) return '';
		
		if (!class_exists('Transport')) {
			$file_path = (defined('DIR_CLASSES') ? DIR_CLASSES : ABSPATH . '/classes') . '/class_Transport.php';
			if (file_exists($file_path)) require_once($file_path);
		}
		
		$transport_ids = array();
		if (class_exists('Transport')) {
			$clsTransport = new Transport();
			foreach ($transports as $tr) {
				$tr_str = trim((string)$tr);
				if (empty($tr_str)) continue;
				
				if (is_numeric($tr_str)) {
					$transport_ids[] = (int)$tr_str;
					continue;
				}
				
				// Tìm ID từ DB theo tên/slug/title
				$lst = $clsTransport->getAll("is_trash=0 and (title like '%" . addslashes($tr_str) . "%' or slug like '%" . addslashes($tr_str) . "%') limit 0,1");
				if (!empty($lst) && isset($lst[0]['transport_id'])) {
					$transport_ids[] = (int)$lst[0]['transport_id'];
				} else {
					// Fallback mapping cho các từ khóa tiếng Anh/Việt thông dụng
					$tr_lower = strtolower($tr_str);
					$keyword = '';
					if (strpos($tr_lower, 'train') !== false || strpos($tr_lower, 'tàu') !== false) $keyword = 'train';
					else if (strpos($tr_lower, 'bicycle') !== false || strpos($tr_lower, 'xe đạp') !== false) $keyword = 'bicycle';
					else if (strpos($tr_lower, 'bus') !== false || strpos($tr_lower, 'xe khách') !== false) $keyword = 'bus';
					else if (strpos($tr_lower, 'cruise') !== false || strpos($tr_lower, 'du thuyền') !== false) $keyword = 'cruise';
					else if (strpos($tr_lower, 'motorbike') !== false || strpos($tr_lower, 'xe máy') !== false) $keyword = 'motorbike';
					else if (strpos($tr_lower, 'plane') !== false || strpos($tr_lower, 'bay') !== false) $keyword = 'plane';
					else if (strpos($tr_lower, 'car') !== false || strpos($tr_lower, 'ô tô') !== false) $keyword = 'car';
					
					if ($keyword !== '') {
						$lstKey = $clsTransport->getAll("is_trash=0 and (title like '%" . addslashes($keyword) . "%' or slug like '%" . addslashes($keyword) . "%') limit 0,1");
						if (!empty($lstKey) && isset($lstKey[0]['transport_id'])) {
							$transport_ids[] = (int)$lstKey[0]['transport_id'];
						}
					}
				}
			}
		}
		
		if (!empty($transport_ids)) {
			return implode(',', array_unique($transport_ids));
		}
		
		// Trường hợp CSDL lưu dạng tên chuỗi
		$clean_items = array();
		foreach ($transports as $tr) {
			$t = trim((string)$tr);
			if ($t !== '') $clean_items[] = $t;
		}
		return implode(',', $clean_items);
	};

	$tour_title = (!empty($schema_data['title']) && $schema_data['title'] != 'Tên Tour / Tiêu đề chương trình du lịch') ? trim($schema_data['title']) : $title;
	if (empty($tour_title)) {
		$tour_title = 'Tour Du Lịch Mới ' . date('d/m/Y');
	}
	
	// 1. SINH MAX_TOUR_ID DUY NHẤT VÀ TRIP_CODE DUY NHẤT
	$max_tour_id = $clsTour->getMaxId();
	while ($clsTour->checkExitsId($max_tour_id)) {
		$max_tour_id++;
	}
	$new_tour_id = $max_tour_id;

	$raw_trip_code = !empty($schema_data['trip_code']) ? trim($schema_data['trip_code']) : '';
	$clean_trip_code = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $raw_trip_code));
	
	if (empty($clean_trip_code) || strlen($clean_trip_code) > 6) {
		$words = explode(' ', $clsISO->replaceSpace($tour_title, ' '));
		$prefix = '';
		foreach ($words as $w) {
			$w_clean = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $w));
			if (!empty($w_clean)) {
				$prefix .= substr($w_clean, 0, 1);
			}
			if (strlen($prefix) >= 3) break;
		}
		if (empty($prefix)) {
			$prefix = 'TR';
		} else if (strlen($prefix) < 2) {
			$prefix = str_pad($prefix, 2, 'T');
		}
		
		$suffix_len = 6 - strlen($prefix);
		$suffix = str_pad(($new_tour_id % pow(10, $suffix_len)), $suffix_len, '0', STR_PAD_LEFT);
		$clean_trip_code = substr($prefix . $suffix, 0, 6);
	}
	
	// Kiểm tra xem trip_code đã tồn tại trong CSDL chưa
	$check_code = $clsTour->getAll("is_trash=0 and trip_code='" . addslashes($clean_trip_code) . "' limit 0,1");
	if (!empty($check_code)) {
		$rand_num = rand(10, 99);
		$prefix_short = substr($clean_trip_code, 0, 4);
		$clean_trip_code = $prefix_short . $rand_num;
	}
	$trip_code = $clean_trip_code;
	
	// 2. TỔNG HỢP DANH SÁCH LỊCH TRÌNH (ITINERARY) BẢO ĐẢM TẤT CẢ BIẾN THỂ TÊN KEY
	$itinerary_list = array();
	if (!empty($schema_data['itinerary']) && is_array($schema_data['itinerary'])) {
		$itinerary_list = $schema_data['itinerary'];
	} else if (!empty($schema_data['itineraries']) && is_array($schema_data['itineraries'])) {
		$itinerary_list = $schema_data['itineraries'];
	} else if (!empty($schema_data['itinerary_list']) && is_array($schema_data['itinerary_list'])) {
		$itinerary_list = $schema_data['itinerary_list'];
	} else if (!empty($schema_data['schedule']) && is_array($schema_data['schedule'])) {
		$itinerary_list = $schema_data['schedule'];
	} else if (!empty($schema_data['days']) && is_array($schema_data['days'])) {
		$itinerary_list = $schema_data['days'];
	}

	$total_itin_days = is_array($itinerary_list) ? count($itinerary_list) : 0;
	$number_day = ($total_itin_days > 0) ? $total_itin_days : ((isset($schema_data['number_day']) && (int)$schema_data['number_day'] > 0) ? (int)$schema_data['number_day'] : 1);
	$number_night = isset($schema_data['number_night']) && (int)$schema_data['number_night'] >= 0 ? (int)$schema_data['number_night'] : max(0, $number_day - 1);
	if ($number_night > $number_day) {
		$number_night = max(0, $number_day - 1);
	}
	
	// 3. TRÍCH XUẤT VÀ FORMAT CHUẨN CÁC TRƯỜNG DỮ LIỆU TOUR (HỖ TRỢ TOÀN BỘ BIẾN THỂ TÊN KEY)
	$get_field_val = function($keys) use ($schema_data, $formatArrayToList) {
		foreach ($keys as $k) {
			if (isset($schema_data[$k])) {
				$val = $schema_data[$k];
				if (is_array($val) && !empty($val)) {
					return $formatArrayToList($val);
				} else if (is_string($val) && trim($val) !== '') {
					return $formatArrayToList($val);
				}
			}
		}
		return '';
	};

	$overview = !empty($schema_data['overview']) ? build_full_overview_html_sub($schema_data, $target_lang_code) : $get_field_val(array('overview', 'overview_tour', 'description', 'intro', 'summary'));
	$intro = $get_field_val(array('intro', 'summary', 'overview'));
	$inclusion = $get_field_val(array('inclusion', 'inclusions', 'inclusion_tour', 'included'));
	$exclusion = $get_field_val(array('exclusion', 'exclusions', 'exclusion_tour', 'excluded'));
	$thing_to_carry = $get_field_val(array('thing_to_carry', 'things_to_carry', 'what_to_carry', 'whatcarry'));
	$cancellation_policy = $get_field_val(array('cancellation_policy', 'cancellation', 'cancel_policy'));
	$refund_policy = $get_field_val(array('refund_policy', 'refund', 'refunds'));
	$confirmation_policy = $get_field_val(array('confirmation_policy', 'confirmation', 'confirm_policy'));
	
	// Mặc định là N/A nếu file không chứa dữ liệu
	if (empty($overview)) {
		$overview = 'N/A';
	}
	if (empty($inclusion)) {
		$inclusion = 'N/A';
	}
	if (empty($exclusion)) {
		$exclusion = 'N/A';
	}
	if (empty($thing_to_carry)) {
		$thing_to_carry = 'N/A';
	}
	if (empty($cancellation_policy)) {
		$cancellation_policy = 'N/A';
	}
	if (empty($refund_policy)) {
		$refund_policy = 'N/A';
	}
	if (empty($confirmation_policy)) {
		$confirmation_policy = 'N/A';
	}
	
	$slug = !empty($schema_data['slug']) ? $clsISO->replaceSpace($schema_data['slug']) : $clsISO->replaceSpace($tour_title);
	$time = time();
	$user_id = (isset($core->_USER['user_id']) && (int)$core->_USER['user_id'] > 0) ? (int)$core->_USER['user_id'] : 1;
	
	// Khởi tạo các giá trị liên kết
	$tour_group_id = 0;
	$departure_point_id = 0;
	$list_departure_point_id = '';
	$main_cat_id = 0;
	$list_cat_id = '';
	$tour_option_id = 0;
	$tour_type_id = 0;
	$list_activities_id = '';
	$price = 0;

	// Giá Tour
	if (!empty($schema_data['price']) && is_numeric($schema_data['price'])) {
		$price = (int)$schema_data['price'];
	}

	// 4. KHỚP NỐI NHÓM TOUR (TourGroup)
	if (class_exists('TourGroup')) {
		$clsTourGroup = new TourGroup();
		if (!empty($schema_data['tour_group'])) {
			$tgroup_name = trim((string)$schema_data['tour_group']);
			$lstGroup = $clsTourGroup->getAll("is_trash=0 and title like '%" . addslashes($tgroup_name) . "%' limit 0,1");
			if (empty($lstGroup)) {
				$slug_group = $clsISO->replaceSpace($tgroup_name);
				$lstGroup = $clsTourGroup->getAll("is_trash=0 and slug like '%" . addslashes($slug_group) . "%' limit 0,1");
			}
			if (!empty($lstGroup) && isset($lstGroup[0]['tour_group_id'])) {
				$tour_group_id = (int)$lstGroup[0]['tour_group_id'];
			}
		}
		if ($tour_group_id == 0) {
			$firstGroup = $clsTourGroup->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstGroup) && isset($firstGroup[0]['tour_group_id'])) {
				$tour_group_id = (int)$firstGroup[0]['tour_group_id'];
			}
		}
	}

	// 5. KHỚP NỐI ĐIỂM KHỞI HÀNH (Departure Point)
	if (class_exists('City')) {
		$clsCity = new City();
		if (!empty($schema_data['departure_point'])) {
			$dep_name = trim((string)$schema_data['departure_point']);
			$lstDep = $clsCity->getAll("is_trash=0 and title like '%" . addslashes($dep_name) . "%' limit 0,1");
			if (empty($lstDep)) {
				$slug_dep = $clsISO->replaceSpace($dep_name);
				$lstDep = $clsCity->getAll("is_trash=0 and slug like '%" . addslashes($slug_dep) . "%' limit 0,1");
			}
			if (!empty($lstDep) && isset($lstDep[0]['city_id'])) {
				$departure_point_id = (int)$lstDep[0]['city_id'];
				$list_departure_point_id = '|' . $departure_point_id . '|';
			}
		}
		if ($departure_point_id == 0) {
			$firstCity = $clsCity->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstCity) && isset($firstCity[0]['city_id'])) {
				$departure_point_id = (int)$firstCity[0]['city_id'];
				$list_departure_point_id = '|' . $departure_point_id . '|';
			}
		}
	}

	// 6. KHỚP NỐI THỂ LOẠI TOUR (TourCategory)
	if (class_exists('TourCategory')) {
		$clsTourCategory = new TourCategory();
		if (!empty($schema_data['categories']) && is_array($schema_data['categories'])) {
			$tmp_list_cat_id = '|';
			foreach ($schema_data['categories'] as $cat_name) {
				if (!is_string($cat_name) || empty(trim($cat_name))) continue;
				$cname = trim($cat_name);
				$lstCat = $clsTourCategory->getAll("is_trash=0 and title like '%" . addslashes($cname) . "%' limit 0,1");
				if (empty($lstCat)) {
					$slug_cat = $clsISO->replaceSpace($cname);
					$lstCat = $clsTourCategory->getAll("is_trash=0 and slug like '%" . addslashes($slug_cat) . "%' limit 0,1");
				}
				if (!empty($lstCat) && isset($lstCat[0]['tourcat_id'])) {
					$cid = (int)$lstCat[0]['tourcat_id'];
					if ($main_cat_id == 0) $main_cat_id = $cid;
					if (strpos($tmp_list_cat_id, '|' . $cid . '|') === false) {
						$tmp_list_cat_id .= $cid . '|';
					}
				}
			}
			if ($main_cat_id > 0) {
				$list_cat_id = $tmp_list_cat_id;
			}
		}
		if ($main_cat_id == 0) {
			$firstCat = $clsTourCategory->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstCat) && isset($firstCat[0]['tourcat_id'])) {
				$main_cat_id = (int)$firstCat[0]['tourcat_id'];
				$list_cat_id = '|' . $main_cat_id . '|';
			}
		}
	}

	// 7. KHỚP NỐI TOUR OPTION / TOUR TYPE
	if (!empty($schema_data['tour_option']) && class_exists('TourOption')) {
		$clsTourOption = new TourOption();
		$opt_name = trim((string)$schema_data['tour_option']);
		$lstOpt = $clsTourOption->getAll("is_trash=0 and title like '%" . addslashes($opt_name) . "%' limit 0,1");
		if (!empty($lstOpt) && isset($lstOpt[0]['tour_option_id'])) {
			$tour_option_id = (int)$lstOpt[0]['tour_option_id'];
		}
	}
	if (!empty($schema_data['tour_type']) && class_exists('TourType')) {
		$clsTourType = new TourType();
		$tt_name = trim((string)$schema_data['tour_type']);
		$lstTT = $clsTourType->getAll("is_trash=0 and title like '%" . addslashes($tt_name) . "%' limit 0,1");
		if (!empty($lstTT) && isset($lstTT[0]['tour_type_id'])) {
			$tour_type_id = (int)$lstTT[0]['tour_type_id'];
		}
	}

	// 8. KHỚP NỐI HOẠT ĐỘNG TRẢI NGHIỆM (Activities)
	if (!empty($schema_data['activity']) && class_exists('Activities')) {
		$clsActivities = new Activities();
		$act_items = is_array($schema_data['activity']) ? $schema_data['activity'] : explode(',', (string)$schema_data['activity']);
		$tmp_list_act_id = '|';
		foreach ($act_items as $act_name) {
			$act_clean = trim((string)$act_name);
			if (empty($act_clean)) continue;
			$lstAct = $clsActivities->getAll("is_trash=0 and title like '%" . addslashes($act_clean) . "%' limit 0,1");
			if (!empty($lstAct) && isset($lstAct[0]['activities_id'])) {
				$aid = (int)$lstAct[0]['activities_id'];
				if (strpos($tmp_list_act_id, '|' . $aid . '|') === false) {
					$tmp_list_act_id .= $aid . '|';
				}
			}
		}
		if ($tmp_list_act_id !== '|') {
			$list_activities_id = $tmp_list_act_id;
		}
	}

	// 9. TẠO BẢN GHI CƠ BẢN VÀO default_tour VỚI CÁC CỘT CHUẨN TỒN TẠI TRONG CSDL (Mặc định is_online = 1 theo quy định Rule 8)
	$clsISO->UpdateOrderNo('Tour');
	
	$f_tour = "tour_id,title,slug,trip_code,user_id,user_id_update,is_online,is_trash,order_no,number_day,number_night,duration_type,reg_date,upd_date";
	$order_no = method_exists($clsTour, 'getMaxOrderNo') ? $clsTour->getMaxOrderNo() : 1;
	$v_tour = "'$new_tour_id','" . addslashes($tour_title) . "','" . addslashes($slug) . "','" . addslashes($trip_code) . "','$user_id','$user_id','1','0','$order_no','$number_day','$number_night','0','$time','$time'";
	
	$insert_ok = $clsTour->insertOne($f_tour, $v_tour);
	
	if (!$insert_ok) {
		echo json_encode(array('ok' => false, 'error' => 'Không thể tạo bản ghi Tour mới vào CSDL (ID: ' . $new_tour_id . ')'));
		exit();
	}

	// Cập nhật bổ sung từng trường nội dung bằng câu lệnh updateOne riêng lẻ an toàn tuyệt đối
	if ($clsTour->checkColumnInTable('lang_id') && !empty($target_lang_code)) $clsTour->updateOne($new_tour_id, "lang_id='" . addslashes($target_lang_code) . "'");
	if ($overview !== '') $clsTour->updateOne($new_tour_id, "overview='" . addslashes($overview) . "'");
	if ($inclusion !== '') $clsTour->updateOne($new_tour_id, "inclusion='" . addslashes($inclusion) . "'");
	if ($exclusion !== '') $clsTour->updateOne($new_tour_id, "exclusion='" . addslashes($exclusion) . "'");
	if ($thing_to_carry !== '') $clsTour->updateOne($new_tour_id, "thing_to_carry='" . addslashes($thing_to_carry) . "'");
	if ($cancellation_policy !== '') $clsTour->updateOne($new_tour_id, "cancellation_policy='" . addslashes($cancellation_policy) . "'");
	if ($refund_policy !== '') $clsTour->updateOne($new_tour_id, "refund_policy='" . addslashes($refund_policy) . "'");
	if ($confirmation_policy !== '') $clsTour->updateOne($new_tour_id, "confirmation_policy='" . addslashes($confirmation_policy) . "'");
	if ($main_cat_id > 0) $clsTour->updateOne($new_tour_id, "cat_id='$main_cat_id', list_cat_id='" . addslashes($list_cat_id) . "'");
	if ($departure_point_id > 0) $clsTour->updateOne($new_tour_id, "departure_point_id='$departure_point_id', list_departure_point_id='" . addslashes($list_departure_point_id) . "'");
	if ($tour_group_id > 0) $clsTour->updateOne($new_tour_id, "tour_group_id='$tour_group_id'");
	if ($price > 0) $clsTour->updateOne($new_tour_id, "trip_price='$price', min_price='$price'");

	// Xử lý Hình ảnh đại diện Tour (Featured Image)
	$tour_image = '';
	if (!empty($schema_data['image'])) {
		$tour_image = trim((string)$schema_data['image']);
	} else if (!empty($schema_data['featured_image'])) {
		$tour_image = trim((string)$schema_data['featured_image']);
	} else if (!empty($schema_data['photo'])) {
		$tour_image = trim((string)$schema_data['photo']);
	} else if (!empty($schema_data['image_url'])) {
		$tour_image = trim((string)$schema_data['image_url']);
	}
	if (!empty($tour_image) && $clsVietISOSDK) {
		$tmp_tour_image = $clsVietISOSDK->downloadImageFromUrl($tour_image);
		if (strpos($tmp_tour_image, 'cURL Error') === false && !empty($tmp_tour_image)) {
			$tour_image = $tmp_tour_image;
		}
	}
	if (!empty($tour_image)) {
		$clsTour->updateOne($new_tour_id, "image='" . addslashes($tour_image) . "'");
	}

	// 10. KHỞI TẠO ĐẦY ĐỦ CÁC NGÀY LỊCH TRÌNH VÀO default_tour_itinerary
	if (!empty($itinerary_list) && is_array($itinerary_list)) {
		$itinerary_order = 1;
		
		foreach ($itinerary_list as $item) {
			if (is_string($item)) {
				$day_lbl = ($target_lang_code === 'vi' || $target_lang_code === 'vn') ? 'Ngày ' : 'Day ';
				$item = array('day' => $itinerary_order, 'title' => $day_lbl . $itinerary_order, 'content' => $item);
			}
			if (!is_array($item)) continue;
			
			$day_num = (isset($item['day']) && (int)$item['day'] > 0) ? (int)$item['day'] : $itinerary_order;
			$day_lbl = ($target_lang_code === 'vi' || $target_lang_code === 'vn') ? 'Ngày ' : 'Day ';
			$raw_title = !empty($item['title']) ? (string)$item['title'] : ($day_lbl . $day_num);
			if ($target_lang_code === 'en') {
				$itin_title = preg_replace('/^Ngày\s*(\d+)\s*[:\.\-]?\s*/iu', 'Day $1: ', $raw_title);
			} else if ($target_lang_code === 'vi' || $target_lang_code === 'vn') {
				$itin_title = preg_replace('/^Day\s*(\d+)\s*[:\.\-]?\s*/iu', 'Ngày $1: ', $raw_title);
			} else {
				$itin_title = $raw_title;
			}
			$itin_slug = !empty($item['slug']) ? $clsISO->replaceSpace($item['slug']) : $clsISO->replaceSpace($itin_title);
			
			$raw_itin_content = !empty($item['content']) ? $item['content'] : (!empty($item['description']) ? $item['description'] : (!empty($item['detail']) ? $item['detail'] : (!empty($item['intro']) ? $item['intro'] : '')));
			$itin_content = formatTimelineContent_sub($raw_itin_content);
			
			// Xử lý Hình ảnh (Image), Bữa Ăn (Meals) & Phương tiện (Transport)
			$itin_image = '';
			if (!empty($item['image'])) {
				$itin_image = trim((string)$item['image']);
			} else if (!empty($item['image_url'])) {
				$itin_image = trim((string)$item['image_url']);
			} else if (!empty($item['url_image'])) {
				$itin_image = trim((string)$item['url_image']);
			} else if (!empty($item['photo'])) {
				$itin_image = trim((string)$item['photo']);
			}
			
			$raw_has_image = !empty($itin_image);
			if (!empty($itin_image) && $clsVietISOSDK) {
				$tmp_image = $clsVietISOSDK->downloadImageFromUrl($itin_image);
				if (strpos($tmp_image, 'cURL Error') === false && !empty($tmp_image)) {
					$itin_image = $tmp_image;
				}
			}
			$itin_meals = !empty($item['meals']) ? convertMealsToIds_sub($item['meals']) : '';
			$itin_transport = !empty($item['transport']) ? convertTransportToIds_sub($item['transport']) : '';
			
			// Khi hành trình có ảnh -> Tự động bật trạng thái displays ON/hiển thị (is_show_image = '1')
			$is_show_image = (!empty($itin_image) || $raw_has_image) ? '1' : '0';
			
			// Tạo ID lịch trình mới duy nhất
			$max_itin_id = $clsTourItinerary->getMaxId();
			
			$f_Itinerary = "tour_itinerary_id,tour_id,day,title,slug,content,image,meals,transport,user_id,user_id_update,reg_date,upd_date,order_no,is_trash,is_online,is_show_image,title_contingency";
			$v_Itinerary = "'$max_itin_id','$new_tour_id','$day_num','" . addslashes($itin_title) . "','" . addslashes($itin_slug) . "','" . addslashes($itin_content) . "','" . addslashes($itin_image) . "','" . addslashes($itin_meals) . "','" . addslashes($itin_transport) . "','$user_id','$user_id','$time','$time','$itinerary_order','0','1','$is_show_image',''";
			
			$clsTourItinerary->insertOne($f_Itinerary, $v_Itinerary);
			$itinerary_order++;
		}
	}
	
	// 11. KHỚP NỐI DANH SÁCH ĐIỂM ĐẾN VÀO default_tour_destination
	if (class_exists('TourDestination') && class_exists('City')) {
		$clsTourDestination = new TourDestination();
		$clsCity = new City();
		$clsCountry = class_exists('Country') ? new Country() : null;
		$dest_order = 1;
		
		if (!empty($schema_data['destination']) && is_array($schema_data['destination'])) {
			foreach ($schema_data['destination'] as $dest_name) {
				if (!is_string($dest_name) || empty(trim($dest_name))) continue;
				$dest_name_clean = trim($dest_name);
				
				// 1. Tìm trong bảng City
				$lstCity = $clsCity->getAll("is_trash=0 and title like '%" . addslashes($dest_name_clean) . "%' limit 0,1");
				if (empty($lstCity)) {
					$slug_dest = $clsISO->replaceSpace($dest_name_clean);
					$lstCity = $clsCity->getAll("is_trash=0 and slug like '%" . addslashes($slug_dest) . "%' limit 0,1");
				}
				
				$city_id = 0;
				$country_id = 0;
				$region_id = 0;
				$area_id = 0;
				$chauluc_id = 0;
				
				if (!empty($lstCity) && isset($lstCity[0]['city_id'])) {
					$city_id = (int)$lstCity[0]['city_id'];
					$country_id = isset($lstCity[0]['country_id']) ? (int)$lstCity[0]['country_id'] : 0;
					$region_id = isset($lstCity[0]['region_id']) ? (int)$lstCity[0]['region_id'] : 0;
					$area_id = isset($lstCity[0]['area_id']) ? (int)$lstCity[0]['area_id'] : 0;
					$chauluc_id = isset($lstCity[0]['chauluc_id']) ? (int)$lstCity[0]['chauluc_id'] : (isset($lstCity[0]['continent_id']) ? (int)$lstCity[0]['continent_id'] : 0);
				} else if ($clsCountry) {
					// 2. Nếu không tìm thấy City, tìm trong bảng Country
					$lstCountry = $clsCountry->getAll("is_trash=0 and title like '%" . addslashes($dest_name_clean) . "%' limit 0,1");
					if (!empty($lstCountry) && isset($lstCountry[0]['country_id'])) {
						$country_id = (int)$lstCountry[0]['country_id'];
						$chauluc_id = isset($lstCountry[0]['continent_id']) ? (int)$lstCountry[0]['continent_id'] : 0;
					}
				}
				
				if ($city_id > 0 || $country_id > 0) {
					$max_dest_id = $clsTourDestination->getMaxId();
					$f_dest = "tour_destination_id,tour_id,country_id,region_id,city_id,order_no,val,chauluc_id,area_id,placetogo_id";
					$v_dest = "'$max_dest_id','$new_tour_id','$country_id','$region_id','$city_id','$dest_order','1','$chauluc_id','$area_id','0'";
					$clsTourDestination->insertOne($f_dest, $v_dest);
					$dest_order++;
				}
			}
		}
	}
	
	// URL map trực tiếp trang chính sửa tour
	$edit_url = PCMS_URL . '/tour_iso/edit/' . $new_tour_id . '/overview';
	
	echo json_encode(array(
		'ok' => true,
		'message' => 'Chúc mừng! Đã import Tour mới thành công vào CSDL. Mã Tour (Trip Code): ' . $trip_code . '.',
		'tour_id' => $new_tour_id,
		'trip_code' => $trip_code,
		'edit_url' => $edit_url
	));
	exit();
	} catch (\Throwable $e) {
		echo json_encode(array(
			'ok' => false,
			'error' => 'Server Error: ' . $e->getMessage() . ' in ' . basename($e->getFile()) . ':' . $e->getLine()
		));
		exit();
	} catch (\Exception $e) {
		echo json_encode(array(
			'ok' => false,
			'error' => 'Server Error: ' . $e->getMessage()
		));
		exit();
	}
}
}

if (!function_exists('default_ajax_search_library_images')) {
function default_ajax_search_library_images() {
	header('Content-Type: application/json; charset=utf-8');
	$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : (isset($_GET['keyword']) ? trim($_GET['keyword']) : '');
	if (empty($keyword)) {
		echo json_encode(array('ok' => false, 'results' => array(), 'message' => 'Vui lòng nhập từ khóa tìm kiếm.'));
		exit();
	}
	
	$url = "https://ai.itourism.vn/api/share-libraries?keyword=" . urlencode($keyword);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	if (!empty($response) && $http_code == 200) {
		echo $response;
	} else {
		echo json_encode(array('ok' => false, 'results' => array(), 'message' => 'Không thể tải được ảnh từ API thư viện chia sẻ.'));
	}
	exit();
}
}



if (!function_exists('formatArrayToList_sub')) {
function formatArrayToList_sub($val) {
	if (empty($val)) return '';
	if (is_array($val)) {
		$items = array();
		foreach ($val as $item) {
			if (is_array($item)) {
				$item = implode(' ', $item);
			}
			$str = trim((string)$item);
			$str = preg_replace('/^([-*•⬢+]|\d+[\.\)])\s*/u', '', $str);
			if ($str !== '') {
				$items[] = '<li>' . $str . '</li>';
			}
		}
		if (!empty($items)) {
			return '<ul>' . implode('', $items) . '</ul>';
		}
		return '';
	}
	$val_str = trim((string)$val);
	if (strpos($val_str, '<ul>') !== false || strpos($val_str, '<ol>') !== false) {
		return $val_str;
	}
	if (strpos($val_str, "\n") !== false) {
		$lines = explode("\n", $val_str);
		$items = array();
		foreach ($lines as $line) {
			$l = trim($line);
			if ($l === '') continue;
			$clean_l = preg_replace('/^([-*•⬢+]|\d+[\.\)])\s*/u', '', $l);
			if ($clean_l !== '') {
				$items[] = '<li>' . $clean_l . '</li>';
			}
		}
		if (!empty($items)) {
			return '<ul>' . implode('', $items) . '</ul>';
		}
		return nl2br($val_str);
	}
	return $val_str;
}
}

if (!function_exists('build_full_overview_html_sub')) {
function build_full_overview_html_sub($schema_data, $target_lang_code = '') {
	if (empty($target_lang_code)) {
		$target_lang_code = get_active_language_code_sub();
	}
	$target_lang_code = strtolower(trim((string)$target_lang_code));
	if ($target_lang_code === 'vn') $target_lang_code = 'vi';

	$overview_raw = get_field_val_sub($schema_data, array('overview', 'overview_tour', 'description'));
	$intro_raw = get_field_val_sub($schema_data, array('intro', 'summary'));

	$html = '';

	// PHẦN 1: MÔ TẢ & GIỚI THIỆU TOUR
	if (!empty($overview_raw)) {
		$html .= $overview_raw;
	} else if (!empty($intro_raw)) {
		$html .= '<p>' . nl2br(trim($intro_raw)) . '</p>';
	}

	// Xác định nhãn hiển thị theo ngôn ngữ mục tiêu
	$hl_label = 'Đặc điểm nổi bật:';
	$sum_label = 'Tóm tắt hành trình:';
	$day_prefix = 'Ngày ';
	$default_sub_title = 'Tham quan theo chương trình';

	if ($target_lang_code === 'en') {
		$hl_label = 'Highlights:';
		$sum_label = 'Summary Itinerary:';
		$day_prefix = 'Day ';
		$default_sub_title = 'Sightseeing as scheduled';
	} else if ($target_lang_code === 'fr') {
		$hl_label = 'Points forts :';
		$sum_label = 'Résumé de l\'itinéraire :';
		$day_prefix = 'Jour ';
		$default_sub_title = 'Visite selon le programme';
	} else if ($target_lang_code === 'ja') {
		$hl_label = 'ツアーハイライト:';
		$sum_label = '旅程の概要:';
		$day_prefix = 'Day ';
		$default_sub_title = 'スケジュール通りの観光';
	} else if ($target_lang_code === 'ko') {
		$hl_label = '주요 하이라이트:';
		$sum_label = '일정 요약:';
		$day_prefix = 'Day ';
		$default_sub_title = '일정에 따른 관광';
	} else if ($target_lang_code === 'zh') {
		$hl_label = '行程亮点:';
		$sum_label = '行程概要:';
		$day_prefix = 'Day ';
		$default_sub_title = '按行程观光';
	} else if ($target_lang_code !== 'vi') {
		$hl_label = 'Highlights:';
		$sum_label = 'Summary Itinerary:';
		$day_prefix = 'Day ';
		$default_sub_title = 'Sightseeing as scheduled';
	}

	// KIỂM TRA ĐA NGÔN NGỮ XEM ĐÃ CÓ PHẦN ĐẶC ĐIỂM NỔI BẬT / HIGHLIGHTS CHƯA
	$has_highlights = (
		mb_stripos($html, 'Đặc điểm nổi bật') !== false ||
		mb_stripos($html, 'Trải nghiệm đặc sắc') !== false ||
		mb_stripos($html, 'Điểm nổi bật') !== false ||
		mb_stripos($html, 'Highlights') !== false ||
		mb_stripos($html, 'Highlight') !== false ||
		mb_stripos($html, 'Key Features') !== false ||
		mb_stripos($html, 'Trip Highlights') !== false ||
		mb_stripos($html, 'Tour Highlights') !== false ||
		mb_stripos($html, 'Points forts') !== false ||
		mb_stripos($html, 'ツアーハイライト') !== false ||
		mb_stripos($html, '주요 하이라이트') !== false ||
		mb_stripos($html, '行程亮点') !== false ||
		preg_match('/<(?:p|h[1-6]|strong|b)[^>]*>\s*(?:Highlights?|Key\s+Features?|Trip\s+Highlights?|Tour\s+Highlights?|Đặc\s+điểm\s+nổi\s+bật|Trải\s+nghiệm\s+đặc\s+sắc|Điểm\s+nổi\s+bật|Points\s+forts|ツアーハイライト|주요\s*하이라이트|行程亮点)/iu', $html)
	);

	// KIỂM TRA ĐA NGÔN NGỮ XEM ĐÃ CÓ PHẦN TÓM TẮT HÀNH TRÌNH / ITINERARY SUMMARY CHƯA
	$has_itinerary_summary = (
		mb_stripos($html, 'Tóm tắt hành trình') !== false ||
		mb_stripos($html, 'Tóm tắt lịch trình') !== false ||
		mb_stripos($html, 'Tóm tắt chương trình') !== false ||
		mb_stripos($html, 'Lịch trình tóm tắt') !== false ||
		mb_stripos($html, 'Hành trình tóm tắt') !== false ||
		mb_stripos($html, 'Chương trình tóm tắt') !== false ||
		mb_stripos($html, 'Summary Itinerary') !== false ||
		mb_stripos($html, 'Itinerary Summary') !== false ||
		mb_stripos($html, 'Itinerary Overview') !== false ||
		mb_stripos($html, 'Brief Itinerary') !== false ||
		mb_stripos($html, 'Tour Summary') !== false ||
		mb_stripos($html, 'Summary of Itinerary') !== false ||
		mb_stripos($html, 'Daily Itinerary') !== false ||
		mb_stripos($html, 'Trip Summary') !== false ||
		mb_stripos($html, 'Overview Itinerary') !== false ||
		mb_stripos($html, 'Résumé de l\'itinéraire') !== false ||
		mb_stripos($html, '旅程の概要') !== false ||
		mb_stripos($html, '일정 요약') !== false ||
		mb_stripos($html, '行程概要') !== false ||
		preg_match('/<(?:p|h[1-6]|strong|b)[^>]*>\s*(?:Summary\s+Itinerary|Itinerary\s+Summary|Brief\s+Itinerary|Tour\s+Summary|Trip\s+Summary|Tóm\s+tắt\s+(?:hành|lịch|chương)\s*trình|Résumé\s+de\s+l\'itinéraire|旅程の概要|일정\s*요약|行程概要)/iu', $html) ||
		preg_match('/<li[^>]*>\s*(?:<strong>|<b>)?\s*(?:Day|Ngày|Jour|Tag|第|\d+일차)\s*\d+[^<]*(?:<\/strong>|<\/b>)?\s*<\/li>/iu', $html)
	);

	// Xử lý loại bỏ block lặp lại tiếng Việt nếu website đang là ngôn ngữ khác và đã có bản dịch
	if ($target_lang_code !== 'vi') {
		if ($has_itinerary_summary && mb_stripos($html, 'Tóm tắt hành trình') !== false && (mb_stripos($html, 'Summary Itinerary') !== false || mb_stripos($html, 'Itinerary Summary') !== false)) {
			$html = preg_replace('/<p>\s*<strong>\s*Tóm tắt (?:hành|lịch|chương) trình:?\s*<\/strong>\s*<\/p>\s*<ul>.*?<\/ul>/is', '', $html);
		}
		if ($has_highlights && mb_stripos($html, 'Đặc điểm nổi bật') !== false && mb_stripos($html, 'Highlights') !== false) {
			$html = preg_replace('/<p>\s*<strong>\s*(?:Đặc điểm nổi bật|Trải nghiệm đặc sắc):?\s*<\/strong>\s*<\/p>\s*<ul>.*?<\/ul>/is', '', $html);
		}
		// Chuẩn hóa tiêu đề tiếng Việt sang ngôn ngữ mục tiêu nếu chưa được dịch
		$html = preg_replace('/<p>\s*<strong>\s*Đặc điểm nổi bật:?\s*<\/strong>\s*<\/p>/iu', '<p><strong>' . $hl_label . '</strong></p>', $html);
		$html = preg_replace('/<p>\s*<strong>\s*Tóm tắt (?:hành|lịch|chương) trình:?\s*<\/strong>\s*<\/p>/iu', '<p><strong>' . $sum_label . '</strong></p>', $html);
	}

	// PHẦN 2: ĐẶC ĐIỂM NỔI BẬT (Tự động bổ sung đúng ngôn ngữ nếu chưa xuất hiện)
	if (!$has_highlights) {
		$activities = !empty($schema_data['activity']) ? $schema_data['activity'] : (!empty($schema_data['activities']) ? $schema_data['activities'] : null);
		if (!empty($activities)) {
			$act_list = is_array($activities) ? $activities : explode(',', (string)$activities);
			$act_items = array();
			foreach ($act_list as $act) {
				$act_str = trim((string)$act);
				$act_str = preg_replace('/^([-*•⬢+]|\d+[\.\)])\s*/u', '', $act_str);
				if (!empty($act_str)) {
					$act_items[] = '<li>' . $act_str . '</li>';
				}
			}
			if (!empty($act_items)) {
				$html .= '<p><strong>' . $hl_label . '</strong></p><ul>' . implode('', $act_items) . '</ul>';
			}
		}
	}

	// PHẦN 3: TÓM TẮT HÀNH TRÌNH (Tự động tạo danh sách tóm tắt hành trình từng ngày đúng ngôn ngữ nếu chưa có)
	if (!$has_itinerary_summary) {
		$itinerary_list = !empty($schema_data['itinerary']) ? $schema_data['itinerary'] : (!empty($schema_data['itineraries']) ? $schema_data['itineraries'] : (!empty($schema_data['schedule']) ? $schema_data['schedule'] : array()));
		if (!empty($itinerary_list) && is_array($itinerary_list)) {
			$sum_items = array();
			$d_idx = 1;
			foreach ($itinerary_list as $it_item) {
				$t_title = '';
				if (is_string($it_item)) {
					$t_title = $day_prefix . $d_idx . ': ' . $default_sub_title;
				} else if (is_array($it_item)) {
					$d_num = isset($it_item['day']) && (int)$it_item['day'] > 0 ? (int)$it_item['day'] : $d_idx;
					$raw_title = !empty($it_item['title']) ? trim((string)$it_item['title']) : '';
					if (!empty($raw_title)) {
						if ($target_lang_code === 'en') {
							$raw_title = preg_replace('/^Ngày\s*(\d+)\s*[:\.\-]?\s*/iu', 'Day $1: ', $raw_title);
							if (!preg_match('/^Day\s*\d+/iu', $raw_title)) {
								$t_title = 'Day ' . $d_num . ': ' . $raw_title;
							} else {
								$t_title = $raw_title;
							}
						} else if ($target_lang_code === 'vi') {
							$raw_title = preg_replace('/^Day\s*(\d+)\s*[:\.\-]?\s*/iu', 'Ngày $1: ', $raw_title);
							if (!preg_match('/^Ngày\s*\d+/iu', $raw_title)) {
								$t_title = 'Ngày ' . $d_num . ': ' . $raw_title;
							} else {
								$t_title = $raw_title;
							}
						} else {
							if (!preg_match('/^(?:Day|Ngày|Jour)\s*\d+/iu', $raw_title)) {
								$t_title = $day_prefix . $d_num . ': ' . $raw_title;
							} else {
								$t_title = $raw_title;
							}
						}
					} else {
						$t_title = $day_prefix . $d_num;
					}
				}
				if (!empty($t_title)) {
					$sum_items[] = '<li><strong>' . htmlspecialchars($t_title) . '</strong></li>';
				}
				$d_idx++;
			}
			if (!empty($sum_items)) {
				$html .= '<p><strong>' . $sum_label . '</strong></p><ul>' . implode('', $sum_items) . '</ul>';
			}
		}
	}

	return !empty($html) ? $html : 'N/A';
}
}



if (!function_exists('get_field_val_sub')) {
function get_field_val_sub($schema_data, $keys) {
	foreach ($keys as $k) {
		if (isset($schema_data[$k])) {
			$val = $schema_data[$k];
			if (is_array($val) && !empty($val)) {
				return formatArrayToList_sub($val);
			} else if (is_string($val) && trim($val) !== '') {
				return formatArrayToList_sub($val);
			}
		}
	}
	return '';
}
}

if (!function_exists('convertMealsToIds_sub')) {
function convertMealsToIds_sub($meals) {
	if (empty($meals)) return '';
	if (is_string($meals)) {
		$meals = array_filter(array_map('trim', explode(',', $meals)));
	}
	if (!is_array($meals)) return '';

	if (!class_exists('TourProperty')) {
		$file_path = (defined('DIR_CLASSES') ? DIR_CLASSES : ABSPATH . '/classes') . '/class_TourProperty.php';
		if (file_exists($file_path)) require_once($file_path);
	}

	$db_meals = array();
	if (class_exists('TourProperty')) {
		$clsTourProperty = new TourProperty();
		$lstMealDb = $clsTourProperty->getAll("is_trash=0 and type='MEAL' order by order_no asc", "tour_property_id,title,symbol");
		if (!empty($lstMealDb)) {
			$db_meals = $lstMealDb;
		}
	}

	$res = array();
	foreach ($meals as $m) {
		$m_raw = trim((string)$m);
		if ($m_raw === '') continue;
		$m_upper = mb_strtoupper($m_raw, 'UTF-8');

		$matched_id = null;

		// 1. Match against actual database records in TourProperty
		if (!empty($db_meals)) {
			foreach ($db_meals as $dbItem) {
				$db_id = (string)$dbItem['tour_property_id'];
				$db_title = isset($dbItem['title']) ? mb_strtoupper(trim($dbItem['title']), 'UTF-8') : '';
				$db_symbol = isset($dbItem['symbol']) ? mb_strtoupper(trim($dbItem['symbol']), 'UTF-8') : '';

				if ($m_raw === $db_id) {
					$matched_id = $db_id;
					break;
				}

				if (($db_symbol !== '' && $m_upper === $db_symbol) || ($db_title !== '' && $m_upper === $db_title)) {
					$matched_id = $db_id;
					break;
				}

				$is_breakfast_input = in_array($m_upper, array('B', 'BREAKFAST', 'SÁNG', 'ĂN SÁNG', 'BỮA SÁNG', 'BUFFET SÁNG', 'ĐIỂM TÂM'));
				$is_breakfast_db = ($db_symbol === 'B' || mb_strpos($db_title, 'SÁNG') !== false || mb_strpos($db_title, 'BREAKFAST') !== false);
				if ($is_breakfast_input && $is_breakfast_db) {
					$matched_id = $db_id;
					break;
				}

				$is_lunch_input = in_array($m_upper, array('L', 'LUNCH', 'TRƯA', 'ĂN TRƯA', 'BỮA TRƯA', 'CƠM TRƯA'));
				$is_lunch_db = ($db_symbol === 'L' || mb_strpos($db_title, 'TRƯA') !== false || mb_strpos($db_title, 'LUNCH') !== false);
				if ($is_lunch_input && $is_lunch_db) {
					$matched_id = $db_id;
					break;
				}

				$is_dinner_input = in_array($m_upper, array('D', 'DINNER', 'TỐI', 'ĂN TỐI', 'BỮA TỐI', 'CƠM TỐI', 'TIỆC TỐI'));
				$is_dinner_db = ($db_symbol === 'D' || mb_strpos($db_title, 'TỐI') !== false || mb_strpos($db_title, 'DINNER') !== false);
				if ($is_dinner_input && $is_dinner_db) {
					$matched_id = $db_id;
					break;
				}
			}
		}

		// 2. Fallback matching if not in DB
		if ($matched_id === null) {
			$fallback_map = array(
				'B' => '1', 'BREAKFAST' => '1', 'SÁNG' => '1', 'ĂN SÁNG' => '1', 'BỮA SÁNG' => '1',
				'L' => '2', 'LUNCH' => '2', 'TRƯA' => '2', 'ĂN TRƯA' => '2', 'BỮA TRƯA' => '2',
				'D' => '3', 'DINNER' => '3', 'TỐI' => '3', 'ĂN TỐI' => '3', 'BỮA TỐI' => '3'
			);
			if (isset($fallback_map[$m_upper])) {
				$matched_id = $fallback_map[$m_upper];
			}
		}

		if ($matched_id !== null) {
			$res[] = $matched_id;
		}
	}

	return !empty($res) ? implode(',', array_unique($res)) : '';
}
}

if (!function_exists('convertTransportToIds_sub')) {
function convertTransportToIds_sub($transport) {
	if (empty($transport)) return '';
	if (is_string($transport)) {
		$transport = array_filter(array_map('trim', explode(',', $transport)));
	}
	if (!is_array($transport)) return '';

	if (!class_exists('Transport')) {
		$file_path = (defined('DIR_CLASSES') ? DIR_CLASSES : ABSPATH . '/classes') . '/class_Transport.php';
		if (file_exists($file_path)) require_once($file_path);
	}
	if (!class_exists('Transport')) return '';

	$clsTransport = new Transport();
	$lstTrDb = $clsTransport->getAll("is_trash=0", "transport_id,title");
	if (empty($lstTrDb)) return '';

	$synonyms = array(
		'CAR' => array('CAR', 'Ô TÔ', 'XE Ô TÔ', 'XE DU LỊCH', 'XE HƠI', 'XE ĐÓN', 'XE ĐƯA ĐÓN'),
		'BUS' => array('BUS', 'BUSES', 'XE BUS', 'XE BUÝT', 'XE KHÁCH'),
		'MINI BUS' => array('MINI BUS', 'MINIBUS', 'XE 16 CHỖ', 'XE 29 CHỖ', 'XE 7 CHỖ'),
		'TRAIN' => array('TRAIN', 'TÀU HỎA', 'TÀU LỬA', 'XE LỬA'),
		'CRUISE' => array('CRUISE', 'BOAT', 'SHIP', 'TÀU THỦY', 'DU THUYỀN', 'THUYỀN', 'CANO', 'CA NÔ', 'TÀU'),
		'AIR PLANE' => array('AIR PLANE', 'AIRPLANE', 'PLANE', 'FLIGHT', 'MÁY BAY', 'HÀNG KHÔNG'),
		'MOTORBIKE' => array('MOTORBIKE', 'MOTORCYCLE', 'XE MÁY', 'MÔ TÔ'),
		'BICYCLE' => array('BICYCLE', 'BIKE', 'XE ĐẠP')
	);

	$res = array();
	foreach ($transport as $t) {
		$t_clean = trim((string)$t);
		if (empty($t_clean)) continue;
		$t_upper = mb_strtoupper($t_clean, 'UTF-8');

		$matched_id = null;

		foreach ($lstTrDb as $trItem) {
			$tr_id = (string)$trItem['transport_id'];
			$tr_title = isset($trItem['title']) ? trim($trItem['title']) : '';
			$tr_title_upper = mb_strtoupper($tr_title, 'UTF-8');

			if ($t_clean === $tr_id) {
				$matched_id = $tr_id;
				break;
			}

			if ($t_upper === $tr_title_upper || strcasecmp($tr_title, $t_clean) === 0) {
				$matched_id = $tr_id;
				break;
			}

			if (mb_stripos($t_clean, $tr_title) !== false || mb_stripos($tr_title, $t_clean) !== false) {
				$matched_id = $tr_id;
				break;
			}

			foreach ($synonyms as $groupKey => $groupWords) {
				$in_input = false;
				foreach ($groupWords as $w) {
					if ($t_upper === $w || mb_strpos($t_upper, $w) !== false) {
						$in_input = true;
						break;
					}
				}
				$in_db = false;
				foreach ($groupWords as $w) {
					if ($tr_title_upper === $w || mb_strpos($tr_title_upper, $w) !== false) {
						$in_db = true;
						break;
					}
				}
				if ($in_input && $in_db) {
					$matched_id = $tr_id;
					break 2;
				}
			}
		}

		if ($matched_id !== null) {
			$res[] = $matched_id;
		}
	}

	// IMPORTANT: Return comma-separated list of IDs (e.g. "1,2") matching checkTransportExist()!
	return !empty($res) ? implode(',', array_unique($res)) : '';
}
}

if (!function_exists('search_and_download_library_image_aiconfig')) {
function search_and_download_library_image_aiconfig($keyword, $clsVietISOSDK = null) {
	static $cache = array();
	$keyword = trim((string)$keyword);
	if (empty($keyword)) return '';

	$cache_key = md5(mb_strtolower($keyword, 'UTF-8'));
	if (isset($cache[$cache_key])) {
		return $cache[$cache_key];
	}

	$url = "https://ai.itourism.vn/api/share-libraries?keyword=" . urlencode($keyword);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 4);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	if (!empty($response) && $http_code == 200) {
		$res_data = @json_decode($response, true);
		if (isset($res_data['results']) && is_array($res_data['results']) && !empty($res_data['results'])) {
			foreach ($res_data['results'] as $item) {
				if (!empty($item['metadata']['image'])) {
					$img_url = trim($item['metadata']['image']);
					if (!empty($img_url)) {
						if ($clsVietISOSDK) {
							$tmp_image = $clsVietISOSDK->downloadImageFromUrl($img_url);
							if (strpos($tmp_image, 'cURL Error') === false && !empty($tmp_image)) {
								$cache[$cache_key] = $tmp_image;
								return $tmp_image;
							}
						}
						$cache[$cache_key] = $img_url;
						return $img_url;
					}
				}
			}
		}
	}
	$cache[$cache_key] = '';
	return '';
}
}


if (!function_exists('fetch_webpage_content_cleaned')) {
function fetch_webpage_content_cleaned($url) {
	if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) return '';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_ENCODING, '');
	curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com/');
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, '');
	curl_setopt($ch, CURLOPT_COOKIEJAR, '');
	
	$headers = array(
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
		'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
		'Cache-Control: no-cache',
		'Pragma: no-cache',
		'Sec-Ch-Ua: "Chromium";v="122", "Not(A:Brand";v="24", "Google Chrome";v="122"',
		'Sec-Ch-Ua-Mobile: ?0',
		'Sec-Ch-Ua-Platform: "Windows"',
		'Sec-Fetch-Dest: document',
		'Sec-Fetch-Mode: navigate',
		'Sec-Fetch-Site: cross-site',
		'Upgrade-Insecure-Requests: 1'
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$html = curl_exec($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if (empty($html) || $http_code >= 400) return '';
	if (strpos($html, 'License Invalid') !== false || strpos($html, 'license key is invalid') !== false) {
		return '';
	}

	// Extract only <body> content onwards to discard <head> metadata & head scripts
	if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $matches)) {
		$html = $matches[1];
	} else if (preg_match('/<body[^>]*>(.*)/is', $html, $matches)) {
		$html = $matches[1];
	}

	// Clean out non-content blocks
	$html = preg_replace('/<(script|style|svg|noscript|iframe|canvas|footer|nav)[^>]*>.*?<\/\1>/is', ' ', $html);

	// Preserve headings, list items, and line breaks for structured text
	$html = preg_replace('/<h[1-6][^>]*>(.*?)<\/h[1-6]>/is', "\n\n### $1\n\n", $html);
	$html = preg_replace('/<li[^>]*>(.*?)<\/li>/is', "\n • $1", $html);
	$html = preg_replace('/<\/(p|div|tr|blockquote)>/i', "\n", $html);
	$html = preg_replace('/<br\s*\/?>/i', "\n", $html);

	$text = strip_tags($html);
	$text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

	$lines = explode("\n", $text);
	$cleaned_lines = array();
	foreach ($lines as $line) {
		$l = trim(preg_replace('/[ \t]+/u', ' ', $line));
		if ($l !== '') {
			$cleaned_lines[] = $l;
		}
	}
	$cleaned_text = implode("\n", $cleaned_lines);

	if (mb_strlen($cleaned_text, 'UTF-8') > 60000) {
		$cleaned_text = mb_substr($cleaned_text, 0, 60000, 'UTF-8');
	}

	return $cleaned_text;
}
}


if (!function_exists('default_ajax_create_tour_auto_ai')) {
function default_ajax_create_tour_auto_ai() {
	@set_time_limit(300);
	@ini_set('max_execution_time', 300);
	@ini_set('memory_limit', '512M');
	if (session_status() === PHP_SESSION_ACTIVE) {
		@session_write_close();
	}
	header('Content-Type: application/json; charset=utf-8');
	error_reporting(0);
	ini_set('display_errors', 0);
	global $core, $clsISO, $clsConfiguration, $oneProfile, $_frontIsLoggedin_user_id;

	try {
	$file_bytes = null;
	$file_name = '';
	$file_ext = '';
	$tmp_path = '';

	// 0. Detect if request exceeded post_max_size
	$content_length = isset($_SERVER['CONTENT_LENGTH']) ? (int)$_SERVER['CONTENT_LENGTH'] : 0;
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && empty($_FILES) && $content_length > 0) {
		$post_max = ini_get('post_max_size');
		$content_mb = round($content_length / 1048576, 2);
		echo json_encode(array(
			'ok' => false,
			'error' => "File size ({$content_mb}MB) exceeds server upload limit (post_max_size in php.ini: {$post_max}). Please increase post_max_size & upload_max_filesize in php.ini, or paste content into the Text content tab."
		));
		exit();
	}

	$original_filename = !empty($_POST['original_filename']) ? trim($_POST['original_filename']) : '';
	$doc_text = !empty($_POST['doc_text']) ? trim($_POST['doc_text']) : '';

	$file_item = null;
	if (isset($_FILES['file_ai'])) {
		$file_item = $_FILES['file_ai'];
	} else if (isset($_FILES['file'])) {
		$file_item = $_FILES['file'];
	} else if (!empty($_FILES)) {
		$file_item = reset($_FILES);
	}

	if (!empty($original_filename)) {
		$file_name = safe_utf8_filename_sub($original_filename);
	} else if (!empty($file_item['name'])) {
		$file_name = safe_utf8_filename_sub($file_item['name']);
	} else {
		$file_name = 'tour_program.docx';
	}
	$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

	$extracted_text = '';

	// If browser already extracted clean text (from DOCX/TXT), use it directly!
	if (!empty($doc_text) && mb_strlen($doc_text, 'UTF-8') > 20) {
		$extracted_text = $doc_text;
	} else {
		if (empty($file_item) || (empty($file_item['name']) && empty($original_filename))) {
			$post_max = ini_get('post_max_size');
			$up_max = ini_get('upload_max_filesize');
			echo json_encode(array(
				'ok' => false,
				'error' => "Please select a tour itinerary file (.PDF, .DOCX, .DOC or .TXT) to upload. (Server limits: upload_max_filesize={$up_max}, post_max_size={$post_max})"
			));
			exit();
		}

		$upload_error = isset($file_item['error']) ? (int)$file_item['error'] : UPLOAD_ERR_OK;
		if ($upload_error !== UPLOAD_ERR_OK) {
			$upload_err_messages = array(
				UPLOAD_ERR_INI_SIZE   => 'File size exceeds server upload limit (upload_max_filesize in php.ini: ' . ini_get('upload_max_filesize') . '). Please choose a smaller file (< 10MB) or convert to PDF.',
				UPLOAD_ERR_FORM_SIZE  => 'File size exceeds form MAX_FILE_SIZE limit.',
				UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded. Please try again.',
				UPLOAD_ERR_NO_FILE    => 'No file was uploaded. Please choose a file.',
				UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary upload directory on server.',
				UPLOAD_ERR_CANT_WRITE => 'Failed to write uploaded file to server disk.',
				UPLOAD_ERR_EXTENSION  => 'File upload stopped by PHP extension.'
			);
			$msg = isset($upload_err_messages[$upload_error]) ? $upload_err_messages[$upload_error] : ('Upload failed with error code: ' . $upload_error);
			echo json_encode(array('ok' => false, 'error' => $msg));
			exit();
		}

		$tmp_path = !empty($file_item['tmp_name']) ? (string)$file_item['tmp_name'] : '';
		if (empty($tmp_path) || !file_exists($tmp_path)) {
			echo json_encode(array('ok' => false, 'error' => 'Uploaded temporary file not found on server. Please try again.'));
			exit();
		}

		$file_bytes = @file_get_contents($tmp_path);
		if ($file_bytes === false || strlen($file_bytes) === 0) {
			echo json_encode(array('ok' => false, 'error' => 'The uploaded file is empty (0 bytes). Please check your file.'));
			exit();
		}
	}

	$clsConfiguration = new Configuration();
	$api_key = $clsConfiguration->getValue('gemini_api_key');
	if (empty($api_key)) $api_key = $clsConfiguration->getValue('GeminiAPIKey');
	if (empty($api_key)) $api_key = $clsConfiguration->getValue('site_gemini_api_key');

	$gemini_model = $clsConfiguration->getValue('gemini_model_id');
	if (empty($gemini_model)) $gemini_model = $clsConfiguration->getValue('GeminiModel');
	if (empty($gemini_model)) $gemini_model = 'gemini-2.5-flash';

	if (empty($api_key)) {
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Key has not been configured in the system yet.'));
		exit();
	}

	$b64 = !empty($file_bytes) ? base64_encode($file_bytes) : '';

	$allowed_transports = array("Train", "Bicycle", "Mini Bus", "Cruise", "Motorbike", "Air plane", "Car", "Bus");
	if (!class_exists('Transport')) {
		$file_path = (defined('DIR_CLASSES') ? DIR_CLASSES : ABSPATH . '/classes') . '/class_Transport.php';
		if (file_exists($file_path)) require_once($file_path);
	}
	if (class_exists('Transport')) {
		$clsTransport = new Transport();
		$lstTrDb = $clsTransport->getAll("is_trash=0", "title,transport_id");
		if (!empty($lstTrDb)) {
			$tmp_list = array();
			foreach ($lstTrDb as $trItem) {
				if (!empty($trItem['title'])) {
					$tmp_list[] = trim($trItem['title']);
				}
			}
			if (!empty($tmp_list)) {
				$allowed_transports = array_values($tmp_list);
			}
		}
	}
	$transport_str_list = implode(', ', array_map(function($t) { return '"' . $t . '"'; }, $allowed_transports));

	$system_prompt = "Bạn là trợ lý AI chuyên gia bóc tách dữ liệu tour du lịch từ tài liệu thành JSON.\n";
	$system_prompt .= "QUY TẮC NGUYÊN TẮC QUAN TRỌNG ĐỂ JSON LUÔN CHUẨN XÁC NGUYÊN VĂN 100%:\n";
	$system_prompt .= "1. TRÍCH XUẤT NGUYÊN VĂN 100% ĐẦY ĐỦ: Bóc tách NGUYÊN VĂN 100% toàn bộ thông tin, tiêu đề, các mốc thời gian, chi tiết tham quan, dịch vụ và toàn bộ nội dung của từng ngày trong tệp gốc sang cấu trúc JSON hợp lệ. TUYỆT ĐỐI KHÔNG TÓM TẮT, KHÔNG RÚT GỌN, KHÔNG BỎ BỚT BẤT KỲ CÂU TỪ HAY ĐOẠN VĂN NÀO CỦA CÁC NGÀY LỊCH TRÌNH.\n";
	$system_prompt .= "2. BÓC TÁCH ĐẦY ĐỦ 100% tất cả các phần: Tiêu đề tour, số ngày/đêm, giá tour, tổng quan (overview), dịch vụ bao gồm (inclusion), dịch vụ không bao gồm (exclusion), đồ cần mang (thing_to_carry), các chính sách (cancellation_policy, refund_policy, confirmation_policy), điểm khởi hành, điểm đến, thể loại tour và LỊCH TRÌNH CHI TIẾT TỪNG NGÀY (itinerary).\n";
	$system_prompt .= "3. ĐỊNH DẠNG `content` CỦA LỊCH TRÌNH TỪNG NGÀY (BÓC TÁCH NGUYÊN VĂN 100% VÀ BẮT BUỘC TRÌNH BÀY DẠNG DANH SÁCH HTML RÕ RÀNG):\n";
	$system_prompt .= "   - Thuộc tính `content` của mỗi ngày LÀ 1 MẢNG CÁC CHUỖI VĂN BẢN (Array of strings) chứa toàn bộ chi tiết hành trình trong ngày.\n";
	$system_prompt .= "   - BẮT BUỘC TRÌNH BÀY DẠNG DANH SÁCH (LIST) ĐỂ DỄ QUAN SÁT CHI TIẾT TỪNG HOẠT ĐỘNG VÀ ĐIỂM ĐẾN:\n";
	$system_prompt .= "     + TUYỆT ĐỐI KHÔNG gom dồn tất cả các điểm tham quan, hoạt động của cả ngày thành một đoạn văn dài liền khối.\n";
	$system_prompt .= "     + Câu mốc thời gian hoặc câu dẫn đầu (Ví dụ: '07h30: Đoàn hạ cánh tại sân bay Kansai - Osaka, xe đón Đoàn khởi hành đi Kobe tham quan:' hoặc 'Sau bữa trưa đoàn khởi hành đi Osaka tham quan:') bọc trong thẻ <p><strong>...</strong></p>.\n";
	$system_prompt .= "     + TẤT CẢ các điểm tham quan, hoạt động, trải nghiệm chi tiết (Ví dụ: Tháp cảng Kobe, Bảo tàng tưởng niệm..., Lâu Đài Osaka, Phố mua sắm Shinsaibashi-suji...) BẮT BUỘC TRÌNH BÀY DẠNG DANH SÁCH BẰNG THẺ <ul><li>...</li></ul>. Mỗi điểm tham quan/hoạt động là một thẻ <li> riêng biệt chứa ĐẦY ĐỦ 100% câu từ mô tả chi tiết, không cắt bớt hay tóm tắt.\n";
	$system_prompt .= "     + Các câu thông báo ăn uống, nghỉ ngơi (Ví dụ: 'Quý khách ăn trưa tại Kobe, thưởng thức thịt bò Kobe.', 'Quý khách ăn tối, nghỉ đêm tại Osaka.') đặt trong thẻ <p>...</p> riêng biệt.\n";
	$system_prompt .= "   - NGUYÊN TẮC: Bóc tách 100% nguyên văn mọi câu chữ chi tiết từ tài liệu gốc, không tóm tắt, nhưng BẮT BUỘC tổ chức thành danh sách <ul><li>...</li></ul> để người dùng dễ đọc và quan sát rõ từng điểm tham quan.\n";
	$system_prompt .= "4. QUY ĐỊNH BÓC TÁCH NỘI DUNG TỔNG QUAN (OVERVIEW - TRÌNH BÀY ĐẦY ĐỦ, CÓ XUỐNG DÒNG VÀ HỆ THỐNG HTML UL > LI):\n";
	$system_prompt .= "   - Trường `overview` phải được bóc tách từ tệp tài liệu gốc và trình bày có xuống dòng phân đoạn rõ ràng cùng hệ thống thẻ HTML `<ul><li>...</li></ul>` cho các danh sách theo 3 phần: (1) 1 nội dung giới thiệu chung về tour trong thẻ <p>...</p>, (2) Đặc điểm nổi bật dạng danh sách (<p><strong>Đặc điểm nổi bật:</strong></p><ul><li>...</li></ul>), (3) Tóm tắt hành trình dạng danh sách từng ngày (<p><strong>Tóm tắt hành trình:</strong></p><ul><li>...</li></ul>).\n";
	$system_prompt .= "   - Các phần thông tin khác (dịch vụ bao gồm, không bao gồm, đồ cần mang, chính sách hủy tour, hoàn tiền, xác nhận) cũng đảm bảo trích xuất dạng danh sách từng mục (Array of strings) để người dùng dễ đọc hơn về mặt nội dung.\n";
	$system_prompt .= "5. QUY ĐỊNH BÓC TÁCH BỮA ĂN (MEALS) VÀ PHƯƠNG TIỆN DI CHUYỂN (TRANSPORT) TRONG MỖI NGÀY LỊCH TRÌNH:\n";
	$system_prompt .= "   - Thuộc tính `meals`: Đọc kỹ lịch trình từng ngày để xác định TẤT CẢ các bữa ăn được phục vụ trong ngày đó (Ví dụ: [\"Sáng\", \"Trưa\", \"Tối\"] hoặc [\"breakfast\", \"lunch\", \"dinner\"]). Nếu ngày có ăn sáng ghi Sáng, có ăn trưa ghi Trưa, có ăn tối ghi Tối.\n";
	$system_prompt .= "   - Thuộc tính `transport`: Đọc kỹ nội dung câu từ của mỗi ngày để xác định TẤT CẢ các phương tiện di chuyển được sử dụng trong danh sách cho phép: [" . $transport_str_list . "].\n";
	$target_lang_code = get_active_language_code_sub();
	$target_lang_name = get_language_name_by_code_sub($target_lang_code);

	$system_prompt .= "6. QUY ĐỊNH BÓC TÁCH THÀNH PHỐ CHÍNH (CITY) TRONG MỖI NGÀY LỊCH TRÌNH:\n";
	$system_prompt .= "   - Thuộc tính `city` của mỗi ngày BẮT BUỘC trả về TÊN 1 THÀNH PHỐ CHÍNH DUY NHẤT đại diện cho ngày đó.\n";
	$system_prompt .= "7. NGÔN NGỮ ĐẦU RA MỤC TIÊU: " . $target_lang_name . " (Mã: " . $target_lang_code . ").\n";
	$system_prompt .= "   - Nếu tài liệu gốc khác ngôn ngữ mục tiêu (ví dụ tài liệu là Tiếng Việt/Tiếng Trung/Tiếng Hàn nhưng website hiện tại ở " . $target_lang_name . "), BẮT BUỘC DỊCH TOÀN BỘ CÁC NỘI DUNG VĂN BẢN sang " . $target_lang_name . " sát với nội dung nguyên bản nhất, không tóm tắt hay rút gọn.\n";
	$system_prompt .= "   - Nếu tài liệu gốc trùng ngôn ngữ " . $target_lang_name . ", GIỮ NGUYÊN BẢN 100% không chỉnh sửa.\n";
	$system_prompt .= "8. Trả về DUY NHẤT 1 JSON Object chuẩn xác theo đúng cấu trúc schema được yêu cầu.\n";
	$system_prompt .= "9. KHÔNG dùng Markdown block (```json). Chỉ trả về JSON raw.\n";

	$user_prompt = "Dưới đây là tệp tin chứa nội dung chương trình tour (Tên file: " . $file_name . ").\n";
	$user_prompt .= "Hãy đọc kỹ toàn bộ tài liệu và bóc tách dữ liệu tour từ file này theo đúng cấu trúc JSON schema.\n";
	$user_prompt .= "LƯU Ý QUAN TRỌNG: Trích xuất 100% nguyên văn toàn bộ thông tin, không tóm tắt hay cắt bớt câu từ.";

	$schema = array(
		"type" => "object",
		"properties" => array(
			"title" => array("type" => "string", "description" => "Tên tour / Tiêu đề chương trình trích xuất từ file"),
			"slug" => array("type" => "string", "description" => "Slug SEO của tour"),
			"trip_code" => array("type" => "string", "description" => "Mã tour ngắn"),
			"tour_group" => array("type" => "string", "description" => "Nhóm tour"),
			"categories" => array("type" => "array", "items" => array("type" => "string")),
			"departure_point" => array("type" => "string"),
			"destination" => array("type" => "array", "items" => array("type" => "string")),
			"price" => array("type" => "integer"),
			"number_day" => array("type" => "integer"),
			"number_night" => array("type" => "integer"),
			"overview" => array("type" => "string"),
			"inclusion" => array("type" => "array", "items" => array("type" => "string")),
			"exclusion" => array("type" => "array", "items" => array("type" => "string")),
			"thing_to_carry" => array("type" => "array", "items" => array("type" => "string")),
			"cancellation_policy" => array("type" => "string"),
			"refund_policy" => array("type" => "string"),
			"confirmation_policy" => array("type" => "string"),
			"itinerary" => array(
				"type" => "array",
				"items" => array(
					"type" => "object",
					"properties" => array(
						"day" => array("type" => "integer"),
						"title" => array("type" => "string"),
						"slug" => array("type" => "string"),
						"content" => array("type" => "array", "items" => array("type" => "string")),
						"image" => array("type" => "string"),
						"meals" => array("type" => "array", "items" => array("type" => "string")),
						"transport" => array("type" => "array", "items" => array("type" => "string", "enum" => $allowed_transports)),
						"city" => array("type" => "string")
					),
					"required" => array("day", "title", "content")
				)
			)
		),
		"required" => array("title", "number_day", "number_night", "overview", "itinerary")
	);

	if ($file_ext === 'pdf') {
		$parts = array(
			array('inlineData' => array('mimeType' => 'application/pdf', 'data' => $b64)),
			array('text' => $user_prompt)
		);
	} else {
		if (empty($extracted_text)) {
			$extracted_text = extract_text_from_file_sub($tmp_path, $file_ext, $file_bytes);
		}
		if (empty(trim($extracted_text))) {
			echo json_encode(array('ok' => false, 'error' => 'Unable to read content from Word file (' . $file_name . '). Please make sure file has text or try converting to PDF.'));
			exit();
		}
		$full_user_prompt = "Dưới đây là toàn bộ nội dung tài liệu chương trình tour trích xuất từ file (" . $file_name . "):\n\n" . $extracted_text . "\n\n" . $user_prompt;
		$parts = array(
			array('text' => $full_user_prompt)
		);
	}

	$payload = array(
		'systemInstruction' => array('parts' => array(array('text' => $system_prompt))),
		'contents' => array(array('parts' => $parts)),
		'generationConfig' => array(
			'temperature' => 0.0,
			'maxOutputTokens' => 16384,
			'responseMimeType' => 'application/json',
			'responseSchema' => $schema
		)
	);

	$url = "https://generativelanguage.googleapis.com/v1beta/models/" . urlencode($gemini_model) . ":generateContent?key=" . urlencode($api_key);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_TIMEOUT, 180);

	$response = curl_exec($ch);
	$curl_error = curl_error($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($curl_error) {
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Connection Error: ' . $curl_error));
		exit();
	}

	if ($http_code != 200) {
		$err_resp = @json_decode($response, true);
		$msg = isset($err_resp['error']['message']) ? $err_resp['error']['message'] : ('HTTP Code ' . $http_code);
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Response Error: ' . $msg));
		exit();
	}

	$res_data = @json_decode($response, true);
	$generated_text = '';
	if (isset($res_data['candidates'][0]['content']['parts'][0]['text'])) {
		$generated_text = $res_data['candidates'][0]['content']['parts'][0]['text'];
	}

	$schema_data = parse_schema_json_sub($generated_text);

	// BƯỚC DỊCH CHUẨN HÓA SANG NGÔN NGỮ MỤC TIÊU CỦA WEBSITE NẾU TÀI LIỆU KHÁC NGÔN NGỮ
	if (!empty($schema_data) && is_array($schema_data)) {
		$schema_data = translate_schema_data_to_target_lang_sub($schema_data, $target_lang_code, $api_key, $gemini_model);
	}

	if (empty($schema_data) || !isset($schema_data['title'])) {
		echo json_encode(array('ok' => false, 'error' => 'Unable to extract tour data from this file. Please check the file format.'));
		exit();
	}

	// 100% AUTOMATED IMPORT TO DB WITH AUTOMATED IMAGE SEARCH & DOWNLOAD
	$clsTour = new Tour();
	$clsTourItinerary = new TourItinerary();
	$clsVietISOSDK = class_exists('VietISOSDK') ? new VietISOSDK() : null;

	$title = !empty($schema_data['title']) ? trim((string)$schema_data['title']) : 'New AI Generated Tour';
	$slug = !empty($schema_data['slug']) ? $clsISO->replaceSpace($schema_data['slug']) : $clsISO->replaceSpace($title);

	$trip_code = !empty($schema_data['trip_code']) ? strtoupper(trim((string)$schema_data['trip_code'])) : '';
	if (empty($trip_code) && method_exists($clsTour, 'generateTripCode')) {
		$trip_code = $clsTour->generateTripCode();
	}
	if (empty($trip_code)) {
		$trip_code = 'AI' . rand(1000, 9999);
	}

	$number_day = isset($schema_data['number_day']) ? (int)$schema_data['number_day'] : 1;
	$number_night = isset($schema_data['number_night']) ? (int)$schema_data['number_night'] : 0;
	if ($number_day <= 0) $number_day = 1;
	if ($number_night < 0) $number_night = 0;

	$overview = !empty($schema_data['overview']) ? build_full_overview_html_sub($schema_data, $target_lang_code) : (isset($schema_data['overview']) ? formatTimelineContent_sub($schema_data['overview']) : '');
	$inclusion = isset($schema_data['inclusion']) ? formatArrayToList_sub($schema_data['inclusion']) : '';
	$exclusion = isset($schema_data['exclusion']) ? formatArrayToList_sub($schema_data['exclusion']) : '';
	$thing_to_carry = isset($schema_data['thing_to_carry']) ? formatArrayToList_sub($schema_data['thing_to_carry']) : '';
	$cancellation_policy = isset($schema_data['cancellation_policy']) ? formatArrayToList_sub($schema_data['cancellation_policy']) : '';
	$refund_policy = isset($schema_data['refund_policy']) ? formatArrayToList_sub($schema_data['refund_policy']) : '';
	$confirmation_policy = isset($schema_data['confirmation_policy']) ? formatArrayToList_sub($schema_data['confirmation_policy']) : '';
	$price = isset($schema_data['price']) ? (int)$schema_data['price'] : 0;

	// KHỚP NỐI CÁC TRƯỜNG LIÊN KẾT HỆ THỐNG ALL-IN-ONE
	$tour_group_id = 0;
	$departure_point_id = 0;
	$list_departure_point_id = '';
	$main_cat_id = 0;
	$list_cat_id = '';
	$tour_option_id = 0;
	$tour_type_id = 0;
	$list_activities_id = '';

	if (class_exists('TourGroup')) {
		$clsTourGroup = new TourGroup();
		if (!empty($schema_data['tour_group'])) {
			$tgroup_name = trim((string)$schema_data['tour_group']);
			$lstGroup = $clsTourGroup->getAll("is_trash=0 and title like '%" . addslashes($tgroup_name) . "%' limit 0,1");
			if (empty($lstGroup)) {
				$slug_group = $clsISO->replaceSpace($tgroup_name);
				$lstGroup = $clsTourGroup->getAll("is_trash=0 and slug like '%" . addslashes($slug_group) . "%' limit 0,1");
			}
			if (!empty($lstGroup) && isset($lstGroup[0]['tour_group_id'])) {
				$tour_group_id = (int)$lstGroup[0]['tour_group_id'];
			}
		}
		if ($tour_group_id == 0) {
			$firstGroup = $clsTourGroup->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstGroup) && isset($firstGroup[0]['tour_group_id'])) {
				$tour_group_id = (int)$firstGroup[0]['tour_group_id'];
			}
		}
	}

	if (class_exists('City')) {
		$clsCity = new City();
		if (!empty($schema_data['departure_point'])) {
			$dep_name = trim((string)$schema_data['departure_point']);
			$lstDep = $clsCity->getAll("is_trash=0 and title like '%" . addslashes($dep_name) . "%' limit 0,1");
			if (empty($lstDep)) {
				$slug_dep = $clsISO->replaceSpace($dep_name);
				$lstDep = $clsCity->getAll("is_trash=0 and slug like '%" . addslashes($slug_dep) . "%' limit 0,1");
			}
			if (!empty($lstDep) && isset($lstDep[0]['city_id'])) {
				$departure_point_id = (int)$lstDep[0]['city_id'];
				$list_departure_point_id = '|' . $departure_point_id . '|';
			}
		}
		if ($departure_point_id == 0) {
			$firstCity = $clsCity->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstCity) && isset($firstCity[0]['city_id'])) {
				$departure_point_id = (int)$firstCity[0]['city_id'];
				$list_departure_point_id = '|' . $departure_point_id . '|';
			}
		}
	}

	if (class_exists('TourCategory')) {
		$clsTourCategory = new TourCategory();
		if (!empty($schema_data['categories']) && is_array($schema_data['categories'])) {
			$tmp_list_cat_id = '|';
			foreach ($schema_data['categories'] as $cat_name) {
				if (!is_string($cat_name) || empty(trim($cat_name))) continue;
				$cname = trim($cat_name);
				$lstCat = $clsTourCategory->getAll("is_trash=0 and title like '%" . addslashes($cname) . "%' limit 0,1");
				if (empty($lstCat)) {
					$slug_cat = $clsISO->replaceSpace($cname);
					$lstCat = $clsTourCategory->getAll("is_trash=0 and slug like '%" . addslashes($slug_cat) . "%' limit 0,1");
				}
				if (!empty($lstCat) && isset($lstCat[0]['tourcat_id'])) {
					$cid = (int)$lstCat[0]['tourcat_id'];
					if ($main_cat_id == 0) $main_cat_id = $cid;
					if (strpos($tmp_list_cat_id, '|' . $cid . '|') === false) {
						$tmp_list_cat_id .= $cid . '|';
					}
				}
			}
			if ($main_cat_id > 0) {
				$list_cat_id = $tmp_list_cat_id;
			}
		}
		if ($main_cat_id == 0) {
			$firstCat = $clsTourCategory->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstCat) && isset($firstCat[0]['tourcat_id'])) {
				$main_cat_id = (int)$firstCat[0]['tourcat_id'];
				$list_cat_id = '|' . $main_cat_id . '|';
			}
		}
	}

	if (!empty($schema_data['tour_option']) && class_exists('TourOption')) {
		$clsTourOption = new TourOption();
		$opt_name = trim((string)$schema_data['tour_option']);
		$lstOpt = $clsTourOption->getAll("is_trash=0 and title like '%" . addslashes($opt_name) . "%' limit 0,1");
		if (!empty($lstOpt) && isset($lstOpt[0]['tour_option_id'])) {
			$tour_option_id = (int)$lstOpt[0]['tour_option_id'];
		}
	}
	if (!empty($schema_data['tour_type']) && class_exists('TourType')) {
		$clsTourType = new TourType();
		$tt_name = trim((string)$schema_data['tour_type']);
		$lstTT = $clsTourType->getAll("is_trash=0 and title like '%" . addslashes($tt_name) . "%' limit 0,1");
		if (!empty($lstTT) && isset($lstTT[0]['tour_type_id'])) {
			$tour_type_id = (int)$lstTT[0]['tour_type_id'];
		}
	}

	if (!empty($schema_data['activity']) && class_exists('Activities')) {
		$clsActivities = new Activities();
		$act_items = is_array($schema_data['activity']) ? $schema_data['activity'] : explode(',', (string)$schema_data['activity']);
		$tmp_list_act_id = '|';
		foreach ($act_items as $act_name) {
			$act_clean = trim((string)$act_name);
			if (empty($act_clean)) continue;
			$lstAct = $clsActivities->getAll("is_trash=0 and title like '%" . addslashes($act_clean) . "%' limit 0,1");
			if (!empty($lstAct) && isset($lstAct[0]['activities_id'])) {
				$aid = (int)$lstAct[0]['activities_id'];
				if (strpos($tmp_list_act_id, '|' . $aid . '|') === false) {
					$tmp_list_act_id .= $aid . '|';
				}
			}
		}
		if ($tmp_list_act_id !== '|') {
			$list_activities_id = $tmp_list_act_id;
		}
	}

	$user_id = $oneProfile['user_id'] ? $oneProfile['user_id'] : (isset($_frontIsLoggedin_user_id) ? $_frontIsLoggedin_user_id : 1);
	$time = time();

	$new_tour_id = $clsTour->getMaxId();

	$f_Tour = "tour_id,title,slug,trip_code,number_day,number_night,overview,is_trash,is_online,user_id,user_id_update,reg_date,upd_date,order_no";
	$order_no = method_exists($clsTour, 'getMaxOrderNo') ? $clsTour->getMaxOrderNo() : 1;
	$v_Tour = "'$new_tour_id','" . addslashes($title) . "','" . addslashes($slug) . "','" . addslashes($trip_code) . "','$number_day','$number_night','" . addslashes($overview) . "','0','1','$user_id','$user_id','$time','$time','$order_no'";

	$clsTour->insertOne($f_Tour, $v_Tour);

	if ($clsTour->checkColumnInTable('lang_id') && !empty($target_lang_code)) $clsTour->updateOne($new_tour_id, "lang_id='" . addslashes($target_lang_code) . "'");
	if ($inclusion !== '') $clsTour->updateOne($new_tour_id, "inclusion='" . addslashes($inclusion) . "'");
	if ($exclusion !== '') $clsTour->updateOne($new_tour_id, "exclusion='" . addslashes($exclusion) . "'");
	if ($thing_to_carry !== '') $clsTour->updateOne($new_tour_id, "thing_to_carry='" . addslashes($thing_to_carry) . "'");
	if ($cancellation_policy !== '') $clsTour->updateOne($new_tour_id, "cancellation_policy='" . addslashes($cancellation_policy) . "'");
	if ($refund_policy !== '') $clsTour->updateOne($new_tour_id, "refund_policy='" . addslashes($refund_policy) . "'");
	if ($confirmation_policy !== '') $clsTour->updateOne($new_tour_id, "confirmation_policy='" . addslashes($confirmation_policy) . "'");
	if ($main_cat_id > 0) $clsTour->updateOne($new_tour_id, "cat_id='$main_cat_id', list_cat_id='" . addslashes($list_cat_id) . "'");
	if ($departure_point_id > 0) $clsTour->updateOne($new_tour_id, "departure_point_id='$departure_point_id', list_departure_point_id='" . addslashes($list_departure_point_id) . "'");
	if ($tour_group_id > 0) $clsTour->updateOne($new_tour_id, "tour_group_id='$tour_group_id'");
	if ($tour_option_id > 0) $clsTour->updateOne($new_tour_id, "tour_option_id='$tour_option_id'");
	if ($tour_type_id > 0) $clsTour->updateOne($new_tour_id, "tour_type_id='$tour_type_id'");
	if ($list_activities_id !== '') $clsTour->updateOne($new_tour_id, "list_activities_id='" . addslashes($list_activities_id) . "'");
	if ($price > 0) $clsTour->updateOne($new_tour_id, "trip_price='$price', min_price='$price'");

	// FEATURED IMAGE SEARCH & DOWNLOAD
	$tour_image = '';
	if (!empty($schema_data['image'])) {
		$tour_image = trim((string)$schema_data['image']);
	} else if (!empty($schema_data['featured_image'])) {
		$tour_image = trim((string)$schema_data['featured_image']);
	} else if (!empty($schema_data['photo'])) {
		$tour_image = trim((string)$schema_data['photo']);
	} else if (!empty($schema_data['image_url'])) {
		$tour_image = trim((string)$schema_data['image_url']);
	}
	if (!empty($tour_image) && $clsVietISOSDK) {
		$tmp_tour_image = $clsVietISOSDK->downloadImageFromUrl($tour_image);
		if (strpos($tmp_tour_image, 'cURL Error') === false && !empty($tmp_tour_image)) {
			$tour_image = $tmp_tour_image;
		}
	}
	if (empty($tour_image) && !empty($title)) {
		$tour_image = search_and_download_library_image_aiconfig($title, $clsVietISOSDK);
	}
	if (!empty($tour_image)) {
		$clsTour->updateOne($new_tour_id, "image='" . addslashes($tour_image) . "'");
	}

	// ITINERARIES INSERTION WITH AUTOMATED IMAGE SEARCH
	$itinerary_list = !empty($schema_data['itinerary']) ? $schema_data['itinerary'] : array();
	if (!empty($itinerary_list) && is_array($itinerary_list)) {
		$itinerary_order = 1;
		foreach ($itinerary_list as $item) {
			if (is_string($item)) {
				$day_lbl = ($target_lang_code === 'vi' || $target_lang_code === 'vn') ? 'Ngày ' : 'Day ';
				$item = array('day' => $itinerary_order, 'title' => $day_lbl . $itinerary_order, 'content' => $item);
			}
			if (!is_array($item)) continue;
			
			$day_num = (isset($item['day']) && (int)$item['day'] > 0) ? (int)$item['day'] : $itinerary_order;
			$day_lbl = ($target_lang_code === 'vi' || $target_lang_code === 'vn') ? 'Ngày ' : 'Day ';
			$raw_title = !empty($item['title']) ? (string)$item['title'] : ($day_lbl . $day_num);
			if ($target_lang_code === 'en') {
				$itin_title = preg_replace('/^Ngày\s*(\d+)\s*[:\.\-]?\s*/iu', 'Day $1: ', $raw_title);
			} else if ($target_lang_code === 'vi' || $target_lang_code === 'vn') {
				$itin_title = preg_replace('/^Day\s*(\d+)\s*[:\.\-]?\s*/iu', 'Ngày $1: ', $raw_title);
			} else {
				$itin_title = $raw_title;
			}
			$itin_slug = !empty($item['slug']) ? $clsISO->replaceSpace($item['slug']) : $clsISO->replaceSpace($itin_title);
			
			$raw_itin_content = !empty($item['content']) ? $item['content'] : (!empty($item['description']) ? $item['description'] : (!empty($item['detail']) ? $item['detail'] : (!empty($item['intro']) ? $item['intro'] : '')));
			$itin_content = formatTimelineContent_sub($raw_itin_content);
			
			$itin_image = '';
			if (!empty($item['image'])) {
				$itin_image = trim((string)$item['image']);
			} else if (!empty($item['image_url'])) {
				$itin_image = trim((string)$item['image_url']);
			} else if (!empty($item['url_image'])) {
				$itin_image = trim((string)$item['url_image']);
			} else if (!empty($item['photo'])) {
				$itin_image = trim((string)$item['photo']);
			}
			
			if (!empty($itin_image) && $clsVietISOSDK) {
				$tmp_image = $clsVietISOSDK->downloadImageFromUrl($itin_image);
				if (strpos($tmp_image, 'cURL Error') === false && !empty($tmp_image)) {
					$itin_image = $tmp_image;
				}
			}
			
			if (empty($itin_image)) {
				$search_kw = !empty($item['city']) ? trim($item['city']) : (!empty($itin_title) ? $itin_title : '');
				if (!empty($search_kw)) {
					$itin_image = search_and_download_library_image_aiconfig($search_kw, $clsVietISOSDK);
				}
			}
			
			$itin_meals = !empty($item['meals']) ? convertMealsToIds_sub($item['meals']) : '';
			if (empty($itin_meals)) {
				$full_day_text = $itin_title . ' ' . $itin_content;
				$detected_meals = array();
				if (preg_match('/(ăn sáng|bữa sáng|buffet sáng|điểm tâm|breakfast)/iu', $full_day_text)) $detected_meals[] = 'SÁNG';
				if (preg_match('/(ăn trưa|bữa trưa|cơm trưa|lunch)/iu', $full_day_text)) $detected_meals[] = 'TRƯA';
				if (preg_match('/(ăn tối|bữa tối|cơm tối|tiệc tối|dinner)/iu', $full_day_text)) $detected_meals[] = 'TỐI';
				if (!empty($detected_meals)) $itin_meals = convertMealsToIds_sub($detected_meals);
			}

			$itin_transport = !empty($item['transport']) ? convertTransportToIds_sub($item['transport']) : '';
			if (empty($itin_transport)) {
				$full_day_text = $itin_title . ' ' . $itin_content;
				$detected_transport = array();
				if (preg_match('/(máy bay|chuyến bay|flight|bay đi|hàng không)/iu', $full_day_text)) $detected_transport[] = 'Air plane';
				if (preg_match('/(du thuyền|tàu thủy|thuyền|cano|ca nô|cruise|tàu cao tốc)/iu', $full_day_text)) $detected_transport[] = 'Cruise';
				if (preg_match('/(tàu hỏa|tàu lửa|xe lửa|train)/iu', $full_day_text)) $detected_transport[] = 'Train';
				if (preg_match('/(xe đạp|bicycle|cycling)/iu', $full_day_text)) $detected_transport[] = 'Bicycle';
				if (preg_match('/(xe máy|mô tô|motorbike)/iu', $full_day_text)) $detected_transport[] = 'Motorbike';
				if (preg_match('/(xe ô tô|ô tô|xe du lịch|xe đón|xe đưa đón|xe bus|xe buýt|xe khách|car|bus)/iu', $full_day_text)) $detected_transport[] = 'Car';
				if (!empty($detected_transport)) $itin_transport = convertTransportToIds_sub($detected_transport);
			}
			$is_show_image = !empty($itin_image) ? '1' : '0';
			
			$max_itin_id = $clsTourItinerary->getMaxId();
			
			$f_Itinerary = "tour_itinerary_id,tour_id,day,title,slug,content,image,meals,transport,user_id,user_id_update,reg_date,upd_date,order_no,is_trash,is_online,is_show_image,title_contingency";
			$v_Itinerary = "'$max_itin_id','$new_tour_id','$day_num','" . addslashes($itin_title) . "','" . addslashes($itin_slug) . "','" . addslashes($itin_content) . "','" . addslashes($itin_image) . "','" . addslashes($itin_meals) . "','" . addslashes($itin_transport) . "','$user_id','$user_id','$time','$time','$itinerary_order','0','1','$is_show_image',''";
			
			$clsTourItinerary->insertOne($f_Itinerary, $v_Itinerary);
			$itinerary_order++;
		}
	}

	// DESTINATIONS INSERTION
	if (class_exists('TourDestination') && class_exists('City')) {
		$clsTourDestination = new TourDestination();
		$clsCity = new City();
		$clsCountry = class_exists('Country') ? new Country() : null;
		$dest_order = 1;
		
		if (!empty($schema_data['destination']) && is_array($schema_data['destination'])) {
			foreach ($schema_data['destination'] as $dest_name) {
				if (!is_string($dest_name) || empty(trim($dest_name))) continue;
				$dest_name_clean = trim($dest_name);
				
				$lstCity = $clsCity->getAll("is_trash=0 and title like '%" . addslashes($dest_name_clean) . "%' limit 0,1");
				if (empty($lstCity)) {
					$slug_dest = $clsISO->replaceSpace($dest_name_clean);
					$lstCity = $clsCity->getAll("is_trash=0 and slug like '%" . addslashes($slug_dest) . "%' limit 0,1");
				}
				
				$city_id = 0;
				$country_id = 0;
				$region_id = 0;
				$area_id = 0;
				$chauluc_id = 0;
				
				if (!empty($lstCity) && isset($lstCity[0]['city_id'])) {
					$city_id = (int)$lstCity[0]['city_id'];
					$country_id = isset($lstCity[0]['country_id']) ? (int)$lstCity[0]['country_id'] : 0;
					$region_id = isset($lstCity[0]['region_id']) ? (int)$lstCity[0]['region_id'] : 0;
					$area_id = isset($lstCity[0]['area_id']) ? (int)$lstCity[0]['area_id'] : 0;
					$chauluc_id = isset($lstCity[0]['chauluc_id']) ? (int)$lstCity[0]['chauluc_id'] : (isset($lstCity[0]['continent_id']) ? (int)$lstCity[0]['continent_id'] : 0);
				} else if ($clsCountry) {
					$lstCountry = $clsCountry->getAll("is_trash=0 and title like '%" . addslashes($dest_name_clean) . "%' limit 0,1");
					if (!empty($lstCountry) && isset($lstCountry[0]['country_id'])) {
						$country_id = (int)$lstCountry[0]['country_id'];
						$chauluc_id = isset($lstCountry[0]['continent_id']) ? (int)$lstCountry[0]['continent_id'] : 0;
					}
				}
				
				if ($city_id > 0 || $country_id > 0) {
					$max_dest_id = $clsTourDestination->getMaxId();
					$f_dest = "tour_destination_id,tour_id,country_id,region_id,city_id,order_no,val,chauluc_id,area_id,placetogo_id";
					$v_dest = "'$max_dest_id','$new_tour_id','$country_id','$region_id','$city_id','$dest_order','1','$chauluc_id','$area_id','0'";
					$clsTourDestination->insertOne($f_dest, $v_dest);
					$dest_order++;
				}
			}
		}
	}

	$edit_url = PCMS_URL . '/tour_iso/edit/' . $new_tour_id . '/overview';
	
	echo json_encode(array(
		'ok' => true,
		'message' => 'Tour created successfully with AI!',
		'tour_id' => $new_tour_id,
		'trip_code' => $trip_code,
		'edit_url' => $edit_url
	));
	exit();
	} catch (\Throwable $e) {
		echo json_encode(array(
			'ok' => false,
			'error' => 'Server Error: ' . $e->getMessage() . ' in ' . basename($e->getFile()) . ':' . $e->getLine()
		));
		exit();
	} catch (\Exception $e) {
		echo json_encode(array(
			'ok' => false,
			'error' => 'Server Error: ' . $e->getMessage()
		));
		exit();
	}
}
}

if (!function_exists('default_ajax_create_tour_auto_ai_text')) {
function default_ajax_create_tour_auto_ai_text() {
	@set_time_limit(300);
	@ini_set('max_execution_time', 300);
	@ini_set('memory_limit', '512M');
	if (session_status() === PHP_SESSION_ACTIVE) {
		@session_write_close();
	}
	header('Content-Type: application/json; charset=utf-8');
	error_reporting(0);
	ini_set('display_errors', 0);
	global $core, $clsISO, $clsConfiguration, $oneProfile, $_frontIsLoggedin_user_id;

	$text_content = isset($_POST['text_content']) ? trim((string)$_POST['text_content']) : '';
	if (empty($text_content) || mb_strlen($text_content, 'UTF-8') < 20) {
		echo json_encode(array('ok' => false, 'error' => 'Please enter or paste tour itinerary content (minimum 20 characters).'));
		exit();
	}

	$clsConfiguration = new Configuration();
	$api_key = $clsConfiguration->getValue('gemini_api_key');
	if (empty($api_key)) $api_key = $clsConfiguration->getValue('GeminiAPIKey');
	if (empty($api_key)) $api_key = $clsConfiguration->getValue('site_gemini_api_key');

	$gemini_model = $clsConfiguration->getValue('gemini_model_id');
	if (empty($gemini_model)) $gemini_model = $clsConfiguration->getValue('GeminiModel');
	if (empty($gemini_model)) $gemini_model = 'gemini-2.5-flash';

	if (empty($api_key)) {
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Key has not been configured in the system yet.'));
		exit();
	}

	

	$allowed_transports = array("Train", "Bicycle", "Mini Bus", "Cruise", "Motorbike", "Air plane", "Car", "Bus");
	if (!class_exists('Transport')) {
		$file_path = (defined('DIR_CLASSES') ? DIR_CLASSES : ABSPATH . '/classes') . '/class_Transport.php';
		if (file_exists($file_path)) require_once($file_path);
	}
	if (class_exists('Transport')) {
		$clsTransport = new Transport();
		$lstTrDb = $clsTransport->getAll("is_trash=0", "title,transport_id");
		if (!empty($lstTrDb)) {
			$tmp_list = array();
			foreach ($lstTrDb as $trItem) {
				if (!empty($trItem['title'])) {
					$tmp_list[] = trim($trItem['title']);
				}
			}
			if (!empty($tmp_list)) {
				$allowed_transports = array_values($tmp_list);
			}
		}
	}
	$transport_str_list = implode(', ', array_map(function($t) { return '"' . $t . '"'; }, $allowed_transports));

	$system_prompt = "You are an expert AI assistant specializing in extracting travel tour data from documents into JSON.\n";
	$system_prompt .= "IMPORTANT RULES FOR 100% ACCURATE VERBATIM JSON EXTRACTION:\n";
	$system_prompt .= "1. EXTRACT 100% VERBATIM & FULL CONTENT: Extract 100% verbatim all details, titles, timestamps, sightseeing activities, services, and daily itinerary content from the source into valid JSON. DO NOT summarize, shorten, or omit any sentences or paragraphs.\n";
	$system_prompt .= "2. EXTRACT ALL SECTIONS 100%: Tour title, number of days/nights, price, overview, inclusions, exclusions, things to carry, policies (cancellation_policy, refund_policy, confirmation_policy), departure point, destinations, category, and DAILY ITINERARY.\n";
	$system_prompt .= "3. FORMAT OF DAILY ITINERARY `content`:\n";
	$system_prompt .= "   - `content` property of each day IS AN ARRAY OF STRINGS containing all itinerary details.\n";
	$system_prompt .= "   - MUST PRESENT AS HTML LIST items (<ul><li>...</li></ul>) for easy readability.\n";
	$system_prompt .= "   - Lead sentences or timestamps wrapped in <p><strong>...</strong></p>.\n";
	$system_prompt .= "   - ALL sightseeing activities and detailed experiences wrapped in <ul><li>...</li></ul>.\n";
	$system_prompt .= "   - Meals and stay notices placed in separate <p>...</p> tags.\n";
	$system_prompt .= "4. OVERVIEW FORMAT: Overview field should contain structured HTML (<p>...</p>, <ul><li>...</li></ul>) covering general intro, highlights, and itinerary summary.\n";
	$system_prompt .= "5. MEALS & TRANSPORT: Extract meals (e.g. [\"Breakfast\", \"Lunch\", \"Dinner\"]) and transport from allowed list: [" . $transport_str_list . "].\n";
	$target_lang_code = get_active_language_code_sub();
	$target_lang_name = get_language_name_by_code_sub($target_lang_code);

	$system_prompt .= "6. CITY: `city` attribute MUST return 1 main city name for that day.\n";
	$system_prompt .= "7. TARGET OUTPUT LANGUAGE: " . $target_lang_name . " (Code: " . $target_lang_code . ").\n";
	$system_prompt .= "   - If source content is in a different language than " . $target_lang_name . " (e.g. source is Vietnamese/Chinese/Korean but target is " . $target_lang_name . "), YOU MUST TRANSLATE ALL TEXT CONTENT (title, overview, itinerary details, inclusions, exclusions, policies...) into " . $target_lang_name . " accurately and faithfully based on original content without shortening.\n";
	$system_prompt .= "   - If source content matches " . $target_lang_name . ", keep original text 100% verbatim.\n";
	$system_prompt .= "8. Return ONLY 1 valid JSON object matching the required schema.\n";
	$system_prompt .= "9. Do NOT use Markdown block (```json). Only return raw JSON.\n";

	$user_prompt = "Below is the tour itinerary content provided by the user:\n\n" . $text_content . "\n\n";
	$user_prompt .= "Please read carefully and extract all tour data into the JSON schema.\n";
	$user_prompt .= "IMPORTANT: Extract 100% verbatim content without summarizing or skipping details.";

	$schema = array(
		"type" => "object",
		"properties" => array(
			"title" => array("type" => "string", "description" => "Tên tour / Tiêu đề chương trình trích xuất từ file"),
			"slug" => array("type" => "string", "description" => "Slug SEO của tour"),
			"trip_code" => array("type" => "string", "description" => "Mã tour ngắn"),
			"tour_group" => array("type" => "string", "description" => "Nhóm tour"),
			"categories" => array("type" => "array", "items" => array("type" => "string")),
			"departure_point" => array("type" => "string"),
			"destination" => array("type" => "array", "items" => array("type" => "string")),
			"price" => array("type" => "integer"),
			"number_day" => array("type" => "integer"),
			"number_night" => array("type" => "integer"),
			"overview" => array("type" => "string"),
			"inclusion" => array("type" => "array", "items" => array("type" => "string")),
			"exclusion" => array("type" => "array", "items" => array("type" => "string")),
			"thing_to_carry" => array("type" => "array", "items" => array("type" => "string")),
			"cancellation_policy" => array("type" => "string"),
			"refund_policy" => array("type" => "string"),
			"confirmation_policy" => array("type" => "string"),
			"itinerary" => array(
				"type" => "array",
				"items" => array(
					"type" => "object",
					"properties" => array(
						"day" => array("type" => "integer"),
						"title" => array("type" => "string"),
						"slug" => array("type" => "string"),
						"content" => array("type" => "array", "items" => array("type" => "string")),
						"image" => array("type" => "string"),
						"meals" => array("type" => "array", "items" => array("type" => "string")),
						"transport" => array("type" => "array", "items" => array("type" => "string", "enum" => $allowed_transports)),
						"city" => array("type" => "string")
					),
					"required" => array("day", "title", "content")
				)
			)
		),
		"required" => array("title", "number_day", "number_night", "overview", "itinerary")
	);

	$parts = array(
		array('text' => $user_prompt)
	);

	$payload = array(
		'systemInstruction' => array('parts' => array(array('text' => $system_prompt))),
		'contents' => array(array('parts' => $parts)),
		'generationConfig' => array(
			'temperature' => 0.0,
			'maxOutputTokens' => 16384,
			'responseMimeType' => 'application/json',
			'responseSchema' => $schema
		)
	);

	$url = "https://generativelanguage.googleapis.com/v1beta/models/" . urlencode($gemini_model) . ":generateContent?key=" . urlencode($api_key);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_TIMEOUT, 180);

	$response = curl_exec($ch);
	$curl_error = curl_error($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($curl_error) {
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Connection Error: ' . $curl_error));
		exit();
	}

	if ($http_code != 200) {
		$err_resp = @json_decode($response, true);
		$msg = isset($err_resp['error']['message']) ? $err_resp['error']['message'] : ('HTTP Code ' . $http_code);
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Response Error: ' . $msg));
		exit();
	}

	$res_data = @json_decode($response, true);
	$generated_text = '';
	if (isset($res_data['candidates'][0]['content']['parts'][0]['text'])) {
		$generated_text = $res_data['candidates'][0]['content']['parts'][0]['text'];
	}

	$schema_data = parse_schema_json_sub($generated_text);

	// BƯỚC DỊCH CHUẨN HÓA SANG NGÔN NGỮ MỤC TIÊU CỦA WEBSITE NẾU TÀI LIỆU KHÁC NGÔN NGỮ
	if (!empty($schema_data) && is_array($schema_data)) {
		$schema_data = translate_schema_data_to_target_lang_sub($schema_data, $target_lang_code, $api_key, $gemini_model);
	}

	if (empty($schema_data) || !isset($schema_data['title'])) {
		echo json_encode(array('ok' => false, 'error' => 'Không thể bóc tách dữ liệu tour từ file này. Vui lòng kiểm tra lại định dạng file.'));
		exit();
	}

	// 100% AUTOMATED IMPORT TO DB WITH AUTOMATED IMAGE SEARCH & DOWNLOAD
	$clsTour = new Tour();
	$clsTourItinerary = new TourItinerary();
	$clsVietISOSDK = class_exists('VietISOSDK') ? new VietISOSDK() : null;

	$title = !empty($schema_data['title']) ? trim((string)$schema_data['title']) : 'Tour Mới Tạo AI';
	$slug = !empty($schema_data['slug']) ? $clsISO->replaceSpace($schema_data['slug']) : $clsISO->replaceSpace($title);

	$trip_code = !empty($schema_data['trip_code']) ? strtoupper(trim((string)$schema_data['trip_code'])) : '';
	if (empty($trip_code) && method_exists($clsTour, 'generateTripCode')) {
		$trip_code = $clsTour->generateTripCode();
	}
	if (empty($trip_code)) {
		$trip_code = 'AI' . rand(1000, 9999);
	}

	$number_day = isset($schema_data['number_day']) ? (int)$schema_data['number_day'] : 1;
	$number_night = isset($schema_data['number_night']) ? (int)$schema_data['number_night'] : 0;
	if ($number_day <= 0) $number_day = 1;
	if ($number_night < 0) $number_night = 0;

	$overview = !empty($schema_data['overview']) ? build_full_overview_html_sub($schema_data, $target_lang_code) : (isset($schema_data['overview']) ? formatTimelineContent_sub($schema_data['overview']) : '');
	$inclusion = isset($schema_data['inclusion']) ? formatArrayToList_sub($schema_data['inclusion']) : '';
	$exclusion = isset($schema_data['exclusion']) ? formatArrayToList_sub($schema_data['exclusion']) : '';
	$thing_to_carry = isset($schema_data['thing_to_carry']) ? formatArrayToList_sub($schema_data['thing_to_carry']) : '';
	$cancellation_policy = isset($schema_data['cancellation_policy']) ? formatArrayToList_sub($schema_data['cancellation_policy']) : '';
	$refund_policy = isset($schema_data['refund_policy']) ? formatArrayToList_sub($schema_data['refund_policy']) : '';
	$confirmation_policy = isset($schema_data['confirmation_policy']) ? formatArrayToList_sub($schema_data['confirmation_policy']) : '';
	$price = isset($schema_data['price']) ? (int)$schema_data['price'] : 0;

	// KHỚP NỐI CÁC TRƯỜNG LIÊN KẾT HỆ THỐNG ALL-IN-ONE
	$tour_group_id = 0;
	$departure_point_id = 0;
	$list_departure_point_id = '';
	$main_cat_id = 0;
	$list_cat_id = '';
	$tour_option_id = 0;
	$tour_type_id = 0;
	$list_activities_id = '';

	if (class_exists('TourGroup')) {
		$clsTourGroup = new TourGroup();
		if (!empty($schema_data['tour_group'])) {
			$tgroup_name = trim((string)$schema_data['tour_group']);
			$lstGroup = $clsTourGroup->getAll("is_trash=0 and title like '%" . addslashes($tgroup_name) . "%' limit 0,1");
			if (empty($lstGroup)) {
				$slug_group = $clsISO->replaceSpace($tgroup_name);
				$lstGroup = $clsTourGroup->getAll("is_trash=0 and slug like '%" . addslashes($slug_group) . "%' limit 0,1");
			}
			if (!empty($lstGroup) && isset($lstGroup[0]['tour_group_id'])) {
				$tour_group_id = (int)$lstGroup[0]['tour_group_id'];
			}
		}
		if ($tour_group_id == 0) {
			$firstGroup = $clsTourGroup->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstGroup) && isset($firstGroup[0]['tour_group_id'])) {
				$tour_group_id = (int)$firstGroup[0]['tour_group_id'];
			}
		}
	}

	if (class_exists('City')) {
		$clsCity = new City();
		if (!empty($schema_data['departure_point'])) {
			$dep_name = trim((string)$schema_data['departure_point']);
			$lstDep = $clsCity->getAll("is_trash=0 and title like '%" . addslashes($dep_name) . "%' limit 0,1");
			if (empty($lstDep)) {
				$slug_dep = $clsISO->replaceSpace($dep_name);
				$lstDep = $clsCity->getAll("is_trash=0 and slug like '%" . addslashes($slug_dep) . "%' limit 0,1");
			}
			if (!empty($lstDep) && isset($lstDep[0]['city_id'])) {
				$departure_point_id = (int)$lstDep[0]['city_id'];
				$list_departure_point_id = '|' . $departure_point_id . '|';
			}
		}
		if ($departure_point_id == 0) {
			$firstCity = $clsCity->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstCity) && isset($firstCity[0]['city_id'])) {
				$departure_point_id = (int)$firstCity[0]['city_id'];
				$list_departure_point_id = '|' . $departure_point_id . '|';
			}
		}
	}

	if (class_exists('TourCategory')) {
		$clsTourCategory = new TourCategory();
		if (!empty($schema_data['categories']) && is_array($schema_data['categories'])) {
			$tmp_list_cat_id = '|';
			foreach ($schema_data['categories'] as $cat_name) {
				if (!is_string($cat_name) || empty(trim($cat_name))) continue;
				$cname = trim($cat_name);
				$lstCat = $clsTourCategory->getAll("is_trash=0 and title like '%" . addslashes($cname) . "%' limit 0,1");
				if (empty($lstCat)) {
					$slug_cat = $clsISO->replaceSpace($cname);
					$lstCat = $clsTourCategory->getAll("is_trash=0 and slug like '%" . addslashes($slug_cat) . "%' limit 0,1");
				}
				if (!empty($lstCat) && isset($lstCat[0]['tourcat_id'])) {
					$cid = (int)$lstCat[0]['tourcat_id'];
					if ($main_cat_id == 0) $main_cat_id = $cid;
					if (strpos($tmp_list_cat_id, '|' . $cid . '|') === false) {
						$tmp_list_cat_id .= $cid . '|';
					}
				}
			}
			if ($main_cat_id > 0) {
				$list_cat_id = $tmp_list_cat_id;
			}
		}
		if ($main_cat_id == 0) {
			$firstCat = $clsTourCategory->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstCat) && isset($firstCat[0]['tourcat_id'])) {
				$main_cat_id = (int)$firstCat[0]['tourcat_id'];
				$list_cat_id = '|' . $main_cat_id . '|';
			}
		}
	}

	if (!empty($schema_data['tour_option']) && class_exists('TourOption')) {
		$clsTourOption = new TourOption();
		$opt_name = trim((string)$schema_data['tour_option']);
		$lstOpt = $clsTourOption->getAll("is_trash=0 and title like '%" . addslashes($opt_name) . "%' limit 0,1");
		if (!empty($lstOpt) && isset($lstOpt[0]['tour_option_id'])) {
			$tour_option_id = (int)$lstOpt[0]['tour_option_id'];
		}
	}
	if (!empty($schema_data['tour_type']) && class_exists('TourType')) {
		$clsTourType = new TourType();
		$tt_name = trim((string)$schema_data['tour_type']);
		$lstTT = $clsTourType->getAll("is_trash=0 and title like '%" . addslashes($tt_name) . "%' limit 0,1");
		if (!empty($lstTT) && isset($lstTT[0]['tour_type_id'])) {
			$tour_type_id = (int)$lstTT[0]['tour_type_id'];
		}
	}

	if (!empty($schema_data['activity']) && class_exists('Activities')) {
		$clsActivities = new Activities();
		$act_items = is_array($schema_data['activity']) ? $schema_data['activity'] : explode(',', (string)$schema_data['activity']);
		$tmp_list_act_id = '|';
		foreach ($act_items as $act_name) {
			$act_clean = trim((string)$act_name);
			if (empty($act_clean)) continue;
			$lstAct = $clsActivities->getAll("is_trash=0 and title like '%" . addslashes($act_clean) . "%' limit 0,1");
			if (!empty($lstAct) && isset($lstAct[0]['activities_id'])) {
				$aid = (int)$lstAct[0]['activities_id'];
				if (strpos($tmp_list_act_id, '|' . $aid . '|') === false) {
					$tmp_list_act_id .= $aid . '|';
				}
			}
		}
		if ($tmp_list_act_id !== '|') {
			$list_activities_id = $tmp_list_act_id;
		}
	}

	$user_id = $oneProfile['user_id'] ? $oneProfile['user_id'] : (isset($_frontIsLoggedin_user_id) ? $_frontIsLoggedin_user_id : 1);
	$time = time();

	$new_tour_id = $clsTour->getMaxId();

	$f_Tour = "tour_id,title,slug,trip_code,number_day,number_night,overview,is_trash,is_online,user_id,user_id_update,reg_date,upd_date,order_no";
	$order_no = method_exists($clsTour, 'getMaxOrderNo') ? $clsTour->getMaxOrderNo() : 1;
	$v_Tour = "'$new_tour_id','" . addslashes($title) . "','" . addslashes($slug) . "','" . addslashes($trip_code) . "','$number_day','$number_night','" . addslashes($overview) . "','0','1','$user_id','$user_id','$time','$time','$order_no'";

	$clsTour->insertOne($f_Tour, $v_Tour);

	if ($clsTour->checkColumnInTable('lang_id') && !empty($target_lang_code)) $clsTour->updateOne($new_tour_id, "lang_id='" . addslashes($target_lang_code) . "'");
	if ($inclusion !== '') $clsTour->updateOne($new_tour_id, "inclusion='" . addslashes($inclusion) . "'");
	if ($exclusion !== '') $clsTour->updateOne($new_tour_id, "exclusion='" . addslashes($exclusion) . "'");
	if ($thing_to_carry !== '') $clsTour->updateOne($new_tour_id, "thing_to_carry='" . addslashes($thing_to_carry) . "'");
	if ($cancellation_policy !== '') $clsTour->updateOne($new_tour_id, "cancellation_policy='" . addslashes($cancellation_policy) . "'");
	if ($refund_policy !== '') $clsTour->updateOne($new_tour_id, "refund_policy='" . addslashes($refund_policy) . "'");
	if ($confirmation_policy !== '') $clsTour->updateOne($new_tour_id, "confirmation_policy='" . addslashes($confirmation_policy) . "'");
	if ($main_cat_id > 0) $clsTour->updateOne($new_tour_id, "cat_id='$main_cat_id', list_cat_id='" . addslashes($list_cat_id) . "'");
	if ($departure_point_id > 0) $clsTour->updateOne($new_tour_id, "departure_point_id='$departure_point_id', list_departure_point_id='" . addslashes($list_departure_point_id) . "'");
	if ($tour_group_id > 0) $clsTour->updateOne($new_tour_id, "tour_group_id='$tour_group_id'");
	if ($tour_option_id > 0) $clsTour->updateOne($new_tour_id, "tour_option_id='$tour_option_id'");
	if ($tour_type_id > 0) $clsTour->updateOne($new_tour_id, "tour_type_id='$tour_type_id'");
	if ($list_activities_id !== '') $clsTour->updateOne($new_tour_id, "list_activities_id='" . addslashes($list_activities_id) . "'");
	if ($price > 0) $clsTour->updateOne($new_tour_id, "trip_price='$price', min_price='$price'");

	// FEATURED IMAGE SEARCH & DOWNLOAD
	$tour_image = '';
	if (!empty($schema_data['image'])) {
		$tour_image = trim((string)$schema_data['image']);
	} else if (!empty($schema_data['featured_image'])) {
		$tour_image = trim((string)$schema_data['featured_image']);
	} else if (!empty($schema_data['photo'])) {
		$tour_image = trim((string)$schema_data['photo']);
	} else if (!empty($schema_data['image_url'])) {
		$tour_image = trim((string)$schema_data['image_url']);
	}
	if (!empty($tour_image) && $clsVietISOSDK) {
		$tmp_tour_image = $clsVietISOSDK->downloadImageFromUrl($tour_image);
		if (strpos($tmp_tour_image, 'cURL Error') === false && !empty($tmp_tour_image)) {
			$tour_image = $tmp_tour_image;
		}
	}
	if (empty($tour_image) && !empty($title)) {
		$tour_image = search_and_download_library_image_aiconfig($title, $clsVietISOSDK);
	}
	if (!empty($tour_image)) {
		$clsTour->updateOne($new_tour_id, "image='" . addslashes($tour_image) . "'");
	}

	// ITINERARIES INSERTION WITH AUTOMATED IMAGE SEARCH
	$itinerary_list = !empty($schema_data['itinerary']) ? $schema_data['itinerary'] : array();
	if (!empty($itinerary_list) && is_array($itinerary_list)) {
		$itinerary_order = 1;
		foreach ($itinerary_list as $item) {
			if (is_string($item)) {
				$day_lbl = ($target_lang_code === 'vi' || $target_lang_code === 'vn') ? 'Ngày ' : 'Day ';
				$item = array('day' => $itinerary_order, 'title' => $day_lbl . $itinerary_order, 'content' => $item);
			}
			if (!is_array($item)) continue;
			
			$day_num = (isset($item['day']) && (int)$item['day'] > 0) ? (int)$item['day'] : $itinerary_order;
			$day_lbl = ($target_lang_code === 'vi' || $target_lang_code === 'vn') ? 'Ngày ' : 'Day ';
			$raw_title = !empty($item['title']) ? (string)$item['title'] : ($day_lbl . $day_num);
			if ($target_lang_code === 'en') {
				$itin_title = preg_replace('/^Ngày\s*(\d+)\s*[:\.\-]?\s*/iu', 'Day $1: ', $raw_title);
			} else if ($target_lang_code === 'vi' || $target_lang_code === 'vn') {
				$itin_title = preg_replace('/^Day\s*(\d+)\s*[:\.\-]?\s*/iu', 'Ngày $1: ', $raw_title);
			} else {
				$itin_title = $raw_title;
			}
			$itin_slug = !empty($item['slug']) ? $clsISO->replaceSpace($item['slug']) : $clsISO->replaceSpace($itin_title);
			
			$raw_itin_content = !empty($item['content']) ? $item['content'] : (!empty($item['description']) ? $item['description'] : (!empty($item['detail']) ? $item['detail'] : (!empty($item['intro']) ? $item['intro'] : '')));
			$itin_content = formatTimelineContent_sub($raw_itin_content);
			
			$itin_image = '';
			if (!empty($item['image'])) {
				$itin_image = trim((string)$item['image']);
			} else if (!empty($item['image_url'])) {
				$itin_image = trim((string)$item['image_url']);
			} else if (!empty($item['url_image'])) {
				$itin_image = trim((string)$item['url_image']);
			} else if (!empty($item['photo'])) {
				$itin_image = trim((string)$item['photo']);
			}
			
			if (!empty($itin_image) && $clsVietISOSDK) {
				$tmp_image = $clsVietISOSDK->downloadImageFromUrl($itin_image);
				if (strpos($tmp_image, 'cURL Error') === false && !empty($tmp_image)) {
					$itin_image = $tmp_image;
				}
			}
			
			if (empty($itin_image)) {
				$search_kw = !empty($item['city']) ? trim($item['city']) : (!empty($itin_title) ? $itin_title : '');
				if (!empty($search_kw)) {
					$itin_image = search_and_download_library_image_aiconfig($search_kw, $clsVietISOSDK);
				}
			}
			
			$itin_meals = !empty($item['meals']) ? convertMealsToIds_sub($item['meals']) : '';
			if (empty($itin_meals)) {
				$full_day_text = $itin_title . ' ' . $itin_content;
				$detected_meals = array();
				if (preg_match('/(ăn sáng|bữa sáng|buffet sáng|điểm tâm|breakfast)/iu', $full_day_text)) $detected_meals[] = 'SÁNG';
				if (preg_match('/(ăn trưa|bữa trưa|cơm trưa|lunch)/iu', $full_day_text)) $detected_meals[] = 'TRƯA';
				if (preg_match('/(ăn tối|bữa tối|cơm tối|tiệc tối|dinner)/iu', $full_day_text)) $detected_meals[] = 'TỐI';
				if (!empty($detected_meals)) $itin_meals = convertMealsToIds_sub($detected_meals);
			}

			$itin_transport = !empty($item['transport']) ? convertTransportToIds_sub($item['transport']) : '';
			if (empty($itin_transport)) {
				$full_day_text = $itin_title . ' ' . $itin_content;
				$detected_transport = array();
				if (preg_match('/(máy bay|chuyến bay|flight|bay đi|hàng không)/iu', $full_day_text)) $detected_transport[] = 'Air plane';
				if (preg_match('/(du thuyền|tàu thủy|thuyền|cano|ca nô|cruise|tàu cao tốc)/iu', $full_day_text)) $detected_transport[] = 'Cruise';
				if (preg_match('/(tàu hỏa|tàu lửa|xe lửa|train)/iu', $full_day_text)) $detected_transport[] = 'Train';
				if (preg_match('/(xe đạp|bicycle|cycling)/iu', $full_day_text)) $detected_transport[] = 'Bicycle';
				if (preg_match('/(xe máy|mô tô|motorbike)/iu', $full_day_text)) $detected_transport[] = 'Motorbike';
				if (preg_match('/(xe ô tô|ô tô|xe du lịch|xe đón|xe đưa đón|xe bus|xe buýt|xe khách|car|bus)/iu', $full_day_text)) $detected_transport[] = 'Car';
				if (!empty($detected_transport)) $itin_transport = convertTransportToIds_sub($detected_transport);
			}
			$is_show_image = !empty($itin_image) ? '1' : '0';
			
			$max_itin_id = $clsTourItinerary->getMaxId();
			
			$f_Itinerary = "tour_itinerary_id,tour_id,day,title,slug,content,image,meals,transport,user_id,user_id_update,reg_date,upd_date,order_no,is_trash,is_online,is_show_image,title_contingency";
			$v_Itinerary = "'$max_itin_id','$new_tour_id','$day_num','" . addslashes($itin_title) . "','" . addslashes($itin_slug) . "','" . addslashes($itin_content) . "','" . addslashes($itin_image) . "','" . addslashes($itin_meals) . "','" . addslashes($itin_transport) . "','$user_id','$user_id','$time','$time','$itinerary_order','0','1','$is_show_image',''";
			
			$clsTourItinerary->insertOne($f_Itinerary, $v_Itinerary);
			$itinerary_order++;
		}
	}

	// DESTINATIONS INSERTION
	if (class_exists('TourDestination') && class_exists('City')) {
		$clsTourDestination = new TourDestination();
		$clsCity = new City();
		$clsCountry = class_exists('Country') ? new Country() : null;
		$dest_order = 1;
		
		if (!empty($schema_data['destination']) && is_array($schema_data['destination'])) {
			foreach ($schema_data['destination'] as $dest_name) {
				if (!is_string($dest_name) || empty(trim($dest_name))) continue;
				$dest_name_clean = trim($dest_name);
				
				$lstCity = $clsCity->getAll("is_trash=0 and title like '%" . addslashes($dest_name_clean) . "%' limit 0,1");
				if (empty($lstCity)) {
					$slug_dest = $clsISO->replaceSpace($dest_name_clean);
					$lstCity = $clsCity->getAll("is_trash=0 and slug like '%" . addslashes($slug_dest) . "%' limit 0,1");
				}
				
				$city_id = 0;
				$country_id = 0;
				$region_id = 0;
				$area_id = 0;
				$chauluc_id = 0;
				
				if (!empty($lstCity) && isset($lstCity[0]['city_id'])) {
					$city_id = (int)$lstCity[0]['city_id'];
					$country_id = isset($lstCity[0]['country_id']) ? (int)$lstCity[0]['country_id'] : 0;
					$region_id = isset($lstCity[0]['region_id']) ? (int)$lstCity[0]['region_id'] : 0;
					$area_id = isset($lstCity[0]['area_id']) ? (int)$lstCity[0]['area_id'] : 0;
					$chauluc_id = isset($lstCity[0]['chauluc_id']) ? (int)$lstCity[0]['chauluc_id'] : (isset($lstCity[0]['continent_id']) ? (int)$lstCity[0]['continent_id'] : 0);
				} else if ($clsCountry) {
					$lstCountry = $clsCountry->getAll("is_trash=0 and title like '%" . addslashes($dest_name_clean) . "%' limit 0,1");
					if (!empty($lstCountry) && isset($lstCountry[0]['country_id'])) {
						$country_id = (int)$lstCountry[0]['country_id'];
						$chauluc_id = isset($lstCountry[0]['continent_id']) ? (int)$lstCountry[0]['continent_id'] : 0;
					}
				}
				
				if ($city_id > 0 || $country_id > 0) {
					$max_dest_id = $clsTourDestination->getMaxId();
					$f_dest = "tour_destination_id,tour_id,country_id,region_id,city_id,order_no,val,chauluc_id,area_id,placetogo_id";
					$v_dest = "'$max_dest_id','$new_tour_id','$country_id','$region_id','$city_id','$dest_order','1','$chauluc_id','$area_id','0'";
					$clsTourDestination->insertOne($f_dest, $v_dest);
					$dest_order++;
				}
			}
		}
	}

	$edit_url = PCMS_URL . '/tour_iso/edit/' . $new_tour_id . '/overview';
	
	echo json_encode(array(
		'ok' => true,
		'message' => 'Tour created successfully with AI!',
		'tour_id' => $new_tour_id,
		'trip_code' => $trip_code,
		'edit_url' => $edit_url
	));
	exit();
}
}

if (!function_exists('default_ajax_create_tour_auto_ai_url')) {
function default_ajax_create_tour_auto_ai_url() {
	@set_time_limit(300);
	@ini_set('max_execution_time', 300);
	@ini_set('memory_limit', '512M');
	if (session_status() === PHP_SESSION_ACTIVE) {
		@session_write_close();
	}
	header('Content-Type: application/json; charset=utf-8');
	error_reporting(0);
	ini_set('display_errors', 0);
	global $core, $clsISO, $clsConfiguration, $oneProfile, $_frontIsLoggedin_user_id;

	$url_content = isset($_POST['url_content']) ? trim((string)$_POST['url_content']) : '';
	if (empty($url_content) || !filter_var($url_content, FILTER_VALIDATE_URL)) {
		echo json_encode(array('ok' => false, 'error' => 'Please enter a valid tour webpage URL.'));
		exit();
	}

	$cleaned_web_text = fetch_webpage_content_cleaned($url_content);
	if (empty($cleaned_web_text) || mb_strlen($cleaned_web_text, 'UTF-8') < 50) {
		echo json_encode(array('ok' => false, 'error' => 'Unable to fetch webpage content or insufficient text. Please check the URL or try pasting text directly.'));
		exit();
	}

	$clsConfiguration = new Configuration();
	$api_key = $clsConfiguration->getValue('gemini_api_key');
	if (empty($api_key)) $api_key = $clsConfiguration->getValue('GeminiAPIKey');
	if (empty($api_key)) $api_key = $clsConfiguration->getValue('site_gemini_api_key');

	$gemini_model = $clsConfiguration->getValue('gemini_model_id');
	if (empty($gemini_model)) $gemini_model = $clsConfiguration->getValue('GeminiModel');
	if (empty($gemini_model)) $gemini_model = 'gemini-2.5-flash';

	if (empty($api_key)) {
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Key has not been configured in the system yet.'));
		exit();
	}

	

	$allowed_transports = array("Train", "Bicycle", "Mini Bus", "Cruise", "Motorbike", "Air plane", "Car", "Bus");
	if (!class_exists('Transport')) {
		$file_path = (defined('DIR_CLASSES') ? DIR_CLASSES : ABSPATH . '/classes') . '/class_Transport.php';
		if (file_exists($file_path)) require_once($file_path);
	}
	if (class_exists('Transport')) {
		$clsTransport = new Transport();
		$lstTrDb = $clsTransport->getAll("is_trash=0", "title,transport_id");
		if (!empty($lstTrDb)) {
			$tmp_list = array();
			foreach ($lstTrDb as $trItem) {
				if (!empty($trItem['title'])) {
					$tmp_list[] = trim($trItem['title']);
				}
			}
			if (!empty($tmp_list)) {
				$allowed_transports = array_values($tmp_list);
			}
		}
	}
	$transport_str_list = implode(', ', array_map(function($t) { return '"' . $t . '"'; }, $allowed_transports));

	$system_prompt = "You are an expert AI assistant specializing in extracting travel tour data from documents into JSON.\n";
	$system_prompt .= "IMPORTANT RULES FOR 100% ACCURATE VERBATIM JSON EXTRACTION:\n";
	$system_prompt .= "1. EXTRACT 100% VERBATIM & FULL CONTENT: Extract 100% verbatim all details, titles, timestamps, sightseeing activities, services, and daily itinerary content from the source into valid JSON. DO NOT summarize, shorten, or omit any sentences or paragraphs.\n";
	$system_prompt .= "2. EXTRACT ALL SECTIONS 100%: Tour title, number of days/nights, price, overview, inclusions, exclusions, things to carry, policies (cancellation_policy, refund_policy, confirmation_policy), departure point, destinations, category, and DAILY ITINERARY.\n";
	$system_prompt .= "3. FORMAT OF DAILY ITINERARY `content`:\n";
	$system_prompt .= "   - `content` property of each day IS AN ARRAY OF STRINGS containing all itinerary details.\n";
	$system_prompt .= "   - MUST PRESENT AS HTML LIST items (<ul><li>...</li></ul>) for easy readability.\n";
	$system_prompt .= "   - Lead sentences or timestamps wrapped in <p><strong>...</strong></p>.\n";
	$system_prompt .= "   - ALL sightseeing activities and detailed experiences wrapped in <ul><li>...</li></ul>.\n";
	$system_prompt .= "   - Meals and stay notices placed in separate <p>...</p> tags.\n";
	$system_prompt .= "4. OVERVIEW FORMAT: Overview field should contain structured HTML (<p>...</p>, <ul><li>...</li></ul>) covering general intro, highlights, and itinerary summary.\n";
	$system_prompt .= "5. MEALS & TRANSPORT: Extract meals (e.g. [\"Breakfast\", \"Lunch\", \"Dinner\"]) and transport from allowed list: [" . $transport_str_list . "].\n";
	$target_lang_code = get_active_language_code_sub();
	$target_lang_name = get_language_name_by_code_sub($target_lang_code);

	$system_prompt .= "6. CITY: `city` attribute MUST return 1 main city name for that day.\n";
	$system_prompt .= "7. TARGET OUTPUT LANGUAGE: " . $target_lang_name . " (Code: " . $target_lang_code . ").\n";
	$system_prompt .= "   - If source content is in a different language than " . $target_lang_name . " (e.g. source is Vietnamese/Chinese/Korean but target is " . $target_lang_name . "), YOU MUST TRANSLATE ALL TEXT CONTENT (title, overview, itinerary details, inclusions, exclusions, policies...) into " . $target_lang_name . " accurately and faithfully based on original content without shortening.\n";
	$system_prompt .= "   - If source content matches " . $target_lang_name . ", keep original text 100% verbatim.\n";
	$system_prompt .= "8. Return ONLY 1 valid JSON object matching the required schema.\n";
	$system_prompt .= "9. Do NOT use Markdown block (```json). Only return raw JSON.\n";

	$user_prompt = "Below is the webpage content of the tour program (URL: " . $url_content . "):\n\n" . $cleaned_web_text . "\n\n";
	$user_prompt .= "Please read carefully and extract all tour data into the JSON schema.\n";
	$user_prompt .= "IMPORTANT: Extract 100% verbatim content without summarizing or skipping details.";

	$schema = array(
		"type" => "object",
		"properties" => array(
			"title" => array("type" => "string", "description" => "Tên tour / Tiêu đề chương trình trích xuất từ file"),
			"slug" => array("type" => "string", "description" => "Slug SEO của tour"),
			"trip_code" => array("type" => "string", "description" => "Mã tour ngắn"),
			"tour_group" => array("type" => "string", "description" => "Nhóm tour"),
			"categories" => array("type" => "array", "items" => array("type" => "string")),
			"departure_point" => array("type" => "string"),
			"destination" => array("type" => "array", "items" => array("type" => "string")),
			"price" => array("type" => "integer"),
			"number_day" => array("type" => "integer"),
			"number_night" => array("type" => "integer"),
			"overview" => array("type" => "string"),
			"inclusion" => array("type" => "array", "items" => array("type" => "string")),
			"exclusion" => array("type" => "array", "items" => array("type" => "string")),
			"thing_to_carry" => array("type" => "array", "items" => array("type" => "string")),
			"cancellation_policy" => array("type" => "string"),
			"refund_policy" => array("type" => "string"),
			"confirmation_policy" => array("type" => "string"),
			"itinerary" => array(
				"type" => "array",
				"items" => array(
					"type" => "object",
					"properties" => array(
						"day" => array("type" => "integer"),
						"title" => array("type" => "string"),
						"slug" => array("type" => "string"),
						"content" => array("type" => "array", "items" => array("type" => "string")),
						"image" => array("type" => "string"),
						"meals" => array("type" => "array", "items" => array("type" => "string")),
						"transport" => array("type" => "array", "items" => array("type" => "string", "enum" => $allowed_transports)),
						"city" => array("type" => "string")
					),
					"required" => array("day", "title", "content")
				)
			)
		),
		"required" => array("title", "number_day", "number_night", "overview", "itinerary")
	);

	$parts = array(
		array('text' => $user_prompt)
	);

	$payload = array(
		'systemInstruction' => array('parts' => array(array('text' => $system_prompt))),
		'contents' => array(array('parts' => $parts)),
		'generationConfig' => array(
			'temperature' => 0.0,
			'maxOutputTokens' => 16384,
			'responseMimeType' => 'application/json',
			'responseSchema' => $schema
		)
	);

	$url = "https://generativelanguage.googleapis.com/v1beta/models/" . urlencode($gemini_model) . ":generateContent?key=" . urlencode($api_key);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_TIMEOUT, 180);

	$response = curl_exec($ch);
	$curl_error = curl_error($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($curl_error) {
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Connection Error: ' . $curl_error));
		exit();
	}

	if ($http_code != 200) {
		$err_resp = @json_decode($response, true);
		$msg = isset($err_resp['error']['message']) ? $err_resp['error']['message'] : ('HTTP Code ' . $http_code);
		echo json_encode(array('ok' => false, 'error' => 'ISO AI API Response Error: ' . $msg));
		exit();
	}

	$res_data = @json_decode($response, true);
	$generated_text = '';
	if (isset($res_data['candidates'][0]['content']['parts'][0]['text'])) {
		$generated_text = $res_data['candidates'][0]['content']['parts'][0]['text'];
	}

	$schema_data = parse_schema_json_sub($generated_text);

	// BƯỚC DỊCH CHUẨN HÓA SANG NGÔN NGỮ MỤC TIÊU CỦA WEBSITE NẾU TÀI LIỆU KHÁC NGÔN NGỮ
	if (!empty($schema_data) && is_array($schema_data)) {
		$schema_data = translate_schema_data_to_target_lang_sub($schema_data, $target_lang_code, $api_key, $gemini_model);
	}

	if (empty($schema_data) || !isset($schema_data['title'])) {
		echo json_encode(array('ok' => false, 'error' => 'Unable to extract tour data from this URL. Please check the webpage content format.'));
		exit();
	}

	// 100% AUTOMATED IMPORT TO DB WITH AUTOMATED IMAGE SEARCH & DOWNLOAD
	$clsTour = new Tour();
	$clsTourItinerary = new TourItinerary();
	$clsVietISOSDK = class_exists('VietISOSDK') ? new VietISOSDK() : null;

	$title = !empty($schema_data['title']) ? trim((string)$schema_data['title']) : 'New AI Generated Tour';
	$slug = !empty($schema_data['slug']) ? $clsISO->replaceSpace($schema_data['slug']) : $clsISO->replaceSpace($title);

	$trip_code = !empty($schema_data['trip_code']) ? strtoupper(trim((string)$schema_data['trip_code'])) : '';
	if (empty($trip_code) && method_exists($clsTour, 'generateTripCode')) {
		$trip_code = $clsTour->generateTripCode();
	}
	if (empty($trip_code)) {
		$trip_code = 'AI' . rand(1000, 9999);
	}

	$number_day = isset($schema_data['number_day']) ? (int)$schema_data['number_day'] : 1;
	$number_night = isset($schema_data['number_night']) ? (int)$schema_data['number_night'] : 0;
	if ($number_day <= 0) $number_day = 1;
	if ($number_night < 0) $number_night = 0;

	$overview = !empty($schema_data['overview']) ? build_full_overview_html_sub($schema_data, $target_lang_code) : (isset($schema_data['overview']) ? formatTimelineContent_sub($schema_data['overview']) : '');
	$inclusion = isset($schema_data['inclusion']) ? formatArrayToList_sub($schema_data['inclusion']) : '';
	$exclusion = isset($schema_data['exclusion']) ? formatArrayToList_sub($schema_data['exclusion']) : '';
	$thing_to_carry = isset($schema_data['thing_to_carry']) ? formatArrayToList_sub($schema_data['thing_to_carry']) : '';
	$cancellation_policy = isset($schema_data['cancellation_policy']) ? formatArrayToList_sub($schema_data['cancellation_policy']) : '';
	$refund_policy = isset($schema_data['refund_policy']) ? formatArrayToList_sub($schema_data['refund_policy']) : '';
	$confirmation_policy = isset($schema_data['confirmation_policy']) ? formatArrayToList_sub($schema_data['confirmation_policy']) : '';
	$price = isset($schema_data['price']) ? (int)$schema_data['price'] : 0;

	// KHỚP NỐI CÁC TRƯỜNG LIÊN KẾT HỆ THỐNG ALL-IN-ONE
	$tour_group_id = 0;
	$departure_point_id = 0;
	$list_departure_point_id = '';
	$main_cat_id = 0;
	$list_cat_id = '';
	$tour_option_id = 0;
	$tour_type_id = 0;
	$list_activities_id = '';

	if (class_exists('TourGroup')) {
		$clsTourGroup = new TourGroup();
		if (!empty($schema_data['tour_group'])) {
			$tgroup_name = trim((string)$schema_data['tour_group']);
			$lstGroup = $clsTourGroup->getAll("is_trash=0 and title like '%" . addslashes($tgroup_name) . "%' limit 0,1");
			if (empty($lstGroup)) {
				$slug_group = $clsISO->replaceSpace($tgroup_name);
				$lstGroup = $clsTourGroup->getAll("is_trash=0 and slug like '%" . addslashes($slug_group) . "%' limit 0,1");
			}
			if (!empty($lstGroup) && isset($lstGroup[0]['tour_group_id'])) {
				$tour_group_id = (int)$lstGroup[0]['tour_group_id'];
			}
		}
		if ($tour_group_id == 0) {
			$firstGroup = $clsTourGroup->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstGroup) && isset($firstGroup[0]['tour_group_id'])) {
				$tour_group_id = (int)$firstGroup[0]['tour_group_id'];
			}
		}
	}

	if (class_exists('City')) {
		$clsCity = new City();
		if (!empty($schema_data['departure_point'])) {
			$dep_name = trim((string)$schema_data['departure_point']);
			$lstDep = $clsCity->getAll("is_trash=0 and title like '%" . addslashes($dep_name) . "%' limit 0,1");
			if (empty($lstDep)) {
				$slug_dep = $clsISO->replaceSpace($dep_name);
				$lstDep = $clsCity->getAll("is_trash=0 and slug like '%" . addslashes($slug_dep) . "%' limit 0,1");
			}
			if (!empty($lstDep) && isset($lstDep[0]['city_id'])) {
				$departure_point_id = (int)$lstDep[0]['city_id'];
				$list_departure_point_id = '|' . $departure_point_id . '|';
			}
		}
		if ($departure_point_id == 0) {
			$firstCity = $clsCity->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstCity) && isset($firstCity[0]['city_id'])) {
				$departure_point_id = (int)$firstCity[0]['city_id'];
				$list_departure_point_id = '|' . $departure_point_id . '|';
			}
		}
	}

	if (class_exists('TourCategory')) {
		$clsTourCategory = new TourCategory();
		if (!empty($schema_data['categories']) && is_array($schema_data['categories'])) {
			$tmp_list_cat_id = '|';
			foreach ($schema_data['categories'] as $cat_name) {
				if (!is_string($cat_name) || empty(trim($cat_name))) continue;
				$cname = trim($cat_name);
				$lstCat = $clsTourCategory->getAll("is_trash=0 and title like '%" . addslashes($cname) . "%' limit 0,1");
				if (empty($lstCat)) {
					$slug_cat = $clsISO->replaceSpace($cname);
					$lstCat = $clsTourCategory->getAll("is_trash=0 and slug like '%" . addslashes($slug_cat) . "%' limit 0,1");
				}
				if (!empty($lstCat) && isset($lstCat[0]['tourcat_id'])) {
					$cid = (int)$lstCat[0]['tourcat_id'];
					if ($main_cat_id == 0) $main_cat_id = $cid;
					if (strpos($tmp_list_cat_id, '|' . $cid . '|') === false) {
						$tmp_list_cat_id .= $cid . '|';
					}
				}
			}
			if ($main_cat_id > 0) {
				$list_cat_id = $tmp_list_cat_id;
			}
		}
		if ($main_cat_id == 0) {
			$firstCat = $clsTourCategory->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,1");
			if (!empty($firstCat) && isset($firstCat[0]['tourcat_id'])) {
				$main_cat_id = (int)$firstCat[0]['tourcat_id'];
				$list_cat_id = '|' . $main_cat_id . '|';
			}
		}
	}

	if (!empty($schema_data['tour_option']) && class_exists('TourOption')) {
		$clsTourOption = new TourOption();
		$opt_name = trim((string)$schema_data['tour_option']);
		$lstOpt = $clsTourOption->getAll("is_trash=0 and title like '%" . addslashes($opt_name) . "%' limit 0,1");
		if (!empty($lstOpt) && isset($lstOpt[0]['tour_option_id'])) {
			$tour_option_id = (int)$lstOpt[0]['tour_option_id'];
		}
	}
	if (!empty($schema_data['tour_type']) && class_exists('TourType')) {
		$clsTourType = new TourType();
		$tt_name = trim((string)$schema_data['tour_type']);
		$lstTT = $clsTourType->getAll("is_trash=0 and title like '%" . addslashes($tt_name) . "%' limit 0,1");
		if (!empty($lstTT) && isset($lstTT[0]['tour_type_id'])) {
			$tour_type_id = (int)$lstTT[0]['tour_type_id'];
		}
	}

	if (!empty($schema_data['activity']) && class_exists('Activities')) {
		$clsActivities = new Activities();
		$act_items = is_array($schema_data['activity']) ? $schema_data['activity'] : explode(',', (string)$schema_data['activity']);
		$tmp_list_act_id = '|';
		foreach ($act_items as $act_name) {
			$act_clean = trim((string)$act_name);
			if (empty($act_clean)) continue;
			$lstAct = $clsActivities->getAll("is_trash=0 and title like '%" . addslashes($act_clean) . "%' limit 0,1");
			if (!empty($lstAct) && isset($lstAct[0]['activities_id'])) {
				$aid = (int)$lstAct[0]['activities_id'];
				if (strpos($tmp_list_act_id, '|' . $aid . '|') === false) {
					$tmp_list_act_id .= $aid . '|';
				}
			}
		}
		if ($tmp_list_act_id !== '|') {
			$list_activities_id = $tmp_list_act_id;
		}
	}

	$user_id = $oneProfile['user_id'] ? $oneProfile['user_id'] : (isset($_frontIsLoggedin_user_id) ? $_frontIsLoggedin_user_id : 1);
	$time = time();

	$new_tour_id = $clsTour->getMaxId();

	$f_Tour = "tour_id,title,slug,trip_code,number_day,number_night,overview,is_trash,is_online,user_id,user_id_update,reg_date,upd_date,order_no";
	$order_no = method_exists($clsTour, 'getMaxOrderNo') ? $clsTour->getMaxOrderNo() : 1;
	$v_Tour = "'$new_tour_id','" . addslashes($title) . "','" . addslashes($slug) . "','" . addslashes($trip_code) . "','$number_day','$number_night','" . addslashes($overview) . "','0','1','$user_id','$user_id','$time','$time','$order_no'";

	$clsTour->insertOne($f_Tour, $v_Tour);

	if ($clsTour->checkColumnInTable('lang_id') && !empty($target_lang_code)) $clsTour->updateOne($new_tour_id, "lang_id='" . addslashes($target_lang_code) . "'");
	if ($inclusion !== '') $clsTour->updateOne($new_tour_id, "inclusion='" . addslashes($inclusion) . "'");
	if ($exclusion !== '') $clsTour->updateOne($new_tour_id, "exclusion='" . addslashes($exclusion) . "'");
	if ($thing_to_carry !== '') $clsTour->updateOne($new_tour_id, "thing_to_carry='" . addslashes($thing_to_carry) . "'");
	if ($cancellation_policy !== '') $clsTour->updateOne($new_tour_id, "cancellation_policy='" . addslashes($cancellation_policy) . "'");
	if ($refund_policy !== '') $clsTour->updateOne($new_tour_id, "refund_policy='" . addslashes($refund_policy) . "'");
	if ($confirmation_policy !== '') $clsTour->updateOne($new_tour_id, "confirmation_policy='" . addslashes($confirmation_policy) . "'");
	if ($main_cat_id > 0) $clsTour->updateOne($new_tour_id, "cat_id='$main_cat_id', list_cat_id='" . addslashes($list_cat_id) . "'");
	if ($departure_point_id > 0) $clsTour->updateOne($new_tour_id, "departure_point_id='$departure_point_id', list_departure_point_id='" . addslashes($list_departure_point_id) . "'");
	if ($tour_group_id > 0) $clsTour->updateOne($new_tour_id, "tour_group_id='$tour_group_id'");
	if ($tour_option_id > 0) $clsTour->updateOne($new_tour_id, "tour_option_id='$tour_option_id'");
	if ($tour_type_id > 0) $clsTour->updateOne($new_tour_id, "tour_type_id='$tour_type_id'");
	if ($list_activities_id !== '') $clsTour->updateOne($new_tour_id, "list_activities_id='" . addslashes($list_activities_id) . "'");
	if ($price > 0) $clsTour->updateOne($new_tour_id, "trip_price='$price', min_price='$price'");

	// FEATURED IMAGE SEARCH & DOWNLOAD
	$tour_image = '';
	if (!empty($schema_data['image'])) {
		$tour_image = trim((string)$schema_data['image']);
	} else if (!empty($schema_data['featured_image'])) {
		$tour_image = trim((string)$schema_data['featured_image']);
	} else if (!empty($schema_data['photo'])) {
		$tour_image = trim((string)$schema_data['photo']);
	} else if (!empty($schema_data['image_url'])) {
		$tour_image = trim((string)$schema_data['image_url']);
	}
	if (!empty($tour_image) && $clsVietISOSDK) {
		$tmp_tour_image = $clsVietISOSDK->downloadImageFromUrl($tour_image);
		if (strpos($tmp_tour_image, 'cURL Error') === false && !empty($tmp_tour_image)) {
			$tour_image = $tmp_tour_image;
		}
	}
	if (empty($tour_image) && !empty($title)) {
		$tour_image = search_and_download_library_image_aiconfig($title, $clsVietISOSDK);
	}
	if (!empty($tour_image)) {
		$clsTour->updateOne($new_tour_id, "image='" . addslashes($tour_image) . "'");
	}

	// ITINERARIES INSERTION WITH AUTOMATED IMAGE SEARCH
	$itinerary_list = !empty($schema_data['itinerary']) ? $schema_data['itinerary'] : array();
	if (!empty($itinerary_list) && is_array($itinerary_list)) {
		$itinerary_order = 1;
		foreach ($itinerary_list as $item) {
			if (is_string($item)) {
				$day_lbl = ($target_lang_code === 'vi' || $target_lang_code === 'vn') ? 'Ngày ' : 'Day ';
				$item = array('day' => $itinerary_order, 'title' => $day_lbl . $itinerary_order, 'content' => $item);
			}
			if (!is_array($item)) continue;
			
			$day_num = (isset($item['day']) && (int)$item['day'] > 0) ? (int)$item['day'] : $itinerary_order;
			$day_lbl = ($target_lang_code === 'vi' || $target_lang_code === 'vn') ? 'Ngày ' : 'Day ';
			$raw_title = !empty($item['title']) ? (string)$item['title'] : ($day_lbl . $day_num);
			if ($target_lang_code === 'en') {
				$itin_title = preg_replace('/^Ngày\s*(\d+)\s*[:\.\-]?\s*/iu', 'Day $1: ', $raw_title);
			} else if ($target_lang_code === 'vi' || $target_lang_code === 'vn') {
				$itin_title = preg_replace('/^Day\s*(\d+)\s*[:\.\-]?\s*/iu', 'Ngày $1: ', $raw_title);
			} else {
				$itin_title = $raw_title;
			}
			$itin_slug = !empty($item['slug']) ? $clsISO->replaceSpace($item['slug']) : $clsISO->replaceSpace($itin_title);
			
			$raw_itin_content = !empty($item['content']) ? $item['content'] : (!empty($item['description']) ? $item['description'] : (!empty($item['detail']) ? $item['detail'] : (!empty($item['intro']) ? $item['intro'] : '')));
			$itin_content = formatTimelineContent_sub($raw_itin_content);
			
			$itin_image = '';
			if (!empty($item['image'])) {
				$itin_image = trim((string)$item['image']);
			} else if (!empty($item['image_url'])) {
				$itin_image = trim((string)$item['image_url']);
			} else if (!empty($item['url_image'])) {
				$itin_image = trim((string)$item['url_image']);
			} else if (!empty($item['photo'])) {
				$itin_image = trim((string)$item['photo']);
			}
			
			if (!empty($itin_image) && $clsVietISOSDK) {
				$tmp_image = $clsVietISOSDK->downloadImageFromUrl($itin_image);
				if (strpos($tmp_image, 'cURL Error') === false && !empty($tmp_image)) {
					$itin_image = $tmp_image;
				}
			}
			
			if (empty($itin_image)) {
				$search_kw = !empty($item['city']) ? trim($item['city']) : (!empty($itin_title) ? $itin_title : '');
				if (!empty($search_kw)) {
					$itin_image = search_and_download_library_image_aiconfig($search_kw, $clsVietISOSDK);
				}
			}
			
			$itin_meals = !empty($item['meals']) ? convertMealsToIds_sub($item['meals']) : '';
			if (empty($itin_meals)) {
				$full_day_text = $itin_title . ' ' . $itin_content;
				$detected_meals = array();
				if (preg_match('/(ăn sáng|bữa sáng|buffet sáng|điểm tâm|breakfast)/iu', $full_day_text)) $detected_meals[] = 'SÁNG';
				if (preg_match('/(ăn trưa|bữa trưa|cơm trưa|lunch)/iu', $full_day_text)) $detected_meals[] = 'TRƯA';
				if (preg_match('/(ăn tối|bữa tối|cơm tối|tiệc tối|dinner)/iu', $full_day_text)) $detected_meals[] = 'TỐI';
				if (!empty($detected_meals)) $itin_meals = convertMealsToIds_sub($detected_meals);
			}

			$itin_transport = !empty($item['transport']) ? convertTransportToIds_sub($item['transport']) : '';
			if (empty($itin_transport)) {
				$full_day_text = $itin_title . ' ' . $itin_content;
				$detected_transport = array();
				if (preg_match('/(máy bay|chuyến bay|flight|bay đi|hàng không)/iu', $full_day_text)) $detected_transport[] = 'Air plane';
				if (preg_match('/(du thuyền|tàu thủy|thuyền|cano|ca nô|cruise|tàu cao tốc)/iu', $full_day_text)) $detected_transport[] = 'Cruise';
				if (preg_match('/(tàu hỏa|tàu lửa|xe lửa|train)/iu', $full_day_text)) $detected_transport[] = 'Train';
				if (preg_match('/(xe đạp|bicycle|cycling)/iu', $full_day_text)) $detected_transport[] = 'Bicycle';
				if (preg_match('/(xe máy|mô tô|motorbike)/iu', $full_day_text)) $detected_transport[] = 'Motorbike';
				if (preg_match('/(xe ô tô|ô tô|xe du lịch|xe đón|xe đưa đón|xe bus|xe buýt|xe khách|car|bus)/iu', $full_day_text)) $detected_transport[] = 'Car';
				if (!empty($detected_transport)) $itin_transport = convertTransportToIds_sub($detected_transport);
			}
			$is_show_image = !empty($itin_image) ? '1' : '0';
			
			$max_itin_id = $clsTourItinerary->getMaxId();
			
			$f_Itinerary = "tour_itinerary_id,tour_id,day,title,slug,content,image,meals,transport,user_id,user_id_update,reg_date,upd_date,order_no,is_trash,is_online,is_show_image,title_contingency";
			$v_Itinerary = "'$max_itin_id','$new_tour_id','$day_num','" . addslashes($itin_title) . "','" . addslashes($itin_slug) . "','" . addslashes($itin_content) . "','" . addslashes($itin_image) . "','" . addslashes($itin_meals) . "','" . addslashes($itin_transport) . "','$user_id','$user_id','$time','$time','$itinerary_order','0','1','$is_show_image',''";
			
			$clsTourItinerary->insertOne($f_Itinerary, $v_Itinerary);
			$itinerary_order++;
		}
	}

	// DESTINATIONS INSERTION
	if (class_exists('TourDestination') && class_exists('City')) {
		$clsTourDestination = new TourDestination();
		$clsCity = new City();
		$clsCountry = class_exists('Country') ? new Country() : null;
		$dest_order = 1;
		
		if (!empty($schema_data['destination']) && is_array($schema_data['destination'])) {
			foreach ($schema_data['destination'] as $dest_name) {
				if (!is_string($dest_name) || empty(trim($dest_name))) continue;
				$dest_name_clean = trim($dest_name);
				
				$lstCity = $clsCity->getAll("is_trash=0 and title like '%" . addslashes($dest_name_clean) . "%' limit 0,1");
				if (empty($lstCity)) {
					$slug_dest = $clsISO->replaceSpace($dest_name_clean);
					$lstCity = $clsCity->getAll("is_trash=0 and slug like '%" . addslashes($slug_dest) . "%' limit 0,1");
				}
				
				$city_id = 0;
				$country_id = 0;
				$region_id = 0;
				$area_id = 0;
				$chauluc_id = 0;
				
				if (!empty($lstCity) && isset($lstCity[0]['city_id'])) {
					$city_id = (int)$lstCity[0]['city_id'];
					$country_id = isset($lstCity[0]['country_id']) ? (int)$lstCity[0]['country_id'] : 0;
					$region_id = isset($lstCity[0]['region_id']) ? (int)$lstCity[0]['region_id'] : 0;
					$area_id = isset($lstCity[0]['area_id']) ? (int)$lstCity[0]['area_id'] : 0;
					$chauluc_id = isset($lstCity[0]['chauluc_id']) ? (int)$lstCity[0]['chauluc_id'] : (isset($lstCity[0]['continent_id']) ? (int)$lstCity[0]['continent_id'] : 0);
				} else if ($clsCountry) {
					$lstCountry = $clsCountry->getAll("is_trash=0 and title like '%" . addslashes($dest_name_clean) . "%' limit 0,1");
					if (!empty($lstCountry) && isset($lstCountry[0]['country_id'])) {
						$country_id = (int)$lstCountry[0]['country_id'];
						$chauluc_id = isset($lstCountry[0]['continent_id']) ? (int)$lstCountry[0]['continent_id'] : 0;
					}
				}
				
				if ($city_id > 0 || $country_id > 0) {
					$max_dest_id = $clsTourDestination->getMaxId();
					$f_dest = "tour_destination_id,tour_id,country_id,region_id,city_id,order_no,val,chauluc_id,area_id,placetogo_id";
					$v_dest = "'$max_dest_id','$new_tour_id','$country_id','$region_id','$city_id','$dest_order','1','$chauluc_id','$area_id','0'";
					$clsTourDestination->insertOne($f_dest, $v_dest);
					$dest_order++;
				}
			}
		}
	}

	$edit_url = PCMS_URL . '/tour_iso/edit/' . $new_tour_id . '/overview';
	
	echo json_encode(array(
		'ok' => true,
		'message' => 'Tour created successfully with AI!',
		'tour_id' => $new_tour_id,
		'trip_code' => $trip_code,
		'edit_url' => $edit_url
	));
	exit();
}
}
