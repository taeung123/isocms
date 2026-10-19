<script type="text/javascript" src="{$URL_JS}/store.min.js?v={$upd_version}"></script>
<form method="post" action="" enctype="multipart/form-data">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"> 
				<a href="javascript:void(0);" class="closeEv close_pop close"><span>×</span></a> 
				<h3 class="modal-title"><strong>+ {$core->get_Lang('Warehousing')}</strong></h3>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
						<label for="" class="col-form-label text-right col-md-3">{$core->get_Lang('Code')}<span class="text-red">*</span></label>
						<div class="col-md-9">
							<input type="text" class="form-control w-150px required" name="code" value="{$clsStockIn->genCode($voucher_id)}"/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label for="" class="col-form-label text-right col-md-3">{$core->get_Lang('Quantily')}<span class="text-red">*</span></label>
						<div class="col-md-9">
							<div class="input-group w-150px">
								<input type="number" class="form-control numberonly required" onClick="this.select()" name="quantily" min="0" value="0"/>
								<span class="input-group-addon">{$clsProperty->getTitle($unit_id)}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label for="" class="col-form-label text-right col-md-3">{$core->get_Lang('DateIn')}<span class="text-red">*</span></label>
						<div class="col-md-9">
							<div class="input-group double-input">
								<input type="text" class="form-control required datepicker" readonly name="date_id" value="{$smarty.now|date_format:"%d/%m/%Y"}" placeholder="dd/mm/yyyy" />
								<input type="text" class="form-control required timepicker" name="time_id" value="{$smarty.now|date_format:"%H:%M"}" placeholder="hh:ii" />
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label for="" class="col-form-label text-right col-md-3">{$core->get_Lang('Notes')}</label>
						<div class="col-md-9">
							<textarea name="note" rows="2" class="form-control"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success pull-right" onClick="save_stock_in(this)" voucher_id="{$voucher_id}" stock_id="{$stock_id}" stock_in_id="{$stock_in_id}">{$core->get_Lang('Save')}</button>
				<button type="button" class="btn btn-default mr-half pull-right close_pop" data-dismiss="modal">{$core->get_Lang('Close')}</button>
			</div>
		</div>
	</div>
</form>
{literal}
<style>.ui-datepicker{z-index: 99999!important}.modal-footer{position: relative !important; height: 60px;}.frmPop {background: none !important;box-shadow: 0 0px 0px rgba(0,0,0,0.2) !important;}</style>
<script>
if($('.timepicker:not(.ui-timepicker-input)').length){
	$('.timepicker:not(.ui-timepicker-input)')
		.addClass('ui-timepicker-input').timepicker({
		'step' : 15,
		'timeFormat': 'h:i A',
		'forceRoundTime':true
	});
}
 if($('.datepicker:not(.hasDatepicker)').length){
	$('.datepicker:not(.hasDatepicker)').datepicker({
		'dateFormat': 'dd/mm/yy',
	});
}
</script>
{/literal}