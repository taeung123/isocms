$().ready(function(){
    $(document).on('click', '.add_new_voucher:not(".disable")', function (ev) {
        $(this).addClass('disable');
		//console.log('Adding new voucher');
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajActionNewVoucher',
			data: {
				'tp': 'S',
				'type': 0
			},
			dataType: "json",
			success: function(json) {
				//console.log('aa',json);
				
				if(json.result == 'success'){
					window.location.href = json.link;
				}
			}
		});
	});
	if(mod == 'voucher' && act== 'edit') {
		load_list_images({'voucher_id':pvalTable});
		loadListDestination(voucher_id);
		setSelectBoxDestination();
		$(document).on('change', '#slb_Chauluc', function(ev){
			var $_this=$(this);
			if(parseInt($_this.val()) > 0){
				loadCountry($_this.val());
			}else{
				$('select[name=country_id]').html('<option value="0">'+country+'/option>').hide();	
				$('select[name=region_id]').html('<option value="0">'+regions+'</option>').hide();
				$('select[name=city_id]').html('<option value="0">'+cities+'</option>').hide();
			}
		});
		$(document).on('change', '#slb_Country', function(ev){
			var $_this=$(this);
			if(parseInt($_this.val()) > 0){
				if($SiteActive_region == '1') {loadRegion($_this.val());$('#slb_CityID').hide();} else {loadCity($_this.val());}
			}else{
				$('#slb_RegionID').hide();
				$('#slb_CityID').hide();
			}
		});
		$(document).on('change', '#slb_RegionID', function(ev){
			var $_this=$(this);
			if($SiteModActive_country == '1') {
				var $country_id = $('#slb_Country').val();
				if($country_id==undefined){$country_id = $('#Hid_Country').val();}
				loadCity($country_id, $_this.val());
			} else {
				loadCity(0, $_this.val());
			}
		});
		// Destination
		$(document).on('click', '.ajQuickAddDestination', function(ev){
			var $_this = $(this);
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
			adata['voucher_id'] = $voucher_id;
			console.log($voucher_id);

			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+'/?mod='+mod+'&act=ajaxAddMoreVoucherDestination',
				data: adata,
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					if(html.indexOf('_SUCCESS')>=0){
						setSelectBoxDestination();
						loadListDestination($voucher_id);
					}
					if(html.indexOf('_EXIST')>=0){
						alertify.error(exist_error);
					}
				}
			});
			return 0;
		});
		$(document).on('click', '.removeDestination', function(ev){
			var $_this = $(this);
			if(confirm(confirm_delete)){
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+'/?mod='+mod+'&act=ajaxDeleteVoucherDestination',
					data:{"voucher_destination_id" : $_this.attr('data')},
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
						loadListDestination($voucher_id);
					}
				});
				return false;
			}
		});
		$(document).on('click', '.ajRemoveAllDestinationInTour', function(ev){
			var $_this = $(this);
			if(confirm(confirm_delete)){
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+'/?mod='+mod+'&act=ajaxDeleteAllVoucherDestination',
					data:{"voucher_id" : voucher_id},
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
						loadListDestination(voucher_id);
					}
				});
				return false;
			}
		});
	}	
	$(document).on('click', '.btn_search_stocklogs', function(){
		var stock_id = $(this).attr('stock_id');
		load_list_stock_logs(stock_id, {},0);
		return false;
	});
	
	$(document).on('click', '.btnCreateCategoryVoucher', function(ev){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod='+mod+'&act=SiteVoucherCategory',
			data : {'voucher_cat_id':$_this.attr('data'),'tp':'F'},
			dataType: 'html',
			success: function(html) {
				vietiso_loading(0);
				makepopupnotresize('52%', 'auto', html, 'box_AddCategoryVoucher');
				$('#box_AddCategoryVoucher').css('top', '50px');
				var $editorID = $('.textarea_voucher_intro_editor').attr('id');
				$('#'+$editorID).isoTextAreaFix();
			}
		});
		return false;
	});
	$(document).on('click', '.btnEditVoucherCat', function(ev){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod='+mod+'&act=SiteVoucherCategory',
			data: {'voucher_cat_id': $_this.attr('data'),'tp':'F'},
			dataType: 'html',
			success: function(html) {
				vietiso_loading(0);
				makepopupnotresize('52%', 'auto', html, 'box_EditCategoryVoucher');
				$('#box_EditCategoryVoucher').css('top', '50px');
				var $editorID = $('.textarea_voucher_intro_editor').attr('id');
				$('#'+$editorID).isoTextAreaFix();
			}
		});
		return false;
	});
	$(document).on('click', '.btnClickToSubmitCategory', function(ev){
		var $_this = $(this);
		var $_form = $_this.closest('.frmPop');

		var $title = $_form.find('input[name=title]');
		var $editorID = $('.textarea_voucher_intro_editor').attr('id');
		var $intro = tinyMCE.get($editorID).getContent();

		if ($title.val() == '') {
			$title.focus();
			alertify.error(field_is_required);
			return false;
		}
		var adata = {
			'title'			: 	$title.val(),
			'intro'			: 	$intro,
			'voucher_cat_id'	: 	$_this.attr('voucher_cat_id'),
			'tp' 			: 	'S'
		};
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script+'/index.php?mod='+mod+'&act=SiteVoucherCategory',
			data: adata,
			dataType: 'html',
			success: function(html) {
				vietiso_loading(0);
				if(html.indexOf('exist_title') >= 0) {
					alertify.error(exist_title);
					return false;
				}
				if(html.indexOf('_SUCCESS') >= 0) {
					window.location.reload(true);
				}
				if(html.indexOf('_ERROR') >= 0) {
					alertify.error(insert_error);
				}
				if(html.indexOf('_EXIST') >= 0) {
					alertify.error(insert_error_exist);
				}
			}
		});
		return false;
	});
});
function load_list_images(options){
	var $_adata = options || {};
	vietiso_loading(1);
	$.post(path_ajax_script+'/index.php?mod='+mod+'&act=load_images', $_adata, function(response){
		vietiso_loading(0);
		$('.upload-dropzone__wrapper').html(response.html);
		if(parseInt(response.total_record) > 0){
			$('.grid').masonry({
				itemSelector: '.grid-item',
				columnWidth: 130
			});
		}
	},'json');
}
function fileInputChanged(event, _this){
	event.preventDefault();
	var _form = $(_this).closest('form'),
		_total_files = $(_this)[0].files.length;
	if(_total_files > 0){
		vietiso_loading(1);
		_form.ajaxSubmit({
			type:'POST',
			data : {'table_id':pvalTable, 'type':'_PRODUCT'},
			url: path_ajax_script+"/index.php?mod="+mod+"&act=upload_images",
			success: function(html){
				vietiso_loading(0);
				if(html.indexOf('_SUCCESS')>=0){
					_form.resetForm();
					load_list_images({'voucher_id':pvalTable});
				}else if(html.indexOf('_ERROR')>=0){
					alertify.error('Lỗi! Upload dữ liệu.');
					return false;
				}
			}
		});
	}else{
		alert("Bạn chưa chọn file upload !!");
	}
}
function initSysGalleryVoucher() {
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajInitTSysVoucherGallery',
            data: {
                'table_id': voucher_id
            },
            dataType: "html",
            success: function(html) {
                $('#VoucherGalleryHolder').html(html);
                loadTableGallery(voucher_id, '', 1, 10);
            }
        });
    }

    function loadTableGallery(table_id, keyword, $page, $number_per_page) {
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajOpenVoucherGallery',
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
function setSelectBoxDestination(){
	if($("#slb_Chauluc").length > 0){
		$("#slb_Chauluc").val('');
		$("#slb_Chauluc").select2().trigger('change');
	}
	if($SiteModActive_continent == '1') {
		$('#slb_Country').hide();$('#slb_RegionID').hide();$('#slb_CityID').hide();
	} else {
		if($SiteModActive_country == '1') {
			loadCountry();$('#slb_RegionID').hide();$('#slb_CityID').hide();
		} else {
			if($SiteActive_region == '1') {
				loadRegion();$('#slb_CityID').hide();
			} else if($SiteActive_city == '1') {
				loadCity();
			} else {
				$('#slb_CityID').hide();
			}
		}
	}
}
function loadCountry($chauluc_id, $khuvuc_id, $country_id){
	$('#slb_Country').html('<option value="0">'+loading+'</option>')
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajLoadCountry",
		data:{
			"chauluc_id" : $chauluc_id,
			"khuvuc_id" :  $khuvuc_id,
			"country_id" :  $country_id
		},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			if(html.indexOf('EMPTY') >= 0){
				$('#slb_Country').hide();
			}else{
				$('#slb_Country').html(html).show();
			}
			/**/
			$('#slb_RegionID').hide();
			$('#slb_CityID').hide();
		}
	});
}
function loadRegion($country_id, $region_id){
	$('#slb_RegionID').html('<option value="0">'+loading+'</option>')
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajLoadRegion",
		data:{"country_id" : $country_id},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			if(html.indexOf('EMPTY') >= 0){
				$('#slb_RegionID').hide();
				loadCity($country_id);
			}else{
				$('#slb_RegionID').html(html).show();
			}
		}
	});
}
function loadCity($country_id, $region_id, $city_id, $voucher_id){
	$('#slb_CityID').html('<option value="0">'+loading+'</option>');
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajmakeSelectCityGlobal",
		data:{"country_id" : $country_id,"region_id" : $region_id,'city_id': $city_id,'voucher_id': $voucher_id},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			if(html.indexOf('EMPTY') >= 0){
				$('#slb_CityID').hide();
			}else{
                $('#slb_city_Id_Container').show();
				$('#slb_CityID').html(html).show();
			}
		}
	});
}
function loadListDestination(voucherId){
	if(voucherId == 0){
		return false; 	
	} 
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/?mod='+mod+'&act=ajaxLoadVoucherDestination',
		data:{"voucher_id" : voucherId},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			$('#lstDestination').html(html);
		}
	});
}
function open_view_image(_this){
	var image_id = $(_this).attr('image_id'),
		$_adata = {'image_id':image_id};
	
	vietiso_loading(1);
	$.post(path_ajax_script+'/index.php?mod='+mod+'&act=open_view_image', $_adata, function(html){
		vietiso_loading(0);
		makepopup('','auto',html, 'open_view_image_'+image_id);
	});
}
function open_edit_image(_this){
	var image_id = $(_this).attr('image_id'),
		$_adata = {'image_id':image_id};
	
	vietiso_loading(1);
	$.post(path_ajax_script+'/index.php?mod='+mod+'&act=open_edit_image', $_adata, function(html){
		vietiso_loading(0);
		makepopup('','auto',html, 'open_view_image_'+image_id);
	});
}
function open_stock_in(_this){
	var stock_id = $(_this).attr('stock_id'),
		voucher_id = $(_this).attr('voucher_id'),
		$_adata = {'stock_id':stock_id,'voucher_id':voucher_id};
	
	vietiso_loading(1);
	$.post(path_ajax_script+'/index.php?mod='+mod+'&act=open_tock_in', $_adata, function(html){
		vietiso_loading(0);
		makepopup('','auto',html, 'open_tock_in_'+stock_id);
	});
	return false;
}
function save_stock_in(_this){
	var _form = $(_this).closest('form'),
		stock_id = $(_this).attr('stock_id'),
		voucher_id = $(_this).attr('voucher_id'),
		stock_in_id = $(_this).attr('stock_in_id'),
		$_adata = {'stock_id':stock_id,'stock_in_id':stock_in_id,'voucher_id':voucher_id};
	
	var _validated = 0;
	if($('input.required', _form).length){
		$('input.required', _form).each(function(){
			if($(this).val()==''){
				_validated++;
				$(this).focus();
				return false;
			}
		});
	}
	if(_validated==0){
		vietiso_loading(1);
		_form.ajaxSubmit({
			type: 'POST',
			url: path_ajax_script+'/index.php?mod='+mod+'&act=save_tock_in',
			data: $_adata,
			dataType: 'json',
			success: function(response){
				vietiso_loading(0);
				if(response.msg.indexOf('_success') >= 0){
					$('.close_pop').trigger('click');
					$('#total_in_'+response.stock_id+'_'+response.voucher_id).text(response.total_in);
					$('#total_quantily_'+response.stock_id+'_'+response.voucher_id).text(response.total_quantily);
					window.location.reload(true);
				}
			}
		});
	}
	return false;
}
function save_edit_image(_this){
	var _form = $(_this).closest('form'),
		image_id = $(_this).attr('image_id'),
		$_adata = {'image_id':image_id};
	
	var _validated = 0;
	if($('input.required', _form).length){
		$('input.required', _form).each(function(){
			if($(this).val()==''){
				_validated++;
				$(this).focus();
				return false;
			}
		});
	}
	if(_validated==0){
		vietiso_loading(1);
		_form.ajaxSubmit({
			type: 'POST',
			url: path_ajax_script+'/index.php?mod='+mod+'&act=save_edit_image',
			data: $_adata,
			success: function(html){
				vietiso_loading(0);
				$Core.popup.close(_form.closest('.modal'));
			}
		});
	}
	return false;
}
function delete_image(_this){
	var image_id = $(_this).attr('image_id'),
		$_adata = {'image_id':image_id};
	$Core.alert.confirm("Xóa ảnh sản phẩm?", "Bạn có chắc muốn xóa ảnh này và xóa nó từ tất cả phiên bản? Hành động này không thể khôi phục", function(){
		vietiso_loading(0);
		$.post(path_ajax_script+'/index.php?mod='+mod+'&act=delete_image', $_adata, function(html){
			vietiso_loading(0);
			load_list_images({'voucher_id':pvalTable});
		});
	});
}
function setup_voucher_image(_this){
	var image_id = $(_this).attr('image_id'),
		$_adata = {'image_id':image_id, 'voucher_id':pvalTable};
	$Core.alert.confirm("Xác nhận?", "Bạn có chắc muốn chọn ảnh này làm ảnh dại diện cho sản phẩm này", function(){
		vietiso_loading(0);
		$.post(path_ajax_script+'/index.php?mod='+mod+'&act=setup_voucher_image', $_adata, function(html){
			vietiso_loading(0);
			load_list_images({'voucher_id':pvalTable});
		});
	});
}
function setTransfer(_this){
	if($(_this).is(':checked')){
		$('.transfer-section').removeClass('hidden');
	} else {
		$('.transfer-section').addClass('hidden');
	}
}
function setInventory(_this){
	var val = $(_this).val();
	if(val==1){
		$('.stock-quantity-section').removeClass('hidden');
	} else {
		$('.stock-quantity-section').addClass('hidden');
	}
}
function open_stock_logs(_this){
	var stock_id = $(_this).attr('stock_id'),
		$_adata = {'stock_id':stock_id};
	vietiso_loading(1);
	$.post(path_ajax_script+'/index.php?mod='+mod+'&act=open_tock_logs', $_adata, function(html){
		vietiso_loading(0);
		makepopup('768','auto',html, 'open_tock_logs_'+stock_id);
		$('#open_tock_logs_'+stock_id).css({'top':-30,'min-width':768, 'left':0, 'right':0, 'margin':'0 auto'});
		load_list_stock_logs(stock_id, {},0);
	});
	return false;
}
function load_list_stock_logs(stock_id, options, loading=1){
	var $_adata = options || {};
	$_adata['stock_id'] = stock_id;
	if($('.filter_item_stocklogs').length){
		$('.filter_item_stocklogs').each(function(){
			var column = $(this).data('column');
			if(typeof(column) !=='undefined'){
				$_adata[column] = $(this).val();
			}
		});
	}
	vietiso_loading(loading);
	$.ajax({
        type: "POST",
        url: path_ajax_script+'/index.php?mod='+mod+'&act=load_list_stock_logs',
        dataType: "html",
        data: $_adata,
		 success: function(html) {
			var htm = html.split('$$$');
			$('#holder_stocklogs').html(htm[0]);
			if(parseInt(htm[1]) > 0){
				$('#pager_stocklogs').pagination({
					total: parseInt(htm[1]),
					pageSize : htm[2],
					onSelectPage: function(pageNumber,pageSize){
						load_list_stock_logs(stock_id, {'page':pageNumber, 'number_per_page':pageSize},2);
					},
					onRefresh: function(pageNumber,pageSize){
						load_list_stock_logs(stock_id, {'page':pageNumber, 'number_per_page':pageSize},2);
					},
					onChangePageSize: function(pageSize){
						load_list_stock_logs(stock_id, {'page':1,'number_per_page':pageSize},2);
					}
				})
			}
		}
    });
}