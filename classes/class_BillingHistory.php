<?php
class BillingHistory extends dbBasic
{
    function __construct()
    {
        $this->pkey = "billing_history_id";
        $this->tbl = DB_PREFIX . "billing_history";
    }
    function getPaymentTermComplete($booking_id = 0, $bill_type = "PAYMENT")
    {
        if ($booking_id > 0) {
            $cond = "booking_id = '" . $booking_id . "' and status = 1 and bill_type='" . $bill_type . "'";
            $deposit = $this->getAll($cond, 'SUM(bill_money) as deposit');
            return ($deposit[0]['deposit'] > 0) ? $deposit[0]['deposit'] : 0;
        }
        return false;
    }
    function getFieldValue($billing_history_id = 0, $field_name = '')
    {
        global $core;
        if (!isset($oDataTable[$field_name])) {
            $oDataTable = $this->getOne($billing_history_id, $field_name);
            if (isset($oDataTable["status"])) {
                if ($oDataTable["status"] == 1) return $core->get_Lang('Completly payment');
                else return $core->get_Lang('Waiting Payment');
            }
        }
        return $oDataTable[$field_name];
    }
}
