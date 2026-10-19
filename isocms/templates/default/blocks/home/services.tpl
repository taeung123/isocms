{if !empty($listHotel) || !empty($lstVoucher) || !empty($listCruise)}
<section class="inter_services">
    <div class="container">
        <div class="viewmore_btnn">
                    <h2 class="txt_interser">{$core->get_Lang("Would you be interested in these services?")}</h2>
            {if $_LANG_ID eq 'vn'}
            <a href="{$clsISO->getLink('hotel')}"
                class="btn btn_viewmore">{$core->get_Lang('View all hotels')}
            </a>
                {else}
                <a href="{$_LANG_ID}{$clsISO->getLink('hotel')}"
                    class="btn btn_viewmore">{$core->get_Lang('View all hotels')}
                </a>
            {/if}
        </div>

        <ul class="nav nav_services" id="myTab" role="tablist">
            {if !empty($listHotel)}
                <li class="nav-item">
                    <a class="nav-link iso_btn_inter_services" id="accommodation-tab" data-bs-toggle="tab"
                       href="#accommodation"
                       role="tab"
                       aria-controls="accommodation" aria-selected="true">
                        <h4 class="txth4_navservices">{$core->get_Lang('Accommodation')}</h4>
                    </a>
                </li>
            {/if}
            {if !empty($listCruise)}
                <li class="nav-item">
                    <a class="nav-link iso_btn_inter_services" id="cruise-tab" data-bs-toggle="tab" href="#cruise"
                       role="tab"
                       aria-controls="cruise" aria-selected="false">
                        <h4 class="txth4_navservices">{$core->get_Lang('Cruises')}</h4>
                    </a>
                </li>
            {/if}
            {if !empty($lstVoucher)}
                <li class="nav-item">
                    <a class="nav-link iso_btn_inter_services" id="voucher-tab" data-bs-toggle="tab" href="#voucher"
                       role="tab"
                       aria-controls="voucher" aria-selected="false">
                        <h4 class="txth4_navservices">{$core->get_Lang('Vouchers')}</h4>
                    </a>
                </li>
            {/if}
        </ul>

        <div class="tab-content">
            {if !empty($listHotel)}
                <div class="tab-pane fade" id="accommodation" role="tabpanel"
                     aria-labelledby="accommodation-tab">
                    <div class="mt-4">
                        <div class="swiper swiper-servicesitem swiper-hotel">
                            <div class="swiper-wrapper">
                                {section name=k loop=$listHotel}
                                    {assign var=hotel_id value=$listHotel[k].hotel_id}
                                    {assign var=arrHotel value=$listHotel[k]}
                                    {assign var=link value=$clsHotel->getLink($hotel_id,$arrHotel)}
                                    {assign var=title value=$clsHotel->getTitle($hotel_id,$arrHotel)}
                                    {assign var=ratingValue value=$clsReviews->getRateAvg($hotel_id,'hotel','10')}
                                    {assign var=ratingCount value=$clsReviews->getToTalReview($hotel_id,'hotel')}
                                    {assign var=textRateAvg value=$clsReviews->getTextRateAvg($hotel_id,'hotel')}
                                    {assign var=price_hotel value=$clsHotel->getPriceOnPromotionNew($hotel_id)}

                                    <div class="swiper-slide">
                                        <div class="card-contentser deal-card">
                                            <a class="img_servicesitem" href="{$link}" title="{$title}">
                                                <img
                                                    class="img_interserv img100 swiper-lazy"
                                                    src="{$clsHotel->getImage($hotel_id,298,276,$arrHotel)}"
                                                    alt="{$title}"
                                                    width="298"
                                                    height="276"
                                                    loading="lazy"
                                                >
                                            </a>

                                            {if $clsHotel->getLocationNew($hotel_id) != ''}
                                                <div class="border_countryser position-absolute">
                                                    <p class="txt_countryser">
                                                        {$clsHotel->getLocationNew($hotel_id)}
                                                    </p>
                                                </div>
                                            {/if}

                                            <div class="card-bodyserv">
                                                <a href="{$link}" title="{$title}">
                                                    <h4 class="card-titleserv">
                                                        {$listHotel[k].title}
                                                    </h4>
                                                </a>

                                                <div class="deal_rate box_col">
                                                    <h6 class="review_text d-flex">
                                                        <p class="border_rate">
                                                            {$ratingValue|number_format:1}
                                                        </p>
                                                        {$textRateAvg}
                                                        {if $ratingCount > 0}
                                                            | {$ratingCount} {$core->get_Lang('reviews')}
                                                        {/if}
                                                    </h6>
                                                </div>

                                                <div class="txt_price">
                                                    {if $price_hotel}
                                                        <h6 class="txt_from">{$core->get_Lang('from')}</h6>
                                                        <div class="numb_price">
                                                            {$price_hotel}
                                                        </div>
                                                    {else}
                                                        <div class="numb_price size20 text_bold">
                                                            <p class="txt_numb_red">
                                                                {$core->get_Lang('Contact')}
                                                            </p>
                                                        </div>
                                                    {/if}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/section}
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
            {/if}

            {if !empty($listCruise)}
                <div class="tab-pane fade" id="cruise" role="tabpanel" aria-labelledby="cruise-tab">
                    <div class="mt-4">
                        <div class="swiper swiper-servicesitem swiper-cruise">
                            <div class="swiper-wrapper">
                                {section name=lc loop=$listCruise}
                                    {assign var=cruise_id value=$listCruise[lc].cruise_id}
                                    {assign var=linkCruise value=$clsCruise->getLink($cruise_id)}
                                    {assign var=titleCruise value=$listCruise[lc].title}
                                    {assign var=imgCruise value=$clsCruise->getImage($cruise_id,298,276)}
                                    {assign var=ratingValue value=$clsReviews->getRateAvg($cruise_id,'cruise','10')}
                                    {assign var=ratingCount value=$clsReviews->getToTalReview($cruise_id,'cruise')}
                                    {assign var=textRateAvg value=$clsReviews->getTextRateAvg($cruise_id,'cruise')}
                                    {assign var=price_cruise value=$clsCruise->getLTripPriceNew($cruise_id,$now_month)}

                                    <div class="swiper-slide">
                                        <div class="card-contentser deal-card">
                                            <a class="img_servicesitem" href="{$linkCruise}" title="{$titleCruise}">
                                                <img
                                                    class="img_interserv img100 swiper-lazy"
                                                    src="{$imgCruise}"
                                                    alt="{$titleCruise}"
                                                    width="298"
                                                    height="276"
                                                    loading="lazy"
                                                >
                                            </a>

                                            <div class="border_countryser position-absolute">
                                                <p class="txt_countryser">
                                                    {$clsCruise->getCatName($cruise_id)}
                                                </p>
                                            </div>

                                            <div class="card-bodyserv">
                                                <a href="{$linkCruise}" title="{$titleCruise}">
                                                    <h4 class="card-titleserv">{$titleCruise}</h4>
                                                </a>

                                                <div class="deal_rate box_col">
                                                    <h6 class="review_text d-flex">
                                                        <p class="border_rate">
                                                            {$ratingValue|number_format:1}
                                                        </p>
                                                        {$textRateAvg}
                                                        {if $ratingCount > 0}
                                                            | {$ratingCount} {$core->get_Lang('reviews')}
                                                        {/if}
                                                    </h6>
                                                </div>

                                                <div class="txt_price">
                                                    {if $price_cruise}
                                                        <h6 class="txt_from">{$core->get_Lang('from')}</h6>
                                                        <div class="numb_price">
                                                            <p class="txt_numb_red">{$price_cruise}</p>
                                                        </div>
                                                    {else}
                                                        <div class="numb_price size20 text_bold">
                                                            <p class="txt_numb_red">
                                                                {$core->get_Lang('Contact')}
                                                            </p>
                                                        </div>
                                                    {/if}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/section}
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
                    <div class="text-center">
                        <a href="{$clsISO->getLink('cruise')}"
                           class="btn btn_viewmore">{$core->get_Lang('View more')}</a>
                    </div>
                </div>
            {/if}

            {if $lstVoucher}
                <div class="tab-pane fade" id="voucher" role="tabpanel" aria-labelledby="voucher-tab">
                    <div class="row mt-4">
                        <div class="swiper swiper-servicesitem">
                            <div class="swiper-wrapper">
                                {section name=lv loop=$lstVoucher}
                                    {assign var=voucher_id value=$lstVoucher[lv].voucher_id}
                                    {assign var=linkVoucher value=$clsVoucher->getLink($voucher_id)}
                                    {assign var=titleVoucher value=$lstVoucher[lv].title}
                                    {assign var=imgVoucher value=$clsVoucher->getImage($voucher_id,298,276)}
                                    {assign var=ratingValue value=$clsReviews->getRateAvg($voucher_id,'voucher','10')}
                                    {assign var=ratingCount value=$clsReviews->getToTalReview($voucher_id,'voucher')}
                                    {assign var=getStarNew value=$clsReviews->getStarNew($voucher_id,'voucher')}

                                    <div class="swiper-slide">
                                        <div class="card-contentser deal-card">
                                            <a class="img_servicesitem" href="{$linkVoucher}" title="{$titleVoucher}">
                                                <img
                                                    class="img_interserv img100 swiper-lazy"
                                                    src="{$imgVoucher}"
                                                    alt="{$titleVoucher}"
                                                    width="298"
                                                    height="276"
                                                    loading="lazy"
                                                >
                                            </a>

                                            {if $clsVoucherCat->getTitle($lstVoucher[lv].cat_id) != ''}
                                                <div class="border_countryser position-absolute">
                                                    <p class="txt_countryser">
                                                        {$clsVoucherCat->getTitle($lstVoucher[lv].cat_id)}
                                                    </p>
                                                </div>
                                            {/if}

                                            <div class="card-bodyserv">
                                                <a href="{$linkVoucher}" title="{$titleVoucher}">
                                                    <h4 class="card-titleserv">{$titleVoucher}</h4>
                                                </a>

                                                <div class="deal_rate box_col">
                                                    <label class="rate-2019">{$getStarNew}</label>
                                                    <h6 class="review_text d-flex">
                                                        {$ratingValue|number_format:1}
                                                        {if $ratingCount > 0}
                                                            ({$ratingCount} {$core->get_Lang('reviews')})
                                                        {/if}
                                                    </h6>
                                                </div>

                                                <div class="txt_price">
                                                    <h6 class="txt_from">{$core->get_Lang('from')}</h6>
                                                    <div class="numb_price">
                                                        <p class="txt_numb_red">
                                                            {$clsVoucher->getOldPrice($voucher_id)}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/section}
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
                    <div class="text-center">
                        <a href="{$clsISO->getLink('voucher')}"
                           class="btn btn_viewmore">{$core->get_Lang('View more')}</a>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</section>

{literal}
    <script>
       document.addEventListener("DOMContentLoaded", function () {
            new Swiper(".swiper-servicesitem", {
                loop: true,
                speed: 800,
                spaceBetween: 30,

                lazy: {
                    loadPrevNext: true,
                },

                navigation: {
                    nextEl: ".swiper-servicesitem .swiper-button-next",
                    prevEl: ".swiper-servicesitem .swiper-button-prev",
                },

                breakpoints: {
                    0: {
                        slidesPerView: 1.2,
                        navigation: false,
                    },
                    600: {
                        slidesPerView: 2,
                        navigation: true,
                    },
                    1000: {
                        slidesPerView: 4,
                    },
                },
            });
            let iso_btn_inter_services_first = $(".iso_btn_inter_services").first();
            iso_btn_inter_services_first.addClass("active");
            let id_lst_active = iso_btn_inter_services_first.attr("href");
            $(id_lst_active).addClass("show active");
       })
    </script>
    <style>
        /* CSS would you services */

        .inter_services .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .inter_services .nav-tabs .nav-link.active {
            background-color: #17a2b8;
            color: var(--chroma-ffffff, #FFF);
        }

        .nav_services {
            gap: 8px;
        }

        .nav_services .nav-link {
            transition: all 0.3s ease-in-out !important;
            color: var(--primary-18-babd, #18BABD);
            border-radius: var(--border-radius-rouded);
            background: var(--secondary-e-8-f-8-f-8, #E8F8F8);

        }

        .nav_services .active {
            display: inline-flex;
            padding: 8px 16px;
            justify-content: center;
            align-items: center;
            gap: 8px;
            border-radius: var(--border-radius-rouded);
            background: var(--primary-18-babd, #18BABD);
            color: var(--chroma-ffffff, #FFF);
        }
        .nav_services .active h4 {
            color: inherit;
        }
        .nav_services .nav-link:hover {
            background: var(--primary-18-babd, #18BABD);
            color: var(--chroma-ffffff, #FFF) !important;
            border-radius: var(--border-radius-rouded);
        }

        .card-contentser {
            position: relative;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.5s ease-in-out;
        }

        .card-contentser a img:hover {
            -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.2);
        }

        .img_interserv {
            background: lightgray 50% / cover no-repeat;
            object-fit: cover;
            height: revert-layer;
            transition: all 0.3s ease-in-out !important;
        }

        .border_countryser {
            display: inline-flex;
            height: 34px;
            padding: 6px 12px;
            gap: 10px;
            flex-shrink: 0;
            border-radius: 8px 0px 0px 0px;
            background: var(--secondary-177-fa-4, #177FA4);
            z-index: 1;
            top: 0;
            left: 0;
        }

        .txt_countryser {
            color: var(--chroma-ffffff, #FFF);;
            font-size: var(--font-size-small);           
            font-weight: var(--font-weight-normal)
        }

        .card-titleserv {
            margin-top: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-titleserv:hover {
            color: var(--secondary-color);
        }

        .card-bodyserv {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .card-bodyserv .txt_from {
            color: var(--chroma-717171, #717171);;
            font-size: var(--font-size-small);
        }

        .swiper-servicesitem .swiper-button-prev, .swiper-servicesitem .swiper-button-next {
            top: 45%;
            display: none;
        }

        .swiper-servicesitem .swiper-button-prev {
            left: 10px;
        }

        .swiper-servicesitem .swiper-button-next {
            right: 10px;
        }

        .swiper-servicesitem .card-contentser .img_servicesitem {
            overflow: hidden;
            border-radius: var(--border-radius-card);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .deal_rate .border_rate {
            display: flex;
            padding: 1px 8px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 2px;
            background: var(--primary-18-babd);
            color: var(--chroma-ffffff);
            font-size: var(--font-size-small);
            font-weight: var(--font-weight-normal);
            margin: 0;
        }


        .deal_rate .review_text {
            color: var(--primary-1-d-2-d-53, #1D2D53);       
            font-size: var(--font-size-small);
            margin-bottom: 0;
            gap: 8px;
        }

        .inter_services .txt_price, .inter_services .numb_price {
            display: ruby;
        }

        .inter_services .txt_price .txt_from, .inter_services .txt_price_red, .txt_numb_red {
            margin-bottom: 0;
        }

        .txt_price_red {
            color: var(--secondary-c-81-e-3-a, #C81E3A);
            font-size: var(--font-size-small);
        }

        .txt_numb_red, .txt_price .txt_numb_red_new, .unit_price {
            color: var(--secondary-c-81-e-3-a, #C81E3A);
            font-size: var(--font-size-h3);
            font-weight: var(--font-weight-bold);
        }

        .swiper-servicesitem .card-contentser .img_servicesitem .img_interserv:hover {
            scale: 1.2;
            border-radius: var(--border-radius-card);
        }

        .swiper-servicesitem .swiper-button-prev:hover, .swiper-servicesitem .swiper-button-next:hover {
            background: var(--chroma-c-8-cbd-0, #C8CBD0) !important;
            cursor: pointer;
        }

        .swiper-servicesitem:hover .swiper-button-prev,
        .swiper-servicesitem:hover .swiper-button-next {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px; 
            height: 40px;
            border-radius: 50%;
        }

        .card-bodyserv .old_price {
            color: var(--chroma-717171, #717171);
            font-size: var(--font-size-small);
            
            font-weight: 400;
            line-height: 21px;
            margin-right: 5px;
        }

        .swiper-button-prev, .swiper-button-next {
            background: var(--chroma-ffffff, #FFF) !important;
            filter: drop-shadow(0px 1px 3px rgba(0, 0, 0, 0.10));
            border: none !important;
        }
        #voucher .mt-4{
            margin-left: 0 !important;
        }
        .swiper-button-prev i, .swiper-button-next i {
            color: var(--secondary-26456-e, #26456E);
        }
    </style>
{/literal}
{/if}