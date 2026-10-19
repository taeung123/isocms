<?php
class PaymentConfig extends dbBasic
{
    function __construct()
    {
        $this->pkey = "payment_id";
        $this->tbl = DB_PREFIX . "payment";
    }
    function getListPayment() {}
    function initPayment() {}
}
