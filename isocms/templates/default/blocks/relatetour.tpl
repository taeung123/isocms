{if $lstTourRelated}
<section id="related__Box" class="related__Box">
    <div class="head__Box">
        <h2 class="title_headBox">{$core->get_Lang('Related Tours')}</h2>
    </div>
	<div class="box_slider_tour">
		<div class="owl-carousel owl_carousel_4_item" >
			{section name=i loop=$lstTourRelated}
			{assign var=oneTour value=$lstTourRelated[i]}
			{assign var=tour__id value=$lstTourRelated[i].tour_id}
			{$clsISO->getBlock('box_item_tour_mobile',["tour_id"=>$tour__id,"oneTour"=>$oneTour])}
			{/section}
		</div>
	</div>
</div>
</section>
{/if}
