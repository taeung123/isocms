<?php

class CruiseStore extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_store_id";
		$this->tbl = DB_PREFIX . "cruise_store";
	}
	function getMaxOrder($type = '')
	{
		$res = $this->getAll("1=1 and _type='$type' order by order_no desc");
		return intval($res[0]['order_no']) + 1;
	}
	function getListType()
	{
		global $core;
		$lstType = array();
		$lstType['RECOMMED'] = $core->get_Lang('Recommed');
		return $lstType;
	}
	function getListTypeItinerary()
	{
		global $core;
		$lstType = array();
		$lstType['BESTDEAL'] = $core->get_Lang('Best Deals');
		return $lstType;
	}
	function getTitle($type = '')
	{
		$lstType = $this->getListType();
		return $lstType[$type];
	}
	function checkExist($cruise_id = 0, $type = '')
	{
		$res = $this->getAll("cruise_id='$cruise_id' and _type='$type' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function checkExistItinerary($cruise_id = 0, $cruise_itinerary_id = 0, $type = '')
	{
		$res = $this->getAll("cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and _type='$type' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
}
