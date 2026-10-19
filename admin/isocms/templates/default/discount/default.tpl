<link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />

<div id="page_v2" class="page_container">
	<main class="iso-module-list iso-hotels-list">
		{capture name=hotel_header_actions}
			<button type="button" class="v2-btn v2-btn--add btn-addnew" onClick="create_discount(this)"
				title="{$core->get_Lang('Add Discount')}">
				<i class="fa fa-plus" aria-hidden="true"></i><span>{$core->get_Lang('Add Discount')}</span>
			</button>
		{/capture}
		{capture name=hotel_header_setting_url}{$PCMS_URL}/?mod={$mod}&act=setting{/capture}
		{include file="../components/list_v2/header.tpl"
            header_home_label=$core->get_Lang('Dashboard')
            header_module_label=$core->get_Lang('Discounts')
            header_title=$core->get_Lang('Discounts')
            header_count=$number_all
            header_subtitle=$core->get_Lang('Create and manage promotion codes to boost your sales')
            header_actions=$smarty.capture.hotel_header_actions
            header_setting_url=$smarty.capture.hotel_header_setting_url
            header_setting_label=$core->get_Lang('Setting')
        }

		<section class="booking-filter-panel v2-filter-panel" aria-label="{$core->get_Lang('filter')}">
			<form id="forums" method="post" class="booking-filter-form" action="" data-auto-filter="true">
				<div class="booking-field booking-search-field v2-field">
					<label class="booking-field-label v2-field-label"
						for="hotel_keyword">{$core->get_Lang('Search')}</label>
					<i class="fa fa-search" aria-hidden="true"></i>
					<input id="hotel_keyword" type="text" name="keyword" value="{$keyword}"
						placeholder="{$core->get_Lang('Search promo code name')}..." />
				</div>
				<div class="booking-field booking-select-field v2-field">
					<label class="booking-field-label v2-field-label" for="slb_type">
						{$core->get_Lang('Type')}
					</label>

					<select name="discount_type" class="iso-selectbox" data-width="100%" id="slb_type">
						{foreach from=$discount_type_list key=value item=label}
							<option value="{$value}" {if $discount_type == $value}selected{/if}>
								{$label}
							</option>
						{/foreach}
					</select>
				</div>

				<div class="booking-field booking-select-field v2-field">
					<label class="booking-field-label v2-field-label" for="slb_status">
						{$core->get_Lang('Status')}
					</label>

					<select name="status_id" class="iso-selectbox" data-width="100%" id="slb_status">
						{foreach from=$status_list key=value item=label}
							<option value="{$value}" {if $status_id == $value}selected{/if}>
								{$label}
							</option>
						{/foreach}
					</select>
				</div>
				<button type="submit" class="booking-search-btn v2-btn v2-btn--primary" id="findtBtn"><i
						class="fa fa-search" aria-hidden="true"></i>{$core->get_Lang('Search')}</button>
				<a href="{$PCMS_URL}/?mod={$mod}" class="booking-reset-btn v2-btn v2-btn--neutral"><i
						class="fa fa-refresh" aria-hidden="true"></i>{$core->get_Lang('Reset')}</a>
				<input type="hidden" name="filter" value="filter" />
			</form>
		</section>

		<div class="booking-list-toolbar">
			{capture name=hotel_status_tabs}
				<a href="{$PCMS_URL}/?mod={$mod}"
					class="booking-status-tab v2-status-tab v2-status-tab--primary {if $type_list ne 'Trash' && $type_list ne 'Publish'}is-active{/if} v2-tab">
					<i aria-hidden="true"></i>{$core->get_Lang('All')} <span>({$number_all})</span>
				</a>
				<a href="{$PCMS_URL}/?mod={$mod}&type_list=Publish"
					class="booking-status-tab v2-status-tab v2-status-tab--success {if $type_list eq 'Publish'}is-active{/if} v2-tab">
					<i aria-hidden="true"></i>{$core->get_Lang('Publish')} <span>({$number_item})</span>
				</a>
				<a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash"
					class="booking-status-tab v2-status-tab v2-status-tab--danger booking-status-tab--trash {if $type_list eq 'Trash'}is-active{/if} v2-tab">
					<i aria-hidden="true"></i>{$core->get_Lang('Trash')} <span>({$number_trash})</span>
				</a>
				<a class="booking-bulk-delete btn-delete-all v2-tabs-delete" id="btn_delete" clsTable="Discount"
					style="display:none">
					<i class="fa fa-trash" aria-hidden="true"></i>{$core->get_Lang('Delete')}
				</a>
			{/capture}
			{include file="../components/list_v2/status_tabs.tpl"
                status_tabs_label=$core->get_Lang('status')
                status_tabs_content=$smarty.capture.hotel_status_tabs
            }
			<div class="booking-list-toolbar__right">
				{capture name=hotel_records_query}?mod={$mod}{$hotelRecordPerPageFilterUrl}{/capture}
				{include file="../components/list_v2/records_per_page.tpl"
                    records_per_page_id="hotel_records_per_page"
                    records_per_page_label=$core->get_Lang('Records per page')
                    records_per_page_value=$recordPerPage
                    records_per_page_base_url=$PCMS_URL
                    records_per_page_query=$smarty.capture.hotel_records_query
                }
			</div>
		</div>

		<section class="list-table-v2-card booking-table-card v2-table-card">
			<div class="list-table-v2-scroll booking-table-scroll v2-table-scroll">
				<table class="list-table-v2 hotel-list-table v2-table">
					<thead>
						<tr>
							<th class="list-table-v2-check booking-check-cell"><input id="check_all" type="checkbox"
									class="el-checkbox" aria-label="{$core->get_Lang('Select all')}" /></th>
							<th class="list-table-v2-location">{$core->get_Lang('Code')}</th>
							<th class="list-table-v2-name">{$core->get_Lang('Name')}</th>
							<th class="list-table-v2-location">{$core->get_Lang('Type')}</th>
							<th class="list-table-v2-location">{$core->get_Lang('Discount')}</th>
							<th class="list-table-v2-location">{$core->get_Lang('Validity period')}</th>
							<th class="list-table-v2-location">{$core->get_Lang('Used')}</th>
							<th class="list-table-v2-public is-center">{$core->get_Lang('Status')}</th>
							<th class="list-table-v2-action is-center list-table-action-cell">
								{$core->get_Lang('Action')}</th>
						</tr>
					</thead>
					{if !empty($allItem)}
						<tbody id="SortAble" class="sortByTd">
							{section name=i loop=$allItem}
								{assign var=discount_id value=$allItem[i].discount_id}
								{assign var=linkEdit value="{$PCMS_URL}/{$mod}/insert/{$discount_id}"}
								{assign var="more_information" value=$allItem[i].more_information|json_decode:true}
								{assign var="discount_type" value=$more_information.discount_type}
								{assign var="discount_value" value=$more_information.discount_value}

								<td class="list-table-v2-check booking-check-cell">
									<input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$discount_id}" />
								</td>
								<td>
									<span class="tm-code-chip">{$allItem[i].code}<button type="button"
											aria-label="{$allItem[i].code}"><i class="fa-regular fa-copy"></i></button></span>
								</td>
								<td class="list-table-v2-name">
									<div class="list-table-v2-wrap hotel-name-wrap list-table-heading list-table-heading-group">
										<a class="list-table-v2-title hotel-name list-table-link" href="{$linkEdit}"><span
												class="list-table-v2-key list-table-key">#{$discount_id}</span> -
											{$clsClassTable->getTitle($discount_id)}</a>
										{if $allItem[i].is_trash eq '1'}<span
											class="list-table-v2-badge list-table-v2-badge--danger hotel-state hotel-state--trash list-table-badge list-table-badge--danger v2-badge v2-badge--danger">{$core->get_Lang('intrash')}</span>{/if}
										{if $allItem[i].is_online eq '0'}<span
											class="list-table-v2-badge list-table-v2-badge--warning hotel-state hotel-state--private list-table-badge list-table-badge--warning v2-badge v2-badge--warning status_private">{$core->get_Lang('Private')}</span>{/if}
									</div>
									<div class="list-table-v2-meta hotel-meta list-table-meta">{$core->get_Lang('Created')}:
										{$clsISO->formatDateTime($allItem[i].reg_date,'d/m/Y H:i',0)} &nbsp;|&nbsp;
										{$core->get_Lang('Updated')}:
										{$clsISO->formatDateTime($allItem[i].upd_date,'d/m/Y H:i',0)}</div>
								</td>

								<td>
									<span class="tm-type-cell">
										{if $more_information.discount_type == '1'}
											<span class="tm-type-icon tm-type-icon--fixed"><i
													class="fa-solid fa-dollar-sign"></i></span> {$core->get_Lang('Fixed amount')}
										{elseif $more_information.discount_type == '2'}
											<span class="tm-type-icon tm-type-icon--percentage"><i
													class="fa-solid fa-percent"></i></span> {$core->get_Lang('Percentage')}
										{/if}
									</span>
								</td>
								<td class="tm-discount">
									{if $more_information.discount_type == '1'}
										${$discount_value}
									{elseif $more_information.discount_type == '2'}
										{$discount_value}%
									{/if}
								</td>
								<td>
									{$clsISO->convertTimeToText($allItem[i].booking_date_from)}</br>
									{$clsISO->convertTimeToText($allItem[i].booking_date_to)}
								</td>
								<td data-title="{$core->get_Lang('Used')}">
									{$allItem[i].total_used}
								</td>

								<td class="list-table-v2-public is-center">
									{if $smarty.now > $allItem[i].booking_date_to}
										<span class="tm-status-badge tm-status-badge--expired">
											<i class="fa-regular fa-clock"></i>
											{$core->get_Lang('Expired')}
										</span>
									{elseif $smarty.now >= $allItem[i].booking_date_from && $smarty.now <= $allItem[i].booking_date_to}
										<a href="javascript:void(0);" class="SiteClickPublic list-table-v2-toggle list-table-toggle"
											clsTable="Discount" pkey="discount_id" sourse_id="{$discount_id}"
											rel="{$allItem[i].is_online}" title="{$core->get_Lang('Click to change status')}"
											aria-label="{$core->get_Lang('Click to change status')}">
											<span class="list-table-toggle__track" aria-hidden="true"><span
													class="list-table-toggle__thumb"></span></span>
										</a>

									{else}
										<span class="tm-status-badge tm-status-badge--upcoming">
											<i class="fa-solid fa-clock"></i> Upcoming
										</span>
									{/if}
								</td>
								<td class="list-table-v2-action is-center list-table-action-cell">
									<div class="btn-group">
										<button
											class="list-table-v2-action-btn booking-row-menu list-table-action dropdown-toggle v2-action"
											type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
												class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
										<ul class="dropdown-menu dropdown-menu-end">
											{if $allItem[i].is_trash eq '0'}

												<li><a class="dropdown-item" href="javascript:void(0)" onClick="open_discount(this)"
														discount_id="{$allItem[i].discount_id}"><i class="fa fa-edit"></i>
														{$core->get_Lang('edit')}</a></li>
												<li><a class="dropdown-item"
														href="{$PCMS_URL}/?mod={$mod}&act=trash&discount_id={$allItem[i].discount_id}{$pUrl}&page={$currentPage}">
														<i class="fa fa-trash"></i> {$core->get_Lang('trash')}</a>
												</li>
											{else}
												<li>
													<a class="dropdown-item" href="javascript:void(0)" onClick="open_discount(this)"
														discount_id="{$allItem[i].discount_id}">
														<i class="fa fa-edit"></i>
														{$core->get_Lang('edit')}
													</a>
												</li>
												<li><a class="dropdown-item"
														href="{$PCMS_URL}/?mod={$mod}&act=restore&discount_id={$allItem[i].discount_id}{$pUrl}&page={$currentPage}">
														<i class="fa fa-refresh"></i> {$core->get_Lang('restore')}
													</a>
												</li>
												<li><a class="confirm_delete dropdown-item"
														href="{$PCMS_URL}/?mod={$mod}&act=delete&discount_id={$allItem[i].discount_id}{$pUrl}&page={$currentPage}">
														<i class="fa fa-remove"></i>
														{$core->get_Lang('delete')}
													</a>
												</li>
											{/if}
										</ul>
									</div>
								</td>
								</tr>
							{/section}
						</tbody>
					{else}
						<tbody>
							<tr>
								<td colspan="8" class="booking-empty list-table-empty"><i class="fa fa-inbox"
										aria-hidden="true"></i><span>{$core->get_Lang('nodata')}!</span></td>
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
                pagination_entity_label=$core->get_Lang('Codes')
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
	</main>

	<script type="text/javascript">
		var $boxID = '';
		var $cat_id = '{$cat_id}';
		var $city_id = '{$city_id}';
		var $departure_point_id = '{$departure_point_id}';
		var $is_set = '{$is_set}';
		var $recordPerPage = '{$recordPerPage}';
		var $currentPage = '{$currentPage}';
	</script>
	<!-- Insert External Script -->
	<!-- Insert External Script -->
	<link rel="stylesheet" href="{$URL_JS}/jquery-easyui/themes/gray/easyui.css?v={$upd_version}" type="text/css"
		media="screen">
	<script type="text/javascript" src="{$URL_JS}/jquery-easyui/jquery.easyui.min.js?v={$upd_version}"></script>
	<script type="text/javascript" src="{$URL_THEMES}/hotel/jquery.hotel.js?v={$upd_version}"></script>
	{literal}
		<script type="text/javascript">
			function create_discount(button) {
				// Your code to create a new discount
				$.ajax({
					type: 'POST',
					url: path_ajax_script + "/?mod=discount&act=ajCreateNewDiscount",
					dataType: 'json',
					data: {},
					success: function(json) {
						if (json && json.status === 'success') {
							location.href = json.link;
						} else {
							alert('Error creating discount');
						}
					},
					error: function() {
						alert('Error creating discount');
					}
				});
			}

			$(document).on('click', '.tm-code-chip', function(e) {
				e.preventDefault();
				var $chip = $(this);
				// Lấy code từ text, bỏ phần button
				var code = $.trim($chip.clone().find('button').remove().end().text());
				if (!code) return;
				// Copy
				if (navigator.clipboard && window.isSecureContext) {
					navigator.clipboard.writeText(code).then(function() {
						showCopySuccess($chip);
					});
				} else {
					// Fallback cho HTTP / trình duyệt cũ
					var $temp = $('<textarea>');
					$('body').append($temp);
					$temp.val(code)
						.css({
							position: 'fixed',
							left: '-9999px',
							top: '0'
						})
						.select();
					document.execCommand('copy');
					$temp.remove();
					showCopySuccess($chip);
				}
			});

			function showCopySuccess($chip) {
				var $icon = $chip.find('button i');
				var oldClass = $icon.attr('class');

				$icon.attr('class', 'fa-solid fa-check');

				$chip.addClass('is-copied');

				setTimeout(function() {
					$icon.attr('class', oldClass);
					$chip.removeClass('is-copied');
				}, 1500);
			}

			$('#SortAble').sortable({
				items: 'tr',
				handle: 'td.sortable',
				opacity: 0.8,
				cursor: 'move',
				start: function() { vietiso_loading(1); },
				stop: function() { vietiso_loading(0); },
				update: function() {
					var order = $(this).sortable('serialize') + '&update=update&recordPerPage=' + $recordPerPage +
						'&currentPage=' + $currentPage;
					$.post(path_ajax_script + '/index.php?mod=discount&act=ajUpdPosSort', order, function() {
						vietiso_loading(0);
						location.href = REQUEST_URI;
					});
				}
			});
		</script>
	{/literal}
</div>
{literal}
	<style>
		.tm-type-cell {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 13px;
			color: var(--tm-text);
			white-space: nowrap;
		}

		.tm-type-icon {
			width: 26px;
			height: 26px;
			border-radius: 8px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 12px;
			flex-shrink: 0;
		}

		.tm-type-icon--percentage {
			background: var(--color-success-soft);
			color: var(--color-success);
		}

		.tm-type-icon--fixed {
			background: var(--color-primary-soft);
			color: var(--color-primary);
		}

		.tm-discount {
			font-weight: 700;
			color: var(--color-navy);
		}

		.tm-status-badge {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			height: 28px;
			padding: 0 11px;
			border-radius: 999px;
			font-weight: 700;
			white-space: nowrap;
		}

		.tm-status-badge--expired {
			background: var(--color-warning-soft);
			color: #C2410C;
		}
	</style>
{/literal}