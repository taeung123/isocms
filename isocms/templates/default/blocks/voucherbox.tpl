{assign var=getLink value=$clsVoucher->getLink($voucher_id,$arrVoucher)}
{assign var=getTitle value=$clsVoucher->getTitle($voucher_id,$arrVoucher)}
{assign var=ListDestination value=$clsVoucherDestination->getByVoucher($voucher_id)}
{assign var = _discountInfo value = $clsVoucher->checkIsPromotion($voucher_id,1)}
{assign var=is_discount value=$_discountInfo.is_discount}
{assign var=is_due_date value=$_discountInfo.discount_info.is_due_date|default:''}
{assign var=due_date value=$_discountInfo.discount_info.due_date|default:''}
{assign var=total_voucher value=$clsStock->getTotal($voucher_id)}

{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
{assign var=getToTalReview value=$clsReviews->getToTalReview($voucher_id,'voucher')}
{assign var=getRateAvg value=$clsReviews->getRateAvg($voucher_id,'voucher')}
{assign var=getStarNew value=$clsReviews->getStarNew($voucher_id,'voucher')}
{else}
{assign var=getToTalReview value=$clsReviews->getToTalReviewNoLogin($voucher_id,'voucher')}
{assign var=getRateAvg value=$clsReviews->getRateAvgNoLogin($voucher_id,'voucher')}
{assign var=getStarNew value=$clsReviews->getStarNewNoLogin($voucher_id,'voucher')}
{/if}
<div class="box__padding">
	<div class="itemTrip {$deviceType}">
		<a href="{$getLink}" title="{$getTitle}">
			<div class="image relative">
				<img src="{$clsVoucher->getImage($voucher_id,297,194,$arrVoucher)}" alt="{$getTitle}" class="owl-lazy lazy img100" loading="lazy">
				{if $is_discount && $is_due_date}
				<div class="countdown bg_main">
				<span id="countdown_{$smarty.section.i.iteration}" data-date="{$due_date|date_format:"%Y/%m/%d %H:%M"}" class="countdown-timer "></span>
				<span class="icon"></span>
				</div>
				{/if}
				{if $ListDestination}
				<span class="duration"><i class="fa fa-map-marker" aria-hidden="true"></i>
				 {section name=k loop=$ListDestination}
					{$clsCity->getTitle($ListDestination[k].city_id)} 
				 {/section}
				</span>
				{/if}
			</div>
			<div class="body">
				<h3 class="body__title limit_2line">{$getTitle}</h3>
				<div class="body_info_voucher d-flex">
					<div class="body_review">
						<span class="rate_avg">{$getRateAvg}</span><label class="rate-one">{$getStarNew}</label><span class="review_count">({$getToTalReview})</span>

					</div>
					<div class="body_price">
					{$clsVoucher->getPrice($voucher_id,$arrVoucher,'List')}
					</div>
				</div>
			</div>
		</a>
	</div>
</div>