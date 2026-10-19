<link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />

<div id="page_v2" class="page_container">
    <main class="iso-module-list iso-hotels-list">
        {capture name=hotel_header_actions}
                <button type="button" class="v2-btn v2-btn--add createNewHotel" title="{$core->get_Lang('Add Hotel')}">
                    <i class="fa fa-plus" aria-hidden="true"></i><span>{$core->get_Lang('Add Hotel')}</span>
                </button>
        {/capture}
        {capture name=hotel_header_setting_url}{$PCMS_URL}/?mod={$mod}&act=setting{/capture}
        {include file="../components/list_v2/header.tpl"
            header_home_label=$core->get_Lang('Dashboard')
            header_module_label=$core->get_Lang('Hotels')
            header_title=$core->get_Lang('Hotels')
            header_count=$number_all
            header_subtitle=$core->get_Lang('Manage, build and publish your hotel products')
            header_actions=$smarty.capture.hotel_header_actions
            header_setting_url=$smarty.capture.hotel_header_setting_url
            header_setting_label=$core->get_Lang('Setting')
        }

        <section class="booking-filter-panel v2-filter-panel" aria-label="{$core->get_Lang('filter')}">
            <form id="forums" method="post" class="booking-filter-form" action="" data-auto-filter="true">
                <div class="booking-field booking-search-field v2-field">
                    <label class="booking-field-label v2-field-label" for="hotel_keyword">{$core->get_Lang('Search')}</label>
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input id="hotel_keyword" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('Search hotel name')}..." />
                </div>
                <div class="booking-field booking-select-field v2-field">
                    <label class="booking-field-label v2-field-label" for="slb_country">{$core->get_Lang('Country')}</label>
                    <select name="country_id" class="iso-selectbox" data-width="100%" id="slb_country">
                        {$clsCountry->makeSelectHotelOption($country_id, $continent_id)}
                    </select>
                </div>
                <div class="booking-field booking-select-field v2-field">
                    <label class="booking-field-label v2-field-label" for="slb_city">{$core->get_Lang('City')}</label>
                    <select name="city_id" class="iso-selectbox" data-width="100%" id="slb_city">
                        <option value="0">{$core->get_Lang('All City')}</option>
                        {$clsCity->getSelectCityHotel($country_id, 0, $city_id, 'title')}
                    </select>
                </div>
                <button type="submit" class="booking-search-btn v2-btn v2-btn--primary" id="findtBtn"><i class="fa fa-search" aria-hidden="true"></i>{$core->get_Lang('Search')}</button>
                <a href="{$PCMS_URL}/?mod={$mod}" class="booking-reset-btn v2-btn v2-btn--neutral"><i class="fa fa-refresh" aria-hidden="true"></i>{$core->get_Lang('Reset')}</a>
                <input type="hidden" name="filter" value="filter" />
            </form>
        </section>

        <div class="booking-list-toolbar">
            {capture name=hotel_status_tabs}
                <a href="{$PCMS_URL}/?mod={$mod}" class="booking-status-tab v2-status-tab v2-status-tab--primary {if $type_list ne 'Trash' && $type_list ne 'Publish'}is-active{/if} v2-tab">
                    <i aria-hidden="true"></i>{$core->get_Lang('All')} <span>({$number_all})</span>
                </a>
                <a href="{$PCMS_URL}/?mod={$mod}&type_list=Publish" class="booking-status-tab v2-status-tab v2-status-tab--success {if $type_list eq 'Publish'}is-active{/if} v2-tab">
                    <i aria-hidden="true"></i>{$core->get_Lang('Publish')} <span>({$number_publish})</span>
                </a>
                <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="booking-status-tab v2-status-tab v2-status-tab--danger booking-status-tab--trash {if $type_list eq 'Trash'}is-active{/if} v2-tab">
                    <i aria-hidden="true"></i>{$core->get_Lang('Trash')} <span>({$number_trash})</span>
                </a>
                <a class="booking-bulk-delete btn-delete-all v2-tabs-delete" id="btn_delete" clsTable="Hotel" style="display:none">
                    <i class="fa fa-trash" aria-hidden="true"></i>{$core->get_Lang('Delete')}
                </a>
            {/capture}
            {include file="../components/list_v2/status_tabs.tpl"
                status_tabs_label=$core->get_Lang('status')
                status_tabs_content=$smarty.capture.hotel_status_tabs
            }
            <div class="booking-list-toolbar__right">
                {capture name=hotel_records_query}?mod={$mod}{$hotelRecordPerPageFilterUrl}{/capture}
                {include file="../components/list_v2/records_per_page.tpl"
                    records_per_page_id="hotel_records_per_page"
                    records_per_page_label=$core->get_Lang('Records per page')
                    records_per_page_value=$recordPerPage
                    records_per_page_base_url=$PCMS_URL
                    records_per_page_query=$smarty.capture.hotel_records_query
                }
            </div>
        </div>

        <section class="list-table-v2-card booking-table-card v2-table-card">
            <div class="list-table-v2-scroll booking-table-scroll v2-table-scroll">
                <table class="list-table-v2 hotel-list-table v2-table">
                    <thead>
                        <tr>
                            <th class="list-table-v2-check booking-check-cell"><input id="check_all" type="checkbox" class="el-checkbox" aria-label="{$core->get_Lang('Select all')}" /></th>
                            <th class="list-table-v2-image hotel-image-column">{$core->get_Lang('Image')}</th>
                            <th class="list-table-v2-name">{$core->get_Lang('Hotel Name')}</th>
                            <th class="list-table-v2-location">{$core->get_Lang('Location')}</th>
                            <th class="list-table-v2-rating is-center">{$core->get_Lang('Rating')}</th>
                            <th class="list-table-v2-price is-right">{$core->get_Lang('Price from')}</th>
                            <th class="list-table-v2-public is-center">{$core->get_Lang('public')}</th>
                            <th class="list-table-v2-action is-center list-table-action-cell">{$core->get_Lang('Action')}</th>
                        </tr>
                    </thead>
                    {if !empty($allItem) && $allItem[0].hotel_id ne ''}
                        <tbody id="SortAble" class="sortByTd">
                            {section name=i loop=$allItem}
                                {assign var=hotel_id value=$allItem[i].hotel_id}
                                {assign var=linkEdit value="{$PCMS_URL}/hotel/insert/{$hotel_id}/overview"}
                                {assign var=hotel_city_title value=$clsCity->getTitle($allItem[i].city_id)}
                                {assign var=hotel_country_title value=$clsCountry->getTitle($allItem[i].country_id)}
                                {assign var=hotel_star value=$clsClassTable->getStar($hotel_id)}
                                <tr id="order_{$hotel_id}">
                                    <td class="list-table-v2-check booking-check-cell"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$hotel_id}" /></td>
                                    <td class="list-table-v2-image hotel-image-cell list-table-media sortable"><img class="list-table-v2-thumb hotel-thumb list-table-thumbnail v2-thumbnail" src="{$clsClassTable->getImage($hotel_id,105,69)}" alt="{$clsClassTable->getTitle($hotel_id)}" onerror="this.onerror=null;this.classList.add('is-placeholder');this.src='{$URL_IMAGES}/none_image.png';" /></td>
                                    <td class="list-table-v2-name">
                                        <div class="list-table-v2-wrap hotel-name-wrap list-table-heading list-table-heading-group">
                                            <a class="list-table-v2-title hotel-name list-table-link" href="{$linkEdit}"><span class="list-table-v2-key list-table-key">#{$hotel_id}</span> - {$clsClassTable->getTitle($hotel_id)}</a>
                                            {if $allItem[i].is_trash eq '1'}<span class="list-table-v2-badge list-table-v2-badge--danger hotel-state hotel-state--trash list-table-badge list-table-badge--danger v2-badge v2-badge--danger">{$core->get_Lang('intrash')}</span>{/if}
                                            {if $allItem[i].is_online eq '0'}<span class="list-table-v2-badge list-table-v2-badge--warning hotel-state hotel-state--private list-table-badge list-table-badge--warning v2-badge v2-badge--warning status_private">{$core->get_Lang('Private')}</span>{/if}
                                        </div>
                                        <div class="list-table-v2-meta hotel-meta list-table-meta">{$core->get_Lang('Created')}: {$clsISO->formatDateTime($allItem[i].reg_date,'d/m/Y H:i',0)} &nbsp;|&nbsp; {$core->get_Lang('Updated')}: {$clsISO->formatDateTime($allItem[i].upd_date,'d/m/Y H:i',0)}</div>
                                    </td>
                                    <td class="list-table-v2-location">
                                        {if $hotel_city_title || $hotel_country_title}
                                            <div class="hotel-location list-table-detail-line list-table-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><span>{$hotel_city_title}{if $hotel_city_title && $hotel_country_title}, {/if}{$hotel_country_title}</span></div>
                                        {else}
                                            <span class="list-table-empty-value">&mdash;</span>
                                        {/if}
                                    </td>
                                    <td class="list-table-v2-rating is-center hotel-rating">
                                        {if $hotel_star gt 0}
                                            <span class="list-table-rating" aria-label="{$hotel_star} {$core->get_Lang('star')}">{section name=hotel_rating loop=$hotel_star}<i class="fa-solid fa-star" aria-hidden="true"></i>{/section}</span>
                                        {else}
                                            <span class="list-table-empty-value">&mdash;</span>
                                        {/if}
                                    </td>
                                    <td class="v2-price is-right">{$clsClassTable->getPrice($hotel_id)}</td>
                                    <td class="list-table-v2-public is-center">
                                        <a href="javascript:void(0);" class="SiteClickPublic list-table-v2-toggle list-table-toggle" clsTable="Hotel" pkey="hotel_id" sourse_id="{$hotel_id}" rel="{$allItem[i].is_online}" title="{$core->get_Lang('Click to change status')}" aria-label="{$core->get_Lang('Click to change status')}">
                                            <span class="list-table-toggle__track" aria-hidden="true"><span class="list-table-toggle__thumb"></span></span>
                                        </a>
                                    </td>
                                    <td class="list-table-v2-action is-center list-table-action-cell">
                                        <div class="btn-group">
                                            <button class="list-table-v2-action-btn booking-row-menu list-table-action dropdown-toggle v2-action" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                {if $allItem[i].is_trash eq '0'}
                                                    <li><a class="dropdown-item" href="{$DOMAIN_NAME}{$clsClassTable->getLink($hotel_id)}" target="_blank"><i class="fa fa-eye"></i> {$core->get_Lang('view')}</a></li>
                                                    <li><a class="dropdown-item" href="{$linkEdit}"><i class="fa fa-edit"></i> {$core->get_Lang('edit')}</a></li>
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=trash&hotel_id={$core->encryptID($hotel_id)}{$pUrl}&page={$currentPage}"><i class="fa fa-trash"></i> {$core->get_Lang('trash')}</a></li>
                                                {else}
                                                    <li><a class="dropdown-item" href="{$linkEdit}"><i class="fa fa-edit"></i> {$core->get_Lang('edit')}</a></li>
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=restore&hotel_id={$core->encryptID($hotel_id)}{$pUrl}&page={$currentPage}"><i class="fa fa-refresh"></i> {$core->get_Lang('restore')}</a></li>
                                                    <li><a class="confirm_delete dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=delete&hotel_id={$core->encryptID($hotel_id)}{$pUrl}&page={$currentPage}"><i class="fa fa-remove"></i> {$core->get_Lang('delete')}</a></li>
                                                {/if}
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            {/section}
                        </tbody>
                    {else}
                        <tbody><tr><td colspan="8" class="booking-empty list-table-empty"><i class="fa fa-inbox" aria-hidden="true"></i><span>{$core->get_Lang('nodata')}!</span></td></tr></tbody>
                    {/if}
                </table>
            </div>
            {include file="../components/list_v2/pagination.tpl"
                pagination_showing_label=$core->get_Lang('Showing')
                pagination_showing_start=$showingStart
                pagination_showing_end=$showingEnd
                pagination_of_label=$core->get_Lang('of')
                pagination_total_records=$totalRecord
                pagination_entity_label=$core->get_Lang('hotels')
                pagination_total_pages=$totalPage
                pagination_current_page=$currentPage
                pagination_previous_page=$previousPage
                pagination_next_page=$nextPage
                pagination_pages=$listPageNumber
                pagination_base_url=$PCMS_URL
                pagination_page_query=$link_page_current
                pagination_label=$core->get_Lang('pagination')
                pagination_previous_label=$core->get_Lang('Previous')
                pagination_next_label=$core->get_Lang('Next')
            }
        </section>
    </main>

    <script type="text/javascript">
        var $boxID = '';
        var $cat_id = '{$cat_id}';
        var $city_id = '{$city_id}';
        var $departure_point_id = '{$departure_point_id}';
        var $is_set = '{$is_set}';
        var $recordPerPage = '{$recordPerPage}';
        var $currentPage = '{$currentPage}';
    </script>
    <script type="text/javascript" src="{$URL_THEMES}/hotel/jquery.hotel.js?v={$upd_version}"></script>
    {literal}
    <script type="text/javascript">
        $('#SortAble').sortable({
            items: 'tr',
            handle: 'td.sortable',
            opacity: 0.8,
            cursor: 'move',
            start: function(){ vietiso_loading(1); },
            stop: function(){ vietiso_loading(0); },
            update: function(){
                var order = $(this).sortable('serialize') + '&update=update&recordPerPage=' + $recordPerPage + '&currentPage=' + $currentPage;
                $.post(path_ajax_script + '/index.php?mod=hotel&act=ajUpdPosSortHotel', order, function(){
                    vietiso_loading(0);
                    location.href = REQUEST_URI;
                });
            }
        });
    </script>
    {/literal}
</div>
