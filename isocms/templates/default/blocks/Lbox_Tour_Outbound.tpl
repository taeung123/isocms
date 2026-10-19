{if $listTourOutBound}
    <section class="section_box tour__outbound">
    <div class="tour__outbound--header header__content">
        {assign var = TitleTourOutbound value = TitleTourOutbound_|cat:$_LANG_ID}
        {assign var = IntroTourOutbound value = IntroTourOutbound_|cat:$_LANG_ID}
        <div class="container">
            <h2 class="section_box-title">{$clsConfiguration->getValue($TitleTourOutbound)}</h2>
            <div class="section_box-intro">
                {$clsConfiguration->getValue($IntroTourOutbound)|html_entity_decode}
            </div>
        </div>
    </div>
    <div class="tour__outbound--content">
        <div class="container">
            <div class="box_slider_tour">
                <div class="owl_carousel_4_item owl-carousel">
                    {section name=i loop=$listTourOutBound}
                        {assign var=tour_id value=$listTourOutBound[i].tour_id}
						{assign var=oneTour value=$listTourOutBound[i]}
                        {$clsISO->getBlock('box_item_tour_mobile',["tour_id"=>$tour_id,"oneTour"=>$oneTour])}
                    {/section}
                </div>
            </div>

        </div>
    </div>
</section>
{/if}