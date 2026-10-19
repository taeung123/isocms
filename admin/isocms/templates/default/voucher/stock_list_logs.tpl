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