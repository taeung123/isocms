<?php
class Download extends dbBasic
{
	function __construct()
	{
		global $_LANG_ID;
		$this->pkey = "download_id";
		$this->tbl = DB_PREFIX . "download";
	}
	function getTitle($download_id = 0, $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['title'])) {
			$one = $this->getOne($download_id, 'title');
		}
		return $one['title'];
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getIntro($download_id = 0, $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['intro'])) {
			$one = $this->getOne($download_id, 'intro');
		}
		return html_entity_decode($one['intro']);
	}
	function getLink($slug_country = '')
	{
		global $_LANG_ID, $clsISO;
		$link = $clsISO->getLink('sale_tool') . '/' . $slug_country;

		return $link;
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
	{
		global $clsISO;
		#
		if (!isset($oneTable['image'])) {
			$oneTable = $this->getOne($pvalTable, 'image');
		}
		if ($oneTable['image'] != '' && $clsISO->checkFileExists($oneTable['image'])) {
			$image = $oneTable['image'];
			return $clsISO->tripslashImage($image, $w, $h);
		}
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getFileSize($download_id = 0, $type = 'KB', $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['attachment_file'])) {
			$one = $this->getOne($download_id, 'attachment_file');
		}
		if ($type == 'MB') {
			$filesize = number_format(filesize(ABSPATH . $one['attachment_file']) / 1024 / 1024);
		} else {
			$filesize = number_format(filesize(ABSPATH . $one['attachment_file']) / 1024);
		}
		return $filesize . ' ' . $type;
	}
	function getFileExtension($download_id = 0, $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['attachment_file'])) {
			$one = $this->getOne($download_id, 'attachment_file');
		}
		$arr = explode(".", $one['attachment_file']);
		return end($arr);
	}
	function getTripPrice($download_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($download_id, 'trip_price');
		return $one['trip_price'];
	}
	function getTripPriceOld($download_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($download_id, 'trip_price_old');
		return $one['trip_price_old'];
	}
	function doDelete($pvalTable = 0)
	{
		$clsISO = new ISO();
		#
		$this->deleteOne($pvalTable);
		return 1;
	}
}
