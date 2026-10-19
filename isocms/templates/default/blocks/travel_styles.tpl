{if $lstToursCategory}
<div class="boxCatTours"> 
	{if $parentID gt '0'}
	<h2 class="head">{$clsTourCategory->getTitle($parentID)}</h2>
	{else}
	<h2 class="head">{$core->get_Lang('Travel styles')}</h2>
	{/if}
	<ul> 
		{section name=i loop=$lstToursCategory}
		<li {if $cat_id eq $lstToursCategory[i].tourcat_id}class="active"{/if}><a href="{$clsTourCategory->getLink($lstToursCategory[i].tourcat_id)}" title="{$clsTourCategory->getTitle($lstToursCategory[i].tourcat_id)}">{$clsTourCategory->getTitle($lstToursCategory[i].tourcat_id)}</a></li>
		{/section}
 </ul> 
</div>
{/if}



