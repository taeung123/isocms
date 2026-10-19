{if $holderG eq '_modal'}
<div class="modal-dialog home tm-quick-modal" role="document" aria-labelledby="customizeQuickAccessTitle" data-empty-message="{$core->get_Lang('No matching features found.')|escape:'html'}">
    <div class="modal-content tm-quick-modal__content">
        <div class="tm-quick-modal__header">
            <span class="tm-quick-modal__icon" aria-hidden="true"><i class="fa fa-th-large"></i></span>
            <div class="tm-quick-modal__titles">
                <h2 id="customizeQuickAccessTitle">{$core->get_Lang('Customize Quick Access')}</h2>
                <p>{$core->get_Lang('Choose and manage the shortcuts that appear on your dashboard.')}</p>
            </div>
            <button type="button" class="tm-quick-modal__close" data-dismiss="modal" aria-label="{$core->get_Lang('Close')}">
                <i class="fa fa-times"></i>
            </button>
        </div>

        <div class="tm-quick-modal__toolbar">
            <div class="tm-quick-modal__tabs" role="tablist" aria-label="{$core->get_Lang('Feature filter')}">
                <button type="button" class="tm-quick-modal__tab is-active" data-quick-filter="all" role="tab" aria-selected="true">{$core->get_Lang('All Features')}</button>
                <button type="button" class="tm-quick-modal__tab" data-quick-filter="selected" role="tab" aria-selected="false">
                    {$core->get_Lang('Selected')} (<span id="tmQuickSelectedCount">0</span>)
                </button>
                <button type="button" class="tm-quick-modal__tab" data-quick-filter="available" role="tab" aria-selected="false">{$core->get_Lang('Suggested')}</button>
            </div>
            <label class="tm-quick-modal__search">
                <i class="fa fa-search" aria-hidden="true"></i>
                <input type="search" id="tmQuickSearch" placeholder="{$core->get_Lang('Search features...')}" autocomplete="off" />
            </label>
        </div>

        <div class="modal-body tm-quick-modal__body">
            <div class="quick_access_html">
                <div class="loader text-center">...</div>
            </div>
        </div>

        <div class="tm-quick-modal__footer">
            <button type="button" class="tm-quick-btn tm-quick-btn--reset" id="tmQuickReset">{$core->get_Lang('Reset')}</button>
            <div class="tm-quick-modal__footer-actions">
                <button type="button" class="tm-quick-btn tm-quick-btn--cancel" data-dismiss="modal">{$core->get_Lang('Cancel')}</button>
                <button type="button" class="tm-quick-btn tm-quick-btn--save" id="tmQuickSave">{$core->get_Lang('Save Changes')}</button>
            </div>
        </div>
    </div>
</div>
{else}
<div class="tm-quick-feature-section">
    <div class="tm-quick-feature-section__header">
        <h4>{$core->get_Lang('Core Management')}</h4>
        <label class="tm-quick-select-all">
            <span>{$core->get_Lang('Select all')}</span>
            <input type="checkbox" id="tmQuickSelectAll" />
        </label>
    </div>

    <div class="quick_access_list tm-quick-feature-grid" id="tmQuickFeatureGrid">
        {section name=i loop=$listQuickAccessShow}
            {assign var=admin_id value=$listQuickAccessShow[i].adminbutton_id}
            {if $clsAdminButton->checkPackage($admin_id,$package_id)}
                {if $core->checkAccess($listQuickAccessShow[i].mod_page)}
                    {assign var=quick_title value=$core->get_Lang($listQuickAccessShow[i].title_page)}
                    <button type="button"
                            class="quick_access_item remove_item_quick_access tm-quick-feature-tile is-selected"
                            data-tp="remove"
                            data-quick-state="selected"
                            data-quick-default="{$clsAdminButton->isDefaultQuickAccess($listQuickAccessShow[i])}"
                            data-feature-name="{$quick_title|escape:'html'}"
                            data-adminbutton_id="{$listQuickAccessShow[i].adminbutton_id}">
                        <input type="checkbox" class="tm-quick-feature-checkbox" value="{$listQuickAccessShow[i].adminbutton_id}" checked="checked" tabindex="-1" aria-hidden="true" />
                        <span class="icon tm-quick-feature-icon">
                            <img class="imgIcon" src="{$listQuickAccessShow[i].image}" width="28" height="28" alt="" />
                        </span>
                        <span class="text tm-quick-feature-label">{$quick_title}</span>
                    </button>
                {/if}
            {/if}
        {/section}

        {section name=i loop=$listQuickAccess}
            {assign var=admin__id value=$listQuickAccess[i].adminbutton_id}
            {if $clsAdminButton->checkPackage($admin__id,$package_id)}
                {if $core->checkAccess($listQuickAccess[i].mod_page)}
                    {assign var=quick_title value=$core->get_Lang($listQuickAccess[i].title_page)}
                    <button type="button"
                            class="quick_access_item add_item_quick_access tm-quick-feature-tile"
                            data-tp="add"
                            data-quick-state="available"
                            data-quick-default="{$clsAdminButton->isDefaultQuickAccess($listQuickAccess[i])}"
                            data-feature-name="{$quick_title|escape:'html'}"
                            data-adminbutton_id="{$listQuickAccess[i].adminbutton_id}">
                        <input type="checkbox" class="tm-quick-feature-checkbox" value="{$listQuickAccess[i].adminbutton_id}" tabindex="-1" aria-hidden="true" />
                        <span class="icon tm-quick-feature-icon">
                            <img class="imgIcon" src="{$listQuickAccess[i].image}" width="28" height="28" alt="" />
                        </span>
                        <span class="text tm-quick-feature-label">{$quick_title}</span>
                    </button>
                {/if}
            {/if}
        {/section}
    </div>
</div>
{/if}
