{assign var=_link value = $clsCruise->getLink($cruise_item_id,'',$arrCruise)}
{assign var=_title value = $clsCruise->getTitle($cruise_item_id,$arrCruise)}
<div class="item_cruise">
	<a class="photo" href="{$_link}" title="{$_title}">
		<img class="img100" alt="{$_title}" src="{$clsCruise->getImage($cruise_item_id,380,250,$arrCruise)}"/>	
	</a>
	<div class="cruise_body">
		<h3 class="title"><a href="{$_link}" title="{$_title}">{$_title}</a></h3>
		<p class="cruise_star">{$clsCruise->getStarNew($cruise_item_id,$arrCruise)}</p>
		<div class="cruise_intro mb20 text3line">
		{$clsCruise->getAbout($cruise_item_id,$arrCruise)|strip_tags}
		</div>
		<div class="price__box_cruise">
{*		{$clsCruise->getPriceCruiseList($cruise_item_id,$now_month,'list')}*}
			{$clsCruise->getLTripPrice1($cruise_item_id,$now_month,'price_2024')}

		</div>
		<div class="btn_booknow">
			<a href="{$_link}" title="{$core->get_Lang('Book Now')}">{$core->get_Lang('Book Now')}</a>
		</div>
	</div>
</div>
{literal}
	<style>
		.price__box_cruise {
			display: flex;
			gap: 5px;
		}
	</style>
	{/literal}