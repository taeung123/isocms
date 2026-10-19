<header id="isocms_header">
    <div id="iso_header_notify">
        <div class="container">
            <div class="iso_header_notify">
                <div class="iso_box_header_news"></div>
                <div class="iso_box_news_close">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
        </div>
    </div>
    <div id="isocms_header_body">
        <div class="iso_header_body">
            <a href="{$DOMAIN_NAME}{$extLang}" class="iso_header_logo">
                <img class="img_logo" src="{$clsConfiguration->getValue('HeaderLogo')}" width="208" height="58" alt="{$PAGE_NAME}" loading="eager">
            </a>
            <div class="box_left_body">
                <nav class="navbar navbar-expand-lg iso_header_menu">
                    <div class="collapse navbar-collapse" id="iso_navbar_content">
                        <ul class="navbar-nav ">
                            <li class="nav-item iso_close_header_box">
                                <div class="iso_close_header">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div>
                            </li>
                            {foreach from=$lstMenu key=key item=item} 
                                {if empty($item.file_build)}
                                    <li class="nav-item relative iso_nav_dropdown">
                                        <a class="nav-link iso_nav_link_item" href="{$item.link}">
                                            {if !empty($item.icon)}{$item.icon}{/if}
                                            <span>{$item.title}</span>
                                        </a>
                                    </li>
                                {else} 
                                    <li class="nav-item dropdown iso_nav_dropdown">
                                        <a class="nav-link iso_nav_link_item dropdown-toggle" type="button" id="iso_dropdown_{$item.file_key}" data-bs-toggle="dropdown">
                                            {if !empty($item.icon)}{$item.icon}{/if}
                                            <span>{$item.title}</span>
                                            <i class="fa-regular fa-chevron-down"></i>
                                        </a>
                                        {$clsISO->buildFileTpl($item.file_build)}
                                    </li>
                                {/if}
                            {/foreach}
                        </ul>
                    </div>
                </nav>
                <div class="dropdown iso_cms_languages">
                    <a class="isocms_header_lang" class="btn btn-secondary dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        title="{$clsISO->getFullLanguage($_LANG_ID)}">
                        <i class="flag flag-20 flag-20-{$_LANG_ID} pd0_15"></i>
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </a>
                    {if $listLang|@count>1}
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-center" id="isocms_dropdown_lang"
                            aria-labelledby="dropdownMenuButton1">
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
                    {/if}
                </div>
                <button class="navbar-toggler iso_navbar_toggler" type="button" data-bs-toggle="collapse" data-bs-target="#iso_navbar_content" aria-controls="iso_navbar_content" aria-label="Toggle navigation">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                <a class="nav-link header_box_hotline" href="tel:{$clsConfiguration->getValue('CompanyHotline')}" title="{$clsConfiguration->getValue('CompanyHotline')}">
                    <span class="txt_hotline"><i class="fa-regular fa-mobile"></i> {$core->get_Lang('Hotline')}:</span> 
                    <span class="hotline">{$clsConfiguration->getValue('CompanyHotline')}</span>
                </a>
            </div>
        </div>
    </div>
</header>

