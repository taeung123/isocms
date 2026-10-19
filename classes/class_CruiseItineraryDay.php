<?php
class CruiseItineraryDay extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_itinerary_day_id";
		$this->tbl = DB_PREFIX . "cruise_itinerary_day";
	}
	function checkContain($haystack = '', $needle = '')
	{
		$pos = strpos($haystack, $needle);
		if ($pos === false) {
			return 0;
		} else {
			return 1;
		}
	}
	function getMaxDay($cruise_itinerary_id = 0)
	{
		$clsCruiseItinerary = new CruiseItinerary();
		$res = $this->countItem("is_trash=0 and cruise_itinerary_id='$cruise_itinerary_id' order by day desc");
		$number_day = $clsCruiseItinerary->getOneField('number_day', $cruise_itinerary_id);
		if ($res < $number_day) {
			return $res + 1;
		} else {
			return $number_day;
		}
	}
	function checkMealExist($meal = '', $cruise_itinerary_day_id = 0)
	{
		$meals = $this->getOneField('meals', $cruise_itinerary_day_id);
		if ($meals == '' || $meal == '') {
			return 0;
		}
		$tmp = explode(',', $meals);
		if (!in_array($meal, $tmp))
			return 0;
		return 1;
	}
	function checkExist($day = 0, $cruise_itinerary_id = 0)
	{
		$res = $this->getAll("day='$day' and cruise_itinerary_id='$cruise_itinerary_id' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function getTitle($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'title');
		return $one['title'];
	}
	function getContent($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'content');
		return html_entity_decode($one['content'] ?? '');
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return $clsISO->tripslashImage($image, $w, $h);
			$noimage = URL_IMAGES . '/noimage.png';
			return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
		}
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getUrlImage($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function checkShowImage($pvalTable = 0)
	{
		$res = $this->getAll("cruise_itinerary_day_id='$pvalTable' and is_show_image='1' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function getRegDate($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'reg_date');
		return date('H:i d/m/Y', $one['reg_date']);
	}
	function getArriveTime($pvalTable = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($pvalTable, 'arrive_time');
		if (!empty($one['arrive_time'])) {
			return date('Y/m/d H:i', $one['arrive_time']);
		}
	}
	function getDepartTime($pvalTable = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($pvalTable, 'depart_time');
		if (!empty($one['depart_time'])) {
			return date('Y/m/d H:i', $one['depart_time']);
		}
	}
	function getDay($pvalTable = 0)
	{
		global $core, $_LANG_ID;
		$one = $this->getOne($pvalTable, 'day');
		$prefix = $core->get_Lang('Day');
		$day = $one['day'];
		if (is_numeric($day)) {
			return $prefix . '&nbsp;' . $one['day'];
		} else {
			return $one['day'];
		}
	}
	function doDelete($cruise_itinerary_day_id = 0)
	{
		$clsISO = new ISO();
		$this->deleteOne($cruise_itinerary_day_id);
		return 1;
	}
	function checkTransportExist($transport = '', $cruise_itinerary_day_id = 0)
	{
		$transports = $this->getOneField('transport', $cruise_itinerary_day_id);
		if ($transports == '' || $transport == '') {
			return 0;
		}
		$tmp = explode(',', $transports);
		if (!in_array($transport, $tmp))
			return 0;
		return 1;
	}
}
