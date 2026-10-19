<?php
class VoucherCode extends dbBasic
{
	function __construct()
	{
		global $_LANG_ID;
		$this->pkey = "voucher_code_id";
		$this->tbl = DB_PREFIX . "voucher_code";
	}
	
	function checkStatus($voucher_code_id)
	{
		$one = $this->getOne($voucher_code_id);

		if (empty($one)) {
			return 'Unknown';
		}

		if ($one['redeemed_at'] !== null) {
			return 'Redeemed';
		}

		if ($one['cancelled_at'] !== null) {
			return 'Cancelled';
		}

		if ($one['expired_at'] !== null) {
			return 'Expired';
		}

		if ($one['sold_at'] !== null) {
			return 'Sold';
		}

		$today = date('Y-m-d');

		$valid_from = date('Y-m-d', $one['valid_from']);
		$valid_to   = date('Y-m-d', $one['valid_to']);

		if ($today >= $valid_from && $today <= $valid_to) {
			return 'Available';
		}

		return 'Unknown';
	}

	function getTotalByVoucherProduct($voucher_product_id)
	{
        $all = $this->getAll("voucher_product_id = '$voucher_product_id'", $this->pkey);
        return $all ? count($all) : 0;
	}
	function getTotalAvailableByVoucherProduct($voucher_product_id)
	{
        $all = $this->getAll("voucher_product_id = '$voucher_product_id' AND is_trash=0 AND is_online=1 AND redeemed_at is NULL AND expired_at is NULL AND cancelled_at is NULL AND valid_to > UNIX_TIMESTAMP() AND valid_from <= UNIX_TIMESTAMP()", $this->pkey);
        return $all ? count($all) : 0;
	}
	function getTotalSoldByVoucherProduct($voucher_product_id)
	{
        $all = $this->getAll("voucher_product_id = '$voucher_product_id' AND is_trash=0 and is_online=1 and sold_at is NOT NULL", $this->pkey);
        return $all ? count($all) : 0;
	}
	function getTotalRedeemedByVoucherProduct($voucher_product_id)
	{
        $all = $this->getAll("voucher_product_id = '$voucher_product_id' AND is_trash=0 and is_online=1 and redeemed_at is NOT NULL", $this->pkey);
        return $all ? count($all) : 0;
	}
	function doDelete($pvalTable = 0)
	{
		$this->deleteOne($pvalTable);
		/** Delete Image */
		$clsDiscountItem = new DiscountItem();
		$clsDiscountItem->deleteByCond("item_id='$pvalTable' and clsTable ='Voucher'");

		$clsImage = new Image();
		$clsImage->deleteByCond("type='_PRODUCT' and table_id='{$pvalTable}'");
		/* Store */
		$clsVoucherStore = new VoucherStore();
		$clsVoucherStore->deleteByCond("voucher_id='{$pvalTable}'");
		/** Delete Stock */
		$clsStock = new Stock();
		$clsStock->deleteByCond("voucher_id='{$pvalTable}'");
		return 1;
	}
}
