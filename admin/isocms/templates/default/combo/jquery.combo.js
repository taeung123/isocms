$().ready(function() {
	$(document).on('click', '.createNewCombo', function(ev){
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+'/?mod=combo&act=ajLoadCreateCombo',
			dataType: "html",
			success: function(html){
				vietiso_loading(0);
				makepopupnotresize('500px','auto',html,'CreateCombo');
			}
		});
		return false;
	});
	$(document).on('click', '.clickToAddNewCombo', function(ev){
		if($("#NewComboTitle").val()==''){
			$("#NewComboTitle").focus();
			alertify.error("Vui lòng nhập tên Combo!");
			return false;
		}
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+'/?mod=combo&act=ajCreateNewCombo',
			data: {"title":$("#NewComboTitle").val()},
			dataType: "html",
			success: function(html){
				if(html.indexOf('_ERROR') >= 0) {
					alertify.error("Khách sạn này đã tồn tại. Vui lòng nhập tên Combo khác và thử lại!");
					vietiso_loading(0);
				} else {
					location.href = html;
				}
			}
		});
		return false;
	});
	$_document.on('click','.toggle_opt .online_tour',function(){
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/?mod=' + mod + '&act=ajCheckPublicCombo',
			data: {'is_online':$(this).data('val'),'table_id':table_id},
			dataType: "json",
			success: function (json) {
				if (json['result'] == '_SUCCESS') {
					alertify.success(update_success);
					 window.location.reload(true);
				}
				if (json['result'] == '_ERR') {
					alertify.error(exist_error);
				}
			}
		});
	})
	$(document).on('click', '.delete_combo', function(ev){
		if(confirm(confirm_delete)){
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajDeleteCombo',
				data: {'combo_id': $_this.data('combo_id')},
				dataType: "html",
				success: function(html){
					location.href = html;
				}
			});
		}
	});

	$_document.on('keyup','.input-title',function(){
		var $_this = $(this),
			table_id = $_this.data('table_id'),
			_title = $_this.val();
		$('.table-title[table_id='+table_id+']').html(_title);
		return false;
	});
	$_document.on('keyup','.input_code',function(){
		var $_this = $(this),
			table_id = $_this.data('table_id'),
			_trip_code = $_this.val();
		$('.table_code[table_id='+table_id+']').html(_trip_code);
		return false;
	});
	$_document.on('click', '.panel-edited > .panel-heading', function(e){
		e.preventDefault();
		$('.panel-edited > .panel-heading').removeClass('current');
		$('.panel-edited > .panel-collapse').removeClass('in');
		$(this).toggleClass('current');
		var panel = $(this).closest('.panel');
		panel.find('.panel-collapse').addClass('in');
		panel.find('.panel-collapse>.panel-body>ul.stepbar-list>li:first-child>.loadYieldStep').trigger('click');
	});
	$_document.on('click', '.loadYieldStep', function(){
		var $_this = $(this),
			href = $_this.data('route'),
			table_id = $_this.data('table_id'),
			currentstep = $_this.data('step');
		
		$('.stepbar-list>li>a.active').removeClass('active');
		$_this.addClass('active');
		loadMainFormStep(table_id, currentstep);
		$('html,body').animate({scrollTop:0}, 500);
		window.history.pushState({href: href}, '', href);
		return false;
	});
	$_document.on('click','.js_save_continue,.js_save_back',function(){
		var $_this = $(this),
			$_form = $_this.closest('form'),
			table_id = $_this.data('table_id'),
			currentstep = $_this.data('currentstep'),
			nextstep = $_this.data('next_step');
		
		if($_this.hasClass('js_save_back')){
			nextstep= $_this.data('prevstep');
		}
		var options = {};
		if($('.textarea_intro_editor[table_id='+table_id+']').length){
			$('.textarea_intro_editor[table_id='+table_id+']').each(function(){
				var column = $(this).data('column'),
					editorId = $(this).attr('id');
				options[column] = $Core.util.getTextAreaContent(editorId);
			});
		}
		$('.stepbar-list>li>a.active').removeClass('active');
		$('.loadYieldStep[data-step='+nextstep+']').addClass('active');
		var currentpanel = $_this.data('panel'),
			nextpanel = $('.stepbar-list>li>a.active').attr('panel'),
			$_href = $('.stepbar-list>li>a.active').data('route');
		if(currentpanel != nextpanel){
			$('.panel--'+currentpanel).find('.panel-heading a').addClass('collapsed');
			$('.panel--'+currentpanel).find('.panel-collapse').removeClass('in');
			$('.panel--'+nextpanel).find('.panel-heading a').removeClass('collapsed');
			$('.panel--'+nextpanel).find('.panel-collapse').addClass('in');
		}

		if(currentstep=='itinerary_'){
			loadMainFormStep(table_id,nextstep);
			var $_bdata = {"table_id":table_id, "currentstep":currentstep};
			$.post(path_ajax_script+'/index.php?mod='+mod+'&act=check_step', $_bdata, function(html){
				if(html == 1){
					$('.loadYieldStep[step='+currentstep+']').addClass('success');
				}else{
					$('.loadYieldStep[step='+currentstep+']').removeClass('success');
				}	
			});
		}else{
			var _validated = 0;
			if(currentstep == 'duration'){
				var number_day = $('input[name=number_day]').val(),
					number_night = $('input[name=number_night]').val();
				if($Core.util.isEmpty(number_day)) number_day = 0;
				if($Core.util.isEmpty(number_night)) number_night = 0;
				number_day = parseInt(number_day);
				number_night = parseInt(number_night);
				if(number_day > number_night){
					if(number_day - number_night > 1){
						$Core.alert.alert(__['Message'], "Số ngày không hợp lệ");
						return false;
					}
				} else if(number_day < number_night){
					if(number_night - number_day > 1){
						$Core.alert.alert(__['Message'], "Số đêm không hợp lệ");
						return false;
					}
				}
			} else if(currentstep == 'name'){
				if($('input.required,select.required', $_form).length){
					$('input.required,select.required', $_form).each(function(){
						if($Core.util.isEmpty($(this).val())){
							_validated++;
							$(this).focus();
							return false;
						}
					});
				}
				/***/
				var table_code = $('input[name=table_code]').val();
				$.ajax({
					type : "POST",
					async : false,
					data: {'table_code':table_code, 'table_id':table_id},
					url : path_ajax_script+'/index.php?mod='+mod+'&act=check_table_code',
					success : function(html) {
						if(html.indexOf('_invalid') >= 0){
							_validated = 1;
							$('input[name=table_code]').focus();
							$Core.alert.alert(__['Message'], 'Mã code này đã tồn tại');
						}
					}
				});
			} else if(currentstep == 'age'){
				
			}
			if(parseInt(_validated) == 0){
				$Core.util.toggleIndicatior(0);
				$_form.ajaxSubmit({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSaveMainStep', 
					data:$.extend(options,{"table_id":table_id,'currentstep':currentstep}),
					dataType:'html',
					success:function(html){
						$Core.util.toggleIndicatior(0);
						if(nextstep !=='_last' && nextstep !=='_first'){
							loadMainFormStep(table_id, nextstep);
						} else if(nextstep == '_last'){
							loadMainFormStep(table_id, 'name');
						}
					}
				});
				window.history.pushState({href: $_href}, '', $_href);
				return false;
			}
		}
	});
	if(mod == 'combo' && act == 'insert') {
		
    }
});

function loadMainFormStep(table_id,currentstep){
	$Core.util.toggleIndicatior(1);
	var $_adata = {"table_id":table_id,'currentstep':currentstep};
	$.post(path_ajax_script+'/index.php?mod='+mod+'&act=getMainFormStep', $_adata, function(html){
		$Core.util.toggleIndicatior(0);
			$('#'+'frmMainStep_'+table_id).html(html);
			if(currentstep==='room'){
				loadComboRoom();
			} else if(currentstep==='destination'){
				load_list_destinations(table_id);
			} else if(currentstep==='service'){
				load_list_services(table_id);
			} else if(currentstep==='combo-facibility'){
				loadComboFacibility(pvalTable);

			} else if(currentstep == 'combo_price'){
				loadComboPrice();
			} else if(currentstep == 'price-table'){
				load_price_table(table_id, {});
			} else if(currentstep == 'duration'){
				$('[data-trigger="spinner"]').spinner('changed',function(e, newVal, oldVal){
					var number_day = $('input[name=number_day]').val() || 0,
						number_night = $('input[name=number_night]').val() || 0;
					if(number_day > number_night){
						if(number_day - number_night > 1){
							$('input[name=number_night]').val(number_day - 1);
						}
					} else if(number_day < number_night){
						if(number_night - number_day > 1){
							$('input[name=number_day]').val(number_night - 1);
						}
					}
				});
			} else if(currentstep == 'lhdl'){
				var $el = $('[name=departure_point_id][table_id='+table_id+']');
				$el.select2({
					allowClear: true,
					//minimumInputLength: 2,
					minimumResultsForSearch: 10,
					ajax: {
						delay: 250,
						type: "POST",
						url: path_ajax_script + "/index.php?mod="+mod+"&act=ajLoadListDeparturePoint",
						dataType: 'json',
						data: function (param) {
							return {term: param.term};
						}, processResults: function (data) {
							return {
								results: $.map(data, function (item) {
									return {
										id: item.city_id,
										text: item.name
									}
								})
							};
						}
					},
					escapeMarkup: function (markup) {
						return markup;
					},
					/*templateResult: formatCountry,*/
					templateSelection: function (data, container) {
						$(data.element).attr({
							'data-city_id': data.city_id,
							'data-name': data.name
						});
						return data.text;
					}
				}).on("select2:select", function (e) {
				   /* var city_id = $(this).val(),
						city_code = $(this).find(':selected').data('city_code');
					$('.InputPotentialField_phone_' + p_id).val(city_code).focus();
					var InputPotentialField_phone = $('.InputPotentialField_phone_' + p_id),
						strLength = InputPotentialField_phone.val().length;
					InputPotentialField_phone[0].setSelectionRange(strLength, strLength);*/
				}).on("select2:unselect", function (e) {
				   /* $(this).closest('.inline-editor-container').find('.flag-icon').hide();*/
				});
			}
	});
}
function setSelectBoxDestinationCombo() {
	loadCountryCombo();
	$('#slb_RegionID').hide();
	$('#slb_CityID').hide();
}

function loadCountryCombo($continent_id, $country_id) {
    $('#slb_CountryID').html('<option value="0">' + loading + '</option>')
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=loadCountryCombo",
        data: {
            "continent_id": continent_id,
            "country_id": $country_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_CountryID').hide();
            } else {
                $('#slb_CountryID').html(html).show();
            }
            /**/
            $('#slb_RegionID').hide();
            $('#slb_CityID').hide();
        }
    });
}

function loadRegionCombo($country_id, $region_id) {
    $('#slb_RegionID').html('<option value="0">' + loading + '</option>')
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=loadRegionCombo",
        data: {
            "country_id": $country_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_RegionID').hide();
				loadCityCombo($country_id);
            } else {
                $('#slb_RegionID').html(html).show();
            }
        }
    });
}

function loadCityCombo($country_id, $region_id, $city_id, $table_id) {
    $('#slb_CityID').html('<option value="0">' + loading + '</option>');
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=loadCityCombo",
        data: {
            "country_id": $country_id,
            "region_id": $region_id,
            'city_id': $city_id,
            'table_id': $table_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_CityID').hide();
            } else {
				 $('#slb_CityID').html(html).show();
            }
        }
    });
}

function loadListDestination($table_id) {
    vietiso_loading(1);
    $.ajax({

        type: "POST",
        url: path_ajax_script + '/?mod=' + mod + '&act=ajaxLoadComboDestination',
        data: {
            "table_id": $table_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            $('#lstDestination').html(html);
			loadListDestination2($table_id);
        }
    });
}
function loadListDestination2($table_id) {
    vietiso_loading(1);
    $.ajax({

        type: "POST",
        url: path_ajax_script + '/?mod=' + mod + '&act=ajaxLoadComboDestination2',
        data: {
            "table_id": $table_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            $('#lstDestination2').html(html);
        }
    });
}
function loadListHotelCombo($table_id) {
    vietiso_loading(1);
    $.ajax({

        type: "POST",
        url: path_ajax_script + '/?mod=' + mod + '&act=ajaxLoadHotelCombo',
        data: {
            "table_id": $table_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            $('#tblComboHotel').html(html);
        }
    });
}
function search_combo(check) {
	aj_search = setTimeout(function() {
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajGetSearch',
			data: {
				"keyword": $("#searchkey").val(),
				"table_id": table_id,
				"check": check,
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
function loadComboExtension(table_id) {
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajLoadComboExtension',
		data: {
			"table_id": table_id
		},
		dataType: 'html',
		success: function(html) {
			$('#tblComboExtension').html(html);
		}
	});
}
function loadComboPriceTable($table_id) {
    vietiso_loading(1);
    $.ajax({

        type: "POST",
        url: path_ajax_script + '/?mod=' + mod + '&act=ajaxLoadComboPriceTable',
        data: {
            "table_id": $table_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            $('#combo_price_table').html(html);
        }
    });
}