{section name=i loop=$listPromotionId}
	{assign var=tour_id value=$listPromotionId[i].item_id}
	{assign var=getLink value=$clsTour->getLink($tour_id)}
	{assign var=getTitle value=$clsTour->getTitle($tour_id)}

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
	{assign var=percent_promotion value=$clsISO->getPromotion($tour_id,'Tour',$now_day,$now_day,'info_promotion')}
	{assign var=close_sale_date value=$clsTour->getTourStartDate($tour_id,$now,'close_sale_date')}
	<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6 box">
		<div class="itemTrip {$deviceType}">
			<a href="{$getLink}" title="{$getTitle}">
				<div class="image relative">
					<img src="{$clsConfiguration->getImage('default_image_pixel',296,196)}" data-src="{$clsTour->getImage($tour_id,296,196)}" alt="{$getTitle}" class="lazy img100">
					<span class="percent_promotion">
					{$percent_promotion.discount_value}%
					</span>
					{if $close_sale_date}
					<div class="clock_last_hour" data-date="{$close_sale_date|date_format:'%m/%d/%Y %k:%M:%S'}"></div>
					{/if}
					<span class="duration"><i class="fa fa-clock-o" aria-hidden="true"></i> {$clsTour->getTripDuration2020($tour_id)}</span>
				</div>
				<div class="body body_tour">
					<h3 class="body__title limit_2line">{$getTitle}</h3>
					<div class="body_info_tour">
						<div class="body_review">
							<p class="review_rate"><span class="rate_avg">{$getRateAvg}</span> <label class="rate-2019 block">{$getStarNew}</label></p>
							<p class="review_count">{$getToTalReview} {$core->get_Lang('reviews')}</p>
						</div>
						<div class="body_price">
						{if $getPriceTourPromotion}
							{$getPriceTourPromotion}
						{else}
							<p class="size18 color_fb1111 text-bold mb0">{$core->get_Lang('Contact')}</p>
						{/if}
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
{/section}