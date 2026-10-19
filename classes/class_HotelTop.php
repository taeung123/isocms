<?php
class HotelTop extends dbBasic
{
	function __construct()
	{
		$this->pkey = "hoteltop_id";
		$this->tbl = DB_PREFIX . "hoteltop";
	}
}
