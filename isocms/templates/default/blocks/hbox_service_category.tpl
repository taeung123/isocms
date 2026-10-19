<div class="h_box_service_category bg_fff">
	{if $mod eq 'service' and $act eq 'detail'} 
	{if $lstRelated[0].service_id}
    <div class="h_onebox_service_category">   
        <h2 class="h-pane-title">{$core->get_Lang('Related Post')}</h2> 
        <ul> 
            {section name=i loop=$lstRelated}
            <li> 
                <h3><a href="{$clsService->getLink($lstRelated[i].service_id)}" title="{$clsService->getTitle($lstRelated[i].service_id)}">{$clsService->getTitle($lstRelated[i].service_id)}</a></h3>	
                {$clsService->getIntro($lstRelated[i].service_id)|truncate:100}
                <a class="viewMore"  href="{$clsService->getLink($lstRelated[i].service_id)}" title="{$clsService->getTitle($lstRelated[i].service_id)}">More »</a> 
            </li>
            {/section}
        </ul> 
    </div>
    {/if}
	{/if}
	<div class="h_onebox_service_category">
    	<h2 class="h-pane-title">
        {$core->get_Lang('Services Category')}
        </h2>
        <ul>
        	{section name=i loop=$lstServiceCategory}
            	<li>
                	<a href="{$clsServiceCategory->getLink($lstServiceCategory[i].servicecat_id)}" title="{$clsServiceCategory->getTitle($lstServiceCategory[i].servicecat_id)}">{$clsServiceCategory->getTitle($lstServiceCategory[i].servicecat_id)}</a>
                </li>
            {/section}
        </ul>
    </div>
    <div class="h_onebox_service_category h_onebox_service_popular mt30">
    	<h2 class="h-pane-title">
        {$core->get_Lang('Popular Services')}
        </h2>
        <ul>
        	{section name=i loop=$lstLatestService}
            	<li>
                	<a href="{$clsService->getLink($lstLatestService[i].service_id)}" title="{$clsService->getTitle($lstLatestService[i].service_id)}">{$clsService->getTitle($lstLatestService[i].service_id)}</a>
                </li>
            {/section}
        </ul>
    </div>
</div>