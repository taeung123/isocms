{section name=i loop=$listHotelPlace}
{assign var = hotel_id value = $listHotelPlace[i].hotel_id}
 <article class="box col-xs-6 col-sm-4 col-md-4">
{$clsISO->getBlock('hotelbox',["hotel_id"=>$hotel_id])}
</article>
{/section}