<?php
class CityRegion extends dbBasic
{

    function __construct()
    {
        $this->pkey = "city_region_id";
        $this->tbl = DB_PREFIX . "city_region";
    }

    function getMaxOrder($hotel_id = 0)
    {
        $res = $this->getAll("1=1 and hotel_id='$hotel_id' order by order_no desc");
        return intval($res[0]['order_no']) + 1;
    }

    function getTitle($city_region_id = 0)
    {
        $one = $this->getOne($city_region_id);
        return $one['fieldvalue'];
    }

    function getOrderNo($city_region_id = 0)
    {
        $one = $this->getOne($city_region_id);
        return $one['order_no'];
    }

    function getSlug($city_region_id = 0)
    {
        $one = $this->getOne($city_region_id);
        return $one['slug'];
    }

    function getBySlug($slug = '')
    {
        $all = $this->getAll("is_trash=0 and is_online=1 and slug='$slug' limit 0,1", $this->pkey);
        return $all[0][$this->pkey];
    }

    function checkExitsId($city_region_id = 0)
    {
        $res = $this->getAll("city_region_id = '$city_region_id' LIMIT 0,1");
        return !empty($res) ? 1 : 0;
    }

    function checkExist($hotel_id = 0, $city_id = 0)
    {
        $res = $this->getAll("hotel_id='$hotel_id' and city_id='$city_id' limit 0,1");
        return (!empty($res)) ? 1 : 0;
    }

    function countNumberImages($city_region_id = 0, $type = '')
    {
        $clsHotelImage = new HotelImage();
        return $clsHotelImage->countItem("is_trash=0 and table_id = '$city_region_id'");
    }
}
