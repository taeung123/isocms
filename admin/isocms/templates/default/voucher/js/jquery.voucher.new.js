$().ready(function () {
    $_document.on("click", ".toggle_opt .online_tour", function () {
        var $_this = $(this);
        var is_online = $_this.data("val");
        var text_last = $_this.data("text_last");
        var text = $_this.text();
        var adata = {};
        adata["clsTable"] = $_this.data("clstable");
        adata["pkey"] = $_this.data("pkey");
        adata["pvalTable"] = $_this.data("sourse_id");
        adata["toField"] =
            $_this.attr("toField") != undefined
                ? $_this.attr("toField")
                : "is_online";
        adata["val"] = parseInt(is_online) == 0 ? 1 : 0;
        adata["allowDuplicate"] = 1;

        $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=home&act=saveField",
            data: adata,
            dataType: "html",
            success: function (html) {
                var val = is_online == 1 ? 0 : 1;
                if ($_this.hasClass("private_tour")) {
                    $_this.removeClass("private_tour");
                } else {
                    $_this.addClass("private_tour");
                }
                $_this.text(text_last);
                $_this.data({ val: html, text_last: text });
            },
        });
    });

    $_document.on("keyup", ".input-title", function () {
        var $_this = $(this),
            table_id = $_this.data("table_id"),
            _title = $_this.val();
        $(".table-title[table_id=" + table_id + "]").html(_title);
        return false;
    });
    $_document.on("keyup", ".input_code", function () {
        var $_this = $(this),
            table_id = $_this.data("table_id"),
            _trip_code = $_this.val();
        $(".table_code[table_id=" + table_id + "]").html(_trip_code);
        return false;
    });
    $_document.on("click", ".panel-edited > .panel-heading", function (e) {
        e.preventDefault();
        $(".panel-heading").find("a").addClass("collapsed");
        $(this).find("a").removeClass("collapsed");
        $(".panel-edited > .panel-heading").removeClass("current");
        $(".panel-edited > .panel-collapse").removeClass("show");
        $(this).toggleClass("current");
        var panel = $(this).closest(".panel");
        panel.find(".panel-collapse").addClass("show");
        panel
            .find(
                ".panel-collapse>.panel-body>ul.stepbar-list>li:first-child>.loadYieldStep"
            )
            .trigger("click");
    });
    $_document.on("click", ".loadYieldStep", function () {
        var $_this = $(this),
            href = $_this.data("route"),
            table_id = $_this.data("table_id"),
            currentstep = $_this.data("step");
        $(".stepbar-list>li>a.active").removeClass("active");
        $_this.addClass("active");
        loadMainFormStep(table_id, currentstep);
        $("html,body").animate({ scrollTop: 0 }, 500);
        window.history.pushState({ href: href }, "", href);
        return false;
    });
    $_document.on("click", ".js_save_continue,.js_save_back", function () {

        var $_this = $(this),
            $_form = $('#' + $_this.attr('form')),
            table_id = $_this.data("table_id"),
            currentstep = $_this.data("currentstep"),
            nextstep = $_this.data("next_step");
        var options = {};
        if (currentstep == "generalinformation") {
            var title = $('input[name="title"]').val();
            var check = true;
            if (title != "") {
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=" +
                        mod +
                        "&act=checkTitleVoucher",
                    data: { table_id: table_id, title: title },
                    dataType: "json",
                    async: false,
                    success: function (json) {
                        if (!json.result) {
                            alertify.error("Title exist");
                            $('input[name="title"]').addClass("error");
                            check = false;
                        } else {
                            $('input[name="title"]').removeClass("error");
                        }
                    },
                });
            }
            if (!check) {
                console.log("Validation failed: title is empty or already exists.");
                return false;
            }

        }
        if ($_this.hasClass("js_save_back")) {
            nextstep = $_this.data("prevstep");
        }
        
        // if ($(".textarea_intro_editor[table_id=" + table_id + "]").length) {
        //     $(".textarea_intro_editor[table_id=" + table_id + "]").each(
        //         function () {
        //             var column = $(this).data("column"),
        //                 editorId = $(this).attr("id");
        //             options[column] = $Core.util.getTextAreaContent(editorId);
        //         }
        //     );
        // }
        if (typeof tinymce !== "undefined") {
            tinymce.triggerSave();
        }
        var _validated = 0;
        var $firstError = null;

        $_form.find(':input.required, :input[required]').each(function () {
            var $field = $(this);
            var value = "";
            var $error;

            // Xóa message cũ
            $field.siblings(".required-error").remove();

            // TinyMCE
            if ($field.hasClass("textarea_intro_editor")) {
                var editor = tinymce.get($field.attr("id"));

                if (editor) {
                    value = $("<div>")
                        .html(editor.getContent())
                        .text()
                        .replace(/\u00a0/g, " ")
                        .trim();
                } else {
                    value = $.trim($field.val());
                }

            // Checkbox / radio
            } else if ($field.is(":checkbox, :radio")) {
                value = $field.is(":checked") ? $field.val() : "";

            // Input / select / textarea
            } else {
                value = $.trim($field.val());
            }

            if (!value) {
                _validated++;

                $field.addClass("error");

                // Tạo message
                $error = $('<div class="required-error"></div>')
                    .text("This field is required.");

                // Nếu TinyMCE thì đặt message sau editor
                if ($field.hasClass("textarea_intro_editor")) {
                    $field.next(".tox-tinymce").after($error);
                } else {
                    $field.after($error);
                }

                if (!$firstError) {
                    $firstError = $field;
                }

            } else {
                $field.removeClass("error");
            }
        });

        // Có lỗi
        if (_validated > 0) {

            if ($firstError) {
                $firstError.focus();
            }

            Swal.fire({
                icon: "warning",
                title: "Missing information",
                text: "Please fill in all required fields.",
                confirmButtonText: "OK"
            });

            return false;
        }
        // $.each($_form.serializeArray(), function () {
        //     if (options[this.name] !== undefined) {
        //         // Trường hợp input name="xxx[]" có nhiều giá trị
        //         if (!Array.isArray(options[this.name])) {
        //             options[this.name] = [options[this.name]];
        //         }
        //         options[this.name].push(this.value);
        //     } else {
        //         options[this.name] = this.value;
        //     }
        // });
        if (parseInt(_validated) == 0) {
            //next step menu
            $(".stepbar-list>li>a.active").removeClass("active");
            // $(".loadYieldStep[data-step=" + nextstep + "]").addClass("active");
            var currentpanel = $_this.data("panel"),
                nextpanel = $(".stepbar-list>li>a.active").attr("panel"),
                $_href = $(".stepbar-list>li>a.active").data("route");
            if (currentpanel != nextpanel) {
                $(".panel--" + currentpanel)
                    .find(".panel-heading a")
                    .addClass("collapsed");
                $(".panel--" + currentpanel)
                    .find(".panel-collapse")
                    .removeClass("show");
                $(".panel--" + nextpanel)
                    .find(".panel-heading a")
                    .removeClass("collapsed");
                $(".panel--" + nextpanel)
                    .find(".panel-collapse")
                    .addClass("show");
            }

            //save data
            $Core.util.toggleIndicatior(0);
            //console.log(options); return;
            
            $_form.ajaxSubmit({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSaveMainStep",
                data: {
                    table_id: table_id,
                    currentstep: currentstep
                },
                dataType: "html",
                success: function (html) {
                    $Core.util.toggleIndicatior(0);
                    //console.log(html);
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Save changes successfully!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    // if (nextstep !== "_last" && nextstep !== "_first") {
                    //     loadMainFormStep(table_id, nextstep);
                    // } else if (nextstep == "_last") {
                    //     // loadMainFormStep(table_id, "generalinformation");
                    // }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error Save!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
            console.log("Updating browser history with href: ", $_href);
            // window.history.pushState({ href: $_href }, "", $_href);
            return false;
        }
    });
    if (mod == "voucher" && act == "insert") {
        if ($SiteActive_region == "1") {
            loadRegion(country_id, region_id);
        }

        /* HOTEL_CUSTOM_FIELD */
        $(document).on("click", ".ClickCustomField", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=SiteVoucherCustomField",
                data: { table_id: table_id, tp: "C" },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    location.href = REQUEST_URI;
                },
            });
            return false;
        });
        $(".changeToStore").live("change", function () {
            var $_this = $(this);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajUpdateVoucherStore",
                data: {
                    _type: $_this.attr("_type"),
                    table_id: $_this.attr("data"),
                    val: $_this.is(":checked") ? 1 : 0,
                },
                dataType: "html",
                success: function (html) {},
            });
        });
        $(document).on("click", ".btndelete_customfield", function (ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=SiteVoucherCustomField",
                    data: {
                        voucher_customfield_id: $_this.attr("data"),
                        tp: "D",
                    },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        location.href = REQUEST_URI;
                    },
                });
            }
            return false;
        });
        $(document).on("click", ".btnedit_customfield", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteVoucherCustomField",
                data: {
                    tp: "F",
                    voucher_customfield_id: $_this.attr("data"),
                    table_id: $_this.attr("table_id"),
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopup(300, "auto", html, "pop_UpdateFieldName");
                },
            });
            return false;
        });
        $(document).on("click", ".SiteClickUpdateFieldName", function (ev) {
            var $_this = $(this);
            var $_form = $_this.closest(".frmPop");
            var $fieldname = $_form.find("input[name=fieldname]");
            if ($fieldname.val() == "") {
                $fieldname.focus();
                alertiy.error(field_is_required);
                return false;
            }
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteVoucherCustomField",
                data: {
                    tp: "S",
                    voucher_customfield_id: $_this.attr(
                        "voucher_customfield_id"
                    ),
                    table_id: $_this.attr("table_id"),
                    fieldname: $fieldname.val(),
                },
                dataType: "html",
                success: function (html) {
                    if (html.indexOf("_EXIST") >= 0) {
                        alertify.error("Error !");
                    } else {
                        $_form.find(".close_pop").trigger("click");
                    }
                    location.href = REQUEST_URI;
                },
            });
            return false;
        });
        $(document).on("click", ".btnmove_customfield", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteVoucherCustomField",
                data: {
                    tp: "M",
                    table_id: $_this.attr("table_id"),
                    direct: $_this.attr("direct"),
                    voucher_customfield_id: $_this.attr("data"),
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                },
            });
            return false;
        });

        $(document).on("change", "#slb_Chauluc", function (ev) {
            var $_this = $(this);
            if (parseInt($_this.val()) > 0) {
                loadCountry($_this.val());
            } else {
                $("select[name=country_id]")
                    .html('<option value="0">' + country + "/option>")
                    .hide();
                $("select[name=region_id]")
                    .html('<option value="0">' + regions + "</option>")
                    .hide();
                $("select[name=city_id]")
                    .html('<option value="0">' + cities + "</option>")
                    .hide();
            }
        });
        $(document).on("change", "#slb_Country", function (ev) {
            var $_this = $(this);
            if (parseInt($_this.val()) > 0) {
                if ($SiteActive_region == "1") {
                    loadRegion($_this.val());
                    $("#slb_city_Id_Container").hide();
                } else {
                    loadCity($_this.val());
                }
            } else {
                $("#slb_RegionID").hide();
                $("#slb_city_Id_Container").hide();
            }
        });
        $(document).on("change", "#slb_RegionID", function (ev) {
            var $_this = $(this);
            if ($SiteModActive_country == "1") {
                var $country_id = $("#slb_Country").val();
                if ($country_id == undefined) {
                    $country_id = $("#Hid_Country").val();
                }
                loadCity($country_id, $_this.val());
            } else {
                loadCity(0, $_this.val());
            }
        });
        loadCity(country_id, region_id, city_id);
        /* FUNC */
        $(document).on(
            "change",
            "select[name=iso-continent_id]",
            function (ev) {
                var $_this = $(this);
                var title = $_this.find("option:selected").attr("title");
                $("#slb_Country").html(
                    '<option value="0">' + loading + "</option>"
                );
                $("#slb_Area").html(
                    '<option value="0">-- ' + regions + " --</option>"
                );
                $("#slb_City").html(
                    '<option value="0">-- ' + cities + " --</option>"
                );
                loadCountry($_this.val(), 0);
            }
        );
        $(document).on("change", "select[name=iso-area_id]", function (ev) {
            var $_this = $(this);
            var title = $_this.find("option:selected").attr("title");
            var $country_id = $("select[name=iso-country_id]").val();
            if ($country_id == "undefined" || $country_id == undefined) {
                $country_id = 0;
            }
            loadCity($country_id, $_this.val(), 0);
        });
        $(document).on("change", "select[name=iso-country_id]", function (ev) {
            var $_this = $(this);
            var title = $_this.find("option:selected").attr("title");
            if ($SiteActive_region == "1") {
                loadRegion($_this.val(), 0);
            }
            loadCity($_this.val(), 0, 0);
        });
        $(document).on("change", "select[name=iso-region_id]", function (ev) {
            var $_this = $(this);
            var $country_id = $("select[name=iso-country_id]").val();
            if ($country_id == undefined) {
                $country_id = 0;
            }
            loadCity($country_id, $_this.val(), 0);
        });
        /* START HOTEL_PROPERY_POP */
        $(document).on("click", ".ajaxManagerVoucherProperty", function (ev) {
            var $_this = $(this);
            var adata = {
                type: $_this.attr("_type"),
                fromid: $_this.attr("fromid"),
                forid: $_this.attr("forid"),
                tp: "L",
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajGetBoxManagerVoucherProperty",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("30%", "", html, "frmBoxManagerVoucherProperty");
                },
            });
            return false;
        });
        $(document).on("click", "#btnCreateNewVoucherProperty", function (ev) {
            var $_this = $(this);
            var adata = {
                type: $_this.attr("type"),
                fromid: $_this.attr("fromid"),
                forid: $_this.attr("forid"),
                tp: "F",
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajGetBoxManagerVoucherProperty",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);

                    makepopup("25%", "", html, "pop_FrmProperty");
                },
            });
        });
        $(document).on("click", ".edit_pop_voucher_property", function (ev) {
            var $_this = $(this);
            if (!$_this.hasClass("disabled")) {
                var adata = {
                    voucher_property_id: $_this.attr("data"),
                    fromid: $_this.attr("fromid"),
                    forid: $_this.attr("forid"),
                    tp: "F",
                };
                $_this.addClass("disabled");
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=voucher&act=ajGetBoxManagerVoucherProperty",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        $_this.removeClass("disabled");
                        makepopup("20%", "", html, "pop_FrmProperty");
                    },
                });
            }
            return false;
        });
        $(document).on("click", "#ajaxSaveVoucherProperty", function (ev) {
            var $_this = $(this);
            if (!$_this.hasClass("disabled")) {
                var $_form = $_this.closest(".frmPop");

                var $title = $_form.find("input[name=title]");
                var $fromid = $_this.attr("fromid");
                var $forid = $_this.attr("forid");

                if ($title.val() == "") {
                    $title.addClass("error").focus();
                    return false;
                }
                var adata = {
                    voucher_property_id: $_this.attr("voucher_property_id"),
                    type: $_this.attr("_type"),
                    title: $title.val(),
                    tp: "S",
                };
                vietiso_loading(1);
                $_this.addClass("disabled");
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=voucher&act=ajGetBoxManagerVoucherProperty",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        $_this.removeClass("disabled");
                        vietiso_loading(0);
                        if (html.indexOf("IN_SUCCESS") >= 0) {
                            $_form.find(".close_pop").trigger("click");
                            alertify.success(insert_success);
                            loadTableVoucherProperty(
                                $_this.attr("_type"),
                                $fromid,
                                $forid
                            );
                            if ($fromid == "pop_VoucherRoom") {
                                loadSelectBoxRoomFacility(
                                    $_this.attr("property_id"),
                                    $forid
                                );
                            }
                            if ($fromid == "VoucherFacilities") {
                                loadVoucherFacibility($forid);
                            }
                            if ($fromid == "VoucherRating") {
                                loadSelectBoxVoucherRating(
                                    $_this.attr("_type"),
                                    $forid
                                );
                            }
                        }
                        if (html.indexOf("UP_SUCCESS") >= 0) {
                            loadTableVoucherProperty(
                                $_this.attr("_type"),
                                $fromid,
                                $forid
                            );
                            $_form.find(".close_pop").trigger("click");
                            alertify.success(update_success);

                            if ($fromid == "pop_VoucherRoom") {
                                loadSelectBoxRoomFacility(
                                    $_this.attr("property_id"),
                                    $forid
                                );
                            }
                            if ($fromid == "VoucherFacilities") {
                                loadVoucherFacibility($forid);
                            }
                            if ($fromid == "VoucherRating") {
                                loadSelectBoxVoucherRating(
                                    $_this.attr("_type"),
                                    $forid
                                );
                            }
                        }
                        if (html.indexOf("ERROR") >= 0) {
                            alertify.error(error);
                        }
                        if (html.indexOf("EXIST") >= 0) {
                            alertify.error(exist_error);
                        }
                    },
                });
            }
            return false;
        });
        $(document).on("click", ".delete_pop_voucher_property", function (ev) {
            var $_this = $(this);
            if (!$_this.hasClass("disabled")) {
                var $fromid = $_this.attr("fromid");
                var $forid = $_this.attr("forid");
                /**/
                if (confirm(confirm_delete)) {
                    var adata = {
                        voucher_property_id: $_this.attr("data"),
                        tp: "D",
                    };
                    vietiso_loading(1);
                    $_this.addClass("disabled");
                    $.ajax({
                        type: "POST",
                        url:
                            path_ajax_script +
                            "/?mod=voucher&act=ajGetBoxManagerVoucherProperty",
                        data: adata,
                        dataType: "html",
                        success: function (html) {
                            $_this.removeClass("disabled");
                            vietiso_loading(0);
                            loadTableVoucherProperty(
                                $_this.attr("_type"),
                                $_this.attr("fromid"),
                                $_this.attr("forid")
                            );
                            if ($fromid == "pop_VoucherRoom") {
                                loadSelectBoxRoomFacility(
                                    $_this.attr("voucher_property_id"),
                                    $forid
                                );
                            }
                            if ($fromid == "VoucherFacilities") {
                                loadVoucherFacibility($forid);
                            }
                            if ($fromid == "VoucherRating") {
                                loadSelectBoxVoucherRating(
                                    $_this.attr("_type"),
                                    $forid
                                );
                            }
                        },
                    });
                }
            }
            return false;
        });
        /* END HOTEL_PROPERY_POP */

        /* START HOTEL ROOM */
        $(document).on("click", "#clickToAddVoucherRoom", function (ev) {
            var $_this = $(this);
            var adata = {};
            adata["table_id"] = table_id;
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajaxAddVoucherRoom",
                dataType: "html",
                data: adata,
                success: function (html) {
                    makepopup(
                        "991px",
                        "auto",
                        html,
                        "pop_VoucherRoom",
                        "frmPop2"
                    );
                    $("#pop_VoucherRoom").css("top", "30px");
                    $(".price_format").priceFormat({
                        thousandsSeparator: ".",
                        centsLimit: 0,
                    });
                    vietiso_loading(0);
                },
            });
            return false;
        });
        $(document).on("click", ".clickEditVoucherRoom", function (ev) {
            var $_this = $(this);
            var adata = {
                voucher_room_id: $_this.attr("data"),
                table_id: $_this.attr("voucher_id"),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajaxAddVoucherRoom",
                dataType: "html",
                data: adata,
                success: function (html) {
                    makepopup(
                        "991px",
                        "auto",
                        html,
                        "pop_VoucherRoom",
                        "frmPop2"
                    );
                    $("#pop_VoucherRoom").css("top", "30px");
                    $(".price_format").priceFormat({
                        thousandsSeparator: ".",
                        centsLimit: 0,
                    });
                    vietiso_loading(0);
                },
            });
            return false;
        });
        $(document).on("click", ".clickEditVoucherRoom_", function (ev) {
            var $_this = $(this);
            var adata = {
                voucher_room_id: $_this.attr("data"),
                voucher_id: $_this.attr("voucher_id"),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajaxAddVoucherRoom",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopupnotresize("60%", "auto", html, "pop_VoucherRoom");
                    $("#pop_VoucherRoom").css("top", 60 + "px");
                    var editor_id = $(".textarea_content_editor").attr("id");
                    $("#" + editor_id).isoTextAreaFull();
                    $("#" + editor_id + "_ifr").height(120);
                    $(".selectbox").chosen({
                        max_selected_options: 100,
                        width: "100%",
                    });
                    $(".price").priceFormat({
                        thousandsSeparator: ".",
                        centsLimit: 0,
                    });
                },
            });
        });
        $(document).on("click", ".deleteVoucherRoomImage", function (ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                var adata = { voucher_room_id: $_this.attr("voucher_room_id") };
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=voucher&act=ajDeleteVoucherRoomImage",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        $("#isoman_show_image_room").attr("src", "");
                        $("#isoman_hidden_image_room").val("");
                        loadVoucherRoom();
                    },
                });
            }
            return false;
        });
        $(document).on("click", "#clickSubmitVoucherRoom", function (ev) {
            var $_this = $(this);
            if (!$_this.hasClass("disabled")) {
                var $title = $("input[name=voucher_room_title]").val();
                var $content = tinyMCE
                    .get($(".textarea_content_editor").attr("id"))
                    .getContent();
                var $image = $("#isoman_hidden_image_room").val();
                if ($title == "") {
                    alertify.error(field_is_required);
                    $("input[name=voucher_room_title]")
                        .addClass("error")
                        .focus();
                    return false;
                }
                var adata = {
                    voucher_room_id: $_this.attr("voucher_room_id"),
                    table_id: $_this.attr("table_id"),
                    intro: $content,
                    image: $image,
                };
                vietiso_loading(1);
                $_this.addClass("disabled");
                $("#frmVoucherRoom").ajaxSubmit({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=voucher&act=ajaxSubmitVoucherRoom",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        $_this.removeClass("disabled");
                        if (html.indexOf("_IN_SUCCESS") >= 0) {
                            loadVoucherRoom();
                            loadVoucherPrice();
                            alertify.success(insert_success);
                            $_this
                                .closest(".frmPop")
                                .find(".close_pop")
                                .trigger("click");
                        }
                        if (html.indexOf("_UPDATE_SUCCESS") >= 0) {
                            loadVoucherRoom();
                            loadVoucherPrice();
                            alertify.success(update_success);
                            $_this
                                .closest(".frmPop")
                                .find(".close_pop")
                                .trigger("click");
                        }
                        if (html.indexOf("_ERROR") >= 0) {
                            alertify.error(exist_error);
                        }
                        if (html.indexOf("_EXIST") >= 0) {
                            alertify.error(exist_error);
                        }
                    },
                });
            }
            return false;
        });
        $(document).on("click", ".clickDeleteVoucherRoom", function (ev) {
            var $_this = $(this);
            if (confirm(confirm_delete)) {
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=voucher&act=ajDeleteVoucherRoom",
                    data: { voucher_room_id: $_this.attr("data") },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadVoucherRoom();
                        loadVoucherPrice();
                        alertify.success(delete_success);
                    },
                });
            }
            return false;
        });

        $("#add_voucher_room").live("click", function (ev) {
            var _this = $(this);
            if ($("#room_stype_id").val() == 0) {
                $("#room_stype_id").focus();
                alertify.error(field_is_required);
                return false;
            }
            if ($("#title_room").val() == "") {
                $("#title_room").focus();
                alertify.error(field_is_required);
                return false;
            }
            if ($("#number_val").val() == "") {
                $("#number_val").focus();
                alertify.error(field_is_required);
                return false;
            }
            if ($("#footage").val() == "") {
                $("#footage").focus();
                alertify.error(field_is_required);
                return false;
            }
            if ($("#price").val() == "") {
                $("#price").focus();
                alertify.error(field_is_required);
                return false;
            }
            var adata = $("#form_add_voucher_room").serialize();
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSaveVoucherRoom",
                data: adata,
                dataType: "html",
                success: function (html) {
                    if (html.indexOf("INSERT_ERROR") >= 0) {
                        alertify.error(insert_error);
                    } else if (html.indexOf("UPDATE_ERROR") >= 0) {
                        alertify.error(update_error);
                    } else if (html.indexOf("UPDATE_SUCCESS") >= 0) {
                        alertify.success(update_success);
                        vietiso_loading(0);
                    } else {
                        alertify.success(insert_success);
                        vietiso_loading(0);
                    }
                },
            });
        });

        $(document).on("click", ".ajmoveVoucherRoom", function (ev) {
            var $_this = $(this);
            var adata = {
                voucher_room_id: $_this.attr("data"),
                table_id: $_this.attr("table_id"),
                direct: $_this.attr("direct"),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajMoveVoucherRoom",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadVoucherRoom();
                },
            });
            return false;
        });

        // Add Voucher Price Col
        $(document).on("click", "#addVoucherPriceRow", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajLoadNewVoucherPriceRow",
                dataType: "html",
                data: { table_id: pvalTable },
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("300", "", html, "NewVoucherPriceRow");
                },
            });
            return false;
        });
        $(document).on("click", "#addVoucherPriceCol", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajLoadNewVoucherPriceCol",
                dataType: "html",
                data: { table_id: pvalTable },
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("300", "", html, "NewVoucherPriceCol");
                },
            });
            return false;
        });
        $(document).on("click", ".editVoucherPriceRoom", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajLoadEditVoucherPriceRoom",
                dataType: "html",
                data: { id: $_this.attr("data") },
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("300", "", html, "EditVoucherPriceRow");
                },
            });
            return false;
        });
        $(document).on("click", ".editVoucherPriceCol", function (ev) {
            var $_this = $(this);
            var adata = { table_id: pvalTable };
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajCheckVoucherPriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    if (html == 0) {
                        $("#addVoucherPriceCol").trigger("click");
                    } else {
                        vietiso_loading(1);
                        $.ajax({
                            type: "POST",
                            url:
                                path_ajax_script +
                                "/index.php?mod=voucher&act=ajLoadEditVoucherPriceCol",
                            dataType: "html",
                            data: { id: $_this.attr("data") },
                            success: function (html) {
                                vietiso_loading(0);
                                makepopup(
                                    "300",
                                    "",
                                    html,
                                    "EditVoucherPriceCol"
                                );
                            },
                        });
                    }
                },
            });
            return false;
        });
        $(document).on("click", ".editVoucherPriceVal", function (ev) {
            var $_this = $(this);
            var adata = { table_id: pvalTable };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajCheckVoucherPriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    if (html == 0) {
                        alertify.error(error);
                        $("#addVoucherPriceCol").trigger("click");
                    } else {
                        $.ajax({
                            type: "POST",
                            url:
                                path_ajax_script +
                                "/index.php?mod=voucher&act=ajLoadEditVoucherPriceVal",
                            dataType: "html",
                            data: {
                                voucher_price_col_id: $_this.attr(
                                    "voucher_price_col_id"
                                ),
                                voucher_price_row_id: $_this.attr(
                                    "voucher_price_row_id"
                                ),
                            },
                            success: function (html) {
                                makepopup(
                                    "20%",
                                    "",
                                    html,
                                    "EditVoucherPriceVal"
                                );
                                $("#titleVal").priceFormat({
                                    thousandsSeparator: ".",
                                    centsLimit: 0,
                                });
                            },
                        });
                    }
                },
            });
            return false;
        });
        $(document).on("click", ".ajCopyPriceVoucher", function (ev) {
            $("input[name=price_avg]").val();
            return false;
        });
        $(document).on("change", "input[class=ajvClk]", function (ev) {
            var $_this = $(this);
            var adata = {
                tp: $_this.attr("tp"),
                tp_order: $_this.attr("tp_order"),
                table_id: $_this.attr("data"),
                val: $_this.is(":checked") ? 1 : 0,
            };
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajUpdateVoucherVr3",
                data: adata,
                dataType: "html",
                success: function (html) {},
            });
        });
        $(document).on("click", "#clickToAddVoucherPriceRow", function (ev) {
            var $_this = $(this);
            if ($("#titleRow").val() == "") {
                $("#titleRow").focus().addClass("error");
                alertify.error(title_required);
                return false;
            }
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajAddVoucherPriceRow",
                data: {
                    table_id: $_this.attr("table_id"),
                    title: $("#titleRow").val(),
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    if (html.indexOf("_EXIST") >= 0) {
                        alertify.error(insert_error);
                    }
                    if (html.indexOf("_ERROR") >= 0) {
                        alertify.error(insert_error_exist);
                    }
                    if (html.indexOf("_SUCCESS") >= 0) {
                        loadVoucherPrice();
                        loadVoucherRoom();
                        alertify.success(insert_success);
                        $_this
                            .closest(".frmPop")
                            .find(".close_pop")
                            .trigger("click");
                    }
                },
            });
            return false;
        });
        $(document).on("click", "#clickToAddVoucherPriceCol", function (ev) {
            var $_this = $(this);
            if ($("#titleCol").val() == "") {
                $("#titleCol").focus().addClass("error");
                alertify.error(field_required);
                return false;
            }
            var adata = {
                table_id: $_this.attr("table_id"),
                title: $("#titleCol").val(),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajAddVoucherPriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    if (html.indexOf("_IN_SUCCESS") >= 0) {
                        vietiso_loading(0);
                        loadVoucherPrice();
                        alertify.success(insert_success);
                        $_this
                            .closest(".frmPop")
                            .find(".close_pop")
                            .trigger("click");
                    }
                },
            });
            return false;
        });
        $(document).on("click", "#clickToEditVoucherPriceRow", function (ev) {
            var $_this = $(this);
            var adata = {
                id: $_this.attr("data"),
                title: $("#titleRow").val(),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajUpdateVoucherPriceRow",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadVoucherPrice();
                    loadVoucherRoom();
                    $_this
                        .closest(".frmPop")
                        .find(".close_pop")
                        .trigger("click");
                },
            });
            return false;
        });
        $(document).on("click", "#clickToEditVoucherPriceCol", function (ev) {
            var $_this = $(this);
            if ($("#titleCol").val() == "") {
                $("#titleCol").focus().addClass("error");
                alertify.error(title_required);
                return false;
            }
            var adata = {
                id: $_this.attr("data"),
                title: $("#titleCol").val(),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajUpdateVoucherPriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadVoucherPrice();
                    $_this
                        .closest(".frmPop")
                        .find(".close_pop")
                        .trigger("click");
                },
            });
            return false;
        });
        
        $(document).on("click", ".deleteVoucherPriceRoom", function (ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=voucher&act=ajDeleteVoucherPriceRoom",
                    data: { id: $_this.attr("data") },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadVoucherPrice();
                        loadVoucherRoom();
                    },
                });
            }
            return false;
        });
        $(document).on("click", ".deleteVoucherPriceCol", function (ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=voucher&act=ajDeleteVoucherPriceCol",
                    data: { id: $_this.attr("data") },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadVoucherPrice();
                    },
                });
            }
            return false;
        });
        $(document).on("click", "#clickToEditVoucherPriceVal", function (ev) {
            var $_this = $(this);
            var adata = {
                table_id: pvalTable,
                voucher_price_col_id: $_this.attr("voucher_price_col_id"),
                voucher_price_row_id: $_this.attr("voucher_price_row_id"),
                price: $("#titleVal").val(),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajUpdateVoucherPriceVal",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadVoucherPrice();
                    $_this
                        .closest(".frmPop")
                        .find(".close_pop")
                        .trigger("click");
                },
            });
            return false;
        });
        $(document).on("click", ".moveVoucherPriceRoom", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            var adata = {
                id: $_this.attr("data"),
                direct: $_this.attr("direct"),
            };
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajMoveVoucherPriceRow",
                data: adata,
                dataType: "html",
                success: function (html) {
                    loadVoucherPrice();
                    vietiso_loading(0);
                },
            });
            return false;
        });
        $(document).on("click", ".moveVoucherPriceCol", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            var adata = {
                id: $_this.attr("data"),
                direct: $_this.attr("direct"),
            };
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=voucher&act=ajMoveVoucherPriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadVoucherPrice();
                },
            });
            return false;
        });

        //LOAD SELECT BOX
        $("select[name=iso-city_id]").change(function () {
            var $_this = $(this);
            var country = $("select[name=iso-country_id]")
                .find("option:selected")
                .attr("title");
            var city = $_this.find("option:selected").attr("title");
            var address = city + " ," + country;
        });
    }
});

function showAjaxAlert(type, message) {
    var $alert = $('#ajaxAlert');

    $alert
        .removeClass('d-none alert-success alert-danger alert-warning alert-info')
        .addClass('alert-' + type)
        .html(message);

    setTimeout(function () {
        $alert.addClass('d-none');
    }, 3000);
}

function loadMainFormStep(table_id, currentstep) {
    $Core.util.toggleIndicatior(1);
    var $_adata = { table_id: table_id, currentstep: currentstep };
    $.post(
        path_ajax_script + "/index.php?mod=" + mod + "&act=getMainFormStep",
        $_adata,
        function (html) {
            $Core.util.toggleIndicatior(0);
            $("#" + "frmMainStep_" + table_id).html(html);
        }
    );
}
function parentDropdownToggle(e) {
    $(e).parent().toggleClass("open");
}
function checkAll(e) {
    var chkitem = $(e).closest(".fill_data_box").find(".chkitem");
    if ($(e).is(":checked")) {
        chkitem.attr("checked", true);
        chkitem.closest("tr").addClass("hightlight");
        setList();
    } else {
        chkitem.removeAttr("checked");
        chkitem.closest("tr").removeClass("hightlight");
        setList();
    }
}

function showDatepicker(e) {
    $(e).datepicker({ dateFormat: "dd/mm/yy" });
}

function searchRelateTour(e, type) {
    if ($(e).val() != "") {
        clearTimeout(aj_search);
        search_extension(type);
    } else {
        $("#autosuggetTour").stop(false, true).slideUp();
    }
}
function addRelateTour(e) {
    var $_this = $(e);
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajAddTourExtension",
        data: {
            voucher_id: voucher_id,
            tour_id: $_this.attr("data"),
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("_SUCCESS") >= 0) {
                $_this.remove();
                loadTourExtension(voucher_id);
            }
            if (html.indexOf("_EXIST") >= 0) {
                alertify.error(exist_error);
            }
        },
    });
}

function addRelateHotel(e) {
    var $_this = $(e);
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajAddHotelExtension",
        data: {
            voucher_id: voucher_id,
            hotel_id: $_this.attr("data"),
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("_SUCCESS") >= 0) {
                $_this.remove();
                loadHotelExtension(voucher_id);
            }
            if (html.indexOf("_EXIST") >= 0) {
                alertify.error(exist_error);
            }
        },
    });
}
function addRelateCruise(e) {
    var $_this = $(e);
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajAddCruiseExtension",
        data: {
            voucher_id: voucher_id,
            cruise_id: $_this.attr("data"),
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("_SUCCESS") >= 0) {
                $_this.remove();
                loadCruiseExtension(voucher_id);
            }
            if (html.indexOf("_EXIST") >= 0) {
                alertify.error(exist_error);
            }
        },
    });
}

function deleteVoucherExtension(e) {
    if (confirm(confirm_delete)) {
        var _this = $(e);
        var tp = _this.attr("tp");
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajDeleteVoucherExtension",
            data: {
                voucher_extension_id: _this.attr("data"),
            },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                if (tp == "tour") loadTourExtension(voucher_id);
                if (tp == "cruise") loadCruiseExtension(voucher_id);
                if (tp == "hotel") loadHotelExtension(voucher_id);
            },
        });
        return false;
    }
}

function moveTourExtension(e) {
    var _this = $(e);
    vietiso_loading(1);
    var adata = {
        voucher_extension_id: _this.attr("data"),
        voucher_id: voucher_id,
        direct: _this.attr("direct"),
    };
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajMoveTourExtension",
        data: adata,
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            loadTourExtension(voucher_id);
        },
    });
}
function moveHotelExtension(e) {
    var _this = $(e);
    vietiso_loading(1);
    var adata = {
        voucher_extension_id: _this.attr("data"),
        voucher_id: voucher_id,
        direct: _this.attr("direct"),
    };
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajmoveHotelExtension",
        data: adata,
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            loadHotelExtension(voucher_id);
        },
    });
}
function moveCruiseExtension(e) {
    var _this = $(e);
    vietiso_loading(1);
    var adata = {
        voucher_extension_id: _this.attr("data"),
        voucher_id: voucher_id,
        direct: _this.attr("direct"),
    };
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajmoveCruiseExtension",
        data: adata,
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            loadCruiseExtension(voucher_id);
        },
    });
}

function addDestination(e) {
    var $_this = $(e);
    if ($SiteModActive_continent == "1") {
        var $chauluc_id = $("#slb_Chauluc").val();
    }
    if ($SiteModActive_country == "1") {
        var $country_id = $("#slb_Country").val();
        if ($country_id != undefined || $country_id == 0) {
            var $countryID = $("#slb_Country");
            setSelectOpen($countryID);
        } else {
            $country_id = 1;
        }
    }
    if ($SiteActive_region == "1") {
        var $region_id = $("#slb_RegionID").val();
    }
    if ($SiteActive_city == "1") {
        var $city_id = $("#slb_CityID").val();
    }

    /**/
    var adata = {};
    adata["chauluc_id"] = $chauluc_id;
    adata["country_id"] = $country_id;
    adata["region_id"] = $region_id;
    adata["city_id"] = $city_id;
    adata["voucher_id"] = $voucher_id;

    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/?mod=" +
            mod +
            "&act=ajaxAddMoreVoucherDestination",
        data: adata,
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("_SUCCESS") >= 0) {
                setSelectBoxDestination();
                loadListDestination($voucher_id);
            }
            if (html.indexOf("_EXIST") >= 0) {
                alertify.error(exist_error);
            }
        },
    });
    return 0;
}

function removeDestination(e) {
    var $_this = $(e);
    if (confirm(confirm_delete)) {
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/?mod=" +
                mod +
                "&act=ajaxDeleteVoucherDestination",
            data: { voucher_destination_id: $_this.attr("data") },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                var $country_id = $("#slb_Country").val();
                if ($country_id == undefined) {
                    $country_id = $("#Hid_Country").val();
                }
                if ($("#slb_CityID").is(":visible")) {
                    loadCity($country_id, $("#slb_RegionID").val());
                }
                loadListDestination($voucher_id);
            },
        });
        return false;
    }
}
function removeAllDestination(e) {
    var $_this = $(e);
    if (confirm(confirm_delete)) {
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/?mod=" +
                mod +
                "&act=ajaxDeleteAllVoucherDestination",
            data: { voucher_id: voucher_id },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                var $country_id = $("#slb_Country").val();
                if ($country_id == undefined) {
                    $country_id = $("#Hid_Country").val();
                }
                if ($("#slb_CityID").is(":visible")) {
                    loadCity($country_id, $("#slb_RegionID").val());
                }
                loadListDestination(voucher_id);
            },
        });
        return false;
    }
}
