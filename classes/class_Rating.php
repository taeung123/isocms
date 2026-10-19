<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (about_haiphong@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */

class Rating extends dbBasic
{
	function __construct()
	{
		$this->pkey = "rating_id";
		$this->tbl = DB_PREFIX . "rating";
	}
	function checkRating($for_id = 0, $type, $user_ip = 0)
	{
		$all = $this->getAll("for_id='$for_id' and type='$type' and user_ip='$user_ip' limit 0,1");
		return !empty($all) ? 1 : 0;
	}
}
