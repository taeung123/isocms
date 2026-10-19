<?php
class TourTransport extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tourtransport_id";
		$this->tbl = DB_PREFIX . "tourtransport";
	}
	function getTitle($tourtransport_id = 0)
	{
		$one = $this->getOne($tourtransport_id, 'title');
		return $one['title'];
	}
	function getIntro($tourtransport_id = 0)
	{
		$one = $this->getOne($tourtransport_id, 'intro');
		return $one['intro'];
	}
	function getImageUrl($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function getNumAvailableBooking($tourtransport_id = 0)
	{
		$BOOK_ADDON = vnSessionGetVar('BOOK_ADDON');
		if (empty($BOOK_ADDON)) return 0;
		$num = 0;
		foreach ($BOOK_ADDON as $k => $v) {
			if (intval($tourtransport_id) > 0 && $k == $tourtransport_id) {
				$num = $v;
				break;
			}
		}
		return $num;
	}
}
