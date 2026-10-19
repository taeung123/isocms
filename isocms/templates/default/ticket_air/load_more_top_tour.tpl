{section name=i loop=$listTopTour}
    {assign var=getLCountryAround value=$clsTour->getLCountryAround($listTopTour[i].tour_id)}
    {assign var=getLTripDuration value=$clsTour->getLTripDuration($listTopTour[i].tour_id)}
    {assign var=getLink value=$clsTour->getLink($listTopTour[i].tour_id)}
    {assign var=getTitle value=$clsTour->getTitle($listTopTour[i].tour_id)}
    {assign var=getStarNew value=$clsReviews->getStarNew($listTopTour[i].tour_id,tour)}
    {assign var=getToTalReview value=$clsReviews->getToTalReview($listTopTour[i].tour_id,tour)}
    {assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro($listTopTour[i].tour_id,$now_day,$is_agent)}
    <div class="col-md-3 col-sm-6 box">
        <div class="item__tour">
            <div class="image relative">
                <a href="{$getLink}" title="{$getTitle}">
                    <img src="{$clsTour->getImage($listTopTour[i].tour_id,385,256)}" alt="{$getTitle}" class="img100">
                </a>
            </div>
            <div class="body">
                <h3 class="body__title limit_2line"><a href="{$getLink}" class="color_1c1c1c" title="{$getTitle}">{$getTitle}</a></h3>
                {if $getToTalReview}
                    <div class="tour_rate box_col">
                        <label class="rate-2019 block mb05">{$getStarNew}</label>
                        <span class="review_text color_666 size14">{$clsReviews->getRateAVG($listTopTour[i].tour_id,'tour')}/5.0 | {$getToTalReview} {$core->get_Lang('reviews')}</span>
                    </div>
                {/if}
                <div class="additional_infor">
                    <span class="duration">{$clsTour->getTripDuration2019($listTopTour[i].tour_id)}</span>
                    <span class="departure"><i class="fa fa-map-marker"></i> {$core->get_Lang('Departure point')}: {$clsTour->getListDeparturePoint($listTopTour[i].tour_id)}</span>
                </div>
                <div class="price">
                    <div class="price__detail">
                        {$getPriceTourPromotion}
                    </div>
                    <a href="{$getLink}" title="{$core->get_Lang('Detail')}" class="link_tour color_1c1c1c">{$core->get_Lang('Detail')}</a>
                </div>
            </div>
        </div>
    </div>
{/section}