<div class="box__images relative">
    <div class="carousel--one__item owl-carousel" _type="detail__tour">
        {section name=i loop=$lstImage}
            <div class="img__tour">
                <img class="img100"  src="{$clsTourImage->getImage($lstImage[i].tour_image_id,840,420,$lstImage[i])}" alt="{$clsTourImage->getTitle($lstImage[i].tour_image_id,$lstImage[i])}"/>
            </div>
        {/section}
    </div>
    <div class="blur_bg hidden-xs" style="background-image:url('{$clsTourImage->getImage($lstImage[0].tour_image_id,1280,420,$lstImage[i])}') "></div>
</div>
