<?php
class EmailTemplate extends dbBasic
{
	function __construct()
	{
		$this->pkey = "email_template_id";
		$this->tbl = DB_PREFIX . "email_template";
	}
	function getListType()
	{
		$_array = array();
		$_array['_CONTACT'] = 'Mẫu E-Mail Liên hệ';
		$_array['_NEWSLETTER'] = 'Mẫu E-Mail Nhận bản tin';
		$_array['_CUSTOMIZE_TOUR'] = 'Mẫu E-Mail Customize Tour';
		$_array['_BOOKING_TOUR'] = 'Mẫu E-Mail Booking Tour';
		$_array['_BOOKING_HOTEL'] = 'Mẫu E-Mail Booking Hotel';
		return $_array;
	}
	function getTitle($pvalTable = 0)
	{
		global $_LANG_ID;

		$one = $this->getOne($pvalTable, 'email_content_setting');
		$raw = $one['email_content_setting'] ?? '';

		// Chỉ unserialize nếu là chuỗi hợp lệ
		$email_content_setting = @unserialize($raw);
		if (!is_array($email_content_setting)) {
			$email_content_setting = [];
		}

		// Lấy title theo ngôn ngữ hiện tại hoặc fallback sang tiếng Anh
		$title = '';
		if (!empty($email_content_setting[$_LANG_ID]['title'])) {
			$title = $email_content_setting[$_LANG_ID]['title'];
		} elseif (!empty($email_content_setting['en']['title'])) {
			$title = $email_content_setting['en']['title'];
		}

		return html_entity_decode((string) $title);
	}

	function getSubject($pvalTable = 0)
	{
		global $_LANG_ID;

		$one = $this->getOne($pvalTable, 'email_content_setting');
		$raw = $one['email_content_setting'] ?? '';
		$email_content_setting = @unserialize($raw);
		if (!is_array($email_content_setting)) {
			$email_content_setting = [];
		}

		$subject = '';
		if (!empty($email_content_setting[$_LANG_ID]['subject'])) {
			$subject = $email_content_setting[$_LANG_ID]['subject'];
		} elseif (!empty($email_content_setting['en']['subject'])) {
			$subject = $email_content_setting['en']['subject'];
		}

		return html_entity_decode((string) $subject);
	}

	function getContent($pvalTable = 0)
	{
		global $_LANG_ID;

		$one = $this->getOne($pvalTable, 'email_content_setting');
		$raw = $one['email_content_setting'] ?? '';
		$email_content_setting = @unserialize($raw);
		if (!is_array($email_content_setting)) {
			$email_content_setting = [];
		}

		$content = '';
		if (!empty($email_content_setting[$_LANG_ID]['content'])) {
			$content = $email_content_setting[$_LANG_ID]['content'];
		} elseif (!empty($email_content_setting['en']['content'])) {
			$content = $email_content_setting['en']['content'];
		}

		return html_entity_decode((string) $content);
	}

	function getHeader($pvalTable = 0)
	{
		global $_LANG_ID;

		$one = $this->getOne($pvalTable, 'email_content_setting');
		$raw = $one['email_content_setting'] ?? '';
		$email_content_setting = @unserialize($raw);
		if (!is_array($email_content_setting)) {
			$email_content_setting = [];
		}

		$header = '';
		if (!empty($email_content_setting[$_LANG_ID]['header'])) {
			$header = $email_content_setting[$_LANG_ID]['header'];
		} elseif (!empty($email_content_setting['en']['header'])) {
			$header = $email_content_setting['en']['header'];
		}

		return html_entity_decode((string) $header);
	}

	function getFooter($pvalTable = 0)
	{
		global $_LANG_ID;

		$one = $this->getOne($pvalTable, 'email_content_setting');
		$raw = $one['email_content_setting'] ?? '';
		$email_content_setting = @unserialize($raw);
		if (!is_array($email_content_setting)) {
			$email_content_setting = [];
		}

		$footer = '';
		if (!empty($email_content_setting[$_LANG_ID]['footer'])) {
			$footer = $email_content_setting[$_LANG_ID]['footer'];
		} elseif (!empty($email_content_setting['en']['footer'])) {
			$footer = $email_content_setting['en']['footer'];
		}

		return html_entity_decode((string) $footer);
	}

	function getFromName($pvalTable = 0)
	{
		global $_LANG_ID;

		$one = $this->getOne($pvalTable, 'email_content_setting');
		$raw = $one['email_content_setting'] ?? '';

		// Kiểm tra dữ liệu trước khi unserialize
		$email_content_setting = @unserialize($raw);
		if (!is_array($email_content_setting)) {
			$email_content_setting = [];
		}

		// Lấy "fromname" theo ngôn ngữ, fallback sang tiếng Anh
		$fromName = '';
		if (!empty($email_content_setting[$_LANG_ID]['fromname'])) {
			$fromName = $email_content_setting[$_LANG_ID]['fromname'];
		} elseif (!empty($email_content_setting['en']['fromname'])) {
			$fromName = $email_content_setting['en']['fromname'];
		}

		return html_entity_decode((string) $fromName);
	}

	function getFromEmail($pvalTable = 0)
	{
		global $_LANG_ID;

		$one = $this->getOne($pvalTable, 'email_content_setting');
		$raw = $one['email_content_setting'] ?? '';

		// Kiểm tra dữ liệu trước khi unserialize
		$email_content_setting = @unserialize($raw);
		if (!is_array($email_content_setting)) {
			$email_content_setting = [];
		}

		// Lấy fromemail theo ngôn ngữ hiện tại hoặc fallback sang tiếng Anh
		$fromEmail = '';
		if (!empty($email_content_setting[$_LANG_ID]['fromemail'])) {
			$fromEmail = $email_content_setting[$_LANG_ID]['fromemail'];
		} elseif (!empty($email_content_setting['en']['fromemail'])) {
			$fromEmail = $email_content_setting['en']['fromemail'];
		}

		return html_entity_decode((string) $fromEmail);
	}

	function getCopyTo($pvalTable = 0)
	{
		global $_LANG_ID;

		$one = $this->getOne($pvalTable, 'email_content_setting');
		$raw = $one['email_content_setting'] ?? '';

		// Chỉ unserialize nếu dữ liệu hợp lệ
		$email_content_setting = @unserialize($raw);
		if (!is_array($email_content_setting)) {
			$email_content_setting = [];
		}

		// Lấy copyto theo ngôn ngữ hiện tại, fallback sang tiếng Anh
		$copyTo = '';
		if (!empty($email_content_setting[$_LANG_ID]['copyto'])) {
			$copyTo = $email_content_setting[$_LANG_ID]['copyto'];
		} elseif (!empty($email_content_setting['en']['copyto'])) {
			$copyTo = $email_content_setting['en']['copyto'];
		}

		return html_entity_decode((string) $copyTo);
	}

	function getListEmailTemplate($email_template_cat_id = 0)
	{
		$res = $this->getAll("is_trash=0 and cat_id='{$email_template_cat_id}'");
		return !empty($res) ? $res : false;
	}
	function makeSelectboxOption($selected = '')
	{
		$lstType = $this->getListType();
		$html = '<option value=""><< Lựa chọn >></option>';
		foreach ($lstType as $key => $val) {
			$sl = ($key == $selected) ? 'selected="selected"' : '';
			$html .= '<option value="' . $key . '" ' . $sl . '>' . $val . '</option>';
		}
		return $html;
	}
}
