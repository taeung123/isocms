{if $lstCruiseViewed}
<section class="box__cruise_reviewed">
	<div class="header_special"> 
		<div class="box__center">
			<h2>{$core->get_Lang('Recent viewed cruises')}</h2>   
		</div>
	</div>
	<div class="cruise_reviewed mt30">
		<div class="owl-carousel owl-theme owl_slide_cruise_viewed mt30">
			{section name=i loop=$lstCruiseViewed}
			{assign var=oneItemCruiseViewed value=$clsCruise->getOne($lstCruiseViewed[i],'slug,title,image,star_number')}
			{assign var=_link value = $clsCruise->getLink($lstCruiseViewed[i],$oneItemCruiseViewed)}
			{assign var=_title value = $oneItemCruiseViewed.title} 
			{if $clsCruise->checkExist($lstCruiseViewed[i])}
			<div class="cruise_viewed_item">
				<a href="{$_link}" class="photo color_333" title="{$_title}">
					<img class="full-width heightAuto" src="{$clsCruise->getImage($lstCruiseViewed[i],120,80,$oneItemCruiseViewed)}" alt="{$_title}"/>
				</a>
				<div class="body">
					<h3 class="title mt0 mb05">
						<a href="{$_link}" class="color_333" title="{$_title}">{$_title}</a>
						{$clsCruise->getStarNew($lstCruiseViewed[i],$oneItemCruiseViewed)}
					</h3>
					<div class="price__box">
						{$clsCruise->getLTripPrice($lstCruiseViewed[i],$now_month,'list')}
					</div>
				</div>
			</div>
			{/if}
			{/section} 
		</div>
	</div>
</section><!--end box__cruise_reviewed-->
{/if}