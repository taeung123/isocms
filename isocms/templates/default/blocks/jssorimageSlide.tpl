<script type="text/javascript" src="{$URL_JS}/jssor/jssor.slider.min.js?v={$upd_version}"></script>
{literal}
<script>
	jssor_slider1_init = function () {
		var options = {
			$AutoPlay: 1,
			$Idle: 4000,
			$SlideDuration: 500,
			$DragOrientation: 3,
			$UISearchMode: 0,
			$ThumbnailNavigatorOptions: {
				$Class: $JssorThumbnailNavigator$,
				$ChanceToShow: 2,  
				$Loop: 1, 
				$SpacingX: 3,
				$SpacingY: 3, 
				$Cols: 7,  
				$Align: 253,
				$ArrowNavigatorOptions: {
					$Class: $JssorArrowNavigator$,
					$ChanceToShow: 2, 
					$Steps: 7 
				}
			}
		};
		var jssor_slider1 = new $JssorSlider$('slider1_container', options);
		function ScaleSlider() {
			var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
			if (parentWidth)
				jssor_slider1.$ScaleWidth(Math.min(parentWidth, 848));
			else
				$Jssor$.$Delay(ScaleSlider, 30);
		}
		ScaleSlider();
		$Jssor$.$AddEvent(window, "load", ScaleSlider);

		$Jssor$.$AddEvent(window, "resize", ScaleSlider);
		$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
	};
</script>
{/literal}
{if $mod eq 'tour'}
<div id="slider1_container" style="position: relative; width: 848px;
	height: 480px; overflow: hidden;">
	{if $lstImage[0].tour_image_id ne ''}
	<div class="tab-expand text-center hidden992">{section name=i loop=$lstImage}<a class="color_fff photo venobox" data-gall="myGallery" href="{$clsTourImage->getImage($lstImage[i].tour_image_id,750,500)}" title="{$clsTourImage->getTitle($lstImage[i].tour_image_id)}">{if $smarty.section.i.first}<span class="color_fff fa fa-expand z_18"></span>{/if}</a>{/section}</div>
	{literal}
	<script type="text/javascript">
		$(function(){
			$('.venobox').venobox({
				framewidth: '750px',    
				border: '5px',       
				bgcolor: '#fff', 
				numeratio: true,       
				infinigall: true    
			});
		});
	</script>
	{/literal}
	{/if}
	<div data-u="loading" style="position:absolute;top:0px;left:0px;background:url('../img/loading.gif') no-repeat 50% 50%; background-color: rgba(0, 0, 0, .7);"></div>
	<div u="slides" style="position: absolute; left: 0px; top: 0px; width: 848px; height: 480px;
		overflow: hidden;">
		<div>
			<img u="image" class="imageReponsive"  src="{$clsTour->getImage($tour_id,848,565)}" alt="" width="100%" height="auto">
			<img u="thumb" src="{$clsTour->getImage($tour_id,86,54)}" width="100%" height="auto" alt="">
		</div>
		{section name=i loop=$lstImage}
		<div>
			<img u="image" class="imageReponsive"  src="{$clsTourImage->getImage($lstImage[i].tour_image_id,848,565)}" width="100%" height="auto" />
			<img u="thumb" src="{$clsTourImage->getImage($lstImage[i].tour_image_id,86,54)}" width="100%" height="auto" />
		</div>
		{/section}		
	</div>
	<div u="thumbnavigator" class="jssort07" style="width: 848px; height: 100px; left: 0px; bottom: 0px;">
		<div u="slides" style="cursor: default;">
			<div u="prototype" class="p">
				<div u="thumbnailtemplate" class="i"></div>
				<div class="o"></div>
			</div>
		</div>
		<div data-u="arrowleft" class="jssora051" style="width:40px;height:40px;top:123px;left:8px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
			<svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
				<polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
			</svg>
		</div>
		<div data-u="arrowright" class="jssora051" style="width:40px;height:40px;top:123px;right:8px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
			<svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
				<polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
			</svg>
		</div>
	</div>
</div>
{else}
<div id="slider1_container" style="position: relative; width: 848px;
	height: 480px; overflow: hidden;">
	{if $lstImage[0].tour_image_id ne ''}
	<div class="tab-expand text-center hidden992">{section name=i loop=$lstImage}<a class="color_fff photo venobox" data-gall="myGallery" href="{$clsCruiseImage->getImage($lstImage[i].cruise_image_id,750,500)}" title="{$clsCruiseImage->getTitle($lstImage[i].cruise_image_id)}">{if $smarty.section.i.first}<span class="color_fff fa fa-expand z_18"></span>{/if}</a>{/section}</div>
	{literal}
	<script type="text/javascript">
		$(function(){
			$('.venobox').venobox({
				framewidth: '750px',    
				border: '5px',       
				bgcolor: '#fff', 
				numeratio: true,       
				infinigall: true    
			});
		});
	</script>
	{/literal}
	{/if}
	<div data-u="loading" style="position:absolute;top:0px;left:0px;background:url('../img/loading.gif') no-repeat 50% 50%; background-color: rgba(0, 0, 0, .7);"></div>
	<div u="slides" style="position: absolute; left: 0px; top: 0px; width: 848px; height: 480px;
		overflow: hidden;">
		{if $lstVideoCruise}
		<div>
			{section name=i loop=$lstVideoCruise}
			<a class="full-width venobox_video {if $smarty.section.i.first} owl-play{/if}" data-gall="gall-video" data-autoplay="false" data-vbtype="video" href="{$clsCruiseVideo->getLinkVideo($lstVideoCruise[i].cruise_video_id)}">
			</a>
			{/section}
			<img u="image"  src="{$clsCruise->getImage($cruise_id,848,565)}" alt="">
			<img u="thumb" src="{$clsCruise->getImage($cruise_id,88,59)}" alt="">
		</div>
		{literal}
		<script type="text/javascript">
		$(function(){
			$('.venobox_video').venobox({    
			border: '5px',       
			bgcolor: '#fff', 
			numeratio: true,       
			infinigall: true    
			});
		});
		</script>
	{/literal}
	{else}
	<div>
	<img u="image"  src="{$clsCruise->getImage($cruise_id,848,565)}" alt="">
	<img u="thumb" src="{$clsCruise->getImage($cruise_id,88,59)}" alt="">
	</div>
	{/if}
	{section name=i loop=$lstImage}
	<div>
		<img u="image" src="{$clsCruiseImage->getImage($lstImage[i].cruise_image_id,848,565)}" />
		<img u="thumb" src="{$clsCruiseImage->getImage($lstImage[i].cruise_image_id,88,59)}" />
	</div>
	{/section}						
	</div>
	<div u="thumbnavigator" class="jssort07" style="width: 848px; height: 100px; left: 0px; bottom: 0px;">
		<div u="slides" style="cursor: default;">
			<div u="prototype" class="p">
				<div u="thumbnailtemplate" class="i"></div>
				<div class="o"></div>
			</div>
		</div>
		<div data-u="arrowleft" class="jssora051" style="width:40px;height:40px;top:123px;left:8px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
			<svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
				<polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
			</svg>
		</div>
		<div data-u="arrowright" class="jssora051" style="width:40px;height:40px;top:123px;right:8px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
			<svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
				<polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
			</svg>
		</div>
	</div>
</div>
{/if}
{literal}
<style type="text/css">
	.jssort07 {
		position: absolute;
		width: 800px;
		height: 100px;
	}
	.jssort07 .p {
		position: absolute;
		top: 0;
		left: 0;
		width: 99px;
		height: 66px;
	}
	.jssort07 .i {
		position: absolute;
		top: 0px;
		left: 0px;
		width: 99px;
		height: 66px;
		filter: alpha(opacity=80);
		opacity: .8;
	}
	.jssort07 .p:hover .i, .jssort07 .pav .i {
		filter: alpha(opacity=100);
		opacity: 1;
	}
	.jssort07 .o {
		position: absolute;
		top: 0px;
		left: 0px;
		width: 97px;
		height: 64px;
		border: 1px solid #000;
		box-sizing: content-box;
		transition: border-color .6s;
		-moz-transition: border-color .6s;
		-webkit-transition: border-color .6s;
		-o-transition: border-color .6s;
	}
	.jssort07 .pav .o {
		border-color: #0099ff;
	}
	.jssort07 .p:hover .o {
		border-color: #fff;
		transition: none;
		-moz-transition: none;
		-webkit-transition: none;
		-o-transition: none;
	}
	.jssort07 .p.pdn .o {
		border-color: #0099ff;
	}
	* html .jssort07 .o {
		width /**/: 99px;
		height /**/: 66px;
	}
</style>
<style type="text/css">
		.jssora051 {display:block;position:absolute;cursor:pointer;}
		.jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
		.jssora051:hover {opacity:.8;}
		.jssora051.jssora051dn {opacity:.5;}
		.jssora051.jssora051ds {opacity:.3;pointer-events:none;}
	</style>
<script>
	jssor_slider1_init();
</script>
{/literal}