<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    {if $clsConfiguration->getValue('SiteModActive_continent')}
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/?mod={$mod}&continent_id={$continent_id}" title="{$mod}">{$clsContinent->getTitle($continent_id)}</a>
    {/if}
    <a>&raquo;</a>
    <a href="javascript:void(0)" title="{$mod}">{$core->get_Lang('country')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
{if $msg eq 'DeleteFailed'}
<div style="padding:15px; padding-top:0;">
	<div style="padding:10px; background:red; color:#fff; font-size:14px; text-align:center; "><img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" />
<strong>{$core->get_Lang('Warning')}:</strong> {$core->get_Lang('exitscityofcountry')}
</div>
</div>
<div class="clearfix"></div>
{/if}
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Nationality')} <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
		{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)}</p>
		{/if}
    </div>
	<div class="clearfix"><br /></div>
    <div class="wrap">
        <form id="forums" method="post" action="" name="filter" class="filterForm">
           <div class="filterbox">
                <div class="wrap">
                    <div class="searchbox">
                        {if $lstContinent && $clsConfiguration->getValue('SiteModActive_continent') && $core->checkAccess('continent')}
                        <select onchange="_reload();" name="continent_id" class="slb mr5 fl" style="padding:5px;">
                            <option value="">-- {$core->get_Lang('Select Continent')} --</option>
                            {section name=i loop=$lstContinent}
                            <option {if $continent_id eq $lstContinent[i].continent_id}selected="selected"{/if} value="{$lstContinent[i].continent_id}">{$clsContinent->getTitle($lstContinent[i].continent_id)}</option>
                            {/section}
                        </select>
                        {/if}
                        <input type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
                        <a class="btn btn-success" href="javascript:void();" id="searchbtn" style=" padding:5px">
                            <i class="icon-search icon-white"></i>
                        </a>
                        <a  style="display:none" href="{$PCMS_URL}/?mod={$mod}&act=setting" class="btn btn-danger" title="{$core->get_Lang('settings')}"><i class="icon-cog icon-white"></i> <span>{$core->get_Lang('settings')}</span> </a>
                    </div>
                    <div class="fr group_buttons">
                        <a href="{$PCMS_URL}/?mod={$mod}{$pUrl}" class="btn btn-warning"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
                        <a href="{$PCMS_URL}/?mod={$mod}{$pUrl}&type_list=Trash" class="btn btn-danger"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="_Country" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                    </div>
                </div>
            </div>
            <input type="hidden" name="filter" value="filter" />
        </form>
        <input id="list_selected_chkitem" style="display:none" value="0" />
        <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
            <tr>
                <td class="gridheader"><input id="check_all" type="checkbox" /></td>
                <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('nameofcountry')}</strong></td>
                <td class="gridheader"><strong>{$core->get_Lang('func')}</strong></td>
            </tr>
            <tbody id="tbl_sys_country">
                {section name=i loop=$allItem}
                <tr style="cursor:move" id="order_{$allItem[i].country_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                    <td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].country_id}" /></td>
                    <td>
                       {$clsClassTable->getTitle($allItem[i].country_id)}
                       {if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
                    </td>
                    <td style="vertical-align: middle; width: 10px; text-align:left; white-space: nowrap;">
                        <div class="btn-group">
                            <button class="btn btn_dropdown dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                {if $allItem[i].is_trash eq '0'}
                                {*<li>
                                    <a class="dropdown-item"
                                    title="{$core->get_Lang('view')}"
                                    target="_blank"
                                    href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].country_id)}">
                                        <i class="icon-eye-open"></i> {$core->get_Lang('view')}
                                    </a>
                                </li>*}

                                <li>
                                    <a class="dropdown-item"
                                    title="{$core->get_Lang('edit')}"
                                    href="{$PCMS_URL}/?mod={$mod}&act=edit&country_id={$core->encryptID($allItem[i].country_id)}{$pUrl}">
                                        <i class="icon-edit"></i> {$core->get_Lang('edit')}
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item"
                                    title="{$core->get_Lang('trash')}"
                                    href="{$PCMS_URL}/?mod={$mod}&act=trash&country_id={$core->encryptID($allItem[i].country_id)}{$pUrl}&page={$currentPage}">
                                        <i class="icon-trash"></i> {$core->get_Lang('trash')}
                                    </a>
                                </li>

                                {else}

                                <li>
                                    <a class="dropdown-item"
                                    title="{$core->get_Lang('restore')}"
                                    href="{$PCMS_URL}/?mod={$mod}&act=restore&country_id={$core->encryptID($allItem[i].country_id)}{$pUrl}&page={$currentPage}">
                                        <i class="icon-refresh"></i> {$core->get_Lang('restore')}
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item"
                                    title="{$core->get_Lang('delete')}"
                                    href="{$PCMS_URL}/?mod={$mod}&act=delete&country_id={$core->encryptID($allItem[i].country_id)}{$pUrl}&page={$currentPage}">
                                        <i class="icon-remove"></i> {$core->get_Lang('delete')}
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
        <div class="adminPaging">
            <ul class="lstAdminPaging">
                {section name=i loop=$listPageNumber}
                <li><a href="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}" {if $listPageNumber[i] eq $currentPage}class="active"{/if}>{$listPageNumber[i]}</a>
                </li>
                {/section}
            </ul>
            <div class="report">
                <strong>{$core->get_Lang('statistical')}</strong>: <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong>.
            </div>
        </div>
	</div>
</div>

<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
{literal}
<script type="text/javascript">
	$("#tbl_sys_country").sortable({
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
			$.post(path_ajax_script+"/index.php?mod=country&act=ajUpdPosSortCountry", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}