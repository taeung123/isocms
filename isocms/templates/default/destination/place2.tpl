<section class="hnv_des_banner">
    <div class="hnv_des_banner_category">
        <nav class="navbar navbar-expand-lg hnv_des_banner_category_nav">
            <div class="container">
                <div class="collapse navbar-collapse hnv_des_banner_category_collapse" id="hnv_des_banner_category_menu">
                    <ul class="navbar-nav hnv_des_banner_category_navbar_nav">
                        <li class="nav-item hnv_des_banner_category_nav_item">
                            <a class="nav-link hnv_des_banner_category_nav_link" href="javascript:void(0);"
                               data-href="hnv_des_attractions">
                                {$core->get_Lang('Introduction')} {$clsCountry->getTitle($country_id)}
                            </a>
                        </li>
                        <li class="nav-item hnv_des_banner_category_nav_item">
                            <a class="nav-link hnv_des_banner_category_nav_link" href="javascript:void(0);"
                               data-href="hnv_des_attractions_list">
                                {$core->get_Lang('Top attractions')}
                            </a>
                        </li>
                        <li class="nav-item hnv_des_banner_category_nav_item dropdown hnv_des_banner_category_nav_item_dropdown">
                            <a class="nav-link hnv_des_banner_category_nav_link dropdown-toggle hnv_dropdown_toggle"
                               href="javascript:void(0);" data-href="hnv_des_tour">
                                {$core->get_Lang('Explore')} <i class="fa-light fa-angle-down"></i>
                            </a>
                            {if $arr_tsbc}
                                <ul class="dropdown-menu hnv_dropdown_menu">
                                    {foreach from=$arr_tsbc key=key item=item}
                                        {assign var=cat_id value=$item.cat_id}
                                        <li>
                                            <a class="dropdown-item"
                                               href="{$clsTourCategory->getLinkCatCountry($cat_id, $country_id)}">
                                                {$clsTourCategory->getTitle($cat_id)}
                                            </a>
                                        </li>
                                    {/foreach}
                                </ul>
                            {/if}
                        </li>
                        <li class="nav-item hnv_des_banner_category_nav_item">
                            <a class="nav-link hnv_des_banner_category_nav_link" href="javascript:void(0);"
                               data-href="hnv_des_thingtodo">
                                {$core->get_Lang('Things to do')}
                            </a>
                        </li>
                        <li class="nav-item hnv_des_banner_category_nav_item">
                            <a class="nav-link hnv_des_banner_category_nav_link" href="javascript:void(0);"
                               data-href="hnv_des_review">
                                {$core->get_Lang('Reviews')}
                            </a>
                        </li>
                        <li class="nav-item hnv_des_banner_category_nav_item">
                            <a class="nav-link hnv_des_banner_category_nav_link" href="javascript:void(0);"
                               data-href="hnv_des_blog">
                                {$core->get_Lang('Inspiration')}
                            </a>
                        </li>
                        <li class="nav-item hnv_des_banner_category_nav_item">
                            <a class="nav-link hnv_des_banner_category_nav_link" href="javascript:void(0);"
                               data-href="hnv_des_attention">
                                {$core->get_Lang('Notes')}
                            </a>
                        </li>
                        <a href="{$clsISO->getLink('tailor')}" title="{$core->get_Lang('Plan your trips')}"
                           class="hnv_des_banner_category_link">
                            {$core->get_Lang('Plan your trips')}
                        </a>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="hnv_des_banner_image"
         style="background-image: url('{$clsCountry->getBanner($country_id,1920,400)}')">
        <div class="hnv_des_banner_title">
            <h1>{$clsCountry->getTitle($country_id)}</h1>
        </div>
        {if $arr_country_gallery}
            <div class="hnv_des_banner_gallery">
                <div class="hnv_des_banner_gallery_title">{$core->get_Lang('Gallery')}</div>
                <div class="hnv_des_banner_gallery_image">
                    {foreach from=$arr_country_gallery key=key item=item name=loop}
                        {if $smarty.foreach.loop.first}
                            {assign var=country_image_id value=$item.country_image_id}
                            <a data-fancybox="gallery"
                               href="{$clsCountryImage->getImage($country_image_id,800,600)}">
                                <img src="{$clsCountryImage->getImage($country_image_id,800,600)}"
                                     alt="Country Gallery"
                                     width="76" height="76"/>
                            </a>
                        {/if}
                    {/foreach}
                    {assign var=count_gal value=0}
                    {foreach from=$arr_country_gallery key=key item=item name=loop}
                        {if !$smarty.foreach.loop.first}
                            {assign var=count_gal value=$count_gal+1}
                            {assign var=country_image_id value=$item.country_image_id}
                            <a data-fancybox="gallery"
                               href="{$clsCountryImage->getImage($country_image_id,800,600)}">
                            </a>
                        {/if}
                    {/foreach}
                    {if $count_gal ne 0}
                        <div class="hnv_des_banner_gallery_image_quantity">+{$count_gal}</div>
                    {/if}
                </div>
            </div>
        {/if}
    </div>
</section>
<section class="hnv_des_attractions">
    <div class="container">
        <nav class="breadcrumb-main breadcrumb-{$mod} bg_fff">
            <div class="container">
                <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{$PCMS_URL}"> <span itemprop="name"
                                                                     class="reb">{$core->get_Lang('Home')}</span></a>
                        <meta itemprop="position" content="1"/>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a
                                itemprop="item" href="{$curl}"> <span itemprop="name"
                                                                      class="reb">{$core->get_Lang('Destinations')}</span></a>
                        <meta itemprop="position" content="2"/>
                    </li>
                    {if $country_id}
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a
                                    itemprop="item" href="{$curl}"> <span itemprop="name"
                                                                          class="reb">{$clsCountry->getTitle($country_id)}</span></a>
                            <meta itemprop="position" content="3"/>
                        </li>
                    {/if}
                    {if $city_id|default:0 != 0}
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a
                                    itemprop="item" href="{$curl}"> <span itemprop="name"
                                                                          class="reb">{$clsCity->getTitle($city_id)}</span></a>
                            <meta itemprop="position" content="3"/>
                        </li>
                    {/if}
                </ol>
            </div>
        </nav>
        <div class="hnv_des_attractions_intro">
            {$clsCountry->getContent($country_id)}
        </div>
        {if !empty($arr_country_why)}
            <div class="hnv_des_attractions_info">
                <div class="row">
                    <div class="owl-carousel owl-theme owl_hnv_des_attractions_info">
                        {foreach from=$arr_country_why key=key item=item}
                            {assign var=why_choose_country_id value=$item.why_choose_country_id}
                            <div class="card owl_hnv_des_attractions_info_item" data-merge="1">
                                <div class="owl_hnv_des_attractions_info_item_image">
                                    <img class="owl-lazy"
                                         data-src="{$clsWhyChooseCountry->getImage($why_choose_country_id,68,68)}"
                                         width="68" height="68"
                                         alt="{$clsWhyChooseCountry->getTitle($why_choose_country_id)}">
                                </div>
                                <div class="owl_hnv_des_attractions_info_item_title">
                                    <h2 class="truncate truncate_2">{$clsWhyChooseCountry->getTitle($why_choose_country_id)}</h2>
                                </div>
                                <div class="owl_hnv_des_attractions_info_item_description truncate truncate_5">
                                    {$clsWhyChooseCountry->getIntro($why_choose_country_id)}
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        {/if}
        {if $arr_city_top|@count}
            <div class="hnv_des_attractions_list">
                <div class="hnv_des_attractions_list_title">
                    <h2>{$core->get_Lang('Must-see attractions')}</h2>
                </div>
                <div class="row">
                    <div class="owl-carousel owl-theme owl_hnv_des_attractions_list">
                        {foreach from=$arr_city_top key=key item=item}
                            {assign var=city_id value=$item.city_id}
                            <div class="owl_hnv_item owl_hnv_des_attractions_list_item" data-merge="1">
                                <a href="{$clsCity->getLinkInbound($city_id)}" title="{$clsCity->getTitle($city_id)}">
                                    <div class="owl_hnv_des_attractions_list_item_image">
                                        <img class="owl-lazy"
                                             data-src="{$clsCity->getImage($city_id,297,297)}"
                                             width="297" height="297" alt="{$clsCity->getTitle($city_id)}">
                                    </div>
                                    <div class="owl_hnv_des_attractions_list_item_title">
                                        <h3 class="truncate truncate_1">{$clsCity->getTitle($city_id)}</h3>
                                        <div class="owl_hnv_des_attractions_list_item_title_icon">
                                            <i class="fa-light fa-arrow-right"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        {/if}
    </div>
</section>
{if !empty($filtered_tours)}
    <section class="hnv_des_tour">
        <div class="container">
            <div class="hnv_des_tour_title">
                <h2>{$core->get_Lang('Ideas for Travel in')} {$clsCountry->getTitle($country_id)}</h2>
                <a href="{$clsCountry->getLink($country_id, 'tour_new')}"
                   class="hnv_des_tour_title_link hnv_link_active"
                   title="{$core->get_Lang('View all tours')}">
                    {$core->get_Lang('View all tours')}
                </a>
            </div>
            <div class="hnv_des_tour_list">
                <div class="owl-carousel owl-theme owl_hnv_des_tour_list">
                    {foreach from=$filtered_tours key=key item=item}
                        {assign var=tour_id value=$item.tour_id}
                        {assign var=tour_title value=$clsTour->getTitle($tour_id)}
                        {assign var=tour_link value=$clsTour->getLink($tour_id)}
                        {assign var=getToTalReview value=$clsReviews->getToTalReview($tour_id,'tour')}
                        {assign var=getRateAvg value=$clsReviews->getRateAvg($tour_id,'tour')}
                        {assign var=getRateStar value=$clsReviews->getRateStar($tour_id,'tour')}
                        {assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent)}
                        {assign var=getStarNewIcon value=$clsReviews->getStarNewIcon($tour_id,'tour')}
                        <div class="owl_hnv_des_tour_list_item" data-merge="1">
                            <a href="{$tour_link}" title="{$tour_title}">
                                <div class="owl_hnv_des_tour_list_item_image">
                                    <img class="owl-lazy"
                                         data-src="{$clsTour->getImage($tour_id,407,272)}"
                                         width="407" height="272" alt="{$tour_title}">
                                </div>
                            </a>
                            <div class="owl_hnv_des_tour_list_item_intro">
                                {if $clsTour->getDepartureCity($tour_id) ne ''}
                                    <div class="owl_hnv_des_tour_list_item_intro_place">
                                        <i class="fa-light fa-location-dot"></i>
                                        {$core->get_Lang('Start')}: {$clsTour->getDepartureCity($tour_id)}
                                        , {$clsCountry->getTitle($country_id)}
                                    </div>
                                {/if}
                                <div class="owl_hnv_des_tour_list_item_intro_title">
                                    <h3 class="truncate truncate_2">
                                        <a href="{$tour_link}" title="{$tour_title}">
                                            {$tour_title}
                                        </a>
                                    </h3>
                                </div>
                                <div class="owl_hnv_des_tour_list_item_intro_rates">
                                    <div class="box_date_tour">
                                        <p>
                                            {$clsTour->getTripDayText($tour_id)}
                                        </p>
                                        <p class="txt_dot_date">|</p>
                                    </div>
                                    <div class="owl_hnv_des_tour_list_item_intro_rates_star">
                                        {$getStarNewIcon}
                                    </div>
                                    <div class="owl_hnv_des_tour_list_item_intro_rates_score">{$getRateAvg}</div>
                                    <div class="owl_hnv_des_tour_list_item_intro_rates_quantity">({$getToTalReview})
                                    </div>
                                </div>
                                <div class="owl_hnv_des_tour_list_item_intro_price">
                                    {*                                    <div style="width: 100%">*}
                                    {*                                        <span class="owl_hnv_des_tour_list_item_intro_price_from">{$core->get_Lang('from')}</span>*}
                                    {*                                        <span class="owl_hnv_des_tour_list_item_intro_price_currency">{$core->get_Lang('US')}</span>*}
                                    {*                                        <span class="owl_hnv_des_tour_list_item_intro_price_number">$916</span>*}
                                    {*                                    </div>*}
                                    {if $getPriceTourPromotion}
                                        {$getPriceTourPromotion}
                                    {else}
                                        <p class="size20 color_c81e3a text-bold mb0">{$core->get_Lang('Contact')}</p>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </section>
{/if}
{if isset($arr_country_hotel) && $arr_country_hotel|@count
    || isset($arr_country_cruise) && $arr_country_cruise|@count}
    <section class="hnv_des_accommodation">
        <div class="container">
            <div class="hnv_des_accommodation_list">
                <div class="hnv_des_accommodation_list_title">
                    <h2>{$core->get_Lang('Explore other services we offer in')} {$clsCountry->getTitle($country_id)}</h2>
                                        <a href="{if $arr_country_hotel} {if $_LANG_ID ne 'vn'} /{$_LANG_ID}{$clsISO->getLink('hotel')}{$clsCountry->getSlug($country_id)} {else} {$clsISO->getLink('hotel')}/{$clsCountry->getSlug($country_id)}{/if} {else} {$clsISO->getLink('cruise')}{/if}"
                       class="hnv_des_accommodation_link hnv_link_active">
                       
                        {if $arr_country_hotel} 
                             {$core->get_Lang('View all hotels')}
                        {else} 
                            {$core->get_Lang('View all cruises')}
                        {/if}
                    </a>
                </div>
                <div class="hnv_des_accommodation_list_option">
                    {if $arr_country_hotel ne ''}
                        <a href="javascript:void(0);" data-href="{$clsISO->getLink('hotel')}"
                           title="{$core->get_Lang('Accommodation')}"
                           class="hnv_des_accommodation_list_option_hotel hnv_link_active">
                            {$core->get_Lang('Accommodation')}
                        </a>
                    {/if}
                    {if $arr_country_cruise ne ''}
                        <a href="javascript:void(0);" data-href="{$clsISO->getLink('cruise')}"
                           title="{$core->get_Lang('Cruise')}"
                           class="hnv_des_accommodation_list_option_cruise hnv_link_active {if $arr_country_hotel eq ''} hnv_des_accommodation_list_option_active {/if}">
                            {$core->get_Lang('Cruise')}
                        </a>
                    {/if}
                </div>
                <div class="row">
                    {if $arr_country_hotel ne ''}
                        <div class="owl-carousel owl-theme owl_hnv_des_accommodation_list">
                            {foreach from=$arr_country_hotel key=key item=item}
                                {assign var=hotel_id value=$item.hotel_id}
                                {assign var=hotel_title value=$clsHotel->getTitle($hotel_id)}
                                {assign var=hotel_link value=$clsHotel->getLink($hotel_id)}
                                {assign var=city_id value=$item.city_id}

                                {assign var= ratingValue value= $clsReviews->getRateAvg($hotel_id,'hotel')}
                                {assign var= ratingCount value= $clsReviews->getToTalReview($hotel_id,'hotel')}
                                {assign var= textRateAvg value= $clsReviews->getTextRateAvg($hotel_id,'hotel')}
                                <div class="owl_hnv_des_accommodation_list_item" data-merge="1">
                                    <a href="{$hotel_link}" title="{$hotel_title}">
                                        <div class="owl_hnv_des_accommodation_list_item_image">
                                            <img class="owl-lazy"
                                                 data-src="{$clsHotel->getImage($hotel_id,298,276)}"
                                                 width="298" height="276"
                                                 alt="{$hotel_title}">
                                            {if $city_id}
                                                <div class="owl_hnv_des_accommodation_list_item_place">{$clsCity->getTitle($city_id)}</div>
                                            {/if}
                                        </div>
                                    </a>
                                    <div class="owl_hnv_des_accommodation_list_item_intro">
                                        <div class="owl_hnv_des_accommodation_list_item_intro_title">
                                            <h3 class="truncate truncate_2">
                                                <a href="{$hotel_link}" title="{$hotel_title}">
                                                    {$hotel_title}
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="owl_hnv_des_accommodation_list_item_intro_rates">
                                            <div class="owl_hnv_des_accommodation_list_item_intro_rates_star">
                                                {foreach from=range(1, 5) key=key item=index}
                                                    {if $index <= floor($ratingValue)}
                                                        <i class="fa-solid fa-star hnv_star_filled"></i>
                                                    {elseif $index == ceil($ratingValue)}
                                                        <i class="fa-solid fa-star-half-stroke hnv_star_filled"></i>
                                                    {else}
                                                        <i class="fa-solid fa-star hnv_star_default"></i>
                                                    {/if}
                                                {/foreach}
                                            </div>
                                            <div class="owl_hnv_des_accommodation_list_item_intro_rates_score">{$ratingValue}</div>
                                            <div class="owl_hnv_des_accommodation_list_item_intro_rates_quantity">
                                                ({$ratingCount})
                                            </div>
                                        </div>
                                        <div class="owl_hnv_des_accommodation_list_item_intro_price">
                                            <span class="owl_hnv_des_accommodation_list_item_intro_price_from">{$core->get_Lang('From')}</span>
                                            {*<span class="owl_hnv_des_accommodation_list_item_intro_price_currency">
                                                {$core->get_Lang('US')}
                                            </span>*}
                                            <span class="owl_hnv_des_accommodation_list_item_intro_price_number">
                                                {$clsHotel->getPriceOnPromotion($hotel_id)}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    {/if}
                    {if $arr_country_cruise ne ''}
                        <div class="owl-carousel owl-theme owl_hnv_des_cruise_list" {if $arr_country_hotel}style="display: none;"{/if}>
                            {foreach from=$arr_country_cruise key=key item=item}
                                {assign var=cruise_id value=$item.cruise_id}
                                {assign var=cruise_title value=$clsCruise->getTitle($cruise_id)}
                                {assign var=cruise_link value=$clsCruise->getLink($cruise_id)}
                                {assign var=city_id value=$item.city_id}

                                {assign var= ratingValue value= $clsReviews->getRateAvg($cruise_id,'cruise')}
                                {assign var= ratingCount value= $clsReviews->getToTalReview($cruise_id,'cruise')}
                                {assign var= textRateAvg value= $clsReviews->getTextRateAvg($cruise_id,'cruise')}
                                {if $cruise_title}
                                    <div class="owl_hnv_des_accommodation_list_item" data-merge="1">
                                        <a href="{$cruise_link}" title="{$cruise_title}">
                                            <div class="owl_hnv_des_accommodation_list_item_image">
                                                <img class="owl-lazy"
                                                     data-src="{$clsCruise->getImage($cruise_id,298,276)}"
                                                     width="298" height="276"
                                                     alt="{$cruise_title}">
                                                {if $city_id}
                                                    <div class="owl_hnv_des_accommodation_list_item_place">{$clsCity->getTitle($city_id)}</div>
                                                {/if}
                                            </div>
                                        </a>
                                        <div class="owl_hnv_des_accommodation_list_item_intro">
                                            <div class="owl_hnv_des_accommodation_list_item_intro_title">
                                                <h3 class="truncate truncate_2">
                                                    <a href="{$cruise_link}" title="{$cruise_title}">
                                                        {$cruise_title}
                                                    </a>
                                                </h3>
                                            </div>
                                            <div class="owl_hnv_des_accommodation_list_item_intro_rates">
                                                <div class="owl_hnv_des_accommodation_list_item_intro_rates_star">
                                                    {foreach from=range(1, 5) key=key item=index}
                                                        {if $index <= floor($ratingValue)}
                                                            <i class="fa-solid fa-star hnv_star_filled"></i>
                                                        {elseif $index == ceil($ratingValue)}
                                                            <i class="fa-solid fa-star-half-stroke hnv_star_filled"></i>
                                                        {else}
                                                            <i class="fa-solid fa-star hnv_star_default"></i>
                                                        {/if}
                                                    {/foreach}
                                                </div>
                                                <div class="owl_hnv_des_accommodation_list_item_intro_rates_score">{$ratingValue}</div>
                                                <div class="owl_hnv_des_accommodation_list_item_intro_rates_quantity">
                                                    ({$ratingCount})
                                                </div>
                                            </div>
                                            <div class="owl_hnv_des_accommodation_list_item_intro_price">
                                                {*                                        <span class="owl_hnv_des_accommodation_list_item_intro_price_from">{$core->get_Lang('from')}</span>*}
                                                {*                                        <span class="owl_hnv_des_accommodation_list_item_intro_price_currency">{$core->get_Lang('US')}</span>*}
                                                <span class="owl_hnv_des_accommodation_list_item_intro_price_number">
                                            {$clsCruise->getLTripPrice1($cruise_id,$now_month)}
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                    {/if}

                </div>
            </div>
        </div>
    </section>
{/if}

{if !empty($listGuideCat)}
    <section class="hnv_des_thingtodo">
        <div class="container">
            <div class="hnv_des_thingtodo_title">
                <h2>{$core->get_Lang('Things to do in')} {$clsCountry->getTitle($country_id)}</h2>
            </div>
            <div class="hnv_des_thingtodo_description">
                {$core->get_Lang('Trips will show you all the best things to do in')} {$clsCountry->getTitle($country_id)}
            </div>
            <div class="hnv_des_thingtodo_list">
                <div class="row">
                    <div class="owl-carousel owl-theme owl_hnv_des_thingtodo_list">
                        {foreach from=$listGuideCat item=cat}
                            {assign var=title_catguide value=$cat.title|default:''}
                            {assign var=link_gudiecat value=$clsGuideCat->getLinkGuideCountry($cat.guidecat_id, "cat", $country_id)}
                            {assign var=img_catguide value=$clsGuideCat->getImage($cat.guidecat_id, 40, 40)}
                            {assign var=intro_catguide value=$cat.intro|default:''}
                            
                            <div class="owl_hnv_item owl_hnv_des_thingtodo_list_item" data-merge="1">
                                <a href="{$link_gudiecat}" title="{$title_catguide}">
                                    <div class="owl_hnv_des_thingtodo_item_title">
                                        <div class="owl_hnv_des_thingtodo_item_image">
                                            <img class="owl-lazy"
                                                data-src="{$img_catguide}"
                                                width="40" height="40" alt="{$title_catguide}">
                                        </div>
                                        <h3 class="truncate truncate_1">{$title_catguide}</h3>
                                    </div>
                                    <div class="owl_hnv_des_thingtodo_item_description truncate truncate_3">
                                        {$intro_catguide|html_entity_decode}
                                    </div>
                                    <a href="{$link_gudiecat}" title="{$title_catguide}"
                                    class="owl_hnv_des_thingtodo_item_link">
                                        {$core->get_Lang('View more')} <i class="fa-light fa-arrow-right"></i>
                                    </a>
                                </a>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}
{$core->getBlock('2024_review_customer')}
{if $arr_country_blog}
    <section class="hnv_des_blog">
        <div class="container">
            <div class="hnv_des_blog_title">
                <h2>{$core->get_Lang('Latest stories from')} {$clsCountry->getTitle($country_id)}</h2>
                <a href="{$clsCountry->getLink($country_id, 'Blog')}" title="{$core->get_Lang('View more')}"
                   class="hnv_des_blog_title_link hnv_link_active">
                    {$core->get_Lang('View all blogs')}
                </a>
            </div>
            <div class="hnv_des_blog_list">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8">
                        {foreach from=$arr_country_blog key=key item=item name=loop}
                            {if $smarty.foreach.loop.first}
                                {assign var=cat_id value=$item.cat_id}
                                {assign var=blog_id value=$item.blog_id}
                                {assign var=blog_title value=$clsBlog->getTitle($blog_id)}
                                <div class="hnv_des_blog_first"
                                     style="background-image: url('{$clsBlog->getImage($blog_id,787,616)}');">
                                    <div class="hnv_des_blog_first_category">
                                        <a href="{$clsBlogCategory->getLink($cat_id)}"
                                           title="{$clsBlogCategory->getTitle($cat_id)}">
                                            {$clsBlogCategory->getTitle($cat_id)}
                                        </a>
                                    </div>
                                    <div class="hnv_des_blog_first_title">
                                        <h3>
                                            <a href="{$clsBlog->getLink($blog_id)}" title="{$blog_title}">
                                                {$blog_title}
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="hnv_des_blog_first_time">
                                        {$clsBlog->getPublicDate($blog_id)}
                                    </div>
                                    <div class="hnv_des_blog_first_description">
                                        {$clsBlog->getIntro($blog_id)}
                                    </div>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4">
                        {foreach from=$arr_country_blog key=key item=item name=loop}
                            {if !$smarty.foreach.loop.first}
                                {assign var=cat_id value=$item.cat_id}
                                {assign var=blog_id value=$item.blog_id}
                                {assign var=blog_title value=$clsBlog->getTitle($blog_id)}
                                {assign var=blog_link value=$clsBlog->getLink($blog_id)}
                                <div class="hnv_des_blog_list_item">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="hnv_des_blog_list_item_image">
                                                <a href="{$blog_link}" title="{$blog_title}">
                                                    <img loading="lazy"
                                                         src="{$clsBlog->getImage($blog_id,112,92)}"
                                                         width="112" height="92"
                                                         alt="{$blog_title}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-8 col-lg-8">
                                            <div class="hnv_des_blog_list_item_category">
                                                <a href="{$clsBlogCategory->getLink($cat_id)}"
                                                   title="{$clsBlogCategory->getTitle($cat_id)}">
                                                    {$clsBlogCategory->getTitle($cat_id)}
                                                </a>
                                            </div>
                                            <div class="hnv_des_blog_list_item_title">
                                                <h3 class="truncate truncate_3">
                                                    <a href="{$blog_link}" title="{$blog_title}">
                                                        {$blog_title}
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}
{if $arr_faq ne ''}
    <section class="hnv_des_attention">
        <div class="container">
            <div class="hnv_des_attention_title">
                <h2>{$clsCountry->getTitle($country_id)} {$core->get_Lang('travel need attention')}?</h2>
            </div>
            <div class="hnv_des_attention_content">
                <div class="row">
                    <div class="col-md-12 col-lg-9">
                        <div class="hnv_des_attention_content_list">
                            <div class="accordion" id="hnv_des_attention_accordion">
                                {foreach from=$arr_faq key=key item=item}
                                    {assign var=faq_id value=$item.faq_id}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-heading_{$key}">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#panelsStayOpen-collapse_{$key}"
                                                    aria-expanded="false"
                                                    aria-controls="panelsStayOpen-collapse_{$key}">
                                                {$clsFAQ->getTitle($faq_id)}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapse_{$key}" class="accordion-collapse collapse"
                                             aria-labelledby="panelsStayOpen-heading_{$key}">
                                            <div class="accordion-body">
                                                {$clsFAQ->getContent($faq_id)}
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3">
                        <div class="hnv_des_attention_content_tour">
                            <div class="hnv_des_attention_content_tour_image">
                                <img loading="lazy"
                                     src="/uploads/AdminButton/travel-1.png"
                                     width="48" height="48"
                                     alt="{$core->get_Lang('Explore more easily through tour experiences')}">
                            </div>
                            <div class="hnv_des_attention_content_tour_title">
                                <h3>{$core->get_Lang('Explore more easily through tour experiences')}</h3>
                            </div>
                            <div class="hnv_des_attention_content_tour_description">
                                {$core->get_Lang('Let us make your travel dreams come true with our ready-made plans')}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}
<section class="hnv_des_tailormadetour">
    <div class="container">
        <div class="hnv_des_tailormadetour_box">
            <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="hnv_des_tailormadetour_content">
                        <div class="hnv_des_tailormadetour_content_title">
                            <h2>{$core->get_Lang("What’s need to travel here")}?</h2>
                        </div>
                        <div class="hnv_des_tailormadetour_content_description">
                            <span>{$core->get_Lang("Want a unique trip? Submit a tour request today, and we will design an itinerary that suits you!")}</span><br>
                            <span>
                            <strong>{$core->get_Lang("Fill in the information and submit your request now!")}</strong> {$core->get_Lang("We will respond quickly so you can have a great travel experience soon!")}
                        </span>
                        </div>
                        <a href="{$clsISO->getLink('tailor')}" title="{$core->get_Lang("Tailor made tour")}"
                           class="hnv_des_tailormadetour_content_link">
                            {$core->get_Lang("Tailor made tour")}
                        </a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="hnv_des_tailormadetour_image">
                        <img loading="lazy"
                             src="/uploads/Banner/b83d831f-55cf-4645-bdaf-575c3a64ee53-01-1.png"
                             width="391" height="313" alt="{$core->get_Lang('Tailor made tour image')}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{if $arr_country_destination ne ''}
    <section class="hnv_des_destination">
        <div class="container">
            <div class="hnv_des_destination_title">
                <h2>{$core->get_Lang('You may also be interested in')}</h2>
            </div>
            <div class="hnv_des_destination_content">
                <div class="row">
                    <div class="owl-carousel owl-theme owl_hnv_des_destination_list">
                        {foreach from=$arr_country_destination key=key item=item}
                            {assign var=country_id value=$item.country_id}
                            {assign var=country_title value=$clsCountry->getTitle($country_id)}
                            {assign var=country_link value=$clsCountry->getLink($country_id)}
                            <div class="owl_hnv_item owl_hnv_des_destination_list_item" data-merge="1">
                                <div class="owl_hnv_des_destination_item_image">
                                    <a href="{$country_link}" title="{$country_title}">
                                        <img class="owl-lazy"
                                             data-src="{$clsCountry->getImage($country_id,406,464)}"
                                             width="406" height="464" alt="{$country_title}">
                                    </a>
                                    <div class="owl_hnv_des_destination_item_title">
                                        <h3><a href="{$country_link}"
                                               title="{$country_title}">{$clsCountry->getTitle($country_id)}</a></h3>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}

{literal}
    <script>

(function () {
    'use strict';

    /**
     * Cuộn mượt đến vị trí chỉ định.
     *
     * @param {number} targetY  Vị trí cần cuộn đến
     * @param {number} duration Thời gian cuộn, đơn vị ms
     */
    function smoothScrollTo(targetY, duration) {
        var startY = window.pageYOffset || document.documentElement.scrollTop;
        var distance = targetY - startY;
        var startTime = null;

        function easeInOutCubic(progress) {
            return progress < 0.5
                ? 4 * progress * progress * progress
                : 1 - Math.pow(-2 * progress + 2, 3) / 2;
        }

        function animation(currentTime) {
            if (startTime === null) {
                startTime = currentTime;
            }

            var elapsed = currentTime - startTime;
            var progress = Math.min(elapsed / duration, 1);
            var easedProgress = easeInOutCubic(progress);

            window.scrollTo(0, startY + distance * easedProgress);

            if (progress < 1) {
                window.requestAnimationFrame(animation);
            }
        }

        window.requestAnimationFrame(animation);
    }

    document.addEventListener('click', function (event) {
        var link = event.target.closest(
            '.hnv_des_banner_category_nav_link'
        );

        if (!link) {
            return;
        }

        var targetName = link.getAttribute('data-href');

        if (!targetName) {
            return;
        }

        event.preventDefault();

        var section = document.getElementById(targetName);

        if (!section) {
            try {
                section = document.querySelector('.' + targetName);
            } catch (error) {
                console.warn('Tên section không hợp lệ:', targetName);
                return;
            }
        }

        if (!section) {
            console.warn('Không tìm thấy section:', targetName);
            return;
        }

        var offset = 20;
        var header = document.querySelector('header');

        if (header) {
            offset += header.getBoundingClientRect().height;
        }

        var destinationNav = document.querySelector(
            '.hnv_des_banner_category'
        );

        if (destinationNav) {
            var navStyle = window.getComputedStyle(destinationNav);

            if (
                navStyle.position === 'fixed' ||
                navStyle.position === 'sticky'
            ) {
                offset += destinationNav.getBoundingClientRect().height;
            }
        }

        var sectionTop =
            section.getBoundingClientRect().top +
            window.pageYOffset -
            offset;

        smoothScrollTo(Math.max(0, sectionTop), 900);

        document
            .querySelectorAll('.hnv_des_banner_category_nav_link')
            .forEach(function (item) {
                item.classList.remove('active');
            });

        link.classList.add('active');
    });
})();

</script>

    <style>
        .box_date_tour, .box_date_tour i {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 24px; /* 150% */
        }
        .owl_hnv_des_review_item_intro_description em, .owl_hnv_des_review_item_intro_description{
                -webkit-line-clamp: 3;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
                font-style: normal;
        }
        .box_date_tour {
            display: flex;
            gap: 8px;
            margin-right: 2px;
        }

        .box_date_tour p {
            margin: unset;
        }

        .box_date_tour .txt_dot_date {
            color: #A5A5A5;
        }
    </style>
{/literal}