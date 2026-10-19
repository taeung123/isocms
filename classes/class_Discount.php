<?php
class Discount extends dbBasic
{
	function __construct()
	{
		$this->pkey = "discount_id";
		$this->tbl = DB_PREFIX . "discount";
	}
	function getCode($discount_id = 0, $oDataTable = null)
	{
		if (!isset($oDataTable['code'])) {
			$oDataTable = $this->getOne($discount_id);
		}
		return $oDataTable['code'];
	}
	function getTitle($discount_id = 0, $one = null)
    {
        if (!isset($one['title'])) {
            $one = $this->getOne($discount_id, 'title');
        }
        return $one['title'];
    }
	function getStatus($discount_id = 0)
	{
		global $dbconn, $core, $clsISO;
		$one = $this->getOne($discount_id);
		$booking_date_from = $one['booking_date_from'] ?? '';
		$booking_date_to = $one['booking_date_to'] ?? '';

		// $due_date = $one['due_date'] ?? '';
		// $is_due_date = $one['is_due_date'] ?? '';

		if ($booking_date_to < time()) {
			$label = 'warning';
			$text = $core->get_Lang('expired');
		} 
		if ($booking_date_from > time()) {
			$label = 'info';
			$text = $core->get_Lang('Ready to start');
		} 
		if ($booking_date_from < time() && $booking_date_to > time()) {
			$label = 'success';
			$text = $core->get_Lang('Starting');
		}
		
		$html = '<span class="p-2 text-white label-' . $label . '">' . $text . '</span>';
		return $html;
	}
	function doDelete($discount_id = 0)
	{

		// Delete Cruise Promotion
		$clsDiscountItem = new DiscountItem();
		$clsDiscountItem->deleteByCond("discount_id='$discount_id'");
		#
		$this->deleteOne($discount_id);
		return 1;
	}
}
