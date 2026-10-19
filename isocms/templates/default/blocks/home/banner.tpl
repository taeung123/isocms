<section class="bground-section">
    <div class="bground_img2">
        {if $clsConfiguration->getValue('Video_Teaser_Home') and $clsConfiguration->getValue('video_teaser_page') ne ''}
            <section id="slider" class="section_box">
                <div id="video-teaser" class="video-teaser video-container">
                    <div class="filter"></div>
                    <video autoplay loop muted class="fillWidth">
                        <source src="{$clsConfiguration->getValue('video_teaser_page')}" type="video/mp4">
                        {$core->get_Lang('Your browser does not support the video tag. I suggest you upgrade your browser.')}
                    </video>
                </div>
            </section>
        {else}
            {if $listSlide}
                <section id="slider" class="section_box">
                    <div class="swiper-container slider_swiper_container">
                        <div class="swiper-wrapper">
                            {foreach from=$listSlide key=key item=item} 
                                <div class="swiper-slide iso_slider_swiper">
                                    <picture>
                                        <source media="(max-width: 576px)" 
                                                srcset="{$clsSlide->getImage($item.slide_id,480,320,$item)}">
                                        <source media="(min-width: 576px)" 
                                                srcset="{$clsSlide->getImage($item.slide_id,1920,760,$item)}">
                                        <img src="{$clsSlide->getImage($item.slide_id,1920,760,$item)}" 
                                            alt="Image slider" class="swiper-lazy">
                                    </picture>
                                </div>
                            {/foreach}
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </section> 
            {/if} 
        {/if}
    </div>
   {$clsISO->build('iso_search_tour.tpl')}
</section>


