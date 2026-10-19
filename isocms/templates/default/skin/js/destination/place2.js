/* ================= CAROUSEL MODULE ================= */

App.registerModule(function ({ actionRegistry }) {
    function initCarousel(selector, options) {
        function tryInit(retry = 8) {
            /* Owl check */

            if (!$.fn.owlCarousel) {
                if (retry > 0) {
                    return setTimeout(function () {
                        tryInit(retry - 1);
                    }, 300);
                }

                console.warn("❌ OwlCarousel not loaded");

                return;
            }

            let $els = $(selector);

            if (!$els.length) {
                if (retry > 0) {
                    return setTimeout(function () {
                        tryInit(retry - 1);
                    }, 200);
                }

                return;
            }

            $els.each(function () {
                let $el = $(this);

                /* Prevent double init */

                if ($el.hasClass("owl-loaded")) return;

                /* Hidden fix */

                if ($el.is(":hidden")) {
                    return setTimeout(function () {
                        if (!$el.hasClass("owl-loaded")) {
                            console.log("⏳ Delayed init:", selector);

                            $el.owlCarousel(options);
                        }
                    }, 350);
                }

                console.log("✅ Init carousel:", selector);

                $el.owlCarousel(options);
            });
        }

        tryInit();
    }

    /* REGISTER ACTION */

    actionRegistry.register("carousel.init", function () {
        console.log("🚀 carousel.init running");

        const base = {
            lazyLoad: true,
            loop: false,
            margin: 26,
            dots: false,
            smartSpeed: 800,

            navText: [
                "<i class='fa-solid fa-angle-left'></i>",

                "<i class='fa-solid fa-angle-right'></i>",
            ],
        };

        initCarousel(".owl_hnv_des_attractions_info", {
            ...base,
            nav: false,
            responsive: {
                0: { items: 1.2, nav: false, merge: true },
                576: { items: 2 },
                992: { items: 3 },
                1200: { items: 4 },
            },
        });

        initCarousel(".owl_hnv_des_attractions_list", {
            ...base,
            nav: true,
            responsive: {
                0: { items: 1.2, nav: false, merge: true },
                576: { items: 2 },
                992: { items: 3 },
                1200: { items: 4 },
            },
        });

        initCarousel(".owl_hnv_des_tour_list", {
            ...base,
            nav: true,
            merge: true,
            responsive: {
                0: { items: 1.2, nav: false },
                576: { items: 2 },
                992: { items: 2 },
                1200: { items: 3 },
            },
        });

        initCarousel(".owl_hnv_des_accommodation_list", {
            ...base,
            nav: true,
            merge: true,
            responsive: {
                0: { items: 1.2, nav: false },
                576: { items: 2 },
                992: { items: 3 },
                1200: { items: 4 },
            },
        });

        initCarousel(".owl_hnv_des_cruise_list", {
            ...base,
            nav: true,
            merge: true,
            responsive: {
                0: { items: 1.2, nav: false },
                576: { items: 2 },
                992: { items: 3 },
                1200: { items: 4 },
            },
        });

        initCarousel(".owl_hnv_des_thingtodo_list", {
            ...base,
            nav: true,
            merge: true,
            responsive: {
                0: { items: 1.2, nav: false },
                576: { items: 2 },
                992: { items: 3 },
                1200: { items: 4 },
            },
        });

        initCarousel(".owl_hnv_des_destination_list", {
            ...base,
            nav: true,
            merge: true,
            responsive: {
                0: { items: 1.2, nav: false },
                576: { items: 2 },
                992: { items: 3 },
                1200: { items: 4 },
            },
        });
    });
});

/* ================= ACCOMMODATION MODULE ================= */

App.registerModule(function ({ actionRegistry, eventManager }) {
    function refresh(selector) {
        let $el = $(selector);

        if (!$el.length) return;

        if ($el.hasClass("owl-loaded")) {
            $el.trigger("refresh.owl.carousel");
        }
    }

    /* HOTEL */

    actionRegistry.register("accommodation.hotel", function (ctx) {
        $(".hnv_des_accommodation_list_option_cruise").removeClass(
            "hnv_des_accommodation_list_option_active",
        );

        $(ctx.element).addClass("hnv_des_accommodation_list_option_active");

        let dataHref = $(ctx.element).attr("data-href");

        $(".owl_hnv_des_cruise_list").fadeOut();

        $(".owl_hnv_des_accommodation_list").fadeIn(200, function () {
            refresh(".owl_hnv_des_accommodation_list");
        });

        $(".hnv_des_accommodation_link").attr("href", dataHref);
    });

    /* CRUISE */

    actionRegistry.register("accommodation.cruise", function (ctx) {
        $(".hnv_des_accommodation_list_option_hotel").removeClass(
            "hnv_des_accommodation_list_option_active",
        );

        $(ctx.element).addClass("hnv_des_accommodation_list_option_active");

        let dataHref = $(ctx.element).attr("data-href");

        $(".owl_hnv_des_accommodation_list").fadeOut();

        $(".owl_hnv_des_cruise_list").fadeIn(200, function () {
            refresh(".owl_hnv_des_cruise_list");
        });

        $(".hnv_des_accommodation_link").attr("href", dataHref);
    });

    /* EVENTS */

    eventManager.register({
        type: "click",

        selector: ".hnv_des_accommodation_list_option_hotel",

        action: "accommodation.hotel",
    });

    eventManager.register({
        type: "click",

        selector: ".hnv_des_accommodation_list_option_cruise",

        action: "accommodation.cruise",
    });
});

/* ================= APP LIFECYCLE MODULE ================= */

App.registerModule(function ({ actionRegistry }) {
    /* DOM READY */

    actionRegistry.register("app.ready", function () {
        console.log("🚀 App ready");

        $(".hnv_des_accommodation_list_option_hotel").addClass(
            "hnv_des_accommodation_list_option_active",
        );
    });

    /* WINDOW LOAD */

    actionRegistry.register("app.loaded", function () {
        console.log("🌍 Window loaded");

        App.dispatch("carousel.init");

        App.dispatch("banner.sticky.init");
    });
});
