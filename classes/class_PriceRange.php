<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class PriceRange extends dbBasic
{
	function __construct()
	{
		$this->pkey = "price_range_id";
		$this->tbl = DB_PREFIX . "price_range";
	}
	function getTitle($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'title');
		return $one['title'] ?? '';
	}
	function getMin($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'min_rate');
		return number_format($one['min_rate'] ?? 0);
	}
	function getMax($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'max_rate');
		return number_format($one['max_rate'] ?? 0);
	}
	function getSelectByPrice($type = 0, $selected = '')
	{
		global $core, $_lang;
		#
		$type = !empty($type) ? intval($type) : 1;
		$all = $this->getAll("is_trash=0 and type='$type' order by order_no asc");
		$html = '<option value="">-- ' . $core->get_Lang('pricerange') . ' --</option>';
		if (!empty($all)) {
			$i = 0;
			foreach ($all as $item) {
				$selected_index = ($selected == $item[$this->pkey]) ? 'selected="selected"' : '';
				$html .= '<option value="' . $item[$this->pkey] . '" ' . $selected_index . '>-- ' . $this->getTitle($item[$this->pkey]) . ' --</option>';
				++$i;
			}
		}
		return $html;
	}
	function getSelectByPriceLFilter($type = '', $price_range_ID = 0)
	{
		global $core, $clsISO, $_lang;
		#

		$all = $this->getAll("is_trash=0 and type='$type' order by order_no asc");
		$html = '';
		if (!empty($all)) {
			$i = 0;
			foreach ($all as $item) {
				$html .= '<li>
					<input id="p' . $item[$this->pkey] . '" class="typeSearch" name="price_range_ID[]" value="' . $item[$this->pkey] . '" type="checkbox" ' . ($clsISO->checkInArray($price_range_ID, $item[$this->pkey]) ? 'selected="selected"' : '') . '/>
<label for="p' . $item[$this->pkey] . '" class="twoFilter">' . $this->getTitle($item[$this->pkey]) . '</label>	
				  </li>';
				++$i;
			}
		}
		return $html;
	}
}
