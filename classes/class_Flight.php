<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class Flight extends dbBasic
{
	function __construct()
	{
		$this->pkey = "flight_id";
		$this->tbl = DB_PREFIX . "flight";
	}
	function getType($flight_id = 0)
	{
		return $this->getOneField('_type', $flight_id) == 0 ? 'Chuyến đi' : 'Chuyến về';
	}
	function getStartDate($flight_id = 0)
	{
		return date('d/m/Y', $this->getOneField('start_date', $flight_id));
	}
	function getEndDate($flight_id = 0)
	{
		return date('d/m/Y', $this->getOneField('end_date', $flight_id));
	}
	function getFlightCode($flight_id = 0)
	{
		return $this->getOneField('flight_code', $flight_id);
	}
	function getStartTime($flight_id = 0)
	{
		return $this->getOneField('start_hour', $flight_id) . ':' . $this->getOneField('start_minute', $flight_id);
	}
	function getEndTime($flight_id = 0)
	{
		return $this->getOneField('end_hour', $flight_id) . ':' . $this->getOneField('end_minute', $flight_id);
	}
}
