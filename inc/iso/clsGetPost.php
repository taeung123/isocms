<?
/**
*  Created by   :
*  @author		: Dung Luong Tien(luongtiendung@gmail.com)
*  @date		: 2012/07/11
*  @version		: 3.5.4
*/
class getGetPostValue
{
	var $input_form_method;
	var $strError;
	var $wasShowJSWYSIWYG = 0;
	
	function __construct() {
		$this->input_form_method = '';
		$this->strError = '';
	}
	
	function setMethod($input_form_method) {
		$this->input_form_method = (!empty($input_form_method))? $input_form_method : "GET";
	}
	
	function getStringValueFromFields($input_field) {
		return (!empty($input_field))? (($this->input_form_method!="GET")? $_POST[$input_field] : $_GET[$input_field]) : "";
	}
	
	function getIntValueFromFields($input_field) {
		return (!empty($input_field))? (($this->input_form_method!="GET")? intval($_POST[$input_field]) : intval($_GET[$input_field])) : "";
	}
	
	function showJSEditor() {
		$html = '<script type="text/javascript" src="'.PCMS_URL.'/includes/wysiwyg/scripts/wysiwyg.js"></script>';
		$html .= "\n";
		$html .= '<script type="text/javascript" src="'.PCMS_URL.'/includes/wysiwyg/scripts/wysiwyg-settings.js"></script>';
		$html .= "\n";
		$this->wasShowJSWYSIWYG=1;
		
		return $html;
	}
	
	//function
	function createTextEditor($type="notoolbar", $w="500px", $h="200px", $name="", $attr="", $value=""){
		$html = "";
		if ($this->wasShowJSWYSIWYG==0) {
			$html .= $this->showJSEditor();		
			$html.= "\n";
		}
								
		$id = "textarea_".$name;
		
		$html .= '<script type="text/javascript">';
				
		switch($type) {
			case "default"   : $html .= 'var mysettings = new WYSIWYG.Settings();'; 
			                   $html .= "\n";
							   $html .= 'mysettings.ImagePopupFile = "'.PCMS_URL.'/includes/wysiwyg/addons/imagelibrary/insert_image.php";'; 
							   $html .= "\n";
							   $html .= 'mysettings.ImagePopupWidth = 600;'; 
							   $html .= "\n";
							   $html .= 'mysettings.ImagePopupHeight = 245;';
							   $html .= "\n"; 
							   $html .= 'mysettings.Width = "'.$w.'";';
							   $html .= "\n"; 
							   $html .= 'mysettings.Height = "'.$h.'";';
							   $html .= "\n"; 
							   $html .= 'mysettings.removeToolbarElement("help");';
							   $html .= "\n";
							   $html .= 'WYSIWYG.attach("'.$id.'", mysettings);';
							   $html .= "\n";
							   break;
			
			case "notoolbar" : $html .= '';  
							   break;
			
			case "barhide"   : $html .= 'var mysettings = new WYSIWYG.Settings();'; 
			                   $html .= "\n";
							   $html .= 'mysettings.ImagePopupFile = "'.PCMS_URL.'/includes/wysiwyg/addons/imagelibrary/insert_image.php";'; 
							   $html .= "\n";
							   $html .= 'mysettings.ImagePopupWidth = 600;'; 
							   $html .= "\n";
							   $html .= 'mysettings.ImagePopupHeight = 245;';
							   $html .= "\n";
							   $html .= 'mysettings.Width = "'.$w.'";';
							   $html .= "\n"; 
							   $html .= 'mysettings.Height = "'.$h.'";';
							   $html .= "\n"; 
							   $html .= 'mysettings.Toolbar[0] = "";';
							   $html .= "\n";
							   $html .= 'mysettings.Toolbar[1] = "";';
							   $html .= "\n";
							   $html .= 'WYSIWYG.attach("'.$id.'", mysettings);';
							   $html .= "\n";
							   break;
							   
			case "full"      : $html .= 'var mysettings = new WYSIWYG.Settings();'; 
			                   $html .= "\n";
							   $html .= 'mysettings.ImagePopupFile = "'.PCMS_URL.'/includes/wysiwyg/addons/imagelibrary/insert_image.php";'; 
							   $html .= "\n";
							   $html .= 'mysettings.ImagePopupWidth = 600;'; 
							   $html .= "\n";
							   $html .= 'mysettings.ImagePopupHeight = 245;';
							   $html .= "\n";
							   $html .= 'mysettings.Width = "'.$w.'";';
							   $html .= "\n"; 
							   $html .= 'mysettings.Height = "'.$h.'";';
							   $html .= "\n"; 
							   $html .= 'mysettings.removeToolbarElement("help");';
							   $html .= "\n";
							   $html .= 'WYSIWYG.attach("'.$id.'", mysettings);';
							   $html .= "\n";
							   break;
			
			case "simple"    : $html .= 'var mysettings = new WYSIWYG.Settings();'; 
			                   $html .= "\n";
							   $html .= 'mysettings.ImagePopupFile = "'.PCMS_URL.'/includes/wysiwyg/addons/imagelibrary/insert_image.php";'; 
							   $html .= "\n";
							   $html .= 'mysettings.ImagePopupWidth = 600;'; 
							   $html .= "\n";
							   $html .= 'mysettings.ImagePopupHeight = 245;';
							   $html .= "\n";
							   $html .= 'mysettings.Width = "'.$w.'";';
							   $html .= "\n"; 
							   $html .= 'mysettings.Height = "'.$h.'";';
							   $html .= "\n"; 
							   $html .= 'mysettings.Toolbar[0] = new Array("font", "fontsize", "bold", "italic", "underline", "justifyleft", "justifycenter", "justifyright", "removeformat", "undo", "redo", "inserttable", "insertimage", "createlink", "viewSource");';
							   $html .= "\n";
							   $html .= 'mysettings.Toolbar[1] = "";';
							   $html .= "\n";
							   $html .= 'WYSIWYG.attach("'.$id.'", mysettings);';
							   $html .= "\n";
							   break;
										 
			case "customize" : $html .= 'var mysettings = new WYSIWYG.Settings();'; 
			                   $html .= "\n";
							   $html .= 'mysettings.ImagePopupFile = "'.PCMS_URL.'/includes/wysiwyg/addons/imagelibrary/insert_image.php";'; 
							   $html .= "\n";
							   $html .= 'mysettings.ImagePopupWidth = 600;'; 
							   $html .= "\n";
							   $html .= 'mysettings.ImagePopupHeight = 245;';
							   $html .= "\n";
							   $html .= 'mysettings.Width = "'.$w.'";';
							   $html .= "\n"; 
							   $html .= 'mysettings.Height = "'.$h.'";';
							   $html .= "\n"; 
							   $html .= 'mysettings.removeToolbarElement("help");';
							   $html .= "\n";
							   $html .= 'WYSIWYG.attach("'.$id.'", mysettings);';
							   $html .= "\n";
							   break;
		}
		
		$html .= '</script>';
		$html.= "\n";
		
		$html.= "<textarea name=\"".$name."\" id=\"textarea_".$name."\" $attr>$value</textarea>";
		$html.= "\n";
		
		return $html;		
	}
	/*	
	function createTextEditor($theme="advanced", $type="notoolbar", $row=5, $cols=10, $name="", $attr="", $value="") {
		$html.= "<!-- TinyMCE -->\n";
		$html.= "<script language=\"javascript\" src=\"".PCMS_URL."/includes/tinymce/tiny_mce.js\"></script>\n";
		$html.= "<script language=\"javascript\">\n";
		$html.= 'tinyMCE.init({'."\n";
		switch($type) {
			case "notoolbar" : $html .= 'mode : "textareas",
										 theme : "'.$theme.'",
										 skin : "o2k7",
										 plugins : "inlinepopups",
										 theme_advanced_buttons1 : "",
										 theme_advanced_buttons2 : "",
										 theme_advanced_buttons3 : "",
										 theme_advanced_buttons4 : "",
										 theme_advanced_toolbar_location : "",
										 theme_advanced_toolbar_align : "left",
										 theme_advanced_statusbar_location : "bottom",
										 theme_advanced_resizing : false,
										 force_p_newlines : \'false\',
										 force_br_newlines : true,
										 forced_root_block : \'\',
										 submit_patch : true
										 '; break;
			case "readonly"  : $html .= 'mode : "textareas",
										 theme : "'.$theme.'",
										 skin : "o2k7",
										 readonly : true,
										 force_p_newlines : \'false\',
										 force_br_newlines : true,
										 forced_root_block : \'\',
										 submit_patch : true,
										 content_css : "'.URL_CSS.'/word.css"
										 '; break;
			case "customize" : $html .= 'mode : "textareas",
										 theme : "'.$theme.'",
										 skin : "o2k7",
										 theme_advanced_buttons1 : "mybutton,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
										 theme_advanced_buttons2 : "",
										 theme_advanced_buttons3 : "",
										 theme_advanced_toolbar_location : "top",
										 theme_advanced_toolbar_align : "left",
										 theme_advanced_statusbar_location : "bottom",
										 plugins : "inlinepopups",
										 theme_advanced_resizing : false,
										 force_p_newlines : \'false\',
										 force_br_newlines : true,
										 forced_root_block : \'\',
										 submit_patch : true,
										 content_css : "'.URL_CSS.'/word.css"
										 '; break;
			case "full"      : $html .= 'mode : "textareas",
										 theme : "'.$theme.'",
										 skin : "o2k7",
										 plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
										 theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
										 theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
										 theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
										 theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
										 theme_advanced_toolbar_location : "top",
										 theme_advanced_toolbar_align : "left",
										 theme_advanced_statusbar_location : "bottom",
										 theme_advanced_resizing : false,
										 force_p_newlines : \'false\',
										 force_br_newlines : true,
										 forced_root_block : \'\',
										 submit_patch : true,
										 content_css : "'.URL_CSS.'/word.css"									 
										 '; break;
		}
		
		$html.= '});';
		$html.= "\n";
		$html.= "</script>\n";
		$html.= "<!-- /TinyMCE -->\n";
		$html.= "\n";
		
		$html.= "<textarea rows=\"".$row."\" cols=\"".$cols."\" name=\"$name\" id=\"$name\" $attr>$value</textarea>";
		
		return $html;
	}
	*/
}
?>