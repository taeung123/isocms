<link rel="stylesheet" href="{$URL_CSS}/style_tour_setting.css?v={$upd_version}" type="text/css" media="all" />
<div class="page-tour_setting iso-module-list">
	{$core->getBlock('breadcrumb_tour_settings')}

	{$core->getBlock('header_title_tour_setting')}
    <div class="container-fluid container-fluid-2 ">
        {$core->getBlock('menu_tour_exhautive_setting')}

<div class="content_setting_box">

    {* PAGE HEADER *}
    <div class="page_detail-title d-flex">
        <div class="title">
            <h2>{$core->get_Lang('Travel Styles by Country list')}</h2>
            <p>{$core->get_Lang("This function is intended to manage in isoCMS system")} Travel Styles by Country</p>
        </div>

        <div class="button_right">
            <a class="btn btn-main btn-addnew add_new_category_country btnCreate" 
               href="javascript:void(0);"
               title="{$core->get_Lang('Add')}">
                {$core->get_Lang('Add new')}
            </a>
        </div>
    </div>

    {* FILTER BAR *}
    <div class="filter_box">
        <form id="forums" method="post" class="filterForm" action="">

            <div class="filterbox">
                <div class="wrap">

                    <div class="searchbox">

                        {* FILTER COUNTRY *}
                        <div class="searchbox-left">
                            <select onchange="_reload()"
                                    name="country_id"
                                    class="form-control">
                                {$clsCountry->makeSelectboxOption($country_id)}
                            </select>

                            <button type="submit"
                                    class="btn btn-text btn-main"
                                    id="findtBtn">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                {$core->get_Lang('Search')}
                            </button>
                            <a class="btn btn-delete-all "  clsTable="AddOnService" style="display: none;">{$core->get_Lang('Delete')}</a>
                        </div>

                        {* RECORDS PER PAGE RIGHT *}
                        <div class="searchbox-right">
                            <label>{$core->get_Lang('Record/page')}</label>
                            {$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl|default:'')}
                        </div>

                    </div>

                    <input type="hidden" name="filter" value="filter" />

                </div>
            </div>

            <!-- <div class="form-group form-button">
                <a class="btn btn-delete-all"
                   id="btn_delete"
                   clsTable="Category_Country"
                   style="display:none;">
                    {$core->get_Lang('Delete')}
                </a>
            </div> -->

        </form>

        {* BACK TO TRAVEL STYLES LIST *}
        <!-- <div class="group_buttons">
            <a href="{$PCMS_URL}/?mod={$mod}&act=category"
               class="btn btn-warning btnNew"
               title="{$core->get_Lang('Travel Styles list')}">
                <i class="icon-list icon-white" aria-hidden="true"></i>
                <span>{$core->get_Lang('Travel Styles list')}</span>
            </a>
        </div> -->
    </div>

    <div class="clearfix"></div>

    <input id="list_selected_chkitem" style="display:none" value="0" />

    {* TABLE CARD *}
    <div class="list-table-v2-card booking-table-card v2-table-card">
        <div class="hastable list-table-v2-scroll booking-table-scroll v2-table-scroll">

            <table cellspacing="0"
                   class="list-table-v2 cruise-list-table v2-table"
                   width="100%">

                <thead>
                    <tr>
                        <th class="list-table-v2-check booking-check-cell list-table-v2-sortdrop"
                            style="width:40px">#</th>

                        <th class="list-table-v2-check booking-check-cell booking-check-sort"
                            style="width:50px">
                            <input id="check_all" type="checkbox" />
                        </th>

                        {if $clsConfiguration->getValue('SiteHasCat_Tours')}
                            <th class="list-table-v2-name name_responsive"
                                style="text-align:left;padding-left:15px;">
                                <strong>{$core->get_Lang('Name')}</strong> <i class="sort-ico fa-solid fa-sort"></i>
                            </th>
                        {/if}

                        <th class="list-table-v2-name name_responsive"
                            style="text-align:center">
                            <strong>{$core->get_Lang('Image')}</strong><i class="sort-ico fa-solid fa-sort"></i>
                        </th>

                        <th class="list-table-v2-name hiden_responsive"
                            style="text-align:left;min-width:1px">
                            <strong>{$core->get_Lang('Country')}</strong> <i class="sort-ico fa-solid fa-sort"></i>
                        </th>

                        <th class="list-table-v2-public hiden_responsive"
                            style="width:100px">
                            <strong>{$core->get_Lang('status')}</strong> <i class="sort-ico fa-solid fa-sort"></i>
                        </th>

                        <th class="list-table-v2-action is-center list-table-action-cell"
                            style="width:80px">
                            <strong>{$core->get_Lang('Action')}</strong>
                        </th>
                    </tr>
                </thead>

                {if !empty($allItem) && $allItem[0].category_country_id ne ''}

                    <tbody id="SortAble" class="sortByTd ui-sortable">

                        {section name=i loop=$allItem}

                            <tr id="order_{$allItem[i].category_country_id}"
                                class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">

                                {* SORT HANDLE *}
                                <td class="index hiden767 sortable">
                                    <i class="fa fa-arrows" aria-hidden="true"></i>
                                </td>

                                {* CHECKBOX *}
                                <td class="check_40 has-checkbox text-center booking-check-sort">
                                    <input name="p_key[]"
                                           class="chkitem el-checkbox"
                                           type="checkbox"
                                           value="{$allItem[i].category_country_id}" />
                                </td>

                                {* TRAVEL STYLE NAME *}
                                {if $clsConfiguration->getValue('SiteHasCat_Tours')}
                                    <td class="name_service">

                                        <b>

                                            {* {if $clsClassTable->getOneField('is_online',$allItem[i].category_country_id) eq 0}
                                                <span style="color:#F90">[PRIVATE]</span>
                                            {/if}*}

                                            <a href="{$PCMS_URL}/index.php?mod={$mod}&cat_id={$allItem[i].cat_id}">
                                                {$clsTourCategory->getTitle($allItem[i].cat_id)}
                                            </a>
                                        </b>
		    <div class="v2-meta list-table-v2-meta tour-meta list-table-meta">
													{$core->get_Lang('Created')}: {$clsISO->formatDateTime($allItem[i].reg_date,'d/m/Y H:i',0)} &nbsp;|&nbsp; 
													{$core->get_Lang('Updated')}: {$clsISO->formatDateTime($allItem[i].upd_date,'d/m/Y H:i',0)}
												</div>
                          <div class="v2-meta list-table-v2-meta tour-meta list-table-meta">
                                        {$core->get_Lang('Created By')}: 
                               {if $allItem[i].user_id gt 0}
																{assign var=firstName value=$clsUser->getOneField('first_name', $allItem[i].user_id)}
																{assign var=lastName value=$clsUser->getOneField('last_name', $allItem[i].user_id)}
																{assign var=fullName value="`$firstName|default:''` `$lastName|default:''`"}
																{$fullName|trim|default:'N/A'}
														{else}
																N/A
														{/if}
                                 </div>    
                                        {if $allItem[i].is_trash eq '1'}
                                            <span class="fr" style="color:#CCC">
                                                {$core->get_Lang('intrash')}
                                            </span>
                                        {/if}

                                        <button type="button"
                                                class="toggle-row inline_block767"
                                                style="display:none">
                                            <i class="fa fa-caret fa-caret-down" aria-hidden="true"></i>
                                        </button>

                                    </td>
                                {/if}

                                
                            <td class="list-table-image" style="text-align: center;">
                                {assign var=imageUrl value=$clsClassTable->getImage($allItem[i].category_country_id, 60, 60)}
  
                                
                                <img
                                    src="{$imageUrl|escape:'html'}"
                                    width="60"
                                    height="60"
                                    alt="{$clsTourCategory->getTitle($allItem[i].cat_id)|escape:'html'}"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='{$URL_IMAGES}/noimage.png';"
                                />
                            </td>


                                {* COUNTRY *}
                                <td class="block_responsive border_top_responsive" style="width: 20px;"
                                    data-title="{$core->get_Lang('Country')}">
                                    <strong>
                                        {$clsCountry->getTitle($allItem[i].country_id)}
                                    </strong>
                                </td>

                                {* STATUS *}
                                <td class="block_responsive"
                                    data-title="{$core->get_Lang('status')}">

                                    <a href="javascript:void(0);"
                                       class="SiteClickPublic"
                                       clsTable="Category_Country"
                                       pkey="{$pkeyTable}"
                                       sourse_id="{$allItem[i].$pkeyTable}"
                                       rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}"
                                       title="{$core->get_Lang('Click to change status')}">

                                        {if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}
                                            <i class="fa-solid fa-circle-check green" aria-hidden="true"></i>
                                        {else}
                                            <i class="fa-solid fa-circle-minus red" aria-hidden="true"></i>
                                        {/if}

                                    </a>
                                </td>

                                {* ACTION DROPDOWN *}
                                <td class="block_responsive text-center list-table-action-cell"
                                    data-title="{$core->get_Lang('func')}"
                                    style="vertical-align:middle;text-align:center;width:80px;white-space:nowrap;">

                                    <div class="btn-group">
                                        <div class="dropdown">

                                            <button class="btn btn_dropdown dropdown-toggle"
                                                    type="button"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">

                                                {if $allItem[i].is_trash eq '0'}

                                                    {assign var=country_id value=$clsClassTable->getOneField('country_id',$allItem[i].$pkeyTable)}
                                                    {assign var=cat_id value=$clsClassTable->getOneField('cat_id',$allItem[i].$pkeyTable)}

                                                    {* VIEW *}
                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="{$DOMAIN_NAME}{$clsTourCategory->getLink($allItem[i].cat_id)|default:'#'}"
                                                           target="_blank"
                                                           title="{$core->get_Lang('view')}">
                                                            <i class="icon-eye-open" aria-hidden="true"></i>
                                                            <span>{$core->get_Lang('view')}</span>
                                                        </a>
                                                    </li>

                                                    {* EDIT *}
                                                    <li>
                                                        <a class="dropdown-item"
                                                           title="{$core->get_Lang('edit')}"
                                                           href="{$PCMS_URL}/tour/categorycountry/insert/{$allItem[i].category_country_id}/overview">
                                                            <i class="icon-edit" aria-hidden="true"></i>
                                                            <span>{$core->get_Lang('edit')}</span>
                                                        </a>
                                                    </li>

                                                    {* TRASH *}
                                                    <li>
                                                        <a class="dropdown-item"
                                                           title="{$core->get_Lang('trash')}"
                                                           href="{$PCMS_URL}/?mod={$mod}&act=trash2&category_country_id={$core->encryptID($allItem[i].category_country_id)}">
                                                            <i class="icon-trash" aria-hidden="true"></i>
                                                            <span>{$core->get_Lang('trash')}</span>
                                                        </a>
                                                    </li>

                                                {else}

                                                    {* RESTORE *}
                                                    <li>
                                                        <a class="dropdown-item"
                                                           title="{$core->get_Lang('restore')}"
                                                           href="{$PCMS_URL}/?mod={$mod}&act=restore2&category_country_id={$core->encryptID($allItem[i].category_country_id)}{$pUrl}">
                                                            <i class="icon-refresh" aria-hidden="true"></i>
                                                            <span>{$core->get_Lang('restore')}</span>
                                                        </a>
                                                    </li>

                                                    {* DELETE PERMANENTLY *}
                                                    <li>
                                                        <a class="dropdown-item confirm_delete"
                                                           title="{$core->get_Lang('delete')}"
                                                           href="{$PCMS_URL}/?mod={$mod}&act=delete2&category_country_id={$core->encryptID($allItem[i].category_country_id)}{$pUrl}">
                                                            <i class="icon-remove" aria-hidden="true"></i>
                                                            <span>{$core->get_Lang('delete')}</span>
                                                        </a>
                                                    </li>

                                                {/if}

                                            </ul>
                                        </div>
                                    </div>

                                </td>

                            </tr>

                        {/section}

                    </tbody>

                {else}

                    <tbody>
                        <tr>
                            <td colspan="6" style="text-align:center">
                                {$core->get_Lang('nodata')}
                            </td>
                        </tr>
                    </tbody>

                {/if}

            </table>

        </div>
    </div>

    {* PAGINATION *}
    <div class="clearfix"></div>

    {$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type|default:'')}

</div>

    </div>
</div>
<script type="text/javascript">
    var country_id = "{$country_id}";
    var $recordPerPage = '{$recordPerPage}';
    var $currentPage = '{$currentPage}';
</script>
<script type="text/javascript"
        src="{$URL_THEMES}/tour_exhautive/js/jquery.category_country.js?v={$upd_version}"></script>
{literal}
<style>
    #findtBtn{
            height: 46px;
    min-width: 111px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    padding: 0px 18px;
    border-radius: 9px;
    background: rgb(32, 75, 137);
    border-width: 1px;
    border-style: solid;
    border-color: rgb(32, 75, 137);
    border-image: none;
    text-decoration: none;
    }
    .dropdown-menu-end li{
        padding: 5px;
    }
    .searchbox-left .fa-search{
            margin-right: 10px;
    }
    @media (max-width: 767px) {
        #findtBtn{
            min-width: 100%;
        }
    }
</style>
    <script type="text/javascript">
        $("#SortAble").sortable({
    items: '> tr',
    handle: 'th.sortable',
    opacity: 0.8,
    cursor: 'move',
            start: function () {
                vietiso_loading(1);
            },
            stop: function () {
                vietiso_loading(0);
            },
            update: function () {
                var recordPerPage = $recordPerPage;
                var currentPage = $currentPage;
                var order = $(this).sortable("serialize") + '&update=update' + '&recordPerPage=' + recordPerPage + '&currentPage=' + currentPage;
                $.post(path_ajax_script + "/index.php?mod=tour&act=ajUpdPosSortTravelStylebyCountry", order,

                    function (html) {
                        vietiso_loading(0);
                        location.href = REQUEST_URI;
                    });
            }
        });
    </script>
{/literal}
