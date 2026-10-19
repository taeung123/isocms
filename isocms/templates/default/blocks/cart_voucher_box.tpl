{*{if $profile_id == 1672}
{$clsISO->dump($cartSessionVoucher)}
{/if}*}
{if $cartSessionVoucher}
    <label class="titleBoxContent">{$core->get_Lang('Vouchers')}</label>
    {foreach from=$cartSessionVoucher item=item name=item}

        {assign var=voucher_id value=$item.voucher_id}
        {if $voucher_id}
            {assign var=title_package value=$clsVoucher->getTitle($item.voucher_id)}
            {assign var=link_package value=$clsVoucher->getLink($item.voucher_id)}
            {assign var=price_package value=$clsVoucher->getPrice($item.voucher_id)}
            {assign var=price_voucher value=$clsVoucher->getPricePromotion2($item.voucher_id)}
            {assign var=priceO_voucher value=$clsVoucher->getPricePromotionO($item.voucher_id)}
            {assign var=priceO_package value=$clsVoucher->getPriceOrigin($item.voucher_id)}
            {assign var=img_voucher value=$clsVoucher->getImage($item.voucher_id)}
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
                        <div class="col-sm-3 col-xxl-2 col-3">
                            <div class="hnv_cart_item_image">
                                <a href="{$link_voucher}" title="{$title_package}">
                                    <img src="{$img_voucher}" width="auto" height="auto" alt="{$title_package}">
                                </a>
                                {if $item.discount_value}
                                <div class="iso_cart_promotion">
                                    {if $item.discount_type == 2} 
                                        <span class="promotion">-{$item.discount_value}%</span>
                                    {else} 
                                        {if $_LANG_ID == 'vn'}
                                            <span class="promotion">-{$item.discount_value}{$clsISO->getShortRate()}</span>
                                        {else}
                                            <span class="promotion">-{$clsISO->getShortRate()}{$item.discount_value}</span>
                                        {/if}
                                    {/if}
                                </div>
                                {/if}
                            </div>
                        </div>
                        <div class="col-sm-9 col-xxl-10 col-9">
                            <div class="hnv_cart_item_info">
                                <div class="hnv_cart_item_info_title">
                                    <h3>
                                        <a href="{$link_voucher}" title="{$title_package}">
                                            {$title_package}
                                        </a>
                                    </h3>
                                </div>
                                <div class="hnv_cart_item_info_detail d-none d-md-flex">
                                    <div class="hnv_cart_item_info_detail_date">
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
                                            <div class="col-sm-12 col-md-8">
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
                                            {if $_LANG_ID == 'vn'} 
                                            <div class="col-sm-12 col-md-4">
                                                <div class="hnv_cart_item_info_detail_policy_right">
                                                    <div class="hnv_cart_item_info_detail_policy_price">
                                                        <span>{$clsISO->formatPrice($TotalPriceVoucher)}</span> {$clsISO->getShortRate()}
                                                    </div>
                                                    <a href="javascript:void(0);"
                                                       class="hnv_cart_item_info_detail_policy_adult">
                                                        {$core->get_Lang('Price details')}
                                                        <div class="hnv_cart_item_info_detail_policy_price_tooltip">
                                                            <ul class="hnv_cart_item_info_detail_policy_price_tooltip_list">
                                                                <li class="hnv_cart_item_info_detail_policy_price_tooltip_item">
                                                                    {$item.number_voucher} {$core->get_Lang('ticket')} x {$price_voucher} {$clsISO->getShortRate()} 
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            {else} 
                                            <div class="col-sm-12 col-md-4">
                                                <div class="hnv_cart_item_info_detail_policy_right">
                                                    <div class="hnv_cart_item_info_detail_policy_price">
                                                        {$clsISO->getShortRate()}<span>{$clsISO->formatPrice($TotalPriceVoucher)}</span> 
                                                    </div>
                                                    <a href="javascript:void(0);"
                                                       class="hnv_cart_item_info_detail_policy_adult">
                                                        {$core->get_Lang('Price details')}
                                                        <div class="hnv_cart_item_info_detail_policy_price_tooltip">
                                                            <ul class="hnv_cart_item_info_detail_policy_price_tooltip_list">
                                                                <li class="hnv_cart_item_info_detail_policy_price_tooltip_item">
                                                                    {$item.number_voucher} {$core->get_Lang('ticket')} x {$clsISO->getShortRate()}{$price_voucher} 
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hnv_cart_item_info_detail d-sm-flex d-md-none mt-3">
                        <div class="hnv_cart_item_info_detail_date">
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
                                <div class="col-sm-12 col-md-8">
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
                        </div>
                    </div>
                </div>
                <div class="hnv_cart_item_bottom">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 d-flex align-items-center">
                            <div class="hnv_cart_item_action">
                                <ul class="hnv_cart_item_action_list">
                                    <li class="hnv_cart_item_action_item">
                                        <a href="{$link_voucher}">
                                            <i class="fa-light fa-pen-to-square"></i>
                                            {$core->get_Lang('Edit')}
                                        </a>
                                    </li>
                                    <li class="hnv_cart_item_action_item">
                                        <a href="javascript:void(0);" class="remove ajvCart" data-tp="DEL_VOUCHER" data-table_id="{$item.voucher_id}">
                                            <i class="fa-light fa-trash-can"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="hnv_cart_item_total">
                                <div class="hnv_cart_item_total_price">
                                    {if $_LANG_ID == 'vn'} 
                                    <span>{$clsISO->formatPrice($TotalPriceVoucher)}</span> {$clsISO->getShortRate()}
                                    {else} 
                                    {$clsISO->getShortRate()}<span>{$clsISO->formatPrice($TotalPriceVoucher)}</span> 
                                    {/if}
                                </div>
                                <div class="hnv_cart_item_total_include">
                                    {$core->get_Lang('All taxes and fees included')}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}
    {/foreach}
{/if}