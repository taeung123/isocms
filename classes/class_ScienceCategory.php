<?php
class ScienceCategory extends dbBasic
{
	function __construct()
	{
		$this->pkey = "sciencecat_id";
		$this->tbl = DB_PREFIX . "sciencecat";
	}
	function getLink($pvalTable = 0)
	{
		global $extLang, $_LANG_ID;
		if ($_LANG_ID == 'vn')
			return $extLang . '/tin-tuc/' . $this->getSlug($pvalTable);
		return $extLang . '/travel-science/' . $this->getSlug($pvalTable);
	}
	function getTitle($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'title');
		return $one['title'];
	}
	function getSlug($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'slug');
		return $one['slug'];
	}
	function getBySlug($slug = '')
	{
		$res = $this->getAll("is_trash=0 and slug='$slug' limit 0,1");
		return $res[0][$this->pkey];
	}
	function getIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function checkIsParent($pvalTable = 0, $parent_id_check = 0)
	{
		$one = $this->getOne($pvalTable, 'parent_id');
		$parent_id = $one['parent_id'];
		if ($parent_id == $parent_id_check) {
			return 1;
		}
		if ($parent_id == 0) {
			return 0;
		}
		return $this->checkIsParent($parent_id, $parent_id_check);
	}
	function getListParent($sciencecat_id = 0)
	{
		#
		$listChild = array();
		$allChild = $this->getAll();
		if ($allChild[0][$this->pkey] != '') {
			for ($i = 0; $i < count($allChild); $i++) {
				if ($this->checkIsParent($sciencecat_id, $allChild[$i]['sciencecat_id'])) {
					$listChild[] = $allChild[$i]['sciencecat_id'];
				}
			}
		}
		#
		$cond = "|0|" . $sciencecat_id . "|";
		if (is_array($listChild) && count($listChild) > 0) {
			for ($i = 0; $i < count($listChild); $i++) {
				$cond .= $listChild[$i] . "|";
			}
		}
		#
		return $cond;
	}
	function makeSelectboxOption($sciencecat_id = 0)
	{
		global $core;
		$res = $this->getAll("is_trash=0 and is_online=1 order by order_no asc");
		$html = '<option value="">-- ' . $core->get_Lang('selectcategory') . ' --</option>';
		if (!empty($res)) {
			foreach ($res as $item) {
				$sl = ($sciencecat_id == $item[$this->pkey]) ? 'selected="selected"' : '';
				$html .= '<option value="' . $item[$this->pkey] . '" ' . $sl . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
			}
		}
		return $html;
	}
	function countItemInCat($sciencecat_id = 0)
	{
		$clsScience = new Science();
		return $clsScience->getAll("is_trash=0 and sciencecat_id = '$sciencecat_id'") ? count($clsScience->getAll("is_trash=0 and sciencecat_id = '$sciencecat_id'")) : 0;
	}
	function doDelete($sciencecat_id = 0)
	{
		// Delete Science
		$clsScience = new Science();
		$lstScience = $clsScience->getAll("sciencecat_id='$sciencecat_id'");
		if (is_array($lstScience) && count($lstScience) > 0) {
			for ($i = 0; $i < count($lstScience); $i++) {
				$clsScience->doDelete($lstScience[$i][$clsScience->pkey]);
			}
		}
		// Delete Science
		$this->deleteOne($sciencecat_id);
		return 1;
	}
}
