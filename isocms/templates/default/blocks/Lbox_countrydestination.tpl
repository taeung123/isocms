{if $listCountryDestination}
<section class="home_box section_box top__destination">
	{assign var = TitleFavoriteDestination value = TitleFavoriteDestination_|cat:$_LANG_ID}
	{assign var = IntroFavoriteDestination value = IntroFavoriteDestination_|cat:$_LANG_ID}
	<div class="container">
		<div class="title text_center mb30">
			<h2 class="section_box-title">{$clsConfiguration->getValue($TitleFavoriteDestination)}</h2>
			<div class="intro_box">{$clsConfiguration->getValue($IntroFavoriteDestination)|html_entity_decode}</div>
		</div>
	</div>
	<div class="slide_list_country">
		<div class="container">
			<div class="jcarousel-box owl-carousel" id="listCountryDes">
				{section name=i loop=$listCountryDestination}
				{assign var=getTitle_Country value=$clsCountryEx->getTitle($listCountryDestination[i].country_id,$listCountryDestination[i])}
				{assign var=getLink_Country value=$clsCountryEx->getLink($listCountryDestination[i].country_id,'',$listCountryDestination[i])}
				{assign var=getIntro_Country value=$clsCountryEx->getIntro($listCountryDestination[i].country_id,'',false,$listCountryDestination[i])}
				<div class="countryItem">	
					<div class="box_img">
						<a class="photo" href="{$getLink_Country}" title="{$getTitle_Country}">
							<img class="owl-lazy img100" src="{$clsConfiguration->getImage('default_image_pixel',263,175)}" data-src="{$clsCountryEx->getImage($listCountryDestination[i].country_id,263,175,$listCountryDestination[i])}" width="263" height="175" alt="{$getTitle_Country}"/>
						</a>
					</div>					
					<div class="body">
						<h3 class="title_h3"><a href="{$getLink_Country}" title="{$getTitle_Country}">{$getTitle_Country}</a></h3>
						<div class="intro limit_2line">{$getIntro_Country|html_entity_decode|strip_tags|truncate:100}</div>
						<div class="bottom">
							{assign var=totalPlace value=$clsCountryEx->countNumberPlaceToGo($listCountryDestination[i].country_id)}
							{assign var=totalTour value=$clsCountryEx->countNumberTour($listCountryDestination[i].country_id)}
							{assign var=totalHotel value=$clsCountryEx->countNumberHotel($listCountryDestination[i].country_id)}
							{if $totalPlace || $totalTour}
							<p class="icon_place">
							{$totalPlace} {$core->get_Lang('Places')} <span class="color_999">&middot;</span> {$totalTour} {$core->get_Lang('Tours')}
							</p>
							{/if}
							{if $totalHotel}
							<p class="icon_hotel">
							{$totalHotel} {$core->get_Lang('Hotels')}
							</p>
							{/if}
						</div>
					</div>
				</div>
				{/section}
			</div>
		</div>
	</div>
</section>
{/if}
