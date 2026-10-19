<script>
	var $tour_id = '{$tour_id}';
	var $Loading = '{$core->get_Lang("Loading")}';
	var selectmonth='{$core->get_Lang("select month")}';
	var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
</script>
{assign var=title_tour_detail value=$clsTour->getTitle($tour_id)}
<div class="page_container">
	<nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff pd15_0" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$PCMS_URL}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="hidden-xs">
                  <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$curl}" title="{$core->get_Lang('Tour')}">
                    <span itemprop="name" class="reb">{$core->get_Lang('Tour')}</span>
                  </a>
					<meta itemprop="position" content="2" />
               </li>
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="hidden-xs">
                  <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$clsTourCategory->getLink($tourcat_id)}" title="{$clsTourCategory->getTitle($tourcat_id)}">
                    <span itemprop="name" class="reb">{$clsTourCategory->getTitle($tourcat_id)}</span>
                  </a>
				   <meta itemprop="position" content="3" />
               </li>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active">
                    <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="javascript:void(0);" title="{$title_tour_detail}">
                    <span itemprop="name" class="reb">{$title_tour_detail}</span>
                    </a>
					<meta itemprop="position" content="4" />
                </li>
            </ol>
        </div>
    </nav>
	<div class="pageDetail TourDetail bg_f1f3f3 pd25_0">
		{if 1 eq 2}
		<div class="zalo-share-button" data-href="{$DOMAIN_NAME}/{$clsTour->getLink($tour_id)}" data-oaid="579745863508352884" data-layout="2" data-color="blue" data-customize=false></div>
		{/if}
		<div class="container">
			<div class="row">
				<div class="col-md-8 floatRight_992 mb991_30">
					<article class="cd-header">
						{*<div class="sharethis-inline-share-buttons"></div>*}
						<h1 class="size24 mb10">{$title_tour_detail}</h1>
						{assign var=address value=$clsTour->getLCityAround2($tour_id)}
						{assign var=Depart_point value=$clsTour->getListDeparturePoint($tour_id)}
							{if $Depart_point}
								<address class="" style="margin-bottom: 5px;"><span class="fa fa-map-marker c2a color_main size16"></span> {$core->get_Lang('Departure point')}: {$Depart_point}</address>
							{/if}
						{if $address}
						<address class="mb20"><span class="fa fa-map-marker c2a color_main size16"></span> {$core->get_Lang('Destintions')}: {$address}</address>
						{/if}
					</article>
					<div class="hotelsDetail-imges hidden1140">
						{$core->getBlock('jssorimageSlide2')}
						{assign var=promotion_id value=$clsTour->getPromotionIdPro($tour_id,'Tour')}
						{if $promotion_id}
						<div class="flag-text__promotion" style="display:none;">
							{$clsPromotion->getFlagText($promotion_id)}
						</div>
						{/if}
					</div>
					<div class="cd-bottom">
						<div class="lCityAround">
							<div class="start w30 text-left">
								<span class="text_upper mb10">{$core->get_Lang('Starts')}</span>
								<span class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
								<span>{$clsTour->getStartCityAround($tour_id)}</span>
							</div>
							<div class="center w40 text-center">
								{assign var=getNumberOtherCityAround value=$clsTour->getNumberOtherCityAround($tour_id)}
								{if $getNumberOtherCityAround gt 0}
								<span class="text_upper mb10">+ {$getNumberOtherCityAround} {$core->get_Lang('Destinations')}</span>
								<span class="icon"></span>
								<span>{$clsTour->getLOtherCityAround($tour_id)}</span>
								{else}
								<span>&nbsp;</span>
								{/if}
							</div>
							<div class="end w30 text-right">
								<span class="text_upper mb10">{$core->get_Lang('Ends')}</span>
								<span class="icon"><i class="fa fa-flag size12" aria-hidden="true"></i></span>
								<span>{$clsTour->getEndCityAround($tour_id)}</span>
							</div>
						</div>
					</div>
					<div class="box-info__tour_mb mt20" style="display:none;">
						<ul>
							<li>
								<span class="block">
								{$core->get_Lang('Duration')}
								</span>
								<span class="size18">{$clsTour->getNumberDayDuration($tour_id)}</span>
							</li>
							<li>
								<span class="block">
								{$core->get_Lang('Price from')}
								</span>
								{$clsTour->getTripPrice($tour_id,$now_day,$is_agent,'detail')}
							</li>
							<li>
								<span class="block">
								{$core->get_Lang('Trip code')}
								</span>
								<span class="block size18">{$clsTour->getTripCode($tour_id)}</span>
							</li>
						</ul>
					</div>
					<div class="cd-tabs" id="navbar-detail">
						<div class="mb20"></div>
						<article class="bg_fff tab-item mb30" id="overview">
							<img class="map" src="{$URL_IMAGES}/Maps.png" alt="" width="280" height="180" style="float:right; margin-left:20px;">
							{$core->getBlock('Lbox_map_tour')}
							{if $clsTour->getTripOverview($tour_id)}
							<h3 class="tit-item overview">{$core->get_Lang('Trip overview')}</h3>
							<div class="it-item">
								<div class="tinymce_Content width-auto">
									 {$clsTour->getTripOverview($tour_id)}
								</div>
							</div>
							{/if}
						</article>
						{assign var = _Inclusion value = $clsTour->getInclusion($tour_id)}
						{assign var = _Exclusion value = $clsTour->getExclusion($tour_id)}
						{assign var = _ThingToCarry value = $clsTour->getThingToCarry($tour_id)}
						{assign var = _CancellationPolicy value = $clsTour->getCancellationPolicy($tour_id)}
						{assign var = _RefundPolicy value = $clsTour->getRefundPolicy($tour_id)}
						{assign var = _ConfirmationPolicy value = $clsTour->getConfirmationPolicy($tour_id)}
						{if $_Inclusion || $_Exclusion || $_ThingToCarry || $_CancellationPolicy || $_RefundPolicy || $_ConfirmationPolicy || $listCustomField}
						<article class="bg_fff tab-item mb30" id="content">
							<a href="javascript:void(0);" class="Expand_all fr">{$core->get_Lang('Expand all')}</a>
							<div class="clearfix"></div>
							{if $_Inclusion}
							<h4 class="bg_fff z_14 slideToggle">{$core->get_Lang('Trip Inclusion')}</h4>
							<div class="it-body">
								<div class="list-check plus">{$_Inclusion}</div>
							</div>
							{/if}

							{if $_Exclusion}
							<h4 class="bg_fff exclusion z_14 slideToggle">{$core->get_Lang('Trip Exclusions')}</h4>
							<div class="it-body">
								<div class="list-check minus">{$_Exclusion}</div>
							</div>
							{/if}

							{if $_ThingToCarry}
							<h4 class="bg_fff z_14 slideToggle">{$core->get_Lang('Thing To Carry')}</h4>
							<div class="it-body">
								<div class="list-dot">{$_ThingToCarry}</div>
							</div>
							{/if}

							{if $_CancellationPolicy}
							<h4 class="bg_fff z_14 slideToggle">{$core->get_Lang('Cancellation Policy')}</h4>
							<div class="it-body">
								<div class="list-dot">{$_CancellationPolicy}</div>
							</div>
							{/if}

							{if $_RefundPolicy}
							<h4 class="bg_fff z_14 slideToggle">{$core->get_Lang('Refund Policy')}</h4>
							<div class="it-body">
								<div class="list-dot">{$_RefundPolicy}</div>
							</div>
							{/if}

							{if $_ConfirmationPolicy}
							<h4 class="bg_fff z_14 slideToggle">{$core->get_Lang('Confirmation Policy')}</h4>
							<div class="it-body">
								<div class="list-dot">{$_ConfirmationPolicy}</div>
							</div>
							{/if}

							{if $listCustomField}
							{section name=i loop=$listCustomField}
							<h4 class="bg_fff z_14 slideToggle">{$listCustomField[i].fieldname}</h4>
							<div class="it-body">
								<div class="list-dot">{$listCustomField[i].fieldvalue|html_entity_decode}</div>
							</div>
							{/section}
							{/if}

						</article>
						{/if}
						{if $lstItineraryTour}
						<article class="tab-item tabFullItinerary bg_fff" id="fullItinerary">
							{if $clsConfiguration->getValue('SiteHasProgramFile_Tours') and $clsTour->getFileProgram($tour_id)}
							<a class="btn_download_file fr" title="{$core->get_Lang('DOWNLOAD PDF')}" href="{$clsTour->getFileProgram($tour_id)}">{$core->get_Lang('DOWNLOAD PDF')} <i class="fa fa-download" aria-hidden="true"></i></a>
							{/if}
							<a href="javascript:void(0);" class="Expand_all fr">{$core->get_Lang('Expand all')}</a>
							{assign var = duration_cus value = $clsTour->getDurationCustom($tour_id)}
							<h3 class="tit-item text_uppercase inline-block mb20">{$core->get_Lang('Tour itinerary')} {if $duration_cus}( {$duration_cus} ){/if}</h3>
							{section name=j loop=$lstItineraryTour}
								{assign var=tourItinerary_id value=$lstItineraryTour[j].tour_itinerary_id}
								{assign var=lst_transport_id value=$lstItineraryTour[j].transport}
								{assign var=lstItineraryTransport value=$clsTransport->getAll("is_trash=0 and is_online=1 and transport_id in ($lst_transport_id) order by order_no ASC")}
								{assign var=_ItineraryContent value=$lstItineraryTour[j].content}
								{assign var=_ItineraryImage value=$clsTourItinerary->getImageUrl($tourItinerary_id)}
								<div class="it-item {if $smarty.section.j.first}first-child{/if} {if $smarty.section.j.last}last-child{/if}">
									<div class="it-head z_14 slideToggle {if $oneItem.number_day ne $oneItem.number_night}{if $smarty.section.j.first}open{/if}{/if}">
										{if $oneItem.number_day ne $oneItem.number_night}
											{if $smarty.section.j.first}
												<span class="fa1"><i class="fa fa-map-marker"></i></span>
											{else}
												<span class="fa fa{$smarty.section.j.iteration}"></span>
											{/if}
										{else}
											<span class="fa fa{$smarty.section.j.iteration+1}"></span>
										{/if}

										<span class="title_day">
											{$clsTourItinerary->getTitleItineraryNew($tourItinerary_id)}
										</span>
									</div>
									<div class="it-body-inti itineraryItem" {if $oneItem.number_day ne $oneItem.number_night}{if $smarty.section.j.first}style="display:block"{/if}{/if}>
										<div class="tinymce_Content">
											{if $lstItineraryTransport}
											<div class="mb10">
												<span class="icon-transport-tour">
													{section name=k loop=$lstItineraryTransport|@count}
													<span title="{$clsTransport->getTitle($lstItineraryTransport[k].transport_id)}"><img src="{$clsTransport->getImageUrl($lstItineraryTransport[k].transport_id)}" width="30" height="30" alt="{$clsTransport->getTitle($lstItineraryTransport[k].transport_id)}" />
													</span>
													{/section}
												</span>
											</div>
											{/if}
											{if $lstItineraryTour[j].is_show_image eq '1' and $_ItineraryImage}
											<div class="photo">
												<img class="photo275 image full-width height-auto" src="{$_ItineraryImage}" alt=""/>
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
												<span>{$core->get_Lang('Hotels')}:</span>
												<ul class="inline-block">
													{section name=h loop=$listHotel}
													{assign var=_HotelName value=$clsHotel->getTitle($listHotel[h].hotel_id)}
													{assign var=star_id value=$clsHotel->getOneField('star_id',$listHotel[h].hotel_id)}
													<li>
													<h3 class="mb5">
													<a target="_blank" href="{$clsHotel->getLink($listHotel[h].hotel_id)}" title="{$_HotelName}">{$_HotelName}</a>
													{if $clsHotel->getImageStar($star_id)}
													<img src="{$clsHotel->getImageStar($star_id)}" alt="{$_HotelName}" />
													{/if}
													</h3>
													</li>
													{/section}
												</ul>
											</div>
											{/if}
										</div>
									</div>
								</div>
							{/section}
						</article>
						{/if}
						{if _ISOCMS_CLIENT_LOGIN}
						<article id="reviews" class="mt30">
							<h2 class="size17 text_upper mt30 mb20">{$core->get_Lang('Traveler rating')} <label class="rate-1 text_left mb10" style="margin-right:5px;">{$clsReviews->getStarNew($tour_id,$mod)}</label></h2>
							<a class="btn_write_review {if $profile_id eq ''}btn_write_review_not_login{else}btn_write_review_login{/if} fr" href="javascript:void(0);" title="{$core->get_Lang('Write a review')}">{$core->get_Lang('Write a review')}</a>
							<div class="clearfix mb20"></div>
							{$core->getBlock('review_Star')}
						</article>
						{else}
						<article id="reviews" class="mt30">
							<h2 class="size17 text_upper mt30 mb20">{$core->get_Lang('Traveler rating')} <label class="rate-1 text_left mb10" style="margin-right:5px;">{$clsReviews->getStarNew($tour_id,$mod)}</label></h2>
							<a class="btn_write_review btn_write_review_no_login fr" href="javascript:void(0);" title="{$core->get_Lang('Write a review')}">{$core->get_Lang('Write a review')}</a>
							<div class="clearfix mb20"></div>
							{$core->getBlock('review_Star')}
						</article>
						{/if}
						<article class="tailoring hidden-xs" id="tourBookGroupGo">
							<h3 class="title_tailor">{$core->get_Lang('Tailoring your trip')} <span>_ _ _ _ _ _ _ _</span><img class="icon_tailor" alt="Tailoring" src="{$URL_IMAGES}/img_isocms/icon_tailor.png"/></h3>
							<img class="woman_tailor" alt="Tailoring" src="{$URL_IMAGES}/img_isocms/bg_woman.png"/>
							<p class="desc">{$core->get_Lang('Any part of this itinerary can be altered to fit your need, e.g.accommodation, add/skip city, tour length')}...</p>
							<div class="mt10">
								{*{if $clsTour->getTripPrice($tour_id,$now_day,$is_agent,'value') gt 0}
								<button class="btn_book_now"><a href="{$clsTour->getLinkBooken($tour_id)}" title="Book now">{$core->get_Lang('Book now')}</a></button>
								{else}
								<button class="btn_book_now"><a  href="{$clsISO->getLink('contact')}">{$core->get_Lang('Contact Us')}</a></button>
								{/if}
								<span class="m15">{$core->get_Lang('or')}</span> *}
								<a href="{$clsTour->getLinkCustomize($tour_id)}"><span class="getCall mb5" style="display: inline-block">{$core->get_Lang('Free tailor made')}</span></a>
							</div>
						</article>
					</div>
				</div>
				<aside class="col-md-4">
					<div class="priceBox hidden-sm">
						<div class="line mb30 inline-block full-width">
							<div class="price">
								<span class="block">
								{$core->get_Lang('Price from')}
								</span>
								{assign var=checkmem value=$clsTour->getCheckMemSet($tour_id)}
								{*{$clsTour->getTripPriceNew($tour_id,$now_day,$is_agent,'detail')}*}
								{if $checkmem eq 1}
									{if $profile_id eq ''}
										{$clsTour->getTripPriceNewPro($tour_id,$now_day,$is_agent,'detailnomem')}
									{else}
										{$clsTour->getTripPriceNewPro($tour_id,$now_day,$is_agent,'detail')}
									{/if}
								{else}
									{$clsTour->getTripPriceNewPro($tour_id,$now_day,$is_agent,'detail')}
								{/if}

							</div>
							<div class="tripCode">
								<span class="block">
								{$core->get_Lang('Trip code')}
								</span>
								<span class="block size18">{$clsTour->getTripCode($tour_id)}</span>
							</div>

						</div>
						{assign var=promotion_id value=$clsTour->getMinStartDatePromotionProID($tour_id,$now_day)}
						{if $promotion_id}
						<div class="clearfix"></div>
						<div class="line mb30">
							{if $checkmem eq 1}
								{if $profile_id}
									<div class="flag_text text_upper">
										{$clsPromotion->getFlagText($promotion_id)}
									</div>
									<div class="departure_day">
										<span class="block size15">{$core->get_Lang('Departure day')}: {$clsTour->getDepartureDayPromotionPro($tour_id)}</span>
									</div>
								{/if}
							{else}
								<div class="flag_text text_upper">
									{$clsPromotion->getFlagText($promotion_id)}
								</div>
								<div class="departure_day">
									<span class="block size15">{$core->get_Lang('Departure day')}: {$clsTour->getDepartureDayPromotionPro($tour_id)}</span>
								</div>
							{/if}
						</div>
						{/if}
						{if $clsTour->getTripPrice($tour_id,$now_day,$is_agent,'value') gt 0}
						<div class="clearfix"></div>
						<a class="btn_book" href="{$clsTour->getLinkBookEn($tour_id)}" title="{$core->get_Lang('Book now')}">{$core->get_Lang('Book now')}</a>
						{else}
						{*<a class="btn_enquiry" href="{$clsTour->getLinkCustomize($tour_id)}" title="{$core->get_Lang('Send Enquiry')}">{$core->get_Lang('Send Enquiry')} <i class="fa fa-comment color_main" aria-hidden="true"></i></a>*}
						{/if}
					</div>
					<div class="support hidden-xs">
						<span class="support_text">{$core->get_Lang('24/7 Customer Support')}</span>
						{if 1 eq 2}
						<a class="btn_enquiry" href="" title="{$core->get_Lang('Send Enquiry')}">{$core->get_Lang('Send Enquiry')} <i class="fa fa-comment color_main" aria-hidden="true"></i></a>
						{/if}
					</div>
					<div class="clearfix mb30"></div>
					{$core->getBlock(find_a_trip)}
					<div class="mb30"></div>
					{$core->getBlock(Lwhybox)}
					<div class="mb10"></div>
					{$core->getBlock(Lfaqscolbox)}
					<div class="mb30"></div>
					{$core->getBlock(testimonials)}
				</aside>
				<div id="stickyNavOut"></div>
			</div>
			{if $check_tour_departure}
				<article id="departure" class="departure mt40 bg_fff">
					<div class="filter">
						<h4 class="text_uppercase mb30">{$core->get_Lang('Select departure')}</h4>
						<ul id="monthtabs" class="hidden767">
							<li><a class="mClick_all" href="javascript:void(0);" title="{$core->get_Lang('Upcoming departures')}">{$core->get_Lang('Upcoming departures')}</a></li>
							{section name=i loop=$listMonth}
								{assign var=start_date value=$listMonth[i].month|cat:'/01/'|cat:$listMonth[i].year}
								{assign var=number_day_of_month value=$clsISO->getNumberDayOfMonth($listMonth[i].year,$listMonth[i].month)}
								{assign var=end_date value=$listMonth[i].month|cat:'/'|cat:$number_day_of_month|cat:'/'|cat:$listMonth[i].year}
								{if $clsTourStartDate->countTourStartDateByMonth($tour_id,$start_date,$end_date)}
									<li><a class="mClick" href="javascript:void(0);" month="{$listMonth[i].month}/{$listMonth[i].year}" year="{$listMonth[i].year}">{$clsISO->getNameMonth02($listMonth[i].month)} {$listMonth[i].year}</a></li>
								{/if}
							{/section}
						</ul>
						<div class="block767 mb10" style="display:none">
							<select id="slb_MonthYear" name="month" class="appearance_none">
								<option value="0">{$core->get_Lang('Upcoming departures')}</option>
								{section name=i loop=$listMonth}
									{assign var=start_date value=$listMonth[i].month|cat:'/01/'|cat:$listMonth[i].year}
									{assign var=number_day_of_month value=$clsISO->getNumberDayOfMonth($listMonth[i].year,$listMonth[i].month)}
									{assign var=end_date value=$listMonth[i].month|cat:'/'|cat:$number_day_of_month|cat:'/'|cat:$listMonth[i].year}
									{if $clsTourStartDate->countTourStartDateByMonth($tour_id,$start_date,$end_date)}
										<option value="{$listMonth[i].month}/{$listMonth[i].year}" month="{$listMonth[i].month}" year="{$listMonth[i].year}">{$clsISO->getNameMonth02($listMonth[i].month)} {$listMonth[i].year}</option>
									{/if}
								{/section}
							</select>
						</div>
					</div>
					<table border="0" style="width:100%;border-collapse:collapse;table-layout:auto;padding: 3px; border-spacing: 0;" id="home-masonry-container">
						<tr style="text-align: center" class="text_uppercase text_bold tr_theader">
							<td style="width: 20%;text-align: left" class="text_uppercase text_bold">{$core->get_Lang('Start Date')}</td>
							<td style="width: 20%;text-align: left" class="text_uppercase text_bold hidden991">{$core->get_Lang('End Date')}</td>
							<td style="width: 20%" class="text_uppercase text_bold">{$core->get_Lang('Durations')}</td>
							<td style="width: 20%" class="text_uppercase text_bold">{$core->get_Lang('Price From')}</td>
							<td style="width: 20%" class="text_uppercase text_bold hidden767">&nbsp;</td>
						</tr>
						<tbody id="ucIndex_TourOpenning"></tbody>
					</table>
				</article>
			{/if}
			{$core->getBlock(relatetour)}
		</div>
		<div class="cleafix mb30"></div>
	</div>
	
</div>
<div class="box-nav__tool_bottom" style="display:none;">
	<ul>
	{if $clsTour->getTripPrice($tour_id,$now_day,$is_agent,'value') gt 0}
	<li><a class="btn_book" href="{$clsTour->getLinkBookEn($tour_id)}" title="{$core->get_Lang('Book now')}">{$core->get_Lang('Book now')}</a></li>
	{else}
	<li><a class="contactLink" href="{$clsISO->getLink('contact')}">{$core->get_Lang('Contact Us')}</a></li>
	{/if}
	<li><a href="{$clsISO->getLink('tailor')}" title="{$core->get_Lang('Tailor Made')}" >{$core->get_Lang('Tailor Made')}</a></li>
	</ul>
</div>
<script>
	var $_Expand_all = '{$core->get_Lang("Expand all")}';
	var $_Collapse_all = '{$core->get_Lang("Collapse all")}';
	var $_LANG_ID = '{$_LANG_ID}';
</script>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(function(){
			var $_clicked = 0;
			var $_clicked_1 = 0;
			$('#content .Expand_all').click(function(){
				var $_this = $(this);
				if($_clicked==0){
					$('#content .slideToggle').addClass('open');
					$('#content .it-body').show();
					$_this.html($_Collapse_all);
					$_clicked = 1;
				}else{
					$('#content .slideToggle').removeClass('open');
					$('#content .it-body').hide();
					$_this.html($_Expand_all);
					$_clicked = 0;
				}
				return false;
			});
			$('#fullItinerary .Expand_all').click(function(){
				var $_this = $(this);
				if($_clicked_1==0){
					$('#fullItinerary .slideToggle').addClass('open');
					$('#fullItinerary .it-body-inti').show();
					$_this.html($_Collapse_all);
					$_clicked_1 = 1;
				}else{
					$('#fullItinerary .slideToggle').removeClass('open');
					$('#fullItinerary .it-body-inti').hide();
					$_this.html($_Expand_all);
					$_clicked_1 = 0;
				}
				return false;
			});
		});
	})
</script>
{/literal}

{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(document).on('click', '.loadMore_c .clickshow', function(){
			var $_this = $(this);
				var $page_Review = $_this.attr('Page-Review');
				var dataReview = {
					'tour_id':$tour_id,
					'page_Review': $page_Review
				};
				if($tour_id > 0 && $page_Review >0){ 
				$.post(path_ajax_script+'/index.php?mod='+mod+'&act=loadReview',dataReview,function(html){
					var $htm = html.split('$$$');
					$('.load_result-review').append($htm[0]);
					if($htm[1] == 'NoNo'){
						$('.loadMore_c').hide();
						}else{
						$('.loadMore_c a.clickshow').attr('page_Review',$htm[1]);
					}
				});
				}
		});
		$(document).on('click', '.semoreClick', function(){ 
			$(this).closest(".clicSeemore").find(".More").hide();
			$(this).closest(".clicSeemore").find(".Less").show();
		});

		$(document).on('click', '.LessClick', function(){ 	
			$(this).closest(".clicSeemore").find(".Less").hide();
			$(this).closest(".clicSeemore").find(".More").show();
		});
		/*$(document).on('click', '.selectDeparture', function(ev){
			event.preventDefault();
			var offset_start = $('#departure').offset().top;
			$('html, body').animate({
				scrollTop: offset_start
			}, 500);
		});*/
	$(document).ready(function(){
		var $month = $('#monthtabs a.current').attr('month');
		var $year = $('#monthtabs a.current').attr('year');	
		loadTourOpenning(0,$tour_id);
		$(document).on('change', '#slb_MonthYear', function(ev){
			var $_this = $(this);
			var $month = $_this.val();
			loadTourOpenning($month,$tour_id);
		});
		$('.mClick').click(function(){
			var $_this = $(this);
			var $month = $_this.attr('month');
			$('#monthtabs a.current').removeClass('current');
			$_this.addClass('current');
			loadTourOpenning($month,$tour_id);
			return false;
		});	
		$('.mClick_all').click(function(){
			var $_this = $(this);
			loadTourOpenning(0,$tour_id);
			return false;
		});	
		
		$(document).on('change', '#slb_MonthYear', function(ev){
			var $_this = $(this);
			var $year = $('#tabDeparture .tab.active a').attr('data');
				loadTourOpenning($_this.val(),$tour_id);
		});
		$('.paginate_button').click('click',function(){
			var $_this = $(this);
			var $month = $('#monthtabs a.current').attr('month');
			var $year = $('#monthtabs a.current').attr('year');
			loadTourOpenning($month,$tour_id,$_this.attr('page'));
			return false;
		});
	});
	function loadTourOpenning($month,$tour_id,$page) {
		var $departure_id = $('select[name=departure_id]').val();
		var $destination_id = $('select[name=destination_id]').val();
		var $duration = $('select[name=duration]').val();
		
		var adata = {
			'month' 			: $month,
			'page' 				: $page,
			'departure_id' 		: $departure_id,
			'destination_id' 	: $destination_id,
			'duration' 			: $duration,
			'tour_id' 			: $tour_id,
			'_LANG_ID' 			: $_LANG_ID
		};
		$.ajax({
			type: 'POST',
			url: path_ajax_script+'/index.php?mod='+mod+'&act=ajaxGetTourOpenning&lang='+LANG_ID,
			data :adata,
			dataType:'html',
			success: function(html){
				var $htm = html.split('$$');
				if($htm!=''){
					$('#ucIndex_TourOpenning').html($htm[0]);
					$('#pagination').html($htm[1]);
					// $('.priceBox .btn_book').removeAttr("href").addClass('selectDeparture');
					// $('.box-nav__tool_bottom .btn_book').removeAttr("href").addClass('selectDeparture');
				}else{
					$('#departure').remove();
				}
				
			} 
		});
	}
	})
</script>
{/literal}
<script defer src="{$URL_JS}/jquerytourdetail.js?v={$upd_version}"></script>
