// JavaScript Document
$(function(){
	$(document).on('click', '.btnCreateService', function(){
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajaxFrmService',
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
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajaxFrmService',
			data : {'tourservice_id' : $_this.attr('data')},
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
	$(document).on('click', '.btnSaveService', function(){
		var $_this = $(this);
		var $title = $('input[name=title]');
		var $price = $('input[name=price]');
		var $editorID = $('.textarea_intro_editor').attr('id');
		var $intro = tinyMCE.get($editorID).getContent();
		var $image = $('#isoman_url_image');
		var $tourservice_id = $_this.attr('tourservice_id');
		
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
			'tourservice_id' 	: 	$tourservice_id
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