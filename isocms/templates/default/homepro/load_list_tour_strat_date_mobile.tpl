<div class="accordion" id="accordionStartDate">
{section name=i loop=$lstTourStartDate}
{assign var=tour_start_date_id value=$lstTourStartDate[i].tour_start_date_id}
{assign var=tour_id value=$lstTourStartDate[i].tour_id}
{assign var=start_date value=$clsTourStartDate->getStartDate($tour_start_date_id)}
{assign var=checkmem value=$clsTour->getCheckMemSet($tour_id)}
{assign var=checkTourLast value=$clsTour->checkTourLastHour2($tour_id,$now_day)}
{assign var=countAvailable value=$clsTourStartDate->getSeatAvailable($tour_start_date_id)}
{assign var=promotion value=$clsTourStartDate->getTripPriceOnePromotionStartDate($tour_start_date_id,$tour_id,$start_date)}
{assign var=no_promotion value=$clsTourStartDate->getTripPriceTourStartDateValue($tour_id,$start_date)}
{if @count|$countAvailable ne '0'}
<div class="card">
	<div class="card-header" id="start_date_{$smarty.section.i.iteration}">
		<h3 class="title"> <a class="collapsed" data-toggle="collapse" data-target="#collapsestart_date_{$smarty.section.i.iteration}" aria-expanded="false" aria-controls="collapsestart_date_{$smarty.section.i.iteration}"> {$clsTour->getTitle($tour_id)} </a> </h3>
	</div>
	<div id="collapsestart_date_{$smarty.section.i.iteration}" class="collapse" aria-labelledby="start_date_{$smarty.section.i.iteration}" data-parent="#accordionStartDate">
		<div class="card-body">
			<p class="journeys"><span class="left">{$core->get_Lang('Journeys')}</span> <span class="right">{$clsTour->getTripDuration2020($tour_id)}</span></p>
			<p class="day"><span class="left">{$core->get_Lang('Departure day')}</span> <span class="right">{$clsTourStartDate->getStartDateTour($tour_start_date_id)}</span></p>
			{if $checkTourLast ne '' && @count|$countAvailable ne '0'}
			<p class="blank"><span class="left">{$core->get_Lang('Blank')}</span> <span class="right">{$clsTourStartDate->getSeatAvailable($tour_start_date_id)} {$core->get_Lang('chỗ')}</span></p>
			{else}
			  <p class="blank"><span class="left">{$core->get_Lang('Blank')}</span> <span class="right">{$core->get_Lang('Còn chỗ')}</span></p>
			{/if}
			<div class="tour_price"><span class="left">{$core->get_Lang('Tour Price')}</span>
				<div class="right"> {if $promotion ne ''}
					<p class="size18 color_fb1111 text-bold mb0"> <del class="size16 color_1c1c1c fw_400">{$clsISO->formatPrice($clsTourStartDate->getTripPriceTourStartDateValue($tour_id,$start_date))} {$clsISO->getShortRate()}</del> <span>{$clsTourStartDate->getTripPriceOnePromotionStartDate($tour_start_date_id,$tour_id,$start_date)} {$clsISO->getShortRate()}</span></p>
					{elseif no_promotion ne '0'}
					<p class="size18 color_fb1111 text-bold mb0">{$clsISO->formatPrice($clsTourStartDate->getTripPriceTourStartDateValue($tour_id,$start_date))} {$clsISO->getShortRate()}</p>
					{else}
					<p class="size18 color_fb1111 text-bold mb0">{$core->get_Lang('Contact')}</p>
					{/if} </div>
			</div>
			<p class="view_tour"> <a class="detail_tour btn_main" href="{$clsTourStartDate->getLink($tour_start_date_id,$tour_id)}" title="{$core->get_Lang('Detail')}"> {$core->get_Lang('Detail')} </a> </p>
		</div>
	</div>
</div>
{/if}
{/section}
</div>