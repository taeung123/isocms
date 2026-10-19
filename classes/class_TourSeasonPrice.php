<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class TourSeasonPrice extends dbBasic
{
	function __construct()
	{
		global $_LANG_ID;
		$this->pkey = "tour_season_price_id";
		$this->tbl = DB_PREFIX . "tour_season_price";
	}
	function getTitle($tour_season_price_id = 0)
	{
		$one = $this->getOne($tour_season_price_id, 'title');
		return $one['title'];
	}
}
