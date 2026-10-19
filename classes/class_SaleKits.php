<?php
class SaleKits extends dbBasic
{
	function __construct()
	{
		$this->pkey = "salekit_id";
		$this->tbl = DB_PREFIX . "salekits";
	}
	function getTitle($salekit_id = 0, $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['title'])) {
			$one = $this->getOne($salekit_id, 'title');
		}
		return $one['title'] ?? '';
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro'] ?? '');
	}
	function getIntro($salekit_id = 0, $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['intro'])) {
			$one = $this->getOne($salekit_id, 'intro');
		}
		return html_entity_decode($one['intro'] ?? '');
	}
	function getFileSize($salekit_id = 0, $type = 'KB', $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['attachment_file'])) {
			$one = $this->getOne($salekit_id, 'attachment_file');
		}
		if ($type == 'MB') {
			$filesize = number_format(filesize(ABSPATH . $one['attachment_file']) / 1024 / 1024);
		} else {
			$filesize = number_format(filesize(ABSPATH . $one['attachment_file']) / 1024);
		}
		return $filesize . ' ' . $type;
	}
	function getFileExtension($salekit_id = 0, $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['attachment_file'])) {
			$one = $this->getOne($salekit_id, 'attachment_file');
		}
		$arr = explode(".", $one['attachment_file']);
		return end($arr);
	}
	function doDelete($pvalTable = 0)
	{
		$clsISO = new ISO();
		#
		$this->deleteOne($pvalTable);
		return 1;
	}
}
