$(function () {
    // Kiểm tra và thay đổi LANG_ID
    let lang_phone = LANG_ID;
    if (LANG_ID === "en") {
        lang_phone = "us";
    }

    // Lấy tất cả các trường số điện thoại và áp dụng intlTelInput
    $(".phonenumber").each(function () {
        window.intlTelInput(this, {
            initialCountry: lang_phone,
            strictMode: true,
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.7.0/build/js/utils.min.js",
        });
    });

    let clickedButton = "";

    $(document).on(
        "click",
        '#iso_cart_2024 button, #iso_cart_2024 input[type="submit"]',
        function () {
            clickedButton = $(this).attr("id");
        }
    );

    function resetRecaptcha() {
        grecaptcha.reset();
    }

    $.validator.addMethod("conditionalCheck", function (value, element) {
        let iso_information_tour_item = $(element).parents(
            ".iso_information_tour_item"
        );
        let iso_radio_item_primary = iso_information_tour_item
            .find(".iso_radio_item_primary:checked")
            .val();

        // Chỉ validate nếu iso_radio_item_primary == 'show'
        if (iso_radio_item_primary == "show") {
            return value.trim() !== ""; // Không được để trống
        }
        return true; // Không cần validate nếu không phải 'show'
    });

    $.validator.addMethod("validateTraveler", function (value, element) {
        let hnv_cart_item = $(element).parents(".hnv_cart_item");

        if (hnv_cart_item.hasClass("active")) {
            if (!$(element).parents(".iso_traveler_item").hasClass("hidden")) {
                return value.trim() !== ""; // Không được để trống
            }
        }

        return true; // Không cần validate nếu không phải 'active'
    });

    /*Lay danh sach input để thực hiện validate*/
    let cart_rules = {
        first_name: "required",
        last_name: "required",
        birthday: "required",
        gender: "required",
        email: {
            required: true,
            email: true,
        },
        country_id: "required",
        phone: "required",
    };

    //validate primary traveler
    $(".iso_box_item_primary_traveler").each(function () {
        let input = $(this).find(".form-booking_input");
        let name = input.attr("name");
        if (name && !(name in cart_rules)) {
            cart_rules[name] = {
                conditionalCheck: true,
            };
        }
    });
    // validate traveler
    $(".iso_traveler_item .form-booking_input").each(function () {
        let name = $(this).attr("name");

        if (name) {
            cart_rules[name] = {
                validateTraveler: true,
            };
        }
    });

    $("#iso_cart_2024").validate({
        errorPlacement: function (error, element) {
            error.appendTo(element.parents(".iso_input_box_item"));
            element.parents(".iso_input_box_item").addClass("validate_input");
        },
        highlight: function (element) {
            $(element)
                .parents(".iso_input_box_item")
                .addClass("validate_input");
        },
        unhighlight: function (element) {
            // Thêm phương thức unhighlight để xóa class khi hợp lệ
            $(element)
                .parents(".iso_input_box_item")
                .removeClass("validate_input");
        },
        success: function (label, element) {
            $(element)
                .parents(".iso_input_box_item")
                .removeClass("validate_input");
        },
        ignore: [],
        debug: false,
        rules: cart_rules,
        submitHandler: function (form) {
            if (clickedButton == "btn_contact_details") {
                //Xử lý hiển thị sau khi click submit bước 1
                let contact_detail = $(`#${clickedButton}`).parents(
                    ".iso_item_body"
                );
                contact_detail.find(".iso_input_box").hide();
                contact_detail.find(".iso_show_information").show();
                $(" .iso_box_left, .iso_lst_cart").show();
                let first_name = contact_detail
                    .find('input[name="first_name"]')
                    .val();
                let last_name = contact_detail
                    .find('input[name="last_name"]')
                    .val();
                let email = contact_detail.find('input[name="email"]').val();
                let phone = contact_detail.find('input[name="phone"]').val();

                $(".iso_show_information .information_name").text(
                    first_name + " " + last_name
                );
                $(".iso_show_information .information_text .txt_mail").text(
                    email
                );
                $(".iso_show_information .information_text .txt_phone").text(
                    phone
                );

                if (!$(".hnv_cart_item").first().hasClass("active")) {
                    $(".hnv_cart_item").first().addClass("active");
                }
            } else if (clickedButton == "confirm_payment") {
                // if ($("#iso_csrf_token").length == 0) {
                //     var recaptchaValue = $(
                //         'textarea[name="g-recaptcha-response"]'
                //     ).val();
                //     $.ajax({
                //         type: "POST",
                //         url:
                //             path_ajax_script +
                //             "/index.php?mod=home&act=ajGetSubs_totalSeNew",
                //         data: { "g-recaptcha-response": recaptchaValue },
                //         dataType: "json",
                //         async: false,
                //         success: function (res) {
                //             $("#iso_submit_click").remove();
                //             if (res.result) {
                //                 a_se_subs = res.a_se_subs;
                //                 b_se_subs = res.b_se_subs;
                //                 subs_uid = res.subs_uid;
                //                 csrf_token = res.csrf_token;
                //                 Swal.fire({
                //                     title: "",
                //                     text:
                //                         a_se_subs + " + " + b_se_subs + " = ?",
                //                     input: "text",
                //                     inputPlaceholder: placeholder_input,
                //                     icon: "question",
                //                     confirmButtonText: btn_send,
                //                     showCancelButton: true,
                //                     cancelButtonText: btn_close,
                //                     inputValidator: (value) => {
                //                         if (!value) {
                //                             return validate_input;
                //                         }
                //                     },
                //                 }).then((result) => {
                //                     if (result.isConfirmed) {
                //                         let calc =
                //                             parseInt(a_se_subs) +
                //                             parseInt(b_se_subs);
                //                         if (result.value == calc) {
                //                             $(".iso_form_submit").append(`
                // 									<input type="hidden" name="csrf_token" id="iso_csrf_token" value="${csrf_token}">>
                // 								`);
                //                             $("#confirm_payment").click();
                //                         } else {
                //                             Swal.fire(
                //                                 Wrong_result,
                //                                 "",
                //                                 "error"
                //                             );
                //                             resetRecaptcha();
                //                         }
                //                     } else if (
                //                         result.dismiss ===
                //                         Swal.DismissReason.cancel
                //                     ) {
                //                         resetRecaptcha();
                //                     }
                //                 });
                //             } else {
                //                 Swal.fire({
                //                     title: "",
                //                     text: res.msg,
                //                     icon: "info",
                //                     confirmButtonText: btn_close,
                //                     customClass: {
                //                         popup: "custom-popup-class",
                //                     },
                //                 });
                //             }
                //             return false;
                //         },
                //     });

                //     return false;
                // } else {

                // }
                $(".iso_box_waiting").show();
                form.submit();
            } else {
                $(`#${clickedButton}`)
                    .parents(".hnv_cart_item")
                    .find(".iso_hnv_cart_edit")
                    .addClass("active");
                $(`#${clickedButton}`)
                    .parents(".hnv_cart_item")
                    .find(".iso_information_booking")
                    .addClass("hidden");

                let hnv_cart_item_not_active = $(
                    ".hnv_cart_item:not(.active)"
                ).first();
                if (hnv_cart_item_not_active.length > 0) {
                    hnv_cart_item_not_active.addClass("active");
                } else {
                    $(".payment_box_card").show();
                }
            }
            return false;
        },
    });

    //Sự kiện hiển thị chi tiết dịch vụ của tour
    $(document)
        .on("click", ".iso_text_addon", function () {
            let info_addon = $(this).parents(".hnv_cart_item_info_addon");
            let item = $(this).parents(".hnv_cart_item");
            if (item.hasClass("active")) {
                if (info_addon.hasClass("active")) {
                    info_addon.removeClass("active");
                } else {
                    info_addon.addClass("active");
                }
            }
        })
        .on("click", ".iso_box_left", function () {
            /*Hiển thị box nhap của contact detail*/
            $(this).parents(".iso_item_cart").find(".iso_input_box").show();
            $(this)
                .parents(".iso_item_cart")
                .find(".iso_show_information, .iso_box_left")
                .hide();
        })
        .on("click", ".add_tourist_information", function () {
            let data_adult = $(this).attr("data-adult");
            let data_child = $(this).attr("data-child");
            let data_infant = $(this).attr("data-infant");
            let people =
                parseInt(data_adult) +
                parseInt(data_child) +
                parseInt(data_infant);

            let iso_input_box = $(this)
                .parents(".iso_information_tour_item")
                .find(".iso_traveler_item.hidden")
                .first();

            if (iso_input_box) {
                iso_input_box.removeClass("hidden");
            }

            let count_traveler_item = $(this)
                .parents(".hnv_cart_item_tour")
                .find(".iso_traveler_item:not(.hidden)").length;
            if (people == count_traveler_item) {
                $(this).addClass("hidden");
            }
        })
        .on("click", ".iso_traveler_delete", function () {
            if (confirm("confirm_delete")) {
                $(this)
                    .parents(".iso_information_tour_item")
                    .find(".add_tourist_information")
                    .removeClass("hidden");
                $(this).parents(".iso_traveler_item").addClass("hidden");
            }
        })
        .on("click", ".iso_hnv_cart_edit", function () {
            $(this)
                .parents(".hnv_cart_item")
                .find(".iso_information_booking")
                .removeClass("hidden");
        })
        .on(
            "keyup, change",
            ".iso_traveler_item .form-booking_input",
            function () {
                let first_name = $(this)
                    .parents(".iso_traveler_item")
                    .find(".first_name")
                    .val();
                let last_name = $(this)
                    .parents(".iso_traveler_item")
                    .find(".last_name")
                    .val();
                let full_name = first_name + " " + last_name;
                $(this)
                    .parents(".iso_traveler_item")
                    .find(".txt_full_name")
                    .val(full_name);
            }
        );
});
