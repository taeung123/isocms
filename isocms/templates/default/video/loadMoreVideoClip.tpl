{section name=i loop=$lstVideoClip}
<div class="col-md-4 col-sm-6 col-xs-6 full_width_600 mb20 box_append">
	<div class="VideoItem">
		<a class="venobox_video relative" data-gall="gall-video" data-autoplay="false" data-vbtype="video" href="{$clsVideo->getLinkVideo($lstVideoClip[i].video_id)}">
		<img src="{$clsVideo->getImage($lstVideoClip[i].video_id,360,240)}" width="100%" height="auto" />
		<i class="icon icon_play_video"></i>
		</a>
		<h3 class="title_video"><a class="venobox_video" data-gall="gall-video" data-autoplay="false" data-vbtype="video" href="{$clsVideo->getLinkVideo($lstVideoClip[i].video_id)}">{$clsVideo->getTitle($lstVideoClip[i].video_id)}</a></h3>
	</div>
</div>
{/section}