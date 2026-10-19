<?php
class CruiseCustomField extends dbBasic{
	function __construct(){
		$this->pkey = "cruise_customfield_id";
		$this->tbl = DB_PREFIX."cruise_customfield";
	}
}