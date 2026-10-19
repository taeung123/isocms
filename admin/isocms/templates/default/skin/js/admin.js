$Core = (function ($, window, document, undefined) {
    return {
        alert: {
            error: function (msg) {
                alertify.error(msg);
            },
            success: function (msg) {
                alertify.success(msg);
            },
            confirm: function (title, message, onOk) {
                var onClose = function () {
                    if ($("#modal").is(":visible")) {
                        $("#modal").modal("hide");
                    }
                };
                modal("#modal-confirm", { title: title, message: message });
                $("#modal-confirm-ok")
                    .unbind()
                    .on("click", onOk)
                    .one("click", onClose);
            },
        },
        util: {
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
            convertTextBr: function (a) {
                return a.replace(/<br\s?\/?>/g, "\n");
            },
            nl2br: function (a) {
                var breakTag = "<br>";
                var b = a.replace(
                    /([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,
                    "$1" + breakTag + "$2",
                );
                breakTag = "<br />";
                var c = b.replace(
                    /([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,
                    "$1" + breakTag + "$2",
                );
                return c;
            },
            br2nl: function (a) {
                var b = a.replace(/<br\s?\/?>/g, "\n");
                return b.replace(/(<([^>]+)>)/gi, "");
            },
            popstate: function (name) {
                window.history.pushState(null, null, name);
                return false;
            },
            getmaxzindex: function () {
                var maxindex = 0;
                $("div").each(function () {
                    var zindex = parseInt($(this).css("z-index"));
                    if (zindex > maxindex) maxindex = zindex;
                });
                return maxindex;
            },
            getTextAreaContent: function (id) {
                if ($("#" + id).length) return tinyMCE.get(id).getContent();
                else return "";
            },
            getTinyMCEContent: function (id) {
                return tinymce.activeEditor.getContent();
            },
            setTextAreaContent: function (id, data) {
                tinyMCE.get(id).setContent(data);
                return false;
            },
            IsEmail: function (email) {
                var regex =
                    /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            },
            IsPhone: function (a) {
                var filter = /^[0-9-+]+$/;
                if (filter.test(a)) {
                    return 1;
                } else {
                    return 0;
                }
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
            isInt: function (n) {
                return Number(n) === n && n % 1 === 0;
            },
            isFloat: function (n) {
                return Number(n) === n && n % 1 !== 0;
            },
            IsNaN: function (n) {
                Number.isNaN(Number(n));
            },
            randomString: function (length) {
                var text = "",
                    possible =
                        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                for (var i = 0; i < length; i++) {
                    text += possible.charAt(
                        Math.floor(Math.random() * possible.length),
                    );
                }
                return text;
            },
            resortitem: function (classname) {
                classname = classname.replace(".", "");
                $("." + classname).each(function (e) {
                    $(this).text(e + 1);
                });
            },
            animated: function ($el, $cls) {
                $el.removeClass($cls + " animated")
                    .addClass($cls + " animated")
                    .one(
                        "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",
                        function () {
                            $(this).removeClass($cls + " animated");
                        },
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
            },
            open: function (width, height, content, name) {
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
                    var $thisPop = $("#" + name);
                    var $overflow = "auto";
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
                            ($(window).width() - $("#" + name).width()) / 2 +
                                "px",
                        )
                        .css(
                            "top",
                            ($(window).height() - $("#" + name).height()) / 2 +
                                "px",
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
    };
})(jQuery, window, document);
(function ($) {
    $.fn.extend({
        isodatepicker: function () {
            return this.each(function () {
                $(this).datepicker({
                    minDate: new Date(),
                    dateFormat: "dd-mm-yy",
                    changeMonth: true,
                    changeYear: true,
                });
            });
        },
    });
})(jQuery);
(function ($) {
    $.fn.extend({
        isopriceformat: function () {
            return this.each(function () {
                $(this).priceFormat({
                    centsLimit: "",
                });
            });
        },
    });
})(jQuery);
$().ready(function () {
    initialize();
    // ticketnotify();
    $_document.ajaxComplete(function () {
        initialize();
    });
    $(document).on('click', '.facilities_item', function (e) {
        if ($(e.target).is('input[type="checkbox"]')) {
            return;
        }
        var $checkbox = $(this).find('input[type="checkbox"]');
        $checkbox.prop('checked', !$checkbox.prop('checked')).trigger('change');
    });
    $(document).on("click", ".btn_preview_tour", async function (ev) {
        var $_this = $(this);
        let checkPublic = 1;
        ev.preventDefault();
        if ($_this.hasClass("icon_action")) {
            if (
                $_this.closest("tr").find(".SiteClickPublic").attr("rel") == "0"
            ) {
                checkPublic = 0;
            }
        } else {
            if (
                $("#online_tour").length &&
                $("#online_tour").hasClass("private_tour")
            ) {
                checkPublic = 0;
            }
            if (
                $(".box_status_switch input[name='is_online']").length &&
                !$(".box_status_switch input[name='is_online']").is(":checked")
            ) {
                checkPublic = 0;
            }
            if (
                $(".online_tour").length &&
                $(".online_tour").hasClass("private_tour")
            ) {
                checkPublic = 0;
            }
        }
        if (!checkPublic && !$(this).hasClass("delete_tour_ex")) {
            alert($_this.attr("title") + " " + alertMsgPreview);
            return false;
        } else {
            if (mod == "tour_exhautive") mod = "tour";
            if (
                typeof mod !== "undefined" &&
                typeof pvalTable !== "undefined" &&
                act != "default"
            ) {
                const data = { table: mod, id: pvalTable };
                try {
                    const link = await $.post(
                        `${path_ajax_script}/index.php?mod=home&act=updateLinkPreview&lang=${LANG_ID}`,
                        data,
                    );
                    $_this.attr("href", link);
                } catch (error) {
                    console.log(error);
                    alertify.error("error");
                }
            }
            if ($_this.attr("href")) window.open($_this.attr("href"));
            else if ($_this.data("href")) window.open($_this.data("href"));
        }
    });

    $_document.on("change", 'input[name="is_online"]', function () {
        var $_this = $(this).closest(".switch_public");
        var $lbl_switch = $(".box_status_switch").find(".txt_status_switch");
        if ($_this.find("input[name='is_online']").is(":checked")) {
            var is_online = 1;
            $("input[name='is_online']").prop("checked", true);
        } else {
            var is_online = 0;
            $("input[name='is_online']").prop("checked", false);
        }
        var adata = {};
        adata["clsTable"] = $_this.data("clstable");
        adata["pkey"] = $_this.data("pkey");
        adata["pvalTable"] = $_this.data("sourse_id");
        adata["toField"] =
            $_this.attr("toField") != undefined
                ? $_this.attr("toField")
                : "is_online";
        adata["val"] = parseInt(is_online);
        adata["allowDuplicate"] = 1;
        if (is_online == 1) {
            $lbl_switch
                .addClass("public")
                .removeClass("private")
                .text(txtPublic);
        } else {
            $lbl_switch
                .addClass("private")
                .removeClass("public")
                .text(txtPrivate);
        }
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=home&act=saveField",
            data: adata,
            dataType: "html",
            success: function (html) {},
        });
    });
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
        },
    );
    $_document.on(
        "keyup",
        "input[type=number],.numberonly:not(.allotment)",
        function (event) {
            var _value = $(this).val();
            if ($Core.util.isEmpty(_value)) {
                $(this).val(0);
            }
        },
    );
    $(window).load(function () {
        $("#ajax_loading").fadeOut(1600);
    });
    if ($(".input-bind__counter").length) {
        $(".input-bind__counter").each(function () {
            //$(this).trigger('keyup');
        });
    }
    $_document.on("click", ".SiteClickPublic", function (ev) {
        ev.preventDefault();
        var $_this = $(this);
        if ($_this.data("public-status-busy")) {
            return false;
        }
        $_this.data("public-status-busy", true)
            .data("public-original-icon-class", $_this.find("i").attr("class") || "")
            .addClass("is-loading")
            .attr("aria-busy", "true");

        var
            $_rel = $_this.attr("rel"),
            pkey = $_this.attr("pkey"),
            clsTable = $_this.attr("clsTable"),
            pvalTable = $_this.attr("sourse_id"),
            toField = $_this.hasAttr("toField")
                ? $_this.attr("toField")
                : "is_online";

        var $_adata = {};
        $_adata["pkey"] = pkey;
        $_adata["toField"] = toField;
        $_adata["clsTable"] = clsTable;
        $_adata["pvalTable"] = pvalTable;
        $_adata["val"] = parseInt($_rel) == 0 ? 1 : 0;
        $_adata["allowDuplicate"] = 1;
        // Disable ngay khi bắt đầu AJAX
        $_this.prop("disabled", true);
        $.ajax({
            type: "POST",
            data: $_adata,
            dataType: "html",
            url: path_ajax_script + "/index.php?mod=home&act=saveField",
            beforeSend: function () {
                $_this
                    .find("i")
                    .attr(
                        "class",
                        "fa-sharp-duotone fa-solid fa-spinner-third fa-spin",
                    );
            },
            success: function (html) {
                var nextRel = parseInt($_rel) == 1 ? 0 : 1;
                //console.log('nextRel:', nextRel);
                if (parseInt($_rel) == 1) {
                    $_this
                        .find("i")
                        .attr("class", "fa-solid fa-circle-minus red");
                    $_this.attr("rel", 0);
                    // Bỏ checked checkbox 
                    $_this.prop("checked", false);
                    $_this.find('span.tm-text').text('Inactive');
                    $('.SiteClickPublic').prop("checked", false);
                    $('.tm-status-pill').removeClass("tm-status-pill--inactive tm-status-pill--active").addClass("tm-status-pill--inactive");
                    $('.tm-status-pill i').removeClass("fa-circle-minus fa-circle-check").addClass("fa-circle-minus");
                    $_this.removeClass("tm-status-badge-btn--active tm-status-badge-btn--inactive").addClass("tm-status-badge-btn--inactive");
                } else {
                    $_this.find('span.tm-text').text('Active');
                    $_this
                        .find("i")
                        .attr("class", "fa-solid fa-circle-check green");
                    $_this.attr("rel", 1);
                    // Checked checkbox 
                   $_this.prop("checked", true);
                   $('.SiteClickPublic').prop("checked", true);
                   $('.tm-status-pill').removeClass("tm-status-pill--inactive tm-status-pill--active").addClass("tm-status-pill--active");
                   $('.tm-status-pill i').removeClass("fa-circle-minus fa-circle-check").addClass("fa-circle-check");
                   $_this.removeClass("tm-status-badge-btn--active tm-status-badge-btn--inactive").addClass("tm-status-badge-btn--active");
                }

                if (toField === "is_online") {
                    var $_tr = $_this.closest("tr");
                    var $_heading = $_tr.find(".v2-heading-group, .list-table-v2-wrap, .list-table-heading, .tour-name-wrap, .blog-name-wrap, .hotel-name-wrap, .cruise-name-wrap").first();
                    if ($_heading.length === 0) {
                        $_heading = $_tr.find(".list-table-v2-name, td:eq(2)");
                    }

                    var isBlog = (clsTable === "Blog" || (typeof mod !== "undefined" && mod === "blog"));
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
                 // AJAX xong thì enable lại
                $_this.prop("disabled", false);
            },
        });
        return false;
    });
    $_document.on("click", ".close_pop", function () {
        var _thispop = $(this).closest(".modal-form");
        $Core.popup.close(_thispop);
        return false;
    });
    $_document.on(
        "click",
        ".close:not(.inpopover), button[data-dismiss=modal]",
        function () {
            var _thispop = $(this).closest(".modal"),
                _id = _thispop.attr("id");
            if (_id !== "modal") {
                $Core.popup.close(_thispop);
                return false;
            }
        },
    );
    $_document.on("click", ".deleteItemImage", function (ev) {
        if (confirm(confirm_delete)) {
            var _this = $(this),
                pvalTable = _this.attr("pvalTable"),
                clsTable = _this.attr("clsTable"),
                $_adata = { pvalTable: pvalTable, clsTable: clsTable };

            vietiso_loading(1);
            $.post(
                path_ajax_script + "/index.php?mod=home&act=ajDeleteItemImage",
                $_adata,
                function () {
                    vietiso_loading(0);
                    _this.closest(".image").find("img").attr("src", "");
                    _this
                        .closest(".image")
                        .find("input[name=isoman_url_image]")
                        .val("");
                    _this.remove();
                },
            );
        }
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
    $_document.on("click", function (e) {
        if (
            !$(".dropdown.mega-dropdown:not(.noclickable)").is(e.target) &&
            $(".dropdown.mega-dropdown:not(.noclickable)").has(e.target)
                .length === 0 &&
            $(".open:not(.noclickable)").has(e.target).length === 0
        ) {
            $(".dropdown.mega-dropdown:not(.noclickable)").removeClass("open");
        }
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
        window.location.href = $_this.data("url").toString();
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
    if ($("#isotabs").length > 0) {
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
                console.log(html);
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


    // Check / uncheck tất cả
    $(document).on("click", "#check_all", function () {
        const isChecked = this.checked;
        $(".chkitem[type='checkbox']").each(function () {
            this.checked = isChecked;
        });

        setList();
    });


    $(document).on("change", ".chkitem[type='checkbox']", function () {
        setList();
    });


    function setList() {
        const $checkboxes = $(".chkitem[type='checkbox']");
        const $checkedItems = $checkboxes.filter(":checked");
        const numberChecked = $checkedItems.length;
        const totalItems = $checkboxes.length;
        // console.log("Total:", totalItems);
        // console.log("Checked:", numberChecked);
        // Đồng bộ Check All
        const isCheckAll =
            totalItems > 0 &&
            numberChecked === totalItems;

        // Dùng DOM trực tiếp
        $("#check_all").prop("checked", isCheckAll);
        $("#all_check").prop("checked", isCheckAll);

        // Danh sách ID được chọn
        const listSelected = $checkedItems
            .map(function () {
                return this.value;
            })
            .get()
            .join("|");

        $("#list_selected_chkitem").val(
            listSelected ? listSelected + "|" : ""
        );

        $(".btn-delete-all").toggle(numberChecked > 0);
    }



    $_document.on("click", "#" + "all_check", function () {
        var rel = $(this).attr("rel"),
            chk = $(this).is(":checked");
        if (rel) {
            $("." + rel).prop("checked", chk);
        }
    });
    $("input[name=config_value_title]").on("keyup", function (e) {
        e.stopImmediatePropagation();
        var _this = $(this),
            clsTable = _this.attr("clsTable"),
            pvalTable = _this.attr("pvalTable"),
            char_lenth = _this.val().length;
        $(".title-counter__charactor").text(char_lenth);
        load_preview_search(clsTable, pvalTable);
    });
    $("textarea[name=config_value_intro]").on(
        "keyup",
        $Core.util.delay(function (e) {
            e.preventDefault();
            var _this = $(this),
                clsTable = _this.attr("clsTable"),
                pvalTable = _this.attr("pvalTable"),
                char_length = _this.val().length;

            $(".description-counter__charactor").text(char_length);
            load_preview_search(clsTable, pvalTable);
        }, 100),
    );


});
!(function ($) {
    $.fn.hasAttr = function (name) {
        return this.attr(name) !== undefined;
    };
})(jQuery);
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
            null,
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
        $("#" + tabid + "_ul li.tabs_child_" + tabid).removeClass(
            "tabselected",
        );
        $(this).addClass("tabselected");
        $(".tabboxchild_" + tabid).hide();
        $("#show" + elid).show();
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
    $(".isotabbox").css("display", "none");
    $_document.on("click", "#isotabs .tab", function (ev) {
        var tabid = $(this).attr("id");
        $("#isotabs .tab").removeClass("tabselected");
        if ($("#" + tabid + "box").is(":visible")) {
            $("#" + tabid + "box").hide();
        } else {
            $(".isotabbox").hide();
            $("#" + tabid + "box").show();
            $("#isotabs #" + tabid).addClass("tabselected");
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
function getmaxzindex() {
    return $Core.util.getmaxzindex();
}
function makepopup(width, height, content, name) {
    $Core.popup.open(width, height, content, name);
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
                ($(window).height() - $("#" + name).height()) / 2 - 20 + "px",
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
            ($(window).height() - $("#" + name).height()) / 2 - 20 + "px",
        )
        .addClass("stacked");
}
function vietiso_loading($show) {
    if ($show == 1) {
        $("#ajax_loading").fadeIn(400);
    }
    if ($show == 0) {
        $("#ajax_loading").fadeOut(1600);
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
                .replace(/<br\s?\/?>/g, "\n"),
        );
    });
}
function _reload() {
    $("#searchbtn").trigger("click");
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
function showSeo(_this) {
    $(_this).addClass("hidden");
    $(".seo-section").removeClass("hidden");
}
function load_preview_search(clsTable, pvalTable) {
    var config_link = $("input[name=config_link]").val(),
        config_value_title = $("input[name=config_value_title]").val(),
        config_value_intro = $("textarea[name=config_value_intro]").val(),
        $_adata = {
            clsTable: clsTable,
            pvalTable: pvalTable,
            config_link: config_link,
            config_value_title: config_value_title,
            config_value_intro: config_value_intro,
        };
    $.post(
        path_ajax_script + "/index.php?mod=home&act=load_preview_search",
        $_adata,
        function (html) {
            $(".holderPrevSeo").html(html);
        },
    );
}
function modal() {
    /* check if the modal not visible, show it */
    if (!$("#modal").is(":visible")) $("#modal").modal("show");
    /* update the modal-content with the rendered template */
    $("#modal .modal-content:last").html(
        render_template(arguments[0], arguments[1]),
    );
    /* initialize modal if the function defined (user logged in) */
}
/** render template */
function render_template(selector, options) {
    var template = $(selector).html();
    Mustache.parse(template);
    var rendered_template = Mustache.render(template, options);
    return html_entity_decode(rendered_template);
}
function html_entity_decode(str) {
    var ta = document.createElement("textarea");
    ta.innerHTML = str.replace(/</g, "&lt;").replace(/>/g, ">");
    toReturn = ta.value;
    ta = null;
    return toReturn;
}
function initialize() {
    if ($('[data-toggle="tooltip"]').length) {
        $('[data-toggle="tooltip"]').tooltip({});
    }
    if ($(".datepicker:not(.hasDatepicker)").length) {
        $(".datepicker:not(.hasDatepicker)").datepicker(crm_datepicker_format);
    }
    if ($(".isodatepicker:not(.hasDatepicker)").length) {
        $(".isodatepicker:not(.hasDatepicker)").datepicker(
            crm_datepicker_format,
        );
    }
    /*if($('textarea.form-control:not(.striped)').length){
		$('textarea.form-control:not(.striped)').each(function(){
			var _this = $(this);
			_this.addClass('striped').val($Core.util.convertTextBr(_this.val()));
		})
	}*/
    $(".js_scroller").each(function () {
        var _this = $(this);
        /* return if the plugin already running  */
        if (_this.parent(".slimScrollDiv").length > 0) {
            return;
        }
        /* run if not */
        _this.slimScroll({
            height: _this.attr("data-slimScroll-height") || "200px",
            start: _this.attr("data-slimScroll-start") || "top",
            distance: "2px",
        });
    });
    if ($(".price-In").length) {
        $(".price-In").priceFormat({
            thousandsSeparator: ".",
            centsLimit: 0,
        });
    }
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
            "animate",
        );
    });
    /** Timepicker */
    if ($(".timepicker:not(.ui-timepicker-input)").length) {
        $(".timepicker:not(.ui-timepicker-input)")
            .addClass("ui-timepicker-input")
            .timepicker({
                step: 15,
                timeFormat: "h:i A",
                forceRoundTime: true,
            });
    }
    if ($(".datepicker:not(.hasDatepicker)").length) {
        $(".datepicker:not(.hasDatepicker)").datepicker({
            dateFormat: "dd/mm/yy",
            minDate: new Date(),
        });
    }
    /* End */
    if ($(".textarea_intro_editor:not(.isoTextArea)").length > 0) {
        $(".textarea_intro_editor:not(.isoTextArea)").each(function () {
            var editorId = $(this).attr("id");
            $("#" + editorId)
                .addClass("isoTextArea")
                .isoTextArea();
        });
    }
    if ($(".textarea_intro_editor_full:not(.isoTextArea)").length > 0) {
        $(".textarea_intro_editor_full:not(.isoTextArea)").each(function () {
            var editorId = $(this).attr("id");
            $("#" + editorId)
                .addClass("isoTextArea")
                .isoTextAreaFull();
        });
    }

    if ($(".isoTextArea:not(.textarea_intro_editor)").length > 0) {
        $(".isoTextArea:not(.textarea_intro_editor)").each(function () {
            var editorId = $(this).attr("id");
            $("#" + editorId)
                .addClass("textarea_intro_editor")
                .isoTextArea();
        });
    }
    if ($(".iso-selectize:not(.selectized)").length) {
        $(".iso-selectize").addClass("selectized").selectize({
            create: false,
        });
    }
    if ($(".iso-selectizeNotSearch:not('.selectized')").length) {
        $(".iso-selectizeNotSearch:not(.selectized)").each(function () {
            var $_this = $(this),
                ajax_url = $_this.data("url"),
                optgroup = $_this.data("optgroup");

            var options = {};
            $self = $_this.addClass("selectized").selectize(
                $.extend(options, {
                    valueField: "id",
                    labelField: "text",
                    searchField: "text",
                    create: false,
                    preload: true,
                    load: function (query, callback) {
                        var self = $(this);
                        $.ajax({
                            url: ajax_url,
                            type: "GET",
                            dataType: "json",
                            cache: true,
                            error: function () {
                                callback();
                            },
                            success: function (res) {
                                callback(res);
                            },
                        });
                    },
                }),
            );
        });
    }
    if ($(".iso-selectizeLiveSearch:not(.selectized)").length) {
        $(".iso-selectizeLiveSearch:not(.selectized)").each(function () {
            var $_this = $(this),
                ajax_url = $(this).data("url");
            $_this.addClass("selectized").selectize({
                valueField: "id",
                labelField: "text",
                searchField: "text",
                create: false,
                preload: true,
                load: function (query, callback) {
                    if (!query.length) return callback();
                    $.ajax({
                        url: ajax_url,
                        type: "GET",
                        dataType: "json",
                        data: { keysearch: query },
                        delay: 250,
                        cache: true,
                        error: function () {
                            callback();
                        },
                        success: function (res) {
                            callback(res);
                        },
                    });
                },
            });
        });
    }
}
/** Delete Global */
function delete_globe(_this) {
    var pkey = $(_this).attr("pkey"),
        pval_id = $(_this).attr("pval_id"),
        clsTable = $(_this).attr("clsTable"),
        return_url = $(_this).attr("return_url"),
        $_adata = { pval_id: pval_id, pkey: pkey, clsTable: clsTable };

    $Core.alert.confirm(
        "Xác nhận xóa",
        "Bạn có chắc chắn muốn xóa nội dung này. Việc chấp nhận xóa có thể sẽ không thể khôi phục lại",
        function () {
            $.post(
                path_ajax_script + "/index.php?mod=ajax&act=delete_blobe",
                $_adata,
                function (html) {
                    if (html.indexOf("_success") >= 0) {
                        window.location.href =
                            return_url + "&message=DeleteSuccess";
                    }
                },
            );
        },
    );
    return false;
}
/** Property */
function load_list_property(property_type, options) {
    var $_adata = options || {};
    $_adata["property_type"] = property_type;
    vietiso_loading(loading);
    $.post(
        path_ajax_script + "/index.php?mod=ajax&act=load_list_property",
        $_adata,
        function (html) {
            vietiso_loading(0);
            $(".holderPropertyType_" + property_type).html(html);
            $(".TableListProperty_" + property_type + " tbody")
                .sortable({
                    connectWith: ".TableListProperty_" + property_type,
                    handle: ".mySortableHandler",
                    update: function (event, ui) {
                        var orderNo = $(this).sortable("toArray"),
                            $_adata = { orderNo: orderNo };
                        vietiso_loading(1);
                        $.post(
                            path_ajax_script +
                                "/index.php?mod=ajax&act=save_property&action=_saveorder",
                            $_adata,
                            function (html) {
                                vietiso_loading(0);
                            },
                        );
                    },
                })
                .disableSelection();
        },
    );
}
/** Property */
function load_saveorder_menu(menu_id, options) {
    var $_adata = options || {};
    $_adata["menu_id"] = menu_id;
    vietiso_loading(loading);
    $(".TableListMenu_" + menu_id + "")
        .sortable({
            connectWith: ".TableListMenu_" + menu_id,
            handle: ".mySortableHandler",
            update: function (event, ui) {
                var orderNo = $(this).sortable("toArray"),
                    $_adata = { orderNo: orderNo, menu_id: menu_id };
                vietiso_loading(1);
                $.post(
                    path_ajax_script + "/index.php?mod=ajax&act=save_menu",
                    $_adata,
                    function (html) {
                        vietiso_loading(0);
                    },
                );
            },
        })
        .disableSelection();
}
function open_property(_this) {
    var property_id = $(_this).attr("property_id"),
        property_type = $(_this).attr("property_type"),
        $_adata = { property_id: property_id, property_type: property_type };
    vietiso_loading(1);
    $.post(
        path_ajax_script + "/index.php?mod=ajax&act=open_property",
        $_adata,
        function (html) {
            vietiso_loading(0);
            makepopup("auto", "auto", html, "open_property_" + property_type);
        },
    );
}
function save_property(_this) {
    var $_form = $(_this).closest("form"),
        property_id = $(_this).attr("property_id"),
        property_type = $(_this).attr("property_type");

    var _validated = 0;
    if ($(".input.required,select.required", $_form).length) {
        $(".input.required,select.required", $_form).each(function () {
            if ($Core.util.isEmpty($(this).val())) {
                _validated++;
                $(this).val();
                return false;
            }
        });
    }
    if (_validated == 0) {
        vietiso_loading(1);
        $_form.ajaxSubmit({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=ajax&act=save_property",
            data: { property_id: property_id, property_type: property_type },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                load_list_property(property_type, { loading: 0 });
                $Core.alert.success("Saved !");
                $Core.popup.close($_form.closest(".modal"));
            },
        });
    }
}
function delete_property(_this) {
    var property_id = $(_this).attr("property_id"),
        property_type = $(_this).attr("property_type");
    $Core.alert.confirm(
        "Xác nhận xóa",
        "Bạn có chắc chắn muốn xóa nội dung này",
        function () {
            vietiso_loading(1);
            $.post(
                path_ajax_script +
                    "/index.php?mod=ajax&act=save_property&action=_delete",
                { property_type: property_type, property_id: property_id },
                function (html) {
                    vietiso_loading(0);
                    if (html.indexOf("_invalid") >= 0) {
                        $Core.alert.error("Errors");
                    } else {
                        load_list_property(property_type, {});
                    }
                    _this.dialog("close");
                },
            );
        },
    );
}
function handler_status_property(_this) {
    var property_id = $(_this).attr("property_id"),
        property_type = $(_this).attr("property_type");
    vietiso_loading(1);
    $.post(
        path_ajax_script +
            "/index.php?mod=ajax&act=save_property&action=_delete",
        { property_type: property_type, property_id: property_id },
        function (html) {
            vietiso_loading(0);
            load_list_property(property_type, {});
        },
    );
}
/* End Property */
function get_select_city(_this) {
    var forId = $(_this).attr("forId"),
        country_id = $(_this).val(),
        $_adata = { country_id: country_id };
    $("#" + forId).html("<option>-- Loading --</option>");
    $.post(
        path_ajax_script + "/index.php?mod=ajax&act=get_select_city",
        $_adata,
        function (html) {
            $("#" + forId).html(html);
        },
    );
}
function get_select_district(_this) {
    var forId = $(_this).attr("forId"),
        city_id = $(_this).val(),
        $_adata = { city_id: city_id };
    $("#" + forId).html("<option>-- Loading --</option>");
    $.post(
        path_ajax_script + "/index.php?mod=ajax&act=get_select_district",
        $_adata,
        function (html) {
            $("#" + forId).html(html);
        },
    );
}
