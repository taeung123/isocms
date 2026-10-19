<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('download')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('download')} <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit{$pUrl|default:''}" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        <div class="permalinkbox mb30">
            <div class="wrap permalink_show">
                <strong><a href="{$DOMAIN_NAME}{$clsISO->getLink('sale_tool')}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> {$DOMAIN_NAME}{$clsISO->getLink('sale_tool')}</a></strong>
            </div>
        </div>
		<p>Chức năng quản lý danh sách các File Download trong hệ thống isoCMS</p>
		<p>{$core->get_Lang('This function is intended to manage File Download in isoCMS system')}</p>
    </div>
    <div class="clearfix"><br /></div>
    <form id="forums" method="post" action="" name="filter" class="filterForm">
        <div class="filterbox filterbox-border" style="width:100%">
            <div class="wrap">
                <div class="searchbox">
                    <input type="text" class="text search_keyword" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}" />
                    <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
                        <i class="icon-search icon-white"></i>
                    </a>
                </div>
                <div class="fr group_buttons mt10_767">
                    <a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
                    <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Download" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                </div>
            </div>
        </div>
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
					{$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod)}
				</td>
			</tr>
		</table>
	</div>
    <table cellspacing="0" class="tbl-grid full-width table-striped table_responsive">
		<thead>
			 <tr>
				<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
				<th class="gridheader hiden767" style="width:60px"><strong>{$core->get_Lang('ID')}</strong></th>
				<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('File name')}</strong></th>
				<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('Tour mapping')}</strong></th>
				<th class="gridheader hiden_responsive" style="width:60px;"><strong>{$core->get_Lang('status')}</strong></th>
				<th class="gridheader hiden_responsive" style="width:120px; text-align:right"><strong>{$core->get_Lang('update')}</strong></th>
				<th class="gridheader hiden_responsive" style="width:70px"><strong>{$core->get_Lang('func')}</strong></th>
			</tr>
		</thead>
        <tbody id="SortAble">
			{section name=i loop=$allItem}
			<tr style="cursor:move" id="order_{$allItem[i].download_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
				<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].download_id}" /></th>
				<th class="index hiden767">{$allItem[i].download_id}</th>
				<td class="name_service">
					<a href="{$PCMS_URL}/?mod={$mod}&act=edit&download_id={$core->encryptID($allItem[i].download_id)}" class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].download_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].download_id)}</a>
					{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
					<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
				</td>
				<td>
					{if !empty($allItem[i].tour_id)}<span class="btn_sale_agent">{$core->get_Lang('Tour')}</span>{/if}
				</td>
				<td data-title="{$core->get_Lang('status')}" class="block_responsive border_top_responsive" style="text-align:center">
					<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Download" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
						{if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}
						<i class="fa-solid fa-circle-check green"></i>
						{else}
						<i class="fa-solid fa-circle-minus red"></i>
						{/if}
					</a>
				</td>
				<td data-title="{$core->get_Lang('update')}" class="block_responsive" style="text-align:right">{$allItem[i].upd_date|date_format:"%d/%m/%Y %H:%M"}</td>
				<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>
						<ul class="dropdown-menu" style="right:0px !important">
							{if $allItem[i].is_trash eq '0'}
								<li>
									<a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod={$mod}&act=edit&download_id={$core->encryptID($allItem[i].download_id)}">
										<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
									</a>
								</li>
								<li>
									<a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&download_id={$core->encryptID($allItem[i].download_id)}{$pUrl|default:''}">
										<i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span>
									</a>
								</li>
							{else}
								<li>
									<a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&download_id={$core->encryptID($allItem[i].download_id)}{$pUrl|default:''}">
										<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
									</a>
								</li>
								<li>
									<a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&download_id={$core->encryptID($allItem[i].download_id)}{$pUrl|default:''}">
										<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
									</a>
								</li>
							{/if}
							{if $clsConfiguration->getValue('SiteHasDuplicate_News')}
								<li>
									<a title="{$core->get_Lang('duplicate')}" class="ajDuplicateNews" download_id="{$allItem[i].download_id}">
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
	{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type|default:'')}
</div>
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
{literal}
	<style>
		.btn_sale_agent {
			color: #fff;
			background-color: #18BABD;
			border: 12px;
			border-radius: 80px;
			padding: 4px 8px;
			font-size: 14px;
			font-style: normal;
			font-weight: 400;
			line-height: normal;
			margin-top: 6px;
			display: inline-block;
		}
	</style>
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
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListDownload", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/news/jquery.news.js"></script>