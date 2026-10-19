<?php
class SettingChildPolicy extends dbBasic
{
	function __construct()
	{
		$this->pkey = "child_setting_id";
		$this->tbl = DB_PREFIX . "child_setting";
	}
	function getMaxOrder($type = '')
	{
		$res = $this->getAll("1=1 and type='$type' order by order_no desc");
		return intval($res[0]['order_no']) + 1;
	}
	function getNumberChild($group_size_id = 0, $number_adult = 0)
	{
		$res = $this->getAll("1=1 and group_size_id='$group_size_id' and number_adult='$number_adult' limit 0,1");
		return intval($res[0]['number_child'] ?? 0);
	}
	function getNumberInfant($group_size_id = 0, $number_adult = 0)
	{
		$res = $this->getAll("1=1 and group_size_id='$group_size_id' and number_adult='$number_adult' limit 0,1");
		return intval($res[0]['number_infant'] ?? 0);
	}
	function getMin($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'number_from');
		return $one['number_from'] ?? 0;
	}
	function getMax($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'number_to');
		return $one['number_to'] ?? 0;
	}
	function getListType()
	{
		global $core;
		$listType = array();

		$listType['VISITORTYPE'] = $core->get_Lang('Visitor Type');
		return $listType;
	}
	function getNameType($selected = '')
	{
		$lstType = $this->getListType();
		return $lstType[$selected];
	}
	function getSelectType($selected = '')
	{
		global $core;
		#
		$listType = $this->getListType();
		$html = '<option value="0"> -- ' . $core->get_Lang('select') . ' -- </option>';
		foreach ($listType as $key => $val) {
			$html .= '<option value="' . $key . '" ' . ($key == $selected ? 'selected="selected"' : '') . '> -- ' . $val . ' -- </option>';
		}
		return $html;
	}
	function makeSelectboxOption($selected = '', $type = '', $tour_property_id = '')
	{
		global $core, $clsConfiguration, $clsISO;
		$sql = "is_trash=0 and type='$type' and tour_property_id='$tour_property_id'";
		#
		$lstProperty = $this->getAll($sql . " order by number_to ASC");
		$html = '<option value="0">-- ' . $core->get_Lang('selectcategory') . ' --</option>';
		if (is_array($lstProperty) && count($lstProperty) > 0) {
			foreach ($lstProperty as $k => $v) {
				$_array = $this->getArray($selected);
				$html .= '<option value="' . $v[$this->pkey] . '" ' . ($clsISO->checkItemInArray($v[$this->pkey], $_array) ? 'selected="selected"' : '') . '>-- ' . $this->getTitle($v[$this->pkey]) . '</option>';
			}
			unset($lstCat);
		}
		return $html;
	}
	function getSelectTourClass($tour_id = 0, $departure = '')
	{
		global $core;

		$clsTour = new Tour();
		$clsTourPriceGroup = new TourPriceGroup();
		$lstTourOption = $clsTour->getOneField('tour_option', $tour_id);
		$lstOption = array();
		if ($lstTourOption != '' && $lstTourOption != '0') {
			$lstTourOption = str_replace('||', '|', $lstTourOption);
			$lstTourOption = ltrim($lstTourOption, '|');
			$lstTourOption = rtrim($lstTourOption, '|');
			$TMP = explode('|', $lstTourOption);
			for ($i = 0; $i < count($TMP); $i++) {
				if (!in_array($TMP[$i], $lstOption)) {
					$lstOption[] = $TMP[$i];
				}
			}
		}
		$listTourPriceGroup = $clsTourPriceGroup->getAll("tour_id='$tour_id' and price > 0 and departure_date = '" . $departure . "' and tour_visitor_type_id='16' order by price asc limit 0,1");
		$tour_class_id_selected = $listTourPriceGroup[0]['tour_class_id'];
		$html = '<option value="0">' . $core->get_Lang('Select') . '</option>';

		for ($i = 0; $i < (count($lstOption)); $i++) {
			$select = ($tour_class_id_selected == $lstOption[$i]) ? 'selected="selected"' : '';
			$html .= '<option value="' . $lstOption[$i] . '"' . $select . '>' . $this->getTitle($lstOption[$i]) . '</option>';
		}
		return $html;
	}
	function getArray($string = '')
	{
		if ($string == '' || $string == '|') {
			return array();
		}
		$string = str_replace('||', '|', $string);
		$string = str_replace(',', '|', $string);
		$string = str_replace(':', '|', $string);
		$string = str_replace(';', '|', $string);
		$string = ltrim($string, '|');
		$string = rtrim($string, '|');
		return explode('|', $string);
	}
}
