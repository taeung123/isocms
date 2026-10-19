{if $lstCruiseRecent}
    <section id="cruise_recently_viewed">
        <div class="container">
            <h2 class="title_recently_viewed">{$core->get_Lang("Recently viewed")}</h2>
            <div class="owl-carousel cruise_recently_viewed">
                {foreach from=$lstCruiseRecent item=cruise}
                    {assign var=cruise_id value=$cruise.cruise_id}
                    {assign var=cruise_title value=$cruise.title}
                    {assign var=cruise_link value=$clsCruise->getLink($cruise_id)}
                    {assign var=cruisePrice value=$clsCruise->getLTripPrice1($cruise_id, $now_month, 'price_2024')}

                    <div class="card-contentser deal-card">
                        <div class="img_servicesitem">
                            <a href="{$cruise_link}" title="{$cruise_title}">
                                <img src="{$clsISO->tripslashImage($cruise.image, 298, 276)}" 
                                    class="img_interserv img100" 
                                    alt="{$cruise_title}" 
                                    width="298" height="276">
                            </a>
                        </div>
                        <div class="card-bodyserv">
                            <a href="{$cruise_link}" title="{$cruise_title}">
                                <h3 class="card-titleserv hover_txt_green_dark">{$cruise_title}</h3>
                            </a>

                            <div class="cruise_review">
                                <p class="review_score">{$clsReviews->getReviews($cruise_id, "avg_point", "cruise")}</p>
                                <p class="review_txt">{$clsReviews->getReviews($cruise_id, "txt_review", "cruise")}</p>
                                <p class="vertical_bar">|</p>
                                <p class="quantity_review">{$clsReviews->getReviews($cruise_id, "", "cruise")}</p>
                            </div>

                            <div class="txt_price">
                                {if $cruisePrice}
                                    <div class="numb_price">
                                        {$cruisePrice}
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
        .cruise_recently_viewed {
            margin-bottom: var(--margin-bottom-section);
        }
        #cruise_recently_viewed .card-contentser {
            position: relative;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.5s ease-in-out;
        }
        #cruise_recently_viewed .card-contentser .img_servicesitem {
            overflow: hidden;
            border-radius: 8px;
            transition: transform .3s ease-in-out;
        }
        #cruise_recently_viewed .img_servicesitem img:hover {
            transform: scale(1.2);
        }
        #cruise_recently_viewed .card-contentser a {
            overflow: hidden;
        }
        #cruise_recently_viewed .deal-card a {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 20px;
            font-style: normal;
            font-weight: 500;
            line-height: 30px;
        }
        #cruise_recently_viewed .img_interserv {
            border-radius: 8px;
            background: lightgray 50% / cover no-repeat;
            object-fit: cover;
            transition: all 0.3s ease-in-out;
        }
        #cruise_recently_viewed .border_countryser {
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
        #cruise_recently_viewed .txt_countryser {
            color: var(--chroma-ffffff, #FFF);
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 21px;
        }
        #cruise_recently_viewed .card-bodyserv {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        #cruise_recently_viewed .card-titleserv {
            margin-top: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        #cruise_recently_viewed .deal_rate .review_text {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-style: normal;
            font-size: 14px;
            font-weight: 400;
            line-height: 21px;
            margin-bottom: 0;
            gap: 8px;
        }
        #cruise_recently_viewed .txt_price, .numb_price {
            display: ruby;
        }
        .numb_price .hnv_trvs_main_tour_item_content_price_number {
            margin-right: 4px;
            margin-left: 4px
        }
        #cruise_recently_viewed .txt_price .txt_from, .txt_numb_red {
            margin-bottom: 0;
        }
        #cruise_recently_viewed .txt_numb_red {
            color: var(--secondary-c-81-e-3-a);
            font-size: 20px;
        }
        #cruise_recently_viewed .title_recently_viewed {
            margin-bottom: 24px;
        }
        #cruise_recently_viewed .owl-carousel .owl-item {
            min-width: unset !important;
        }
        #cruise_recently_viewed .cruise_review {
            margin-bottom: 0;
        }
        #cruise_recently_viewed .cruise_review {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .cruise_review p {
            margin-bottom: 0;
        }
        @media only screen and (max-width: 600px) {
            #cruise_recently_viewed .owl-prev,
            #cruise_recently_viewed .owl-next {
                background: #fff;
            }
            #cruise_recently_viewed .owl-prev {
                left: 0;
                top: 75px;
            }
            #cruise_recently_viewed .owl-next {
                right: 0;
                top: 75px;
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if ($('.cruise_recently_viewed').length) {
                $('.cruise_recently_viewed').owlCarousel({
                    margin: 20,
                    nav: false,
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
        })
    </script>
{/literal}
{/if}