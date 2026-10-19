<div class="ui-title-bar-container">
	<div class="ui-title-bar">
		<div class="ui-title-bar__navigation">
			<div class="ui-breadcrumbs">
				<a href="{$PCMS_URL}/index.php?mod={$mod}" class="btn btn-default ui-breadcrumb">
					{$clsISO->makeIcon('angle-left mr-5')}
					<span class="ui-breadcrumb__item">{$core->get_Lang('VoucherPage')}</span>
				</a>
			</div>
		</div>
	</div>
	<div class="ui-title-bar__main-group">
		<div class="ui-title-bar__heading-group">
			{if $action eq 'edit'}
			<h1 class="ui-title-bar__title w-100">{$clsClassTable->getTitle($pvalTable)}</h1>
			<div class="action-bar__item action-bar__item--link-container">
				<div class="action-bar__top-links">
					<a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" class="ui-button ui-button--transparent action-bar__link"  target="_blank">{$clsISO->makeIcon('eye', $core->get_Lang('ViewOnWeb'))}</a>
				</div>
			</div>
			{else}
			<h1 class="ui-title-bar__title">{$core->get_Lang('add')} {$core->get_Lang('voucher')}</h1>
			{/if}
		</div>
	</div>
</div>
<!-- Form upload image -->
<form method="post" class="hidden" action="" enctype="multipart/form-data">
	<input name="images[]" id="image-upload" type="file" onChange="fileInputChanged(event, this)" multiple accept="image/*" class="js-no-dirty">
</form>
<!-- End form -->
<form method="post" action="" class="validate-form" enctype="multipart/form-data">
	<div class="ui-layout">
		<div class="row">
			<div class="col-md-8 col-xs-12">
				<div class="ui-layout__item">
					<div class="ui-card">
						<div class="ui-card__section">
							<div class="ui-type-container">
								<div class="form-group">
									<label class="col-form-label">{$core->get_Lang('nameofvoucher')} <span class="text-red">*</span></label>
									<input type="text" class="form-control require fontLarge" required="true" name="iso-title" value="{if $pvalTable gt '0'}{$oneItem.title}{/if}" />
								</div>
								<div class="form-group">
									<label class="col-form-label">{$core->get_Lang('ShortIntro')}</label>
									 {$clsForm->showInput('intro')}
								</div>
								<div class="form-group">
									<label class="col-form-label">{$core->get_Lang('Content')}</label>
									 {$clsForm->showInput('content')}
								</div>
							</div>
						</div>
					</div>
					<div class="ui-card mt-half">
						<header class="ui-card__header">
							<div class="ui-stack ui-stack--wrap">
								<div class="ui-stack-item ui-stack-item--fill">
									<h2 class="ui-heading">{$core->get_Lang('Image')}</h2>
								</div>
								<div class="ui-stack-item">
									<button type="button" onClick="$('#image-upload').click()" class="ui-button ui-button--link">{$core->get_Lang('AddImages')}</button>
									
								</div>
							</div>
						</header>
						<div class="ui-card__section">
							<div class="ui-type-container">
								<div id="upload-dropzone__wrapper" class="upload-dropzone__wrapper text-center">
									Loading...
								</div>
							</div>
						</div>
					</div>
					<div class="ui-card mt-half">
						<header class="ui-card__header">
							<h2 class="ui-heading">{$core->get_Lang('Price')}</h2>
						</header>
						<div class="ui-card__section">
							<div class="ui-type-container">
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-6 col-md-12">
											<label class="col-form-label">{$core->get_Lang('Price')}</label>
											<div class="input-group">
												<span class="input-group-addon">₫</span>
												<input type="text" class="form-control require numberonly price-In" required="true" name="price" value="{$oneItem.price}" />
											</div>
										</div>
										<div class="col-md-6 col-md-12">
											<label class="col-form-label">{$core->get_Lang('PriceInput')}</label>
											<div class="input-group">
												<span class="input-group-addon">₫</span>
												<input type="text" class="form-control price-In numberonly" name="price_input" value="{$oneItem.price_input}" />
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="custom-checkbox-wrapper core-checkbox-custom">
										<label class="">
											<input{if $oneItem.taxable eq '1'} checked{/if} name="taxable" value="1" type="checkbox">
											<span class="custom-checkbox custom-icon"></span>
										</label> {$core->get_Lang('Price_Included_VAT')}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ui-card mt-half">
						<header class="ui-card__header">
							<h2 class="ui-heading">Kho hàng</h2>
						</header>
						<div class="ui-card__section">
							<div class="ui-type-container">
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-6 col-md-12">
											<label class="col-form-label">Mã sản phẩm / SKU</label>
											<input type="text" class="form-control require" required name="iso-code" value="{$oneItem.code}" />
										</div>
										<div class="col-md-6 col-md-12">
											<label class="col-form-label">Mã vạch / Barcode (ISBN, UPC, v.v...)</label>
											<input type="text" class="form-control" name="iso-barcode" value="{$oneItem.barcode}" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-6 col-md-12">
											<label class="col-form-label">Quản lý kho</label>
											<select class="form-control" onChange="setInventory(this)" name="is_inventory">
												<option{if $oneItem.is_inventory eq '0'} selected{/if} value="0">{$core->get_Lang('NoStockManagement')}</option>
												<option{if $oneItem.is_inventory eq '1'} selected{/if} value="1">{$core->get_Lang('AllowStockManagement')}</option>
											</select>
										</div>
										<div class="col-md-6 col-md-12 stock-quantity-section{if $oneItem.is_inventory ne '1'} hidden{/if}">
											<label class="col-form-label">Số lượng</label>
											<input type="number" min="0" class="form-control numberonly" value="{$clsClassTable->getQuantityInStock($pvalTable)}" name="quantity" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="custom-checkbox-wrapper core-checkbox-custom">
										<label class="">
											<input{if $oneItem.continue_order eq '1'} checked{/if} name="continue_order" value="1" type="checkbox"> 
											<span class="custom-checkbox custom-icon"></span>
										</label> Cho phép tiếp tục đặt hàng khi hết hàng
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ui-card mt-half">
						<header class="ui-card__header">
							<h2 class="ui-heading">{$core->get_Lang('Transfer')}</h2>
						</header>
						<div class="ui-card__section">
							<div class="ui-type-container">
								<div class="form-group">
									<div class="custom-checkbox-wrapper core-checkbox-custom">
										<label class="">
											<input onChange="setTransfer(this)" name="is_shipping"{if $oneItem.is_shipping eq '1'} checked{/if} value="1" type="checkbox"> 
											<span class="custom-checkbox custom-icon"></span>
										</label> Sản phẩm yêu cầu vận chuyển
									</div>
								</div>
							</div>
						</div>
						<div class="ui-card__section transfer-section{if $oneItem.is_shipping ne '1'} hidden{/if}">
							<div class="ui-type-container">
								<div class="ui-stack ui-stack--wrap ui-stack--vertical ui-stack--spacing-tight">
									<h3 class="ui-subheading">Khối kượng</h3>
									<p class="type--subdued">Được dùng để tính phí vận chuyển ở trang thanh toán</p>
								</div>
								<div class="form-group">
									<div class="input-group double-input">
										<input type="text" class="form-control numberonly" name="iso-weight" value="{$oneItem.weight}" />
										<select class="form-control" name="iso-unit">
											{$clsISO->getSelectByPropertyTypeTitle('_UNIT', $oneItem.unit, $core->get_Lang('Unit'))}
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ui-card mt-half">
						<header class="ui-card__header">
							<div class="ui-stack ui-stack--wrap">
								<div class="ui-stack-item ui-stack-item--fill">
									<h2 class="ui-heading">{$core->get_Lang('PreviewSearchResult')}</h2>
								</div>
								<div class="ui-stack-item">
									<button type="button" onClick="showSeo(this)" class="ui-button ui-button--link">{$core->get_Lang('CustomSeo')}</button>
								</div>
							</div>
						</header>
						<div class="ui-card__section">
							<div class="ui-type-container">
								<div class="holderPrevSeo">
									{$clsISO->getPreviewSEO('Voucher', $pvalTable)}
								</div>
							</div>
						</div>
						<div class="ui-card__section seo-section hidden">
							<div class="ui-type-container">
								<div class="form-group">
									<div class="ui-form__label-wrapper">
										<label class="col-form-label">{$core->get_Lang('TitlePage')}</label>
										<p class="type--subdued">{$core->get_Lang('NumberOfCharactersUsed')}: <span data-bind="titleCharsRemainingText()" class="title-counter__charactor" >0</span>/70</p>
									</div>
									<input type="text" class="form-control input-bind__counter" clsTable="Voucher" pvalTable="{$pvalTable}" name="config_value_title"{if $pvalTable gt '0'} value="{$clsISO->getPageTitle($pvalTable,'Voucher')}"{/if} data-length-max="70" onKeyUp="titleCharsRemainingText(this)" />
								</div>
								<div class="form-group">	
									<div class="ui-form__label-wrapper">
										<label class="col-form-label">{$core->get_Lang('DescriptionPage')}</label>
										<p class="type--subdued">{$core->get_Lang('NumberOfCharactersUsed')}: <span class="description-counter__charactor">0</span>/320</p>
									</div>
									<textarea class="form-control input-bind__counter" clsTable="Voucher" pvalTable="{$pvalTable}" onKeyUp="descriptionCharsRemainingText(this)" rows="4" data-length-max="320"  name="config_value_intro">{if $pvalTable gt '0'}{$clsISO->getPageDescription($pvalTable,'Voucher')}{/if}</textarea>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
			<div class="col-md-4 col-xs-12">
				<div class="ui-layout__item">
					<div class="ui-card">
						<header class="ui-card__header">
							<h2 class="ui-heading">{$core->get_Lang('Status')}</h2>
						</header>
						<div class="ui-card__section">
							<div class="ui-type-container">
								<div class="form-group">
									<div class="custom-radio-wrapper core-radio-custom">
										<label class="">
											<input name="is_online"{if $oneItem.is_online eq '1' || $pvalTable eq '0'} checked="checked"{/if} value="1" type="radio">
											<span class="custom-radio custom-icon"></span>
										</label> {$core->get_Lang('Show')}
									</div>
								</div>
								<div class="form-group">
									<div class="custom-radio-wrapper core-radio-custom">
										<label class="">
											<input name="is_online"{if $oneItem.is_online eq '0'} checked{/if} value="0" type="radio">
											<span class="custom-radio custom-icon"></span>
										</label> {$core->get_Lang('Hide')}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ui-card mt-half">
						<header class="ui-card__header">
							<h2 class="ui-heading">{$core->get_Lang('Type')}</h2>
						</header>
						<div class="ui-card__section">
							<div class="ui-type-container">
								<div class="form-group">
									<label class="col-form-label">{$core->get_Lang('VoucherType')}</label>
									<select name="cat_id" class="form-control iso-selectize required">
										{$clsCategory->makeSelectboxOption(0,'_PRODUCT',$cat_id)}
									</select>
									<div class="help-block">Thêm sản phẩm vào danh mục để nó dễ dàng được tìm kiếm trên website của bạn.</div>
								</div>
								<div class="form-group">
									<label class="col-form-label">{$core->get_Lang('Supplier')}</label>
									<select class="iso-selectize" name="iso-brand_id">
										{$clsSupplier->getOpt($oneItem.brand_id)}
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="ui-card mt-half">
						<header class="ui-card__header">
							<h2 class="ui-heading">{$core->get_Lang('Category')}</h2>
						</header>
						<div class="ui-card__section">
							<div class="ui-type-container">
								<div class="form-group">
									<label class="col-form-label">{$core->get_Lang('Category')}</label>
									<select class="iso-selectize" placeholder="Tìm kiếm danh mục" multiple name="list_type_id[]">
										{$clsCategory->makeSelectboxOptionMultiple(0,'_CATEGORY',$list_type_selected)}
									</select>
									<div class="help-block">Thêm sản phẩm vào danh mục để nó dễ dàng được tìm kiếm trên website của bạn.</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="submit" value="Update" />
	<input type="hidden" name="action" value="{$action}" />
	<input type="hidden" name="pvalTable" value="{$pvalTable}" />
	<div class="ui-page-actions ui-page-actions--has-secondary">
		<div class="ui-page-actions__container">
			<div class="ui-page-actions__actions ui-page-actions__actions--secondary">
				<div class="ui-page-actions__button-group">
					{if $pvalTable gt '0'}
					<a class="btn btn-warning" onClick="delete_globe(this)" clsTable="Voucher" pval_id="{$pvalTable}" pkey="{$pkayTable}" return_url="{$PCMS_URL}/index.php?mod={$mod}{$pUrl}">{$core->get_Lang('Delete')}</a>
					{/if}
				</div>
			</div>
			<div class="ui-page-actions__actions ui-page-actions__actions--primary">
				<div class="ui-page-actions__button-group">
					<a class="btn btn-default" href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Cancel')}</a>
					{$saveBtn} {$saveList}
				</div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	var pvalTable = '{$pvalTable}';
	var $table_id = '{$pvalTable}';
</script>