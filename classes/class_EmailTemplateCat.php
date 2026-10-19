<?php
class EmailTemplateCat extends dbBasic
{
	function __construct()
	{
		$this->pkey = "email_template_cat_id";
		$this->tbl = DB_PREFIX . "email_template_cat";
	}
	function getTitle($pval = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pval, 'title');
		return $one['title'];
	}
	function getContent($pval = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pval);
		return $one['content_' . $_LANG_ID];
	}
	function makeSelectboxOption($email_template_cat_id = '')
	{
		global $core;
		$res = $this->getALl("is_trash=0 order by order_no desc");
		$Html = '<option value="">-- Chọn danh mục --</option>';
		if (!empty($res)) {
			foreach ($res as $item) {
				$selected = ($email_template_cat_id == $item[$this->pkey]) ? 'selected="selected"' : '';
				$Html .= '<option title="' . $this->getTitle($item[$this->pkey]) . '" value="' . $item[$this->pkey] . '" ' . $selected . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
			}
		}
		return $Html;
	}
}
