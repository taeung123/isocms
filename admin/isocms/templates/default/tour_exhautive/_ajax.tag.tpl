<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header version-xs">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">{$core->get_Lang('Tags')}</h4>
		</div>
		<form method="post" id="frmItinerary" class="frmform" enctype="multipart/form-data">
			<div class="modal-body version-xs">
				<div class="form-group">
					<label class="col-form-label">Tag</label>
					<input type="text" class="form-control titleTag" name="title" placeholder="Tag" value="" />
				</div>
			</div>
			<div class="modal-footer version-xs">
				<button type="button" class="btn btn-primary ajSaveTag" tour_id="{$tour_id}">
					<span>{$core->get_Lang('Save')}</span>
				</button>
			</div>
		</form>
	</div>
</div>