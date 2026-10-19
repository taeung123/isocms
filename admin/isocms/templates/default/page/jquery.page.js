$().ready(function(){
	$(document).on('click', '.btnCreateNewWhy', function(ev){
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSitePageWhy',
			data: {"tp" : 'F'},	
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('45%', 'auto', html, 'pop_OpenWhy');
				var $editorID = $('.textarea_intro_editor').attr('id');
				if($editorID != undefined){$('#'+$editorID).isoTextAreaSimple();}
				$('#pop_OpenWhy').css('top',100);
			}
		});
		return false;
	});
	$(document).on('click', '.btnEditWhy', function(ev){
		var $_this = $(this);
		var $why_id = $_this.attr('data');
		/**/
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSitePageWhy',
			data : {'why_id' : $why_id,'tp' : 'F'},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('45%', 'auto', html, 'pop_OpenWhy');
				var $editorID = $('.textarea_intro_editor').attr('id');
				if($editorID != undefined){$('#'+$editorID).isoTextAreaSimple();}
				$('#pop_OpenWhy').css('top',100);
			}
		});
		return false;
	});
	$(document).on('click', '.ClickSubmitWhy', function(ev){
		var $_this = $(this);
		var $_form = $_this.closest('.frmPop');
		var $title = $_form.find('input[name=title]');
		var $editorID = $('.textarea_intro_editor').attr('id');
		var $intro = '';
		if($editorID != undefined){
			var $intro = tinyMCE.get($editorID).getContent();
		}
		var $imageID = $('#isoman_url_image');
		var $image = '';
		if($imageID != undefined){
			$image = $imageID.val();
		}
		if($title.val()==''){
			$title.addClass('error').focus();
			alertify.error(field_is_required);
			return false;
		}
		var adata = {
			'title' 		: 	$title.val(),
			'intro'	  		: 	$intro,
			'image'	  		: 	$image,
			'why_id' 		: 	$_this.attr('why_id'),
			'tp'	 		: 	'S'
		};
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSitePageWhy',
			data:adata,
			dataType:'html',
			success:function(html){
				console.log(html);
				if(html.indexOf('_SUCCESS') >= 0){
					window.location.reload(true);
				}
				if(html.indexOf('_ERROR') >= 0){
					alertify.error(insert_error);
				}
				if(html.indexOf('_EXIST') >= 0){
					alertify.error(exist_error);
				}
				vietiso_loading(0);
			}
		});
		return false;
	});
});