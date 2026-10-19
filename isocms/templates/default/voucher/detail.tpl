{assign var=TitleItem value=$clsVoucher->getTitle($voucher_id,$oneTable)}
{assign var = _discountInfo value = $clsVoucher->checkIsPromotion($voucher_id,1)}
{assign var=discount_id value=$_discountInfo.discount_info.discount_id|default:0}
{assign var=is_discount value=$_discountInfo.is_discount}
{assign var=is_due_date value=$_discountInfo.discount_info.is_due_date|default:''}
{assign var=discount_value value=$_discountInfo.discount_info.discount_value|default:0}
{assign var=discount_type value=$_discountInfo.discount_info.discount_type|default:0}
{assign var=due_date value=$_discountInfo.discount_info.due_date|default:''}
{assign var=TotalStock value=$clsStock->getTotal($voucher_id)}
{assign var=have_bought value=$clsStock->getTotalOut($voucher_id)}
{assign var=ListDestination value=$clsVoucherDestination->getByVoucher($voucher_id)}

 <section class="page_container bg_f9f9f9">
	 <nav class="breadcrumb-main breadcrumb-{$mod}">
      <div class="container">
         <ol class="breadcrumb hidden-xs bg_f9f9f9 mt0" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <a itemprop="item" href="{$PCMS_URL}">
               <span itemprop="name" class="reb">{$core->get_Lang('Trang chủ')}</span></a>
               <meta itemprop="position" content="1" />
            </li>
             <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <a itemprop="item" href="{$clsISO->getLink('voucher')}">
               <span itemprop="name" class="reb">{$core->get_Lang('Vouchers')}</span></a>
               <meta itemprop="position" content="2" />
            </li>
              <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <a itemprop="item" href="{$purl|default:''}">
               <span itemprop="name" class="reb">{$TitleItem|truncate:40}</span></a>
               <meta itemprop="position" content="3" />
            </li>
         </ol>
      </div>
   </nav>
	<div class="contentVoucher">
		<div class="container">
			<div class="topDetailVoucher">
				<div class="row">
					<div class="col-md-7">
						<div class="sliderImage owl-carousel">
							{section name=i loop=$lstImage}
								<img class="Item" src="{$clsImage->getImage($lstImage[i].image_id,714,467,$lstImage[i])}" width="714" height="467" alt="{$clsImage->getTitle($lstImage[i].image_id,$lstImage[i])}">
							{/section}
						</div>
					</div>
					<div class="col-md-5">
						<div class="contentRight">
							<div class="box_title_voucher_detail">
								<h1 class="title">{$TitleItem}</h1>
                                {if $deviceType ne 'phone'}
								<div class="icon_share">
									<i class="ic ic_share"></i>
									<div class="share_box">
										<script type="text/javascript" src="{$URL_JS}/jquery.sharer.js?v={$upd_version}"></script>
										{assign var=link_share value=$curl}
										{assign var=title_share value=$TitleItem}
										{$clsISO->getBlock('box_share',["link_share"=>$link_share,"title_share"=>$title_share])}
									</div>
								</div>
                                {/if}
							</div>
							<div class="number_people_bought">
								<i class="fa fa-user-circle-o" aria-hidden="true" style="font-size: 22px"></i>
								<p>{$have_bought} {$core->get_Lang('have bought')}</p>
                                
                                {if $deviceType eq 'phone'}
								<div class="icon_share">
									<i class="ic ic_share"></i>
									<div class="share_box">
										<script type="text/javascript" src="{$URL_JS}/jquery.sharer.js?v={$upd_version}"></script>
										{assign var=link_share value=$curl}
										{assign var=title_share value=$TitleItem}
										{$clsISO->getBlock('box_share',["link_share"=>$link_share,"title_share"=>$title_share])}
									</div>
								</div>
                                {/if}
							</div>
							<div class="PriceDetail">
								<div class="ContentLeft">
                                    <div class="detail_price">{$clsVoucher->getPrice($voucher_id,$oneTable,'Detail')}</div>
								</div>
                                {if $TotalStock && $TotalStock gt 0}
                                <form action="" method="post" class="cmxform">
                                    {assign var=ticket value=$core->get_Lang('ticket')}
                                    {math assign="StockP" equation="x + 1" x=$TotalStock}
                                    <div class="count_voucher">
                                        <div class="count_value_text">{$core->get_Lang('Số lượng')}</div>
                                        <div class="wpcf7-spinner">
                                            <input type="text" class="spinnerExample" name="number_voucher" value="1" min="1" max="{$TotalStock}"/>
                                        </div>
                                    </div>
                                    <input type="hidden" name="voucher_id" value="{$voucher_id}" />
                                    <input type="hidden" name="BookingVoucher" id="BookingVoucher" value="BookingVoucher" />
                                    <input type="hidden" name="voucher_price_z" value="{$clsVoucher->getPricePromotionO($voucher_id,$oneTable)}" />
                                    {if $getPromotion}
                                    <input type="hidden" name="discount_id" value="{$getPromotion.discount_id}">
                                    <input type="hidden" name="discount_value" value="{$getPromotion.discount_value|replace:".":""}">
                                    <input type="hidden" name="discount_type" value="{$getPromotion.discount_type}">
                                    {/if}
									<div class="box_button_submit">
										<button type="submit" class="bookVoucher btn_book_now btn_main">{$core->get_Lang('Booking now')}</button>
                                        {if $clsISO->getCheckActiveModulePackage($package_id,'setting','cart','customize')}
										<button type="submit" class="btn_add_cart">{$core->get_Lang('Add to cart')}</button>
                                        {/if}
									</div>
                                </form>
                                {else}
                                {if $clsVoucher->getContiOrder($voucher_id,$oneTable) eq '1'}
                                <form class="form_booking_now" action="" method="post">
                                    <input type="hidden" name="voucher_id" value="{$voucher_id}" />
                                    <input type="hidden" name="ContactVoucher" id="ContactVoucher" value="ContactVoucher" />
                                    <button class="bookVoucher contact_now btn_main">
                                        {$core->get_Lang("Contact")}
                                    </button>
                                </form>
                                {else}
                                <button type="submit" class="bookVoucher OutVoucher btn_main">{$core->get_Lang('Out of voucher')}</button>
                                {/if}
                                {/if}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="contentPage">
				<div class="row">
					<div class="col-md-9">
						<div class="wrap_list_tab bg_fff tinymce_Content">
							<div id="tabsk" class="box__menu">
								{assign var=Intro value=$clsVoucher->getIntro($voucher_id,$oneTable)}
								{assign var=Content value=$clsVoucher->getContent($voucher_id,$oneTable)}
								{assign var=Condition value=$clsVoucher->getLocation($voucher_id,$oneTable)}
								<ul class="clienttabs list_style_none d-flex">
									{if $Intro}
									<li><a id="intro--link" href="javascript:void(0);">{$core->get_Lang('Overview')}</a></li>
									{/if}
									{if $Content}
										<li><a id="overview--link" href="javascript:void(0);">{$core->get_Lang('Details')}</a></li>
									{/if}
									{if $Condition}
										<li><a id="condition--link" href="javascript:void(0);">{$core->get_Lang('Conditions apply')}</a></li>
									{/if}
									{if $clsISO->getCheckActiveModulePackage($package_id,'reviews','default','default','voucher')}
										<li><a id="reviews--link" href="javascript:void(0);">{$core->get_Lang('Review')}</a></li>
									{/if}
								</ul>
							</div>
							<div class="list_tab">
								{if $Intro}
									<div id="intro" class="intro section__box">
										<h2 class="title_section title_tab">{$core->get_Lang('Overview')}</h2>
										<div class="main_intro short_content" data-height="250">
											{$Intro}
										</div>
									</div>
								{/if}
								{if $Content}
									<div id="overview" class="overview section__box">
										<h2 class="title_section title_tab">{$core->get_Lang('Details')}</h2>
										{$Content}
									</div>
								{/if}
								{if $Condition}
									<div id="condition" class="condition section__box">
										<h2 class="title_section title_tab">{$core->get_Lang('Conditions apply')}</h2>
										{$Condition}
									</div>
								{/if}
								{if $clsISO->getCheckActiveModulePackage(
	$package_id,
	'reviews',
	'default',
	'default',
	'voucher'
)}
	{*
	 * Khởi tạo dữ liệu đánh giá voucher.
	 * Review No Login sử dụng profile_id=0.
	 *}
	{assign var=table_id value=$voucher_id}
	{assign var=review_type value='voucher'}

	{assign
		var=getToTalReview
		value=$clsReviews->getToTalReviewNoLogin(
			$voucher_id,
			'voucher'
		)
	}

	{assign
		var=numReview
		value=$getToTalReview|default:0
	}

	<div
		id="reviews"
		class="review section__box"
	>
		<h2 class="title_section title_tab">
			{$core->get_Lang('Reviews')}
		</h2>

		{$core->getBlock(
			'review_Star_No_Login',
			[
				"table_id"        => $voucher_id,
				"voucher_id"      => $voucher_id,
				"review_type"     => "voucher",
				"getToTalReview"  => $getToTalReview,
				"numReview"       => $numReview,
				"lstReview"       => $lstReview
			]
		)}

		{if $numReview eq 0}
			<div class="text_review_bottom">
				{$core->get_Lang(
					'Chưa có đánh giá mới nào.'
				)}

				<a
					class="btn_write_review_no_login"
					href="#writeTourReview"
					title="{$core->get_Lang('Write review')}"
					role="button"
				>
					{$core->get_Lang('Write review')}
				</a>
			</div>
		{/if}
	</div>
{/if}
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="LocationRight">
							{if $lstVoucherRecommend}
							<div class="listVoucherRe">
								<p class="titleBoxVoucher titleLocation">{$core->get_Lang('Voucher interested')}</p>
								{section name=i loop=$lstVoucherRecommend}
									{assign var=voucher_id value=$lstVoucherRecommend[i].voucher_id}
									{assign var=arrVoucher value=$lstVoucherRecommend[i]}
                                           {assign var=getLink value=$clsVoucher->getLink($voucher_id,$lstVoucherRecommend[i])}
                                           {assign var=getTitle value=$clsVoucher->getTitle($voucher_id,$lstVoucherRecommend[i])}
                                           {assign var=ListDestination value=$clsVoucherDestination->getByVoucher($voucher_id)}
                                           {assign var = _discountInfo value = $clsVoucher->checkIsPromotion($voucher_id,1)}
											{assign var=is_discount value=$_discountInfo.is_discount}
											{assign var=is_due_date value=$_discountInfo.discount_info.is_due_date}
											{assign var=due_date value=$_discountInfo.discount_info.due_date}
                                          {if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
											{assign var=getToTalReview value=$clsReviews->getToTalReview($voucher_id,'voucher')}
											{assign var=getRateAvg value=$clsReviews->getRateAvg($voucher_id,'voucher')}
											{assign var=getStarNew value=$clsReviews->getStarNew($voucher_id,'voucher')}
											{else}
											{assign var=getToTalReview value=$clsReviews->getToTalReviewNoLogin($voucher_id,'voucher')}
											{assign var=getRateAvg value=$clsReviews->getRateAvgNoLogin($voucher_id,'voucher')}
											{assign var=getStarNew value=$clsReviews->getStarNewNoLogin($voucher_id,'voucher')}
										  {/if}
									{$clsISO->getBlock('voucherbox',[
										"voucher_id"	=>$voucher_id,
										"arrVoucher"	=>$arrVoucher,
										"getLink"	=>$getLink,
										"getTitle"	=>$getTitle,
										"ListDestination"	=>$ListDestination,
										"_discountInfo"	=>$_discountInfo,
										"is_discount"	=>$is_discount,
										"is_due_date"	=>$is_due_date,
										"due_date"	=>$due_date,
										"getToTalReview"	=>$getToTalReview,
										"getRateAvg"	=>$getRateAvg,
										"getStarNew"	=>$getStarNew
									])}
								{/section}
							</div>
							{/if}
						</div>
				  </div>
				</div>
			</div>
		</div>
		{*{$core->getBlock('box_service_ad')}*}
	</div>
</section>
<script type="text/javascript">
	var map_la = '{$map_la|default:0}';
	var map_lo = '{$map_lo|default:0}';
	var $_View_more = '{$core->get_Lang("View more")}';
	var $_Less_more = '{$core->get_Lang("Less more")}';
</script>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		function toggleShorted(_this, e){
			e.preventDefault();
			if(!$(_this).hasClass('clicked')){
				$(_this).parent('.short_content')
						.css('height','auto')
						.removeClass('shorted')
						.addClass('lessmore');
				$(_this).addClass('clicked').text($_Less_more);
			} else {
				var max_height = $(_this).attr('max_height');
				$(_this).parent('.short_content')
						.css('height',max_height)
						.addClass('shorted')
						.removeClass('lessmore');
				$(_this).removeClass('clicked').text($_View_more);
			}
			return false;
		}
		$(function(){
			if($('.short_content').length){
				$('.short_content').each((_i, _elem) => {
					var _max_height = $(_elem).data('height'),
							_origin_height = $(_elem).outerHeight(false);
					if(parseInt(_max_height) < _origin_height){
						$(_elem)
								.height(_max_height)
								.addClass('shorted')
								.append('<a class="more" max_height="'+_max_height+'" onClick="toggleShorted(this,event)">'+$_View_more+'</a>');
					}
				});
			}
		});
(function () {
	'use strict';

	function openVoucherReview() {
		var reviewBox = document.getElementById('writeTourReview');

		if (!reviewBox) {
			console.warn(
				'Không tìm thấy phần tử #writeTourReview'
			);
			return;
		}

		reviewBox.style.display = 'block';
		reviewBox.removeAttribute('hidden');
		reviewBox.classList.add('is-open');
		reviewBox.setAttribute('aria-hidden', 'false');

		/*
		 * Cuộn xuống form đánh giá.
		 */
		var headerOffset = 130;
		var reviewTop = reviewBox
			.getBoundingClientRect()
			.top
			+ window.pageYOffset
			- headerOffset;

		window.scrollTo({
			top: reviewTop,
			behavior: 'smooth'
		});

		/*
		 * Focus vào ô nhập đầu tiên nếu có.
		 */
		window.setTimeout(function () {
			var firstInput = reviewBox.querySelector(
				'textarea:not([disabled]),'
				+ 'input:not([type="hidden"]):not([disabled])'
			);

			if (firstInput) {
				firstInput.focus();
			}
		}, 350);
	}

	/*
	 * Dùng capture=true để không bị JS cũ chặn click.
	 */
	document.addEventListener('click', function (event) {
		var button = event.target.closest(
			'.btn_write_review,'
			+ '.btn_write_review_login,'
			+ '.btn_write_review_no_login'
		);

		if (!button) {
			return;
		}

		event.preventDefault();

		/*
		 * Đợi các handler cũ chạy xong rồi mở lại form.
		 */
		window.setTimeout(function () {
			openVoucherReview();
		}, 0);
	}, true);
})();
		$(function(){
			var $owl = $('.sliderImage');
			$owl.owlCarousel({
				items: 1,
				margin: 0,
				nav: false,
				dots: false,
				loop: true,
				autoplay:true,
				responsive: {
					0: { 
						nav: true,
					},
					768: { 
						nav: true,
					},
					1200:{
						nav:true
					}
				},
			});
			initialize();
		});
		if($(window).width() > 992){
			$.lockfixed("#tabsk", {offset: {top:0,bottom:500}});
		}

		function goToByScroll(id) {
			id = id.replace("--link", "");
			$('html,body').animate({
						scrollTop: $("#" + id).offset().top - 140
					},
					'slow');
		}
		$("#tabsk > ul li a").click(function (e) {
			var $_this = $(this);
			e.preventDefault();
			goToByScroll($(this).attr("id"));
		});
		
		function initialize() {
			var mapOptions = {
				center: new google.maps.LatLng(map_la,map_lo),
				zoom: 18,
				scaleControl: false,
				scrollwheel: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}; 
			map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
			var marker = new google.maps.Marker({
				map: map,
				position: new google.maps.LatLng(map_la,map_lo),
			});
			var infowindow = new google.maps.InfoWindow({
				map: map,
				position: new google.maps.LatLng(map_la,map_lo),
			});
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map, marker);
			});
			setTimeout(function () { infowindow.close(); }, 1000);
		}
	})
</script>
{/literal}

{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
	{assign var=getToTalReview value=$clsReviews->getToTalReview($voucher_id,'voucher')}
	{assign var=getRateAvg value=$clsReviews->getRateAvg($voucher_id,'voucher')}
{else}
	{assign var=getToTalReview value=$clsReviews->getToTalReviewNoLogin($voucher_id,'voucher')}
	{assign var=getRateAvg value=$clsReviews->getRateAvgNoLogin($voucher_id,'voucher')}
{/if}
{literal}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{/literal}{$getRateAvg}{literal}",
    "reviewCount": "{/literal}{$getToTalReview}{literal}"
  },
  "description": "{/literal}{$clsVoucher->getIntro($voucher_id,$oneTable)|html_entity_decode|strip_tags}{literal}",
  "name": "{/literal}{$TitleItem}{literal}",
  "image": [
		{/literal}{section name=i loop=$lstImage}
			"{$DOMAIN_NAME}{$lstImage[i].image}"{if !$smarty.section.i.last},{/if}
		{/section}{literal}
  ],
  "offers": {
    "@type": "Offer",
    "availability": "https://schema.org/InStock",
    "price": "{/literal}{$clsVoucher->getPriceSort($voucher_id,$oneTable)}{literal}",
    "priceCurrency": "{/literal}{$clsISO->getShortCurrency()|strip_tags:false}{literal}"
  },
	"review": [
		{/literal}{section name=i loop=$lstReview}
			{assign var=oneItemProfile value=$clsProfile->getOne($lstReview[i].profile_id,'first_name,last_name,full_name,username,avatar,facebook_email,google_email')}
			{assign var=full_name 	value=$clsProfile->getFullname($lstReview[i].profile_id,$oneItemProfile)}
			{assign var=dateSecond 	value=$clsISO->formatDateSecond($lstReview[i].review_date)}
			{assign var=rateOne 	value=$clsReviews->getTextRateOne($lstReview[i].reviews_id,$lstReview[i])}
			{assign var=content 	value=$clsReviews->getContent($lstReview[i].reviews_id,400,true,$lstReview[i])|html_entity_decode}{literal}
			{
				"@type": "Review",
				"author": "{/literal}{$full_name}{literal}",
				"datePublished": "{/literal}{$dateSecond}{literal}",
				"reviewBody": "{/literal}{$content}{literal}",
				"name": "",
				"reviewRating": {
					"@type": "Rating",
					"bestRating": "5",
					"ratingValue": "{/literal}{$rateOne}{literal}",
					"worstRating": "1"
				}
			}{/literal}{if !$smarty.section.i.last},{/if}{literal}
		{/literal}{/section}{literal}
	]
}
</script>
{/literal}

{literal}
<style>
	#reviews {
		position: relative;
	}
.rate_star.checked{
	background: #F9D932;
}
	#reviews .btn_write_review,
	#reviews .btn_write_review_login,
	#reviews .btn_write_review_no_login {
		position: relative !important;
		z-index: 20;
		pointer-events: auto !important;
		cursor: pointer !important;
	}

	#writeTourReview.is-open {
		display: block !important;
	}
</style>
	<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function () {
			$(function(){
				$.widget( "ui.spinner", $.ui.spinner, {
					_buttonHtml: function() {
						return "" +
								"<button class='ui-spinner-button ui-spinner-up' type='button'>+</button>" +
								"<button class='ui-spinner-button ui-spinner-down' type='button'>-</button>";
					}
				});
				$('.spinnerExample').spinner({});
				setTimeout(() => {
					if($('.ui-spinner-input').length){
						$('.ui-spinner-input').attr('readonly', true);
					}
				},500);

			});
		})
	</script>
{/literal}