<?php
class Partner extends dbBasic
{
	function __construct()
	{
		global $_LANG_ID;
		$this->pkey = "partner_id";
		$this->tbl = DB_PREFIX . "partner";
	}
	function getTitle($partner_id = 0)
	{
		$one = $this->getOne($partner_id, 'title');
		return $one['title'];
	}
	function getImage($pvalTable = 0, $w = '', $h = '')
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return $clsISO->tripslashImage($image, $w, $h);
		}
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getImage1($partner_id = 0)
	{
		$one = $this->getOne($partner_id, "image");
		return $one['image'];
	}
	function getUrlImage($pvalTable = 0, $oneTable = null)
	{
		global $clsISO;
		if (empty($oneTable['image'])) {
			$oneTable = $this->getOne($pvalTable, "image");
		}

		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
		//return $clsISO->tripslashUrlWebp($url_image);
	}
	function getLink($partner_id = 0)
	{
		$one = $this->getOne($partner_id, "url");
		return $one['url'];
	}
	function getIntro($partner_id = 0)
	{
		$one = $this->getOne($partner_id, 'intro');
		return html_entity_decode($one['intro']);
	}
	function doDelete($pvalTable = 0)
	{
		$this->deleteOne($pvalTable);
		return 1;
	}
}
