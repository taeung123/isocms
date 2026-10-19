<?php
class ConfigImages extends dbBasic
{
	function __construct()
	{
		$this->pkey = "config_images_id";
		$this->tbl = DB_PREFIX . "config_images";
	}
	function getMaxOrder($parent_id = 0)
	{
		$all = $this->getAll("1=1 and parent_id = '$parent_id' order by order_no desc");
		return intval($all[0]['order_no']) + 1;
	}
	function checkExist($parent_id = 0, $type = '')
	{
		$res = $this->getAll("parent_id='$parent_id' and type='$type' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function checkExistChild($parent_id = 0)
	{
		$res = $this->getAll("parent_id='$parent_id' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function getTitle($infoset_type_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($infoset_type_id);
		return $one['title'];
	}
	function makeOption($catid = 0, $selectedid = "", $level = 0, &$arrHtml = [])
	{
		global $dbconn;
		$arrListCat = $this->getAll("parent_id='$catid' and is_trash=0 order by order_no asc");
		if (is_array($arrListCat)) {
			foreach ($arrListCat as $k => $v) {
				$selected = ($v[$this->pkey] == $selectedid) ? "selected" : "";
				$value = $v[$this->pkey];
				$option = str_repeat("|__", $level) . $this->getTitle($v[$this->pkey]);
				$arrHtml[$value] = $option;
				$this->makeOption($v[$this->pkey], $selectedid, $level + 1, $arrHtml);
			}
			return "";
		} else {
			return "";
		}
	}
	function getListOption($selectedid = '')
	{
		$arrOptionsCategory = array();
		$this->makeOption(0, "", 0, $arrOptionsCategory);
		#
		$html = '<option value="">-- Select --</option>';
		foreach ($arrOptionsCategory as $k => $v) {
			$selected = ($k == $selectedid) ? 'selected="selected"' : '';
			$html .= '<option ' . $selected . ' value="' . $k . '" ' . $selected . '>' . $v . '</option>';
		}
		return $html;
	}
	function getListType()
	{
		$lstType = array();
		$lstType['1:1'] = '1:1';
		$lstType['3:2'] = '3:2';
		return $lstType;
	}
	function makeSelectbox($selected = '')
	{
		$lstType = $this->getListType();
		$html = '<option value="">-- Select Dimension -- </option>';
		foreach ($lstType as $k => $v) {
			$html .= '<option value="' . $k . '" ' . ($selected == $k ? 'selected="selected"' : '') . '>' . $v . '</option>';
		}
		return $html;
		die();
	}
	function getDimension($type = '')
	{
		$one = $this->getAll("type='$type' limit 0,1");
		$arr['width'] = $one[0]['width'];
		$arr['height'] = $one[0]['height'];
		return $arr;
	}
}
