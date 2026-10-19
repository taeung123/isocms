<div class="sidebar">
	{if $act eq 'detail'}
	{if $lstRelated}
    <div class="servicePopular mb20">
        <p class="size20 text_bold">{$core->get_Lang('Related Post')}</p>
		<ul class="listBlog">
			{section name=i loop=$lstRelated}
				<li><a href="{$clsService->getLink($lstRelated[i].service_id)}" title="{$clsService->getTitle($lstRelated[i].service_id)}">{$clsService->getTitle($lstRelated[i].service_id)}</a></li>
			{/section}
		</ul>
    </div>
	{/if}
	{else}
	{/if}
	{if $lstServiceCategory && $clsISO->getCheckActiveModulePackage($package_id,'service','category','default')}
    <div class="linkDestination mb20">
		<p class="size20 text_bold">{$core->get_Lang('Categories')}</p>
		<ul>
			{section name=i loop=$lstServiceCategory}
			{assign var = title value = $clsServiceCategory->getTitle($lstServiceCategory[i].servicecat_id)}
			<li class="category-link {if $lstServiceCategory[i].servicecat_id eq $servicecat_id} active{/if}"><a href="{$clsServiceCategory->getLink($lstServiceCategory[i].servicecat_id)}" title="{$clsServiceCategory->getTitle($lstServiceCategory[i].servicecat_id)}">{$title}</a></li>
			{/section}
		</ul>
    </div>
	{/if}
	{if $act eq 'detail'}
	{else}
	{if $lstLatestService}
	<div class="servicePopular mb20">
        <p class="size20 text_bold">{$core->get_Lang('Popular Services')}</p>
		<ul class="listBlog">
			{section name=i loop=$lstLatestService}
				<li><a href="{$clsService->getLink($lstLatestService[i].service_id)}" title="{$clsService->getTitle($lstLatestService[i].service_id)}">{$clsService->getTitle($lstLatestService[i].service_id)}</a></li>
			{/section}
		</ul>
    </div>
	{/if}
	{/if}
</div>