<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')}:</strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('commitsion')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('commitsion')} <a style="margin-left:5px;" class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit{$pUrl}" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        {assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)}</p>
		{/if}
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <strong><a href="{$DOMAIN_NAME}{$clsISO->getLink($mod)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> {$DOMAIN_NAME}{$clsISO->getLink($mod)}</a></strong>
            </div>
        </div>
    </div>
    <div class="clearfix"><br /></div>
    <div class="wrap">
        <form id="forums" method="post" action="" name="filter" class="filterForm">
            <div class=" filterbox" style="width:100%">
                <div class="wrap">
                    <div class="searchbox">
                        {if $clsConfiguration->getValue('SiteHasCat_Abouts')}
                        <select onchange="_reload()" name="aboutcat_id" class="slb">
                            {$clsAboutCategory->makeSelectboxOption($aboutcat_id)}
                        </select>
                        {/if}
                        <input type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
                        <a class="btn btn-success" href="javascript:void();" id="searchbtn" style="padding:5px">
                            <i class="icon-search icon-white"></i>
                        </a>
						<a href="{$PCMS_URL}/?mod={$mod}&act=category" class="btn btn-success" title="{$core->get_Lang('Guide Category')}">
							<i class="icon-upload icon-white"></i> <span>{$core->get_Lang('Search')}</span>
						</a>
                    </div>                   
                </div>
            </div>
            <input type="hidden" name="filter" value="filter" />
        </form>
        <input id="list_selected_chkitem" style="display:none" value="0" />
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
        <div class="clearfix"></div>
        <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
			<tr>
			<td width="40px" style="text-align:center;"><strong>{$core->get_Lang('no')}</strong></td>
			<td style="text-align:left;">{$core->get_Lang('title')}</td>
			<td style="text-align:left;">{$core->get_Lang('explain')}</td>
			<td style="text-align:left;">{$core->get_Lang('code_discount')}</td>
			<td style="text-align:left;">{$core->get_Lang('level_discount')}</td>			
			<td style="text-align:left;">{$core->get_Lang('start_date')}</td>
			<td style="text-align:left;">{$core->get_Lang('end_date')}</td>
			<td style="text-align:left;">{$core->get_Lang('priority')}</td>
			<td></td>
		</tr>		          
            {section name=i loop=$allItem}
                <tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                    <td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].about_id}" /></td>
                    <td class="index">{$smarty.section.i.index+1}</td>
                    <td>
                        <strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].about_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].about_id)}</strong>
                        {if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
                    </td>
                    {if $clsConfiguration->getValue('SiteHasCat_Abouts') eq 1}
                    <td><a href="{$PCMS_URL}/index.php?admin&mod={$mod}&aboutcat_id={$allItem[i].cat_id}">
                        <i class="fa fa-folder-open"></i> {$clsAboutCategory->getTitle($allItem[i].cat_id)}</a>
                    </td>
                    {/if}
                    <td style="text-align:center">
                        <a href="javascript:void(0);" class="SiteClickPublic" clsTable="About" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
                            {if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}
                            <i class="fa-solid fa-circle-check green"></i>
                            {else}
                            <i class="fa-solid fa-circle-minus red"></i>
                            {/if}
                        </a>
                    </td>
                    <td style="text-align:right">{$allItem[i].reg_date|date_format:"%d/%m/%Y %H:%M"}</td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.first}
                        <a title="{$core->get_Lang('movetop')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movetop&about_id={$core->encryptID($allItem[i].about_id)}{$pUrl}"><i class="icon-circle-arrow-up"></i></a>
                        {/if}
                    </td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.last}
                        <a title="{$core->get_Lang('movebottom')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movebottom&about_id={$core->encryptID($allItem[i].about_id)}{$pUrl}"><i class="icon-circle-arrow-down"></i></a>
                        {/if}
                    </td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.first}
                        <a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=moveup&about_id={$core->encryptID($allItem[i].about_id)}{$pUrl}"><i class="icon-arrow-up"></i></a>
                        {/if}
                    </td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.last}
                        <a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movedown&about_id={$core->encryptID($allItem[i].about_id)}{$pUrl}"><i class="icon-arrow-down"></i></a>
                        {/if}
                    </td>
                    <td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                        <div class="btn-group">
                            <button class="btn btn_dropdown dropdown-toggle" type="button" data-toggle="dropdown">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>
                            <ul class="dropdown-menu" style="right:0px !important">
                                {if $allItem[i].is_trash eq '0'}
                                <li><a href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].about_id)}" target="_blank" title="{$core->get_Lang('View')}"><i class="icon-eye-open"></i> <span>{$core->get_Lang('View')}</span></a></li>
                                <li><a title="{$core->get_Lang('Edit')}" href="{$PCMS_URL}/?mod={$mod}&act=edit&about_id={$core->encryptID($allItem[i].about_id)}"><i class="icon-edit"></i> <span>{$core->get_Lang('Edit')}</span></a></li>
                                <li><a title="{$core->get_Lang('Trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&about_id={$core->encryptID($allItem[i].about_id)}{$pUrl}"><i class="icon-trash"></i> <span>{$core->get_Lang('Trash')}</span></a></li>
                                {else}
                                <li><a title="{$core->get_Lang('Refresh')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&about_id={$core->encryptID($allItem[i].about_id)}{$pUrl}"><i class="icon-refresh"></i> <span>{$core->get_Lang('Refresh')}</span></a></li>
                                <li><a title="{$core->get_Lang('Delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&about_id={$core->encryptID($allItem[i].about_id)}{$pUrl}"><i class="icon-remove"></i> <span>{$core->get_Lang('Delete')}</span></a></li>
                                {/if}
                                {if $clsConfiguration->getValue('SiteHasDuplicate_News')}
                                <li><a title="{$core->get_Lang('duplicate')}" class="ajDuplicateAbout" about_id="{$allItem[i].about_id}"><i class="icon-share"></i> <span>{$core->get_Lang('duplicate')}</span></a></li>
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
</div>
<script type="text/javascript" src="{$URL_THEMES}/about/jquery.about.js"></script>