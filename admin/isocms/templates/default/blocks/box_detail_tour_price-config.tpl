<!-- CONTENT ROW: Price Config form | Instructions -->
<div class="tm-tour-content-row">

	<!-- PRICE CONFIG FORM -->
	<section class="tm-form-card" id="price-config" aria-labelledby="priceConfigHeading">
		<div class="tm-form-card__header">
			<span class="tm-form-card__icon" aria-hidden="true"><i class="fa-solid fa-dollar-sign"></i></span>
			<div class="tm-form-card__titles">
				<h2 id="priceConfigHeading">
					{$core->get_Lang('Price Config')}
					{assign var= price_config_tour value='price_config_tour_'|cat:$check_lang}
					{if $CHECKHELP eq 1}
						<button data-key="{$price_config_tour}" data-label="{$core->get_Lang('Price Config')}" type="button"
							title="Thêm mô tả" onclick="open_texthelp(this, event)" class="tm-info-dot">i
						</button>
					{/if}
				</h2>
				<p>{$core->get_Lang('Configure pricing types and customer groups for this tour.')}</p>
			</div>
		</div>

		<!-- SECTION 1: PRICE CLASS -->
		<div class="tm-subcard">
			<div class="tm-subcard__header">
				<div class="tm-subcard__heading">
					<span class="tm-numbered-icon" aria-hidden="true">1</span>
					<div class="tm-subcard__titles">
						<strong>{$core->get_Lang('Price class')} <span class="required">*</span></strong>
						<p>{$core->get_Lang('Select the pricing classes that apply to this tour.')}</p>
					</div>
				</div>
				<a target="_blank" href="{$PCMS_URL}/?&mod=tour_exhautive&act=property&type=TOUROPTION" class="tm-link"
					id="lnkManagePriceClasses"><i class="fa-solid fa-gear"></i>
					{$core->get_Lang('Manage price classes')}</a>
			</div>

			<div id="slb_ContainerTourOption">
				<select name="tour_option[]" id="tour_option" class="chosen-select required" multiple="multiple">
					{assign var = selected value = $oneItem.tour_option}
					{$clsTourOption->makeSelectboxOption2($selected,'TOUROPTION',0)}
					{$selected}
				</select>
			</div>
		</div>

		<!-- SECTION 2: GROUP SIZE -->
		<div class="tm-subcard">
			<div class="tm-subcard__header">
				<div class="tm-subcard__heading">
					<span class="tm-numbered-icon" aria-hidden="true"><i class="fa-solid fa-user-group"
							style="font-size:12px;"></i></span>
					<div class="tm-subcard__titles">
						<strong>{$core->get_Lang('Group size')}</strong>
						<p>{$core->get_Lang('Set the number of participants for each customer group and age range.')}
						</p>
					</div>
				</div>
			</div>

			<!-- ADULTS -->
			<div class="tm-group-block">
				<div class="tm-group-header">
					<span class="tm-group-icon" aria-hidden="true"><i class="fa-solid fa-person"></i></span>
					<span class="tm-group-title">{$core->get_Lang('Adults')}</span>
					<span class="tm-age-pill">{$core->get_Lang('Age')}: 16 {$core->get_Lang('years')}+</span>
					<a target="_blank" href="{$PCMS_URL}/?&mod=tour_exhautive&act=property&type=SIZEGROUP"
						class="tm-link" id="lnkManageAdults"><i class="fa-solid fa-gear"></i>
						{$core->get_Lang('Manage')}</a>
				</div>
				<div class="tm-group-content">
					<div id="slb_ContainerAdultSizeGroup" class="mb-3">
						<select name="adult_size_group[]" id="adult_size_group"
							class="chosen-select js-size-group required" multiple="multiple">
							{assign var = selected value = $oneItem.adult_group_size}
							{$clsTourOption->makeSelectboxOption2($selected,'SIZEGROUP',$adult_type_id)}
							{$selected}
						</select>
					</div>
					<div class="tm-field-rows"></div>
				</div>
				{* <div class="tm-info-banner">
					<i class="fa-solid fa-circle-info"></i>
					<span>{$core->get_Lang('Enter the minimum and maximum number of adults per group.')}</span>
				</div> *}
			</div>

			<!-- CHILDREN -->
			<div class="tm-group-block">
				<div class="tm-group-header">
					<span class="tm-group-icon" aria-hidden="true"><i class="fa-solid fa-child"></i></span>
					<span class="tm-group-title">{$core->get_Lang('Children')}</span>
					<a target="_blank" href="{$PCMS_URL}/?&mod=tour_exhautive&act=property&type=SIZEGROUP"
						class="tm-link" id="lnkManageChildren"><i class="fa-solid fa-gear"></i>
						{$core->get_Lang('Manage')}</a>
				</div>
				<div class="tm-group-content">
					<div id="slb_ContainerChildSizeGroup" class="mb-3">
						<select name="child_size_group[]" id="child_size_group"
							class="chosen-select js-size-group required" multiple="multiple">
							{assign var = selected value = $oneItem.child_group_size}
							{$clsTourOption->makeSelectboxOption2($selected,'SIZEGROUP',$child_type_id)}
							{$selected}
						</select>
					</div>
					<div class="tm-field-rows"></div>
				</div>
			</div>

			<!-- INFANTS -->
			<div class="tm-group-block">
				<div class="tm-group-header">
					<span class="tm-group-icon" aria-hidden="true"><i class="fa-solid fa-baby"></i></span>
					<span class="tm-group-title">{$core->get_Lang("Infants")}</span>
					<span class="tm-age-pill">{$core->get_Lang("Age")}: 0 - 3 {$core->get_Lang("years")}</span>
					<a target="_blank" href="{$PCMS_URL}/?&mod=tour_exhautive&act=property&type=SIZEGROUP"
						class="tm-link" id="lnkManageInfants"><i class="fa-solid fa-gear"></i> Manage</a>
				</div>

				<div class="tm-group-content">
					<div id="slb_ContainerInfantSizeGroup" class="mb-3">
						<select name="infant_size_group[]" id="infant_size_group"
							class="chosen-select js-size-group required" multiple="multiple">
							{assign var = selected value = $oneItem.infant_group_size}
							{$clsTourOption->makeSelectboxOption2($selected,'SIZEGROUP',$infant_type_id)}
							{$selected}
						</select>
					</div>
					<div class="tm-field-rows"></div>
				</div>
			</div>

		</div>
	</section>

	<!-- INSTRUCTIONS PANEL (shared component, reused as-is) -->
	{capture assign="instruction_body_vi"}
		<h4>{$core->get_Lang("Về cấu hình giá")}</h4>
		<p>{$clsConfiguration->getValue('price_config_tour_vi')|html_entity_decode}</p>
	{/capture}
	{capture assign="instruction_body_en"}
		<h4>{$core->get_Lang("About price configuration")}</h4>
		<p>{$clsConfiguration->getValue('price_config_tour_en')|html_entity_decode}</p>
	{/capture}
	{capture assign="instruction_tip_vi"}
		<div class="tm-tips-box">
			<p class="tm-tips-box__title"><i class="fa-solid fa-lightbulb"></i> Mẹo nhỏ</p>
			<ul class="tm-tips-list">
				<li><i class="fa-solid fa-check"></i> Chọn khoảng độ tuổi phù hợp</li>
				<li><i class="fa-solid fa-check"></i> Thiết lập số lượng khách tối thiểu/tối đa hợp lý</li>
				<li><i class="fa-solid fa-check"></i> Sử dụng các nhóm giá rõ ràng và nhất quán</li>
				<li><i class="fa-solid fa-check"></i> Các thiết lập này sẽ được sử dụng trong bảng giá</li>
			</ul>
		</div>
	{/capture}
	{capture assign="instruction_tip_en"}
		<div class="tm-tips-box">
			<p class="tm-tips-box__title"><i class="fa-solid fa-lightbulb"></i> Tips</p>
			<ul class="tm-tips-list">
				<li><i class="fa-solid fa-check"></i> Choose appropriate age ranges</li>
				<li><i class="fa-solid fa-check"></i> Set realistic min/max group size</li>
				<li><i class="fa-solid fa-check"></i> Use clear and consistent pricing classes</li>
				<li><i class="fa-solid fa-check"></i> This configuration will be used in the pricing table</li>
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
	<script>
		$(document).ready(function() {

			$('.js-size-group').each(function() {

				var $select = $(this);

				// Tìm container tương ứng trong cùng group
				var $container = $select
					.closest('.tm-group-content')
					.find('.tm-field-rows');

				// Tạo header nếu chưa có
				if (!$container.find('.tm-child-rows-header').length) {
					$container.prepend(`
                <div class="tm-child-rows-header">
                    <div class="tm-child-rows-header__label">
                        Size
                    </div>
                    <div class="tm-child-rows-header__label">
                        Min Pax
                    </div>
                    <div class="tm-child-rows-header__label">
                        Max Pax
                    </div>
                </div>
            `);
				}

				function renderChildRows() {

					var selectedValues = ($select.val() || []).map(String);

					// Xóa những row không còn được chọn
					$container.find('.tm-child-row').each(function() {

						var optionId = String($(this).data('option-id'));

						if ($.inArray(optionId, selectedValues) === -1) {
							$(this).remove();
						}
					});

					// Thêm row cho các option đang được chọn
					$select.find('option:selected').each(function() {

						var $option = $(this);
						var optionId = String($option.val());

						// Nếu đã có row thì không tạo lại
						if (
							$container.find(
								'.tm-child-row[data-option-id="' + optionId + '"]'
							).length
						) {
							return;
						}

						var title = $.trim($option.text()).replace(/^--\s*/, '');
						var min = $option.attr('min') || '';
						var max = $option.attr('max') || '';

						var rowHtml = `
<div class="tm-child-row" data-option-id="${optionId}">

                        <span class="tm-child-row__label">
${title}
                        </span>

                        <div class="tm-select-wrap">
                            <input
                                type="text"
                                class="form-control"
value="${min}"
                                readonly
aria-label="Min pax for ${title}"
                            >
                        </div>

                        <div class="tm-select-wrap">
                            <input
                                type="text"
                                class="form-control"
value="${max}"
                                readonly
aria-label="Max pax for ${title}"
                            >
                        </div>

                    </div>
                `;

						$container.append(rowHtml);
					});
				}

				// Khi select thay đổi
				$select.on('change', function() {
					renderChildRows();
				});

				// Render dữ liệu đã selected khi load trang
				renderChildRows();

			});

		});
	</script>
{/literal}
{literal}
	<style>
		.tm-form-card__header {
			display: flex;
			align-items: flex-start;
			gap: 12px;
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

		.tm-form-card__titles p {
			margin: 3px 0 0;
			font-size: 12.5px;
			color: var(--color-text-secondary);
		}

		/* ---------- subcard (Price class / Group size) ---------- */
		.tm-subcard {
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-lg);
			padding: 18px 20px;
		}

		.tm-subcard__header {
			display: flex;
			align-items: flex-start;
			justify-content: space-between;
			gap: 12px;
			margin-bottom: 16px;
			flex-wrap: wrap;
		}

		.tm-subcard__heading {
			display: flex;
			align-items: flex-start;
			gap: 12px;
			min-width: 0;
		}

		.tm-numbered-icon {
			width: 32px;
			height: 32px;
			border-radius: 999px;
			background: var(--color-primary-soft);
			color: var(--color-primary);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 14px;
			font-weight: 700;
			flex-shrink: 0;
		}

		.tm-subcard__titles strong {
			font-size: 14.5px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-subcard__titles strong .required {
			color: var(--color-danger);
		}

		.tm-subcard__titles p {
			margin: 2px 0 0;
			font-size: 12.5px;
			color: var(--color-text-secondary);
		}

		.tm-link {
			font-size: 12.5px;
			font-weight: 700;
			color: var(--color-primary);
			text-decoration: none;
			flex-shrink: 0;
			display: inline-flex;
			align-items: center;
			gap: 6px;
		}

		.tm-link:hover {
			color: var(--color-primary-dark);
		}

		/* multi-select tag field */
		.tm-tag-select {
			min-height: 48px;
			border: 1px solid var(--color-border);
			border-radius: var(--border-radius-md);
			padding: 8px 38px 8px 12px;
			display: flex;
			flex-wrap: wrap;
			gap: 8px;
			align-items: center;
			position: relative;
			background: var(--color-surface);
		}

		.tm-tag-select:focus-within {
			border-color: var(--color-primary);
			box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
		}

		.tm-tag-select i.fa-chevron-down {
			position: absolute;
			right: 14px;
			top: 50%;
			transform: translateY(-50%);
			font-size: 12px;
			color: var(--color-text-muted);
			pointer-events: none;
		}

		.tm-tag-chip {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			height: 30px;
			padding: 0 8px 0 12px;
			border-radius: 999px;
			background: var(--color-primary-soft);
			color: var(--color-primary-dark);
			font-size: 13px;
			font-weight: 600;
		}

		.tm-tag-chip button {
			border: none;
			background: none;
			color: var(--color-primary);
			width: 18px;
			height: 18px;
			border-radius: 999px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 10px;
		}

		.tm-tag-chip button:hover {
			background: rgba(37, 99, 235, 0.15);
		}

		/* group heading row (Adults/Children/Infants) */
		.tm-group-block {
			padding-top: 18px;
			border-top: 1px solid var(--color-border-light);
			margin-top: 18px;
		}

		.tm-group-block:first-of-type {
			padding-top: 0;
			border-top: none;
			margin-top: 0;
		}

		.tm-group-header {
			display: flex;
			align-items: center;
			gap: 10px;
			margin-bottom: 14px;
			flex-wrap: wrap;
		}

		.tm-group-icon {
			width: 30px;
			height: 30px;
			border-radius: 999px;
			background: var(--color-primary-soft);
			color: var(--color-primary);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 13px;
			flex-shrink: 0;
		}

		.tm-group-title {
			font-size: 14.5px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-age-pill {
			display: inline-flex;
			align-items: center;
			height: 22px;
			padding: 0 10px;
			border-radius: 999px;
			background: var(--color-primary-soft);
			color: var(--color-primary);
			font-size: 11.5px;
			font-weight: 600;
		}

		.tm-group-header .tm-link {
			margin-left: auto;
		}

		.tm-field-row {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 16px;
		}

		.tm-field-block {
			display: flex;
			flex-direction: column;
			gap: 8px;
			min-width: 0;
		}

		.tm-form-label {
			font-size: 13px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-form-label .required {
			color: var(--color-danger);
		}

		.tm-input {
			width: 100%;
			height: 46px;
			border-radius: var(--border-radius-md);
			border: 1px solid var(--color-border);
			background: var(--color-surface);
			padding: 0 14px;
			font-size: 14px;
			color: var(--color-text);
		}

		.tm-input:focus {
			outline: none;
			border-color: var(--color-primary);
			box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
		}

		.tm-input.has-error {
			border-color: var(--color-danger);
		}

		.tm-select-wrap {
			position: relative;
		}

		.tm-select-wrap select {
			appearance: none;
			-webkit-appearance: none;
			width: 100%;
			height: 46px;
			border-radius: var(--border-radius-md);
			border: 1px solid var(--color-border);
			background: var(--color-surface);
			padding: 0 34px 0 14px;
			font-size: 14px;
			color: var(--color-text);
		}

		.tm-select-wrap select:focus {
			outline: none;
			border-color: var(--color-primary);
			box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
		}

		.tm-select-wrap i {
			position: absolute;
			right: 14px;
			top: 50%;
			transform: translateY(-50%);
			font-size: 12px;
			color: var(--color-text-muted);
			pointer-events: none;
		}

		.tm-info-banner {
			display: flex;
			align-items: flex-start;
			gap: 10px;
			background: var(--color-primary-soft);
			border-radius: var(--border-radius-md);
			padding: 12px 14px;
			margin-top: 14px;
			font-size: 12.5px;
			color: var(--color-primary-dark);
		}

		.tm-info-banner i {
			font-size: 13px;
			margin-top: 1px;
			flex-shrink: 0;
		}

		/* children rows */
		.tm-child-rows-header,
		.tm-child-row {
			display: grid;
			grid-template-columns: 1fr 150px 150px;
			gap: 12px;
			align-items: center;
		}

		.tm-child-rows-header {
			margin-bottom: 8px;
		}

		.tm-child-rows-header__label {
			font-size: 13px;
			font-weight: 600;
			color: #555;
		}

		.tm-child-row {
			margin-bottom: 8px;
		}

		.tm-child-row__label {
			font-size: 13.5px;
			font-weight: 600;
			color: var(--color-text);
		}
		@media (max-width: 1023px) {
			.tm-child-rows-header {
				display: none;
			}
			.tm-child-row {
				display: flex;
				flex-direction: column;
				gap: 8px;
				align-items: flex-start;
			}
			.tm-select-wrap {
				width: 100%;
			}
		}
	</style>
{/literal}