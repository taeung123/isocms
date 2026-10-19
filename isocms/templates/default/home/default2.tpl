<link rel="stylesheet" href="{$URL_CSS}/homepagenew.css?v={$upd_version}"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css">
<script defer src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
<div class="page_container">
    {$core->getBlock('des_header_bground')}
    {* End Header *}

    {* Body *}
    <div class="body_homecontainer">
        {$core->getBlock('dev_lastdealtour')}
        {$core->getBlock('dev_dealstour')}
        {if $listAdsHome}
            <section class="itinerary_ins">
                <div class="container">
                    <h2 class="txt_itinerary">{$core->get_Lang('Inspiration for your itinerary')}</h2>
                    <div class="owl-carousel owl-theme owl-itinerary">
                        {section name=a loop=$listAdsHome}
                            {if $deviceType ne 'phone'}
                                <div class="item item_itinerary" data-merge="1">
                                    <a href="{$clsAds->getLink($listAdsHome[a].ads_id)}">
                                        <picture>
                                            <source srcset="{$clsAds->getImage($listAdsHome[a].ads_id,624,335, 'webp')}"
                                                    type="image/webp">
                                            <img data-src="{$clsAds->getImage($listAdsHome[a].ads_id,624,335)}"
                                                 alt="{$clsAds->getTitle($listAdsHome[a].ads_id)}" width="624"
                                                 height="335" class="owl-lazy img_itinerary w-100" loading="lazy">
                                        </picture>
                                        {*                                    <img class="owl-lazy img_itinerary w-100"*}
                                        {*                                         data-src="{$clsAds->getImage($listAdsHome[a].ads_id,624,335)}"*}
                                        {*                                         alt="{$clsAds->getTitle($listAdsHome[a].ads_id)}" width="624" height="335" loading="lazy">*}
                                    </a>
                                </div>
                            {else}
                                <div class="item item_itinerary" data-merge="1">
                                    <a href="{$clsAds->getLink($listAdsHome[a].ads_id)}">
                                        <picture>
                                            <source srcset="{$clsAds->getImage($listAdsHome[a].ads_id,450,300, 'webp')}"
                                                    type="image/webp">
                                            <img data-src="{$clsAds->getImage($listAdsHome[a].ads_id,450,300)}"
                                                 alt="{$clsAds->getTitle($listAdsHome[a].ads_id)}" width="450"
                                                 height="300" class="owl-lazy img_itinerary w-100" loading="lazy">
                                        </picture>
                                        {*                                        <img class="owl-lazy img_itinerary w-100"*}
                                        {*                                             data-src="{$clsAds->getImage($listAdsHome[a].ads_id,450,300)}"*}
                                        {*                                             alt="{$clsAds->getTitle($listAdsHome[a].ads_id)}" width="450" height="300"*}
                                        {*                                             loading="lazy">*}
                                    </a>
                                </div>
                            {/if}
                        {/section}
                    </div>
                </div>
            </section>
        {/if}

{*        {$core->getBlock('dev_coupon_codes')}*}
        {$core->getBlock('dev_travel_favchoice')}

        <section class="offers_dest py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 txt_offersdest">
                        <h2 class="txt_offers">{$core->get_Lang("Offers & featured destinations")}</h2>
                        <p class="text_offes">
                            {$core->get_Lang('Delight in exceptional travel experiences at world-renowned destinations, thoughtfully curated to cater to your every desire.')}
                        </p>
                    </div>
                    <div class="col-md-8 img_infoffer">
                        <div class="row">
                            <div class="owl-carousel owl-theme owl-offers">
                                {section name = i loop =$listCountryDestination}
                                    {assign var = countrytitle value = $listCountryDestination[i].title}
                                    {assign var =linkcountry value = $clsCountryEx->getLink($listCountryDestination[i].country_id)}
                                    {assign var = minprice value = $clsTour->getMinPriceByCountry($listCountryDestination[i].country_id)}
                                    {assign var = countryIntro value = $listCountryDestination[i].intro|html_entity_decode}
                                    {if $minprice}
                                        <div class="card-imgoffs" data-merge="1">
                                            <a href="{$linkcountry}" title="{$countrytitle}" alt="{$countrytitle}">
                                                <div class="img_offfersfeat">
                                                    <img class="owl-lazy img_featuredoff img100"
                                                         data-src="{$clsCountryEx->getImage($listCountryDestination[i].country_id,261,376)}"
                                                         class="card-img-top" alt="{$countrytitle}" width="261"
                                                         height="376" loading="lazy">
                                                </div>
                                                <div class="price-tag position-absolute">
                                                    <p class="badge_1">{$core->get_Lang('From')}</p>
                                                    <div class="price_featiso d-flex">
                                                        <p class="price_offs">{$minprice}</p>
                                                        <p class="badge_2">{$clsISO->getShortRate()}</p>
                                                    </div>
                                                </div>
                                                <div class="card_region_inf">
                                                    <h3 class="region_txt">{$countrytitle}</h3>
                                                    <div class="region_txt_inf text_linelimit3">{$countryIntro}</div>

                                                </div>
                                            </a>
                                        </div>
                                    {/if}
                                {/section}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {$core->getBlock('dev_inter_services')}
        {$core->getBlock('dev_whychoose')}
        {$core->getBlock('dev_reviews_customer')}
        {$core->getBlock('dev_subscribehomenew')}
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
                            <div class="col-md-6 col-sm-12" style="margin-bottom: 32px;">
                                <div class="travel_inspitem deal-card">
                                    <!-- Tạo row cho phần media -->
                                    <div class="row media d-flex align-items-start">
                                        <!-- Chia cột cho ảnh -->
                                        <div class="col-md-6 img_mediablog">
                                            <a href="{$getLink_Blog}" title="{$getTitle_Blog}">
                                                <img src="{$clsBlog->getImage($lstTopBlog[t].blog_id,298,169,$lstTopBlog[t])}"
                                                     {if $deviceType != "phone"}class="me-3"{/if} alt="{$getTitle_Blog}"
                                                     width="298" height="169" loading="lazy">
                                            </a>

                                        </div>
                                        <!-- Chia cột cho nội dung -->
                                        <div class="col-md-6">
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
        {$core->getBlock('dev_moretoexplore')}
        {$core->getBlock('dev_helpcenter_topdest')}
    </div>
</div>
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('.owl-dealcard').owlCarousel({
                loop: false,
                margin: 29,
                nav: true,
                smartSpeed: 800,
                navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
                merge: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1.2,
                        nav: false
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 3
                    }
                }
            });

            $('.owl-itinerary').owlCarousel({
                rewind: true,
                margin: 31,
                loop: true,
                lazyLoad:true,
                smartSpeed: 800,
                navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
                nav: false,
                autoplay: true,
                autoplayTimeout: 2000,
                merge: true,
                responsiveClass: true,
                autoHeight: true,
                responsive: {
                    0: {
                        items: 1.2,
                        nav: false
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 2
                    }
                }
            });

            $('.owl_couponcode').owlCarousel({
                loop: true,
                margin: 29,
                nav: true,
                smartSpeed: 800,
                navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
                merge: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1.2,
                        nav: false
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });


            $('.owl-offers').owlCarousel({
                margin: 29,
                nav: true,
                loop: true,
                lazyLoad:true,
                smartSpeed: 800,
                navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
                merge: true,
                responsive: {
                    0: {
                        items: 1.2,
                        nav: false
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });
            
            // Copy mã coupon
            function copyCode(code, btn) {
                navigator.clipboard.writeText(code).then(() => {
                    const copiedText = btn.nextElementSibling; // Tìm phần tử span "Copied" ngay sau button
                    copiedText.style.display = 'inline'; // Hiển thị chữ "Copied"
                    setTimeout(() => {
                        copiedText.style.display = 'none'; // Ẩn sau 2 giây
                    }, 2000);
                }).catch(err => {
                    console.error('Error copying text: ', err);
                });
            }

            Fancybox.bind('[data-fancybox]', {
                Toolbar: {
                    display: ['zoom', 'close'],
                },
                width: '80%',
                height: 'auto',
                maxWidth: 800,
                maxHeight: 600,
                mobile: {
                    width: '90%',
                    height: 'auto'
                }
            });
        })
    </script>
    <style>
        .home2024_home_new_body .fancybox__content {
            max-width: 1000px;
            width: 100%;
        }

    </style>
{/literal}

{*Header*}