<div class="breadcrumb">
	<strong>You are here:</strong>
	<a href="{$PCMS_URL}" title="Dashboard">Dashboard</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$mod|capitalize}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
    	<a href="javascript:window.history.back();" class="back fr">Back</a>
        <h2>Hotel Property Managerment <a href="javascript:void(0);" class="btn btn-success btnCreateHotelProperty" title="{$core->get_Lang('add')}"><i class="icon-plus icon-white"></i></a></h2>
        <p>{$core->get_Lang('System hotel property managerment')}</p>
    </div>
	<div class="hastable">
		<table width="100%" cellspacing="0" class="tbl-grid table-striped table_responsive" id="tblLanguage">
			<thead>
				<td class="gridheader"><strong>STT</strong></td>
				<td class="gridheader"><strong>{$core->get_Lang('Title')}</strong></td>
				<td class="gridheader" style="text-align:center; width:6%" colspan="4"><b>{$core->get_Lang('move')}</b></td>
				<td class="gridheader"><strong>Action</strong></td>
			</thead>
		   <tr>
		   {section name=i loop=$allItem}
			<tr class="{if $smarty.section.i.iteration %2 eq '0'}row2{else} row1{/if}">
				<td class="index">{$smarty.section.i.index+1}</td>
				<td>
					<a class="btnEditHotelProperty" href="javascript:void();" data="{$allItem[i].hotel_property_id}">
						<strong style="font-size:16px">{$clsClassTable->getTitle($allItem[i].hotel_property_id)}</strong>
					</a>
                    {if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
				</td>
				<td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.first}
                        <a title="{$core->get_Lang('movetop')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movetop&hotel_property_id={$allItem[i].hotel_property_id}"><i class="icon-circle-arrow-up"></i></a>
                        {/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.last}
                        <a title="{$core->get_Lang('movebottom')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movebottom&hotel_property_id={$allItem[i].hotel_property_id}"><i class="icon-circle-arrow-down"></i></a>
                        {/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.first}
                        <a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=moveup&hotel_property_id={$allItem[i].hotel_property_id}"><i class="icon-arrow-up"></i></a>
                        {/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.last}
                        <a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movedown&hotel_property_id={$allItem[i].hotel_property_id}"><i class="icon-arrow-down"></i></a>
                        {/if}
                </td>
				<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                    <div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle"
								type="button"
								data-bs-toggle="dropdown"
								aria-expanded="false">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>

						<ul class="dropdown-menu dropdown-menu-end">
							{if $allItem[i].is_trash eq '0'}

							<li>
								<a title="Edit"
								class="btnEditHotelProperty dropdown-item"
								href="javascript:void(0)"
								data="{$allItem[i].hotel_property_id}">
									<i class="icon-edit"></i>
									<span>Edit</span>
								</a>
							</li>

							<li>
								<a title="{$core->get_Lang('trash')}"
								class="dropdown-item"
								href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&hotel_property_id={$core->encryptID($allItem[i].hotel_property_id)}{$pUrl}">
									<i class="icon-trash"></i>
									<span>{$core->get_Lang('trash')}</span>
								</a>
							</li>

							{else}

							<li>
								<a title="{$core->get_Lang('restore')}"
								class="dropdown-item"
								href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&hotel_property_id={$core->encryptID($allItem[i].hotel_property_id)}{$pUrl}">
									<i class="icon-refresh"></i>
									<span>{$core->get_Lang('restore')}</span>
								</a>
							</li>

							<li>
								<a title="{$core->get_Lang('delete')}"
								class="confirm_delete dropdown-item"
								href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&hotel_property_id={$core->encryptID($allItem[i].hotel_property_id)}{$pUrl}">
									<i class="icon-remove"></i>
									<span>{$core->get_Lang('delete')}</span>
								</a>
							</li>

							{/if}
						</ul>
					</div>
                </td>
			</tr>
			{/section}
		   </tr>
		</table>
		<div class="clearfix" style="height:5px"></div>
            <div class="pagination_box">
            <div class="wrap holderEvent_tbl" id="dataTable_paginate" style="min-height:16px">
            <!-- Ajax Loading pagination -->
            </div>
        </div>
	</div>
</div>
<script type="text/javascript">
	var parent_id = '{$parent_id}';
	var type = '{$type}';
	var content_vn_required = '{$core->get_Lang("content_vn_required")}';
	var content_en_required = '{$core->get_Lang("content_en_required")}';
	var insert_success = '{$core->get_Lang("insert_success")}';
	var update_success = '{$core->get_Lang("update_success")}';
	var confirm_delete = '{$core->get_Lang("confirm_delete")}';
</script>
{literal}
<script type="text/javascript" src="{$URL_THEMES}/hotelpro/jquery.hotelpro.js?v={$upd_version}"></script>
<script type="text/javascript">
	$().ready(function(){
		$('#forums select').change(function(){
			$('#forums').submit();
		});
		$('.clickToAddProperty').click(function(){
			vietiso_loading(1);
			var adata = {
				'parent_id' : parent_id,
				'type' : type
			};
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/?mod=property&act=ajLoadFormAddProperty",
				data: adata,
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					makepopup('45%','auto',html,'frmAddProperty');
				}
			});
			return false;
		});
		$('.clickToEditProperty').live('click',function(){
			var $_this = $(this);
			var adata = {
				'hotel_property_id' : $_this.attr('data'),
				'type' : type
			};
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/?mod=property&act=ajLoadFormEditProperty",
				data: adata,
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					makepopup('45%','auto',html,'frmEditProperty');
				}
			});
			return false;
		});
		$('.clickToDeleteProperty').live('click',function(){
			if(confirm('Delete This Property ?')){
				var $_this = $(this);
				var adata = {
					'hotel_property_id' : $_this.attr('data')
				};
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/?mod=property&act=ajDeleteProperty",
					data: adata,
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						window.location.reload();
					}
				});
			}
			return false;
		});
		$('.frmPop .clickToClose').live('click',function(e){
			var idtmp =$(this).closest('.frmPop');
			$('#isoblanketpop_'+idtmp.attr('id')).remove();
			idtmp.remove();	
		});
		$('#clickSubmitProperty').live('click',function(e){
			e.preventDefault();
			var _this = $(this);
			if($('#title').val()==''){
				$('#title').addClass('errorInput').focus();
				alertify.error(title_required);
				return false;
			}
			if($('#type').val()==''){
				$('#type').addClass('errorInput').focus();
				alertify.error('Bạn chưa chọn lại thuộc tính');
				return false;
			}
			var adata = {
				'title'				: $('#title').val(),
				'type'				: $('#type').val(),
				'hotel_property_id'		: _this.attr('hotel_property_id')
			};
			$.ajax({
				type : "POST",
				url : path_ajax_script+'/index.php?mod=property&act=ajSubmitProperty',
				data: adata,
				dataType: 'html',
				success : function(html){
					window.location.reload();
				}
			});
		});
	});
</script>
{/literal}
{literal}
<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click', '.btnCreateHotelProperty', function(ev){
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteHotelProperty',
			data : {'tp' : 'F'},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('55%', 'auto', html, 'box_HotelProperty');
				$('#box_HotelProperty').css('top','50px');
			}
		});
		return false;
	});
	$(document).on('click', '.btnEditHotelProperty', function(ev){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteHotelProperty',
			data : {'hotel_property_id' : $_this.attr('data'), 'tp' : 'F'},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize('55%', 'auto', html, 'box_HotelProperty');
				$('#box_HotelProperty').css('top','50px');
			}
		});
		return false;
	});
	$(document).on('click', '.btnClickToSubmitHotelProperty', function(ev){
		var $_this = $(this);
		var $_form = $_this.closest('.frmPop');
		var $title = $_form.find('input[name=title]');
		
		if($title.val()==''){
			$title.addClass('error').focus();
			alertify.error(field_is_required);
			return false;
		}
		var adata = {
			'title' 		: 	$title.val(),
			'hotel_property_id' 	: 	$_this.attr('hotel_property_id'),
			'tp' 			: 	'S'
		};
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteHotelProperty',
			data:adata,
			dataType:'html',
			success:function(html){
				if(html.indexOf('_SUCCESS') >= 0){
					window.location.reload(true);
				}
				if(html.indexOf('_ERROR') >= 0){
					alertify.error(insert_error);
				}
				if(html.indexOf('_EXIST') >= 0){
					alertify.error(insert_error_exist);
				}
				vietiso_loading(0);
			}
		});
	});
});
</script>
{/literal}