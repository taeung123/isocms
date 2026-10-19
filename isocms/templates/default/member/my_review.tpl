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
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$core->get_Lang('My Reviews')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('My Reviews')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</nav>
	<section id="contentPage" class="pageMyReview pd40_0">
		<div class="container">
			<div class="content-info">
				<div class="row">
					{$core->getBlock('box_member_link')}
					<div class="col-lg-9 col-xs-12 tabs_content pl0" id="lstTabs" style="border:0 !important">
						<div class="box_review_agent">
							{section name=i loop=$lstReviewsTour}
							{assign var=title_tour value=$clsTour->getTitle($lstReviewsTour[i].table_id)}
							{assign var=link_tour value=$clsTour->getLink($lstReviewsTour[i].table_id)}
								<div class="item_reviews">
								<div class="body_reviews">
									<div class="photo">
										<a href="{$link_tour}" title="{$title_tour}">
											<img src="{$clsTour->getImage($lstReviewsTour[i].table_id,197,107)}" width="197px" height="107px" alt="{$title_tour}">
										</a>
									</div>
									<div class="body">
										<h3 class="fw600 size18 mb5"><a href="{$link_tour}" class="color_333" title="{$title_tour}">{$title_tour}</a>
											<label class="rate-1"
												   style="margin-right:5px;">{$clsReviews->getStarNew($lstReviewsTour[i].table_id,'tour')}</label>
										</h3>
										<address class="color_999">
											{$clsTour->getLCityAround2($lstReviewsTour[i].table_id)}
										</address>
										<p class="content_reviews">
											<i class="fa fa-comment size18 color_1aa95a pr10"></i> {$clsReviews->getContent($lstReviewsTour[i].reviews_id)}
										</p>
									</div>
								</div>
								<div class="right_body">
									<p  class="fw600 size18 mb0 totalReview">{$clsReviews->getTextRateAvg($lstReviewsTour[i].table_id,'tour')} {$clsReviews->getRateAvg($lstReviewsTour[i].table_id,'tour')}</p>
									<p class="color_999 mb20">{$core->get_Lang('Dựa trên')} {$clsReviews->getToTalReview($lstReviewsTour[i].table_id,'tour')} {$core->get_Lang('đánh giá')}</p>
									<p class="link_detail"><a href="{$link_tour}" title="{$core->get_Lang('Xem chi tiết')}">{$core->get_Lang('Xem chi tiết')}</a></p>
								</div>
							</div>
							{/section}
						</div>
					</div>
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
			$(document).on('click', '.semoreClick', function(){ 
				$(this).closest(".clicSeemore").find(".More").hide();
				$(this).closest(".clicSeemore").find(".Less").show();
			});
			$('.it-head-iti').click(function(){
				$(this).find('.fa-dropdown').toggleClass('fa-angle-up');
				$(this).next().slideToggle();
			});
			$(document).on('click', '.LessClick', function(){ 	
				$(this).closest(".clicSeemore").find(".Less").hide();
				$(this).closest(".clicSeemore").find(".More").show();
			});
		}); 
	})
</script>
{/literal}
