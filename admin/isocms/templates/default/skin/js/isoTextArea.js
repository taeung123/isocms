(function($){
	$.fn.isoTextArea = function() {
		var $editorID = $(this).attr('id');
		tinyMCE.init({
            mode: "textareas",
            height : "300px",
            theme: "modern",
            mobile: {
                theme: "mobile",
            },
            selector: '#'+$editorID,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help filemanager youTube'
            ],
            toolbar: 'undo redo | insert | styleselect| fontselect | fontsizeselect | bold italic | bullist numlist outdent indent | link unlink image imagetools youTube | print preview media | anchor | toc | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons| help',
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align],+a[id|rel|rev|dir|onclick|tabindex|accesskey|type|name|href=javascript:void(0);|target|title|class]",
            menubar: true,
            relative_urls: false,
            convert_urls:false,
            apply_source_formatting:false,
            remove_string_host: false,
            remove_linebreaks: false,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements:"major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes:"all",
            forced_root_block : "false",
            force_p_newlines : true,
            force_br_newlines : false,
            convert_newlines_to_brs : false,
            remove_redundant_brs : true,
            setup : function(editor) {
                editor.on('BeforeSetContent', function(ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            }

        });
		return this;
	};
})(jQuery);
(function($){
	$.fn.isoTextAreaSimple = function() {
		var $editorID = $(this).attr('id');
		tinyMCE.init({
            mode: "textareas",
            height : "300px",
            theme: "modern",
            mobile: {
                theme: "mobile",
            },
            selector: '#'+$editorID,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help filemanager youTube'
            ],
            toolbar: 'undo redo | insert | styleselect| fontselect | fontsizeselect | bold italic | bullist numlist outdent indent | link unlink image imagetools youTube | print preview media | anchor | toc | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons| help',
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align],+a[id|rel|rev|dir|onclick|tabindex|accesskey|type|name|href=javascript:void(0);|target|title|class]",
            menubar: true,
            relative_urls: false,
            convert_urls:false,
            apply_source_formatting:false,
            remove_string_host: false,
            remove_linebreaks: false,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements:"major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes:"all",
            forced_root_block : "false",
            force_p_newlines : true,
            force_br_newlines : false,
            convert_newlines_to_brs : false,
            remove_redundant_brs : true,
            setup : function(editor) {
                editor.on('BeforeSetContent', function(ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            }

        });
		return this;
	};
})(jQuery);
(function($){
	$.fn.isoTextAreaSimpleEmail = function() {
		var $editorID = $(this).attr('id');
		tinyMCE.init({
            mode: "textareas",
            height : "300px",
            theme: "modern",
            mobile: {
                theme: "mobile",
            },
            selector: '#'+$editorID,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help filemanager youTube'
            ],
            toolbar: 'undo redo | insert | styleselect| fontselect | fontsizeselect | bold italic | bullist numlist outdent indent | link unlink image imagetools youTube | print preview media | anchor | toc | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons| help',
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align],+a[id|rel|rev|dir|onclick|tabindex|accesskey|type|name|href=javascript:void(0);|target|title|class]",
            menubar: true,
            relative_urls: false,
            convert_urls:false,
            apply_source_formatting:false,
            remove_string_host: false,
            remove_linebreaks: false,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements:"major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes:"all",
            forced_root_block : "false",
            force_p_newlines : true,
            force_br_newlines : false,
            convert_newlines_to_brs : false,
            remove_redundant_brs : true,
            setup : function(editor) {
                editor.on('BeforeSetContent', function(ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            }

        });
		return this;
	};
})(jQuery);
(function($){
	$.fn.isoTextAreaFix = function() {
		var $editorID = $(this).attr('id');
		tinyMCE.init({
            mode: "textareas",
            height : "300px",
            theme: "modern",
            mobile: {
                theme: "mobile",
            },
            selector: '#'+$editorID,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help filemanager youTube'
            ],
            toolbar: 'undo redo | insert | styleselect| fontselect | fontsizeselect | bold italic | bullist numlist outdent indent | link unlink image imagetools youTube | print preview media | anchor | toc | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons| help',
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align],+a[id|rel|rev|dir|onclick|tabindex|accesskey|type|name|href=javascript:void(0);|target|title|class]",
            menubar: true,
            relative_urls: false,
            convert_urls:false,
            apply_source_formatting:false,
            remove_string_host: false,
            remove_linebreaks: false,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements:"major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes:"all",
            forced_root_block : "false",
            force_p_newlines : true,
            force_br_newlines : false,
            convert_newlines_to_brs : false,
            remove_redundant_brs : true,
            setup : function(editor) {
                editor.on('BeforeSetContent', function(ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            }

        });
		return this;
	};
})(jQuery);
(function($){
    $.fn.isoTextAreaFull = function() {
        var $editorID = $(this).attr('id');
        tinyMCE.init({
            mode: "textareas",
            height : "300px",
            theme: "modern",
            mobile: {
                theme: "mobile",
            },
            selector: '#'+$editorID,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help filemanager youTube'
            ],
            toolbar: 'undo redo | insert | styleselect| fontselect | fontsizeselect | bold italic | bullist numlist outdent indent | link unlink image imagetools youTube | print preview media | anchor | toc | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons| help',
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align],+a[id|rel|rev|dir|onclick|tabindex|accesskey|type|name|href=javascript:void(0);|target|title|class]",
            menubar: true,
            relative_urls: false,
            convert_urls:false,
            apply_source_formatting:false,
            remove_string_host: false,
            remove_linebreaks: false,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements:"major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes:"all",
            forced_root_block : "false",
            force_p_newlines : true,
            force_br_newlines : false,
            convert_newlines_to_brs : false,
            remove_redundant_brs : true,
            setup : function(editor) {
                editor.on('BeforeSetContent', function(ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            }

        });
        return this;
    };
})(jQuery);
(function($){
    $.fn.isoTextAreaEmail= function() {
        var $editorID = $(this).attr('id');
        tinyMCE.init({
            mode: "textareas",
            height : "300px",
            theme: "modern",
            mobile: {
                theme: "mobile",
            },
            selector: '#'+$editorID,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help filemanager youTube'
            ],
            toolbar: 'undo redo | insert | styleselect| fontselect | fontsizeselect | bold italic | bullist numlist outdent indent | link unlink image imagetools youTube | print preview media | anchor | toc | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons| help',
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align],+a[id|rel|rev|dir|onclick|tabindex|accesskey|type|name|href=javascript:void(0);|target|title|class]",
            menubar: true,
            relative_urls: false,
            convert_urls:false,
            apply_source_formatting:false,
            remove_string_host: false,
            remove_linebreaks: false,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements:"major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes:"all",
            forced_root_block : "false",
            force_p_newlines : true,
            force_br_newlines : false,
            convert_newlines_to_brs : false,
            remove_redundant_brs : true,
            setup : function(editor) {
                editor.on('BeforeSetContent', function(ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            }

        });
        return this;
    };
})(jQuery);
(function($){
    $.fn.isoTextAreaFullPage= function() {
        var $editorID = $(this).attr('id');
        tinyMCE.init({
            mode: "textareas",
            height : "300px",
            theme: "modern",
            mobile: {
                theme: "mobile",
            },
            selector: '#'+$editorID,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help filemanager youTube'
            ],
            toolbar: 'undo redo | insert | styleselect| fontselect | fontsizeselect | bold italic | bullist numlist outdent indent | link unlink image imagetools youTube | print preview media | anchor | toc | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons| help',
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align],+a[id|rel|rev|dir|onclick|tabindex|accesskey|type|name|href=javascript:void(0);|target|title|class]",
            menubar: true,
            relative_urls: false,
            convert_urls:false,
            apply_source_formatting:false,
            remove_string_host: false,
            remove_linebreaks: false,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements:"major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes:"all",
            forced_root_block : "false",
            force_p_newlines : true,
            force_br_newlines : false,
            convert_newlines_to_brs : false,
            remove_redundant_brs : true,
            setup : function(editor) {
                editor.on('BeforeSetContent', function(ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (ed) {
                    ed.content = ed.content.replace(/<br\s?\/?>/g,"\n");
                });
            }

        });
        return this;
    };
})(jQuery);
