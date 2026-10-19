<section class="moretoexplore">
    <div class="container">
        <h2 class="txt_interser">{$core->get_Lang('More to explore')}</h2>

        <div class="row">
            <div class="swiper swiper-exploremore">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="card-contentser card-exploremore card_deals">
                            <a href="{$clsISO->getLink('news')}" title="{$core->get_Lang('Travel news')}">
                                <img
                                    src="{$URL_IMAGES}/img/7567.png"
                                    class="img_interserv img100 img_exploremore"
                                    alt="{$core->get_Lang('Travel news')}"
                                    width="298"
                                    height="276"
                                    loading="lazy"
                                >
                                <div class="swiper-lazy-preloader"></div>

                                <div class="card-bodyserv card-bodyexplore">
                                    <h3 class="card-titleserv title_exploremore">
                                        {$core->get_Lang('Travel news')}
                                    </h3>
                                    <p class="txt_inf_exploremore">
                                        {$core->get_Lang("Update today's travel news and see what's new to take on your adventure")}
                                    </p>
                                    <div class="bttn_exploremore">
                                        <span class="btn btn_exploremore">
                                            {$core->get_Lang('Find out more')}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card-contentser card-exploremore card_deals">
                            <a href="{$clsISO->getLink('become_a_partner')}" title="{$core->get_Lang('Become a partner')}">
                                <img
                                    src="{$URL_IMAGES}/img/2247714.png"
                                    class="img_interserv img100 img_exploremore"
                                    alt="{$core->get_Lang('Become a partner')}"
                                    width="298"
                                    height="276"
                                    loading="lazy"
                                >
                                <div class="swiper-lazy-preloader"></div>

                                <div class="card-bodyserv card-bodyexplore">
                                    <h3 class="card-titleserv title_exploremore">
                                        {$core->get_Lang('Become a partner')}
                                    </h3>
                                    <p class="txt_inf_exploremore">
                                        {$core->get_Lang("Sell on our site and receive thousands of exclusive offers")}
                                    </p>
                                    <div class="bttn_exploremore">
                                        <span class="btn btn_exploremore">
                                            {$core->get_Lang('Find out more')}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card-contentser card-exploremore card_deals">
                            <a href="{$clsISO->getLink('testimonial')}" title="{$core->get_Lang('Customer trust')}">
                                <img
                                    src="{$URL_IMAGES}/img/7714997.png"
                                    class="img_interserv img100 img_exploremore"
                                    alt="{$core->get_Lang('Customer trust')}"
                                    width="298"
                                    height="276"
                                    loading="lazy"
                                >
                                <div class="swiper-lazy-preloader"></div>

                                <div class="card-bodyserv card-bodyexplore">
                                    <h3 class="card-titleserv title_exploremore">
                                        {$core->get_Lang('Customer trust')}
                                    </h3>
                                    <p class="txt_inf_exploremore">
                                        {$core->get_Lang("We always put the best interests of our customers in mind, devoting all the joy to the trip")}
                                    </p>
                                    <div class="bttn_exploremore">
                                        <span class="btn btn_exploremore">
                                            {$core->get_Lang('Find out more')}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>
</section>
{literal}
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.swiper-exploremore', {
        loop: true,
        speed: 800,
        spaceBetween: 30,

        lazy: {
            loadPrevNext: true
        },

        navigation: {
            nextEl: '.swiper-exploremore .swiper-button-next',
            prevEl: '.swiper-exploremore .swiper-button-prev'
        },

        breakpoints: {
            0: {
                slidesPerView: 1.2
            },
            600: {
                slidesPerView: 2
            },
            1000: {
                slidesPerView: 3
            }
        }
    });
});
</script>
<style>
.moretoexplore {
    margin-top: 80px;
}

.img_exploremore {
    border-radius: 12px 12px 0 0;
    background: lightgray 50% / cover no-repeat;
}

.title_exploremore {
    color: #1D2D53;
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    line-height: 40px;
}

.card-exploremore {
    border-radius: 12px;
    background: #fff;
    overflow: hidden;
}

.card-bodyexplore {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    padding: 20px 0;
    border: 1px solid #DADFE6;
    border-top: none;
    border-radius: 0 0 12px 12px;
}

.card-contentser .img_interserv {
    transition: all .3s ease-in-out;
}

.card-contentser:hover .img_interserv {
    transform: scale(1.2);
    border-radius: 8px;
}

.txt_inf_exploremore {
    color: #717171;
    text-align: center;
    font-size: 16px;
    line-height: 24px;
    padding: 0 10px;
    min-height: 72px;
}

.btn_exploremore {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px 20px;
    border-radius: 4px;
    border: 1px solid #18BABD;
    color: #18BABD;
    font-size: 14px;
}

.btn_exploremore:hover {
    background: #18BABD;
    color: #fff;
}

.swiper-exploremore .swiper-button-prev,
.swiper-exploremore .swiper-button-next {
    top: 260px;
    display: none;
    width: 48px;
    height: 48px;
    background: #fff;
    filter: drop-shadow(0 1px 3px rgba(0,0,0,.1));
}

.swiper-exploremore:hover .swiper-button-prev,
.swiper-exploremore:hover .swiper-button-next {
    display: flex;
}

.swiper-button-prev::after,
.swiper-button-next::after {
    display: none;
}
</style>

{/literal}
