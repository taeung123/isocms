<?php
class TourService extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tourservice_id";
		$this->tbl = DB_PREFIX . "tourservice";
	}
	function getTitle($tourservice_id = 0)
	{
		$one = $this->getOne($tourservice_id, 'title');
		return $one['title'];
	}
	function getPrice($tourservice_id = 0)
	{
		global $clsISO;
		$one = $this->getOne($tourservice_id, 'price');
		return $clsISO->formatPrice($one['price']);
	}
	function getPriceOrgin($tourservice_id = 0)
	{
		global $clsISO;
		$one = $this->getOne($tourservice_id, 'price');
		return $clsISO->processSmartNumber($one['price']);
	}
	function getIntro($tourservice_id = 0)
	{
		$one = $this->getOne($tourservice_id, 'intro');
		return $one['intro'];
	}
	function getImageUrl($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function getNumAvailableBooking($tourservice_id = 0)
	{
		$BOOK_ADDON = vnSessionGetVar('BOOK_ADDON');
		if (empty($BOOK_ADDON)) return 0;
		$num = 0;
		foreach ($BOOK_ADDON as $k => $v) {
			if (intval($tourservice_id) > 0 && $k == $tourservice_id) {
				$num = $v;
				break;
			}
		}
		return $num;
	}
}
