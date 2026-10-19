<div class="row">
	{section name=i loop=$lstCatTour max=3}
	{assign var=getTitle value=$lstCatTour[i].title}
	{assign var=getLink value=$clsTourCategory->getLink($lstCatTour[i].tourcat_id)}
	<div class="col-md-4 col-sm-4 box">
		<div class="catItem">
			<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="lazy img100" src="{$clsConfiguration->getImage('default_image_pixel',501,277)}" data-src="{$clsTourCategory->getImage($lstCatTour[i].tourcat_id,501,277)}"/></a>
			<div class="spotlight">
			<h3><a href="{$getLink}" title="{$getTitle}">{$getTitle}</a></h3>
			{assign var=number_tour_by_cat value=$clsTourCategory->countItemInCat($lstCatTour[i].tourcat_id)}
			{if $number_tour_by_cat}
			<p class="mb0">{$number_tour_by_cat} {$core->get_Lang('tours found')}</p>
			{/if}
			</div>
		</div>
	</div>
	{/section}
</div>
<div class="row">
	{section name=i loop=$lstCatTour start=3 max=2}
	{assign var=getTitle value=$lstCatTour[i].title}
	{assign var=getLink value=$clsTourCategory->getLink($lstCatTour[i].tourcat_id)}
	<div class="col-md-6 col-sm-6 box">
		<div class="catItem">
			<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="lazy img100" src="{$clsConfiguration->getImage('default_image_pixel',767,425)}" data-src="{$clsTourCategory->getImage($lstCatTour[i].tourcat_id,767,425)}"/></a>
			<div class="spotlight">
			<h3 class=" mb10"><a href="{$getLink}" title="{$getTitle}">{$getTitle}</a></h3>
			{assign var=number_tour_by_cat value=$clsTourCategory->countItemInCat($lstCatTour[i].tourcat_id)}
			{if $number_tour_by_cat}
			<p class="mb05">{$number_tour_by_cat} {$core->get_Lang('tours found')}</p>
			{/if}
			</div>
		</div>
	</div>
	{/section}
</div>