{if $cartSessionVoucher}
    {foreach from=$cartSessionVoucher key=_key item=item name=item}
        {assign var=voucher_id value=$item.voucher_id}
        {if $voucher_id}
            {assign var=title_package value=$clsVoucher->getTitle($item.voucher_id)}
            {assign var=link_package value=$clsVoucher->getLink($item.voucher_id)}
            {assign var=price_package value=$clsVoucher->getPrice($item.voucher_id)}
            {assign var=price_voucher value=$clsVoucher->getPricePromotion2($item.voucher_id)}
            {assign var=priceO_voucher value=$clsVoucher->getPricePromotionO($item.voucher_id)}
            {assign var=priceO_package value=$clsVoucher->getPriceOrigin($item.voucher_id)}
            {assign var=img_voucher value=$clsVoucher->getImage($item.voucher_id,112,112)}
            {assign var=link_voucher value=$clsVoucher->getLink($item.voucher_id)}
            {assign var=priceOld value=$clsVoucher->getPricePromotionO($voucher_id)}
            {assign var=numberVoucher value=$item.number_voucher}
            {math assign="PriceVoucher" equation="x * y" x=$priceOld y=$numberVoucher}

            {assign var=getPromotion value=$clsISO->getPromotion($voucher_id,'voucher',$time_now,$time_now,'get_infomation')}
            {if $item.discount_value}
                {if $item.discount_type eq '1'}
                    {math assign='pricePromotion' equation="x - y" x=$priceOld y=$item.discount_value}
                    {assign var=priceDiscount value=$item.discount_value}
                {else}
                    {math assign='pricePromotion' equation="x*(100 - y)/100" x=$priceOld y=$item.discount_value}
                    {math assign='priceDiscount' equation="x*y/100" x=$priceOld y=$item.discount_value}
                {/if}
                {math assign="TotalPriceVoucher" equation="x * y" x=$pricePromotion y=$numberVoucher}
            {else}
                {assign var=TotalPriceVoucher value=$PriceVoucher}
            {/if}
            <div class="hnv_cart_item hnv_cart_item_cruise">
                <div class="hnv_cart_item_top">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="hnv_cart_item_image">
                                <div class="title_package" title="{$title_package}">
                                    <img src="{$img_voucher}" width="112" height="112" alt="{$title_package}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-9">
                            <div class="hnv_cart_item_info">
                                <div class="hnv_cart_item_info_title d-flex align-items-center justify-content-between">
                                    <h3>
                                        {$title_package}
                                    </h3>
                                    <div class="iso_hnv_cart_edit">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="hnv_cart_item_info_detail">
                                    {*<div class="hnv_cart_item_info_detail_date">
                                        <i class="fa-light fa-calendar"></i>
                                        Wed, Dec 4, 2024
                                    </div>
                                    <div class="hnv_cart_item_info_detail_customer">
                                        <i class="fa-light fa-calendars"></i>
                                        2 Combo 2N1D Villa 2PN NovaWorld Phan Thiet + Play in 5 parks (1 day) + Breakfast +
                                        Shuttle bus from Ho Chi Minh City
                                    </div>
                                    <div class="hnv_cart_item_info_detail_policy">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="hnv_cart_item_info_detail_policy_left">
                                                    <ul class="hnv_cart_item_info_detail_policy_list">
                                                        <li class="hnv_cart_item_info_detail_policy_item">
                                                            <i class="fa-light fa-circle-xmark"></i>
                                                            <span>{$core->get_Lang('Non-refundable')}</span>
                                                        </li>
                                                        <li class="hnv_cart_item_info_detail_policy_item hnv_cart_item_info_detail_policy_item_date">
                                                            <i class="fa-light fa-calendar-check"></i>
                                                            <span>{$core->get_Lang('Date changed')}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>*}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iso_information_booking">
                    {$clsISO->getBlock('iso_primary_traveler', ["type_block"=>"voucher", "_key"=>$_key])}
                    <div class="iso_information_tour_item">
                        <div class="title">
                            {$core->get_Lang('Special requirements')}
                        </div>
                        <div class="iso_special_requirements">
                            <div class="iso_item_body_tour iso_input_box">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="iso_input_box_item_area">
                                            <textarea name="voucher_special_{$_key}" rows="3" placeholder="{$core->get_Lang('To type the request to us. E.g. dietary needs, accessibility')}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="iso_button d-flex flex-column">
                                    <button class="iso_cart_button" id="btn_voucher_{$_key}">
                                        {$core->get_Lang('Next')}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}
    {/foreach}
{/if}