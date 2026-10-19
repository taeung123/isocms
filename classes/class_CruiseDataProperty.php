<?php
class CruiseDataProperty extends dbBasic
{
    function __construct()
    {
        $this->pkey = "cruise_data_property_id";
        $this->tbl = DB_PREFIX . "cruise_data_property";
    }
    function getTitle($cruise_data_property_id = 0)
    {
        $one = $this->getOne($cruise_data_property_id);
        return $one['fieldvalue'];
    }
    function getFieldValue($cruise_data_property_id = 0)
    {
        $one = $this->getOne($cruise_data_property_id);
        return $one['fieldvalue'];
    }
    function getFieldValue2($cruise_id = 0, $cruise_property_id = 0)
    {
        $one = $this->getAll("cruise_id='$cruise_id' and cruise_property_id='$cruise_property_id' order by order_no ASC");
        return $one[0]['fieldvalue'];
    }
    function getSlug($cruise_data_property_id = 0)
    {
        $one = $this->getOne($cruise_data_property_id);
        return $one['slug'];
    }
    function getBySlug($slug = '')
    {
        $all = $this->getAll("is_trash=0 and is_online=1 and slug='$slug' limit 0,1", $this->pkey);
        return $all[0][$this->pkey];
    }
    function checkExitsId($cruise_data_property_id = 0)
    {
        $res = $this->getAll("cruise_data_property_id = '$cruise_data_property_id' LIMIT 0,1");
        return !empty($res) ? 1 : 0;
    }
    function countNumberImages($cruise_data_property_id = 0, $type = '')
    {
        $clsHotelImage = new HotelImage();
        return $clsHotelImage->countItem("is_trash=0 and table_id = '$cruise_data_property_id'");
    }
}
