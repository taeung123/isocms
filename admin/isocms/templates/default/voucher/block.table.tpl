<table class="table table-vertical table-striped" cellpadding="2" cellspacing="2" width="100%" style="margin-bottom: 0">
	<thead><tr>
		<th class="text-center" width="5%">
			<div class="checkbox">
				<input type="checkbox" id="check_all" class="check_all styled" value="1" />
				<label></label>
			</div>
		</th>
		<th class="text-center" width="5%">No.</td>
		<th class="text-center" width="80px">{$core->get_Lang('Image')}</th>
		<th class="text-left">Tiêu đề</th>
		<th class="text-right">Giá bán</th>
		<th class="text-left">Nhóm</th>
		<th class="text-center" style="width:3%;"><i class="icon-circle-arrow-up"></i></th>
		<th class="text-center" style="width:3%;"><i class="icon-circle-arrow-down"></i></th>
		<th class="text-center" style="width:3%;"><i class="icon-arrow-up"></i></th>
		<th class="text-center" style="width:3%;"><i class="icon-arrow-down"></i></th>
		<th class="text-center" style="width:5%;">Action</th>
	</tr></thead>
	<tbody>
	{if $lstItem}
		{section name=i loop=$lstItem}
		<tr>
			<td class="text-center">
				<div class="checkbox">
					<input type="checkbox" name="p_key[]" class="chkitem styled" value="{$lstItem[i].product_store_id}" />
					<label></label>
				</div>
			</td>
			<td class="text-center">{$smarty.section.i.iteration}</td>
			<td class="text-center">
				<a class="aspect-ratio aspect-ratio--square aspect-ratio--square--50 aspect-ratio--interactive" href="{$PCMS_URL}/?mod={$mod}&act=edit&product_id={$core->encryptID($lstItem[i].product_id)}"><img class="aspect-ratio__content" src="{$lstItem[i].image}" width="80px" /></a>
			</td>
			<td class="text-left">
				<a href="{$PCMS_URL}/?mod={$mod}&act=edit&product_id={$core->encryptID($lstItem[i].product_id)}">{$lstItem[i].title}</a>
			</td>
			<td class="text-right">{$clsISO->formatPrice($lstItem[i].price)}</td>
			<td class="text-left">{$clsCategory->getTitle($lstItem[i].cat_id)}</td>
			<td class="text-center">
				{if !$smarty.section.i.first}<a href="javascript:void(0);" onClick="move_product_store(this)" title="Di chuyển xuống lên đầu" for_id="{$for_id}" product_type="{$product_type}" id="{$lstItem[i].product_store_id}" direct="movetop"><i class="icon-circle-arrow-up"></i></a>{/if}
			</td>
			<td class="text-center">
				{if !$smarty.section.i.last}<a href="javascript:void(0);" onClick="move_product_store(this)" title="Di chuyển xuống dưới cùng" for_id="{$for_id}" product_type="{$product_type}" id="{$lstItem[i].product_store_id}" direct="movebottom"><i class="icon-circle-arrow-down"></i></a>{/if}
			</td>
			<td class="text-center">
				{if !$smarty.section.i.first}<a href="javascript:void(0);" onClick="move_product_store(this)" title="Di chuyển lên" for_id="{$for_id}" product_type="{$product_type}" id="{$lstItem[i].product_store_id}" direct="moveup"><i class="icon-arrow-up"></i></a>{/if}
			</td>
			<td class="text-center">
				{if !$smarty.section.i.last}<a href="javascript:void(0);" title="Di chuyển xuống" for_id="{$for_id}" product_type="{$product_type}" id="{$lstItem[i].product_store_id}" onClick="move_product_store(this)" direct="movedown"><i class="icon-arrow-down"></i></a>{/if}
			</td>
			<td class="text-center">
				<button class="btn btn-sm btn-default" for_id="{$for_id}" product_type="{$product_type}" id="{$lstItem[i].product_store_id}" onClick="delete_product_store(this)">{$core->makeIcon('trash')}</button>
			</td>
		</tr>
		{/section}
	{/if}
	</tbody>
</table>
{if $total_record gt '0'}
<div class="easyui-pagination" id="pager_product_store" pageNumber="{$current_page}" pageList="[15,30]"></div>
{/if}
