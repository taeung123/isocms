<?php
class _Country extends dbBasic
{
	function __construct()
	{
		$this->pkey = "country_id";
		$this->tbl = "_country";
	}
	function getTitle($country_id = 0)
	{
		$one = $this->getOne($country_id, 'title');
		return (!empty($one['title'])) ? $one['title'] : "";
	}
	function getCity($country_id = 0)
	{
		$clsCity = new _City();
		$res = $clsCity->getAll("is_trash=0 and country_id='$country_id' order by slug asc");
		return $res;
	}
	function getSelectByCountry($selected = '')
	{
		global $core;
		$all = $this->getAll("is_trash=0 and country_id<>'9' order by order_no asc", $this->pkey);
		$html = '<option value="0">-- ' . $core->get_Lang('Select country') . ' --</option>';
		if (!empty($all)) {
			foreach ($all as $item) {
				$selected_index = ($selected == $item[$this->pkey]) ? 'selected="selected"' : '';
				$html .= '<option value="' . $item[$this->pkey] . '" ' . $selected_index . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
			}
		}
		return $html;
	}

	function getClassFlag($country_id = 0)
	{
		$one = $this->getOne($country_id, 'class_flag');
		return (!empty($one['class_flag'])) ? $one['class_flag'] : "";
	}

	function doDelete($country_id = 0)
	{
		$this->deleteOne($country_id);
		return 1;
	}
}
