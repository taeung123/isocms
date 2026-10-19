<link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />

<div id="page_v2" class="page_container">
	<main class="iso-module-list iso-hotels-list">
		{capture name=list_header_actions}
			<button type="button" 
					class="v2-btn v2-btn--add addNewVoucherSetting" 
					title="{$core->get_Lang('Add new')}"
					data-table="{$currentTab}"
				>
				<i class="fa fa-plus" aria-hidden="true"></i><span>{$core->get_Lang('Add new')}</span>
			</button>
		{/capture}
		{capture name=list_header_setting_url}{$PCMS_URL}/?mod={$mod}&act=setting{/capture}
		{include file="../components/list_v2/header.tpl"
            header_home_label=$core->get_Lang('Dashboard')
            header_module_label=$core->get_Lang('Voucher Settings')
            header_title=$core->get_Lang('Voucher Settings')
            header_count=$number_all
            header_subtitle=$core->get_Lang('Manage suppliers, categories and system configurations for your voucher inventory.')
            header_actions=$smarty.capture.list_header_actions
        }

		<!-- SETTINGS TABS -->
		<nav class="tm-settings-tabs-card" aria-label="Voucher settings sections">
			<div class="tm-settings-tabs" role="tablist">

				{foreach from=$tabInfo key=tabKey item=tab}
					<a href="{$PCMS}/admin/voucher/setting/{$tabKey}"
						class="tm-settings-tab{if $currentTab == $tabKey} active{/if}" role="tab"
						aria-selected="{if $currentTab == $tabKey}true{else}false{/if}" id="{$tab.id}">
						<i class="{$tab.icon}"></i>
						{$core->get_Lang($tab.name)}
					</a>
				{/foreach}

			</div>
		</nav>
		<div class="tm-setting-content">
			{if $currentTab=='categories'}
				{$core->getBlock('box_detail_voucher_setting_categories')}
			{elseif $currentTab=='supplier'}
				{$core->getBlock('box_detail_voucher_setting_supplier')}
			{/if}
		</div>

	</main>



</div>
{literal}
	<script type="text/javascript">
		$(document).ready(function() {
			// Add your JavaScript code here
			$(document).on('click', '.addNewVoucherSetting', function() {
				var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=voucher&act=ajAddNewSetting",
                    data: { 
                        table: $_this.attr("data-table")
                    },
                    dataType: "json",
                    success: function (json) {
                        vietiso_loading(0);
						console.log('aa: ', json);
						if(json.status == 'success') {
							let newId = json.new_id;
							let table = $_this.attr("data-table");
							$link = path_ajax_script + "/voucher/setting/" + table + "/edit/" + newId + "/basic-information";
						
							location.href = $link;
						}
						else {
							alert('Error adding new setting.');
						}
                    
                    },
					error: function (e) {
						vietiso_loading(0);
						console.log(e);
						alert('Error adding new setting.');
					}
                });
			});
		});
	</script>
{/literal}
{literal}
	<style type="text/css">
		/* ---------- KPI ROW ---------- */

		.tm-setting-content {
			display: flex;
			flex-direction: column;
			gap: 16px;
		}

		.tm-setting-content .tm-kpi-grid {
			grid-template-columns: repeat(4, minmax(0, 1fr));
		}

		.tm-kpi-grid .tm-kpi-card {
			flex-direction: row;
		}

		.tm-kpi-value {
			font-size: 24px;
			font-weight: 800;
			color: var(--color-navy);
			line-height: 1;
		}

		.tm-kpi-label {
			font-size: 12px;
			font-weight: 600;
			color: var(--color-text-secondary);
			white-space: nowrap;
		}
		.tm-kpi-sub-label {
			font-size: 10px;
			font-weight: 500;
			color: var(--color-text-secondary);
		}

		/* ---------- TOOLBAR ---------- */
		.tm-toolbar-card {
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-lg);
			box-shadow: var(--box-shadow-sm);
			padding: 14px 16px;
		}

		.tm-toolbar-row {
			display: flex;
			align-items: flex-end;
			gap: 12px;
			flex-wrap: wrap;
		}

		.tm-search-field {
			position: relative;
			flex: 1 1 260px;
			min-width: 200px;
		}

		.tm-search-field i.fa-magnifying-glass {
			position: absolute;
			left: 14px;
			top: 50%;
			transform: translateY(-50%);
			color: var(--color-text-muted);
			font-size: 13px;
		}

		.tm-input {
			width: 100%;
			height: 44px;
			border-radius: var(--border-radius-md);
			border: 1px solid var(--color-border);
			background: var(--color-surface);
			padding: 0 14px;
			font-size: 13.5px;
			color: var(--color-text);
		}

		.tm-search-field .tm-input {
			padding-left: 40px;
			padding-right: 44px;
		}

		.tm-input:focus {
			outline: none;
			border-color: var(--color-primary);
			box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.12);
		}

		.tm-search-field .kbd {
			position: absolute;
			right: 10px;
			top: 50%;
			transform: translateY(-50%);
			font-size: 10px;
			color: var(--color-text-muted);
			border: 1px solid var(--color-border);
			border-radius: 5px;
			padding: 2px 5px;
		}

		.tm-select-field {
			display: flex;
			flex-direction: column;
			gap: 6px;
			width: 175px;
			flex-shrink: 0;
		}

		.tm-select-field label {
			font-size: 12px;
			font-weight: 700;
			color: var(--color-text);
		}

		.tm-select-field .tm-select-wrap {
			position: relative;
		}

		.tm-select-field select {
			appearance: none;
			-webkit-appearance: none;
			width: 100%;
			height: 44px;
			border-radius: var(--border-radius-md);
			border: 1px solid var(--color-border);
			background: var(--color-surface);
			padding: 0 30px 0 14px;
			font-size: 13.5px;
			color: var(--color-text);
		}

		.tm-select-field select:focus {
			outline: none;
			border-color: var(--color-primary);
			box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.12);
		}

		.tm-select-field i {
			position: absolute;
			right: 12px;
			top: 50%;
			transform: translateY(-50%);
			font-size: 11px;
			color: var(--color-text-muted);
			pointer-events: none;
		}

		.tm-btn--more-filters {
			background: var(--color-surface);
			border-color: var(--color-border);
			color: var(--color-text);
			height: 44px;
		}

		.tm-btn--more-filters:hover {
			background: var(--color-page);
		}

		.tm-toolbar-spacer {
			flex: 1 1 0;
			min-width: 0;
		}

		/* ---------- SETTINGS TABS ---------- */
		.tm-settings-tabs-card {
			background: var(--color-surface);
			border: 1px solid var(--color-border-light);
			border-radius: var(--border-radius-lg);
			box-shadow: var(--box-shadow-sm);
			padding: 6px;
		}

		.tm-settings-tabs {
			display: flex;
			align-items: center;
			gap: 4px;
			overflow-x: auto;
		}

		.tm-settings-tab {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			height: 46px;
			padding: 0 16px;
			border: none;
			background: transparent;
			font-size: 13.5px;
			font-weight: 700;
			color: var(--color-text-secondary);
			white-space: nowrap;
			flex-shrink: 0;
		}

		.tm-settings-tab i {
			font-size: 14px;
		}

		.tm-settings-tab:hover {
			background: var(--color-page);
			color: var(--color-text);
		}

		.tm-settings-tab[aria-selected="true"] {
			color: var(--color-primary);
			box-shadow: inset 0 -2px 0 var(--color-primary);
		}

		.tm-settings-tab[aria-selected="true"] i {
			color: var(--color-primary);
		}

		.tm-btn--import {
			background: var(--color-surface);
			border-color: var(--color-border);
			color: var(--color-success);
		}

		.tm-btn--import:hover {
			background: var(--color-success-soft);
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
			box-shadow: var(--box-shadow-md);
			padding: 16px;
			display: flex;
			flex-direction: column;
			gap: 10px;
			transition: transform 180ms ease, box-shadow 180ms ease;
		}

		.tm-kpi-card:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 24px rgba(11, 31, 68, 0.08);
		}

		.tm-kpi-card__top {
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

		.tm-kpi-card__label {
			font-size: 13px;
			font-weight: 600;
			color: var(--color-text-secondary);
		}

		.tm-kpi-card__value-row {
			display: flex;
			align-items: baseline;
			gap: 8px;
			flex-wrap: wrap;
		}

		.tm-kpi-card__value {
			font-size: 24px;
			font-weight: 700;
			color: var(--color-navy);
			line-height: 1;
		}

		.tm-kpi-delta {
			display: inline-flex;
			align-items: center;
			gap: 3px;
			font-size: 12px;
			font-weight: 700;
			padding: 2px 7px;
			border-radius: 999px;
		}

		.tm-kpi-delta--up {
			background: var(--color-success-soft);
			color: var(--color-success);
		}

		.tm-kpi-delta--warn {
			background: var(--color-danger-soft);
			color: var(--color-danger);
		}

		.tm-kpi-card__caption {
			font-size: 12px;
			color: var(--color-text-muted);
		}

		.tm-supplier-cell {
			display: flex;
			align-items: center;
			gap: 9px;
			white-space: nowrap;
		}

		.tm-supplier-avatar {
			width: 26px;
			height: 26px;
			border-radius: 999px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 10px;
			font-weight: 700;
			color: #fff;
			flex-shrink: 0;
		}

		.tm-category-badge {
			display: inline-flex;
			align-items: center;
			height: 24px;
			padding: 0 11px;
			border-radius: 999px;
			font-size: 12px;
			font-weight: 700;
			white-space: nowrap;
		}

		/* =========================================================
   RESPONSIVE
   ========================================================= */
		@media (min-width: 1920px) {
			.tm-kpi-grid {
				gap: 18px;
			}
		}

		@media (max-width: 1439px) {
			.tm-kpi-grid {
				grid-template-columns: repeat(3, minmax(0, 1fr));
			}
		}

		@media (max-width: 1024px) {
			.tm-kpi-grid {
				grid-template-columns: repeat(2, minmax(0, 1fr));
			}
		}

		@media (max-width: 900px) {

			.tm-page-header__actions .tm-btn--primary,
			.tm-page-header__actions .tm-btn--import {
				flex: 1;
				justify-content: center;
			}

		}

		@media (max-width: 768px) {
			.iso-vouchers-inv {
				padding: 14px 12px 28px;
				gap: 14px;
			}

			.tm-kpi-grid {
				grid-template-columns: repeat(2, minmax(0, 1fr));
				gap: 10px;
			}

			.tm-kpi-card {
				padding: 12px;
			}

			.tm-kpi-card__value {
				font-size: 20px;
			}
		}

		@media (max-width: 480px) {
			.tm-kpi-grid {
				grid-template-columns: 1fr;
			}
		}
	</style>
{/literal}