<?php
class Team extends dbBasic
{
    function __construct()
    {
        $this->pkey = "team_id";
        $this->tbl = DB_PREFIX . "team";
    }
    function getImage($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, "image");
        if ($oneTable['image'] != '') {
            $image = $oneTable['image'];
            return $clsISO->tripslashImage($image, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }
    function getUrlImage($pvalTable = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, "image");
        $url_image = $oneTable['image'];
        return $clsISO->tripslashUrl($url_image);
    }
    function getName($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'name');
        return $one['name'];
    }
    function getAbout($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'content');
        return html_entity_decode($one['content']);
    }
    function doDelete($pvalTable = 0)
    {
        $clsISO = new ISO();
        #
        $this->deleteOne($pvalTable);
        return 1;
    }
}
