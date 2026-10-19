<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('science')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('science')} <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
		<div class="permalinkbox mb20">
            <div class="wrap permalink_show">
                <strong><a href="{$DOMAIN_NAME}{$clsISO->getLink($mod)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> {$DOMAIN_NAME}{$clsISO->getLink($mod)}</a></strong>
            </div>
        </div>
        <p>Chức năng quản lý danh sách các Science trong hệ thống isoCMS</p>
		<p>{$core->get_Lang('This function is intended to manage Science in isoCMS system')}</p>
    </div>
    <div class="clearfix"><br /></div>
    <form id="forums" method="post" action="" name="filter" class="filterForm">
		{if $_loged_id eq 1}
		{$core->getBlock('filter_post_by_ctv')}
		{else}
        <div class="filterbox filterbox-border" style="width:100%">
            <div class="wrap">
                <div class="searchbox">
                    {if $clsConfiguration->getValue('SiteHasCat_Science') eq 1}
                    <select name="sciencecat_id" onchange="_reload()" class="slb mr5 fl" style="padding:5px;">
                        {$clsScienceCategory->makeSelectboxOption($sciencecat_id)}
                    </select>
                    {/if}
                    <input type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
                    <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
                        <i class="icon-search icon-white"></i>
                    </a>
                </div>
                <div class="fr group_buttons">
					{if $clsConfiguration->getValue('SiteHasCat_Science') && $_user_group_id ne 5}
					<a href="{$PCMS_URL}/?mod={$mod}&act=category" class="btn btn-green" title="{$core->get_Lang('Category')}"><i class="icon-list icon-white"></i> <span>{$core->get_Lang('Category')}</span> </a>
					{/if}
					
                    <a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
                    <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
					{if $_user_group_id ne '5'}
					<a href="{$PCMS_URL}/?mod={$mod}&act=setting" class="btn btn-green" title="{$core->get_Lang('Setting')}"><i class="icon-cog icon-white"></i> <span>{$core->get_Lang('Setting')}</span> </a> 
					<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Science" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
					{/if}
                   
                </div>
            </div>
        </div>
		{/if}
        <input type="hidden" name="filter" value="filter" />
    </form>
    <input id="list_selected_chkitem" style="display:none" value="0" />
    <div class="clearfix"></div>
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
    <table cellspacing="0" class="tbl-grid full-width table-striped table_responsive">
		<thead>
			<tr>
				<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
				<th class="gridheader hiden767" style="width:60px"><strong>{$core->get_Lang('ID')}</strong></th>
				<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('titleofarticle')}</strong></th>
				{if $clsConfiguration->getValue('SiteHasCat_Science') eq 1}
				<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('category')}</strong></th>
				{/if}
				{if $_loged_id eq 1 || $_user_group_id eq 5}
				<td class="gridheader" style="width:10%"><strong>{$core->get_Lang('Approved')}</strong></td>
				{/if}
				<th class="gridheader hiden_responsive" style="width:60px;"><strong>{$core->get_Lang('status')}</strong></th>
				<th class="gridheader hiden_responsive" style="width:120px; text-align:right"><strong>{$core->get_Lang('update')}</strong></th>
				<th class="gridheader hiden_responsive" style="width:70px"><strong>{$core->get_Lang('func')}</strong></th>
			</tr>
		</thead>
        <tbody id="SortAble">
			{section name=i loop=$allItem}
			<tr style="cursor:move" id="order_{$allItem[i].science_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
				<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].science_id}" /></th>
				<th class="index hiden767">{$allItem[i].science_id}</th>
				<td class="name_service">
					<strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].science_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].science_id)}</strong>
					{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
					<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
				</td>
				{if $clsConfiguration->getValue('SiteHasCat_Science') eq 1}
				<td data-title="{$core->get_Lang('category')}" class="block_responsive border_top_responsive"><a href="{$PCMS_URL}/index.php?admin&mod={$mod}&sciencecat_id={$allItem[i].sciencecat_id}">
					<i class="fa fa-folder-open"></i> {$clsScienceCategory->getTitle($allItem[i].sciencecat_id)}</a>
				</td>
				{/if}
				{if $_loged_id eq 1 || $_user_group_id eq 5}
				<td style="text-align:center">
					<a href="javascript:void(0);" {if $_loged_id eq 1}class="SiteClickPublic"{/if} clsTable="Blog" pkey="blog_id" toField="is_approve" sourse_id="{$allItem[i].blog_id}" rel="{$clsClassTable->getOneField('is_approve',$allItem[i].blog_id)}" title="{$core->get_Lang('Click to change status')}"> {if $allItem[i].is_approve eq '1'}<i class="fa-solid fa-circle-check green"></i>{else}<i class="fa-solid fa-circle-minus red"></i>{/if}</a>
				</td>
				{/if}
				<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
					<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Science" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
						{if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}
						<i class="fa-solid fa-circle-check green"></i>
						{else}
						<i class="fa-solid fa-circle-minus red"></i>
						{/if}
					</a>
				</td>
				<td data-title="{$core->get_Lang('update')}" class="block_responsive" style="text-align:right">{$allItem[i].reg_date|date_format:"%d/%m/%Y %H:%M"}</td>
				<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>

						<ul class="dropdown-menu dropdown-menu-end">
							{if $allItem[i].is_trash eq '0'}
								<li>
									<a class="dropdown-item" href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].science_id)}" target="_blank" title="{$core->get_Lang('view')}">
										<i class="icon-eye-open"></i> <span>{$core->get_Lang('view')}</span>
									</a>
								</li>
								<li>
									<a class="dropdown-item" title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod={$mod}&act=edit&science_id={$core->encryptID($allItem[i].science_id)}">
										<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
									</a>
								</li>
								<li>
									<a class="dropdown-item" title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&science_id={$core->encryptID($allItem[i].science_id)}{$pUrl}&page={$currentPage}">
										<i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span>
									</a>
								</li>
							{else}
								<li>
									<a class="dropdown-item" title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&science_id={$core->encryptID($allItem[i].science_id)}{$pUrl}&page={$currentPage}">
										<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
									</a>
								</li>
								<li>
									<a class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act=delete&science_id={$core->encryptID($allItem[i].science_id)}{$pUrl}&page={$currentPage}">
										<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
									</a>
								</li>
							{/if}

							{if $clsConfiguration->getValue('SiteHasDuplicate_Science')}
								<li>
									<a class="dropdown-item ajDuplicateScience" title="{$core->get_Lang('duplicate')}" science_id="{$allItem[i].science_id}">
										<i class="icon-share"></i> <span>{$core->get_Lang('duplicate')}</span>
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
	<div class="cleafix"></div>
	{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
</div>

<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
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
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListScience", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/science/jquery.science.js"></script>