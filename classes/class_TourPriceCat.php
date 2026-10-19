<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class TourPriceCat extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_price_cat_id";
		$this->tbl = DB_PREFIX . "tour_price_cat";
	}
}
