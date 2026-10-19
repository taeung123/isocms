<?php
class OnlineSupport extends dbBasic
{
	function __construct()
	{
		$this->pkey = "online_support_id";
		$this->tbl = DB_PREFIX . "online_support";
	}
	function getTitle($pval = 0)
	{
		$one = $this->getOne($pval, 'title');
		return $one['title'];
	}
	function getNick($pval = 0)
	{
		$one = $this->getOne($pval, 'nick');
		return $one['nick'];
	}
	function getListType()
	{
		$lstType = array();
		$lstType['_YAHOO'] = 'Yahoo';
		$lstType['_SKYPER'] = 'Skype';
		$lstType['_PHONE'] = 'Phone';
		return $lstType;
	}
	function getNameType($pval = 0)
	{
		$one = $this->getOne($pval, 'type');
		$lstType = $this->getListType();
		return $lstType[$one['type']];
	}
	function makeSelectbox($selected = '')
	{
		global $core;
		$lstType = $this->getListType();
		$html = '<option value="">--' . $core->get_Lang('Select') . '--</option>';
		foreach ($lstType as $k => $v) {
			$html .= '<option value="' . $k . '" ' . ($selected == $k ? 'selected="selected"' : '') . '>' . $v . '</option>';
		}
		return $html;
		die();
	}
	function checkOnlineAvaiable()
	{
		$res = $this->getAll("is_trash=0");
		return !empty($res) ? 1 : 0;
	}
}
