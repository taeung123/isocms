{section name=i loop=$lstAddOnService}
<tr class="{cycle values="row1,row2"}">
	<td class="text-center">
		<input type="checkbox" class="el-checkbox" name="list_service_id[]" {$lstAddOnService[i].check} value="{$lstAddOnService[i].addonservice_id}" {if $clsISO->checkContainer($oneItem.list_service_id,$lstAddOnService[i].addonservice_id)}checked="checked"{/if} />
	</td>
	<td class="index">{$lstAddOnService[i].addonservice_id}</td>
	<td class="text-left">{$clsAddOnService->getTitle($lstAddOnService[i].addonservice_id)}</td>
	<td class="text-right">
		<strong class="format_price">
			{$clsAddOnService->getPrice($lstAddOnService[i].addonservice_id)} {$clsISO->getRate()}
		</strong>
	</td>
	<td align="center" style="vertical-align: middle; text-align:center; width:60px; white-space: nowrap;">
		<div class="btn-group-ico">
			<a class="clickEditAddOnService" title="{$core->get_Lang('edit')}" href="javascript:void(0);" data-combo_id="{$combo_id}" data-addonservice_id="{$lstAddOnService[i].addonservice_id}" ><i class="ico ico-edit"></i></a>
			<a class="clickDeleteAddOnService" title="{$core->get_Lang('delete')}" href="javascript:void(0);" data-combo_id="{$combo_id}" data-addonservice_id="{$lstAddOnService[i].addonservice_id}"><i class="ico ico-remove"></i></a>
		</div>
	</td>
</tr>
{/section}