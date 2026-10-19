{section name=i loop=$listTour}
<div class="box col-xs-6 col-sm-6 col-md-4">
	{if $clsTourStore->checkExist($listTour[i].tour_id,PROMOTION)}
	<div class="grid-item swiper-slide TripItem">
		<div class="image">
		  <div class="tour-collection-actions_2707"></div>
		  {assign var=cattour_id value=$clsTour->getOneField('cat_id',$listTour[i].tour_id)}
		  {assign var=hot_promotion_id value=$clsTour->getMinStartDatePromotionID($listTour[i].tour_id)}
		  {if $hot_promotion_id ne ''}
		  <div class="tag featured">{$clsHotPromotion->getFlagText($hot_promotion_id)}</div>
		  {/if}
		  <div class="tag featured"><i class="fa fa-map-marker"></i> {$clsTour->getLCountryAround($listTour[i].tour_id)}</div>
		  <span style="cursor:pointer" class="{if $profile_id eq ''}exitLogin{else}addWishlist{/if} heart-o inline-block text-center btnwl" title="{$core->get_Lang('Saved to wishlist')}" clsTable="Tour" data="{$listTour[i].tour_id}" id="addwishlistTour{$listTour[i].tour_id}">{$clsTour->getOneField('wishlist_num',$listTour[i].tour_id)}</span>
		  <div class="bottom">{$clsTour->getLTripDuration($listTour[i].tour_id)}</div>
		  <a href="{$clsTour->getLink($listTour[i].tour_id)}" title="{$clsTour->getTitle($listTour[i].tour_id)}">
		  <img class="lazy" data-original="{$clsTour->getImage($listTour[i].tour_id,720,480)}" alt="{$clsTour->getTitle($listTour[i].tour_id)}" width="100%" height="auto">
		  </a>
		</div>
		<div class="desc">
		  <div class="left">
			<div class="name"><a href="{$clsTour->getLink($listTour[i].tour_id)}">{$clsTour->getTitle($listTour[i].tour_id)}</a></div>
			<label class="rate-1">{$clsReviews->getStarNew($listTour[i].tour_id,tour)}</label>
			<span class="review_text">{$clsReviews->getToTalReview($listTour[i].tour_id,tour)} {$core->get_Lang('reviews')}</span>
		  </div>
		  {$clsTour->getPriceTourPromotion($listTour[i].tour_id,$is_agent)}
		  <div class="cleafix"></div>
		  <div class="date"><i class="fa fa-calendar" aria-hidden="true"></i> {$core->get_Lang('Departure date')}: {$clsTour->getDeparturePromotion($listTour[i].tour_id)} {if $clsTour->checkDeparturePromotionOther($listTour[i].tour_id)}<a class="otherDate" href="{$clsTour->getLinkDeparture($listTour[i].tour_id)}" title="">{$core->get_lang('Other date')}</a>{/if}</div>
		</div>
	  </div>
	  {else}
	  <div class="grid-item swiper-slide TripItem">
		<div class="image">
		  <div class="tour-collection-actions_2707"></div>
		  <div class="tag featured"><i class="fa fa-map-marker"></i> {$clsTour->getLCountryAround($listTour[i].tour_id)}</div>
		  <span style="cursor:pointer" class="{if $profile_id eq ''}exitLogin{else}addWishlist{/if} heart-o inline-block text-center btnwl" title="{$core->get_Lang('Saved to wishlist')}" clsTable="Tour" data="{$listTour[i].tour_id}" id="addwishlistTour{$listTour[i].tour_id}">{$clsTour->getOneField('wishlist_num',$listTour[i].tour_id)}</span>
		  <div class="bottom">{$clsTour->getLTripDuration($listTour[i].tour_id)}</div>
		  <a href="{$clsTour->getLink($listTour[i].tour_id)}" title="{$clsTour->getTitle($listTour[i].tour_id)}">
		  <img class="lazy" data-original="{$clsTour->getImage($listTour[i].tour_id,720,480)}" alt="{$clsTour->getTitle($listTour[i].tour_id)}" width="100%" height="auto">
		  </a>
		</div>
		<div class="desc">
		  <div class="left">
			<div class="name"><a href="{$clsTour->getLink($listTour[i].tour_id)}">{$clsTour->getTitle($listTour[i].tour_id)}</a></div>
			<label class="rate-1">{$clsReviews->getStarNew($listTour[i].tour_id,tour)}</label>
			<span class="review_text">{$clsReviews->getToTalReview($listTour[i].tour_id,tour)} {$core->get_Lang('reviews')}</span>
		  </div>
		  {$clsTour->getTripPrice($listTour[i].tour_id,$is_agent)}
		</div>
	  </div>
	  {/if}
</div>
{/section} 