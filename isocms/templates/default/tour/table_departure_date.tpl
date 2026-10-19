{section name=i loop=$lstTourStartDate}
<tr class="tr_departure_item">
	<td align="left">
	<span class="block">{$clsISO->getDayOfWeek($lstTourStartDate[i].start_date)}</span>
	<span class="block text_bold">{$clsISO->converTimeToTextShort($lstTourStartDate[i].start_date)}</span>
	<span class="block color_333">{$core->get_Lang('from')} {$clsTour->getDepartureCityFrom($tour_id)}</span>
	</td>
	<td align="left" class="hidden991">
	<span class="block">{$clsISO->getDayOfWeek($clsTour->getEndDate($lstTourStartDate[i].start_date,$tour_id))}</span>
	<span class="block text_bold">{$clsISO->converTimeToTextShort($clsTour->getEndDate($lstTourStartDate[i].start_date,$tour_id))}</span>
	<span class="block color_333">{$core->get_Lang('in')} {$clsTour->getDepartureCityEnd($tour_id)}</span>
	</td>
	<td align="center">{$clsTour->getNumberDayDuration($tour_id)}</td>	
	<td align="center">
		{$clsTourPriceGroup->getTripMinPriceTourGroupDate($tour_id,$adult_type_id,$lstTourStartDate[i].start_date)}
	</td>
	<td align="center" class="hidden767">
	<a class="view_detail color_main text_upper block mb10" data-toggle="modal" data-target="#formPriceGroup_{$lstTourStartDate[i].tour_start_date_id}" title="{$core->get_Lang('View price')}">{$core->get_Lang('View price')}</a>
	<a class="btn_booking color_main text_upper block" href="{$clsTour->getLinkBookDeparture($tour_id,$lstTourStartDate[i].start_date)}" title="{$core->get_Lang('Book now')}" start_date="{$lstTourStartDate[i].start_date}" LANG_ID="{$_LANG_ID}">{$core->get_Lang('Book now')}</a>
	</td>
</tr>
<tr align="center" class="table_row_767" style="display:none">
<td class="btn_booking" colspan="5"><a class="btn_booking color_main text_upper full-width" href="{$clsTour->getLinkBookDeparture($tour_id,$lstTourStartDate[i].start_date)}" title="{$core->get_Lang('Book now')}" LANG_ID="{$_LANG_ID}">{$core->get_Lang('Book now')}</a></td>
</tr>
<tr class="hr table_row_767" style="display:none"><td colspan="5"></td></tr>
<tr>
<td class="priceGroup" colspan="5">
<div class="modal fade in" id="formPriceGroup_{$lstTourStartDate[i].tour_start_date_id}" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content content_enquire">
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="closex" aria-hidden="true">×</span></button>
				<h3 class="modal-title">{$core->get_Lang('Price Departure')}</h3>
			</div>
			<div class="modal-body">
				{$clsTour->getTourPriceGroup($tour_id,$lstTourStartDate[i].start_date)}
			</div>
		</div>
	</div>
</div>
</td>
</tr>
{/section}
