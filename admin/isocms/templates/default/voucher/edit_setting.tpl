<!-- ================= EDIT VOUCHER ================= -->
<div class="iso-voucher-edit" id="voucher-settingedit-page">

	<!-- BREADCRUMB -->
	<nav class="tm-breadcrumb" aria-label="Breadcrumb">
		<a href="{$PCMS}/admin"><i class="fa-solid fa-chevron-left"></i>{$core->get_Lang('Inventory')}</a>
		<span class="sep">›</span>
		<a href="{$PCMS}/admin/?mod=voucher">{$core->get_Lang('Vouchers')}</a>
		<span class="sep">›</span>
		<a href="{$PCMS}/admin/?mod=voucher&act=setting">{$core->get_Lang('Settings')}</a>
		<span class="sep">›</span>
		<a href="{$PCMS}/admin/voucher/setting/{$type}">{$core->get_Lang($type)}</a>
		<span class="sep">›</span>
		<span class="is-current">{$clsClassTable->getTitle($pvalTable)}</span>
	</nav>

	<!-- HEADER ROW -->
	<div class="tm-edit-header-row">
		<div class="tm-edit-header-left">
			<a href="{$PCMS}/admin/voucher/setting/{$type}" class="tm-btn tm-btn--neutral" id="btnBackToDetail"><i
					class="fa-solid fa-arrow-left"></i> {$core->get_Lang('Back to detail')}</a>
			<div>
				<h1 class="tm-edit-title">{$core->get_Lang('Edit')} {$type}</h1>
				<p class="tm-edit-subtitle">{$core->get_Lang('Update voucher information, manage settings and keep your inventory organized.')}</p>
			</div>
		</div>
		<div class="tm-edit-header-actions">
			<a href="{$PCMS}/admin/voucher/setting/{$type}" class="tm-btn tm-btn--neutral" id="btnCancelEdit">{$core->get_Lang('Cancel')}</a>
			<button
    			type="button"
				data-table_id="{$pvalTable}" 
				data-panel="{$arrStep[$step].panel}" 
				data-currentstep="{$currentstep}"
				data-next_step="" 
				class="tm-btn tm-btn--primary js_save_continue" 
				id="btnSaveChanges" 
				form="editVoucherSettingForm"
			>
				<i class="fa-regular fa-floppy-disk"></i> 
				{$core->get_Lang('Save changes')}
			</button>
		</div>
	</div>

	<!-- MAIN CARD: TABS + FORM -->
	<div class="tm-card">

		<div class="tm-tabs-card">
			<div class="tm-tabs" role="tablist" aria-label="Edit voucher sections">
				{foreach from=$tabInfo key=tabKey item=tab}
					<a
						href="{$PCMS}/admin/voucher/setting/{$type}/edit/{$pvalTable}/{$tabKey}"
						class="tm-tab {if $currentstep == $tabKey}active{/if}"
						role="tab"
						aria-selected="{if $currentstep == $tabKey}true{else}false{/if}"
						id="{$tab.id}"
					>
						<i class="{$tab.icon}"></i>
						{$tab.name}
					</a>
				{/foreach}

			</div>
		</div>
		<div class="tm-form-section">
			<form class="tm-form-section" id="editVoucherSettingForm" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
				<input type="hidden" name="table" value="{$type}" />
				{if $currentstep=='image'}
					{assign var= image_detail value='image_voucher'}
					{$core->getBlock('box_detail_image')}
				{elseif $currentstep=='basic-information'}
					{if $type == 'supplier'}
						{$core->getBlock('box_detail_voucher_setting_basic-information')}
					{elseif $type == 'categories'}
						{$core->getBlock('box_detail_voucher_setting_categories_basic-information')}
					{/if}
				{elseif $currentstep=='photoGallery'}
					{$core->getBlock('box_detail_voucher_image-gallery')}
				{/if}
			</form>
		</div>
		<div id="ajaxAlert" class="alert d-none" role="alert"></div>
	</div>
</div>
<link rel="stylesheet" href="{URL_TEMPLATES}/default/skin/css/module.css?v={$upd_version}" type="text/css" media="all" />
<link rel="stylesheet" href="{URL_TEMPLATES}/default/voucher/css/voucher.css?v={$upd_version}" type="text/css" media="all" />
<script type="text/javascript" src="{$URL_JS}/sweetalert.js?v={$upd_version}"></script>

<script type="text/javascript" src="{$URL_THEMES}/voucher/js/jquery.voucher.new.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/bootstrap/js/bootstrap.min.js?v={$upd_version}"></script>

