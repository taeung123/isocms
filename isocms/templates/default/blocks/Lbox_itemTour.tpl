<div class="image">
	<div class="tour-collection-actions_2707"></div>
    {assign var=cattour_id value=$clsTour->getOneField('cat_id',$listTopTour[i].tour_id)}
    {if $clsTourCategory->getTitle($cattour_id) ne ''}
    <div class="tag featured">{$clsTourCategory->getTitle($cattour_id)}</div>
    {/if}
    <div class="tag featured"><i class="fa fa-map-marker"></i> {$clsTour->getLCountryAround($listTopTour[i].tour_id)}</div>
    <span style="cursor:pointer" class="{if $profile_id eq ''}exitLogin{else}addWishlist{/if} heart-o inline-block text-center btnwl" title="{$core->get_Lang('Saved to wishlist')}" clsTable="Tour" data="{$listTopTour[i].tour_id}" id="addwishlistTour{$listTopTour[i].tour_id}">{$clsTour->getOneField('wishlist_num',$listTopTour[i].tour_id)}</span>
    <div class="bottom">{$clsTour->getLTripDuration($listTopTour[i].tour_id)}</div>
    <a href="{$clsTour->getLink($listTopTour[i].tour_id)}" title="{$clsTour->getTitle($listTopTour[i].tour_id)}">
    <img class="lazy" data-original="{$clsTour->getImage($listTopTour[i].tour_id,720,480)}" alt="{$clsTour->getTitle($listTopTour[i].tour_id)}" width="100%" height="auto">
    </a>
</div>
<div class="desc">
    <div class="left">
    <div class="name"><a href="{$clsTour->getLink($listTopTour[i].tour_id)}">{$clsTour->getTitle($listTopTour[i].tour_id)}</a></div>
    <label class="rate-1">{$clsTour_Review->getStarNew($listTopTour[i].tour_id)}</label>
    <span class="review_text">{$clsTour_Review->getToTalReview($listTopTour[i].tour_id)} reviews</span>
    </div>
    {if $clsTour->getTripPrice($listTopTour[i].tour_id,$now_day) gt '0' and $clsTour->getLTripPriceOld($listTopTour[i].tour_id) gt '0'}
    <div class="price">
      <div>
          <div class="price_left">
            <span class="original_price">{$clsISO->getRate()} {$clsTour->getLTripPriceOld($listTopTour[i].tour_id)}</span></span>
          </div>
          <div class="discounted_price">
                <span>{$clsISO->getRate()} {$clsTour->getTripPrice($listTopTour[i].tour_id,$now_day)}</span>
          </div>
      </div>
    </div>
    {elseif ($clsTour->getTripPrice($listTopTour[i].tour_id,$now_day) eq '0' or $clsTour->getTripPrice($listTopTour[i].tour_id,$now_day) eq '') and $clsTour->getLTripPriceOld($listTopTour[i].tour_id) gt '0'}
    <div class="price">
    <div>
      <div class="price_left no_discount">
        <span class="discounted_price">{$clsISO->getRate()} {$clsTour->getLTripPriceOld($listTopTour[i].tour_id)}</span>
      </div>
    </div>
    </div>
    {elseif $clsTour->getTripPrice($listTopTour[i].tour_id,$now_day) gt '0' and ($clsTour->getLTripPriceOld($listTopTour[i].tour_id) eq '0' or $clsTour->getLTripPriceOld($listTopTour[i].tour_id) eq '')}
    <div class="price">
    <div>
      <div class="price_left no_discount">
        <span class="discounted_price">{$clsISO->getRate()} {$clsTour->getTripPrice($listTopTour[i].tour_id,$now_day)}</span>
      </div>
    </div>
    </div>
    {else}
    
    {/if}
</div>