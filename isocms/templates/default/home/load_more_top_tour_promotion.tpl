{section name=i loop=$listTopTourPromotion}
            {assign var=promotion_id value=$clsTour->getMinStartDatePromotionProID($listTopTourPromotion[i].taget_id,$now_day)}
            {assign var=checkmem value=$clsTour->getCheckMemSet($listTopTourPromotion[i].taget_id)}
            {assign var=getFlagText value=$clsPromotion->getFlagText($promotion_id)}
            {assign var=getLink value=$clsTour->getLink($listTopTourPromotion[i].taget_id)}
            {assign var=getTitle value=$clsTour->getTitle($listTopTourPromotion[i].taget_id)}
            {assign var=getStarNew value=$clsReviews->getStarNew($listTopTourPromotion[i].taget_id,tour)}
            {assign var=getToTalReview value=$clsReviews->getToTalReview($listTopTourPromotion[i].taget_id,tour)}
            {assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($listTopTourPromotion[i].taget_id,$now_day,$is_agent)}
            {assign var=getPriceTourPromotionnomem value=$clsTour->getTripPriceNewPro2020($listTopTourPromotion[i].taget_id,$now_day,$is_agent,'nomem')}
            <div class="col-md-3 col-sm-6 box">
                <div class="item__tour">
                    <div class="image relative">
                        <a href="{$getLink}" title="{$getTitle}">
                            <img src="{$clsConfiguration->getImage('default_image_pixel',385,256)}" data-src="{$clsTour->getImage($listTopTourPromotion[i].taget_id,385,256)}" alt="{$getTitle}" class="lazy img100">
                        </a>
                        <span class="promotion">-{$clsPromotion->getPromotion($promotion_id)}%</span>
                    </div>
                    <div class="body">
                      
                        <h3 class="body__title limit_2line"><a href="{$getLink}" class="color_1c1c1c" title="{$getTitle}">{$getTitle}</a></h3>
                        <div class="tour_rate box_col">
                            <label class="rate-2019 block mb05">{$getStarNew}</label>
                            <span class="review_text color_666 size14">{$clsReviews->getRateAVG($listTopTourPromotion[i].taget_id,'tour')}/5.0 | {$getToTalReview} {$core->get_Lang('reviews')}</span>
                        </div>
                        <div class="additional_infor">
                            <span class="duration">{$clsTour->getTripDuration2020($listTopTourPromotion[i].taget_id)}</span>
                            <span class="departure"><i class="fa fa-map-marker"></i> {$core->get_Lang('Departure point')}: {$clsTour->getListDeparturePoint($listTopTourPromotion[i].taget_id)}</span>
                        </div>
                        <div class="price">
                            <div class="price__detail">
                                {if $checkmem eq 1}
                                    {if $profile_id eq ''}{$getPriceTourPromotionnomem}{else}{$getPriceTourPromotion}{/if}
                                {else}
                                    {$getPriceTourPromotion}
                                {/if}
                            </div>
                            <a href="{$getLink}" title="{$core->get_Lang('Detail')}" class="link_tour color_1c1c1c">{$core->get_Lang('Detail')}</a>
                        </div>
                    </div>
                </div>
            </div>
            {/section}