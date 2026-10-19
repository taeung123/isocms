// Active menu phụ khi scroll
$(window).on("scroll", function () {
    if ($(window).width() > 992) {
        var scrollPosition = $(this).scrollTop() + 170;
    } else {
        var scrollPosition = $(this).scrollTop() + 115;
    }
    $(".hnv_scrollspy_item").each(function (index) {
        var sectionTop = $(this).offset().top;
        var sectionHeight = $(this).outerHeight();
        if (
            scrollPosition >= sectionTop &&
            scrollPosition < sectionTop + sectionHeight
        ) {
            $("ul.hnv_hotel_detail_main_nav_list .nav-link").removeClass(
                "active"
            );
            $("ul.hnv_hotel_detail_main_nav_list .nav-link")
                .eq(index)
                .addClass("active");
        }
    });
});

// Hàm scroll đến phần tử khi click thanh menu phụ
function goToByScroll(id) {
    var offsetTop;
    if ($(window).width() > 992) {
        offsetTop = $("#" + id).offset().top - 168;
    } else {
        offsetTop = $("#" + id).offset().top - 115;
    }
    $("html, body").animate(
        {
            scrollTop: offsetTop,
        },
        100
    );
}



$(".read_more_review").click(function () {
    var item_review_clone = $(this).closest(".review_item").clone();
    $("#mdReview").find(".box_content").html(item_review_clone);
    $("#mdReview").find(".content_review_short,.read_more_review").hide();
    $("#mdReview").find(".content_review_full").show();
    var bg_color = $(this)
        .closest(".review_item")
        .find(".avatar")
        .css("background-color");
    $("#mdReview").find(".avatar").css("background-color", bg_color);
});

$(document).ready(function () {
    $("ul.hnv_hotel_detail_main_nav_list .nav-link").click(function (e) {
        e.preventDefault();  
        goToByScroll($(this).attr("data-target"));
    });
    if ($(".hnv_hotel_detail_main_intro_right_bottom_list").length > 0) {
        $(".hnv_hotel_detail_main_intro_right_bottom_list").owlCarousel({
            lazyLoad: true,
            loop: false,
            margin: 26,
            nav: false,
            dots: true,
            smartSpeed: 800,
            navText: [
                "<i class='fa-solid fa-angle-left'></i>",
                "<i class='fa-solid fa-angle-right'></i>",
            ],
            merge: true,
            responsive: {
                0: {
                    items: 1,
                },
                576: {
                    items: 1,
                },
                992: {
                    items: 1,
                },
                1200: {
                    items: 1,
                },
            },
        });
    }
    if ($(".hnv_hotel_detail_main_tour_content_list").length > 0) {
        $(".hnv_hotel_detail_main_tour_content_list").owlCarousel({
            lazyLoad: true,
            loop: false,
            margin: 28,
            nav: true,
            dots: false,
            smartSpeed: 800,
            navText: [
                "<i class='fa-solid fa-angle-left'></i>",
                "<i class='fa-solid fa-angle-right'></i>",
            ],
            merge: true,
            responsive: {
                0: {
                    items: 1.2,
                    nav: false,
                },
                576: {
                    items: 2,
                },
                992: {
                    items: 3,
                },
                1200: {
                    items: 4,
                },
            },
        });
    }
    if ($(".hnv_hotel_detail_main_review_detail_content_list").length > 0) {
        $(".hnv_hotel_detail_main_review_detail_content_list").owlCarousel({
            lazyLoad: true,
            loop: false,
            margin: 33,
            nav: true,
            dots: false,
            smartSpeed: 800,
            navText: [
                "<i class='fa-solid fa-angle-left'></i>",
                "<i class='fa-solid fa-angle-right'></i>",
            ],
            merge: true,
            responsive: {
                0: {
                    items: 1.2,
                    nav: false,
                },
                576: {
                    items: 2,
                },
                992: {
                    items: 3,
                },
                1200: {
                    items: 3,
                },
            },
        });
    }
    if ($(".hnv_hotel_detail_recent_content_list").length > 0) {
        $(".hnv_hotel_detail_recent_content_list").owlCarousel({
            lazyLoad: true,
            loop: false,
            margin: 30,
            nav: true,
            dots: false,
            smartSpeed: 800,
            navText: [
                "<i class='fa-solid fa-angle-left'></i>",
                "<i class='fa-solid fa-angle-right'></i>",
            ],
            merge: true,
            responsive: {
                0: {
                    items: 1.2,
                    nav: false,
                },
                576: {
                    items: 2,
                },
                992: {
                    items: 3,
                },
                1200: {
                    items: 4,
                },
            },
        });
    }
    // Fixed navbar hotel trên đầu trang
    var nav = $("#hnv_navbar_fixed");
    var navTop = nav.offset().top;
    $(window).scroll(function () {
        if ($(window).scrollTop() >= navTop) {
            if ($(window).width() > 992) {
                nav.addClass("hnv_hotel_navbar_fixed");
                nav.removeClass("hnv_hotel_navbar_fixed_phone");
            } else {
                nav.addClass("hnv_hotel_navbar_fixed_phone");
                nav.removeClass("hnv_hotel_navbar_fixed");
            }
        } else {
            nav.removeClass(
                "hnv_hotel_navbar_fixed hnv_hotel_navbar_fixed_phone"
            );
        }
    });
    // Click phần tử trong navbar hotel thì scroll đến phần tử tương ứng
    $(".hnv_hotel_detail_main_nav_item .nav-link").click(function (e) {
        e.preventDefault();
        var target = $(this).attr("href");
        // Lấy chuỗi sau dấu thăng (#) trong URL
        var targetId = target.split("#")[1];
        var $target = $("#" + targetId);
        if ($target.length) {
            if ($(window).width() > 992) {
                $("html, body").animate(
                    {
                        scrollTop: $target.offset().top - 173,
                    },
                    500
                );
            } else {
                $("html, body").animate(
                    {
                        scrollTop: $target.offset().top - 120,
                    },
                    500
                );
            }
        }
    });
    // Click button select room thì scroll đến phần tử tương ứng
    $(".hnv_hotel_detail_intro_place_right_book").click(function (e) {
        e.preventDefault();
        var $target = $("#hnv_hotel_detail_main_room");
        if ($target.length) {
            if ($(window).width() > 992) {
                $("html, body").animate(
                    {
                        scrollTop: $target.offset().top - 173,
                    },
                    500
                );
            } else {
                $("html, body").animate(
                    {
                        scrollTop: $target.offset().top - 120,
                    },
                    500
                );
            }
        }
    });
    // Ẩn/hiện tooltip của box review bên phải
    if (
        $(".hnv_hotel_detail_main_intro_right_middle_list .fa-circle-info")
            .length > 0
    ) {
        $(
            ".hnv_hotel_detail_main_intro_right_middle_list .fa-circle-info"
        ).hover(
            function () {
                $(this)
                    .next(
                        ".hnv_hotel_detail_main_intro_right_middle_item_tooltip"
                    )
                    .fadeIn(300);
            },
            function () {
                $(this)
                    .next(
                        ".hnv_hotel_detail_main_intro_right_middle_item_tooltip"
                    )
                    .fadeOut(300);
            }
        );
    }
    // if ($('.short_content').length) {
    //     $('.short_content').each((_i, _elem) => {
    //         var _max_height = $(_elem).data('height'),
    //             _origin_height = $(_elem).outerHeight(false);
    //         if (parseInt(_max_height) < _origin_height) {
    //             $(_elem)
    //                 .height(_max_height)
    //                 .addClass('shorted')
    //                 .append('<a class="more" max_height="' + _max_height + '" onClick="toggleShorted(this,event)">' + $_View_more + '</a>');
    //         }
    //     });
    // }
});

$(function () {
    //Du lieu lay tu form
    iso_check_in = iso_check_in.replace(/\//g, "-");
    iso_check_out = iso_check_out.replace(/\//g, "-");
    let dataRoom = {
        hotel_id: hotel_id,
        check_in: iso_check_in,
        checkout: iso_check_out,
        number_rooms: iso_number_rooms,
        number_adults: iso_number_adults,
        number_child: iso_number_child,
    };

    loadRoomHotel(dataRoom);

    //Khi thay doi so phong
    function loadRoomHotel(dataRoom) {
        $.ajax({
            url:
                path_ajax_script +
                "/index.php?mod=hotel&act=loadRoomHotel&lang=" +
                LANG_ID,
            type: "POST",
            data: dataRoom,
            dataType: "html",
            success: function (html) {
                $(".hnv_hotel_detail_main_room_list").html(html);
                reloadScript(URL_JS + "/fotorama-4.6.4/fotorama.js");
            },
        });
    }

    //Load lai script
    function reloadScript(scriptUrl) {
        const script = document.createElement("script");
        script.src = scriptUrl + "?t=" + new Date().getTime();
        script.type = "text/javascript";
        document.body.appendChild(script);
    }

    //Tim kiem phong
    $(document).on("click", ".iso_btn_search", function (event) {
        event.preventDefault();

        let search_hotel_dates = $("#search_hotel_dates").val();
        search_hotel_dates = search_hotel_dates.split(" - ");
        let check_in = search_hotel_dates[0].replace(/\//g, "-");
        let check_out = search_hotel_dates[1].replace(/\//g, "-");

        let number_rooms = $('input[name="number_rooms"]').val();
        let number_adults = $('input[name="number_adults"]').val();
        let number_child = $('input[name="number_child"]').val();
        let dataRoom = {
            hotel_id: hotel_id,
            check_in: check_in,
            checkout: check_out,
            number_rooms: number_rooms,
            number_adults: number_adults,
            number_child: number_child,
        };

        loadRoomHotel(dataRoom);

        let $target = $(".hnv_hotel_detail_main_room_list");
        if ($target.length) {
            if ($(window).width() > 992) {
                $("html, body").animate(
                    {
                        scrollTop: $target.offset().top - 200,
                    },
                    500
                );
            } else {
                $("html, body").animate(
                    {
                        scrollTop: $target.offset().top - 120,
                    },
                    500
                );
            }
        }
    });

    $(document).on("click", ".iso_btn_book_rom", function (event) {
        event.preventDefault();
        let formData = $(this).parents("form").serialize();
        $.ajax({
            url:
                path_ajax_script +
                "/index.php?mod=hotel&act=BookingHotel&lang=" +
                LANG_ID,
            type: "POST",
            data: formData,
            dataType: "html",
            success: function (html) {
                location.href = html;
            },
        });
    });
});
