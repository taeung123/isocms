<?php

class HotelPackage extends dbBasic
{
    function __construct()
    {
        $this->pkey = "hotel_package_id";
        $this->tbl = DB_PREFIX . "hotel_packages";
    }
}
