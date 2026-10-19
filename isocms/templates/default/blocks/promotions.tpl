{if 1 eq 2}
<div id="promotions-home">
	<div class="promotions-title">
			<i class="icon icon-top"></i>
				<h2>Top khuyến mãi</h2>
		</div>
		<div class="promotionsh">
			{section name=i loop=$lstPromotion max=1}
				{assign var = link value = $clsPromotion->getLink($lstPromotion[i].promotion_id)}
				{assign var = title value = $clsPromotion->getTitle($lstPromotion[i].promotion_id)}
			  <div class="images">
					<a href="{$link}" title="{$title}"><img src="{$clsPromotion->getImage($lstPromotion[i].promotion_id,132,100)}" width="132px" height="100px" ></a>
				</div>
				<div class="formatext">
					<h3><a href="{$link}" title="{$title}">{$title}</a></h3>
{$clsPromotion->getIntro($lstPromotion[i].promotion_id)|html_entity_decode|truncate:150}
				</div>
				{/section}
				<ul class="related-hotel">
					{section name=i loop=$lstPromotion start=1 max=3}
					{assign var = link value = $clsPromotion->getLink($lstPromotion[i].promotion_id)}
					{assign var = title value = $clsPromotion->getTitle($lstPromotion[i].promotion_id)}
					<li><a href="{$link}" title="{$title}">{$title}</a></li>
					{/section}
				</ul>
		</div>
</div>
<div class="booking-room">
	<i class="icon icon-room"></i>
		<div class="formattest-booking">
			<h4>Đặt phòng theo đoàn?</h4>
			 Vietnamhotel đảm bảo sẽ tìm kiếm deal tốt nhất cho bạn!
				<div class="book-now-room">
					<a href="javascript:void(0);" rel="nofollow" data-toggle="modal" data-target="#bookingGroup" class="book-now">Đặt ngay <i class="fa fa-chevron-right"></i></a>
				</div>
		</div>
</div>
{/if}
