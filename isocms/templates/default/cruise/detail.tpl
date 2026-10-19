{assign var= title_cruise value= $clsCruise->getTitle($cruise_id,$oneTable)}
{assign var= link_cruise value= $clsCruise->getLink($cruise_id,$oneTable)}

{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
    {assign var= ratingValue value= $clsReviews->getReviews($cruise_id, 'avg_point','cruise')}
    {assign var= bestRating value= $clsReviews->getBestRate($cruise_id,'cruise')}
    {assign var= ratingCount value= $clsReviews->getToTalReview($cruise_id,'cruise')}
{else}
    {assign var= ratingValue value= $clsReviews->getReviews($cruise_id, 'avg_point','cruise')}
    {assign var= bestRating value= $clsReviews->getBestRate($cruise_id,'cruise')}
    {assign var= ratingCount value= $clsReviews->getToTalReviewNoLogin($cruise_id,'cruise')}
{/if}
{assign var=textRateAvg value=$clsReviews->getReviews($cruise_id,'txt_review','cruise')}
{assign var=getAbout value=$clsCruise->getAbout($cruise_id,$oneTable)}
{assign var=itemCruiseCat value=$clsCruiseCat->getOne($cruise_cat_id,' title,slug')}
{assign var=title_cat value=$itemCruiseCat.title}
{assign var=link_cat value=$clsCruiseCat->getLink($cruise_cat_id,$itemCruiseCat)}
{assign var=CruiseFacilities value=$clsCruise->getCruiseFa($cruise_id,CruiseFacilities,$oneTable)}
{assign var=CruiseServices value=$clsCruise->getCruiseFa($cruise_id,CruiseServices,$oneTable)}
{assign var=CruiseFaActivities value=$clsCruise->getCruiseFa($cruise_id,CruiseFaActivities,$oneTable)}
{assign var=Inclusion value=$clsCruise->getInclusion($cruise_id,$oneTable)}
{assign var=Exclusion value=$clsCruise->getExclusion($cruise_id,$oneTable)}
{assign var=CruisePolicy value=$clsCruise->getCruisePolicy($cruise_id,$oneTable)}
{assign var=BookingPolicy value=$clsCruise->getCruiseBookingPolicy($cruise_id,$oneTable)}
{assign var=getCruiseChildPolicy value=$clsCruise->getCruiseChildPolicy($cruise_id,$oneTable)}
{assign var=cruisePrice value=$clsCruise->getLTripPrice1($cruise_id,$now_month,'price_2024')}

{if $show eq 'Itinerary'}
    {assign var=table_map_id value=$cruise_itinerary_id}
    {assign var=checkPriceCruise value=$clsCruiseItinerary->getLTripPriceItinerary($cruise_itinerary_id,$now_month,'Value')}
    {assign var=address value=$clsCruiseItinerary->getAllCityAround($cruise_itinerary_id)}
{else}
    {assign var=table_map_id value=$cruise_id}
    {assign var=checkPriceCruise value=$clsCruise->getLTripPrice($cruise_id,$now_month,'Value')}
    {assign var=address value=$core->get_Lang('Departure Port')|cat:': '|cat:$clsCruise->getDeparturePort($cruise_id,$oneTable)}
{/if}
{assign var=start_from value = $clsCruise->getStartCityAround($cruise_id,0,0)}
{assign var=destination value = $clsCruise->getLCityAround2($cruise_id,0,0,' - ')}
<div class="page_container bg_fff">
    {$core->getBlock("2024_breadcrumb")}
    <div id="content" class="pageCruiseDetail">
        <section class="section_image">
            <div class="container">
                <div class="box_info_top">
                    <div class="box_info_top_left">
                        {$clsCruise->getStarNew($cruise_id,$oneTable)}
                        <a href="{$link_cat}" class="cruise_cat" title="{$title_cat}">{$title_cat}</a>
                        <div class="box_txt_reviews">
                            <span class="review_score">{$clsReviews->getReviews($cruise_id, "avg_point", "cruise")}</span>
                            <span class="review_txt">{$clsReviews->getReviews($cruise_id, "txt_review", "cruise")}</span>
                            <span class="review_cruise"> | {$ratingCount} {$core->get_Lang('reviews')}</span>
                        </div>
                        {if $oneTable.cruise_code ne ''}<span class="item_cruise_code">{$core->get_Lang('Code')}:
                            <span class="cruise_code">{$oneTable.cruise_code}</span>
                            </span>{/if}
                    </div>
                    <div class="box_share">
                        <button class="share_socical_detail collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#share_box" aria-expanded="false" aria-controls="share_box"><i class="fa-light fa-share-nodes" style="color: #1d2d53;"></i></button>
                        <div class="share_box" id="share_box">
                            {assign var=link_share value=$curl}
                            {assign var=title_share value=$title_cat}
                            {$clsISO->getBlock('box_share',["link_share"=>$link_share,"title_share"=>$title_share])}
                        </div>
                    </div>
                </div>
                <div class="div_title_cruise d-flex justify-content-md-between mb-4">
                    <div class="div_title_cruise_item">
                        <h1 class="title_cruise">{$title_cruise}</h1>
                        <div class="hnv_trvs_main_tour_item_content_info_place pt-2">
                            <div class="hnv_trvs_main_tour_item_content_info_place_icon">
                                <i class="fa-duotone fa-regular fa-anchor" aria-hidden="true"></i>
                            </div>
                            <label class="d-inline"><span>{$core->get_Lang("Departure port")}:</span>
                                {$oneTable.departure_port}
                            </label>
                        </div>
                    </div>
                    <div class="div_title_cruise_item mt-auto">
                        <div class="hnv_trvs_main_tour_item_content_price">
                            {if $cruisePrice}
                                <div>
                                    {$cruisePrice}
                                </div>
                            {else}
                                <div class="hnv_trvs_main_tour_item_content_price_number mb-2">
                                    <span>{$core->get_Lang("Contact")}</span>
                                </div>
                            {/if}
                            <button class="price--link hnv_trvs_main_tour_item_content_price_link hover_btn_green_dark" title="{$title_cruise}">
                                {$core->get_Lang('Book now')}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="big_image" data-fancybox="gallery" href="{$oneTable.image}">
                            <img class="img100" alt="{$title_cruise}"
                                 src="{$clsISO->tripslashImage($oneTable.image,733,486,$oneTable)}" width="733" height="486"/>
                            <p class="view_all">
                                <i class="fa-duotone fa-regular fa-images"></i>
                                {$core->get_Lang('View All')}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="d-flex flex-wrap box_image_left">
                            {if $lstVideoCruise}
                                {section name=i loop=$lstVideoCruise}
                                    {if $lstVideoCruise[i].url ne ''}
                                        <div class="image_small" data-fancybox="gallery">
                                            <img class="img100"
                                                 alt="{$clsCruiseVideo->getTitle($lstVideoCruise[i].cruise_video_id,$lstVideoCruise[i])}"
                                                 src="{$clsCruiseVideo->getImage($lstVideoCruise[i].cruise_video_id,264,238)}"
                                                 width="264" height="238"/>
                                        </div>
                                    {/if}
                                {/section}
                            {/if}
                            {if !empty($lstImage) && isset($lstImage[0]) && !empty($lstImage[0].cruise_image_id)}
    <div class="image_medium"
         data-fancybox="gallery"
         href="{$lstImage[0].image}">

        <img class="img100"
             alt="{$clsCruiseImage->getTitle($lstImage[0].cruise_image_id)}"
             src="{$clsCruiseImage->getImage($lstImage[0].cruise_image_id,537,238)}"
             width="537"
             height="238"/>
    </div>
{/if}
                            {if $lstImage|@count gt 1}
                                <div class="box_image_small">
                                    {section name=i loop=$lstImage start=1 step=1}
                                        <div class="image_small" data-fancybox="gallery" href="{$lstImage[i].image}"
                                             {if $smarty.section.i.index gt 2}hidden{/if}>
                                            <img class="img100"
                                                 alt="{$clsCruiseImage->getTitle($lstImage[i].cruise_image_id)}"
                                                 src="{$clsCruiseImage->getImage($lstImage[i].cruise_image_id,264,238)}"
                                                 width="264" height="238"/>
                                        </div>
                                    {/section}
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div id="tabsk" class="box__menu d-flex justify-content-between align-items-center tabskTour">
            <div class="container d-flex justify-content-between">
                <ul class="clienttabs list_style_none d-flex">
                    {if $getAbout}
                        <li><a id="overview--link" href="javascript:void(0);" class="nav-link"
                               data="0" data-target=".overview_box">{$core->get_Lang('Overview')}</a></li>{/if}
                    {if $lstItineraryCruise}
                        <li><a id="itinerary--link" href="javascript:void(0);" class="nav-link"
                               data="2" data-target=".itinerary_box">{$core->get_Lang('Cruise Itineraries')}</a></li>{/if}
                    <li><a id="price--link" href="javascript:void(0);" class="nav-link"
                           data="2" data-target=".price_box">{$core->get_Lang('Cabin & Prices')}</a></li>
                    <li><a id="notes--link" href="javascript:void(0);" class="nav-link"
                           data="2" data-target=".notes_box">{$core->get_Lang('Things to know')}</a></li>
                    <li><a id="review--link" href="javascript:void(0);" class="nav-link"
                           data="3" data-target=".reviews_box">{$core->get_Lang('Customer reviews')}</a></li>
                </ul>
                <div class="div_title_cruise_item my-auto">
                    <div class="hnv_trvs_main_tour_item_content_price">
                        {if $cruisePrice}
                            <div>
                                {$cruisePrice}
                            </div>
                        {else}
                            <div class="hnv_trvs_main_tour_item_content_price_number mb-2">
                                <span>{$core->get_Lang("Contact")}</span>
                            </div>
                        {/if}
                        <button class="price--link hnv_trvs_main_tour_item_content_price_link hover_btn_green_dark" title="{$title_cruise}">
                            {$core->get_Lang('Book now')}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="box_content_cruise">
            {if $deviceType eq 'phone'}
                <div class="box_form_contact box_price_detail">
                    {$cruisePrice}
                    <button class="btn_contact price--link hover_btn_green_dark">{$core->get_Lang('Book now')}</button>
                </div>
            {/if}
            <div class="container mt-3">
                <div class="list_tab">
                    <section id="overview" class="overview_box section_box">
                        <h2 class="title_cruise_box_detail">{$core->get_Lang('Overview')}</h2>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="box_info_cruise">
                                    {if $oneTable.build}
                                        <div class="item_info_cruise item_info_cruise_build">
                                            <label for=""
                                                   class="lbl_item_info_cruise">{$core->get_Lang('Build')}</label>
                                            <span class="value_item_info_cruise">{$oneTable.build}</span>
                                        </div>
                                    {/if}
                                    {if $oneTable.material}
                                        <div class="item_info_cruise item_info_cruise_material">
                                            <label for=""
                                                   class="lbl_item_info_cruise">{$core->get_Lang('Material')}</label>
                                            <span class="value_item_info_cruise">{$clsCruiseProperty->getTitle($oneTable.material)}</span>
                                        </div>
                                    {/if}
                                    {if $oneTable.total_cabin}
                                        <div class="item_info_cruise item_info_cruise_total_cabin">
                                            <label for=""
                                                   class="lbl_item_info_cruise">{$core->get_Lang('Cabin')}(s)</label>
                                            <span class="value_item_info_cruise">{$oneTable.total_cabin}</span>
                                        </div>
                                    {/if}
                                    {if $oneTable.departure_port}
                                        <div class="item_info_cruise item_info_cruise_start">
                                            <label for=""
                                                   class="lbl_item_info_cruise">{$core->get_Lang('Departure Port')}</label>
                                            <span class="value_item_info_cruise">{$oneTable.departure_port}</span>
                                        </div>
                                    {/if}
                                    {if $destination}
                                        <div class="item_info_cruise item_destination_cruise">
                                            <label for=""
                                                   class="lbl_item_info_cruise">{$core->get_Lang('Destinations')}</label>
                                            <span class="value_item_info_cruise">{$destination}</span>
                                        </div>
                                    {/if}
                                </div>
                            </div>
                            {if $getAbout}
                                <div class="col-lg-8">
                                    <div class="intro_about">
                                        {$getAbout}
                                    </div>
                                </div>
                            {/if}
                        </div>
                    </section>
                    {if $lstItineraryCruise}
                        <section id="itinerary" class="itinerary_box section_box">
                            <h2 class="title_cruise_box_detail">{$core->get_Lang('Cruise Itineraries')}</h2>
                            <div class="wapper_itinerary">
                                <div class="unikasia_btn_itineraries discovertour">
                                    <ul class="nav nav-tabs d-flex align-items-center mt-4" role="tablist">
                                        {section name=i loop=$lstItineraryCruise}
                                            {assign var= cruise_itinerary_id value= $lstItineraryCruise[i].cruise_itinerary_id}
                                            <li class="nav-item" role="presentation"> <button class="nav-link item_btn_itineraries {if $smarty.section.i.index == 0} active {/if}" data-list="unika_list_itineraries_{$cruise_itinerary_id}">
                                                    {if $lstItineraryCruise[i].title_itinerary} {$lstItineraryCruise[i].title_itinerary} {else}{$title_cruise} {$lstItineraryCruise[i].number_day} {$core->get_Lang('days')}{/if}
                                                </button> </li>
                                        {/section}
                                    </ul>
                                </div>
                                {section name=i loop=$lstItineraryCruise}
                                    {assign var= _cruise_itinerary_id value= $lstItineraryCruise[i].cruise_itinerary_id}
                                    {assign var=lstDayItinerary value = $clsCruiseItineraryDay->getAll("is_trash=0 and cruise_itinerary_id='$_cruise_itinerary_id' order by day ASC")}
                                    {assign var=number_day value=$lstItineraryCruise[i].number_day}
                                    {assign var=des_itinerary value=$clsCruiseDestination->getDesIti($cruise_id,$_cruise_itinerary_id)}
                                    {assign var=meal_itinerary value=$clsCruiseItinerary->getListMealItineraryDay($lstItineraryCruise[i].cruise_itinerary_id, 1)}
                                    {if $lstDayItinerary}
                                        <div class="item-itinerary">
                                            <div id="collapse{$smarty.section.i.index}" class="item_body collapse unika_list_itineraries_{$_cruise_itinerary_id} {if $smarty.section.i.index == 0} show{/if}"
                                                 data-bs-parent="#accordion">
                                                {section name=k loop=$number_day}
                                                    {assign var=lst_transport_id value=$clsCruiseItineraryDay->getOneField("transport",$lstDayItinerary[k].cruise_itinerary_day_id)}
                                                    {assign var=lstItineraryTransport value=$clsTransport->getAll("is_trash=0 and is_online=1 and transport_id in ($lst_transport_id) order by order_no ASC")}
                                                    <div class="item_day_itinerary">
                                                        <div class="position-relative item_header_day cursor-pointer collapsed d-flex justify-content-between align-items-center"
                                                             data-bs-toggle="collapse"
                                                             href="#collapse{$smarty.section.i.index}{$smarty.section.k.index}">
                                                            <span class="title_day position-relative">{$clsCruiseItineraryDay->getTitle($lstDayItinerary[k].cruise_itinerary_day_id)} {if $meal_itinerary}({$meal_itinerary}){/if}</span>
                                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            <div class="itineraries_fa"> </div>
                                                        </div>
                                                        <div id="collapse{$smarty.section.i.index}{$smarty.section.k.index}"
                                                             class="body_item_day_itinerary main-txt-color-dark pb-3 collapse tinymce_Content">
                                                            {if $clsCruiseItineraryDay->checkShowImage($lstDayItinerary[k].cruise_itinerary_day_id)}
                                                                <div class="row">
                                                                    <div class="col-lg-4 col-md-5 mb15_767">
                                                                        <img class="img100"
                                                                             src="{$clsCruiseItineraryDay->getImage($lstDayItinerary[k].cruise_itinerary_day_id,384,256)}"
                                                                             alt="{$clsCruiseItineraryDay->getTitle($lstDayItinerary[k].cruise_itinerary_day_id)}"
                                                                             width="384" height="256"/>
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-7">
                                                                        {$clsCruiseItineraryDay->getContent($lstDayItinerary[k].cruise_itinerary_day_id)}
                                                                    </div>
                                                                </div>
                                                            {else}
                                                                {$clsCruiseItineraryDay->getContent($lstDayItinerary[k].cruise_itinerary_day_id)}
                                                            {/if}
                                                        </div>
                                                    </div>
                                                {/section}
                                            </div>
                                        </div>
                                    {/if}
                                {/section}
                            </div>
                        </section>
                    {/if}
                    {if $oneTable.file_programme ne ""}
                        <div class="box_download_file">
                            <div class="box_download_file_left">
                                <h3 class="title_download_file">{$core->get_Lang('Want to read it later?')}</h3>
                                <p class="text_download_file">{$core->get_Lang('Download the PDF document of this tour and start planning your tour offline')}. <a href="{$oneTable.file_programme}" title="{$core->get_Lang('Download')}" class="click_here" download>{$core->get_Lang("Click here")}</a> {$core->get_Lang("to download")}</p>
                            </div>
                        </div>
                    {/if}
                    {$clsISO->getBlock('filter_cabin_cruise')}
                    <section id="notes" class="notes_box section_box">
                        <h2 class="title_cruise_box_detail">{$core->get_Lang('Things to know')}</h2>
                        <div class="box_important_notes">
                            <div class="nav nav-pills {if $deviceType eq 'phone'}owl-carousel{else} flex-column {/if}"
                                 id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                {assign var=checkActive value=0}
                                {if $CruiseFacilities || $CruiseServices || $CruiseFaActivities}
                                    <button class="nav-link {if !$checkActive}active{/if}" id="v-pills-facilities-tab"
                                            data-bs-toggle="pill" data-bs-target="#v-pills-facilities" type="button"
                                            role="tab" aria-controls="v-pills-facilities"
                                            aria-selected="true">{$core->get_Lang('Facilities')}</button>
                                    {if !$checkActive}{assign var=checkActive value=1}{/if}
                                {/if}
                                {if $Inclusion}
                                    <button class="nav-link {if !$checkActive}active{/if}" id="v-pills-Inclusion-tab"
                                            data-bs-toggle="pill" data-bs-target="#v-pills-Inclusion" type="button"
                                            role="tab" aria-controls="v-pills-Inclusion"
                                            aria-selected="false">{$core->get_Lang('Included')}</button>
                                    {if !$checkActive}{assign var=checkActive value=1}{/if}
                                {/if}
                                {if $Exclusion}
                                    <button class="nav-link {if !$checkActive}active{/if}" id="v-pills-Exclusion-tab"
                                            data-bs-toggle="pill" data-bs-target="#v-pills-Exclusion" type="button"
                                            role="tab" aria-controls="v-pills-Exclusion"
                                            aria-selected="false">{$core->get_Lang('Excluded')}</button>
                                    {if !$checkActive}{assign var=checkActive value=1}{/if}
                                {/if}
                                {if $CruisePolicy}
                                    <button class="nav-link {if !$checkActive}active{/if}" id="v-pills-CruisePolicy-tab"
                                            data-bs-toggle="pill" data-bs-target="#v-pills-CruisePolicy" type="button"
                                            role="tab" aria-controls="v-pills-CruisePolicy"
                                            aria-selected="false">{$core->get_Lang('Booking Cruise Policy')}</button>
                                    {if !$checkActive}{assign var=checkActive value=1}{/if}
                                {/if}
                                {if $BookingPolicy}
                                    <button class="nav-link {if !$checkActive}active{/if}"
                                            id="v-pills-BookingPolicy-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-BookingPolicy" type="button" role="tab"
                                            aria-controls="v-pills-BookingPolicy"
                                            aria-selected="false">{$core->get_Lang('Booking Policy')}</button>
                                    {if !$checkActive}{assign var=checkActive value=1}{/if}
                                {/if}
                                {if $getCruiseChildPolicy}
                                    <button class="nav-link {if !$checkActive}active{/if}" id="v-pills-ChildPolicy-tab"
                                            data-bs-toggle="pill" data-bs-target="#v-pills-ChildPolicy" type="button"
                                            role="tab" aria-controls="v-pills-ChildPolicy"
                                            aria-selected="false">{$core->get_Lang('Child Policy')}</button>
                                    {if !$checkActive}{assign var=checkActive value=1}{/if}
                                {/if}
                            </div>
                            <div class="tab-content" id="v-pills-tabContent">
                                {assign var=checkActiveContent value=0}
                                {if $CruiseFacilities || $CruiseServices || $CruiseFaActivities}
                                    <div class="tab-pane fade {if !$checkActiveContent}show active{/if}"
                                         id="v-pills-facilities" role="tabpanel"
                                         aria-labelledby="v-pills-facilities-tab">
                                        {if $CruiseFacilities}
                                            <div class="box_cruise_facilities">
                                                <label for=""
                                                       class="lbl_title_facilities">{$core->get_Lang('Cruise Facilities')}</label>
                                                <div class="row">
                                                    {section name=i loop=$CruiseFacilities}
                                                        <div class="col-md-4">
                                                            <div class="item_facilities">
                                                                {if $CruiseFacilities[i].image ne ''}
                                                                    <img src="{$CruiseFacilities[i].image}" width="20"
                                                                         height="20" alt="{$CruiseFacilities[i].title}"
                                                                         class="icon_facilities">
                                                                {else}
                                                                    <img src="/uploads/icon/tick-circle-outline.png" width="20"
                                                                         height="20" alt="tick"
                                                                         class="icon_facilities">
                                                                {/if}
                                                                <span class="lbl_item_facilities">{$CruiseFacilities[i].title}</span>
                                                            </div>
                                                        </div>
                                                    {/section}
                                                </div>
                                            </div>
                                        {/if}
                                        {if $CruiseServices}
                                            <div class="box_cruise_facilities">
                                                <label for=""
                                                       class="lbl_title_facilities">{$core->get_Lang('Cruise Services')}</label>
                                                <div class="row">
                                                    {section name=i loop=$CruiseServices}
                                                        <div class="col-md-4">
                                                            <div class="item_facilities">
                                                                {if $CruiseServices[i].image ne ''}
                                                                    <img src="{$CruiseServices[i].image}" width="20"
                                                                         height="20" alt="{$CruiseServices[i].title}"
                                                                         class="icon_facilities">
                                                                {else}
                                                                    <img src="/uploads/icon/tick-circle-outline.png" width="20"
                                                                         height="20" alt="tick"
                                                                         class="icon_facilities">
                                                                {/if}
                                                                <span class="lbl_item_facilities">{$CruiseServices[i].title}</span>
                                                            </div>
                                                        </div>
                                                    {/section}
                                                </div>
                                            </div>
                                        {/if}
                                        {if $CruiseFaActivities}
                                            <div class="box_cruise_facilities">
                                                <label for=""
                                                       class="lbl_title_facilities">{$core->get_Lang('Activities on Board')}</label>
                                                <div class="row">
                                                    {section name=i loop=$CruiseFaActivities}
                                                        <div class="col-md-4">
                                                            <div class="item_facilities">
                                                                {if $CruiseFaActivities[i].image ne ''}
                                                                    <img src="{$CruiseFaActivities[i].image}" width="20"
                                                                         height="20"
                                                                         alt="{$CruiseFaActivities[i].title}"
                                                                         class="icon_facilities">
                                                                {else}
                                                                    <img src="/uploads/icon/tick-circle-outline.png" width="20"
                                                                         height="20" alt="tick"
                                                                         class="icon_facilities">
                                                                {/if}
                                                                <span class="lbl_item_facilities">{$CruiseFaActivities[i].title}</span>
                                                            </div>
                                                        </div>
                                                    {/section}
                                                </div>
                                            </div>
                                        {/if}
                                    </div>
                                    {if !$checkActiveContent}{assign var=checkActiveContent value=1}{/if}
                                {/if}
                                {if $Inclusion}
                                    <div class="tab-pane fade {if !$checkActiveContent}show active{/if}"
                                         id="v-pills-Inclusion" role="tabpanel"
                                         aria-labelledby="v-pills-Inclusion-tab">{$Inclusion}</div>
                                    {if !$checkActiveContent}{assign var=checkActiveContent value=1}{/if}
                                {/if}
                                {if $Exclusion}
                                    <div class="tab-pane fade {if !$checkActiveContent}show active{/if}"
                                         id="v-pills-Exclusion" role="tabpanel"
                                         aria-labelledby="v-pills-Exclusion-tab">{$Exclusion}</div>
                                    {if !$checkActiveContent}{assign var=checkActiveContent value=1}{/if}
                                {/if}
                                {if $CruisePolicy}
                                    <div class="tab-pane fade {if !$checkActiveContent}show active{/if}"
                                         id="v-pills-CruisePolicy" role="tabpanel"
                                         aria-labelledby="v-pills-CruisePolicy-tab">{$CruisePolicy}</div>
                                    {if !$checkActiveContent}{assign var=checkActiveContent value=1}{/if}
                                {/if}
                                {if $BookingPolicy}
                                    <div class="tab-pane fade {if !$checkActiveContent}show active{/if}"
                                         id="v-pills-BookingPolicy" role="tabpanel"
                                         aria-labelledby="v-pills-BookingPolicy-tab">{$BookingPolicy}</div>
                                    {if !$checkActiveContent}{assign var=checkActiveContent value=1}{/if}
                                {/if}
                                {if $getCruiseChildPolicy}
                                    <div class="tab-pane fade {if !$checkActiveContent}show active{/if}"
                                         id="v-pills-ChildPolicy" role="tabpanel"
                                         aria-labelledby="v-pills-ChildPolicy-tab">{$getCruiseChildPolicy}</div>
                                    {if !$checkActiveContent}{assign var=checkActiveContent value=1}{/if}
                                {/if}
                            </div>
                        </div>
                    </section>
                    <section class="reviews_box section_box" id="review">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="title_cruise_box_detail">{$core->get_Lang('Customer reviews')}</h2>
                            {$clsISO->getBlock('2024_box_review')}
{*                            <button class="btn_cruise_review btn_write_review_login">{$core->get_Lang('Reviews')}</button>*}
                        </div>
                        <div class="row align-items-center">
                            <div class="col-lg-3">
                                <div class="box_score">
                                    <div class="score_number">{$ratingValue}</div>
                                    <div class="score_text">
                                        <p class="txt_score">{$textRateAvg}</p>
                                        <p class="number_review">{$ratingCount} {$core->get_Lang('Reviews')}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box_rate_score">
                                    {if $lstReviewCruise.cruise_quality}
                                        {math equation='x/10' x=$lstReviewCruise.cruise_quality assign=cruise_quality}
                                    {else}
                                        {assign var=cruise_quality value=0}
                                    {/if}
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Cruise quality')}</label>
                                        <span>{$cruise_quality}</span>
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                 aria-valuenow="{$cruise_quality}" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: {$lstReviewCruise.cruise_quality}%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box_rate_score">
                                    {if $lstReviewCruise.staff_quality}
                                        {math equation='x/10' x=$lstReviewCruise.staff_quality assign=staff_quality}
                                    {else}
                                        {assign var=staff_quality value=0}
                                    {/if}
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Staff quality')}</label>
                                        <span>{$staff_quality}</span>
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                 aria-valuenow="{$staff_quality}" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: {$lstReviewCruise.staff_quality}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box_rate_score">
                                    {if $lstReviewCruise.food_drink}
                                        {math equation='x/10' x=$lstReviewCruise.food_drink assign=food_drink}
                                    {else}
                                        {assign var=food_drink value=0}
                                    {/if}
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Food/Drink')}</label>
                                        <span>{$food_drink}</span>
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="{$food_drink}"
                                                 aria-valuemin="0" aria-valuemax="100"
                                                 style="width: {$lstReviewCruise.food_drink}%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box_rate_score">
                                    {if $lstReviewCruise.entertainment}
                                        {math equation='x/10' x=$lstReviewCruise.entertainment assign=entertainment}
                                    {else}
                                        {assign var=entertainment value=0}
                                    {/if}
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Entertainment')}</label>
                                        <span>{$entertainment}</span>
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                 aria-valuenow="{$entertainment}" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: {$lstReviewCruise.entertainment}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box_rate_score">
                                    {if $lstReviewCruise.cabin_quality}
                                        {math equation='x/10' x=$lstReviewCruise.cabin_quality assign=cabin_quality}
                                    {else}
                                        {assign var=cabin_quality value=0}
                                    {/if}
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Cabin quality')}</label>
                                        <span>{$cabin_quality}</span>
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                 aria-valuenow="{$cabin_quality}" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: {$lstReviewCruise.cabin_quality}%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box_rate_score">
                                    {if $lstReviewCruise.worth_the_money}
                                        {math equation='x/10' x=$lstReviewCruise.worth_the_money assign=worth_the_money}
                                    {else}
                                        {assign var=worth_the_money value=0}
                                    {/if}
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Worth the money')}</label>
                                        <span>{$worth_the_money}</span>
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                 aria-valuenow="{$worth_the_money}" aria-valuemin="0"
                                                 aria-valuemax="100"
                                                 style="width: {$lstReviewCruise.worth_the_money}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {if $lstReview}
                            <h3 class="title_list_review">{$core->get_Lang("Guests who stayed here loved")}</h3>
                            <div class="box_list_reviews owl-carousel">
                                {section name=i loop=$lstReview}
                                    {assign var=reviews_content value=$clsReviews->getContent($lstReview[i].reviews_id,400,true,$lstReview[i])}
                                    <div class="review_item">
                                        <div class="top_item_review">
                                            <div class="avatar">
                                                <span>{$lstReview[i].fullname|truncate:1:"":true}</span>
                                            </div>
                                            <div class="info">
                                                <p class="name">{$lstReview[i].fullname}</p>
                                                <p class="country">{$clsCountry->getTitle($lstReview[i].country_id)}</p>
                                            </div>
                                        </div>
                                        <div class="content_review content_review_short limit_3line">
                                            {$clsReviews->getContent($lstReview[i].reviews_id,400,true,$lstReview[i])|html_entity_decode}
                                        </div>
                                        <div class="content_review content_review_full" style="display:none">
                                            {$clsReviews->getContent($lstReview[i].reviews_id,400,false,$lstReview[i])|html_entity_decode}
                                        </div>
                                        <a data-bs-toggle="modal" data-bs-target="#mdReview"
                                           class="read_more_review">{$core->get_Lang('Read more')}</a>
                                    </div>
                                {/section}
                            </div>
                        {/if}
                    </section>
                </div>
            </div>
            {$core->getBlock('box_service_ad')}
            {*            {$core->getBlock('relateCruise')}*}
            {$core->getBlock('cruise_recently_viewed')}
        </div>
    </div>
</div><!--wapper_content-->
<!-- Modal -->
<div class="modal fade" id="mdReview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="box_content"></div>
            </div>
        </div>
    </div>
</div>
<script src="{$URL_JS}/jquery.form.js?v={$upd_version}"></script>
<script>
    var $cruise_id = '{$cruise_id}';
    var txt_showMore = '{$core->get_Lang("Show more")}';
    var txt_showLess = '{$core->get_Lang("Show less")}';
    var map_la = '{$map_la}';
    var map_lo = '{$map_lo}';
    var cruise_id = '{$cruise_id}';
    var cruise_itinerary_id = '{$cruise_itinerary_id}';
</script>