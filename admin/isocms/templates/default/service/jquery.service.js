$().ready(function(){
	// Page Service - Mod: Service - Act: Edit
	if(mod == 'service' && act== 'edit') {
		/* TAG SERVICE */
		if($SiteHasTags_Service==1){
			$("#txtTag").autocomplete(availableTags, {
				minChars: 1,
				width: 200,
				matchContains: true,
				autoFill: false,
				formatItem: function(row, i, max) {
					return row.name;
				},
				formatResult: function(row) {
					return row.val;
				}
			});
			$('#txtTag').keypress(function(e) {
				var key;
				if (window.event)
					key = window.event.keyCode;
				else
					key = e.which;
				if (key == 13) {
					$('#addTag').trigger('click');
				}
			});
			$(document).on('click', '#addTag', function(ev){
				var newval = $('#txtTag').val();
				if (newval != '') {
					vietiso_loading(1);
					$.ajax({
						type: "POST",
						url: path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteServiceTags',
						data: {"for_id": pvalTable,"val": $('#txtTag').val(),"type": $type,'tp': 'S'},
						dataType: "html",
						success: function(html) {
							vietiso_loading(0);
							if(html.indexOf('_EXIST') >= 0) {
								alertify.error(exist_error);
							} else {
								$('#listTag').append(html);
								$('#txtTag').val('').focus();
							}
						}
					});
					return false;
				}
			});
			$(document).on('click', '.closeTag', function(ev){
				if(confirm(confirm_delete)){
					var $_this = $(this);
					var id = $_this.attr('id');
					var sp = id.split('-');
					var tag_module_id = sp[1];
					vietiso_loading(1);
					$.ajax({
						type: "POST",
						url: path_ajax_script + '/index.php?mod='+mod+'&act=ajSiteServiceTags',
						data: {"tag_module_id": tag_module_id,'tp': 'D'},
						dataType: "html",
						success: function(html) {
							vietiso_loading(0);
							$_this.parent().remove();
						}
					});
				}
				return false;
			});
			function stopRKey(evt) {
				var evt = (evt) ? evt : ((event) ? event : null);
				var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
				if ((evt.keyCode == 13) && (node.type == "text")) {
					return false;
				}
			}
			document.onkeypress = stopRKey;
		}
	}
	if(mod == 'service' && act== 'category') {
		/* SERVICES CATEGORY */
		if($SiteHasCat_Service==1){
			$(document).on('click', '.btnCreateCategoryService', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: 'POST',
					url: path_ajax_script + '/index.php?mod='+mod+'&act=SiteServiceCategory',
					data : {'servicecat_id':$_this.attr('data'),'tp':'F'},
					dataType: 'html',
					success: function(html) {
						vietiso_loading(0);
						makepopupnotresize('52%', 'auto', html, 'box_AddCategoryService');
						$('#box_AddCategoryService').css('top', '50px');
						var $editorID = $('.textarea_service_intro_editor').attr('id');
						$('#'+$editorID).isoTextAreaFull();
					}
				});
				return false;
			});
			$(document).on('click', '.btnEditServiceCat', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: 'POST',
					url: path_ajax_script + '/index.php?mod='+mod+'&act=SiteServiceCategory',
					data: {'servicecat_id': $_this.attr('data'),'tp':'F'},
					dataType: 'html',
					success: function(html) {
						vietiso_loading(0);
						makepopupnotresize('52%', 'auto', html, 'box_EditCategoryService');
						$('#box_EditCategoryService').css('top', '50px');
						var $editorID = $('.textarea_service_intro_editor').attr('id');
						$('#'+$editorID).isoTextAreaFull();
					}
				});
				return false;
			});
			$(document).on('click', '.btnClickToSubmitCategory', function(ev){
				var $_this = $(this);
				var $_form = $_this.closest('.frmPop');
				
				var $title = $_form.find('input[name=title]');
				var $editorID = $('.textarea_service_intro_editor').attr('id');
				var $intro = tinyMCE.get($editorID).getContent();
				
				if ($title.val() == '') {
					$title.focus();
					alertify.error(field_is_required);
					return false;
				}
				var adata = {
					'title'			: 	$title.val(),
					'intro'			: 	$intro,
					'servicecat_id'	: 	$_this.attr('servicecat_id'),
					'tp' 			: 	'S'
				};
				vietiso_loading(1);
				$.ajax({
					type: 'POST',
					url: path_ajax_script+'/index.php?mod='+mod+'&act=SiteServiceCategory',
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