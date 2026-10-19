{assign var=title_country_cat value=$clsCountryEx->getTitle($country_id)}
<div class="page_container">
	<nav class="breadcrumb-main breadcrumb-{$mod} mb30 bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs bg_fff mt0" itemscope itemtype="https://schema.org/BreadcrumbList"> 
			   <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				   <a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
			   <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				   <a itemprop="item" href="{$curl}" title="{$core->get_Lang('Travel styles')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Travel styles')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			   {if $show eq 'CatCountry'}
			   <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				   <a itemprop="item" href="{$clsCountryEx->getLink($country_id)}" title="{$title_country_cat}">
					   <span itemprop="name" class="reb">{$title_country_cat}</span></a>
					<meta itemprop="position" content="3" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
				  <a itemprop="item" href="{$curl}" title="{$title_cat}">
					  <span itemprop="name" class="reb">{$title_cat}</span></a>
				   <meta itemprop="position" content="4" />
			   </li>
			   {else}
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
				  <a itemprop="item" href="{$curl}" title="{$title_cat}">
					  <span itemprop="name" class="reb">{$title_cat}</span></a>
				   <meta itemprop="position" content="3" />
			   </li>
			   {/if}
			</ol>
		</div>
	</nav>
	<div id="ContentPage" class="maincontent pd50_0">
		<section class="introPage">
			<div class="container">
			{if $show eq 'CatCountry'}
				{assign var=contentMoreCatCountry value=$clsCategory_Country->getContent($category_country__id,500,true,$catCountryItem)}
				<h1>{$title_country_cat} - {$title_cat}</h1>
				{if $contentMoreCatCountry}
				<div class="intro_cat mb30">
					{$contentMoreCatCountry}
				</div>
				{/if}
			{else}
				<h1>{$title_cat}</h1>
				{assign var=introMoreCat value=$clsTourCategory->getIntroMore($cat_id,400,true,$oneItem)}
				{if $introMoreCat}
				<div class="intro_cat mb30">
					{$introMoreCat}
				</div>
				{/if}
			{/if}
			</div>
		</section>
        {if $listTour || $action=='search'}
		<section class="contentPage padding50_0">
			<div class="container">
				<div class="row">
					<div class="col-lg-3">
                      	<div class="block991" style="display:none">
							<div class="tag-search">
								<div class="btn_open_modal btn_quick_search bg_main" data-bs-toggle="modal" data-bs-target="#filter_search" >
									<span>{$core->get_Lang('Filter Trip')}</span> <i class="fa fa-sliders" aria-hidden="true"></i>
								</div>
							</div>
						</div> 
						<div class="modal fade" id="filter_search" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="filter_left">
										<div class="modal-header">
											<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">X</span><span class="sr-only">{$core->get_Lang('Close')}</span></button> {$core->get_Lang('Search')}
										</div>
										<div class="modal-body">
											<div class="totalTour mb20">
											   <h2 class="totalTourpage bg_main h3">{$core->get_Lang('Find')} {$totalTour} {if $totalTour gt 1}{$core->get_Lang('Tours')}{else}{$core->get_Lang('Tour')}{/if}</h2>
											</div>
											{$core->getBlock('filter_left_trip')}
										</div>
									</div>
								</div>
							</div>
						</div>
                  	</div>
					<div class="col-lg-9">
						<div class="loader"></div>
                            {if $show =='CatCountry'}
                            {assign var=lstCountryCat value=$clsCategory_Country->getListCatCountry($country_id)}
								<div class="box_scroll">
									<div class="list_tour_cat">
										{section name=j loop=$lstCountryCat}
											{assign var=oneCategoryCountry value=$clsTourCategory->getOne($lstCountryCat[j].cat_id,'title,slug')}
											{assign var=title_category_country value=$oneCategoryCountry.title}
											<div class="item_tour_cat {if $lstCountryCat[j].cat_id==$cat_id}active{/if}">
												<a href="{$clsTourCategory->getLinkCatCountry($lstCountryCat[j].cat_id,$country_id,$oneCategoryCountry)}"
												   title="{$title_category_country}">{$title_category_country}
												</a>
											</div>
										{/section}
									</div>
								</div>
                            {else}
								<div class="box_scroll">
									<div class="list_tour_cat">
										{section name=j loop=$lstCatTour}
											{assign var=title_category value=$lstCatTour[j].title}
											<div class="item_tour_cat {if $lstCatTour[j].tourcat_id==$cat_id}active{/if}">
												<a title="{$title_category}" href="{$clsTourCategory->getLink($lstCatTour[j].tourcat_id,$lstCatTour[i])}">{$title_category}
												</a>
											</div>
										{/section}
									</div>
								</div>
                            {/if}
                        
							<div class="listTour listTourItem search-results js-search-results row">
								{section name=i loop=$listTour}
								<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
								{assign var=tour_id value=$listTour[i].tour_id}
								{assign var=oneTour value=$listTour[i]}
								{$clsISO->getBlock('box_item_tour_mobile',["tour_id"=>$tour_id,"oneTour"=>$oneTour])}
								</div>
								{/section}                        
							</div>
							{if $totalPage gt '1'}
							<div class="clearfix"></div>
							<div class="pagination pager">
								{$page_view}
							</div>
							{/if}         
						</div>
					</div>
				</div>
			</div>
		</section>
        {/if}
	</div>
</div>

{literal}
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			$(document).ready(function (){
				var container = $(".list_tour_cat .item_tour_cat.active");
				$('.box_scroll').animate({
					scrollLeft: container.position().left - 10
				});
			});
		})
	</script>
{/literal}
