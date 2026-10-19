<?php
class Why extends dbBasic
{
	function __construct()
	{
		$this->pkey = "why_id";
		$this->tbl = DB_PREFIX . "why";
	}
	function getTitle($why_id = 0, $one = null)
	{
		if (!isset($one['title'])) {
			$one = $this->getOne($why_id, 'title');
		}
		return $one['title'] ?? '';
	}
	function getImageUrl($why_id = 0)
	{
		global $clsISO;
		$one = $this->getOne($why_id, 'image');
		$url_image = $one['image'] ?? '';
		return $clsISO->tripslashUrl($url_image);
	}
	function getIcon($why_id = 0, $oneTable = null)
	{
		global $clsISO;

		if (!isset($oneTable['image'])) {
			$oneTable = $this->getOne($why_id, "image");
		}
		$url_image = $oneTable['image'] ?? '';
		return $clsISO->tripslashUrl($url_image);
		//return $clsISO->tripslashUrlWebp($url_image);
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro'] ?? '');
	}
	function getStripIntro($why_id = 0, $one = null)
	{
		if (!isset($one['intro'])) {
			$one = $this->getOne($why_id, 'intro');
		}
		return strip_tags(html_entity_decode($one['intro'] ?? ''));
	}
	function getIntro($why_id = 0, $one = null)
	{
		if (!isset($one['intro'])) {
			$one = $this->getOne($why_id, 'intro');
		}
		return html_entity_decode($one['intro'] ?? '');
	}
	function checkExist($why_id = 0, $type = '')
	{
		$res = $this->getAll("why_id='$why_id' and type='$type' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function doDelete($why_id = 0)
	{
		$this->deleteOne($why_id);
		return 1;
	}
}
