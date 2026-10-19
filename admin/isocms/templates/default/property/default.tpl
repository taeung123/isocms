<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('Dashboard')}">{$core->get_Lang('Dashboard')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$mod|capitalize}</a>
</div>
<script type="text/javascript" src="{$PCMS_URL}/editor/tiny_mce/tiny_mce.js"></script>
<div class="page-tour_setting page_container">
    {if $type && $type !='Unit' && $type != 'Market'}
	{$core->getBlock('header_title_tour_setting')}
    {/if}
	{if $type != "Market"}
	{$core->getBlock('header_title_module_setting')}
	{/if}
	<div class="container-fluid container-fluid-2 d-flex">
        {if $type !='Unit' && $type !='Market'}
		{$core->getBlock('menu_tour_exhautive_setting')}
        {/if}
		{if $type != "Market"}
		{$core->getBlock('menu_voucher_setting')}
		{/if}
		<div class="content_setting_box {$type}">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang($type)} </h2>
					<p>Chức năng quản lý danh sách các {$type} trong hệ thống isoCMS</p>
					<p>This function is intended to manage {$type} in isoCMS system</p>
				</div>
				<div class="button_right">
					<a class="btn btn-main btn-addnew clickToAddProperty" title="{$core->get_Lang('Add')} {$core->get_Lang($type)}">{$core->get_Lang('Add')} {$core->get_Lang($type)}</a>
				</div>
			</div>
			<div class="container-fluid">
				<div class="wrap">
					<div class="filter_box">
						<form id="forums" method="post" class="filterForm" action="">
							<div class="form-group form-keyword">
								<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
							</div>
							<div class="form-group form-button">
								<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
								<input type="hidden" name="filter" value="filter" />
								<input type="hidden" name="type" value="{$type}" />
							</div>
							<div class="form-group form-button">
								<a class="btn btn-delete-all" id="btn_delete" clsTable="Property" style="display:none">
									{$core->get_Lang('Delete')}
								</a>
							</div>
						</form>	
						<div class="record_per_page">
							<label>{$core->get_Lang('Record/page')}</label>
							{$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod,'',$type)}
						</div>
					</div>
					
				</div>
				<div class="hastable">
					<table width="100%" cellspacing="0" class="tbl-grid table-striped table_responsive" id="tblLanguage">
						<thead>
							<tr>
								<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
								<th class="gridheader hiden767" style="width:60px"><strong>{$core->get_Lang('ID')}</strong></th>
								<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('Name')}</strong></th>
								<th class="gridheader hiden_responsive text-left" style="width:100px"><strong>{$core->get_Lang('Type')}</strong></th>
								<th class="gridheader hiden_responsive" style="text-align:center; width:60px"></th>
							</tr>
						</thead>
					   <tr>
					   <tbody id="SortAble">
							{section name=i loop=$allItem}
							<tr style="cursor:move" id="order_{$allItem[i].property_id}"   class="{cycle values="row1,row2"}">
								<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].property_id}" /></th>
								<th class="index hiden767"> {$allItem[i].property_id}</th>
								<td class="name_service">
									<span class="title">{$clsClassTable->getTitle($allItem[i].property_id)}</span>
									{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
									<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
								</td>
								<td class="text-left block_responsive border_top_responsive" style="white-space:nowrap" data-title="{$core->get_Lang('Type')}">
									<strong>{$clsClassTable->getOneField('type',$allItem[i].property_id)}</strong>
								</td>
								<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 60px; white-space: nowrap;">
									<div class="btn-group">
										<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
										</button>
										<ul class="dropdown-menu" style="right:0px !important">
											{if $allItem[i].is_trash eq '0'}
												<li>
													<a title="Edit" class="clickToEditProperty" href="javascript:void(0)" data="{$allItem[i].property_id}">
														<i class="icon-edit"></i><span>Edit</span>
													</a>
												</li>
												<li>
													<a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&type={$type}&action=Trash&property_id={$core->encryptID($allItem[i].property_id)}">
														<i class="icon-trash"></i><span>{$core->get_Lang('trash')}</span>
													</a>
												</li>
											{else}
												<li>
													<a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&type={$type}&action=Restore&property_id={$core->encryptID($allItem[i].property_id)}">
														<i class="icon-refresh"></i><span>{$core->get_Lang('restore')}</span>
													</a>
												</li>
												<li>
													<a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&type={$type}&action=Delete&property_id={$core->encryptID($allItem[i].property_id)}">
														<i class="icon-remove"></i><span>{$core->get_Lang('delete')}</span>
													</a>
												</li>
											{/if}
										</ul>
									</div>
								</td>
							</tr>
							{assign var=listChild value=$clsClassTable->getChild($allItem[i].property_id,0,0)}
							{if $listChild}
								{$clsClassTable->getLstChild($allItem[i].property_id)}
							{/if}
							{/section}
						</tbody>
					   
					</table>
					<div class="clearfix"></div>
					{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
				</div>
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
				'property_id' : $_this.attr('data'),
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
					'property_id' : $_this.attr('data')
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
			var $image = $('#isoman_url_image');
			if($('#title').val()==''){
				$('#title').addClass('errorInput').focus();
				alertify.error(title_required);
				return false;
			}
			/*if($('#type').val()==''){
				$('#type').addClass('errorInput').focus();
				alertify.error('Bạn chưa chọn lại thuộc tính');
				return false;
			}*/

			var parent_id = 0;
			if($('#parent_id').length > 0){
				parent_id = $('#parent_id').val();
			}
			var country_id = 0;
			if($('#country_id').length > 0){
				/*if($('#country_id').val()=='' && parent_id == 0){
					$('#country_id').addClass('errorInput').focus();
					alertify.error('Bạn chưa chọn quốc gia');
					return false;
				}*/
				country_id = $('#country_id').val();
			}

			var adata = {
				'title'				: $('#title').val(),
				'image'	  		: 	$image.val(),
				'type'				: type,
				'property_id'		: _this.attr('property_id'),
				'country_id'		: country_id,
				'parent_id'		: parent_id
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
<script type="text/javascript">
	var $type= '{$type}';
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/tour/jquery.tour.js"></script>
{literal}
<script type="text/javascript">
	$("#SortAble").sortable({
		opacity: 0.8,
		cursor: 'move',
		start: function(){
			vietiso_loading(1);
		},
		stop: function(){
			vietiso_loading(0);
		},
		update: function(){
			var type = $type;
			var recordPerPage = $recordPerPage;
			var currentPage = $currentPage;
			var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage+'&type='+type;
			$.post(path_ajax_script+"/index.php?mod=property&act=ajUpdPosSortProperty", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}