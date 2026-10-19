{if $listTopTour[0].tour_id ne ''}
<div class="MR_box">
    <h2 class="h3_24_Bold mb10">{$core->get_Lang('Most popular tours')}</h2>
    <div class="box">
    	<ul class="MR_Items">
        	{section name=i loop=$listTopTour max=5}
            {assign var = title value = $clsTour->getTitle($listTopTour[i].tour_id)}
            {assign var = link value = $clsTour->getLink($listTopTour[i].tour_id)}
            <li>
            	<a class="photo" href="{$link}" title="{$title}"><img src="{$clsTour->getImage($listTopTour[i].tour_id,393,276)}" alt="{$title}" width="100%"/></a>
                <div class="rbox">
                	<h3 class="title"><a href="{$link}" title="{$title}">{$title}</a></h3>
                     {if $clsTour->getTripPrice($listTopTour[i].tour_id,$now_day) gt '0' and $clsTour->getLTripPriceOld($listTopTour[i].tour_id) gt '0'}
                     <p>{$core->get_Lang('Price from')}: <strong class="price-Inc">{$clsISO->getRate()} {$clsTour->getTripPrice($listTopTour[i].tour_id,$now_day)}</strong></p>
                      {elseif $clsTour->getTripPrice($listTopTour[i].tour_id,$now_day) eq '0' and $clsTour->getLTripPriceOld($listTopTour[i].tour_id) gt '0'}
                       <p>{$core->get_Lang('Price from')}: <strong class="price-Inc">{$clsISO->getRate()} {$clsTour->getLTripPriceOld($listTopTour[i].tour_id,$now_day)}</strong></p>
                      {elseif $clsTour->getTripPrice($listTopTour[i].tour_id,$now_day) gt '0' and $clsTour->getLTripPriceOld($listTopTour[i].tour_id) eq '0'}
                       <p>{$core->get_Lang('Price from')}: <strong class="price-Inc">{$clsISO->getRate()} {$clsTour->getTripPrice($listTopTour[i].tour_id,$now_day)}</strong></p>
                      {else}
                      {/if}
                </div>
            </li>
            {/section}
        </ul>
    </div>
</div>
{/if}