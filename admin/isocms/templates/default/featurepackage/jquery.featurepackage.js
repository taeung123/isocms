$().ready(function(){

	// Page Faqs - Mod: Faqs - Act: Category
	if(mod == 'featurepackage' && act== 'cat') {
		/* FAQS CATEGORY */
		if($SiteHasCat_FAQ==1){
			$(document).on('click', '.btnCreateFeaturePackageCat', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteFeaturePackageCat',
					data : {'feature_package_cat_id':$_this.attr('data'),'tp':'F'},
					dataType:'html',
					success:function(html){
						vietiso_loading(0);
						makepopupnotresize('52%', 'auto', html, 'box_CreateFAQCat');
						$('#box_CreateFAQCat').css('top','50px');
						var $editorID = $('.textarea_intro_editor').attr('id');
						$('#'+$editorID).isoTextAreaFix();
					}
				});
				return false;
			});
			$(document).on('click', '.btnEditFeaturePackageCat', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteFeaturePackageCat',
					data : {'feature_package_cat_id':$_this.attr('data'),'tp':'F'},
					dataType:'html',
					success:function(html){
						vietiso_loading(0);
						makepopupnotresize('52%', 'auto', html, 'box_EditFaqsCat');
						$('#box_EditFaqsCat').css('top','50px');
						var $editorID = $('.textarea_intro_editor').attr('id');
						$('#'+$editorID).isoTextAreaFix();
					}
				});
				return false;
			});
			$('.btnSubmitFeaturePackageCat').live('click',function(){
				var $_this = $(this);
				var $_form = $_this.closest('.frmPop');
				var $title = $_form.find('input[name=title]');
				var $editorID = $('.textarea_intro_editor').attr('id');
				var $intro = tinyMCE.get($editorID).getContent();
				var $image = $('#isoman_url_image').val();
				
				if($title.val()==''){
					$title.focus();
					alertify.error(field_is_required);
					return false;
				}
				var adata = {
					'title' 		: 	$title.val(),
					'intro'	  		: 	$intro,
					'image'	  		: 	$image,
					'feature_package_cat_id' 	: 	$_this.attr('feature_package_cat_id'),
					'tp' 			: 	'S'
				};
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteFeaturePackageCat',
					data:adata,
					dataType:'html',
					success:function(html){
						vietiso_loading(0);
						if(html.indexOf('_SUCCESS') >= 0){
							window.location.reload(true);
						}else if(html.indexOf('_ERROR') >= 0){
							alertify.error(insert_error);
						}else{
							alertify.error(exist_error);
						}
					}
				});
			});
		}
	}
});