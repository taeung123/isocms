{if $lstHotelTop[0].hotel_id ne ''}
<div class="MR_box">
	<h2 class="hd">{$core->get_Lang('Top hotels')}</h2>
	<div class="box mt20">
		<ul class="MR_Items">
		{section name=i loop=$lstHotelTop}
		{assign var = title value = $clsHotel->getTitle($lstHotelTop[i].hotel_id)}
		{assign var = link value = $clsHotel->getLink($lstHotelTop[i].hotel_id)}
		{assign var = Location value = $clsHotel->getLocation($lstHotelTop[i].hotel_id)}
		<li>
			<a class="photo" href="{$link}" title="{$title}">
				<img src="{$clsHotel->getImage($lstHotelTop[i].hotel_id,393,276)}" alt="{$title}" width="100%" height="auto" />
			</a>
			<div class="rbox">
				<h3 class="title mbn"><a href="{$link}" title="{$title}">{$title}</a></h3>
				<img height="13" src="{$clsHotel->getImageStar($lstHotelTop[i].star_id)}">
				{if $Location ne ''}
				<address><b>{$core->get_Lang('Location')}:</b> {$Location} </address>
				{/if}
			</div>
		</li>
		{/section}
		</ul>
	</div>
</div>
{/if}