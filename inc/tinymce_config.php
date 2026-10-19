<?php
$tinymce_config = '
	tinyMCE.init({
		theme: "modern",
		mobile: {
			theme: "mobile",
		},
		height: \'300px\',
		mode : "textareas",
		editor_selector: "mceFull",
		editor_deselector : "mceNoEditor",
		valid_elements : "*[*]",   
		plugins: [
			\'advlist autolink lists link image charmap print preview hr anchor pagebreak\',
			\'searchreplace wordcount visualblocks visualchars code fullscreen\',
			\'insertdatetime media nonbreaking save table contextmenu directionality\',
			\'emoticons template textcolor colorpicker textpattern imagetools codesample toc help filemanager youTube powerpaste\'
		],
		toolbar1: \'undo redo | insert | styleselect| fontselect | fontsizeselect | bold italic | bullist numlist outdent indent | link unlink image imagetools youTube | print preview media | anchor | toc | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons| help\',   
		  powerpaste_allow_local_images: true,
		  powerpaste_word_import: \'prompt\',
		  powerpaste_html_import: \'prompt\',
		fontsize_formats: "10px 12px 13px 14px 15px 16px 18px 24px 36px",
		extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align],+a[id|rel|rev|dir|onclick|tabindex|accesskey|type|name|href=javascript:void(0);|target|title|class]",
		menubar: true,
		relative_urls: false,
		convert_urls:false,
		apply_source_formatting:false,
		remove_string_host: false,
		remove_linebreaks: true,
		gecko_spellcheck: true,
		accessibility_focus: true,
		tabfocus_elements:"major-publishing-actions",
		paste_remove_styles: false,
		paste_remove_spans: true,
		paste_strip_class_attributes:"all",
		forced_root_block : "",
		force_br_newlines : false,
		force_p_newlines : true,
		remove_redundant_brs : false,
		convert_newlines_to_brs : false,
        visual_anchor_class: "anchor_link",
		setup : function(editor) {
            editor.on(\'BeforeSetContent\', function(ed) {
				 
			});
		},
		init_instance_callback: function (editor) {
			editor.on(\'PostProcess\', function (ed) {
				
			});
			editor.on(\'keydown\', function(e) {
				if(e.keyCode == 9){
				  e.preventDefault();
				  tinyMCE.activeEditor.execCommand(\'mceInsertContent\', false, "&emsp;&emsp;");
				}
			});
		}
	});';
$tinymce_config_mobile = '
		tinyMCE.init({
			theme: "modern",
			mobile: {
				theme: "mobile",
			},
			height: \'200px\',
			mode : "textareas",
			editor_selector: "mceFull",
			editor_deselector : "mceNoEditor",
			valid_elements : "*[*]",   
			plugins: [
				\'advlist autolink lists print hr anchor pagebreak\',
			],
   			toolbar1: \'undo redo | fontsizeselect | styleselect | bold italic \',   
			
			fontsize_formats: "10px 12px 13px 14px 15px 16px 18px 24px 36px",
			extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align],+a[id|rel|rev|dir|onclick|tabindex|accesskey|type|name|href=javascript:void(0);|target|title|class]",
			menubar: true,
			relative_urls: false,
			convert_urls:false,
			apply_source_formatting:false,
			remove_string_host: false,
			remove_linebreaks: true,
			gecko_spellcheck: true,
			accessibility_focus: true,
			tabfocus_elements:"major-publishing-actions",
			paste_remove_styles: true,
			paste_remove_spans: true,
			paste_strip_class_attributes:"all",
			forced_root_block : "",
			force_br_newlines : false,
			force_p_newlines : true,
			remove_redundant_brs : false,
			convert_newlines_to_brs : false,
            visual_anchor_class: "anchor_link",
			setup : function(editor) {
				editor.on(\'BeforeSetContent\', function(ed) {
				});
			},
			init_instance_callback: function (editor) {
				editor.on(\'PostProcess\', function (ed) {
				});
			}
		});';

$tinymce_config_static = '
	tinyMCE.init({
		theme: "modern",
		mobile: {
			theme: "mobile",
		},
		height:\'120px\',
		mode : "textareas",
		editor_selector: "mceStatic",
		editor_deselector : "mceNoEditor",
		valid_elements : "*[*]",
		plugins: [
			\'advlist autolink lists link image charmap print preview hr anchor pagebreak\',
			\'searchreplace wordcount visualblocks visualchars code fullscreen\',
			\'insertdatetime media nonbreaking save table contextmenu directionality\',
			\'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help filemanager\'
		],
		toolbar1: \'undo redo | insert | styleselect | bold italic | bullist numlist outdent indent | link unlink image imagetools\',
		extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align]",
		menubar: false,
		relative_urls: false,
		convert_urls:false,
		apply_source_formatting:false,
		remove_string_host: false,
		remove_trailing_brs: true,
		remove_linebreaks: true,
		gecko_spellcheck: true,
		accessibility_focus: true,
		tabfocus_elements:"major-publishing-actions",
		paste_remove_styles: true,
		paste_remove_spans: true,
		paste_strip_class_attributes:"all",
		forced_root_block : false,
		force_br_newlines : false,
		force_p_newlines : true,
		convert_newlines_to_brs : false,
        visual_anchor_class: "anchor_link",
		setup : function(editor) {
            editor.on(\'BeforeSetContent\', function(ed) {
			
			});
		}
	});';

$tinymce_config_simple = 'tinyMCE.init({
		theme: "modern",
		mobile: {
			theme: "mobile",
		},
		mode : "textareas",
		height:\'300px\',
		editor_selector: "mceSimple",
		editor_deselector : "mceNoEditor",
		valid_elements : "*[*]", 
		plugins: [
			\'advlist autolink lists link image charmap print preview hr anchor pagebreak\',
			\'searchreplace wordcount visualblocks visualchars code fullscreen\',
			\'insertdatetime media nonbreaking save table contextmenu directionality\',
			\'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help filemanager\'
		],
		toolbar1: \'undo redo | insert | styleselect | bold italic | bullist numlist outdent indent | link unlink image imagetools\',
		extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align]",
		menubar: false,
		toolbar_items_size: "small",
		relative_urls: false,
		convert_urls:false,
		apply_source_formatting:false,
		remove_string_host: false,
		remove_trailing_brs: true,
		remove_linebreaks: true,
		gecko_spellcheck: true,
		accessibility_focus: true,
		tabfocus_elements:"major-publishing-actions",
		paste_remove_styles: true,
		paste_remove_spans: true,
		paste_strip_class_attributes:"all",
		forced_root_block : false,
		force_br_newlines : false,
		force_p_newlines : true,
		convert_newlines_to_brs : false,
        visual_anchor_class: "anchor_link",
		setup : function(editor) {
            editor.on(\'BeforeSetContent\', function(ed) {
				
			});
		}
	});';
$tinymce_config_simple_height150 = 'tinyMCE.init({
		theme: "modern",
		mobile: {
			theme: "mobile",
		},
		mode : "textareas",
		height:\'150px\',
		editor_selector: "mceSimple",
		editor_deselector : "mceNoEditor",
		valid_elements : "*[*]", 
		plugins: [
			\'advlist autolink lists link image charmap print preview hr anchor pagebreak\',
			\'searchreplace wordcount visualblocks visualchars code fullscreen\',
			\'insertdatetime media nonbreaking save table contextmenu directionality\',
			\'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help filemanager\'
		],
		toolbar1: \'undo redo | insert | styleselect | bold italic | bullist numlist outdent indent | link unlink image imagetools\',
		extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align]",
		menubar: false,
		toolbar_items_size: "small",
		relative_urls: false,
		convert_urls:false,
		apply_source_formatting:false,
		remove_string_host: false,
		remove_trailing_brs: true,
		remove_linebreaks: true,
		gecko_spellcheck: true,
		accessibility_focus: true,
		tabfocus_elements:"major-publishing-actions",
		paste_remove_styles: true,
		paste_remove_spans: true,
		paste_strip_class_attributes:"all",
		forced_root_block : false,
		force_br_newlines : false,
		force_p_newlines : true,
		convert_newlines_to_brs : false,
        visual_anchor_class: "anchor_link",
		setup : function(editor) {
            editor.on(\'BeforeSetContent\', function(ed) {
			
			});
		}
	});';
$tinymce_config_simple_no_tool = 'tinyMCE.init({
		theme: "modern",
		mobile: {
			theme: "mobile",
		},
		mode : "textareas",
		height:\'150px\',
		editor_selector: "mceSimple",
		editor_deselector : "mceNoEditor",
		valid_elements : "*[*]", 
		plugins: [
			\'advlist autolink lists link image charmap print preview hr anchor pagebreak\',
			\'searchreplace wordcount visualblocks visualchars code fullscreen\',
			\'insertdatetime media nonbreaking save table contextmenu directionality\',
			\'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help filemanager\'
		],
		toolbar1: false,
		toolbar: false,
		extended_valid_elements : false,
		menubar: false,
		toolbar_items_size: "small",
		relative_urls: false,
		convert_urls:false,
		apply_source_formatting:false,
		remove_string_host: false,
		remove_trailing_brs: true,
		remove_linebreaks: true,
		gecko_spellcheck: true,
		accessibility_focus: true,
		tabfocus_elements:"major-publishing-actions",
		paste_remove_styles: true,
		paste_remove_spans: true,
		paste_strip_class_attributes:"all",
		forced_root_block : false,
		force_br_newlines : false,
		force_p_newlines : true,
		convert_newlines_to_brs : false,
        visual_anchor_class: "anchor_link",
		setup : function(editor) {
            editor.on(\'BeforeSetContent\', function(ed) {
			});
		}
	});';

require_once DIR_CLASSES . "/class_ISO.php";
$clsISO = new ISO();

if ($clsISO->getBrowser() == 'phone') {
	define("_TINYMCE_CONFIG", $tinymce_config_mobile);
	define("_TINYMCE_CONFIG_STATIC", $tinymce_config_mobile);
	define("_TINYMCE_CONFIG_SIMPLE", $tinymce_config_mobile);
	define("_TINYMCE_CONFIG_SIMPLE_HEIGHT150", $tinymce_config_mobile);
} else {
	define("_TINYMCE_CONFIG", $tinymce_config);
	define("_TINYMCE_CONFIG_STATIC", $tinymce_config_static);
	define("_TINYMCE_CONFIG_SIMPLE", $tinymce_config_simple);
	define("_TINYMCE_CONFIG_SIMPLE_HEIGHT150", $tinymce_config_simple_height150);
	define("_TINYMCE_CONFIG_SIMPLE_NO_TOOL", $tinymce_config_simple_no_tool);
}
