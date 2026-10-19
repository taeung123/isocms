<link rel="stylesheet" href="{$DOMAIN_NAME}/inc/isoman/css/skin.css?v={$upd_version}" type="text/css" media="all">
<script defer type="text/javascript" src="{$DOMAIN_NAME}/inc/isoman/js/jquery.cookie.js?v={$upd_version}"></script>
<script defer type="text/javascript" src="{$URL_JS}/jquery-ui.js?v={$upd_version}"></script>
<script defer type="text/javascript" src="{$DOMAIN_NAME}/inc/isoman/js/man.js?v={$upd_version}"></script>
<script defer type="text/javascript" src="{$URL_JS}/assets/jasny-bootstrap.min.js?v={$upd_version}"></script>
<div class="page_container">
	<nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
			   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
			   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$core->get_Lang('My Wish List')}" >
					   <span itemprop="name" class="reb">{$core->get_Lang('My Wish List')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</nav>
	<section id="contentPage" class="pageMyWishlist pd40_0">
		<div class="container">
			<div class="content-info"> 
				<div class="row">
					{$core->getBlock('box_member_link')}
					<section class="col-md-9 col-xs-12 tabs_content pl0" id="lstTabs" style="border:0 !important">
					<div class="contentTab" style="display:block">
						<div class="row">
							<section class="col-md-8 mb30">
								<div class="wishlist-media">
									<h1 class="title24">{$core->get_Lang('My Wishlist')} <span>({$totlalWishlist})</span></h1>
									{if $lstWishlistHotel}
									<h3>{$core->get_Lang('Hotels Wishlist')}</h3>
									{section name=i loop=$lstWishlistHotel}
									<div class="bookingItem">
										<div class="photo">
											<img src="{$clsHotel->getImage($lstWishlistHotel[i].target_id,193,129)}" class="static" width="90" height="60" alt="{$clsHotel->getTitle($lstWishlistHotel[i].target_id)}" style="height: 60px; width: 90px;">
										</div>
										<div class="body">
											<h3 class="content_blue">
												<a class="hotelLinks" href="{$clsHotel->getLink($lstWishlistHotel[i].target_id)}" title="{$clsHotel->getTitle($lstWishlistHotel[i].target_id)}">{$clsHotel->getTitle($lstWishlistHotel[i].target_id)}</a>
												<img class="star" height="13px" src="{$clsHotel->getHotelStar($lstWishlistHotel[i].target_id)}" /> 
											</h3> 
											{if $clsHotel->getAddress($lstWishlistHotel[i].target_id) ne ''}
												<address>
													<i class="fa fa-map-marker"></i> {$clsHotel->getAddress($lstWishlistHotel[i].target_id)}
												</address>
											 {/if}
											 <span class="inline-block fa fa-trash z_24 h-center remove DeleteWishlist" clsTable='Hotel' id="{$lstWishlistHotel[i].target_id}"></span>
										</div>
									</div>
									{/section}
									{/if}
									{if $lstWishlistTour}
									<h3>{$core->get_Lang('Tour Wishlist')}</h3>
									{section name=i loop=$lstWishlistTour}
									<div class="bookingItem">
										<div class="photo">
											<img src="{$clsTour->getImage($lstWishlistTour[i].target_id,193,129)}" class="static" width="90" height="60" alt="{$clsTour->getTitle($lstWishlistTour[i].target_id)}" style="height: 60px; width: 90px;">
										</div>
										<div class="body">
											<h3 class="content_blue">
												<a class="hotelLinks" href="{$clsTour->getLink($lstWishlistTour[i].target_id)}" title="{$clsTour->getTitle($lstWishlistTour[i].target_id)}">{$clsTour->getTitle($lstWishlistTour[i].target_id)}</a>
												<label class="rate-1">{$clsReviews->getStarNew($lstWishlistTour[i].target_id,tour)}</label>
											</h3> 
											{if $clsTour->getCityAround($lstWishlistTour[i].target_id) ne ''}
												<address><i class="fa fa-map-marker"></i> {$clsTour->getCityAround($lstWishlistTour[i].target_id)}</address>
											 {/if}
											 <span class="inline-block fa fa-trash z_24 h-center remove DeleteWishlist" clsTable='Tour' id="{$lstWishlistTour[i].target_id}"></span>
										</div>
									</div>
									{/section}
									{/if}
									{if $lstWishlistCruise}
									<h3>{$core->get_Lang('Cruise Wishlist')}</h3>
									{section name=i loop=$lstWishlistCruise}
									<div class="bookingItem">
										<div class="photo">
											<img src="{$clsCruise->getImage($lstWishlistCruise[i].target_id,193,129)}" class="static" width="90" height="60" alt="{$clsCruise->getTitle($lstWishlistCruise[i].target_id)}" style="height: 60px; width: 90px;">
										</div>
										<div class="body">
											<h3 class="content_blue">
												<a class="hotelLinks" href="{$clsCruise->getLink($lstWishlistCruise[i].target_id)}" title="{$clsCruise->getTitle($lstWishlistCruise[i].target_id)}">{$clsCruise->getTitle($lstWishlistCruise[i].target_id)}</a>
												<label class="rate-1">{$clsReviews->getStarNew($lstWishlistCruise[i].target_id,tour)}</label>
											</h3> 
											{if $clsCruise->getCityAround($lstWishlistCruise[i].target_id) ne ''}
												<address><i class="fa fa-map-marker"></i> {$clsCruise->getCityAround($lstWishlistCruise[i].target_id)}</address>
											 {/if}
											 <span class="inline-block fa fa-trash z_24 h-center remove DeleteWishlist" clsTable='Cruise' id="{$lstWishlistCruise[i].target_id}"></span>
										</div>
									</div>
									{/section}
									{/if}
								</div>
							</section>
							<section class="col-md-4 unitRight">
								{$core->getBlock(l_rightMember)}
							</section>
						</div>
					</div>
					</section>
				</div>
				
			</div>
		</div>
	</section>
</div>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(document).ready(function(){	
			$('.fileinput-exists').click(function(){
				$('.btn-update').show();
			});
			$('.it-head-iti').click(function(){
				$(this).find('.fa-dropdown').toggleClass('fa-angle-up');
				$(this).next().slideToggle();
			});
		}); 
	})
</script>
{/literal}
