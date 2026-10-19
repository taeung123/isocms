<!-- CONTENT ROW: SEO form | Preview panel -->
<div class="tm-content-row">

	<!-- SEO TOOL FORM -->
	<section class="tm-form-card" id="seo-tool" aria-labelledby="seoToolHeading">
		<div class="tm-form-card__header">
			<span class="tm-form-card__icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
			<div class="tm-form-card__titles">
				<h2 id="seoToolHeading">{$core->get_Lang('SEO Tool')}</h2>
				<p>{$core->get_Lang('Optimize your tour page for better visibility on search engines.')}</p>
			</div>
		</div>
		<div class="tm-field-block">
			<div class="tm-field-label-row">
				<label class="tm-form-label" for="config_value_title">{$core->get_Lang('Meta Title')} <span
						class="required">*</span></label>
				<span class="tm-char-count"><span
						id="charTitleNum">{$clsISO->getCountMetaWord($clsMeta->getMetaTitle($meta_id))}</span>/70</span>
			</div>
			<input class="tm-input required" name="config_value_title" id="config_value_title"
				onkeyup="countCharTitle(this)" value="{$clsMeta->getMetaTitle($meta_id)}" maxlength="255" type="text">
			<p class="tm-field-hint">{$core->get_Lang('The meta title of your page has a length of')} <span
					id="charTitleNum">{$clsISO->getCountMetaWord($clsMeta->getMetaTitle($meta_id))}</span>
				{$core->get_Lang('characters. Most search engines will truncate titles to')} 70
				{$core->get_Lang('characters.')}</p>
		</div>
		<div class="tm-field-block" style="margin-top:24px;">
			<div class="tm-field-label-row">
				<label class="tm-form-label" for="config_value_intro">{$core->get_Lang('Meta Description')} <span
						class="required">*</span></label>
				<span class="tm-char-count"><span
						id="charDesNum">{$clsISO->getCountMetaWord($clsMeta->getMetaDescription($meta_id))}</span>/160</span>
			</div>
			<textarea name="config_value_intro" id="config_value_intro" class="tm-textarea required"
				onkeyup="countCharDes(this)">{$clsMeta->getMetaDescription($meta_id)}</textarea>

			<p class="tm-field-hint">{$core->get_Lang('The meta description of your page has a length of')} <span
					id="charDesNum">{$clsISO->getCountMetaWord($clsMeta->getMetaDescription($meta_id))}</span>
				{$core->get_Lang('characters. Most search engines will truncate meta descriptions to')} 160
				{$core->get_Lang('characters.')}</p>
		</div>

		{$core->getBlock('meta_schema')}

		<div class="tm-field-block" style="margin-top:24px;">
			<label class="tm-form-label">{$core->get_Lang('Image Share Social')} <span class="required">*</span></label>
			<div class="tm-image-share-row">
				<div class="tm-dropzone" id="imageDropzone">
					<span class="tm-dropzone__icon" aria-hidden="true"><i class="fa-solid fa-cloud-arrow-up"></i></span>
					<span class="tm-dropzone__title">{$core->get_Lang('Click to upload')}</span>
					{* <span class="tm-dropzone__title">Drag &amp; drop an image here</span>
						<span class="tm-dropzone__or">or click to upload</span> *}
					<span
						class="tm-dropzone__caption">{$core->get_Lang('Recommended size: 1200 x 630px (JPG, PNG)')}<br>{$core->get_Lang('Max file size: 2MB')}</span>
					<div class="tm-dropzone-actions">
						<a table_id="{$meta_id}" isoman_multiple="0"
							isoman_callback='isoman_callback({ldelim}"openFrom":"seo", "clsTable":"Meta", "table_id":"{$meta_id}","toField":"image","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim})'
							class="tm-btn tm-btn--library ajOpenDialog" isoman_for_id="image_seo" isoman_name="image"
							href="javascript:void(0);">
							{$core->get_Lang('Choose from library') }
						</a>
						<button type="button" class="tm-btn tm-btn--browse filedrop"
							onclick="file_explorer(this,event);" ondrop="file_drop(this,event)" toId="selectFile"
							hiddenId="isoman_hidden_image_seo"
							data-options='{ldelim}"openFrom":"seo","clsTable":"Meta", "table_id":"{$meta_id}","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim}'
							ondragover="return false">
							Browse files
						</button>
						<input class="hidden" id="selectFile" type="file"
							data-options='{ldelim}"seo":"image","clsTable":"Meta", "table_id":"{$meta_id}","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim}'>

					</div>
				</div>
				<div class="tm-image-preview" id="socialImagePreview">
					<input type="hidden" id="isoman_hidden_image_seo" name="isoman_url_image_seo"
						value="{$clsMeta->getOneField('image',$meta_id)}" />
					<img id="isoman_show_image_seo" src="{$clsMeta->getOneField('image',$meta_id)}"
						onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="Social share image preview">
					{* <button type="button" class="tm-image-preview__remove" id="btnRemoveSocialImage"
							aria-label="Remove social share image"><i class="fa-solid fa-xmark"></i></button> *}
				</div>
			</div>
		</div>

	</section>

	<!-- SEO PREVIEW PANEL -->
	<aside class="tm-preview-panel" aria-label="SEO preview">

		<div class="tm-card">
			<div class="tm-card__header">
				<span class="tm-card__icon" aria-hidden="true">
					<i class="fa-solid fa-circle-info"></i>
				</span>
				<h3>SEO Preview</h3>
			</div>

			<div class="tm-lang-tabs" role="tablist" aria-label="Preview target">
				<button type="button" class="tm-lang-tab" role="tab" aria-selected="true" id="tabGoogle">
					Google
				</button>

				<button type="button" class="tm-lang-tab" role="tab" aria-selected="false" id="tabSocial">
					Social
				</button>
			</div>

			<!-- Google Preview -->
			<div class="tm-google-preview tm-preview-pane" id="googlePreviewPane">

				<div class="tm-google-preview__breadcrumb">
					<span class="tm-google-preview__favicon"></span>
					{DOMAIN_URL} &rsaquo; tours
				</div>

				<p class="tm-google-preview__title" id="previewTitle">
					{$clsMeta->getMetaTitle($meta_id)}
				</p>

				<p class="tm-google-preview__desc" id="previewDesc">
					{$clsMeta->getMetaDescription($meta_id)}
				</p>

			</div>

			<!-- Social Preview -->
			<div class="tm-social-preview tm-preview-pane" id="socialPreviewPane" style="display:none;">

				<div class="tm-social-preview__image">
					<img id="socialPreviewImage" src="{$clsMeta->getOneField('image',$meta_id)}" alt="Social preview">
				</div>

				<div class="tm-social-preview__content">

					<div class="tm-social-preview__title" id="socialPreviewTitle">
						{$clsMeta->getMetaTitle($meta_id)}
					</div>

					<div class="tm-social-preview__desc" id="socialPreviewDesc">
						{$clsMeta->getMetaDescription($meta_id)}
					</div>

					<div class="tm-social-preview__domain">
						{DOMAIN_URL}
					</div>

				</div>

			</div>
		</div>


		<div class="tm-card">

			<div class="tm-card__header">
				<span class="tm-card__icon" aria-hidden="true">
					<i class="fa-solid fa-circle-check"></i>
				</span>
				<h3>SEO Checklist</h3>
			</div>

			<div class="tm-checklist-score">

				<span class="tm-score-ring" id="seoScoreRing">
					<span id="seoScore">0%</span>
				</span>

				<div class="tm-checklist-score__text">
					<strong id="seoScoreTitle">Needs improvement</strong>
					<span id="seoScoreText">
						Complete the SEO fields below.
					</span>
				</div>

			</div>

			<ul class="tm-checklist-list">

				<li id="checkMetaTitle">
					<i class="fa-solid fa-circle-xmark"></i>
					Meta title (10–70 characters)
				</li>

				<li id="checkMetaDescription">
					<i class="fa-solid fa-circle-xmark"></i>
					Meta description (50–160 characters)
				</li>

				<li id="checkSocialImage">
					<i class="fa-solid fa-circle-check"></i>
					Social image (1200 x 630px)
				</li>

				<li id="checkSchema">
					<i class="fa-solid fa-circle-check"></i>
					Valid schema markup (JSON-LD)
				</li>

			</ul>

		</div>


		<div class="tm-tips-box">

			<p class="tm-tips-box__title">
				<i class="fa-solid fa-lightbulb"></i>
				Tips
			</p>

			<ul class="tm-tips-list">

				<li>
					<i class="fa-solid fa-check"></i>
					Write clear and attractive meta titles
				</li>

				<li>
					<i class="fa-solid fa-check"></i>
					Include key highlights in meta description
				</li>

				<li>
					<i class="fa-solid fa-check"></i>
					Use high-quality images (1200x630px)
				</li>

				<li>
					<i class="fa-solid fa-check"></i>
					Add valid schema markup for rich results
				</li>

			</ul>

		</div>


	</aside>

</div>


<!-- BOTTOM STICKY ACTION BAR -->
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
		$(document).on('input', '#config_value_title, #config_value_intro', function() {
			updateSEOChecklist();

		});
		$(document).on('click', '.tm-lang-tab', function() {

			var $this = $(this);

			var tabId = $this.attr('id');

			/* Remove active */
			$('.tm-lang-tab')
				.removeClass('active')
				.attr('aria-selected', 'false');

			/* Active current tab */
			$this
				.addClass('active')
				.attr('aria-selected', 'true');


			/* Hide all preview */
			$('.tm-preview-pane').hide();


			/* Show selected preview */
			if (tabId === 'tabGoogle') {

				$('#googlePreviewPane').show();

			} else if (tabId === 'tabSocial') {

				$('#socialPreviewPane').show();

			}

		});

		function countCharTitle(val) {

			var len = val.value.length;

			$('#charTitleNum').text(len);

			$('#previewTitle').text(
				val.value.trim() ||
				'Your meta title will appear here'
			);

			$('#socialPreviewTitle').text(
				val.value.trim() ||
				'Your meta title will appear here'
			);

			updateSEOChecklist();
		}


		function countCharDes(val) {

			var len = val.value.length;

			$('#charDesNum').text(len);

			$('#previewDesc').text(
				val.value.trim() ||
				'Your meta description will appear here'
			);

			$('#socialPreviewDesc').text(
				val.value.trim() ||
				'Your meta description will appear here'
			);

			updateSEOChecklist();
		}


		function updateSEOChecklist() {

			var title = $('#config_value_title').val().trim();
			var description = $('#config_value_intro').val().trim();


			/* =========================
		 * META TITLE
		 * 10 - 70 characters
		 * ========================= */

			var titleLength = title.length;

			var titleValid = (
				titleLength >= 10 &&
				titleLength <= 70
			);


			/* =========================
		 * META DESCRIPTION
		 * 50 - 160 characters
		 * ========================= */

			var descriptionLength = description.length;

			var descriptionValid = (
				descriptionLength >= 50 &&
				descriptionLength <= 160
			);


			/* =========================
		 * SOCIAL IMAGE
		 * ========================= */

			var socialImageValid = checkSocialImage();


			/* =========================
		 * SCHEMA
		 * Empty = valid
		 * Invalid JSON = invalid
		 * ========================= */

			var schemaValid = checkSchemaMarkup();


			/* =========================
		 * UPDATE CHECK ICON
		 * ========================= */

			updateCheckItem(
				'#checkMetaTitle',
				titleValid
			);

			updateCheckItem(
				'#checkMetaDescription',
				descriptionValid
			);

			updateCheckItem(
				'#checkSocialImage',
				socialImageValid
			);

			updateCheckItem(
				'#checkSchema',
				schemaValid
			);


			/* =========================
		 * CALCULATE SCORE
		 * ========================= */

			var total = 4;
			var passed = 0;

			if (titleValid) {
				passed++;
			}

			if (descriptionValid) {
				passed++;
			}

			if (socialImageValid) {
				passed++;
			}

			if (schemaValid) {
				passed++;
			}

			var score = Math.round(
				(passed / total) * 100
			);


			/* =========================
		 * UPDATE RING
		 * ========================= */

			var $ring = $('#seoScoreRing');

			$ring
				.removeClass(
					'is-danger is-warning is-good is-excellent'
				)
				.css(
					'--score',
					score + '%'
				);


			/* =========================
		 * COLOR
		 * ========================= */

			if (score === 100) {

				$ring.addClass('is-excellent');

			} else if (score >= 80) {

				$ring.addClass('is-good');

			} else if (score >= 50) {

				$ring.addClass('is-warning');

			} else {

				$ring.addClass('is-danger');
			}


			/* =========================
		 * SCORE %
		 * ========================= */

			$('#seoScore').text(score + '%');


			/* =========================
		 * MESSAGE
		 * ========================= */

			if (score === 100) {

				$('#seoScoreTitle').text('Great!');
				$('#seoScoreText').text(
					'Your SEO looks good.'
				);

			} else if (score >= 80) {

				$('#seoScoreTitle').text('Almost there!');
				$('#seoScoreText').text(
					'A few SEO improvements are recommended.'
				);

			} else if (score >= 50) {

				$('#seoScoreTitle').text('Needs improvement');
				$('#seoScoreText').text(
					'Some SEO fields need attention.'
				);

			} else {

				$('#seoScoreTitle').text('Needs improvement');
				$('#seoScoreText').text(
					'Complete the SEO fields below.'
				);
			}
		}


		function updateCheckItem(selector, valid) {

			var $item = $(selector);
			var $icon = $item.find('i');

			$icon.removeClass(
				'fa-circle-check fa-circle-xmark'
			);

			if (valid) {

				$icon.addClass('fa-circle-check');

				$item
					.removeClass('is-error')
					.addClass('is-success');

			} else {

				$icon.addClass('fa-circle-xmark');

				$item
					.removeClass('is-success')
					.addClass('is-error');
			}
		}

		function checkSocialImage() {

			var $img = $('#imageDropzone').find('img');

			if (!$img.length) {
				return false;
			}

			var img = $img[0];

			return (
				img.naturalWidth === 1200 &&
				img.naturalHeight === 630
			);
		}

		function checkSchemaMarkup() {

			var value = $('#schemaMarkup').val().trim();

			// Schema không bắt buộc
			// Rỗng = hợp lệ
			if (!value) {
				return true;
			}

			try {

				JSON.parse(value);

				return true;

			} catch (e) {

				return false;
			}
		}

		/* =========================
	 * Initial load
	 * ========================= */

		$(document).ready(function() {

			updateSEOChecklist();

			$('#config_value_title').trigger('keyup');
			$('#config_value_intro').trigger('keyup');

		});
	</script>

{/literal}
{literal}
	<style>
		/* ---------- CONTENT ROW ---------- */
		.tm-content-row {
			flex: 1;
			min-width: 0;
			display: flex;
			align-items: flex-start;
			gap: 20px;
		}

		.tm-form-card {
			flex: 1;
			min-width: 0;
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-xl);
			box-shadow: var(--color-shadow-sm);
			padding: 20px 24px 24px;
			display: flex;
			flex-direction: column;
			gap: 24px;
		}

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
		}

		.tm-field-block {
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.tm-field-label-row {
			display: flex;
			align-items: baseline;
			justify-content: space-between;
			gap: 10px;
		}

		.tm-form-label {
			font-size: 13px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-form-label .required {
			color: var(--color-danger);
		}

		.tm-char-count {
			font-size: 12px;
			color: var(--color-text-muted);
			font-weight: 600;
			flex-shrink: 0;
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

		.tm-textarea {
			width: 100%;
			min-height: 84px;
			border-radius: var(--border-radius-md);
			border: 1px solid var(--color-border);
			background: var(--color-surface);
			padding: 12px 14px;
			font-size: 14px;
			color: var(--color-text);
			font-family: inherit;
			resize: vertical;
		}

		.tm-textarea:focus {
			outline: none;
			border-color: var(--color-primary);
			box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
		}

		.tm-field-hint {
			margin: 0;
			font-size: 12px;
			color: var(--color-text-secondary);
		}

		/* image share social */
		.tm-image-share-row {
			display: flex;
			gap: 16px;
			flex-wrap: wrap;
		}

		.tm-dropzone {
			flex: 1;
			min-width: 260px;
			border: 1.5px dashed var(--color-border);
			border-radius: var(--border-radius-lg);
			padding: 22px 16px;
			display: flex;
			flex-direction: column;
			align-items: center;
			gap: 8px;
			text-align: center;
			background: var(--color-page);
		}

		.tm-dropzone__icon {
			width: 40px;
			height: 40px;
			border-radius: 999px;
			background: var(--color-primary-soft);
			color: var(--color-primary);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 16px;
			margin-bottom: 2px;
		}

		.tm-dropzone__title {
			font-size: 13.5px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-dropzone__or {
			font-size: 11.5px;
			color: var(--color-text-muted);
		}

		.tm-dropzone__caption {
			font-size: 11px;
			color: var(--color-text-muted);
			line-height: 1.5;
			margin: 2px 0 4px;
		}

		.tm-dropzone-actions {
			display: flex;
			gap: 8px;
			flex-wrap: wrap;
			justify-content: center;
		}

		.tm-btn--browse {
			background: var(--color-primary);
			color: #fff;
			height: 36px;
			padding: 0 14px;
			font-size: 12.5px;
		}

		.tm-btn--browse:hover {
			background: var(--color-primary-dark);
		}

		.tm-btn--library {
			background: var(--color-surface);
			border-color: var(--color-border);
			color: var(--color-text);
			height: 36px;
			padding: 0 14px;
			font-size: 12.5px;
		}

		.tm-btn--library:hover {
			background: var(--color-page);
		}

		.tm-image-preview {
			position: relative;
			width: 220px;
			aspect-ratio: 1200/630;
			border-radius: var(--border-radius-lg);
			overflow: hidden;
			background: var(--color-border-light);
			flex-shrink: 0;
		}

		.tm-image-preview img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			display: block;
		}

		.tm-image-preview__remove {
			position: absolute;
			top: 8px;
			right: 8px;
			width: 26px;
			height: 26px;
			border-radius: 999px;
			border: none;
			background: rgba(15, 23, 42, 0.65);
			color: #fff;
			font-size: 12px;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.tm-image-preview__remove:hover {
			background: rgba(15, 23, 42, 0.85);
		}

		/* ---------- SEO PREVIEW PANEL (right column) ---------- */
		.tm-preview-panel {
			width: 320px;
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			gap: 16px;
			position: sticky;
			top: 76px;
			max-height: calc(100vh - 96px);
			overflow-y: auto;
		}

		.tm-card {
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-xl);
			box-shadow: var(--color-shadow-sm);
			padding: 16px;
		}

		.tm-card__header {
			display: flex;
			align-items: center;
			gap: 10px;
			margin-bottom: 14px;
		}

		.tm-card__icon {
			width: 26px;
			height: 26px;
			border-radius: 999px;
			background: var(--color-primary-soft);
			color: var(--color-primary);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 12px;
			flex-shrink: 0;
		}

		.tm-card__header h3 {
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
			margin-bottom: 14px;
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

		.tm-google-preview__breadcrumb {
			display: flex;
			align-items: center;
			gap: 6px;
			font-size: 12px;
			color: var(--color-text-secondary);
			margin-bottom: 4px;
		}

		.tm-google-preview__favicon {
			width: 16px;
			height: 16px;
			border-radius: 50%;
			background: var(--color-border-light);
			flex-shrink: 0;
		}

		.tm-google-preview__title {
			font-size: 15px;
			color: #1A0DAB;
			font-weight: 500;
			line-height: 1.3;
			margin: 0 0 6px;
		}

		.tm-google-preview__desc {
			font-size: 12.5px;
			color: var(--color-text-secondary);
			line-height: 1.5;
			margin: 0;
		}

		.tm-score-ring {
			--score: 0%;
			--score-color: var(--color-danger);

			position: relative;
			width: 64px;
			height: 64px;
			flex-shrink: 0;
			border-radius: 50%;

			background: conic-gradient(var(--score-color) 0 var(--score),
					var(--color-border-light) var(--score) 100%);

			display: flex;
			align-items: center;
			justify-content: center;
		}

		.tm-score-ring::before {
			content: "";
			position: absolute;
			inset: 6px;
			border-radius: 50%;
			background: var(--color-surface);
		}

		.tm-score-ring>span {
			position: relative;
			z-index: 1;
			font-size: 14px;
			font-weight: 700;
			color: var(--score-color);
		}


		/* 0 - 49 */
		.tm-score-ring.is-danger {
			--score-color: var(--color-danger);
		}


		/* 50 - 79 */
		.tm-score-ring.is-warning {
			--score-color: var(--color-warning);
		}


		/* 80 - 99 */
		.tm-score-ring.is-good {
			--score-color: var(--color-success);
		}


		/* 100 */
		.tm-score-ring.is-excellent {
			--score-color: var(--color-success);
		}


		.tm-checklist-score {
			display: flex;
			align-items: center;
			gap: 14px;
			margin-bottom: 14px;
		}

		.tm-checklist-score__text strong {
			display: block;
			font-size: 13.5px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-checklist-score__text span {
			font-size: 12px;
			color: var(--score-color, var(--color-text-secondary));
			font-weight: 600;
		}

		.tm-checklist-list {
			list-style: none;
			margin: 0;
			padding: 0;
			display: flex;
			flex-direction: column;
			gap: 9px;
		}

		.tm-checklist-list li {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 12.5px;
			color: var(--color-text);
			line-height: 1.5;
		}

		.tm-checklist-list i {
			color: var(--color-success);
			font-size: 13px;
			margin-top: 1px;
			flex-shrink: 0;
		}

		.tm-checklist-list i.fa-circle-xmark {
			color: var(--color-warning);
		}

		.tm-tips-box {
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

		.tm-social-preview {
			width: 100%;
		}

		.tm-social-preview__card {
			width: 100%;
			max-width: 520px;
			margin: 0 auto;

			border: 1px solid #dddfe2;
			border-radius: 8px;
			overflow: hidden;

			background: #fff;
		}


		/* =========================
 * IMAGE
 * ========================= */

		.tm-social-preview__image {
			width: 100%;
			aspect-ratio: 1200 / 630;

			background: #f0f2f5;
			overflow: hidden;
		}

		.tm-social-preview__image img {
			display: block;

			width: 100%;
			height: 100%;

			object-fit: cover;
		}


		/* =========================
 * CONTENT
 * ========================= */

		.tm-social-preview__content {
			padding: 10px 12px 12px;
			background: #fff;
		}


		/* =========================
 * DOMAIN
 * ========================= */

		.tm-social-preview__domain {
			margin-bottom: 4px;

			font-size: 11px;
			line-height: 16px;

			color: #65676b;
			text-transform: uppercase;
		}


		/* =========================
 * TITLE
 * ========================= */

		.tm-social-preview__title {
			margin-bottom: 4px;

			font-size: 16px;
			line-height: 20px;

			font-weight: 600;
			color: #1c1e21;

			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}


		/* =========================
		* DESCRIPTION
		* ========================= */

		.tm-social-preview__desc {
			font-size: 13px;
			line-height: 18px;
			color: #65676b;
			margin-bottom: 6px;
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}

		.tm-social-preview__placeholder {
			width: 100%;
			height: 100%;

			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;

			color: #8a8d91;
			font-size: 14px;
			font-weight: 600;
			text-align: center;

			background: #f0f2f5;
		}

		.tm-social-preview__placeholder small {
			margin-top: 4px;

			font-size: 11px;
			font-weight: 400;
		}
	</style>
{/literal}