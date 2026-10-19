<?php
class NewsCategory extends dbBasic
{
	function __construct()
	{
		$this->pkey = "newscat_id";
		$this->tbl = DB_PREFIX . "newscat";
	}
	function getLink($pvalTable = 0, $one = null)
	{
		global $extLang, $_LANG_ID;
		if ($_LANG_ID == 'vn')
			return $extLang . '/tin-tuc/' . $this->getSlug($pvalTable, $one);
		return $extLang . '/travel-news/' . $this->getSlug($pvalTable, $one);
	}
	function getTitle($pvalTable = 0, $one = null)
	{
		if (!isset($one['title'])) {
			$one = $this->getOne($pvalTable, 'title');
		}
		return $one['title'] ?? '';
	}
	function getSlug($pvalTable = 0, $one = null)
	{
		if (!isset($one['slug'])) {
			$one = $this->getOne($pvalTable, 'slug');
		}
		return $one['slug'] ?? '';
	}
	function getBySlug($slug = '')
	{
		$res = $this->getAll("is_trash=0 and slug='$slug' limit 0,1");
		return $res[0][$this->pkey] ?? 0;
	}
	function getIntro($pvalTable = 0, $one = null)
	{
		if (!isset($one['intro'])) {
			$one = $this->getOne($pvalTable, 'intro');
		}
		return html_entity_decode($one['intro'] ?? '');
	}
	function getMetaDescription($pvalTable = 0, $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['intro'])) {
			$one = $this->getOne($pvalTable, 'intro');
		}
		return html_entity_decode($one['intro'] ?? '');
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
	function getListParent($newscat_id = 0)
	{
		#
		$listChild = array();
		$allChild = $this->getAll();
		if ($allChild[0][$this->pkey] != '') {
			for ($i = 0; $i < count($allChild); $i++) {
				if ($this->checkIsParent($newscat_id, $allChild[$i]['newscat_id'])) {
					$listChild[] = $allChild[$i]['newscat_id'];
				}
			}
		}
		#
		$cond = "|0|" . $newscat_id . "|";
		if (is_array($listChild) && count($listChild) > 0) {
			for ($i = 0; $i < count($listChild); $i++) {
				$cond .= $listChild[$i] . "|";
			}
		}
		#
		return $cond;
	}
	function makeSelectboxOption($newscat_id = 0)
	{
		global $core;
		$res = $this->getAll("is_trash=0 and is_online=1 order by order_no asc");
		$html = '<option value="">-- ' . $core->get_Lang('selectcategory') . ' --</option>';
		if (!empty($res)) {
			foreach ($res as $item) {
				$sl = ($newscat_id == $item[$this->pkey]) ? 'selected="selected"' : '';
				$html .= '<option value="' . $item[$this->pkey] . '" ' . $sl . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
			}
		}
		return $html;
	}
	function countItemInCat($newscat_id = 0)
	{
		$clsNews = new News();
		return $clsNews->getAll("is_trash=0 and newscat_id = '$newscat_id'") ? count($clsNews->getAll("is_trash=0 and newscat_id = '$newscat_id'")) : 0;
	}
	function doDelete($newscat_id = 0)
	{
		// Delete News
		$clsNews = new News();
		$lstNews = $clsNews->getAll("newscat_id='$newscat_id'");
		if (is_array($lstNews) && count($lstNews) > 0) {
			for ($i = 0; $i < count($lstNews); $i++) {
				$clsNews->doDelete($lstNews[$i][$clsNews->pkey]);
			}
		}
		// Delete News
		$this->deleteOne($newscat_id);
		return 1;
	}
}
