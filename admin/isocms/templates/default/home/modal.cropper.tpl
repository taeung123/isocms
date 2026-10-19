<div class="modal-dialog modal-md modal_crop_image">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">{$core->get_Lang('Crop image')}</h4>
		</div>
		<div class="cropper-indicator" id="cropper-indicator" style="display: none">
			<div class="md-progress-linear">
				<div class="_md-container _md-mode-indeterminate">
					<div class="_md-dashed"></div>
					<div class="_md-bar _md-bar1"></div>
					<div class="_md-bar _md-bar2"></div>
				</div>
			</div>
		</div>
		<form method="post" id="frmItinerary" class="frmform" enctype="multipart/form-data">
			<div class="modal-body">
				<p class="help-block">Để cắt ảnh kéo vùng dưới hoặc nhập kích thước, sau đó nhấp vào “{$core->get_Lang('Save')}”</p>
				<div class="clearfix"></div>
				<div class="row">
					<div class="col-xs-12 col-md-8">
						<div class="cropper-wrap mb10">
							<img id="cropper" class="img-responsive" src="{$objectUrl}" />
						</div>
					</div>
					<div class="col-xs-12 col-md-4">
						<ul class="ui-cropper-tools">
							<li><a class="ui-cropper-tool" data-method="scaleX" data-option="-1" href="javascript:void(0)">
								{$clsISO->makeIMO('undo','&nbsp;','font-16 mr-2')}
								{$clsISO->makeIMO('redo','&nbsp;','font-16 mr-2')}
								{$core->get_Lang('Rotate left and right')}
							</a></li>
							<li><a class="ui-cropper-tool" data-method="scaleY" data-option="-1" href="javascript:void(0)">
								{$clsISO->makeIMO('undo','','font-16 mr-2','style="transform: rotateZ(-110deg);"')}
								{$clsISO->makeIMO('undo','','font-16 mr-2','style="transform: rotateZ(110deg);"')}
								{$core->get_Lang('Rotate up bottom')}
							</a></li>
							<li>
								<a class="ui-cropper-tool" data-method="rotate" data-option="-45" href="javascript:void(0)">
									{$clsISO->makeIMO('rotate_left','&nbsp;','font-16 mr-2')}</a>
								<a class="ui-cropper-tool" data-method="rotate" data-option="45" href="javascript:void(0)">
									{$clsISO->makeIMO('rotate_right','&nbsp;','font-16 mr-2')}</a>
								{$core->get_Lang('Rotate left right')}</li>
							<li>
								<a class="ui-cropper-tool" data-method="move" data-option="-10" data-second-option="0" href="javascript:void(0)">
									{$clsISO->makeIMO('west','&nbsp;','font-16 mr-2')}</a>
								<a class="ui-cropper-tool" data-method="move" data-option="10" data-second-option="0" href="javascript:void(0)">
									{$clsISO->makeIMO('east','&nbsp;','font-16 mr-2')}</a>
								{$core->get_Lang('Move left right')}</li>
							<li>
								<a class="ui-cropper-tool" data-method="move" data-option="0" data-second-option="-10" href="javascript:void(0)">
									{$clsISO->makeIMO('north','&nbsp;','font-16 mr-2')}</a>
								<a class="ui-cropper-tool" data-method="move" data-option="0" data-second-option="10" href="javascript:void(0)">
									{$clsISO->makeIMO('south','&nbsp;','font-16 mr-2')}</a>
								{$core->get_Lang('Move up down')} </li>
							<li>
								<a class="ui-cropper-tool" data-method="zoom" data-option="0.1" href="javascript:void(0)">
									{$clsISO->makeIcon('search-plus','&nbsp;','font-18 mr-2')}</a>
								<a class="ui-cropper-tool" data-method="zoom" data-option="-0.1" href="javascript:void(0)">
									{$clsISO->makeIcon('search-minus','&nbsp;','font-18 mr-2')}</a>
								{$core->get_Lang('Zoom in out')}</li>
							<li>
								<div class="form-grop">
									<div class="row">
										<div class="col-md-6">
											<label class="col-form-label">Width</label>
											<input type="text" class="form-control numberonly" id="cropper-width" placeholder="width" value="0" readonly />
										</div>
										<div class="col-md-6">
											<label class="col-form-label">Height</label>
											<input type="text" class="form-control numberonly" id="cropper-height" placeholder="height" value="0" readonly />
										</div>
									</div>
								</div>
							</li>
						</ul>
						{if $openFrom eq 'gallery'}
						<textarea class="form-control mb10" name="img_gallery_title" placeholder="Tên ảnh"></textarea>
						{/if}
						<button type="button" class="btn btn-primary ui-cropper-tool" tour_id="{$tour_id}" data-method="getCroppedCanvas">
							<i class="icon-ok icon-white"></i> <span>{$core->get_Lang('Save')}</span>
						</button>
						<button type="reset" class="btn btn-warning" data-dismiss="modal">
							<i class="icon-retweet icon-white"></i> <span>{$core->get_Lang('Close')}</span>
						</button>
						<div class="well mt10">
							<p class="bold mb10">Khuyến nghị</p>
							<p class="mb0">Ảnh cần có độ phân giải cao: tối thiểu 2048 x 1110 pixel, tối đa là: 4000 x 2170 (kích cỡ ảnh tối đa có thể tải lên cho mỗi ảnh là 5MB)
							</p>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
{literal}
<script>
$_document.on('click', '.close:not(.inpopover), button[data-dismiss=modal]', function(){
	var _thispop = $(this).closest(".modal"),
		_id = _thispop.attr("id");
	if(_id !== 'modal'){
		$Core.popup.close(_thispop);
		return false;
	}
});
</script>
{/literal}