<?php
class HotelCustomField extends dbBasic
{
	function __construct()
	{
		$this->pkey = "hotel_customfield_id";
		$this->tbl = DB_PREFIX . "hotel_customfield";
	}
	function getFieldName($hotel_customfield_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($hotel_customfield_id, 'fieldname');
		return $one['fieldname'];
	}
	function getFieldValue($hotel_customfield_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($hotel_customfield_id, 'fieldvalue');
		return $one['fieldvalue'];
	}
	function initCustomField($hotel_id = 0)
	{
		global $core;
		$listField = array();
		$listField[] = 'Di chuyển';
		$listField[] = 'Hướng dẫn nhận phòng';
		$listField[] = 'Chính sách phụ thu';
		#
		if ($this->countItem("hotel_id='$hotel_id'") == 0) {
			for ($i = 0; $i < count($listField); $i++) {
				$f = "hotel_customfield_id,hotel_id,fieldname,fieldname_slug,fieldtype,order_no";
				$hotel_customfield_id = $this->getMaxId();
				$v = "'$hotel_customfield_id'
				,'$hotel_id'
				,'" . addslashes($listField[$i]) . "'
				,'" . $core->replaceSpace($listField[$i]) . "'
				,'CUSTOM'
				,'" . $this->getMaxOrderNo() . "'";
				#
				$this->insertOne($f, $v);
			}
		}
	}
}
