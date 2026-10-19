<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class HotelPriceVal extends dbBasic
{
	function __construct()
	{
		$this->pkey = "hotel_price_val_id";
		$this->tbl = DB_PREFIX . "hotel_price_val";
	}

	function getPrice($hotel_price_row_id = 0, $hotel_price_col_id = 0)
	{
		$one = $this->getAll("hotel_price_row_id='$hotel_price_row_id' and hotel_price_col_id='$hotel_price_col_id'");
		return $one[0]['price'] == '' ? '0' : $one[0]['price'];
	}
	function getId($hotel_price_row_id = 0, $hotel_price_col_id = 0)
	{
		$one = $this->getAll("hotel_price_row_id='$hotel_price_row_id' and hotel_price_col_id='$hotel_price_col_id'");
		return $one[0]['hotel_price_val_id'];
	}
}
