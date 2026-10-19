App.registerModule(function ({ container, actionRegistry }) {
    container.register(
        "layoutService",
        (function () {
            let resizeTimeout;

            function init() {
                setWidthHeightElement();
                bindResize();
                stickyBtnBottom(".btnSticky");
                isoCmsSticky();
            }

            function bindResize() {
                $(window).on("resize.layout", function () {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(setWidthHeightElement, 150);
                });
            }

            function isoCmsSticky() {
                const header = $("#isocms_header").outerHeight();
                let iso_cms_sticky = $(".iso_cms_sticky");
                if (iso_cms_sticky.length > 0) {
                    iso_cms_sticky.css({ top: `${header}px` });
                }
            }

            return { init };
        })(),
    );

    actionRegistry.register("layout.init", function () {
        container.get("layoutService").init();
    });
});

App.registerModule(function ({ container, actionRegistry }) {
    container.register(
        "countdownService",
        (function () {
            function init() {
                initLastHour();
                initCountdownTimer();
            }

            function initLastHour() {
                $(".clock_last_hour").each(function () {
                    let $_this = $(this);
                    let $_date = $_this.data("date");

                    $_this.countdown($_date, function (event) {
                        let format = "%H:%M:%S";
                        if (event.offset.totalDays > 0) {
                            format = "%D ngày " + format;
                        }
                        $_this.html(event.strftime("Còn " + format));
                    });
                });
            }

            function initCountdownTimer() {
                $(".countdown-timer").each(function () {
                    let $_this = $(this);
                    let $_date = $_this.data("date");

                    $_this.countdown($_date, function (event) {
                        $_this.html(event.strftime("%D ngày %H:%M:%S"));
                    });
                });
            }

            return { init };
        })(),
    );

    actionRegistry.register("countdown.init", function () {
        container.get("countdownService").init();
    });
});

App.registerModule(function ({ container, actionRegistry, eventManager }) {
    container.register(
        "ajaxService",
        (function () {
            function init() {
                loadTotalServiceCart();
            }

            function loadMore(ctx, moduleName) {
                let $_this = $(ctx.element);
                $_this.find(".ajax-loader").show();

                $pageLastest++;

                $.post(
                    `${path_ajax_script}/index.php?mod=${moduleName}&act=ajLoadMoreTopTourPromotion&lang=${LANG_ID}`,
                    { page: $pageLastest },
                    function (html) {
                        $_this.find(".ajax-loader").hide();
                        $(".list_tours").append(html);

                        App.dispatch("carousel.init");
                        App.dispatch("countdown.init");

                        setTimeout(loadPageShowMore, 100);
                    },
                    "html",
                );
            }

            return { init, loadMore };
        })(),
    );

    actionRegistry.register("load.more.home", function (ctx) {
        container.get("ajaxService").loadMore(ctx, "home");
    });

    actionRegistry.register("load.more.homepro", function (ctx) {
        container.get("ajaxService").loadMore(ctx, "homepro");
    });

    actionRegistry.register("load.more.package", function (ctx) {
        container.get("ajaxService").loadMore(ctx, "homepackage");
    });

    eventManager.register({
        type: "click",
        selector: "#show-more",
        action: "load.more.home",
    });

    eventManager.register({
        type: "click",
        selector: "#show-more-top-tour",
        action: "load.more.homepro",
    });

    eventManager.register({
        type: "click",
        selector: "#show-more-tour-professional",
        action: "load.more.package",
    });
});

App.registerModule(function ({ actionRegistry, eventManager }) {
    actionRegistry.register("toggle.review", function (ctx) {
        let $btn = $(ctx.element);
        $btn.toggleClass("active");
        $("#writeTourReview").toggle(500);
    });

    actionRegistry.register("require.login", function () {
        if (loggedIn != 1) {
            window.location.href =
                path_ajax_script + "tai-khoan/dang-nhap/r=" + REQUEST_URI;
        }
    });

    actionRegistry.register("wishlist.add", function (ctx) {
        let $_this = $(ctx.element);

        $.post(
            path_ajax_script + "/index.php?mod=home&act=ajUpdateWishlist",
            {
                clsTable: $_this.data("clsTable"),
                target_id: $_this.data("data"),
            },
            function (html) {
                if (html.indexOf("_EXIST") >= 0) {
                    alert("You already save this list wishlist");
                } else {
                    loadTotalWishlist(
                        $_this.data("data"),
                        $_this.data("clsTable"),
                    );
                }
            },
        );
    });

    eventManager.register({
        type: "click",
        selector: ".btn_write_review_login",
        action: "toggle.review",
    });

    eventManager.register({
        type: "click",
        selector: ".exitLogin",
        action: "require.login",
    });

    eventManager.register({
        type: "click",
        selector: ".addWishlist",
        action: "wishlist.add",
    });
});

App.registerModule(function ({ actionRegistry }) {
    actionRegistry.register("app.ready", function () {
        App.dispatch("layout.init");
        App.dispatch("carousel.init");
        App.dispatch("countdown.init");
        App.dispatch("ajax.init");
    });
});

function setWidthHeightElement() {
    var $ww = $(window).width();
    var $wc = $(".container").width();
    var $wlf = ($ww - $wc) / 2;
    var $wtopleft = $wlf + $("#logo").width();
    var $wtopright = $ww - $wtopleft;
    var $wblog = $ww / 2 - $wlf;
    var $setHeightLeft = $(".colleft_setHeight").height();
    var $w_imgtourHome = $(".TripItem .image").width();
    $("#header .bordertopLeft").width($wtopleft);
    $("#header .bordertopRight").width($wtopright);
    $(".lastterOffer .owl-carousel .owl-item.active").width($ww - $wlf - 10);
    $("#container_5 #sticky-wrapper").css({ right: $wlf });
    var $h_imgtourHome = $(".TripItem .image").height($w_imgtourHome / 1.5);
    var $destinationHeight = $(".listDestination").height();
    var $sidebarLeft = $(".sidebarLeft").height();
    if ($destinationHeight == 0) {
        $(".AZDestinationGuide").remove();
        $("#destinationAZ").remove();
    }
    if ($sidebarLeft == 0) {
        $(".destinationLink").remove();
    }
    if ($ww >= 1140) {
        $(".removeblock1140").remove();
    }
    if ($ww < 1140) {
        $(".removehidden1140").remove();
    }
    if ($ww <= 768) {
        $(".768left").remove();
        $(".lfillterDesTop").remove();
    }
    if ($ww > 768) {
        $(".lfillterMobile").remove();
    }
}

function stickyBtnBottom(btnSelector) {
    const windowWidth = $(window).width();
    const btnSticky = $(btnSelector);
    if (btnSticky.length > 0) {
        const btnStickyBottom = btnSticky.offset().top;
        $(window).scroll(function () {
            const scrollPosition = $(this).scrollTop();
            const btnStickyFixedBot = $(".btn_fixed_bot");
            if (windowWidth < 575) {
                if (scrollPosition > btnStickyBottom) {
                    btnSticky.addClass("btn_fixed_bot");
                } else {
                    btnSticky.removeClass("btn_fixed_bot");
                }
            }
        });
    }
}

function toggleContent(
    class_parent,
    class_child,
    btn = ".view_more",
    limit = 4,
) {
    $(class_parent).each(function () {
        const $parent = $(this);
        $parent.find(`${class_child}:gt(${limit})`).hide();
        if ($parent.find(class_child).length <= limit + 1) {
            $parent.find(btn).hide();
        } else if ($parent.find(btn).length === 0) {
            $parent.append(
                `<p class="view_more">${view_more} <i class="fa-light fa-angle-down"></i></p>`,
            );
        }
    });

    $(document).on("click", `${class_parent} ${btn}`, function () {
        const $_this = $(this);
        const $parent = $_this.closest(class_parent);

        if (!$_this.hasClass("less")) {
            $_this.addClass("less");
            $parent.find(class_child).show();
            $_this.html(`${view_less} <i class="fa-light fa-angle-up"></i>`);
        } else {
            $_this.removeClass("less");
            $parent.find(`${class_child}:gt(${limit})`).hide();
            $_this.html(`${view_more} <i class="fa-light fa-angle-down"></i>`);
        }
    });
}
