<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class TourPriceCustomerType extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_price_customer_type_id";
		$this->tbl = DB_PREFIX . "tour_price_customer_type";
	}
	function getTitle($tour_price_customer_type_id = 0)
	{
		$one = $this->getOne($tour_price_customer_type_id, 'title');
		return $one['title'];
	}
}
