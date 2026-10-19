<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('onlinesupport')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('onlinesupport')} <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        <p>Chức năng quản lý danh sách các {$core->get_Lang('onlinesupport')} trong hệ thống isoCMS</p>
		<p>{$core->get_Lang('This function is intended to manage Online Support in isoCMS system')}</p>
    </div>
	<div class="clearfix"><br /></div>
    <div class="wrap">
        <form id="forums" method="post" action="" name="filter" class="filterForm">
            <div class="ui-action">
               <div class="fl fiterbox" style="width:100%">
                    <div class="wrap">
                        <div class="searchbox">
                            <input type="text" class="m-wrap short search_keyword" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
                            <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
                                <i class="icon-search icon-white"></i>
                            </a>
                        </div>
                        <div class="mt10_767" style="float:right;">
                            <a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
                            <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="OnlineSupport" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="filter" value="filter" />
        </form>
        <div class="clearfix"></div>
        <input id="list_selected_chkitem" style="display:none" value="0" />
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
        <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
			<thead>
				<tr>
					<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
					<th class="gridheader hiden767"><strong>{$core->get_Lang('index')}</strong></th>
					<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></th>
					<th class="gridheader hiden_responsive" style="width:12%;" align="center"><strong>{$core->get_Lang('nick')}</strong></th>
					<th class="gridheader hiden_responsive" style="width:12%;" align="center"><strong>{$core->get_Lang('type')}</strong></th>
					<th class="gridheader hiden_responsive" style="width:6%"><strong>{$core->get_Lang('status')}</strong></th>
					<th class="gridheader hiden_responsive"><strong>{$core->get_Lang('func')}</strong></th>
				</tr>
			</thead>
			<tbody id="SortAble">
            {section name=i loop=$allItem}
            <tr style="cursor:move" id="order_{$allItem[i].online_support_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                <th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].online_support_id}" /></th>
                <th class="index hiden767">{$smarty.section.i.index+1}</th>
                <td class="name_service">
					<strong class="title" title="{if $clsClassTable->getOneField('is_online',$allItem[i].online_support_id) eq 0}{$core->get_Lang('PRIVATE')}{/if}">{$clsClassTable->getTitle($allItem[i].online_support_id)}</strong>
                {if $clsClassTable->getOneField('is_online',$allItem[i].online_support_id) eq 0}<span style="color:red;" title="{$core->get_Lang('PRIVATE')}">[P]</span>{/if}
                    {if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
					<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
                </td>
                <td data-title="{$core->get_Lang('nick')}" class="block_responsive border_top_responsive" style="text-align:center">{$clsClassTable->getNick($allItem[i].online_support_id)}</td>
                <td data-title="{$core->get_Lang('type')}" class="block_responsive" style="text-align:center">{$clsClassTable->getNameType($allItem[i].online_support_id)}</td>
                <td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
                    <a href="javascript:void(0);" class="SiteClickPublic" clsTable="OnlineSupport" pkey="online_support_id" sourse_id="{$allItem[i].online_support_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].online_support_id)}" title="{$core->get_Lang('Click to change status')}">
                        {if $clsClassTable->getOneField('is_online',$allItem[i].online_support_id) eq '1'}
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
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            {if $allItem[i].is_trash eq '0'}

                            <li>
                                <a class="dropdown-item"
                                title="{$core->get_Lang('edit')}"
                                href="{$PCMS_URL}/?mod={$mod}&act=edit&online_support_id={$core->encryptID($allItem[i].online_support_id)}">
                                    <i class="icon-edit"></i>
                                    <span>{$core->get_Lang('edit')}</span>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                title="{$core->get_Lang('trash')}"
                                href="{$PCMS_URL}/?mod={$mod}&act=trash&online_support_id={$core->encryptID($allItem[i].online_support_id)}{$pUrl}">
                                    <i class="icon-trash"></i>
                                    <span>{$core->get_Lang('trash')}</span>
                                </a>
                            </li>

                            {else}

                            <li>
                                <a class="dropdown-item"
                                title="{$core->get_Lang('restore')}"
                                href="{$PCMS_URL}/?mod={$mod}&act=restore&online_support_id={$core->encryptID($allItem[i].online_support_id)}{$pUrl}">
                                    <i class="icon-refresh"></i>
                                    <span>{$core->get_Lang('restore')}</span>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item confirm_delete"
                                title="{$core->get_Lang('delete')}"
                                href="{$PCMS_URL}/?mod={$mod}&act=delete&online_support_id={$core->encryptID($allItem[i].online_support_id)}{$pUrl}">
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
			</tbody>
        </table>
        <div class="statistical mt5">
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td width="50%" align="left">{$core->get_Lang('statistical')} <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
					<td width="50%" align="right">
						{$core->get_Lang('gotopage')}:
						<select name="page" onchange="window.location = this.options[this.selectedIndex].value">
							{section name=i loop=$listPageNumber}
							<option {if $listPageNumber[i] eq $currentPage}selected="selected"{/if} value="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}">{$listPageNumber[i]}</option>
							{/section}
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
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
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListOnlineSupport", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}