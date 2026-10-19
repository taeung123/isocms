<link rel="stylesheet" href="{$URL_CSS}/style_tour_setting.css?v={$upd_version}" type="text/css" media="all" />
<div class="page-tour_setting iso-module-list">
    {$core->getBlock('breadcrumb_tour_settings')}

	{$core->getBlock('header_title_tour_setting')}
	<div class="container-fluid container-fluid-2">
		{$core->getBlock('menu_tour_exhautive_setting')}

<div class="content_setting_box">

    {* PAGE HEADER *}
    <div class="page_detail-title d-flex">
        <div class="title">
            <h2>{$core->get_Lang('Transportations')}</h2>
            <p>{$core->get_Lang("This function is intended to manage in isoCMS system")} Transportations</p>
        </div>

        <div class="button_right">
            <a class="btn btn-main btn-addnew btnCreateService btnCreate"
               href="javascript:void(0);"
               title="{$core->get_Lang('Add new')}">
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

                        {* SEARCH LEFT *}
                        <div class="searchbox-left">
                            <i class="fa fa-search" aria-hidden="true"></i>

                            <input type="text"
                                   class="text search_keyword"
                                   name="keyword"
                                   value="{$keyword|default:''}"
                                   placeholder="{$core->get_Lang('Search transportations by name...')}" />

                            <a class="btn btn-text btn-main"
                               href="javascript:void(0);"
                               id="searchbtn">
                                {$core->get_Lang('Search')}
                            </a>
                                            <a class="btn btn-delete-all"
                                id="btn_delete"
                                clstable="Transport"
                                style="display:none;">
                                    {$core->get_Lang('Delete')}
                                </a>
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


        </form>
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
                        <th class="list-table-v2-check booking-check-cell booking-check-sort"
                            style="width:40px">#</th>

                        <th class="list-table-v2-check booking-check-cell booking-check-sort"
                            style="width:50px">
                            <input id="check_all" type="checkbox" />
                        </th>

                        <th class="list-table-v2-name name_responsive name_responsive3"
                            style="text-align:left;">
                            <strong>{$core->get_Lang('Name')}</strong> <i class="sort-ico fa-solid fa-sort"></i>
                        </th>

                        <th class="list-table-v2-name image_responsive"
                            style="width:80px">
                            <strong>{$core->get_Lang('Image')}</strong> <i class="sort-ico fa-solid fa-sort"></i>
                        </th>
                        <th class="list-table-v2-public hiden_responsive"
                            style="width:100px">
                            <strong>{$core->get_Lang('status')}</strong> <i class="sort-ico fa-solid fa-sort"></i>
                        </th>

                        <th class="list-table-v2-action is-center list-table-action-cell"
                            style="text-align:center;width:80px">{$core->get_Lang('Action')}</th>
                    </tr>
                </thead>

                {if !empty($allItem) && $allItem[0].transport_id ne ''}

                    <tbody id="SortAble" class="sortByTd ui-sortable">

                        {section name=i loop=$allItem}

                            <tr id="order_{$allItem[i].transport_id}"
                                class="{cycle values="row1,row2"}">

                                {* SORT HANDLE *}
                                <td class="index hiden767 sortable">
                                    <i class="fa fa-arrows" aria-hidden="true"></i>
                                </td>

                                {* CHECKBOX *}
                                <td class="check_40 has-checkbox text-center booking-check-sort">
                                    <input name="p_key[]"
                                           class="chkitem el-checkbox"
                                           type="checkbox"
                                           value="{$allItem[i].transport_id}" />
                                </td>

                                                                {* TRANSPORT NAME *}
                                <td class="name_service">
                                    <b>{$clsClassTable->getTitle($allItem[i].transport_id)}</b>

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
                                </td>

                                {* IMAGE *}
                                <td class="list-table-image image_responsive">
                                    {if $clsClassTable->getImageUrl($allItem[i].transport_id)}
                                        <img src="{$clsClassTable->getImage($allItem[i].transport_id,60,40)}"
                                             width="60"
                                             alt="{$clsClassTable->getTitle($allItem[i].transport_id)|escape:'html'}" />
                                    {/if}
                                </td>



                                {* STATUS *}
                                <td class="block_responsive"
                                    data-title="{$core->get_Lang('status')}">

                                    <a href="javascript:void(0);"
                                       class="SiteClickPublic"
                                       clsTable="Transport"
                                       pkey="transport_id"
                                       sourse_id="{$allItem[i].transport_id}"
                                       rel="{$clsClassTable->getOneField('is_online',$allItem[i].transport_id)}"
                                       title="{$core->get_Lang('Click to change status')}">

                                        {if $clsClassTable->getOneField('is_online',$allItem[i].transport_id) eq '1'}
                                            <i class="fa-solid fa-circle-check green"></i>
                                        {else}
                                            <i class="fa-solid fa-circle-minus red"></i>
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

                                                    {* EDIT *}
                                                    <li>
                                                        <a class="dropdown-item btn_edit_transport"
                                                           title="{$core->get_Lang('edit')}"
                                                           href="javascript:void(0);"
                                                           data="{$allItem[i].transport_id}">
                                                            <i class="icon-edit"></i>
                                                            <span>{$core->get_Lang('edit')}</span>
                                                        </a>
                                                    </li>

                                                    {* TRASH *}
                                                    <li>
                                                        <a class="dropdown-item"
                                                           title="{$core->get_Lang('trash')}"
                                                           href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&transport_id={$core->encryptID($allItem[i].transport_id)}">
                                                            <i class="icon-trash"></i>
                                                            <span>{$core->get_Lang('trash')}</span>
                                                        </a>
                                                    </li>

                                                {else}

                                                    {* RESTORE *}
                                                    <li>
                                                        <a class="dropdown-item"
                                                           title="{$core->get_Lang('restore')}"
                                                           href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&transport_id={$core->encryptID($allItem[i].transport_id)}">
                                                            <i class="icon-refresh"></i>
                                                            <span>{$core->get_Lang('restore')}</span>
                                                        </a>
                                                    </li>

                                                    {* DELETE *}
                                                    <li>
                                                        <a class="dropdown-item confirm_delete"
                                                           title="{$core->get_Lang('delete')}"
                                                           href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&transport_id={$core->encryptID($allItem[i].transport_id)}">
                                                            <i class="icon-remove"></i>
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
<script type="text/javascript" src="{$URL_THEMES}/property/jquery.transport.js"></script>
<script type="text/javascript">var $recordPerPage = '{$recordPerPage}';var $currentPage = '{$currentPage}';</script>
{literal}
<script type="text/javascript">
	$("#SortAble").sortable({
		items: 'tr',
		handle: 'th.sortable',
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
			$.post(path_ajax_script+"/index.php?mod=property&act=ajUpdPosSortTransport", order, 

			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}