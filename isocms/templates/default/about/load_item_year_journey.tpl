{section name=i loop=$listYearJourney}
{assign var=year_journey_id value=$listYearJourney[i].year_journey_id}
	<div class="item item_{$smarty.section.i.iteration}">
		{*<span class="icon"><img class="img100 lazy height-auto" src="{$URL_IMAGES}/pixel.png" data-src="{$clsYearJourney->getImageUrl($year_journey_id)}" alt="{$clsYearJourney->getTitle($year_journey_id)}" /></span>*}
		<div class="body">
			<p class="number_year">{$clsYearJourney->getTitle($year_journey_id)}</p>
			{if $clsYearJourney->getIntro($year_journey_id) ne ''}
				<div class="intro">{$clsYearJourney->getIntro($year_journey_id)|strip_tags}
					<span class="angle"><i class="fa fa-caret-right" aria-hidden="true"></i></span>
				</div>
			{/if}
		</div>
	</div>
{/section}