<!-- ================= EDIT VOUCHER ================= -->
<div class="iso-voucher-edit" id="voucher-edit-page">

	<!-- BREADCRUMB -->
	<nav class="tm-breadcrumb" aria-label="Breadcrumb">
		<a href="{$PCMS}/admin"><i class="fa-solid fa-chevron-left"></i>{$core->get_Lang('Inventory')}</a>
		<span class="sep">›</span>
		<a href="{$PCMS}/admin/?mod=voucher">{$core->get_Lang('Vouchers')}</a>
		<span class="sep">›</span>
		<span class="is-current">{$clsClassTable->getTitle($pvalTable)}</span>
	</nav>

	<!-- HEADER ROW -->
	<div class="tm-edit-header-row">
		<div class="tm-edit-header-left">
			<a href="{$PCMS}/admin/voucher/overview/{$pvalTable}" class="tm-btn tm-btn--neutral" id="btnBackToDetail"><i
					class="fa-solid fa-arrow-left"></i> {$core->get_Lang('Back to detail')}</a>
			<div>
				<h1 class="tm-edit-title">{$core->get_Lang('Edit Voucher')}</h1>
				<p class="tm-edit-subtitle">{$core->get_Lang('Update voucher information, manage settings and keep your inventory organized.')}</p>
			</div>
		</div>
		<div class="tm-edit-header-actions">
			<a href="{$PCMS}/admin/voucher/overview/{$pvalTable}" class="tm-btn tm-btn--neutral" id="btnCancelEdit">{$core->get_Lang('Cancel')}</a>
			<button
    			type="button"
				data-table_id="{$pvalTable}" 
				data-panel="{$arrStep[$step].panel}" 
				data-currentstep="{$currentstep}"
				data-next_step="" 
				class="tm-btn tm-btn--primary js_save_continue" 
				id="btnSaveChanges" 
				form="editVoucherForm"
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
						href="{$PCMS}/admin/voucher/insert/{$pvalTable}/overview/{$tabKey}"
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
		<div class="main_step_box tm-form-section" id="frmMainStep_{$pvalTable}">

		</div>
		<div id="ajaxAlert" class="alert d-none" role="alert"></div>
	</div>
</div>
<link rel="stylesheet" href="{URL_TEMPLATES}/default/skin/css/module.css?v={$upd_version}" type="text/css" media="all" />
<link rel="stylesheet" href="{URL_TEMPLATES}/default/voucher/css/voucher.css?v={$upd_version}" type="text/css" media="all" />
<script type="text/javascript" src="{$URL_JS}/sweetalert.js?v={$upd_version}"></script>

<script type="text/javascript">
    var table_id = `{$pvalTable|default:0}`;
    var panel = `{$panel|default:''}`;
    var currentstep = `{$currentstep|default:''}`;
    var nextstep = `{$nextstep|default:[]}`;
    var continent_id = `{$oneItem.continent_id|default:0}`;
	var country_id = `{$oneItem.country_id|default:0}`;
    var region_id = `{$oneItem.region_id|default:0}`;
    var city_id = `{$oneItem.city_id|default:0}`;
	var map_lo= `{$oneItem.map_lo|default:0}`;
	var map_la= `{$oneItem.map_la|default:0}`;
	var map_zoom = `{$oneItem.map_zoom|default:0}`;
	var map_type = `{$oneItem.map_tyle|default:0}`;
	var Select = `{$core->get_Lang('Select')}`;
</script>
{literal}
<script>
	$(function () {
		
		$(window).scroll(function() {
			var sticky = $('.box_top_opt_set'),
				scroll = $(window).scrollTop();
			if (scroll >= 40) {
				sticky.addClass('fixed');
			}else {
				sticky.removeClass('fixed');
			}
		});
		loadMainFormStep(table_id,currentstep,nextstep);
	});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/voucher/js/jquery.voucher.new.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/voucher/js/jquery.voucher.js?v={$upd_version}"></script>
<script src="{$URL_JS}/cropper/jquery.cropper.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/bootstrap/js/bootstrap.min.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/html2canvas.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/cropper/cropper.min.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/cropper/cropper.min.css?v={$upd_version}" media="all" />
<!-- Map -->
<link href="{$URL_JS}/mapbox/mapbox.css?v={$upd_version}" rel="stylesheet" />
<script src="{$URL_JS}/mapbox/mapbox.js?v={$upd_version}"></script>
<script src="{$URL_JS}/mapbox/leaflet-heat.js?v={$upd_version}"></script>
<link rel="stylesheet" href="{$URL_JS}/mapbox/leaflet.css?v={$upd_version}" />
<script type="text/javascript" src="{$URL_JS}/mapbox/leaflet-image.js?v={$upd_version}"></script>