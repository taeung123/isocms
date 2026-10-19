<link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />

<div id="page_v2" class="page_container">
    <main class="iso-module-list iso-members-list">
        {capture name=member_header_setting_url}{$PCMS_URL}/?mod={$mod}&act=setting{/capture}
        {include file="../components/list_v2/header.tpl"
            header_home_label=$core->get_Lang('Dashboard')
            header_module_label=$core->get_Lang('Customers')
            header_title=$core->get_Lang('Customers')
            header_count=$number_all
            header_subtitle=$core->get_Lang('Manage your customers and keep building long-term relationships')
            header_actions=''
            header_setting_url=$smarty.capture.member_header_setting_url
            header_setting_label=$core->get_Lang('Setting')
        }

        <section class="booking-filter-panel v2-filter-panel" aria-label="{$core->get_Lang('filter')}">
            <form id="forums" method="post" class="booking-filter-form filterForm" action="" data-auto-filter="true">
                <div class="booking-field booking-search-field v2-field">
                    <label class="booking-field-label v2-field-label" for="member_keyword">{$core->get_Lang('Search')}</label>
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input id="member_keyword" type="search" name="name" value="{$name|default:''}" placeholder="{$core->get_Lang('Search by name, email or phone')}..." />
                </div>
                <div class="booking-field booking-select-field v2-field">
                    <label class="booking-field-label v2-field-label" for="member_status">{$core->get_Lang('status')}</label>
                    <select id="member_status" name="type_list" class="iso-selectbox" data-width="100%">
                        <option value="">{$core->get_Lang('All status')}</option>
                        <option value="Pending" {if $type_list eq 'Pending' || $is_active eq '0'}selected{/if}>{$core->get_Lang('Reminding')}</option>
                        <option value="Reviewed" {if $type_list eq 'Reviewed' || $type_list eq 'Approved' || $is_active eq '1' || $is_active eq '2'}selected{/if}>{$core->get_Lang('Reviewed')}</option>
                    </select>
                </div>
                <button type="submit" class="booking-search-btn v2-btn v2-btn--primary" id="findtBtn"><i class="fa fa-search" aria-hidden="true"></i>{$core->get_Lang('Search')}</button>
                <a href="{$PCMS_URL}/?mod={$mod}" class="booking-reset-btn v2-btn v2-btn--neutral"><i class="fa fa-refresh" aria-hidden="true"></i>{$core->get_Lang('Reset')}</a>
                <input type="hidden" name="filter" value="filter" />
            </form>
        </section>

        <div class="booking-list-toolbar">
            {capture name=member_status_tabs}
                <a href="{$PCMS_URL}/?mod={$mod}" class="booking-status-tab v2-status-tab v2-status-tab--primary {if !$type_list}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('All')} <span>({$number_all})</span></a>
                <a href="{$PCMS_URL}/?mod={$mod}&type_list=Pending" class="booking-status-tab v2-status-tab v2-status-tab--warning {if $type_list eq 'Pending'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('Reminding')} <span>({$number_unactive})</span></a>
                <a href="{$PCMS_URL}/?mod={$mod}&type_list=Reviewed" class="booking-status-tab v2-status-tab v2-status-tab--success {if $type_list eq 'Reviewed' || $type_list eq 'Approved'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('Reviewed')} <span>({$number_reviewed_total})</span></a>
                <a class="booking-bulk-delete btn-delete-all v2-tabs-delete" id="btn_delete" clsTable="Profile" style="display:none"><i class="fa fa-trash" aria-hidden="true"></i>{$core->get_Lang('Delete')}</a>
            {/capture}
            {include file="../components/list_v2/status_tabs.tpl" status_tabs_label=$core->get_Lang('status') status_tabs_content=$smarty.capture.member_status_tabs}
            <div class="booking-list-toolbar__right">
                {capture name=member_records_query}?mod={$mod}{$memberRecordPerPageFilterUrl}{/capture}
                {include file="../components/list_v2/records_per_page.tpl"
                    records_per_page_id="member_records_per_page"
                    records_per_page_label=$core->get_Lang('Records per page')
                    records_per_page_value=$recordPerPage
                    records_per_page_base_url=$PCMS_URL
                    records_per_page_query=$smarty.capture.member_records_query
                }
            </div>
        </div>

        <section class="list-table-v2-card booking-table-card v2-table-card">
            <div class="list-table-v2-scroll booking-table-scroll v2-table-scroll">
                <table class="list-table-v2 member-list-table v2-table">
                    <thead><tr>
                        <th class="list-table-v2-check booking-check-cell"><input id="check_all" type="checkbox" class="el-checkbox" aria-label="{$core->get_Lang('Select all')}" /></th>
                        <th class="list-table-v2-name">{$core->get_Lang('Customer')}</th>
                        <th class="list-table-v2-customer">{$core->get_Lang('Contact information')}</th>
                        <th class="list-table-v2-location">{$core->get_Lang('Location')}</th>
                        <th class="list-table-v2-type is-center">{$core->get_Lang('Customer type')}</th>
                        <th class="list-table-v2-status is-center">{$core->get_Lang('status')}</th>
                        <th class="list-table-v2-action-btn-cell member-booking-column"></th>
                        <th class="list-table-v2-action is-center list-table-action-cell">{$core->get_Lang('Action')}</th>
                    </tr></thead>
                    {if $listItem}
                        <tbody>
                            {section name=i loop=$listItem}
                                {assign var=nationality value=$clsCountry->getTitle($listItem[i].country_id)}
                                {assign var=member_name value=$listItem[i].full_name}
                                {assign var=member_avatar value=$clsClassTable->getImageAvatar($listItem[i].profile_id,80,80,$listItem[i])}
                                <tr>
                                    <td class="list-table-v2-check booking-check-cell"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$listItem[i].profile_id}" /></td>
                                    <td class="list-table-v2-name member-primary-cell">
                                        <div class="list-table-v2-wrap member-name-wrap list-table-content">
                                            <span class="list-table-v2-avatar member-avatar v2-avatar" aria-hidden="true">
                                                {if $member_avatar}
                                                    <img src="{$member_avatar}" alt="" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.classList.remove('is-hidden');" />
                                                    <span class="member-avatar-fallback is-hidden">{if $member_name}{$member_name|substr:0:1|upper}{else}<i class="fa-solid fa-user"></i>{/if}</span>
                                                {else}
                                                    <span class="member-avatar-fallback">{if $member_name}{$member_name|substr:0:1|upper}{else}<i class="fa-solid fa-user"></i>{/if}</span>
                                                {/if}
                                            </span>
                                            <div class="member-info">
                                                <div class="list-table-v2-wrap member-title-wrap list-table-heading list-table-heading-group">
                                                    <a class="list-table-v2-title member-name list-table-link" href="{$PCMS_URL}/member/view/{$listItem[i].profile_id}/overview"><span class="list-table-v2-key list-table-key">#{$listItem[i].profile_id}</span>{if $member_name} - {$member_name}{/if}</a>
                                                    {if $listItem[i].is_active eq '0'}
                                                        <span class="list-table-v2-badge list-table-v2-badge--warning list-table-badge list-table-badge--warning v2-badge v2-badge--warning">{$core->get_Lang('Reminding')}</span>
                                                    {else}
                                                        <span class="list-table-v2-badge list-table-v2-badge--success list-table-badge list-table-badge--success v2-badge v2-badge--success">{$core->get_Lang('Reviewed')}</span>
                                                    {/if}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="list-table-v2-customer">
                                        <div class="list-table-v2-contact list-table-detail-list list-table-contact">
                                            {if $listItem[i].email}<a class="list-table-detail-line list-table-contact-line" href="mailto:{$listItem[i].email}"><i class="fa-solid fa-envelope" aria-hidden="true"></i><span>{$listItem[i].email}</span></a>{/if}
                                            {if $listItem[i].phone}<a class="list-table-detail-line list-table-contact-line" href="tel:{$listItem[i].phone}"><i class="fa-solid fa-phone" aria-hidden="true"></i><span>{$listItem[i].phone}</span></a>{/if}
                                            <span class="list-table-detail-line list-table-contact-line list-table-contact-date"><i class="fa-solid fa-calendar" aria-hidden="true"></i><span>{$clsISO->formatDateTime($listItem[i].reg_date,"d/m/Y H:i",0)}</span></span>
                                        </div>
                                    </td>
                                    <td class="list-table-v2-location">
                                        {if $listItem[i].address || $nationality}
                                            <div class="list-table-detail-line list-table-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><span>{$listItem[i].address}{if $listItem[i].address && $nationality}, {/if}{$nationality}</span></div>
                                        {else}
                                            <span class="list-table-empty-value">&mdash;</span>
                                        {/if}
                                    </td>
                                    <td class="list-table-v2-type is-center">
                                        {if $listItem[i].is_agent eq '2'}
                                            <span class="list-table-v2-type-badge list-table-v2-badge--primary member-type-badge list-table-badge list-table-badge--purple v2-badge v2-badge--primary"><i class="fa-solid fa-building" aria-hidden="true"></i>{$core->get_Lang('Travel Agent')}</span>
                                        {else}
                                            <span class="list-table-v2-type-badge member-type-badge list-table-badge v2-badge"><i class="fa-solid fa-user" aria-hidden="true"></i>{$core->get_Lang('Traveller')}</span>
                                        {/if}
                                    </td>
                                    <td class="list-table-v2-status is-center">
                                        <a href="javascript:void(0);" class="SiteClickPublic list-table-v2-toggle list-table-toggle" clsTable="Profile" pkey="profile_id" sourse_id="{$listItem[i].profile_id}" rel="{$listItem[i].is_online}" title="{$core->get_Lang('Click to change status')}" aria-label="{$core->get_Lang('Click to change status')}">
                                            <span class="list-table-toggle__track" aria-hidden="true"><span class="list-table-toggle__thumb"></span></span>
                                        </a>
                                    </td>
                                    <td class="list-table-v2-action-btn-cell member-booking-cell"><a class="member-create-booking" href="" title="{$core->get_Lang('Create booking')}"><i class="fa fa-plus"></i>{$core->get_Lang('Create booking')}</a></td>
                                    <td class="list-table-v2-action is-center list-table-action-cell">
                                        <div class="btn-group">
                                            <button class="list-table-v2-action-btn booking-row-menu list-table-action dropdown-toggle v2-action" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{$core->get_Lang('Action')}"><i class="fa fa-ellipsis-v"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="{$PCMS_URL}/member/view/{$listItem[i].profile_id}/overview" class="dropdown-item"><i class="fa fa-eye"></i>{$core->get_Lang('view')}</a></li>
                                                <li><a class="confirm_delete dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=delete&profile_id={$core->encryptID($listItem[i].profile_id)}"><i class="fa fa-trash"></i>{$core->get_Lang('delete')}</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            {/section}
                        </tbody>
                    {else}
                        <tbody><tr><td colspan="8" class="list-table-v2-empty booking-empty list-table-empty"><i class="fa fa-users"></i><span>{$core->get_Lang('nodata')}</span></td></tr></tbody>
                    {/if}
                </table>
            </div>
            {include file="../components/list_v2/pagination.tpl"
                pagination_showing_label=$core->get_Lang('Showing') pagination_showing_start=$showingStart pagination_showing_end=$showingEnd
                pagination_of_label=$core->get_Lang('of') pagination_total_records=$totalRecord pagination_entity_label=$core->get_Lang('customers')
                pagination_total_pages=$totalPage pagination_current_page=$currentPage pagination_previous_page=$previousPage pagination_next_page=$nextPage
                pagination_pages=$listPageNumber pagination_base_url=$PCMS_URL pagination_page_query=$link_page_current
                pagination_label=$core->get_Lang('pagination') pagination_previous_label=$core->get_Lang('Previous') pagination_next_label=$core->get_Lang('Next')
            }
        </section>
    </main>
</div>
