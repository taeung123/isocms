{assign var=promotion_id value=$clsTour->getMinStartDatePromotionProID($tour_id,$now_day)}
{assign var=checkmem value=$clsTour->getCheckMemSet($tour_id)}
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
{assign var=getPriceTourPromotionnomem value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent,'nomem')}
{assign var=getPromotion value=$clsPromotion->getPromotion($promotion_id)}
<div class="box__padding">
	<div class="itemTrip">
		<div class="image relative">
			<a href="{$getLink}" title="{$getTitle}">
				<img src="{$clsConfiguration->getImage('default_image_pixel',296,196)}" data-src="{$clsTour->getImage($tour_id,296,196)}" alt="{$getTitle}" class="owl-lazy lazy img100">
			</a>
			{if $getPromotion}<span class="promotion">-{$getPromotion}%</span>{/if}
			<span class="duration"><i class="fa fa-clock-o" aria-hidden="true"></i> {$clsTour->getTripDuration2020($tour_id)}</span>
		</div>
		<div class="body">
			<div class="show_item">
			<h3 class="body__title limit_2line"><a href="{$getLink}" class="color_1c1c1c" title="{$getTitle}">{$getTitle}</a></h3>
				<div class="tour_rate box_col">
					<label class="rate-2019 block mb05">{$getStarNew}</label>
					<span class="review_text color_666 size14">{$getRateAvg}/5.0 | {$getToTalReview} {$core->get_Lang('reviews')}</span>
				</div>
			<div class="additional_infor">
				<i class="fa fa-map-marker"></i> {$core->get_Lang('Departure point')}: {$clsTour->getListDeparturePoint($tour_id)}
			</div>
			</div>
			<div class="price">
				{if $checkmem eq 1}
					{if $profile_id eq ''}{$getPriceTourPromotionnomem}{else}{$getPriceTourPromotion}{/if}
				{elseif $getPriceTourPromotion}
					{$getPriceTourPromotion}
				{else}
					<span class="size18 color_fb1111 text-bold">{$core->get_Lang('Updating')}</span>
				{/if}
			</div>
		</div>
	</div>
</div>