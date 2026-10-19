{if $listTopTour}
<section class="section_box attractive_tour">
	<div class="container">
		<div class="attractive_tour--header header__content">
			{assign var = TitleAttractiveTour value = TitleAttractiveTour_|cat:$_LANG_ID}
			{assign var = IntroAttractiveTour value = IntroAttractiveTour_|cat:$_LANG_ID}
			<h2 class="section_box-title text-left">{$clsConfiguration->getValue($TitleAttractiveTour)}</h2>
			<div class="section_box-intro text-left">
				{$clsConfiguration->getValue($IntroAttractiveTour)|html_entity_decode}
			</div>
		</div>
		<div class="attractive_tour--content">
			<div class="row list_tours">
				{section name=i loop=$listTopTour}
					{assign var=tour_id value=$listTopTour[i].tour_id}
					{$clsISO->getBlock('box_item_tourpro',["tour_id"=>$tour_id])}
				{/section}
			</div>
			{if $totalRecord gt $recordPerPage}
				<div class="view_more">
					<a href="javascript:void(0);" page="1" rel="nofollow" _type="TopTrip" class="show-loader btn_view_more" id="show-more-top-tour" title="{$core->get_Lang('View more')}">{$core->get_Lang('View more')}</a>
				</div>
			{/if}
		</div>
	</div>
	<script>
		var totalRecord='{$totalRecord}';
		var $pageLastest = 1;
		var $_LANG_ID = '{$_LANG_ID}';
		var width = $(window).width();
	</script>
</section>
{/if}