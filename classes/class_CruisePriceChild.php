<?php

class CruisePriceChild extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_price_child_id";
		$this->tbl = DB_PREFIX . "cruise_price_child";
	}
	function getTitle($pvalTable = 0, $one = null)
	{
		if (!isset($one['title'])) {
			$one = $this->getOne($pvalTable, 'title');
		}
		return $one['title'] ?? '';
	}
	function getMin($pvalTable = 0, $one = null)
	{
		if (!isset($one['min'])) {
			$one = $this->getOne($pvalTable, 'min');
		}
		return $one['min'] ?? 0;
	}
	function getMax($pvalTable = 0, $one = null)
	{
		if (!isset($one['max'])) {
			$one = $this->getOne($pvalTable, 'max');
		}
		return $one['max'] ?? 0;
	}
}
