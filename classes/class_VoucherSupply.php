<?php
class VoucherSupply extends dbBasic
{
	function __construct()
	{
		global $_LANG_ID;
		$this->pkey = "supply_id";
		$this->tbl = DB_PREFIX . "voucher_supply";
	}
	function getTitle($pvalTable = 0, $one = null)
    {
        if (!isset($one['supply_name'])) {
            $one = $this->getOne($pvalTable);
        }
        return $one['supply_name'] ?? '';
    }
    function getCode($pvalTable = 0, $one = null)
    {
        if (!isset($one['code'])) {
            $one = $this->getOne($pvalTable);
        }
        return $one['code'] ?? '';
    }
	function makeSelectboxOption($catid = 0, $selected = '')
    {
        return $this->getListOption($catid, $selected);
    }
    function getListOption($cat_id = 0)
    {
        global $core, $dbconn, $_LANG_ID;
        $arrOptionsCategory = array();;
        $this->makeOption(0, "", 0, $arrOptionsCategory);

        $html = '<option value="0" >' . $core->get_Lang('All Suppliers') . '</option>';
        foreach ($arrOptionsCategory as $k => $v) {
            $selected = ($k == $cat_id) ? 'selected="selected"' : '';
            $html .= '<option value="' . $k . '" ' . $selected . '>' . $v . '</option>';
        }
        return $html;
    }
	function makeOption($catid = 0, $selectedid = "", $level = 0, &$arrHtml = [])
    {
        //		print_r($catid);die();
        global $dbconn, $_LANG_ID;
        $arrListCat = $this->getAll("is_trash=0 and is_online=1 order by " . $this->pkey . " ASC", $this->pkey . ",supply_name");
        if (is_array($arrListCat)) {
            foreach ($arrListCat as $k => $v) {
                $selected = ($v["supply_id"] == $selectedid) ? "selected" : "";
                $value = $v["supply_id"];
                $option = str_repeat("|----", $level) . $v["supply_name"];
                $arrHtml[$value] = $option;
            }
            return "";
        } else {
            return "";
        }
    }

    function getImage($pvalTable = 0, $w = 0, $h = 0, $ValImag = 'image')
    {
        global $clsISO;
        #
        $oneTable = $this->getOne($pvalTable, $ValImag);
        if ($oneTable[$ValImag] != '') {
            $image = $oneTable[$ValImag];
            return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
        }
        return false;
    }

    function doDelete($pvalTable = 0)
	{
		$this->deleteOne($pvalTable);
		/** Delete Image */
		$clsDiscountItem = new DiscountItem();
		$clsDiscountItem->deleteByCond("item_id='$pvalTable' and clsTable ='Voucher'");

		$clsImage = new Image();
		$clsImage->deleteByCond("type='_PRODUCT' and table_id='{$pvalTable}'");
		/* Store */
		$clsVoucherStore = new VoucherStore();
		$clsVoucherStore->deleteByCond("voucher_id='{$pvalTable}'");
		/** Delete Stock */
		$clsStock = new Stock();
		$clsStock->deleteByCond("voucher_id='{$pvalTable}'");
		return 1;
	}
}
