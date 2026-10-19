<?php
class Transport extends dbBasic
{
	function __construct()
	{
		$this->pkey = "transport_id";
		$this->tbl = DB_PREFIX . "transport";
	}
	function getTitle($transport_id = 0, $one = null)
	{
		if (!isset($one['title'])) {
			$one = $this->getOne($transport_id, 'title');
		}
		return $one['title'] ?? '';
	}
	function getIntro($transport_id = 0)
	{
		$one = $this->getOne($transport_id, 'intro');
		return $one['intro'] ?? '';
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
	{
		global $clsISO;
		if (!isset($oneTable['image'])) {
			$oneTable = $this->getOne($pvalTable, "image");
		}
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return $clsISO->tripslashImage($image, $w, $h);
		}
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getImageUrl($pvalTable = 0, $oneTable = null)
	{
		global $clsISO;
		if (!isset($oneTable['image'])) {
			$oneTable = $this->getOne($pvalTable, "image");
		}
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function getNumAvailableBooking($transport_id = 0)
	{
		$BOOK_ADDON = vnSessionGetVar('BOOK_ADDON');
		if (empty($BOOK_ADDON)) return 0;
		$num = 0;
		foreach ($BOOK_ADDON as $k => $v) {
			if (intval($transport_id) > 0 && $k == $transport_id) {
				$num = $v;
				break;
			}
		}
		return $num;
	}
	function doDelete($pvalTable = 0)
	{
		$clsISO = new ISO();
		#
		$image = $this->getOneField("image", $pvalTable);
		if (trim($image) != '') {
			if ($clsISO->checkContainer($image, DOMAIN_NAME)) {
				$image = $_SERVER['DOCUMENT_ROOT'] . $clsISO->parseImageURL($image, false);
				$clsISO->deleteFile($image);
				$image = $_SERVER['DOCUMENT_ROOT'] . $clsISO->parseImageURL($image, false);
				$clsISO->deleteFile($image);
			}
		}
		#
		$this->deleteOne($pvalTable);
		return 1;
	}
}
