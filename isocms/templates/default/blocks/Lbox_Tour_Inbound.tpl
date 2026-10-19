{if $listTourInBound}
<section class="section_box tour__inbound">
	<div class="tour__inbound--header header__content">
		{assign var = TitleTourInbound value = TitleTourInbound_|cat:$_LANG_ID}
		{assign var = IntroTourInbound value = IntroTourInbound_|cat:$_LANG_ID}
		<div class="container">
			<h2 class="section_box-title">{$clsConfiguration->getValue($TitleTourInbound)}</h2>
			<div class="section_box-intro">
				{$clsConfiguration->getValue($IntroTourInbound)|html_entity_decode}
			</div>
		</div>
	</div>
	<div class="tour__inbound--content">
		<div class="container">
			<div class="box_slider_tour">
				<div class="owl_carousel_4_item owl-carousel">
					{section name=i loop=$listTourInBound}
						{assign var=tour_id value=$listTourInBound[i].tour_id}
						{assign var=oneTour value=$listTourInBound[i]}
						{$clsISO->getBlock('box_item_tour_mobile',["tour_id"=>$tour_id,"oneTour"=>$oneTour])}

					{/section}
				</div>
			</div>

		</div>
	</div>
</section>
{/if}