{assign var=getLCountryAround value=$clsTour->getLCountryAround($tour_id)}
{assign var=getLTripDuration value=$clsTour->getLTripDuration($tour_id)}
{assign var=getLink value=$clsTour->getLink($tour_id,$one_tour)}
{assign var=getTitle value=$clsTour->getTitle($tour_id,$one_tour)}
{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
{assign var=getToTalReview value=$clsReviews->getToTalReview($tour_id,'tour')}
{assign var=getRateAvg value=$clsReviews->getRateAvg($tour_id,'tour')}
{assign var=getStarNew value=$clsReviews->getStarNew($tour_id,'tour')}
{else}
{assign var=getToTalReview value=$clsReviews->getToTalReviewNoLogin($tour_id,'tour')}
{assign var=getRateAvg value=$clsReviews->getRateAvgNoLogin($tour_id,'tour')}
{assign var=getStarNew value=$clsReviews->getStarNewNoLogin($tour_id,'tour')}
{/if}
{assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent)}
<div class="col-lg-4 col-md-6 box">
	<div class="item__tour {$deviceType}">
		<a href="{$getLink}" title="{$getTitle}">
		<div class="image relative">
			<img src="{$clsTour->getImage($tour_id,385,256,$one_tour)}" alt="{$getTitle}" width="385" height="256" class=" img100">
		</div>
		<div class="body">
			<h3 class="body__title limit_2line color_1c1c1c">{$getTitle}</h3>
			
			<div class="body_info_tour">
				<div class="body_review">
					<p class="review_rate"><span class="rate_avg">{$getRateAvg}</span> 
						<label class="rate-2023 block">{$getStarNew}</label> ({$getToTalReview})</p>
				</div>
                <div class="additional_infor">
                    <span class="duration">{$clsTour->getTripDuration2020($tour_id)}</span>
                </div>
                <div class="d-flex">
                    <div class="body_price">
                        {if $getPriceTourPromotion}
                            {$getPriceTourPromotion}
                        {else}
                            <p class="mb0"></p>
                            <p class="size18 color_fb1111 text-bold mb0">{$core->get_Lang('Contact')}</p>
                        {/if}
                    </div>
                    <div class="view_detail">{$core->get_Lang('Detail')}</div>
                
                </div>
				
			</div>
            
		</div>
		</a>
	</div>
</div>