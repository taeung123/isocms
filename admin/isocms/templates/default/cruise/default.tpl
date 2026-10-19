<link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />

<div id="page_v2" class="page_container">
    <main class="iso-module-list iso-cruises-list">
        {capture name=cruise_header_actions}
            <button type="button" class="v2-btn v2-btn--add createNewCruise" title="{$core->get_Lang('Add cruise')}">
                <i class="fa fa-plus" aria-hidden="true"></i><span>{$core->get_Lang('Add cruise')}</span>
            </button>
        {/capture}
        {capture name=cruise_header_setting_url}{$PCMS_URL}/?mod={$mod}&act=setting{/capture}
        {include file="../components/list_v2/header.tpl"
            header_home_label=$core->get_Lang('Dashboard')
            header_module_label=$core->get_Lang('Cruises')
            header_title=$core->get_Lang('Cruises')
            header_count=$number_all
            header_subtitle=$core->get_Lang('Manage, build and publish your cruise products')
            header_actions=$smarty.capture.cruise_header_actions
            header_setting_url=$smarty.capture.cruise_header_setting_url
            header_setting_label=$core->get_Lang('Setting')
        }

        <section class="booking-filter-panel v2-filter-panel" aria-label="{$core->get_Lang('filter')}">
            <form id="forums" method="post" class="booking-filter-form" action="" data-auto-filter="true">
                <div class="booking-field booking-search-field v2-field">
                    <label class="booking-field-label v2-field-label" for="cruise_keyword">{$core->get_Lang('Search')}</label>
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input id="cruise_keyword" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('Search cruise name')}..." />
                </div>
                <div class="booking-field booking-select-field v2-field">
                    <label class="booking-field-label v2-field-label" for="cruise_category">{$core->get_Lang('Cruise Class')}</label>
                    <select name="cruise_cat_id" class="iso-selectbox" data-width="100%" id="cruise_category">
                        {$clsCruiseCat->makeSelectboxOption($cruise_cat_id,0)}
                    </select>
                </div>
                <div class="booking-field booking-select-field v2-field">
                    <label class="booking-field-label v2-field-label" for="cruise_type">{$core->get_Lang('Cruise Type')}</label>
                    <select name="cruise_type" class="iso-selectbox" data-width="100%" id="cruise_type">
                        <option value="">{$core->get_Lang('All types')}</option>
                        <option value="1" {if $cruise_type|default:0 == 1}selected{/if}>{$core->get_Lang('Join-in Cruise')}</option>
                        <option value="2" {if $cruise_type|default:0 == 2}selected{/if}>{$core->get_Lang('Private Cruise')}</option>
                    </select>
                </div>
                <button type="submit" class="booking-search-btn v2-btn v2-btn--primary" id="findtBtn"><i class="fa fa-search" aria-hidden="true"></i>{$core->get_Lang('Search')}</button>
                <a href="{$PCMS_URL}/?mod={$mod}" class="booking-reset-btn v2-btn v2-btn--neutral"><i class="fa fa-refresh" aria-hidden="true"></i>{$core->get_Lang('Reset')}</a>
                <input type="hidden" name="filter" value="filter" />
            </form>
        </section>

        <div class="booking-list-toolbar">
            {capture name=cruise_status_tabs}
                <a href="{$PCMS_URL}/?mod={$mod}" class="booking-status-tab v2-status-tab v2-status-tab--primary {if $type_list ne 'Trash' && $type_list ne 'Publish'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('All')} <span>({$number_all})</span></a>
                <a href="{$PCMS_URL}/?mod={$mod}&type_list=Publish" class="booking-status-tab v2-status-tab v2-status-tab--success {if $type_list eq 'Publish'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('Publish')} <span>({$number_publish})</span></a>
                <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="booking-status-tab v2-status-tab v2-status-tab--danger booking-status-tab--trash {if $type_list eq 'Trash'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('Trash')} <span>({$number_trash})</span></a>
                <a class="booking-bulk-delete btn-delete-all v2-tabs-delete" id="btn_delete" clsTable="Cruise" style="display:none"><i class="fa fa-trash" aria-hidden="true"></i>{$core->get_Lang('Delete')}</a>
            {/capture}
            {include file="../components/list_v2/status_tabs.tpl" status_tabs_label=$core->get_Lang('status') status_tabs_content=$smarty.capture.cruise_status_tabs}
            <div class="booking-list-toolbar__right">
                {capture name=cruise_records_query}?mod={$mod}{$cruiseRecordPerPageFilterUrl}{/capture}
                {include file="../components/list_v2/records_per_page.tpl"
                    records_per_page_id="cruise_records_per_page"
                    records_per_page_label=$core->get_Lang('Records per page')
                    records_per_page_value=$recordPerPage
                    records_per_page_base_url=$PCMS_URL
                    records_per_page_query=$smarty.capture.cruise_records_query
                }
            </div>
        </div>

        <section class="list-table-v2-card booking-table-card v2-table-card">
            <div class="list-table-v2-scroll booking-table-scroll v2-table-scroll">
                <table class="list-table-v2 cruise-list-table v2-table">
                    <thead><tr>
                        <th class="list-table-v2-check booking-check-cell"><input id="check_all" type="checkbox" class="el-checkbox" aria-label="{$core->get_Lang('Select all')}" /></th>
                        <th class="list-table-v2-image cruise-image-column">{$core->get_Lang('Image')}</th>
                        <th class="list-table-v2-name">{$core->get_Lang('Cruise Name')}</th>
                        <th class="list-table-v2-type">{$core->get_Lang('Cruise Type')}</th>
                        <th class="list-table-v2-duration">{$core->get_Lang('duration')}</th>
                        <th class="list-table-v2-public is-center">{$core->get_Lang('public')}</th>
                        <th class="list-table-v2-action is-center list-table-action-cell">{$core->get_Lang('Action')}</th>
                    </tr></thead>
                    {if !empty($allItem) && $allItem[0].cruise_id ne ''}
                        <tbody id="SortAble" class="sortByTd">
                            {section name=i loop=$allItem}
                                {assign var=cruise_id value=$allItem[i].cruise_id}
                                {assign var=nameServices value=$clsClassTable->getTitle($cruise_id)}
                                {assign var=oneUserCreator value=$clsUser->getOne($allItem[i].user_id,'first_name,last_name')}
                                {assign var=oneUserUpdate value=$clsUser->getOne($allItem[i].user_id_update,'first_name,last_name')}
                                {assign var=cruise_itinerary value=$clsCruiseItinerary->getItinerary($cruise_id)}
                                <tr id="order_{$cruise_id}" class="sortable">
                                    <td class="list-table-v2-check booking-check-cell"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$cruise_id}" /></td>
                                    <td class="list-table-v2-image cruise-image-cell sortable"><img class="list-table-v2-thumb cruise-thumb list-table-thumbnail v2-thumbnail" src="{$clsClassTable->getImage($cruise_id,105,69)}" alt="{$nameServices}" onerror="this.onerror=null;this.classList.add('is-placeholder');this.src='{$URL_IMAGES}/none_image.png';" /></td>
                                    <td class="list-table-v2-name">
                                        <div class="list-table-v2-wrap list-table-heading list-table-heading-group">
                                            <a class="list-table-v2-title list-table-link" href="{$PCMS_URL}/cruise/insert/{$cruise_id}/overview"><span class="list-table-v2-key list-table-key">#{$cruise_id}</span>{if $nameServices} - {$nameServices}{/if}</a>
                                            {if $allItem[i].is_trash eq '1'}<span class="list-table-v2-badge list-table-v2-badge--danger list-table-badge list-table-badge--danger v2-badge v2-badge--danger">{$core->get_Lang('intrash')}</span>{/if}
                                            {if $allItem[i].is_online eq '0'}<span class="list-table-v2-badge list-table-v2-badge--warning list-table-badge list-table-badge--warning v2-badge v2-badge--warning status_private">{$core->get_Lang('Private')}</span>{/if}
                                        </div>
                                        <div class="list-table-v2-meta list-table-meta">{$core->get_Lang('Created')}: {$clsISO->formatDateTime($allItem[i].reg_date,'d/m/Y H:i',0)} &nbsp;|&nbsp; {$core->get_Lang('Updated')}: {$clsISO->formatDateTime($allItem[i].upd_date,'d/m/Y H:i',0)}</div>
                                    </td>
                                    <td class="list-table-v2-type"><span class="list-table-detail-line">{if $allItem[i].cruise_type == 1}{$core->get_Lang('Join-in Cruise')}{else}{$core->get_Lang('Private Cruise')}{/if}</span></td>
                                    <td class="list-table-v2-duration">
                                        {if !empty($cruise_itinerary)}
                                            <div class="list-table-detail-list">{section name=j loop=$cruise_itinerary}<span class="list-table-detail-line cruise-itinerary-title">{$clsCruiseItinerary->getTitleItinerary($cruise_itinerary[j].cruise_itinerary_id)}</span>{/section}</div>
                                        {else}<span class="list-table-empty-value">&mdash;</span>{/if}
                                    </td>
                                    <td class="list-table-v2-public is-center">
                                        <a href="javascript:void(0);" class="SiteClickPublic list-table-v2-toggle list-table-toggle" clsTable="Cruise" pkey="cruise_id" sourse_id="{$cruise_id}" rel="{$allItem[i].is_online}" title="{$core->get_Lang('Click to change status')}" aria-label="{$core->get_Lang('Click to change status')}">
                                            <span class="list-table-toggle__track" aria-hidden="true"><span class="list-table-toggle__thumb"></span></span>
                                        </a>
                                    </td>
                                    <td class="list-table-v2-action is-center list-table-action-cell">
                                        <div class="btn-group">
                                            <button class="list-table-v2-action-btn booking-row-menu list-table-action dropdown-toggle v2-action" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                {if $allItem[i].is_trash eq '0'}
                                                    <li><a class="dropdown-item btn_preview_tour edit_review" data-href="{$DOMAIN_NAME}{$clsClassTable->getLink($cruise_id)}" href="{$DOMAIN_NAME}{$clsClassTable->getLink($cruise_id)}" target="_blank"><i class="fa fa-eye"></i> {$core->get_Lang('view')}</a></li>
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/cruise/insert/{$cruise_id}/overview"><i class="fa fa-edit"></i> {$core->get_Lang('edit')}</a></li>
                                                    <li><a class="dropdown-item ajDuplicateCruise" data-name_services="{$nameServices}" cruise_id="{$cruise_id}" href="#"><i class="fa fa-clone"></i> {$core->get_Lang('duplicate')}</a></li>
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=trash&cruise_id={$core->encryptID($cruise_id)}{$pUrl}&page={$currentPage}"><i class="fa fa-trash"></i> {$core->get_Lang('trash')}</a></li>
                                                {else}
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/cruise/insert/{$cruise_id}/overview"><i class="fa fa-edit"></i> {$core->get_Lang('edit')}</a></li>
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=restore&cruise_id={$core->encryptID($cruise_id)}{$pUrl}&page={$currentPage}"><i class="fa fa-refresh"></i> {$core->get_Lang('restore')}</a></li>
                                                    <li><a class="dropdown-item confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&cruise_id={$core->encryptID($cruise_id)}{$pUrl}&page={$currentPage}"><i class="fa fa-remove"></i> {$core->get_Lang('delete')}</a></li>
                                                {/if}
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            {/section}
                        </tbody>
                    {else}
                        <tbody><tr><td colspan="7" class="booking-empty list-table-empty"><i class="fa fa-inbox" aria-hidden="true"></i><span>{$core->get_Lang('nodata')}!</span></td></tr></tbody>
                    {/if}
                </table>
            </div>
            {include file="../components/list_v2/pagination.tpl"
                pagination_showing_label=$core->get_Lang('Showing') pagination_showing_start=$showingStart pagination_showing_end=$showingEnd
                pagination_of_label=$core->get_Lang('of') pagination_total_records=$totalRecord pagination_entity_label=$core->get_Lang('cruises')
                pagination_total_pages=$totalPage pagination_current_page=$currentPage pagination_previous_page=$previousPage pagination_next_page=$nextPage
                pagination_pages=$listPageNumber pagination_base_url=$PCMS_URL pagination_page_query=$link_page_current
                pagination_label=$core->get_Lang('pagination') pagination_previous_label=$core->get_Lang('Previous') pagination_next_label=$core->get_Lang('Next')
            }
        </section>
    </main>
</div>

<script type="text/javascript">
    var $boxID = "";
    var $cat_id = '{$cat_id}';
    var $city_id = '{$city_id}';
    var $departure_point_id = '{$departure_point_id}';
    var $is_set = '{$is_set}';
    var $recordPerPage = '{$recordPerPage}';
    var $currentPage = '{$currentPage}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/cruise/jquery.cruise.js?v={$upd_version}"></script>
{literal}
<script type="text/javascript">
    $("#SortAble").sortable({
        opacity: 0.8,
        cursor: "move",
        start: function(){ vietiso_loading(1); },
        stop: function(){ vietiso_loading(0); },
        update: function(){
            var order = $(this).sortable("serialize") + "&update=update&recordPerPage=" + $recordPerPage + "&currentPage=" + $currentPage;
            $.post(path_ajax_script + "/index.php?mod=cruise&act=ajUpdPosSortCruise", order, function(){
                vietiso_loading(0);
                location.href = path_ajax_script + "/index.php?mod=" + mod;
            });
        }
    });
</script>
{/literal}
