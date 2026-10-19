{if $listTopDestination}
<section class="section_box top__destination">
	<div class="top__destination--header header__content">
		{assign var = TitleFavoriteDestination value = TitleFavoriteDestination_|cat:$_LANG_ID}
		{assign var = IntroFavoriteDestination value = IntroFavoriteDestination_|cat:$_LANG_ID}
		<div class="container">
			<h2 class="section_box-title">{$clsConfiguration->getValue($TitleFavoriteDestination)}</h2>
			<div class="section_box-intro">
				{$clsConfiguration->getValue($IntroFavoriteDestination)|html_entity_decode}
			</div>
		</div>
	</div>
	<div class="top__destination--content">
		<div class="container">
			{if $deviceType eq 'phone'}
			<div class="box_slider_top_des">
				<div class="owl_carousel_4_item owl-carousel">
					{section name=i loop=$listTopDestination}
					{assign var=city_top_id value=$listTopDestination[i].city_id}
					{assign var=getTitle_City value=$listTopDestination[i].title}
					{assign var=getLink_City value=$clsCity->getLinkTour($listTopDestination[i].city_id,$listTopDestination[i])}
					<div class="item relative">
						<a class="photo" href="{$getLink_City}" title="{$getTitle_City}">
							<img src="{$clsCity->getImage($listTopDestination[i].city_id,289,165,$listTopDestination[i])}" alt="{$getTitle_City}" class="img100" width="289" height="165" />
						</a>
						<h3 class="title text_bold size22"><a class="color_fff" href="{$getLink_City}" title="{$getTitle_City}">{$getTitle_City}</a></h3>
					</div>
					{/section}
				</div>
			</div>
			{else}
			<div class="row row_flex">
				{assign var=city_top_id value=$listTopDestination[0].city_id}
                {assign var=getTitle_City value=$listTopDestination[0].title}
				{assign var=getLink_City value=$clsCity->getLinkTour($listTopDestination[0].city_id,$listTopDestination[0])}
				<div class="col-xl-3 col-lg-4 item item_highlight mb991_20 mb767_20">
					<div class="item__box relative">
						<a class="photo" href="{$getLink_City}" title="{$getTitle_City}">
							<img src="{$clsConfiguration->getImage('default_image_pixel',1,1)}" data-src="{$clsCity->getImage($listTopDestination[0].city_id,324,360,$listTopDestination[0])}" alt="{$getTitle_City}" class="lazy img100"/>
						</a>
						<h3 class="title text_bold size22"><a class="color_fff" href="{$getLink_City}" title="{$getTitle_City}">{$getTitle_City}</a></h3>
					</div>
				</div>
				<div class="col-xl-9 col-lg-8 list_item">
					<div class="row">
						{section name=i loop=$listTopDestination start="1"}
							{assign var=city_top_id value=$listTopDestination[i].city_id}
							{assign var=getTitle_City value=$listTopDestination[i].title}
							{assign var=getLink_City value=$clsCity->getLinkTour($listTopDestination[i].city_id,$listTopDestination[i])}
							<div class="col-lg-4 col-md-6 col-sm-6 item mb991_20 mb767_20">
								<div class="item__box relative">
									<a class="photo" href="{$getLink_City}" title="{$getTitle_City}">
										<img src="{$clsConfiguration->getImage('default_image_pixel',3,2)}" data-src="{$clsCity->getImage($listTopDestination[i].city_id,289,165,$listTopDestination[i])}" alt="{$getTitle_City}" class="lazy img100"/>
									</a>
									<h3 class="title text_bold size22"><a class="color_fff" href="{$getLink_City}" title="{$getTitle_City}">{$getTitle_City}</a></h3>
								</div>
							</div>
						{/section}
					</div>
				</div>
			</div>
			{/if}
		</div>
	</div>
</section>
{/if}
