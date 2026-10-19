<?php

class BlogCategory extends dbBasic
{

    function __construct()
    {
        $this->pkey = "blogcat_id";
        $this->tbl = DB_PREFIX . "blogcat";
    }

    function getSlash($level = 0)
    {
        return str_repeat("------", $level + 1);
    }

    function getTitle($cat_id = 0, $_args = array())
    {
        global $_LANG_ID;
        if (!empty($_args) && $_args[$this->pkey] > 0) {
            return $_args['title'] ?? '';
        } else {
            $one = $this->getOne($cat_id, "title");
            return $one['title'] ?? '';
        }
    }

    function getSlug($cat_id = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['slug'])) {
            $one = $this->getOne($cat_id, 'slug');
        }
        return $one['slug'];
    }

    function getLink($cat_id = 0, $one = null)
    {
        global $_LANG_ID, $extLang, $clsISO;
        $clsCountry = new Country();
        $clsCity = new City();
        return $extLang . '/blog/' . $this->getSlug($cat_id, $one) . '.html';
    }

    function getPermalink($cat_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($cat_id, 'permalink');
        return "/blog-category/" . $one['permalink'];
    }

    function getBySlug($slug = '')
    {
        $res = $this->getAll("is_trash=0 and slug='$slug' limit 0,1");
        return $res[0][$this->pkey];
    }

    function getMetaDescription($pvalTable = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['intro'])) {
            $one = $this->getOne($pvalTable, 'intro');
        }
        return html_entity_decode($one['intro']);
    }

    function getIntro($cat_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($cat_id, 'intro');
        return $one['intro'];
    }

    function getContent($cat_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($cat_id, 'content');
        return $one['content'];
    }

    function checkIsParent($cat_id = 0, $parent_id_check = 0)
    {
        $one = $this->getOne($cat_id, 'parent_id');
        $parent_id = $one['parent_id'];
        if ($parent_id == $parent_id_check) {
            return 1;
        }
        if ($parent_id == 0) {
            return 0;
        }
        return $this->checkIsParent($parent_id, $parent_id_check);
    }

    function getListParent($cat_id = 0)
    {
        #
        $listChild = array();
        $allChild = $this->getAll();
        if ($allChild[0][$this->pkey] != '') {
            for ($i = 0; $i < count($allChild); $i++) {
                if ($this->checkIsParent($cat_id, $allChild[$i][$this->pkey])) {
                    $listChild[] = $allChild[$i][$this->pkey];
                }
            }
        }
        #
        $cond = "|0|" . $cat_id . "|";
        if (is_array($listChild) && count($listChild) > 0) {
            for ($i = 0; $i < count($listChild); $i++) {
                $cond .= $listChild[$i] . "|";
            }
        }
        #
        return $cond;
    }

    function makeSelectboxOption($cat_id = 0, $placeholder = '')
    {
        global $core;
        $res = $this->getAll("is_trash=0 and is_online=1 order by order_no asc");
        $placeholder = $placeholder !== '' ? $placeholder : $core->get_Lang('Select');
        $html = '<option value="">' . $placeholder . '</option>';
        if (!empty($res)) {
            foreach ($res as $item) {
                $sl = ($cat_id == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $sl . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
            }
        }
        return $html;
    }

    function countItemInCat($blogcat_id = 0)
    {
        $clsBlog = new Blog();
        return $clsBlog->getAll("is_trash=0 and is_online=1 and cat_id = '$blogcat_id'") ? count($clsBlog->getAll("is_trash=0 and is_online=1 and cat_id = '$blogcat_id'")) : 0;
    }

    function doDelete($blogcat_id = 0)
    {
        // Delete
        $clsBlog = new Blog();
        if (1 == 2) {
            $lstItem = $clsBlog->getAll("cat_id='$blogcat_id'");
            if (is_array($lstItem) && count($lstItem) > 0) {
                for ($i = 0; $i < count($lstItem); $i++) {
                    $clsBlog->doDelete($lstItem[$i][$clsBlog->pkey]);
                }
            }
        }
        // Delete
        $this->deleteOne($blogcat_id);
        return 1;
    }
}
