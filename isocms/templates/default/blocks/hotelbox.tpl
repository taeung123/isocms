{assign var = link value = $clsHotel->getLink($hotel_id,$arrHotel)}
{assign var = title value = $clsHotel->getTitle($hotel_id,$arrHotel)}
{assign var = getImageStar value = $clsHotel->getHotelStar($hotel_id,$arrHotel)}
<div class="cityHotel hotelItem">
	<div class="post-thumb">
		<a class="photo" href="{$link}" title="{$title}">
			<img class="img-responsive img100" src="{$clsHotel->getImage($hotel_id,552,368,$arrHotel)}" alt="{$title}" />
		</a>
		<div class="figure">
			<a href="{$link}" class="cityHotel viewdetail btn_main">{$core->get_Lang('View Detail')}</a>
			<p class="price">
				<span>{$core->get_Lang('From')}: </span> 
				<span class="price-Inc">{$clsHotel->getPriceOnPromotion($hotel_id)}</span>
			</p>
		</div>
	</div>
	<div class="body">
		<h3 class="title"><a href="{$link}" title="{$title}">{$title}</a> {$clsHotel->getStarNew($hotel_id,$arrHotel)}{*{if $getImageStar != null}<img class="star" height="13" src="{$getImageStar}" alt="star" style="width: auto" />{/if}*}</h3>
		<p class="address"><i class="fa fa-map-marker"></i> {$clsHotel->getAddress($hotel_id,$arrHotel)}</p>
		<p class="text" style="display:none">{$clsHotel->getIntro($hotel_id,$arrHotel)|strip_tags|truncate:80}</p>
	</div>
</div>