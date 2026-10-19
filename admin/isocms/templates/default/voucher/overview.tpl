<link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />
<!-- ================= VIEW VOUCHER ================= -->
<div class="iso-voucher-view" id="voucher-view-page" data-voucher-id="FLC-2026-001">

	<!-- BREADCRUMB + TOP ACTIONS -->
	<div class="tm-topbar-row">
		<nav class="tm-breadcrumb" aria-label="Breadcrumb">
			<a href="{$PCMS}/admin"><i class="fa-solid fa-chevron-left"></i>{$core->get_Lang('Inventory')}</a>
			<span class="sep">›</span>
			<a href="{$PCMS}/admin/?mod=voucher">{$core->get_Lang('Vouchers')}</a>
			<span class="sep">›</span>
			<span class="is-current">{$clsClassTable->getTitle($pvalTable)}</span>
		</nav>
		<div class="tm-top-actions">
			<a href="{$PCMS}/admin/?mod=voucher" class="v2-btn tm-btn--neutral" id="btnBackToList"><i
					class="fa-solid fa-arrow-left"></i> {$core->get_Lang('Back to list')}</a>
			<a href="{$PCMS}/admin/voucher/insert/{$pvalTable}/overview/generalinformation"
				class="v2-btn tm-btn--neutral" id="btnEditVoucher"><i class="fa-regular fa-pen-to-square"></i>
				{$core->get_Lang('Edit')}</a>
			<button type="button" class="v2-btn tm-btn--primary js-open-lightbox" id="btnImportMoreCodes"
				data-lightbox="lightbox_import_voucher">
				<i class="fa-solid fa-arrow-up-from-bracket"></i>
				{$core->get_Lang('Import more codes')}
			</button>
			<button type="button" class="v2-btn tm-btn--icon" id="btnMoreVoucherOptions"
				aria-label="More voucher options"><i class="fa-solid fa-ellipsis-vertical"></i></button>
		</div>
	</div>

	<div class="tm-view-layout">

		<!-- MAIN COLUMN -->
		<div class="tm-main-col">

			<!-- VOUCHER HEADER: gallery + info -->
			<section class="tm-card">
				<div class="tm-voucher-header">
					<div class="tm-gallery">
						<div class="swiper" id="voucherGallery">
							<div class="swiper-wrapper">
								{if !empty($clsClassTable->getImage($pvalTable))}
									<div class="swiper-slide">
										<img src="{$clsClassTable->getImage($pvalTable)}"
											alt="{$clsClassTable->getTitle($pvalTable)}">
									</div>
								{/if}
								{foreach from=$voucherGallery item=image}
									<div class="swiper-slide">
										<img src="{$image.image}" alt="{$clsClassTable->getTitle($pvalTable)}">
									</div>
								{/foreach}
							</div>

							{if $totalImage > 1}
								<div class="tm-gallery__nav swiper-button-prev">
									<i class="fa-solid fa-chevron-left"></i>
								</div>
								<div class="tm-gallery__nav swiper-button-next">
									<i class="fa-solid fa-chevron-right"></i>
								</div>
							{/if}

							{if $totalImage}
								<span class="tm-gallery__counter" id="galleryCounter">
									1 / {$totalImage}
								</span>
							{/if}

							<a href="{$PCMS}/admin/voucher/insert/{$pvalTable}/overview/photoGallery/photoGallery"
								class="tm-gallery__btn" id="btnOpenGallery">
								<i class="fa-regular fa-image"></i>
								{$core->get_Lang('Gallery')}
							</a>
						</div>
					</div>

					<div class="tm-voucher-info">
						<div class="tm-voucher-info__eyebrow"><i class="fa-solid fa-chevron-down"></i>
							{$core->get_Lang('Voucher')}</div>
						<div class="tm-voucher-title-row">
							<h1>
								{$clsClassTable->getTitle($pvalTable)}
								{if $clsClassTable->getLabel($pvalTable) != 'None'}
									<span class="tm-voucher-badge">{$clsClassTable->getLabel($pvalTable)|default:''}</span>
								{/if}
							</h1>

						</div>
						<p class="tm-voucher-desc">{$clsISO->truncateText($clsClassTable->getIntro($pvalTable), 30)}</p>

						<div class="tm-voucher-meta-row">
							<div class="tm-voucher-meta-item">
								<span class="tm-voucher-meta-icon tm-voucher-meta-icon--supplier" aria-hidden="true"><i
										class="fa-solid fa-people-roof"></i></span>
								<span class="tm-voucher-meta-text">
									{assign var="supplier" value=$clsClassTable->getSupplier($oneItem.supplier_id, "supply_name")}
									<strong>{$supplier.supply_name|default:''}</strong>
									<span>{$core->get_Lang('Supplier')}</span></span>
							</div>
							<div class="tm-voucher-meta-item">
								<span class="tm-voucher-meta-icon tm-voucher-meta-icon--category" aria-hidden="true"><i
										class="fa-solid fa-bed"></i></span>
								<span
									class="tm-voucher-meta-text"><strong>{$clsVochercat->getTitle($oneItem.cat_id)|default:''}</strong><span>{$core->get_Lang('Category')}</span></span>
							</div>
							{* <div class="tm-voucher-meta-item">
								<span class="tm-voucher-meta-icon tm-voucher-meta-icon--validity" aria-hidden="true"><i
										class="fa-regular fa-calendar"></i></span>
								<span class="tm-voucher-meta-text"><strong>01/10/2026 -
										31/12/2026</strong><span>Validity period</span></span>
							</div> *}
						</div>
					</div>
				</div>
			</section>

			<!-- KPI ROW -->
			<section class="tm-kpi-grid" aria-label="Voucher code inventory">
				<article class="tm-kpi-card">
					<span class="tm-kpi-icon tm-kpi-icon--blue" aria-hidden="true"><i
							class="fa-solid fa-box"></i></span>
					<div class="tm-kpi-body"><strong>{$totalCode}</strong><span>{$core->get_Lang('Total')}</span></div>
				</article>
				<article class="tm-kpi-card">
					<span class="tm-kpi-icon tm-kpi-icon--green" aria-hidden="true"><i
							class="fa-solid fa-briefcase"></i></span>
					<div class="tm-kpi-body">
						<strong>{$availableCode}</strong><span>{$core->get_Lang('Available')}</span>
					</div>
				</article>
				<article class="tm-kpi-card">
					<span class="tm-kpi-icon tm-kpi-icon--blue" aria-hidden="true"><i
							class="fa-solid fa-cart-shopping"></i></span>
					<div class="tm-kpi-body"><strong>{$soldCode}</strong><span>{$core->get_Lang('Sold')}</span></div>
				</article>
				<article class="tm-kpi-card">
					<span class="tm-kpi-icon tm-kpi-icon--purple" aria-hidden="true"><i
							class="fa-solid fa-circle-check"></i></span>
					<div class="tm-kpi-body"><strong>{$redeemedCode}</strong><span>{$core->get_Lang('Redeemed')}</span>
					</div>
				</article>
				<article class="tm-kpi-card">
					<span class="tm-kpi-icon tm-kpi-icon--orange" aria-hidden="true"><i
							class="fa-regular fa-clock"></i></span>
					<div class="tm-kpi-body"><strong>{$expiredCode}</strong><span>{$core->get_Lang('Expired')}</span>
					</div>
				</article>
			</section>

			<!-- TABS -->
			{* <section class="tm-card tm-tabs-card">
				<div class="tm-tabs" role="tablist" aria-label="Voucher detail sections">
					<button type="button" class="tm-tab" role="tab" aria-selected="true" id="tabVoucherCodes"><i
							class="fa-solid fa-table-cells"></i> Voucher Codes</button>
					<button type="button" class="tm-tab" role="tab" aria-selected="false" id="tabInformation"><i
							class="fa-regular fa-file-lines"></i> Information</button>
					<button type="button" class="tm-tab" role="tab" aria-selected="false" id="tabTerms"><i
							class="fa-regular fa-file-lines"></i> Terms &amp; Conditions</button>
					<button type="button" class="tm-tab" role="tab" aria-selected="false" id="tabSalesHistory"><i
							class="fa-solid fa-chart-line"></i> Sales History</button>
				</div>
			</section> *}


			<section class="booking-filter-panel v2-filter-panel" aria-label="{$core->get_Lang('filter')}">
				<form id="forums" method="post" class="booking-filter-form" action="" data-auto-filter="true">
					<div class="booking-field booking-search-field v2-field">
						<label class="booking-field-label v2-field-label"
							for="search_keyword">{$core->get_Lang('Search Voucher')}</label>
						<i class="fa fa-search" aria-hidden="true"></i>
						<input id="search_keyword" type="text" name="keyword" value="{$keyword}"
							placeholder="{$core->get_Lang('Search voucher name, booking code, customer name')}..." />
					</div>
					<div class="booking-field booking-select-field v2-field">
						<label class="booking-field-label v2-field-label"
							for="slb_status">{$core->get_Lang('Status')}</label>
						<select name="option_status" class="iso-selectbox" data-width="100%" id="slb_status">
							<option value="0">{$core->get_Lang('All Status')}</option>
							{foreach from=$op_status item=status_name key=status}
								<option value="{$status}" {if $option_status == $status}selected{/if}>
									{$core->get_Lang($status_name)}
								</option>
							{/foreach}
						</select>
					</div>
					<button type="submit" class="booking-search-btn v2-btn v2-btn--primary" id="findtBtn"><i
							class="fa fa-search" aria-hidden="true"></i>{$core->get_Lang('Search')}</button>
					<a href="{$PCMS}/admin/voucher/overview/{$pvalTable}"
						class="booking-reset-btn v2-btn v2-btn--neutral"><i class="fa fa-refresh"
							aria-hidden="true"></i>{$core->get_Lang('Reset')}</a>
					<input type="hidden" name="filter" value="filter" />
				</form>
			</section>
			<!-- FILTER PANEL -->
			<div class="booking-list-toolbar">
				{capture name=list_status_tabs}
					<a href="{$PCMS}/admin/voucher/overview/{$pvalTable}"
						class="booking-status-tab v2-status-tab v2-status-tab--primary {if $type_list ne 'Trash' && $type_list ne 'Publish'}is-active{/if} v2-tab">
						<i aria-hidden="true"></i>{$core->get_Lang('All')} <span>({$number_all})</span>
					</a>
					<a href="{$PCMS}/admin/voucher/overview/{$pvalTable}?type_list=Publish"
						class="booking-status-tab v2-status-tab v2-status-tab--success {if $type_list eq 'Publish'}is-active{/if} v2-tab">
						<i aria-hidden="true"></i>{$core->get_Lang('Publish')} <span>({$number_publish})</span>
					</a>
					<a href="{$PCMS}/admin/voucher/overview/{$pvalTable}?type_list=Private"
						class="booking-status-tab v2-status-tab v2-status-tab--warning {if $type_list eq 'Private'}is-active{/if} v2-tab">
						<i aria-hidden="true"></i>{$core->get_Lang('Private')} <span>({$number_private})</span>
					</a>
					<a href="{$PCMS}/admin/voucher/overview/{$pvalTable}?type_list=Trash"
						class="booking-status-tab v2-status-tab v2-status-tab--danger booking-status-tab--trash {if $type_list eq 'Trash'}is-active{/if} v2-tab">
						<i aria-hidden="true"></i>{$core->get_Lang('Trash')} <span>({$number_trash})</span>
					</a>
					<a class="booking-bulk-delete btn-delete-all v2-tabs-delete" id="btn_delete" clsTable="VoucherCode"
						style="display:none">
						<i class="fa fa-trash" aria-hidden="true"></i>{$core->get_Lang('Delete')}
					</a>
				{/capture}
				{include file="../components/list_v2/status_tabs.tpl"
                status_tabs_label=$core->get_Lang('status')
                status_tabs_content=$smarty.capture.list_status_tabs
            }
				<div class="booking-list-toolbar__right">
					{capture name=list_records_query}?mod={$mod}{$hotelRecordPerPageFilterUrl}{/capture}
					{include file="../components/list_v2/records_per_page.tpl"
                    records_per_page_id="list_records_per_page"
                    records_per_page_label=$core->get_Lang('Records per page')
                    records_per_page_value=$recordPerPage
                    records_per_page_base_url=$PCMS_URL
                    records_per_page_query=$smarty.capture.list_records_query
                }
				</div>
			</div>

			<!-- VOUCHER CODE TABLE -->
			<section class="list-table-v2-card booking-table-card v2-table-card">
				<div class="list-table-v2-scroll booking-table-scroll v2-table-scroll">
					<table class="list-table-v2 hotel-list-table v2-table">
						<thead>
							<tr>
								<th class="list-table-v2-check booking-check-cell"><input id="check_all" type="checkbox"
										class="el-checkbox" aria-label="{$core->get_Lang('Select all')}" /></th>
								<th class="list-table-v2-name">{$core->get_Lang('Voucher Code')}</th>
								<th class="list-table-v2-location">{$core->get_Lang('Status')}</th>
								<th class="list-table-v2-location">{$core->get_Lang('Customer')}</th>
								<th class="list-table-v2-location">{$core->get_Lang('Booking')}</th>
								<th class="list-table-v2-location">{$core->get_Lang('Price')}</th>
								<th class="list-table-v2-location">{$core->get_Lang('Start Date')}</th>
								<th class="list-table-v2-location">{$core->get_Lang('Expiry Date')}</th>
								<th class="list-table-v2-location">{$core->get_Lang('Sold Date')}</th>
								<th class="list-table-v2-location">{$core->get_Lang('Redeemed Date')}</th>
								<th class="list-table-v2-public is-center">{$core->get_Lang('public')}</th>
								{* <th class="list-table-v2-action is-center list-table-action-cell">
									{$core->get_Lang('Action')}</th> *}
							</tr>
						</thead>

						{if !empty($allItem)}
							<tbody id="SortAble" class="sortByTd">
								{section name=i loop=$allItem}

									{assign var=voucher_id value=$allItem[i].voucher_code_id}
									{assign var=linkEdit value="{$PCMS_URL}/voucher/insert/{$voucher_id}/overview/generalinformation"}

									<tr id="order_{$voucher_id}">
										<td class="list-table-v2-check booking-check-cell"><input name="p_key[]"
												class="chkitem el-checkbox" type="checkbox" value="{$voucher_id}" /></td>

										<td class="list-table-v2-name">
											<div
												class="list-table-v2-wrap hotel-name-wrap list-table-heading list-table-heading-group">
												<a class="list-table-v2-title hotel-name list-table-link"
													href="javascript:void(0);">
													<span class="font-weight-bold">
														{$allItem[i].code}
													</span>
												</a>
												{if $allItem[i].is_trash eq '1'}<span
													class="list-table-v2-badge list-table-v2-badge--danger hotel-state hotel-state--trash list-table-badge list-table-badge--danger v2-badge v2-badge--danger">{$core->get_Lang('intrash')}</span>{/if}
												{if $allItem[i].is_online eq '0'}<span
													class="list-table-v2-badge list-table-v2-badge--warning hotel-state hotel-state--private list-table-badge list-table-badge--warning v2-badge v2-badge--warning status_private">{$core->get_Lang('Private')}</span>{/if}
											</div>

										</td>
										<td class="font-weight-bold">
											<span
												class="tm-status-pill tm-status-pill--{$clsVoucherCode->checkStatus($allItem[i].voucher_code_id)}">
												<i
													class="fa-solid fa-circle-check"></i>{$clsVoucherCode->checkStatus($allItem[i].voucher_code_id)}
											</span>

										</td>
										<td>
											{$clsCustomer->getTitle($allItem[i].customer_id)}
										</td>

										<td class="font-weight-bold">
											{$clsBooking->getBookingCode($allItem[i].booking_id)}
										</td>
										<td class="font-weight-bold">
											{$clsISO->formatPriceRead($allItem[i].price,',')}
										</td>
										<td class="font-weight-bold">
											{$clsISO->convertTimeToText($allItem[i].valid_from)}
										</td>
										<td class="font-weight-bold">
											{$clsISO->convertTimeToText($allItem[i].valid_to)}
										</td>
										<td class="font-weight-bold">
											{$clsISO->convertTimeToText($allItem[i].sold_at)}
										</td>
										<td class="font-weight-bold">
											{$clsISO->convertTimeToText($allItem[i].redeemed_at)}
										</td>
										{* <td class="list-table-v2-rating is-center hotel-rating">
                                        <strong>${$clsISO->formatPriceRead($allItem[i].price,',')}</strong>
                                    </td> *}
										<td class="list-table-v2-public is-center">
											<a href="javascript:void(0);"
												class="SiteClickPublic list-table-v2-toggle list-table-toggle"
												clsTable="VoucherCode" pkey="voucher_code_id"
												sourse_id="{$allItem[i].voucher_code_id}" rel="{$allItem[i].is_online}"
												title="{$core->get_Lang('Click to change status')}"
												aria-label="{$core->get_Lang('Click to change status')}">
												<span class="list-table-toggle__track" aria-hidden="true"><span
														class="list-table-toggle__thumb"></span></span>
											</a>
										</td>
										{* <td class="list-table-v2-action is-center list-table-action-cell">
											<div class="btn-group"> *}
										{* <button
													class="list-table-v2-action-btn booking-row-menu list-table-action dropdown-toggle v2-action"
													type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
														class="fa fa-ellipsis-v" aria-hidden="true"></i></button> *}
										{* <ul class="dropdown-menu dropdown-menu-end">
													{if $allItem[i].is_trash eq '0'}

														<li><a class="dropdown-item" href="{$linkEdit}"><i class="fa fa-edit"></i>
																{$core->get_Lang('edit')}</a></li>
														<li><a class="dropdown-item"
																href="{$PCMS_URL}/?mod={$mod}&act=trash&voucher_id={$core->encryptID($voucher_id)}{$pUrl}&page={$currentPage}"><i
																	class="fa fa-trash"></i> {$core->get_Lang('trash')}</a></li>
													{else}
														<li><a class="dropdown-item" href="{$linkEdit}"><i class="fa fa-edit"></i>
																{$core->get_Lang('edit')}</a></li>
														<li><a class="dropdown-item"
																href="{$PCMS_URL}/?mod={$mod}&act=restore&voucher_id={$core->encryptID($voucher_id)}{$pUrl}&page={$currentPage}"><i
																	class="fa fa-refresh"></i> {$core->get_Lang('restore')}</a></li>
														<li><a class="confirm_delete dropdown-item"
																href="{$PCMS_URL}/?mod={$mod}&act=delete&voucher_id={$core->encryptID($voucher_id)}{$pUrl}&page={$currentPage}"><i
																	class="fa fa-remove"></i> {$core->get_Lang('delete')}</a></li>
													{/if}
												</ul> *}
										{* </div>
										</td> *}
									</tr>
								{/section}
							</tbody>
						{else}
							<tbody>
								<tr>
									<td colspan="8" class="booking-empty list-table-empty"><i class="fa fa-inbox"
											aria-hidden="true"></i><span> {$core->get_Lang('no item')}!</span></td>
								</tr>
							</tbody>
						{/if}
					</table>
				</div>
				{include file="../components/list_v2/pagination.tpl"
                pagination_showing_label=$core->get_Lang('Showing')
                pagination_showing_start=$showingStart
                pagination_showing_end=$showingEnd
                pagination_of_label=$core->get_Lang('of')
                pagination_total_records=$totalRecord
                pagination_entity_label=$core->get_Lang('Voucher Codes')
                pagination_total_pages=$totalPage
                pagination_current_page=$currentPage
                pagination_previous_page=$previousPage
                pagination_next_page=$nextPage
                pagination_pages=$listPageNumber
                pagination_base_url=$PCMS_URL
                pagination_page_query=$link_page_current
                pagination_label=$core->get_Lang('pagination')
                pagination_previous_label=$core->get_Lang('Previous')
                pagination_next_label=$core->get_Lang('Next')
            }
			</section>

		</div>

		<!-- SIDE COLUMN -->
		<aside class="tm-side-col" aria-label="Voucher status and activity">

			<!-- STATUS PANEL -->
			{assign var="isActive" value=$oneItem['is_online']}
			<section class="tm-card tm-status-panel">
				<a href="javascript:void(0);"
					class="SiteClickPublic tm-status-badge-btn  tm-status-badge-btn--{if $isActive == 1}active{else}inactive{/if}"
					clsTable="Voucher" pkey="voucher_id" sourse_id="{$pvalTable}" rel="{$oneItem['is_online']}"
					title="{$core->get_Lang('Click to change status')}"
					aria-label="{$core->get_Lang('Click to change status')}">
					<i class="fa-solid fa-{if $isActive == 1}circle-check{else}circle-minus{/if}"></i>
					<span
						class="tm-text">{if $isActive == 1}{$core->get_Lang('Active')}{else}{$core->get_Lang('Inactive')}{/if}</span>
				</a>

				{* <div class="tm-status-stat">
					<strong>25%</strong>
					<span>Discount value</span>
				</div>
				<div class="tm-status-stat">
					<strong>100</strong>
					<span>Total vouchers</span>
				</div> *}
			</section>

			<!-- INVENTORY OVERVIEW -->
			<section class="tm-card">
				<div class="tm-side-card__header">
					<h3>{$core->get_Lang('Inventory Overview')}</h3>
				</div>
				<div class="tm-donut-wrap">
					<div class="tm-donut-canvas-wrap">
						<svg viewBox="0 0 120 120">
							<!-- Background -->
							<circle cx="60" cy="60" r="52" fill="none" stroke="#EEF2F9" stroke-width="14">
							</circle>
							<!-- Available -->
							{if $availableCode > 0}
								<circle class="tm-donut-progress" data-value="{$availableCode}" fill="none" stroke="#16A34A"
									stroke-width="14" stroke-linecap="round" cx="60" cy="60" r="52">
								</circle>
							{/if}
							<!-- Sold -->
							{if $soldCode > 0}
								<circle class="tm-donut-progress" data-value="{$soldCode}" fill="none" stroke="#0066FF"
									stroke-width="14" stroke-linecap="round" cx="60" cy="60" r="52">
								</circle>
							{/if}
							<!-- Redeemed -->
							{if $redeemedCode > 0}
								<circle class="tm-donut-progress" data-value="{$redeemedCode}" fill="none" stroke="#7C3AED"
									stroke-width="14" stroke-linecap="round" cx="60" cy="60" r="52">
								</circle>
							{/if}
							<!-- Expired -->
							{if $expiredCode > 0}
								<circle class="tm-donut-progress" data-value="{$expiredCode}" fill="none" stroke="#EA7A1C"
									stroke-width="14" stroke-linecap="round" cx="60" cy="60" r="52">
								</circle>
							{/if}
						</svg>

						<div class="tm-donut-center">
							<strong class="js-donut-percent">0%</strong>
							<span>{$core->get_Lang('Available')}</span>
						</div>
					</div>

					<div class="tm-donut-legend">
						<div class="tm-donut-legend__row"><span class="tm-legend-dot"
								style="background:#16A34A;"></span><span
								class="tm-donut-legend__label">{$core->get_Lang('Available')}</span><span
								class="tm-donut-legend__value">{$availableCode}</span></div>
						<div class="tm-donut-legend__row"><span class="tm-legend-dot"
								style="background:#0066FF;"></span><span
								class="tm-donut-legend__label">{$core->get_Lang('Sold')}</span><span
								class="tm-donut-legend__value">{$soldCode}</span></div>
						<div class="tm-donut-legend__row"><span class="tm-legend-dot"
								style="background:#7C3AED;"></span><span
								class="tm-donut-legend__label">{$core->get_Lang('Redeemed')}</span><span
								class="tm-donut-legend__value">{$redeemedCode}</span></div>
						<div class="tm-donut-legend__row"><span class="tm-legend-dot"
								style="background:#EA7A1C;"></span><span
								class="tm-donut-legend__label">{$core->get_Lang('Expired')}</span><span
								class="tm-donut-legend__value">{$expiredCode}</span></div>
					</div>

					<div style="width:100%;">
						<div class="tm-donut-progress-track">
							<div class="tm-donut-progress-fill" style="width:{$availablePercent}%;"></div>
						</div>
						<p class="tm-donut-caption">{$availableCode} {$core->get_Lang('of')} {$totalCode}
							{$core->get_Lang('voucher codes available')}</p>
					</div>
				</div>
			</section>

			<!-- RECENT ACTIVITY -->
			{* <section class="tm-card">
				<div class="tm-side-card__header">
					<h3>{$core->get_Lang('Recent Activity')}</h3>
					<a href="#" class="tm-side-card__link">{$core->get_Lang('View all')} <i class="fa-solid fa-arrow-right"
							style="font-size:10px;"></i></a>
				</div>
				<div class="tm-activity-list">
					<div class="tm-activity-item">
						<span class="tm-activity-icon tm-activity-icon--redeemed" aria-hidden="true"><i
								class="fa-solid fa-circle-check"></i></span>
						<div>
							<div class="tm-activity-title">Voucher redeemed</div>
							<div class="tm-activity-meta">FLC20260001</div>
							<div class="tm-activity-time">12/09/2026 14:22</div>
						</div>
					</div>
					<div class="tm-activity-item">
						<span class="tm-activity-icon tm-activity-icon--sold" aria-hidden="true"><i
								class="fa-solid fa-cart-shopping"></i></span>
						<div>
							<div class="tm-activity-title">Voucher sold</div>
							<div class="tm-activity-meta">FLC20260005</div>
							<div class="tm-activity-time">07/09/2026 10:15</div>
						</div>
					</div>
					<div class="tm-activity-item">
						<span class="tm-activity-icon tm-activity-icon--sold" aria-hidden="true"><i
								class="fa-solid fa-cart-shopping"></i></span>
						<div>
							<div class="tm-activity-title">Voucher sold</div>
							<div class="tm-activity-meta">FLC20260004</div>
							<div class="tm-activity-time">07/09/2026 09:40</div>
						</div>
					</div>
					<div class="tm-activity-item">
						<span class="tm-activity-icon tm-activity-icon--imported" aria-hidden="true"><i
								class="fa-solid fa-arrow-down"></i></span>
						<div>
							<div class="tm-activity-title">Voucher imported</div>
							<div class="tm-activity-meta">Batch FLC-2026-001</div>
							<div class="tm-activity-time">01/09/2026 08:30</div>
						</div>
					</div>
				</div>
			</section> *}

			<!-- QUICK ACTIONS -->
			{* <section class="tm-card">
				<div class="tm-side-card__header" style="padding-bottom:12px;">
					<h3>Quick Actions</h3>
				</div>
				<div class="tm-quick-actions">
					<button type="button" class="v2-btn tm-btn--quick" id="btnDownloadCodes"><i
							class="fa-solid fa-download"></i> Download codes</button>
					<button type="button" class="v2-btn tm-btn--quick" id="btnPrintList"><i
							class="fa-solid fa-print"></i> Print list</button>
				</div>
			</section> *}

		</aside>

	</div>
</div>

{assign var="lightbox_content" value= $clsISO->getTemplate('blocks/lightbox/voucher/import.tpl')}
{$clsISO->getTemplate(
	'blocks/lightbox/default.tpl',
		array(
		'lightbox_id' => 'lightbox_import_voucher',
		'lightbox_size' => 'lg',
		'lightbox_content' => $lightbox_content
	)
)}

<link rel="stylesheet" href="{$URL_LIBRARY}/swiper-11.1.15/swiper-bundle.min.css?v={$v_cache}">
<script src="{$URL_LIBRARY}/swiper-11.1.15/swiper-bundle.min.js?v={$v_cache}"></script>

{literal}

	<script>
		$(document).on(
			'click',
			'.js-open-lightbox',
			function() {

				var lightboxId = $(this).data('lightbox');

				if (lightboxId) {
					Lightbox.open(lightboxId);
				}

			}
		);

		document.addEventListener("DOMContentLoaded", function() {

			const swiper = new Swiper('#voucherGallery', {
				slidesPerView: 1,
				spaceBetween: 10,

				navigation: {
					nextEl: '#voucherGallery .swiper-button-next',
					prevEl: '#voucherGallery .swiper-button-prev'
				},

				on: {
					init: function() {
						updateGalleryCounter(this);
					},

					slideChange: function() {
						updateGalleryCounter(this);
					}
				}
			});

			function updateGalleryCounter(swiper) {
				const current = swiper.activeIndex + 1;
				const total = swiper.slides.length;

				$('#galleryCounter').text(current + ' / ' + total);
			}
		});
	</script>
{/literal}
<script type="text/javascript">
	function initVoucherDonut() {
		$('.tm-donut-canvas-wrap').each(function() {

			var $wrap = $(this);
			var $circles = $wrap.find('.tm-donut-progress');

			var radius = 52;
			var circumference = 2 * Math.PI * radius;

			var total = 0;

			// Tổng số voucher
			$circles.each(function() {
				total += parseInt($(this).attr('data-value'), 10) || 0;
			});

			if (total <= 0) {
				$circles.css({
					'stroke-dasharray': '0 ' + circumference,
					'stroke-dashoffset': 0
				});

				$wrap.find('.js-donut-percent').text('0%');

				return;
			}

			var currentPercent = 0;

			$circles.each(function() {

				var $circle = $(this);
				var value = parseInt($circle.attr('data-value'), 10) || 0;

				var percent = (value / total) * 100;

				// Độ dài đoạn cần vẽ
				var segmentLength = circumference * percent / 100;

				// Khoảng trống còn lại
				var gapLength = circumference - segmentLength;

				// Vẽ đoạn
				$circle.css({
					'stroke-dasharray': segmentLength + ' ' + gapLength,
					'stroke-dashoffset': 0,

					// Xoay tới vị trí bắt đầu của segment
					'transform': 'rotate(' + ((currentPercent * 3.6) - 90) + 'deg)',
					'transform-origin': '60px 60px'
				});
				currentPercent += percent;
			});

			// Available %
			var available = parseInt(
				$circles.eq(0).attr('data-value'),
				10
			) || 0;

			var availablePercent = Math.round((available / total) * 100);

			$wrap.find('.js-donut-percent').text(
				availablePercent + '%'
			);
		});

	}

	$(document).ready(function() {
		initVoucherDonut();
	});

	$('#SortAble').sortable({
		items: 'tr',
		handle: 'td.sortable',
		opacity: 0.8,
		cursor: 'move',
		start: function() { vietiso_loading(1); },
		stop: function() { vietiso_loading(0); },
		update: function() {
			var order = $(this).sortable('serialize') + '&update=update&recordPerPage=' +
				$recordPerPage + '&currentPage=' + $currentPage;
			$.post(path_ajax_script + '/index.php?mod=voucher&act=ajUpdPosSort', order, function() {
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{literal}
	<style>
		.tm-donut-progress-fill {
			width: 0;
			transition: width 1s ease;
		}

		.tm-status-pill--Redeemed {
			background: var(--color-purple-soft);
			color: var(--color-purple);
		}

		.tm-status-pill--Cancelled {
			background: var(--color-danger-soft);
			color: var(--color-danger);
		}

		.tm-status-pill--Expired {
			background: var(--color-border-light);
			color: var(--color-text-muted);
		}

		.tm-status-pill--Sold {
			background: var(--color-primary-soft);
			color: var(--color-primary);
		}

		.tm-status-pill--Available {
			background: var(--color-success-soft);
			color: var(--color-success);
		}

		.tm-status-pill {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			height: 26px;
			padding: 0 10px;
			border-radius: 999px;
			font-size: 12px;
			font-weight: 700;
		}

		.iso-voucher-view {
			flex: 1;
			min-width: 0;
			width: 100%;
			max-width: none;
			background: var(--color-page);
			padding: 18px clamp(16px, 2vw, 24px) 32px;
			display: flex;
			flex-direction: column;
			gap: 16px;
		}

		.iso-voucher-view * {
			box-sizing: border-box;
		}

		.iso-voucher-view button {
			cursor: pointer;
		}

		.iso-voucher-view a {
			text-decoration: none;
		}

		.v2-btn:active {
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

		.tm-btn--primary {
			background: var(--color-primary);
			color: #fff;
		}

		.tm-btn--primary:hover {
			background: var(--color-primary-dark);
		}

		.tm-btn--icon {
			width: 40px;
			padding: 0;
			justify-content: center;
			background: var(--color-surface);
			border-color: var(--color-border);
			color: var(--color-text-secondary);
			flex-shrink: 0;
		}

		.tm-btn--icon:hover {
			background: var(--color-page);
			color: var(--color-text);
		}

		.tm-btn--quick {
			width: 100%;
			justify-content: center;
			background: var(--color-surface);
			border-color: var(--color-border);
			color: var(--color-text);
		}

		/* ---------- BREADCRUMB + TOP ACTIONS ---------- */
		.tm-topbar-row {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 16px;
			flex-wrap: wrap;
		}

		.tm-breadcrumb {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 13px;
			color: var(--color-text-secondary);
			flex-wrap: wrap;
		}

		.tm-breadcrumb a {
			color: var(--color-text-secondary);
		}

		.tm-breadcrumb a:hover {
			color: var(--color-primary);
		}

		.tm-breadcrumb i.fa-chevron-left {
			color: var(--color-primary);
			font-size: 12px;
			margin-right: 4px;
		}

		.tm-breadcrumb .sep {
			color: var(--color-border);
		}

		.tm-breadcrumb .is-current {
			color: var(--color-text);
			font-weight: 700;
		}

		.tm-top-actions {
			display: flex;
			align-items: center;
			gap: 8px;
			flex-wrap: wrap;
		}

		/* ---------- MAIN LAYOUT: left content | right sidebar ---------- */
		.tm-view-layout {
			display: flex;
			align-items: flex-start;
			gap: 20px;
		}

		.tm-main-col {
			flex: 1;
			min-width: 0;
			display: flex;
			flex-direction: column;
			gap: 16px;
		}

		.tm-side-col {
			width: 300px;
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			gap: 16px;
			position: sticky;
			top: 76px;
		}

		.tm-card {
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-xl);
			box-shadow: var(--box-shadow-sm);
		}

		/* ---------- VOUCHER HEADER ---------- */
		.tm-voucher-header {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 20px;
			padding: 20px;
		}

		.tm-gallery {
			position: relative;
			border-radius: var(--border-radius-lg);
			overflow: hidden;
		}

		.tm-gallery img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			display: block;
			aspect-ratio: 16/11;
			background: var(--color-border-light);
		}

		.tm-gallery__nav {
			position: absolute;
			top: 50%;
			/* transform: translateY(-50%); */
			width: 34px;
			height: 34px;
			border-radius: 999px;
			border: none;
			background: rgba(255, 255, 255, 0.85);
			color: var(--color-text);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 13px;
		}

		.tm-gallery__nav:hover {
			background: #fff;
		}

		.tm-gallery__nav--prev {
			left: 12px;
		}

		.tm-gallery__nav--next {
			right: 12px;
		}

		.tm-gallery__counter {
			position: absolute;
			left: 12px;
			bottom: 12px;
			background: rgba(11, 31, 68, 0.7);
			color: #fff;
			font-size: 12px;
			font-weight: 700;
			padding: 4px 10px;
			border-radius: 999px;
			z-index: 9;
		}

		.swiper-button-next:after,
		.swiper-button-prev:after {
			display: none;
		}

		.tm-gallery__btn {
			position: absolute;
			right: 12px;
			bottom: 12px;
			display: inline-flex;
			align-items: center;
			gap: 6px;
			height: 34px;
			padding: 0 12px;
			border-radius: var(--border-radius-sm);
			border: none;
			background: rgba(255, 255, 255, 0.92);
			color: var(--color-text);
			font-size: 12.5px;
			font-weight: 700;
			z-index: 9;
		}

		.tm-gallery__btn:hover {
			background: #fff;
		}

		.tm-voucher-info {
			display: flex;
			flex-direction: column;
			gap: 12px;
			min-width: 0;
		}

		.tm-voucher-info__eyebrow {
			display: flex;
			align-items: center;
			gap: 6px;
			font-size: 12.5px;
			font-weight: 700;
			color: var(--color-text-secondary);
		}

		.tm-voucher-info__eyebrow i {
			font-size: 11px;
		}

		.tm-voucher-title-row {
			display: flex;
			align-items: center;
			gap: 10px;
			flex-wrap: wrap;
		}

		.tm-voucher-title-row h1 {
			margin: 0;
			font-size: clamp(19px, 1.8vw, 23px);
			font-weight: 800;
			color: var(--color-navy);
		}

		.tm-voucher-badge {
			display: inline-flex;
			align-items: center;
			height: 22px;
			padding: 0 10px;
			border-radius: 999px;
			font-size: 11px;
			font-weight: 700;
			margin-left: 12px;
			vertical-align: middle;
			background: var(--color-pink-soft);
			color: var(--color-pink);
		}

		.tm-voucher-code-chip {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			height: 30px;
			padding: 0 6px 0 12px;
			border-radius: 999px;
			background: var(--color-primary-soft);
			color: var(--color-primary);
			font-size: 12.5px;
			font-weight: 700;
			width: fit-content;
		}

		.tm-voucher-code-chip button {
			width: 22px;
			height: 22px;
			border-radius: 999px;
			border: none;
			background: rgba(0, 102, 255, 0.12);
			color: var(--color-primary);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 10.5px;
		}

		.tm-voucher-code-chip button:hover {
			background: rgba(0, 102, 255, 0.22);
		}

		.tm-voucher-desc {
			margin: 0;
			font-size: 13px;
			color: var(--color-text-secondary);
			line-height: 1.6;
		}

		.tm-voucher-meta-row {
			display: flex;
			align-items: flex-start;
			gap: 24px;
			flex-wrap: wrap;
			margin-top: 4px;
		}

		.tm-voucher-meta-item {
			display: flex;
			align-items: center;
			gap: 10px;
		}

		.tm-voucher-meta-icon {
			width: 34px;
			height: 34px;
			border-radius: 999px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 14px;
			flex-shrink: 0;
		}

		.tm-voucher-meta-icon--supplier {
			background: var(--color-orange-soft);
			color: var(--color-orange);
		}

		.tm-voucher-meta-icon--category {
			background: var(--color-primary-soft);
			color: var(--color-primary);
		}

		.tm-voucher-meta-icon--validity {
			background: var(--color-primary-soft);
			color: var(--color-primary);
		}

		.tm-voucher-meta-text strong {
			display: block;
			font-size: 13.5px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-voucher-meta-text span {
			font-size: 11.5px;
			color: var(--color-text-muted);
		}

		/* ---------- STATUS PANEL (top of right sidebar) ---------- */
		.tm-status-panel {
			padding: 16px;
			display: flex;
			flex-direction: column;
			gap: 10px;
		}

		.tm-status-badge-btn {
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			height: 42px;
			border-radius: var(--border-radius-md);
			background: var(--color-success-soft);
			color: var(--color-success);
			font-size: 13.5px;
			font-weight: 700;
			border: none;
			width: 100%;
		}

		.tm-status-badge-btn i {
			font-size: inherit;
		}

		.tm-status-badge-btn i.fa-chevron-down {
			font-size: 11px;
			margin-left: 4px;
		}

		.tm-status-badge-btn--active {
			background: var(--color-success-soft);
			color: var(--color-success);
		}

		.tm-status-badge-btn--inactive {
			background: var(--color-danger-soft);
			color: var(--color-danger);
		}

		.tm-status-stat {
			background: var(--color-primary-soft);
			border-radius: var(--border-radius-md);
			padding: 12px 14px;
		}

		.tm-status-stat strong {
			display: block;
			font-size: 20px;
			font-weight: 800;
			color: var(--color-navy);
		}

		.tm-status-stat span {
			font-size: 12px;
			color: var(--color-text-secondary);
			font-weight: 600;
		}

		/* ---------- KPI ROW ---------- */
		.tm-kpi-grid {
			display: grid;
			grid-template-columns: repeat(5, minmax(0, 1fr));
			gap: 14px;
		}

		.tm-kpi-card {
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-lg);
			box-shadow: var(--box-shadow-sm);
			padding: 14px;
			display: flex;
			align-items: center;
			gap: 12px;
		}

		.tm-kpi-icon {
			width: 40px;
			height: 40px;
			border-radius: 999px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 16px;
			flex-shrink: 0;
		}

		.tm-kpi-icon--blue {
			background: var(--color-primary-soft);
			color: var(--color-primary);
		}

		.tm-kpi-icon--green {
			background: var(--color-success-soft);
			color: var(--color-success);
		}

		.tm-kpi-icon--purple {
			background: var(--color-purple-soft);
			color: var(--color-purple);
		}

		.tm-kpi-icon--orange {
			background: var(--color-warning-soft);
			color: #C2410C;
		}

		.tm-kpi-body strong {
			display: block;
			font-size: 20px;
			font-weight: 800;
			color: var(--color-navy);
			line-height: 1.1;
		}

		.tm-kpi-body span {
			font-size: 12px;
			color: var(--color-text-secondary);
			font-weight: 600;
		}

		/* ---------- TABS ---------- */
		.tm-tabs-card {
			padding: 4px 16px 0;
		}

		.tm-tabs {
			display: flex;
			align-items: center;
			gap: 4px;
			flex-wrap: wrap;
		}

		.tm-tab {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			height: 46px;
			padding: 0 6px;
			border: none;
			background: transparent;
			font-size: 13.5px;
			font-weight: 700;
			color: var(--color-text-secondary);
			border-bottom: 2px solid transparent;
			margin-right: 18px;
		}

		.tm-tab i {
			font-size: 14px;
		}

		.tm-tab:hover {
			color: var(--color-text);
		}

		.tm-tab[aria-selected="true"] {
			color: var(--color-primary);
			border-bottom-color: var(--color-primary);
		}

		/* ---------- INVENTORY OVERVIEW ---------- */
		.tm-side-card__header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 10px;
			padding: 16px 16px 0;
		}

		.tm-side-card__header h3 {
			margin: 0;
			font-size: 14.5px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-side-card__link {
			font-size: 12px;
			font-weight: 700;
			color: var(--color-primary);
			display: inline-flex;
			align-items: center;
			gap: 4px;
		}

		.tm-side-card__link:hover {
			color: var(--color-primary-dark);
		}

		.tm-donut-wrap {
			padding: 16px;
			display: flex;
			flex-direction: column;
			align-items: center;
			gap: 14px;
		}

		.tm-donut-canvas-wrap {
			position: relative;
			width: 128px;
			height: 128px;
		}

		.tm-donut-canvas-wrap svg {
			width: 100%;
			height: 100%;
			transform: rotate(-90deg);
		}

		.tm-donut-center {
			position: absolute;
			inset: 0;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
		}

		.tm-donut-center strong {
			font-size: 20px;
			font-weight: 800;
			color: var(--color-success);
			line-height: 1.1;
		}

		.tm-donut-center span {
			font-size: 11px;
			color: var(--color-text-muted);
			font-weight: 600;
		}

		.tm-donut-legend {
			width: 100%;
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.tm-donut-legend__row {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 12.5px;
		}

		.tm-legend-dot {
			width: 9px;
			height: 9px;
			border-radius: 999px;
			flex-shrink: 0;
		}

		.tm-donut-legend__label {
			flex: 1;
			color: var(--color-text);
			font-weight: 500;
		}

		.tm-donut-legend__value {
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-donut-progress-track {
			width: 100%;
			height: 6px;
			border-radius: 999px;
			background: var(--color-border-light);
			overflow: hidden;
			margin-top: 2px;
		}

		.tm-donut-progress-fill {
			height: 100%;
			background: var(--color-success);
			border-radius: 999px;
		}

		.tm-donut-caption {
			font-size: 12px;
			color: var(--color-text-secondary);
			text-align: center;
		}

		/* ---------- RECENT ACTIVITY ---------- */
		.tm-activity-list {
			display: flex;
			flex-direction: column;
			padding: 12px 16px 16px;
		}

		.tm-activity-item {
			display: flex;
			gap: 12px;
			padding: 10px 0;
			border-bottom: 1px solid var(--color-border-light);
		}

		.tm-activity-item:last-child {
			border-bottom: none;
		}

		.tm-activity-icon {
			width: 32px;
			height: 32px;
			border-radius: 999px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 13px;
			flex-shrink: 0;
		}

		.tm-activity-icon--redeemed {
			background: var(--color-success-soft);
			color: var(--color-success);
		}

		.tm-activity-icon--sold {
			background: var(--color-primary-soft);
			color: var(--color-primary);
		}

		.tm-activity-icon--imported {
			background: var(--color-primary-soft);
			color: var(--color-primary);
		}

		.tm-activity-title {
			font-size: 13px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-activity-meta {
			font-size: 12px;
			color: var(--color-text-secondary);
			margin-top: 1px;
		}

		.tm-activity-time {
			font-size: 11px;
			color: var(--color-text-muted);
			margin-top: 2px;
		}

		/* ---------- QUICK ACTIONS ---------- */
		.tm-quick-actions {
			padding: 16px;
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.tm-btn--quick {
			width: 100%;
			justify-content: center;
			background: var(--color-surface);
			border-color: var(--color-border);
			color: var(--color-text);
		}

		.tm-btn--quick:hover {
			background: var(--color-page);
		}

		@media (max-width: 1439px) {
			.tm-kpi-grid {
				grid-template-columns: repeat(3, minmax(0, 1fr));
			}
		}

		@media (max-width: 1280px) {
			.tm-side-col {
				width: 270px;
			}
		}

		@media (max-width: 1180px) {
			.tm-view-layout {
				flex-direction: column;
			}

			.tm-side-col {
				width: 100%;
				position: static;
				flex-direction: row;
				flex-wrap: wrap;
			}

			.tm-side-col>* {
				flex: 1;
				min-width: 260px;
			}
		}

		@media (max-width: 1024px) {
			.demo-sidebar {
				position: fixed;
				left: 0;
				top: 60px;
				transform: translateX(-100%);
				transition: transform 220ms ease;
				box-shadow: 6px 0 20px rgba(8, 35, 58, 0.15);
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

			.tm-voucher-header {
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

			.tm-kpi-grid {
				grid-template-columns: repeat(2, minmax(0, 1fr));
			}
		}

		@media (max-width: 768px) {
			.iso-voucher-view {
				padding: 14px 12px 28px;
				gap: 14px;
			}

			.tm-top-actions {
				width: 100%;
			}

			.tm-top-actions .v2-btn {
				flex: 1;
				justify-content: center;
			}

			.tm-voucher-meta-row {
				flex-direction: column;
				gap: 12px;
			}

			.tm-filter-row {
				flex-direction: column;
				align-items: stretch;
			}

			.tm-select-field {
				width: 100%;
			}

			.tm-side-col {
				flex-direction: column;
			}

			.tm-side-col>* {
				min-width: 0;
			}
		}

		@media (max-width: 480px) {
			.tm-kpi-grid {
				grid-template-columns: 1fr 1fr;
			}

			.tm-pagination-row {
				flex-direction: column;
				align-items: flex-start;
			}

			.tm-tabs {
				overflow-x: auto;
				flex-wrap: nowrap;
			}

			.tm-tab {
				flex-shrink: 0;
			}
		}
	</style>
{/literal}