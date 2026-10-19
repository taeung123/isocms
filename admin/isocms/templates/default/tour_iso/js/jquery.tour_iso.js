function loadYieldRate(opts) {
    var opts = opts || {};
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadYieldRate",
        data: opts,
        dataType: "json",
        success: function (res) {
            $(".yieldRate[tour_id=" + opts.tour_id + "]").val(
                res.rate_exchange,
            );
            FilterYieldEstimate(opts.tour_id);
        },
    });
}
function FilterYieldEstimate(tour_id) {
    var adata = {
        tour_id: tour_id,
        yield_op_id: $("#YieldEstimateTourOp_" + tour_id).val(),
        currency_id: $("#Nett_CRM_CURRENCY_" + tour_id).val(),
        exchange_rate: $("#Nett_CRM_Rate_" + tour_id).val(),
    };
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajFilterYieldEstimate",
        data: adata,
        dataType: "json",
        success: function (res) {
            vietiso_loading(0);
            $("#holderTourEstimate_" + tour_id)
                .attr({
                    tour_id: tour_id,
                })
                .html(res.html);
        },
    });
}

function openURL(href) {
    var link = href;

    $.ajax({
        url: link,
        type: "GET",
        cache: false,
        dataType: "html",

        success: function (result) {

            // Load nội dung mới
            $(".content_box_insert_tour").html(result);

            // Parse URL
            var arr = link.split("/");

            /*
             * URL:
             * /admin/tour_iso/edit/{tour_id}/{cat_menu}/{child_id}
             *
             * arr[0] = ""
             * arr[1] = "admin"
             * arr[2] = "tour_iso"
             * arr[3] = "edit"
             * arr[4] = tour_id
             * arr[5] = cat_menu
             * arr[6] = child_id
             */

            // ==========================
            // ACTIVE TOUR SETUP MENU
            // ==========================
            if (arr[4]) {

                // ==========================
                // REMOVE OLD ACTIVE
                // ==========================
                $(".tm-setup-item")
                    .removeClass("is-current")
                    .removeAttr("aria-current");

                $(".tm-setup-group")
                    .removeClass("is-open");

                $(".tm-setup-parent")
                    .attr("aria-expanded", "false");

                // ==========================
                // ACTIVE CURRENT ITEM
                // ==========================
                if (arr[6]) {

                    var $currentItem = $("#" + arr[6]);

                    if ($currentItem.length) {

                        $currentItem
                            .addClass("is-current")
                            .attr("aria-current", "page");

                        // Mở parent
                        var $group = $currentItem.closest(".tm-setup-group");

                        $group.addClass("is-open");

                        $group.find("> .tm-setup-parent")
                            .attr("aria-expanded", "true");
                    }
                }
            }

            // ==========================
            // OVERVIEW
            // ==========================
            if (arr[5] == "overview" || arr[3] == "overview") {

                $(".go_overview").hide();

                $(".list_work_step_insert .panel-heading a")
                    .addClass("collapsed");

                $(".list_work_step_insert .panel-collapse")
                    .removeClass("show");

                $(".list_work_step_insert .panel-heading #basic_tg_a")
                    .removeClass("collapsed");

                $(".list_work_step_insert .panel-collapse#basic_tg")
                    .addClass("show")
                    .css("height", "auto");

            }

            // ==========================
            // DEPARTURE DATE
            // ==========================
            else if (arr[5] == "departure_date") {

                initCalendar(tour_id);

            }

            // ==========================
            // OTHER
            // ==========================
            else {

                $(".go_overview").show();

            }

            // ==========================
            // RELOAD OPTION PRICE
            // ==========================
            $(".type_visitor").each(function (index, element) {

                var $_this = $(element);

                var $id = $_this.data("id");
                var $type = $_this.data("type");
                var $tour_id = $_this.data("tour_id");
                var $type_visitor = $_this.val();

                ajLoadOptionPriceTour(
                    $tour_id,
                    $type_visitor,
                    $id,
                    $type
                );

            });
        }
    });

    // Update browser URL without reload
    window.history.pushState(
        { href: href },
        "",
        href
    );

    return false;
}

function initCalendar(tour_id) {
    var calendarEl = document.getElementById("calendar");
    if (!calendarEl) return;

    if (calendarEl._calendar) {
        calendarEl._calendar.destroy();
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        height: "auto",
        initialView: "dayGridMonth",

        headerToolbar: {
            left: "",
            center: "prev title next",
            right: "",
        },

        // QUAN TRỌNG
        dayMaxEvents: false,
        dayMaxEventRows: false,
        fixedWeekCount: false,
        expandRows: true,

        /**
         * LOAD EVENTS
         */
        events: function (info, successCallback, failureCallback) {
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=loadCalendarSlot",
                dataType: "json",
                data: {
                    tour_id: tour_id,
                    start: info.startStr,
                    end: info.endStr,
                },
                success: function (res) {
                    var events = [];

                    if (Array.isArray(res)) {
                        res.forEach(function (e) {
                            if (!e.start) return;

                            events.push({
                                start: e.start,
                                title: "",
                                display: "block", // BẮT BUỘC
                                extendedProps: {
                                    html: e.html || "",
                                    number: parseInt(e.number || 0, 10),
                                    is_active: parseInt(e.is_active || 0, 10),
                                },
                            });
                        });
                    }

                    successCallback(events);
                },
                error: function () {
                    failureCallback();
                },
            });
        },

        /**
         * RENDER HTML TRONG Ô NGÀY
         */
        eventContent: function (arg) {
            var ext = arg.event.extendedProps;
            var html = "";

            if (ext.number > 0) {
                html =
                    '<div class="fc-event-skin ' +
                    (ext.is_active === 1 ? "active" : "noactive") +
                    ' text-center">' +
                    ext.html +
                    "</div>";
            } else {
                html = '<div class="text-center pt-10">' + ext.html + "</div>";
            }

            return { html: html };
        },
    });

    calendar.render();
    calendarEl._calendar = calendar;
}

function delete_departure(_this) {
    var tour_start_date_id = $(_this).data("tour_start_date_id");

    $.post(
        path_ajax_script + "/index.php?mod=" + mod + "&act=delete_departure",
        { tour_start_date_id: tour_start_date_id },
        function (respJson) {
            if (respJson.msg === "_success") {
                // REFRESH FULLCALENDAR V5+
                var calendarEl = document.getElementById("calendar");
                if (calendarEl && calendarEl._calendar) {
                    calendarEl._calendar.refetchEvents();
                }

                $Core.alert.alert(__["Message"], __["Delete success"]);
            } else {
                $Core.alert.alert(__["Message"], __["Delete Error"]);
            }
        },
        "json",
    );

    return false;
}

function open_departure_date(_this) {
    var date_id = $(_this).attr("date_id"),
        tour_id = $(_this).attr("tour_id"),
        openFrom = $(_this).attr("openFrom"),
        $_adata = { date_id: date_id, tour_id: tour_id, openFrom: openFrom };

    $Core.util.toggleIndicatior(1);
    $.post(
        path_ajax_script + "/index.php?mod=" + mod + "&act=open_departure_date",
        $_adata,
        function (respJson) {
            $Core.util.toggleIndicatior(0);
            $Core.popup.open(
                "auto",
                "auto",
                respJson.html,
                "open_departure_date_" + tour_id,
            );
            if (respJson.callback) {
                eval(respJson.callback);
            }
        },
        "json",
    );
    return false;
}
function edit_departure_date(_this) {
    var date_id = $(_this).data("date_id"),
        tour_id = $(_this).data("tour_id"),
        openFrom = $(_this).data("openFrom"),
        tour_start_date_id = $(_this).data("tour_start_date_id"),
        $_adata = {
            date_id: date_id,
            tour_id: tour_id,
            tour_start_date_id: tour_start_date_id,
            openFrom: openFrom,
        };

    $Core.util.toggleIndicatior(1);
    $.post(
        path_ajax_script + "/index.php?mod=" + mod + "&act=open_departure_date",
        $_adata,
        function (respJson) {
            $Core.util.toggleIndicatior(0);
            $Core.popup.open(
                "auto",
                "auto",
                respJson.html,
                "open_departure_date_" + tour_id,
            );
            if (respJson.callback) {
                eval(respJson.callback);
            }
        },
        "json",
    );
    return false;
}
function handler_ruler_type(_this, ev) {
    ev.preventDefault();
    var _val = $(_this).val(),
        _form = $(_this).closest("form");
    $(".ruler-controls").addClass("hidden");
    if (_val == 1) {
        $(".hcDateRange").removeClass("hidden");
        $("input[name=date_id]", _form).removeClass("required");
        $("input[name=start_date],input[name=due_date]", _form).addClass(
            "required",
        );
    } else if (_val == 2) {
        $(".hcOneDay").removeClass("hidden");
        $("input[name=date_id]", _form).addClass("required");
        $("input[name=start_date],input[name=due_date]", _form).removeClass(
            "required",
        );
    }
}
function handler_price_type(_this, ev) {
    ev.preventDefault();
    var _form = $(_this).closest("form"),
        _val = $("input[name=price_type]:checked", _form).val();

    if (_val == 0) {
        $(".hc-PriceTable").addClass("hidden");
        /*$(".price-In:not('.price_single_supply')", _form).removeClass('required');*/
    } else {
        $(".hc-PriceTable").removeClass("hidden");
        /*$(".price-In:not('.price_single_supply')", _form).addClass('required');*/
    }
}
function pop_save_departure_date(_this, ev) {
    ev.preventDefault();

    var $form = $(_this).closest("form");

    var $_adata = {
        date_id: $(_this).attr("date_id"),
        tour_id: $(_this).attr("tour_id"),
        openFrom: $(_this).attr("openFrom"),
        tour_start_date_id: $(_this).attr("tour_start_date_id"),
        data_price_child: JSON.stringify(collectPrice($form, ".price_child")),
        data_price_infant: JSON.stringify(collectPrice($form, ".price_infant")),
    };

    if (!validateDepartureForm($form)) {
        return false;
    }

    $Core.util.toggleIndicatior(1);

    $form.ajaxSubmit({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=pop_save_departure_date",
        data: $_adata,
        success: function (html) {
            $Core.util.toggleIndicatior(0);

            if (html.indexOf("_success") >= 0) {
                $Core.popup.close($form.closest(".modal"));

                // ✅ REFRESH FULLCALENDAR V5+
                var calendarEl = document.getElementById("calendar");
                if (calendarEl && calendarEl._calendar) {
                    calendarEl._calendar.refetchEvents();
                }

                $Core.alert.alert(__["Message"], __["Save success"]);
            } else if (html.indexOf("_invalid") >= 0) {
                alertify.error(html.split("|")[1]);
            }
        },
    });

    return false;
}

function collectPrice($form, selector) {
    var arr = [];
    $form.find(selector).each(function () {
        var $el = $(this);
        arr.push({
            tour_class_id: $el.attr("tour_class_id"),
            tour_number_group_id: $el.attr("tour_number_group_id"),
            tour_visitor_age_type_id: $el.attr("tour_visitor_age_type_id"),
            tour_visitor_height_type_id: $el.attr(
                "tour_visitor_height_type_id",
            ),
            price: $el.val(),
            price_type: $el.parent().find(".price_type_departure").val(),
        });
    });
    return arr;
}
if ($SiteHasFaqTours == 1) {
    $_document.on("click", "#clickToAddFaq", function (ev) {
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=SiteFrmTourFaq",
            data: {
                tour_id: tour_id,
                tp: "F",
            },
            dataType: "html",
            success: function (html) {
                makepopupnotresize(
                    "90%",
                    "auto",
                    html,
                    "SiteFrmTourFaq"
                );
                $("#SiteFrmTourFaq").css("top", "20px");
                var $editorID = $(
                    ".textarea_faq_content_editor"
                ).attr("id");
                $("#" + $editorID).isoTextAreaFull();
                vietiso_loading(0);
            },
        });
        return false;
    });

    $_document.on("click", ".clickEditFaq", function (ev) {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=SiteFrmTourFaq",
            data: {
                tour_faq_id: $_this.attr("data"),
                tour_id: tour_id,
                tp: "F",
            },
            dataType: "html",
            success: function (html) {
                makepopupnotresize(
                    "90%",
                    "auto",
                    html,
                    "SiteFrmTourFaq"
                );
                $("#SiteFrmTourFaq").css("top", "20px");
                var $editorID = $(
                    ".textarea_faq_content_editor"
                ).attr("id");
                var $editor_ID = $(
                    ".textarea_faq_content_editor_1"
                ).attr("id");
                $("#" + $editorID).isoTextAreaFull();
                $("#" + $editor_ID).isoTextAreaFull();

                vietiso_loading(0);
            },
        });
        return false;
    });

    $_document.off("click", ".btnSaveTourFaq").on("click", ".btnSaveTourFaq", function (ev) {
        ev.preventDefault();

        var $_this = $(this);
        var $form = $("#frmFaq");

        if (!$form.length) {
            alertify.error("Không tìm thấy form FAQ");
            return false;
        }

        // Validate required HTML5
        if ($form[0] && !$form[0].checkValidity()) {
            $form[0].reportValidity();
            return false;
        }

        // Save TinyMCE content vào textarea
        if (typeof tinyMCE !== "undefined") {
            tinyMCE.triggerSave();
        }

        var tour_id = $form.find('input[name="tour_id"]').val() || 0;
        var tour_faq_id = $form.find('input[name="tour_faq_id"]').val() || 0;

        vietiso_loading(1);

        $form.ajaxSubmit({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=" + mod + "&act=SiteFrmTourFaq",
            data: {
                tp: "S",
                tour_id: tour_id,
                tour_faq_id: tour_faq_id
            },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);

                if (html.indexOf("_INSERT_SUCCESS") >= 0 || html.indexOf("_UPDATE_SUCCESS") >= 0) {
                    loadTourFaq(tour_id);
                    $_this.closest(".frmPop").find(".close_pop").trigger("click");
                    return false;
                }

                if (html.indexOf("_TITLE_REQUIRED") >= 0) {
                    alertify.error("Vui lòng nhập Title");
                    return false;
                }

                if (html.indexOf("_ERROR") >= 0) {
                    alertify.error(insert_error);
                    return false;
                }

                if (html.indexOf("_EXIST") >= 0) {
                    alertify.error(exist_error);
                    return false;
                }

                console.log(html);
                alertify.error("Save failed");
            },
            error: function (xhr) {
                vietiso_loading(0);
                console.log(xhr.responseText);
                alertify.error("Ajax error");
            }
        });

        return false;
    });


    $_document.on("click", ".clickDeleteFaq", function (ev) {
        var _this = $(this);
        if (confirm(confirm_delete)) {
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteFrmTourFaq",
                data: (adata = {
                    tour_id: tour_id,
                    tour_faq_id: _this.attr("data"),
                    tp: "D",
                }),
                dataType: "html",
                success: function (html) {
                    loadTourFaq(tour_id);
                    alertify.success(delete_success);
                    vietiso_loading(0);
                    window.location.reload(true);
                },
            });
        }
        return false;
    });

}
function loadTourFaq($tour_id) {
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=SiteFrmTourFaq",
        data: {
            tour_id: $tour_id,
            tp: "L",
        },
        dataType: "html",
        success: function (html) {
            if (html.replace(" ", "") == "") {
                $("#tab3Note")
                    .addClass("iso-check-disabled")
                    .removeClass("iso-check");
            } else {
                $("#tab3Note")
                    .removeClass("iso-check-disabled")
                    .addClass("iso-check");
            }
            $("#tblTourFaq").html(html);
        },
    });
}
function validateDepartureForm($form) {
    var invalid = false;

    $form.find("input.required, select.required").each(function () {
        if (!$Core.util.isEmpty($(this).val())) return true;
        $(this).focus();
        invalid = true;
        return false;
    });

    var ruler_type = $form.find('select[name="ruler_type"]').val();
    if (
        ruler_type == 1 &&
        $form.find('input[name="start_date"]').val() &&
        $form.find('input[name="due_date"]').val() &&
        $form.find('input[name="weekdays[]"]:checked').length === 0
    ) {
        $form.find(".day_range").addClass("error");
        return false;
    }

    $form.find(".day_range").removeClass("error");
    return !invalid;
}

function load_tourTMS() {
    //vietiso_loading(1);
    $.post(
        path_ajax_script + "/index.php?mod=" + mod + "&act=ajload_tourTMS",
        {},
        function (html) {
            //vietiso_loading(0);
            $(".holder_tour_tms").html(html);
        },
    );
}
function load_tourToTMS() {
    //vietiso_loading(1);
    $.post(
        path_ajax_script + "/index.php?mod=" + mod + "&act=ajload_tourToTMS",
        {},
        function (html) {
            //vietiso_loading(0);
            $(".holder_tour_to_tms").html(html);
        },
    );
}
function ajLoadOptionPriceTour($tour_id, $type_visitor, $id, $type) {
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadOptionPriceTour",
        data: {
            tour_id: $tour_id,
            type_visitor: $type_visitor,
            type: $type,
        },
        dataType: "html",
        success: function (html) {
            $("#" + $id).html(html);
        },
    });
}
$_document.ready(function () {
    $(document).on("click", ".tm-setup-parent", function (e) {
        e.preventDefault();

        var $parent = $(this);
        var $group = $parent.closest(".tm-setup-group");
        var isOpen = $group.hasClass("is-open");

        // Đóng tất cả menu khác
        $(".tm-setup-group")
            .not($group)
            .removeClass("is-open")
            .find(".tm-setup-parent")
            .attr("aria-expanded", "false");

        // Toggle menu hiện tại
        if (isOpen) {
            $group.removeClass("is-open");
            $parent.attr("aria-expanded", "false");
        } else {
            $group.addClass("is-open");
            $parent.attr("aria-expanded", "true");
        }
    });

    $(document).on('click', '.tm-lang-tab', function () {
        var lang = $(this).data('lang');

        $('.tm-lang-tab')
            .removeClass('active')
            .attr('aria-selected', 'false');

        $(this)
            .addClass('active')
            .attr('aria-selected', 'true');

        $('.tm-instructions__content').attr('hidden', true);
        $('.tm-instructions__content[data-language="' + lang + '"]')
            .removeAttr('hidden');
    });

    $(document).on("change", ".iso_radio_switch", function () {
        let type = $(this).data("type");
        let val = $(this).prop("checked") ? 1 : 0;

        let data = {
            val: val,
            type: type,
            tour_id: tour_id,
        };

        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=updateTourStore",
            data: data,
            dataType: "json",
            success: function (json) {
                if (!json.res) {
                    alert(json.msg);
                }
            },
        });
    });

    function ajaxDepartureDate(type) {
        let lst_id = [];
        $(".iso_checkbox_departure").each(function () {
            if ($(this).prop("checked")) {
                let val = $(this).val();
                lst_id.push(val);
            }
        });

        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/?mod=" +
                mod +
                "&act=ajaxDepartureDateEvents",
            data: {
                lst_id: lst_id,
                type: type,
            },
            dataType: "json",
            success: function (resJson) {
                location.reload();
            },
        });
    }

    $(document)
        .on("change", ".iso_checkbox_departure", function () {
            if (
                !$(".iso_btn_item").hasClass("active") &&
                $(this).prop("checked")
            ) {
                $(".iso_btn_item").addClass("active");
            } else if (
                !$(this).prop("checked") &&
                $(".iso_checkbox_departure:checked").length == 0
            ) {
                $(".iso_btn_item").removeClass("active");
            }
        })
        .on("click", ".iso_btn_active", function () {
            ajaxDepartureDate("active");
        })
        .on("click", ".iso_btn_delete", function () {
            if (confirm(confirm_delete)) {
                ajaxDepartureDate("delete");
            }
        });

    // Duplicate Module TOur
    $(document).on("click", ".ajDuplicateTour", function (ev) {
        var $_this = $(this);
        var confirm_dup = $_this.data("confirm");
        if (confirm(confirm_dup + ": " + $_this.data("name_services") + "?")) {
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url: path_ajax_script + "/?mod=" + mod + "&act=ajDuplicateTour",
                data: {
                    tour_id: $_this.attr("tour_id"),
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    location.href = html;
                },
            });
        }
        return false;
    });
    // Add Tour Package
    $(document).on("click", ".ajAddTourPackage", function (ev) {
        var $_this = $(this);

        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajAddTourPackage",
            data: {
                tour_id: $_this.attr("tour_id"),
            },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                location.href = html;
            },
        });
        return false;
    });
    $_document.on("change", ".type_visitor", function (ev) {
        var $_this = $(this);
        var $id = $_this.data("id");
        var $type = $_this.data("type");
        var $tour_id = $_this.data("tour_id");
        var $type_visitor = $_this.val();
        ajLoadOptionPriceTour($tour_id, $type_visitor, $id, $type);
    });
    var url = window.location.pathname;
    $(document).on("click", ".open_syncTourAPI", function () {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajOpenSyncTourAPI",
            data: {},
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                makepopup("auto", "auto", html, "ajOpenSyncTourAPI");
                $("#ajOpenSyncTourAPI").css({ top: "60px" });
                load_tourTMS();
            },
        });
        return false;
    });
    $(document).on("click", ".open_syncTourtoTMS", function () {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajOpenSyncTourtoTMS",
            data: {},
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                makepopup("auto", "auto", html, "ajOpenSyncTourtoTMS");
                $("#ajOpenSyncTourtoTMS").css({ top: "60px" });
                load_tourToTMS();
            },
        });
        return false;
    });
    $(document).on("click", ".syncTourTMS", function () {
        var $_this = $(this),
            lst_tour_id = $Core.util.getCheckBoxValueByClass("ckb_tour_tms");
        //console.log(lst_tour_id);
        //return false;
        if ($(".ckb_tour_tms:checked").length == 0) {
            $Core.alert.alert("Vui lòng chọn Tour");
            return false;
        }
        $Core.util.toggleIndicatior(1);
        $.post(
            path_ajax_script + "/index.php?mod=" + mod + "&act=syncTourAPI",
            { lst_tour_id: lst_tour_id },
            function (res) {
                $Core.util.toggleIndicatior(0);
                if ($Core.util.isEmpty(res.result)) {
                    $.alert({
                        title: "Thất bại",
                        content:
                            "Vui lòng kiểm tra thông tin kết nối TMS tại: Cài đặt > Hồ sơ Công ty",
                    });
                } else {
                    if (res.result == "error") {
                        $.alert({
                            title: "Thất bại",
                            content: res.msg,
                        });
                    } else {
                        $.alert({
                            title: "Thành công",
                            content: res.msg,
                        });
                    }
                }
            },
            "json",
        );
        return false;
    });
    $(document).on("change", ".ckb_all_tour_tms", function () {
        var $_this = $(this);
        $(".ckb_tour_tms").prop("checked", $_this.is(":checked"));
        return false;
    });
    $(document).on("change", ".ckb_all_tour_to_tms", function () {
        var $_this = $(this);
        $(".ckb_tour_to_tms").prop("checked", $_this.is(":checked"));
        return false;
    });
    $(document).on("click", ".syncTourToTMS", function () {
        var $_this = $(this),
            lst_tour_id = $Core.util.getCheckBoxValueByClass("ckb_tour_to_tms");
        //console.log(lst_tour_id);
        //return false;
        if ($(".ckb_tour_to_tms:checked").length == 0) {
            $Core.alert.alert("Vui lòng chọn Tour");
            return false;
        }
        $Core.util.toggleIndicatior(1);
        $.post(
            path_ajax_script + "/index.php?mod=" + mod + "&act=syncTourToTMS",
            { lst_tour_id: lst_tour_id },
            function (res) {
                $Core.util.toggleIndicatior(0);
                if ($Core.util.isEmpty(res.result)) {
                    $.alert({
                        title: "Thất bại",
                        content:
                            "Vui lòng kiểm tra thông tin kết nối TMS tại: Cài đặt > Hồ sơ Công ty",
                    });
                } else {
                    if (res.result == "error") {
                        $.alert({
                            title: "Thất bại",
                            content: res.msg,
                        });
                    } else {
                        $.alert({
                            title: "Thành công",
                            content: res.msg,
                        });
                    }
                }
            },
            "json",
        );
        return false;
    });
    if (
        act != "default" &&
        act != "edit_itinerary" &&
        act != "property" &&
        act != "group" &&
        act != "price_range" &&
        act != "category_country" &&
        act != "insert_category_country" &&
        act != "store"
    ) {
        if (typeof slug !== "undefined" && slug) {
            openURL(url);
        } else if (typeof tour_id !== "undefined") {
            window.location.href =
                "/admin/tour_iso/edit/" + tour_id + "/basic/title-tripcode";
        }
        setTimeout(() => {
            //var w_h = $('body').height();
            //$(".box_left_opt_set").css('min-height',w_h-94);
        }, 1000);
    }
    $_document.on("change", ".FilterYieldEstimate", function (ev) {
        var $_this = $(this);
        var tour_id = $_this.attr("tour_id");
        if ($_this.hasClass("yieldCurrency")) {
            var opts = {
                tour_id: tour_id,
                currency_id: $_this.val(),
            };
            loadYieldRate(opts);
        } else {
            FilterYieldEstimate(tour_id);
        }
        return false;
    });
    $_document.on("click", ".refreshYieldEstimate", function () {
        var $_this = $(this);
        var tour_id = $_this.attr("tour_id");
        $.post(
            path_ajax_script + "/?mod=" + mod + "&act=refreshYieldEstimate",
            {
                tour_id: tour_id,
            },
            function (res) {
                FilterYieldEstimate(tour_id);
            },
            "json",
        );
    });
    $(document).on("click", '.add_new_tour:not(".disable")', function (ev) {
        $(this).addClass("disable");
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajActionNewTour",
            data: {
                tp: "S",
            },
            dataType: "json",
            success: function (json) {
                if (json.result == "success") {
                    $(this).removeClass("disable");
                    window.location.href = json.link;
                }
            },
        });
    });
    $_document.on("click", ".toggle_opt .online_tour", function () {
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajCheckPublicTour",
            data: { is_online: $(this).data("val"), tour_id: tour_id },
            dataType: "json",
            success: function (json) {
                if (json["result"] == "_SUCCESS") {
                    alertify.success(exist_success_tour_status);
                    window.location.reload(true);
                }
                if (json["result"] == "_ERR") {
                    alertify.error(exist_error);
                }
            },
        });
    });
    $_document.on("click", ".is_has_package", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajChangeHasPackage",
            data: { has_package: $(this).data("val"), tour_id: tour_id },
            dataType: "json",
            success: function (json) {
                if (json["result"] == "_SUCCESS") {
                    window.location.href =
                        "/admin/tour_iso/edit/" + tour_id + "/basic/overview";
                }
                if (json["result"] == "_ERR") {
                    alertify.error("error");
                }
            },
        });
    });
    $(".restore_tour_ex,.trash_tour_ex").on("click", function () {
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajCheckTrashTour",
            data: { type_btn: $(this).attr("type_btn"), tour_id: tour_id },
            dataType: "json",
            success: function (json) {
                if (json["result"] == "_SUCCESS") {
                    if (json["type"] == "trash") {
                        $(
                            "#is_delete_tour, #is_restore_tour, .trash_tour_text",
                        ).show();
                        $("#is_trash_tour").hide();
                        $(".preview_tour_ex").css({
                            "pointer-events": "none",
                            color: "#ccc",
                            "border-color": "#ccc",
                            "background-color": "#ffffff",
                            cursor: "not-allowed",
                        });
                        alertify.success(exist_success_tour_trash);
                    }
                    if (json["type"] == "delete") {
                        console.log(json["link"]);
                        alertify.success(exist_success_tour_delete);
                        setTimeout(function () {
                            window.location.href = json["link"];
                        }, 3000);
                    }
                    if (json["type"] == "restore") {
                        $(
                            "#is_delete_tour, #is_restore_tour, .trash_tour_text",
                        ).hide();
                        $("#is_trash_tour").show();
                        $(".preview_tour_ex").removeAttr("style");
                        alertify.success(exist_success_tour_restore);
                    }
                }
                if (json["result"] == "_ERR") {
                    alertify.error(exist_error);
                }
            },
        });
    });
    $(".delete_tour_ex").on("click", function () {
        if (confirm(confirm_delete)) {
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script + "/?mod=" + mod + "&act=ajCheckTrashTour",
                data: { type_btn: $(this).attr("type_btn"), tour_id: tour_id },
                dataType: "json",
                success: function (json) {
                    if (json["result"] == "_SUCCESS") {
                        if (json["type"] == "trash") {
                            $(
                                "#is_delete_tour, #is_restore_tour, .trash_tour_text",
                            ).show();
                            $("#is_trash_tour").hide();
                            $(".preview_tour_ex").css({
                                "pointer-events": "none",
                                color: "#ccc",
                                "border-color": "#ccc",
                                "background-color": "#ffffff",
                                cursor: "not-allowed",
                            });
                            alertify.success(exist_success_tour_trash);
                        }
                        if (json["type"] == "restore") {
                            $(
                                "#is_delete_tour, #is_restore_tour, .trash_tour_text",
                            ).hide();
                            $("#is_trash_tour").show();
                            $(".preview_tour_ex").removeAttr("style");
                            alertify.success(exist_success_tour_restore);
                        }
                        if (json["type"] == "delete_package") {
                            console.log(json["link"]);
                            alertify.success(exist_success_tour_delete);
                            setTimeout(function () {
                                window.location.href = json["link"];
                            }, 1000);
                        }
                        if (json["type"] == "delete") {
                            console.log(json["link"]);
                            alertify.success(exist_success_tour_delete);
                            setTimeout(function () {
                                window.location.href = json["link"];
                            }, 1000);
                        }
                    }
                    if (json["result"] == "_ERR") {
                        alertify.error(exist_error);
                    }
                },
            });
        }
    });
    $(document).on(
        "click",
        ".btnCreateTourProperty,.btnedit_tourProperty,.btndelete_tourProperty",
        function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=SiteTourProperty&lang=" +
                    LANG_ID,
                data: {
                    type: $_this.attr("type"),
                    tour_property_id: $_this.attr("data"),
                    tp: $_this.attr("tp"),
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    if ($_this.attr("tp") == "D") {
                        window.location.reload();
                    } else {
                        makepopup(320, "auto", html, "pop_TourProperty");
                    }
                },
            });
            return false;
        },
    );
    $(document).on("click", ".btnCreateTourActivities", function (ev) {
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=SiteTourActivities",
            data: { tp: "F" },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                makepopupnotresize("55%", "auto", html, "box_TourActivities");
                $("#box_TourActivities").css("top", "50px");
                var $editorID = $(".textarea_tour_intro_editor").attr("id");
                var $editorContentID = $(".textarea_tour_content_editor").attr(
                    "id",
                );
                $("#" + $editorID).isoTextAreaFix();
                $("#" + $editorContentID).isoTextAreaFix();
            },
        });
        return false;
    });
    $(document).on("click", ".btnClickToSubmitActivities", function (ev) {
        var $_this = $(this);
        var $_form = $_this.closest(".frmPop");
        var $title = $_form.find("input[name=title]");
        var $editorID = $(".textarea_tour_intro_editor").attr("id");
        var $editorContentID = $(".textarea_tour_content_editor").attr("id");

        var $image = $("#isoman_url_image").val();

        if ($title.val() == "") {
            $title.addClass("error").focus();
            alertify.error(field_is_required);
            return false;
        }

        var intro = tinyMCE.get($editorID).getContent();
        var content = tinyMCE.get($editorContentID).getContent();

        var _async = true;
        let frag = document.createElement("div");
        frag.innerHTML = intro;
        let itemsBase64 = [...frag.querySelectorAll("img")]
            .filter((img) => img.getAttribute("src").startsWith("data"))
            .map((img) => img.getAttribute("src"));
        if (itemsBase64.length) {
            _async = false;
            $.ajax({
                type: "POST",
                url: PCMS_URL + "/index.php?mod=ajax&act=convertBase64toImage",
                data: {
                    intro: intro,
                },
                async: false,
                dataType: "json",
                success: function (res) {
                    intro = res.intro;
                },
            });
        }
        frag.innerHTML = content;
        let itemsBase64Content = [...frag.querySelectorAll("img")]
            .filter((img) => img.getAttribute("src").startsWith("data"))
            .map((img) => img.getAttribute("src"));
        if (itemsBase64Content.length) {
            _async = false;
            $.ajax({
                type: "POST",
                url: PCMS_URL + "/index.php?mod=ajax&act=convertBase64toImage",
                data: {
                    intro: content,
                },
                async: false,
                dataType: "json",
                success: function (res) {
                    content = res.intro;
                },
            });
        }

        var adata = {
            title: $title.val(),
            intro: intro,
            content: content,
            image: $image,
            tp: "S",
        };
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=SiteTourActivities",
            data: adata,
            dataType: "html",
            success: function (html) {
                if (html.indexOf("_SUCCESS") >= 0) {
                    $(document)
                        .find(
                            "#isoblanketpop_box_TourActivities,#box_TourActivities",
                        )
                        .remove();
                    $(document).find("#activities-tour").trigger("click");
                }
                if (html.indexOf("_ERROR") >= 0) {
                    alertify.error(insert_error);
                }
                if (html.indexOf("_EXIST") >= 0) {
                    alertify.error(insert_error_exist);
                }
                vietiso_loading(0);
            },
        });
    });
    $(document).on("click", ".SiteClickSaveTourProperty", function (ev) {
        var $_this = $(this);
        var $_form = $_this.closest(".frmPop");
        var $title = $_form.find("input[name=title]");
        var $symbol = $_form.find("input[name=symbol]");

        if ($.trim($title.val()) == "") {
            $title.focus();
            alertify.error(field_is_required);
            return false;
        }
        var adata = {};
        adata["title"] = $title.val();
        adata["symbol"] = $symbol.val();
        adata["tour_property_id"] = $_this.attr("tour_property_id");
        adata["type"] = $_this.attr("type");
        adata["tp"] = "S";

        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/?mod=" +
                mod +
                "&act=SiteTourProperty&lang=" +
                LANG_ID,
            data: adata,
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                if (html.indexOf("_SUCCESS") >= 0) {
                    window.location.reload(true);
                }
                if (html.indexOf("_ERROR") >= 0) {
                    alertify.error(insert_error);
                }
                if (html.indexOf("_EXIST") >= 0) {
                    alertify.error(insert_error_exist);
                }
            },
        });
        return false;
    });
    $_document.on("keyup", ".input_text_form", function (e) {
        var _this = $(this),
            _tp = _this.attr("name"),
            value = _this.val();
        if (_tp == "title") {
            $(".tour-title[tour_id=" + tour_id + "]").text(value);
        } else if (_tp == "trip_code") {
            $(".trip_code[tour_id=" + tour_id + "]").text(value);
        }
    });
    $_document.on(
        "click",
        ".box_left_opt_set ul li a,.go_overview,.list_link li a,.link_open,.setting_menu_detail .btn-group ul li a",
        function (ev) {
            ev.preventDefault();
            var _this = $(this);
            $(".box_left_opt_set a").removeAttr("style");
            _this.css({ color: "#4094ff", "font-weight": "bold" });
            if (_this.data("type") == "promotion") {
                window.open(_this.attr("href"));
            } else {
                openURL(_this.attr("href"));
            }

            // console.log(prev_step);
            return false;
        },
    );
    $(document).on("click", ".panel-heading > .btn", function () {
        var accordionItem = $(this).closest(".panel");
        // Tìm collapse tương ứng
        var firstLink = accordionItem.find(
            ".panel-collapse > .panel-body > ul.stepbar-list > li:first-child > .load-block",
        );
        if (firstLink.length) {
            firstLink.trigger("click");
        }
    });

    $(document).on("change", "#slb_TourGroup", function (ev) {
        var $_this = $(this);
        var $tp = $_this.attr("tp") ? $_this.attr("tp").toLowerCase() : "";
        if ($tp == "ajax" && $SiteHasGroup_Tours == 1) {
            loadTourCategory($_this.val(), 0, 0);
        } else if ($tp == "multiple" && $SiteHasGroup_Tours == 1) {
            loadTourCategory(
                $_this.val(),
                $listcatID,
                1,
                "slb_ContainerTourCategory",
            );
        }
    });
    $_document.on("change", "#slb_TourGroupDes", function (ev) {
        var $_this = $(this),
            $tour_group_id = $_this.val();
        if (parseInt($tour_group_id) == 2) {
            $("#" + "slb_country_Id_Container").addClass("hidden");
            $("#" + "slb_region_Id_Container").addClass("hidden");
            $("#" + "slb_city_Id_Container").addClass("hidden");
            $("#" + "slb_placetogoID_Container").addClass("hidden");
            $("#slb_Chauluc").parent().hide();
            loadRegion(4);
        } else {
            vietiso_loading(1);
            $("#" + "slb_country_Id_Container").addClass("hidden");
            $("#" + "slb_region_Id_Container").addClass("hidden");
            $("#" + "slb_city_Id_Container").addClass("hidden");
            $("#" + "slb_placetogoID_Container").addClass("hidden");
            $("#slb_Chauluc").parent().show();
            vietiso_loading(0);
        }
    });

    if ($SiteHasDestinationTours == 1) {
        setSelectBoxDestination();
        $_document.on("change", ".slb_Chauluc_Id", function (ev) {
            var $_this = $(this),
                $_chauluc_id = $_this.val(),
                $_toId = $_this.attr("toId");
            if (parseInt($_chauluc_id) > 0) {
                vietiso_loading(1);
                $.post(
                    path_ajax_script + "/?mod=" + mod + "&act=ajLoadCountry",
                    {
                        chauluc_id: $_chauluc_id,
                    },
                    function (html) {
                        vietiso_loading(0);
                        if (html.indexOf("EMPTY") >= 0) {
                            $("#" + "slb_country_Id_Container").addClass(
                                "hidden",
                            );
                            $("#" + "slb_region_Id_Container").addClass(
                                "hidden",
                            );
                            $("#" + "slb_city_Id_Container").addClass("hidden");
                            $("#" + "slb_placetogoID_Container").addClass(
                                "hidden",
                            );
                        } else {
                            $("#" + "slb_country_Id_Container").removeClass(
                                "hidden",
                            );
                            $("#" + $_toId).html(html);
                        }
                    },
                );
            } else {
                $("#" + "slb_country_Id_Container").addClass("hidden");
                $("#" + "slb_region_Id_Container").addClass("hidden");
                $("#" + "slb_city_Id_Container").addClass("hidden");
                $("#" + "slb_placetogoID_Container").addClass("hidden");
            }
        });
        $_document.on("change", ".slb_Country_Id", function (ev) {
            var $_this = $(this),
                $_toId = $_this.attr("toId"),
                $_country_id = $_this.val(),
                SiteActive_region = $_this.attr("SiteActive_region"),
                SiteActive_city = $_this.attr("SiteActive_city");
            $("#" + "slb_region_Id_Container").addClass("hidden");
            $("#" + "slb_city_Id_Container").addClass("hidden");
            $("#" + "slb_placetogoID_Container").addClass("hidden");
            if (parseInt($_country_id) > 0) {
                loadRegion($_country_id);
            } else {
                $("#" + "slb_city_Id_Container").addClass("hidden");
                $("#" + "slb_placetogoID_Container").addClass("hidden");
            }
            return false;
        });
        $_document.on("change", ".slb_Region_Id", function (ev) {
            var $_this = $(this),
                $_region_id = $_this.val(),
                $_country_id = $("#" + "slb_CountryID").val(),
                $_toId = $_this.attr("toId");
            if (parseInt($_region_id) > 0) {
                vietiso_loading(1);
                $.post(
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajmakeSelectCityGlobal",
                    {
                        country_id: $_country_id,
                        region_id: $_region_id,
                    },
                    function (html) {
                        vietiso_loading(0);
                        if (html.indexOf("EMPTY") >= 0) {
                            $("#slb_CityID").hide();
                        } else {
                            $("#" + "slb_city_Id_Container").removeClass(
                                "hidden",
                            );
                            $("#" + "slb_placetogoID_Container").addClass(
                                "hidden",
                            );
                            $("#slb_CityID").html(html);
                        }
                    },
                );
            } else {
                $("#" + "slb_city_Id_Container").addClass("hidden");
                $("#" + "slb_placetogoID_Container").addClass("hidden");
            }
        });
        $_document.on("change", ".slb_City_Id", function (ev) {
            var $_this = $(this),
                $_city_id = $_this.val(),
                $_region_id = $("#" + "slb_RegionID").val(),
                $_country_id = $("#" + "slb_CountryID").val(),
                $_toId = $_this.attr("toId");

            if (parseInt($_city_id) > 0) {
                vietiso_loading(1);
                $.post(
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajmakeSelectPlaceToGoGlobal",
                    {
                        country_id: $_country_id,
                        region_id: $_region_id,
                        city_id: $_city_id,
                    },
                    function (html) {
                        vietiso_loading(0);
                        if (html.indexOf("EMPTY") >= 0) {
                            $("#" + "slb_placetogoID_Container").addClass(
                                "hidden",
                            );
                        } else {
                            $("#" + "slb_placetogoID_Container").removeClass(
                                "hidden",
                            );
                            $("#" + $_toId).html(html);
                        }
                    },
                );
            } else {
                $("#" + "slb_placetogoID_Container").addClass("hidden");
            }
        });
        // Destination
        $_document.on("click", ".ajQuickAddDestination", function (ev) {
            ev.preventDefault();
            var $_this = $(this),
                $_adata = {};
            $_adata["tour_id"] = $tour_id;
            var checkDes = 0;
            if ($SiteModActive_continent == "1") {
                var $chauluc_id = $(".slb_Chauluc_Id").val();
                $_adata["chauluc_id"] = $chauluc_id;
                if ($chauluc_id > 0) {
                    checkDes = 1;
                }
            }
            if ($SiteModActive_country == "1") {
                var $country_id = 1;
                if ($(".Hid_Country").length) {
                    $country_id = $(".Hid_Country").val();
                } else {
                    $country_id = $(".slb_Country_Id").val();
                }
                $_adata["country_id"] = $country_id;
                if ($country_id > 0) {
                    checkDes = 1;
                }
            }
            if ($SiteActive_region == "1") {
                var $region_id = $(".slb_Region_Id").val();
                $_adata["region_id"] = $region_id;
                if ($region_id > 0) {
                    checkDes = 1;
                }
            }
            if ($SiteActive_city == "1") {
                var $city_id = $(".slb_City_Id").val();
                $_adata["city_id"] = $city_id;
                if ($city_id > 0) {
                    checkDes = 1;
                }
            }
            if ($SiteActive_city == "1") {
                var $placetogo_id = $(".slb_placetogo_Id").val();
                $_adata["placetogo_id"] = $placetogo_id;
                if ($placetogo_id > 0) {
                    checkDes = 1;
                }
            }
            /**/
            if (checkDes > 0) {
                $.post(
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajaxAddMoreTourDestination",
                    $_adata,
                    function (html) {
                        if (html.indexOf("_SUCCESS") >= 0) {
                            if (tour_group_id == 2) {
                                loadRegion(4);
                                $("#slb_city_Id_Container").addClass("hidden");
                                if (
                                    $("#slb_placetogoID_Container").hasClass(
                                        "hidden",
                                    )
                                ) {
                                } else {
                                    $("#slb_placetogoID_Container").addClass(
                                        "hidden",
                                    );
                                }
                            } else {
                                loadCountry($("#slb_Chauluc").val());
                            }

                            loadListDestination($tour_id);
                            var url = $("#destination").attr("href");
                            openURL(url);
                        } else if (html.indexOf("_EXIST") >= 0) {
                            alertify.error(exist_error);
                        }
                    },
                );
            }
        });
        $_document.on("click", ".removeDestination", function (ev) {
            var $_this = $(this);
            $Core.alert.confirm(__["Message"], confirm_delete, function () {
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=" +
                        mod +
                        "&act=ajaxDeleteTourDestination",
                    data: { tour_destination_id: $_this.attr("data") },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadListDestination($tour_id);
                        var url = $("#destination").attr("href");
                        openURL(url);
                    },
                });
            });
            return false;
        });
        $_document.on("click", ".ajRemoveAllDestinationInTour", function (ev) {
            var $_this = $(this);
            $Core.alert.confirm(__["Message"], confirm_delete, function () {
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=" +
                        mod +
                        "&act=ajaxDeleteAllTourDestination",
                    data: { tour_id: tour_id },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadListDestination(tour_id);
                        var url = $("#destination").attr("href");
                        openURL(url);
                    },
                });
            });
            return false;
        });
    }
    if ($SiteHasExtensionTours == "1") {
        // Tour Extension
        $_document.on("click", ".clickChooiseTour", function (ev) {
            ev.preventDefault();
            var $_this = $(this),
                tour_2_id = $_this.attr("data");
            vietiso_loading(1);
            $.post(
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajAddTourExtension",
                {
                    tour_1_id: tour_id,
                    tour_2_id: tour_2_id,
                },
                function (html) {
                    vietiso_loading(0);
                    if (html.indexOf("_SUCCESS") >= 0) {
                        $_this.remove();
                        loadTourExtension(tour_id);
                    } else if (html.indexOf("_EXIST") >= 0) {
                        alertify.error(exist_error);
                    }
                },
            );
            return false;
        });
        $_document.on("click", ".clickDeleteTourExtension", function (ev) {
            ev.preventDefault();
            var _this = $(this),
                tour_extension_id = _this.attr("data");
            $Core.alert.confirm(__["Message"], confirm_delete, function () {
                vietiso_loading(1);
                $.post(
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajDeleteTourExtension",
                    {
                        tour_id: tour_id,
                        tour_extension_id: tour_extension_id,
                    },
                    function (html) {
                        vietiso_loading(0);
                        loadTourExtension(tour_id);
                    },
                );
            });
            return false;
        });
    }
    if ($SiteHasItineraryTours == 1) {
        $_document.on("click", "#clickToAddItinerary", function (ev) {
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteFrmTourItinerary",
                data: {
                    tour_id: tour_id,
                    tp: "F",
                },
                dataType: "html",
                success: function (html) {
                    makepopupnotresize(
                        "90%",
                        "auto",
                        html,
                        "SiteFrmTourItinerary",
                    );
                    $("#SiteFrmTourItinerary").css("top", "20px");
                    var $editorID = $(
                        ".textarea_itinerary_content_editor",
                    ).attr("id");
                    var $editor_ID = $(
                        ".textarea_itinerary_content_editor_1",
                    ).attr("id");
                    $("#" + $editorID).isoTextAreaFull();
                    $("#" + $editor_ID).isoTextAreaFull();
                    vietiso_loading(0);
                },
            });
            return false;
        });

        $_document.on(
            "click",
            "#clickToAddItinerary_contingency",
            function (ev) {
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=SiteFrmTourItineraryContingency",
                    data: {
                        tour_id: tour_id,
                        tp: "F",
                    },
                    dataType: "html",
                    success: function (html) {
                        makepopupnotresize(
                            "90%",
                            "auto",
                            html,
                            "SiteFrmTourItinerary",
                        );
                        $("#SiteFrmTourItinerary").css("top", "20px");
                        var $editorID = $(
                            ".textarea_itinerary_content_editor",
                        ).attr("id");
                        $("#" + $editorID).isoTextAreaFix();
                        vietiso_loading(0);
                    },
                });
                return false;
            },
        );

        $_document.on("click", ".clickEditItinerary", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteFrmTourItinerary",
                data: {
                    tour_itinerary_id: $_this.attr("data"),
                    tour_id: tour_id,
                    tp: "F",
                },
                dataType: "html",
                success: function (html) {
                    makepopupnotresize(
                        "90%",
                        "auto",
                        html,
                        "SiteFrmTourItinerary",
                    );
                    $("#SiteFrmTourItinerary").css("top", "20px");
                    var $editorID = $(
                        ".textarea_itinerary_content_editor",
                    ).attr("id");
                    var $editor_ID = $(
                        ".textarea_itinerary_content_editor_1",
                    ).attr("id");
                    $("#" + $editorID).isoTextAreaFull();
                    $("#" + $editor_ID).isoTextAreaFull();
                    if ($SiteHasHotel_Tours == 1) {
                        loadListHotelItinerary(
                            tour_id,
                            $_this.attr("data"),
                            "",
                        );
                    }
                    vietiso_loading(0);
                },
            });
            return false;
        });

        $_document.on("click", ".clickEditItineraryContingency", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteFrmTourItineraryContingency",
                data: {
                    tour_itinerary_id: $_this.attr("data"),
                    tour_id: tour_id,
                    tp: "F",
                },
                dataType: "html",
                success: function (html) {
                    makepopupnotresize(
                        "90%",
                        "auto",
                        html,
                        "SiteFrmTourItinerary",
                    );
                    $("#SiteFrmTourItinerary").css("top", "20px");
                    var $editorID = $(
                        ".textarea_itinerary_content_editor",
                    ).attr("id");
                    $("#" + $editorID).isoTextAreaFix();
                    if ($SiteHasHotel_Tours == 1) {
                        loadListHotelItinerary(
                            tour_id,
                            $_this.attr("data"),
                            "",
                        );
                    }
                    vietiso_loading(0);
                },
            });
            return false;
        });

        $_document.on(
            "input",
            ".iso_itinerary_day, .iso_itinerary_day2",
            function () {
                let dayInput = $(".iso_itinerary_day");
                let day2Input = $(".iso_itinerary_day2");

                let day = parseInt(dayInput.val()) || 0;
                let day2 = parseInt(day2Input.val()) || 0;

                let max = parseInt(dayInput.attr("max"));

                /* Không vượt max */
                if (day > max) {
                    day = max;
                    dayInput.val(day);
                }

                if (day2 > max) {
                    day2 = max;
                    day2Input.val(day2);
                }

                /* Đảm bảo day <= day2 */
                if (day > day2) {
                    day2Input.val(day);
                }

                /* Update min của day2 theo day */
                day2Input.attr("min", day);
            },
        );

        $(document).on("click", ".btnSaveTourItinerary", function (ev) {
            ev.preventDefault();

            var $_this = $(this);
            var $_form = $_this.closest(".frmPop");

            var $day = $_form.find("input[name=day]");
            var $day2 = $_form.find("input[name=day2]");
            var $title = $_form.find("input[name=title]");

            var $meals = getCheckBoxValueByClass("chk_Meal");
            var $transport = getCheckBoxValueByClass("chk_Transport");

            var $editorID = $(".textarea_itinerary_content_editor").attr("id");
            var $editor_ID = $(".textarea_itinerary_content_editor_1").attr("id");

            var $content = tinyMCE.get($editorID).getContent();

            var $condition = $("#" + $editor_ID).length
                ? tinyMCE.get($editor_ID).getContent()
                : "";

            var $image = $_form.find("input[name=isoman_url_image]");
            var $tour_itinerary_id = $_this.attr("tour_itinerary_id");
            var $is_show_image = $("input[name=is_show_image]:checked").val();

            /* =========================
             * REQUIRED: DAY
             * ========================= */
            if ($.trim($day.val()) == "") {
                $day.addClass("error").focus();
                alertify.error(field_is_required);
                return false;
            }

            /* =========================
             * REQUIRED: DAY 2
             * ========================= */
            if ($.trim($day2.val()) == "") {
                $day2.addClass("error").focus();
                alertify.error(field_is_required);
                return false;
            }

            /* =========================
             * REQUIRED: TITLE
             * ========================= */
            if ($.trim($title.val()) == "") {
                $title.addClass("error").focus();
                alertify.error(field_is_required);
                return false;
            }

            /* =========================
             * REQUIRED: MEAL
             * Chỉ kiểm tra nếu có checkbox Meal
             * ========================= */
            var $mealCheckbox = $_form.find(".chk_Meal");

            if ($mealCheckbox.length > 0) {
                if ($mealCheckbox.filter(":checked").length === 0) {
                    alertify.error("Please select at least one meal.");

                    $mealCheckbox.first().focus();

                    return false;
                }
            }

            /* =========================
             * REQUIRED: TRANSPORT
             * Chỉ kiểm tra nếu có checkbox Transport
             * ========================= */
            var $transportCheckbox = $_form.find(".chk_Transport");

            if ($transportCheckbox.length > 0) {
                if ($transportCheckbox.filter(":checked").length === 0) {
                    alertify.error("Please select at least one transport.");

                    $transportCheckbox.first().focus();

                    return false;
                }
            }

            /* =========================
             * DATA
             * ========================= */
            var adata = {};

            adata["day"] = $.trim($day.val());
            adata["day2"] = $.trim($day2.val());
            adata["title"] = $.trim($title.val());
            adata["meals"] = $meals;
            adata["transport"] = $transport;
            adata["content"] = $content;
            adata["condition"] = $condition;
            adata["image"] = $image.val();
            adata["tour_itinerary_id"] = $tour_itinerary_id;
            adata["is_show_image"] = $is_show_image;
            adata["tour_id"] = $tour_id;
            adata["tp"] = "S";

            vietiso_loading(1);

            $("#frmItinerary").ajaxSubmit({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteFrmTourItinerary",
                data: adata,
                dataType: "json",

                success: function (data) {
                    vietiso_loading(0);

                    if (data.result) {
                        window.location.reload();
                    } else {
                        alertify.error(data.mes);
                    }

                    return false;
                },
            });

            return false;
        });

        $_document.on(
            "click",
            ".btnSaveTourItineraryContingency",
            function (ev) {
                var $_this = $(this);
                var $_form = $_this.closest(".frmPop");
                var $title_contingency = $_form.find(
                    "input[name=title_contingency]",
                );

                var $meals = getCheckBoxValueByClass("chk_Meal");
                var $transport = getCheckBoxValueByClass("chk_Transport");
                var $editorID = $(".textarea_itinerary_content_editor").attr(
                    "id",
                );
                var $content = tinyMCE.get($editorID).getContent();
                var $image = $_form.find("input[name=isoman_url_image]");
                var $tour_itinerary_id = $_this.attr("tour_itinerary_id");
                var $is_show_image = $(
                    "input[name=is_show_image]:checked",
                ).val();

                /**/
                var adata = {};

                adata["title_contingency"] = $title_contingency.val();
                adata["meals"] = $meals;
                adata["transport"] = $transport;
                adata["content"] = $content;
                adata["image"] = $image.val();
                adata["tour_itinerary_id"] = $tour_itinerary_id;
                adata["is_show_image"] = $is_show_image;
                adata["tour_id"] = $tour_id;
                adata["tp"] = "S";

                vietiso_loading(1);
                $("#frmItinerary").ajaxSubmit({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=SiteFrmTourItineraryContingency",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        if (html.indexOf("_INSERT_SUCCESS") >= 0) {
                            loadTourItinerary($tour_id);
                            loadTourItineraryContingency($tour_id);
                            $_this
                                .closest(".frmPop")
                                .find(".close_pop")
                                .trigger("click");
                        }
                        if (html.indexOf("_UPDATE_SUCCESS") >= 0) {
                            loadTourItinerary($tour_id);
                            loadTourItineraryContingency($tour_id);
                            $_this
                                .closest(".frmPop")
                                .find(".close_pop")
                                .trigger("click");
                        }
                        if (html.indexOf("_ERROR") >= 0) {
                            alertify.error(insert_error);
                        }
                        if (html.indexOf("_EXIST") >= 0) {
                            alertify.error(exist_error);
                        }
                        if (html.indexOf("day_invalid") >= 0) {
                            $day.focus();
                            alertify.error("Error !");
                        }
                    },
                });
                return false;
            },
        );

        $_document.on("click", ".moveTourItinerary", function (ev) {
            var _this = $(this);
            /**/
            var adata = {};
            adata["tour_itinerary_id"] = _this.attr("data");
            adata["tour_id"] = tour_id;
            adata["direct"] = _this.attr("direct");
            adata["tp"] = "M";

            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteFrmTourItinerary",
                data: adata,
                dataType: "html",
                success: function (html) {
                    loadTourItinerary(tour_id);
                    loadTourItineraryContingency(tour_id);
                    vietiso_loading(0);
                },
            });
        });

        $_document.on("click", ".clickDeleteItinerary", function (ev) {
            var _this = $(this);
            if (confirm(confirm_delete)) {
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=SiteFrmTourItinerary",
                    data: (adata = {
                        tour_id: tour_id,
                        tour_itinerary_id: _this.attr("data"),
                        tp: "D",
                    }),
                    dataType: "html",
                    success: function (html) {
                        loadTourItinerary(tour_id);
                        loadTourItineraryContingency(tour_id);
                        alertify.success(delete_success);
                        vietiso_loading(0);
                        window.location.reload(true);
                    },
                });
            }
            return false;
        });

        $_document.on(
            "click",
            ".clickDeleteItineraryContingency",
            function (ev) {
                var _this = $(this);
                if (confirm(confirm_delete)) {
                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url:
                            path_ajax_script +
                            "/index.php?mod=" +
                            mod +
                            "&act=SiteFrmTourItineraryContingency",
                        data: (adata = {
                            tour_id: tour_id,
                            tour_itinerary_id: _this.attr("data"),
                            tp: "D",
                        }),
                        dataType: "html",
                        success: function (html) {
                            loadTourItinerary(tour_id);
                            loadTourItineraryContingency(tour_id);
                            alertify.success(delete_success);
                            vietiso_loading(0);
                        },
                    });
                }
                return false;
            },
        );
    }
    $_document.on("click", ".addTag", function () {
        var $_this = $(this),
            tour_id = $_this.attr("tour_id");
        $Core.util.toggleIndicatior(1);
        $.post(
            path_ajax_script + "/index.php?mod=" + mod + "&act=openTag",
            {
                tour_id: tour_id,
            },
            function (html) {
                $Core.util.toggleIndicatior(0);
                $Core.popup.open("auto", "auto", html, "OpenTag_" + tour_id);
            },
        );
        return false;
    });
    $_document.on("click", ".ajSaveTag", function () {
        var $_this = $(this),
            tour_id = $_this.attr("tour_id"),
            title = $(".titleTag").val();
        if ($Core.util.isEmpty(title)) {
            $Core.alert.alert(__["Message"], "Vui lòng nhập Tag!");
            $(".titleTag").focus();
            return false;
        }
        $.post(
            path_ajax_script + "/index.php?mod=" + mod + "&act=ajSaveTag",
            {
                tour_id: tour_id,
                title: title,
            },
            function (res) {
                if (res.indexOf("exist") >= 0) {
                    $Core.alert.alert(__["Message"], "Tag đã tồn tại!");
                    return false;
                } else {
                    $Core.popup.close($_this.closest(".modal"));
                    var url = $("#" + "option-tour").attr("url");
                    openURL(url);
                }
            },
        );
        return false;
    });
    $_document.on("click", ".addTourCategory,.editTourCategory", function () {
        var $_this = $(this),
            tour_id = $_this.attr("tour_id"),
            cat_id = $_this.attr("cat_id");
        $Core.util.toggleIndicatior(1);
        $.post(
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=openTourCategory",
            {
                tour_id: tour_id,
                cat_id: cat_id,
            },
            function (html) {
                $Core.util.toggleIndicatior(0);
                $Core.popup.open(
                    "auto",
                    "auto",
                    html,
                    "OpenTourCategory_" + tour_id,
                );
            },
        );
        return false;
    });
    $_document.on("click", ".saveTourCategory", function () {
        var $_this = $(this),
            tour_id = $_this.attr("tour_id"),
            cat_id = $_this.attr("cat_id"),
            title = $(".titleTourCategory").val();
        if ($Core.util.isEmpty(title)) {
            $Core.alert.alert(
                __["Message"],
                "Vui lòng nhập tên loại hình du lịch!",
            );
            $(".titleTourCategory").focus();
            return false;
        }
        $.post(
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajSaveTourCategory",
            {
                tour_id: tour_id,
                cat_id: cat_id,
                title: title,
            },
            function (res) {
                if (res.indexOf("exist") >= 0) {
                    $Core.alert.alert(
                        __["Message"],
                        "Loại hình du lịch đã tồn tại!",
                    );
                    return false;
                } else {
                    if (!$Core.util.isEmpty(cat_id)) {
                        $("#TourCategory_" + cat_id).text(title);
                    }
                    $Core.popup.close($_this.closest(".modal"));
                    var url = $("#" + "option-tour").attr("url");
                    openURL(url);
                }
            },
        );
        return false;
    });
    $_document.on("click", ".clickEditTourGroupStartDate", function (ev) {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajLoadTourPriceGroup",
            data: {
                tour_start_date_id: $_this.attr("tour_start_date_id"),
                tour_id: $_this.attr("tour_id"),
                tour_itinerary_id: $_this.attr("tour_itinerary_id"),
                departure: $_this.attr("departure"),
                tp: "F",
            },
            dataType: "html",
            success: function (html) {
                makepopupnotresize(
                    "90%",
                    "auto",
                    html,
                    "SiteFrmTourPriceGroup",
                );
                $("#SiteFrmTourPriceGroup").css("top", "20px");
                var $editorID = $(".textarea_itinerary_content_editor").attr(
                    "id",
                );
                $("#" + $editorID).isoTextAreaFull();
                vietiso_loading(0);
            },
        });
        return false;
    });

    $_document.on("click", ".clickDeleteTourGroupStartDate", function (ev) {
        if (confirm(confirm_delete)) {
            vietiso_loading(1);
            var $_this = $(this);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajDeleteTourGroupStartDate",
                data: {
                    tour_start_date_id: $_this.attr("tour_start_date_id"),
                    tour_itinerary_id: $_this.attr("tour_itinerary_id"),
                    tour_id: tour_id,
                    departure: $_this.attr("departure"),
                    type: "GROUP",
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadListPriceTourGroupStartDate(
                        $_this.attr("tour_itinerary_id"),
                    );
                },
            });
        }
        return false;
    });
    $_document.on("click", ".clickCopyTourGroupStartDate", function (ev) {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/?mod=" +
                mod +
                "&act=ajCopyPriceStartDateGroup",
            data: {
                tour_start_date_id: $_this.attr("tour_start_date_id"),
                tour_itinerary_id: $_this.attr("tour_itinerary_id"),
                tour_id: tour_id,
                departure: $_this.attr("departure"),
                type: "GROUP",
                tp: "COPY",
            },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                loadListPriceTourGroupStartDate(
                    $_this.attr("tour_itinerary_id"),
                );
            },
        });
        return false;
    });
    $_document.on("click", ".save_and_continue_tour", function (ev) {
        ev.preventDefault();
        ev.stopPropagation();
        var __ = {};
        __["Message"] = "Error";
        var _this = $(this),
            _form = _this.closest("form"),
            tour_id = _this.attr("tour_id"),
            present_step = _this.attr("present_step") ? _this.attr("present_step") : 'faq',
            next_step = _this.attr("next_step") ? _this.attr("next_step") : 'faq',
            cat_run = _this.attr("cat_run") ? _this.attr("cat_run") : 'Faq',
            skip = _this.attr("status");


        var arr = {};
        arr["tour_id"] = tour_id;
        arr["cat_run"] = cat_run;
        arr["present_step"] = present_step;
        if (skip) {
            arr["skip"] = skip;
        }
        if ($(".isoTextArea,.textarea_intro_editor_simple").length) {
            $(".isoTextArea,.textarea_intro_editor_simple").each(
                function (_index, _elem) {
                    var name = $(_elem).data("name"),
                        editorId = $(_elem).attr("id");
                    arr[name] = $Core.util.getTextAreaContent(editorId);
                },
            );
        }
        if ($('select[name="payments_term_deposit"]').length > 0) {
            arr["payments_term_deposit"] = $(
                'select[name="payments_term_deposit"]',
            ).val();
        }
        // console.log(cat_run);
        if (cat_run == "basic") {
            var title = $('input[name="title"]').val();
            var trip_code = $('input[name="trip_code"]').val();
            var tms_code = $("input[name=tms_code]").val();
            var check = true;
            if (title != "" || trip_code != "") {
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=" +
                        mod +
                        "&act=checkExistTitleTripcode",
                    data: {
                        table_id: tour_id,
                        title: title,
                        trip_code: trip_code,
                        tms_code: tms_code,
                    },
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
                        if (!json.result && json.type == "trip_code") {
                            alertify.error(json.message);
                            $('input[name="trip_code"]').addClass("error");
                            check = false;
                        } else {
                            $('input[name="trip_code"]').removeClass("error");
                        }
                        if (!json.result && json.type == "tms_code") {
                            alertify.error(json.message);
                            $('input[name="tms_code"]').addClass("error");
                            check = false;
                        } else {
                            $('input[name="tms_code"]').removeClass("error");
                        }
                    },
                });
            }
            if (!check) {
                return false;
            }
        }
        var _validated = 0;
        if (
            $("input.required,select.required,textarea.required", _form).length
        ) {
            $("input.required,select.required,textarea.required", _form).each(
                function () {
                    if ($Core.util.isEmpty($(this).val())) {
                        _validated++;
                        $(this).focus();
                        $(this).addClass("error");
                        if (
                            $(this).hasClass("chosen-select") &&
                            $(this).attr("multiple") == "multiple"
                        ) {
                            $(this).next().addClass("error");
                        }
                        return false;
                    } else {
                        $(this).removeClass("error");
                        if (
                            $(this).hasClass("chosen-select") &&
                            $(this).attr("multiple") == "multiple"
                        ) {
                            $(this).next().removeClass("error");
                        }
                    }
                },
            );
        }
        if (_validated > 0) {
            return false;
        }
        // console.log(_form);

        _form.ajaxSubmit({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajSaveDataTour",
            cache: false,
            data: arr,
            dataType: "json",
            success: function (json) {
                $(".panel .iso_tg_a").addClass("collapsed");
                if (json.result == "success") {
                    if (present_step == "title-tripcode") {
                        $(".tour_view_text").text(json.title);
                        $(".link_overview strong").text(json.trip_code);
                        $(".preview_tour_ex").attr("href", json.url);
                    }
                    if (present_step == "image-file-tour") {
                        $(".image_nav_tour").attr("src", json.image);
                    }
                    if (json.caution == "next") {
                        var p_step = present_step.split("/");
                        if (p_step[1]) {
                            $("#" + p_step[1])
                                .closest("li")
                                .removeAttr("class")
                                .addClass("check_success");
                        } else {
                            $("#" + p_step[0])
                                .closest("li")
                                .removeAttr("class")
                                .addClass("check_success");
                        }
                        //console.log(next_step);
                        if (
                            next_step != "SaveAll" &&
                            next_step != "SaveAllDayTrip" &&
                            next_step != "SaveAllTourPackage"
                        ) {
                            var next_s = next_step.split("/");
                            var numm = next_s.length;
                            //console.log(next_step, next_s);

                            if (numm == 2) {
                                openURL(
                                    "/admin/tour_iso/edit/" +
                                    tour_id +
                                    "/" +
                                    next_s[0] +
                                    "/" +
                                    next_s[1],
                                );
                                $(".box_left_opt_set a")
                                    .removeAttr("class")
                                    .addClass("collapsed");
                                $("#" + next_s[0] + "_tg_a").removeAttr(
                                    "class",
                                );

                                $("#" + cat_run + "_tg").removeClass("show");
                                $("#" + next_s[0] + "_tg")
                                    .addClass("show")
                                    .removeAttr("style");
                                $("#" + next_s[1]).css({
                                    color: "#4094ff",
                                    "font-weight": "bold",
                                });
                            } else {
                                $("#" + next_step + "_tg_a")
                                    .removeAttr("class")
                                    .addClass("collapsed");
                                $("#" + cat_run + "_tg").removeClass("show");
                                $("#" + cat_run + "_tg")
                                    .addClass("show")
                                    .removeAttr("style");
                                $("#" + next_step).css({
                                    color: "#4094ff",
                                    "font-weight": "bold",
                                });
                                openURL(
                                    "/admin/tour_iso/edit/" +
                                    tour_id +
                                    "/" +
                                    cat_run +
                                    "/" +
                                    next_step,
                                );
                            }
                        } else if (next_step == "SaveAllDayTrip") {
                            window.location.href =
                                path_ajax_script +
                                "/?mod=" +
                                mod +
                                "&is_day_trip=1&message=UpdateSuccess";
                        } else if (next_step == "SaveAllTourPackage") {
                            alertify.success("Success");
                        } else {
                            window.location.href =
                                path_ajax_script +
                                "/?mod=" +
                                mod +
                                "&message=UpdateSuccess";
                        }
                    } else if (json.caution == "skip") {
                        console.log('a', present_step);

                        var p_step1 = present_step.split("/");
                        if (p_step1[1]) {
                            $("#" + p_step1[1])
                                .closest("li")
                                .addClass("check_caution");
                        } else {
                            $("#" + p_step1[0])
                                .closest("li")
                                .addClass("check_caution");
                        }
                        var next_s = next_step.split("/");
                        var numm = next_s.length;
                        if (numm == 2) {
                            // alert(numm);
                            openURL(
                                "/admin/tour_iso/edit/" +
                                tour_id +
                                "/" +
                                next_s[0] +
                                "/" +
                                next_s[1],
                            );
                            $(".box_left_opt_set a")
                                .removeAttr("class")
                                .addClass("collapsed");
                            $("#" + next_s[0] + "_tg_a").removeAttr("class");
                            $("#" + cat_run + "_tg").removeClass("show");
                            $("#" + next_s[0] + "_tg")
                                .addClass("show")
                                .removeAttr("style");
                            // $("#"+next_s[1]).css({'color':'#4094ff','font-weight':'bold'});
                        } else {
                            console.log(cat_run);

                            $("#" + next_step + "_tg_a")
                                .removeAttr("class")
                                .addClass("collapsed");
                            $("#" + cat_run + "_tg").removeClass("show");
                            $("#" + cat_run + "_tg")
                                .addClass("show")
                                .removeAttr("style");
                            // $("#"+next_step).css({'color':'#4094ff','font-weight':'bold'});
                            openURL(
                                "/admin/tour_iso/edit/" +
                                tour_id +
                                "/" +
                                cat_run +
                                "/" +
                                next_step,
                            );
                        }
                    }
                } else if (json.result == "error_adult") {
                    $Core.alert.alert(
                        __["Message"],
                        "Adult group size data invalid",
                    );
                } else if (json.result == "error_child") {
                    $Core.alert.alert(
                        __["Message"],
                        "Child group size data invalid",
                    );
                } else if (json.result == "error_infant") {
                    $Core.alert.alert(
                        __["Message"],
                        "Infant group size data invalid",
                    );
                } else if (json.result == "error_seo") {
                    console.log($Core);
                    $Core.alert.alert(
                        __["Message"],
                        "Schema invalid",
                    );
                }
            },
        });
    });
    $_document.on("click", ".back_step", function (ev) {
        // var all_name = getInputSelectAttr('name');
        // var all_name_val = getInputSelectValAttr('value');
        var prev_step = $(this).attr("prev_step"),
            tour_id = $(this).attr("tour_id"),
            cat_run = $(this).attr("cat_run");
        var prev_s = prev_step.split("/");
        var numm = prev_s.length;
        if (numm == 2) {
            openURL(
                "/admin/tour_iso/edit/" +
                tour_id +
                "/" +
                prev_s[0] +
                "/" +
                prev_s[1],
            );
            $(".box_left_opt_set a").removeAttr("class").addClass("collapsed");
            $("#" + prev_s[0] + "_tg_a").removeAttr("class");
            $("#" + cat_run + "_tg").removeClass("in");
            $("#" + prev_s[0] + "_tg")
                .addClass("in")
                .removeAttr("style");
            $("#" + prev_s[1]).css({ color: "#4094ff", "font-weight": "bold" });
        } else {
            $("#" + prev_step + "_tg_a")
                .removeAttr("class")
                .addClass("collapsed");
            $("#" + cat_run + "_tg").removeClass("in");
            $("#" + cat_run + "_tg")
                .addClass("in")
                .removeAttr("style");
            $("#" + prev_step).css({ color: "#4094ff", "font-weight": "bold" });
            openURL(
                "/admin/tour_iso/edit/" + tour_id + "/" + cat_run + "/" + prev_step,
            );
        }
    });
    $(document).on(
        "click",
        ".btn-tour-for-agent, #btn-tour-for-agent",
        function (ev) {
            var $_this = $(this);
            var $listID = getCheckBoxValueByClass("chkitem");
            var $clsTable = $_this.attr("clsTable");
            var $act = $_this.attr("action");
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url: path_ajax_script + "/?mod=" + mod + "&act=ajTourForAgent",
                data: {
                    listID: $listID.join("|"),
                    clsTable: $clsTable,
                    action: $act,
                },
                dataType: "html",
                success: function (html) {
                    window.location.reload();
                },
            });
            return false;
        },
    );
    $(document).on("click", ".tm-tour-setup__mobile-toggle", function (e) {
        e.preventDefault();
        var $button = $(this);
        var $setup = $button.closest(".tm-tour-setup");
        var $nav = $setup.find(".tm-setup-nav");
        var isOpen = $setup.hasClass("is-mobile-open");
        if (isOpen) {
            $setup.removeClass("is-mobile-open");
            $button.attr("aria-expanded", "false");
            $nav.css("max-height", "0");
        } else {
            $setup.addClass("is-mobile-open");
            $button.attr("aria-expanded", "true");
            $nav.css("max-height", $nav[0].scrollHeight + "px");
        }
    });

});
$_document.on("change", ".h_tour_price_group,.price_type", function (ev) {
    var $_this = $(this);
    if ($_this.hasClass("price_type")) {
        var price = $_this
            .closest(".input-group")
            .find(".h_tour_price_group")
            .val();
        var price_type = $_this.val();
    } else {
        var price = $_this.val();
        var price_type = $_this
            .closest(".input-group")
            .find(".price_type")
            .val();
    }
    // console.log(price);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadTourPriceGroup",
        data: {
            tour_id: $_this.attr("tour_id"),
            tour_class_id: $_this.attr("tour_class_id"),
            tour_start_date_id: $_this.attr("tour_start_date_id"),
            tour_itinerary_id: $_this.attr("tour_itinerary_id"),
            departure: $_this.attr("departure"),
            tour_number_group_id: $_this.attr("tour_number_group_id"),
            tour_visitor_type_id: $_this.attr("tour_visitor_type_id"),
            tour_visitor_age_type_id: $_this.attr("tour_visitor_age_type_id"),
            tour_visitor_height_type_id: $_this.attr(
                "tour_visitor_height_type_id",
            ),
            price: price,
            price_type: price_type,
            tp: "S",
        },
        dataType: "html",
        success: function (html) {
            var htm = html.split("|||");
            if (!$_this.hasClass("price_type")) {
                $_this.val(htm[1]);
            }
            if ($_this.attr("departure") == "") {
                loadTourPriceGroupNoDeparture();
            }
            loadTourPriceGroup(
                $tour_id,
                $_this.attr("departure"),
                $_this.attr("tour_start_date_id"),
            );
        },
    });
});

$_document.on("change", ".h_price_single_supply", function (ev) {
    var $_this = $(this);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadTourPriceGroup",
        data: {
            tour_id: $_this.attr("tour_id"),
            departure_date: $_this.attr("departure"),
            tour_class_id: $_this.attr("tour_class_id"),
            tour_itinerary_id: $_this.attr("tour_itinerary_id"),
            tour_start_date_id: $_this.attr("tour_start_date_id"),
            price_single: $_this.val(),
            tp: "SINGLE",
        },
        dataType: "html",
        success: function (html) {
            var htm = html.split("|||");
            $_this.val(htm[1]);
            loadTourPriceGroup(
                $tour_id,
                $_this.attr("departure"),
                $_this.attr("tour_start_date_id"),
            );
        },
    });
});

$_document.on("click", "#clickToAddDay", function (ev) {
    var $_this = $(this);
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajAddHotPromotion",
        data: {
            target_id: tour_id,
            type: "TOUR",
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            loadListHotTourPromotion();
        },
    });
    return false;
});

$_document.on("click", ".clickToAddNewTourGroupStartDate", function (ev) {
    var $_this = $(this);
    if ($("#multiDate").val() == "") {
        $("#multiDate").focus();
        return false;
    }
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajAddGroupStartDate",
        data: {
            tour_id: tour_id,
            type: "GROUP",
            start_date: $("#multiDate").val(),
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            loadListPriceTourGroupStartDate(tour_itinerary_id);
            //loadTourPriceUnitStartDate();
            $_this.closest(".frmPop").find(".close_pop").click();
        },
    });
    return false;
});

$_document.on("click", ".clickDeleteTourStartDate", function (ev) {
    if (confirm(confirm_delete)) {
        vietiso_loading(1);
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/?mod=" +
                mod +
                "&act=ajDeleteTourStartDate",
            data: {
                tour_start_date_id: $_this.attr("tour_start_date_id"),
                tour_id: tour_id,
                departure: $_this.attr("departure"),
            },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                loadTourPriceUnitStartDate();
            },
        });
    }
    return false;
});

$_document.on("click", ".clickCopyTourGroupStartDate", function (ev) {
    var $_this = $(this);
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/?mod=" +
            mod +
            "&act=ajCopyPriceStartDateGroup",
        data: {
            tour_start_date_id: $_this.attr("tour_start_date_id"),
            tour_itinerary_id: $_this.attr("tour_itinerary_id"),
            tour_id: tour_id,
            departure: $_this.attr("departure"),
            type: "GROUP",
            tp: "COPY",
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            loadListPriceTourGroupStartDate($_this.attr("tour_itinerary_id"));
        },
    });
    return false;
});

$_document.on("click", ".clickPasteTourGroupStartDate", function (ev) {
    var $_this = $(this);
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/?mod=" +
            mod +
            "&act=ajCopyPriceStartDateGroup",
        data: {
            tour_start_date_id: $_this.attr("tour_start_date_id"),
            tour_itinerary_id: $_this.attr("tour_itinerary_id"),
            tour_id: tour_id,
            departure: $_this.attr("departure"),
            type: "GROUP",
            tp: "PASTE",
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            loadListPriceTourGroupStartDate($_this.attr("tour_itinerary_id"));
        },
    });
    return false;
});

$_document.on("click", ".clickDeleteTourGroupStartDate", function (ev) {
    if (confirm(confirm_delete)) {
        vietiso_loading(1);
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/?mod=" +
                mod +
                "&act=ajDeleteTourGroupStartDate",
            data: {
                tour_start_date_id: $_this.attr("tour_start_date_id"),
                tour_itinerary_id: $_this.attr("tour_itinerary_id"),
                tour_id: tour_id,
                departure: $_this.attr("departure"),
                type: "GROUP",
            },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                loadListPriceTourGroupStartDate(
                    $_this.attr("tour_itinerary_id"),
                );
            },
        });
    }
    return false;
});
function setSelectBoxDestination() { }
function loadTourCategory($tour_group_id, $selected, $chosen, $conatiner) {
    if ($conatiner == "" || $conatiner == undefined) {
        $conatiner = "slb_Category";
    }
    $("#" + $conatiner).html('<option value="0">' + loading + "</option>");
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajaxSiteTourCategory",
        data: {
            tour_group_id: $tour_group_id,
            cat_id: $selected,
            chosen: $chosen,
        },
        dataType: "html",
        success: function (html) {
            if ($chosen) {
                $("#" + $conatiner).html(html);
                $(".chosen-select").chosen({
                    width: "100%",
                });
            } else {
                $("#" + $conatiner).html(html);
            }
        },
    });
}
function loadListHotelItinerary($tour_id, $tour_itinerary_id, $keyword) {
    var adata = {
        tour_id: $tour_id,
        tour_itinerary_id: $tour_itinerary_id,
        keyword: $keyword,
    };
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajaxLoadHotelItinerary",
        data: adata,
        dataType: "html",
        success: function (html) {
            $("#lstHotel").html(html);
            vietiso_loading(0);
        },
    });
}

function loadTourItinerary($tour_id) {
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=SiteFrmTourItinerary",
        data: {
            tour_id: $tour_id,
            tp: "L",
        },
        dataType: "html",
        success: function (html) {
            if (html.replace(" ", "") == "") {
                $("#holderCopyItinerary").hide();
                $("#tab3Note")
                    .addClass("iso-check-disabled")
                    .removeClass("iso-check");
            } else {
                $("#holderCopyItinerary").show();
                $("#tab3Note")
                    .removeClass("iso-check-disabled")
                    .addClass("iso-check");
            }
            $("#tblTourItinerary").html(html);
        },
    });
}

function loadTourItineraryContingency($tour_id) {
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=SiteFrmTourItineraryContingency",
        data: {
            tour_id: $tour_id,
            tp: "L",
        },
        dataType: "html",
        success: function (html) {
            if (html.replace(" ", "") == "") {
                $("#holderCopyItinerary").hide();
                $("#tab3Note")
                    .addClass("iso-check-disabled")
                    .removeClass("iso-check");
            } else {
                $("#holderCopyItinerary").show();
                $("#tab3Note")
                    .removeClass("iso-check-disabled")
                    .addClass("iso-check");
            }
            $("#tblTourItinerary_contingency").html(html);
        },
    });
}

function loadCountry($chauluc_id, $country_id) {
    $("#slb_Country").html('<option value="0">' + loading + "</option>");
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadCountry",
        data: {
            chauluc_id: $chauluc_id,
            country_id: $country_id,
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("EMPTY") >= 0) {
                $("#slb_Country").hide();
            } else {
                $("#slb_CountryID").html(html).show();
            }
            /**/
            if (!$("#slb_region_Id_Container").hasClass("hidden")) {
                $("#slb_region_Id_Container").addClass("hidden");
            }
            if (!$("#slb_city_Id_Container").hasClass("hidden")) {
                $("#slb_city_Id_Container").addClass("hidden");
            }
            if (!$("#slb_placetogoID_Container").hasClass("hidden")) {
                $("#slb_placetogoID_Container").addClass("hidden");
            }
        },
    });
}

function loadRegion($country_id, $region_id) {
    $("#slb_RegionID").html('<option value="0">' + loading + "</option>");
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadRegion",
        data: {
            country_id: $country_id,
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("EMPTY") >= 0) {
                $("#slb_region_Id_Container").addClass("hidden");
                loadCity($country_id);
            } else {
                $("#slb_region_Id_Container").removeClass("hidden");
                $("#slb_RegionID").html(html).show();
            }
        },
    });
}

function loadCity($country_id, $region_id, $city_id, $tour_id) {
    $("#slb_CityID").html('<option value="0">' + loading + "</option>");
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajmakeSelectCityGlobal",
        data: {
            country_id: $country_id,
            region_id: $region_id,
            city_id: $city_id,
            tour_id: $tour_id,
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("EMPTY") >= 0) {
                $("#slb_CityID").hide();
            } else {
                $("#slb_city_Id_Container").removeClass("hidden");
                $("#slb_CityID").html(html).show();
            }
        },
    });
}

function loadPlaceTogo($country_id, $city_id) {
    $("#slb_placetogoID").html('<option value="0">' + loading + "</option>");
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/?mod=" +
            mod +
            "&act=ajmakeSelectPlaceToGoGlobal",
        data: {
            country_id: $country_id,
            city_id: $city_id,
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("EMPTY") >= 0) {
                $("#slb_placetogoID").hide();
            } else {
                $("#slb_placetogoID").html(html).show();
            }
        },
    });
}

function loadListDestination($tour_id, openFrom) {
    /*vietiso_loading(1);*/
    $.post(
        path_ajax_script + "/?mod=" + mod + "&act=ajaxLoadTourDestination",
        {
            tour_id: $tour_id,
            openFrom: openFrom,
        },
        function (html) {
            vietiso_loading(0);
            $("#lstDestination").html(html);
            /*loadMaps($tour_id);*/
        },
    );
}
function loadMaps(tour_id) {
    vietiso_loading(1);
    $.post(
        path_ajax_script + "/?mod=" + mod + "&act=map",
        {
            tour_id: tour_id,
        },
        function (html) {
            vietiso_loading(0);
            var $htm = html.split("$$$");
            $("#map_canvas").html($htm[0]);
        },
    );
}
function search_tour() {
    aj_search = setTimeout(function () {
        $.ajax({
            type: "POST",
            url:
                path_ajax_script + "/index.php?mod=" + mod + "&act=ajGetSearch",
            data: {
                keyword: $("#searchkey").val(),
                tour_id: tour_id,
            },
            dataType: "html",
            success: function (html) {
                if (html.indexOf("_EMPTY") >= 0) {
                    $("#autosugget").hide();
                } else {
                    $("#autosugget").stop(false, true).slideDown();
                    $("#autosugget").find(".HTML_sugget").html(html);
                }
            },
        });
    }, 500);
}
function loadTourExtension(tour_id) {
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajLoadTourExtension",
        data: {
            tour_1_id: tour_id,
        },
        dataType: "html",
        success: function (html) {
            if (html.replace(" ", "") == "") {
                $("#tab5Note")
                    .removeClass("iso-check")
                    .addClass("iso-check-disabled");
                $("#tblTourExtension").html("");
            } else {
                $("#tblTourExtension").html(html);
                $("#tab5Note")
                    .addClass("iso-check")
                    .removeClass("iso-check-disabled");
            }
            if ($("#tblTourExtension").find("tr").length > 0) {
                $("#related_tours")
                    .closest("li")
                    .removeAttr("class")
                    .addClass("check_success");
            } else {
                $("#related_tours")
                    .closest("li")
                    .removeAttr("class")
                    .addClass("check_caution");
            }
        },
    });
}
function loadTourPriceGroupNoDeparture() {
    vietiso_loading(1);
    var $_this = $(this);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadTourPriceGroup",
        data: {
            tour_id: $tour_id,
            tp: "L",
            type: "NoDeparture",
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            $("#TourPriceGroupNoDeparture").html(html);
        },
    });
}

function loadListPriceTourGroupStartDate(tour_itinerary_id) {
    vietiso_loading(1);
    var $_this = $(this);
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/?mod=" +
            mod +
            "&act=ajLoadListPriceTourGroupStartDate",
        data: {
            tour_id: tour_id,
            tour_itinerary_id: tour_itinerary_id,
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            $("#GroupStartDateHolder").html(html);
        },
    });
}
function loadTourPriceGroup(
    $tour_id,
    $departure,
    $tour_start_date_id,
    $tour_itinerary_id,
) {
    var adata = {
        tour_id: $tour_id,
        departure: $departure,
        tour_start_date_id: $tour_start_date_id,
        tour_itinerary_id: $tour_itinerary_id,
        tp: "L",
    };
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadTourPriceGroup",
        data: adata,
        dataType: "html",
        success: function (html) {
            vietiso_loading(2);
            $("#tblTourPriceGroup").html(html);
        },
    });
}

function getInputTextAttr(attr) {
    var result = $(".box_title_trip_code input").get();
    var columns = $.map(result, function (element) {
        return $(element).attr(attr);
    });

    return columns.join(",");
}

function getInputSelectAttr(attr) {
    $arr = {};
    var result_select = $(".box_title_trip_code select").get();
    var result_input_text = $(".box_title_trip_code input:text").get();
    var result_input_hidden = $(".box_title_trip_code input:hidden").get();
    var result_input_radio = $(
        ".box_title_trip_code input:radio:checked",
    ).get();
    var result_input_checkbox = $(
        ".box_title_trip_code input:checkbox:checked",
    ).get();
    var result_input_area = $(".box_title_trip_code textarea").get();

    $.map(result_select, function (element) {
        var key = $(element).attr(attr);
        if (key && key != "undefined") {
            if ($(element).val() != "") {
                $arr[key] = $(element).val();
            }
        }
    });
    $.map(result_input_text, function (element) {
        var key = $(element).attr(attr);
        if (key && key != "undefined") {
            if ($(element).val() != "") {
                $arr[key] = $(element).val();
            }
        }
    });
    $.map(result_input_hidden, function (element) {
        var key = $(element).attr(attr);
        if (key && key != "undefined") {
            if ($(element).val() != "") {
                $arr[key] = $(element).val();
            }
        }
    });
    $.map(result_input_radio, function (element) {
        var key = $(element).attr(attr);
        if (key && key != "undefined") {
            if ($(element).val() != "") {
                $arr[key] = $(element).val();
            }
        }
    });
    var columns = $.map(result_input_checkbox, function (element) {
        return $(element).attr("value");
    });
    $.map(result_input_checkbox, function (element) {
        var key = $(element).attr(attr);
        if (key && key != "undefined") {
            $arr[key] = columns.join(",");
        }
    });
    $.map(result_input_area, function (element) {
        var key = $(element).attr(attr);
        var clas = $(element).attr("class");
        if (key && key != "undefined") {
            if (clas == "textarea_intro_editor_simple") {
                if (content() != "") {
                    $arr[key] = content();
                }
            } else {
                if ($(element).val() != "") {
                    $arr[key] = $(element).val();
                }
            }
        }
    });

    return $arr;
}

function getInputSelectGrpSize(attr) {
    $arr = {};
    var result_select_grp = $(".box_title_trip_code select").get();
    $.map(result_select_grp, function (element) {
        var key = $(element).attr(attr);
        if (key && key != "undefined") {
            $arr[key] = $(element).val();
        }
    });

    return $arr;
}

$(".checkall_checkbox").live("click", function () {
    var $_this = $(this);
    var group = $_this.attr("group");
    if ($_this.is(":checked")) {
        $(".checkitem_checkbox[group='" + group + "']").attr(
            "checked",
            "checked",
        );
    } else {
        $(".checkitem_checkbox[group='" + group + "']").removeAttr("checked");
    }
});
// Tour Hotels
if ($SiteHasHotel_Tours == "1") {
    $_document.on("click", ".ajaxOpenChoiceHotel", function (ev) {
        var $_this = $(this);
        var adata = {};
        adata["tour_id"] = $_this.attr("tour_id");
        adata["tour_itinerary_id"] = $_this.attr("tour_itinerary_id");
        adata["tour_hotel_id"] = $_this.attr("tour_hotel_id");
        adata["tour_type_id"] = $tour_type_id;

        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajaxGetBoxHotelRecommend",
            dataType: "html",
            data: adata,
            success: function (html) {
                makepopup("80%", "auto", html, "pop_HotelRecommend");
                $("#pop_HotelRecommend").css("top", "30px");
                if ($tour_type_id == "1") {
                    loadCityHotelList();
                    setInterval(function () {
                        /*	$('select[name=countryhotel_id]').attr('disabled','disabled');*/
                    }, 100);
                }
                vietiso_loading(0);
            },
        });
        return false;
    });
    $_document.on(
        "change",
        "#pop_HotelRecommend select[name=continenthotel_id]",
        function (ev) {
            var $_this = $(this);
            var $continent_id = $_this.val();

            vietiso_loading(1);
            $("#pop_HotelRecommend select[name=countryhotel_id]").html(
                "<option>" + loading + "</option>",
            );
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=tour&act=ajaxSelectHotelCountry",
                data: {
                    continent_id: $continent_id,
                },
                dataType: "html",
                success: function (html) {
                    $("#pop_HotelRecommend select[name=countryhotel_id]").html(
                        html,
                    );
                    vietiso_loading(0);
                },
            });
            var $keyword = $("#pop_HotelRecommend input[name=keypop]").val();
            var $number_per_page = $(
                "#pop_HotelRecommend .paginate_length",
            ).val();
            var $star = $("#pop_HotelRecommend select[name=star]").val();
            var $tour_id = $("#pop_HotelRecommend #hid_tour_id").val();
            var $itinerary_id = $(
                "#pop_HotelRecommend #hid_itinerary_id",
            ).val();
            reloadListHotel(
                $continent_id,
                0,
                0,
                $star,
                $keyword,
                $tour_id,
                $itinerary_id,
                1,
                $number_per_page,
            );
        },
    );
    $_document.on(
        "change",
        "#pop_HotelRecommend select[name=countryhotel_id]",
        function (ev) {
            var $_this = $(this);
            var $country_id = $_this.val();
            var $city_id = 0;
            var $continent_id = $(
                "#pop_HotelRecommend select[name=continent_id]",
            ).val();
            var $star = $("#pop_HotelRecommend select[name=star]").val();
            var $keyword = $("#pop_HotelRecommend input[name=keypop]").val();
            var $number_per_page = $(
                "#pop_HotelRecommend .paginate_length",
            ).val();
            var $tour_id = $("#pop_HotelRecommend #hid_tour_id").val();
            var $tour_itinerary_id = $(
                "#pop_HotelRecommend #hid_itinerary_id",
            ).val();

            if (parseInt($country_id) == 0) {
                $("#pop_HotelRecommend select[name=cityhotel_id]").html(
                    "<option>-- " + Select + " --</option>",
                );
                $("#pop_HotelRecommend select[name=star]").html(
                    "<option>-- " + Select + " --</option>",
                );
                return false;
            }
            /* Make combobox city */
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajmakeSelectCityHotelGlobal",
                data: {
                    country_id: $country_id,
                },
                dataType: "html",
                success: function (html) {
                    $("#pop_HotelRecommend select[name=cityhotel_id]").html(
                        html,
                    );
                },
            });
            reloadListHotel(
                $continent_id,
                $country_id,
                $city_id,
                $star,
                $keyword,
                $tour_id,
                $tour_itinerary_id,
                1,
                $number_per_page,
            );
        },
    );
    $_document.on(
        "change",
        "#pop_HotelRecommend select[name=cityhotel_id]",
        function (ev) {
            var $_this = $(this);
            var $continent_id = $(
                "#pop_HotelRecommend select[name=continent_id]",
            ).val();
            var $country_id = $(
                "#pop_HotelRecommend select[name=country_id]",
            ).val();
            var $keyword = $("#pop_HotelRecommend input[name=keypop]").val();
            var $number_per_page = $(
                "#pop_HotelRecommend .paginate_length",
            ).val();
            var $star = $("#pop_HotelRecommend select[name=star]").val();
            var $tour_id = $("#pop_HotelRecommend #hid_tour_id").val();
            var $tour_itinerary_id = $(
                "#pop_HotelRecommend #hid_itinerary_id",
            ).val();

            reloadListHotel(
                $continent_id,
                $country_id,
                $_this.val(),
                $star,
                $keyword,
                $tour_id,
                $tour_itinerary_id,
                1,
                $number_per_page,
            );
        },
    );
    $_document.on("click", "#pop_HotelRecommend .searchpop", function (ev) {
        var $continent_id = $(
            "#pop_HotelRecommend select[name=continent_id]",
        ).val();
        var $country_id = $(
            "#pop_HotelRecommend select[name=country_id]",
        ).val();
        var $city_id = $("#pop_HotelRecommend select[name=city_id]").val();
        var $keyword = $("#pop_HotelRecommend input[name=keypop]").val();
        var $star = $("#pop_HotelRecommend select[name=star]").val();
        var $number_per_page = $("#pop_HotelRecommend .paginate_length").val();
        var $tour_id = $("#pop_HotelRecommend #hid_tour_id").val();
        var $tour_itinerary_id = $(
            "#pop_HotelRecommend #hid_itinerary_id",
        ).val();
        reloadListHotel(
            $continent_id,
            $country_id,
            $city_id,
            $star,
            $keyword,
            $tour_id,
            $tour_itinerary_id,
            1,
            $number_per_page,
        );
    });
    $_document.on(
        "click",
        "#pop_HotelRecommend .paginate_button",
        function (ev) {
            var $_this = $(this);
            var $continent_id = $(
                "#pop_HotelRecommend select[name=continent_id]",
            ).val();
            var $country_id = $(
                "#pop_HotelRecommend select[name=country_id]",
            ).val();
            var $city_id = $("#pop_HotelRecommend select[name=city_id]").val();
            var $star = $("#pop_HotelRecommend select[name=star]").val();
            var $keyword = $("#pop_HotelRecommend input[name=keypop]").val();
            var $tour_id = $("#pop_HotelRecommend #hid_tour_id").val();
            var $tour_itinerary_id = $(
                "#pop_HotelRecommend #hid_itinerary_id",
            ).val();
            var $number_per_page = $(
                "#pop_HotelRecommend .paginate_length",
            ).val();
            reloadListHotel(
                $continent_id,
                $country_id,
                $city_id,
                $star,
                $keyword,
                $tour_id,
                $tour_itinerary_id,
                $_this.attr("page"),
                $number_per_page,
            );
            return false;
        },
    );
    $_document.on("click", ".btnChooiseHotel", function (ev) {
        var $_this = $(this);
        var $tour_id = $_this.attr("tour_id");
        var $tour_itinerary_id = $_this.attr("tour_itinerary_id");
        var $list_id = $("#list_selected_chkitem").val();

        var adata = {};
        adata["tour_id"] = $tour_id;
        adata["tour_itinerary_id"] = $tour_itinerary_id;
        adata["list_id"] = $list_id;

        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajaxSaveTourHotel",
            data: adata,
            dataType: "html",
            success: function (html) {
                if (html.indexOf("_EMPTY") >= 0) {
                    alertify.error("You must choose hotel !");
                }
                if (html.indexOf("_SUCCESS") >= 0) {
                    loadListHotelItinerary(tour_id, $tour_itinerary_id, "");
                    $_this
                        .closest(".frmPop")
                        .find(".close_pop")
                        .trigger("click");
                }
            },
        });
        return false;
    });
    $_document.on("click", ".btn_delete_hotel_itinerary", function (ev) {
        var $_this = $(this);
        if (confirm(confirm_delete)) {
            var $tour_id = $_this.attr("_tour_id");
            var $tour_itinerary_id = $_this.attr("_tour_itinerary_id");

            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajaxDeleteHotelItinerary",
                data: {
                    tour_hotel_id: $_this.attr("data"),
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadListHotelItinerary(tour_id, $tour_itinerary_id, "");
                },
            });
        }
        return false;
    });
    $("#slb_MonthYear").live("change", function () {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/?mod=" +
                mod +
                "&act=ajLoadListPriceTourGroupStartDate",
            data: {
                tour_id: tour_id,
                start_date: $_this.attr("start_date"),
                departure: $_this.val(),
            },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                $("#GroupStartDateHolder").html(html);
            },
        });
    });
    $_document.on("change", ".h_tour_price_group", function (ev) {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script + "/?mod=" + mod + "&act=ajLoadTourPriceGroup",
            data: {
                tour_id: $_this.attr("tour_id"),
                tour_class_id: $_this.attr("tour_class_id"),
                tour_start_date_id: $_this.attr("tour_start_date_id"),
                tour_itinerary_id: $_this.attr("tour_itinerary_id"),
                departure: $_this.attr("departure"),
                tour_number_group_id: $_this.attr("tour_number_group_id"),
                tour_visitor_type_id: $_this.attr("tour_visitor_type_id"),
                price: $_this.val(),
                tp: "S",
            },
            dataType: "html",
            success: function (html) {
                var htm = html.split("|||");
                $_this.val(htm[1]);
                if ($_this.attr("departure") == "") {
                    loadTourPriceGroupNoDeparture();
                }
                loadTourPriceGroup(
                    $tour_id,
                    $_this.attr("departure"),
                    $_this.attr("tour_start_date_id"),
                );
            },
        });
    });
    $_document.on("change", ".h_price_single_supply", function (ev) {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script + "/?mod=" + mod + "&act=ajLoadTourPriceGroup",
            data: {
                tour_id: $_this.attr("tour_id"),
                departure_date: $_this.attr("departure"),
                tour_class_id: $_this.attr("tour_class_id"),
                tour_itinerary_id: $_this.attr("tour_itinerary_id"),
                tour_start_date_id: $_this.attr("tour_start_date_id"),
                price_single: $_this.val(),
                tp: "SINGLE",
            },
            dataType: "html",
            success: function (html) {
                var htm = html.split("|||");
                $_this.val(htm[1]);
                loadTourPriceGroup(
                    $tour_id,
                    $_this.attr("departure"),
                    $_this.attr("tour_start_date_id"),
                );
            },
        });
    });
    $_document.on("change", "#available", function (ev) {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajAddGroupStartDate",
            data: {
                tour_id: $_this.attr("tour_id"),
                start_date: $_this.attr("start_date"),
                available: $_this.val(),
                type: "GROUP",
                tp: "SaveAvailable",
            },
            dataType: "html",
            success: function (html) {
                var htm = html.split("|||");
                $_this.val(htm[1]);
                loadTourPriceGroup($tour_id, $_this.attr("start_date"));
            },
        });
    });
    $_document.on("click", ".up_grp_size", function (ev) {
        var all_select_grp = getInputSelectGrpSize("name");
        all_select_grp["tour_id"] = tour_id;
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajSaveGrpSize",
            cache: false,
            data: all_select_grp,
            dataType: "json",
            success: function (json) {
                if (json.result == "success") {
                    if (is_depart == 1) {
                        if (is_check_depart) {
                            loadListPriceTourGroupStartDate();
                        } else {
                            loadTourPriceGroupNoDeparture();
                        }
                    } else {
                        loadTourPriceGroupNoDeparture();
                    }
                }
                if (json.result == "error") {
                    alert("Data Invalid");
                } else if (json.result == "error_adult") {
                    alert("Adult group size data invalid");
                } else if (json.result == "error_child") {
                    alert("Child group size data invalid");
                } else if (json.result == "error_infant") {
                    alert("Infant group size data invalid");
                }
            },
        });
    });
    $_document.on("change", "#select_group_id", function (ev) {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajAddGroupStartDate",
            data: {
                tour_id: $_this.attr("tour_id"),
                start_date: $_this.attr("start_date"),
                select_group_id: $_this.val(),
                type: "GROUP",
                tp: "SaveSelect",
            },
            dataType: "html",
            success: function (html) {
                var htm = html.split("|||");
                $_this.val(htm[1]);
                loadTourPriceGroup($tour_id, $_this.attr("start_date"));
            },
        });
    });
    $_document.on("change", "#seat_status", function (ev) {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajAddGroupStartDate",
            data: {
                tour_id: $_this.attr("tour_id"),
                start_date: $_this.attr("start_date"),
                seat_status: $_this.val(),
                type: "GROUP",
                tp: "SaveSelectSeatStatus",
            },
            dataType: "html",
            success: function (html) {
                var htm = html.split("|||");
                $_this.val(htm[1]);
                loadTourPriceGroup($tour_id, $_this.attr("start_date"));
            },
        });
    });
    $_document.on("change", "#deposit_departure", function (ev) {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajAddGroupStartDate",
            data: {
                tour_id: $_this.attr("tour_id"),
                start_date: $_this.attr("start_date"),
                deposit_departure: $_this.val(),
                type: "GROUP",
                tp: "SaveDeposit",
            },
            dataType: "html",
            success: function (html) {
                var htm = html.split("|||");
                $_this.val(htm[1]);
                loadTourPriceGroup($tour_id, $_this.attr("start_date"));
            },
        });
    });
    $_document.on("click", ".SiteClickNoPublic", function (ev) {
        alert("Please enter a price in the price table");
    });
    $_document.on("click", ".clickEditTourGroupStartDate", function (ev) {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajLoadTourPriceGroup",
            data: {
                tour_start_date_id: $_this.attr("tour_start_date_id"),
                tour_id: $_this.attr("tour_id"),
                tour_itinerary_id: $_this.attr("tour_itinerary_id"),
                departure: $_this.attr("departure"),
                tp: "F",
            },
            dataType: "html",
            success: function (html) {
                makepopupnotresize(
                    "90%",
                    "auto",
                    html,
                    "SiteFrmTourPriceGroup",
                );
                $("#SiteFrmTourPriceGroup").css("top", "20px");
                var $editorID = $(".textarea_itinerary_content_editor").attr(
                    "id",
                );
                $("#" + $editorID).isoTextAreaFull();
                vietiso_loading(0);
            },
        });
        return false;
    });
}
if (mod == "tour_exhautive" && act == "property") {
    loadListTourOption();
    loadListSizeGroup("16", "SIZEGROUP");
    $(document).ready(function () {
        var aj_search = "";
        $(document).on("click", "#findSizeGroup", function (ev) {
            var $_this = $(this);
            loadListSizeGroup($("input[name=keyword]").val(), $type);
        });
        $(document).on("click", ".btnCreateSizeGroup", function (e) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSiteFrmTourSizeGroup",
                data: (adata = {
                    tour_property_id: $_this.attr("tour_property_id"),
                    type: "SIZEGROUP",
                    tp: "F",
                }),
                dataType: "html",
                success: function (html) {
                    makepopupnotresize(
                        "30%",
                        "auto",
                        html,
                        "box_CreateTourSizeGroup",
                    );
                    $("#box_CreateTourSizeGroup").css("top", 80 + "px");
                    $(".price").priceFormat({
                        thousandsSeparator: ".",
                        centsLimit: 0,
                    });
                    vietiso_loading(0);
                },
            });
            return false;
        });
        $(document).on("click", ".ajEditSizeGroup", function (e) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSiteFrmTourSizeGroup",
                data: {
                    tour_option_id: $_this.attr("data"),
                    tour_property_id: $_this.attr("tour_property_id"),
                    tp: "F",
                },
                dataType: "html",
                success: function (html) {
                    makepopupnotresize(
                        "30%",
                        "auto",
                        html,
                        "box_EditTourSizeGroup",
                    );
                    $("#box_EditTourSizeGroup").css("top", 80 + "px");
                    vietiso_loading(0);
                },
            });
            return false;
        });
        $(document).on("click", ".ajSubmitSizeGroup", function (e) {
            var $_this = $(this);
            var $_form = $_this.closest(".frmPop");
            /**/
            var $title = $_form.find("input[name=title]");
            var $number_to = $_form.find("input[name=number_to]");
            var $number_from = $_form.find("input[name=number_from]");
            var $tour_property_age = $_form.find(
                "select[name=tour_property_age]",
            );
            var $tour_property_height = $_form.find(
                "select[name=tour_property_height]",
            );
            /**/
            $_form.find("input,select").removeClass("error");
            if ($.trim($title.val()) == "") {
                $title.addClass("error").focus();
                alertify.error(field_is_required);
                return false;
            }
            if (
                $tour_property_age.length > 0 &&
                $tour_property_age.val() == "0"
            ) {
                $tour_property_age.addClass("error").focus();
                alertify.error(field_is_required);
                return false;
            }
            if (
                $tour_property_height.length > 0 &&
                $tour_property_height.val() == "0"
            ) {
                $tour_property_height.addClass("error").focus();
                alertify.error(field_is_required);
                return false;
            }
            if ($number_to.val() == "") {
                $number_to.addClass("error").focus();
                alertify.error(field_is_required);
                return false;
            } else if ($number_to.val() < 0) {
                $number_to.addClass("error").focus();
                alertify.error(field_valid);
                return false;
            }
            if ($number_from.val() == "") {
                $number_from.addClass("error").focus();
                alertify.error(field_is_required);
                return false;
            } else if ($number_from.val() < 0) {
                $number_from.addClass("error").focus();
                alertify.error(field_valid);
                return false;
            }
            if (parseInt($number_from.val()) > parseInt($number_to.val())) {
                $number_from.addClass("error").focus();
                $number_to.addClass("error").focus();
                alertify.error(field_valid);
                return false;
            }
            var adata = {
                title: $title.val(),
                type: "SIZEGROUP",
                number_to: $number_to.val(),
                number_from: $number_from.val(),
                tour_property_age: $tour_property_age.val(),
                tour_property_height: $tour_property_height.val(),
                tour_property_id: $_this.attr("tour_property_id"),
                tour_option_id: $_this.attr("tour_option_id"),
                tp: "S",
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSiteFrmTourSizeGroup",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    if (html.indexOf("_SUCCESS") >= 0) {
                        alertify.success(insert_success);
                        loadListSizeGroup(
                            $_this.attr("tour_property_id"),
                            "SIZEGROUP",
                        );
                        $_form.find(".close_pop").trigger("click");
                    } else if (html.indexOf("_UPDATE_SUCCESS") >= 0) {
                        alertify.success(update_success);
                        var $keyword = $("#keyword").val();
                        var $page = $(".paginate_current_page").val();
                        var $number_per_page = $(".paginate_length").val();
                        loadListSizeGroup(
                            $_this.attr("tour_property_id"),
                            "SIZEGROUP",
                        );
                        $_form.find(".close_pop").trigger("click");
                    } else if (html.indexOf("_TITLEINVALID") >= 0) {
                        $title.addClass("error").focus();
                        alertify.error(field_valid);
                    } else if (html.indexOf("_ERROR") >= 0) {
                        alertify.error(insert_error);
                    } else if (html.indexOf("_INVALID") >= 0) {
                        $number_from.addClass("error").focus();
                        $number_to.addClass("error").focus();
                        alertify.error(field_valid);
                    } else {
                        alertify.error(exist_error);
                    }
                },
            });
        });
        $(".ajDeleteSizeGroup").live("click", function () {
            var $_this = $(this);
            if (confirm(confirm_delete)) {
                var adata = { tour_option_id: $_this.attr("data") };
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=ajSiteFrmTourSizeGroup",
                    data: {
                        tour_property_id: $_this.attr("tour_property_id"),
                        tour_option_id: $_this.attr("data"),
                        tp: "D",
                    },
                    dataType: "html",
                    success: function (html) {
                        var $keyword = $("#keyword").val();
                        loadListSizeGroup(
                            $_this.attr("tour_property_id"),
                            "SIZEGROUP",
                        );
                        vietiso_loading(0);
                    },
                });
            }
            return false;
        });
        $(document).on("click", "#clickToAddTourOption", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            if ($("#PopupAddTourOption").length == 0) {
                $.ajax({
                    type: "POST",
                    url: `${path_ajax_script}/?mod=${mod}&act=ajAddTourOption`,
                    data: {
                        type: "OPENMODAL",
                    },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        makepopupnotresize(
                            "600px",
                            "auto",
                            html,
                            "PopupAddTourOption",
                        );
                        $("#PopupAddTourOption").css({ top: "100px" });
                    },
                });
                return;
            }

            $.ajax({
                type: "POST",
                url: `${path_ajax_script}/?mod=${mod}&act=ajAddTourOption`,
                data: {
                    type: "TOUROPTION",
                    title: $('#PopupAddTourOption input[name="title"]').val(),
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    let loadTourOption = false;
                    if (html.indexOf("exist_title") >= 0) {
                        alertify.error(exist_title);
                        return false;
                    }
                    $(
                        "#PopupAddTourOption,#isoblanketpop_PopupAddTourOption",
                    ).fadeOut(300, function () {
                        $(this).remove();
                        if (!loadTourOption) {
                            loadTourOption = true;
                            if (html.indexOf("success") >= 0)
                                alertify.success(insert_success);
                            else alertify.error(error);
                            loadListTourOption();
                        }
                    });
                },
            });
            return false;
        });
        $(document).on("click", ".SiteClickSaveTourOption", function (ev) {
            var $_this = $(this);
            var $_form = $_this.closest(".frmPop");
            var $title = $_form.find("input[name=title]");

            if ($.trim($title.val()) == "") {
                $title.focus();
                alertify.error(field_is_required);
                return false;
            }
            var adata = {};
            adata["title"] = $title.val();
            adata["tour_option_id"] = $_this.attr("tour_option_id");
            adata["type"] = $_this.attr("type");
            adata["tp"] = "Save";

            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajLoadListTourOption",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    if (html.indexOf("_SUCCESS") >= 0) {
                        window.location.reload(true);
                    }
                    if (html.indexOf("_ERROR") >= 0) {
                        alertify.error(insert_error);
                    }
                    if (html.indexOf("_EXIST") >= 0) {
                        alertify.error(insert_error_exist);
                    }
                },
            });
            return false;
        });
        $(document).on("click", ".clickEditTourOption", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajLoadListTourOption",
                data: {
                    tour_option_id: $_this.attr("tour_option_id"),
                    tp: "Edit",
                },
                dataType: "html",
                success: function (html) {
                    makepopupnotresize(
                        "600px",
                        "auto",
                        html,
                        "SiteFrmTourOption",
                    );
                    $("#SiteFrmTourOption").css("top", "100px");
                    var $editorID = $(".textarea_price_editor").attr("id");
                    $("#" + $editorID).isoTextAreaFull();
                    vietiso_loading(0);
                },
            });
            return false;
        });
        $(document).on("click", ".clickDeleteTourOption", function (ev) {
            if (confirm(confirm_delete)) {
                vietiso_loading(1);
                var $_this = $(this);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=" +
                        mod +
                        "&act=ajLoadListTourOption",
                    data: {
                        tour_option_id: $_this.attr("tour_option_id"),
                        tp: "Delete",
                    },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadListTourOption();
                    },
                });
            }
            return false;
        });
    });
    function loadListSizeGroup($tour_property_id, $type) {
        vietiso_loading(1);
        var adata = {
            tour_property_id: $tour_property_id,
            type: $type,
            tp: "L",
        };
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/?mod=" +
                mod +
                "&act=ajSiteFrmTourSizeGroup",
            data: adata,
            dataType: "html",
            success: function (html) {
                var htm = html.split("$$");
                $("#tblHolderSizeGroup" + $tour_property_id).html(htm[0]);
                $("#dataTable_paginate" + $tour_property_id).html(htm[1]);
                vietiso_loading(0);
            },
        });
    }
    function loadListTourOption() {
        vietiso_loading(1);
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script + "/?mod=" + mod + "&act=ajLoadListTourOption",
            data: {
                tp: "loadList",
            },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                $("#LstTourOption").html(html);
            },
        });
    }
}

//xử lý jquery của itinerary
$(function () {
    $(document).ajaxComplete(function () {
        if ($("#tblTourItinerary").length > 0) {
            // $("#tblTourItinerary").sortable({
            //     opacity: 0.8,
            //     cursor: "move",
            //     start: function () {
            //         vietiso_loading(1);
            //     },
            //     stop: function () {
            //         vietiso_loading(0);
            //     },
            //     update: function () {
            //         var order =
            //             $(this).sortable("serialize") + "&update=update";
            //         $.post(
            //             path_ajax_script +
            //                 "/index.php?mod=tour&act=ajUpdPosTourItinerary",
            //             order,
            //             function (html) {
            //                 loadTourItinerary(tour_id);
            //                 vietiso_loading(0);
            //             },
            //         );
            //     },
            // });
        }
    });

    $(".toggle-row").click(function () {
        var $_this = $(this);
        if ($_this.parents("tr").hasClass("open_tr")) {
            $_this.closest("tr").removeClass("open_tr");
            $_this.closest("tr").find(".fa-caret").removeClass("fa-caret-up");
        } else {
            $_this.parents("tr").addClass("open_tr");
            $_this.closest("tr").find(".fa-caret").addClass("fa-caret-up");
        }
    });
    function closeDropdown(element) {
        $(element).closest(".btn-group").removeClass("open");
    }

    $(document).ready(function () {
        $(".clickEditItinerary, .clickDeleteItinerary").click(function () {
            closeDropdown(this);
        });
    });
});
