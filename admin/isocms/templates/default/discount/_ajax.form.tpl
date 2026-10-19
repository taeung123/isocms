{if $template eq '_add'}
	<div class="headPop headPop2">
		<a href="javascript:void(0);" class="closeEv close_pop"></a>
		<h3>
			{if $action eq '_edit'}
				{$core->get_Lang('Edit Discount')}
			{else}
				{$core->get_Lang('Add new')}
			{/if}
		</h3>
	</div>
	<div class="bodyPop">
			<form method="post">
				<div class="modal-body version-xs">
					<div class="row flex-row">
						<div class="col-xs-12 col-md-7 left_pop">
							<div class="form-group mb-4">
								<label class="col-form-label text-bold">{$core->get_Lang('Discount Name')} <span class="text-red">*</span></label>
								<input type="text" class="form-control required fontLarge" value="{$oneItem.title}" name="title" maxlength="255" placeholder="" />
							</div>
							<div class="form-group mb-4">
								<label class="col-form-label text-bold">{$core->get_Lang('Code')} <span class="text-red">*</span></label>
								<div class="input-group">
									<input type="text" class="form-control ipn__discount_code required"{if $action eq '_edit'} readonly{/if} value="{$oneItem.code}" name="code" maxlength="255" placeholder="{$core->get_Lang('Code')}" />
									<div class="input-group-btn">
										<button type="button" onClick="generateCode(this)"{if $action eq '_edit'} disabled{/if} discount_id="{$discount_id}" class="btn btn-default">{$clsISO->makeIcon('refresh', $core->get_Lang('Generate Code'))}</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-form-label text-bold">{$core->get_Lang('Discount Type')} <span class="text-red">*</span></label>
								<span class="help-block">Bạn có thể chọn giữa loại chiết khấu theo tỷ lệ phần trăm hoặc phí cố định.</span>
								<div class="clearfix"></div>
								<div class="d-flex">
									<div class="btn-group mr-4" data-toggle="buttons">
										<button class="btn btn-default {if $more_information.discount_type eq 2}active{/if}">
											<input type="radio" checked="checked" value="2" suffix="%" onchange="handler_discount_change(this)" name="discount_type" {if $more_information.discount_type eq 2}checked{/if}>{$core->get_Lang('Percent')}
										</button>
										<button class="btn btn-default {if $more_information.discount_type eq 1}active{/if}">
											<input type="radio" suffix="{$clsISO->getRate()}" onchange="handler_discount_change(this)" value="1" name="discount_type" {if $more_information.discount_type eq 1}checked{/if}> {$core->get_Lang('Value')}
										</button>
									</div>
									<div class="input-group">
										<input type="text" class="form-control required numberonly w-150px" min="0" max="100" placeholder="0.00" name="discount_value" value="{$more_information.discount_value}">
										<span class="input-group-addon discount-suffix">{if $more_information.discount_type eq 2}%{else}{$clsISO->getRate()}{/if}</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-form-label text-bold">{$core->get_Lang('Booking Date')} <span class="text-red">*</span></label>
								<div class="input-date-picker">
									<i class="ico ico-calendar"></i>
									<input type="text" class="from_date required" name="booking_date_from" readonly placeholder="{$core->get_Lang('From date')}" value="{if $action eq '_edit'}{$clsISO->convertTimeToText($oneItem.booking_date_from)}{/if}">
									<span class="input-picker-separator">--</span>
									<input type="text" class="to_date required" name="booking_date_to" readonly placeholder="{$core->get_Lang('To date')}" value="{if $action eq '_edit'}{$clsISO->convertTimeToText($oneItem.booking_date_to)}{/if}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-form-label text-bold">{$core->get_Lang('Travel Date')} <span class="text-red">*</span></label>
								<div class="input-date-picker">
									<i class="ico ico-calendar"></i>
									<input type="text" class="from_date required" readonly name="travel_date_from" placeholder="{$core->get_Lang('From date')}" value="{if $action eq '_edit'}{$clsISO->convertTimeToText($oneItem.travel_date_from)}{/if}">
									<span class="input-picker-separator">--</span>
									<input type="text" class="to_date required" readonly name="travel_date_to" placeholder="{$core->get_Lang('To date')}" value="{if $action eq '_edit'}{$clsISO->convertTimeToText($oneItem.travel_date_to)}{/if}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-form-label text-bold">{$core->get_Lang('Travel Days of the Week')}</label>
								<div class="clearfix"></div>
								<label class="checkbox-inline">
									<input type="checkbox" name="is_alldays"{if $more_information.is_alldays} checked{/if} value="1" />
									{$core->get_Lang('All days')}
								</label>
								<span class="help-block text-muted">{$core->get_Lang('Select the travel dates to which this promotional code applies.')}</span>
								<div class="vs-checkbox mt-3">
									{foreach from = $lstDay key = _Key item = _Item}
									<input type="checkbox" id="weekday-{$_Key}" name="weekdays[]"{if $clsISO->checkItemInArray($_Key, $weekdays_arr)}checked {/if} value="{$_Key}" class="weekday">
									<label for="weekday-{$_Key}">{$core->get_Lang($_Item)}</label>
									{/foreach}
								</div>
							</div>
							<div class="form-group">
								<label class="col-form-label text-bold">{$core->get_Lang('Other Setting')}</label>
								<div class="clearfix"></div>
								<label class="checkbox-inline mb-2">
									<input type="checkbox" name="use_addon_service" value="1"{if $more_information.use_addon_service} checked{/if} />
									{$core->get_Lang('Apply discount to addon services')}
								</label>
								<div class="clearfix"></div>
								<label class="checkbox-inline mb-2">
									<input type="checkbox" name="use_extra_bed" value="1"{if $more_information.use_extra_bed} checked{/if}/>
									{$core->get_Lang('Apply discount to extra bed')}
								</label>
								<div class="clearfix"></div>
								<label class="checkbox-inline">
									<input type="checkbox" name="allow_usage_limit"{if $more_information.allow_usage_limit} checked{/if} value="1" />
									{$core->get_Lang('Usage Limits')}
								</label>
								<div id="usage_limit" class="form-group pl-4 {if $more_information.allow_usage_limit eq '0'} hidden{/if}">
									<label class="col-form-label">{$core->get_Lang("Number of uses")}:</label>
									<input type="number" class="form-control numberonly w-200px" name="usage_limit" value="{$more_information.usage_limit}" />
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-5 right_pop">
							<div class="p-4">
								<p class="text">
									{$core->get_Lang('Here you can choose whether the promotional code applies to all your products or selected products. If you choose selected products, you will be able to choose from the list of products to be included.')}
								</p>
								<div class="form-group">
									<label class="col-form-label text-bold">{$core->get_Lang('Other Setting')} <span class="text-red">*</span></label>
									<div class="clearfix"></div>
									<label class="radio-inline">
										<input type="radio" discount_id="{$discount_id}" name="product_type"{if $more_information.product_type eq 'all'} checked{/if} value="all" />
										{$core->get_Lang('All Products')}
									</label>
									<div class="clearfix"></div>
									<label class="radio-inline">
										<input type="radio" discount_id="{$discount_id}" name="product_type"{if $more_information.product_type eq 'product'} checked{/if} value="product" />
										{$core->get_Lang('Selected Products')}
									</label>
								</div>
								<div class="form-group holder_product_group{if $more_information.product_type eq 'all'} hidden{/if}">
									<label class="col-form-label">1.{$core->get_Lang('Group product')}</label>
									<select class="form-control iso-selectbox" onchange="handler_filter_objects(this)" name="product_group" discount_id="{$discount_id}" data-width="100%" data-placeholder="{$core->get_Lang('Group product')}">
										<option value="tour">{$core->get_Lang('Tour')}</option>
										<option value="hotel">{$core->get_Lang('Hotel')}</option>
										<option value="cruise">{$core->get_Lang('Cruise')}</option>
										<option value="combo">{$core->get_Lang('Combo')}</option>
										<option value="voucher">{$core->get_Lang('Voucher')}</option>
									</select>
								</div>
								<div id="holder_filters_{$discount_id}" class="holder_filters holder_product_group{if $more_information.product_type eq 'all'} hidden{/if}">
									<div class="loading text-center">{$core->get_Lang('Loading')}...</div>
								</div>
								<div class="form-group holder_product_group{if $more_information.product_type eq 'all'} hidden{/if}">
									<label class="col-form-label text-bold">{$core->get_Lang('Selected Products')} (<span id="total_items">0</span>)</label>
									<div id="holder_products_discount" class="holder_products_discount">
										<div class="loading text-center">{$core->get_Lang('Loading')}...</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="btn_group footerPop">
					<button type="button" class="btn btn-default" data-dismiss="modal">{$core->get_Lang('Close')}</button>
					<button type="button" class="btn btn-success" onClick="pop_save_discount(this,event)" discount_id="{$discount_id}">
						{$core->get_Lang('Save')}
					</button>
				</div>
			</form>
	</div>
{else}
<div class="modal-dialog{if $type eq 'voucher'} modal-standard{/if}" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Tìm kiếm sản phẩm</h5>
			<button type="button" class="close close_pop" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="input-group mb5">
				<div class="input-group-addon"><i class="fa fa-search"></i></div>
				<input type="text" class="form-control form-input-search" discount_id="{$discount_id}" _type="{$type}" value="{$keyword}" placeholder="Tìm kiếm sản phẩm" />
			</div> 
			{if $type eq 'voucher'}
			<table id="dg" class="easyui-datagrid" url="{$PCMS_URL}/index.php?mod=discount&act=load_list_voucher_search&lang={$_LANG_ID}" 
			fitColumns="true" singleSelect="false" showHeader="true" pagination="true" style="width:100%; height:400px">
				<thead><tr>
					<th data-options="field:'ck',width:50,align:'center',checkbox:'true'"></th>
					<th data-options="field:'image',width:40,align:'center'">H.ảnh</th>
					<th data-options="field:'code',width:120">Mã sản phẩm</th>
					<th data-options="field:'name',width:250">Tên sản phẩm</th>
				</tr></thead>
			</table>
			{else}
			<table class="easyui-datagrid" id="dg" url="{$PCMS_URL}/index.php?mod=discount&act=load_list_category_search" 
			fitColumns="true" singleSelect="false" showHeader="true" pagination="true" style="width:100%; height:400px">
				<thead><tr>
					<th data-options="field:'ck',width:40,align:'center',checkbox:'true'"></th>
					<th data-options="field:'name',width:250">Tên danh mục</th>
					<th data-options="field:'qty',width:100,align:'left'">SL. sản phẩm</th>
				</tr></thead>
			</table>
			{/if}
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{$core->get_Lang('Close')}</button>
			<button type="button" class="btn btn-success" onClick="add_choice_discount(this)" discount_id="{$discount_id}" _type="{$type}">{$core->get_Lang('Update')}</button>
		</div>
	</div>
</div>
{/if}
