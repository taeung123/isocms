{assign var=title_hotel value=$clsHotel->getTitle($hotel_id,$oneItem)}
{assign var=hotel__id value=$hotel_id}
{assign var=intro_hotel value=$oneItem.intro}
{assign var=overview_hotel value=$oneItem.overview}
{assign var=bookingPolicy_hotel value=$clsHotel->getHotelBookingPolicy($hotel_id,oneItem)}

{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
    {assign var= ratingValue value= $clsReviews->getRateAvg($hotel__id,'hotel')}
    {assign var= bestRating value= $clsReviews->getBestRate($hotel__id,'hotel')}
    {assign var= ratingCount value= $clsReviews->getToTalReview($hotel__id,'hotel')}
{else}
    {assign var= ratingValue value= $clsReviews->getRateAvgNoLogin($hotel__id,'hotel')}
    {assign var= bestRating value= $clsReviews->getBestRate($hotel__id,'hotel')}
    {assign var= ratingCount value= $clsReviews->getToTalReviewNoLogin($hotel__id,'hotel')}
{/if}
{math equation=x*2 assign="rating_value_of_10" x=$ratingValue}
{assign var=textRateAvg value=$clsReviews->getTextRateAvg($hotel__id,'hotel')}
{literal}
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Hotel",
        "name": "{/literal}{$title_hotel}{literal}",
    "description": "{/literal}{$intro_hotel|html_entity_decode|replace:'"':'\"'|strip_tags}{literal}",
    "address": {
        "@type": "PostalAddress",
        "addressCountry": "{/literal}{$_LANG_ID}{literal}",
        "addressLocality": "",
        "addressRegion": "{/literal}{$district_name}{literal}",
        "postalCode": "",
        "streetAddress": "{/literal}{$clsHotel->getAddress($hotel_id,$oneItem)}{literal}"
    },
    "telephone": "{/literal}{$oneItem.phone}{literal}",
    "photo": [
    {/literal}{section name=i loop=$listImage}{literal}
    "{/literal}{$DOMAIN_NAME}{$listImage[i].image}{literal}",
    {/literal}{/section}{literal}
    "{/literal}{$DOMAIN_NAME}{$oneItem.image}{literal}"
    ]
}
</script>
{/literal}
<div class="page_container bg_fff">
    <nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{$PCMS_URL}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{$clsISO->getLink('hotel')}" title="{$core->get_Lang('Hotels')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Hotels')}</span></a>
                    <meta itemprop="position" content="2"/>
                </li>
                {if $oneItem.country_id}

                    {assign var=title_country value=$clsCountryEx->getTitle($oneItem.country_id)}
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{$clsCountryEx->getLink($oneItem.country_id,'Hotel')}"
                           title="{$title_country}">
                            <span itemprop="name" class="reb">{$title_country}</span></a>
                        <meta itemprop="position" content="3"/>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
                        <a itemprop="item" href="{$curl}" title="{$title_hotel}">
                            <span itemprop="name" class="reb">{$title_hotel}</span></a>
                        <meta itemprop="position" content="4"/>
                    </li>
                {else}
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
                        <a itemprop="item" href="{$curl}" title="{$title_hotel}">
                            <span itemprop="name" class="reb">{$title_hotel}</span></a>
                        <meta itemprop="position" content="3"/>
                    </li>
                {/if}

            </ol>
        </div>
    </nav>
    <div id="contentPage" class="content hotelPageDetail mt05">
        <div class="hotelDetail">
            <div class="container">
                <section class="section_box_image_top">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="big_image">
                                <img class="img100" alt="{$title_hotel}"
                                     src="{$clsHotel->getImage($hotel_id,850,391,$oneItem)}"/>
                                <p class="view_all" data-fancybox="gallery"
                                   href="{$oneItem.image}">{$core->get_Lang('See all')}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="list_image_small">
                                {section name=i loop=$listImage}
                                    <div class="small_image" data-fancybox="gallery" href="{$listImage[i].image}"
                                         {if $smarty.section.i.index gt 3}hidden{/if}>
                                        <img class="img100"
                                             alt="{$clsHotelImage->getTitle($listImage[i].hotel_image_id,$listImage[i])}"
                                             src="{$clsHotelImage->getImage($listImage[i].hotel_image_id,202,189,$listImage[i])}"/>
                                    </div>
                                {/section}
                            </div>
                        </div>
                    </div>
                </section>

                <div class="row">
                    <div class="col-lg-8">
                        <section class="hotel_detail_main">
                            <div class="info_review_top">
                                <div class="info_review_top_left">
                                    {if $clsProperty->getTitle($oneItem.list_TypeHotel)}
                                        <div class="hotel_text_cat">
                                            {$clsProperty->getTitle($oneItem.list_TypeHotel)}
                                        </div>
                                    {/if}
                                    <div class="rank_level">
                                        {$ratingValue|number_format:1}/5 - {$textRateAvg}
                                    </div>
                                    <div class="total_review">
                                        {$ratingCount} {$core->get_Lang('reviews')}
                                    </div>
                                </div>
                                <div class="icon_share">
                                    <i class="ic ic_share"></i>
                                    <div class="share_box">
                                        <script defer type="text/javascript"
                                                src="{$URL_JS}/jquery.sharer.js?v={$up_version}"></script>
                                        {assign var=link_share value=$curl}
                                        {assign var=title_share value=$title_hotel}
                                        {$clsISO->getBlock('box_share',["link_share"=>$link_share,"title_share"=>$title_share])}
                                    </div>
                                </div>
                            </div>
                            <div class="box_sec_title">
                                <h1 class="sec_title">
                                    {$title_hotel}
                                    {$clsHotel->getStarNew($hotel_id,$oneItem)}
                                    {*{if $clsHotel->getImageStar($oneItem.star_id) != ''}
                                        <img height="19" src="{$clsHotel->getImageStar($oneItem.star_id)}" alt="{$title_hotel}" style="width:auto"/>
                                    {/if}*}
                                </h1>
                                <div class="address">
                                    <i class="fa fa-map-marker"></i>&nbsp;&nbsp;{$clsHotel->getAddress($hotel_id,$oneItem)}
                                    -
                                    <a role="link" title="map" data-bs-toggle="modal"
                                       data-bs-target="#mapModal{$hotel__id}">{$core->get_Lang('Show map')}</a>
                                    <div class="modal fade mapModal" id="mapModal{$hotel__id}" tabindex="-1"
                                         aria-labelledby="mapModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <iframe src="https://maps.google.it/maps?q={$clsHotel->getAddressMapView($hotel_id,$oneItem)}&output=embed"
                                                            width="600" height="450" style="border:0;"
                                                            allowfullscreen="" loading="lazy"
                                                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sec_intro">
                                {$overview_hotel|html_entity_decode}
                            </div>
                            {if $lstHotelFacility}
                                <div class="box_facilities">
                                    <div class="box_facilities_title">
                                        {$core->get_Lang('Most popular amenities')}
                                    </div>
                                    <div class="list_facilities">
                                        {section name=i loop=$lstHotelFacility}
                                            <div class="facilities_item align-items-center">
                                                {if $clsProperty->getImage($lstHotelFacility[i])}
                                                    <img width="16" height="16"
                                                         src="{$clsProperty->getImage($lstHotelFacility[i])}"
                                                         alt="{$clsProperty->getTitle($lstHotelFacility[i])}"/>
                                                {/if}
                                                <div class="facilities_name">
                                                    {$clsProperty->getTitle($lstHotelFacility[i])}
                                                </div>
                                            </div>
                                        {/section}

                                    </div>
                                </div>
                            {/if}

                        </section>

                    </div>
                    <div class="col-lg-4">
                        <section class="box_right_info_hotel sticky_fix">
                            <div class="box_info_right_top">
                                <div class="price_from_text">
                                    {if $clsHotel->getPriceOnPromotion($hotel_id,'detail')}
                                        <div class="from_text">
                                            {$core->get_Lang('Only from')}
                                        </div>
                                        <div class="val_price">
                                            {$clsHotel->getPriceOnPromotion($hotel_id,'detail')}
                                        </div>
                                    {/if}
                                </div>
                                <form action="" method="post">
                                    <input type="hidden" name="hotel_id" value="{$hotel_id}">
                                    <input type="hidden" name="ContactHotel" value="ContactHotel">
                                    <button class="departure_day">{$core->get_Lang('Contact')}</button>
                                </form>
                            </div>
                            {$core->getBlock('Lfaqscolbox')}

                        </section>
                    </div>
                </div>
                {assign var=_CheckInRoom value=$clsHotel->getCheckInRoom($hotel_id,$oneItem)}
                {assign var=_CheckOutRoom value=$clsHotel->getCheckOutRoom($hotel_id,$oneItem)}
                {assign var=_BookingPolicy value=$clsHotel->getBookingPolicy($hotel_id,$oneItem)}
                {assign var=_ChildPolicy value=$clsHotel->getChildPolicy($hotel_id,$oneItem)}
                {assign var=_CancellationPolicy value=$clsHotel->getCancellationPolicy($hotel_id,$oneItem)}
                {assign var=_OtherPolicy value=$clsHotel->getOtherPolicy($hotel_id,$oneItem)}
                {if $_CheckInRoom || $_BookingPolicy || $_ChildPolicy || $_CancellationPolicy || $_OtherPolicy ||$listCustomField}
                    <section class="sec_info_hotel">
                        <h2 class="sec_info_title">{$title_hotel} {$core->get_Lang('Informations')}</h2>
                        <div class="important_note_box">
                            {if $_CheckInRoom || $_CheckOutRoom}
                                <div class="important_note_item">
                                    <h3 class="note_title check_in_out">{$core->get_Lang('Check-in/check-out time')}</h3>
                                    <div class="box_right">
                                        <p class="box_right_content">{$_CheckInRoom} - {$_CheckOutRoom}</p>
                                    </div>
                                </div>
                            {/if}

                            {if $_BookingPolicy ne ''}
                                <div class="important_note_item">
                                    <h3 class="note_title booking_policy">{$core->get_Lang('Booking policy')}</h3>
                                    <div class="box_right">
                                        <p class="box_right_content">{$_BookingPolicy}</p>
                                    </div>
                                </div>
                            {/if}

                            {if $_ChildPolicy ne ''}
                                <div class="important_note_item">
                                    <h3 class="note_title bed">{$core->get_Lang('Children policy and bed')}</h3>
                                    <div class="box_right">
                                        <p class="box_right_content">{$_ChildPolicy}</p>
                                    </div>
                                </div>
                            {/if}

                            {if $_CancellationPolicy ne ''}
                                <div class="important_note_item">
                                    <h3 class="note_title cancel_prepay">{$core->get_Lang('Cancellation/prepayment')}</h3>
                                    <div class="box_right">
                                        <p class="box_right_content">{$_CancellationPolicy}</p>
                                    </div>
                                </div>
                            {/if}
                            {if $_OtherPolicy ne ''}
                                <div class="important_note_item">
                                    <h3 class="note_title other_regulation">{$core->get_Lang('Other regulations')}</h3>
                                    <div class="box_right">
                                        <p class="box_right_content">{$_OtherPolicy}</p>
                                    </div>
                                </div>
                            {/if}

                            {if $listCustomField}
                                {section name=i loop=$listCustomField}
                                    {if $listCustomField[i].fieldvalue ne ''}
                                        <div class="important_note_item">
                                            <h3 class="note_title">{$listCustomField[i].fieldname}</h3>
                                            <div class="box_right">
                                                <p class="box_right_content">{$listCustomField[i].fieldvalue|html_entity_decode}</p>
                                            </div>
                                        </div>
                                    {/if}
                                {/section}
                            {/if}
                        </div>
                    </section>
                {/if}

                <section class="customer_reviews">
                    <h2 class="customer_review_title">{$core->get_Lang('Customer reviews')}</h2>
                    <div class="customer_reviews_main">
                        <div class="reviews_box_top">
                            <div class="row align-items-center">
                                <div class="col-lg-3">
                                    <div class="box_score">
                                        <div class="score_number">{$ratingValue}</div>
                                        <div class="score_text">
                                            <p class="txt_score">{$textRateAvg}</p>
                                            <p class="number_review">
                                                {$ratingCount} {$core->get_Lang('Reviews')}
                                                <a class="view_all_review btn_write_review btn_write_review_login"
                                                   href="javascript:void(0);"
                                                   title="{$core->get_Lang('Reviews')}">{$core->get_Lang('Reviews')}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="box_rate_score">
                                        {if $lstReviewHotel.staff}
                                            {math equation='x/10' x=$lstReviewHotel.staff assign=staff}
                                        {else}
                                            {assign var=staff value=0}
                                        {/if}
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Staff')}</label>
                                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="{$staff}"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                     style="width: {$lstReviewHotel.staff}%"></div>
                                            </div>
                                            <span>{$staff}</span>
                                        </div>
                                    </div>
                                    <div class="box_rate_score">
                                        {if $lstReviewHotel.place}
                                            {math equation='x/10' x=$lstReviewHotel.place assign=place}
                                        {else}
                                            {assign var=place value=0}
                                        {/if}
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Place')}</label>
                                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="{$place}"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                     style="width: {$lstReviewHotel.place}%"></div>
                                            </div>
                                            <span>{$place}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="box_rate_score">
                                        {if $lstReviewHotel.amenities}
                                            {math equation='x/10' x=$lstReviewHotel.amenities assign=amenities}
                                        {else}
                                            {assign var=amenities value=0}
                                        {/if}
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Amenities')}</label>
                                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     aria-valuenow="{$amenities}" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: {$lstReviewHotel.amenities}%"></div>
                                            </div>
                                            <span>{$amenities}</span>
                                        </div>
                                    </div>
                                    <div class="box_rate_score">
                                        {if $lstReviewHotel.food_drink}
                                            {math equation='x/10' x=$lstReviewHotel.food_drink assign=food_drink}
                                        {else}
                                            {assign var=food_drink value=0}
                                        {/if}
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Food&amp;Drink')}</label>
                                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     aria-valuenow="{$food_drink}" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: {$lstReviewHotel.food_drink}%"></div>
                                            </div>
                                            <span>{$food_drink}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="box_rate_score">
                                        {if $lstReviewHotel.clean}
                                            {math equation='x/10' x=$lstReviewHotel.clean assign=clean}
                                        {else}
                                            {assign var=clean value=0}
                                        {/if}
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Clean')}</label>
                                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="{$clean}"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                     style="width: {$lstReviewHotel.clean}%"></div>
                                            </div>
                                            <span>{$clean}</span>
                                        </div>
                                    </div>
                                    <div class="box_rate_score">
                                        {if $lstReviewHotel.worthy}
                                            {math equation='x/10' x=$lstReviewHotel.worthy assign=worthy}
                                        {else}
                                            {assign var=worthy value=0}
                                        {/if}
                                        <label for="" class="lbl_rate_score">{$core->get_Lang('Worthy')}</label>
                                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="{$worthy}"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                     style="width: {$lstReviewHotel.worthy}%"></div>
                                            </div>
                                            <span>{$worthy}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box_write_review">
                            <div class="clearfix mb20"></div>
                            {if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
                                {$core->getBlock('review_Star')}
                            {else}
                                {$core->getBlock('review_Star_No_Login')}
                            {/if}
                        </div>
                        <div class="owl-carousel list_customer_review_items">
                            {section name=i loop=$lstReview}
                                {assign var=reviews_content value=$clsReviews->getContent($lstReview[i].reviews_id,400,true,$lstReview[i])}
                                <div class="customer_reviews_item review_item">
                                    <div class="customer_intro">
                                        <div class="customer_avatar avatar">{$lstReview[i].fullname|truncate:1:"":true}</div>
                                        <div class="customer_info">
                                            <div class="customer_name">{$lstReview[i].fullname}</div>
                                            <div class="address">{$clsCountry->getTitle($lstReview[i].country_id)}</div>
                                        </div>
                                    </div>
                                    <div class="customer_reviews_text content_review content_review_short">
                                        {$clsISO->truncateWord($lstReview[i].content,30,$btn_view_more)|html_entity_decode}
                                    </div>
                                    <div class="content_review content_review_full" style="display:none">
                                        {$lstReview[i].content|html_entity_decode}
                                    </div>

                                </div>
                            {/section}
                        </div>
                    </div>
                </section>
            </div>
            {$core->getBlock('box_service_ad')}
            {if $lstHotelRelated}
                <section class="sec_relate_box">
                    <div class="container">
                        <div class="headBox">
                            <h2 class="sec_relate_title text-left">{$core->get_Lang('Maybe you are interested')}</h2>
                        </div>
                        <div class="owl-carousel related_slides">
                            {section name=i loop=$lstHotelRelated}
                                {assign var=hotel_id value = $lstHotelRelated[i].hotel_id}
                                {assign var=arrHotel value = $lstHotelRelated[i]}
                                {$clsISO->getBlock('hotelRelateBox',["hotel_id"=>$hotel_id,"arrHotel"=>$arrHotel])}
                            {/section}
                        </div>
                    </div>
                </section>
            {/if}

        </div>
    </div>
</div>

<div class="modal fade" id="mdReview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="box_content"></div>
            </div>
        </div>
    </div>
</div>

{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(".read_more_review").click(function () {
                var item_review_clone = $(this).closest('.review_item').clone();
                $("#mdReview").find('.box_content').html(item_review_clone);
                $("#mdReview").find(".content_review_short,.read_more_review").hide();
                $("#mdReview").find(".content_review_full").show();
                var bg_color = $(this).closest('.review_item').find('.avatar').css('background-color');
                $("#mdReview").find(".avatar").css('background-color', bg_color);
            });
            Fancybox.bind("[data-fancybox]", {});
            $('.list_customer_review_items').owlCarousel({
                loop: false,
                margin: 30,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        margin: 20,
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    992: {
                        items: 3
                    },
                    1025: {
                        items: 3
                    }
                }
            });

            $('.related_slides').owlCarousel({
                loop: false,
                margin: 30,
                nav: false,
                dots: false,
                responsive: {
                    0: {
                        margin: 20,
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    992: {
                        items: 4
                    },
                    1025: {
                        items: 4
                    }
                }
            });
        })
    </script>
{/literal}