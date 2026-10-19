<?php

class CruisePriceTable extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_price_table_id";
		$this->tbl = DB_PREFIX . "cruise_price_table";
	}
	function getSeason($cruise_price_table_id = 0)
	{
		$one = $this->getOne($cruise_price_table_id, 'season');
		return $one['season'];
	}
	function getPrice($cruise_id = 0, $cruise_cabin_id = 0, $cruise_itinerary_id = 0, $property_id = 0, $season = '')
	{
		global $core, $clsISO;
		$one = $this->getAll("cruise_id='$cruise_id' and cruise_cabin_id='$cruise_cabin_id' and cruise_itinerary_id='$cruise_itinerary_id' and property_id='$property_id' and season = '$season' limit 0,1");
		return $one[0]['price'] == '' ? $core->get_Lang('null') : $clsISO->getRate() . '' . $clsISO->formatPrice($one[0]['price']);
	}
}
