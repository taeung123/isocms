<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$mod}">{$core->get_Lang('transfer')}</a>    
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>
       {$core->get_Lang('transfer')} <a href="{$PCMS_URL}/?mod={$mod}&act=edit{$pUrl}" class="btn btn-success" title="{$core->get_Lang('addtours')}"> <i class="icon-plus icon-white"></i></a>
        </h2>
        <p>Chức năng quản lý danh sách các transfer trong hệ thống isoCMS</p>
		<p>{$core->get_Lang('This function is intended to manage transfer in isoCMS system')}</p>
    </div>
	<div class="clearfix"></div>
	<div class="statistical mb5">
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="50%" align="left">&nbsp;</td>
				<td width="50%" align="right">
					{$core->get_Lang('Record/page')}:
					{$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod)}
					<a class="btn btn-danger btn-delete-all" clsTable="Transfer" style="display:none">
                        <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span>
                    </a>
				</td>
			</tr>
		</table>
	</div>
	<div class="tabbox">
		<div class="hastable">
			<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
				<thead>
					<tr>
						<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
						<th class="gridheader hiden767"><strong>ID</strong></th>
						<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('transfer name')}</strong></th>
						<th class="gridheader hiden_responsive" style="text-align:center; width:70px;"><strong>{$core->get_Lang('public')}</strong></th>
						<th class="gridheader hiden_responsive" style="text-align:center; width:70px;"><strong>{$core->get_Lang('func')}</strong></th>
					</tr>
				</thead>
				{if $allItem[0].transfer_id ne ''}
				<tbody id="SortAble">
					{section name=i loop=$allItem}
					<tr style="cursor:move" id="order_{$allItem[i].transfer_id}" class="{cycle values="row1,row2"}">
						<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].transfer_id}" /></th>
						<th class="index hiden767">{$allItem[i].transfer_id}</th>
						<td class="name_service">
							<strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].transfer_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].transfer_id)}</strong>
							{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
							<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
						</td>
						<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
							<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Transfer" pkey="transfer_id" sourse_id="{$allItem[i].transfer_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].transfer_id)}" title="{$core->get_Lang('Click to change status')}">
								{if $clsClassTable->getOneField('is_online',$allItem[i].transfer_id) eq '1'}
								<i class="fa-solid fa-circle-check green"></i>
								{else}
								<i class="fa-solid fa-circle-minus red"></i>
								{/if}
							</a>
						</td>
						<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn btn_dropdown dropdown-toggle"
										type="button"
										data-bs-toggle="dropdown"
										aria-expanded="false">
									<i class="fa fa-ellipsis-v"></i>
								</button>

								<ul class="dropdown-menu dropdown-menu-end">

									{if $allItem[i].is_trash eq '0'}

									<li>
										<a class="dropdown-item"
										href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].transfer_id)}"
										target="_blank"
										title="{$core->get_Lang('view')}">
											<i class="fa fa-eye"></i>
											{$core->get_Lang('view')}
										</a>
									</li>

									<li>
										<a class="dropdown-item"
										title="{$core->get_Lang('edit')}"
										href="{$PCMS_URL}/?mod={$mod}&act=edit{if $is_set=='free'}&is_set=free{/if}&transfer_id={$core->encryptID($allItem[i].transfer_id)}">
											<i class="fa fa-edit"></i>
											{$core->get_Lang('edit')}
										</a>
									</li>

									<li>
										<a class="dropdown-item"
										title="{$core->get_Lang('trash')}"
										href="{$PCMS_URL}/?mod={$mod}&act=trash&transfer_id={$core->encryptID($allItem[i].transfer_id)}{$pUrl}&page={$currentPage}">
											<i class="fa fa-trash"></i>
											{$core->get_Lang('trash')}
										</a>
									</li>

									{else}

									<li>
										<a class="dropdown-item"
										title="{$core->get_Lang('restore')}"
										href="{$PCMS_URL}/?mod={$mod}&act=restore&transfer_id={$core->encryptID($allItem[i].transfer_id)}{$pUrl}&page={$currentPage}">
											<i class="fa fa-undo"></i>
											{$core->get_Lang('restore')}
										</a>
									</li>

									<li>
										<a class="dropdown-item confirm_delete"
										title="{$core->get_Lang('delete')}"
										href="{$PCMS_URL}/?mod={$mod}&act=delete&transfer_id={$core->encryptID($allItem[i].transfer_id)}{$pUrl}&page={$currentPage}">
											<i class="fa fa-times"></i>
											{$core->get_Lang('delete')}
										</a>
									</li>

									{/if}

								</ul>
							</div>
						</td>
					</tr>
					{/section}
				</tbody>
				{else}<tr><td colspan="15">{$core->get_Lang('nodata')}!</td></tr>{/if}
			</table>
			<div style="border:1px solid #ccc; padding:5px; margin-top:10px;">
				<strong>{$core->get_Lang('warning')}</strong>:  
				<img src="{$URL_IMAGES}/warning-20.png" align="absmiddle" /> {$core->get_Lang('incorrectlyformatted')}
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
	
</div>
<script type="text/javascript">
	var $boxID = "";
	var $tour_group_id = '{$tour_group_id}';
	var $tour_type_id = '{$tour_type_id}';
	var $cat_id = '{$cat_id}';
	var $city_id= '{$city_id}';
	var $departure_point_id= '{$departure_point_id}';
	var $is_set= '{$is_set}';
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/transfer/jquery.transfer.js"></script>
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
			var recordPerPage = $recordPerPage;
			var currentPage = $currentPage;
			var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage;
			$.post(path_ajax_script+"/index.php?mod=transfer&act=ajUpdPosSortTransfer", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}