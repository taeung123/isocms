{$core->getBlock('box_travel')} 
<div class="page_container mb50">
    <div class="banner" style="background-image:url('{$clsConfiguration->getValue('site_destination_banner')}'); background-position:50% 50%; background-size:cover">
        <div class="contentBanner">
            <h1>
            {if $show eq 'overview'}
            {$clsCity->getTitle($city_id)}
            {else}
            {$clsGuideCat->getTitle($guidecat_id)} in {$clsCity->getTitle($city_id)}
            {/if}
            </h1><br/>
            <div class="intro14_f">            
            {assign var=site_intro_banner value=site_intro_banner_|cat:$_LANG_ID}
            {$clsConfiguration->getValue($site_intro_banner)}
            </div>
        </div>
        {$core->getBlock('find_a_trip')}
    </div>
    {$core->getBlock('find_a_trip_mobile')}
    <div class="container">
    	<nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
            <div class="container">
                <ol class="breadcrumb bg_fff hidden-xs mt0" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<a itemprop="item" href="/" title="">
							<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
						<meta itemprop="position" content="1" />
					</li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<a itemprop="item" href="{$clsISO->getLink('destination')}" title="{$core->get_Lang('Destinations')}">
							<span itemprop="name" class="reb">{$core->get_Lang('Destinations')}</span></a>
						<meta itemprop="position" content="2" />
					</li>
                   
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<a itemprop="item" href="{$curl}" title="{$clsCity->getTitle($city_id)}">
							<span itemprop="name" class="reb">{$clsCity->getTitle($city_id)} {$clsGuideCat->getTitle($guidecat_id)}</span></a>
						<meta itemprop="position" content="3" />
					</li>
                </ol>
            </div>
        </nav>
        <div class="contentPage">
        	<div class="row">
                <div class="col-lg-3 hidden-xs hidden-sm mb30">
                    <div class="destinationLink mb40">
                        <h3 class="h3_18_Bold_007f75 mb10">{$core->get_Lang('Destinations')}</h3>
                        <ul>
                            {section name=i loop=$listTopCity}
                            {assign var=title value=$clsCity->getTitle($listTopCity[i].city_id)}
                            {assign var=cat_id value=$clsGuideCat->getGuideCatId($listGuideCat[0].guidecat_id)}
                            <li class="{if $city_id eq ($listTopCity[i].city_id)}active{/if}"><a href="{$clsCity->getLink($listTopCity[i].city_id)}" title="{$title}">{$title}</a></li>
                            {/section}
                        </ul>
                    </div>
                    {$core->getBlock('download')}
                    {$core->getBlock('company')}
                </div>
                <div class="col-lg-9 mb50">
                    <div class="contentDestination">   
                        <h2 class="h2_24_Bold_010101 mb20">
                        {if $show eq 'overview'}
                        {$clsCity->getTitle($city_id)}
                        {else}
                        {$clsGuideCat->getTitle($guidecat_id)} in {$clsCity->getTitle($city_id)}
                        {/if}
                        
                        </h2>
                        {section name=j loop=$listGuideByCity2 max=1}
                        <div class="intro14_3 mb30">{$clsGuide2->getStripIntro($listGuideByCity2[j].guide2_id)}</div>
                        {/section}
                        {$core->getBlock('destinationTab')}
                        {if $show eq 'overview'}
                        <div class="intro14_3 mb20">{$clsCity->getStripIntro($city_id)}</div>
                         <div class="photoCity mb20">
                        <a href="{$clsCity->getLink($city_id)}" title="{$clsCity->getTitle($city_id)}"><img src="{$clsCity->getImage($city_id,800,450)}" width="100%" height="auto" alt="{$clsCity->getTitle($city_id)}" /></a>
                    </div>
                        <div class="intro14_3 mb20">{$clsCity->getContent($city_id)}</div>
                        
                        
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
                            {assign var=title value=$clsCity->getTitle($listTopCity[i].city_id)}
                            {assign var=link value=$clsCity->getLink($listTopCity[i].city_id)}
                            <li class="{if $city_id eq ($listTopCity[i].city_id)}active{/if}"><a href="{$link}" title="{$title}">{$title}</a></li>
                            {/section}
                        </ul>
                    </div>
                    {$core->getBlock('download')}
                </div>
            </div>
        </div>
    </div>
    {$core->getBlock('blog')}
</div>
{$core->getBlock('getspecial')}

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
