{foreach from=$list_hotel key=k item=v}
<tr>
<td>{$k}</td>
<td>{$clsHotel->getTitle($k)}</td>
<td>Ngày {foreach from=$v item=item name=item}{$item}{if !$smarty.foreach.item.last}-{/if}{/foreach}</td>
<td align="center" style="vertical-align: middle; text-align:center; width:50px; white-space: nowrap;">
	<div class="btn-group-ico d-flex">
		<a class="clickEditHotelCombo item_left" title="{$core->get_Lang('edit')}" href="javascript:void(0);" data-combo_id="{$combo_id}" data-hotel_id="{$k}" ><i class="ico ico-edit"></i></a>
		<a class="clickDeleteHotelCombo item_right" title="{$core->get_Lang('delete')}" href="javascript:void(0);" data-combo_id="{$combo_id}" data-hotel_id="{$k}"><i class="ico ico-remove"></i></a>
	</div>
</td>
</tr>
{/foreach}

{literal}
<script>

</script>
{/literal}