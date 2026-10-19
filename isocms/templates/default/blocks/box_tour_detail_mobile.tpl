{assign var=title_tour value=$clsTour->getTitle($tour_id)}
{assign var=oneItemCatTour value=$clsTourCategory->getOne($tourcat_id,'title,slug')}
{assign var=titleCatTour value=$oneItemCatTour.title}
{assign var=linkCatTour value=$clsTourCategory->getLink($tourcat_id,$oneItemCatTour)}

{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
{assign var=getToTalReview value=$clsReviews->getToTalReview($tour_id,'tour')}
{assign var=getStarNew value=$clsReviews->getStarNew($tour_id,'tour')}
{assign var=getRateAvg value=$clsReviews->getRateAvg($tour_id,'tour')}
{else}
{assign var=getToTalReview value=$clsReviews->getToTalReviewNoLogin($tour_id,'tour')}
{assign var=getStarNew value=$clsReviews->getStarNewNoLogin($tour_id,'tour')}
{assign var=getRateAvg value=$clsReviews->getRateAvgNologin($tour_id,'tour')}
{/if}
{assign var = _Inclusion value = $clsTour->getInclusion($tour_id,$oneItem)}
{assign var = _Exclusion value = $clsTour->getExclusion($tour_id,$oneItem)}
{assign var = _ThingToCarry value = $clsTour->getThingToCarry($tour_id,$oneItem)}
{assign var = _CancellationPolicy value = $clsTour->getCancellationPolicy($tour_id,$oneItem)}
{assign var = _RefundPolicy value = $clsTour->getRefundPolicy($tour_id,$oneItem)}
{assign var = _ConfirmationPolicy value = $clsTour->getConfirmationPolicy($tour_id,$oneItem)}
<div class="page_container page_tour">
	<main class="pageDetail TourDetail bg_fff">
		<div class="tour__header">
			<div class="tour__header--child">
				<div class="container">
					<h1 class="title">{$title_tour}</h1>
					{if $getToTalReview}
					<div class="tour_rate box_col">
						<label class="rate-2019 block mb05">{$getStarNew}</label>
						<span class="review_text color_666">{$getRateAvg}/5.0</span> <span class="total__reviews text_bold">{$getToTalReview} {$core->get_Lang('reviews')}</span>
					</div>
					{/if}
				</div>
			</div>
			{$core->getBlock('slider_DetailTour')}
		</div>
		<div class="price__Box phone">
			{assign var=date_coutdown value=$clsTourStartDate->getStartDateTour($lstTourStartDate[0].tour_start_date_id,'date_coutdown')}
			{assign var=getFlagText value=$clsPromotion->getFlagText($promotion_id)}
			{assign var=checkmem value=$clsTour->getCheckMemSet($tour_id)}
			{assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent,'detail')}
			{if $date_coutdown }
				<div class="container">
					{if $getFlagText}
					<div class="sale_off">{$getFlagText}</div>
					{/if}
					<div class="box__price phone {if empty($getFlagText)}border_top{/if}">
						<div class="price">
							{if $getPriceTourPromotion}
								{$core->get_Lang('Fromm')} {$getPriceTourPromotion}
							{/if}
						</div>
						<div class="offerDate phone">
							<div class="d-flex offerDate__box">
								<div class="text_bold color_24b89c text_deal">{$core->get_Lang('Last minute deal')}</div>
								<div class="sale_clock">
									<ul class="clock lastHour" data-date="{$date_coutdown}"
										data-promotion_id="{$promotion_id}" style="float:left !important">
										<li><span class="days fw600 fs30">00</span>
											<p class="days_text ">{$core->get_Lang('Days')}</p></li>
										<li><span class="hours fw600 fs30">00</span>
											<p class="hours_text ">{$core->get_Lang('Hours')}</p></li>
										<li><span class="minutes fw600 fs30">00</span>
											<p class="minutes_text ">{$core->get_Lang('Mins')}</p></li>
										<li><span class="seconds fw600 fs30">00</span>
											<p class="seconds_text ">{$core->get_Lang('Secs')}</p></li>
									</ul>
								</div>
							</div>
							{if $first_start_date}
							<p class="mt10 text_right">{$core->get_Lang('Latest departure date')}: {$first_start_date}</p>
							{/if}
						</div>
					</div>
				</div>
				<div class="btn_box">
					<button class="btn_scroll btn_yellow btn_main">{$core->get_Lang('Choose departure date')}</button>
				</div>
			{else}
				{if $getPriceTourPromotion }
				<div class="container">
					{if $getFlagText}<div class="sale_off">{$getFlagText}</div>{/if}
					<div class="box__price phone {if $getPriceTourPromotion }box_shadow_pro{else}box_shadow{/if} {if empty($getFlagText)}border_top{/if}">
						<div class="price">
							{$core->get_Lang('Fromm')}
							{$getPriceTourPromotion} 
						</div>
					</div>
					{if $first_start_date}
						<div class="offerDate">
							<p>{$core->get_Lang('Latest departure date')}: {$first_start_date}</p>
						</div>
					{/if}
				</div>
				<div class="btn_box">
					<button class="btn_scroll btn_yellow btn_main">{$core->get_Lang('Choose departure date')}</button>
				</div>
				{else}
				<div class="container">
					<div class="hotline">
						<a class="img_phone" title="Call now" href="tel:{$clsConfiguration->getValue('CompanyHotline')}">
							<img src="{$URL_IMAGES}/icon/telephone.png" alt="">
						</a>
						<div class="infor_contact">
							<span> {$core->get_Lang('Hotline')} 24/7</span>
							<a title="{$core->get_Lang('Call now')}" href="tel:{$clsConfiguration->getValue('CompanyHotline')}">{$clsConfiguration->getValue('CompanyHotline')}</a>
						</div>
					</div>
				</div>
				<div class="btn_box">
					<button class="btn_scroll btn_yellow btn_main">{$core->get_Lang('Choose departure date')}</button>
				</div>
				{/if}
			{/if}
		</div>
		<div class="tour__content">
			<div class="container">
				<div class="list_tab phone tinymce_Content">
					<section id="overview" class="overview section__box">
						<div class="accordion" id="accordionExample">
						  <div class="card">
							<div class="card-header" id="headingOne">
							  <h3 class="title">
								<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
								  {$core->get_Lang('Overviewz')}
									<i class="fa fa-angle-up pull-right"></i>
								</a>
								  
							  </h3>
							</div>

							<div id="collapseOne1" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
							  <div class="card-body">
								<ul class="overview__list list__item list_style_none text_bold">
									{assign var=address value=$clsTour->getLCityAround2($tour_id)}
									{assign var=Depart_point value=$clsTour->getListDeparturePointLink($tour_id)}
									{assign var=getTripDuration value=$clsTour->getTripDuration2019($tour_id)}
									{if $getTripDuration}<li class="item itinerary">{$core->get_Lang('Itinerary')}: {$getTripDuration}</li>{/if}
									{if $Depart_point}<li class="item departure_point">{$core->get_Lang('Depart from')}: {$Depart_point}</li>{/if}
									{if $address}<li class="item destintions">{$core->get_Lang('Destintions')}: {$address}</li>{/if}
								</ul>
								<div class="intro">
									{$clsTour->getTripOverview($tour_id)}
								</div>
							  </div>
							</div>
						  </div>
						{if $getKeyInfo}
						  <div class="card">
							<div class="card-header" id="headingTwo">
							  <h3 class="title">
								<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
								  {$core->get_Lang('Key infomation')}
									<i class="fa fa-angle-up pull-right"></i>
								</a>
							  </h2>
							</div>
							<div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
							  <div class="card-body">
								<div class="key__infomation--list">
									{$getKeyInfo}
								</div>
							  </div>
							</div>
						  </div>
						{/if}
						</div>
					</section>
					<section id="avaiable" class="avaiable section__box">
						{$clsISO->getBlock("box_find_tour")}
					</section>
					{if $lstItineraryTour}
					<section id="itinerary" class="itinerary section__box">
						
						<div class="accordion" id="accordionItinerary">
							{section name=i loop=$lstItineraryTour}
							{assign var=tourItinerary_id value=$lstItineraryTour[i].tour_itinerary_id}
							{assign var=lst_transport_id value=$lstItineraryTour[i].transport}
							{assign var=lstItineraryTransport value=$clsTransport->getAll("is_trash=0 and is_online=1 and transport_id in ($lst_transport_id) order by order_no ASC")}
							{assign var=_ItineraryContent value=$lstItineraryTour[i].content}
							{assign var=_ItineraryImage value=$clsTourItinerary->getImageUrl($tourItinerary_id)}
							<div class="card">
								<div class="card-header" id="itinerary_{$smarty.section.i.iteration}">
									<h3 class="title">
										<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseitinerary_{$smarty.section.i.iteration}" aria-expanded="true" aria-controls="collapseitinerary_{$smarty.section.i.iteration}">
										{$clsTourItinerary->getTitleItineraryNew($tourItinerary_id)}
										<i class="fa fa-angle-up pull-right"></i>
										</a>
									</h3>
								</div>
								<div id="collapseitinerary_{$smarty.section.i.iteration}" class="collapse" aria-labelledby="itinerary_{$smarty.section.i.iteration}" data-parent="#accordionItinerary">
									<div class="card-body">
										<div class="detail tinymce_Content">
											<p itinerary_id="{$lstItineraryTour[i].tour_itinerary_id}" class="day_Itinerary color_999 size16 mb0">
												{$clsISO->converTimeToText5($list_itinerary.$tourItinerary_id)}
											</p>
											{if $lstItineraryTour[i].is_show_image eq '1' and $_ItineraryImage ne ''}
											<div class="photo">
												<img class="photo275 image full-width height-auto"
												src="{$_ItineraryImage}" alt=""/>
											</div>
											<div class="introItinerary">
												{$_ItineraryContent|html_entity_decode}
											</div>
											{else}
												{$_ItineraryContent|html_entity_decode}
											{/if}
											{assign var=listHotel value=$clsHotel->getListByItinerary($tour_id,$tourItinerary_id)}
											{if $listHotel}
											<div class="cleafix"></div>
											<div class="HotelTourAcc mtl0">
												<span class="d-block">{$core->get_Lang('Hotels')}:</span>
												<ul class="inline-block">
													{section name=h loop=$listHotel}
														{assign var=_HotelName value=$clsHotel->getTitle($listHotel[h].hotel_id)}
														{assign var=star_id value=$clsHotel->getOneField('star_id',$listHotel[h].hotel_id)}
														<li>
															<h4 class="mb5 size16">
																<a target="_blank"
																   href="{$clsHotel->getLink($listHotel[h].hotel_id)}"
																   title="{$_HotelName}">{$_HotelName}</a>
																{if $clsHotel->getImageStar($star_id) ne ''}
																	<img src="{$clsHotel->getImageStar($star_id)}"
																		 alt="{$_HotelName}"/>
																{/if}
															</h4>
														</li>
													{/section}
												</ul>
											</div>
											{/if}
										</div>
									</div>
								</div>
							</div>
							{/section}
						</div>
                         {if $clsTour->getFileProgram($tour_id) && $clsISO->getCheckActiveModulePackage($package_id,'tour_exhautive','tour_program_file','customize')}
                        <div class="itnerary_file">
                            <div class="flex_1">
                                <div class="icon"><img src="{$URL_IMAGES}/icon/icon_file.svg" /></div>
                                <div class="text">
                                    <p class="bold p_text_1">{$core->get_Lang('Want to read it later')}?</p>
                                    <p class="bold p_text_2">{$core->get_Lang('Download this tour’s PDF brochure and start tour planning offline')}</p>
                                </div>
                            </div>
                            
                            <div class="btn_download">
                                <a class="btn_download_file" title="{$core->get_Lang('Download Brochure')}" download="{$clsTour->getFileProgram($tour_id)}" href="{$clsTour->getFileProgram($tour_id)}">{$core->get_Lang('Download Brochure')}</a></a>
                            </div>
                        </div>
                        {/if}
					</section>
					{/if}
					{if $_Inclusion || $_Exclusion || $_ThingToCarry || $_CancellationPolicy || $_RefundPolicy || $_ConfirmationPolicy || $listCustomField}
					<section id="important__noted" class="important__noted  section__box">
						<h2 class="title_section">{$core->get_Lang('Important noted')}</h2>
						<div class="accordion important__noted--box" id="accordionImportant">
							{if $_Inclusion}
							<div class="card">
								<div class="card-header" id="Inclusion">
									<h3 class="title title_inclusion">
										<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseInclusion" aria-expanded="true" aria-controls="collapseInclusion">
										{$core->get_Lang('Trip Inclusion')}
										<i class="fa fa-angle-up pull-right"></i>
										</a>
									</h3>
								</div>
								<div id="collapseInclusion" class="collapse" aria-labelledby="Inclusion" data-parent="#accordionImportant">
									<div class="card-body">
										<div class="list-check plus">{$_Inclusion}</div>
									</div>
								</div>
							</div>
							{/if}
                            {if $_Exclusion}
							<div class="card">
								<div class="card-header" id="Exclusion">
									<h3 class="title title_exclusion">
										<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseExclusion" aria-expanded="true" aria-controls="collapseExclusion">
										{$core->get_Lang('Trip Exclusions')}
										<i class="fa fa-angle-up pull-right"></i>
										</a>
									</h3>
								</div>
								<div id="collapseExclusion" class="collapse" aria-labelledby="Exclusion" data-parent="#accordionImportant">
									<div class="card-body">
										<div class="list-check minus">{$_Exclusion}</div>
									</div>
								</div>
							</div>
							{/if}
							{if $_ThingToCarry}
							<div class="card">
								<div class="card-header" id="ThingToCarry">
									<h3 class="title title_thing_to_carry">
										<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThingToCarry" aria-expanded="true" aria-controls="collapseThingToCarry">
										{$core->get_Lang('Thing To Carry')}
										<i class="fa fa-angle-up pull-right"></i>
										</a>
									</h3>
								</div>
								<div id="collapseThingToCarry" class="collapse" aria-labelledby="ThingToCarry" data-parent="#accordionImportant">
									<div class="card-body">
										<div class="list-dot">{$_ThingToCarry}</div>
									</div>
								</div>
							</div>
							{/if}
							{if $_CancellationPolicy}
							<div class="card">
								<div class="card-header" id="CancellationPolicy">
									<h3 class="title title_cancellationpolicy">
										<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseCancellationPolicy" aria-expanded="true" aria-controls="collapseCancellationPolicy">
										{$core->get_Lang('Cancellation Policy')}
										<i class="fa fa-angle-up pull-right"></i>
										</a>
									</h3>
								</div>
								<div id="collapseCancellationPolicy" class="collapse" aria-labelledby="CancellationPolicy" data-parent="#accordionImportant">
									<div class="card-body">
										<div class="list-dot">{$_CancellationPolicy}</div>
									</div>
								</div>
							</div>
							{/if}
							{if $_RefundPolicy}
							<div class="card">
								<div class="card-header" id="RefundPolicy">
									<h3 class="title title_refundpolicy">
										<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseRefundPolicy" aria-expanded="true" aria-controls="collapseRefundPolicy">
										{$core->get_Lang('Refund Policy')}
										<i class="fa fa-angle-up pull-right"></i>
										</a>
									</h3>
								</div>
								<div id="collapseRefundPolicy" class="collapse" aria-labelledby="RefundPolicy" data-parent="#accordionImportant">
									<div class="card-body">
										<div class="list-dot">{$_RefundPolicy}</div>
									</div>
								</div>
							</div>
							{/if}
							{if $_ConfirmationPolicy}
							<div class="card">
								<div class="card-header" id="ConfirmationPolicy">
									<h3 class="title title_confirmationpolicy">
										<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseConfirmationPolicy" aria-expanded="true" aria-controls="collapseConfirmationPolicy">
										{$core->get_Lang('Confirmation Policy')}
										<i class="fa fa-angle-up pull-right"></i>
										</a>
									</h3>
								</div>
								<div id="collapseConfirmationPolicy" class="collapse" aria-labelledby="ConfirmationPolicy" data-parent="#accordionImportant">
									<div class="card-body">
										<div class="list-dot">{$_ConfirmationPolicy}</div>
									</div>
								</div>
							</div>
							{/if}
							{if $listCustomField}
							{section name=i loop=$listCustomField}
							<div class="card">
								<div class="card-header" id="listCustomField_{$smarty.section.i.iteration}">
									<h3 class="title title_customfield">
										<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapselistCustomField_{$smarty.section.i.iteration}" aria-expanded="true" aria-controls="collapselistCustomField_{$smarty.section.i.iteration}">
										{$listCustomField[i].fieldname}
										<i class="fa fa-angle-up pull-right"></i>
										</a>
									</h3>
								</div>
								<div id="collapselistCustomField_{$smarty.section.i.iteration}" class="collapse" aria-labelledby="listCustomField_{$smarty.section.i.iteration}" data-parent="#accordionImportant">
									<div class="card-body">
										<div class="list-dot">{$listCustomField[i].fieldvalue|html_entity_decode}</div>
									</div>
								</div>
							</div>
							{/section}
							{/if}
						</div>
					</section>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,'reviews','default','default','tour')}
					<section id="reviews" class="reviews section__box bg_f7f7f7 phone">
						<h2 class="title_section">{$core->get_Lang('Reviews')}</h2>
						{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
                        {$clsISO->getBlock('review_Star',["tour_id"=>$tour_id,"getToTalReview"=>$getToTalReview])}
                        {else}
                        {$clsISO->getBlock('review_Star_No_Login',["tour_id"=>$tour_id,"getToTalReview"=>$getToTalReview])}
                        {/if}
					</section>
					{/if}
					{$core->getBlock('Lfaqscolbox')}
				</div>
			</div>
		</div>
        {$core->getBlock('box_service_ad')}
		{if $clsISO->getCheckActiveModulePackage($package_id,'tour','tour_related','customize')}
		<div class="tour___foot">
			<div class="container">
				
				{$core->getBlock('relatetour')}
				
			</div>
		</div>
		<div class="cleafix mb30"></div>
		{/if}
	</main>
</div>
<script>
    var $tour_id = '{$tour_id}';
    var $Loading = '{$core->get_Lang("Loading")}';
    var selectmonth='{$core->get_Lang("select month")}';
    var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
    var Input_data_is_required='{$core->get_Lang("Select data is required")}';
    var $_Expand_all = '{$core->get_Lang("Expand all")}';
    var $_Collapse_all = '{$core->get_Lang("Collapse all")}';
    var $_LANG_ID = '{$_LANG_ID}';
    var Adults='{$core->get_Lang("Adults")}';
    var Children='{$core->get_Lang("Children")}';
    var Infants='{$core->get_Lang("Infants")}';
    var Departure_date_invalid='{$core->get_Lang("Departure date is invalid")}';
	var Please_choose_departure_date='{$core->get_Lang("Please choose departure date")}';
	var Warning='{$core->get_Lang("Warning")}';
    var list_start_date=['{$list_start_date}'];
    var $check_tour_promotion='{$check_tour_promotion}';
	var $check_tour_start_date='{$check_tour_start_date}';
	 
	var getSelectChild 	= `{$getSelectChild}`; 
	var getSelectInfant 	= `{$getSelectInfant}`; 
</script>
{$date_range_js_update}
<script src="{$URL_JS}/jquery.countdown.min.js?v={$upd_version}"></script>
<script src="{$URL_JS}/jquery-confirm.min.js?v={$upd_version}"></script>
{literal}
	<script>

		$(function(){
			var $ww = $(window).width();
			var $heightFooter = $('#footer').outerHeight();
			var $heightAZ = $('.tour___foot').outerHeight();
			var $price__BoxAZ = $('.price__Box').offset().top + 50;
			if ($ww < 1200 ){
				x = 68;
				}else {
				x = 109;
					
			}
			if($ww >992){
				$.lockfixed(".price__Box", {offset: {top:x, bottom:  $heightFooter + $heightAZ}});
			}
			$(document).scroll(function(){
				if($price__BoxAZ <= $(this).scrollTop()) {
					$(".btn_box").addClass('fixed');
				} else {
					$(".btn_box").removeClass('fixed');
				}
			});

			$(document).on("click",".trigger_contact",function() {
				$('.contact_now').trigger('click');
			});
			$('.close_tb').click(function(){
				var  $_this=$('#pick_travellers');
				if($_this.hasClass('open')){
					$('#che').removeClass('bg-black');
					$('#check_number_travellers').hide();
					$_this.closest('.number_travellers').removeClass('open');
					$_this.removeClass('open');
				}else{
					$('#che').addClass('bg-black');
					$('#check_number_travellers').show();
					$_this.closest('.number_travellers').addClass('open');
					$_this.addClass('open');
				}
			});
			$(".btn_scroll ").click(function() {
				$('html, body').animate({
					scrollTop: $("#avaiable").offset().top - 111
				}, 600);
			});

		});
	</script>
{/literal}
{if $clsReviews->getToTalReview($tour_id,$mod) gt 0}
{literal}
<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "{/literal}{$title_tour}{literal}",
  "url": "{/literal}{$DOMAIN_NAME}{$clsTour->getLink($tour_id)}{literal}",
  "description": "{/literal}{$clsTour->getTripOverview($tour_id)|strip_tags}{literal}",
 "image": "{/literal}{$DOMAIN_NAME}{$clsTour->getImage($tour_id,300,200)}{literal}",
  "brand": {
    "@type": "Thing",
    "name": "Tour"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
	"ratingValue": "{/literal}{$clsReviews->getRateAvg($tour_id,$mod)}{literal}",
    "bestRating": "{/literal}{$clsReviews->getBestRate($tour_id,$mod)}{literal}",
    "ratingCount": "{/literal}{$clsReviews->getToTalReview($tour_id,$mod)}{literal}"
  }
}
</script>
{/literal}
{/if}
{literal}
<script>
	$('.clock').each(function () {
		var $_this = $(this);
		var $_date = $_this.data('date');
		var $promotion_id = $_this.data('promotion_id');
		$_this.countdown($_date, function (event) {
			var $this = $(this).html(event.strftime(''
					+ '<li><span class="days">%D</span><p class="days_text">' + Days + '</p></li>'
					+ '<li><span class="hours">%H</span><p class="hours_text">' + Hours + '</p></li>'
					+ '<li><span class="minutes">%M</span><p class="minutes_text">' + Minutes + '</p></li>'
					+ '<li><span class="seconds">%S</span><p class="seconds_text">' + Seconds + '</p></li>'
			));
		});
	});
	function goToByScroll(id) {
		id = id.replace("--link", "");
		$('html,body').animate({
			scrollTop: $("#" + id).offset().top - 120
		},
		'slow');
	}
	$("#tabsk > ul li a").click(function (e) {
		e.preventDefault();
		goToByScroll($(this).attr("id"));
	});
	$(document).ready(function () {
		var $windown_w = $(window).width();
		var scrollOut = $('#footer').offset().top;
		$(window).scroll(function () {
			if ($windown_w > 1200) {
				if ($(this).scrollTop() > {/literal}{if $deviceType eq 'phone'}240{else}600{/if}{literal} && $(this).scrollTop() < scrollOut) {
					$('#tabsk').css({
						"position": "fixed",
						"top": "68px",
						"z-index": "999",
						"width": "100%",
					});
					$('#tabsk').addClass('fixed').fadeIn();
				} else {
					$('#tabsk').removeAttr('style').fadeIn();
					$('#tabsk').removeClass('fixed');
				}
			}
		});
	});
</script>
<style type="text/css">
	
</style>
{/literal}
