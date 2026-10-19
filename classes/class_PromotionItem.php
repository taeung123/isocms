<?php
class PromotionItem extends dbBasic
{
    function __construct()
    {
        $this->pkey = "promotion_item_id";
        $this->tbl = DB_PREFIX . "promotion_item";
    }
    function doDelete($pvalTable = 0)
    {
        // Delete
        $this->deleteOne($pvalTable);
        return 1;
    }
    function CountPromotion($tour_id = 0, $promotion_id = 0)
    {
        global $dbconn;
        // Delete
        $count = $dbconn->GetAll("SELECT COUNT(*) as total FROM " . $this->tbl . " WHERE taget_id=$tour_id and promotion_id=$promotion_id");
        return $count[0]['total'];
    }
    function getListPromotion($tour_id = 0)
    {
        global $core, $clsISO, $package_id;
        if ($clsISO->getCheckActiveModulePackage($package_id, 'promotionpro', 'default', 'default', 'tour')) {
            $listItem = $this->getAll("is_online=1 and taget_id='$tour_id' and cruise_intinerary=0", $this->pkey);

            $ListPromotion = array();
            if (!empty($listItem)) {
                foreach ($listItem as $k => $v) {
                    $ListPromotion[] = $this->getPromotion($v[$this->pkey]);
                }
            }

            $ListPromotion = implode(',', $ListPromotion);
            return $ListPromotion;
        }
    }
    function getPromotion($pvalTable = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($pvalTable, 'promotion_id');
        return $one['promotion_id'];
    }
    function CountItemCruise($tour_id = 0, $promotion_id = 0, $inti = 0)
    {
        global $dbconn;
        // Delete
        $count = $dbconn->GetAll("SELECT COUNT(*) as total FROM " . $this->tbl . " WHERE taget_id=$tour_id and promotion_id=$promotion_id and cruise_intinerary=$inti");
        return $count[0]['total'];
    }
    function doDeleteAllByProId($list_pro_id = 0)
    {
        global $dbconn;
        // Delete
        $this->deleteByCond("promotion_id in ($list_pro_id)");
        return 1;
    }
}
