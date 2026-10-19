<link rel="stylesheet" type="text/css" href="{$URL_CSS}/screen.css?v={$upd_version}" />
<script type="text/javascript" src="{$URL_JS}/slick.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/functions1.js?v={$upd_version}"></script>
<section class="lastterOffer desktop">
    <div class="container">
        <h2 class="headPage text-center"><a href="/promotions">{$core->get_Lang('Explore our latest offers')}</a></h2>
        <p class="intro14_3 mb60 text-center">
        {assign var=site_promotion_intro value=site_promotion_intro_|cat:$_LANG_ID}
        {$clsConfiguration->getValue($site_promotion_intro)|html_entity_decode|strip_tags}
    </div>
    <section class="section section-hot-offer">
       <span class="section-delimiter"></span>
       <section class="hot-offer-block">
          <span class="hot-offer-slider-arrow arrow-prev">
             <i class="icon-arrowleft"></i>
          </span>
          <span class="hot-offer-slider-arrow arrow-next">
             <i class="icon-arrowright"></i>
          </span>
          <div class="row row-fit"> 
             <section class="col-md-5">
			 	 <h2><a href="/promotions">Latest OFFER</a></h2>
				 <div class="hot-offer-description">
                    <div class="body">
						<h3><a href="{$lstTourOfferHome[i.first].link}">{$lstTourOfferHome[i.first].title}</a></h3>
						<p>{$clsTour->getIntro($lstTourOfferHome[i.first].tour_id)|html_entity_decode|strip_tags|truncate:200}</p>
						<a href="{$lstTourOfferHome[i.first].link}" class="link">View details</a>
                   </div> 
                </div> 
			 </section>
             <section class="col-md-7">
                <div class="hot-offer-cover">
                   <div class="theme-slider" data-dots="false" data-arrows="false" data-infinite="true">
                      <ul class="slides-list clean-list">
                        {section name=i loop=$lstTourOfferHome}
                         <li class="slide" data-title="{$lstTourOfferHome[i].title}" data-description="{$lstTourOfferHome[i].intro|html_entity_decode|strip_tags|truncate:200}" data-link="{$lstTourOfferHome[i].link}">
                            <div class="offer-item-meta">
                                <span class="price"></span>
                               <ul class="clean-list comodities">
                                  <li class="comodity price">
                                    Price from<span>
                                    {$clsTour->getTripPrice($lstTourOfferHome[i].tour_id)}</span>
                                  </li>
                                  <li class="comodity duration">
                                     {$core->get_Lang('Durations')} <span>
                                     {$clsTour->getTripDuration($lstTourOfferHome[i].tour_id)}</span>
                                  </li>
                                  <li class="comodity travelstyle">
                                     {$core->get_Lang('Travel styles')} <br/><a href="{$clsTourCategory->getLink($lstTourOfferHome[i].cat_id)}" title="{$clsTourCategory->getTitle($lstTourHome[i].cat_id)}">{$clsTourCategory->getTitle($lstTourHome[i].cat_id)}</a>
                                  </li>
                               </ul>
                            </div>
                            <img src="{$lstTourOfferHome[i].image}" width="670" height="430" alt="{$title}" />
                         </li>
                        {/section}
                      </ul>
                   </div>
                </div>
             </section>
          </div>
       </section>
    </section>
</section>

