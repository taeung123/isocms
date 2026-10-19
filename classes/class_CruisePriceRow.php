<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class CruisePriceRow extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_price_row_id";
		$this->tbl = DB_PREFIX . "cruise_price_row";
	}
	function getTitle($cruise_price_row_id = 0)
	{
		$one = $this->getOne($cruise_price_row_id, 'title');
		return $one['title'];
	}
}
