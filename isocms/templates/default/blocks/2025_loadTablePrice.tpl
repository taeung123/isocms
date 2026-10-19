{assign var=total_price_promotion_z value=$total_price_promotion|number_format:0:".":","}
<div class="row">
    <div class="box_price_table_detail">
        <div class="box_price_detail_table">
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
            <div class="box_avaiable_detail d-flex box_tour_avaiable_detail">
                {if !$has_parent_id}
                <div class="box_left">
                    <p class="text_bold mb_booking_tour">{$core->get_Lang('Select Travel Style')}
                    </p>
                    <select class="select--tour__class" name="tour__class" id="tour__class">
                        {section name=i loop=$lstOption}
                            <option value="{$lstOption[i]}" {if $tour_class_id eq $lstOption[i]} selected="selected" {/if}>{$clsTourOption->getTitle($lstOption[i])}</option>
                        {/section}
                    </select>
                </div>
                {/if}
                {if $_LANG_ID eq 'vn'}
                    <div class="box_right">
                        <div class="price-detail-wrapper">
                            <p class="text_bold mb_booking_tour">
                                {$core->get_Lang('Price detail')}
                                <i class="fa-regular fa-circle-info icon_circle_info"></i>
                            </p>
                            <div class="tooltip_detail_price_tour" style="display: none;">
                                <div class="price_audit_child">
                                    <span class="text_left">{$number_adults} {$core->get_Lang('Adults')}</span>
                                    <span class="text_right">x {$price_adults|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                </div>

                                {if $number_child}
                                    <div class="price_audit_child">
                                        <div class="price_child_number">
                                            <span class="text_left">{$number_child} {$core->get_Lang('Children')}:</span>
                                            {section name=i loop=$arr_price_child}
                                                {if $arr_price_child[i].price gt 0}
                                                    <span class="price text_right">x {$arr_price_child[i].total_price|number_format:0:".":","} {$clsISO->getShortRate()}
                                                    </span>
                                                {else}
                                                <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                            {/if}
                                            {/section}
                                        </div>
                                    </div>
                                {/if}

                                {if $number_infants}
                                 <div class="price_audit_child">
                                     <span class="text_left">{$number_infants} {$core->get_Lang('Infants')}</span>
                                     {section name=i loop=$arr_price_infant}
                                         {if $arr_price_infant[i].price gt 0}
                                             <span class="price text_right">x {$arr_price_infant[i].price|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                         {else}
                                         <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                     {/if}
                                     {/section}
                                 </div>
                                {/if}
                            </div>
                        </div>
                        <ul class="list_style_none list_detail_price">
                            <li>
                                <span class="text_left">{$number_adults} {$core->get_Lang('Adults')}</span>
                                <span class="price text_right">{$total_price_adults|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                            </li>
                            {if $number_child}
                                <li class="flex-wrap">
                                    <div class="w-100 collapseHead collapsed collapse_child"
                                         {if $arr_price_child|count gt 0}data-bs-toggle="collapse"
                                         data-bs-target="#collapseChild" aria-expanded="false"
                                         aria-controls="collapseChild"{/if}>
                                        <span class="text_left">{$number_child} {$core->get_Lang('Children')} {if $arr_price_child|count gt 0}
                                                <i class="fa fa-angle-down"
                                                   aria-hidden="true"></i>
                                            {/if}
                                        </span>
                                        {if $check_contact_child eq 0 && $total_price_child ne 0}
                                            <span class="price text_right">
                                                {$total_price_child|number_format:0:".":","} {$clsISO->getShortRate()}
                                            </span>
                                        {else}
                                            <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                        {/if}
                                    </div>
                                    <div class="w-100 collapse" id="collapseChild">
                                        {section name=i loop=$arr_price_child}
                                            <div class="collapse_child_price_detail w-100">
                                                <span class="text_left">{$arr_price_child[i].number} ({$arr_price_child[i].text})
                                                </span>
                                                {if $arr_price_child[i].price gt 0}
                                                    <span class="price text_right">{$arr_price_child[i].total_price|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                                {else}
                                                    <span class="text_right"></span>
                                                    <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                {/if}
                                            </div>
                                        {/section}
                                    </div>
                                </li>
                            {/if}
                            {if $number_infants}
                                <li class="flex-wrap">
                                    <div class="collapsed w-100 collapseHead collapsed collapse_child"
                                         {if $arr_price_infant|count gt 0}data-bs-toggle="collapse"
                                         data-bs-target="#collapseInfant" aria-expanded="false"
                                         aria-controls="collapseInfant"{/if}>
                                        <span class="text_left">{$number_infants} {$core->get_Lang('Infants')}
                                            {if $arr_price_infant|count gt 0}
                                                <i class="fa fa-angle-down"
                                                   aria-hidden="true"></i>
                                            {/if}
                                        </span>
                                        {if $check_contact_infant eq 0 && $total_price_infants ne 0}
                                            <span class="price text_right">{$total_price_infants|number_format:0:".":","} {$clsISO->getShortRate()}
                                            </span>
                                        {else}
                                            <span class="text_right">
                                                {if $arr_price_infant|count gt 0}
                                                    <i class="fa fa-angle-down"
                                                       aria-hidden="true"></i>
                                                {/if}
                                            </span>
                                            <span class="price text_right">{$core->get_Lang('Contact')}
                                            </span>
                                        {/if}
                                    </div>
                                    <div class="w-100 collapse" id="collapseInfant">
                                        {section name=i loop=$arr_price_infant}
                                            <div class="collapse_child_price_detail">
                                                        <span class="text_left">{$arr_price_infant[i].number} ({$arr_price_infant[i].text})
                                                        </span>
                                                {if $arr_price_infant[i].price gt 0}
                                                    <span class="text_right">x {$arr_price_infant[i].price|number_format:0:".":","} {$clsISO->getShortRate()}
                                                    </span>
                                                    <span class="price text_right">{$arr_price_infant[i].total_price|number_format:0:".":","} {$clsISO->getShortRate()}
                                                    </span>
                                                {else}
                                                    <span class="w_120 text_right">

                                                    </span>
                                                    <span class="price text_right">{$core->get_Lang('Contact')}
                                                    </span>
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
                        <ul class="list_style_none list_detail_price" id="box__price__addon"></ul>
                    </div>
                {else}
                    <div class="box_right">
                        <div class="price-detail-wrapper">
                            <p class="text_bold mb_booking_tour">
                                {$core->get_Lang('Price detail')}
                                <i class="fa-regular fa-circle-info icon_circle_info"></i>
                            </p>
                            <div class="tooltip_detail_price_tour" style="display: none;">
                                <div class="price_audit_child">
                                    <span class="text_left">{$number_adults} {$core->get_Lang('Adults')}</span>
                                    <span class="text_right">x {$price_adults|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                </div>

                                {if $number_child}
                                    <div class="price_audit_child">
                                        <div class="price_child_number">
                                            <span class="text_left">{$number_child} {$core->get_Lang('Children')}:</span>
                                            {section name=i loop=$arr_price_child}
                                                {if $arr_price_child[i].price gt 0}
                                                    <span class="price text_right">x {$arr_price_child[i].total_price|number_format:0:".":","} {$clsISO->getShortRate()}
                                                    </span>
                                                {else}
                                                    <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                                {/if}
                                            {/section}
                                        </div>
                                    </div>
                                {/if}

                                {if $number_infants}
                                    <div class="price_audit_child">
                                        <span class="text_left">{$number_infants} {$core->get_Lang('Infants')}</span>
                                        {section name=i loop=$arr_price_infant}
                                            {if $arr_price_infant[i].price gt 0}
                                                <span class="price text_right">x {$arr_price_infant[i].price|number_format:0:".":","} {$clsISO->getShortRate()}</span>
                                            {else}
                                                <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                            {/if}
                                        {/section}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <ul class="list_style_none list_detail_price">
                            <li>
                                <span class="text_left">{$number_adults} {$core->get_Lang('Adults')}</span>
                                <span class="price text_right">{$clsISO->getShortRate()}{$total_price_adults|number_format:0:".":","}</span>
                            </li>
                            {if $number_child}
                                <li class="flex-wrap">
                                    <div class="d-flex flex-wrap w-100 collapseHead collapsed"
                                         {if $arr_price_child|count gt 0}data-bs-toggle="collapse"
                                         data-bs-target="#collapseChild" aria-expanded="false"
                                         aria-controls="collapseChild"{/if}>
                                        <span class="w_240 text_left">{$number_child} {$core->get_Lang('Children')}
                                            {if $arr_price_child|count gt 0}
                                                <i class="fa fa-angle-down"
                                                   aria-hidden="true"></i>
                                            {/if}
                                        </span>
                                        {if $check_contact_child eq 0 && $total_price_child ne 0}
                                            <span class="price text_right">{$clsISO->getShortRate()}{$total_price_child|number_format:0:".":","}</span>
                                        {else}
                                            <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                        {/if}
                                    </div>
                                    <div class="w-100 mt10 collapse" id="collapseChild">
                                        {section name=i loop=$arr_price_child}
                                            <div class="d-flex flex-wrap w-100">
                                                        <span class="text_left">{$arr_price_child[i].number} ({$arr_price_child[i].text})</span>
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
                                    <div class="d-flex flex-wrap w-100 collapseHead collapsed"
                                         {if $arr_price_infant|count gt 0}data-bs-toggle="collapse"
                                         data-bs-target="#collapseInfant" aria-expanded="false"
                                         aria-controls="collapseInfant"{/if}>
                                        <span class="w_240 text_left">{$number_infants} {$core->get_Lang('Infants')}</span>
                                        {if $check_contact_infant eq 0 && $total_price_infants ne 0}
                                            <span class="w_120 text_right">{if $arr_price_infant|count gt 0}
                                                    <i class="fa fa-angle-down"
                                                       aria-hidden="true"></i>
                                                {/if}</span>
                                            <span class="price text_right">{$clsISO->getShortRate()}{$total_price_infants|number_format:0:".":","}</span>
                                        {else}
                                            <span class="w_120 text_right">{if $arr_price_infant|count gt 0}
                                                    <i class="fa fa-angle-down"
                                                       aria-hidden="true"></i>
                                                {/if}</span>
                                            <span class="price text_right">{$core->get_Lang('Contact')}</span>
                                        {/if}
                                    </div>
                                    <div class="w-100 mt10 collapse" id="collapseInfant">
                                        {section name=i loop=$arr_price_infant}
                                            <div class="d-flex flex-wrap w-100">
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
                        <ul class="list_style_none list_detail_price" id="box__price__addon"></ul>
                    </div>
                {/if}
            </div>
        </div>
    </div>
    {*
    <div class="col-lg-3 col-md-3 d-none d-md-none d-lg-block">
        <div class="box_price_detail_table_price">
            {if $_LANG_ID eq 'vn'}
                <div class="box_right">
                    <p class="txt_total_price_table">{$core->get_Lang('Total Price')}</p>
                    <div class="price">
                        {if $promotion}
                            <del class="mgr05">{$total_price|number_format:0:".":","} {$clsISO->getShortRate()}</del>
                        {/if}
                        <span class="total_price_booking_services">{$total_price_promotion_z}
                            <span
                                    class="txt_price_unit">{$clsISO->getShortRate()}
                            </span>
                                                </span>
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
        </div>
        <div class="box__booking">
            <input type="hidden" name="tour_id_z" value="{$tour_id}"/>
            <input type="hidden" name="discount_type" value="{$discount_type}"/>
            <input type="hidden" name="promotion_z" id="promotion_z" value="{$promotion}"/>
            <input type="hidden" name="price_promotion" value="{$price_promotion}"/>
            <input type="hidden" name="number_adults_z" id="number_adults_z"
                   value="{$number_adults}"/>
            <input type="hidden" name="number_child_z" id="number_child_z" value="{$number_child}"/>
            <input type="hidden" name="number_infants_z" id="number_infants_z"
                   value="{$number_infants}"/>
            <input type="hidden" name="price_adults_z" id="price_adults_z" value="{$price_adults}"/>
            <input type="hidden" name="price_child_z" id="price_child_z" value="{$price_child}"/>
            <input type="hidden" name="str_price_child" id="str_price_child"
                   value='{$str_price_child}'/>
            <input type="hidden" name="str_price_infant" id="str_price_infant"
                   value='{$str_price_infant}'/>
            <input type="hidden" name="price_infants_z" id="price_infants_z"
                   value="{$price_infants}"/>
            <input type="hidden" name="total_price_adults" id="total_price_adults"
                   value="{$total_price_adults}"/>
            <input type="hidden" name="total_price_child" id="total_price_child"
                   value="{$total_price_child}"/>
            <input type="hidden" name="total_price_infants" id="total_price_infants"
                   value="{$total_price_infants}"/>
            <input type="hidden" name="check_in_book_z" id="check_in_book_z"
                   value="{$check_in_book}"/>
            <input type="hidden" name="deposit" id="deposit" value="{$deposit}"/>
            <input type="hidden" name="price_deposit" id="price_deposit" value="{$price_deposit}"/>
            <input type="hidden" name="total_price_z" id="total_price_z"
                   value="{$total_price_promotion}"/>
            <input type="hidden" name="total_addon" id="total_addon" value="{$total_addon_z}"/>
            {if $check_contact}
                <input type="hidden" name="ContactTour" id="ContactTour" value="ContactTour"/>
                <button class="contact_now btn_yellow btn_main">
                    {$core->get_Lang("Contact")}
                </button>
            {else}
                <input type="hidden" name="BookingTour" id="BookingTour" value="BookingTour"/>
                <button class="book_now_tour btn_yellow btn_main">
                    {$core->get_Lang("Book now")}
                </button>
            {/if}
        </div>
    </div>
    *}
</div>


{literal}
    <script>
        $(document).ready(function () {
            $('.price-detail-wrapper').on('mouseenter', function () {
                $('.tooltip_detail_price_tour').css('display', 'block');
            });

            $('.price-detail-wrapper').on('mouseleave', function () {
                $('.tooltip_detail_price_tour').css('display', 'none');
            });
        });
    </script>
    <style>

        /*.booking_price_services_now .box__booking {*/
        /*    background: unset;*/
        /*    padding: unset;*/
        /*}*/

        /*.booking_price_services_now .box__booking .book_now_tour {*/
        /*    max-width: 100%;*/
        /*}*/

        .booking_price_services_now .box_avaiable_detail .box_left {
            width: 44%;
        }

        .booking_price_services_now .box_price_detail_table_price {
            text-align: end;
        }


        .table_detail_booking .select--tour__class {
            min-width: auto;
            width: 88%;
        }

        .booking_price_services_now .box_avaiable_detail .box_right ul li:first-child {
            padding-top: 12px;
        }

        .booking_price_services_now .box_avaiable_detail .box_right {
            width: 62%;
        }

        .booking_price_services_now .box_price_date_departure {
            margin-bottom: 28px;
        }

        .booking_price_services_now .box_avaiable_detail {
            flex-wrap: unset;
        }

        .table_detail_booking .total_price_booking_services {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 22px;
            font-style: normal;
            font-weight: 700;
            line-height: 26px; /* 144.444% */
        }

        .table_detail_booking .total_price_booking_services .txt_price_unit {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 18px;
            font-style: normal;
            font-weight: 700;
            line-height: 26px; /* 144.444% */
        }

        .table_detail_booking .month_departure_date, .table_detail_booking .month_end_date {
            font-size: 22px;
        }

        .table_detail_booking .txt_total_price_table {
            color: var(--chroma-717171, #717171);
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 21px; /* 150% */
        }

        .table_detail_booking .box_tour_avaiable_detail {
            gap: unset;
        }

        .box_tour_avaiable_detail .box_right ul li {
            border-top: unset;
        }

        .list_detail_price li span.price {
            width: unset;
        }

        .booking_price_services_now .list_detail_price li {
            justify-content: space-between;
        }

        .booking_price_services_now .list_detail_price {
            color: var(--secondary-26456-e, #26456E);
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 24px; /* 150% */
        }

        .price-detail-wrapper {
            position: relative;
        }

        .price_audit_child {
            margin-bottom: 5px; /* Space between items */
        }


        .icon_circle_info {
            margin-left: 5px; /* Space between text and icon */
        }

        .booking_price_services_now .box_price_table_detail {
            position: relative;
            padding-right: 15px;
        }

        /*.booking_price_services_now .box_price_table_detail::after {*/
        /*    content: '';*/
        /*    position: absolute;*/
        /*    top: -30px;*/
        /*    bottom: 0;*/
        /*    right: 0;*/
        /*    width: 1px;*/
        /*    background-color: #DADFE6;*/
        /*}*/

        .price-detail-wrapper .tooltip_detail_price_tour {
            width: 100%;
            max-width: 192px;
            background: white;
            padding: 10px;
            border-radius: 5px;
            filter: drop-shadow(0px 4px 12px rgba(0, 0, 0, 0.20));
            margin-top: 10px;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            font-size: 14px;
        }

        .price-detail-wrapper .tooltip_detail_price_tour::after {
            content: "";
            position: absolute;
            bottom: 100%;
            left: 50%;
            margin-left: -4px;
            border-width: 7px;
            border-style: solid;
            border-color: transparent transparent white transparent;
        }
        
        .price_audit_child {
            color: var(--chroma-717171, #717171);
            text-align: right;
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 18px; /* 150% */
            text-align: left;
            padding: 0 14px 0 14px;
        }

        .price_audit_child:first-child {
            padding: 14px 14px 0 14px;
        }

        .box_avaiable_detail .box_right ul li {
            padding: unset;
        }

        .booking_price_services_now .collapse_child, .booking_price_services_now .collapse_child_price_detail {
            display: flex;
            justify-content: space-between;
        }
    </style>
{/literal}