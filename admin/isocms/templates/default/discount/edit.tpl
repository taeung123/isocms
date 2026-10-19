<script type="text/javascript" src="{$URL_JS}/store.min.js?v={$upd_version}"></script>
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Discount')}</a>
	<a>&raquo;</a>
	<a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
		{if $action eq '_edit'}
        <h2>{if $oneItem.discount_rule eq 'code'}{$oneItem.code}{else}{$oneItem.title}{/if}</h2>
		{else}
		<h2>{$core->get_Lang('Add New Promotion')}</h2>
		{/if}
	</div>
	<form id="edititem" method="post" action="" enctype="multipart/form-data">
		<input type="hidden" class="gen" name="iso-discount_rule" value="{$oneItem.discount_rule}" />
		<div class="promotion-layout">
			<div class="row">
			<div class="col-md-8">
				<div class="box light">
					{if $oneItem.discount_rule eq 'code'}
					<div class="box-title no-border-bottom">
						<span class="caption bold">Mã khuyến mãi</span>
						<a href="javascript:void(0);" onClick="generateCode()" class="pull-right">Sinh mã ngẫu nhiên</a>
					</div>
					<div class="box-body">
						<input type="text" placeholder="COUPON10%" autocomplete="off" class="form-control gen uppercase ipn__discount-code" required="true" name="iso-code" value="{$oneItem.code}" />
						<small class="help-block">Khách hàng sẽ nhập mã khuyến mãi này ở màn hình thanh toán.</small>
					</div>
					{else}
					<div class="box-title no-border-bottom">
						<span class="caption bold">Tên chương trình khuyến mãi</span>
					</div>
					<div class="box-body">
						<input type="text" class="form-control gen" autocomplete="off" required="true" placeholder="Chương trình khuyến mãi tháng 4" name="iso-title" value="{$oneItem.title}" />
					</div>
					{/if}
				</div>
				<div class="box light">
					<div class="box-title no-border-bottom">
						<span class="caption bold">{$core->get_Lang('Status')}</span>
					</div>
					<div class="box-body">
						<div class="action-bar__top-links">
							{if $oneItem.status eq '1'}
							<a href="javascript:void(0);" title="{$core->get_Lang('Stop Discount')}" class="btn ui-button--transparent action-bar__link" onClick="stop_discount(this)" discount_id="{$pvalTable}">{$clsISO->makeIcon('ban', $core->get_Lang('Stop Discount'))}</a>
							{else}
							<a href="javascript:void(0);" class="btn ui-button--transparent action-bar__link" onClick="continue_discount(this)" title="{$core->get_Lang('Continue Discount')}" discount_id="{$pvalTable}">{$clsISO->makeIcon('check-circle-o', $core->get_Lang('Continue Discount'))}</a>
							{/if}
						</div>
					</div>
				</div>
				<div class="box light">
					<div class="box-title no-border-bottom">
						<span class="caption bold">Tùy chọn khuyến mại</span>
					</div>
					<div class="box-body form-horizontal">
						{assign var = discount_type value = $oneItem.discount_type}
						<div class="form-group">
							<div class="col-md-6">
								<label>Loại khuyến mãi</label>
								<select class="form-control gen ipn__discount_type" name="discount_type">
									<option {if $discount_type eq 'percentage'}selected="selected"{/if} value="percentage">Phần trăm</option>
									<option {if $discount_type eq 'amount'}selected="selected"{/if} value="amount">Số tiền</option>
									<option {if $discount_type eq 'free_shipping'}selected="selected"{/if} value="free_shipping">M.phí vận chuyển</option>
								</select>
							</div>
							<div class="col-md-6">
								<div class="discount_value__area" {if $discount_type eq 'free_shipping'}style="display:none"{/if}>
									<label>Giá trị khuyến mãi</label>
									<div class="input-group">
										<span class="input-group-addon discount__value-prefix">{if $discount_type eq 'percentage'}%{else}{$clsISO->getRate()}{/if}</span>
										<input type="{if $discount_type eq 'percentage'}number{else}text{/if}" min="0" max="100" class="form-control gen numberonly price-In ipn__discount_value"{if $discount_type ne 'free_shipping'} required="required"{/if} onClick="this.select()" name="discount_value" min="0" max="100" value="{$oneItem.discount_value}" autocomplete="off" />
									</div>
								</div>
							</div>
						</div>
					</div>
					{if $oneItem.discount_rule eq 'code'}
					<div class="box-end">
						<div class="icheck-primary">
							<input type="checkbox" name="requires_minimum_purchase" {if $oneItem.requires_minimum_purchase}checked{/if} value="1" id="checkbox_1" />
							<label for="checkbox_1">Áp dụng với đơn hàng có tổng giá trị voucher thuộc chương trình khuyến mại từ</label>
						</div>
						<div class="form-group form-group-minimum_purchase" {if !$oneItem.requires_minimum_purchase}style="display:none"{/if}>
							<div class="input-group pl30">
								<div class="input-group-addon input-discount-prefix">₫</div>
								<input type="text" class="form-control price-In" name="minimum_purchase" value="{$oneItem.minimum_purchase}" />
							</div>
						</div>
					</div>
					{/if}
				</div>
				<div class="box light">
					<div class="box-title no-border-bottom">
						<span class="caption bold">Áp dụng với</span>
					</div>
					<div class="box-body">
						{assign var = type value = $oneItem.type}
						<div class="icheck-primary">
							<input type="radio" name="type" class="rdo__discount-type gen" {if $type eq 'all'}checked{/if} value="all" id="rdo__order-all"  />
							<label for="rdo__order-all">Tất cả {if $oneItem.discount_rule eq 'code'}booking{else}voucher{/if}</label>
						</div>
						<div class="icheck-primary">
							<input type="radio" name="type" class="rdo__discount-type gen" value="category" {if $type eq 'category'}checked{/if} id="rdo__type-category" />
							<label for="rdo__type-category">Danh mục voucher</label>
						</div>
						{if $oneItem.discount_rule ne 'code'}
						<div class="icheck-primary">
							<input type="radio" name="type" class="rdo__discount-type gen" {if $type eq 'voucher'}checked{/if} value="voucher" id="radio__type-voucher" />
							<label for="radio__type-voucher">Voucher</label>
						</div>
						{/if}
						<div class="holder__object-apply{if $type eq 'all'} hidden{/if}">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-search"></i></div>
								<input type="text" class="form-control ipn__search-voucher" placeholder="Tìm kiếm voucher" />
								<div class="input-group-btn">
									<button type="button" class="btn btn-default" onClick="openModal()" style="height: 34px;">{$clsISO->makeIcon('search', 'Tìm kiếm')}</button>
								</div>
							</div>
							<div id="holder_voucher_discount" class="holder_voucher_discount">
								<div class="text-center p-md-4">Loading...</div>
							</div>
						</div>
					</div>
					{if $oneItem.discount_rule eq 'promotion'}
					<div class="box-end">
						<div class="icheck-primary">
							<input type="checkbox" class="hasPromotionVoucherCond gen" name="has_promotion_voucher_cond" {if $oneItem.has_promotion_voucher_cond eq '1'}checked{/if} value="1" id="hasPromotionVoucherCond" />
							<label for="hasPromotionVoucherCond">{$core->get_Lang('Conditions_Apply')}</label>
						</div>
						<div class="form-group holder_hasPromotionVoucherCond {if $oneItem.has_promotion_voucher_cond ne '1'} hidden{/if}">
							<div class="row">
								<div class="col-md-6">
									<select name="promotion_voucher_cond_type" class="form-control promotionVoucherCondType gen">
										<option value="quantity"{if $oneItem.promotion_voucher_cond_type eq 'quantity'} selected{/if}>Số lượng voucher áp dụng</option>
										<option value="total_price"{if $oneItem.promotion_voucher_cond_type eq 'total_price'} selected{/if}>Tổng giá trị voucher khuyến mãi</option>
									</select>
								</div>
								<div class="col-md-6">
									<div class="minimumPromotionVoucherQuantity{if $oneItem.promotion_voucher_cond_type eq 'total_price'} hidden{/if}">
										<input type="number" class="form-control gen" name="minimum_promotion_voucher_quntity" value="{$oneItem.minimum_promotion_voucher_quntity}" />
									</div>
									<div class="input-group{if $oneItem.promotion_voucher_cond_type eq 'quantity'} hidden{/if} minimumPromotionVoucherTotalPrice">
										<span class="input-group-addon">{$clsISO->getRate()}</span>
										<input type="text" class="form-control gen price-In" value="{$clsISO->formatPrice($oneItem.minimum_promotion_voucher_total_price)}" name="minimum_promotion_voucher_total_price" "{$oneItem.minimum_promotion_voucher_total_price}" />
									</div>
								</div>
							</div>
						</div>
					</div>
					{/if}
					<div class="box-end discount__once_per_order"{if $discount_type eq 'amount' and $oneItem.discount_rule eq 'code'}{else} style="display:none"{/if}>
						<div class="icheck-primary">
							<input type="checkbox" name="once_per_order" {if $oneItem.once_per_order eq '1'}checked{/if} value="1" id="checkbox_4" />
							<label for="checkbox_4">Mã giảm giá sẽ được tính 1 lần trên mỗi đơn hàng</label>
						</div>
						<span class="pl-6 gray">Bỏ tích nghĩa là mã giảm giá sẽ được áp dụng vào mỗi voucher trong đơn hàng.</span>
					</div>
				</div>
				{if $oneItem.discount_rule eq 'code'}
				<div class="box light">
					<div class="box-title no-border-bottom"><span class="caption bold">Nhóm khách hàng</span></div>
					<div class="box-body">
						<div class="icheck-primary">
							<input class="gen" type="radio" name="customer_group_type" {if $oneItem.customer_group_type eq 'all'}checked{/if} value="all" id="radio_5" />
							<label for="radio_5">Tất cả</label>
						</div>
						<div class="icheck-primary">
							<input class="gen" type="radio" name="customer_group_type" {if $oneItem.customer_group_type eq 'group'}checked{/if} value="group" id="radio_6" />
							<label for="radio_6">Nhóm khách hàng đã lưu</label>
						</div>
						<div class="form-group ipn__customer_group_type "{if $oneItem.customer_group_type eq 'all'} style="display:none"{/if}>
							<select name="list_customer_group[]" placeholder="Chọn nhóm khách hàng" multiple="multiple" class="form-control gen iso-selectize">
								{section name=i loop=$lstGroup}
								<option value="{$lstGroup[i].property_id}" {if $clsISO->checkInArray($list_customer_group, $lstGroup[i].property_id)}selected{/if}>{$clsProperty->getTitle($lstGroup[i].property_id)}</option>
								{/section}
							</select>
						</div>
					</div>
				</div>
				<div class="box light">
					<div class="box-title no-border-bottom">
						<span class="caption bold">Giới hạn sử dụng</span>
					</div>
					<div class="box-body">
						<div class="icheck-primary">
							<input type="checkbox" class="gen" name="allow_usage_limit" {if $oneItem.allow_usage_limit}checked{/if} value="1" id="checkbox_limit_used" />
							<label for="checkbox_limit_used">Giới hạn số lần mã giảm giá được áp dụng</label>
						</div>
						<div class="form-group ipn__usage_limit pl-6" style="{if $oneItem.allow_usage_limit ne '1'}display:none{/if}">
							<input type="number" class="form-control gen span20" placeholder="Tổng số mã" name="usage_limit" value="{$oneItem.usage_limit}" />
						</div>
						<div class="icheck-primary">
							<input type="checkbox" name="once_per_customer" class="gen" {if $oneItem.once_per_customer}checked{/if} value="1" id="checkbox_8" />
							<label for="checkbox_8">Giới hạn mỗi khách hàng chỉ được sử dụng mã giảm giá này 1 lần</label>
						</div>
						<div class="form-group ipn__once_per_customer pl-6"{if $oneItem.once_per_customer ne '1'} style="display:none"{/if}>
							<span class="gray">Kiểm tra bằng email</span>
						</div>
					</div>
				</div>
				{/if}
				<div class="box light">
					<div class="box-title no-border-bottom">
						<span class="caption bold">Thời gian</span>
					</div>
					<div class="box-body form-horizontal">
						<div class="form-group">
							<div class="col-md-6">
								<label>Ngày bắt đầu</label>
								<div class="input-group">
									<div class="input-group-addon">{$clsISO->makeIcon('calendar')}</div>
									<input type="text" readonly class="form-control gen isodatepicker" id="start_date" name="start_date" value="{$clsISO->convertTimeToText($oneItem.start_date)}" />
								</div>
							</div>
							<div class="col-md-6">
								<label>Thời điểm</label>
								<div class="input-group">
									<div class="input-group-addon">{$clsISO->makeIcon('clock-o')}</div>
									<input type="text" class="form-control gen timepicker" name="start_time" value="{$oneItem.start_date|date_format:"%H:%M"}" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div class="icheck-primary">
									<input type="checkbox" class="gen" onChange="set_enable_duedate(this)" {if $oneItem.is_due_date eq '1'}checked="checked"{/if} name="is_due_date" value="1" id="checkbox_enable_finish_date">
									<label for="checkbox_enable_finish_date">Thời gian kết thúc</label>
								</div>
							</div>
						</div>
						<div class="form-group duedate-section{if $oneItem.is_due_date ne '1'} hidden{/if}">
							<div class="col-md-6">
								<label>Ngày kết thúc</label>
								<div class="input-group">
									<div class="input-group-addon">{$clsISO->makeIcon('calendar')}</div>
									<input type="text" readonly class="form-control gen isodatepicker" id="due_date" name="due_date" value="{$clsISO->convertTimeToText($oneItem.due_date)}" />
								</div>
							</div>
							<div class="col-md-6">
								<label>Thời điểm</label>
								<div class="input-group">
									<div class="input-group-addon">{$clsISO->makeIcon('clock-o')}</div>
									<input type="text" class="form-control gen timepicker" name="due_time" value="{$oneItem.due_date|date_format:"%H:%M"}" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="ui-layout__item">
					<div class="ui-card">
						<header class="ui-card__header">
							<h2 class="ui-heading">{$core->get_Lang('Promotion_Overview')}</h2>
						</header>
						<div class="ui-card__section">
							<div class="ui-type-container preview">Loading...</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="ui-page-actions full-width ui-page-actions--has-secondary">
			<input type="hidden" name="action" value="{$action}">
			<input value="Update" name="submit" type="hidden">
			<div class="ui-page-actions__container">
				<div class="ui-page-actions__actions ui-page-actions__actions--secondary">
					<div class="ui-page-actions__button-group">
						{if $pvalTable gt '0'}
						<a class="btn btn-warning" onClick="delete_globe(this)" clsTable="Discount" pval_id="{$pvalTable}" pkey="{$pkeyTable}" return_url="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Delete')}</a>
						{/if}
					</div>
				</div>
				<div class="ui-page-actions__actions ui-page-actions__actions--primary">
					<div class="ui-page-actions__button-group">
						{$saveBtn}&nbsp;{$saveList}
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
{if $action eq '_add'}
<script type="text/javascript">
	var action = '{$action}';
	var type = '{$oneItem.type}';
	var discount_id = '{$pvalTable}';
</script>
{else}
<script type="text/javascript">
	var action = '{$action}';
	var type = '{$oneItem.type}';
	var discount_id = '{$pvalTable}';
</script>
{/if}
{literal}
<style>
.frmPop .modal-dialog .modal-body{max-height: 360px; overflow-y: auto}
.close_pop{color: #333}
</style>
<script>
$('#start_date').datepicker({
	dateFormat: "dd/mm/yy", 
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	showOtherMonths: true,
	onSelect: function(dateStr) { 
		var date = $(this).datepicker('getDate'); 
		if(date){ 
			date.setDate(date.getDate() + 1); 
		} 
		$('#due_date').datepicker('option', {minDate: date}).datepicker('setDate', date); 
	},
	onClose: function(dateText, inst) {
		$('#due_date').focus();
	}
});
$("#due_date").datepicker( { 
	dateFormat: "dd/mm/yy", 
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	showOtherMonths: true,
	minDate: $('#start_date').val()
});	
if($('.timepicker:not(.ui-timepicker-input)').length){
	$('.timepicker:not(.ui-timepicker-input)')
		.addClass('ui-timepicker-input').timepicker({
		'step' : 15,
		'timeFormat': 'h:i A',
		'forceRoundTime':true
	});
}
 if($('.datepicker:not(.hasDatepicker)').length){
	$('.datepicker:not(.hasDatepicker)').datepicker({
		'dateFormat': 'dd/mm/yy',
		'minDate'	: new Date()
	});
}
</script>
{/literal}
{literal}
<style>.modal-footer{position: relative !important; height: 60px;}.frmPop {background: none !important;box-shadow: 0 0px 0px rgba(0,0,0,0.2) !important; top: 0 !important}</style>
{/literal}
<link rel="stylesheet" href="{$URL_JS}/jquery-easyui/themes/gray/easyui.css?v={$upd_version}" type="text/css" media="all" />
<script type="text/javascript" src="{$URL_JS}/jquery-easyui/jquery.easyui.min.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/discount/js/jquery.discount.js?v={$upd_version}"></script>