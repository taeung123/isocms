{section name=i loop=$listHotelPlace}
{assign var = hotel_id value = $listHotelPlace[i].hotel_id}
<div class="box col-sm-6 col-md-4 col-lg-3">
	{$clsISO->getBlock('hotelbox',["hotel_id"=>$hotel_id])}
</div>
{/section}