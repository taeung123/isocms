<link rel="preload" href="{$URL_CSS}/mobilemenu.css?v={$upd_version}" as="style" />
<link rel="stylesheet" href="{$URL_CSS}/mobilemenu.css?v={$upd_version}"/>
<script src="{$URL_JS}/jquery-simple-mobilemenu.min.js?v={$upd_version}"></script>
<div class="logo-port">
	<p>
		<a href="{$DOMAIN_NAME}" title="{$PAGE_NAME}">
			<img class="img-responsive img100" alt="{$PAGE_NAME}" width="106" height="50" src="{$clsConfiguration->getValue('HeaderLogo')}"/>
		</a>	
	</p>
</div>
<div class="header_link">
<!--
	{if $clsISO->getCheckActiveModulePackage($package_id,'faqs','default','default')}
	<a class="icon_faqs" href="{$clsISO->getLink('faqs')}" title="{$core->get_Lang('Faqs')}"><i class="fa fa-question-circle" aria-hidden="true"></i> {$core->get_Lang('Faqs')}</a>
	{/if}
-->
	{*<div class="search_box_icon">
		<span class="icon_search"></span>
	</div>
	<div class="search_box">
		<form class="form_search_top" method="post" action="{$extLang}/">
			<span class="icon_search"></span>
			<input type="text" class="search_top_mb" name="key" autocomplete="off" placeholder="{$core->get_Lang('Search by destination, tour')},....">
			<input type="hidden" name="Hid_Search" value="Hid_Search" />
		</form>	
	</div>*}
	{if $listLang|@count>1}
		<li class="dropdown language_select">
			<a class="slt_country" data-bs-toggle="dropdown"
			   style="cursor:pointer"
			   title="{$clsISO->getFullLanguage($_LANG_ID)}" role=link
			   aria-disabled=true><i
						class="flag flag-20 flag-20-{$_LANG_ID} pd0_15"></i> <i
						class="fa fa-angle-down" aria-hidden="true"></i></a>
			{if $listLang|@count>1}
				<ul class="dropdown-menu menu-language">
					{section name=i loop=$listLang}
						{if $listLang[i] ne $_LANG_ID}
							<li><a class="color_333"
								   href="{if $listLang[i] ne $LANG_DEFAULT}{$DOMAIN_NAME}/{$listLang[i]}{else}{$DOMAIN_NAME}{/if}"
								   title="{$clsISO->getFullLanguage($listLang[i])}"><i
											class="flag flag-20 flag-20-{$listLang[i]}"></i> {$clsISO->getFullLanguage($listLang[i])}
								</a></li>
						{/if}
					{/section}
				</ul>
			{/if}
		</li>
	{/if}
	
	{if $clsISO->getCheckActiveModulePackage($package_id,'setting','cart','customize')}
	<div class="cart__box">
		<a href="{$clsISO->getLink('cart')}" title="{$core->get_Lang('Cart')}" class="color_1c1c1c cart__header">
			<span class="icon__cart"><span class="number__item" id="number_cart_mobile">0</span></span>
			<span class="cart">{$core->get_Lang('Cart')}</span>
		</a>
	</div>
	{/if}
	{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
	{if $loggedIn eq ''}
	<div class="dropdown login_mobile">
		<a title="{$core->get_Lang('Customer Login')}" data-bs-toggle="dropdown" href="javascript:void(0);" rel="nofollow" role=link aria-disabled=true >
			<span class="icon_user"></span>
		</a>
		<ul class="dropdown-menu dropdown-mene-profile" role="menu">
			<li><a href="{$clsISO->getLink('signin')}" class="signin_head color_333" title="{$core->get_Lang('Sign In')}">
				<i class="fa fa-sign-out" aria-hidden="true"></i> {$core->get_Lang('Sign In')}</a>
			</li>
			<li class="border0"><a href="{$clsISO->getLink('signup')}" class="signin_head color_333" title="{$core->get_Lang('Sign Up')}">
				<i class="fa fa-user" aria-hidden="true"></i> {$core->get_Lang('Sign Up')}</a>
			</li>
		</ul>
	</div>
	{else}
	<div class="dropdown login_mobile">
		<a title="{$core->get_Lang('Customer Login')}" data-bs-toggle="dropdown" href="javascript:void(0);" rel="nofollow" role=link aria-disabled=true>
			<span class="icon_user"></span>
		</a>
		<ul class="dropdown-menu dropdown-mene-profile" role="menu">
			<li><a role="menuitem" href="{$clsISO->getLink('my_profile')}">{$core->get_Lang('My Profile')}</a> </li>
			<li><a role="menuitem" href="{$clsISO->getLink('my_booking')}">{$core->get_Lang('My Booking')}</a> </li>
			<li><a role="menuitem" href="{$clsISO->getLink('my_wishlist')}">{$core->get_Lang('My Wishlist')}</a> </li>
			<li><a role="menuitem" href="{$clsISO->getLink('contact_info')}">{$core->get_Lang('Contact Information')}</a> </li>
			{assign var=_provider value = $clsProfile->getOauthProvider($profile_id)}
			{if $_provider eq '_REGSITER'}
				<li><a role="menuitem" href="{$clsISO->getLink('change_pass')}">{$core->get_Lang('Change Password')}</a> </li>
			{/if}
			<li><a role="menuitem" href="{$clsISO->getLink('logout')}"><i class="fa fa-sign-out" aria-hidden="true"></i> {$core->get_Lang('Logout')}</a></li>
		</ul>
	</div>
	{/if}
	{/if}
</div>
<ul class="mobile_menu">
    {if $_LANG_ID!='vn'}
    <li class="relative">
        <a href="javascript:void(0);" title="{$core->get_Lang('Destinations')}" role="link">{$core->get_Lang('Destinations')}</a>
        <ul class="submenu">
            {section name=i loop=$listCountryDestination}
            {assign var=title_country value=$listCountryDestination[i].title}
            <li><a href="{$clsCountryEx->getLink($listCountryDestination[i].country_id)}" title="{$title_country}">{$title_country}</a></li>
            {/section}
        </ul>
    </li>
    <li class="relative">
        <a href="javascript:void(0);" title="{$core->get_Lang('Travel styles')}" role="link">{$core->get_Lang('Travel styles')} </a>
        {if $lstCatTour}
        <ul class="submenu">
            {section name=j loop=$lstCatTour}
            {assign var=title_category value=$clsTourCategory->getTitle($lstCatTour[j].tourcat_id)}
            <li><a  title="{$title_category}" href="{$clsTourCategory->getLink($lstCatTour[j].tourcat_id)}">{$title_category} </a></li>
            {/section}
        </ul>
        {/if}
    </li>
    <li class="relative">
        <a href="javascript:void(0);" title="{$core->get_Lang('Other Product')}" role=link aria-disabled=true>{$core->get_Lang('Other Product')}</a>
        <ul class="submenu">
            <li><a href="{$clsISO->getLink('hotel')}" title="{$core->get_Lang('Stay')}">{$core->get_Lang('Stay')}</a></li>
            <li><a href="{$clsISO->getLink('cruise')}" title="{$core->get_Lang('Cruise')}">{$core->get_Lang('Cruise')}</a></li>
            <li><a href="{$clsISO->getLink('voucher')}" title="{$core->get_Lang('Voucher')}">{$core->get_Lang('Voucher')}</a></li>
        </ul>
    </li>
    <li class="relative">
		<a href="{$clsISO->getLink('news')}" title="{$core->get_Lang('Experience')}" class="color_1c1c1c"> {$core->get_Lang('Experience')}</a>
	</li>
	<li class="relative">
		<a href="{$clsISO->getLink('blog')}" title="{$core->get_Lang('Blog')}" class="color_1c1c1c"> {$core->get_Lang('Blog')}</a>
	</li>
	<li class="menu_promotion">
		<a href="{$clsISO->getLink('promotion')}" title="{$core->get_Lang('Promotion')}" class="color_1c1c1c"> {$core->get_Lang('Deals')}</a>
	</li>
    {else}
	{if $package_id!=1}
		<li class="relative">
			<a href="javascript:void(0);" title="{$core->get_Lang('Domestic tours')}" role=link aria-disabled=true>{$core->get_Lang('Domestic tours')}</a>
			<ul class="submenu">
				{section name=i loop=$lstRegionTour}
				{assign var=TitleRegion value=$clsRegion->getTitle($lstRegionTour[i].region_id)}
				{assign var=slugRegion value=$clsRegion->getSlug($lstRegionTour[i].region_id)}
				{assign var=listCityTourByRegion value=$lstRegionTour[i].listCityTourByRegion}
				<li>
					<a href="javascript:void(0);" title="{$TitleRegion}" >{$TitleRegion}</a>
					<ul class="submenu">
						{section name=j loop=$listCityTourByRegion}
						{assign var=titleCityTourByRegion value=$clsCity->getTitle($listCityTourByRegion[j].city_id,$listCityTourByRegion[j])}
						{assign var=linkCityTourByRegion value=$clsCity->getLinkInbound($listCityTourByRegion[j].city_id,$listCityTourByRegion[j])}
						<li><a href="{$linkCityTourByRegion}" title="{$titleCityTourByRegion}">{$titleCityTourByRegion}</a></li>
						{/section}
					</ul>
				</li>
				{/section}
			</ul>
		</li>
		<li class="relative">
			<a href="javascript:void(0);" title="{$core->get_Lang('Outbound tours')}" role=link aria-disabled=true>{$core->get_Lang('Outbound tours')}</a>
			<ul class="submenu">
				{section name=i loop=$lstCountryTourOutbound}
				{assign var=country__id value=$lstCountryTourOutbound[i].country_id}
				{assign var=title_country value=$clsCountryEx->getTitle($lstCountryTourOutbound[i].country_id)}
				<li class="menuhover"><a href="{$clsCountryEx->getLinkOutbound($lstCountryTourOutbound[i].country_id)}" title="{$title_country}">{$title_country}</a></li>
				{/section}
			</ul>
		</li>
		<li class="relative">
			<a href="javascript:void(0);" title="{$core->get_Lang('Travel styles')}" role=link aria-disabled=true>{$core->get_Lang('Travel styles')} </a>
			{if $clsISO->getCheckActiveModulePackage($package_id,'tour','category_country','default')}
			<ul class="submenu">
				{section name=i loop=$lstCountryTourOutbound}
				{assign var=country__id value=$lstCountryTourOutbound[i].country_id}
				{assign var=title_country value=$clsCountryEx->getTitle($lstCountryTourOutbound[i].country_id)}
				{assign var=lstCountryCat value=$clsCategory_Country->getListCatCountry($country__id)}
				{if $lstCountryCat}
				<li><a href="javascript:void(0);" role=link aria-disabled=true>{$title_country}</a>
					<ul class="submenu">
						{section name=j loop=$lstCountryCat}
						{assign var=title_category_country value=$clsTourCategory->getTitle($lstCountryCat[j].cat_id)}
						<li>
							<a href="{$clsTourCategory->getLinkCatCountry($lstCountryCat[j].cat_id,$country__id)}"
							   title="{$title_category_country}">
								{$title_category_country}
							</a>
						</li>
						{/section}
					</ul>
				</li>
				{/if}
				{/section}
			</ul>
			{else}
			{if $lstCatTour}
			<ul class="submenu">
				{section name=j loop=$lstCatTour}
				{assign var=title_category value=$clsTourCategory->getTitle($lstCatTour[j].tourcat_id)}
				<li><a title="{$title_category}" href="{$clsTourCategory->getLink($lstCatTour[j].tourcat_id)}">{$title_category} </a></li>
				{/section}
			</ul>
			{/if}
			{/if}
		</li>


        <li class="relative">
			<a href="javascript:void(0);" title="{$core->get_Lang('Stay')}" role=link aria-disabled=true>{$core->get_Lang('Stay')}</a>
			<ul class="submenu">
                {section name=i loop=$lstCountryHotel}
                {assign var=country_hotel_title value=$lstCountryHotel[i].title}
                <li><a href="{$clsCountryEx->getLink($lstCountryHotel[i].country_id,'Hotel',$lstCountryHotel[i])}"
                       title="{$country_hotel_title}">{$country_hotel_title}</a>
                </li>
                {/section}
			</ul>
		</li>
        <li class="relative">
			<a href="javascript:void(0);" title="{$core->get_Lang('Cruise')}" role=link aria-disabled=true>{$core->get_Lang('Cruise')}</a>
			<ul class="submenu">
                {section name=i loop=$lstCruiseCat}
                {assign var=_cruisecat_id value=$lstCruiseCat[i].cruise_cat_id}
                {assign var=title_cruisecat value=$lstCruiseCat[i].title}
                {assign var=link_cruisecat value=$clsCruiseCat->getLink($_cruisecat_id,$lstCruiseCat[i])}
                {if $clsISO->getCheckActiveModulePackage($package_id,'cruise','cruise_sub_category','customize')}
                    {assign var=childCat value=$clsCruiseCat->getMenuChild($_cruisecat_id)}

                    <li><a href="{$link_cruisecat}"
                           title="{$title_cruisecat}">{$title_cruisecat}</a>
                            {$childCat}
                    </li>
                {else}
                    <li><a href="{$link_cruisecat}"
                           title="{$title_cruisecat}">{$title_cruisecat}</a>
                    </li>
                {/if}
                {/section}
			</ul>
		</li>

        <li class="relative">
			<a href="{$clsISO->getLink('voucher')}" title="{$core->get_Lang('Voucher')}" class="color_1c1c1c"> {$core->get_Lang('Voucher')}</a>
		</li>
	{else}
		<li class="relative">
			<a href="{$clsISO->getLink('search_tour')}" title="{$core->get_Lang('Our')}" class="color_1c1c1c"> {$core->get_Lang('Our')}</a>
		</li>
		<li class="relative">
			<a href="javascript:void(0);" title="{$core->get_Lang('Travel Styles')}" role=link aria-disabled=true>{$core->get_Lang('Travel Styles')} </a>
			<ul class="submenu">
				{section name=i loop=$lstCatTour}
				{assign var = title_category value = $lstCatTour[i].title}
					<li><a class="color_333" title="{$title_category}" href="{$clsTourCategory->getLink($lstCatTour[i].tourcat_id)}">{$title_category}</a></li>
				{/section}
			</ul>
		</li>
		<li class="relative">
			<a href="{$clsISO->getLink('tailor')}" title="{$core->get_Lang('Tailor made tour')}" class="color_1c1c1c"> {$core->get_Lang('Tailor made tour')}</a>
		</li>
		<li class="relative">
			<a href="{$clsISO->getLink('service')}" title="{$core->get_Lang('Services')}" class="color_1c1c1c"> {$core->get_Lang('Services')}</a>
		</li>
	{/if}
	<li class="relative">
		<a href="{$clsISO->getLink('news')}" title="{$core->get_Lang('News')}" class="color_1c1c1c"> {$core->get_Lang('News')}</a>
	</li>
	<li class="relative">
		<a href="{$clsISO->getLink('blog')}" title="{$core->get_Lang('Blog')}" class="color_1c1c1c"> {$core->get_Lang('Blog')}</a>
	</li>
    {if $package_id==3 || $package_id==4}
	<li class="menu_promotion">
		<a href="{$clsISO->getLink('promotion')}" title="{$core->get_Lang('Promotion')}" class="color_1c1c1c"> {$core->get_Lang('Promotion')}</a>
	</li>
    {/if}
    {/if}
</ul>
{if 0}
<span class="find_mobi"><i class="fa fa-search" aria-hidden="true"></i></span>
{/if}
{literal}
<script>
    $(document).ready(function() {
        $(".mobile_menu").slideMobileMenu({
            onMenuLoad: function(menu) {
                console.log(menu)
            },
            onMenuToggle: function(menu, opened) {
                console.log(opened)
            }
        });
        $('.find_mobi').on('click', function () {
            $('.content_banner').toggle();
        })

        $('.icon_search').click(function(){
            $('.search_box').addClass('show_search');
            $('.search_top_mb').focus();	
        });
        $('.search_top_mb').focusout(function(){
            $(this).closest('.search_box').removeClass('show_search');
        });
    })
</script>
{/literal}