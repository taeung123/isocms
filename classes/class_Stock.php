<?php
class Stock extends dbBasic
{
	function __construct()
	{
		$this->pkey = "stock_id";
		$this->tbl = DB_PREFIX . "stock";
	}
	function getTotal($voucher_id = 0)
	{
		global $clsISO;
		$tmp = $this->getAll("voucher_id='{$voucher_id}'", "quantily");

		if (!empty($tmp))
			return $tmp[0]['quantily'];
		return 0;
	}
	function getTotalOut($voucher_id = 0)
	{
		$tmp = $this->getAll("voucher_id='{$voucher_id}'", "total_out");
		if (!empty($tmp))
			return $tmp[0]['total_out'];
		return 0;
	}
	function init($voucher_id = 0, $total_quantily = 0)
	{
		$clsVoucher = new Voucher();
		if ($clsVoucher->getOneField('is_inventory', $voucher_id) == 1) {
			$lstcheck = $this->getAll("voucher_id='{$voucher_id}' limit 0,1");
			if (!empty($lstcheck)) {
				$total_quantily_old = $lstcheck[0]['total_quantily'];
				$quantily_old = $lstcheck[0]['quantily'];
				$quantily = $quantily_old + $total_quantily - $total_quantily_old;
				$quantily = ($quantily > 0) ? $quantily : 0;
				$this->updateOne($lstcheck[0][$this->pkey], array(
					'is_locked' => 0,
					'quantily' => $quantily,
					'total_quantily' => $total_quantily,
				));
			} else {
				$stock_id = $this->getMaxId();
				$this->insert(array(
					$this->pkey => $stock_id,
					'voucher_id' => $voucher_id,
					'quantily'	=> $total_quantily,
					'total_quantily'	=> $total_quantily,
					'is_locked' => 0
				));
			}
		} else {
			$lstcheck = $this->getAll("voucher_id='{$voucher_id}' limit 0,1");
			if (!empty($lstcheck)) {
				$this->updateOne($lstcheck[0][$this->pkey], array(
					'is_locked' => 1
				));
			}
		}
	}
}
