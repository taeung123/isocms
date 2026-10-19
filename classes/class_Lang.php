<?php
class _Lang extends dbBasic
{
	function __construct()
	{
		$this->pkey = "lang_id";
		$this->tbl = DB_PREFIX . "lang";
		#Create Table If Not Exist
		$sqlCreate =    $this->pkey . " INT(0) NOT NULL AUTO_INCREMENT, 
						`user_id` int(10) NOT NULL,
						`name` varchar(255) NOT NULL default '',
						`val_en` varchar(255) NOT NULL default '',
						`val_fr` varchar(255) NOT NULL default '',
						`is_trash` tinyint(1) NOT NULL";
		#
		$sqlInit_f = '';
		$sqlInit_v = '';
		$this->createTableDB($sqlCreate, $sqlInit_f, $sqlInit_v);
		#End Create
	}
	function get_Lang($key)
	{
		global $_LANG_ID;
		$one = $this->getAll("name='$key'");
		$ret = $one[0]['val_' . $_LANG_ID] != '' ? $one[0]['val_' . $_LANG_ID] : '[' . $key . ']';
		return $ret;
	}
}
