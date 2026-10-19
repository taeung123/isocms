$().ready(function() {
	var $ok = true;
	$(document).on('click', '.clickShowMap', function(){
		if($ok){
			$('#HotelMap_Area').show();
			initialize();
			$ok = false;
		}else{
			$('#HotelMap_Area').hide();
			$ok = true;
		}
		return false;
	});
	
	// Page Hotel - Mod: Default - Act: Default
    if(mod == 'hotelpro' && act == 'default'|| mod== 'area_city' && act=='default') {
        loadCountry();
        loadCity();
		$('#forums select').change(function() {
            $('#forums').submit();
        });
		$(document).on('click', '.ajDuplicateHotel', function(ev){
			var $_this=$(this);	
			if(confirm(confirm_cloning)){	
				vietiso_loading(1);	
				$.ajax({	
					type: "POST",
					url: path_ajax_script+'/?mod='+mod+'&act=ajDuplicateHotel',	
					data: {"hotel_id"	: $_this.attr('hotel_id')},	
					dataType: "html",	
					success: function(html){
						vietiso_loading(0);	
						location.href = html;
					}	
				});	
			}	
			return false;	
		});
        
        $('select[name=iso-country_id]').change(function() {
            var $_this = $(this);
            $('select[name=iso-city_id]').html('<option value="">'+loading+'</option>');
            $.ajax({
                type: "POST",
                url: path_ajax_script + "/?mod=hotelpro&act=loadCity",
                data: {"country_id": $_this.val()},
                dataType: "html",
                success: function(html) {
                    $('select[name=iso-city_id]').html(html);
                }
            });
        });
    }
	/* EDIT ONE HOTEL */
    if(mod == 'hotelpro' && act == 'edit'|| mod == 'area_city' && act == 'edit') {
        loadHotelFacibility(pvalTable);
		initSysGalleryHotel();
        loadHotelRoom();
        loadHotelPrice();
		if($Hotel_Region=='1'){loadRegion(country_id, region_id);}
		
		/* HOTEL_CUSTOM_FIELD */
		loadCustomField(hotel_id);
		$(document).on('click', '.ClickCustomField', function(ev){
			var $_this=$(this);
			vietiso_loading(1);	
			$.ajax({	
				type: "POST",
				url: path_ajax_script+'/?mod='+mod+'&act=SiteHotelCustomField',	
				data: {"hotel_id" : hotel_id, 'tp' : 'C'},	
				dataType: "html",	
				success: function(html){
					vietiso_loading(0);
					loadCustomField(hotel_id);
				}	
			});		
			return false;	
		});
		$(document).on('click', '.btndelete_customfield', function(ev){
			if(confirm(confirm_delete)){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteHotelCustomField",
					data: {'hotel_customfield_id' : $_this.attr('data'), 'tp' : 'D'},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						loadCustomField($_this.attr('hotel_id'));
					}
				});
			}
			return false;	
		});
		$(document).on('click', '.btnedit_customfield', function(ev){
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteHotelCustomField",
				data: {'tp': 'F', 'hotel_customfield_id' : $_this.attr('data'), 'hotel_id' : $_this.attr('hotel_id')},
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					makepopup(300,'auto',html,'pop_UpdateFieldName');
				}
			});
			return false;
		});
		$(document).on('click', '.SiteClickUpdateFieldName', function(ev){
			var $_this = $(this);
			var $_form = $_this.closest('.frmPop');
			var $fieldname = $_form.find('input[name=fieldname]');
			if($fieldname.val()==''){
				$fieldname.focus();
				alertiy.error(field_is_required);
				return false;
			}
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteHotelCustomField",
				data: {
					'tp': 'S',
					'hotel_customfield_id' : $_this.attr('hotel_customfield_id'),
					'hotel_id' : $_this.attr('hotel_id'),
					'fieldname' : $fieldname.val()
				},
				dataType: "html",
				success: function(html){
					if(html.indexOf('_EXIST') >= 0){
						alertify.error('Error !');
					}else{
						loadCustomField($_this.attr('hotel_id'));
						$_form.find('.close_pop').trigger('click');
					}
					vietiso_loading(0);
				}
			});
			return false;
		});
		$(document).on('click', '.btnmove_customfield', function(ev){
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteHotelCustomField",
				data: {
					'tp' : 'M',
					'hotel_id' : $_this.attr('hotel_id'),
					'direct' : $_this.attr('direct'),
					'hotel_customfield_id' : $_this.attr('data')
				},
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					loadCustomField($_this.attr('hotel_id'));
				}
			});	
			return false;
		});
		
		loadCity(country_id, region_id, city_id);
        /* FUNC */
		$(document).on('change', 'select[name=iso-continent_id]', function(ev){
            var $_this = $(this);
            var title = $_this.find('option:selected').attr('title');
			$('#slb_Country').html('<option value="0">'+loading+'</option>');
			$('#slb_Area').html('<option value="0">-- '+regions+' --</option>');
			$('#slb_City').html('<option value="0">-- '+cities+' --</option>');
            loadCountry($_this.val(),0);
        });
		$(document).on('change', 'select[name=iso-area_id]', function(ev){
			var $_this = $(this);
			var $country_id = $('select[name=iso-country_id]').val();
			if($country_id=='undefined' || $country_id == undefined){
				$country_id = 0;
			}
			loadCity($country_id, $_this.val(),0);
        });
		$(document).on('change', 'select[name=iso-country_id]', function(ev){
			var $_this = $(this);
			if($Hotel_Region=='1'){
				loadRegion($_this.val(),0);
			}
			
			loadCity($_this.val(),0,0);
        });
		$(document).on('change', 'select[name=iso-region_id]', function(ev){
			var $_this = $(this);
			var $country_id = $('select[name=iso-country_id]').val();
			if($country_id==undefined){
				$country_id = 0;
			}
			loadCity($country_id, $_this.val(),0);
        });
		/* START HOTEL_PROPERY_POP */
		$(document).on('click', '.ajaxManagerHotelProperty', function(ev){
			var $_this = $(this);
			var adata = {
				'type': $_this.attr('_type'),
				'fromid': $_this.attr('fromid'),
				'forid': $_this.attr('forid'),
				'tp' : 'L'
			};
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script + "/index.php?mod='+mod+'&act=ajGetBoxManagerHotelProperty",
				data: adata,
				dataType: "html",
				success: function(html) {
					vietiso_loading(0);
					makepopup('30%', '', html, 'frmBoxManagerHotelProperty');
				}
			});
			return false;
        });
		$(document).on('click', '#btnCreateNewHotelProperty', function(ev) {
			var $_this = $(this);
			var adata = {
				'type': $_this.attr('type'),
				'fromid': $_this.attr('fromid'),
				'forid': $_this.attr('forid'),
				'tp' : 'F'
			};
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script + "/index.php?mod='+mod+'&act=ajGetBoxManagerHotelProperty",
				data: adata,
				dataType: "html",
				success: function(html) {
					vietiso_loading(0);
					makepopup('25%', '', html, 'pop_FrmProperty');
				}
			});
		});
		$(document).on('click', '.edit_pop_hotel_property', function(ev) {
			var $_this = $(this);
			if (!$_this.hasClass('disabled')) {
				var adata = {
					'hotel_property_id': $_this.attr('data'),
					'fromid': $_this.attr('fromid'),
					'forid': $_this.attr('forid'),
					'tp' : 'F'
				};
				$_this.addClass('disabled');
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script + "/?mod=hotelpro&act=ajGetBoxManagerHotelProperty",
					data: adata,
					dataType: "html",
					success: function(html) {
						vietiso_loading(0);
						$_this.removeClass('disabled');
						makepopup('20%', '', html, 'pop_FrmProperty');
					}
				});
			}
			return false;
		});
		$(document).on('click', '#ajaxSaveHotelProperty', function(ev) {
			var $_this = $(this);
			if (!$_this.hasClass('disabled')) {
				var $_form = $_this.closest('.frmPop');
				
				var $title = $_form.find('input[name=title]');
				var $fromid = $_this.attr('fromid');
				var $forid = $_this.attr('forid');
	
				if ($title.val() == '') {
					$title.addClass('error').focus();
					return false;
				}
				var adata = {
					'hotel_property_id': $_this.attr('hotel_property_id'),
					'type': $_this.attr('_type'),
					'title': $title.val(),
					'tp' : 'S'
				};
				vietiso_loading(1);
				$_this.addClass('disabled');
				$.ajax({
					type: "POST",
					url: path_ajax_script + "/index.php?mod='+mod+'&act=ajGetBoxManagerHotelProperty",
					data: adata,
					dataType: "html",
					success: function(html) {
						$_this.removeClass('disabled');
						vietiso_loading(0);
						if (html.indexOf('IN_SUCCESS') >= 0) {
							$_form.find('.close_pop').trigger('click');
							alertify.success(insert_success);
							loadTableHotelProperty($_this.attr('_type'), $fromid, $forid);
							if ($fromid == 'pop_HotelRoom') {
								loadSelectBoxRoomFacility($_this.attr('property_id'), $forid);
							}
							if ($fromid == 'HotelFacilities') {
								loadHotelFacibility($forid);
							}
							if ($fromid == 'HotelRating') {
								loadSelectBoxHotelRating($_this.attr('_type'), $forid);
							}
						}
						if (html.indexOf('UP_SUCCESS') >= 0) {
							loadTableHotelProperty($_this.attr('_type'), $fromid, $forid);
							$_form.find('.close_pop').trigger('click');
							alertify.success(update_success);
	
							if ($fromid == 'pop_HotelRoom') {
								loadSelectBoxRoomFacility($_this.attr('property_id'), $forid);
							}
							if ($fromid == 'HotelFacilities') {
								loadHotelFacibility($forid);
							}
							if ($fromid == 'HotelRating') {
								loadSelectBoxHotelRating($_this.attr('_type'), $forid);
							}
						}
						if (html.indexOf('ERROR') >= 0) {
							alertify.error(error);
						}
						if (html.indexOf('EXIST') >= 0) {
							alertify.error(exist_error);
						}
					}
				});
			}
			return false;
		});
		$(document).on('click', '.delete_pop_hotel_property', function(ev) {
			var $_this = $(this);
			if (!$_this.hasClass('disabled')) {
				var $fromid = $_this.attr('fromid');
				var $forid = $_this.attr('forid');
				/**/
				if (confirm(confirm_delete)) {
					var adata = {'hotel_property_id': $_this.attr('data'),'tp' : 'D'};
					vietiso_loading(1);
					$_this.addClass('disabled');
					$.ajax({
						type: "POST",
						url: path_ajax_script + "/?mod=hotelpro&act=ajGetBoxManagerHotelProperty",
						data: adata,
						dataType: "html",
						success: function(html) {
							$_this.removeClass('disabled');
							vietiso_loading(0);
							loadTableHotelProperty($_this.attr('_type'), $_this.attr('fromid'), $_this.attr('forid'));
							if ($fromid == 'pop_HotelRoom') {
								loadSelectBoxRoomFacility($_this.attr('hotel_property_id'), $forid);
							}
							if ($fromid == 'HotelFacilities') {
								loadHotelFacibility($forid);
							}
							if ($fromid == 'HotelRating') {
								loadSelectBoxHotelRating($_this.attr('_type'), $forid);
							}
						}
					});
				}
			}
			return false;
		});
		/* END HOTEL_PROPERY_POP */
		
		/* START HOTEL ROOM */
		$(document).on('click', '#clickToAddHotelRoom', function(ev) {
            var $_this = $(this);
            var adata = {'hotel_id': $_this.attr('hotel_id')};
            $.ajax({
                type: "POST",
                url: path_ajax_script + "/index.php?mod='+mod+'&act=ajaxFrmHotelRoom",
                data: adata,
                dataType: "html",
                success: function(html) {
                    makepopupnotresize('60%', 'auto', html, 'pop_FrmHotelRoom');
                    $('#pop_FrmHotelRoom').css('top', 60 + 'px');
                    var editor_id = $('.textarea_content_editor').attr('id');
                    $('#' + editor_id).isoTextAreaFull();
                    $('#' + editor_id + '_ifr').height(120);
                    $(".selectbox").chosen({
                        max_selected_options: 100,
                        width: '100%'
                    });
					$(".price").priceFormat({
						thousandsSeparator: '.',
						centsLimit: 0
					});
                }
            });
        });
		$(document).on('click', '.clickEditHotelRoom', function(ev) {
            var $_this = $(this);
            var adata = {
                'hotel_room_id': $_this.attr('data'),
                'hotel_id': $_this.attr('hotel_id')
            };
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajaxFrmHotelRoom',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    vietiso_loading(0);
                    makepopupnotresize('60%', 'auto', html, 'pop_FrmHotelRoom');
                    $('#pop_FrmHotelRoom').css('top', 60 + 'px');
                    var editor_id = $('.textarea_content_editor').attr('id');
                    $('#' + editor_id).isoTextAreaFull();
                    $('#' + editor_id + '_ifr').height(120);
                    $(".selectbox").chosen({
                        max_selected_options: 100,
                        width: '100%'
                    });
					$(".price").priceFormat({
						thousandsSeparator: '.',
						centsLimit: 0
					});
                }
            });
        });
		$(document).on('click', '.deleteHotelRoomImage', function(ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                var adata = {'hotel_room_id': $_this.attr('hotel_room_id')};
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod='+mod+'&act=ajDeleteHotelRoomImage',
                    data: adata,
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        $("#isoman_show_image_room").attr("src", "");
                        $("#isoman_hidden_image_room").val("");
                        loadHotelRoom();
                    }
                });
            }
            return false;
        });
        $(document).on('click', '#clickSubmitHotelRoom', function(ev) {
            var $_this = $(this);
            if (!$_this.hasClass('disabled')) {
                var $title = $('input[name=hotel_room_title]').val();
                var $content = tinyMCE.get($('.textarea_content_editor').attr('id')).getContent();
                var $image = $('#isoman_hidden_image_room').val();
                if ($title == '') {
                    alertify.error(field_is_required);
                    $('input[name=hotel_room_title]').addClass('error').focus();
                    return false;
                }
                var adata = {
                    'hotel_room_id': $_this.attr('hotel_room_id'),
                    'hotel_id': $_this.attr('hotel_id'),
                    'intro': $content,
                    'image': $image
                };
                vietiso_loading(1);
                $_this.addClass('disabled');
                $('#frmHotelRoom').ajaxSubmit({
                    type: "POST",
                    url: path_ajax_script + "/index.php?mod='+mod+'&act=ajaxSubmitHotelRoom",
                    data: adata,
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        $_this.removeClass('disabled');
                        if (html.indexOf('_IN_SUCCESS') >= 0) {
                            loadHotelRoom();
                            loadHotelPrice();
                            alertify.success(insert_success);
							$_this.closest('.frmPop').find('.close_pop').trigger('click');
                        }
                        if (html.indexOf('_UPDATE_SUCCESS') >= 0) {
                            loadHotelRoom();
                            loadHotelPrice();
                            alertify.success(update_success);
							$_this.closest('.frmPop').find('.close_pop').trigger('click');
                        }
                        if (html.indexOf('_ERROR') >= 0) {
                            alertify.error(exist_error);
                        }
                        if (html.indexOf('_EXIST') >= 0) {
                            alertify.error(exist_error);
                        }
                    }
                });
            }
            return false;
        });
		$(document).on('click', '.clickDeleteHotelRoom', function(ev) {
            var $_this = $(this);
            if (confirm(confirm_delete)) {
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod='+mod+'&act=ajDeleteHotelRoom',
                    data: {'hotel_room_id': $_this.attr('data')},
                    dataType: 'html',
                    success: function(html) {
                        vietiso_loading(0);
                        loadHotelRoom();
                        loadHotelPrice();
                        alertify.success(delete_success);
                    }
                });
            }
            return false;
        });
		
		$(document).on('click', '.ajmoveHotelRoom', function(ev) {
			var $_this = $(this);
			var adata = {
				'hotel_room_id': $_this.attr('data'),
				'hotel_id': $_this.attr('hotel_id'),
				'direct': $_this.attr('direct'),
			};
			vietiso_loading(1);
			$.ajax({
				type: 'POST',
				url: path_ajax_script + "/index.php?mod='+mod+'&act=ajMoveHotelRoom",
				data: adata,
				dataType: 'html',
				success: function(html) {
					vietiso_loading(0);
					loadHotelRoom();
				}
			});
			return false;
		});
		
		// Add Hotel Price Col
		$(document).on('click', '#addHotelPriceRow', function(ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajLoadNewHotelPriceRow',
                dataType: 'html',
                data: {'hotel_id': pvalTable},
                success: function(html) {
                    vietiso_loading(0);
                    makepopup('300', '', html, 'NewHotelPriceRow');
                }
            });
            return false;
        });
		$(document).on('click', '#addHotelPriceCol', function(ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajLoadNewHotelPriceCol',
                dataType: 'html',
                data: {'hotel_id': pvalTable},
                success: function(html) {
                    vietiso_loading(0);
                    makepopup('300', '', html, 'NewHotelPriceCol');
                }
            });
            return false;
        });
		$(document).on('click', '.editHotelPriceRoom', function(ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajLoadEditHotelPriceRoom',
                dataType: 'html',
                data: {'id': $_this.attr('data')},
                success: function(html) {
					vietiso_loading(0);
                    makepopup('300', '', html, 'EditHotelPriceRow');
                }
            });
            return false;
        });
		$(document).on('click', '.editHotelPriceCol', function(ev) {
            var $_this = $(this);
            var adata = {'hotel_id': pvalTable};
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajCheckHotelPriceCol',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    if (html == 0) {
                        $('#addHotelPriceCol').trigger('click');
                    } else {
                        vietiso_loading(1);
                        $.ajax({
                            type: 'POST',
                            url: path_ajax_script + '/index.php?mod='+mod+'&act=ajLoadEditHotelPriceCol',
                            dataType: 'html',
                            data: {'id': $_this.attr('data')},
                            success: function(html) {
								vietiso_loading(0);
                                makepopup('300', '', html, 'EditHotelPriceCol');
                            }
                        });
                    }
                }
            });
            return false;
        });
		$(document).on('click', '.editHotelPriceVal', function(ev) {
            var $_this = $(this);
            var adata = {'hotel_id': pvalTable};
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajCheckHotelPriceCol',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    vietiso_loading(0);
                    if (html == 0) {
                        alertify.error(error);
                        $('#addHotelPriceCol').trigger('click');
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: path_ajax_script + '/index.php?mod='+mod+'&act=ajLoadEditHotelPriceVal',
                            dataType: 'html',
                            data: {
                                'hotel_price_col_id': $_this.attr('hotel_price_col_id'),
                                'hotel_price_row_id': $_this.attr('hotel_price_row_id')
                            },
                            success: function(html) {
                                makepopup('20%', '', html, 'EditHotelPriceVal');
                                $("#titleVal").priceFormat({thousandsSeparator: '.', centsLimit: 0});
                            }
                        });
                    }
                }
            });
            return false;
        });
		$(document).on('click', '.ajCopyPriceHotel', function(ev) {
            $('#titleVal').val($('#price').val());
            return false;
        });
		$(document).on('change', 'input[class=ajvClk]', function(ev) {
            var $_this = $(this);
            var adata = {
                'tp': $_this.attr('tp'),
                'tp_order': $_this.attr('tp_order'),
                'hotel_id': $_this.attr('data'),
                'val': $_this.is(':checked') ? 1 : 0
            };
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajUpdateHotelVr3',
                data: adata,
                dataType: 'html',
                success: function(html) {
                }
            });
        });
		$(document).on('click', '#clickToAddHotelPriceRow', function(ev) {
            var $_this = $(this);
            if ($('#titleRow').val() == '') {
                $('#titleRow').focus().addClass('error');
                alertify.error(title_required);
                return false;
            }
			vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajAddHotelPriceRow',
                data: {'hotel_id': $_this.attr('hotel_id'),'title': $('#titleRow').val()},
                dataType: 'html',
                success: function(html) {
					vietiso_loading(0);
                    if(html.indexOf("_EXIST") >= 0) {
                        alertify.error(insert_error);
                    }
					if(html.indexOf("_ERROR") >= 0) {
                        alertify.error(insert_error_exist);
                    }
					if(html.indexOf("_SUCCESS") >= 0) {
                        loadHotelPrice();
                        loadHotelRoom();
                        alertify.success(insert_success);
						$_this.closest('.frmPop').find('.close_pop').trigger('click');
                    }
                }
            });
            return false;
        });
		$(document).on('click', '#clickToAddHotelPriceCol', function(ev) {
            var $_this = $(this);
            if ($('#titleCol').val() == '') {
                $('#titleCol').focus().addClass('error');
                alertify.error(field_required);
                return false;
            }
            var adata = {
                'hotel_id': $_this.attr('hotel_id'),
                'title': $('#titleCol').val()
            };
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajAddHotelPriceCol',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    if (html.indexOf('_IN_SUCCESS') >= 0) {
						vietiso_loading(0);
                        loadHotelPrice();
						alertify.success(insert_success);
						$_this.closest('.frmPop').find('.close_pop').trigger('click');
                    }
                }
            });
            return false;
        });
		$(document).on('click', '#clickToEditHotelPriceRow', function(ev) {
            var $_this = $(this);
            var adata = {
                'id': $_this.attr('data'),
                'title': $('#titleRow').val()
            };
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajUpdateHotelPriceRow',
                data: adata,
                dataType: 'html',
                success: function(html) {
					vietiso_loading(0);
                    loadHotelPrice();
                    loadHotelRoom();
					$_this.closest('.frmPop').find('.close_pop').trigger('click');
                }
            });
            return false;
        });
		$(document).on('click', '#clickToEditHotelPriceCol', function(ev) {
            var $_this = $(this);
            if ($('#titleCol').val() == '') {
                $('#titleCol').focus().addClass('error');
                alertify.error(title_required);
                return false;
            }
            var adata = {
                'id': $_this.attr('data'),
                'title': $('#titleCol').val()
            };
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajUpdateHotelPriceCol',
                data: adata,
                dataType: 'html',
                success: function(html) {
					vietiso_loading(0);
                    loadHotelPrice();
					$_this.closest('.frmPop').find('.close_pop').trigger('click');
                }
            });
            return false;
        });
		$(document).on('click', '.deleteHotelPriceRoom', function(ev) {
            if(confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod='+mod+'&act=ajDeleteHotelPriceRoom',
                    data: {'id': $_this.attr('data')},
                    dataType: 'html',
                    success: function(html) {
						vietiso_loading(0);
                        loadHotelPrice();
                        loadHotelRoom();
                    }
                });
            }
            return false;
        });
		$(document).on('click', '.deleteHotelPriceCol', function(ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod='+mod+'&act=ajDeleteHotelPriceCol',
                    data: {'id': $_this.attr('data')},
                    dataType: 'html',
                    success: function(html) {
						vietiso_loading(0);
                        loadHotelPrice();
                    }
                });
            }
            return false;
        });
		$(document).on('click', '#clickToEditHotelPriceVal', function(ev) {
            var $_this = $(this);
            var adata = {
                'hotel_id': pvalTable,
                'hotel_price_col_id': $_this.attr('hotel_price_col_id'),
                'hotel_price_row_id': $_this.attr('hotel_price_row_id'),
                'price': $('#titleVal').val()
            };
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajUpdateHotelPriceVal',
                data: adata,
                dataType: 'html',
                success: function(html) {
					vietiso_loading(0);
                    loadHotelPrice();
					$_this.closest('.frmPop').find('.close_pop').trigger('click');
                }
            });
            return false;
        });
		$(document).on('click', '.moveHotelPriceRoom', function(ev) {
            var $_this = $(this);
            vietiso_loading(1);
            var adata = {
                'id': $_this.attr('data'),
                'direct': $_this.attr('direct')
            };
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajMoveHotelPriceRow',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    loadHotelPrice();
                    vietiso_loading(0);
                }
            });
            return false;
        });
		$(document).on('click', '.moveHotelPriceCol', function(ev) {
            var $_this = $(this);
            vietiso_loading(1);
            var adata = {
                'id': $_this.attr('data'),
                'direct': $_this.attr('direct')
            };
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod='+mod+'&act=ajMoveHotelPriceCol',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    vietiso_loading(0);
                    loadHotelPrice();
                }
            });
            return false;
        });
    }
	
	// Page Hotel - Mod: Default - Act: Price Range
    if(mod == 'hotelpro' && act == 'price_range') {
		loadTablePriceRange('',1,10);
		$(document).on('click', '#findPriceRange', function(ev) {
			var $_this = $(this);
			loadTablePriceRange($('input[name=keyword]').val(),1,10);
		});
		$(document).on('click', '.btnCreatePriceRange', function(ev) {
			vietiso_loading(1);
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmHotelPriceRange',
				data : adata = {'tp' : 'F'},
				dataType:'html',
				success:function(html){
					makepopupnotresize('30%','auto',html,'box_CreateHotelPriceRange');
					$('#box_CreateHotelPriceRange').css('top', 80 + 'px');
					$(".price").priceFormat({thousandsSeparator: '.',centsLimit: 0});
					vietiso_loading(0);
				}
			});
			return false;
		});
		$(document).on('click', '.ajEditPriceRange', function(ev) {
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmHotelPriceRange',
				data : {'hotel_price_range_id' : $_this.attr('data'),'tp' : 'F'},
				dataType:'html',
				success:function(html){
					makepopupnotresize('30%','auto',html,'box_EditHotelPriceRange');
					$('#box_EditHotelPriceRange').css('top', 80 + 'px');
					$(".price").priceFormat({thousandsSeparator: '.',centsLimit: 0});
					vietiso_loading(0);
				}
			});
			return false;
		});
		$(document).on('click', '.ajSubmitPriceRange', function(ev) {
			var $_this = $(this);
			var $_form = $_this.closest('.frmPop');
			/**/
			var $title = $_form.find('input[name=title]');
			var $min_rate = $_form.find('input[name=min_rate]');
			var $max_rate = $_form.find('input[name=max_rate]');
			/**/
			if($title.val()==''){
				$title.addClass('error').focus();
				alertify.error(field_is_required);
				return false;
			}
			if($min_rate.val()==''){
				$min_rate.addClass('error').focus();
				alertify.error(field_is_required);
				return false;
			}
			if($max_rate.val()==''){
				$max_rate.addClass('error').focus();
				alertify.error(field_is_required);
				return false;
			}
			var adata = {
				'title'		: $title.val(),
				'min_rate' 	: $min_rate.val(),
				'max_rate' 	: $max_rate.val(),
				'hotel_price_range_id' : $_this.attr('hotel_price_range_id'),
				'tp' : 'S'
			};
			vietiso_loading(1);
			$.ajax({
				type:'POST',
				url : path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmHotelPriceRange',
				data:adata,
				dataType:'html',
				success:function(html){
					vietiso_loading(0);
					if(html.indexOf('_INSUCCESS') >= 0){
						loadTablePriceRange('',1,10);
						alertify.success(insert_success);
						$_form.find('.close_pop').trigger('click');
					}
					if(html.indexOf('_UPSUCCESS') >= 0){
						var $keyword = $('#keyword').val();
						var $page = $('.paginate_current_page').val();
						var $number_per_page = $('.paginate_length').val();
						loadTablePriceRange($keyword,$page,$number_per_page);
						alertify.success(update_success);
						$_form.find('.close_pop').trigger('click');
					}
					if(html.indexOf('_ERROR') >= 0){
						alertify.error(insert_error);
					}
					if(html.indexOf('_EXIST') >= 0){
						alertify.error(exist_error);
					}
				}
			});
		});
		$(document).on('click', '.ajDeletePriceRange', function(ev) {
			var $_this = $(this);
			if(confirm(confirm_delete)){
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmHotelPriceRange',
					data : {'hotel_price_range_id' : $_this.attr('data'),'tp' : 'D'},
					dataType:'html',
					success:function(html){
						var $keyword = $('#keyword').val();
						var $page = $('.paginate_current_page').val();
						var $number_per_page = $('.paginate_length').val();
						loadTablePriceRange($keyword,$page,$number_per_page);
						vietiso_loading(0);
					}
				});
			}
			return false;
		});
		$(document).on('click', '.ajMovePriceRange', function(ev) {
			var _this = $(this);
			var adata = {
				'hotel_price_range_id' : _this.attr('data'),
				'direct' : _this.attr('direct'),
				'tp' : 'M'
			};
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/?mod="+mod+"&act=ajSiteFrmHotelPriceRange",
				data: adata,
				dataType: "html",
				success: function(html){
					var $keyword = $('#keyword').val();
					var $page = $('.paginate_current_page').val();
					var $number_per_page = $('.paginate_length').val();
					loadTablePriceRange($keyword,$page,$number_per_page);
					vietiso_loading(0);
				}
			});
			return false;
		});
		$(document).on('change', '.paginate_length', function(ev) {
			var $_this = $(this);
			var $keyword = $('#keyword').val();
			var $page = 1;
			var $number_per_page = $_this.val();
			loadTablePriceRange($keyword,$page,$number_per_page);
		});
		$(document).on('click', '.paginate_button', function(ev) {
			var $_this = $(this);
			if(!$_this.hasClass('disabled')){
				var $keyword = $('#keyword').val();
				var $page = $_this.attr('page');
				var $number_per_page = $('.paginate_length').val();
				loadTablePriceRange($keyword,$page,$number_per_page);
			}
			return false;
		});
	}
});
function loadHotelFacibility($forid) {
    var $_container = $('#fT');
    $_container.html('<div>'+loading+'</div>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=hotelpro&act=ajaxLoadHotelFacibility',
        data: {"hotel_id": $forid},
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            $_container.html(html);
        }
    });
}
function getLocationZ() {
    var country = $('select[name=iso-country_id]').find('option:selected').attr('title');
    var city = $('select[name=iso-city_id]').val();
}
function loadArea($continent_id, $area_id) {
    $('#slb_Area').html('<option value="0">'+loading+'</option>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=hotelpro&act=loadArea',
        data: {
			"continent_id": $continent_id,
			'area_id': $area_id
		},
        dataType: "html",
        success: function(html) {
            $('#slb_Area').html(html);
        }
    });
}
function loadCountry($continent_id, $country_id) {
    $('#slb_Country').html('<option value="0">'+loading+'</option>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=hotelpro&act=loadCountry',
        data: {
			"country_id": $country_id,
			'continent_id': $continent_id
		},
        dataType: "html",
        success: function(html) {
            $('#slb_Country').html(html);
        }
    });
}
function loadRegion($country_id, $region_id) {
    $('#slb_Region').html('<option value="0">'+loading+'</option>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=hotelpro&act=loadRegion',
        data: {"country_id": $country_id,'region_id': $region_id},
        dataType: "html",
        success: function(html) {
            $('#slb_Region').html(html);
        }
    });
}
function loadCity($country_id, $region_id, $city_id) {
	$('#slb_City').html('<option value="0">'+loading+'</option>');
	if(parseInt($Hotel_Region)>0) {var $region_id = $region_id;} else {var $region_id = 0;}
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=hotelpro&act=loadCity',
        data: {
			"country_id": $country_id,
			"region_id": $region_id,
			'city_id': $city_id
		},
        dataType: "html",
        success: function(html) {
			$('#slb_City').html(html);
        }
    });
}
function checkHotelRoomAvailable() {
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/index.php?mod='+mod+'&act=ajCheckHotelRoomAvailable",
        data: {"hotel_id": pvalTable},
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (parseInt(html) > 0) {
                $('#addHotelPriceCol').show();
            } else {
                $('#addHotelPriceCol').hide();
            }
        }
    });
}
function loadHotelPrice() {
    var adata = {'hotel_id': pvalTable};
    $.ajax({
        type: 'POST',
        url: path_ajax_script + '/index.php?mod='+mod+'&act=ajaxLoadHotelPrice',
        data: adata,
        dataType: 'html',
        success: function(html) {
            vietiso_loading(0);
            $('#hotelPriceTable').html(html);
            checkHotelRoomAvailable();
        }
    });
}
function loadHotelRoom() {
    var adata = {'hotel_id': pvalTable};
    $.ajax({
        type: 'POST',
        url: path_ajax_script + '/index.php?mod='+mod+'&act=ajaxLoadHotelRoom',
        data: adata,
        dataType: 'html',
        success: function(html) {
            $('#hotelRoomTable').html(html);
        }
    });
}
function loadTableHotelProperty($type, $fromid, $forid) {
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/index.php?mod='+mod+'&act=ajLoadTableHotelProperty',
        data: {'type': $type,'fromid': $fromid,'forid': $forid},
        dataType: "html",
        success: function(html) {
            $('#tblHolderPropertyPop').html(html);
        }
    });
}
function loadListCheckBoxPropertyType(type) {
    var adata = { 'type': type };
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/index.php?mod=property&act=ajLoadListCheckBoxPropertyType',
        data: adata,
        dataType: "html",
        success: function(html) {
            $('#room_facility').html(html);
        }
    });
}
function loadSelectBoxRoomFacility($type, $hotel_room_id) {
    return 0;
}
function loadSelectBoxHotelRating($type, $forid) {
    var adata = { 'type': $type,'forid': $forid };
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/index.php?mod='+mod+'&act=ajSelectBoxHotelRating',
        data: adata,
        dataType: "html",
        success: function(html) {
            $('#slb_HotelRating').html(html);
        }
    });
}
function loadCustomField($hotel_id){
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/index.php?mod='+mod+'&act=SiteHotelCustomField',
		data: {'hotel_id': $hotel_id, 'tp' : 'L'},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			if(html != ''){
				$('.SiteCustomFieldContaciner').html(html);
				$('.Site_Custom_Field_Editor').each(function(){
					var $editorID = $(this).attr('id');
					$('#'+$editorID).isoTextAreaFull();
				});
			}
		}
	});
}

// Hotel Photos Gallery
function initSysGalleryHotel(){
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajaxInitPhotosGallery',
		data: {'table_id':pvalTable},
		dataType: "html",
		success: function(html){
			$('#HotelGalleryHolder').html(html);
			loadTableGallery(pvalTable,'',1,10);
		}
	});
}
function loadTableGallery(table_id, keyword, $page, $number_per_page){
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajSysPhotosGallery',
		data: {'table_id':table_id,'keyword': keyword,'page': $page,'number_per_page': $number_per_page,'tp':'L'},
		dataType: "html",
		success: function(html){
			var $htm = html.split('$$$');
			$('#preview').html(html);
			$('#gallery_paginate').html($htm[1]);
		}
	});
}

// Hotel Price Range
function loadTablePriceRange($keyword,$page, $number_per_page){
	var adata = {
		'keyword' : $keyword,
		'page'	: $page,
		'number_per_page' : $number_per_page,
		'tp' : 'L'
	};
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajSiteFrmHotelPriceRange",
		data: adata,
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			var htm = html.split('$$');
			$('#tblHolderPriceRange').html(htm[0]);
			$('#dataTable_paginate').html(htm[1]);
		}
	});
}