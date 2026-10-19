<link rel="stylesheet" href="{$URL_CSS}/homepagenew.css?v={$upd_version}"/>
<link rel="stylesheet" href="{$URL_CSS}/fontawesome/css/all.min.css?v={$upd_version}"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css">
<script defer src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
<script defer src="https://apis.google.com/js/api.js"></script>
<div class="page_container">
    {$core->getBlock('des_header_bground')}
    {* End Header *}

    {* Body *}
    {$core->getBlock('dev_lastdealtour')}
    {$core->getBlock('dev_dealstour')}
    {if $listAdsHome}
        <section class="itinerary_ins">
            <div class="container">
                <h2 class="txt_itinerary">{$core->get_Lang('Inspiration for your itinerary')}</h2>
                <div class="owl-carousel owl-theme owl-itinerary">
                    {section name=a loop=$listAdsHome}
                        <div class="item item_itinerary" data-merge="1">
                            <img class="img_itinerary w-100"
                                 src="{$clsAds->getImage($listAdsHome[a].ads_id,624,335)}"
                                 alt="Image 1" width="624" height="335">
                        </div>
                    {/section}
                </div>
            </div>
        </section>
    {/if}

    {$core->getBlock('dev_coupon_codes')}
    {$core->getBlock('dev_travel_favchoice')}

    <section class="offers_dest py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 txt_offersdest">
                    <h2 class="txt_offers mb-4">{$core->get_Lang("Offers & featured destinations")}</h2>
                    <h5 class="text_offes">
                        {$core->get_Lang('Test Offers destinations')}
                    </h5>
                </div>
                <div class="col-md-8 img_infoffer">
                    <div class="row">
                        <div class="owl-carousel owl-theme owl-offers">
                            {section name = i loop =$listCountryDestination}
                                {assign var = countrytitle value = $listCountryDestination[i].title}
                                {assign var =linkcountry value = $clsCountryEx->getLink($listCountryDestination[i].country_id)}
                                {assign var = minprice value = $clsTour->getMinPriceByCountry($listCountryDestination[i].country_id)}
                                {if $minprice}
                                    <div class="card-imgoffs" data-merge="1">
                                        <a href="{$linkcountry}" title="{$countrytitle}" alt="{$countrytitle}">
                                            <div class="img_offfersfeat">
                                                <img class="img_featuredoff img100"
                                                     src="{$clsCountryEx->getImage($listCountryDestination[i].country_id,261,376)}"
                                                     class="card-img-top" alt="{$countrytitle}" width="261"
                                                     height="376">
                                            </div>
                                            <div class="price-tag position-absolute">
                                                <h6 class="badge_1">{$core->get_Lang('From')}</h6>
                                                <div class="price_featiso d-flex">
                                                    <h6 class="badge_2">{$core->get_Lang('US')}<h3
                                                                class="price_offs">{$minprice}</h3></h6>
                                                </div>
                                            </div>
                                            <div class="card_region_inf">
                                                <h5 class="region_txt">{$countrytitle}</h5>
                                            </div>
                                        </a>
                                        <p class="region_txt_inf">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting
                                            industry.</p>
                                    </div>
                                {/if}
                            {/section}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="inter_services">
        <div class="container">
            <h2 class="txt_interser">{$core->get_Lang("Would you be interested in these services?")}</h2>
            <ul class="nav nav_services" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active " id="accommodation-tab" data-bs-toggle="tab" href="#accommodation"
                       role="tab"
                       aria-controls="accommodation" aria-selected="true">
                        <h6 class="txth6_navservices">{$core->get_Lang('Accommodation')}</h6>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cruise-tab" data-bs-toggle="tab" href="#cruise" role="tab"
                       aria-controls="cruise" aria-selected="false">
                        <h4 class="txth4_navservices">{$core->get_Lang('Cruise')}</h4>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                {if $listHotel}
                    <div class="tab-pane fade show active" id="accommodation" role="tabpanel"
                         aria-labelledby="accommodation-tab">
                        <div class="row mt-4">
                            <div class="owl-carousel owl-theme owl-servicesitem">
                                {section name =k loop=$listHotel}
                                    {assign var=totalHotel value=$listHotel|@count}
                                    {assign var = hotel_id value = $listHotel[k].hotel_id}
                                    {assign var = arrHotel value = $listHotel[k]}
                                    {assign var = link value = $clsHotel->getLink($hotel_id,$arrHotel)}
                                    {assign var = title value = $clsHotel->getTitle($hotel_id,$arrHotel)}
                                    {assign var = getImageStar value = $clsHotel->getHotelStar($hotel_id,$arrHotel)}
                                    {assign var= ratingValue value= $clsReviews->getRateAvg($hotel_id,'hotel','5')}
                                    {assign var= bestRating value= $clsReviews->getBestRate($hotel_id,'hotel')}
                                    {assign var= ratingCount value= $clsReviews->getToTalReview($hotel_id,'hotel')}
                                    {assign var=getStarNew value=$clsReviews->getStarNew($hotel_id,'hotel')}
                                    <div class="card-contentser deal-card" data-merge="1">
                                        <div class="img_servicesitem">
                                            <a href="{$link}" title="{$title}" alt="{$title}">
                                                <img src="{$clsHotel->getImage($hotel_id,298,276,$arrHotel)}"
                                                     class="img_interserv img100" alt="{$listHotel[k].title}"
                                                     width="298"
                                                     height="276">
                                        </div>
                                        {if $clsHotel->getLocationNew($hotel_id) != ''}
                                            <div class="border_countryser position-absolute">
                                                <p class="txt_countryser">{$clsHotel->getLocationNew($hotel_id)}</p>
                                            </div>
                                        {/if}

                                        <div class="card-bodyserv">
                                            <h5 class="card-titleserv">{$listHotel[k].title}</h5>
                                            </a>
                                            <div class="deal_rate box_col">
                                                <label class="rate-2019"
                                                       style="align-self: center">{$getStarNew}</label>
                                                <h6 class="review_text">{$ratingValue|number_format:1} ({$ratingCount}
                                                    )</h6>
                                            </div>
                                            <div class="txt_price">
                                                <h6 class="txt_from">{$core->get_Lang('from')}</h6>
                                                <div class="numb_price">
                                                    {*                                            <h6 class="txt_price_red">US</h6>*}
                                                    {$clsHotel->getPriceOnPromotionNew($hotel_id)}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/section}
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="{$clsISO->getLink('hotel')}" class="btn btn_viewmore"
                               style="margin-top: 32px;">{$core->get_Lang('View more')}</a>

                        </div>
                    </div>
                {/if}

                {if $listCruise}
                    <div class="tab-pane fade" id="cruise" role="tabpanel" aria-labelledby="cruise-tab">
                        <div class="row mt-4">
                            <div class="owl-carousel owl-theme owl-servicesitem">
                                {section name =lc loop=$listCruise}
                                    {assign var = cruise_id value = $listCruise[lc].cruise_id}
                                    {assign var = linkCruise value = $clsCruise->getLink($cruise_id)}
                                    {assign var = titleCruise value = $listCruise[lc].title}
                                    {assign var = imgCruise value = $clsCruise->getImage($cruise_id, 298,276)}
                                    {assign var= ratingValue value= $clsReviews->getRateAvg($cruise_id,'cruise','5')}
                                    {assign var= bestRating value= $clsReviews->getBestRate($cruise_id,'cruise')}
                                    {assign var= ratingCount value= $clsReviews->getToTalReview($cruise_id,'cruise')}
                                    {assign var=getStarNew value=$clsReviews->getStarNew($cruise_id,'cruise')}
                                    <div class="card-contentser deal-card" data-merge="1">
                                        <div class="img_servicesitem">
                                            <a href="{$linkCruise}" title="{$titleCruise}" alt="{$titleCruise}">
                                                <img src="{$imgCruise}"
                                                     class="img_interserv img100" alt="{$titleCruise}" width="298"
                                                     height="276">
                                        </div>
                                        <div class="border_countryser position-absolute">
                                            <p class="txt_countryser">{$clsCruise->getCatName($cruise_id)}</p>
                                        </div>
                                        <div class="card-bodyserv">
                                            <h5 class="card-titleserv">{$titleCruise}</h5>
                                            </a>
                                            <div class="deal_rate box_col">
                                                <label class="rate-2019"
                                                       style="align-self: center">{$getStarNew}</label>
                                                <h6 class="review_text">{$ratingValue|number_format:1} ({$ratingCount}
                                                    )</h6>
                                            </div>
                                            <div class="txt_price">
                                                <h6 class="txt_from">{$core->get_Lang('from')}</h6>
                                                <div class="numb_price">
                                                    {*                                            <h6 class="txt_price_red">US</h6>*}
                                                    <h3 class="txt_numb_red"> {$clsCruise->getLTripPriceNew($cruise_id,$now_month)}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/section}
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="{$clsISO->getLink('cruise')}" class="btn btn_viewmore"
                               style="margin-top: 32px;">{$core->get_Lang('View more')}</a>
                        </div>
                    </div>
                {/if}
            </div>
        </div>
    </section>
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
                                             width="298" height="169">
                                    </a>

                                </div>
                                <!-- Chia cột cho nội dung -->
                                <div class="col-md-6 media-body">
                                    <a href="{$getLink_Blog}" title="{$getTitle_Blog}">
                                        <h5 class="mt-0 txt_media_travel1 text_linelimit3">{$getTitle_Blog}</h5>
                                    </a>
                                    <h6 class="txt_media_travel2 text_linelimit4">
                                        {$clsBlog->getIntro($lstTopBlog[t].blog_id,$lstTopBlog[t])|strip_tags}
                                    </h6>
                                    <div class="button_travel_seemore">
                                        <a href="{$getLink_Blog}" title="{$getTitle_Blog}"
                                           class="btn_travel_insp">{$core->get_Lang('See more')}
                                        </a>
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
{$core->getBlock('Press_partner')}
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
                smartSpeed: 800,
                navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
                merge: true,
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

            $('.owl-servicesitem').owlCarousel({
                margin: 30,
                nav: true,
                loop: true,
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

            $('.owl-whychoose').owlCarousel({
                margin: 30,
                nav: true,
                loop: true,
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

            $('.owl-custreview').owlCarousel({
                margin: 30,
                nav: true,
                loop: true,
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

            $('.owl-exploremore').owlCarousel({
                margin: 30,
                nav: true,
                loop: true,
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
