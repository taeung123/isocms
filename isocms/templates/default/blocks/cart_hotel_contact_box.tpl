{if $cartSessionHotel}
{assign var=title_hotel value=$clsHotel->getTitle($cartSessionHotel.hotel_id)}
{assign var=link_hotel value=$clsHotel->getLink($cartSessionHotel.hotel_id)}
<div class="infor_tour bg_fff relative">
    <a href="javascript:void(0);" class="delete_service" data-type="Hotel" key="{$k}" title="{$core->get_Lang('Delete serivce')}"><i class="fa fa-times"></i></a>
    <h3 class="title text_bold mb15 size24 size20_mb">{$title_hotel} </h3>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <p class="departure_in4"><b>{$core->get_Lang('Check In')}  </b></p>
            <p class="departure">{$clsISO->converTimeToText5($cartSessionHotel.check_in)}</p>
        </div>
        <div class="col-md-6 col-sm-6">
             <p> <b>{$core->get_Lang('Check Out')} </b> </p>
             <p class="departure">{$clsISO->converTimeToText5($cartSessionHotel.check_out)}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <p class="departure_in4"><b>{$core->get_Lang('Traveler')}  </b></p>
            <p class="departure">{$cartSessionHotel.number_adult} {$core->get_Lang('Adult(s)')} {if $cartSessionHotel.number_child},{$cartSessionHotel.number_child} {$core->get_Lang('Child')}{/if} </p>
        </div>
    </div>
    <table class="table_booking_price">
        <tbody>
            {foreach from=$cartSessionHotel.room key=hotel_room_id item=value name=room}
            <p class="text_bold">{$value.number_room} {$core->get_Lang('rooms')}: {$clsHotelRoom->getTitle($hotel_room_id)}</p>
            {/foreach}
        </tbody>
    </table>
</div>
{/if}