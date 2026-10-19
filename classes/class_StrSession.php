<?php
class StrSession extends dbBasic {}

class StringSessionID extends dbBasic
{

	function __construct()
	{
		$this->pkey = "session_key_id";
		$this->tbl = "session_key";
	}

	function checkStringSessionIDExist($session_id = 0)
	{
		$arrOneCheck = $this->getByCond("sid='" . $session_id . "'");
		if (is_array($arrOneCheck) && count($arrOneCheck) > 0)
			return $arrOneCheck["session_key_id"];
		else
			return 0;
	}

	function getSessionID($session_key_id = 0)
	{
		$arrOneCheck = $this->getOne($session_key_id);
		if (is_array($arrOneCheck) && count($arrOneCheck) > 0)
			return $arrOneCheck["sid"];
		else
			return "";
	}
}
