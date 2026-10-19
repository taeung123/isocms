$().ready(function () {
    /*==add cabin*/
    $_document.on("click", ".addCabin,.edit_cabin", function () {
        var $_this = $(this);
        var $cabin_id = 0;
        if ($_this.hasClass("edit_cabin")) {
            $cabin_id = $_this.data("cabin_id");
        }
        var $cruise_id = $_this.data("cruise_id");
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=cruise&act=ajLoadFormCabin",
            data: { tp: "F", cruise_id: $cruise_id, cabin_id: $cabin_id },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                $("#frmMainStep_" + $cruise_id).hide();
                $(".box_add_cruise_new").html(html).show();
            },
        });
        return false;
    });
    $_document.on("click", ".btn_back_list_cabin,.btn_back_cabin", function () {
        loadMainFormStep(pvalTable_ovv, "cabin", "");
        $("#frmMainStep_" + pvalTable_ovv).show();
        $(".box_add_cruise_new").html("").hide();
        return false;
    });
    $_document.on("click", ".btn_back_list_itinerary", function () {
        loadMainFormStep(table_id, "itinerary");
        $("#frmMainStep_" + table_id).show();
        $(".box_add_cruise_new").html("").hide();
        return false;
    });
    $_document.on("keyup", "#title_cabin", function () {
        var $_this = $(this);
        var title = $_this.val();
        if (title != "") {
            $(".title_add_cabin").text(title);
        } else {
            var title_default = $(".title_add_cabin").data("title_add_cabin");
            $(".title_add_cabin").text(title_default);
        }
        return false;
    });
    $_document.on("click", ".btn_save_cabin", function () {
        var adata = {},
            $_form = $("#frm_addCabin");
        var _validated = 0;
        if (
            $("input.required,select.required,textarea.required", $_form).length
        ) {
            $("input.required,select.required,textarea.required", $_form).each(
                function (index, elm) {
                    if ($Core.util.isEmpty($(this).val())) {
                        _validated++;
                        $(this).focus();
                        $(this).addClass("error");
                        if (
                            $(this).hasClass("chosen-select") &&
                            $(this).attr("multiple") == "multiple"
                        ) {
                            $(this).next().addClass("error");
                            $("html,body").animate(
                                {
                                    scrollTop:
                                        $(this).next().offset().top - 300,
                                },
                                100
                            );
                        } else {
                            $("html,body").animate(
                                {
                                    scrollTop: $(elm).offset().top - 300,
                                },
                                100
                            );
                        }
                        return false;
                    } else {
                        $(this).removeClass("error");
                        if (
                            $(this).hasClass("chosen-select") &&
                            $(this).attr("multiple") == "multiple"
                        ) {
                            $(this).next().removeClass("error");
                        }
                    }
                }
            );
        }
        if (_validated > 0) {
            return false;
        }
        adata["cruise_id"] = table_id;
        adata["image_src"] = $_form.find("input[name='image_src']").val();
        adata["isoman_url_image"] = $_form
            .find("input[name='isoman_url_image']")
            .val();
        adata["title"] = $_form.find("input[name='title']").val();
        adata["list_group_size"] = $_form
            .find('select[name="list_group_size[]"]')
            .val();
        adata["cabin_size"] = $_form.find("input[name='cabin_size']").val();
        adata["number_cabin"] = $_form.find("input[name='number_cabin']").val();
        adata["floor"] = $_form.find("input[name='floor']").val();
        adata["bed_size"] = $_form.find("input[name='bed_size']").val();
        adata["extra_bed"] = $_form.find("select[name='extra_bed']").val();
        adata["cabin_id"] = $_form.find("input[name='cabin_id']").val();
        adata["listCabinFacilities"] = [];
        adata["is_show_image"] = $_form
            .find("input[name='is_show_image']:checked")
            .val();
        $_form
            .find("input[name='listCabinFacilities[]']:checked")
            .each(function (index, elm) {
                adata["listCabinFacilities"].push($(elm).val());
            });
        if ($_form.find(".textarea_intro_editor").length) {
            $(".textarea_intro_editor").each(function () {
                var column = $(this).data("column"),
                    editorId = $(this).attr("id");
                adata[column] = $Core.util.getTextAreaContent(editorId);
            });
        }

        adata["tp"] = "S";
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=cruise&act=ajLoadFormCabin",
            data: adata,
            dataType: "json",
            success: function (res) {
                vietiso_loading(0);
                if (res.result) {
                    alertify.success(res.message);
                    loadMainFormStep(table_id, "cabin");
                    $("#frmMainStep_" + table_id).show();
                    $(".box_add_cruise_new").html("").hide();
                    window.location.reload();
                } else {
                    alertify.error(res.message);
                }
            },
        });
        return false;
    });
    /*==end add cabin*/
    /*==add itinerary*/
    $(document).on("click", ".upNum", function (ev) {
        ev.preventDefault();
        ev.stopPropagation();
        let $_this = $(this);
        let number_day = parseInt($("input[name=number_day]").val()),
            max_number_day = parseInt(
                $("input[name=number_day]").attr("max-number")
            ),
            number_night = parseInt($("input[name=number_night]").val()),
            max_number_night = parseInt(
                $("input[name=number_night]").attr("max-number")
            );
        if ($_this.hasClass("number_day")) {
            number_day = number_day + 1;
            if (number_day > max_number_day) {
                alert("Max days");
                number_day = max_number_day;
            }
            $("input[name=number_day]").val(number_day);
            if (number_night < number_day - 1) {
                number_night = number_day - 1;
            } else if (number_night > number_day + 1) {
                number_night = number_day + 1;
            }
            $(".clickToAddItineraryDay").show();
        } else if ($_this.hasClass("number_night")) {
            number_night = number_night + 1;
            if (number_night > max_number_night) {
                alert("Max days");
                number_night = max_number_night;
            }
            if (number_night < number_day - 1) {
                number_night = number_day - 1;
            } else if (number_night > number_day + 1) {
                number_night = number_day + 1;
            }
        }
        $("input[name=number_night]").val(number_night);
        var txt = "";
        if (number_day == 1 && number_night == 0) {
            txt = $txtFullDay;
        } else if (number_day > 0) {
            if (number_day == 1) {
                txt += number_day + " " + $txtDay;
            } else {
                txt += number_day + " " + $txtDays;
            }
            if (number_night <= 1) {
                txt += ", " + number_night + " " + $txtNight;
            } else {
                txt += ", " + number_night + " " + $txtNights;
            }
        }
        if (txt !== "") {
            // $(".title_add_itinerary").text(txt);
        } else {
            // $(".title_add_itinerary").text($txtFullDay);
        }

        return false;
    });
    $(document).on("click", ".unNum", function (ev) {
        ev.preventDefault();
        ev.stopPropagation();
        let $_this = $(this);
        let number_day = parseInt($("input[name=number_day]").val()),
            min_number_day = parseInt(
                $("input[name=number_day]").attr("min-number")
            ),
            number_night = parseInt($("input[name=number_night]").val()),
            min_number_night = parseInt(
                $("input[name=number_night]").attr("min-number")
            );
        if ($_this.hasClass("number_day")) {
            number_day = number_day - 1;
            let number_itinerary_day = $("#tblCruiseItineraryDay").find(
                "tr"
            ).length;
            if (number_day < number_itinerary_day) {
                alert($msg_delete_itinerary_day);
                return false;
            } else if (number_day == number_itinerary_day) {
                $(".clickToAddItineraryDay").hide();
            }
            if (number_day < min_number_day) {
                alert("Min days");
                number_day = min_number_day;
            }
            $("input[name=number_day]").val(number_day);
            if (number_night < number_day - 1) {
                number_night = number_day - 1;
            } else if (number_night > number_day + 1) {
                number_night = number_day + 1;
            }
        } else if ($_this.hasClass("number_night")) {
            number_night = number_night - 1;
            if (number_night < min_number_night) {
                alert("Min days");
                number_night = min_number_night;
            }

            if (number_night < number_day - 1) {
                number_night = number_day - 1;
            } else if (number_night > number_day + 1) {
                number_night = number_day + 1;
            }
        }

        $("input[name=number_night]").val(number_night);
        var txt = "";
        if (number_day == 1 && number_night == 0) {
            txt = $txtFullDay;
        } else if (number_day > 0) {
            if (number_day == 1) {
                txt += number_day + " " + $txtDay;
            } else {
                txt += number_day + " " + $txtDays;
            }
            if (number_night <= 1) {
                txt += ", " + number_night + " " + $txtNight;
            } else {
                txt += ", " + number_night + " " + $txtNights;
            }
        }
        if (txt !== "") {
            // $(".title_add_itinerary").text(txt);
        } else {
            // $(".title_add_itinerary").text($txtFullDay);
        }
        return false;
    });
    $_document.on("click", ".addItinerary,.edit_itinerary", function () {
        var $_this = $(this);
        var $cruise_itinerary_id = 0;
        if ($_this.hasClass("edit_itinerary")) {
            $cruise_itinerary_id = $_this.data("cruise_itinerary_id");
        }
        var $cruise_id = $_this.data("cruise_id");
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=cruise&act=ajLoadFormItinerary",
            data: {
                tp: "F",
                cruise_id: $cruise_id,
                cruise_itinerary_id: $cruise_itinerary_id,
            },
            dataType: "json",
            success: function (res) {
                vietiso_loading(0);
                if (res.result) {
                    $("#frmMainStep_" + $cruise_id).hide();
                    $(".box_add_cruise_new").html(res.html).show();
                    if (res.message !== "") {
                        alertify.success(res.message);
                    }
                } else {
                    alertify.error(res.message);
                }
            },
        });
        return false;
    });
    $_document.on("click", ".btn_save_cruise_itinerary", function () {
        var adata = {},
            $_form = $("#frm_addCruideItinerary");
        var _validated = 0;
        if (
            $("input.required,select.required,textarea.required", $_form).length
        ) {
            $("input.required,select.required,textarea.required", $_form).each(
                function (index, elm) {
                    if ($Core.util.isEmpty($(this).val())) {
                        _validated++;
                        $(this).focus();
                        $(this).addClass("error");
                        if (
                            $(this).hasClass("chosen-select") &&
                            $(this).attr("multiple") == "multiple"
                        ) {
                            $(this).next().addClass("error");
                        }
                        return false;
                    } else {
                        $(this).removeClass("error");
                        if (
                            $(this).hasClass("chosen-select") &&
                            $(this).attr("multiple") == "multiple"
                        ) {
                            $(this).next().removeClass("error");
                        }
                    }
                }
            );
        }
        if (_validated > 0) {
            return false;
        }
        adata["cruise_id"] = table_id;
        adata["number_day"] = $_form.find("input[name='number_day']").val();
        adata["number_night"] = $_form.find("input[name='number_night']").val();
        adata["cruise_itinerary_id"] = $cruise_itinerary_id;
        adata["title_itinerary"] = $_form
            .find("input[name='title_itinerary']")
            .val();
        adata["listService"] = [];
        adata["duration_custom"] = $_form
            .find("input[name='duration_custom']")
            .val();
        adata["duration_type"] = $_form
            .find("input[name='duration_type']:checked")
            .val();
        console.log($_form.find("input[name='duration_type']"));
        $_form
            .find("input[name='listService[]']:checked")
            .each(function (index, elm) {
                adata["listService"].push($(elm).val());
            });
        if ($_form.find(".textarea_intro_editor").length) {
            $(".textarea_intro_editor").each(function () {
                var column = $(this).data("column"),
                    editorId = $(this).attr("id");
                adata[column] = $Core.util.getTextAreaContent(editorId);
            });
        }

        adata["tp"] = "S";
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=cruise&act=ajLoadFormItinerary",
            data: adata,
            dataType: "json",
            success: function (res) {
                vietiso_loading(0);
                if (res.result) {
                    alertify.success(res.message);
                    loadMainFormStep(table_id, "itinerary");
                    $("#frmMainStep_" + table_id).show();
                    $(".box_add_cruise_new").html("").hide();
                    // window.location.reload();
                } else {
                    alertify.error(res.message);
                }
            },
        });
        return false;
    });

    $(document).on("click", ".checkall_checkbox", function (ev) {
        var $_this = $(this);
        var group = $_this.attr("group");
        if ($_this.is(":checked")) {
            $(".checkitem_checkbox[group='" + group + "']").attr(
                "checked",
                "checked"
            );
        } else {
            $(".checkitem_checkbox[group='" + group + "']").removeAttr(
                "checked"
            );
        }
    });
    $(document).on("click", ".chk_Meal", function (ev) {
        var $_this = $(this);
        var group = $_this.attr("group");
        var length_checkbox = $_this
            .closest(".fieldarea")
            .find(".chk_Meal").length;
        var length_checked = $_this
            .closest(".fieldarea")
            .find(".chk_Meal:checked").length;
        if (length_checkbox == length_checked) {
            $(".checkall_checkbox[group='" + group + "']").attr(
                "checked",
                "checked"
            );
        } else {
            $(".checkall_checkbox[group='" + group + "']").removeAttr(
                "checked"
            );
        }
    });
    // Cruise Destination
    if ($SiteHasDestinationCruises == "1") {
        $_document.on("change", ".slb_Chauluc_Id", function (ev) {
            var $_this = $(this),
                $_chauluc_id = $_this.val(),
                $_toId = $_this.attr("toId");
            if (parseInt($_chauluc_id) > 0) {
                vietiso_loading(1);
                $.post(
                    path_ajax_script + "/?mod=" + mod + "&act=ajLoadCountry",
                    {
                        chauluc_id: $_chauluc_id,
                    },
                    function (html) {
                        vietiso_loading(0);
                        if (html.indexOf("EMPTY") >= 0) {
                            $("#" + "slb_country_Id_Container").addClass(
                                "hidden"
                            );
                            $("#" + "slb_region_Id_Container").addClass(
                                "hidden"
                            );
                            $("#" + "slb_city_Id_Container").addClass("hidden");
                            $("#" + "slb_placetogoID_Container").addClass(
                                "hidden"
                            );
                        } else {
                            $("#" + "slb_country_Id_Container").removeClass(
                                "hidden"
                            );
                            $("#" + $_toId).html(html);
                        }
                    }
                );
            } else {
                $("#" + "slb_country_Id_Container").addClass("hidden");
                $("#" + "slb_region_Id_Container").addClass("hidden");
                $("#" + "slb_city_Id_Container").addClass("hidden");
                $("#" + "slb_placetogoID_Container").addClass("hidden");
            }
        });
        $_document.on("change", ".slb_Country_Id", function (ev) {
            var $_this = $(this),
                $_toId = $_this.attr("toId"),
                $_country_id = $_this.val(),
                SiteActive_region = $_this.attr("SiteActive_region"),
                SiteActive_city = $_this.attr("SiteActive_city");
            $("#" + "slb_region_Id_Container").addClass("hidden");
            $("#" + "slb_city_Id_Container").addClass("hidden");
            $("#" + "slb_placetogoID_Container").addClass("hidden");
            if (parseInt($_country_id) > 0) {
                loadRegion($_country_id);
            } else {
                $("#" + "slb_city_Id_Container").addClass("hidden");
                $("#" + "slb_placetogoID_Container").addClass("hidden");
            }
            return false;
        });
        $_document.on("change", ".slb_Region_Id", function (ev) {
            var $_this = $(this),
                $_region_id = $_this.val(),
                $_country_id = $("#" + "slb_CountryID").val(),
                $_toId = $_this.attr("toId");
            if (parseInt($_region_id) > 0) {
                vietiso_loading(1);
                $.post(
                    path_ajax_script +
                        "/?mod=" +
                        mod +
                        "&act=ajmakeSelectCityGlobal",
                    {
                        country_id: $_country_id,
                        region_id: $_region_id,
                    },
                    function (html) {
                        vietiso_loading(0);
                        if (html.indexOf("EMPTY") >= 0) {
                            $("#slb_CityID").hide();
                        } else {
                            $("#" + "slb_city_Id_Container").removeClass(
                                "hidden"
                            );
                            $("#" + "slb_placetogoID_Container").addClass(
                                "hidden"
                            );
                            $("#slb_CityID").html(html);
                        }
                    }
                );
            } else {
                $("#" + "slb_city_Id_Container").addClass("hidden");
                $("#" + "slb_placetogoID_Container").addClass("hidden");
            }
        });
        $_document.on("change", ".slb_City_Id", function (ev) {
            var $_this = $(this),
                $_city_id = $_this.val(),
                $_region_id = $("#" + "slb_RegionID").val(),
                $_country_id = $("#" + "slb_CountryID").val(),
                $_toId = $_this.attr("toId");

            if (parseInt($_city_id) > 0) {
                vietiso_loading(1);
                $.post(
                    path_ajax_script +
                        "/?mod=" +
                        mod +
                        "&act=ajmakeSelectPlaceToGoGlobal",
                    {
                        country_id: $_country_id,
                        region_id: $_region_id,
                        city_id: $_city_id,
                    },
                    function (html) {
                        vietiso_loading(0);
                        if (html.indexOf("EMPTY") >= 0) {
                            $("#" + "slb_placetogoID_Container").addClass(
                                "hidden"
                            );
                        } else {
                            $("#" + "slb_placetogoID_Container").removeClass(
                                "hidden"
                            );
                            $("#" + $_toId).html(html);
                        }
                    }
                );
            } else {
                $("#" + "slb_placetogoID_Container").addClass("hidden");
            }
        });
        /*$(document).on('change', '#slb_Chauluc', function(ev){
			var $_this=$(this);
			if(parseInt($_this.val()) > 0){
				loadCountry($_this.val());
			}else{
				$('select[name=country_id]').html('<option value="0"><< '+country+' >></option>').hide();	
				$('select[name=region_id]').html('<option value="0"><< '+regions+' >></option>').hide();
				$('select[name=city_id]').html('<option value="0"><< '+cities+' >></option>').hide();
			}
		});
		$(document).on('change', '#slb_Country', function(ev){
			var $_this = $(this);
			if (parseInt($_this.val()) > 0) {
				if ($SiteActive_region == '1') {
					loadRegion($_this.val());
					$('#slb_CityID').hide();
					$('#slb_placetogoID').hide();
				}else{
					loadCity($_this.val());
					$('#slb_placetogoID').hide();
				}
			} else {
				$('#slb_RegionID').hide();
				$('#slb_CityID').hide();
				$('#slb_placetogoID').hide();

			}
		});
		$(document).on('change', '#slb_RegionID', function(ev){
			var $_this=$(this);
			var $country_id = $('#slb_Country').val();
			if($country_id==undefined){
				$country_id = $('#Hid_Country').val();
			}
			loadCity($country_id, $_this.val());
		});
		$(document).on('change', '#slb_CityID', function(ev) {
			var $_this = $(this);
			if ($SiteModActive_country == '1') {
				var $country_id = $('#slb_Country').val();
				if ($country_id == undefined) {
					$country_id = $('#Hid_Country').val();
				}
				loadPlaceTogo($country_id, $_this.val());
			} else {
				loadPlaceTogo(0, $_this.val());
			}
		});*/
        // Destination
        $(document).on("click", ".ajQuickAddDestination", function (ev) {
            var $_this = $(this);

            if ($SiteModActive_continent == "1") {
                var $chauluc_id = $("#slb_Chauluc").val();
                if ($chauluc_id == undefined) {
                    $chauluc_id = 0;
                }
            }
            if ($SiteActive_region == "1") {
                var $area_id = $("#slb_AreaID").val();
                if ($area_id == undefined) {
                    $area_id = 0;
                }
            }
            if ($SiteModActive_country == "1") {
                var $country_id = 1;
                if ($(".Hid_Country").length) {
                    $country_id = $(".Hid_Country").val();
                } else {
                    $country_id = $(".slb_Country_Id").val();
                }
                if ($country_id == 0 || $city_id == 0) {
                    alertify.error("Error !");
                    return false;
                }
            }
            if ($SiteActive_region == "1") {
                var $region_id = $("#slb_RegionID").val();
                if ($region_id == undefined) {
                    $region_id = 0;
                }
            }
            if ($SiteActive_city == "1") {
                var $city_id = $("#slb_CityID").val();
                if ($city_id == undefined) {
                    $city_id = 0;
                }
            }
            if ($SiteActive_destination == "1") {
                var $destination_id = $("#slb_Destination").val();
                if ($destination_id == undefined) {
                    $destination_id = 0;
                }
            }
            var $placetogo_id = $("#slb_placetogoID").val();

            /**/
            var adata = {};
            if ($SiteModActive_continent == "1") {
                adata["chauluc_id"] = $chauluc_id;
            }
            if ($SiteActive_region == "1") {
                adata["area_id"] = $area_id;
            }
            if ($SiteModActive_country == "1") {
                adata["country_id"] = $country_id;
            }
            if ($SiteActive_region == "1") {
                adata["region_id"] = $region_id;
            }
            if ($SiteActive_city == "1") {
                adata["city_id"] = $city_id;
            }
            if ($SiteActive_destination == "1") {
                adata["destination_id"] = $destination_id;
            }
            adata["cruise_id"] = $cruise_id;
            adata["cruise_itinerary_id"] = $cruise_itinerary_id;
            adata["placetogo_id"] = $placetogo_id;

            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajaxAddMoreCruiseDestination",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    if (html.indexOf("_SUCCESS") >= 0) {
                        loadListDestination($cruise_itinerary_id);
                        if ($SiteModActive_continent == "1") {
                            loadChauLuc();
                        } else {
                            loadCountry();
                        }

                        if ($SiteActive_region == "1") {
                            $("#slb_AreaID").val("");
                            $("#" + "slb_region_Id_Container").addClass(
                                "hidden"
                            );
                        }
                        if ($SiteModActive_country == "1") {
                            $("#slb_Country").val("");
                            $("#" + "slb_country_Id_Container").addClass(
                                "hidden"
                            );
                        }
                        if ($SiteActive_region == "1") {
                            $("#slb_RegionID").val("");
                            $("#slb_region_Id_Container").addClass("hidden");
                        }
                        if ($SiteActive_city == "1") {
                            $("#slb_CityID").val("");
                            $("#" + "slb_city_Id_Container").addClass("hidden");
                        }
                        $("#" + "slb_placetogoID_Container").addClass("hidden");
                    }
                    if (html.indexOf("_EXIST") >= 0) {
                        alertify.error(exist_error);
                    }
                },
            });
            return 0;
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
                        "&act=ajaxDeleteCruiseDestination",
                    data: { cruise_destination_id: $_this.attr("data") },
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
                        loadListDestination($cruise_itinerary_id);
                    },
                });
                return false;
            }
        });
        $(document).on(
            "click",
            ".ajRemoveAllDestinationInCruise",
            function (ev) {
                var $_this = $(this);
                if (confirm(confirm_delete)) {
                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url:
                            path_ajax_script +
                            "/?mod=" +
                            mod +
                            "&act=ajaxDeleteAllCruiseDestination",
                        data: { cruise_id: $cruise_id },
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
                            loadListDestination($cruise_itinerary_id);
                        },
                    });
                    return false;
                }
            }
        );
        $(document).on("click", ".ajClickAddCity", function (ev) {
            var $_this = $(this);
            var $_form = $_this.closest(".frmPop");
            var $chauluc_id = $_form.find("select[name=chauluc_id]");
            var $area_id = $_form.find("select[name=area_id]");

            var $country_id = $_form.find("select[name=country_id]");
            if ($country_id.val() == "" || $country_id.val() == "0") {
                $country_id.focus();
                alertify.error(field_is_required);
                return false;
            }

            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajLoadFormAddQuickCity",
                dataType: "html",
                data: {
                    country_id: $country_id.val(),
                    chauluc_id: $chauluc_id.val(),
                    area_id: $area_id.val(),
                    forid: $_this.attr("forid"),
                },
                success: function (html) {
                    makepopup("400px", "", html, "cmsbox_BoxAddCity");
                    vietiso_loading(0);
                },
            });
        });
        $(document).on("click", ".ajSubmitQuickCity", function (ev) {
            var $_this = $(this);
            var $forid = $_this.attr("forid");
            var $country_id = $_this.attr("country_id");
            if ($("#cmsbox_BoxAddCity input[name=title]").val() == "") {
                $("#cmsbox_BoxAddCity input[name=title]").focus();
                alertify.error(field_is_required);
                return false;
            }

            var $chauluc_id = $_this.attr("chauluc_id");
            var $area_id = $_this.attr("area_id");

            vietiso_loading(1);
            var adata = {
                city_id: $_this.attr("data"),
                title: $("#cmsbox_BoxAddCity input[name=title]").val(),
                country_id: $country_id,
                chauluc_id: $chauluc_id,
                area_id: $area_id,
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSubmitQuickCity",
                data: adata,
                dataType: "html",
                success: function (html) {
                    if (html.indexOf("_SUCCESS") >= 0) {
                        alertify.success(insert_success);
                        $("#cmsbox_BoxAddCity .close_pop").trigger("click");
                        loadCity($country_id);
                    }
                    if (html.indexOf("_ERROR") >= 0) {
                        alertify.success(insert_error);
                    }
                    if (html.indexOf("_EXIST") >= 0) {
                        alertify.success(exist_error);
                    }
                    vietiso_loading(0);
                },
            });
        });
    }

    /* CRUISE_ITINERARY_DAY */
    $(document).on("keyup", 'input[name="day"]', function () {
        var max = $(this).attr("max");
        var value = $(this).val();
        if (value > max) {
            $(this).val(max);
        }
    });
    $(document).on("click", ".clickToAddItineraryDay", function (ev) {
        vietiso_loading(1);
        let $number_day = $('input[name="number_day"]').val();
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=SiteCruiseItineraryDay",
            data: {
                cruise_itinerary_id: $cruise_itinerary_id,
                number_day: $number_day,
                tp: "F",
            },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                makepopupnotresize(
                    "90%",
                    "auto",
                    html,
                    "SiteFrmCruiseItineraryDay"
                );
                $("#SiteFrmCruiseItineraryDay").css("top", "20px");
                var $editorID = $(".textarea_itinerary_content_editor").attr(
                    "id"
                );
                $("#" + $editorID).isoTextAreaFix();
            },
        });
        return false;
    });
    $(document).on("click", ".clickEditItineraryDay", function (ev) {
        var $_this = $(this);
        var $cruise_itinerary_id = $_this.data("cruise_itinerary_id");
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=SiteCruiseItineraryDay",
            data: {
                cruise_itinerary_day_id: $_this.attr("data"),
                cruise_itinerary_id: $cruise_itinerary_id,
                tp: "F",
            },
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                makepopupnotresize(
                    "90%",
                    "auto",
                    html,
                    "SiteFrmCruiseItineraryDay"
                );
                $("#SiteFrmCruiseItineraryDay").css("top", "20px");
                var $editorID = $(".textarea_itinerary_content_editor").attr(
                    "id"
                );
                $("#" + $editorID).isoTextAreaFix();
            },
        });
        return false;
    });
    $(document).on("click", ".btnSaveCruiseItineraryDay", function (ev) {
        ev.preventDefault();
        var $_this = $(this);
        var $_form = $_this.closest(".frmPop");
        var $title = $_form.find("input[name=title]");
        var $day = $_form.find("input[name=day]");
        var $transport = getCheckBoxValueByClass("chk_Transport");
        var $editorID = $(".textarea_itinerary_content_editor").attr("id");
        var $content = tinyMCE.get($editorID).getContent();
        var $cruise_itinerary_day_id = $_this.attr("cruise_itinerary_day_id");
        var $image = $_form.find("input[name=isoman_url_image]");
        var $is_show_image = $("input[name=is_show_image]:checked").val();

        if ($.trim($title.val()) == "") {
            $title.focus().addClass("error");
            alertify.error(field_is_required);
            return false;
        }
        if ($.trim($day.val()) == "") {
            $day.focus().addClass("error");
            alertify.error(field_is_required);
            return false;
        }

        let $number_day = $('input[name="number_day"]').val();
        let $number_night = $('input[name="number_night"]').val();
        let $meal = new Array();
        $('input[name="meal[]"]:checked').each(function (index, elm) {
            $meal.push($(elm).val());
        });
        var adata = {};
        adata["title"] = $.trim($title.val());
        adata["day"] = $.trim($day.val());
        adata["content"] = $content;
        adata["transport"] = $transport;
        adata["image"] = $image.val();
        adata["cruise_itinerary_day_id"] = $cruise_itinerary_day_id;
        adata["cruise_itinerary_id"] = $cruise_itinerary_id;
        adata["number_day"] = $number_day;
        adata["number_night"] = $number_night;
        adata["meal"] = $meal;
        adata["tp"] = "S";

        vietiso_loading(1);
        $("#frmItinerary").ajaxSubmit({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=SiteCruiseItineraryDay",
            data: adata,
            dataType: "html",
            success: function (html) {
                vietiso_loading(0);
                if (html.indexOf("_INSERT_SUCCESS") >= 0) {
                    alertify.success(insert_success);
                    var number_day = $(".box_add_cruise_new")
                        .find("input[name='number_day']")
                        .val();
                    $("#tblCruiseItineraryDay").data("number_day", number_day);
                    loadCruiseItineraryDay($cruise_itinerary_id);
                    $_form.find(".close_pop").trigger("click");
                }
                if (html.indexOf("_UPDATE_SUCCESS") >= 0) {
                    alertify.success(update_success);
                    loadCruiseItineraryDay($cruise_itinerary_id);
                    $_form.find(".close_pop").trigger("click");
                }
                if (html.indexOf("_ERROR") >= 0) {
                    alertify.error(insert_error);
                }
                if (html.indexOf("_EXIST") >= 0) {
                    alertify.error(exist_error);
                }
            },
        });
        return false;
    });
    $(document).on("click", ".moveCruiseItineraryDay", function (ev) {
        var _this = $(this);
        var adata = {
            cruise_itinerary_day_id: _this.attr("data"),
            cruise_itinerary_id: $cruise_itinerary_id,

            direct: _this.attr("direct"),
            tp: "M",
        };
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=SiteCruiseItineraryDay",
            data: adata,
            dataType: "html",
            success: function (html) {
                loadCruiseItineraryDay($cruise_itinerary_id);
                vietiso_loading(0);
            },
        });
    });
    $(document).on("click", ".clickDeleteItinerary", function (ev) {
        var _this = $(this);
        var $cruise_itinerary_id = _this.data("cruise_itinerary_id");
        if (confirm(confirm_delete)) {
            var adata = {
                cruise_itinerary_id: $cruise_itinerary_id,
                cruise_itinerary_day_id: _this.attr("data"),
                tp: "D",
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteCruiseItineraryDay",
                data: adata,
                dataType: "html",
                success: function (html) {
                    loadCruiseItineraryDay($cruise_itinerary_id);
                    alertify.success(delete_success);
                    vietiso_loading(0);
                },
            });
        }
        return false;
    });
    /*==end add itinerary*/
        /*==add cruise video==*/
    $(document).on(
        "click",
        ".addCruiseVideo,.edit_cruise_video",
        function (e) {
            e.preventDefault();
            var $_this = $(this);
            vietiso_loading(1);
            let $cruise_video_id = $_this.data("cruise_video_id") || 0;
            let $c_id = $_this.data("cruise_id") || (typeof table_id !== 'undefined' ? table_id : (typeof pvalTable !== 'undefined' ? pvalTable : 0));
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSiteFrmCruiseVideo",
                data: {
                    cruise_id: $c_id,
                    cruise_video_id: $cruise_video_id,
                    tp: "F",
                },
                dataType: "json",
                success: function (res) {
                    if (res.result) {
                        $("#box_CreateVideo").remove();
                        $("#isoblanketpop_box_CreateVideo").remove();
                        makepopupnotresize(
                            "35%",
                            "auto",
                            res.html,
                            "box_CreateVideo"
                        );
                        $("#box_CreateVideo").css("top", 80 + "px");
                    }
                    vietiso_loading(0);
                },
                error: function() {
                    vietiso_loading(0);
                }
            });
            return false;
        }
    );
    $(document).on("click", ".ajSubmitCruiseVideo", function (e) {
        e.preventDefault();
        var $_this = $(this);
        var $_form = $_this.closest(".frmform, .frmPop");
        var $title = $_form.find("input[name=title]");
        var $url = $_form.find("input[name=url]");
        var $cruise_video_id = $_this.attr("cruise_video_id") || 0;
        var $c_id = $_this.attr("cruise_id") || (typeof table_id !== 'undefined' ? table_id : 0);

        $_form.find("input").removeClass("error");
        if ($.trim($title.val()) == "") {
            $title.addClass("error").focus();
            return false;
        }
        if ($.trim($url.val()) == "") {
            $url.addClass("error").focus();
            return false;
        }

        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajSiteFrmCruiseVideo",
            data: {
                cruise_id: $c_id,
                cruise_video_id: $cruise_video_id,
                title: $title.val(),
                url: $url.val(),
                tp: "S",
            },
            dataType: "json",
            success: function (res) {
                vietiso_loading(0);
                if (res.result) {
                    $("#box_CreateVideo").remove();
                    $("#isoblanketpop_box_CreateVideo").remove();
                    loadListCruiseVideo($c_id);
                } else {
                    alertify.error(res.message || "Error");
                }
            },
            error: function() {
                vietiso_loading(0);
            }
        });
        return false;
    });
    $(document).on("click", ".ajDeleteCruiseVideo", function (e) {
        e.preventDefault();
        var $_this = $(this);
        var $cruise_video_id = $_this.data("cruise_video_id");
        var $c_id = $_this.data("cruise_id") || (typeof table_id !== 'undefined' ? table_id : 0);
        if (confirm(__["confirm_delete"] || "Are you sure you want to delete this?")) {
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSiteFrmCruiseVideo",
                data: {
                    cruise_id: $c_id,
                    cruise_video_id: $cruise_video_id,
                    tp: "D",
                },
                dataType: "json",
                success: function (res) {
                    vietiso_loading(0);
                    if (res.result) {
                        loadListCruiseVideo($c_id);
                    } else {
                        alertify.error(res.message || "Error");
                    }
                },
                error: function() {
                    vietiso_loading(0);
                }
            });
        }
        return false;
    });

/*==add price children==*/
    $(document).on(
        "click",
        ".addPriceChild,.edit_cruise_price_child",
        function (e) {
            var $_this = $(this);
            vietiso_loading(1);
            let $cruise_price_child_id = $(this).data("cruise_price_child_id");
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSiteFrmPriceChildren",
                data: (adata = {
                    cruise_id: $cruise_id,
                    cruise_price_child_id: $cruise_price_child_id,
                    tp: "F",
                }),
                dataType: "json",
                success: function (res) {
                    if (res.result) {
                        makepopupnotresize(
                            "30%",
                            "auto",
                            res.html,
                            "box_CreatePriceChilren"
                        );
                        $("#box_CreatePriceChilren").css("top", 80 + "px");
                        $(".price").priceFormat({
                            thousandsSeparator: ".",
                            centsLimit: 0,
                        });
                    }

                    vietiso_loading(0);
                },
            });
            return false;
        }
    );
    $(document).on("click", ".ajSubmitCruisePriceChildren", function (e) {
        var $_this = $(this);
        var $_form = $_this.closest(".frmPop");
        /**/
        var $title = $_form.find("input[name=title]");
        var $number_to = $_form.find("input[name=max]");
        var $number_from = $_form.find("input[name=min]");
        var $price = $_form.find("input[name=price]");
        var $price_type = $_form.find("select[name=price_type]");
        var $cruise_price_child_id = $_this.attr("cruise_price_child_id");
        var $cruise_id = $_this.attr("cruise_id");
        /**/
        $_form.find("input,select").removeClass("error");
        if ($.trim($title.val()) == "") {
            $title.addClass("error").focus();
            alertify.error(field_is_required);
            return false;
        }
        if ($number_from.val() == "") {
            $number_from.addClass("error").focus();
            alertify.error(field_is_required);
            return false;
        } else if ($number_from.val() < 0) {
            $number_from.addClass("error").focus();
            alertify.error(field_valid);
            return false;
        }
        if ($number_to.val() == "") {
            $number_to.addClass("error").focus();
            alertify.error(field_is_required);
            return false;
        } else if ($number_to.val() < 0) {
            $number_to.addClass("error").focus();
            alertify.error(field_valid);
            return false;
        }
        if (parseInt($number_from.val()) > parseInt($number_to.val())) {
            $number_from.addClass("error").focus();
            $number_to.addClass("error").focus();
            alertify.error(field_valid);
            return false;
        }
        if ($price.val() == "") {
            $price.addClass("error").focus();
            alertify.error(field_is_required);
            return false;
        } else if (
            $price_type.val() == 1 &&
            parseInt($price.val().replaceAll(".", "")) > 100
        ) {
            $price.addClass("error").focus();
            alertify.error(field_valid);
            return false;
        }
        var adata = {
            title: $title.val(),
            number_to: $number_to.val(),
            number_from: $number_from.val(),
            price: $price.val(),
            price_type: $price_type.val(),
            cruise_price_child_id: $cruise_price_child_id,
            cruise_id: $cruise_id,
            tp: "S",
        };
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url:
                path_ajax_script +
                "/index.php?mod=" +
                mod +
                "&act=ajSiteFrmPriceChildren",
            data: adata,
            dataType: "json",
            success: function (res) {
                vietiso_loading(0);
                if (res.result) {
                    if (res.message == "_SUCCESS") {
                        alertify.success(insert_success);
                    } else if (res.message == "_UPDATE_SUCCESS") {
                        alertify.success(update_success);
                    }
                    loadListPriceChildren($cruise_id);
                    $_form.find(".close_pop").trigger("click");
                } else {
                    if (res.message == "_TITLEINVALID") {
                        $title.addClass("error").focus();
                        alertify.error(field_valid);
                    } else if (res.message == "_INVALID") {
                        $number_from.addClass("error").focus();
                        $number_to.addClass("error").focus();
                        alertify.error($error_exist_people);
                    } else if (res.message == "_INSERT_ERROR") {
                        alertify.error(insert_error);
                    } else if (res.message == "_UPDATE_ERROR") {
                        alertify.error(update_error);
                    } else {
                        alertify.error(exist_error);
                    }
                }
            },
        });
    });
    $(".ajDeleteCruisePriceChildren").live("click", function () {
        var $_this = $(this);
        if (confirm(confirm_delete)) {
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSiteFrmPriceChildren",
                data: {
                    cruise_price_child_id: $_this.data("cruise_price_child_id"),
                    cruise_id: $cruise_id,
                    tp: "D",
                },
                dataType: "json",
                success: function (res) {
                    if (res.result) {
                        alertify.success(delete_success);
                        loadListPriceChildren($cruise_id);
                    } else {
                        alertify.error(delete_error);
                    }
                    vietiso_loading(0);
                },
            });
        }
        return false;
    });
    $(document).on("change", ".check_box_price_by", function (ev) {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajUpdatePriceBy",
            data: {
                cruise_id: $_this.attr("cruise_id"),
                cruise_itinerary_id: $_this.attr("cruise_itinerary_id"),
                price_by: $_this
                    .closest("tr")
                    .find("input[type='radio']:checked")
                    .val(),
                season: $_this.attr("season"),
            },
            dataType: "json",
            success: function (res) {
                if (!res.result) {
                    alertify.error(update_error);
                } else {
                    loadCabinPriceCruise(
                        $_this.attr("cruise_itinerary_id"),
                        $_this.attr("cruise_id")
                    );
                }
                vietiso_loading(0);
            },
        });
    });
    $(document).on("change", ".cruise_season_price", function (ev) {
        var $_this = $(this);
        const overnight = $_this.hasClass("overnight") ? 1 : 0;
        $trip_price = parseInt($("input[name=trip_price]").val());
        if ($_this.val() > $trip_price && $trip_price > 0) {
            alert("Input data is invalid");
        } else {
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajOpenManageCabinPriceCruise",
                data: {
                    cruise_id: $_this.attr("cruise_id"),
                    cruise_itinerary_id: $_this.attr("cruise_itinerary_id"),
                    cruise_cabin_id: $_this.attr("cruise_cabin_id"),
                    cabin_type_id: $_this.attr("cabin_type_id"),
                    group_size_id: $_this.attr("group_size_id"),
                    season: $_this.attr("season"),
                    number_adult: $_this.attr("number_adult"),
                    price: $_this.val(),
                    price_by: $_this
                        .closest("tr")
                        .find("input[type='radio']:checked")
                        .val(),
                    tp: "S",
                    overnight,
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    var htm = html.split("|||");
                    $_this.val(htm[1]);
                    loadCabinPriceCruise(
                        $_this.attr("cruise_itinerary_id"),
                        $cruise_id
                    );
                },
            });
        }
    });
    $(document).on("change", ".cruise_season_price_extra_bed", function (ev) {
        var $_this = $(this);
        $trip_price = parseInt($("input[name=trip_price]").val());
        if ($_this.val() > $trip_price && $trip_price > 0) {
            alert("Input data is invalid");
        } else {
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=ajOpenManageCabinPriceCruise",
                data: {
                    cruise_id: $_this.attr("cruise_id"),
                    cruise_itinerary_id: $_this.attr("cruise_itinerary_id"),
                    cruise_cabin_id: $_this.attr("cruise_cabin_id"),
                    cabin_type_id: $_this.attr("cabin_type_id"),
                    group_size_id: $_this.attr("group_size_id"),
                    season: $_this.attr("season"),
                    price: $_this
                        .closest("tr")
                        .find("input.cruise_season_price_extra_bed")
                        .val(),
                    price_by: $_this
                        .closest("tr")
                        .find("input[type='radio']:checked")
                        .val(),
                    tp: "S_EXB",
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    var htm = html.split("|||");
                    $_this.val(htm[1]);
                    loadCabinPriceCruise(
                        $_this.attr("cruise_itinerary_id"),
                        $cruise_id
                    );
                },
            });
        }
    });
    /*==end add price children==*/

    $_document.on("click", ".toggle_opt .online_tour", function () {
        var $_this = $(this);
        var is_online = $_this.data("val");
        var text_last = $_this.data("text_last");
        var text = $_this.text();
        var adata = {};
        adata["clsTable"] = $_this.data("clstable");
        adata["pkey"] = $_this.data("pkey");
        adata["pvalTable"] = $_this.data("sourse_id");
        adata["toField"] =
            $_this.attr("toField") != undefined
                ? $_this.attr("toField")
                : "is_online";
        adata["val"] = parseInt(is_online) == 0 ? 1 : 0;
        adata["allowDuplicate"] = 1;

        $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=home&act=saveField",
            data: adata,
            dataType: "html",
            success: function (html) {
                var val = is_online == 1 ? 0 : 1;
                if ($_this.hasClass("private_tour")) {
                    $_this.removeClass("private_tour");
                } else {
                    $_this.addClass("private_tour");
                }
                $_this.text(text_last);
                $_this.data({ val: html, text_last: text });
            },
        });
    });

    $_document.on("keyup", ".input-title", function () {
        var $_this = $(this),
            table_id = $_this.data("table_id"),
            _title = $_this.val();
        $(".table-title[table_id=" + table_id + "]").html(_title);
        return false;
    });
    $_document.on("keyup", ".input_code", function () {
        var $_this = $(this),
            table_id = $_this.data("table_id"),
            _trip_code = $_this.val();
        $(".table_code[table_id=" + table_id + "]").html(_trip_code);
        return false;
    });
    $_document.on("keyup", 'input[type="number"]', function () {
        var value = $(this).val();
        $(this).val(parseInt(value));
        return false;
    });
    $_document.on("click", ".panel-edited > .panel-heading", function (e) {
        e.preventDefault();
        $(".panel-heading a").addClass("collapsed");
        $(".panel-edited > .panel-heading").removeClass("current");
        $(".panel-edited > .panel-collapse").removeClass("show");
        $(this).find("a").removeClass("collapsed");
        $(this).toggleClass("current");
        var panel = $(this).closest(".panel");
        panel.find(".panel-collapse").addClass("show");
        panel
            .find(
                ".panel-collapse>.panel-body>ul.stepbar-list>li:first-child>.loadYieldStep"
            )
            .trigger("click");
        $(".box_add_cruise_new").html("").hide();
        $("#frmMainStep_" + table_id).show();
    });
    $_document.on("click", ".loadYieldStep", function () {
        var $_this = $(this),
            href = $_this.data("route"),
            table_id = $_this.data("table_id"),
            currentstep = $_this.data("step"),
            step_id = $_this.data("step_id");
        $(".stepbar-list>li>a.active").removeClass("active");
        $_this.addClass("active");
        loadMainFormStep(table_id, currentstep, step_id);
        if (step_id > 0) {
            loadCabinPriceCruise($cruise_itinerary_id, table_id);
        }
        $("html,body").animate({ scrollTop: 0 }, 500);
        window.history.pushState({ href: href }, "", href);
        return false;
    });
    $_document.on("click", ".js_save_continue,.js_save_back", function () {
        var $_this = $(this),
            $_form = $_this.closest("form"),
            table_id = $_this.data("table_id"),
            currentstep = $_this.data("currentstep"),
            nextstep = $_this.data("next_step"),
            step_id = $_this.data("step_id");

        var _validated = 0;
        if (
            $("input.required,select.required,textarea.required", $_form).length
        ) {
            $("input.required,select.required,textarea.required", $_form).each(
                function () {
                    if ($Core.util.isEmpty($(this).val())) {
                        _validated++;
                        $(this).focus();
                        $(this).addClass("error");
                        if (
                            $(this).hasClass("chosen-select") &&
                            $(this).attr("multiple") == "multiple"
                        ) {
                            $(this).next().addClass("error");
                        }
                        return false;
                    } else {
                        $(this).removeClass("error");
                        if (
                            $(this).hasClass("chosen-select") &&
                            $(this).attr("multiple") == "multiple"
                        ) {
                            $(this).next().removeClass("error");
                        }
                    }
                }
            );
        }
        if (_validated > 0) {
            return false;
        }

        if ($_this.hasClass("js_save_back")) {
            nextstep = $_this.data("prevstep");
        }
        var options = {};
        if ($(".textarea_intro_editor[table_id=" + table_id + "]").length) {
            $(".textarea_intro_editor[table_id=" + table_id + "]").each(
                function () {
                    var column = $(this).data("column"),
                        editorId = $(this).attr("id");
                    options[column] = $Core.util.getTextAreaContent(editorId);
                }
            );
        }
        $(".stepbar-list>li>a.active").removeClass("active");
        $(".loadYieldStep[data-step=" + nextstep + "]").addClass("active");
        var currentpanel = $_this.data("panel"),
            nextpanel = $(".stepbar-list>li>a.active").attr("panel"),
            $_href = $(".stepbar-list>li>a.active").data("route");
        $(".panel-heading a").addClass("collapsed");
        if (currentpanel != nextpanel) {
            $(".panel--" + currentpanel)
                .find(".panel-collapse")
                .removeClass("show");
            $(".panel--" + nextpanel)
                .find(".panel-heading a")
                .removeClass("collapsed");
            $(".panel--" + nextpanel)
                .find(".panel-collapse")
                .addClass("show");
        }

        if (currentstep == "itinerary") {
            loadMainFormStep(table_id, nextstep, step_id);
            var $_bdata = { table_id: table_id, currentstep: currentstep };
            $.post(
                path_ajax_script + "/index.php?mod=" + mod + "&act=check_step",
                $_bdata,
                function (html) {
                    if (html == 1) {
                        $(".loadYieldStep[step=" + currentstep + "]").addClass(
                            "success"
                        );
                    } else {
                        $(
                            ".loadYieldStep[step=" + currentstep + "]"
                        ).removeClass("success");
                    }
                }
            );
        } else {
            var _validated = 0;
            if (currentstep == "duration") {
                var number_day = $("input[name=number_day]").val(),
                    number_night = $("input[name=number_night]").val();
                if ($Core.util.isEmpty(number_day)) number_day = 0;
                if ($Core.util.isEmpty(number_night)) number_night = 0;
                number_day = parseInt(number_day);
                number_night = parseInt(number_night);
                if (number_day > number_night) {
                    if (number_day - number_night > 1) {
                        $Core.alert.alert(
                            __["Message"],
                            "Số ngày không hợp lệ"
                        );
                        return false;
                    }
                } else if (number_day < number_night) {
                    if (number_night - number_day > 1) {
                        $Core.alert.alert(__["Message"], "Số đêm không hợp lệ");
                        return false;
                    }
                }
            } else if (currentstep == "basic") {
                if ($("input.required,select.required", $_form).length) {
                    $("input.required,select.required", $_form).each(
                        function () {
                            if ($Core.util.isEmpty($(this).val())) {
                                _validated++;
                                $(this).focus();
                                return false;
                            }
                        }
                    );
                }
                /***/
                var table_code = $('input[name="cruise_code"]').val();
                $.ajax({
                    type: "POST",
                    async: false,
                    data: { table_code: table_code, table_id: table_id },
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=check_table_code",
                    success: function (html) {
                        if (html.indexOf("_invalid") >= 0) {
                            _validated = 1;
                            $("input[name=table_code]").focus();
                            $Core.alert.alert(
                                __["Message"],
                                "Mã code này đã tồn tại"
                            );
                        }
                    },
                });
            } else if (currentstep == "age") {
            }
            if (parseInt(_validated) == 0) {
                $Core.util.toggleIndicatior(0);
                $_form.ajaxSubmit({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=ajSaveMainStep",
                    data: $.extend(options, {
                        table_id: table_id,
                        currentstep: currentstep,
                    }),
                    dataType: "html",
                    success: function (html) {
                        $Core.util.toggleIndicatior(0);
                        if (html.indexOf("_EXIST") >= 0) {
                            alertify.error(insert_error_exist);
                            return false;
                        }
                        if (nextstep !== "_last" && nextstep !== "_first") {
                            loadMainFormStep(table_id, nextstep, step_id);
                        } else if (nextstep == "_last") {
                            location.href = `${path_ajax_script}/${mod}/${act}/${pvalTable}/overview/basic`;
                            // loadMainFormStep(table_id, 'basic',step_id);
                        }
                    },
                });
                window.history.pushState({ href: $_href }, "", $_href);
                return false;
            }
        }
    });
    if (mod == "cruise" && act == "insert") {
        if ($SiteActive_region == "1") {
            loadRegion(country_id, region_id);
        }

        /* HOTEL_CUSTOM_FIELD */
        loadCustomField(table_id);
        $(document).on("click", ".ClickCustomField", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/?mod=" +
                    mod +
                    "&act=SiteCruiseCustomField",
                data: { table_id: table_id, tp: "C" },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    location.href = REQUEST_URI;
                },
            });
            return false;
        });
        $(".changeToStore").live("change", function () {
            var $_this = $(this);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajUpdateCruiseStore",
                data: {
                    _type: $_this.attr("_type"),
                    table_id: $_this.attr("data"),
                    val: $_this.is(":checked") ? 1 : 0,
                },
                dataType: "html",
                success: function (html) {},
            });
        });
        $(document).on("click", ".btndelete_customfield", function (ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=" +
                        mod +
                        "&act=SiteCruiseCustomField",
                    data: {
                        cruise_customfield_id: $_this.attr("data"),
                        tp: "D",
                    },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        location.href = REQUEST_URI;
                    },
                });
            }
            return false;
        });
        $(document).on("click", ".btnedit_customfield", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteCruiseCustomField",
                data: {
                    tp: "F",
                    cruise_customfield_id: $_this.attr("data"),
                    table_id: $_this.attr("table_id"),
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopup(300, "auto", html, "pop_UpdateFieldName");
                },
            });
            return false;
        });
        $(document).on("click", ".SiteClickUpdateFieldName", function (ev) {
            var $_this = $(this);
            var $_form = $_this.closest(".frmPop");
            var $fieldname = $_form.find("input[name=fieldname]");
            if ($fieldname.val() == "") {
                $fieldname.focus();
                alertiy.error(field_is_required);
                return false;
            }
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteCruiseCustomField",
                data: {
                    tp: "S",
                    cruise_customfield_id: $_this.attr("cruise_customfield_id"),
                    table_id: $_this.attr("table_id"),
                    fieldname: $fieldname.val(),
                },
                dataType: "html",
                success: function (html) {
                    if (html.indexOf("_EXIST") >= 0) {
                        alertify.error("Error !");
                    } else {
                        loadCustomField($_this.attr("table_id"));
                        $_form.find(".close_pop").trigger("click");
                    }
                    location.href = REQUEST_URI;
                },
            });
            return false;
        });
        $(document).on("click", ".btnmove_customfield", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=SiteCruiseCustomField",
                data: {
                    tp: "M",
                    table_id: $_this.attr("table_id"),
                    direct: $_this.attr("direct"),
                    cruise_customfield_id: $_this.attr("data"),
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadCustomField($_this.attr("table_id"));
                },
            });
            return false;
        });

        loadCity(country_id, region_id, city_id);
        /* FUNC */
        $(document).on(
            "change",
            "select[name=iso-continent_id]",
            function (ev) {
                var $_this = $(this);
                var title = $_this.find("option:selected").attr("title");
                $("#slb_Country").html(
                    '<option value="0">' + loading + "</option>"
                );
                $("#slb_Area").html(
                    '<option value="0">-- ' + regions + " --</option>"
                );
                $("#slb_City").html(
                    '<option value="0">-- ' + cities + " --</option>"
                );
                loadCountry($_this.val(), 0);
            }
        );
        $(document).on("change", "select[name=iso-area_id]", function (ev) {
            var $_this = $(this);
            var title = $_this.find("option:selected").attr("title");
            var $country_id = $("select[name=iso-country_id]").val();
            if ($country_id == "undefined" || $country_id == undefined) {
                $country_id = 0;
            }
            loadCity($country_id, $_this.val(), 0);
        });
        $(document).on("change", "select[name=iso-country_id]", function (ev) {
            var $_this = $(this);
            var title = $_this.find("option:selected").attr("title");
            if ($SiteActive_region == "1") {
                loadRegion($_this.val(), 0);
            }
            loadCity($_this.val(), 0, 0);
        });
        $(document).on("change", "select[name=iso-region_id]", function (ev) {
            var $_this = $(this);
            var $country_id = $("select[name=iso-country_id]").val();
            if ($country_id == undefined) {
                $country_id = 0;
            }
            loadCity($country_id, $_this.val(), 0);
        });
        /* START HOTEL_PROPERY_POP */
        $(document).on("click", ".ajaxManagerCruiseProperty", function (ev) {
            var $_this = $(this);
            var adata = {
                type: $_this.attr("_type"),
                fromid: $_this.attr("fromid"),
                forid: $_this.attr("forid"),
                tp: "L",
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajGetBoxManagerCruiseProperty",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("30%", "", html, "frmBoxManagerCruiseProperty");
                },
            });
            return false;
        });
        $(document).on("click", "#btnCreateNewCruiseProperty", function (ev) {
            var $_this = $(this);
            var adata = {
                type: $_this.attr("type"),
                fromid: $_this.attr("fromid"),
                forid: $_this.attr("forid"),
                tp: "F",
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajGetBoxManagerCruiseProperty",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("25%", "", html, "pop_FrmProperty");
                },
            });
        });
        $(document).on("click", ".edit_pop_cruise_property", function (ev) {
            var $_this = $(this);
            if (!$_this.hasClass("disabled")) {
                var adata = {
                    cruise_property_id: $_this.attr("data"),
                    fromid: $_this.attr("fromid"),
                    forid: $_this.attr("forid"),
                    tp: "F",
                };
                $_this.addClass("disabled");
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/?mod=cruise&act=ajGetBoxManagerCruiseProperty",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        $_this.removeClass("disabled");
                        makepopup("20%", "", html, "pop_FrmProperty");
                    },
                });
            }
            return false;
        });
        $(document).on("click", "#ajaxSaveCruiseProperty", function (ev) {
            var $_this = $(this);
            if (!$_this.hasClass("disabled")) {
                var $_form = $_this.closest(".frmPop");

                var $title = $_form.find("input[name=title]");
                var $fromid = $_this.attr("fromid");
                var $forid = $_this.attr("forid");

                if ($title.val() == "") {
                    $title.addClass("error").focus();
                    return false;
                }
                var adata = {
                    cruise_property_id: $_this.attr("cruise_property_id"),
                    type: $_this.attr("_type"),
                    title: $title.val(),
                    tp: "S",
                };
                vietiso_loading(1);
                $_this.addClass("disabled");
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=cruise&act=ajGetBoxManagerCruiseProperty",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        $_this.removeClass("disabled");
                        vietiso_loading(0);
                        if (html.indexOf("IN_SUCCESS") >= 0) {
                            $_form.find(".close_pop").trigger("click");
                            alertify.success(insert_success);
                            loadTableCruiseProperty(
                                $_this.attr("_type"),
                                $fromid,
                                $forid
                            );
                            if ($fromid == "pop_CruiseRoom") {
                                loadSelectBoxRoomFacility(
                                    $_this.attr("property_id"),
                                    $forid
                                );
                            }
                            if ($fromid == "CruiseFacilities") {
                                loadCruiseFacibility($forid);
                            }
                            if ($fromid == "CruiseRating") {
                                loadSelectBoxCruiseRating(
                                    $_this.attr("_type"),
                                    $forid
                                );
                            }
                        }
                        if (html.indexOf("UP_SUCCESS") >= 0) {
                            loadTableCruiseProperty(
                                $_this.attr("_type"),
                                $fromid,
                                $forid
                            );
                            $_form.find(".close_pop").trigger("click");
                            alertify.success(update_success);

                            if ($fromid == "pop_CruiseRoom") {
                                loadSelectBoxRoomFacility(
                                    $_this.attr("property_id"),
                                    $forid
                                );
                            }
                            if ($fromid == "CruiseFacilities") {
                                loadCruiseFacibility($forid);
                            }
                            if ($fromid == "CruiseRating") {
                                loadSelectBoxCruiseRating(
                                    $_this.attr("_type"),
                                    $forid
                                );
                            }
                        }
                        if (html.indexOf("ERROR") >= 0) {
                            alertify.error(error);
                        }
                        if (html.indexOf("EXIST") >= 0) {
                            alertify.error(exist_error);
                        }
                    },
                });
            }
            return false;
        });
        $(document).on("click", ".delete_pop_cruise_property", function (ev) {
            var $_this = $(this);
            if (!$_this.hasClass("disabled")) {
                var $fromid = $_this.attr("fromid");
                var $forid = $_this.attr("forid");
                /**/
                if (confirm(confirm_delete)) {
                    var adata = {
                        cruise_property_id: $_this.attr("data"),
                        tp: "D",
                    };
                    vietiso_loading(1);
                    $_this.addClass("disabled");
                    $.ajax({
                        type: "POST",
                        url:
                            path_ajax_script +
                            "/?mod=cruise&act=ajGetBoxManagerCruiseProperty",
                        data: adata,
                        dataType: "html",
                        success: function (html) {
                            $_this.removeClass("disabled");
                            vietiso_loading(0);
                            loadTableCruiseProperty(
                                $_this.attr("_type"),
                                $_this.attr("fromid"),
                                $_this.attr("forid")
                            );
                            if ($fromid == "pop_CruiseRoom") {
                                loadSelectBoxRoomFacility(
                                    $_this.attr("cruise_property_id"),
                                    $forid
                                );
                            }
                            if ($fromid == "CruiseFacilities") {
                                loadCruiseFacibility($forid);
                            }
                            if ($fromid == "CruiseRating") {
                                loadSelectBoxCruiseRating(
                                    $_this.attr("_type"),
                                    $forid
                                );
                            }
                        },
                    });
                }
            }
            return false;
        });
        /* END HOTEL_PROPERY_POP */

        /* START HOTEL ROOM */
        $(document).on("click", "#clickToAddCruiseRoom", function (ev) {
            var $_this = $(this);
            var adata = {};
            adata["table_id"] = table_id;
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajaxAddCruiseRoom",
                dataType: "html",
                data: adata,
                success: function (html) {
                    makepopup(
                        "991px",
                        "auto",
                        html,
                        "pop_CruiseRoom",
                        "frmPop2"
                    );
                    $("#pop_CruiseRoom").css("top", "30px");
                    $(".price_format").priceFormat({
                        thousandsSeparator: ".",
                        centsLimit: 0,
                    });
                    vietiso_loading(0);
                },
            });
            return false;
        });
        $(document).on("click", ".clickEditCruiseRoom", function (ev) {
            var $_this = $(this);
            var adata = {
                cruise_room_id: $_this.attr("data"),
                table_id: $_this.attr("cruise_id"),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajaxAddCruiseRoom",
                dataType: "html",
                data: adata,
                success: function (html) {
                    makepopup(
                        "991px",
                        "auto",
                        html,
                        "pop_CruiseRoom",
                        "frmPop2"
                    );
                    $("#pop_CruiseRoom").css("top", "30px");
                    $(".price_format").priceFormat({
                        thousandsSeparator: ".",
                        centsLimit: 0,
                    });
                    vietiso_loading(0);
                },
            });
            return false;
        });
        $(document).on("click", ".clickEditCruiseRoom_", function (ev) {
            var $_this = $(this);
            var adata = {
                cruise_room_id: $_this.attr("data"),
                cruise_id: $_this.attr("cruise_id"),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajaxAddCruiseRoom",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopupnotresize("60%", "auto", html, "pop_CruiseRoom");
                    $("#pop_CruiseRoom").css("top", 60 + "px");
                    var editor_id = $(".textarea_content_editor").attr("id");
                    $("#" + editor_id).isoTextAreaFull();
                    $("#" + editor_id + "_ifr").height(120);
                    $(".selectbox").chosen({
                        max_selected_options: 100,
                        width: "100%",
                    });
                    $(".price").priceFormat({
                        thousandsSeparator: ".",
                        centsLimit: 0,
                    });
                },
            });
        });
        $(document).on("click", ".deleteCruiseRoomImage", function (ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                var adata = { cruise_room_id: $_this.attr("cruise_room_id") };
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=cruise&act=ajDeleteCruiseRoomImage",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        $("#isoman_show_image_room").attr("src", "");
                        $("#isoman_hidden_image_room").val("");
                        loadCruiseRoom();
                    },
                });
            }
            return false;
        });
        $(document).on("click", "#clickSubmitCruiseRoom", function (ev) {
            var $_this = $(this);
            if (!$_this.hasClass("disabled")) {
                var $title = $("input[name=cruise_room_title]").val();
                var $content = tinyMCE
                    .get($(".textarea_content_editor").attr("id"))
                    .getContent();
                var $image = $("#isoman_hidden_image_room").val();
                if ($title == "") {
                    alertify.error(field_is_required);
                    $("input[name=cruise_room_title]")
                        .addClass("error")
                        .focus();
                    return false;
                }
                var adata = {
                    cruise_room_id: $_this.attr("cruise_room_id"),
                    table_id: $_this.attr("table_id"),
                    intro: $content,
                    image: $image,
                };
                vietiso_loading(1);
                $_this.addClass("disabled");
                $("#frmCruiseRoom").ajaxSubmit({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=cruise&act=ajaxSubmitCruiseRoom",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        $_this.removeClass("disabled");
                        if (html.indexOf("_IN_SUCCESS") >= 0) {
                            loadCruiseRoom();
                            loadCruisePrice();
                            alertify.success(insert_success);
                            $_this
                                .closest(".frmPop")
                                .find(".close_pop")
                                .trigger("click");
                        }
                        if (html.indexOf("_UPDATE_SUCCESS") >= 0) {
                            loadCruiseRoom();
                            loadCruisePrice();
                            alertify.success(update_success);
                            $_this
                                .closest(".frmPop")
                                .find(".close_pop")
                                .trigger("click");
                        }
                        if (html.indexOf("_ERROR") >= 0) {
                            alertify.error(exist_error);
                        }
                        if (html.indexOf("_EXIST") >= 0) {
                            alertify.error(exist_error);
                        }
                    },
                });
            }
            return false;
        });
        $(document).on("click", ".clickDeleteCruiseRoom", function (ev) {
            var $_this = $(this);
            if (confirm(confirm_delete)) {
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=cruise&act=ajDeleteCruiseRoom",
                    data: { cruise_room_id: $_this.attr("data") },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadCruiseRoom();
                        loadCruisePrice();
                        alertify.success(delete_success);
                    },
                });
            }
            return false;
        });

        $("#add_cruise_room").live("click", function (ev) {
            var _this = $(this);
            if ($("#room_stype_id").val() == 0) {
                $("#room_stype_id").focus();
                alertify.error(field_is_required);
                return false;
            }
            if ($("#title_room").val() == "") {
                $("#title_room").focus();
                alertify.error(field_is_required);
                return false;
            }
            if ($("#number_val").val() == "") {
                $("#number_val").focus();
                alertify.error(field_is_required);
                return false;
            }
            if ($("#footage").val() == "") {
                $("#footage").focus();
                alertify.error(field_is_required);
                return false;
            }
            if ($("#price").val() == "") {
                $("#price").focus();
                alertify.error(field_is_required);
                return false;
            }
            var adata = $("#form_add_cruise_room").serialize();
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=" +
                    mod +
                    "&act=ajSaveCruiseRoom",
                data: adata,
                dataType: "html",
                success: function (html) {
                    if (html.indexOf("INSERT_ERROR") >= 0) {
                        alertify.error(insert_error);
                    } else if (html.indexOf("UPDATE_ERROR") >= 0) {
                        alertify.error(update_error);
                    } else if (html.indexOf("UPDATE_SUCCESS") >= 0) {
                        alertify.success(update_success);
                        vietiso_loading(0);
                    } else {
                        alertify.success(insert_success);
                        vietiso_loading(0);
                    }
                },
            });
        });

        $(document).on("click", ".ajmoveCruiseRoom", function (ev) {
            var $_this = $(this);
            var adata = {
                cruise_room_id: $_this.attr("data"),
                table_id: $_this.attr("table_id"),
                direct: $_this.attr("direct"),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajMoveCruiseRoom",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadCruiseRoom();
                },
            });
            return false;
        });

        // Add Cruise Price Col
        $(document).on("click", "#addCruisePriceRow", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajLoadNewCruisePriceRow",
                dataType: "html",
                data: { table_id: pvalTable },
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("300", "", html, "NewCruisePriceRow");
                },
            });
            return false;
        });
        $(document).on("click", "#addCruisePriceCol", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajLoadNewCruisePriceCol",
                dataType: "html",
                data: { table_id: pvalTable },
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("300", "", html, "NewCruisePriceCol");
                },
            });
            return false;
        });
        $(document).on("click", ".editCruisePriceRoom", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajLoadEditCruisePriceRoom",
                dataType: "html",
                data: { id: $_this.attr("data") },
                success: function (html) {
                    vietiso_loading(0);
                    makepopup("300", "", html, "EditCruisePriceRow");
                },
            });
            return false;
        });
        $(document).on("click", ".editCruisePriceCol", function (ev) {
            var $_this = $(this);
            var adata = { table_id: pvalTable };
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajCheckCruisePriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    if (html == 0) {
                        $("#addCruisePriceCol").trigger("click");
                    } else {
                        vietiso_loading(1);
                        $.ajax({
                            type: "POST",
                            url:
                                path_ajax_script +
                                "/index.php?mod=cruise&act=ajLoadEditCruisePriceCol",
                            dataType: "html",
                            data: { id: $_this.attr("data") },
                            success: function (html) {
                                vietiso_loading(0);
                                makepopup(
                                    "300",
                                    "",
                                    html,
                                    "EditCruisePriceCol"
                                );
                            },
                        });
                    }
                },
            });
            return false;
        });
        $(document).on("click", ".editCruisePriceVal", function (ev) {
            var $_this = $(this);
            var adata = { table_id: pvalTable };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajCheckCruisePriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    if (html == 0) {
                        alertify.error(error);
                        $("#addCruisePriceCol").trigger("click");
                    } else {
                        $.ajax({
                            type: "POST",
                            url:
                                path_ajax_script +
                                "/index.php?mod=cruise&act=ajLoadEditCruisePriceVal",
                            dataType: "html",
                            data: {
                                cruise_price_col_id: $_this.attr(
                                    "cruise_price_col_id"
                                ),
                                cruise_price_row_id: $_this.attr(
                                    "cruise_price_row_id"
                                ),
                            },
                            success: function (html) {
                                makepopup(
                                    "20%",
                                    "",
                                    html,
                                    "EditCruisePriceVal"
                                );
                                $("#titleVal").priceFormat({
                                    thousandsSeparator: ".",
                                    centsLimit: 0,
                                });
                            },
                        });
                    }
                },
            });
            return false;
        });
        $(document).on("click", ".ajCopyPriceCruise", function (ev) {
            $("input[name=price_avg]").val();
            return false;
        });
        $(document).on("change", "input[class=ajvClk]", function (ev) {
            var $_this = $(this);
            var adata = {
                tp: $_this.attr("tp"),
                tp_order: $_this.attr("tp_order"),
                table_id: $_this.attr("data"),
                val: $_this.is(":checked") ? 1 : 0,
            };
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajUpdateCruiseVr3",
                data: adata,
                dataType: "html",
                success: function (html) {},
            });
        });
        $(document).on("click", "#clickToAddCruisePriceRow", function (ev) {
            var $_this = $(this);
            if ($("#titleRow").val() == "") {
                $("#titleRow").focus().addClass("error");
                alertify.error(title_required);
                return false;
            }
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajAddCruisePriceRow",
                data: {
                    table_id: $_this.attr("table_id"),
                    title: $("#titleRow").val(),
                },
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    if (html.indexOf("_EXIST") >= 0) {
                        alertify.error(insert_error);
                    }
                    if (html.indexOf("_ERROR") >= 0) {
                        alertify.error(insert_error_exist);
                    }
                    if (html.indexOf("_SUCCESS") >= 0) {
                        loadCruisePrice();
                        loadCruiseRoom();
                        alertify.success(insert_success);
                        $_this
                            .closest(".frmPop")
                            .find(".close_pop")
                            .trigger("click");
                    }
                },
            });
            return false;
        });
        $(document).on("click", "#clickToAddCruisePriceCol", function (ev) {
            var $_this = $(this);
            if ($("#titleCol").val() == "") {
                $("#titleCol").focus().addClass("error");
                alertify.error(field_required);
                return false;
            }
            var adata = {
                table_id: $_this.attr("table_id"),
                title: $("#titleCol").val(),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajAddCruisePriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    if (html.indexOf("_IN_SUCCESS") >= 0) {
                        vietiso_loading(0);
                        loadCruisePrice();
                        alertify.success(insert_success);
                        $_this
                            .closest(".frmPop")
                            .find(".close_pop")
                            .trigger("click");
                    }
                },
            });
            return false;
        });
        $(document).on("click", "#clickToEditCruisePriceRow", function (ev) {
            var $_this = $(this);
            var adata = {
                id: $_this.attr("data"),
                title: $("#titleRow").val(),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajUpdateCruisePriceRow",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadCruisePrice();
                    loadCruiseRoom();
                    $_this
                        .closest(".frmPop")
                        .find(".close_pop")
                        .trigger("click");
                },
            });
            return false;
        });
        $(document).on("click", "#clickToEditCruisePriceCol", function (ev) {
            var $_this = $(this);
            if ($("#titleCol").val() == "") {
                $("#titleCol").focus().addClass("error");
                alertify.error(title_required);
                return false;
            }
            var adata = {
                id: $_this.attr("data"),
                title: $("#titleCol").val(),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajUpdateCruisePriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadCruisePrice();
                    $_this
                        .closest(".frmPop")
                        .find(".close_pop")
                        .trigger("click");
                },
            });
            return false;
        });
        $(document).on("click", ".deleteCruisePriceRoom", function (ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=cruise&act=ajDeleteCruisePriceRoom",
                    data: { id: $_this.attr("data") },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadCruisePrice();
                        loadCruiseRoom();
                    },
                });
            }
            return false;
        });
        $(document).on("click", ".deleteCruisePriceCol", function (ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=cruise&act=ajDeleteCruisePriceCol",
                    data: { id: $_this.attr("data") },
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        loadCruisePrice();
                    },
                });
            }
            return false;
        });
        $(document).on("click", "#clickToEditCruisePriceVal", function (ev) {
            var $_this = $(this);
            var adata = {
                table_id: pvalTable,
                cruise_price_col_id: $_this.attr("cruise_price_col_id"),
                cruise_price_row_id: $_this.attr("cruise_price_row_id"),
                price: $("#titleVal").val(),
            };
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajUpdateCruisePriceVal",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadCruisePrice();
                    $_this
                        .closest(".frmPop")
                        .find(".close_pop")
                        .trigger("click");
                },
            });
            return false;
        });
        $(document).on("click", ".moveCruisePriceRoom", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            var adata = {
                id: $_this.attr("data"),
                direct: $_this.attr("direct"),
            };
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajMoveCruisePriceRow",
                data: adata,
                dataType: "html",
                success: function (html) {
                    loadCruisePrice();
                    vietiso_loading(0);
                },
            });
            return false;
        });
        $(document).on("click", ".moveCruisePriceCol", function (ev) {
            var $_this = $(this);
            vietiso_loading(1);
            var adata = {
                id: $_this.attr("data"),
                direct: $_this.attr("direct"),
            };
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=cruise&act=ajMoveCruisePriceCol",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    loadCruisePrice();
                },
            });
            return false;
        });
        $(document).on("click", ".link_open,.go_overview", function (ev) {
            var step = $(this).data("step");
            var link = $(this).data("route");
            var panel = $(this).data("panel");
            loadMainFormStep(table_id, step);
            if (step == "") {
                $("#step_overview")
                    .closest(".panel-default")
                    .find(".panel-heading a")
                    .click()
                    .addClass("collapsed");
                $("#frmMainStep_" + table_id).show();
                $(".box_add_cruise_new").html("").hide();
            } else {
                $("#step_" + step)
                    .closest(".panel-default")
                    .find(".panel-heading a")
                    .click();
            }

            $(".loadYieldStep").removeClass("active");
            $("#step_" + step).addClass("active");
            window.history.pushState({ href: link }, "", link);

            return false;
        });

        //LOAD SELECT BOX
        $("select[name=iso-city_id]").change(function () {
            var $_this = $(this);
            var country = $("select[name=iso-country_id]")
                .find("option:selected")
                .attr("title");
            var city = $_this.find("option:selected").attr("title");
            var address = city + " ," + country;
        });
    }
});

function loadMainFormStep(table_id, currentstep, step_id = 0) {
    $Core.util.toggleIndicatior(1);
    var $_adata = {
        table_id: table_id,
        currentstep: currentstep,
        step_id: step_id,
    };
    $.post(
        path_ajax_script + "/index.php?mod=" + mod + "&act=getMainFormStep",
        $_adata,
        function (html) {
            $Core.util.toggleIndicatior(0);
            $("#" + "frmMainStep_" + table_id).html(html);
            if (currentstep === "room") {
                loadCruiseRoom();
            } else if (currentstep === "destination") {
                load_list_destinations(table_id);
            } else if (currentstep === "service") {
                load_list_services(table_id);
            } else if (currentstep === "cruise-facibility") {
                loadCruiseFacibility(pvalTable);
            } else if (currentstep == "cruise_price") {
                loadCruisePrice();
            } else if (currentstep == "video") {
                loadListCruiseVideo(table_id);
            } else if (currentstep == "pricechild") {
                loadListPriceChildren(table_id);
            } else if (currentstep == "price-table") {
                load_price_table(table_id, {});
            } else if (currentstep == "itineraryday-" + step_id) {
                loadCabinPriceCruise(step_id, table_id);
            } else if (currentstep == "duration") {
                $('[data-trigger="spinner"]').spinner(
                    "changed",
                    function (e, newVal, oldVal) {
                        var number_day = $("input[name=number_day]").val() || 0,
                            number_night =
                                $("input[name=number_night]").val() || 0;
                        if (number_day > number_night) {
                            if (number_day - number_night > 1) {
                                $("input[name=number_night]").val(
                                    number_day - 1
                                );
                            }
                        } else if (number_day < number_night) {
                            if (number_night - number_day > 1) {
                                $("input[name=number_day]").val(
                                    number_night - 1
                                );
                            }
                        }
                    }
                );
            } else if (currentstep == "lhdl") {
                var $el = $(
                    "[name=departure_point_id][table_id=" + table_id + "]"
                );
                $el.select2({
                    allowClear: true,
                    //minimumInputLength: 2,
                    minimumResultsForSearch: 10,
                    ajax: {
                        delay: 250,
                        type: "POST",
                        url:
                            path_ajax_script +
                            "/index.php?mod=" +
                            mod +
                            "&act=ajLoadListDeparturePoint",
                        dataType: "json",
                        data: function (param) {
                            return { term: param.term };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        id: item.city_id,
                                        text: item.name,
                                    };
                                }),
                            };
                        },
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    /*templateResult: formatCountry,*/
                    templateSelection: function (data, container) {
                        $(data.element).attr({
                            "data-city_id": data.city_id,
                            "data-name": data.name,
                        });
                        return data.text;
                    },
                })
                    .on("select2:select", function (e) {
                        /* var city_id = $(this).val(),
						city_code = $(this).find(':selected').data('city_code');
					$('.InputPotentialField_phone_' + p_id).val(city_code).focus();
					var InputPotentialField_phone = $('.InputPotentialField_phone_' + p_id),
						strLength = InputPotentialField_phone.val().length;
					InputPotentialField_phone[0].setSelectionRange(strLength, strLength);*/
                    })
                    .on("select2:unselect", function (e) {
                        /* $(this).closest('.inline-editor-container').find('.flag-icon').hide();*/
                    });
            }
        }
    );
}
function parentDropdownToggle(e) {
    $(e).parent().toggleClass("open");
}
function checkAll(e) {
    var chkitem = $(e).closest(".fill_data_box").find(".chkitem");
    if ($(e).is(":checked")) {
        chkitem.attr("checked", true);
        chkitem.closest("tr").addClass("hightlight");
        setList();
    } else {
        chkitem.removeAttr("checked");
        chkitem.closest("tr").removeClass("hightlight");
        setList();
    }
}

function loadListPriceChildren($cruise_id) {
    vietiso_loading(1);
    var adata = {
        cruise_id: $cruise_id,
        tp: "L",
    };
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajSiteFrmPriceChildren",
        data: adata,
        dataType: "json",
        success: function (res) {
            if (res.result) {
                $("#ListCruisePriceChildren").html(res.html);
            }
            vietiso_loading(0);
        },
    });
}

function loadListCruiseVideo($cruise_id) {
    vietiso_loading(1);
    var adata = {
        cruise_id: $cruise_id,
        tp: "L",
    };
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/index.php?mod=" + mod + "&act=ajSiteFrmCruiseVideo",
        data: adata,
        dataType: "json",
        success: function (res) {
            if (res.result) {
                $("#ListCruiseVideo").html(res.html);
            }
            vietiso_loading(0);
        },
    });
}
