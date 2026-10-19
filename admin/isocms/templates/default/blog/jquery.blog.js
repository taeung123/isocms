$().ready(function () {
    $(document).on("click", '.add_new_blog:not(".disable")', function (ev) {
        $(this).addClass("disable");
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajActionNewBlog",
            data: {
                tp: "S",
            },
            dataType: "json",
            success: function (json) {
                if (json.result == "success") {
                    window.location.href = json.link;
                }
            },
        });
    });
    // Page Blog - Mod: Blog - Act: Default
    if (mod == "blog" && act == "default") {
        // Duplicate Module Blog
        $(document).on("click", ".ajDuplicateBlog", function (ev) {
            var $_this = $(this);
            if (confirm(confirm_cloning)) {
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=" +
                        mod +
                        "&act=ajDuplicateBlog",
                    data: { blog_id: $_this.attr("blog_id") },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        location.href = html;
                    },
                });
            }
            return false;
        });
    }
    // Page Blog - Mod: Blog - Act: Category
    if (mod == "blog" && act == "category") {
        /* BLOGS CATEGORY */
        if ($SiteHasCat_Blogs == 1) {
            $(document).on("click", ".btnCreateCategoryBlog", function (ev) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=SiteBlogCategory",
                    data: { blogcat_id: $_this.attr("data"), tp: "F" },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        makepopupnotresize(
                            "52%",
                            "auto",
                            html,
                            "box_AddCategoryBlog"
                        );
                        $("#box_AddCategoryBlog").css("top", "50px");
                        var $editorID = $(".textarea_blog_intro_editor").attr(
                            "id"
                        );
                        $("#" + $editorID).isoTextAreaFix();
                    },
                });
                return false;
            });
            $(document).on("click", ".btnEditBlogCat", function (ev) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=SiteBlogCategory",
                    data: { blogcat_id: $_this.attr("data"), tp: "F" },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        makepopupnotresize(
                            "52%",
                            "auto",
                            html,
                            "box_EditCategoryBlog"
                        );
                        $("#box_EditCategoryBlog").css("top", "50px");
                        var $editorID = $(".textarea_blog_intro_editor").attr(
                            "id"
                        );
                        $("#" + $editorID).isoTextAreaFix();
                    },
                });
                return false;
            });
            $(document).on("click", ".btnClickToSubmitCategory", function (ev) {
                var $_this = $(this);
                var $_form = $_this.closest(".frmPop");

                var $title = $_form.find("input[name=title]");
                var $content = $_form.find("input[name=content]");
                var $editorID = $(".textarea_blog_intro_editor").attr("id");
                var editor = tinyMCE.get($editorID);
                var $intro = editor ? editor.getContent() : $('#' + $editorID).val();
                var $image_banner = $("#isoman_url_image_banner").val();
                var $icon_banner = $("#isoman_url_icon_banner").val();

                if ($title.val() == "") {
                    $title.focus();
                    alertify.error(field_is_required);
                    return false;
                }
                var adata = {
                    title: $title.val(),
                    intro: $intro,
                    content: $content.val(),
                    image_banner: $image_banner,
                    icon_banner: $icon_banner,
                    blogcat_id: $_this.attr("blogcat_id"),
                    tp: "S",
                };
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=SiteBlogCategory",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        if (html.indexOf("_SUCCESS") >= 0) {
                            location.href = `${path_ajax_script}/?mod=${mod}&act=${act}&message=insertSuccess`
                        }
                        if (html.indexOf("_ERROR") >= 0) {
                            alertify.error(insert_error);
                        }
                        if (html.indexOf("_EXIST") >= 0) {
                            alertify.error(insert_error_exist);
                        }
                    },
                });
                return false;
            });
        }
    }
    // Page Blog - Mod: Blog - Act: Edit
    if (mod == "blog" && act == "edit") {
        loadListDestination(blog_id);
        $(".chosen-select").chosen({ max_selected_options: 10, width: "100%" });
        if ($SiteHasTourExtension == "1") {
            // Tour Extension
            loadTourExtension(blog_id);
            $("#searchkeyTour").bind("keyup change", function () {
                var $_this = $(this);
                if ($_this.val() != "") {
                    clearTimeout(aj_search);
                    search_extension("Tour");
                } else {
                    $("#autosuggetTour").stop(false, true).slideUp();
                }
            });
            $(document).on("click", ".clickChooiseTour", function (ev) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=ajAddTourExtension",
                    data: {
                        blog_id: blog_id,
                        tour_id: $_this.attr("data"),
                    },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        if (html.indexOf("_SUCCESS") >= 0) {
                            $_this.remove();
                            loadTourExtension(blog_id);
                        }
                        if (html.indexOf("_EXIST") >= 0) {
                            alertify.error(exist_error);
                        }
                    },
                });
            });
            $(document).on("click", ".moveTourExtension", function (ev) {
                var _this = $(this);
                vietiso_loading(1);
                var adata = {
                    blog_extension_id: _this.attr("data"),
                    blog_id: blog_id,
                    direct: _this.attr("direct"),
                };
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=ajMoveTourExtension",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadTourExtension(blog_id);
                    },
                });
            });
            $(document).on("click", ".clickDeleteBlogExtension", function (ev) {
                if (confirm(confirm_delete)) {
                    var _this = $(this);
                    var tp = _this.attr("tp");
                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url:
                            path_ajax_script +
                            "/index.php?mod=" +
                            mod +
                            "&act=ajDeleteBlogExtension",
                        data: {
                            blog_extension_id: _this.attr("data"),
                        },
                        dataType: "html",
                        success: function (html) {
                            vietiso_loading(0);
                            if (tp == "tour") loadTourExtension(blog_id);
                            if (tp == "cruise") loadCruiseExtension(blog_id);
                        },
                    });
                    return false;
                }
            });
        }
        if ($SiteHasCruiseExtension == "1") {
            // Tour Extension
            loadCruiseExtension(blog_id);
            $("#searchkeyCruise").bind("keyup change", function () {
                var $_this = $(this);
                if ($_this.val() != "") {
                    clearTimeout(aj_search);
                    search_extension("Cruise");
                } else {
                    $("#autosuggetCruise").stop(false, true).slideUp();
                }
            });
            $(document).on("click", ".clickChooiseCruise", function (ev) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=ajAddCruiseExtension",
                    data: {
                        blog_id: blog_id,
                        cruise_id: $_this.attr("data"),
                    },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        if (html.indexOf("_SUCCESS") >= 0) {
                            $_this.remove();
                            loadCruiseExtension(blog_id);
                        }
                        if (html.indexOf("_EXIST") >= 0) {
                            alertify.error(exist_error);
                        }
                    },
                });
            });
            $(document).on("click", ".moveCruiseExtension", function (ev) {
                var _this = $(this);
                vietiso_loading(1);
                var adata = {
                    blog_extension_id: _this.attr("data"),
                    blog_id: blog_id,
                    direct: _this.attr("direct"),
                };
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=ajMoveCruiseExtension",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadCruiseExtension(blog_id);
                    },
                });
            });
            $(document).on("click", ".clickDeleteBlogExtension", function (ev) {
                if (confirm(confirm_delete)) {
                    var _this = $(this);
                    var tp = _this.attr("tp");
                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url:
                            path_ajax_script +
                            "/index.php?mod=" +
                            mod +
                            "&act=ajDeleteBlogExtension",
                        data: {
                            blog_extension_id: _this.attr("data"),
                        },
                        dataType: "html",
                        success: function (html) {
                            vietiso_loading(0);
                            if (tp == "tour") loadTourExtension(blog_id);
                            if (tp == "cruise") loadCruiseExtension(blog_id);
                        },
                    });
                    return false;
                }
            });
        }
        if ($SiteHasHotelExtension == "1") {
            loadHotelExtension(blog_id);
            $("#searchkeyHotel").bind("keyup change", function () {
                var $_this = $(this);
                if ($_this.val() != "") {
                    clearTimeout(aj_search);
                    search_extension("Hotel");
                } else {
                    $("#autosuggetHotel").stop(false, true).slideUp();
                }
            });
            $(document).on("click", ".clickChooiseHotel", function (ev) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=ajAddHotelExtension",
                    data: {
                        blog_id: blog_id,
                        hotel_id: $_this.attr("data"),
                    },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        if (html.indexOf("_SUCCESS") >= 0) {
                            $_this.remove();
                            loadHotelExtension(blog_id);
                        }
                        if (html.indexOf("_EXIST") >= 0) {
                            alertify.error(exist_error);
                        }
                    },
                });
            });
            $(document).on("click", ".moveHotelExtension", function (ev) {
                var _this = $(this);
                vietiso_loading(1);
                var adata = {
                    blog_extension_id: _this.attr("data"),
                    blog_id: blog_id,
                    direct: _this.attr("direct"),
                };
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=ajmoveHotelExtension",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadHotelExtension(blog_id);
                    },
                });
            });
            $(document).on("click", ".clickDeleteBlogExtension", function (ev) {
                if (confirm(confirm_delete)) {
                    var _this = $(this);
                    var tp = _this.attr("tp");
                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url:
                            path_ajax_script +
                            "/index.php?mod=" +
                            mod +
                            "&act=ajDeleteBlogExtension",
                        data: {
                            blog_extension_id: _this.attr("data"),
                        },
                        dataType: "html",
                        success: function (html) {
                            vietiso_loading(0);
                            if (tp == "tour") loadTourExtension(blog_id);
                            if (tp == "cruise") loadCruiseExtension(blog_id);
                            if (tp == "hotel") loadHotelExtension(blog_id);
                        },
                    });
                    return false;
                }
            });
        }
    }
    /* START_Dia_Danh */
    setSelectBoxDestination();
    $(document).on("change", "#slb_Chauluc", function (ev) {
        var $_this = $(this);
        if (parseInt($_this.val()) > 0) {
            loadCountry($_this.val());
        } else {
            $("select[name=country_id]")
                .html('<option value="0">' + country + "/option>")
                .hide();
            $("select[name=region_id]")
                .html('<option value="0">' + regions + "</option>")
                .hide();
            $("select[name=city_id]")
                .html('<option value="0">' + cities + "</option>")
                .hide();
        }
    });
    $(document).on("change", "#slb_Country", function (ev) {
        var $_this = $(this);
        if (parseInt($_this.val()) > 0) {
            if ($SiteActive_region == "1") {
                loadRegion($_this.val());
                $("#slb_CityID").hide();
            } else {
                loadCity($_this.val());
            }
        } else {
            $("#slb_RegionID").hide();
            $("#slb_CityID").hide();
        }
    });
    $(document).on("change", "#slb_RegionID", function (ev) {
        var $_this = $(this);
        if ($SiteModActive_country == "1") {
            var $country_id = $("#slb_Country").val();
            if ($country_id == undefined) {
                $country_id = $("#Hid_Country").val();
            }
            loadCity($country_id, $_this.val());
        } else {
            loadCity(0, $_this.val());
        }
    });
    // Destination
    $(document).on("click", ".ajQuickAddDestination", function (ev) {
        var $_this = $(this);
        if ($SiteModActive_continent == "1") {
            var $chauluc_id = $("#slb_Chauluc").val();
        }
        if ($SiteModActive_country == "1") {
            var $country_id = $("#slb_Country").val();
            if ($country_id != undefined || $country_id == 0) {
                var $countryID = $("#slb_Country");
                setSelectOpen($countryID);
            } else {
                $country_id = 1;
            }
        }
        if ($SiteActive_region == "1") {
            var $region_id = $("#slb_RegionID").val();
        }
        if ($SiteActive_city == "1") {
            var $city_id = $("#slb_CityID").val();
        }

        if (
            $chauluc_id > 0 ||
            $country_id > 0 ||
            $region_id > 0 ||
            $city_id > 0
        ) {
            var adata = {};
            adata["chauluc_id"] = $chauluc_id;
            adata["country_id"] = $country_id;
            adata["region_id"] = $region_id;
            adata["city_id"] = $city_id;
            adata["blog_id"] = $blog_id;

            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajaxAddMoreBlogDestination",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    if (html.indexOf("_SUCCESS") >= 0) {
                        loadListDestination($blog_id);
                    }
                    if (html.indexOf("_EXIST") >= 0) {
                        alertify.error(exist_error);
                    }
                },
            });
            return 0;
        }
    });
    $(document).on("click", ".removeDestination", function (ev) {
        var $_this = $(this);
        if (confirm(confirm_delete)) {
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajaxDeleteBlogDestination",
                data: { blog_destination_id: $_this.attr("data") },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    var $country_id = $("#slb_Country").val();
                    if ($country_id == undefined) {
                        $country_id = $("#Hid_Country").val();
                    }
                    if ($("#slb_CityID").is(":visible")) {
                        loadCity($country_id, $("#slb_RegionID").val());
                    }
                    loadListDestination($blog_id);
                },
            });
            return false;
        }
    });
    $(document).on("click", ".ajRemoveAllDestinationInTour", function (ev) {
        var $_this = $(this);
        if (confirm(confirm_delete)) {
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajaxDeleteAllBlogDestination",
                data: { blog_id: blog_id },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    var $country_id = $("#slb_Country").val();
                    if ($country_id == undefined) {
                        $country_id = $("#Hid_Country").val();
                    }
                    if ($("#slb_CityID").is(":visible")) {
                        loadCity($country_id, $("#slb_RegionID").val());
                    }
                    loadListDestination(blog_id);
                },
            });
            return false;
        }
    });
});

function setSelectBoxDestination() {
    if ($SiteModActive_continent == "1") {
        $("#slb_Country").hide();
        $("#slb_RegionID").hide();
        $("#slb_CityID").hide();
    } else {
        if ($SiteModActive_country == "1") {
            loadCountry();
            $("#slb_RegionID").hide();
            $("#slb_CityID").hide();
        } else {
            if ($SiteActive_region == "1") {
                loadRegion();
                $("#slb_CityID").hide();
            } else if ($SiteActive_city == "1") {
                loadCity();
            } else {
                $("#slb_CityID").hide();
            }
        }
    }
}
function loadCountry($chauluc_id, $khuvuc_id, $country_id) {
    $("#slb_Country").html('<option value="0">' + loading + "</option>");
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadCountry",
        data: {
            chauluc_id: $chauluc_id,
            khuvuc_id: $khuvuc_id,
            country_id: $country_id,
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("EMPTY") >= 0) {
                $("#slb_Country").hide();
            } else {
                $("#slb_Country").html(html).show();
            }
            /**/
            $("#slb_RegionID").hide();
            $("#slb_CityID").hide();
        },
    });
}
function loadRegion($country_id, $region_id) {
    $("#slb_RegionID").html('<option value="0">' + loading + "</option>");
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadRegion",
        data: { country_id: $country_id },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("EMPTY") >= 0) {
                $("#slb_RegionID").hide();
                loadCity($country_id);
            } else {
                $("#slb_RegionID").html(html).show();
            }
        },
    });
}
function loadCity($country_id, $region_id, $city_id, $blog_id) {
    $("#slb_CityID").html('<option value="0">' + loading + "</option>");
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajmakeSelectCityGlobal",
        data: {
            country_id: $country_id,
            region_id: $region_id,
            city_id: $city_id,
            blog_id: $blog_id,
        },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            if (html.indexOf("EMPTY") >= 0) {
                $("#slb_CityID").hide();
            } else {
                $("#slb_CityID").html(html).show();
            }
        },
    });
}
function loadListDestination($blog_id) {
    if ($blog_id == 0) {
        return false;
    }
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajaxLoadBlogDestination",
        data: { blog_id: $blog_id },
        dataType: "html",
        success: function (html) {
            vietiso_loading(0);
            $("#lstDestination").html(html);
        },
    });
}
function loadTourExtension(blog_id) {
    if (blog_id == 0) {
        return false;
    }
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajLoadTourExtension",
        data: {
            blog_id: blog_id,
        },
        dataType: "html",
        success: function (html) {
            if (html.replace(" ", "") == "") {
                /*$("#tab5Note").removeClass("iso-check").addClass("iso-check-disabled");*/
                $("#tblTourExtension").html(html);
            } else {
                $("#tblTourExtension").html(html);
                /*$("#tab5Note").addClass("iso-check").removeClass("iso-check-disabled");*/
            }
        },
    });
}
function loadCruiseExtension(blog_id) {
    if (blog_id == 0) {
        return false;
    }
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajLoadCruiseExtension",
        data: {
            blog_id: blog_id,
        },
        dataType: "html",
        success: function (html) {
            if (html.replace(" ", "") == "") {
                /*$("#tab5Note").removeClass("iso-check").addClass("iso-check-disabled");*/
                $("#tblCruiseExtension").html(html);
            } else {
                $("#tblCruiseExtension").html(html);
                /*$("#tab5Note").addClass("iso-check").removeClass("iso-check-disabled");*/
            }
        },
    });
}
function loadHotelExtension(blog_id) {
    if (blog_id == 0) {
        return false;
    }
    $.ajax({
        type: "POST",
        url:
            path_ajax_script +
            "/index.php?mod=" +
            mod +
            "&act=ajLoadHotelExtension",
        data: {
            blog_id: blog_id,
        },
        dataType: "html",
        success: function (html) {
            if (html.replace(" ", "") == "") {
                $("#tblHotelExtension").html(html);
            } else {
                $("#tblHotelExtension").html(html);
            }
        },
    });
}

function search_extension(type) {
    aj_search = setTimeout(function () {
        $.ajax({
            type: "POST",
            url:
                path_ajax_script + "/index.php?mod=" + mod + "&act=ajGetSearch",
            data: {
                keyword: $("#searchkey" + type).val(),
                blog_id: blog_id,
                type: type,
            },
            dataType: "html",
            success: function (html) {
                if (html.indexOf("_EMPTY") >= 0) {
                    $("#autosugget" + type).hide();
                } else {
                    $("#autosugget" + type)
                        .stop(false, true)
                        .slideDown();
                    $("#autosugget" + type)
                        .find(".HTML_sugget" + type)
                        .html(html);
                }
            },
        });
    }, 500);
}
