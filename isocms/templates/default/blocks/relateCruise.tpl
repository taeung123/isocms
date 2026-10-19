{if $lstCruiseOther}
<section class="section_box box_cruise_cd_related">
	<div class="container">
		<div class="headBox">
			<h2 class="title_cruise_box_detail">{$core->get_Lang('Maybe you are interested')}</h2>
		</div>	
		<div class="owl-carousel owl-theme owl_slide_cruise_related mt30">
			{section name=i loop=$lstCruiseOther}
				{assign var=cruise_item_id value = $lstCruiseOther[i].cruise_id}
				{assign var=arrCruise value = $lstCruiseOther[i]}
				{$clsISO->getBlock('box_item_cruise',["cruise_item_id"=>$cruise_item_id,"arrCruise"=>$arrCruise])}
			{/section}
		</div>
	</div>
</section>	
{/if}