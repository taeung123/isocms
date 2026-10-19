<?php
class YearJourney extends dbBasic
{
	function __construct()
	{
		$this->pkey = "year_journey_id";
		$this->tbl = DB_PREFIX . "year_journey";
	}
	function getTitle($pvalTable = 0, $_args = array())
	{
		global $_LANG_ID;
		if (is_array($_args) && $_args['title'] != '') {
			return $_args['title'];
		} else {
			$one = $this->getOne($pvalTable, "title");
			return $one['title'];
		}
	}
	function getIntro($pvalTable = 0, $_args = array())
	{
		global $_LANG_ID;
		if (is_array($_args) && $_args['intro'] != '') {
			return $_args['intro'];
		} else {
			$one = $this->getOne($pvalTable, "intro");
			return html_entity_decode($one['intro']);
		}
	}
	function getLink($pvalTable = 0, $_args = array())
	{
		global $_LANG_ID;
		if (is_array($_args) && $_args['link'] != '') {
			return $_args['link'];
		} else {
			$one = $this->getOne($pvalTable, "link");
			return $one['link'];
		}
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
	{
		global $clsISO, $deviceType;
		if (!isset($oneTable['image'])) {
			$oneTable = $this->getOne($pvalTable, 'image');
		}
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
		}
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getImage2($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		return $oneTable['image'];
	}
	function getIcon($pvalTable = 0, $oneTable = null)
	{
		global $clsISO;
		if (!isset($oneTable['icon'])) {
			$oneTable = $this->getOne($pvalTable, "icon");
		}
		return $oneTable['icon'];
	}
	function getYear($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "year");
		return $oneTable['year'];
	}
	function getImageUrl($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		return $oneTable['image'];
	}
	function doDelete($pvalTable_id = 0)
	{
		$this->deleteOne($pvalTable_id);
		return 1;
	}
}
