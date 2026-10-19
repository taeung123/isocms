<main id="main" class="page_container page_container_2019">
	{$core->getBlock('slider2019')}
    <div id="content_page_2019">
		{if _IS_PROMOTION eq '1'}
			{$core->getBlock('Lbox_toptourPromotion2019')}
		{else}
			{$core->getBlock('Lbox_toptourHomePage')}
		{/if}
		
		{$core->getBlock('Lbox_cattourHomePage2019')}
		<div class="box_home_2019 boxAboutUs">
			<div class="container">
				<div class="col_box box_logo">
					<img class="logo_about_box lazy" src="{$URL_IMAGES}/pixel.png" data-src="{$clsConfiguration->getImage('site_about_logo_home',202,96)}" width="202" height="96" alt="{$PAGE_NAME}" />
				</div>
				{assign var = SiteIntroAboutHome value = SiteIntroAboutHome_|cat:$_LANG_ID}
				<section class="col_box box_content">
					<h3><a href="{$clsISO->getLink('aboutUs')}" title="{$core->get_Lang('ABOUT US')}">{$core->get_Lang('ABOUT US')}</a></h3>
					<div class="content">
						{$clsConfiguration->getValue($SiteIntroAboutHome)|html_entity_decode}
					</div>
				</section>
				<div class="col_box box_follow_us">
					<p class="color_666 text_bold mb0">{$core->get_Lang('DON&#39;T HESITATE TO')}</p>
					<p class="color_666 size22 text_bold mb0">{$core->get_Lang('FOLLOW US')}</p>
					<div class="social_box">
						<ul>
							{if $clsConfiguration->getValue('Facebook_Link')}
							<li class="mb20"><a target="_blank" class="facebook" href="//www.facebook.com/{$clsConfiguration->getValue('SiteFacebookLink')}" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a></li>
							{/if}
							{if $clsConfiguration->getValue('Twitter_Link')}
							<li class="mb20"><a target="_blank" class="twitter" href="//www.twitter.com/{$clsConfiguration->getValue('SiteTwitterLink')}" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</a></li>
							{/if}
							{if $clsConfiguration->getValue('Youtube_Link')}
							<li><a target="_blank" class="youtube" href="//www.youtube.com/{$clsConfiguration->getValue('SiteYoutubeLink')}" title="Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i> Youtube</a></li>
							{/if}
							{if $clsConfiguration->getValue('TripAdvisor_Link')}
							<li><a target="_blank" class="tripadvisor" href="//www.tripadvisor.com/{$clsConfiguration->getValue('SiteTripAdvisorLink')}" title="TripAdvisor"><i class="fa fa fa-tripadvisor" aria-hidden="true"></i> TripAdvisor</a></li>
							{/if}
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		{$core->getBlock('Lbox_countrydestination')}
		
		{$core->getBlock('Lbox_blogHomePage2019')}
		
		{* {$core->getBlock('testimonialsHome2019')}*}
		 
		 {$core->getBlock('supportbox2019')}
		
		{$core->getBlock('subscribeHome2019')}
    </div>
</main>
{literal}
<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "{/literal}{$PAGE_NAME}{literal}",
  "url": "{/literal}{$DOMAIN_NAME}{$PAGE_NAME}{literal}",
  "description": "{/literal}{$global_description_page|strip_tags}{literal}",
 "image": "{/literal}{$DOMAIN_NAME}{$clsConfiguration->getValue('HeaderLogo')}{literal}",
  "aggregateRating": {
    "@type": "AggregateRating",
	"ratingValue": "{/literal}{if $clsReviews->getRateAvg(0,'') gt 0}{$clsReviews->getRateAvg(0,'')}{else}5{/if}{literal}",
    "bestRating": "{/literal}{if $clsReviews->getBestRate(0,'') gt 0}{$clsReviews->getBestRate(0,'')}{else}5{/if}{literal}",
    "ratingCount": "{/literal}{if $clsReviews->getToTalReview(0,'') gt 0}{$clsReviews->getToTalReview(0,'')}{else}1{/if}{literal}"
  }
}
</script>
{/literal}