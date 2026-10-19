<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class HotelPriceCol extends dbBasic
{
	function __construct()
	{
		$this->pkey = "hotel_price_col_id";
		$this->tbl = DB_PREFIX . "hotel_price_col";
	}
	function getTitle($pval = 0)
	{
		$one = $this->getOne($pval, 'title');
		return $one['title'];
	}
}
