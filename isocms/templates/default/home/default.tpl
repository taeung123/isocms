<main id="main" class="page_container">
    {$core->getBlock('slider_home')}
	{if $deviceType ne 'phone'}
    {if $listWhyHome}
    <section class="section_box why">
        <div class="container">
		   <div class="owl-carousel slideWhy" id="whyWithUs">
				{section name=i loop=$listWhyHome}
				{assign var=title value=$clsWhy->getTitle($listWhyHome[i].why_id)}
				<div class=" item__why box_col"> 
					<div class="item__why--icon">
						<img src="{$URL_IMAGES}/pixel.png" data-src="{$clsWhy->getIcon($listWhyHome[i].why_id)}" alt="{$title}" class="lazy img100">
					</div>
					<div class="item__why--artice">
						<p class="title size20 mb10">{$title}</p>
						<div class="intro limit_2line">
							{$clsWhy->getIntro($listWhyHome[i].why_id)}
						</div>
					</div>
				</div>
				{/section}
			</div>
        </div>
    </section>
    {/if}
	
	{/if}
    {if $listAdsHome}
	<section class="qc__box home_box">
		<div class="container">
			<div class="qc__box--slider owl_carousel_1_item owl-carousel">
				{section name=i loop=$listAdsHome}
					{assign var=title value=$clsAds->getTitle($listAdsHome[i].ads_id)}
					{assign var=link_ads value=$clsAds->getLink($listAdsHome[i].ads_id)}
					{if $deviceType eq 'phone'}
						{assign var=image_ads value=$clsAds->getImage($listAdsHome[i].ads_id,480,320)}
						{else}
						{assign var=image_ads value=$clsAds->getImage($listAdsHome[i].ads_id,1280,292)}
					{/if}
					<div class="qc__box--item">
						<a {if $link_ads} href="{$link_ads}"{/if} title="{$title}">
							<img data-src="{$image_ads}" alt="{$title}" class="owl-lazy img100">
						</a>
					</div>
				{/section}
			</div>
		</div>
	</section>
	{/if}
	{if $package_id eq 3||$package_id eq 4}
	   {if $deviceType eq 'computer'}
			{$core->getBlock('Lbox_departure_scheduleHome')}
	   {else}
			{$core->getBlock('Lbox_departure_scheduleHome_mobile')}
	   {/if}
	{/if}
    {if _IS_PROMOTION eq '2'}
        {$core->getBlock('Lbox_toptourPromotion')}
    {else}
        {$core->getBlock('Lbox_topTour')}
    {/if}
    {$core->getBlock('Lbox_TopDestination')}
    {$core->getBlock('Lbox_Tour_Inbound')}
    {$core->getBlock('Lbox_Tour_Outbound')}
    {$core->getBlock('testimonialsHome')}
    {$core->getBlock('subscribeHome')}
    {$core->getBlock('Lbox_blogHomePage')}
	{if $deviceType ne 'phone'}
    {$core->getBlock('partner')}
    {$core->getBlock('Press_news')}
	{else}
	<div class="clearfix mb50"></div>
	{/if}
</main>
