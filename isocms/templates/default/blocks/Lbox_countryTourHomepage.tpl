<div class="boxTravelStyle bg_edf0f0">
	<div class="container">
		<div class="title text_center mb30">
			<p class="color_main text_upper mb10">{$core->get_Lang('EXPLORE THE WORLD')}!</p>
			<h2 class="h2_title size24 mb10 text_bold">{$core->get_Lang('See what is trending now')}!</h2>
		</div>
		<div class="transitions-enabled" id="listTravelStyle">
		{assign var=totalTourCategory value=$lstCatTour|@count}
		{section name=i loop=$lstCatTour max=5}
		{assign var=getTitle value=$lstCatTour[i].title}
		{assign var=getLink value=$clsTourCategory->getLink($lstCatTour[i].tourcat_id)}
		{assign var=getImageRand value=$clsTourCategory->getImageRand($lstCatTour[i].tourcat_id,$smarty.section.i.iteration)}
		{if $smarty.section.i.iteration eq '1'}
		<div class="col-md-5 col-sm-5 col-xs-12">
			<div class="catItem catItem1">
			<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="base_image" src="{$getImageRand}" {$smarty.section.i.iteration} width="100%" height="auto"/></a>
			<p class="spotlight mb0"><a href="{$getLink}">{$getTitle}</a></p>
			</div>
		</div>
		{elseif $smarty.section.i.iteration eq '2'}
		<div class="col-md-2 col-sm-2 col-xs-2">
			<div class="catItem catItem2 mb10">
			<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="base_image" src="{$getImageRand}" {$smarty.section.i.iteration} width="100%" height="auto"/></a>
			<p class="spotlight mb0"><a href="{$getLink}">{$getTitle}</a></p>
			</div>
			{elseif $smarty.section.i.iteration eq '3'}
			<div class="catItem catItem3">
			<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="base_image" src="{$getImageRand}" {$smarty.section.i.iteration} width="100%" height="auto"/></a>
			<p class="spotlight mb0"><a href="{$getLink}">{$getTitle}</a></p>
			</div>
		</div>
		{elseif $smarty.section.i.iteration eq '4'}
		<div class="col-md-5 col-sm-5 col-xs-5">
			<div class="catItem catItem4 mb10">
			<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="base_image" src="{$getImageRand}" {$smarty.section.i.iteration} width="100%" height="auto"/></a>
			<p class="spotlight mb0"><a href="{$getLink}">{$getTitle}</a></p>
			</div>
			{elseif $smarty.section.i.iteration eq '5'}
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="catItem catItem5">
						<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="base_image" src="{$getImageRand}" {$smarty.section.i.iteration} width="100%" height="auto"/></a>
						<p class="spotlight mb0"><a href="{$getLink}">{$getTitle}</a></p>
					</div>
				</div>
				{if $totalTourCategory gt 5}
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="catItem catItem6">
						<a title="{$core->get_Lang('Travel Styles')}"><img alt="{$core->get_Lang('Travel Styles')}" class="base_image" src="{$clsTourCategory->getBgTravelStyle()}" width="100%" height="auto"/></a>
						<div class="spotlight">
							<p class="intro"><span class="numberCatTour">+{$totalTourCategory-5}</span> {$core->get_Lang('Travel Styles')}</p>
							<ul class="listTravelStyle2" style="display:none">
								{section name=j loop=$lstCatTour start=5}
								{assign var=getTitle2 value=$lstCatTour[j].title}
								{assign var=getLink2 value=$clsTourCategory->getLink($lstCatTour[j].tourcat_id)}
								<li><span class="fa fa-angle-right mr-5"></span> <a href="{$getLink2}" title="{$getTitle2}">{$getTitle2}</a></li>
								{/section}
							</ul>
						</div>
					</div>
				</div>
				{/if}
			</div>
		</div>
		{/if}
		{/section}
		</div>
	</div>
</div>
