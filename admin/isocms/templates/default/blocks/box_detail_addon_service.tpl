<h3 class="title_box mb05">{$core->get_Lang('Add On Services')}</h3>
<p class="intro_box mb40">{$core->get_Lang('introaddonservice')}</p>
<div class="form_option_tour">
	<div class="inpt_tour">
		<table width="100%" class="tbl-grid" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th class="gridheader text-left" style="width:50px"></th>
					<th class="gridheader text-left" style="width:80px"><strong>{$core->get_Lang('ID')}</strong></th>
					<th class="gridheader text-left"><strong>{$core->get_Lang('nameofservice')}</strong></th>
					<th class="gridheader text-right" style="width:120px"><strong>{$core->get_Lang('Price')}</strong></th>
					<th class="gridheader text-center" style="width:30px"></th>
					<th class="gridheader" style="width:50px"></th>
				</tr>
			</thead>
			<tbody>
			{section name=i loop=$lstAddOnService}
			<tr class="{cycle values="row1,row2"}">
				<td class="text-left">
					<input type="checkbox" class="el-checkbox" name="list_service_id[]" {$lstAddOnService[i].check} value="{$lstAddOnService[i].addonservice_id}"{if in_array($lstAddOnService[i].addonservice_id, $list_service_check)} checked{/if}/>
				</td>
				<td class="index text-left">{$lstAddOnService[i].addonservice_id}</td>
				<td class="text-left">{$clsAddOnService->getTitle($lstAddOnService[i].addonservice_id)}</td>
				<td class="text-right td_price">
					{$clsAddOnService->getPrice($lstAddOnService[i].addonservice_id)}{$clsISO->getRate()}
				</td>
				<td></td>
				<td align="center" style="vertical-align: middle; text-align:center; width:50px; white-space: nowrap;">
					<div class="btn-group-ico d-flex">
						<a class="btn_edit_service item_left" title="{$core->get_Lang('edit')}" href="javascript:void(0);" data-combo_id="{$pvalTable}" data-addonservice_id="{$lstAddOnService[i].addonservice_id}" ><i class="ico ico-edit"></i></a>
						<a class="clickDeleteAddOnService item_right" title="{$core->get_Lang('delete')}" href="javascript:void(0);" data-combo_id="{$pvalTable}" data-addonservice_id="{$lstAddOnService[i].addonservice_id}"><i class="ico ico-remove"></i></a>
					</div>
				</td>
			</tr>
			{/section}
			</tbody>
			<tr><td colspan="6" class="td_add_addon"><a href="javascript:void(0);" id="btnCreateService" class="btn_add_addon btnCreateService" title="{$core->get_Lang('Addservice')}">+ {$core->get_Lang('Addservice')}</a></td></tr>
		</table>
	</div>
</div>
{literal}
<script>
$(document).ready(function(){
	$(document).on('click', '.btnCreateService', function(){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod=property&act=ajSiteAddOnService',
			data : {'is_online' : 1, 'tp' : 'F'},
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
			url:path_ajax_script+'/index.php?mod=property&act=ajSiteAddOnService',
			data : {'addonservice_id' : $_this.data('addonservice_id'), 'tp' : 'F'},
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
			'is_online'	  		: 	1,
			'addonservice_id' : 	$_this.attr('addonservice_id'),
			'tp' 				: 	'S'
		};
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod=property&act=ajSiteAddOnService',
			data:adata,
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				if(html.indexOf('_INSERT_SUCCESS') >= 0) {
					alertify.success(insert_success);
					$_this.closest('.frmPop').find('.close_pop').trigger('click');
					window.location.reload();
				}
				if(html.indexOf('_UPDATE_SUCCESS') >= 0){
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
	$(document).on('click', '.clickDeleteAddOnService', function(){
		var $_this = $(this);
		/**/
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod=property&act=ajSiteAddOnService',
			data : {'addonservice_id' : $_this.data('addonservice_id'),'combo_id' : $_this.data('combo_id'), 'tp' : 'DEL'},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				if(html.indexOf('_DELETE_SUCCESS') >= 0) {
					alertify.success(delete_success);
					window.location.reload();
				}
				if(html.indexOf('_ERROR') >= 0) {
					alertify.error(delete_error);
				}
			}
		});
		return false;
	});
});
</script>
{/literal}
