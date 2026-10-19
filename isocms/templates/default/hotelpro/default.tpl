{$core->getBlock('box_travel')} 
<div class="page_container">
    <div class="banner" style="background-image:url('{$clsConfiguration->getValue('site_hotel_banner')}'); background-position:50% 50%; background-size:cover">
        <div class="contentBanner">
            <h1>Hotel & Resorts</h1><br/>
            {assign var=site_intro_hotel_banner value=site_intro_hotel_banner_|cat:$_LANG_ID}
            {if $clsConfiguration->getValue($site_intro_hotel_banner) ne ''}
            <div class="intro14_f"> 
				{$clsConfiguration->getValue($site_intro_hotel_banner)}
           </div>
           {/if}
        </div>
        {$core->getBlock('find_hotel')}
    </div>   
    {$core->getBlock('find_hotel_mobile')}
    <div class="container">
        <div id="breadcrumb" class="mb20">
            <div class="breadcrumb">
                <ul itemscope itemtype="http://schema.org/BreadcrumbList">
                    <li itemprop="name"><a href="{$PCMS_URL}{$extLang}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a></li>
                    <li><span>› </span></li>
                    <li itemprop="name"><a href="{$clsCountryEx->getLink($country_id,'Hotel')}" title="{$clsCountryEx->getTitle($country_id)}">Hotel & Resort</a></li>
                </ul>
            </div>
        </div>        
    </div>
    <div class="clearfix"></div>
    <div class="content">
        <div class="container">
            <div class="MH_box">
                <h1 class="headMod SegoeUILight">Hotel & Resorts</h1>
                {assign var=site_hotel_intro value=site_hotel_intro_|cat:$_LANG_ID}
            	{if $clsConfiguration->getValue($site_hotel_intro) ne ''}
            	<div class="intro14_3 text-center"> 
				{$clsConfiguration->getValue($site_hotel_intro)|html_entity_decode}
                </div>
                {/if}
            </div>
            <div class="clearfix"></div>
            <div class="row">
                {section name=i loop=$listHotel}
                {assign var = link value = $clsHotel->getLink($listHotel[i].hotel_id)}
                {assign var = title value = $clsHotel->getTitle($listHotel[i].hotel_id)}
                <div class="col-sm-6 col-md-4">
                    <div class="hotelItem">
                        <div class="post-thumb">
                            <a class="photo" href="{$link}" title="{$title}">
                                <img class="img-responsive" src="{$clsHotel->getImage($listHotel[i].hotel_id,600,400)}" alt="{$title}" title="{$title}" width="100%" align="top">
                            </a>
                            <div class="figure">
                                <a href="{$link}" class="viewdetail">{$core->get_Lang('View Detail')}</a>
                                <p class="price-hotels">{$core->get_Lang('From')}: <span class="price-Inc">{$clsHotel->getPrice($listHotel[i].hotel_id)}</span></p>
                            </div>
                        </div>
                        <div class="body">
                            <h3 class="title"><a href="{$link}" title="{$title}">{$title}</a></h3>
                            <p class="star"><img src="{$clsHotel->getImageStar($listHotel[i].star_id)}" /></p>
                            <p class="address"><span>{$core->get_Lang('Address')}: </span>{$clsHotel->getAddress($listHotel[i].hotel_id)}</p>
                            <p class="text">{$clsHotel->getIntro($listHotel[i].hotel_id)|strip_tags|truncate:100}</p>
                        </div>
                    </div>
                </div>
                {/section}
            </div>
            <div class="clearfix"></div>
            {if $totalPage gt 1}
            <center>
                <div class="pagination">
                    {$page_view}
                </div>
            </center>
            {/if}
            <div class="clearfix"><br /></div>
            {$core->getBlock('recommended')}
        </div>
    </div>
</div>