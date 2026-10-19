<?php
class TourHotel extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_hotel_id";
		$this->tbl = DB_PREFIX . "tour_hotel";
	}
	function getName($tour_hotel_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($tour_hotel_id, 'name');
		return $one['name'];
	}
	function getAddress($tour_hotel_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($tour_hotel_id, 'address');
		return $one['address'];
	}
}
