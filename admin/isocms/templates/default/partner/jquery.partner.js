$().ready(function(){
	// Page partner - Mod: partner - Act: Category
	if(mod == 'partner' && act== 'category') {
		/* partnerS CATEGORY */
		if($SiteHasCat_Partner==1){
			$(document).on('click', '.btnCreateCategoryPartner', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: 'POST',
					url: path_ajax_script + '/index.php?mod='+mod+'&act=SitePartnerCategory',
					data : {'blogcat_id':$_this.attr('data'),'tp':'F'},
					dataType: 'html',
					success: function(html) {
						vietiso_loading(0);
						makepopupnotresize('52%', 'auto', html, 'box_AddCategoryPartner');
						$('#box_AddCategoryPartner').css('top', '50px');
						var $editorID = $('.textarea_partner_intro_editor').attr('id');
						$('#'+$editorID).isoTextAreaFull();
					}
				});
				return false;
			});
			$(document).on('click', '.btnEditPartnerCat', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: 'POST',
					url: path_ajax_script + '/index.php?mod='+mod+'&act=SitePartnerCategory',
					data: {'partnercat_id': $_this.attr('data'),'tp':'F'},
					dataType: 'html',
					success: function(html) {
						vietiso_loading(0);
						makepopupnotresize('52%', 'auto', html, 'box_EditCategoryPartner');
						$('#box_EditCategoryPartner').css('top', '50px');
						var $editorID = $('.textarea_partner_intro_editor').attr('id');
						$('#'+$editorID).isoTextAreaFull();
					}
				});
				return false;
			});
			$(document).on('click', '.btnClickToSubmitCategory', function(ev){
				var $_this = $(this);
				var $_form = $_this.closest('.frmPop');
				
				var $title = $_form.find('input[name=title]');
				var $editorID = $('.textarea_partner_intro_editor').attr('id');
				var $intro = tinyMCE.get($editorID).getContent();
				
				if ($title.val() == '') {
					$title.focus();
					alertify.error(field_is_required);
					return false;
				}
				var adata = {
					'title'			: 	$title.val(),
					'intro'			: 	$intro,
					'partnercat_id'	: 	$_this.attr('partnercat_id'),
					'tp' 			: 	'S'
				};
				vietiso_loading(1);
				$.ajax({
					type: 'POST',
					url: path_ajax_script+'/index.php?mod='+mod+'&act=SitePartnerCategory',
					data: adata,
					dataType: 'html',
					success: function(html) {
						vietiso_loading(0);
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
		}
	}
});