{assign var=TitleItem value=$clsVoucher->getTitle($voucher_id,$oneTable)}
{assign var = _discountInfo value = $clsVoucher->checkIsPromotion($voucher_id,1)}
{assign var=discount_id value=$_discountInfo.discount_info.discount_id}
{assign var=is_discount value=$_discountInfo.is_discount}
{assign var=is_due_date value=$_discountInfo.discount_info.is_due_date}
{assign var=discount_value value=$_discountInfo.discount_info.discount_value}
{assign var=discount_type value=$_discountInfo.discount_info.discount_type}
{assign var=due_date value=$_discountInfo.discount_info.due_date}
{assign var=TotalStock value=$clsStock->getTotal($voucher_id)}
 {assign var=ListDestination value=$clsVoucherDestination->getByVoucher($voucher_id)}
 <section class=" page_container bg_fff">
	 <nav class="breadcrumb-main breadcrumb-{$mod}">
      <div class="container">
         <ol class="breadcrumb hidden-xs bg_fff mt0" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
               <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}">
               <span itemprop="name" class="reb">{$core->get_Lang('Trang chủ')}</span></a>
               <meta itemprop="position" content="1" />
            </li>
             <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
               <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$clsISO->getLink('voucher')}">
               <span itemprop="name" class="reb">{$core->get_Lang('Voucher')}</span></a>
               <meta itemprop="position" content="2" />
            </li>
              <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
               <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$purl}">
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
					<div class="col-md-6">
						<div class="sliderImage owl-carousel">
							{section name=i loop=$lstImage}
								<img class="Item" src="{$clsImage->getImage($lstImage[i].image_id,625,413,$lstImage[i])}" alt="{$clsImage->getTitle($lstImage[i].image_id,$lstImage[i])}">
							{/section}
						</div>
					</div>
					<div class="col-md-6">
						<div class="contentRight">
							<h1 class="title">{$TitleItem}</h1>
						  <div class="durationAndTotal">
								<span class="duration"><i class="fa fa-map-marker" aria-hidden="true"></i> 
								{section name=k loop=$ListDestination}
									{$clsCity->getTitle($ListDestination[k].city_id)} 
								 {/section} 
								 </span>
								<span class="totalBook" style="display: none">{$core->get_Lang('7k+ Đã được đặt')}</span>
						  </div>
							<div class="intro viewIntroPage">
								{$clsVoucher->getIntro($voucher_id,$oneTable)|html_entity_decode|strip_tags}
							</div>
							<span class="read__more viewMore d-block">{$core->get_Lang('Read more')}</span>
							<div class="PriceDetail">
								<div class="ContentLeft">
									{if $is_discount}
									<span class="oldPrice">{$core->get_Lang('Old Price')}: <span class="priceol">{$clsVoucher->getPricePromotion($voucher_id,$oneTable)}</span></span>
									{/if}
									<span class="newPrice">{$clsVoucher->getPrice($voucher_id,$oneTable)} </span>
									<span class="TextVat">{if $clsVoucher->getTaxable($voucher_id,$oneTable) eq '1'} {$core->get_Lang('Prices include VAT')} {else}{$core->get_Lang('Price does not include VAT')} {/if}</span>
								</div>
								<div class="ContentRight">
									
									 <div class="addthis_toolbox addthis_default_style" addthis:media="{$DOMAIN_NAME}{$clsVoucher->getImage($voucher_id,400,300,$oneTable)}" addthis:url="{$DOMAIN_NAME}{$clsVoucher->getLink($voucher_id,$oneTable)}" addthis:title="{$title_service}">
										<div class="fb-like" data-href="{$DOMAIN_NAME}{$curl}" data-width="220" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
<!--									  <a class="facebook" onclick="openInNewWindow('https://www.facebook.com/sharer/sharer.php?u={$PCMS_URL}{$_productLink}')"  href="javascript:(void);">{$core->get_Lang('Like')}</a>-->
										<a class="addthis_counter addthis_pill_style"></a>
									</div> 
									<script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=thiembv"></script>
								</div>
							</div>
							<div class="BookVoucher">
								<div class="topBox">
								<span class="totalVoucher">{$core->get_Lang('Còn')} {$clsStock->getTotal($voucher_id)}  {$core->get_Lang('Voucher')}</span>
								{if $is_discount && $is_due_date}
								<span id="countdown" data-date="{$due_date|date_format:"%Y/%m/%d %H:%M"}" class="countdown countdown-timer"></span>
								{/if}
								</div>
								{if $TotalStock}
								<form action="" method="post" class="cmxform">
									{assign var=ticket value=$core->get_Lang('ticket')}
									{math assign="StockP" equation="x + 1" x=$TotalStock}
									{if $TotalStock gt '50'}
									<select name="number_voucher" id="number_voucher">
										{$clsISO->makeSelectNumber2(51,$number_voucher,"$ticket,$ticket")}
									</select>
									{else}
									<select name="number_voucher" id="number_voucher">
										{$clsISO->makeSelectNumber2($StockP,$number_voucher,"$ticket,$ticket")}
									</select>
									{/if}
									<input type="hidden" name="voucher_id" value="{$voucher_id}" />
									<input type="hidden" name="BookingVoucher" id="BookingVoucher" value="BookingVoucher" />
									{if $is_discount}
									<input type="hidden" name="discount_id" value="{$discount_id}">
									<input type="hidden" name="discount_value" value="{$discount_value}">
									<input type="hidden" name="discount_type" value="{$discount_type}">
									{/if}
									<button type="submit" class="bookVoucher btn_main">{$core->get_Lang('Booking now')}</button>
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
					<div class="col-md-8">
						<div id="tabsk" class="box__menu tabskVoucher">
						{assign var=TimeCheck value=$clsVoucher->getCheckTime($voucher_id)|html_entity_decode}
					 	{assign var=TimeApplication value=$clsVoucher->getTimeApplication($voucher_id,$oneTable)|html_entity_decode}
							<ul class="clienttabs list_style_none d-flex">
						   	   {if $TimeCheck}
							   <li class="first"><a id="overview--link" href="javascript:void(0);">{$core->get_Lang('Details')}</a></li>
							   <li><a id="condition--link" href="javascript:void(0);">{$core->get_Lang('Conditions apply')}</a></li>
							   {if $clsISO->getCheckActiveModulePackage($package_id,'reviews','default','default','voucher')}
							   <li><a id="reviews--link" href="javascript:void(0);">{$core->get_Lang('Review')}</a></li>
							   {/if}
							   {elseif $TimeApplication}
							   <li class="first"><a id="condition--link" href="javascript:void(0);">{$core->get_Lang('Conditions apply')}</a></li>
							   {if $clsISO->getCheckActiveModulePackage($package_id,'reviews','default','default','voucher')}
							   <li><a id="reviews--link" href="javascript:void(0);">{$core->get_Lang('Review')}</a></li>
							   {/if}
							   {else}
							   {if $clsISO->getCheckActiveModulePackage($package_id,'reviews','default','default','voucher')}
							   <li class="first"><a id="reviews--link" href="javascript:void(0);">{$core->get_Lang('Review')}</a></li>
							   {/if}
							   {/if}
							   
							</ul>
						 </div>
						 
						 <div class="list_tab">
						 
						 	{if $TimeCheck}
						 	<div id="overview" class="overview section__box">
						 	{assign var=Location value=$clsVoucher->getLocation($voucher_id,$oneTable)}
						 	{assign var=Content value=$clsVoucher->getContent($voucher_id,$oneTable)}
						 		{$TimeCheck}
						   </div>
						   {/if}
					 		{if $TimeApplication}
							<div id="condition" class="condition section__box">
					 		{assign var=Inclusion value=$clsVoucher->getInclusion($voucher_id,$oneTable)}
					 		{assign var=Exclusion value=$clsVoucher->getExclusion($voucher_id,$oneTable)}
					 		{assign var=Note value=$clsVoucher->getNote($voucher_id,$oneTable)}
						 		{$TimeApplication}
							</div>
							{/if}
							{if $clsISO->getCheckActiveModulePackage($package_id,'reviews','default','default','voucher')}
							<section id="reviews" class="reviews section__box bg_f7f7f7 phone">
								<h2 class="title_section">{$core->get_Lang('Reviews')}</h2>
								{$core->getBlock('review_Star')}
							</section>
							{/if}
						 </div>
					</div>
					<div class="col-md-1"></div>
					<div class="col-md-3">
						<div class="LocationRight">
						  	<div class="contentRight" style="display: none">
							  <p class="titleLocation">{$core->get_Lang('Location')}</p>
							  {assign var=itemCity value=$clsCity->getOne($ListDestination[0].city_id,'title,map_lo,map_la')}
							  <p class="address">{$clsCity->getTitle($ListDestination[0].city_id,$itemCity)} </p>
							   {assign var=map_la value=$clsCity->getMapLa($ListDestination[0].city_id,$itemCity)}
							   {assign var=map_lo value=$clsCity->getMapLo($ListDestination[0].city_id,$itemCity)}
							 <div id="map">
								<div id="map_canvas" style="height:235px; float:right;width: 100%"></div>
							</div>
							</div>
							{if $lstVoucherRecommend}
							<div class="listVoucherRe">
								<p class="titleBoxVoucher titleLocation">{$core->get_Lang('Voucher interested')}</p>
								{section name=i loop=$lstVoucherRecommend}
									{assign var=voucher_id value=$lstVoucherRecommend[i].voucher_id}
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
                                           <div class="box__padding">
												<div class="itemTrip {$deviceType}">
                                      				<a href="{$getLink}" title="{$getTitle}">
                                      					<div class="image relative">
															<img src="{$clsConfiguration->getImage('default_image_pixel',296,196)}" data-src="{$clsVoucher->getImage($voucher_id,296,196,$lstVoucherRecommend[i])}" alt="{$getTitle}" class="owl-lazy lazy img100">
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
															<h3 class="body__title limit_2line color_1c1c1c">{$getTitle}</h3>
															<div class="body_info_voucher">
																<div class="body_review">
																	<span class="rate-2019">{$getStarNew}</span>
																	<span>{$getRateAvg}/5.0</span>
																	<span class="totalReview">| {$getToTalReview} {$core->get_Lang('reviews')}</span>
																</div>
																<div class="body_price">
																{if $is_discount}
																<span class="oldPrice">{$core->get_Lang('Old Price')}: <span class="priceol">{$clsVoucher->getOldPrice($voucher_id,$lstVoucherRecommend[i])}</span></span>
																{/if}
																<span class="newPrice">{$clsVoucher->getPrice($voucher_id,$lstVoucherRecommend[i])} </span>
																<span class="totalBook">{$core->get_Lang('Còn')} {$clsStock->getTotal($voucher_id)}  {$core->get_Lang('Voucher')}</span>
																</div>
															</div> 
														</div>
													</a>
											   </div>
										   </div>
								{/section}
							</div>
							{/if}
						</div>
				  </div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	var map_la = '{$map_la}';
	var map_lo = '{$map_lo}';
</script>
{literal}
<script>
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
					nav: false,
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
	 $.lockfixed("#tabsk", {offset: {top:70,bottom:500}});
//	 $.lockfixed(".LocationRight", {offset: {top:70,bottom:700}});
	}
	$('.contentVoucher .viewIntroPage').each(function(){
			var $_this = $(this);
			if($_this.height()>70){
				$_this.css("height","70px");
				$_this.closest(".contentVoucher").find(".read__more").show();
			}else{
				$_this.closest(".contentVoucher").find(".read__more").hide();
				$_this.closest(".contentVoucher").find(".viewIntroPage").removeClass( "bg_transparent" );
			}
		});
		$(document).on("click",".contentVoucher .read__more",function(){
			var $_this = $(this); 
			if(!$_this.hasClass("less")){
				$_this.addClass("less");
				$_this.closest(".contentVoucher").find(".viewIntroPage").css("height","auto");
				$_this.html('{/literal}{$core->get_Lang("Less")}{literal}');
				$_this.closest(".contentVoucher").find(".viewIntroPage").removeClass( "bg_transparent" );
			}
			else{
				$_this.removeClass("less");
				$_this.closest(".contentVoucher").find(".viewIntroPage").css("height","70px");
				$_this.closest(".contentVoucher").find(".viewIntroPage").addClass( "bg_transparent" );
				$_this.html('{/literal}{$core->get_Lang("Read more")}{literal}');
			}
		}); 
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

</script>
{/literal}