<?php

class FAQCategory extends dbBasic
{
	function __construct()
	{
		$this->pkey = "faqcat_id";
		$this->tbl = DB_PREFIX . "faqcat";
	}
	function getSlash($level = '')
	{
		return str_repeat("------", $level + 1);
	}
	function getLink($pvalTable = 0)
	{
		global $extLang;
		return $extLang . '/travel-news/' . $this->getSlug($pvalTable);
	}
	function getTitle($faq_cat_id = 0, $one = null)
	{
		if (!isset($one['title'])) {
			$one = $this->getOne($faq_cat_id, 'title');
		}
		return $one['title'];
	}
	function getSlug($faq_cat_id = 0)
	{
		$one = $this->getOne($faq_cat_id, 'slug');
		return $one['slug'];
	}
	function getBySlug($slug = '')
	{
		$res = $this->getAll("is_trash=0 and slug='$slug' limit 0,1");
		return $res[0][$this->pkey];
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getIntro($faq_cat_id = 0)
	{
		$one = $this->getOne($faq_cat_id, 'intro');
		return $one['intro'];
	}
	function checkIsParent($faq_cat_id = 0, $parent_id_check = 0)
	{
		$one = $this->getOne($faq_cat_id);
		$parent_id = $one['parent_id'];
		if ($parent_id == $parent_id_check) {
			return 1;
		}
		if ($parent_id == 0) {
			return 0;
		}
		return $this->checkIsParent($parent_id, $parent_id_check);
	}
	function getListParent($faq_cat_id = 0)
	{
		#
		$listChild = array();
		$allChild = $this->getAll();
		if ($allChild[0][$this->pkey] != '') {
			for ($i = 0; $i < count($allChild); $i++) {
				if ($this->checkIsParent($faq_cat_id, $allChild[$i]['faq_cat_id'])) {
					$listChild[] = $allChild[$i]['faq_cat_id'];
				}
			}
		}
		#
		$cond = "|0|" . $faq_cat_id . "|";
		if (is_array($listChild) && count($listChild) > 0) {
			for ($i = 0; $i < count($listChild); $i++) {
				$cond .= $listChild[$i] . "|";
			}
		}
		#
		return $cond;
	}
	function makeSelectboxOption($faq_cat_id = 0)
	{
		global $core;
		$res = $this->getAll("is_trash=0 order by order_no asc");
		$html = '<option value="">-- ' . $core->get_Lang('selectcategory') . ' --</option>';
		if (!empty($res)) {
			foreach ($res as $item) {
				$sl = ($faq_cat_id == $item[$this->pkey]) ? 'selected="selected"' : '';
				$html .= '<option value="' . $item[$this->pkey] . '" ' . $sl . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
			}
		}
		return $html;
	}
	function countItemInCat($faqcat_id = 0)
	{
		$clsFAQ = new FAQ();
		return $clsFAQ->countItem("is_trash=0 and faqcat_id = '$faqcat_id'");
	}
	function doDelete($faq_cat_id = 0)
	{
		// Delete
		$clsFAQ = new FAQ();
		$lstItem = $clsFAQ->getAll("faq_cat_id='$faq_cat_id'");
		if (is_array($lstItem) && count($lstItem) > 0) {
			for ($i = 0; $i < count($lstItem); $i++) {
				$clsFAQ->doDelete($lstItem[$i][$clsFAQ->pkey]);
			}
		}
		// Delete
		$this->deleteOne($faq_cat_id);
		return 1;
	}
}
