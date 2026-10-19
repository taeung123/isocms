{if $clsConfiguration->getValue('Video_Teaser_Home') and $clsConfiguration->getValue('video_teaser_page') ne ''}
<div id="video-teaser" class="video-teaser video-container">
	<div class="filter"></div>
	<video autoplay="" loop="" class="fillWidth"><source src="{$clsConfiguration->getValue('video_teaser_page')}" type="video/mp4">
	{$core->get_Lang('Your browser does not support the video tag. I suggest you upgrade your browser.')}
	</video>
</div>
{else}
<div id="slide" class="sliderWrapper">
	<div class="slide-main">
		<div class="swiper-container swiper-container-horizontal swiper-container-fade">
			<div class="swiper-wrapper" style="transition-duration: 0ms;">
				{section name=i loop=$listSlide} 
				{assign var = slide_text value = $clsSlide->getTitle($listSlide[i].slide_id)}
				{if $clsISO->getBrowser() eq 'phone'}
				<div id="slide-main0{$smarty.section.i.index}" class="swiper-slide bg-check" style="background-image:url('{$clsSlide->getImage($listSlide[i].slide_id,480,320)}')" onclick="ClickHref('{$clsSlide->getUrl($listSlide[i].slide_id)}');">
				{if $slide_text ne ''}<div class="titleSlide">{$slide_text}</div>{/if}
				</div>
				{else}
				<div id="slide-main0{$smarty.section.i.index}" class="swiper-slide bg-check" style="background-image:url('{$clsSlide->getImage($listSlide[i].slide_id,1600,668)}')" onclick="ClickHref('{$clsSlide->getUrl($listSlide[i].slide_id)}');">
				{if $slide_text ne ''}<div class="titleSlide">{$slide_text}</div>{/if}
				</div>
				{/if}
				{/section}
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
			<p class="text_find hidden-xs hidden-sm" style="text-align:center;">{$core->get_Lang('Find your special tour today')}</p>
			<div class="search_home_page">
				{$core->getBlock('find_trip_details')}
			</div>
		</div>
	</div>
	{/if}
	{/if}
</div>
{/if}
{literal}
<style type="text/css">
.slide-main{position:relative;height:calc(100vh - 114px); overflow:hidden}
.slide-main .swiper-container{position:absolute;top:0;left:0;width:100%;height:100%}
.slide-main .swiper-slide{background-size:cover;background-color:#111; position:relative; background-position:center center; background-repeat:no-repeat;}
.swiper-slide .text_slide{position:absolute; left:50%; top:45%; z-index:1; color:#fff; font-size:30px; width:100%; max-width:500px;}
.titleSlide{position:absolute; bottom:0; right:20px; display:inline-block; padding:0 10px; line-height:24px; color:#fff; background:rgba(0,0,0,0.6)}
.swiper-container{margin-left:auto;margin-right:auto;position:relative;overflow:hidden;z-index:1}
.swiper-container-no-flexbox .swiper-slide{float:left}
.swiper-container-vertical > .swiper-wrapper{-webkit-box-orient:vertical;-moz-box-orient:vertical;-ms-flex-direction:column;-webkit-flex-direction:column;flex-direction:column}
.swiper-wrapper{position:relative;width:100%;height:100%;z-index:1;display:-webkit-box;display:-moz-box;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-transition-property:-webkit-transform;-moz-transition-property:-moz-transform;-o-transition-property:-o-transform;-ms-transition-property:-ms-transform;transition-property:transform;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box}
.swiper-container-android .swiper-slide,.swiper-wrapper{-webkit-transform:translate3d(0px,0,0);-moz-transform:translate3d(0px,0,0);-o-transform:translate(0px,0px);-ms-transform:translate3d(0px,0,0);transform:translate3d(0px,0,0)}
.swiper-container-multirow > .swiper-wrapper{-webkit-box-lines:multiple;-moz-box-lines:multiple;-ms-flex-wrap:wrap;-webkit-flex-wrap:wrap;flex-wrap:wrap}
.swiper-container-free-mode > .swiper-wrapper{-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-ms-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out;margin:0 auto}
.swiper-slide{-webkit-flex-shrink:0;-ms-flex:0 0 auto;flex-shrink:0;width:100%;height:100%;position:relative}
.swiper-container-autoheight,.swiper-container-autoheight .swiper-slide{height:auto}
.swiper-container-autoheight .swiper-wrapper{-webkit-box-align:start;-ms-flex-align:start;-webkit-align-items:flex-start;align-items:flex-start;-webkit-transition-property:-webkit-transform,height;-moz-transition-property:-moz-transform;-o-transition-property:-o-transform;-ms-transition-property:-ms-transform;transition-property:transform,height}
.swiper-container .swiper-notification{position:absolute;left:0;top:0;pointer-events:none;opacity:0;z-index:-1000}
.swiper-wp8-horizontal{-ms-touch-action:pan-y;touch-action:pan-y}
.swiper-wp8-vertical{-ms-touch-action:pan-x;touch-action:pan-x}
.swiper-button-prev,.swiper-button-next{position:absolute;top:50%;width:27px;height:44px;margin-top:-22px;z-index:10;cursor:pointer;-moz-background-size:27px 44px;-webkit-background-size:27px 44px;background-size:27px 44px;background-position:center;background-repeat:no-repeat;}
.swiper-button-prev.swiper-button-disabled,.swiper-button-next.swiper-button-disabled{opacity:.35;cursor:auto;pointer-events:none}
.swiper-container-fade .swiper-slide{pointer-events:none;-webkit-transition-property:opacity;-moz-transition-property:opacity;-o-transition-property:opacity;transition-property:opacity}
.swiper-container-fade .swiper-slide .swiper-slide{pointer-events:none}
.swiper-container-fade .swiper-slide-active,.swiper-container-fade .swiper-slide-active .swiper-slide-active{pointer-events:auto}
.swiper-zoom-container{width:100%;height:100%;display:-webkit-box;display:-moz-box;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-pack:center;-moz-box-pack:center;-ms-flex-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-moz-box-align:center;-ms-flex-align:center;-webkit-align-items:center;align-items:center;text-align:center}
.swiper-zoom-container > img,.swiper-zoom-container > svg,.swiper-zoom-container > canvas{max-width:100%;max-height:100%;object-fit:contain}
.swiper-scrollbar{border-radius:10px;position:relative;-ms-touch-action:none;background:rgba(0,0,0,0.1)}
.swiper-container-horizontal > .swiper-scrollbar{position:absolute;left:1%;bottom:3px;z-index:50;height:5px;width:98%}
.swiper-container-vertical > .swiper-scrollbar{position:absolute;right:3px;top:1%;z-index:50;width:5px;height:98%}
@-webkit-keyframes swiper-preloader-spin {
100%{-webkit-transform:rotate(360deg)}
}
@keyframes swiper-preloader-spin {
100%{transform:rotate(360deg)}
}
.u-visible-xxs,.u-visible-xs,.u-visible-sm,.u-visible-md,.u-visible-lg{display:none!important}
.u-visible-xs{display:none !important}
.width1250{width:100%; max-width:1250px !important}
.swiper-button-prev,.swiper-button-next{
	position: absolute;
    width: 28px;
    height: 28px;
    box-sizing: border-box;
}
.swiper-button-prev{
    left: 100px;
	border-left: 1px solid #fff;
    border-top: 1px solid #fff;
	transform: rotate(-45deg);
}
.swiper-button-next{
    right: 100px;
	border-right: 1px solid #fff;
    border-bottom: 1px solid #fff;
	transform: rotate(-45deg);
}

@media (max-width: 767px) {
.slide-main {
    height:480px;
}
}
@media (max-width: 600px) {
.slide-main {
    height:320px;
}
.swiper-button-prev{
    left: 10px;
}
.swiper-button-next{
    right: 10px;
}
}
@media (max-width: 479px) {
.slide-main {
    height:275px;
}
}
@media (max-width: 360px) {
.slide-main {
    height:250px;
}
}
</style>
{/literal}

{literal}
<script type="text/javascript">
	var swiper = new Swiper('.slide-main .swiper-container', {
		slidesPerView: 1,
		effect: 'fade',
		speed: 1000,
		autoplay: 3000,
		//autoplayDisableOnInteraction: false,
		nextButton: '.slide-main .swiper-button-next',
        prevButton: '.slide-main .swiper-button-prev',
	});
</script>
{/literal}