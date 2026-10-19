<div class="page_container page-tour_setting">
	{$core->getBlock('header_title_module_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		{$core->getBlock('menu_cruise_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang('pricerange')}</h2>
				</div>
				<div class="button_right">
					<a class="btn btn-main btn-addnew btnCreatePriceRange" href="javascript:void(0);" title="{$core->get_Lang('add')} {$core->get_Lang('Cruise Class')}">{$core->get_Lang('add')}</a>
				</div>
			</div>
			<div class="fl fiterbox" style=" width:80%">
				<div class="wrap">
					<div class="searchbox" style="float:left !important; width:100%">
						<input type="text" class="m-wrap short" name="keyword" id="keyword" placeholder="{$core->get_Lang('search')}" />
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="hastable" style=" width:60%">
				<table cellspacing="0" class="tbl-grid table-striped table_responsive tblAction full-width" id="tblLanguage">
					<thead>
						<tr>
							<th class="gridheader" style=" width:4%">#</th>
							<th class="gridheader"><strong>{$core->get_Lang('title')}</strong></th>
							<th class="gridheader"><strong>{$core->get_Lang('minrate')}</strong></th>
							<th class="gridheader"><strong>{$core->get_Lang('maxrate')}</strong></th>
							<th class="gridheader" style="width:3%" colspan="4"><strong>{$core->get_Lang('move')}</strong></th>
							<th class="gridheader" style="text-align:center;"><strong>{$core->get_Lang('func')}</strong></th>
						</tr>
					</thead>					
					<tbody id="tblHolderPriceRange">
					</tbody>
				</table>
				<div class="clearfix" style="height:5px"></div>
					<div class="pagination_box">
					<div class="wrap holderEvent_tbl" id="dataTable_paginate">
					<!-- Ajax Loading pagination -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
	var aj_search = '';
	loadTablePriceRange('',1,10);
	$('#keyword').bind('keydown',function(){
		var $_this = $(this);
		loadTablePriceRange($_this.val(),1,10);
	});
	$('.btnCreatePriceRange').click(function(){
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmCruisePriceRange',
			data : adata = {'tp' : 'F'},
			dataType:'html',
			success:function(html){
				makepopupnotresize('30%','auto',html,'box_CreatePriceRange');
				$('#box_CreatePriceRange').css('top', 80 + 'px');
				$(".price").priceFormat({thousandsSeparator: '.',centsLimit: 0});
				vietiso_loading(0);
			}
		});
		return false;
	});
	$('.ajEditPriceRange').live('click',function(){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmCruisePriceRange',
			data : {'cruise_price_range_id' : $_this.attr('data'),'tp' : 'F'},
			dataType:'html',
			success:function(html){
				makepopupnotresize('30%','auto',html,'box_EditPriceRange');
				$('#box_EditPriceRange').css('top', 80 + 'px');
				$(".price").priceFormat({thousandsSeparator: '.',centsLimit: 0});
				vietiso_loading(0);
			}
		});
		return false;
	});
	$('.ajSubmitPriceRange').live('click',function(){
		var $_this = $(this);
		var $_form = $_this.closest('.frmPop');
		/**/
		var $title = $_form.find('input[name=title]');
		var $min_rate = $_form.find('input[name=min_rate]');
		var $max_rate = $_form.find('input[name=max_rate]');
		/**/
		if($title.val()==''){
			$title.addClass('error').focus();
			alertify.error(field_is_required);
			return false;
		}
		if($min_rate.val()==''){
			$min_rate.addClass('error').focus();
			alertify.error(field_is_required);
			return false;
		}
		if($max_rate.val()==''){
			$max_rate.addClass('error').focus();
			alertify.error(field_is_required);
			return false;
		}
		var adata = {
			'title'		: $title.val(),
			'min_rate' 	: $min_rate.val(),
			'max_rate' 	: $max_rate.val(),
			'cruise_price_range_id' : $_this.attr('cruise_price_range_id'),
			'tp' : 'S'
		};
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url : path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmCruisePriceRange',
			data:adata,
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				if(html.indexOf('_INSUCCESS') >= 0){
					loadTablePriceRange('',1,10);
					alertify.success(insert_success);
					$_form.find('.close_pop').trigger('click');
				}
				if(html.indexOf('_UPSUCCESS') >= 0){
					var $keyword = $('#keyword').val();
					var $page = $('.paginate_current_page').val();
					var $number_per_page = $('.paginate_length').val();
					loadTablePriceRange($keyword,$page,$number_per_page);
					alertify.success(update_success);
					$_form.find('.close_pop').trigger('click');
				}
				if(html.indexOf('_ERROR') >= 0){
					alertify.error(insert_error);
				}
				if(html.indexOf('_EXIST') >= 0){
					alertify.error(exist_error);
				}
			}
		});
	});
	$('.ajDeletePriceRange').live('click',function(){
		var $_this = $(this);
		if(confirm(confirm_delete)){
			vietiso_loading(1);
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteFrmCruisePriceRange',
				data : {'cruise_price_range_id' : $_this.attr('data'),'tp' : 'D'},
				dataType:'html',
				success:function(html){
					var $keyword = $('#keyword').val();
					var $page = $('.paginate_current_page').val();
					var $number_per_page = $('.paginate_length').val();
					loadTablePriceRange($keyword,$page,$number_per_page);
					vietiso_loading(0);
				}
			});
		}
		return false;
	});
	$('.ajMovePriceRange').live('click',function(){
		var _this = $(this);
		var adata = {
			'cruise_price_range_id' : _this.attr('data'),
			'direct' : _this.attr('direct'),
			'tp' : 'M'
		};
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/index.php?mod="+mod+"&act=ajSiteFrmCruisePriceRange",
			data: adata,
			dataType: "html",
			success: function(html){
				var $keyword = $('#keyword').val();
				var $page = $('.paginate_current_page').val();
				var $number_per_page = $('.paginate_length').val();
				loadTablePriceRange($keyword,$page,$number_per_page);
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
		loadTablePriceRange($keyword,$page,$number_per_page);
	});
	$('.paginate_button').live('click',function(){
		var $_this = $(this);
		if(!$_this.hasClass('disabled')){
			var $keyword = $('#keyword').val();
			var $page = $_this.attr('page');
			var $number_per_page = $('.paginate_length').val();
			loadTablePriceRange($keyword,$page,$number_per_page);
		}
		return false;
	});
});
function loadTablePriceRange($keyword,$page, $number_per_page){
	vietiso_loading(1);
	var adata = {
		'keyword' : $keyword,
		'page'	: $page,
		'number_per_page' : $number_per_page,
		'tp' : 'L'
	};
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/index.php?mod="+mod+"&act=ajSiteFrmCruisePriceRange",
		data: adata,
		dataType: "html",
		success: function(html){
			var htm = html.split('$$');
			$('#tblHolderPriceRange').html(htm[0]);
			$('#dataTable_paginate').html(htm[1]);
			vietiso_loading(0);
		}
	});
}
</script>
{/literal}