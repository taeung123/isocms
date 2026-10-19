<div class="slideHomeTour" data="{$city_id}">
    <div id="sliderHomeTour_{$smarty.section.i.index}" class="owl-carousel owl-carousel-homegroup">
        {assign var = lstTourTop value = $clsISO->getTourInHome($city_id,6)}
        {section name=j loop=$lstTourTop}
        {assign var=title value=$clsTour->getTitle($lstTourTop[j].tour_id)}
        {assign var=link value=$clsTour->getLink($lstTourTop[j].tour_id)}
        <div class="TourItem">
            <div class="photo200">
                <a href="{$link}" title="{$title}">
                    <img src="{$clsTour->getImage($lstTourTop[j].tour_id,200,155)}" width="200" height="155" alt="{$title}" />
                </a>
             <div class="price">From <strong>{$clsTour->getTripPrice($lstTourTop[j].tour_id)}</strong></div>
             <div class="duration">{$clsTour->getTripDuration($lstTourTop[j].tour_id)}</div>
            </div>
            <div class="body">
                <h3><a href="{$link}" title="{$title}">{$title}</a></h3>
                <div class="address"><i class="icon_add"></i>{$clsTour->getCityAround($lstTourTop[j].tour_id)|strip_tags}</div>
                <div class="intro14_3">{$clsTour->getIntro($lstTourTop[j].tour_id)|truncate:100}</div>
               
            </div>
            <div class="cleafix"></div>
            <div class="offerBook">
            {if $clsTour->getTripOldPrice($lstTourTop[j].tour_id) ne ''}
            <p class="offer">OFFERS:  <span class="line-through">{$clsTour->getTripOldPrice($lstTourTop[j].tour_id)}</span>| {$clsTour->getTripPrice($lstTourTop[j].tour_id)}</p>{/if}
            <a class="linkBook" href="{$clsTour->getLinkBook($lstTourTop[j].tour_id)}" title="{$core->get_Lang('Book now')}">{$core->get_Lang('Book now')}</a>
            </div>
        </div>
        {/section}
    </div>
</div>