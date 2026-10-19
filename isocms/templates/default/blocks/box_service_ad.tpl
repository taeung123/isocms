{if $listWhy}
<section class="box_service_ad">
    <div class="container">
        <h2 class="sec_box_service_title">{$PAGE_NAME} {$core->get_Lang('is always the ideal choice')}</h2>
        <div class="owl-carousel list_service_ad">
            {section name=i loop=$listWhy}
                <div class="service_ad_item">
                    <div class="icon_service">
                        <img src="{$clsWhy->getIcon($listWhy[i].why_id,$listWhy[i])}" alt="{$clsWhy->getTitle($listWhy[i].why_id,$listWhy[i])}" width="70"
                             height="70">
                    </div>
                    <div class="box_service_content">{$clsWhy->getStripIntro($listWhy[i].why_id,$listWhy[i])}</div>
                </div>
            {/section}
        </div>

    </div>
</section>
{literal}
<script>
    $('.list_service_ad').owlCarousel({
        loop:true,
        margin:30,
        nav:false,
        dots:false,
        autoplay:true,
        autoplayTimeout:3500,
        responsive:{
            0:{
                margin: 20,
                items:1,
                loop: $('.owl-carousel .service_ad_item').size() > 1 ? true:false,
            },
            600:{
                items:2,
                loop: $('.owl-carousel .service_ad_item').size() > 2 ? true:false,
            },
            992:{
                items:3,
                loop: $('.owl-carousel .service_ad_item').size() > 3 ? true:false
            },
            1025:{
                items:3,
                loop: $('.owl-carousel .service_ad_item').size() > 3 ? true:false,
            }
        }
    });

</script>
{/literal}
{/if}