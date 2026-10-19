<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('Continent')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
{if $msg eq 'DeleteFailed'}
<div style="padding:15px; padding-top:0;">
	<div style="padding:10px; background:red; color:#fff; font-size:14px; text-align:center; "><img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" />
<strong>{$core->get_Lang('Warning')}:</strong> {$core->get_Lang('exitscountryofcontinents')}
</div>
</div>
<div class="clearfix"></div>
{/if}
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Continent Manage')} <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        {assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)}</p>
		{/if}
    </div>
	<div class="clearfix"><br /></div>
    <form id="forums" method="post" action="" name="filter" class="filterForm">
        <div class="ui-action">
           <div class="fl fiterbox" style="width:100%">
                <div class="wrap">
                    <div class="searchbox">
                        <input type="text" class="m-wrap short" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}" />
                        <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
                            <i class="icon-search icon-white"></i>
                        </a>
{*                        <a href="{$PCMS_URL}/?mod={$mod}&act=setting" class="btn btn-danger" title="{$core->get_Lang('settings')}"><i class="icon-cog icon-white"></i> <span>{$core->get_Lang('settings')}</span> </a>*}
                    </div>
                    <div class="fr group_buttons">
                        <a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
                        <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Continent" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <input id="list_selected_chkitem" style="display:none" value="0" />
    <div class="clearfix"></div>
    <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
        <thead>
        <tr>
        	<td class="gridheader"><input id="check_all" type="checkbox" /></td>
            <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('Continent Name')}</strong></td>
            <td class="gridheader" {if $clsConfiguration->getValue('SiteHasChild_slide')}colspan="2"{/if} style="text-align:left">
                <strong>{$core->get_Lang('stastic')}</strong>
            </td>
			<td class="gridheader" style="width:6%;"><strong>{$core->get_Lang('status')}</strong></td>
            <td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('func')}</strong></td>
        </tr>
        </thead>
        <tbody id="SortAble">
        {section name=i loop=$allItem}
        <tr style="cursor: move" id="order_{$allItem[i].continent_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
        	<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].continent_id}" /></td>
            <td>
            	<strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].continent_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].continent_id)}</strong>
            	{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
            </td>
            <td>
            	<a style="margin-right:15px" href="{$PCMS_URL}/index.php?mod=country&continent_id={$allItem[i].continent_id}">
                	<i class="fa fa-folder-open"></i>  {$core->get_Lang('Contries of Continent')} <strong style="color:#c00000;"> ({$clsClassTable->countCountryInCat($allItem[i].continent_id)})</strong>
                </a>
            </td>
            {if $clsConfiguration->getValue('SiteHasChild_slide')}
            <td>
                <a href="{$PCMS_URL}/index.php?mod=slide&mod_page={$mod}&act_page={$act}&target_id={$allItem[i].$pkeyTable}" title="{$core->get_Lang('listslide')}">
                	<i class="fa fa-folder-open"></i>  {$core->get_Lang('listslide')} <strong style="color:#c00000;">({$clsISO->countTotalSlide($mod,$act,$allItem[i].$pkeyTable)})</strong>
                </a>
            </td>
            {/if}
			<td style="text-align:center">
				<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Continent" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
					{if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}
					<i class="fa-solid fa-circle-check green"></i>
					{else}
					<i class="fa-solid fa-circle-minus red"></i>
					{/if}
				</a>
			</td>
            <td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                <div class="btn-group">
                    <button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        {if $allItem[i].is_trash eq '0'}
                            <li>
                                <a title="{$core->get_Lang('edit')}" 
                                href="{$PCMS_URL}/?mod={$mod}&act=edit&continent_id={$core->encryptID($allItem[i].continent_id)}" 
                                class="dropdown-item">
                                <i class="icon-edit"></i> <span>{$core->get_Lang('Edit')}</span>
                                </a>
                            </li>
                            <li>
                                <a title="{$core->get_Lang('trash')}" 
                                href="{$PCMS_URL}/?mod={$mod}&act=trash&continent_id={$core->encryptID($allItem[i].continent_id)}{$pUrl|default:''}" 
                                class="dropdown-item">
                                <i class="icon-trash"></i> <span>{$core->get_Lang('Trash')}</span>
                                </a>
                            </li>
                        {else}
                            <li>
                                <a title="{$core->get_Lang('restore')}" 
                                href="{$PCMS_URL}/?mod={$mod}&act=restore&continent_id={$core->encryptID($allItem[i].continent_id)}{$pUrl|default:''}" 
                                class="dropdown-item">
                                <i class="icon-refresh"></i> <span>{$core->get_Lang('Refresh')}</span>
                                </a>
                            </li>
                            <li>
                                <a title="{$core->get_Lang('delete')}" 
                                class="confirm_delete dropdown-item" 
                                href="{$PCMS_URL}/?mod={$mod}&act=delete&continent_id={$core->encryptID($allItem[i].continent_id)}{$pUrl|default:''}">
                                <i class="icon-remove"></i> <span>{$core->get_Lang('Delete')}</span>
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
            <li>
                <a href="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}" {if $listPageNumber[i] eq $currentPage}class="active"{/if}>{$listPageNumber[i]}</a>
            </li>
        {/section}
        </ul>
        <div class="report">
            <strong>{$core->get_Lang('statistical')}</strong>: <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong>.
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
            items: 'tr',
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
                $.post(path_ajax_script+"/index.php?mod=continent&act=ajUpdPosSortContinent", order,
                    function(html){
                        vietiso_loading(0);
                        // window.location.reload(true);
                    });
            }
        });
    </script>
{/literal}