{assign var=day value=$core->get_Lang('day')}
{assign var=days value=$core->get_Lang('days')}
<div class="page_container page_{$mod}">
	<div class="page-title d-flex flex-wrap justify-content-between" style="background: inherit">
        <div class="title">
			<h2>{$core->get_Lang('Tours')} ({$number_all})</h2>
			<p>{$core->get_Lang('This function is intended to manage tours in isoCMS system')}</p>
		</div>
		<div class="button_right d-flex flex-wrap" style="gap:5px">
			{if $clsISO->checkConnTMS()}
				{if 0}
				<a class="btn btn-success syncTourAPI" href="{$PCMS_URL}/?mod={$mod}&act=syncTourAPI" title="{$core->get_Lang('syncTourAPIfromTMS')}">{$core->get_Lang('syncTourAPIfromTMS')} <i class="fa fa-reply-all" aria-hidden="true"></i></a>
				<a class="btn btn-primary syncTourAPItoTMS" href="{$PCMS_URL}/?mod={$mod}&act=syncTourAPItoTMS" title="{$core->get_Lang('syncTourAPItoTMS')}">{$core->get_Lang('syncTourAPItoTMS')} <i class="fa fa-share" aria-hidden="true"></i></a>
				{/if}
				<a class="btn btn-success btn-addnew open_syncTourAPI" syncTourAPI href="javascript:void(0)" title="{$core->get_Lang('syncTourAPIfromTMS')}">{$core->get_Lang('syncTourAPIfromTMS')} <i class="fa fa-reply-all" aria-hidden="true"></i></a>
				<a class="btn btn-primary btn-addnew open_syncTourtoTMS" syncTourAPItoTMS href="javascript:void(0)" title="{$core->get_Lang('syncTourAPItoTMS')}">{$core->get_Lang('syncTourAPItoTMS')} <i class="fa fa-share" aria-hidden="true"></i></a>
		   	{/if}
		   	{if $package_id==4}
			<form method="post" action="">
				<button type="submit" class="btn btn-addnew btn-export" id="btn_export">Export <i class="fa fa-arrow-down" aria-hidden="true" style="border-bottom: 2px solid #fff"></i></button>
				<input type="hidden" value="export_tour" name="export_tour">
			</form>
			{/if}
			{if $clsConfiguration->getValue('ai_tour_enabled') eq '1'}
			<button type="button" class="btn btn-addnew" id="btn_open_auto_ai_modal" style="background: linear-gradient(135deg, #7c3aed, #4f46e5); border: none; color: #fff; font-weight: 600; box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);">
				<i class="fa fa-magic" style="margin-right: 6px;"></i> {$core->get_Lang('Create with AI')}
			</button>
			{/if}
			<a class="btn btn-main btn-addnew {if $is_day_trip|default:'' eq '1'}add_new_day_trip{else}add_new_tour{/if}" title="{$core->get_Lang('Add Tour')}">{$core->get_Lang('Add Tour')}</a>
			<div class="btn btn-setting"><a href="{$PCMS_URL}/?mod={$mod}&act=setting" title="{$core->get_Lang('Setting')}"><i class="fa fa-cog" aria-hidden="true"></i></a></div>
		</div>
    </div>
	<div class="container-fluid">
		<div class="wrap">
			<div class="statistical mb5">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}..." />
					</div>
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'group ','default') && $_LANG_ID eq 'vn'}
					<div class="form-group">
						<select name="tour_group_id" class="form-control iso-selectbox" data-width="100%" tp="ajax" id="slb_TourGroup">
							{$clsTourGroup->makeSelectboxOption($tour_group_id)}
						</select>
					</div>
					{/if}
					<div class="form-group">
						<select name="cat_id" class="form-control iso-selectbox" data-width="100%" id="slb_Category">
							{$clsTourCat->makeSelectboxOption($tour_group_id, $cat_id, $is_set)}
						</select>
					</div>
					<div class="form-group">
						<select name="number_day" class="form-control iso-selectbox" data-width="100%">
							 <option value="0">{$core->get_Lang('Itinerary')}</option>
							 {$clsISO->makeSelectNumber2(30,$number_day,"$day,$days")}
						</select>
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang("Search")}</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button">
						<a class="btn btn-delete-all" id="btn_delete" clsTable="Tour" style="display:none">
							{$core->get_Lang('Delete')}
						</a>
					</div>
				</form>	
				<div class="gr-button-right">
					<div class="fr group_buttons mb-3">
						<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning btnNew"><i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
						<a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger btnNew"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
						
					</div>
					<div class="record_per_page">
						<label>{$core->get_Lang('Record/page')}</label>
						{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl)}
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="tabbox">
				<div class="hastable">
					{assign var = SiteHasCat_Tours value = $clsISO->getCheckActiveModulePackage($package_id,$mod,'category ','default')}
					<table cellspacing="0" class="table table-striped tbl-grid table_responsive" width="100%">
						<thead><tr>
							<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" class="el-checkbox" /></th>
							<th class="gridheader name_responsive" style="text-align:left" colspan="2"><strong>{$core->get_Lang('Name tour')}</strong></th>
							<th class="gridheader text-left hiden_responsive"><strong>{$core->get_Lang('Duration')}</strong></th>
							<th class="gridheader hiden_responsive text-right" width="6%"><strong>{$core->get_Lang('Price')}</strong></th>
							<th class="gridheader text-center hiden_responsive"><strong>{$core->get_Lang('Status')}</strong></th>
							<th class="gridheader text-center hiden_responsive" width="100px"></th>
						</tr></thead>
						{if !empty($allItem) && !empty($allItem.0.tour_id)}
							<tbody id="SortAble" class="sortByTd">
								{foreach from=$allItem item=item}
									{assign var="tour_id" value=$item.tour_id}
									{assign var="nameServices" value=$clsClassTable->getTitle($tour_id)}
									{assign var="oneUserCreator" value=$clsUser->getOne($item.user_id, 'first_name,last_name')}
									{assign var="oneUserUpdate" value=$clsUser->getOne($item.user_id_update, 'first_name,last_name')}

									<tr id="order_{$tour_id}" class="sortable">
										<td class="check_40 has-checkbox text-center">
											<input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$tour_id}" />
										</td>

										<td class="index hiden767">
											<img src="{$clsClassTable->getImage($tour_id,105,69)}"
												alt="Image"
												width="105"
												height="69"
												onerror="this.src='{$URL_IMAGES}/none_image.png'" />
										</td>

										<td class="text-left name_service">
											<div class="box_name_services">
												<p class="txt_name_services">
													{if $item.is_trash eq '1'}<span class="text-muted">{$core->get_Lang('In Trash')} - </span>{/if}
													<a href="{$PCMS_URL}/tour/edit/{$tour_id}/overview" title="{$nameServices}">
														<span class="txt_tour_id">#{$tour_id}</span>
														{if $nameServices}- {$nameServices}{/if}
													</a>
												</p>
												<p class="txt_info">
													{if !empty($oneUserCreator)}
													<span>
														{$core->get_Lang("Created")}: {$oneUserCreator.first_name|default:''} {$oneUserCreator.last_name|default:''}
														{$clsISO->formatDateTime($item.reg_date, "d/m/Y H:i", 0)}
													</span> |
													<span>
														{$core->get_Lang("Update")}: {$oneUserUpdate.first_name|default:''} {$oneUserUpdate.last_name|default:''}
														{$clsISO->formatDateTime($item.upd_date, "d/m/Y H:i", 0)}
													</span>
													{/if}
												</p>
												<div>
													{if !empty($item.is_for_agent)}<span class="btn_sale_agent">{$core->get_Lang('Agent')}</span>{/if}
													{if $clsISO->checkConnTMS() && (!empty($item.yield_id) || !empty($item.tms_code))}
														<span class="btn_connect is_connect_tms">{$core->get_Lang('TravelMaster')}</span>
													{/if}
													<span class="btn_connect is_connect_itrsm hidden">{$core->get_Lang('iTourism')}</span>
													
												</div>
											</div>
											<button type="button" class="toggle-row inline_block767" style="display:none">
												<i class="fa fa-caret fa-caret-down"></i>
											</button>
										</td>

										<td class="text-left block_responsive border_top_responsive" style="white-space:nowrap"
											data-title="{$core->get_Lang('Duration')}">
											{$clsClassTable->getTripDuration2020($tour_id,'/ ')}
										</td>

										<td class="block_responsive" style="text-align:right; white-space:nowrap"
											data-title="{$core->get_Lang('Price from')}">
											{assign var="price" value=$clsClassTable->getTripPriceNewPro2020($tour_id, $now_day, 0, 'value')}
											<span class="format_price_new">
												{if $price gt 0}
													{$price} <u>{$clsISO->getShortRate()}</u>
												{else}
													0 <u>{$clsISO->getShortRate()}</u>
												{/if}
											</span>
										</td>

										<td class="block_responsive" style="text-align:center"
											data-title="{$core->get_Lang('Status')}">
											<a href="javascript:void(0);" class="SiteClickPublic"
											clsTable="Tour" pkey="tour_id" sourse_id="{$tour_id}"
											rel="{$item.is_online}" title="{$core->get_Lang('Click to change status')}">
												{if $item.is_online eq '1'}
													<i class="fa-solid fa-circle-check green"></i>
												{else}
													<i class="fa-solid fa-circle-minus red"></i>
												{/if}
											</a>
										</td>

										<td class="block_responsive text-center" style="white-space:nowrap;"
											data-title="{$core->get_Lang('func')}">
											<div class="d-flex align-items-center" style="gap:5px">
												<a data-href="{$DOMAIN_NAME}{$clsClassTable->getLink($tour_id)}"
												title="{$nameServices}"
												class="btn_preview_tour icon_action edit_review"
												target="_blank">
													<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
														<path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" fill="#1756C8"/>
														<path d="M19.3375 9.7875C18.6024 7.88603 17.3262 6.24164 15.6668 5.05755C14.0073 3.87347 12.0372 3.20161 10 3.125C7.96283 3.20161 5.99275 3.87347 4.33326 5.05755C2.67377 6.24164 1.39761 7.88603 0.662509 9.7875C0.612863 9.92482 0.612863 10.0752 0.662509 10.2125C1.39761 12.114 2.67377 13.7584 4.33326 14.9424C5.99275 16.1265 7.96283 16.7984 10 16.875C12.0372 16.7984 14.0073 16.1265 15.6668 14.9424C17.3262 13.7584 18.6024 12.114 19.3375 10.2125C19.3872 10.0752 19.3872 9.92482 19.3375 9.7875ZM10 14.0625C9.19652 14.0625 8.41108 13.8242 7.743 13.3778C7.07493 12.9315 6.55423 12.297 6.24675 11.5547C5.93927 10.8123 5.85882 9.99549 6.01557 9.20745C6.17232 8.4194 6.55924 7.69553 7.12739 7.12738C7.69554 6.55923 8.41941 6.17231 9.20745 6.01556C9.9955 5.85881 10.8123 5.93926 11.5547 6.24674C12.297 6.55422 12.9315 7.07492 13.3779 7.743C13.8242 8.41107 14.0625 9.19651 14.0625 10C14.0609 11.0769 13.6323 12.1093 12.8708 12.8708C12.1093 13.6323 11.0769 14.0608 10 14.0625Z" fill="#1756C8"/>
													</svg>
												</a>

												<a title="{$core->get_Lang('duplicate')}"
												class="ajDuplicateTour"
												data-name_services="{$nameServices}"
												tour_id="{$tour_id}" href="#">
													<i class="fa fa-clone" aria-hidden="true"></i>
												</a>
												<div class="btn-group">
													<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
													<ul class="dropdown-menu dropdown-menu-end">
														{if $item.is_trash eq '0'}
															<li>
																<a class="dropdown-item" title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/tour/edit/{$tour_id}/overview">
																	<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
																</a>
															</li>
															<li>
																<a class="dropdown-item" title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&tour_id={$core->encryptID($tour_id)}{$pUrl}&page={$currentPage}">
																	<i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span>
																</a>
															</li>
														{else}
															<li>
																<a class="dropdown-item" title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&tour_id={$core->encryptID($tour_id)}{$pUrl}&page={$currentPage}">
																	<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
																</a>
															</li>
															<li>
																<a class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act=delete&tour_id={$core->encryptID($tour_id)}{$pUrl}&page={$currentPage}">
																	<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
																</a>
															</li>
														{/if}
														{if $clsISO->checkConnTMS() && (!empty($item.yield_id) || !empty($item.tms_code))}
															<li>
																<a class="dropdown-item" title="{$core->get_Lang('syncTourAPIfromTMS')}" href="{$PCMS_URL}/?mod={$mod}&act=syncOneTourAPI&yield_id={$core->encryptID($item.yield_id)}&tour_id={$core->encryptID($item.tour_id)}">
																	<i class="icon-share"></i> <span>{$core->get_Lang('syncTourAPIfromTMS')}</span>
																</a>
															</li>
														{/if}
													</ul>
												</div>
											</div>
										</td>
									</tr>
								{/foreach}
							</tbody>
						{else}
							<tr><td colspan="15">{$core->get_Lang('nodata')}!</td></tr>
						{/if}
					</table>
				</div>
			</div>
			<div class="clearfix"></div>
			{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type|default:'')}
		</div>
	</div>
</div>
{if $clsConfiguration->getValue('ai_tour_enabled') eq '1'}
{$clsISO->getTemplate('aiconfig/modal_auto_ai_import.tpl')}
{/if}
<script type="text/javascript">
	var $boxID = "";
	var $tour_group_id = '{$tour_group_id|default:0}';
	var $tour_type_id = '{$tour_type_id|default:0}';
	var $cat_id = '{$cat_id|default:0}';
	var $city_id= '{$city_id|default:0}';
	var $departure_point_id= '{$departure_point_id|default:0}';
	var $is_set= '{$is_set|default:0}';
	var $recordPerPage = '{$recordPerPage|default:0}';
	var $currentPage = '{$currentPage|default:0}';
	var $listcatID  = '';
	var confirm_dup  = '{$core->get_Lang("Are you sure to duplicate this tour")}';
</script>
{literal}
<style type="text/css">
	.select2-container .select2-selection--single{
		height:50px;
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered{
		line-height:50px;
	}
	.select2-container--default .select2-selection--single .select2-selection__arrow{
		width:30px;
		height:50px;
	}
</style>
<script type="text/javascript">
	$("#SortAble").sortable({
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
			$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosSortTour", order,
			function(html){
				vietiso_loading(0);
				location.href = `${path_ajax_script}/index.php?mod=${mod}`;
			});
		}
	});
</script>
{/literal}
