$().ready(function() {
    $(document).on('click', '.add_new_partner:not(".disable")', function (ev) {
        $(this).addClass('disable');
		var type = $(this).attr('type');
		var cat_id = $(this).attr('cat_id');
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajActionNewPartner',
			data: {
				'tp': 'S',
				'type':type,
				'cat_id':cat_id
			},
			dataType: "json",
			success: function(json) {
				if(json.result == 'success'){
					window.location.href = json.link;
				}
			}
		});
	});
	$_document.on('click','.toggle_opt .online_tour',function(){
		var $_this = $(this);
		var is_online = $_this.data('val');
		var text_last = $_this.data('text_last');
		var text = $_this.text();
		var adata = {};
		adata['clsTable'] = $_this.data('clstable');
		adata['pkey'] = $_this.data('pkey');
		adata['pvalTable'] = $_this.data('sourse_id');
		adata['toField'] = $_this.attr('toField') != undefined ? $_this.attr('toField') : 'is_online';
		adata['val'] = parseInt(is_online)==0?1:0;
		adata['allowDuplicate'] = 1;
		
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/index.php?mod=home&act=saveField",
			data: adata,
			dataType: "html",
			success: function(html){
				var val = (is_online == 1)?0:1;
				if($_this.hasClass('private_tour')){
					$_this.removeClass('private_tour');
				}else{
					$_this.addClass('private_tour');
				}
				$_this.text(text_last);
				$_this.data({'val':html,'text_last':text});
			}
		});
	})

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
		var _validated = 0;
		if($('input.required,select.required', $_form).length){
			$('input.required,select.required', $_form).each(function(){
				if($Core.util.isEmpty($(this).val())){
					_validated++;
					$(this).focus();
					$(this).addClass('error');
					return false;
				}else{
					$(this).removeClass('error');
				}
			});
		}
		if(parseInt(_validated) == 0){
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
			$Core.util.toggleIndicatior(0);
			$_form.ajaxSubmit({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSaveMainStep', 
				data:$.extend(options,{"table_id":table_id,'currentstep':currentstep}),
				dataType:'html',
				success:function(html){
					$Core.util.toggleIndicatior(0);
                    if(html.indexOf('_EXIST') >= 0) {
                        alertify.error(insert_error_exist);
                        return false;
                    }
					alertify.success(update_success);
					if(nextstep !=='_last' && nextstep !=='_first'){
						loadMainFormStep(table_id, nextstep);
					} else if(nextstep == '_last'){
						loadMainFormStep(table_id, 'partner');

					}
				}
			});
			window.history.pushState({href: $_href}, '', $_href);
			return false;
		}
	});
	if(mod == 'blog' && act == 'insert') {
        
		if($SiteActive_region=='1'){loadRegion(country_id, region_id);}
		
		/* HOTEL_CUSTOM_FIELD */
		$(document).on('click', '.ClickCustomField', function(ev){
			var $_this=$(this);
			vietiso_loading(1);	
			$.ajax({	
				type: "POST",
				url: path_ajax_script+'/?mod='+mod+'&act=SiteBlogCustomField',	
				data: {"table_id" : table_id, 'tp' : 'C'},	
				dataType: "html",	
				success: function(html){
					vietiso_loading(0);
					location.href = REQUEST_URI;
				}	
			});		
			return false;	
		});
		$('.changeToStore').live('change',function(){
			var $_this = $(this);
			$.ajax({
				type: 'POST',
				url: path_ajax_script+'/index.php?mod='+mod+'&act=ajUpdateBlogStore',
				data:{'_type' : $_this.attr('_type'),'table_id': $_this.attr('data'),'val' : $_this.is(':checked')?1:0},
				dataType:'html',
				success: function(html){
				}
			});
		});
		$(document).on('click', '.btndelete_customfield', function(ev){
			if(confirm(confirm_delete)){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteBlogCustomField",
					data: {'blog_customfield_id' : $_this.attr('data'), 'tp' : 'D'},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						location.href = REQUEST_URI;
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
				url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteBlogCustomField",
				data: {'tp': 'F', 'blog_customfield_id' : $_this.attr('data'), 'table_id' : $_this.attr('table_id')},
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
				url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteBlogCustomField",
				data: {
					'tp': 'S',
					'blog_customfield_id' : $_this.attr('blog_customfield_id'),
					'table_id' : $_this.attr('table_id'),
					'fieldname' : $fieldname.val()
				},
				dataType: "html",
				success: function(html){
					if(html.indexOf('_EXIST') >= 0){
						alertify.error('Error !');
					}else{
						$_form.find('.close_pop').trigger('click');
					}
					location.href=REQUEST_URI;
				}
			});
			return false;
		});
		$(document).on('click', '.btnmove_customfield', function(ev){
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteBlogCustomField",
				data: {
					'tp' : 'M',
					'table_id' : $_this.attr('table_id'),
					'direct' : $_this.attr('direct'),
					'blog_customfield_id' : $_this.attr('data')
				},
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
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
			var title = $_this.find('option:selected').attr('title');
			var $country_id = $('select[name=iso-country_id]').val();
			if($country_id=='undefined' || $country_id == undefined){
				$country_id = 0;
			}
			loadCity($country_id, $_this.val(),0);
        });
		$(document).on('change', 'select[name=iso-country_id]', function(ev){
			var $_this = $(this);
			var title = $_this.find('option:selected').attr('title');
			if($SiteActive_region=='1'){
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
		$(document).on('click', '.ajaxManagerBlogProperty', function(ev){
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
				url: path_ajax_script + "/index.php?mod=blog&act=ajGetBoxManagerBlogProperty",
				data: adata,
				dataType: "html",
				success: function(html) {
					vietiso_loading(0);
					makepopup('30%', '', html, 'frmBoxManagerBlogProperty');
				}
			});
			return false;
        });
		$(document).on('click', '#btnCreateNewBlogProperty', function(ev) {
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
				url: path_ajax_script + "/index.php?mod=blog&act=ajGetBoxManagerBlogProperty",
				data: adata,
				dataType: "html",
				success: function(html) {
					vietiso_loading(0);
					makepopup('25%', '', html, 'pop_FrmProperty');
				}
			});
		});
		$(document).on('click', '.edit_pop_blog_property', function(ev) {
			var $_this = $(this);
			if (!$_this.hasClass('disabled')) {
				var adata = {
					'blog_property_id': $_this.attr('data'),
					'fromid': $_this.attr('fromid'),
					'forid': $_this.attr('forid'),
					'tp' : 'F'
				};
				$_this.addClass('disabled');
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script + "/?mod=blog&act=ajGetBoxManagerBlogProperty",
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
		$(document).on('click', '#ajaxSaveBlogProperty', function(ev) {
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
					'blog_property_id': $_this.attr('blog_property_id'),
					'type': $_this.attr('_type'),
					'title': $title.val(),
					'tp' : 'S'
				};
				vietiso_loading(1);
				$_this.addClass('disabled');
				$.ajax({
					type: "POST",
					url: path_ajax_script + "/index.php?mod=blog&act=ajGetBoxManagerBlogProperty",
					data: adata,
					dataType: "html",
					success: function(html) {
						$_this.removeClass('disabled');
						vietiso_loading(0);
						if (html.indexOf('IN_SUCCESS') >= 0) {
							$_form.find('.close_pop').trigger('click');
							alertify.success(insert_success);
							loadTableBlogProperty($_this.attr('_type'), $fromid, $forid);
							if ($fromid == 'pop_BlogRoom') {
								loadSelectBoxRoomFacility($_this.attr('property_id'), $forid);
							}
							if ($fromid == 'BlogFacilities') {
								loadBlogFacibility($forid);
							}
							if ($fromid == 'BlogRating') {
								loadSelectBoxBlogRating($_this.attr('_type'), $forid);
							}
						}
						if (html.indexOf('UP_SUCCESS') >= 0) {
							loadTableBlogProperty($_this.attr('_type'), $fromid, $forid);
							$_form.find('.close_pop').trigger('click');
							alertify.success(update_success);
	
							if ($fromid == 'pop_BlogRoom') {
								loadSelectBoxRoomFacility($_this.attr('property_id'), $forid);
							}
							if ($fromid == 'BlogFacilities') {
								loadBlogFacibility($forid);
							}
							if ($fromid == 'BlogRating') {
								loadSelectBoxBlogRating($_this.attr('_type'), $forid);
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
		$(document).on('click', '.delete_pop_blog_property', function(ev) {
			var $_this = $(this);
			if (!$_this.hasClass('disabled')) {
				var $fromid = $_this.attr('fromid');
				var $forid = $_this.attr('forid');
				/**/
				if (confirm(confirm_delete)) {
					var adata = {'blog_property_id': $_this.attr('data'),'tp' : 'D'};
					vietiso_loading(1);
					$_this.addClass('disabled');
					$.ajax({
						type: "POST",
						url: path_ajax_script + "/?mod=blog&act=ajGetBoxManagerBlogProperty",
						data: adata,
						dataType: "html",
						success: function(html) {
							$_this.removeClass('disabled');
							vietiso_loading(0);
							loadTableBlogProperty($_this.attr('_type'), $_this.attr('fromid'), $_this.attr('forid'));
							if ($fromid == 'pop_BlogRoom') {
								loadSelectBoxRoomFacility($_this.attr('blog_property_id'), $forid);
							}
							if ($fromid == 'BlogFacilities') {
								loadBlogFacibility($forid);
							}
							if ($fromid == 'BlogRating') {
								loadSelectBoxBlogRating($_this.attr('_type'), $forid);
							}
						}
					});
				}
			}
			return false;
		});
		/* END HOTEL_PROPERY_POP */
		
		/* START HOTEL ROOM */
		$(document).on('click', '#clickToAddBlogRoom', function(ev) {
			var $_this = $(this);
			var adata = {};
			adata['table_id'] = table_id;
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxAddBlogRoom',
				dataType: "html",
				data: adata,
				success: function(html){
					makepopup('991px', 'auto', html, 'pop_BlogRoom','frmPop2');
					$('#pop_BlogRoom').css('top', '30px');
					$(".price_format").priceFormat({
						thousandsSeparator: '.',
						centsLimit: 0
					});
					vietiso_loading(0);
				}
			});
			return false;
		});
		$(document).on('click', '.clickEditBlogRoom', function(ev) {
			var $_this = $(this);
			var adata = {
                'blog_room_id': $_this.attr('data'),
                'table_id': $_this.attr('blog_id')
            };
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxAddBlogRoom',
				dataType: "html",
				data: adata,
				success: function(html){
					makepopup('991px', 'auto', html, 'pop_BlogRoom','frmPop2');
					$('#pop_BlogRoom').css('top', '30px');
					$(".price_format").priceFormat({
						thousandsSeparator: '.',
						centsLimit: 0
					});
					vietiso_loading(0);
				}
			});
			return false;
		});
		$(document).on('click', '.clickEditBlogRoom_', function(ev) {
            var $_this = $(this);
            var adata = {
                'blog_room_id': $_this.attr('data'),
                'blog_id': $_this.attr('blog_id')
            };
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajaxAddBlogRoom',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    vietiso_loading(0);
                    makepopupnotresize('60%', 'auto', html, 'pop_BlogRoom');
                    $('#pop_BlogRoom').css('top', 60 + 'px');
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
		$(document).on('click', '.deleteBlogRoomImage', function(ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                var adata = {'blog_room_id': $_this.attr('blog_room_id')};
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=blog&act=ajDeleteBlogRoomImage',
                    data: adata,
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        $("#isoman_show_image_room").attr("src", "");
                        $("#isoman_hidden_image_room").val("");
                        loadBlogRoom();
                    }
                });
            }
            return false;
        });
        $(document).on('click', '#clickSubmitBlogRoom', function(ev) {
            var $_this = $(this);
            if (!$_this.hasClass('disabled')) {
                var $title = $('input[name=blog_room_title]').val();
                var $content = tinyMCE.get($('.textarea_content_editor').attr('id')).getContent();
                var $image = $('#isoman_hidden_image_room').val();
                if ($title == '') {
                    alertify.error(field_is_required);
                    $('input[name=blog_room_title]').addClass('error').focus();
                    return false;
                }
                var adata = {
                    'blog_room_id': $_this.attr('blog_room_id'),
                    'table_id': $_this.attr('table_id'),
                    'intro': $content,
                    'image': $image
                };
                vietiso_loading(1);
                $_this.addClass('disabled');
                $('#frmBlogRoom').ajaxSubmit({
                    type: "POST",
                    url: path_ajax_script + "/index.php?mod=blog&act=ajaxSubmitBlogRoom",
                    data: adata,
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        $_this.removeClass('disabled');
                        if (html.indexOf('_IN_SUCCESS') >= 0) {
                            loadBlogRoom();
                            loadBlogPrice();
                            alertify.success(insert_success);
							$_this.closest('.frmPop').find('.close_pop').trigger('click');
                        }
                        if (html.indexOf('_UPDATE_SUCCESS') >= 0) {
                            loadBlogRoom();
                            loadBlogPrice();
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
		$(document).on('click', '.clickDeleteBlogRoom', function(ev) {
            var $_this = $(this);
            if (confirm(confirm_delete)) {
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=blog&act=ajDeleteBlogRoom',
                    data: {'blog_room_id': $_this.attr('data')},
                    dataType: 'html',
                    success: function(html) {
                        vietiso_loading(0);
                        loadBlogRoom();
                        loadBlogPrice();
                        alertify.success(delete_success);
                    }
                });
            }
            return false;
        });
		
		$('#add_blog_room').live('click',function(ev){
			var _this = $(this);
			if ($('#room_stype_id').val() ==0){
				$('#room_stype_id').focus();
				alertify.error(field_is_required);
				return false;
			}
			if ($('#title_room').val() ==''){
				$('#title_room').focus();
				alertify.error(field_is_required);
				return false;
			}
			if ($('#number_val').val() ==''){
				$('#number_val').focus();
				alertify.error(field_is_required);
				return false;
			}
			if ($('#footage').val() ==''){
				$('#footage').focus();
				alertify.error(field_is_required);
				return false;
			}
			if ($('#price').val() ==''){
				$('#price').focus();
				alertify.error(field_is_required);
				return false;
			}
			var adata = $("#form_add_blog_room").serialize();
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod="+mod+"&act=ajSaveBlogRoom",
				data: adata,
				dataType: "html",
				success: function(html){
					if (html.indexOf('INSERT_ERROR') >= 0) {
						alertify.error(insert_error);
					}else if(html.indexOf('UPDATE_ERROR') >= 0) {
						alertify.error(update_error);
					}else if(html.indexOf('UPDATE_SUCCESS') >= 0) {
						alertify.success(update_success);
						vietiso_loading(0);
						
					}else{
						alertify.success(insert_success);
						vietiso_loading(0);
						
					}
				}
			});
		});
		
		$(document).on('click', '.ajmoveBlogRoom', function(ev) {
			var $_this = $(this);
			var adata = {
				'blog_room_id': $_this.attr('data'),
				'table_id': $_this.attr('table_id'),
				'direct': $_this.attr('direct'),
			};
			vietiso_loading(1);
			$.ajax({
				type: 'POST',
				url: path_ajax_script + "/index.php?mod=blog&act=ajMoveBlogRoom",
				data: adata,
				dataType: 'html',
				success: function(html) {
					vietiso_loading(0);
					loadBlogRoom();
				}
			});
			return false;
		});
		
		// Add Blog Price Col
		$(document).on('click', '#addBlogPriceRow', function(ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajLoadNewBlogPriceRow',
                dataType: 'html',
                data: {'table_id': pvalTable},
                success: function(html) {
                    vietiso_loading(0);
                    makepopup('300', '', html, 'NewBlogPriceRow');
                }
            });
            return false;
        });
		$(document).on('click', '#addBlogPriceCol', function(ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajLoadNewBlogPriceCol',
                dataType: 'html',
                data: {'table_id': pvalTable},
                success: function(html) {
                    vietiso_loading(0);
                    makepopup('300', '', html, 'NewBlogPriceCol');
                }
            });
            return false;
        });
		$(document).on('click', '.editBlogPriceRoom', function(ev) {
            var $_this = $(this);
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajLoadEditBlogPriceRoom',
                dataType: 'html',
                data: {'id': $_this.attr('data')},
                success: function(html) {
					vietiso_loading(0);
                    makepopup('300', '', html, 'EditBlogPriceRow');
                }
            });
            return false;
        });
		$(document).on('click', '.editBlogPriceCol', function(ev) {
            var $_this = $(this);
            var adata = {'table_id': pvalTable};
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajCheckBlogPriceCol',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    if (html == 0) {
                        $('#addBlogPriceCol').trigger('click');
                    } else {
                        vietiso_loading(1);
                        $.ajax({
                            type: 'POST',
                            url: path_ajax_script + '/index.php?mod=blog&act=ajLoadEditBlogPriceCol',
                            dataType: 'html',
                            data: {'id': $_this.attr('data')},
                            success: function(html) {
								vietiso_loading(0);
                                makepopup('300', '', html, 'EditBlogPriceCol');
                            }
                        });
                    }
                }
            });
            return false;
        });
		$(document).on('click', '.editBlogPriceVal', function(ev) {
            var $_this = $(this);
            var adata = {'table_id': pvalTable};
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajCheckBlogPriceCol',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    vietiso_loading(0);
                    if (html == 0) {
                        alertify.error(error);
                        $('#addBlogPriceCol').trigger('click');
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: path_ajax_script + '/index.php?mod=blog&act=ajLoadEditBlogPriceVal',
                            dataType: 'html',
                            data: {
                                'blog_price_col_id': $_this.attr('blog_price_col_id'),
                                'blog_price_row_id': $_this.attr('blog_price_row_id')
                            },
                            success: function(html) {
                                makepopup('20%', '', html, 'EditBlogPriceVal');
                                $("#titleVal").priceFormat({thousandsSeparator: '.', centsLimit: 0});
                            }
                        });
                    }
                }
            });
            return false;
        });
		$(document).on('click', '.ajCopyPriceBlog', function(ev) {
            $('input[name=price_avg]').val();
            return false;
        });
		$(document).on('change', 'input[class=ajvClk]', function(ev) {
            var $_this = $(this);
            var adata = {
                'tp': $_this.attr('tp'),
                'tp_order': $_this.attr('tp_order'),
                'table_id': $_this.attr('data'),
                'val': $_this.is(':checked') ? 1 : 0
            };
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajUpdateBlogVr3',
                data: adata,
                dataType: 'html',
                success: function(html) {
                }
            });
        });
		$(document).on('click', '#clickToAddBlogPriceRow', function(ev) {
            var $_this = $(this);
            if ($('#titleRow').val() == '') {
                $('#titleRow').focus().addClass('error');
                alertify.error(title_required);
                return false;
            }
			vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajAddBlogPriceRow',
                data: {'table_id': $_this.attr('table_id'),'title': $('#titleRow').val()},
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
                        loadBlogPrice();
                        loadBlogRoom();
                        alertify.success(insert_success);
						$_this.closest('.frmPop').find('.close_pop').trigger('click');
                    }
                }
            });
            return false;
        });
		$(document).on('click', '#clickToAddBlogPriceCol', function(ev) {
            var $_this = $(this);
            if ($('#titleCol').val() == '') {
                $('#titleCol').focus().addClass('error');
                alertify.error(field_required);
                return false;
            }
            var adata = {
                'table_id': $_this.attr('table_id'),
                'title': $('#titleCol').val()
            };
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajAddBlogPriceCol',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    if (html.indexOf('_IN_SUCCESS') >= 0) {
						vietiso_loading(0);
                        loadBlogPrice();
						alertify.success(insert_success);
						$_this.closest('.frmPop').find('.close_pop').trigger('click');
                    }
                }
            });
            return false;
        });
		$(document).on('click', '#clickToEditBlogPriceRow', function(ev) {
            var $_this = $(this);
            var adata = {
                'id': $_this.attr('data'),
                'title': $('#titleRow').val()
            };
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajUpdateBlogPriceRow',
                data: adata,
                dataType: 'html',
                success: function(html) {
					vietiso_loading(0);
                    loadBlogPrice();
                    loadBlogRoom();
					$_this.closest('.frmPop').find('.close_pop').trigger('click');
                }
            });
            return false;
        });
		$(document).on('click', '#clickToEditBlogPriceCol', function(ev) {
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
                url: path_ajax_script + '/index.php?mod=blog&act=ajUpdateBlogPriceCol',
                data: adata,
                dataType: 'html',
                success: function(html) {
					vietiso_loading(0);
                    loadBlogPrice();
					$_this.closest('.frmPop').find('.close_pop').trigger('click');
                }
            });
            return false;
        });
		$(document).on('click', '.deleteBlogPriceRoom', function(ev) {
            if(confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=blog&act=ajDeleteBlogPriceRoom',
                    data: {'id': $_this.attr('data')},
                    dataType: 'html',
                    success: function(html) {
						vietiso_loading(0);
                        loadBlogPrice();
                        loadBlogRoom();
                    }
                });
            }
            return false;
        });
		$(document).on('click', '.deleteBlogPriceCol', function(ev) {
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=blog&act=ajDeleteBlogPriceCol',
                    data: {'id': $_this.attr('data')},
                    dataType: 'html',
                    success: function(html) {
						vietiso_loading(0);
                        loadBlogPrice();
                    }
                });
            }
            return false;
        });
		$(document).on('click', '#clickToEditBlogPriceVal', function(ev) {
            var $_this = $(this);
            var adata = {
                'table_id': pvalTable,
                'blog_price_col_id': $_this.attr('blog_price_col_id'),
                'blog_price_row_id': $_this.attr('blog_price_row_id'),
                'price': $('#titleVal').val()
            };
            vietiso_loading(1);
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajUpdateBlogPriceVal',
                data: adata,
                dataType: 'html',
                success: function(html) {
					vietiso_loading(0);
                    loadBlogPrice();
					$_this.closest('.frmPop').find('.close_pop').trigger('click');
                }
            });
            return false;
        });
		$(document).on('click', '.moveBlogPriceRoom', function(ev) {
            var $_this = $(this);
            vietiso_loading(1);
            var adata = {
                'id': $_this.attr('data'),
                'direct': $_this.attr('direct')
            };
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajMoveBlogPriceRow',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    loadBlogPrice();
                    vietiso_loading(0);
                }
            });
            return false;
        });
		$(document).on('click', '.moveBlogPriceCol', function(ev) {
            var $_this = $(this);
            vietiso_loading(1);
            var adata = {
                'id': $_this.attr('data'),
                'direct': $_this.attr('direct')
            };
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=blog&act=ajMoveBlogPriceCol',
                data: adata,
                dataType: 'html',
                success: function(html) {
                    vietiso_loading(0);
                    loadBlogPrice();
                }
            });
            return false;
        });
        
        //LOAD SELECT BOX
        $('select[name=iso-city_id]').change(function() {
            var $_this = $(this);
            var country = $('select[name=iso-country_id]').find('option:selected').attr('title');
            var city = $_this.find('option:selected').attr('title');
            var address = city + ' ,' + country;
        });
    }
});

function loadMainFormStep(table_id,currentstep){
	$Core.util.toggleIndicatior(1);
	var $_adata = {"table_id":table_id,'currentstep':currentstep,'type':$type,'cat_id':$cat_id};
	$.post(path_ajax_script+'/index.php?mod='+mod+'&act=getMainFormStep', $_adata, function(html){
		$Core.util.toggleIndicatior(0);
			$('#'+'frmMainStep_'+table_id).html(html);
	});
}
function parentDropdownToggle(e){
	$(e).parent().toggleClass('open');
}
function checkAll(e){
	var chkitem = $(e).closest('.fill_data_box').find('.chkitem');
	console.log(chkitem);
	if($(e).is(':checked')){
		chkitem.attr('checked', true);
		chkitem.closest('tr').addClass('hightlight');
		setList();
	} else {
		chkitem.removeAttr('checked');
		chkitem.closest('tr').removeClass('hightlight');
		setList();
	}
}

function showDatepicker(e){
	$(e).datepicker({dateFormat: "dd/mm/yy"});
}

function searchRelateTour(e,type) {
	if ($(e).val() != '') {
		clearTimeout(aj_search);
		search_extension(type);
	} else {
		$("#autosuggetTour").stop(false, true).slideUp();
	}
}
function addRelateTour(e) {
	var $_this = $(e);
	vietiso_loading(1);
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajAddTourExtension',
		data: {
			'blog_id': blog_id,
			'tour_id': $_this.attr('data')
		},
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			if (html.indexOf('_SUCCESS') >= 0) {
				$_this.remove();
				loadTourExtension(blog_id);
			}
			if (html.indexOf('_EXIST') >= 0) {
				alertify.error(exist_error);
			}
		}
	});
}

function addRelateHotel(e) {
	var $_this = $(e);
	vietiso_loading(1);
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajAddHotelExtension',
		data: {
			'blog_id': blog_id,
			'hotel_id': $_this.attr('data')
		},
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			if (html.indexOf('_SUCCESS') >= 0) {
				$_this.remove();
				loadHotelExtension(blog_id);
			}
			if (html.indexOf('_EXIST') >= 0) {
				alertify.error(exist_error);
			}
		}
	});
}
function addRelateCruise(e) {
	var $_this = $(e);
	vietiso_loading(1);
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajAddCruiseExtension',
		data: {
			'blog_id': blog_id,
			'cruise_id': $_this.attr('data')
		},
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			if (html.indexOf('_SUCCESS') >= 0) {
				$_this.remove();
				loadCruiseExtension(blog_id);
			}
			if (html.indexOf('_EXIST') >= 0) {
				alertify.error(exist_error);
			}
		}
	});
}

function deleteBlogExtension(e) {
	if (confirm(confirm_delete)) {
		var _this = $(e);
		var tp = _this.attr("tp");
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajDeleteBlogExtension',
			data: {
				"blog_extension_id": _this.attr('data')
			},
			dataType: 'html',
			success: function(html) {
				vietiso_loading(0);
				if(tp=='tour')
					loadTourExtension(blog_id);
				if(tp=='cruise')
					loadCruiseExtension(blog_id);
				if(tp=='hotel')
					loadHotelExtension(blog_id);
			}
		});
		return false;
	}
}

function moveTourExtension(e) {
	console.log(e);
	var _this = $(e);
	vietiso_loading(1);
	var adata = {
		'blog_extension_id': _this.attr('data'),
		'blog_id': blog_id,
		'direct': _this.attr('direct')
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajMoveTourExtension',
		data: adata,
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			loadTourExtension(blog_id);
		}
	});
}
function moveHotelExtension(e) {
	var _this = $(e);
	vietiso_loading(1);
	var adata = {
		'blog_extension_id': _this.attr('data'),
		'blog_id': blog_id,
		'direct': _this.attr('direct')
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajmoveHotelExtension',
		data: adata,
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			loadHotelExtension(blog_id);
		}
	});
}
function moveCruiseExtension(e) {
	var _this = $(e);
	vietiso_loading(1);
	var adata = {
		'blog_extension_id': _this.attr('data'),
		'blog_id': blog_id,
		'direct': _this.attr('direct')
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajmoveCruiseExtension',
		data: adata,
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			loadCruiseExtension(blog_id);
		}
	});
}

function addDestination(e){
	var $_this = $(e);
	if($SiteModActive_continent == '1') {var $chauluc_id = $('#slb_Chauluc').val();}
	if($SiteModActive_country == '1') {
		var $country_id = $('#slb_Country').val();
		if($country_id!=undefined || $country_id==0){
			var $countryID = $('#slb_Country');
			setSelectOpen($countryID);
		}else{
			$country_id = 1;
		}
	}
	if($SiteActive_region == '1') {var $region_id = $('#slb_RegionID').val();}
	if($SiteActive_city == '1') {var $city_id = $('#slb_CityID').val();}

	/**/
	var adata = {};
	adata['chauluc_id'] = $chauluc_id;
	adata['country_id'] = $country_id;
	adata['region_id'] = $region_id;
	adata['city_id'] = $city_id;
	adata['blog_id'] = $blog_id;

	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/?mod='+mod+'&act=ajaxAddMoreBlogDestination',
		data: adata,
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			if(html.indexOf('_SUCCESS')>=0){
				loadListDestination($blog_id);
			}
			if(html.indexOf('_EXIST')>=0){
				alertify.error(exist_error);
			}
		}
	});
	return 0;
}

function removeDestination(e){
	var $_this = $(e);
	if(confirm(confirm_delete)){
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+'/?mod='+mod+'&act=ajaxDeleteBlogDestination',
			data:{"blog_destination_id" : $_this.attr('data')},
			dataType: "html",
			success: function(html){
				vietiso_loading(0);
				var $country_id = $('#slb_Country').val();
				if($country_id==undefined){
					$country_id = $('#Hid_Country').val();
				}
				if($('#slb_CityID').is(':visible')){
					loadCity($country_id, $('#slb_RegionID').val());
				}
				loadListDestination($blog_id);
			}
		});
		return false;
	}
}
function removeAllDestination(e){
	var $_this = $(e);
	if(confirm(confirm_delete)){
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+'/?mod='+mod+'&act=ajaxDeleteAllBlogDestination',
			data:{"blog_id" : blog_id},
			dataType: "html",
			success: function(html){
				vietiso_loading(0);
				var $country_id = $('#slb_Country').val();
				if($country_id==undefined){
					$country_id = $('#Hid_Country').val();
				}
				if($('#slb_CityID').is(':visible')){
					loadCity($country_id, $('#slb_RegionID').val());
				}
				loadListDestination(blog_id);
			}
		});
		return false;
	}
}