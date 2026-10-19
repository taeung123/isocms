{if $lstTestimonial}
<section class="review_customer">
    <div class="container">
        <div class="txt_reviews">
            <h2 class="txt_interser">
                {$core->get_Lang('Reviews from Customers')}
            </h2>
            <p class="txtinf_review">
                {$core->get_Lang('Please take a look at the following reviews from our customers')}
            </p>
        </div>
        <div class="swiper swiper-custreview">
            <div class="swiper-wrapper">
                {section name=q loop=$lstTestimonial}
                    {assign var=title_testimonial value=$lstTestimonial[q].title}
                    <div class="swiper-slide">
                        <div class="card_review">
                            <img
                                src="{$clsTestimonial->getImage($lstTestimonial[q].testimonial_id,407,217,$lstTestimonial[q])}"
                                class="card-img-top card_img_review"
                                alt="{$clsTestimonial->getName($lstTestimonial[q].testimonial_id,$lstTestimonial[q])}"
                                width="407"
                                height="217"
                                loading="lazy"
                            >
                            <div class="card-body card-body-review position-relative">
                                <h3 class="card-title card_name_review text_linelimit2">
                                    {$clsTestimonial->getName($lstTestimonial[q].testimonial_id,$lstTestimonial[q])}
                                </h3>
                                <p class="card_region_review">
                                    {$clsTestimonial->getCountry($lstTestimonial[q].testimonial_id,$lstTestimonial[q])}
                                    {if $clsTestimonial->getCountry($lstTestimonial[q].testimonial_id,$lstTestimonial[q]) != ''} | {/if}
                                    {$clsTestimonial->getRegDate($lstTestimonial[q].testimonial_id,$lstTestimonial[q])}
                                </p>
                                <p class="rating d-flex align-items-center rating_custreview">
                                    <span class="border_review me-2">
                                        {$clsTestimonial->getRatesTextNumber($lstTestimonial[q].testimonial_id,$lstTestimonial[q],'avg_point')}
                                    </span>
                                    {$clsTestimonial->getRatesTextNumber($lstTestimonial[q].testimonial_id,$lstTestimonial[q],'txt_review')}
                                    <i class="fa-solid fa-quote-right ms-auto" style="color:#f1f3f5"></i>
                                </p>
                                <div class="txt_inf_des_review">
                                    <p class="txt_infdes_review text_linelimit1">
                                        {$title_testimonial|html_entity_decode|strip_tags}
                                    </p>
                                    <p class="card-text card_des_review text_linelimit3">
                                        {$clsTestimonial->getIntro($lstTestimonial[q].testimonial_id,$lstTestimonial[q])|strip_tags}
                                    </p>
                                </div>
                                <a
                                    href="{$clsTestimonial->getLink($lstTestimonial[q].testimonial_id)}"
                                    class="btn btn_viewmore">
                                    {$core->get_Lang('View more')}
                                </a>
                                <div id="testimonial_detail_{$lstTestimonial[q].testimonial_id}"
                                    class="view_reviews"
                                    style="display:none">
                                    <h3 class="card_name_review mb-3">
                                        {$clsTestimonial->getName($lstTestimonial[q].testimonial_id,$lstTestimonial[q])}
                                    </h3>
                                    <p class="txt_infdes_review mb-3">
                                        {$title_testimonial|html_entity_decode|strip_tags}
                                    </p>
                                    <p class="card_des_review">
                                        {$clsTestimonial->getIntro($lstTestimonial[q].testimonial_id,$lstTestimonial[q])|strip_tags}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                {/section}
            </div>
            <div class="swiper-button-prev"><i class="fa-solid fa-chevron-left"></i></div>
            <div class="swiper-button-next"><i class="fa-solid fa-chevron-right"></i></div>
        </div>
    </div>
</section>
{/if}
{literal}
<script>
    /* ================= SAFE LITERAL MODULE ================= */
    (function () {
        function registerModule() {
            if (!window.App || !App.registerModule) {
                /* Retry đến khi App ready */
                return setTimeout(registerModule, 50);
            }
            /* REGISTER MODULE */
            App.registerModule(function ({ actionRegistry }) {
                function initSwiper(retry = 8) {
                    let $el = $('.swiper-custreview');
                    if (!$el.length) {
                        if (retry > 0) {
                            return setTimeout(function () {
                                initSwiper(retry - 1);
                            }, 200);
                        }
                        return;
                    }
                    /* Prevent double init */
                    if ($el.hasClass("swiper-initialized"))
                        return;
                    console.log("✅ Init customer review swiper");
                    new Swiper('.swiper-custreview', {
                        loop: true,
                        speed: 800,
                        spaceBetween: 30,
                        lazy: {
                            loadPrevNext: true
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev'
                        },
                        breakpoints: {
                            0: { slidesPerView: 1.2 },
                            600: { slidesPerView: 2 },
                            1000: { slidesPerView: 3 }
                        }
                    });
                }
                /* ACTION */
                actionRegistry.register(
                    "carousel.customer_review.init",
                    function () {
                        initSwiper();
                    }
                );
                /* RUN AT WINDOW LOAD */
                actionRegistry.register(
                    "app.loaded",
                    function () {
                        App.dispatch(
                            "carousel.customer_review.init"
                        );
                    }
                );
            });
        }
        registerModule();
    })();
</script>
<style>
.review_customer .txt_interser {
    margin-bottom: 12px;
}
.review_customer .txtinf_review {
    color: var(--secondary-26456-e);
    line-height: var(--line-height);
}
.txt_reviews {
    margin-bottom: 40px;
}
.swiper-custreview .swiper-button-prev,
.swiper-custreview .swiper-button-next {
    top: 186px;
    display: none;
    width: 48px;
    height: 48px;
    background: #fff;
    filter: drop-shadow(0 1px 3px rgba(0,0,0,.1));
    border-radius: var(--border-radius-circle);
}
.swiper-custreview:hover .swiper-button-prev,
.swiper-custreview:hover .swiper-button-next {
    display: flex;
}
.swiper-button-prev::after,
.swiper-button-next::after {
    display: none;
}
.swiper-button-prev i,
.swiper-button-next i {
    font-size: var(--font-size-title);
    color: var(--primary-color);
}
.card_review {
    display: flex;
    flex-direction: column;
    border-radius: 4px 4px 0px 0px;
    overflow: hidden;
}
.card_review img {
    border-radius: var(--border-radius-card);
    overflow: hidden;
    transition: all 0.3s ease-in-out !important;
}
.card_review img:hover {
    scale: 1.2;
}
.card_review .card_img_review {
    align-self: stretch;
    border-radius: 4px 4px 0px 0px;
    height: revert-layer;
}
.card-body-review {
    padding: 16px 14px 14px 14px;
    border-radius: var(--border-radius-button);
    border: 1px solid var(--chroma-dadfe-6);
    background: var(--chroma-ffffff);
}
.card_name_review {
    color: var(--secondary-00818-a);
    margin-bottom: 8px;
}
.card_region_review {
    color: var(--chroma-717171, #717171);
    font-size: var(--font-size-small);
    margin-bottom: 12px;
}
.border_review {
    display: flex;
    padding: 1px 8px;
    justify-content: center;
    align-items: center;
    gap: 10px;
    border-radius: 2px;
    background: var(--primary-18-babd, #18BABD);
    color: var(--chroma-ffffff, #FFF);
}
.rating_custreview {
    color: var(--primary-18-babd, #18BABD);
    font-size: var(--font-size-small);
    font-weight: var(--font-weight-normal);
    line-height: var(--line-height);
    margin-bottom: 12px;
}
.txt_infdes_review {
    color: var(--primary-1-d-2-d-53, #1D2D53);
    font-weight: var(--font-weight-bold);
    line-height: var(--line-height)
}
.card_des_review {
    color: var(--chroma-717171, #717171);
    font-size: var(--font-size-small);
    line-height: var(--line-height);
}
.owl-custreview .btn_viewmore {
    border: none;
    padding: unset;
    color: var(--secondary-177-fa-4, #177FA4);
    font-size: var(--font-size-small);
    line-height: var(--line-height);
    justify-content: left;
    align-items: first;
}
.owl-custreview .btn_viewmore:hover {
    text-decoration: underline;
    background: unset;
    color: var(--secondary-177-fa-4, #177FA4);
    border: none;
}
.txt_inf_des_review {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 15px;
}
</style>
{/literal}
