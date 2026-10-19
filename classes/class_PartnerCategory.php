<?php
class PartnerCategory extends dbBasic
{
	function __construct()
	{
		$this->pkey = "partnercat_id";
		$this->tbl = DB_PREFIX . "partnercat";
	}
	function getSlash($level = 0)
	{
		return str_repeat("------", $level + 1);
	}
	function getLink($cat_id = 0)
	{
		return '/travel-partner/' . $this->getSlug($cat_id);
	}
	function getTitle($cat_id = 0, $_args = array())
	{
		global $_LANG_ID;
		if (is_array($_args) && $_args[$this->pkey] > 0) {
			return $_args['title'];
		} else {
			$one = $this->getOne($cat_id, "title");
			return $one['title'];
		}
	}
	function getSlug($cat_id = 0, $row = array())
	{
		global $_LANG_ID;
		if (is_array($row) && $row[$this->pkey] > 0) {
			return $row['slug'];
		} else {
			$one = $this->getOne($cat_id, 'slug');
			return $one['slug'];
		}
	}
	function getPermalink($cat_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($cat_id, 'permalink');
		return "/partner-category/" . $one['permalink'];
	}
	function getBySlug($slug = '')
	{
		$res = $this->getAll("is_trash=0 and slug='$slug' limit 0,1");
		return $res[0][$this->pkey];
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
	function makeSelectboxOption($cat_id = 0)
	{
		global $core;
		$res = $this->getAll("is_trash=0 order by order_no asc");
		$html = '<option value="">' . $core->get_Lang('Select') . '</option>';
		if (!empty($res)) {
			foreach ($res as $item) {
				$sl = ($cat_id == $item[$this->pkey]) ? 'selected="selected"' : '';
				$html .= '<option value="' . $item[$this->pkey] . '" ' . $sl . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
			}
		}
		return $html;
	}
	function countItemInCat($partnercat_id = 0)
	{
		$clsPartner = new Partner();
		return $clsPartner->countItem("is_trash=0 and cat_id = '$partnercat_id'");
	}
	function doDelete($partnercat_id = 0)
	{
		// Delete
		$clsPartner = new Partner();
		$lstItem = $clsPartner->getAll("cat_id='$partnercat_id'");
		if (is_array($lstItem) && count($lstItem) > 0) {
			for ($i = 0; $i < count($lstItem); $i++) {
				$clsPartner->doDelete($lstItem[$i][$clsPartner->pkey]);
			}
		}
		// Delete
		$this->deleteOne($partnercat_id);
		return 1;
	}
}
