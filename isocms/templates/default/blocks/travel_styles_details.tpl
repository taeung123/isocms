{if $lstToursCategory}
<div id="Travel-services">
    {if $parentID gt '0'}
	<h2>{$clsTourCategory->getTitle($parentID)}</h2>
	{else}
	<h2><a href="">{$core->get_Lang('Travel styles')}</a></h2>
	{/if}
    <ul>
    	{section name=i loop=$lstToursCategory max=10}
        <li {if $cat_id eq $lstToursCategory[i].tourcat_id}class="active"{/if}>
        	<h3><a href="{$clsTourCategory->getLink($lstToursCategory[i].tourcat_id)}" title="{$clsTourCategory->getTitle($lstToursCategory[i].tourcat_id)}">{$clsTourCategory->getTitle($lstToursCategory[i].tourcat_id)}</a></h3>
        	{$clsTourCategory->getIntro($lstToursCategory[i].tourcat_id)|truncate:100}<a href="{$clsTourCategory->getLink($lstToursCategory[i].tourcat_id)}" title="{$clsTourCategory->getTitle($lstToursCategory[i].tourcat_id)}">More »</a>
        </li>
        {/section}
    </ul>
</div>
{/if}

