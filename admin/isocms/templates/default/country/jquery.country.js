$().ready(function () {
    $(document).on("click", '.add_new_country:not(".disable")', function (ev) {
        $(this).addClass("disable");
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajActionNewCountry",
            data: {
                tp: "S",
            },
            dataType: "json",
            success: function (json) {
                if (json.result == "success") {
                    window.location.href = json.link;
                }
            },
        });
    });
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
            $_form = $_this.closest("form"),
            table_id = $_this.data("table_id"),
            currentstep = $_this.data("currentstep"),
            nextstep = $_this.data("next_step");

        if ($_this.hasClass("js_save_back")) {
            nextstep = $_this.data("prevstep");
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

        var _validated = 0;
        if (
            $("input.required,select.required,textarea.required", $_form).length
        ) {
            $("input.required,select.required,textarea.required", $_form).each(
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
        if (parseInt(_validated) == 0) {
            //save data
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
                async: false,
                success: function (html) {
                    $Core.util.toggleIndicatior(0);
                    if (html.indexOf("_EXIST") >= 0) {
                        alertify.error(insert_error_exist);
                        return false;
                    }
                    if (nextstep !== "_last" && nextstep !== "_first") {
                        loadMainFormStep(table_id, nextstep);
                    } else if (nextstep == "_last") {
                        loadMainFormStep(table_id, "basic");
                    }
                    //next step menu
                    $(".stepbar-list>li>a.active").removeClass("active");
                    $(".loadYieldStep[data-step=" + nextstep + "]").addClass(
                        "active"
                    );
                    var currentpanel = $_this.data("panel"),
                        nextpanel = $(".stepbar-list>li>a.active").attr(
                            "panel"
                        ),
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
                    window.history.pushState({ href: $_href }, "", $_href);
                },
            });
            return false;
        }
    });
});

function loadMainFormStep(table_id, currentstep) {
    $Core.util.toggleIndicatior(1);
    var $_adata = { table_id: table_id, currentstep: currentstep };
    $.post(
        path_ajax_script + "/index.php?mod=" + mod + "&act=getMainFormStep",
        $_adata,
        function (html) {
            $Core.util.toggleIndicatior(0);
            $("#" + "frmMainStep_" + table_id).html(html);
            if (currentstep === "room") {
                loadCruiseRoom();
            } else if (currentstep === "destination") {
                load_list_destinations(table_id);
            } else if (currentstep === "service") {
                load_list_services(table_id);
            } else if (currentstep === "cruise-facibility") {
                loadCruiseFacibility(pvalTable);
            } else if (currentstep == "cruise_price") {
                loadCruisePrice();
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

function loadWhyCountry(country_id) {
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=SiteFrmWhyCountry",
        data: {
            country_id: country_id,
            tp: "L",
        },
        dataType: "html",
        success: function (html) {
            $("#tblWhyCountry").html(html);
        },
    });
}
$(document).on("click", "#clickToAddWhyCountry", function (ev) {
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=SiteFrmWhyCountry",
        data: {
            country_id: country_id,
            tp: "F",
        },
        dataType: "html",
        success: function (html) {
            makepopupnotresize("90%", "auto", html, "SiteFrmWhyCountry");
            $("#SiteFrmWhyCountry").css("top", "20px");
            var $editorID = $(".textarea_why_country_content_editor").attr(
                "id"
            );
            $("#" + $editorID).isoTextAreaFull();
            vietiso_loading(0);
        },
    });
    return false;
});
$(document).on("click", ".clickEditWhyCountry", function (ev) {
    var $_this = $(this);
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=SiteFrmWhyCountry",
        data: {
            why_choose_country_id: $_this.attr("data"),
            country_id: country_id,
            tp: "F",
        },
        dataType: "html",
        success: function (html) {
            makepopupnotresize("90%", "auto", html, "SiteFrmWhyCountry");
            $("#SiteFrmWhyCountry").css("top", "20px");
            var $editorID = $(".textarea_why_country_content_editor").attr(
                "id"
            );
            $("#" + $editorID).isoTextAreaFull();
            vietiso_loading(0);
        },
    });
    return false;
});
$(document).on("click", ".btnSaveWhyCountry", function (ev) {
    var $_this = $(this);
    var $_form = $_this.closest(".frmPop");
    var $title = $_form.find("input[name=title]");
    var $editorID = $(".textarea_why_country_content_editor").attr("id");
    var $intro = tinyMCE.get($editorID).getContent();
    var $image = $_form.find("input[name=isoman_url_image]");
    var $why_choose_country_id = $_this.attr("why_choose_country_id");
    // var $is_show_image = $('input[name=is_show_image]:checked').val();
    /**/
    var adata = {};
    adata["title"] = $.trim($title.val());
    adata["content"] = $intro;
    adata["image"] = $image.val();
    adata["why_choose_country_id"] = $why_choose_country_id;
    // adata['is_show_image'] = $is_show_image;
    adata["country_id"] = country_id;
    adata["tp"] = "S";
    console.log(adata);
    vietiso_loading(1);
    $("#frmWhyCountry").ajaxSubmit({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=SiteFrmWhyCountry",
        data: adata,
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("_INSERT_SUCCESS") >= 0) {
                loadWhyCountry(country_id);
                $_this.closest(".frmPop").find(".close_pop").trigger("click");
            }
            if (html.indexOf("_UPDATE_SUCCESS") >= 0) {
                loadWhyCountry(country_id);
                $_this.closest(".frmPop").find(".close_pop").trigger("click");
            }
            if (html.indexOf("_ERROR") >= 0) {
                alertify.error(insert_error);
            }
            if (html.indexOf("_EXIST") >= 0) {
                alertify.error(exist_error);
            }
            window.location.reload(true);
        },
    });
    return false;
});
$(document).on("click", ".clickDeleteWhyCountry", function (ev) {
    var _this = $(this);
    if (confirm(confirm_delete)) {
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=SiteFrmWhyCountry",
            data: (adata = {
                country_id: country_id,
                why_choose_country_id: _this.attr("data"),
                tp: "D",
            }),
            dataType: "html",
            success: function (html) {
                loadWhyCountry(country_id);
                alertify.success(delete_success);
                vietiso_loading(0);
                window.location.reload(true);
            },
        });
    }
    return false;
});
