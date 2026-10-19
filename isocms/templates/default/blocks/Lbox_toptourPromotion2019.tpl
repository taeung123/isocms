{if $listTopTourPromotion}
<section class="box_home_2019 boxTourHomePage bg_fff">
	<div class="container">
		<div class="title text_center mb30">
			<p class="color_main_2019 text_upper mb15">{$core->get_Lang('So many Adventures. So little time')}</p>
			<h2 class="h2_title mb10">{$core->get_Lang('Top Trip from')} {$PAGE_NAME}</h2>
			<p class="color_666">{$core->get_Lang('Pick from our amazing adventures. How on earth will you choose')}?</p>
		</div>
		<div class="list_tour">
				<div class="row">
					{section name=i loop=$listTopTourPromotion}
					{assign var=promotion_id value=$clsTour->getMinStartDatePromotionProID($listTopTourPromotion[i].taget_id,$now_day)}
					{assign var=checkmem value=$clsTour->getCheckMemSet($listTopTourPromotion[i].taget_id)}
					{assign var=getFlagText value=$clsPromotion->getFlagText($promotion_id)}
					{assign var=getLink value=$clsTour->getLink($listTopTourPromotion[i].taget_id)}
					{assign var=getTitle value=$clsTour->getTitle($listTopTourPromotion[i].taget_id)}
					{assign var=getStarNew value=$clsReviews->getStarNew($listTopTourPromotion[i].taget_id,tour)}
					{assign var=getToTalReview value=$clsReviews->getToTalReview($listTopTourPromotion[i].taget_id,tour)}
					{assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2019($listTopTourPromotion[i].taget_id,$now_day,$is_agent)}
					{assign var=getPriceTourPromotionnomem value=$clsTour->getTripPriceNewPro2019($listTopTourPromotion[i].taget_id,$now_day,$is_agent,'nomem')}
					<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 full_width_480">
						<div class="tour_home_item">
							<div class="tour_home_image">
								<span style="cursor:pointer" class="{if $profile_id eq ''}exitLoginHome{else}addWishlist{/if} heart-o inline-block text-center btnwl" title="{$core->get_Lang('Saved to wishlist')}" data-clsTable="Tour" data-data="{$listTopTourPromotion[i].taget_id}" id="addwishlistTour{$listTopTourPromotion[i].taget_id}">{$clsTour->getOneField('wishlist_num',$listTopTourPromotion[i].taget_id)}</span>

								<a class="photo" href="{$getLink}" title="{$getTitle}">
									<img class="img100" src="{$clsTour->getImage($listTopTourPromotion[i].taget_id,264,175)}" alt="{$getTitle}"/>
								</a>
							</div>
							<div class="tour_home_body">
								<div class="body_top">
									<h3><a href="{$getLink}" title="{$getTitle}">{$getTitle}</a></h3>
									{if $checkmem eq 1}
										{if $profile_id ne ''}
											{if $getFlagText ne ''}
												<p class="discount_text color_main">{$getFlagText}</p>
											{/if}
										{/if}
									{else}
										{if $getFlagText ne ''}
											<p class="discount_text color_main">{$getFlagText}</p>
										{/if}
									{/if}

								</div>
								<p class="duration">{$clsTour->getTripDuration2020($listTopTourPromotion[i].taget_id)}</p>
								<div class="body_bottom">
									<div class="tour_rate">
										<label class="rate-2019 block mb05">{$getStarNew}</label>
										<span class="review_text color_666">{$clsReviews->getRateAVG($listTopTourPromotion[i].taget_id,'tour')}/5 - <span class="text_bold color_333">{$getToTalReview} {$core->get_Lang('reviews')}</span></span>
									</div>
									<div class="tour_price">

										{if $checkmem eq 1}
											{if $profile_id eq ''}{$getPriceTourPromotionnomem}{else}{$getPriceTourPromotion}{/if}
										{else}
											{$getPriceTourPromotion}
										{/if}
									</div>
								</div>
							</div>
						</div>
					</div>
				{/section}
			</div>
		</div>
	</div>
	<script>
		var totalRecord='{$totalRecord}';
		var $pageLastest = 1;
		var $_LANG_ID = '{$_LANG_ID}';
	</script>
	{literal}
	<script>
	$(function(){
		$(document).on('click', "#show-more", function(ev) {
			var $_this = $(this);
			$_this.find('.ajax-loader').show();
			$pageLastest++;
			$.ajax({  
				type:'POST',
				url:path_ajax_script+'/index.php?mod=home&act=ajLoadMoreTopTourPromotion&lang='+LANG_ID, 
				data:{
					"page":$pageLastest,
				},
				dataType:'html',
				success:function(html){
					$_this.find('.ajax-loader').hide();
					$('#home-masonry-container').append( html );
					setwidthLeft();
				}
			});
			setInterval(function(){	
				loadPageShowMore();	
			},100);	
		});
	});
	function loadPageShowMore($number_per_page){
		var $number_show = $('#home-masonry-container .box:visible').size();
		if($number_show >= totalRecord){
			$('.semore_topTourHome').remove();
		}
	}
	</script>
	{/literal}
</section>
{/if}