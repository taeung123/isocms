{if $clsConfiguration->getValue('Video_Teaser_Home') and $clsConfiguration->getValue('video_teaser_page') ne ''}
<div id="video-teaser" class="video-teaser video-container">
	<div class="filter"></div>
	<video autoplay loop class="fillWidth"><source src="{$clsConfiguration->getValue('video_teaser_page')}" type="video/mp4">
	{$core->get_Lang('Your browser does not support the video tag. I suggest you upgrade your browser.')}
	</video>
</div>
{else}
<div id="slide" class="sliderWrapper">
	<div class="slide-main">
		<div class="swiper-container">
			<div class="swiper-wrapper">
				{section name=i loop=$listSlide} 
				{assign var = slide_text value = $clsSlide->getTitle($listSlide[i].slide_id)}
				{if $clsISO->getBrowser() eq 'phone'}
				<div class="swiper-slide lazy" data-src="{$clsSlide->getImage($listSlide[i].slide_id,480,320)}" style="background-image:url('{$clsSlide->getImage($listSlide[i].slide_id,480,320)}')" onclick="ClickHref('{$clsSlide->getUrl($listSlide[i].slide_id)}');">
				{if $slide_text ne ''}<div class="titleSlide">{$slide_text}</div>{/if}
				</div>
				{else}
				<div class="swiper-slide lazy" data-src="{$clsSlide->getImage($listSlide[i].slide_id,1600,568)}" style="background-image:url('{$clsSlide->getImage($listSlide[i].slide_id,1600,568)}')" onclick="ClickHref('{$clsSlide->getUrl($listSlide[i].slide_id)}');">
				{if $slide_text ne ''}<div class="titleSlide">{$slide_text}</div>{/if}
				</div>
				{/if}
				{/section}
				{if 1 eq 2}<video src="/uploads/Slide/video/lasertec-30-slm-en-data.mp4" class="swiper-slide swiper-slide-active" autoplay loop muted playsinline="" data-swiper-slide-index="3" style="width: 1583px;"></video>{/if}
			</div>
			<div class="container relative">
				<!-- Add Pagination -->
				<div class="swiper-pagination"></div>
			</div>
			<!-- Add Arrows -->
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
	  </div>
	</div>
	{if $mod ne 'member'}
		{if $clsISO->getBrowser() eq 'phone'}
			{$core->getBlock('find_trip_details_mobile')}
		{else}
		<div class="content_banner">
			<div class="container">
				<div class="box_search_home_page">
					{$core->getBlock('find_trip_details_2019')}
				</div>
			</div>
		</div>
		{/if}
	{/if}
</div>
{/if}
{literal}
<script>
	var swiper = new Swiper('.swiper-container', {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });


	
</script>
{/literal}