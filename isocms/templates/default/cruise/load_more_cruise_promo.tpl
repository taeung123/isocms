{section name=i loop=$lstCruiseTopPromotion}
{assign var=cruise_item_id value = $lstCruiseTopPromotion[i].cruise_id}
<div class="clear_left_3 col-md-4 col-sm-6 col-xs-6 mt30">
	{$clsISO->getBlock('box_item_cruise_list',["cruise_item_id"=>$cruise_item_id])}
</div>
{/section}