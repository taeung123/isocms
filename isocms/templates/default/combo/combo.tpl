<div class="page_container">
 	<div class="banner">
 		<img class="img100" src="{$clsConfiguration->getValue('site_combo_page_banner')}" alt="">
 		{assign var = SiteIntroBannerCombo value = SiteIntroBannerCombo_|cat:$_LANG_ID}
 		<div class="content-banner">
 			<h1 class="size40 text-upper">{$clsConfiguration->getValue($SiteIntroBannerCombo)|html_entity_decode}</h1>
 		</div>
 	</div>
    <div id="contentPage" class="ComboPlacePage">
        <div class="container">
			{$core->getBlock('find_search_combo')}
       		<section class="boxWhyCombo">
       			<h2 class="title_cb text-center">{$core->get_Lang('Why should you book a savings combo with isoCMS?')}</h2>
       			<div class="why_list">
       				<div class="owl-carousel" id="why_list_combo">
       					{section name=i loop=$listWhyCombo}
       					{assign var=title value=$clsYearJourney->getTitle($listWhyCombo[i].year_journey_id)}
       					{assign var=link value=$clsYearJourney->getLink($listWhyCombo[i].year_journey_id)}
       					<div class="item">
       						<a class="photo" href="{$link}" title="{$title}">
       							<img class="img100" src="{$clsYearJourney->getImage2($listWhyCombo[i].year_journey_id)}" alt="{$title}">
       						</a>
       						<div class="body">
       							<h3 class="title"><a class="color_1c1c1c" href="{$link}" title="{$title}">{$title}</a></h3>
       							<div class="intro">{$clsYearJourney->getIntro($listWhyCombo[i].year_journey_id)}</div>
       						</div>
       					</div>
       					{/section}
       				</div>
       			</div>
       		</section>
       		<section cite="boxPutCombo">
       			<h2 class="title_cb text-center mb40">{$core->get_Lang('How to order saving combo isoCMS?')}</h2>
       			<div class="put_cb_list">
       			{if $clsISO->getBrowser() eq 'computer'}
       			{section name=i loop=$listPutCombo}
       			{assign var=title value=$clsYearJourney->getTitle($listPutCombo[i].year_journey_id)}
       			{assign var=link value=$clsYearJourney->getLink($listPutCombo[i].year_journey_id)}
					<div class="item">
						<div class="row">
							<div class="line"></div>
							<div class="col-md-5 col-md-offset-1">
								<img class="img100 photo" src="{$clsYearJourney->getImage2($listPutCombo[i].year_journey_id)}" alt="{$title}"> 
							</div>
							<div class="col-md-5">
								<div class="body" data-step="{$smarty.section.i.iteration}">
									<h3 class="title"><a class="color_1c1c1c" href="{$link}" title="{$title}">{$title}</a></h3>
									<p class="intro">{$clsYearJourney->getIntro($listPutCombo[i].year_journey_id)}</p>
								</div>
							</div>
						</div>
					</div>
      			{/section}
      			{else}
      				<div class="owl-carousel" id="list_put_combo">
       					{section name=i loop=$listPutCombo}
       					{assign var=title value=$clsYearJourney->getTitle($listPutCombo[i].year_journey_id)}
       					<div class="item-mb">
       						<a class="photo" href="{$link}" title="{$title}">
       							<img class="img100" src="{$clsYearJourney->getImage($listPutCombo[i].year_journey_id,300,169)}" alt="{$title}">
       						</a>
       						<div class="body">
       							<h3 class="title">{$title}</h3>
       							<div class="intro">{$clsYearJourney->getIntro($listPutCombo[i].year_journey_id)}</div>
       						</div>
       					</div>
       					{/section}
       				</div>
      			{/if}
       			</div>
       		</section>
        </div>
    </div>
</div>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		if($('#why_list_combo').length > 0){
			var $owl = $('#why_list_combo');
			$owl.owlCarousel({
				loop:false,
				nav: false,
				dots:false,
				margin:55,
				autoplay:false,
				responsiveClass:true,
				responsive:{
					0:{
						items:1,
						nav:false
					},
					601:{
						items:2,
						nav:false,
						margin:20,
					},
					800:{
						items:3,
						nav:false,
						margin:20,
					},
					1200:{
						items:4,
						nav:false
					}
				}
			});
		}
		if($('#list_put_combo').length > 0){
			var $owl = $('#list_put_combo');
			$owl.owlCarousel({
				loop:false,
				nav: false,
				dots:false,
				margin:30,
				autoplay:false,
				responsiveClass:true,
				responsive:{
					0:{
						items:1,
						nav:false
					},
					601:{
						items:2,
						nav:false,
						margin:20,
					},
					800:{
						items:3,
						nav:false,
						margin:20,
					},
					1200:{
						items:4,
						nav:false
					}
				}
			});
		}
	})
</script>
{/literal}