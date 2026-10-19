<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')}:</strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('Stock')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
		<h2>{$core->get_Lang('StockManagement')}</h2>
        <p>{$core->get_Lang('This system allows you to stock manage in Systems')}</p>
    </div>
    <div class="clearfix"><br /></div>
    <div class="wrap">
		<table id="list_voucher">
			<thead>
				<tr>
					<th style="width:40px; text-align: center"><input id="check_all" type="checkbox" style="margin-top:5px;" /></th>
					<th style="width: 60px">{$core->get_Lang('Image')}</th>
					<th align="left">{$core->get_Lang('VoucherName')}</th>
					<th style="text-align:left; width:80px"><strong>{$core->get_Lang('SKU')}</strong></th>
					<th style="text-align:left; width:120px"><strong>{$core->get_Lang('Price')}</strong></th>
					<th style="text-align:left; width:120px"><strong>{$core->get_Lang('OutOfStock')}</strong></th>
					<th style="text-align:left; width:120px"><strong>{$core->get_Lang('TotalQuantily')}</strong></th>
					<th style="text-align:left; width:150px"><strong>{$core->get_Lang('InStock')}</strong></th>
					<th style="width:100px; text-align: right"><strong>{$core->get_Lang('Sold')}</strong></th>
					<th style="width: 116px" align="center">{$core->get_Lang('Status')}</th>
					<th style="width: 106px" align="center">{$core->get_Lang('Function')}</th>
				</tr>
			</thead>
			<tbody id="SortAble">
				{section name=i loop=$allItem}
				{assign var = stock_id value = $allItem[i].stock_id}
				{assign var = voucher_id value = $allItem[i].voucher_id}
				<tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].stock_id}" /></td>
					<td class="text-center">
						<a class="aspect-ratio aspect-ratio--square aspect-ratio--square--50 aspect-ratio--interactive" href="{$PCMS_URL}/?mod={$mod}&act=edit&voucher_id={$core->encryptID($allItem[i].voucher_id)}">
							<img class="aspect-ratio__content" src="{$clsVoucher->getImage($allItem[i].voucher_id,60,40)}" width="60" />
						</a>
					</td>
					<td class="text-left">
						<a href="{$PCMS_URL}/?mod={$mod}&act=edit&voucher_id={$core->encryptID($allItem[i].voucher_id)}">{$clsVoucher->getTitle($allItem[i].voucher_id)}</a>
					</td>
					<td class="text-left">{$allItem[i].code}</td>
					<td class="text-right">{$clsISO->priceFormat($allItem[i].price)} {$clsISO->getRate()}</td>
					<td class="text-center">
						{if $allItem[i].continue_order eq 1}
						<span class="label label-success">{$core->get_Lang('ContinueOrder')}</span>
						{else}
						<span class="label label-danger">{$core->get_Lang('StopOrder')}</span>
						{/if}</td>
					<td class="text-left" id="total_in_{$stock_id}_{$voucher_id}">{$allItem[i].total_in}</td>
					<td class="text-left" id="total_quantily_{$stock_id}_{$voucher_id}">{$allItem[i].quantily}</td>
					<td class="text-right">{$allItem[i].total_out}</td>
					<td class="text-center">
						<a href="javascript:void(0);" class="SiteClickLock" toField="is_locked" clsTable="Stock" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" title="{$core->get_Lang('Click to change status')}" rel="{$clsClassTable->getOneField('is_locked',$allItem[i].$pkeyTable)}">
							{if $allItem[i].is_locked eq 0}
							<i class="fa-solid fa-circle-check green"></i>
							{else}
							<i class="fa-solid fa-circle-minus red"></i>
							{/if}
						</a>
					</td>
					<td class="text-center" style="white-space:nowrap;">
						<div class="btn-group">
							<a class="btn iso-button-standard dropdown-toggle"
							href="javascript:void(0);"
							data-bs-toggle="dropdown"
							aria-expanded="false">
								<i class="fa fa-cog"></i>
							</a>

							<ul class="dropdown-menu dropdown-menu-end">

								<li>
									<a class="dropdown-item"
									href="javascript:void(0);"
									onclick="open_stock_in(this);"
									stock_id="{$stock_id}"
									voucher_id="{$voucher_id}"
									title="{$core->get_Lang('Warehousing')}">
										<i class="fa fa-plus"></i>
										{$core->get_Lang('Warehousing')}
									</a>
								</li>

								<li>
									<a class="dropdown-item"
									href="javascript:void(0);"
									onclick="open_stock_logs(this);"
									stock_id="{$stock_id}"
									voucher_id="{$voucher_id}"
									title="{$core->get_Lang('Logs')}">
										<i class="fa fa-file-alt"></i>
										{$core->get_Lang('Logs')}
									</a>
								</li>

							</ul>
						</div>
					</td>
				</tr>
				{/section}
			</tbody>
		</table>
    </div>
</div>
{literal}
<style>
.DataTables_sort_icon{display: none}
</style>
<script>
$(document).ready(function(){
	$('#list_voucher').DataTable({
		columnDefs: [
		  { orderable: false, targets: '_all' }
		]
	});
	$('.dropdown-menu').on('hide.bs.dropdown', function () {
})
});
</script>
{/literal}
<link rel="stylesheet" href="{$URL_JS}/jquery-easyui/themes/gray/easyui.css?v={$upd_version}" type="text/css" media="all" />
<script type="text/javascript" src="{$URL_JS}/jquery-easyui/jquery.easyui.min.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/voucher/js/jquery.voucher.js?v={$upd_version}"></script>