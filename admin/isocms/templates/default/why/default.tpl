<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Why with us')} ?  <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('Why with us')} trong hệ thống isoCMS">i</div>
			</h2>
		</div>
  		<div class="button_right">
			<a class="btn btn-main add_new_ads" href="{$PCMS_URL}/?mod={$mod}&act=edit" title="{$core->get_Lang('Add')} {$core->get_Lang('Why with us')}">{$core->get_Lang('Add')} {$core->get_Lang('Why with us')}</a>
		</div>
   		{*<div class="button_right">
			<a class="btn btn-main btn-addnew add_new_why" type="{$type}" title="{$core->get_Lang('Add')} {$core->get_Lang('Why with us')}">{$core->get_Lang('Add')} {$core->get_Lang('Why with us')}</a>
		</div>*}
    </div>
	<div class="breadcrumb">
		<strong>{$core->get_Lang('You are here')}:</strong>
		<a href="{$PCMS_URL}">{$core->get_Lang('Home')}</a>
		<a>&raquo;</a>
		<a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('Why with us')}?</a>
	</div>
	<div class="container-fluid">
		<div class="wrap">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					{assign var=blog_category_check value=$clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang("Search")}</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button">
						<a class="btn btn-delete-all" id="btn_delete" clsTable="Why" style="display:none">
							{$core->get_Lang('Delete')}
						</a>
					</div>
					<div class="fr group_buttons">
						<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning btnNew" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')}({$number_all})</span> </a>
						<a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger btnNew" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                    </div>
				</form>	
			</div>
		</div>
		<div id="tab_content">
			<div class="tabbox" style="display:block">
				<div class="clearfix"><br /></div>
				{if $allItem[0].why_id eq ''}
				No data
				{else}
				<table width="100%" border="0" cellpadding="3" cellspacing="0">
					<tr>
						<td width="50%" align="left">&nbsp;</td>
						<td width="50%" align="right">
							{$core->get_Lang('Record/page')}:
							{$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod)}
						</td>
					</tr>
				</table>
				<table cellspacing="0" class="tbl-grid full-width table-striped table_responsive">
					<thead>
						<tr>
							<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
							<th class="gridheader hiden767" style="width:60px">{$core->get_Lang('ID')}</th>
							<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('Content')}</strong></th>
{*							<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('Type')}</strong></th>*}
							<th class="gridheader hiden_responsive" style="width:60px"><strong>{$core->get_Lang('status')}</strong></th>
							<th class="gridheader hiden_responsive" style="width:70px"><strong>{$core->get_Lang('Action')}</strong></th>
						</tr>
					</thead>
					<tbody id="SortAble">
						{section name=i loop=$allItem}
						<tr style="cursor:move" id="order_{$allItem[i].why_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
							<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].why_id}" /></th>
							<th class="index hiden767" style="width: 5%; text-align: center;">{$allItem[i].why_id}</th>
							<td class="name_service">							
								<a title="Edit" href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&why_id={$allItem[i].why_id}">
								   <strong>{$clsClassTable->getTitle($allItem[i].why_id)}</strong>
								</a>
								{if $allItem[i].is_trash eq '1'}
								<span style="color:#ccc;">[In Trash]</span>
								{/if}
								<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
							</td>
							{*<td data-title="{$core->get_Lang('Type')}" class="block_responsive border_top_responsive">{if $clsClassTable->getOneField('Type',$allItem[i].why_id) ne ''}
								{$clsClassTable->getOneField('Type',$allItem[i].why_id)}
								{else}
								{$core->get_Lang('Default')}
								{/if}
							</td>*}
							<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
								<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Why" pkey="why_id" sourse_id="{$allItem[i].why_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].why_id)}" title="{$core->get_Lang('Click to change status')}">
									{if $clsClassTable->getOneField('is_online',$allItem[i].why_id) eq '1'}
									<i class="fa-solid fa-circle-check green"></i>
									{else}
									<i class="fa-solid fa-circle-minus red"></i>
									{/if}
								</a>
							</td>
							<td data-title="{$core->get_Lang('func')}" class="block_responsive" style="vertical-align: middle; width: 40px; text-align: right; white-space: nowrap;"> 
								<div class="btn-group">
									<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="fa fa-ellipsis-v"></i>
									</button>

									<ul class="dropdown-menu dropdown-menu-end">
										{if $allItem[i].is_trash eq '0'}
											<li>
												<a class="dropdown-item" title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod={$mod}&act=edit&why_id={$allItem[i].why_id}">
													<i class="fa fa-edit me-1"></i> {$core->get_Lang('edit')}
												</a>
											</li>
											<li>
												<a class="dropdown-item" title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&why_id={$allItem[i].why_id}">
													<i class="fa fa-trash me-1"></i> {$core->get_Lang('trash')}
												</a>
											</li>
										{else}
											<li>
												<a class="dropdown-item" title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&why_id={$allItem[i].why_id}">
													<i class="fa fa-undo me-1"></i> {$core->get_Lang('restore')}
												</a>
											</li>
											<li>
												<a class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act=delete&why_id={$allItem[i].why_id}">
													<i class="fa fa-times me-1"></i> {$core->get_Lang('Delete')}
												</a>
											</li>
										{/if}
									</ul>
								</div>
							</td>
						</tr>	
						{/section}
					</tbody>
				</table>
				{/if}
				{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/why/jquery.why.new.js?v={$upd_version}"></script>
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
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListWhy", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}