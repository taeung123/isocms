<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('whymanagement')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('whymanagement')} <a class="btn btn-success btnCreateNewWhy" href="javascript:void();" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
		<p>{$core->get_Lang('This system allows you to manage & amp; edit static pages in Systems')}</p>
    </div>
	<div class="clearfix"><br /></div>
	<div class="hastable">
    	<form id="forums" method="post" action="" name="filter" class="filterForm">
            <div class="filterbox filterbox-border" style="width:100%">
                <div class="wrap">
                    <div class="searchbox">
                        <input type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
                        <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
                            <i class="icon-search"></i>
                        </a>
                    </div>
                </div>
            </div>
            <input type="hidden" name="filter" value="filter" />
        </form>
		<table width="100%" cellspacing="0" class="tbl-grid">
			<tr>
				<td class="gridheader" style="width:4%;text-align:left; "><strong>{$core->get_Lang('index')}</strong></td>
				<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
                <td class="gridheader" style="width:6%"><strong>{$core->get_Lang('status')}</strong></td>
                <td class="gridheader" colspan="4" style="width:3%"><strong>{$core->get_Lang('move')}</strong></td>
				<td class="gridheader" style="width:6%;text-align:center; "><strong>{$core->get_Lang('func')}</strong></td>
			</tr>
			{if $allItem[0].why_id ne ''}
			{section name=i loop=$allItem}
			<tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
				<td class="index">{$smarty.section.i.iteration}</td>
				<td><strong class="title">{$clsClassTable->getTitle($allItem[i].why_id)}</strong></td>
                <td style="text-align:center">
                    <a href="javascript:void(0);" class="SiteClickPublic" clsTable="Why" pkey="why_id" sourse_id="{$allItem[i].why_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].why_id)}" title="{$core->get_Lang('Click to change status')}">
                        {if $clsClassTable->getOneField('is_online',$allItem[i].why_id) eq '1'}
                        <i class="fa-solid fa-circle-check green"></i>
                        {else}
                        <i class="fa-solid fa-circle-minus red"></i>
                        {/if}
                    </a>
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.first}
                    <a title="{$core->get_Lang('movetop')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movetop&why_id={$allItem[i].why_id}"><i class="icon-circle-arrow-up"></i></a>
                    {/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.last}
                    <a title="{$core->get_Lang('movebottom')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movebottom&why_id={$allItem[i].why_id}"><i class="icon-circle-arrow-down"></i></a>
                    {/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.first}
                    <a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=moveup&why_id={$allItem[i].why_id}"><i class="icon-arrow-up"></i></a>
                    {/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.last}
                    <a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movedown&why_id={$allItem[i].why_id}"><i class="icon-arrow-down"></i></a>
                    {/if}
                </td>
				<td style="vertical-align: middle; width: 40px; text-align: center; white-space: nowrap;">
					<div class="btn-group">
                        <button class="btn iso-button-standard dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon-cog"></i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item btnEditWhy" title="{$core->get_Lang('edit')}" href="javascript:void(0);" data="{$allItem[i].why_id}">
                                    <i class="icon-edit"></i> {$core->get_Lang('edit')}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act=why&action=Delete&why_id={$allItem[i].why_id}{$pUrl}">
                                    <i class="icon-remove"></i> {$core->get_Lang('delete')}
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
			</tr>	
			{/section}
			{else}<tr><td colspan="10" style="text-align:center">{$core->get_Lang('nodata')}</td></tr>{/if}
		</table>
		<div class="clearfix" style="height:5px"></div>
            <div class="pagination_box">
            <div class="wrap holderEvent_tbl" id="dataTable_paginate" style="min-height:16px">
            <!-- Ajax Loading pagination -->
            </div>
        </div>
	</div>
</div>
<script type="text/javascript" src="{$URL_THEMES}/page/jquery.page.js?v={$upd_version}"></script>