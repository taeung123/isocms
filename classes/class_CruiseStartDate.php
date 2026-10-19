<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class CruiseStartDate extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_start_date_id";
		$this->tbl = DB_PREFIX . "cruise_start_date";
	}
	function getTitle($tour_price_col_id = 0)
	{
		$one = $this->getOne($tour_price_col_id, 'title');
		return $one['title'];
	}
	function getTripCode($cruise_start_date_id = 0)
	{
		$start_date = $this->getOneField('start_date', $cruise_start_date_id);
		$date =  date('d', $start_date) . date('m', $start_date) . date('y', $start_date);
		$clsCruise = new Cruise();
		return 'CR-' . $date;
	}
	function getEndDate($cruise_start_date_id = 0)
	{
		$clsCruise = new Cruise();
		$start_date = $this->getOneField('start_date', $cruise_start_date_id);
		$cruise_id = $this->getOneField('cruise_id', $cruise_start_date_id);
		if ($this->getOneField('end_date', $cruise_start_date_id) == 0)
			return $start_date + 24 * 60 * 60;
		else
			return $this->getOneField('end_date', $cruise_start_date_id);
	}
	function getEndDateDefault($cruise_start_date_id = 0)
	{
		$clsCruise = new Cruise();
		$start_date = $this->getOneField('start_date', $cruise_start_date_id);
		$cruise_id = $this->getOneField('cruise_id', $cruise_start_date_id);
		return $start_date + 24 * 60 * 60;
	}
}
