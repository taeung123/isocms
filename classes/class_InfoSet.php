<?php
class InfoSet extends dbBasic
{
	function __construct()
	{
		$this->pkey = "infoset_id";
		$this->tbl = DB_PREFIX . "infoset";
	}
	function getLink($page_info_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($page_info_id, 'link');
		return $one['link'];
	}
	function getIntro($mod_page = '', $act_page = '')
	{
		global $_LANG_ID;
		$sql = "domain_id='" . _DOMAIN_ID . "' and mod_page = '$mod_page'";
		if ($act_page != '') {
			$sql .= " and act_page = '$act_page'";
		}
		$all = $this->getAll($sql . " limit 0,1");
		$one = $this->getOne($all[0][$this->pkey], "intro_" . $_LANG_ID);
		return html_entity_decode($one['intro_' . $_LANG_ID]);
	}
	function getContent($mod_page = '', $act_page = '')
	{
		global $_LANG_ID;
		$sql = "domain_id='" . _DOMAIN_ID . "' and mod_page = '$mod_page'";
		if ($act_page != '') {
			$sql .= " and act_page = '$act_page'";
		}
		$all = $this->getAll($sql . " limit 0,1");
		$one = $this->getOne($all[0][$this->pkey], "content_" . $_LANG_ID);
		return html_entity_decode($one['content_' . $_LANG_ID]);
	}
	function getRecommend($mod_page = '', $act_page = '')
	{
		global $_LANG_ID;
		$sql = "domain_id='" . _DOMAIN_ID . "' and mod_page = '$mod_page'";
		if ($act_page != '') {
			$sql .= " and act_page = '$act_page'";
		}
		$all = $this->getAll($sql . " limit 0,1");
		$one = $this->getOne($all[0][$this->pkey], "recommend_" . $_LANG_ID);
		return html_entity_decode($one['recommend_' . $_LANG_ID]);
	}
	function getImage($module = '', $action = "")
	{
		global $_LANG_ID;
		$cond = "module='$module' and action='$action'";
		if (!empty($action)) {
			$cond .= "and action='$action'";
		}
		$res = $this->getAll($cond . " limit 0,1");
		if (!empty($res)) {
			return $res[0]['image'];
		}
		return '';
	}
	function getPageIntro($type = '', $default_txt = '')
	{
		$one = $this->getAll("module='$type' limit 0,1");
		if ($one[0]['intro'] != '') {
			return html_entity_decode($one[0]['intro']);
		} else {
			return $default_txt;
		}
	}
}
