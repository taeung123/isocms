var _timeOut,
    $Core = (function ($, window, document, undefined) {
        return {
            init: function () {
                if (
                    $(".iso-selectbox:not('.select2-hidden-accessible')").length
                ) {
                    $(".iso-selectbox:not('.select2-hidden-accessible')").each(
                        function () {
                            var _this = $(this),
                                _tabindex = _this.attr("tabindex");
                            if (
                                typeof _tabindex !== "undefined" &&
                                !$Core.util.isEmpty(_tabindex)
                            ) {
                                _this
                                    .select2({})
                                    .on("select2:select", function (e) {
                                        $(this).focus();
                                    })
                                    .on("load", function (e) {
                                        $(this).prop("tabindex", _tabindex);
                                    })
                                    .trigger("load");
                            } else {
                                _this.select2({});
                            }
                        }
                    );
                }

                if ($(".chosen-select:not(.selectized)").length) {
                    $(".chosen-select").addClass("selectized").chosen({
                        width: "100%",
                    });
                }
                if ($(".selectpicker:not(.selectized)").length) {
                    $(".selectpicker").addClass("selectized").selectpicker();
                }
                if ($(".isoTextArea:not(.tinyMCE)").length) {
                    $(".isoTextArea:not(.tinyMCE)").each(function () {
                        var editorId = $.trim($(this).attr("id"));
                        $("#" + editorId)
                            .addClass("tinyMCE")
                            .isoTextAreaFull();
                    });
                }
                if ($(".textarea_intro_editor:not(.tinyMCE)").length > 0) {
                    $(".textarea_intro_editor:not(.tinyMCE)").each(function () {
                        var $_this = $(this);
                        var $editorID = $_this.attr("id");
                        $("#" + $editorID)
                            .addClass("tinyMCE")
                            .isoTextAreaFull();
                    });
                }
                if ($(".textarea_intro_editor_full:not(.tinyMCE)").length > 0) {
                    $(".textarea_intro_editor_full:not(.tinyMCE)").each(
                        function () {
                            var $_this = $(this);
                            var $editorID = $_this.attr("id");
                            $("#" + $editorID)
                                .addClass("tinyMCE")
                                .isoTextAreaFull();
                        }
                    );
                }
                if (
                    $(".textarea_intro_editor_simple:not(.tinyMCE)").length > 0
                ) {
                    $(".textarea_intro_editor_simple:not(.tinyMCE)").each(
                        function () {
                            var $_this = $(this);
                            var $editorID = $_this.attr("id");
                            $("#" + $editorID)
                                .addClass("tinyMCE")
                                .isoTextAreaSimple();
                        }
                    );
                }
                if ($(".accordion").length > 0) {
                    $(".accordion").smk_Accordion({
                        showIcon: true, //boolean
                        animation: true, //boolean
                        closeAble: false, //boolean
                        slideSpeed: 200, //integer, miliseconds
                    });
                }
                $(".price-In,.priceFormat").priceFormat({
                    thousandsSeparator: ".",
                    centsLimit: 0,
                });
                $(".price_input_booking").priceFormat({
                    thousandsSeparator: " ",
                    centsLimit: 0,
                });
                if ($(".priceFormat:not(.simple-money-format)").length) {
                    $(".priceFormat:not(.simple-money-format)")
                        .addClass("simple-money-format")
                        .simpleMoneyFormat();
                }
                if ($(".datepicker:not(.hasDatepicker)").length) {
                    $(".datepicker:not(.hasDatepicker)").datepicker({
                        minDate: new Date(),
                        changeYear: true,
                        changeMonth: true,
                        prevText: __["Prev"],
                        nextText: __["Next"],
                        dateFormat: "dd/mm/yy",
                        dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                        monthNamesShort: [
                            __["Jan"],
                            __["Feb"],
                            __["Mar"],
                            __["Apr"],
                            __["May"],
                            __["Jun"],
                            __["Jul"],
                            __["Aug"],
                            __["Sep"],
                            __["Oct"],
                            __["Nov"],
                            __["Dec"],
                        ],
                        monthNames: [
                            __["January"],
                            __["February"],
                            __["March"],
                            __["April"],
                            __["May"],
                            __["June"],
                            __["July"],
                            __["August"],
                            __["September"],
                            __["October"],
                            __["November"],
                            __["December"],
                        ],
                    });
                }
                if ($(".birthday").length) {
                    $(".birthday").datepicker({
                        minDate: new Date(1970),
                        maxDate: "+0m",
                        yearRange: "1900:2099",
                        changeYear: true,
                        changeMonth: true,
                        prevText: __["Prev"],
                        nextText: __["Next"],
                        dateFormat: "dd/mm/yy",
                        dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                        monthNamesShort: [
                            __["Jan"],
                            __["Feb"],
                            __["Mar"],
                            __["Apr"],
                            __["May"],
                            __["Jun"],
                            __["Jul"],
                            __["Aug"],
                            __["Sep"],
                            __["Oct"],
                            __["Nov"],
                            __["Dec"],
                        ],
                        monthNames: [
                            __["January"],
                            __["February"],
                            __["March"],
                            __["April"],
                            __["May"],
                            __["June"],
                            __["July"],
                            __["August"],
                            __["September"],
                            __["October"],
                            __["November"],
                            __["December"],
                        ],
                    });
                }
                $_document.on(
                    "keydown",
                    "input[type=number],.numberonly",
                    function (event) {
                        /*Allow: backspace, delete, tab, escape, and enter*/
                        if (
                            event.keyCode == 46 ||
                            event.keyCode == 8 ||
                            event.keyCode == 9 ||
                            event.keyCode == 27 ||
                            event.keyCode == 13 ||
                            event.keyCode == 188 ||
                            event.keyCode == 190 ||
                            /*Allow: Ctrl+V*/
                            (event.keyCode == 86 && event.ctrlKey === true) ||
                            /*Allow: Ctrl+C*/
                            (event.keyCode == 67 && event.ctrlKey === true) ||
                            /*Allow: Ctrl+A*/
                            (event.keyCode == 65 && event.ctrlKey === true) ||
                            /* Allow: home, end, left, right*/
                            (event.keyCode >= 35 && event.keyCode <= 39)
                        ) {
                            /*let it happen, don't do anything*/
                            return;
                        } else {
                            /*Ensure that it is a number and stop the keypress*/
                            if (
                                event.shiftKey ||
                                ((event.keyCode < 48 || event.keyCode > 57) &&
                                    (event.keyCode < 96 || event.keyCode > 105))
                            ) {
                                event.preventDefault();
                            }
                        }
                    }
                );
                if ($('[data-toggle="tooltip"]').length) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
                if ($(".isotimepicker:not(.masked)").length > 0) {
                    $(".isotimepicker:not(.masked)")
                        .addClass("masked")
                        .mask("99:99");
                }
                if ($("#v-nav>ul>li").length > 0) {
                    var items = $("#v-nav>ul>li").each(function () {
                        $(this).click(function () {
                            //remove previous class and add it to clicked tab
                            items.removeClass("current");
                            $(this).addClass("current");
                            //hide all content divs and show current one
                            //$('#v-nav>div.tab-content').hide().eq(items.index($(this))).show();

                            //$('#v-nav>div.tab-content').hide().eq(items.index($(this))).fadeIn(100);

                            $("#v-nav>div.tab-content")
                                .hide()
                                .eq(items.index($(this)))
                                .show();
                            window.location.hash = $(this).attr("tab");
                        });
                    });
                }
                if ($(".input-date-picker").length) {
                    $(".input-date-picker").each(function (_i, _elem) {
                        var _this = $(_elem);
                        $(".from_date", _this).datepicker({
                            dateFormat: "dd/mm/yy",
                            numberOfMonths: 2,
                            autoclose: true,
                            minDate: "+0D",
                            maxDate: "+1Y",
                            onClose: function (dateStr) {
                                var date = $(this).datepicker("getDate");
                                if (date) {
                                    date.setDate(date.getDate() + 1);
                                }
                                $(".to_date", _this)
                                    .datepicker("option", { minDate: date })
                                    .datepicker("setDate", date);
                                $(".to_date", _this).datepicker("show");
                            },
                        });
                        $(".to_date", _this).datepicker({
                            dateFormat: "dd/mm/yy",
                            numberOfMonths: 2,
                            minDate: new Date(),
                            maxDate: "+1Y",
                            autoclose: true,
                        });
                    });
                }
            },
            util: {
                toggleIndicatior: function (type) {
                    if (type == 1) {
                        $("#ajax_loading").stop(false, true).fadeIn();
                    }
                    if (type == 0) {
                        $("#ajax_loading").stop(false, true).fadeOut();
                    }
                },
                checkValidEmail: function (email) {
                    var re =
                        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return re.test(email);
                },
                delay: function (callback, ms) {
                    var timer = 0;
                    return function () {
                        var context = this,
                            args = arguments;
                        clearTimeout(timer);
                        timer = setTimeout(() => {
                            callback.apply(context, args);
                        }, ms || 0);
                    };
                },
                slugify(str, mark) {
                    var mark = mark || "-";
                    str = str.replace(/^\s+|\s+$/g, ""); // trim
                    str = str.toLowerCase();
                    // remove accents, swap ñ for n, etc
                    var from = "ạàáäâẹèéëêìíïîọòóöôùúüûñç·/_,:;";
                    var to = "aaaaaeeeeeiiiiooooouuuunc------";
                    for (var i = 0, l = from.length; i < l; i++) {
                        str = str.replace(
                            new RegExp(from.charAt(i), "g"),
                            to.charAt(i)
                        );
                    }
                    str = str.replace(
                        /à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,
                        "a"
                    );
                    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
                    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
                    str = str.replace(
                        /ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,
                        "o"
                    );
                    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
                    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
                    str = str.replace(/đ/g, "d");
                    str = str
                        .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
                        .replace(/\s+/g, mark) // collapse whitespace and replace by -
                        .replace(/-+/g, mark); // collapse dashes
                    return str;
                },
                isEmpty: function (value) {
                    if (!value || 0 === value.length) {
                        return true;
                    }
                    if (typeof value == "number" || typeof value == "boolean") {
                        return false;
                    }
                    if (
                        typeof value == "undefined" ||
                        value === "0" ||
                        value === null ||
                        value == "undefined"
                    ) {
                        return true;
                    }
                    if (typeof value.length != "undefined") {
                        return value.length == 0;
                    }
                    var count = 0;
                    for (var i in value) {
                        if (data.hasOwnProperty(i)) {
                            count++;
                        }
                    }
                    return count == 0;
                },
                getTextAreaContent: function (id) {
                    if ($("#" + id).length) return tinyMCE.get(id).getContent();
                    else return "";
                },
                stopEventHandler: function (e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                },
                getCheckBoxValueByClass: function (classname) {
                    var names = [];
                    $("." + classname + ":checked").each(function () {
                        names.push(this.value);
                    });
                    return names;
                },
                randomString: function (length) {
                    var text = "",
                        possible =
                            "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                    for (var i = 0; i < length; i++) {
                        text += possible.charAt(
                            Math.floor(Math.random() * possible.length)
                        );
                    }
                    return text;
                },
                animated: function ($el, $cls) {
                    $el.removeClass($cls + " animated")
                        .addClass($cls + " animated")
                        .one(
                            "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",
                            function () {
                                $(this).removeClass($cls + " animated");
                            }
                        );
                },
            },
            popup: {
                close: function (name) {
                    var _id = name.attr("id");
                    if ($("#isoblanketpop_" + _id).length) {
                        $("#isoblanketpop_" + _id).remove();
                    }
                    /* delete all events */
                    name.remove();
                    if ($(".modal.in").length == 0) {
                        $("body").removeClass("modal-open");
                    }
                },
                open: function (width, height, content, name) {
                    if ($("#" + name).length > 0) {
                    } else {
                        if (!$("body").hasClass("modal-open")) {
                            $("body").addClass("modal-open");
                        }
                        $('<div id="isoblanketpop_' + name + '">')
                            .css({
                                position: "fixed",
                                top: 0,
                                left: 0,
                                height: $_document.height(),
                                width: "100%",
                                opacity: 0.3,
                                backgroundColor: "black",
                                zIndex: "3",
                            })
                            .appendTo(document.body)
                            .addClass("stacked");
                        var html =
                            '<div id="' +
                            name +
                            '" class="modal animated bounceInDown in" style="display:none" tabindex="-1" role="dialog" aria-hidden="false">' +
                            content +
                            "</div>";
                        $(document.body).append(html);
                        var $win = $(window),
                            $thisPop = $("#" + name),
                            $overflow = "auto";
                        if ($(window).width() < 768) {
                            width = "100vw";
                            $overflow = "auto";
                        }
                        $thisPop
                            .css("position", "fixed")
                            .css("overflow", $overflow)
                            .css("z-index", "4")
                            .css(
                                "left",
                                ($win.width() - $("#" + name).width()) / 2 +
                                    "px"
                            )
                            .css(
                                "top",
                                ($win.height() - $("#" + name).height()) / 2 +
                                    "px"
                            )
                            .stop(false, true)
                            .fadeIn()
                            .find(".required:first")
                            .focus();
                        $thisPop.find("input").on("keydown", function (e) {
                            var keyCode = e.keyCode || e.which;
                            if (keyCode === 13) {
                                $(this)
                                    .closest(".modal-form")
                                    .find(".submitClick")
                                    .click();
                                return false;
                            } else if (keyCode === 27) {
                                $(this)
                                    .closest(".modal-form")
                                    .find(".close_pop")
                                    .click();
                                return false;
                            }
                        });
                    }
                },
            },
            alert: {
                alert: function (title, content) {
                    $.alert({
                        title: title,
                        content: content,
                    });
                },
                confirm: function (title, content, callback) {
                    $.confirm({
                        title: title,
                        content: content,
                        buttons: {
                            ok: function () {
                                if (typeof callback === "function") {
                                    callback();
                                } else {
                                    $Core.alert.alert(__["Message"], callback);
                                }
                            },
                            cancel: function () {
                                // close
                            },
                        },
                    });
                },
            },
        };
    })(jQuery, window, document);
$().ready(function () {
    var timer,
        timer_popup,
        timer_system_tab = "";
    $Core.init();
    $_document.ajaxComplete(function () {
        $Core.init();
    });
    $_document.on(
        "keyup",
        ".iso_search_field",
        $Core.util.delay(function () {
            var searchTxt = $(this).val().toLowerCase();
            var searchTxtSlug = $Core.util.slugify($(this).val());
            var toClass = $(this).attr("toClass");
            var hasflex = $(this).attr("hasflex");
            $("." + toClass).each(function () {
                var lstToClass = $(this).find(".iso_search_item");
                var have_result;
                lstToClass.each(function () {
                    var _this = $(this);
                    var _text = _this.text();
                    if (_text.toLowerCase().indexOf(searchTxt) != -1) {
                        have_result = 1;
                    }
                    if (_this.html().toLowerCase().indexOf(searchTxt) != -1) {
                        have_result = 1;
                    }
                    if (_this.hasAttr("slug")) {
                        var slug_item = _this.attr("slug");
                        if (slug_item.indexOf(searchTxtSlug) != -1) {
                            have_result = 1;
                        }
                    }
                });
                if (have_result == 1) {
                    if (!$Core.util.isEmpty(hasflex)) {
                        $(this).addClass("d-flex");
                    }
                    $(this).show();
                } else {
                    if (!$Core.util.isEmpty(hasflex)) {
                        $(this).removeClass("d-flex");
                    }
                    $(this).hide();
                }
            });
        }, 500)
    );
    $_document.on(
        "click",
        ".close:not(.inpopover), button[data-dismiss=modal]",
        function () {
            if (!$(this).hasClass("close_modal_booking")) {
                var _thispop = $(this).closest(".modal"),
                    _id = _thispop.attr("id");
                if (_id !== "modal") {
                    if (_id == "add_task") {
                        window.location.reload(true);
                    }
                    $Core.popup.close(_thispop);
                    return false;
                }
            }
        }
    );
    $(window).load(function () {
        $("#ajax_loading").fadeOut(1600);
    });
    $("[data-toggle=ripple]").click(function (a) {
        var i = $(this);
        0 == i.find(".material-ink").length &&
            i.prepend("<div class='material-ink'></div>");
        var t = i.find(".material-ink");
        if ((t.removeClass("animate"), !t.height() && !t.width())) {
            var e = Math.max(i.outerWidth(), i.outerHeight());
            t.css({ height: e, width: e });
        }
        var r = a.pageX - i.offset().left - t.width() / 2,
            h = a.pageY - i.offset().top - t.height() / 2,
            l = i.data("ripple-color");
        t.css({ top: h + "px", left: r + "px", background: l }).addClass(
            "animate"
        );
    });
    // System event click global.
    $(".btn-export").live("click", function () {
        if ($(this).hasClass("open")) {
            $(".dateExport").hide();
            $(this).removeClass("open");
        } else {
            $(".dateExport").show();
            $(this).addClass("open");
        }
    });
    $_document.on("click", "#searchbtn, #searchBtn", function (ev) {
        ev.preventDefault();
        $("#forums").submit();
    });
    $_document.on("click", ".ClickDistace", function (ev) {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script + "/?mod=" + mod + "&act=SiteHotelCustomField",
            data: { hotel_id: hotel_id, tp: "C" },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                loadCustomField(hotel_id);
            },
        });
        return false;
    });
    $_document.on("click", ".SiteClickPublic", function (ev) {
        ev.preventDefault();
        var $_this = $(this);
        if ($_this.data("public-status-busy")) {
            return false;
        }
        $_this.data("public-status-busy", true)
            .data("public-original-icon-class", $_this.find("i.fa").attr("class") || "")
            .addClass("is-loading")
            .attr("aria-busy", "true");
        var $_rel = $_this.attr("rel");
        var adata = {};
        adata["clsTable"] = $_this.attr("clsTable");
        adata["pkey"] = $_this.attr("pkey");
        adata["pvalTable"] = $_this.attr("sourse_id");
        adata["toField"] =
            $_this.attr("toField") != undefined
                ? $_this.attr("toField")
                : "is_online";
        adata["val"] = parseInt($_rel) == 0 ? 1 : 0;
        adata["allowDuplicate"] = 1;

        $_this.find("i.fa").attr("class", "fa fa-circle-o-notch fa-spin spin");
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=home&act=saveField",
            data: adata,
            dataType: "html",
            success: function (html) {
                $_this.find("i.fa").attr("class", "fa");
                var nextRel = parseInt($_rel) == 1 ? 0 : 1;
                //console.log('13', $_rel);
                
                if (parseInt($_rel) == 1) {
                    $_this
                        .find("i.fa")
                        .addClass("fa-minus-circle")
                        .addClass("red");
                    $_this.attr("rel", 0);
                    // Bỏ checked checkbox 
                    $_this.find('input[type="checkbox"]').prop("checked", false);
                    
                } else {
                    $_this
                        .find("i.fa")
                        .addClass("fa-check-circle")
                        .addClass("green");
                    $_this.attr("rel", 1);
                    // Checked checkbox 
                    $_this.find('input[type="checkbox"]').prop("checked", true);
                }

                if (adata["toField"] === "is_online") {
                    var $_tr = $_this.closest("tr");
                    var $_heading = $_tr.find(".v2-heading-group, .list-table-v2-wrap, .list-table-heading, .tour-name-wrap, .blog-name-wrap, .hotel-name-wrap, .cruise-name-wrap").first();
                    if ($_heading.length === 0) {
                        $_heading = $_tr.find(".list-table-v2-name, td:eq(2)");
                    }

                    var isBlog = (adata["clsTable"] === "Blog" || (typeof mod !== "undefined" && mod === "blog"));
                    var $_draftBadge = $_heading.find(".status_draft, .v2-badge--warning, .list-table-v2-badge--warning");
                    var $_privateBadge = $_heading.find(".status_private, .hotel-state--private, .v2-badge--warning.status_private, .v2-badge--primary.status_private");

                    if (nextRel === 1) {
                        $_draftBadge.remove();
                        $_privateBadge.remove();
                    } else {
                        if (isBlog) {
                            var draftLabel = (typeof txtDraft !== "undefined" && txtDraft) ? txtDraft : ((typeof lang_draft !== "undefined" && lang_draft) ? lang_draft : "Draft");
                            if ($_draftBadge.length === 0) {
                                var $_titleLink = $_heading.find(".v2-title-link, .list-table-v2-title, .list-table-title, .list-table-link, a").first();
                                var badgeHtml = '<span class="v2-badge v2-badge--warning status_draft">' + draftLabel + '</span>';
                                if ($_titleLink.length > 0) {
                                    $_titleLink.after(' ' + badgeHtml);
                                } else {
                                    $_heading.append(' ' + badgeHtml);
                                }
                            } else {
                                $_draftBadge.show();
                            }
                        } else {
                            var privateLabel = (typeof txtPrivate !== "undefined" && txtPrivate) ? txtPrivate : "Private";
                            if ($_privateBadge.length === 0) {
                                var $_titleLink = $_heading.find(".v2-title-link, .list-table-v2-title, .list-table-title, .list-table-link, a").first();
                                var badgeHtml = '<span class="v2-badge v2-badge--warning status_private">' + privateLabel + '</span>';
                                if ($_titleLink.length > 0) {
                                    $_titleLink.after(' ' + badgeHtml);
                                } else {
                                    $_heading.append(' ' + badgeHtml);
                                }
                            } else {
                                $_privateBadge.show();
                            }
                        }
                    }

                    var $tabPublish = $('a.v2-status-tab[href*="type_list=Publish"] span, a.booking-status-tab[href*="type_list=Publish"] span');
                    var $tabDraft = $('a.v2-status-tab[href*="type_list=Draft"] span, a.v2-status-tab[href*="type_list=Private"] span, a.booking-status-tab[href*="type_list=Draft"] span, a.booking-status-tab[href*="type_list=Private"] span');
                    if ($tabPublish.length && $tabDraft.length) {
                        var pubMatch = $tabPublish.text().match(/\d+/);
                        var draftMatch = $tabDraft.text().match(/\d+/);
                        var pubCount = pubMatch ? parseInt(pubMatch[0], 10) : 0;
                        var draftCount = draftMatch ? parseInt(draftMatch[0], 10) : 0;

                        if (nextRel === 1) {
                            pubCount += 1;
                            draftCount = Math.max(0, draftCount - 1);
                        } else {
                            pubCount = Math.max(0, pubCount - 1);
                            draftCount += 1;
                        }

                        $tabPublish.text('(' + pubCount + ')');
                        $tabDraft.text('(' + draftCount + ')');
                    }
                }
            },
            error: function () {
                $_this.find("i").attr("class", $_this.data("public-original-icon-class"));
            },
            complete: function () {
                $_this.removeData("public-status-busy")
                    .removeData("public-original-icon-class")
                    .removeClass("is-loading")
                    .removeAttr("aria-busy");
            },
        });
        return false;
    });

    $_document.on("click", ".SiteClickLock", function (ev) {
        var $_this = $(this);
        var $_rel = $_this.attr("rel");
        var adata = {};
        adata["clsTable"] = $_this.attr("clsTable");
        adata["pkey"] = $_this.attr("pkey");
        adata["pvalTable"] = $_this.attr("sourse_id");
        adata["toField"] =
            $_this.attr("toField") != undefined
                ? $_this.attr("toField")
                : "is_online";
        adata["val"] = parseInt($_rel) == 0 ? 1 : 0;
        adata["allowDuplicate"] = 1;

        $_this.find("i.fa").attr("class", "fa fa-circle-o-notch fa-spin spin");
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=home&act=saveField",
            data: adata,
            dataType: "html",
            success: function (html) {
                $_this.find("i.fa").attr("class", "fa");
                if (parseInt($_rel) == 0) {
                    $_this
                        .find("i.fa")
                        .addClass("fa-minus-circle")
                        .addClass("red");
                    $_this.attr("rel", 1);
                } else {
                    $_this
                        .find("i.fa")
                        .addClass("fa-check-circle")
                        .addClass("green");
                    $_this.attr("rel", 0);
                }
            },
        });
        return false;
    });

    $_document.on("click", ".confirm_delete", function (ev) {
        var $_this = $(this);
        if (confirm(confim_delete)) {
            window.location.href = $_this.attr("href");
        }
        return false;
    });
    /*$_document.on('click', '.deleteItemImage', function(ev){ 
        if(confirm(confirm_delete)){
            var _this = $(this);
            var name	= _this.data('name_input');
            var adata = {
                'pvalTable' : _this.attr('pvalTable'),
                'clsTable'	: _this.attr('clsTable'),
                'type'		: _this.data('type')
                
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:path_ajax_script+'/index.php?mod=home&act=ajDeleteItemImage',
                data: adata,
                dataType: "html",
                success: function(html){
                    vietiso_loading(0);
                    _this.closest('.image').find('img').attr("src","");
                    if(name!='' && name!='undefined'){
                      _this.closest('.image').find('input[name='+name+']').val("");
                     }else{
                       _this.closest('.image').find('input[name=isoman_url_image]').val("");
                     }
                    
                    _this.remove();
                }
            });
        }
        return false;
    });*/
    $_document.on("click", ".deleteItemImageHtml", function (ev) {
        if (confirm(confirm_delete)) {
            var _this = $(this);
            var name = _this.data("name_input");
            var adata = {
                pvalTable: _this.attr("pvalTable"),
                clsTable: _this.attr("clsTable"),
            };
            vietiso_loading(1);
            vietiso_loading(0);
            _this.closest(".image").find("img").attr("src", "");
            if (name != "" && name != "undefined") {
                _this
                    .closest(".image")
                    .find("input[name=" + name + "]")
                    .val("");
            } else {
                _this
                    .closest(".image")
                    .find("input[name=isoman_url_image]")
                    .val("");
            }
            _this.remove();
        }
        return false;
    });
    $_document.on("click", ".btn-delete-all", function (ev) {
        var $_this = $(this);
        var $listID = getCheckBoxValueByClass("chkitem");
        var $clsTable = $_this.attr("clsTable");
        if ($listID == "") {
            alertify.error(confirm_delete);
            return false;
        } else {
            if (confirm(confirm_delete)) {
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/?mod=home&act=ajDeleteMultiItem",
                    data: { listID: $listID.join("|"), clsTable: $clsTable },
                    dataType: "html",
                    success: function (html) {
                        window.location.reload();
                    },
                });
            }
        }
        return false;
    });
    $_document.on("click", ".btn_status_review", function (ev) {
        var $_this = $(this);
        var $listID = getCheckBoxValueByClass("chkitem");
        var $clsTable = $_this.attr("clsTable");
        var $val = $_this.data("value");
        if ($listID == "") {
            return false;
        } else {
            if (confirm(confirm_update_status)) {
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=home&act=ajUpdateMultiItemStatus",
                    data: {
                        listID: $listID.join("|"),
                        clsTable: $clsTable,
                        val: $val,
                    },
                    dataType: "html",
                    success: function (html) {
                        window.location.reload();
                    },
                });
            }
        }
        return false;
    });
    $_document.on("click", ".btn-delete-all-promotion-pro", function (ev) {
        var $_this = $(this);
        var $listID = getCheckBoxValueByClass("chkitem");
        var $clsTable = $_this.attr("clsTable");
        if ($listID == "") {
            alertify.error(confirm_delete);
            return false;
        } else {
            if (confirm(confirm_delete)) {
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=home&act=ajDeleteMultiItemPromotionPro",
                    data: { listID: $listID.join("|"), clsTable: $clsTable },
                    dataType: "html",
                    success: function (html) {
                        window.location.reload();
                    },
                });
            }
        }
        return false;
    });
    $_document.on("click", ".btn-delete-all-booking", function (ev) {
        var $_this = $(this);
        var $listID = getCheckBoxValueByClass("chkitem");
        var $clsTable = $_this.attr("clsTable");
        var $type = $_this.attr("type");
        if ($listID == "") {
            alertify.error(confirm_delete);
            return false;
        } else {
            if (confirm(confirm_delete)) {
                // vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=home&act=ajDeleteMultiItemBooking",
                    data: {
                        listID: $listID.join(","),
                        clsTable: $clsTable,
                        type: $type,
                    },
                    dataType: "html",
                    success: function (html) {
                        window.location.reload();
                    },
                });
            }
        }
        return false;
    });
    $_document.on("click", ".btn-delete-all-new", function (ev) {
        var $_this = $(this);
        var $listID = getCheckBoxValueByClass("chkitem");
        var $clsTable = $_this.attr("clsTable");
        if ($listID == "") {
            alertify.error(confirm_delete);
            return false;
        } else {
            if (confirm(confirm_delete)) {
                // vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=home&act=ajDeleteMultiItemNew",
                    data: { listID: $listID.join(","), clsTable: $clsTable },
                    dataType: "html",
                    success: function (html) {
                        window.location.reload();
                    },
                });
            }
        }
        return false;
    });
    $_document.on("click", ".close_pop", function (ev) {
        var id = $(this).closest(".frmPop").attr("id");
        $("#" + id).remove();
        $("#isoblanketpop_" + id).remove();
        return false;
    });
    $_document.on("click", ".close_Div", function (ev) {
        var $_this = $(this);
        $_this.closest(".autosugget").stop(false, true).slideUp();
        return false;
    });
    $("a.scroll_top").click(function () {
        if ($("body").scrollTop() > 0)
            $("body").animate({ scrollTop: 0 }, 500, "easeOutBounce");
        return false;
    });
    if (mod == "home" && act == "default" && $(".homecolumn").length > 0) {
        $(".homecolumn").sortable({
            handle: ".widget-header",
            connectWith: [".homecolumn"],
            stop: function () {
                saveHomeWidgets();
            },
        });
        $(".homewidget")
            .find(".widget-header")
            .prepend("<span class='ui-icon ui-icon-minusthick'></span>");
        $(".widget-header .ui-icon").click(function () {
            $(this)
                .toggleClass("ui-icon-minusthick")
                .toggleClass("ui-icon-plusthick");
            $(this)
                .parents(".homewidget:first")
                .find(".widget-content")
                .toggle();
        });
    }
    $_document.on("change", ".gotopage", function (ev) {
        var $_this = $(this);
        window.location.href = $_this.val().toString();
    });
    $_document.on("click", ".gotoLink", function (ev) {
        var $_this = $(this);
        window.location.href = $_this.attr("href").toString();
    });
    // End system click global

    // Sytem message notification
    if ($("#message").length > 0) {
        var $ok = true;
        if ($ok) {
            var $message_W = $("#message").outerWidth(false);
            $("#message")
                .animate({ right: 10 }, 200)
                .fadeIn()
                .delay(5000)
                .animate({ right: -$message_W }, 500);
            $ok = false;
        }
    }
    // System tab click
    if ($("#clienttabs").length > 0) {
        makeClientTab();
    }
    if ($("#clienttabsCol").length > 0) {
        makeClientTabCol();
    }
    if ($("#isotabs").length > 0) {
        var _cookie_name = "systab_" + mod + "_" + act;
        var _cookie_val = $.cookie(_cookie_name);
        clearTimeout(timer_system_tab);
        if (_cookie_val != "") {
            timer_system_tab = setTimeout(function () {
                $("#" + _cookie_val).trigger("click");
            }, 100);
        }
        makeSystemTab();
    }
    // System send feedback for admin.
    $_document.on("click", "#button_send_feedback", function (ev) {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=home&act=ajOpenFeedback",
            data: { tp: "F" },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                makepopup(600, "", html, "feedbackPop");
            },
        });
        return false;
    });
    $_document.on("click", "#send_feedback", function (ev) {
        var $_this = $(this);
        var $message_feedback = $("#message_feedback");
        if ($message_feedback.val() == "") {
            $message_feedback.focus();
            alertify.error(field_is_required);
            return false;
        }
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=home&act=ajOpenFeedback",
            data: {
                tp: "S",
                type: $("#type").val(),
                REQUEST_URI: REQUEST_URI,
                message: $message_feedback.val(),
            },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                if (html.indexOf("_SUCCESS") >= 0) {
                    alertify.success("Success !");
                    $("#feedbackPop .close_pop").trigger("click");
                } else {
                    alertify.success("Error !");
                }
            },
        });
        return false;
    });
    // System notes for personal.
    $_document.on("click", ".ajManageSystemNote", function (ev) {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=home&act=ajOpenNote",
            data: { tp: "F" },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                makepopup(600, "", html, "NotePop");
                setViewTextAreaByClass("textarea");
            },
        });
        return false;
    });
    // System checkbox list.
    $("input[id=check_all]").on("change", function (e) {
        e.preventDefault();
        var _this = $(this);
        if (_this.is(":checked")) {
            $(".chkitem").attr("checked", true);
            setList();
        } else {
            $(".chkitem").removeAttr("checked");
            setList();
        }
    });
    $(".chkitem").on("change", function (e) {
        e.preventDefault();
        setList();
    });
    $("#all_check").live("click", function () {
        var rel = $(this).attr("rel");
        var chk = $(this).is(":checked") ? 1 : 0;
        $("." + rel).each(function () {
            if (chk) {
                $(this).attr("checked", "checked");
            } else {
                $(this).removeAttr("checked");
            }
        });
    });
    $("#all_check_attr").live("click", function () {
        var rel = $(this).attr("rel");
        var chk = $(this).is(":checked") ? 1 : 0;
        $("." + rel).each(function () {
            if (chk) {
                $(this).attr("checked", "checked");
            } else {
                $(this).removeAttr("checked");
            }
        });
    });
    $(document).on("click", 'input[type="checkbox"]', function () {
        if ($(this).hasClass("fa_ge") && !$(this).is(":checked")) {
            $('input[rel="fa_ge"]#all_check').removeAttr("checked");
        }
        if ($(this).hasClass("fa_cs") && !$(this).is(":checked")) {
            $('input[rel="fa_cs"]#all_check').removeAttr("checked");
        }
        if ($(this).hasClass("fa_ac") && !$(this).is(":checked")) {
            $('input[rel="fa_ac"]#all_check').removeAttr("checked");
        }
    });
});

function saveHomeWidgets() {
    console.log("Moved !");
}

function setSelectOpen(elem) {
    if (document.createEvent) {
        var e = document.createEvent("MouseEvents");
        e.initMouseEvent(
            "mousedown",
            true,
            true,
            window,
            0,
            0,
            0,
            0,
            0,
            false,
            false,
            false,
            false,
            0,
            null
        );
        elem[0].dispatchEvent(e);
    } else if (element.fireEvent) {
        elem[0].fireEvent("onmousedown");
    }
}

function getCheckBoxValueByClass(classname) {
    var names = [];
    $("." + classname + ":checked").each(function () {
        names.push(this.value);
    });
    return names;
}

function makeGlobalTab(tabid) {
    $("#" + tabid + "_ul li").each(function (tbs) {
        $(this)
            .attr("id", "tabs_" + tabid + "_" + tbs)
            .addClass("tabs_child")
            .addClass("tabs_child_" + tabid)
            .find("a")
            .attr("href", "javascript:void();");
    });
    $("#" + tabid + "_ul li:first").addClass("tabselected");
    $(".tabboxchild_" + tabid).each(function (tbs) {
        $(this).attr("id", "showtabs_" + tabid + "_" + tbs);
    });
    $("#" + tabid + "_ul li.tabs_child_" + tabid).live("click", function () {
        var elid = $(this).attr("id");
        var tour_property_id = $(this).attr("tour_property_id");
        $("#" + tabid + "_ul li.tabs_child_" + tabid).removeClass(
            "tabselected"
        );
        $(this).addClass("tabselected");
        $(".tabboxchild_" + tabid).hide();
        $("#show" + elid).show();
        if (mod == "tour" && act == "property") {
            loadListSizeGroup(tour_property_id, "SIZEGROUP");
        }
        if (mod == "tour_exhautive" && act == "property") {
            loadListSizeGroup(tour_property_id, "SIZEGROUP");
        }
        return false;
    });
}

function makeSystemTab() {
    $("#isotabs li").each(function (tbs) {
        $(this)
            .attr("id", "isotab" + tbs)
            .addClass("tab")
            .find("a")
            .attr("data", "#isotabs" + tbs);
    });
    $(".isotabbox").each(function (tbs) {
        $(this).attr("id", "isotab" + tbs + "box");
        $(this).attr("data", tbs);
    });
    if (checkfiltertour == 1) $(".isotabbox").css("display", "block");
    else $(".isotabbox").css("display", "none");
    $_document.on("click", "#isotabs .tab", function (ev) {
        var tabid = $(this).attr("id");
        var _cookie_name = "systab_" + mod + "_" + act;
        $("#isotabs .tab").removeClass("tabselected");
        if ($("#" + tabid + "box").is(":visible")) {
            $("#" + tabid + "box").hide();
            $.cookie(_cookie_name, "");
        } else {
            $(".isotabbox").hide();
            $("#" + tabid + "box").show();
            $("#isotabs #" + tabid).addClass("tabselected");
            $.cookie(_cookie_name, tabid);
        }
        return false;
    });
    return true;
}

function makeClientTab() {
    if (!$("#clienttabs").hasClass("disabled")) {
        $("#clienttabs li").each(function (tbs) {
            $(this)
                .attr("id", "tab" + tbs)
                .addClass("tab")
                .find("a")
                .attr("data", "#isotab" + tbs);
        });
        $(".tabbox").each(function (tbs) {
            $(this).attr("id", "tab" + tbs + "box");
            $(this).attr("data", tbs);
        });
        $(".tabbox").css("display", "none");
        var selectedTab;
        $("#clienttabs .tab").live("click", function () {
            if ($(this).hasClass("disabled")) {
                return false;
            }
            if ($(this).find("a").attr("isTab") != "0") {
                var elid = $(this).attr("id");
                $(".tab").removeClass("tabselected");
                $("#" + elid).addClass("tabselected");
                if (elid != selectedTab) {
                    $(".tabbox").hide();
                    $("#" + elid + "box").show();
                    selectedTab = elid;
                }
                if ($(this).find("a").attr("submit") == "_NOT") {
                    $(".submit-buttons").hide();
                } else {
                    $(".submit-buttons").show();
                }
                var hs = $(this).find("a").attr("data");
                setTimeout(function () {
                    window.location.hash = hs;
                }, 200);
            }
            return false;
        });
        selectedTab =
            location.hash.substring(1) != ""
                ? location.hash.substring(4)
                : "tab0";
        if ($("#" + selectedTab).length == 0) selectedTab = "tab0";
        $("#" + selectedTab).addClass("tabselected");
        $("#" + selectedTab + "box").css("display", "");
        if (
            $("#" + selectedTab)
                .find("a")
                .attr("submit") == "_NOT"
        ) {
            $(".submit-buttons").hide();
        } else {
            $(".submit-buttons").show();
        }
        if (location.hash.indexOf("iso") != -1) {
            setTimeout(function () {
                window.location.hash = "iso" + selectedTab;
            }, 200);
        }
    }
}

function makeClientTabCol() {
    if (!$("#clienttabsCol").hasClass("disabled")) {
        $("#clienttabsCol li").each(function (tbs) {
            $(this)
                .attr("id", "tabcol" + tbs)
                .addClass("tabcol")
                .find("a")
                .attr("data", "#isotabCol" + tbs);
        });
        $(".tabboxcol").each(function (tbs) {
            $(this).attr("id", "tabcol" + tbs + "boxcol");
            $(this).attr("data", tbs);
        });

        var selectedTab;
        $("#clienttabsCol .tabcol").live("click", function () {
            if ($(this).hasClass("disabled")) {
                return false;
            }
            if ($(this).find("a").attr("isTab") != "0") {
                var elid = $(this).attr("id");
                $(".tabcol").removeClass("tabselected");
                $("#" + elid).addClass("tabselected");
                if (elid != selectedTab) {
                    $(".tabboxcol").hide();
                    $("#" + elid + "boxcol").show();
                    selectedTab = elid;
                }
                if ($(this).find("a").attr("submit") == "_NOT") {
                    $(".submit-buttons").hide();
                } else {
                    $(".submit-buttons").show();
                }
                var hs = $(this).find("a").attr("data");
                setTimeout(function () {
                    window.location.hash = hs;
                }, 200);
            }
            return false;
        });
        selectedTab =
            location.hash.substring(1) != ""
                ? location.hash.substring(4)
                : "tab0";
        if ($("#" + selectedTab).length == 0) selectedTab = "tabcol0";
        $("#" + selectedTab).addClass("tabselected");
        $("#" + selectedTab + "boxcol").css("display", "");
        if (
            $("#" + selectedTab)
                .find("a")
                .attr("submit") == "_NOT"
        ) {
            $(".submit-buttons").hide();
        } else {
            $(".submit-buttons").show();
        }
        if (location.hash.indexOf("iso") != -1) {
            setTimeout(function () {
                window.location.hash = "iso" + selectedTab;
            }, 200);
        }
    }
}

function getmaxzindex() {
    var maxindex = 0;
    $("div").each(function () {
        var zindex = parseInt($(this).css("z-index"));
        if (zindex > maxindex) maxindex = zindex;
    });
    return maxindex;
}

function makepopup(width, height, content, name, class_pop) {
    if ($("#" + name).length > 0) {
    } else {
        $('<div id="isoblanketpop_' + name + '">')
            .css({
                position: "fixed",
                top: 0,
                left: 0,
                height: $_document.height(),
                width: "100%",
                opacity: 0.3,
                backgroundColor: "black",
            })
            .appendTo(document.body)
            .addClass("stacked");
        $('<div id="' + name + '" class="frmPop ' + class_pop + '">')
            .appendTo(document.body)
            .html(content);
        $("#" + name)
            .css("position", "fixed")
            .css("width", width)
            .css("height", height)
            .addClass("stacked")
            .addClass("transition")
            .addClass("fadeInUp")
            .show()
            .find(".required:first")
            .focus();
    }
    $("#" + name)
        .find("input")
        .live("keydown", function (e) {
            if (e.keyCode == 13) {
                $(this).closest(".frmPop").find(".submitClick").click();
                return false;
            }
            if (e.keyCode == 27) {
                $(this).closest(".frmPop").find(".close_pop").click();
                return false;
            }
        });
    $("#" + name).draggable({
        containment: "body",
        cancel: ".form",
        handle: ".headPop",
    });
    $("#" + name).resizable();
}

function makepopupnotresize(width, height, content, name) {
    if ($("#" + name).length > 0) {
    } else {
        $('<div id="isoblanketpop_' + name + '">')
            .css({
                position: "fixed",
                top: 0,
                left: 0,
                height: $_document.height(),
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
            .css("left", ($(window).width() - $("#" + name).width()) / 2 + "px")
            .css(
                "top",
                ($(window).height() - $("#" + name).height()) / 2 - 20 + "px"
            )
            .addClass("stacked")
            .addClass("transition")
            .addClass("zoomOut")
            .show()
            .find(".required:first")
            .focus();
    }
    $("#" + name)
        .find("input")
        .live("keydown", function (e) {
            if (e.keyCode == 13) {
                $(this).closest(".frmPop").find(".submitClick").click();
                return false;
            }
            if (e.keyCode == 27) {
                $(this).closest(".frmPop").find(".close_pop").click();
                return false;
            }
        });
    $("#" + name).draggable({
        containment: "body",
        cancel: ".form",
        handle: ".headPop",
    });
}

function reinstance_makepopup(name) {
    $("#" + name)
        .css("position", "fixed")
        .css("width", width)
        .css("height", height)
        .css("left", ($(window).width() - $("#" + name).width()) / 2 + "px")
        .css(
            "top",
            ($(window).height() - $("#" + name).height()) / 2 - 20 + "px"
        )
        .addClass("stacked");
}

function vietiso_loading($show) {
    if ($show == 1) {
        $("#ajax_loading").fadeIn(200);
    }
    if ($show == 0) {
        $("#ajax_loading").fadeOut(1200);
    }
    if ($show == 2) {
        $("#ajax_loading").fadeOut(100);
    }
    if ($show == 5) {
        $("#ajax_loading").fadeOut(500);
    }
}

function checkVaidEmail(email) {
    var regex =
        /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function checkVaidUrl(url) {
    var regex =
        /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    return regex.test(url);
}

function getStats(id) {
    var body = tinymce.get(id).getBody(),
        text = tinymce.trim(body.innerText || body.textContent);
    return {
        chars: text.length,
        words: text.split(/[\w\u2019\'-]+/).length,
    };
}

function setCounter($_id, $max, $infoShow) {
    var optionsCounter = {
        maxCharacterSize: $max,
        displayFormat: "",
    };
    $_id.textareaCount(optionsCounter, function (data) {
        var result = data.input + "/" + data.max;
        $infoShow.html(result);
    });
}

function setViewTextAreaByClass($class) {
    $("." + $class).each(function () {
        $(this).val(
            $(this)
                .val()
                .replace(/<br\s?\/?>/g, "\n")
        );
    });
}

function _reload() {
    $("#searchbtn").trigger("click");
    return false;
}

function _reload2() {
    $("#findtBtn").trigger("click");
    return false;
}

function delete_cookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
}

function zCheckAll(oForm) {
    $("#" + oForm)
        .find('input[type="checkbox"]')
        .attr("checked", "checked");
}

function zUncheckAll(oForm) {
    $("#" + oForm)
        .find('input[type="checkbox"]')
        .removeAttr("checked");
}

function setList() {
    var _check_all = 1,
        _list_Id = "",
        _total_check = 0;
    $(".chkitem").each(function (_i, _elem) {
        if ($(_elem).is(":checked")) {
            _total_check += 1;
        } else {
            _check_all = 0;
        }
    });
    if (_total_check > 0) {
        $(
            ".btn-delete-all,.btn-delete-all-new,.btn-delete-all-booking,#txt_select,.btn_status_review"
        ).show();
    } else {
        $(
            ".btn-delete-all,.btn-delete-all-new,.btn-delete-all-booking,#txt_select,.btn_status_review"
        ).hide();
    }
    if (_check_all == 0) {
        $("input[id=check_all]").removeAttr("checked");
    } else {
        $("input[id=check_all]").attr("checked", "checked");
    }
    $("#number_select").text(_total_check);
}
var height = $(window).height();
$(".Review").css({ height: height });

var cookieList = function (cookieName) {
    //When the cookie is saved the items will be a comma seperated string
    //So we will split the cookie by comma to get the original array
    var cookie = $.cookie(cookieName);
    //Load the items or a new array if null.
    var items = cookie ? cookie.split(/,/) : new Array();

    //Return a object that we can use to access the array.
    //while hiding direct access to the declared items array
    //this is called closures see http://www.jibbering.com/faq/faq_notes/closures.html
    return {
        add: function (val) {
            //Add to the items.
            items.push(val);
            //Save the items to a cookie.
            //EDIT: Modified from linked answer by Nick see
            //      http://stackoverflow.com/questions/3387251/how-to-store-array-in-jquery-cookie
            $.cookie(cookieName, items.join(","));
        },
        remove: function (val) {
            //EDIT: Thx to Assef and luke for remove.
            indx = items.indexOf(val);
            if (indx != -1) items.splice(indx, 1);
            $.cookie(cookieName, items.join(","));
        },
        clear: function () {
            items = null;
            //clear the cookie.
            $.cookie(cookieName, null);
        },
        items: function () {
            //Get all the items.
            return items;
        },
    };
};

function open_texthelp(_this, e) {
    e.preventDefault();
    var key = $(_this).data("key"),
        label = $(_this).data("label");
    $.post(
        path_ajax_script + "/index.php?mod=home&act=open_texthelp",
        {
            key: key,
            label: label,
        },
        function (html) {
            makepopup(600, "", html, "open_texthelp");
        }
    );
    return false;
}

function pop_save_texthelp(_this, e) {
    e.preventDefault();
    var key = $(_this).data("key"),
        department_id = $(_this).attr("department_id");
    var _validated = 0,
        _form = $(_this).closest("form");
    var isoTextArea = _form.find(".isoTextArea");
    var editorID = isoTextArea.attr("id");
    var value = $Core.util.getTextAreaContent(editorID);

    if (_validated == 0) {
        _form.ajaxSubmit({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=home&act=pop_save_texthelp",
            data: { key: key, value: value },
            success: function (html) {
                location.reload();
            },
        });
    }
    return false;
}

function loadHelp(e) {
    var content_help = $(e).parent().find(".text_help").html();
    $(".instruction_fill_data_box .content_box").html(content_help);
}
