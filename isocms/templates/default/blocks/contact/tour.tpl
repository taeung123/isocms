{if !empty($cartSessionTour)} 
    {assign var=tour_id value=$cartSessionTour.tour_id_z}
    {assign var=title_tour value=$clsTour->getTitle($tour_id)}
    {assign var=departure_date value=$clsISO->getStrToTime($cartSessionTour.check_in_book_z)}
    {assign var=end_date value=$clsTour->getEndDate($departure_date,$tour_id)}
    {assign var=number_adult value=$cartSessionTour.number_adults_z}
    {assign var=number_child value=$cartSessionTour.number_child_z}
    {assign var=number_infant value=$cartSessionTour.number_infants_z}
    {assign var=tour__class value=$cartSessionTour.tour__class}
    <input type="hidden" name="tour_id" value="{$tour_id}"/>
    <input type="hidden" name="departure_date" value="{$departure_date}"/>
    <input type="hidden" name="end_date" value="{$end_date}"/>
    <input type="hidden" name="number_adult" value="{$number_adult}"/>
    <input type="hidden" name="number_child" value="{$number_child}"/>
    <input type="hidden" name="number_infant" value="{$number_infant}"/>
    <input type="hidden" name="tour__class" value="{$tour__class}"/>
    <div class="infor_tour bg_fff relative">
        <a href="javascript:void(0);" data-type="Tour" class="delete_service" key="{$key}" title="{$core->get_Lang('Delete serivce')}"><i class="fa fa-times"></i></a>
        <h3 class="title text_bold mb15 size24 size20_mb"><a
                    href="{$clsTour->getLink($tour_id)}" title="{$title_tour}">{$title_tour}</a>
        </h3>
        <div class="row d-flex">
            <div class="col-md-5 col-sm-5">
                <p class="mb05"><strong>{$core->get_Lang('Departing')}  </strong></p>
                <p class="departure mb0">{$clsTour->getListDeparturePoint($tour_id)}</p>
                <p class="departure_date mb0">{$clsISO->converTimeToText5($departure_date)}</p>
            </div>
            <div class="col-md-1 col-sm-1 icon_arrow">
            </div>
            <div class="col-md-6 col-sm-6">
                <p class="mb05"><strong>{$core->get_Lang('End')} </strong></p>
                <p class="departure mb0">{$clsTour->getEndCityAround($tour_id,1)}</p>
                <p class="departure_date mb0">{$clsISO->converTimeToText5($end_date)}</p>
            </div>
        </div>
        <div class="more_infor">
            <p>
                <strong>{$core->get_Lang('Traveler')}</strong>: {$number_adult} {$core->get_Lang('Adult(s)')} {if $number_child},{$number_child} {$core->get_Lang('Child')}{/if} {if $number_infant},{$number_infant} {$core->get_Lang('Infant')}{/if}
            </p>
            {if $tour__class} <p>
                <strong>{$core->get_Lang('Travel Style')}</strong>
                : {$clsTourOption->getTitle($tour__class)}</p>{/if}
        </div>
    </div>
{/if}