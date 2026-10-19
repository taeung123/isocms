{if !empty($arr_country_testimonial)}
    <section class="hnv_des_review">
        <div class="container">
            <div class="hnv_des_review_title">
                <h2>{$core->get_Lang('Reviews from Customers')}</h2>
                <div class="hnv_des_review_description">
                    {$core->get_Lang('Please take a look at the following reviews from our customers')}
                </div>
            </div>
            
            <div class="row">
                <div class="owl-carousel owl-theme owl_hnv_des_review_list">
                    {foreach from=$arr_country_testimonial key=key item=item}
                        {assign var=testimonial_id value=$item.testimonial_id}
                        {assign var=testimonial_title value=$clsTestimonial->getTitle($testimonial_id)}
                        <div class="owl_hnv_item owl_hnv_des_review_list_item" data-merge="1">
                            <a data-fancybox="" href="javascript:void(0);" title="{$core->get_Lang('View more')}"
                               data-src="#owl_hnv_des_review_item_detail_{$key}"
                               class="owl_hnv_des_review_item_detail_more">
                                <div class="owl_hnv_des_review_item_image">
                                    <img class="owl-lazy scale_img_hover"
                                         data-src="{$clsTestimonial->getImage($testimonial_id,407,217)}"
                                         width="407" height="217" alt="{$testimonial_title}">
                                </div>
                            </a>
                            <div class="owl_hnv_des_review_item_intro">
                                <div class="owl_hnv_des_review_item_intro_customer">
                                    <h3>{$clsTestimonial->getName($testimonial_id)}</h3>
                                </div>
                                <div class="owl_hnv_des_review_item_intro_time">
                                    {if $clsTestimonial->getCountry($testimonial_id)}
                                        {$clsTestimonial->getCountry($testimonial_id)} |
                                    {/if}
                                    {$clsTestimonial->getRegDate($testimonial_id)}
                                </div>
                                <div class="owl_hnv_des_review_item_intro_rates">
                                    <div class="owl_hnv_des_review_item_intro_rates_text">
                                        {$clsTestimonial->getRatesTextNumber($testimonial_id)}
                                    </div>
                                </div>
                                <div class="owl_hnv_des_review_item_intro_title">
                                    <h4 class="truncate truncate_1">{$testimonial_title}</h4>
                                </div>
                                <div class="owl_hnv_des_review_item_intro_description truncate truncate_4">
                                    {$clsTestimonial->getIntro($testimonial_id)}
                                </div>
                                <a data-fancybox="" href="javascript:void(0);" title="{$core->get_Lang('View more')}"
                                   data-src="#owl_hnv_des_review_item_detail_{$key}"
                                   class="owl_hnv_des_review_item_detail_more">
                                    {$core->get_Lang('View more')}
                                </a>
                                <div class="owl_hnv_des_review_item_intro_quote">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
            {foreach from=$arr_country_testimonial key=key item=item}
                {assign var=testimonial_id value=$item.testimonial_id}
                {assign var=testimonial_title value=$clsTestimonial->getTitle($testimonial_id)}
                <div id="owl_hnv_des_review_item_detail_{$key}" class="owl_hnv_des_review_item_detail"
                     style="display: none;">
                    <h2 class="mb-3">{$testimonial_title}</h2>
                    <div>{$clsTestimonial->getIntro($testimonial_id)}</div>
                </div>
            {/foreach}
        </div>
    </section>
    {literal}
        <style>
            .owl_hnv_des_review_item_intro {
                padding: 16px 20px 20px;
                position: relative;
            }
            .owl_hnv_des_review_item_intro_customer h3 {
                margin-bottom: 6px;
            }
            .owl_hnv_des_review_item_intro_time {
                color: var(--chroma-717171, #717171);
                font-size: var(--font-size-small);
                margin-bottom: 12px;
            }
            .owl_hnv_des_review_item_intro_rates {
                display: flex;
                gap: 8px;
                align-items: center;
                margin-bottom: 12px;
            }
            .owl_hnv_des_review_item_intro_rates_score {
                border-radius: var(--border-radius-small);
                background: var(--primary-18-babd);
                color: var(--chroma-ffffff);
                font-size: var(--font-size-small);
                padding: 0 8px;
            }
            .owl_hnv_des_review_item_intro_rates_text {
                color: var(--primary-18-babd, #18babd);
                font-size: var(--font-size-small);
                font-weight: var(--font-weight-normal);
            }
            .owl_hnv_des_review_item_intro_rates_text .rates_score {
                color: var(--chroma-ffffff);
                font-size: var(--font-size-small);
                font-weight: var(--font-weight-normal);
                border-radius: var(--border-radius-small);
                background: var(--primary-18-babd);
                padding: 1px 8px;
                align-items: center;
                gap: 10px;
            }
            .owl_hnv_des_review_item_intro_title {
                max-width: 75%;
            }
            .owl_hnv_des_review_item_intro_title h4 {
                margin-bottom: 8px;
            }
            .owl_hnv_des_review_item_intro_description {
                color: var(--chroma-717171);
                font-size: var(--font-size-small);
                min-height: 84px;
            }
            .owl_hnv_des_review_item_intro_quote {
                width: 66px;
                height: 66px;
                position: absolute;
                top: 28%;
                right: 20px;
            }
            .owl_hnv_des_review_item_intro_quote .fa-quote-right {
                font-size: 66px;
                opacity: 0.1;
            }
            .owl_hnv_des_review_list_item {
                border-radius: var(--border-radius-button);
                border: 1px solid var(--chroma-dadfe-6);
                background: var(--light-color);
            }
            .hnv_des_review_title {
                margin-bottom: 24px;
            }

            .owl_hnv_des_review_list .owl-prev, .owl_hnv_des_review_list .owl-next,
            .owl_hnv_des_destination_list .owl-prev, .owl_hnv_des_destination_list .owl-next,
            .owl_hnv_des_thingtodo_list .owl-prev, .owl_hnv_des_thingtodo_list .owl-next,
            .owl_hnv_des_accommodation_list  .owl-prev, .owl_hnv_des_accommodation_list .owl-next,
            .owl_hnv_des_cruise_list .owl-prev, .owl_hnv_des_cruise_list .owl-next,
            .owl_hnv_des_tour_list .owl-prev, .owl_hnv_des_tour_list  .owl-next,
            .owl_hnv_des_attractions_list .owl-prev, .owl_hnv_des_attractions_list .owl-next{
                display: none;
            }
            .owl_hnv_des_review_list:hover .owl-prev, .owl_hnv_des_review_list:hover .owl-next,
            .owl_hnv_des_destination_list:hover .owl-prev, .owl_hnv_des_destination_list:hover .owl-next,
            .owl_hnv_des_thingtodo_list:hover .owl-prev, .owl_hnv_des_thingtodo_list:hover .owl-next,
            .owl_hnv_des_accommodation_list:hover  .owl-prev, .owl_hnv_des_accommodation_list:hover  .owl-next,
            .owl_hnv_des_cruise_list:hover .owl-prev, .owl_hnv_des_cruise_list:hover .owl-next,
            .owl_hnv_des_tour_list:hover .owl-prev, .owl_hnv_des_tour_list:hover  .owl-next,
            .owl_hnv_des_attractions_list:hover .owl-prev, .owl_hnv_des_attractions_list:hover .owl-next{
                display: block;
            }
            .owl_hnv_des_review_list .owl-prev {
                position: absolute;
                top: 50%;
                left: -10px;
                transform: translateY(-70%);
                width: 48px;
                height: 48px;
                background: #fff !important;
                filter: drop-shadow(0px 1px 3px rgba(0, 0, 0, 0.1));
                opacity: unset;
                transition: all 0.3s ease-in-out !important;
            }
            .owl_hnv_des_review_list .owl-next {
                position: absolute;
                top: 50%;
                right: -10px;
                transform: translateY(-70%);
                width: 48px;
                height: 48px;
                background: #fff !important;
                filter: drop-shadow(0px 1px 3px rgba(0, 0, 0, 0.1));
                opacity: unset;
                transition: all 0.3s ease-in-out !important;
            }
            .owl_hnv_des_review_list .owl-prev i,
            .owl_hnv_des_review_list .owl-next i {
                font-size: 28px;
            }
            .owl_hnv_des_review_list .owl-prev:hover,
            .owl_hnv_des_review_list .owl-next:hover {
                background: var(--chroma-c-8-cbd-0) !important;
                cursor: pointer;
            }
            .owl_hnv_des_review_item_detail {
                max-width: 1000px;
            }
            .owl_hnv_des_review_item_detail_more {
                color: var(--secondary-177-fa-4);
                font-size: var(--font-size-small);
            }
            .owl-item {
                height: unset;
            }
            .owl_hnv_des_review_item_image {
                overflow: hidden;
            }
        </style>
        <script>
            (function waitForApp() {
                if (!window.App) {
                    return setTimeout(waitForApp, 50);
                }
                // Tránh register trùng
                if (!window.__carouselReviewRegistered) {
                    window.__carouselReviewRegistered = true;
                    App.registerModule(function ({
                        actionRegistry
                    }) {
                        actionRegistry.register(
                            "carousel.review.init",
                            function () {
                                let $list =
                                    $('.owl_hnv_des_review_list');
                                if (!$list.length) return;
                                $list.each(function () {
                                    let $el = $(this);
                                    // chống init lại
                                    if ($el.hasClass("owl-loaded"))
                                        return;
                                    $el.owlCarousel({
                                        lazyLoad: true,
                                        loop: false,
                                        margin: 26,
                                        nav: true,
                                        dots: false,
                                        smartSpeed: 800,
                                        navText: [
                                            "<i class='fa-solid fa-angle-left'></i>",
                                            "<i class='fa-solid fa-angle-right'></i>"
                                        ],
                                        merge: true,
                                        responsive: {
                                            0: {
                                                items: 1.2,
                                                nav: false
                                            },
                                            576: {
                                                items: 2
                                            },
                                            992: {
                                                items: 3
                                            },
                                            1200: {
                                                items: 3
                                            }
                                        }
                                    });
                                });
                            }
                        );
                    });
                }
                $(window).on("load", function () {
                     App.dispatch(
                        "carousel.review.init"
                    );
                });
            })();
        </script>
    {/literal}
{/if}