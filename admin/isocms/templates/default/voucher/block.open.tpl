<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> 
			<a href="javascript:void(0);" class="closeEv close_pop close"><span>×</span></a> 
			<h3 class="modal-title"><strong>{$titlePage}</strong></h3>
		</div>
		<form method="post" action="" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="row">
					<div class="form-group">
						<label for="" class="col-form-label text-right col-md-3">{$core->get_Lang('Title')}<span class="text-red">*</span></label>
						<div class="col-md-9">
							<input type="text" class="form-control required" name="title" placeholder="Nhập tiêu đề" value=""/>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-form-label text-right col-md-3">{$core->get_Lang('ShortIntro')}</label>
						<div class="col-md-9">
							<textarea name="intro" rows="5" class="form-control" placeholder="Nhập miêu tả"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success ajSaveNewBlock pull-right">{$core->get_Lang('Save')}</button>
				<button type="button" class="btn btn-default mr-half pull-right" data-dismiss="modal">{$core->get_Lang('Close')}</button>
			</div>
		</form>
	</div>
</div>