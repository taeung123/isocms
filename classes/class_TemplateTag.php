<?php
class TemplateTag extends dbBasic
{
	function __construct()
	{
		$this->pkey = "template_tag_id";
		$this->tbl = DB_PREFIX . "template_tag";
	}
	function getTitle($pval = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pval);
		return $one['title'];
	}
	function getReplaceTag($pval = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pval);
		return $one['replace_tag'];
	}
}
