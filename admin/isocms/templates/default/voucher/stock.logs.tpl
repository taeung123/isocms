{if $template eq '_manage'}
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header"> 
				<a href="javascript:void(0);" class="closeEv close_pop close"><span>×</span></a> 
				<h3 class="modal-title"><strong>{$core->get_Lang('Logs')} - {$clsVoucher->getTitle($voucher_id)}</strong></h3>
				
			</div>
			<form method="post" action="" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-search form-inline">
						<div class="form-group">
							<div class="double-input input-group">
								<input type="text" id="start_date_stocklogs" data-column="start_date" class="form-control filter_item_stocklogs datepicker" readonly placeholder="{$core->get_Lang('Từ ngày')}">
								<input type="text" id="due_date_stocklogs" data-column="due_date" class="form-control filter_item_stocklogs datepicker" readonly placeholder="{$core->get_Lang('Đến ngày')}">
								<div class="input-group-btn">
									<button type="button" stock_id="{$stock_id}" style="padding:9px 10px;" class="btn btn_search_stocklogs btn-success">{$clsISO->makeIcon('search')}</button>
								</div>
							</div>
						</div>
					</div>
					<div id="holder_stocklogs">Loading...</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default mr-half pull-right close_pop" data-dismiss="modal">{$core->get_Lang('Close')}</button>
				</div>
			</form>
		</div>
	</div>
{elseif $template eq '_list'}
	<table class="table table-vertical m-0 table-striped" width="100%" cellpadding="0" cellspacing="0">
		<thead><tr>
			<th class="text-center" width="5%">No.</th>
			<th width="15%">{$core->get_Lang('Code')}</th>
			<th class="text-right" width="20%">{$core->get_Lang('DateIn')}</th>
			<th class="text-left" width="10%">{$core->get_Lang('Quantily')}</th>
			<th>{$core->get_Lang('Notes')}</th>
		</tr></thead>
		{if $lstStock}
			{section name=i loop=$lstStock}
			<tr>
				<td class="text-center">{$smarty.section.i.iteration}</td>
				<td class="bold">{$lstStock[i].code}</td>
				<td class="text-right">{$clsISO->convertTimeToText($lstStock[i].date_id, true)}</td>
				<td class="text-left">{$lstStock[i].quantily}</td>
				<td>{$lstStock[i].note}</td>
			</tr>
			{/section}
		{else}
			<tr><td colspan="5" class="text-center">
				{$clsISO->renderHTMLNoDocument('Dữ liệu trống')}
			</td></tr>
		{/if}
	</table>
	{if $total_record gt '0'}
	<div class="easyui-pagination" id="pager_stocklogs" pageList="[10,20,30]" pageNumber="{$current_page}"></div>
	{/if}
{/if}
{literal}
<style>.ui-datepicker{z-index: 99999!important}.modal-footer{position: relative !important; height: 60px;}.frmPop {background: none !important;box-shadow: 0 0px 0px rgba(0,0,0,0.2) !important;}</style>
{/literal}
{literal}
<script>
$("#start_date_stocklogs,#due_date_stocklogs").datepicker({
	'dateFormat': "dd-mm-yy",
	changeMonth: true,
	changeYear: true
	}
);
</script>
{/literal}