{if $lstWhy}
<div class="boxRightCol bg_fff pd1510 mb20">
	<div class="boxWhyCol">
		<h3>{$core->get_Lang('Why book with us')}?</h3>
		<ul class="listWhy">
			{section name=i loop=$lstWhy}
			<li>{$clsWhy->getTitle($lstWhy[i].why_id,$lstWhy[i])}</li>
			{/section}
		</ul>
		<a href="{$clsISO->getLink('why')}" target="_blank" class="more color_d19d37" style="float:right">{$core->get_Lang('View more')} >></a>
	</div>
</div>
{/if}
 {literal} 
 <script>
	document.addEventListener("DOMContentLoaded", function () {
		$(".widget-tit").click(function(){
			$(this).closest(".widget-book-us").find(".h-w-body").slideToggle();	
		});
	})
 </script>
 {/literal} 