<div class="breadcrumb">
	<strong>{$core->get_Lang('You ar here')}: </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('Cars')}</a>
</div>
<div class="container-fluid">
	<div class="page-title">
        <h2>{$core->get_Lang('Car List')} <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
		 <p>Chức năng quản lý danh sách các Car trong hệ thống isoCMS</p>
		<p>{$core->get_Lang('This function is intended to manage Car in isoCMS system')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="forums" method="post" action="" name="filter" class="filterForm">
		<div class="filterbox">
			<div class="wrap">
				<div class="searchbox" style="white-space:nowrap">
					<select name="vehicle_type_id" class="text_32 border_aaa span50 fl mr10">
					<option value="0">{$core->get_Lang('Vehicle type')}</option>
						{$clsProperty->getSelectByProperty('VehicleType',$vehicle_type_id)}
					</select>
					<input type="text" class="m-wrap short" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('Search')}..." />
					<a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
						<i class="icon-search icon-white"></i>
					</a>
				</div>
				<div class="fr group_buttons">
					<a href="{$PCMS_URL}/?mod={$mod}&act=new" class="btn btn-success fileinput-button">
						<i class="icon-plus icon-white"></i> <span>{$core->get_Lang('Add new')}</span> 
					</a>
					<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning fileinput-button">
						<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('All')} ({$number_all})</span> 
					</a>
					<a href="{$PCMS_URL}/{$link_page_current_2}&type_list=Trash" class="btn btn-danger fileinput-button">
						<i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Trash')} ({$number_trash})</span> 
					</a>
					<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Car" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
				</div>
			</div>
		</div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <div class="clearfix"><br /></div>
	<div class="statistical mb5">
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="50%" align="left">&nbsp;</td>
				<td width="50%" align="right">
					{$core->get_Lang('Record/page')}:
					{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl)}
				</td>
			</tr>
		</table>
	</div>
	<div class="hastable">
		<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
			<thead>
				<tr>
					<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
					<th class="gridheader hiden767" style="width:50px"><strong>{$core->get_Lang('No')}</strong></th>
					<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('Title')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:center"><strong>{$core->get_Lang('Vehicle type')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:center"><strong>{$core->get_Lang('Seat number')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:center"><strong>{$core->get_Lang('Passenger')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:center; width:70px;"><strong>{$core->get_Lang('function')}</strong></th>
				</tr>
			</thead>
			<tbody id="sortAble">
				{if $allItem[0].car_id ne ''}
				{section name=i loop=$allItem}
				<tr style="cursor:move" id="order_{$allItem[i].car_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].car_id}" /></th>
					<th class="index hiden767">{$smarty.section.i.index+1}</th>
					<td class="name_service" style="text-align:left">
						<a title='Edit "{$clsClassTable->getTitle($allItem[i].car_id)}"' href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&car_id={$allItem[i].car_id}">
						   <strong style="font-size:14px;">{$clsClassTable->getTitle($allItem[i].car_id)}</strong>
						</a>
						{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
						<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
					</td>
					<td data-title="{$core->get_Lang('Vehicle type')}" class="block_responsive" width="120px" style="text-align:left">{$clsProperty->getTitle($clsClassTable->getOneField('vehicle_type_id',$allItem[i].car_id))}</td>
					<td data-title="{$core->get_Lang('Seat number')}" class="block_responsive" width="100px" style="text-align:center">{$clsClassTable->getOneField('number_seat',$allItem[i].car_id)}</td>
					<td data-title="{$core->get_Lang('Passenger')}" class="block_responsive" width="40px" style="text-align:center">{$clsClassTable->getOneField('passenger',$allItem[i].car_id)}</td>
					<td data-title="{$core->get_Lang('func')}" class="block_responsive" style="vertical-align: middle; width: 10px; text-align:center; white-space: nowrap;">
						<div class="dropdown">
							<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>

							<ul class="dropdown-menu dropdown-menu-end">
								{if $allItem[i].is_trash eq '0'}

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('edit')}"
									href="{$PCMS_URL}/?mod={$mod}&act=edit&car_id={$core->encryptID($allItem[i].car_id)}{$pUrl}">
										<i class="icon-edit"></i> {$core->get_Lang('edit')}
									</a>
								</li>

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('trash')}"
									href="{$PCMS_URL}/?mod={$mod}&act=trash&car_id={$core->encryptID($allItem[i].car_id)}{$pUrl}">
										<i class="icon-trash"></i> {$core->get_Lang('trash')}
									</a>
								</li>

								{else}

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('restore')}"
									href="{$PCMS_URL}/?mod={$mod}&act=restore&car_id={$core->encryptID($allItem[i].car_id)}{$pUrl}">
										<i class="icon-refresh"></i> {$core->get_Lang('restore')}
									</a>
								</li>

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('delete')}"
									href="{$PCMS_URL}/?mod={$mod}&act=delete&car_id={$core->encryptID($allItem[i].car_id)}{$pUrl}">
										<i class="icon-remove"></i> {$core->get_Lang('delete')}
									</a>
								</li>

								{/if}
							</ul>
						</div>
					</td>
				</tr>
				{/section}
				{/if}
			</tbody>
		</table>
	</div>
    <div class="clearfix"></div>
	{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
</div>
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
{literal}
<script type="text/javascript">
	$("#sortAble").sortable({
		opacity: 0.8,
		cursor: 'move',
		sortInitialOrder:'desc',
		start: function(){
			vietiso_loading(1);
		},
		stop: function(){
			vietiso_loading(0);
		},
		update: function(){
			var recordPerPage = $recordPerPage;
			var currentPage = $currentPage;
			var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage;
			$.post(path_ajax_script+"/index.php?mod=car&act=ajUpdPosSortCar", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}