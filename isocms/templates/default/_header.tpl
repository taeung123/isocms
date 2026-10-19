<header id="isocms_header">
    <div id="isocms_header_top">
        <div id="isocms_header_box">
            <div class="container d-flex flex-wrap justify-content-between">
                <a href="{$DOMAIN_NAME}{$extLang}"
                    class="d-flex align-items-center iso_image_logo">
                    <img class="img_logo" src="{$clsConfiguration->getValue('HeaderLogo')}" width="auto" height="50" alt="{$PAGE_NAME}" loading="eager">
                </a>
                <div class="d-flex justify-content-end align-items-center">
                    <div class="col-12 mb-lg-0 d-flex align-items-center isocms_header_box">
                        {if $listLang|@count>1}
                            <div class="dropdown iso_cms_languages">
                                <a class="isocms_header_lang" class="btn btn-secondary dropdown-toggle"
                                    type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                    title="{$clsISO->getFullLanguage($_LANG_ID)}">
                                    <i class="flag flag-20 flag-20-{$_LANG_ID} pd0_15"></i>
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </a>
                                {if $listLang|@count>1}
                                    <ul class="dropdown-menu dropdown-menu-center" id="isocms_dropdown_lang"
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
                        {/if}

                        <div class="nav d-flex align-items-center isocms_box_item">
                            {if $agentLoggedIn}
                                <div class="isocms_btn_item">
                                    <a href="{$clsISO->getLink('sale_tool')}">{$core->get_Lang('Production price')}</a>
                                </div>
                            {else}
                                <div class="isocms_btn_item"><a href="{$clsISO->getLink('tailor')}">{$core->get_Lang('Customize')}</a></div>
                                {if $loggedIn ne ''}
                                    <div class="isocms_btn_item"><a href="{$clsProfile->getLink('my_booking')}">{$core->get_Lang('My booking')}</a></div>
                                {/if}
                                <div class="isocms_btn_item">
                                    <a href="{$clsISO->getLink('contact')}">{$core->get_Lang('Contact')}</a>
                                </div>
                                <a href="{$clsISO->getLink('cart')}" class="relative iso_header_cart_link">
                                    <div class="iso_header_icon_cart">
                                        <img class="img_user" src="{$URL_IMAGES}/cart_new.svg" width="20" height="20" alt="Icon" loading="lazy">
                                    </div>
                                    <div class="iso_count_cart">
                                        {$iso_countCart}
                                    </div>
                                </a>
                                {if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}

                            {/if}
                            {/if}
                        </div>
                        <button class="navbar-toggler iso_navbar_toggler" type="button" data-bs-toggle="collapse" data-bs-target="#iso_navbarSupportedContent" aria-controls="iso_navbarSupportedContent" aria-label="Toggle navigation">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="isocms_header_bottom">
        <div class="container">
            <nav class="navbar navbar-expand-lg iso_header_menu">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="iso_navbarSupportedContent">
                        <ul class="navbar-nav ">
                            <li class="nav-item iso_close_header_box">
                                <div class="iso_close_header">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link iso_nav_link_item dropdown-toggle"
                                    type="button" id="iso_dropdown_destinations" data-bs-toggle="dropdown"
                                >
                                    <i class="fa-regular fa-earth-africa"></i>
                                    <span>{$core->get_Lang('Explore destinations')}</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="iso_dropdown_destinations" id="iso_header_destinations">
                                    <div class="iso_header_destinations">
                                        <div class="row">
                                            <div class="col-lg-8 iso_col">
                                                <div class="row iso_header_destinations_body">
                                                    <div class="col-lg-5 iso_col iso_col_pc">
                                                        <div class="iso_box_destination d-flex flex-column">
                                                            {foreach from=$listCountryDestination key=key item=item}
                                                                {assign var=title_country value=$item.title}
                                                                {assign var=country__id value=$item.country_id}
                                                                <a class="iso_box_destination_item d-flex align-items-center justify-content-between"
                                                                    href="{$clsCountryEx->getLink($country__id, 'Destination_new', $item)}"
                                                                    data-id="iso_country_{$item.country_id}">
                                                                    <span>{$title_country}</span>
                                                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                                </a>
                                                            {/foreach}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 iso_col iso_col_city">
                                                        {foreach from=$listCountryDestination key=key item=item}
                                                            {assign var=country__id value=$item.country_id}
                                                            {assign var=title_country value=$item.title}
                                                            {assign var=cities value=$item.cities}
                                                            <div class="iso_lst_city {if $key eq 0}show{/if}"
                                                                    id="iso_country_{$item.country_id}">
                                                                <a href="{$clsCountryEx->getLink($country__id, 'Destination_new')}" class="iso_city_title">
                                                                    {$title_country}
                                                                </a>
                                                                {if $cities}
                                                                <div class="iso_city_item row">
                                                                    {foreach from=$cities key=k item=i}
                                                                        {assign var=title_category_country value=$i.title}
                                                                        <a class="item col-lg-6 iso_col"
                                                                            href="{$clsCity->getLink($i.city_id)}">
                                                                            {$title_category_country}
                                                                        </a>
                                                                    {/foreach}
                                                                </div>
                                                                {/if}
                                                            </div>
                                                        {/foreach}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 iso_col">
                                                {foreach from=$listCountryDestination key=key item=item}
                                                    {assign var=title_country value=$item.title}
                                                    {assign var=country__id value=$item.country_id}
                                                    <div class="box_collapse_item {if $key eq 0}active{/if}"
                                                            data-id="iso_country_{$country__id}">
                                                        <div class="box_collapse_img">
                                                            <img src="{$clsCountryEx->getBanner($country__id, 360, 430)}"
                                                                    width="360" height="430" alt="{$title_country}" loading="lazy">
                                                        </div>
                                                        <a href="{$clsCountryEx->getLink($country__id, 'Destination_new')}"
                                                            class="iso_link_country">
                                                            {$core->get_Lang('See all')} {$title_country} {$core->get_Lang('tours')}
                                                        </a>
                                                    </div>
                                                {/foreach}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link iso_nav_link_item dropdown-toggle" type="button"
                                    id="iso_dropdownMore"
                                    data-bs-toggle="dropdown">
                                    <i class="fa-regular fa-rv"></i>
                                    <span>{$core->get_Lang('Travel Styles')}</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="iso_dropdownMore"
                                    id="iso_dropdownTravel_Style">
                                    {foreach from=$lstCatTour key=key item=item}
                                        {assign var=title_country value=$item.title}
                                        <li>
                                            <a class="dropdown-item"
                                                href="{$clsTourCategory->getLink($item.tourcat_id)}">{$title_country}</a>
                                        </li>
                                    {/foreach}
                                </ul>
                            </li>
                            {if !empty($hotelModuleActive)}
                            <li class="nav-item dropdown">
                                <a class="nav-link iso_nav_link_item dropdown-toggle"
                                    type="button" id="iso_dropdown_hotel" data-bs-toggle="dropdown">
                                    <i class="fa-regular fa-hotel"></i>
                                    {$core->get_Lang('Hotels')}
                                </a>
                                <ul class="dropdown-menu iso_dropdownTravel_Style"
                                    aria-labelledby="iso_dropdown_hotel">
                                    {foreach from=$lstCountryHotel key=key item=item}
                                        {assign var=country_hotel_title value=$item.title}
                                        <li>
                                            <a class="dropdown-item"
                                                href="{$clsCountryEx->getLink($item.country_id,'Hotel')}">
                                                {$country_hotel_title}
                                            </a>
                                        </li>
                                    {/foreach}
                                </ul>
                            </li>
                            {/if}
                            {if !empty($cruiseModuleActive)}
                            <li class="nav-item dropdown">
                                <a class="nav-link iso_nav_link_item dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fa-sharp fa-regular fa-ship"></i>
                                    {$core->get_Lang('Cruises')}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="iso_dropdown_domestic"
                                        id="iso_header_cruise">
                                    <div class="iso_header_domestic">
                                        <div class="row">
                                            <div class="col-lg-12 iso_col">
                                                <div class="row iso_header_domestic_body">
                                                    <div class="col-lg-4 iso_col iso_col_pc">
                                                        <div class="iso_box_domestic d-flex flex-column">
                                                            {foreach from=$lstCruiseCat key=key item=item}
                                                                {assign var=_cruisecat_id value=$item.cruise_cat_id}
                                                                {assign var=title_cruisecat value=$item.title}
                                                                {assign var=link_cruisecat value=$clsCruiseCat->getLink($_cruisecat_id,$item)}
                                                                <a href="{$link_cruisecat}" class="iso_box_domestic_item d-flex align-items-center justify-content-between"
                                                                        data-id="iso_header_cruise_{$_cruisecat_id}"
                                                                        data-type="cruise">
                                                                    <span>{$title_cruisecat}</span>
                                                                    <i class="fa fa-angle-right"
                                                                        aria-hidden="true"></i>
                                                                </a>
                                                            {/foreach}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 iso_col iso_col_city">
                                                        {foreach from=$lstCruiseCat key=key item=item}
                                                            {assign var=_cruisecat_id value=$item.cruise_cat_id}
                                                            {assign var=title_cruisecat value=$item.title}
                                                            {assign var=link_cruisecat value=$clsCruiseCat->getLink($_cruisecat_id,$item)}
                                                            <div class="iso_lst_domestic {if $key eq 0}show{/if}"
                                                                    id="iso_header_cruise_{$_cruisecat_id}"
                                                                    data-type="cruise">
                                                                <a href="{$link_cruisecat}" class="iso_city_title">
                                                                    {$title_cruisecat}
                                                                </a>
                                                                <div class="iso_city_item row">
                                                                    {if $clsISO->getCheckActiveModulePackage($package_id,'cruise','cruise_sub_category','customize')}
                                                                        {assign var=childCat value=$clsCruiseCat->getMenuChild($_cruisecat_id)}
                                                                        {$childCat}
                                                                    {else}
                                                                        <a class="item col-lg-6 iso_col"
                                                                            href="{$link_cruisecat}">
                                                                            {$title_cruisecat}
                                                                        </a>
                                                                    {/if}
                                                                </div>

                                                            </div>
                                                        {/foreach}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {/if}
                            {if !empty($voucherModuleActive)}
                            <li class="nav-item relative">
                                <a class="nav-link iso_nav_link_item"
                                    href="{$clsISO->getLink('voucher')}">
                                    <i class="fa-regular fa-ticket"></i> {$core->get_Lang('Vouchers')}
                                </a>
                            </li>
                            {/if}
                            <li class="nav-item relative">
                                <a class="nav-link iso_nav_link_item"  href="{$clsISO->getLink('blog')}"><i class="fa-regular fa-blog"></i>{$core->get_Lang('Blog')}</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>