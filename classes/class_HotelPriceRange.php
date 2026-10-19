<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class HotelPriceRange extends dbBasic
{
	function __construct()
	{
		$this->pkey = "hotel_price_range_id";
		$this->tbl = DB_PREFIX . "hotel_price_range";
	}
	function getTitle($hotel_price_range_id = 0, $one = null)
	{
		if (!isset($one['title'])) {
			$one = $this->getOne($hotel_price_range_id, 'title');
		}
		return $one['title'];
	}
	function getMin($hotel_price_range_id = 0)
	{
		$one = $this->getOne($hotel_price_range_id, 'min_rate');
		return number_format($one['min_rate']);
	}
	function getMax($hotel_price_range_id = 0)
	{
		$one = $this->getOne($hotel_price_range_id, 'max_rate');
		return number_format($one['max_rate']);
	}
}
