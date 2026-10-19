<link rel="stylesheet" href="{$URL_JS}/fancybox-3.5.7/jquery.fancybox.min.css"/>
<link rel="stylesheet" href="{$URL_JS}/fotorama-4.6.4/fotorama.css"/>
<link rel="stylesheet" href="{$URL_JS}/swiper-11.1.15/swiper-bundle.min.css"/>
<link rel="stylesheet" href="{$URL_CSS}/2024_tour_detail.css?v={$upd_version}"/>
<script src="{$URL_JS}/fancybox-3.5.7/jquery.fancybox.min.js"></script>
<script src="{$URL_JS}/fotorama-4.6.4/fotorama.js"></script>
<script src="{$URL_JS}/swiper-11.1.15/swiper-bundle.min.js"></script>

{assign var=title_tour value=$clsTour->getTitle($tour_id)}
{assign var=oneItemCatTour value=$clsTourCategory->getOne($tourcat_id,'title,slug')}
{assign var=titleCatTour value=$oneItemCatTour.title}
{assign var=linkCatTour value=$clsTourCategory->getLink($tourcat_id,$oneItemCatTour)}
{assign var=getTripDuration value=$clsTour->getTripDuration2019($tour_id)}
{assign var=Depart_point value=$clsTour->getListDeparturePointLink($tour_id)}
{assign var=Address value=$clsTour->getLCityAround2($tour_id)}
{assign var=listCityAround value=$clsTour->getLCityAround4($tour_id)}

{assign var = _Inclusion value = $clsTour->getInclusion($tour_package,$oneItem)}
{assign var = _Exclusion value = $clsTour->getExclusion($tour_package,$oneItem)}
{assign var = _ThingToCarry value = $clsTour->getThingToCarry($tour_id,$oneItem)}
{assign var = _CancellationPolicy value = $clsTour->getCancellationPolicy($tour_id,$oneItem)}
{assign var = _RefundPolicy value = $clsTour->getRefundPolicy($tour_id,$oneItem)}
{assign var = _ConfirmationPolicy value = $clsTour->getConfirmationPolicy($tour_id,$oneItem)}
{assign var = minPricePackage value=$clsTour->getTripPriceNewPro2020($tour_package,$now_day,$is_agent,'detail')}
{assign var = has_package value = ($oneItem.has_package && $listPackage)}

{assign var=getPriceTourPromotion value= ($has_package) ? $minPricePackage : $clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent,'detail')}

{*{assign var=getToTalReview value=$clsReviews->getToTalReviewNoLogin($tour_id,'tour')}*}
{*{assign var=getStarNewIcon value=$clsReviews->getStarNewIconNoLogin($tour_id,'tour')}*}
{*{assign var=getRateAvg value=$clsReviews->getRateAvgNologin($tour_id,'tour')}*}
{assign var=textRateAvg value=$clsReviews->getTextRateAvg($tour_id,'tour')}

{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
    {assign var="getToTalReview" value=$clsReviews->getToTalReview($tour_id,'tour')}
    {assign var="getStarNewIcon" value=$clsReviews->getStarNewIcon($tour_id,'tour')}
    {assign var="getRateAvg" value=$clsReviews->getRateAvg($tour_id,'tour')}
    {assign var="getStarNew" value=$clsReviews->getStarNew($tour_id,'tour')}
{else}
    {assign var="getToTalReview" value=$clsReviews->getToTalReviewNoLogin($tour_id,'tour')}
    {assign var="getStarNewIcon" value=$clsReviews->getStarNewIconNoLogin($tour_id,'tour')}
    {assign var="getRateAvg" value=$clsReviews->getRateAvgNologin($tour_id,'tour')}
    {assign var="getStarNew" value=$clsReviews->getStarNewNoLogin($tour_id,'tour')}
{/if}
{literal}
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Trip",
        "name": "{/literal}{$title_tour}{literal}",
        "description": "{/literal}{$clsTour->getTripOverview($tour_id,$oneItem)|html_entity_decode|replace:'"':'\"'|strip_tags:true}{literal}",
        "itinerary": [
            {/literal}
            {if $lstItineraryTour}
    {section name=i loop=$lstItineraryTour}
    {assign var=tourItinerary_id value=$lstItineraryTour[i].tour_itinerary_id}
    {assign var=title_itinerary value=$clsTourItinerary->getTitleItineraryNew($tourItinerary_id,$lstItineraryTour[i])}
    {assign var=content value=$lstItineraryTour[i].content|html_entity_decode|replace:'"':'\"'|strip_tags}
{literal}
                    {
                        "@type": "City",
                        "name": "{/literal}{$title_itinerary}{literal}",
                        "description": "{/literal}{$content}{literal}",
                        "url": ""
                    }{/literal}
    {if !$smarty.section.i.last}{/if}
    {/section}
    {/if}
            {literal}
    ]
}
</script>

{/literal}

{$core->getBlock('2024_breadcrumb')}

<section class="hnv_tour_detail_intro">
    {$core->getBlock('2025_detail_tour_mobile')}
    <div class="container">
        {if $oneItem['is_best_price'] && $oneItem['is_recommended']}
            <div class="hnv_tour_detail_intro_suggest d-none d-lg-block">
                <ul class="hnv_tour_detail_intro_suggest_list">
                    {if $oneItem['is_best_price']}
                        <li class="hnv_tour_detail_intro_suggest_item">
                            <i class="fa-light fa-star"></i> {$core->get_Lang('Best Price')}
                        </li>
                    {/if}
                    {if $oneItem['is_recommended']}
                        <li class="hnv_tour_detail_intro_suggest_item">
                            <i class="fa-light fa-heart"></i> {$core->get_Lang('Recommended')}
                        </li>
                    {/if}
                </ul>
            </div>
        {/if}
        <div class="hnv_tour_detail_intro_title d-none d-lg-flex">
            <h1>{$title_tour}</h1>
            <div class="hnv_tour_detail_intro_suggest_share">
                <button class="icon_share">
                    <span>{$core->get_Lang("Share")}</span>
                    <i class="fa-solid fa-share-from-square"></i>
                </button>
                <div class="share_box">
                    <script type="text/javascript"
                            src="{$URL_JS}/jquery.sharer.js?v={$up_version}"></script>
                    {assign var=link_share value=$curl}
                    {assign var=title_share value="{$title_tour}"}
                    {$clsISO->getBlock('box_share',["link_share"=>$link_share,"title_share"=>$title_share])}
                </div>
            </div>
        </div>
        <div class="hnv_tour_detail_intro_review d-none d-lg-flex">
            <div class="hnv_tour_detail_intro_review_star">
                {$getStarNewIcon}
            </div>
            <div class="hnv_tour_detail_intro_review_text">
                {$getRateAvg} <span>({$getToTalReview} {$core->get_Lang('reviews')})</span>
            </div>
            {if $getTripDuration}
                <div class="hnv_tour_detail_intro_review_duration">
                    | <i class="fa-light fa-clock"></i>
                    <span>{$core->get_Lang('Duration')}:</span> {$getTripDuration}
                </div>
            {/if}
            {if $Depart_point}
                <div class="hnv_tour_detail_intro_review_start">
                    | <i class="fa-light fa-location-dot" aria-hidden="true"></i>
                    <span>{$core->get_Lang('Start')}:</span> {$Depart_point}
                </div>
            {/if}
            {if $oneItem.trip_code}
                <div class="hnv_tour_detail_intro_review_start iso_tour_separation">
                    | <i class="fa-solid fa-barcode-read" aria-hidden="true"></i>
                    <span>{$core->get_Lang('Tour code')}:</span> {$oneItem.trip_code}
                </div>
            {/if}
        </div>
    </div>
</section>
<section class="hnv_tour_detail_gallery">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="iso_box_gallery row d-none d-md-none d-lg-flex">
                    {if $lstImage}
                        <div class="col-3 col-lg-2 hnv_tour_detail_gallery_thumb">
                            <div class="thumdsslider">
                                <ul>
                                    {foreach from=$lstImage key=key item=item}
                                        <li {if $key == 0} class="active" {/if}>
                                            <img
                                                    src="{$clsTourImage->getImage($item.tour_image_id,147,93)}"
                                                    alt="{$item.title}"
                                                    width="147"
                                                    height="93"
                                            />
                                        </li>
                                    {/foreach}
                                </ul>
                            </div>
                        </div>
                        <div class="col-9 col-lg-10 hnv_tour_detail_gallery_main">
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    {foreach from=$lstImage key=key_main item=item_main}
                                        <div class="swiper-slide">
                                            <a href="{$clsTourImage->getImage($item_main.tour_image_id,674,491)}"
                                               data-fancybox="gallery">
                                                <img src="{$clsTourImage->getImage($item_main.tour_image_id,674,491)}"
                                                     class="swiper-lazy item" width="674" height="491"
                                                     alt="{$item_main.title}"
                                                />
                                            </a>
                                        </div>
                                    {/foreach}
                                </div>
                                <div class="swiper-next"></div>
                                <div class="swiper-prev"></div>
                            </div>
                        </div>
                    {/if}
                </div>
                <div id="hnv_navbar_fixed">
                    <ul class="hnv_tour_detail_main_nav_list">
                        {if $oneItem['overview']}
                            <li class="hnv_tour_detail_main_nav_item">
                                <a class="nav-link" href="javascript:void(0);"
                                   data-target="hnv_tour_detail_main_intro">{$core->get_Lang('Overview')}</a>
                            </li>
                            <li class="asia_fa_circle"><i class="fa fa-circle" aria-hidden="true"></i></li>
                        {/if}
                        {if $lstItineraryTour}
                            <li class="hnv_tour_detail_main_nav_item">
                                <a class="nav-link" href="javascript:void(0);"
                                   data-target="hnv_tour_detail_main_itinerary">{$core->get_Lang('Itinerary')}</a>
                            </li>
                            <li class="asia_fa_circle"><i class="fa fa-circle" aria-hidden="true"></i></li>
                        {/if}
                        <li class="hnv_tour_detail_main_nav_item">
                            <a class="nav-link"
                               href="javascript:void(0);"
                               data-target="hnv_tour_detail_main_meeting_pickup">{$core->get_Lang('Meeting & Pickup')}</a>
                        </li>
                        <li class="asia_fa_circle"><i class="fa fa-circle" aria-hidden="true"></i></li>

                        <li class="hnv_tour_detail_main_nav_item">
                            <a class="nav-link"
                               href="javascript:void(0);"
                               data-target="hnv_tour_detail_main_useful_information">{$core->get_Lang('Useful Information')}</a>
                        </li>
                        <li class="asia_fa_circle"><i class="fa fa-circle" aria-hidden="true"></i></li>

                        <li class="hnv_tour_detail_main_nav_item">
                            <a class="nav-link" href="javascript:void(0);"
                               data-target="hnv_tour_detail_main_review">{$core->get_Lang('Reviews')}</a>
                        </li>
                    </ul>
                </div>
                <div class="hnv_scrollspy">
                    <div id="hnv_tour_detail_main_intro" class="hnv_scrollspy_item hnv_tour_detail_main_intro">
                        <div class="hnv_tour_detail_main_intro_overview">
                            <div class="hnv_tour_detail_main_intro_overview_title">
                                <h2>{$core->get_Lang('Overview')}</h2>
                            </div>
                            {if $oneItem['overview']}
                                <div class="hnv_tour_detail_main_intro_overview_content">
                                    {$oneItem['overview']|html_entity_decode}
                                </div>
                            {/if}
                        </div>
                    </div>

                    <div class="hnv_tour_detail_main_intro_overview_place">
                        {if $listCityAround}
                            <div class="hnv_tour_detail_main_intro_overview_place_top">
                                <h2>{$core->get_Lang("Places you’ll see")}</h2>
                                <div class="hnv_tour_detail_main_intro_overview_place_top_list">
                                    <div class="swiper-container swiper_hnv_tour_detail_main_intro_overview_place_top_list">
                                        <div class="swiper-wrapper">
                                            {foreach from=$listCityAround key=key item=item}
                                                {assign var="listCityAround_title" value=$item.title}
                                                {assign var="listCityAround_link" value=$item.link}
                                                {assign var="listCityAround_image" value=$item.image}
                                                <div class="swiper-slide swiper_hnv_tour_detail_main_intro_overview_place_top_item">
                                                    <a href="{$listCityAround_link}"
                                                       class="swiper_hnv_tour_detail_main_intro_overview_place_top_item_image"
                                                       title="Hanoi">
                                                        <img src="{$listCityAround_image}" alt="{$listCityAround_title}"
                                                             width="268" height="180" loading="lazy"
                                                             class="scale_img_hover"/>
                                                    </a>
                                                    <h3>
                                                        <a href="#"
                                                           class="swiper_hnv_tour_detail_main_intro_overview_place_top_item_title">
                                                            {$listCityAround_title}
                                                        </a>
                                                    </h3>
                                                </div>
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/if}
                    </div>
                    {if $lstItineraryTour}
                        <div id="hnv_tour_detail_main_itinerary"
                             class="hnv_scrollspy_item hnv_tour_detail_main_itinerary">
                            <div class="hnv_tour_detail_main_itinerary_title">
                                <h2>{$core->get_Lang("Itinerary")}</h2>
                                <a href="javascript:void(0);"
                                   class="hnv_tour_detail_main_itinerary_title_expand link_hover"
                                   title="{$core->get_Lang("Expand All")}">
                                    {$core->get_Lang("Expand All")}
                                </a>
                            </div>
                            <div class="hnv_tour_detail_main_itinerary_content">
                                <div class="accordion" id="accordionTourItinerary">
                                    {foreach from=$lstItineraryTour key=key item=item}
                                        {assign var=tourItinerary_id value=$item.tour_itinerary_id}
                                        {assign var=_lstItineraryTransport value=$item.lstItineraryTransport}
                                        {assign var=lst_transport_id value=$item.transport}
                                        {assign var=lstItineraryTransport value=$clsTransport->getAll("is_trash=0 and is_online=1 and transport_id in ($lst_transport_id) order by order_no ASC",'transport_id,image,title')}
                                        {assign var=_ItineraryContent value=$item.content}
                                        {assign var=_ItineraryImage value = $item.image}
                                        <div class="accordion-item {if $key == 0} hnv_expand {/if}">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button {if $key != 0} collapsed {/if}"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#panelsStayOpen-collapse{$key}"
                                                        aria-expanded="true"
                                                        aria-controls="panelsStayOpen-collapse{$key}">
                                                    {$clsTourItinerary->getTitleItineraryNew($tourItinerary_id,$item)}
                                                </button>
                                            </h2>
                                            <div id="panelsStayOpen-collapse{$key}"
                                                 class="accordion-collapse collapse {if $key == 0} show {/if}">
                                                <div class="accordion-body">
                                                    {if $lstItineraryTransport && $clsISO->getCheckActiveModulePackage($package_id,'property','transport','default')}
                                                        <div class="mb10">
                                                            <div class="icon-transport-tour">
                                                                {section name=k loop=$lstItineraryTransport|@count}
                                                                    <div class="iso_transport_tour"
                                                                         title="{$clsTransport->getTitle($lstItineraryTransport[k].transport_id,$lstItineraryTransport[k])}">
                                                                        <img src="{$clsTransport->getImageUrl($lstItineraryTransport[k].transport_id,$lstItineraryTransport[k])}"
                                                                             width="30" height="30"
                                                                             alt="{$clsTransport->getTitle($lstItineraryTransport[k].transport_id,$lstItineraryTransport[k])}"/>
                                                                    </div>
                                                                {/section}
                                                            </div>
                                                        </div>
                                                    {/if}
                                                    {if $item.is_show_image eq '1' and $_ItineraryImage ne ''}
                                                        <div class="box_content_item d-flex flex-wrap">
                                                            <div class="photo_itinerary">
                                                                <img class="photo275 image img100" width="263"
                                                                     height="153" src="{$_ItineraryImage}"
                                                                     onerror="this.style.display='none';"/>
                                                            </div>
                                                            <div class="intro_itinerary">
                                                                {$_ItineraryContent|html_entity_decode}
                                                            </div>
                                                        </div>
                                                    {else}
                                                        {$_ItineraryContent|html_entity_decode}
                                                    {/if}


                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                    {/if}
                    <div id="hnv_tour_detail_main_meeting_pickup"
                         class="hnv_scrollspy_item hnv_tour_detail_main_meeting_pickup">
                        <div class="hnv_tour_detail_main_meeting_pickup_title">
                            <h3>{$core->get_Lang('Meeting & Pickup')}</h3>
                        </div>
                        <div class="hnv_tour_detail_main_meeting_pickup_content">
                            <div class="row">
                                {assign var=start_address value=$oneItem.meeting_point}
                                {*{if $start_destination.city_id}
                                    {assign var=start_address value="{$clsCountry->getTitle($start_destination.country_id)}, {$clsRegion->getTitle($start_destination.region_id)}, {$clsCity->getTitle($start_destination.city_id)}"}
                                    {assign var=start_address_city value = "{$clsCity->getTitle($start_destination.city_id)}"}
                                {elseif $start_destination.chauluc_id}
                                    {assign var=start_address value=$clsContinent->getTitle($start_destination.chauluc_id)}
                                {/if}*}

                                <div class="col-12 col-md-6">
                                    <div class="hnv_tour_detail_main_meeting_pickup_content_title">
                                        <i class="fa-light fa-location-dot" aria-hidden="true"></i>
                                        <h4>{$core->get_Lang('Meeting point')}</h4>
                                    </div>

                                    <div class="hnv_tour_detail_main_meeting_pickup_content_address start">
                                        {$start_address}
                                    </div>

                                    {if $start_address}
                                        <a href="https://maps.google.it/maps?q={$start_address}"
                                           target="_blank" class="hnv_tour_detail_main_meeting_pickup_content_map"
                                           title="{$core->get_Lang('Open in Google Maps')}">
                                            {$core->get_Lang('Open in Google Maps')}
                                        </a>
                                    {/if}
                                </div>

                                {assign var=end_address value=$oneItem.end_point}
                                {*{if $end_destination.city_id}
                                    {assign var=end_address value="{$clsCountry->getTitle($end_destination.country_id)}, {$clsRegion->getTitle($end_destination.region_id)}, {$clsCity->getTitle($end_destination.city_id)}"}
                                    {assign var=end_address_city value = "{$clsCity->getTitle($end_destination.city_id)}"}
                                {elseif $end_destination.chauluc_id}
                                    {assign var=end_address value=$clsContinent->getTitle($end_destination.chauluc_id)}
                                {/if}*}

                                <div class="col-12 col-md-6">
                                    <div class="hnv_tour_detail_main_meeting_pickup_content_title">
                                        <i class="fa-sharp fa-solid fa-flag"></i>
                                        <h4>{$core->get_Lang('End point')}</h4>
                                    </div>

                                    <div class="hnv_tour_detail_main_meeting_pickup_content_address end">
                                        {$end_address}
                                    </div>

                                    {if $end_address}
                                        <a href="https://maps.google.it/maps?q={$end_address}"
                                           target="_blank" class="hnv_tour_detail_main_meeting_pickup_content_map"
                                           title="{$core->get_Lang('Open in Google Maps')}">
                                            {$core->get_Lang('Open in Google Maps')}
                                        </a>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </div>
                    {if $has_package}
                        <div class="hnv_scrollspy_item hnv_tour_detail_main_intro mb-5">
                            <div class="hnv_tour_detail_main_intro_overview_title">
                                <h2>{$core->get_Lang('Select Package')}</h2>
                            </div>
                            <div class="hnv_tour_detail_gallery_right_bottom">
                                <div class="listPackage">
                                    {foreach from=$listPackage item=item}
                                        {assign var="package_price" value=$clsTour->getTripPriceNewPro2020($item.tour_id,$now_day,$is_agent,'detail')}
                                        {if $package_price}
                                            <label class="package_item">
                                                <div class="div_package_item">
                                                    <input class="package_radio" type="radio" name="radioDefault" {if $tour_package == $item.tour_id}checked{/if} value="{$item.tour_id}" id="package_{$item.tour_id}">
                                                    <p class="package_title">{$item.title}</p>
                                                </div>
                                                {if $package_price}<div class="package_price">{$package_price} {$core->get_Lang("per person")}</div>{/if}
                                            </label>
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                    {/if}
                    <div id="hnv_tour_detail_main_date_availability" class="hnv_tour_detail_main_date_availability">
                        {$clsISO->getBlock("box_find_tour")}
                    </div>
                    <div id="hnv_tour_detail_main_useful_information"
                         class="hnv_scrollspy_item hnv_tour_detail_main_useful_information">
                        <div class="hnv_tour_detail_main_useful_information_title">
                            <h2>{$core->get_Lang("Useful Information")}</h2>
                            <a href="javascript:void(0);"
                               class="hnv_tour_detail_main_useful_information_title_expand link_hover"
                               title="{$core->get_Lang("Expand All")}">
                                {$core->get_Lang("Expand All")}
                            </a>
                        </div>
                        <div class="hnv_tour_detail_main_useful_information_content">
                            <div class="accordion" id="accordionTourUsefulInformation">
{*                                {if $_Inclusion}*}
                                    <div class="accordion-item hnv_expand">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#panelsStayOpen-collapseOne"
                                                    aria-expanded="true"
                                                    aria-controls="panelsStayOpen-collapseOne">
                                                {$core->get_Lang("What's Included")}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseOne"
                                             class="accordion-collapse collapse show">
                                            <div class="accordion-body htmlInclusion">
                                                {$_Inclusion}
                                            </div>
                                        </div>
                                    </div>
{*                                {/if}*}
{*                                {if $_Exclusion}*}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#panelsStayOpen-collapseTwo"
                                                    aria-expanded="false"
                                                    aria-controls="panelsStayOpen-collapseTwo">
                                                {$core->get_Lang("What's Not Included")}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                            <div class="accordion-body htmlExclusion">
                                                {$_Exclusion}
                                            </div>
                                        </div>
                                    </div>
{*                                {/if}*}
                                {if $_ThingToCarry}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#panelsStayOpen-collapseThree"
                                                    aria-expanded="false"
                                                    aria-controls="panelsStayOpen-collapseThree">
                                                {$core->get_Lang('What Carry')}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                {$_ThingToCarry}
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                                {if $_CancellationPolicy}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#panelsStayOpen-collapseFour"
                                                    aria-expanded="false"
                                                    aria-controls="panelsStayOpen-collapseFour">
                                                {$core->get_Lang('Cancellation Policy')}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                {$_CancellationPolicy}
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                                {if $_RefundPolicy}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#panelsStayOpen-collapseFive"
                                                    aria-expanded="false"
                                                    aria-controls="panelsStayOpen-collapseFive">
                                                {$core->get_Lang('Refund Policy')}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                {$_RefundPolicy}
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                                {if $_ConfirmationPolicy}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#panelsStayOpen-collapseSix"
                                                    aria-expanded="false"
                                                    aria-controls="panelsStayOpen-collapseSix">
                                                {$core->get_Lang('Confirmation Policy')}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                {$_ConfirmationPolicy}
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>

                    <div class="box_needmore">
                        <div class="icon_needmore">
                            <i class="fa-regular fa-circle-question" style="color: #18babd;"></i>
                            <div class="content_needmore">
                                <h3>{$core->get_Lang('Need more in-depth advice')} ?</h3>
                                <p>{$core->get_Lang('Please ask us your travel questions now! With your enquiry, they usually respond within 1 day')}</p>
                            </div>
                        </div>
                        <button class="book_now_tour btn_yellow btn_main">
                            <a href="{$clsISO->getLink('contact')}" target="_blank"
                               title="{$core->get_Lang('Contact Us')}">
                                {$core->get_Lang('Contact Us')}
                            </a>

                        </button>
                    </div>
                    {$clsISO->getBlock("2024_review_hotel")}
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block">
                <div class="hnv_tour_detail_gallery_right">
                    <div class="hnv_tour_detail_gallery_right_top">
                        {assign var=getFlagText value=$clsPromotion->getFlagText($promotion_id)}
                        {assign var=checkmem value=$clsTour->getCheckMemSet($tour_id)}
                        {assign var=getPriceTourPromotionnomem value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent,'nomem')}
                        {if $date_coutdown}
                            {if $getFlagText}
                                <div class="sale_off">{$getFlagText}</div>{/if}
                            <div>
                                <div class="price" style="margin-bottom: 24px;">
                                    {if $getPriceTourPromotion}
                                        <p>{$core->get_Lang('From')}</p>
                                        <div class="price_package_right">{$getPriceTourPromotion}</div>
                                        <span class="color_666 size16">{$core->get_Lang('per person')}</span>
                                    {/if}
                                </div>
                                <button class="hnv_btn_scroll btn_yellow btn_main">{$core->get_Lang('Check Availability')}</button>
                            </div>
                            <div class="offerDate">
                                <div class="d-flex offerDate__box">
                                    <div class="text_bold color_24b89c">{$core->get_Lang('Last minute deal')}</div>
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
                                <p class="mt10">{$core->get_Lang('Latest departure date')}: {$first_start_date}</p>
                            </div>
                        {else}
                            {if $getPriceTourPromotion}
                                {if $getFlagText}
                                    <div class="sale_off">{$getFlagText}</div>{/if}
                                <div>
                                    <div class="price" style="margin-bottom: 24px;">
                                        <p>{$core->get_Lang('From')}</p>
                                        {$getPriceTourPromotion} <span
                                                class="color_666 size16">{$core->get_Lang('per person')}</span>
                                    </div>
                                    <button class="hnv_btn_scroll btn_yellow btn_main">{$core->get_Lang('Check Availability')}</button>
                                </div>
                                {if $first_start_date}
                                    <div class="offerDate">
                                        <p>{$core->get_Lang('Latest departure date')}: {$first_start_date}</p>
                                    </div>
                                {/if}
                            {else}
                                <div>
                                    <div class="price" style="margin-bottom: 24px;">
                                        <span class="size24 color_fb1111 color_c81e3a text_bold">
                                            {$core->get_Lang('Contact')}
                                        </span>
                                    </div>
                                    <button class="hnv_btn_scroll btn_yellow btn_main margin_0_auto">{$core->get_Lang('Check Availability')}</button>
                                </div>
                                {if $first_start_date}
                                    <div class="offerDate">
                                        <p>{$core->get_Lang('Latest departure date')}: {$first_start_date}</p>
                                    </div>
                                {/if}
                            {/if}
                        {/if}
                        <!-- <div class="hnv_tour_detail_gallery_right_top_price">
                            <div class="hnv_tour_detail_gallery_right_top_price_old">
                                {$core->get_Lang("From")} <span>$340</span>
                            </div>
                            <div class="hnv_tour_detail_gallery_right_top_price_new">
                                <span>$174</span> {$core->get_Lang("per person")}
                            </div>
                        </div>
                        <a class="hnv_tour_detail_gallery_right_top_book" href="javascript:void(0);"
                           title="{$core->get_Lang("Check Availability")}">
                            {$core->get_Lang("Check Availability")}
                        </a> -->
                        <ul class="hnv_tour_detail_gallery_right_top_policy">
                            <li class="hnv_tour_detail_gallery_right_top_policy_item">
                                <i class="fa-duotone fa-light fa-circle-check"></i>
                                <label>
                                    <span>{$core->get_Lang("Free cancellation")}</span> {$core->get_Lang("up to 24 hours before the experience starts (local time)")}
                                </label>
                            </li>
                            <li class="hnv_tour_detail_gallery_right_top_policy_item">
                                <i class="fa-duotone fa-light fa-circle-check"></i>
                                <label>
                                    <span>{$core->get_Lang("Reserve Now and Pay Later")}</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="hnv_tour_detail_gallery_right_bottom">
                        <div class="hnv_tour_detail_gallery_right_bottom_title">
                            <h2>{$core->get_Lang("Plan your adventure")}</h2>
                        </div>
                        <div class="hnv_tour_detail_gallery_right_bottom_content">
                            <ul class="hnv_tour_detail_gallery_right_bottom_content_list">
                                {if $oneItem['file_programme']}
                                    <li class="hnv_tour_detail_gallery_right_bottom_content_item">
                                        <a href="{$oneItem['file_programme']}" download="{$oneItem['file_programme']}"
                                           title="{$core->get_Lang("Download PDF Brochure")}">
                                            <i class="fa-light fa-arrow-down-to-bracket"></i> {$core->get_Lang("Download tour program PDF")}
                                        </a>
                                    </li>
                                {/if}
                                <li class="hnv_tour_detail_gallery_right_bottom_content_item">
                                    <a href="{$clsISO->getLink('faqs')}" target="_blank"
                                       title="{$core->get_Lang("Ask a Question")}">
                                        <i class="fa-light fa-circle-question"></i> {$core->get_Lang("Ask a Question")}
                                    </a>
                                </li>
                                <li class="hnv_tour_detail_gallery_right_bottom_content_item">
                                    <a href="{$clsISO->getLink('tailor')}" target="_blank"
                                       title="{$core->get_Lang("Tailor made tour")}">
                                        <i class="fa-light fa-grid-2-plus"></i> {$core->get_Lang("Tailor made tour")}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{if $arr_tour_recent}
    <section class="hnv_tour_detail_recent">
        <div class="container">
            <div class="hnv_tour_detail_recent_title">
                <h2>{$core->get_Lang("Recently Viewed")}</h2>
            </div>
            <div class="hnv_tour_detail_recent_content">
                <div style="--swiper-navigation-color: #fff;--swiper-pagination-color: #fff;"
                     class="swiper hnv_tour_detail_recent_content_list">
                    <div class="swiper-wrapper">
                        {foreach from=$arr_tour_recent key=key item=item}
                            {assign var="recent_tour_id" value=$item}
                            {assign var="recent_tour_title" value=$clsTour->getTitle($item)}
                            {assign var="recent_tour_link" value=$clsTour->getLink($item)}
                            {assign var="recent_depart_point" value=$clsTour->getListDeparturePointLink($recent_tour_id)}
                            {assign var="recent_getPriceTourPromotion" value=$clsTour->getTripPriceNewPro2020($recent_tour_id,$now_day,$is_agent,'detail')}
                            {assign var="is_online" value=$clsTour->checkisOnline($recent_tour_id)}
                            {assign var="getTripTourRelated" value=$clsTour->getTripDayText($recent_tour_id)}

                            {if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
                                {assign var="recent_getToTalReview" value=$clsReviews->getToTalReview($recent_tour_id,'tour')}
                                {assign var="recent_getStarNewIcon" value=$clsReviews->getStarNewIcon($recent_tour_id,'tour')}
                                {assign var="recent_getRateAvg" value=$clsReviews->getRateAvg($recent_tour_id,'tour')}
                            {else}
                                {assign var="recent_getToTalReview" value=$clsReviews->getToTalReviewNoLogin($recent_tour_id,'tour')}
                                {assign var="recent_getStarNewIcon" value=$clsReviews->getStarNewIconNoLogin($recent_tour_id,'tour')}
                                {assign var="recent_getRateAvg" value=$clsReviews->getRateAvgNologin($recent_tour_id,'tour')}
                            {/if}

                            {if $is_online}
                                <div class="swiper-slide hnv_tour_detail_recent_content_item">
                                    <a href="{$recent_tour_link}" class="hnv_tour_detail_recent_content_item_image"
                                       title="{$recent_tour_title}">
                                        <img src="{$clsTour->getImage($item,298,276)}" width="298" height="276"
                                             loading="lazy" class="scale_img_hover"/>
                                    </a>
                                    <div class="hnv_tour_detail_recent_content_item_info">
                                        {if $recent_depart_point}
                                            <div class="hnv_tour_detail_recent_content_item_start">
                                                <i class="fa-light fa-location-dot" aria-hidden="true"></i>
                                                {$core->get_Lang("Start")}: {$recent_depart_point}
                                            </div>
                                        {/if}
                                        <h3>
                                            <a href="{$recent_tour_link}" title="{$recent_tour_title}"
                                               class="hnv_tour_detail_recent_content_item_title">
                                                {$recent_tour_title}
                                            </a>
                                        </h3>
                                        <div class="hnv_tour_detail_recent_content_item_review">
                                            {if $getTripTourRelated}
                                                <div class="hnv_tour_detail_intro_review_duration">
                                                    {$getTripTourRelated} <i class="fa-solid fa-circle fa-2xs"></i>
                                                </div>
                                            {/if}
                                            <div class="hnv_tour_detail_recent_content_item_review_star">
                                                {$recent_getStarNewIcon}
                                            </div>
                                            <div class="hnv_tour_detail_recent_content_item_review_text">
                                                {$recent_getRateAvg} ({$recent_getToTalReview})
                                            </div>
                                        </div>
                                        <div class="hnv_tour_detail_recent_content_item_price">
                                            {if $recent_getPriceTourPromotion}
                                                {$core->get_Lang("from")} {$recent_getPriceTourPromotion}
                                            {else}
                                                <span class="size20 color_fb1111 color_c81e3a text_bold">
                                                {$core->get_Lang("Contact")}
                                            </span>
                                            {/if}
                                        </div>
                                    </div>
                                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
{/if}
{if $arr_tour_related}
    <section class="hnv_tour_detail_related">
        <div class="container">
            <div class="hnv_tour_detail_related_title">
                <h2>{$core->get_Lang("You might also like")}</h2>
            </div>
            <div class="hnv_tour_detail_related_content">
                <div style="--swiper-navigation-color: #fff;--swiper-pagination-color: #fff;"
                     class="swiper hnv_tour_detail_related_content_list">
                    <div class="swiper-wrapper">
                        {foreach from=$arr_tour_related key=key item=item}
                            {assign var="related_tour_id" value=$item['tour_id']}
                            {assign var="related_tour_title" value=$clsTour->getTitle($related_tour_id)}
                            {assign var="related_tour_link" value=$clsTour->getLink($related_tour_id)}
                            {assign var="related_depart_point" value=$clsTour->getListDeparturePointLink($related_tour_id)}
                            {assign var="related_getPriceTourPromotion" value=$clsTour->getTripPriceNewPro2020($related_tour_id,$now_day,$is_agent,'detail')}
                            {assign var="getTripTourRelated" value=$clsTour->getTripDayText($related_tour_id)}

                            {if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
                                {assign var="related_getToTalReview" value=$clsReviews->getToTalReview($related_tour_id,'tour')}
                                {assign var="related_getStarNewIcon" value=$clsReviews->getStarNewIcon($related_tour_id,'tour')}
                                {assign var="related_getRateAvg" value=$clsReviews->getRateAvg($related_tour_id,'tour')}
                            {else}
                                {assign var="related_getToTalReview" value=$clsReviews->getToTalReviewNoLogin($related_tour_id,'tour')}
                                {assign var="related_getStarNewIcon" value=$clsReviews->getStarNewIconNoLogin($related_tour_id,'tour')}
                                {assign var="related_getRateAvg" value=$clsReviews->getRateAvgNologin($related_tour_id,'tour')}
                            {/if}
                            <div class="swiper-slide hnv_tour_detail_related_content_item">
                                <a href="{$related_tour_link}" class="hnv_tour_detail_related_content_item_image"
                                   title="{$related_tour_title}">
                                    <img src="{$clsTour->getImage($related_tour_id,407,272)}" width="407" height="272"
                                         loading="lazy" class="scale_img_hover"/>
                                </a>
                                <div class="hnv_tour_detail_related_content_item_info">
                                    {if $related_depart_point}
                                        <div class="hnv_tour_detail_related_content_item_start">
                                            <i class="fa-light fa-location-dot" aria-hidden="true"></i>
                                            {$core->get_Lang("Start")}: {$related_depart_point}
                                        </div>
                                    {/if}
                                    <h3>
                                        <a href="{$related_tour_link}"
                                           class="hnv_tour_detail_related_content_item_title"
                                           title="{$related_tour_title}">
                                            {$related_tour_title}
                                        </a>
                                    </h3>
                                    <div class="hnv_tour_detail_related_content_item_review">
                                        {if $getTripTourRelated}
                                            <div class="hnv_tour_detail_intro_review_duration">
                                                {$getTripTourRelated} |
                                            </div>
                                        {/if}
                                        <div class="hnv_tour_detail_related_content_item_review_star">
                                            {$related_getStarNewIcon}
                                        </div>
                                        <div class="hnv_tour_detail_related_content_item_review_text">
                                            {$related_getRateAvg} ({$related_getToTalReview})
                                        </div>
                                    </div>
                                    <div class="hnv_tour_detail_related_content_item_price">
                                        {if $related_getPriceTourPromotion}
                                            {$core->get_Lang("from")} {$related_getPriceTourPromotion}
                                        {else}
                                            <span class="size20 color_fb1111 color_c81e3a text_bold">
                                                {$core->get_Lang("Contact")}
                                            </span>
                                        {/if}
                                    </div>
                                </div>
                                <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                            </div>
                        {/foreach}
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
{/if}

<script>
    var $tour_id = '{$tour_id}';
    if ($('.package_radio:checked').length) {
        $tour_id = $('.package_radio:checked').val()
    }
    var $Loading = '{$core->get_Lang("Loading")}';
    var selectmonth = '{$core->get_Lang("select month")}';
    var Input_data_is_invalid = '{$core->get_Lang("Input data is invalid")}';
    var Input_data_is_required = '{$core->get_Lang("Select data is required")}';
    var $_Expand_all = '{$core->get_Lang("Expand all")}';
    var $_Collapse_all = '{$core->get_Lang("Collapse all")}';
    var $_LANG_ID = '{$_LANG_ID}';
    var Adults = '{$core->get_Lang("Adults")}';
    var Children = '{$core->get_Lang("Children")}';
    var Infants = '{$core->get_Lang("Infants")}';
    var Departure_date_invalid = '{$core->get_Lang("Departure date is invalid")}';
    var Please_choose_departure_date = '{$core->get_Lang("Please choose departure date")}';
    var Warning = '{$core->get_Lang("Warning")}';
    var list_start_date = ['{$list_start_date}'];
    var $check_tour_promotion = '{$check_tour_promotion}';
    var $check_tour_start_date = '{$check_tour_start_date}';
    var getSelectChild = `{$getSelectChild}`;
    var getSelectInfant = `{$getSelectInfant}`;
    var txtAccordionExpand = '{$core->get_Lang("Expand All")}';
    var txtAccordionCollapse = '{$core->get_Lang("Collapse All")}';
    let iso_not_available = "{$core->get_Lang('Not Available')}";
    let iso_available = "{$core->get_Lang('Available')}";
    let iso_promotions = "{$core->get_Lang('Promotions')}";
    var has_package = {$has_package};
</script>
{$date_range_js_update}
<script src="{$URL_JS}/jquery.countdown.min.js?v={$upd_version}"></script>
<script src="{$URL_JS}/jquery-confirm.min.js?v={$upd_version}"></script>

{literal}
    <script>
        // Gallery tour
        $(function () {
            let thumsslider = $(".thumdsslider ul");
            const image = $(".hnv_tour_detail_gallery .swiper img");
            thumsslider.height(image.height());
            thumsslider.show();
            image.on("load", function () {
                thumsslider.height(image.height());
                thumsslider.show();
            });
            const swiper = new Swiper(".hnv_tour_detail_gallery .swiper", {
                slidesPerView: 1,
                spaceBetween: 0,
                lazy: {
                    loadPrevNext: true,
                    loadPrevNextAmount: 2,
                },
                autoplay: {
                    disableOnInteraction: true,
                    pauseOnMouseEnter: true,
                },
                speed: 500,
                loop: false,
                // navigation: {
                //     nextEl: ".swiper-next",
                //     prevEl: ".swiper-prev",
                // },
                on: {
                    slideChange: function (s) {
                        const index = s.realIndex;
                        $(".thumdsslider .active").removeClass("active");
                        const activeElement =
                            $(".thumdsslider li").eq(index);
                        activeElement.addClass("active");
                        // Auto scroll thumbs
                        const activePosition = activeElement.position();
                        const thumssliderPosition = thumsslider.position();
                        const heightElement = activeElement.height();
                        if (
                            activePosition.top + heightElement >
                            thumssliderPosition.top + thumsslider.height()
                        ) {
                            thumsslider.scrollTop(
                                (index + 1) * activeElement.height()
                            );
                            return;
                        }
                        if (activePosition.top < thumssliderPosition.top) {
                            thumsslider.scrollTop(
                                (index + 1) * activeElement.height() -
                                heightElement
                            );
                        }
                    },
                    resize: function () {
                        thumsslider.height(image.height());
                    },
                },
            });
            $(".thumdsslider li").click(function () {
                swiper.slideToLoop($(".thumdsslider li").index($(this)));
            });
            $(".thumdsslider").mouseover(function () {
                swiper.autoplay.stop();
            });
            $(".thumdsslider").mouseout(function () {
                swiper.autoplay.start();
            });
        });
        var swiper_hnv_tour_detail_main_intro_overview_place_top_list = new Swiper(".swiper_hnv_tour_detail_main_intro_overview_place_top_list", {
            // autoplay: {
            //     disableOnInteraction: true,
            //     pauseOnMouseEnter: true,
            // },
            // speed: 500,
            // loop: true,
            // pagination: {
            //     el: ".swiper-pagination",
            //     clickable: true,
            // },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            lazy: {
                loadPrevNext: true,
            },
            effect: "slide",
            slidesPerView: 4,
            spaceBetween: 20,
            breakpoints: {
                0: {
                    slidesPerView: 1.3,
                },
                350: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                },
            },
        });
        var hnv_tour_detail_recent_content_list = new Swiper(".hnv_tour_detail_recent_content_list", {
            // autoplay: {
            //     disableOnInteraction: true,
            //     pauseOnMouseEnter: true,
            // },
            // speed: 500,
            // loop: true,
            // pagination: {
            //     el: ".swiper-pagination",
            //     clickable: true,
            // },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            lazy: {
                loadPrevNext: true,
            },
            effect: "slide",
            spaceBetween: 30,
            breakpoints: {
                0: {
                    slidesPerView: 1.3,
                },
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                },
            },
        });
        var hnv_tour_detail_related_content_list = new Swiper(".hnv_tour_detail_related_content_list", {
            // autoplay: {
            //     disableOnInteraction: true,
            //     pauseOnMouseEnter: true,
            // },
            // speed: 500,
            // loop: true,
            // pagination: {
            //     el: ".swiper-pagination",
            //     clickable: true,
            // },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            lazy: {
                loadPrevNext: true,
            },
            effect: "slide",
            spaceBetween: 30,
            breakpoints: {
                0: {
                    slidesPerView: 1.3,
                },
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 3,
                },
            },
        });

        // Scroll đến bảng giá tour
        $(".hnv_btn_scroll").click(function () {
            var offsetTop;
            if ($(window).width() > 992) {
                offsetTop = $(".hnv_tour_detail_main_date_availability").offset().top - 125;
            } else {
                offsetTop = $(".hnv_tour_detail_main_date_availability").offset().top - 72;
            }
            $('html, body').animate({
                scrollTop: offsetTop
            }, 600);
        });

        // Active menu phụ khi scroll
        $(window).on('scroll', function () {
            if ($(window).width() > 992) {
                var scrollPosition = $(this).scrollTop() + 168;
            } else {
                var scrollPosition = $(this).scrollTop() + 115;
            }
            $('.hnv_scrollspy_item').each(function (index) {
                var sectionTop = $(this).offset().top;
                var sectionHeight = $(this).outerHeight();
                if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                    $('ul.hnv_tour_detail_main_nav_list .nav-link').removeClass('active');
                    $('ul.hnv_tour_detail_main_nav_list .nav-link').eq(index).addClass('active');
                }
            });
        });

        // Hàm scroll đến phần tử khi click thanh menu phụ
        function goToByScroll(id) {
            var offsetTop;
            if ($(window).width() > 992) {
                offsetTop = $("#" + id).offset().top - 168;
            } else {
                offsetTop = $("#" + id).offset().top - 115;
            }
            $('html, body').animate({
                scrollTop: offsetTop
            }, 600);
        }

        $(".hnv_tour_detail_main_nav_list .nav-link").click(function (e) {
            e.preventDefault();
            goToByScroll($(this).attr("data-target"));
        });

        // Hảm đóng/mở tất cả các accordion trong 1 button
        function toggleAllAccordion(clickElement, parentElement) {
            $(document).on('click', clickElement, function () {
                const accordionCollapse = $(this).closest(parentElement).find(".accordion-collapse.collapse");
                accordionCollapse.addClass('show');
                if ($(this).hasClass('expand')) {
                    $(this).removeClass('expand').text(txtAccordionExpand);
                    accordionCollapse.removeClass('show');
                    $(this).closest(parentElement).find(".accordion-item").removeClass('hnv_expand');
                    $(this).closest(parentElement).find(".accordion-button").addClass('collapsed');
                } else {
                    $(this).addClass('expand').text(txtAccordionCollapse);
                    accordionCollapse.addClass('show');
                    $(this).closest(parentElement).find(".accordion-item").addClass('hnv_expand');
                    $(this).closest(parentElement).find(".accordion-button").removeClass('collapsed');
                }
            });
        }

        toggleAllAccordion('.hnv_tour_detail_main_itinerary_title_expand', '.hnv_tour_detail_main_itinerary');
        toggleAllAccordion('.hnv_tour_detail_main_useful_information_title_expand', '.hnv_tour_detail_main_useful_information');

        // Hảm active accordion khi click
        function clickAccordion(clickElement) {
            $(clickElement).click(function () {
                var accordionButton = $(this).find('.accordion-button');
                if (accordionButton.hasClass('collapsed')) {
                    $(this).removeClass('hnv_expand');
                } else {
                    $(this).addClass('hnv_expand');
                }
            });
        }

        clickAccordion('.hnv_tour_detail_main_itinerary .accordion-item');
        clickAccordion('.hnv_tour_detail_main_useful_information .accordion-item');

        //
        $(document).on("click", ".trigger_contact", function () {
            $('.contact_now').trigger('click');
        });
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

        if (has_package) {
            function packageSelected(tour_id) {
                $.post(`${path_ajax_script}index.php?mod=${mod}&act=selectTourPackage&lang=${LANG_ID}`, {tour_id: tour_id}, function (res) {
                    $(".htmlInclusion").html(res.htmlInclusion)
                    $(".htmlExclusion").html(res.htmlExclusion)
                    $("#hnv_tour_detail_main_date_availability").html(res.htmlBoxFindTour)
                    getSelectChild = res.getSelectChild
                    getSelectInfant = res.getSelectInfant
                    GetMaxChildInfant(tour_id, 1)
                    GetMaxChildInfant(tour_id, 1)
                }, "json");

            }

            packageSelected($(".package_radio:checked").val())
            $(".package_radio").change(function () {
                let tour_id = $(this).val();
                let price = $(this).closest(".package_item").find(".package_price .size20.color_fb1111").text();
                $(".hnv_tour_detail_gallery_right_top .size20.color_fb1111").html(price)
                packageSelected(tour_id)
            })
        }
    </script>
{/literal}

{if $getToTalReview gt 0}
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
                    "ratingValue": "{/literal}{$getRateAvg}{literal}",
                    "bestRating": "{/literal}{$clsReviews->getBestRate($tour_id,$mod)}{literal}",
                    "ratingCount": "{/literal}{$getToTalReview}{literal}"
                }
            }
    </script>
{/literal}
{/if}

<script src="{$URL_JS}/jquery.tourdetail.js?v={$upd_version}"></script>