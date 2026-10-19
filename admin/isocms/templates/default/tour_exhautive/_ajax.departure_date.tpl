<div class="modal-dialog modal-lg">
	<div class="modal-content version-xs">
		<div class="modal-header px-30 version-xs">
			<h4 class="modal-title">{$titlePage}</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<form method="post" id="frmIssue" class="frmform" enctype="multipart/form-data">
			<div class="modal-body px-30 version-xs">
				<div class="form-group">
					<label class="col-form-label text-bold">{$core->get_Lang('Types of Ruler')}<span class="text-red">*</span></label>
					<div class="clearfix"></div>
					<select class="form-control iso-selectbox" onChange="handler_ruler_type(this, event)" name="ruler_type" data-width="80%">
						<!--<option value="3">Lặp lại hàng tuần vào những ngày đã chọn</option> -->
						<option value="1" {if $oneItem.ruler_type eq '1'} selected{/if}>Khởi hành vào khoảng ngày đã chọn</option>
						<option value="2" {if $openFrom eq 'calendar' || $oneItem.ruler_type eq '2'} selected{/if}>Khởi hành vào ngày nhất định</option>  
					</select>
				</div>
				{if $tour_start_date_id eq 0}
				<div class="ruler-controls hcDateRange form-group{if $openFrom eq 'calendar'} hidden{/if}">
					<label class="col-form-label text-bold">{$core->get_Lang('Date Range')}</label>
					<div class="form-row">
						<div class="col-xs-12 col-md-3">
							<input type="text" class="form-control datepicker1{if $openFrom ne 'calendar'} required{/if} w-100" name="start_date" placeholder="{$core->get_Lang('Start Date')}" value="{$clsISO->convertTimeToText($oneItem.start_date)}" autocomplete="off" readonly />
						</div>
						<div class="col-xs-12 col-md-3">
							<input type="text" class="form-control datepicker1{if $openFrom ne 'calendar'} required{/if}  w-100" name="due_date" placeholder="{$core->get_Lang('End Date')}" value="{$clsISO->convertTimeToText($oneItem.end_date)}" autocomplete="off" readonly />
						</div>
					</div>
				</div>
				<div class="ruler-controls hcOneDay form-group{if $openFrom ne 'calendar'} hidden{/if} w-80">
					<label class="col-form-label text-bold">{$core->get_Lang('Day')}</label>
					<div class="form-row">
						<div class="col-xs-12 col-md-12">
							<input type="text" class="form-control multi_datepicker1{if $openFrom eq 'calendar'} required{/if} w-100" name="date_id" value="{$clsISO->convertTimeToText($oneItem.date_id)}" placeholder="dd/mm/yy" autocomplete="off" readonly />
						</div>
					</div>
				</div>
				{else} 
				<div class="form-group w-80">
					<label class="col-form-label text-bold">{$core->get_Lang('Day')}</label>
					<div class="form-row">
						<div class="col-xs-12 col-md-5">
							<input type="text" class="form-control w-100" name="date_id" value="{$clsISO->convertTimeToText($oneItem.date_id)}" placeholder="dd/mm/yy" autocomplete="off" readonly disabled />
						</div>
					</div>
				</div>
				{/if}
				<div class="ruler-controls hcOneDay form-group">
					<label class="col-form-label text-bold">{$core->get_Lang('Active')}</label>
					<input type="hidden" value="0" name="is_active">
					<input {if $oneItem.is_active==1} checked{/if} type="checkbox" class="cm-toggle" value="1" name="is_active">
				</div>
				<div class="ruler-controls hcOneDay form-group">
					<label class="col-form-label text-bold">Là tour giờ chót</label> <input type="hidden" value="0" name="is_last_hour"><input {if $oneItem.is_last_hour==1} checked{/if} type="checkbox" class="cm-toggle is_last_hour" value="1" name="is_last_hour">
				</div>
				<div id="is_last_hour_html" class="ruler-controls hcOneDay form-group">
					<div class="row">
						<div class="col-sm-6">
							<label class="col-form-label text-bold">{$core->get_Lang('Open sale date')}</label>
							<div class="form-row">
								<div class="col-xs-12 col-md-8">
									<input type="text" class="form-control w-100" name="open_sale_date" value="{$clsISO->convertTimeToText($oneItem.open_sale_date)}" placeholder="dd/mm/yy" />
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<label class="col-form-label text-bold">{$core->get_Lang('Close sale date')}</label>
							<div class="form-row">
								<div class="col-xs-12 col-md-8">
									<input type="text" class="form-control w-100" name="close_sale_date" value="{$clsISO->convertTimeToText($oneItem.close_sale_date)}" placeholder="dd/mm/yy" />
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="ruler-controls hcDateRange form-group{if $openFrom eq 'calendar'} hidden{/if} day_range">
					<label class="col-form-label text-bold">{$core->get_Lang('Day Influencing')}</label>
					<span class="help-block text-muted">Chọn (những) ngày áp dụng quy tắc sẵn có này.</span>
					<div class="vs-checkbox">
						{foreach from = $lstDay key = _Key item = _Item}
						<input type="checkbox" id="weekday-{$_Key}" name="weekdays[]"{if $clsISO->checkItemInArray($_Key, $weekdays_arr)}checked {/if} value="{$_Key}" class="weekday">
						<label for="weekday-{$_Key}">{$core->get_Lang($_Item)}</label>
						{/foreach}
					</div>
				</div>
				<div class="form-group iso_btn_departure">
					<label class="col-form-label text-bold">{$core->get_Lang('Type Of Departures')}</label>
					<div class="clearfix"></div>
					<select class="form-control selectpicker" name="departure_type" data-width="80%">
						{foreach from = $listType key=_Key item = _Item}
						<option{if $oneItem.departure_type eq $_Key} selected{/if} value="{$_Key}" data-content="<div class='option'><div class='text'><b>{$_Item.title}</b> 
						- {$_Item.subtitle}</div></div>">{$_Item.title}</option>
						{/foreach}
					</select>
				</div>
				<div class="form-group">
					<label class="col-form-label text-bold">{$core->get_Lang('Price')}<span class="text-red">*</span></label>
					<div class="clearfix"></div>
					<div class="d-flex">
						<label class="radio-inline version-xs mr-4">
							<input type="radio" value="0" name="price_type" onChange="handler_price_type(this,event)"{if $oneItem.price_type eq '0'} checked="checked"{/if} value="0" /> {$core->get_Lang('Default')}
						</label>
						<label class="radio-inline version-xs">
							<input type="radio" value="1" name="price_type" onChange="handler_price_type(this,event)"{if $oneItem.price_type eq '1'} checked="checked"{/if} value="1" /> {$core->get_Lang('Change')}
						</label>
					</div>
					<div class="hc-PriceTable{if $oneItem.price_type eq '0'} hidden{/if} mt-3">
						{$htmlPriceTable}
					</div>
				</div>
				<div class="form-group row">
					<div class="col-xs-12 col-md-4">
						<label class="col-form-label text-bold">{$core->get_Lang('Numberofseats')}</label>
						<span class="help-block mt-0 text-muted">{$core->get_Lang('Để trống nếu không giới hạn chỗ')}</span>
						<input type="text" class="form-control numberonly allotment w-150px" autocomplete="off" value="{$oneItem.allotment}" name="allotment" maxlength="255" />
					</div>
					<div class="col-xs-12 col-md-4">
						<label class="col-form-label text-bold">{$core->get_Lang('Deposit')}(%)</label>
						<span class="help-block mt-0 text-muted">{$core->get_Lang('Số tiền phải thanh toán khi đặt')}</span> 
						<input type="number" class="form-control price-In numberonly w-150px" min="0" max="100" value="{if $oneItem.deposit}{$oneItem.deposit}{else}0{/if}" autocomplete="off" name="deposit" />
					</div>
				</div>
				<div class="form-group iso_btn_departure">
					<label class="col-form-label text-bold">{$core->get_Lang('Payment Due Date')}</label>
					<div class="clearfix"></div>
					<select class="form-control selectpicker" name="time_for_payment" data-width="80%">
						{foreach from = $listPaymentDue key=_Key item = _Item}
						<option{if $oneItem.time_for_payment eq $_Key} selected{/if} value="{$_Key}" data-content="<div class='option'><div class='text'><b>{$_Item.title}</b> - {$_Item.subtitle}</div></div>">{$_Item.title}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="modal-footer px-30 version-xs">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<span>{$core->get_Lang('Cancel')}</span>
				</button>
				<button type="button" class="btn btn-primary" onClick="pop_save_departure_date(this,event)" tour_id="{$tour_id}" openFrom="{$openFrom}" tour_start_date_id="{$tour_start_date_id}">
					<i class="icon-ok icon-white"></i> <span>{$core->get_Lang('Save')}</span>
				</button>
			</div>
		</form>
	</div>
</div>

<script>
var is_last_hour='{$oneItem.is_last_hour}';
var date_id='{$oneItem.date_id|date_format:"%d/%m/%Y"}';
</script>
{literal}
<style>
	.iso_btn_departure button {
		border: unset;
		padding: 0;
		margin-right: 10px;
		position: relative;
	}
	
	.iso_btn_departure .bs-caret{
		margin: 0;
		display: none;
	}
</style>
<script>
loadIsLastHourHtml(is_last_hour);
$_document.on('click','.cm-toggle.is_last_hour',function(){
	loadIsLastHourHtml($(this).is(':checked'));
});
function loadIsLastHourHtml(is_last_hour){
	if(is_last_hour==1){
	   $('#is_last_hour_html').show();
	}else{
		$('#is_last_hour_html').hide();
	}
}

datePickerOpenSale(date_id);
datePickerCloseSale(new Date(),date_id);
	
$('input[name="date_id"]').change(function(){
	var value = $(this).val();
	$('input[name="open_sale_date"]').datepicker('destroy');
	$('input[name="close_sale_date"]').datepicker('destroy');
	datePickerOpenSale(value);
	datePickerCloseSale(new Date(),value);
});
$('input[name="open_sale_date"]').change(function(){
	var max_date = $('input[name="date_id"]').val();
	datePickerOpenSale($(this).val());
	$('input[name="close_sale_date"]').datepicker('destroy');
	datePickerCloseSale($(this).val(),max_date);
});
$('.datepicker1').datepicker({
	dateFormat: "dd/mm/yy",
	minDate: new Date()
});
$('.multi_datepicker1').multiDatesPicker({
	dateFormat: "dd/mm/yy",
	minDate: new Date()
});
function datePickerOpenSale(maxDate=0) {
    $('input[name="open_sale_date"]').datepicker({
        dateFormat: "dd/mm/yy",
		minDate: new Date(),
		maxDate: maxDate
    });
}
function datePickerCloseSale(minDate=0,maxDate=0) {
    $('input[name="close_sale_date"]').datepicker({
        dateFormat: "dd/mm/yy",
        minDate: minDate,
		maxDate: maxDate
    });
}
</script>
{/literal}