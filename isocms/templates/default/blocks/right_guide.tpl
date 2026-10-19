<div class="sb__cat_guide mb30">	
	{if $listGuideCat}
	<div class="destinationLink">
		{if $_LANG_ID eq 'vn'}
		<p class="size21 text_bold mb10">{$core->get_Lang('Travel Guide')} {if $show eq 'City'}{$clsCity->getTitle($city_id)}{else}{$clsCountryEx->getTitle($country_id)}{/if} </p>
		{else}
		<p class="size21 text_bold mb10">{if $show eq 'City'}{$clsCity->getTitle($city_id)}{else}{$clsCountryEx->getTitle($country_id)}{/if} {$core->get_Lang('Travel Guide')}</p>
		{/if}
		
		<ul>
		{section name=i loop=$listGuideCat}
		{if $clsGuide->countGuideGlobal($country_id, $city_id, $listGuideCat[i].guidecat_id) gt 0}
		<li {if $guidecat_id eq $listGuideCat[i].guidecat_id}class="active"{/if}>
			<a href="{$clsGuideCat->getLinkGuideCountry($listGuideCat[i].guidecat_id, "cat", $country_id)}" title="{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}">{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}
			</a>

{*			<a href="{$clsGuideCat->getLink($country_id,$city_id,$listGuideCat[i].guidecat_id)}" title="{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}">{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}*}
{*			</a>*}
		</li>
		{/if}
		{/section}
		</ul>
	</div>
	{/if}
</div>	
{if $listTourPlace}
<div class="related__Box">
	<p class="size24 mb20">{$core->get_Lang('Tour Related')}</p>
	{section name=i loop=$listTourPlace}
	{assign var=tour_related_id value=$listTourPlace[i].tour_id}
    {assign var=oneTour value=$listTourPlace[i]}
    {$clsISO->getBlock('box_item_tour_mobile',["tour_id"=>$tour_related_id,"oneTour"=>$oneTour])}
	{/section}
</div>
{/if}