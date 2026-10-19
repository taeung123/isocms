<?php
	function isSecure() {
	  return
		(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
		|| $_SERVER['SERVER_PORT'] == 443;
	}
	function checkBrowser(){
		require_once $_SERVER['DOCUMENT_ROOT'].'/inc/Mobile_Detect.php';
		$detect = new Mobile_Detect;
		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		return $deviceType; 
	}
	
	define("PCMS_DIR", $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['SCRIPT_NAME']));
	define("PCMS_URL", "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
	#Common Directory
	define("DIR_INCLUDES", 	PCMS_DIR."/inc");
	define("DIR_LANG", 		PCMS_DIR."/lang");
	define("DIR_LOGS", 		PCMS_DIR."/logs");
	define("DIR_THEMES", 	PCMS_DIR."/themes");
	define("DIR_TMP", 		PCMS_DIR."/tmp");
	define("DIR_UPLOADS",	PCMS_DIR."/uploads");
	define("DIR_CLASSES", 	PCMS_DIR."/classes");
	define("DIR_COMMON", 	DIR_INCLUDES."/iso");
	define("DIR_SMARTY", 	DIR_INCLUDES."/smarty");
	define("DIR_ADODB", 	DIR_INCLUDES."/adodb");
	define("DIR_PEAR", 		DIR_INCLUDES."/PEAR");
	define("DIR_LIB", 		DIR_INCLUDES."/lib");
	define("DIR_CONF", 		DIR_INCLUDES."/conf");
	
	define("URL_THEMES", 	PCMS_URL."/isocms/templates/default/skin");
	define("DIR_TEMPLATES", PCMS_DIR."/isocms/templates/default/skin");
	define("URL_CSS", 		URL_THEMES."/css");
	define("URL_JS", 		URL_THEMES."/js");
	
	function compress($buffer) {
		/* remove comments */
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		/* remove tabs, spaces, new lines, etc. */        
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
		/* remove unnecessary spaces */        
		$buffer = str_replace('{ ', '{', $buffer);
		$buffer = str_replace(' }', '}', $buffer);
		$buffer = str_replace('; ', ';', $buffer);
		$buffer = str_replace(', ', ',', $buffer);
		$buffer = str_replace(' {', '{', $buffer);
		$buffer = str_replace('} ', '}', $buffer);
		$buffer = str_replace(': ', ':', $buffer);
		$buffer = str_replace(' ,', ',', $buffer);
		$buffer = str_replace(' ;', ';', $buffer);
		return $buffer;
	}
	#
	$minExpected = '';
	$minExpected .= file_get_contents(URL_CSS.'/bootstrap.css');
	$minExpected .= file_get_contents(URL_CSS.'/global-v2.css');
	$minExpected .= file_get_contents(URL_CSS.'/global-v1.css');
	$minExpected .= file_get_contents(URL_CSS.'/destinations.css');
	$minExpected .= file_get_contents(URL_CSS.'/font-awesome.min.css');
	$minExpected .= file_get_contents(URL_JS.'/owl/owl.carousel.css');
	$minExpected .= file_get_contents(URL_JS.'/tipsy/tipsy.css');
	#
	if(checkBrowser()=='tablet'){
		$minExpected .= file_get_contents(URL_CSS.'/tablet.css');
	}else if(checkBrowser()=='phone'){
		$minExpected .= file_get_contents(URL_CSS.'/phone.css');
	}
	$minOutput = compress($minExpected);
	@file_put_contents(DIR_TEMPLATES.'/css/global.min.css',$minOutput);
	#
	$sLastModified = gmdate('D, d M Y H:i:s', time()).' GMT';
	header('Expires: '.gmdate('D, d M Y H:i:s', time() + 31356000).' GMT'); /*1 year from now*/
	header('Content-Type: text/css');
	header('Content-Length: '.strlen($html));
	header("Last-Modified: $sLastModified");
	header('Cache-Control: max-age= 31356000');
	echo $minOutput;
?>