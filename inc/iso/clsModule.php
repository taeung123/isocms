<?

/**
 *  Created by   :
 *  @author		: Dung Luong Tien(luongtiendung@gmail.com)
 *  @date		: 2012/07/11
 *  @version		: 3.5.4
 */
if (!defined("DIR_MODULES")) {
	trigger_error("Cannot find constant 'DIR_MODULES'", E_USER_ERROR);
	die();
}
/**
 *  Class Module Driver
 *  @author		: Luong Tien Dung
 *  @date		: 2009/10/01
 *  @version		: 3.0.0
 */
class Module extends DbBasic
{
	var $mod = ""; //name of module
	var $path = DIR_MODULES; //path to module file
	var $arrSub = array(); //array submod of module
	var $arrAct = array(); //array action of submod
	var $errNo = 0; //error code
	var $requireLogin = 0; //0 is no need log in
	//function
	function __construct($_mod = "", $_path = "")
	{
		$this->pkey = "moduleid";
		$this->tbl = DB_PREFIX . "module";
		if ($_mod != "") $this->mod = $_mod;
		if ($_path != "") $this->path = $_path;
		if (!is_dir($this->path . "/" . $this->mod)) {
			//ModuleFolder is not exists
			trigger_error("Module Folder is not exists!", E_USER_ERROR);
			exit();
		}
	}
	//function
	function addSub($sub)
	{
		array_push($this->arrSub, $sub);
		$this->arrAct[$sub] = array();
	}
	//function
	function addAct($sub, $act)
	{
		array_push($this->arrAct[$sub], $act);
	}
	//function
	function existsSub($sub)
	{
		return in_array($sub, $this->arrSub);
	}
	//function
	function existsAct($sub, $act)
	{
		return in_array($act, $this->arrAct[$sub]);
	}
	//function
	function run($sub = "default", $act = "default")
	{
		$this->addSub($sub);
		$this->addAct($sub, $act);
		if ($this->existsSub($sub) && $this->existsAct($sub, $act)) {
			$file_mod_sub = $this->path . "/" . $this->mod . "/sub_" . $sub . ".php";
			if (file_exists($file_mod_sub)) {
				require_once($file_mod_sub);
				$funcdef = $sub . "_default";
				$func = $sub . "_" . $act;
				if (function_exists($func)) {
					$func(); //call function sub_act()
				} else
				if (function_exists($funcdef)) {
					$funcdef(); //call function sub_default()
				} else {
					//function sub_act() is not installed
					trigger_error("SubModule is not found!", E_USER_ERROR);
					exit();
				}
			} else {
				//SubModule file is not exists	
				trigger_error("ModuleFile is not found!", E_USER_ERROR);
				exit();
			}
		} else {
			//not exists act of sub or act is not registered to sub
			trigger_error("This Module did not install!", E_USER_ERROR);
			exit();
		}
	}
	//function
	function makeOptions($status = "ON", $arr = "ON,OFF")
	{
		$arrOptions = explode(',', $arr);
		$hmtl = "";
		foreach ($arrOptions as $val) {
			$selected = ($val == $status) ? "selected" : "";
			$html .= "<option value='$val' $selected >$val</options>";
		}
		return $html;
	}
}
//class Block
class Block extends DbBasic
{
	var $blockid = "";
	var $site = "";
	var $name = "";
	function __construct()
	{
		$this->pkey = "blockid";
		$this->tbl = "block";
	}
}
