<?php
class TourCustomField extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_customfield_id";
		$this->tbl = DB_PREFIX . "tour_customfield";
	}
}
