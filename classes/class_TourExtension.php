<?php
class TourExtension extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_extension_id";
		$this->tbl = DB_PREFIX . "tour_extension";
	}
	function checkExist($tour_1_id = 0, $tour_2_id = 0)
	{
		$res = $this->getAll("is_trash=0 and tour_1_id='$tour_1_id' and tour_2_id='$tour_2_id' limit 0,1");
		return !empty($res) ? 1 : 0;
	}
	function checkExistOne($tour_1_id = 0)
	{
		$res = $this->getAll("is_trash=0 and tour_1_id='$tour_1_id' limit 0,1");
		return !empty($res) ? 1 : 0;
	}
}
