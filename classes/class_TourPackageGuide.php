<?php

class TourPackageGuide extends dbBasic
{
    function __construct()
    {
        $this->pkey = "tour_package_guide";
        $this->tbl = DB_PREFIX . "tour_package_guide";
    }
}