{section name=i loop=$listHotelPlace}
{assign var = link value = $clsHotel->getLink($listHotelPlace[i].hotel_id)}
{assign var = title value = $clsHotel->getTitle($listHotelPlace[i].hotel_id)}
<article class="box col-xs-6 col-sm-4 col-md-4">
	<div class="cityHotel hotelItem">
		<div class="post-thumb">
			<a class="photo" href="{$link}" title="{$title}">
				<img class="img-responsive img100" src="{$clsHotel->getImage($listHotelPlace[i].hotel_id,552,368)}" alt="{$title}"/>
			</a>
			<span style="cursor:pointer" class="{if $profile_id eq ''}exitLogin{else}addWishlist{/if} heart-o inline-block text-center btnwl" title="{$core->get_Lang('Saved to wishlist')}" data-clsTable="Hotel" data-data="{$listHotelPlace[i].hotel_id}" id="addwishlistHotel{$listHotelPlace[i].hotel_id}">{$clsHotel->getOneField('wishlist_num',$listHotelPlace[i].hotel_id)}</span>
			<div class="figure">
				<a href="{$link}" class="cityHotel viewdetail">{$core->get_Lang('View Detail')}</a>
				<p class="price">{$core->get_Lang('From')}: <span class="price-Inc">{$clsHotel->getPrice($listHotelPlace[i].hotel_id)}</span></p>
			</div>
		</div>
		<div class="body">
			<h3 class="title"><a href="{$link}" title="{$title}">{$title}</a> <img class="star" height="13" src="{$clsHotel->getImageStar($listHotelPlace[i].star_id)}" alt="star" /></h3>
			<p class="address"><i class="fa fa-map-marker"></i> {$clsHotel->getAddress($listHotelPlace[i].hotel_id)}</p>
			<p class="text" style="display:none">{$clsHotel->getIntro($listHotelPlace[i].hotel_id)|strip_tags|truncate:80}</p>
		</div>
	</div>
</article>
{/section}