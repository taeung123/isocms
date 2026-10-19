<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class CruisePriceVal extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_price_val_id";
		$this->tbl = DB_PREFIX . "cruise_price_val";
	}
	function getPrice($cruise_price_row_id = 0, $cruise_price_col_id = 0)
	{
		global $core, $clsISO;
		$one = $this->getAll("cruise_price_row_id='$cruise_price_row_id' and cruise_price_col_id='$cruise_price_col_id'");
		return $one[0]['price'] == '' ? $core->get_Lang('null') : $clsISO->getRate() . ' ' . $clsISO->formatPrice($one[0]['price']);
	}
	function getId($cruise_price_row_id = 0, $cruise_price_col_id = 0)
	{
		$one = $this->getAll("cruise_price_row_id='$cruise_price_row_id' and cruise_price_col_id='$cruise_price_col_id'");
		return $one[0]['cruise_price_val_id'];
	}
}
