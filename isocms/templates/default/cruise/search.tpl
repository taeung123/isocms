<div class="page_container">
  <nav class="breadcrumb-main breadcrumb_page">
      <div class="container">
        <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
          <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			  <a itemprop="item" href="{$PCMS_URL}{$extLang}">
				  <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
				<meta itemprop="position" content="1" />
			</li>
          <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			  <a itemprop="item" href="{$PCMS_URL}{$extLang}">
				  <span itemprop="name" class="reb">{$core->get_Lang('Search Cruise')}</span></a>
				<meta itemprop="position" content="2" />
			</li>
        </ol>
      </div>
    </nav>
  	<section class="cat-list cat-list-cruise">
    	<div class="container">
		<h1 class="mb30">{$core->get_Lang('Results search')} ({$totalRecord} {$core->get_Lang('Results')})</h1>
		{if $lstCruiseSearch gt 0}
		<div class="row" id="home-masonry-container">
			{section name=i loop=$lstCruiseSearch}
			{assign var=_cruise_id value=$lstCruiseSearch[i].cruise_id}
			{assign var=_cruise_itinerary_id value=$lstCruiseSearch[i].cruise_itinerary_id}
			{assign var=_title value=$clsCruiseItinerary->getTitleDay($_cruise_itinerary_id)}
			{assign var=_link value=$clsCruiseItinerary->getLinkPromotion($_cruise_itinerary_id)}
			<div class="box col-lg-4 col-md-6 col-sm-6 it_cruise_best mb20" {if $smarty.section.i.iteration gt '6'} style="display:none"{/if}>
				<div class="it_entry_thumb_cb">
					<a href="{$_link}" title="{$_title}">
						<img class="full-width height-auto" alt="{$_title}" src="{$clsCruise->getImage($_cruise_id,380,250)}" />
					</a>
					<div class="entry_box_title clearfix">
						<h3><a href="{$_link}" title="{$_title}">{$_title}</a></h3>
					</div>
				</div><!--end it_entry_thumb_cb-->
				<div class="it_entry_cruise_body">
					<div class="it_entry_header clearfix">
						<div class="num_day pull-left">
							<p class="number">
								{$clsCruiseItinerary->getOneField('number_day',$_cruise_itinerary_id)}
							</p>
							<span class="day">{$core->get_Lang('Days')}</span>
						</div>
						<div class="city_around pull-left">
							{$clsCruiseItinerary->getAllCityAround($_cruise_itinerary_id)}
						</div>
					</div>
					<div class="it_entry_meta mt10">
						<label class="rate-circle">
							{$clsReviews->getStarNew($_cruise_id,'cruise')} 
						</label>
						<span class="rate_avg">
							{$clsReviews->getRateAVG($_cruise_id,'cruise')}	
						</span>
						<span class="text_review">
							{$clsReviews->getTextRateAVG($_cruise_id,'cruise')} 
						</span>
						{if $clsReviews->getToTalReview($_cruise_id,'cruise') gt 0}
						{$clsReviews->getToTalReview($_cruise_id,'cruise')} {$core->get_Lang('reviews')}
						{/if}
					</div>
					<div class="it_entry_intro">
<!--						{$clsCruise->getAbout($_cruise_id)|strip_tags|truncate:90}-->
						{$clsCruise->getIntro($_cruise_id)|strip_tags|truncate:90}
					</div>
					<div class="it_entry_price_view clearfix mt10">
						<div class="see_detail pull-left">
							<a class="color_333" href="{$_link}" title="{$core->get_Lang('See Detail')}"> 
								{$core->get_Lang('See Detail')}	
							</a>
						</div>	
						<div class="price__box pull-right">
							{$clsCruiseItinerary->getLTripPriceItinerary($_cruise_itinerary_id,$now_month)}
						</div>
					</div>
				</div>
			</div><!--end it_cruise_best-->
			{/section}
		  {if $totalRecord gt '6'}
		   <div class="cleafix"></div>
			<div id="exploreWorldLoadMore">
			  <div id="load_more_collections" class="text-center">
				<div class="loader"></div>
				<a href="javascript:void(0);" rel="nofollow" page="1" class="btn_orance_border show-loader" id="show-more">{$core->get_Lang('LOAD MORE COLLECTIONS')}</a></div>
			</div>  
			{/if}
		</div>
		{/if}
      </div>
    </section>
  </div>
</div>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(function(){
			var $number_per_page = 6;
			var $page = 1;
			$page_aj = 0;

			var timer = '';
			/*loadPage();*/
			$('#show-more').click(function(e) {
				var $totalRecord = $('#home-masonry-container .box').size();
				if($page_aj){
					$page = $page_aj + 1;
					$page_aj=0;	
				}
				else $page = $page + 1;
				e.preventDefault();
				var $this = $(this);
				clearTimeout(timer);
				$('.loader').show();
				timer = setTimeout(function(){
					var $start = ($page-1) * $number_per_page;
					var $end = $start + $number_per_page;

					for(var i = $start; i < $end; i++) {
						$('.box').eq(i).show();
					}

					$('.loader').hide();
					if($end>=$totalRecord)
						$('#show-more').hide();
				}, 500);
			});
			$('.moreH').click(function(){
				if($(this).hasClass('ex')){
					$('#box_3').hide();
					$('#box_4').show();
				}else{
					$('#box_3').show();
					$('#box_4').hide();
				}
			});
		});
	})
</script>
{/literal}
