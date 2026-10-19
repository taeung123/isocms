$().ready(function(){
	// Page Ads - Mod: Ads - Act: Default
	if(mod == 'ads' && act== 'default') {
		if($SiteHasGroup_Ads==1){
			loadListAdsGroup('',1,10);
			
			$('#keyword_ads_group').bind('keyup change',function(){
				var $_this = $(this);
				loadListAdsGroup($_this.val(),1,10);
			});
			$('.btnCreateNewAdsGroup').click(function(){
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteAdsGroup',
					data : {'tp' : 'F'},
					dataType:'html',
					success:function(html){
						vietiso_loading(0);
						makepopupnotresize('45%', 'auto', html, 'box_CreateNewAdsGroup');
						$('#box_CreateNewAdsGroup').css('top','50px');
					}
				});
				return false;
			});
			$('.ajEditAdsGroup').live('click',function(){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteAdsGroup',
					data : {'ads_group_id' : $_this.attr('data'),'tp' : 'F'},
					dataType:'html',
					success:function(html){
						vietiso_loading(0);
						makepopupnotresize('45%', 'auto', html, 'box_EditAdsGroup');
						$('#box_EditAdsGroup').css('top','50px');
					}
				});
				return false;
			});
			$('.ajSubmitAdsGroup').live('click',function(){
				var $_this = $(this);
				var $_form = $_this.closest('.frmPop');
				
				var $parent_id 	= $_form.find('select[name=parent_id]');
				var $title 		= $_form.find('input[name=title]');
				var $code 		= $_form.find('input[name=code]');
				var $width 		= $_form.find('input[name=width]');
				var $height 	= $_form.find('input[name=height]');
				var $intro 		= $_form.find('textarea[name=intro]');
				/**/
				if($parent_id.val()==''){
					$parent_id.addClass('error').focus();
					alertify.error(field_is_required);
					return false;
				}
				if($title.val()==''){
					$title.addClass('error').focus();
					alertify.error(field_is_required);
					return false;
				}
				if($width.val()==''){
					$width.addClass('error').focus();
					alertify.error(field_is_required);
					return false;
				}
				if($height.addClass('error').val()==''){
					$height.focus();
					alertify.error(field_is_required);
					return false;
				}
				var adata = {
					'parent_id'		: $parent_id.val(),
					'title'			: $title.val(),
					'code'			: $code.val(),
					'width'			: $width.val(),
					'height'		: $height.val(),
					'intro'			: $intro.val(),
					'ads_group_id' 	: $_this.attr('ads_group_id'),
					'tp' : 'S'
				};
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url : path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteAdsGroup',
					data:adata,
					dataType:'html',
					success:function(html){
						if(html.indexOf('_INSERT_SUCCESS')>=0){
							loadListAdsGroup('',1,10);
							$_this.closest('.frmPop').find('.close_pop').trigger('click');
						}
						if(html.indexOf('_UPDATE_SUCCESS')>=0){
							var $keyword = $('#keyword').val();
							var $page = $('.paginate_current_page').val();
							var $number_per_page = $('.paginate_length').val();
							loadListAdsGroup($keyword,$page,$number_per_page);
							$_this.closest('.frmPop').find('.close_pop').trigger('click');
						}
						if(html.indexOf('_ERROR')>=0){
							alertify.error(insert_error);
						}
						if(html.indexOf('_EXIST')>=0){
							alertify.error(exist_error);
						}
						vietiso_loading(0);
					}
				});
			});
			$('.ajDeleteAdsGroup').live('click',function(){
				var $_this = $(this);
				if(confirm(confirm_delete)){
					var adata = {
						'ads_group_id' : $_this.attr('data'),
						'tp' : 'D'
					};
					vietiso_loading(1);
					$.ajax({
						type:'POST',
						url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteAdsGroup',
						data : adata,
						dataType:'html',
						success:function(html){
							var $keyword = $('#keyword').val();
							var $page = $('.paginate_current_page').val();
							var $number_per_page = $('.paginate_length').val();
							loadListAdsGroup($keyword,$page,$number_per_page);
							vietiso_loading(0);
						}
					});
				}
				return false;
			});
			$('.ajMoveAdsGroup').live('click',function(){
				var $_this = $(this);
				var adata = {
					'ads_group_id' : $_this.attr('data'),
					'direct' : $_this.attr('direct'),
					'parent_id' : $_this.attr('parent_id'),
					'tp' : 'M'
				};
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/?mod="+mod+"&act=ajSiteAdsGroup",
					data: adata,
					dataType: "html",
					success: function(html){
						var $keyword = $('#keyword').val();
						var $page = $('.paginate_current_page').val();
						var $number_per_page = $('.paginate_length').val();
						loadListAdsGroup($keyword,$page,$number_per_page);
						vietiso_loading(0);
					}
				});
				return false;
			});
			$('.paginate_length').live('change',function(){
				var $_this = $(this);
				var $keyword = $('#keyword').val();
				var $page = 1;
				var $number_per_page = $_this.val();
				loadListAdsGroup($keyword,$page,$number_per_page);
			});
			$('.paginate_button').live('click',function(){
				var $_this = $(this);
				if(!$_this.hasClass('disabled')){
					var $keyword = $('#keyword').val();
					var $page = $_this.attr('page');
					var $number_per_page = $('.paginate_length').val();
					loadListAdsGroup($keyword,$page,$number_per_page);
				}
				return false;
			});
		}
	}
});
function loadListAdsGroup($keyword, $page, $number_per_page){
	vietiso_loading(1);
	var adata = {
		'keyword' : $keyword,
		'page'	: $page,
		'number_per_page' : $number_per_page,
		'tp'	: 'L',
	};
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajSiteAdsGroup",
		data: adata,
		dataType: "html",
		success: function(html){
			var htm = html.split('$$');
			$('#tblAdsGroup').html(htm[0]);
			$('#dataTable_paginate').html(htm[1]);
			vietiso_loading(0);
		}
	});
}