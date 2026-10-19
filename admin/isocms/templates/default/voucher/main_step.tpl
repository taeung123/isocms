<form class="tm-form-section" id="editVoucherForm" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	{if $currentstep=='image'}
		{assign var= image_detail value='image_voucher'}
		{$core->getBlock('box_detail_image')}
	{elseif $currentstep=='generalinformation'}
		{$core->getBlock('box_detail_voucher_basic-information')}
	{elseif $currentstep=='highLight'}
		<div class="inpt_tour">
			<label for="title">{$core->get_Lang('HighLight')}
				{assign var= highLight_voucher value='highLight_voucher'}
				{assign var= help_first value=$highLight_voucher}
				{if $CHECKHELP eq 1}
					<button data-key="{$highLight_voucher}" data-label="{$core->get_Lang('HighLight')}" type="button"
						title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i
							class="fa fa-plus-circle"></i></button>
				{/if}
			</label></br>
			<textarea style="width:100%" table_id="{$pvalTable}" name="iso-intro" class="textarea_intro_editor"
				data-column="iso-intro" id="textarea_intro_editor_overview_{$now}" cols="255"
				rows="2">{$oneItem.intro}</textarea>
			{literal}
				<script>
					$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
				</script>
			{/literal}
		</div>
	{elseif $currentstep=='detail_information'}
		<div class="inpt_tour">
			<label for="title">{$core->get_Lang('Detail Information')}
				{assign var= detail_information_voucher value='detail_information_voucher'}
				{assign var= help_first value=$detail_information_voucher}
				{if $CHECKHELP eq 1}
					<button data-key="{$detail_information_voucher}" data-label="{$core->get_Lang('Detail Information')}"
						type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i
							class="fa fa-plus-circle"></i></button>
				{/if}
			</label></br>
			<textarea style="width:100%" table_id="{$pvalTable}" name="iso-content" class="textarea_intro_editor"
				data-column="iso-content" id="textarea_intro_editor_overview_{$now}" cols="255"
				rows="2">{$oneItem.content}</textarea>
			<div class="text_help" hidden="">{$clsConfiguration->getValue($detail_information_voucher)|html_entity_decode}
			</div>
			{literal}
				<script>
					$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
				</script>
			{/literal}
		</div>
	{elseif $currentstep=='conditions_apply'}
		<div class="inpt_tour">
			<label for="title">{$core->get_Lang('Conditions apply')}
				{assign var= conditions_apply_voucher value='conditions_apply_voucher'}
				{assign var= help_first value=$conditions_apply_voucher}
				{if $CHECKHELP eq 1}
					<button data-key="{$conditions_apply_voucher}" data-label="{$core->get_Lang('Conditions apply')}"
						type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i
							class="fa fa-plus-circle"></i></button>
				{/if}
			</label></br>
			<textarea style="width:100%" table_id="{$pvalTable}" name="iso-location" class="textarea_intro_editor"
				data-column="iso-location" id="textarea_intro_editor_overview_{$now}" cols="255"
				rows="2">{$oneItem.location}</textarea>
			{literal}
				<script>
					$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
				</script>
			{/literal}
		</div>

	{elseif $currentstep=='destination'}
		<div class="inpt_tour">
			<label for="title">{$core->get_Lang('infodestinationadmin')}
				{assign var= destination_voucher value='destination_voucher'}
				{assign var= help_first value=$destination_voucher}
				{if $CHECKHELP eq 1}
					<button data-key="{$destination_voucher}" data-label="{$core->get_Lang('infodestinationadmin')}"
						type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i
							class="fa fa-plus-circle"></i></button>
				{/if}
			</label></br>
			<div class="fieldarea">
				<div class="d-flex">
					{if $clsISO->getCheckActiveModulePackage($package_id,'continent','default','default') and $core->checkAccess('continent')}
						<select class="slb form-control-new mr5" name="chauluc_id" style="width:160px" id="slb_Chauluc"
							onClick="loadHelp(this)">
							{$clsContinent->makeSelectboxOption()}
						</select>
					{/if}
					<select class="slb form-control-new mr5" name="country_id" id="slb_Country"
						style="width:160px !important;">
						<option value="0">-- {$core->get_Lang('selectcountry')} --</option>
					</select>
					{if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
						<select class="slb form-control-new mr5" id="slb_RegionID" name="region_id"
							style="width:160px !important;">
							<option value="0">-- {$core->get_Lang('selectregion')} --</option>
						</select>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
						<div id="slb_city_Id_Container" class="form-group mr5">
							<select class="slb form-control-new iso-selectbox" id="slb_CityID" name="city_id"
								style="width: auto">
								<option value="0">-- {$core->get_Lang('selectcity')} --</option>
							</select>
						</div>
					{/if}
					<button class="btn-add ajQuickAddDestination" onClick="addDestination(this)"
						type="button">{$core->get_Lang('adddestination')}</button>
				</div>

				{literal}
					<script>
						loadCountry();
					</script>
				{/literal}
			</div>
			<div class="clear"><br></div>
			<div class="row-span">
				<div style="padding-left:10px">
					<ul class="list-group" id="lstDestination" style="width:500px;"></ul>
					<div class="clearfix mt10"></div>
					<span class="notice" style="padding:0;color:#0565c9">(<span class="requiredMask">*</span> )
						{$core->get_Lang('infoless1destination')}</span>
				</div>
			</div>
			<script>
				loadListDestination({$pvalTable});
			</script>
		</div>
	{elseif $currentstep=='photoGallery'}
		{$core->getBlock('box_detail_voucher_image-gallery')}
	{elseif $currentstep=='configPrice'}
		<h3 class="title_box mb0">{$core->get_Lang('Config Price')}</h3>
		<div class="tabbox">
			<form method="post" action="">
				<div class="row">
					<div class="col-xs-12">
						<div class="ui-card mt-half">
							<header class="ui-card__header">
								<h4 class="ui-heading">{$core->get_Lang('Price')}
								</h4>
							</header>
							<div class="ui-card__section">
								<div class="ui-type-container">
									<div class="form-group">
										<div class="row">
											<div class="col-md-9">
												<label class="col-form-label">{$core->get_Lang('Price')}
													{assign var= title_price_voucher value='title_price_voucher'}
													{assign var= help_first value=$title_price_voucher}
													{if $CHECKHELP eq 1}
														<button data-key="{$title_price_voucher}"
															data-label="{$core->get_Lang('Price')}" type="button"
															title="Thêm mô tả" onclick="open_texthelp(this, event)"
															class="btn btn-xs btn-default"><i
																class="fa fa-plus-circle"></i></button>
													{/if}
												</label>
												<div class="row">
													<div class="col-md-8">
														<div class="input-group">
															<span
																class="input-group-addon">{$clsISO->getShortCurrency()}</span>
															<input type="text"
																class="form-control require numberonly price-In"
																required="true" name="price" value="{$oneItem.price}"
																onClick="loadHelp(this)" />
															<div class="text_help" hidden="">
																{$clsConfiguration->getValue($title_price_voucher)|html_entity_decode}
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="input-group">
															<select class="form-control" name="unit">
																{$clsProperty->getSelectByProperty('Unit', $oneItem.unit)}
															</select>
														</div>
													</div>
												</div>

											</div>
											{if 1==2}
												<div class="col-md-6 col-md-12">
													<label class="col-form-label">{$core->get_Lang('PriceInput')}
														{assign var= title_price_input_voucher value='title_price_input_voucher'}
														{if $CHECKHELP eq 1}
															<button data-key="{$title_price_input_voucher}"
																data-label="{$core->get_Lang('PriceInput')}" type="button"
																title="Thêm mô tả" onclick="open_texthelp(this, event)"
																class="btn btn-xs btn-default"><i
																	class="fa fa-plus-circle"></i></button>
														{/if}
													</label>
													<div class="input-group">
														<span class="input-group-addon">{$clsISO->getShortCurrency()}</span>
														<input type="text" class="form-control price-In numberonly"
															name="price_input" value="{$oneItem.price_input}"
															onClick="loadHelp(this)" />
														<div class="text_help" hidden="">
															{$clsConfiguration->getValue($title_price_input_voucher)|html_entity_decode}
														</div>
													</div>
												</div>
											{/if}
										</div>
									</div>
									<div class="form-group">

										<a target="_blank" href="{$PCMS_URL}/index.php?mod=property&type=Unit"
											title="{$core->get_Lang('Manage Unit')}">{$core->get_Lang('Manage Unit')}</a>
										<div class="text_help" hidden="">
											{$clsConfiguration->getValue($mass_voucher)|html_entity_decode}</div>
									</div>
									{if 1==2}
										<div class="form-group">
											<div class="custom-checkbox-wrapper core-checkbox-custom">
												<label class="">
													<input{if $oneItem.taxable eq '1'} checked{/if} name="taxable" value="1"
														type="checkbox">
														<span class="custom-checkbox custom-icon"></span>
												</label> {$core->get_Lang('Price_Included_VAT')}
											</div>
										</div>
									{/if}
								</div>
							</div>
						</div>

						<div class="ui-card mt-half">
							<header class="ui-card__header">
								<h4 class="ui-heading">Kho hàng</h4>
							</header>
							<div class="ui-card__section">
								<div class="ui-type-container">

									{if 1==2}
										<div class="form-group">
											<div class="row">
												<div class="col-md-6 col-md-12">
													<label class="col-form-label">Mã Voucher / SKU
														{assign var= code_voucher value='code_voucher'}
														{if $CHECKHELP eq 1}
															<button data-key="{$code_voucher}" data-label="Mã Voucher / SKU"
																type="button" title="Thêm mô tả"
																onclick="open_texthelp(this, event)"
																class="btn btn-xs btn-default"><i
																	class="fa fa-plus-circle"></i></button>
														{/if}
													</label>
													<input type="text" class="form-control require" required name="iso-code"
														value="{$oneItem.code}" onClick="loadHelp(this)" />
													<div class="text_help" hidden="">
														{$clsConfiguration->getValue($code_voucher)|html_entity_decode}</div>
												</div>
												<div class="col-md-6 col-md-12">
													<label class="col-form-label">Mã vạch / Barcode (ISBN, UPC, v.v...)
														{assign var= barcode_voucher value='barcode_voucher'}
														{if $CHECKHELP eq 1}
															<button data-key="{$barcode_voucher}"
																data-label="Mã vạch / Barcode (ISBN, UPC, v.v...)" type="button"
																title="Thêm mô tả" onclick="open_texthelp(this, event)"
																class="btn btn-xs btn-default"><i
																	class="fa fa-plus-circle"></i></button>
														{/if}
													</label>
													<input type="text" class="form-control" name="iso-barcode"
														value="{$oneItem.barcode}" onClick="loadHelp(this)" />
													<div class="text_help" hidden="">
														{$clsConfiguration->getValue($barcode_voucher)|html_entity_decode}</div>
												</div>
											</div>
										</div>
									{/if}
									<div class="form-group">
										<div class="row">
											<div class="col-md-6 col-md-12">
												<label class="col-form-label">Quản lý kho
													{assign var= warehouse_voucher value='warehouse_voucher'}
													{if $CHECKHELP eq 1}
														<button data-key="{$warehouse_voucher}" data-label="Quản lý kho"
															type="button" title="Thêm mô tả"
															onclick="open_texthelp(this, event)"
															class="btn btn-xs btn-default"><i
																class="fa fa-plus-circle"></i></button>
													{/if}
												</label>
												<select class="form-control" onChange="setInventory(this)"
													name="is_inventory" onClick="loadHelp(this)">
													<option{if $oneItem.is_inventory eq '0'} selected{/if} value="0">
														{$core->get_Lang('NoStockManagement')}</option>
														<option{if $oneItem.is_inventory eq '1'} selected{/if} value="1">
															{$core->get_Lang('AllowStockManagement')}</option>
												</select>
												<div class="text_help" hidden="">
													{$clsConfiguration->getValue($warehouse_voucher)|html_entity_decode}
												</div>
											</div>
											<div
												class="col-md-6 col-md-12 stock-quantity-section{if $oneItem.is_inventory ne '1'} hidden{/if}">
												<label class="col-form-label">Số lượng
													{assign var= amount_voucher value='amount_voucher'}
													{if $CHECKHELP eq 1}
														<button data-key="{$amount_voucher}" data-label="Số lượng" type="button"
															title="Thêm mô tả" onclick="open_texthelp(this, event)"
															class="btn btn-xs btn-default"><i
																class="fa fa-plus-circle"></i></button>
													{/if}
												</label>
												<input type="number" min="0" class="form-control numberonly"
													value="{$clsClassTable->getTotalQuantityInStock($pvalTable)}"
													name="quantity" onClick="loadHelp(this)" />
												<div class="text_help" hidden="">
													{$clsConfiguration->getValue($amount_voucher)|html_entity_decode}</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="custom-checkbox-wrapper core-checkbox-custom">
											<label class="">
												<input{if $oneItem.continue_order eq '1'} checked{/if} name="continue_order"
													value="1" type="checkbox">
													<span class="custom-checkbox custom-icon"></span>
											</label> Cho phép tiếp tục đặt hàng khi hết hàng
										</div>
									</div>
								</div>
							</div>
						</div>
						{if 1==2}
							<div class="ui-card mt-half">
								<header class="ui-card__header">
									<h4 class="ui-heading">{$core->get_Lang('Transfer')}</h4>
								</header>
								<div class="ui-card__section">
									<div class="ui-type-container">
										<div class="form-group">
											<div class="custom-checkbox-wrapper core-checkbox-custom">
												<label class="">
													<input onChange="setTransfer(this)" name="is_shipping"
														{if $oneItem.is_shipping eq '1'} checked{/if} value="1" type="checkbox">
													<span class="custom-checkbox custom-icon"></span>
												</label> Sản phẩm yêu cầu vận chuyển
											</div>
										</div>
									</div>
								</div>
								<div class="ui-card__section transfer-section{if $oneItem.is_shipping ne '1'} hidden{/if}">
									<div class="ui-type-container" onClick="loadHelp(this)">
										<div class="ui-stack ui-stack--wrap ui-stack--vertical ui-stack--spacing-tight">
											<h3 class="ui-subheading">Khối lượng
												{assign var= mass_voucher value='mass_voucher'}
												{if $CHECKHELP eq 1}
													<button data-key="{$mass_voucher}" data-label="Khối lượng" type="button"
														title="Thêm mô tả" onclick="open_texthelp(this, event)"
														class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
												{/if}
											</h3>
											<p class="type--subdued">Được dùng để tính phí vận chuyển ở trang thanh toán</p>
										</div>
										<div class="form-group">
											<div class="input-group double-input mb10">
												<input type="text" class="form-control numberonly" name="iso-weight"
													value="{$oneItem.weight}" />
												<select class="form-control" name="unit">
													{$clsProperty->getSelectByProperty('Unit', $oneItem.unit)}
												</select>
											</div>
											<a href="{$PCMS_URL}/index.php?mod=property&type=Unit"
												title="{$core->get_Lang('Manage Unit')}">{$core->get_Lang('Manage Unit')}</a>
											<div class="text_help" hidden="">
												{$clsConfiguration->getValue($mass_voucher)|html_entity_decode}</div>
										</div>
									</div>
								</div>
							</div>
						{/if}
					</div>
				</div>
			</form>
		</div>
	{elseif $currentstep=='seo'}
		{$core->getBlock('box_detail_voucher_seotool')}
	{/if}
	{* <div class="btn_save_titile_table_code mt30">
		<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$arrStep[$step].key}"
			data-prevstep="{$prevstep}" class="back_step js_save_back">{$core->get_Lang('Back')}</a>

		<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$currentstep}"
			data-next_step="{$nextstep}" class="js_save_continue">{$core->get_Lang('Save &amp; Continue')}</a>
	</div> *}
</form>

<script>
	var voucher_id = $voucher_id = '{$pvalTable}';
	var list_check_target = {$list_check_target};
</script>
{literal}
	<style>
		.fill_data_box select {
			height: 50px;
		}
	</style>
	<script>
		if ($('.textarea_intro_editor').length > 0) {
			$('.textarea_intro_editor').each(function() {
				var $_this = $(this);
				var $editorID = $_this.attr('id');
				$('#' + $editorID).isoTextArea();
			});
		}
		$('.toggle-row').click(function() {
			$(this).closest('tr').toggleClass('open_tr');
		});
		$.each(list_check_target, function(i, val) {
			if (val.status == 1) {
				$('#step_' + val.key).closest('li').removeAttr('class').addClass("check_success");
			} else {
				$('#step_' + val.key).closest('li').removeAttr('class').addClass("check_caution");
			}
		});
	</script>
{/literal}