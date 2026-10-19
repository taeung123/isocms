(function($){
    $.fn.isoTextArea = function() {
        var $editorID = $(this).attr('id');
        tinymce.init({
            selector: `#${$editorID}`,
            height: "500px",
            menubar: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste'
            ],
            toolbar: 'undo redo | insert | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            mobile: {
                theme: 'mobile'
            },
            extended_valid_elements: "iframe[src|frameborder|style|scrolling|class|width|height|name|align]",
            relative_urls: false,
            convert_urls: false,
            apply_source_formatting: false,
            remove_linebreaks: false,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements: "major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes: "all",
            forced_root_block: "",
            force_p_newlines: true,
            force_br_newlines: false,
            convert_newlines_to_brs: false,
            remove_redundant_brs: true,
            setup: function (editor) {
                editor.on('BeforeSetContent', function (event) {
                    event.content = event.content.replace(/<br\s?\/?>/g, "\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (event) {
                    event.content = event.content.replace(/<br\s?\/?>/g, "\n");
                });
            }
        });
        return this;
    };
})(jQuery);
(function($){
    $.fn.isoTextAreaSimple = function() {
        var $editorID = $(this).attr('id');
        tinymce.init({
            selector: `#${$editorID}`,
            height: "300px",
            menubar: true,
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste'
            ],
            mobile: {
                theme: 'mobile'
            },
            extended_valid_elements: "iframe[src|frameborder|style|scrolling|class|width|height|name|align]",
            relative_urls: false,
            convert_urls: false,
            apply_source_formatting: false,
            remove_linebreaks: false,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements: "major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes: "all",
            forced_root_block: "",
            force_p_newlines: true,
            force_br_newlines: false,
            convert_newlines_to_brs: false,
            remove_redundant_brs: true,
            setup: function (editor) {
                editor.on('BeforeSetContent', function (event) {
                    event.content = event.content.replace(/<br\s?\/?>/g, "\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (event) {
                    event.content = event.content.replace(/<br\s?\/?>/g, "\n");
                });
            }
        });
        return this;
    };
})(jQuery);
(function($){
    $.fn.isoTextAreaSimpleEmail = function() {
        var $editorID = $(this).attr('id');
        tinymce.init({
            selector: `#${$editorID}`,  // Chọn textarea bằng ID từ biến $editorID
            height: "300px",
            menubar: true,
            toolbar: 'undo redo | insert | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code'
            ],
            mobile: {
                theme: 'mobile'
            },
            valid_elements: "*[*]",
            extended_valid_elements: "iframe[src|frameborder|style|scrolling|class|width|height|name|align]",
            relative_urls: false,
            convert_urls: false,
            apply_source_formatting: false,
            remove_linebreaks: true,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements: "major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes: "all",
            forced_root_block: "",  // Không tự động thêm thẻ `<p>`
            force_br_newlines: false,
            force_p_newlines: true,
            remove_redundant_brs: false,
            convert_newlines_to_brs: false,
            setup: function (editor) {
                editor.on('BeforeSetContent', function (event) {
                    event.content = event.content.replace(/<br\s?\/?>/g, "\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (event) {
                    event.content = event.content.replace(/<br\s?\/?>/g, "\n");
                });
            }
        });
        return this;
    };
})(jQuery);
(function($){
    $.fn.isoTextAreaFix = function() {
        var $editorID = $(this).attr('id');
        tinymce.init({
            selector: `#${$editorID}`,  // Thay thế cho mode "exact" bằng cách sử dụng selector
            height: "150px",
            menubar: true,
            toolbar: 'undo redo | insert | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code'
            ],
            mobile: {
                theme: 'mobile'
            },
            extended_valid_elements: "iframe[src|frameborder|style|scrolling|class|width|height|name|align]",
            relative_urls: false,
            convert_urls: false,
            apply_source_formatting: false,
            remove_string_host: false,
            remove_linebreaks: false,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements: "major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes: "all",
            forced_root_block: "",  // Để bỏ thẻ gốc mặc định
            force_p_newlines: true,
            force_br_newlines: false,
            convert_newlines_to_brs: false,
            remove_redundant_brs: true,
            setup: function (editor) {
                editor.on('BeforeSetContent', function (event) {
                    event.content = event.content.replace(/<br\s?\/?>/g, "\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (event) {
                    event.content = event.content.replace(/<br\s?\/?>/g, "\n");
                });
            }
        });

        return this;
    };
})(jQuery);
(function($){
    $.fn.isoTextAreaFull = function() {
        var $editorID = $(this).attr('id');
        tinymce.init({
            selector: `#${$editorID}`,  // TinyMCE 7 không hỗ trợ `mode: "textareas"`, thay vào đó dùng `selector`.
            height: "500px",
            menubar: true,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
                // `filemanager` và `youTube` cần tích hợp riêng nếu có API hỗ trợ TinyMCE 7.
            ],
            toolbar: 'undo redo | insert | styles | fontselect | fontsizeselect | bold italic | bullist numlist outdent indent | link unlink image imagetools | print preview media | anchor | toc | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons| help',
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            extended_valid_elements: "iframe[src|frameborder|style|scrolling|class|width|height|name|align],+a[id|rel|rev|dir|onclick|tabindex|accesskey|type|name|href=javascript:void(0);|target|title|class]",
            mobile: {
                theme: 'mobile'
            },
            relative_urls: false,
            convert_urls: false,
            apply_source_formatting: false,
            remove_string_host: false,
            remove_linebreaks: false,
            gecko_spellcheck: true,
            accessibility_focus: true,
            tabfocus_elements: "major-publishing-actions",
            paste_remove_styles: true,
            paste_remove_spans: true,
            paste_strip_class_attributes: "all",
            forced_root_block: "",  // Để bỏ thẻ gốc mặc định, TinyMCE 7 không hỗ trợ "false"
            force_p_newlines: true,
            force_br_newlines: false,
            convert_newlines_to_brs: false,
            remove_redundant_brs: true,
            setup: function (editor) {
                editor.on('BeforeSetContent', function (event) {
                    event.content = event.content.replace(/<br\s?\/?>/g, "\n");
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (event) {
                    event.content = event.content.replace(/<br\s?\/?>/g, "\n");
                });
            }
        });

        return this;
    };
})(jQuery);
(function($){
    $.fn.isoTextAreaEmail= function() {
        var $editorID = $(this).attr('id');
        tinymce.init({
            selector: `#${$editorID}`,  // Chỉ định selector trực tiếp cho TinyMCE 7
            height: "500px",
            menubar: true,
            mobile: {
                theme: "mobile"
            },
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
                // `filemanager` và `youTube` có thể cần plugin bổ sung tùy thuộc vào API TinyMCE 7
            ],
            toolbar: 'undo redo | insert | styles | fontselect | fontsizeselect | bold italic | bullist numlist outdent indent | link unlink image imagetools | print preview media | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons | help',
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            extended_valid_elements: '*[*]',  // Cho phép tất cả các phần tử và thuộc tính
            relative_urls: false,
            convert_urls: false,
            apply_source_formatting: false,
            remove_string_host: false,
            remove_linebreaks: false,
            gecko_spellcheck: false,
            accessibility_focus: false,
            tabfocus_elements: "major-publishing-actions",
            paste_remove_styles: false,
            paste_remove_spans: false,
            paste_strip_class_attributes: "all",
            forced_root_block: "",  // Để bỏ thẻ gốc mặc định
            force_br_newlines: false,
            force_p_newlines: false,
            remove_redundant_brs: false,
            convert_newlines_to_brs: false,
            setup: function (editor) {
                editor.on('BeforeSetContent', function (event) {
                    // Điều chỉnh nội dung trước khi thiết lập, nếu cần
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (event) {
                    // Điều chỉnh nội dung sau khi xử lý, nếu cần
                });
            }
        });

        return this;
    };
})(jQuery);
(function($){
    $.fn.isoTextAreaFullPage= function() {
        var $editorID = $(this).attr('id');
        tinymce.init({
            selector: `#${$editorID}`,
            plugins: 'fullpage',
            menubar: 'file',
            toolbar: 'fullpage',
            fullpage_default_doctype: "<!DOCTYPE html>",
            setup: function (editor) {
                editor.on('BeforeSetContent', function (event) {
                    // Thêm logic trước khi nội dung được thiết lập, nếu cần
                });
            },
            init_instance_callback: function (editor) {
                editor.on('PostProcess', function (event) {
                    // Thêm logic sau khi xử lý nội dung, nếu cần
                });
            }
        });

        return this;
    };
})(jQuery);
