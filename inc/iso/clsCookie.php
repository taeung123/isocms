<?
/**
*  Created by   :
*  @author		: Dung Luong Tien(luongtiendung@gmail.com)
*  @date		: 2012/07/11
*  @version		: 3.5.4
*/
class VnCookie{
	var $name  		=  	"";
	var $arrVar    	=  	array();
	var $expires	=  	0;
	var $path    	=  	'/'; 
	var $site   	=  	'';
	/**
	 * Init class
	 */
	function __construct($_name, $_expires = "", $_path = "/", $_site = "")
	{
		$this->name  =  $_name;
		if($_expires){
			$this->expires  =  $_expires;
		}else{
			$this->expires  =  time() + 60*60*24*5;//~5 days
		}

		$this->path  =  $_path;
		$this->site  =  $_site;
		$this->arrVar  =  array();
		$this->extractAll();
	}

	/**
	 * Extract all cookie var
	 */
	function extractAll($name = "", $register_global=false){
		if(!isset($_COOKIE)){
			global $_COOKIE;
			$_COOKIE  =  $GLOBALS["HTTP_COOKIE_VARS"];
		}

		if(empty($name) && isset($this)){
			$name = $this->name;
		}
	
		if(!empty($_COOKIE[$name])){		
			if(get_magic_quotes_gpc()){
				$_COOKIE[$name] = stripslashes($_COOKIE[$name]);
			}
			$arr = unserialize($_COOKIE[$name]);
			//check regist global
			if ($register_global){		
				if($arr!== false && is_array($arr)){		
					foreach($arr as $var  => $val){								
						$_COOKIE[$var] = $val;			
						if(isset($GLOBALS["PHP_SELF"])){
							$GLOBALS[$var] = $val;
						}
					}
				}	
			}	
			if(isset($this)) $this->arrVar = $arr;	
		}
		unset($_COOKIE[$name]);
		unset($GLOBALS[$name]);
	}
	
	/**
	 * Get var
	 */
	function getVar($var){
		return $this->arrVar[$var];
	}
	/**
	 * Put $var = $value
	 */
	function putVar($var, $value="")
	{
		$_COOKIE[$var] = $value;
		$this->arrVar["$var"] = $value;
		
		if(isset($GLOBALS["PHP_SELF"])){
			$GLOBALS[$var] = $value;
		}
		
		if(empty($value)){
			unset($this->arrVar[$var]);
		}
	
	}
	/**
	 * Clear all value
	 */
	function clearVar()
	{
		$this->arrVar = array();
	}

	/**
	 * Set cookie after put
	 */
	function setVar()
	{
		if(empty($this->arrVar)){
			$cookiearr = "";
		}else{
			$cookiearr = serialize($this->arrVar);
		}

		if(strlen($cookiearr)>4*1024){
			//error length of cookie variable
			return 0;
		}
		setcookie("$this->name", $cookiearr, $this->expires, $this->path, $this->site);
	}
}
?>