<?php
class Stock extends dbBasic{
	function __construct(){
		$this->pkey = "stock_id";
		$this->tbl = DB_PREFIX."stock";
	}
	function getTotal($voucher_id){
		$tmp = $this->getAll("voucher_id='{$voucher_id}'", "quantily");
		if(!empty($tmp))
			return $tmp[0]['quantily'];
		return 0;
	}
	function init($voucher_id, $quantily){
		$clsVoucher = new Voucher();
		if($clsVoucher->getOneField('is_inventory', $voucher_id)==1){
			$lstcheck = $this->getAll("voucher_id='{$voucher_id}' limit 0,1");
			if(!empty($lstcheck)){
				$this->updateOne($lstcheck[0][$this->pkey], array(
					'is_locked' => 0,
					'quantily' => $quantily,
					'total_quantily' => $quantily,
				));
			} else {
				$stock_id = $this->getMaxId();
				$this->insert(array(
					$this->pkey => $stock_id,
					'voucher_id' => $voucher_id,
					'quantily'	=> $quantily,
					'total_quantily'	=> $quantily,
					'is_locked' => 0
				));
			}
		} else {
			$lstcheck = $this->getAll("voucher_id='{$voucher_id}' limit 0,1");
			if(!empty($lstcheck)){
				$this->updateOne($lstcheck[0][$this->pkey], array(
					'is_locked' => 1
				));
			}
		}
	}
}