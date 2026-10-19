{assign var=titleGuideCat value=$clsGuideCat->getTitle($guidecat_id)}
<div class="page_container">
	<div class="banner"> 
		{if $guide2_id ne ''} 
		<a href="{$clsGuide2->getBannerLink($guide2_id)}" title="{$titleGuideCat} {$core->get_Lang('in')} {$TD}">
		<img class="full-width height-auto" src="{$clsGuide2->getBannerImage($guide2_id,1920,500)}" alt="{$titleGuideCat} {$core->get_Lang('in')} {$TD}" />
		</a>
		{else} 
		<a href="{$clsGuideCat->getBannerLink($guidecat_id)}" title="{$titleGuideCat} {$core->get_Lang('in')} {$TD}">
		<img class="full-width height-auto" src="{$clsGuideCat->getBannerImage($guidecat_id,1920,500)}" alt="{$titleGuideCat} {$core->get_Lang('in')} {$TD}"/>
		{/if}
	</div>
	<nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb bg_fff hidden-xs mt0" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span>
					</a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$clsCity->getLinkTour($city_id)}" title="{$clsCity->getTitle($city_id)}">
						<span itemprop="name" class="reb">{$clsCity->getTitle($city_id)}</span></a>
					<meta itemprop="position" content="2" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active"> 
					<a itemprop="item" href="javascript:Void();" title="{$titleGuideCat}"> 
						<span itemprop="name" class="reb">{$titleGuideCat}</span> </a> 
					<meta itemprop="position" content="3" />
				</li>
			</ol>
		</div>
	</nav>
	<div id="contentPage" class="travelGuidePage bg_f7f7f7 pd40_0">
		<div class="container">
			<div class="row">
				<section class="col-lg-9 mb991_30 floatRight992">
					{if $_LANG_ID eq 'vn'}
					<h1 class="title32 color_333 mb20">{$titleGuideCat} {$TD}</h1>
					{else}
					<h1 class="title32 color_333 mb20">{$TD} {$titleGuideCat}</h1>
					{/if}
					{assign var=introGuideCat value=$clsGuideCat->getIntro($listGuideByCat[0].guidecat_id)}
					{assign var=IntroGuideCat value=$clsGuide2->getIntro($guide2_id)}
					{assign var=ContentGuideCat value=$clsGuide2->getContent($guide2_id)}
					{if $show eq 'GuideCat' and $introGuideCat ne ''}
					<div class="intro14_3 mb30">{$introGuideCat}</div>
					{/if}
					{if $IntroGuideCat ne ''}
					<div class="intro14_3 mb20">{$IntroGuideCat}</div>
					{/if}
					{if $ContentGuideCat ne ''}
					<div class="intro14_3 mb30">{$ContentGuideCat}</div>
					{/if}
					<div>
						<div class="loader"></div>
						<div class="search-results js-search-results" id="home-masonry-container">
							<div class="row"> 
								{assign var=totalGuide value=$listGuide|@count}
								{section name=i loop=$listGuide}
								{assign var=title value=$clsGuide->getTitle($listGuide[i].guide_id)}
								{assign var=link value=$clsGuide->getLink($listGuide[i].guide_id)}
								<article class="box col-xl-4 col-lg-6 col-sm-6 mb10" {if $smarty.section.i.iteration gt '12'} style="display:none"{/if}>
									<div class="guideItem">
										<div class="image">
											<a href="{$link}"><img class="full-width" alt="{$title}" src="{$clsGuide->getImage($listGuide[i].guide_id,513,342)}"></a> 
											{assign var=city__id value=$clsGuide->getOneField(city_id,$listGuide[i].guide_id)}
											{assign var=country__id value=$clsGuide->getOneField(country_id,$listGuide[i].guide_id)}
											{assign var=title_city value=$clsCity->getTitle($city__id)}
											{assign var=title_country value=$clsCountryEx->getTitle($country__id)}
											<div class="figure"><i class="fa fa-map-marker"></i>{if $city__id gt '0'} <a href="{$clsCity->getLink($city__id)}" title="{$title_city}">{$title_city}</a>, {/if} <a href="{$clsCountryEx->getLink($country__id)}" title="{$title_country}">{$title_country}</a></div>
										</div>
										<h3 class="name"><a href="{$link}">{$title}</a></h3>
									</div>
								</article>	 
								{/section}
							</div>
						</div>
						{if $totalGuide gt 12}
						<div id="exploreWorldLoadMore">
							<div id="load_more_collections">
								<div class="loader"></div>
								<a href="javascript:void(0);" rel="nofollow" page="1" class="btn_orance_border show-loader" id="show-more">{$core->get_Lang('LOAD MORE COLLECTIONS')}</a>
							</div>
						</div>
						{/if} 
					</div>
				</section>
				<aside class="col-lg-3"> {if $listGuideCat or $listHotelPlace or $listBlogPlace}
					<div class="destinationLink mt20">
						<h3 class="h3_24_Bold mb10">{$TD}</h3>
						<ul>
							{if $listHotelPlace && $_LANG_ID ne 'vn'}
							{if $show eq 'City'}
							<li ><a class="{if $mod eq 'hotel' && $act eq 'place'}active{/if}" href="{$clsCity->getLink($city_id,'Hotel')}" title="{$core->get_Lang('Hotels')}">{$core->get_Lang('Hotels')}</a></li>
							{elseif $show eq 'Country'}
							<li ><a class="{if $mod eq 'hotel' && $act eq 'place'}active{/if}" href="{$clsCountryEx->getLink($country_id,'Hotel')}" title="{$core->get_Lang('Hotels')}">{$core->get_Lang('Hotels')}</a></li>
							{else}
							<li ><a class="{if $mod eq 'hotel' && $act eq 'place'}active{/if}" href="{$clsRegion->getLink($country_id,$region_id,'Hotel')}" title="{$core->get_Lang('Hotels')}">{$core->get_Lang('Hotels')}</a></li>
							{/if}
							{/if}
							{if $listBlogPlace}
							{if $show eq 'City'}
							<li ><a class="{if $mod eq 'blog' && $act eq 'default'}active{/if}" href="{$clsCity->getLink($city_id,'Blog')}" title="{$core->get_Lang('Blogs')}">{$core->get_Lang('Blogs')}</a></li>
							{elseif $show eq 'Country'}
							<li ><a class="{if $mod eq 'blog' && $act eq 'default'}active{/if}" href="{$clsCountryEx->getLink($country_id,'Blog')}" title="{$core->get_Lang('Blogs')}">{$core->get_Lang('Blogs')}</a></li>
							{else}
							<li ><a class="{if $mod eq 'blog' && $act eq 'default'}active{/if}" href="{$clsRegion->getLink($country_id,$region_id,'Blog')}" title="{$core->get_Lang('Blogs')}">{$core->get_Lang('Blogs')}</a></li>
							{/if}
							{/if}
							{if $show eq 'Region'}
							{section name=i loop=$listGuideCat}
							{if $clsGuide->countGuideByRegion($country_id, $region_id, $listGuideCat[i].guidecat_id) gt 0}
							<li {if $guidecat_id eq $listGuideCat[i].guidecat_id}class="active"{/if}><a href="{$clsGuideCat->getLinkRegion($country_id,$region_id,$listGuideCat[i].guidecat_id)}" title="{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}">{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}</a></li>
							{/if}
							{/section}
							{else}
							{section name=i loop=$listGuideCat}
							{if $clsGuide->countGuideGlobal($country_id, $city_id, $listGuideCat[i].guidecat_id) gt 0}
							<li {if $guidecat_id eq $listGuideCat[i].guidecat_id}class="active"{/if}><a href="{$clsGuideCat->getLink($country_id,$city_id,$listGuideCat[i].guidecat_id)}" title="{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}">{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}</a></li>
							{/if}
							{/section}
							{/if}
						</ul>
					</div>
					{/if}
				</aside>
			</div>
		</div>
	</div>
	{if $show ne 'GuideCat'}
	<div class="pd50_0 bg_fff AZDestinationGuide">
		<div class="container"> 
			{if $lstRegionByCountry}
			<article class="destinationAZ">
				<h2 class="pane-title mb20 xxxxx">{$core->get_Lang('A-Z')} {$titleGuideCat} {$core->get_Lang('of')} {$core->get_Lang('Destinations')} {$TD}</h2>
				<div class="listDestinationByRegion"> 
				{section name=i loop=$lstRegionByCountry}
				{assign var = lstCityGuideCatRegion value = $clsCity->getListCityGuideCatByRegion($lstRegionByCountry[i].region_id,$guidecat_id)}
				{if $lstCityGuideCatRegion}
				<h3 class="title"><a href="{$clsGuideCat->getLinkRegion($country_id,$lstRegionByCountry[i].region_id,$guidecat_id)}" title="{$lstRegionByCountry[i].title}">{$lstRegionByCountry[i].title}</a></h3>
				<ul class="CityRegionItem {if $smarty.section.i.last}cleafix{/if}"> 
				{section name=j loop=$lstCityGuideCatRegion}
					<li class="col-md-2 col-sm-4 col-xs-6">
					<a href="{$clsGuideCat->getLink($country_id,$lstCityGuideCatRegion[j].city_id,$guidecat_id)}">{$clsCity->getTitle($lstCityGuideCatRegion[j].city_id)}</a></li>
				{/section}
				</ul>
				{/if}
				{if $smarty.section.i.last}
				{if $lstCityRegionOther}
				<h3 class="title"><span>{$core->get_Lang('Other City')}</span></h3>
				<ul class="CityRegionItem"> 
					{section name=k loop=$lstCityRegionOther}
					<li class="col-md-2 col-sm-4 col-xs-6">
					<a href="{$clsCity->getLink($lstCityRegionOther[k].city_id,'Hotel')}">{$clsCity->getTitle($lstCityRegionOther[k].city_id)}</a></li>
					{/section} 
				</ul>
				{/if}
				{/if}
				{/section} 
				</div>
			</article>
			{else}
			<div class="destinationAZ"> 
				{if $show eq 'Region' && $letter}
				<h2 class="pane-title mb20">{$core->get_Lang('A-Z')} {$titleGuideCat} {$core->get_Lang('of')} {$core->get_Lang('Destinations')} {$TD}</h2>
				<div class="listDestination"> 
				{section name=i loop=$letter}
				{assign var = lstCityAZ value = $clsISO->getItemByAlphabetCityGuide($country_id,$region_id,0,$guidecat_id,$letter[i])}
				{if $lstCityAZ}
				<ul class="masonry grid-of-blog" id="SiteBlogContainer">
					<h3 class="title"><span>{$letter[i]}</span></h3>
					{section name=j loop=$lstCityAZ}
					{if $clsGuide->countGuideByRegion($country_id,$region_id,$guidecat_id) gt 0}
					<li><a href="{$clsGuideCat->getLink($country_id,$lstCityAZ[j].city_id,$guidecat_id)}">{$clsCity->getTitle($lstCityAZ[j].city_id)}</a></li>
					{/if}
					{/section}
				</ul>
				{/if}
				{/section} 
				</div>
				{else}
				{if $show eq 'City'}
				<h2 class="pane-title mb20">{$core->get_Lang('A-Z')} {$titleGuideCat} {$core->get_Lang('of')} {$core->get_Lang('Other Destinations')}</h2>
				{else}
				<h2 class="pane-title mb20">{$core->get_Lang('A-Z')} {$titleGuideCat}{$core->get_Lang('of')} {$core->get_Lang('Destinations')} {$TD}</h2>
				{/if}
				<div class="listDestination"> {section name=i loop=$letter}
				{assign var = lstCityAZ value = $clsISO->getItemByAlphabetCityGuide($country_id,0,$city_id,$guidecat_id,$letter[i])}
				{if $lstCityAZ}
				<ul class="masonry grid-of-blog" id="SiteBlogContainer">
					<h3 class="title"><span>{$letter[i]}</span></h3>
					{section name=j loop=$lstCityAZ}
					<li><a href="{$clsGuideCat->getLink($country_id,$lstCityAZ[j].city_id,$guidecat_id)}">{$clsCity->getTitle($lstCityAZ[j].city_id)}</a></li>
					{/section}
				</ul>
				{/if}
				{/section}
				{/if} 
				</div>
			</div>
			{/if} 
		</div>
	</div>
{/if} 
</div>
<script>
	var cat_id='{$cat_id}';
</script> 
{literal} 
<script>
$(function(){
	var $number_per_page = 12;
	var $page = 1;
	$page_aj = 0;
	var timer = '';
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