<?php if (!defined('ABSPATH')) exit('No direct script access allowed');
/*======================================================================*\
|| #################################################################### ||
|| # The modules of the ISOCMS                                        # ||
|| # ISOCMS 6.0.0 VietISO Technical (support@vietiso.com)             # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/

use Curl\Curl;

class API
{
	public $curl				= array();
	public $return_array		= false;
	protected static $_instance = null;
	protected static $_results 	= array();
	protected static $api_key 	= ILOOCA_TOURDB_API_KEY;
	protected static $api_secret = ILOOCA_TOURDB_API_SECRET;
	protected static $api_url 	= ILOOCA_TOURDB_API_URL;
	// Source: ABSPATH .'/constranst.php'
	protected function __construct($config = array('Content-Type' => 'application/json'), $opts = array())
	{
		global $core, $clsISO, $_LANG_ID;
		if (!empty($opts) && is_array($opts)) {
			foreach ($opts as $key => $val) {
				$this->{$key} = $val;
			}
		}
		#- Set Opts
		$this->curl = new Curl();
		//$this->curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
		//$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->curl->setHeader("Content-Language", $_LANG_ID);
		$this->curl->setHeader("Authorization", "Bearer " . self::$api_key);
		if (!empty($config)) {
			foreach ($config as $key => $val) {
				$this->curl->setHeader($key, $val);
			}
		}
	}
	public static function getInstance($config = array('Content-Type' => 'application/json'), $opts = array())
	{
		global $core, $clsISO, $_LANG_ID;
		return new self($config, $opts);
	}
	function setOpt($filesize)
	{
		$this->curl->setOpt($key, $val);
	}
	function isJson($string)
	{
		json_decode(html_entity_decode($string));
		return (json_last_error() == JSON_ERROR_NONE);
	}
	function post($request_url, $params = array())
	{
		global $core, $dbconn, $clsISO, $_LANG_ID;
		try {
			$full_url = self::$api_url . $request_url;
			$this->curl->post($full_url, $params);
			if (!$this->curl->error) {
				self::$_results = toArray($this->curl->response);
				if ($this->return_array) {
					return self::$_results;
				} else {
					if (isset(self::$_results['result'])) {
						if (self::$_results['result'] == 'success')
							return self::$_results['data'];
						elseif (self::$_results['result'] == 'error')
							return isset(self::$_results['message'])
								? self::$_results['message']
								: 'Error';
						return false;
					}
				}
			} else {
				echo 'Error: ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n";
				die();
			}
		} catch (Exception $e) {
			echo 'Error: ' . $e->getMessage();
			die();
		}
	}
	function get($request_url, $params = array(), $debug = false)
	{
		global $core, $dbconn, $clsISO, $_LANG_ID;
		$full_url = self::$api_url . $request_url;
		$this->curl->get($full_url, $params);
		if (!$this->curl->error) {
			self::$_results = toArray($this->curl->response);
			if ($this->return_array) {
				return self::$_results;
			} else {
				if (isset(self::$_results['result'])) {
					if (self::$_results['result'] == 'success')
						return self::$_results['data'];
					elseif (self::$_results['result'] == 'error')
						return isset(self::$_results['message'])
							? self::$_results['message']
							: "Error";
					return false;
				}
			}
		} else {
			echo 'Error: ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n";
			die();
		}
	}
	function getOne($clsTable, $pval_id, $field = "*")
	{
		$arrResult = $this->post('/backend/common/getOne.cfg', array(
			'clsTable' => $clsTable,
			'pval_id' => $pval_id,
			'field' => $field
		));
		return !empty($arrResult) ? $arrResult : false;
	}
	function getOneField($clsTable, $field = "", $pval_id)
	{
		$valueField = $this->post('/backend/common/getOneField.cfg', array(
			'clsTable' => $clsTable,
			'pval_id' => $pval_id,
			"field" => $field
		));
		return $valueField;
	}
	function getAll($clsTable, $cond = "", $field = "*")
	{
		$arrResult = $this->post('/backend/common/getAll.cfg', array(
			'clsTable' => $clsTable,
			'cond' => $cond,
			'field' => $field
		));
		return !empty($arrResult) ? $arrResult : false;
	}
	function countItem($clsTable, $cond = "")
	{
		if (!empty($clsTable) && !empty($cond)) {
			$totalItem = $this->post('/backend/common/countItem.cfg', array(
				'clsTable' => $clsTable,
				'cond' => $cond
			));
			return (int) $totalItem;
		}
		return 0;
	}
	function execSql($sql, $func = "getAll")
	{
		$sql = trim(preg_replace('/\s\s+/', ' ', $sql)); //remove new line
		$arrResult = $this->post('/backend/common/execSql.cfg', array(
			'sql' => $sql,
			'func' => $func
		));
		return !empty($arrResult) ? $arrResult : false;
	}
	function updateOne($clsTable, $pval_id, $arr_update_fields = array())
	{
		if (!empty($clsTable) && (int) $pval_id > 0 && !empty($arr_update_fields)) {
			return $this->post('/backend/common/updateOne.cfg', array(
				'clsTable' => $clsTable,
				'pval_id'  => $pval_id,
				'arr_update_field' => $arr_update_fields
			));
		}
		return 0;
	}
	function insertOne($clsTable, $arr_insert_fields = array())
	{
		if (!empty($clsTable) && !empty($arr_insert_fields)) {
			return $this->post('/backend/common/insertOne.cfg', array(
				'clsTable' => $clsTable,
				'arr_insert_fields' => $arr_insert_fields
			));
		}
		return 0;
	}
	function deleteOne($clsTable, $pval_id)
	{
		if (!empty($clsTable) && (int) $pval_id > 0) {
			return $this->post('/backend/common/deleteOne.cfg', array(
				'clsTable' => $clsTable,
				'pval_id' => $pval_id
			));
		}
		return 0;
	}
	function deleteByCond($clsTable, $cond)
	{
		if (!empty($clsTable) && !empty($cond)) {
			return $this->post('/backend/common/deleteByCond.cfg', array(
				'clsTable' => $clsTable,
				'cond' => $cond
			));
		}
		return 0;
	}
}
