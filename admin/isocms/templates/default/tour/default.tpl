<div class="page_container">
	<div class="page-title  d-flex">
        <div class="title">
			<h2>
				{$core->get_Lang('Tours')}
				<div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các tours trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$number_all} {$core->get_Lang('tours')}</p>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew createNewTour" title="{$core->get_Lang('addtours')}">{$core->get_Lang('addtours')}</a>
			<div class="btn btn-setting"><a href="{$PCMS_URL}/?mod={$mod}&act=setting" title="{$core->get_Lang('Setting')}"><i class="fa fa-cog" aria-hidden="true"></i></a></div>
		</div>
		{if 1 eq 2}
        <p>Chức năng quản lý danh sách các tours trong hệ thống isoCMS</p>
		<p>{$core->get_Lang('This function is intended to manage tours in isoCMS system')}</p>
		{/if}
    </div>
	<div class="container-fluid">
		<div class="wrap">
			<div class="statistical mb5">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
					</div>
					<div class="form-group form-category">
						<select onchange="_reload()" name="cat_id" class="form-control" id="slb_Category">
							{$clsTourCat->makeSelectboxOption($tour_group_id, $cat_id, $is_set)}
						</select>
					</div>
					<div class="form-group">
						<select onchange="_reload()" name="number_day" class="form-control">
							 <option value="0">{$core->get_Lang('Itinerary')}</option>
							 {$clsISO->makeSelectNumber2(30,$number_day)}
						</select>
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button">
						<button type="button" class="btn btn-export" id="btn_export">Export</button>
					</div>
					<div class="form-group form-button">
						<a class="btn btn-delete-all" id="btn_delete" clsTable="Tour" style="display:none">
							{$core->get_Lang('Delete')}
						</a>
					</div>
				</form>	
				<div class="record_per_page">
					<label>{$core->get_Lang('Record/page')}</label>
					{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl)}
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="tabbox">
				<div class="hastable">
					<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
						<thead>
							<tr>
								<th class="gridheader"  style="width:40px"><input id="check_all" type="checkbox" style="margin-top:5px;" /></th>
								<th class="gridheader hiden767" style="width:70px"><strong>ID</strong></th>
								<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('nameoftrips')}</strong></th>
								{if $clsConfiguration->getValue('SiteHasCat_Tours')}
								<th class="gridheader hiden_responsive" style="text-align:left; width:16%"><strong>{$core->get_Lang('travelstyles')}</strong></th>
								{/if}
								<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('duration')}</strong></th>
								
								<th class="gridheader hiden_responsive" style="text-align:right; width:6%"><strong>{$core->get_Lang('pricefrom')}</strong></th>
								<th class="gridheader hiden_responsive" style="text-align:center"><strong>{$core->get_Lang('public')}</strong></th>
								
								<th class="gridheader hiden_responsive" style="text-align:center; width:40px"></th>
							</tr>
						</thead>
						{if $allItem[0].tour_id ne ''}
						<tbody id="SortAble">
							{section name=i loop=$allItem}
							<tr style="cursor:move" id="order_{$allItem[i].tour_id}" class="{cycle values="row1,row2"}">
								<td class="check_40 text-center"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].tour_id}" /></td>
								<td class="index hiden767" data-title="ID"><span>{$allItem[i].tour_id}</span></td>
								<td class="text-left name_service">
									<span class="title" title="{if $clsClassTable->getOneField('is_online',$allItem[i].tour_id) eq 0}{$core->get_Lang('Tour PRIVATE')}{/if}">{$clsClassTable->getTitle($allItem[i].tour_id)}</span>
						{if $clsClassTable->getOneField('is_online',$allItem[i].tour_id) eq 0}<span style="color:red;" title="{$core->get_Lang('Tour PRIVATE')}">[P]</span>{/if}

									{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}

									<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
								</td>
								{if $clsConfiguration->getValue('SiteHasCat_Tours')}
								<td class="block_responsive" data-title="{$core->get_Lang('travelstyles')}">
									<span>{$clsClassTable->getCatName($allItem[i].tour_id)}</span>
								</td>
								{/if}
								<td class="text-left block_responsive border_top_responsive" style="white-space:nowrap" data-title="{$core->get_Lang('duration')}">
									{$clsClassTable->getTripDuration2020($allItem[i].tour_id,'/ ')}
								</td>
								<td class="block_responsive" style="text-align:right; white-space:nowrap" data-title="{$core->get_Lang('pricefrom')}">
									{if $clsClassTable->getTripPriceNewPro($allItem[i].tour_id,$now_day,0,'value') gt '0'}
										<span class="format_price">
										{$clsClassTable->getTripPriceNewPro($allItem[i].tour_id,$now_day,0,'value')} <u>{$clsISO->getShortRate()}</u>
										</span>
									{else}
										<span class="format_price">
										0 <u>{$clsISO->getShortRate()}<u>
										</span>
									{/if}
								</td>
								<td class="block_responsive" style="text-align:center" data-title="{$core->get_Lang('public')}">
									<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Tour" pkey="tour_id" sourse_id="{$allItem[i].tour_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].tour_id)}" title="{$core->get_Lang('Click to change status')}">
										{if $clsClassTable->getOneField('is_online',$allItem[i].tour_id) eq '1'}
										<i class="fa-solid fa-circle-check green"></i>
										{else}
										<i class="fa-solid fa-circle-minus red"></i>
										{/if}
									</a>
								</td>
								
								<td class="block_responsive" align="center" style="vertical-align: middle; text-align:center;white-space: nowrap;" data-title="{$core->get_Lang('func')}">
									<div class="btn-group">
										<button class="btn btn_dropdown dropdown-toggle"
												type="button"
												data-bs-toggle="dropdown"
												aria-expanded="false">
											<i class="fa fa-ellipsis-v"></i>
										</button>

										<ul class="dropdown-menu dropdown-menu-end">
											{if $allItem[i].is_trash eq '0'}
											<li>
												<a class="dropdown-item"
												href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].tour_id)}"
												target="_blank"
												title="{$core->get_Lang('view')}">
													<i class="icon-eye-open"></i> {$core->get_Lang('view')}
												</a>
											</li>

											<li>
												<a class="dropdown-item"
												title="{$core->get_Lang('edit')}"
												href="{$PCMS_URL}/?mod={$mod}&act=edit{if $is_set=='free'}&is_set=free{/if}&tour_id={$core->encryptID($allItem[i].tour_id)}">
													<i class="icon-edit"></i> {$core->get_Lang('edit')}
												</a>
											</li>

											<li>
												<a class="dropdown-item"
												title="{$core->get_Lang('trash')}"
												href="{$PCMS_URL}/?mod={$mod}&act=trash&tour_id={$core->encryptID($allItem[i].tour_id)}{$pUrl}&page={$currentPage}">
													<i class="icon-trash"></i> {$core->get_Lang('trash')}
												</a>
											</li>
											{else}
											<li>
												<a class="dropdown-item"
												title="{$core->get_Lang('restore')}"
												href="{$PCMS_URL}/?mod={$mod}&act=restore&tour_id={$core->encryptID($allItem[i].tour_id)}{$pUrl}&page={$currentPage}">
													<i class="icon-refresh"></i> {$core->get_Lang('restore')}
												</a>
											</li>

											<li>
												<a class="dropdown-item confirm_delete"
												title="{$core->get_Lang('delete')}"
												href="{$PCMS_URL}/?mod={$mod}&act=delete&tour_id={$core->encryptID($allItem[i].tour_id)}{$pUrl}&page={$currentPage}">
													<i class="icon-remove"></i> {$core->get_Lang('delete')}
												</a>
											</li>
											{/if}

											{if $clsConfiguration->getValue('SiteHasDuplicate_Tours')}
											<li>
												<a class="dropdown-item ajDuplicateTour"
												title="{$core->get_Lang('duplicate')}"
												tour_id="{$allItem[i].tour_id}"
												href="#">
													<i class="icon-share"></i> {$core->get_Lang('Duplicate')}
												</a>
											</li>
											{/if}
										</ul>
									</div>
								</td>
							</tr>
							{/section}
						</tbody>
						{else}<tr><td colspan="15">{$core->get_Lang('nodata')}!</td></tr>{/if}
					</table>
				</div>
			</div>
			<div class="clearfix"></div>
			{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
		</div>
	</div>
	<script type="text/javascript">
		var $boxID = "";
		var $tour_group_id = '{$tour_group_id}';
		var $tour_type_id = '{$tour_type_id}';
		var $cat_id = '{$cat_id}';
		var $city_id= '{$city_id}';
		var $departure_point_id= '{$departure_point_id}';
		var $is_set= '{$is_set}';
		var $recordPerPage = '{$recordPerPage}';
		var $currentPage = '{$currentPage}';
	</script>
	<script type="text/javascript" src="{$URL_THEMES}/tour/jquery.tour.js"></script>
	{literal}
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
					location.href = REQUEST_URI;
				});
			}
		});
	</script>
	{/literal}
</div>