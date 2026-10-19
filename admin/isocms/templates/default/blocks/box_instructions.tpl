<!-- INSTRUCTIONS PANEL -->
	<aside class="tm-instructions" aria-label="Instructions">
		<div class="tm-instructions__header">
			<span class="tm-instructions__icon" aria-hidden="true">
				<i class="fa-solid fa-info"></i>
			</span>
			<h3>{$core->get_Lang("Instructions")}</h3>
		</div>
		<div class="tm-lang-tabs" role="tablist" aria-label="Instruction language">
			<button type="button" class="tm-lang-tab {if $_LANG_ID == 'vn'}active{/if}" role="tab" aria-selected="{if $_LANG_ID == 'vn'}true{else}false{/if}" id="langTabVi"
				data-lang="vi">
				VI
			</button>
			<button type="button" class="tm-lang-tab {if $_LANG_ID != 'vn'}active{/if}" role="tab" aria-selected="{if $_LANG_ID != 'vn'}true{else}false{/if}" id="langTabEn" data-lang="en">
				EN
			</button>

		</div>

		<!-- VI -->
		<div class="tm-instructions__content" data-language="vi" {if $_LANG_ID != 'vn'}hidden{/if}>
			<div class="tm-instructions__body">
                {$instruction_body_vi}
			</div>
            {$instruction_tip_vi}
			
		</div>

		<!-- EN -->
		<div class="tm-instructions__content" data-language="en" {if $_LANG_ID == 'vn'}hidden{/if}>
			<div class="tm-instructions__body">
                {$instruction_body_en}
			</div>
            {$instruction_tip_en}
			
		</div>

	</aside>