{assign var=day value=$core->get_Lang('day')}
{assign var=days value=$core->get_Lang('days')}
<link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />

<div id="page_v2" class="page_container tour-list-screen">
    <main class="iso-module-list iso-tours-list">
        {capture name=tour_header_actions}
            {if $clsConfiguration->getValue('ai_tour_enabled') eq '1'}
                <button type="button" class="v2-btn v2-btn--purple btn--ai" id="btn_open_auto_ai_modal" title="{$core->get_Lang('Create with AI')}">
                    <i class="fa fa-magic" aria-hidden="true"></i><span>{$core->get_Lang('Create with AI')}</span>
                </button>
            {/if}
            <a class="v2-btn v2-btn--add {if $is_day_trip|default:'' eq '1'}add_new_day_trip{else}add_new_tour{/if}" title="{$core->get_Lang('Add Tour')}" href="javascript:void(0);">
                <i class="fa fa-plus" aria-hidden="true"></i><span>{$core->get_Lang('Add Tour')}</span>
            </a>
            <div class="v2-dropdown-details">
                <details> 
                    <summary class="v2-btn v2-btn--icon" title="{$core->get_Lang('Setting')}"> 
                        <i class="fa fa-cog" aria-hidden="true"></i>
                    </summary> 
                    <div class="v2-dropdown-menu"> 
                        {if $clsISO->checkConnTMS()}
                            <a class="v2-dropdown-item open_syncTourAPI" syncTourAPI href="javascript:void(0)" title="{$core->get_Lang('Sync Tour from TMS')}">
                                <i class="fa fa-reply-all" aria-hidden="true"></i><span>{$core->get_Lang('Sync Tour from TMS')}</span>
                            </a>
                            <a class="v2-dropdown-item open_syncTourtoTMS" syncTourAPItoTMS href="javascript:void(0)" title="{$core->get_Lang('Sync Tour to TMS')}">
                                <i class="fa fa-share" aria-hidden="true"></i><span>{$core->get_Lang('Sync Tour to TMS')}</span>
                            </a>
                        {/if}
                        {if $package_id==4}
                            <form method="post" action="" style="margin:0;padding:0;">
                                <button type="submit" class="v2-dropdown-item btn-export" id="btn_export">
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i><span>{$core->get_Lang('Export')}</span>
                                </button>
                                <input type="hidden" value="export_tour" name="export_tour" />
                            </form>
                        {/if}
                        <a href="{$PCMS_URL}/?mod={$mod}&act=setting" class="v2-dropdown-item" title="{$core->get_Lang('Setting')}">
                            <i class="fa fa-cog" aria-hidden="true"></i><span>{$core->get_Lang('Setting')}</span>
                        </a>
                    </div> 
                </details>
            </div>
        {/capture}
        {include file="../components/list_v2/header.tpl"
            header_home_label=$core->get_Lang('Dashboard')
            header_module_label=$core->get_Lang('Tours')
            header_title=$core->get_Lang('Tours')
            header_count=$number_all
            header_subtitle=$core->get_Lang('Manage, build and publish your tour products')
            header_actions=$smarty.capture.tour_header_actions
        }

        <section class="v2-filter-panel" aria-label="{$core->get_Lang('filter')}">
            <form id="forums" method="post" class="v2-filter-form" action="" data-auto-filter="true">
                <div class="v2-field v2-search-field">
                    <label class="v2-field-label" for="tour_keyword">{$core->get_Lang('Search')}</label>
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input id="tour_keyword" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('Search tours by name, code, destination')}..." />
                </div>
                <div class="v2-field v2-select-field">
                    <label class="v2-field-label" for="tours_category">{$core->get_Lang('Category')}</label>
                    <select name="cat_id" class="iso-selectbox" data-width="100%" id="tours_category">
                        <option value="0">{$core->get_Lang('All Category')}</option>
                        {$clsTourCat->makeSelectboxOption($tour_group_id, $cat_id, false, false, false)}
                    </select>
                </div>
                <div class="v2-field v2-select-field">
                    <label class="v2-field-label" for="tours_itinerary">{$core->get_Lang('Itinerary')}</label>
                    <select name="number_day" class="iso-selectbox" data-width="100%" id="tours_itinerary">
                        <option value="0">{$core->get_Lang('All Itinerary')}</option>
                        {$clsISO->makeSelectNumber2(30,$number_day,"$day,$days")}
                    </select>
                </div>
                <button type="submit" class="v2-btn v2-btn--primary" id="findtBtn"><i class="fa fa-search" aria-hidden="true"></i>{$core->get_Lang('Search')}</button>
                <a href="{$PCMS_URL}/?mod={$mod}" class="v2-btn v2-btn--neutral"><i class="fa fa-refresh" aria-hidden="true"></i>{$core->get_Lang('Reset')}</a>
                <input type="hidden" name="filter" value="filter" />
                <input type="hidden" name="type_list" value="{$type_list|default:''}" />
            </form>
        </section>

        <div class="v2-toolbar">
            {capture name=tour_status_tabs}
                <a href="{$PCMS_URL}/?mod={$mod}{$pUrl|default:''}&recordperpage={$recordPerPage}" class="v2-status-tab v2-status-tab--primary {if $type_list ne 'Publish' && $type_list ne 'Private' && $type_list ne 'Trash'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('All')} <span>({$number_all|default:0})</span></a>
                <a href="{$PCMS_URL}/?mod={$mod}{$pUrl|default:''}&recordperpage={$recordPerPage}&type_list=Publish" class="v2-status-tab v2-status-tab--success {if $type_list eq 'Publish'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('Published')} <span>({$number_publish|default:0})</span></a>
                <a href="{$PCMS_URL}/?mod={$mod}{$pUrl|default:''}&recordperpage={$recordPerPage}&type_list=Private" class="v2-status-tab v2-status-tab--warning {if $type_list eq 'Private'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('Private')} <span>({$number_private|default:0})</span></a>
                <a href="{$PCMS_URL}/?mod={$mod}{$pUrl|default:''}&recordperpage={$recordPerPage}&type_list=Trash" class="v2-status-tab v2-status-tab--danger {if $type_list eq 'Trash'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('Trash')} <span>({$number_trash|default:0})</span></a>
                <a class="btn-delete-all v2-tabs-delete" id="btn_delete" clsTable="Tour" style="display:none"><i class="fa fa-trash" aria-hidden="true"></i>{$core->get_Lang('Delete')}</a>
            {/capture}
            {include file="../components/list_v2/status_tabs.tpl" status_tabs_label=$core->get_Lang('status') status_tabs_content=$smarty.capture.tour_status_tabs}
            <div class="v2-toolbar__right">
                {capture name=tour_records_query}?mod={$mod}{$pUrl|default:''}{if $type_list}&type_list={$type_list}{/if}{/capture}
                {include file="../components/list_v2/records_per_page.tpl" records_per_page_id="tour_records_per_page"
                    records_per_page_label=$core->get_Lang('Records per page') records_per_page_value=$recordPerPage
                    records_per_page_base_url=$PCMS_URL records_per_page_query=$smarty.capture.tour_records_query}
            </div>
        </div>

        <input id="list_selected_chkitem" type="hidden" value="0" />
        <section class="v2-table-card">
            <div class="v2-table-scroll">
                <table class="v2-table tours-list-table">
                    <thead>
                        <tr>
                            <th class="v2-check-cell list-table-v2-check"><input id="check_all" type="checkbox" class="el-checkbox" aria-label="{$core->get_Lang('Select all')}" /></th>
                            <th class="list-table-v2-image tour-image-column is-center">{$core->get_Lang('Image')}</th>
                            <th class="list-table-v2-name">{$core->get_Lang('Name tour')}</th>
                            <th class="list-table-v2-duration is-center">{$core->get_Lang('Duration')}</th>
                            <th class="list-table-v2-price is-right">{$core->get_Lang('Price')}</th>
                            <th class="list-table-v2-status is-center">{$core->get_Lang('status')}</th>
                            <th class="list-table-v2-action is-center list-table-action-cell">{$core->get_Lang('Action')}</th>
                        </tr>
                    </thead>
                    {if !empty($allItem) && $allItem[0].tour_id ne ''}
                        <tbody id="SortAble" class="sortByTd">
                            {section name=i loop=$allItem}
                                {assign var=tour_id value=$allItem[i].tour_id}
                                {assign var=nameServices value=$clsClassTable->getTitle($tour_id)}
                                <tr id="order_{$tour_id}">
                                    <td class="v2-check-cell list-table-v2-check"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$tour_id}" /></td>
                                    <td class="list-table-v2-image tour-image-cell list-table-media sortable is-center">
                                        <img class="v2-thumbnail list-table-v2-thumb tour-thumb list-table-thumbnail" src="{$clsClassTable->getImage($tour_id,105,69)}" alt="{$nameServices}" onerror="this.onerror=null;this.classList.add('is-placeholder');this.src='{$URL_IMAGES}/none_image.png';" />
                                    </td>
                                    <td class="list-table-v2-name">
                                        <div class="v2-heading-group list-table-v2-wrap tour-name-wrap list-table-heading">
                                            <a class="v2-title-link list-table-v2-title tour-name list-table-link" href="{$PCMS_URL}/tour_iso/edit/{$tour_id}/basic/title-tripcode">
                                                <span class="v2-key list-table-v2-key list-table-key">#{$tour_id}</span> - {$nameServices}
                                            </a>
                                            {if $allItem[i].is_trash eq '1'}<span class="v2-badge v2-badge--danger">{$core->get_Lang('intrash')}</span>{/if}
                                            {if $allItem[i].is_online eq '0' && $allItem[i].is_trash eq '0'}<span class="v2-badge v2-badge--warning status_private">{$core->get_Lang('Private')}</span>{/if}
                                            {if !empty($allItem[i].is_for_agent)}<span class="v2-badge v2-badge--primary">{$core->get_Lang('Agent')}</span>{/if}
                                            {if $clsISO->checkConnTMS() && (!empty($allItem[i].yield_id) || !empty($allItem[i].tms_code))}<span class="v2-badge v2-badge--info">{$core->get_Lang('TravelMaster')}</span>{/if}
                                        </div>
                                        <div class="v2-meta list-table-v2-meta tour-meta list-table-meta">{$core->get_Lang('Created')}: {$clsISO->formatDateTime($allItem[i].reg_date,'d/m/Y H:i',0)} &nbsp;|&nbsp; {$core->get_Lang('Updated')}: {$clsISO->formatDateTime($allItem[i].upd_date,'d/m/Y H:i',0)}</div>
                                    </td>
                                    <td class="list-table-v2-duration is-center">{$clsClassTable->getTripDuration2020($tour_id,'/ ')}</td>
                                    <td class="v2-price is-right">
                                        {assign var="price" value=$clsClassTable->getTripPriceNewPro2020($tour_id, $now_day, 0, 'value')}
                                        {if $price gt 0}
                                            {$clsISO->priceFormat($price)} {$clsISO->getShortRateText()}
                                        {else}
                                            0 {$clsISO->getShortRateText()}
                                        {/if}
                                    </td>
                                    <td class="list-table-v2-status is-center">
                                        {if $allItem[i].is_trash eq 0}
                                            <a href="javascript:void(0);" class="SiteClickPublic list-table-v2-toggle list-table-toggle" clsTable="Tour" pkey="tour_id" sourse_id="{$tour_id}" toField="is_online" rel="{$allItem[i].is_online}" title="{$core->get_Lang('Click to change status')}" aria-label="{$core->get_Lang('Click to change status')}">
                                                <span class="list-table-toggle__track" aria-hidden="true"><span class="list-table-toggle__thumb"></span></span>
                                            </a>
                                        {else}
                                            <span class="v2-badge v2-badge--danger"><i class="fa fa-circle"></i>{$core->get_Lang('Trash')}</span>
                                        {/if}
                                    </td>
                                    <td class="list-table-v2-action is-center list-table-action-cell">
                                        <div class="btn-group">
                                            <button class="v2-action dropdown-toggle list-table-v2-action-btn list-table-action" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{$core->get_Lang('Action')}"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                {if $allItem[i].is_trash eq '0'}
                                                    <li><a class="dropdown-item" href="{$DOMAIN_NAME}{$clsClassTable->getLink($tour_id)}" target="_blank"><i class="fa fa-eye"></i> {$core->get_Lang('view')}</a></li>
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/tour_iso/edit/{$tour_id}/basic/title-tripcode"><i class="fa fa-edit"></i> {$core->get_Lang('edit')}</a></li>
                                                    <li><a class="dropdown-item ajDuplicateTour" id="btnClone" data-name_services="{$nameServices}" tour_id="{$tour_id}" href="javascript:void(0);" data-confirm="{$core->get_Lang('Are you sure to duplicate this tour')}"><i class="fa fa-copy"></i> {$core->get_Lang('Clone')}</a></li>
                                                    <li><a class="dropdown-item" title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&tour_id={$core->encryptID($tour_id)}{$pUrl|default:''}&page={$currentPage}"><i class="fa fa-trash"></i> {$core->get_Lang('trash')}</a></li>
                                                {else}
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/tour_iso/edit/{$tour_id}/basic/title-tripcode"><i class="fa fa-edit"></i> {$core->get_Lang('edit')}</a></li>
                                                    <li><a class="dropdown-item" title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&tour_id={$core->encryptID($tour_id)}{$pUrl|default:''}&page={$currentPage}"><i class="fa fa-refresh"></i> {$core->get_Lang('restore')}</a></li>
                                                    <li><a class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act=delete&tour_id={$core->encryptID($tour_id)}{$pUrl|default:''}&page={$currentPage}"><i class="fa fa-remove"></i> {$core->get_Lang('delete')}</a></li>
                                                {/if}
                                                {if $clsISO->checkConnTMS() && (!empty($allItem[i].yield_id) || !empty($allItem[i].tms_code))}
                                                     <li><a class="dropdown-item" title="{$core->get_Lang('syncTourAPIfromTMS')}" href="{$PCMS_URL}/?mod={$mod}&act=syncOneTourAPI&yield_id={$core->encryptID($allItem[i].yield_id)}&tour_id={$core->encryptID($allItem[i].tour_id)}"><i class="fa fa-share"></i> {$core->get_Lang('syncTourAPIfromTMS')}</a></li>
                                                {/if}
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            {/section}
                        </tbody>
                    {else}
                        <tbody><tr><td colspan="7" class="v2-table-empty"><i class="fa fa-inbox" aria-hidden="true"></i><span>{$core->get_Lang('nodata')}!</span></td></tr></tbody>
                    {/if}
                </table>
            </div>
            {include file="../components/list_v2/pagination.tpl"
                pagination_showing_label=$core->get_Lang('Showing')
                pagination_showing_start=$showingStart
                pagination_showing_end=$showingEnd
                pagination_of_label=$core->get_Lang('of')
                pagination_total_records=$totalRecord
                pagination_entity_label=$core->get_Lang('tours')
                pagination_total_pages=$totalPage
                pagination_current_page=$currentPage
                pagination_previous_page=$previousPage
                pagination_next_page=$nextPage
                pagination_pages=$listPageNumber
                pagination_base_url=$PCMS_URL
                pagination_page_query=$link_page_current
                pagination_label=$core->get_Lang('pagination')
                pagination_previous_label=$core->get_Lang('Previous')
                pagination_next_label=$core->get_Lang('Next')}
        </section>
    </main>
</div>

{if $clsConfiguration->getValue('ai_tour_enabled') eq '1'}
{$clsISO->getTemplate('aiconfig/modal_auto_ai_import.tpl')}
{/if}

<script type="text/javascript">
    var $boxID = "";
    var $tour_group_id = '{$tour_group_id|default:0}';
    var $tour_type_id = '{$tour_type_id|default:0}';
    var $cat_id = '{$cat_id|default:0}';
    var $city_id = '{$city_id|default:0}';
    var $departure_point_id = '{$departure_point_id|default:0}';
    var $is_set = '{$is_set|default:0}';
    var $recordPerPage = '{$recordPerPage|default:20}';
    var $currentPage = '{$currentPage|default:1}';
    var $listcatID = '';
    var confirm_dup = '{$core->get_Lang("Are you sure to duplicate this tour")}';
</script>
{literal}
<script type="text/javascript">
    $(document).ready(function() {
        if (typeof $.fn.sortable !== 'undefined') {
            $("#SortAble").sortable({
                opacity: 0.8,
                cursor: 'move',
                start: function(){
                    if (typeof vietiso_loading === 'function') vietiso_loading(1);
                },
                stop: function(){
                    if (typeof vietiso_loading === 'function') vietiso_loading(0);
                },
                update: function(){
                    var recordPerPage = $recordPerPage;
                    var currentPage = $currentPage;
                    var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage;
                    $.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortTour", order,
                    function(html){
                        if (typeof vietiso_loading === 'function') vietiso_loading(0);
                        location.href = path_ajax_script + '/index.php?mod=' + mod;
                    });
                }
            });
        }

        $(document).on('click', '.add_new_tour:not(.disabled), .add_new_day_trip:not(.disabled)', function (ev) {
            ev.preventDefault();
            var $_this = $(this);
            $_this.addClass('disabled');
            if (typeof vietiso_loading === 'function') vietiso_loading(1);
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajActionNewTour',
                data: {
                    'tp': 'S',
                    'is_day_trip': $_this.hasClass('add_new_day_trip') ? 1 : 0
                },
                dataType: "json",
                success: function(json) {
                    if (typeof vietiso_loading === 'function') vietiso_loading(0);
                    if (json.result == 'success' || json.result == '_SUCCESS') {
                        window.location.href = json.link;
                    } else {
                        $_this.removeClass('disabled');
                    }
                },
                error: function() {
                    if (typeof vietiso_loading === 'function') vietiso_loading(0);
                    $_this.removeClass('disabled');
                }
            });
        });
    });
</script>
{/literal}
