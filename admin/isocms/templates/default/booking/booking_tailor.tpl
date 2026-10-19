{literal}
    <style>
        .tbl-grid tr td{
            padding: 2px 2px;
        }
    </style>
{/literal}
<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>
				{if $status ne ''}
					{if $status eq 0}{$core->get_Lang('Tour Request Reminding List')}{/if}
					{if $status eq 1}{$core->get_Lang('Tour Request Offered List')}{/if}
					{if $status eq 2}{$core->get_Lang('Tour Request Reviewed List')}{/if}
				{else}
					{$core->get_Lang('Tour Request List')}
				{/if}
			</h2>
			{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
			{if $clsConfiguration->getValue($setting) ne ''}
			<div>{$clsConfiguration->getValue($setting)|html_entity_decode}</div>
			{/if}
		</div>
    </div>
	<div class="container-fluid">
		<div class="filter_box">
			<form id="forums" method="post" class="filterForm" action="">
				{assign var=blog_category_check value=$clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
				<div class="form-group form-keyword">
					<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
				</div>
				<div class="form-group form-button">
					<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang('Search')}</button>
					<input type="hidden" name="filter" value="filter" />
				</div>
				<div class="form-group form-button">
					<a class="btn btn-delete-all" id="btn_delete" clsTable="Booking" type="Tailor" style="display:none">
						{$core->get_Lang('Delete')}
					</a>
				</div>
				<div class="fr group_buttons">
					<a href="{$PCMS_URL}/?mod={$mod}&act=booking_tailor" class="btn btn-warning btnNew">
						<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$totalItem})</span>
					</a>
					<a href="{$PCMS_URL}/?mod={$mod}&act=booking_tailor&status=1" class="btn btn-success btnNew" style="background:#06C;border-color:#06C">
						<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('Offered')} ({$number_process})</span>
					</a>
					<a href="{$PCMS_URL}/?mod={$mod}&act=booking_tailor&status=2" class="btn btn-success btnNew" style="background:#c00000;border-color:#c00000">
						<i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Reviewed')} ({$number_reviewed})</span>
					</a>
					<a href="{$PCMS_URL}/?mod={$mod}&act=booking_tailor&status=0" class="btn btn-success btnNew" style="background:#FC0;border-color:#FC0">
						<i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Reminding')} ({$number_unprocess})</span>
					</a>
				</div>
			</form>	
		</div>
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
			<div class="table_list_booking">
				<table cellspacing="0" class="tbl-grid table-striped table-layout-fixed" width="100%">
					<thead>
						<tr>
							<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
							<th class="gridheader" style="width:60px"><strong>{$core->get_Lang('id')}</strong></th>
							<th class="gridheader" style="text-align:left;width:8%"><strong>{$core->get_Lang('Service Code')}</strong></th>
							<th class="gridheader text-left" style="width:14%"><strong>{$core->get_Lang("Customer's Contact")}</strong></th>
							<th class="gridheader text-left" style="width:10%;"><strong>{$core->get_Lang('orderdate')}</strong></th>
							<th class="gridheader text-left" style="width:10%;"><strong>{$core->get_Lang('Departure Date')}</strong></th>
							<th class="gridheader text-left" style="white-space:nowrap;min-width: 150px"><strong>{$core->get_Lang('Special Requests')}</strong></th>
							<th class="gridheader text-left" style="width:100px"><strong>{$core->get_Lang('Contact By')}</strong></th>
							<th class="gridheader text-left" style="width:100px"><strong>{$core->get_Lang('status')}</strong></th>
							<th class="gridheader text-left" style="width:65px"><strong>{$core->get_Lang('action')}</strong></th>
						</tr>
					</thead>
					<tbody>
						{section name=i loop=$listItem}
						{assign var=BOOKINGVALUE value = $clsClassTable->getBookingValue($listItem[i].booking_id)}
						<tr {if $smarty.section.i.index%2 eq '0'}class="row1"{else}class="row2"{/if}>
							<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$listItem[i].booking_id}" /></td>
							<td class="index td_overflow" style="white-space:nowrap">{$listItem[i].booking_id}</td>
							<td class="td_overflow" style="white-space:nowrap">{$listItem[i].booking_code}</td>
							<td class="td_overflow" style="white-space:nowrap">
								<strong>{$BOOKINGVALUE.name} </strong>
								<br />
								<i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:{$listItem[i].email}" title="{$listItem[i].email}">{$BOOKINGVALUE.email}</a>
								<br/>
								<i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:+{$listItem[i].phone}" title="{$listItem[i].phone}">{$BOOKINGVALUE.phone}</a>
								<br />
								<i class="fa fa-globe" aria-hidden="true"></i> <span>{$clsClassTable->getCountryBookingStore($BOOKINGVALUE.country__id)}</span>
							</td>
							<td class="td_overflow" style="white-space:nowrap">{$clsISO->formatDate($listItem[i].reg_date)}</td>
{*							<td style="white-space:nowrap" class="td_overflow">{$clsClassTable->getDepartureDate($listItem[i].booking_id)}</td>*}
							<td style="white-space:nowrap" class="td_overflow">{$clsClassTable->formatDate($BOOKINGVALUE.date_begin_simple)}</td>
							<td class="td_message" style="width:300px">{$clsClassTable->getRequest($listItem[i].booking_id)}</td>
							<td class="td_overflow" style="white-space:nowrap">{if $BOOKINGVALUE.please eq 1}{$core->get_Lang('Email')}{else}{$core->get_Lang('Phone')}{/if}</td>
							<td>
								{if $listItem[i].status eq '0'}
								<span class="status_pending">{$core->get_Lang('Reminding')}</span>
								{elseif $listItem[i].status eq '2'}
								<span class="status_lock">{$core->get_Lang('Reviewed')}</span>
								{else}
								<span class="status_approved">{$core->get_Lang('Offered')}</span>
								{/if}
							</td>
							<td style="vertical-align: top; text-align: right; white-space: nowrap; width:5%;text-align: center"> 
								<div class="btn-group">
									<button class="btn iso-button-standard dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="icon-cog"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-end">
										<li>
											<a href="{$PCMS_URL}/?mod={$mod}&act=edit&action=booking_tailor&booking_id={$core->encryptID($listItem[i].booking_id)}" title="{$core->get_Lang('viewbooking')}" class="dropdown-item">
												<i class="icon-edit"></i> {$core->get_Lang('viewbooking')}
											</a>
										</li>
										<li>
											<a href="{$PCMS_URL}/?mod={$mod}&act=print&booking_id={$core->encryptID($listItem[i].booking_id)}" title="{$core->get_Lang('print')}" class="dropdown-item">
												<i class="icon-print"></i> {$core->get_Lang('print')}
											</a>
										</li>
										<li>
											<a class="confirm_delete dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=delete&booking_id={$core->encryptID($listItem[i].booking_id)}" title="{$core->get_Lang('delete')}">
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