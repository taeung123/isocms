<?php
class HotelStore extends dbBasic
{
	function __construct()
	{
		$this->pkey = "hotel_store_id";
		$this->tbl = DB_PREFIX . "hotel_store";
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
		$lstType['HOT'] = $core->get_Lang('Hotel Hot');
		return $lstType;
	}
	function getTitle($type = '')
	{
		$lstType = $this->getListType();
		return $lstType[$type];
	}
	function checkExist($hotel_id = 0, $type = '')
	{
		$res = $this->getAll("hotel_id='$hotel_id' and _type='$type' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
}
