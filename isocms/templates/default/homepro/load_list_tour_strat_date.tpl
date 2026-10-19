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
<tr>
	<td style="width: 568px"><p class="limit_1line mb0">{$clsTour->getTitle($tour_id)}</p></td>
	<td style="width: 140px">{$clsTour->getTripDuration2020($tour_id)}</td>
	<td style="width: 150px">{$clsTourStartDate->getStartDateTour($tour_start_date_id)}</td>
	{if $checkTourLast ne '' && @count|$countAvailable ne '0'}
	<td style="width: 100px" class="available">{$clsTourStartDate->getSeatAvailable($tour_start_date_id)} {$core->get_Lang('chỗ')}</td>
	{else}
	<td style="width: 100px" class="available">{$core->get_Lang('Còn chỗ')}</td>
	{/if}
	<td style="width: 320px" class="price"><div class="p_price"> {if $promotion ne ''}
		<p class="size18 color_fb1111 text-bold mb0"> <del class="size16 color_1c1c1c fw_400">{$clsISO->formatPrice($clsTourStartDate->getTripPriceTourStartDateValue($tour_id,$start_date))} {$clsISO->getShortRate()}</del> <span>{$clsTourStartDate->getTripPriceOnePromotionStartDate($tour_start_date_id,$tour_id,$start_date)} {$clsISO->getShortRate()}</span></p>
		{elseif no_promotion ne '0'}
		<p class="size18 color_fb1111 text-bold mb0">{$clsISO->formatPrice($clsTourStartDate->getTripPriceTourStartDateValue($tour_id,$start_date))} {$clsISO->getShortRate()}</p>
		{else}
		<p class="size18 color_fb1111 text-bold mb0">{$core->get_Lang('Contact')}</p>
		{/if} </div>
	<a class="detail_tour btn_main" href="{$clsTourStartDate->getLink($tour_start_date_id,$tour_id)}" title="{$core->get_Lang('Detail')}"> {$core->get_Lang('Detail')} </a></td>
</tr>
{/if}
{/section}