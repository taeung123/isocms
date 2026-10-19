class IsoManager {
    constructor() {
        this.init();
    }

    init() {
        this.bindGlobal();
        this.bindDialog();
        this.bindMenu();
    }

    /* ===============================
     * GLOBAL / BASE
     * =============================== */
    bindGlobal() {
        $(document).on("click", "body", function () {
            $(".isoman-menu").hide();
        });

        $(document).on("click", ".close_pop", function (e) {
            e.preventDefault();
            const $form = $(this).closest(".frmPop");
            if ($form.find(".isInIframe").val() == 1) {
                window.close();
            } else {
                const id = $form.attr("id");
                $("#" + id).remove();
                $("#isoblanketpop_" + id).remove();
            }
            return false;
        });
    }

    /* ===============================
     * OPEN DIALOG
     * =============================== */
    bindDialog() {
        const self = this;

        $(document).on(
            "click",
            ".ajOpenDialog, .ajOpenDialogIframe",
            function () {
                let $_this = $(this),
                    isoman_for_id = $_this.attr("isoman_for_id"),
                    isoman_multiple = $_this.attr("isoman_multiple"),
                    isoman_callback = $_this.attr("isoman_callback"),
                    isInIframe = $_this.hasClass("ajOpenDialogIframe") ? 1 : 0;

                if (isInIframe) {
                    window.open(
                        "/admin/isomanager/",
                        "ISOMAN",
                        "width=860, height=620",
                    );
                } else {
                    let data = {
                        for_id: isoman_for_id,
                        isInIframe: isInIframe,
                        isoman_multiple: isoman_multiple,
                        isoman_callback: isoman_callback,
                    };

                    if ($("#OpenDialog").length == 0) {
                        self.loadOpenDialog(data);
                    }
                }
                return false;
            },
        );
    }

    /* ===============================
     * MENU / ACTION
     * =============================== */
    bindMenu() {
        $(document).on("click", ".isoman-menu-view", function (ev) {
            ev.preventDefault();
            let $_this = $(this);
            let $_form = $_this.closest(".frmPop");
            let $isoman_for_id = $_form.find(".isoman-current-for_id").val();
            let $_img = $(".isoman-checked")
                .attr("isoman_url")
                .replace(
                    $("#isoman-current-domain-" + $isoman_for_id).val(),
                    "",
                );
            let html =
                '<div class="headPop ui-draggable-handle" style="cursor: move;"> <a href="javascript:void();" class="closeEv close_pop"></a> <b>' +
                $_img +
                "</b> </div>";
            html += '<img src="' + $_img + '" style="max-width:800px;" />';

            $("#isoman-action-menu").hide();
            makepopupnotresize("auto", "auto", html, "ViewImage");
            return false;
        });

        $(document).on(
            "click",
            ".isoman-folder-create,.isoman-rename",
            function (ev) {
                ev.preventDefault();
                let $_this = $(this);
                let $_form = $_this.closest(".frmPop");
                let $isoman_for_id = $_form
                    .find(".isoman-current-for_id")
                    .val();
                let folder_name = "";
                let folder_name_dir = "";
                let isoman_type = "";
                if ($_this.hasClass("isoman-rename")) {
                    folder_name_dir = $(".isoman-checked").attr("isoman_dir");
                    isoman_type = $(".isoman-checked").attr("isoman_type");
                }
                let adata = {
                    for_id: $isoman_for_id,
                    abs_url: $(
                        "#isoman-current-abs_url-" + $isoman_for_id,
                    ).val(),
                    isoman_dir: $(
                        "#isoman-current-dir-" + $isoman_for_id,
                    ).val(),
                    isoman_url: $(
                        "#isoman-current-url-" + $isoman_for_id,
                    ).val(),
                    folder_name_dir: folder_name_dir,
                    isoman_type: isoman_type,
                };
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?act=isoman_load_one_folder",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        if (folder_name_dir == "") {
                            makepopupnotresize(
                                "auto",
                                "auto",
                                html,
                                "LoadCreateFolder",
                            );
                        } else {
                            makepopupnotresize(
                                "auto",
                                "auto",
                                html,
                                "LoadEditFolder",
                            );
                        }
                        $("#isoman_folder_name").focus();
                    },
                });
                return false;
            },
        );

        $(document).on("keyup", "#isoman_folder_name", function (ev) {
            if (ev.which == 13) {
                $(this)
                    .closest(".frmPop")
                    .find(".isoman-update-folder")
                    .click();
                return false;
            }
        });

        $(document).on("click", ".isoman-update-folder", function (ev) {
            ev.preventDefault();
            let $_this = $(this);
            let $_form = $_this.closest(".frmPop");

            let $title = $_form.find("#isoman_folder_name");
            if ($.trim($title.val()) == "") {
                $title.addClass("error").focus();
                alertify.error(field_required);
                return false;
            }

            let adata = {
                for_id: $_this.attr("isoman_for_id"),
                abs_url: $_this.attr("isoman_abs_url"),
                isoman_dir: $_this.attr("isoman_dir"),
                isoman_url: $_this.attr("isoman_url"),
                folder_name: $title.val(),
                isoman_dir_root: $_this.attr("isoman_dir_root"),
                isoman_root_name: $_this.attr("isoman_root_name"),
            };
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?act=isoman_update_one_folder",
                data: adata,
                dataType: "html",
                success: function (html) {
                    //console.log(html);
                    $("#isoman-reload-" + $_this.attr("isoman_for_id")).click();
                    $_form.find(".close_pop").click();
                },
            });
            return false;
        });

        $(document).on(
            "click",
            ".isoman-menu-cut,.isoman-menu-copy",
            function (ev) {
                ev.preventDefault();
                let $_this = $(this);
                let $action = "";
                if ($_this.hasClass("isoman-menu-cut")) {
                    $action = "cut";
                }
                if ($_this.hasClass("isoman-menu-copy")) {
                    $action = "copy";
                }
                $.cookie("isoman-action", $action);
                $.cookie("isoman-action-dir", isoman_selected_dirs());
                $.cookie(
                    "isoman-action-type",
                    $_this
                        .closest(".frmPop")
                        .find(".isoman-checked")
                        .attr("isoman_type"),
                );
                $(".isoman-menu-paste").show();
                $("#isoman-action").css("left", "277.78125px");
            },
        );

        $(document).on("click", ".isoman-menu-paste", function (ev) {
            ev.preventDefault();
            $paste_isoman_action = $.cookie("isoman-action");
            $paste_isoman_dir = $.cookie("isoman-action-dir");
            $isoman_paste_type = $.cookie("isoman-action-type");

            if ($paste_isoman_action == "" || $paste_isoman_dir == "")
                return false;

            let $_this = $(this);
            let $_form = $_this.closest(".frmPop");
            let $isoman_for_id = $_form.find(".isoman-current-for_id").val();
            let adata = {
                isoman_dir: $("#isoman-current-dir-" + $isoman_for_id).val(),
                paste_isoman_dir: $paste_isoman_dir,
                isoman_paste_type: $isoman_paste_type,
                isoman_paste_action: $paste_isoman_action,
            };
            $("#isoman-main-container-body").html(
                '<div class="isoman-throbber isoman-throbber-inline"></div>',
            );
            $.ajax({
                type: "POST",
                url: path_ajax_script + "/index.php?act=isoman_paste",
                data: adata,
                dataType: "html",
                success: function (html) {
                    //console.log(html);
                    $.cookie("isoman-action", "");
                    $.cookie("isoman-action-dir", "");
                    $_form.find(".isoman-i-refresh").click();
                },
            });
        });

        $(document).on("click", "#isoman-action", function (ev) {
            ev.preventDefault();
            let $_this = $(this);
            $("#isoman-action-menu").show();
            return false;
        });

        $(document).on("click", "#isoman-sort", function (ev) {
            ev.preventDefault();
            let $_this = $(this);
            $("#isoman-sort-menu").show();
            return false;
        });

        $(document).on("keydown", ".isoman-search", function (ev) {
            if (ev.which === 13) {
                ev.preventDefault();
                $(this).closest(".frmPop").find(".isoman-i-refresh").click();
            }
        });

        $(document).on(
            "click",
            ".isoman-i-refresh,.isoman-search-action",
            function (ev) {
                ev.preventDefault();
                let $_this = $(this);
                let $_form = $_this.closest(".frmPop");
                let $isoman_for_id = $_form
                    .find(".isoman-current-for_id")
                    .val();
                isoman_load_folder(
                    $isoman_for_id,
                    $("#isoman-current-typelist-" + $isoman_for_id).val(),
                    $("#isoman-current-dir-" + $isoman_for_id).val(),
                    $("#isoman-current-url-" + $isoman_for_id).val(),
                );
                return false;
            },
        );

        $(document).on("click", ".isoman-upload-file", function (ev) {
            ev.preventDefault();
            let $_this = $(this);
            let $_form = $_this.closest(".frmPop");
            let $isoman_for_id = $_form.find(".isoman-current-for_id").val();
            $("#isoman-upload-file-" + $isoman_for_id).click();
            return false;
        });

        $(document).on("change", ".isoman-upload-file-input", function (ev) {
            let $_this = $(this);
            let $_form = $_this.closest(".frmPop");
            let $isoman_for_id = $_form.find(".isoman-current-for_id").val();

            let isoman_dir = $("#isoman-current-dir-" + $isoman_for_id).val();
            makepopupnotresize(
                "auto",
                "auto",
                '<a class="close_pop"></a><p style="margin-top:-26px">Uploading... Please wait...</p>',
                "UploadingDialog",
            );
            //console.log('11');
            
            $_this.closest("form").ajaxSubmit({
                type: "POST",
                url: path_ajax_script + "/index.php?act=isoman_upload_file",
                success: function (html) {
                    //console.log(html);
                    var filePath = $.trim(html).replace(/\/+/g, "/");
                    $("#isoman-reload-" + $isoman_for_id)
                        .attr("cval", html)
                        .click();
                    if (html.indexOf("_NOT_VALID") >= 0) {
                        alert("This directory is not allow to upload!");
                    }
                    if (html.indexOf("_EXIST_FILE") >= 0) {
                        alert("This is file already exists!");
                    }

                    // đợi reload xong
                    setTimeout(function () {
                        var $img = $('.isoman-image').filter(function () {
                            
                            return $(this).attr("isoman_dir").replace(/\/+/g, "/") === filePath;
                        });

                        if ($img.length) {

                            // chọn
                            //$img.addClass("selected").trigger("click");
                            $img.find(".isoman-i-checkbox").trigger("click");
                            
                            // scroll
                             $(".isoman-thumbnailview").animate({
                                scrollTop: $(".isoman-thumbnailview").scrollTop() + $img.position().top - 20
                            }, 400);
                        }
                    }, 300);
                    $("#UploadingDialog").find(".close_pop").click();
                },
            });
        });

        $(document).on("click", ".isoman-menu-remove", function (ev) {
            ev.preventDefault();
            let $_this = $(this);
            let $_form = $_this.closest(".frmPop");
            let $isoman_for_id = $_form.find(".isoman-current-for_id").val();
            let $file_images = isoman_selected_dirs();
            $(".isoman-menu").hide();
            let adata = {
                isoman_for_id: $isoman_for_id,
                isoman_dir: $file_images,
            };
            $("#isoman-main-container-body").html(
                '<div class="isoman-throbber isoman-throbber-inline"></div>',
            );
            $.ajax({
                type: "POST",
                url: path_ajax_script + "/index.php?act=isoman_delete_dir",
                data: adata,
                dataType: "html",
                success: function (html) {
                    //console.log(html);
                    $_form.find(".isoman-i-refresh").click();
                    if (html.indexOf("_NOT_VALID") >= 0) {
                        alertify.error(delete_error);
                    }
                    if (html.indexOf("_NOT_VALID_WRITE") >= 0) {
                        alertify.error(delete_error);
                    }
                    if (html.indexOf("_NOT_EMPTY") >= 0) {
                        alertify.error(delete_error);
                    }
                    if (html.indexOf("_NO_PERMISSION") >= 0) {
                        alertify.error(delete_error);
                    }
                },
            });
            return false;
        });

        $(document).on("click", ".isoman-switch", function (ev) {
            ev.preventDefault();
            let $_this = $(this);
            let $_form = $_this.closest(".frmPop");
            let $isoman_for_id = $_form.find(".isoman-current-for_id").val();
            $("#isoman-current-typelist-" + $isoman_for_id).val(
                $_this.attr("typelist"),
            );
            $(".isoman-switch").removeClass("isoman-active");
            $_this.addClass("isoman-active");
            $_form.find(".isoman-i-refresh").click();
            return false;
        });

        $(document).on(
            "click",
            ".isoman-i-folder,.isoman-open-folder",
            function (ev) {
                ev.preventDefault();
                let $_this = $(this);
                let $_form = $_this.closest(".frmPop");
                let $isoman_for_id = $_form
                    .find(".isoman-current-for_id")
                    .val();

                isoman_load_folder(
                    $isoman_for_id,
                    $("#isoman-current-typelist-" + $isoman_for_id).val(),
                    $_this.attr("isoman_dir"),
                    $_this.attr("isoman_url"),
                );

                return false;
            },
        );

        $(document).on("click", ".isoman-i-checkbox", function (ev) {
            ev.preventDefault();
            let _this = $(this),
                $_form = _this.closest(".frmPop"),
                $isoman_for_id = $(".isoman-current-for_id", $_form).val(),
                $isoman_multiple = $(
                    ".isoman-current-multiple-" + $isoman_for_id,
                    $_form,
                ).val();

            if ($("#isoman-current-typelist-" + $isoman_for_id).val() == 1) {
                _this.closest(".isoman-grid-row").click();
            } else {
                let $_this = _this.closest(".isoman-image");
                if ($_this.hasClass("isoman-checked")) {
                    if (!$isoman_multiple || parseInt($isoman_multiple) == 0) {
                        $_this.removeClass("isoman-checked");
                        $("#isoman-action").hide();
                        $("#isoman-insert-" + $isoman_for_id)
                            .attr("isoman_url", "")
                            .hide();
                    } else {
                        $_this.removeClass("isoman-checked");
                        if (isoman_total_selected_files() == 0) {
                            $("#isoman-action").hide();
                            $("#isoman-insert-" + $isoman_for_id)
                                .attr("isoman_url", "")
                                .hide();
                        }
                    }
                } else {
                    if (
                        parseInt($isoman_multiple) == 0 ||
                        !$isoman_multiple ||
                        $isoman_multiple == undefined
                    ) {
                        $(".isoman-image").removeClass("isoman-checked");
                        $_this.addClass("isoman-checked");
                        $("#isoman-action").show();

                        if ($_this.attr("isoman_url") != "") {
                            $("#isoman-insert-" + $isoman_for_id)
                                .attr("isoman_url", $_this.attr("isoman_url"))
                                .show();
                            $(
                                "#isoman-menu-view-" + $isoman_for_id,
                            ).removeClass("isoman-disabled");
                        } else {
                            $("#isoman-insert-" + $isoman_for_id)
                                .attr("isoman_url", "")
                                .hide();
                            $("#isoman-menu-view-" + $isoman_for_id).addClass(
                                "isoman-disabled",
                            );
                        }
                    } else {
                        $_this.addClass("isoman-checked");
                        $("#isoman-action").show();
                        if ($_this.attr("isoman_url") != "") {
                            $("#isoman-insert-" + $isoman_for_id).show();
                            $(
                                "#isoman-menu-view-" + $isoman_for_id,
                            ).removeClass("isoman-disabled");
                        } else {
                            $("#isoman-insert-" + $isoman_for_id)
                                .attr("isoman_url", "")
                                .hide();
                            $("#isoman-menu-view-" + $isoman_for_id).addClass(
                                "isoman-disabled",
                            );
                        }
                    }
                }
            }
            //$("#isoman-action-menu").hide();
            return false;
        });

        $(document).on("click", ".isoman-grid-row", function (ev) {
            ev.preventDefault();
            let $_this = $(this);
            let $_form = $_this.closest(".frmPop");
            let $isoman_for_id = $_form.find(".isoman-current-for_id").val();

            if ($_this.hasClass("isoman-checked")) {
                $(".isoman-grid-row").removeClass("isoman-checked");
                $_this.removeClass("isoman-checked");
                $("#isoman-action").hide();
                $("#isoman-insert-" + $isoman_for_id)
                    .attr("isoman_url", "")
                    .hide();
            } else {
                $(".isoman-grid-row").removeClass("isoman-checked");
                $_this.addClass("isoman-checked");
                $("#isoman-action").show();
                if ($_this.attr("isoman_url") != "") {
                    $("#isoman-insert-" + $isoman_for_id)
                        .attr("isoman_url", $_this.attr("isoman_url"))
                        .show();
                    $("#isoman-menu-view-" + $isoman_for_id).removeClass(
                        "isoman-disabled",
                    );
                } else {
                    $("#isoman-insert-" + $isoman_for_id)
                        .attr("isoman_url", "")
                        .hide();
                    $("#isoman-menu-view-" + $isoman_for_id).addClass(
                        "isoman-disabled",
                    );
                }
            }
            $("#isoman-action-menu").hide();
            return false;
        });

        $(document).on("click", ".isoman-go-back", function (ev) {
            ev.preventDefault();
            let $_this = $(this);
            let $_form = $_this.closest(".frmPop");
            let $isoman_for_id = $_form.find(".isoman-current-for_id").val();
            isoman_load_folder(
                $isoman_for_id,
                $("#isoman-current-typelist-" + $isoman_for_id).val(),
                $_this.attr("isoman_dir"),
                $_this.attr("isoman_url"),
            );
            return false;
        });

        $(document).on("click", ".isoman-image", function (ev) {
            ev.preventDefault();
            ev.stopPropagation();

            $(this).find(".isoman-i-checkbox").trigger("click");

            return false;
        });

        $(document).on(
            "click",
            ".isoman-image-list,.isoman-insert",
            function (ev) {
                ev.preventDefault();
                let $_this = $(this),
                    $_form = $_this.closest(".frmPop"),
                    isparent = $_this.attr("data-isoman-isparent"),
                    $isoman_callback = $_this.attr("isoman_callback"),
                    $isoman_for_id = $(".isoman-current-for_id").val(),
                    isInIframe = $(
                        "#isoman-current-isInIframe-" + $isoman_for_id,
                    ).val(),
                    $isoman_multiple = $(
                        ".isoman-current-multiple-" + $isoman_for_id,
                    ).val();

                if (isparent == "parent" && !$_this.hasClass("isoman-insert")) {
                    isoman_load_folder(
                        $isoman_for_id,
                        $("#isoman-current-typelist-" + $isoman_for_id).val(),
                        $_this.attr("isoman_dir"),
                        $_this.attr("isoman_url"),
                    );
                } else {
                    let $_img = $_this
                        .attr("isoman_url")
                        .replace(
                            $("#isoman-current-domain-" + $isoman_for_id).val(),
                            "",
                        );
                    $_img = $_img.replace("http:///", "/");
                    $_img = $_img.replace("https:///", "/");

                    if (isInIframe == "1") {
                        window.opener
                            .$("#src")
                            .val($_img)
                            .focus()
                            .trigger("change");
                    } else {
                        if ($_this.hasClass("isoman-image")) {
                            if (!$isoman_multiple) {
                                if ($_this.hasClass("isoman-checked")) {
                                    $_this.removeClass("isoman-checked");
                                } else {
                                    $(".isoman-checked").removeClass(
                                        "isoman-checked",
                                    );
                                    $_this.addClass("isoman-checked");
                                }

                                if (isoman_total_selected_files() > 0) {
                                    $("#isoman-action").show();
                                    $("#isoman-insert-" + $isoman_for_id)
                                        .attr("isoman_url", "")
                                        .show();
                                } else {
                                    $("#isoman-action").hide();
                                    $("#isoman-insert-" + $isoman_for_id)
                                        .attr("isoman_url", "")
                                        .hide();
                                }
                            } else {
                                if ($_this.hasClass("isoman-checked")) {
                                    $_this.removeClass("isoman-checked");
                                } else {
                                    $_this.addClass("isoman-checked");
                                }
                                if (isoman_total_selected_files() > 0) {
                                    $("#isoman-action").show();
                                    $("#isoman-insert-" + $isoman_for_id)
                                        .attr("isoman_url", "")
                                        .show();
                                } else {
                                    $("#isoman-action").hide();
                                    $("#isoman-insert-" + $isoman_for_id)
                                        .attr("isoman_url", "")
                                        .hide();
                                }
                            }
                        }

                        if (
                            !$isoman_multiple ||
                            $isoman_multiple == undefined ||
                            parseInt($isoman_multiple) == 0
                        ) {
                            //console.log('123',$isoman_for_id, $_img);
                            
                            $("#" + $isoman_for_id).val($_img);
                            $("#isoman_url_" + $isoman_for_id).val($_img);
                            $("#isoman_hidden_" + $isoman_for_id).val($_img);
                            $("#isoman_show_" + $isoman_for_id).attr(
                                "src",
                                $_img,
                            );
                            $(".isoman_show_" + $isoman_for_id).attr(
                                "src",
                                $_img,
                            );
                        } else {
                          
                            if (typeof $isoman_callback !== "undefined") {
                                eval($isoman_callback);
                            } else if (typeof isoman_callback == "function") {
                                isoman_callback($isoman_for_id);
                                isoman_gallery_callback(options_gallery);
                            }
                        }
                    }
                    $_this.closest(".frmPop").find(".close_pop").click();
                }
                return false;
            },
        );

        $(document).on("click", ".isoman-open-path", function (ev) {
            ev.preventDefault();
            let $_this = $(this);
            let $_form = $_this.closest(".frmPop");
            let $isoman_for_id = $_form.find(".isoman-current-for_id").val();
            isoman_load_folder(
                $isoman_for_id,
                $("#isoman-current-typelist-" + $isoman_for_id).val(),
                $_this.attr("isoman-dir"),
                $_this.attr("isoman-url"),
            );
            return false;
        });

       $(document).on("click", ".isoman-pagination", function (ev) {
    ev.preventDefault();

    let $_this = $(this);
    let $_form = $_this.closest(".frmPop");
    let $isoman_for_id = $_form.find(".isoman-current-for_id").val();
    let $page = parseInt($_this.data("page"), 10) || 1;

    isoman_load_folder(
        $isoman_for_id,
        $("#isoman-current-typelist-" + $isoman_for_id).val(),
        $_this.attr("isoman-dir"),
        $_this.attr("isoman-url"),
        0,
        $page,
        true,
    );

    return false;
});
    }

    /* ===============================
     * EVENT AJAX
     * =============================== */
    loadOpenDialog(data) {
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?act=isoman_load_open_dialog",
            data: data,
            dataType: "html",
            success: function (html) {
                makepopupnotresize("auto", "auto", html, "OpenDialog");

                $("#OpenDialog").css("top", "40px");

                if (
                    $.cookie("isoman_last_dir") == "" ||
                    $.cookie("isoman_last_url") == ""
                ) {
                    isoman_load_folder(
                        data.isoman_for_id,
                        $(
                            "#isoman-current-typelist-" + data.isoman_for_id,
                        ).val(),
                        $("#isoman-current-dir-" + data.isoman_for_id).val(),
                        $("#isoman-current-url-" + data.isoman_for_id).val(),
                    );
                } else {
                    isoman_load_folder(
                        data.isoman_for_id,
                        $(
                            "#isoman-current-typelist-" + data.isoman_for_id,
                        ).val(),
                        $.cookie("isoman_last_dir"),
                        $.cookie("isoman_last_url"),
                    );
                }
            },
        });
    }
}

function isoman_load_folder(
    isoman_for_id,
    isoman_typelist,
    isoman_dir,
    isoman_url,
    isoman_multiple,
    isoman_page = 1,
    scroll = false,
) {
    let isoman_abs_url = $("#isoman-current-abs_url-" + isoman_for_id).val();
    $("#isoman-current-dir-" + isoman_for_id).val(isoman_dir);
    $("#isoman-current-url-" + isoman_for_id).val(isoman_url);
    $("#isoman-current-typelist-" + isoman_for_id).val(isoman_typelist);
    $("#isoman-main-container-body").html(
        '<div class="isoman-throbber isoman-throbber-inline"></div>',
    );
    if (isoman_typelist == 0) {
        $("#isoman-main-container-body")
            .removeClass("isoman-abs-layout")
            .addClass("isoman-flow-layout")
            .css("top", "32px");
    } else {
        $("#isoman-main-container-body")
            .removeClass("isoman-flow-layout")
            .addClass("isoman-abs-layout")
            .css("top", "0");
    }
    let cval = $("#isoman-reload-" + isoman_for_id).attr("cval");
    let adata = {
        isoman_for_id: isoman_for_id,
        isoman_dir: isoman_dir,
        isoman_url: isoman_url,
        isoman_abs_url: isoman_abs_url,
        isoman_typelist: isoman_typelist,
        isoman_search: $("#isoman-search-" + isoman_for_id).val(),
        isoman_multiple: isoman_multiple,
        cval: cval,
        page: isoman_page,
    };
    $.cookie("isoman_last_dir", isoman_dir);
    $.cookie("isoman_last_url", isoman_url);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/index.php?act=isoman_load_open_folder",
        data: adata,
        dataType: "html",
        success: function (html) {
            // let htm = html.split("|||");
            $(".isoman_container_body").html(html);
            // $("#isoman-main-container-body").html(htm[0]);
            // $("#isoman-path").html(htm[1]);
            $(".isoman-image").each(function () {
                if ($(this).attr("isoman_dir") == cval) {
                    $(this).find(".isoman-i-checkbox").click();
                }
            });

            if (scroll) {
                let container = $("#isoman-main-container");
                let target = $("#iso_man_images");

                if (target.length) {
                    let scrollPos =
                        target.offset().top -
                        container.offset().top +
                        container.scrollTop();

                    container.animate({ scrollTop: scrollPos }, 300);
                }
            }
        },
    });
    if (
        $.cookie("isoman-action") != "" &&
        $.cookie("isoman-action-dir") != ""
    ) {
        $(".isoman-menu-paste").show();
        $("#isoman-action").css("left", "277.78125px");
    } else {
        $(".isoman-menu-paste").hide();
        $("#isoman-action").css("left", "196.078125px");
    }
    if (!$(".isoman-checked").length) {
        $("#isoman-action").hide();
    }
}

function isoman_total_selected_files() {
    let $total_files = 0;
    $(".isoman-image.isoman-checked,.isoman-grid-row.isoman-checked").each(
        function (_i, _elem) {
            if ($(_elem).hasClass("isoman-checked")) {
                $total_files++;
            }
        },
    );
    return $total_files;
}

function isoman_selected_files() {
    let $str = [];
    $(".isoman-image.isoman-checked,.isoman-grid-row.isoman-checked").each(
        function (_i, _elem) {
            if ($(_elem).hasClass("isoman-checked")) {
                $str.push($(_elem).attr("isoman_url"));
            }
        },
    );
    return $str.join("|");
}

function isoman_selected_dirs() {
    let $str = [];
    $(".isoman-image.isoman-checked,.isoman-grid-row.isoman-checked").each(
        function (_i, _elem) {
            if ($(_elem).hasClass("isoman-checked")) {
                $str.push($(_elem).attr("isoman_dir"));
            }
        },
    );
    return $str.join("|");
}

function getmaxzindex() {
    let maxindex = 0;
    $("div").each(function () {
        let zindex = parseInt($(this).css("z-index"));
        if (zindex > maxindex) maxindex = zindex;
    });
    return maxindex;
}

function makepopupnotresize(width, height, content, name) {
    let isInIframe = $(".isInIframe").val();
    if (isInIframe == 1) {
        if ($("#" + name).length > 0) {
        } else {
            $('<div id="isoblanketpop_' + name + '">')
                .css({
                    position: "fixed",
                    top: 0,
                    left: 0,
                    height: $(document).height(),
                    width: "100%",
                    opacity: 0.3,

                    backgroundColor: "black",
                })
                .appendTo(document.body)
                .addClass("stacked");
            $('<div id="' + name + '" class="frmPop">')
                .appendTo(document.body)
                .html(content);
            $("#" + name)
                .css("position", "fixed")
                .css("width", width)
                .css("height", height)
                .css("left", "20px")
                .css("top", "20px")
                .addClass("stacked")
                .show()
                .find(".required:first")
                .focus();
        }
        $(document).on("keydown", $("#" + name).find("input"), function (e) {
            if (e.keyCode == 13) {
                $(this).closest(".frmPop").find(".submitClick").click();
                return false;
            }
            if (e.keyCode == 27) {
                $(this).closest(".frmPop").find(".close_pop").click();
                return false;
            }
        });
    } else {
        if ($("#" + name).length > 0) {
        } else {
            $('<div id="isoblanketpop_' + name + '">')
                .css({
                    position: "fixed",
                    top: 0,
                    left: 0,
                    height: $(document).height(),
                    width: "100%",
                    opacity: 0.3,
                    backgroundColor: "black",
                })
                .appendTo(document.body)
                .addClass("stacked");
            $('<div id="' + name + '" class="frmPop">')
                .appendTo(document.body)
                .html(content);
            $("#" + name)
                .css("position", "fixed")
                .css("width", width)
                .css("height", height)
                .css(
                    "left",
                    ($(window).width() - $("#" + name).width()) / 2 + "px",
                )
                .css(
                    "top",
                    ($(window).height() - $("#" + name).height()) / 2 -
                        20 +
                        "px",
                )
                .addClass("stacked")
                .show()
                .find(".required:first")
                .focus();
        }
        $(document).on("keydown", $("#" + name).find("input"), function (e) {
            if (e.keyCode == 13) {
                $(this).closest(".frmPop").find(".submitClick").click();
                return false;
            }
            if (e.keyCode == 27) {
                $(this).closest(".frmPop").find(".close_pop").click();
                return false;
            }
        });
        $("#" + name)
            .draggable({
                containment: "body",
                cancel: ".form",
                handle: ".headPop",
            })
            .find(".headPop")
            .css("cursor", "move");
    }
}

$(function () {
    $(function () {
        window.IsoManager = new IsoManager();
    });
});
