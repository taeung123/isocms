<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class CruiseSeasonPrice extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_season_price_id";
		$this->tbl = DB_PREFIX . "cruise_season_price";
	}
	function getPrice($cruise_itinerary_id = 0, $cruise_cabin_id = 0, $cabin_type_id = 0, $season = '')
	{
		global $clsISO;
		$res = $this->getAll("cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and cabin_type_id='$cabin_type_id' and season='$season' LIMIT 0,1", "price");
		return $clsISO->formatPrice($res[0]['price']);
	}
	function getPriceDefault($cruise_itinerary_id = 0, $cruise_cabin_id = 0, $group_size_id = 0, $season = '', $number_adult = 0)
	{
		global $clsISO;
		$res = $this->getAll("cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and group_size_id='$group_size_id' and season='$season' and number_adult='$number_adult' LIMIT 0,1", "price");
		$price = $res[0]['price'];
		if ($price > 0)
			return $res[0]['price'];
		return '';
	}
	function getPriceExtraBedDefault($cruise_itinerary_id = 0, $cruise_cabin_id = 0, $group_size_id = 0, $season = '')
	{
		global $clsISO;
		$res = $this->getAll("cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and group_size_id='$group_size_id' and season='$season' LIMIT 0,1", "price_extra_bed");
		$price = $res[0]['price_extra_bed'];
		if ($price > 0)
			return $res[0]['price_extra_bed'];
		return '';
	}
	function getPriceExtraBed($cruise_itinerary_id = 0, $cruise_cabin_id = 0, $group_size_id = 0, $season = '')
	{
		global $clsISO;
		$res = $this->getAll("cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and group_size_id='$group_size_id' and season='$season' LIMIT 0,1", "price_extra_bed");
		$price = $res[0]['price_extra_bed'];
		return $price ? $price : 0;
	}
	function getPriceFor1Adult($cruise_itinerary_id = 0, $cruise_cabin_id = 0, $group_size_id = 0, $season = 0, $number_adult = 0)
	{
		global $clsISO;
		$clsCruiseItinerary = new CruiseItinerary();
		$clsCruiseCabin = new CruiseCabin();

		$oneItinerary = $clsCruiseItinerary->getOne($cruise_itinerary_id, "price_by_high,price_by_low,cruise_id");
		$lstCruiseCabinID = $clsCruiseCabin->getAll("is_trash=0 and is_online=1 and cruise_id='" . $oneItinerary['cruise_id'] . "' and cruise_cabin_id IN (SELECT cruise_cabin_id FROM " . DB_PREFIX . "cruise_season_price WHERE cruise_itinerary_id='$cruise_itinerary_id' and season='$season')", $clsCruiseCabin->pkey);
		if ($season == 'high') {
			$price_by = $oneItinerary['price_by_high'];
		} else {
			$price_by = $oneItinerary['price_by_low'];
		}
		$numberAdult = ($price_by == 0) ? $number_adult : 0;
		$res = $this->getAll("cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and group_size_id='$group_size_id' and season='$season' and number_adult='$numberAdult' LIMIT 0,1", "price");
		$price = $res[0]['price'];
		if ($price > 0) {
			if ($price_by == 0) { //0: theo giá /người; 1: theo giá phòng
				$price_1_adult = $res[0]['price'];
			} else {
				$price_1_adult = ((int)$res[0]['price']) / (int)$number_adult;
			}
			return $price_1_adult;
		}
		return '';
	}
	function getPriceBy($cruise_itinerary_id = 0, $cruise_cabin_id = 0, $group_size_id = 0, $season = '')
	{
		global $clsISO;
		$res = $this->getAll("cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and group_size_id='$group_size_id' and season='$season' LIMIT 0,1", "price_by");
		return $clsISO->formatPrice($res[0]['price_by']);
	}
	function getIsHide($cruise_id = 0, $cruise_itinerary_id = 0, $cabin_type_id = 0, $season = '')
	{
		$res = $this->getAll("cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and cabin_type_id='$cabin_type_id' and season='$season' LIMIT 0,1");
		return $res[0]['is_hide'];
	}
}
