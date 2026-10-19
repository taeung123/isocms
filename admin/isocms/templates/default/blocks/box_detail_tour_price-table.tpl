<!-- CONTENT ROW: Price table content | Instructions -->
<div class="tm-tour-content-row">

	<!-- PRICE TABLE -->
	<section class="tm-form-card" id="price-table-detail" aria-labelledby="priceTableHeading">

		<div class="tm-form-card__header">
			<div class="tm-form-card__heading">
				<span class="tm-form-card__icon" aria-hidden="true"><i class="fa-solid fa-tag"></i></span>
				<div class="tm-form-card__titles">
					<h2 id="priceTableHeading">
						{$core->get_Lang('Price table')}
						{assign var= price_table_tour value='price_table_tour_'|cat:$check_lang}
						{if $CHECKHELP eq 1}
							<button data-key="{$price_table_tour}" data-label="{$core->get_Lang('Price Config')}"
								type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="tm-info-dot">i
							</button>
						{/if}
					</h2>
					<p>{$core->get_Lang('Set specific prices for each customer group, age range and pricing class.')}
					</p>
				</div>
			</div>
			{* <div class="tm-form-card__actions">
				<button type="button" class="tm-btn tm-btn--neutral" id="btnCopyFromAnotherTour"><i
						class="fa-regular fa-copy"></i> Copy from another tour</button>
				<button type="button" class="tm-btn tm-btn--icon-only" id="btnPriceTableMore"
					aria-label="More price table options"><i class="fa-solid fa-ellipsis"></i></button>
			</div> *}
		</div>
		<div class="form_option_tour">
			<div id="TourPriceGroupNoDeparture">
				Loading...
			</div>
		</div>
		

	</section>

	<!-- INSTRUCTIONS PANEL (shared component, reused as-is) -->
	{capture assign="instruction_body_vi"}
		<h4>{$core->get_Lang("Về bảng giá")}</h4>
		<p>{$clsConfiguration->getValue('price_table_tour_vi')|html_entity_decode}</p>
	{/capture}
	{capture assign="instruction_body_en"}
		<h4>{$core->get_Lang("About price table")}</h4>
		<p>{$clsConfiguration->getValue('price_table_tour_en')|html_entity_decode}</p>
	{/capture}
	{capture assign="instruction_tip_vi"}
		<div class="tm-tips-box">
			<p class="tm-tips-box__title"><i class="fa-solid fa-lightbulb"></i> Mẹo nhỏ</p>
			<ul class="tm-keynotes-list">
				<li><i class="fa-solid fa-check"></i> Thiết lập giá cho tất cả các nhóm và độ tuổi phù hợp</li>

				<li><i class="fa-solid fa-check"></i> Sử dụng đơn vị tiền tệ thống nhất (USD)</li>

				<li><i class="fa-solid fa-check"></i> Có thể tạo nhiều loại giá (Tiêu chuẩn, Cao cấp, v.v.)</li>

				<li><i class="fa-solid fa-check"></i> Thiết lập phụ thu phòng đơn và tiền đặt cọc nếu áp dụng</li>


			</ul>

		</div>
	{/capture}
	{capture assign="instruction_tip_en"}
		<div class="tm-keynotes-box">
			<p class="tm-keynotes-box__title"><i class="fa-solid fa-lightbulb"></i> Key notes</p>
			<ul class="tm-keynotes-list">
				<li><i class="fa-solid fa-check"></i> Set prices for all relevant groups and age ranges</li>
				<li><i class="fa-solid fa-check"></i> Use consistent currency (USD)</li>
				<li><i class="fa-solid fa-check"></i> You can create multiple pricing classes (Standard, Premium, etc.)
				</li>
				<li><i class="fa-solid fa-check"></i> Set Single Room Addition and Deposit if applicable</li>
			</ul>
		</div>

		<div class="tm-example-section">
			<h4>Example</h4>
			<ul class="tm-example-list">
				<li>Adult (16+): 225 USD</li>
				<li>Child (4–7): 23 USD</li>
				<li>Child (8–12): 44 USD</li>
				<li>Infant (0–3): 55 USD</li>
			</ul>
		</div>
	{/capture}
	{$clsISO->getBlock('box_instructions', [
		'instruction_tip_en' => $instruction_tip_en,
		'instruction_tip_vi' => $instruction_tip_vi,	
		'instruction_body_en' => $instruction_body_en,
		'instruction_body_vi' => $instruction_body_vi
	])}
</div>
{$clsISO->buildFileTpl('tour_iso/edit_footer.tpl', [
    'child_cat_menu_j_index_prev' => $child_cat_menu_j_index_prev,
    'list_cat_menu_prev' => $list_cat_menu_prev,
    'count_child_cat_menu_prev' => $count_child_cat_menu_prev,
    'child_cat_menu_j' => $child_cat_menu_j,
    'child_cat_menu_j_index_next' => $child_cat_menu_j_index_next,
    'list_menu_tour_i_index_next' => $list_menu_tour_i_index_next,
    'child_cat_menu_next' => $child_cat_menu_next,
    'list_cat_menu_next' => $list_cat_menu_next,
    'pvalTable' => $pvalTable,
    'cat_run' => $cat_run,
    'oneItem' => $oneItem
])}

{literal}
	<script type="text/javascript">
		$(document).ready(function() {
			loadTourPriceGroupNoDeparture();
		});
		$(document).on('change', '.deposit_tour_group', function(ev) {
			var $_this = $(this);
			$.ajax({
				type: "POST",
				url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadTourPriceGroup&lang=" + LANG_ID,
				data: {
					'tour_id': $_this.attr("tour_id"),
					"deposit": $_this.val(),
					'tp': 'Save_Deposit'
				},
				dataType: "html",
				success: function(html) {
					var htm = html.split('|||');
					$_this.val(htm[1]);
					vietiso_loading(2);
				}
			});
		});

		$(document).on('change', '.option_status', function(ev) {
			var $_this = $(this);
			var currentStatus = parseInt($_this.val(), 10) || 0; // Đảo trạng thái: 0 -> 1, 1 -> 0 
			var newStatus = currentStatus === 1 ? 0 : 1;
			var $header = $_this.closest('.tm-price-class-card__header'); 
			
			$.ajax({
				type: "POST",
				url: path_ajax_script + "/?mod=" + mod + "&act=ajChangeStatusTourOption&lang=" + LANG_ID,
				data: {
					'tour_option_id': $_this.attr("option_id"),
					"option_status": $_this.val(),
				},
				beforeSend: function () { $_this.prop('disabled', true); },
				dataType: "JSON",
				success: function(json) {
					if(newStatus == 1) {
						$header.addClass('header-active'); 
					} else {
						$header.removeClass('header-active'); 
					}
					$_this.val(newStatus);
					console.log(json.status);
					vietiso_loading(2);
				},
				error: function () { // AJAX lỗi thì rollback 
					$_this.prop('checked', currentStatus === 1); 
					alert('Update failed!'); 
				}, 
				complete: function () { 
					$_this.prop('disabled', false); 
				}
			});
		});
	</script>
{/literal}
{literal}
	<style>
		.tm-form-card {
			flex: 1;
			min-width: 0;
			display: flex;
			flex-direction: column;
			gap: 20px;
		}

		.tm-form-card__header {
			display: flex;
			align-items: flex-start;
			justify-content: space-between;
			gap: 12px;
			flex-wrap: wrap;
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-xl);
			box-shadow: var(--box-shadow-sm);
			padding: 18px 22px;
		}

		.tm-form-card__heading {
			display: flex;
			align-items: flex-start;
			gap: 12px;
			min-width: 0;
		}

		.tm-form-card__icon {
			width: 36px;
			height: 36px;
			border-radius: 10px;
			background: var(--color-primary-soft);
			color: var(--color-primary);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 15px;
			flex-shrink: 0;
		}

		.tm-form-card__titles h2 {
			margin: 0;
			font-size: 17px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-form-card__titles p {
			margin: 3px 0 0;
			font-size: 12.5px;
			color: var(--color-text-secondary);
		}

		.tm-form-card__actions {
			display: flex;
			align-items: center;
			gap: 8px;
			flex-shrink: 0;
		}

		/* ---------- PRICING CLASS CARD ---------- */
		.tm-price-class-card {
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-xl);
			box-shadow: var(--box-shadow-sm);
			overflow: hidden;
			margin-bottom: var(--section-spacing);
		}

		.tm-price-class-card__header {
			display: flex;
			align-items: center;
			gap: 14px;
			padding: 18px 22px;
			flex-wrap: wrap;
		}

		.tm-price-class-card--standard .tm-price-class-card__header {
			background: var(--color-primary-soft);
		}
		.tm-price-class-card--standard .tm-price-class-card__header.header-active {
			background: var(--color-orange-soft);
		}

	
		.tm-price-class-icon {
			width: 40px;
			height: 40px;
			border-radius: var(--border-radius-md);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 17px;
			flex-shrink: 0;
		}

		.tm-price-class-card--standard .tm-price-class-icon {
			background: #D6E4FE;
			color: var(--color-primary);
		}

		.tm-price-class-card--standard .tm-price-class-card__header.header-active .tm-price-class-icon {
			background: #FCE0BE;
			color: var(--color-orange);
		}

		

		.tm-price-class-heading {
			flex: 1;
			min-width: 200px;
		}

		.tm-price-class-title-row {
			display: flex;
			align-items: center;
			gap: 10px;
			flex-wrap: wrap;
		}

		.tm-price-class-title-row strong {
			font-size: 15.5px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-default-badge {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			height: 22px;
			padding: 0 10px;
			border-radius: 999px;
			background: var(--color-orange);
			color: #fff;
			font-size: 11px;
			font-weight: 700;
		}

		.tm-price-class-heading p {
			margin: 2px 0 0;
			font-size: 12.5px;
			color: var(--color-text-secondary);
		}

		.tm-price-class-card__controls {
			display: flex;
			align-items: center;
			gap: 12px;
			flex-shrink: 0;
		}

		.tm-active-label {
			font-size: 13px;
			font-weight: 600;
			color: var(--color-text);
		}

		.tm-row-menu-btn {
			width: 32px;
			height: 32px;
			border: none;
			background: transparent;
			border-radius: 8px;
			color: var(--color-text-secondary);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 14px;
		}

		.tm-row-menu-btn:hover {
			background: rgba(15, 23, 42, 0.06);
			color: var(--color-text);
		}

		/* pricing table */
		.table-responsive {
			overflow-x: auto;
		}

		.tm-price-table {
			width: 100%;
			border-collapse: collapse;
		}

		.tm-price-table th {
			text-align: left;
			font-size: 12.5px;
			font-weight: 700;
			color: var(--color-text);
			padding: 12px 22px;
			border-bottom: 1px solid var(--color-border-light);
			white-space: nowrap;
		}

		.tm-price-table td {
			padding: 12px 22px;
			border-bottom: 1px solid var(--color-border-light);
			font-size: 13.5px;
			color: var(--color-text);
			vertical-align: middle;
		}

		.tm-price-table tr:last-child td {
			border-bottom: none;
		}

		.tm-price-table th.col-price,
		.tm-price-table td.col-price {
			width: 220px;
		}

		.tm-price-table th.col-menu,
		.tm-price-table td.col-menu {
			width: 44px;
		}

		.tm-customer-group-cell {
			display: flex;
			align-items: center;
			gap: 10px;
			font-weight: 600;
		}

		.tm-cg-icon {
			width: 30px;
			height: 30px;
			border-radius: 999px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 13px;
			flex-shrink: 0;
		}

		.tm-cg-icon--adult {
			background: var(--color-primary-soft);
			color: var(--color-primary);
		}

		.tm-cg-icon--children {
			background: var(--color-orange-soft);
			color: var(--color-orange);
		}

		.tm-cg-icon--infant {
			background: var(--color-purple-soft);
			color: var(--color-purple);
		}

		.tm-price-input-group {
			display: flex;
			align-items: center;
			height: 40px;
			border: 1px solid var(--color-border);
			border-radius: var(--border-radius-md);
			overflow: hidden;
			max-width: 190px;
		}

		.tm-price-input-group input {
			flex: 1;
			min-width: 0;
			height: 100%;
			border: none;
			padding: 0 12px;
			font-size: 13.5px;
			color: var(--color-text);
			text-align: right;
			background: var(--color-surface);
		}

		.tm-price-input-group input:focus {
			outline: none;
		}

		.tm-price-input-group:focus-within {
			border-color: var(--color-primary);
			box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
		}

		.tm-price-input-group__suffix {
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100%;
			padding: 0 10px;
			background: var(--color-page);
			color: var(--color-text-secondary);
			font-size: 12px;
			font-weight: 700;
			border-left: 1px solid var(--color-border);
			flex-shrink: 0;
		}

		.tm-add-row-wrap {
			padding: 16px 22px 22px;
		}

		.tm-btn--add-row {
			width: 100%;
			height: 44px;
			justify-content: center;
			border-radius: var(--border-radius-md);
			font-size: 13px;
			font-weight: 700;
		}

		.tm-btn--add-row--orange {
			background: var(--color-orange-soft);
			color: var(--color-orange);
			border: 1px solid #FBD9AE;
		}

		.tm-btn--add-row--orange:hover {
			background: #FCE3C4;
		}

		.tm-btn--add-row--blue {
			background: var(--color-primary-soft);
			color: var(--color-primary);
			border: 1px solid #C7D9FB;
		}

		.tm-btn--add-row--blue:hover {
			background: #DCE9FF;
		}

		/* additional settings */
		.tm-additional-settings {
			background: var(--color-primary-soft);
			border-radius: var(--border-radius-xl);
			padding: 18px 22px;
		}

		.tm-additional-settings__header {
			display: flex;
			align-items: center;
			gap: 10px;
			margin-bottom: 16px;
		}

		.tm-additional-settings__header i {
			color: var(--color-primary);
			font-size: 15px;
		}

		.tm-additional-settings__header strong {
			font-size: 14.5px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-additional-settings__grid {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 20px;
		}

		.tm-as-field {
			display: flex;
			flex-direction: column;
			gap: 6px;
		}

		.tm-as-field label {
			font-size: 13px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-as-input-group {
			display: flex;
			align-items: center;
			height: 44px;
			border: 1px solid var(--color-border);
			border-radius: var(--border-radius-md);
			overflow: hidden;
			background: var(--color-surface);
		}

		.tm-as-input-group input {
			flex: 1;
			min-width: 0;
			height: 100%;
			border: none;
			padding: 0 14px;
			font-size: 14px;
			color: var(--color-text);
			background: transparent;
		}

		.tm-as-input-group input:focus {
			outline: none;
		}

		.tm-as-input-group:focus-within {
			border-color: var(--color-primary);
			box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
		}

		.tm-as-input-group__suffix {
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100%;
			padding: 0 12px;
			background: var(--color-page);
			color: var(--color-text-secondary);
			font-size: 12.5px;
			font-weight: 700;
			border-left: 1px solid var(--color-border);
			flex-shrink: 0;
		}

		.tm-as-hint {
			margin: 0;
			font-size: 12px;
			color: var(--color-text-secondary);
		}

		.tm-keynotes-box {
			margin-top: 16px;
			background: var(--color-warning-soft);
			border-radius: var(--border-radius-md);
			padding: 14px;
		}

		.tm-keynotes-box__title {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 12.5px;
			font-weight: 700;
			color: #92610A;
			margin: 0 0 10px;
		}

		.tm-keynotes-box__title i {
			color: var(--color-warning);
		}

		.tm-keynotes-list {
			list-style: none;
			margin: 0;
			padding: 0;
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.tm-keynotes-list li {
			display: flex;
			align-items: flex-start;
			gap: 8px;
			font-size: 12.5px;
			color: #7A5209;
			line-height: 1.5;
		}

		.tm-keynotes-list i {
			color: var(--color-success);
			font-size: 12px;
			margin-top: 2px;
			flex-shrink: 0;
		}

		.tm-example-section {
			margin-top: 16px;
		}

		.tm-example-section h4 {
			font-size: 13.5px;
			font-weight: 700;
			margin: 0 0 8px;
			color: var(--color-primary-dark);
		}

		.tm-example-list {
			list-style: none;
			margin: 0;
			padding: 0;
			display: flex;
			flex-direction: column;
			gap: 7px;
		}

		.tm-example-list li {
			display: flex;
			align-items: flex-start;
			gap: 8px;
			font-size: 12.5px;
			color: var(--color-text);
			line-height: 1.5;
		}

		.tm-example-list li::before {
			content: "";
			width: 4px;
			height: 4px;
			border-radius: 999px;
			background: var(--color-text-muted);
			margin-top: 7px;
			flex-shrink: 0;
		}

		/* =========================================================
   RESPONSIVE
   ========================================================= */
		@media (max-width: 1280px) {}

		@media (max-width: 1180px) {}

		@media (max-width: 1024px) {}

		@media (max-width: 900px) {}

		@media (max-width: 768px) {
			.iso-tour-pricetable {
				padding: 16px 14px 110px;
			}

			.tm-price-class-card__header {
				flex-direction: column;
				align-items: stretch;
			}

			.tm-price-class-card__controls {
				justify-content: space-between;
				width: 100%;
			}

			.tm-additional-settings__grid {
				grid-template-columns: 1fr;
			}

			.tm-as-input-group {
				max-width: none;
			}

		}

		@media (max-width: 576px) {

		}

		@media (prefers-reduced-motion: reduce) {
			.iso-tour-pricetable * {
				transition: none !important;
			}
		}
	</style>
{/literal}