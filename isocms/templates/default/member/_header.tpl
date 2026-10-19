<header class="pt-2 border-bottom">
    <div class="container d-flex flex-wrap justify-content-between align-items-center mb-2">
        <a href="{$DOMAIN_NAME}{$extLang}"
            class="d-flex align-items-center text-decoration-none">
            <img class="img_logo" src="{$URL_IMAGES}/logo_new2024/logo_isocms_default.png" width="105" height="50" loading="lazy">
        </a>
        <div class="d-flex align-items-center gap-4">
            {if $listLang|@count>1}
                <div class="dropdown">
                    <a class="isocms_header_lang" class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        title="{$clsISO->getFullLanguage($_LANG_ID)}">
                        <i class="flag flag-20 flag-20-{$_LANG_ID} pd0_15"></i>
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu" id="isocms_dropdown_lang" aria-labelledby="dropdownMenuButton1">
                        {section name=i loop=$listLang}
                            {if $listLang[i] ne $_LANG_ID}
                                <li>
                                    <a class="isocms_dropdown_lang_item"
                                        href="{if $listLang[i] ne $LANG_DEFAULT}{$DOMAIN_NAME}/{$listLang[i]}{else}{$DOMAIN_NAME}{/if}"
                                        title="{$clsISO->getFullLanguage($listLang[i])}">
                                        <i class="flag flag-20 flag-20-{$listLang[i]}"></i>
                                        {$clsISO->getFullLanguage($listLang[i])}
                                    </a>
                                </li>
                            {/if}
                        {/section}
                    </ul>
                </div>
            {/if}
            {if $deviceType != "phone"}
                <div class="separator" style="border-left: 1px solid #ccc; height: 40px; margin: 0 16px;"></div>
                <div class="nav item_iso2 d-flex flex-column align-items-end" style="gap: 5px">
                    <div class="ico_txt_phone d-flex align-items-center">
                        <i class="fa-solid fa-phone me-2" style="color: #26456e;"></i>
                        <a href="tel:{$clsConfiguration->getValue('CompanyPhone')}" class="phone_number"
                            style="color: #26456e; font-size: 18px; font-weight: bold;">
                            {$clsConfiguration->getValue('CompanyPhone')}
                        </a>
                    </div>
                    <div class="phone_description" style="color: #888; font-size: 14px;">
                        {$core->get_Lang('or call your travel agent')}
                    </div>
                </div>
            {/if}
        </div>
    </div>
</header>