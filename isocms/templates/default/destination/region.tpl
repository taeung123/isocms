<div class="page_container">
	<div class="banner">
		<a href="{$clsRegion->getBannerUrl($region_id)}" title="{$core->get_Lang('Destinations in')} {$TD}">
		<img src="{$clsRegion->getBanner($region_id,1920,500)}" width="100%" height="auto" alt="{$core->get_Lang('Destinations in')} {$TD}"/>
		</a>
	</div>
	<nav class="breadcrumb-main breadcrumb-{$mod} bg_f1f3f3">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_f1f3f3" itemscope itemtype="http://schema.org/BreadcrumbList">
			   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
			   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Destinations')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$clsCountryEx->getLink($country_id)}" title="{$clsCountryEx->getTitle($country_id)}">
					   <span itemprop="name" class="reb">{$clsCountryEx->getTitle($country_id)}</span></a>
					<meta itemprop="position" content="3" />
				</li>
			   <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				  <a itemscope itemtype="http://schema.org/Thing" itemprop="item" title="{$TD}" href="{$curl}">
					<span itemprop="name" class="reb">{$TD}</span>
				  </a>
				   <meta itemprop="position" content="4" />
			   </li>
			</ol>
		</div>
	</nav>
	<div id="contentPage" class="PageDestination pd40_0">
		<div class="container">
			<div class="row">
				<div class="col-md-9 outerHeight">
					<div id="overview_des" class="overview mb40">
						<h3 class="size18 mb20 color_333"> {$core->get_Lang('Overview')} </h3>
						<h2 class="size24 mb20 color_333">{$TD} {$core->get_Lang('Adventure Holidays')}</h2>
						<div class="overview">
							<div class="intro16 mb15">{$ID}</div>
							<div class="intro16">{$CD}</div> 
						</div>
					</div>
					{if $listPlaceToGoByRegion}
					<div id="guide_des_{$place_to_go_id}" class="placesToGo_des placesToGo mb40">
						<h2 class="title__guilde">
							<a href="{$clsGuideCat->getLinkRegion($country_id,$region_id,$place_to_go_id)}">{$core->get_Lang('Places to go')}</a>
						</h2>
						{assign var=total_place value= $listPlaceToGoByRegion|@count}
						<div class="owl-carousel owl-theme slider_PlaceToGo_box {if $total_place lt 3 }max__width_place{/if}">
							{section name=i loop=$listPlaceToGoByRegion}
							<article class="placeItem">
								<div class="photo">
									<a href="{$clsGuide->getLink($listPlaceToGoByRegion[i].guide_id)}" title="{$clsGuide->getTitle($listPlaceToGoByRegion[i].guide_id)}">
									<img src="{$clsGuide->getImage($listPlaceToGoByRegion[i].guide_id,270,210)}" width="100%" height="auto" alt="{$clsGuide->getTitle($listPlaceToGoByRegion[i].guide_id)}"/>
									</a>
									{assign var=city_id value=$clsGuide->getOneField(city_id,$listPlaceToGoByRegion[i].guide_id)}
									{assign var=country_id value=$clsGuide->getOneField(country_id,$listPlaceToGoByRegion[i].guide_id)}
									<div class="figure"><i class="fa fa-map-marker"></i>
										{if $city_id gt '0'}<a href="{$clsCity->getLink($city_id)}" title="{$clsCity->getTitle($city_id)}">{$clsCity->getTitle($city_id)}</a>,{/if} <a href="{$clsCountryEx->getLink($country_id)}" title="{$clsCountryEx->getTitle($country_id)}">{$clsCountryEx->getTitle($country_id)}</a>
									</div>
								</div>
								<div class="body">
									<h3 class="title mb10"><span class="index">{$smarty.section.i.iteration}</span> <a class="size15 text-bold" href="{$clsGuide->getLink($listPlaceToGoByRegion[i].guide_id)}" title="{$clsGuide->getTitle($listPlaceToGoByRegion[i].guide_id)}">{$clsGuide->getTitle($listPlaceToGoByRegion[i].guide_id)}</a></h3>
									<div class="intro text_justify">{$clsGuide->getIntro($listPlaceToGoByRegion[i].guide_id)|strip_tags|truncate:100}</div>
								</div>
							</article>
							{/section}
						</div>
					</div>
					{/if}
					{if $listHotelPlace}
					<div id="hotel_des" class="placesToGo mb40">
						<h2 class="title__guilde">
							<a href="{$clsRegion->getLink($country_id,$region_id,'Hotel')}">{$core->get_Lang('Hotel in')} {$TD}</a>
						</h2>
						{assign var=total_place value= $listHotelPlace|@count}
						<div class="owl-carousel owl-theme slider_PlaceToGo_box {if $total_place lt 3 }max__width_place{/if}">
							{section name=i loop=$listHotelPlace}
							<article class="placeItem">
								<div class="photo">
									<a href="{$clsHotel->getLink($listHotelPlace[i].hotel_id)}" title="{$clsHotel->getTitle($listHotelPlace[i].hotel_id)}">
									<img src="{$clsHotel->getImage($listHotelPlace[i].hotel_id,270,210)}" class="img100" alt="{$clsHotel->getTitle($listHotelPlace[i].hotel_id)}"/>
									</a>
									{assign var=city_id value=$clsHotel->getOneField(city_id,$listHotelPlace[i].hotel_id)}
									{assign var=country_id value=$clsHotel->getOneField(country_id,$listHotelPlace[i].hotel_id)}
									<div class="figure"><i class="fa fa-map-marker"></i>
										{if $city_id gt '0'}<a href="{$clsCity->getLink($city_id)}" title="{$clsCity->getTitle($city_id)}">{$clsCity->getTitle($city_id)}</a>,{/if} <a href="{$clsCountryEx->getLink($country_id)}" title="{$clsCountryEx->getTitle($country_id)}">{$clsCountryEx->getTitle($country_id)}</a>
									</div>
								</div>
								<div class="body">
									<h3 class="title mb10"><span class="index">{$smarty.section.i.iteration}</span> <a class="size15 text-bold" href="{$clsHotel->getLink($listHotelPlace[i].hotel_id)}" title="{$clsHotel->getTitle($listHotelPlace[i].hotel_id)}">{$clsHotel->getTitle($listHotelPlace[i].hotel_id)}</a></h3>
									<div class="intro text_justify">{$clsHotel->getIntro($listHotelPlace[i].hotel_id)|strip_tags|truncate:100}</div>
								</div>
							</article>
							{/section}
						</div>
					</div>
					{/if}
					{if $listTour}
					<div id="countryTrip_des" class="countryTrip">
						<h2 class="title__guilde">{$core->get_Lang('Our')} {$TD} {$core->get_Lang('trips')}</h2>
						<table class="listTourCountry full-width {$clsISO->getBrowser()}" id="home-masonry-container" style="min-width:847px;border-collapse: collapse;" >
							<tbody>
								<tr style="border-bottom:1px solid #999">
									{if _IS_DEPARTURE eq '1'}
									<th class="width16">{$core->get_Lang('Departing')}</th>
									{/if}
									<th>{$core->get_Lang('Trip name')}</th>
									<th class="width13"></th>
									<th class="width10 text_center">{$core->get_Lang('Days')}</th>
									<th class="width14 text_left">{$core->get_Lang('From')} {$clsISO->getRate()}</th>
									<th class="width16"></th>
								</tr>
								{assign var=totalTour value=$listTour|@count}
								{section name=i loop=$listTour}
								<tr class="bg_f4f4f4 box" {if $smarty.section.i.iteration gt '5'} style="display:none"{/if}>
									{if _IS_DEPARTURE eq '1'}
									<td><span class="title16">{$clsISO->converTimeToText($now_next)}</span></td>
									{/if}
									<td><a class="title16 text-bold" href="{$clsTour->getLink($listTour[i].tour_id)}" title="{$clsTour->getTitle($listTour[i].tour_id)}">{$clsTour->getTitle($listTour[i].tour_id)}</a>
									<span class="block">{$clsTour->getDepartureFrom($listTour[i].tour_id,0)} {$core->get_Lang('to')} {$clsTour->getDepartureEnd($listTour[i].tour_id,0)}</span>
									</td>
									<td class="text_center"><a class="photo inline-block full-width" href="{$clsTour->getLink($listTour[i].tour_id)}" title="{$clsTour->getTitle($listTour[i].tour_id)}"><img class="lazy border_radius_full" data-src="{$clsTour->getImage($listTour[i].tour_id,80,80)}" width="80" height="80" alt="{$clsTour->getTitle($listTour[i].tour_id)}" /></a></td>
									<td class="text_center"><span class="title16">{$clsTour->getNumberDayDuration($listTour[i].tour_id)}</span></td>
									<td>
									{assign var=getTripPrice value= $clsTour->getTripPrice($listTour[i].tour_id,$now_day,$is_agent,'value')}
									{if $getTripPrice gt '0'}
									{if $_LANG_ID eq 'vn'}
									<strong class="color_main size24">{$getTripPrice}{$clsISO->getShortRate()}</strong>
									{else}
									<strong class="color_main size24">{$clsISO->getShortRate()}{$getTripPrice}</strong>
									{/if}
									{else}
									<a class="contactLink color_main size16" href="{$clsTour->getLinkCustomize($listTour[i].tour_id)}" target="_blank" title="{$core->get_Lang('Contact us')}">{$core->get_Lang('Contact us')}</a>
									{/if}
									</td>
									<td><a class="viewTrip bg_main color_fff" href="{$clsTour->getLink($listTour[i].tour_id)}" title="{$clsTour->getTitle($listTour[i].tour_id)}">{$core->get_Lang('View Trip')} <i class="fa fa-angle-right" aria-hidden="true"></i></a></td>
								</tr>
								{/section}
								{if $totalTour gt '5'}
								<tr>
									<td colspan="6" class="text_center">
									<div class="cleafix"></div>
									<div id="exploreWorldLoadMore">
									  <div id="load_more_collections">
										<div class="loader"></div>
										<a href="javascript:void(0);" rel="nofollow" page="1" class="viewTrip bg_main color_fff " style="border-radius:15px" id="show-more">{$core->get_Lang('LOAD MORE COLLECTIONS')}</a></div>
									</div>  
									</td>
								</tr>
								{/if}
							</tbody>
						</table>
					</div>
					{/if}
					<div class="boxGuideCat mt40">
						{section name=i loop=$listGuideCat}
						{assign var=guidecat_id value=$listGuideCat[i].guidecat_id}
						{if $guidecat_id ne $place_to_go_id}
						{assign var=listItemGuideCat value=$clsGuide->getListGuidePlace($region_id,$guidecat_id,$show)}
						{if $listItemGuideCat}
						<div id="guide_des_{$guidecat_id}" class="GuideCatBox mt40">
							<h2 class="title__guilde">
								<a href="{$clsGuideCat->getLinkRegion($country_id,$region_id,$guidecat_id)}" title="{$clsGuideCat->getTitle($guidecat_id)}">
									{$clsGuideCat->getTitle($guidecat_id)}
								</a>
							</h2>
							{assign var=contentGuideCat value=$clsGuide->getContent($place_id,$guidecat_id,300,$show)}
							{if $contentGuideCat}
							<div class="intro16 mb30">{$clsGuide->getContent($place_id,$guidecat_id,300,$show)}</div>
							{/if}
							<div class="listGuideCat">
								<div class="row">
									<div class="col-sm-6">
										<a class="photo" href="{$clsGuide->getLink($listItemGuideCat[0].guide_id)}" title="{$clsGuide->getTitle($listItemGuideCat[0].guide_id)}">
											<img class="lazy img100" data-src="{$clsGuide->getImage($listItemGuideCat[0].guide_id,728,485)}" alt="{$clsGuide->getTitle($listItemGuideCat[0].guide_id)}"  />
										</a>
									</div>
									<div class="col-sm-6">
										{section name=j loop=$listItemGuideCat max=2}
										{assign var=title_guide_item_cat value=$clsGuide->getTitle($listItemGuideCat[j].guide_id)}
										{assign var=link_guide_item_cat value=$clsGuide->getLink($listItemGuideCat[j].guide_id)}
										<div class="GuideItem mb30">
											<h3 class="size18 text-bold mb10"><a href="{$link_guide_item_cat}" title="{$title_guide_item_cat}">{$title_guide_item_cat}</a></h3>
											<div class="intro text_justify">{$clsGuide->getIntro($listItemGuideCat[j].guide_id)|strip_tags|truncate:200}</div>
											<a class="viewMore color_main " href="{$link_guide_item_cat}" title="{$title_guide_item_cat}">{$core->get_Lang('More')}</a>  
										</div>
										{/section}
									</div>
								</div>
							</div>
						</div>
						{/if}
						{/if}
						{/section}		
					</div>
					{if $listBlogPlace}
					<div id="blog_des" class="countryBlog mt40">
						<h2 class="title__guilde">
							<a href="{$clsRegion->getLink($country_id,$region_id,'Blog')}" title="{$core->get_Lang('Blogs')}">
							{$core->get_Lang('Blogs')}
							 </a>
						</h2>
						<div class="intro16 mb30">{$clsCountryEx->getIntro($country_id,'Blog')}</div>
						<div class="listBlog">
							{section name=i loop=$listBlogPlace max=3}
							<article class="blogItem mb30">
								<a href="{$clsBlog->getLink($listBlogPlace[i].blog_id)}" title="{$clsBlog->getTitle($listBlogPlace[i].blog_id)}" class="photo">
								<img class="lazy img100" data-src="{$clsBlog->getImage($listBlogPlace[i].blog_id,453,346)}" alt="{$clsBlog->getTitle($listBlogPlace[i].blog_id)}" />
								</a>
								<div class="body">
									<h3 class="mb10 size18">
										<a class="block size18 text-bold" href="{$clsBlog->getLink($listBlogPlace[i].blog_id)}" title="{$clsBlog->getTitle($listBlogPlace[i].blog_id)}">
											{$clsBlog->getTitle($listBlogPlace[i].blog_id)}
										</a>
									</h3>
									<p class="clock"><i class="fa fa-clock-o" aria-hidden="true"></i> {$clsISO->converTimeToText($clsBlog->getOneField('reg_date',$listBlogPlace[i].blog_id))}</p>
									<div class="intro16 text_justify">{$clsBlog->getIntro($listBlogPlace[i].blog_id)|strip_tags|truncate:320}</div>
								</div>
							</article>
							{/section}
						</div>
					</div>
					{/if}
				</div>
				<div class="col-md-3">
					<div class="rightDestination sb__destinations">
						{if $listGuideCat or $listHotelPlace or $listBlogPlace}
						<h3 class="title20 mb10">{$TD}</h3>
						<ul>
							{if $listHotelPlace}
							{if $show eq 'City'}
							<li ><a class="anchor-link {if $mod eq 'hotel' && $act eq 'place'}active{/if}" href="#hotel_des">{$core->get_Lang('Hotels')}</a></li>
							{else}
							<li ><a class="anchor-link {if $mod eq 'hotel' && $act eq 'place'}active{/if}" href="#hotel_des" title="{$core->get_Lang('Hotels')}">{$core->get_Lang('Hotels')}</a></li>
							{/if}
							{/if}
							{section name=i loop=$listGuideCat}
							{assign var=guidecat_id value=$listGuideCat[i].guidecat_id}
							{assign var=listItemGuideCat value=$clsGuide->getListGuidePlace($place_id,$guidecat_id,$show)}
							{if $listItemGuideCat}
							<li {if $guidecat_id eq $listGuideCat[i].guidecat_id}class="active"{/if}>
								<a class="anchor-link"  href="#guide_des_{$listGuideCat[i].guidecat_id}" title="{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}">{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}
								</a>
							</li>
							{/if}
							{/section}
							{if $listBlogPlace}
							<li ><a class="anchor-link" href="#blog_des" title="{$core->get_Lang('Blogs')}">{$core->get_Lang('Blogs')}</a></li>
							{/if}
						</ul>
						{/if}
					</div>
				</div>
			</div>
			{if $letter}
			<div class="pd50_0 bg_fff AZDestination">
				<div class="container">
					<div class="destinationAZ">
						<h2 class="pane-title mb20">{$core->get_Lang('A-Z of Destinations')} {$TD}</h2>
						<div class="listDestination">
						{section name=i loop=$letter}
						{assign var = lstCityAZ value = $clsISO->getCityByRegionAlphabet($country_id,$region_id,$letter[i])}
						{if $lstCityAZ}
						<ul class="masonry grid-of-blog" id="SiteBlogContainer">
							<h3 class="title"><span>{$letter[i]}</span></h3>
							{section name=j loop=$lstCityAZ}
							<li><a href="{$clsCity->getLink($lstCityAZ[j].city_id)}" title="{$clsCity->getTitle($lstCityAZ[j].city_id)}">{$clsCity->getTitle($lstCityAZ[j].city_id)}</a></li>
							{/section}
						</ul>
						{/if}
						{/section}
						</div>
					</div>
				</div>
			</div>
			{/if}
		</div>
	</div>
</div>
<script>
	var country_id='{$country_id}';
	var city_id='{$city_id}';
</script>
{literal}
<script>
$(function(){
	var $number_per_page =5;
	var $page = 1;
	$page_aj = 0;
	var timer = '';
	/*loadPage();*/
	$('#show-more').click(function(e) {
		var $totalRecord = $('#home-masonry-container .box').size();
		if($page_aj){
			$page = $page_aj + 1;
			$page_aj=0;	
		}
		else $page = $page + 1;
		e.preventDefault();
		var $this = $(this);
		clearTimeout(timer);
		$('.loader').show();
		timer = setTimeout(function(){
			var $start = ($page-1) * $number_per_page;
			var $end = $start + $number_per_page;

			for(var i = $start; i < $end; i++) {
				$('.box').eq(i).show();
			}
			$('.loader').hide();
			if($end>=$totalRecord)
				$('#show-more').hide();
		}, 500);
	});
});
</script>
{/literal}  
{literal}
<script>
	$(document).ready(function(){
	  $(".anchor-link").on('click', function(event) {
		if (this.hash !== "") {
		  event.preventDefault();
		  var hash = this.hash;
		  $('html, body').animate({
			scrollTop: $(hash).offset().top - 85
		  }, 800, function(){
			//window.location.hash = hash;
		  });
		} 
	  });
	});

	var $ww = $(window).width();
	var stickyOffsetSB = $('.sb__destinations').offset().top;
	if($ww >992){
		$(window).scroll(function(){
			var sticky = $('.sb__destinations'),
			scroll = $(window).scrollTop();
			var stickyOffsetSBOut = $('.outerHeight').outerHeight() + 100;
			if (scroll >= stickyOffsetSB && scroll <= stickyOffsetSBOut){
			  sticky.addClass('fixed__sb_des');
			}
			else{
			  sticky.removeClass('fixed__sb_des');
			}
		});
		
	}
</script>
{/literal}