<?php
class TransferPrice extends dbBasic
{
	function __construct()
	{
		$this->pkey = "transfer_price_id";
		$this->tbl = DB_PREFIX . "transfer_price";
	}
	function getId($transfer_id = 0, $car_id = 0, $type_of_trip_id = 0)
	{
		$res = $this->getAll("transfer_id='$transfer_id' and car_id='$car_id' and type_of_trip_id='$type_of_trip_id' LIMIT 0,1");
		return $res[0][$this->pkey];
	}
	function getPrice($transfer_id = 0, $car_id = 0, $type_of_trip_id = 0)
	{
		global $_LANG_ID;
		$price = '';
		$lst = $this->getAll("transfer_id='$transfer_id' and car_id='$car_id' and type_of_trip_id='$type_of_trip_id' limit 0,1");
		if ($lst[0][$this->pkey] != '') {
			$price = $lst[0]['price'];
		}
		return $price;
	}
	function getPriceGraft($transfer_id = 0, $car_id = 0, $seat_id = 0, $type_of_trip_id = 0)
	{
		global $_LANG_ID;
		$price = '';
		$lst = $this->getAll("transfer_id='$transfer_id' and car_id='$car_id' and type_of_trip_id='$type_of_trip_id' limit 0,1");
		if ($lst[0][$this->pkey] != '') {
			$price = $lst[0]['price_graft'];
		}
		return $price;
	}
	function getPriceCheap($transfer_id = 0, $car_id = 0, $seat_id = 0, $type_of_trip_id = 0)
	{
		global $_LANG_ID;
		$price = '';
		$lst = $this->getAll("transfer_id='$transfer_id' and car_id='$car_id' and type_of_trip_id='$type_of_trip_id' limit 0,1");
		if ($lst[0][$this->pkey] != '') {
			$price = $lst[0]['price_cheap'];
		}
		return $price;
	}
	function getPriceKmPlus($transfer_id = 0, $car_id = 0, $seat_id = 0, $type_of_trip_id = 0)
	{
		global $_LANG_ID;
		$price = '';
		$lst = $this->getAll("transfer_id='$transfer_id' and car_id='$car_id' and type_of_trip_id='$type_of_trip_id' limit 0,1");
		if ($lst[0][$this->pkey] != '') {
			$price = $lst[0]['price_km_plus'];
		}
		return $price;
	}
}
