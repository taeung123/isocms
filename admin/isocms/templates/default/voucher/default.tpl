<link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />

<div id="page_v2" class="page_container">
    <main class="iso-module-list iso-hotels-list">
        {capture name=list_header_actions}
            {* <a  type="button" class="v2-btn tm-btn--import" id="btnImportVouchers"><i class="fa-solid fa-upload"></i>
                {$core->get_Lang('Import')}</a> *}
            <button type="button" class="v2-btn v2-btn--add add_new_voucher"
                title="{$core->get_Lang('Voucher')}">
                <i class="fa fa-plus" aria-hidden="true"></i><span>{$core->get_Lang('Add Voucher')}</span>
            </button>
            <a href="{$PCMS_URL}/{$mod}/setting/supplier" class="v2-btn v2-btn--icon v2-module-setting-btn" title="Setting" aria-label="Setting">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                </a>
        {/capture}
        {capture name=list_header_setting_url}{$PCMS_URL}/?mod={$mod}&act=setting{/capture}
        {include file="../components/list_v2/header.tpl"
            header_home_label=$core->get_Lang('Dashboard')
            header_module_label=$core->get_Lang('Vouchers')
            header_title=$core->get_Lang('Vouchers')
            header_count=$number_all
            header_subtitle=$core->get_Lang('Create and manage discount vouchers for your website and booking system')
            header_actions=$smarty.capture.list_header_actions
        }

        <!-- KPI ROW -->
        <section class="tm-kpi-grid" aria-label="Voucher inventory metrics">
            <article class="tm-kpi-card">
                <div class="tm-kpi-card__top">
                    <span class="tm-kpi-icon tm-kpi-icon--blue" aria-hidden="true"><i
                            class="fa-solid fa-layer-group"></i></span>
                    <div>
                        <div class="tm-kpi-card__label">{$core->get_Lang('Total Vouchers')}</div>
                    </div>
                </div>
                <div class="tm-kpi-card__value-row">
                    <span class="tm-kpi-card__value">{number_format($totalCode)}</span>
                    <span class="tm-kpi-delta tm-kpi-delta--up"><i class="fa-solid fa-arrow-up"></i> {$totalPercent}%</span>
                </div>
                <div class="tm-kpi-card__caption">{$core->get_Lang('All voucher codes')}</div>
            </article>

            <article class="tm-kpi-card">
                <div class="tm-kpi-card__top">
                    <span class="tm-kpi-icon tm-kpi-icon--green" aria-hidden="true"><i
                            class="fa-solid fa-box"></i></span>
                    <div>
                        <div class="tm-kpi-card__label">{$core->get_Lang('Available')}</div>
                    </div>
                </div>
                <div class="tm-kpi-card__value-row">
                    <span class="tm-kpi-card__value">{number_format($availableCode)}</span>
                    <span class="tm-kpi-delta tm-kpi-delta--up"><i class="fa-solid fa-arrow-up"></i> {$availablePercent}%</span>
                </div>
                <div class="tm-kpi-card__caption">{$core->get_Lang('Ready to sell')}</div>
            </article>

            <article class="tm-kpi-card">
                <div class="tm-kpi-card__top">
                    <span class="tm-kpi-icon tm-kpi-icon--blue" aria-hidden="true"><i
                            class="fa-solid fa-cart-shopping"></i></span>
                    <div>
                        <div class="tm-kpi-card__label">{$core->get_Lang('Sold')}</div>
                    </div>
                </div>
                <div class="tm-kpi-card__value-row">
                    <span class="tm-kpi-card__value">{number_format($soldCode)}</span>
                    <span class="tm-kpi-delta tm-kpi-delta--up"><i class="fa-solid fa-arrow-up"></i> {$soldPercent}%</span>
                </div>
                <div class="tm-kpi-card__caption">{$core->get_Lang('Sold to customers')}</div>
            </article>

            <article class="tm-kpi-card">
                <div class="tm-kpi-card__top">
                    <span class="tm-kpi-icon tm-kpi-icon--purple" aria-hidden="true"><i
                            class="fa-solid fa-circle-check"></i></span>
                    <div>
                        <div class="tm-kpi-card__label">{$core->get_Lang('Redeemed')}</div>
                    </div>
                </div>
                <div class="tm-kpi-card__value-row">
                    <span class="tm-kpi-card__value">{number_format($redeemedCode)}</span>
                    <span class="tm-kpi-delta tm-kpi-delta--up"><i class="fa-solid fa-arrow-up"></i> {$redeemedPercent}%</span>
                </div>
                <div class="tm-kpi-card__caption">{$core->get_Lang('Already used')}</div>
            </article>

            <article class="tm-kpi-card">
                <div class="tm-kpi-card__top">
                    <span class="tm-kpi-icon tm-kpi-icon--orange" aria-hidden="true"><i
                            class="fa-regular fa-clock"></i></span>
                    <div>
                        <div class="tm-kpi-card__label">{$core->get_Lang('Expired')}</div>
                    </div>
                </div>
                <div class="tm-kpi-card__value-row">
                    <span class="tm-kpi-card__value">{number_format($expiredCode)}</span>
                    <span class="tm-kpi-delta tm-kpi-delta--warn"><i class="fa-solid fa-arrow-up"></i> {$expiredPercent}%</span>
                </div>
                <div class="tm-kpi-card__caption">{$core->get_Lang('No longer valid')}</div>
            </article>
        </section>


        <section class="booking-filter-panel v2-filter-panel" aria-label="{$core->get_Lang('filter')}">
            <form id="forums" method="post" class="booking-filter-form" action="" data-auto-filter="true">
                <div class="booking-field booking-search-field v2-field">
                    <label class="booking-field-label v2-field-label"
                        for="search_keyword">{$core->get_Lang('Search Voucher')}</label>
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input id="search_keyword" type="text" name="keyword" value="{$keyword}"
                        placeholder="{$core->get_Lang('Search voucher name')}..." />
                </div>
                <div class="booking-field booking-select-field v2-field">
                    <label class="booking-field-label v2-field-label"
                        for="slb_supplier">{$core->get_Lang('Supplier')}</label>
                    <select name="supplier_id" class="iso-selectbox" data-width="100%" id="slb_supplier">
                        {$clsSupplier->makeSelectboxOption($supplier_id)}
                    </select>
                </div>
                <div class="booking-field booking-select-field v2-field">
                    <label class="booking-field-label v2-field-label"
                        for="slb_category">{$core->get_Lang('Category')}</label>
                    <select name="voucher_cat_id" class="iso-selectbox" data-width="100%" id="slb_category">
                        {$clsVoucherCat->makeSelectboxOption($cat_id)}
                    </select>
                </div>
                <div class="booking-field booking-select-field v2-field">
                    <label class="booking-field-label v2-field-label"
                        for="slb_status">{$core->get_Lang('Status')}</label>
                    <select name="option_status" class="iso-selectbox" data-width="100%" id="slb_status">
                        <option value="0">{$core->get_Lang('All Status')}</option>
                        {foreach from=$op_status item=status_name key=status}
                            <option value="{$status}" {if $option_status == $status}selected{/if}>
                                {$core->get_Lang($status_name)}
                            </option>
                        {/foreach}
                    </select>
                </div>
                <button type="submit" class="booking-search-btn v2-btn v2-btn--primary" id="findtBtn"><i
                        class="fa fa-search" aria-hidden="true"></i>{$core->get_Lang('Search')}</button>
                <a href="{$PCMS_URL}/?mod={$mod}" class="booking-reset-btn v2-btn v2-btn--neutral"><i
                        class="fa fa-refresh" aria-hidden="true"></i>{$core->get_Lang('Reset')}</a>
                <input type="hidden" name="filter" value="filter" />
            </form>
        </section>

        <div class="booking-list-toolbar">
            {capture name=list_status_tabs}
                <a href="{$PCMS_URL}/?mod={$mod}"
                    class="booking-status-tab v2-status-tab v2-status-tab--primary {if $type_list ne 'Trash' && $type_list ne 'Publish'}is-active{/if} v2-tab">
                    <i aria-hidden="true"></i>{$core->get_Lang('All')} <span>({$number_all})</span>
                </a>
                <a href="{$PCMS_URL}/?mod={$mod}&type_list=Publish"
                    class="booking-status-tab v2-status-tab v2-status-tab--success {if $type_list eq 'Publish'}is-active{/if} v2-tab">
                    <i aria-hidden="true"></i>{$core->get_Lang('Publish')} <span>({$number_publish})</span>
                </a>
                <a href="{$PCMS_URL}/?mod={$mod}&type_list=Private"
                    class="booking-status-tab v2-status-tab v2-status-tab--warning {if $type_list eq 'Private'}is-active{/if} v2-tab">
                    <i aria-hidden="true"></i>{$core->get_Lang('Private')} <span>({$number_private})</span>
                </a>
                <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash"
                    class="booking-status-tab v2-status-tab v2-status-tab--danger booking-status-tab--trash {if $type_list eq 'Trash'}is-active{/if} v2-tab">
                    <i aria-hidden="true"></i>{$core->get_Lang('Trash')} <span>({$number_trash})</span>
                </a>
                <a class="booking-bulk-delete btn-delete-all v2-tabs-delete" 
                    id="btn_delete" 
                    clsTable="Voucher"
                    style="display:none">
                    <i class="fa fa-trash" aria-hidden="true"></i>{$core->get_Lang('Delete')}
                </a>
            {/capture}
            {include file="../components/list_v2/status_tabs.tpl"
                status_tabs_label=$core->get_Lang('status')
                status_tabs_content=$smarty.capture.list_status_tabs
            }
            <div class="booking-list-toolbar__right">
                {capture name=list_records_query}?mod={$mod}{$hotelRecordPerPageFilterUrl}{/capture}
                {include file="../components/list_v2/records_per_page.tpl"
                    records_per_page_id="list_records_per_page"
                    records_per_page_label=$core->get_Lang('Records per page')
                    records_per_page_value=$recordPerPage
                    records_per_page_base_url=$PCMS_URL
                    records_per_page_query=$smarty.capture.list_records_query
                }
            </div>
        </div>

        <section class="list-table-v2-card booking-table-card v2-table-card">
            <div class="list-table-v2-scroll booking-table-scroll v2-table-scroll">
                <table class="list-table-v2 hotel-list-table v2-table">
                    <thead>
                        <tr>
                            <th class="list-table-v2-check booking-check-cell"><input id="check_all" type="checkbox"
                                    class="el-checkbox" aria-label="{$core->get_Lang('Select all')}" /></th>
                            <th class="list-table-v2-image hotel-image-column">{$core->get_Lang('Image')}</th>
                            <th class="list-table-v2-name">{$core->get_Lang('Voucher')}</th>
                            <th class="list-table-v2-location">{$core->get_Lang('Supply')}</th>
                            <th class="list-table-v2-location">{$core->get_Lang('Category')}</th>
                            <th class="list-table-v2-location">{$core->get_Lang('Total')}</th>
                            <th class="list-table-v2-location">{$core->get_Lang('Available')}</th>
                            <th class="list-table-v2-location">{$core->get_Lang('Sold')}</th>
                            <th class="list-table-v2-location">{$core->get_Lang('Redeemed')}</th>
                            <th class="list-table-v2-public is-center">{$core->get_Lang('public')}</th>
                            <th class="list-table-v2-action is-center list-table-action-cell">
                                {$core->get_Lang('Action')}</th>
                        </tr>
                    </thead>

                    {if !empty($allItem)}
                        <tbody id="SortAble" class="sortByTd">
                            {section name=i loop=$allItem}

                                {assign var=voucher_id value=$allItem[i].voucher_id}
                                {assign var=linkEdit value="{$PCMS_URL}/voucher/overview/{$voucher_id}"}

                                <tr id="order_{$voucher_id}">
                                    <td class="list-table-v2-check booking-check-cell"><input name="p_key[]"
                                            class="chkitem el-checkbox" type="checkbox" value="{$voucher_id}" /></td>
                                    <td class="list-table-v2-image hotel-image-cell list-table-media sortable"><img
                                            class="list-table-v2-thumb hotel-thumb list-table-thumbnail v2-thumbnail"
                                            src="{$clsClassTable->getImage($voucher_id,105,69)}"
                                            alt="{$clsClassTable->getTitle($voucher_id)}"
                                            onerror="this.onerror=null;this.classList.add('is-placeholder');this.src='{$URL_IMAGES}/none_image.png';" />
                                    </td>

                                    <td class="list-table-v2-name">
                                        <div
                                            class="list-table-v2-wrap hotel-name-wrap list-table-heading list-table-heading-group">
                                            <a class="list-table-v2-title hotel-name list-table-link" href="{$linkEdit}"><span
                                                    class="list-table-v2-key list-table-key">#{$voucher_id}</span> -
                                                {$clsClassTable->getTitle($voucher_id)}</a>
                                            {if $allItem[i].is_trash eq '1'}<span
                                                class="list-table-v2-badge list-table-v2-badge--danger hotel-state hotel-state--trash list-table-badge list-table-badge--danger v2-badge v2-badge--danger">{$core->get_Lang('intrash')}</span>{/if}
                                            {if $allItem[i].is_online eq '0'}<span
                                                class="list-table-v2-badge list-table-v2-badge--warning hotel-state hotel-state--private list-table-badge list-table-badge--warning v2-badge v2-badge--warning status_private">{$core->get_Lang('Private')}</span>{/if}
                                        </div>
                                        <div class="list-table-v2-meta hotel-meta list-table-meta">{$core->get_Lang('Created')}:
                                            {$clsISO->formatDateTime($allItem[i].reg_date,'d/m/Y H:i',0)} &nbsp;|&nbsp;
                                            {$core->get_Lang('Updated')}:
                                            {$clsISO->formatDateTime($allItem[i].upd_date,'d/m/Y H:i',0)}</div>
                                    </td>

                                    <td>
                                        {if !empty($allItem[i].supplier_id)}
                                            {assign var="abbr" value=$clsISO->getNameAbbreviation($clsSupplier->getTitle($allItem[i].supplier_id))}
                                      
                                            <span class="tm-supplier-cell">
                                                <span class="tm-supplier-avatar" style="background:{$abbr.bg}; color:{$abbr.color};">
                                                    {$abbr.text}
                                                </span> 
                                                {$clsSupplier->getTitle($allItem[i].supplier_id)}
                                            </span>
                                        {/if}
                                    </td>

                                    <td class="list-table-v2-location">
                                        {if !empty($allItem[i].cat_id)}
                                            {assign var="catColor" value=$clsISO->getRandomColor($clsVoucherCat->getTitle($allItem[i].cat_id))}
                                            <span class="tm-category-badge" style="background:{$catColor.bg}; color:{$catColor.color};">
                                                {$clsVoucherCat->getTitle($allItem[i].cat_id)}
                                            </span>
                                        {/if}
                                    </td>
                                    <td class="font-weight-bold">{$clsVoucherCode->getTotalByVoucherProduct($allItem[i].voucher_id)}</td>
                                    <td class="font-weight-bold">{$clsVoucherCode->getTotalAvailableByVoucherProduct($allItem[i].voucher_id)}</td>
                                    <td class="font-weight-bold">{$clsVoucherCode->getTotalSoldByVoucherProduct($allItem[i].voucher_id)}</td>
                                    <td class="font-weight-bold">{$clsVoucherCode->getTotalRedeemedByVoucherProduct($allItem[i].voucher_id)}</td>
                                    {* <td class="list-table-v2-rating is-center hotel-rating">
                                        <strong>${$clsISO->formatPriceRead($allItem[i].price,',')}</strong>
                                    </td> *}
                                    <td class="list-table-v2-public is-center">
                                        <a href="javascript:void(0);"
                                            class="SiteClickPublic list-table-v2-toggle list-table-toggle" clsTable="Voucher"
                                            pkey="voucher_id" sourse_id="{$voucher_id}" rel="{$allItem[i].is_online}"
                                            title="{$core->get_Lang('Click to change status')}"
                                            aria-label="{$core->get_Lang('Click to change status')}">
                                            <span class="list-table-toggle__track" aria-hidden="true"><span
                                                    class="list-table-toggle__thumb"></span></span>
                                        </a>
                                    </td>
                                    <td class="list-table-v2-action is-center list-table-action-cell">
                                        <div class="btn-group">
                                            <button
                                                class="list-table-v2-action-btn booking-row-menu list-table-action dropdown-toggle v2-action"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                {if $allItem[i].is_trash eq '0'}
                                                    <li><a class="dropdown-item"
                                                            href="{$DOMAIN_NAME}{$clsClassTable->getLink($voucher_id)}"
                                                            target="_blank"><i class="fa fa-eye"></i> {$core->get_Lang('view')}</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="{$linkEdit}"><i class="fa fa-edit"></i>
                                                            {$core->get_Lang('edit')}</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{$PCMS_URL}/?mod={$mod}&act=trash&voucher_id={$core->encryptID($voucher_id)}{$pUrl}&page={$currentPage}"><i
                                                                class="fa fa-trash"></i> {$core->get_Lang('trash')}</a></li>
                                                {else}
                                                    <li><a class="dropdown-item" href="{$linkEdit}"><i class="fa fa-edit"></i>
                                                            {$core->get_Lang('edit')}</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{$PCMS_URL}/?mod={$mod}&act=restore&voucher_id={$core->encryptID($voucher_id)}{$pUrl}&page={$currentPage}"><i
                                                                class="fa fa-refresh"></i> {$core->get_Lang('restore')}</a></li>
                                                    <li><a class="confirm_delete dropdown-item"
                                                            href="{$PCMS_URL}/?mod={$mod}&act=delete&voucher_id={$core->encryptID($voucher_id)}{$pUrl}&page={$currentPage}"><i
                                                                class="fa fa-remove"></i> {$core->get_Lang('delete')}</a></li>
                                                {/if}
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            {/section}
                        </tbody>
                    {else}
                        <tbody>
                            <tr>
                                <td colspan="8" class="booking-empty list-table-empty"><i class="fa fa-inbox"
                                        aria-hidden="true"></i><span>{$core->get_Lang('no item')}!</span></td>
                            </tr>
                        </tbody>
                    {/if}
                </table>
            </div>
            {include file="../components/list_v2/pagination.tpl"
                pagination_showing_label=$core->get_Lang('Showing')
                pagination_showing_start=$showingStart
                pagination_showing_end=$showingEnd
                pagination_of_label=$core->get_Lang('of')
                pagination_total_records=$totalRecord
                pagination_entity_label=$core->get_Lang('Vouchers')
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
    {literal}
        <script type="text/javascript">
            $('#SortAble').sortable({
                items: 'tr',
                handle: 'td.sortable',
                opacity: 0.8,
                cursor: 'move',
                start: function() { vietiso_loading(1); },
                stop: function() { vietiso_loading(0); },
                update: function() {
                    var order = $(this).sortable('serialize') + '&update=update&recordPerPage=' +
                        $recordPerPage + '&currentPage=' + $currentPage;
                    $.post(path_ajax_script + '/index.php?mod=voucher&act=ajUpdPosSortVoucher', order, function() {
                        vietiso_loading(0);
                        location.href = REQUEST_URI;
                    });
                }
            });
        </script>
    {/literal}
</div>
{literal}
    <style type="text/css">
        .tm-btn--import {
            background: var(--color-surface);
            border-color: var(--color-border);
            color: var(--color-success);
        }

        .tm-btn--import:hover {
            background: var(--color-success-soft);
        }

        /* ---------- KPI ROW ---------- */
        .tm-kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
        }

        .tm-kpi-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border-light);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--box-shadow-md);
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        .tm-kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(11, 31, 68, 0.08);
        }

        .tm-kpi-card__top {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .tm-kpi-icon {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .tm-kpi-icon--blue {
            background: var(--color-primary-soft);
            color: var(--color-primary);
        }

        .tm-kpi-icon--green {
            background: var(--color-success-soft);
            color: var(--color-success);
        }

        .tm-kpi-icon--purple {
            background: var(--color-purple-soft);
            color: var(--color-purple);
        }

        .tm-kpi-icon--orange {
            background: var(--color-warning-soft);
            color: #C2410C;
        }

        .tm-kpi-card__label {
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text-secondary);
        }

        .tm-kpi-card__value-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
            flex-wrap: wrap;
        }

        .tm-kpi-card__value {
            font-size: 24px;
            font-weight: 700;
            color: var(--color-navy);
            line-height: 1;
        }

        .tm-kpi-delta {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 12px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 999px;
        }

        .tm-kpi-delta--up {
            background: var(--color-success-soft);
            color: var(--color-success);
        }

        .tm-kpi-delta--warn {
            background: var(--color-danger-soft);
            color: var(--color-danger);
        }

        .tm-kpi-card__caption {
            font-size: 12px;
            color: var(--color-text-muted);
        }

        .tm-supplier-cell {
            display: flex;
            align-items: center;
            gap: 9px;
            white-space: nowrap;
        }
        .tm-supplier-avatar {
            width: 26px;
            height: 26px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .tm-category-badge {
            display: inline-flex;
            align-items: center;
            height: 24px;
            padding: 0 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* =========================================================
   RESPONSIVE
   ========================================================= */
        @media (min-width: 1920px) {
            .tm-kpi-grid {
                gap: 18px;
            }
        }

        @media (max-width: 1439px) {
            .tm-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1024px) {
            .tm-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {

            .tm-page-header__actions .tm-btn--primary,
            .tm-page-header__actions .tm-btn--import {
                flex: 1;
                justify-content: center;
            }

        }

        @media (max-width: 768px) {
            .iso-vouchers-inv {
                padding: 14px 12px 28px;
                gap: 14px;
            }

            .tm-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .tm-kpi-card {
                padding: 12px;
            }

            .tm-kpi-card__value {
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            .tm-kpi-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
{/literal}