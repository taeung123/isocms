<!-- KPI ROW -->
<section class="tm-kpi-grid" aria-label="Category summary">
    <article class="tm-kpi-card">
        <span class="tm-kpi-icon tm-kpi-icon--purple" aria-hidden="true"><i
                class="fa-solid fa-table-cells-large"></i></span>
        <div class="tm-kpi-body">
            <div class="tm-kpi-value-row">
                <span class="tm-kpi-value">{$totalCategory}</span>
                <span class="tm-kpi-delta {if $totalPercent >= 0}tm-kpi-delta--up{else}tm-kpi-delta--down{/if}"><i
                        class="fa-solid {if $totalPercent >= 0}fa-arrow-up{else}fa-arrow-down{/if}"></i>
                    {$totalPercent}%</span>
            </div>
            <span class="tm-kpi-label">{$core->get_Lang('Total Categories')}</span>
        </div>
    </article>

    <article class="tm-kpi-card">
        <span class="tm-kpi-icon tm-kpi-icon--green" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
        <div class="tm-kpi-body">
            <div class="tm-kpi-value-row">
                <span class="tm-kpi-value">{$totalActiveCategory}</span>
                <span class="tm-kpi-delta {if $totalActivePercent >= 0}tm-kpi-delta--up{else}tm-kpi-delta--down{/if}"><i
                        class="fa-solid {if $totalActivePercent >= 0}fa-arrow-up{else}fa-arrow-down{/if}"></i>
                    {$totalActivePercent}%</span>
            </div>
            <span class="tm-kpi-label">{$core->get_Lang('Active Categories')}</span>
        </div>
    </article>

    <article class="tm-kpi-card">
        <span class="tm-kpi-icon tm-kpi-icon--orange" aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
        <div class="tm-kpi-body">
            <div class="tm-kpi-value-row">
                <span class="tm-kpi-value">{$totalInactiveCategory}</span>
                <span
                    class="tm-kpi-delta {if $totalInactivePercent >= 0}tm-kpi-delta--up{else}tm-kpi-delta--down{/if}"><i
                        class="fa-solid {if $totalInactivePercent >= 0}fa-arrow-up{else}fa-arrow-down{/if}"></i>
                    {$totalInactivePercent}%</span>
            </div>
            <span class="tm-kpi-label">{$core->get_Lang('Inactive Categories')}</span>
        </div>
    </article>

    {* <article class="tm-kpi-card">
        <span class="tm-kpi-icon tm-kpi-icon--blue" aria-hidden="true"><i class="fa-solid fa-user-group"></i></span>
        <div class="tm-kpi-body">
            <div class="tm-kpi-value-row">
                <span class="tm-kpi-value">8</span>
                <span class="tm-kpi-delta tm-kpi-delta--up"><i class="fa-solid fa-arrow-up"></i> 20%</span>
            </div>
            <span class="tm-kpi-label">{$core->get_Lang('Suppliers Using')}</span>
        </div>
    </article> *}

    <article class="tm-kpi-card">
        <span class="tm-kpi-icon tm-kpi-icon--blue" aria-hidden="true"><i class="fa-solid fa-ticket"></i></span>
        <div class="tm-kpi-body">
            <div class="tm-kpi-value-row">
                <span class="tm-kpi-value">{$totalVoucherUsing}</span>
                <span
                    class="tm-kpi-delta {if $totalVoucherUsingPercent >= 0}tm-kpi-delta--up{else}tm-kpi-delta--down{/if}"><i
                        class="fa-solid {if $totalVoucherUsingPercent >= 0}fa-arrow-up{else}fa-arrow-down{/if}"></i>
                    {$totalVoucherUsingPercent}%</span>
            </div>
            <span class="tm-kpi-label">{$core->get_Lang('Vouchers Using')}</span>
        </div>
    </article>
</section>

<section class="booking-filter-panel v2-filter-panel" aria-label="{$core->get_Lang('filter')}">
    <form id="forums" method="post" class="booking-filter-form" action="" data-auto-filter="true">
        <div class="booking-field booking-search-field v2-field">
            <label class="booking-field-label v2-field-label"
                for="search_keyword">{$core->get_Lang('Search Category')}</label>
            <i class="fa fa-search" aria-hidden="true"></i>
            <input id="search_keyword" type="text" name="keyword" value="{$keyword}"
                placeholder="{$core->get_Lang('Search category name')}..." />
        </div>
        {* <div class="booking-field booking-select-field v2-field">
            <label class="booking-field-label v2-field-label" for="slb_supplier">{$core->get_Lang('Supplier')}</label>
            <select name="supplier_id" class="iso-selectbox" data-width="100%" id="slb_supplier">
                {$clsSupplier->makeSelectboxOption($supplier_id)}
            </select>
        </div> *}

        <div class="booking-field booking-select-field v2-field">
            <label class="booking-field-label v2-field-label" for="slb_status">{$core->get_Lang('Status')}</label>
            <select name="option_status" class="iso-selectbox" data-width="100%" id="slb_status">
                <option value="0">{$core->get_Lang('All Status')}</option>
                {foreach from=$op_status item=status_name key=status}
                    <option value="{$status}" {if $option_status == $status}selected{/if}>
                        {$core->get_Lang($status_name)}
                    </option>
                {/foreach}
            </select>
        </div>
        <button type="submit" class="booking-search-btn v2-btn v2-btn--primary" id="findtBtn"><i class="fa fa-search"
                aria-hidden="true"></i>{$core->get_Lang('Search')}</button>
        <a href="{$PCMS_URL}/{$mod}/setting/{$currentTab}" class="booking-reset-btn v2-btn v2-btn--neutral"><i
                class="fa fa-refresh" aria-hidden="true"></i>{$core->get_Lang('Reset')}</a>
        <input type="hidden" name="filter" value="filter" />
    </form>
</section>

<div class="booking-list-toolbar">
    {capture name=list_status_tabs}
        <a href="{$PCMS_URL}/{$mod}/setting/{$currentTab}"
            class="booking-status-tab v2-status-tab v2-status-tab--primary {if $type_list ne 'Trash' && $type_list ne 'Publish'}is-active{/if} v2-tab">
            <i aria-hidden="true"></i>{$core->get_Lang('All')} <span>({$number_all})</span>
        </a>
        <a href="{$PCMS_URL}/{$mod}/setting/{$currentTab}?type_list=Publish"
            class="booking-status-tab v2-status-tab v2-status-tab--success {if $type_list eq 'Publish'}is-active{/if} v2-tab">
            <i aria-hidden="true"></i>{$core->get_Lang('Publish')} <span>({$number_publish})</span>
        </a>
        <a href="{$PCMS_URL}/{$mod}/setting/{$currentTab}?type_list=Private"
            class="booking-status-tab v2-status-tab v2-status-tab--warning booking-status-tab--private {if $type_list eq 'Private'}is-active{/if} v2-tab">
            <i aria-hidden="true"></i>{$core->get_Lang('Private')} <span>({$number_private})</span>
        </a>
        <a href="{$PCMS_URL}/{$mod}/setting/{$currentTab}?type_list=Trash"
            class="booking-status-tab v2-status-tab v2-status-tab--danger booking-status-tab--trash {if $type_list eq 'Trash'}is-active{/if} v2-tab">
            <i aria-hidden="true"></i>{$core->get_Lang('Trash')} <span>({$number_trash})</span>
        </a>
        <a class="booking-bulk-delete btn-delete-all v2-tabs-delete" id="btn_delete" clsTable="VoucherCat"
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
                    <th class="list-table-v2-name">{$core->get_Lang('Category')}</th>
                    <th class="list-table-v2-location">{$core->get_Lang('Voucher Count')}</th>
                    <th class="list-table-v2-location">{$core->get_Lang('Updated')}</th>
                    <th class="list-table-v2-public is-center">{$core->get_Lang('public')}</th>
                    <th class="list-table-v2-action is-center list-table-action-cell">
                        {$core->get_Lang('Action')}</th>
                </tr>
            </thead>

            {if !empty($allItem)}
                <tbody id="SortAble" class="sortByTd">
                    {section name=i loop=$allItem}

                        {assign var=voucher_cat_id value=$allItem[i].voucher_cat_id}
                        {assign var=linkEdit value="{$PCMS_URL}/voucher/setting/categories/edit/{$voucher_cat_id}/basic-information"}

                        <tr id="order_{$voucher_cat_id}">
                            <td class="list-table-v2-check booking-check-cell"><input name="p_key[]" class="chkitem el-checkbox"
                                    type="checkbox" value="{$voucher_cat_id}" /></td>
                            <td class="list-table-v2-image hotel-image-cell list-table-media sortable">
                                <img class="list-table-v2-thumb hotel-thumb list-table-thumbnail v2-thumbnail"
                                    src="{$clsClassTable->getImage($voucher_cat_id,105,69)}"
                                    alt="{$clsClassTable->getTitle($voucher_cat_id)}"
                                    onerror="this.onerror=null;this.classList.add('is-placeholder');this.src='{$URL_IMAGES}/none_image.png';" />
                            </td>

                            <td class="list-table-v2-name">
                                <div class="list-table-v2-wrap hotel-name-wrap list-table-heading list-table-heading-group">
                                    <a class="list-table-v2-title hotel-name list-table-link" href="{$linkEdit}"><span
                                            class="list-table-v2-key list-table-key">#{$voucher_cat_id}</span> -
                                        {$clsClassTable->getTitle($voucher_cat_id)}</a>
                                    {if $allItem[i].is_trash eq '1'}<span
                                        class="list-table-v2-badge list-table-v2-badge--danger hotel-state hotel-state--trash list-table-badge list-table-badge--danger v2-badge v2-badge--danger">{$core->get_Lang('intrash')}</span>{/if}
                                    {if $allItem[i].is_online eq '0'}<span
                                        class="list-table-v2-badge list-table-v2-badge--warning hotel-state hotel-state--private list-table-badge list-table-badge--warning v2-badge v2-badge--warning status_private">{$core->get_Lang('Private')}</span>{/if}
                                </div>
                            </td>



                            <td class="font-weight-bold">
                                {$clsVoucher->countVoucherByCategory($voucher_cat_id)}
                            </td>
                            <td>
                                {$clsISO->formatDateTime($allItem[i].upd_date,'d/m/Y',0)}</br>
                                {$clsISO->formatDateTime($allItem[i].upd_date,'H:i',0)}
                            </td>
                            {* <td class="list-table-v2-rating is-center hotel-rating">
                                        <strong>${$clsISO->formatPriceRead($allItem[i].price,',')}</strong>
                                    </td> *}
                            <td class="list-table-v2-public is-center">
                                <a href="javascript:void(0);" class="SiteClickPublic list-table-v2-toggle list-table-toggle"
                                    clsTable="VoucherCat" pkey="voucher_cat_id" sourse_id="{$voucher_cat_id}"
                                    rel="{$allItem[i].is_online}" title="{$core->get_Lang('Click to change status')}"
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

                                            <li>
                                                <a class="dropdown-item btnEditVoucherCat" href="javascript:void(0);"
                                                    data="{$allItem[i].voucher_cat_id}">
                                                    <i class="fa fa-edit"></i>
                                                    {$core->get_Lang('edit')}
                                                </a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{$PCMS_URL}/?mod={$mod}&act={$act}&step={$currentTab}&action=Trash&voucher_cat_id={$core->encryptID($allItem[i].voucher_cat_id)}"><i
                                                        class="fa fa-trash"></i> {$core->get_Lang('trash')}</a></li>
                                        {else}
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);"
                                                    data="{$allItem[i].voucher_cat_id}"><i class="fa fa-edit"></i>
                                                    {$core->get_Lang('edit')}</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{$PCMS_URL}/?mod={$mod}&act={$act}&step={$currentTab}&action=Restore&voucher_cat_id={$core->encryptID($allItem[i].voucher_cat_id)}">
                                                    <i class="fa fa-refresh"></i>
                                                    {$core->get_Lang('restore')}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="confirm_delete dropdown-item"
                                                    href="{$PCMS_URL}/?mod={$mod}&act={$act}&step={$currentTab}&action=Delete&voucher_cat_id={$core->encryptID($allItem[i].voucher_cat_id)}">
                                                    <i class="fa fa-remove"></i>
                                                    {$core->get_Lang('delete')}
                                                </a>
                                            </li>
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
                pagination_entity_label=$core->get_Lang('Categories')
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
<script type="text/javascript">
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
                $.post(path_ajax_script + '/index.php?mod=voucher&act=ajUpdPosSortVoucherCategory', order,
                    function() {
                        vietiso_loading(0);
                        location.href = REQUEST_URI;
                    });
            }
        });
    </script>
{/literal}