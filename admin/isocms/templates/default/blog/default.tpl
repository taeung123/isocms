<link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />

<div id="page_v2" class="page_container blog-list-screen">
    <main class="iso-module-list iso-blog-list">
        {capture name=blog_header_actions}
            <a href="{$PCMS_URL}/?mod={$mod}&act=category" class="v2-btn v2-btn--success" title="{$core->get_Lang('Category')}">
                <i class="fa fa-folder-open" aria-hidden="true"></i><span>{$core->get_Lang('Category')}</span>
            </a>
            <button type="button" class="v2-btn v2-btn--add add_new_blog" title="{$core->get_Lang('Add blog')}">
                <i class="fa fa-plus" aria-hidden="true"></i><span>{$core->get_Lang('Add blog')}</span>
            </button>
        {/capture}
        {capture name=blog_setting_url}{$PCMS_URL}/?mod={$mod}&act=setting{/capture}
        {include file="../components/list_v2/header.tpl"
            header_home_label=$core->get_Lang('Dashboard') header_module_label=$core->get_Lang('Blogs')
            header_title=$core->get_Lang('Blogs') header_count=$number_all
            header_subtitle=$core->get_Lang('Create and manage travel blogs to inspire your customers')
            header_actions=$smarty.capture.blog_header_actions header_setting_url=$smarty.capture.blog_setting_url
            header_setting_label=$core->get_Lang('Setting')
        }

        <section class="booking-filter-panel v2-filter-panel" aria-label="{$core->get_Lang('filter')}">
            <form id="forums" method="post" class="booking-filter-form blog-filter-form" action="" data-auto-filter="true">
                <div class="booking-field booking-search-field v2-field">
                    <label class="booking-field-label v2-field-label" for="blog_keyword">{$core->get_Lang('Search')}</label>
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input id="blog_keyword" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('Search blog title')}..." />
                </div>
                <div class="booking-field booking-select-field v2-field">
                    <label class="booking-field-label v2-field-label" for="blog_category">{$core->get_Lang('Category')}</label>
                    {assign var=all_category_label value=$core->get_Lang('All category')}
                    <select name="blogcat_id" class="iso-selectbox" data-width="100%" id="blog_category">{$clsBlogCategory->makeSelectboxOption($blogcat_id,$all_category_label)}</select>
                </div>
                <button type="button" class="booking-reset-btn blog-more-filter v2-btn v2-btn--neutral" id="blogMoreFilter" aria-expanded="false" aria-controls="blogAdvancedFilters">
                    <i class="fa fa-sliders" aria-hidden="true"></i>{$core->get_Lang('More filters')}
                </button>
                <button type="submit" class="booking-search-btn v2-btn v2-btn--primary" id="findtBtn"><i class="fa fa-search" aria-hidden="true"></i>{$core->get_Lang('Search')}</button>
                <a href="{$PCMS_URL}/?mod={$mod}" class="booking-reset-btn v2-btn v2-btn--neutral"><i class="fa fa-refresh" aria-hidden="true"></i>{$core->get_Lang('Reset')}</a>

                <div id="blogAdvancedFilters" class="blog-advanced-filters {if $is_approve_id|default:0 || $from_date|default:'' || $to_date|default:''}is-open{/if}">
                    <div class="booking-field booking-select-field v2-field">
                        <label class="booking-field-label v2-field-label" for="blog_approval">{$core->get_Lang('Approval status')}</label>
                        <select id="blog_approval" name="is_approve_id" class="iso-selectbox">
                            <option value="0">{$core->get_Lang('All approval statuses')}</option>
                            <option value="1" {if $is_approve_id|default:0 eq 1}selected{/if}>{$core->get_Lang('Approved')}</option>
                            <option value="2" {if $is_approve_id|default:0 eq 2}selected{/if}>{$core->get_Lang('Pending approval')}</option>
                        </select>
                    </div>
                    {include file="../components/list_v2/date_picker.tpl" date_picker_id="blog_from_date" date_picker_name="from_date" date_picker_value=$from_date_value|default:'' date_picker_placeholder="dd/mm/yyyy" date_picker_label=$core->get_Lang('Created from')}
                    {include file="../components/list_v2/date_picker.tpl" date_picker_id="blog_to_date" date_picker_name="to_date" date_picker_value=$to_date_value|default:'' date_picker_placeholder="dd/mm/yyyy" date_picker_label=$core->get_Lang('Created to') date_picker_auto_filter=true}
                </div>
                <input type="hidden" name="filter" value="filter" />
                <input type="hidden" name="type_list" value="{$type_list|default:''}" />
            </form>
        </section>

        <div class="booking-list-toolbar">
            {capture name=blog_status_tabs}
                <a href="{$PCMS_URL}/?mod={$mod}&recordperpage={$recordPerPage}" class="booking-status-tab v2-status-tab v2-status-tab--primary {if $type_list ne 'Publish' && $type_list ne 'Draft' && $type_list ne 'Trash'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('All')} <span>({$number_all})</span></a>
                <a href="{$PCMS_URL}/?mod={$mod}&recordperpage={$recordPerPage}&type_list=Publish" class="booking-status-tab v2-status-tab v2-status-tab--success {if $type_list eq 'Publish'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('Published')} <span>({$number_publish})</span></a>
                <a href="{$PCMS_URL}/?mod={$mod}&recordperpage={$recordPerPage}&type_list=Draft" class="booking-status-tab v2-status-tab v2-status-tab--warning {if $type_list eq 'Draft'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('Draft')} <span>({$number_draft})</span></a>
                <a href="{$PCMS_URL}/?mod={$mod}&recordperpage={$recordPerPage}&type_list=Trash" class="booking-status-tab v2-status-tab v2-status-tab--danger booking-status-tab--trash {if $type_list eq 'Trash'}is-active{/if} v2-tab"><i aria-hidden="true"></i>{$core->get_Lang('Trash')} <span>({$number_trash})</span></a>
                <a class="booking-bulk-delete btn-delete-all v2-tabs-delete" id="btn_delete" clsTable="Blog" style="display:none"><i class="fa fa-trash" aria-hidden="true"></i>{$core->get_Lang('Delete')}</a>
            {/capture}
            {include file="../components/list_v2/status_tabs.tpl" status_tabs_label=$core->get_Lang('status') status_tabs_content=$smarty.capture.blog_status_tabs}
            <div class="booking-list-toolbar__right">
                {capture name=blog_records_query}?mod={$mod}{$pUrl|default:''}{if $type_list}&type_list={$type_list}{/if}{/capture}
                {include file="../components/list_v2/records_per_page.tpl" records_per_page_id="blog_records_per_page"
                    records_per_page_label=$core->get_Lang('Records per page') records_per_page_value=$recordPerPage
                    records_per_page_base_url=$PCMS_URL records_per_page_query=$smarty.capture.blog_records_query}
            </div>
        </div>

        <input id="list_selected_chkitem" type="hidden" value="0" />
        <section class="list-table-v2-card booking-table-card v2-table-card">
            <div class="list-table-v2-scroll booking-table-scroll v2-table-scroll">
                <table class="list-table-v2 blog-list-table v2-table">
                    <thead><tr>
                        <th class="list-table-v2-check booking-check-cell"><input id="check_all" type="checkbox" class="el-checkbox" aria-label="{$core->get_Lang('Select all')}" /></th>
                        <th class="list-table-v2-image blog-image-column">{$core->get_Lang('Image')}</th>
                        <th class="list-table-v2-name">{$core->get_Lang('Blog Name')}</th>
                        <th class="list-table-v2-category is-center">{$core->get_Lang('Category')}</th>
                        <th class="list-table-v2-view is-center">{$core->get_Lang('Viewer')}</th>
                        {if $_loged_id eq 1 || $_user_group_id eq 5}<th class="list-table-v2-approved is-center">{$core->get_Lang('Approved')}</th>{/if}
                        <th class="list-table-v2-status is-center">{$core->get_Lang('status')}</th>
                        <th class="list-table-v2-action is-center list-table-action-cell">{$core->get_Lang('Action')}</th>
                    </tr></thead>
                    {if !empty($allItem) && $allItem[0].blog_id ne ''}
                        <tbody id="SortAble" class="sortByTd">
                            {section name=i loop=$allItem}
                                {assign var=blog_id value=$allItem[i].blog_id}
                                {assign var=blog_title value=$clsClassTable->getTitle($blog_id)}
                                <tr id="order_{$blog_id}">
                                    <td class="list-table-v2-check booking-check-cell"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$blog_id}" /></td>
                                    <td class="list-table-v2-image blog-image-cell list-table-media sortable">
                                        <img class="list-table-v2-thumb blog-thumb list-table-thumbnail v2-thumbnail" src="{$clsClassTable->getImage($blog_id,105,69)}" alt="{$blog_title}" onerror="this.onerror=null;this.classList.add('is-placeholder');this.src='{$URL_IMAGES}/none_image.png';" />
                                    </td>
                                    <td class="list-table-v2-name">
                                        <div class="list-table-v2-wrap blog-name-wrap list-table-heading list-table-heading-group">
                                            <a class="list-table-v2-title blog-name list-table-link" href="{$PCMS_URL}/blog/insert/{$blog_id}/overview"><span class="list-table-v2-key list-table-key">#{$blog_id}</span> - {$blog_title}</a>
                                            {if $allItem[i].is_trash eq '1'}<span class="list-table-v2-badge list-table-v2-badge--danger list-table-badge list-table-badge--danger v2-badge v2-badge--danger">{$core->get_Lang('intrash')}</span>{/if}
                                            {if $allItem[i].is_online eq '0' && $allItem[i].is_trash eq '0'}<span class="list-table-v2-badge list-table-v2-badge--warning list-table-badge list-table-badge--warning v2-badge v2-badge--warning status_draft">{$core->get_Lang('Draft')}</span>{/if}
                                        </div>
                                        <div class="list-table-v2-meta blog-meta list-table-meta">{$core->get_Lang('Created')}: {$clsISO->formatDateTime($allItem[i].reg_date,'d/m/Y H:i',0)} &nbsp;|&nbsp; {$core->get_Lang('Updated')}: {$clsISO->formatDateTime($allItem[i].upd_date,'d/m/Y H:i',0)}</div>
                                    </td>
                                    <td class="list-table-v2-category is-center">{if $allItem[i].cat_id}<a class="blog-category-badge list-table-badge v2-badge" href="{$PCMS_URL}/?mod={$mod}&blogcat_id={$allItem[i].cat_id}"><i class="fa-solid fa-folder" aria-hidden="true"></i>{$clsBlogCategory->getTitle($allItem[i].cat_id)}</a>{else}<span class="list-table-empty-value">&mdash;</span>{/if}</td>
                                    <td class="list-table-v2-view is-center">{$allItem[i].num_view|default:0}</td>
                                    {if $_loged_id eq 1 || $_user_group_id eq 5}
                                        <td class="list-table-v2-approved is-center"><span class="blog-approval {if $allItem[i].is_approve eq 1}is-approved{else}is-pending{/if}"><i class="fa {if $allItem[i].is_approve eq 1}fa-check-circle{else}fa-clock-o{/if}"></i>{if $allItem[i].is_approve eq 1}{$core->get_Lang('Approved')}{else}{$core->get_Lang('Pending')}{/if}</span></td>
                                    {/if}
                                    <td class="list-table-v2-status is-center">
                                        {if $allItem[i].is_trash eq 0}
                                            <a href="javascript:void(0);" class="SiteClickPublic list-table-v2-toggle list-table-toggle" clsTable="Blog" pkey="blog_id" toField="is_online" sourse_id="{$blog_id}" rel="{$allItem[i].is_online}" title="{$core->get_Lang('Click to change status')}" aria-label="{$core->get_Lang('Click to change status')}"><span class="list-table-toggle__track" aria-hidden="true"><span class="list-table-toggle__thumb"></span></span></a>
                                        {else}
                                            <span class="list-table-v2-badge list-table-v2-badge--danger blog-status is-trash"><i class="fa fa-circle"></i>{$core->get_Lang('Trash')}</span>
                                        {/if}
                                    </td>
                                    <td class="list-table-v2-action is-center list-table-action-cell">
                                        <div class="btn-group">
                                            <button class="list-table-v2-action-btn booking-row-menu list-table-action dropdown-toggle v2-action" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{$core->get_Lang('Action')}"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                {if $allItem[i].is_trash eq '0'}
                                                    <li><a class="dropdown-item" href="{$DOMAIN_NAME}{$clsClassTable->getLink($blog_id)}" target="_blank"><i class="fa fa-eye"></i> {$core->get_Lang('View')}</a></li>
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/blog/insert/{$blog_id}/overview"><i class="fa fa-edit"></i> {$core->get_Lang('Edit')}</a></li>
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=trash&blog_id={$core->encryptID($blog_id)}{$pUrl|default:''}&page={$currentPage}"><i class="fa fa-trash"></i> {$core->get_Lang('Trash')}</a></li>
                                                {else}
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/blog/insert/{$blog_id}/overview"><i class="fa fa-edit"></i> {$core->get_Lang('Edit')}</a></li>
                                                    <li><a class="dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=restore&blog_id={$core->encryptID($blog_id)}{$pUrl|default:''}&page={$currentPage}"><i class="fa fa-refresh"></i> {$core->get_Lang('Restore')}</a></li>
                                                    <li><a class="dropdown-item confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&blog_id={$core->encryptID($blog_id)}{$pUrl|default:''}&page={$currentPage}"><i class="fa fa-remove"></i> {$core->get_Lang('Delete')}</a></li>
                                                {/if}
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            {/section}
                        </tbody>
                    {else}
                        <tbody><tr><td colspan="{if $_loged_id eq 1 || $_user_group_id eq 5}8{else}7{/if}" class="booking-empty list-table-empty"><i class="fa fa-inbox"></i><span>{$core->get_Lang('nodata')}!</span></td></tr></tbody>
                    {/if}
                </table>
            </div>
            {include file="../components/list_v2/pagination.tpl"
                pagination_showing_label=$core->get_Lang('Showing') pagination_showing_start=$showingStart pagination_showing_end=$showingEnd
                pagination_of_label=$core->get_Lang('of') pagination_total_records=$totalRecord pagination_entity_label=$core->get_Lang('blogs')
                pagination_total_pages=$totalPage pagination_current_page=$currentPage pagination_previous_page=$previousPage pagination_next_page=$nextPage
                pagination_pages=$listPageNumber pagination_base_url=$PCMS_URL pagination_page_query=$link_page_current
                pagination_label=$core->get_Lang('pagination') pagination_previous_label=$core->get_Lang('Previous') pagination_next_label=$core->get_Lang('Next')}
        </section>
    </main>
</div>

<script type="text/javascript">
var $recordPerPage = '{$recordPerPage}', $currentPage = '{$currentPage}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/blog/jquery.blog.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/datepicker/jquery-ui.css?ver={$upd_version}-blog-date" />
<script type="text/javascript" src="{$URL_JS}/datepicker/jquery-ui.js?v={$upd_version}-blog-date"></script>
{literal}<script type="text/javascript">
(function($){
    var blogToday = new Date();
    blogToday.setHours(0, 0, 0, 0);
    $('#blog_from_date').datepicker({
        dateFormat:'dd/mm/yy', maxDate:blogToday, changeMonth:true, changeYear:true,
        numberOfMonths:1, showOtherMonths:true,
        onSelect:function(){
            var date=$(this).datepicker('getDate');
            $('#blog_to_date').datepicker('option','minDate',date);
            if (!$('#blog_to_date').datepicker('getDate') || $('#blog_to_date').datepicker('getDate') < date) {
                $('#blog_to_date').datepicker('setDate',date);
            }
        },
        onClose:function(){ $('#blog_to_date').focus(); }
    });
    $('#blog_to_date').datepicker({
        dateFormat:'dd/mm/yy', maxDate:blogToday, changeMonth:true, changeYear:true,
        numberOfMonths:1, showOtherMonths:true,
        onSelect:function(){ $(this).trigger('change'); }
    });
    $('#blogMoreFilter').on('click', function(){
        var $panel = $('#blogAdvancedFilters');
        $panel.toggleClass('is-open');
        $(this).attr('aria-expanded', $panel.hasClass('is-open') ? 'true' : 'false');
    });
    $('#SortAble').sortable({items:'tr',handle:'td.sortable',opacity:.8,cursor:'move',start:function(){vietiso_loading(1);},stop:function(){vietiso_loading(0);},update:function(){
        var order=$(this).sortable('serialize')+'&update=update&recordPerPage='+$recordPerPage+'&currentPage='+$currentPage;
        $.post(path_ajax_script+'/index.php?mod=blog&act=ajUpdPosSortBlog',order,function(){vietiso_loading(0);location.href=REQUEST_URI;});
    }});
})(jQuery);
</script>{/literal}
