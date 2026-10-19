<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('recruit')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('recruit')} <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        {assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
		{/if}
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <strong><a href="{$DOMAIN_NAME}{$clsISO->getLink($mod)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> {$DOMAIN_NAME}{$clsISO->getLink($mod)}</a></strong>
            </div>
        </div>
    </div>
	<div class="clearfix"><br /></div>
    <form id="forums" method="post" action="" name="filter" class="filterForm">
        <div class="ui-action">
           <div class="fl fiterbox" style="width:100%">
                <div class="wrap">
                    <div class="searchbox">
                        <input type="text" class="m-wrap short" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
                        <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
                            <i class="icon-search icon-white"></i>
                        </a>
                        <a href="{$PCMS_URL}/?mod={$mod}&act=setting" class="btn btn-danger" title="{$core->get_Lang('settingrecruit')}"><i class="icon-cog icon-white"></i> <span>{$core->get_Lang('settingrecruit')}</span> </a>
                    </div>
                    <div style="float:right;">
                        <a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')}({$number_all})</span> </a>
                        <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Recruit" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <input id="list_selected_chkitem" style="display:none" value="0" />
    <div class="statistical">
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
    <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
		<thead>
			<tr>
				<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
				<th class="gridheader hiden767"><strong>{$core->get_Lang('index')}</strong></th>
				<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('titleofarticle')}</strong></th>
				<th class="gridheader hiden_responsive" style="width:6%"><strong>{$core->get_Lang('status')}</strong></th>
				<th class="gridheader hiden_responsive" style="width:12%;" align="center"><strong>{$core->get_Lang('update')}</strong></th>
				<th class="gridheader hiden_responsive" colspan="4" style="width:4%"><strong>{$core->get_Lang('move')}</strong></th>
				<th class="gridheader hiden_responsive"><strong>{$core->get_Lang('func')}</strong></th>
			</tr>
		</thead>
        {section name=i loop=$allItem}
        <tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
            <th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].recruit_id}" /></th>
            <th class="index hiden767">{$smarty.section.i.index+1}</th>
            <td class="name_service"><strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].recruit_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].recruit_id)}</strong></td>
            <td class="block_responsive" style="text-align:center">
                <a href="javascript:void(0);" class="SiteClickPublic" clsTable="Recruit" pkey="recruit_id" sourse_id="{$allItem[i].recruit_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].recruit_id)}" title="{$core->get_Lang('Click to change status')}">
                    {if $clsClassTable->getOneField('is_online',$allItem[i].recruit_id) eq '1'}
                    <i class="fa-solid fa-circle-check green"></i>
                    {else}
                    <i class="fa-solid fa-circle-minus red"></i>
                    {/if}
                </a>
            </td>
            <td class="block_responsive" style="text-align:center">{$allItem[i].reg_date|date_format:"%d/%m/%Y %H:%M"}</td>
            <td class="block_responsive" style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.first}
                <a title="{$core->get_Lang('movetop')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movetop&recruit_id={$core->encryptID($allItem[i].recruit_id)}"><i class="icon-circle-arrow-up"></i></a>
                {/if}
            </td>
            <td class="block_responsive" style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.last}
                <a title="{$core->get_Lang('movebottom')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movebottom&recruit_id={$core->encryptID($allItem[i].recruit_id)}"><i class="icon-circle-arrow-down"></i></a>
                {/if}
            </td>
            <td class="block_responsive" style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.first}
                <a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=moveup&recruit_id={$core->encryptID($allItem[i].recruit_id)}"><i class="icon-arrow-up"></i></a>
                {/if}
            </td>
            <td style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.last}
                <a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movedown&recruit_id={$core->encryptID($allItem[i].recruit_id)}"><i class="icon-arrow-down"></i></a>
                {/if}
            </td>
            <td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                <div class="btn-group">
                    <button class="btn btn_dropdown dropdown-toggle" type="button" data-toggle="dropdown">
						<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
					</button>
                    <ul class="dropdown-menu" style="right:0px !important">
                        {if $allItem[i].is_trash eq '0'}
                        <li><a href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].recruit_id)}" target="_blank" title="{$core->get_Lang('View')}"><i class="icon-eye-open"></i> <span>{$core->get_Lang('View')}</span></a></li>
                        <li><a title="{$core->get_Lang('Edit')}" href="{$PCMS_URL}/?mod={$mod}&act=edit&recruit_id={$core->encryptID($allItem[i].recruit_id)}"><i class="icon-edit"></i> <span>{$core->get_Lang('Edit')}</span></a></li>
                        <li><a title="{$core->get_Lang('Trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&recruit_id={$core->encryptID($allItem[i].recruit_id)}{$pUrl}"><i class="icon-trash"></i> <span>{$core->get_Lang('Trash')}</span></a></li>
                        {else}
                        <li><a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&recruit_id={$core->encryptID($allItem[i].recruit_id)}{$pUrl}"><i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span></a></li>
                        <li><a title="{$core->get_Lang('Delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&recruit_id={$core->encryptID($allItem[i].recruit_id)}{$pUrl}"><i class="icon-remove"></i> <span>{$core->get_Lang('Delete')}</span></a></li>
                        {/if}
                    </ul>
                </div>
            </td>
        </tr>
        {/section}
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