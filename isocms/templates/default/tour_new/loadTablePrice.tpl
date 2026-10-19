{if $deviceType ne 'phone'}
    <form class="form_booking_now booking_services booking_price_services_now {if $has_parent_id}form_booking_package{/if}" action="" method="post">
        <div class="iso_title_form">
            {$core->get_Lang('Get Instant Confirmation')}
        </div>
        {if empty($exceeded_seat)}
            {if !empty($total_price)}
                {assign var=total_price_promotion_z value=$total_price_promotion|number_format:0:".":","}
                <div class="box__price_table table_detail_booking" 1>
                    {if $clsISO->getRealIP() == '124.158.4.434'}
                        {$core->getBlock('2025_loadTablePrice')}
                    {else}
                        <div class="box__price--header d-flex">
                            <div class="box_left">
                                <h4 class="text_bold mt0 iso_mb">{$clsTour->getTitle($tour_id)}</h4>
                                {if $title_seat}
                                    <p class="mb0 title_seat">{$title_seat}</p>
                                {else}
                                    <p class="color_1fb69a mb0">{$core->get_Lang('Still enough spaces left for you')}</p>
                                {/if}
                            </div>
                            {*
                            {if $_LANG_ID eq 'vn'}
                                <div class="box_right">
                                    <p class="color_666 text_bold iso_mb">{$core->get_Lang('Total Price')}</p>
                                    <div class="price">
                                        {if $promotion}
                                            <del class="mgr05">{$total_price|number_format:0:".":","} {$clsISO->getShortRate()}</del>
                                        {/if}
                                        <span class="size28 color_fb1111 text_bold">{$total_price_promotion_z} <span
                                                    class="size20">{$clsISO->getShortRate()}</span></span>
                                    </div>
                                </div>
                            {else}
                                <div class="box_right">
                                    <p class="color_666 text_bold iso_mb">{$core->get_Lang('Total Price')}</p>
                                    <div class="price">
                                        {if $promotion}
                                            <del class="mgr05"> {$clsISO->getShortRate()}{$total_price|number_format:0:".":","}</del>
                                        {/if}
                                        <span class="size28 color_fb1111 text_bold">{$clsISO->getShortRate()}{$total_price_promotion_z} </span>
                                    </div>
                                </div>
                            {/if}
                            *}
                        </div>
                        <div class="box_avaiable_detail d-flex">
                            {if !$has_parent_id}
                            <div class="box_left">
                                <p class="text_bold iso_mb">{$core->get_Lang('Service tiers')}:</p>
                                <select class="select--tour__class" name="tour__class" id="tour__class">
                                    {section name=i loop=$lstOption}
                                        <option value="{$lstOption[i]}" {if $tour_class_id eq $lstOption[i]} selected="selected" {/if}>{$clsTourOption->getTitle($lstOption[i])}</option>
                                    {/section}
                                </select>
                            </div>
                            {/if}
                            {if $_LANG_ID eq 'vn'}
                                <div class="box_right ">
                                    <p class="text_bold iso_mb">{$core->get_Lang('Price detail 1')}</p>
                                    <ul class="list_style_none list_detail_price">
                                        <li>
                                            <span class="w_240 text_left">{$number_adults} {$core->get_Lang('Adults')}</span>
                                            <span class="w_120 text_right">x {$price_adults|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                            <span class="price text_right">{$total_price_adults|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                        </li>
                                        {if $number_child}
                                            <li class="flex-wrap">
                                                <div class="d-flex justify-content-between w-100 mb-2 collapseHead collapsed"
                                                     {if $arr_price_child|count gt 0}data-bs-toggle="collapse"
                                                     data-bs-target="#collapseChild" aria-expanded="false"
                                                     aria-controls="collapseChild"{/if}>
                                                    <span class="w_240 text_left">{$number_child} {$core->get_Lang('Children')}</span>
                                                    {if $check_contact_child eq 0 && $total_price_child ne 0}
                                                        <span class="w_120 text_right">{if $arr_price_child|count gt 0}
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            {/if}</span>
                                                        <span class="price text_right">{$total_price_child|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                    {else}
                                                        <span class="w_120 text_right">{if $arr_price_child|count gt 0}
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            {/if}</span>
                                                        <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                    {/if}
                                                </div>
                                                <div class="w-100 mt10 collapse" id="collapseChild">
                                                    {section name=i loop=$arr_price_child}
                                                        <div class="d-flex justify-content-between w-100 mb-2">
                                                        <span class="w_240 text_left"
                                                              style="padding-left:15px">{$arr_price_child[i].number} ({$arr_price_child[i].text})</span>
                                                            {if $arr_price_child[i].price gt 0}
                                                                <span class="w_120 text_right">x {$arr_price_child[i].price|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                                <span class="price text_right">{$arr_price_child[i].total_price|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                            {else}
                                                                <span class="w_120 text_right"></span>
                                                                <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                            {/if}
                                                        </div>
                                                    {/section}
                                                </div>
                                            </li>
                                        {/if}
                                        {if $number_infants}
                                            <li class="flex-wrap">
                                                <div class="d-flex justify-content-between w-100 mb-2 collapseHead collapsed"
                                                     {if $arr_price_infant|count gt 0}data-bs-toggle="collapse"
                                                     data-bs-target="#collapseInfant" aria-expanded="false"
                                                     aria-controls="collapseInfant"{/if}>
                                                    <span class="w_240 text_left">{$number_infants} {$core->get_Lang('Infants')}</span>
                                                    {if $check_contact_infant eq 0 && $total_price_infants ne 0}
                                                        <span class="w_120 text_right">{if $arr_price_infant|count gt 0}
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            {/if}</span>
                                                        <span class="price text_right">{$total_price_infants|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                    {else}
                                                        <span class="w_120 text_right">{if $arr_price_infant|count gt 0}
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            {/if}</span>
                                                        <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                    {/if}
                                                </div>
                                                <div class="w-100 mt10 collapse" id="collapseInfant">
                                                    {section name=i loop=$arr_price_infant}
                                                        <div class="d-flex justify-content-between w-100 mb-2">
                                                        <span class="w_240 text_left"
                                                              style="padding-left:15px">{$arr_price_infant[i].number} ({$arr_price_infant[i].text})</span>
                                                            {if $arr_price_infant[i].price gt 0}
                                                                <span class="w_120 text_right">x {$arr_price_infant[i].price|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                                <span class="price text_right">{$arr_price_infant[i].total_price|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                            {else}
                                                                <span class="w_120 text_right"></span>
                                                                <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                            {/if}
                                                        </div>
                                                    {/section}
                                                </div>
                                            </li>
                                        {/if}
                                        {if $promotion}
                                            {if $discount_type eq '2'}
                                                <li class="promotion color_1fb69a "><span
                                                            class="w_240 text_left">{$core->get_Lang('Promotion')}</span>
                                                    <span class="w_120 text_right">-{$promotion}%</span> <span
                                                            class="price text_right">-{$price_promotion|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                </li>
                                            {else}
                                                <li class="promotion color_1fb69a "><span
                                                            class="w_240 text_left">{$core->get_Lang('Promotion')}</span>
                                                    <span class="w_120 text_right">-{$promotion|number_format:0:".":","}  {$clsISO->getShortRate()}</span>
                                                    <span class="price text_right">-{$price_promotion|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                </li>
                                            {/if}
                                        {/if}
                                    </ul>
                                    {*
                                    <ul class="list_style_none list_detail_price">
                                        <li class="total_price">
									<span class="total size20">
										{$core->get_Lang('Grand total')}:
									</span>
                                            <span class="price text_right size20 color_fb1111 text_bold">
										<span id="grand_total"
                                              grand_total="{$total_price_promotion}">{$total_price_promotion_z}</span> <span
                                                        class="size18"> {$clsISO->getShortRate()}</span>
									</span>
                                        </li>
                                    </ul>
                                    *}
                                </div>
                            {else}
                                <div class="box_right">
                                    <p class="text_bold iso_mb">{$core->get_Lang('Price detail 2')}</p>
                                    <ul class="list_style_none list_detail_price">
                                        <li>
                                            <span class="w_240 text_left">{$number_adults} {$core->get_Lang('Adults')}</span>
                                            <span class="w_120 text_right">x {$clsISO->getShortRate()}{$price_adults|number_format:0:".":","}</span>
                                            <span class="price text_right">{$clsISO->getShortRate()}{$total_price_adults|number_format:0:".":","}</span>
                                        </li>
                                        {if $number_child}
                                            <li class="flex-wrap">
                                                <div class="d-flex justify-content-between w-100 mb-2 collapseHead collapsed"
                                                     {if $arr_price_child|count gt 0}data-bs-toggle="collapse"
                                                     data-bs-target="#collapseChild" aria-expanded="false"
                                                     aria-controls="collapseChild"{/if}>
                                                    <span class="w_240 text_left">{$number_child} {$core->get_Lang('Children')}</span>
                                                    
                                                    {if $check_contact_child eq 0 && $total_price_child ne 0}
                                                        <span class="w_120 text_right">{if $arr_price_child|count gt 0}
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            {/if}</span>
                                                        <span class="price text_right">{$clsISO->getShortRate()}{$total_price_child|number_format:0:".":","}</span>
                                                    {else}
                                                        <span class="w_120 text_right">{if $arr_price_child|count gt 0}
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            {/if}</span>
                                                        <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                    {/if}
                                                </div>
                                                <div class="w-100 mt10 collapse" id="collapseChild">
                                                    {section name=i loop=$arr_price_child}
                                                        <div class="d-flex justify-content-between w-100 mb-2">
                                                        <span class="w_240 text_left"
                                                              style="padding-left:15px">{$arr_price_child[i].number} ({$arr_price_child[i].text})</span>
                                                            {if $arr_price_child[i].price gt 0}
                                                                <span class="w_120 text_right">x {$clsISO->getShortRate()}{$arr_price_child[i].price|number_format:0:".":","}</span>
                                                                <span class="price text_right">{$clsISO->getShortRate()}{$arr_price_child[i].total_price|number_format:0:".":","}</span>
                                                            {else}
                                                                <span class="w_120 text_right"></span>
                                                                <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                            {/if}
                                                        </div>
                                                    {/section}
                                                </div>
                                            </li>
                                        {/if}
                                        {if $number_infants}
                                            <li class="flex-wrap">
                                                <div class="d-flex justify-content-between w-100 mb-2 collapseHead collapsed"
                                                     {if $arr_price_infant|count gt 0}data-bs-toggle="collapse"
                                                     data-bs-target="#collapseInfant" aria-expanded="false"
                                                     aria-controls="collapseInfant"{/if}>
                                                    <span class="w_240 text_left">{$number_infants} {$core->get_Lang('Infants')}</span>
                                                    {if $check_contact_infant eq 0 && $total_price_infants ne 0}
                                                        <span class="w_120 text_right">{if $arr_price_infant|count gt 0}
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            {/if}</span>
                                                        <span class="price text_right">{$clsISO->getShortRate()}{$total_price_infants|number_format:0:".":","}</span>
                                                    {else}
                                                        <span class="w_120 text_right">{if $arr_price_infant|count gt 0}
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            {/if}</span>
                                                        <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                    {/if}
                                                </div>
                                                <div class="w-100 mt10 collapse" id="collapseInfant">
                                                    {section name=i loop=$arr_price_infant}
                                                        <div class="d-flex justify-content-between w-100 mb-2">
                                                        <span class="w_240 text_left"
                                                              style="padding-left:15px">{$arr_price_infant[i].number} ({$arr_price_infant[i].text})</span>
                                                            {if $arr_price_infant[i].price gt 0}
                                                                <span class="w_120 text_right">x {$clsISO->getShortRate()}{$arr_price_infant[i].price|number_format:0:".":","}</span>
                                                                <span class="price text_right">{$clsISO->getShortRate()}{$arr_price_infant[i].total_price|number_format:0:".":","}</span>
                                                            {else}
                                                                <span class="w_120 text_right"></span>
                                                                <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                            {/if}
                                                        </div>
                                                    {/section}
                                                </div>
                                            </li>
                                        {/if}
                                        {if $promotion}
                                            {if $discount_type eq '2'}
                                                <li class="promotion color_1fb69a "><span
                                                            class="w_240 text_left">{$core->get_Lang('Promotion')}</span>
                                                    <span class="w_120 text_right">-{$promotion}%</span> <span
                                                            class="price text_right">-{$clsISO->getShortRate()}{$price_promotion|number_format:0:".":","}</span>
                                                </li>
                                            {else}
                                                <li class="promotion color_1fb69a "><span
                                                            class="w_240 text_left">{$core->get_Lang('Promotion')}</span>
                                                    <span class="w_120 text_right">-{$clsISO->getShortRate()}{$promotion|number_format:0:".":","}</span>
                                                    <span class="price text_right">-{$clsISO->getShortRate()}{$price_promotion|number_format:0:".":","}</span>
                                                </li>
                                            {/if}
                                        {/if}
                                    </ul>
                                    <ul class="list_style_none list_detail_price">
                                        <li class="total_price">
                                        <span class="total size20">
                                            {$core->get_Lang('Grand total')}:
                                        </span>
                                        <span class="price text_right size20 color_fb1111 text_bold">
										    <span id="grand_total" grand_total="{$total_price_promotion}">{$clsISO->getShortRate()}{$total_price_promotion_z}</span>
									    </span>
                                        </li>
                                    </ul>
                                </div>
                            {/if}
                        </div>
                    {/if}
                </div>
                {if !$has_parent_id}
                    {if $lstService}
                        <div class="addon__box">
                            <p class="text_bold iso_mb">{$core->get_Lang('Addon services')}:</p>
                            <p class="size14 color_666 iso_mb">{$core->get_Lang('Addon prices will be recalculated when you click Book now')}</p>
                            <ul class="addon__list list_style_none">
                                {section name=i loop=$lstService}
                                    {assign var=addonservice_id value=$lstService[i].addonservice_id}
                                    {assign var=price value=$clsAddOnService->getPrice($addonservice_id)}
                                    <li class="item d-flex">
                                        <div class="addon__details">
                                            <p class="text_bold iso_mb5">{$clsAddOnService->getTitle($addonservice_id)}</p>
                                            <div class="size14 color_666 intro_addon">{$clsAddOnService->getIntro($addonservice_id)|strip_tags}</div>
                                        </div>
                                        <div class="addon__select d-flex">
                                            <div class="box__left">
                                                {if $price}
                                                    {if $_LANG_ID eq 'vn'}
                                                        <p class="color_1fb69a size18 text_bold iso_mb5">+ {$price} <span
                                                                    class="size14 text-lowercase">{$clsISO->getShortRate()}</span>
                                                        </p>
                                                    {else}
                                                        <p class="color_1fb69a size18 text_bold iso_mb5">+ <span
                                                                    class="size14 text-lowercase">{$clsISO->getShortRate()}</span>{$price}
                                                        </p>
                                                    {/if}
                                                {else}
                                                    <p class="free iso_mb5">-100%</p>
                                                {/if}
                                                <p class="color_666 size14 hidden-xs iso_mb5">{$clsAddOnService->getNameExtra($addonservice_id)}</p>
                                            </div>
                                            <div class="box__right addon__select_val">
                                                <select class="select_addon"
                                                        name="number_addon[{$addonservice_id}]" id="">
                                                    {section name=ik start=0 loop=21}
                                                        <option value="{$smarty.section.ik.index}">{$smarty.section.ik.index}</option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                {/section}
                            </ul>
                        </div>
                    {/if}
                {/if}
                <div class="box__booking">
                    <input type="hidden" name="tour_id_z" value="{$tour_id}"/>
                    <input type="hidden" name="discount_type" value="{$discount_type}"/>
                    <input type="hidden" name="promotion_z" id="promotion_z" value="{$promotion}"/>
                    <input type="hidden" name="price_promotion" value="{$price_promotion}"/>
                    <input type="hidden" name="number_adults_z" id="number_adults_z" value="{$number_adults}"/>
                    <input type="hidden" name="number_child_z" id="number_child_z" value="{$number_child}"/>
                    <input type="hidden" name="number_infants_z" id="number_infants_z" value="{$number_infants}"/>
                    <input type="hidden" name="price_adults_z" id="price_adults_z" value="{$price_adults}"/>
                    <input type="hidden" name="price_child_z" id="price_child_z" value="{$price_child}"/>
                    <input type="hidden" name="str_price_child" id="str_price_child" value='{$str_price_child}'/>
                    <input type="hidden" name="str_price_infant" id="str_price_infant" value='{$str_price_infant}'/>
                    <input type="hidden" name="price_infants_z" id="price_infants_z" value="{$price_infants}"/>
                    <input type="hidden" name="total_price_adults" id="total_price_adults"  value="{$total_price_adults}"/>
                    <input type="hidden" name="total_price_child" id="total_price_child" value="{$total_price_child}"/>
                    <input type="hidden" name="total_price_infants" id="total_price_infants" value="{$total_price_infants}"/>
                    <input type="hidden" name="check_in_book_z" id="check_in_book_z" value="{$check_in_book}"/>
                    <input type="hidden" name="deposit" id="deposit" value="{$deposit}"/>
                    <input type="hidden" name="price_deposit" id="price_deposit" value="{$price_deposit}"/>
                    <input type="hidden" name="total_price_z" id="total_price_z" value="{$total_price_promotion}"/>
                    <input type="hidden" name="total_addon" id="total_addon" value="{$total_addon_z|default:0}"/>
                    <input type="hidden" name="parent_id" value="{$parent_id|default:0}"/>
                    {if $check_contact}
                        <input type="hidden" name="ContactTour" id="ContactTour" value="ContactTour"/>
                        <button class="contact_now btn_yellow btn_main">
                            {$core->get_Lang("Contact")}
                        </button>
                    {else}
                        {if $price_deposit > 0}
                            <div class="hnv_cart_item_action_item d-none d-sm-none d-md-block me-auto ms-3">
                                <label>
                                    {$core->get_Lang('Deposit')} {if $deposit}{$deposit}{else}0{/if}% ({$clsISO->getShortRate()}{$clsISO->formatPrice($price_deposit)})
                                </label>
                            </div>
                        {/if}
                        <ul class="list_style_none list_detail_price price_total_detail">
                            {if $_LANG_ID eq 'vn'}
                                <li class="total_price">
									<span class="total">
										{$core->get_Lang('Grand total')}:
									</span>
                                    <span class="price">
									    <span id="grand_total" grand_total="{$total_price_promotion}">{$total_price_promotion_z}</span> 
                                        <span class="size18"> {$clsISO->getShortRate()}</span>
									</span>
                                </li>
                            {else}
                                <li class="total_price">
									<span class="total">
										{$core->get_Lang('Grand total')}:
									</span>
                                    <span class="price">
                                        <span class="size18"> {$clsISO->getShortRate()}</span>
										<span id="grand_total" grand_total="{$total_price_promotion}">{$total_price_promotion_z}</span>
									</span>
                                </li>
                            {/if}
                        </ul>
                        <input type="hidden" name="BookingTour" id="BookingTour" value="BookingTour"/>
                        <button class="book_now_tour btn_yellow btn_main">
                            {$core->get_Lang("Book now")}
                        </button>
                    {/if}
                </div>
            {else}
                <div class="box__price_table" 2>
                    <div class="box__price--header d-flex">
                        <div class="box_left">
                            <h4 class="text_bold mt0">{$clsTour->getTitle($tour_id)}</h4>
                            {if $title_seat}
                                <p class="mb0 title_seat">{$title_seat}</p>
                            {else}
                                <p class="color_1fb69a mb0">{$core->get_Lang('Contact us for more information')}</p>
                            {/if}
                        </div>
                        <div class="box_right">
                            <input type="hidden" name="tour_id_z" value="{$tour_id}"/>
                            <input type="hidden" name="promotion_z" id="promotion_z" value="{$promotion}"/>
                            <input type="hidden" name="price_promotion" value="{$price_promotion}"/>
                            <input type="hidden" name="number_adults_z" id="number_adults_z" value="{$number_adults}"/>
                            <input type="hidden" name="number_child_z" id="number_child_z" value="{$number_child}"/>
                            <input type="hidden" name="number_infants_z" id="number_infants_z"  value="{$number_infants}"/>
                            <input type="hidden" name="price_adults_z" id="price_adults_z" value="{$price_adults}"/>
                            <input type="hidden" name="price_child_z" id="price_child_z" value="{$price_child}"/>
                            <input type="hidden" name="price_infants_z" id="price_infants_z" value="{$price_infants}"/>
                            <input type="hidden" name="total_price_adults" id="total_price_adults"  value="{$total_price_adults}"/>
                            <input type="hidden" name="total_price_child" id="total_price_child"  value="{$total_price_child}"/>
                            <input type="hidden" name="total_price_infants" id="total_price_infants"  value="{$total_price_infants}"/>
                            <input type="hidden" name="check_in_book_z" id="check_in_book_z" value="{$check_in_book}"/>
                            <input type="hidden" name="deposit" id="deposit" value="{$deposit}"/>
                            <input type="hidden" name="price_deposit" id="price_deposit" value="{$price_deposit}"/>
                            <input type="hidden" name="total_price_z" id="total_price_z" value="{$total_price_promotion}"/>
                            <input type="hidden" name="ContactTour" id="ContactTour" value="ContactTour"/>
                            <button class="contact_now btn_yellow btn_main">
                                {$core->get_Lang("Contact")}
                            </button>
                        </div>
                    </div>
                    <div class="box_avaiable_detail d-flex">
                        {if !$has_parent_id}
                        <div class="box_left">
                            <p class="text_bold">{$core->get_Lang('Select Travel Style')}:</p>
                            <select class="select--tour__class" name="tour__class" id="tour__class">
                                {section name=i loop=$lstOption}
                                    <option value="{$lstOption[i]}" {if $tour_class_id eq $lstOption[i]} selected="selected" {/if}>{$clsTourOption->getTitle($lstOption[i])}</option>
                                {/section}
                            </select>
                        </div>
                        {/if}
                        <div class="box_right">
                            <p class="text_bold">{$core->get_Lang('Price detail 3')}</p>
                            <ul class="list_style_none list_detail_price">
                                <li><span class="w_120">{$number_adults} {$core->get_Lang('Adults')}</span></li>
                                {if $number_child}
                                    <li><span class="w_120">{$number_child} {$core->get_Lang('Children')}</span></li>
                                {/if}
                                {if $number_infants}
                                    <li><span class="w_120">{$number_infants} {$core->get_Lang('Infants')}</span></li>
                                {/if}
                                {if $promotion && $price_promotion}
                                    <li class="promotion color_1fb69a hidden"><span
                                                class="w_120">{$core->get_Lang('Promotion')}</span> <span class="w_120">-{$promotion}%</span>
                                        <span class="price text_right">-{$price_promotion|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                    </li>
                                {/if}
                            </ul>
                        </div>
                    </div>
                    <div class="box_avaiable_detail d-flex hidden">
                        <div class="notice">
                            <p>{$core->get_Lang('The system is updating. please contact')} <a
                                        href="{$clsISO->getLink('contact')}"
                                        target="_blank">{$core->get_Lang('here')}</a>
                                <br>{$core->get_Lang('Hotline')} <a
                                        href="tel:{$clsConfiguration->getValue('CompanyHotline')}"
                                        title="{$clsConfiguration->getValue('CompanyHotline')}"
                                        class="">{$clsConfiguration->getValue('CompanyHotline')}</a>
                            </p>
                        </div>
                    </div>
                </div>
            {/if}
        {else}
            {if !empty($total_price)}
                <div class="box__price_table" 3>
                    <div class="box__price--header d-flex">
                        <div class="box_left">
                            <h4 class="text_bold mt0">{$clsTour->getTitle($tour_id)}</h4>
                            {if $title_seat}
                                <p class="mb0 title_seat">{$title_seat}</p>
                            {/if}
                        </div>
                        <div class="box_right">
                            <p class="color_666 text_bold mb0">{$core->get_Lang('Total Price')}</p>
                            <div class="price">
                                {if $promotion}
                                    <del class="mgr05">{$total_price|number_format:0:".":","} {$clsISO->getShortRate()}</del>
                                {/if}
                                <span class="size28 color_fb1111 text_bold">{$total_price_promotion|number_format:0:".":","} <span
                                            class="size20">{$clsISO->getShortRate()}</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="box_avaiable_detail d-flex">
                        <div class="notice">
                            <p>{$core->get_Lang('The number of people exceeded the number of seats left. Please')} <a
                                        class="repick_travellers">{$core->get_Lang('choose again')}</a> {$core->get_Lang('person number or contact')}
                                <a class="trigger_contact" href="javascript:void(0);">{$core->get_Lang('here')}</a>
                                <br>{$core->get_Lang('Hotline')} <a
                                        href="tel:{$clsConfiguration->getValue('CompanyHotline')}"
                                        title="{$clsConfiguration->getValue('CompanyHotline')}"
                                        class="">{$clsConfiguration->getValue('CompanyHotline')}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="box__booking hidden">
                    <input type="hidden" name="tour_id_z" value="{$tour_id}"/>
                    <input type="hidden" name="promotion_z" id="promotion_z" value="{$promotion}"/>
                    <input type="hidden" name="price_promotion" value="{$price_promotion}"/>
                    <input type="hidden" name="number_adults_z" id="number_adults_z" value="{$number_adults}"/>
                    <input type="hidden" name="number_child_z" id="number_child_z" value="{$number_child}"/>
                    <input type="hidden" name="number_infants_z" id="number_infants_z" value="{$number_infants}"/>
                    <input type="hidden" name="price_adults_z" id="price_adults_z" value="{$price_adults}"/>
                    <input type="hidden" name="price_child_z" id="price_child_z" value="{$price_child}"/>
                    <input type="hidden" name="price_infants_z" id="price_infants_z" value="{$price_infants}"/>
                    <input type="hidden" name="total_price_adults" id="total_price_adults"
                           value="{$total_price_adults}"/>
                    <input type="hidden" name="total_price_child" id="total_price_child" value="{$total_price_child}"/>
                    <input type="hidden" name="total_price_infants" id="total_price_infants"
                           value="{$total_price_infants}"/>
                    <input type="hidden" name="check_in_book_z" id="check_in_book_z" value="{$check_in_book}"/>
                    <input type="hidden" name="deposit" id="deposit" value="{$deposit}"/>
                    <input type="hidden" name="price_deposit" id="price_deposit" value="{$price_deposit}"/>
                    <input type="hidden" name="total_price_z" id="total_price_z" value="{$total_price_promotion}"/>
                    <input type="hidden" name="ContactTour" id="ContactTour" value="ContactTour"/>
                    <button class="contact_now btn_yellow btn_main">
                        {$core->get_Lang("Contact")}
                    </button>
                </div>
            {else}
                <div class="box__price_table" 4>
                    <div class="box__price--header d-flex">
                        <div class="box_left">
                            <h4 class="text_bold mt0">{$clsTour->getTitle($tour_id)}</h4>
                            {if $title_seat}
                                <p class="mb0 title_seat">{$title_seat}</p>
                            {/if}
                        </div>
                        <div class="box_right">
                            <p class="color_666 text_bold mb0">{$core->get_Lang('Total Price')}</p>
                            <div class="price">

                                <span class="size24 color_fb1111 text_bold">{$core->get_Lang('Updating')}</span>
                            </div>
                        </div>
                    </div>
                    <div class="box_avaiable_detail d-flex">
                        <div class="notice">
                            <p>{$core->get_Lang('The number of people exceeded the number of seats left. Please')} <a
                                        class="repick_travellers">{$core->get_Lang('choose again')}</a> {$core->get_Lang('person number or contact')}
                                <a class="trigger_contact" href="javascript:void(0);">{$core->get_Lang('here')}</a>
                                <br>{$core->get_Lang('Hotline')} <a
                                        href="tel:{$clsConfiguration->getValue('CompanyHotline')}"
                                        title="{$clsConfiguration->getValue('CompanyHotline')}"
                                        class="">{$clsConfiguration->getValue('CompanyHotline')}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="box__booking hidden">
                    <input type="hidden" name="tour_id_z" value="{$tour_id}"/>
                    <input type="hidden" name="promotion_z" id="promotion_z" value="{$promotion}"/>
                    <input type="hidden" name="price_promotion" value="{$price_promotion}"/>
                    <input type="hidden" name="number_adults_z" id="number_adults_z" value="{$number_adults}"/>
                    <input type="hidden" name="number_child_z" id="number_child_z" value="{$number_child}"/>
                    <input type="hidden" name="number_infants_z" id="number_infants_z" value="{$number_infants}"/>
                    <input type="hidden" name="price_adults_z" id="price_adults_z" value="{$price_adults}"/>
                    <input type="hidden" name="price_child_z" id="price_child_z" value="{$price_child}"/>
                    <input type="hidden" name="price_infants_z" id="price_infants_z" value="{$price_infants}"/>
                    <input type="hidden" name="total_price_adults" id="total_price_adults"
                           value="{$total_price_adults}"/>
                    <input type="hidden" name="total_price_child" id="total_price_child" value="{$total_price_child}"/>
                    <input type="hidden" name="total_price_infants" id="total_price_infants"
                           value="{$total_price_infants}"/>
                    <input type="hidden" name="check_in_book_z" id="check_in_book_z" value="{$check_in_book}"/>
                    <input type="hidden" name="deposit" id="deposit" value="{$deposit}"/>
                    <input type="hidden" name="price_deposit" id="price_deposit" value="{$price_deposit}"/>
                    <input type="hidden" name="total_price_z" id="total_price_z" value="{$total_price_promotion}"/>
                    <input type="hidden" name="ContactTour" id="ContactTour" value="ContactTour"/>
                    <button class="contact_now btn_yellow btn_main">
                        {$core->get_Lang("Contact")}
                    </button>
                </div>
            {/if}
        {/if}
    </form>
{else}
    <form class="form_booking_now booking_services" action="" method="post">
        <div class="iso_title_form">
            {$core->get_Lang('Get Instant Confirmation')}
        </div>
        {if empty($exceeded_seat)}
            {if !empty($total_price)}
                {assign var=total_price_promotion_z value=$total_price_promotion|number_format:0:".":","}
                <div class="box__price_table" 1>
                    <div class="box_price_date_departure">
                        <div class="txt_day_departure_date">
                            <div class="txt_date_day">
                                <p>{$now_next_departure_day}</p>
                            </div>
                            <div class="month_departure_date">
                                <p>{$now_next_departure_date}</p>
                            </div>
                        </div>
                        <div class="arrow_between_dates">
                            <div class="arrow_circle">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        <div class="txt_day_end_date">
                            <div class="txt_date_day">
                                <p>{$now_next_end_day}</p>
                            </div>
                            <div class="month_end_date">
                                <p>{$now_next_end_date}</p>
                            </div>
                        </div>
                    </div>

                    <div class="box_avaiable_detail d-flex">
                        <div class="box_left">
                            <p class="text_bold">{$core->get_Lang('Select Travel Style')}:</p>
                            <select class="select--tour__class" name="tour__class" id="tour__class">
                                {section name=i loop=$lstOption}
                                    <option value="{$lstOption[i]}" {if $tour_class_id eq $lstOption[i]} selected="selected" {/if}>{$clsTourOption->getTitle($lstOption[i])}</option>
                                {/section}
                            </select>
                        </div>

                        {if $_LANG_ID eq 'vn'}
                            <div class="box_right">
                                {*<p class="text_bold">{$core->get_Lang('Price detail')}</p>*}
                                <div class="list_style_none list_detail_price">
                                    <li>
                                        <span class="text_left">{$number_adults} {$core->get_Lang('Adults')}</span>
                                        <span class="price text_right">{$clsISO->getShortRate()}{$total_price_adults|number_format:0:".":","}</span>
                                    </li>
                                    {if $number_child}
                                        <li class="flex-wrap">
                                            <div class="d-flex justify-content-between w-100 mb-2" style="justify-content: space-between">
                                                <span class="text_left">{$number_child} {$core->get_Lang('Children')}</span>
                                                {if $check_contact_child eq 0 && $total_price_child ne 0}
                                                    <span class="price text_right">{$clsISO->getShortRate()}{$total_price_child|number_format:0:".":","}</span>
                                                {else}
                                                    <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                {/if}
                                            </div>
                                        </li>
                                    {/if}

                                    {if $number_infants}
                                        <li class="flex-wrap">
                                            <div class="d-flex justify-content-between w-100 mb-2" style="justify-content: space-between">
                                                <span class="text_left">{$number_infants} {$core->get_Lang('Infants')}</span>
                                                {if $check_contact_infant eq 0 && $total_price_infants ne 0}
                                                    <span class="price text_right">{$clsISO->getShortRate()}{$total_price_infants|number_format:0:".":","}</span>
                                                {else}
                                                    <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                {/if}
                                            </div>
                                        </li>
                                    {/if}

                                    {if $promotion}
                                        {if $discount_type eq '2'}
                                            <li class="promotion color_1fb69a "><span
                                                        class="w_240 text_left">{$core->get_Lang('Promotion')}</span>
                                                <span class="w_120 text_right">-{$promotion}%</span> <span
                                                        class="price text_right">-{$clsISO->getShortRate()}{$price_promotion|number_format:0:".":","}</span>
                                            </li>
                                        {else}
                                            <li class="promotion color_1fb69a "><span
                                                        class="w_240 text_left">{$core->get_Lang('Promotion')}</span>
                                                <span class="w_120 text_right">-{$clsISO->getShortRate()}{$promotion|number_format:0:".":","}</span>
                                                <span class="price text_right">-{$clsISO->getShortRate()}{$price_promotion|number_format:0:".":","}</span>
                                            </li>
                                        {/if}
                                    {/if}
                                </div>

                                <div class="button_detail_price">
                                    <div class="price_btn_detail" id="btn_services">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading_price">
                                                <button class="accordion_btn_services" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#services_btn"
                                                        aria-expanded="true" aria-controls="services_btn">
                                                    {$core->get_Lang('Price detail 4')}
                                                </button>
                                            </h2>
                                            <div id="services_btn" class="accordion-collapse collapse"
                                                 aria-labelledby="heading_price" data-bs-parent="#btn_services">
                                                <div class="accordion-body">
                                                    <div class="list_price_detail_accordion">
                                                        <div class="list_style_none list_detail_price">
                                                            <li>
                                                                <span class="w_240 text_left">{$number_adults} {$core->get_Lang('Adults')}</span>
                                                                <span class="w_120 text_right">x {$price_adults|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                                <span class="price text_right">{$total_price_adults|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                            </li>
                                                            {if $number_child}
                                                                <li class="flex-wrap">
                                                                    <div class="d-flex justify-content-between w-100 mb-2 collapseHead collapsed"
                                                                         {if $arr_price_child|count gt 0}data-bs-toggle="collapse"
                                                                         data-bs-target="#collapseChild"
                                                                         aria-expanded="false"
                                                                         aria-controls="collapseChild"{/if}
                                                                         style="justify-content: space-between">
                                                                            <span class="text_left">{$number_child} {$core->get_Lang('Children')} {if $arr_price_child|count gt 0}
                                                                                    <i class="fa fa-angle-down"
                                                                                       aria-hidden="true"></i>
                                                                                {/if}
                                                                            </span>
                                                                        {if $check_contact_child eq 0 && $total_price_child ne 0}
                                                                            <span class="price text_right">{$clsISO->getShortRate()}{$total_price_child|number_format:0:".":","} </span>
                                                                        {else}
                                                                            <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                                        {/if}
                                                                    </div>
                                                                    <div class="w-100 collapse"
                                                                         id="collapseChild">
                                                                        {section name=i loop=$arr_price_child}
                                                                            <div class="d-flex justify-content-between w-100 mb-2">
                                                                                <span class="w_240 text_left">{$arr_price_child[i].number} ({$arr_price_child[i].text})</span>
                                                                                {if $arr_price_child[i].price gt 0}
                                                                                    <span class="w_120 text_right">x {$clsISO->getShortRate()}{$arr_price_child[i].price|number_format:0:".":","}</span>
                                                                                    <span class="price text_right">{$clsISO->getShortRate()}{$arr_price_child[i].total_price|number_format:0:".":","}</span>
                                                                                {else}
                                                                                    <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                                                {/if}
                                                                            </div>
                                                                        {/section}
                                                                    </div>
                                                                </li>
                                                            {/if}

                                                            {if $number_infants}
                                                                <li class="flex-wrap">
                                                                    <div class="d-flex justify-content-between w-100 mb-2 collapseHead collapsed"
                                                                         {if $arr_price_infant|count gt 0}data-bs-toggle="collapse"
                                                                         data-bs-target="#collapseInfant"
                                                                         aria-expanded="false"
                                                                         aria-controls="collapseInfant"{/if}
                                                                         style="justify-content: space-between">
                                                                            <span class="w_240 text_left">{$number_infants} {$core->get_Lang('Infants')}
                                                                                {if $arr_price_infant|count gt 0}
                                                                                    <i class="fa fa-angle-down"
                                                                                       aria-hidden="true"></i>
                                                                                {/if}
                                                                            </span>
                                                                        {if $check_contact_infant eq 0 && $total_price_infants ne 0}
                                                                            <span class="price text_right">{$clsISO->getShortRate()}{$total_price_infants|number_format:0:".":","} </span>
                                                                        {else}
                                                                            <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                                        {/if}
                                                                    </div>
                                                                    <div class="w-100 collapse"
                                                                         id="collapseInfant">
                                                                        {section name=i loop=$arr_price_infant}
                                                                            <div class="d-flex justify-content-between w-100 mb-2">
                                                                                <span class="w_240 text_left">{$arr_price_infant[i].number} ({$arr_price_infant[i].text})</span>
                                                                                {if $arr_price_infant[i].price gt 0}
                                                                                    <span class="w_120 text_right">x {$arr_price_infant[i].price|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                                                    <span class="price text_right">{$arr_price_infant[i].total_price|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                                                {else}
                                                                                    <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                                                {/if}
                                                                            </div>
                                                                        {/section}
                                                                    </div>
                                                                </li>
                                                            {/if}

                                                            {if $promotion}
                                                                {if $discount_type eq '2'}
                                                                    <li class="promotion color_1fb69a "><span
                                                                                class="w_240 text_left">{$core->get_Lang('Promotion')}</span>
                                                                        <span class="w_120 text_right">-{$promotion}%</span>
                                                                        <span
                                                                                class="price text_right">-{$price_promotion|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                                    </li>
                                                                {else}
                                                                    <li class="promotion color_1fb69a "><span
                                                                                class="w_240 text_left">{$core->get_Lang('Promotion')}</span>
                                                                        <span class="w_120 text_right">-{$promotion|number_format:0:".":","}  {$clsISO->getShortRate()}</span>
                                                                        <span class="price text_right">-{$price_promotion|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                                    </li>
                                                                {/if}
                                                            {/if}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        {else}
                            <div class="box_right">
                                {*<p class="text_bold">{$core->get_Lang('Price detail')}</p>*}
                                <div class="list_style_none list_detail_price">
                                    <li>
                                        <span class="text_left">{$number_adults} {$core->get_Lang('Adults')}</span>
                                        <span class="price text_right">{$clsISO->getShortRate()}{$total_price_adults|number_format:0:".":","}</span>
                                    </li>
                                    {if $number_child}
                                        <li class="flex-wrap">
                                            <div class="d-flex justify-content-between w-100 mb-2" style="justify-content: space-between">
                                                <span class="text_left">{$number_child} {$core->get_Lang('Children')}</span>
                                                {if $check_contact_child eq 0 && $total_price_child ne 0}
                                                    <span class="price text_right">{$clsISO->getShortRate()}{$total_price_child|number_format:0:".":","}</span>
                                                {else}
                                                    <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                {/if}
                                            </div>
                                        </li>
                                    {/if}

                                    {if $number_infants}
                                        <li class="flex-wrap">
                                            <div class="d-flex justify-content-between w-100 mb-2" style="justify-content: space-between">
                                                <span class="text_left">{$number_infants} {$core->get_Lang('Infants')}</span>
                                                {if $check_contact_infant eq 0 && $total_price_infants ne 0}
                                                    <span class="price text_right">{$clsISO->getShortRate()}{$total_price_infants|number_format:0:".":","}</span>
                                                {else}
                                                    <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                {/if}
                                            </div>
                                        </li>
                                    {/if}

                                    {if $promotion}
                                        {if $discount_type eq '2'}
                                            <li class="promotion color_1fb69a "><span
                                                        class="w_240 text_left">{$core->get_Lang('Promotion')}</span>
                                                <span class="w_120 text_right">-{$promotion}%</span> <span
                                                        class="price text_right">-{$clsISO->getShortRate()}{$price_promotion|number_format:0:".":","}</span>
                                            </li>
                                        {else}
                                            <li class="promotion color_1fb69a "><span
                                                        class="w_240 text_left">{$core->get_Lang('Promotion')}</span>
                                                <span class="w_120 text_right">-{$promotion|number_format:0:".":","}  {$clsISO->getShortRate()}</span>
                                                <span class="price text_right">-{$clsISO->getShortRate()}{$price_promotion|number_format:0:".":","}</span>
                                            </li>
                                        {/if}
                                    {/if}
                                </div>

                                <div class="button_detail_price">
                                    <div class="price_btn_detail" id="btn_services">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading_price">
                                                <button class="accordion_btn_services" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#services_btn"
                                                        aria-expanded="true" aria-controls="services_btn">
                                                    {$core->get_Lang('Price detail 5')}
                                                </button>
                                            </h2>
                                            <div id="services_btn" class="accordion-collapse collapse"
                                                 aria-labelledby="heading_price" data-bs-parent="#btn_services">
                                                <div class="accordion-body">
                                                    <div class="list_price_detail_accordion">
                                                        <div class="list_style_none list_detail_price">
                                                            <li>
                                                                <span class="w_240 text_left">{$number_adults} {$core->get_Lang('Adults')}</span>
                                                                <span class="w_120 text_right">x {$clsISO->getShortRate()}{$price_adults|number_format:0:".":","} </span>
                                                                <span class="price text_right">{$clsISO->getShortRate()}{$total_price_adults|number_format:0:".":","} </span>
                                                            </li>
                                                            {if $number_child}
                                                                <li class="flex-wrap">
                                                                    <div class="d-flex justify-content-between w-100 mb-2 collapseHead collapsed"
                                                                         {if $arr_price_child|count gt 0}data-bs-toggle="collapse"
                                                                         data-bs-target="#collapseChild"
                                                                         aria-expanded="false"
                                                                         aria-controls="collapseChild"{/if}
                                                                         style="justify-content: space-between">
                                                                            <span class="text_left">{$number_child} {$core->get_Lang('Children')} {if $arr_price_child|count gt 0}
                                                                                    <i class="fa fa-angle-down"
                                                                                       aria-hidden="true"></i>
                                                                                {/if}
                                                                            </span>
                                                                        {if $check_contact_child eq 0 && $total_price_child ne 0}
                                                                            <span class="price text_right">{$clsISO->getShortRate()}{$total_price_child|number_format:0:".":","} </span>
                                                                        {else}
                                                                            <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                                        {/if}
                                                                    </div>
                                                                    <div class="w-100 collapse"
                                                                         id="collapseChild">
                                                                        {section name=i loop=$arr_price_child}
                                                                            <div class="d-flex justify-content-between w-100 mb-2">
                                                                                <span class="w_240 text_left">{$arr_price_child[i].number} ({$arr_price_child[i].text})</span>
                                                                                {if $arr_price_child[i].price gt 0}
                                                                                    <span class="w_120 text_right">x {$clsISO->getShortRate()}{$arr_price_child[i].price|number_format:0:".":","}</span>
                                                                                    <span class="price text_right">{$clsISO->getShortRate()}{$arr_price_child[i].total_price|number_format:0:".":","}</span>
                                                                                {else}
                                                                                    <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                                                {/if}
                                                                            </div>
                                                                        {/section}
                                                                    </div>
                                                                </li>
                                                            {/if}

                                                            {if $number_infants}
                                                                <li class="flex-wrap">
                                                                    <div class="d-flex justify-content-between w-100 mb-2 collapseHead collapsed"
                                                                         {if $arr_price_infant|count gt 0}data-bs-toggle="collapse"
                                                                         data-bs-target="#collapseInfant"
                                                                         aria-expanded="false"
                                                                         aria-controls="collapseInfant"{/if}
                                                                         style="justify-content: space-between">
                                                                            <span class="w_240 text_left">{$number_infants} {$core->get_Lang('Infants')}
                                                                                {if $arr_price_infant|count gt 0}
                                                                                    <i class="fa fa-angle-down"
                                                                                       aria-hidden="true"></i>
                                                                                {/if}
                                                                            </span>
                                                                        {if $check_contact_infant eq 0 && $total_price_infants ne 0}
                                                                            <span class="price text_right">{$clsISO->getShortRate()}{$total_price_infants|number_format:0:".":","} </span>
                                                                        {else}
                                                                            <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                                        {/if}
                                                                    </div>
                                                                    <div class="w-100 collapse"
                                                                         id="collapseInfant">
                                                                        {section name=i loop=$arr_price_infant}
                                                                            <div class="d-flex justify-content-between w-100 mb-2">
                                                                                <span class="w_240 text_left">{$arr_price_infant[i].number} ({$arr_price_infant[i].text})</span>
                                                                                {if $arr_price_infant[i].price gt 0}
                                                                                    <span class="w_120 text_right">x {$clsISO->getShortRate()}{$arr_price_infant[i].price|number_format:0:".":","}</span>
                                                                                    <span class="price text_right">{$clsISO->getShortRate()}{$arr_price_infant[i].total_price|number_format:0:".":","}</span>
                                                                                {else}
                                                                                    <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                                                {/if}
                                                                            </div>
                                                                        {/section}
                                                                    </div>
                                                                </li>
                                                            {/if}

                                                            {if $promotion}
                                                                {if $discount_type eq '2'}
                                                                    <li class="promotion color_1fb69a ">
                                                                        <span
                                                                                class="w_240 text_left">{$core->get_Lang('Promotion')}
                                                                        </span>
                                                                        <span class="w_120 text_right">-{$promotion}%</span>
                                                                        <span class="price text_right">-{$clsISO->getShortRate()}{$price_promotion|number_format:0:".":","}
                                                                        </span>
                                                                    </li>
                                                                {else}
                                                                    <li class="promotion color_1fb69a ">
                                                                        <span class="w_240 text_left">{$core->get_Lang('Promotion')}
                                                                        </span>
                                                                        <span class="w_120 text_right">-{$clsISO->getShortRate()}{$promotion|number_format:0:".":","}
                                                                        </span>
                                                                        <span class="price text_right">-{$clsISO->getShortRate()}{$price_promotion|number_format:0:".":","}
                                                                        </span>
                                                                    </li>
                                                                {/if}
                                                            {/if}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
{*                                <ul class="list_style_none list_detail_price">*}
{*                                    <li class="total_price">*}
{*									<span class="total size20">*}
{*										{$core->get_Lang('Grand total')}:*}
{*									</span>*}
{*                                        <span class="price text_right size20 color_fb1111 text_bold">*}
{*										<span id="grand_total"*}
{*                                              grand_total="{$total_price_promotion}">{$total_price_promotion_z}</span> <span*}
{*                                                    class="size18"> {$clsISO->getShortRate()}</span>*}
{*									</span>*}
{*                                    </li>*}
{*                                </ul>*}
                            </div>
                        {/if}
                    </div>

                </div>
                {if $lstService}
                    <div class="accordion" id="addonAccordion">
                        <div class="accordion-item accordion_addon_services">
                            <h2 class="accordion-header" id="headingAddon">
                                <button class="accordion-button accordion_addon_button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseAddon" aria-expanded="false"
                                        aria-controls="collapseAddon">
                                    <p class="text_bold iso_mb size16 txt_addon_serivices">
                                        {$core->get_Lang('Addon services')}
                                    </p>
                                </button>
                            </h2>
                            <div id="collapseAddon" class="accordion-collapse collapse" aria-labelledby="headingAddon"
                                 data-bs-parent="#addonAccordion">
                                <div class="accordion-body collapse_addon_services">
                                    <div class="addon__box addon-services-container">
                                        <ul class="addon__list list_style_none list_addon_style">
                                            {section name=i loop=$lstService}
                                                {assign var=addonservice_id value=$lstService[i].addonservice_id}
                                                {assign var=price value=$clsAddOnService->getPrice($addonservice_id)}
                                                <li class="item d-flex">
                                                    <div class="addon__details">
                                                        <p class="text_bold iso_mb5">{$clsAddOnService->getTitle($addonservice_id)}</p>
                                                        <div class="intro_addon">{$clsAddOnService->getIntro($addonservice_id)|strip_tags}</div>
                                                    </div>
                                                    <div class="addon__select d-flex">
                                                        <div class="box__left">
                                                            {if $price}
                                                                {if $_LANG_ID eq 'vn'}
                                                                    <p class="txt_price_addon_box">+{$price}
                                                                        <span class="size14 text-lowercase">{$clsISO->getShortRate()}</span>
                                                                    </p>
                                                                    {*                                                                    <p class="txt_traveler_per">{$core->get_Lang('per Traveler')}</p>*}
                                                                {else}
                                                                    <p class="size14 text-lowercase"> {$clsISO->getShortRate()}
                                                                        <span class="txt_price_addon_box">+{$price}</span>

                                                                    </p>
                                                                    {*                                                                    <p class="txt_traveler_per">{$core->get_Lang('per Traveler')}</p>*}
                                                                {/if}
                                                            {else}
                                                                <p class="free iso_mb5">-100%</p>
                                                            {/if}
                                                            <p class="txt_traveler_per">{$clsAddOnService->getNameExtra($addonservice_id)}</p>
                                                        </div>
                                                        <div class="box__right addon__select_val">
                                                            <select class="select_addon"
                                                                   
                                                                    name="number_addon[{$addonservice_id}]" id="">
                                                                {section name=ik start=0 loop=21}
                                                                    <option value="{$smarty.section.ik.index}">{$smarty.section.ik.index}</option>
                                                                {/section}
                                                            </select>
                                                        </div>
                                                    </div>
                                                </li>
                                            {/section}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}

                <div class="box__booking">
                    <input type="hidden" name="tour_id_z" value="{$tour_id}"/>
                    <input type="hidden" name="discount_type" value="{$discount_type}"/>
                    <input type="hidden" name="promotion_z" id="promotion_z" value="{$promotion}"/>
                    <input type="hidden" name="price_promotion" value="{$price_promotion}"/>
                    <input type="hidden" name="number_adults_z" id="number_adults_z" value="{$number_adults}"/>
                    <input type="hidden" name="number_child_z" id="number_child_z" value="{$number_child}"/>
                    <input type="hidden" name="number_infants_z" id="number_infants_z" value="{$number_infants}"/>
                    <input type="hidden" name="price_adults_z" id="price_adults_z" value="{$price_adults}"/>
                    <input type="hidden" name="price_child_z" id="price_child_z" value="{$price_child}"/>
                    <input type="hidden" name="str_price_child" id="str_price_child" value='{$str_price_child}'/>
                    <input type="hidden" name="str_price_infant" id="str_price_infant" value='{$str_price_infant}'/>
                    <input type="hidden" name="price_infants_z" id="price_infants_z" value="{$price_infants}"/>
                    <input type="hidden" name="total_price_adults" id="total_price_adults"
                           value="{$total_price_adults}"/>
                    <input type="hidden" name="total_price_child" id="total_price_child" value="{$total_price_child}"/>
                    <input type="hidden" name="total_price_infants" id="total_price_infants"
                           value="{$total_price_infants}"/>
                    <input type="hidden" name="check_in_book_z" id="check_in_book_z" value="{$check_in_book}"/>
                    <input type="hidden" name="deposit" id="deposit" value="{$deposit}"/>
                    <input type="hidden" name="price_deposit" id="price_deposit" value="{$price_deposit}"/>
                    <input type="hidden" name="total_price_z" id="total_price_z" value="{$total_price_promotion}"/>
                    <input type="hidden" name="total_addon" id="total_addon" value="{$total_addon_z|default:0}"/>
                    {if $check_contact}
                        <input type="hidden" name="ContactTour" id="ContactTour" value="ContactTour"/>
                        <button class="contact_now btn_yellow btn_main">
                            {$core->get_Lang("Contact")}
                        </button>
                    {else}
                        <div class="box_right box_price_grand_total">
                        {if $_LANG_ID eq 'vn'}
									<span class="color_666 text_bold iso_mb">
										{$core->get_Lang('Grand total')}:
									</span>
                                    <span class="price">
										<span id="grand_total"
                                              grand_total="{$total_price_promotion}" class="size28 text_bold txt_price_bold">{$total_price_promotion_z}</span> <span
                                                class="size18"> {$clsISO->getShortRate()}</span>
									</span>
                            {else}
									<span class="color_666 text_bold iso_mb">
										{$core->get_Lang('Grand total')}:
									</span>
                                    <div class="price">
                                    <span class="size18"> {$clsISO->getShortRate()}
                                    </span>
										<span id="grand_total" grand_total="{$total_price_promotion}" class="size28 text_bold txt_price_bold">{$total_price_promotion_z}</span>
									</div>
                            {/if}
                        </div>

                        <input type="hidden" name="BookingTour" id="BookingTour" value="BookingTour"/>
                        <button class="book_now_tour btn_yellow btn_main">
                            {$core->get_Lang("Book now")}
                        </button>
                    {/if}
                </div>
            {else}
                <div class="box__price_table" 2>
                    <div class="box__price--header d-flex">
                        <div class="box_left">
                            <h4 class="text_bold mt0">{$clsTour->getTitle($tour_id)}</h4>
                            {if $title_seat}
                                <p class="mb0 title_seat">{$title_seat}</p>
                            {else}
                                <p class="color_1fb69a mb0">{$core->get_Lang('Contact us for more information')}</p>
                            {/if}

                        </div>
                        <div class="box_right">
                            <input type="hidden" name="tour_id_z" value="{$tour_id}"/>
                            <input type="hidden" name="promotion_z" id="promotion_z" value="{$promotion}"/>
                            <input type="hidden" name="price_promotion" value="{$price_promotion}"/>
                            <input type="hidden" name="number_adults_z" id="number_adults_z" value="{$number_adults}"/>
                            <input type="hidden" name="number_child_z" id="number_child_z" value="{$number_child}"/>
                            <input type="hidden" name="number_infants_z" id="number_infants_z"
                                   value="{$number_infants}"/>
                            <input type="hidden" name="price_adults_z" id="price_adults_z" value="{$price_adults}"/>
                            <input type="hidden" name="price_child_z" id="price_child_z" value="{$price_child}"/>
                            <input type="hidden" name="price_infants_z" id="price_infants_z" value="{$price_infants}"/>
                            <input type="hidden" name="total_price_adults" id="total_price_adults"
                                   value="{$total_price_adults}"/>
                            <input type="hidden" name="total_price_child" id="total_price_child"
                                   value="{$total_price_child}"/>
                            <input type="hidden" name="total_price_infants" id="total_price_infants"
                                   value="{$total_price_infants}"/>
                            <input type="hidden" name="check_in_book_z" id="check_in_book_z" value="{$check_in_book}"/>
                            <input type="hidden" name="deposit" id="deposit" value="{$deposit}"/>
                            <input type="hidden" name="price_deposit" id="price_deposit" value="{$price_deposit}"/>
                            <input type="hidden" name="total_price_z" id="total_price_z"
                                   value="{$total_price_promotion}"/>
                            <input type="hidden" name="ContactTour" id="ContactTour" value="ContactTour"/>
                            <button class="contact_now btn_yellow btn_main">
                                {$core->get_Lang("Contact")}
                            </button>
                        </div>
                    </div>
                    <div class="box_avaiable_detail d-flex">
                        <div class="box_left">
                            <p class="text_bold">{$core->get_Lang('Select Travel Style')}:</p>
                            <select class="select--tour__class" name="tour__class" id="tour__class">
                                {section name=i loop=$lstOption}
                                    <option value="{$lstOption[i]}" {if $tour_class_id eq $lstOption[i]} selected="selected" {/if}>{$clsTourOption->getTitle($lstOption[i])}</option>
                                {/section}
                            </select>

                        </div>
                        <div class="box_right">
                            <p class="text_bold">{$core->get_Lang('Price detail 6')}</p>
                            <ul class="list_style_none list_detail_price">
                                <li><span class="w_120">{$number_adults} {$core->get_Lang('Adults')}</span></li>
                                {if $number_child}
                                    <li><span class="w_120">{$number_child} {$core->get_Lang('Children')}</span></li>
                                {/if}
                                {if $number_infants}
                                    <li><span class="w_120">{$number_infants} {$core->get_Lang('Infants')}</span></li>
                                {/if}
                                {if $promotion && $price_promotion}
                                    <li class="promotion color_1fb69a hidden"><span
                                                class="w_120">{$core->get_Lang('Promotion')}</span> <span class="w_120">-{$promotion}%</span>
                                        <span class="price text_right">-{$price_promotion|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                    </li>
                                {/if}
                            </ul>
                        </div>
                    </div>
                    <div class="box_avaiable_detail d-flex hidden">
                        <div class="notice">
                            <p>{$core->get_Lang('The system is updating. please contact')} <a
                                        href="{$clsISO->getLink('contact')}"
                                        target="_blank">{$core->get_Lang('here')}</a>
                                <br>{$core->get_Lang('Hotline')} <a
                                        href="tel:{$clsConfiguration->getValue('CompanyHotline')}"
                                        title="{$clsConfiguration->getValue('CompanyHotline')}"
                                        class="">{$clsConfiguration->getValue('CompanyHotline')}</a>
                            </p>
                        </div>
                    </div>
                </div>
            {/if}
        {else}
            {if !empty($total_price)}
                <div class="box__price_table" 3>
                    <div class="box__price--header d-flex">
                        <div class="box_left">
                            <h4 class="text_bold mt0">{$clsTour->getTitle($tour_id)}</h4>
                            {if $title_seat}
                                <p class="mb0 title_seat">{$title_seat}</p>
                            {/if}
                        </div>
                        <div class="box_right">
                            <p class="color_666 text_bold mb0">{$core->get_Lang('Total Price')}</p>
                            <div class="price">
                                {if $promotion}
                                    <del class="mgr05">{$total_price|number_format:0:".":","} {$clsISO->getShortRate()}</del>
                                {/if}
                                <span class="size28 color_fb1111 text_bold">{$total_price_promotion|number_format:0:".":","} <span
                                            class="size20">{$clsISO->getShortRate()}</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="box_avaiable_detail d-flex">
                        <div class="notice">
                            <p>{$core->get_Lang('The number of people exceeded the number of seats left. Please')} <a
                                        class="repick_travellers">{$core->get_Lang('choose again')}</a> {$core->get_Lang('person number or contact')}
                                <a class="trigger_contact" href="javascript:void(0);">{$core->get_Lang('here')}</a>
                                <br>{$core->get_Lang('Hotline')} <a
                                        href="tel:{$clsConfiguration->getValue('CompanyHotline')}"
                                        title="{$clsConfiguration->getValue('CompanyHotline')}"
                                        class="">{$clsConfiguration->getValue('CompanyHotline')}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="box__booking hidden">
                    <input type="hidden" name="tour_id_z" value="{$tour_id}"/>
                    <input type="hidden" name="promotion_z" id="promotion_z" value="{$promotion}"/>
                    <input type="hidden" name="price_promotion" value="{$price_promotion}"/>
                    <input type="hidden" name="number_adults_z" id="number_adults_z" value="{$number_adults}"/>
                    <input type="hidden" name="number_child_z" id="number_child_z" value="{$number_child}"/>
                    <input type="hidden" name="number_infants_z" id="number_infants_z" value="{$number_infants}"/>
                    <input type="hidden" name="price_adults_z" id="price_adults_z" value="{$price_adults}"/>
                    <input type="hidden" name="price_child_z" id="price_child_z" value="{$price_child}"/>
                    <input type="hidden" name="price_infants_z" id="price_infants_z" value="{$price_infants}"/>
                    <input type="hidden" name="total_price_adults" id="total_price_adults"
                           value="{$total_price_adults}"/>
                    <input type="hidden" name="total_price_child" id="total_price_child" value="{$total_price_child}"/>
                    <input type="hidden" name="total_price_infants" id="total_price_infants"
                           value="{$total_price_infants}"/>
                    <input type="hidden" name="check_in_book_z" id="check_in_book_z" value="{$check_in_book}"/>
                    <input type="hidden" name="deposit" id="deposit" value="{$deposit}"/>
                    <input type="hidden" name="price_deposit" id="price_deposit" value="{$price_deposit}"/>
                    <input type="hidden" name="total_price_z" id="total_price_z" value="{$total_price_promotion}"/>
                    <input type="hidden" name="ContactTour" id="ContactTour" value="ContactTour"/>
                    <button class="contact_now btn_yellow btn_main">
                        {$core->get_Lang("Contact")}
                    </button>
                </div>
            {else}
                <div class="box__price_table" 4>
                    <div class="box__price--header d-flex">
                        <div class="box_left">
                            <h4 class="text_bold mt0">{$clsTour->getTitle($tour_id)}</h4>
                            {if $title_seat}
                                <p class="mb0 title_seat">{$title_seat}</p>
                            {/if}
                        </div>
                        <div class="box_right">
                            <p class="color_666 text_bold mb0">{$core->get_Lang('Total Price')}</p>
                            <div class="price">

                                <span class="size24 color_fb1111 text_bold">{$core->get_Lang('Updating')}</span>
                            </div>
                        </div>
                    </div>
                    <div class="box_avaiable_detail d-flex">
                        <div class="notice">
                            <p>{$core->get_Lang('The number of people exceeded the number of seats left. Please')} <a
                                        class="repick_travellers">{$core->get_Lang('choose again')}</a> {$core->get_Lang('person number or contact')}
                                <a class="trigger_contact" href="javascript:void(0);">{$core->get_Lang('here')}</a>
                                <br>{$core->get_Lang('Hotline')} <a
                                        href="tel:{$clsConfiguration->getValue('CompanyHotline')}"
                                        title="{$clsConfiguration->getValue('CompanyHotline')}"
                                        class="">{$clsConfiguration->getValue('CompanyHotline')}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="box__booking hidden">
                    <input type="hidden" name="tour_id_z" value="{$tour_id}"/>
                    <input type="hidden" name="promotion_z" id="promotion_z" value="{$promotion}"/>
                    <input type="hidden" name="price_promotion" value="{$price_promotion}"/>
                    <input type="hidden" name="number_adults_z" id="number_adults_z" value="{$number_adults}"/>
                    <input type="hidden" name="number_child_z" id="number_child_z" value="{$number_child}"/>
                    <input type="hidden" name="number_infants_z" id="number_infants_z" value="{$number_infants}"/>
                    <input type="hidden" name="price_adults_z" id="price_adults_z" value="{$price_adults}"/>
                    <input type="hidden" name="price_child_z" id="price_child_z" value="{$price_child}"/>
                    <input type="hidden" name="price_infants_z" id="price_infants_z" value="{$price_infants}"/>
                    <input type="hidden" name="total_price_adults" id="total_price_adults"
                           value="{$total_price_adults}"/>
                    <input type="hidden" name="total_price_child" id="total_price_child" value="{$total_price_child}"/>
                    <input type="hidden" name="total_price_infants" id="total_price_infants"
                           value="{$total_price_infants}"/>
                    <input type="hidden" name="check_in_book_z" id="check_in_book_z" value="{$check_in_book}"/>
                    <input type="hidden" name="deposit" id="deposit" value="{$deposit}"/>
                    <input type="hidden" name="price_deposit" id="price_deposit" value="{$price_deposit}"/>
                    <input type="hidden" name="total_price_z" id="total_price_z" value="{$total_price_promotion}"/>
                    <input type="hidden" name="ContactTour" id="ContactTour" value="ContactTour"/>
                    <button class="contact_now btn_yellow btn_main">
                        {$core->get_Lang("Contact")}
                    </button>
                </div>
            {/if}
        {/if}
    </form>
{/if}
{literal}
<script>
(function ($) {
    'use strict';

    /*
     * Gỡ toàn bộ handler change đã gắn trực tiếp bằng jQuery
     * trên select addon trong nội dung vừa load.
     */
    $('.form_booking_now .select_addon').off('change');

    /*
     * Gỡ các delegated handler có namespace từng thêm trước đó.
     */
    $(document).off(
        'change.tourAddonPrice',
        '.select_addon'
    );

    $(document).off(
        'change.tourAddonPrice',
        '#TablePrice .select_addon'
    );

    $(document).off(
        'change.tourAddonPrice',
        '#TablePrice select[name^="number_addon["]'
    );

    $(document).off(
        'change.tourAddonPrice',
        '#TablePrice select[name*="[number_addon]"]'
    );
})(window.jQuery);
</script>
{/literal}