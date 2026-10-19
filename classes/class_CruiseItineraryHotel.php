<?php

class CruiseItineraryHotel extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_itinerary_hotel_id";
		$this->tbl = DB_PREFIX . "cruise_itinerary_hotel";
	}
	function getName($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'name');
		return $one['name'];
	}
	function getAddress($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'address');
		return $one['address'];
	}
}
