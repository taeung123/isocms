<?php
class TourStore extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_store_id";
		$this->tbl = DB_PREFIX . "tour_store";
	}
	function getMaxOrder($type = 0)
	{
		$res = $this->getAll("1=1 and _type='$type' order by order_no desc");
		return intval($res[0]['order_no']) + 1;
	}
	function getListType()
	{
		global $core, $clsISO, $package_id;
		$lstType = array();
		$lstType['TOPTOUR'] = $core->get_Lang('Top Trip');
		if ($clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'store', 'default', 'REVQQVJUVVJFLVZpZXRJU08=')) {
			$lstType['DEPARTURE'] = $core->get_Lang('Tour Departure');
		}
		return $lstType;
	}
	function getTitle($type = 0)
	{
		$lstType = $this->getListType();
		return $lstType[$type];
	}
	function checkExist($tour_id = 0, $type = '')
	{
		$res = $this->getAll("tour_id='$tour_id' and _type='$type' limit 0,1", $this->pkey);
		return (!empty($res)) ? 1 : 0;
	}
}
