{if $listWhyHome}
<section class="whychoose">
    <div class="container">
        <h2 class="txt_interser">{$core->get_Lang('Why choose us')}</h2>

        <div class="swiper whychoose-swiper">
            <div class="swiper-wrapper">
                {section name=o loop=$listWhyHome}
                    {assign var=title value=$clsWhy->getTitle($listWhyHome[o].why_id,$listWhyHome[o])}

                    <div class="swiper-slide">
                        <div class="item_whychoose">
                            <div class="img_itemwhy">
                                <img
                                    class="swiper-lazy img_whychoose"
                                    src="{$clsWhy->getIcon($listWhyHome[o].why_id)}"
                                    alt="logo"
                                    title="logo"
                                    width="60"
                                    height="60"
                                >
                            </div>

                            <h3 class="txth3_whychoose">{$title}</h3>
                            <p class="text_linelimit3">
                                {$clsWhy->getIntro($listWhyHome[o].why_id,$listWhyHome[o])}
                            </p>
                        </div>
                    </div>
                {/section}
            </div>

            <!-- navigation -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>
{literal}
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.whychoose-swiper', {
        loop: true,
        speed: 800,
        spaceBetween: 30,

        lazy: {
            loadPrevNext: true,
        },

        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        slidesPerView: 1.2,

        breakpoints: {
            600: {
                slidesPerView: 3,
            },
            1000: {
                slidesPerView: 4,
            }
        },
    });
});
</script> 
{/literal}
{/if}
