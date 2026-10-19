<div class="page_container">
    <h1 style="display: none;">{PAGE_NAME}</h1>
    {$clsISO->getBlock('home/banner')}

    {* Body *}
    <div class="body_homecontainer">
        {$clsISO->getBlock('home/ads')}

        {$clsISO->getBlock('home/top_tour')}

        {if !empty($listCountryDestination)}
        <section class="offers_dest">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 txt_offersdest">
                        <h2 class="txt_offers">
                            {$core->get_Lang("Offers & featured destinations")}
                        </h2>
                        <p class="text_offes">
                            {$core->get_Lang('Delight in exceptional travel experiences at world-renowned destinations, thoughtfully curated to cater to your every desire.')}
                        </p>
                    </div>

                    <div class="col-md-8 img_infoffer">
                        <div class="swiper swiper-offers">
                            <div class="swiper-wrapper">
                                {foreach from=$lstOffersFeatured key=key item=country}
                                    {if $ShowFeaturedDestinations == 1}
                                    <div class="swiper-slide">
                                        <div class="card-imgoffs">
                                            <a href="{$country.link}" title="{$country.title}">
                                                <div class="relative">
                                                    <div class="img_offfersfeat">
                                                        <img fetchpriority="high"
                                                            class="img_featuredoff img100 swiper-lazy"
                                                            src="{$country.image}"
                                                            alt="{$country.title}"
                                                            width="261"
                                                            height="376"
                                                            loading="lazy"
                                                        >
                                                        <div class="swiper-lazy-preloader"></div>
                                                        
                                                    </div>
                                                    {if !empty($country.min_price)}
                                                    <div class="price-tag position-absolute">
                                                        <!-- <p class="badge_1">{$core->get_Lang('From')}</p> -->
                                                        <div class="price_featiso d-flex">
                                                            <p class="price_offs">{$clsISO->formatPrice($country.min_price)}</p>
                                                            <p class="badge_2">{$clsISO->getShortRate()}</p>
                                                        </div>
                                                    </div>
                                                    {/if}
                                                </div>
                                                <div class="card_region_inf">
                                                    <h3 class="region_txt">{$country.title}</h3>
                                                    <!-- <div class="region_txt_inf text_linelimit3">
                                                        {$clsISO->cleanHtmlKeepParagraph($country.intro)}
                                                    </div> -->
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    {/if}
                                    {assign var=lst_child value=$country.lst_child}
                                    {if !empty($lst_child)}
                                    {foreach from=$lst_child key=kc item=city} 
                                        <div class="swiper-slide">
                                            <div class="card-imgoffs">
                                                <a href="{$city.link}" title="{$city.city_title}">
                                                    <div class="relative">
                                                         <div class="img_offfersfeat">
                                                            <img fetchpriority="high"
                                                                class="img_featuredoff img100 swiper-lazy"
                                                                src="{$city.image}"
                                                                alt="{$city.city_title}"
                                                                width="261"
                                                                height="376"
                                                                loading="lazy"
                                                            >
                                                            <div class="swiper-lazy-preloader"></div>
                                                        </div>
                                                        {if !empty($city.min_price)}
                                                        <div class="price-tag position-absolute">
                                                            <!-- <p class="badge_1">{$core->get_Lang('From')}</p> -->
                                                            <div class="price_featiso d-flex">
                                                                <p class="price_offs">{$clsISO->formatPrice($city.min_price)}</p>
                                                                <p class="badge_2">{$clsISO->getShortRate()}</p>
                                                            </div>
                                                        </div>
                                                        {/if}
                                                    </div>
                                                    <div class="card_region_inf">
                                                         <h3 class="region_txt">{$city.city_title}</h3>
                                                        <!--<div class="region_txt_inf text_linelimit3">
                                                            {$clsISO->cleanHtmlKeepParagraph($city.city_intro)}
                                                        </div> -->
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    {/foreach}
                                    {/if}
                                {/foreach}
                            </div>

                            <!-- Navigation -->
                            <div class="swiper-button-prev">
                                <i class="fa-solid fa-angle-left"></i>
                            </div>
                            <div class="swiper-button-next">
                                <i class="fa-solid fa-angle-right"></i>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        {/if}
        {$clsISO->getBlock('Lbox_VideoHome')}
        {$clsISO->getBlock('home/services')}
        {$clsISO->getBlock('home/why_with_us')}
        {$clsISO->getBlock('home/customer_reviews')}
        {$clsISO->getBlock('home/subscribe')}

        {if $lstTopBlog}
            <section class="travel_insp">
                <div class="container">
                    {assign var = TitleTravelInspiration value = TitleTravelInspiration_|cat:$_LANG_ID}
                    {assign var = IntroTravelInspiration value = IntroTravelInspiration_|cat:$_LANG_ID}
                    <h2 class="txt_interser">
                        <a href="{$_LANG_ID}/blog">
                            {$clsConfiguration->getValue($TitleTravelInspiration)}
                        </a>
                    </h2>
                    <div class="row">
                        {section name = t loop =$lstTopBlog}
                            {assign var=getTitle_Blog value=$clsBlog->getTitle($lstTopBlog[t].blog_id,$lstTopBlog[t])}
                            {assign var=getLink_Blog value=$clsBlog->getLink($lstTopBlog[t].blog_id,$lstTopBlog[t])}
                            <div class="col-lg-6 col-md-6 col-sm-12" style="margin-bottom: 32px;">
                                <div class="travel_inspitem deal-card">
                                    <!-- Tạo row cho phần media -->
                                    <div class="row media d-flex align-items-start">
                                        <!-- Chia cột cho ảnh -->
                                        <div class="col-lg-6 col-md-7 col-sm-12 img_mediablog">
                                            <a href="{$getLink_Blog}" title="{$getTitle_Blog}">
                                                <img src="{$clsBlog->getImage($lstTopBlog[t].blog_id,298,169,$lstTopBlog[t])}"
                                                     {if $deviceType != "phone"}class="me-3"{/if} alt="{$getTitle_Blog}"
                                                     width="298" height="169" loading="lazy">
                                            </a>

                                        </div>
                                        <!-- Chia cột cho nội dung -->
                                        <div class="col-lg-6 col-md-5 col-sm-12">
                                            <div class="media-body">
                                                <a href="{$getLink_Blog}" title="{$getTitle_Blog}">
                                                    <h3 class="mt-0 txt_media_travel1 text_linelimit3">{$getTitle_Blog}</h3>
                                                </a>
                                                <p class="txt_media_travel2 text_linelimit4">
                                                    {$clsBlog->getIntro($lstTopBlog[t].blog_id,$lstTopBlog[t])|strip_tags}
                                                </p>
                                                <div class="button_travel_seemore">
                                                    <a href="{$getLink_Blog}" title="{$getTitle_Blog}"
                                                       class="btn_travel_insp">{$core->get_Lang('See more')}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/section}
                    </div>
                </div>
            </section>
        {/if}

        {$clsISO->getBlock('dev_helpcenter_topdest')}
    </div>
</div>
