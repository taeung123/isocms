<?php
class HotelAttraction extends dbBasic
{
    function __construct()
    {
        $this->pkey = "hotel_attraction_id";
        $this->tbl = DB_PREFIX . "hotel_attraction";
    }
    function getTitle($hotel_attraction_id = 0)
    {
        $one = $this->getOne($hotel_attraction_id, 'fieldvalue');
        return $one['fieldvalue'];
    }
    function getSlug($hotel_attraction_id = 0)
    {
        $one = $this->getOne($hotel_attraction_id, 'slug');
        return $one['slug'];
    }
    function getBySlug($slug = '')
    {
        $all = $this->getAll("is_trash=0 and is_online=1 and slug='$slug' limit 0,1", $this->pkey);
        return $all[0][$this->pkey];
    }
    function checkExitsId($hotel_attraction_id = 0)
    {
        $res = $this->getAll("hotel_attraction_id = '$hotel_attraction_id' LIMIT 0,1");
        return !empty($res) ? 1 : 0;
    }
    function countNumberImages($hotel_attraction_id = 0, $type = '')
    {
        $clsHotelImage = new HotelImage();
        return $clsHotelImage->countItem("is_trash=0 and table_id = '$hotel_attraction_id'");
    }
}
