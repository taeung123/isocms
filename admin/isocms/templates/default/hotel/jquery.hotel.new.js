$().ready(function () {
    $_document.on("click", ".toggle_opt .online_tour", function () {
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajCheckPublicHotel",
            data: { is_online: $(this).data("val"), hotel_id: table_id },
            dataType: "json",
            success: function (json) {
                console.log(json);
                if (json.result == "_SUCCESS") {
                    alertify.success("exist_success_hotel_status");
                    window.location.reload(true);
                }
                if (json["result"] == "_ERR") {
                    alertify.error(exist_error);
                }
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
            currentstep = $_this.data("step"),
            step_id = $_this.data("step_id");

        $(".stepbar-list>li>a.active").removeClass("active");
        $_this.addClass("active");
        loadMainFormStep(table_id, currentstep, "", null, step_id);
        $("html,body").animate({ scrollTop: 0 }, 500);
        window.history.pushState({ href: href }, "", href);
        return false;
    });
    $_document.on("click", ".js_save_continue,.js_save_back", function () {
        var $_this = $(this),
            $_form = $_this.closest("form"),
            table_id = $_this.data("table_id"),
            currentstep = $_this.data("currentstep"),
            nextstep = $_this.data("next_step");
        if ($_this.hasClass("js_save_back")) {
            nextstep = $_this.data("prevstep");
        }
        if(nextstep == "_last"){
            nextstep = "name";
        }
        var options = {};
        if ($(".textarea_intro_editor[table_id=" + table_id + "]").length) {
            $(".textarea_intro_editor[table_id=" + table_id + "]").each(
                function () {
                    var column = $(this).data("column"),
                        editorId = $(this).attr("id");
                    options[column] = $Core.util.getTextAreaContent(editorId);
                }
            );
        }

        if (currentstep == "itinerary") {
            loadMainFormStep(table_id, nextstep);
            var $_bdata = { table_id: table_id, currentstep: currentstep };
            $.post(
                path_ajax_script + "/index.php?mod=" + mod + "&act=check_step",
                $_bdata,
                function (html) {
                    if (html == 1) {
                        $(".loadYieldStep[step=" + currentstep + "]").addClass(
                            "success"
                        );
                    } else {
                        $(
                            ".loadYieldStep[step=" + currentstep + "]"
                        ).removeClass("success");
                    }
                }
            );
        } else {
            var _validated = 0;
            if (
                $("input.required,select.required,textarea.required", $_form)
                    .length
            ) {
                $(
                    "input.required,select.required,textarea.required",
                    $_form
                ).each(function () {
                    if ($Core.util.isEmpty($(this).val())) {
                        _validated++;
                        $(this).focus();
                        $(this).addClass("error");
                        return false;
                    } else {
                        $(this).removeClass("error");
                    }
                });
            }
            if (currentstep == "duration") {
                var number_day = $("input[name=number_day]").val(),
                    number_night = $("input[name=number_night]").val();
                if ($Core.util.isEmpty(number_day)) number_day = 0;
                if ($Core.util.isEmpty(number_night)) number_night = 0;
                number_day = parseInt(number_day);
                number_night = parseInt(number_night);
                if (number_day > number_night) {
                    if (number_day - number_night > 1) {
                        $Core.alert.alert(
                            __["Message"],
                            "Số ngày không hợp lệ"
                        );
                        return false;
                    }
                } else if (number_day < number_night) {
                    if (number_night - number_day > 1) {
                        $Core.alert.alert(__["Message"], "Số đêm không hợp lệ");
                        return false;
                    }
                }
            } else if (currentstep == "name") {
                if ($("input.required,select.required", $_form).length) {
                    $("input.required,select.required", $_form).each(
                        function () {
                            if ($Core.util.isEmpty($(this).val())) {
                                _validated++;
                                $(this).focus();
                                $(this).addClass("error");
                                return false;
                            } else {
                                $(this).removeClass("error");
                            }
                        }
                    );
                }
                var title = $('input[name="title"]').val();
                var check = true;
                if (title != "") {
                    $.ajax({
                        type: "POST",
                        url:
                            path_ajax_script +
                            "/?mod=" +
                            mod +
                            "&act=checkExistTitle",
                        data: { table_id: table_id, title: title },
                        dataType: "json",
                        async: false,
                        success: function (json) {
                            if (!json.result && json.type == "title") {
                                alertify.error(json.message);
                                $('input[name="title"]').addClass("error");
                                check = false;
                            } else {
                                $('input[name="title"]').removeClass("error");
                            }
                        },
                    });
                }
                if (!check) {
                    return false;
                }

                /***/

                if ($("input[name=table_code]").length > 0) {
                    var table_code = $("input[name=table_code]").val();
                    $.ajax({
                        type: "POST",
                        async: false,
                        data: { table_code: table_code, table_id: table_id },
                        url:
                            path_ajax_script +
                            "/index.php?mod=" +
                            mod +
                            "&act=check_table_code",
                        success: function (html) {
                            if (html.indexOf("_invalid") >= 0) {
                                _validated = 1;
                                $("input[name=table_code]").focus();
                                $Core.alert.alert(
                                    __["Message"],
                                    "Mã code này đã tồn tại"
                                );
                            }
                        },
                    });
                }
            } else if (currentstep == "age") {
            }
            if (parseInt(_validated) == 0) {
                $(".stepbar-list>li>a.active").removeClass("active");
                $(".loadYieldStep[data-step=" + nextstep + "]").addClass(
                    "active"
                );
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
                $Core.util.toggleIndicatior(0);

                $_form.ajaxSubmit({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=ajSaveMainStep",
                    data: $.extend(options, {
                        table_id: table_id,
                        currentstep: currentstep,
                    }),
                    dataType: "html",
                    success: function (html) {
                        $Core.util.toggleIndicatior(0);
                        if (nextstep !== "_last" && nextstep !== "_first") {
                            loadMainFormStep(table_id, nextstep);
                        } else if (nextstep == "_last") {
                            loadMainFormStep(table_id, "name");
                        }
                        if (currentstep == "image") {
                            let url_image = $("#image").val();
                            $(".isoman_show_image").attr("src", url_image);
                        }
                    },
                });
                console.log("pushState", $_href);
                window.history.pushState({ href: $_href }, "", $_href);
                return false;
            }
        }
    });
    if (mod == "hotel" && act == "insert") {
        if ($SiteActive_region == "1") {
            loadRegion(country_id, region_id);
        }

        /* HOTEL_CUSTOM_FIELD */
        loadCustomField(table_id);
        $(document).on("click", ".ClickCustomField", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=SiteHotelCustomField",
                data: { table_id: table_id, tp: "C" },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    location.href = REQUEST_URI;
                },
            });
            return false;
        });
        $(".changeToStore").on("change", function () {
            var $_this = $(this);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajUpdateHotelStore",
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
                        "&act=SiteHotelCustomField",
                    data: {
                        hotel_customfield_id: $_this.attr("data"),
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
                    "&act=SiteHotelCustomField",
                data: {
                    tp: "F",
                    hotel_customfield_id: $_this.attr("data"),
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
                    "&act=SiteHotelCustomField",
                data: {
                    tp: "S",
                    hotel_customfield_id: $_this.attr("hotel_customfield_id"),
                    table_id: $_this.attr("table_id"),
                    fieldname: $fieldname.val(),
                },
                dataType: "html",
                success: function (html) {
                    if (html.indexOf("_EXIST") >= 0) {
                        alertify.error("Error !");
                    } else {
                        loadCustomField($_this.attr("table_id"));
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
                    "&act=SiteHotelCustomField",
                data: {
                    tp: "M",
                    table_id: $_this.attr("table_id"),
                    direct: $_this.attr("direct"),
                    hotel_customfield_id: $_this.attr("data"),
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadCustomField($_this.attr("table_id"));
                },
            });
            return false;
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
        $(document).on("click", ".ajaxManagerHotelProperty", function (ev) {
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
                    "/index.php?mod=hotel&act=ajGetBoxManagerHotelProperty",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("30%", "", html, "frmBoxManagerHotelProperty");
                },
            });
            return false;
        });
        $(document).on("click", "#btnCreateNewHotelProperty", function (ev) {
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
                    "/index.php?mod=hotel&act=ajGetBoxManagerHotelProperty",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("25%", "", html, "pop_FrmProperty");
                },
            });
        });
        $(document).on("click", ".edit_pop_hotel_property", function (ev) {
            var $_this = $(this);
            if (!$_this.hasClass("disabled")) {
                var adata = {
                    hotel_property_id: $_this.attr("data"),
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
                        "/?mod=hotel&act=ajGetBoxManagerHotelProperty",
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
        $(document).on("click", "#ajaxSaveHotelProperty", function (ev) {
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
                    hotel_property_id: $_this.attr("hotel_property_id"),
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
                        "/index.php?mod=hotel&act=ajGetBoxManagerHotelProperty",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        $_this.removeClass("disabled");
                        vietiso_loading(0);
                        if (html.indexOf("IN_SUCCESS") >= 0) {
                            $_form.find(".close_pop").trigger("click");
                            alertify.success(insert_success);
                            loadTableHotelProperty(
                                $_this.attr("_type"),
                                $fromid,
                                $forid
                            );
                            if ($fromid == "pop_HotelRoom") {
                                loadSelectBoxRoomFacility(
                                    $_this.attr("property_id"),
                                    $forid
                                );
                            }
                            if ($fromid == "HotelFacilities") {
                                loadHotelFacibility($forid);
                            }
                            if ($fromid == "HotelRating") {
                                loadSelectBoxHotelRating(
                                    $_this.attr("_type"),
                                    $forid
                                );
                            }
                        }
                        if (html.indexOf("UP_SUCCESS") >= 0) {
                            loadTableHotelProperty(
                                $_this.attr("_type"),
                                $fromid,
                                $forid
                            );
                            $_form.find(".close_pop").trigger("click");
                            alertify.success(update_success);

                            if ($fromid == "pop_HotelRoom") {
                                loadSelectBoxRoomFacility(
                                    $_this.attr("property_id"),
                                    $forid
                                );
                            }
                            if ($fromid == "HotelFacilities") {
                                loadHotelFacibility($forid);
                            }
                            if ($fromid == "HotelRating") {
                                loadSelectBoxHotelRating(
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
        $(document).on("click", ".delete_pop_hotel_property", function (ev) {
            var $_this = $(this);
            if (!$_this.hasClass("disabled")) {
                var $fromid = $_this.attr("fromid");
                var $forid = $_this.attr("forid");
                /**/
                if (confirm(confirm_delete)) {
                    var adata = {
                        hotel_property_id: $_this.attr("data"),
                        tp: "D",
                    };
                    vietiso_loading(1);
                    $_this.addClass("disabled");
                    $.ajax({
                        type: "POST",
                        url:
                            path_ajax_script +
                            "/?mod=hotel&act=ajGetBoxManagerHotelProperty",
                        data: adata,
                        dataType: "html",
                        success: function (html) {
                            $_this.removeClass("disabled");
                            vietiso_loading(0);
                            loadTableHotelProperty(
                                $_this.attr("_type"),
                                $_this.attr("fromid"),
                                $_this.attr("forid")
                            );
                            if ($fromid == "pop_HotelRoom") {
                                loadSelectBoxRoomFacility(
                                    $_this.attr("hotel_property_id"),
                                    $forid
                                );
                            }
                            if ($fromid == "HotelFacilities") {
                                loadHotelFacibility($forid);
                            }
                            if ($fromid == "HotelRating") {
                                loadSelectBoxHotelRating(
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
        $(document).on("click", "#clickAddHotelRoom", function (ev) {
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
                    "&act=ajaxAddHotelRoom",
                dataType: "html",
                data: adata,
                success: function (html) {
                    makepopup(
                        "991px",
                        "auto",
                        html,
                        "pop_HotelRoom",
                        "frmPop2"
                    );
                    $("#pop_HotelRoom").css("top", "100px");
                    $(".price_format").priceFormat({
                        thousandsSeparator: ".",
                        centsLimit: 0,
                    });
                    vietiso_loading(0);
                },
            });
            return false;
        });
        // $(document).on("click", ".clickEditHotelRoom", function (ev) {
        //     var $_this = $(this);
        //     let table_id = $_this.attr("hotel_id");
        //     var adata = {
        //         hotel_room_id: $_this.attr("data"),
        //         table_id: $_this.attr("hotel_id"),
        //         currentstep: "edit_room",
        //     };
        //     loadMainFormStep(table_id, "edit_room", "", adata);
        //     return false;
        // });

        $(document).on("click", ".clickEditHotelRoom", function (ev) {
            var $_this = $(this);
            var adata = {
                hotel_room_id: $_this.attr("data"),
                hotel_id: $_this.attr("hotel_id"),
                tp:'EDIT'
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=hotel&act=ajaxAddHotelRoom",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopup(
                        "991px",
                        "auto",
                        html,
                        "pop_HotelRoom",
                        "frmPop2"
                    );
                    $("#pop_HotelRoom").css("top", 60 + "px");
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
        $(document).on("click", ".deleteHotelRoomImage", function (ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                var adata = { hotel_room_id: $_this.attr("hotel_room_id") };
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=hotel&act=ajDeleteHotelRoomImage",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        $("#isoman_show_image_room").attr("src", "");
                        $("#isoman_hidden_image_room").val("");
                        loadHotelRoom();
                    },
                });
            }
            return false;
        });
        $(document).on("click", "#clickSubmitHotelRoom", function (ev) {
            var $_this = $(this);
            if (!$_this.hasClass("disabled")) {
                var $title = $("input[name=hotel_room_title]").val();
                var $content = tinyMCE
                    .get($(".textarea_content_editor").attr("id"))
                    .getContent();
                var $image = $("#isoman_hidden_image_room").val();
                if ($title == "") {
                    alertify.error(field_is_required);
                    $("input[name=hotel_room_title]").addClass("error").focus();
                    return false;
                }
                var adata = {
                    hotel_room_id: $_this.attr("hotel_room_id"),
                    table_id: $_this.attr("table_id"),
                    intro: $content,
                    image: $image,
                };
                vietiso_loading(1);
                $_this.addClass("disabled");
                $("#frmHotelRoom").ajaxSubmit({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=hotel&act=ajaxSubmitHotelRoom",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        $_this.removeClass("disabled");
                        if (html.indexOf("_IN_SUCCESS") >= 0) {
                            loadHotelRoom();
                            loadHotelPrice();
                            alertify.success(insert_success);
                            $_this
                                .closest(".frmPop")
                                .find(".close_pop")
                                .trigger("click");
                        }
                        if (html.indexOf("_UPDATE_SUCCESS") >= 0) {
                            loadHotelRoom();
                            loadHotelPrice();
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
        $(document).on("click", ".clickDeleteHotelRoom", function (ev) {
            var $_this = $(this);
            if (confirm(confirm_delete)) {
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=hotel&act=ajDeleteHotelRoom",
                    data: { hotel_room_id: $_this.attr("data") },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadHotelRoom();
                        loadHotelPrice();
                        alertify.success(delete_success);
                    },
                });
            }
            return false;
        });

        $("#add_hotel_room").live("click", function (ev) {
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
            var room_stype_id = $('select[name="room_stype_id"]').val();
            var hotel_room_id = $('input[name="hotel_room_id"]').val();
            var hotel_id = $('input[name="hotel_id"]').val();
            var title_room = $("#title_room").val();
            var check = true;
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajCheckTitleHotelRoom",
                data: {
                    hotel_id: hotel_id,
                    table_id: hotel_room_id,
                    title_room: title_room,
                    room_stype_id: room_stype_id,
                },
                dataType: "json",
                async: false,
                success: function (json) {
                    if (!json.result) {
                        alertify.error(errorExistRoomName);
                        $("#title_room").focus();
                        check = false;
                    }
                },
            });
            if (!check) {
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
            if ($("#price").val() == "" || $("#price").val() == 0) {
                $("#price").focus();
                alertify.error(field_is_required);
                return false;
            }

            var adata = $(".form_add_hotel_room").serializeArray();
            var img = $("#holder_gallery .preview-img").first().attr("src") || "";
            adata.push({
                name: "img",
                value: img
            });
            console.log(adata);
            // return false;
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSaveHotelRoom",
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
                        loadHotelRoom();
                        $("#pop_HotelRoom").find(".closeEv").trigger("click");
                    } else {
                        alertify.success(insert_success);
                        vietiso_loading(0);
                        loadHotelRoom();
                        $("#pop_HotelRoom").find(".closeEv").trigger("click");
                    }
                },
            });
        });

        $(document).on("click", ".ajmoveHotelRoom", function (ev) {
            var $_this = $(this);
            var adata = {
                hotel_room_id: $_this.attr("data"),
                table_id: $_this.attr("table_id"),
                direct: $_this.attr("direct"),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=hotel&act=ajMoveHotelRoom",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadHotelRoom();
                },
            });
            return false;
        });

        // Add Hotel Price Col
        $(document).on("click", "#addHotelPriceRow", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=hotel&act=ajLoadNewHotelPriceRow",
                dataType: "html",
                data: { table_id: pvalTable },
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("300", "", html, "NewHotelPriceRow");
                },
            });
            return false;
        });
        $(document).on("click", "#addHotelPriceCol", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=hotel&act=ajLoadNewHotelPriceCol",
                dataType: "html",
                data: { table_id: pvalTable },
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("300", "", html, "NewHotelPriceCol");
                },
            });
            return false;
        });
        $(document).on("click", ".editHotelPriceRoom", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=hotel&act=ajLoadEditHotelPriceRoom",
                dataType: "html",
                data: { id: $_this.attr("data") },
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("300", "", html, "EditHotelPriceRow");
                },
            });
            return false;
        });
        $(document).on("click", ".editHotelPriceCol", function (ev) {
            var $_this = $(this);
            var adata = { table_id: pvalTable };
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=hotel&act=ajCheckHotelPriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    if (html == 0) {
                        $("#addHotelPriceCol").trigger("click");
                    } else {
                        vietiso_loading(1);
                        $.ajax({
                            type: "POST",
                            url:
                                path_ajax_script +
                                "/index.php?mod=hotel&act=ajLoadEditHotelPriceCol",
                            dataType: "html",
                            data: { id: $_this.attr("data") },
                            success: function (html) {
                                vietiso_loading(0);
                                makepopup("300", "", html, "EditHotelPriceCol");
                            },
                        });
                    }
                },
            });
            return false;
        });
        $(document).on("click", ".editHotelPriceVal", function (ev) {
            var $_this = $(this);
            var adata = { table_id: pvalTable };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=hotel&act=ajCheckHotelPriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    if (html == 0) {
                        alertify.error(error);
                        $("#addHotelPriceCol").trigger("click");
                    } else {
                        $.ajax({
                            type: "POST",
                            url:
                                path_ajax_script +
                                "/index.php?mod=hotel&act=ajLoadEditHotelPriceVal",
                            dataType: "html",
                            data: {
                                hotel_price_col_id:
                                    $_this.attr("hotel_price_col_id"),
                                hotel_price_row_id:
                                    $_this.attr("hotel_price_row_id"),
                            },
                            success: function (html) {
                                makepopup("20%", "", html, "EditHotelPriceVal");
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
        $(document).on("click", ".ajCopyPriceHotel", function (ev) {
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
                    "/index.php?mod=hotel&act=ajUpdateHotelVr3",
                data: adata,
                dataType: "html",
                success: function (html) {},
            });
        });
        $(document).on("click", "#clickToAddHotelPriceRow", function (ev) {
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
                    "/index.php?mod=hotel&act=ajAddHotelPriceRow",
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
                        loadHotelPrice();
                        loadHotelRoom();
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
        $(document).on("click", "#clickToAddHotelPriceCol", function (ev) {
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
                    "/index.php?mod=hotel&act=ajAddHotelPriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    if (html.indexOf("_IN_SUCCESS") >= 0) {
                        vietiso_loading(0);
                        loadHotelPrice();
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
        $(document).on("click", "#clickToEditHotelPriceRow", function (ev) {
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
                    "/index.php?mod=hotel&act=ajUpdateHotelPriceRow",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadHotelPrice();
                    loadHotelRoom();
                    $_this
                        .closest(".frmPop")
                        .find(".close_pop")
                        .trigger("click");
                },
            });
            return false;
        });
        $(document).on("click", "#clickToEditHotelPriceCol", function (ev) {
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
                    "/index.php?mod=hotel&act=ajUpdateHotelPriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadHotelPrice();
                    $_this
                        .closest(".frmPop")
                        .find(".close_pop")
                        .trigger("click");
                },
            });
            return false;
        });
        $(document).on("click", ".deleteHotelPriceRoom", function (ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=hotel&act=ajDeleteHotelPriceRoom",
                    data: { id: $_this.attr("data") },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadHotelPrice();
                        loadHotelRoom();
                    },
                });
            }
            return false;
        });
        $(document).on("click", ".deleteHotelPriceCol", function (ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=hotel&act=ajDeleteHotelPriceCol",
                    data: { id: $_this.attr("data") },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadHotelPrice();
                    },
                });
            }
            return false;
        });
        $(document).on("click", "#clickToEditHotelPriceVal", function (ev) {
            var $_this = $(this);
            var adata = {
                table_id: pvalTable,
                hotel_price_col_id: $_this.attr("hotel_price_col_id"),
                hotel_price_row_id: $_this.attr("hotel_price_row_id"),
                price: $("#titleVal").val(),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=hotel&act=ajUpdateHotelPriceVal",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadHotelPrice();
                    $_this
                        .closest(".frmPop")
                        .find(".close_pop")
                        .trigger("click");
                },
            });
            return false;
        });
        $(document).on("click", ".moveHotelPriceRoom", function (ev) {
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
                    "/index.php?mod=hotel&act=ajMoveHotelPriceRow",
                data: adata,
                dataType: "html",
                success: function (html) {
                    loadHotelPrice();
                    vietiso_loading(0);
                },
            });
            return false;
        });
        $(document).on("click", ".moveHotelPriceCol", function (ev) {
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
                    "/index.php?mod=hotel&act=ajMoveHotelPriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadHotelPrice();
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

function loadMainFormStep(
    table_id = 0,
    currentstep = "",
    nextstep = "",
    data = null,
    step_id = 0
) {
    $Core.util.toggleIndicatior(1);
    var $_adata;
    if (data != null) {
        $_adata = data;
    } else {
        $_adata = {
            table_id: table_id,
            currentstep: currentstep,
            step_id: step_id,
        };
    }
    $.post(
        path_ajax_script + "/index.php?mod=" + mod + "&act=getMainFormStep",
        $_adata,
        function (html) {
            $Core.util.toggleIndicatior(0);
            $("#" + "frmMainStep_" + table_id).html(html);
            if (currentstep === "room") {
                loadHotelRoom();
            } else if (currentstep === "destination") {
                load_list_destinations(table_id);
            } else if (currentstep === "service") {
                load_list_services(table_id);
            } else if (currentstep === "hotel-facibility") {
                loadHotelFacibility(pvalTable);
            } else if (currentstep == "hotel_price") {
                loadHotelPrice();
            } else if (currentstep == "price-table") {
                load_price_table(table_id, {});
            } else if (currentstep == "duration") {
                $('[data-trigger="spinner"]').spinner(
                    "changed",
                    function (e, newVal, oldVal) {
                        var number_day = $("input[name=number_day]").val() || 0,
                            number_night =
                                $("input[name=number_night]").val() || 0;
                        if (number_day > number_night) {
                            if (number_day - number_night > 1) {
                                $("input[name=number_night]").val(
                                    number_day - 1
                                );
                            }
                        } else if (number_day < number_night) {
                            if (number_night - number_day > 1) {
                                $("input[name=number_day]").val(
                                    number_night - 1
                                );
                            }
                        }
                    }
                );
            } else if (currentstep == "lhdl") {
                var $el = $(
                    "[name=departure_point_id][table_id=" + table_id + "]"
                );
                $el.select2({
                    allowClear: true,
                    //minimumInputLength: 2,
                    minimumResultsForSearch: 10,
                    ajax: {
                        delay: 250,
                        type: "POST",
                        url:
                            path_ajax_script +
                            "/index.php?mod=" +
                            mod +
                            "&act=ajLoadListDeparturePoint",
                        dataType: "json",
                        data: function (param) {
                            return { term: param.term };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        id: item.city_id,
                                        text: item.name,
                                    };
                                }),
                            };
                        },
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    /*templateResult: formatCountry,*/
                    templateSelection: function (data, container) {
                        $(data.element).attr({
                            "data-city_id": data.city_id,
                            "data-name": data.name,
                        });
                        return data.text;
                    },
                })
                    .on("select2:select", function (e) {
                        /* var city_id = $(this).val(),
							city_code = $(this).find(':selected').data('city_code');
						$('.InputPotentialField_phone_' + p_id).val(city_code).focus();
						var InputPotentialField_phone = $('.InputPotentialField_phone_' + p_id),
							strLength = InputPotentialField_phone.val().length;
						InputPotentialField_phone[0].setSelectionRange(strLength, strLength);*/
                    })
                    .on("select2:unselect", function (e) {
                        /* $(this).closest('.inline-editor-container').find('.flag-icon').hide();*/
                    });
            }
        }
    );
}
