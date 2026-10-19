{assign var=title_hotel value=$clsHotel->getTitle($hotel_id,$oneItem)}
{assign var=hotel__id value=$hotel_id}
{assign var=intro_hotel value=$oneItem.intro}
{assign var=bookingPolicy_hotel value=$clsHotel->getHotelBookingPolicy($hotel_id,oneItem)}
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
                    <a itemprop="item" href="{$clsCountryEx->getLink($country_id,'Hotel')}"
                       title="{$core->get_Lang('Hotels')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Hotels')}</span></a>
                    <meta itemprop="position" content="2"/>
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
                    <a itemprop="item" href="{$curl}" title="{$title_hotel}">
                        <span itemprop="name" class="reb">{$title_hotel}</span></a>
                    <meta itemprop="position" content="3"/>
                </li>
            </ol>
        </div>
    </nav>
    <div id="contentPage" class="content hotelPageDetail pd40_0">
        <div class="hotelDetail">
            <div class="container">
                <section class="detail_head">
                    <h1>{$title_hotel} {$clsHotel->getStarNew($hotel_id,$oneItem)}{*{if $clsHotel->getImageStar($oneItem.star_id) != ''}<img src="{$clsHotel->getImageStar($oneItem.star_id)}" alt="{$title_hotel}"/>{/if}*}</h1>
                    <div class="address"><i class="fa fa-map-marker"></i> {$clsHotel->getAddress($hotel_id,$oneItem)}
                    </div>
                    <div class="col_price">
                        <div class="price_hotel">
                            {$clsHotel->getPriceOnPromotion($hotel_id,'detail')}
                            {*<p class="price_number">{$clsISO->priceFormat($min_price)} {$clsISO->getShortRate()}</p>
                            <p class="price_text">1 {$core->get_Lang('night')}/{$number_adult} {$core->get_Lang('adults')}</p>*}
                        </div>
                        <a href="javascript:void(0);" class="btn_book_hotel btn_main btn_scroll_book_hotel"
                           title="{$core->get_Lang('Book now')}">{$core->get_Lang('Book now')}</a>
                    </div>
                </section>
                <section class="detail_photo box_gallery mt30 mb30">
                    <div class="owl-carousel photo-slider">
                        {if $deviceType eq 'phone'}
                            <div class="img_item">
                                <img class="img100" alt="{$title_hotel}"
                                     src="{$clsHotel->getImage($hotel_id,360,240,$oneItem)}"/>
                            </div>
                            {section name=i loop=$listImage}
                                <div class="img_item">
                                    <img class="img100"
                                         alt="{$clsHotelImage->getTitle($listImage[i].hotel_image_id,$listImage[i])}"
                                         src="{$clsHotelImage->getImage($listImage[i].hotel_image_id,360,240,$listImage[i])}"/>
                                </div>
                            {/section}
                        {elseif $deviceType eq 'tablet'}
                            <div class="img_item">
                                <img class="img100" alt="{$title_hotel}"
                                     src="{$clsHotel->getImage($hotel_id,950,403,$oneItem)}"/>
                            </div>
                            {section name=i loop=$listImage}
                                <div class="img_item">
                                    <img class="img100"
                                         alt="{$clsHotelImage->getTitle($listImage[i].hotel_image_id,$listImage[i])}"
                                         src="{$clsHotelImage->getImage($listImage[i].hotel_image_id,950,403,$listImage[i])}"/>
                                </div>
                            {/section}
                        {else}
                            <div class="img_item">
                                <img class="img100" alt="{$title_hotel}"
                                     src="{$clsHotel->getImage($hotel_id,1280,543,$oneItem)}"/>
                            </div>
                            {section name=i loop=$listImage}
                                <div class="img_item">
                                    <img class="img100"
                                         alt="{$clsHotelImage->getTitle($listImage[i].hotel_image_id,$listImage[i])}"
                                         src="{$clsHotelImage->getImage($listImage[i].hotel_image_id,1280,543,$listImage[i])}"/>
                                </div>
                            {/section}
                        {/if}
                    </div>
                </section>
                {$core->getBlock('check_rate_hotel')}
                {if $intro_hotel}
                    <section class="detail_intro hotel_detail_box mb60 phone_mb30">
                        <h2 class="title_hotel_box_detail">Giới thiệu {$title_hotel}</h2>
                        {$intro_hotel}
                    </section>
                {/if}

                <section class="cruise_detail_box room_box special_packages_room" id="blockCheckRate">
                </section>
                {if $lstHotelFacility}
                    <section class="detail_facility hotel_detail_box mb60 phone_mb30">
                        <h2 class="title_hotel_box_detail mb40">{$core->get_Lang('Facilities')}</h2>
                        <div class="facility_UL">
                            <div class="row">
                                {section name=i loop=$lstHotelFacility}
                                    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 _full_width_480 visible facility_item">
                                        {if $clsProperty->getImage($lstHotelFacility[i])}
                                            <span class="icon"><img class="img100"
                                                                    src="{$clsProperty->getImage($lstHotelFacility[i])}"
                                                                    alt="{$clsProperty->getTitle($lstHotelFacility[i])}"/></span>
                                        {/if}{$clsProperty->getTitle($lstHotelFacility[i])}
                                    </div>
                                {/section}
                            </div>
                        </div>
                    </section>
                {/if}
                {assign var=_CheckInRoom value=$clsHotel->getCheckInRoom($hotel_id,$oneItem)}
                {*{assign var=_CheckOutRoom value=$clsHotel->getCheckOutRoom($hotel_id)}*}
                {assign var=_BookingPolicy value=$clsHotel->getBookingPolicy($hotel_id,$oneItem)}
                {assign var=_ChildPolicy value=$clsHotel->getChildPolicy($hotel_id,$oneItem)}
                {assign var=_CancellationPolicy value=$clsHotel->getCancellationPolicy($hotel_id,$oneItem)}
                {assign var=_OtherPolicy value=$clsHotel->getOtherPolicy($hotel_id,$oneItem)}
                {if $_CheckInRoom || $_BookingPolicy || $_ChildPolicy || $_CancellationPolicy || $_OtherPolicy ||$listCustomField}
                    <section class="detail_info hotel_detail_box mb100 phone_mb30">
                        <h2 class="title_hotel_detail_box">Thông tin của {$title_hotel}</h2>
                        {if $deviceType eq 'phone'}
                            <div class="content_hotel_phone">
                                {if $_CheckInRoom || $_CheckOutRoom}
                                    <div class="content_hotel_2">
                                        <h3 class="title_hotel_box_detail mb20">{$core->get_Lang('Thời gian nhận - trả phòng')}</h3>
                                        <div class="tinymce_Content">
                                            <p>Thời gian nhận phòng: {$_CheckInRoom}</p>
                                            <p>Thời gian trả phòng: {$_CheckOutRoom}</p>
                                        </div>
                                    </div>
                                {/if}
                                {if $_BookingPolicy ne ''}
                                    <div class="content_hotel_2">
                                        <h3 class="title_hotel_box_detail mb20">{$core->get_Lang('Chính sách đặt phòng')}</h3>
                                        <div class="tinymce_Content">
                                            {$_BookingPolicy}
                                        </div>
                                    </div>
                                {/if}
                                {if $_ChildPolicy ne ''}
                                    <div class="content_hotel_2">
                                        <h3 class="title_hotel_box_detail mb20">{$core->get_Lang('Chính sách trẻ em và giường')}</h3>
                                        <div class="tinymce_Content">
                                            {$_ChildPolicy}
                                        </div>
                                    </div>
                                {/if}
                                {if $_CancellationPolicy ne ''}
                                    <div class="content_hotel_2">
                                        <h3 class="title_hotel_box_detail mb20">{$core->get_Lang('Hủy đặt phòng/ Trả trước')}</h3>
                                        <div class="tinymce_Content">
                                            {$_CancellationPolicy}
                                        </div>
                                    </div>
                                {/if}
                                {if $_OtherPolicy ne ''}
                                    <div class="content_hotel_2">
                                        <h3 class="title_hotel_box_detail mb20">{$core->get_Lang('Quy định khác')}</h3>
                                        <div class="tinymce_Content">
                                            {$_OtherPolicy}
                                        </div>
                                    </div>
                                {/if}
                                {if $listCustomField}
                                    {section name=i loop=$listCustomField}
                                        {if $listCustomField[i].fieldvalue ne ''}
                                            <div class="content_hotel_2">
                                                <h3 class="title_hotel_box_detail mb20">{$listCustomField[i].fieldname}</h3>
                                                <div class="tinymce_Content">
                                                    {$listCustomField[i].fieldvalue|html_entity_decode}
                                                </div>
                                            </div>
                                        {/if}
                                    {/section}
                                {/if}
                            </div>
                        {else}
                            <div class="content_hotel">
                                <ul id="tabsk" class="clienttabs mtm">
                                    <li class="first"><a href="javascript:void(0);"
                                                         class="current">{$core->get_Lang('Thời gian nhận - trả phòng')}</a>
                                    </li>
                                    {if $_BookingPolicy}
                                        <li><a href="javascript:void(0);">{$core->get_Lang('Chính sách đặt phòng')}</a>
                                        </li>
                                    {/if}
                                    {if $_ChildPolicy}
                                        <li>
                                            <a href="javascript:void(0);">{$core->get_Lang('Chính sách trẻ em và giường')}</a>
                                        </li>
                                    {/if}
                                    {if $_CancellationPolicy}
                                        <li>
                                            <a href="javascript:void(0);">{$core->get_Lang('Hủy đặt phòng/ Trả trước')}</a>
                                        </li>
                                    {/if}
                                    {if $_OtherPolicy}
                                        <li><a href="javascript:void(0);">{$core->get_Lang('Quy định khác')}</a></li>
                                    {/if}
                                </ul>

                                <ul class="tabs_content pl0" id="lstTabs" style="border:0 !important">
                                    <li class="contentTab">
                                        <div class="tinymce_Content">
                                            <p>Thời gian nhận phòng: {$_CheckInRoom}</p>
                                            <p>Thời gian trả phòng: {$_CheckOutRoom}</p>
                                        </div>
                                    </li>
                                    {if $_BookingPolicy}
                                        <li class="contentTab" style="display: none">
                                            <div class="tinymce_Content">
                                                {$_BookingPolicy}
                                            </div>
                                        </li>
                                    {/if}
                                    {if $_ChildPolicy}
                                        <li class="contentTab" style="display: none">
                                            <div class="tinymce_Content">
                                                {$_ChildPolicy}
                                            </div>
                                        </li>
                                    {/if}
                                    {if $_CancellationPolicy}
                                        <li class="contentTab" style="display: none">
                                            <div class="tinymce_Content">
                                                {$_CancellationPolicy}
                                            </div>
                                        </li>
                                    {/if}
                                    {if $_OtherPolicy}
                                        <li class="contentTab" style="display: none">
                                            <div class="tinymce_Content">
                                                {$_OtherPolicy}
                                            </div>
                                        </li>
                                    {/if}
                                </ul>
                            </div>
                        {/if}
                    </section>
                {/if}
                {if $lstHotelRelated}
                    <section id="relatedBox" class="hotelBox mb60 phone_mb0">
                        <div class="headBox">
                            <h2 class="pane-title text-left mt0 mb20">{$core->get_Lang('Related hotels')}</h2>
                        </div>
                        <div class="jcarousel-box owl-carousel" id="jcarousel-related-slides">
                            {section name=i loop=$lstHotelRelated}
                                {assign var=hotel_id value = $lstHotelRelated[i].hotel_id}
                                {assign var=arrHotel value = $lstHotelRelated[i]}
                                {$clsISO->getBlock('hotelbox',["hotel_id"=>$hotel_id,"arrHotel"=>$arrHotel])}
                            {/section}
                        </div>
                    </section>
                {/if}
            </div>
        </div>
    </div>
</div>
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(".btn_scroll_book_hotel").click(function () {
                $('html, body').animate({
                    scrollTop: $(".entry_body_search").offset().top - 50
                }, 600);
            });
        })
    </script>
{/literal}