{assign var = link value = $clsHotel->getLink($hotel_id,$arrHotel)}
{assign var = title value = $clsHotel->getTitle($hotel_id,$arrHotel)}
{assign var = getImageStar value = $clsHotel->getHotelStar($hotel_id,$arrHotel)}
{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
    {assign var= ratingValue value= $clsReviews->getRateAvg($hotel_id,'hotel','10')}
{else}
    {assign var= ratingValue value= $clsReviews->getRateAvgNoLogin($hotel_id,'hotel','10')}
{/if}
{assign var=textRateAvg value=$clsReviews->getTextRateAvg($hotel_id,'hotel')}
<div class="relate_slide_item">
    <div class="relate_slide_image">
        <a href="{$link}" title="{$title}">
            <img class="img-responsive img100" src="{$clsHotel->getImage($hotel_id,298,195,$arrHotel)}" alt="{$title}" />
        </a>
    </div>
    <div class="relate_slide_item_body">
        <h3 class="relate_slide_item_title">
            <a href="{$link}" title="{$title}">{$title}</a>
        </h3>
        <div class="score_number">
            {$ratingValue} <span>{$textRateAvg}</span>
        </div>
        <div class="price_from">
            {$core->get_Lang('Only from')} <span>{$clsHotel->getPriceOnPromotion($hotel_id)}</span>
        </div>
    </div>
</div>
