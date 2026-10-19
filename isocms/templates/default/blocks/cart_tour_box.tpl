{if $cartSessionService}
    <label class="titleBoxContent">{$core->get_Lang('Tours')}</label>
    {foreach from=$cartSessionService item=item name=item}
        {assign var=tour_id value=$item.tour_id_z}
        {if $tour_id}
            {assign var=departure_date value=$clsISO->getStrToTime($item.check_in_book_z)}
            {assign var=end_date value=$clsTour->getEndDate($departure_date,$tour_id)}
            {assign var=title_package value=$clsTour->getTitle($item.tour_id_z)}
            {assign var=link_package value=$clsTour->getLink($item.tour_id_z)}
            {assign var=image_package value=$clsTour->getImage($item.tour_id_z)}
            {assign var=adult_visitor value="national_visitor"|cat:$adult_type_id}
            {assign var=child_visitor value="national_visitor"|cat:$child_type_id}
            {assign var=infant_visitor value="national_visitor"|cat:$infant_type_id}
            {assign var=adult_price value="people_price"|cat:$adult_type_id}
            {assign var=child_price value="people_price"|cat:$child_type_id}
            {assign var=infant_price value="people_price"|cat:$infant_type_id}

            {assign var=number_adult value=$item.number_adults_z|default:0}
            {assign var=number_child value=$item.number_child_z|default:0}
            {assign var=number_infant value=$item.number_infants_z|default:0}

            {assign var=price_adult value=$item.total_price_adults|default:0}
            {assign var=price_child value=$item.total_price_child|default:0}
            {assign var=price_infant value=$item.total_price_infants|default:0}

            {*
             * Tổng tiền theo số lượng từng loại khách.
             * Không cộng giá dịch vụ add-on tại vị trí giá chi tiết của tour.
             *}
            {assign var=people_total value=$price_adult+$price_child+$price_infant}

            {assign var=number_of_guests value=$number_adult+$number_child}


            {assign var=row_traveler value=2}
            {assign var=parent_id value=$item.parent_id|default:0}
            {if $parent_id}
                {assign var="arr_tour_parent" value=$item.arr_tour_parent}
                {assign var=title_tour value=$arr_tour_parent.title}
                {assign var=link_tour value=$clsTour->getLink($parent_id, $arr_tour_parent.slug)}
            {/if}
            <div class="hnv_cart_item hnv_cart_item_tour">
                <div class="hnv_cart_item_top">
                    <div class="row">
                        <div class="col-sm-3 col-xxl-2 col-3">
                            <div class="hnv_cart_item_image">
                                <a href="{$link_package}" title="{$title_package}">
                                    <img src="{$image_package}" width="auto" height="auto" alt="{$title_package}">
                                </a>
                                {if isset($item.promotion_z) && $item.promotion_z > 0}
                                <div class="iso_cart_promotion">
                                    {if $item.discount_type == 2} 
                                        <span class="promotion">{$item.promotion_z} %</span>
                                    {else} 
                                        {if $_LANG_ID == 'vn'}
                                            <span class="promotion">{$item.promotion_z} {$clsISO->getShortRate()}</span>
                                        {else}
                                            <span class="promotion">{$clsISO->getShortRate()} {$item.promotion_z}</span>
                                            
                                        {/if}
                                    {/if}
                                    <span class="text">{$core->get_Lang('Discount')}</span>
                                </div>
                                {/if}
                            </div>
                        </div>
                        <div class="col-sm-9 col-xxl-10 col-9">
                            <div class="hnv_cart_item_info">
                                <div class="hnv_cart_item_info_title">
                                    {if $parent_id}
                                        <h3>
                                            <a href="{$link_tour}" title="{$title_tour}">
                                                {$title_tour}
                                            </a>
                                        </h3>
                                        <div class="mb-3">{$title_package}</div>
                                    {else}
                                    <h3>
                                        <a href="{$link_package}" title="{$title_package}">
                                            {$title_package}
                                        </a>
                                    </h3>
                                    {/if}
                                </div>
                                <div class="hnv_cart_item_info_detail d-none d-md-flex">
                                    <div class="hnv_cart_item_info_detail_date">
                                        <i class="fa-light fa-calendar"></i>
                                        <label>{$clsISO->converTimeToText5($departure_date)}</label>
                                        <i class="fa-solid fa-circle-small"></i>
                                        {$clsTour->getLTripDuration($tour_id)}
                                    </div>
                                    <div class="hnv_cart_item_info_detail_customer">
                                        <i class="fa-light fa-user"></i>
                                        {$number_adult} {$core->get_Lang('Adults')}{if $number_child}, {$number_child} {$core->get_Lang('Children')}{/if}{if $number_infant}, {$number_infant} {$core->get_Lang('Infants')}{/if}
                                    </div>

                                </div>
                                {if !empty($item.number_addon)}
                                    <div class="hnv_cart_line d-none d-sm-none d-md-block"></div>
                                    <div class="hnv_cart_item_info_addon d-none d-sm-none d-md-block">
                                        <ul class="hnv_cart_item_info_addon_list">
                                            {foreach from=$item.number_addon key=k item=v}
                                                <li class="hnv_cart_item_info_addon_item" >
                                                    <div class="hnv_cart_item_info_addon_item_left">
                                                        <span>{$v}</span> x {$clsAddOnService->getTitle($k)}
                                                    </div>
                                                    {assign var=addon_item value=null}
                                                    {if isset($item.addon_items[$k])}
                                                        {assign var=addon_item value=$item.addon_items[$k]}
                                                    {/if}
                                                    {if $addon_item}
                                                        {assign var=price_service value=$addon_item.line_total|default:0}
                                                        {assign var=unit_price_service value=$addon_item.unit_price|default:0}
                                                        {assign var=extra value=$addon_item.extra|default:0}
                                                    {else}
                                                        {assign var=extra value=$clsAddOnService->getOneField("extra", $k)}
                                                        {assign var=unit_price_service value=$clsAddOnService->getStrPrice($k)}
                                                        {assign var=price_service value=($extra == 1)
                                                            ? $unit_price_service
                                                            : $v*$unit_price_service}
                                                    {/if}
                                                    <div class="hnv_cart_item_info_addon_item_right">
                                                        <span>
                                                            {$clsISO->getShortRate()}
                                                            {$clsISO->formatPrice($price_service)}
                                                        </span>

                                                        <a href="javascript:void(0);" class="hnv_cart_item_info_addon_item_right_detail">
                                                            <i class="fa-light fa-circle-info"></i>
                                                            <div class="hnv_cart_item_info_addon_item_right_tooltip">
                                                                <div class="iso_cart_tooltip">
                                                                    {$v} {$clsAddOnService->getTitle($k)}
                                                                    {if $extra == 1}:{else}x{/if}
                                                                    {$clsISO->getShortRate()}
                                                                    {$clsISO->formatPrice($unit_price_service)}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                    <div class="hnv_cart_item_info_detail d-sm-flex d-md-none mt-3">
                        <div class="hnv_cart_item_info_detail_date">
                            <i class="fa-light fa-calendar"></i>
                            <label>{$clsISO->converTimeToText5($departure_date)}</label>
                            <i class="fa-solid fa-circle-small"></i>
                            {$clsTour->getLTripDuration($tour_id)}
                        </div>
                        <div class="hnv_cart_item_info_detail_customer">
                            <i class="fa-light fa-user"></i>
                            {$number_adult} {$core->get_Lang('Adults')}{if $number_child}, {$number_child} {$core->get_Lang('Children')}{/if}{if $number_infant}, {$number_infant} {$core->get_Lang('Infants')}{/if}
                        </div>
                        <div class="hnv_cart_item_info_detail_policy">
                            <div class="row">
                                <div class="col-sm-12 col-md-8">
                                    <div class="hnv_cart_item_info_detail_policy_left">
                                        <ul class="hnv_cart_item_info_detail_policy_list">
                                            {if isset($item.price_deposit) && $item.price_deposit > 0}
                                                <li class="hnv_cart_item_info_detail_policy_item hnv_cart_item_info_detail_policy_item_date">
                                                    <i class="fa-light fa-circle-xmark"></i>
                                                    <span>{$core->get_Lang('Refundable')}</span>
                                                </li>
                                            {/if}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {if !empty($item.number_addon)}
                        <div class="hnv_cart_line d-sm-block d-md-none"></div>
                        <div class="hnv_cart_item_info_addon d-sm-block d-md-none">
                            <ul class="hnv_cart_item_info_addon_list">
                                {foreach from=$item.number_addon key=k item=v}
                                    <li class="hnv_cart_item_info_addon_item">
                                        <div class="hnv_cart_item_info_addon_item_left">
                                            <span>{$v}</span> x {$clsAddOnService->getTitle($k)}
                                        </div>

                                        {assign var=addon_item value=null}

                                        {if isset($item.addon_items[$k])}
                                            {assign var=addon_item value=$item.addon_items[$k]}
                                        {/if}

                                        {if $addon_item}
                                            {assign var=price_service value=$addon_item.line_total|default:0}
                                            {assign var=unit_price_service value=$addon_item.unit_price|default:0}
                                            {assign var=extra value=$addon_item.extra|default:0}
                                        {else}
                                            {assign var=extra value=$clsAddOnService->getOneField("extra", $k)}
                                            {assign var=unit_price_service value=$clsAddOnService->getStrPrice($k)}
                                            {assign var=price_service value=($extra == 1)
                                                ? $unit_price_service
                                                : $v*$unit_price_service}
                                        {/if}

                                        <div class="hnv_cart_item_info_addon_item_right">
                                            <span>{$clsISO->getShortRate()}{$clsISO->formatPrice($price_service)}</span>
                                            <a href="javascript:void(0);" class="hnv_cart_item_info_addon_item_right_detail">
                                                <i class="fa-light fa-circle-info"></i>
                                                <div class="hnv_cart_item_info_addon_item_right_tooltip">
                                                    <div class="iso_cart_tooltip">
                                                        {$v} {$clsAddOnService->getTitle($k)}
                                                        {if $extra == 1}:{else}x{/if}
                                                        {$clsISO->getShortRate()}{$clsISO->formatPrice($unit_price_service)}
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    {/if}
                </div>
                <div class="hnv_cart_item_bottom">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 d-flex align-items-center mobile_cart_item">
                            <div class="hnv_cart_item_action">
                                <ul class="hnv_cart_item_action_list">
                                    <li class="hnv_cart_item_action_item">
                                        <a class="edit" href="{$clsTour->getLink($item.tour_id_z)}"
                                        title="{$core->get_Lang('Edit')}">
                                            <i class="fa-light fa-pen-to-square"></i>
                                            {$core->get_Lang('Edit')}
                                        </a>
                                    </li>
                                    <li class="hnv_cart_item_action_item">
                                        <a class="remove ajvCart" data-tp="DEL_PACKAGE" data-table_id="{if $parent_id neq 0}{$parent_id}{else}{$item.tour_id_z}{/if}"
                                        href="javascript:void(0);"
                                        title="{$core->get_Lang('Delete')}">
                                            <i class="fa-light fa-trash-can"></i>
                                        </a>
                                    </li>
                                    {if isset($item.price_deposit) && $item.price_deposit > 0}
                                    <li class="hnv_cart_item_action_item d-none d-sm-none d-md-block">
                                        <label>
                                            {$core->get_Lang('Deposit')} {if $item.deposit}{$item.deposit}{else}0{/if}% ({$clsISO->getShortRate()}{$clsISO->formatPrice($item.price_deposit)})
                                        </label>
                                    </li>
                                    {/if}
                                </ul>
                            </div>
                            <div class="hnv_cart_item_total_price d-sm-block d-md-none">
                                <span>{$clsISO->getShortRate()}{$clsISO->formatPrice($item.total_price_z)}</span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="hnv_cart_item_total">
                                <div class="hnv_cart_item_total_price d-none d-sm-none d-md-block">
                                    <span>{$clsISO->getShortRate()}{$clsISO->formatPrice($item.total_price_z)}</span>
                                </div>
                                <div class="hnv_cart_item_total_include">
                                    {$core->get_Lang('All taxes and fees included')}
                                </div>
                                {if isset($item.price_deposit) && $item.price_deposit > 0}
                                    <div class="hnv_cart_item_action_item d-sm-block d-md-none">
                                        <label>
                                            {$core->get_Lang('Deposit')} {if $item.deposit}{$item.deposit}{else}0{/if}
                                            % ({$clsISO->getShortRate()}{$clsISO->formatPrice($item.price_deposit)})
                                        </label>
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}
    {/foreach}
    {assign var=row_traveler value=0}
{/if}
