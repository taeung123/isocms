<!-- DESTINATION WORKSPACE + INSTRUCTIONS -->
<div class="tm-tour-content-row">

    <main class="tm-destination-workspace" id="destination">

        <!-- DESTINATION HEADER -->
        <section class="tm-destination-header">
            <div class="tm-destination-header__heading">
                <span class="tm-destination-header__icon" aria-hidden="true"><i
                        class="fa-solid fa-location-dot"></i></span>
                <div class="tm-destination-header__titles">
                    <h2>
                        {$core->get_Lang('Destination')}
                        {assign var= destination_tour value='destination_tour_'|cat:$check_lang}
                        {if $CHECKHELP eq 1}
                            <button data-key="{$destination_tour}" data-label="{$core->get_Lang('Destination')}"
                                type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                class="tm-info-dot">i</button>
                        {/if}
                    </h2>
                    <p>{$core->get_Lang('Manage the key destinations included in this tour.')}</p>
                </div>
            </div>
            {* <div class="tm-destination-header__actions">
                <div class="tm-count-chip">
                    <span class="tm-count-chip__value" id="destinationCount">5</span>
                    <span class="tm-count-chip__label">Destinations</span>
                </div>
                <button type="button" class="tm-btn tm-btn--add-destination" id="btnAddDestinationTop"><i
                        class="fa-solid fa-plus"></i> {$core->get_Lang('Add destination')}</button>
            </div> *}
        </section>

        <!-- ADD DESTINATION -->
        <section class="tm-add-panel" aria-label="Add destination">
            <h3 class="tm-add-panel__title">{$core->get_Lang('Add destination')}</h3>
            <div class="tm-add-panel__row">
                {assign var = SiteModActive_continent value = $clsISO->getCheckActiveModulePackage($package_id,'continent','default','default')}
                {assign var = SiteModActive_country value = $clsISO->getCheckActiveModulePackage($package_id,'country','default','default')}
                {assign var = SiteActive_region value = $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
                {assign var = SiteActive_city value = $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
                {assign var = SiteHasGroup_Tours value = $clsISO->getCheckActiveModulePackage($package_id,'tour_exhautive','group','default')}
                <span class="tm-add-panel__field-icon" aria-hidden="true"><i class="fa-solid fa-earth-asia"></i></span>
                <div class="tm-add-panel__field">

                    {if $SiteModActive_continent}
                        <div class="form-group">
                            <select class="form-control slb_Chauluc_Id iso-selectbox" toId="slb_CountryID" name="chauluc_id"
                                id="slb_Chauluc" data-width="100%">
                                {$clsContinent->makeSelectboxOption()}
                            </select>
                        </div>
                    {/if}

                    {if $SiteModActive_country}
                        <div id="slb_country_Id_Container"
                            class="form-group{if $SiteModActive_continent eq '1'} hidden{/if}">
                            <select id="slb_CountryID" class="form-control slb_Country_Id iso-selectbox"
                                SiteActive_region="{$SiteActive_region}" SiteActive_city="{$SiteActive_city}"
                                toId="{if $SiteActive_region}slb_RegionID{else}slb_CityID{/if}" name="country_id"
                                data-width="100%">
                                {if $SiteModActive_continent eq '1'}
                                    <option value="0">{$core->get_Lang('Select country')}</option>
                                {else}
                                    {$clsCountryEx->makeSelectboxOption(0,0)}
                                {/if}
                            </select>
                        </div>
                    {/if}
                    {if $SiteActive_region eq '1'}
                        <div id="slb_region_Id_Container"
                            class="form-group {if $SiteModActive_continent eq '1' && $SiteModActive_country eq '1'} hidden{/if}">
                            <select id="slb_RegionID" class="form-control slb_Region_Id iso-selectbox" toId="slb_CityID"
                                name="region_id" data-width="100%">
                                <option value="0">{$core->get_Lang('selectregion')}</option>
                            </select>
                        </div>
                    {/if}

                    {if $SiteActive_city eq '1'}
                        <div id="slb_city_Id_Container" class="form-group hidden">
                            <select id="slb_CityID" class="form-control slb_City_Id iso-selectbox" toId="slb_placetogoID"
                                name="city_id" data-width="100%">
                                <option value="0">{$core->get_Lang('selectcity')}</option>
                            </select>
                        </div>
                    {/if}
                    <div id="slb_placetogoID_Container" class="form-group hidden">
                        <select id="slb_placetogoID" class="form-control slb_placetogo_Id iso-selectbox"
                            name="placetogo_id" data-width="100%">
                            <option value="0">{$core->get_Lang('selectplacetogo')}</option>
                        </select>
                    </div>
                    
                </div>
                <button type="button" class="tm-btn tm-btn--add-orange ajQuickAddDestination"
                        id="btnAddDestination">{$core->get_Lang('Add destination')}</button>
            </div>
        </section>

        <!-- SELECTED DESTINATIONS -->
        <section class="tm-selected-panel" aria-label="Selected destinations">
            <div class="tm-selected-panel__header">
                <h3 id="selectedDestinationsHeading">
                    {$core->get_Lang('Selected destinations')} (<span class="destination-count">0</span>)
                </h3>
                <button type="button" class="tm-btn tm-btn--remove-all ajRemoveAllDestinationInTour"
                    id="btnRemoveAll"><i class="fa-regular fa-trash-can"></i> {$core->get_Lang('Remove all')}</button>
            </div>

            <div class="tm-destination-list" id="destinationList">
                <ul class="list-group" id="lstDestination">
                    <li>{$core->get_Lang('Loading')}...</li>
                </ul>
            </div>
        </section>
        <input type="hidden" name="skip" value="1">
        <!--
            EMPTY STATE (hidden by default — show only when backend
            returns zero selected destinations; do not fake data)
          -->
        <div class="tm-destination-empty" id="destinationEmptyState" hidden>
            <i class="fa-regular fa-map" aria-hidden="true"></i>
            <h3>No destinations selected yet</h3>
            <p>Add the key destinations this tour visits using the form above.</p>
        </div>

    </main>

    <!-- INSTRUCTIONS PANEL (shared component, reused as-is) -->
    {capture assign="instruction_body_vi"}
        <h4>{$core->get_Lang("Về điểm đến")}</h4>
        <p>{$clsConfiguration->getValue('destination_tour_vi')|html_entity_decode}</p>
    {/capture}
    {capture assign="instruction_body_en"}
        <h4>{$core->get_Lang("About Destinations")}</h4>
        <p>{$clsConfiguration->getValue('destination_tour_en')|html_entity_decode}</p>
    {/capture}
    {capture assign="instruction_tip_vi"}
        <div class="tm-tips-box">
            <p class="tm-tips-box__title"><i class="fa-solid fa-lightbulb"></i> Mẹo nhỏ</p>
            <ul class="tm-tips-list">
                <li><i class="fa-solid fa-check"></i> Chọn đúng theo hành trình</li>
                <li><i class="fa-solid fa-check"></i> Bao gồm các điểm chính</li>
                <li><i class="fa-solid fa-check"></i> Giúp tour dễ tìm kiếm hơn</li>
                <li><i class="fa-solid fa-check"></i> Tránh thêm các địa điểm không liên quan</li>
            </ul>
        </div>
    {/capture}
    {capture assign="instruction_tip_en"}
        <div class="tm-tips-box">
            <p class="tm-tips-box__title"><i class="fa-solid fa-lightbulb"></i> Tips</p>
            <ul class="tm-tips-list">
                <li><i class="fa-solid fa-check"></i> Select options that match the itinerary</li>
                <li><i class="fa-solid fa-check"></i> Include the main destinations</li>
                <li><i class="fa-solid fa-check"></i> Make the tour easier to find</li>
                <li><i class="fa-solid fa-check"></i> Avoid adding unrelated destinations</li>
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
        $().ready(function() {
            loadListDestination(tour_id);
            if ($SiteHasDestinationTours == 1) {
                //loadMaps(tour_id);
            }
        });
    </script>
{/literal}
{literal}
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            min-width: 250px;
        }

        .tm-destination-workspace {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
            width: 100%;
        }

        /* ---------- DESTINATION HEADER ---------- */
        .tm-destination-header {
            background: var(--color-surface);
            border: 1px solid var(--color-border-light);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--box-shadow-sm);
            padding: 18px 20px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .tm-destination-header__heading {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            min-width: 0;
        }

        .tm-destination-header__icon {
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

        .tm-destination-header__titles h2 {
            margin: 0;
            font-size: 15.5px;
            font-weight: 700;
            color: var(--color-text);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .tm-destination-header__titles p {
            margin: 3px 0 0;
            font-size: 12.5px;
            color: var(--color-text-secondary);
            max-width: 46ch;
        }

        .tm-destination-header__actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tm-count-chip {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 64px;
            height: 44px;
            border-radius: var(--border-radius-md);
            background: var(--color-page);
            border: 1px solid var(--color-border-light);
            padding: 4px 10px;
        }

        .tm-count-chip__value {
            font-size: 16px;
            font-weight: 700;
            color: var(--color-navy);
            line-height: 1;
        }

        .tm-count-chip__label {
            font-size: 10px;
            color: var(--color-text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .tm-btn--add-destination {
            background: var(--color-primary);
            color: #fff;
        }

        .tm-btn--add-destination:hover {
            background: var(--color-primary-dark);
        }

        /* ---------- ADD DESTINATION PANEL ---------- */
        .tm-add-panel {
            background: var(--color-surface);
            border: 1px solid var(--color-border-light);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--box-shadow-sm);
            padding: 18px 20px;
        }

        .tm-add-panel__title {
            margin: 0 0 14px;
            font-size: 14px;
            font-weight: 700;
            color: var(--color-text);
        }

        .tm-add-panel__row {
            display: flex;
            align-items: baseline;
            gap: 12px;
            flex-wrap: wrap;
        }

        .tm-add-panel__field {
            flex: 1;
            min-width: 220px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tm-add-panel__field .form-group {
            width: 100%;
        }

        .tm-add-panel__field-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--color-page);
            color: var(--color-text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .tm-select-wrap {
            position: relative;
            flex: 1;
            min-width: 0;
        }

        .tm-select-wrap select {
            appearance: none;
            -webkit-appearance: none;
            width: 100%;
            height: 44px;
            border-radius: var(--border-radius-md);
            border: 1px solid var(--color-border);
            background: var(--color-surface);
            padding: 0 34px 0 14px;
            font-size: 13.5px;
            color: var(--color-text);
            transition: border-color 160ms ease, box-shadow 160ms ease;
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

        .tm-btn--add-orange {
            background: var(--color-orange);
            color: #fff;
            height: 44px;
            flex-shrink: 0;
        }

        .tm-btn--add-orange:hover {
            background: var(--color-orange-dark);
        }

        /* ---------- SELECTED DESTINATIONS LIST ---------- */
        .tm-selected-panel {
            background: var(--color-surface);
            border: 1px solid var(--color-border-light);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--box-shadow-sm);
            padding: 18px 20px;
        }

        .tm-selected-panel__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }

        .tm-selected-panel__header h3 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: var(--color-text);
        }

        .tm-btn--remove-all {
            background: var(--color-danger-soft);
            border: 1px solid #FBD5D5;
            color: var(--color-danger);
            height: 36px;
            padding: 0 12px;
            font-size: 12.5px;
        }

        .tm-btn--remove-all:hover {
            background: #FADCDC;
        }

        .tm-destination-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        

        /* ---------- INSTRUCTIONS PANEL (shared component, reused as-is) ---------- */
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
            line-height: 1.65;
            color: var(--color-text);
        }

        .tm-instructions__body h4 {
            font-size: 13.5px;
            font-weight: 700;
            margin: 0 0 8px;
            color: var(--color-text);
        }

        .tm-instructions__body p {
            margin: 0 0 10px;
            color: var(--color-text-secondary);
        }

        .tm-instructions__body .tm-suggest-label {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--color-text);
            margin: 4px 0 6px;
        }

        .tm-instructions__list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .tm-instructions__list li {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 12.5px;
            color: var(--color-text-secondary);
            line-height: 1.5;
        }

        .tm-instructions__list li::before {
            content: "";
            width: 4px;
            height: 4px;
            border-radius: 999px;
            background: var(--color-text-muted);
            margin-top: 7px;
            flex-shrink: 0;
        }

        .tm-tips-box {
            margin-top: 16px;
            background: var(--color-primary-soft);
            border-radius: var(--border-radius-md);
            padding: 14px;
        }

        .tm-tips-box__title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--color-primary-dark);
            margin: 0 0 10px;
        }

        .tm-tips-box__title i {
            color: var(--color-primary);
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
            color: var(--color-text);
            line-height: 1.5;
        }

        .tm-tips-list i {
            color: var(--color-success);
            font-size: 12px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* ---------- BOTTOM STICKY ACTION BAR (shared component, reused as-is) ---------- */
        .tm-action-bar {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 40;
            background: var(--color-surface);
            border-top: 1px solid var(--color-border-light);
            box-shadow: 0 -1px 6px rgba(15, 23, 42, 0.04);
            padding: 14px clamp(16px, 2vw, 32px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .tm-action-bar__status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            color: var(--color-text-secondary);
        }

        .tm-action-bar__status i {
            color: var(--color-success);
            font-size: 13px;
        }

        .tm-action-bar__status strong {
            color: var(--color-text);
            font-weight: 600;
        }

        .tm-action-bar__right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .tm-btn--back-bar {
            background: var(--color-page);
            border-color: var(--color-border);
            color: var(--color-text);
        }

        .tm-btn--back-bar:hover {
            background: var(--color-border-light);
        }

        /* =========================================================
   RESPONSIVE
   ========================================================= */
        @media (max-width: 1280px) {
            .tm-instructions {
                width: 270px;
            }
        }

        @media (max-width: 1180px) {
            .tm-tour-content-row {
                flex-direction: column;
            }

            .tm-instructions {
                width: 100%;
                position: static;
                max-height: none;
            }
            .tm-add-panel__field-icon {
                display: none;
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
                padding: 8px;
                max-height: none;
            }
        }

        @media (max-width: 900px) {
            .tm-tour-header {
                flex-wrap: wrap;
            }

            .tm-tour-header__nav-arrow {
                display: none;
            }
            .tm-destination-header__actions {
                width: 100%;
            }

            .tm-destination-header__actions .tm-btn--add-destination {
                flex: 1;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .iso-tour-destination {
                padding: 16px 14px 110px;
            }

            .tm-add-panel__row {
                flex-direction: column;
                align-items: stretch;
            }

            .tm-add-panel__field {
                min-width: 0;
            }

            .tm-btn--add-orange {
                width: 100%;
                justify-content: center;
            }

            .tm-destination-row {
                flex-wrap: wrap;
            }

            .tm-destination-row__handle {
                display: none;
            }

            .tm-destination-row__body {
                order: 4;
                width: 100%;
                margin-top: 4px;
            }

            .tm-destination-row__remove {
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
                align-items: stretch;
                padding: 16px;
            }

            .tm-tour-thumb-wrap {
                width: 100%;
                aspect-ratio: 21/9;
            }

            .tm-tour-actions {
                gap: 10px;
            }

            .tm-btn--primary {
                grid-column: span 2;
            }

            .tm-destination-header {
                flex-direction: column;
                align-items: stretch;
            }

            .tm-destination-header__actions {
                justify-content: space-between;
            }

            .tm-count-chip {
                flex: 1;
            }
        }
    </style>
{/literal}