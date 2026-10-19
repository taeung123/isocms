<link rel="stylesheet" href="{$URL_CSS}/isocruise.css?v={$upd_version}" type="text/css">	
<link rel="stylesheet" href="{$URL_CSS}/default.css?v={$upd_version}" type="text/css">
<link rel="stylesheet" href="{$URL_CSS}/guide.css?v={$upd_version}" type="text/css">		
<div class="page_container mb50">
	<section class="cat-banner" id="container_2"> <img src="{$clsConfiguration->getValue('site_destination_banner')}" alt="{$clsCruiseCat->getTitle($cat_id)}" width="100%" height="402px">
    <nav class="breadcrumb-main">
      <div class="container">
        <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
          <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			  <a itemprop="item" href="{$PCMS_URL}{$extLang}">
				  <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
				<meta itemprop="position" content="1" />
			</li>
           <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			   <a itemprop="item" href="{$clsISO->getLink('destination')}" title="{$core->get_Lang('Destinations')}" itemprop="url">
				   <span itemprop="name" class="reb">{$core->get_Lang('Destinations')}</span></a>
				<meta itemprop="position" content="2" />
			</li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a itemprop="item" href="{$curl}" title="{$clsCountryEx->getTitle($country_id)}" itemprop="url">
					<span itemprop="name" class="reb">{$clsCountryEx->getTitle($country_id)}</span> </a>
				<meta itemprop="position" content="3" />
			</li>
        </ol>
      </div>
    </nav>
    <h1 class="z_24 f_hn text-normal text-uppercase" style="left: 206.5px;">{if $show eq 'overview'}
        {$clsCountryEx->getTitle($country_id)}
        {else}
        {$clsGuideCat->getTitle($guidecat_id)} in {$clsCountryEx->getTitle($country_id)}
        {/if}
    </h1>
  </section>
    <div class="container mt50">
        <div class="contentPage">
        	<div class="row">
                <div class="col-lg-3 hidden-xs hidden-sm mb30">
                    <div class="destinationLink mb40">
                        <h3 class="h3_18_Bold_007f75 mb10">{$core->get_Lang('Category')}</h3>
                        <ul>
                            {if $listTour[0].tour_id ne ''}
                            <li><a class="{if $mod eq 'destination' && $act eq 'country'}current{/if}" href="{$clsCountryEx->getLink($country_id,'tour')}" title="{$clsCountryEx->getTitle($country_id)} {$core->get_Lang('Tours')}">{$clsCountryEx->getTitle($country_id)} {$core->get_Lang('Tours')}</a></li>
                            {/if}
                            {if $listHotelCity[0].hotel_id ne ''}
                            <li ><a class="{if $mod eq 'hotel' && $act eq 'place'}current{/if}" href="{$clsCity->getLink($city_id,'Hotel')}" title="Hotels">Hotels</a></li>
                            {/if}
                            {section name=i loop=$listGuideCat}
                            {assign var=cat_id value=$clsGuideCat->getGuideCatId($listGuideCat[i].guidecat_id)}
                            {if $clsGuide->countGuideGlobal($country_id, 0, $listGuideCat[i].guidecat_id) gt 0}
                            <li><a href="{$clsCity->getLinkGuide($cat_id,$country_id)}" title="{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}" class="{if $guidecat_id eq $listGuideCat[i].guidecat_id}current{/if}">{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}</a></li>
                            {/if}
                            {/section}
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 mb50">
                    <div class="contentDestination">   
                        <h2 class="h2_24_Bold_010101 mb20">
                        {if $show eq 'overview'}
                        {$clsCountryEx->getTitle($country_id)} {$core->get_Lang('Destination')}
                        {else}
                        {$clsGuideCat->getTitle($guidecat_id)} in {$clsCountryEx->getTitle($country_id)}
                        {/if}
                        
                        </h2>
                        {if $show eq 'overview'}
                        <div class="intro14_3 mb20">{$clsCountryEx->getStripIntro($country_id)}</div>
                         <div class="photoCity mb20">
                        <a href="{$clsCountryEx->getLink($country_id)}" title="{$clsCountryEx->getTitle($country_id)}"><img src="{$clsCountryEx->getImage($country_id,800,450)}" width="100%" height="auto" alt="{$clsCountryEx->getTitle($country_id)}" /></a>
                    </div>
                        <div class="intro14_3 mb20">{$clsCountryEx->getContent($country_id)}</div>
                        {else}
                         {section name=j loop=$listGuideByCity2 max=1}
                        	<div class="intro14_3 mb30">{$clsGuide2->getStripIntro($listGuideByCity2[j].guide2_id)}</div>
                         {/section}
                        {/if}
                        <div class="tabs_contentRL mb20" id="lstTabsRL" style="border:0 !important">
                            <div id="listHolderView" class="contentTabRL row">
                                {assign var=totalGuide value=$listGuideByCity|@count}
                                {section name=j loop=$listGuideByCity}
                                {if $clsGuide->getTitle($listGuideByCity[j].guide_id) ne ''}
                                {assign var=title value=$clsGuide->getTitle($listGuideByCity[j].guide_id)}
                                {assign var=link value=$clsGuide->getLink($listGuideByCity[j].guide_id)}
                                <div class="box col-sm-6 col-md-4" {if $smarty.section.j.iteration gt '9'} style="display:none;"{/if}>
                                    <div class="TourItem">
                                        <div class="photo250">
                                            <a class="photo" href="{$link}" title="{$title}">
                                                 <img class="img-responsive" src="{$clsGuide->getImage($listGuideByCity[j].guide_id,600,400)}" width="100%" alt="{$title}"/>
                                            </a>
                                        </div>
                                        <div class="body" style="height:135px; overflow:hidden">
                                            <h3><a href="{$link}" title="{$title}">{$title}</a></h3>
                                            <div class="intro14_3 mb10">{$clsGuide->getStripIntro($listGuideByCity[j].guide_id)|strip_tags|truncate:80}</div>
                                        </div>
                                        <!--<a class="linkBook" href="{$link}" title="{$core->get_Lang('Read more')}">{$core->get_Lang('Read more')}</a>-->
                                    </div>
                                </div>
                                {/if}
                                {/section}
                                {if $totalGuide gt '9'}
                                    <div class="cleafix"></div>
                                     <div class="wrap">
                                            <a href="javascript:void(0);" rel="nofollow" page="1" class="show-more" id="show-more">{$core->get_Lang('Show more trips')}<img src="{$URL_IMAGES}/loadtrip.png" class="load" alt="load" width="16px" height="16px"/></a>
                                     </div>                                                
                                {/if}
                        	</div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-3 hidden-md hidden-lg">
                    <div class="destinationLink mb40 ">
                        <h3 class="h3_18_Bold_007f75 mb10">{$core->get_Lang('Destinations')}</h3>
                        <ul>
                            {section name=i loop=$listTopCity}
                            {assign var=title value=$clsCountryEx->getTitle($listTopCity[i].country_id)}
                            {assign var=link value=$clsCountryEx->getLink($listTopCity[i].country_id)}
                            <li class="{if $country_id eq ($listTopCity[i].country_id)}active{/if}"><a href="{$link}" title="{$title}">{$title}</a></li>
                            {/section}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="destinationAZ">
                <h2 class="mb20">A-Z of {$core->get_Lang(' Destinations')} {$clsCountryEx->getTitle($country_id)}</h2>
                <div class="listDestination">
                    {section name=i loop=$letter}
                    {assign var = lstCityAZ value = $clsISO->getItemByAlphabet($country_id,0,$letter[i])}
                    {if $lstCityAZ}
                    <ul class="masonry grid-of-blog" id="SiteBlogContainer">
                        <h3 class="title"><span>{$letter[i]}</span></h3>
                        {section name=j loop=$lstCityAZ}
                            <li>
                                <a href="{$clsCity->getLink($lstCityAZ[j].city_id)}">{$clsCity->getTitle($lstCityAZ[j].city_id)}</a>
                           </li>
                        {/section}
                    </ul>
                    {/if}
                    {/section}
                </div>
            </div>
        </div>
    </div>
    
</div>
{literal}
<script type="text/javascript">
$(function(){	
    var $number_per_page = 6;	
    var $page =1;	
    var timer = '';
    $('#show-more').click(function(){
        var $_this = $(this);	
        clearTimeout(timer);	
        $page = $page+1;	
        timer = setTimeout(function(){	
            var $start = ($page-1)*$number_per_page;	
            var $end = $start + $number_per_page;	
            for(var i = $start; i < $end; i++){	
                $('.box').eq(i).show();	
            }	
        },500);
        /* Hide load more */	
        setInterval(function(){	
            loadPageFix();	
        },100);	
    });	
}); 
</script>
{/literal}
