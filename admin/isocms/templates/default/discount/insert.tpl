 <link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />
 <!-- ================= ADD PROMOTION ================= -->
 <div class="iso-add-promo" id="add-promotion-page">

 	<div class="tm-breadcrumb" aria-label="Breadcrumb">
 		<a href="{$PCMS_URL}"><i class="fa-solid fa-house" style="font-size:12px;"></i>
 			{$core->get_Lang('Dashboard')}</a><span class="sep">›</span>
 		<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Promo Codes')}</a><span class="sep">›</span>
 		<span class="is-current">{$core->get_Lang('Edit Promotion')}</span>
 	</div>

 	<div class="tm-page-header">
 		<div>
 			<h1 class="tm-page-title">{$core->get_Lang('Edit Promotion')} / {$core->get_Lang('Promo Code')}</h1>
 			<p class="tm-page-subtitle">
 				{$core->get_Lang('Edit your promotion to update its details and continue attracting customers')}</p>
 		</div>
 		<div class="tm-header-actions">
 			<button type="button" class="tm-btn tm-btn--outline tm-btn--summary-toggle" data-open-summary><i
 					class="fa-regular fa-eye"></i>{$core->get_Lang('Summary')}</button>
 			<a href="{$PCMS_URL}/index.php?mod={$mod}" class="tm-btn tm-btn--neutral" id="btnCancel"><i
 					class="fa-solid fa-xmark"></i>
 				{$core->get_Lang('Cancel')}</a>
 			<button type="button" class="tm-btn tm-btn--primary" id="btnPublish"
 				onclick="pop_save_discount(this,event)" discount_id="{$oneItem.discount_id}"><i
 					class="fa-regular fa-paper-plane"></i> {$core->get_Lang('Publish Promotion')}</button>
 		</div>
 	</div>

 	<div class="tm-layout">
 		<form class="tm-form-col" id="promoForm" novalidate>
 			<input type="hidden" class="gen" name="iso-discount_rule" value="{$oneItem.discount_rule}" />
 			<!-- 1. PROMOTION INFORMATION -->
 			<section class="tm-section">
 				<div class="tm-section__head"><span class="tm-section__num">1</span>
 					<div>
 						<h2>{$core->get_Lang('Promotion Information')}</h2>
 						<p>{$core->get_Lang('Set the basic details of your promotion.')}</p>
 					</div>
 				</div>
 				<div class="tm-two-col">
 					<div style="display:flex;flex-direction:column;gap:18px;min-width:0;">
 						<div class="tm-field">
 							<label class="tm-label" for="promoName">
 								{$core->get_Lang('Promotion Name')}
 								<span class="req">*</span>
 							</label>
 							<input type="text" id="promoName" name="title" class="tm-input" maxlength="100"
 								value="{$oneItem.title}" required>
 							<div class="tm-counter"><span id="promoNameCount">0</span>/100</div>
 							<p class="tm-error" data-for="promoName"></p>
 						</div>
 						<div class="tm-field">
 							<label class="tm-label" for="promoDescription">{$core->get_Lang('Description')}</label>
 							<textarea id="promoDescription" class="tm-textarea" name="description"
 								maxlength="500">{$oneItem.description}</textarea>
 							<div class="tm-counter"><span id="promoDescCount">0</span>/500</div>
 							<p class="tm-error" data-for="promoDescription"></p>
 						</div>
 					</div>
 					<div style="display:flex;flex-direction:column;gap:18px;min-width:0;">
 						<div class="tm-field">
 							<span class="tm-label">{$core->get_Lang('Promotion Type')}
 								<span class="req">*</span>
 								<i class="fa-regular fa-circle-question tm-tip"
 									title="Promo Code is an activation method. Automatic promotions are evaluated by the promotion engine."></i>
 							</span>
 							<div class="tm-card-grid" role="radiogroup" aria-label="Promotion type">
 								<label class="tm-option">
 									<input type="radio" name="promo_type" value="2" {if $oneItem.type== 2}checked{/if}
 										required>
 									<span><span class="tm-option__title">
 											<i class="fa-solid fa-percent"></i> {$core->get_Lang('Promo Code')}</span>
 										<p class="tm-option__desc">
 											{$core->get_Lang('Customers enter a code to get the discount')}</p>
 									</span></label>
 								<label class="tm-option">
 									<input type="radio" name="promo_type" value="1" {if $oneItem.type== 1}checked{/if}
 										required><span><span class="tm-option__title"><i
 												class="fa-regular fa-calendar-check"></i>
 											{$core->get_Lang('Automatic Promotion')}</span>
 										<p class="tm-option__desc">
 											{$core->get_Lang('Discount is applied automatically (no code required)')}
 										</p>
 									</span>
 								</label>
 							</div>
 						</div>
 						<div class="tm-field is-visible" id="promoCodeField">
 							<label class="tm-label" for="promoCode">{$core->get_Lang('Promo Code')} <span
 									class="req">*</span></label>
 							<div class="tm-code-row">
 								<input type="text" id="promoCode" class="tm-input ipn__discount_code" name="code"
 									maxlength="30" value="{$oneItem.code}" autocomplete="off">
 								<a href="javascript:void(0);" onClick="generateCode()" class="tm-btn tm-btn--outline"
 									id="btnGenerateCode"><i class="fa-solid fa-arrows-rotate"></i>
 									{$core->get_Lang('Generate Code')}</a>
 							</div>
 							<p class="tm-helper">
 								{$core->get_Lang('Unique code for this promotion. Use letters and numbers, no spaces (e.g. SUMMER25).')}
 							</p>
 							<p class="tm-error" data-for="promoCode"></p>
 						</div>
 					</div>
 				</div>
 			</section>

 			<!-- 2. DISCOUNT CONFIGURATION -->
 			<section class="tm-section">
 				<div class="tm-section__head">
 					<span class="tm-section__num">2</span>
 					<div>
 						<h2>{$core->get_Lang('Discount Configuration')}</h2>
 						<p>{$core->get_Lang('Define the discount type, value and limits.')}</p>
 					</div>
 				</div>

 				<div class="tm-field" style="margin-bottom:18px;">
 					<span class="tm-label">
 						{$core->get_Lang('Discount Type')}
 						<span class="req">*</span>
 					</span>
 					<div class="tm-card-grid tm-card-grid--2" role="radiogroup" aria-label="Discount type">
 						<label
 							class="tm-option tm-option--percentage {if $more_information.discount_type == 2}is-selected{/if}">
 							<input type="radio" name="discount_type" value="2"
 								{if $more_information.discount_type == 2}checked{/if}>
 							<span>
 								<span class="tm-option__title">
 									{$core->get_Lang('Percentage (%)')}
 								</span>
 								<p class="tm-option__desc">
 									{$core->get_Lang('Discount by percentage')}
 								</p>
 							</span>
 						</label>

 						<label
 							class="tm-option tm-option--fixed {if $more_information.discount_type == 1}is-selected{/if}">
 							<input type="radio" name="discount_type" value="1"
 								{if $more_information.discount_type == 1}checked{/if}>
 							<span>
 								<span class="tm-option__title">
 									{$core->get_Lang('Fixed Amount')}
 								</span>
 								<p class="tm-option__desc">
 									{$core->get_Lang('Discount by a fixed amount')}
 								</p>
 							</span>
 						</label>

 					</div>
 				</div>

 				<div class="tm-two-col">

 					<!-- Discount Value -->
 					<div class="tm-field discount-field discount-field--percentage">

 						<label class="tm-label" for="discountValue">
 							{$core->get_Lang('Discount Value')}
 							<span class="req">*</span>
 						</label>

 						<div class="tm-input-group">
 							<input type="number" name="discount_value" id="discountValue" class="tm-input" min="0"
 								step="any" value="{$more_information.discount_value}" required>

 							<span class="tm-input-group__suffix"
 								id="discountSuffix">{if $more_information.discount_type == 2}%{else}${/if}</span>
 						</div>

 						<p class="tm-helper" id="discountHelper">
 							{if $more_information.discount_type == 2}{$core->get_Lang('Enter a percentage value (e.g. 20 for 20%).')}{/if}
 							{if $more_information.discount_type == 1}{$core->get_Lang('Enter a fixed amount for the discount.')}{/if}
 						</p>

 						<p class="tm-error" data-for="discountValue"></p>

 					</div>
 					
					<!-- Maximum Discount -->
					<div class="tm-field discount-field discount-field--fixed {if $more_information.discount_type == 2}is-visible{/if}" id="maxDiscountField">

						<label class="tm-label" for="maxDiscount">
							{$core->get_Lang('Maximum Discount')}
							<span class="opt">
								{$core->get_Lang('Optional')}
							</span>
						</label>

						<div class="tm-money-row">

							<input type="number" name="max_discount" id="maxDiscount" class="tm-input" min="0"
								step="any"
								value="{if $more_information.discount_type == 2}{$more_information.max_discount}{/if}">

							<select id="maxDiscountCurrency" class="tm-select" aria-label="Maximum discount currency">
								<option value="USD">$</option>
								{* <option value="VND">₫</option>
								<option value="EUR">€</option> *}
							</select>

						</div>

						<p class="tm-helper">
							{$core->get_Lang('Set a maximum discount amount per booking.')}
						</p>

						<p class="tm-error" data-for="maxDiscount"></p>

					</div>
 					
 				</div>
 			</section>

 			<!-- 3. PRODUCT APPLICABILITY -->
 			<section class="tm-section">
 				<div class="tm-section__head"><span class="tm-section__num">3</span>
 					<div>
 						<h2>{$core->get_Lang('Product Applicability')}</h2>
 						<p>{$core->get_Lang('Choose which products or services this promotion applies to.')}</p>
 					</div>
 				</div>
 				<div class="tm-field" style="margin-bottom:18px;">
 					<div class="tm-card-grid tm-card-grid--3" role="radiogroup" aria-label="Product scope">
 						<label class="tm-option"><input type="radio" name="product_type" value="all"
 								{if $oneItem.product_type eq 'all'}checked{/if}><span><span
 									class="tm-option__title">{$core->get_Lang('All Products')}</span>
 								<p class="tm-option__desc">
 									{$core->get_Lang('Apply to all products of Tour, Hotel, Cruise, Voucher in the system')}
 								</p>
 							</span></label>
 						<label class="tm-option"><input type="radio" name="product_type" value="product"
 								{if $oneItem.product_type eq 'product'}checked{/if}><span><span
 									class="tm-option__title">{$core->get_Lang('Selected Products')}</span>
 								<p class="tm-option__desc">
 									{$core->get_Lang('Choose specific products for this promotion')}</p>
 							</span>
 						</label>
 					</div>
 				</div>
 				<div class="tm-conditional--wrapper">
 					<div class="tm-field" style="max-width:340px;margin-bottom:18px;">
 						<label class="tm-label" for="productType">{$core->get_Lang('Select Product Group')} <span
 								class="req">*</span></label>
 						<div class="tm-select-wrapper">
 							<select id="productType" class="tm-select" name="product_group"
 								discount_id="{$oneItem.discount_id}">
 								{foreach from=$productGroups key=value item=label}
	 								<option value="{$value}" {if $value == "tour"}selected{/if}>
	 									{$label}
	 								</option>
 								{/foreach}
 							</select>
 							<button type="button" class="tm-btn tm-btn--primary" id="btnAddProduct"><i
 									class="fa-solid fa-plus"></i> {$core->get_Lang('Add product')}</button>
 						</div>
 					</div>
 					<div class="tm-conditional is-visible" id="selectedPanel">
 						<div class="tm-selected-head">
 							<strong>{$core->get_Lang('Selected Products')} (<span
 									id="selectedCount">{$total_items}</span>)</strong>
 							<span style="display:flex;gap:16px;">

 								<button type="button" class="tm-link-btn" id="btnClearProducts">Clear all</button>
 							</span>
 						</div>
 						<div class="tm-product-list" id="selectedList">
 							{if !empty($discount_items)}

	 							{foreach from=$discount_items item=item}

		 							<div class="tm-product-item">

		 								{* IMAGE *}
		 								{if $item.type == 'Tour'}
			 								<img src="{$clsISO->tripslashImage($item.data.image, 120, 90)}"
			 									alt="{$item.title|escape:'html'}">

		 								{elseif $item.type == 'Hotel'}
			 								<img src="{$clsISO->tripslashImage($item.data.image, 120, 90)}"
			 									alt="{$item.title|escape:'html'}">

		 								{elseif $item.type == 'Cruise'}
			 								<img src="{$clsISO->tripslashImage($item.data.image, 120, 90)}"
			 									alt="{$item.title|escape:'html'}">

		 								{elseif $item.type == 'Voucher'}
			 								<img src="{$clsISO->tripslashImage($item.data.image, 120, 90)}"
			 									alt="{$item.title|escape:'html'}">
		 								{/if}


		 								<div class="tm-product-item__info">

		 									<div class="tm-product-item__name">
		 										{$item.title|escape:'html'}
		 									</div>

		 									<div class="tm-product-item__meta">
		 										{$item.type}

		 										{if $item.code}
			 										&nbsp;|&nbsp; {$item.code}
		 										{/if}

		 										{if $item.type == 'Tour' && $item.data.destination}
			 										&nbsp;|&nbsp; {$item.data.destination}
		 										{/if}

		 									</div>

		 								</div>


		 								<button type="button" class="tm-icon-btn" data-remove="{$item.item_id}"
		 									data-type="{$item.type}" aria-label="Remove {$item.title|escape:'html'}">
		 									<i class="fa-solid fa-xmark"></i>
		 								</button>

		 							</div>

	 							{/foreach}

 							{/if}

 						</div>

 					</div>
 					<p class="tm-error" data-for="products" style="margin-top:10px;"></p>

 					<div class="tm-picker" id="productPicker">
 						<input type="search" class="tm-input" id="pickerSearch"
 							placeholder="Search products by name or code..." aria-label="Search products"
 							autocomplete="off">

 						<div class="tm-picker__list" id="pickerList">
 							<div class="tm-picker__empty">
 								{$core->get_Lang('Enter product name or code to search')}
 							</div>
 						</div>
 					</div>

 				</div>
 			</section>

 			<!-- 4. VALIDITY & SCHEDULE -->
 			<section class="tm-section">
 				<div class="tm-section__head"><span class="tm-section__num">4</span>
 					<div>
 						<h2>{$core->get_Lang('Validity &amp; Schedule')}</h2>
 						<p>{$core->get_Lang('Set the time period and applicable days.')}</p>
 					</div>
 				</div>
 				{assign var="booking_date_from" value=date('Y-m-d', $oneItem['booking_date_from']) }
 				{assign var="booking_date_to" value=date('Y-m-d', $oneItem['booking_date_to']) }
 				{assign var="travel_date_from" value=date('Y-m-d', $oneItem['travel_date_from']) }
 				{assign var="travel_date_to" value=date('Y-m-d', $oneItem['travel_date_to']) }
 				<div class="tm-two-col">
 					<div class="tm-field">
 						<span class="tm-label">{$core->get_Lang('Booking Period')} <span class="req">*</span></span>
 						<div class="tm-date-range">
 							<input type="date" name="booking_date_from" id="bookingStart" class="tm-input"
 								value="{$booking_date_from}" aria-label="Booking period start" required>
 							<i class="fa-solid fa-arrow-right"></i>
 							<input type="date" name="booking_date_to" id="bookingEnd" class="tm-input"
 								value="{$booking_date_to}" aria-label="Booking period end" required>
 						</div>
 						<p class="tm-helper">
 							{$core->get_Lang('Promotion can be used for bookings made within this period.')}</p>
 						<p class="tm-error" data-for="bookingPeriod"></p>
 					</div>
 					<div class="tm-field">
 						<span class="tm-label">{$core->get_Lang('Service Date')} <span class="req">*</span></span>
 						<div class="tm-date-range">
 							<input type="date" name="travel_date_from" id="serviceStart" class="tm-input"
 								value="{$travel_date_from}" aria-label="Service date start" required>
 							<i class="fa-solid fa-arrow-right"></i>
 							<input type="date" name="travel_date_to" id="serviceEnd" class="tm-input"
 								value="{$travel_date_to}" aria-label="Service date end" required>
 						</div>
 						<p class="tm-helper" id="serviceHelper">
 							{$core->get_Lang('Applicable for travel/stay/sailing/usage date.')}</p>
 						<p class="tm-error" data-for="servicePeriod"></p>
 					</div>
 				</div>
 				<div class="tm-field" style="margin-top:18px;"> <span class="tm-label">
 						{$core->get_Lang('Applicable Days of Week')} <i class="fa-regular fa-circle-question tm-tip"
 							title="{$core->get_Lang('Applied on the Service Date.')}"></i> </span> <!-- All days -->
 					<label class="tm-check"> <input type="checkbox" id="allDays" name="is_alldays"
 							{if $oneItem['is_alldays'] } checked{/if} value="1"> {$core->get_Lang('All days')}
 					</label> <!-- Days -->
 					<div class="tm-days" id="daysRow">
 						{foreach from=$lstDay key=day item=label}
	 						<button type="button"
	 							class="tm-day active {if $clsISO->checkItemInArray($day, $weekdays_arr)}is-on{/if}"
	 							data-day="{$day}">
	 							{$core->get_Lang($label)}
	 							<input type="checkbox" name="weekdays[]" value="{$day}"
	 								{if $clsISO->checkItemInArray($day, $weekdays_arr)}checked {/if} hidden>
	 						</button>
 						{/foreach}
 					</div>
 					<p class="tm-error" data-for="days"></p>
 				</div>
 			</section>

 			<div class="tm-pair">
 				<section class="tm-section">
 					<div class="tm-section__head"><span class="tm-section__num">5</span>
 						<div>
 							<h2>{$core->get_Lang('Discount Application')}</h2>
 							<p>{$core->get_Lang('Choose which parts of the booking the discount applies to.')}</p>
 						</div>
 					</div>

 					<label class="tm-check">
 						<input type="checkbox" id="applyAddons" name="use_addon_service" value="1"
 							{if $more_information.use_addon_service} checked{/if}>
 						{$core->get_Lang('Apply to additional')}
 						{$core->get_Lang('services / add-ons')}
 						<i class="fa-regular fa-circle-question tm-tip"
 							title="e.g. airport transfer, meals, insurance, guide."></i>
 					</label>

 					<label class="tm-check" id="extraBedRow">
 						<input type="checkbox" id="applyExtraBed" name="use_extra_bed" value="1"
 							{if $more_information.use_extra_bed} checked{/if} />
 						{$core->get_Lang('Apply to extra bed (for hotel only)')}
 					</label>
 					<p class="tm-error" data-for="application"></p>
 				</section>
 				<!-- USAGE LIMITS -->
 				<section class="tm-section">
 					<div class="tm-section__head"><span class="tm-section__num">6</span>
 						<div>
 							<h2>{$core->get_Lang('Usage Limits')}</h2>
 							<p>{$core->get_Lang('Set how many times this promotion can be used.')}</p>
 						</div>
 					</div>
 					<div class="tm-card-grid tm-card-grid--2" role="radiogroup" aria-label="Usage limits">
 						<label class="tm-option">
 							<input type="radio" value="0" name="allow_usage_limit"
 								{if $more_information.allow_usage_limit == 0} checked{/if}>
 							<span>
 								<span class="tm-option__title">
 									{$core->get_Lang('No limits')}
 								</span>
 								<p class="tm-option__desc">{$core->get_Lang('Can be used unlimited times')}</p>
 							</span>
 						</label>
 						<label class="tm-option">
 							<input type="radio" value="1" name="allow_usage_limit"
 								{if $more_information.allow_usage_limit == 1} checked{/if}>
 							<span>
 								<span class="tm-option__title">
 									{$core->get_Lang('Total usage limit')}
 								</span>
 								<p class="tm-option__desc">{$core->get_Lang('Maximum number of total uses')}</p>
 							</span>
 						</label>
 					</div>
 					<div class="tm-field {if $more_information.allow_usage_limit == 0}tm-conditional{/if}"
 						id="usageValueField" style="max-width:340px;margin-top:18px;">
 						<label class="tm-label" for="usageValue"
 							id="usageValueLabel">{$core->get_Lang('Maximum total uses')} <span
 								class="req">*</span></label>
 						<input type="number" id="usageValue" class="tm-input" min="1" step="1" name="usage_limit"
 							value="{$more_information.usage_limit}">
 						<p class="tm-error" data-for="usage"></p>
 					</div>
 				</section>
 			</div>
 		</form>

 		<!-- SUMMARY -->
 		<aside class="tm-summary-col" id="summaryCol" aria-label="Promotion summary">
 			<div class="tm-summary">
 				<div class="tm-summary__head">
 					<h3>{$core->get_Lang('Promotion Summary')}</h3>
 					<span style="display:flex;align-items:center;gap:10px;">

 						<button type="button" class="tm-icon-btn tm-summary__sheet-close" data-close-summary
 							aria-label="Close summary"><i class="fa-solid fa-xmark"></i></button>
 					</span>
 				</div>
 				<div id="summaryBody">
 					<div class="tm-summary__title">
 						<div class="tm-summary__badge">
 							<i
 								class="fa-solid {if $more_information.discount_type == 2}fa-percent{else}fa-dollar-sign{/if}"></i>
 						</div>

 						<div>
 							<div class="tm-summary__name">
 								{$oneItem.title}
 							</div>

 							<div class="tm-summary__meta">
 								{if $oneItem.code}
	 								<span class="tm-code-chip">{$oneItem.code}</span>
 								{/if}
 								<span
 									class="tm-status-pill {if $oneItem.is_online == 1}tm-status-pill--active{else}tm-status-pill--inactive{/if}">
 									<i class="fa-solid fa-circle" style="font-size:7px;"></i>
 									{if $oneItem.is_online == 1}{$core->get_Lang('Active')}{else}{$core->get_Lang('Inactive')}{/if}
 								</span>
 							</div>
 						</div>
 					</div>

 					<div class="tm-summary__discount">
 						<strong>
 							{if $more_information.discount_type == 2}
	 							{$more_information.discount_value}%
 							{elseif $more_information.discount_type == 1}
	 							${$more_information.discount_value} {$core->get_Lang('OFF')}
 							{/if}
 						</strong>
 						{if $more_information.discount_type == 2}
	 						{if $more_information.max_discount}
		 						<span>Maximum discount: ${$more_information.max_discount}</span>
	 						{/if}
 						{/if}
 					</div>

 					<div class="tm-summary__list">

 						<div class="tm-summary__row">
 							<div class="tm-summary__icon">
 								<i class="fa-solid fa-suitcase-rolling"></i>
 							</div>

 							<div class="tm-summary__content">
 								<div class="tm-summary__label">
 									<strong>{$core->get_Lang('Applies to')}</strong>
 								</div>

 								<div class="tm-summary__value">
 									{if $oneItem.product_type eq 'all'}
	 									{$core->get_Lang('All products')}
 									{else}
	 									{$core->get_Lang('Selected products')}

 									{/if}
 								</div>
 							</div>
 						</div>

 						<div class="tm-summary__row">
 							<div class="tm-summary__icon">
 								<i class="fa-regular fa-calendar"></i>
 							</div>

 							<div class="tm-summary__content">
 								<div class="tm-summary__label">
 									<strong>{$core->get_Lang('Validity')}</strong>
 								</div>

 								<div class="tm-summary__value">
 									<b>Booking:</b> <br>{$clsISO->convertTimeToText($oneItem.booking_date_from)} –
 									{$clsISO->convertTimeToText($oneItem.booking_date_to)}<br>
 									<b>Service date:</b> <br>{$clsISO->convertTimeToText($oneItem.travel_date_from)} –
 									{$clsISO->convertTimeToText($oneItem.travel_date_to)}<br>
 									<b>
 										{if $more_information.is_alldays == 1}
	 										{$core->get_Lang('All days')}
 										{else}
	 										{$clsISO->formatWeekdays(json_decode($oneItem.weekdays, true))}
 										{/if}
 									</b>
 								</div>
 							</div>
 						</div>

 						<div class="tm-summary__row">
 							<div class="tm-summary__icon">
 								<i class="fa-solid fa-layer-group"></i>
 							</div>

 							<div class="tm-summary__content">
 								<div class="tm-summary__label">
 									<strong>{$core->get_Lang('Usage limits')}</strong>
 								</div>

 								<div class="tm-summary__value">
 									{if $more_information.allow_usage_limit == 0}
	 									{$core->get_Lang('Unlimited')}
 									{else}
	 									{$more_information.usage_limit}
 									{/if}
 								</div>
 							</div>
 						</div>

 					</div>
 				</div>
 			</div>
 		</aside>
 	</div>
 </div>
 <script type="text/javascript" src="{$URL_JS}/sweetalert.js?v={$upd_version}"></script>
 <script type="text/javascript" src="{$URL_JS}/jquery-easyui/jquery.easyui.min.js?v={$upd_version}"></script>
 <script type="text/javascript" src="{$URL_THEMES}/discount/js/jquery.discount.js?v={$upd_version}"></script>
 {literal}
	 <script type="text/javascript">
	 	$(document).ready(function() {

	 		function updateDiscountType(type) {

	 			var $percentageOption = $('.tm-option--percentage');
	 			var $fixedOption = $('.tm-option--fixed');
	 			var $maxDiscountField = $('#maxDiscountField');
	 			var $discountSuffix = $('#discountSuffix');
	 			var $discountHelper = $('#discountHelper');
	 			var $discountValue = $('#discountValue');

	 			// Reset selected
	 			$('.tm-option').removeClass('is-selected');

	 			if (type == '2') {
	 				// Percentage
	 				$percentageOption.addClass('is-selected');

	 				$discountSuffix.text('%');

	 				$discountHelper.text(
	 					'Enter a percentage value (e.g. 20 for 20%).'
	 				);

	 				// Hiện Maximum Discount
	 				$maxDiscountField.show();

	 				// Giới hạn percentage
	 				$discountValue.attr('max', '100');

	 			} else {
	 				// Fixed Amount
	 				$fixedOption.addClass('is-selected');

	 				$discountSuffix.text('$');

	 				$discountHelper.text(
	 					'Enter a fixed amount for the discount.'
	 				);

	 				// Ẩn Maximum Discount
	 				$maxDiscountField.hide();

	 				// Bỏ giới hạn percentage
	 				$discountValue.removeAttr('max');
	 			}
	 		}


	 		// Click vào radio
	 		$(document).on('change', 'input[name="discount_type"]', function() {

	 			var type = $(this).val();

	 			updateDiscountType(type);

	 		});


	 		// Khởi tạo theo giá trị hiện tại
	 		var currentType = $('input[name="discount_type"]:checked').val();

	 		if (currentType) {
	 			updateDiscountType(currentType);
	 		}

	 	});

	 	$(document).on('change', 'input[name="allow_usage_limit"]', function() {
	 		var value = $(this).val();
	 		var $field = $('#usageValueField');
	 		var $input = $('#usageValue');

	 		if (value == '0') {
	 			// No limits
	 			$field.hide().addClass('tm-conditional');

	 			$input
	 				.prop('required', false)
	 				.removeAttr('required')
	 				.removeClass('is-invalid');

	 			$field.find('.tm-error').text('');

	 		} else {
	 			// Total usage limit
	 			$field.show().removeClass('tm-conditional');

	 			$input
	 				.prop('required', true)
	 				.attr('required', 'required');
	 		}
	 	});

	 	/* All Days */
	 	$(document).on('change', '#allDays', function() {

	 		var isAll = $(this).is(':checked');

	 		$('#daysRow .tm-day').each(function() {

	 			var $day = $(this);
	 			var $input = $day.find('input[name="weekdays[]"]');

	 			if (isAll) {

	 				// Chọn tất cả
	 				$input.prop('checked', true);
	 				$day.addClass('is-on').prop('disabled', true);

	 			} else {

	 				// Khi bỏ All Days:
	 				// không tự ý xóa trạng thái is-on
	 				$day.prop('disabled', false);

	 			}
	 		});
	 	});


	 	/* Click từng ngày */
	 	$(document).on('click', '#daysRow .tm-day', function(e) {

	 		// Nếu All Days đang bật thì không cho click
	 		if ($('#allDays').is(':checked')) {
	 			return;
	 		}

	 		var $day = $(this);
	 		var $input = $day.find('input[name="weekdays[]"]');

	 		var isChecked = !$input.is(':checked');

	 		$input.prop('checked', isChecked);
	 		$day.toggleClass('is-on', isChecked);
	 	});


	 	/* Trạng thái ban đầu */
	 	$(function() {

	 		if ($('#allDays').is(':checked')) {

	 			// Chỉ đồng bộ khi All Days thực sự đang checked
	 			$('#daysRow .tm-day').each(function() {

	 				var $day = $(this);
	 				var $input = $day.find('input[name="weekdays[]"]');

	 				$input.prop('checked', true);
	 				$day.addClass('is-on').prop('disabled', true);
	 			});

	 		} else {

	 			// Giữ nguyên is-on do Smarty render
	 			$('#daysRow .tm-day').each(function() {

	 				var $day = $(this);
	 				var $input = $day.find('input[name="weekdays[]"]');

	 				$day.toggleClass('is-on', $input.is(':checked'));
	 				$day.prop('disabled', false);
	 			});
	 		}
	 	});
	 	$(document).ready(function() {

	 		function togglePromoCodeField() {
	 			var type = $('input[name="promo_type"]:checked').val();
	 			var $field = $('#promoCodeField');
	 			var $input = $('#promoCode');

	 			if (type === '2') {
	 				$field.slideDown(200);
	 				$input.prop('required', true);
	 			} else {
	 				$field.slideUp(200);
	 				$input.prop('required', false);
	 			}
	 		}

	 		togglePromoCodeField();

	 		$('input[name="promo_type"]').on('change', togglePromoCodeField);

	 	});




	 	$(document).on('change', 'input[name="product_type"]', function() {
	 		if ($(this).val() === 'all') {
	 			$('.tm-conditional--wrapper').stop(true, true).slideUp(200);
	 		} else {
	 			$('.tm-conditional--wrapper').stop(true, true).slideDown(200);
	 		}
	 	});

	 	$(function() {
	 		if ($('input[name="product_type"]:checked').val() === 'all') {
	 			$('.tm-conditional--wrapper').hide();
	 		}
	 	});
	 	$(document).on('click', '#btnAddProduct', function(e) {
	 		e.preventDefault();

	 		var $picker = $('#productPicker');

	 		$picker.addClass('is-open').show();

	 		setTimeout(function() {
	 			var $search = $picker.find('#pickerSearch');

	 			if ($search.length) {
	 				$('html, body').animate({
	 					scrollTop: $search.offset().top - 100
	 				}, 400);

	 				$search.focus();
	 			}
	 		}, 100);
	 	});
	 	$(function() {

	 		var searchTimer = null;

	 		$('#pickerSearch').on('input', function() {

	 			var $input = $(this);
	 			var keyword = $.trim($input.val());
	 			var productType = $('#productType').val();
	 			var discountId = $('#productType').attr('discount_id');

	 			clearTimeout(searchTimer);

	 			if (!keyword) {
	 				$('#pickerList').html(
	 					'<div class="tm-picker__empty">Enter product name or code to search</div>'
	 				);
	 				return;
	 			}

	 			searchTimer = setTimeout(function() {

	 				$('#pickerList').html(
	 					'<div class="tm-picker__loading">Searching...</div>'
	 				);

	 				$.ajax({
	 					type: 'POST',
	 					url: path_ajax_script + "/?mod=discount&act=ajSearchProducts",
	 					dataType: 'json',
	 					data: {
	 						product_group: productType,
	 						keyword: keyword,
	 						discount_id: discountId
	 					},
	 					success: function(json) {
	 						if (json && json.status === 'success') {
	 							$('#pickerList').html(json.html);
	 						} else {
	 							$('#pickerList').html(
	 								'<div class="tm-picker__empty">No products found</div>'
	 							);
	 						}
	 					},
	 					error: function() {
	 						$('#pickerList').html(
	 							'<div class="tm-picker__empty">Search failed. Please try again.</div>'
	 						);
	 					}
	 				});

	 			}, 300);
	 		});


	 		// Đổi Tour / Hotel / Cruise / Voucher
	 		$('#productType').on('change', function() {

	 			var productType = $(this).val();

	 			$('#pickerSearch').val('');

	 			$('#pickerList').html(
	 				'<div class="tm-picker__empty">' +
	 				'Search ' + productType + ' by name or code' +
	 				'</div>'
	 			);
	 		});


	 		$(document).on('click', '.tm-icon-btn[data-remove]', function(e) {
	 			e.preventDefault();

	 			var $btn = $(this);
	 			var itemId = $btn.data('remove');
	 			var itemType = $btn.data('type');

	 			if (!itemId || !itemType) {
	 				return;
	 			}

	 			if (!confirm('Are you sure you want to delete this item?')) {
	 				return;
	 			}

	 			$.ajax({
	 				type: 'POST',
	 				url: path_ajax_script + "/?mod=discount&act=ajRemoveProduct",
	 				data: {
	 					id: itemId,
	 					type: itemType
	 				},
	 				dataType: 'json',
	 				beforeSend: function() {
	 					$btn.prop('disabled', true);
	 					$btn.addClass('loading');
	 				},
	 				success: function(res) {
	 					if (res && res.status === 'success') {

	 						// Xóa item khỏi giao diện
	 						$btn.closest('.tm-product-item').remove();
	 						updateSelectedCount();

	 						// Nếu cần cập nhật lại summary/count
	 						// updateProductSummary();

	 					} else {
	 						alert(res && res.message ?
	 							res.message :
	 							'Cannot delete this item.');
	 					}
	 				},
	 				error: function() {
	 					alert('An error occurred. Please try again.');
	 				},
	 				complete: function() {
	 					$btn.prop('disabled', false);
	 					$btn.removeClass('loading');
	 				}
	 			});
	 		});



	 	});

	 	$(document).on('click', '.tm-picker__item', function(e) {
	 		e.preventDefault();

	 		var $item = $(this);

	 		var itemId = $item.data('product-id');
	 		var itemTable = $item.data('table');
	 		var itemCode = $item.data('product-code');
	 		var itemName = $item.data('product-name');

	 		var discountId = $('#productType').attr('discount_id');

	 		if (!itemId || !itemTable || !discountId) {
	 			return;
	 		}

	 		// Chống click nhiều lần
	 		if ($item.hasClass('is-loading')) {
	 			return;
	 		}

	 		$item.addClass('is-loading');

	 		$.ajax({
	 			type: 'POST',
	 			url: path_ajax_script + "/?mod=discount&act=ajAddDiscountItem",
	 			data: {
	 				discount_id: discountId,
	 				item_id: itemId,
	 				type: itemTable
	 			},
	 			dataType: 'json',

	 			success: function(res) {

	 				if (res.status === 'success') {

	 					// PHP trả HTML
	 					$('#selectedList').prepend(res.html);

	 					// Xóa item khỏi danh sách search
	 					$item.remove();

	 					// Nếu backend trả HTML thì append vào list ở đây
	 					// $('#discountItemList').prepend(res.html);
	 					updateSelectedCount();

	 				} else if (res.status === 'exists') {

	 					alert('Item này đã được thêm.');

	 				} else {

	 					alert(res.message || 'Không thể thêm item.');
	 				}
	 			},

	 			error: function() {
	 				alert('Có lỗi xảy ra.');
	 			},

	 			complete: function() {
	 				$item.removeClass('is-loading');
	 			}
	 		});
	 	});
	 	$(document).on('click', '#btnClearProducts', function(e) {
	 		e.preventDefault();

	 		var $btn = $(this);

	 		var items = [];

	 		$('#selectedList .tm-product-item').each(function() {

	 			var $item = $(this);

	 			items.push({
	 				id: $item.find('[data-remove]').data('remove'),
	 				type: $item.find('[data-remove]').data('type')
	 			});

	 		});

	 		// Không có sản phẩm
	 		if (!items.length) {
	 			updateSelectedCount();
	 			return;
	 		}

	 		if (!confirm('Are you sure you want to remove all selected products?')) {
	 			return;
	 		}

	 		$btn.prop('disabled', true);

	 		var completed = 0;
	 		var failed = false;

	 		$.each(items, function(index, item) {

	 			$.ajax({
	 				type: 'POST',
	 				url: path_ajax_script + "/?mod=discount&act=ajRemoveProduct",
	 				data: {
	 					id: item.id,
	 					type: item.type
	 				},
	 				dataType: 'json',

	 				success: function(res) {

	 					if (res.status !== 'success') {
	 						failed = true;
	 					}

	 				},

	 				error: function() {
	 					failed = true;
	 				},

	 				complete: function() {

	 					completed++;

	 					if (completed === items.length) {

	 						$btn.prop('disabled', false);

	 						if (!failed) {

	 							// Xóa toàn bộ UI
	 							$('#selectedList').empty();

	 							// Update count
	 							updateSelectedCount();

	 						} else {

	 							alert('Some products could not be removed.');
	 						}
	 					}
	 				}
	 			});

	 		});
	 	});

	 	function updateSelectedCount() {
	 		var count = $('#selectedList .tm-product-item').length;
	 		$('#selectedCount').text(count);
	 	}
	 </script>
 {/literal}
 {literal}
	 <style>
	 	.tm-select-wrapper {
	 		display: flex;
	 		align-items: center;
	 		gap: 8px;
	 	}

	 	.iso-add-promo {
	 		flex: 1;
	 		min-width: 0;
	 		width: 100%;
	 		background: var(--color-page);
	 		padding: 16px clamp(16px, 2vw, 28px) 48px;
	 		display: flex;
	 		flex-direction: column;
	 		gap: 16px;
	 	}

	 	.iso-add-promo * {
	 		box-sizing: border-box;
	 	}

	 	.iso-add-promo button {
	 		cursor: pointer;
	 	}

	 	.iso-add-promo a {
	 		text-decoration: none;
	 	}

	 	.tm-btn {
	 		display: inline-flex;
	 		align-items: center;
	 		justify-content: center;
	 		gap: 8px;
	 		height: 44px;
	 		padding: 0 18px;
	 		border-radius: var(--border-radius-md);
	 		font-size: 14px;
	 		font-weight: 700;
	 		border: 1px solid transparent;
	 		white-space: nowrap;
	 		transition: background 160ms ease, border-color 160ms ease, transform 160ms ease;
	 	}

	 	.tm-btn i {
	 		font-size: 14px;
	 	}

	 	.tm-btn:active {
	 		transform: translateY(1px);
	 	}

	 	.tm-btn--neutral {
	 		background: var(--color-surface);
	 		border-color: var(--color-border);
	 		color: var(--color-text);
	 	}

	 	.tm-btn--neutral:hover {
	 		background: var(--color-page);
	 	}

	 	.tm-btn--outline {
	 		background: var(--color-surface);
	 		border-color: var(--color-primary);
	 		color: var(--color-primary);
	 	}

	 	.tm-btn--outline:hover {
	 		background: var(--color-primary-soft);
	 	}

	 	.tm-btn--primary {
	 		background: var(--color-primary);
	 		color: #fff;
	 	}

	 	.tm-btn--primary:hover {
	 		background: var(--color-primary);
	 	}

	 	.tm-btn[disabled] {
	 		opacity: .65;
	 		cursor: not-allowed;
	 	}

	 	/* breadcrumb + header */
	 	.tm-breadcrumb {
	 		display: flex;
	 		align-items: center;
	 		gap: 8px;
	 		font-size: 13px;
	 		color: var(--color-muted);
	 		flex-wrap: wrap;
	 	}

	 	.tm-breadcrumb a {
	 		color: var(--color-muted);
	 	}

	 	.tm-breadcrumb a:hover {
	 		color: var(--color-primary);
	 	}

	 	.tm-breadcrumb .sep {
	 		color: #C8D3E6;
	 	}

	 	.tm-breadcrumb .is-current {
	 		color: var(--color-text);
	 		font-weight: 700;
	 	}

	 	.tm-page-header {
	 		display: flex;
	 		align-items: flex-start;
	 		justify-content: space-between;
	 		gap: 16px;
	 		flex-wrap: wrap;
	 	}

	 	.tm-page-title {
	 		font-size: var(--type-page-title);
	 		font-weight: 800;
	 		line-height: 1.2;
	 		color: var(--color-text);
	 		letter-spacing: -0.02em;
	 	}

	 	.tm-page-subtitle {
	 		margin: 4px 0 0;
	 		font-size: 14px;
	 		color: var(--color-muted);
	 	}

	 	.tm-header-actions {
	 		display: flex;
	 		align-items: center;
	 		gap: 10px;
	 		flex-wrap: wrap;
	 	}

	 	.tm-btn--summary-toggle {
	 		display: none;
	 	}

	 	/* layout */
	 	.tm-layout {
	 		display: flex;
	 		align-items: flex-start;
	 		gap: 20px;
	 	}

	 	.tm-form-col {
	 		flex: 1;
	 		min-width: 0;
	 		display: flex;
	 		flex-direction: column;
	 		gap: 16px;
	 	}

	 	.tm-summary-col {
	 		width: 340px;
	 		flex-shrink: 0;
	 		position: sticky;
	 		top: 76px;
	 		max-height: calc(100vh - 96px);
	 		overflow-y: auto;
	 	}

	 	/* section card */
	 	.tm-section {
	 		background: var(--color-surface);
	 		border: 1px solid var(--color-border);
	 		border-radius: var(--border-radius-md);
	 		box-shadow: var(--box-shadow);
	 		padding: 22px clamp(16px, 2vw, 26px) 24px;
	 	}

	 	.tm-section__head {
	 		display: flex;
	 		align-items: flex-start;
	 		gap: 14px;
	 		margin-bottom: 20px;
	 	}

	 	.tm-section__num {
	 		width: 34px;
	 		height: 34px;
	 		border-radius: 999px;
	 		background: var(--color-primary-soft);
	 		color: var(--color-primary);
	 		display: flex;
	 		align-items: center;
	 		justify-content: center;
	 		font-size: 16px;
	 		font-weight: 800;
	 		flex-shrink: 0;
	 	}

	 	.tm-section__head h2 {
	 		margin: 0;
	 		font-size: 17px;
	 		font-weight: 800;
	 		color: var(--color-primary);
	 	}

	 	.tm-section__head p {
	 		margin: 3px 0 0;
	 		font-size: 13px;
	 		color: var(--color-muted);
	 	}

	 	.tm-two-col {
	 		display: grid;
	 		grid-template-columns: 1fr 1fr;
	 		gap: 18px;
	 	}

	 	.tm-pair {
	 		display: grid;
	 		grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
	 		gap: 24px;
	 	}

	 	.tm-pair>.tm-section {
	 		height: 100%;
	 	}

	 	/* fields (Form UX Standard) */
	 	.tm-field {
	 		display: flex;
	 		flex-direction: column;
	 		gap: 8px;
	 		min-width: 0;
	 	}

	 	.tm-label {
	 		font-size: 14px;
	 		font-weight: 700;
	 		color: var(--color-text);
	 		display: flex;
	 		align-items: center;
	 		gap: 8px;
	 		flex-wrap: wrap;
	 	}

	 	.tm-label .req {
	 		color: var(--color-danger);
	 	}

	 	.tm-label .opt {
	 		font-size: 11px;
	 		font-weight: 600;
	 		color: var(--color-muted);
	 		background: var(--color-primary-soft);
	 		padding: 2px 8px;
	 		border-radius: 999px;
	 	}

	 	.tm-input,
	 	.tm-select,
	 	.tm-textarea {
	 		width: 100%;
	 		min-height: 44px;
	 		padding: 8px 12px;
	 		color: var(--color-text);
	 		background: var(--color-bg);
	 		border: 1px solid var(--color-border);
	 		border-radius: 4px;
	 		font-family: inherit;
	 		font-size: 16px;
	 	}

	 	.tm-textarea {
	 		min-height: 110px;
	 		resize: vertical;
	 		line-height: 1.5;
	 	}

	 	.tm-input:focus,
	 	.tm-select:focus,
	 	.tm-textarea:focus {
	 		outline: none;
	 		border-color: var(--color-primary);
	 		box-shadow: 0 0 0 3px rgba(31, 95, 216, 0.14);
	 	}

	 	.tm-input.has-error,
	 	.tm-select.has-error,
	 	.tm-textarea.has-error {
	 		border-color: var(--color-danger);
	 	}

	 	.tm-select {
	 		appearance: none;
	 		-webkit-appearance: none;
	 		padding-right: 36px;
	 		background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'><path d='M1 1l5 5 5-5' fill='none' stroke='%2394A3B8' stroke-width='2' stroke-linecap='round'/></svg>");
	 		background-repeat: no-repeat;
	 		background-position: right 12px center;
	 	}

	 	.tm-helper {
	 		margin: 0;
	 		font-size: 12px;
	 		color: var(--color-muted);
	 		line-height: 1.5;
	 	}

	 	.tm-error {
	 		margin: 0;
	 		font-size: 12px;
	 		color: var(--color-danger);
	 		font-weight: 600;
	 		display: none;
	 	}

	 	.tm-error.is-visible {
	 		display: block;
	 	}

	 	.tm-counter {
	 		font-size: 12px;
	 		color: var(--color-text-muted);
	 		text-align: right;
	 	}

	 	.tm-input-group {
	 		display: flex;
	 		align-items: stretch;
	 	}

	 	.tm-input-group .tm-input {
	 		border-radius: 4px 0 0 4px;
	 		flex: 1;
	 		min-width: 0;
	 	}

	 	.tm-input-group__suffix {
	 		display: flex;
	 		align-items: center;
	 		justify-content: center;
	 		min-width: 52px;
	 		padding: 0 12px;
	 		background: #F3F6FB;
	 		color: var(--color-muted);
	 		font-weight: 700;
	 		border: 1px solid var(--color-border);
	 		border-left: none;
	 		border-radius: 0 4px 4px 0;
	 	}

	 	.tm-input-group .tm-select {
	 		border-radius: 0 4px 4px 0;
	 		width: 96px;
	 		flex: none;
	 	}

	 	.tm-money-row {
	 		display: flex;
	 		gap: 8px;
	 	}

	 	.tm-money-row .tm-input {
	 		flex: 1;
	 	}

	 	.tm-money-row .tm-select {
	 		width: 96px;
	 		flex: none;
	 	}

	 	/* selectable cards */
	 	.tm-card-grid {
	 		display: grid;
	 		gap: 12px;
	 	}

	 	.tm-card-grid--2 {
	 		grid-template-columns: repeat(2, minmax(0, 1fr));
	 	}

	 	.tm-card-grid--3 {
	 		grid-template-columns: repeat(3, minmax(0, 1fr));
	 	}

	 	.tm-card-grid--4 {
	 		grid-template-columns: repeat(4, minmax(0, 1fr));
	 	}

	 	.tm-option {
	 		position: relative;
	 		display: flex;
	 		align-items: flex-start;
	 		gap: 12px;
	 		min-height: 64px;
	 		padding: 14px;
	 		border: 1px solid var(--color-border);
	 		border-radius: var(--border-radius-md);
	 		background: var(--color-surface);
	 		cursor: pointer;
	 		transition: border-color 150ms ease, background 150ms ease;
	 	}

	 	.tm-option:hover {
	 		border-color: #9DB9F0;
	 	}

	 	.tm-option input[type="radio"] {
	 		appearance: none;
	 		-webkit-appearance: none;
	 		width: 20px;
	 		height: 20px;
	 		border-radius: 999px;
	 		border: 2px solid #B8C3D9;
	 		background: #fff;
	 		flex-shrink: 0;
	 		margin: 2px 0 0;
	 		cursor: pointer;
	 		position: relative;
	 	}

	 	.tm-option input[type="radio"]:checked {
	 		border-color: var(--color-primary);
	 	}

	 	.tm-option input[type="radio"]:checked::after {
	 		content: "";
	 		position: absolute;
	 		inset: 3px;
	 		border-radius: 999px;
	 		background: var(--color-primary);
	 	}

	 	.tm-option.is-selected {
	 		border-color: var(--color-primary);
	 		background: var(--color-primary-soft);
	 	}

	 	.tm-option__title {
	 		font-size: 14px;
	 		font-weight: 700;
	 		color: var(--color-text);
	 		display: flex;
	 		align-items: center;
	 		gap: 8px;
	 	}

	 	.tm-option__title i {
	 		color: var(--color-primary);
	 	}

	 	.tm-option__desc {
	 		margin: 2px 0 0;
	 		font-size: 12.5px;
	 		color: var(--color-muted);
	 		line-height: 1.45;
	 	}

	 	.tm-field.is-selected .tm-input {
	 		border-color: var(--color-primary);
	 		background: var(--color-primary-soft);
	 	}

	 	/* generate code row */
	 	.tm-code-row {
	 		display: flex;
	 		gap: 10px;
	 	}

	 	.tm-code-row .tm-input {
	 		flex: 1;
	 		text-transform: uppercase;
	 		font-weight: 700;
	 		letter-spacing: .5px;
	 	}

	 	.tm-conditional {
	 		display: none;
	 	}

	 	.tm-conditional.is-visible {
	 		display: block;
	 	}

	 	.tm-conditional.is-visible.tm-flex {
	 		display: flex;
	 	}

	 	/* product selector */
	 	.tm-selected-head {
	 		display: flex;
	 		align-items: center;
	 		justify-content: space-between;
	 		gap: 10px;
	 		margin: 20px 0 10px;
	 	}

	 	.tm-selected-head strong {
	 		font-size: 14px;
	 	}

	 	.tm-link-btn {
	 		border: none;
	 		background: none;
	 		color: var(--color-primary);
	 		font-weight: 700;
	 		font-size: 13px;
	 		padding: 4px 0;
	 	}

	 	.tm-link-btn:hover {
	 		color: var(--color-primary);
	 		text-decoration: underline;
	 	}

	 	.tm-product-list {
	 		display: flex;
	 		flex-direction: column;
	 		gap: 8px;
	 	}

	 	.tm-product-item {
	 		display: flex;
	 		align-items: center;
	 		gap: 12px;
	 		border: 1px solid var(--color-border);
	 		border-radius: var(--border-radius-md);
	 		padding: 8px 12px 8px 8px;
	 		background: var(--color-surface);
	 	}

	 	.tm-product-item img {
	 		width: 56px;
	 		height: 44px;
	 		object-fit: cover;
	 		border-radius: 6px;
	 		flex-shrink: 0;
	 		background: var(--color-border);
	 	}

	 	.tm-product-item__info {
	 		flex: 1;
	 		min-width: 0;
	 	}

	 	.tm-product-item__name {
	 		font-size: 13.5px;
	 		font-weight: 700;
	 		color: var(--color-text);
	 		overflow: hidden;
	 		text-overflow: ellipsis;
	 		white-space: nowrap;
	 	}

	 	.tm-product-item__meta {
	 		font-size: 12px;
	 		color: var(--color-muted);
	 	}

	 	.tm-icon-btn {
	 		width: 40px;
	 		height: 40px;
	 		border: none;
	 		background: transparent;
	 		color: var(--color-primary);
	 		border-radius: var(--border-radius-md);
	 		font-size: 15px;
	 		display: flex;
	 		align-items: center;
	 		justify-content: center;
	 		flex-shrink: 0;
	 	}

	 	.tm-icon-btn:hover {
	 		background: var(--color-primary-soft);
	 	}

	 	.tm-empty {
	 		border: 1px dashed var(--color-border);
	 		border-radius: var(--border-radius-md);
	 		padding: 22px;
	 		text-align: center;
	 		color: var(--color-muted);
	 		font-size: 13px;
	 	}

	 	.tm-picker {
	 		border: 1px solid var(--color-border);
	 		border-radius: var(--border-radius-md);
	 		margin-top: 10px;
	 		padding: 12px;
	 		background: #FBFCFE;
	 		display: none;
	 	}

	 	.tm-picker.is-open {
	 		display: block;
	 	}

	 	.tm-picker__list {
	 		margin-top: 10px;
	 		display: flex;
	 		flex-direction: column;
	 		gap: 4px;
	 		max-height: 220px;
	 		overflow-y: auto;
	 	}

	 	.tm-picker__item {
	 		display: flex;
	 		align-items: center;
	 		gap: 10px;
	 		padding: 8px;
	 		border: none;
	 		background: transparent;
	 		border-radius: 6px;
	 		text-align: left;
	 		width: 100%;
	 		font-size: 13px;
	 		color: var(--color-text);
	 	}

	 	.tm-picker__item:hover {
	 		background: var(--color-primary-soft);
	 	}

	 	.tm-picker__item img {
	 		width: 44px;
	 		height: 34px;
	 		object-fit: cover;
	 		border-radius: 4px;
	 	}

	 	.tm-group-filters {
	 		display: grid;
	 		grid-template-columns: repeat(3, minmax(0, 1fr));
	 		gap: 14px;
	 		margin-top: 18px;
	 	}

	 	/* dates */
	 	.tm-date-range {
	 		display: flex;
	 		align-items: center;
	 		gap: 8px;
	 	}

	 	.tm-date-range .tm-input {
	 		flex: 1;
	 		min-width: 0;
	 		padding: 8px 10px;
	 		font-size: 15px;
	 	}

	 	.tm-date-range i {
	 		color: var(--color-text-muted);
	 		font-size: 12px;
	 	}

	 	.tm-days {
	 		display: flex;
	 		gap: 8px;
	 		flex-wrap: wrap;
	 		margin-top: 8px;
	 	}

	 	.tm-day {
	 		width: 44px;
	 		height: 40px;
	 		border-radius: var(--border-radius-md);
	 		border: 1px solid var(--color-border);
	 		background: var(--color-surface);
	 		font-size: 12.5px;
	 		font-weight: 700;
	 		color: var(--color-muted);
	 	}

	 	.tm-day.is-on {
	 		background: var(--color-primary-soft);
	 		border-color: var(--color-primary);
	 		color: var(--color-primary);
	 	}

	 	.tm-day[disabled] {
	 		opacity: .45;
	 		cursor: not-allowed;
	 	}

	 	.tm-check {
	 		display: flex;
	 		align-items: center;
	 		gap: 10px;
	 		min-height: 44px;
	 		font-size: 14px;
	 		color: var(--color-text);
	 		cursor: pointer;
	 	}

	 	.tm-check input[type="checkbox"] {
	 		width: 20px;
	 		height: 20px;
	 		accent-color: var(--color-primary);
	 		flex-shrink: 0;
	 		margin: 0;
	 	}

	 	.tm-check[hidden],
	 	.tm-hidden {
	 		display: none !important;
	 	}

	 	.tm-tip {
	 		color: var(--color-text-muted);
	 		font-size: 13px;
	 		cursor: help;
	 	}

	 	/* chips/segments */
	 	.tm-chip-row {
	 		display: flex;
	 		flex-wrap: wrap;
	 		gap: 8px;
	 		margin-top: 12px;
	 	}

	 	.tm-chip {
	 		display: inline-flex;
	 		align-items: center;
	 		gap: 8px;
	 		min-height: 36px;
	 		padding: 0 12px;
	 		border: 1px solid var(--color-border);
	 		border-radius: 999px;
	 		font-size: 13px;
	 		background: var(--color-surface);
	 	}

	 	.tm-chip.is-on {
	 		background: var(--color-primary-soft);
	 		border-color: var(--color-primary);
	 		color: var(--color-primary);
	 		font-weight: 700;
	 	}

	 	.tm-chip button {
	 		border: none;
	 		background: none;
	 		color: inherit;
	 		padding: 0;
	 		font-size: 12px;
	 	}

	 	/* channels */
	 	.tm-channel-row {
	 		display: flex;
	 		flex-wrap: wrap;
	 		gap: 4px 22px;
	 		align-items: center;
	 	}

	 	/* summary */
	 	.tm-summary {
	 		background: var(--color-surface);
	 		border: 1px solid var(--color-border);
	 		border-radius: var(--border-radius-md);
	 		box-shadow: var(--box-shadow);
	 		padding: 20px;
	 	}

	 	.tm-summary__head {
	 		display: flex;
	 		align-items: center;
	 		justify-content: space-between;
	 		margin-bottom: 16px;
	 	}

	 	.tm-summary__head h3 {
	 		margin: 0;
	 		font-size: 16px;
	 		font-weight: 800;
	 		color: var(--color-primary);
	 	}

	 	.tm-summary__title {
	 		display: flex;
	 		gap: 14px;
	 		align-items: center;
	 	}

	 	.tm-summary__badge {
	 		width: 58px;
	 		height: 58px;
	 		border-radius: 12px;
	 		background: var(--color-success-soft);
	 		color: var(--color-success);
	 		display: flex;
	 		align-items: center;
	 		justify-content: center;
	 		font-size: 26px;
	 		flex-shrink: 0;
	 	}

	 	.tm-summary__name {
	 		font-size: 18px;
	 		font-weight: 800;
	 		color: var(--color-primary);
	 		line-height: 1.25;
	 		word-break: break-word;
	 	}

	 	.tm-summary__meta {
	 		display: flex;
	 		align-items: center;
	 		gap: 8px;
	 		margin-top: 6px;
	 		flex-wrap: wrap;
	 	}

	 	.tm-code-chip {
	 		background: var(--color-primary-soft);
	 		color: var(--color-primary);
	 		font-weight: 800;
	 		font-size: 12px;
	 		padding: 4px 10px;
	 		border-radius: 6px;
	 		letter-spacing: .4px;
	 	}

	 	.tm-status-pill {
	 		display: inline-flex;
	 		align-items: center;
	 		gap: 6px;
	 		font-size: 12px;
	 		font-weight: 700;
	 		padding: 4px 10px;
	 		border-radius: 999px;
	 	}

	 	.tm-status-pill--active {
	 		background: var(--color-success-soft);
	 		color: var(--color-success);
	 	}

	 	.tm-status-pill--scheduled {
	 		background: var(--color-warning-soft);
	 		color: #B45309;
	 	}

	 	.tm-status-pill--inactive {
	 		background: #EEF2F7;
	 		color: var(--color-muted);
	 	}

	 	.tm-summary__discount {
	 		display: flex;
	 		align-items: baseline;
	 		gap: 10px;
	 		flex-wrap: wrap;
	 		margin: 18px 0 6px;
	 	}

	 	.tm-summary__discount strong {
	 		font-size: 22px;
	 		font-weight: 800;
	 		color: var(--color-danger);
	 	}

	 	.tm-summary__discount span {
	 		font-size: 13px;
	 		color: var(--color-muted);
	 	}

	 	.tm-summary__list {
	 		display: flex;
	 		flex-direction: column;
	 	}

	 	.tm-summary__row {
	 		display: flex;
	 		gap: 14px;
	 		padding: 14px 0;
	 		border-top: 1px solid var(--color-border);
	 	}

	 	.tm-summary__row i {
	 		width: 26px;
	 		text-align: center;
	 		color: var(--color-primary);
	 		font-size: 20px;
	 		margin-top: 2px;
	 		flex-shrink: 0;
	 	}

	 	.tm-summary__row strong {
	 		display: block;
	 		font-size: 14px;
	 		font-weight: 800;
	 		color: var(--color-primary);
	 		margin-bottom: 3px;
	 	}

	 	.tm-summary__row div {
	 		font-size: 13px;
	 		color: var(--color-muted);
	 		line-height: 1.6;
	 		min-width: 0;
	 		word-break: break-word;
	 	}

	 	.tm-summary__thumbs {
	 		display: flex;
	 		gap: 6px;
	 		margin-top: 8px;
	 	}

	 	.tm-summary__thumbs img,
	 	.tm-summary__thumbs span {
	 		width: 36px;
	 		height: 36px;
	 		border-radius: 6px;
	 		object-fit: cover;
	 	}

	 	.tm-summary__thumbs span {
	 		background: var(--color-primary-soft);
	 		color: var(--color-primary);
	 		font-size: 12px;
	 		font-weight: 800;
	 		display: flex;
	 		align-items: center;
	 		justify-content: center;
	 	}

	 	.tm-summary__sheet-close {
	 		display: none;
	 	}

	 	/* toast + bottom bar */
	 	.tm-toast {
	 		position: fixed;
	 		top: 76px;
	 		right: 24px;
	 		z-index: 300;
	 		display: flex;
	 		align-items: center;
	 		gap: 10px;
	 		background: var(--color-primary);
	 		color: #fff;
	 		padding: 14px 18px;
	 		border-radius: 10px;
	 		font-size: 14px;
	 		font-weight: 600;
	 		box-shadow: 0 10px 30px rgba(15, 42, 85, 0.3);
	 		transform: translateY(-12px);
	 		opacity: 0;
	 		pointer-events: none;
	 		transition: transform 200ms ease, opacity 200ms ease;
	 		max-width: calc(100vw - 32px);
	 	}

	 	.tm-toast.is-visible {
	 		transform: translateY(0);
	 		opacity: 1;
	 	}

	 	.tm-toast i {
	 		color: #4ADE80;
	 	}

	 	.tm-toast.is-error i {
	 		color: #FCA5A5;
	 	}

	 	.tm-mobile-bar {
	 		display: none;
	 	}

	 	.tm-sheet-backdrop {
	 		display: none;
	 		position: fixed;
	 		inset: 0;
	 		background: rgba(15, 42, 85, .45);
	 		z-index: 150;
	 	}

	 	/* =========================================================
   RESPONSIVE
   ========================================================= */
	 	@media (max-width: 1439px) {
	 		.tm-summary-col {
	 			width: 300px;
	 		}
	 	}

	 	@media (max-width: 1199px) {
	 		.tm-summary-col {
	 			position: fixed;
	 			z-index: 160;
	 			left: 0;
	 			right: 0;
	 			bottom: 0;
	 			width: 100%;
	 			max-height: 82dvh;
	 			border-radius: 16px 16px 0 0;
	 			transform: translateY(105%);
	 			transition: transform 240ms ease;
	 			box-shadow: 0 -10px 40px rgba(15, 42, 85, 0.25);
	 			background: var(--color-surface);
	 		}

	 		.tm-summary-col.is-open {
	 			transform: translateY(0);
	 		}

	 		.tm-summary {
	 			border: none;
	 			box-shadow: none;
	 		}

	 		.tm-sheet-backdrop.is-open {
	 			display: block;
	 		}

	 		.tm-btn--summary-toggle {
	 			display: inline-flex;
	 		}

	 		.tm-summary__sheet-close {
	 			display: inline-flex;
	 		}
	 	}

	 	@media (max-width: 1024px) {
	 		.demo-sidebar {
	 			position: fixed;
	 			left: 0;
	 			top: 60px;
	 			transform: translateX(-100%);
	 			transition: transform 220ms ease;
	 			box-shadow: 6px 0 20px rgba(15, 42, 85, 0.15);
	 		}

	 		.demo-sidebar.is-open {
	 			transform: translateX(0);
	 		}

	 		.demo-hamburger {
	 			display: inline-flex;
	 		}

	 		.demo-topbar__menu-icon {
	 			display: none;
	 		}

	 		.demo-shell {
	 			display: block;
	 		}

	 		.tm-card-grid--4 {
	 			grid-template-columns: repeat(2, minmax(0, 1fr));
	 		}

	 		.tm-pair {
	 			grid-template-columns: 1fr;
	 		}
	 	}

	 	@media (max-width: 900px) {
	 		.demo-topbar__search {
	 			order: 4;
	 			flex: 1 1 100%;
	 		}

	 		.demo-topbar {
	 			flex-wrap: wrap;
	 			height: auto;
	 			padding: 10px 16px;
	 			row-gap: 8px;
	 		}

	 		.tm-daterange span {
	 			display: none;
	 		}

	 		.tm-card-grid--3 {
	 			grid-template-columns: 1fr;
	 		}

	 		.tm-group-filters {
	 			grid-template-columns: 1fr;
	 		}
	 	}

	 	@media (max-width: 767px) {
	 		.iso-add-promo {
	 			padding: 14px 12px 110px;
	 			gap: 14px;
	 		}

	 		.tm-header-actions {
	 			display: none;
	 		}

	 		.tm-two-col {
	 			grid-template-columns: 1fr;
	 		}

	 		.tm-card-grid--2,
	 		.tm-card-grid--4 {
	 			grid-template-columns: 1fr;
	 		}

	 		.tm-date-range {
	 			flex-direction: column;
	 			align-items: stretch;
	 		}

	 		.tm-date-range i {
	 			display: none;
	 		}

	 		.tm-code-row {
	 			flex-direction: column;
	 		}

	 		.tm-section {
	 			padding: 18px 14px;
	 		}

	 		.tm-mobile-bar {
	 			display: grid;
	 			grid-template-columns: auto 1fr 1fr;
	 			gap: 8px;
	 			position: fixed;
	 			left: 0;
	 			right: 0;
	 			bottom: 0;
	 			z-index: 140;
	 			background: var(--color-surface);
	 			border-top: 1px solid var(--color-border);
	 			padding: 10px 12px calc(10px + env(safe-area-inset-bottom));
	 		}

	 		.tm-mobile-bar .tm-btn {
	 			height: 48px;
	 			padding: 0 12px;
	 		}

	 		.tm-toast {
	 			left: 16px;
	 			right: 16px;
	 			top: 72px;
	 		}
	 	}
	 </style>
{/literal}