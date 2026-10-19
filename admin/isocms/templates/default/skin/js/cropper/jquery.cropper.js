function file_drop(_this, ev) {
    ev.preventDefault();
    var file = ev.dataTransfer.files[0],
        params = $(_this).data("options") || {};
    if (/^image\/\w+/.test(file.type)) {
        upload_file_picker(file, params);
    }
}

function file_explorer(_this, ev) {
    ev.preventDefault();
    var $_this = $(_this),
        $_toId = $_this.attr("toId"),
        params = $_this.data("options") || {};
    $("#" + $_toId)
        .val("")
        .click();
    $("#" + $_toId).change(function () {
        var file,
            files = $(this).prop("files"),
            params = $(this).data("options") || {};
        if (files && files.length) {
            file = files[0];
            if (/^image\/\w+/.test(file.type)) {
                upload_file_picker(file, params);
            }
        }
    });
    return false;
}

function upload_file_picker(file, params) {
    console.log(params);
    var $_adata = params,
        URL = window.URL || window.webkitURL,
        imgdata = URL.createObjectURL(file),
        filename = $.trim(file.name);
    $_adata["imgdata"] = imgdata;
    // $_adata['table_id'] = table_id;
    // $_adata['openFrom'] = openFrom;
    $.post(
        path_ajax_script + "/index.php?mod=cropper&act=open_cropper",
        $_adata,
        function (html) {
            $Core.util.toggleIndicatior(0);
            $Core.popup.open(
                "auto",
                "auto",
                html,
                "open_cropper_" + params.table_id
            );
            if (params.clsTable == "Ads") {
                // var aspectRatio = (1280 / 294);
                var aspectRatio = 624 / 335;
            } else if (params.clsTable == "Slide") {
                var aspectRatio = 1920 / 640;
            } else if (params.clsTable == "Configuration") {
                if (params.toField == "site_about_page_banner") {
                    var aspectRatio = 1280 / 600;
                } else if (
                    params.openFrom == "banner" &&
                    params.toId == "isoman_show_banner"
                ) {
                    var aspectRatio = 1920 / 400;
                } else {
                    var aspectRatio = 1920 / 640;
                }
            } else if (params.clsTable == "Partner") {
                if (params.type == "BC") {
                    var aspectRatio = 111 / 65;
                    // var aspectRatio = (115 / 92);
                } else {
                    // var aspectRatio = (151 / 65);
                    var aspectRatio = 115 / 92;
                }
            } else if (params.clsTable == "Testimonial") {
                var aspectRatio = 260 / 200;
            } else if (params.clsTable == "News") {
                var aspectRatio = 850 / 547;
            } else if (params.clsTable == "Hotel") {
                var aspectRatio = 858 / 395;
            } else if (params.clsTable == "Cruise") {
                var aspectRatio = 743 / 489;
            } else if (params.clsTable == "Service") {
                var aspectRatio = 280 / 255;
            } else if (params.clsTable == "Blog") {
                var aspectRatio = 828 / 552;
            } else if (params.clsTable == "Voucher") {
                var aspectRatio = 297 / 194;
            } else if (params.clsTableGal == "Voucher") {
                var aspectRatio = 714 / 467;
            } else if (params.clsTable == "Category_Country") {
                if (params.openFrom == "banner") {
                    var aspectRatio = 1920 / 400;
                } else {
                    // var aspectRatio = (532 / 355);
                    var aspectRatio = 261 / 376;
                }
            } else if (
                params.clsTable == "Country" ||
                params.clsTable == "Region"
            ) {
                // var aspectRatio = (298 / 198);
                var aspectRatio = 261 / 376;
                if (
                    params.openFrom == "banner" ||
                    params.openFrom == "image_hotel"
                ) {
                    // var aspectRatio = (1600 / 500);
                    var aspectRatio = 1920 / 400;
                }
            } else if (params.clsTable == "City") {
                var aspectRatio = 297 / 297;
                if (
                    params.openFrom == "banner" ||
                    params.openFrom == "image_hotel"
                ) {
                    var aspectRatio = 1920 / 400;
                }
            } else if (params.clsTable == "Meta") {
                var aspectRatio = 500 / 261;
            } else if (
                params.clsTable == "Tour" ||
                params.clsTableGal == "TourImage"
            ) {
                var aspectRatio = 840 / 480;
            } else {
                var aspectRatio = 750 / 500;
            }
            var URL = window.URL || window.webkitURL,
                $cropper = $("#" + "cropper"),
                $cropper_width = $("#" + "cropper-width"),
                $cropper_height = $("#" + "cropper-height"),
                options = {
                    aspectRatio: aspectRatio,
                    crop: function (e) {
                        $cropper_width.val(Math.round(e.detail.width));
                        $cropper_height.val(Math.round(e.detail.height));
                    },
                },
                originalImageURL = $cropper.attr("src"),
                uploadedImageName = "cropped.png",
                uploadedImageType = "image/png",
                uploadedImageURL,
                $target;
            $cropper.cropper(options);
            $(".ui-cropper-tool").on("click", function (e) {
                $Core.util.stopEventHandler(e);
                var $_this = $(this),
                    data = $_this.data(),
                    cropper = $cropper.data("cropper"),
                    img_title = $("[name=img_title]").val();
                if (data.method == "getCroppedCanvas") {
                    if ($(this).hasClass("clicked")) {
                        return false;
                    } else {
                        $Core.util.toggleIndicatior(1);
                        $(this).addClass("clicked");
                    }
                }
                if (
                    params.openFrom == "gallery" &&
                    data.method == "getCroppedCanvas" &&
                    $Core.util.isEmpty(img_title)
                ) {
                    $Core.util.toggleIndicatior(0);
                    $Core.alert.alert(__["Message"], "Vui lòng nhập tên ảnh!");
                    $("input[name=img_title]").focus();
                    $(this).removeClass("clicked");
                    return false;
                }
                data["secondOption"] = $_this.data("second-option");
                if (cropper && data.method) {
                    data = $.extend({}, data); // Clone a new one
                    if (typeof data.target !== "undefined") {
                        $target = $(data.target);
                        if (typeof data.option === "undefined") {
                            try {
                                data.option = JSON.parse($target.val());
                            } catch (e) {
                                console.log(e.message);
                            }
                        }
                    }
                    cropped = cropper.cropped;
                    switch (data.method) {
                        case "rotate":
                            if (cropped && options.viewMode > 0) {
                                $cropper.cropper("clear");
                            }
                            break;
                        case "getCroppedCanvas":
                            if (uploadedImageType === "image/jpeg") {
                                if (!data.option) {
                                    data.option = {};
                                }
                                data.option.fillColor = "#fff";
                            }
                            break;
                    }
                    console.log(data.method, data.option, data.secondOption);
                    var result = $("#cropper").cropper(
                        data.method,
                        data.option,
                        data.secondOption
                    );
                    switch (data.method) {
                        case "rotate":
                            if (cropped && options.viewMode > 0) {
                                $cropper.cropper("crop");
                            }
                            break;
                        case "scaleX":
                        case "scaleY":
                            $(this).data("option", -data.option);
                            break;
                        case "getCroppedCanvas":
                            if (result) {
                                result.toBlob(function (blob) {
                                    const formData = new FormData();
                                    for (const [key, value] of Object.entries(
                                        $_adata
                                    )) {
                                        if (key != "imgdata") {
                                            formData.append(key, value);
                                        }
                                    }
                                    formData.append("img_title", img_title);
                                    formData.append("imgdata", blob);
                                    if (params.openFrom == "gallery") {
                                        $Core.util.toggleIndicatior(1);
                                        $.ajax({
                                            url:
                                                path_ajax_script +
                                                "/index.php?mod=cropper&act=upload_gallery",
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            type: "POST",
                                            success: function (html) {
                                                $Core.util.toggleIndicatior(0);
                                                $cropper.cropper("destroy");
                                                $("form")[0].reset();
                                                $Core.popup.close(
                                                    $(
                                                        "#" +
                                                            "open_cropper_" +
                                                            params.table_id
                                                    )
                                                );
                                                // Callback
                                                if (clsTableGal != "") {
                                                    loadGallery(
                                                        params.table_id,
                                                        {
                                                            clsTable:
                                                                clsTableGal,
                                                        }
                                                    );
                                                } else {
                                                    loadTourGallery(
                                                        params.table_id
                                                    );
                                                }
                                            },
                                        });
                                    } else {
                                        $Core.util.toggleIndicatior(1);
                                        $.ajax({
                                            url:
                                                path_ajax_script +
                                                "/index.php?mod=cropper&act=upload_image",
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            type: "POST",
                                            success: function (html) {
                                                $Core.util.toggleIndicatior(0);
                                                $cropper.cropper("destroy");
                                                $Core.popup.close(
                                                    $(
                                                        "#" +
                                                            "open_cropper_" +
                                                            params.table_id
                                                    )
                                                );
                                                if (
                                                    html.indexOf("_error") >= 0
                                                ) {
                                                    $Core.alert.alert(
                                                        __["Message"],
                                                        __["Image upload error"]
                                                    );
                                                } else {
                                                    var s = html.split("|||");
                                                    $("#" + params.toId).attr(
                                                        "src",
                                                        $.trim(s[1])
                                                    );
                                                    $("." + params.toId).attr(
                                                        "src",
                                                        $.trim(s[1])
                                                    );
                                                    if (
                                                        params.toId ==
                                                        "isoman_show_image"
                                                    ) {
                                                        $("#image").val(
                                                            $.trim(s[1])
                                                        );
                                                    }
                                                    if (
                                                        params.toId ==
                                                        "isoman_show_banner"
                                                    ) {
                                                        $("#banner").val(
                                                            $.trim(s[1])
                                                        );
                                                    }
                                                    if (
                                                        params.toId ==
                                                        "isoman_show_image_hotel"
                                                    ) {
                                                        $("#image_hotel").val(
                                                            $.trim(s[1])
                                                        );
                                                    }
                                                    $("." + params.toId).attr(
                                                        "src",
                                                        $.trim(s[1])
                                                    );
                                                    if (
                                                        !$Core.util.isEmpty(
                                                            params.hiddenId
                                                        )
                                                    ) {
                                                        $(
                                                            "#" +
                                                                params.hiddenId
                                                        ).val($.trim(s[1]));
                                                    }
                                                }
                                            },
                                            error: function (
                                                xhr,
                                                status,
                                                error
                                            ) {
                                                console.error(
                                                    "Lỗi khi upload:",
                                                    xhr.responseText
                                                );
                                            },
                                        });
                                    }
                                }, file.type);
                                return false;
                            }
                            break;
                        case "destroy":
                            if (uploadedImageURL) {
                                URL.revokeObjectURL(uploadedImageURL);
                                uploadedImageURL = "";
                                $image.attr("src", originalImageURL);
                            }
                            break;
                    }
                    if (
                        typeof result === "object" &&
                        result !== cropper &&
                        $target
                    ) {
                        try {
                            $target.value = JSON.stringify(result);
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }
                return false;
            });
        }
    );
}

function isoman_callback(options) {
    console.log(options);
    var $_adata = options || {},
        $_file_images = isoman_selected_files();

    if (
        !$Core.util.isEmpty(options.clsTable) &&
        !$Core.util.isEmpty(options.table_id)
    ) {
        $_adata["val"] = $_file_images;
        $_adata["toField"] = "image";
        $_adata["allowDuplicate"] = 1;
        $.post(
            path_ajax_script + "/?mod=home&act=saveField",
            $_adata,
            function (res) {
                $("#" + $_adata.toId).attr("src", $_file_images);
                $("." + $_adata.toId).attr("src", $_file_images);
            }
        );
    } else {
        $("#" + $_adata.toId).attr("src", $_file_images);
        $("." + $_adata.toId).attr("src", $_file_images);
        if (!$Core.util.isEmpty(options.hiddenId)) {
            $("#" + $_adata.hiddenId).val($_file_images);
        }
    }
}

$(function () {
    $_document.on("click", ".save_edit_img_gallery", function () {
        var _this = $(this);
        var img_val = _this
            .closest(".form_edit_img")
            .find("input[name=isoman_url_image]")
            .val();
        var img_title = _this
            .closest(".form_edit_img")
            .find("input[name=title]")
            .val();
        var img_id = _this.attr("pvalTable");
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajChangeEditImg",
            data: { url_img: img_val, title_img: img_title, id: img_id },
            dataType: "json",
            success: function (json) {
                if (json["result"] == "error") {
                    alertify.success(json["mes"]);
                }
                if (json["result"] == "success") {
                    _this
                        .closest(".form_edit_img")
                        .find(".modal-title")
                        .text(img_title);
                    $("#image_galry_" + img_id).attr("title", img_title);
                    $("#image_galry_" + img_id + " img").attr("src", img_val);
                    alertify.success(json["mes"]);
                    $("#edit_tour_image_" + img_id).modal("hide");
                }
                // $('#files').append(html);
                return false;
            },
        });
        return false; //intercept the link
    });
    $_document.on("click", ".close_image", function () {
        var _this = $(this);
        var pval = $(this).attr("pvalTable");
        $("#edit_tour_image_" + pval).modal("hide");
        return false; //intercept the link
    });
    $_document.on("click", ".del_gal_img", function () {
        var _this = $(this),
            table_id = _this.data("table_id"),
            image_id = _this.data("img_id"),
            clsTable = _this.data("class");
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=cropper&act=ajDeleteGalImg",
            data: { table_id: table_id, img_id: img_id, clsTable: clsTable },
            dataType: "json",
            success: function (respJson) {
                if (respJson.result == "error") {
                    alertify.success(json["mes"]);
                } else if (respJson.result == "success") {
                    _this.closest("li").remove();
                    alertify.success(json["mes"]);
                }
            },
        });
        return false;
    });
});
