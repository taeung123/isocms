{assign var=tour_title value=$clsTour->getTitle($pvalTable)|default:''}
{assign var=tour_slug value=$clsTour->getSlug($pvalTable)|default:''}
{assign var=default_tour_slug value="new-tour-`$pvalTable`"}

{assign var=is_new_tour value=false}

{if $tour_slug eq ''
	|| $tour_slug eq $default_tour_slug
	|| $tour_title eq ''
	|| $tour_title eq $default_tour_slug
}
{assign var=is_new_tour value=true}
{/if}

{assign var=is_edit_tour value=true}
{if $is_new_tour}
	{assign var=is_edit_tour value=false}
{/if}
{assign var=tour_title value=$clsTour->getTitle($pvalTable)|default:''}
{assign var=tour_slug value=$clsTour->getSlug($pvalTable)|default:''}
<!-- FORM + INSTRUCTIONS -->
<div class="tm-tour-content-row">
	<!-- FORM CARD -->
	<section class="tm-form-card" id="basic-information" aria-labelledby="basicInfoHeading">
		<div class="tm-form-card__header">
			<div class="tm-form-card__heading">
				<span class="tm-form-card__icon" aria-hidden="true"><i class="fa-regular fa-file-lines"></i></span>
				<div class="tm-form-card__titles">
					<h2 id="basicInfoHeading">{$core->get_Lang("Basic information")}</h2>
					<p>{$core->get_Lang("Set the main information for your tour. This information will be displayed on your website and in search results.")}
					</p>
				</div>
			</div>
			{* <button type="button" class="tm-btn tm-btn--ai" id="btnAiAssistant">
				<i class="fa-solid fa-wand-magic-sparkles"></i> AI Assistant <i class="fa-solid fa-chevron-down"></i>
			</button> *}
		</div>

		<form id="basicInfoForm">
			<div class="tm-form-field">
				<label class="tm-form-label" for="tourTitle">
					{$core->get_Lang("Title")} <span class="required">*</span>
					{assign var=title_tour value='title_tour_'|cat:$check_lang}

					{if $CHECKHELP|default:0 eq 1}
						<button data-key="{$title_tour}" data-label="{$core->get_Lang('Title')|escape:'html'}" type="button"
							title="{$core->get_Lang('Add description')|escape:'html'}" onclick="open_texthelp(this, event)"
							class="tm-info-dot">i</button>
					{/if}

				</label>
				<input class="form-control tm-input required" type="text" id="title" name="title"
					tour_id="{$pvalTable|default:0}" value="{$tour_title|escape:'html'}"
					placeholder="{$core->get_Lang('New title tour')|escape:'html'}" autocomplete="off" maxlength="255"
					onclick="loadHelp(this)">
				<p class="tm-field-counter"><span id="titleCount">61</span>/255</p>
				<div class="text_help" hidden>
					{$clsConfiguration->getValue($title_tour)|html_entity_decode}
				</div>
			</div>

			<div class="tm-form-field">
				<div class="tm-checkbox-row">
					<input type="checkbox" id="change_url" name="change_url" value="1">
					<label for="change_url">
						{$core->get_Lang('Change URL')}
						{assign var=change_url_tour value='change_url_tour_'|cat:$check_lang}
						{if $CHECKHELP|default:0 eq 1}
							<button data-key="{$change_url_tour}" data-label="{$core->get_Lang('Change URL')|escape:'html'}"
								type="button" title="{$core->get_Lang('Add description')|escape:'html'}"
								onclick="open_texthelp(this, event)" class="tm-info-dot">i</button>
						{/if}
					</label>
					<div class="text_help" hidden>
						{$clsConfiguration->getValue($change_url_tour)|html_entity_decode}
					</div>
				</div>
				<input class="form-control input_text_form tour_slug_input tm-input" type="text" id="tour_slug"
					name="slug" value="{if $is_new_tour}{else}{$tour_slug|escape:'html'}{/if}"
					data-original-slug="{$tour_slug|escape:'html'}" tour_id="{$pvalTable|default:0}"
					placeholder="{$core->get_Lang('URL slug')|escape:'html'}" autocomplete="off" spellcheck="false"
					{if !$is_new_tour}readonly{/if}>
			</div>
			<div class="tm-form-field">
				<label class="tm-form-label" for="tourUrl">
					URL
					{assign var=url_tour value='url_tour_'|cat:$check_lang}
					{if $CHECKHELP|default:0 eq 1}
						<button data-key="{$url_tour}" data-label="{$core->get_Lang('URL')|escape:'html'}" type="button"
							title="{$core->get_Lang('Add description')|escape:'html'}" onclick="open_texthelp(this, event)"
							class="tm-info-dot">i</button>
					{/if}
				</label>
				<div class="text_help" hidden>
					{$clsConfiguration->getValue($url_tour)|html_entity_decode}
				</div>
				<div class="form-group inpt_tour tour_url_group tm-url-group" id="tour_url_group"
					data-is-new="{if $is_new_tour}1{else}0{/if}">
					<span class="tm-url-prefix">{$PCMS}/</span>
					<div class="tm-url-input-wrap">
						<input type="text" id="tourUrl" class="tm-input" readonly value="{$tour_slug|escape:'html'}">
						<button type="button" class="tm-url-refresh" id="btnRefreshUrl"
							aria-label="Regenerate URL from title">
							<i class="fa-solid fa-rotate-right"></i>
						</button>
					</div>
				</div>
				<p class="check-slug tm-field-hint hidden"></p>
				<p class="tm-field-hint">
					{$core->get_Lang("You should not change your URL frequently unless absolutely necessary. Changing your URL can have a negative impact on your SEO.")|escape:'html'}
				</p>
			</div>
			{assign var=titleTrip value='trip_code'}
			<div class="tm-form-field">
				<label class="tm-form-label" for="tripCode">
					{$core->get_Lang('Trip code')} <span class="required">*</span>
					{assign var=titleTrip value="trip_code_"|cat:$check_lang}
					{if $CHECKHELP|default:0 eq 1}
						<button data-key="{$titleTrip}" data-label="{$core->get_Lang('Trip code')|escape:'html'}"
							type="button" title="{$core->get_Lang('Add description')|escape:'html'}"
							onclick="open_texthelp(this, event)" class="tm-info-dot">i</button>
					{/if}
				</label>
				<input class="form-control input_text_form tm-input required" type="text" id="trip_code"
					name="trip_code" tour_id="{$pvalTable|default:0}"
					value="{$clsTour->getTripCode($pvalTable)|escape:'html'}"
					placeholder="{$core->get_Lang('Trip Code')|escape:'html'}"
					{if $oneItem.yield_id|default:0}readonly{/if} onclick="loadHelp(this)">
				<p class="tm-field-hint">
					{$core->get_Lang("Add your trip code (e.g. HNHL4D, VN-SAPA-01...)")|escape:'html'}</p>
				<div class="text_help" hidden>
					{$clsConfiguration->getValue($titleTrip)|html_entity_decode}
				</div>
			</div>
		</form>

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
	</section>

	<!-- INSTRUCTIONS PANEL -->
	{assign var="instruction_body_vi" value="
        <p>{$clsConfiguration->getValue('title_tour_vi')|html_entity_decode}</p>
	<h4>{$core->get_Lang('URL')}:</h4>
	<p>{$clsConfiguration->getValue('url_tour_vi')|html_entity_decode}</p>
	<p>{$clsConfiguration->getValue('change_url_tour_vi')|html_entity_decode}</p>
	<h4>{$core->get_Lang('Mã tour (Trip code)')}:</h4>
	<p>{$clsConfiguration->getValue('trip_code_tour_vi')|html_entity_decode}</p>
	"}
	{assign var="instruction_body_en" value="
        <p>{$clsConfiguration->getValue('title_tour_en')|html_entity_decode}</p>
	<h4>{$core->get_Lang('URL')}:</h4>
	<p>{$clsConfiguration->getValue('url_tour_en')|html_entity_decode}</p>
	<p>{$clsConfiguration->getValue('change_url_tour_en')|html_entity_decode}</p>
	<h4>{$core->get_Lang('Trip code')}:</h4>
	<p>{$clsConfiguration->getValue('trip_code_tour_en')|html_entity_decode}</p>
	"}
	{capture assign="instruction_tip_en"}
		<div class="tm-example-box">
			<p class="tm-example-box__title">
				{$core->get_Lang("Example:")}
			</p>
			<ul>
				<li>
					{$core->get_Lang("Title")}: Hanoi - Ha Long Bay 4 Days
				</li>
				<li>
					{$core->get_Lang("URL")}: hanoi-ha-long-bay-4-days
				</li>
				<li>
					{$core->get_Lang("Trip code")}: HNHL4D
				</li>
			</ul>
		</div>
		<div class="tm-tip-box">
			<i class="fa-regular fa-lightbulb" aria-hidden="true"></i>

			<div>
				<p class="tm-tip-box__title">
					{$core->get_Lang("Tip:")}
				</p>

				<p>
					{$core->get_Lang("Use a short name containing the main keyword and destination to improve SEO.")}
				</p>
			</div>
		</div>
	{/capture}
	{capture assign="instruction_tip_vi"}
		<div class="tm-example-box">
			<p class="tm-example-box__title">
				{$core->get_Lang("Ví dụ:")}
			</p>
			<ul>
				<li>
					{$core->get_Lang("Title")}: Hà Nội - Vịnh Hạ Long 4 Ngày
				</li>
				<li>
					{$core->get_Lang("URL")}: ha-noi-vinh-ha-long-4-ngay
				</li>
				<li>
					{$core->get_Lang("Mã tour (Trip code)")}: HNHL4D
				</li>
			</ul>
		</div>
		<div class="tm-tip-box">
			<i class="fa-regular fa-lightbulb" aria-hidden="true"></i>
			<div>
				<p class="tm-tip-box__title">
					{$core->get_Lang("Mẹo:")}
				</p>
				<p>
					{$core->get_Lang("Sử dụng tên ngắn gọn, chứa từ khóa chính và điểm đến để tối ưu SEO.")}
				</p>
			</div>
		</div>
	{/capture}
	{$clsISO->getBlock('box_instructions', [
		'instruction_tip_en' => $instruction_tip_en,
		'instruction_tip_vi' => $instruction_tip_vi,	
		'instruction_body_en' => $instruction_body_en,
		'instruction_body_vi' => $instruction_body_vi
	])}
</div>
{literal}
	<script>
		(function() {
			'use strict';
			var titleCount = document.getElementById('titleCount');
			var titleInput = document.getElementById('title');
			var maxTitleLength = 255;

			function updateTitleCount() {
				if (!titleInput || !titleCount) return;
				if (titleInput.value.length > maxTitleLength) {
					titleInput.value = titleInput.value.substring(0, maxTitleLength);
				}
				titleCount.textContent = titleInput.value.length;
			}

			if (titleInput && titleCount) {
				updateTitleCount();
				titleInput.addEventListener('input', updateTitleCount);
				titleInput.addEventListener('keyup', updateTitleCount);
				titleInput.addEventListener('paste', function() {
					setTimeout(updateTitleCount, 0);
				});
			}

			function createSlug(value) {
				value = String(value || '');

				if (typeof value.normalize === 'function') {
					value = value
						.normalize('NFD')
						.replace(/[\u0300-\u036f]/g, '');
				}

				return value
					.replace(/[đĐ]/g, 'd')
					.toLowerCase()
					.trim()
					.replace(/&/g, ' and ')
					.replace(/['’"`]/g, '')
				.replace(/[^a-z0-9]+/g, '-')
				.replace(/^-+|-+$/g, '')
			.replace(/-{2,}/g, '-');
		}

		function initTourSlug() {
			var titleInput = document.getElementById('title');
			var slugInput = document.getElementById('tour_slug');
			var changeUrl = document.getElementById('change_url');
			var urlGroup = document.getElementById('tour_url_group');
			if (
				!titleInput ||
				!slugInput ||
				!changeUrl ||
				!urlGroup
			) {
				console.log('Missing required elements for tour slug initialization');
				return;
			}

			var isNew =
				urlGroup.getAttribute('data-is-new') === '1';

			var originalSlug =
				slugInput.getAttribute('data-original-slug') || '';

			/*
			 * ADD MỚI
			 * - Title trắng
			 * - URL trắng
			 * - Gõ title thì slug tự sinh
			 */
			if (isNew) {
				titleInput.value = '';
				slugInput.value = '';

				titleInput.readOnly = false;
				slugInput.readOnly = false;

				titleInput.classList.remove('is-readonly');
				slugInput.classList.remove('is-readonly');

				titleInput.addEventListener('keyup', function() {
					slugInput.value = createSlug(
						titleInput.value
					);
				});

				titleInput.addEventListener('input', function() {
					slugInput.value = createSlug(
						titleInput.value
					);
				});

				slugInput.addEventListener('input', function() {
					slugInput.value = createSlug(
						slugInput.value
					);
				});

				return;
			}

			/*
			 * EDIT
			 * - Không tự thay slug khi sửa Title
			 * - Chỉ sửa slug khi tích Change URL
			 */
			slugInput.readOnly = true;
			slugInput.classList.add('is-readonly');

			changeUrl.addEventListener('change', function() {
				if (changeUrl.checked) {
					slugInput.readOnly = false;
					slugInput.classList.remove('is-readonly');
					slugInput.focus();
				} else {
					slugInput.value = originalSlug;
					slugInput.readOnly = true;
					slugInput.classList.add('is-readonly');
				}
			});


		}

		if (document.readyState === 'loading') {
			document.addEventListener(
				'DOMContentLoaded',
				initTourSlug
			);
		} else {
			initTourSlug();
		}
	})();
	// Khi click refresh URL
	$('#btnRefreshUrl').on('click', function() {
		var $slug = $('#tour_slug');
		var $tourUrl = $('#tourUrl');

		// Lấy slug hiện tại
		var slug = $.trim($slug.val());
		var tour_id = $slug.attr('tour_id');

		// Nếu chưa cho phép thay đổi URL thì tự động bật
		// if (!$('#change_url').is(':checked')) {
		// 	$('#change_url').prop('checked', true).trigger('change');
		// }

		// Nếu có slug thì cập nhật tourUrl
		if (slug !== '') {
			$tourUrl.val(slug);
		}
		$.ajax({
			type: "POST",
			url: path_ajax_script + "/index.php?mod=tour_iso&act=ajaxCheckSlug",
			data: {
				slug: slug,
				tour_id: tour_id
			},
			dataType: "html",
			success: function(html) {
				console.log(html);
				if (html === '_EXISTS') {
					$('.check-slug.tm-field-hint').removeClass('hidden').text('Slug already exists!');
					$('.check-slug.tm-field-hint').removeClass('text-success').addClass('text-danger');
				} else if (html === '_AVAILABLE') {
					$('.check-slug.tm-field-hint').removeClass('hidden').text('Slug Available');
					$('.check-slug.tm-field-hint').removeClass('text-danger').addClass('text-success');
				}
			}
		});
	});

	// Khi nhập trực tiếp slug -> cập nhật URL hiển thị
	// $('#tour_slug').on('input', function() {
	// 	if ($('#change_url').is(':checked')) {
	// 		$('#tourUrl').val($(this).val());
		// 		}
		// 	});
	</script>

{/literal}
{literal}
	<style>

		/* ---------- FORM CARD ---------- */
		

		.tm-form-card__header {
			display: flex;
			align-items: flex-start;
			justify-content: space-between;
			gap: 16px;
			flex-wrap: wrap;
			padding-bottom: 18px;
			border-bottom: 1px solid var(--color-border-light);
			margin-bottom: 22px;
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
			font-size: 15.5px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-form-card__titles p {
			margin: 3px 0 0;
			font-size: 12.5px;
			color: var(--color-text-secondary);
			max-width: 46ch;
		}

		.tm-btn--ai {
			background: var(--color-primary-soft);
			border-color: transparent;
			color: var(--color-primary);
		}

		.tm-btn--ai:hover {
			background: #DCE9FF;
		}

		.tm-btn--ai i.fa-chevron-down {
			font-size: 11px;
			margin-left: 2px;
		}

		/* form fields */
		.tm-form-field {
			margin-bottom: 22px;
		}

		.tm-form-field:last-of-type {
			margin-bottom: 0;
		}

		.tm-form-label {
			display: flex;
			align-items: center;
			gap: 6px;
			font-size: 13px;
			font-weight: 700;
			color: var(--color-text);
			margin-bottom: 8px;
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
			transition: border-color 160ms ease, box-shadow 160ms ease;
		}

		.tm-input:focus {
			outline: none;
			border-color: var(--color-primary);
			box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
		}

		.tm-input::placeholder {
			color: var(--color-text-muted);
		}

		.tm-field-hint {
			margin: 6px 0 0;
			font-size: 12px;
			color: var(--color-text-secondary);
		}

		.tm-field-counter {
			text-align: right;
			font-size: 11.5px;
			color: var(--color-text-muted);
			margin-top: 6px;
		}

		/* URL field: fixed domain prefix + editable slug */
		.tm-url-group {
			display: flex;
			width: 100%;
		}

		.tm-url-prefix {
			display: flex;
			align-items: center;
			height: 46px;
			padding: 0 14px;
			background: var(--color-page);
			border: 1px solid var(--color-border);
			border-right: none;
			border-radius: var(--border-radius-md) 0 0 var(--border-radius-md);
			font-size: 13px;
			color: var(--color-text-muted);
			white-space: nowrap;
			flex-shrink: 0;
		}

		.tm-url-group .tm-input {
			border-radius: 0 var(--border-radius-md) var(--border-radius-md) 0;
			padding-right: 44px;
		}

		.tm-url-input-wrap {
			position: relative;
			flex: 1;
			min-width: 0;
		}

		.tm-url-refresh {
			position: absolute;
			right: 8px;
			top: 50%;
			transform: translateY(-50%);
			width: 30px;
			height: 30px;
			border-radius: 8px;
			border: none;
			background: transparent;
			color: var(--color-primary);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 14px;
		}

		.tm-url-refresh:hover {
			background: var(--color-primary-soft);
		}

		.tm-url-refresh i {
			line-height: 20px;
		}

		.tm-checkbox-row {
			display: flex;
			align-items: center;
			gap: 8px;
			margin: 14px 0;
		}

		.tm-checkbox-row input[type="checkbox"] {
			width: 16px;
			height: 16px;
			accent-color: var(--color-primary);
		}

		.tm-checkbox-row label {
			font-size: 13px;
			font-weight: 600;
			color: var(--color-text);
			display: flex;
			align-items: center;
			gap: 6px;
		}

		/* footer actions */
		.tm-form-footer {
			margin-top: 26px;
			padding-top: 20px;
			border-top: 1px solid var(--color-border-light);
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 12px;
		}

		/* ---------- INSTRUCTIONS PANEL ---------- */
		.tm-instructions {
			width: 300px;
			flex-shrink: 0;
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-xl);
			box-shadow: var(--box-shadow-sm);
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
			box-shadow: var(--box-shadow-sm);
		}

		.tm-instructions__body {
			font-size: 13px;
			line-height: 1.6;
			color: var(--color-text);
		}

		.tm-instructions__body h4 {
			font-size: 13px;
			font-weight: 700;
			margin: 16px 0 6px;
			color: var(--color-text);
		}

		.tm-instructions__body h4:first-child {
			margin-top: 0;
		}

		.tm-instructions__body p {
			margin: 0 0 4px;
			color: var(--color-text-secondary);
		}

		.tm-example-box {
			margin-top: 16px;
			background: var(--color-primary-soft);
			border-radius: var(--border-radius-md);
			padding: 14px;
		}

		.tm-example-box__title {
			font-size: 12.5px;
			font-weight: 700;
			color: var(--color-primary-dark);
			margin: 0 0 8px;
		}

		.tm-example-box ul {
			margin: 0;
			padding-left: 18px;
			font-size: 12.5px;
			color: var(--color-text);
		}

		.tm-example-box li {
			margin-bottom: 4px;
		}

		.tm-example-box li:last-child {
			margin-bottom: 0;
		}

		.tm-tip-box {
			margin-top: 14px;
			background: var(--color-warning-soft);
			border-radius: var(--border-radius-md);
			padding: 14px;
			display: flex;
			gap: 10px;
		}

		.tm-tip-box i {
			color: var(--color-warning);
			font-size: 15px;
			flex-shrink: 0;
			margin-top: 1px;
		}

		.tm-tip-box__title {
			font-size: 12.5px;
			font-weight: 700;
			color: #92610A;
			margin: 0 0 4px;
		}

		.tm-tip-box p {
			margin: 0;
			font-size: 12.5px;
			color: #7A5209;
			line-height: 1.5;
		}

		/* mobile-only instructions toggle button */
		.tm-instructions-mobile-toggle {
			display: none;
		}
	</style>
{/literal}