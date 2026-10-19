{if $clsConfiguration->getValue('Video_Teaser_Home') and $clsConfiguration->getValue('video_teaser_page') ne ''}
<section id="slider" class="relative section_box">
    <div id="video-teaser" class="video-teaser video-container">
        <div class="filter"></div>
        <video autoplay loop muted class="fillWidth"><source src="{$clsConfiguration->getValue('video_teaser_page')}" type="video/mp4">
            {$core->get_Lang('Your browser does not support the video tag. I suggest you upgrade your browser.')}
        </video>
    </div>
    {if $mod eq 'ticket_air'}
    <div class="box_search_home {$deviceType}">
    {$core->getBlock('find_ticket_air')}
    </div>
    {else}
    <div class="box_search_home {$deviceType}">
        {$core->getBlock('find_trip_detailspro')}
    </div>
    {/if}
</section>
{else}
    {if $listSlide}
    <section id="slider" class="relative section_box">
        <div class="slider__home owl-carousel">
            {section name=i loop=$listSlide}
                {assign var = slide_title value = $listSlide[i].title}
                {assign var = slide_text value = $listSlide[i].text}
                {assign var = slide_link value = $listSlide[i].link}
                {if $clsISO->getBrowser() eq 'phone'}
                    <div class="item__slider">
                       {if $slide_link != ''}
                        <a href="{$slide_link}" title="{$slide_title}">
                            <img src="{$clsConfiguration->getImage('default_image_pixel',3,2)}" data-src="{$clsSlide->getImage($listSlide[i].slide_id,480,320,$listSlide[i])}" width="480" height="320" alt="{$slide_title}" class="img100 owl-lazy">
                        </a>
                        {else}
                        <img src="{$clsConfiguration->getImage('default_image_pixel',3,2)}" data-src="{$clsSlide->getImage($listSlide[i].slide_id,480,320,$listSlide[i])}" width="480" height="320" alt="{$slide_title}" class="img100 owl-lazy">
                        {/if}
                    </div>
                {else}
                    <div class="item_slider {$clsISO->getBrowser()}">
                       	{if $slide_link != ''}
                        <a href="{$slide_link}" title="{$slide_title}">
                            <img src="{$clsConfiguration->getImage('default_image_pixel',4,1)}" data-src="{$clsSlide->getImage($listSlide[i].slide_id,1600,460,$listSlide[i])}" width="1600" height="460" alt="{$slide_title}" class="img100 owl-lazy">
                        </a>
                        {else}
                        <img src="{$clsConfiguration->getImage('default_image_pixel',4,1)}" data-src="{$clsSlide->getImage($listSlide[i].slide_id,1600,460,$listSlide[i])}" width="1600" height="460" alt="{$slide_title}" class="img100 owl-lazy">
                        {/if}
                    </div>
                {/if}
            {/section}
        </div>
		{if $mod eq 'ticket_air'}
		<div class="box_search_home {$deviceType}">
		{$core->getBlock('find_ticket_air')}
		</div>
		{else}
        <div class="box_search_home {$deviceType}">
            {$core->getBlock('find_trip_detailspro')}
        </div>
		{/if}
    </section>
    {/if}
{/if}
