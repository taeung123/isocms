<main id="main" class="page_container promotion_container">
	<section class="section_box attractive_tour">
		<div class="container">
			<div class="attractive_tour--header header__content">
				<div class="container">
					<h1 class="title32 color_333 mb20">{$core->get_Lang('Promotion')}</h2>
				</div>
			</div>
    		{if $listPromotionId}
				<div class="attractive_tour--content">
					<div class="row list_tours">
						{section name=i loop=$listPromotionId}
							{assign var=tour_id value=$listPromotionId[i].item_id}

							{assign var=getLink value=$clsTour->getLink($tour_id)}
							{assign var=getTitle value=$clsTour->getTitle($tour_id)}

							{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
								{assign var=getToTalReview value=$clsReviews->getToTalReview($tour_id,'tour')}
								{assign var=getRateAvg value=$clsReviews->getRateAvg($tour_id,'tour')}
								{assign var=getStarNew value=$clsReviews->getStarNew($tour_id,'tour')}
							{else}
								{assign var=getToTalReview value=$clsReviews->getToTalReviewNoLogin($tour_id,'tour')}
								{assign var=getRateAvg value=$clsReviews->getRateAvgNoLogin($tour_id,'tour')}
								{assign var=getStarNew value=$clsReviews->getStarNewNoLogin($tour_id,'tour')}
							{/if}

							{assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent)}
							{assign var=percent_promotion value=$clsISO->getPromotion($tour_id,'Tour',$now_day,$now_day,'info_promotion')}
							{assign var=close_sale_date value=$clsTour->getTourStartDate($tour_id,$now,'close_sale_date')}
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6 box">
								<div class="itemTrip {$deviceType}">
									<a href="{$getLink}" title="{$getTitle}">
										<div class="image relative">
											<img src="{$clsConfiguration->getImage('default_image_pixel',296,196)}" data-src="{$clsTour->getImage($tour_id,296,196)}" alt="{$getTitle}" class="lazy img100">
											<span class="percent_promotion">
											{$percent_promotion.discount_value}%
											</span>
											{if $close_sale_date}
											<div class="clock_last_hour" data-date="{$close_sale_date|date_format:'%m/%d/%Y %k:%M:%S'}"></div>
											{/if}
											<span class="duration"><i class="fa fa-clock-o" aria-hidden="true"></i> {$clsTour->getTripDuration2020($tour_id)}</span>
										</div>
										<div class="body body_tour">
											<h3 class="body__title limit_2line">{$getTitle}</h3>
											<div class="body_info_tour">
												<div class="body_review">
													<p class="review_rate"><span class="rate_avg">{$getRateAvg}</span> <label class="rate-2019 block">{$getStarNew}</label></p>
													<p class="review_count">{$getToTalReview} {$core->get_Lang('reviews')}</p>
												</div>
												<div class="body_price">
												{if $getPriceTourPromotion}
													{$getPriceTourPromotion}
												{else}
													<p class="size18 color_fb1111 text-bold mb0">{$core->get_Lang('Contact')}</p>
												{/if}
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
						{/section}
					</div>
					{if $totalRecord gt $recordPerPage}
						<div class="view_more">
							<a href="javascript:void(0);" page="1" rel="nofollow" _type="TopTrip" class="show-loader btn_view_more" id="show-more-promotion-tour" data-total={$totalRecord} data-page={$currentPage} title="{$core->get_Lang('View more')}">{$core->get_Lang('View more')}</a>
						</div>
					{/if}
				</div>
			{/if}
		</div>
	</section>
</main>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(document).ready(function(){
			setClockLastHourTour();
			$('#show-more-promotion-tour').click(function(){
				var $_this = $(this);
				_Action = 'ajaxLoadMorePromotion';
				$pageLastest = $_this.data('page');
				$totalRecord = $_this.data('total');
				$pageLastest++;
				if($pageLastest * 8 >= $totalRecord){
					$('.view_more').hide();
				}
				$_this.data('page',$pageLastest);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod=homepro&act='+_Action+'&lang='+LANG_ID,
					data:{
						"page":$pageLastest,
					},
					dataType:'html',
					success:function(html){
						$_this.find('.ajax-loader').hide();
						$('.list_tours').append( html );
						$('.lazy').lazy({
							effect: "fadeIn",
							effectTime: 20,
							threshold: 0
						});
						setWidthHeightElement();
						setClockLastHourTour()
					}
				});
			}); 
		});
	})
</script>
{/literal}
