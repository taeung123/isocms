$(function () {
    let thumsslider = $(".thumdsslider ul");
    const image = $(".hnv_tour_detail_gallery .swiper img");
    thumsslider.height(image.height());
    thumsslider.show();
    image.on("load", function () {
        thumsslider.height(image.height());
        thumsslider.show();
    });
    const swiper = new Swiper(".hnv_tour_detail_gallery .swiper", {
        slidesPerView: 1,
        spaceBetween: 0,
        lazy: {
            loadPrevNext: true,
            loadPrevNextAmount: 2,
        },
        autoplay: {
            disableOnInteraction: true,
            pauseOnMouseEnter: true,
        },
        speed: 500,
        loop: false,
        // navigation: {
        //     nextEl: ".swiper-next",
        //     prevEl: ".swiper-prev",
        // },
        on: {
            slideChange: function (s) {
                const index = s.realIndex;
                $(".thumdsslider .active").removeClass("active");
                const activeElement = $(".thumdsslider li").eq(index);
                activeElement.addClass("active");
                // Auto scroll thumbs
                const activePosition = activeElement.position();
                const thumssliderPosition = thumsslider.position();
                const heightElement = activeElement.height();
                if (
                    activePosition.top + heightElement >
                    thumssliderPosition.top + thumsslider.height()
                ) {
                    thumsslider.scrollTop((index + 1) * activeElement.height());
                    return;
                }
                if (activePosition.top < thumssliderPosition.top) {
                    thumsslider.scrollTop(
                        (index + 1) * activeElement.height() - heightElement,
                    );
                }
            },
            resize: function () {
                thumsslider.height(image.height());
            },
        },
    });
    $(".thumdsslider li").click(function () {
        swiper.slideToLoop($(".thumdsslider li").index($(this)));
    });
    $(".thumdsslider").mouseover(function () {
        swiper.autoplay.stop();
    });
    $(".thumdsslider").mouseout(function () {
        swiper.autoplay.start();
    });

    var swiper_hnv_tour_detail_main_intro_overview_place_top_list = new Swiper(
        ".swiper_hnv_tour_detail_main_intro_overview_place_top_list",
        {
            // autoplay: {
            //     disableOnInteraction: true,
            //     pauseOnMouseEnter: true,
            // },
            // speed: 500,
            // loop: true,
            // pagination: {
            //     el: ".swiper-pagination",
            //     clickable: true,
            // },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            lazy: {
                loadPrevNext: true,
            },
            effect: "slide",
            slidesPerView: 4,
            spaceBetween: 20,
            breakpoints: {
                0: {
                    slidesPerView: 1.3,
                },
                350: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                },
            },
        },
    );
    var hnv_tour_detail_recent_content_list = new Swiper(
        ".hnv_tour_detail_recent_content_list",
        {
            // autoplay: {
            //     disableOnInteraction: true,
            //     pauseOnMouseEnter: true,
            // },
            // speed: 500,
            // loop: true,
            // pagination: {
            //     el: ".swiper-pagination",
            //     clickable: true,
            // },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            lazy: {
                loadPrevNext: true,
            },
            effect: "slide",
            spaceBetween: 30,
            breakpoints: {
                0: {
                    slidesPerView: 1.3,
                },
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                },
            },
        },
    );
    var hnv_tour_detail_related_content_list = new Swiper(
        ".hnv_tour_detail_related_content_list",
        {
            // autoplay: {
            //     disableOnInteraction: true,
            //     pauseOnMouseEnter: true,
            // },
            // speed: 500,
            // loop: true,
            // pagination: {
            //     el: ".swiper-pagination",
            //     clickable: true,
            // },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            lazy: {
                loadPrevNext: true,
            },
            effect: "slide",
            spaceBetween: 30,
            breakpoints: {
                0: {
                    slidesPerView: 1.3,
                },
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 3,
                },
            },
        },
    );

    // Scroll đến bảng giá tour
    $(".hnv_btn_scroll").click(function () {
        var offsetTop;
        if ($(window).width() > 992) {
            offsetTop =
                $(".hnv_tour_detail_main_date_availability").offset().top - 125;
        } else {
            offsetTop =
                $(".hnv_tour_detail_main_date_availability").offset().top - 72;
        }
        $("html, body").animate(
            {
                scrollTop: offsetTop,
            },
            600,
        );
    });

    function getHeaderOffset() {
        return $(window).width() > 992 ? 168 : 115;
    }

    // Hàm active menu
    function updateActiveMenu() {
        var scrollPosition = $(window).scrollTop() + getHeaderOffset() + 5;
        var $sections = $(".hnv_scrollspy_item");
        $sections.each(function () {
            var $section = $(this);
            var sectionTop = $section.offset().top;
            var sectionBottom = sectionTop + $section.outerHeight();
            if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                var sectionId = $section.attr("id");
                //console.log("Active section:", sectionId);
                // Xóa active section
                $sections.removeClass("active");
                // Active section hiện tại
                $section.addClass("active");
                // Xóa active menu
                $(".hnv_tour_detail_main_nav_list .nav-link").removeClass("active");
                // Active menu có data-target trùng với ID section
                $('.hnv_tour_detail_main_nav_list .nav-link[data-target="' + sectionId + '"]').addClass("active");
                return false;
            }
        });
    }


    // Scroll event
    $(window).on("scroll", function () {
        updateActiveMenu();
    });


    // Click menu
    $(".hnv_tour_detail_main_nav_list .nav-link").on("click", function (e) {
        e.preventDefault();
        var $this = $(this);
        var targetId = $this.data("target");
        var $target = $("#" + targetId);
        if (!$target.length) {
            console.error("Không tìm thấy section:",targetId);
            return;
        }

        // Active ngay khi click
        $(".hnv_tour_detail_main_nav_list .nav-link").removeClass("active");
        $this.addClass("active");
        // Active section
        $(".hnv_scrollspy_item").removeClass("active");
        $target.addClass("active");

        // Tính vị trí chính xác
        var targetPosition = $target.offset().top - getHeaderOffset();
        // Scroll
        $("html, body").stop().animate({scrollTop: targetPosition}, 300, function () {
                // Cập nhật lại active sau khi scroll xong
                updateActiveMenu();
            }
        );

    });

    // Kiểm tra active ngay khi load trang
    $(window).on("load", function () {
        updateActiveMenu();
    });

    // Hảm đóng/mở tất cả các accordion trong 1 button
    function toggleAllAccordion(clickElement, parentElement) {
        $(clickElement).click(function () {
            const accordionCollapse = $(this)
                .closest(parentElement)
                .find(".accordion-collapse.collapse");
            accordionCollapse.addClass("show");
            if ($(this).hasClass("expand")) {
                $(this).removeClass("expand").text(txtAccordionExpand);
                accordionCollapse.removeClass("show");
                $(this)
                    .closest(parentElement)
                    .find(".accordion-item")
                    .removeClass("hnv_expand");
                $(this)
                    .closest(parentElement)
                    .find(".accordion-button")
                    .addClass("collapsed");
            } else {
                $(this).addClass("expand").text(txtAccordionCollapse);
                accordionCollapse.addClass("show");
                $(this)
                    .closest(parentElement)
                    .find(".accordion-item")
                    .addClass("hnv_expand");
                $(this)
                    .closest(parentElement)
                    .find(".accordion-button")
                    .removeClass("collapsed");
            }
        });
    }

    toggleAllAccordion(
        ".hnv_tour_detail_main_itinerary_title_expand",
        ".hnv_tour_detail_main_itinerary",
    );
    toggleAllAccordion(
        ".hnv_tour_detail_main_useful_information_title_expand",
        ".hnv_tour_detail_main_useful_information",
    );

    // Hảm active accordion khi click
    function clickAccordion(clickElement) {
        $(clickElement).click(function () {
            var accordionButton = $(this).find(".accordion-button");
            if (accordionButton.hasClass("collapsed")) {
                $(this).removeClass("hnv_expand");
            } else {
                $(this).addClass("hnv_expand");
            }
        });
    }

    clickAccordion(".hnv_tour_detail_main_itinerary .accordion-item");
    clickAccordion(".hnv_tour_detail_main_useful_information .accordion-item");

    //
    $(document).on("click", ".trigger_contact", function () {
        $(".contact_now").trigger("click");
    });
    $(".clock").each(function () {
        var $_this = $(this);
        var $_date = $_this.data("date");
        var $promotion_id = $_this.data("promotion_id");
        $_this.countdown($_date, function (event) {
            var $this = $(this).html(
                event.strftime(
                    "" +
                        '<li><span class="days">%D</span><p class="days_text">' +
                        Days +
                        "</p></li>" +
                        '<li><span class="hours">%H</span><p class="hours_text">' +
                        Hours +
                        "</p></li>" +
                        '<li><span class="minutes">%M</span><p class="minutes_text">' +
                        Minutes +
                        "</p></li>" +
                        '<li><span class="seconds">%S</span><p class="seconds_text">' +
                        Seconds +
                        "</p></li>",
                ),
            );
        });
    });

    if (has_package) {
        function packageSelected(tour_id) {
            $.post(
                `${path_ajax_script}index.php?mod=${mod}&act=selectTourPackage&lang=${LANG_ID}`,
                { tour_id: tour_id },
                function (res) {
                    $(".htmlInclusion").html(res.htmlInclusion);
                    $(".htmlExclusion").html(res.htmlExclusion);
                    $("#hnv_tour_detail_main_date_availability").html(
                        res.htmlBoxFindTour,
                    );
                    getSelectChild = res.getSelectChild;
                    getSelectInfant = res.getSelectInfant;
                    GetMaxChildInfant(tour_id, 1);
                    GetMaxChildInfant(tour_id, 1);
                },
                "json",
            );
            /*setTimeout(function() {
                    $('#check_avaiable').trigger('click');
                }, 1000);*/
        }

        packageSelected($(".package_radio:checked").val());
        $(".package_radio").change(function () {
            let tour_id = $(this).val();
            let price = $(this)
                .closest(".package_item")
                .find(".package_price .size20.color_fb1111")
                .text();
            $(".hnv_tour_detail_gallery_right_top .size20.color_fb1111").html(
                price,
            );
            packageSelected(tour_id);
        });
    }

    function departure_date() {
        // var datet = date_range;
        var tips = ["", ""];
        var arrayable = list_start_date;

        $("#departure_date").datepicker({
            dateFormat: "DD, dd/mm/yy",
            minDate: "+1d",
            maxDate: "+1Y",
            prevText: "Trước",
            nextText: "Sau",
            currentText: "Hôm nay",
            firstDay: 1,
            monthNames: [
                January,
                February,
                March,
                April,
                May,
                June,
                July,
                August,
                September,
                October,
                November,
                December,
            ],
            dayNamesMin: [Su, Mo, Tu, We, Th, Fr, Sa],
            beforeShowDay: function (date) {
                var datestring = jQuery.datepicker.formatDate("dd/mm/yy", date);

                var aindex = $.inArray(datestring, arrayable);

                setTimeout(function () {
                    if ($check_tour_promotion == 1) {
                        appendPromotion();
                    }
                    if ($check_tour_start_date == 1) {
                        appendSeat();
                    }
                }, 10);

                if (arrayable[0] != "") {
                    if (aindex == -1)
                        return [false, "disable_day", Departure_date_invalid];
                    return [true];
                } else {
                    return [aindex == -1];
                }
            },
            onSelect: function (date) {
                loadTextDayCheckIn($(this).val());
                loadTextDayItinerary($(this).val(), $tour_id);
                var date = $(this).datepicker("getDate");
                var fomatDate = $.datepicker.formatDate("DD, dd/mm/yy", date);
                $("input[name=check_in_book]").val(fomatDate);
                $("#departure_date").attr("now_next_departure", fomatDate);
            },
        });
    }
    $(function () {
        $("input[readonly]").on("focus", function (ev) {
            $(this).trigger("blur");
        });
        departure_date();
        function appendPromotion() {
            var parElem = $("#ui-datepicker-div");
            if (!$(".note_promotion", parElem).length) {
                parElem.append(
                    "<div class='note_promotion inline-block size14'><span class='color_fb1111'>%</span> <span> " +
                        iso_promotions +
                        " </span></div>",
                );
            }
        }
        function appendSeat() {
            var parElem = $("#ui-datepicker-div");
            if (!$(".note_seat", parElem).length) {
                parElem.append(
                    "<div class='note_seat inline-block size14'><span class='note_seat_child'></span> <span>" +
                        iso_available +
                        "</span></div>",
                );
            }
            if (!$(".note_seat_disable", parElem).length) {
                parElem.append(
                    "<div class='note_seat_disable inline-block size14'><span class='note_seat_disable_child'></span> <span>" +
                        iso_not_available +
                        "</span></div>",
                );
            }
        }
    });

    $(function () {
        var $ww = $(window).width();
        if ($(".price__Box").lenth > 0) {
            var $price__BoxAZ = $(".price__Box").offset().top + 50;

            $(document).scroll(function () {
                if ($price__BoxAZ <= $(this).scrollTop()) {
                    $(".btn_box").addClass("fixed");
                } else {
                    $(".btn_box").removeClass("fixed");
                }
            });
        }

        $(document).on("click", ".repick_travellers", function () {
            $("#pick_travellers").trigger("click");
        });
        $(document).on("click", "#pick_travellers", function () {
            var $_this = $(this);
            if ($_this.hasClass("open")) {
                $("#check_number_travellers").hide();
                $_this.closest(".number_travellers").removeClass("open");
                $_this.removeClass("open");
            } else {
                $("#check_number_travellers").show();
                $_this.closest(".number_travellers").addClass("open");
                $_this.addClass("open");
            }
        });
        $(".btn_scroll ").click(function () {
            $("html, body").animate(
                {
                    scrollTop: $("#avaiable").offset().top - 111,
                },
                600,
            );
        });
        $(document).on("click", ".upNum:not(.disabled)", function () {
            var number_person = $(this).val();
            var departure_date = $("input[name=departure_date]").val();

            var traveler_type_id = $(this).attr("traveler_type_id");
            var val = parseInt($("#national_visitor" + traveler_type_id).val());
            var max_number = parseInt(
                $("#national_visitor" + traveler_type_id).attr("max-number"),
            );
            var _type = $(this).attr("_type");
            val = val + 1;
            if (val >= max_number) {
                /*$.alert({
				title: Warning,
				type: 'red',
				typeAnimated: true,
				content: Input_data_is_invalid,
			});*/
                $(this).addClass("disabled");
                val = max_number;
            }
            $(this)
                .closest(".right__inputTraveller")
                .find(".unNum")
                .removeClass("disabled");
            $("#national_visitor" + traveler_type_id).val(val);
            $("#" + _type).val(val);
            if (_type == "number_adults") {
                (($tour_id = $("#tour_id").val()),
                    GetMaxChildInfant($tour_id, val));
                $("#number_child,#number_infants").val(0);
                $("#box_group_child,#box_group_infant").html("");
            }
            // if (_type == "number_child") {
            //     $number_child =
            //         $("#box_group_child").find(".item_group_size").length;
            //     for (var i = $number_child; i < val; i++) {
            //         $("#box_group_child").append(
            //             `<div class="item_group_size">` +
            //                 getSelectChild +
            //                 `</div>`,
            //         );
            //     }
            // }
            // if (_type == "number_infants") {
            //     $number_infant =
            //         $("#box_group_infant").find(".item_group_size").length;
            //     for (var i = $number_infant; i < val; i++) {
            //         $("#box_group_infant").append(
            //             `<div class="item_group_size">` +
            //                 getSelectInfant +
            //                 `</div>`,
            //         );
            //     }
            // }
            getNumberPerson();
            return false;
        });
        $(document).on("click", ".unNum:not(.disabled)", function () {
            var number_person = $(this).val();
            var departure_date = $("input[name=departure_date]").val();
            var traveler_type_id = $(this).attr("traveler_type_id");
            var val = parseInt($("#national_visitor" + traveler_type_id).val());
            var min_number = parseInt(
                $("#national_visitor" + traveler_type_id).attr("min-number"),
            );
            var _type = $(this).attr("_type");
            val = val - 1;
            if (val <= min_number) {
                /*$.alert({
				title: Warning,
				type: 'red',
				typeAnimated: true,
				content: Input_data_is_invalid,
			});*/
                $(this).addClass("disabled");
                val = min_number;
            }
            $(this)
                .closest(".right__inputTraveller")
                .find(".upNum")
                .removeClass("disabled");
            $("#national_visitor" + traveler_type_id).val(val);
            $("#" + _type).val(val);
            if (_type == "number_adults") {
                (($tour_id = $("#tour_id").val()),
                    GetMaxChildInfant($tour_id, val));
                $("#number_child,#number_infants").val(0);
                $("#box_group_child,#box_group_infant").html("");
            }
            if (_type == "number_child") {
                $("#box_group_child")
                    .find(".item_group_size")
                    .each(function (index, element) {
                        if (index >= val) {
                            $(element).remove();
                        }
                    });
            }
            if (_type == "number_infants") {
                $("#box_group_infant")
                    .find(".item_group_size")
                    .each(function (index, element) {
                        if (index >= val) {
                            $(element).remove();
                        }
                    });
            }
            getNumberPerson();
            return false;
        });
        $(document).on("click", "#check_avaiable", function () {
            var $_this = $(this),
                $tour_id = $("#tour_id").val(),
                $number_adults = $("#number_adults").val(),
                $number_child = $("#number_child").val(),
                $number_infants = $("#number_infants").val(),
                $check_in_book = $("#check_in_book").val(),
                $departure_date =
                    $("#departure_date").attr("now_next_departure"),
                $check = 1;
            // nếu chọn tour package thì set lại tour_id
            if ($(".package_radio").length) {
                $tour_id = $(".package_radio:checked").val();
                $('input[name="tour_id"]').val($tour_id);
            }

            $("#check_number_travellers")
                .find(".slt_item_age_child")
                .each(function (index, element) {
                    if ($(element).val() == "") {
                        $(element).addClass("error");
                        $check = 0;
                    } else {
                        $(element).removeClass("error");
                    }
                });
            if ($check == 0) {
                $("#check_number_travellers").show();
                $.alert({
                    title: Warning,
                    type: "red",
                    typeAnimated: true,
                    content: Input_data_is_required,
                });
                return false;
            }
            loadTablePrice(
                $tour_id,
                $number_adults,
                $number_child,
                $number_infants,
                $check_in_book,
            );
            $("#check_number_travellers").hide();
        });
    });

    $(document).on("change", ".input_number", function () {
        var number_person = $(this).val();
        var max_person = $(this).attr("max-number");
        var departure_date = $("input[name=departure_date]").val();
        var tour_visitor_type_id = $(this).attr("tour_visitor_type_id");
        var _type = $(this).attr("_type");
        if (!isNaN(parseInt(number_person))) {
            if (
                parseInt(number_person) >= 0 &&
                parseInt(number_person) <= max_person
            ) {
                $(this).val(parseInt(number_person));

                if ($(this).hasClass("number_adults")) {
                    (($tour_id = $("#tour_id").val()),
                        GetMaxChildInfant($tour_id, parseInt(number_person)));
                    $("#number_child,#number_infants").val(0);
                }
                $("#" + _type).val(number_person);
            } else {
                $.alert({
                    title: Warning,
                    type: "red",
                    typeAnimated: true,
                    content: Input_data_is_invalid,
                });
                $(this).val(1);
                $("#" + _type).val(1);
            }
        } else {
            $.alert({
                title: Warning,
                type: "red",
                typeAnimated: true,
                content: Input_data_is_invalid,
            });

            $(this).val(1);
            $("#" + _type).val(1);
        }
        getNumberPerson();
    });
    $(document).on("change", ".select--tour__class", function () {
        var $tour__class = $(this).val();
        $("#tour__class_check").val($tour__class);
        $("#check_avaiable").trigger("click");
    });

    $(document).on("change", ".select_addon", function () {
        var adata = [];
        var $total_price_z = $("#grand_total").attr("grand_total");
        var $deposit = $("#deposit").val();
        var check_in_book = $("#check_in_book").val();
        var tour_id = $("#tour_id").val();
        $(".select_addon").each(function () {
            var $number_addon = $(this).val(),
                $addonservice_id = $(this).attr("addonservice_id");
            if ($(this).val() > 0) {
                var data = {
                    number_addon: $number_addon,
                    addonservice_id: $addonservice_id,
                };
                adata.push(data);
            }
        });
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=loadSelectAddon&lang=" +
                LANG_ID,
            data: {
                addons: adata,
                total_price_z: $total_price_z,
                deposit: $deposit,
                check_in_book: check_in_book,
                tour_id: tour_id,
            },
            dataType: "json",
            success: function (res) {
                $("#box__price__addon").html(res.html);
                $("#grand_total").html(res.grand_total);
                $("#price_deposit").val(res.price_deposit);
                $("#total_price_z").val(res.grand_total_z);
                $("#total_addon").val(res.total_addons);
            },
        });
    });
    $(document).mouseup(function (e) {
        var container = $("#check_number_travellers");
        var jconfirm_box = $(".jconfirm-open");
        var pick_travellers = $("#pick_travellers");
        if (
            !container.is(e.target) &&
            container.has(e.target).length === 0 &&
            !jconfirm_box.is(e.target) &&
            jconfirm_box.has(e.target).length === 0 &&
            !pick_travellers.is(e.target) &&
            pick_travellers.has(e.target).length === 0
        ) {
            container.hide();
            $(".number_travellers").removeClass("open");
            $(".pick_travellers").removeClass("open");
        }
    });

    function getNumberPerson() {
        var $totalAdult = 0;
        $(".number_adults").each(function () {
            $totalAdult += parseInt($(this).val());
        });
        var $totalChild = 0;
        $(".number_child").each(function () {
            $totalChild += parseInt($(this).val());
        });
        var $totalInfants = 0;
        $(".number_infants").each(function () {
            $totalInfants += parseInt($(this).val());
        });
        if ($totalChild == 0 && $totalInfants == 0) {
            $("#pick_travellers").val(Adults + " x " + $totalAdult);
        } else if ($totalChild == 0 && $totalInfants != 0) {
            $("#pick_travellers").val(
                Adults +
                    " x " +
                    $totalAdult +
                    ", " +
                    Infants +
                    " x " +
                    $totalInfants,
            );
        } else if ($totalChild != 0 && $totalInfants == 0) {
            $("#pick_travellers").val(
                Adults +
                    " x " +
                    $totalAdult +
                    ", " +
                    Children +
                    " x " +
                    $totalChild,
            );
        } else {
            $("#pick_travellers").val(
                Adults +
                    " x " +
                    $totalAdult +
                    ", " +
                    Children +
                    " x " +
                    $totalChild +
                    ", " +
                    Infants +
                    " x " +
                    $totalInfants,
            );
        }
    }

    function loadTextDayCheckIn(date) {
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=loadTextDay&lang=" +
                LANG_ID,
            data: { date: date },
            dataType: "html",
            success: function (html) {
                $("#departure_date").val(html);
                /*$("#departure_date").html(html);*/
            },
        });
    }
    function loadTextDayItinerary(date, tour_id) {
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=loadTextDayItinerary&lang=" +
                LANG_ID,
            data: { date: date, tour_id: tour_id },
            dataType: "json",
            success: function (res) {
                $(".day_Itinerary").each(function () {
                    var $itinerary_id = $(this).attr("itinerary_id");
                    $(this).html(res.list_itinerary[$itinerary_id]);
                });
            },
        });
    }
    function loadTablePrice(
        $tour_id,
        $number_adults,
        $number_child,
        $number_infants,
        $check_in_book,
    ) {
        $("#TablePrice").html(
            '<div class="lazy_loading"><img src="{/literal}{$URL_IMAGES}/icon/lazy_load_100.svg{literal}" alt=""></div>',
        );
        var $_adata = {
            tour_id: $tour_id,
            number_adults: $number_adults,
            number_child: $number_child,
            number_infants: $number_infants,
            check_in_book: $check_in_book,
        };
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=loadTablePrice&lang=" +
                LANG_ID,
            data: $("#form__avaiable").serialize(),
            dataType: "html",
            success: function (html) {
                $("#TablePrice").html(html);
            },
        });
    }
    (($tour_id = $("#tour_id").val()), GetMaxChildInfant($tour_id, 1));
    function GetMaxChildInfant($tour_id, $number_adults) {
        
        var tour_property_id = $("#li_adult").data("tour_property_id");
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=tour_new&act=ajGetMaxChildInfant&lang=" +
                LANG_ID,
            data: {
                tour_id: $tour_id,
                number_adults: $number_adults,
                tour_property_id: tour_property_id,
            },
            dataType: "json",
            success: function (json) {
                // $(".number_child.input_number").attr(
                //     "max-number",
                //     json.max_child,
                // );
                // $(".number_infants.input_number").attr(
                //     "max-number",
                //     json.max_infant,
                // );
                // $(
                //     ".number_child.input_number,.number_infants.input_number",
                // ).val(0);

                // $(".number_infants.input_number,#number_infants").val(0);
                // $(".number_infants.input_number")
                //     .closest(".right__inputTraveller")
                //     .find(".unNum")
                //     .addClass("disabled");

                // let max_child = $(".number_child.input_number").attr(
                //     "max-number",
                // );
                // let max_infant = $(".number_infants.input_number").attr(
                //     "max-number",
                // );
                // $(".number_child.input_number,.number_infants.input_number")
                //     .closest(".right__inputTraveller")
                //     .find(".unNum")
                //     .addClass("disabled");
                // if (max_child > 0) {
                //     $(".number_child.input_number")
                //         .closest(".right__inputTraveller")
                //         .find(".upNum")
                //         .removeClass("disabled");
                // } else {
                //     $(".number_child.input_number")
                //         .closest(".right__inputTraveller")
                //         .find(".upNum")
                //         .addClass("disabled");
                // }
                // if (max_infant > 0) {
                //     $(".number_infants.input_number")
                //         .closest(".right__inputTraveller")
                //         .find(".upNum")
                //         .removeClass("disabled");
                // } else {
                //     $(".number_infants.input_number")
                //         .closest(".right__inputTraveller")
                //         .find(".upNum")
                //         .addClass("disabled");
                // }
                // getNumberPerson();
            },
        });
    }
});
