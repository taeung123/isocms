{if $lstCatTour}
<section class="box_home_2019 boxTravelStyle2019">
	<div class="container">
		<div class="title text_center mb30">
			<h2 class="h2_title mb10">{$core->get_Lang('See what is trending now')}!</h2>
			{assign var = SiteBlockCatTour value = SiteBlockCatTour_|cat:$_LANG_ID}
			<div class="intro_box">{$clsConfiguration->getValue($SiteBlockCatTour)|html_entity_decode}</div>
		</div>
		<div class="transitions-enabled" id="listTravelStyle" style="position: relative">
			<div class="row">
				{if $deviceType eq 'phone'}
				{assign var=totalTourCategory value=$lstCatTour|@count}
				{section name=i loop=$lstCatTour max=5}
				{assign var=getTitle value=$lstCatTour[i].title}
				{assign var=getLink value=$clsTourCategory->getLink($lstCatTour[i].tourcat_id)}
				{assign var=getImageRand value=$clsTourCategory->getImage($lstCatTour[i].tourcat_id,200,200)}
				<div class="catItem catItem{$smarty.section.i.iteration}">
					<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="base_image lazy img100" src="{$URL_IMAGES}/pixel.png" data-src="{$getImageRand}"/></a>
					<div class="spotlight">
						<h3 class=" mb10"><a href="{$getLink}" title="{$getTitle}">{$getTitle}</a></h3>
						<p class="mb05">{$clsTourCategory->countItemInCat($lstCatTour[i].tourcat_id)} {$core->get_Lang('tours found')}</p>
					</div>
				</div>
				{/section}
				{if $totalTourCategory gt 5}
				<div class="catItem catItem6">
					<a title="{$core->get_Lang('Travel Styles')}"><img alt="{$core->get_Lang('Travel Styles')}" class="base_image lazy img100" src="{$URL_IMAGES}/pixel.png" data-src="{$clsTourCategory->getBgTravelStyle()}"/></a>
					<div class="other_cat">
						<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span class="numberCatTour">+{$totalTourCategory-5}</span> {$core->get_Lang('Travel Styles')}</a>
						<ul class="dropdown-menu dropdown-other-menu">
							{section name=j loop=$lstCatTour start=5}
							{assign var=getTitle2 value=$lstCatTour[j].title}
							{assign var=getLink2 value=$clsTourCategory->getLink($lstCatTour[j].tourcat_id)}
							<li><a href="{$getLink2}" title="{$getTitle2}"><i class="fa fa-angle-right mr-5"></i>  {$getTitle2}</a></li>
							{/section}
						</ul>
					</div>
				</div>
				{/if}
				{else}
					{assign var=totalTourCategory value=$lstCatTour|@count}
					{section name=i loop=$lstCatTour max=5}
						{assign var=getTitle value=$lstCatTour[i].title}
						{assign var=getLink value=$clsTourCategory->getLink($lstCatTour[i].tourcat_id)}
						{assign var=getImageRand value=$clsTourCategory->getImageRand2019($lstCatTour[i].tourcat_id,$smarty.section.i.iteration)}
						<div class="catItem catItem{$smarty.section.i.iteration}">
							<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="base_image lazy img100" src="{$URL_IMAGES}/pixel.png" data-src="{$getImageRand}"/></a>
							<div class="spotlight">
								<h3 class=" mb10"><a href="{$getLink}" title="{$getTitle}">{$getTitle}</a></h3>
								<p class="mb05">{$clsTourCategory->countItemInCat($lstCatTour[i].tourcat_id)} {$core->get_Lang('tours found')}</p>
							</div>
						</div>
					{/section}
					{if $totalTourCategory eq 6}
						{assign var=getTitle value=$lstCatTour[5].title}
						{assign var=getLink value=$clsTourCategory->getLink($lstCatTour[5].tourcat_id)}
						{assign var=getImageRand value=$clsTourCategory->getImageRand2019($lstCatTour[5].tourcat_id,6)}
						<div class="catItem catItem6">
							<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="base_image lazy img100" src="{$URL_IMAGES}/pixel.png" data-src="{$getImageRand}"/></a>
							<div class="spotlight">
								<h3 class=" mb10"><a href="{$getLink}" title="{$getTitle}">{$getTitle}</a></h3>
								<p class="mb05">{$clsTourCategory->countItemInCat($lstCatTour[5].tourcat_id)} {$core->get_Lang('tours found')}</p>
							</div>
						</div>
					{else}
						<div class="catItem catItem6">
							<a title="{$core->get_Lang('Travel Styles')}"><img alt="{$core->get_Lang('Travel Styles')}" class="base_image lazy img100" src="{$URL_IMAGES}/pixel.png" data-src="{$clsTourCategory->getBgTravelStyle()}"/></a>
							<div class="other_cat">
								<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span class="numberCatTour">+{$totalTourCategory-5}</span> {$core->get_Lang('Travel Styles')}</a>
								<ul class="dropdown-menu dropdown-other-menu">
									{section name=j loop=$lstCatTour start=5}
									{assign var=getTitle2 value=$lstCatTour[j].title}
									{assign var=getLink2 value=$clsTourCategory->getLink($lstCatTour[j].tourcat_id)}
									<li><a href="{$getLink2}" title="{$getTitle2}"><i class="fa fa-angle-right mr-5"></i>  {$getTitle2}</a></li>
									{/section}
								</ul>
							</div>
						</div>
					{/if}
				{/if}
			</div>
		</div>
	</div>
	{literal}
	<script>
	$(function () {
		var h_spot_l = $("#listTravelStyle").outerHeight();
		$(".listTravelStyle2").css("top",h_spot_l+"px")
	})
	$('.list_travel_style_cattour').click(function(){
		if($(this).hasClass('open')){
			$('.listTravelStyle2').hide();
			$(this).removeClass('open');
		}else{
			$('.listTravelStyle2').show();
			$(this).addClass('open');
		}
	});
	</script>
	{/literal}
</section>
{/if}