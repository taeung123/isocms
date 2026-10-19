<?php

class HotelPackageService extends dbBasic
{
    function __construct()
    {
        $this->pkey = "hotel_package_service_id";
        $this->tbl = DB_PREFIX . "hotel_package_service";
    }
}
