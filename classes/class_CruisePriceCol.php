<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class CruisePriceCol extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_price_col_id";
		$this->tbl = DB_PREFIX . "cruise_price_col";
	}

	function getTitle($cruise_price_col_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($cruise_price_col_id, 'title');
		return $one['title'];
	}
}
