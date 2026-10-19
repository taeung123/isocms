{if $list_combo_related}
<section id="related__Box" class="related__Box">
	<div class="container">
		<div class="head__Box">
			<h2 class="title_headBox">{$core->get_Lang('Combo không thể bỏ lỡ')}!</h2>
		</div>
		<div class="box_slider_tour">
			<div class="owl-carousel owl_carousel_4_item" >
				{foreach from=$list_combo_related item=v}
				{assign var=combo_id value=$v}
				{$clsISO->getBlock('box_item_combo_list',["combo_id"=>$combo_id])}
				{/foreach}
			</div>
		</div>
	</div>
</section>
{/if}
