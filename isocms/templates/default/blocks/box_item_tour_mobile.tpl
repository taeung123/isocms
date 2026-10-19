{assign var=getLink value=$clsTour->getLink($tour_id,$oneTour)}
{assign var=getTitle value=$clsTour->getTitle($tour_id,$oneTour)}
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
<div class="box__padding">
	<div class="itemTrip {$deviceType}">
		<a href="{$getLink}" title="{$getTitle}">
			<div class="image relative">
				<img src="{$clsConfiguration->getImage('default_image_pixel',3,2)}" data-src="{$clsTour->getImage($tour_id,295,195,$oneTour)}" width="295" height="195" alt="{$getTitle}" class="{if $mod eq 'home' || $act eq 'detaildeparture'}owl-lazy{else}lazy{/if} img100">
				{if $percent_promotion.discount_value}
					<span class="promotion bg_main">
						{if $percent_promotion.discount_type eq 1}
							{if $_LANG_ID eq 'vn'}
								-{$percent_promotion.discount_value}{$clsISO->getShortRateText()}
							{else}
								-{$clsISO->getShortRateText()}{$percent_promotion.discount_value}
							{/if}
						{else}
							-{$percent_promotion.discount_value}%
						{/if}
					</span>
				{/if}
				<span class="duration"><i class="fa-light fa-clock"></i> {$clsTour->getTripDuration2020($tour_id,'',$oneTour)}</span>
			</div>
			<div class="body body_two">
				<h3 class="body__title limit_2line color_1c1c1c">{$getTitle}</h3>
				<div class="body_info_tour d-flex">
					<div class="body_review">
						<p class="review_rate"><span class="rate_avg">{$getRateAvg}</span> <label class="rate-one block">{$getStarNew}</label></p>
						<p class="review_count">({$getToTalReview})</p>
					</div>
					<div class="body_price text_right">
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