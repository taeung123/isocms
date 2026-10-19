<?php

class HotelService extends dbBasic
{
    function __construct()
    {
        $this->pkey = "hotel_service_id";
        $this->tbl = DB_PREFIX . "hotel_services";
    }
}
