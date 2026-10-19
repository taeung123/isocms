<?php
class VoucherStore extends dbBasic
{
	function __construct()
	{
		$this->pkey = "voucher_store_id";
		$this->tbl = DB_PREFIX . "voucher_store";
	}
	function getTitle($type = '')
	{
		$lstType = $this->getListType();
		return $lstType[$type];
	}
	function checkAvailable($voucher_type = '', $for_id = 0, $voucher_id = 0)
	{
		$where = "is_trash=0 and voucher_type='{$voucher_type}' and for_id='{$for_id}' and voucher_id='{$voucher_id}'";
		return $this->countItem($where);
	}
	function getId($voucher_type = '', $for_id = 0, $voucher_id = 0)
	{
		$where = "is_trash=0 and voucher_type='{$voucher_type}' and for_id='{$for_id}' and voucher_id='{$voucher_id}'";
		$tmp = $this->getAll($where . " limit 0,1");
		return !empty($tmp) ? $tmp[0][$this->pkey] : 0;
	}
	function getListType()
	{
		global $core;
		$lstType = array();
		$lstType['NEW'] = $core->get_Lang('vouchernew');
		$lstType['PROMOTION'] = $core->get_Lang('voucherSaleoff');
		$lstType['TOPSELLING'] = $core->get_Lang('vouchertopselling');
		return $lstType;
	}
	function checkExist($voucher_id = 0, $type = '')
	{
		$res = $this->getAll("voucher_id='{$voucher_id}' and _type='{$type}' limit 0,1");
		return !empty($res) ? 1 : 0;
	}
}
