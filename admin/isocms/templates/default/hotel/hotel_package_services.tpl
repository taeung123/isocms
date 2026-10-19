<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Hotel Services')}
			</h2>
			<p>{$number_all} {$core->get_Lang('hotels')}</p>
		</div>
		<div class="button_right">
			{if $clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_packages', 'customize')}
			<a href="{$PCMS_URL}/?mod=hotel&act=hotel_packages" target="_blank" class="btn btn-addnew btn-green" title="{$core->get_Lang('Hotel services')}">
				<i class="icon-list icon-white"></i> <span>{$core->get_Lang('Hotel packages')}</span> 
			</a>
			{/if}
            <a class="btn btn-main btn-addnew iso_event_hotel_services" data-key="{$clsClassTable->pkey}" data-type="F" title="{$core->get_Lang('Add service')}">
                {$core->get_Lang('Add service')}
            </a>
		</div>
    </div>
	<div class="container-fluid">
		<div class="wrap">
			<div class="statistical mb5">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button hidden">
						<button type="button" class="btn btn-export" id="btn_export">Export</button>
					</div>
					<div class="form-group form-button">
						<a class="btn btn-delete-all" id="btn_delete" clsTable="HotelService" style="display:none">
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
						<thead><tr>
							<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" class="el-checkbox" /></th>
							<th class="gridheader name_responsive" style="text-align:left;padding-left:15px!important">
								<strong>{$core->get_Lang('Title')}</strong>
							</th>
							<th class="gridheader text-right hiden_responsive" style="width: 130px"><strong>{$core->get_Lang('DateTime')}</strong></th>
							<th class="gridheader text-center hiden_responsive" style="width: 120px"><strong>{$core->get_Lang('public')}</strong></th>
							<th class="gridheader text-center hiden_responsive" width="40px"></th>
						</tr></thead>
						{if !empty($allItem)}
						<tbody id="SortAble" class="sortByTd">
                            {foreach from=$allItem key=key item=item} 
                            {assign var=hotel_service_id value=$item.hotel_service_id}
                            {assign var="oneUserCreator" value=$clsUser->getOne($item.user_id,'first_name,last_name')}
                            <tr id="order_{$hotel_service_id}" class="{cycle values="row1,row2"}">
								<td class="check_40 has-checkbox text-center"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$hotel_service_id}" /></td>
								<td class="text-left name_service" style="cursor: move">
									<div class="box_name_services">
										<p class="txt_name_services">
											<b><span class="title" title="{if $clsClassTable->getOneField('is_online',$hotel_service_id) eq 0}{$core->get_Lang('Hotel PRIVATE')}{/if}">
												#{$hotel_service_id}</span>
												- {$item.title}</b>
											{if $item.is_online eq 0}
											<span class="color_r" title="{$core->get_Lang('Hotel PRIVATE')}">[P]</span>{/if}
											{if $item.is_trash eq '1'}
												<span class="pull-right text-muted">{$core->get_Lang('intrash')}</span>
											{/if}
										</p>
										<p class="txt_info"><span>{$core->get_Lang("User")}: {$oneUserCreator.first_name} {$oneUserCreator.last_name} </span></p>
									</div>
									<button type="button" class="toggle-row inline_block767" style="display:none">
										<i class="fa fa-caret fa-caret-down"></i>
									</button>
								</td>
								<td class="block_responsive" style="text-align:right; white-space:nowrap" data-title="{$core->get_Lang('pricefrom')}">
									{$clsISO->formatDateTime($item.reg_date,"d/m/Y H:i",0)}
								</td>
								<td class="block_responsive" style="text-align:center" data-title="{$core->get_Lang('public')}">
									<a href="javascript:void(0);" class="SiteClickPublic" clsTable="HotelService" pkey="hotel_service_id" sourse_id="{$hotel_service_id}" rel="{$item.is_online}" title="{$core->get_Lang('Click to change status')}">
										{if $item.is_online eq '1'}
										<i class="fa-solid fa-circle-check green"></i>
										{else}
										<i class="fa-solid fa-circle-minus red"></i>
										{/if}
									</a>
								</td>
								<td class="block_responsive text-center" style="white-space:nowrap;" data-title="{$core->get_Lang('func')}">
									<div class="btn-group">
										<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
										</button>

										<ul class="dropdown-menu dropdown-menu-end">
											{if $item.is_trash eq '0'}
												<li>
													<a class="dropdown-item iso_event_hotel_services"
													title="{$core->get_Lang('edit')}"
													data-key="{$clsClassTable->pkey}"
													data-type="F"
													data-id="{$hotel_service_id}"
													href="javascript:void(0);">
														<i class="icon-edit"></i>
														<span>{$core->get_Lang('edit')}</span>
													</a>
												</li>

												<li>
													<a class="dropdown-item iso_event_hotel_services"
													title="{$core->get_Lang('trash')}"
													data-key="{$clsClassTable->pkey}"
													data-type="T"
													data-id="{$hotel_service_id}"
													href="javascript:void(0);">
														<i class="icon-trash"></i>
														<span>{$core->get_Lang('trash')}</span>
													</a>
												</li>

											{else}

												<li>
													<a class="dropdown-item iso_event_hotel_services"
													title="{$core->get_Lang('edit')}"
													data-key="{$clsClassTable->pkey}"
													data-type="S"
													data-id="{$hotel_service_id}"
													href="javascript:void(0);">
														<i class="icon-edit"></i>
														<span>{$core->get_Lang('edit')}</span>
													</a>
												</li>

												<li>
													<a class="dropdown-item iso_event_hotel_services"
													title="{$core->get_Lang('restore')}"
													data-key="{$clsClassTable->pkey}"
													data-type="R"
													data-id="{$hotel_service_id}"
													href="javascript:void(0);">
														<i class="icon-refresh"></i>
														<span>{$core->get_Lang('restore')}</span>
													</a>
												</li>

												<li>
													<a class="dropdown-item iso_event_hotel_services"
													title="{$core->get_Lang('delete')}"
													data-key="{$clsClassTable->pkey}"
													data-type="D"
													data-id="{$hotel_service_id}"
													href="javascript:void(0);">
														<i class="icon-remove"></i>
														<span>{$core->get_Lang('delete')}</span>
													</a>
												</li>
											{/if}
										</ul>
									</div>
								</td>
							</tr>
                            {/foreach}
						</tbody>
						{else}<tr><td colspan="15">{$core->get_Lang('nodata')}!</td></tr>{/if}
					</table>
				</div>
			</div>
			<div class="clearfix"></div>
			{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
		</div>
	</div>
</div>
<script type="text/javascript" src="{$URL_THEMES}/hotel/jquery.hotel_packages.js?v={$upd_version}"></script>