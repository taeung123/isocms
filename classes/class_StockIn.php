<?php if (!defined('ABSPATH')) exit('No direct script access allowed');
/*======================================================================*\
|| #################################################################### ||
|| # The Classes configurations of the ISOCMS                         # ||
|| # ISOCMS 6.0.0 VietISO Techical Team (luongtiendung@gmail.com)     # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
class StockIn extends dbBasic
{
	function __construct()
	{
		$this->pkey = "id";
		$this->tbl = DB_PREFIX . "stock_in";
	}
	function genCode($product_id = 0)
	{
		$total_in = $this->countItem("product_id='{$product_id}'");
		if ($total_in >= 1 && $total_in < 10) return 'NK000' . $total_in;
		if ($total_in >= 10 && $total_in < 100) return 'NK00' . $total_in;
		if ($total_in >= 100 && $total_in < 1000) return 'NK0' . $total_in;
		return 'NK' . $total_in;
	}
}
