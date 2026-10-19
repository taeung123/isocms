// JavaScript Document
$(function(){
	$(document).on('click', '.btnCreateService', function(){
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajaxFrmTransport',
			dataType:'html',
			success:function(html){
				makepopupnotresize('52%', 'auto', html, 'pop_FrmTransport');
				$('#pop_FrmTransport').css('top','50px');
				$('#'+$('.textarea_intro_editor').attr('id')).isoTextAreaFull();
				vietiso_loading(0);
			}
		});
		return false;
	});
	$(document).on('click', '.btn_edit_transport', function(){
		var $_this = $(this);
		/**/
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajaxFrmTransport',
			data : {'transport_id' : $_this.attr('data')},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('52%', 'auto', html, 'pop_FrmTransport');
				$('#pop_FrmTransport').css('top','50px');
				$('#'+$('.textarea_intro_editor').attr('id')).isoTextAreaFull();
				$(".formatprice").priceFormat({thousandsSeparator: '.',centsLimit: 0});
			}
		});
		return false;
	});
	$(document).on('click', '.btnSaveTransport', function(){
		var $_this = $(this);
		var $title = $('input[name=title]');
		var $editorID = $('.textarea_intro_editor').attr('id');
		var $image = $('#isoman_url_image');
		var $transport_id = $_this.attr('transport_id');
		
		if($($title).val()==''){
			$title.focus();
			alertify.error(field_is_required);
			return false;
		}		
		var adata = {
			'title' 		: 	$title.val(),
			'image'	  		: 	$image.val(),
			'transport_id' 	: 	$transport_id
		};
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajaxSaveTransport',
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
	$(document).on('click', '.btn_-delete-all____', function(ev){ 
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