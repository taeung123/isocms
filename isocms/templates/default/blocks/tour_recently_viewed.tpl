{if !empty($lstTourRecent)}
    <section id="tour_recently_viewed">
        <div class="container my-5">
        <h3 class="title_recently_viewed">{$core->get_Lang("Recently viewed")}</h3>
        <div class="owl-carousel tour_recently_viewed">
                {foreach from=$lstTourRecent key=key item=tour}
                    {assign var=tour_id value=$tour.tour_id}
                    {assign var=tour_title value=$tour.title}
                    {assign var=tour_link value=$clsTour->getLink($tour_id)}
                    {assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent,"new2024")}
                    {assign var=getToTalReview value=$clsReviews->getToTalReview($tour_id,'tour')}
                    {assign var=getRateAvg value=$clsReviews->fetchAvgRating($tour_id,'tour')}
                    {assign var=getStarNew value=$clsReviews->getStarNew($tour_id,'tour')}
                    {assign var=address value=$clsTour->getLCityAround2024($tour_id)}

                    <div class="card-contentser deal-card">
                        <div class="img_servicesitem">
                            <a href="{$tour_link}" title="{$tour_title}">
                                <img src="{$clsISO->tripslashImage($tour.image, 298, 276)}"
                                    class="img_interserv img100"
                                    alt="{$tour_title}"
                                    width="298"
                                    height="276">
                            </a>
                        </div>

                        {if $address}
                            <div class="border_countryser position-absolute">
                                <p class="txt_countryser" title="{$address}">{$address}</p>
                            </div>
                        {/if}

                        <div class="card-bodyserv">
                            <a href="{$tour_link}" title="{$tour_title}">
                                <h3 class="card-titleserv hover_txt_green_dark">{$tour_title}</h3>
                            </a>

                            <div class="deal_rate box_col">
                                <label class="rate-2019" style="align-self: center">{$getStarNew}</label>
                                <h6 class="review_text d-flex">
                                    {$getRateAvg} ({$getToTalReview})
                                </h6>
                            </div>

                            <div class="txt_price">
                                {if $getPriceTourPromotion}
                                    <h6 class="txt_from">{$core->get_Lang('from')}</h6>
                                    <div class="numb_price">
                                        {$getPriceTourPromotion}
                                    </div>
                                {else}
                                    <div class="hnv_trvs_main_tour_item_content_price_number">
                                        <span>{$core->get_Lang("Contact")}</span>
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                {/foreach}

            </div>
        </div>
    </section>
{literal}
    <style>
        #tour_recently_viewed .card-contentser {
            position: relative;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.5s ease-in-out;
        }
        #tour_recently_viewed .card-contentser .img_servicesitem {
            overflow: hidden;
            border-radius: 8px;
            transition: transform .3s ease-in-out;
        }
        #tour_recently_viewed .img_servicesitem img:hover {
            transform: scale(1.2);
        }
        #tour_recently_viewed .card-contentser a {
            overflow: hidden;
        }
        #tour_recently_viewed .deal-card a {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 20px;
            font-style: normal;
            font-weight: 500;
            line-height: 30px;
        }
        #tour_recently_viewed .img_interserv {
            border-radius: 8px;
            background: lightgray 50% / cover no-repeat;
            object-fit: cover;
            height: 200px;
            transition: all 0.3s ease-in-out;
        }
        #tour_recently_viewed .border_countryser {
            display: inline-flex;
            padding: 6px 12px;
            gap: 10px;
            flex-shrink: 0;
            border-radius: 8px 0px 0px 0px;
            background: var(--secondary-177-fa-4, #177FA4);
            z-index: 1;
            top: 0;
            left: 0;
        }
        #tour_recently_viewed .txt_countryser {
            color: var(--chroma-ffffff, #FFF);
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 21px;
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #tour_recently_viewed .card-bodyserv {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        #tour_recently_viewed .card-titleserv {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 18px;
            font-style: normal;
            font-weight: 700;
            line-height: 24px;
            margin-top: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        #tour_recently_viewed .deal_rate .review_text {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-style: normal;
            font-size: 14px;
            font-weight: 400;
            line-height: 21px;
            margin-bottom: 0;
            gap: 8px;
        }
        #tour_recently_viewed .txt_price, #tour_recently_viewed .numb_price {
            display: ruby;
        }
        #tour_recently_viewed .txt_price .txt_from, .txt_numb_red {
            margin-bottom: 0;
        }
        #tour_recently_viewed .txt_numb_red {
            color: var(--secondary-c-81-e-3-a, #C81E3A);
            font-size: 20px;
            font-style: normal;
            font-weight: 700;
            line-height: 30px;
            margin-bottom: 0;
        }
        #tour_recently_viewed .title_recently_viewed {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 28px;
            font-style: normal;
            font-weight: 700;
            line-height: 40px; /* 142.857% */
            padding: 0;
            margin: 10px 0 20px 0
        }

        #tour_recently_viewed .owl-item {
            height: auto;
        }
        
        @media only screen and (max-width: 768px) {
            #tour_recently_viewed .owl-prev {
                left: 0;
            }
            #tour_recently_viewed .owl-next {
                right: 0;
            }
            #tour_recently_viewed .owl-prev, #tour_recently_viewed .owl-next {
                background: white !important;
                top: 32% !important;
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if ($('.tour_recently_viewed').length) {
                $('.tour_recently_viewed').owlCarousel({
                    margin: 20,
                    nav: true,
                    loop: false,
                    navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
                    merge: true,
                    dots: false,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 2
                        },
                        1000: {
                            items: 4
                        }
                    }
                });
            }
        });
    </script>
{/literal}
{/if}