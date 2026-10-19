App.registerModule(function ({
    actionRegistry,
    eventManager,
    middlewareManager,
}) {
    /* ================= ACTIONS ================= */

    // 1. Close header (mobile collapse)
    actionRegistry.register("header.close", function () {
        $("#iso_navbarSupportedContent, #iso_navbar_content").collapse("hide");
    });

    // 2. Toggle language dropdown
    actionRegistry.register("header.toggleLang", function (ctx) {
        $(ctx.element).toggleClass("active");
    });

    // 3. Toggle city list
    actionRegistry.register("header.toggleCity", function (ctx) {
        $(ctx.element).closest(".dropdown-menu").addClass("show");

        $(ctx.element).siblings(".iso_city_item").toggleClass("show");
    });

    // 4. Add shadow when scroll
    actionRegistry.register("header.scrollShadow", function () {
        let scrollTop = $(window).scrollTop();

        if (scrollTop > 4) {
            $("#isocms_header").addClass("header_shadow");
        } else {
            $("#isocms_header").removeClass("header_shadow");
        }
    });

    // 5. Close lang when click outside
    actionRegistry.register("header.closeLangOutside", function (ctx) {
        if (!$(ctx.event.target).closest(".isocms_header_lang").length) {
            $(".isocms_header_lang").removeClass("active");
        }
    });

    // 6. Desktop destination dropdown
    actionRegistry.register("header.destinationHover", function (ctx) {
        let self = ctx.element;
        let dropdown_menu = $(self).parents(".dropdown-menu");

        dropdown_menu.find(".iso_lst_city").removeClass("show");
        dropdown_menu
            .find(".iso_box_destination_item, .box_collapse_item")
            .removeClass("active");

        let id = $(self).attr("data-id");

        $(self).addClass("active");
        $(`#${id}`).addClass("show");
        $(`.box_collapse_item[data-id="${id}"]`).addClass("active");
    });

    // 7. Desktop domestic dropdown
    actionRegistry.register("header.domesticHover", function (ctx) {
        let self = ctx.element;
        let type = $(self).attr("data-type");
        let dropdown_menu = $(self).parents(".dropdown-menu");

        dropdown_menu
            .find(`.iso_lst_domestic[data-type="${type}"]`)
            .removeClass("show");

        dropdown_menu
            .find(`.iso_box_domestic_item[data-type="${type}"]`)
            .removeClass("active");

        dropdown_menu.find(".box_collapse_item").removeClass("active");

        let id = $(self).attr("data-id");

        $(self).addClass("active");
        $(`#${id}`).addClass("show");
        $(`.box_collapse_item[data-id="${id}"]`).addClass("active");
    });

    // 8. Active nav item
    actionRegistry.register("header.activeNav", function (ctx) {
        $(".iso_nav_link_item").removeClass("active");
        $(".iso_nav_link_item").parents(".nav-item").removeClass("active");

        $(ctx.element).addClass("active");
        $(ctx.element).parents(".nav-item").addClass("active");
    });

    /* ================= EVENTS ================= */

    eventManager.register({
        type: "click",
        selector: ".iso_close_header",
        action: "header.close",
    });

    eventManager.register({
        type: "click",
        selector: ".isocms_header_lang",
        action: "header.toggleLang",
    });

    eventManager.register({
        type: "click",
        selector: "div.iso_city_title",
        action: "header.toggleCity",
    });

    eventManager.register({
        type: "scroll",
        selector: document,
        action: "header.scrollShadow",
    });

    eventManager.register({
        type: "click",
        selector: document,
        action: "header.closeLangOutside",
    });

    // Desktop only
    if ($(window).width() > 991) {
        eventManager.register({
            type: "mouseenter",
            selector: ".iso_box_destination_item",
            action: "header.destinationHover",
        });

        eventManager.register({
            type: "click",
            selector: ".iso_box_destination_item",
            action: "header.destinationHover",
        });

        eventManager.register({
            type: "mouseenter",
            selector: ".iso_box_domestic_item",
            action: "header.domesticHover",
        });

        eventManager.register({
            type: "click",
            selector: ".iso_box_domestic_item",
            action: "header.domesticHover",
        });

        eventManager.register({
            type: "click",
            selector: ".iso_nav_link_item",
            action: "header.activeNav",
        });
    }
});
