<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&clsTable={$core->encryptID($clsTable|default:'')}">{$core->get_Lang('Billing')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="page_container page_billing_history">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Billing Management')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('Billing Management')} trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$core->get_Lang('Here you can find all the important figures regarding your revenue and fees')}</p>
		</div>
    </div>
	<div class="container-fluid">
		<div class="filter_box">
			<form id="forums" method="post" class="filterForm" action="">
				<div class="form-group form-keyword">
					<input class="form-control" type="text" name="bill_code" value="{$bill_code|default:''}" placeholder="{$core->get_Lang('code')}..." />
				</div>
				<div class="form-group form-country">
					<select name="status" class="form-control" data-width="100%">
						<option value="">{$core->get_Lang('Status')}</option>
						<option value="0" {if $status eq '0'}selected="selected"{/if}>{$core->get_Lang('Waiting Payment')}</option>
						<option value="1" {if $status eq '1'}selected="selected"{/if}>{$core->get_Lang('Completly payment')}</option>
					</select>
				</div>
				<div class="form-group form-button">
					<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang("Search")}</button>
					<input type="hidden" name="filter" value="filter" />
				</div>
				<div class="group_buttons fr">
					<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-success btnNew">
						<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$totalItem})</span>
					</a>
					<a href="javascript:void(0)" class="btn btn-success btn-export btnNew">
						<img src="{$URL_IMAGES}/v2/excel.png" style="vertical-align:middle"> {$core->get_Lang('Export')}
					</a>
				</div>
			</form>
		</div>

		<div class="dateExport dateExport2" style="display:none">
			<form class="form-export" method="post" action="">
				<div class="form-group inline-block">
					<div class="span50 fl">
						<label class="col-md-3 col-sm-4 col-xs-4 control-label title" for="from_date">
							{$core->get_Lang('From')} <span class="color_r">*</span>
						</label>
						<div class="col-md-9 col-sm-8 col-xs-8">
							<input name="from_date" autocomplete="off" maxlength="10" id="from_date" value="{$clsISO->formatTimeDate($now_day)}" size="15" class="full-width text_32 border_aaa" placeholder="dd/mm/yyyy">
						</div>
					</div>
					<div class="span50 fr">
						<label class="col-md-3 col-sm-4 col-xs-4 control-label title" for="to_date">
							{$core->get_Lang('To')} <span class="color_r">*</span>
						</label>
						<div class="col-md-9 col-sm-8 col-xs-8">
							<input name="to_date" autocomplete="off" maxlength="10" id="to_date" value="{$clsISO->formatTimeDate($now_next)}" size="15" class="full-width text_32 border_aaa" placeholder="dd/mm/yyyy">
						</div>
					</div>
				</div>
				<button type="submit" class="buttonExport" id="button_export">{$core->get_Lang('Export')}</button>
				<input type="hidden" name="Export" value="Export" />
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
				<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
					<thead><tr>
						<th class="gridheader hiden767" style="width:40px"><strong>No.</strong></th>
						<th class="gridheader name_responsive full-w767" style="text-align:left"><strong>{$core->get_Lang('Code')}</strong></th>
						<th class="gridheader hiden767" style="text-align:left"><strong>{$core->get_Lang('Booking code')}</strong></th>
						<th class="gridheader text-left hiden767" style="min-width:150px"><strong>{$core->get_Lang("Customer's Contact")}</strong></th>
						<th class="gridheader hiden767" style="white-space:nowrap"><strong>{$core->get_Lang('Billing Method')}</strong></th>
						<th class="gridheader hiden767" style="white-space:nowrap"><strong>{$core->get_Lang('Pay Now')}</strong></th>
						<th class="gridheader hiden767" style="white-space:nowrap"><strong>{$core->get_Lang('Status')}</strong></th>
						<th class="gridheader hiden767" style="width:10%"><strong>{$core->get_Lang('Payment term')}</strong></th>
						<th class="gridheader hiden767" style="width:10%"><strong>{$core->get_Lang('Bill type')}</strong></th>
						<th class="gridheader hiden767" style="width:6%"><strong>{$core->get_Lang('Action')}</strong></th>
					</tr></thead>
					{section name=i loop=$listItem}

					<tr class="row_custom {cycle values="row1,row2"}">
						<td class="index hiden767">{$smarty.section.i.iteration}</td>
						<td class="name_service title_td1">{$listItem[i].bill_code}<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button></td>
						<td class="block_responsive td_overflow" data-title="{$core->get_Lang('Booking code')}">{$clsBooking->getOneField('booking_code',$listItem[i].booking_id)}</td>
						{assign var=txt_customer_contact value=$core->get_Lang("Customer's Contact")}
						<td class="block_responsive td_overflow" data-title="{$txt_customer_contact}" style="white-space:nowrap">
							<strong>{$listItem[i].customer_name} </strong>
							<br />
							<i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:{$listItem[i].customer_email}" title="{$listItem[i].customer_email}">{$listItem[i].customer_email}</a>
							<br/>
							<i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:+{$listItem[i].customer_phone}" title="{$listItem[i].customer_phone}">{$listItem[i].customer_phone}</a>
						</td>

						<td class="block_responsive" data-title="{$core->get_Lang('Billing Method')}">
							{if $listItem[i].payment_method eq '1'}
								{assign var = SitePay_CashName value = SitePay_CashName_|cat:$_LANG_ID}
								{$clsConfiguration->getValue($SitePay_CashName)}
							{elseif $listItem[i].payment_method eq '2'}
								{assign var = SitePay_BankName value = SitePay_BankName_|cat:$_LANG_ID}
								{$clsConfiguration->getValue($SitePay_BankName)}
							{elseif $listItem[i].payment_method eq '3'}
								{assign var = ONEPAY_Name value = ONEPAY_Name_|cat:$_LANG_ID}
								{$clsConfiguration->getValue($ONEPAY_Name)}
							{elseif $listItem[i].payment_method eq '4'}
								{assign var = ONEPAY_Visa_Name value = ONEPAY_Visa_Name_|cat:$_LANG_ID}
								{$clsConfiguration->getValue($ONEPAY_Visa_Name)}
							{elseif $listItem[i].payment_method eq '5'}
								{assign var = Paypal_Name value = Paypal_Name_|cat:$_LANG_ID}
								{$clsConfiguration->getValue($Paypal_Name)}
							{elseif $listItem[i].payment_method eq '6'}
								{assign var = ONEPAY_Visa_Name value = ONEPAY_Visa_Name_|cat:$_LANG_ID}
								{$clsConfiguration->getValue($ONEPAY_Visa_Name)}
							{elseif $listItem[i].payment_method eq '7'}
								{$core->get_Lang('QR code')}
							{/if}
						</td>
						<td class="fieldNumber block_responsive" data-title="{$core->get_Lang('Pay Now')}">{$listItem[i].bill_money|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
						<td class="fieldNumber block_responsive" data-title="{$core->get_Lang('Status')}">
						<p class="status_payment {if $listItem[i].status eq 1}complete_payment{else}waiting_payment{/if}">
							{if $listItem[i].status eq 1}
								{$core->get_Lang('Completly payment')}
							{else}
								{$core->get_Lang('Waiting Payment')}
							{/if}
							</p>
						</td>
						<td class=" block_responsive" data-title="{$core->get_Lang('Payment term')}">{if $listItem[i].payment_term gt 0}{$listItem[i].payment_term|date_format:"%d/%m/%Y"}{/if}</td>
						<td class="fieldNumber block_responsive" data-title="{$core->get_Lang('Bill type')}">
							{if $listItem[i].bill_type eq 'PAYMENT'}
								{$core->get_Lang('Payment')}
							{else}
								{$core->get_Lang('Cashback')}
							{/if}
						</td>
						<td class=" block_responsive" data-title="{$core->get_Lang('Action')}" style="vertical-align: top; text-align: right; white-space: nowrap">
							<div class="btn-group">
								<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end">
									<li>
										<a href="{$PCMS_URL}/?mod=booking&act=edit&booking_id={$core->encryptID($listItem[i].booking_id)}" target="_blank" class="dropdown-item">
											<i class="icon-edit"></i> {$core->get_Lang('View')}
										</a>
									</li>
									{if $listItem[i].bill_type eq 'PAYMENT'}
									<li>
										<a href="{$PCMS_URL}/?mod=booking&act=downloadPDF&billing_id={$listItem[i].booking_id}" target="_blank" class="dropdown-item">
											<i class="icon-print"></i> {$core->get_Lang('Print')}
										</a>
									</li>
									{/if}
								</ul>
							</div>
						</td>
					</tr>
					{/section}
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
{literal}
<script type="text/javascript">
$(document).ready(function(){
$('#from_date').datepicker({
	dateFormat: "dd/mm/yy",

	maxDate: "+1Y",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	showOtherMonths: true,
	onSelect: function(dateStr) {
		var date = $(this).datepicker('getDate');
		if(date){
			date.setDate(date.getDate() + 30);
		}
		$('#to_date').datepicker('option').datepicker('setDate', date);
	},
	onClose: function(dateText, inst) {
		$('#to_date').focus();
	}
});
$("#to_date").datepicker( {
	dateFormat: "dd/mm/yy",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	showOtherMonths: true
});
});
</script>
{/literal}
<link rel="stylesheet" type="text/css"  href="{$URL_JS}/datepicker/jquery-ui.css?ver={$upd_version}"/>
<script type="text/javascript" src="{$URL_JS}/datepicker/jquery-ui.js?v={$upd_version}"></script>