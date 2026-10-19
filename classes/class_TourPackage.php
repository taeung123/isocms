<?php

class TourPackage extends dbBasic
{
    function __construct()
    {
        $this->pkey = "tour_package_id";
        $this->tbl = DB_PREFIX . "tour_package";
    }

    function checkOnlineBySlug($pvalTable = 0, $slug = '')
    {
        $item = $this->getAll("is_trash=0 and is_online=1 and blog_id='$pvalTable' and slug='$slug'", $this->pkey);
        if (empty($item))
            return 0;
        return 1;
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
