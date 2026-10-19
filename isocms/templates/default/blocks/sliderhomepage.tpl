{if $clsConfiguration->getValue('Video_Teaser_Home') and $clsConfiguration->getValue('video_teaser_page') ne ''}
<div id="main" class="page_container">
	<div id="video-teaser" class="video-teaser video-container">
	<div class="filter"></div>
	<video preload="auto" autoplay loop class="fillWidth"><source src="{$clsConfiguration->getValue('video_teaser_page')}" type="video/mp4">
	{$core->get_Lang('Your browser does not support the video tag. I suggest you upgrade your browser.')}
	</video>
	</div>
</div>
{else}
{if $listSlide[0].slide_id ne ''}
{assign var=total value = $listSlide|@count}
{if $mod eq 'member'}
<div class="member sliderWrapper">
    <div id="sliderHomePage"{if $total gt '1'} class="owl-carousel"{/if}>
    	{section name=i loop=$listSlide} 
		{assign var = slide_title value = $clsSlide->getTitle($listSlide[i].slide_id)}
		{assign var = slide_image value = $clsSlide->getImage($listSlide[i].slide_id,1920,1200)}
        <div class="sliderItem" style="cursor:pointer">
			<img src="{$slide_image}" width="100%" alt="{$slide_title}" height="auto" />
        </div>
        {/section}
    </div>
</div>
{else}
<div class="sliderWrapper">
    <div id="sliderHomePage"{if $total gt '1'} class="owl-carousel"{/if}>
    	{section name=i loop=$listSlide} 
		{assign var = slide_text value = $clsSlide->getText($listSlide[i].slide_id)}
		{assign var = slide_title value = $clsSlide->getTitle($listSlide[i].slide_id)}
		{assign var = slide_link value = $clsSlide->getUrl($listSlide[i].slide_id)}
        <div class="sliderItem" style="cursor:pointer">
            <a class="photoSLide" href="{$slide_link}" title="{$text}">
				<img srcset="{$clsSlide->getImage($listSlide[i].slide_id,303,175)} 320w, {$clsSlide->getImage($listSlide[i].slide_id,455,220)} 480w, {$clsSlide->getImage($listSlide[i].slide_id,700,250)} 700w,{$clsSlide->getImage($listSlide[i].slide_id,759,237)} 768w, {$clsSlide->getImage($listSlide[i].slide_id,1009,315)} 1024w, {$clsSlide->getImage($listSlide[i].slide_id,1600,650)} 1200w" width="100%" height="auto" alt="{$slide_title}"/>
			</a>
            {if $slide_text ne ''}<div class="titleSlide">{$slide_text}</div>{/if}
        </div>
        {/section}
    </div>
	<div class="content_banner">
		<div class="container">
			<p class="text_find hidden-sm" style="text-align:center;">{$core->get_Lang('Find your special tour today')}</p>
			<div class="search_home_page">
				{$core->getBlock('find_trip_details')}
			</div>
		</div>
	</div>
	{*<div class="content_banner hidden-xs">
		<div class="container">
			<div class="search_home_page">
				<p class="title_find_trip">{$core->get_Lang('Make Your Trip')}</p>
				{$core->getBlock('find_tour_destination')}
			</div>
		</div>
	</div>*}
</div>
{/if}
{if $total gt '1'}
{literal}
<script type="text/javascript">
	$(function(){
		if($('#sliderHomePage').length > 0){
			var $owl = $('#sliderHomePage');
			$owl.owlCarousel({
				loop:true,
				lazyLoad:true,
				margin:0,
				responsiveClass:true,
				autoplay:true,
				responsive:{
					0:{
						items:1,
						nav:false
					},
					600:{
						items:1,
						nav:false
					},
					1200:{
						items:1,
						nav:false
					}
				}
			});
			$('#next_1').click(function(){
				$('#sliderHomePage .owl-next').trigger('click');
			});
			$('#prev_1').click(function(){
				$('#sliderHomePage .owl-prev').trigger('click');
			});
		}
	});
</script>
{/literal}
{/if}
{literal}
<style type="text/css">
	.sliderWrapper{position:relative}
	.sliderWrapper .owl-controls{display:none !important}
	.sliderWrapper .owl-dots{display:none !important}
	.sliderWrapper #sliderHomePage{height:100%; overflow:hidden}
	#sliderHomePage .container{position:relative}
	.sliderItem{position:relative}
	.sliderItem .titleSlide{position:absolute; width:auto; height:36px; line-height:36px; background:rgba(0,0,0,0.6); bottom:15px; right:15px; color:#fff; padding:0 10px}
	#sliderHomePage img{min-height:175px;}
</style>
{/literal}
{/if}
{/if}