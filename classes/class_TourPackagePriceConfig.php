<?php

class TourPackagePriceConfig extends dbBasic
{
    function __construct()
    {
        $this->pkey = "tp_price_cfg_id";
        $this->tbl = DB_PREFIX . "tour_package_price_config";
    }

    function checkOnlineBySlug($pvalTable = 0, $slug = '')
    {
        $item = $this->getAll("is_trash=0 and is_online=1 and blog_id='$pvalTable' and slug='$slug'", $this->pkey);
        if (empty($item))
            return 0;
        return 1;
    }

    function getSlash($level = 0)
    {
        return str_repeat("------", $level + 1);
    }

    function getTitle($pvalTable = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['title'])) {
            $one = $this->getOne($pvalTable, 'title');
        }
        return $one['title'];
    }

    function getImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
    {
        global $clsISO;
        #
        if (!isset($oneTable['image'])) {
            $oneTable = $this->getOne($pvalTable, 'image');
        }
        if ($oneTable['image'] != '') {
            $image = $oneTable['image'];
            return $clsISO->tripslashImage($image, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }

    function getPriceBooking($tour_id = 0, $tour_class_id = 0, $tour_number_group_id = 0, $tour_visitor_type_id = 0, $departure = 0)
    {
        $price = 0;
        $sql = "tour_package_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id='$tour_visitor_type_id'";
        $sql .= " and departure_date='$departure'";
        $sql .= " limit 0,1";
        // var_dump($sql);die();
        $lst = $this->getAll($sql);
        if (!empty($lst[0]['price'])) {
            $price = $lst[0]['price'];
        }
        return $price;
    }

    function doDelete($pvalTable = 0)
    {

        $clsBlogDestination = new BlogDestination();
        $clsBlogDestination->deleteByCond("blog_id='$pvalTable'");

        $clsBlogExtension = new BlogExtension();
        $clsBlogExtension->deleteByCond("blog_id='$pvalTable'");
        $this->deleteOne($pvalTable);
        return 1;
    }
}
