<!-- ITINERARY WORKSPACE + INSTRUCTIONS -->
<div class="tm-tour-content-row">

	<main class="tm-itinerary-workspace" id="itinerary">

		<!-- ITINERARY HEADER -->
		<section class="tm-itinerary-header">
			<div class="tm-itinerary-header__heading">
				<span class="tm-itinerary-header__icon" aria-hidden="true"><i class="fa-regular fa-calendar"></i></span>
				<div class="tm-itinerary-header__titles">
					<h2>
						{$core->get_Lang("Itinerary")}
						{assign var=itinerary_tour value='itinerary_tour_'|cat:$check_lang}
						{if $CHECKHELP|default:0 eq 1}
							<button data-key="{$itinerary_tour}" data-label="{$core->get_Lang('Itinerary')|escape:'html'}"
								type="button" title="{$core->get_Lang('Add description')|escape:'html'}"
								onclick="open_texthelp(this, event)" class="tm-info-dot">i</button>
						{/if}
					</h2>
					<p>{$core->get_Lang("Create and manage the day-by-day itinerary for this tour.")}</p>
					<div class="text_help" hidden>
						{$clsConfiguration->getValue($itinerary_tour)|html_entity_decode}
					</div>
				</div>
			</div>
			<div class="tm-itinerary-header__actions" role="group" aria-label="Itinerary actions">
				{* <button type="button" class="tm-btn tm-btn--neutral" id="btnReorder"><i
						class="fa-solid fa-arrows-up-down-left-right"></i> Reorder</button>
				<button type="button" class="tm-btn tm-btn--neutral" id="btnPreviewItinerary"><i
						class="fa-regular fa-eye"></i> Preview Itinerary</button> *}
				<a class="tm-btn tm-btn--add-day" href="javascript:void(0);" id="clickToAddItinerary">
					<i class="fa-solid fa-plus"></i> {$core->get_Lang("Add Day")}
				</a>
			</div>
		</section>

		<!-- DAY CARDS -->
		<div class="tm-itinerary-list" id="tblTourItinerary">


		</div>

	</main>

	<!-- INSTRUCTIONS PANEL (shared component, reused as-is) -->
	{capture assign="instruction_body_vi"}
		<h4>{$core->get_Lang("Về lịch trình")}</h4>
		<p>{$clsConfiguration->getValue('itinerary_tour_vi')|html_entity_decode}</p>
	{/capture}
	{capture assign="instruction_body_en"}
		<h4>{$core->get_Lang("About Itinerary")}</h4>
		<p>{$clsConfiguration->getValue('itinerary_tour_en')|html_entity_decode}</p>
	{/capture}
	{capture assign="instruction_tip_vi"}
		<div class="tm-tips-box">

			<p class="tm-tips-box__title">
				<i class="fa-solid fa-lightbulb"></i>
				{$core->get_Lang("Mẹo")}
			</p>

			<ul class="tm-tips-list">

				<li>
					<i class="fa-solid fa-check"></i>
					{$core->get_Lang("Sử dụng tiêu đề rõ ràng và hấp dẫn cho từng ngày")}
				</li>

				<li>
					<i class="fa-solid fa-check"></i>
					{$core->get_Lang("Bao gồm các hoạt động chính và điểm nổi bật")}
				</li>

				<li>
					<i class="fa-solid fa-check"></i>
					{$core->get_Lang("Ghi rõ các bữa ăn: sáng, trưa, tối")}
				</li>

				<li>
					<i class="fa-solid fa-check"></i>
					{$core->get_Lang("Đề cập đến nơi lưu trú nếu có")}
				</li>

				<li>
					<i class="fa-solid fa-check"></i>
					{$core->get_Lang("Giữ phần mô tả ngắn gọn và hấp dẫn")}
				</li>

			</ul>

		</div>


		<div class="tm-encourage-box">

			<p class="tm-encourage-box__title">
				{$core->get_Lang("Lịch trình tốt = nhiều lượt đặt tour hơn!")}
			</p>

			<p>
				{$core->get_Lang("Một lịch trình rõ ràng, chi tiết và truyền cảm hứng giúp khách hàng hiểu rõ trải nghiệm và khuyến khích họ đặt tour.")}
			</p>

		</div>
	{/capture}
	{capture assign="instruction_tip_en"}
		<div class="tm-tips-box">

			<p class="tm-tips-box__title">
				<i class="fa-solid fa-lightbulb"></i>
				{$core->get_Lang("Tips")}
			</p>

			<ul class="tm-tips-list">

				<li>
					<i class="fa-solid fa-check"></i>
					{$core->get_Lang("Use clear and attractive titles for each day")}
				</li>

				<li>
					<i class="fa-solid fa-check"></i>
					{$core->get_Lang("Include main activities and highlights")}
				</li>

				<li>
					<i class="fa-solid fa-check"></i>
					{$core->get_Lang("Specify meals (breakfast, lunch, dinner)")}
				</li>

				<li>
					<i class="fa-solid fa-check"></i>
					{$core->get_Lang("Mention accommodation (if any)")}
				</li>

				<li>
					<i class="fa-solid fa-check"></i>
					{$core->get_Lang("Keep descriptions concise and engaging")}
				</li>

			</ul>

		</div>


		<div class="tm-encourage-box">

			<p class="tm-encourage-box__title">
				{$core->get_Lang("Good itinerary = more bookings!")}
			</p>

			<p>
				{$core->get_Lang("A clear, detailed, and inspiring itinerary helps customers understand the experience and encourages them to book.")}
			</p>

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
	<script>
		loadTourItinerary($tour_id);
		loadTourItineraryContingency(tour_id);
	</script>
{/literal}
{literal}
	<style>
		/* Itinerary workspace + instructions row */
		

		/* ---------- ITINERARY WORKSPACE ---------- */
		.tm-itinerary-workspace {
			flex: 1;
			min-width: 0;
			display: flex;
			flex-direction: column;
			gap: 16px;
		}

		.tm-itinerary-header {
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-xl);
			box-shadow: var(--color-shadow-sm);
			padding: 18px 20px;
			display: flex;
			align-items: flex-start;
			justify-content: space-between;
			gap: 16px;
			flex-wrap: wrap;
		}

		.tm-itinerary-header__heading {
			display: flex;
			align-items: flex-start;
			gap: 12px;
			min-width: 0;
		}

		.tm-itinerary-header__icon {
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

		.tm-itinerary-header__titles h2 {
			margin: 0;
			font-size: 15.5px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-itinerary-header__titles p {
			margin: 3px 0 0;
			font-size: 12.5px;
			color: var(--color-text-secondary);
			max-width: 46ch;
		}

		.tm-itinerary-header__actions {
			display: flex;
			align-items: center;
			gap: 8px;
			flex-wrap: wrap;
		}

		.tm-btn--add-day {
			background: var(--color-primary);
			color: #fff;
		}

		.tm-btn--add-day:hover {
			background: var(--color-primary-dark);
		}

		/* ---------- DAY CARD LIST ---------- */
		.tm-itinerary-list {
			display: flex;
			flex-direction: column;
			gap: 14px;
		}

		.tm-day-card {
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-lg);
			box-shadow: var(--color-shadow-sm);
			padding: 16px;
			display: flex;
			align-items: flex-start;
			gap: 14px;
			transition: border-color 160ms ease, box-shadow 160ms ease;
		}

		.tm-day-card:hover {
			border-color: #D6E0EE;
			box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
		}

		.tm-day-card__handle {
			flex-shrink: 0;
			width: 20px;
			height: 100%;
			min-height: 88px;
			display: flex;
			align-items: center;
			justify-content: center;
			color: var(--color-text-muted);
			font-size: 15px;
			cursor: grab;
			touch-action: none;
			border: none;
			background: transparent;
			padding: 0;
		}

		.tm-day-card__handle:active {
			cursor: grabbing;
		}

		.tm-day-card__handle:hover {
			color: var(--color-text-secondary);
		}

		.tm-day-card__number {
			flex-shrink: 0;
			width: 50px;
			text-align: center;
			background: var(--color-page);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-md);
			padding: 7px 8px;
		}

		.tm-day-card__number-label {
			font-size: 10.5px;
			font-weight: 700;
			letter-spacing: .06em;
			color: var(--color-text-muted);
			text-transform: uppercase;
		}

		.tm-day-card__number-value {
			font-size: 22px;
			font-weight: 700;
			color: var(--color-navy);
			line-height: 1.1;
			margin: 2px 0 6px;
		}

		.tm-day-card__date {
			font-size: 11.5px;
			color: var(--color-text-secondary);
			line-height: 1.4;
		}

		.tm-day-card__date strong {
			display: block;
			font-weight: 600;
			color: var(--color-text);
		}

		.tm-day-card__image {
			position: relative;
			flex-shrink: 0;
			width: 75px;
			aspect-ratio: 4/3;
			border-radius: var(--border-radius-md);
			overflow: hidden;
			background: var(--color-border-light);
		}

		.tm-day-card__image.image_hidden:before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: var(--color-text);
			opacity: 0.5;
		}

		.tm-day-card__image img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			display: block;
		}

		.tm-day-card__image--empty {
			display: flex;
			align-items: center;
			justify-content: center;
			color: var(--color-text-muted);
			font-size: 20px;
		}

		.tm-day-card__body {
			flex: 1;
			min-width: 0;
		}

		.tm-day-card__title {
			margin: 2px 0 6px;
			font-size: 15px;
			font-weight: 700;
			color: var(--color-navy);
			line-height: 1.35;
			text-transform: uppercase;
			letter-spacing: .01em;
			overflow-wrap: break-word;
		}

		.tm-day-card__title a {
			color: inherit;
		}

		.tm-day-card__title a:hover {
			color: var(--color-primary);
		}

		.tm-day-card__meals {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: 6px;
			font-size: 12.5px;
			color: var(--color-text-secondary);
			font-weight: 500;
			margin-bottom: 6px;
		}

		.tm-day-card__meals i {
			font-size: 12px;
			color: var(--color-text-muted);
		}

		.tm-day-card__desc {
			margin: 0;
			font-size: 13px;
			color: var(--color-text-secondary);
			line-height: 1.55;
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}

		.tm-day-card__side {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: center;
			gap: 10px;
			align-self: stretch;
			justify-content: space-between;
		}

		.tm-day-card__menu {
			width: 32px;
			height: 32px;
			border: none;
			background: transparent;
			border-radius: 8px;
			color: var(--color-text-muted);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 15px;
		}

		.tm-day-card__menu:hover {
			background: var(--color-page);
			color: var(--color-text);
		}

		.tm-day-card__expand {
			width: 32px;
			height: 32px;
			border: none;
			background: transparent;
			border-radius: 8px;
			color: var(--color-text-muted);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 13px;
			transition: transform 160ms ease, background 160ms ease;
		}

		.tm-day-card__expand:hover {
			background: var(--color-page);
			color: var(--color-text);
		}

		.tm-day-card__expand[aria-expanded="true"] {
			transform: rotate(180deg);
		}

		/* ---------- ADD DAY ---------- */
		.tm-add-day {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			gap: 4px;
			width: 100%;
			padding: 22px 16px;
			border: 1.5px dashed #B9D2FA;
			border-radius: var(--border-radius-lg);
			background: var(--color-primary-soft);
			color: var(--color-primary);
			transition: background 160ms ease, border-color 160ms ease;
		}

		.tm-add-day:hover {
			background: #DCE9FF;
			border-color: var(--color-primary);
		}

		.tm-add-day__label {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 14.5px;
			font-weight: 700;
		}

		.tm-add-day__hint {
			font-size: 12.5px;
			color: var(--color-primary-dark);
			font-weight: 500;
			opacity: .85;
		}

		/* ---------- EMPTY STATE ---------- */
		.tm-itinerary-empty {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			text-align: center;
			gap: 6px;
			padding: 56px 24px;
			background: var(--color-surface);
			border: 1px dashed var(--color-border);
			border-radius: var(--border-radius-xl);
		}

		.tm-itinerary-empty i {
			font-size: 30px;
			color: var(--color-text-muted);
			margin-bottom: 6px;
		}

		.tm-itinerary-empty h3 {
			margin: 0;
			font-size: 15px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-itinerary-empty p {
			margin: 2px 0 14px;
			font-size: 13px;
			color: var(--color-text-secondary);
			max-width: 40ch;
		}

		/* ---------- INSTRUCTIONS PANEL (shared component, reused as-is) ---------- */
		.tm-instructions {
			width: 300px;
			flex-shrink: 0;
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-xl);
			box-shadow: var(--color-shadow-sm);
			padding: 18px;
			position: sticky;
			top: 76px;
			max-height: calc(100vh - 96px);
			overflow-y: auto;
		}

		.tm-instructions__header {
			display: flex;
			align-items: center;
			gap: 10px;
			margin-bottom: 14px;
		}

		.tm-instructions__icon {
			width: 26px;
			height: 26px;
			border-radius: 999px;
			background: var(--color-danger);
			color: #fff;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 12px;
			flex-shrink: 0;
		}

		.tm-instructions__header h3 {
			margin: 0;
			font-size: 14px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-lang-tabs {
			display: flex;
			background: var(--color-page);
			border-radius: 10px;
			padding: 3px;
			margin-bottom: 16px;
		}

		.tm-lang-tab {
			flex: 1;
			border: none;
			background: transparent;
			height: 32px;
			border-radius: 8px;
			font-size: 12.5px;
			font-weight: 700;
			color: var(--color-text-secondary);
		}

		.tm-lang-tab[aria-selected="true"] {
			background: var(--color-surface);
			color: var(--color-primary);
			box-shadow: var(--color-shadow-sm);
		}

		.tm-instructions__body {
			font-size: 13px;
			line-height: 1.6;
			color: var(--color-text);
		}

		.tm-instructions__body h4 {
			font-size: 13px;
			font-weight: 700;
			margin: 0 0 6px;
			color: var(--color-text);
		}

		.tm-instructions__body p {
			margin: 0;
			color: var(--color-text-secondary);
		}

		.tm-tips-box {
			margin-top: 16px;
			background: var(--color-warning-soft);
			border-radius: var(--border-radius-md);
			padding: 14px;
		}

		.tm-tips-box__title {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 12.5px;
			font-weight: 700;
			color: #92610A;
			margin: 0 0 10px;
		}

		.tm-tips-box__title i {
			color: var(--color-warning);
		}

		.tm-tips-list {
			list-style: none;
			margin: 0;
			padding: 0;
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.tm-tips-list li {
			display: flex;
			align-items: flex-start;
			gap: 8px;
			font-size: 12.5px;
			color: #7A5209;
			line-height: 1.5;
		}

		.tm-tips-list i {
			color: var(--color-success);
			font-size: 12px;
			margin-top: 2px;
			flex-shrink: 0;
		}

		.tm-encourage-box {
			margin-top: 14px;
			background: var(--color-success-soft);
			border-radius: var(--border-radius-md);
			padding: 14px;
		}

		.tm-encourage-box__title {
			font-size: 12.5px;
			font-weight: 700;
			color: #14663A;
			margin: 0 0 4px;
		}

		.tm-encourage-box p {
			margin: 0;
			font-size: 12.5px;
			color: #276B4A;
			line-height: 1.5;
		}



		/* =========================================================
   RESPONSIVE
   ========================================================= */
		@media (max-width: 1280px) {
			.tm-instructions {
				width: 270px;
			}

			.tm-day-card__image {
				width: 112px;
			}
		}

		@media (max-width: 1180px) {

			.tm-instructions {
				width: 100%;
				position: static;
				max-height: none;
			}
		}

		@media (max-width: 1024px) {
			.demo-sidebar {
				display: none;
			}

			.demo-hamburger {
				display: inline-flex;
			}

			.tm-tour-layout {
				flex-direction: column;
			}

			.tm-tour-navigation {
				width: 100%;
				position: static;
				padding: 10px;
				max-height: none;
			}

			.tm-tour-navigation__title {
				display: none;
			}

			.tm-setup-nav {
				flex-direction: row;
				overflow-x: auto;
				gap: 6px;
				padding-bottom: 2px;
			}

			.tm-setup-item {
				flex-shrink: 0;
			}
		}

		@media (max-width: 900px) {
			.tm-tour-header {
				flex-wrap: wrap;
			}

			.tm-tour-actions {
				align-items: flex-start;
				width: 100%;
				margin-left: 0;
			}

			.tm-actions-row {
				justify-content: flex-start;
				width: 100%;
			}

			.tm-itinerary-header__actions {
				width: 100%;
			}

			.tm-itinerary-header__actions .tm-btn {
				flex: 1;
				justify-content: center;
			}
		}

		@media (max-width: 768px) {
			.iso-tour-itinerary {
				padding: 16px 14px 110px;
			}

			.tm-day-card {
				flex-wrap: wrap;
			}

			.tm-day-card__handle {
				display: none;
			}

			.tm-day-card__number {
				width: auto;
				display: flex;
				align-items: center;
				gap: 8px;
				text-align: left;
				padding: 8px 12px;
			}

			.tm-day-card__number-value {
				margin: 0;
				font-size: 16px;
			}

			.tm-day-card__date {
				border-left: 1px solid var(--color-border-light);
				padding-left: 8px;
			}

			.tm-day-card__image {
				width: 100%;
				aspect-ratio: 16/9;
				order: 3;
			}

			.tm-day-card__body {
				order: 4;
				width: 100%;
			}

			.tm-day-card__side {
				flex-direction: row;
				align-self: auto;
				margin-left: auto;
			}

			.tm-action-bar {
				flex-direction: column;
				align-items: stretch;
				gap: 10px;
			}

			.tm-action-bar__status {
				justify-content: center;
			}

			.tm-action-bar__right {
				justify-content: space-between;
			}

			.tm-action-bar__right .tm-btn {
				flex: 1;
				justify-content: center;
			}
		}

		@media (max-width: 576px) {
			.tm-tour-header {
				flex-direction: column;
				padding: 16px;
			}

			.tm-tour-thumb-wrap {
				width: 100%;
			}

			.tm-tour-header__decor,
			.tm-header-decor-svg {
				display: none;
			}

			.tm-tour-identity {
				width: 100%;
			}

			.tm-tour-title {
				max-width: none;
			}

			.tm-tour-actions {
				gap: 10px;
			}

			.tm-tour-actions__toggle {
				width: 100%;
				justify-content: space-between;
			}

			.tm-actions-row {
				display: grid;
				grid-template-columns: 1fr 1fr;
				width: 100%;
				gap: 8px;
			}

			.tm-btn--primary {
				grid-column: span 2;
			}

			.tm-itinerary-header {
				flex-direction: column;
				align-items: stretch;
			}

			.tm-day-card__desc {
				-webkit-line-clamp: 3;
			}
		}

		@media (prefers-reduced-motion: reduce) {
			.iso-tour-itinerary * {
				transition: none !important;
			}
		}

		.visually-hidden {
			position: absolute !important;
			width: 1px;
			height: 1px;
			padding: 0;
			margin: -1px;
			overflow: hidden;
			clip: rect(0, 0, 0, 0);
			white-space: nowrap;
			border: 0;
		}
	</style>
{/literal}