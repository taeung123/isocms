 {if !empty($listAdsHome)}
    <section class="itinerary_ins">
        <div class="container">
            <h2 class="txt_itinerary">
                {$core->get_Lang('Inspiration for your itinerary')}
            </h2>

            <!-- Swiper -->
            <div class="swiper itinerary-swiper">
                <div class="swiper-wrapper">
                    {foreach from=$listAdsHome item=ad}
                        <div class="swiper-slide item_itinerary">
                            <a href="{$clsAds->getLink($ad.ads_id)}">
                                <picture>
                                    {if $deviceType ne 'phone'}
                                        <img
                                            src="{$clsAds->getImage($ad.ads_id,624,335)}"
                                            alt="{$clsAds->getTitle($ad.ads_id)}"
                                            width="624"
                                            height="335"
                                            class="swiper-lazy img_itinerary w-100"
                                            loading="lazy"
                                        >
                                    {else}
                                        <img
                                            src="{$clsAds->getImage($ad.ads_id,450,300)}"
                                            alt="{$clsAds->getTitle($ad.ads_id)}"
                                            width="450"
                                            height="300"
                                            class="swiper-lazy img_itinerary w-100"
                                            loading="lazy"
                                        >
                                    {/if}
                                </picture>
                            </a>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </section>
{/if}