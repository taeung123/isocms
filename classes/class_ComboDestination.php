<?php
class ComboDestination extends dbBasic
{
	function __construct()
	{
		$this->pkey = "combo_destination_id";
		$this->tbl = DB_PREFIX . "combo_destination";
	}
	function getMaxOrderNoByTour($combo_id = 0)
	{
		$res = $this->getAll("combo_id='$combo_id' order by order_no DESC limit 0,1");
		return intval($res[0]['order_no']) + 1;
	}
	function checkExist($combo_id = 0)
	{
		$res = $this->getAll("combo_id='$combo_id' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function getByDestination($combo_id = 0, $destination_id = 0)
	{
		$all = $this->getAll("is_trash=0 and combo_id='$combo_id' and destination_id='$destination_id' order by " . $this->pkey . " limit 0,1");
		return $all[0][$this->pkey];
	}
}
