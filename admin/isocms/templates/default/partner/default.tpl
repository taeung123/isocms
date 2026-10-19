<div class="page_container">
	<div class="page-title  d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Partner')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách {$core->get_Lang('Partner')} trong hệ thống isoCMS">i</div></h2>
			<p>Chức năng quản lý danh sách các Partner trong hệ thống isoCMS</p>
			<p>{$core->get_Lang('This function is intended to manage Partner in isoCMS system')}</p>			
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew add_new_partner" type="{$type}" cat_id="{$cat_id}" title="{$core->get_Lang('Add')} {$core->get_Lang('Partner')}">{$core->get_Lang('Add')} {$core->get_Lang('Partner')}</a>
		</div>
    </div>
	<div class="container-fluid">
   	<div class="filter_box">
		<form id="forums" method="post" action="" name="filter" class="filterForm">
			<div class="form-group form-keyword">
				<input type="text" class="text form-control" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
				<input type="hidden" name="type" value="{$type}">
			</div>
			<div class="form-group form-button">
				<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang('Search')}</button>
				<input type="hidden" name="filter" value="filter">
			</div>				
			<div class="form-group form-button">
				<a class="btn btn-delete-all" id="btn_delete" clsTable="Partner" style="display:none">
					{$core->get_Lang('Delete')}
				</a>
			</div>
		</form>
		<div class="fr group_buttons">
			<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-primary btnNew">
				<i class="icon-folder-open icon-white"></i><span> {$core->get_Lang('All')}({$number_all})</span>
			</a>
			<a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-warning btnNew">
				<i class="icon-trash icon-white"></i><span> {$core->get_Lang('Trash')}({$number_trash})</span>
			</a>
		</div>
	</div>
    
	<div class="statistical mb5">
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="50%" align="left">&nbsp;</td>
				<td width="50%" align="right">
					{$core->get_Lang('Record/page')}:
					{$clsISO->getRecordPerPage($recordPerPage|default:0,$totalRecord|default:0,$mod)}
				</td>
			</tr>
		</table>
	</div>
    {if $allItem[0].partner_id eq ''}
    {$core->get_Lang('No data. Click Add New to continue.')}
   
    {else}
    <table cellspacing="0" class="tbl-grid full-width table-striped table_responsive">
		<thead>
			<tr>
				<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
				<th class="gridheader hiden767"><strong>{$core->get_Lang('ID')}</strong></th>
				<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('Title')}</strong></th>
				<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('Path Url')}</strong></th>
				<th class="gridheader hiden_responsive" style="text-align:left;width:60px"><strong>{$core->get_Lang('status')}</strong></th>
				<th class="gridheader hiden_responsive" style="width:60px"><strong>{$core->get_Lang('func')}</strong></th>
			</tr>
		</thead>
        <tbody id="SortAble">
			{section name=i loop=$allItem}
			<tr style="cursor:move" id="order_{$allItem[i].partner_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
				<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].partner_id}" /></th>
				<th class="index hiden767">{$allItem[i].partner_id}</th>
				<td class="name_service">	
					{if $type == 'BC'}
						<a title="Edit" href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&type=BC&partner_id={$core->encryptID($allItem[i].partner_id)}">
						   <strong style="font-size:16px;">{$allItem[i].title}</strong>
						</a>
					{else}
						<a title="Edit" href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&partner_id={$core->encryptID($allItem[i].partner_id)}">
						   <strong style="font-size:16px;">{$allItem[i].title}</strong>
						</a>
					{/if}
					
					{if $allItem[i].is_trash eq 1}<span style="color:#999">[{$core->get_Lang('Trash')}]</span>{/if}
					<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
				</td>
				<td data-title="{$core->get_Lang('Path Url')}" class="block_responsive border_top_responsive">				
					<a href="{$allItem[i].url}" target="_blank">{$allItem[i].url}</a>
				</td>
				<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
					<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Partner" pkey="partner_id" sourse_id="{$allItem[i].partner_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].partner_id)}" title="{$core->get_Lang('Click to change status')}">
						{if $clsClassTable->getOneField('is_online',$allItem[i].partner_id) eq '1'}
						<i class="fa-solid fa-circle-check green"></i>
						{else}
						<i class="fa-solid fa-circle-minus red"></i>
						{/if}
					</a>
				</td>
				<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>

						<ul class="dropdown-menu dropdown-menu-end">

							{assign var=partner_id value=$allItem[i].partner_id}

							{* Build edit link *}
							{if $cat_id eq '0'}
								{assign var=link_edit value="partner/insert/`$partner_id`"}
								{if $type neq ''}{assign var=link_edit value="$link_edit/`$type`"}{/if}
							{else}
								{assign var=link_edit value="partner/insertcat/`$partner_id`"}
								{if $type neq ''}{assign var=link_edit value="$link_edit/`$type`"}{/if}
								{if $cat_id > 0}{assign var=link_edit value="$link_edit/`$cat_id`"}{/if}
							{/if}

							{assign var=link_edit value="$link_edit/overview"}

							{* Fix: Smarty không hỗ trợ toán tử ? :  *}
							{if $type neq ''}
								{assign var=type_url value='&type=BC'}
							{else}
								{assign var=type_url value=''}
							{/if}

							{* Dropdown items *}
							{if $allItem[i].is_trash eq '0'}

								<li>
									<a href="{$PCMS_URL}/{$link_edit}" class="dropdown-item" title="{$core->get_Lang('edit')}">
										<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
									</a>
								</li>

								<li>
									<a href="{$PCMS_URL}/?mod={$mod}&act=trash{$type_url}&partner_id={$core->encryptID($partner_id)}{$pUrl}&page={$currentPage}" class="dropdown-item" title="{$core->get_Lang('trash')}">
										<i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span>
									</a>
								</li>

							{else}

								<li>
									<a href="{$PCMS_URL}/?mod={$mod}&act=restore{$type_url}&partner_id={$core->encryptID($partner_id)}{$pUrl}&page={$currentPage}" class="dropdown-item" title="{$core->get_Lang('restore')}">
										<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
									</a>
								</li>

								<li>
									<a href="{$PCMS_URL}/?mod={$mod}&act=delete&partner_id={$core->encryptID($partner_id)}{$pUrl}&page={$currentPage}" class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}">
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
    {/if}
    <div class="clearfix"><br /></div>
    <div class="clearfix"></div>
	{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber|default:0,$link_page_current,$type)}
</div>
</div>

<script type="text/javascript">
	var $recordPerPage = `{$recordPerPage|default:0}`;
	var $currentPage = `{$currentPage|default:0}`;
</script>
<script type="text/javascript" src="{$URL_THEMES}/partner/jquery.partner.new.js?v={$upd_version}"></script>
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
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListPartner", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}