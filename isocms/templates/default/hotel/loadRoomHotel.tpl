
{foreach from=$lstHotelRoom key=key item=item}
    {assign var=hotel_room_id value=$item.hotel_room_id}
    {assign var=hotel_room_view value=$clsHotelRoom->getStringTitleHotelRoom($item.list_viewroom_id)}
    {assign var=hotel_room_meal value=$clsProperty->getTitle($item.meal_id)}
    {assign var=hotel_room_cancel value=$clsProperty->getTitle($item.cancel_id)}
    {assign var=hotel_room_payment value=$clsProperty->getTitle($item.payment_id)}
    {assign var=hotel_room_highlight value=$item.list_highlight_id}
    {assign var=arr_hotel_room_highlight value=$clsProperty->getArray($hotel_room_highlight)}
    {assign var=hotel_room_size value=$clsHotelRoom->getRoomSize($hotel_room_id)}

    {assign var=hotel_room_image value=$item.room_image}
    {assign var=hotel_room_quantity value=$item.number_val}
    {assign var=hotel_room_facilities value=$item.list_RoomFacilities}
    {assign var=hotel_room_max_adult value=$clsHotelRoom->getNumberAdult($hotel_room_id)}
    {assign var=hotel_room_bed value=$clsHotelRoom->getRoomBed($hotel_room_id)}
    {assign var=total_hotel_room_price value=$item.price * $number_night}
    {assign var=hotel_room_price value=$item.price}
    {if $hotel_room_quantity == 0}
        <div class="hnv_hotel_detail_main_room_item soldout">
            <div class="row">
                <div class="col-sm-12 col-md-5 col-lg-3 col-xl-3">
                    <div class="hnv_hotel_detail_main_room_item_gallery">
                        {if $hotel_room_image}
                            {foreach from=$hotel_room_image key=k_img item=i_img}
                                {if $k_img < 1}
                                    <div class="hnv_grid_item_room hnv_r{$k_img + 1}">
                                        <img src="{$clsHotelRoomImage->getImage($i_img.hotel_image_room_id,204,114)}"
                                             width="204" height="114" alt="Image {$k_img + 1}">
                                    </div>
                                {else}
                                    {break}
                                {/if}
                            {/foreach}
                        {else}
                            <div class="hnv_grid_item_room hnv_r1">
                                <img src="{$clsHotel->getImage($hotel_id,204,114)}"
                                     width="204" height="114" alt="Image 1">
                            </div>
                        {/if}
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-4 col-xl-5">
                    <div class="hnv_hotel_detail_main_room_item_info">
                        <div class="hnv_hotel_detail_main_room_item_title">
                            <h3>{$clsHotelRoom->getTitle($hotel_room_id)}</h3>
                        </div>
                        <div class="hnv_hotel_detail_main_room_item_facilities">
                            <ul class="hnv_hotel_detail_main_room_item_facilities_list">
                                {if $hotel_room_size}
                                    <li class="hnv_hotel_detail_main_room_item_facilities_item">
                                        <i class="fa-light fa-arrow-up-right-and-arrow-down-left-from-center"></i>
                                        {$hotel_room_size} {$core->get_Lang('m2')}
                                    </li>
                                {/if}
                                {if $hotel_room_bed}
                                    <li class="hnv_hotel_detail_main_room_item_facilities_item">
                                        <i class="fa-light fa-bed-front"></i>
                                        {$hotel_room_bed}
                                    </li>
                                {/if}
                                {if $hotel_room_view}
                                    <li class="hnv_hotel_detail_main_room_item_facilities_item">
                                        <i class="fa-light fa-eye"></i>
                                        {$hotel_room_view}
                                    </li>
                                {/if}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-5 col-xl-4 d-flex align-items-center justify-content-center">
                    <div class="hnv_hotel_detail_main_room_item_soldout">
                        <div class="hnv_hotel_detail_main_room_item_soldout_alert">
                            <div class="hnv_hotel_detail_main_room_item_soldout_alert_border">
                                <div class="hnv_hotel_detail_main_room_item_soldout_alert_content">
                                    {$core->get_Lang('Sold out')}
                                </div>
                            </div>
                        </div>
                        <div class="hnv_hotel_detail_main_room_item_soldout_contact">
                            <p>
                                {$core->get_Lang('The room is sold out for the period you selected')}.
                                <a href="{$clsISO->getLink('contact')}" title="{$core->get_Lang('Contact Us')}">
                                    {$core->get_Lang('Contact Us')}
                                </a>
                                {$core->get_Lang('to reserve this favorite room')}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {else}
        <form class="hnv_hotel_detail_main_room_item" {if $key == 0 && $hotel_room_quantity > 0} style="border: 1px solid var(--success-color-1);" {/if}>
            {if $key == 0 && $hotel_room_quantity > 0}
                <div class="hnv_hotel_detail_main_room_item_min_price">
                    <i class="fa-solid fa-star"></i> {$core->get_Lang('Lowest price available')}!
                </div>
            {/if}
            <input type="hidden" name="hotel_room_id" value="{$hotel_room_id}">
            <input type="hidden" name="hotel_id" value="{$hotel_id}">
            <input type="hidden" name="check_in" value="{$check_in}">
            <input type="hidden" name="check_out" value="{$check_out}">
            <input type="hidden" name="number_adult" value="{$number_adults}">
            <input type="hidden" name="number_child" value="{$number_child}">
            <input type="hidden" name="room_price" value="{$item.price}">
            <input type="hidden" name="totalprice" value="{$item.totalPrice}">
            <input type="hidden" name="number_night" value="{$number_night}">
            <div class="row">
                <div class="col-sm-12 col-md-5 col-lg-3 col-xl-3">
                    <div class="hnv_hotel_detail_main_room_item_gallery">
                        <div class="hnv_grid_container_room">
                            {if $hotel_room_image}
                                {assign var=hotel_room_image_remaining value=count($hotel_room_image) - 3}
                                {foreach from=$hotel_room_image key=k_img item=i_img}
                                    {if $k_img <= 2}
                                        {if $k_img == 0}
                                            <div class="hnv_grid_item_room hnv_r{$k_img + 1}">
                                                <img src="{$clsHotelRoomImage->getImage($i_img.hotel_image_room_id,204,114)}"
                                                     width="204" height="114" alt="Image {$k_img + 1}">
                                            </div>
                                        {else}
                                            <div class="hnv_grid_item_room hnv_r{$k_img + 1}">
                                                <img src="{$clsHotelRoomImage->getImage($i_img.hotel_image_room_id,100,55)}"
                                                     width="100" height="55" alt="Image {$k_img + 1}">
                                                {if $hotel_room_image_remaining && $k_img == 2}
                                                    <div class="hnv_grid_item_room_remaining">
                                                        + {$hotel_room_image_remaining} {$core->get_Lang('images')}
                                                    </div>
                                                {/if}
                                            </div>
                                        {/if}
                                    {else}
                                        {break}
                                    {/if}
                                {/foreach}
                            {else}
                                <div class="hnv_grid_item_room hnv_r1">
                                    <img src="{$clsHotel->getImage($hotel_id,204,114)}"
                                         width="204" height="114" alt="Image 1">
                                </div>
                            {/if}
                        </div>
                        <div class="hnv_hotel_detail_main_room_item_detail">
                            <!-- ButtonRoomDetailsModal -->
                            <a href="javascript:void(0);"
                               class="hnv_hotel_detail_main_room_item_detail_button" data-bs-toggle="modal"
                               data-bs-target="#RoomDetailModal_{$key}">
                                <i class="fa-light fa-circle-plus"></i> {$core->get_Lang('Room details')}
                            </a>
                            <!-- RoomDetailsModal -->
                            <div class="modal fade" id="RoomDetailModal_{$key}" tabindex="-1"
                                 aria-labelledby="RoomDetailModal1Label" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        {if $deviceType eq 'phone'}
                                            <div class="modal-header">
                                                <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                        {/if}
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-7">
                                                    <div class="hnv_hotel_detail_main_room_item_detail_gallery">
                                                        <div
                                                                class="fotorama"
                                                                data-width="612"
                                                                data-ratio="612/458"
                                                                data-max-width="100%"
                                                                data-nav="thumbs"
                                                                data-thumbmargin="10"
                                                                data-thumbwidth="91"
                                                                data-thumbheight="68"
                                                                data-allowfullscreen="native"
                                                                data-navposition="bottom"
                                                                data-keyboard="true"
                                                                data-loop="false"
                                                                data-autoplay="false"
                                                                data-stopautoplayontouch="true"
                                                                data-lazy="true"
                                                        >
                                                            {if $hotel_room_image}
                                                                {foreach from=$hotel_room_image key=k_imgmodal item=i_imgmodal}
                                                                    <a href="{$clsHotelRoomImage->getImage($i_imgmodal.hotel_image_room_id,612,458)}"
                                                                       data-thumb="{$clsHotelRoomImage->getImage($i_imgmodal.hotel_image_room_id,91,68)}"></a>
                                                                {/foreach}
                                                            {else}
                                                                <img src="{$clsHotel->getImage($hotel_id,612,458)}"
                                                                     width="204" height="114" alt="Image 1">
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-5 d-flex flex-column justify-content-between">
                                                    <div class="hnv_hotel_detail_main_room_item_detail_info">
                                                        <div class="hnv_hotel_detail_main_room_item_detail_info_title">
                                                            <h3>{$clsHotelRoom->getTitle($hotel_room_id)}</h3>
                                                        </div>
                                                        <div class="hnv_hotel_detail_main_room_item_detail_info_basic">
                                                            <ul class="hnv_hotel_detail_main_room_item_detail_info_basic_list">
                                                                {if $hotel_room_size}
                                                                    <li class="hnv_hotel_detail_main_room_item_detail_info_basic_item">
                                                                        <i class="fa-light fa-arrow-up-right-and-arrow-down-left-from-center"></i>
                                                                        {$hotel_room_size} {$core->get_Lang('m2')}
                                                                    </li>
                                                                {/if}
                                                                {if $hotel_room_bed}
                                                                    <li class="hnv_hotel_detail_main_room_item_detail_info_basic_item">
                                                                        <i class="fa-light fa-bed-front"></i>
                                                                        {$hotel_room_bed}
                                                                    </li>
                                                                {/if}
                                                                {if $hotel_room_view}
                                                                    <li class="hnv_hotel_detail_main_room_item_detail_info_basic_item">
                                                                        <i class="fa-light fa-eye"></i>
                                                                        {$hotel_room_view}
                                                                    </li>
                                                                {/if}
                                                            </ul>
                                                        </div>
                                                        <div class="hnv_hotel_detail_main_room_item_detail_info_included">
                                                            <ul class="hnv_hotel_detail_main_room_item_detail_info_included_list">
                                                                {if $hotel_room_meal}
                                                                    <li class="hnv_hotel_detail_main_room_item_detail_info_included_item green">
                                                                        <i class="fa-light fa-check"></i>
                                                                        {$hotel_room_meal}
                                                                    </li>
                                                                {/if}
                                                                {if $hotel_room_cancel}
                                                                    <li class="hnv_hotel_detail_main_room_item_detail_info_included_item green">
                                                                        <i class="fa-light fa-check"></i>
                                                                        {$hotel_room_cancel}
                                                                    </li>
                                                                {/if}
                                                                {if $hotel_room_payment}
                                                                    <li class="hnv_hotel_detail_main_room_item_detail_info_included_item green">
                                                                        <i class="fa-light fa-check"></i>
                                                                        {$hotel_room_payment}
                                                                    </li>
                                                                {/if}
                                                                {if $arr_hotel_room_highlight}
                                                                    {foreach from=$arr_hotel_room_highlight key=k item=i}
                                                                        {assign var=hotel_room_highlight_title value=$clsProperty->getTitle($i)}
                                                                        <li class="hnv_hotel_detail_main_room_item_detail_info_included_item grey">
                                                                            <i class="fa-light fa-check"></i>
                                                                            <span>{$hotel_room_highlight_title}</span>
                                                                        </li>
                                                                    {/foreach}
                                                                {/if}
                                                            </ul>
                                                        </div>
                                                        {if $hotel_room_facilities}
                                                            <div class="hnv_hotel_detail_main_room_item_detail_info_facilities">
                                                                <h4>{$core->get_Lang('Facilities')}</h4>
                                                                <div class="hnv_hotel_detail_main_room_item_detail_info_facilities_list">
                                                                    <div class="row">
                                                                        {assign var=arr_hotel_room_facilities value=$clsProperty->getArray($hotel_room_facilities)}
                                                                        {if !empty(arr_hotel_room_facilities)}
                                                                            {foreach from=$arr_hotel_room_facilities key=k_facilities item=i_facilities}
                                                                                {assign var=hotel_room_facilities_title value=$clsProperty->getTitle($i_facilities)}
                                                                                {if $k_facilities % 2 == 0}
                                                                                    <div class="col-sm-12 col-md-6">
                                                                                        <div class="hnv_hotel_detail_main_room_item_detail_info_facilities_item">
                                                                                            <i class="fa-light fa-check"></i>
                                                                                            {$hotel_room_facilities_title}
                                                                                        </div>
                                                                                    </div>
                                                                                {else}
                                                                                    <div class="col-sm-12 col-md-6">
                                                                                        <div class="hnv_hotel_detail_main_room_item_detail_info_facilities_item">
                                                                                            <i class="fa-light fa-check"></i>
                                                                                            {$hotel_room_facilities_title}
                                                                                        </div>
                                                                                    </div>
                                                                                {/if}
                                                                            {/foreach}
                                                                        {/if}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {/if}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-4 col-xl-5">
                    <div class="hnv_hotel_detail_main_room_item_info">
                        <div class="hnv_hotel_detail_main_room_item_title">
                            <h3>{$clsHotelRoom->getTitle($hotel_room_id)}</h3>
                        </div>
                        <div class="hnv_hotel_detail_main_room_item_facilities">
                            <ul class="hnv_hotel_detail_main_room_item_facilities_list">
                                {if !empty($hotel_room_size)}
                                    <li class="hnv_hotel_detail_main_room_item_facilities_item">
                                        <i class="fa-light fa-arrow-up-right-and-arrow-down-left-from-center"></i>
                                        {$hotel_room_size} {$core->get_Lang('m2')}
                                    </li>
                                {/if}
                                {if !empty($hotel_room_bed)}
                                    <li class="hnv_hotel_detail_main_room_item_facilities_item">
                                        <i class="fa-light fa-bed-front"></i>
                                        {$hotel_room_bed}
                                    </li>
                                {/if}
                                {if !empty($hotel_room_view)}
                                    <li class="hnv_hotel_detail_main_room_item_facilities_item">
                                        <i class="fa-light fa-eye"></i>
                                        {$hotel_room_view}
                                    </li>
                                {/if}
                            </ul>
                        </div>
                        <div class="hnv_hotel_detail_main_room_item_includes">
                            <ul class="hnv_hotel_detail_main_room_item_includes_list">
                                {if !empty($hotel_room_meal)}
                                    <li class="hnv_hotel_detail_main_room_item_includes_green">
                                        <i class="fa-light fa-check"></i>
                                        {$hotel_room_meal}
                                    </li>
                                {/if}
                                {if !empty($hotel_room_cancel)}
                                    <li class="hnv_hotel_detail_main_room_item_includes_green">
                                        <i class="fa-light fa-check"></i>
                                        {$hotel_room_cancel}
                                    </li>
                                {/if}
                                {if !empty($hotel_room_payment)}
                                    <li class="hnv_hotel_detail_main_room_item_includes_green">
                                        <i class="fa-light fa-check"></i>
                                        {$hotel_room_payment}
                                    </li>
                                {/if}
                                {if !empty($arr_hotel_room_highlight)}
                                    {foreach from=$arr_hotel_room_highlight key=k item=j}
                                        {assign var=hotel_room_highlight_title value=$clsProperty->getTitle($j)}
                                        <li class="hnv_hotel_detail_main_room_item_includes_grey">
                                            <i class="fa-light fa-check"></i>
                                            <span>{$hotel_room_highlight_title}</span>
                                        </li>
                                    {/foreach}
                                {/if}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-5 col-xl-4">
                    <table class="hnv_hotel_detail_main_room_item_table">
                        <thead>
                            <tr>
                                <th style="width: 24%; border-bottom: unset; border-top: unset;" class="text-center">{$core->get_Lang('Guest')}</th>
                                <th style="width: 22%; border-bottom: unset; border-top: unset;" class="text-center">{$core->get_Lang('Room')}</th>
                                <th style="border-bottom: unset; border-right: unset; border-top: unset;">{$core->get_Lang('Total price')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="hnv_hotel_detail_main_room_item_table_guest">
                                    {if $item.count_people_room < 3}
                                        {section name=guest loop=$item.count_people_room}
                                            <i class="fa-duotone fa-light fa-user"></i>
                                        {/section}
                                    {else}
                                        <p><span>{$item.count_people_room}</span> x <i
                                                    class="fa-duotone fa-light fa-user"></i></p>
                                    {/if}
                                    <p class="iso_number_people">
                                        <i class="fa-duotone fa-light fa-circle-info"></i>
                                        <span class="iso_number_people_span">
                                        {$item.number_adult} x {$core->get_Lang('Adult(s)')}
                                        {if $item.number_children}
                                            , {$item.number_children} x {$core->get_Lang('Child')}
                                        {/if}
                                        </span>
                                    </p>
                                </td>
                                <td class="hnv_hotel_detail_main_room_item_table_room">
                                    <input type="text" name="number_rooms" value="{$item.number_rooms}"
                                           class="iso_rooms_input" readonly>
                                </td>
                                <td class="hnv_hotel_detail_main_room_item_table_total">
                                    <div class="hnv_hotel_detail_main_room_item_table_total_price">
                                        <span> {$clsHotel->renderTextLoadPricePromotion($hotel_id, $total_hotel_room_price)}</span>
                                    </div>
                                    <div class="hnv_hotel_detail_main_room_item_table_total_includes">
                                        <span>{$number_night}</span> {$core->get_Lang('nights includes taxes & fees')}
                                    </div>
                                    <div class="hnv_hotel_detail_main_room_item_table_total_room_per_night">
                                        {$core->get_Lang('Price per room/night is')}
                                        <span>
                                            {$clsHotel->renderTextLoadPricePromotion($hotel_id, $hotel_room_price, 'is')}
                                        </span>
                                    </div>
                                    <a href="javascript:void(0);" title="{$core->get_Lang('Book now')}"
                                       class="hnv_hotel_detail_main_room_item_table_book iso_btn_book_rom">
                                        {$core->get_Lang('Book now')}
                                    </a>
                                    <div class="hnv_hotel_detail_main_room_item_table_total_note">
                                        <ul class="hnv_hotel_detail_main_room_item_table_total_note_list">
                                            <li class="hnv_hotel_detail_main_room_item_table_total_note_item">
                                                {$core->get_Lang('Limited quantity')}
                                            </li>
                                            <li class="hnv_hotel_detail_main_room_item_table_total_note_item">
                                                {$core->get_Lang('Confirmation is immediate')}
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    {/if}
{/foreach}  