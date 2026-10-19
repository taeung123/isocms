<section class="MR_box mt20">
    <h2 class="title">{$core->get_Lang('Most popular tours')}</h2>
    <div class="box">
    	<ul class="MR_Items">
        	{section name=i loop=$listTourTopHot}
            {assign var = title value = $clsTour->getTitle($listTourTopHot[i].tour_id)}
            {assign var = link value = $clsTour->getLink($listTourTopHot[i].tour_id)}
			{assign var=getTripPrice value= $clsTour->getTripMinPrice($listTourTopHot[i].tour_id,$now_day)}
			{assign var=getLTripPriceOld value= $clsTour->getLTripPriceOld($listTourTopHot[i].tour_id)}
            <li>
            	<a class="photo " href="{$link}" title="{$title}"><img src="{$clsTour->getImage($listTourTopHot[i].tour_id,77,54)}" alt="{$title}" width="77" height="54" /></a>
                <div class="rbox">
                	<h3 class="title"><a href="{$link}" title="{$title}">{$title}</a></h3>
                    <p>{$core->get_Lang('Price from')}: <strong class="price-Inc">
					{$clsISO->getRate()} 
					{if $getTripPrice gt 0}
					{$getTripPrice}
					{else}
					{$getLTripPriceOld}
					{/if}
					</strong></p>
                </div>
            </li>
            {/section}
        </ul>
    </div>
</section>
