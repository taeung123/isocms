<?php
class TourHome extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_home_id";
		$this->tbl = DB_PREFIX . "tour_home";
	}
	function checkExist($tour_id = 0)
	{
		$res = $this->getAll("is_trash=0 and tour_id='$tour_id' limit 0,1");
		return !empty($res) ? 1 : 0;
	}
	function countTourHome($type = "", $country_id = "")
	{
		if ($type == "all") {
			$res = $this->getAll("is_trash=0");
			return !empty($res) ? count($res) : 0;
		}
		$res = $this->getAll("is_trash=0 and country_id='$country_id'");
		return !empty($res) ? count($res) : 0;
	}
}
