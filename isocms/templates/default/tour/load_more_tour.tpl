{section name=i loop=$listTour}
{assign var=title_tour value=$clsTour->getTitle($listTour[i].tour_id)}
{assign var=link_tour value=$clsTour->getLink($listTour[i].tour_id)}
{assign var=promotion_id value=$clsTour->getMinStartDatePromotionID($listTour[i].tour_id)}
<div class="box  col-xl-4 col-lg-6 col-md-6 col-sm-6 mb20">
	<div class="grid-item swiper-slide TripItem">
		<div class="photo">
			<div class="tour-collection-actions_2707"></div>
			<div class="top-tag">
				{if $promotion_id ne ''}
				<div class="tag featured">{$clsPromotion->getFlagText($promotion_id)}</div>
				{/if}
				<div class="tag featured"><i class="fa fa-map-marker"></i> {$clsTour->getLCountryAround($listTour[i].tour_id)}</div>
			</div>
			<span style="cursor:pointer" class="{if $profile_id eq ''}exitLogin{else}addWishlist{/if} heart-o inline-block text-center btnwl" title="{$core->get_Lang('Saved to wishlist')}" clsTable="Tour" data="{$listTour[i].tour_id}" id="addwishlistTour{$listTour[i].tour_id}">{$clsTour->getOneField('wishlist_num',$listTour[i].tour_id)}</span>
			<div class="bottom">{$clsTour->getLTripDuration($listTour[i].tour_id)}</div>
			<a href="{$link_tour}" title="{$title_tour}">
				<img class="full-width height-auto" src="{$clsTour->getImage($listTour[i].tour_id,720,480)}" alt="{$title_tour}">
			</a>
		</div>
		<div class="desc">
			<div class="left">
				<h3 class="name"><a title="{$title_tour}" href="{$link_tour}">{$title_tour}</a></h3>
				<label class="rate-1">{$clsReviews->getStarNew($listTour[i].tour_id,tour)}</label>
				<span class="review_text">{$clsReviews->getToTalReview($listTour[i].tour_id,tour)} {$core->get_Lang('reviews')}</span>
			</div>
			{$clsTour->getTripPrice($listTour[i].tour_id,$now_day,$is_agent)}
			{if $promotion_id ne ''}
			<div class="cleafix mb05"></div>
			<div class="date"><i class="fa fa-calendar" aria-hidden="true"></i> {$core->get_Lang('Offer date')}: {$clsTour->getDeparturePromotion($listTour[i].tour_id)}
			</div>
			{/if}
		</div>
	</div>
</div>
{if $smarty.section.i.iteration %2 eq '0'}
<div class="clearfix1 clearfix2"></div>
{else}
<div class="clearfix1"></div>
{/if}
{/section}