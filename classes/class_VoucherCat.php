<?php
class VoucherCat extends dbBasic
{
    public $data;
    public $InData;
    public $dataVoucherCate;
    function __construct()
    {
        $this->pkey = "voucher_cat_id";
        $this->tbl = DB_PREFIX . "voucher_cat";
    }
    function getMaxOrder()
    {
        $res = $this->getAll("1=1 order by order_no desc");
        return intval($res[0]['order_no']) + 1;
    }
    function getOneValue($pvalTable = 0, $key = '')
    {
        $one = $this->getOne($pvalTable);
        if (isset($one[$key]) && !empty($one[$key])) {
            return $one[$key];
        }
        return false;
    }
    function getTitle($pvalTable = 0, $one = null)
    {
        if (!isset($one['title'])) {
            $one = $this->getOne($pvalTable);
        }
        return $one['title'] ?? '';
    }
    function getSlug($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        return $one['slug'] ?? '';
    }
    function getBySlug($slug = '')
    {
        $res = $this->getAll("is_trash=0 and slug='$slug'");
        return $res[0][$this->pkey] ?? 0;
    }
    function getBySlugOnline($slug = '')
    {
        $res = $this->getAll("is_trash=0 and is_online=1 and slug='$slug'");
        return $res[0][$this->pkey];
    }
    function countItemInCat($voucher_cat_id = 0)
    {
        $clsVoucher = new Voucher();
        $all = $clsVoucher->getAll("is_trash=0 and is_online=1 and cat_id = '$voucher_cat_id'", $clsVoucher->pkey);
        return $all ? count($all) : 0;
    }
    function checkSelected($data = [], $val = 0, $sect = '')
    {
        if (is_array($data) && !empty($data)) {
            foreach ($data as $item) {
                if ($item == $val) {
                    return $sect;
                }
            }
        } else {
            if ($data == $val) {
                return $sect;
            }
        }
        return false;
    }
    function getIntro($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        return html_entity_decode($one['intro']);
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
    function getImageIcon($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        #
        $oneTable = $this->getOne($pvalTable, "image_icon");
        if ($oneTable['image_icon'] != '') {
            $image = $oneTable['image_icon'];
            return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
        }
        return URL_IMAGES . '/noimage.png';
    }
    function getImageIcon2($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        #
        $oneTable = $this->getOne($pvalTable, "image_icon2");
        if ($oneTable['image_icon2'] != '') {
            $image = $oneTable['image_icon2'];
            return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
        }
        return URL_IMAGES . '/noimage.png';
    }
    function makeOptionParent($selected = "", $level = 1, $arrHtml = array())
    {
        global $dbconn, $_LANG_ID, $core;
        $arrListCat = $dbconn->GetAll("SELECT * FROM " . $this->tbl . " WHERE parent_id=0 and is_trash=0 order by order_no desc");
        if (is_array($arrListCat)) {
            foreach ($arrListCat as $k => $v) {
                $value = $v["voucher_cat_id"];
                $option = str_repeat("|----", $level) . $this->getTitle($v[$this->pkey]);
                $arrHtml[$value] = $option;
            }
            $html = '<option value="">-- ' . $core->get_Lang('Select') . ' --</option>';
            foreach ($arrHtml as $k => $v) {
                $html .= '<option value="' . $k . '" ' . ($k == $selected ? 'selected="selected"' : '') . '>' . $v . '</option>';
            }
            return $html;
        } else {
            return "";
        }
    }
    function makeOption($catid = 0, $selectedid = "", $level = 0, &$arrHtml = [])
    {
        //		print_r($catid);die();
        global $dbconn, $_LANG_ID;
        $arrListCat = $this->getAll("is_trash=0 and is_online=1 order by order_no ASC", $this->pkey . ",title");
        if (is_array($arrListCat)) {
            foreach ($arrListCat as $k => $v) {
                $selected = ($v["voucher_cat_id"] == $selectedid) ? "selected" : "";
                $value = $v["voucher_cat_id"];
                $option = str_repeat("|----", $level) . $v["title"];
                $arrHtml[$value] = $option;
            }
            return "";
        } else {
            return "";
        }
    }
    function makeList($catid = 0, $level = 0, $arrHtml = [])
    {
        global $dbconn;
        #
        $arrListCat = $dbconn->GetAll("SELECT * FROM " . $this->tbl . " WHERE parent_id='$catid' order by order_no desc");
        if (is_array($arrListCat)) {
            foreach ($arrListCat as $k => $v) {
                $value = $v[$this->pkey];
                $v['level'] = str_repeat("----", $level);
                $arrHtml[$value] = $v;
                $this->makeList($v[$this->pkey], $level + 1, $arrHtml);
            }
            return "";
        } else {
            return "";
        }
    }
    function getALLByParentID($parent = 0)
    {
        global $dbconn;
        return $arrListCat = $dbconn->GetAll("SELECT * FROM " . $this->tbl . " WHERE parent_id = " . $parent . " order by order_no desc");
    }
    function getALLParent($parent = 0, $lavel = '|--', $zezo = 1)
    {
        global $dbconn;
        if ($zezo == 1) {
            return $arrListCat = $dbconn->GetAll("SELECT * FROM " . $this->tbl . " WHERE parent_id = " . $parent . " order by order_no desc");
        } else {
            $arrListCat = $dbconn->GetAll("SELECT * FROM " . $this->tbl . " WHERE parent_id = " . $parent . " order by order_no desc");
        }
        if (count($arrListCat) > 0) {
            foreach ($arrListCat as $key => $val) {
                $this->data[] = array(
                    'voucher_cat_id' => $val['voucher_cat_id'],
                    'parent_id' => $val['parent_id'],
                    'title' => $lavel . " " . $val['title'],
                    'slug' => $val['slug'],
                    'intro' => $val['intro'],
                    'image' => $val['image'],
                    'order_no' => $val['order_no'],
                    'user_id' => $val['user_id'],
                    'user_id_update' => $val['user_id_update'],
                    'reg_date' => $val['reg_date'],
                    'upd_date' => $val['upd_date'],
                    'is_trash' => $val['is_trash'],
                    'getNAV' => $val['getNAV'],
                    'image_icon' => $val['image_icon'],
                    'image_icon2' => $val['image_icon2'],
                    'is_online' => $val['is_online']
                );
                $this->getALLParent($val[$this->pkey], '|--');
            }
        } else {
            $val = $this->getOne($parent);
            if (!empty($val)) {
                $this->data[] = array(
                    'voucher_cat_id' => $val['voucher_cat_id'],
                    'parent_id' => $val['parent_id'],
                    'title' => $val['title'],
                    'slug' => $val['slug'],
                    'intro' => $val['intro'],
                    'image' => $val['image'],
                    'order_no' => $val['order_no'],
                    'user_id' => $val['user_id'],
                    'user_id_update' => $val['user_id_update'],
                    'reg_date' => $val['reg_date'],
                    'upd_date' => $val['upd_date'],
                    'is_trash' => $val['is_trash'],
                    'getNAV' => $val['getNAV'],
                    'image_icon' => $val['image_icon'],
                    'image_icon2' => $val['image_icon2'],
                    'is_online' => $val['is_online']
                );
            }
        }
        return $this->data;
    }
    function getALLParentID($datta = array())
    {
        global $dbconn;
        if (!empty($datta)) {
            if (is_array($datta)) {
                foreach ($datta as $valItem) {
                    $arrListCat = $dbconn->GetAll("SELECT * FROM " . $this->tbl . " WHERE parent_id = " . $valItem . " order by order_no desc");
                    if (!empty($arrListCat)) {
                        foreach ($arrListCat as $key => $val) {
                            $this->InData[] = $val['voucher_cat_id'];
                            $this->getALLParent($val[$this->pkey]);
                        }
                    } else {
                        $this->InData[] = $valItem;
                    }
                }
            } else {
                $arrListCat = $dbconn->GetAll("SELECT * FROM " . $this->tbl . " WHERE parent_id = " . $datta . " order by order_no desc");
                if (!empty($arrListCat)) {
                    foreach ($arrListCat as $key => $val) {
                        $this->InData[] = $val['voucher_cat_id'];
                        $this->getALLParent($val[$this->pkey]);
                    }
                } else {
                    $this->InData[] = $datta;
                }
            }
        }
        if (count($this->InData) > 0) {
            return implode(" , ", array_unique($this->InData));
        }
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

        $html = '<option value="0" >' . $core->get_Lang('Category') . '</option>';
        foreach ($arrOptionsCategory as $k => $v) {
            $selected = ($k == $cat_id) ? 'selected="selected"' : '';
            $html .= '<option value="' . $k . '" ' . $selected . '>' . $v . '</option>';
        }
        return $html;
    }
    function getListParent($cat_id = 0)
    {
        $listChild = array();
        $allChild = $this->getAll();
        if ($allChild[0][$this->pkey] != '') {
            for ($i = 0; $i < count($allChild); $i++) {
                if ($this->checkIsParent($cat_id, $allChild[$i]['voucher_cat_id'])) {
                    $listChild[] = $allChild[$i]['voucher_cat_id'];
                }
            }
        }
        #
        $cond = "|";
        if (is_array($listChild) && count($listChild) > 0) {
            for ($i = 0; $i < count($listChild); $i++) {
                $cond .= $listChild[$i] . "|";
            }
        }
        $cond .= $cat_id . "|";
        return $cond;
    }
    function checkMove($pval = 0, $group = [], $type = '')
    {
        $one = $this->getOne($pval);
        $parent_id = $one['parent_id'];
        if ($type == '_UP') {
            if (!$this->checkIsFirst($pval, $parent_id, $group)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            if (!$this->checkIsLast($pval, $parent_id, $group)) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    function checkIsFirst($pval = 0, $parent_id = 0, $group = [])
    {
        $allItem = $this->getAll("is_trash=0 and _type='$group' and parent_id='$parent_id' order by order_no ASC");
        if (is_array($allItem) && count($allItem) > 0) {
            if ($allItem[0][$this->pkey] == $pval) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    function checkIsLast($pval = 0, $parent_id = 0, $group = [])
    {
        $allItem = $this->getAll("is_trash=0 and _type='$group' and parent_id='$parent_id' order by order_no ASC");
        if (is_array($allItem) && count($allItem) > 0) {
            if ($allItem[count($allItem) - 1][$this->pkey] == $pval) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    function checkIsParent($cat_id = 0, $parent_id_check = 0)
    {
        $one = $this->getOne($cat_id);
        $parent_id = $one['parent_id'];
        if ($parent_id == $parent_id_check) {
            return 1;
        }
        if ($parent_id == 0) {
            return 0;
        }
        return $this->checkIsParent($parent_id, $parent_id_check);
    }
    function countParent($cat_id = 0)
    {
        return    $count = $this->countItem("1=1 and parent_id='$cat_id'");
    }
    function doDelete($cat_id = 0)
    {
        $count = $this->countItem("1=1 and parent_id='$cat_id'");
        if ($count > 0) {
            $lstItem = $this->getAll("1=1 and parent_id='$cat_id'");
            foreach ($lstItem as $item) {
                $pval = $item[$this->pkey];
                $this->deleteOne($pval);
            }
        } else {
            $this->deleteOne($cat_id);
        }
    }
    function getLink($cat_id = 0)
    {
        return '/danh-muc-voucher/' . $this->getSlug($cat_id);
    }
    function getLinkSort($cat_id = 0)
    {
        return '/danh-muc-voucher/' . $this->getSlug($cat_id);
    }
    function getChild($voucher_cat_id = 0)
    {
        return $this->getAll("is_trash=0 and parent_id='$voucher_cat_id' order by order_no ASC");
    }
    function getChildParent($voucher_cat_id = 0)
    {
        $data =  $this->getAll("is_trash=0 and parent_id='$voucher_cat_id' order by order_no ASC", $this->pkey);
        $html = $voucher_cat_id;
        $datax = count($data);
        if ($datax > 1) {
            foreach ($data as $val) {
                $html .= " , " . $val[$this->pkey];
            }
        }
        return $html;
    }
    function getNAV($voucher_cat_id = 0)
    {
        global $dbconn;
        $getNAV = $this->getOneField('getNAV', $voucher_cat_id);
        if ($getNAV == '' || $getNAV == '0') {
            $oneCat = $this->getOne($voucher_cat_id);
            #
            $i = 1;
            $j = 0;
            $res = array();
            $res[0] = $voucher_cat_id;
            #
            while ($i == 1) {
                $oneCurrent = $this->getOne($res[$j], 'parent_id');
                $oneParent = $oneCurrent["parent_id"];
                if ($oneParent != 0 and $i == 1) {
                    $j++;
                    $res[$j] = $oneParent;
                } else {
                    $j++;
                    $res[$j] = $oneParent;
                    $i = 0;
                }
            }
            #$this->updateOne($voucher_cat_id,"getNAV='".unserialize(array_reverse($res))."'");
            return array_reverse($res);
        } else {
            return unserialize($getNAV);
        }
    }
    function getALLParentCheckVoucher($parent = 0, $level = true)
    {
        global $dbconn;
        $arrListCat = $dbconn->GetAll("SELECT  " . $this->pkey . " FROM " . $this->tbl . " WHERE parent_id = " . $parent . " order by order_no desc");
        if (!empty($arrListCat)) {
            foreach ($arrListCat as $key => $val) {
                $count = $dbconn->GetAll("SELECT COUNT(voucher_id) FROM default_voucher WHERE cat_id = '" . $val[$this->pkey] . "'");
                if ($count > 0) {
                    $this->dataVoucherCate[] = $val;
                    $this->getALLParentCheckVoucher($val[$this->pkey]);
                }
            }
        } else {
            $count = $dbconn->GetAll("SELECT COUNT(voucher_id) FROM default_voucher WHERE cat_id = '" . $parent . "'");
            if ($count > 0) {
                $this->dataVoucherCate[] = $parent;
            }
        }
        if (!empty($this->dataVoucherCate)) {
            $cate = array_unique($this->dataVoucherCate);
        }
        if (isset($cate) && !empty($cate)) {
            $dataCate = array();
            foreach ($cate as $value) {
                $one = $this->getOne($value);
                if (!empty($one['voucher_cat_id'])) {
                    if ($level == true) {
                        if ($one['parent_id'] == 0) {
                            $dataCate[] = $one['voucher_cat_id'];
                        }
                    } else {
                        $dataCate[] = $one['voucher_cat_id'];
                    }
                }
            }
            return $dataCate;
        }
        return false;
    }
}
