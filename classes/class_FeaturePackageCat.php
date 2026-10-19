<?php

class FeaturePackageCat extends dbBasic
{
	function __construct()
	{
		$this->pkey = "feature_package_cat_id";
		$this->tbl = DB_PREFIX . "featurepackagecat";
	}
	function getSlash($level = 0)
	{
		return str_repeat("------", $level + 1);
	}
	function getLink($pvalTable = 0)
	{
		global $extLang;
		return $extLang . '/travel-news/' . $this->getSlug($pvalTable);
	}
	function getTitle($feature_package_cat_id = 0)
	{
		$one = $this->getOne($feature_package_cat_id, 'title');
		return $one['title'];
	}
	function getSlug($feature_package_cat_id = 0)
	{
		$one = $this->getOne($feature_package_cat_id, 'slug');
		return $one['slug'];
	}
	function getBySlug($slug = '')
	{
		$res = $this->getAll("is_trash=0 and slug='$slug' limit 0,1");
		return $res[0][$this->pkey];
	}
	function getIntro($feature_package_cat_id = 0)
	{
		$one = $this->getOne($feature_package_cat_id, 'intro');
		return $one['intro'];
	}
	function checkIsParent($feature_package_cat_id = 0, $parent_id_check = 0)
	{
		$one = $this->getOne($feature_package_cat_id);
		$parent_id = $one['parent_id'];
		if ($parent_id == $parent_id_check) {
			return 1;
		}
		if ($parent_id == 0) {
			return 0;
		}
		return $this->checkIsParent($parent_id, $parent_id_check);
	}
	function getIcon($feature_package_cat_id = 0)
	{
		global $clsISO;
		$image = $this->getOneField('image', $feature_package_cat_id);
		if ($image != '' || $image != '0') {
			return $clsISO->parseImageURL($image);
		}
		return  URL_IMAGES . '/noimage.png';
	}
	function getListParent($feature_package_cat_id = 0)
	{
		#
		$listChild = array();
		$allChild = $this->getAll();
		if ($allChild[0][$this->pkey] != '') {
			for ($i = 0; $i < count($allChild); $i++) {
				if ($this->checkIsParent($feature_package_cat_id, $allChild[$i]['feature_package_cat_id'])) {
					$listChild[] = $allChild[$i]['feature_package_cat_id'];
				}
			}
		}
		#
		$cond = "|0|" . $feature_package_cat_id . "|";
		if (is_array($listChild) && count($listChild) > 0) {
			for ($i = 0; $i < count($listChild); $i++) {
				$cond .= $listChild[$i] . "|";
			}
		}
		#
		return $cond;
	}
	function makeSelectboxOption($feature_package_cat_id = 0)
	{
		global $core;
		$res = $this->getAll("is_trash=0 order by order_no asc");
		$html = '<option value="">-- ' . $core->get_Lang('selectcategory') . ' --</option>';
		if (!empty($res)) {
			foreach ($res as $item) {
				$sl = ($feature_package_cat_id == $item[$this->pkey]) ? 'selected="selected"' : '';
				$html .= '<option value="' . $item[$this->pkey] . '" ' . $sl . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
			}
		}
		return $html;
	}
	function getListFeatureByCat($pvalTable = 0)
	{
		global $core, $_LANG_ID;

		$clsFeaturePackage = new FeaturePackage();

		$ListFeaturePackage = $clsFeaturePackage->getAll("is_trash=0 and is_online=1 and feature_package_cat_id = '$pvalTable' order by order_no ASC", $clsFeaturePackage->pkey);

		return $ListFeaturePackage;
	}
	function countItemInCat($faqcat_id = 0)
	{
		$clsFAQ = new FAQ();
		return $clsFAQ->countItem("is_trash=0 and faqcat_id = '$faqcat_id'");
	}
	function doDelete($feature_package_cat_id = 0)
	{
		// Delete
		$clsFAQ = new FAQ();
		$lstItem = $clsFAQ->getAll("feature_package_cat_id='$feature_package_cat_id'");
		if (is_array($lstItem) && count($lstItem) > 0) {
			for ($i = 0; $i < count($lstItem); $i++) {
				$clsFAQ->doDelete($lstItem[$i][$clsFAQ->pkey]);
			}
		}
		// Delete
		$this->deleteOne($feature_package_cat_id);
		return 1;
	}
}
