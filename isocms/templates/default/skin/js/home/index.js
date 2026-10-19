App.registerModule(function ({ container, actionRegistry, eventManager }) {
    /* ================= SERVICES ================= */

    container.register("ajaxService", {
        post: function (url, data) {
            return $.ajax({
                url: url,
                method: "POST",
                data: data,
                dataType: "html",
            });
        },
    });

    /* ================= UI SERVICE ================= */

    container.register("uiService", {
        initSelect: function () {
            if ($("#duration_id").length) {
                $("#duration_id").selectStyle({
                    width: 500,
                    height: 400,
                    theme: "light",
                });
            }

            let $departure = $("#departure_point_id");

            if ($departure.length && $departure.is("select")) {
                $departure.selectStyle({
                    width: 500,
                    height: 400,
                    theme: "light",
                });
            }
        },

        initDatepicker: function () {
            const today = new Date();

            if (LANG_ID == "en") {
                $("#header_departure_date, #header_cruise_date").datepicker({
                    dateFormat: "dd/mm/yy",
                    minDate: 1,
                });
            } else {
                $("#header_departure_date, #header_cruise_date").datepicker(
                    iso_datepicker,
                );
            }

            $("#header_departure_date, #header_cruise_date").datepicker(
                "setDate",
                today,
            );
        },
    });

    /* ================= SWIPER SERVICE ================= */

    container.register("swiperService", {
        /* ===== RETRY HELPER ===== */

        retry: function (selector, options, retry) {
            if (retry >= 15) {
                console.warn("❌ Swiper init failed:", selector);

                return;
            }

            setTimeout(() => {
                this.safeInit(selector, options, retry + 1);
            }, 300);
        },

        /* ===== SAFE INIT ===== */

        safeInit: function (selector, options, retry = 0) {
            let $el = $(selector);

            /* Element chưa có */

            if (!$el.length) {
                return this.retry(selector, options, retry);
            }

            /* Tránh init trùng */

            if ($el.hasClass("swiper-initialized")) return;

            /* Slides chưa có */

            if ($el.find(".swiper-slide").length === 0) {
                return this.retry(selector, options, retry);
            }

            /* Size chưa sẵn */

            if ($el.width() === 0 || $el.height() === 0) {
                return this.retry(selector, options, retry);
            }

            /* INIT */

            new Swiper(selector, {
                observer: true,
                observeParents: true,

                ...options,
            });
        },

        /* ===== INIT FUNCTIONS ===== */

        initItinerary: function () {
            this.safeInit(
                ".itinerary-swiper",

                {
                    loop: true,
                    speed: 800,
                    spaceBetween: 31,
                    autoHeight: true,

                    autoplay: {
                        delay: 2000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },

                    lazy: {
                        loadPrevNext: true,
                        loadOnTransitionStart: true,
                    },

                    slidesPerView: 1.2,

                    breakpoints: {
                        600: {
                            slidesPerView: 2,
                        },

                        1000: {
                            slidesPerView: 2,
                        },
                    },
                },
            );
        },

        initBanner: function () {
            this.safeInit(
                ".slider_swiper_container",

                {
                    loop: true,
                    speed: 800,
                    autoHeight: true,
                    autoplay: {
                        delay: 2000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    slidesPerView: 1,
                },
            );
        },

        initDeal: function () {
            if ($(".owl-dealcard").length > 0) {
                this.safeInit(
                    ".owl-dealcard",

                    {
                        loop: false,
                        speed: 800,
                        spaceBetween: 29,

                        navigation: {
                            nextEl: ".owl-dealcard .swiper-button-next",

                            prevEl: ".owl-dealcard .swiper-button-prev",
                        },

                        breakpoints: {
                            0: {
                                slidesPerView: 1.2,
                            },

                            600: {
                                slidesPerView: 3,
                            },

                            1000: {
                                slidesPerView: 3,
                            },
                        },
                    },
                );
            }
        },

        initOffers: function () {
            this.safeInit(".swiper-offers", {
                loop: true,
                speed: 1500,
                spaceBetween: 29,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },

                lazy: {
                    loadPrevNext: true,
                },

                navigation: {
                    nextEl: ".swiper-offers .swiper-button-next",
                    prevEl: ".swiper-offers .swiper-button-prev",
                },

                breakpoints: {
                    0: {
                        slidesPerView: 1.2,
                    },

                    600: {
                        slidesPerView: 2,
                    },

                    1000: {
                        slidesPerView: 3,
                    },
                },
            });
        },

        initAll: function () {
            this.initItinerary();
            this.initDeal();
            this.initOffers();
            this.initBanner();
        },
    });

    /* ================= ACTIONS ================= */

    actionRegistry.register(
        "home.initUI",

        function () {
            const ui = container.get("uiService");

            ui.initSelect();
            ui.initDatepicker();
        },
    );

    actionRegistry.register(
        "home.initSwiper",

        function () {
            const swiper = container.get("swiperService");

            swiper.initAll();
        },
    );

    /* ===== AJAX LOAD ===== */

    actionRegistry.register(
        "home.loadSearchForm",

        function (ctx) {
            $(".category_btnt").removeClass("active");

            $(ctx.element).addClass("active");

            let type = $(ctx.element).attr("data-id");

            const ajax = container.get("ajaxService");

            return ajax
                .post(
                    path_ajax_script +
                        "/index.php?mod=homepackage&act=ajLoadFormSearchHome&lang=" +
                        LANG_ID,

                    { type: type },
                )

                .then(function (html) {
                    $(".iso_box_search").html(html);

                    /* Re-init sau AJAX */

                    setTimeout(function () {
                        actionRegistry.executeMany([
                            "home.initUI",
                            "home.initSwiper",
                        ]);
                    }, 100);
                });
        },
    );

    actionRegistry.register(
        "home.showFloatingInput",

        function (ctx) {
            $(ctx.element)
                .parents(".iso_form_floating")
                .find("input, select")
                .show();
        },
    );

    /* ================= EVENTS ================= */

    eventManager.register({
        type: "click",
        selector: ".iso_button_search",
        action: "home.loadSearchForm",
    });

    eventManager.register({
        type: "click",
        selector: ".iso_icon_svg",
        action: "home.showFloatingInput",
    });

    /* ================= LIFECYCLE ================= */

    /* UI */

    actionRegistry.register(
        "app.ready",

        function () {
            actionRegistry.execute("home.initUI");
        },
    );

    /* SWIPER */

    actionRegistry.register(
        "app.loaded",

        function () {
            actionRegistry.execute("home.initSwiper");
        },
    );
});
