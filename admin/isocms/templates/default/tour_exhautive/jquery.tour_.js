var aj_search = '';
$().ready(function() {
    checkNumberDaysNights();
    $('#itinerary_tour').on('click',function () {
        checkNumberDaysNights();
    });
    $('#select_number_days').on('change',function () {
        checkNumberDaysNights();
    });
	$("#clienttabs .maps").live('click',function(){
			loadMaps(tour_id);
	});
    if($('#tabsk a.current').length==0){
		$('#tabsk a:first').addClass('current');
	}
	$('#tabsk a').each(function(index){
		$(this).attr('data',index);});
		$('#lstTabs .contentTab').each(function(index){
			$(this).attr('id','tab-'+index);}
		);
		$('#lstTabs .contentTab:not(:first)').hide();
		$('#tabsk a').click(function(){
			var _this=$(this);
			$('#tabsk a.current').removeClass('current');
			_this.addClass('current');
			var cu_id=_this.attr('data');
			$('#lstTabs .contentTab:visible').hide();
			$('#tab-'+cu_id).show();
			return false;
	});
    $('.tour_available').live('change', function() {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajAddStartDate",
            data: {
                "tour_id": $_this.attr("tour_id"),
				"tour_start_date_id": $_this.attr("tour_start_date_id"),
                "allotment": $_this.val(),
				"is_agent": $_this.attr("is_agent"),
                "departure": $_this.attr("departure"),
                "tp": 'SaveAvailable'
            },
            dataType: "html",
            success: function(html) {
                loadTourPriceNewVersion($tour_id);
            }
        });
    });
    $('.tour_season_price_newversion').live('change', function() {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadTourPriceNewVersion",
            data: {
                "tour_id": $_this.attr("tour_id"),
                "tour_price_col_id": $_this.attr("tour_property_idc"),
                "tour_price_row_id": $_this.attr("tour_property_idr"),
				"is_agent": $_this.attr("is_agent"),
                "departure": $_this.attr("departure"),
                "price": $_this.val(),
                "tp": 'S'
            },
            dataType: "html",
            success: function(html) {
                loadTourPriceNewVersion($tour_id);
            }
        });
    });
	
    $(document).on('click', '.clkDeleteTourStore', function(ev) {
        if (confirm(confirm_delete)) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajDeleteTourStore',
                data: {
                    'tour_store_id': $_this.attr('tour_store_id')
                },
                dataType: "html",
                success: function(html) {
                    window.location.reload(true);
                }
            });
        }
    });
    $(document).on('click', '.ajMoveTourStore', function(ev) {
        var $_this = $(this);
        var adata = {
            'tour_store_id': $_this.attr('tour_store_id'),
            'tour_id': $_this.attr('tour_id'),
            'profile_id': $_this.attr('profile_id'),
            'direct': $_this.attr('direct')
        };
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajMoveTourStore",
            data: adata,
            dataType: "html",
            success: function(html) {
                window.location.reload(true);
            }
        });
        return false;
    });
    $(document).on('click', '.addAgencyTour', function(event) {
        event.preventDefault();
        var $_this = $(this);
        var url = $_this.attr('href');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'profile_id': $_this.attr('profile_id'),
                'tour_id': $_this.attr('tour_id'),
                'promo_value_id': $_this.closest('tr').find('.PromoValue').val()
            },
            dataType: "html",
            success: function(data) {
                data = $.parseJSON(data);
                if (data.ok) {
                    alertify.success(data.message);
                    window.location.reload(true);
                }
                if (data.ok == false) {
                    if (data.waning != '') {
                        alertify.error(data.waning);
                    }
                }

            }
        });
    });
    $(document).on('click', '.clickToSaveTourStore', function(event) {
        event.preventDefault();
        var $_this = $(this);
        $_this.closest('form').ajaxSubmit({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=tour&act=addAgencyTourInList',
            data: $_this.closest('form').serialize(),
            success: function(data) {
                data = $.parseJSON(data);
                if (data.ok) {
                    alertify.success(data.message);
                    window.location.reload(true);
                }
                if (data.ok == false) {
                    if (data.waning != '') {
                        alertify.error(data.waning);
                    }
                }
            }
        });
    });
    $(document).on('change', '#slb_TourGroup', function(ev) {
        var $_this = $(this);
        var $tp = $_this.attr('tp').toLowerCase();
        if ($tp == 'ajax' && $SiteHasCategoryGroup_Tours == 1) {
            loadTourCategory($_this.val(), 0, 0);
        } else if ($tp == 'multiple' && $SiteHasCategoryGroup_Tours == 1) {
            loadTourCategory($_this.val(), $listcatID, 1, 'slb_ContainerTourCategory');
        }
    });
    /* POPUP */
    $(document).on('change', '#slb_TourGroupID', function(ev) {
        var $_this = $(this);
        var $tp = $_this.attr('tp').toLowerCase();
        if ($tp == 'ajax' && $SiteHasCategoryGroup_Tours == 1) {
            loadTourCategory($_this.val(), 0, 0, 'slb_CategoryID');
        }
    });
    /* TOUR_PROPERTY_MOD*/
    $(document).on('change', '#slb_TourProperty', function(ev) {
        var $_this = $(this);
        window.location.href = '/admin/?mod=' + mod + '&act=' + act + '&type=' + $_this.val();
    });
    $(document).on('click', '.btnCreateTourProperty,.btnedit_tourProperty,.btndelete_tourProperty', function(ev) {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/?mod=' + mod + '&act=SiteTourProperty&lang='+LANG_ID,
            data: {
                'type': $_this.attr('type'),
                "tour_property_id": $_this.attr('data'),
                'tp': $_this.attr('tp')
            },
            dataType: "html",
            success: function(html) {
                vietiso_loading(0);
                if ($_this.attr('tp') == 'D') {
                    window.location.reload();
                } else {
                    makepopup(320, 'auto', html, 'pop_TourProperty');
                }
            }
        });
        return false;
    });
    $(document).on('click', '.SiteClickSaveTourProperty', function(ev) {
        var $_this = $(this);
        var $_form = $_this.closest('.frmPop');
        var $title = $_form.find('input[name=title]');

        if ($.trim($title.val()) == '') {
            $title.focus();
            alertify.error(field_is_required);
            return false;
        }
        var adata = {};
        adata['title'] = $title.val();
        adata['tour_property_id'] = $_this.attr('tour_property_id');
        adata['type'] = $_this.attr('type');
        adata['tp'] = 'S';

        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/?mod=' + mod + '&act=SiteTourProperty&lang='+LANG_ID,
            data: adata,
            dataType: "html",
            success: function(html) {
                vietiso_loading(0);
                window.location.reload();
            }
        });
        return false;
    });
    // Page Tour - Mod: Default - Act: Default
    if ((mod == 'tour_exhautive' && act == 'default') || (mod == 'tour_exhautive' && act == 'liststore') || (mod == 'tour_exhautive' && act == 'listtour')) {
        if ($SiteHasDeparturePoint_Tours == 1) {
            var $country_id = $('#slb_Country').val();
            var $catID = $('#slb_Category').val();
            if ($catID == undefined) {
                $catID = 0;
            }
            loadDepartPoint($country_id, $catID, $tour_type_id, $departure_point_id);
        }
        if ($SiteHasCat_Tours == 1) {
            $(document).on('change', '#slb_Category', function(ev) {
                var $_this = $(this);
                loadDepartPoint($('#slb_Country').val(), $_this.val(), $tour_type_id);
            });
        }

        if (mod == 'tour_exhautive' && act == 'default') {
            // Add New Tours
            $(document).on('click', '.createNewTour', function(ev) {
                var $_this = $(this);
                var adata = {};
                adata['tour_group_id'] = $tour_group_id;
                adata['tour_type_id'] = $tour_type_id;
                /*				adata['is_set'] = $is_set;*/
                if ($SiteHasCat_Tours == 1) {
                    adata['cat_id'] = $cat_id;
                }
                adata['tp'] = 'F';
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/?mod=' + mod + '&act=ajaxCreateQuickTour',
                    data: adata,
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        makepopupnotresize('560px', 'auto', html, 'CreateTour');
                    }
                });
                return false;
            });

            $(document).on('click', '.clickToSubmitNewTour', function(ev) {
                var $_this = $(this);
                var $_form = $_this.closest('.frmPop');

                if ($SiteHasGroup_Tours) {
                    var $groupID = $_form.find('#slb_TourGroupID');
                    if (parseInt($groupID.val()) == 0) {
                        $groupID.focus();
                        setSelectOpen($groupID);
                        alertify.error(field_required);
                        return false;
                    }
                }
                if ($SiteHasCat_Tours == 1) {
                    var $catID = $_form.find('#slb_CategoryID');
                    if (parseInt($catID.val()) == 0) {
                        $catID.focus();
                        setSelectOpen($catID);
                        alertify.error(field_required);
                        return false;
                    }
                }

                var $title = $_form.find('#NewTourTitle');
                if ($.trim($title.val()) == '') {
                    $title.focus();
                    alertify.error(field_required);
                    return false;
                }
                vietiso_loading(1);
                $('#frmCrxTour').ajaxSubmit({
                    type: "POST",
                    url: path_ajax_script + '/?mod=' + mod + '&act=ajaxCreateQuickTour',
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        if (html.indexOf('_ERROR') >= 0) {
                            alertify.error(insert_error);
                        } else if (html.indexOf('_EXIST') >= 0) {
                            alertify.error(exist_error);
                        } else {
                            location.href = html;
                        }
                    }
                });
                return false;
            });
            // Duplicate Module TOur
            $(document).on('click', '.ajDuplicateTour', function(ev) {
                var $_this = $(this);
                if (confirm(confirm_cloning)) {
                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + '/?mod=' + mod + '&act=ajDuplicateTour',
                        data: {
                            "tour_id": $_this.attr('tour_id')
                        },
                        dataType: "html",
                        success: function(html) {
                            vietiso_loading(0);
                            location.href = html;
                        }
                    });
                }
                return false;
            });
        }
    }
    // Page Tour - Mod: Default - Act: Edit
    if (mod == 'tour_exhautive' && act == 'edit') {
        if ($SiteHasItineraryTours == 1) {
            loadTourItinerary(tour_id);
            loadTourItineraryContingency(tour_id);
        }
        if ($SiteHasStartDate_Tours == 1) {
            initDateInOut();
            /*loadPriceTableCustomerAge();*/
        }
        if ($SiteHasPriceTableTours == 1) {
            /*loadTourPrice($tour_id);*/
        }

        $(".checkall_checkbox").live("click", function() {
            var $_this = $(this);
            var group = $_this.attr("group");
            if ($_this.is(":checked")) {
                $(".checkitem_checkbox[group='" + group + "']").attr("checked", "checked");
            } else {
                $(".checkitem_checkbox[group='" + group + "']").removeAttr("checked");
            }
        });
        $('.changeToStore').live('change', function() {
            var $_this = $(this);
            var type = $_this.attr('_type');
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajUpdateTourStore',
                data: {
                    '_type': $_this.attr('_type'),
                    'tour_id': $_this.attr('data'),
                    'val': $_this.is(':checked') ? 1 : 0
                },
                dataType: 'html',
                success: function(html) {
                    if (type == "PROMOTION") {
                        if ($_this.is(':checked') == 1) {
                            $('#hot_deals').show();
                        } else {
                            $('#hot_deals').hide();
                            $('input[name=price_old]').val() == 0;
                        }
                    }
					vietiso_loading(2);
					location.href = REQUEST_URI;
                }
            });
        });
        /* TOUR_CUSTOm_FIELD */
        if ($SiteHasCustomContentField_Tours == 1) {
            $(document).on('click', '.ClickCustomField', function(ev) {
                var $_this = $(this);
                var $tour_id = $_this.data('tour_id');
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/?mod=' + mod + '&act=SiteTourCustomField',
                    data: {
                        "tour_id": $tour_id,
                        'tp': 'C'
                    },
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        location.href = REQUEST_URI;
                    }
                });
                return false;
            });
            $(document).on('click', '.btndelete_customfield', function(ev) {
                if (confirm(confirm_delete)) {
                    var $_this = $(this);
                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + "/index.php?mod=" + mod + "&act=SiteTourCustomField",
                        data: {
                            'tour_customfield_id': $_this.attr('data'),
                            'tp': 'D'
                        },
                        dataType: "html",
                        success: function(html) {
                            vietiso_loading(0);
                            location.href = REQUEST_URI;
                        }
                    });
                }
                return false;
            });
            $(document).on('click', '.btnedit_customfield', function(ev) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/index.php?mod=" + mod + "&act=SiteTourCustomField",
                    data: {
                        'tp': 'F',
                        'tour_customfield_id': $_this.attr('data'),
                        'tour_id': $_this.attr('tour_id')
                    },
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        makepopup(300, 'auto', html, 'pop_UpdateFieldName');
                    }
                });
                return false;
            });
            $(document).on('click', '.SiteClickUpdateFieldName', function(ev) {
                var $_this = $(this);
                var $_form = $_this.closest('.frmPop');
                var $fieldname = $_form.find('input[name=fieldname]');

                if ($fieldname.val() == '') {
                    $fieldname.focus();
                    alertiy.error(field_is_required);
                    return false;
                }
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/index.php?mod=" + mod + "&act=SiteTourCustomField",
                    data: {
                        'tp': 'S',
                        'tour_customfield_id': $_this.attr('tour_customfield_id'),
                        'tour_id': $_this.attr('tour_id'),
                        'fieldname': $fieldname.val()
                    },
                    dataType: "html",
                    success: function(html) {
                        if (html.indexOf('_EXIST') >= 0) {
                            alertify.error('Error !');
                        } else {
                            location.href = REQUEST_URI;
                            $_form.find('.close_pop').trigger('click');
                        }
                        vietiso_loading(0);
                    }
                });
                return false;
            });
            $(document).on('click', '.btnmove_customfield', function(ev) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/index.php?mod=tour&act=SiteTourCustomField",
                    data: {
                        'tp': 'M',
                        'tour_id': $_this.attr('tour_id'),
                        'direct': $_this.attr('direct'),
                        'tour_customfield_id': $_this.attr('data')
                    },
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        location.href = REQUEST_URI;
                    }
                });
                return false;
            });
        }
        /* END_TOUR_CUSTOM_FIELD */

        /* START TOUR_ITINERARY */
        if ($SiteHasItineraryTours == 1) {
            $(document).on('click', '#clickToAddItinerary', function(ev) {
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmTourItinerary',
                    data: {
                        'tour_id': tour_id,
                        'tp': 'F'
                    },
                    dataType: "html",
                    success: function(html) {
                        makepopupnotresize('90%', 'auto', html, 'SiteFrmTourItinerary');
                        $('#SiteFrmTourItinerary').css('top', '20px');
                        var $editorID = $('.textarea_itinerary_content_editor').attr('id');
						var $editor_ID = $('.textarea_itinerary_content_editor_1').attr('id');
						$('#' + $editorID).isoTextAreaFull();
                        $('#' + $editor_ID).isoTextAreaFull();
                        vietiso_loading(0);
                    }
                });
                return false;
            });
            $(document).on('click', '#clickToAddItinerary_contingency', function(ev) {
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmTourItineraryContingency',
                    data: {
                        'tour_id': tour_id,
                        'tp': 'F'
                    },
                    dataType: "html",
                    success: function(html) {
                        makepopupnotresize('90%', 'auto', html, 'SiteFrmTourItinerary');
                        $('#SiteFrmTourItinerary').css('top', '20px');
                        var $editorID = $('.textarea_itinerary_content_editor').attr('id');
                        $('#' + $editorID).isoTextAreaFix();
                        vietiso_loading(0);
                    }
                });
                return false;
            });
            $(document).on('click', '.clickEditItinerary', function(ev) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmTourItinerary',
                    data: {
                        'tour_itinerary_id': $_this.attr('data'),
                        'tour_id': tour_id,
                        'tp': 'F'
                    },
                    dataType: "html",
                    success: function(html) {
                        makepopupnotresize('90%', 'auto', html, 'SiteFrmTourItinerary');
                        $('#SiteFrmTourItinerary').css('top', '20px');
                        var $editorID = $('.textarea_itinerary_content_editor').attr('id');
						var $editor_ID = $('.textarea_itinerary_content_editor_1').attr('id');
						$('#' + $editorID).isoTextAreaFull();
                        $('#' + $editor_ID).isoTextAreaFull();
                        if ($SiteHasHotel_Tours == 1) {
                            loadListHotelItinerary(tour_id, $_this.attr('data'), '');
                        }
                        vietiso_loading(0);
                    }
                });
                return false;
            });
            $(document).on('click', '.clickEditItineraryContingency', function(ev) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmTourItineraryContingency',
                    data: {
                        'tour_itinerary_id': $_this.attr('data'),
                        'tour_id': tour_id,
                        'tp': 'F'
                    },
                    dataType: "html",
                    success: function(html) {
                        makepopupnotresize('90%', 'auto', html, 'SiteFrmTourItinerary');
                        $('#SiteFrmTourItinerary').css('top', '20px');
                        var $editorID = $('.textarea_itinerary_content_editor').attr('id');
                        $('#' + $editorID).isoTextAreaFix();
                        if ($SiteHasHotel_Tours == 1) {
                            loadListHotelItinerary(tour_id, $_this.attr('data'), '');
                        }
                        vietiso_loading(0);
                    }
                });
                return false;
            });
            $(document).on('click', '.btnSaveTourItinerary', function(ev) {
                var $_this = $(this);
                var $_form = $_this.closest('.frmPop');
                var $day = $_form.find('input[name=day]');
                var $day2 = $_form.find('input[name=day2]');

                var $meals = getCheckBoxValueByClass('chk_Meal');
                var $transport = getCheckBoxValueByClass('chk_Transport');
                var $editorID = $('.textarea_itinerary_content_editor').attr('id');
                var $content = tinyMCE.get($editorID).getContent();
                var $image = $_form.find('input[name=isoman_url_image]');
                var $tour_itinerary_id = $_this.attr('tour_itinerary_id');
                var $is_show_image = $('input[name=is_show_image]:checked').val();

                if ($day.val() == '') {
                    $day.focus().addClass('error');
                    alertify.error(field_is_required);
                    return false;
                }
                /**/
                var adata = {};
                adata['day'] = $.trim($day.val());
                adata['day2'] = $.trim($day2.val());
                adata['meals'] = $meals;
                adata['transport'] = $transport;
                adata['content'] = $content;
                adata['image'] = $image.val();
                adata['tour_itinerary_id'] = $tour_itinerary_id;
                adata['is_show_image'] = $is_show_image;
                adata['tour_id'] = $tour_id;
                adata['tp'] = 'S';

                vietiso_loading(1);
                $('#frmItinerary').ajaxSubmit({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmTourItinerary',
                    data: adata,
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        if (html.indexOf('_INSERT_SUCCESS') >= 0) {
                            loadTourItinerary($tour_id);
                            loadTourItineraryContingency($tour_id);
                            $_this.closest('.frmPop').find('.close_pop').trigger('click');
                        }
                        if (html.indexOf('_UPDATE_SUCCESS') >= 0) {
                            loadTourItinerary($tour_id);
                            loadTourItineraryContingency($tour_id);
                            $_this.closest('.frmPop').find('.close_pop').trigger('click');
                        }
                        if (html.indexOf('_ERROR') >= 0) {
                            alertify.error(insert_error);
                        }
                        if (html.indexOf('_EXIST') >= 0) {
                            alertify.error(exist_error);
                        }
                        if (html.indexOf('day_invalid') >= 0) {
                            $day.focus();
                            alertify.error('Error !');
                        }
						window.location.reload(true);
                    }
                });
                return false;
            });
            $(document).on('click', '.btnSaveTourItineraryContingency', function(ev) {
                var $_this = $(this);
                var $_form = $_this.closest('.frmPop');
                var $title_contingency = $_form.find('input[name=title_contingency]');

                var $meals = getCheckBoxValueByClass('chk_Meal');
                var $transport = getCheckBoxValueByClass('chk_Transport');
                var $editorID = $('.textarea_itinerary_content_editor').attr('id');
                var $content = tinyMCE.get($editorID).getContent();
                var $image = $_form.find('input[name=isoman_url_image]');
                var $tour_itinerary_id = $_this.attr('tour_itinerary_id');
                var $is_show_image = $('input[name=is_show_image]:checked').val();

                /**/
                var adata = {};

                adata['title_contingency'] = $title_contingency.val();
                adata['meals'] = $meals;
                adata['transport'] = $transport;
                adata['content'] = $content;
                adata['image'] = $image.val();
                adata['tour_itinerary_id'] = $tour_itinerary_id;
                adata['is_show_image'] = $is_show_image;
                adata['tour_id'] = $tour_id;
                adata['tp'] = 'S';

                vietiso_loading(1);
                $('#frmItinerary').ajaxSubmit({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmTourItineraryContingency',
                    data: adata,
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        if (html.indexOf('_INSERT_SUCCESS') >= 0) {
                            loadTourItinerary($tour_id);
                            loadTourItineraryContingency($tour_id);
                            $_this.closest('.frmPop').find('.close_pop').trigger('click');
                        }
                        if (html.indexOf('_UPDATE_SUCCESS') >= 0) {
                            loadTourItinerary($tour_id);
                            loadTourItineraryContingency($tour_id);
                            $_this.closest('.frmPop').find('.close_pop').trigger('click');
                        }
                        if (html.indexOf('_ERROR') >= 0) {
                            alertify.error(insert_error);
                        }
                        if (html.indexOf('_EXIST') >= 0) {
                            alertify.error(exist_error);
                        }
                        if (html.indexOf('day_invalid') >= 0) {
                            $day.focus();
                            alertify.error('Error !');
                        }
                    }
                });
                return false;
            });
            $(document).on('click', '.moveTourItinerary', function(ev) {
                var _this = $(this);
                /**/
                var adata = {};
                adata['tour_itinerary_id'] = _this.attr('data');
                adata['tour_id'] = tour_id;
                adata['direct'] = _this.attr('direct');
                adata['tp'] = 'M';

                vietiso_loading(1);
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmTourItinerary',
                    data: adata,
                    dataType: 'html',
                    success: function(html) {
                        loadTourItinerary(tour_id);
                        loadTourItineraryContingency(tour_id);
                        vietiso_loading(0);
                    }
                });
            });
            $(document).on('click', '.clickDeleteItinerary', function(ev) {
                var _this = $(this);
                if (confirm(confirm_delete)) {
                    vietiso_loading(1);
                    $.ajax({
                        type: 'POST',
                        url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmTourItinerary',
                        data: adata = {
                            'tour_id': tour_id,
                            'tour_itinerary_id': _this.attr('data'),
                            'tp': 'D'
                        },
                        dataType: 'html',
                        success: function(html) {
                            loadTourItinerary(tour_id);
                            loadTourItineraryContingency(tour_id);
                            alertify.success(delete_success);
                            vietiso_loading(0);
							window.location.reload(true);
                        }
                    });
                }
                return false;
            });
            $(document).on('click', '.clickDeleteItineraryContingency', function(ev) {
                var _this = $(this);
                if (confirm(confirm_delete)) {
                    vietiso_loading(1);
                    $.ajax({
                        type: 'POST',
                        url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmTourItineraryContingency',
                        data: adata = {
                            'tour_id': tour_id,
                            'tour_itinerary_id': _this.attr('data'),
                            'tp': 'D'
                        },
                        dataType: 'html',
                        success: function(html) {
                            loadTourItinerary(tour_id);
                            loadTourItineraryContingency(tour_id);
                            alertify.success(delete_success);
                            vietiso_loading(0);
                        }
                    });
                }
                return false;
            });
        }

        if ($SiteHasDestinationTours == 1) {
            setSelectBoxDestination();
            $(document).on('change', '#slb_Chauluc', function(ev) {
                var $_this = $(this);
                if (parseInt($_this.val()) > 0) {
                    loadCountry($_this.val());
                } else {
                    $('select[name=country_id]').html('<option value="0">' + country + '/option>').hide();
                    $('select[name=region_id]').html('<option value="0">' + regions + '</option>').hide();
                    $('select[name=city_id]').html('<option value="0">' + cities + '</option>').hide();
					$('select[name=placetogo_id]').html('<option value="0">' + placetogo + '</option>').hide();
                }
            });
            $(document).on('change', '#slb_Country', function(ev) {
                var $_this = $(this);
                if (parseInt($_this.val()) > 0) {
                    if ($SiteActive_region == '1') {
                        loadRegion($_this.val());
                        $('#slb_CityID').hide();
						$('#slb_placetogoID').hide();
                    } else {
                        loadCity($_this.val());
                    }
                } else {
                    $('#slb_RegionID').hide();
                    $('#slb_CityID').hide();
					$('#slb_placetogoID').hide();
					
                }
            });
            $(document).on('change', '#slb_RegionID', function(ev) {
                var $_this = $(this);
                if ($SiteModActive_country == '1') {
                    var $country_id = $('#slb_Country').val();
                    if ($country_id == undefined) {
                        $country_id = $('#Hid_Country').val();
                    }
                    loadCity($country_id, $_this.val());
                } else {
                    loadCity(0, $_this.val());
                }
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
            });
            // Destination
            $(document).on('click', '.ajQuickAddDestination', function(ev) {
                var $_this = $(this);
                if ($SiteModActive_continent == '1') {
                    var $chauluc_id = $('#slb_Chauluc').val();
                }
                if ($SiteModActive_country == '1') {
                    var $country_id = $('#slb_Country').val();
                    if ($country_id != undefined || $country_id == 0) {
                        var $countryID = $('#slb_Country');
                        setSelectOpen($countryID);
                    } else {
                        $country_id = 1;
                    }
                }
                if ($SiteActive_region == '1') {
                    var $region_id = $('#slb_RegionID').val();
                }
                if ($SiteActive_city == '1') {
                    var $city_id = $('#slb_CityID').val();
                }
				 if ($SiteActive_city == '1') {
                    var $placetogo_id = $('#slb_placetogoID').val();
                }

                /**/
                var adata = {};
                adata['chauluc_id'] = $chauluc_id;
                adata['country_id'] = $country_id;
                adata['region_id'] = $region_id;
                adata['city_id'] = $city_id;
				adata['placetogo_id'] = $placetogo_id;
                adata['tour_id'] = $tour_id;

                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/?mod=' + mod + '&act=ajaxAddMoreTourDestination',
                    data: adata,
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        if (html.indexOf('_SUCCESS') >= 0) {
                            loadListDestination($tour_id);
                        }
                        if (html.indexOf('_EXIST') >= 0) {
                            alertify.error(exist_error);
                        }
                    }
                });
                return 0;
            });
            $(document).on('click', '.removeDestination', function(ev) {
                var $_this = $(this);
                if (confirm(confirm_delete)) {
                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + '/?mod=' + mod + '&act=ajaxDeleteTourDestination',
                        data: {
                            "tour_destination_id": $_this.attr('data')
                        },
                        dataType: "html",
                        success: function(html) {
                            vietiso_loading(0);
                            var $country_id = $('#slb_Country').val();
                            if ($country_id == undefined) {
                                $country_id = $('#Hid_Country').val();
                            }
                            if ($('#slb_CityID').is(':visible')) {
                                loadCity($country_id, $('#slb_RegionID').val());
                            }
                            loadListDestination($tour_id);
                        }
                    });
                    return false;
                }
            });
            $(document).on('click', '.ajRemoveAllDestinationInTour', function(ev) {
                var $_this = $(this);
                if (confirm(confirm_delete)) {
                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + '/?mod=' + mod + '&act=ajaxDeleteAllTourDestination',
                        data: {
                            "tour_id": tour_id
                        },
                        dataType: "html",
                        success: function(html) {
                            vietiso_loading(0);
                            var $country_id = $('#slb_Country').val();
                            if ($country_id == undefined) {
                                $country_id = $('#Hid_Country').val();
                            }
                            if ($('#slb_CityID').is(':visible')) {
                                loadCity($country_id, $('#slb_RegionID').val());
                            }
                            loadListDestination(tour_id);
                        }
                    });
                    return false;
                }
            });
        }
        // Tour Hotels
        if ($SiteHasHotel_Tours == '1') {
            $(document).on('click', '.ajaxOpenChoiceHotel', function(ev) {
                var $_this = $(this);
                var adata = {};
                adata['tour_id'] = $_this.attr('tour_id');
                adata['tour_itinerary_id'] = $_this.attr('tour_itinerary_id');
                adata['tour_hotel_id'] = $_this.attr('tour_hotel_id');
                adata['tour_type_id'] = $tour_type_id;

                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxGetBoxHotelRecommend',
                    dataType: "html",
                    data: adata,
                    success: function(html) {
                        makepopup('80%', 'auto', html, 'pop_HotelRecommend');
                        $('#pop_HotelRecommend').css('top', '30px');
                        if ($tour_type_id == '1') {
                            loadCityHotelList();
                            setInterval(function() {
                                /*	$('select[name=countryhotel_id]').attr('disabled','disabled');*/
                            }, 100);
                        }
                        vietiso_loading(0);
                    }
                });
                return false;
            });
            $(document).on('change', '#pop_HotelRecommend select[name=continenthotel_id]', function(ev) {
                var $_this = $(this);
                var $continent_id = $_this.val();

                vietiso_loading(1);
                $('#pop_HotelRecommend select[name=countryhotel_id]').html('<option>' + loading + '</option>');
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + "/index.php?mod=tour&act=ajaxSelectHotelCountry",
                    data: {
                        'continent_id': $continent_id
                    },
                    dataType: 'html',
                    success: function(html) {
                        $('#pop_HotelRecommend select[name=countryhotel_id]').html(html);
                        vietiso_loading(0);
                    }
                });
                var $keyword = $('#pop_HotelRecommend input[name=keypop]').val();
                var $number_per_page = $('#pop_HotelRecommend .paginate_length').val();
                var $star = $('#pop_HotelRecommend select[name=star]').val();
                var $tour_id = $('#pop_HotelRecommend #hid_tour_id').val();
                var $itinerary_id = $('#pop_HotelRecommend #hid_itinerary_id').val();
                reloadListHotel($continent_id, 0, 0, $star, $keyword, $tour_id, $itinerary_id, 1, $number_per_page);
            });
            $(document).on('change', '#pop_HotelRecommend select[name=countryhotel_id]', function(ev) {
                var $_this = $(this);
                var $country_id = $_this.val();
                var $city_id = 0;
                var $continent_id = $('#pop_HotelRecommend select[name=continent_id]').val();
                var $star = $('#pop_HotelRecommend select[name=star]').val();
                var $keyword = $('#pop_HotelRecommend input[name=keypop]').val();
                var $number_per_page = $('#pop_HotelRecommend .paginate_length').val();
                var $tour_id = $('#pop_HotelRecommend #hid_tour_id').val();
                var $tour_itinerary_id = $('#pop_HotelRecommend #hid_itinerary_id').val();

                if (parseInt($country_id) == 0) {
                    $('#pop_HotelRecommend select[name=cityhotel_id]').html('<option>-- ' + Select + ' --</option>');
                    $('#pop_HotelRecommend select[name=star]').html('<option>-- ' + Select + ' --</option>');
                    return false;
                }
                /* Make combobox city */
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/?mod=' + mod + '&act=ajmakeSelectCityHotelGlobal',
                    data: {
                        "country_id": $country_id
                    },
                    dataType: "html",
                    success: function(html) {
                        $('#pop_HotelRecommend select[name=cityhotel_id]').html(html);
                    }
                });
                reloadListHotel($continent_id, $country_id, $city_id, $star, $keyword, $tour_id, $tour_itinerary_id, 1, $number_per_page);
            });
            $(document).on('change', '#pop_HotelRecommend select[name=cityhotel_id]', function(ev) {
                var $_this = $(this);
                var $continent_id = $('#pop_HotelRecommend select[name=continent_id]').val();
                var $country_id = $('#pop_HotelRecommend select[name=country_id]').val();
                var $keyword = $('#pop_HotelRecommend input[name=keypop]').val();
                var $number_per_page = $('#pop_HotelRecommend .paginate_length').val();
                var $star = $('#pop_HotelRecommend select[name=star]').val();
                var $tour_id = $('#pop_HotelRecommend #hid_tour_id').val();
                var $tour_itinerary_id = $('#pop_HotelRecommend #hid_itinerary_id').val();

                reloadListHotel($continent_id, $country_id, $_this.val(), $star, $keyword, $tour_id, $tour_itinerary_id, 1, $number_per_page);
            });
            $(document).on('click', '#pop_HotelRecommend .searchpop', function(ev) {
                var $continent_id = $('#pop_HotelRecommend select[name=continent_id]').val();
                var $country_id = $('#pop_HotelRecommend select[name=country_id]').val();
                var $city_id = $('#pop_HotelRecommend select[name=city_id]').val();
                var $keyword = $('#pop_HotelRecommend input[name=keypop]').val();
                var $star = $('#pop_HotelRecommend select[name=star]').val();
                var $number_per_page = $('#pop_HotelRecommend .paginate_length').val();
                var $tour_id = $('#pop_HotelRecommend #hid_tour_id').val();
                var $tour_itinerary_id = $('#pop_HotelRecommend #hid_itinerary_id').val();
                reloadListHotel($continent_id, $country_id, $city_id, $star, $keyword, $tour_id, $tour_itinerary_id, 1, $number_per_page);
            });
            $(document).on('click', '#pop_HotelRecommend .paginate_button', function(ev) {
                var $_this = $(this);
                var $continent_id = $('#pop_HotelRecommend select[name=continent_id]').val();
                var $country_id = $('#pop_HotelRecommend select[name=country_id]').val();
                var $city_id = $('#pop_HotelRecommend select[name=city_id]').val();
                var $star = $('#pop_HotelRecommend select[name=star]').val();
                var $keyword = $('#pop_HotelRecommend input[name=keypop]').val();
                var $tour_id = $('#pop_HotelRecommend #hid_tour_id').val();
                var $tour_itinerary_id = $('#pop_HotelRecommend #hid_itinerary_id').val();
                var $number_per_page = $('#pop_HotelRecommend .paginate_length').val();
                reloadListHotel($continent_id, $country_id, $city_id, $star, $keyword, $tour_id, $tour_itinerary_id, $_this.attr('page'), $number_per_page);
                return false;
            });
            $(document).on('click', '.btnChooiseHotel', function(ev) {
                var $_this = $(this);
                var $tour_id = $_this.attr('tour_id');
                var $tour_itinerary_id = $_this.attr('tour_itinerary_id');
                var $list_id = $('#list_selected_chkitem').val();

                var adata = {};
                adata['tour_id'] = $tour_id;
                adata['tour_itinerary_id'] = $tour_itinerary_id;
                adata['list_id'] = $list_id;

                vietiso_loading(1);
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxSaveTourHotel',
                    data: adata,
                    dataType: 'html',
                    success: function(html) {
                        if (html.indexOf('_EMPTY') >= 0) {
                            alertify.error('You must choose hotel !');
                        }
                        if (html.indexOf('_SUCCESS') >= 0) {
                            loadListHotelItinerary(tour_id, $tour_itinerary_id, '');
                            $_this.closest('.frmPop').find('.close_pop').trigger('click');
                        }
                    }
                });
                return false;
            });
            $(document).on('click', '.btn_delete_hotel_itinerary', function(ev) {
                var $_this = $(this);
                if (confirm(confirm_delete)) {
                    var $tour_id = $_this.attr('_tour_id');
                    var $tour_itinerary_id = $_this.attr('_tour_itinerary_id');

                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxDeleteHotelItinerary',
                        data: {
                            'tour_hotel_id': $_this.attr('data')
                        },
                        dataType: "html",
                        success: function(html) {
                            vietiso_loading(0);
                            loadListHotelItinerary(tour_id, $tour_itinerary_id, '');
                        }
                    });
                }
                return false;
            });
			$('#slb_MonthYear').live('change', function() {
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadListPriceTourGroupStartDate",
					data: {
						'tour_id': tour_id,
						"start_date": $_this.attr("start_date"),
						"departure": $_this.val(),
					},
					dataType: "html",
					success: function(html) {
						vietiso_loading(0);
						$("#GroupStartDateHolder").html(html);
					}
				});
			});
			$(document).on('change', '.h_tour_price_group', function(ev){
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/?mod="+mod+"&act=ajLoadTourPriceGroup",
					data:{
						'tour_id':$_this.attr("tour_id"),
						'tour_class_id':$_this.attr("tour_class_id"),
						'tour_start_date_id':$_this.attr("tour_start_date_id"),
						'departure':$_this.attr("departure"),
						'tour_number_group_id':$_this.attr("tour_number_group_id"),
						'tour_visitor_type_id':$_this.attr("tour_visitor_type_id"),
						"price":$_this.val(),
						'tp' : 'S'
					},
					dataType: "html",
					success: function(html){
						var htm = html.split('|||');
						$_this.val(htm[1]);
						if($_this.attr("departure")==''){
							loadTourPriceGroupNoDeparture();
						}
						loadTourPriceGroup($tour_id,$_this.attr("departure"),$_this.attr("tour_start_date_id"));
					}
				}); 
			});
			$(document).on('change', '.h_price_single_supply', function(ev){
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/?mod="+mod+"&act=ajLoadTourPriceGroup",
					data:{
						'tour_id':$_this.attr("tour_id"),
						'departure_date':$_this.attr("departure"),
						'tour_class_id':$_this.attr("tour_class_id"),
						'tour_start_date_id':$_this.attr("tour_start_date_id"),
						"price_single":$_this.val(),
						'tp' : 'SINGLE'
					},
					dataType: "html",
					success: function(html){
						var htm = html.split('|||');
						$_this.val(htm[1]);
						loadTourPriceGroup($tour_id,$_this.attr("departure"),$_this.attr("tour_start_date_id"));
					}
				}); 
			});
			$(document).on('change', '#available', function(ev){
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/?mod="+mod+"&act=ajAddGroupStartDate",
					data:{
						'tour_id':$_this.attr("tour_id"),
						'start_date':$_this.attr("start_date"),
						"available":$_this.val(),
						"type":'GROUP',
						'tp' : 'SaveAvailable'
					},
					dataType: "html",
					success: function(html){
						var htm = html.split('|||');
						$_this.val(htm[1]);
						loadTourPriceGroup($tour_id,$_this.attr("start_date"));
					}
				}); 
			});
			$(document).on('change', '#deposit_departure', function(ev){
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/?mod="+mod+"&act=ajAddGroupStartDate",
					data:{
						'tour_id':$_this.attr("tour_id"),
						'start_date':$_this.attr("start_date"),
						"deposit_departure":$_this.val(),
						"type":'GROUP',
						'tp' : 'SaveDeposit'
					},
					dataType: "html",
					success: function(html){
						var htm = html.split('|||');
						$_this.val(htm[1]);
						loadTourPriceGroup($tour_id,$_this.attr("start_date"));
					}
				}); 
			});
			$(document).on('click', '.SiteClickNoPublic', function(ev){
				alert('Please enter a price in the price table');
			});
			$(document).on('click', '.clickEditTourGroupStartDate', function(ev) {
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajLoadTourPriceGroup',
					data: {
						'tour_start_date_id': $_this.attr('tour_start_date_id'),
						'tour_id': $_this.attr('tour_id'),
						'departure': $_this.attr('departure'),
						'tp': 'F'
					},
					dataType: "html",
					success: function(html) {
						makepopupnotresize('90%', 'auto', html, 'SiteFrmTourPriceGroup');
						$('#SiteFrmTourPriceGroup').css('top', '20px');
						var $editorID = $('.textarea_itinerary_content_editor').attr('id');
						$('#' + $editorID).isoTextAreaFull();
						vietiso_loading(0);
					}
				});
				return false;
			});
        }
        /* START TOUR_PRICE_SYSTEM */
        if ($SiteHasPriceTableTours == 1) {
            if ($SitePriceTableType_Tours == 1) {
                /*load_season_price('low');
                load_season_price('high');*/
                $(".tour_season_price_check").live("change", function() {
                    vietiso_loading(1);
                    var $_this = $(this);
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + "/?mod=tour&act=aj_save_tour_season_price",
                        data: {
                            'tour_id': $_this.attr("tour_id"),
                            "season": $_this.attr("season"),
                            "tour_class_id": $_this.attr("tour_class_id"),
                            "price": 0,
                            "_type": $_this.attr("_type"),
                            "is_hide": $_this.is(":checked") ? 0 : 1,
                            "action": 'check'
                        },
                        dataType: "html",
                        success: function(html) {
                            vietiso_loading(0);
                            if ($_this.is(":checked")) {
                                $_this.closest('td').find('.tour_season_price').removeAttr("disabled").focus().select();
                            } else {
                                $_this.closest('td').find('.tour_season_price').attr("disabled", "disabled");
                            }
                        }
                    });
                });

                $(".tour_price_in_date").live("change", function() {
                    vietiso_loading(1);
                    var $_this = $(this);
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + "/?mod=tour&act=aj_save_tour_price_in_date",
                        data: {
                            'tour_id': $_this.attr("tour_id"),
                            "tour_start_date_id": $_this.attr("tour_start_date_id"),
                            "tour_class_id": $_this.attr("tour_class_id"),
                            "price": $_this.val(),
                            "_type": $_this.attr("_type")
                        },
                        dataType: "html",
                        success: function(html) {
                            vietiso_loading(0);
                            var htm = html.split('|||');
                            $_this.val(htm[1]);
                        }
                    });
                });
                $(".change_is_hide").live("change", function() {
                    vietiso_loading(1);
                    var $_this = $(this);
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + "/?mod=tour&act=aj_save_change_is_hide",
                        data: {
                            'tour_id': $_this.attr("tour_id"),
                            "tour_start_date_id": $_this.attr("tour_start_date_id"),
                            "tour_class_id": $_this.attr("tour_class_id"),
                            "val": $_this.is(":checked") ? 0 : 1,
                            "_type": $_this.attr("_type")
                        },
                        dataType: "html",
                        success: function(html) {
                            vietiso_loading(0);
                            if ($_this.is(":checked")) {
                                $_this.closest("td").find("input[type=text]").removeAttr("disabled").focus();
                            } else {
                                $_this.closest("td").find("input[type=text]").attr("disabled", "disabled");
                            }
                        }
                    });
                });
                $(document).on('click', '.resetTourProperty', function() {
                    vietiso_loading(1);
                    var $_this = $(this);
                    var $_tp = $_this.attr("tp");
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + "/?mod=tour&act=ajResetTourProperty",
                        data: {
                            'tour_id': $_this.attr("tour_id"),
                            "tp": $_tp
                        },
                        dataType: "html",
                        success: function(html) {
                            vietiso_loading(0);
                            var htm = html.split('|||');
                            if ($_tp == 'tour_low' || $_tp == 'tour_high') {
                                $("input[name=date-" + $_tp + "_from]").val(htm[1]);
                                $("input[name=date-" + $_tp + "_to]").val(htm[2]);
                            }
                            if ($_tp == 'config_markup_tour') {
                                $("input[name=iso-" + $_tp + "").val(htm[1]);
                                $("input[name=iso-" + $_tp + "_agent]").val(htm[2]);
                            }
                        }
                    });
                    return false
                });
            } else {
                $(document).on('click', '.btnCreatePriceRow,.editTourPriceRow,.btnSavePriceRow,.deleteTourPriceRow', function(ev) {
                    var $_this = $(this);
                    $tp = $_this.attr('tp');
                    var adata = {};
                    adata['tour_id'] = $tour_id;
                    adata['tour_price_row_id'] = $_this.attr('data');
                    adata['tp'] = $_this.attr('tp');

                    if ($tp == 'S') {
                        var $_form = $(this).closest('.frmPop');
                        var $titleRow = $('#titleRow').val();
                        if ($titleRow == '') {
                            $('#titleRow').focus();
                            alertify.error(field_is_required);
                            return false;
                        }
                        adata['title'] = $titleRow;
                    } else if ($tp == 'D') {
                        if (!confirm(confirm_delete)) {
                            return false;
                        }
                    }
                    vietiso_loading(1);
                    $.ajax({
                        type: 'POST',
                        url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteTourPriceRow',
                        data: adata,
                        dataType: 'html',
                        success: function(html) {
                            vietiso_loading(0);
                            if ($tp == 'D') {
                                loadTourPrice($tour_id);
                            } else if ($tp == 'S') {
                                loadTourPrice($tour_id);
                                $_form.find('.close_pop').trigger('click');
                            } else {
                                makepopup(300, '', html, 'pop_SiteTourPriceRow');
                            }
                        }
                    });
                    return false;
                });
                $(document).on('click', '.moveTourPriceRow', function(ev) {
                    var $_this = $(this);
                    var adata = {
                        'tp': 'M',
                        'tour_id': $tour_id,
                        'tour_price_row_id': $_this.attr('data'),
                        'direct': $_this.attr('direct')
                    };
                    vietiso_loading(1);
                    $.ajax({
                        type: 'POST',
                        url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteTourPriceRow',
                        data: adata,
                        dataType: 'html',
                        success: function(html) {
                            vietiso_loading(0);
                            loadTourPrice($tour_id);
                        }
                    });
                    return false;
                });
                $(document).on('click', '.btnCreatePriceCol,.editTourPriceCol,.btnSavePriceCol,.deleteTourPriceCol', function(ev) {
                    var $_this = $(this);
                    $tp = $_this.attr('tp');
                    var adata = {};
                    adata['tour_id'] = $tour_id;
                    adata['tour_price_col_id'] = $_this.attr('data');
                    adata['tp'] = $_this.attr('tp');

                    if ($tp == 'S') {
                        var $_form = $(this).closest('.frmPop');
                        var $titleCol = $('#titleCol').val();
                        if ($titleCol == '') {
                            $('#titleCol').focus();
                            alertify.error(field_is_required);
                            return false;
                        }
                        adata['title'] = $titleCol;
                    } else if ($tp == 'D') {
                        if (!confirm(confirm_delete)) {
                            return false;
                        }
                    }
                    vietiso_loading(1);
                    $.ajax({
                        type: 'POST',
                        url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteTourPriceCol',
                        data: adata,
                        dataType: 'html',
                        success: function(html) {
                            vietiso_loading(0);
                            if ($tp == 'D') {
                                loadTourPrice($tour_id);
                            } else if ($tp == 'S') {
                                loadTourPrice($tour_id);
                                $_form.find('.close_pop').trigger('click');
                            } else {
                                makepopup(300, '', html, 'pop_SiteTourPriceRow');
                            }
                        }
                    });
                    return false;
                });
                $(document).on('click', '.moveTourPriceCol', function(ev) {
                    var $_this = $(this);
                    var adata = {
                        'tp': 'M',
                        'tour_id': $tour_id,
                        'tour_price_col_id': $_this.attr('data'),
                        'direct': $_this.attr('direct')
                    };
                    vietiso_loading(1);
                    $.ajax({
                        type: 'POST',
                        url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteTourPriceCol',
                        data: adata,
                        dataType: 'html',
                        success: function(html) {
                            loadTourPrice(tour_id);
                            vietiso_loading(0);
                        }
                    });
                    return false;
                });
                $(document).on('click', '.ajCopyPriceCustomer', function(ev) {
                    var $_this = $(this);
                    $("#titleVal").val($("#trip_price").val());
                    return false;
                });
                $(document).on('click', '.editTourPriceVal', function(ev) {
                    var $_this = $(this);
                    $.ajax({
                        type: 'POST',
                        url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteTourPriceVal',
                        dataType: 'html',
                        data: {
                            'tp': 'F',
                            'tour_price_col_id': $_this.attr('tour_property_idc'),
                            'tour_price_row_id': $_this.attr('tour_property_idr'),
                            'tour_id': tour_id
                        },
                        success: function(html) {
                            vietiso_loading(0);
                            makepopup('200', '', html, 'EditTourPriceVal');
                            $("#titleVal").priceFormat({
                                thousandsSeparator: '.',
                                centsLimit: 0
                            });
                        }
                    });
                    return false;
                });
                $(document).on('click', '.clickToEditTourPriceVal', function(ev) {
                    var $_this = $(this);
                    var adata = {
                        'tp': 'S',
                        'tour_id': tour_id,
                        'tour_price_col_id': $_this.attr('tour_price_col_id'),
                        'tour_price_row_id': $_this.attr('tour_price_row_id'),
                        'price': $('#titleVal').val()
                    };
                    vietiso_loading(1);
                    $.ajax({
                        type: 'POST',
                        url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteTourPriceVal',
                        data: adata,
                        dataType: 'html',
                        success: function(html) {
                            vietiso_loading(0);
                            loadTourPrice(tour_id);
                            $_this.closest('.frmPop').find('.close_pop').trigger('click');
                        }
                    });
                    return false;
                });
            }
            /* END PRICCE */

        }

        if ($SiteHasStartDate_Tours == '1') {
            // Tour Start Date
            $(document).on('click', '.ajAddStartDate', function(ev) {
                vietiso_loading(1);
                var $_this = $(this);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/?mod=' + mod + '&act=ajLoadAddStartDate',
                    data: {
                        'tour_id': tour_id
                    },
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        makepopupnotresize('450px', 'auto', html, 'AddStartDate');
                        $("#multiDate").multiDatesPicker();
                    }
                });
                return false;
            });
            $(document).on('click', '.clickToAddNewTourStartDate', function(ev) {
                var $_this = $(this);
                if ($("#multiDate").val() == '') {
                    $("#multiDate").focus();
                    return false;
                }
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/?mod=' + mod + '&act=ajAddStartDate',
                    data: {
                        'tour_id': tour_id,
                        'start_date': $("#multiDate").val()
                    },
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        loadTourPriceUnitStartDate();
                        $_this.closest(".frmPop").find(".close_pop").click();
                    }
                });
                return false;
            });
			$(document).on('click', '.clickToAddNewTourStartDateAgent', function(ev) {
                var $_this = $(this);
                if ($("#multiDateAgent").val() == '') {
                    $("#multiDateAgent").focus();
                    return false;
                }
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/?mod=' + mod + '&act=ajAddStartDate',
                    data: {
                        'tour_id': tour_id,
						'is_agent': 1,
                        'start_date': $("#multiDateAgent").val()
                    },
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        loadTourPriceUnitStartDateAgent();
                        $_this.closest(".frmPop").find(".close_pop").click();
                    }
                });
                return false;
            });
            $(document).on('click', '.clickDeleteTourStartDate', function(ev) {
                if (confirm(confirm_delete)) {
                    vietiso_loading(1);
                    var $_this = $(this);
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + '/?mod=' + mod + '&act=ajDeleteTourStartDate',
                        data: {
                            'tour_start_date_id': $_this.attr("tour_start_date_id"),
                            'tour_id': tour_id,
                            'departure': $_this.attr("departure")
                        },
                        dataType: "html",
                        success: function(html) {
                            vietiso_loading(0);
                            loadTourPriceUnitStartDate();
                        }
                    });
                }
                return false;
            });
            $(document).on('click', '.ajEditTourStartDateElement', function(ev) {
                vietiso_loading(1);
                var $_this = $(this);
                var $_tp = $_this.attr("tp");
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/?mod=' + mod + '&act=ajLoadEditTourStartDateElement',
                    data: {
                        'tour_start_date_id': $_this.attr("tour_start_date_id"),
                        "tp": $_tp
                    },
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        makepopupnotresize('220px', 'auto', html, 'EditTourStartDateAllotment');
                    }
                });
                return false;
            });
            $(document).on('click', '.clickToUpdateTourStartDateElement', function(ev) {
                vietiso_loading(1);
                var $_this = $(this);
                var $_tp = $_this.attr("tp");
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/?mod=' + mod + '&act=ajSaveTourStartDateElement',
                    data: {
                        'tour_start_date_id': $_this.attr("tour_start_date_id"),
                        "val": $("#TourStartDateElementVal").val(),
                        "tp": $_tp
                    },
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        if ($_tp == 'end_date')
                            $("#TourStartDateElement-" + $_this.attr("tour_start_date_id") + "-" + $_tp).text(html);
                        else
                            $("#TourStartDateElement-" + $_this.attr("tour_start_date_id") + "-" + $_tp).text($("#TourStartDateElementVal").val());
                        $_this.closest(".frmPop").find(".close_pop").click();
                    }
                });
                return false;
            });
            $(document).on('click', '.clickResetPriceTourStartDate', function(ev) {
                if (confirm(confirm_reset)) {
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + '/?mod=' + mod + '&act=ajResetTourPriceStartDate',
                        data: {
                            "tour_id": tour_id
                        },
                        dataType: "html",
                        success: function(html) {
                            vietiso_loading(0);
                            loadTourPriceUnitStartDate();
                            alertify.success(reset_success);
                        }
                    });
                }
            });
        }
        if ($SiteHasExtensionTours == '1') {
            // Tour Extension
            $("#searchkey").bind('keyup change', function() {
                var $_this = $(this);
                if ($_this.val() != '') {
                    clearTimeout(aj_search);
                    search_tour();
                } else {
                    $("#autosugget").stop(false, true).slideUp();
                }
            });
            $(document).on('click', '.clickChooiseTour', function(ev) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajAddTourExtension',
                    data: {
                        'tour_1_id': tour_id,
                        'tour_2_id': $_this.attr('data')
                    },
                    dataType: 'html',
                    success: function(html) {
                        vietiso_loading(0);
                        if (html.indexOf('_SUCCESS') >= 0) {
                            $_this.remove();
                            loadTourExtension(tour_id);
                        }
                        if (html.indexOf('_EXIST') >= 0) {
                            alertify.error(exist_error);
                        }
                    }
                });
            });
            $(document).on('click', '.moveTourExtension', function(ev) {
                var _this = $(this);
                vietiso_loading(1);
                var adata = {
                    'tour_extension_id': _this.attr('data'),
                    'tour_1_id': tour_id,
                    'direct': _this.attr('direct')
                };
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajMoveTourExtension',
                    data: adata,
                    dataType: 'html',
                    success: function(html) {
                        vietiso_loading(0);
                        loadTourExtension(tour_id);
                    }
                });
            });
            $(document).on('click', '.clickDeleteTourExtension', function(ev) {
                if (confirm(confirm_delete)) {
                    var _this = $(this);
                    vietiso_loading(1);
                    $.ajax({
                        type: 'POST',
                        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajDeleteTourExtension',
                        data: {
                            "tour_extension_id": _this.attr('data')
                        },
                        dataType: 'html',
                        success: function(html) {
                            vietiso_loading(0);
                            loadTourExtension(tour_id);
                        }
                    });
                    return false;
                }
            });
        }
        $('input[class=ajvClk]').live('change', function() {
            var $_this = $(this);
            var adata = {
                '_type': $_this.attr('_type'),
                'tour_id': $_this.attr('data'),
                'val': $_this.is(':checked') ? 1 : 0
            };
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajUpdateTourVr3',
                data: adata,
                dataType: 'html',
                success: function(html) {}
            });
        });

        if ($SitePriceTableType_Tours == 2) {
            loadSlotAvailable(tour_id);
            $(document).on('change', '#chgSellByMonth', function(ev) {
                var $_this = $(this);
                var $is_type_table = $('#is_type_table').val();
                var $pp_month = $(this).val();
                var $pp_year = $('#chgSellByYear').val();
                loadSlotAvailable(tour_id, $pp_month, $pp_year, $is_type_table);
            });
            $(document).on('change', '#chgSellByYear', function(ev) {
                var $_this = $(this);
                var $is_type_table = $('#is_type_table').val();
                var $pp_year = $(this).val();
                var $pp_month = $('#chgSellByMonth').val();

                loadSlotAvailable(tour_id, $pp_month, $pp_year, $is_type_table);
            });
            $(document).on('click', '.showAvailablePriceTables', function(ev) {
                var $_this = $(this);
                var $is_type_table = $_this.attr('is_type_table');
                var $pp_month = $('#chgSellByMonth').val();
                var $pp_year = $('#chgSellByYear').val();
                /**/
                $('.showAvailablePriceTables').removeClass('active');
                $_this.addClass('active');
                $('#is_type_table').val($is_type_table);
                loadSlotAvailable(tour_id, $pp_month, $pp_year, $is_type_table);
            });
            $(document).on('change', '.chkSell', function(ev) {
                var $_this = $(this);
                checkSellActive();
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/?mod=tour&act=ajOpenSotAvailable",
                    data: {
                        'tp': 'S',
                        'start_date': $_this.attr('start_date'),
                        'tour_id': $_this.attr('tour_id'),
                        'is_active': $_this.is(':checked') ? 1 : 0
                    },
                    dataType: "html",
                    success: function(html) {
                        console.log(html);
                        var $pp_month = $('#chgSellByMonth').val();
                        var $pp_year = $('#chgSellByYear').val();
                        loadSlotAvailable(tour_id, $pp_month, $pp_year);
                    }
                });
            });
            $(document).on('change', '.autosavefield', function(ev) {
                var $_this = $(this);
                var adata = {};
                adata['clsTable'] = 'TourStartDate';
                adata['pkey'] = 'tour_start_date_id';
                adata['allowDuplicate'] = 1;
                adata['pvalTable'] = $_this.attr('data');
                adata['toField'] = $_this.attr('toField');
                adata['val'] = $_this.val();
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=home&act=saveField',
                    data: adata,
                    dataType: 'html',
                    success: function(html) {
                        if ($SitePriceTableType_Tours == 2) {
                            loadSlotAvailable(tour_id);
                        }
                    }
                });
            });
        }
    }
});
/* END READY FUNCTION */
function checkSellActive() {
    $('.chkSell').each(function() {
        var $_this = $(this);
        var $id = $_this.attr('id');
        var $s = $id.split('_');
        var $cu = $s[1] + '_' + $s[2];
        if ($_this.is(':checked') == false) {
            $('#input_' + $cu).attr('disabled', 'disabled');
            $('#input_sale_' + $cu).attr('disabled', 'disabled');
            $('#input_avai_' + $cu).attr('disabled', 'disabled');
            $('#input_price_' + $cu).attr('disabled', 'disabled');
            $('#input_price_old_' + $cu).attr('disabled', 'disabled');
        } else {
            $('#input_' + $cu).removeAttr('disabled');
            $('#input_sale_' + $cu).attr('disabled', 'disabled');
            $('#input_avai_' + $cu).attr('disabled', 'disabled');
            $('#input_price_' + $cu).removeAttr('disabled');
            $('#input_price_old_' + $cu).removeAttr('disabled');
        }
    });
}

function loadSlotAvailable($tour_id, $pp_month, $pp_year, $is_type_table) {
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=' + mod + '&act=ajOpenSotAvailable',
        data: {
            'tp': 'L',
            "tour_id": $tour_id,
            "pp_month": $pp_month,
            "pp_year": $pp_year,
            "is_type_table": $is_type_table
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            $('#slotAvailableContainer').html(html);
            checkSellActive();
        }
    });
}

function loadTourCategory($tour_group_id, $selected, $chosen, $conatiner) {
    if ($conatiner == '' || $conatiner == undefined) {
        $conatiner = 'slb_Category';
    }
    $('#' + $conatiner).html('<option value="0">' + loading + '</option>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=' + mod + '&act=ajaxSiteTourCategory',
        data: {
            "tour_group_id": $tour_group_id,
            "cat_id": $selected,
            "chosen": $chosen,
        },
        dataType: "html",
        success: function(html) {
            if ($chosen) {
                $('#' + $conatiner).html(html);
                $(".chosen-select").chosen({
                    max_selected_options: 5,
                    width: '100%'
                });
            } else {
                $('#' + $conatiner).html(html);
            }
        }
    });
}

function loadDepartPoint($country_id, $cat_id, $tour_type_id, $departure_point_id) {
    $('#slb_Departure_Point').html('<option value="0">' + loading + '</option>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=' + mod + '&act=ajaxSiteDeparturePoint',
        data: {
            "country_id": $country_id,
            "cat_id": $cat_id,
            'tour_type_id': $tour_type_id,
            'departure_point_id': $departure_point_id,
        },
        dataType: "html",
        success: function(html) {
            $('#slb_Departure_Point').html(html);
        }
    });
}

function loadCustomField($tour_id) {
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/index.php?mod=tour&act=SiteTourCustomField",
        data: {
            'tour_id': $tour_id,
            'tp': 'L'
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html != '') {
                $('.SiteCustomFieldContaciner').html(html);
                $('.Site_Custom_Field_Editor').each(function() {
                    var $editorID = $(this).attr('id');
                    $('#' + $editorID).isoTextArea();
                });
            }
        }
    });
}

function loadTourItinerary($tour_id) {
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmTourItinerary',
        data: {
            'tour_id': $tour_id,
            'tp': 'L'
        },
        dataType: "html",
        success: function(html) {
            if (html.replace(" ", "") == "") {
                $("#holderCopyItinerary").hide();
                $("#tab3Note").addClass("iso-check-disabled").removeClass("iso-check");
            } else {
                $("#holderCopyItinerary").show();
                $("#tab3Note").removeClass("iso-check-disabled").addClass("iso-check");
            }
            $('#tblTourItinerary').html(html);
        }
    });
}
function loadTourItineraryContingency($tour_id) {
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmTourItineraryContingency',
        data: {
            'tour_id': $tour_id,
            'tp': 'L'
        },
        dataType: "html",
        success: function(html) {
            if (html.replace(" ", "") == "") {
                $("#holderCopyItinerary").hide();
                $("#tab3Note").addClass("iso-check-disabled").removeClass("iso-check");
            } else {
                $("#holderCopyItinerary").show();
                $("#tab3Note").removeClass("iso-check-disabled").addClass("iso-check");
            }
            $('#tblTourItinerary_contingency').html(html);
        }
    });
}

function setSelectBoxDestination() {
    if ($SiteHasGroup_Tours == 1) {
        if ($tourgroup_ID == 1) {
            if ($SiteModActive_continent == '1') {
                $('#slb_Country').hide();
                $('#slb_RegionID').hide();
                $('#slb_CityID').hide();
				$('#slb_placetogoID').hide();
            } else {
                if ($SiteModActive_country == '1') {
                    loadCountry();
                    $('#slb_RegionID').hide();
                    $('#slb_CityID').hide();
					$('#slb_placetogoID').hide();
                } else {
                    if ($SiteActive_region == '1') {
                        loadRegion();
                        $('#slb_CityID').hide();
						$('#slb_placetogoID').hide();
                    } else if ($SiteActive_city == '1') {
                        loadCity();
                    } else {
                        $('#slb_CityID').hide();
                    }
                }
            }
        } else {
            $('#slb_Chauluc').hide();
            $('#slb_Country').hide();

            var $country_id = $('#Hid_Country').val();
            if ($SiteActive_region == '1') {
                loadRegion($country_id);
                $('#slb_CityID').hide();
				$('#slb_placetogoID').hide();
            } else if ($SiteActive_city == '1') {
                loadCity($country_id);
            } else {
                $('#slb_CityID').hide();
				$('#slb_placetogoID').hide();
            }
        }
    } else {
        if ($SiteModActive_continent == '1') {
            $('#slb_Country').hide();
            $('#slb_RegionID').hide();
            $('#slb_CityID').hide();
			$('#slb_placetogoID').hide();
        } else {
            if ($SiteModActive_country == '1') {
                loadCountry();
                $('#slb_RegionID').hide();
                $('#slb_CityID').hide();
				$('#slb_placetogoID').hide();
            } else {
                if ($SiteActive_region == '1') {
                    loadRegion();
                    $('#slb_CityID').hide();
					$('#slb_placetogoID').hide();
                } else if ($SiteActive_city == '1') {
                    loadCity();
                } else {
                    $('#slb_CityID').hide();
					$('#slb_placetogoID').hide();
                }
            }
        }
    }
}

function loadCountry($chauluc_id, $khuvuc_id, $country_id) {
    $('#slb_Country').html('<option value="0">' + loading + '</option>')
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadCountry",
        data: {
            "chauluc_id": $chauluc_id,
            "khuvuc_id": $khuvuc_id,
            "country_id": $country_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_Country').hide();
            } else {
                $('#slb_Country').html(html).show();
            }
            /**/
            $('#slb_RegionID').hide();
            $('#slb_CityID').hide();
			$('#slb_placetogoID').hide();
        }
    });
}

function loadRegion($country_id, $region_id) {
    $('#slb_RegionID').html('<option value="0">' + loading + '</option>')
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadRegion",
        data: {
            "country_id": $country_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_RegionID').hide();
				loadCity($country_id);
            } else {
                $('#slb_RegionID').html(html).show();
            }
        }
    });
}

function loadCity($country_id, $region_id, $city_id, $tour_id) {
    $('#slb_CityID').html('<option value="0">' + loading + '</option>');
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajmakeSelectCityGlobal",
        data: {
            "country_id": $country_id,
            "region_id": $region_id,
            'city_id': $city_id,
            'tour_id': $tour_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_CityID').hide();
            } else {
				
                $('#slb_CityID').html(html).chosen({width:'125px'});
				$("#slb_CityID").next().css({'float':'left','margin-bottom':'5px'});
				$('#slb_CityID').trigger("chosen:updated");
				
            }
        }
    });
}
/*
function loadTourCategory($tour_group_id, $selected, $chosen, $conatiner) {
    if ($conatiner == '' || $conatiner == undefined) {
        $conatiner = 'slb_Category';
    }
    $('#' + $conatiner).html('<option value="0">' + loading + '</option>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=' + mod + '&act=ajaxSiteTourCategory',
        data: {
            "tour_group_id": $tour_group_id,
            "cat_id": $selected,
            "chosen": $chosen,
        },
        dataType: "html",
        success: function(html) {
            if ($chosen) {
                $('#' + $conatiner).html(html);
                $(".chosen-select").chosen({
                    max_selected_options: 5,
                    width: '100%'
                });
            } else {
                $('#' + $conatiner).html(html);
            }
        }
    });
}
*/

function loadPlaceTogo($country_id, $city_id) {
    $('#slb_placetogoID').html('<option value="0">' + loading + '</option>');
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajmakeSelectPlaceToGoGlobal",
        data: {
            "country_id": $country_id,
            'city_id': $city_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_placetogoID').hide();
            } else {
                $('#slb_placetogoID').html(html).show();	
            }
        }
    });
}


function loadListDestination($tour_id) {
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=' + mod + '&act=ajaxLoadTourDestination',
        data: {
            "tour_id": $tour_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            $('#lstDestination').html(html);
			loadMaps($tour_id);
        }
    });
}

function initDateInOut() {
    $('#departure_date').datepicker({
        dateFormat: "dd-mm-yy",
        minDate: new Date()
    });
    $('#return_date').datepicker({
        dateFormat: "dd-mm-yy",
        minDate: new Date()
    });
}

function load_season_price($season) {
    vietiso_loading(1);
    var $_this = $(this);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=tour&act=aj_load_season_price",
        data: {
            'tour_id': $tour_id,
            "season": $season
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            var htm = html.split('|||');
            $("#" + $season + "_season_price").html(htm[1]);
        }
    });
}

function loadTourPrice(tour_id) {
    vietiso_loading(1);
    $.ajax({
        type: 'POST',
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajLoadTourPrice',
        data: {
            "tour_id": tour_id
        },
        dataType: 'html',
        success: function(html) {
            vietiso_loading(0);
            $('#tblTourPrice').html(html);
        }
    });
}

function loadTourPriceNewVersion(tour_id) {
    var adata = {};
    adata['tour_id'] = $tour_id;
    adata['tp'] = 'L';

    vietiso_loading(1);
    $.ajax({
        type: 'POST',
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajLoadTourPriceNewVersion',
        data: adata,
        dataType: 'html',
        success: function(html) {
            vietiso_loading(0);
            $('.tblTourPriceNewVersion').html(html);
        }
    });
}

function loadCruisePriceTable($cruise_id, $cruise_itinerary_id, $cruise_cabin_id, $cruise_property_id) {
    var adata = {};
    adata['cruise_id'] = $cruise_id;
    adata['cruise_itinerary_id'] = $cruise_itinerary_id;
    adata['cruise_cabin_id'] = $cruise_cabin_id;
    adata['cruise_property_id'] = $cruise_property_id;
    adata['tp'] = 'L';

    vietiso_loading(1);
    $.ajax({
        type: 'POST',
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajCruisePriceSetup',
        data: adata,
        dataType: 'html',
        success: function(html) {
            vietiso_loading(0);
            $('#tblCruisePrice').html(html);
        }
    });
}

function loadTourPriceGroupNoDeparture() {
	vietiso_loading(1);
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/?mod=' + mod + '&act=ajLoadTourPriceGroup',
		data: {
			'tour_id' : $tour_id,
			'tp'       : 'L'
		},
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			$("#TourPriceGroupNoDeparture").html(html);
		}
	});
}

if (mod == 'tour_exhautive' && act == 'edit') {
    function loadCityHotelList() {
        $('select[name=cityhotel_id]').html('<option value="0">-- ' + cities + '--</option>');
        var $country_id = $('select[name=countryhotel_id]').val();
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajmakeSelectCityHotelGlobal",
            data: {
                "country_id": $country_id
            },
            dataType: "html",
            success: function(html) {
                vietiso_loading(0);
                if (html.replace(' ', '') != '') {
                    $('select[name=cityhotel_id]').html(html).show();
                } else {
                    $('select[name=cityhotel_id]').html('<option value="0">-- ' + cities + ' --</option>').hide();
                }
            }
        });
    }

    function loadListHotelItinerary($tour_id, $tour_itinerary_id, $keyword) {
        var adata = {
            'tour_id': $tour_id,
            'tour_itinerary_id': $tour_itinerary_id,
            'keyword': $keyword
        };
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxLoadHotelItinerary',
            data: adata,
            dataType: "html",
            success: function(html) {
                $('#lstHotel').html(html);
                vietiso_loading(0);
            }
        });
    }

    function loadTourPriceUnitStartDate() {
        vietiso_loading(1);
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/?mod=' + mod + '&act=ajLoadTourPriceUnitStartDate',
            data: {
                'tour_id': tour_id
            },
            dataType: "html",
            success: function(html) {
                vietiso_loading(0);
                $("#StartDateHolder").html(html);
            }
        });
    }
	function loadTourPriceUnitStartDateAgent() {
        vietiso_loading(1);
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/?mod=' + mod + '&act=ajLoadTourPriceUnitStartDate',
            data: {
                'tour_id': tour_id,
				'is_agent': 1
            },
            dataType: "html",
            success: function(html) {
                vietiso_loading(0);
                $("#StartDateHolderAgent").html(html);
            }
        });
    }


    function loadPriceTableCustomerAge() {
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/?mod=' + mod + '&act=ajLoadPriceTableCustomerAge',
            data: {
                'tour_id': tour_id
            },
            dataType: "html",
            success: function(html) {
                vietiso_loading(0);
                if (html.replace(' ', '') == '') {
                    $("#prTbl").html("<em style='color:red;'>" + required_client + "</em>");
                    $("#tab4Note").removeClass("iso-check").addClass("iso-check-disabled");
                } else {
                    $("#prTbl").html(html);
                    $("#tab4Note").addClass("iso-check").removeClass("iso-check-disabled");
                    loadTourPriceUnitStartDate();
                }
            }
        });
    }

    function loadTourExtension(tour_id) {
        $.ajax({
            type: 'POST',
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajLoadTourExtension',
            data: {
                "tour_1_id": tour_id
            },
            dataType: 'html',
            success: function(html) {
                if (html.replace(' ', '') == '') {
                    $("#tab5Note").removeClass("iso-check").addClass("iso-check-disabled");
                } else {
                    $('#tblTourExtension').html(html);
                    $("#tab5Note").addClass("iso-check").removeClass("iso-check-disabled");
                }
            }
        });
    }

    function search_tour() {
        aj_search = setTimeout(function() {
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajGetSearch',
                data: {
                    "keyword": $("#searchkey").val(),
                    "tour_id": tour_id
                },
                dataType: 'html',
                success: function(html) {
                    if (html.indexOf('_EMPTY') >= 0) {
                        $('#autosugget').hide();
                    } else {
                        $('#autosugget').stop(false, true).slideDown();
                        $('#autosugget').find('.HTML_sugget').html(html);
                    }
                }
            });
        }, 500);
    }

    function initSysGalleryTour() {
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajInitTSysTourGallery',
            data: {
                'table_id': tour_id
            },
            dataType: "html",
            success: function(html) {
                $('#TourGalleryHolder').html(html);
                loadTableGallery(tour_id, '', 1, 10);
            }
        });
    }

    function loadTableGallery(table_id, keyword, $page, $number_per_page) {
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajOpenTourGallery',
            data: {
                'table_id': table_id,
                'keyword': keyword,
                'page': $page,
                'number_per_page': $number_per_page,
                'tp': 'L'
            },
            dataType: "html",
            success: function(html) {
                //console.log(html);
                var $htm = html.split('$$$');
                $('#preview').html($htm[0]);
                $('#gallery_paginate').html($htm[1]);
            }
        });
    }

    function reloadListHotel($continent_id, $country_id, $city_id, $star, $keyword, $tour_id, $tour_itinerary_id, $page, $number_per_page) {
        var adata = {};
        adata['continent_id'] = $continent_id;
        adata['country_id'] = $country_id;
        adata['city_id'] = $city_id;
        adata['keyword'] = $keyword;
        adata['star'] = $star;
        adata['tour_id'] = $tour_id;
        adata['tour_itinerary_id'] = $tour_itinerary_id;
        adata['page'] = $page;
        adata['number_per_page'] = $number_per_page;

        vietiso_loading(1);
        $.ajax({
            type: 'POST',
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxLoadListHotel',
            data: adata,
            dataType: 'html',
            success: function(html) {
                var htm = html.split('$$');
                $('#pop_HotelRecommend #tblHolderHotel').html(htm[0]);
                $('#pop_HotelRecommend #dataTable_paginate').html(htm[1]);
                vietiso_loading(0);
            }
        });
    }

    function loadChauLuc() {
        $('select[name=country_id]').html('<option value="0"><< ' + country + ' >></option>').hide();
        $('select[name=khuvuc_id]').html('<option value="0"><< ' + area + ' >></option>').hide();
        $('select[name=area_id]').html('<option value="0"><< ' + regions + ' >></option>').hide();
        $('select[name=city_id]').html('<option value="0"><< ' + cities + ' >></option>').hide();
        $('select[name=destination_id]').html('<option value="0"><< ' + attractions + ' >></option>').hide();
        $('select[name=chauluc_id]').html('<option value="0"><< ' + continents + ' >></option>');
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadChauLuc",
            dataType: "html",
            success: function(html) {
                vietiso_loading(0);
                $('select[name=chauluc_id]').append(html).show();
            }
        });
    }
}





function isoman_callback() {
    $xx = isoman_selected_files();
}
function loadListTourOption() {
	vietiso_loading(1);
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/?mod=' + mod + '&act=ajLoadListTourOption',
		data: {
			'tp'       : 'loadList'
		},
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			$("#LstTourOption").html(html);
		}
	});
}


function loadListHotTourPromotion() {
	vietiso_loading(1);
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/?mod=' + mod + '&act=ajLoadListHotPromotion',
		data: {
			'target_id': tour_id
		},
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			$("#ListHotPromotion").html(html);
		}
	});
}
function loadTourPriceGroup($tour_id,$departure,$tour_start_date_id){
	var adata = {
		'tour_id' : $tour_id,
		'departure' : $departure,
		'tour_start_date_id' : $tour_start_date_id,
		'tp' : 'L'
	};
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajLoadTourPriceGroup",
		data: adata,
		dataType: "html",
		success: function(html){
			vietiso_loading(2);
			$('#tblTourPriceGroup').html(html);
		}
	});
}
function loadTourPriceDetail() {
    var trip_price = parseInt($('#priceHiddenAdult').val());
	if(trip_price>0){
		var priceAd = $('#advertisedPriceFormatted');
		priceAd.change(function() {
			if (!isNaN(parseInt($(this).val()))) {
				if (parseInt($(this).val()) >= trip_price) {
					}else{
					alert("Input data is invalid");
					$(this).val(trip_price);
				}
			} else {
				alert("Input data is invalid");
				$(this).val(trip_price);
			}
		});
	}
}
function loadListPriceTourGroupStartDate() {
	vietiso_loading(1);
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/?mod=' + mod + '&act=ajLoadListPriceTourGroupStartDate',
		data: {
			'tour_id': tour_id
		},
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			$("#GroupStartDateHolder").html(html);
		}
	});
}
function checkNumberDaysNights() {
    var number_days= $('#select_number_days option:selected').val();
    var number_nights= $('#select_number_nights option:selected').val();

    if(number_days == number_nights){
        $('.contingency_table').show();
    }else{
        $('.contingency_table').hide();
    }
}

$(document).on('click', '.btnCreateNewReview', function(ev) {
    vietiso_loading(1);
    var review_id = $(this).attr('review_id');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxLoadReviews',
        data: {
            'tour_id': tour_id,
            'review_id': review_id,
            'tp': 'Edit'
        },
        dataType: "html",
        success: function(html) {
            makepopupnotresize('50%', 'auto', html, 'SiteFrmTourRewreviw');
            $('#SiteFrmTourRewreviw').css('top', '20px');
            var $editorID = $('.textarea_review_content_editor').attr('id');
            $('#' + $editorID).isoTextAreaFull();
            vietiso_loading(0);
        }
    });
    return false;
});

$(document).on('click', '.btnSaveTourReview', function(ev) {
		var $editorID = $('.textarea_review_content_editor').attr('id');
		var $content = tinyMCE.get($editorID).getContent();
		$("textarea[name=iso-content]").val($content);
});
	
$(document).on('click', '.btnSaveTourReview', function(ev) {
	  var $_this = $(this);
	var $data = $("#reviewData").serializeArray(); 
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxLoadReviews',
        data: $data,
        dataType: "html",
        success: function(html) {
            if (html.indexOf('_INSERT_SUCCESS') >= 0) {
                vietiso_loading(1);
                $_this.closest('.frmPop').find('.close_pop').trigger('click');
                alertify.success(insert_success);
                vietiso_loading(0);
            }
            if (html.indexOf('_UPDATE_SUCCESS') >= 0) {
                vietiso_loading(1);
                $_this.closest('.frmPop').find('.close_pop').trigger('click');
                alertify.success(update_success);
                vietiso_loading(0);
            }
            if (html.indexOf('_ERROR') >= 0) {
                alertify.error(insert_error);
            }
            if (html.indexOf('_EXIST') >= 0) {
                alertify.error(exist_error);
            }
        }
    });
    return false;
});


$(document).on('click', '.clickDeleteReviews', function(ev) {
    var $_this = $(this);
    if (confirm(confirm_delete)) {
        $.ajax({
            type: 'POST',
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxLoadReviews',
            data: {
                'review_id': $_this.attr('data'),
                'tp': 'delete',
                'tour_id': $tour_id,
            },
            dataType: 'html',
            success: function(html) {
                vietiso_loading(0);
                alertify.success(delete_success);}
        });
    }
    return false;
});

$(document).on('click', '.clickStatusReviews', function(ev) {
    var $_this = $(this);
        $.ajax({
            type: 'POST',
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxLoadReviews',
            data: {
                'review_id': $_this.attr('data'),
                'tp': 'status',
                'tour_id': $tour_id,
				'is_online':$_this.attr('is_online')
            },
            dataType: 'html',
            success: function(html) {
                vietiso_loading(0);
                alertify.success(update_success);
           
            }
        });
    return false;
});
$(document).on('click', '#clickToAddDay', function(ev) {
	var $_this = $(this);
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/?mod=' + mod + '&act=ajAddHotPromotion',
		data: {
			'target_id': tour_id,
			'type': 'TOUR',
		},
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			loadListHotTourPromotion();
		}
	});
	return false;
});
$(document).on('click', '.clickToAddNewTourGroupStartDate', function(ev) {
	var $_this = $(this);
	if ($("#multiDate").val() == '') {
		$("#multiDate").focus();
		return false;
	}
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/?mod=' + mod + '&act=ajAddGroupStartDate',
		data: {
			'tour_id': tour_id,
			'type': 'GROUP',
			'start_date': $("#multiDate").val()
		},
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			loadListPriceTourGroupStartDate();
			//loadTourPriceUnitStartDate();
			$_this.closest(".frmPop").find(".close_pop").click();
		}
	});
	return false;
});
$(document).on('click', '.clickDeleteTourStartDate', function(ev) {
	if (confirm(confirm_delete)) {
		vietiso_loading(1);
		var $_this = $(this);
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/?mod=' + mod + '&act=ajDeleteTourStartDate',
			data: {
				'tour_start_date_id': $_this.attr("tour_start_date_id"),
				'tour_id': tour_id,
				'departure': $_this.attr("departure")
			},
			dataType: "html",
			success: function(html) {
				vietiso_loading(0);
				loadTourPriceUnitStartDate();
			}
		});
	}
	return false;
});
$(document).on('click', '.clickCopyTourGroupStartDate', function(ev) {
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/?mod=' + mod + '&act=ajCopyPriceStartDateGroup',
		data: {
			'tour_start_date_id': $_this.attr("tour_start_date_id"),
			'tour_id': tour_id,
			'departure': $_this.attr("departure"),
			'type':'GROUP',
			'tp':'COPY',
		},
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			loadListPriceTourGroupStartDate();
		}
	});
	return false;
});

$(document).on('click', '.clickPasteTourGroupStartDate', function(ev) {
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/?mod=' + mod + '&act=ajCopyPriceStartDateGroup',
		data: {
			'tour_start_date_id': $_this.attr("tour_start_date_id"),
			'tour_id': tour_id,
			'departure': $_this.attr("departure"),
			'type':'GROUP',
			'tp':'PASTE',
		},
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			loadListPriceTourGroupStartDate();
		}
	});
	return false;
});

$(document).on('click', '.clickDeleteTourGroupStartDate', function(ev) {
	if (confirm(confirm_delete)) {
		vietiso_loading(1);
		var $_this = $(this);
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/?mod=' + mod + '&act=ajDeleteTourGroupStartDate',
			data: {
				'tour_start_date_id': $_this.attr("tour_start_date_id"),
				'tour_id': tour_id,
				'departure': $_this.attr("departure"),
				'type':'GROUP',
			},
			dataType: "html",
			success: function(html) {
				vietiso_loading(0);
				loadListPriceTourGroupStartDate();
			}
		});
	}
	return false;
});




$(document).on('click', '.clickEditHotPromotion', function(ev) {
	var $_this = $(this);
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajLoadHotPromotionItem',
		data: {
			'hot_promotion_id': $_this.attr('hot_promotion_id'),
			'target_id': $_this.attr('target_id'),
			'tp': 'F'
		},
		dataType: "html",
		success: function(html) {
			makepopupnotresize('600px', 'auto', html, 'SiteFrmHotPromotionItem');
			$('#SiteFrmHotPromotionItem').css('top', '20px');
			var $editorID = $('.textarea_price_editor').attr('id');
			$('#' + $editorID).isoTextAreaFull();
			vietiso_loading(0);
		}
	});
	return false;
});
$(document).on('click', '.btnSaveHotPromotion', function(ev) {
	var $_this = $(this);
	var $_form = $_this.closest('.frmPop');
	var $start_date = $_form.find('input[name=start_date]');
	var $end_date = $_form.find('input[name=end_date]');
	var $flag_text = $_form.find('input[name=flag_text]');
	var $price_ads = $_form.find('input[name=price_ads]');
	var $price_agent = $_form.find('input[name=price_agent]');
	var $deposit = $_form.find('input[name=deposit]');
	var $hot_promotion_id = $_this.attr('hot_promotion_id');
	var $target_id = $_this.attr('target_id');
	
	

	if ($start_date.val() == '') {
		$start_date.focus().addClass('error');
		alertify.error(field_is_required);
		return false;
	}
	if ($end_date.val() == '') {
		$end_date.focus().addClass('error');
		alertify.error(field_is_required);
		return false;
	}
	if ($flag_text.val() == '') {
		$flag_text.focus().addClass('error');
		alertify.error(field_is_required);
		return false;
	}
	if ($price_ads.val() == '') {
		$price_ads.focus().addClass('error');
		alertify.error(field_is_required);
		return false;
	}
	var adata = {};
	adata['start_date'] = $start_date.val();
	adata['end_date'] = $end_date.val();
	adata['flag_text'] = $flag_text.val();
	adata['price_ads'] = $price_ads.val();
	adata['price_agent'] = $price_agent.val();
	adata['deposit'] = $deposit.val();
	adata['hot_promotion_id'] = $hot_promotion_id;
	adata['target_id'] = $target_id;
	adata['tp'] = 'S';
	vietiso_loading(1);
	$('#tblPriceHotPromotion').ajaxSubmit({
		type: "POST",
		url: path_ajax_script + '/index.php?mod='+mod+'&act=ajLoadHotPromotionItem',
		data: adata,
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			if (html.indexOf('_UPDATE_SUCCESS') >= 0) {
				$_this.closest('.frmPop').find('.close_pop').trigger('click');
				if(act=='list_promotion'){
					location.href = REQUEST_URI;
				}else{
				loadListHotTourPromotion();
				}
			}
			if (html.indexOf('_ERROR') >= 0) {
				alertify.error(insert_error);
			}
			if (html.indexOf('_EXIST') >= 0) {
				alertify.error(exist_error);
			}
			if (html.indexOf('start_date_invalid') >= 0) {
				$start_date.focus();
				alertify.error(start_date_error);
			}
			if (html.indexOf('end_date_invalid') >= 0) {
				$end_date.focus();
				alertify.error(end_date_error);
			}
		}
	});
	return false;
});
$(document).on('click', '.clickDeleteHotPromotion', function(ev) {
	if (confirm(confirm_delete)) {
		vietiso_loading(1);
		var $_this = $(this);
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/?mod=' + mod + '&act=ajDeleteHotPromotion',
			data: {
				'hot_promotion_id': $_this.attr("hot_promotion_id"),
				'target_id': $_this.attr("target_id"),
			},
			dataType: "html",
			success: function(html) {
				vietiso_loading(0);
				if(act=='list_promotion'){
					location.href = REQUEST_URI;
				}else{
					loadListHotTourPromotion();
				}
			}
		});
	}
	return false;
});



if(mod=='tour_exhautive' && act=='property'){
	loadListTourOption();
	loadListSizeGroup('16', 'SIZEGROUP');
	$(document).ready(function(){
		var aj_search = '';
		$(document).on('click', '#findSizeGroup', function(ev) {
			var $_this = $(this);
			loadListSizeGroup($('input[name=keyword]').val(), $type);
		});
		$(document).on('click','.btnCreateSizeGroup',function(e){
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmTourSizeGroup',
				data : adata = {'tour_property_id' : $_this.attr('tour_property_id'),'type' : 'SIZEGROUP','tp' : 'F'},
				dataType:'html',
				success:function(html){
					makepopupnotresize('30%','auto',html,'box_CreateTourSizeGroup');
					$('#box_CreateTourSizeGroup').css('top', 80 + 'px');
					$(".price").priceFormat({thousandsSeparator: '.',centsLimit: 0});
					vietiso_loading(0);
				}
			});
			return false;
		});
		$(document).on('click','.ajEditSizeGroup',function(e){
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmTourSizeGroup',
				data : {'tour_option_id' : $_this.attr('data'),'tour_property_id' : $_this.attr('tour_property_id'),'tp' : 'F'},
				dataType:'html',
				success:function(html){
					makepopupnotresize('30%','auto',html,'box_EditTourSizeGroup');
					$('#box_EditTourSizeGroup').css('top', 80 + 'px');
					vietiso_loading(0);
				}
			});
			return false;
		});
		$(document).on('click','.ajSubmitSizeGroup',function(e){
			var $_this = $(this);
			var $_form = $_this.closest('.frmPop');
			/**/
			var $title = $_form.find('input[name=title]');
			var $number_to = $_form.find('input[name=number_to]');
			var $number_from = $_form.find('input[name=number_from]');
			/**/
			if($.trim($title.val())==''){
				$title.addClass('error').focus();
				alertify.error(field_is_required);
				return false;
			}
			if($number_to.val()==''){
				$number_to.addClass('error').focus();
				alertify.error(field_is_required);
				return false;
			}
			if($number_from.val()==''){
				$number_from.addClass('error').focus();
				alertify.error(field_is_required);
				return false;
			}
			var adata = {
				'title'		: $title.val(),
				'type'		: 'SIZEGROUP',
				'number_to' 	: $number_to.val(),
				'number_from' 	: $number_from.val(),
				'tour_property_id' : $_this.attr('tour_property_id'),
				'tour_option_id' : $_this.attr('tour_option_id'),
				'tp' : 'S'
			};
			vietiso_loading(1);
			$.ajax({
				type:'POST',
				url : path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmTourSizeGroup',
				data:adata,
				dataType:'html',
				success:function(html){
					vietiso_loading(0);
					if(html.indexOf('_SUCCESS') >=0 ){
						alertify.success(insert_success);
						loadListSizeGroup($_this.attr('tour_property_id'),'SIZEGROUP');
						$_form.find('.close_pop').trigger('click');
					}
					else if(html.indexOf('_UPDATE_SUCCESS') >=0 ){
						alertify.success(update_success);
						var $keyword = $('#keyword').val();
						var $page = $('.paginate_current_page').val();
						var $number_per_page = $('.paginate_length').val();
						loadListSizeGroup($_this.attr('tour_property_id'),'SIZEGROUP');
						$_form.find('.close_pop').trigger('click');
					}
					else if(html.indexOf('_ERROR') >=0 ){
						alertify.error(insert_error);
					}
					else{
						alertify.error(exist_error);
					}
					
				}
			});
		});
		$('.ajDeleteSizeGroup').live('click',function(){
			var $_this = $(this);
			if(confirm(confirm_delete)){
				var adata = {'tour_option_id' : $_this.attr('data')};
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmTourSizeGroup',
					data : {'tour_property_id' : $_this.attr('tour_property_id'),'tour_option_id' : $_this.attr('data'),'tp' : 'D'},
					dataType:'html',
					success:function(html){
						var $keyword = $('#keyword').val();
						loadListSizeGroup($_this.attr('tour_property_id'),'SIZEGROUP');
						vietiso_loading(0);
					}
				});
			}
			return false;
		});
		$(document).on('click', '#clickToAddTourOption', function(ev) {
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script + '/?mod=' + mod + '&act=ajAddTourOption',
				data: {
					'type': 'TOUROPTION',
				},
				dataType: "html",
				success: function(html) {
					vietiso_loading(0);
					loadListTourOption();
					//loadListHotTourPromotion();
				}
			});
			return false;
		});
		$(document).on('click', '.SiteClickSaveTourOption', function(ev) {
			var $_this = $(this);
			var $_form = $_this.closest('.frmPop');
			var $title = $_form.find('input[name=title]');
	
			if ($.trim($title.val()) == '') {
				$title.focus();
				alertify.error(field_is_required);
				return false;
			}
			var adata = {};
			adata['title'] = $title.val();
			adata['tour_option_id'] = $_this.attr('tour_option_id');
			adata['type'] = $_this.attr('type');
			adata['tp'] = 'Save';
	
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script + '/?mod=' + mod + '&act=ajLoadListTourOption',
				data: adata,
				dataType: "html",
				success: function(html) {
					vietiso_loading(0);
					window.location.reload();
				}
			});
			return false;
		});
		$(document).on('click', '.clickEditTourOption', function(ev) {
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajLoadListTourOption',
				data: {
					'tour_option_id': $_this.attr('tour_option_id'),
					'tp': 'Edit'
				},
				dataType: "html",
				success: function(html) {
					makepopupnotresize('600px', 'auto', html, 'SiteFrmTourOption');
					$('#SiteFrmTourOption').css('top', '20px');
					var $editorID = $('.textarea_price_editor').attr('id');
					$('#' + $editorID).isoTextAreaFull();
					vietiso_loading(0);
				}
			});
			return false;
		});
		$(document).on('click', '.clickDeleteTourOption', function(ev) {
			if (confirm(confirm_delete)) {
				vietiso_loading(1);
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script + '/?mod=' + mod + '&act=ajLoadListTourOption',
					data: {
						'tour_option_id': $_this.attr("tour_option_id"),
						'tp'		:'Delete'
					},
					dataType: "html",
					success: function(html) {
						vietiso_loading(0);
						loadListTourOption();
					}
				});
			}
			return false;
		});
		
	});
	function loadListSizeGroup($tour_property_id, $type){
		vietiso_loading(1);
		var adata = {
			'tour_property_id' : $tour_property_id,
			'type' : $type,
			'tp' : 'L'
		};
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/?mod="+mod+"&act=ajSiteFrmTourSizeGroup",
			data: adata,
			dataType: "html",
			success: function(html){
				var htm = html.split('$$');
				$('#tblHolderSizeGroup'+$tour_property_id).html(htm[0]);
				$('#dataTable_paginate'+$tour_property_id).html(htm[1]);
				vietiso_loading(0);
			}
		});
	}
}
$(document).on('click', '.add_new_tour', function (ev) {
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajActionNewTour',
        data: {
            'tp': 'S'
        },
        dataType: "json",
        success: function(json) {
            if(json.result == 'success'){
                window.location.href = json.link;
            }
        }
    });
});
$(document).on('click', '.add_new_day_trip', function (ev) {
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajActionNewTour',
        data: {
            'tp': 'S',
			'is_day_trip': '1'
        },
        dataType: "json",
        success: function(json) {
            if(json.result == 'success'){
                window.location.href = json.link;
            }
        }
    });
});

$(".chosen-select").chosen({
    max_selected_options: 10,
    width: '100%'
});