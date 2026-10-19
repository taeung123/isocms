{if $lstTourRelated[0].tour_id ne ''}
<div class="related_places">
  <div class="container">
    <p class="related_tours_title">{$core->get_Lang('Related Tours')}</p>
    <div class="asd" id="locationTours">
        <div class="destination_carousel">
          <div class="container">
            <div class="row">
              <h3></h3>
              <div class="wrapper placeCrousel_wrapper" style="width:100% !important">
                  <div class="caroufredsel_wrapper">
                    <div class="placesCarousel">
                      <div class="caroufredsel_wrapper">
                        <ul id="item_slider" class="row">
                        {section name=i loop=$lstTourRelated}
                           <li class="grid-item swiper-slide col-md-3">
                            <div class="image">
                              <div class="tour-collection-actions_2707"></div>
                              {assign var=cattour_id value=$clsTour->getOneField('cat_id',$lstTourRelated[i].tour_id)}
                              <div class="bottom">{$clsTour->getLTripDuration($lstTourRelated[i].tour_id)}</div>
                              <a href="{$clsTour->getLink($lstTourRelated[i].tour_id)}"><img alt="{$clsTour->getTitle($lstTourRelated[i].tour_id)}" class="" src="{$clsTour->getImage($lstTourRelated[i].tour_id,324,288)}" width="100%" height="100%"></a></div>
                            <div class="desc">
                              <div class="left">
                                <div class="name"><a href="{$clsTour->getLink($lstTourRelated[i].tour_id)}">{$clsTour->getTitle($lstTourRelated[i].tour_id)}</a></div>
                                <div class="row"><span class="icon filled_color">N</span><span class="icon filled_color">N</span><span class="icon filled_color">N</span><span class="icon filled_color">N</span><span class="icon filled_color">N</span><span class="review_text">19 reviews</span></div>
                              </div>
                              {if $clsTour->getTourPromotion($lstTourRelated[i].tour_id) gt '0'}
                              <div class="price">
                                  <div>
                                      <div class="price_left">
                                      	<span class="discount">{$clsTour->getLTripHotDeals($lstTourRelated[i].tour_id)} </span><span class="original_price"><span>{$clsTour->getLTripPriceOld($lstTourRelated[i].tour_id)}</span></span>
                                      </div>
                                      <div class="discounted_price">
                                      		<span>{$clsTour->getTripPrice($lstTourRelated[i].tour_id)}</span>
                                      </div>
                                  </div>
                              </div>
                              {else}
                              <div class="price">
                                <div>
                                  <div class="price_left no_discount">
                                  	<span class="original_price"><span>{$clsTour->getTripPrice($lstTourRelated[i].tour_id)}</span></span>
                                  </div>
                                </div>
                              </div>
                              {/if}
                            </div>
                          </li>
                          {/section}
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
{/if}
