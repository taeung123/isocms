<?php
class AreaCityStore extends dbBasic
{
    function __construct()
    {
        $this->pkey = "citystore_id";
        $this->tbl = DB_PREFIX . "area_citystore";
    }
    function getListType()
    {
        global $core;
        $lstType = array();
        $lstType['DEPARTUREPOINT'] = $core->get_Lang('departurepoint');
        $lstType['TOP'] = $core->get_Lang('toparea_city');
        return $lstType;
    }
    function getTitle($type = '')
    {
        $lstType = $this->getListType();
        return $lstType[$type];
    }
    function checkExist($area_city_id = 0, $type = '')
    {
        $res = $this->getAll("area_city_id='$area_city_id' and type='$type' limit 0,1");
        return (!empty($res)) ? 1 : 0;
    }
}
