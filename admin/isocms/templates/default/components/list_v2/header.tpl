<nav class="booking-list-breadcrumb v2-breadcrumb" aria-label="Breadcrumb">
    <a href="{$PCMS_URL}/"><i class="fa fa-home" aria-hidden="true"></i> {$header_home_label}</a>
    <i class="fa fa-angle-right" aria-hidden="true"></i>
    <span>{$header_module_label}</span>
</nav>

<header class="booking-list-hero v2-page-header">
    <div class="booking-list-hero__content v2-page-header__content">
        <div class="booking-list-title-row v2-page-title-row">
            <h1 class="v2-page-title">{$header_title}</h1>
            {if $header_count}
                <span class="booking-count-pill v2-count-pill">{$header_count}</span>
            {/if}
        </div>
        <p class="v2-page-subtitle">{$header_subtitle}</p>
    </div>
    {if $header_actions || $header_setting_url}
        <div class="booking-list-hero__actions v2-page-header__actions">
            {$header_actions}
            {if $header_setting_url}
                <a href="{$header_setting_url}"
                   class="v2-btn v2-btn--icon v2-module-setting-btn"
                   title="{$header_setting_label}"
                   aria-label="{$header_setting_label}">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                </a>
            {/if}
        </div>
    {/if}
</header>
