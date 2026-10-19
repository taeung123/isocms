// JavaScript Document
$(function(){
	$(document).on('click', '.btnCreateService', function(){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteAddOnService',
			data : {'addonservice_id' : $_this.attr('data'), 'tp' : 'F'},
			dataType:'html',
			success:function(html){
				makepopupnotresize('52%', 'auto', html, 'pop_FrmService');
				$('#pop_FrmService').css('top','50px');
				$('#'+$('.textarea_intro_editor').attr('id')).isoTextAreaFull();
				$(".formatprice").priceFormat({thousandsSeparator: '.',centsLimit: 0});
				vietiso_loading(0);
			}
		});
		return false;
	});
	$(document).on('click', '.btn_edit_service', function(){
		var $_this = $(this);
		/**/
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteAddOnService',
			data : {'addonservice_id' : $_this.attr('data'), 'tp' : 'F'},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('52%', 'auto', html, 'pop_FrmService');
				$('#pop_FrmService').css('top','50px');
				$('#'+$('.textarea_intro_editor').attr('id')).isoTextAreaFull();
				$(".formatprice").priceFormat({thousandsSeparator: '.',centsLimit: 0});
			}
		});
		return false;
	});
	$(document).on('click', '.submitAddOnService', function(ev){
		var $_this = $(this);
		var $_form = $_this.closest('.frmPop');
		var $title = $_form.find('input[name=title]');
		var $price = $_form.find('input[name=price]');
		var $extra = $_form.find('select[name=extra]');
		var $intro = tinyMCE.get($('.textarea_intro_editor').attr('id')).getContent();
		var $image = $_form.find('#isoman_url_image');
		
		if($.trim($title.val())==''){
			$title.focus().addClass('error');
			alertify.error(field_is_required);
			return false;
		}
		if($.trim($price.val())==''){
			$price.focus().addClass('error');
			alertify.error(field_is_required);
			return false;
		}
		/**/
		var adata = {
			'title' 			: 	$title.val(),
			'price' 			: 	$price.val(),
			'extra' 			: 	$extra.val(),
			'intro'	  			: 	$intro,
			'image'	  			: 	$image.val(),
			'addonservice_id' : 	$_this.attr('addonservice_id'),
			'tp' 				: 	'S'
		};
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteAddOnService',
			data:adata,
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				if(html.indexOf('_INSERT_SUCCESS') >= 0) {
					alertify.success(insert_success);
					$_this.closest('.frmPop').find('.close_pop').trigger('click');
					window.location.reload();
				}
				if(html.indexOf('_UPDATE_SUCCESS') >= 0) {
					alertify.success(update_success);
					$_this.closest('.frmPop').find('.close_pop').trigger('click');
					window.location.reload();
				}
				if(html.indexOf('_ERROR') >= 0) {
					alertify.error(error);
				}
				if(html.indexOf('_EXIST') >= 0) {
					alertify.error(exist_error);
				}
			}
		});
	});
	$(document).on('click', '.btnSaveService', function(){
		var $_this = $(this);
		var $title = $('input[name=title]');
		var $price = $('input[name=price]');
		var $editorID = $('.textarea_intro_editor').attr('id');
		var $intro = tinyMCE.get($editorID).getContent();
		var $image = $('#isoman_url_image');
		var $addonservice_id = $_this.attr('addonservice_id');
		
		if($($title).val()==''){
			$title.focus();
			alertify.error(field_is_required);
			return false;
		}
		if($($price).val()==''){
			$price.focus();
			alertify.error(field_is_required);
			return false;
		}
		var adata = {
			'title' 		: 	$title.val(),
			'price' 		: 	$price.val(),
			'intro'	  		: 	$intro,
			'image'	  		: 	$image.val(),
			'addonservice_id' 	: 	$addonservice_id
		};
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajaxSaveService',
			data:adata,
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				if(html.indexOf('_SUCCESS') >= 0){
					window.location.reload(true);
				}
				if(html.indexOf('_ERROR') >= 0){
					alertify.error(insert_error);
				}
				if(html.indexOf('_EXIST') >= 0){
					alertify.error(insert_error_exist);
				}
			}
		});
	});
	$(document).on('click', '.btn-delete-all', function(ev){ 
		var $_this = $(this);
		var $listID = getCheckBoxValueByClass('chkitem');
		var $clsTable = $_this.attr('clsTable');
		if($listID==''){   
			alertify.error(confirm_delete);  
			return false;
		}
		else{   
			if(confirm(confirm_delete)){    
				vietiso_loading(1);
				$.ajax({     
					type: "POST",
					url: path_ajax_script+'/?mod='+mod+'&act=ajDeleteMultiItem',
					data: {
						"listID":$listID.join('|'),
						"clsTable":$clsTable
					},
					dataType: "html",
					success: function(html){
						window.location.reload();
					}    
				});
			}
			return false;  
		}  
		return false; 
	});

});