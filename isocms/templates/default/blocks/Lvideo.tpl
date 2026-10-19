{section name=i loop=$lstVideoCruise}
<div class="modal fade in" id="videoModal{$lstVideoCruise[i].cruise_video_id}" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-full" role="document" style="width: 1140px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close z_16 video-close" data-dismiss="modal" aria-label="Close"><span class="hidden-xs">CLOSE</span> <span aria-hidden="true" class="fa fa-times z_18"></span></button>
                <h4 class="modal-title" id="videoModalLabel"></h4>
            </div>
            <div class="modal-body" style="width:100% !important">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" id="playvideo" src="{$clsCruiseVideo->getLink($lstVideoCruise[i].cruise_video_id)}?autoplay=1"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
{/section}