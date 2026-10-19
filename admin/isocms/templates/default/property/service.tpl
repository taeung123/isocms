<link rel="stylesheet" href="{$URL_CSS}/style_tour_setting.css?v={$upd_version}" type="text/css" media="all" />
<div class="page-tour_setting iso-module-list">
{$core->getBlock('breadcrumb_tour_settings')}
	{$core->getBlock('header_title_tour_setting')}
	<div class="container-fluid container-fluid-2">
		{$core->getBlock('menu_tour_exhautive_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang('Addon Services')} </h2>
					<p>{$core->get_Lang("This function is intended to manage in isoCMS system")} Addon Services</p>
				</div>
				<div class="button_right">
					<a class="btn btn-main btn-addnew btnCreateService btnCreate" href="javascript:void(0);" title="{$core->get_Lang('Add new')}">{$core->get_Lang('Add new')}</a>
				</div>
			</div>
			<div class="wrap">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="filterbox">
						<div class="wrap">
							<div class="searchbox">
								<div class="searchbox-left">
									<i class="fa fa-search" aria-hidden="true"></i>
									<input type="text" class="text search_keyword" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('Search addon services by name...')}" />
								<a class="btn btn-text btn-main" href="javascript:void();" id="searchbtn" >
									{$core->get_Lang('Search')}
								</a>
									<a class="btn btn-delete-all "  clsTable="AddOnService" style="display: none;">{$core->get_Lang('Delete')}</a>
								</div>
								<div class="searchbox-right">
													{$core->get_Lang('Record/page')}:
										<select name="recordperpage" onchange="window.location = this.options[this.selectedIndex].value">
											<option {if $recordPerPage eq '20'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=20">20</option>
											{if $totalRecord gt '20'}
											<option {if $recordPerPage eq '50'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=50">50</option>
											{if $totalRecord gt '50'}
											<option {if $recordPerPage eq '100'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=100">100</option>
											{if $totalRecord gt '100'}
											<option {if $recordPerPage eq '200'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=200">200</option>
											{if $totalRecord gt '200'}
											<option {if $recordPerPage eq '{$totalRecord}'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage={$totalRecord}">{$core->get_Lang('All')}</option>
											{/if}
											{/if}
											{/if}
											{/if}
										</select>

						
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="filter" value="filter" />
				</form>
				<div class="clearfix"><br /></div>
    			<input id="list_selected_chkitem" style="display:none" value="0" />
				<div class="wrap">
					<div class="clearfix"></div>

					<div class="list-table-v2-card booking-table-card v2-table-card">
											<div class="hastable list-table-v2-scroll booking-table-scroll v2-table-scroll">
						<table cellspacing="0" class="list-table-v2 cruise-list-table v2-table" width="100%">
							<thead>
								 <tr>
								 	<th class="list-table-v2-check booking-check-cell booking-check-sort" style="width:40px">#</th>
									<th class="list-table-v2-check booking-check-cell booking-check-sort" style="width:40px"><input id="check_all" type="checkbox" /></th>
									<th class="list-table-v2-name" ><strong>{$core->get_Lang('Name')}</strong> <i class="sort-ico fa-solid fa-sort"></i></th>
									<th class="list-table-v2-name" style="    text-align: center;"><strong>{$core->get_Lang('Type')}</strong> <i class="sort-ico fa-solid fa-sort"></i></th>
									<th class="list-table-v2-public is-center" style="text-align:right; width:8%"><strong>{$core->get_Lang('Price from')}</strong> <i class="sort-ico fa-solid fa-sort"></i></th>
									<th class="list-table-v2-public is-center" style="width:80px"><strong>{$core->get_Lang('status')}</strong> <i class="sort-ico fa-solid fa-sort"></i></th>
									<th class="list-table-v2-action is-center list-table-action-cell" style="text-align:center;    padding-left: 3px;">Action</th>
								</tr>
							</thead>
							{if !empty($allItem) && $allItem[0].addonservice_id ne ''}
							<tbody id="SortAble" class="sortByTd ui-sortable">
								{section name=i loop=$allItem}

								<tr id="order_{$allItem[i].addonservice_id}"   class="{cycle values="row1,row2"}">
									<th class="index hiden767 sortable">
										<i class="fa fa-arrows" aria-hidden="true"></i>
									</th>
									<th class="check_40 booking-check-sort"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].addonservice_id}" /></th>
									<td class="name_service">
										<b>
											{$clsClassTable->getTitle($allItem[i].addonservice_id)}
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
											<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>
										{/if}
									</td>
									<td style="text-align: center;">
										{$clsClassTable->lstExtra($allItem[i].extra)}
									</td>
									<td data-title="{$core->get_Lang('price')}" class="block_responsive border_top_responsive" style="text-align:right; white-space:nowrap">
										<strong class="format_price">{$clsClassTable->getPrice($allItem[i].addonservice_id)} USD</strong>
									</td>
									<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
										<a href="javascript:void(0);" class="SiteClickPublic" clsTable="AddOnService" pkey="addonservice_id" sourse_id="{$allItem[i].addonservice_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].addonservice_id)}" title="{$core->get_Lang('Click to change status')}">
											{if $clsClassTable->getOneField('is_online',$allItem[i].addonservice_id) eq '1'}
											<i class="fa-solid fa-circle-check green"></i>
											{else}
											<i class="fa-solid fa-circle-minus red"></i>
											{/if}
										</a>
									</td>
									<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
										<div class="btn-group">
											<div class="dropdown">
												<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
													<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
												</button>

												<ul class="dropdown-menu dropdown-menu-end">
													{if $allItem[i].is_trash eq '0'}
														<li>
															<a class="dropdown-item btn_edit_service" title="{$core->get_Lang('edit')}" href="javascript:void(0);" data="{$allItem[i].addonservice_id}">
																<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
															</a>
														</li>
														<li>
															<a class="dropdown-item" title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&addonservice_id={$core->encryptID($allItem[i].addonservice_id)}">
																<i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span>
															</a>
														</li>
													{else}
														<li>
															<a class="dropdown-item" title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&addonservice_id={$core->encryptID($allItem[i].addonservice_id)}">
																<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
															</a>
														</li>
														<li>
															<a class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&addonservice_id={$core->encryptID($allItem[i].addonservice_id)}">
																<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
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

					<div class="clearfix"></div>
					{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type|default:'')}
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/property/jquery.addonservice.js"></script>

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
			$.post(path_ajax_script+"/index.php?mod=property&act=ajUpdPosSortServiceTour", order,

			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}