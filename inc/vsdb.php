<?php 
	ini_set('max_execution_time', '300');
	ini_set('display_errors',0);
	error_reporting(E_ALL);
	#
	define('DS', DIRECTORY_SEPARATOR);
	define('ABSPATH', $_SERVER['DOCUMENT_ROOT']);
	#
	class Helper {
		public static $startVal = '(';
		public static $endVal = ')';
		function __construct(){
			// DO SOMETHING
		}
		static function folder_exist($folder){
			// Get canonicalized absolute pathname
			$path = realpath($folder);
			// If it exist, check if it's a directory
			return ($path !== false AND is_dir($path)) ? $path : false;
		}
		function pre ($expression, $wrap = true) {
			$css = 'border:1px dashed #06f;padding:1em;text-align:left;';
			if ($wrap) {
				$str = '<p style="' . $css . '"><tt>' . str_replace(
						array('  ', "\n"), array('&nbsp; ', '<br />'),
						htmlspecialchars(print_r($expression, true))
					) . '</tt></p>';
			} else {
				$str = '<pre style="' . $css . '">'
					. htmlspecialchars(print_r($expression, true)) . '</pre>';
			}
			echo $str;
		}
		static function getColumnDataInTable($table_name, $column_name){
			global $dbconn;
			$sql = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$table_name}' AND COLUMN_NAME = '{$column_name}';";
			$lstTbl = $dbconn->GetAll($sql);
			return !empty($lstTbl) ? $lstTbl[0]['DATA_TYPE'] : false;
		}
		static function setInputType($datatype){
			global $dbconn;
			$posStartVal = strpos($datatype, self::$startVal);
			$posEndVal = strpos($datatype, self::$endVal);
			if($posStartVal === false){
				$type = $datatype;
				$val = false;
			} else {
				$lengthVal = $posEndVal - $posStartVal - strlen($posStartVal);
				$type = substr($datatype, 0, $posStartVal);
				$val = substr($datatype, $posStartVal + 1, $lengthVal);
			}
			$type = strtolower($type);
			#
			$array = array();
			$arrayAttr = array();
			switch ($type){
				case 'char':
				case 'varchar':
					$array['InputType'] = 'text';
					if($val !== false){
						$arrayAttr['maxlength'] = intval($val);
					}
					break;
				case 'text':
				case 'tinytext':
				case 'midiumtext':
				case 'mediumtext':
				case 'longtext':
				case 'blob':
				case 'tinyblob':
				case 'mediumblob':
				case 'longblob':
					$array['InputType'] = 'textarea';
					break;
				case 'int':
				case 'smallint':
				case 'mediumint':
				case 'bigint':
					$array['InputType'] = 'text';
					$array['dataType'] = 'number';
					if($val !== false){
						$arrayAttr['maxlength'] = intval($val);
					}
					break;
				case 'tinyint':
					$array['InputType'] = 'checkbox';
					$array['dataType'] = 'number';
					$array['TrueValue'] = 1; //or Yes
					break;
				case 'float':
				case 'double':
				case 'decimal':
					$array['InputType'] = 'text';
					$array['dataType'] = 'number';
					if($val !== false){
						$arrayAttr['maxlength'] = intval($val);
					}
					break;
				case 'time':
				case 'date':
				case 'datetime':
					//$array['InputType'] = 'date';
					//date is pear type
					//datetime is bsg type :)
					$array['InputType'] = 'datetime';
					break;
				case 'enum':
					$array['InputType'] = 'select';
					$val = str_replace("'",'',$val);
					$val = str_replace('"','',$val);
					$array['Options'] = explode(',',$val);
					break;
				default:
					$array['InputType'] = 'hidden';
					break;
			}
			if(isset($arrayAttr['maxlength'])){
				$arrayAttr['size'] = (round(sqrt($arrayAttr['maxlength']) * 2.5));
			}
			$array['Attributes'] = $arrayAttr;
			return $array;
		}
	}
	#
	define("SMARTY_DEBUG", 	false);//debug or not
	define("COMPILE_CHECK", true);//compile check
	define("ADODB_DEBUG", 	false);//debug or not
	define("HANDLE_ERROR", 	0);//0: no, 1: yes
	define("STOP_APP_IF_ERROR", 1);//stop if error happen 0: no, 1: yes
	#- Define DIR_INCLUDES
	if(Helper::folder_exist(ABSPATH.DS.'inc')){
		define('DIR_INCLUDES', ABSPATH.DS.'inc');
	} else if(Helper::folder_exist(ABSPATH.DS.'lib'.DS.'includes')){
		define('DIR_INCLUDES', ABSPATH.DS.'lib'.DS.'includes');
	} 
	#- Define DIR_ADODB
	if(Helper::folder_exist(DIR_INCLUDES.DS.'adodb5')){
		define('DIR_ADODB', DIR_INCLUDES.DS.'adodb5');
	} else {
		define('DIR_ADODB', DIR_INCLUDES.DS.'adodb');
	}
	define('DIR_COMMOM', DIR_INCLUDES.DS.'common');
	define('DIR_SMARTY', DIR_INCLUDES.DS.'smarty');
	#- Define DIR_CLASSES
	if(Helper::folder_exist(ABSPATH.DS.'classes')){
		define('DIR_CLASSES', ABSPATH.DS.'classes');
	} else if(Helper::folder_exist(ABSPATH.DS.'isocms'.DS.'classes')){
		define('DIR_CLASSES', ABSPATH.DS.'isocms'.DS.'classes');
	}
	# Required config file
	if(file_exists(ABSPATH.DS.'config_db.php')){
		require_once(ABSPATH.DS.'config_db.php');
	} if(file_exists(ABSPATH.DS.'config.php')){
		require_once(ABSPATH.DS.'config.php');
	} else if(file_exists(DIR_CLASSES.DS.'iso.php')){
		require_once(DIR_CLASSES.DS.'iso.php');
	}
	require_once(DIR_ADODB."/adodb.inc.php");
	#
	$dbconn = &ADONewConnection(DB_TYPE);
	$dbconn->debug = ADODB_DEBUG;
	if (isset($dbinfo) && is_array($dbinfo)){
		$dbconn->Connect($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['db']);
	}else{
		$dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}

	$sql = "SHOW TABLES FROM ".DB_NAME;
	$listAllTable = $dbconn->getAll($sql);
	if(!empty($listAllTable)){
		for($i=0;$i<count($listAllTable);$i++){ 
			$tbl = $listAllTable[$i][0];
			$sqlField = "SHOW COLUMNS FROM ".$tbl;
			$listAllTableField = $dbconn->getAll($sqlField);
			if(!empty($listAllTableField)){
				foreach($listAllTableField as $item){
					$Key = $item['Key'];
					if($key != 'PRI'){
						$Null = $item['Null'];
						$Field = $item['Field'];
						$Type = $item['Type'];
						$Attributes = Helper::setInputType($Type);
						#
						$Default = '';
						if(isset($Attributes['dataType']) && $Attributes['dataType'] == 'number'){
							$Default = 0;
						} 
						
						if($Attributes['InputType']=='textarea'){
							$SQL = "ALTER TABLE `{$tbl}` MODIFY COLUMN `{$Field}` ".strtoupper($Type)." NULL";
						Helper::pre($SQL);
						}else{
							$SQL = "ALTER TABLE `{$tbl}` MODIFY COLUMN `{$Field}` ".strtoupper($Type)." DEFAULT '".$Default."'";
						Helper::pre($SQL);
						}
						
						$dbconn->Execute($SQL);
					}
				}
			}
		}
	}
?>