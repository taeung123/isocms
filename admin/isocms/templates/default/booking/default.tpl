<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Overview')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('Overview')} trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$core->get_Lang('Here you can find all the important figures regarding your revenue and fees')}</p>
		</div>
    </div>
	<div class="container-fluid">
		<div class="hastable">
			<div class="wrap">
				<div class="fl" style="width:32%">
					<table cellspacing="0" class="tbl-grid" width="100%">
						<thead>
							<tr>
								<td class="gridheader" colspan="3" style="text-align:left">
									<strong>{$core->get_Lang('Tour booking')} ({$clsClassTable->countTotalAllBooking('Tour')})</strong>
									<a href="{$PCMS_URL}/index.php?mod=booking&act=booking_tour" class="fr">{$core->get_Lang('Show all')} &raquo;</a>
								</td>
							</tr>
						</thead>
						<tbody>
							<tr class="row1">
								<td>{$core->get_Lang('New booking')}</td>
								<td>{$clsClassTable->countTotalBooking('Tour',0)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod={$mod}&act=booking_tour&status=0" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
							<tr class="row1">
								<td>{$core->get_Lang('Request Offered')}</td>
								<td>{$clsClassTable->countTotalBooking('Tour',1)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod={$mod}&act=booking_tour&status=1" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
							<tr class="row2">
								<td>{$core->get_Lang('Reviewed')}</td>
								<td>{$clsClassTable->countTotalBooking('Tour',2)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod={$mod}&act=booking_tour&status=2" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="fl" style="width:32%; margin-left:2%">
					<table cellspacing="0" class="tbl-grid" width="100%">
						<thead>
							<tr>
								<td class="gridheader" colspan="3" style="text-align:left">
									<strong>{$core->get_Lang('Booking Hotel')} ({$clsClassTable->countTotalAllBooking('Hotel')})</strong>
									<a href="{$PCMS_URL}/index.php?mod=booking&act=booking_hotel" class="fr">{$core->get_Lang('Show all')} &raquo;</a>
								</td>
							</tr>
						</thead>
						<tbody>
							<tr class="row1">
								<td>{$core->get_Lang('New booking')}</td>
								<td>{$clsClassTable->countTotalBooking('Hotel',0)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod={$mod}&act=booking_hotel&status=0" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
							<tr class="row1">
								<td>{$core->get_Lang('Request Offered')}</td>
								<td>{$clsClassTable->countTotalBooking('Hotel',1)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod={$mod}&act=booking_hotel&status=1" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
							<tr class="row2">
								<td>{$core->get_Lang('Reviewed')}</td>
								<td>{$clsClassTable->countTotalBooking('Hotel',2)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod={$mod}&act=booking_hotel&status=2" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="fr" style="width:32%">
					<table cellspacing="0" class="tbl-grid" width="100%">
						<thead>
							<tr>
								<td class="gridheader" colspan="3" style="text-align:left">
									<strong>{$core->get_Lang('Tour request')} ({$clsClassTable->countTotalAllBooking('Tailor')})</strong>
									<a href="{$PCMS_URL}/index.php?mod=booking&act=booking_tailor" class="fr">{$core->get_Lang('Show all')} &raquo;</a>
								</td>
							</tr>
						</thead>
						<tbody>
							<tr class="row1">
								<td>{$core->get_Lang('New booking')}</td>
								<td>{$clsClassTable->countTotalBooking('Tailor',0)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod={$mod}&act=booking_tailor&status=0" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
							<tr class="row1">
								<td>{$core->get_Lang('Request Offered')}</td>
								<td>{$clsClassTable->countTotalBooking('Tailor',1)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod={$mod}&act=booking_tailor&status=1" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
							<tr class="row2">
								<td>{$core->get_Lang('Reviewed')}</td>
								<td>{$clsClassTable->countTotalBooking('Tailor',2)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod={$mod}&act=booking_tailor&status=2" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="wrap mt20">
				<div class="fl" style="width:32%">
					<table cellspacing="0" class="tbl-grid" width="100%">
						<thead>
							<tr>
								<td class="gridheader" colspan="3" style="text-align:left">
									<strong>{$core->get_Lang('Contact')} ({$clsFeedback->countTotalAllFeedback($feedback_id)})</strong>
									<a href="{$PCMS_URL}/index.php?mod=feedback" class="fr">{$core->get_Lang('Show all')} &raquo;</a>
								</td>
							</tr>
						</thead>
						<tbody>
							<tr class="row1">
								<td>{$core->get_Lang('New booking')}</td>
								<td>{$clsFeedback->countTotalFeedback(0)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod=feedback&is_process=0" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
							<tr class="row1">
								<td>{$core->get_Lang('Request Offered')}</td>
								<td>{$clsFeedback->countTotalFeedback(1)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod=feedback&is_process=1" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
							<tr class="row2">
								<td>{$core->get_Lang('Reviewed')}</td>
								<td>{$clsFeedback->countTotalFeedback(2)}</td>
								<td align="center" style="text-align:center"><a class="btn btn-success fileinput-button" href="{$PCMS_URL}/index.php?mod=feedback&is_process=2" style="color:#fff" title="Xem Bài Viết này"><i class="icon-eye-open icon-white"></i></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="page-title">
			<h2>{$core->get_Lang('Recent Orders')}</h2>
			{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
			{if $clsConfiguration->getValue($setting) ne ''}
			<p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
			{/if}
		</div>
		<div class="clearfix"></div>
		<form id="forums" method="post" action="" name="filter" class="filterForm">
			<div class="filterbox">
				<div class="wrap">
					<div class="searchbox">
						<label class="fl" style="font-size:12px; margin:6px 4px 0 0">{$core->get_Lang('Select Type')}</label>
						<select name="clsTable" onchange="_reload()" class="slb mr5 fl" style="padding:5px;">
							<option value="">{$core->get_Lang('Select')}</option>
							<option value="Hotel" {if $clsTable eq 'Hotel'}selected="selected"{/if}>{$core->get_Lang('Hotel Request')}</option>
							<option value="Tour" {if $clsTable eq 'Tour'}selected="selected"{/if}>{$core->get_Lang('Tour Booking')}</option>
							<option value="Tailor" {if $clsTable eq 'Tailor'}selected="selected"{/if}>{$core->get_Lang('Tailor Booking')}</option>
						</select>
						<label class="fl" style="font-size:12px; margin:6px 4px 0 6px">{$core->get_Lang('Select Status')}</label>
						<select name="status" onchange="_reload()" class="slb mr5 fl" style="padding:5px;">
							<option value="">{$core->get_Lang('Select')}</option>
							<option value="Offered" {if $status eq 'Offered'}selected="selected"{/if}>{$core->get_Lang('Offered')}</option>
							<option value="Reviewed" {if $status eq 'Reviewed'}selected="selected"{/if}>{$core->get_Lang('Reviewed')}</option>
							<option value="Reminding" {if $status eq 'Reminding'}selected="selected"{/if}>{$core->get_Lang('Reminding')}</option>
						</select>
						<label class="fl" style="font-size:12px; margin:6px 4px 0 6px">{$core->get_Lang('Keyword')}</label>
						<input type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
						<a class="btn btn-success" href="javascript:void();" id="searchbtn" style="padding:6px">
							<i class="icon-search icon-white"></i>
						</a>
					</div>
					<div class="group_buttons fr">
						<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-success">
							<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$totalItem})</span>
						</a>
						<a href="{$PCMS_URL}/?mod={$mod}&type_list=Offered" class="btn btn-success" style="background:#06C;border-color:#06C">
							<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('Offered')} ({$number_process})</span>
						</a>
						<a href="{$PCMS_URL}/?mod={$mod}&type_list=Reviewed" class="btn btn-success" style="background:#c00000;border-color:#c00000">
							<i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Reviewed')} ({$number_reviewed})</span>
						</a>
						<a href="{$PCMS_URL}/?mod={$mod}&type_list=Reminding" class="btn btn-success" style="background:#FC0;border-color:#FC0">
							<i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Reminding')} ({$number_unprocess})</span>
						</a>
					</div>
				</div>
			</div>
			<input type="hidden" name="filter" value="filter" />
		</form>
		<div class="hastable">
			<div class="statistical mb5">
				<table width="100%" border="0" cellpadding="3" cellspacing="0">
					<tr>
						<td width="50%" align="left">{$core->get_Lang('statistical')} <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
						<td width="50%" align="right">
							{$core->get_Lang('gotopage')}:
							<select name="page" onchange="window.location = this.options[this.selectedIndex].value">
								{section name=i loop=$listPageNumber}
								<option {if $listPageNumber[i] eq $currentPage}selected="selected"{/if} value="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}">{$listPageNumber[i]}</option>
								{/section}
							</select>
						</td>
					</tr>
				</table>
			</div>
			<div style="width:100%; overflow-x:scroll;">
				<table cellspacing="0" class="tbl-grid" width="100%">
					<tr>
						<td class="gridheader" style="width:40px"><strong>{$core->get_Lang('id')}</strong></td>
							<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('Type')}</strong></td>
							<td class="gridheader" style="text-align:left;width:9%;white-space:nowrap"><strong>{$core->get_Lang('Service Code')}</strong></td>
							<td class="gridheader" style="width:8%;white-space:nowrap"><strong>{$core->get_Lang('orderdate')}</strong></td>
							<td class="gridheader" style="width:8%;white-space:nowrap"><strong>{$core->get_Lang('Dept Date')}</strong></td>
							<td class="gridheader" style="white-space:nowrap"><strong>Service/Subject name</strong></td>   
							<td class="gridheader" style="white-space:nowrap"><strong>During</strong></td>
							<td class="gridheader" style="white-space:nowrap"><strong>Quanlity</strong></td>
							<td class="gridheader" style="white-space:nowrap"><strong>No. of guest</strong></td>
							<td class="gridheader" style="white-space:nowrap"><strong>Total Booking</strong></td>
							<td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Title')}</strong></td>
							<td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('First Name')}</strong></td>
							<td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Last Name')}</strong></td>
							<td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('phone')}</strong></td>
							<td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('address')}</strong></td>
							<td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Special Requests')}</strong></td>
							<td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('email')}</strong></td>
							<td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Take Care')}</strong></td>
							<td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Nationality')}</strong></td>
							<td class="gridheader" style="width:10%"><strong>{$core->get_Lang('status')}</strong></td>
						<td class="gridheader" style="width:6%"><strong>{$core->get_Lang('Action')}</strong></td>
					</tr>
					<tbody>
						{section name=i loop=$listItem}
						{assign var=BOOKINGVALUE value = $clsClassTable->getBookingValue($listItem[i].booking_id)}
						<tr class="{cycle values="row1,row2"}">
							<td class="index">{$smarty.section.i.iteration}</td>
							<td style="white-space:nowrap">
								{if $listItem[i].clsTable eq 'Hotel'}{$core->get_Lang('Hotel request')}{/if}
								{if $listItem[i].clsTable eq 'Tour'}{$core->get_Lang('Tour booking')}{/if}
								{if $listItem[i].clsTable eq 'Tailor'}{$core->get_Lang('Tailor booking')}{/if}
							</td>
							<td style="white-space:nowrap">{$listItem[i].booking_code}</td>
							<td class="text-right">{$clsISO->formatDate($listItem[i].reg_date)}</td>
							<td style="white-space:nowrap" class="text-right">{$clsClassTable->getDepartureDate($listItem[i].booking_id)}</td>
							<td style="white-space:nowrap">
								{if $listItem[i].clsTable eq 'Hotel'}{$clsHotel->getTitle($listItem[i].target_id)}{/if}
								{if $listItem[i].clsTable eq 'Tour'}{$clsTour->getTitle($listItem[i].target_id)}{/if}
								{if $listItem[i].clsTable eq 'Tailor'}Confirmation Tailor Made Tour{/if}
							</td>
							<td style="white-space:nowrap">{$clsClassTable->getDuration($listItem[i].booking_id)} night(s)</td>
							<td style="white-space:nowrap; text-align:right">{$clsClassTable->getTotalGuest($listItem[i].booking_id)}</td>
							<td style="white-space:nowrap">{$clsClassTable->getNumberGuest($listItem[i].booking_id)}</td>
							<td style="white-space:nowrap">
								{if $listItem[i].clsTable eq 'Hotel'}
									{$clsHotel->getOneField('price',$listItem[i].target_id)} {$clsISO->getRate()}
								{/if}
								{if $listItem[i].clsTable eq 'Tour'}
									{$clsTour->getOneField('trip_price',$listItem[i].target_id)} {$clsISO->getRate()}
								{/if}
							</td>
							<td style="white-space:nowrap">{$clsClassTable->getTitle($listItem[i].booking_id)}</td>
							<td style="white-space:nowrap">{$clsClassTable->getFirstName($listItem[i].booking_id)}</td>
							<td style="white-space:nowrap">{$clsClassTable->getLastName($listItem[i].booking_id)}</td>
							<td style="white-space:nowrap">{$clsClassTable->getPhone($listItem[i].booking_id)}</td>
							<td style="white-space:nowrap">{$clsClassTable->getAddress($listItem[i].booking_id)}</td>
							<td style="width:300px">{$clsClassTable->getRequest($listItem[i].booking_id)}</td>
							<td><a href="mailto:{$clsClassTable->getEmail($listItem[i].booking_id)}" title="{$core->get_Lang('clicksendemail')}">{$clsClassTable->getEmail($listItem[i].booking_id)}</a></td>
							<td style="white-space:nowrap">{$clsClassTable->getTakeCare($listItem[i].booking_id)}</td>
							<td>{$clsClassTable->getCountry($listItem[i].booking_id)}</td>
							<td>
								{if $listItem[i].status eq '0'}
								<span class="status_pending">{$core->get_Lang('Processed')}</span>
								{elseif $listItem[i].status eq '1'}
								<span class="status_lock">{$core->get_Lang('Open')}</span>
								{elseif $listItem[i].status eq '2'}
								<span class="status_approved">{$core->get_Lang('Canceled')}</span>
								{elseif $listItem[i].status eq '3'}
								<span class="status_approved">{$core->get_Lang('Failed')}</span>
								{elseif $listItem[i].status eq '4'}
								<span class="status_approved">{$core->get_Lang('Declined')}</span>
								{elseif $listItem[i].status eq '5'}
								<span class="status_approved">{$core->get_Lang('Backordered')}</span>
								{else}
								<span class="status_approved">{$core->get_Lang('Complete')}</span>
								{/if}
							</td>
							<td style="vertical-align: top; text-align: right; white-space: nowrap; width:5%"> 
								<div class="btn-group">
									<button class="btn iso-button-standard dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="icon-cog"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-end">
										<li>
											<a href="{$PCMS_URL}/?mod={$mod}&act=edit&booking_id={$core->encryptID($listItem[i].booking_id)}" 
											title="{$core->get_Lang('viewbooking')}" class="dropdown-item">
												<i class="icon-edit"></i> {$core->get_Lang('viewbooking')}
											</a>
										</li>
										<li>
											<a href="{$PCMS_URL}/?mod={$mod}&act=print&booking_id={$core->encryptID($listItem[i].booking_id)}" 
											title="{$core->get_Lang('print')}" class="dropdown-item">
												<i class="icon-print"></i> {$core->get_Lang('print')}
											</a>
										</li>
										<li>
											<a class="confirm_delete dropdown-item" 
											href="{$PCMS_URL}/?mod={$mod}&act=delete&booking_id={$core->encryptID($listItem[i].booking_id)}" 
											title="{$core->get_Lang('delete')}">
												<i class="icon-remove"></i> {$core->get_Lang('delete')}
											</a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
						{/section}
					</tbody>
				</table>
			</div>
			<div class="clearfix"></div>
			<div class="statistical mb5">
				<table width="100%" border="0" cellpadding="3" cellspacing="0">
					<tr>
						<td width="50%" align="left">{$core->get_Lang('statistical')} <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
						<td width="50%" align="right">
							{$core->get_Lang('gotopage')}:
							<select name="page" onchange="window.location = this.options[this.selectedIndex].value">
								{section name=i loop=$listPageNumber}
								<option {if $listPageNumber[i] eq $currentPage}selected="selected"{/if} value="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}">{$listPageNumber[i]}</option>
								{/section}
							</select>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>