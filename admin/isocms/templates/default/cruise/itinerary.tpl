<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('cruise')}</a>
    <a>&raquo;</a>
    <a href="javascript:void();">{$core->get_Lang('cruiseitinerary')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{$core->get_Lang('cruiseitinerary')} <a style="vertical-align:top" title="{$core->get_Lang('cruise')}" href="{$PCMS_URL}/?mod={$mod}{$link_back}" class="btn iso-corner-all btn-warning fileinput-button"> <i class="icon-chevron-left icon-white"></i> <span>{$core->get_Lang('cruise')}</span></a></h2>
    	<p>{$core->get_Lang('systemmanagementcruiseitinerary')}</p>
    </div>
	<br class="clear" />
	<br class="clear" />
	<form id="forums" method="post" action="" name="filter" class="filterForm">
		<div class="fiterbox wrap" style="width:100%">
			<div class="searchbox">
				<input type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
				<a class="btn btn-success" href="javascript:void();" id="searchbtn" style="padding:4px">
					<i class="icon-search icon-white"></i> <span> {$core->get_Lang('search')}</span>
				</a>
			</div>
			<div class="group_buttons fr">
				<a href="{$PCMS_URL}/?mod={$mod}&act=edit_itinerary{$pUrl}" class="btn btn-success"> <i class="icon-plus icon-white"></i> <span>{$core->get_Lang('add')}</span> </a>
				<a href="{$PCMS_URL}/?mod={$mod}{$pUrl}" class="btn btn-warning"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
				<a href="{$PCMS_URL}/{$link_page_current_2}&type_list=Trash{$pUrl}" class="btn btn-danger"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="CruiseItinerary" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
			</div>
		</div>
        <input type="hidden" name="filter" value="filter" />
	</form>
    <input id="list_selected_chkitem" style="display:none" value="0" />
	<div class="infobox" style="margin-left:0; margin-right:0">
		<b>{$core->get_Lang('warning')}</b><br /> {$core->get_Lang('cruiseitineraryoverview')}
	</div>
	<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
		<tr>
        	<td class="gridheader"><input id="check_all" type="checkbox" /></td>
			<td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
			<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
			<td class="gridheader" colspan="4" style="width:4%"><strong>{$core->get_Lang('move')}</strong></td>
			<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('func')}</strong></td>
		</tr>
		{if $allItem[0].cruise_itinerary_id ne ''}
		{section name=i loop=$allItem}
		<tr class="{cycle values="row1,row2"}">
        	<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].cruise_itinerary_id}" /></td>
			<td class="index">{$smarty.section.i.index+1}</td>
			<td>
				<a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod={$mod}&act=edit_itinerary&cruise_itinerary_id={$core->encryptID($allItem[i].cruise_itinerary_id)}{$pUrl}">
				   <strong style="font-size:16px;">{$clsClassTable->getTitle($allItem[i].cruise_itinerary_id)}</strong>
				</a>
				{if $allItem[i].is_trash eq '1'}<span style="color:#ccc;">{$core->get_Lang('intrash')}</span>{/if}
			</td>
			<td style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.first}
                <a title="{$core->get_Lang('movetop')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Move&direct=movetop&cruise_itinerary_id={$allItem[i].cruise_itinerary_id}{$pUrl}"><i class="icon-circle-arrow-up"></i></a>
                {/if}
            </td>
            <td style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.last}
                <a title="{$core->get_Lang('movebottom')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Move&direct=movebottom&cruise_itinerary_id={$allItem[i].cruise_itinerary_id}{$pUrl}"><i class="icon-circle-arrow-down"></i></a>
                {/if}
            </td>
            <td style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.first}
                <a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Move&direct=moveup&cruise_itinerary_id={$allItem[i].cruise_itinerary_id}{$pUrl}"><i class="icon-arrow-up"></i></a>
                {/if}
            </td>
            <td style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.last}
                <a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Move&direct=movedown&cruise_itinerary_id={$allItem[i].cruise_itinerary_id}{$pUrl}"><i class="icon-arrow-down"></i></a>
                {/if}
            </td>
            <td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                <div class="btn-group">
                    <button class="btn btn_dropdown dropdown-toggle" type="button" data-toggle="dropdown">
						<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
					</button>
                    <ul class="dropdown-menu" style="right:0px !important">
                        {if $allItem[i].is_trash eq '0'}
                        <li><a href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].cruise_itinerary_id)}" target="_blank" title="{$core->get_Lang('view')}"><i class="icon-eye-open"></i> <span>{$core->get_Lang('view')}</span></a></li>
                        <li><a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod={$mod}&act=edit_itinerary&cruise_itinerary_id={$core->encryptID($allItem[i].cruise_itinerary_id)}{$pUrl}"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
                        <li><a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&cruise_itinerary_id={$allItem[i].cruise_itinerary_id}{$pUrl}"><i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span></a></li>
                        {else}
                        <li><a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&cruise_itinerary_id={$allItem[i].cruise_itinerary_id}{$pUrl}"><i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span></a></li>
                        <li><a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&cruise_itinerary_id={$allItem[i].cruise_itinerary_id}{$pUrl}"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
                        {/if}
                    </ul>
                </div>
            </td>
		</tr>
		{/section}
		{else}<tr><td colspan="10">{$core->get_Lang('nodata')}</td></tr>{/if}
	</table>
	<div class="clearfix" style="height:5px"></div>
		<div class="pagination_box">
			<div class="wrap holderEvent_tbl" id="dataTable_paginate" style="min-height:16px">
				<!-- Ajax Loading pagination -->
			</div>
		</div>
	</div>
</div>