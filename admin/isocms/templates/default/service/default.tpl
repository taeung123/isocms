<div class="page_container">
	<div class="page-title  d-flex">
        <div class="title">
			<h2>{$core->get_Lang('service')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách {$core->get_Lang('service')} trong hệ thống isoCMS">i</div></h2>
			<p>Chức năng quản lý danh sách các services trong hệ thống isoCMS</p>
			<p>{$core->get_Lang('This function is intended to manage services in isoCMS system')}</p>
			
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew add_new_service" title="{$core->get_Lang('Add')} {$core->get_Lang('service')}">{$core->get_Lang('Add')} {$core->get_Lang('service')}</a>
			<div class="btn btn-setting"><a href="{$PCMS_URL}/?mod={$mod}&act=setting" title="{$core->get_Lang('Setting')}"><i class="fa fa-cog" aria-hidden="true"></i></a></div>
		</div>
    </div>
	<div class="container-fluid">
    <div class="wrap">
       <div class="filter_box">
			<form id="forums" method="post" action="" name="filter" class="filterForm">
				<div class="form-group form-keyword">
					<input type="text" class="text form-control" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
				</div>
                {if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
				<div class="form-group form-category">
					<select name="servicecat_id" class="form-control" id="booking_date">
						{$clsServiceCategory->makeSelectboxOption($servicecat_id)}
					</select>
				</div>
                {/if}
				<div class="form-group form-button">
					<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang('Search')}</button>
					<input type="hidden" name="filter" value="filter">
				</div>				
				<div class="form-group form-button">
					<a class="btn btn-delete-all" id="btn_delete" clsTable="Service" style="display:none">
						{$core->get_Lang('Delete')}
					</a>
				</div>
			</form>
			<div class="mt10_767" style="float:right;">
				<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning btnNew" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')}({$number_all})</span> </a>
				<a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger btnNew" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
				{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
				<a href="{$PCMS_URL}/?mod={$mod}&act=category" class="btn btn-green btnNew" title="{$core->get_Lang('Category')}"><i class="icon-list icon-white"></i> <span>{$core->get_Lang('Category')}</span> </a>
				{/if}
			</div>
		</div>
        <input id="list_selected_chkitem" style="display:none" value="0" />
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="50%" align="left">&nbsp;</td>
				<td width="50%" align="right">
					{$core->get_Lang('Record/page')}:
					{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl)}
				</td>
			</tr>
		</table>
        <div class="clearfix"></div>
        <table cellspacing="0" class="tbl-grid full-width table-striped table_responsive" width="100%">
			<thead>
				<tr>
					<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
					<th class="gridheader hiden767" style="width:60px"><strong>{$core->get_Lang('ID')}</strong></th>
					<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('titleofarticle')}</strong></th>
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
					<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('category')}</strong></th>
					{/if}
					<th class="gridheader hiden_responsive" style="width:60px"><strong>{$core->get_Lang('status')}</strong></th>
					<th class="gridheader hiden_responsive" style="width:120px;" align="center"><strong>{$core->get_Lang('update')}</strong></th>
					<th class="gridheader hiden_responsive" style="width:70px"><strong>{$core->get_Lang('func')}</strong></th>
				</tr>
			</thead>
			<tbody id="SortAble">
				{section name=i loop=$allItem}
				<tr style="cursor:move" id="order_{$allItem[i].service_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].service_id}" /></th>
					<th class="index hiden767">{$allItem[i].service_id}</th>
					<td class="name_service">
						<strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].service_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].service_id)}</strong>
						{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
						<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
					</td>
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
					<td data-title="{$core->get_Lang('category')}" class="block_responsive border_top_responsive"><a href="{$PCMS_URL}/index.php?admin&mod={$mod}&servicecat_id={$allItem[i].cat_id}">
						<i class="fa fa-folder-open"></i> {$clsServiceCategory->getTitle($allItem[i].cat_id)}</a>
					</td>
					{/if}
					<td data-title="{$core->get_Lang('status')}" {if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}class="block_responsive"{else}class="block_responsive border_top_responsive"{/if} style="text-align:center">
						<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Service" pkey="service_id" sourse_id="{$allItem[i].service_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].service_id)}" title="{$core->get_Lang('Click to change status')}">
							{if $clsClassTable->getOneField('is_online',$allItem[i].service_id) eq '1'}
							<i class="fa-solid fa-circle-check green"></i>
							{else}
							<i class="fa-solid fa-circle-minus red"></i>
							{/if}
						</a>
					</td>
					<td data-title="{$core->get_Lang('update')}" class="block_responsive" style="text-align:center">{$allItem[i].upd_date|date_format:"%d/%m/%Y %H:%M"}</td>
					<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="btn-group">
							<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>

							<ul class="dropdown-menu dropdown-menu-end">
								{if $allItem[i].is_trash eq '0'}
								<li>
									<a class="dropdown-item" href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].service_id)}" target="_blank" title="{$core->get_Lang('view')}">
										<i class="icon-eye-open"></i> <span>{$core->get_Lang('view')}</span>
									</a>
								</li>

								<li>
									<a class="dropdown-item" title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/service/insert/{$allItem[i].service_id}/overview">
										<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
									</a>
								</li>

								<li>
									<a class="dropdown-item" title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&service_id={$core->encryptID($allItem[i].service_id)}{$pUrl}">
										<i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span>
									</a>
								</li>
								{else}

								<li>
									<a class="dropdown-item" title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&service_id={$core->encryptID($allItem[i].service_id)}{$pUrl}">
										<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
									</a>
								</li>

								<li>
									<a class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act=delete&service_id={$core->encryptID($allItem[i].service_id)}{$pUrl}">
										<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
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
        {$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
	</div>
</div>
</div>
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/service/jquery.service.new.js?v={$upd_version}"></script>
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
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListService", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}